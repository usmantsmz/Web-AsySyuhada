<?php
if (!defined('ABSPATH')) {
    exit;
}

class SPMB_Admin {

    public function __construct() {
        add_action('admin_menu', [$this, 'register_admin_menus']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);

        // AJAX Hooks
        add_action('wp_ajax_spmb_get_applicant_detail', [$this, 'ajax_get_applicant_detail']);
        add_action('wp_ajax_spmb_update_applicant_status', [$this, 'ajax_update_applicant_status']);
        add_action('wp_ajax_spmb_update_doc_status', [$this, 'ajax_update_doc_status']);
        add_action('wp_ajax_spmb_save_requirement', [$this, 'ajax_save_requirement']);
        add_action('wp_ajax_spmb_delete_requirement', [$this, 'ajax_delete_requirement']);
        add_action('wp_ajax_spmb_save_schedule', [$this, 'ajax_save_schedule']);
        add_action('wp_ajax_spmb_delete_schedule', [$this, 'ajax_delete_schedule']);
        add_action('wp_ajax_spmb_save_settings', [$this, 'ajax_save_settings']);
        add_action('wp_ajax_spmb_save_selection', [$this, 'ajax_save_selection']);
        add_action('wp_ajax_spmb_toggle_publish_selection', [$this, 'ajax_toggle_publish_selection']);
        add_action('wp_ajax_spmb_export_csv', [$this, 'export_csv']);
    }

    public function register_admin_menus() {
        add_menu_page(
            'SPMB Dashboard',
            'SPMB',
            'manage_options',
            'spmb-dashboard',
            [$this, 'render_dashboard_page'],
            'dashicons-welcome-learn-more',
            25
        );

        add_submenu_page(
            'spmb-dashboard',
            'Dashboard SPMB',
            'Dashboard',
            'manage_options',
            'spmb-dashboard',
            [$this, 'render_dashboard_page']
        );

        add_submenu_page(
            'spmb-dashboard',
            'Data Pendaftar',
            'Pendaftar',
            'manage_options',
            'spmb-applicants',
            [$this, 'render_applicants_page']
        );

        add_submenu_page(
            'spmb-dashboard',
            'Persyaratan Berkas',
            'Persyaratan',
            'manage_options',
            'spmb-requirements',
            [$this, 'render_requirements_page']
        );

        add_submenu_page(
            'spmb-dashboard',
            'Jadwal & Timeline',
            'Jadwal',
            'manage_options',
            'spmb-schedule',
            [$this, 'render_schedule_page']
        );

        add_submenu_page(
            'spmb-dashboard',
            'Pengaturan SPMB',
            'Pengaturan',
            'manage_options',
            'spmb-settings',
            [$this, 'render_settings_page']
        );

        add_submenu_page(
            'spmb-dashboard',
            'Hasil Seleksi',
            'Hasil Seleksi',
            'manage_options',
            'spmb-selection',
            [$this, 'render_selection_page']
        );
    }

    public function enqueue_admin_assets($hook) {
        if (strpos($hook, 'spmb-') === false) {
            return;
        }

        wp_enqueue_style('spmb-admin-style', SPMB_PLUGIN_URL . 'assets/css/spmb-admin.css', [], SPMB_VERSION);
        wp_enqueue_script('spmb-admin-script', SPMB_PLUGIN_URL . 'assets/js/spmb-admin.js', ['jquery'], SPMB_VERSION, true);

        wp_localize_script('spmb-admin-script', 'spmb_admin_obj', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('spmb_admin_nonce')
        ]);
    }

    // 1. DASHBOARD PAGE
    public function render_dashboard_page() {
        $stats = SPMB_DB::get_applicant_stats();
        $chart_data = SPMB_DB::get_daily_chart_data(7);
        $settings = get_option('spmb_settings', []);
        $is_active = !empty($settings['registration_active']);

        global $wpdb;
        $table_app = SPMB_DB::get_table_applicants();
        $recent_applicants = $wpdb->get_results("SELECT * FROM $table_app ORDER BY registration_date DESC LIMIT 5", ARRAY_A);
        ?>
        <div class="wrap spmb-admin-wrap">
            <div class="spmb-admin-header">
                <div>
                    <h1>Dashboard SPMB MTs Asy-Syuhada</h1>
                    <p class="spmb-subtitle">Sistem Penerimaan Murid Baru Tahun Pelajaran <?php echo esc_html($settings['period_year'] ?? '2026/2027'); ?></p>
                </div>
                <div class="spmb-header-status">
                    <span class="spmb-badge <?php echo $is_active ? 'badge-open' : 'badge-closed'; ?>">
                        <?php echo $is_active ? '🟢 Pendaftaran DIBUKA' : '🔴 Pendaftaran DITUTUP'; ?>
                    </span>
                    <a href="<?php echo admin_url('admin.php?page=spmb-settings'); ?>" class="button button-secondary">Kelola Status</a>
                </div>
            </div>

            <!-- KPI Cards -->
            <div class="spmb-stats-grid">
                <div class="spmb-stat-card card-total">
                    <div class="stat-icon">👥</div>
                    <div class="stat-content">
                        <h3>Total Pendaftar</h3>
                        <div class="stat-value"><?php echo esc_html($stats['total']); ?></div>
                    </div>
                </div>
                <div class="spmb-stat-card card-today">
                    <div class="stat-icon">📅</div>
                    <div class="stat-content">
                        <h3>Pendaftar Hari Ini</h3>
                        <div class="stat-value"><?php echo esc_html($stats['today']); ?></div>
                    </div>
                </div>
                <div class="spmb-stat-card card-warning">
                    <div class="stat-icon">⏳</div>
                    <div class="stat-content">
                        <h3>Menunggu Verifikasi</h3>
                        <div class="stat-value"><?php echo esc_html($stats['waiting_verif'] + $stats['baru']); ?></div>
                    </div>
                </div>
                <div class="spmb-stat-card card-info">
                    <div class="stat-icon">📋</div>
                    <div class="stat-content">
                        <h3>Terverifikasi</h3>
                        <div class="stat-value"><?php echo esc_html($stats['verified']); ?></div>
                    </div>
                </div>
                <div class="spmb-stat-card card-success">
                    <div class="stat-icon">🎓</div>
                    <div class="stat-content">
                        <h3>Diterima</h3>
                        <div class="stat-value"><?php echo esc_html($stats['accepted']); ?></div>
                    </div>
                </div>
                <div class="spmb-stat-card card-reserve">
                    <div class="stat-icon">📑</div>
                    <div class="stat-content">
                        <h3>Cadangan</h3>
                        <div class="stat-value"><?php echo esc_html($stats['reserve']); ?></div>
                    </div>
                </div>
            </div>

            <div class="spmb-dashboard-columns">
                <!-- SVG Graph Chart -->
                <div class="spmb-box spmb-chart-box">
                    <h2>📈 Grafik Pendaftaran 7 Hari Terakhir</h2>
                    <div class="spmb-svg-chart-container">
                        <?php
                        $max_val = 1;
                        foreach ($chart_data as $c) {
                            if ($c['count'] > $max_val) $max_val = $c['count'];
                        }
                        ?>
                        <svg class="spmb-chart-svg" viewBox="0 0 500 180">
                            <!-- Grid lines -->
                            <line x1="40" y1="20" x2="480" y2="20" stroke="#e2e8f0" stroke-dasharray="3,3" />
                            <line x1="40" y1="70" x2="480" y2="70" stroke="#e2e8f0" stroke-dasharray="3,3" />
                            <line x1="40" y1="120" x2="480" y2="120" stroke="#e2e8f0" stroke-dasharray="3,3" />
                            <line x1="40" y1="150" x2="480" y2="150" stroke="#cbd5e1" />

                            <?php 
                            $pts = [];
                            $step_x = (440) / (count($chart_data) - 1 ?: 1);
                            foreach ($chart_data as $idx => $cd) {
                                $x = 40 + ($idx * $step_x);
                                $y = 150 - (($cd['count'] / $max_val) * 120);
                                $pts[] = "$x,$y";
                                echo "<circle cx='$x' cy='$y' r='5' fill='#0d5c3a' />";
                                echo "<text x='$x' y='".($y - 10)."' text-anchor='middle' font-size='11' font-weight='bold' fill='#0d5c3a'>{$cd['count']}</text>";
                                echo "<text x='$x' y='168' text-anchor='middle' font-size='11' fill='#64748b'>{$cd['date']}</text>";
                            }
                            if (count($pts) > 1) {
                                echo "<polyline points='" . implode(' ', $pts) . "' fill='none' stroke='#0d5c3a' stroke-width='3' />";
                            }
                            ?>
                        </svg>
                    </div>
                </div>

                <!-- Recent Applicants -->
                <div class="spmb-box spmb-recent-box">
                    <div class="spmb-box-header">
                        <h2>📥 Pendaftar Terbaru</h2>
                        <a href="<?php echo admin_url('admin.php?page=spmb-applicants'); ?>" class="button button-small">Lihat Semua</a>
                    </div>
                    <table class="wp-list-table widefat fixed striped">
                        <thead>
                            <tr>
                                <th>No. Reg</th>
                                <th>Nama</th>
                                <th>Sekolah Asal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($recent_applicants)): ?>
                                <tr><td colspan="4">Belum ada data pendaftar.</td></tr>
                            <?php else: ?>
                                <?php foreach ($recent_applicants as $app): ?>
                                    <tr>
                                        <td><strong><a href="#" class="btn-open-detail" data-id="<?php echo $app['id']; ?>"><?php echo esc_html($app['reg_no']); ?></a></strong></td>
                                        <td><?php echo esc_html($app['full_name']); ?></td>
                                        <td><?php echo esc_html($app['school_origin']); ?></td>
                                        <td><span class="spmb-status-pill status-<?php echo sanitize_title($app['status']); ?>"><?php echo esc_html($app['status']); ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
        $this->render_applicant_detail_modal();
    }

    // 2. APPLICANTS PAGE
    public function render_applicants_page() {
        global $wpdb;
        $table = SPMB_DB::get_table_applicants();

        $search = sanitize_text_field($_GET['s'] ?? '');
        $status_filter = sanitize_text_field($_GET['status_filter'] ?? '');
        $paged = max(1, intval($_GET['paged'] ?? 1));
        $per_page = 15;
        $offset = ($paged - 1) * $per_page;

        $where = ["1=1"];
        if ($search) {
            $where[] = $wpdb->prepare("(reg_no LIKE %s OR full_name LIKE %s OR nisn LIKE %s OR school_origin LIKE %s)", "%$search%", "%$search%", "%$search%", "%$search%");
        }
        if ($status_filter) {
            $where[] = $wpdb->prepare("status = %s", $status_filter);
        }
        $where_sql = implode(' AND ', $where);

        $total_items = $wpdb->get_var("SELECT COUNT(*) FROM $table WHERE $where_sql");
        $applicants = $wpdb->get_results("SELECT * FROM $table WHERE $where_sql ORDER BY id DESC LIMIT $per_page OFFSET $offset", ARRAY_A);
        $total_pages = ceil($total_items / $per_page);
        ?>
        <div class="wrap spmb-admin-wrap">
            <h1 class="wp-heading-inline">Data Pendaftar SPMB</h1>
            <a href="<?php echo admin_url('admin-ajax.php?action=spmb_export_csv&_wpnonce=' . wp_create_nonce('spmb_export')); ?>" class="button button-primary" style="margin-left: 10px;">📥 Export CSV / Excel</a>
            <hr class="wp-header-end">

            <!-- Search & Filter Bar -->
            <form method="get" class="spmb-filter-bar">
                <input type="hidden" name="page" value="spmb-applicants">
                <input type="search" name="s" value="<?php echo esc_attr($search); ?>" placeholder="Cari No. Reg, Nama, NISN, Sekolah...">
                <select name="status_filter">
                    <option value="">-- Semua Status --</option>
                    <?php 
                    $statuses = ['Baru', 'Menunggu Verifikasi', 'Berkas Tidak Lengkap', 'Terverifikasi', 'Mengikuti Seleksi', 'Diterima', 'Tidak Diterima', 'Cadangan'];
                    foreach ($statuses as $st) {
                        $sel = ($status_filter === $st) ? 'selected' : '';
                        echo "<option value='$st' $sel>$st</option>";
                    }
                    ?>
                </select>
                <button type="submit" class="button button-secondary">Filter</button>
                <?php if ($search || $status_filter): ?>
                    <a href="<?php echo admin_url('admin.php?page=spmb-applicants'); ?>" class="button">Reset</a>
                <?php endif; ?>
            </form>

            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th style="width: 40px;">No</th>
                        <th style="width: 140px;">No. Pendaftaran</th>
                        <th>Nama Lengkap</th>
                        <th>NISN</th>
                        <th>Asal Sekolah</th>
                        <th>No. HP/WA</th>
                        <th>Tgl Daftar</th>
                        <th>Status</th>
                        <th style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($applicants)): ?>
                        <tr><td colspan="9" style="text-align:center; padding: 20px;">Tidak ada data pendaftar ditemukan.</td></tr>
                    <?php else: ?>
                        <?php foreach ($applicants as $idx => $app): ?>
                            <tr>
                                <td><?php echo $offset + $idx + 1; ?></td>
                                <td><strong><a href="#" class="btn-open-detail" data-id="<?php echo $app['id']; ?>"><?php echo esc_html($app['reg_no']); ?></a></strong></td>
                                <td><strong><?php echo esc_html($app['full_name']); ?></strong></td>
                                <td><?php echo esc_html($app['nisn']); ?></td>
                                <td><?php echo esc_html($app['school_origin']); ?></td>
                                <td><?php echo esc_html($app['phone']); ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($app['registration_date'])); ?></td>
                                <td><span class="spmb-status-pill status-<?php echo sanitize_title($app['status']); ?>"><?php echo esc_html($app['status']); ?></span></td>
                                <td>
                                    <button type="button" class="button button-small btn-open-detail" data-id="<?php echo $app['id']; ?>">Detail</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
                <div class="tablenav bottom">
                    <div class="tablenav-pages">
                        <span class="displaying-num"><?php echo $total_items; ?> item</span>
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <a class="page-numbers <?php echo ($paged == $i) ? 'current' : ''; ?>" href="<?php echo add_query_arg(['paged' => $i]); ?>"><?php echo $i; ?></a>
                        <?php endfor; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <?php
        $this->render_applicant_detail_modal();
    }

    // Modal Drawer for Applicant Details
    private function render_applicant_detail_modal() {
        ?>
        <div id="spmb-detail-modal" class="spmb-modal" style="display:none;">
            <div class="spmb-modal-overlay"></div>
            <div class="spmb-modal-content">
                <div class="spmb-modal-header">
                    <h2 id="spmb-modal-title">Detail Pendaftar</h2>
                    <button type="button" class="spmb-modal-close">&times;</button>
                </div>
                <div class="spmb-modal-body" id="spmb-modal-body">
                    <div class="spmb-spinner">Memuat data...</div>
                </div>
            </div>
        </div>
        <?php
    }

    // 3. REQUIREMENTS PAGE
    public function render_requirements_page() {
        global $wpdb;
        $table = SPMB_DB::get_table_requirements();
        $reqs = $wpdb->get_results("SELECT * FROM $table ORDER BY sort_order ASC, id ASC", ARRAY_A);
        ?>
        <div class="wrap spmb-admin-wrap">
            <h1>Pengaturan Persyaratan Berkas Dokumen</h1>
            <p>Kelola dokumen yang wajib / opsional diunggah oleh calon siswa pada formulir pendaftaran.</p>

            <div class="spmb-two-columns">
                <!-- Requirements Form -->
                <div class="spmb-box">
                    <h2 id="req-form-title">Tambah Persyaratan Baru</h2>
                    <form id="spmb-req-form">
                        <input type="hidden" name="req_id" id="req_id" value="0">
                        
                        <div class="spmb-form-group">
                            <label>Nama Dokumen *</label>
                            <input type="text" name="title" id="req_title" required class="widefat" placeholder="misal: Kartu Keluarga">
                        </div>
                        <div class="spmb-form-group">
                            <label>Deskripsi / Petunjuk</label>
                            <textarea name="description" id="req_description" class="widefat" rows="2" placeholder="misal: Scan KK asli yang masih berlaku"></textarea>
                        </div>
                        <div class="spmb-form-group">
                            <label>Format File Dikizinkan (pisahkan koma)</label>
                            <input type="text" name="allowed_formats" id="req_allowed_formats" value="pdf,jpg,jpeg,png" class="widefat">
                        </div>
                        <div class="spmb-form-group">
                            <label>Maksimal Ukuran File (MB)</label>
                            <input type="number" name="max_size_mb" id="req_max_size_mb" value="2" min="1" max="10" class="small-text"> MB
                        </div>
                        <div class="spmb-form-group">
                            <label><input type="checkbox" name="is_required" id="req_is_required" value="1" checked> Wajib Diunggah (Required)</label>
                        </div>
                        <div class="spmb-form-group">
                            <label>Urutan Tampil</label>
                            <input type="number" name="sort_order" id="req_sort_order" value="1" class="small-text">
                        </div>
                        <button type="submit" class="button button-primary">Simpan Persyaratan</button>
                        <button type="button" id="btn-cancel-req" class="button" style="display:none;">Batal</button>
                    </form>
                </div>

                <!-- Requirements List -->
                <div class="spmb-box">
                    <h2>Daftar Persyaratan Dokumen Saat Ini</h2>
                    <table class="wp-list-table widefat striped">
                        <thead>
                            <tr>
                                <th>Urutan</th>
                                <th>Nama Dokumen</th>
                                <th>Format & Max</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reqs as $r): ?>
                                <tr>
                                    <td><?php echo $r['sort_order']; ?></td>
                                    <td>
                                        <strong><?php echo esc_html($r['title']); ?></strong>
                                        <div style="font-size: 11px; color:#64748b;"><?php echo esc_html($r['description']); ?></div>
                                    </td>
                                    <td><code><?php echo esc_html($r['allowed_formats']); ?></code> (<?php echo $r['max_size_mb']; ?>MB)</td>
                                    <td>
                                        <?php echo $r['is_required'] ? '<span style="color:red; font-weight:bold;">Wajib</span>' : '<span style="color:gray;">Opsional</span>'; ?>
                                    </td>
                                    <td>
                                        <button type="button" class="button button-small btn-edit-req" data-json="<?php echo esc_attr(json_encode($r)); ?>">Edit</button>
                                        <button type="button" class="button button-small btn-delete-req" data-id="<?php echo $r['id']; ?>">Hapus</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
    }

    // 4. SCHEDULE PAGE
    public function render_schedule_page() {
        global $wpdb;
        $table = SPMB_DB::get_table_schedule();
        $schedules = $wpdb->get_results("SELECT * FROM $table ORDER BY sort_order ASC, id ASC", ARRAY_A);
        ?>
        <div class="wrap spmb-admin-wrap">
            <h1>Kelola Jadwal & Timeline SPMB</h1>
            <p>Atur alur dan periode tanggal penting pendaftaran murid baru untuk ditampilkan pada halaman publik.</p>

            <div class="spmb-two-columns">
                <!-- Schedule Form -->
                <div class="spmb-box">
                    <h2 id="sched-form-title">Tambah Kegiatan / Agenda Baru</h2>
                    <form id="spmb-sched-form">
                        <input type="hidden" name="sched_id" id="sched_id" value="0">
                        <div class="spmb-form-group">
                            <label>Nama Kegiatan *</label>
                            <input type="text" name="event_title" id="sched_title" required class="widefat" placeholder="misal: Verifikasi Berkas">
                        </div>
                        <div class="spmb-form-group">
                            <label>Tanggal Mulai</label>
                            <input type="date" name="start_date" id="sched_start_date" class="regular-text">
                        </div>
                        <div class="spmb-form-group">
                            <label>Tanggal Selesai</label>
                            <input type="date" name="end_date" id="sched_end_date" class="regular-text">
                        </div>
                        <div class="spmb-form-group">
                            <label>Deskripsi / Keterangan</label>
                            <textarea name="description" id="sched_description" class="widefat" rows="3"></textarea>
                        </div>
                        <div class="spmb-form-group">
                            <label>Urutan Tampil</label>
                            <input type="number" name="sort_order" id="sched_sort_order" value="1" class="small-text">
                        </div>
                        <button type="submit" class="button button-primary">Simpan Agenda</button>
                        <button type="button" id="btn-cancel-sched" class="button" style="display:none;">Batal</button>
                    </form>
                </div>

                <!-- Schedule List -->
                <div class="spmb-box">
                    <h2>Timeline Agenda SPMB</h2>
                    <table class="wp-list-table widefat striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kegiatan</th>
                                <th>Periode Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($schedules as $s): ?>
                                <tr>
                                    <td><?php echo $s['sort_order']; ?></td>
                                    <td>
                                        <strong><?php echo esc_html($s['event_title']); ?></strong>
                                        <div style="font-size: 11px; color:#64748b;"><?php echo esc_html($s['description']); ?></div>
                                    </td>
                                    <td>
                                        <?php 
                                        $st = $s['start_date'] ? date('d/m/Y', strtotime($s['start_date'])) : '-';
                                        $en = $s['end_date'] ? date('d/m/Y', strtotime($s['end_date'])) : '-';
                                        echo "$st s/d $en";
                                        ?>
                                    </td>
                                    <td>
                                        <button type="button" class="button button-small btn-edit-sched" data-json="<?php echo esc_attr(json_encode($s)); ?>">Edit</button>
                                        <button type="button" class="button button-small btn-delete-sched" data-id="<?php echo $s['id']; ?>">Hapus</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
    }

    // 5. SETTINGS PAGE
    public function render_settings_page() {
        $settings = get_option('spmb_settings', [
            'registration_active' => 1,
            'period_year' => '2026/2027',
            'start_date' => '2026-05-01',
            'end_date' => '2026-06-30',
            'enable_email_notification' => 1,
            'enable_admin_alert' => 1,
            'admin_notify_email' => get_option('admin_email'),
            'email_subject_student' => '[SPMB] Konfirmasi Pendaftaran Online - {no_pendaftaran}'
        ]);
        ?>
        <div class="wrap spmb-admin-wrap">
            <h1>Pengaturan Sistem SPMB</h1>
            <p>Atur status pendaftaran, periode tahun ajaran, dan konfigurasikan sistem notifikasi email.</p>

            <form id="spmb-settings-form" class="spmb-box" style="max-width: 800px;">
                <h2>1. Status & Periode Pendaftaran</h2>

                <div class="spmb-form-group highlight-box">
                    <label style="font-size: 16px; font-weight: bold;">
                        <input type="checkbox" name="registration_active" value="1" <?php checked($settings['registration_active'] ?? 1, 1); ?>>
                        🟢 Aktifkan Formulir Pendaftaran Online (Pendaftaran Dibuka)
                    </label>
                    <p class="description">Jika di-OFF-kan, tombol "Daftar Sekarang" pada website publik akan ter-disable dan menampilkan pesan pendaftaran ditutup.</p>
                </div>

                <div class="spmb-form-group">
                    <label>Tahun Pelajaran / Ajaran</label>
                    <input type="text" name="period_year" value="<?php echo esc_attr($settings['period_year'] ?? '2026/2027'); ?>" class="regular-text">
                    <p class="description">misal: 2026/2027</p>
                </div>

                <div class="spmb-form-group">
                    <label>Tanggal Mulai Pendaftaran</label>
                    <input type="date" name="start_date" value="<?php echo esc_attr($settings['start_date'] ?? ''); ?>" class="regular-text">
                </div>

                <div class="spmb-form-group">
                    <label>Tanggal Selesai Pendaftaran</label>
                    <input type="date" name="end_date" value="<?php echo esc_attr($settings['end_date'] ?? ''); ?>" class="regular-text">
                </div>

                <hr style="margin: 25px 0;">

                <h2>2. Pengaturan Notifikasi Email</h2>
                <div class="spmb-form-group">
                    <label><input type="checkbox" name="enable_email_notification" value="1" <?php checked($settings['enable_email_notification'] ?? 1, 1); ?>> Kirim Email Konfirmasi Otomatis ke Calon Siswa setelah submit</label>
                </div>
                <div class="spmb-form-group">
                    <label><input type="checkbox" name="enable_admin_alert" value="1" <?php checked($settings['enable_admin_alert'] ?? 1, 1); ?>> Kirim Email Notifikasi ke Admin Sekolah saat ada Pendaftar Baru</label>
                </div>
                <div class="spmb-form-group">
                    <label>Email Penerima Notifikasi Admin</label>
                    <input type="email" name="admin_notify_email" value="<?php echo esc_attr($settings['admin_notify_email'] ?? get_option('admin_email')); ?>" class="regular-text">
                </div>
                <div class="spmb-form-group">
                    <label>Subjek Email Konfirmasi Siswa</label>
                    <input type="text" name="email_subject_student" value="<?php echo esc_attr($settings['email_subject_student'] ?? '[SPMB] Konfirmasi Pendaftaran Online - {no_pendaftaran}'); ?>" class="widefat">
                </div>

                <br>
                <button type="submit" class="button button-primary button-hero">Simpan Seluruh Pengaturan</button>
            </form>
        </div>
        <?php
    }

    // 6. SELECTION RESULTS PAGE
    public function render_selection_page() {
        global $wpdb;
        $table_app = SPMB_DB::get_table_applicants();
        $table_sel = SPMB_DB::get_table_selection();

        $is_published = get_option('spmb_selection_published', 0);

        $sql = "SELECT a.id, a.reg_no, a.full_name, a.nisn, a.school_origin, a.status as app_status, s.status as sel_status, s.participant_no, s.ranking, s.score, s.notes
                FROM $table_app a
                LEFT JOIN $table_sel s ON a.id = s.applicant_id
                ORDER BY a.id DESC";

        $results = $wpdb->get_results($sql, ARRAY_A);
        ?>
        <div class="wrap spmb-admin-wrap">
            <div class="spmb-admin-header">
                <div>
                    <h1>Penetapan & Publikasi Hasil Seleksi SPMB</h1>
                    <p>Tentukan status Kelulusan (Diterima / Tidak Diterima / Cadangan) bagi pendaftar dan atur visibilitas ke halaman publik.</p>
                </div>
                <div class="spmb-header-status">
                    <button type="button" id="btn-toggle-publish" class="button <?php echo $is_published ? 'button-primary' : 'button-secondary'; ?>" data-published="<?php echo $is_published; ?>">
                        <?php echo $is_published ? '🟢 Hasil Seleksi DIPUBLIKASIKAN (Klik utk Unpublish)' : '🔴 Hasil Seleksi DISEMBUNYIKAN (Klik utk Publish)'; ?>
                    </button>
                </div>
            </div>

            <div class="spmb-box">
                <table class="wp-list-table widefat striped">
                    <thead>
                        <tr>
                            <th>No. Pendaftaran</th>
                            <th>Nama Siswa</th>
                            <th>Asal Sekolah</th>
                            <th>No. Peserta / Ranking</th>
                            <th>Nilai Seleksi</th>
                            <th>Status Kelulusan</th>
                            <th>Catatan Panitia</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($results)): ?>
                            <tr><td colspan="8" style="text-align:center;">Belum ada pendaftar.</td></tr>
                        <?php else: ?>
                            <?php foreach ($results as $res): ?>
                                <tr id="sel-row-<?php echo $res['id']; ?>">
                                    <td><strong><?php echo esc_html($res['reg_no']); ?></strong></td>
                                    <td><?php echo esc_html($res['full_name']); ?></td>
                                    <td><?php echo esc_html($res['school_origin']); ?></td>
                                    <td>
                                        <input type="text" class="small-text input-participant-no" value="<?php echo esc_attr($res['participant_no'] ?? ''); ?>" placeholder="No Test">
                                        / <input type="number" class="small-text input-ranking" value="<?php echo esc_attr($res['ranking'] ?? ''); ?>" placeholder="Rank">
                                    </td>
                                    <td>
                                        <input type="text" class="small-text input-score" value="<?php echo esc_attr($res['score'] ?? ''); ?>" placeholder="Nilai">
                                    </td>
                                    <td>
                                        <select class="select-sel-status">
                                            <option value="Menunggu" <?php selected($res['sel_status'], 'Menunggu'); ?>>-- Belum Ditentukan --</option>
                                            <option value="Diterima" <?php selected($res['sel_status'], 'Diterima'); ?>>🟢 Diterima</option>
                                            <option value="Tidak Diterima" <?php selected($res['sel_status'], 'Tidak Diterima'); ?>>🔴 Tidak Diterima</option>
                                            <option value="Cadangan" <?php selected($res['sel_status'], 'Cadangan'); ?>>🟡 Cadangan</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" class="regular-text input-sel-notes" value="<?php echo esc_attr($res['notes'] ?? ''); ?>" placeholder="Catatan opsional">
                                    </td>
                                    <td>
                                        <button type="button" class="button button-small button-primary btn-save-selection" data-id="<?php echo $res['id']; ?>">Simpan</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
    }

    // AJAX: Get applicant details with tabs
    public function ajax_get_applicant_detail() {
        check_ajax_referer('spmb_admin_nonce', 'nonce');
        $id = intval($_POST['id'] ?? 0);

        global $wpdb;
        $table_app = SPMB_DB::get_table_applicants();
        $table_doc = SPMB_DB::get_table_documents();

        $app = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_app WHERE id = %d", $id), ARRAY_A);
        if (!$app) {
            wp_send_json_error('Pendaftar tidak ditemukan');
        }

        $docs = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_doc WHERE applicant_id = %d", $id), ARRAY_A);

        ob_start();
        ?>
        <div class="spmb-detail-tabs">
            <button type="button" class="tab-btn active" data-tab="tab-biodata">👤 Biodata Siswa</button>
            <button type="button" class="tab-btn" data-tab="tab-ortu">👨‍👩‍👧 Data Orang Tua & Wali</button>
            <button type="button" class="tab-btn" data-tab="tab-alamat">🏠 Alamat</button>
            <button type="button" class="tab-btn" data-tab="tab-sekolah">🏫 Sekolah Asal</button>
            <button type="button" class="tab-btn" data-tab="tab-dokumen">📎 Dokumen Persyaratan (<?php echo count($docs); ?>)</button>
            <button type="button" class="tab-btn" data-tab="tab-status">⚙️ Status & Catatan Admin</button>
        </div>

        <div class="spmb-tab-contents">
            <!-- TAB 1: BIODATA -->
            <div id="tab-biodata" class="spmb-tab-pane active">
                <table class="spmb-detail-table">
                    <tr><th>No. Pendaftaran:</th><td><strong style="color:#0d5c3a; font-size:16px;"><?php echo esc_html($app['reg_no']); ?></strong></td></tr>
                    <tr><th>Nama Lengkap:</th><td><strong><?php echo esc_html($app['full_name']); ?></strong> (Panggilan: <?php echo esc_html($app['nickname']); ?>)</td></tr>
                    <tr><th>NISN:</th><td><?php echo esc_html($app['nisn']); ?></td></tr>
                    <tr><th>NIK:</th><td><?php echo esc_html($app['nik']); ?></td></tr>
                    <tr><th>Tempat, Tgl Lahir:</th><td><?php echo esc_html($app['pob']); ?>, <?php echo $app['dob'] ? date('d F Y', strtotime($app['dob'])) : '-'; ?></td></tr>
                    <tr><th>Jenis Kelamin:</th><td><?php echo ($app['gender'] == 'L') ? 'Laki-laki' : 'Perempuan'; ?></td></tr>
                    <tr><th>Agama:</th><td><?php echo esc_html($app['religion']); ?></td></tr>
                    <tr><th>No. KK:</th><td><?php echo esc_html($app['kk_no']); ?></td></tr>
                    <tr><th>No. HP / WhatsApp:</th><td><a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $app['phone']); ?>" target="_blank" class="button button-small">💬 Chat WA (<?php echo esc_html($app['phone']); ?>)</a></td></tr>
                    <tr><th>Email:</th><td><?php echo esc_html($app['email']); ?></td></tr>
                    <tr><th>Tanggal Daftar:</th><td><?php echo date('d F Y H:i:s', strtotime($app['registration_date'])); ?></td></tr>
                </table>
            </div>

            <!-- TAB 2: DATA ORTU -->
            <div id="tab-ortu" class="spmb-tab-pane">
                <h3 style="color:#0d5c3a; border-bottom: 2px solid #0d5c3a; padding-bottom:5px;">Data Ayah Kandung</h3>
                <table class="spmb-detail-table">
                    <tr><th>Nama Ayah:</th><td><?php echo esc_html($app['ayah_name']); ?></td></tr>
                    <tr><th>NIK Ayah:</th><td><?php echo esc_html($app['ayah_nik']); ?></td></tr>
                    <tr><th>Tempat/Tgl Lahir:</th><td><?php echo esc_html($app['ayah_pob_dob']); ?></td></tr>
                    <tr><th>Pendidikan:</th><td><?php echo esc_html($app['ayah_education']); ?></td></tr>
                    <tr><th>Pekerjaan:</th><td><?php echo esc_html($app['ayah_job']); ?></td></tr>
                    <tr><th>Penghasilan:</th><td><?php echo esc_html($app['ayah_income']); ?></td></tr>
                    <tr><th>No HP Ayah:</th><td><?php echo esc_html($app['ayah_phone']); ?></td></tr>
                </table>

                <h3 style="color:#0d5c3a; border-bottom: 2px solid #0d5c3a; padding-bottom:5px; margin-top:20px;">Data Ibu Kandung</h3>
                <table class="spmb-detail-table">
                    <tr><th>Nama Ibu:</th><td><?php echo esc_html($app['ibu_name']); ?></td></tr>
                    <tr><th>NIK Ibu:</th><td><?php echo esc_html($app['ibu_nik']); ?></td></tr>
                    <tr><th>Tempat/Tgl Lahir:</th><td><?php echo esc_html($app['ibu_pob_dob']); ?></td></tr>
                    <tr><th>Pendidikan:</th><td><?php echo esc_html($app['ibu_education']); ?></td></tr>
                    <tr><th>Pekerjaan:</th><td><?php echo esc_html($app['ibu_job']); ?></td></tr>
                    <tr><th>Penghasilan:</th><td><?php echo esc_html($app['ibu_income']); ?></td></tr>
                    <tr><th>No HP Ibu:</th><td><?php echo esc_html($app['ibu_phone']); ?></td></tr>
                </table>

                <?php if (!empty($app['has_wali'])): ?>
                    <h3 style="color:#0d5c3a; border-bottom: 2px solid #0d5c3a; padding-bottom:5px; margin-top:20px;">Data Wali</h3>
                    <table class="spmb-detail-table">
                        <tr><th>Nama Wali:</th><td><?php echo esc_html($app['wali_name']); ?></td></tr>
                        <tr><th>NIK Wali:</th><td><?php echo esc_html($app['wali_nik']); ?></td></tr>
                        <tr><th>Tempat/Tgl Lahir:</th><td><?php echo esc_html($app['wali_pob_dob']); ?></td></tr>
                        <tr><th>Pendidikan:</th><td><?php echo esc_html($app['wali_education']); ?></td></tr>
                        <tr><th>Pekerjaan:</th><td><?php echo esc_html($app['wali_job']); ?></td></tr>
                        <tr><th>Penghasilan:</th><td><?php echo esc_html($app['wali_income']); ?></td></tr>
                        <tr><th>No HP Wali:</th><td><?php echo esc_html($app['wali_phone']); ?></td></tr>
                    </table>
                <?php endif; ?>
            </div>

            <!-- TAB 3: ALAMAT -->
            <div id="tab-alamat" class="spmb-tab-pane">
                <table class="spmb-detail-table">
                    <tr><th>Alamat Lengkap:</th><td><?php echo esc_html($app['address']); ?></td></tr>
                    <tr><th>RT / RW:</th><td><?php echo esc_html($app['rt_rw']); ?></td></tr>
                    <tr><th>Kelurahan / Desa:</th><td><?php echo esc_html($app['kelurahan']); ?></td></tr>
                    <tr><th>Kecamatan:</th><td><?php echo esc_html($app['kecamatan']); ?></td></tr>
                    <tr><th>Kota / Kabupaten:</th><td><?php echo esc_html($app['city']); ?></td></tr>
                    <tr><th>Provinsi:</th><td><?php echo esc_html($app['province']); ?></td></tr>
                </table>
            </div>

            <!-- TAB 4: SEKOLAH ASAL -->
            <div id="tab-sekolah" class="spmb-tab-pane">
                <table class="spmb-detail-table">
                    <tr><th>Nama Sekolah Asal:</th><td><strong><?php echo esc_html($app['school_origin']); ?></strong></td></tr>
                    <tr><th>NPSN Sekolah:</th><td><?php echo esc_html($app['school_npsn']); ?></td></tr>
                </table>
            </div>

            <!-- TAB 5: DOKUMEN -->
            <div id="tab-dokumen" class="spmb-tab-pane">
                <?php if (empty($docs)): ?>
                    <p style="color:red; font-style:italic;">Belum ada dokumen yang diunggah.</p>
                <?php else: ?>
                    <table class="wp-list-table widefat striped">
                        <thead>
                            <tr>
                                <th>Nama Dokumen</th>
                                <th>File Name</th>
                                <th>Ukuran</th>
                                <th>Status Verifikasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($docs as $d): ?>
                                <tr>
                                    <td><strong><?php echo esc_html($d['doc_title']); ?></strong></td>
                                    <td><?php echo esc_html($d['file_name']); ?></td>
                                    <td><?php echo round($d['file_size'] / 1024, 1); ?> KB</td>
                                    <td>
                                        <select class="spmb-doc-status-select" data-doc-id="<?php echo $d['id']; ?>">
                                            <option value="Menunggu" <?php selected($d['status'], 'Menunggu'); ?>>Menunggu</option>
                                            <option value="Valid" <?php selected($d['status'], 'Valid'); ?>>🟢 Valid</option>
                                            <option value="Tidak Valid" <?php selected($d['status'], 'Tidak Valid'); ?>>🔴 Tidak Valid</option>
                                        </select>
                                    </td>
                                    <td>
                                        <a href="<?php echo esc_url($d['file_url']); ?>" target="_blank" class="button button-small">👁️ Lihat / Download</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>

            <!-- TAB 6: STATUS & CATATAN ADMIN -->
            <div id="tab-status" class="spmb-tab-pane">
                <form id="spmb-update-status-form" data-applicant-id="<?php echo $app['id']; ?>">
                    <div class="spmb-form-group">
                        <label>Status Pendaftaran Pendaftar Ini:</label>
                        <select name="status" id="applicant_status_select" class="widefat" style="font-size:16px; padding:8px;">
                            <?php 
                            $statuses = ['Baru', 'Menunggu Verifikasi', 'Berkas Tidak Lengkap', 'Terverifikasi', 'Mengikuti Seleksi', 'Diterima', 'Tidak Diterima', 'Cadangan'];
                            foreach ($statuses as $st) {
                                $sel = selected($app['status'], $st, false);
                                echo "<option value='$st' $sel>$st</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="spmb-form-group" style="margin-top:15px;">
                        <label>Catatan Panitia / Admin (Dapat dilihat internal atau menjadi alasan berkas tidak lengkap):</label>
                        <textarea name="admin_note" id="admin_note_textarea" class="widefat" rows="4"><?php echo esc_textarea($app['admin_note']); ?></textarea>
                    </div>

                    <button type="submit" class="button button-primary button-large">Simpan Perubahan Status</button>
                </form>
            </div>
        </div>
        <?php
        $html = ob_get_clean();
        wp_send_json_success(['html' => $html, 'reg_no' => $app['reg_no'], 'name' => $app['full_name']]);
    }

    // AJAX Handlers
    public function ajax_update_applicant_status() {
        check_ajax_referer('spmb_admin_nonce', 'nonce');
        $id = intval($_POST['id'] ?? 0);
        $status = sanitize_text_field($_POST['status'] ?? '');
        $admin_note = sanitize_textarea_field($_POST['admin_note'] ?? '');

        global $wpdb;
        $table = SPMB_DB::get_table_applicants();
        $res = $wpdb->update($table, [
            'status' => $status,
            'admin_note' => $admin_note
        ], ['id' => $id]);

        if ($res !== false) {
            wp_send_json_success('Status pendaftar berhasil diperbarui');
        } else {
            wp_send_json_error('Gagal memperbarui status');
        }
    }

    public function ajax_update_doc_status() {
        check_ajax_referer('spmb_admin_nonce', 'nonce');
        $doc_id = intval($_POST['doc_id'] ?? 0);
        $status = sanitize_text_field($_POST['status'] ?? '');

        global $wpdb;
        $table = SPMB_DB::get_table_documents();
        $wpdb->update($table, ['status' => $status], ['id' => $doc_id]);
        wp_send_json_success('Status dokumen diperbarui');
    }

    public function ajax_save_requirement() {
        check_ajax_referer('spmb_admin_nonce', 'nonce');
        global $wpdb;
        $table = SPMB_DB::get_table_requirements();

        $id = intval($_POST['req_id'] ?? 0);
        $data = [
            'title' => sanitize_text_field($_POST['title'] ?? ''),
            'description' => sanitize_textarea_field($_POST['description'] ?? ''),
            'allowed_formats' => sanitize_text_field($_POST['allowed_formats'] ?? 'pdf,jpg,jpeg,png'),
            'max_size_mb' => intval($_POST['max_size_mb'] ?? 2),
            'is_required' => !empty($_POST['is_required']) ? 1 : 0,
            'sort_order' => intval($_POST['sort_order'] ?? 1)
        ];

        if ($id > 0) {
            $wpdb->update($table, $data, ['id' => $id]);
        } else {
            $wpdb->insert($table, $data);
        }
        wp_send_json_success('Persyaratan berhasil disimpan');
    }

    public function ajax_delete_requirement() {
        check_ajax_referer('spmb_admin_nonce', 'nonce');
        $id = intval($_POST['id'] ?? 0);
        global $wpdb;
        $table = SPMB_DB::get_table_requirements();
        $wpdb->delete($table, ['id' => $id]);
        wp_send_json_success('Persyaratan dihapus');
    }

    public function ajax_save_schedule() {
        check_ajax_referer('spmb_admin_nonce', 'nonce');
        global $wpdb;
        $table = SPMB_DB::get_table_schedule();

        $id = intval($_POST['sched_id'] ?? 0);
        $data = [
            'event_title' => sanitize_text_field($_POST['event_title'] ?? ''),
            'start_date' => !empty($_POST['start_date']) ? sanitize_text_field($_POST['start_date']) : null,
            'end_date' => !empty($_POST['end_date']) ? sanitize_text_field($_POST['end_date']) : null,
            'description' => sanitize_textarea_field($_POST['description'] ?? ''),
            'sort_order' => intval($_POST['sort_order'] ?? 1)
        ];

        if ($id > 0) {
            $wpdb->update($table, $data, ['id' => $id]);
        } else {
            $wpdb->insert($table, $data);
        }
        wp_send_json_success('Agenda jadwal berhasil disimpan');
    }

    public function ajax_delete_schedule() {
        check_ajax_referer('spmb_admin_nonce', 'nonce');
        $id = intval($_POST['id'] ?? 0);
        global $wpdb;
        $table = SPMB_DB::get_table_schedule();
        $wpdb->delete($table, ['id' => $id]);
        wp_send_json_success('Agenda jadwal dihapus');
    }

    public function ajax_save_settings() {
        check_ajax_referer('spmb_admin_nonce', 'nonce');
        $settings = [
            'registration_active' => !empty($_POST['registration_active']) ? 1 : 0,
            'period_year' => sanitize_text_field($_POST['period_year'] ?? '2026/2027'),
            'start_date' => sanitize_text_field($_POST['start_date'] ?? ''),
            'end_date' => sanitize_text_field($_POST['end_date'] ?? ''),
            'enable_email_notification' => !empty($_POST['enable_email_notification']) ? 1 : 0,
            'enable_admin_alert' => !empty($_POST['enable_admin_alert']) ? 1 : 0,
            'admin_notify_email' => sanitize_email($_POST['admin_notify_email'] ?? ''),
            'email_subject_student' => sanitize_text_field($_POST['email_subject_student'] ?? '')
        ];

        update_option('spmb_settings', $settings);
        wp_send_json_success('Pengaturan SPMB berhasil disimpan');
    }

    public function ajax_save_selection() {
        check_ajax_referer('spmb_admin_nonce', 'nonce');
        $applicant_id = intval($_POST['applicant_id'] ?? 0);
        $status = sanitize_text_field($_POST['status'] ?? 'Menunggu');
        $participant_no = sanitize_text_field($_POST['participant_no'] ?? '');
        $ranking = intval($_POST['ranking'] ?? 0);
        $score = sanitize_text_field($_POST['score'] ?? '');
        $notes = sanitize_textarea_field($_POST['notes'] ?? '');

        global $wpdb;
        $table_sel = SPMB_DB::get_table_selection();
        $table_app = SPMB_DB::get_table_applicants();

        $exists = $wpdb->get_var($wpdb->prepare("SELECT id FROM $table_sel WHERE applicant_id = %d", $applicant_id));

        $data = [
            'applicant_id' => $applicant_id,
            'status' => $status,
            'participant_no' => $participant_no,
            'ranking' => $ranking,
            'score' => $score,
            'notes' => $notes
        ];

        if ($exists) {
            $wpdb->update($table_sel, $data, ['applicant_id' => $applicant_id]);
        } else {
            $wpdb->insert($table_sel, $data);
        }

        // Also update applicant table status if status set
        if (in_array($status, ['Diterima', 'Tidak Diterima', 'Cadangan'])) {
            $wpdb->update($table_app, ['status' => $status], ['id' => $applicant_id]);
        }

        wp_send_json_success('Hasil seleksi disimpan');
    }

    public function ajax_toggle_publish_selection() {
        check_ajax_referer('spmb_admin_nonce', 'nonce');
        $current = get_option('spmb_selection_published', 0);
        $new_val = $current ? 0 : 1;
        update_option('spmb_selection_published', $new_val);
        wp_send_json_success(['published' => $new_val]);
    }

    public function export_csv() {
        check_admin_referer('spmb_export');
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }

        global $wpdb;
        $table = SPMB_DB::get_table_applicants();
        $rows = $wpdb->get_results("SELECT * FROM $table ORDER BY id DESC", ARRAY_A);

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=spmb_pendaftar_' . date('Ymd_His') . '.csv');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['No Reg', 'Tahun', 'NISN', 'NIK', 'Nama Lengkap', 'Panggilan', 'Gender', 'No HP', 'Email', 'Sekolah Asal', 'NPSN', 'Status', 'Tanggal Daftar']);

        foreach ($rows as $r) {
            fputcsv($output, [
                $r['reg_no'],
                $r['year_period'],
                $r['nisn'],
                $r['nik'],
                $r['full_name'],
                $r['nickname'],
                $r['gender'],
                $r['phone'],
                $r['email'],
                $r['school_origin'],
                $r['school_npsn'],
                $r['status'],
                $r['registration_date']
            ]);
        }
        fclose($output);
        exit;
    }
}
