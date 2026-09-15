<?php $__env->startSection('title', ($insight->exists ? 'Edit' : 'Create').' Insight | BIC Admin'); ?>
<?php $__env->startSection('admin-content'); ?>
<div class="admin-detail-header">
    <div class="admin-detail-title">
        <a href="<?php echo e(route('admin.insights.index')); ?>" class="admin-btn-back">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back to Insights
        </a>
        <div class="admin-detail-meta">
            <p class="eyebrow">Content Management</p>
            <h1><?php echo e($insight->exists ? 'Edit Insight' : 'Create New Insight'); ?></h1>
        </div>
    </div>
</div>

<form class="admin-form-card" method="post" enctype="multipart/form-data" action="<?php echo e($insight->exists ? route('admin.insights.update', $insight) : route('admin.insights.store')); ?>">
    <?php echo csrf_field(); ?>
    <?php if($insight->exists): ?>
        <?php echo method_field('PUT'); ?>
    <?php endif; ?>

    <div class="admin-form-grid">
        <label class="wide">
            <span>Title <strong class="req">*</strong></span>
            <input name="title" value="<?php echo e(old('title', $insight->title)); ?>" required placeholder="e.g. Navigating Indian Seed-Stage Valuation Trends">
        </label>
        
        <label class="wide">
            <span>Slug (URL Segment)</span>
            <input name="slug" value="<?php echo e(old('slug', $insight->slug)); ?>" placeholder="Generated from title automatically if empty">
        </label>
        
        <label class="wide">
            <span>Summary / Excerpt <strong class="req">*</strong></span>
            <textarea name="summary" rows="3" required placeholder="Brief excerpt summarizing key findings..."><?php echo e(old('summary', $insight->summary)); ?></textarea>
        </label>
        
        <label class="wide">
            <span>Full Article Body (Markdown supported) <strong class="req">*</strong></span>
            <textarea name="body" rows="14" required placeholder="Write the complete article content..."><?php echo e(old('body', $insight->body)); ?></textarea>
        </label>
        
        <label>
            <span>Cover Image File</span>
            <input name="cover_upload" type="file" accept="image/*">
            <?php if($insight->cover_image): ?>
                <small class="admin-input-hint">Current: <?php echo e($insight->cover_image); ?></small>
            <?php endif; ?>
        </label>
        
        <label>
            <span>Image Alt Text</span>
            <input name="alt_text" value="<?php echo e(old('alt_text', $insight->alt_text)); ?>" placeholder="Image description for accessibility">
        </label>
        
        <label>
            <span>Author</span>
            <input name="author" value="<?php echo e(old('author', $insight->author)); ?>" placeholder="e.g. BIC Investment Committee">
        </label>
        
        <label>
            <span>Category</span>
            <input name="category" value="<?php echo e(old('category', $insight->category)); ?>" placeholder="e.g. Venture Capital, M&A Advisory">
        </label>
        
        <label>
            <span>Publication Status</span>
            <select name="status">
                <?php $__currentLoopData = ['draft','published','archived']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($status); ?>" <?php if(old('status', $insight->status ?: 'draft')===$status): echo 'selected'; endif; ?>><?php echo e(ucfirst($status)); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </label>
        
        <label>
            <span>Publish Date & Time</span>
            <input name="published_at" type="datetime-local" value="<?php echo e(old('published_at', $insight->published_at?->format('Y-m-d\TH:i'))); ?>">
        </label>
        
        <div class="wide admin-check-wrap">
            <label class="admin-check">
                <input name="featured" type="checkbox" value="1" <?php if(old('featured', $insight->featured)): echo 'checked'; endif; ?>>
                <span>Feature this insight on BIC homepage & featured hero carousel</span>
            </label>
        </div>
        
        <div class="wide" style="border-top: 1px solid var(--admin-border); padding-top: 24px; margin-top: 12px;">
            <h3 style="font-size: 16px; margin: 0 0 16px; font-weight: 600; color: var(--admin-text-main);">Search Engine Optimization (SEO)</h3>
        </div>

        <label class="wide">
            <span>SEO Meta Title</span>
            <input name="seo_title" value="<?php echo e(old('seo_title', $insight->seo_title)); ?>" placeholder="Custom meta title for Google (optional)">
        </label>
        
        <label class="wide">
            <span>SEO Meta Description</span>
            <textarea name="seo_description" rows="2" placeholder="Custom meta description for search engine previews (optional)"><?php echo e(old('seo_description', $insight->seo_description)); ?></textarea>
        </label>
    </div>

    <?php if($errors->any()): ?>
        <div class="admin-error-box">
            <strong>Please correct the form errors:</strong>
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="admin-form-actions">
        <button class="admin-primary" type="submit">Save Insight</button>
        <a href="<?php echo e(route('admin.insights.index')); ?>" class="admin-btn-clear">Cancel</a>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DESIGN\Downloads\BIC_Laravel_Production_Source\resources\views/admin/insights/form.blade.php ENDPATH**/ ?>