@extends($activeTemplate . 'user.layouts.master')

@section('title', 'Register')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/intl/css/prism.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/intl/css/intlTelInput.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('assets/plugins/intl/css/demo.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('assets/plugins/intl/css/countrySync.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/intl/css/isValidNumber.css') }}">
@endpush

@section('content')
    <!-- main-signin-wrapper -->
    <div class="my-auto page page-h">
        <div class="main-signin-wrapper">
            <div class="main-card-signin d-md-flex wd-100p">
                <div class="wd-md-40p login d-none d-md-block page-signin-style p-5 text-white">
                    {{-- <div class="my-auto authentication-pages"> --}}
                    <div class="side-left">
                        {{-- <img src="{{  asset('assets/img/brand/logo-white.png') }}" class="m-0 mb-4" alt="logo"> --}}
                        <h4 class="mb-4">Welcome to MLM World</h4>
                        <p class="mb-2">Already Have an Account?</p>
                        <a href="{{ route('user.login') }}" class="btn btn-danger">Login</a>
                    </div>
                    {{-- </div> --}}
                </div>
                <div class="sign-up-body wd-md-70p">
                    <div class="main-signin-header">
                        <h2>Welcome back!</h2>
                        <h4>Please Register with HDMI50</h4>
                        <form method="POST" action="{{ route('user.registeration') }}">
                            @csrf

                            @if ($ref_user == null && $ref_placer == null)
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sponsor_id">Sponsor ID</label>
                                            <input type="text" name="sponsor_id" id="sponsor_id" class="form-control"
                                                placeholder="Enter Sponsor ID" value="{{ old('sponsor_id') }}">
                                            <div id="ref"></div>
                                            <span id="referral"></span>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="placer_id">Placer ID</label>
                                            <input type="text" name="placer_id" id="placer_id" class="form-control"
                                                placeholder="Enter Placer ID" value="{{ old('placer_id') }}">
                                            <div id="ref_placer"></div>
                                            <span id="referral_placer"></span>
                                        </div>

                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="position">Select Position</label>
                                            <select name="position" id="position" class="form-control" required disabled>
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
                                                <label for="sponsor_id">Sponsor ID</label>
                                                <input type="text" name="sponsor_id" class="form-control"
                                                    placeholder="Enter Sponsor ID" value="{{ $ref_user->sponsor_id }}" readonly>
                                                 @php echo $sponsorss_id; @endphp
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="placer_id">Placer ID</label>
                                                <input type="text" name="placer_id" class="form-control"
                                                    placeholder="Enter Placer ID" value="{{ $ref_placer->placer_id }}" readonly>
                                                 @php echo $placerss_id; @endphp
                                            </div>

                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="position">Select Position</label>
                                                <select id="position" class="form-control" required disabled>
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
                                        <label for="firstname">First Name</label>
                                        <input type="text" name="firstname" id="firstname" class="form-control"
                                            placeholder="Enter First Name" value="{{ old('firstname') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lastname">Last Name</label>
                                        <input type="text" name="lastname" id="lastname" class="form-control"
                                            placeholder="Enter Last Name" value="{{ old('lastname') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" id="email" class="form-control"
                                            placeholder="Enter Email" value="{{ old('email') }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Phone">Phone</label>
                                        <input id="phone" class="form-control" value="{{ old('phone') }}" name="phone" type="tel">
                                        {{-- <input type="hidden" name="full_phone" id="full_phone"> --}}
                                        <span id="valid-msg" class="hide">✓ Valid</span>
                                        <span id="error-msg" class="hide"></span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="country">Country</label>
                                        <input type="text" readonly name="country" id="address-country"
                                            placeholder="Country" class="form-control country">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="city">city</label>
                                        <input type="text" name="city" id="city" placeholder="city" class="form-control" value="{{ old('city') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="state">State</label>
                                        <input type="text" name="state" id="state" placeholder="State"
                                            class="form-control" value="{{ old('state') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" name="username" placeholder="Enter your username" id="username"
                                            class="form-control" value={{ old('username') }}>
                                        <span id="username_check"></span>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pin_valid">Pin</label>
                                        <input type="text" name="pin" id="pin_valid" placeholder="Enter your Transaction Pin"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="epin_valid">Epin</label>
                                        <input type="text" name="epin" id="epin_valid" placeholder="Enter your Epin"
                                            class="form-control">
                                        <div id="epin_check"></div>
                                        <span id="referral_epin"></span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" id="password" class="form-control"
                                            placeholder="Enter Password">

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password_confirmation">Confirm Password</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                            class="form-control" placeholder="Enter Confirm Password">
                                    </div>
                                </div>


                                <button class="btn btn-main-primary btn-block">Create Account</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /main-signin-wrapper -->
@endsection

@push('scripts')
    <script src="{{ asset('assets/plugins/intl/js/prism.js') }}"></script>
    <script src="{{ asset('assets/plugins/intl/js/intlTelInput.js') }}"></script>
    <script src="{{ asset('assets/js/countrySync.js') }}"></script>

    <script>
        (function($) {
            "use strict";
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
                        //     $('select[name=position]').removeAttr('disabled');
                        //     $('#position_check').text('');
                        // } else {
                        //     $('select[name=position]').attr('disabled', true);
                        //     $('#position_check').html(not_select_msg);
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

        })(jQuery);
    </script>
@endpush
