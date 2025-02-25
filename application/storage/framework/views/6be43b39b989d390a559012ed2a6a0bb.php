<?php $__env->startSection('content'); ?>

<!-- exclusive item section -->
<!-- < popular -->
<section class="popular-section section-bg-before py-115 bg--img" style="background: url(<?php echo e(asset($activeTemplateTrue.'images/bg/popular-bg.png')); ?>)">
    <div class="container">
        <div class="row gy-4 justify-content-center">
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="coupon-card-2 wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">

                        <div class="icon-wrap">
                            <img src="<?php echo e(getImage(getFilePath('category') . '/' . $item->image)); ?>" alt="<?php echo app('translator')->get('popular-image'); ?>">
                        </div>
                        <a href="<?php echo e(route("category.coupons", $item->id)); ?>" class="title-cat">
                            <?php if(strlen(__($item->name)) > 20): ?>
                            <?php echo e(substr(__($item->name), 0, 20) . '...'); ?>

                            <?php else: ?>
                                <?php echo e(__($item->name)); ?>

                            <?php endif; ?>
                        </a>
                        <span class="text--base"><?php echo e($item->coupons->count()); ?> <?php echo app('translator')->get('coupons'); ?></span>

                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="row py-4">
            <?php if($categories->hasPages()): ?>
                <div class="py-4">
                    <?php echo e(paginateLinks($categories)); ?>

                </div>
            <?php endif; ?>
        </div>
    
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate.'layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/veckansr/application/resources/views/presets/default/categories.blade.php ENDPATH**/ ?>