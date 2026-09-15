<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['insights']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['insights']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<section class="insights reveal" id="insights">
    <div class="eyebrow">Insights</div><h2 class="big">Ideas for better capital and transaction decisions.</h2>
    <div class="insights-grid">
        <?php $__currentLoopData = $insights; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $insight): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <article class="article"><a href="<?php echo e(route('insights.show', $insight->slug)); ?>"><div class="thumb"><img src="<?php echo e(asset($insight->cover_image)); ?>" alt="<?php echo e($insight->alt_text); ?>"></div><h3><?php echo e($insight->title); ?></h3><p><?php echo e($insight->summary); ?></p></a></article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</section>

<?php /**PATH C:\Users\DESIGN\Downloads\BIC_Laravel_Production_Source\resources\views/components/home/insights.blade.php ENDPATH**/ ?>