@extends($activeTemplate . 'user.layouts.app')

@section('title', 'Dashboard')

@push('css')
@endpush

@section('content')


    <!-- container -->
    <div class="container-fluid">

        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="left-content">
                <h3 class="content-title mb-2">Welcome back, {{ Auth::user()->full_name }}</h3>
                <h5 class="mb-0">
                    <span class="text-muted font-weight-bold">ID: {{ Auth::user()->user_id }}</span>
                </h5>
                <div class="d-flex">
                    <a href="/"><i class="mdi mdi-home text-muted hover-cursor"></i></a>
                    <p class="text-primary mb-0 hover-cursor">&nbsp;/&nbsp;Dashboard</p>
                </div>
            </div>
            <div class="d-flex align-items-end flex-wrap my-auto right-content breadcrumb-right">
                <button class="btn btn-primary mt-2 mt-xl-0">Current Rank<br>
                    <span class="badge badge-light">NIL</span>
                    {{-- <span class="badge badge-light">{{ auth()->user()->rank }}</span> --}}
                </button>
            </div>
        </div>
        <!-- /breadcrumb -->
        @php
            $total_earnings = getAmount(auth()->user()->total_ref_com) + getAmount(auth()->user()->total_binary_com);
            $available_balance = getAmount(auth()->user()->balance);
            $sponsorCom = getAmount(auth()->user()->total_ref_com);
            $binaryCom = getAmount(auth()->user()->total_binary_com);
            $totalLeft = getAmount(auth()->user()->userExtra->pv_left);
            $totalRight = getAmount(auth()->user()->userExtra->pv_right);
            $totalShiba = getAmount(auth()->user()->userExtra->shiba_left) + getAmount(auth()->user()->userExtra->shiba_right);
            $available_shiba = getAmount(auth()->user()->shibainu);
            $sponsor_shiba = getAmount(auth()->user()->total_ref_shiba);
            $binary_shiba = getAmount(auth()->user()->total_binary_shiba);
            $total_shiba_left = getAmount(auth()->user()->userExtra->shiba_left);
            $total_shiba_right = getAmount(auth()->user()->userExtra->shiba_right);
            // $user_roi = getAmount(auth()->user()->roi);
            // $total_roi = $roi;
            $weeklyRoi = $weeklyroi;
            
        @endphp

        {{-- ref + binary + total com + roi --}}
        <div class="row ">
            <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
                <div class="dashboard-w1 bg--success b-radius--10 box-shadow">
                    <div class="icon">
                        <i class="las la-money-bill"></i>
                    </div>
                    <div class="details">
                        <div class="desciption">
                            <span class="text--small">Total Earnings</span>
                        </div>
                        <div class="numbers">
                            <span class="amount">  {{ $totalWithdraw }}</span>
                            <span class="currency-sign">{{$general->cur_text}}</span>
                        </div>
                        <a href="{{ route('user.report.transactions') }}"
                            class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
                <div class="dashboard-w1 bg--success b-radius--10 box-shadow">
                    <div class="icon">
                        <i class="las la-money-bill"></i>
                    </div>
                    <div class="details">
                        <div class="desciption">
                            <span class="text--small">Available Balance</span>
                        </div>
                        <div class="numbers">
                            <span class="amount">{{ $available_balance }}</span>
                            <span class="currency-sign">{{$general->cur_text}}</span>
                        </div>
                        <a href="{{ route('user.report.transactions') }}"
                            class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6 mb-30 features">
                <div class="dashboard-w1 bg--5 b-radius--10 box-shadow">
                    <div class="icon">
                        <i class="las la-cloud-upload-alt"></i>
                    </div>
                    <div class="details">
                        <div class="desciption">
                            <span class="text--small">Sponsor Commission</span>
                        </div>
                        <div class="numbers">
                            <span class="amount">{{ $sponsorCom }}</span>
                            <span class="currency-sign">{{$general->cur_text}}</span>
                        </div>
                        <a href="{{ route('user.report.refCom') }}"
                            class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6 mb-30 features">
                <div class="dashboard-w1 bg--3 b-radius--10 box-shadow">
                    <div class="icon">
                        <i class="las la-cloud-upload-alt"></i>
                    </div>
                    <div class="details">
                        <div class="desciption">
                            <span class="text--small">Binary Commission</span>
                        </div>
                        <div class="numbers">
                            <span class="amount">{{ $binaryCom }}</span>
                            <span class="currency-sign">{{$general->cur_text}}</span>
                        </div>
                        <a href="{{ route('user.report.binaryCom') }}"
                            class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6 mb-30 features">
                <div class="dashboard-w1 bg--2 b-radius--10 box-shadow">
                    <div class="icon">
                        <i class="las la-hand-holding-usd"></i>
                    </div>
                    <div class="details">
                        <div class="desciption">
                            <span class="text--small">Total PV</span>
                        </div>
                        <div class="numbers">
                            <span
                                class="amount">{{ auth()->user()->userExtra->pv_left + auth()->user()->userExtra->pv_right }}</span>
                            {{-- <span class="currency-sign">{{$general->cur_text}}</span> --}}
                        </div>
                        <a href="{{ route('user.pv.log') }}?type=paidPV"
                            class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6 mb-30 features">
                <div class="dashboard-w1 bg--8 b-radius--10 box-shadow">
                    <div class="icon">
                        <i class="las la-hand-holding-usd"></i>
                    </div>
                    <div class="details">
                        <div class="desciption">
                            <span class="text--small">Total PV Left</span>
                        </div>
                        <div class="numbers">
                            <span class="amount">{{ $totalLeft }}</span>
                            {{-- <span class="currency-sign">{{$general->cur_text}}</span> --}}
                        </div>
                        <a href="{{ route('user.pv.log') }}?type=leftPV"
                            class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6 mb-30 features">
                <div class="dashboard-w1 bg--4 b-radius--10 box-shadow">
                    <div class="icon">
                        <i class="las la-hand-holding-usd"></i>
                    </div>
                    <div class="details">
                        <div class="desciption">
                            <span class="text--small">Total PV Right</span>
                        </div>
                        <div class="numbers">
                            <span class="amount">{{ $totalRight }}</span>
                            {{-- <span class="currency-sign">{{$general->cur_text}}</span> --}}
                        </div>
                        <a href="{{ route('user.pv.log') }}?type=rightPV"
                            class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6 mb-30 features">
                <div class="dashboard-w1 bg--warning b-radius--10 box-shadow">
                    <div class="icon">
                        <i class="las la-cloud-upload-alt"></i>
                    </div>
                    <div class="details">
                        <div class="desciption">
                            <span class="text--small">Total Invest PV</span>
                        </div>
                        <div class="numbers">
                            <span class="amount">{{ getAmount($total_invest_pv) }}</span>
                            {{-- <span class="currency-sign">{{$general->cur_text}}</span> --}}
                        </div>
                        <a href="{{ route('user.report.invest') }}"
                            class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6 mb-30 features">
                <div class="dashboard-w1 bg--warning b-radius--10 box-shadow">
                    <div class="icon">
                        <i class="las la-cloud-upload-alt"></i>
                    </div>
                    <div class="details">
                        <div class="desciption">
                            <span class="text--small">Total Shiba</span>
                        </div>
                        <div class="numbers">
                            <span class="amount">{{ $totalShiba }} SHIB</span>
                            {{-- <span class="currency-sign">{{$general->cur_text}}</span> --}}
                        </div>
                        <a href="{{ route('user.report.withdraw') }}"
                            class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>

                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6 mb-30 features">
                <div class="dashboard-w1 bg--3 b-radius--10 box-shadow">
                    <div class="icon">
                        <i class="las la-cloud-upload-alt"></i>
                    </div>
                    <div class="details">
                        <div class="desciption">
                            <span class="text--small">Available Shiba</span>
                        </div>
                        <div class="numbers">
                            <span class="amount">{{ $available_shiba }} SHIB</span>
                            {{-- <span class="currency-sign">{{$general->cur_text}}</span> --}}
                        </div>
                        <a href="{{ route('user.report.withdraw') }}"
                            class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>

                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6 mb-30 features">
                <div class="dashboard-w1 bg--info b-radius--10 box-shadow">
                    <div class="icon">
                        <i class="las la-cloud-upload-alt"></i>
                    </div>
                    <div class="details">
                        <div class="desciption">
                            <span class="text--small">Sponsor Bonus Shiba</span>
                        </div>
                        <div class="numbers">
                            <span class="amount">{{ $sponsor_shiba }} SHIB</span>
                            {{-- <span class="currency-sign">{{$general->cur_text}}</span> --}}
                        </div>
                        <a href="{{ route('user.report.withdraw') }}"
                            class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>

                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6 mb-30 features">
                <div class="dashboard-w1 bg--9 b-radius--10 box-shadow">
                    <div class="icon">
                        <i class="las la-cloud-upload-alt"></i>
                    </div>
                    <div class="details">
                        <div class="desciption">
                            <span class="text--small">Binary Bonus Shiba</span>
                        </div>
                        <div class="numbers">
                            <span class="amount">{{ $binary_shiba }} SHIB</span>
                            {{-- <span class="currency-sign">{{$general->cur_text}}</span> --}}
                        </div>
                        <a href="{{ route('user.report.withdraw') }}"
                            class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>

                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6 mb-30 features">
                <div class="dashboard-w1 bg--9 b-radius--10 box-shadow">
                    <div class="icon">
                        <i class="las la-cloud-upload-alt"></i>
                    </div>
                    <div class="details">
                        <div class="desciption">
                            <span class="text--small">Total Shiba Left</span>
                        </div>
                        <div class="numbers">
                            <span class="amount">{{ $total_shiba_left }} SHIB</span>
                            {{-- <span class="currency-sign">{{$general->cur_text}}</span> --}}
                        </div>
                        <a href="{{ route('user.report.withdraw') }}"
                            class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>

                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6 mb-30 features">
                <div class="dashboard-w1 bg--9 b-radius--10 box-shadow">
                    <div class="icon">
                        <i class="las la-cloud-upload-alt"></i>
                    </div>
                    <div class="details">
                        <div class="desciption">
                            <span class="text--small">Total Shiba Right</span>
                        </div>
                        <div class="numbers">
                            <span class="amount">{{ $total_shiba_right }} SHIB</span>
                            {{-- <span class="currency-sign">{{$general->cur_text}}</span> --}}
                        </div>
                        <a href="{{ route('user.report.withdraw') }}"
                            class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>

                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-sm-6 mb-30 features">
                <div class="dashboard-w1 bg--9 b-radius--10 box-shadow">
                    <div class="icon">
                        <i class="las la-cloud-upload-alt"></i>
                    </div>
                    <div class="details">
                        <div class="desciption">
                            <span class="text--small">Total ROI</span>
                        </div>
                        <div class="numbers">
                            <span class="amount">{{ getAmount($roi) }}</span>
                            <span class="currency-sign">{{ $general->cur_text }}</span>
                        </div>
                        <a href="{{ route('user.report.withdraw') }}"
                            class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>

                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-sm-6 mb-30 features">
                <div class="dashboard-w1 bg--9 b-radius--10 box-shadow">
                    <div class="icon">
                        <i class="las la-cloud-upload-alt"></i>
                    </div>
                    <div class="details">
                        <div class="desciption">
                            <span class="text--small">Weekly</span>
                        </div>
                        <div class="numbers">
                            <span class="amount">{{ getAmount($weeklyRoi) }}</span>
                            <span class="currency-sign">{{ $general->cur_text }}</span>
                        </div>
                        <a href="{{ route('user.report.withdraw') }}"
                            class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>

                    </div>
                </div>
            </div>







        </div>
        <!-- /row -->

    </div>
    <!-- /conatiner -->

@endsection
