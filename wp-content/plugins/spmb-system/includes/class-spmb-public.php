<?php
if (!defined('ABSPATH')) {
    exit;
}

class SPMB_Public {

    public function __construct() {
        add_shortcode('spmb_main_page', [$this, 'render_main_page']);
        add_shortcode('spmb_registration_form', [$this, 'render_registration_form']);
        add_shortcode('spmb_selection_results', [$this, 'render_selection_results']);

        add_action('wp_enqueue_scripts', [$this, 'enqueue_public_assets']);

        // Public AJAX Endpoints
        add_action('wp_ajax_spmb_submit_registration', [$this, 'ajax_submit_registration']);
        add_action('wp_ajax_nopriv_spmb_submit_registration', [$this, 'ajax_submit_registration']);

        add_action('wp_ajax_spmb_search_selection', [$this, 'ajax_search_selection']);
        add_action('wp_ajax_nopriv_spmb_search_selection', [$this, 'ajax_search_selection']);
    }

    public function enqueue_public_assets() {
        wp_enqueue_style('spmb-public-style', SPMB_PLUGIN_URL . 'assets/css/spmb-public.css', [], SPMB_VERSION);
        wp_enqueue_script('spmb-public-script', SPMB_PLUGIN_URL . 'assets/js/spmb-public.js', ['jquery'], SPMB_VERSION, true);

        wp_localize_script('spmb-public-script', 'spmb_obj', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('spmb_public_nonce'),
            'reg_url' => home_url('/spmb-pendaftaran/'),
            'result_url' => home_url('/spmb-hasil-seleksi/')
        ]);
    }

    // 1. MAIN PAGE SHORTCODE: [spmb_main_page]
    public function render_main_page() {
        $settings = get_option('spmb_settings', []);
        $is_active = !empty($settings['registration_active']);
        $period_year = $settings['period_year'] ?? '2026/2027';

        global $wpdb;
        $table_sched = SPMB_DB::get_table_schedule();
        $schedules = $wpdb->get_results("SELECT * FROM $table_sched ORDER BY sort_order ASC", ARRAY_A);

        $table_req = SPMB_DB::get_table_requirements();
        $requirements = $wpdb->get_results("SELECT * FROM $table_req ORDER BY sort_order ASC", ARRAY_A);

        ob_start();
        ?>
        <div class="spmb-public-container">
            <!-- Hero Banner -->
            <div class="spmb-hero-card">
                <div class="spmb-hero-overlay"></div>
                <div class="spmb-hero-content">
                    <div class="spmb-period-pill">SPMB Tahun Pelajaran <?php echo esc_html($period_year); ?></div>
                    <h1 class="spmb-hero-title">Sistem Penerimaan Murid Baru</h1>
                    <p class="spmb-hero-sub">Selamat Datang di Portal Penerimaan Murid Baru MTs Asy-Syuhada. Daftarkan putra-putri Anda secara online dengan mudah, cepat, dan terintegrasi.</p>
                    
                    <div class="spmb-status-banner <?php echo $is_active ? 'banner-open' : 'banner-closed'; ?>">
                        <span class="status-indicator-dot"></span>
                        <span class="status-text">
                            STATUS PENDAFTARAN: <strong><?php echo $is_active ? '🟢 PENDAFTARAN DIBUKA' : '🔴 PENDAFTARAN DITUTUP'; ?></strong>
                        </span>
                    </div>

                    <div class="spmb-hero-cta-buttons">
                        <?php if ($is_active): ?>
                            <a href="<?php echo home_url('/spmb-pendaftaran/'); ?>" class="spmb-btn spmb-btn-primary spmb-btn-lg">
                                ✨ DAFTAR SEKARANG
                            </a>
                        <?php else: ?>
                            <button type="button" class="spmb-btn spmb-btn-disabled spmb-btn-lg" disabled title="Pendaftaran belum dibuka">
                                🔒 DAFTAR SEKARANG (DITUTUP)
                            </button>
                        <?php endif; ?>
                        
                        <a href="<?php echo home_url('/spmb-hasil-seleksi/'); ?>" class="spmb-btn spmb-btn-outline spmb-btn-lg">
                            🔍 LIHAT HASIL SELEKSI
                        </a>
                    </div>
                    <?php if (!$is_active): ?>
                        <p class="spmb-notice-closed">ℹ️ Mohon maaf, pendaftaran murid baru saat ini belum dibuka atau telah ditutup.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Key Dates Grid -->
            <?php if (!empty($schedules)): ?>
                <div class="spmb-section spmb-dates-section">
                    <div class="spmb-section-title">
                        <h2>📅 Agenda & Tanggal Penting</h2>
                        <p>Simpan jadwal kegiatan penerimaan murid baru berikut</p>
                    </div>
                    <div class="spmb-dates-grid">
                        <?php foreach ($schedules as $sch): ?>
                            <div class="spmb-date-card">
                                <div class="date-card-icon">📌</div>
                                <div class="date-card-title"><?php echo esc_html($sch['event_title']); ?></div>
                                <div class="date-card-range">
                                    <?php 
                                    $st = $sch['start_date'] ? date('d M Y', strtotime($sch['start_date'])) : '';
                                    $en = $sch['end_date'] ? date('d M Y', strtotime($sch['end_date'])) : '';
                                    echo ($st === $en || empty($en)) ? $st : "$st - $en";
                                    ?>
                                </div>
                                <div class="date-card-desc"><?php echo esc_html($sch['description']); ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Section: Tentang SPMB -->
            <div class="spmb-section spmb-about-section" id="tentang">
                <div class="spmb-about-card">
                    <div class="spmb-about-text">
                        <h2>🏫 Tentang SPMB MTs Asy-Syuhada</h2>
                        <p>Sistem Penerimaan Murid Baru (SPMB) MTs Asy-Syuhada diselenggarakan secara transparan, akuntabel, dan berbasis teknologi untuk memberikan kemudahan bagi calon wali murid dalam mendaftarkan putra-putrinya.</p>
                        <p>Melalui portal ini, pendaftar dapat mengisi biodata, mengunggah dokumen persyaratan, memantau status verifikasi berkas, hingga mengecek hasil kelulusan seleksi secara real-time dari mana saja.</p>
                        <ul class="spmb-check-list">
                            <li>✔️ Formulir Pendaftaran Online 24/7</li>
                            <li>✔️ Upload Berkas Dokumen Persyaratan Digital</li>
                            <li>✔️ Verifikasi Berkas & Transparansi Hasil Seleksi</li>
                            <li>✔️ Notifikasi Email Konfirmasi Otomatis</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Section: Alur Pendaftaran -->
            <div class="spmb-section spmb-steps-section" id="tata-cara">
                <div class="spmb-section-title">
                    <h2>📋 Tata Cara & Alur Pendaftaran</h2>
                    <p>7 Langkah mudah mendaftar sebagai murid baru MTs Asy-Syuhada</p>
                </div>
                <div class="spmb-steps-grid">
                    <div class="step-card">
                        <div class="step-num">01</div>
                        <div class="step-body">
                            <h4>Klik Button Daftar</h4>
                            <p>Klik tombol <strong>Daftar Sekarang</strong> untuk masuk ke formulir pendaftaran.</p>
                        </div>
                    </div>
                    <div class="step-card">
                        <div class="step-num">02</div>
                        <div class="step-body">
                            <h4>Isi Biodata Siswa</h4>
                            <p>Isi formulir biodata calon murid secara lengkap dan sesuai dokumen resmi (KK/Akta).</p>
                        </div>
                    </div>
                    <div class="step-card">
                        <div class="step-num">03</div>
                        <div class="step-body">
                            <h4>Isi Data OrtU / Wali</h4>
                            <p>Lengkapi informasi identitas Ayah, Ibu Kandung, maupun Wali murid.</p>
                        </div>
                    </div>
                    <div class="step-card">
                        <div class="step-num">04</div>
                        <div class="step-body">
                            <h4>Upload Persyaratan</h4>
                            <p>Unggah file scan KK, Akta Kelahiran, Pas Foto, dan berkas pendukung lainnya.</p>
                        </div>
                    </div>
                    <div class="step-card">
                        <div class="step-num">05</div>
                        <div class="step-body">
                            <h4>Submit Pendaftaran</h4>
                            <p>Periksa kembali rangkuman formulir Anda lalu klik Kirim Pendaftaran.</p>
                        </div>
                    </div>
                    <div class="step-card">
                        <div class="step-num">06</div>
                        <div class="step-body">
                            <h4>Simpan Nomor Pendaftaran</h4>
                            <p>Dapatkan Nomor Registrasi otomatis (contoh: <code>SPMB-2026-000123</code>) & simpan bukti.</p>
                        </div>
                    </div>
                    <div class="step-card">
                        <div class="step-num">07</div>
                        <div class="step-body">
                            <h4>Cek Hasil Seleksi</h4>
                            <p>Pantau hasil pengumuman seleksi melalui halaman Cek Hasil Seleksi secara berkala.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section: Persyaratan -->
            <?php if (!empty($requirements)): ?>
                <div class="spmb-section spmb-req-section" id="persyaratan">
                    <div class="spmb-section-title">
                        <h2>📑 Dokumen Persyaratan Pendaftaran</h2>
                        <p>Persiapkan berkas digital berikut sebelum mengisi formulir</p>
                    </div>
                    <div class="spmb-req-grid">
                        <?php foreach ($requirements as $req): ?>
                            <div class="spmb-req-card">
                                <div class="req-card-badge <?php echo $req['is_required'] ? 'req-mandatory' : 'req-optional'; ?>">
                                    <?php echo $req['is_required'] ? 'Wajib' : 'Opsional'; ?>
                                </div>
                                <h4><?php echo esc_html($req['title']); ?></h4>
                                <p><?php echo esc_html($req['description']); ?></p>
                                <div class="req-format-tag">
                                    <span>Format: <code><?php echo esc_html($req['allowed_formats']); ?></code></span>
                                    <span>Max: <?php echo $req['max_size_mb']; ?> MB</span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Bottom CTA -->
            <div class="spmb-bottom-cta">
                <h3>Siap Mendaftarkan Putra-Putri Anda?</h3>
                <p>Bergabunglah bersama MTs Asy-Syuhada untuk membentuk generasi cerdas, berakhlak mulia, dan berprestasi.</p>
                <?php if ($is_active): ?>
                    <a href="<?php echo home_url('/spmb-pendaftaran/'); ?>" class="spmb-btn spmb-btn-primary spmb-btn-lg">🚀 Isi Formulir Pendaftaran Sekarang</a>
                <?php else: ?>
                    <p class="spmb-notice-closed">Pendaftaran saat ini belum dibuka.</p>
                <?php endif; ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    // 2. REGISTRATION FORM SHORTCODE: [spmb_registration_form]
    public function render_registration_form() {
        $settings = get_option('spmb_settings', []);
        $is_active = !empty($settings['registration_active']);

        if (!$is_active) {
            return "
            <div class='spmb-public-container'>
                <div class='spmb-closed-card'>
                    <div class='closed-icon'>🔒</div>
                    <h2>Pendaftaran Belum Dibuka</h2>
                    <p>Mohon maaf, sistem penerimaan murid baru saat ini sedang tidak menerima pendaftaran online. Silakan cek kembali jadwal pendaftaran pada halaman informasi SPMB.</p>
                    <a href='" . home_url('/spmb/') . "' class='spmb-btn spmb-btn-primary'>⬅️ Kembali ke Halaman Utama SPMB</a>
                </div>
            </div>";
        }

        global $wpdb;
        $table_req = SPMB_DB::get_table_requirements();
        $requirements = $wpdb->get_results("SELECT * FROM $table_req ORDER BY sort_order ASC", ARRAY_A);

        $reg_preview = SPMB_DB::generate_reg_no();

        ob_start();
        ?>
        <div class="spmb-public-container">
            <div class="spmb-form-wrapper">
                <div class="spmb-form-header">
                    <h2>Formulir Pendaftaran Online SPMB</h2>
                    <p>Tahun Pelajaran <?php echo esc_html($settings['period_year'] ?? '2026/2027'); ?></p>
                </div>

                <!-- Multi-step Indicator -->
                <div class="spmb-step-bar">
                    <div class="step-item active" data-step="1">
                        <div class="step-badge">1</div>
                        <div class="step-label">Biodata Siswa</div>
                    </div>
                    <div class="step-item" data-step="2">
                        <div class="step-badge">2</div>
                        <div class="step-label">Orang Tua / Wali</div>
                    </div>
                    <div class="step-item" data-step="3">
                        <div class="step-badge">3</div>
                        <div class="step-label">Sekolah Asal</div>
                    </div>
                    <div class="step-item" data-step="4">
                        <div class="step-badge">4</div>
                        <div class="step-label">Upload Berkas</div>
                    </div>
                    <div class="step-item" data-step="5">
                        <div class="step-badge">5</div>
                        <div class="step-label">Review & Submit</div>
                    </div>
                </div>

                <form id="spmb-public-reg-form" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="spmb_submit_registration">
                    <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('spmb_public_nonce'); ?>">

                    <!-- STEP 1: BIODATA -->
                    <div class="spmb-form-step step-pane-1 active">
                        <div class="spmb-form-section-title">
                            <h3>01. Biodata Calon Murid</h3>
                            <span class="reg-preview-tag">No. Registrasi: <strong><?php echo $reg_preview; ?></strong></span>
                        </div>

                        <div class="spmb-grid-2">
                            <div class="form-group">
                                <label>NISN *</label>
                                <input type="text" name="nisn" required maxlength="10" placeholder="10 Digit NISN">
                            </div>
                            <div class="form-group">
                                <label>NIK Siswa *</label>
                                <input type="text" name="nik" required maxlength="16" placeholder="16 Digit NIK di KK">
                            </div>
                        </div>

                        <div class="spmb-grid-2">
                            <div class="form-group">
                                <label>Nama Lengkap Siswa *</label>
                                <input type="text" name="full_name" required placeholder="Sesuai Ijazah/Akta">
                            </div>
                            <div class="form-group">
                                <label>Nama Panggilan</label>
                                <input type="text" name="nickname" placeholder="Nama Panggilan">
                            </div>
                        </div>

                        <div class="spmb-grid-3">
                            <div class="form-group">
                                <label>Tempat Lahir *</label>
                                <input type="text" name="pob" required placeholder="Kota/Kab Tempat Lahir">
                            </div>
                            <div class="form-group">
                                <label>Tanggal Lahir *</label>
                                <input type="date" name="dob" required>
                            </div>
                            <div class="form-group">
                                <label>Jenis Kelamin *</label>
                                <select name="gender" required>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                        </div>

                        <div class="spmb-grid-2">
                            <div class="form-group">
                                <label>Agama *</label>
                                <select name="religion" required>
                                    <option value="Islam" selected>Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Buddha">Buddha</option>
                                    <option value="Khonghucu">Khonghucu</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Nomor Kartu Keluarga (KK) *</label>
                                <input type="text" name="kk_no" required maxlength="16" placeholder="16 Digit Nomor KK">
                            </div>
                        </div>

                        <div class="spmb-grid-2">
                            <div class="form-group">
                                <label>No. HP / WhatsApp Aktif *</label>
                                <input type="tel" name="phone" required placeholder="contoh: 081234567890">
                            </div>
                            <div class="form-group">
                                <label>Email Aktif *</label>
                                <input type="email" name="email" required placeholder="alamat@email.com">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Alamat Lengkap Tempat Tinggal *</label>
                            <textarea name="address" required rows="2" placeholder="Jalan, No. Rumah, Kampung/Komplek"></textarea>
                        </div>

                        <div class="spmb-grid-3">
                            <div class="form-group">
                                <label>RT / RW</label>
                                <input type="text" name="rt_rw" placeholder="001 / 002">
                            </div>
                            <div class="form-group">
                                <label>Kelurahan / Desa *</label>
                                <input type="text" name="kelurahan" required>
                            </div>
                            <div class="form-group">
                                <label>Kecamatan *</label>
                                <input type="text" name="kecamatan" required>
                            </div>
                        </div>

                        <div class="spmb-grid-2">
                            <div class="form-group">
                                <label>Kota / Kabupaten *</label>
                                <input type="text" name="city" required placeholder="Kab. Bandung">
                            </div>
                            <div class="form-group">
                                <label>Provinsi *</label>
                                <input type="text" name="province" required placeholder="Jawa Barat">
                            </div>
                        </div>

                        <div class="form-nav-buttons">
                            <button type="button" class="spmb-btn spmb-btn-primary btn-next-step" data-next="2">Lanjut ke Data Orang Tua ➡️</button>
                        </div>
                    </div>

                    <!-- STEP 2: ORANG TUA / WALI -->
                    <div class="spmb-form-step step-pane-2">
                        <div class="spmb-form-section-title">
                            <h3>02. Data Orang Tua & Wali</h3>
                        </div>

                        <div class="sub-section-box">
                            <h4>👨 Data Ayah Kandung</h4>
                            <div class="spmb-grid-2">
                                <div class="form-group">
                                    <label>Nama Ayah Kandung *</label>
                                    <input type="text" name="ayah_name" required>
                                </div>
                                <div class="form-group">
                                    <label>NIK Ayah *</label>
                                    <input type="text" name="ayah_nik" required maxlength="16">
                                </div>
                            </div>
                            <div class="spmb-grid-3">
                                <div class="form-group">
                                    <label>Tempat/Tgl Lahir Ayah</label>
                                    <input type="text" name="ayah_pob_dob" placeholder="Bandung, 12-05-1980">
                                </div>
                                <div class="form-group">
                                    <label>Pendidikan Terakhir</label>
                                    <select name="ayah_education">
                                        <option value="SD/MI">SD/MI</option>
                                        <option value="SMP/MTs">SMP/MTs</option>
                                        <option value="SMA/MA/SMK" selected>SMA/MA/SMK</option>
                                        <option value="D3/D4">D3/D4</option>
                                        <option value="S1/S2/S3">S1/S2/S3</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Pekerjaan Ayah</label>
                                    <input type="text" name="ayah_job" placeholder="Wiraswasta / Karyawan / PNS">
                                </div>
                            </div>
                            <div class="spmb-grid-2">
                                <div class="form-group">
                                    <label>Penghasilan Per Bulan</label>
                                    <select name="ayah_income">
                                        <option value="< 1 Juta">&lt; Rp 1.000.000</option>
                                        <option value="1 - 3 Juta" selected>Rp 1.000.000 - Rp 3.000.000</option>
                                        <option value="3 - 5 Juta">Rp 3.000.000 - Rp 5.000.000</option>
                                        <option value="> 5 Juta">&gt; Rp 5.000.000</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>No. HP Ayah</label>
                                    <input type="tel" name="ayah_phone">
                                </div>
                            </div>
                        </div>

                        <div class="sub-section-box">
                            <h4>👩 Data Ibu Kandung</h4>
                            <div class="spmb-grid-2">
                                <div class="form-group">
                                    <label>Nama Ibu Kandung *</label>
                                    <input type="text" name="ibu_name" required>
                                </div>
                                <div class="form-group">
                                    <label>NIK Ibu *</label>
                                    <input type="text" name="ibu_nik" required maxlength="16">
                                </div>
                            </div>
                            <div class="spmb-grid-3">
                                <div class="form-group">
                                    <label>Tempat/Tgl Lahir Ibu</label>
                                    <input type="text" name="ibu_pob_dob" placeholder="Bandung, 18-08-1983">
                                </div>
                                <div class="form-group">
                                    <label>Pendidikan Terakhir</label>
                                    <select name="ibu_education">
                                        <option value="SD/MI">SD/MI</option>
                                        <option value="SMP/MTs">SMP/MTs</option>
                                        <option value="SMA/MA/SMK" selected>SMA/MA/SMK</option>
                                        <option value="D3/D4">D3/D4</option>
                                        <option value="S1/S2/S3">S1/S2/S3</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Pekerjaan Ibu</label>
                                    <input type="text" name="ibu_job" placeholder="Ibu Rumah Tangga / Wiraswasta">
                                </div>
                            </div>
                            <div class="spmb-grid-2">
                                <div class="form-group">
                                    <label>Penghasilan Per Bulan</label>
                                    <select name="ibu_income">
                                        <option value="Tidak Berpenghasilan" selected>Tidak Berpenghasilan / IRT</option>
                                        <option value="< 1 Juta">&lt; Rp 1.000.000</option>
                                        <option value="1 - 3 Juta">Rp 1.000.000 - Rp 3.000.000</option>
                                        <option value="> 3 Juta">&gt; Rp 3.000.000</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>No. HP Ibu</label>
                                    <input type="tel" name="ibu_phone">
                                </div>
                            </div>
                        </div>

                        <div class="sub-section-box">
                            <div class="form-group">
                                <label><input type="checkbox" name="has_wali" id="toggle_wali_check" value="1"> Apakah Calon Murid Memiliki Wali (Selain Orang Tua Kandung)?</label>
                            </div>
                            <div id="wali_fields_box" style="display:none; margin-top:15px;">
                                <h4>👴 Data Wali</h4>
                                <div class="spmb-grid-2">
                                    <div class="form-group"><label>Nama Wali</label><input type="text" name="wali_name"></div>
                                    <div class="form-group"><label>NIK Wali</label><input type="text" name="wali_nik"></div>
                                </div>
                                <div class="spmb-grid-2">
                                    <div class="form-group"><label>Pekerjaan Wali</label><input type="text" name="wali_job"></div>
                                    <div class="form-group"><label>No. HP Wali</label><input type="tel" name="wali_phone"></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-nav-buttons">
                            <button type="button" class="spmb-btn spmb-btn-outline btn-prev-step" data-prev="1">⬅️ Kembali</button>
                            <button type="button" class="spmb-btn spmb-btn-primary btn-next-step" data-next="3">Lanjut ke Data Sekolah ➡️</button>
                        </div>
                    </div>

                    <!-- STEP 3: SEKOLAH ASAL -->
                    <div class="spmb-form-step step-pane-3">
                        <div class="spmb-form-section-title">
                            <h3>03. Data Sekolah Asal (SD / MI)</h3>
                        </div>

                        <div class="form-group">
                            <label>Nama Sekolah Asal *</label>
                            <input type="text" name="school_origin" required placeholder="misal: SD Negeri 1 Cileunyi / MI Asy-Syuhada">
                        </div>

                        <div class="spmb-grid-2">
                            <div class="form-group">
                                <label>NPSN Sekolah Asal (jika ada)</label>
                                <input type="text" name="school_npsn" placeholder="8 Digit NPSN">
                            </div>
                        </div>

                        <div class="form-nav-buttons">
                            <button type="button" class="spmb-btn spmb-btn-outline btn-prev-step" data-prev="2">⬅️ Kembali</button>
                            <button type="button" class="spmb-btn spmb-btn-primary btn-next-step" data-next="4">Lanjut ke Upload Berkas ➡️</button>
                        </div>
                    </div>

                    <!-- STEP 4: UPLOAD DOKUMEN -->
                    <div class="spmb-form-step step-pane-4">
                        <div class="spmb-form-section-title">
                            <h3>04. Unggah Dokumen Persyaratan</h3>
                            <p>Format yang diperbolehkan & batasan ukuran tertera pada masing-masing field file.</p>
                        </div>

                        <?php foreach ($requirements as $req): ?>
                            <div class="file-upload-card">
                                <div class="upload-card-header">
                                    <strong><?php echo esc_html($req['title']); ?></strong>
                                    <?php echo $req['is_required'] ? '<span class="tag-req">Wajib</span>' : '<span class="tag-opt">Opsional</span>'; ?>
                                </div>
                                <p class="upload-card-desc"><?php echo esc_html($req['description']); ?></p>
                                <input type="file" name="doc_<?php echo $req['id']; ?>" class="spmb-file-input" data-req-title="<?php echo esc_attr($req['title']); ?>" data-max-size="<?php echo $req['max_size_mb']; ?>" data-formats="<?php echo esc_attr($req['allowed_formats']); ?>" <?php echo $req['is_required'] ? 'required' : ''; ?>>
                                <div class="file-hint">Format: <?php echo esc_html($req['allowed_formats']); ?> | Max: <?php echo $req['max_size_mb']; ?>MB</div>
                            </div>
                        <?php endforeach; ?>

                        <div class="form-nav-buttons">
                            <button type="button" class="spmb-btn spmb-btn-outline btn-prev-step" data-prev="3">⬅️ Kembali</button>
                            <button type="button" class="spmb-btn spmb-btn-primary btn-next-step" data-next="5" id="btn-goto-review">Periksa Rangkuman ➡️</button>
                        </div>
                    </div>

                    <!-- STEP 5: REVIEW & SUBMIT -->
                    <div class="spmb-form-step step-pane-5">
                        <div class="spmb-form-section-title">
                            <h3>05. Periksa Kembali Data Pendaftaran Anda</h3>
                            <p>Pastikan seluruh data yang Anda masukkan sudah tepat dan jujur sebelum dikirim.</p>
                        </div>

                        <div id="spmb-review-container" class="spmb-review-box">
                            <!-- Populated via JS -->
                        </div>

                        <div class="spmb-declaration-box">
                            <label>
                                <input type="checkbox" name="declaration_agree" id="declaration_agree" required>
                                <strong>Saya menyatakan bahwa seluruh data dan berkas dokumen yang saya masukkan adalah BENAR dan SAH. Apabila dikemudian hari ditemukan ketidaksesuaian, saya bersedia menerima keputusan panitia.</strong>
                            </label>
                        </div>

                        <div class="form-nav-buttons">
                            <button type="button" class="spmb-btn spmb-btn-outline btn-prev-step" data-prev="4">⬅️ Edit Kembali</button>
                            <button type="submit" id="spmb-btn-submit-form" class="spmb-btn spmb-btn-success spmb-btn-lg">🚀 Kirim Pendaftaran Sekarang</button>
                        </div>
                    </div>
                </form>

                <!-- STEP 6: SUCCESS SCREEN -->
                <div id="spmb-success-screen" class="spmb-success-card" style="display:none;">
                    <div class="success-icon">🎉</div>
                    <h2>Pendaftaran Berhasil Dikirim!</h2>
                    <p>Terima kasih, data pendaftaran murid baru Anda telah resmi terdaftar di database kami.</p>

                    <div class="reg-no-highlight">
                        <span>NOMOR PENDAFTARAN ANDA:</span>
                        <h1 id="success-reg-no">SPMB-2026-000000</h1>
                    </div>

                    <div class="success-instructions">
                        <h4>📌 Catatan Penting untuk Calon Wali Murid:</h4>
                        <ol>
                            <li>Mohon <strong>CATAT atau SIMPAN</strong> Nomor Pendaftaran Anda di atas.</li>
                            <li>Panitia SPMB akan menguji keabsahan berkas yang diunggah.</li>
                            <li>Hasil pengumuman seleksi dapat dicek secara berkala pada menu <a href="<?php echo home_url('/spmb-hasil-seleksi/'); ?>">Lihat Hasil Seleksi</a>.</li>
                        </ol>
                    </div>

                    <div class="success-actions">
                        <button type="button" onclick="window.print()" class="spmb-btn spmb-btn-outline">🖨️ Cetak / Simpan Bukti Pendaftaran</button>
                        <a href="<?php echo home_url('/spmb/'); ?>" class="spmb-btn spmb-btn-primary">🏠 Kembali ke Beranda SPMB</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    // 3. SELECTION RESULTS SHORTCODE: [spmb_selection_results]
    public function render_selection_results() {
        $is_published = get_option('spmb_selection_published', 0);
        $settings = get_option('spmb_settings', []);
        $period_year = $settings['period_year'] ?? '2026/2027';

        ob_start();
        ?>
        <div class="spmb-public-container">
            <div class="spmb-result-wrapper">
                <div class="spmb-result-header">
                    <h2>Pengumuman Hasil Seleksi SPMB</h2>
                    <p>Tahun Pelajaran <?php echo esc_html($period_year); ?></p>
                </div>

                <?php if (!$is_published): ?>
                    <div class="spmb-result-unpublished">
                        <div class="unpub-icon">⏳</div>
                        <h3>Hasil Seleksi Belum Dipublikasikan</h3>
                        <p>Panitia SPMB saat ini masih dalam tahap proses evaluasi dan verifikasi berkas seleksi calon murid baru. Pengumuman kelulusan akan dipublikasikan secara resmi sesuai jadwal yang telah ditentukan.</p>
                        <a href="<?php echo home_url('/spmb/'); ?>" class="spmb-btn spmb-btn-primary">⬅️ Lihat Jadwal & Informasi SPMB</a>
                    </div>
                <?php else: ?>
                    <!-- Search Box -->
                    <div class="spmb-result-search-box">
                        <h3>Cek Status Kelulusan Anda</h3>
                        <p>Masukkan Nomor Pendaftaran (contoh: <code>SPMB-2026-000001</code>) atau Nama Lengkap Calon Siswa:</p>
                        
                        <form id="spmb-search-result-form" class="spmb-search-form">
                            <input type="text" id="search_query" required placeholder="Ketik No. Pendaftaran atau Nama..." class="spmb-search-input">
                            <button type="submit" class="spmb-btn spmb-btn-primary">🔍 Cari Hasil Seleksi</button>
                        </form>
                    </div>

                    <div id="spmb-search-results-container" class="spmb-results-output">
                        <!-- Ajax populated -->
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    // PUBLIC AJAX: Submit Registration
    public function ajax_submit_registration() {
        check_ajax_referer('spmb_public_nonce', 'nonce');

        $settings = get_option('spmb_settings', []);
        if (empty($settings['registration_active'])) {
            wp_send_json_error('Pendaftaran saat ini sedang ditutup.');
        }

        global $wpdb;
        $table_app = SPMB_DB::get_table_applicants();
        $table_doc = SPMB_DB::get_table_documents();
        $table_req = SPMB_DB::get_table_requirements();

        $reg_no = SPMB_DB::generate_reg_no();
        $year_period = $settings['period_year'] ?? '2026/2027';

        $applicant_data = [
            'reg_no' => $reg_no,
            'year_period' => $year_period,
            'nisn' => sanitize_text_field($_POST['nisn'] ?? ''),
            'nik' => sanitize_text_field($_POST['nik'] ?? ''),
            'full_name' => sanitize_text_field($_POST['full_name'] ?? ''),
            'nickname' => sanitize_text_field($_POST['nickname'] ?? ''),
            'pob' => sanitize_text_field($_POST['pob'] ?? ''),
            'dob' => !empty($_POST['dob']) ? sanitize_text_field($_POST['dob']) : null,
            'gender' => sanitize_text_field($_POST['gender'] ?? 'L'),
            'religion' => sanitize_text_field($_POST['religion'] ?? 'Islam'),
            'address' => sanitize_textarea_field($_POST['address'] ?? ''),
            'rt_rw' => sanitize_text_field($_POST['rt_rw'] ?? ''),
            'kelurahan' => sanitize_text_field($_POST['kelurahan'] ?? ''),
            'kecamatan' => sanitize_text_field($_POST['kecamatan'] ?? ''),
            'city' => sanitize_text_field($_POST['city'] ?? ''),
            'province' => sanitize_text_field($_POST['province'] ?? ''),
            'kk_no' => sanitize_text_field($_POST['kk_no'] ?? ''),
            'phone' => sanitize_text_field($_POST['phone'] ?? ''),
            'email' => sanitize_email($_POST['email'] ?? ''),
            'school_origin' => sanitize_text_field($_POST['school_origin'] ?? ''),
            'school_npsn' => sanitize_text_field($_POST['school_npsn'] ?? ''),
            'ayah_name' => sanitize_text_field($_POST['ayah_name'] ?? ''),
            'ayah_nik' => sanitize_text_field($_POST['ayah_nik'] ?? ''),
            'ayah_pob_dob' => sanitize_text_field($_POST['ayah_pob_dob'] ?? ''),
            'ayah_education' => sanitize_text_field($_POST['ayah_education'] ?? ''),
            'ayah_job' => sanitize_text_field($_POST['ayah_job'] ?? ''),
            'ayah_income' => sanitize_text_field($_POST['ayah_income'] ?? ''),
            'ayah_phone' => sanitize_text_field($_POST['ayah_phone'] ?? ''),
            'ibu_name' => sanitize_text_field($_POST['ibu_name'] ?? ''),
            'ibu_nik' => sanitize_text_field($_POST['ibu_nik'] ?? ''),
            'ibu_pob_dob' => sanitize_text_field($_POST['ibu_pob_dob'] ?? ''),
            'ibu_education' => sanitize_text_field($_POST['ibu_education'] ?? ''),
            'ibu_job' => sanitize_text_field($_POST['ibu_job'] ?? ''),
            'ibu_income' => sanitize_text_field($_POST['ibu_income'] ?? ''),
            'ibu_phone' => sanitize_text_field($_POST['ibu_phone'] ?? ''),
            'has_wali' => !empty($_POST['has_wali']) ? 1 : 0,
            'wali_name' => sanitize_text_field($_POST['wali_name'] ?? ''),
            'wali_nik' => sanitize_text_field($_POST['wali_nik'] ?? ''),
            'wali_job' => sanitize_text_field($_POST['wali_job'] ?? ''),
            'wali_phone' => sanitize_text_field($_POST['wali_phone'] ?? ''),
            'status' => 'Baru',
            'registration_date' => current_time('mysql')
        ];

        $inserted = $wpdb->insert($table_app, $applicant_data);
        if (!$inserted) {
            wp_send_json_error('Gagal menyimpan data pendaftaran. Silakan coba kembali.');
        }

        $applicant_id = $wpdb->insert_id;

        // Process Document Uploads
        $requirements = $wpdb->get_results("SELECT * FROM $table_req", ARRAY_A);
        $upload_dir = wp_upload_dir();
        $target_dir = $upload_dir['basedir'] . '/spmb_docs/' . date('Y') . '/';
        $target_url = $upload_dir['baseurl'] . '/spmb_docs/' . date('Y') . '/';

        if (!file_exists($target_dir)) {
            wp_mkdir_p($target_dir);
            // Create security htaccess inside spmb_docs
            @file_put_contents($upload_dir['basedir'] . '/spmb_docs/.htaccess', "Options -Indexes\n<FilesMatch \"\.(php|php5|phtml|php7|phps)$\">\nOrder Deny,Allow\nDeny from all\n</FilesMatch>");
        }

        foreach ($requirements as $req) {
            $field_key = 'doc_' . $req['id'];
            if (!empty($_FILES[$field_key]['name'])) {
                $file = $_FILES[$field_key];
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $allowed = array_map('trim', explode(',', strtolower($req['allowed_formats'])));

                if (!in_array($ext, $allowed)) {
                    continue;
                }

                if ($file['size'] > ($req['max_size_mb'] * 1024 * 1024)) {
                    continue;
                }

                $safe_filename = $reg_no . '_' . sanitize_file_name($req['title']) . '_' . time() . '.' . $ext;
                $dest_path = $target_dir . $safe_filename;
                $dest_url = $target_url . $safe_filename;

                if (move_uploaded_file($file['tmp_name'], $dest_path)) {
                    $wpdb->insert($table_doc, [
                        'applicant_id' => $applicant_id,
                        'req_id' => $req['id'],
                        'doc_title' => $req['title'],
                        'file_name' => $file['name'],
                        'file_path' => $dest_path,
                        'file_url' => $dest_url,
                        'file_size' => $file['size'],
                        'file_type' => $file['type'],
                        'status' => 'Menunggu'
                    ]);
                }
            }
        }

        // Send Email Notifications
        SPMB_Emailer::send_registration_confirmation($applicant_data);
        SPMB_Emailer::send_admin_alert($applicant_data);

        wp_send_json_success([
            'reg_no' => $reg_no,
            'full_name' => $applicant_data['full_name']
        ]);
    }

    // PUBLIC AJAX: Search Selection Results
    public function ajax_search_selection() {
        check_ajax_referer('spmb_public_nonce', 'nonce');
        $query = sanitize_text_field($_POST['query'] ?? '');

        if (strlen($query) < 3) {
            wp_send_json_error('Kata kunci pencarian minimal 3 karakter.');
        }

        global $wpdb;
        $table_app = SPMB_DB::get_table_applicants();
        $table_sel = SPMB_DB::get_table_selection();

        $sql = $wpdb->prepare(
            "SELECT a.reg_no, a.full_name, a.school_origin, COALESCE(s.status, a.status) as sel_status, s.notes
             FROM $table_app a
             LEFT JOIN $table_sel s ON a.id = s.applicant_id
             WHERE a.reg_no LIKE %s OR a.full_name LIKE %s
             ORDER BY a.id DESC LIMIT 10",
            "%$query%", "%$query%"
        );

        $results = $wpdb->get_results($sql, ARRAY_A);

        if (empty($results)) {
            wp_send_json_success([
                'html' => "<div class='spmb-no-result'>⚠️ Data pendaftaran dengan nomor atau nama <strong>'" . esc_html($query) . "'</strong> tidak ditemukan. Pastikan Anda memasukkan nomor/nama dengan benar.</div>"
            ]);
        }

        ob_start();
        ?>
        <div class="spmb-results-card">
            <h4>Hasil Pencarian (<?php echo count($results); ?> Ditemukan):</h4>
            <table class="spmb-public-table">
                <thead>
                    <tr>
                        <th>No. Pendaftaran</th>
                        <th>Nama Calon Siswa</th>
                        <th>Asal Sekolah</th>
                        <th>Status Kelulusan</th>
                        <th>Catatan Panitia</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $res): ?>
                        <tr>
                            <td><strong><?php echo esc_html($res['reg_no']); ?></strong></td>
                            <td><?php echo esc_html($res['full_name']); ?></td>
                            <td><?php echo esc_html($res['school_origin']); ?></td>
                            <td>
                                <span class="spmb-result-pill pill-<?php echo sanitize_title($res['sel_status']); ?>">
                                    <?php echo esc_html($res['sel_status']); ?>
                                </span>
                            </td>
                            <td><?php echo !empty($res['notes']) ? esc_html($res['notes']) : '-'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php
        $html = ob_get_clean();
        wp_send_json_success(['html' => $html]);
    }
}
