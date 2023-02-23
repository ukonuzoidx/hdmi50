@php
    $works = getContent('product.element', false, null, true);
    $workCaption = getContent('product.content', true);
@endphp

@if ($works)
    <!-- our product -->
    <section class="pricing-section pt-120 pb-60">
        <div class="container">
            <div class="row justify-content-center">
                <div class="section__header text-center text-white">
                    <span class="section__cate">{{ __(@$workCaption->data_values->heading) }}</span>
                    <h3 class="section__title">{{ __(@$workCaption->data_values->subheading) }}</h3>
                    <p>
                        {{ __(@$workCaption->data_values->description) }}
                    </p>
                </div>
            </div>
            <div class="price-wrapper">

                @foreach ($works as $k => $data)
                    <div class="pricing-item">
                        <div class="pricing-deco">
                            <div class="wave">&nbsp;</div>
                            <div class="about__thumb">
                                <div class="thumb">
                                    <img src="{{ getImage('assets/images/frontend/product/' . @$data->data_values->image, '770x610') }}"
                                        alt="@lang('product')">
                                    {{-- <a href="" class="video-button" data-lightbox>
                                        <p>
                                            {{ @$data->data_values->title }}
                                        </p> --}}
                                    {{-- </a> --}}
                                </div>
                            </div>
                        </div>


                    </div>
                @endforeach

            </div>
        </div>
    </section>
    <!-- our product -->
@endif
