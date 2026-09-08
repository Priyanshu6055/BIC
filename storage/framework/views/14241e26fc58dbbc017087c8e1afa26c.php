<?php $__env->startSection('robots', 'noindex,nofollow'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-shell <?php echo e(Auth::check() ? 'admin-has-sidebar' : 'admin-guest-shell'); ?>" id="adminShell">
    <?php if(auth()->guard()->check()): ?>
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="admin-sidebar-header">
            <a href="<?php echo e(route('admin.inquiries.index')); ?>" class="admin-sidebar-brand">
                <div class="admin-brand-mark">BIC</div>
                <div class="admin-brand-text">
                    <strong>Bridge India</strong>
                    <span>Administration</span>
                </div>
            </a>
            <button type="button" class="admin-sidebar-close" id="adminSidebarClose" aria-label="Close navigation">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>

        <div class="admin-sidebar-user">
            <div class="admin-user-avatar"><?php echo e(strtoupper(substr(auth()->user()->name ?? 'A', 0, 1))); ?></div>
            <div class="admin-user-info">
                <span class="admin-user-name"><?php echo e(auth()->user()->name ?? 'Admin User'); ?></span>
                <span class="admin-user-email"><?php echo e(auth()->user()->email ?? ''); ?></span>
            </div>
        </div>

        <nav class="admin-sidebar-nav">
            <span class="admin-nav-heading">Main Navigation</span>
            <a href="<?php echo e(route('admin.inquiries.index')); ?>" class="<?php echo e(request()->routeIs('admin.inquiries.*') && request('type') !== 'contact' ? 'active' : ''); ?>">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                    <polyline points="22,6 12,13 2,6"></polyline>
                </svg>
                <span>All Inquiries</span>
            </a>
            <a href="<?php echo e(route('admin.inquiries.index', ['type' => 'contact'])); ?>" class="<?php echo e(request()->routeIs('admin.inquiries.*') && request('type') === 'contact' ? 'active' : ''); ?>">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                </svg>
                <span>Contact Messages</span>
            </a>
            <a href="<?php echo e(route('admin.insights.index')); ?>" class="<?php echo e(request()->routeIs('admin.insights.*') ? 'active' : ''); ?>">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
                <span>Insights CMS</span>
            </a>

            <span class="admin-nav-heading" style="margin-top: 24px;">Quick Links</span>
            <a href="<?php echo e(route('home')); ?>" target="_blank" rel="noopener noreferrer">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                    <polyline points="15 3 21 3 21 9"></polyline>
                    <line x1="10" y1="14" x2="21" y2="3"></line>
                </svg>
                <span>View Public Site</span>
            </a>

            <form action="<?php echo e(route('admin.logout')); ?>" method="post" class="admin-logout-form">
                <?php echo csrf_field(); ?>
                <button type="submit">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    <span>Log out</span>
                </button>
            </form>
        </nav>
    </aside>

    <div class="admin-backdrop" id="adminBackdrop"></div>
    <?php endif; ?>

    <main class="admin-main">
        <?php if(auth()->guard()->check()): ?>
        <header class="admin-mobile-topbar">
            <button type="button" class="admin-menu-toggle" id="adminSidebarToggle" aria-label="Open navigation menu">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>
            <div class="admin-mobile-brand">
                <strong>BIC</strong>
                <span>Admin</span>
            </div>
            <div class="admin-mobile-user">
                <span class="admin-user-pill"><?php echo e(auth()->user()->name ?? 'Admin'); ?></span>
            </div>
        </header>
        <?php endif; ?>

        <?php if(session('success')): ?>
            <div class="admin-notice">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
                <span><?php echo e(session('success')); ?></span>
            </div>
        <?php endif; ?> 

        <?php echo $__env->yieldContent('admin-content'); ?>
    </main>
</div>

<?php if(auth()->guard()->check()): ?>
<script>
    (function() {
        const sidebar = document.getElementById('adminSidebar');
        const toggleBtn = document.getElementById('adminSidebarToggle');
        const closeBtn = document.getElementById('adminSidebarClose');
        const backdrop = document.getElementById('adminBackdrop');

        function openSidebar() {
            if (sidebar) sidebar.classList.add('is-open');
            if (backdrop) backdrop.classList.add('is-open');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            if (sidebar) sidebar.classList.remove('is-open');
            if (backdrop) backdrop.classList.remove('is-open');
            document.body.style.overflow = '';
        }

        if (toggleBtn) toggleBtn.addEventListener('click', openSidebar);
        if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
        if (backdrop) backdrop.addEventListener('click', closeSidebar);

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && sidebar && sidebar.classList.contains('is-open')) {
                closeSidebar();
            }
        });
    })();
</script>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DESIGN\Downloads\BIC_Laravel_Production_Source\resources\views/layouts/admin.blade.php ENDPATH**/ ?>