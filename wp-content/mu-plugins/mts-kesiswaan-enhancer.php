<?php
/*
Plugin Name: MTs Asy-Syuhada Kesiswaan & Ekstrakurikuler Enhancer
Description: Memperbarui bagian Kesiswaan & Ekstrakurikuler di Beranda dengan desain institusional modern yang 100% tampil & mendukung Elementor Editor & Shortcode [mts_kesiswaan_grid].
Version: 1.5.0
Author: MTs Asy-Syuhada Development Team
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Shortcode [mts_kesiswaan_grid] for Direct Use in Elementor & Page Builders
 */
add_shortcode('mts_kesiswaan_grid', 'mts_render_kesiswaan_grid_html');

function mts_render_kesiswaan_grid_html() {
    ob_start();
    ?>
    <div id="kesiswaan-ekstrakurikuler-wrapper" class="mts-kesiswaan-wrapper-node">
        <section class="mts-kesiswaan-section" id="kesiswaan-ekstrakurikuler">
            <div class="mts-kesiswaan-container">
                
                <div class="mts-kesiswaan-header">
                    <span class="mts-section-badge">KESISWAAN & EKSTRAKURIKULER</span>
                    <h2 class="mts-section-title">Pengembangan Bakat, Karakter & Prestasi Santri</h2>
                    <p class="mts-section-subtitle">MTs Asy-Syuhada memfasilitasi berbagai kegiatan intrakurikuler dan ekstrakurikuler untuk membentuk generasi yang berakhlak mulia, disiplin, berprestasi akademik, dan terampil.</p>
                </div>

                <div class="mts-filter-tabs">
                    <button type="button" class="mts-tab-btn active" data-filter="all">Semua Kegiatan</button>
                    <button type="button" class="mts-tab-btn" data-filter="keagamaan">Keagamaan & Seni Islam</button>
                    <button type="button" class="mts-tab-btn" data-filter="kepemimpinan">Kepemimpinan & Kebangsaan</button>
                    <button type="button" class="mts-tab-btn" data-filter="olahraga">Olahraga & Beladiri</button>
                    <button type="button" class="mts-tab-btn" data-filter="akademik">Akademik & Digital</button>
                </div>

                <div class="mts-kesiswaan-grid">
                    
                    <!-- Card 1: Pramuka & Paskibra -->
                    <div class="mts-activity-card" data-category="kepemimpinan">
                        <div class="mts-card-header">
                            <span class="mts-cat-badge kepemimpinan">Kepemimpinan</span>
                            <span class="mts-schedule-tag">Jumat, 14.00 WIB</span>
                        </div>
                        <div class="mts-card-body">
                            <div class="mts-card-icon-box">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                            </div>
                            <h3 class="mts-activity-title">Pramuka & Paskibraka</h3>
                            <p class="mts-activity-desc">Melatih kedisiplinan, jiwa kepemimpinan, kemandirian, serta kecintaan pada NKRI melalui kegiatan ketrampilan ambalan dan tata upacara bendera.</p>
                        </div>
                        <div class="mts-card-footer">
                            <div class="mts-achievement">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                <span>Juara LKTBB Kabupaten</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: PMR & Keorganisasian -->
                    <div class="mts-activity-card" data-category="kepemimpinan">
                        <div class="mts-card-header">
                            <span class="mts-cat-badge kepemimpinan">Kemanusiaan</span>
                            <span class="mts-schedule-tag">Sabtu, 09.00 WIB</span>
                        </div>
                        <div class="mts-card-body">
                            <div class="mts-card-icon-box">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
                            </div>
                            <h3 class="mts-activity-title">PMR & KSR Palang Merah</h3>
                            <p class="mts-activity-desc">Membentuk jiwa kepedulian sosial, pertolongan pertama pada kecelakaan (P3K), kesiapsiagaan bencana, serta kegiatan aksi donor darah madrasah.</p>
                        </div>
                        <div class="mts-card-footer">
                            <div class="mts-achievement">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                <span>Tim Medis Utama Madrasah</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3: Tahfidz & Seni Qiro'at -->
                    <div class="mts-activity-card" data-category="keagamaan">
                        <div class="mts-card-header">
                            <span class="mts-cat-badge keagamaan">Keagamaan</span>
                            <span class="mts-schedule-tag">Senin & Rabu, 15.30 WIB</span>
                        </div>
                        <div class="mts-card-body">
                            <div class="mts-card-icon-box">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                            </div>
                            <h3 class="mts-activity-title">Tahfidz & Seni Qiro'at</h3>
                            <p class="mts-activity-desc">Pengembangan bimbingan hafalan Al-Qur'an bertarget 3-5 Juz serta seni baca Al-Qur'an dengan lagam (tartil/mujawwad) dan tajwid mendalam.</p>
                        </div>
                        <div class="mts-card-footer">
                            <div class="mts-achievement">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                <span>Juara 1 MTQ Kecamatan</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card 4: Seni Kaligrafi & Hadroh -->
                    <div class="mts-activity-card" data-category="keagamaan">
                        <div class="mts-card-header">
                            <span class="mts-cat-badge keagamaan">Seni Islam</span>
                            <span class="mts-schedule-tag">Selasa, 15.30 WIB</span>
                        </div>
                        <div class="mts-card-body">
                            <div class="mts-card-icon-box">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 19l7-7 3 3-7 7-3-3z"/><path d="M18 13l-1.5-7.5L2 2l3.5 14.5L11 18l7-5z"/></svg>
                            </div>
                            <h3 class="mts-activity-title">Seni Kaligrafi & Hadroh</h3>
                            <p class="mts-activity-desc">Seni penulisan khat Al-Qur'an (Naskhi, Tsuluts, Riq'ah) serta grup sholawat Hadroh kontemporer penampil utama dalam peringatan hari besar Islam.</p>
                        </div>
                        <div class="mts-card-footer">
                            <div class="mts-achievement">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                <span>Penampil Utama PHBI</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card 5: Pencak Silat & Olahraga -->
                    <div class="mts-activity-card" data-category="olahraga">
                        <div class="mts-card-header">
                            <span class="mts-cat-badge olahraga">Olahraga</span>
                            <span class="mts-schedule-tag">Kamis & Sabtu, 15.30 WIB</span>
                        </div>
                        <div class="mts-card-body">
                            <div class="mts-card-icon-box">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m4.93 4.93 4.24 4.24"/><path d="m14.83 9.17 4.24-4.24"/><path d="m14.83 14.83 4.24 4.24"/><path d="m9.17 14.83-4.24 4.24"/></svg>
                            </div>
                            <h3 class="mts-activity-title">Pencak Silat & Futsal</h3>
                            <p class="mts-activity-desc">Bela diri tradisional pencak silat penanaman karakter & fisik, serta tim futsal & voli putri/putra berlaga pada turnamen antar madrasah.</p>
                        </div>
                        <div class="mts-card-footer">
                            <div class="mts-achievement">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                <span>Medali Emas Silat Daerah</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card 6: Klub Sains & Digital -->
                    <div class="mts-activity-card" data-category="akademik">
                        <div class="mts-card-header">
                            <span class="mts-cat-badge akademik">Akademik</span>
                            <span class="mts-schedule-tag">Kamis, 14.00 WIB</span>
                        </div>
                        <div class="mts-card-body">
                            <div class="mts-card-icon-box">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                            </div>
                            <h3 class="mts-activity-title">Klub Sains, English & Digital</h3>
                            <p class="mts-activity-desc">Bimbingan persiapan Kompetisi Sains Madrasah (KSM) IPA & Matematika, English Public Speaking, serta pelatihan dasar pemrograman & desain grafis.</p>
                        </div>
                        <div class="mts-card-footer">
                            <div class="mts-achievement">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                <span>Finalis KSM Matematika</span>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="mts-kesiswaan-cta-box">
                    <span class="mts-cta-text">Ingin mendaftar atau berkonsultasi mengenai kegiatan kesiswaan?</span>
                    <a href="https://wa.me/6281234567890" target="_blank" rel="noopener noreferrer" class="mts-kesiswaan-btn">
                        <span>Konsultasi Pembina Kesiswaan</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </a>
                </div>

            </div>
        </section>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Inject Styles & Scripts into both Frontend and Elementor Preview
 */
add_action('wp_footer', function() {
    ?>
    <style id="mts-kesiswaan-enhanced-css">
        /* KESISWAAN & EKSTRAKURIKULER SECTION STYLES */
        .mts-kesiswaan-section {
            background-color: #F8FAFC !important;
            padding: 72px 0 !important;
            font-family: 'Plus Jakarta Sans', 'Inter', system-ui, -apple-system, sans-serif !important;
            border-top: 1px solid #E2E8F0 !important;
            border-bottom: 1px solid #E2E8F0 !important;
            color: #1E293B !important;
            width: 100% !important;
            position: relative !important;
            z-index: 10 !important;
            clear: both !important;
        }

        .mts-kesiswaan-section *, .mts-kesiswaan-section *::before, .mts-kesiswaan-section *::after {
            box-sizing: border-box !important;
        }

        .mts-kesiswaan-container {
            max-width: 1200px !important;
            margin: 0 auto !important;
            padding: 0 24px !important;
        }

        /* Section Header */
        .mts-kesiswaan-header {
            text-align: center !important;
            max-width: 760px !important;
            margin: 0 auto 40px auto !important;
        }

        .mts-section-badge {
            display: inline-block !important;
            background-color: rgba(13, 92, 58, 0.1) !important;
            color: #0D5C3A !important;
            border: 1px solid rgba(13, 92, 58, 0.25) !important;
            font-family: 'Outfit', 'Plus Jakarta Sans', sans-serif !important;
            font-size: 11.5px !important;
            font-weight: 700 !important;
            letter-spacing: 1.2px !important;
            text-transform: uppercase !important;
            padding: 4px 14px !important;
            border-radius: 99px !important;
            margin-bottom: 12px !important;
        }

        .mts-section-title {
            color: #0F172A !important;
            font-family: 'Outfit', 'Plus Jakarta Sans', sans-serif !important;
            font-size: 32px !important;
            font-weight: 800 !important;
            line-height: 1.3 !important;
            letter-spacing: -0.5px !important;
            margin: 0 0 14px 0 !important;
        }

        .mts-section-subtitle {
            color: #64748B !important;
            font-size: 15px !important;
            line-height: 1.6 !important;
            margin: 0 !important;
        }

        /* Filter Tabs */
        .mts-filter-tabs {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            flex-wrap: wrap !important;
            gap: 10px !important;
            margin-bottom: 40px !important;
        }

        .mts-tab-btn {
            background-color: #FFFFFF !important;
            color: #64748B !important;
            border: 1px solid #E2E8F0 !important;
            padding: 9px 18px !important;
            border-radius: 8px !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            font-size: 13.5px !important;
            font-weight: 600 !important;
            cursor: pointer !important;
            transition: all 0.2s ease !important;
            outline: none !important;
        }

        .mts-tab-btn:hover {
            color: #0D5C3A !important;
            border-color: #0D5C3A !important;
            background-color: rgba(13, 92, 58, 0.03) !important;
        }

        .mts-tab-btn.active {
            background-color: #0D5C3A !important;
            color: #FFFFFF !important;
            border-color: #0D5C3A !important;
            box-shadow: 0 4px 12px rgba(13, 92, 58, 0.2) !important;
        }

        /* Grid Layout */
        .mts-kesiswaan-grid {
            display: grid !important;
            grid-template-columns: repeat(3, 1fr) !important;
            gap: 24px !important;
            margin-bottom: 48px !important;
        }

        /* Cards */
        .mts-activity-card {
            background-color: #FFFFFF !important;
            border: 1px solid #E2E8F0 !important;
            border-radius: 14px !important;
            padding: 24px !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: space-between !important;
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease !important;
            position: relative !important;
            overflow: hidden !important;
        }

        .mts-activity-card:hover {
            transform: translateY(-4px) !important;
            box-shadow: 0 12px 24px -4px rgba(15, 23, 42, 0.08) !important;
            border-color: rgba(13, 92, 58, 0.4) !important;
        }

        .mts-activity-card::before {
            content: '' !important;
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            height: 4px !important;
            background-color: #0D5C3A !important;
            border-radius: 14px 14px 0 0 !important;
        }

        .mts-card-header {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            gap: 12px !important;
            margin-bottom: 16px !important;
        }

        .mts-cat-badge {
            font-size: 11px !important;
            font-weight: 700 !important;
            padding: 3px 10px !important;
            border-radius: 6px !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
        }

        .mts-cat-badge.kepemimpinan {
            background-color: #FEF3C7 !important;
            color: #B45309 !important;
        }

        .mts-cat-badge.keagamaan {
            background-color: #DCFCE7 !important;
            color: #15803D !important;
        }

        .mts-cat-badge.olahraga {
            background-color: #DBEAFE !important;
            color: #1D4ED8 !important;
        }

        .mts-cat-badge.akademik {
            background-color: #F3E8FF !important;
            color: #7E22CE !important;
        }

        .mts-schedule-tag {
            font-size: 11.5px !important;
            color: #64748B !important;
            font-weight: 500 !important;
        }

        .mts-card-body {
            flex-grow: 1 !important;
            margin-bottom: 20px !important;
        }

        .mts-card-icon-box {
            width: 44px !important;
            height: 44px !important;
            border-radius: 10px !important;
            background-color: rgba(13, 92, 58, 0.08) !important;
            color: #0D5C3A !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin-bottom: 16px !important;
        }

        .mts-activity-title {
            color: #0F172A !important;
            font-family: 'Outfit', 'Plus Jakarta Sans', sans-serif !important;
            font-size: 18px !important;
            font-weight: 700 !important;
            margin: 0 0 10px 0 !important;
            line-height: 1.35 !important;
        }

        .mts-activity-desc {
            color: #475569 !important;
            font-size: 13.5px !important;
            line-height: 1.6 !important;
            margin: 0 !important;
        }

        .mts-card-footer {
            border-top: 1px dashed #E2E8F0 !important;
            padding-top: 14px !important;
        }

        .mts-achievement {
            display: flex !important;
            align-items: center !important;
            gap: 6px !important;
            color: #D97706 !important;
            font-size: 12.5px !important;
            font-weight: 600 !important;
        }

        /* CTA Box */
        .mts-kesiswaan-cta-box {
            background-color: #FFFFFF !important;
            border: 1px solid #E2E8F0 !important;
            border-radius: 12px !important;
            padding: 20px 28px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            gap: 20px !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03) !important;
        }

        .mts-cta-text {
            color: #334155 !important;
            font-size: 14.5px !important;
            font-weight: 600 !important;
        }

        .mts-kesiswaan-btn {
            display: inline-flex !important;
            align-items: center !important;
            gap: 8px !important;
            background-color: #0D5C3A !important;
            color: #FFFFFF !important;
            padding: 10px 20px !important;
            border-radius: 8px !important;
            font-size: 13.5px !important;
            font-weight: 600 !important;
            text-decoration: none !important;
            transition: background-color 0.2s ease !important;
            white-space: nowrap !important;
        }

        .mts-kesiswaan-btn:hover {
            background-color: #09472C !important;
            color: #FFFFFF !important;
        }

        /* RESPONSIVE DESIGN */
        @media (max-width: 992px) {
            .mts-kesiswaan-grid {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 20px !important;
            }

            .mts-section-title {
                font-size: 26px !important;
            }
        }

        @media (max-width: 640px) {
            .mts-kesiswaan-section {
                padding: 48px 0 !important;
            }

            .mts-kesiswaan-grid {
                grid-template-columns: 1fr !important;
                gap: 18px !important;
            }

            .mts-section-title {
                font-size: 22px !important;
            }

            .mts-kesiswaan-cta-box {
                flex-direction: column !important;
                text-align: center !important;
                padding: 20px !important;
            }

            .mts-kesiswaan-btn {
                width: 100% !important;
                justify-content: center !important;
            }
        }
    </style>

    <script id="mts-kesiswaan-enhancer-js">
    (function() {
        function setupTabs(container) {
            var tabBtns = container.querySelectorAll(".mts-tab-btn");
            var activityCards = container.querySelectorAll(".mts-activity-card");

            tabBtns.forEach(function(btn) {
                btn.addEventListener("click", function() {
                    tabBtns.forEach(function(b) { b.classList.remove("active"); });
                    this.classList.add("active");

                    var filter = this.getAttribute("data-filter");

                    activityCards.forEach(function(card) {
                        if (filter === "all" || card.getAttribute("data-category") === filter) {
                            card.style.display = "flex";
                        } else {
                            card.style.display = "none";
                        }
                    });
                });
            });
        }

        function replaceKesiswaanSection() {
            // Target headings ONLY inside page content
            var contentArea = document.querySelector(".site-content, #content, .entry-content, article, .elementor");
            if (!contentArea) contentArea = document.body;

            var headings = contentArea.querySelectorAll("h1, h2, h3, h4, h5, h6, .elementor-heading-title, .elementor-widget-heading");
            var targetHeading = null;

            for (var i = 0; i < headings.length; i++) {
                var h = headings[i];
                if (h.textContent && h.textContent.toUpperCase().indexOf("KESISWAAN & EKSTRAKURIKULER") !== -1) {
                    // Check if it's already inside our wrapper
                    if (h.closest("#kesiswaan-ekstrakurikuler-wrapper") || h.closest(".mts-kesiswaan-section")) {
                        continue;
                    }
                    targetHeading = h;
                    break;
                }
            }

            if (!targetHeading) {
                // Also setup tabs for shortcode instances if present
                document.querySelectorAll(".mts-kesiswaan-wrapper-node").forEach(function(node) {
                    if (!node.getAttribute("data-tabs-bound")) {
                        node.setAttribute("data-tabs-bound", "true");
                        setupTabs(node);
                    }
                });
                return;
            }

            var targetSec = targetHeading.closest(".elementor-section, section");
            if (!targetSec) {
                targetSec = targetHeading.closest(".elementor-element") || targetHeading.parentElement;
            }

            if (targetSec && targetSec !== document.body && targetSec !== contentArea) {
                var tempDiv = document.createElement("div");
                tempDiv.innerHTML = `<?php echo str_replace(array("\r", "\n"), '', mts_render_kesiswaan_grid_html()); ?>`;
                
                var newEl = tempDiv.firstElementChild;
                targetSec.parentNode.replaceChild(newEl, targetSec);
                setupTabs(newEl);
            }
        }

        if (document.readyState === "complete" || document.readyState === "interactive") {
            replaceKesiswaanSection();
        }
        document.addEventListener("DOMContentLoaded", replaceKesiswaanSection);
        window.addEventListener("load", replaceKesiswaanSection);
        
        // Polling interval to support live Elementor Editor Canvas rendering
        setInterval(replaceKesiswaanSection, 1000);
    })();
    </script>
    <?php
});
