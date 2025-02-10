
<?php $__env->startSection('content'); ?>
<?php
    $banner = getContent('banner.content', true);
    $bannerTwo = getContent('banner_two.content', true);
    $bannerThree = getContent('banner_three.content', true);
    $bannerElements = getContent('banner.element', false);
    $referByHomePage = session()->get('reference');
?>
 <?php if(@$referByHomePage ? @$referByHomePage == 1 : gs()->homepage == 1): ?>
<!-- < Hero Section -->
<section class="hero three section-bg-before">
    <div class="banner-right-shape"></div>
    <div class="banner-right-top"></div>
    <div class="banner-right-bottom animate-rotate">
        <div class="dot-wrap">
            <div class="slider-dot one"></div>
            <div class="slider-dot two"></div>
            <div class="slider-dot three"></div>
            <div class="slider-dot four"></div>
        </div>
    </div>
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-6 d-flex align-items-center">
                <div class="hero-left-content2">
                     <div class="hero-content">
                        <p class="subtitle animate__animated animate__fadeInUp"><span><?php echo e(__($bannerThree->data_values->deal_count)); ?> <?php echo e(__($bannerThree->data_values->subheading )); ?></span></p>
                        <h2 class="banner-title animate__animated animate__fadeInUp"><?php echo e(__($bannerThree->data_values->heading )); ?></h2>
                        <p class="short-descriptions">
                            <?php if(strlen(__($bannerThree->data_values->short_description)) > 118): ?>
                                <?php echo e(substr( __($bannerThree->data_values->short_description), 0,118).'...'); ?>

                            <?php else: ?>
                                <?php echo e(__($bannerThree->data_values->short_description)); ?>

                            <?php endif; ?>
                        </p>
                    </div>
                    <div class="grp-btn">
                        <a class="btn btn--base" href="<?php echo e(route('coupon')); ?>"><?php echo app('translator')->get('Discover more'); ?></a>
                        <a class="ms-3 btn btn--base outline" href="<?php echo e(route('contact')); ?>"><?php echo app('translator')->get('Contact Us'); ?></a>
                    </div>
                </div>
            </div>

        <div class="col-lg-6">
            <div class="hero-right-side three">
                 <div class="banner-shape-bg animate-zoom-in-out"></div>
                <div class="hero-right-thumb2">
                    <img src="<?php echo e(getImage(getFilePath('bannerThree') . '/' . $bannerThree->data_values->banner_image)); ?> " alt="<?php echo app('translator')->get('banner-image'); ?>">
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<!--  Hero Section -->
<?php elseif(@$referByHomePage ? @$referByHomePage == 2 : gs()->homepage == 2): ?>

    <!-- < Hero Section two-->
<section class="hero-2 py-180-2 bg--img" style="background: url(<?php echo e(asset($activeTemplateTrue.'images/bg/hero-bg-2.png')); ?>)">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 pt-160">
                <div class="hero-content-2 text-center">
                    <p class="subtitle animate__animated animate__fadeInUp"><?php echo e(__($bannerTwo->data_values->deal_count )); ?> <?php echo e(__($bannerTwo->data_values->subheading )); ?></p>
                    <h2 class="title animate__animated animate__fadeInUp"><?php echo e(__($bannerTwo->data_values->heading)); ?></h2>
                </div>
                <div class="hero-search-bar-2 animate__animated animate__fadeInUp">
                    <form action="<?php echo e(route('single.coupon.search')); ?>" method="get">
                        <input class="form--control" name="search" type="text" placeholder="<?php echo app('translator')->get('Search'); ?> ...">
                        <button class="search-btn btn btn--base" type="submit"> <i class="las la-search icon"></i> <span><?php echo e(__($banner->data_values->button )); ?></button>
                    </form>
                </div>
                <div class="categories">
                    <p class="title animate__animated animate__fadeInUp"><?php echo app('translator')->get('Or browse featured categories:'); ?></p>
                    <div class="item-wrap animate__animated animate__fadeInUp">
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="item">
                            <img class="categories-hero-two-img" src="<?php echo e(getImage(getFilePath('category') . '/' . $item->image)); ?>" alt="<?php echo app('translator')->get('category-image'); ?>">
                            <p class="item-name"><?php echo e(__($item->name)); ?></p>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--  Hero Section two/>-->
<?php else: ?>

<!--  Hero Section three -->
<section class="hero bg--img section-bg-before" style="background: url(<?php echo e(asset($activeTemplateTrue.'images/banner-shape.png')); ?>)">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-5 d-flex align-items-center">
                <div class="hero-left-content">
                     <div class="hero-content">
                        <p class="animate__animated animate__fadeInUp"><span><?php echo e(__($banner->data_values->deal_count )); ?> <?php echo e(__($banner->data_values->subheading )); ?></span></p>
                        <h2 class="banner-title animate__animated animate__fadeInUp"><span><?php echo e(__($banner->data_values->heading)); ?></h1>
                    </div>
                    <div class="hero-search-bar animate__animated animate__fadeInUp">
                        <form action="<?php echo e(route('single.coupon.search')); ?>" method="get">
                            <input class="form--control" name="search" type="text" placeholder="<?php echo app('translator')->get('Search'); ?> ...">
                            <button class="search-btn btn btn--base" type="submit"> <i class="fas fa-search"></i> <span><?php echo e(__($banner->data_values->button )); ?></button>
                        </form>
                    </div>
                    <div class="hero-grp-counter wow animate__animated animate__fadeInUp">
                        <?php $__currentLoopData = $bannerElements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="counter-wrap">
                                <h6 class="odometer" data-count="<?php echo e(__($item->data_values->digit_count )); ?>"><?php echo app('translator')->get('00'); ?></h6>
                                <p><?php echo e(__($item->data_values->title )); ?></p>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="hero-right-side">
                    <div class="hero-right-thumb">
                        <img src="<?php echo e(getImage(getFilePath('banner') . '/' . $banner->data_values->banner_image)); ?>" alt="<?php echo app('translator')->get('banner-image'); ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--  Hero Section three -->

<?php endif; ?>

<?php if($sections->secs != null): ?>
<?php $__currentLoopData = json_decode($sections->secs); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php echo $__env->make($activeTemplate.'sections.'.$sec, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate.'layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\adzspec\veckansr\application\resources\views/presets/default/home.blade.php ENDPATH**/ ?>