@extends($activeTemplate . 'user.layouts.app')

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
            <a href="{{ route('user.profile-setting') }}" class="btn btn--success mb-4">
                <i class="fa fa-user"></i>
                @lang('Profile Setting')
            </a>

            <div class="d-flex align-items-end flex-wrap my-auto right-content breadcrumb-right">
                <button class="btn btn-primary mt-2 mt-xl-0">Current Rank<br>
                    <span class="badge badge-light">NIL</span>
                    {{-- <span class="badge badge-light">{{ auth()->user()->rank }}</span> --}}
                </button>
            </div>
        </div>
        <div class="row mb-none-30">
            <div class="col-xl-3 col-lg-5 col-md-5">
                <div class="card b-radius--10 overflow-hidden">
                    <div class="card-body p-0">
                        <div class="p-3">
                            <img id="output"
                                src="{{ getImage('assets/images/user/profile/' . auth()->user()->image, '350x300') }}"
                                alt="@lang('profile-image')" class="b-radius--10 w-100">
                            <ul class="list-group mt-3">
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>@lang('Name')</span> {{ auth()->user()->fullname }}
                                </li>
                                <li class="list-group-item rounded-0 d-flex justify-content-between">
                                    <span>@lang('Username')</span> {{ auth()->user()->username }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-9 mb-30">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-50 border-bottom pb-2">@lang('Change Password')</h5>
                        <form action="" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">@lang('Current Password')</label>
                                <div class="col-lg-9">
                                    <input class="form-control form-control-lg" type="password" name="current_password"
                                        required minlength="5">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">@lang('New password')</label>
                                <div class="col-lg-9">
                                    <input class="form-control form-control-lg" type="password" name="password" required
                                        minlength="5">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">@lang('Confirm password')</label>
                                <div class="col-lg-9">
                                    <input class="form-control form-control-lg" type="password" required minlength="5"
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
