<?php $__env->startSection('authContent'); ?>
    
<?php $__env->startSection('authContent'); ?>
    <div class="bg-primary-dark">
        <div class="row g-0 bg-primary-dark-op">
            <div class="hero-static col-lg-4 d-none d-lg-flex flex-column justify-content-center">
                <div class="p-4 p-xl-5 flex-grow-1 d-flex align-items-center">
                    <div class="w-100">
                        <a class="link-fx fw-semibold fs-2 text-white" href="index.html">
                            One<span class="fw-normal">UI</span>
                        </a>
                        <p class="text-white-75 me-xl-8 mt-2">
                            Creating a new account is completely free. Get started with 5 projects to manage and feel free
                            to upgrade as your business grow.
                        </p>
                    </div>
                </div>
                <div class="p-4 p-xl-5 d-xl-flex justify-content-between align-items-center fs-sm">
                    <p class="fw-medium text-white-50 mb-0">
                        <strong>OneUI 5.4</strong> &copy; <span data-toggle="year-copy"></span>
                    </p>
                    <ul class="list list-inline mb-0 py-2">
                        <li class="list-inline-item">
                            <a class="text-white-75 fw-medium" href="javascript:void(0)">Legal</a>
                        </li>
                        <li class="list-inline-item">
                            <a class="text-white-75 fw-medium" href="javascript:void(0)">Contact</a>
                        </li>
                        <li class="list-inline-item">
                            <a class="text-white-75 fw-medium" href="javascript:void(0)">Terms</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="hero-static col-lg-8 d-flex flex-column align-items-center bg-body-extra-light">
                <div class="p-3 w-100 d-lg-none text-center">
                    <a class="link-fx fw-semibold fs-3 text-dark" href="index.html">
                        One<span class="fw-normal">UI</span>
                    </a>
                </div>
                <div class="p-4 w-100 flex-grow-1 d-flex align-items-center">
                    <div class="w-100">
                        <div class="text-center mb-5">
                            <p class="mb-3">
                                <i class="fa fa-2x fa-circle-notch text-primary-light"></i>
                            </p>
                            <h1 class="fw-bold mb-2">
                                Reset Email Account
                            </h1>
                            <p class="fw-medium text-muted">
                                Get your access today in one easy step
                            </p>
                        </div>
                        <div class="row g-0 justify-content-center">
                            <div class="col-sm-8 col-xl-4">
                                <form class="js-validation-signup" action="<?php echo e(route('reset.password.post')); ?>"
                                    method="POST">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="token" value="<?php echo e($token); ?>">
                                    <div class="mb-4">
                                        <input type="email" class="form-control form-control-lg form-control-alt py-3"
                                            id="signup-email" name="email" placeholder="Email">
                                        <?php if($errors->has('email')): ?>
                                            <span class="text-danger"><?php echo e($errors->first('email')); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="mb-4">
                                        <input type="password" class="form-control form-control-lg form-control-alt py-3"
                                            id="signup-password" name="password" placeholder="Password">
                                        <?php if($errors->has('password')): ?>
                                            <span class="text-danger"><?php echo e($errors->first('password')); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="mb-4">
                                        <input type="password" class="form-control form-control-lg form-control-alt py-3"
                                            id="signup-password-confirm" name="password_confirmation"
                                            placeholder="Confirm Password">
                                        <?php if($errors->has('password_confirmation')): ?>
                                            <span class="text-danger"><?php echo e($errors->first('password_confirmation')); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-lg btn-alt-success">
                                            Reset Password
                                        </button>
                                        <a href="<?php echo e(route('admin.dashboard')); ?>"
                                            class="btn btn-lg btn-alt-danger">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('styles'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('styles'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.authMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('backend.layouts.authMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\LaravelPanel\resources\views/backend/emailForget/forgetPasswordLink.blade.php ENDPATH**/ ?>