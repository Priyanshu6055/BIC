<?php
$factors = [
['Market access','Relevant relationships that can open customers, channels, partnerships or new markets.'],
['Governance depth','Board-level perspective, stronger decision-making and readiness for institutional growth.'],
['Follow-on capital','A stronger basis for future rounds, syndication and the next stage of capital.'],
['Institutional credibility','Greater confidence, stronger signalling and a more credible position with future stakeholders.'],
['Category relevance','Brand reach, operating knowledge or strategic association where it genuinely creates value.'],
];
?>
<section class="motion-story reveal" id="why">
    <div class="motion-stage">
        <div class="motion-copy"><div class="eyebrow">Why BIC</div><h2>Capital is the input.<br>The +1 is the advantage.</h2><p>No two businesses need the same investor. BIC identifies the strategic contribution that matters for that transaction and evaluates the relationship accordingly.</p></div>
        <div class="factor-stage" aria-label="Capital plus one factors">
            <?php $__currentLoopData = $factors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$title,$copy]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="factor-card" data-factor="<?php echo e($loop->index); ?>"><small>Capital +1 · <?php echo e(str_pad((string)$loop->iteration, 2, '0', STR_PAD_LEFT)); ?></small><h3><?php echo e($title); ?></h3><p><?php echo e($copy); ?></p></div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <div class="factor-dots" aria-hidden="true"><?php $__currentLoopData = $factors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $factor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><i></i><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></div>
        </div>
    </div>
</section>

<?php /**PATH C:\Users\DESIGN\Downloads\BIC_Laravel_Production_Source\resources\views/components/home/capital-plus-one.blade.php ENDPATH**/ ?>