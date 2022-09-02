@extends($activeTemplate . 'user.layouts.app')

@section('title')
    {{ $page_title }}
@endsection

@push('css')
    <!-- Internal  Data table css -->
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endpush



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
            <form action="" method="GET" class="form-inline float-sm-right">
                <div class="input-group has_append">
                    <input type="text" name="search" class="form-control" placeholder="@lang('Search by TRX')"
                        value="{{ $search ?? '' }}">
                    <div class="input-group-append">
                        <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>
            <div class="d-flex align-items-end flex-wrap my-auto right-content breadcrumb-right">
                <button class="btn btn-primary mt-2 mt-xl-0">Current Rank<br>
                    <span class="badge badge-light">Member</span>
                    {{-- <span class="badge badge-light">{{ auth()->user()->rank }}</span> --}}
                </button>
            </div>
        </div>
        <!-- /breadcrumb -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card b-radius--10 ">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card b-radius--10 overflow-hidden">
                                    <div class="card-body p-0">
                                        <div class="table-responsive--sm">
                                            <table class="table table--light style--two">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">@lang('Transaction ID')</th>
                                                        <th scope="col">@lang('Gateway')</th>
                                                        <th scope="col">@lang('Amount')</th>
                                                        <th scope="col">@lang('Charge')</th>
                                                        <th scope="col">@lang('After Charge')</th>
                                                        <th scope="col">@lang('Rate')</th>
                                                        <th scope="col">@lang('Receivable')</th>
                                                        <th scope="col">@lang('Status')</th>
                                                        <th scope="col">@lang('Time')</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($withdraws as $k=>$data)
                                                        <tr>
                                                            <td data-label="#@lang('Trx')">{{ $data->trx }}</td>
                                                            <td data-label="@lang('Gateway')">{{ $data->method->name }}
                                                            </td>
                                                            <td data-label="@lang('Amount')">
                                                                <strong>{{ getAmount($data->amount) }} USD</strong>
                                                            </td>
                                                            <td data-label="@lang('Charge')" class="text--danger">
                                                                {{ getAmount($data->charge) }} USD
                                                            </td>
                                                            <td data-label="@lang('After Charge')">
                                                                {{ getAmount($data->after_charge) }} USD
                                                            </td>
                                                            <td data-label="@lang('Rate')">
                                                                {{ getAmount($data->rate) }} {{ $data->currency }}
                                                            </td>
                                                            <td data-label="@lang('Receivable')" class="text--success">
                                                                <strong>{{ getAmount($data->final_amount) }}
                                                                    {{ $data->currency }}</strong>
                                                            </td>
                                                            <td data-label="@lang('Status')">
                                                                @if ($data->status == 2)
                                                                    <span
                                                                        class="badge badge--warning">@lang('Pending')</span>
                                                                @elseif($data->status == 1)
                                                                    <span
                                                                        class="badge badge--success">@lang('Completed')</span>
                                                                    <button class="btn-info btn-rounded  badge approveBtn"
                                                                        data-admin_feedback="{{ $data->admin_feedback }}"><i
                                                                            class="fa fa-info"></i></button>
                                                                @elseif($data->status == 3)
                                                                    <span
                                                                        class="badge badge--danger">@lang('Rejected')</span>
                                                                    <button class="btn-info btn-rounded badge approveBtn"
                                                                        data-admin_feedback="{{ $data->admin_feedback }}"><i
                                                                            class="fa fa-info"></i></button>
                                                                @endif

                                                            </td>
                                                            <td data-label="@lang('Time')">
                                                                <i class="las la-calendar"></i>
                                                                {{ showDateTime($data->created_at) }}
                                                            </td>
                                                        </tr>

                                                    @empty
                                                        <tr>
                                                            <td class="text-muted text-center" colspan="100%">
                                                                {{ __($empty_message) }}
                                                            </td>
                                                        </tr>
                                                    @endforelse

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>



                        </div>
                        <div class="card-footer py-4">
                            {{ $withdraws->appends($_GET)->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Detail MODAL --}}
    <div id="detailModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Details')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="withdraw-detail"></div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        'use strict';
        (function($) {
            $('.approveBtn').on('click', function() {
                var modal = $('#detailModal');
                var feedback = $(this).data('admin_feedback');

                modal.find('.withdraw-detail').html(`<p> ${feedback} </p>`);
                modal.modal('show');
            });
        })(jQuery)
    </script>
@endpush


@push('scripts')
    <!-- Internal Data tables -->
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>

    <!-- Internal Datatable js -->
    <script src="{{ asset('assets/js/table-data.js') }}"></script>
@endpush
