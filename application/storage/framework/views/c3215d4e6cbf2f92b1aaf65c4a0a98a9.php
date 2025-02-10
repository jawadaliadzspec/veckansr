
<?php
    $links = getContent('policy_pages.element');
    $socialIconElements = getContent('social_icon.element', false);
    $contactUs = getContent('contact_us.content', true);
    $importantLinks = getContent('footer_important_links.element', false, null, true);
    $companyLinks = getContent('footer_company_links.element', false, null, true);
?>
<!-- ==================== Footer Start Here ==================== -->
<footer class="footer-area pt-115">
    <div class="footer-top pb-60">
        <div class="container">
        
            <div class="row gy-4 justify-content-center">
                <div class="col-xl-4 col-sm-6">
                    <div class="footer-item">
                        <div class="footer-item__logo wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">
                            <a href="<?php echo e(route('home')); ?>" class="footer-logo-normal"> 
                                <img src="<?php echo e(getImage(getFilePath('logoIcon') . '/logo.png', '?' . time())); ?>"
                                alt="<?php echo e(config('app.name')); ?>">
                            </a>
                        </div>
                        <p class="footer-item__desc wow animate__animated animate__fadeInUp" data-wow-delay="0.3s"><?php echo e(__($contactUs->data_values->short_description)); ?></p>

                        <ul class="social-list wow animate__animated animate__fadeInUp" data-wow-delay="1s">
                            <?php $__currentLoopData = $socialIconElements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="social-list__item">
                                    <a href="<?php echo e($item->data_values->url); ?>" class="social-list__link" target="_blank">
                                   <?php echo $item->data_values->social_icon; ?>
                                    </a> 
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div> 
                <div class="col-xl-2 col-sm-6">
                    <div class="footer-item wow animate__animated animate__fadeInUp">
                        <h5 class="footer-item__title"><?php echo app('translator')->get('Useful Links'); ?></h5>
                        <ul class="footer-menu">
                            <?php $__currentLoopData = $importantLinks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="footer-menu__item">
                                <a href="<?php echo e(url('/').$link->data_values->url); ?>" target="_blank" class="footer-menu__link"><?php echo e($link->data_values->title); ?></a>
                            </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-sm-6">
                    <div class="footer-item wow animate__animated animate__fadeInUp">
                        <h5 class="footer-item__title"><?php echo app('translator')->get('Company Links'); ?></h5>
                        <ul class="footer-menu">
                            <?php $__currentLoopData = $companyLinks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="footer-menu__item"><a href="<?php echo e(url('/').$link->data_values->url); ?>" target="_blank" class="footer-menu__link"><?php echo e($link->data_values->title); ?></a></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="footer-menu__item"><a href="<?php echo e(route('policy.pages', [slug($link->data_values->title), $link->id])); ?>"  class="footer-menu__link" target="_blank"><?php echo e($link->data_values->title); ?></a></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <li class="footer-menu__item"><a href="<?php echo e(url('/cookie-policy')); ?>"  class="footer-menu__link" target="_blank"><?php echo app('translator')->get('Cookie Policy'); ?></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6">
                    <div class="footer-item wow animate__animated animate__fadeInUp">
                        <h5 class="footer-item__title"><?php echo app('translator')->get('Newsletter'); ?></h5>
                        <p class="footer-item__desc"><?php echo app('translator')->get('Stay up-to-date with the latest news, updates, and offers by subscribing to our newsletter.'); ?></p>
                        <div class="subscribe-box">
                          <form  action="<?php echo e(route('subscribe')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <input type="text" class="form--control footer-input footer-email" name="email" placeholder="<?php echo app('translator')->get('Enter your mail'); ?>...">
                            <button class="btn btn--base sub-btn" type="submit"><i class="fas fa-arrow-right"></i></button>
                          </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  <!-- Footer Top End-->
  
    <!-- bottom Footer -->
    <div class="bottom-footer section-bg py-4">
        <div class="container">
            <div class="row text-center gy-2">
                <div class="col-lg-12">
                    <div class="bottom-footer-text wow animate__animated animate__fadeInUp">
                        <?php echo $contactUs->data_values->website_footer;  ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
  <!-- ==================== Footer End Here ==================== -->

  <!-- ==================== Coupon-Code Notification ==================== -->
  <div class="coupon-code-notification"></div>

  <!-- ====================Scroll To Top ==================== -->
  <div class="scroll-top">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
      <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 93.9268;"></path>
    </svg>
    <i class="fas fa-arrow-up"></i>
  </div><?php /**PATH D:\adzspec\veckansr\application\resources\views/presets/default/components/footer.blade.php ENDPATH**/ ?>