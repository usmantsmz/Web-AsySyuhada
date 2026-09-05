<?php
if (!defined('ABSPATH')) {
    exit;
}

class SPMB_Emailer {

    public static function send_registration_confirmation($applicant) {
        $settings = get_option('spmb_settings', []);
        
        if (empty($settings['enable_email_notification']) || empty($applicant['email'])) {
            return false;
        }

        $to = $applicant['email'];
        $subject = !empty($settings['email_subject_student']) 
            ? str_replace(['{no_pendaftaran}', '{nama_siswa}'], [$applicant['reg_no'], $applicant['full_name']], $settings['email_subject_student'])
            : "[SPMB] Konfirmasi Pendaftaran Online - " . $applicant['reg_no'];

        $school_name = get_bloginfo('name');
        $site_url = home_url();
        $period_year = $applicant['year_period'] ?? '2026/2027';

        $body = "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e2e8f0; border-radius: 12px; background-color: #ffffff;'>
            <div style='text-align: center; padding-bottom: 20px; border-bottom: 2px solid #0d5c3a;'>
                <h2 style='color: #0d5c3a; margin: 0;'>$school_name</h2>
                <p style='color: #64748b; margin: 5px 0 0 0;'>Sistem Penerimaan Murid Baru ($period_year)</p>
            </div>

            <div style='padding: 20px 0;'>
                <h3 style='color: #1e293b;'>Pendaftaran Berhasil!</h3>
                <p>Halo <strong>" . esc_html($applicant['full_name']) . "</strong>,</p>
                <p>Terima kasih telah melakukan pendaftaran murid baru di $school_name. Formulir Anda telah berhasil kami terima.</p>

                <div style='background-color: #f1f5f9; padding: 15px; border-radius: 8px; margin: 20px 0;'>
                    <p style='margin: 5px 0;'><strong>Nomor Pendaftaran:</strong> <span style='font-size: 18px; color: #0d5c3a; font-weight: bold;'>" . esc_html($applicant['reg_no']) . "</span></p>
                    <p style='margin: 5px 0;'><strong>Nama Lengkap:</strong> " . esc_html($applicant['full_name']) . "</p>
                    <p style='margin: 5px 0;'><strong>Asal Sekolah:</strong> " . esc_html($applicant['school_origin']) . "</p>
                    <p style='margin: 5px 0;'><strong>Tanggal Daftar:</strong> " . esc_html($applicant['registration_date']) . "</p>
                </div>

                <h4 style='color: #0d5c3a; margin-top: 25px;'>Langkah Selanjutnya:</h4>
                <ol style='color: #334155; line-height: 1.6;'>
                    <li>Simpan <strong>Nomor Pendaftaran</strong> Anda di atas untuk mengecek status seleksi.</li>
                    <li>Tim seleksi SPMB kami akan melakukan pengujian dan verifikasi berkas pendaftaran Anda.</li>
                    <li>Anda dapat memantau hasil seleksi secara berkala pada menu <a href='$site_url/spmb-hasil-seleksi/' style='color: #0d5c3a; font-weight: bold;'>Hasil Seleksi SPMB</a>.</li>
                </ol>
            </div>

            <div style='text-align: center; padding-top: 20px; border-top: 1px solid #e2e8f0; color: #94a3b8; font-size: 12px;'>
                <p>Email ini dikirim secara otomatis oleh Sistem SPMB $school_name.</p>
            </div>
        </div>";

        $headers = ['Content-Type: text/html; charset=UTF-8'];
        return wp_mail($to, $subject, $body, $headers);
    }

    public static function send_admin_alert($applicant) {
        $settings = get_option('spmb_settings', []);
        
        if (empty($settings['enable_admin_alert'])) {
            return false;
        }

        $admin_email = !empty($settings['admin_notify_email']) ? $settings['admin_notify_email'] : get_option('admin_email');
        $subject = "[SPMB Alert] Pendaftar Baru: " . $applicant['reg_no'] . " - " . $applicant['full_name'];

        $body = "
        <div style='font-family: Arial, sans-serif; padding: 20px; border: 1px solid #e2e8f0; border-radius: 8px;'>
            <h3 style='color: #0d5c3a;'>Pendaftar Baru Masuk</h3>
            <p><strong>No Pendaftaran:</strong> " . esc_html($applicant['reg_no']) . "</p>
            <p><strong>Nama Lengkap:</strong> " . esc_html($applicant['full_name']) . "</p>
            <p><strong>NISN:</strong> " . esc_html($applicant['nisn']) . "</p>
            <p><strong>Asal Sekolah:</strong> " . esc_html($applicant['school_origin']) . "</p>
            <p><strong>No. HP/WA:</strong> " . esc_html($applicant['phone']) . "</p>
            <br>
            <p><a href='" . admin_url('admin.php?page=spmb-applicants&id=' . $applicant['id']) . "' style='background-color: #0d5c3a; color: #fff; padding: 10px 15px; text-decoration: none; border-radius: 5px;'>Buka Detail di WordPress Dashboard</a></p>
        </div>";

        $headers = ['Content-Type: text/html; charset=UTF-8'];
        return wp_mail($admin_email, $subject, $body, $headers);
    }
}
