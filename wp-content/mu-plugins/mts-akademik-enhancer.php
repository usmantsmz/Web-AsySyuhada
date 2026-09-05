<?php
/*
Plugin Name: MTs Asy-Syuhada Akademik & Kurikulum Enhancer
Description: Memperbarui bagian Akademik & Kurikulum di Beranda dengan desain institusional modern, 100% Elementor Friendly & Tipografi Outfit + Plus Jakarta Sans.
Version: 1.2.0
Author: MTs Asy-Syuhada Development Team
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Enqueue Web Fonts (Outfit & Plus Jakarta Sans) for High Quality Typography
 */
add_action('wp_enqueue_scripts', function() {
    wp_enqueue_style(
        'mts-akademik-fonts',
        'https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap',
        array(),
        null
    );
});

/**
 * Shortcode [mts_akademik_grid] for Direct Use in Elementor & Page Builders
 */
add_shortcode('mts_akademik_grid', 'mts_render_akademik_grid_html');

function mts_render_akademik_grid_html() {
    $site_url = get_site_url();
    ob_start();
    ?>
    <div id="akademik-kurikulum-wrapper" class="mts-akademik-wrapper-node">
        <section class="mts-akademik-section" id="akademik-kurikulum">
            <div class="mts-akademik-container">
                
                <!-- Header Seksi -->
                <div class="mts-akademik-header">
                    <span class="mts-akademik-badge">AKADEMIK & KURIKULUM</span>
                    <h2 class="mts-akademik-title">Program Unggulan & Kurikulum Terpadu</h2>
                    <p class="mts-akademik-subtitle">MTs Asy-Syuhada mengintegrasikan Kurikulum Nasional (Kurikulum Merdeka), Pendalaman Kitab Kuning Pesantren, Tahfidz Al-Qur'an, dan Penguasaan Teknologi Digital.</p>
                </div>

                <!-- Grid 4 Kartu Program -->
                <div class="mts-akademik-grid">
                    
                    <!-- Card 1: Tahfidz Al-Qur'an & Hadits -->
                    <div class="mts-akademik-card">
                        <div class="mts-akademik-card-top">
                            <span class="mts-akademik-cat-badge kemenag">Unggulan Kemenag</span>
                            <span class="mts-akademik-target">Target 3-5 Juz</span>
                        </div>
                        <div class="mts-akademik-icon-box">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/><line x1="12" y1="6" x2="16" y2="6"/><line x1="12" y1="10" x2="16" y2="10"/></svg>
                        </div>
                        <h3 class="mts-akademik-program-title">Tahfidz Al-Qur'an & Hadits</h3>
                        <p class="mts-akademik-program-desc">Bimbingan hafalan intensif setiap pagi (Ziyadah & Muroja'ah) dengan bimbingan ustadz/ustadzah bersyahadah hafiz 30 Juz.</p>
                        
                        <ul class="mts-akademik-highlights">
                            <li><span class="mts-check">✓</span> Halqah Hafalan Pagi Hari</li>
                            <li><span class="mts-check">✓</span> Ujian Tasmi' Berkelanjutan</li>
                            <li><span class="mts-check">✓</span> Sertifikat Syahadah Tahfidz</li>
                        </ul>
                    </div>

                    <!-- Card 2: Pembelajaran Digital & Sains -->
                    <div class="mts-akademik-card">
                        <div class="mts-akademik-card-top">
                            <span class="mts-akademik-cat-badge sains">Teknologi & STEM</span>
                            <span class="mts-akademik-target">CBT & Coding</span>
                        </div>
                        <div class="mts-akademik-icon-box">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/><polyline points="8 9 10 11 8 13"/><line x1="13" y1="13" x2="16" y2="13"/></svg>
                        </div>
                        <h3 class="mts-akademik-program-title">Pembelajaran Digital & Sains</h3>
                        <p class="mts-akademik-program-desc">Pembelajaran berbasis CBT (Computer Based Test), dasar pemrograman/coding, literasi media digital, serta praktikum laboratorium IPA modern.</p>
                        
                        <ul class="mts-akademik-highlights">
                            <li><span class="mts-check">✓</span> Laboratorium Komputer AC</li>
                            <li><span class="mts-check">✓</span> Akses Portal E-Learning</li>
                            <li><span class="mts-check">✓</span> Pembiasaan Ujian CBT</li>
                        </ul>
                    </div>

                    <!-- Card 3: Program Bahasa Bilingual -->
                    <div class="mts-akademik-card">
                        <div class="mts-akademik-card-top">
                            <span class="mts-akademik-cat-badge bahasa">Komunikasi Global</span>
                            <span class="mts-akademik-target">Arab & Inggris</span>
                        </div>
                        <div class="mts-akademik-icon-box">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                        </div>
                        <h3 class="mts-akademik-program-title">Program Bahasa (Bilingual)</h3>
                        <p class="mts-akademik-program-desc">Pembiasaan percakapan harian (Muhaadatsah & English Speaking), klub debat, serta kelas persiapan bahasa Arab & Inggris internasional.</p>
                        
                        <ul class="mts-akademik-highlights">
                            <li><span class="mts-check">✓</span> Program Yaumul Lughah</li>
                            <li><span class="mts-check">✓</span> Bimbingan Public Speaking</li>
                            <li><span class="mts-check">✓</span> Vocabulary Daily Refresh</li>
                        </ul>
                    </div>

                    <!-- Card 4: Kajian Kitab Kuning -->
                    <div class="mts-akademik-card">
                        <div class="mts-akademik-card-top">
                            <span class="mts-akademik-cat-badge pesantren">Dirasah Islamiyah</span>
                            <span class="mts-akademik-target">Fiqih & Aqidah</span>
                        </div>
                        <div class="mts-akademik-icon-box">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                        </div>
                        <h3 class="mts-akademik-program-title">Kajian Kitab & Dirasah</h3>
                        <p class="mts-akademik-program-desc">Pendalaman kajian keislaman ala pesantren tradisional (Safinatun Najah, Aqidatul Awam, Ta'lim Muta'allim) untuk penguatan fondasi aqidah dan fiqih.</p>
                        
                        <ul class="mts-akademik-highlights">
                            <li><span class="mts-check">✓</span> Metode Sorogan & Bandongan</li>
                            <li><span class="mts-check">✓</span> Praktik Ibadah & Imtihan</li>
                            <li><span class="mts-check">✓</span> Pembentukan Akhlakul Karimah</li>
                        </ul>
                    </div>

                </div>

                <!-- CTA Box Bawah -->
                <div class="mts-akademik-cta-box">
                    <div class="mts-akademik-cta-info">
                        <span class="mts-cta-heading">Kurikulum Merdeka Plus Pesantren</span>
                        <p class="mts-cta-subtext">Ingin mengetahui struktur mata pelajaran, skema kelulusan, dan kalender akademik selengkapnya?</p>
                    </div>
                    <div class="mts-akademik-cta-btns">
                        <a href="<?php echo esc_url($site_url . '/akademik/'); ?>" class="mts-akademik-btn mts-btn-main">
                            <span>Selengkapnya Tentang Kurikulum</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        </a>
                        <a href="https://wa.me/6281234567890" target="_blank" rel="noopener noreferrer" class="mts-akademik-btn mts-btn-sub">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-1.099 4.019 4.142-1.086z"/></svg>
                            <span>Konsultasi Kurikulum</span>
                        </a>
                    </div>
                </div>

            </div>
        </section>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Inject Styles & Scripts into both Frontend and Elementor Preview
 */
add_action('wp_footer', function() {
    ?>
    <style id="mts-akademik-enhanced-css">
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        /* AKADEMIK & KURIKULUM SECTION STYLES */
        .mts-akademik-section {
            background-color: #FFFFFF !important;
            padding: 76px 0 !important;
            font-family: 'Plus Jakarta Sans', 'Inter', system-ui, -apple-system, sans-serif !important;
            border-top: 1px solid #E2E8F0 !important;
            border-bottom: 1px solid #E2E8F0 !important;
            color: #1E293B !important;
            width: 100% !important;
            position: relative !important;
            z-index: 10 !important;
            clear: both !important;
            -webkit-font-smoothing: antialiased !important;
            -moz-osx-font-smoothing: grayscale !important;
        }

        .mts-akademik-section *, .mts-akademik-section *::before, .mts-akademik-section *::after {
            box-sizing: border-box !important;
        }

        .mts-akademik-container {
            max-width: 1200px !important;
            margin: 0 auto !important;
            padding: 0 24px !important;
        }

        /* Header */
        .mts-akademik-header {
            text-align: center !important;
            max-width: 760px !important;
            margin: 0 auto 48px auto !important;
        }

        .mts-akademik-badge {
            display: inline-block !important;
            background-color: rgba(13, 92, 58, 0.08) !important;
            color: #0D5C3A !important;
            border: 1px solid rgba(13, 92, 58, 0.2) !important;
            font-family: 'Outfit', 'Plus Jakarta Sans', sans-serif !important;
            font-size: 11.5px !important;
            font-weight: 700 !important;
            letter-spacing: 1.2px !important;
            text-transform: uppercase !important;
            padding: 4px 14px !important;
            border-radius: 99px !important;
            margin-bottom: 12px !important;
        }

        .mts-akademik-title {
            color: #0F172A !important;
            font-family: 'Outfit', 'Plus Jakarta Sans', sans-serif !important;
            font-size: 32px !important;
            font-weight: 800 !important;
            line-height: 1.3 !important;
            letter-spacing: -0.5px !important;
            margin: 0 0 14px 0 !important;
        }

        .mts-akademik-subtitle {
            color: #64748B !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            font-size: 15px !important;
            font-weight: 400 !important;
            line-height: 1.65 !important;
            margin: 0 !important;
        }

        /* Grid Layout (4 Columns) */
        .mts-akademik-grid {
            display: grid !important;
            grid-template-columns: repeat(4, 1fr) !important;
            gap: 24px !important;
            margin-bottom: 52px !important;
        }

        /* Cards */
        .mts-akademik-card {
            background-color: #F8FAFC !important;
            border: 1px solid #E2E8F0 !important;
            border-radius: 14px !important;
            padding: 24px !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: space-between !important;
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease !important;
            position: relative !important;
        }

        .mts-akademik-card:hover {
            transform: translateY(-4px) !important;
            box-shadow: 0 12px 24px -4px rgba(15, 23, 42, 0.08) !important;
            border-color: rgba(13, 92, 58, 0.4) !important;
            background-color: #FFFFFF !important;
        }

        .mts-akademik-card-top {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            gap: 8px !important;
            margin-bottom: 18px !important;
        }

        .mts-akademik-cat-badge {
            font-family: 'Outfit', 'Plus Jakarta Sans', sans-serif !important;
            font-size: 10.5px !important;
            font-weight: 700 !important;
            padding: 3px 8px !important;
            border-radius: 4px !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
        }

        .mts-akademik-cat-badge.kemenag {
            background-color: #DCFCE7 !important;
            color: #15803D !important;
        }

        .mts-akademik-cat-badge.sains {
            background-color: #DBEAFE !important;
            color: #1D4ED8 !important;
        }

        .mts-akademik-cat-badge.bahasa {
            background-color: #FEF3C7 !important;
            color: #B45309 !important;
        }

        .mts-akademik-cat-badge.pesantren {
            background-color: #F3E8FF !important;
            color: #7E22CE !important;
        }

        .mts-akademik-target {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            font-size: 11px !important;
            color: #64748B !important;
            font-weight: 600 !important;
        }

        .mts-akademik-icon-box {
            width: 48px !important;
            height: 48px !important;
            border-radius: 10px !important;
            background-color: rgba(13, 92, 58, 0.08) !important;
            color: #0D5C3A !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin-bottom: 16px !important;
        }

        .mts-akademik-program-title {
            color: #0F172A !important;
            font-family: 'Outfit', 'Plus Jakarta Sans', sans-serif !important;
            font-size: 17.5px !important;
            font-weight: 700 !important;
            margin: 0 0 10px 0 !important;
            line-height: 1.35 !important;
        }

        .mts-akademik-program-desc {
            color: #475569 !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            font-size: 13px !important;
            font-weight: 400 !important;
            line-height: 1.6 !important;
            margin: 0 0 18px 0 !important;
            flex-grow: 1 !important;
        }

        /* Highlights List */
        .mts-akademik-highlights {
            list-style: none !important;
            padding: 14px 0 0 0 !important;
            margin: 0 !important;
            border-top: 1px dashed #E2E8F0 !important;
            display: flex !important;
            flex-direction: column !important;
            gap: 7px !important;
        }

        .mts-akademik-highlights li {
            color: #334155 !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            font-size: 12.5px !important;
            font-weight: 600 !important;
            display: flex !important;
            align-items: center !important;
            gap: 6px !important;
        }

        .mts-check {
            color: #0D5C3A !important;
            font-weight: 800 !important;
            font-size: 13px !important;
        }

        /* CTA Box */
        .mts-akademik-cta-box {
            background-color: #F1F5F9 !important;
            border: 1px solid #E2E8F0 !important;
            border-radius: 14px !important;
            padding: 24px 32px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            gap: 24px !important;
        }

        .mts-cta-heading {
            display: block !important;
            color: #0F172A !important;
            font-family: 'Outfit', 'Plus Jakarta Sans', sans-serif !important;
            font-size: 17px !important;
            font-weight: 700 !important;
            margin-bottom: 4px !important;
        }

        .mts-cta-subtext {
            color: #64748B !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            font-size: 13.5px !important;
            font-weight: 400 !important;
            margin: 0 !important;
        }

        .mts-akademik-cta-btns {
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
            flex-shrink: 0 !important;
        }

        .mts-akademik-btn {
            display: inline-flex !important;
            align-items: center !important;
            gap: 8px !important;
            padding: 11px 20px !important;
            border-radius: 8px !important;
            font-family: 'Outfit', 'Plus Jakarta Sans', sans-serif !important;
            font-size: 13.5px !important;
            font-weight: 600 !important;
            text-decoration: none !important;
            transition: all 0.2s ease !important;
            white-space: nowrap !important;
        }

        .mts-btn-main {
            background-color: #0D5C3A !important;
            color: #FFFFFF !important;
            border: 1px solid #0D5C3A !important;
        }

        .mts-btn-main:hover {
            background-color: #09472C !important;
            color: #FFFFFF !important;
        }

        .mts-btn-sub {
            background-color: #FFFFFF !important;
            color: #334155 !important;
            border: 1px solid #CBD5E1 !important;
        }

        .mts-btn-sub:hover {
            background-color: #25D366 !important;
            border-color: #25D366 !important;
            color: #FFFFFF !important;
        }

        /* RESPONSIVE DESIGN */
        @media (max-width: 1024px) {
            .mts-akademik-grid {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 20px !important;
            }

            .mts-akademik-cta-box {
                flex-direction: column !important;
                align-items: flex-start !important;
            }

            .mts-akademik-cta-btns {
                width: 100% !important;
            }

            .mts-akademik-btn {
                flex: 1 !important;
                justify-content: center !important;
            }
        }

        @media (max-width: 640px) {
            .mts-akademik-section {
                padding: 48px 0 !important;
            }

            .mts-akademik-grid {
                grid-template-columns: 1fr !important;
                gap: 18px !important;
            }

            .mts-akademik-title {
                font-size: 22px !important;
            }

            .mts-akademik-cta-btns {
                flex-direction: column !important;
            }

            .mts-akademik-btn {
                width: 100% !important;
            }
        }
    </style>

    <script id="mts-akademik-enhancer-js">
    (function() {
        function replaceAkademikSection() {
            // Guard clause: stop if already enhanced
            if (document.getElementById("akademik-kurikulum-wrapper")) {
                return;
            }

            var contentArea = document.querySelector(".site-content, #content, .entry-content, article, .elementor");
            if (!contentArea) contentArea = document.body;

            var allNodes = contentArea.querySelectorAll("h1, h2, h3, h4, h5, h6, .elementor-heading-title, .elementor-widget-heading, div, span, p");
            var targetHeading = null;

            for (var i = 0; i < allNodes.length; i++) {
                var n = allNodes[i];
                if (n.children.length === 0 && n.textContent && n.textContent.trim().toUpperCase().indexOf("AKADEMIK & KURIKULUM") !== -1) {
                    if (n.closest("#akademik-kurikulum-wrapper") || n.closest(".mts-akademik-section")) {
                        continue;
                    }
                    targetHeading = n;
                    break;
                }
            }

            if (!targetHeading) return;

            var sec = targetHeading;
            while (sec && sec !== document.body) {
                if (sec.classList && (sec.classList.contains("elementor-section") || sec.tagName === "SECTION")) {
                    var topSec = sec.closest(".elementor-section-wrap > .elementor-section, article .elementor-section, .entry-content .elementor-section, #content .elementor-section");
                    if (topSec) {
                        sec = topSec;
                    }
                    break;
                }
                sec = sec.parentElement;
            }

            if (!sec || sec === document.body) {
                sec = targetHeading.closest(".elementor-element") || targetHeading.parentElement;
            }

            if (sec) {
                var tempDiv = document.createElement("div");
                tempDiv.innerHTML = `<?php echo str_replace(array("\r", "\n"), '', mts_render_akademik_grid_html()); ?>`;
                
                var newEl = tempDiv.firstElementChild;
                sec.parentNode.replaceChild(newEl, sec);
            }
        }

        if (document.readyState === "complete" || document.readyState === "interactive") {
            replaceAkademikSection();
        }
        document.addEventListener("DOMContentLoaded", replaceAkademikSection);
        window.addEventListener("load", replaceAkademikSection);
        
        // Interval check for live Elementor preview rendering
        setInterval(replaceAkademikSection, 1000);
    })();
    </script>
    <?php
});
