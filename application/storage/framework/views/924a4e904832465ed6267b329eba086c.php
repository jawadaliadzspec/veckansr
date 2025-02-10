
<?php $__env->startSection('content'); ?>
    <div class="container my-5">
        <div class="card shadow-lg border-0 rounded-4 mx-auto">
            <!-- Image and Logo Section -->
            <div class="position-relative">
                <img src="<?php echo e($coupon->thumnail); ?>" class="card-img-top" alt="Offer Image">

                <div class="position-absolute start-50 translate-middle bg-white px-2 rounded-3 shadow-sm fw-bold">



                    <img src="<?php echo e(getImage(getFilePath('store') . '/' . @$coupon->store->image)); ?>" width="90px" height="90px"
                         alt="<?php echo app('translator')->get('Store Image'); ?>">
                </div>
            </div>

            <!-- Offer Body -->
            <div class="card-body text-center py-60">
                <h3 class="card-title fw-bold"><?php echo e($coupon->title); ?></h3>
                <p class="card-text"><?php echo e($coupon->description); ?></p>
                <!-- Offer Button -->
                <a href="<?php echo e($coupon->link); ?>" target="_blank" class="btn btn--base">To the Offer</a>

                <!-- Terms -->

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\adzspec\veckansr\application\resources\views/presets/default/coupon_details.blade.php ENDPATH**/ ?>