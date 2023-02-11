@extends('admin.layouts.app')

@section('title')
    {{ $page_title }}
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/apps.css') }}" />
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
            <a href="{{ route('admin.withdraw.method.index') }}" class="btn btn-sm btn--primary mb-4">
                <i class="la la-fw la-backward"></i> @lang('Go Back')
            </a>
        </div>
        <!-- /breadcrumb -->

        <div class="row mb-30">
            <div class="col-lg-12 col-md-12 mb-30">
                <div class="card">
                    <div class="card-body">
                        <form action="" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <label class="form-control-label font-weight-bold"> @lang('Site Title') </label>
                                        <input class="form-control form-control-lg" type="text" name="sitename"
                                            value="{{ $general->sitename }}">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <label class="form-control-label font-weight-bold">@lang('Currency')</label>
                                        <input class="form-control  form-control-lg" type="text" name="cur_text"
                                            value="{{ $general->cur_text }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <label class="form-control-label font-weight-bold">@lang('Currency Symbol')</label>
                                        <input class="form-control  form-control-lg" type="text" name="cur_sym"
                                            value="{{ $general->cur_sym }}">
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <label class="form-control-label font-weight-bold">@lang('Site Base Color')</label>
                                    <div class="input-group">
                                        <span class="input-group-addon ">
                                            <input type='text' class="form-control  form-control-lg colorPicker"
                                                value="{{ $general->base_color }}" />
                                        </span>
                                        <input type="text" class="form-control form-control-lg colorCode"
                                            name="base_color" value="{{ $general->base_color }}" />
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <label class="form-control-label font-weight-bold">@lang('Balance transfer fixed charge')</label>
                                        <input class="form-control  form-control-lg" type="text"
                                            name="bal_trans_fixed_charge"
                                            value="{{ getAmount($general->bal_trans_fixed_charge) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <label class="form-control-label font-weight-bold">@lang('Balance transfer Percent charge')</label>
                                        <input class="form-control  form-control-lg" type="text"
                                            name="bal_trans_per_charge"
                                            value="{{ getAmount($general->bal_trans_per_charge) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <label class="form-control-label font-weight-bold">@lang('Signup Bonus')</label>
                                        <input class="form-control  form-control-lg" type="text" name="signup_bonus"
                                            value="{{ getAmount($general->signup_bonus) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <label class="form-control-label font-weight-bold">@lang('Units Per Capital')</label>
                                        <input class="form-control  form-control-lg" type="text" name="unitspercapital"
                                            value="{{ $general->unitspercapital }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <label class="form-control-label font-weight-bold">@lang('Binary Percentage')</label>
                                        <input class="form-control  form-control-lg" type="text" name="bonus_percent"
                                            value="{{ $general->bonus_percent }}">
                                        <small>Note 0.1 means 10 %</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <label class="form-control-label font-weight-bold">@lang('Referral Commission Percentage')</label>
                                        <input class="form-control  form-control-lg" type="text" name="ref_percent"
                                            value="{{ $general->ref_percent }}">
                                        <small>Note 0.08 means 8 %</small>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <label class="form-control-label font-weight-bold">@lang('Profit & Loss (PNL)')</label>
                                        <input class="form-control  form-control-lg" type="text" name="pnl"
                                            value="{{ $general->pnl }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <label class="form-control-label font-weight-bold">@lang('Email From')</label>
                                        <input class="form-control  form-control-lg" type="text" name="email_from"
                                            value="{{ $general->email_from }}">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label font-weight-bold">@lang('Terms and Condition')</label>
                                        <input type="checkbox" data-width="100%" data-size="large"
                                            data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle"
                                            data-on="@lang('Agree')" data-off="@lang('Disagree')"
                                            name="agree_policy" @if ($general->agree_policy) checked @endif>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label font-weight-bold">@lang('User Registration')</label>
                                        <input type="checkbox" data-width="100%" data-size="large"
                                            data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle"
                                            data-on="@lang('Enable')" data-off="@lang('Disabled')"
                                            name="registration" @if ($general->registration) checked @endif>
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <label class="form-control-label font-weight-bold">@lang('Force Secure Password')</label>
                                    <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success"
                                        data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Enable')"
                                        data-off="@lang('Disabled')" name="secure_password"
                                        @if ($general->secure_password) checked @endif>
                                </div>

                                <div class="form-group col-md-4">
                                    <label class="form-control-label font-weight-bold">@lang('Force SSL')</label>
                                    <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success"
                                        data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Enable')"
                                        data-off="@lang('Disabled')" name="force_ssl"
                                        @if ($general->force_ssl) checked @endif>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-lg-3 col-sm-6 col-md-4">
                                    <label class="form-control-label font-weight-bold">@lang('Email Verification')</label>
                                    <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success"
                                        data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Enable')"
                                        data-off="Disable" name="ev"
                                        @if ($general->ev) checked @endif>
                                </div>
                                <div class="form-group col-lg-3 col-sm-6 col-md-4">
                                    <label class="form-control-label font-weight-bold">@lang('Email Notification')</label>
                                    <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success"
                                        data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Enable')"
                                        data-off="Disable" name="en"
                                        @if ($general->en) checked @endif>
                                </div>
                                <div class="form-group col-lg-3 col-sm-6 col-md-4">
                                    <label class="form-control-label font-weight-bold">@lang('SMS Verification')</label>
                                    <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success"
                                        data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Enable')"
                                        data-off="Disable" name="sv"
                                        @if ($general->sv) checked @endif>
                                </div>
                                <div class="form-group col-lg-3 col-sm-6 col-md-4">
                                    <label class="form-control-label font-weight-bold">@lang('SMS Notification')</label>
                                    <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success"
                                        data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Enable')"
                                        data-off="Disable" name="sn"
                                        @if ($general->sn) checked @endif>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit"
                                    class="btn btn--primary btn-block btn-lg">@lang('Update')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="row ">

            <div class="col-lg-12 mb-30">
                <div class="card">
                    <div class="card-header ">
                        <h4 class="card-title font-weight-normal">@lang('Matching Bonus')</h4>
                    </div>
                    <form action="{{ route('admin.roi.update') }}" method="post">
                        <div class="card-body">
                            @csrf

                            <div class="row">
                                <div class="form-group col-md-4 ">
                                    <label>@lang('ROI Bonus Time')</label>
                                    <select name="roi_bonus_time" class="form-control form-control-lg">
                                        <option value="Select Time">Select option</option>
                                        <option value="daily">@lang('Daily')</option>
                                        <option value="weekly">@lang('Weekly')</option>
                                        <option value="monthly">@lang('Monthly')</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4" id="daily_time" style="display:none;">
                                    <label>@lang('Daily Time')</label>
                                    <select name="daily_time" class="form-control form-control-lg">
                                        <option value="1">@lang('01:00')</option>
                                        <option value="2">@lang('02:00')</option>
                                        <option value="3">@lang('03:00')</option>
                                        <option value="4">@lang('04:00')</option>
                                        <option value="5">@lang('05:00')</option>
                                        <option value="6">@lang('06:00')</option>
                                        <option value="7">@lang('07:00')</option>
                                        <option value="8">@lang('08:00')</option>
                                        <option value="9">@lang('09:00')</option>
                                        <option value="10">@lang('10:00')</option>
                                        <option value="11">@lang('11:00')</option>
                                        <option value="12">@lang('12:00')</option>
                                        <option value="13">@lang('13:00')</option>
                                        <option value="14">@lang('14:00')</option>
                                        <option value="15">@lang('15:00')</option>
                                        <option value="16">@lang('16:00')</option>
                                        <option value="17">@lang('17:00')</option>
                                        <option value="18">@lang('18:00')</option>
                                        <option value="19">@lang('19:00')</option>
                                        <option value="20">@lang('20:00')</option>
                                        <option value="21">@lang('21:00')</option>
                                        <option value="22">@lang('22:00')</option>
                                        <option value="23">@lang('23:00')</option>
                                        <option value="24">@lang('24:00')</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4" id="weekly_time" style="display:none;">
                                    <label>@lang('Weekly Time')</label>
                                    <select name="weekly_time" class="form-control form-control-lg">
                                        <option value="sat">@lang('Saturday')</option>
                                        <option value="sun">@lang('Sunday')</option>
                                        <option value="mon">@lang('Monday')</option>
                                        <option value="tue">@lang('Tuesday')</option>
                                        <option value="wed">@lang('Wednesday')</option>
                                        <option value="thu">@lang('Thursday')</option>
                                        <option value="fri">@lang('Friday')</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4" id="monthly_time" style="display:none;">
                                    <label>@lang('Monthly Time')</label>
                                    <select name="monthly_time" class="form-control form-control-lg">
                                        <option value="1">@lang('1st day Month')</option>
                                        <option value="15">@lang('15th day of Month')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="form-group col-md-12 text-center">
                                <button type="submit"
                                    class="btn btn--primary btn-block btn-lg">@lang('Update')</button>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>

        <div class="row ">

            <div class="col-lg-12 mb-30">
                <div class="card">
                    <div class="card-header ">
                        <h4 class="card-title font-weight-normal">@lang('Update Passwords and Transaction Pin for all Users ')</h4>
                    </div>
                    <form action="{{ route('admin.update.password') }}" method="post">
                        <div class="card-body">
                            @csrf

                            <div class="row">
                                <div class="form-group col-md-4 ">
                                    <label>@lang('Password')</label>
                                    <input type="text" name="password" class="form-control form-control-lg">

                                </div>
                                <div class="form-group col-md-4">
                                    <label>@lang('Transaction Pin')</label>
                                    <input type="text" name="pin" class="form-control form-control-lg">

                                </div>

                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="form-group col-md-12 text-center">
                                <button type="submit"
                                    class="btn btn--primary btn-block btn-lg">@lang('Update')</button>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/spectrum.css') }}">
    <style>
        .sp-replacer {
            padding: 0;
            border: 1px solid rgba(0, 0, 0, .125);
            border-radius: 5px 0 0 5px;
            border-right: none;
        }

        .sp-preview {
            width: 100px;
            height: 46px;
            border: 0;
        }

        .sp-preview-inner {
            width: 110px;
        }

        .sp-dd {
            display: none;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('assets/admin/js/spectrum.js') }}"></script>

    <script>
        'use strict';
        (function($) {
            $('.colorPicker').spectrum({
                color: $(this).data('color'),
                change: function(color) {
                    $(this).parent().siblings('.colorCode').val(color.toHexString().replace(/^#?/, ''));
                }
            });

            $('.colorCode').on('input', function() {
                var clr = $(this).val();
                $(this).parents('.input-group').find('.colorPicker').spectrum({
                    color: clr,
                });
            });

            $("select[name=roi_bonus_time]").val("{{ $general->roi_bonus_time }}");
            $("select[name=weekly_time]").val("{{ $general->roi_when }}");
            $("select[name=monthly_time]").val("{{ $general->roi_when }}");
            $("select[name=daily_time]").val("{{ $general->roi_when }}");

            $('select[name=roi_bonus_time]').on('change', function() {
                roiBonus($(this).val());
            });

            roiBonus($('select[name=roi_bonus_time]').val());

            function roiBonus(roi_bonus_time) {
                if (roi_bonus_time == 'daily') {
                    document.getElementById('weekly_time').style.display = 'none';
                    document.getElementById('monthly_time').style.display = 'none'
                    document.getElementById('daily_time').style.display = 'block'

                } else if (roi_bonus_time == 'weekly') {
                    document.getElementById('weekly_time').style.display = 'block';
                    document.getElementById('monthly_time').style.display = 'none'
                    document.getElementById('daily_time').style.display = 'none'
                } else if (roi_bonus_time == 'monthly') {
                    document.getElementById('weekly_time').style.display = 'none';
                    document.getElementById('monthly_time').style.display = 'block'
                    document.getElementById('daily_time').style.display = 'none'
                }
            }
        })(jQuery)
    </script>
@endpush
