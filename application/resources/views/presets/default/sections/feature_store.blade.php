@php
    $featureStore = getContent('feature_store.content', true);
    $featureStoreElements = App\Models\Store::active()->latest()->limit(8)->get();
@endphp

<!-- < exclusive -->
<section class="exclusive-section py-115">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-content">
                    <div class="title-wrap">
                        <h2 class="section-title mb-2 wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">
                            {{(__($featureStore->data_values->heading))}}
                        </h2>
                        <a href="{{route('feature.store')}}">@lang('View More')</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row gy-4 justify-content-center">
            @foreach( $featureStoreElements as $item) 

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
    </div>
</section>
<!--  exclusive /> -->
