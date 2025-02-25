<?php $__env->startSection('content'); ?>

<!-- ==================== Blog Start Here ==================== -->
<section class="blog pt-115">
    <div class="container">
        <div class="row gy-4 justify-content-center">
            <?php $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-lg-4 col-md-6">
                <div class="blog-item">
                    <div class="blog-item__thumb">
                        <a href="<?php echo e(route('blog.details', ['slug' => slug($item->data_values->title), 'id' => $item->id])); ?>" class="blog-item__thumb-link">
                            <img src="<?php echo e(getImage(getFilePath('blog').'/'.'thumb_'.$item->data_values->blog_image)); ?>" alt="">
                        </a>
                    </div>
                    <div class="blog-item__content">
                        <ul class="text-list inline">
                            <li class="text-list__item"> <span class="text-list__item-icon"><i class="fas fa-calendar-alt"></i></span><?php echo e(showDateTime($item->created_at)); ?></li>
                        </ul>
                        <h4 class="blog-item__title"><a href="<?php echo e(route('blog.details', ['slug' => slug($item->data_values->title), 'id' => $item->id])); ?>" class="blog-item__title-link">
                            <?php if(strlen(__($item->data_values->title)) >50): ?>
                            <?php echo e(substr( __($item->data_values->title), 0,50).'...'); ?>

                            <?php else: ?>
                            <?php echo e(__($item->data_values->title)); ?>

                            <?php endif; ?>
                        </a></h4>
                        <a href="<?php echo e(route('blog.details', ['slug' => slug($item->data_values->title), 'id' => $item->id])); ?>" class="btn btn--base"><?php echo app('translator')->get('Details'); ?><span class="btn--simple__icon"><i class="fas fa-arrow-right"></i></span></a>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <div class="col-sm-12">
                <nav>
                    <ul class="pagination mt-3">
                        <?php if($blogs->hasPages()): ?>
                        <div class="py-4">
                            <?php echo e(paginateLinks($blogs)); ?>

                        </div>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>

        </div>
    </div>
</section>
<!-- ==================== Blog End Here ==================== -->

<?php if($sections->secs != null): ?>
<?php $__currentLoopData = json_decode($sections->secs); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php echo $__env->make($activeTemplate.'sections.'.$sec, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate.'layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/veckansr/application/resources/views/presets/default/blog.blade.php ENDPATH**/ ?>