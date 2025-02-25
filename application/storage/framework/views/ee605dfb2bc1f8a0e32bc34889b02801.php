<?php $__env->startSection('content'); ?>
<?php
       $secondAd = App\Models\Ad::skip(1)->first();
?>
<!-- ==================== Blog  Blog Details Start Here ==================== -->
<section class="blog-detials pt-115">
    <div class="container">
        <div class="row gy-5 justify-content-center">
            <div class="col-lg-8">
                <div class="blog-details">

                    <div class="blog-item">
                        <div class="blog-item__thumb">
                            <img src="<?php echo e(getImage(getFilePath('blog').'/'. $blog->data_values->blog_image)); ?>" alt="blog-img">
                        </div>

                        <div class="blog-item__content pt-2">
                            <ul class="text-list inline">
                                <li class="text-list__item"> <span class="text-list__item-icon"><i class="fas fa-calendar-alt"></i></span><?php echo e(showDateTime($blog->created_at)); ?></li>
                            </ul>
                        </div>
                    </div>
                   <div class="blog-details__content">
                        <div class="wyg">
                            <h3 class="blog-details__title mb-4"><?php echo e(__($blog->data_values->title)); ?></h3>
                            <p class="blog-details__desc">
                                <?php
                                echo $blog->data_values->description;
                                ?>
                            </p>
                            <div class="blog-details__share d-flex align-items-center flex-wrap">
                                <h5 class="social-share__title mb-0 me-sm-3 me-1 d-inline-block"><?php echo app('translator')->get('Share This'); ?></h5>
                                <ul class="social-list blog-details-social-wrapper">
                                    <li class="social-list__item" data-bs-toggle="tooltip" data-bs-placement="top" title="Facebook"> <a class="social-list__link" target="_blank" href="https://www.facebook.com/share.php?u=<?php echo e(Request::url()); ?>&title=<?php echo e(slug(@$element->data_values->title)); ?>"><i class="lab la-facebook-f"></i></a> </li>
                                    <li class="social-list__item" data-bs-toggle="tooltip" data-bs-placement="top" title="Linkedin"> <a class="social-list__link" target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo e(Request::url()); ?>&title=<?php echo e(slug(@$element->data_values->title)); ?>&source=behands"><i class="lab la-linkedin-in"></i></a> </li>
                                    <li class="social-list__item" data-bs-toggle="tooltip" data-bs-placement="top" title="Twitter"> <a class="social-list__link" target="_blank" href="https://twitter.com/intent/tweet?status=<?php echo e(slug(@$element->data_values->title)); ?>+<?php echo e(Request::url()); ?>"><i class="lab la-twitter"></i></a> </li>
                                </ul>
                            </div>
                        </div>
                   </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- ============================= Blog Details Sidebar Start ======================== -->
                <div class="blog-sidebar-wrapper">
                    <?php if($secondAd): ?>
                    <div class="blog-sidebar text-center">
                        <!-- ad image start -->
                        <div class="sidebar-add-wrap position-relative">
                        
                            <div class="long-add-wrap--thumb">
                                <a href="<?php echo e(@$secondAd->link); ?>" target="_blank">
                                    <img src="<?php echo e(getImage(getFilePath('adImage') . '/' . @$secondAd->image)); ?>" alt="">
                                </a>
                            </div>
                        </div>
                         <!-- ad image end -->
                    </div>
                    <?php else: ?>
                    <?php endif; ?>

                    <div class="blog-sidebar">
                        <h5 class="blog-sidebar__title"><?php echo app('translator')->get('Latests'); ?></h5>
                        <?php $__currentLoopData = $latests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="latest-blog">
                            <div class="latest-blog__thumb">
                                <a href="<?php echo e(route('blog.details', ['slug' => slug($item->data_values->title), 'id' => $item->id])); ?>"> <img src="<?php echo e(getImage(getFilePath('blog').'/'. $item->data_values->blog_image)); ?>" alt="latest blog"></a>
                            </div>
                            <div class="latest-blog__content">
                                <h6 class="latest-blog__title">
                                    <a href="<?php echo e(route('blog.details', ['slug' => slug($item->data_values->title), 'id' => $item->id])); ?>">
                                        <?php if(strlen(__($item->data_values->title)) >50): ?>
                                        <?php echo e(substr( __($item->data_values->title), 0,50).'...'); ?>

                                        <?php else: ?>
                                        <?php echo e(__($item->data_values->title)); ?>

                                        <?php endif; ?>
                                    </a>
                                </h6>
                                <span class="latest-blog__date"><?php echo e(showDateTime($item->created_at)); ?></span>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <!-- ============================= Blog Details Sidebar End ======================== -->
            </div>
        </div>
    </div>
</section>
<!-- ==================== Blog Details End Here ==================== -->
<?php $__env->stopSection(); ?>

<?php $__env->startPush('style'); ?>
    <style>
        .wyg h1,
        .wyg h2,
        .wyg h3,
        .wyg h4 {
            color: hsl(var(--black));
        }
        .wyg p {
            color: hsl(var(--black));
        }
        .wyg ul {
            margin: 35px;
        }
        .wyg ul li {
            list-style-type: disc;
            color: hsl(var(--black));
            font-family: var(--body-font);
        }
        .wyg ul ol {
            list-style-type: auto;
            color: hsl(var(--black));
            font-family: var(--body-font);
        }
    </style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make($activeTemplate.'layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/veckansr/application/resources/views/presets/default/blog_details.blade.php ENDPATH**/ ?>