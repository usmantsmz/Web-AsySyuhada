# 📚 DOKUMENTASI ANALISIS & STRUKTUR WEBSITE ACUAN (SMKN 1 CIMAHI)
**Acuan Pengembangan Web Profile Sekolah MTs Asy-Syuhada (WordPress + Astra Theme)**

---

## 📌 1. Ringkasan Analisis Teknis (Web Scraping Result)

- **URL Sumber**: [https://www.smkn1-cmi.sch.id/](https://www.smkn1-cmi.sch.id/)
- **CMS**: WordPress
- **Tema yang Digunakan (Source)**: `newspaperex` (Child theme dari `newsup` - gaya portal berita/majalah sekolah).
- **Adaptasi Target**: WordPress + **Astra Theme** (Disesuaikan untuk MTs Asy-Syuhada dengan tampilan bersih, responsif, modern, dan cepat).

---

## 🗺️ 2. Struktur Menu Navigation (Navbar Hierarchy)

Berikut adalah hirarki menu navigasi utama hasil scraping yang dapat diadopsi dan disesuaikan untuk MTs Asy-Syuhada:

### Detail Hirarki Sub-Menu:

1. **Beranda** (`/`)
2. **Profil Sekolah** (`/profil/`)
   - Sejarah Singkat (`/sejarah/`)
   - Sambutan Kepala Sekolah (`/sambutan-kepala-sekolah/`)
   - Visi & Misi (`/visi-misi/`)
   - Logo & Meaning (`/logo-sekolah/`)
   - Struktur Organisasi (`/struktur-organisasi/`)
   - Komite Sekolah (`/komite-sekolah/`)
3. **Akademik & Kurikulum** (`/akademik/`)
   - Kurikulum Pembelajaran (`/kurikulum/`)
   - Kalender Akademik (`/kalender-akademik/`)
   - Program Pembelajaran Digital (`/pembelajaran-digital/`)
4. **Keagamaan & Program Unggulan** *(Penyesuaian MTs)*
   - Program Tahfidz Al-Qur'an (`/tahfidz/`)
   - Program Kajian Islam & Kitab (`/kajian-islam/`)
   - Program Bahasa (Arab & Inggris) (`/program-bahasa/`)
5. **Kesiswaan** (`/kesiswaan/`)
   - Prestasi Siswa (`/prestasi-siswa/`)
   - Ekstrakulikuler (`/ekstrakulikuler/`)
   - Organisasi Siswa (OSIS / IPNU / IPPNU) (`/osis/`)
   - Info Beasiswa (`/beasiswa/`)
6. **GTK (Guru & Tenaga Kependidikan)** (`/gtk/`)
   - Direktori Guru (`/direktori-guru/`)
   - Tenaga Kependidikan (`/staf-tu/`)
   - Prestasi & Karya Guru (`/prestasi-guru/`)
7. **Sarana & Prasarana** (`/sarpras/`)
   - Gedung & Ruang Kelas (`/fasilitas-kelas/`)
   - Masjid & Perpustakaan (`/masjid-perpustakaan/`)
   - Lab Komputer & IPA (`/laboratorium/`)
8. **Berita & Informasi** (`/berita/`)
   - Berita Sekolah (`/category/berita-sekolah/`)
   - Pengumuman Official (`/category/pengumuman/`)
   - Agenda Kegiatan (`/category/agenda/`)
9. **PPDB / Pendaftaran** (`/ppdb/`)
   - Informasi & Syarat PPDB (`/syarat-ppdb/`)
   - Alur Pendaftaran (`/alur-ppdb/`)
   - Form Pendaftaran Online (`/form-ppdb/`)
10. **Kontak** (`/kontak/`)
    - Lokasi Google Maps, Telepon/WA, Form Pesan.

---

## 📄 3. Struktur Halaman Statis (WordPress Pages)

| No | Judul Halaman | Slug / URL | Deskripsi / Elemen Utama |
|---|---|---|---|
| 1 | **Beranda** | `/` | Hero Slider, Sambutan Ka. Sekolah, Highlights Stat, Program Unggulan, Grid Berita, Footer |
| 2 | **Sejarah Sekolah** | `/sejarah/` | Narasi pendirian madrasah, foto perintis, milestone perkembangan |
| 3 | **Visi dan Misi** | `/visi-misi/` | Poin Visi, Misi, serta Tujuan Pendidikan Madrasah |
| 4 | **Sambutan Kepala Sekolah** | `/sambutan-kepala-sekolah/` | Foto formal Kepala Sekolah + Teks Sambutan Resmi |
| 5 | **Struktur Organisasi** | `/struktur-organisasi/` | Chart / Diagram bagan organisasi pengurus & guru |
| 6 | **Ekstrakulikuler** | `/ekstrakulikuler/` | Grid Card eskul (Pramuka, PMR, Paskibra, Qiro'at, Kaligrafi, Olahraga) |
| 7 | **Fasilitas & Sarpras** | `/fasilitas/` | Galeri foto fasilitas lengkap dengan deskripsi singkat |
| 8 | **Informasi PPDB** | `/ppdb/` | Brosur digital, jadwal gelombang, syarat administrasi & tombol WhatsApp Admin PPDB |
| 9 | **Buku Tamu** | `/buku-tamu/` | Form masukan / kunjungan tamu madrasah |
| 10 | **Kontak** | `/kontak/` | Alamat lengkap, Peta Lokasi, Email, WA Center, Form kontak |

---

## 📰 4. Taksonomi Post & Kategori (WordPress Posts & Categories)

### Kategori (Categories):
- 📌 **Berita Sekolah**: Warta kegiatan harian, upacara, dan kunjungan.
- 📣 **Pengumuman**: Pengumuman libur, jadwal ujian, edaran orang tua/wali.
- 🏆 **Prestasi**: Rangkuman kejuaraan siswa/guru di bidang akademik & non-akademik.
- 🕌 **Kegiatan Keagamaan**: Wisuda Tahfidz, PHBI, Pesantren Kilat, Majlis Ta'lim.
- 🎨 **Karya Siswa**: Artikel, buletin, kaligrafi, karya literasi siswa.

### Tag (Etiket Utama):
`#PPDB2026`, `#Tahfidz`, `#PrestasiMTs`, `#EskulMTs`, `#ANBK`, `#HariSantri`, `#MadrasahHebat`.

---

## 🧩 5. Komponen Visual & Widget Kunci Hasil Scraping

1. **Header Top Bar**:
   - Running date/time & running text pengumuman (Marquee Ticker).
   - Ikon media sosial (Facebook, Instagram, YouTube, TikTok).
2. **Hero Slider & Highlight News**:
   - Banner slide besar untuk berita utama / headline prestisius.
3. **Running News Ticker (Berita Terbaru)**:
   - Teks berjalan di bawah navbar untuk update pengumuman penting secara cepat.
4. **Floating Button / Bell Notification**:
   - Akses cepat untuk info penting seperti Pendaftaran PPDB.
5. **Sidebar Widget**:
   - Widget Post Populer & Terbaru.
   - Widget Link Eksternal (Kemenag, EMIS, RDM/e-Raport).
   - Widget Calendar & Feed Instagram.

---

## 🚀 6. Panduan Implementasi pada Tema Astra (MTs Asy-Syuhada)

1. **Pengaturan Header & Navigation (Astra Header Builder)**:
   - Gunakan fitur Header Builder di Astra Customizer untuk membuat Top Bar & Main Header.
2. **Pengaturan Warna & Tipografi (Global Palette Astra)**:
   - Primary: `#0D5C3A` (Hijau Emerald Islami), Secondary: `#1E293B` (Navy), Accent: `#F59E0B` (Warm Gold).
3. **Pembangunan Layout Halaman (Gutenberg / Spectra Blocks)**:
   - Membuat template Halaman Utama (Homepage) modular.
