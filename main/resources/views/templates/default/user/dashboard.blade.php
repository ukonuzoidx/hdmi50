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
                <div class="d-flex">
                    <a href="/"><i class="mdi mdi-home text-muted hover-cursor"></i></a>
                    <p class="text-primary mb-0 hover-cursor">&nbsp;/&nbsp;Dashboard</p>
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

        <div class="row ">
            <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
                <div class="dashboard-w1 bg--success b-radius--10 box-shadow">
                    <div class="icon">
                        <i class="las la-money-bill"></i>
                    </div>
                    <div class="details">
                        <div class="desciption">
                            <span class="text--small">Current Balance</span>
                        </div>
                        <div class="numbers">
                            <span class="amount">USD {{ getAmount(auth()->user()->balance) }}</span>
                            {{-- <span class="currency-sign">{{$general->cur_text}}</span> --}}
                        </div>
                        <a href="{{ route('user.report.transactions') }}"
                            class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
                <div class="dashboard-w1 bg--info b-radius--10 box-shadow">
                    <div class="icon">
                        <i class="fa fa-tree"></i>
                    </div>
                    <div class="details">
                        <div class="desciption">
                            <span class="text--small">Total Withdrawal</span>
                        </div>
                        <div class="numbers">
                            <span class="amount">{{ getAmount($totalWithdraw) }}</span>
                            {{-- <span class="currency-sign">{{$general->cur_text}}</span> --}}
                        </div>
                        <a href="{{ route('user.report.withdraw') }}"
                            class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                    </div>
                </div>

            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
                <div class="dashboard-w1 bg--10 b-radius--10 box-shadow">
                    <div class="icon">
                        <i class="las la-cloud-download-alt"></i>
                    </div>
                    <div class="details">
                        <div class="desciption">
                            <span class="text--small">Completed Withdrawal</span>
                        </div>
                        <div class="numbers">
                            <span class="amount">{{ getAmount($completeWithdraw) }}</span>
                            {{-- <span class="currency-sign">{{$general->cur_text}}</span> --}}
                        </div>
                        <a href="{{ route('user.report.withdraw') }}?type=complete"
                            class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                    </div>
                </div>

            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
                <div class="dashboard-w1 bg--10 b-radius--10 box-shadow">
                    <div class="icon">
                        <i class="las la-cloud-upload-alt"></i>
                    </div>
                    <div class="details">
                        <div class="desciption">
                            <span class="text--small">Pending Withdrawal</span>
                        </div>
                        <div class="numbers">
                            <span class="amount">{{ getAmount($pendingWithdraw) }}</span>
                            {{-- <span class="currency-sign">{{$general->cur_text}}</span> --}}
                        </div>
                        <a href="{{ route('user.report.withdraw') }}?type=pending"
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
                            <span class="text--small">Rejected Withdrawal</span>
                        </div>
                        <div class="numbers">
                            <span class="amount">{{ getAmount($rejectWithdraw) }}</span>
                            {{-- <span class="currency-sign">{{$general->cur_text}}</span> --}}
                        </div>
                        <a href="{{ route('user.report.withdraw') }}?type=reject"
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
                            <span class="text--small">Total Invested</span>
                        </div>
                        <div class="numbers">
                            <span class="amount">USD {{ getAmount(auth()->user()->total_invest) }}</span>
                            {{-- <span class="currency-sign">{{$general->cur_text}}</span> --}}
                        </div>
                        <a href="{{ route('user.report.invest') }}"
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
                            <span class="text--small">Total Referal Commission</span>
                        </div>
                        <div class="numbers">
                            <span class="amount">USD {{ getAmount(auth()->user()->total_ref_com) }}</span>
                            {{-- <span class="currency-sign">{{$general->cur_text}}</span> --}}
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
                            <span class="text--small">Total Binary Commission</span>
                        </div>
                        <div class="numbers">
                            <span class="amount">USD {{ getAmount(auth()->user()->total_binary_com) }}</span>
                            {{-- <span class="currency-sign">{{$general->cur_text}}</span> --}}
                        </div>
                        <a href="{{ route('user.report.binaryCom') }}"
                            class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6 mb-30 features">
                <div class="dashboard-w1 bg--11 b-radius--10 box-shadow">
                    <div class="icon">
                        <i class="las la-arrow-alt-circle-left"></i>
                    </div>
                    <div class="details">
                        <div class="desciption">
                            <span class="text--small">Total Referral</span>
                        </div>
                        <div class="numbers">
                            <span class="amount">{{ $total_ref }}</span>
                            {{-- <span class="currency-sign">{{$general->cur_text}}</span> --}}
                        </div>
                        <a href="{{ route('user.my.ref') }}"
                            class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-sm-6 mb-30 features">
                <div class="dashboard-w1 bg--5 b-radius--10 box-shadow">
                    <div class="icon">
                        <i class="las la-hand-holding-usd"></i>
                    </div>
                    <div class="details">
                        <div class="desciption">
                            <span class="text--small">Total Paid Left</span>
                        </div>
                        <div class="numbers">
                            <span class="amount">{{ auth()->user()->userExtra->paid_left }}</span>
                            {{-- <span class="currency-sign">{{$general->cur_text}}</span> --}}
                        </div>
                        <a href="{{ route('user.my.tree') }}"
                            class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6 mb-30 features">
                <div class="dashboard-w1 bg--5 b-radius--10 box-shadow">
                    <div class="icon">
                        <i class="las la-hand-holding-usd"></i>
                    </div>
                    <div class="details">
                        <div class="desciption">
                            <span class="text--small">Total Paid Right</span>
                        </div>
                        <div class="numbers">
                            <span class="amount">{{ auth()->user()->userExtra->paid_right }}</span>
                            {{-- <span class="currency-sign">{{$general->cur_text}}</span> --}}
                        </div>
                        <a href="{{ route('user.my.tree') }}"
                            class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6 mb-30 features">
                <div class="dashboard-w1 bg--5 b-radius--10 box-shadow">
                    <div class="icon">
                        <i class="las la-hand-holding-usd"></i>
                    </div>
                    <div class="details">
                        <div class="desciption">
                            <span class="text--small">Total Left</span>
                        </div>
                        <div class="numbers">
                            <span
                                class="amount">{{ auth()->user()->userExtra->free_left + auth()->user()->userExtra->paid_left }}</span>
                            {{-- <span class="currency-sign">{{$general->cur_text}}</span> --}}
                        </div>
                        <a href="{{ route('user.my.tree') }}"
                            class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6 mb-30 features">
                <div class="dashboard-w1 bg--5 b-radius--10 box-shadow">
                    <div class="icon">
                        <i class="las la-hand-holding-usd"></i>
                    </div>
                    <div class="details">
                        <div class="desciption">
                            <span class="text--small">Total Right</span>
                        </div>
                        <div class="numbers">
                            <span
                                class="amount">{{ auth()->user()->userExtra->free_right + auth()->user()->userExtra->paid_right }}</span>
                            {{-- <span class="currency-sign">{{$general->cur_text}}</span> --}}
                        </div>
                        <a href="{{ route('user.my.tree') }}"
                            class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">
                            @lang('View All')
                        </a>
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
                            <span class="text--small">PV Left</span>
                        </div>
                        <div class="numbers">
                            <span class="amount">{{ getAmount(auth()->user()->userExtra->pv_left) }}</span>
                            {{-- <span class="currency-sign">{{$general->cur_text}}</span> --}}
                        </div>
                        <a href="{{ route('user.pv.log') }}?type=leftPV"
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
                            <span class="text--small">PV Right</span>
                        </div>
                        <div class="numbers">
                            <span class="amount">{{ getAmount(auth()->user()->userExtra->pv_right) }}</span>
                            {{-- <span class="currency-sign">{{$general->cur_text}}</span> --}}
                        </div>
                        <a href="{{ route('user.pv.log') }}?type=rightPV"
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
                            <span class="text--small">Total PVCut</span>
                        </div>
                        <div class="numbers">
                            <span class="amount">{{ getAmount($totalPvCut) }}</span>
                            {{-- <span class="currency-sign">{{$general->cur_text}}</span> --}}
                        </div>
                        <a href="{{ route('user.pv.log') }}?type=cutPV"
                            class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                    </div>
                </div>
            </div>







        </div>
        <!-- /row -->

    </div>
    <!-- /conatiner -->

@endsection
