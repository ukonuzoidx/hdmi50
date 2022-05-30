@extends('admin.layouts.app')

@section('title')
    {{ $page_title }}
@endsection

@push('css')
    {{-- <link rel="stylesheet" href="{{ asset('assets/admin/css/apps.css') }}" /> --}}
@endpush



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
            <a href="{{ route('admin.profile') }}" class="btn btn-sm btn--primary mb-4 text--small"><i
                    class="fa fa-user"></i>@lang('Profile Setting')</a>


        </div>
        <!-- /breadcrumb -->
        <div class="row mb-none-30">
            <div class="col-lg-3 col-md-3 mb-30">

                <div class="card b-radius--5 overflow-hidden">
                    <div class="card-body p-0">
                        <div class="d-flex p-3 bg--primary">
                            <div class="avatar avatar--lg">
                                <img src="{{ getImage(imagePath()['profile']['admin']['path'] . '/' . $admin->image, imagePath()['profile']['admin']['size']) }}"
                                    alt="@lang('Image')">
                            </div>
                            <div class="pl-3">
                                <h4 class="text--white">{{ __($admin->name) }}</h4>
                            </div>
                        </div>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Name')
                                <span class="font-weight-bold">{{ __($admin->name) }}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Username')
                                <span class="font-weight-bold">{{ __($admin->username) }}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Email')
                                <span class="font-weight-bold">{{ $admin->email }}</span>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-9 col-md-9 mb-30">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-50 border-bottom pb-2">@lang('Change Password')</h5>

                        <form action="{{ route('admin.password.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">@lang('Password')</label>
                                <div class="col-lg-9">

                                    <input class="form-control" type="password" placeholder="@lang('Password')"
                                        name="old_password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">@lang('New Password')</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="password" placeholder="@lang('New Password')"
                                        name="password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">@lang('Confirm Password')</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="password" placeholder="@lang('Confirm Password')"
                                        name="password_confirmation">
                                </div>
                            </div>


                            <div class="form-group row">

                                <label class="col-lg-3 col-form-label form-control-label"></label>
                                <div class="col-lg-9">
                                    <button type="submit"
                                        class="btn btn--primary btn-block btn-lg">@lang('Save Changes')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
