# ⚙️ MODUL MANAJEMEN PERSYARATAN & JADWAL TIMELINE

---

## 1. Modul Manajemen Persyaratan Berkas (`WP-Admin -> SPMB -> Persyaratan`)

Modul ini memberikan fleksibilitas penuh kepada administrator sekolah untuk menambah, mengedit, menghapus, atau mengatur urutan berkas persyaratan pendaftaran tanpa perlu mengubah kode program (*no hard-coded requirements*).

Location Slug: `admin.php?page=spmb-requirements`

### Parameter Konfigurasi Persyaratan:
- **Nama Dokumen**: Nama jenis berkas (misal: *Kartu Keluarga*, *Akta Kelahiran*, *Pas Foto 3x4*).
- **Deskripsi / Petunjuk**: Instruksi cara mengunggah bagi calon siswa.
- **Format File Diizinkan**: Komposisi ekstensi berkas yang dibolehkan (misal: `pdf,jpg,jpeg,png`).
- **Maksimal Ukuran File**: Batas ukuran file dalam Megabytes (`1MB` - `10MB`).
- **Flag Required / Optional**: Menentukan apakah berkas tersebut **Wajib** diunggah atau **Opsional**.
- **Urutan Tampil**: Nomor urut posisi field pada formulir pendaftaran.

---

## 2. Modul Manajemen Jadwal & Timeline (`WP-Admin -> SPMB -> Jadwal`)

Modul ini digunakan untuk mengelola agenda kegiatan pendaftaran yang ditampilkan pada halaman utama website.

Location Slug: `admin.php?page=spmb-schedule`

### Parameter Konfigurasi Agenda:
- **Nama Kegiatan**: Judul agenda (misal: *Pendaftaran Online*, *Verifikasi Berkas*, *Seleksi Tes & Wawancara*, *Pengumuman*, *Daftar Ulang*).
- **Tanggal Mulai**: Tanggal dimulainya agenda (`YYYY-MM-DD`).
- **Tanggal Selesai**: Tanggal berakhirnya agenda (`YYYY-MM-DD`).
- **Deskripsi Kegiatan**: Penjelasan singkat alur pelaksanaan agenda.
- **Urutan Tampil**: Nomor posisi urutan timeline.

---

## 3. Eksekusi AJAX Handler Persyaratan & Jadwal

Seluruh aksi Tambah, Edit, dan Hapus pada modul ini diproses menggunakan AJAX handler yang aman:

```php
// Contoh Handler Simpan Persyaratan pada Class SPMB_Admin
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
```
