@extends($activeTemplate . 'user.layouts.app')

@section('title')
    {{ $page_title }}
@endsection

@section('content')
    <!-- container -->
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
            <div class="d-flex align-items-end flex-wrap my-auto right-content breadcrumb-right">
                <button class="btn btn-primary mt-2 mt-xl-0">Current Rank<br>
                    <span class="badge badge-light">Silver Rank</span>
                    {{-- <span class="badge badge-light">{{ auth()->user()->rank }}</span> --}}
                </button>
            </div>
        </div>
        <!-- /breadcrumb -->
        {{-- Show KYC form --}}
        @if (auth()->user()->kyc_status == 0)
            <div class="row">
                <div class="col-md-12">
                    <div class="alert block-none alert-warning p-2" role="alert">
                        <strong>@lang('Please complete your KYC before you can transfer balance.')</strong>
                    </div>
                    {{-- show form her --}}
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title font-weight-normal">@lang('KYC')</h4>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('user.kyc.store') }}">
                                @csrf
                                <div class="form-row">

                                    <div class="form-group col-md-4">
                                        <label>
                                            <h5>@lang('Phone') <span class="text-danger">*</span> </h5>
                                        </label>
                                        <input id="phone" class="form-control form-control-lg" value="{{ old('phone') }}"
                                            name="phone" type="tel">
                                        {{-- <input type="hidden" name="full_phone" id="full_phone"> --}}
                                        <span id="valid-msg" class="hide">✓ Valid</span>
                                        <span id="error-msg" class="hide"></span>
                                    </div>
                                    <div class="form-group col-md-8">
                                        <label>
                                            <h5>@lang('Country') <span class="text-danger">*</span> </h5>
                                        </label>
                                        <input type="text" readonly name="country" id="address-country"
                                            placeholder="Country" class="form-control form-control-lg country">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>
                                            <h5>@lang('State') <span class="text-danger">*</span> </h5>
                                        </label>
                                        <input type="text" name="state" id="state" value="{{ old('state') }}"
                                            placeholder="State" class="form-control form-control-lg">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>
                                            <h5>@lang('Address') <span class="text-danger">*</span> </h5>
                                        </label>
                                        <input type="text" class="form-control form-control-lg" id="address"
                                            value="{{ value('address') }}" name="address" placeholder="@lang('Address')"
                                            required autocomplete="off">

                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>
                                            <h5>@lang('Crypto Wallet Address') <span class="text-danger">*</span> </h5>
                                        </label>
                                        <input type="text" class="form-control form-control-lg" id="crypto_address"
                                            name="crypto_address" value="{{ old('crypto_address') }}"
                                            placeholder="@lang('USDT trc20 only')" required autocomplete="off">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>
                                            <h5>@lang('Date of Birth') <span class="text-danger">*</span> </h5>
                                        </label>
                                        <input type="date" class="form-control form-control-lg" id="dob" name="dob"
                                            placeholder="@lang('Date of Birth')" required autocomplete="off">

                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>
                                            <h5>@lang('Marital Status') <span class="text-danger">*</span> </h5>
                                        </label>
                                        <select class="form-control form-control-lg" name="martial_status"
                                            id="martial_status">
                                            <option value="">@lang('Select')</option>
                                            <option value="Single">@lang('Single')</option>
                                            <option value="Married">@lang('Married')</option>
                                            <option value="Divorced">@lang('Divorced')</option>
                                            <option value="Widowed">@lang('Widowed')</option>
                                        </select>

                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>
                                            <h5>@lang('Gender') <span class="text-danger">*</span> </h5>
                                        </label>
                                        <select class="form-control form-control-lg" name="gender" id="gender">
                                            <option value="">@lang('Select')</option>
                                            <option value="Male">@lang('Male')</option>
                                            <option value="Female">@lang('Female')</option>
                                        </select>

                                    </div>



                                    <div class="form-group col-md-12">
                                        <button type="submit"
                                            class="btn btn-primary btn-lg btn-block">@lang('Submit')</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        @elseif (auth()->user()->kyc_status == 1)
            <div class="row">
                <div class="col-md-12">
                    <div class="alert block-none alert-info p-2" role="alert">
                        <strong>@lang('Your KYC is under review. Please wait for admin approval.')</strong>
                    </div>
                </div>
            </div>
        @elseif (auth()->user()->kyc_status == 2)
            <div class="row">
                <div class="col-md-12">
                    <div class="alert block-none alert-danger p-2" role="alert">
                        <strong>@lang('Your KYC is rejected. Please contact admin.')</strong>
                    </div>
                </div>
            </div>
        @elseif (auth()->user()->kyc_status == 3)
            <div class="row">
                <div class="col-md-12">
                    <div class="alert block-none alert-success p-2" role="alert">
                        <strong>@lang('Your KYC is approved. Please upload your proof of address.')</strong>
                    </div>
                </div>
            </div>
        @endif


    </div>
@endsection


@push('scripts')
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
