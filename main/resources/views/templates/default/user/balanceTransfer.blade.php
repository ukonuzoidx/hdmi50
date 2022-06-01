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

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title font-weight-normal">@lang('Balance Transfer')</h4>
                    </div>
                    <div class="col-md-12 text-center">
                        {{-- <div class="alert block-none alert-danger p-2" role="alert">
                            <strong>@lang('Balance Transfer Charge') {{ getAmount($general->bal_trans_fixed_charge) }}
                                {{ __($general->cur_text) }} @lang('Fixed and')
                                {{ getAmount($general->bal_trans_per_charge) }}
                                % @lang('of your total amount to transfer balance.')</strong>
                            <p id="after-balance"></p>
                        </div> --}}
                    </div>
                    <form class="contact-form" method="POST" action="{{ route('user.balance.transfer.post') }}">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>
                                        <h5> @lang('Username To Send Amount') <span class="text-danger">*</span> </h5>
                                    </label>
                                    <input type="text" class="form-control form-control-lg" id="username" name="username"
                                        placeholder="@lang('username')" required autocomplete="off">
                                    <span id="position-test"></span>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="InputMail">
                                        <h5>@lang('Transfer Amount') <span class="text-danger">*</span> </h5>
                                    </label>
                                    <input onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                                        class="form-control form-control-lg" autocomplete="off" id="amount" name="amount"
                                        placeholder="@lang('Amount') {{ __($general->cur_text) }}" required>
                                    <span id="balance-message"></span>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="InputMail">
                                        <h5>@lang('Transaction Pin') <span class="text-danger">*</span> </h5>
                                    </label>
                                    <input type="password" class="form-control form-control-lg" id="pin"
                                        name="pin" placeholder="@lang('....')" required>
                                    <span id="pin-message"></span>
                                </div>

                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="form-group col-md-12 text-center">
                                <button type="submit" class=" btn btn-block btn--primary mr-2">@lang('Transfer Balance')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        'use strict';
        (function($) {
            $(document).on('keyup', '#username', function() {
                var username = $('#username').val();
                var token = "{{ csrf_token() }}";
                if (username) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('user.search.user') }}",
                        data: {
                            'username': username,
                            '_token': token
                        },
                        success: function(data) {
                            if (data.success) {
                                $('#position-test').html(
                                    '<div class="text--success mt-1">@lang('User found')</div>');
                            } else {
                                $('#position-test').html(
                                    '<div class="text--danger mt-2">@lang('User not found')</div>');
                            }
                        }
                    });
                } else {
                    $('#position-test').html('');
                }
            });

            $(document).on('keyup', '#amount', function() {
                var amount = parseFloat($('#amount').val());
                var balance = parseFloat("{{ Auth::user()->balance + 0 }}");
                var fixed_charge = parseFloat("{{ $general->bal_trans_fixed_charge + 0 }}");
                var percent_charge = parseFloat("{{ $general->bal_trans_per_charge + 0 }}");
                var percent = (amount * percent_charge) / 100;
                var with_charge = amount + fixed_charge + percent;
                if (with_charge > balance) {
                    $('#after-balance').html('<p  class="text-danger">' + with_charge +
                        ' {{ $general->cur_text }} ' +
                        ' {{ __('will be subtracted from your balance') }}' + '</p>');
                    $('#balance-message').html('<small class="text-danger">Insufficient Balance!</small>');
                } else if (with_charge <= balance) {
                    $('#after-balance').html('<p class="text-danger">' + with_charge +
                        ' {{ $general->cur_text }} ' +
                        ' {{ __('will be subtracted from your balance') }}' + '</p>');
                    $('#balance-message').html('');
                }
            });
            // check if pin is correct
            $(document).on('keyup', '#pin', function() {
                var pin = $('#pin').val();
                var token = "{{ csrf_token() }}";
                if (pin) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('user.check.pin') }}",
                        data: {
                            'pin': pin,
                            '_token': token
                        },
                        success: function(data) {
                            if (data.success) {
                                $('#pin-message').html(
                                    '<small class="text-success">@lang('Pin is correct')</small>');
                            } else {
                                $('#pin-message').html(
                                    '<small class="text-danger">@lang('Pin is incorrect')</small>');
                            }
                        }
                    });
                } else {
                    $('#pin-message').html('');
                }
            });

        })(jQuery)
    </script>
@endpush
