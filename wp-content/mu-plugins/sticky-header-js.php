<?php
/*
Plugin Name: MTs Asy-Syuhada Modern Sticky Header & Menu
Description: Adds sticky header scroll listener and enforces high-contrast aesthetic menu styles.
*/

add_action('wp_head', function() {
    ?>
    <style id="mts-modern-header-css">
    /* Sticky Header Container */
    html body #masthead,
    html body.ast-theme-transparent-header #masthead {
        position: sticky !important;
        top: 0 !important;
        z-index: 999999 !important;
        width: 100% !important;
        background: rgba(255, 255, 255, 0.96) !important;
        backdrop-filter: blur(12px) !important;
        -webkit-backdrop-filter: blur(12px) !important;
        border-bottom: 1px solid rgba(13, 92, 58, 0.1) !important;
        box-shadow: 0 4px 20px -2px rgba(13, 92, 58, 0.08) !important;
        transition: background 0.3s ease, box-shadow 0.3s ease !important;
    }

    html body #masthead.is-scrolled {
        background: rgba(255, 255, 255, 0.98) !important;
        box-shadow: 0 8px 30px rgba(13, 92, 58, 0.15) !important;
        border-bottom-color: rgba(13, 92, 58, 0.18) !important;
    }

    /* Overflow Visibility */
    html body #masthead,
    html body #masthead *,
    html body .site-header,
    html body .ast-main-header-wrap,
    html body .main-header-bar-wrap,
    html body .main-header-bar,
    html body .site-primary-header-wrap,
    html body .site-header-primary-section-left,
    html body .site-header-primary-section-right,
    html body .ast-builder-menu-1,
    html body .main-navigation {
        overflow: visible !important;
    }

    /* Target Every Menu Link (High Contrast Dark Navy) */
    html body #masthead .main-header-bar a,
    html body #masthead .main-header-bar a.menu-link,
    html body #masthead .main-navigation a,
    html body #masthead .main-navigation a.menu-link,
    html body #masthead .main-header-menu a,
    html body #masthead .main-header-menu a.menu-link,
    html body .ast-builder-menu-1 .main-header-menu .menu-item > .menu-link,
    html body.ast-theme-transparent-header .ast-builder-menu-1 .main-header-menu .menu-item > .menu-link {
        color: #1E293B !important;
        font-family: 'Outfit', 'Inter', system-ui, -apple-system, sans-serif !important;
        font-size: 15px !important;
        font-weight: 600 !important;
        padding: 9px 16px !important;
        border-radius: 8px !important;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 6px !important;
        text-decoration: none !important;
        opacity: 1 !important;
    }

    /* Hover State */
    html body #masthead .main-header-menu > .menu-item:hover > .menu-link,
    html body #masthead .main-header-menu > .menu-item.focus > .menu-link,
    html body .ast-builder-menu-1 .main-header-menu .menu-item:hover > .menu-link {
        color: #0D5C3A !important;
        background: rgba(13, 92, 58, 0.08) !important;
        transform: translateY(-1px);
    }

    /* Active State */
    html body #masthead .main-header-menu > .menu-item.current-menu-item > .menu-link,
    html body #masthead .main-header-menu > .menu-item.current-menu-ancestor > .menu-link {
        color: #0D5C3A !important;
        background: rgba(13, 92, 58, 0.12) !important;
        font-weight: 700 !important;
    }

    /* Floating Dropdown Card Container */
    html body #masthead .main-header-menu .sub-menu,
    html body .ast-builder-menu-1 .main-header-menu .sub-menu {
        position: absolute !important;
        top: 100% !important;
        left: 0 !important;
        z-index: 9999999 !important;
        border-radius: 12px !important;
        background: #FFFFFF !important;
        box-shadow: 0 15px 35px rgba(13, 92, 58, 0.18), 0 5px 15px rgba(0, 0, 0, 0.06) !important;
        border: 1px solid rgba(13, 92, 58, 0.14) !important;
        padding: 8px !important;
        min-width: 240px !important;
        margin-top: 6px !important;
        display: none !important;
        opacity: 0 !important;
        visibility: hidden !important;
        transition: opacity 0.2s ease, transform 0.2s ease !important;
        transform: translateY(6px) !important;
    }

    /* Display Dropdown on Hover or Focus */
    html body #masthead .main-header-menu .menu-item:hover > .sub-menu,
    html body #masthead .main-header-menu .menu-item.focus > .sub-menu,
    html body #masthead .main-header-menu .menu-item-has-children:hover > .sub-menu,
    html body .ast-builder-menu-1 .main-header-menu .menu-item:hover > .sub-menu {
        display: block !important;
        opacity: 1 !important;
        visibility: visible !important;
        transform: translateY(0) !important;
    }

    /* Submenu Links */
    html body #masthead .main-header-menu .sub-menu .menu-item {
        margin: 2px 0 !important;
        width: 100% !important;
        list-style: none !important;
    }

    html body #masthead .main-header-menu .sub-menu a,
    html body #masthead .main-header-menu .sub-menu a.menu-link {
        font-family: 'Outfit', 'Inter', sans-serif !important;
        font-size: 14px !important;
        font-weight: 600 !important;
        color: #334155 !important;
        padding: 10px 16px !important;
        border-radius: 8px !important;
        transition: all 0.2s ease !important;
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        width: 100% !important;
        box-sizing: border-box !important;
        background: transparent !important;
    }

    html body #masthead .main-header-menu .sub-menu .menu-item:hover > .menu-link,
    html body #masthead .main-header-menu .sub-menu a:hover {
        color: #0D5C3A !important;
        background: #F0FDF4 !important;
        padding-left: 20px !important;
    }

    /* Dropdown Arrow Icons */
    html body #masthead .main-navigation .menu-item-has-children > .menu-link .ast-icon {
        transition: transform 0.25s ease !important;
        margin-left: 4px !important;
    }

    html body #masthead .main-navigation .menu-item-has-children > .menu-link .ast-icon svg {
        fill: #1E293B !important;
        width: 12px !important;
        height: 12px !important;
    }

    html body #masthead .main-navigation .menu-item-has-children:hover > .menu-link .ast-icon {
        transform: rotate(180deg) !important;
    }

    html body #masthead .main-navigation .menu-item-has-children:hover > .menu-link .ast-icon svg {
        fill: #0D5C3A !important;
    }
    </style>
    <?php
}, 99999);

add_action('wp_footer', function() {
    ?>
    <script id="sticky-header-scroll-js">
    document.addEventListener("DOMContentLoaded", function() {
        var header = document.getElementById("masthead");
        if (header) {
            function checkScroll() {
                if (window.scrollY > 20) {
                    header.classList.add("is-scrolled");
                } else {
                    header.classList.remove("is-scrolled");
                }
            }
            window.addEventListener("scroll", checkScroll, { passive: true });
            checkScroll();
        }
    });
    </script>
    <?php
}, 99999);