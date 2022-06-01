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
            <a href="javascript:void(0)" class="btn mb-4 btn--success add">
                <i class="fa fa-fw fa-plus"></i>
                @lang('Add New Epin')
            </a>

        </div>
        <!-- /breadcrumb -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card b-radius--10 ">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table text-md-nowrap" id="example1">
                                <thead>
                                    <tr>
                                        <th scope="col">@lang('Name')</th>
                                        <th scope="col">@lang('Amount')</th>
                                        <th scope="col">@lang('Status')</th>
                                        <th scope="col">@lang('Created At')</th>
                                        <th scope="col">@lang('Action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($epins as $epin)
                                        <tr>
                                            <td data-label="@lang('Email')">{{ $epin->epin }}</td>
                                            <td data-label="@lang('Phone')">{{ getAmount($epin->amount) }} USD</td>
                                            <td data-label="@lang('Status')">
                                                @if ($epin->status == 1)
                                                    <span class="badge badge-danger">@lang('Used')</span>
                                                @elseif($epin->status == 0)
                                                    <span class="badge badge-success">@lang('Unused')</span>
                                                @endif
                                            <td data-label="@lang('Joined At')">{{ showDateTime($epin->created_at) }}
                                            </td>
                                            <td data-label="@lang('Action')">
                                                <button type="button" class="icon-btn edit" data-toggle="tooltip"
                                                    data-id="{{ $epin->id }}" data-name="{{ $epin->epin }}"
                                                    data-status="{{ $epin->status }}"
                                                    data-amount="{{ getAmount($epin->amount) }}"
                                                    data-original-title="Edit">
                                                    <i class="la la-pencil"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-muted text-center" colspan="100%">{{ __($empty_message) }}
                                            </td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table><!-- table end -->
                        </div>
                    </div>
                    {{-- <div class="card-footer py-4">
                        {{ paginateLinks($epins) }}
                    </div> --}}
                </div><!-- card end -->
            </div>

        </div>





        {{-- edit modal --}}
        <div id="edit-epin" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('Edit Plan')</h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                    </div>
                    <form method="post" action="{{ route('admin.epins.update', $epin->id) }}">
                        @csrf
                        <div class="modal-body">

                            <input class="form-control epin_id" type="hidden" name="id">

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold"> @lang('Name') :</label>
                                    <input class="form-control epin" name="epin" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold"> @lang('Amount') </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text">$ </span></div>
                                        <input type="text" class="form-control amount" id="amountEdit" name="amount"
                                            required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold"> @lang('Status') :</label>
                                    <select class="form-control status" name="status" required>
                                        <option value="1">@lang('Used')</option>
                                        <option value="0">@lang('Unused')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-block btn--primary">@lang('Update')</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="add-epin" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('Add New Epin')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="{{ route('admin.epins.store') }}">
                        @csrf
                        <div class="modal-body">

                            <input class="form-control epin_id" type="hidden" name="id">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold"> @lang('Name') :</label>
                                    <input type="text" class="form-control " name="epin" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold"> @lang('Amount') </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text">$ </span></div>
                                        <input type="text" class="form-control" id="amount" name="amount" required>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn-block btn btn--primary">@lang('Submit')</button>
                        </div>
                    </form>

                </div>
            </div>
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
    <script>
        "use strict";
        (function($) {
            $('.edit').on('click', function() {
                var modal = $('#edit-epin');
                modal.find('.epin').val($(this).data('name'));
                modal.find('.amount').val($(this).data('amount'));
                modal.find('.status').val($(this).data('status'));

                modal.find('input[name=id]').val($(this).data('id'));
                modal.modal('show');
            });

            $('.add').on('click', function() {
                var modal = $('#add-epin');
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
