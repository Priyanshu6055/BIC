<?php $__env->startSection('title', 'Admin login | Bridge India Capital'); ?>
<?php $__env->startSection('admin-content'); ?>
<div class="admin-login"><div><p class="eyebrow">Secure administration</p><h1>Admin login</h1><form method="post" action="<?php echo e(route('admin.login.store')); ?>"><?php echo csrf_field(); ?>
    <label>Email<input name="email" type="email" value="<?php echo e(old('email')); ?>" required autocomplete="email"></label><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="admin-error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    <label>Password<input name="password" type="password" required autocomplete="current-password"></label><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="admin-error"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    <label class="admin-check"><input name="remember" type="checkbox" value="1"> Keep me signed in</label><button class="admin-primary" type="submit">Sign in</button>
</form></div></div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DESIGN\Downloads\BIC_Laravel_Production_Source\resources\views/admin/login.blade.php ENDPATH**/ ?>