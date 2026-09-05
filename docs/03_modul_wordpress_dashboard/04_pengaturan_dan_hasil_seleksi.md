# 🔧 MODUL PENGATURAN SISTEM & PENETAPAN HASIL SELEKSI

---

## 1. Modul Pengaturan Sistem (`WP-Admin -> SPMB -> Pengaturan`)

Modul **Pengaturan** digunakan untuk mengonfigurasi status operasional pendaftaran dan pengaturannotifikasi email.

Location Slug: `admin.php?page=spmb-settings`

### Fitur Pengaturan:

1. **Status Pendaftaran Toggle**:
   - Checkbox `🟢 Aktifkan Formulir Pendaftaran Online (Pendaftaran Dibuka)`.
   - Jika dicentang (`ON`), formulir online pada `/spmb-pendaftaran/` dapat diakses publik.
   - Jika tidak dicentang (`OFF`), formulir ditutup dan tombol *Daftar Sekarang* pada website publik berubah menjadi ter-disable secara otomatis.
2. **Periode Tahun Pelajaran**:
   - Teks penanda tahun ajaran aktif (misal: `2026/2027`). Digunakan sebagai prefix nomor pendaftaran dan header halaman publik.
3. **Rentang Tanggal Pendaftaran**:
   - Tanggal Mulai dan Tanggal Selesai pendaftaran.
4. **Pengaturan Notifikasi Email**:
   - `enable_email_notification`: Toggle pengiriman email konfirmasi otomatis ke calon siswa setelah submit.
   - `enable_admin_alert`: Toggle pengiriman email notifikasi ke admin sekolah saat ada pendaftar baru.
   - `admin_notify_email`: Alamat email penerima notifikasi admin sekolah.
   - `email_subject_student`: Subjek email konfirmasi dengan variabel placeholder `{no_pendaftaran}` dan `{nama_siswa}`.

---

## 2. Modul Penetapan & Publikasi Hasil Seleksi (`WP-Admin -> SPMB -> Hasil Seleksi`)

Modul ini digunakan oleh Panitia Seleksi untuk menetapkan kelulusan setiap pendaftar sebelum dipublikasikan ke halaman pencarian publik.

Location Slug: `admin.php?page=spmb-selection`

### A. Fitur Penetapan Kelulusan Per Siswa:
Operator dapat menginput parameter berikut pada setiap baris siswa:
- **No. Peserta / Ujian**: Nomor kartu tes peserta.
- **Peringkat (Ranking)**: Peringkat kelulusan siswa.
- **Nilai Seleksi**: Total nilai tes akademik / Rata-rata raport.
- **Status Kelulusan**: Pilihan dropdown (`Menunggu`, `🟢 Diterima`, `🔴 Tidak Diterima`, `🟡 Cadangan`).
- **Catatan Panitia**: Pesan khusus kelulusan (misal: *Lulus Seleksi Utama Gelombang 1*).

### B. Engine Global Publish / Unpublish:
Di bagian header halaman ini, terdapat tombol toggle **Publish Hasil Seleksi**:
- **Status 🔴 DISEMBUNYIKAN (Unpublished)**: Hasil seleksi masih menjadi draf internal panitia. Halaman pencarian publik `/spmb-hasil-seleksi/` akan menampilkan pesan bahwa hasil seleksi belum dirilis.
- **Status 🟢 DIPUBLIKASIKAN (Published)**: Pengumuman hasil seleksi resmi dibuka dan dapat dicari oleh publik.

---

## 3. Template HTML Email Konfirmasi Otomatis (`SPMB_Emailer`)

Saat pendaftar mengirimkan formulir online, sistem secara otomatis mengeksekusi skrip pengiriman email bermuatan HTML:

```html
<div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e2e8f0; border-radius: 12px; background-color: #ffffff;'>
    <div style='text-align: center; padding-bottom: 20px; border-bottom: 2px solid #0d5c3a;'>
        <h2 style='color: #0d5c3a; margin: 0;'>MTs Asy-Syuhada</h2>
        <p style='color: #64748b; margin: 5px 0 0 0;'>Sistem Penerimaan Murid Baru (2026/2027)</p>
    </div>
    <div style='padding: 20px 0;'>
        <h3 style='color: #1e293b;'>Pendaftaran Berhasil!</h3>
        <p>Halo <strong>Ahmad Fauzi Ridwan</strong>,</p>
        <p>Terima kasih telah melakukan pendaftaran murid baru di MTs Asy-Syuhada.</p>
        <div style='background-color: #f1f5f9; padding: 15px; border-radius: 8px; margin: 20px 0;'>
            <p><strong>Nomor Pendaftaran:</strong> <span style='font-size: 18px; color: #0d5c3a; font-weight: bold;'>SPMB-2026-000123</span></p>
        </div>
    </div>
</div>
```
