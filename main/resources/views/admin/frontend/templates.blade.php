@extends('admin.layouts.app')

@section('title')
    {{ $page_title }}
@endsection


@section('content')
    <div class="container-fluid">
        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="left-content">


                <h3 class="content-title mb-2">{{ $page_title }}</h3>
                <div class="d-flex">
                    <a href="/"><i class="mdi mdi-home text-muted hover-cursor"></i></a>
                    <p class="text-primary mb-0 hover-cursor">&nbsp;/&nbsp;{{ $page_title }}</p>
                </div>
            </div>
     
        </div>
        <!-- /breadcrumb -->

        <div class="row">
            @foreach ($templates as $temp)
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-header bg--primary">
                            <h4 class="card-title text-white"> {{ __(inputTitle($temp['name'])) }} </h4>
                        </div>
                        <div class="card-body">
                            <img src="{{ $temp['image'] }}" alt="@lang('Template')" class="w-100">
                        </div>
                        <div class="card-footer">
                            @if ($general->active_template == $temp['name'])
                                <button type="submit" name="name" value="{{ $temp['name'] }}"
                                    class="btn btn--primary btn-block">
                                    @lang('SELECTED')
                                </button>
                            @else
                                <form action="" method="post">
                                    @csrf
                                    <button type="submit" name="name" value="{{ $temp['name'] }}"
                                        class="btn btn--success btn-block">
                                        @lang('Select As Active')
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
            @if ($extra_templates)
                @foreach ($extra_templates as $temp)
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-header bg--primary">
                                <h4 class="card-title text-white"> {{ __(inputTitle($temp['name'])) }} </h4>
                            </div>
                            <div class="card-body">
                                <img src="{{ $temp['image'] }}" alt="@lang('Template')" class="w-100">
                            </div>
                            <div class="card-footer">
                                <a href="{{ $temp['url'] }}" target="_blank"
                                    class="btn btn--primary btn-block">@lang('Get This')</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

        </div>
    </div>

@endsection
