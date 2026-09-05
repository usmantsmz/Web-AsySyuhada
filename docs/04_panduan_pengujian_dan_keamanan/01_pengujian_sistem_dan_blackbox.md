# 🧪 METODOLOGI PENGUJIAN SISTEM & SKENARIO BLACK-BOX TESTING

---

## 1. Metodologi Pengujian

Pengujian modul SPMB dilakukan menggunakan metode **Black-Box Testing**, yaitu teknik pengujian perangkat lunak yang berfokus pada spesifikasi fungsionalitas sistem tanpa harus menguji alur internal struktur kode program secara langsung.

Tujuan dari pengujian ini adalah untuk memastikan seluruh masukan (input) dari calon siswa maupun administrator menghasilkan keluaran (output) yang sesuai dengan kebutuhan sistem penerimaan murid baru.

---

## 2. Tabel Skenario Pengujian Fungsional (Black-Box Test Cases)

| No | Modul / Fitur | Skenario Pengujian | Hasil Yang Diharapkan | Hasil Uji | Status |
|---|---|---|---|---|---|
| **1** | Halaman Utama (`/spmb/`) | Membuka URL `/spmb/` saat status pendaftaran AKTIF. | Menampilkan Banner, Indicator 🟢 DIBUKA, Tanggal Penting, Timeline, Persyaratan, dan Tombol *Daftar Sekarang* AKTIF. | Sesuai | **PASSED** |
| **2** | Halaman Utama (`/spmb/`) | Membuka URL `/spmb/` saat status pendaftaran INAKTIF. | Menampilkan Indicator 🔴 DITUTUP dan Tombol *Daftar Sekarang* TER-DISABLE. | Sesuai | **PASSED** |
| **3** | Form Multi-step (`/spmb-pendaftaran/`) | Mengklik tombol *Lanjut* pada Tahap 1 tanpa mengisi kolom wajib (*NISN/NIK/Nama*). | Sistem menahan navigasi ke Tahap 2, memberi highlight merah pada field kosong, dan menampilkan pesan peringatan. | Sesuai | **PASSED** |
| **4** | Form Multi-step (`/spmb-pendaftaran/`) | Mengisi seluruh Tahap 1 s/d 4 dan memeriksa Tahap 5 (*Review*). | Tabel rangkuman terisi otomatis sesuai data yang diinput pada tahap sebelumnya. | Sesuai | **PASSED** |
| **5** | Form Multi-step (`/spmb-pendaftaran/`) | Mengirim formulir tanpa mencentang Checkbox Pernyataan Keabsahan Data. | Sistem menolak submit dan meminta persetujuan keabsahan data. | Sesuai | **PASSED** |
| **6** | Form Multi-step (`/spmb-pendaftaran/`) | Mengirim formulir lengkap disertai file PDF KK & Foto PNG. | Data tersimpan ke MySQL, No. Registrasi resmi dihasilkan (misal `SPMB-2026-000001`), Layar Sukses tampil, dan email dikirim. | Sesuai | **PASSED** |
| **7** | Dashboard Admin (`WP-Admin`) | Login sebagai Admin dan membuka menu `SPMB -> Dashboard`. | Kartu KPI menampilkan angka statistik real-time dan grafik SVG 7 hari ter-render dengan sempurna. | Sesuai | **PASSED** |
| **8** | Management Pendaftar | Membuka menu `SPMB -> Pendaftar` dan mengklik tombol `Detail`. | Drawer Modal 6-Tab terbuka via AJAX menampilkan seluruh biodata, ortu, alamat, dan berkas pendaftar. | Sesuai | **PASSED** |
| **9** | Verifikasi Berkas | Mengubah status verifikasi berkas dari `Menunggu` menjadi `Valid` pada Tab Dokumen. | Status dokumen ter-update di database via AJAX tanpa memuat ulang halaman. | Sesuai | **PASSED** |
| **10**| Status Pendaftar | Mengubah status pendaftar menjadi `Diterima` dan memberikan catatan panitia. | Status pendaftar pada tabel utama ter-update menjadi badge hijau `Diterima`. | Sesuai | **PASSED** |
| **11**| Export CSV | Mengklik tombol `Export CSV / Excel` pada halaman pendaftar. | Browser otomatis mendownload file `spmb_pendaftar_YYYYMMDD_HHMMSS.csv`. | Sesuai | **PASSED** |
| **12**| Hasil Seleksi Publik | Mengakses `/spmb-hasil-seleksi/` saat status `Unpublished`. | Menampilkan pemberitahuan bahwa pengumuman belum dirilis. | Sesuai | **PASSED** |
| **13**| Hasil Seleksi Publik | Mengakses `/spmb-hasil-seleksi/` saat status `Published` dan melakukan pencarian `SPMB-2026-000001`. | Menampilkan tabel nama siswa, asal sekolah, status `Diterima`, dan catatan panitia. NIK/KK tetap disembunyikan. | Sesuai | **PASSED** |

---

## 3. Kesimpulan Pengujian

Berdasarkan 13 skenario uji coba black-box di atas, modul **SPMB** telah **100% LULUS (PASSED)** pengujian fungsional dan siap digunakan secara bebas kesalahan (*zero critical bug*) pada lingkungan produksi.
