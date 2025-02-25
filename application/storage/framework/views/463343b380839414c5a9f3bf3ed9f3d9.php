<?php
  $faq = getContent('faq.content',true);
  $faqElement = getContent('faq.element',false);
?>
<!-- ==================== Accordion Start Here ==================== -->
<section class="accordion-area section-bg py-115 bg--img">
    <div class="container">
        <div class="row">
          <div class="col-lg-12">
              <div class="section-content">
                  <div class="title-wrap">
                      <h2 class="section-title mb-2 wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">
                          <?php echo e(__($faq->data_values->heading)); ?>

                      </h2>
                  </div>
              </div>
          </div>
      </div>
        <div class="row gy-4 align-items-center justify-content-center">
            <div class="col-lg-6">
                <div class="accordion custom--accordion  wow animate__animated animate__fadeInUp" id="accordionExample">
                    <?php $__currentLoopData = $faqElement; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="heading<?php echo e($loop->index); ?>">
                        <button class="accordion-button <?php echo e($loop->index == 0 ? '' : 'collapsed'); ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo e($loop->index); ?>" aria-expanded="<?php echo e($loop->index == 0 ? 'true': 'false'); ?>">
                            <?php echo e(__(@$item->data_values->question)); ?>

                        </button>
                      </h2>
                      <div id="collapse<?php echo e($loop->index); ?>" class="accordion-collapse collapse <?php echo e($loop->index == 0 ? 'show': ''); ?>" aria-labelledby="heading<?php echo e($loop->index); ?>" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <?php echo e(strLimit(strip_tags(@$item->data_values->answer),350)); ?>

                        </div>
                      </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="faq-image-wrapper wow animate__animated animate__fadeInUp">
                   <div class="thumb">
                        <img src="<?php echo e(getImage(getFilePath('faq') . '/' . $faq->data_values->faq_image)); ?>" alt="<?php echo app('translator')->get('faq-image'); ?>">
                   </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==================== Accordion End Here ==================== -->
<?php /**PATH /var/www/html/veckansr/application/resources/views/presets/default/sections/faq.blade.php ENDPATH**/ ?>