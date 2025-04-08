@extends($activeTemplate.'layouts.frontend')
@section('content')
@php
    $banner = getContent('banner.content', true);
    $bannerTwo = getContent('banner_two.content', true);
    $bannerThree = getContent('banner_three.content', true);
    $bannerElements = getContent('banner.element', false);
    $referByHomePage = session()->get('reference');
@endphp
 @if(@$referByHomePage ? @$referByHomePage == 1 : gs()->homepage == 1)
<!-- < Hero Section -->
<section class="hero three section-bg-before">
    <div class="banner-right-shape"></div>
    <div class="banner-right-top"></div>
    <div class="banner-right-bottom animate-rotate">
        <div class="dot-wrap">
            <div class="slider-dot one"></div>
            <div class="slider-dot two"></div>
            <div class="slider-dot three"></div>
            <div class="slider-dot four"></div>
        </div>
    </div>
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-6 d-flex align-items-center">
                <div class="hero-left-content2">
                     <div class="hero-content">
                        <p class="subtitle animate__animated animate__fadeInUp"><span>{{__($bannerThree->data_values->deal_count)}} {{__($bannerThree->data_values->subheading )}}</span></p>
                        <h2 class="banner-title animate__animated animate__fadeInUp">{{__($bannerThree->data_values->heading )}}</h2>
                        <p class="short-descriptions">
                            @if(strlen(__($bannerThree->data_values->short_description)) > 118)
                                {{substr( __($bannerThree->data_values->short_description), 0,118).'...' }}
                            @else
                                {{__($bannerThree->data_values->short_description)}}
                            @endif
                        </p>
                    </div>
                    <div class="grp-btn">
                        <a class="btn btn--base" href="{{route('coupon')}}">@lang('Discover more')</a>
                        <a class="ms-3 btn btn--base outline" href="{{route('contact')}}">@lang('Contact Us')</a>
                    </div>
                </div>
            </div>

        <div class="col-lg-6">
            <div class="hero-right-side three">
                 <div class="banner-shape-bg animate-zoom-in-out"></div>
                <div class="hero-right-thumb2">
                    <img style="max-width: 60%" src="{{ getImage(getFilePath('bannerThree') . '/' . $bannerThree->data_values->banner_image) }} " alt="@lang('banner-image')">
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<!--  Hero Section -->
@elseif(@$referByHomePage ? @$referByHomePage == 2 : gs()->homepage == 2)

    <!-- < Hero Section two-->
<section class="hero-2 py-180-2 bg--img" style="background: url({{asset($activeTemplateTrue.'images/bg/hero-bg-2.png')}})">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 pt-160">
                <div class="hero-content-2 text-center">
                    <p class="subtitle animate__animated animate__fadeInUp">{{__($bannerTwo->data_values->deal_count )}} {{__($bannerTwo->data_values->subheading )}}</p>
                    <h2 class="title animate__animated animate__fadeInUp">{{__($bannerTwo->data_values->heading)}}</h2>
                </div>
                <div class="hero-search-bar-2 animate__animated animate__fadeInUp">
                    <form action="{{route('single.coupon.search')}}" method="get">
                        <input class="form--control" name="search" type="text" placeholder="@lang('Search') ...">
                        <button class="search-btn btn btn--base" type="submit"> <i class="las la-search icon"></i> <span>{{__($banner->data_values->button )}}</button>
                    </form>
                </div>
                <div class="categories">
                    <p class="title animate__animated animate__fadeInUp">@lang('Or browse featured categories:')</p>
                    <div class="item-wrap animate__animated animate__fadeInUp">
                        @foreach($categories as $item)
                        <div class="item">
                            <img class="categories-hero-two-img" src="{{ getImage(getFilePath('category') . '/' . $item->image) }}" alt="@lang('category-image')">
                            <p class="item-name">{{__($item->name)}}</p>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--  Hero Section two/>-->
@else

<!--  Hero Section three -->
<section class="hero bg--img section-bg-before" style="background: url({{asset($activeTemplateTrue.'images/banner-shape.png')}})">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-5 d-flex align-items-center">
                <div class="hero-left-content">
                     <div class="hero-content">
                        <p class="animate__animated animate__fadeInUp"><span>{{__($banner->data_values->deal_count )}} {{__($banner->data_values->subheading )}}</span></p>
                         <h2 class="banner-title animate__animated animate__fadeInUp"><span>{{__($banner->data_values->heading)}}</span></h2>
                    </div>
                    <div class="hero-search-bar animate__animated animate__fadeInUp">
                        <form action="{{route('single.coupon.search')}}" method="get">
                            <input class="form--control" name="search" type="text" placeholder="@lang('Search') ...">
                            <button class="search-btn btn btn--base" type="submit"> <i class="fas fa-search"></i> <span>{{__($banner->data_values->button )}}</button>
                        </form>
                    </div>
                    <div class="hero-grp-counter wow animate__animated animate__fadeInUp">
                        @foreach($bannerElements as $item)
                            <div class="counter-wrap">
                                <h6 class="odometer" data-count="{{__($item->data_values->digit_count )}}">@lang('00')</h6>
                                <p>{{__($item->data_values->title )}}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="hero-right-side">
                    <div class="hero-right-thumb">
                        <img src="{{ getImage(getFilePath('banner') . '/' . $banner->data_values->banner_image) }}" alt="@lang('banner-image')">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--  Hero Section three -->

@endif

@if($sections->secs != null)
@foreach(json_decode($sections->secs) as $sec)
@include($activeTemplate.'sections.'.$sec)
@endforeach
@endif
@endsection
