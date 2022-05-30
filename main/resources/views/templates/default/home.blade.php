@extends($activeTemplate . 'layouts.master')

@section('content')

    @php
    $banner = getContent('banner.content', true);
    @endphp

    <!-- Banner -->
    <section class="banner-section bg--title shapes-container">

        <div class="banner-shape shape1">
            <img src="{{ asset($activeTemplateTrue . 'images/banner/shapes/1.png') }}" alt="@lang('banner-shapes')">
        </div>
        <div class="banner-shape shape2">
            <img src="{{ asset($activeTemplateTrue . 'images/banner/shapes/2.png') }}" alt="@lang('banner-shapes')">
        </div>
        <div class="banner-shape shape3">
            <img src="{{ asset($activeTemplateTrue . 'images/banner/shapes/3.png') }}" alt="@lang('banner-shapes')">
        </div>
        <div class="banner-shape shape4">
            <img src="{{ asset($activeTemplateTrue . 'images/banner/shapes/4.png') }}" alt="@lang('banner-shapes')">
        </div>
        <div class="banner-shape shape5">
            <img src="{{ asset($activeTemplateTrue . 'images/banner/shapes/5.png') }}" alt="@lang('banner-shapes')">
        </div>
        <div class="banner-shape shape6">
            <img src="{{ asset($activeTemplateTrue . 'images/banner/shapes/6.png') }}" alt="@lang('banner-shapes')">
        </div>
        <div class="banner-shape shape7">
            <img src="{{ asset($activeTemplateTrue . 'images/banner/shapes/7.png') }}" alt="@lang('banner-shapes')">
        </div>
        <div class="banner-shape shape8">
            <img src="{{ asset($activeTemplateTrue . 'images/banner/shapes/8.png') }}" alt="@lang('banner-shapes')">
        </div>
        <div class="banner-shape shape9">
            <img src="{{ asset($activeTemplateTrue . 'images/banner/shapes/9.png') }}" alt="@lang('banner-shapes')">
        </div>
        <div class="banner-shape shape10">
            <img src="{{ asset($activeTemplateTrue . 'images/banner/shapes/10.png') }}" alt="@lang('banner-shapes')">
        </div>
        <div class="container">
            <div class="banner__wrapper">
                <div class="banner__wrapper-content">
                    <h2 class="banner__wrapper-content-title">{{ __(@$banner->data_values->heading) }}</h2>
                    <p class="banner__wrapper-content-txt">
                        {{ __(@$banner->data_values->subheading) }}
                    </p>
                    <div class="btn__grp white-btns">
                        <a href="{{ __(@$banner->data_values->left_button_link) }}"
                            class="cmn--btn">{{ __(@$banner->data_values->left_button) }}</a>
                        <a href="{{ __(@$banner->data_values->right_button_link) }}"
                            class="cmn--btn">{{ __(@$banner->data_values->right_button) }}</a>
                    </div>
                </div>
                <div class="banner__wrapper-thumb">
                    <img src="{{ getImage('assets/images/frontend/banner/' . @$banner->data_values->background_image, '770x610') }}"
                        alt="@lang('banner')">
                </div>
            </div>
        </div>
    </section>
    <!-- Banner -->

    @if ($sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif

@endsection
