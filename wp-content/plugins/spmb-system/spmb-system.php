<?php
/**
 * Plugin Name: SPMB System - Sistem Penerimaan Murid Baru
 * Plugin URI: https://mts-asy-syuhada.sch.id
 * Description: Modul/Sistem Penerimaan Murid Baru (SPMB) fungsional dan terintegrasi lengkap di dalam ekosistem WordPress untuk MTs Asy-Syuhada.
 * Version: 1.0.0
 * Author: Antigravity AI Team
 * Text Domain: spmb-system
 */

if (!defined('ABSPATH')) {
    exit;
}

define('SPMB_VERSION', '1.0.0');
define('SPMB_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('SPMB_PLUGIN_URL', plugin_dir_url(__FILE__));

require_once SPMB_PLUGIN_DIR . 'includes/class-spmb-db.php';
require_once SPMB_PLUGIN_DIR . 'includes/class-spmb-emailer.php';
require_once SPMB_PLUGIN_DIR . 'includes/class-spmb-admin.php';
require_once SPMB_PLUGIN_DIR . 'includes/class-spmb-public.php';

// Activation Hook
register_activation_hook(__FILE__, 'spmb_activate_plugin');

function spmb_activate_plugin() {
    // 1. Initialize Tables
    SPMB_DB::init_db();

    // 2. Set Default Options
    $settings = get_option('spmb_settings', []);
    if (empty($settings)) {
        update_option('spmb_settings', [
            'registration_active' => 1,
            'period_year' => '2026/2027',
            'start_date' => date('Y-m-d'),
            'end_date' => date('Y-m-d', strtotime('+60 days')),
            'enable_email_notification' => 1,
            'enable_admin_alert' => 1,
            'admin_notify_email' => get_option('admin_email'),
            'email_subject_student' => '[SPMB] Konfirmasi Pendaftaran Online - {no_pendaftaran}'
        ]);
    }

    // 3. Ensure Pages Exist
    spmb_ensure_pages_exist();

    // 4. Flush Rewrite Rules
    flush_rewrite_rules();
}

function spmb_ensure_pages_exist() {
    $pages = [
        [
            'slug' => 'spmb',
            'title' => 'SPMB — Sistem Penerimaan Murid Baru',
            'shortcode' => '[spmb_main_page]'
        ],
        [
            'slug' => 'spmb-pendaftaran',
            'title' => 'Pendaftaran SPMB',
            'shortcode' => '[spmb_registration_form]'
        ],
        [
            'slug' => 'spmb-hasil-seleksi',
            'title' => 'Hasil Seleksi SPMB',
            'shortcode' => '[spmb_selection_results]'
        ]
    ];

    foreach ($pages as $p) {
        $existing = get_page_by_path($p['slug']);
        if (!$existing) {
            wp_insert_post([
                'post_title'   => $p['title'],
                'post_name'    => $p['slug'],
                'post_content' => $p['shortcode'],
                'post_status'  => 'publish',
                'post_type'    => 'page',
                'comment_status' => 'closed'
            ]);
        }
    }
}

// Initialize Plugin Classes
function spmb_init() {
    if (is_admin()) {
        new SPMB_Admin();
    }
    new SPMB_Public();
}
add_action('plugins_loaded', 'spmb_init');
