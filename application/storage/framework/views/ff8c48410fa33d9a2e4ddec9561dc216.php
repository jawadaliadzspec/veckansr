<!doctype html>
<html lang="<?php echo e(config('app.locale')); ?>" itemscope itemtype="http://schema.org/WebPage">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> <?php echo e($general->siteName(__($pageTitle))); ?></title>
    <?php echo $__env->make('includes.seo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- Bootstrap CSS -->
    <link href="<?php echo e(asset('assets/common/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/common/css/all.min.css')); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('assets/common/css/line-awesome.min.css')); ?>">

    <link rel="stylesheet" href="<?php echo e(asset($activeTemplateTrue.'css/animate.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset($activeTemplateTrue.'css/odometer.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset($activeTemplateTrue.'css/glightbox.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset($activeTemplateTrue.'css/slick.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset($activeTemplateTrue.'css/main.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset($activeTemplateTrue.'css/custom.css')); ?>">
    <?php echo $__env->yieldPushContent('style-lib'); ?>
    <?php echo $__env->yieldPushContent('style'); ?>

    <link rel="stylesheet" href="<?php echo e(asset($activeTemplateTrue.'css/color.php')); ?>?color=<?php echo e($general->base_color); ?>&secondColor=<?php echo e($general->secondary_color); ?>">
</head>
<body>
    <div class="sidebar-overlay"></div>

    <!--==================== Preloader Start ====================-->      
    <div id="loading">
        <div id="loading-center">
            <div id="loading-center-absolute">
                <span class="loader"></span>
            </div>
        </div>
    </div>
    <?php
     $referByHomePage = session()->get('reference');
    ?>

<?php if(@$referByHomePage ? @$referByHomePage == 2 : gs()->homepage == 2): ?>
    <?php if(@$referByHomePage ? @$referByHomePage == 2 : request()->route()->uri == '/'): ?>
         <?php echo $__env->make($activeTemplate.'components.home_two_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <?php else: ?> 
         <?php echo $__env->make($activeTemplate.'components.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
<?php else: ?>

<?php echo $__env->make($activeTemplate.'components.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>

<?php if(request()->route()->uri != '/'): ?>
    <?php echo $__env->make($activeTemplate.'components.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
 <?php endif; ?>


<?php echo $__env->yieldContent('content'); ?>

<?php echo $__env->make($activeTemplate.'components.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<?php echo $__env->make($activeTemplate.'components.cookie', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="<?php echo e(asset('assets/common/js/jquery-3.7.1.min.js')); ?>"></script>
  <script src="<?php echo e(asset('assets/common/js/bootstrap.bundle.min.js')); ?>"></script>

  <script src="<?php echo e(asset($activeTemplateTrue.'js/odometer.min.js')); ?>"></script>
  <script src="<?php echo e(asset($activeTemplateTrue.'js/jquery.appear.min.js')); ?>"></script>

  <script src="<?php echo e(asset($activeTemplateTrue.'js/bootstrap.min.js')); ?>"></script>

  <script src="<?php echo e(asset($activeTemplateTrue.'js/slick.min.js')); ?>"></script>
  <script src="<?php echo e(asset($activeTemplateTrue.'js/wow.min.js')); ?>"></script>
  <script src="<?php echo e(asset($activeTemplateTrue.'js/main.js')); ?>"></script>
 

<?php echo $__env->yieldPushContent('script-lib'); ?>

<?php echo $__env->yieldPushContent('script'); ?>

<?php echo $__env->make('includes.plugins', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->make('includes.notify', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<script>
    (function ($) {
        "use strict";
        $(".langSel").on("change", function() {
            window.location.href = "<?php echo e(route('home')); ?>/change/"+$(this).val() ;
        });

        var inputElements = $('input,select');
        $.each(inputElements, function (index, element) {
            element = $(element);
            element.closest('.form-group').find('label').attr('for',element.attr('name'));
            element.attr('id',element.attr('name'))
        });

        $('.policy').on('click',function(){
            $.get('<?php echo e(route('cookie.accept')); ?>', function(response){
                $('.cookies-card').addClass('d-none');
            });
        });

        setTimeout(function(){
            $('.cookies-card').removeClass('hide')
        },2000);

        var inputElements = $('[type=text],select,textarea');
        $.each(inputElements, function (index, element) {
            element = $(element);
            element.closest('.form-group').find('label').attr('for',element.attr('name'));
            element.attr('id',element.attr('name'))
        });

        $.each($('input, select, textarea'), function (i, element) {

            if (element.hasAttribute('required')) {
                $(element).closest('.form-group').find('label').addClass('required');
            }

        });

    })(jQuery);
</script>

</body>
</html>
<?php /**PATH D:\adzspec\veckansr\application\resources\views/presets/default/layouts/frontend.blade.php ENDPATH**/ ?>