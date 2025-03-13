@php 
    $dealCoupon = getContent('deal_coupon.content', true);
@endphp

<!-- < Deal coupon -->
<section class="deal-section py-115 bg--img section-bg-base" style="background: url({{asset($activeTemplateTrue.'images/bg/deal-bg.png')}});">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="deal-content">
              <h2 class="title wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">
                {{__($dealCoupon->data_values->heading)}}
              </h2>
              <p class="sub-title text-center wow animate__animated animate__fadeInUp" data-wow-delay="0.3s">
                {{__($dealCoupon->data_values->subheading)}}
              </p>
              <a href="{{route('coupon')}}" class="btn btn--base bg--white text-black deal-btn wow animate__animated animate__fadeInUp" data-wow-delay="0.4s">
                {{__($dealCoupon->data_values->button)}}
              </a>
            </div>
        </div>
      </div>
    </div>
</section>
<!--  Deal coupon /> -->