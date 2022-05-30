@extends($activeTemplate . 'layouts.app')

@section('panel')

    @php
    $policyElements = getContent('policy_pages.element');
    @endphp

    <!-- Account Section -->
    <div class="account-section bg_img"
        data-background="{{ getImage('assets/images/frontend/sign_up/' . @$content->data_values->background_image, '1920x1080') }}">
        <div class="account__section-wrapper">
            <div class="account__section-content sign-up">
                <div class="w-100">
                    <div class="logo mb-4">
                        <a href="{{ route('home') }}">
                            <img src="{{ getImage(imagePath()['logoIcon']['path'] . '/darkLogo.png') }}"
                                alt="@lang('site-logo')">
                        </a>
                    </div>
                    <div class="section__header text-white mb-4">
                        <h5 class="section__title mb-0 text-white">@lang('Sign Up')</h5>
                    </div>
                    <form class="account--form row gy-3" method="post" action="{{ route('user.register') }}"
                        onsubmit="return submitUserForm();">
                        @csrf

                        @if ($ref_user == null && $ref_placer == null)
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form--label-2" for="sponsor_id">Sponsor ID</label>
                                        <input type="text" name="sponsor_id" id="sponsor_id"
                                            class="form-control form--control-2" placeholder="Enter Sponsor ID"
                                            value="{{ old('sponsor_id') }}">
                                        <div id="ref"></div>
                                        <span id="referral"></span>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form--label-2" for="placer_id">Placer ID</label>
                                        <input type="text" name="placer_id" id="placer_id"
                                            class="form-control form--control-2" placeholder="Enter Placer ID"
                                            value="{{ old('placer_id') }}">
                                        <div id="ref_placer"></div>
                                        <span id="referral_placer"></span>
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form--label-2" for="position">Select Position</label>
                                        <select name="position" id="position" class="form-control form--control-2" required
                                            disabled>
                                            <option value="">Select Position</option>
                                            @foreach (mlmPositions() as $k => $v)
                                                <option value="{{ $k }}">{{ $v }}</option>
                                            @endforeach
                                        </select>
                                        <span id="position_check">
                                            <span class="text-danger">Please enter sponsor_id and placer_id</span>
                                        </span>
                                    </div>
                                </div>
                            @else
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form--label-2" for="sponsor_id">Sponsor ID</label>
                                            <input type="text" name="sponsor_id" class="form-control form--control-2"
                                                placeholder="Enter Sponsor ID" value="{{ $ref_user->sponsor_id }}"
                                                readonly>
                                            @php echo $sponsorss_id; @endphp
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form--label-2" for="placer_id">Placer ID</label>
                                            <input type="text" name="placer_id" class="form-control form--control-2"
                                                placeholder="Enter Placer ID" value="{{ $ref_placer->placer_id }}"
                                                readonly>
                                            @php echo $placerss_id; @endphp
                                        </div>

                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form--label-2" for="position">Select Position</label>
                                            <select id="position" class="form-control form--control-2" required disabled>
                                                <option value="">Select Position</option>
                                                @foreach (mlmPositions() as $k => $v)
                                                    <option value="{{ $k }}">@lang($v)</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="position" value="{{ $position }}">
                                            @php echo $joining; @endphp
                                        </div>
                                    </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form--label-2" for="firstname">First Name</label>
                                    <input type="text" name="firstname" id="firstname" class="form-control form--control-2"
                                        placeholder="Enter First Name" value="{{ old('firstname') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form--label-2" for="lastname">Last Name</label>
                                    <input type="text" name="lastname" id="lastname" class="form-control form--control-2"
                                        placeholder="Enter Last Name" value="{{ old('lastname') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form--label-2" for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control form--control-2"
                                        placeholder="Enter Email" value="{{ old('email') }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form--label-2" for="Phone">Phone</label>
                                    <input id="phone" class="form-control" value="{{ old('phone') }}" name="phone"
                                        type="tel">
                                    {{-- <input type="hidden" name="full_phone" id="full_phone"> --}}
                                    <span id="valid-msg" class="hide">✓ Valid</span>
                                    <span id="error-msg" class="hide"></span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form--label-2" for="country">Country</label>
                                    <input type="text" readonly name="country" id="address-country" placeholder="Country"
                                        class="form-control country">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form--label-2" for="city">City</label>
                                    <input type="text" name="city" id="city" placeholder="city"
                                        class="form-control form--control-2" value="{{ old('city') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form--label-2" for="state">State</label>
                                    <input type="text" name="state" id="state" placeholder="State"
                                        class="form-control form--control-2" value="{{ old('state') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form--label-2" for="username">Username</label>
                                    <input type="text" name="username" placeholder="Enter your username" id="username"
                                        class="form-control form--control-2" value={{ old('username') }}>
                                    <span id="username_check"></span>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form--label-2" for="pin_valid">Pin</label>
                                    <input type="text" name="pin" id="pin_valid" placeholder="Enter your Transaction Pin"
                                        class="form-control form--control-2">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form--label-2" for="epin_valid">Epin</label>
                                    <input type="text" name="epin" id="epin_valid" placeholder="Enter your Epin"
                                        class="form-control form--control-2">
                                    <div id="epin_check"></div>
                                    <span id="referral_epin"></span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form--label-2" for="password">Password</label>
                                    <input type="password" name="password" id="password"
                                        class="form-control form--control-2" placeholder="Enter Password">

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form--label-2" for="password_confirmation">Confirm Password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="form-control form--control-2" placeholder="Enter Confirm Password">
                                </div>
                            </div>


                            @if (reCaptcha())
                                <div class="col-lg-12">
                                    @php echo reCaptcha(); @endphp
                                </div>
                            @endif

                            <div class="col-lg-12">
                                @include($activeTemplate . 'partials.custom-captcha')
                            </div>

                            @if ($general->agree_policy)
                                <div class="col-md-12">
                                    <div class="d-flex flex-wrap justify-content-between">
                                        <div class="checkgroup d-flex flex-wrap align-items-center">
                                            <input type="checkbox" class="border-0" id="agree" name="agree">
                                            &nbsp;
                                            <label for="agree" class="m-0 pl-2 text-white">@lang('I agree with')&nbsp;</label>
                                            @foreach ($policyElements as $item)
                                                <a href="{{ route('policy.details', [slug(@$item->data_values->title), $item->id]) }}"
                                                    class="text--base"> {{ __($item->data_values->title) }} </a>
                                                @if (!$loop->last)
                                                    ,&nbsp;
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif


                            <div class="col-sm-12">
                                <button type="submit" class="cmn--btn w-100">@lang('Sign Up')</button>
                            </div>
                    </form>
                    <div class="mt-4 text--white">
                        <span class="d-block">
                            @lang('Already Have an Account') ? <a href="{{ route('user.login') }}"
                                class="text--base">@lang('Sign In')</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Account Section -->
@endsection

@push('script')
    <script src="{{ asset('assets/plugins/intl/js/prism.js') }}"></script>
    <script src="{{ asset('assets/plugins/intl/js/intlTelInput.js') }}"></script>
    <script src="{{ asset('assets/js/countrySync.js') }}"></script>
    <script>
        (function($) {
            "use strict";

            // var oldPosition = '{{ old('position') }}';

            // if (oldPosition) {
            //     $('select[name=position]').removeAttr('disabled');
            //     $('#position').val(oldPosition);
            // }


            var not_select_msg = $('#position_check').html();
            // Check Sponsor ID
            $(document).on('keyup', '#sponsor_id', function() {
                var sponsor = $('#sponsor_id').val();
                var token = "{{ csrf_token() }}";
                $.ajax({
                    type: "POST",
                    url: "{{ route('check.sponsor') }}",
                    data: {
                        'sponsor': sponsor,
                        '_token': token
                    },
                    success: function(data) {
                        // if (data.success) {
                        // $('select[name=position]').removeAttr('disabled');
                        // $('#position_check').text('');
                        // } else {
                        // $('select[name=position]').attr('disabled', true);
                        // $('#position_check').html(not_select_msg);
                        // }
                        $("#ref").html(data.msg);
                    }
                });
            });
            // Check Placer
            $(document).on('keyup', '#placer_id', function() {
                var placer = $('#placer_id').val();
                var token = "{{ csrf_token() }}";
                $.ajax({
                    type: "POST",
                    url: "{{ route('check.placer') }}",
                    data: {
                        'placer': placer,
                        '_token': token
                    },
                    success: function(data) {
                        if (data.success) {
                            $('select[name=position]').removeAttr('disabled');
                            $('#position_check').text('');
                        } else {
                            $('select[name=position]').attr('disabled', true);
                            $('#position_check').html(not_select_msg);
                        }
                        console.log(data.msg);
                        $("#ref_placer").html(data.msg);
                    }
                });
            });
            // Check Epin
            $(document).on('keyup', '#epin_valid', function() {
                var epin = $('#epin_valid').val();
                var token = "{{ csrf_token() }}";
                $.ajax({
                    type: "POST",
                    url: "{{ route('check.epin') }}",
                    data: {
                        'epin': epin,
                        '_token': token
                    },
                    success: function(data) {

                        $("#epin_check").html(data.msg);
                    }
                });
            });

            $(document).on('change', '#position', function() {
                updateHand();
            });

            function updateHand() {
                var pos = $('#position').val();
                var referrer_id = $('#placer_ref_id').val();
                var token = "{{ csrf_token() }}";
                $.ajax({
                    type: "POST",
                    url: "{{ route('get.user.position') }}",
                    data: {
                        'referrer': referrer_id,
                        'position': pos,
                        '_token': token
                    },
                    success: function(data) {
                        $("#position_check").html(data.msg);
                    }
                });
            }

            @if (old('position'))
                $(`select[name=position]`).val('{{ old('position') }}');
            @endif


            @if ($country_code)
                $(`option[data-code={{ $country_code }}]`).attr('selected', '');
            @endif

            $('select[name=country_code]').change(function() {
                $('input[name=country]').val($('select[name=country_code] :selected').data('country'));
            }).change();

            function submitUserForm() {
                var response = grecaptcha.getResponse();
                if (response.length == 0) {
                    document.getElementById('g-recaptcha-error').innerHTML =
                        '<span style="color:red;">@lang('Captcha field is required.')</span>';
                    return false;
                }
                return true;
            }

            function verifyCaptcha() {
                document.getElementById('g-recaptcha-error').innerHTML = '';
            }

            @if ($general->secure_password)
                $('input[name=password]').on('input', function() {
                    var password = $(this).val();
                    var capital = /[ABCDEFGHIJKLMNOPQRSTUVWXYZ]/;
                    var capital = capital.test(password);
                    if (!capital) {
                        $('.capital').removeClass('text--success');
                    } else {
                        $('.capital').addClass('text--success');
                    }
                    var number = /[123456790]/;
                    var number = number.test(password);
                    if (!number) {
                        $('.number').removeClass('text--success');
                    } else {
                        $('.number').addClass('text--success');
                    }
                    var special = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
                    var special = special.test(password);
                    if (!special) {
                        $('.special').removeClass('text--success');
                    } else {
                        $('.special').addClass('text--success');
                    }

                });
            @endif


        })(jQuery);
    </script>
@endpush


@push('style')
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
