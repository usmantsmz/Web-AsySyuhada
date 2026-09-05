<?php
/**
 * DOM guard injection.
 *
 * The tag-level passes in Blocker only ever see the HTML WordPress sent, so a
 * tracker that a page builder, lazy-loader or tag manager builds in the browser
 * loads no matter what the visitor chose. This prints a small script at the very
 * top of `<head>` that intercepts the assignment of a URL to a `<script>` or
 * `<iframe>` and parks it in the same `data-surecookie-*` shape the PHP blocker
 * produces, so consentManager.js restores it on accept with no extra plumbing.
 *
 * Injected into the buffer rather than hooked onto `wp_head`, because a theme or
 * plugin can print a tag manager into `<head>` before any hook fires; the only
 * reliable "first" is the top of the finished document.
 *
 * The payload is consent-agnostic (patterns only), so it is safe to serve from a
 * full-page cache. The guard reads the consent cookie itself at runtime.
 *
 * @package SureCookie\Inc\Modules\ScriptBlocking
 * @since   1.4.0
 */

namespace SureCookie\Inc\Modules\ScriptBlocking;

use SureCookie\Inc\Functions\Settings;
use SureCookie\Inc\Traits\GetInstance;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Dom_Guard class.
 *
 * @since 1.4.0
 */
class Dom_Guard {
	use GetInstance;

	/**
	 * Cached guard source, read once per request.
	 *
	 * @var string|null
	 */
	private ?string $source = null;

	/**
	 * Insert the guard at the top of `<head>`.
	 *
	 * @since 1.4.0
	 * @param string $buffer Page HTML.
	 * @return string
	 */
	public function inject( string $buffer ): string {
		/**
		 * Filter whether the client-side DOM guard runs.
		 *
		 * The guard wraps the native `src` accessors, so this is the kill switch
		 * for a site where that conflicts with another plugin.
		 *
		 * @since 1.4.0
		 * @param bool $enabled Whether to inject the guard. Default true.
		 */
		if ( ! apply_filters( 'surecookie_dom_guard_enabled', true ) ) {
			return $buffer;
		}

		$patterns = $this->build_patterns();
		if ( empty( $patterns['s'] ) && empty( $patterns['i'] ) ) {
			return $buffer;
		}

		$source = $this->source();
		if ( $source === '' ) {
			return $buffer;
		}

		// Match the opening <head> tag with its attributes, so the guard lands
		// immediately inside it and ahead of every other tag on the page.
		if ( preg_match( '/<head\b[^>]*>/i', $buffer, $match, PREG_OFFSET_CAPTURE ) !== 1 ) {
			return $buffer;
		}

		$config = wp_json_encode(
			[
				'p' => $patterns['s'],
				'f' => $patterns['i'],
				'e' => array_values( (array) apply_filters( 'surecookie_skippable_categories', [ 'essential' ] ) ),
				'm' => (string) Settings::get( 'consent_model' ),
				'r' => (int) Settings::get( 'consent_renewed_at' ),
				// Core prefixes plus the host they belong to, so the guard spares
				// core exactly as Blocker::is_core_asset() does. The host is sent,
				// not read from `location`: on a domain-mapped install (WPML
				// domain-per-language) the two would disagree about which is ours.
				'c' => array_values( array_map( static fn( array $b ): string => $b[1], Blocker::core_bases() ) ),
				'h' => (string) ( Blocker::core_bases()[0][0] ?? '' ),
			],
			// HEX_TAG keeps a pattern from closing the script tag; slashes stay
			// unescaped because every pattern is a URL fragment and `\/` would
			// add roughly half a kilobyte to every page for nothing.
			JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_SLASHES
		);

		if ( $config === false ) {
			return $buffer;
		}

		// data-cfasync stops Cloudflare Rocket Loader from deferring the guard,
		// which would put it behind the scripts it exists to intercept.
		$tag = '<script data-cfasync="false" data-surecookie-guard="1">'
			. 'window.surecookieGuard=' . $config . ';'
			. $source
			. '</script>';

		$offset = $match[0][1] + strlen( $match[0][0] );

		return substr( $buffer, 0, $offset ) . $tag . substr( $buffer, $offset );
	}

	/**
	 * Flatten the blocking catalog into `pattern => [ category, service ]`, kept
	 * in separate script and iframe maps.
	 *
	 * Reads the same `surecookie_known_scripts` view the tag passes block from,
	 * and applies the same per-resource decisions on top: a resource the admin
	 * excluded is dropped, and a category override wins over the catalog's. Skip
	 * either and the guard would contradict the tag passes - blocking something
	 * the admin allowed, or holding a resource under a category the visitor has
	 * already consented to, which consentManager would then restore and the
	 * guard would immediately park again.
	 *
	 * @since 1.4.0
	 * @return array{s: array<string, array{0: string, 1: string}>, i: array<string, array{0: string, 1: string}>}
	 */
	private function build_patterns(): array {
		$patterns = [
			's' => [],
			'i' => [],
		];

		$catalog = apply_filters( 'surecookie_known_scripts', [] );
		if ( ! is_array( $catalog ) ) {
			return $patterns;
		}

		// Catalog key => the kind Resource_Categories scopes its entries by, and
		// the map the guard consults for that element type.
		$kinds = [
			'scripts' => [ 'script', 's' ],
			'iframes' => [ 'iframe', 'i' ],
		];

		foreach ( $catalog as $category => $services ) {
			if ( ! is_array( $services ) ) {
				continue;
			}

			foreach ( $services as $service_key => $service ) {
				if ( ! is_array( $service ) ) {
					continue;
				}

				// `path` narrows a rule to resources that also contain that
				// fragment. The guard matches on a single substring, so a
				// narrowed rule is skipped rather than over-blocking its host.
				if ( ! empty( $service['path'] ) ) {
					continue;
				}

				foreach ( $kinds as $catalog_key => $kind ) {
					if ( empty( $service[ $catalog_key ] ) || ! is_array( $service[ $catalog_key ] ) ) {
						continue;
					}

					foreach ( $service[ $catalog_key ] as $pattern ) {
						$pattern = (string) $pattern;
						if ( $pattern === '' || Resource_Categories::matches_excluded_src( $pattern, $kind[0] ) ) {
							continue;
						}

						/**
						 * Filter: leave a pattern out of the browser guard's map.
						 *
						 * The guard exists to catch what the server pass cannot see,
						 * so anything the server is going to let through has to be
						 * dropped here too or the two layers disagree - which is how
						 * an always-allowed resource ended up loading in the page and
						 * still being intercepted in the browser. Pro uses this for
						 * its whitelist; the free exclusion is handled above.
						 *
						 * @since x.x.x
						 * @param bool   $skip    Whether to omit this pattern.
						 * @param string $pattern Blocking pattern.
						 * @param string $kind    Resource kind ('script'|'iframe').
						 */
						if ( apply_filters( 'surecookie_guard_skip_pattern', false, $pattern, $kind[0] ) ) {
							continue;
						}

						// The pattern carries the host the override keys match on.
						$patterns[ $kind[1] ][ $pattern ] = [
							Resource_Categories::resolve( $pattern, (string) $category, $kind[0] ),
							(string) $service_key,
						];
					}
				}
			}
		}

		return $patterns;
	}

	/**
	 * The guard's built (minified) source.
	 *
	 * @since 1.4.0
	 * @return string
	 */
	private function source(): string {
		if ( $this->source !== null ) {
			return $this->source;
		}

		$path = SURECOOKIE_DIR . 'build/dom-guard.js';

		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- Reading a bundled plugin asset, not a remote resource.
		$contents = is_readable( $path ) ? file_get_contents( $path ) : false;

		$this->source = is_string( $contents ) ? trim( $contents ) : '';

		return $this->source;
	}
}
