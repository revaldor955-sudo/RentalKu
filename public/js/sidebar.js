/*!
 * Sidebar behavior – shared by admin-sidebar.blade.php & staff-sidebar.blade.php
 * Extracted to avoid 135+ lines of duplicate inline JS across two partials.
 * Elements required in DOM: #adminSidebar, #sidebarToggle, #sidebarOverlay (overlay optional)
 */
(function () {
    'use strict';

    const STORAGE_KEY = 'rentalku_sidebar_collapsed';
    const MOBILE_BREAKPOINT = 1024;

    const sidebar = document.getElementById('adminSidebar');
    const toggleBtn = document.getElementById('sidebarToggle');
    const overlay = document.getElementById('sidebarOverlay');

    if (!sidebar) return;

    let isCollapsed = false;
    let isMobile = window.innerWidth < MOBILE_BREAKPOINT;

    function init() {
        isCollapsed = false;
        sidebar.classList.remove('collapsed');
        sidebar.setAttribute('data-collapsed', 'false');
        updateAria();
    }

    function applyCollapsedState() {
        if (isCollapsed) {
            sidebar.classList.add('collapsed');
            sidebar.setAttribute('data-collapsed', 'true');
        } else {
            sidebar.classList.remove('collapsed');
            sidebar.setAttribute('data-collapsed', 'false');
        }
    }

    function updateAria() {
        if (toggleBtn) {
            toggleBtn.setAttribute('aria-expanded', !isCollapsed);
            toggleBtn.setAttribute('aria-label', isCollapsed ? 'Expand sidebar' : 'Collapse sidebar');
        }
    }

    function toggleSidebar() {
        if (isMobile) {
            sidebar.classList.toggle('mobile-open');
            if (overlay) overlay.classList.toggle('visible');
            document.body.style.overflow = sidebar.classList.contains('mobile-open') ? 'hidden' : '';
        } else {
            isCollapsed = !isCollapsed;
            localStorage.setItem(STORAGE_KEY, isCollapsed);
            applyCollapsedState();
        }
        updateAria();
    }

    function closeMobileSidebar() {
        if (isMobile) {
            sidebar.classList.remove('mobile-open');
            if (overlay) overlay.classList.remove('visible');
            document.body.style.overflow = '';
        }
    }

    if (toggleBtn) {
        toggleBtn.addEventListener('click', toggleSidebar);
    }

    // Mobile toggle button lives in the navbar partial, which may parse after this script.
    function bindMobileToggle() {
        const btn = document.getElementById('mobileSidebarToggle');
        if (btn && !btn.dataset.sidebarBound) {
            btn.dataset.sidebarBound = 'true';
            btn.addEventListener('click', function () {
                isMobile = window.innerWidth < MOBILE_BREAKPOINT;
                toggleSidebar();
                btn.setAttribute('aria-expanded', sidebar.classList.contains('mobile-open'));
            });
        }
    }
    bindMobileToggle();
    document.addEventListener('DOMContentLoaded', bindMobileToggle);

    // Pages render .page-content as a body sibling AFTER .sidebar-layout,
    // so it misses the #mainContent sidebar offset. Move it inside once DOM is ready.
    // Single fix here covers all admin/staff pages using this partial.
    function relocatePageContent() {
        const mc = document.getElementById('mainContent');
        if (!mc) return;
        const placeholder = mc.querySelector('main.page-content');
        if (placeholder && placeholder.children.length === 0) placeholder.style.display = 'none';
        document.querySelectorAll('body > .page-content').forEach(function (el) {
            mc.appendChild(el);
        });
    }
    document.addEventListener('DOMContentLoaded', relocatePageContent);

    if (overlay) overlay.addEventListener('click', closeMobileSidebar);

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && isMobile && sidebar.classList.contains('mobile-open')) {
            closeMobileSidebar();
        }
    });

    let resizeTimer;
    window.addEventListener('resize', function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function () {
            const wasMobile = isMobile;
            isMobile = window.innerWidth < MOBILE_BREAKPOINT;

            if (wasMobile && !isMobile) {
                // Mobile -> Desktop
                sidebar.classList.remove('mobile-open');
                if (overlay) overlay.classList.remove('visible');
                document.body.style.overflow = '';
            } else if (!wasMobile && isMobile) {
                // Desktop -> Mobile
                sidebar.classList.remove('collapsed');
                sidebar.setAttribute('data-collapsed', 'false');
                isCollapsed = false;
                localStorage.removeItem(STORAGE_KEY);
            }
            updateAria();
        }, 100);
    });

    document.querySelectorAll('.nav-link').forEach(function (link) {
        link.addEventListener('click', function () {
            if (isMobile) {
                closeMobileSidebar();
            }
        });
    });

    // Remember nav scroll position per session so it doesn't reset to top on page change
    function restoreNavScroll() {
        const nav = sidebar.querySelector('.sidebar-nav');
        if (!nav) return;
        try {
            const saved = sessionStorage.getItem('rentalku_sidebar_nav_scroll');
            if (saved !== null) nav.scrollTop = parseInt(saved, 10) || 0;
        } catch (e) {}
        let scrollTimer;
        nav.addEventListener('scroll', function () {
            clearTimeout(scrollTimer);
            scrollTimer = setTimeout(function () {
                try {
                    sessionStorage.setItem('rentalku_sidebar_nav_scroll', nav.scrollTop);
                } catch (e) {}
            }, 100);
        }, { passive: true });
    }

    init();
    restoreNavScroll();
})();
