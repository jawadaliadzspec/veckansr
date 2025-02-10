<?php
    $blog = getContent('blog.content',true);
    $blogElements = getContent('blog.element',false,3);
    $firstAd = App\Models\Ad::first();
?>
<!-- ==================== Blog Start Here ==================== -->
<section class="blog section-bg-before bg--img py-115" style="background: url(<?php echo e(asset($activeTemplateTrue.'images/bg/testimonial-bg.png')); ?>)">
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

    <?php if(request()->route()->uri == '/'): ?>
    <div class="row">
      <div class="col-lg-12">
          <div class="section-content">
              <div class="title-wrap">
                  <h2 class="section-title mb-2 wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">
                      <?php echo e(__($blog->data_values->heading)); ?>

                  </h2>
                  <a href="<?php echo e(route('blog')); ?>"><?php echo app('translator')->get("View More"); ?></a>
              </div>
          </div>
      </div>
  </div>
    <?php endif; ?>
        <div class="row gy-4 justify-content-center">
            <?php $__currentLoopData = $blogElements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-lg-4 col-md-6">
                <div class="blog-item wow animate__animated animate__fadeInUp">
                    <div class="blog-item__thumb">
                        <a href="<?php echo e(route('blog.details', ['slug' => slug($item->data_values->title), 'id' => $item->id])); ?>" class="blog-item__thumb-link">
                            <img src="<?php echo e(getImage(getFilePath('blog').'/'.'thumb_'.$item->data_values->blog_image)); ?>" alt="image">
                        </a>
                    </div>
                    <div class="blog-item__content">
                        <ul class="text-list inline">
                            <li class="text-list__item"> <span class="text-list__item-icon"><i class="fas fa-calendar-alt"></i></span> <?php echo e(showDateTime($item->created_at)); ?></li>
                        </ul>
                        <h4 class="blog-item__title">
                            <a href="<?php echo e(route('blog.details', ['slug' => slug($item->data_values->title), 'id' => $item->id])); ?>" class="blog-item__title-link">
                                <?php if(strlen(__($item->data_values->title)) >50): ?>
                                <?php echo e(substr( __($item->data_values->title), 0,50).'...'); ?>

                                <?php else: ?>
                                <?php echo e(__($item->data_values->title)); ?>

                                <?php endif; ?>
                            </a>
                        </h4>
                        <a href="<?php echo e(route('blog.details', ['slug' => slug($item->data_values->title), 'id' => $item->id])); ?>" class="btn btn--base">
                            <?php echo app('translator')->get('Read More'); ?>
                            <span class="btn--simple__icon">
                            <i class="fas fa-arrow-right"></i>
                        </span>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<!-- ==================== Blog End Here ==================== -->
<?php /**PATH D:\adzspec\veckansr\application\resources\views/presets/default/sections/blog.blade.php ENDPATH**/ ?>