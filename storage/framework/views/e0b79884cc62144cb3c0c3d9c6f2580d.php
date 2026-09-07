<section class="advisory-layer reveal">
    <div class="advisory-photo"><img src="<?php echo e(asset('images/approved/boardroom-hd.webp')); ?>" alt="Modern boardroom prepared for a strategic business discussion"></div>
    <div class="advisory-copy">
        <div class="eyebrow">The advisory layer</div><h2>The best transaction work often begins before the transaction.</h2>
        <p>Capital becomes easier to evaluate when the business is prepared. BIC can work with founders and promoters before a formal raise or M&amp;A process to clarify the story, structure the opportunity and improve readiness.</p>
        <div class="advisory-points">
            <div><strong>MSME readiness:</strong> clarify financials, structure, governance and the equity story before approaching investors.</div>
            <div><strong>Startup pilots:</strong> focused engagements that build understanding, evidence and readiness before a formal capital conversation.</div>
            <div><strong>Transaction preparation:</strong> define what the business needs, why it needs it and which counterparties are genuinely relevant.</div>
        </div>
    </div>
</section>
<?php
$steps = [
['Discover','Understand the business, objective, readiness and immediate constraint.'],
['Assess and structure','Shape the capital or transaction requirement around the business—not around a standard template.'],
['Align','Identify investors or counterparties whose mandate and potential contribution fit the opportunity.'],
['Execute','Support a clear process through discussion, diligence, terms, negotiation and closing.'],
['Support','Continue with agreed post-transaction, integration or transition support where relevant.'],
];
?>
<section class="process reveal">
    <div class="eyebrow">How it works</div><h2 class="big">A disciplined path from first conversation to transaction support.</h2>
    <div class="process-grid"><?php $__currentLoopData = $steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$title,$copy]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><article class="step"><span><?php echo e(str_pad((string)$loop->iteration, 2, '0', STR_PAD_LEFT)); ?></span><h3><?php echo e($title); ?></h3><p><?php echo e($copy); ?></p></article><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></div>
</section>

<?php /**PATH C:\Users\DESIGN\Downloads\BIC_Laravel_Production_Source\resources\views/components/home/process.blade.php ENDPATH**/ ?>