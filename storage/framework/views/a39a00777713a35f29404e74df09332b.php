<?php
$audiences = [
['01','strategic-investment-hd.webp','Startup founder and advisors in a capital discussion','Startups','Traction-led startups seeking growth capital, strategic investors and support beyond the cheque.','startup','For startups →'],
['02','msme-growth-hd.webp','MSME promoters inside a modern operating business','MSMEs','Established MSMEs seeking equity capital for expansion, ownership transition, professionalisation or growth.','msme','For MSMEs →'],
['03','network-hd.webp','Strategic capital network representing investors and counterparties','Investors','HNIs, UHNIs, family offices and corporates seeking prepared, relevant and relationship-sourced opportunities.','investor','For investors →'],
['04','ma-advisory-hd.webp','Business leaders discussing mergers and acquisitions','Strategic partners and acquirers','Corporates, acquirers and strategic partners seeking direct investments, partnerships or acquisition opportunities.','ma','For strategic partners →'],
];
?>
<section class="section reveal" id="serve">
    <div class="eyebrow">Who we serve</div>
    <div class="split"><h2 class="big">Different objectives. One place to begin.</h2><p class="copy">Choose the route that reflects where you are today. BIC will assess fit, readiness and the most relevant next conversation.</p></div>
    <div class="audience-grid">
        <?php $__currentLoopData = $audiences; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$number,$image,$alt,$title,$copy,$routeType,$link]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <article class="audience"><div class="audience-media"><img src="<?php echo e(asset('images/approved/'.$image)); ?>" alt="<?php echo e($alt); ?>"></div><div class="audience-body"><strong><?php echo e($number); ?></strong><h3><?php echo e($title); ?></h3><p><?php echo e($copy); ?></p><a href="<?php echo e(route('inquiries.create', $routeType)); ?>"><?php echo e($link); ?></a></div></article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</section>
<?php /**PATH C:\Users\DESIGN\Downloads\BIC_Laravel_Production_Source\resources\views/components/home/audience.blade.php ENDPATH**/ ?>