@extends('admin.layouts.app')

@section('title')
    {{ $page_title }}
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/apps.css') }}" />
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
            <a href="{{ route('admin.withdraw.shiba.log') }}" class="btn btn-sm btn--primary mb-4">
                <i class="la la-fw la-backward"></i> @lang('Go Back')
            </a>
        </div>
        <!-- /breadcrumb -->
        <div class="row mb-none-30">


            <div class="col-lg-4 col-md-4 mb-30">
                <div class="card b-radius--10 overflow-hidden">
                    <div class="card-body">
                        <h5 class="mb-20 text-muted">@lang('Withdraw For SHIBA')</h5>


                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Date')
                                <span class="font-weight-bold">{{ showDateTime($withdrawal->created_at) }}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Trx Number')
                                <span class="font-weight-bold">{{ $withdrawal->trx }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Username')
                                <span class="font-weight-bold">
                                    <a
                                        href="{{ route('admin.users.detail', $withdrawal->user_id) }}">{{ @$withdrawal->user->username }}</a>
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Amount')
                                <span class="font-weight-bold">{{ getAmount($withdrawal->shibainu) }}
                                    SHIB</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Rate')
                                <span class="font-weight-bold">1USD
                                    = 10000 SHIB</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Status')
                                @if ($withdrawal->status == 2)
                                    <span class="badge badge-pill bg--warning">@lang('Pending')</span>
                                @elseif($withdrawal->status == 1)
                                    <span class="badge badge-pill bg--success">@lang('Approved')</span>
                                @elseif($withdrawal->status == 3)
                                    <span class="badge badge-pill bg--danger">@lang('Rejected')</span>
                                @endif
                            </li>


                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-8 mb-30">

                <div class="card b-radius--10 overflow-hidden">
                    <div class="card-body">
                        <h5 class="card-title mb-50 border-bottom pb-2">@lang('User Withdraw Information')</h5>


                        @if ($withdrawal->status == 2)
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <button class="btn btn--success ml-1 approveBtn" data-toggle="tooltip"
                                        data-original-title="@lang('Approve')" data-id="{{ $withdrawal->id }}"
                                        data-shibainu="{{ getAmount($withdrawal->shibainu) }} SHIB">
                                        <i class="fas la-check"></i> @lang('Approve')
                                    </button>

                                    <button class="btn btn--danger ml-1 rejectBtn" data-toggle="tooltip"
                                        data-original-title="@lang('Reject')" data-id="{{ $withdrawal->id }}"
                                        data-shibainu="{{ getAmount($withdrawal->shibainu) }} SHIB">
                                        <i class="fas fa-ban"></i> @lang('Reject')
                                    </button>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>



    {{-- APPROVE MODAL --}}
    <div id="approveModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Approve Shiba Withdrawal Confirmation')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.withdraw.shiba.approve') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <p>@lang('Have you Sent') <span class="font-weight-bold withdraw-amount text-success"></span>?</p>
                        <p class="withdraw-detail"></p>
                        <textarea name="details" class="form-control pt-3" rows="3" placeholder="@lang('Provide the Details. eg: Transaction number')" required=""></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--success">@lang('Approve')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- REJECT MODAL --}}
    <div id="rejectModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Reject Shiba Withdrawal Confirmation')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.withdraw.shiba.reject') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <strong>@lang('Reason of Rejection')</strong>
                        <textarea name="details" class="form-control pt-3" rows="3" placeholder="@lang('Provide the Details')" required=""></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--danger">@lang('Reject')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            "use strict";
            $('.approveBtn').on('click', function() {
                var modal = $('#approveModal');
                modal.find('input[name=id]').val($(this).data('id'));
                modal.find('.withdraw-amount').text($(this).data('shibainu'));
                modal.modal('show');
            });

            $('.rejectBtn').on('click', function() {
                var modal = $('#rejectModal');
                modal.find('input[name=id]').val($(this).data('id'));
                modal.find('.withdraw-amount').text($(this).data('shibainu'));
                modal.modal('show');
            });
        });
    </script>
@endpush
