<?php $__env->startSection('authContent'); ?>
    <div class="bg-primary">
        <div class="row g-0 bg-primary-dark-op">
            <div class="hero-static col-lg-4 d-none d-lg-flex flex-column justify-content-center">
                <div class="p-4 p-xl-5 flex-grow-1 d-flex align-items-center">
                    <div class="w-100">
                        <a class="link-fx fw-semibold fs-2 text-white" href="<?php echo e(route('admin.dashboard')); ?>">
                            One<span class="fw-normal">UI</span>
                        </a>
                        <p class="text-white-75 me-xl-8 mt-2">
                            Don’t worry, we’ve got your back. You’ll be soon back to your favorite dashboard!
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
                                Password Reminder
                            </h1>
                            <p class="fw-medium text-muted">
                                Please provide your account’s email or username and we will send you your password.
                            </p>
                        </div>
                        <div class="row g-0 justify-content-center">
                            <div class="col-sm-8 col-xl-4">
                                <form class="js-validation-reminder" action="<?php echo e(route('forget.password.post')); ?>"
                                    method="POST">
                                    <?php echo csrf_field(); ?>
                                    <div class="mb-4">
                                        <input type="text" class="form-control form-control-lg form-control-alt py-3"
                                            id="reminder-credential" name="email" placeholder="Email">
                                        <?php if($errors->has('email')): ?>
                                            <span class="text-danger"><?php echo e($errors->first('email')); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-lg btn-alt-primary">
                                            <i class="fa fa-fw fa-envelope me-1 opacity-50"></i> Send Mail
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="px-4 py-3 w-100 d-lg-none d-flex flex-column flex-sm-row justify-content-between fs-sm text-center text-sm-start">
                    <p class="fw-medium text-black-50 py-2 mb-0">
                        <strong>OneUI 5.4</strong> &copy; <span data-toggle="year-copy"></span>
                    </p>
                    <ul class="list list-inline py-2 mb-0">
                        <li class="list-inline-item">
                            <a class="text-muted fw-medium" href="javascript:void(0)">Legal</a>
                        </li>
                        <li class="list-inline-item">
                            <a class="text-muted fw-medium" href="javascript:void(0)">Contact</a>
                        </li>
                        <li class="list-inline-item">
                            <a class="text-muted fw-medium" href="javascript:void(0)">Terms</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('styles'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.authMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\LaravelPanel\resources\views/backend/emailForget/forgetPassword.blade.php ENDPATH**/ ?>