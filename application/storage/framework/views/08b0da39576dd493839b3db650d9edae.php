<?php 
    $dealCoupon = getContent('deal_coupon.content', true);
?>

<!-- < Deal coupon -->
<section class="deal-section py-115 bg--img section-bg-base" style="background: url(<?php echo e(asset($activeTemplateTrue.'images/bg/deal-bg.png')); ?>);">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="deal-content">
              <h2 class="title wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">
                <?php echo e(__($dealCoupon->data_values->heading)); ?>

              </h2>
              <p class="sub-title text-center wow animate__animated animate__fadeInUp" data-wow-delay="0.3s">
                <?php echo e(__($dealCoupon->data_values->subheading)); ?>

              </p>
              <a href="<?php echo e(route('coupon')); ?>" class="btn btn--base bg--white text-black deal-btn wow animate__animated animate__fadeInUp" data-wow-delay="0.4s">
                <?php echo e(__($dealCoupon->data_values->button)); ?>

              </a>
            </div>
        </div>
      </div>
    </div>
</section>
<!--  Deal coupon /> --><?php /**PATH D:\adzspec\veckansr\application\resources\views/presets/default/sections/deal_coupon.blade.php ENDPATH**/ ?>