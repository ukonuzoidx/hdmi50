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
            <a href="{{ route('user.change-password') }}" class="btn btn--success mb-4">
                <i class="fa fa-key"></i>
                @lang('Change Password')
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
                                {{-- <li class="list-group-item rounded-0 d-flex justify-content-between">
                                    <span>@lang('Sponsor ID')</span> {{ auth()->user()->sponsor_id }}
                                </li>
                                <li class="list-group-item rounded-0 d-flex justify-content-between">
                                    <span>@lang('Placer ID')</span> {{ auth()->user()->placer_id }}
                                </li> --}}
                                <li class="list-group-item rounded-0 d-flex justify-content-between">
                                    <span>@lang('User ID')</span> {{ auth()->user()->user_id }}
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>@lang('Joined at')</span>
                                    {{ date('d M, Y h:i A', strtotime(auth()->user()->created_at)) }}
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-9 col-lg-7 col-md-7 mb-30">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-50 border-bottom pb-2">{{ auth()->user()->fullname }} @lang('Information')
                        </h5>

                        <form action="" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label class="form-control-label font-weight-bold">@lang('First Name') <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control form-control-lg" type="text" name="firstname"
                                            value="{{ auth()->user()->firstname }}" required readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label  font-weight-bold">@lang('Last Name') <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control form-control-lg" type="text" name="lastname"
                                            value="{{ auth()->user()->lastname }}" required readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label class="form-control-label font-weight-bold">@lang('Email')<span
                                                class="text-danger">*</span></label>
                                        <input class="form-control form-control-lg" type="email"
                                            value="{{ auth()->user()->email }}" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label  font-weight-bold">@lang('Mobile Number')<span
                                                class="text-danger">*</span></label>
                                        <input class="form-control form-control-lg" type="text" name="phone"
                                            value="{{ auth()->user()->phone }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-control-label  font-weight-bold">@lang('Avatar')</label>
                                        <input class="form-control" type="file" accept="image/*"
                                            onchange="loadFile(event)" name="image">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="form-group ">
                                        <label class="form-control-label font-weight-bold">@lang('Address') </label>
                                        <input class="form-control form-control-lg" type="text" name="address"
                                            value="{{ auth()->user()->address->address }}">
                                        <small class="form-text text-muted"><i
                                                class="las la-info-circle"></i>@lang('House number, street address')
                                        </small>
                                    </div>
                                </div>

                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group ">
                                        <label class="form-control-label font-weight-bold">@lang('State')</label>
                                        <input class="form-control form-control-lg" type="text" name="state"
                                            value="{{ auth()->user()->address->state }}">
                                    </div>
                                </div>

                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group ">
                                        <label class="form-control-label font-weight-bold">@lang('Country')</label>
                                        <select name="country" class="form-control form-control-lg">
                                            @include('partials.country')
                                        </select>

                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group ">
                                        <label class="form-control-label font-weight-bold">@lang('Date of Birth')</label>
                                        <input class="form-control form-control-lg" type="date" id="dob" name="dob"
                                            placeholder="@lang('Date of Birth')" value="{{ auth()->user()->dob }}">

                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group ">
                                        <label class="form-control-label font-weight-bold">@lang('Marital Status')</label>

                                        <select class="form-control form-control-lg" name="martial_status"
                                            id="martial_status">
                                            <option value="">@lang('Select')</option>
                                            <option value="Single">@lang('Single')</option>
                                            <option value="Married">@lang('Married')</option>
                                            <option value="Divorced">@lang('Divorced')</option>
                                            <option value="Widowed">@lang('Widowed')</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group ">
                                        <label class="form-control-label font-weight-bold">@lang('Gender')</label>

                                        <select class="form-control form-control-lg" name="gender" id="gender">
                                            <option value="">@lang('Select')</option>
                                            <option value="Male">@lang('Male')</option>
                                            <option value="Female">@lang('Female')</option>
                                        </select>

                                    </div>
                                </div>
                                @if (auth()->user()->pin == '' || auth()->user()->pin == null)
                                    <div class="col-xl-4 col-md-6">
                                        <div class="form-group ">
                                            <label class="form-control-label font-weight-bold">@lang('Transaction Pin')</label>
                                            <input class="form-control form-control-lg" type="text" id="pin" name="pin"
                                                placeholder="@lang('Enter your Transaction pin')" value="{{ auth()->user()->pin }}">

                                        </div>
                                    </div>
                                @endif
                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group ">
                                        <label class="form-control-label font-weight-bold">@lang('Crypto Address')</label>
                                        <input type="text" class="form-control form-control-lg" id="crypto_address"
                                            name="crypto_address" value="{{ auth()->user()->crypto_address }}"
                                            placeholder="@lang('USDT trc20 only')" required autocomplete="off">

                                    </div>
                                </div>

                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="submit"
                                            class="btn btn--primary btn-block btn-lg">@lang('Save Changes')</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



@push('scripts')
    <script>
        'use strict';
        (function($) {
            $("select[name=country]").val("{{ auth()->user()->address->country }}");
            $("select[name=martial_status]").val("{{ auth()->user()->martial_status }}");
            $("select[name=gender]").val("{{ auth()->user()->gender }}")
        })(jQuery)

        var loadFile = function(event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src)
            }
        };
    </script>

    <script src="{{ asset('assets/plugins/intl/js/prism.js') }}"></script>
    <script src="{{ asset('assets/plugins/intl/js/intlTelInput.js') }}"></script>
    <script src="{{ asset('assets/js/countrySync.js') }}"></script>
@endpush


@push('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/intl/css/prism.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/intl/css/intlTelInput.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('assets/plugins/intl/css/demo.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('assets/plugins/intl/css/countrySync.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/intl/css/isValidNumber.css') }}">
    <style>
        .form-control:disabled,
        .form-control[readonly] {
            background-color: transparent !important;
        }

    </style>
@endpush
