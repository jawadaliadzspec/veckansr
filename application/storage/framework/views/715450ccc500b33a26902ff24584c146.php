<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title> <?php echo e($general->siteName(__('404'))); ?></title>
        <link rel="shortcut icon" href="<?php echo e(getImage(getFilePath('logoIcon') .'/favicon.png')); ?>" type="image/x-icon">

        <link href="<?php echo e(asset('assets/common/css/bootstrap.min.css')); ?>" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo e(asset($activeTemplateTrue.'css/main.css')); ?>">

        <style>
            .erro-body{
                height: 100vh;
            }
        </style>
    </head>

    <body>
        <section class="account section-bg-before bg--img" style="background: url(<?php echo e(asset($activeTemplateTrue.'images/bg/popular-bg.png')); ?>)">
            <div class="account-inner">
                <div class="container">
                    <div class="row gy-4 justify-content-center align-items-center erro-body">
                        <div class="col-lg-6">
                            <div class="error-wrap text-center">
                                <div class="error__text">
                                    <span><?php echo app('translator')->get('4'); ?></span>
                                    <span><?php echo app('translator')->get('0'); ?></span>
                                    <span><?php echo app('translator')->get('4'); ?></span>
                                </div>
                                <h2 class="error-wrap__title mb-3"><?php echo app('translator')->get('Page Not Found'); ?></h2>
                                <p class="error-wrap__desc"><?php echo app('translator')->get('Sorry, the page you are looking for could not be found Coupon Website.'); ?></p>
                                <a href="<?php echo e(route('home')); ?>" class="btn btn--base">
                                    <i class="la la-undo"></i> <?php echo app('translator')->get('Go Home'); ?>
                                    <span></span>
                                  </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </body>

<script src="<?php echo e(asset('assets/common/js/jquery-3.6.0.min.js')); ?>"></script>
<script src="<?php echo e(asset($activeTemplateTrue.'js/main.js')); ?>"></script>
</html>
<?php /**PATH /var/www/html/veckansr/application/resources/views/errors/404.blade.php ENDPATH**/ ?>