<?php $__env->startSection('title', 'Insights CMS | BIC Administration'); ?>
<?php $__env->startSection('admin-content'); ?>
<div class="admin-page-header">
    <div class="admin-header-top">
        <div>
            <p class="eyebrow">Content Management</p>
            <h1>Insights CMS</h1>
        </div>
        <div class="admin-header-actions">
            <div class="admin-export-group">
                <a href="<?php echo e(route('admin.insights.export', array_merge(request()->query(), ['format' => 'csv']))); ?>" class="admin-btn-export" title="Download filtered insights to Excel (.csv)">
                    <svg class="admin-btn-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg>
                    <span>Download Excel</span>
                </a>
                <a href="<?php echo e(route('admin.insights.export', array_merge(request()->query(), ['format' => 'json']))); ?>" class="admin-btn-export-subtle" title="Download insights in JSON format">
                    <svg class="admin-btn-icon" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="16 18 22 12 16 6"></polyline>
                        <polyline points="8 6 2 12 8 18"></polyline>
                    </svg>
                    <span>JSON</span>
                </a>
            </div>

            <a class="admin-primary admin-btn-create" href="<?php echo e(route('admin.insights.create')); ?>">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                <span>New Insight</span>
            </a>
        </div>
    </div>

    <div class="admin-toolbar">
        <form class="admin-filters" method="GET" action="<?php echo e(route('admin.insights.index')); ?>">
            <div class="admin-search-wrap">
                <svg class="admin-search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input type="text" name="search" placeholder="Search title, author, category..." value="<?php echo e(request('search')); ?>">
            </div>
            <select name="category" onchange="this.form.submit()">
                <option value="">All Categories</option>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($category); ?>" <?php if(request('category')===$category): echo 'selected'; endif; ?>><?php echo e($category); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <select name="status" onchange="this.form.submit()">
                <option value="">All Statuses</option>
                <?php $__currentLoopData = ['draft','published','archived']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($status); ?>" <?php if(request('status')===$status): echo 'selected'; endif; ?>><?php echo e(ucfirst($status)); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <button type="submit" class="admin-btn-filter">Filter</button>
            <?php if(request()->anyFilled(['search', 'category', 'status'])): ?>
                <a href="<?php echo e(route('admin.insights.index')); ?>" class="admin-btn-clear">Clear</a>
            <?php endif; ?>
        </form>
    </div>
</div>

<div class="admin-table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Published Date</th>
                <th>Featured</th>
                <th style="text-align: right;">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $insights; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $insight): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="fw-medium">
                        <a href="<?php echo e(route('admin.insights.edit', $insight)); ?>" class="admin-table-title-link">
                            <?php echo e(Str::limit($insight->title, 50)); ?>

                        </a>
                    </td>
                    <td class="text-muted-cell"><?php echo e($insight->category ?: '—'); ?></td>
                    <td><span class="status-pill status-<?php echo e(ucfirst($insight->status)); ?>"><span class="status-dot"></span><?php echo e(ucfirst($insight->status)); ?></span></td>
                    <td class="text-muted-cell"><?php echo e($insight->published_at?->format('d M Y') ?: '—'); ?></td>
                    <td>
                        <?php if($insight->featured): ?>
                            <span class="badge-featured">Featured</span>
                        <?php else: ?>
                            <span class="text-muted-cell">No</span>
                        <?php endif; ?>
                    </td>
                    <td style="text-align: right;">
                        <div style="display: inline-flex; align-items: center; justify-content: flex-end; gap: 8px;">
                            <a href="<?php echo e(route('admin.insights.edit', $insight)); ?>" class="admin-btn-action-edit" title="Edit insight">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                <span>Edit</span>
                            </a>
                            <form method="POST" action="<?php echo e(route('admin.insights.destroy', $insight)); ?>" onsubmit="return confirm('Are you sure you want to delete this insight: &quot;<?php echo e(addslashes($insight->title)); ?>&quot;? This action cannot be undone.');" style="display: inline; margin: 0;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="admin-btn-action-delete" title="Delete insight">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="table-empty-cell">
                        <div class="admin-empty-state">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="color: var(--admin-text-muted); margin-bottom: 12px;">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="8" y1="12" x2="16" y2="12"></line>
                            </svg>
                            <p>No insights found matching your current filter criteria.</p>
                            <?php if(request()->anyFilled(['search', 'category', 'status'])): ?>
                                <a href="<?php echo e(route('admin.insights.index')); ?>" class="admin-btn-clear" style="margin-top: 8px;">Reset filters</a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="admin-pagination-wrap">
    <?php echo e($insights->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DESIGN\Downloads\BIC_Laravel_Production_Source\resources\views/admin/insights/index.blade.php ENDPATH**/ ?>