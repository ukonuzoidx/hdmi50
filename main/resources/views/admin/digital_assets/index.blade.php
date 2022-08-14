@extends('admin.layouts.app')

@section('title')
    {{ $page_title }}
@endsection




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
                                        <th scope="col">@lang('Type')</th>
                                        <th scope="col">@lang('Username')</th>
                                        <th scope="col">@lang('Plan')</th>
                                        <th scope="col">@lang('Current Price')</th>
                                        <th scope="col">@lang('Product')</th>
                                        <th scope="col">@lang('Claim')</th>
                                        <th scope="col">@lang('Total Claim')</th>
                                        <th scope="col">@lang('Status')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($digital_assets as $key => $digital_asset)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $digital_asset->name }}</td>
                                            <td>{{ $digital_asset->user->username }}</td>
                                            <td>{{ $digital_asset->plan->name }}</td>
                                            <td>{{ $digital_asset->current_price }}</td>
                                            <td>{{ $digital_asset->total_product }}</td>
                                            <td>{{ $digital_asset->claim }}</td>
                                            <td>{{ $digital_asset->total_claim }}</td>
                                            <td>
                                                @if ($digital_asset->total_claim == $digital_asset->plan->claim)
                                                    <span class="badge badge-success">@lang('Claimed')</span>
                                                @else
                                                    <span class="badge badge-warning">@lang('Not yet Claimed')</span>
                                                @endif

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table><!-- table end -->
                        </div>
                    </div>
                    <div class="card-footer py-4">
                        {{ $digital_assets->links('admin.partials.paginate') }}
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

{{-- @push('scripts')
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
@endpush --}}
