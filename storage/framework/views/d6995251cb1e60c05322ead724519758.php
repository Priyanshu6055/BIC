<?php $__env->startSection('title', 'Insights & Research | Bridge India Capital'); ?>
<?php $__env->startSection('description', 'Ideas for better capital and transaction decisions from Bridge India Capital.'); ?>

<?php $__env->startSection('content'); ?>
<div class="insights-shell">
    <?php if (isset($component)) { $__componentOriginalb9bbfe885e55d0fbef8fd518e902a9d7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb9bbfe885e55d0fbef8fd518e902a9d7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.header','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb9bbfe885e55d0fbef8fd518e902a9d7)): ?>
<?php $attributes = $__attributesOriginalb9bbfe885e55d0fbef8fd518e902a9d7; ?>
<?php unset($__attributesOriginalb9bbfe885e55d0fbef8fd518e902a9d7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb9bbfe885e55d0fbef8fd518e902a9d7)): ?>
<?php $component = $__componentOriginalb9bbfe885e55d0fbef8fd518e902a9d7; ?>
<?php unset($__componentOriginalb9bbfe885e55d0fbef8fd518e902a9d7); ?>
<?php endif; ?>

    <main class="insights-main">
        <div class="insights-container">
            <div class="insight-nav-bar">
                <a href="<?php echo e(route('home')); ?>" class="insight-back-btn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                    Back to Home
                </a>
                <span class="insight-category-badge">BIC Strategy &amp; Research</span>
            </div>

            <header class="insight-article-header" style="margin-bottom: 48px;">
                <p class="eyebrow" style="color: var(--accent); margin-bottom: 12px;">Market Perspectives</p>
                <h1 class="insight-article-title" style="margin-bottom: 16px;">Ideas for better capital and transaction decisions.</h1>
                <p style="font-size: 17px; line-height: 1.6; color: var(--muted); max-width: 680px; margin: 0;">In-depth analyses, advisory frameworks, and market notes on early-stage investments, MSME equity readiness, and Indian M&amp;A dynamics.</p>
            </header>

            <div class="insights-grid" style="margin-top: 0; margin-bottom: 48px;">
                <?php $__currentLoopData = $insights; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $insight): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <article class="article">
                    <a href="<?php echo e(route('insights.show', $insight->slug)); ?>" style="display: block; text-decoration: none; color: inherit;">
                        <?php if($insight->cover_image): ?>
                        <div class="thumb" style="border-radius: 6px; overflow: hidden; margin-bottom: 16px; height: 220px;">
                            <img src="<?php echo e(asset($insight->cover_image)); ?>" alt="<?php echo e($insight->alt_text ?: $insight->title); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <?php endif; ?>
                        <p class="eyebrow" style="margin-bottom: 8px; font-size: 10px; color: var(--accent); font-weight: 700;"><?php echo e($insight->category); ?></p>
                        <h2 style="font-family: Georgia, serif; font-size: 22px; line-height: 1.25; margin: 0 0 10px; color: var(--ink);"><?php echo e($insight->title); ?></h2>
                        <p style="font-size: 14px; line-height: 1.6; color: var(--muted); margin: 0;"><?php echo e($insight->summary); ?></p>
                    </a>
                </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div style="margin-top: 36px;">
                <?php echo e($insights->links()); ?>

            </div>
        </div>
    </main>

    <?php if (isset($component)) { $__componentOriginal072e9a89eb33ca4c48f7e8f7970944d7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal072e9a89eb33ca4c48f7e8f7970944d7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.footer','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.footer'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal072e9a89eb33ca4c48f7e8f7970944d7)): ?>
<?php $attributes = $__attributesOriginal072e9a89eb33ca4c48f7e8f7970944d7; ?>
<?php unset($__attributesOriginal072e9a89eb33ca4c48f7e8f7970944d7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal072e9a89eb33ca4c48f7e8f7970944d7)): ?>
<?php $component = $__componentOriginal072e9a89eb33ca4c48f7e8f7970944d7; ?>
<?php unset($__componentOriginal072e9a89eb33ca4c48f7e8f7970944d7); ?>
<?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DESIGN\Downloads\BIC_Laravel_Production_Source\resources\views/insights/index.blade.php ENDPATH**/ ?>