# 📊 MODUL DASHBOARD & STATISTIK SPMB (`WP-Admin -> SPMB -> Dashboard`)

---

## 1. Deskripsi Modul

Sub-menu **Dashboard SPMB** merupakan halaman utama manajemen administrasi pendaftaran murid baru di dalam WordPress Admin Dashboard. Halaman ini menyajikan indikator kinerja utama (KPI), grafik tren pendaftaran harian, serta aktivitas pendaftaran terbaru secara real-time.

Location Slug: `admin.php?page=spmb-dashboard`

---

## 2. Komponen Visual & Fungsional Dashboard

```text
+-----------------------------------------------------------------------------------+
| 🏫 Dashboard SPMB MTs Asy-Syuhada                             [🟢 Pendaftaran DIBUKA] |
| Sistem Penerimaan Murid Baru Tahun Pelajaran 2026/2027              [Kelola Status] |
+-----------------------------------------------------------------------------------+
| [👥 Total: 15] [📅 Hari Ini: 3] [⏳ Menunggu: 4] [📋 Terverifikasi: 5] [🎓 Diterima: 3] |
+------------------------------------------------------+----------------------------+
| 📈 Grafik Pendaftaran 7 Hari Terakhir (SVG Chart)    | 📥 Pendaftar Terbaru       |
|                                                      | - SPMB-2026-00001 (Fauzi)  |
|  10 |           *                                    | - SPMB-2026-00002 (Dewi)   |
|   5 |     *   *   *                                  | - SPMB-2026-00003 (Rizky)  |
|   0 +---*---*---*---*---                              | [Lihat Semua Pendaftar]   |
+------------------------------------------------------+----------------------------+
```

### A. Header Bar & Status Monitor
- Menampilkan judul resmi madrasah, periode tahun ajaran aktif, serta status pendaftaran saat ini (`🟢 DIBUKA` atau `🔴 DITUTUP`).
- Shortcut tombol `Kelola Status` menuju halaman pengaturan.

### B. Grid 6 Kartu Statistik KPI (Key Performance Indicator)
1. **Total Pendaftar**: Jumlah kumulatif pendaftar yang masuk ke database.
2. **Pendaftar Hari Ini**: Jumlah pendaftar yang melakukan submit pada tanggal berjalan (`TODAY()`).
3. **Menunggu Verifikasi**: Jumlah pendaftar bernilai status `Baru` atau `Menunggu Verifikasi`.
4. **Terverifikasi**: Jumlah pendaftar yang telah diperiksa dan dinyatakan sah berkasnya.
5. **Diterima**: Jumlah siswa yang telah ditetapkan lolos seleksi penerimaan.
6. **Cadangan**: Jumlah siswa yang berada pada status daftar tunggu / cadangan.

### C. Visualisasi Grafik Vector SVG Dynamic Chart
- Menggambarkan tren jumlah pendaftar harian dalam kurun waktu 7 hari terakhir.
- Dihasilkan secara murni menggunakan kode matematika SVG (tanpa dependensi library pihak ketiga yang berat), sehingga pemuatan halaman sangat cepat dan responsif.

### D. Tabel Pendaftar Terbaru (Quick View Table)
- Menyajikan 5 pendaftar paling baru yang masuk ke sistem.
- Dilengkapi link cepat untuk membuka modal detail pendaftar.
