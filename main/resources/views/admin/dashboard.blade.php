@extends('admin.layouts.app')

@section('title', 'Dashboard')

@push('css')
    {{-- <link rel="stylesheet" href="{{ asset('assets/admin/css/apps.css') }}" /> --}}
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous"> --}}
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
                    <p class="text-primary mb-0 hover-cursor">&nbsp;/&nbsp;Dashboard</p>
                </div>
            </div>
            <a href="javascript:void(0)"
                class="mb-4 btn @if (Carbon\Carbon::parse($general->last_cron)->diffInSeconds() < 600) btn--success @elseif(Carbon\Carbon::parse($general->last_cron)->diffInSeconds() < 1200) btn--warning @else
        btn--danger @endif ">
                <i class="fa fa-fw fa-clock"></i>
                @lang('Last Cron Run') : {{ Carbon\Carbon::parse($general->last_cron)->difFforHumans() }}
            </a>
        </div>
        <!-- /breadcrumb -->

        <div class="row">
            <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
                <div class="dashboard-w1 bg--primary b-radius--10 box-shadow">
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <div class="details">
                        <div class="numbers">
                            <span class="amount">{{ $widget['total_users'] }}</span>
                        </div>
                        <div class="desciption">
                            <span class="text--small">@lang('Total Users')</span>
                        </div>
                        <a href="{{ route('admin.users.all') }}"
                            class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
                <div class="dashboard-w1 bg--success b-radius--10 box-shadow">
                    <div class="icon">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <div class="details">
                        <div class="numbers">
                            <span class="currency-sign">{{ $general->cur_sym }}</span>
                            <span class="amount">{{ getAmount($widget['users_balance']) }}</span>
                        </div>
                        <div class="desciption">
                            <span class="text--small">@lang('Users Balance')</span>
                        </div>
                        <a href="{{ route('admin.report.transaction') }}"
                            class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                    </div>
                </div>
            </div>


            <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
                <div class="dashboard-w1 bg--teal b-radius--10 box-shadow">
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <div class="details">
                        <div class="numbers">
                            <span class="amount">{{ $widget['verified_users'] }}</span>
                        </div>
                        <div class="desciption">
                            <span class="text--small">@lang('Total Verified Users')</span>
                        </div>
                        <a href="{{ route('admin.users.active') }}"
                            class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
                <div class="dashboard-w1 bg--red b-radius--10 box-shadow">
                    <div class="icon">
                        <i class="fa fa-ban"></i>
                    </div>
                    <div class="details">
                        <div class="numbers">
                            <span class="amount">{{ $widget['banned_users'] }}</span>
                        </div>
                        <div class="desciption">
                            <span class="text--small">@lang('Banned Users')</span>
                        </div>
                        <a href="{{ route('admin.users.banned') }}"
                            class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                    </div>
                </div>
            </div>


            <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
                <div class="dashboard-w1 bg--indigo b-radius--10 box-shadow ">
                    <div class="icon">
                        <i class="la la-envelope"></i>
                    </div>
                    <div class="details">
                        <div class="numbers">
                            <span class="amount">{{ $widget['email_verified_users'] }}</span>
                        </div>
                        <div class="desciption">
                            <span class="text--small">@lang('Total Email Verified')</span>
                        </div>
                        <a href="{{ route('admin.users.emailVerified') }}"
                            class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
                <div class="dashboard-w1 bg--danger b-radius--10 box-shadow">
                    <div class="icon">
                        <i class="fa fa-envelope"></i>
                    </div>
                    <div class="details">
                        <div class="numbers">
                            <span class="amount">{{ $widget['emailUnverified'] }}</span>
                        </div>
                        <div class="desciption">
                            <span class="text--small">@lang('Total Email Unverified')</span>
                        </div>
                        <a href="{{ route('admin.users.emailUnverified') }}"
                            class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
                <div class="dashboard-w1 bg--primary b-radius--10 box-shadow ">
                    <div class="icon">
                        <i class="fa fa-phone"></i>
                    </div>
                    <div class="details">
                        <div class="numbers">
                            <span class="amount">{{ $widget['sms_verified_users'] }}</span>
                        </div>
                        <div class="desciption">
                            <span class="text--small">@lang('Total SMS Verified')</span>
                        </div>
                        <a href="{{ route('admin.users.smsVerified') }}"
                            class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
                <div class="dashboard-w1 bg--pink b-radius--10 box-shadow">
                    <div class="icon">
                        <i class="fa fa-window-close"></i>
                    </div>
                    <div class="details">
                        <div class="numbers">
                            <span class="amount">{{ $widget['smsUnverified'] }}</span>
                        </div>
                        <div class="desciption">
                            <span class="text--small">@lang('Total SMS Unverified')</span>
                        </div>
                        <a href="{{ route('admin.users.smsUnverified') }}"
                            class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                    </div>
                </div>
            </div>


            <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
                <div class="dashboard-w1 bg--cyan b-radius--10 box-shadow">
                    <div class="icon">
                        <i class="fa fa-money-bill-wave-alt"></i>
                    </div>
                    <div class="details">
                        <div class="numbers">
                            <span class="currency-sign">{{ $general->cur_sym }}</span>
                            <span class="amount">{{ getAmount($widget['users_invest']) }}</span>
                        </div>
                        <div class="desciption">
                            <span class="text--small">@lang('Total Invest')</span>
                        </div>
                        <a href="{{ route('admin.report.invest') }}"
                            class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
                <div class="dashboard-w1 bg--info b-radius--10 box-shadow">
                    <div class="icon">
                        <i class="fa fa-money-bill-wave-alt"></i>
                    </div>
                    <div class="details">
                        <div class="numbers">
                            <span class="currency-sign">{{ $general->cur_sym }}</span>
                            <span class="amount">{{ getAmount($widget['last7days_invest']) }}</span>
                        </div>
                        <div class="desciption">
                            <span class="text--small">@lang('Last 7 Days Invest')</span>
                        </div>
                        <a href="#0"
                            class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                    </div>
                </div>
            </div>


            <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
                <div class="dashboard-w1 bg--3 b-radius--10 box-shadow">
                    <div class="icon">
                        <i class="las la-hand-holding-usd"></i>
                    </div>
                    <div class="details">
                        <div class="numbers">
                            <span class="currency-sign">{{ $general->cur_sym }}</span>
                            <span class="amount">{{ getAmount($widget['total_ref_com']) }}</span>
                        </div>
                        <div class="desciption">
                            <span class="text--small">@lang('Total Referral Commission')</span>
                        </div>
                        <a href="{{ route('admin.report.refCom') }}"
                            class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
                <div class="dashboard-w1 bg--17 b-radius--10 box-shadow">
                    <div class="icon">
                        <i class="las la-tree"></i>
                    </div>
                    <div class="details">
                        <div class="numbers">
                            <span class="currency-sign">{{ $general->cur_sym }}</span>
                            <span class="amount">{{ getAmount($widget['total_binary_com']) }}</span>

                        </div>
                        <div class="desciption">
                            <span class="text--small">@lang('Total Binary Commission')</span>
                        </div>
                        <a href="{{ route('admin.report.binaryCom') }}"
                            class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
                <div class="dashboard-w1 bg--deep-purple b-radius--10 box-shadow">
                    <div class="icon">
                        <i class="las la-cut"></i>
                    </div>
                    <div class="details">
                        <div class="numbers">
                            <span class="amount">{{ getAmount($pv['totalPvCut']) }}</span>
                        </div>
                        <div class="desciption">
                            <span class="text--small">@lang('Users Total Pv Cut')</span>
                        </div>
                        <a href="{{ route('admin.report.pvLog') }}?type=cutpv"
                            class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
                <div class="dashboard-w1 bg--15 b-radius--10 box-shadow">
                    <div class="icon">
                        <i class="las la-cart-arrow-down"></i>
                    </div>
                    <div class="details">
                        <div class="numbers">
                            <span class="amount">{{ getAmount($pv['pvLeft'] + $pv['pvRight']) }}</span>
                        </div>
                        <div class="desciption">
                            <span class="text--small">@lang('Users Total pv')</span>
                        </div>
                        <a href="{{ route('admin.report.pvLog') }}?type=paidpv"
                            class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                    </div>
                </div>
            </div>


            <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
                <div class="dashboard-w1 bg--10 b-radius--10 box-shadow">
                    <div class="icon">
                        <i class="las la-arrow-alt-circle-left"></i>
                    </div>
                    <div class="details">
                        <div class="numbers">
                            <span class="amount">{{ getAmount($pv['pvLeft']) }}</span>
                        </div>
                        <div class="desciption">
                            <span class="text--small">@lang('Users Left Pv')</span>
                        </div>
                        <a href="{{ route('admin.report.pvLog') }}?type=leftpv"
                            class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
                <div class="dashboard-w1 bg--3 b-radius--10 box-shadow">
                    <div class="icon">
                        <i class="las la-arrow-alt-circle-right"></i>
                    </div>
                    <div class="details">
                        <div class="numbers">
                            <span class="amount">{{ getAmount($pv['pvRight']) }}</span>
                        </div>
                        <div class="desciption">
                            <span class="text--small">@lang('Users Right Pv')</span>
                        </div>
                        <a href="{{ route('admin.report.pvLog') }}?type=rightpv"
                            class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                    </div>
                </div>
            </div>
        </div>
    {{-- <div class="row mt-50 mb-none-30">
            <div class="col-xl-12 mb-30">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">@lang('Monthly  Deposit & Withdraw  Report')</h5>
                        <div id="apex-bar-chart"></div>
                    </div>
                </div>
            </div>  --}}
    {{-- <div class="col-xl-6 mb-30">
                <div class="row mb-none-30">
                    <div class="col-lg-6 col-sm-6 mb-30">
                        <div class="widget-three box--shadow2 b-radius--5 bg--white">
                            <div class="widget-three__icon b-radius--rounded bg--success  box--shadow2">
                                <i class="las la-money-bill "></i>
                            </div>
                            <div class="widget-three__content">
                                {{-- <h2 class="numbers">{{getAmount($payment['total_deposit_amount'])}} {{$general->cur_text}}</h2> 
                                <p class="text--small">@lang('Total Deposit')</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 mb-30">
                        <div class="widget-three box--shadow2 b-radius--5 bg--white">
                            <div class="widget-three__icon b-radius--rounded bg--teal box--shadow2">
                                <i class="las la-money-check"></i>
                            </div>
                            <div class="widget-three__content">
                                {{-- <h2 class="numbers">{{getAmount($payment['total_deposit_charge'])}} {{$general->cur_text}}</h2> 
                                <p class="text--small">@lang('Total Deposit Charge')</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-6 mb-30">
                        <div class="widget-three box--shadow2 b-radius--5 bg--white">
                            <div class="widget-three__icon b-radius--rounded bg--warning  box--shadow2">
                                <i class="las la-spinner"></i>
                            </div>
                            <div class="widget-three__content">
                                {{-- <h2 class="numbers">{{$payment['total_deposit_pending']}}</h2> -
                                <p class="text--small">@lang('Pending Deposit')</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 mb-30">
                        <div class="widget-three box--shadow2 b-radius--5 bg--white">
                            <div class="widget-three__icon b-radius--rounded bg--danger box--shadow2">
                                <i class="las la-ban "></i>
                            </div>
                            <div class="widget-three__content">
                                {{-- <h2 class="numbers">{{$payment['total_deposit_reject']}}</h2> --
                                <p class="text--small">@lang('Reject Deposit')</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
    {{-- </div><!-- row end --> --}}


    <div class="row mt-50 mb-none-30">
        <div class="col-xl-3 col-lg-6 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--15 b-radius--10 box-shadow">
                <div class="icon">
                    <i class="fa fa-wallet"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{ $paymentWithdraw['withdraw_method'] }}</span>
                    </div>
                    <div class="desciption">
                        <span>@lang('Withdraw Method')</span>
                    </div>
                    {{-- <a href="{{route('admin.withdraw.method.index')}}"
                       class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a> --}}
                </div>
            </div>
        </div>


        <div class="col-xl-3 col-lg-6 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--success b-radius--10 box-shadow">
                <div class="icon">
                    <i class="fa fa-hand-holding-usd"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{ getAmount($paymentWithdraw['total_withdraw_amount']) }}</span>
                        <span class="currency-sign">USD</span>
                    </div>
                    <div class="desciption">
                        <span>@lang('Total Withdraw')</span>
                    </div>
                    {{-- <a href="{{route('admin.withdraw.approved')}}"
                       class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a> --}}
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--danger b-radius--10 box-shadow">
                <div class="icon">
                    <i class="fa fa-money-bill-alt"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{ getAmount($paymentWithdraw['total_withdraw_charge']) }}
                        </span>
                        <span class="currency-sign">USD</span>
                    </div>
                    <div class="desciption">
                        <span>@lang('Total Withdraw Charge')</span>
                    </div>

                    {{-- <a href="{{route('admin.withdraw.approved')}}"
                       class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a> --}}
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--warning b-radius--10 box-shadow">
                <div class="icon">
                    <i class="fa fa-spinner"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{ $paymentWithdraw['total_withdraw_pending'] }}</span>
                    </div>
                    <div class="desciption">
                        <span>@lang('Withdraw Pending')</span>
                    </div>

                    {{-- <a href="{{route('admin.withdraw.pending')}}"
                       class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a> --}}
                </div>
            </div>
        </div>
    </div>


    <div class="row mb-none-30 mt-5">

        <div class="col-xl-6 mb-30">
            <div class="card ">
                <div class="card-header">
                    <h6 class="card-title mb-0">@lang('New User list')</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th scope="col">@lang('User')</th>
                                    <th scope="col">@lang('Username')</th>
                                    <th scope="col">@lang('Email')</th>
                                    <th scope="col">@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestUser as $user)
                                    <tr>
                                        <td data-label="@lang('User')">
                                            <div class="user">
                                                <div class="thumb"><img
                                                        src="{{ getImage('assets/images/user/profile/' . $user->image, '350x300') }}"
                                                        alt="@lang('image')"></div>
                                                <span class="name">{{ $user->fullname }}</span>
                                            </div>
                                        </td>
                                        <td data-label="@lang('Username')">
                                            {{-- <a
                                            href="{{ route('admin.users.detail', $user->id) }}">{{ $user->username }}</a> --}}
                                            <a href="#">{{ $user->username }}</a>
                                        </td>
                                        <td data-label="@lang('Email')">{{ $user->email }}</td>
                                        <td data-label="@lang('Action')">
                                            {{-- <a href="{{ route('admin.users.detail', $user->id) }}" class="icon-btn"
                                           data-toggle="tooltip" title="@lang('Details')">
                                            <i class="las la-desktop text--shadow"></i>
                                        </a> --}}
                                            <a href="#" class="icon-btn" data-toggle="tooltip"
                                                title="@lang('Details')">
                                                <i class="las la-desktop text--shadow"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">@lang('User Not Found')</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
            </div><!-- card end -->
        </div>

        <div class="col-xl-6 mb-30">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">@lang('Last 30 days Withdraw History')</h5>
                    <div id="withdraw-line"></div>
                </div>
            </div>s
        </div>
    </div>
    </div>
    @include('admin.partials.matchingBonusModal')

@endsection



@push('scripts')
    <script src="{{ asset('assets/admin/js/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/admin/js/chart.js.2.8.0.js') }}"></script>

    <script>
        'use strict';
        // apex-bar-chart js
        var options = {
            series: [{
                name: 'Total Deposit',
                data: [
                    @foreach ($report['months'] as $month)
                        {{ getAmount(@$depositsMonth->where('months', $month)->first()->depositAmount) }},
                    @endforeach
                ]
            }, {
                name: 'Total Withdraw',
                data: [
                    @foreach ($report['months'] as $month)
                        {{ getAmount(@$withdrawalMonth->where('months', $month)->first()->withdrawAmount) }},
                    @endforeach
                ]
            }],
            chart: {
                type: 'bar',
                height: 400,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '50%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: true
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: @json($report['months']->flatten()),
            },
            yaxis: {
                title: {
                    text: "$",
                    style: {
                        color: '#7c97bb'
                    }
                }
            },
            grid: {
                xaxis: {
                    lines: {
                        show: false
                    }
                },
                yaxis: {
                    lines: {
                        show: false
                    }
                },
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return "$" + val + " "
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#apex-bar-chart"), options);
        chart.render();

        // apex-line chart
        var options = {
            chart: {
                height: 430,
                type: "area",
                toolbar: {
                    show: false
                },
                dropShadow: {
                    enabled: true,
                    enabledSeries: [0],
                    top: -2,
                    left: 0,
                    blur: 10,
                    opacity: 0.08
                },
                animations: {
                    enabled: true,
                    easing: 'linear',
                    dynamicAnimation: {
                        speed: 1000
                    }
                },
            },
            dataLabels: {
                enabled: false
            },
            series: [{
                name: "Series 1",
                data: @json($withdrawals['per_day_amount']->flatten())
            }],
            fill: {
                type: "gradient",
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.9,
                    stops: [0, 90, 100]
                }
            },
            xaxis: {
                categories: @json($withdrawals['per_day']->flatten())
            },
            grid: {
                padding: {
                    left: 5,
                    right: 5
                },
                xaxis: {
                    lines: {
                        show: false
                    }
                },
                yaxis: {
                    lines: {
                        show: false
                    }
                },
            },
        };

        var chart = new ApexCharts(document.querySelector("#withdraw-line"), options);

        chart.render();
    </script>
@endpush
