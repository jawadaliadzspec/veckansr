<?php
    $popularCoupon = getContent('categories.content', true);
    $popularCouponElements = App\Models\Category::with('coupons')->where('status', 1)->latest()->limit(8)->get();
    $firstAd = App\Models\Ad::first();
?>

<!-- < popular -->
<section class="popular-section section-bg-before py-115 bg--img" style="background: url(<?php echo e(asset($activeTemplateTrue.'images/bg/popular-bg.png')); ?>)">
    <div class="container">
        <?php if($firstAd): ?>
        <!-- ad image start -->
        <div class="long-add-wrap">
           <div class="long-add-wrap--thumb">
                <a href="<?php echo e(@$firstAd->link); ?>" target="_blank">
                    <img src="<?php echo e(getImage(getFilePath('adImage') . '/' . @$firstAd->image)); ?>" alt="">
                </a>
           </div>
        </div>
        <?php else: ?>
         <!-- ad image end -->
         <?php endif; ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="section-content">
                    <div class="title-wrap">
                        <h2 class="section-title mb-2 wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">
                            <?php echo e(__($popularCoupon->data_values->heading)); ?>

                        </h2>
                        <a href="<?php echo e(route('categories')); ?>"><?php echo app('translator')->get('View More'); ?></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row gy-4 justify-content-center">
            <?php $__currentLoopData = $popularCouponElements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="coupon-card-2 wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">
                        <div class="icon-wrap">
                            <img src="<?php echo e(getImage(getFilePath('category') . '/' . $item->image)); ?>" alt="<?php echo app('translator')->get('popular-image'); ?>">
                        </div>
                        <a href="<?php echo e(route('category.coupons', $item->id)); ?>" class="title-cat">
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
    </div>
</section>
  <!--  popular /> -->

<?php /**PATH D:\adzspec\veckansr\application\resources\views/presets/default/sections/categories.blade.php ENDPATH**/ ?>