<?php
if (!defined('ABSPATH')) {
    exit;
}

class SPMB_DB {
    
    public static function get_table_applicants() {
        global $wpdb;
        return $wpdb->prefix . 'spmb_applicants';
    }

    public static function get_table_documents() {
        global $wpdb;
        return $wpdb->prefix . 'spmb_documents';
    }

    public static function get_table_requirements() {
        global $wpdb;
        return $wpdb->prefix . 'spmb_requirements';
    }

    public static function get_table_schedule() {
        global $wpdb;
        return $wpdb->prefix . 'spmb_schedule';
    }

    public static function get_table_selection() {
        global $wpdb;
        return $wpdb->prefix . 'spmb_selection';
    }

    public static function init_db() {
        global $wpdb;
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        $charset_collate = $wpdb->get_charset_collate();

        // 1. Applicants Table
        $table_applicants = self::get_table_applicants();
        $sql_applicants = "CREATE TABLE $table_applicants (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            reg_no varchar(50) NOT NULL,
            year_period varchar(20) NOT NULL DEFAULT '2026/2027',
            nisn varchar(20) DEFAULT '',
            nik varchar(20) DEFAULT '',
            full_name varchar(150) NOT NULL,
            nickname varchar(50) DEFAULT '',
            pob varchar(100) DEFAULT '',
            dob date DEFAULT NULL,
            gender enum('L', 'P') NOT NULL DEFAULT 'L',
            religion varchar(50) DEFAULT 'Islam',
            address text DEFAULT NULL,
            rt_rw varchar(20) DEFAULT '',
            kelurahan varchar(100) DEFAULT '',
            kecamatan varchar(100) DEFAULT '',
            city varchar(100) DEFAULT '',
            province varchar(100) DEFAULT '',
            kk_no varchar(20) DEFAULT '',
            phone varchar(30) DEFAULT '',
            email varchar(100) DEFAULT '',
            school_origin varchar(150) DEFAULT '',
            school_npsn varchar(20) DEFAULT '',
            ayah_name varchar(150) DEFAULT '',
            ayah_nik varchar(20) DEFAULT '',
            ayah_pob_dob varchar(100) DEFAULT '',
            ayah_education varchar(50) DEFAULT '',
            ayah_job varchar(100) DEFAULT '',
            ayah_income varchar(100) DEFAULT '',
            ayah_phone varchar(30) DEFAULT '',
            ibu_name varchar(150) DEFAULT '',
            ibu_nik varchar(20) DEFAULT '',
            ibu_pob_dob varchar(100) DEFAULT '',
            ibu_education varchar(50) DEFAULT '',
            ibu_job varchar(100) DEFAULT '',
            ibu_income varchar(100) DEFAULT '',
            ibu_phone varchar(30) DEFAULT '',
            has_wali tinyint(1) NOT NULL DEFAULT 0,
            wali_name varchar(150) DEFAULT '',
            wali_nik varchar(20) DEFAULT '',
            wali_pob_dob varchar(100) DEFAULT '',
            wali_education varchar(50) DEFAULT '',
            wali_job varchar(100) DEFAULT '',
            wali_income varchar(100) DEFAULT '',
            wali_phone varchar(30) DEFAULT '',
            status varchar(50) NOT NULL DEFAULT 'Baru',
            is_docs_complete tinyint(1) NOT NULL DEFAULT 0,
            admin_note text DEFAULT NULL,
            registration_date datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY  (id),
            UNIQUE KEY reg_no (reg_no),
            KEY status (status),
            KEY full_name (full_name)
        ) $charset_collate;";
        dbDelta($sql_applicants);

        // 2. Documents Table
        $table_documents = self::get_table_documents();
        $sql_documents = "CREATE TABLE $table_documents (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            applicant_id bigint(20) NOT NULL,
            req_id bigint(20) DEFAULT 0,
            doc_title varchar(150) NOT NULL,
            file_name varchar(255) NOT NULL,
            file_path varchar(255) NOT NULL,
            file_url varchar(255) NOT NULL,
            file_size bigint(20) DEFAULT 0,
            file_type varchar(100) DEFAULT '',
            status varchar(30) NOT NULL DEFAULT 'Menunggu',
            admin_note text DEFAULT NULL,
            uploaded_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY  (id),
            KEY applicant_id (applicant_id)
        ) $charset_collate;";
        dbDelta($sql_documents);

        // 3. Requirements Table
        $table_requirements = self::get_table_requirements();
        $sql_requirements = "CREATE TABLE $table_requirements (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            title varchar(150) NOT NULL,
            description text DEFAULT NULL,
            allowed_formats varchar(100) NOT NULL DEFAULT 'pdf,jpg,jpeg,png',
            max_size_mb int(11) NOT NULL DEFAULT 2,
            is_required tinyint(1) NOT NULL DEFAULT 1,
            sort_order int(11) NOT NULL DEFAULT 0,
            PRIMARY KEY  (id)
        ) $charset_collate;";
        dbDelta($sql_requirements);

        // 4. Schedule Table
        $table_schedule = self::get_table_schedule();
        $sql_schedule = "CREATE TABLE $table_schedule (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            event_title varchar(150) NOT NULL,
            start_date date DEFAULT NULL,
            end_date date DEFAULT NULL,
            description text DEFAULT NULL,
            sort_order int(11) NOT NULL DEFAULT 0,
            PRIMARY KEY  (id)
        ) $charset_collate;";
        dbDelta($sql_schedule);

        // 5. Selection Results Table
        $table_selection = self::get_table_selection();
        $sql_selection = "CREATE TABLE $table_selection (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            applicant_id bigint(20) NOT NULL,
            status varchar(50) NOT NULL DEFAULT 'Cadangan',
            participant_no varchar(50) DEFAULT '',
            ranking int(11) DEFAULT 0,
            score varchar(20) DEFAULT '',
            notes text DEFAULT NULL,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY  (id),
            UNIQUE KEY applicant_id (applicant_id)
        ) $charset_collate;";
        dbDelta($sql_selection);

        self::seed_default_data();
    }

    public static function seed_default_data() {
        global $wpdb;

        // Seed Requirements
        $req_table = self::get_table_requirements();
        $count_req = $wpdb->get_var("SELECT COUNT(*) FROM $req_table");
        if ($count_req == 0) {
            $default_reqs = [
                ['title' => 'Kartu Keluarga (KK)', 'description' => 'Scan/Foto asli Kartu Keluarga terbaru', 'allowed_formats' => 'pdf,jpg,jpeg,png', 'max_size_mb' => 2, 'is_required' => 1, 'sort_order' => 1],
                ['title' => 'Akta Kelahiran', 'description' => 'Scan/Foto asli Akta Kelahiran calon siswa', 'allowed_formats' => 'pdf,jpg,jpeg,png', 'max_size_mb' => 2, 'is_required' => 1, 'sort_order' => 2],
                ['title' => 'KTP Orang Tua / Wali', 'description' => 'Scan KTP Ayah dan Ibu/Wali digabung 1 file/foto', 'allowed_formats' => 'pdf,jpg,jpeg,png', 'max_size_mb' => 2, 'is_required' => 1, 'sort_order' => 3],
                ['title' => 'Ijazah / SKL / Raport', 'description' => 'Scan Ijazah/Surat Keterangan Lulus dari sekolah asal', 'allowed_formats' => 'pdf,jpg,jpeg,png', 'max_size_mb' => 3, 'is_required' => 1, 'sort_order' => 4],
                ['title' => 'Pas Foto Calon Siswa (3x4)', 'description' => 'Pas foto formal terbaru dengan latar belakang merah/biru', 'allowed_formats' => 'jpg,jpeg,png', 'max_size_mb' => 2, 'is_required' => 1, 'sort_order' => 5],
                ['title' => 'Sertifikat Prestasi / Pendukung', 'description' => 'Dokumen piagam/sertifikat kejuaraan atau prestasi (Opsional)', 'allowed_formats' => 'pdf,jpg,jpeg,png', 'max_size_mb' => 5, 'is_required' => 0, 'sort_order' => 6],
            ];
            foreach ($default_reqs as $req) {
                $wpdb->insert($req_table, $req);
            }
        }

        // Seed Schedule
        $sched_table = self::get_table_schedule();
        $count_sched = $wpdb->get_var("SELECT COUNT(*) FROM $sched_table");
        if ($count_sched == 0) {
            $default_scheds = [
                ['event_title' => 'Pendaftaran Online', 'start_date' => '2026-05-01', 'end_date' => '2026-06-30', 'description' => 'Pengisian formulir pendaftaran dan upload berkas online melalui website resmi', 'sort_order' => 1],
                ['event_title' => 'Verifikasi Berkas', 'start_date' => '2026-07-01', 'end_date' => '2026-07-05', 'description' => 'Pemeriksaan dan pencocokan keabsahan berkas oleh Panitia SPMB', 'sort_order' => 2],
                ['event_title' => 'Seleksi Tes & Wawancara', 'start_date' => '2026-07-08', 'end_date' => '2026-07-10', 'description' => 'Pelaksanaan Tes Akademik, Baca Tulis Al-Qur\'an (BTQ), dan Wawancara Orang Tua', 'sort_order' => 3],
                ['event_title' => 'Pengumuman Hasil Seleksi', 'start_date' => '2026-07-15', 'end_date' => '2026-07-15', 'description' => 'Pengumuman kelulusan pendaftaran melalui sistem online website', 'sort_order' => 4],
                ['event_title' => 'Daftar Ulang', 'start_date' => '2026-07-16', 'end_date' => '2026-07-22', 'description' => 'Registrasi ulang dan penyerahan berkas fisik calon murid baru yang diterima', 'sort_order' => 5],
            ];
            foreach ($default_scheds as $sched) {
                $wpdb->insert($sched_table, $sched);
            }
        }
    }

    public static function generate_reg_no() {
        global $wpdb;
        $settings = get_option('spmb_settings', []);
        $period_year = !empty($settings['period_year']) ? substr($settings['period_year'], 0, 4) : '2026';
        
        $table = self::get_table_applicants();
        $prefix = "SPMB-{$period_year}-";

        $max_no = $wpdb->get_var($wpdb->prepare(
            "SELECT MAX(CAST(SUBSTRING_INDEX(reg_no, '-', -1) AS UNSIGNED)) FROM $table WHERE reg_no LIKE %s",
            $prefix . '%'
        ));

        $next_num = ($max_no) ? intval($max_no) + 1 : 1;
        return $prefix . str_pad($next_num, 5, '0', STR_PAD_LEFT);
    }

    public static function get_applicant_stats() {
        global $wpdb;
        $table = self::get_table_applicants();
        $today = date('Y-m-d');

        $total = $wpdb->get_var("SELECT COUNT(*) FROM $table") ?: 0;
        $today_count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table WHERE DATE(registration_date) = %s", $today)) ?: 0;
        $baru = $wpdb->get_var("SELECT COUNT(*) FROM $table WHERE status = 'Baru'") ?: 0;
        $waiting_verif = $wpdb->get_var("SELECT COUNT(*) FROM $table WHERE status = 'Menunggu Verifikasi'") ?: 0;
        $incomplete = $wpdb->get_var("SELECT COUNT(*) FROM $table WHERE status = 'Berkas Tidak Lengkap'") ?: 0;
        $verified = $wpdb->get_var("SELECT COUNT(*) FROM $table WHERE status = 'Terverifikasi'") ?: 0;
        $accepted = $wpdb->get_var("SELECT COUNT(*) FROM $table WHERE status = 'Diterima'") ?: 0;
        $rejected = $wpdb->get_var("SELECT COUNT(*) FROM $table WHERE status = 'Tidak Diterima'") ?: 0;
        $reserve = $wpdb->get_var("SELECT COUNT(*) FROM $table WHERE status = 'Cadangan'") ?: 0;

        return [
            'total' => (int)$total,
            'today' => (int)$today_count,
            'baru' => (int)$baru,
            'waiting_verif' => (int)$waiting_verif,
            'incomplete' => (int)$incomplete,
            'verified' => (int)$verified,
            'accepted' => (int)$accepted,
            'rejected' => (int)$rejected,
            'reserve' => (int)$reserve
        ];
    }

    public static function get_daily_chart_data($days = 7) {
        global $wpdb;
        $table = self::get_table_applicants();
        $data = [];
        
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table WHERE DATE(registration_date) = %s", $date)) ?: 0;
            $data[] = [
                'date' => date('d M', strtotime($date)),
                'count' => (int)$count
            ];
        }
        return $data;
    }
}
