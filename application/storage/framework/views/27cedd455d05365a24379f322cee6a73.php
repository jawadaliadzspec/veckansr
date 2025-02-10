<?php
    $firstAd =App\Models\Ad::first();
?>
<!-- ==================== Breadcumb Start Here ==================== -->
<div class="breadcumb  section-bg-before-base py-115 bg--img" style="background: url(<?php echo e(asset($activeTemplateTrue.'images/bg/breadcrumb-bg.png')); ?>)">
    <div class="container">
        <?php if($firstAd): ?>
        <!-- ad image start -->
        <div class="breadcrumb-long-add-wrap">
           <div class="long-add-wrap--thumb">
                <a href="<?php echo e(@$firstAd->link); ?>" target="_blank">
                    <img src="<?php echo e(getImage(getFilePath('adImage') . '/' .@$firstAd->image)); ?>" alt="addImg">
                </a>
           </div>
        </div>
        <?php else: ?>
         <!-- ad image end -->
         <?php endif; ?>

        <div class="row">
            <div class="col-lg-12">
                <div class="breadcumb__wrapper">
                    <h2 class="breadcumb__title"> <?php echo e(__($pageTitle)); ?> </h2>
                    <ul class="breadcumb__list">
                        <li class="breadcumb__item"><a href="<?php echo e(route('home')); ?>" class="breadcumb__link"><i class="las la-home"></i> <?php echo app('translator')->get('Home'); ?></a> </li>
                        <li class="breadcumb__item">/</li>
                        <li class="breadcumb__item"> <span class="breadcumb__item-text">  <?php echo e(__($pageTitle)); ?> </span> </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ==================== Breadcumb End Here ==================== -->
<?php /**PATH D:\adzspec\veckansr\application\resources\views/presets/default/components/breadcrumb.blade.php ENDPATH**/ ?>