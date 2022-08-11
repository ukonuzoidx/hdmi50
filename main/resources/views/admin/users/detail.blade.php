@extends('admin.layouts.app')

@section('title')
    {{ $page_title }}
@endsection

@push('css')
    {{-- <link rel="stylesheet" href="{{ asset('assets/admin/css/apps.css') }}" /> --}}
    <!-- Internal  Data table css -->
    <link href="{{ asset('assets/admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endpush


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

            <div class="col-xl-3 col-lg-5 col-md-5 mb-30">

                <div class="card b-radius--10 overflow-hidden">
                    <div class="card-body p-0">
                        <div class="p-3">
                            <div class="">
                                <img src="{{ getImage('assets/images/user/profile/' . $user->image, '350x300') }}"
                                    alt="@lang('profile-image')" class="b-radius--10 w-100">
                            </div>
                            <div class="mt-15">
                                <h4 class="">{{ $user->fullname }}</h4>
                                <span
                                    class="text--small">@lang('Joined At ')<strong>{{ showDateTime($user->created_at, 'd M, Y h:i A') }}</strong></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card b-radius--10 overflow-hidden mt-30">
                    <div class="card-body">
                        <h5 class="mb-20 text-muted">@lang('User information')</h5>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Username')
                                <span class="font-weight-bold">{{ $user->username }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Ref By')
                                <span class="font-weight-bold"> {{ $ref_id->username ?? 'N/A' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Balance')
                                <span class="font-weight-bold"> {{ getAmount($user->balance) }} USD </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Total PV')
                                <span class="font-weight-bold"><a href="#">
                                        {{ getAmount($user->userExtra->pv_left + $user->userExtra->pv_right) }}
                                    </a></span>
                                {{-- <span class="font-weight-bold"><a href="{{route('admin.report.single.bvLog', $user->id)}}"> {{getAmount($user->userExtra->pv_left + $user->userExtra->pv_right)}} </a></span> --}}
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Paid Left User')
                                <span class="font-weight-bold">{{ $user->userExtra->paid_left }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Paid Right User')
                                <span class="font-weight-bold">{{ $user->userExtra->paid_right }}</span>
                            </li>
                                <li class="list-group-item rounded-0 d-flex justify-content-between">
                                    <span>@lang('User ID')</span> {{ $user->user_id }}
                                </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Status')
                                @switch($user->status)
                                    @case(1)
                                        <span class="badge badge-pill bg--success">@lang('Active')</span>
                                    @break

                                    @case(2)
                                        <span class="badge badge-pill bg--danger">@lang('Banned')</span>
                                    @break
                                @endswitch
                            </li>

                        </ul>
                    </div>
                </div>
                <div class="card b-radius--10 overflow-hidden mt-30">
                    <div class="card-body">
                        <h5 class="mb-20 text-muted">@lang('User action')</h5>
                        <a data-toggle="modal" href="#addSubModal" class="btn btn--success btn--shadow btn-block btn-lg">
                            @lang('Add Balance')
                        </a>
                        <a href="{{ route('admin.users.email.single', $user->id) }}"
                            class="btn btn--danger btn--shadow btn-block btn-lg">
                            @lang('Send Email')
                        </a>
                        <a href="{{ route('admin.users.single.tree', $user->username) }}"
                            class="btn btn--primary btn--shadow btn-block btn-lg">
                            @lang('User Tree')
                        </a>
                        <a href="{{ route('admin.users.ref', $user->id) }}"
                            class="btn btn--info btn--shadow btn-block btn-lg">
                            @lang('User Referrals')
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-xl-9 col-lg-7 col-md-7 mb-30">
                <div class="row mb-none-30">

                    <div class="col-xl-4 col-lg-6 col-sm-6 mb-30">
                        <div class="dashboard-w1 bg--red b-radius--10 box-shadow has--link">
                            <a href="{{ route('admin.users.withdrawals', $user->id) }}" class="item--link"></a>
                            <div class="icon">
                                <i class="fa fa-wallet"></i>
                            </div>
                            <div class="details">
                                <div class="numbers">
                                    <span class="amount">{{ getAmount($totalWithdraw) }}</span>
                                    <span class="currency-sign">USD</span>
                                </div>
                                <div class="desciption">
                                    <span>@lang('Total Withdraw')</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- dashboard-w1 end -->

                    <div class="col-xl-4 col-lg-6 col-sm-6 mb-30">
                        <div class="dashboard-w1 bg--dark b-radius--10 box-shadow has--link">
                            <a href="{{ route('admin.users.transactions', $user->id) }}" class="item--link"></a>
                            <div class="icon">
                                <i class="la la-exchange-alt"></i>
                            </div>
                            <div class="details">
                                <div class="numbers">
                                    <span class="amount">{{ $totalTransaction }}</span>
                                </div>
                                <div class="desciption">
                                    <span>@lang('Total Transaction')</span>
                                </div>
                            </div>
                        </div>
                    </div><!-- dashboard-w1 end -->


                    <div class="col-xl-4 col-lg-6 col-sm-6 mb-30">
                        <div class="dashboard-w1 bg--info b-radius--10 box-shadow has--link">
                            <a href="{{ route('admin.report.invest') }}?user={{ $user->id }}"
                                class="item--link"></a>
                            <div class="icon">
                                <i class="la la-money"></i>
                            </div>
                            <div class="details">
                                <div class="numbers">
                                    <span class="amount">{{ getAmount($user->total_invest) }}</span>
                                    <span class="currency-sign">USD</span>
                                </div>
                                <div class="desciption">
                                    <span>@lang('Total Invest')</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-6 col-sm-6 mb-30">
                        <div class="dashboard-w1 bg--indigo b-radius--10 box-shadow has--link">
                            <a href="{{ route('admin.report.refCom') }}?userID={{ $user->id }}"
                                class="item--link"></a>
                            <div class="icon">
                                <i class="la la-user"></i>
                            </div>
                            <div class="details">
                                <div class="numbers">
                                    <span class="amount">{{ getAmount($user->total_ref_com) }}</span>
                                    <span class="currency-sign">USD</span>
                                </div>
                                <div class="desciption">
                                    <span>@lang('Total Referral Commission')</span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-xl-4 col-lg-6 col-sm-6 mb-30">
                        <div class="dashboard-w1 bg--10 b-radius--10 box-shadow has--link">
                            <a href="{{ route('admin.report.binaryCom') }}?userID={{ $user->id }}"
                                class="item--link"></a>
                            <div class="icon">
                                <i class="la la-tree"></i>
                            </div>
                            <div class="details">
                                <div class="numbers">
                                    <span class="amount">{{ getAmount($user->total_binary_com) }}</span>
                                    <span class="currency-sign">USD</span>
                                </div>
                                <div class="desciption">
                                    <span>@lang('Total Binary Commission')</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-6 col-sm-6 mb-30">
                        <div class="dashboard-w1 bg--19 b-radius--10 box-shadow has--link">
                            <a href="{{ route('admin.report.single.pvLog', $user->id) }}?type=cutPV"
                                class="item--link"></a>
                            <div class="icon">
                                <i class="la la-cut"></i>
                            </div>
                            <div class="details">
                                <div class="numbers">
                                    <span class="amount">{{ getAmount($totalPvCut) }}</span>
                                </div>
                                <div class="desciption">
                                    <span>@lang('Total Cut PV')</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-sm-6 mb-30">
                        <div class="dashboard-w1 bg--15 b-radius--10 box-shadow has--link">
                            <a href="{{ route('admin.report.single.pvLog', $user->id) }}?type=leftPV"
                                class="item--link"></a>
                            <div class="icon">
                                <i class="las la-arrow-alt-circle-left"></i>
                            </div>
                            <div class="details">
                                <div class="numbers">
                                    <span class="amount">{{ getAmount($user->userExtra->pv_left) }}</span>
                                </div>
                                <div class="desciption">
                                    <span>@lang('Left PV')</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-sm-6 mb-30">
                        <div class="dashboard-w1 bg--12 b-radius--10 box-shadow has--link">
                            <a href="{{ route('admin.report.single.pvLog', $user->id) }}?type=rightPV"
                                class="item--link"></a>
                            <div class="icon">
                                <i class="las la-arrow-alt-circle-right"></i>
                            </div>
                            <div class="details">
                                <div class="numbers">
                                    <span class="amount">{{ getAmount($user->userExtra->pv_right) }}</span>
                                </div>
                                <div class="desciption">
                                    <span>@lang('Right PV')</span>
                                </div>
                            </div>
                        </div>
                    </div>




                </div>


                <div class="card mt-50">
                    <div class="card-body">
                        <h5 class="card-title mb-50 border-bottom pb-2">@lang('Information')</h5>

                        <form action="{{ route('admin.users.update', [$user->id]) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label class="form-control-label font-weight-bold">@lang('First Name')<span
                                                class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="firstname"
                                            value="{{ $user->firstname }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label  font-weight-bold">@lang('Last Name') <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="lastname"
                                            value="{{ $user->lastname }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label class="form-control-label font-weight-bold">@lang('Email') <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control" type="email" name="email"
                                            value="{{ $user->email }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label  font-weight-bold">@lang('Mobile Number') <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="phone"
                                            value="{{ $user->phone }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group ">
                                        <label class="form-control-label font-weight-bold">@lang('Username') <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="username"
                                            value="{{ $user->username }}">
                                    </div>
                                </div>

                            </div>


                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="form-group ">
                                        <label class="form-control-label font-weight-bold">@lang('Address') </label>
                                        <input class="form-control" type="text" name="address"
                                            value="{{ $user->address->address }}">
                                        <small class="form-text text-muted"><i class="las la-info-circle"></i>
                                            @lang('House number, street address')
                                        </small>
                                    </div>
                                </div>


                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group ">
                                        <label class="form-control-label font-weight-bold">@lang('State') </label>
                                        <input class="form-control" type="text" name="state"
                                            value="{{ $user->address->state }}">
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group ">
                                        <label class="form-control-label font-weight-bold">@lang('Country') </label>
                                        <select name="country" class="form-control"> @include('partials.country')
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="form-group col-xl-4 col-md-6  col-sm-3 col-12">
                                    <label class="form-control-label font-weight-bold">@lang('Status') </label>
                                    <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                        data-toggle="toggle" data-on="Active" data-off="Banned" data-width="100%"
                                        name="status" @if ($user->status) checked @endif>
                                </div>

                                <div class="form-group  col-xl-4 col-md-6  col-sm-3 col-12">
                                    <label class="form-control-label font-weight-bold">@lang('Email Verification') </label>
                                    <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                        data-toggle="toggle" data-on="Verified" data-off="Unverified" name="ev"
                                        @if ($user->ev) checked @endif>

                                </div>

                                <div class="form-group  col-xl-4 col-md-6  col-sm-3 col-12">
                                    <label class="form-control-label font-weight-bold">@lang('SMS Verification') </label>
                                    <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                        data-toggle="toggle" data-on="Verified" data-off="Unverified" name="sv"
                                        @if ($user->sv) checked @endif>

                                </div>
                                <div class="form-group  col-md-6  col-sm-3 col-12">
                                    <label class="form-control-label font-weight-bold">@lang('2FA Status') </label>
                                    <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                        data-toggle="toggle" data-on="Active" data-off="Deactive" name="ts"
                                        @if ($user->ts) checked @endif>
                                </div>

                                <div class="form-group  col-md-6  col-sm-3 col-12">
                                    <label class="form-control-label font-weight-bold">@lang('2FA Verification') </label>
                                    <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                        data-toggle="toggle" data-on="Verified" data-off="Unverified" name="tv"
                                        @if ($user->tv) checked @endif>
                                </div>
                            </div>


                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn--primary btn-block btn-lg">@lang('Save Changes')
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>


    {{-- Add Sub Balance MODAL --}}
    <div id="addSubModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Add / Subtract Balance')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.users.addSubBalance', $user->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <input type="checkbox" data-width="100%" data-height="44px" data-onstyle="-success"
                                    data-offstyle="-danger" data-toggle="toggle" data-on="Add Balance"
                                    data-off="Subtract Balance" name="act" checked>
                            </div>


                            <div class="form-group col-md-12">
                                <label>@lang('Amount')<span class="text-danger">*</span></label>
                                <div class="input-group has_append">
                                    <input type="text" name="amount" class="form-control"
                                        placeholder="Please provide positive amount">
                                    <div class="input-group-append">
                                        <div class="input-group-text">USD</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--success">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        'use strict';
        (function($) {
            $("select[name=country]").val("{{ @$user->address->country }}");
        })(jQuery)
    </script>
@endpush
