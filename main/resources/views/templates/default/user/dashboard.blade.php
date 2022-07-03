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
                <h6>GIB: 100000SHIB</h6>
                <div class="d-flex">
                    <a href="/"><i class="mdi mdi-home text-muted hover-cursor"></i></a>
                    <p class="text-primary mb-0 hover-cursor">&nbsp;/&nbsp;Dashboard</p>
                </div>
            </div>
            {{-- <div class="flex-w cd100 p-t-15 p-b-15 p-r-36">

                <div class="flex-w flex-b m-r-22 m-t-8 m-b-8">
                    <span class="l1-txt1 wsize1 hours">0</span>
                    <span class="m1-txt1 p-b-2">Hrs</span>
                </div>

                <div class="flex-w flex-b m-r-22 m-t-8 m-b-8">
                    <span class="l1-txt1 wsize1 minutes">0</span>
                    <span class="m1-txt1 p-b-2">Mins</span>
                </div>

                <div class="flex-w flex-b m-r-22 m-t-8 m-b-8">
                    <span class="l1-txt1 wsize1 seconds">0</span>
                    <span class="m1-txt1 p-b-2">Secs</span>
                </div>
            </div> --}}



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
                            <span class="amount"> {{ getAmount($totalWithdraw) }}</span>
                            <span class="currency-sign">{{ $general->cur_text }}</span>
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
                            <span class="currency-sign">{{ $general->cur_text }}</span>
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
                            <span class="currency-sign">{{ $general->cur_text }}</span>
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
                            <span class="currency-sign">{{ $general->cur_text }}</span>
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
                            <span class="amount">{{ getAmount(auth()->user()->total_invest) }}</span>
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
                            <span class="text--small">Total Claimed Shiba</span>
                        </div>
                        <div class="numbers">
                            <span class="amount">{{ getAmount($totalWithdrawShiba) }} SHIB</span>
                            {{-- <span class="currency-sign">{{$general->cur_text}}</span> --}}
                        </div>
                        <a href="{{ route('user.report.transactions') }}"
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
                        <a href="#withdrawShiba" data-toggle="modal"
                            class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('Claim Shiba')</a>

                        {{-- withdrawal modal --}}


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
                <div class="dashboard-w1 bg--2 b-radius--10 box-shadow">
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
                <div class="dashboard-w1 bg--1 b-radius--10 box-shadow">
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
                        <form action="{{ route('user.claim.roi') }}" method="POST">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                            <button type="submit"
                                class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('Claim')</button>
                        </form>

                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-sm-6 mb-30 features">
                <div class="dashboard-w1 bg--8 b-radius--10 box-shadow">
                    <div class="icon">
                        <i class="las la-cloud-upload-alt"></i>
                    </div>
                    <div class="details">
                        <div class="desciption">
                            <span class="text--small">Weekly ROI</span>
                        </div>
                        <div class="numbers">
                            <span class="amount">{{ getAmount($weeklyRoi) }}</span>
                            <span class="currency-sign">{{ $general->cur_text }}</span>
                        </div>
                        <a href="{{ route('user.report.withdraw') }}"
                            class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('Claim')</a>

                    </div>
                </div>
            </div>



            <div class="modal fade" id="withdrawShiba" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel"> @lang('Confirm Withdraw ' . auth()->user()->fullname)?</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">×</span></button>
                        </div>
                        <form method="post" action="{{ route('user.withdraw.shiba.money') }}">
                            <div class="modal-body">

                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}" />

                                @csrf
                                <input type="text" name="shibainu" class="form-control mb-4"
                                    placeholder="@lang('Enter Anount of Shiba you want to withdraw')" />
                                <input type="text" name="pin" class="form-control"
                                    placeholder="@lang('Enter your Transaction pin')" required />
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn--danger" data-dismiss="modal"><i
                                        class="fa fa-times"></i> @lang('Close')</button>

                                <button type="submit" name="user_id" value="{{ auth()->user()->id }}"
                                    class="btn btn--success"><i class="lab la-telegram-plane"></i>
                                    @lang('Claim')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>




        </div>
        <!-- /row -->

        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mg-b-0">Fixed Investments</h4>
                            <i class="mdi mdi-dots-horizontal text-gray"></i>
                        </div>
                        {{-- <p class="tx-12 tx-gray-500 mb-2">Example ofXino Simple Table. <a href="">Learn more</a></p> --}}
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table text-md-nowrap" id="example1">
                                <thead>
                                    <tr>
                                        <th class="wd-20p border-bottom-0">Name</th>
                                        <th class="wd-15p border-bottom-0">Plan Name</th>
                                        <th class="wd-15p border-bottom-0">Claim Daily</th>
                                        <th class="wd-15p border-bottom-0">Total Claimed</th>
                                        <th class="wd-10p border-bottom-0">Withdraw</th>
                                        <th class="wd-10p border-bottom-0">Time to be withdraw</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($investments as $key=>$data)
                                        <tr>
                                            <td>
                                                {{ $data->user->fullname }}
                                            </td>
                                            <td>{{ $data->investment->name }}</td>
                                            <td>
                                                <form action="{{ route('user.claim.fixed.roi') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                                                    <button type="submit"
                                                        class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('Claim')</button>
                                                </form>
                                            </td>
                                            <td>{{ $data->investment->fixed_roi }}</td>
                                            {{-- countdown for date to be claimed --}}
                                            <td>
                                                <form action="{{ route('user.withdraw.fixed.roi') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                                                    <button type="submit"
                                                        class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('Withdraw')</button>
                                                </form>
                                            </td>

                                            <td>
                                                <div id="clockdiv" class="d-flex">
                                                    <span class="days"></span>
                                                </div>
                                                <div id="end_time" style="display: none;">{{ $data->roi_last_paid }}
                                                </div>
                                            </td>







                                        </tr>

                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">
                                                {{ $empty_message }}
                                            </td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--/div-->
        </div>
        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mg-b-0">Digitial Products</h4>
                            <i class="mdi mdi-dots-horizontal text-gray"></i>
                        </div>
                        {{-- <p class="tx-12 tx-gray-500 mb-2">Example ofXino Simple Table. <a href="">Learn more</a></p> --}}
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table text-md-nowrap" id="example1">
                                <thead>
                                    <tr>
                                        <th class="wd-20p border-bottom-0">Name</th>
                                        <th class="wd-15p border-bottom-0">Plan Name</th>
                                        <th class="wd-15p border-bottom-0">Claim</th>
                                        <th class="wd-15p border-bottom-0">Total Claim</th>
                                        <th class="wd-10p border-bottom-0">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($digital_assets as $key=>$data)
                                        <tr>
                                            <td>
                                                {{ $data->user->full_name }}
                                            </td>
                                            <td>{{ $data->plan->name }}</td>
                                            <td>{{ $data->claim }}</td>
                                            <td>{{ $data->total_claim }}</td>

                                            <td>
                                                @if ($data->total_claim != $data->plan->claim)
                                                    <form action="{{ route('user.digital.claim') }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="digital_id"
                                                            value="{{ $data->id }}" />
                                                        <button type="submit"
                                                            class="btn btn-sm btn-primary">@lang('Claim')</button>
                                                    </form>
                                                @else
                                                    <span class="badge badge-success">@lang('Already Claimed')</span>
                                                @endif
                                            </td>





                                        </tr>

                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">
                                                {{ $empty_message }}
                                            </td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--/div-->
        </div>


    </div>
    <!-- /conatiner -->

@endsection


@push('scripts')
    <script>
        $(document).ready(function() {

            function getTimeRemaining(endtime) {
                var t = endtime - new Date().getTime();
                var days = Math.floor(t / (1000 * 60 * 60 * 24));
                return {
                    'total': t,
                    'days': days,
                };
            }

            function initializeClock(id, endtime) {
                var clock = document.getElementById(id);
                var daysSpan = clock.querySelector('.days');

                function updateClock() {
                    var t = getTimeRemaining(endtime);

                    daysSpan.innerHTML = t.days + ' Days left!';

                    if (t.total <= 0) {
                        clearInterval(timeinterval);
                    }
                }

                updateClock();
                var timeinterval = setInterval(updateClock, 1000);
            }

            // end time for countdown
            var deadline = new Date(document.getElementById('end_time').innerHTML);

            initializeClock('clockdiv', deadline);


        });
    </script>
@endpush
