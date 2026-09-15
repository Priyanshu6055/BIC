<?php $__env->startSection('title', $inquiry->reference.' | BIC Admin'); ?>
<?php $__env->startSection('admin-content'); ?>
<div class="admin-detail-header">
    <div class="admin-detail-title">
        <a href="<?php echo e(route('admin.inquiries.index')); ?>" class="admin-btn-back">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back to Inquiries
        </a>
        <div class="admin-detail-meta">
            <p class="eyebrow"><?php echo e(strtoupper($inquiry->type)); ?> INQUIRY</p>
            <h1><?php echo e($inquiry->reference); ?></h1>
            <p class="admin-subtext">Received on <?php echo e($inquiry->created_at->format('d M Y \a\t H:i')); ?></p>
        </div>
    </div>
    <form method="post" action="<?php echo e(route('admin.inquiries.update', $inquiry)); ?>" class="admin-status-update-form">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PATCH'); ?>
        <div class="admin-select-wrapper">
            <label for="statusSelect">Update Status</label>
            <select id="statusSelect" name="status">
                <?php $__currentLoopData = ['New','Reviewed','Contacted','Closed','Spam']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option <?php if($inquiry->status===$status): echo 'selected'; endif; ?>><?php echo e($status); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <button type="submit" class="admin-primary">Update</button>
    </form>
</div>

<div class="admin-detail">
    <section class="admin-card">
        <div class="admin-card-header">
            <h2>Contact Information</h2>
        </div>
        <dl>
            <dt>Client Name</dt>
            <dd><?php echo e($inquiry->name); ?></dd>
            <dt>Email Address</dt>
            <dd><a href="mailto:<?php echo e($inquiry->email); ?>" class="table-link"><?php echo e($inquiry->email); ?></a></dd>
            <dt>Phone Number</dt>
            <dd><?php echo e($inquiry->phone ?: '—'); ?></dd>
            <dt>Company Name</dt>
            <dd><?php echo e($inquiry->company ?: '—'); ?></dd>
            <dt>Current Status</dt>
            <dd><span class="status-pill status-<?php echo e($inquiry->status); ?>"><span class="status-dot"></span><?php echo e($inquiry->status); ?></span></dd>
        </dl>
    </section>

    <section class="admin-card">
        <div class="admin-card-header">
            <h2>Submission Details</h2>
        </div>
        <dl>
            <?php $__empty_1 = true; $__currentLoopData = $inquiry->payload; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <dt><?php echo e(str($key)->headline()); ?></dt>
                <dd><?php echo e(is_bool($value) ? ($value ? 'Yes' : 'No') : (is_array($value) ? implode(', ', $value) : ($value ?: '—'))); ?></dd>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <dt>Data</dt>
                <dd>No additional questionnaire fields submitted.</dd>
            <?php endif; ?>
        </dl>
    </section>

    <?php if($inquiry->document_path): ?>
    <section class="admin-card full-span">
        <div class="admin-card-header">
            <h2>Attached Document</h2>
        </div>
        <div style="padding: 8px 0;">
            <a class="admin-primary" href="<?php echo e(route('admin.inquiries.document', $inquiry)); ?>" style="display: inline-flex; align-items: center; gap: 8px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="7 10 12 15 17 10"></polyline>
                    <line x1="12" y1="15" x2="12" y2="3"></line>
                </svg>
                Download Attached PDF Document
            </a>
        </div>
    </section>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DESIGN\Downloads\BIC_Laravel_Production_Source\resources\views/admin/inquiries/show.blade.php ENDPATH**/ ?>