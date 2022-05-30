@php
$works = getContent('how_it_works.element', false, null, true);
$workCaption = getContent('how_it_works.content', true);
@endphp

@if ($works)
    <!-- How To Section -->
    <section class="how-to-section bg--title shapes-container feature-section pt-60 pb-120">
        <div class="banner-shape shape1">
            <img src="{{ asset($activeTemplateTrue . 'images/banner/shapes/1.png') }}" alt="@lang('banner/shapes')">
        </div>
        <div class="banner-shape shape2">
            <img src="{{ asset($activeTemplateTrue . 'images/banner/shapes/2.png') }}" alt="@lang('banner/shapes')">
        </div>
        <div class="banner-shape shape3">
            <img src="{{ asset($activeTemplateTrue . 'images/banner/shapes/3.png') }}" alt="@lang('banner/shapes')">
        </div>
        <div class="banner-shape shape4">
            <img src="{{ asset($activeTemplateTrue . 'images/banner/shapes/4.png') }}" alt="@lang('banner/shapes')">
        </div>
        <div class="banner-shape shape6">
            <img src="{{ asset($activeTemplateTrue . 'images/banner/shapes/6.png') }}" alt="@lang('banner/shapes')">
        </div>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-10">
                    <div class="section__header text-center text-white">
                        <span class="section__cate text-white">{{ __(@$workCaption->data_values->heading) }}</span>
                        <h3 class="section__title text-white">{{ __(@$workCaption->data_values->subheading) }}</h3>
                        <p>
                            {{ __(@$workCaption->data_values->description) }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="row g-3 g-sm-4">
                @foreach ($works as $k => $data)
                    <div class="col-lg-4 col-md-6">
                        <div class="feature__item">
                            <div class="feature__item-icon">
                                @php echo @$data->data_values->icon; @endphp
                            </div>
                            <div class="feature__item-cont">
                                <h6 class="feature__item-cont-title">{{ __(@$data->data_values->title) }}</h6>
                                <p>
                                    {{ __(@$data->data_values->description) }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>



        {{-- <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-10">
                    <div class="section__header text-center text-white">
                        <span class="section__cate text-white">{{ __(@$workCaption->data_values->heading) }}</span>
                        <h3 class="section__title text-white">{{ __(@$workCaption->data_values->subheading) }}</h3>
                        <p>
                            {{ __(@$workCaption->data_values->description) }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="how--wrapper">
                @foreach ($works as $k => $data)
                    <div class="how__item">
                        <div class="how__item-icon text--base">
                            @php echo @$data->data_values->icon; @endphp
                        </div>
                        <div class="how__item-content">
                            <h6 class="how__item-title">{{ __(@$data->data_values->title) }}</h6>
                        </div>
                        <div class="feature-body">
                            <p>{{ __(@$data->data_values->description) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div> --}}
    </section>
    <!-- How To Section -->
@endif
