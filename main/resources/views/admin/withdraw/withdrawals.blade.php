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
            @if (!request()->routeIs('admin.users.withdrawals') && !request()->routeIs('admin.users.withdrawals.method'))
        <form
            action="{{ route('admin.withdraw.search',$scope ??str_replace('admin.withdraw.','',request()->route()->getName())) }}"
            method="GET" class="form-inline float-sm-right">
            <div class="input-group has_append">
                <input type="text" name="search" class="form-control" placeholder="@lang('Withdrawal code/Username')"
                    value="{{ $search ?? '' }}">
                <div class="input-group-append">
                    <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>
        <form
            action="{{ route('admin.withdraw.dateSearch',$scope ??str_replace('admin.withdraw.','',request()->route()->getName())) }}"
            method="GET" class="form-inline float-sm-right mr-0 mr-xl-2 mr-lg-0">
            <div class="input-group has_append">
                <input name="date" type="text" data-range="true" data-multiple-dates-separator=" - " data-language="en"
                    class="datepicker-here text--black form-control" data-position='bottom right'
                    placeholder="@lang('Min Date - Max date')" autocomplete="off" value="{{ @$dateSearch }}" readonly>
                <input type="hidden" name="method" value="{{ @$method->id }}">
                <div class="input-group-append">
                    <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>
    @endif
        </div>
        <!-- /breadcrumb -->

        <div class="row justify-content-center">
            @if (request()->routeIs('admin.withdraw.log') || request()->routeIs('admin.withdraw.method') || request()->routeIs('admin.users.withdrawals') || request()->routeIs('admin.users.withdrawals.method'))
                <div class="col-xl-4 col-sm-6 mb-30">
                    <div class="widget-two box--shadow2 b-radius--5 bg--success">
                        <div class="widget-two__content">
                            <h2 class="text-white">
                                ${{ $withdrawals->where('status', 1)->sum('amount') }}</h2>
                            <p class="text-white">@lang('Approved Withdrawals')</p>
                        </div>
                    </div><!-- widget-two end -->
                </div>
                <div class="col-xl-4 col-sm-6 mb-30">
                    <div class="widget-two box--shadow2 b-radius--5 bg--6">
                        <div class="widget-two__content">
                            <h2 class="text-white">
                                ${{ $withdrawals->where('status', 2)->sum('amount') }}</h2>
                            <p class="text-white">@lang('Pending Withdrawals')</p>
                        </div>
                    </div><!-- widget-two end -->
                </div>
                <div class="col-xl-4 col-sm-6 mb-30">
                    <div class="widget-two box--shadow2 b-radius--5 bg--pink">
                        <div class="widget-two__content">
                            <h2 class="text-white">
                                ${{ $withdrawals->where('status', 3)->sum('amount') }}</h2>
                            <p class="text-white">@lang('Rejected Withdrawals')</p>
                        </div>
                    </div><!-- widget-two end -->
                </div>
            @endif
          <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">

                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Date')</th>
                                <th scope="col">@lang('Trx Number')</th>
                                @if(!request()->routeIs('admin.users.withdrawals') && !request()->routeIs('admin.users.withdrawals.method'))
                                <th scope="col">@lang('Username')</th>
                                @endif
                                <th scope="col">@lang('Method')</th>
                                <th scope="col">@lang('Amount')</th>
                                <th scope="col">@lang('Charge')</th>
                                <th scope="col">@lang('After Charge')</th>
                                <th scope="col">@lang('Rate')</th>
                                <th scope="col">@lang('Payable')</th>
                                @if(request()->routeIs('admin.withdraw.pending'))
                                    <th scope="col">@lang('Action')</th>
                                @elseif(request()->routeIs('admin.withdraw.log') || request()->routeIs('admin.withdraw.search')  || request()->routeIs('admin.users.withdrawals') || request()->routeIs('admin.withdraw.method'))
                                    <th scope="col">@lang('Status')</th>
                                @endif

                                @if(request()->routeIs('admin.withdraw.approved') || request()->routeIs('admin.withdraw.rejected') || request()->routeIs('admin.users.withdrawals.method'))
                                    <th scope="col">@lang('Info')</th>
                                @endif

                            </tr>
                            </thead>
                            <tbody>
                            @forelse($withdrawals as $withdraw)
                                @php
                                    $details = ($withdraw->withdraw_information != null) ? json_encode($withdraw->withdraw_information) : null;
                                @endphp
                                <tr>
                                    <td data-label="@lang('Date')">{{ showDateTime($withdraw->created_at) }}</td>
                                    <td data-label="@lang('Trx Number')" class="font-weight-bold">{{ strtoupper($withdraw->trx) }}</td>
                                    @if(!request()->routeIs('admin.users.withdrawals') && !request()->routeIs('admin.users.withdrawals.method'))
                                    <td data-label="@lang('Username')">
                                        <a href="{{ route('admin.users.detail', $withdraw->user_id) }}">{{ @$withdraw->user->username }}</a>
                                    </td>
                                    @endif
                                    <td data-label="@lang('Method')">
                                        @if(request()->routeIs('admin.users.withdrawals') || request()->routeIs('admin.users.withdrawals'))
                                       <a href="{{ route('admin.users.withdrawals.method',[$withdraw->method->id,@$type?$type:'all',$userId]) }}"> {{ __(@$withdraw->method->name) }}</a>
                                       @else
                                       <a href="{{ route('admin.withdraw.method',[$withdraw->method->id,@$type]) }}"> {{ __(@$withdraw->method->name) }}</a>
                                       @endif
                                    </td>
                                    <td data-label="@lang('Amount')" class="budget font-weight-bold">{{ getAmount($withdraw->amount) }} {{__($general->cur_text)}}</td>
                                    <td data-label="@lang('Charge')" class="budget text-danger">{{ getAmount($withdraw->charge) }} {{__($general->cur_text)}}</td>
                                    <td data-label="@lang('After Charge')" class="budget">{{ getAmount($withdraw->after_charge) }} {{__($general->cur_text)}}</td>
                                    <td data-label="@lang('Rate')" class="budget">{{ getAmount($withdraw->rate) }}  {{__($withdraw->currency)}}</td>

                                    <td data-label="@lang('Payable')" class="budget font-weight-bold">{{ getAmount($withdraw->final_amount) }} {{ __($withdraw->currency) }} </td>
                                    @if(request()->routeIs('admin.withdraw.pending'))

                                        <td data-label="@lang('Action')">
                                            <a href="{{ route('admin.withdraw.details', $withdraw->id) }}" class="icon-btn ml-1 " data-toggle="tooltip"data-original-title="@lang('Detail')">
                                                <i class="la la-eye"></i>
                                            </a>
                                        </td>
                                    @elseif(request()->routeIs('admin.withdraw.log') || request()->routeIs('admin.withdraw.search') || request()->routeIs('admin.users.withdrawals') || request()->routeIs('admin.withdraw.method') ||  request()->routeIs('admin.users.withdrawals.method'))
                                        <td data-label="@lang('Status')">
                                            @if($withdraw->status == 2)
                                                <span class="text--small badge font-weight-normal badge--warning">@lang('Pending')</span>
                                            @elseif($withdraw->status == 1)
                                                <span class="text--small badge font-weight-normal badge--success">@lang('Approved')</span>
                                            @elseif($withdraw->status == 3)
                                                <span class="text--small badge font-weight-normal badge--danger">@lang('Rejected')</span>
                                            @endif
                                        </td>
                                    @endif
                                    @if(request()->routeIs('admin.withdraw.approved') || request()->routeIs('admin.withdraw.rejected'))
                                        <td data-label="@lang('Info')">
                                            <a href="{{ route('admin.withdraw.details', $withdraw->id) }}" class="icon-btn ml-1 " data-toggle="tooltip" data-original-title="@lang('Detail')">
                                                <i class="la la-desktop"></i>
                                            </a>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($empty_message) }}</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>

                <div class="card-footer py-4">
                    {{ paginateLinks($withdrawals) }}
                </div>
            </div><!-- card end -->
        </div>
        </div>
    </div>

@endsection



@push('scripts')
    <!-- Internal Data tables -->
    <script src="{{ asset('assets/admin/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>

    <!-- Internal Datatable js -->
    <script src="{{ asset('assets/admin/js/table-data.js') }}"></script>
    <script src="{{ asset('assets/admin/js/vendor/datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/vendor/datepicker.en.js') }}"></script>
    <script>
        'use strict';
        (function($) {
            if (!$('.datepicker-here').val()) {
                $('.datepicker-here').datepicker();
            }
        })(jQuery)
    </script>
@endpush
