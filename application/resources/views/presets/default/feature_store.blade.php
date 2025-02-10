@extends($activeTemplate.'layouts.frontend')
@section('content')
<!-- exclusive item section -->
<!-- < exclusive -->
<section class="exclusive-section py-115">
    <div class="container">
        <div class="row gy-4 justify-content-center">
            <div class="col-lg-12">
                <div class="row gy-4">
                    @foreach( $featureStore as $item) 
                    <div class="col-lg-3 col-md-6">
                        <div class="coupon-card-3 wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">
                            <div class="card-thumb">
                                <img src="{{ getImage(getFilePath('store') . '/' . $item->image) }} " alt="@lang('feature-store-image')">
                            </div>
                            <span></span>
                            <a href="{{route('store.coupons', $item->id)}}" class="title">
                                {{__($item->name)}}
                            </a>
                        </div>
                    </div>

                @endforeach
                </div>
                <div class="row py-4">
                    
                    @if ($featureStore->hasPages())
                        <div class="py-4">
                            {{ paginateLinks($featureStore) }}
                        </div>
                    @endif
                </div>
            </div>
        
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
            
            <div class="modal-body">
                <div class="logo-thumb">
                    <img class="storeImage" src="/" alt="modal-image">
                </div>
                <p class="title"></p>
                <p class="storeTitle">@lang('Copy and paste this code at') <a href="" class="text--base storeName" target="_blank"></a></p>
                <div class="copy-code-input">
                    <input class="form--control coponCodeCopy" name="code" readonly>
                    <button class="btn btn--base copy-btn copytext" id="copyBoard"><i class="fas fa-copy"></i></button>
                </div>
                <div class="qr-thumb">
                   <p class="description"></p>
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
    modal.find('a[href]').attr('href', $(this).data('link'));
    var couponId = $(this).data('id');
    getCouponInfo(couponId)
   
    modal.modal('show');
});

$('#copyBoard').on('click', function () {
    var copyText = document.getElementsByClassName("coponCodeCopy");
    copyText = copyText[0];
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    /*For mobile devices*/
    document.execCommand("copy");
    copyText.blur();
    this.classList.add('copied');
    setTimeout(() => this.classList.remove('copied'), 1500);
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
$(document).on('click', '.addToWishListFeature', function() {
    'use strict'
    var couponId = $(this).data('id');
    $.ajax({
        url: '{{ route("user.wishlist.add") }}',
        type: 'get',
        data: {
            couponId:couponId,
        },
        success: function(response) {
            if (response.hasOwnProperty('message')) {
            Toast.fire({
                icon: 'success',
                title: response.message
            });
           
            }else{
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
});

// end wishlist


})(jQuery);
</script>
@endpush