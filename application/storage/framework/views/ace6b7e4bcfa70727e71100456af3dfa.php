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
                <?php if($item->expire_date): ?><p class="card-action"><?php echo isExpired($item->id); ?></p><?php endif; ?>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <p class="text-center h4"><?php echo e(__($emptyMessage)); ?></p>
    <?php endif; ?>
</div>


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
                        $('.storeImage').attr('src', storeImages);
                    }else{
                        console.error('store image could not found');
                    }

                },
                error: function(error) {
                    console.error('Error fetching product info:', error);
                }
            });
        }

    })(jQuery);
</script>
<?php /**PATH D:\adzspec\veckansr\application\resources\views/presets/default/couponFilter/coupon_search.blade.php ENDPATH**/ ?>