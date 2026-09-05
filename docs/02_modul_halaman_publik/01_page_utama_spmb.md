# 🌐 MODUL HALAMAN UTAMA SPMB (`/spmb/`)

---

## 1. Deskripsi & Tujuan Halaman

Halaman Utama SPMB (Informasi SPMB) berfungsi sebagai **Portal Informasi Resmi Penerimaan Murid Baru MTs Asy-Syuhada**. Halaman ini didesain modern, responsif, dan elegan, menjadi gerbang utama bagi calon orang tua/wali murid untuk memahami informasi pendaftaran sebelum melakukan pengisian formulir.

URL Akses: `http://localhost/asy-syuhada/spmb/`  
Shortcode Handler: `[spmb_main_page]`

---

## 2. Struktur Komponen Visual & Informasi Halaman Utama

Halaman utama SPMB terdiri atas 6 section utama:

### 1. Hero Banner Card
- **Badge Periode**: Menampilkan teks dinamis tahun pelajaran aktif, misal `SPMB TAHUN PELAJARAN 2026/2027`.
- **Judul Halaman**: `Sistem Penerimaan Murid Baru`.
- **Live Status Indicator Badge**:
  - `🟢 PENDAFTARAN DIBUKA` (Latar hijau dengan animasi pulsing dot jika status pendaftaran aktif).
  - `🔴 PENDAFTARAN DITUTUP` (Latar merah jika status pendaftaran non-aktif).
  - `🟡 SEGERA DIBUKA` (Latar kuning jika periode pendaftaran belum masuk tanggal).
- **Tombol CTA Utama**:
  - **DAFTAR SEKARANG**: Link mengarah ke `/spmb-pendaftaran/`. Tombol ini aktif jika pendaftaran terbuka, dan ter-disable secara otomatis disertai pesan peringatan jika pendaftaran ditutup.
  - **LIHAT HASIL SELEKSI**: Link mengarah ke `/spmb-hasil-seleksi/`.

### 2. Agenda & Tanggal Penting Grid
- Menampilkan kartu-kartu jadwal kegiatan (misal: *Pendaftaran Online*, *Verifikasi Berkas*, *Seleksi Tes & Wawancara*, *Pengumuman*, *Daftar Ulang*).
- Data diambil secara dinamis dari tabel `wp_spmb_schedule` yang diatur melalui WordPress Dashboard.

### 3. Section "Tentang SPMB"
- Menjelaskan profil keunggulan pendaftaran online MTs Asy-Syuhada (transparan, 24/7, verifikasi cepat, notifikasi email).

### 4. Section "Tata Cara & Alur Pendaftaran" (7 Langkah Interaktif)
1. **Langkah 01**: Klik Tombol Daftar
2. **Langkah 02**: Isi Biodata Siswa
3. **Langkah 03**: Isi Data OrTu / Wali
4. **Langkah 04**: Upload Berkas Persyaratan
5. **Langkah 05**: Submit Pendaftaran & Verifikasi Rangkuman
6. **Langkah 06**: Simpan Nomor Pendaftaran Resmi
7. **Langkah 07**: Cek Pengumuman Hasil Seleksi

### 5. Section "Dokumen Persyaratan"
- Menampilkan kartu persyaratan dokumen secara dinamis dari tabel `wp_spmb_requirements`.
- Dilengkapi badge penanda **Wajib** / **Opsional**, format berkas yang diperbolehkan (`PDF`, `JPG`, `PNG`), serta batas maksimal ukuran file (`MB`).

### 6. Bottom Call-To-Action (CTA)
- Banner penutup bawah yang mengajak orang tua segera mendaftarkan putra-putrinya.

---

## 3. Logika PHP Rendering Status Pendaftaran

```php
$settings = get_option('spmb_settings', []);
$is_active = !empty($settings['registration_active']);
$period_year = $settings['period_year'] ?? '2026/2027';

// Kondisi tampilan tombol pendaftaran pada Halaman Utama:
if ($is_active) {
    echo '<a href="' . home_url('/spmb-pendaftaran/') . '" class="spmb-btn spmb-btn-primary spmb-btn-lg">✨ DAFTAR SEKARANG</a>';
} else {
    echo '<button type="button" class="spmb-btn spmb-btn-disabled spmb-btn-lg" disabled>🔒 DAFTAR SEKARANG (DITUTUP)</button>';
    echo '<p class="spmb-notice-closed">ℹ️ Mohon maaf, pendaftaran murid baru saat ini belum dibuka atau telah ditutup.</p>';
}
```
