<?php $__env->startSection('title', $config['title'].' | Bridge India Capital'); ?>
<?php $__env->startSection('description', $config['purpose']); ?>
<?php $__env->startSection('robots', 'noindex,nofollow'); ?>

<?php $__env->startSection('content'); ?>
<main class="inquiry-page" id="main">
    <div class="inquiry-container">
        <a class="inquiry-wordmark" href="<?php echo e(route('home')); ?>" aria-label="Bridge India Capital home"><span>BIC</span><small>Bridge India Capital</small></a>

        <div class="inquiry-intro">
            <p class="eyebrow">Initial inquiry · <?php echo e($type === 'ma' ? 'M&A' : strtoupper($type)); ?></p>
            <h1><?php echo e($config['title']); ?></h1><p><?php echo e($config['purpose']); ?></p>
            <p class="inquiry-privacy-note">Please provide only the requested initial information. Do not submit identity documents, bank statements, full financial statements, complete cap tables or confidential customer lists.</p>
        </div>

        <?php if(session('submission')): ?>
            <div class="inquiry-result">
                <div class="state-panel state-panel--success" style="text-align: center; padding: 48px 32px;">
                    <div style="width: 56px; height: 56px; border-radius: 50%; background: rgba(34, 197, 94, 0.12); color: #16a34a; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                    </div>
                    <h2 style="font-size: 26px; font-family: Georgia, serif; color: #1e293b; margin: 0 0 24px;">Your response has been submitted successfully.</h2>
                    <p><a class="button button--primary" href="<?php echo e(route('home')); ?>">Back to Home</a></p>
                </div>
            </div>
        <?php else: ?>
        <form class="inquiry-form" action="<?php echo e(route('inquiries.store', $type)); ?>" method="post" enctype="multipart/form-data" novalidate data-inquiry-form>
            <?php echo csrf_field(); ?>
            <nav class="form-progress" aria-label="Form progress"><ol>
                <?php $__currentLoopData = $config['steps']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li data-current="<?php echo e($loop->first ? 'true' : 'false'); ?>"><button type="button" data-step-button="<?php echo e($loop->index); ?>" <?php if(!$loop->first): echo 'disabled'; endif; ?> aria-current="<?php echo e($loop->first ? 'step' : 'false'); ?>"><span><?php echo e($loop->iteration); ?></span><span class="form-progress-label"><?php echo e($step['title']); ?></span></button></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ol></nav>
            <div class="form-error-summary" role="alert" tabindex="-1" hidden><strong>Review this step</strong><span>Correct the highlighted fields before continuing.</span></div>
            <div class="submission-state" role="status" hidden></div>
            <?php $__currentLoopData = $config['steps']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <fieldset class="inquiry-step" data-step="<?php echo e($loop->index); ?>" <?php if(!$loop->first): ?> hidden <?php endif; ?>>
                <legend><?php echo e($step['title']); ?></legend>
                <div class="inquiry-fields">
                <?php $__currentLoopData = $step['fields']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php ($id = 'inquiry-'.$field['name']); ?>
                    <?php if($field['type'] === 'checkbox'): ?>
                    <div class="inquiry-checkbox-field" data-field="<?php echo e($field['name']); ?>"><label class="checkbox"><input class="checkbox__control" id="<?php echo e($id); ?>" name="<?php echo e($field['name']); ?>" type="checkbox" value="1" <?php if(old($field['name'])): echo 'checked'; endif; ?> <?php if($field['required']): ?> required <?php endif; ?>><span><?php echo e($field['label']); ?><?php if($field['required']): ?> <span aria-hidden="true">*</span><?php endif; ?></span></label><p class="field__error" id="<?php echo e($id); ?>-error" role="alert" hidden></p></div>
                    <?php else: ?>
                    <div class="field" data-field="<?php echo e($field['name']); ?>">
                        <label class="field__label" for="<?php echo e($id); ?>"><?php echo e($field['label']); ?><?php if($field['required']): ?> <span aria-hidden="true">*</span><?php endif; ?></label>
                        <?php if(isset($field['hint'])): ?><p class="field__hint" id="<?php echo e($id); ?>-hint"><?php echo e($field['hint']); ?></p><?php endif; ?>
                        <?php if($field['type'] === 'select'): ?>
                        <select class="control" id="<?php echo e($id); ?>" name="<?php echo e($field['name']); ?>" <?php if($field['required']): ?> required <?php endif; ?>><option value="">Select an option</option><?php $__currentLoopData = $field['options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($option['value']); ?>" <?php if(old($field['name']) === $option['value']): echo 'selected'; endif; ?>><?php echo e($option['label']); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select>
                        <?php elseif($field['type'] === 'textarea'): ?>
                        <textarea class="control control--textarea" id="<?php echo e($id); ?>" name="<?php echo e($field['name']); ?>" maxlength="1200" <?php if($field['required']): ?> required <?php endif; ?>><?php echo e(old($field['name'])); ?></textarea>
                        <?php elseif($field['type'] === 'file'): ?>
                        <input class="control" id="<?php echo e($id); ?>" name="<?php echo e($field['name']); ?>" type="file" accept="application/pdf,.pdf">
                        <?php else: ?>
                        <input class="control" id="<?php echo e($id); ?>" name="<?php echo e($field['name']); ?>" type="<?php echo e($field['type']); ?>" value="<?php echo e(old($field['name'])); ?>" maxlength="254" <?php if(isset($field['autoComplete'])): ?> autocomplete="<?php echo e($field['autoComplete']); ?>" <?php endif; ?> <?php if($field['required']): ?> required <?php endif; ?>>
                        <?php endif; ?>
                        <p class="field__error" id="<?php echo e($id); ?>-error" role="alert" hidden></p>
                    </div>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </fieldset>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <div class="inquiry-actions">
                <a class="button button--quiet" href="<?php echo e(route('home')); ?>" data-home-back>Back</a>
                <button class="button button--quiet" type="button" data-back hidden>Back</button>
                <button class="button button--primary" type="button" data-next>Continue</button>
                <button class="button button--primary" type="submit" data-submit hidden>Submit inquiry</button>
            </div>
            <div class="honeypot" aria-hidden="true"><label for="companyFax">Company fax</label><input id="companyFax" name="companyFax" tabindex="-1" autocomplete="off"></div>
        </form>
        <?php endif; ?>
    </div>
</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DESIGN\Downloads\BIC_Laravel_Production_Source\resources\views/inquiries/create.blade.php ENDPATH**/ ?>