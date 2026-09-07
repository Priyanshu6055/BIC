<?php $__env->startSection('robots', 'noindex,nofollow'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-shell">
    <header class="admin-header"><a href="<?php echo e(route('admin.inquiries.index')); ?>"><strong>BIC</strong><span>Administration</span></a><?php if(auth()->guard()->check()): ?><nav><a href="<?php echo e(route('admin.inquiries.index')); ?>">Inquiries</a><a href="<?php echo e(route('admin.insights.index')); ?>">Insights</a><form action="<?php echo e(route('admin.logout')); ?>" method="post"><?php echo csrf_field(); ?><button type="submit">Log out</button></form></nav><?php endif; ?></header>
    <main class="admin-main"><?php if(session('success')): ?><div class="admin-notice"><?php echo e(session('success')); ?></div><?php endif; ?> <?php echo $__env->yieldContent('admin-content'); ?></main>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DESIGN\Downloads\BIC_Laravel_Production_Source\resources\views/layouts/admin.blade.php ENDPATH**/ ?>