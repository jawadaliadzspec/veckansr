@extends($activeTemplate.'layouts.frontend')
@section('content')

<!-- exclusive item section -->
<!-- < popular -->
<section class="popular-section section-bg-before py-115 bg--img" style="background: url({{asset($activeTemplateTrue.'images/bg/popular-bg.png')}})">
    <div class="container">
        <div class="row gy-4 justify-content-center">
            @foreach($categories as $item)
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="coupon-card-2 wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">

                        <div class="icon-wrap">
                            <img src="{{ getImage(getFilePath('category') . '/' . $item->image) }}" alt="@lang('popular-image')">
                        </div>
                        <a href="{{route("category.coupons", $item->id)}}" class="title-cat">
                            @if (strlen(__($item->name)) > 20)
                            {{ substr(__($item->name), 0, 20) . '...' }}
                            @else
                                {{ __($item->name) }}
                            @endif
                        </a>
                        <span class="text--base">{{$item->coupons->count()}} @lang('coupons')</span>

                    </div>
                </div>
            @endforeach
        </div>
        <div class="row py-4">
            @if ($categories->hasPages())
                <div class="py-4">
                    {{ paginateLinks($categories) }}
                </div>
            @endif
        </div>
    
    </div>
</section>
@endsection
