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
        <div class="row mb-none-30">
            @foreach ($plans as $data)
                <div class="col-xl-4 col-md-6 mb-30">
                    <div class="card">

                        <div class="card-body pt-5 pb-5 ">
                            <div class="pricing-table text-center mb-4">
                                <h2 class="package-name mb-20 text-"><strong>@lang($data->name)</strong></h2>
                                <span class="price text--white font-weight-bold d-block">USD
                                    {{ getAmount($data->price) }}</span>
                                <hr>
                                <ul class="package-features-list mt-30">
                                    <li>
                                        <i class="fas fa-check bg--success"></i>
                                        <span>@lang('Personal Volume (PV)'):
                                            {{ getAmount($data->pv) }}</span> <span class="icon"
                                            data-toggle="modal" data-target="#bvInfoModal">
                                            <i class="fas fa-question-circle"></i>
                                        </span>
                                    </li>
                                    <li>
                                        <i class="fas fa-check bg--success"></i>
                                        <span> @lang('Referral Commission'):
                                            USD {{ getAmount($data->ref_com) }}
                                        </span>
                                        <span class="icon" data-toggle="modal" data-target="#refComInfoModal">
                                            <i class="fas fa-question-circle"></i>
                                        </span>
                                    </li>
                                    <li>
                                        <i
                                            class="fas @if (getAmount($data->tree_com) != 0) fa-check bg--success @else fa-times bg--danger @endif "></i>
                                        <span>
                                            @lang('Tree Commission'): USD {{ getAmount($data->tree_com) }}
                                        </span>
                                        <span class="icon" data-toggle="modal" data-target="#treeComInfoModal">
                                            <i class="fas fa-question-circle"></i></span>
                                    </li>
                                </ul>
                            </div>
                            {{-- @if (Auth::user()->plan_id != $data->id) --}}
                            <a href="#confBuyModal{{ $data->id }}" data-toggle="modal"
                                class="btn w-100 btn-outline--primary  mt-20 py-2 box--shadow1">@lang('Subscribe')</a>
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
                            <form method="post" action="{{ route('user.plan.purchase') }}">
                                <div class="modal-body">
                                    {{-- <h5 class="text-danger text-center">USD {{ getAmount($data->price) }}
                                        @lang('will subtract from your balance')
                                    </h5> --}}
                                    <input type="hidden" name="plan_id" value="{{ $data->id }}" />
                                    {{-- input epin --}}
                                    @csrf
                                    <input type="text" name="epin" class="form-control" placeholder="@lang('Enter your epin')"
                                        required />
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn--danger" data-dismiss="modal"><i
                                            class="fa fa-times"></i> @lang('Close')</button>

                                    <button type="submit" name="plan_id" value="{{ $data->id }}"
                                        class="btn btn--success"><i class="lab la-telegram-plane"></i>
                                        @lang('Subscribe')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="modal fade" id="bvInfoModal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('Business Volume (BV) info')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="@lang('Close')">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5 class="text-danger">@lang('When someone from your below tree subscribe this plan, You will get this Personal Volume  which will be used for matching bonus').
                        </h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="refComInfoModal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('Referral Commission info')</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5><span class=" text-danger">@lang('When your referred user subscribe in') <b> @lang('ANY PLAN')</b>,
                                @lang('you will get this amount').</span>
                            <br>
                            <br>
                            <span class="text-success"> @lang('This is the reason you should choose a plan with bigger referral commission').</span>
                        </h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="treeComInfoModal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('Commission to tree info')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5 class=" text-danger">@lang('When someone from your below tree subscribe this plan, You will get this amount as tree commission'). </h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mg-b-0">{{ $subscribed }}</h4>
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
                                        <th class="wd-15p border-bottom-0">Email</th>
                                        <th class="wd-15p border-bottom-0">Plan Name</th>
                                        <th class="wd-15p border-bottom-0">Amount</th>
                                        <th class="wd-10p border-bottom-0">Subscribed At</th>
                                        <th class="wd-10p border-bottom-0">Status</th>
                                        <th class="wd-10p border-bottom-0">Expired At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($subscribed_plans as $key=>$data)
                                        <tr>
                                            <td>
                                                {{ $data->user->full_name }}
                                            </td>
                                            <td>
                                                {{ $data->user->email }}
                                            </td>
                                            <td>{{ $data->plan->name }}</td>
                                            <td>{{ $general->cur_text }} {{ getAmount($data->plan->price) }}</td>

                                            <td>
                                                @if ($data->subscribed_at != '')
                                                    {{ showDateTime($data->subscribed_at) }}
                                                @else
                                                    @lang('Not Assign')
                                                @endif
                                            </td>
                                            {{-- check if subscription is expired or active --}}
                                            @if ($data->subscribed_at != '')
                                                @if ($data->expired_at != '')
                                                    @if (strtotime($data->expired_at) > strtotime(date('Y-m-d')))
                                                        <td>
                                                            <span class="badge badge-success">@lang('Active')</span>
                                                        </td>
                                                    @else
                                                        <td>
                                                            <span class="badge badge-danger">@lang('Expired')</span>
                                                        </td>
                                                    @endif
                                                @else
                                                    <td>
                                                        <span class="badge badge-success">@lang('Active')</span>
                                                    </td>
                                                @endif
                                                @endif
                                            <td>
                                                @if ($data->expires_at != '')
                                                    {{ showDateTime($data->expires_at) }}
                                                @else
                                                    @lang('Not Assign')
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
@endsection
