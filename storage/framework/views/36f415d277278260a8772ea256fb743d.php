<?php $__env->startSection('title', $insight->seo_title ?: $insight->title.' | Bridge India Capital'); ?>
<?php $__env->startSection('description', $insight->seo_description ?: $insight->summary); ?>
<?php $__env->startSection('og_type', 'article'); ?>
<?php $__env->startSection('og_image', asset($insight->cover_image)); ?>
<?php $__env->startSection('content'); ?>
<main class="insight-detail"><a class="inquiry-wordmark" href="<?php echo e(route('home')); ?>"><span>BIC</span><small>Bridge India Capital</small></a><article><p class="eyebrow"><?php echo e($insight->category); ?></p><h1><?php echo e($insight->title); ?></h1><p class="insight-summary"><?php echo e($insight->summary); ?></p><?php if($insight->cover_image): ?><img src="<?php echo e(asset($insight->cover_image)); ?>" alt="<?php echo e($insight->alt_text); ?>"><?php endif; ?><div class="insight-body"><?php echo nl2br(e($insight->body)); ?></div><footer><?php echo e($insight->author); ?> · <?php echo e($insight->published_at?->format('d M Y')); ?></footer></article></main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DESIGN\Downloads\BIC_Laravel_Production_Source\resources\views/insights/show.blade.php ENDPATH**/ ?>