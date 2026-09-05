# 🔎 MODUL HALAMAN PENCARIAN HASIL SELEKSI (`/spmb-hasil-seleksi/`)

---

## 1. Deskripsi & Tujuan Modul

Halaman Hasil Seleksi SPMB berfungsi sebagai **Engine Pengumuman Kelulusan Publik**. Melalui halaman ini, calon murid atau orang tua dapat mengecek hasil verifikasi dan seleksi penerimaan murid baru secara langsung dari website sekolah.

URL Akses: `http://localhost/asy-syuhada/spmb-hasil-seleksi/`  
Shortcode Handler: `[spmb_selection_results]`

---

## 2. Fitur Visibilitas Global (Publish / Unpublish Engine)

Sistem memiliki fitur kontrol visibilitas global `spmb_selection_published` yang dikendalikan oleh administrator melalui WordPress Dashboard:

- **Kondisi 1: Hasil Seleksi BELUM DIPUBLIKASIKAN (`Unpublished`)**  
  Pengunjung halaman akan melihat kartu pemberitahuan resmi bahwa panitia SPMB sedang melakukan tahap verifikasi/proses pengujian. Formulir pencarian disembunyikan untuk menjaga kerahasiaan data selama masa pengolahan nilai.
- **Kondisi 2: Hasil Seleksi SUDAH DIPUBLIKASIKAN (`Published`)**  
  Formulir pencarian interaktif ditampilkan secara otomatis.

---

## 3. Fitur Engine Pencarian (Public Search Engine)

Pencarian dilakukan secara real-time via AJAX dengan kriteria:
1. **Nomor Pendaftaran** (contoh: `SPMB-2026-000001`)
2. **Nama Lengkap Siswa** (pencarian parsial *Case-Insensitive* / `LIKE %query%`)

### Hasil Yang Ditampilkan pada Tabel Publik:
- Nomor Registrasi Pendaftaran (`reg_no`)
- Nama Lengkap Calon Siswa (`full_name`)
- Nama Sekolah Asal (`school_origin`)
- Status Kelulusan (Badge Warna: `🟢 Diterima`, `🔴 Tidak Diterima`, `🟡 Cadangan`)
- Catatan Panitia Seleksi (`notes`)

---

## 4. Perlindungan Privasi Data Pribadi (Data Privacy Protection)

Sesuai dengan regulasi perlindungan data pribadi (PDP):
- **Informasi Sensitif DISEMBUNYIKAN**: Nomor NIK Siswa, NIK Orang Tua, Nomor Kartu Keluarga (KK), Nomor Handphone, dan File Scan Berkas **TIDAK PERNAH ditayangkan pada halaman publik**.
- Hanya data identitas publik dasar (Nama, No Reg, Sekolah Asal, dan Status Kelulusan) yang dapat diakses oleh publik.

---

## 5. Script Query PHP Pencarian Hasil Seleksi

```php
public function ajax_search_selection() {
    check_ajax_referer('spmb_public_nonce', 'nonce');
    $query = sanitize_text_field($_POST['query'] ?? '');

    if (strlen($query) < 3) {
        wp_send_json_error('Kata kunci pencarian minimal 3 karakter.');
    }

    global $wpdb;
    $table_app = SPMB_DB::get_table_applicants();
    $table_sel = SPMB_DB::get_table_selection();

    // Query pencarian dengan JOIN tabel seleksi dan applicants
    $sql = $wpdb->prepare(
        "SELECT a.reg_no, a.full_name, a.school_origin, COALESCE(s.status, a.status) as sel_status, s.notes
         FROM $table_app a
         LEFT JOIN $table_sel s ON a.id = s.applicant_id
         WHERE a.reg_no LIKE %s OR a.full_name LIKE %s
         ORDER BY a.id DESC LIMIT 10",
        "%$query%", "%$query%"
    );

    $results = $wpdb->get_results($sql, ARRAY_A);
    // Format response HTML...
}
```
