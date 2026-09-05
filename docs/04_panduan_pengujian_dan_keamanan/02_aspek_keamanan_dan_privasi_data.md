# 🛡️ ANALISIS ASPEK KEAMANAN (SECURITY) & PRIVASI DATA PRIBADI

---

## 1. Pendahuluan Keamanan Informasi

Sistem Penerimaan Murid Baru (SPMB) mengelola data sensitif identitas anak di bawah umur dan identitas kependudukan orang tua (NIK, Nomor KK, Tanggal Lahir, Penghasilan, Alamat). Oleh karena itu, modul ini dibangun dengan mematuhi prinsip **Security by Design** dan OWASP Top 10 Best Practices untuk mencegah kebocoran data (*Data Breach*).

---

## 2. Lapisan Proteksi Keamanan Sistem

### 1. Proteksi CSRF (Cross-Site Request Forgery) via WordPress Nonce
Seluruh formulir publik maupun request AJAX administrator dilindungi dengan Token **WordPress Nonce** (`wp_create_nonce` dan `check_ajax_referer`):
- Endpoint Publik: Nonce `spmb_public_nonce`.
- Endpoint Admin: Nonce `spmb_admin_nonce`.
Jika request dikirim tanpa nonce valid, WordPress akan langsung membatalkan eksekusi dengan HTTP 403 Forbidden.

### 2. Pengontrolan Hak Akses (Authorization & Capability Checks)
Seluruh fungsi manajemen admin (Melihat biodata lengkap, verifikasi dokumen, ubah status, ekspor CSV) dilindungi dengan pengecekan capability hak akses peran administrator:
```php
if (!current_user_can('manage_options')) {
    wp_die('Unauthorized user access.');
}
```
Pengunjung biasa atau user tanpa peran admin tidak dapat memanggil endpoint AJAX internal.

### 3. Sanitasi Input & Escaping Output (XSS Protection)
- **Sanitasi Input**: Seluruh masukan masukan teks disaring menggunakan `sanitize_text_field()`, `sanitize_email()`, `sanitize_file_name()`, dan `sanitize_textarea_field()` sebelum disimpan ke MySQL untuk mencegah serangan **Cross-Site Scripting (XSS)** dan **SQL Injection**.
- **Escaping Output**: Setiap variabel yang ditayangkan ke antarmuka HTML dibungkus dengan `esc_html()`, `esc_attr()`, `esc_url()`, atau `esc_textarea()`.

### 4. Pencegahan SQL Injection via Prepared Statements
Interaksi basis data yang melibatkan variabel masukan pengguna selalu dieksekusi melalui **WordPress Prepared Statements API** (`$wpdb->prepare`):
```php
$sql = $wpdb->prepare(
    "SELECT * FROM $table WHERE reg_no LIKE %s OR full_name LIKE %s",
    "%$query%", "%$query%"
);
```

### 5. Keamanan Berkas Upload & Direktori Terisolasi
- **Pemeriksaan Format & Size**: File yang diunggah divalidasi ekstensi dan mimetypenyo di server.
- **Penyimpanan Terisolasi**: File diletakkan di `wp-content/uploads/spmb_docs/`.
- **Eksekusi PHP Di-block (`.htaccess`)**: Direktori `spmb_docs/` diproteksi secara otomatis dengan file `.htaccess` yang melarang eksekusi skrip `.php`, `.phtml`, atau `.phps` untuk mengantisipasi serangkaian *Remote Code Execution (RCE)*.
- **Nama File Di-obfuscate**: File diubah namanya menggunakan timestamp dan token unik agar nama berkas asli tidak dapat ditebak.

---

## 3. Perlindungan Privasi Data (Data Privacy & PDP Compliance)

| Kategori Data | Visibilitas Publik | Visibilitas Administrator | Proteksi Privasi |
|---|---|---|---|
| **NIK Siswa / OrTu** | 🔴 TIDAK TAMPIL | 🟢 TERSEDIA (Tabel Admin) | Disembunyikan total pada seluruh halaman pencarian publik. |
| **Nomor Kartu Keluarga (KK)** | 🔴 TIDAK TAMPIL | 🟢 TERSEDIA (Tabel Admin) | Disembunyikan total pada seluruh halaman publik. |
| **File Scan Berkas Dokumen** | 🔴 TIDAK TAMPIL | 🟢 TERSEDIA (Drawer Admin) | Hanya dapat diakses oleh Admin berwenang. |
| **No. HP / WhatsApp / Email** | 🔴 TIDAK TAMPIL | 🟢 TERSEDIA (Drawer Admin) | Disembunyikan dari publik untuk mencegah spamming/scamming. |
| **Nama & No. Pendaftaran** | 🟢 TAMPIL (Saat Published) | 🟢 TERSEDIA | Ditampilkan hanya jika hasil seleksi di-publish oleh admin. |
