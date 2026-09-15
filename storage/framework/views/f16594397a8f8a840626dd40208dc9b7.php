<?php $__env->startSection('title', 'Admin Login | Bridge India Capital'); ?>
<?php $__env->startSection('admin-content'); ?>
<div class="admin-login-wrapper">
    <div class="admin-login-card">
        <div class="admin-login-header">
            <div class="admin-brand-mark admin-login-logo">BIC</div>
            <p class="eyebrow">Secure Portal</p>
            <h1>Admin Login</h1>
            <p class="admin-login-sub">Bridge India Capital Administration</p>
        </div>

        <form method="post" action="<?php echo e(route('admin.login.store')); ?>" class="admin-login-form">
            <?php echo csrf_field(); ?>
            <label>
                <span>Email Address</span>
                <input name="email" type="email" value="<?php echo e(old('email')); ?>" required autocomplete="email" placeholder="admin@bridgeindiacapital.com" autofocus>
            </label>
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="admin-error"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

            <label>
                <span>Password</span>
                <input name="password" type="password" required autocomplete="current-password" placeholder="••••••••">
            </label>
            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="admin-error"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

            <div class="admin-login-options">
                <label class="admin-check">
                    <input name="remember" type="checkbox" value="1">
                    <span>Keep me signed in</span>
                </label>
            </div>

            <button class="admin-primary admin-btn-block" type="submit">Sign In to Dashboard</button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DESIGN\Downloads\BIC_Laravel_Production_Source\resources\views/admin/login.blade.php ENDPATH**/ ?>