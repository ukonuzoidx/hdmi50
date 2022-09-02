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
                    <span class="badge badge-light">Member</span>
                    {{-- <span class="badge badge-light">{{ auth()->user()->rank }}</span> --}}
                </button>
            </div>
        </div>
        <!-- /breadcrumb -->

        <div class="row mb-none-30">
            @foreach ($fixedInvestment as $data)
                <div class="col-xl-3 col-md-6 mb-30">
                    <div class="card">

                        <div class="card-body pt-5 pb-5 ">
                            <div class="pricing-table text-center mb-4">
                                <h2 class="package-name mb-20 text-"><strong>@lang($data->name)</strong></h2>
                                <span class="price text--white font-weight-bold d-block">$
                                    {{ getAmount($data->price) }}</span>

                            </div>
                            {{-- @if (Auth::user()->plan_id != $data->id) --}}
                            <a href="#confBuyModal{{ $data->id }}" data-toggle="modal"
                                class="btn w-100 btn-outline--primary  mt-20 py-2">@lang('Subscribe')</a>
                            {{-- @else
                                <a data-toggle="modal"
                                    class="btn w-100 btn-outline--primary  mt-20 py-2 box--shadow1">@lang('Already Subscribe')</a>
                            @endif --}}
                        </div>

                    </div><!-- card end -->


                </div>


                <div class="modal fade" id="confBuyModal{{ $data->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel"> @lang('Confirm Purchase ' . $data->name)?</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">×</span></button>
                            </div>
                            <form method="post" action="{{ route('user.plan.fixed.investment.purchase') }}">
                                <div class="modal-body">
                                    {{-- <h5 class="text-danger text-center">USD {{ getAmount($data->price) }}
                                        @lang('will subtract from your balance')
                                    </h5> --}}
                                    <input type="hidden" name="fixed_investment_id" value="{{ $data->id }}" />
                                    {{-- input epin --}}
                                    @csrf
                                    <input type="text" name="pin" class="form-control"
                                        placeholder="@lang('Enter your Transaction pin')" required />
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn--danger" data-dismiss="modal"><i
                                            class="fa fa-times"></i> @lang('Close')</button>

                                    <button type="submit" name="fixed_investment_id" value="{{ $data->id }}"
                                        class="btn btn--success"><i class="lab la-telegram-plane"></i>
                                        @lang('Subscribe')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>



    </div>
@endsection
