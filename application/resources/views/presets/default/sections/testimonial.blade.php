@php
    $testimonial = getContent('testimonial.content', true);
    $testimonialElements = getContent('testimonial.element', false);
    $firstAd = App\Models\Ad::first();
@endphp

<!-- testimonial section -->
<section class="exclusive-section section-bg-before bg--img py-115" style="background: url({{asset($activeTemplateTrue.'images/bg/testimonial-bg.png')}})">
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
                        {{__( $testimonial->data_values->heading)}}
                    </h2>
                  
                </div>
            </div>
        </div>
    </div>
    <div class="row testimonial-slider">
        @foreach( $testimonialElements as $item)
            <div class="col-lg-4">
                <div class="testimonial-card">
                    <img class="testimonials-shape" src="{{asset($activeTemplateTrue.'images/testimonials-shape.png')}}" alt="">
                    <div class="user-thumb">
                        <img src="{{ getImage(getFilePath('testimonial') . '/' . $item->data_values->testimonial_img) }} " alt="@lang('testimonial-image')">
                    </div>
                    <p>
                        @if (strlen(__($item->data_values->description)) > 140)
                        {{ substr(__($item->data_values->description), 0, 140) . '...' }}
                        @else
                            {{ __($item->data_values->description) }}
                        @endif
                    </p>
                    <div class="user-meta">
                        <h6> {{ __($item->data_values->name) }}</h6>
                        <p> {{ __($item->data_values->title) }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    </div>
  </section>
  <!--  exclusive /> -->
  