<?php
$services = [
['strategic-investment-hd.webp','Strategic investment discussion with business leaders','Strategic investment for startups','For startups with real traction that need growth capital—and investors who can contribute access, credibility, governance or follow-on support.'],
['msme-growth-hd.webp','MSME leadership reviewing growth plans in an operating business','Equity capital raising for MSMEs','For established businesses seeking growth equity, stronger balance-sheet flexibility and a credible route beyond additional debt.'],
['ma-advisory-hd.webp','Corporate leaders discussing a strategic transaction','M&A advisory','For founders, promoters, corporates and acquirers evaluating exits, acquisitions, consolidation or strategic combinations.'],
];
?>
<section class="section alt reveal" id="what">
    <div class="eyebrow">What we do</div>
    <div class="split"><h2 class="big">Three services. One connected capital journey.</h2><p class="copy">A company may begin with readiness, move into a capital raise, and later pursue an acquisition, consolidation or strategic sale. BIC connects these stages instead of treating them as separate conversations.</p></div>
    <div class="service-image-grid">
        <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$image,$alt,$title,$copy]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <article class="service-image"><div class="media"><img src="<?php echo e(asset('images/approved/'.$image)); ?>" alt="<?php echo e($alt); ?>"></div><div class="body"><h3><?php echo e($title); ?></h3><p><?php echo e($copy); ?></p></div></article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</section>

<?php /**PATH C:\Users\DESIGN\Downloads\BIC_Laravel_Production_Source\resources\views/components/home/services.blade.php ENDPATH**/ ?>