@extends($activeTemplate.'layouts.frontend')
@section('content')
@php
     $secondAd = App\Models\Ad::skip(1)->first();
@endphp
<!-- exclusive item section -->
<!-- < exclusive -->
<section class="exclusive-section py-115">
    <div class="container">
        <div class="row gy-4 justify-content-center">
            <div class="col-lg-3">
                <div class="side-bar-wrap">
                    <div class="section-search-box mb-4">
                        <form>
                            <input class="form--control" id="searchValue" name="search" type="text" placeholder="@lang('Search')">
                            <button><i class="fa-solid fa-magnifying-glass"></i></button>
                        </form>
                    </div>
                    <div class="category-box">
                        <div class="side-bar-wrap">
                            <div class="category-box">
                                <div class="categories">
                                    <h6 class="title">@lang('Categories')</h6>
                                    <div class="category-list">
                                        @foreach ($categories as $item)
                                        <div class="check-item">
                                            <div class="form--check categories-search mb-2">
                                                <input class="form-check-input filter-by-category" name="categories_{{$loop->iteration}}" type="checkbox" value="{{ $item->id }}" id="categories_{{$loop->iteration}}">
                                                <label for="categories_{{$loop->iteration}}" class="form-check-label">{{ $item->name }}</label>
                                            </div>
                                        </div>
                                        @endforeach
                                        <button class="show-more-button btn btn--base btn--sm mt-2">@lang('Show More')</button>
                                    </div>
                                </div>
                                <div class="categories">
                                    <h6 class="title">@lang('Stores')</h6>
                                    <div class="category-list">
                                        @foreach ($stores as $item)
                                        <div class="check-item-stores">
                                            <div class="form--check categories-search mb-2">
                                                <input class="form-check-input filter-by-stores" id="stores_{{$loop->iteration}}" name="stores_{{$loop->iteration}}"
                                                    type="checkbox" value="{{ $item->id }}">
                                                <label for="stores_{{$loop->iteration}}" class="form-check-label">{{ $item->name }}</label>
                                            </div>
                                        </div>
                                        @endforeach
                                        <button class="show-more-button-stores btn btn--base btn--sm mt-2">@lang('Show More')</button>
                                    </div>
                                </div>
                                @if($secondAd)
                                <div class="categories">
                                    <!-- ad image start -->
                                    <div class="sidebar-add-wrap position-relative">
                                       <div class="long-add-wrap--thumb">
                                            <a href="{{@$secondAd->link}}" target="_blank">
                                                <img src="{{ getImage(getFilePath('adImage') . '/' . @$secondAd->image) }}" alt="">
                                            </a>
                                       </div>
                                    </div>
                                     <!-- ad image end -->
                                </div>
                                @else
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-9 main-content">
                <div class="row gy-4">
                    @forelse($featureCoupons as $item)
                    <div class="col-lg-4 col-md-6">
                        <div class="coupon-card wow animate__animated animate__fadeInUp" data-wow-delay="0.5s">
                            <div class="card-ribbon-wrap">
                                <button class="fav-cta addToWishList" data-id="{{ $item->id }}">
                                    @if (auth()->check() && $item->wishlists->count() > 0)
                                        <i class="fas fa-heart"></i>
                                    @else
                                        <i class="far fa-heart"></i>
                                    @endif
                                </button>
                                <div class="ex-cta">
                                    <i class="fas fa-gem"></i>
                                    <p>@lang('Featured')</p>
                                </div>
                            </div>
                            <div class="card-thumb">
                                <img src="{{ getImage(getFilePath('store') . '/' . @$item->store->image) }}" height="90px" width="90px" alt="@lang('Store Image')">
                            </div>
                            <div class="card-content-wrap">
                                <p class="card-title">{{__($item->title)}}</p>
{{--                                <a href="javascript:void(0)" class="btn btn--base w-100 getCoupon" data-id="{{$item->id}}" data-title="{{$item->title}}" data-code="{{$item->code}}" data-description="{{$item->description}}" data-link="{{$item->link}}">@lang('Get Code')</a>--}}
                                @if(!$item->is_deal)
                                    <a href="javascript:void(0)" class="btn btn--base w-100 getCoupon1"
                                       data-id="{{ $item->id }}" data-title="{{ $item->title }}"
                                       data-code="{{ $item->code }}" data-description="{{ $item->description }}"
                                       data-link="{{ $item->link }}">
                                        @lang('Get Code')
                                    </a>
                                @else
                                    <a class="btn btn--base w-100" href="{{ route('couponDetails', $item->path) }}">
                                        Show Details
                                    </a>
                                @endif
                                @if($item->expire_date)<p class="card-action"> {!! isExpired($item->id) !!}</p>@endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-center">{{__($emptyMessage)}}</p>
                    @endforelse
                </div>
                <div class="row py-4">
                    <div class="col-lg-12 justify-content-center d-flex">

                        @if ($featureCoupons->hasPages())
                        <div class="py-4">
                            {{ paginateLinks($featureCoupons) }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>
  <!--  exclusive /> -->


    <!-- Modal -->
    <div class="modal fade" id="couponModal" tabindex="-1" aria-hidden="true">
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
                    <p class="storeTitle">@lang('Copy and paste this code at') <a href="" class="text--base storeName" target="_blank"></a></p>
                    <div class="copy-code-input">
                        <input class="form--control coponCodeCopy" name="code" readonly>
                        <a href="" class="btn btn--base copy-btn copytext" id="copyBoard" target="_blank"><i class="fas fa-copy"></i></a>
                    </div>
                    <div class="qr-thumb">
                       <p class="description"></p>
                    </div>
                    <div class="footer-item social-wrapper">
                         <p class="mb-3">@lang('Share this coupon now.')</p>
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

@endsection

@push('script')
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
                url: '{{ route("get.modal.info") }}',
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
        // add to wishlist
        $(document).on('click', '.addToWishList', function() {
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
                url: "{{route('feature.coupon.filtered') }}",
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
@endpush
