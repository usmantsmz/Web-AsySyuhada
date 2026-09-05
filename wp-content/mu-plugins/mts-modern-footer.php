<?php
/*
Plugin Name: MTs Asy-Syuhada Modern Bottom Footer
Description: Footer modern, bersih, profesional, dan informatif untuk MTs Asy-Syuhada dengan tipografi Outfit & Plus Jakarta Sans (Mendukung Shortcode [mts_footer_grid] & Elementor).
Version: 1.3.0
Author: MTs Asy-Syuhada Development Team
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Register Shortcode [mts_footer_grid] for Elementor & Page Builders
 */
add_shortcode('mts_footer_grid', function() {
    ob_start();
    mts_render_modern_footer();
    return ob_get_clean();
});

/**
 * Enqueue Web Fonts (Outfit & Plus Jakarta Sans) for High Quality Typography
 */
add_action('wp_enqueue_scripts', function() {
    wp_enqueue_style(
        'mts-footer-fonts',
        'https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap',
        array(),
        null
    );
});

/**
 * Remove Astra Default Footer & Hook Custom Modern Footer
 */
add_action('wp', function() {
    // If inside Elementor HFE or Elementor Custom Header/Footer plugin mode, keep clean
    remove_all_actions('astra_footer');
    add_action('astra_footer', 'mts_render_modern_footer');
});

/**
 * Render Custom Clean Professional Footer
 */
function mts_render_modern_footer() {
    $site_url = get_site_url();
    ?>
    <!-- Preconnect for fast font loading fallback -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- ================================================================= -->
    <!-- 🟢 FOOTER ELEGAN & PROFESIONAL MTS ASY-SYUHADA                    -->
    <!-- Edit bagian ini untuk menyesuaikan Logo, Alamat, Kontak, dan Link  -->
    <!-- ================================================================= -->
    <footer class="mts-site-footer" id="colophon">
        
        <div class="mts-footer-container">
            
            <!-- ------------------------------------------------------------- -->
            <!-- 1. BANNER UTAMA PPDB / SPMB (CLEAN INSTITUTIONAL CTA)         -->
            <!-- ------------------------------------------------------------- -->
            <div class="mts-footer-cta-card">
                <div class="mts-cta-content">
                    <span class="mts-cta-tag">PPDB TAHUN AJARAN 2026/2027</span>
                    <h3 class="mts-cta-title">Penerimaan Peserta Didik Baru Telah Dibuka</h3>
                    <p class="mts-cta-desc">Bergabunglah bersama MTs Asy-Syuhada untuk membentuk generasi santri yang berakhlak mulia, unggul dalam akademik, dan berwawasan digital.</p>
                </div>
                <div class="mts-cta-actions">
                    <!-- EDITABLE: LINK PPDB/SPMB -->
                    <a href="<?php echo esc_url($site_url . '/spmb/'); ?>" class="mts-btn mts-btn-primary">
                        <span>Pendaftaran Online</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    </a>
                    <!-- EDITABLE: LINK WHATSAPP CONTACT -->
                    <a href="https://wa.me/6281234567890" target="_blank" rel="noopener noreferrer" class="mts-btn mts-btn-secondary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-1.099 4.019 4.142-1.086z"/></svg>
                        <span>Hubungi Admin WA</span>
                    </a>
                </div>
            </div>

            <!-- ------------------------------------------------------------- -->
            <!-- 2. MAIN FOOTER GRID (4 KOLOM INSTITUSIONAL)                   -->
            <!-- ------------------------------------------------------------- -->
            <div class="mts-footer-grid">
                
                <!-- KOLOM 1: PROFIL MADRASAH -->
                <div class="mts-footer-col">
                    
                    <!-- ================= EDITABLE: LOGO SEKOLAH ================= -->
                    <a href="<?php echo esc_url($site_url); ?>" class="mts-footer-brand">
                        <img src="<?php echo esc_url($site_url . '/wp-content/uploads/2026/09/logo-placeholder.png'); ?>" alt="Logo MTs Asy-Syuhada" class="mts-footer-logo" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';" />
                        <div class="mts-logo-fallback-text" style="display:none;">
                            <span class="mts-brand-name">MTs Asy-Syuhada</span>
                            <span class="mts-brand-sub">Kabupaten Bandung Barat</span>
                        </div>
                    </a>
                    <!-- ========================================================= -->

                    <div class="mts-badge-box">
                        Akreditasi A BAN-S/M
                    </div>

                    <!-- ================= EDITABLE: DESKRIPSI SINGKAT ================= -->
                    <p class="mts-col-desc">
                        Lembaga Pendidikan Tsanawiyah terakreditasi A yang mengintegrasikan kurikulum nasional, pendalaman kitab kuning, dan program Tahfidz Al-Qur'an.
                    </p>
                    <!-- ================================================================ -->

                    <!-- ================= EDITABLE: MEDIA SOSIAL ================= -->
                    <div class="mts-social-links">
                        <a href="#" aria-label="Facebook" class="mts-social-btn" title="Facebook">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="#" aria-label="Instagram" class="mts-social-btn" title="Instagram">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="#" aria-label="YouTube" class="mts-social-btn" title="YouTube">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>
                        <a href="#" aria-label="TikTok" class="mts-social-btn" title="TikTok">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.28-2.42.54-4.88 2.23-6.62 1.58-1.64 3.82-2.5 6.07-2.37v4.06c-1.15-.09-2.32.27-3.17 1.05-.88.78-1.35 1.95-1.27 3.1.07 1.18.67 2.27 1.64 2.92.98.67 2.24.87 3.39.54 1.12-.31 2.05-1.16 2.45-2.24.26-.67.34-1.41.33-2.13-.01-4.89-.01-9.78-.01-14.67z"/></svg>
                        </a>
                    </div>
                    <!-- ========================================================== -->

                </div>

                <!-- KOLOM 2: NAVIGASI UTAMA -->
                <div class="mts-footer-col">
                    <h4 class="mts-col-title">NAVIGASI UTAMA</h4>
                    <!-- ================= EDITABLE: MENU LINKS ================= -->
                    <ul class="mts-nav-list">
                        <li><a href="<?php echo esc_url($site_url); ?>">Beranda</a></li>
                        <li><a href="<?php echo esc_url($site_url . '/about/'); ?>">Profil & Sejarah</a></li>
                        <li><a href="<?php echo esc_url($site_url . '/visi-misi/'); ?>">Visi, Misi & Tujuan</a></li>
                        <li><a href="<?php echo esc_url($site_url . '/akademik/'); ?>">Kurikulum Pembelajaran</a></li>
                        <li><a href="<?php echo esc_url($site_url . '/ekstrakulikuler/'); ?>">Kegiatan Kesiswaan</a></li>
                        <li><a href="<?php echo esc_url($site_url . '/galeri/'); ?>">Fasilitas Madrasah</a></li>
                        <li><a href="<?php echo esc_url($site_url . '/berita/'); ?>">Warta & Pengumuman</a></li>
                    </ul>
                    <!-- ========================================================= -->
                </div>

                <!-- KOLOM 3: PROGRAM & AKADEMIK -->
                <div class="mts-footer-col">
                    <h4 class="mts-col-title">PROGRAM & LAYANAN</h4>
                    <!-- ================= EDITABLE: PROGRAM LINKS ================= -->
                    <ul class="mts-nav-list">
                        <li><a href="<?php echo esc_url($site_url . '/spmb/'); ?>" class="mts-highlight-link">Portal SPMB Online</a></li>
                        <li><a href="#">Program Tahfidz Al-Qur'an</a></li>
                        <li><a href="#">Kajian Kitab & Keagamaan</a></li>
                        <li><a href="#">RDM (Raport Digital Madrasah)</a></li>
                        <li><a href="#">Kalender Akademik</a></li>
                        <li><a href="#">Informasi Beasiswa</a></li>
                        <li><a href="<?php echo esc_url($site_url . '/kontak/'); ?>">Layanan Buku Tamu</a></li>
                    </ul>
                    <!-- =========================================================== -->
                </div>

                <!-- KOLOM 4: KONTAK & ALAMAT SEKOLAH -->
                <div class="mts-footer-col">
                    <h4 class="mts-col-title">KONTAK & ALAMAT</h4>
                    
                    <!-- ================= EDITABLE: INFORMASI KONTAK ================= -->
                    <div class="mts-contact-block">
                        <div class="mts-contact-row">
                            <svg class="mts-icon" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            <span>Jl. Asy-Syuhada No. 12, Cililin, Kab. Bandung Barat, Jawa Barat 40756</span>
                        </div>

                        <div class="mts-contact-row">
                            <svg class="mts-icon" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/></svg>
                            <span>+62 812-3456-7890 / (022) 123-4567</span>
                        </div>

                        <div class="mts-contact-row">
                            <svg class="mts-icon" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            <span>info@mts-asysyuhada.sch.id</span>
                        </div>

                        <div class="mts-contact-row">
                            <svg class="mts-icon" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            <span>Senin - Sabtu (07.00 - 15.00 WIB)</span>
                        </div>
                    </div>
                    <!-- ============================================================== -->

                </div>

            </div>

            <!-- ------------------------------------------------------------- -->
            <!-- 3. BOTTOM BAR (COPYRIGHT & FOOTER LINKS)                      -->
            <!-- ------------------------------------------------------------- -->
            <div class="mts-footer-bottom">
                <div class="mts-copyright">
                    © <?php echo date('Y'); ?> <strong>MTs Asy-Syuhada</strong>. Hak Cipta Dilindungi Undang-Undang.
                </div>

                <div class="mts-bottom-meta">
                    <a href="#">Privasi</a>
                    <span class="mts-divider">•</span>
                    <a href="#">Syarat & Ketentuan</a>
                    <span class="mts-divider">•</span>
                    <a href="#">Peta Situs</a>
                    
                    <button type="button" id="mts-back-to-top" class="mts-top-btn" title="Kembali ke atas">
                        <span>Ke Atas</span>
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="18 15 12 9 6 15"/></svg>
                    </button>
                </div>
            </div>

        </div>
        
    </footer>

    <!-- STYLES (ENHANCED TYPOGRAPHY WITH OUTFIT & PLUS JAKARTA SANS) -->
    <style id="mts-modern-footer-css">
        .mts-site-footer {
            background-color: #0B1D15 !important;
            color: #CBD5E1 !important;
            font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
            padding: 56px 0 28px 0 !important;
            border-top: 3px solid #0D5C3A !important;
            font-size: 14px !important;
            line-height: 1.6 !important;
            -webkit-font-smoothing: antialiased !important;
            -moz-osx-font-smoothing: grayscale !important;
        }

        .mts-site-footer *, .mts-site-footer *::before, .mts-site-footer *::after {
            box-sizing: border-box !important;
        }

        .mts-footer-container {
            max-width: 1200px !important;
            margin: 0 auto !important;
            padding: 0 24px !important;
        }

        /* 1. PPDB CTA Banner */
        .mts-footer-cta-card {
            background-color: #122B20 !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            border-radius: 12px !important;
            padding: 28px 36px !important;
            margin-bottom: 48px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            gap: 24px !important;
        }

        .mts-cta-tag {
            display: inline-block !important;
            color: #EAB308 !important;
            font-family: 'Outfit', 'Plus Jakarta Sans', sans-serif !important;
            font-size: 11.5px !important;
            font-weight: 700 !important;
            letter-spacing: 1.2px !important;
            text-transform: uppercase !important;
            margin-bottom: 6px !important;
        }

        .mts-cta-title {
            color: #FFFFFF !important;
            font-family: 'Outfit', 'Plus Jakarta Sans', sans-serif !important;
            font-size: 23px !important;
            font-weight: 700 !important;
            margin: 0 0 6px 0 !important;
            letter-spacing: -0.3px !important;
        }

        .mts-cta-desc {
            color: #94A3B8 !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            font-size: 13.5px !important;
            font-weight: 400 !important;
            margin: 0 !important;
            max-width: 620px !important;
        }

        .mts-cta-actions {
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
            flex-shrink: 0 !important;
        }

        .mts-btn {
            display: inline-flex !important;
            align-items: center !important;
            gap: 8px !important;
            padding: 10px 20px !important;
            border-radius: 8px !important;
            font-family: 'Outfit', 'Plus Jakarta Sans', sans-serif !important;
            font-size: 13.5px !important;
            font-weight: 600 !important;
            text-decoration: none !important;
            transition: background-color 0.2s ease, border-color 0.2s ease !important;
            cursor: pointer !important;
            white-space: nowrap !important;
        }

        .mts-btn-primary {
            background-color: #0D5C3A !important;
            color: #FFFFFF !important;
            border: 1px solid #0D5C3A !important;
        }

        .mts-btn-primary:hover {
            background-color: #09472C !important;
            border-color: #09472C !important;
            color: #FFFFFF !important;
        }

        .mts-btn-secondary {
            background-color: transparent !important;
            color: #E2E8F0 !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
        }

        .mts-btn-secondary:hover {
            background-color: rgba(255, 255, 255, 0.06) !important;
            border-color: rgba(255, 255, 255, 0.35) !important;
            color: #FFFFFF !important;
        }

        /* 2. Main Grid */
        .mts-footer-grid {
            display: grid !important;
            grid-template-columns: 2fr 1.3fr 1.4fr 1.8fr !important;
            gap: 36px !important;
            padding-bottom: 44px !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
        }

        .mts-footer-col {
            display: flex !important;
            flex-direction: column !important;
        }

        .mts-footer-brand {
            display: inline-block !important;
            margin-bottom: 12px !important;
            text-decoration: none !important;
        }

        .mts-footer-logo {
            max-height: 48px !important;
            width: auto !important;
        }

        .mts-brand-name {
            display: block !important;
            color: #FFFFFF !important;
            font-family: 'Outfit', 'Plus Jakarta Sans', sans-serif !important;
            font-size: 19px !important;
            font-weight: 700 !important;
            letter-spacing: -0.2px !important;
        }

        .mts-brand-sub {
            display: block !important;
            color: #64748B !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            font-size: 12px !important;
            font-weight: 500 !important;
        }

        .mts-badge-box {
            display: inline-block !important;
            background-color: rgba(13, 92, 58, 0.25) !important;
            border: 1px solid rgba(13, 92, 58, 0.5) !important;
            color: #4ADE80 !important;
            font-family: 'Outfit', 'Plus Jakarta Sans', sans-serif !important;
            font-size: 11.5px !important;
            font-weight: 600 !important;
            letter-spacing: 0.4px !important;
            padding: 3px 10px !important;
            border-radius: 4px !important;
            width: fit-content !important;
            margin-bottom: 14px !important;
        }

        .mts-col-desc {
            color: #94A3B8 !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            font-size: 13.5px !important;
            font-weight: 400 !important;
            margin: 0 0 18px 0 !important;
        }

        /* Social Icons */
        .mts-social-links {
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
        }

        .mts-social-btn {
            width: 34px !important;
            height: 34px !important;
            border-radius: 6px !important;
            background-color: rgba(255, 255, 255, 0.04) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            color: #94A3B8 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            text-decoration: none !important;
            transition: color 0.2s ease, border-color 0.2s ease !important;
        }

        .mts-social-btn:hover {
            color: #FFFFFF !important;
            border-color: #0D5C3A !important;
            background-color: #0D5C3A !important;
        }

        /* Titles */
        .mts-col-title {
            color: #FFFFFF !important;
            font-family: 'Outfit', 'Plus Jakarta Sans', sans-serif !important;
            font-size: 13px !important;
            font-weight: 700 !important;
            letter-spacing: 1px !important;
            text-transform: uppercase !important;
            margin: 0 0 16px 0 !important;
            padding-bottom: 8px !important;
            border-bottom: 2px solid #0D5C3A !important;
            width: fit-content !important;
        }

        /* Nav List */
        .mts-nav-list {
            list-style: none !important;
            padding: 0 !important;
            margin: 0 !important;
            display: flex !important;
            flex-direction: column !important;
            gap: 9px !important;
        }

        .mts-nav-list li a {
            color: #94A3B8 !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            font-size: 13.5px !important;
            font-weight: 500 !important;
            text-decoration: none !important;
            transition: color 0.2s ease !important;
        }

        .mts-nav-list li a:hover {
            color: #38BDF8 !important;
        }

        .mts-highlight-link {
            color: #EAB308 !important;
            font-weight: 600 !important;
        }

        /* Contact Block */
        .mts-contact-block {
            display: flex !important;
            flex-direction: column !important;
            gap: 12px !important;
        }

        .mts-contact-row {
            display: flex !important;
            align-items: flex-start !important;
            gap: 10px !important;
            color: #94A3B8 !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            font-size: 13.5px !important;
            font-weight: 400 !important;
        }

        .mts-icon {
            color: #0D5C3A !important;
            flex-shrink: 0 !important;
            margin-top: 3px !important;
        }

        /* 3. Bottom Bar */
        .mts-footer-bottom {
            padding-top: 24px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            flex-wrap: wrap !important;
            gap: 16px !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            font-size: 13px !important;
            color: #64748B !important;
        }

        .mts-copyright strong {
            color: #CBD5E1 !important;
            font-weight: 600 !important;
        }

        .mts-bottom-meta {
            display: flex !important;
            align-items: center !important;
            gap: 10px !important;
        }

        .mts-bottom-meta a {
            color: #64748B !important;
            font-weight: 500 !important;
            text-decoration: none !important;
            transition: color 0.2s ease !important;
        }

        .mts-bottom-meta a:hover {
            color: #94A3B8 !important;
        }

        .mts-divider {
            color: #334155 !important;
        }

        .mts-top-btn {
            background-color: transparent !important;
            border: 1px solid rgba(255, 255, 255, 0.12) !important;
            color: #94A3B8 !important;
            padding: 4px 10px !important;
            border-radius: 4px !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            font-size: 12px !important;
            font-weight: 600 !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 4px !important;
            cursor: pointer !important;
            transition: color 0.2s ease, border-color 0.2s ease !important;
            margin-left: 6px !important;
        }

        .mts-top-btn:hover {
            color: #FFFFFF !important;
            border-color: rgba(255, 255, 255, 0.3) !important;
        }

        /* RESPONSIVE DESIGN */
        @media (max-width: 992px) {
            .mts-footer-grid {
                grid-template-columns: 1fr 1fr !important;
                gap: 32px !important;
            }

            .mts-footer-cta-card {
                flex-direction: column !important;
                align-items: flex-start !important;
                padding: 24px !important;
            }

            .mts-cta-actions {
                width: 100% !important;
            }

            .mts-btn {
                flex: 1 !important;
                justify-content: center !important;
            }
        }

        @media (max-width: 600px) {
            .mts-site-footer {
                padding: 36px 0 20px 0 !important;
            }

            .mts-footer-grid {
                grid-template-columns: 1fr !important;
                gap: 28px !important;
            }

            .mts-cta-title {
                font-size: 19px !important;
            }

            .mts-cta-actions {
                flex-direction: column !important;
            }

            .mts-btn {
                width: 100% !important;
            }

            .mts-footer-bottom {
                flex-direction: column !important;
                align-items: flex-start !important;
            }
        }
    </style>

    <!-- BACK TO TOP SCRIPT -->
    <script id="mts-back-to-top-js">
    document.addEventListener("DOMContentLoaded", function() {
        var btn = document.getElementById("mts-back-to-top");
        if (btn) {
            btn.addEventListener("click", function() {
                window.scrollTo({
                    top: 0,
                    behavior: "smooth"
                });
            });
        }
    });
    </script>
    <?php
}
