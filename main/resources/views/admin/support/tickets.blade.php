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
            <a href="{{ route('admin.withdraw.method.index') }}" class="btn btn-sm btn--primary mb-4">
                <i class="la la-fw la-backward"></i> @lang('Go Back')
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
                                        <th scope="col">@lang('Subject')</th>
                                        <th scope="col">@lang('Submitted By')</th>
                                        <th scope="col">@lang('Status')</th>
                                        <th scope="col">@lang('Last Reply')</th>
                                        <th scope="col">@lang('Action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($items as $item)
                                        <tr>
                                            <td data-label="@lang('Subject')">
                                                <a href="{{ route('admin.ticket.view', $item->id) }}"
                                                    class="font-weight-bold"> [Ticket#{{ $item->ticket }}]
                                                    {{ $item->subject }} </a>
                                            </td>

                                            <td data-label="@lang('Submitted By')">
                                                @if ($item->user_id)
                                                    <a href="{{ route('admin.users.detail', $item->user_id) }}">
                                                        {{ @$item->user->fullname }}</a>
                                                @else
                                                    <p class="font-weight-bold"> {{ $item->name }}</p>
                                                @endif
                                            </td>
                                            <td data-label="@lang('Status')">
                                                @if ($item->status == 0)
                                                    <span class="badge badge--success">@lang('Open')</span>
                                                @elseif($item->status == 1)
                                                    <span class="badge  badge--primary">@lang('Answered')</span>
                                                @elseif($item->status == 2)
                                                    <span class="badge badge--warning">@lang('Customer Reply')</span>
                                                @elseif($item->status == 3)
                                                    <span class="badge badge--danger">@lang('Closed')</span>
                                                @endif
                                            </td>

                                            <td data-label="@lang('Last Reply')">
                                                {{ diffForHumans($item->last_reply) }}
                                            </td>

                                            <td data-label="@lang('Action')">
                                                <a href="{{ route('admin.ticket.view', $item->id) }}"
                                                    class="icon-btn  ml-1" data-toggle="tooltip" title=""
                                                    data-original-title="@lang('Details')">
                                                    <i class="las la-desktop"></i>
                                                </a>
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
                        {{ paginateLinks($items) }}

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
