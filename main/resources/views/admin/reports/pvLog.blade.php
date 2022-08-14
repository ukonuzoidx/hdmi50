@extends('admin.layouts.app')

@section('title')
    {{ $page_title }}
@endsection

{{-- @push('css')
    {{-- <link rel="stylesheet" href="{{ asset('assets/admin/css/apps.css') }}" /> -
    <!-- Internal  Data table css -->
    <link href="{{ asset('assets/admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endpush --}}



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
            @if (request()->routeIs('admin.users.transactions'))
                <form action="" method="GET" class="form-inline float-sm-right">
                    <div class="input-group has_append">
                        <input type="text" name="search" class="form-control" placeholder="@lang('TRX / Username')"
                            value="{{ $search ?? '' }}">
                        <div class="input-group-append">
                            <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </form>
            @else
                <form action="{{ route('admin.report.transaction.search') }}" method="GET"
                    class="form-inline float-sm-right">
                    <div class="input-group has_append">
                        <input type="text" name="search" class="form-control" placeholder="@lang('TRX / Username')"
                            value="{{ $search ?? '' }}">
                        <div class="input-group-append">
                            <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </form>
            @endif
        </div>
        <!-- /breadcrumb -->
        <div class="row">

        <div class="col-lg-12">
            <div class="card b-radius--10 overflow-hidden">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Sl')</th>
                                <th scope="col">@lang('Username')</th>
                                <th scope="col">@lang('BV')</th>
                                <th scope="col">@lang('Position')</th>
                                <th scope="col">@lang('Detail')</th>
                                <th scope="col">@lang('Date')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($logs as $key=>$data)
                                <tr>
                                    <td data-label="@lang('Sl')">{{$logs->firstItem()+$key}}</td>

                                    <td data-label="@lang('Username')"><a href="{{ route('admin.users.detail', @$data->user_id) }}">{{ @$data->user->username }}</a></td>

                                    <td data-label="@lang('BV')" class="budget">
                                        <strong @if($data->trx_type == '+') class="text-success"
                                                @else class="text-danger" @endif> {{($data->trx_type == '+') ? '+':'-'}} {{getAmount($data->amount)}}</strong>
                                    </td>

                                    <td data-label="@lang('Position')">
                                        @if ($data->position == 1)<span class="badge badge--success">@lang('Left')</span>
                                        @else
                                            <span class="badge badge--primary">@lang('Right')</span>
                                        @endif</td>
                                    <td data-label="@lang('Detail')">{{$data->details}}</td>
                                    <td data-label="@lang('Date')">{{$data->created_at != ''? date('d/m/y  g:i A',strtotime($data->created_at)): __('Not Assign')}}</td>
                                </tr>

                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($empty_message) }}</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{ $logs->links('admin.partials.paginate') }}
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
