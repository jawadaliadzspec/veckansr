<?php
    $testimonial = getContent('testimonial.content', true);
    $testimonialElements = getContent('testimonial.element', false);
    $firstAd = App\Models\Ad::first();
?>

<!-- testimonial section -->
<section class="exclusive-section section-bg-before bg--img py-115" style="background: url(<?php echo e(asset($activeTemplateTrue.'images/bg/testimonial-bg.png')); ?>)">
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
                        <?php echo e(__( $testimonial->data_values->heading)); ?>

                    </h2>
                  
                </div>
            </div>
        </div>
    </div>
    <div class="row testimonial-slider">
        <?php $__currentLoopData = $testimonialElements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-lg-4">
                <div class="testimonial-card">
                    <img class="testimonials-shape" src="<?php echo e(asset($activeTemplateTrue.'images/testimonials-shape.png')); ?>" alt="">
                    <div class="user-thumb">
                        <img src="<?php echo e(getImage(getFilePath('testimonial') . '/' . $item->data_values->testimonial_img)); ?> " alt="<?php echo app('translator')->get('testimonial-image'); ?>">
                    </div>
                    <p>
                        <?php if(strlen(__($item->data_values->description)) > 140): ?>
                        <?php echo e(substr(__($item->data_values->description), 0, 140) . '...'); ?>

                        <?php else: ?>
                            <?php echo e(__($item->data_values->description)); ?>

                        <?php endif; ?>
                    </p>
                    <div class="user-meta">
                        <h6> <?php echo e(__($item->data_values->name)); ?></h6>
                        <p> <?php echo e(__($item->data_values->title)); ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    </div>
  </section>
  <!--  exclusive /> -->
  <?php /**PATH /var/www/html/veckansr/application/resources/views/presets/default/sections/testimonial.blade.php ENDPATH**/ ?>