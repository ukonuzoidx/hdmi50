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
                            <span class="amount"> {{ $totalWithdraw }}</span>
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

@push('scripts')
    <script src="{{ asset('assets/global/js/moment.js') }}"></script>
    <script src="{{ asset('assets/global/js/moment-timezone.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/moment-timezone-with-data.js') }}"></script>
    <script src="{{ asset('assets/global/js/countdowntime.js') }}"></script>
    @if (Carbon\Carbon::parse(auth()->user()->roi_last_paid)->diffInSeconds() <= 86400)
        <script>
            $(document).ready(function() {
                // get difference between last paid and the next day





                

                $('.cd100').countdown100({
                    /*Set Endtime here*/
                    /*Endtime must be > current time*/
                    endtimeYear: 0,
                    endtimeMonth: 0,
                    endtimeHours: 19,
                    endtimeMinutes: 0,
                    endtimeSeconds: 0,
                    timeZone: ""
                    // ex:  timeZone: "America/New_York"
                    //go to " http://momentjs.com/timezone/ " to get timezone
                });
            });
        </script>
    @endif
@endpush

@push('css')
    <style>
        /*------------------------------------------------------------------
        Project:  ComingSoon
        Version:
        Last change:
        Assigned to:  Bach Le
        Primary use:
        -------------------------------------------------------------------*/



        /*//////////////////////////////////////////////////////////////////
        [ FONT ]*/

        @font-face {
            font-family: Montserrat-Regular;
            src: url('../fonts/Montserrat/Montserrat-Regular.ttf');
        }

        @font-face {
            font-family: Montserrat-SemiBold;
            src: url('../fonts/Montserrat/Montserrat-SemiBold.ttf');
        }

        @font-face {
            font-family: Playlist Script;
            src: url('../fonts/Playlist/Playlist Script.otf');
        }



        /*//////////////////////////////////////////////////////////////////
        [ RS PLUGIN ]*/
        /*---------------------------------------------*/
        .container {
            max-width: 1200px;
        }


        /*//////////////////////////////////////////////////////////////////
        [ Form ]*/
        .contact100-form {
            max-width: 100%;
        }

        /*------------------------------------------------------------------
        [ Input ]*/

        .wrap-input100 {
            width: 280px;
            max-width: 100%;
            position: relative;
            background-color: transparent;
            height: 50px;
        }

        /*---------------------------------------------*/
        .input100 {
            display: block;
            width: 100%;
            height: 100%;
            padding: 0 40px 0 3px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background-color: rgba(255, 255, 255, 0.0);
        }

        .input100:focus {
            background-color: rgba(255, 255, 255, 0.05);
        }


        /*------------------------------------------------------------------
        [ Alert validate ]*/

        .validate-input {
            position: relative;
        }

        .alert-validate::before {
            content: attr(data-validate);
            position: absolute;
            max-width: 70%;
            background-color: #fff;
            border: 1px solid #c80000;
            border-radius: 0px;
            padding: 4px 25px 4px 10px;
            top: 50%;
            -webkit-transform: translateY(-50%);
            -moz-transform: translateY(-50%);
            -ms-transform: translateY(-50%);
            -o-transform: translateY(-50%);
            transform: translateY(-50%);
            right: 32px;
            pointer-events: none;

            font-family: Montserrat-Regular;
            color: #c80000;
            font-size: 14px;
            line-height: 1.4;
            text-align: left;

            visibility: hidden;
            opacity: 0;

            -webkit-transition: opacity 0.4s;
            -o-transition: opacity 0.4s;
            -moz-transition: opacity 0.4s;
            transition: opacity 0.4s;
        }

        .alert-validate::after {
            content: "\f071";
            font-family: FontAwesome;
            display: block;
            position: absolute;
            color: #c80000;
            font-size: 14px;
            top: 50%;
            -webkit-transform: translateY(-50%);
            -moz-transform: translateY(-50%);
            -ms-transform: translateY(-50%);
            -o-transform: translateY(-50%);
            transform: translateY(-50%);
            right: 38px;
        }

        .alert-validate:hover:before {
            visibility: visible;
            opacity: 1;
        }

        @media (max-width: 992px) {
            .alert-validate::before {
                visibility: visible;
                opacity: 1;
            }
        }


        /*//////////////////////////////////////////////////////////////////
        [ Simple slide100 ]*/
        .simpleslide100 {
            display: block;
            position: fixed;
            z-index: 0;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background-color: #000;
        }

        .simpleslide100-item {
            display: block;
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
        }



        /*==================================================================
            TEXT TEXT TEXT TEXT TEXT TEXT TEXT TEXT TEXT TEXT TEXT TEXT TEXT
        ==================================================================*/

        /*==================================================================
        [ Color ]*/
        .cl0 {
            color: #fff;
        }

        .cl1 {
            color: #999;
        }




        /*//////////////////////////////////////////////////////////////////
        [ S-Text 0 - 15 ]*/
        .s1-txt1 {
            font-family: Montserrat-SemiBold;
            font-size: 14px;
            color: #fff;
            line-height: 1.2;
            text-transform: uppercase;
        }



        /*//////////////////////////////////////////////////////////////////
        [ M-Text 16 - 25 ]*/
        .m1-txt1 {
            font-family: Montserrat-Regular;
            font-size: 18px;
            color: #fff;
            line-height: 1;
        }



        /*//////////////////////////////////////////////////////////////////
        [ L-Text >= 26 ]*/
        .l1-txt1 {
            font-family: Montserrat-Regular;
            font-size: 30px;
            color: #fff;
            line-height: 1;
        }

        .l1-txt2 {
            font-family: Playlist Script;
            font-size: 180px;
            color: #fff;
            line-height: 1.1;
        }


        /*==================================================================
           SHAPE SHAPE SHAPE SHAPE SHAPE SHAPE SHAPE SHAPE SHAPE SHAPE SHAPE
        ==================================================================*/
        /*//////////////////////////////////////////////////////////////////
        [ Size ]*/
        .size1 {
            width: 100%;
            min-height: 100vh;
        }

        .size2 {
            min-width: 140px;
            height: 50px;
        }

        .size3 {
            width: 36px;
            height: 36px;
        }

        .size4 {
            width: 35px;
            height: 100%;
        }


        /*//////////////////////////////////////////////////////////////////
        [ Width ]*/
        .wsize1 {
            min-width: 46px;
        }

        /*//////////////////////////////////////////////////////////////////
        [ Height ]*/




        /*//////////////////////////////////////////////////////////////////
        [ Background ]*/
        .bg0 {
            background-color: #fff;
        }

        .bg-img1 {
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }




        /*//////////////////////////////////////////////////////////////////
        [ Border ]*/





        /*==================================================================
           WHERE WHERE WHERE WHERE WHERE WHERE WHERE WHERE WHERE WHERE WHERE
        ==================================================================*/
        .where1 {
            align-self: flex-start;
        }



        /*==================================================================
         HOW HOW HOW HOW HOW HOW HOW HOW HOW HOW HOW HOW HOW HOW HOW HOW HOW
        ==================================================================*/
        .placeholder0::-webkit-input-placeholder {
            color: #999999;
        }

        .placeholder0:-moz-placeholder {
            color: #999999;
        }

        .placeholder0::-moz-placeholder {
            color: #999999;
        }

        .placeholder0:-ms-input-placeholder {
            color: #999999;
        }


        /*---------------------------------------------*/
        .overlay1 {
            position: relative;
            z-index: 1;
        }

        .overlay1::after {
            content: "";
            display: block;
            position: absolute;
            z-index: -1;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background: rgba(0, 0, 0, 0.5);
        }

        /*---------------------------------------------*/
        .wrappic1 {
            display: block;
            flex-grow: 1;
        }

        .wrappic1 img {
            max-width: 100%;
        }

        /*---------------------------------------------*/
        .how-btn1 {
            padding: 0 15px;
            background-color: transparent;
            border: 1px solid #fff;
            border-radius: 25px;
        }

        .how-btn1:hover {
            background-color: #fff;
            color: #555;
        }

        /*---------------------------------------------*/
        .how-social {
            color: #999;
            font-size: 18px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background-color: transparent;
            border-radius: 50%;
        }

        .how-social:hover {
            background-color: #fff;
            color: #555;
        }

        /*---------------------------------------------*/
        .how-btn-play1 {
            width: 60px;
            height: 60px;
            background-color: transparent;
            border-radius: 50%;
            font-size: 20px;
            color: #333;
            position: relative;
            z-index: 1;
        }

        .how-btn-play1::after {
            content: "";
            display: block;
            position: absolute;
            z-index: -1;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background-color: #fff;
            border-radius: 50%;

            -webkit-transition: all 0.4s;
            -o-transition: all 0.4s;
            -moz-transition: all 0.4s;
            transition: all 0.4s;
        }

        .how-btn-play1:hover:after {
            opacity: 0.6;
            -webkit-transform: scale(1.2);
            -moz-transform: scale(1.2);
            -ms-transform: scale(1.2);
            -o-transform: scale(1.2);
            transform: scale(1.2);
        }


        /*//////////////////////////////////////////////////////////////////
        [ Pseudo ]*/

        /*------------------------------------------------------------------
        [ Focus ]*/
        .focus-in0:focus::-webkit-input-placeholder {
            color: transparent;
        }

        .focus-in0:focus:-moz-placeholder {
            color: transparent;
        }

        .focus-in0:focus::-moz-placeholder {
            color: transparent;
        }

        .focus-in0:focus:-ms-input-placeholder {
            color: transparent;
        }


        /*------------------------------------------------------------------
        [ Hover ]*/
        .hov-cl0:hover {
            color: #fff;
        }

        .hov-bg0:hover {
            background-color: #fff;
        }

        /*---------------------------------------------*/
        .hov1:hover i {
            color: #fff;
        }






        /*==================================================================
          RESPONSIVE RESPONSIVE RESPONSIVE RESPONSIVE RESPONSIVE RESPONSIVE
        ==================================================================*/


        /*//////////////////////////////////////////////////////////////////
        [ XL ]*/
        @media (max-width: 1200px) {
            .m-0-xl {
                margin: 0;
            }

            .m-lr-0-xl {
                margin-left: 0;
                margin-right: 0;
            }

            .m-lr-15-xl {
                margin-left: 15px;
                margin-right: 15px;
            }

            .m-l-0-xl {
                margin-left: 0;
            }

            .m-r-0-xl {
                margin-right: 0;
            }

            .m-l-15-xl {
                margin-left: 15px;
            }

            .m-r-15-xl {
                margin-right: 15px;
            }

            .p-0-xl {
                padding: 0;
            }

            .p-lr-0-xl {
                padding-left: 0;
                padding-right: 0;
            }

            .p-lr-15-xl {
                padding-left: 15px;
                padding-right: 15px;
            }

            .p-l-0-xl {
                padding-left: 0;
            }

            .p-r-0-xl {
                padding-right: 0;
            }

            .p-l-15-xl {
                padding-left: 15px;
            }

            .p-r-15-xl {
                padding-right: 15px;
            }

            .w-full-xl {
                width: 100%;
            }

            /*---------------------------------------------*/

        }


        /*//////////////////////////////////////////////////////////////////
        [ LG ]*/
        @media (max-width: 992px) {
            .dis-none-lg {
                display: none;
            }

            .m-0-lg {
                margin: 0;
            }

            .m-lr-0-lg {
                margin-left: 0;
                margin-right: 0;
            }

            .m-lr-15-lg {
                margin-left: 15px;
                margin-right: 15px;
            }

            .m-l-0-lg {
                margin-left: 0;
            }

            .m-r-0-lg {
                margin-right: 0;
            }

            .m-l-15-lg {
                margin-left: 15px;
            }

            .m-r-15-lg {
                margin-right: 15px;
            }

            .p-0-lg {
                padding: 0;
            }

            .p-lr-0-lg {
                padding-left: 0;
                padding-right: 0;
            }

            .p-lr-15-lg {
                padding-left: 15px;
                padding-right: 15px;
            }

            .p-l-0-lg {
                padding-left: 0;
            }

            .p-r-0-lg {
                padding-right: 0;
            }

            .p-l-15-lg {
                padding-left: 15px;
            }

            .p-r-15-lg {
                padding-right: 15px;
            }

            .w-full-lg {
                width: 100%;
            }

            /*---------------------------------------------*/
            .respon1 {
                font-size: 160px;
            }


        }


        /*//////////////////////////////////////////////////////////////////
        [ MD ]*/
        @media (max-width: 768px) {
            .m-0-md {
                margin: 0;
            }

            .m-lr-0-md {
                margin-left: 0;
                margin-right: 0;
            }

            .m-lr-15-md {
                margin-left: 15px;
                margin-right: 15px;
            }

            .m-l-0-md {
                margin-left: 0;
            }

            .m-r-0-md {
                margin-right: 0;
            }

            .m-l-15-md {
                margin-left: 15px;
            }

            .m-r-15-md {
                margin-right: 15px;
            }

            .p-0-md {
                padding: 0;
            }

            .p-lr-0-md {
                padding-left: 0;
                padding-right: 0;
            }

            .p-lr-15-md {
                padding-left: 15px;
                padding-right: 15px;
            }

            .p-l-0-md {
                padding-left: 0;
            }

            .p-r-0-md {
                padding-right: 0;
            }

            .p-l-15-md {
                padding-left: 15px;
            }

            .p-r-15-md {
                padding-right: 15px;
            }

            .w-full-md {
                width: 100%;
            }

            /*---------------------------------------------*/
            .respon1 {
                font-size: 120px;
            }

        }


        /*//////////////////////////////////////////////////////////////////
        [ SM ]*/
        @media (max-width: 576px) {
            .dis-none-sm {
                display: none;
            }

            .m-0-sm {
                margin: 0;
            }

            .m-lr-0-sm {
                margin-left: 0;
                margin-right: 0;
            }

            .m-lr-15-sm {
                margin-left: 15px;
                margin-right: 15px;
            }

            .m-l-0-sm {
                margin-left: 0;
            }

            .m-r-0-sm {
                margin-right: 0;
            }

            .m-l-15-sm {
                margin-left: 15px;
            }

            .m-r-15-sm {
                margin-right: 15px;
            }

            .p-0-sm {
                padding: 0;
            }

            .p-lr-0-sm {
                padding-left: 0;
                padding-right: 0;
            }

            .p-lr-15-sm {
                padding-left: 15px;
                padding-right: 15px;
            }

            .p-l-0-sm {
                padding-left: 0;
            }

            .p-r-0-sm {
                padding-right: 0;
            }

            .p-l-15-sm {
                padding-left: 15px;
            }

            .p-r-15-sm {
                padding-right: 15px;
            }

            .w-full-sm {
                width: 100%;
            }

            /*---------------------------------------------*/
            .respon1 {
                font-size: 80px;
            }

        }


        /*//////////////////////////////////////////////////////////////////
        [ SSM ]*/
        @media (max-width: 480px) {
            .m-0-ssm {
                margin: 0;
            }

            .m-lr-0-ssm {
                margin-left: 0;
                margin-right: 0;
            }

            .m-lr-15-ssm {
                margin-left: 15px;
                margin-right: 15px;
            }

            .m-l-0-ssm {
                margin-left: 0;
            }

            .m-r-0-ssm {
                margin-right: 0;
            }

            .m-l-15-ssm {
                margin-left: 15px;
            }

            .m-r-15-ssm {
                margin-right: 15px;
            }

            .p-0-ssm {
                padding: 0;
            }

            .p-lr-0-ssm {
                padding-left: 0;
                padding-right: 0;
            }

            .p-lr-15-ssm {
                padding-left: 15px;
                padding-right: 15px;
            }

            .p-l-0-ssm {
                padding-left: 0;
            }

            .p-r-0-ssm {
                padding-right: 0;
            }

            .p-l-15-ssm {
                padding-left: 15px;
            }

            .p-r-15-ssm {
                padding-right: 15px;
            }

            .w-full-ssm {
                width: 100%;
            }

            /*---------------------------------------------*/

        }

    </style>
    <link rel="stylesheet" href="{{ asset('assets/global/css/util.css') }}">
@endpush
