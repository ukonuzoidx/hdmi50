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
                    <span class="badge badge-light">NIL</span>
                    {{-- <span class="badge badge-light">{{ auth()->user()->rank }}</span> --}}
                </button>
            </div>
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
                                        <th scope="col">@lang('SL')</th>
                                        <th scope="col">@lang('Date')</th>
                                        <th scope="col">@lang('TRX')</th>
                                        <th scope="col">@lang('Amount')</th>
                                        <th scope="col">@lang('Charge')</th>
                                        <th scope="col">@lang('Post Balance')</th>
                                        <th scope="col">@lang('Detail')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transactions  as $trx)
                                        <tr>
                                            <td data-label="@lang('SL')">
                                                {{ $transactions ?? ('')->firstItem() + $loop->index }}</td>
                                            <td data-label="@lang('Date')">{{ showDateTime($trx->created_at) }}</td>
                                            <td data-label="@lang('TRX')" class="font-weight-bold">
                                                {{ $trx->trx }}</td>
                                            <td data-label="@lang('Amount')" class="budget">
                                                <strong
                                                    @if ($trx->trx_type == '+') class="text-success"
                                                @else class="text-danger" @endif>
                                                    {{ $trx->trx_type == '+' ? '+' : '-' }}
                                                    {{ getAmount($trx->amount) }}</strong>
                                            </td>
                                            <td data-label="@lang('Charge')" class="budget">
                                                {{ getAmount($trx->charge) }} </td>
                                            <td data-label="@lang('Post Balance')">{{ $trx->post_balance + 0 }}</td>
                                            <td data-label="@lang('Detail')">{{ __($trx->details) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-muted text-center" colspan="100%">{{ __($empty_message) }}
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer py-4">
                        {{ $transactions ?? ('')->appends($_GET)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection






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
