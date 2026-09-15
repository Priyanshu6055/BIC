<?php $__env->startSection('title', 'Inquiry Dashboard | BIC Administration'); ?>
<?php $__env->startSection('admin-content'); ?>
<div class="admin-page-header">
    <div class="admin-header-top">
        <div>
            <p class="eyebrow">Client Submissions</p>
            <h1>Inquiry Dashboard</h1>
        </div>
        <div class="admin-header-actions">
            <div class="admin-export-group">
                <a href="<?php echo e(route('admin.inquiries.export', ['scope' => 'all', 'format' => 'csv'])); ?>" class="admin-btn-export" title="Download all records from the full database table to Excel (.csv)">
                    <svg class="admin-btn-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg>
                    <span>Download Full Table (Excel)</span>
                </a>
                <?php if(request()->anyFilled(['search', 'type', 'status'])): ?>
                <a href="<?php echo e(route('admin.inquiries.export', array_merge(request()->query(), ['filtered' => 1, 'format' => 'csv']))); ?>" class="admin-btn-export-subtle" title="Download only the currently filtered records">
                    <span>Export Filtered</span>
                </a>
                <?php endif; ?>
                <a href="<?php echo e(route('admin.inquiries.export', array_merge(request()->query(), ['format' => 'json']))); ?>" class="admin-btn-export-subtle" title="Download inquiries in JSON format">
                    <svg class="admin-btn-icon" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="16 18 22 12 16 6"></polyline>
                        <polyline points="8 6 2 12 8 18"></polyline>
                    </svg>
                    <span>JSON</span>
                </a>
            </div>
        </div>
    </div>

    <div class="admin-toolbar">
        <form class="admin-filters" method="GET" action="<?php echo e(route('admin.inquiries.index')); ?>">
            <div class="admin-search-wrap">
                <svg class="admin-search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input type="text" name="search" placeholder="Search reference, name, email, company..." value="<?php echo e(request('search')); ?>">
            </div>
            <select name="type" onchange="this.form.submit()">
                <option value="">All Types</option>
                <?php $__currentLoopData = ['startup','msme','investor','ma','contact']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($type); ?>" <?php if(request('type')===$type): echo 'selected'; endif; ?>><?php echo e(ucfirst($type)); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <select name="status" onchange="this.form.submit()">
                <option value="">All Statuses</option>
                <?php $__currentLoopData = ['New','Reviewed','Contacted','Closed','Spam']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($status); ?>" <?php if(request('status')===$status): echo 'selected'; endif; ?>><?php echo e($status); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <button type="submit" class="admin-btn-filter">Filter</button>
            <?php if(request()->anyFilled(['search', 'type', 'status'])): ?>
                <a href="<?php echo e(route('admin.inquiries.index')); ?>" class="admin-btn-clear">Clear</a>
            <?php endif; ?>
        </form>
    </div>
</div>

<div class="admin-table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Reference</th>
                <th>Date</th>
                <th>Type</th>
                <th>Client Name</th>
                <th>Email Address</th>
                <th>Company</th>
                <th>Status</th>
                <th style="text-align: right;">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $inquiries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inquiry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><span class="ref-badge"><?php echo e($inquiry->reference); ?></span></td>
                    <td class="text-muted-cell"><?php echo e($inquiry->created_at->format('d M Y')); ?></td>
                    <td><span class="type-pill"><?php echo e(strtoupper($inquiry->type)); ?></span></td>
                    <td class="fw-medium"><?php echo e($inquiry->name); ?></td>
                    <td><a href="mailto:<?php echo e($inquiry->email); ?>" class="table-link"><?php echo e($inquiry->email); ?></a></td>
                    <td class="text-muted-cell"><?php echo e(Str::limit($inquiry->company ?: '—', 28)); ?></td>
                    <td><span class="status-pill status-<?php echo e($inquiry->status); ?>"><span class="status-dot"></span><?php echo e($inquiry->status); ?></span></td>
                    <td style="text-align: right;"><a href="<?php echo e(route('admin.inquiries.show', $inquiry)); ?>" class="admin-btn-table">View Details &rarr;</a></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="8" class="table-empty-cell">
                        <div class="admin-empty-state">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="color: var(--admin-text-muted); margin-bottom: 12px;">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="8" y1="12" x2="16" y2="12"></line>
                            </svg>
                            <p>No inquiries found matching your current filter criteria.</p>
                            <?php if(request()->anyFilled(['search', 'type', 'status'])): ?>
                                <a href="<?php echo e(route('admin.inquiries.index')); ?>" class="admin-btn-clear" style="margin-top: 8px;">Reset filters</a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="admin-pagination-wrap">
    <?php echo e($inquiries->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DESIGN\Downloads\BIC_Laravel_Production_Source\resources\views/admin/inquiries/index.blade.php ENDPATH**/ ?>