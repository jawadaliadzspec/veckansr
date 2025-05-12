@php
    $popularCoupon = getContent('categories.content', true);
    $popularCouponElements = App\Models\Category::query()->where('status', 1)->latest()->limit(8)->get();
    $firstAd = App\Models\Ad::first();
@endphp

<!-- < popular -->
<section class="popular-section section-bg-before py-115 bg--img" style="background: url({{asset($activeTemplateTrue.'images/bg/popular-bg.png')}})">
    <div class="container">
        @if($firstAd)
        <!-- ad image start -->
        <div class="long-add-wrap">
           <div class="long-add-wrap--thumb">
                <a href="{{@$firstAd->link}}" target="_blank">
                    <img src="{{ getImage(getFilePath('adImage') . '/' . @$firstAd->image) }}" alt="">
                </a>
           </div>
        </div>
        @else
         <!-- ad image end -->
         @endif
        <div class="row">
            <div class="col-lg-12">
                <div class="section-content">
                    <div class="title-wrap">
                        <h2 class="section-title mb-2 wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">
                            {{__($popularCoupon->data_values->heading)}}
                        </h2>
                        <a href="{{route('categories')}}">@lang('View More')</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row gy-4 justify-content-center">
            @foreach($popularCouponElements as $item)
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="coupon-card-2 wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">
                        <div class="icon-wrap">
                            <img src="{{ getImage(getFilePath('category') . '/' . $item->image) }}" alt="@lang('popular-image')">
                        </div>
                        <a href="{{route('category.coupons', $item->id)}}" class="title-cat">
                            @if (strlen(__($item->name)) > 20)
                            {{ substr(__($item->name), 0, 20) . '...' }}
                            @else
                                {{ __($item->name) }}
                            @endif
                        </a>
{{--                        <span class="text--base">{{$item->coupons->count()}} @lang('coupons')</span>--}}
                    </div>

                </div>
            @endforeach
        </div>
    </div>
</section>
  <!--  popular /> -->

