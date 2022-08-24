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
            <a href="javascript:void(0)" class="btn mb-4 btn--success add-plan">
                <i class="fa fa-fw fa-plus"></i>
                @lang('Add New')
            </a>
        </div>
        <!-- /breadcrumb -->


        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive--md table-responsive">
                            <table class="table table--light style--two">
                                <thead>
                                    <tr>
                                        <th scope="col">@lang('Sl')</th>
                                        <th scope="col">@lang('Name')</th>
                                        <th scope="col">@lang('Price')</th>
                                        <th scope="col">@lang('Business Volume (BV)')</th>
                                        <th scope="col">@lang('Referral Commission')</th>
                                        <th scope="col">@lang('Tree Commission')</th>
                                        <th scope="col">@lang('Status')</th>
                                        <th scope="col">@lang('Action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($plans as $key => $plan)
                                        <tr>
                                            <td data-label="@lang('Sl')">{{ $key + 1 }}</td>
                                            <td data-label="@lang('Name')">{{ __($plan->name) }}</td>
                                            <td data-label="@lang('Price')">{{ getAmount($plan->price) }}
                                                {{ $general->cur_text }}</td>
                                            <td data-label="@lang('Bv')">{{ $plan->bv }}</td>
                                            <td data-label="@lang('Referral Commission')"> {{ getAmount($plan->ref_com) }}
                                                {{ $general->cur_text }}</td>

                                            <td data-label="@lang('Tree Commission')">
                                                {{ getAmount($plan->tree_com) }} {{ $general->cur_text }}
                                            </td>
                                            <td data-label="@lang('Status')">
                                                @if ($plan->status == 1)
                                                    <span
                                                        class="text--small badge font-weight-normal badge--success">@lang('Active')</span>
                                                @else
                                                    <span
                                                        class="text--small badge font-weight-normal badge--danger">@lang('Inactive')</span>
                                                @endif
                                            </td>

                                            <td data-label="@lang('Action')">
                                                <button type="button" class="icon-btn edit" data-toggle="tooltip"
                                                    data-id="{{ $plan->id }}" data-name="{{ $plan->name }}"
                                                    data-status="{{ $plan->status }}" data-pv="{{ $plan->pv }}"
                                                    data-roi="{{ getAmount($plan->roi) }}"
                                                    data-price="{{ getAmount($plan->price) }}"
                                                    data-ref_com="{{ getAmount($plan->ref_com) }}"
                                                    data-tree_com="{{ getAmount($plan->tree_com) }}"
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
                    <div class="card-footer py-4">
                        {{ $plans->links('admin.partials.paginate') }}
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive--md table-responsive">
                            <table class="table table--light style--two">
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
                                                {{ $empty_subscribed_message }}
                                            </td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table><!-- table end -->
                        </div>
                    </div>
                    <div class="card-footer py-4">
                        {{ $subscribed_plans->links('admin.partials.paginate') }}
                    </div>
                </div>
            </div>
        </div>

    </div>


    {{-- edit modal --}}
    <div id="edit-plan" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Edit Plan')</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <form method="post" action="{{ route('admin.plan.update') }}">
                    @csrf
                    <div class="modal-body">

                        <input class="form-control plan_id" type="hidden" name="id">

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold"> @lang('Name') :</label>
                                <input class="form-control name" name="name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold"> @lang('Price') </label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">$ </span></div>
                                    <input type="text" class="form-control price" id="priceEdit" name="price"
                                        required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold"> @lang('Personal Volume (PV)')</label>
                            <input class="form-control pv" readonly name="pv" id="pvEdit" required>
                            <small class="text--red">@lang('When someone buys this plan, all of his ancestors will get this value which will be used for a matching bonus.')</small>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">@lang('Referral Commission')</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">$ </span></div>
                                <input type="text" class="form-control ref_com" id="refComEdit" name="ref_com"
                                    readonly required>
                            </div>
                            <small class="text--red">@lang('If a user who subscribed to this plan, refers someone and if the referred user buys a plan, then he will get this amount.')</small>
                        </div>


                        <div class="form-group">
                            <label class="font-weight-bold">@lang('Tree Commission')</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">$ </span></div>
                                <input type="text" class="form-control tree_com" name="tree_com" id="treeComEdit"
                                    readonly required>
                            </div>
                            <small class="small text--red">@lang('When someone buys this plan, all of his ancestors will get this amount.')</small>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">@lang('ROI')</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">$ </span></div>
                                <input type="text" class="form-control roi" name="roi" id="roiComEdit" readonly
                                    required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label class="font-weight-bold">@lang('Status')</label>
                                <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                    data-toggle="toggle" data-on="@lang('Active')" data-off="@lang('Inactive')"
                                    name="status" checked>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-block btn--primary">@lang('Update')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="add-plan" class="modal  fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Add New plan')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="{{ route('admin.plan.store') }}">
                    @csrf
                    <div class="modal-body">

                        <input class="form-control plan_id" type="hidden" name="id">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold"> @lang('Name') :</label>
                                <input type="text" class="form-control " name="name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold"> @lang('Price') </label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">$ </span></div>
                                    <input type="text" class="form-control" id="price" name="price" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold"> @lang('Personal Volume (PV)')</label>
                            <input class="form-control" id="pv" type="number" min="0" name="pv"
                                readonly required>

                            <small class="text--red">@lang('If a user who subscribed to this plan, refers someone and if the referred user buys a plan, then he will get this amount.')</small>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold"> @lang('Referral Commission')</label>
                            <div class="input-group ">
                                <div class="input-group-prepend"><span class="input-group-text">$ </span></div>
                                <input type="text" class="form-control" id="refCom" name="ref_com" readonly
                                    required>
                            </div>
                            <small class="small text--red">@lang('If a user who subscribed to this plan, refers someone and if the referred user buys a plan, then he will get this amount.')</small>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold"> @lang('Tree Commission')</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">$ </span></div>
                                <input type="text" class="form-control" id="treeCom" name="tree_com" readonly
                                    required>
                            </div>
                            <small class="small text--red">@lang('When someone buys this plan, all of his uplines will get this amount.')</small>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold"> @lang('ROI')</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">$ </span></div>
                                <input type="text" class="form-control" id="roiCom" name="roi" readonly
                                    required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col">
                                <label class="font-weight-bold">@lang('Status')</label>
                                <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                    data-toggle="toggle" data-on="@lang('Active')" data-off="@lang('Inactive')"
                                    name="status" checked>
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
@endsection


@push('scripts')
    <!-- Internal Data tables -->
    {{-- <script src="{{ asset('assets/admin/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
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
    <script src="{{ asset('assets/admin/js/table-data.js') }}"></script> --}}
    <script>
        "use strict";
        (function($) {
            $('.edit').on('click', function() {
                var modal = $('#edit-plan');
                modal.find('.name').val($(this).data('name'));
                modal.find('.price').val($(this).data('price'));
                modal.find('.pv').val($(this).data('pv'));
                modal.find('.ref_com').val($(this).data('ref_com'));
                modal.find('.tree_com').val($(this).data('tree_com'));
                modal.find('.roi').val($(this).data('roi'));



                modal.find('input[name=daily_ad_limit]').val($(this).data('daily_ad_limit'));

                if ($(this).data('status')) {
                    modal.find('.toggle').removeClass('btn--danger off').addClass('btn--success');
                    modal.find('input[name="status"]').prop('checked', true);

                } else {
                    modal.find('.toggle').addClass('btn--danger off').removeClass('btn--success');
                    modal.find('input[name="status"]').prop('checked', false);
                }

                modal.find('input[name=id]').val($(this).data('id'));
                modal.modal('show');

                // update the edit modal input field by calculations

                $('#priceEdit').on('keyup', function() {
                    var price = $(this).val();
                    var pv = price;
                    var ref_com = price * 0.08;
                    var tree_com = price * 0.1;
                    $('#pvEdit').val(pv);
                    $('#refComEdit').val(ref_com);
                    $('#treeComEdit').val(tree_com);
                });
            });

            $('.add-plan').on('click', function() {
                var modal = $('#add-plan');
                modal.modal('show');

                // update input field by calculation
                $('#price').on('keyup', function() {
                    var price = $(this).val();
                    var pv = price;
                    var ref_com = price * 0.08;
                    var tree_com = price * 0.1;
                    $('#pv').val(pv);
                    $('#refCom').val(ref_com);
                    $('#treeCom').val(tree_com);
                });

            });
        })(jQuery);
    </script>
@endpush
