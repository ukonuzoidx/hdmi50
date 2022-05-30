@extends('admin.layouts.app')

@section('title')
    {{ $page_title }}
@endsection


@section('content')
    <!-- container -->
    <div class="container-fluid">

        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="left-content">
                <h3 class="content-title mb-2">Welcome back, Admin</h3>
                <div class="d-flex">
                    <a href="/"><i class="mdi mdi-home text-muted hover-cursor"></i></a>
                    <p class="text-primary mb-0 hover-cursor">&nbsp;/&nbsp;{{ $page_title }}</p>
                </div>
            </div>
            <form
                action="{{ route('admin.users.search',$scope ??str_replace('admin.users.','',request()->route()->getName())) }}"
                method="GET" class="form-inline float-sm-right">
                <div class="input-group has_append">
                    <input type="text" name="search" class="form-control" placeholder="@lang('Username or email')"
                        value="{{ $search ?? '' }}">
                    <div class="input-group-append">
                        <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /breadcrumb -->

        <div class="row mb-none-30">
            <div class="col-xl-12">
                <div class="card">
                    <form action="{{ route('admin.users.email.all') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="font-weight-bold">@lang('Subject') <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="@lang('Email subject')" name="subject"
                                        required />
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="font-weight-bold">@lang('Message') <span
                                            class="text-danger">*</span></label>
                                    <textarea name="message" rows="10" class="form-control nicEdit" placeholder="@lang('Your message')"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="form-row">
                                <div class="form-group col-md-12 text-center">
                                    <button type="submit" class="btn btn-block btn--primary mr-2">@lang('Send Email')</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
