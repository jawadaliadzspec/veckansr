
<?php $__env->startSection('content'); ?>
<?php
    $secondAd = App\Models\Ad::skip(1)->first();
?>
<!-- exclusive item section -->
<!-- < exclusive -->
<section class="exclusive-section pt-115">
    <div class="container">
        <div class="row gy-4 justify-content-center">
            <div class="col-lg-3">
                <div class="side-bar-wrap">
                    <div class="section-search-box mb-4">
                        <form>
                            <input class="form--control" id="searchValue" name="search" type="text" placeholder="<?php echo app('translator')->get('Search'); ?>">
                            <button><i class="fa-solid fa-magnifying-glass"></i></button>
                        </form>
                    </div>
                    <div class="category-box">
                        <div class="side-bar-wrap">
                            <div class="category-box">
                                <div class="categories">
                                    <h6 class="title"><?php echo app('translator')->get('Categories'); ?></h6>
                                    <div class="category-list">
                                        <?php
                                            $categoryCount = count($categories);
                                        ?>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="check-item">
                                                <div class="form--check categories-search mb-2">
                                                    <input class="form-check-input filter-by-category" name="categories_<?php echo e($loop->iteration); ?>" type="checkbox" value="<?php echo e($item->id); ?>" id="categories_<?php echo e($loop->iteration); ?>">
                                                    <label for="categories_<?php echo e($loop->iteration); ?>" class="form-check-label"><?php echo e($item->name); ?></label>
                                                </div>
                                            </div>
                                            <?php if($loop->iteration == 6 && $categoryCount > 6): ?>
                                                <button class="show-more-button btn btn--base btn--sm mt-2"><?php echo app('translator')->get('Show More'); ?></button>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>

                                </div>
                                <div class="categories">
                                    <h6 class="title"><?php echo app('translator')->get('Stores'); ?></h6>
                                    <div class="category-list">
                                        <?php
                                            $storeCount = count($stores);
                                        ?>
                                        <?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="check-item-stores">
                                            <div class="form--check categories-search mb-2">
                                                <input class="form-check-input filter-by-stores" id="stores_<?php echo e($loop->iteration); ?>" name="stores_<?php echo e($loop->iteration); ?>"
                                                    type="checkbox" value="<?php echo e($item->id); ?>">
                                                <label for="stores_<?php echo e($loop->iteration); ?>" class="form-check-label"><?php echo e($item->name); ?></label>
                                            </div>
                                        </div>
                                        <?php if($loop->iteration == 6 && $storeCount > 6): ?>
                                            <button class="show-more-button-stores btn btn--base btn--sm mt-2"><?php echo app('translator')->get('Show More'); ?></button>
                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                                <?php if($secondAd): ?>
                                <div class="categories">
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
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-9  main-content">
                <div class="row gy-4">
                    <?php $__empty_1 = true; $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="coupon-card wow animate__animated animate__fadeInUp" data-wow-delay="0.5s">
                            <div class="card-ribbon-wrap">
                                <button class="fav-cta addToWishList" data-id="<?php echo e($item->id); ?>">
                                    <?php if(auth()->check() && $item->wishlists->count() > 0): ?>
                                        <i class="fas fa-heart"></i>
                                    <?php else: ?>
                                        <i class="far fa-heart"></i>
                                    <?php endif; ?>
                                </button>
                                <div class="ex-cta">
                                    <i class="fas fa-gem"></i>
                                    <?php if($item->is_featured == 1): ?>
                                    <p><?php echo app('translator')->get('Featured'); ?></p>
                                    <?php elseif($item->is_exclusive == 1): ?>
                                    <p><?php echo app('translator')->get('Exclusive'); ?></p>
                                    <?php else: ?>
                                    <p><?php echo app('translator')->get('New'); ?></p>
                                    <?php endif; ?>

                                </div>
                            </div>
                            <div class="card-thumb">
                                <img src="<?php echo e(getImage(getFilePath('store') . '/' . @$item->store->image)); ?>" alt="<?php echo app('translator')->get('Store Image'); ?>">
                            </div>
                            <div class="card-content-wrap">
                                <p class="card-title"><?php echo e(__($item->title)); ?></p>

                                <?php if(!$item->is_deal): ?>
                                    <a href="javascript:void(0)" class="btn btn--base w-100 getCoupon1"
                                       data-id="<?php echo e($item->id); ?>" data-title="<?php echo e($item->title); ?>"
                                       data-code="<?php echo e($item->code); ?>" data-description="<?php echo e($item->description); ?>"
                                       data-link="<?php echo e($item->link); ?>">
                                        <?php echo app('translator')->get('Get Code'); ?>
                                    </a>
                                <?php else: ?>
                                    <a class="btn btn--base w-100" href="<?php echo e(url('deal/' . $item->path)); ?>">
                                        Show Details
                                    </a>
                                <?php endif; ?>
                                <?php if($item->expire_date): ?><p class="card-action"><?php echo isExpired($item->id); ?></p><?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-center"><?php echo e(__($emptyMessage)); ?></p>
                    <?php endif; ?>
                </div>
            </div>

        </div>
        <div class="row py-4">
            <?php if($coupons->hasPages()): ?>
                <div class="py-4">
                    <?php echo e(paginateLinks($coupons)); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
  <!--  exclusive /> -->

    <!-- Modal -->
    <div class="modal fade" id="couponModal" tabindex="-1"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="btn-wrap">
                    <button data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
                </div>

                <div class="modal-body justify-content-center align-items-center">
                    <div class="logo-thumb">
                        <img class="storeImage" src="/" alt="modal-image">
                    </div>
                    <p class="title"></p>
                    <p class="storeTitle"><?php echo app('translator')->get('Copy and paste this code at'); ?> <a href="" class="text--base storeName" target="_blank"></a></p>
                    <div class="copy-code-input">
                        <input class="form--control coponCodeCopy" name="code" readonly>
                        <a href="" class="btn btn--base copy-btn copytext" id="copyBoard" target="_blank"><i class="fas fa-copy"></i></a>
                    </div>
                    <div class="qr-thumb">
                       <p class="description"></p>
                    </div>
                    <div class="footer-item social-wrapper">
                         <p class="mb-3"><?php echo app('translator')->get('Share this coupon now.'); ?></p>
                         <ul class="social-list">
                             <li class="social-list__item">
                                 <a href="#" class="social-list__link share-link" target="_blank" data-social="facebook">
                                     <i class="fab fa-facebook-f"></i>
                                 </a>
                             </li>
                             <li class="social-list__item">
                                 <a href="#" class="social-list__link share-link" target="_blank" data-social="twitter">
                                     <i class="fab fa-twitter"></i>
                                 </a>
                             </li>
                             <li class="social-list__item">
                                 <a href="#" class="social-list__link share-link" target="_blank" data-social="linkedin">
                                     <i class="fab fa-linkedin-in"></i>
                                 </a>
                             </li>
                         </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Modal /> -->

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
<script>
    (function ($) {
        "use strict";
        $('.getCoupon').on('click', function () {
            var modal = $('#couponModal');

            modal.find('.title').text($(this).data('title'));
            modal.find('.description').text($(this).data('description'));
            modal.find('input[name=code]').val($(this).data('code'));
            modal.find('.storeName').attr('href', $(this).data('link'));
            modal.find('.copytext').attr('href', $(this).data('link'));
            var couponId = $(this).data('id');
            getCouponInfo(couponId)

            var shareLink = $(this).data('link');
            // Update the href attribute of the share links
            $('.share-link[data-social="facebook"]').attr('href',
                'https://www.facebook.com/sharer/sharer.php?u=' + shareLink);
            $('.share-link[data-social="twitter"]').attr('href',
                'https://twitter.com/intent/tweet?url=' + shareLink);
            $('.share-link[data-social="linkedin"]').attr('href',
                'https://www.linkedin.com/shareArticle?url=' + shareLink);

            modal.modal('show');
        });

        $('#copyBoard').on('click', function () {
            event.preventDefault();

            var copyText = document.getElementsByClassName("coponCodeCopy");
            if (copyText.length > 0) {
                copyText = copyText[0];
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                document.execCommand("copy");
                copyText.blur();

                // Notify "Copied Code" with fade in/out animation
                var notification = $('.coupon-code-notification');
                notification.text('Copied Code').fadeIn().delay(1000).fadeOut(100);

                // Add 'copied' class for styling purposes
                $(this).addClass('copied');

                // Delay before redirecting
                var href = $(this).attr('href');
                setTimeout(function() {
                    window.open(href, '_blank'); // Open link in a new tab
                }, 2000);
            }
        });

        // get modal into product info
        function getCouponInfo(couponId) {
            $.ajax({
                url: '<?php echo e(route("get.modal.info")); ?>',
                type: 'get',
                data: {
                    couponId: couponId,
                },
                success: function(response) {
                    var storeImages = response.storeImage;
                    var storeName = response.storeName;
                    $('.storeName').text(storeName);
                    if(storeImages){
                        var baseUrl = '<?php echo e(url('/')); ?>';
                        var imageUrl = baseUrl + '/' + storeImages;
                        $('.storeImage').attr('src', imageUrl);
                    }else{
                        console.error('store image could not found');
                    }

                },
                error: function(error) {
                    console.error('Error fetching product info:', error);
                }
            });
        }
        // add to wishlist
        $(document).on('click', '.addToWishList', function() {
                'use strict';
                var isLoggedIn = <?php echo e(Auth::check() ? 'true' : 'false'); ?>;
                if (isLoggedIn) {
                    var couponId = $(this).data('id');
                    var button = $(this);
                    $.ajax({
                        url: '<?php echo e(route('user.wishlist.add')); ?>',
                        type: 'get',
                        data: {
                            couponId: couponId,
                        },
                        success: function(response) {
                            if (response.hasOwnProperty('message')) {
                                Toast.fire({
                                    icon: 'success',
                                    title: response.message
                                });
                                var heartIcon = button.find('i');
                                heartIcon.removeClass('far fa-heart').addClass('fas fa-heart');
                            } else {
                                Toast.fire({
                                    icon: 'warning',
                                    title: response.error
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            var errorMessage = 'Error occurred while adding the Coupon to wishlist.';
                            Toast.fire({
                                icon: 'error',
                                title: errorMessage
                            });
                        }
                    });
                } else {
                    var errorMessage = 'Please log in to add items to your wishlist.';
                    Toast.fire({
                        icon: 'warning',
                        title: errorMessage
                    });
                }
            });
            // end wishlist
         // Filter coupon
         $("#searchValue").on('keyup', function () {
            var categories   = [];
            var searchValue = [];
            var stores   = [];

            var searchValue = $(this).val();
            getFilteredData(stores, categories,searchValue)
        });

         $("input[type='checkbox'][name^='categories_']").on('click', function(){
                var categories   = [];
                var stores   = [];
                var searchValue = [];
                $('.filter-by-category:checked').each(function() {
                    if(!categories.includes(parseInt($(this).val()))){
                        categories.push(parseInt($(this).val()));
                    }
                });
                getFilteredData(stores, categories,searchValue)
        });

        $("input[type='checkbox'][name^='stores_']").on('click', function(){
            var categories   = [];
            var stores   = [];
            var searchValue = [];

                $('.filter-by-stores:checked').each(function() {
                    if(!stores.includes(parseInt($(this).val()))){
                        stores.push(parseInt($(this).val()));
                    }
                });
                getFilteredData(stores, categories,searchValue)
        });


        function getFilteredData(stores, categories,searchValue){

            $.ajax({
                type: "get",
                url: "<?php echo e(route('coupon.filtered')); ?>",
                data:{

                    "categories": categories,
                    "stores": stores,
                    "search": searchValue
                },
                dataType: "json",
                success: function (response) {
                    if(response.html){
                        $('.main-content').html(response.html);
                    }

                    if(response.error){
                        notify('error', response.error);
                    }
                }
            });
        }
        // end filter product

    })(jQuery);
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate.'layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\adzspec\veckansr\application\resources\views/presets/default/coupons.blade.php ENDPATH**/ ?>