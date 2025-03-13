@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="container my-5">
        <div class="card shadow-lg border-0 rounded-4 mx-auto">
            <!-- Image and Logo Section -->
            <div class="position-relative">
                <img src="{{$coupon->thumnail}}" class="card-img-top" alt="Offer Image">
{{--                <img src="https://www.studentkortet.se/wp-content/uploads/2024/12/hedvig-1280x400-partner-page-web.jpg" class="card-img-top" alt="Offer Image">--}}
                <div class="position-absolute start-50 translate-middle bg-white px-2 rounded-3 shadow-sm fw-bold">
{{--                    <img src="" class="card-img-top" alt="Offer Image">--}}
{{--                    Hedvig®--}}
{{--                    {{$coupon->store->name}}--}}
                    <img src="{{ getImage(getFilePath('store') . '/' . @$coupon->store->image) }}" width="90px" height="90px"
                         alt="@lang('Store Image')">
                </div>
            </div>

            <!-- Offer Body -->
            <div class="card-body text-center py-60">
                <h3 class="card-title fw-bold">{{$coupon->title}}</h3>
                <p class="card-text">{{$coupon->description}}</p>
                <!-- Offer Button -->
                <a href="{{$coupon->link}}" target="_blank" class="btn btn--base">To the Offer</a>

                <!-- Terms -->
{{--                <p class="mt-3 text-muted small">Terms</p>--}}
            </div>
        </div>
    </div>
@endsection
