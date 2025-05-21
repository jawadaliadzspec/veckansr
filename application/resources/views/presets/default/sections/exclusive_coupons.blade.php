@php
    $exclusiveCoupon = getContent('exclusive_coupons.content', true);
    $exlusivesCouponsData = App\Models\Coupon::with(['category', 'store', 'wishlists'])
        ->where('status', 1)
        ->where('is_exclusive', 1)
        ->latest()
        ->limit(8)
        ->get();
@endphp
<!-- < exclusive -->
<section class="exclusive-section py-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-content">
                    <div class="title-wrap">
                        <h2 class="section-title mb-2 wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">
                            {{ __($exclusiveCoupon->data_values->heading) }}
                        </h2>
                        <a href="{{ route('exclusive.coupons') }}">@lang('View More')</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row gy-4 justify-content-center">

            @foreach ($exlusivesCouponsData as $item)
                <div class="col-lg-3 col-md-6">
                    <div class="coupon-card wow animate__animated animate__fadeInUp" data-wow-delay="0.5s">
                        <div class="card-ribbon-wrap">
                            <button class="fav-cta addToWishList1" data-id="{{ $item->id }}">
                                @if (auth()->check() && $item->wishlists->count() > 0)
                                    <i class="fas fa-heart"></i>
                                @else
                                    <i class="far fa-heart"></i>
                                @endif
                            </button>
                            @php
                                $image = @$item->store->image;
                                $isUrl = filter_var($image, FILTER_VALIDATE_URL);
                                $image = $isUrl ? $image : getImage(getFilePath('store') . '/' . $image)
                            @endphp
                            <div class="ex-cta">
                                <img src="{{ $image }}" height="30px" alt="@lang('Store Image')">
                            </div>
                        </div>

                        <div class="card-thumb">
                            <img src="{{ $item->thumnail ?? $image }}" height="90px" alt="@lang('Store Image')">
                        </div>
                        <div class="card-content-wrap">
                            <p class="card-title">{{ __($item->title) }}</p>
                            @if($item->productPrice == $item->oldPrice)
                            <div class="ex-cta">
                                {{$item->productPrice}}
                            </div>
                            @endif
                            @if(!$item->is_deal)
                                <a href="javascript:void(0)" class="btn btn--base w-100 getCoupon1"
                                   data-id="{{ $item->id }}" data-title="{{ $item->title }}"
                                   data-code="{{ $item->code }}" data-description="{{ $item->description }}"
                                   data-link="{{ $item->link }}">
                                    @lang('Get Code')
                                </a>
                            @else
                                @if($item->productPrice == $item->oldPrice)
                                    <a target="_blank" class="btn btn--base w-100" href="{{ $item->link }}">
                                        @lang('Buy')
                                    </a>
                                @else
                                    <a class="btn btn--base w-100" href="{{ route('couponDetails', $item->path) }}">
                                        @lang('Show Details')
                                    </a>
                                @endif
{{--                                <a class="btn btn--base w-100 getCoupon1" href="{{ url($item->path) }}">Show Details</a>--}}
                            @endif
                            @if($item->expire_date)
                                <p class="card-action">{!! isExpired($item->id) !!}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Modal -->
            <div class="modal fade" id="couponModal1" tabindex="-1" aria-hidden="true">
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
                            <p class="storeTitle">@lang('Copy and paste this code at') <a href="" class="text--base storeName"
                                    target="_blank"></a></p>
                            <div class="copy-code-input">
                                <input class="form--control coponCodeCopy" name="code"
                                    readonly>
                                <a href="" class="btn btn--base copy-btn copytext" id="copyBoard-exclusive" target="_blank"><i
                                    class="fas fa-copy"></i>
                                </a>
                            </div>
                            <div class="qr-thumb">
                                <p class="description"></p>
                            </div>
                            <div class="footer-item social-wrapper">
                                <p class="mb-3">@lang('Share this coupon now.')</p>
                                <ul class="social-list">
                                    <li class="social-list__item">
                                        <a href="#" class="social-list__link share-link" target="_blank"
                                            data-social="facebook">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                    </li>
                                    <li class="social-list__item">
                                        <a href="#" class="social-list__link share-link" target="_blank"
                                            data-social="twitter">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                    </li>
                                    <li class="social-list__item">
                                        <a href="#" class="social-list__link share-link" target="_blank"
                                            data-social="linkedin">
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
        </div>
    </div>
</section>
<!--  exclusive /> -->

 @push('script')
    <script>
         "use strict";
        (function($) {
            "use strict";
            $('.getCoupon1').on('click', function() {
                var modal = $('#couponModal1');

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

            $('#copyBoard-exclusive').on('click', function(event) {
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
                    url: '{{ route('get.modal.info') }}',
                    type: 'get',
                    data: {
                        couponId: couponId,
                    },
                    success: function(response) {
                        var storeImages = response.storeImage;
                        var storeName = response.storeName;
                        $('.storeName').text(storeName);
                        if (storeImages) {
                            $('.storeImage').attr('src', storeImages);
                        } else {
                            console.error('store image could not found');
                        }
                    },
                    error: function(error) {
                        console.error('Error fetching product info:', error);
                    }
                });

            }
            // add to wishlist
            $(document).on('click', '.addToWishList1', function() {
                'use strict';
                var isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
                if (isLoggedIn) {
                    var couponId = $(this).data('id');
                    var button = $(this);
                    $.ajax({
                        url: '{{ route('user.wishlist.add') }}',
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

        })(jQuery);
    </script>
@endpush

