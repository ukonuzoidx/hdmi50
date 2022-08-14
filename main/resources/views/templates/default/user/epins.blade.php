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
            <a href="javascript:void(0)" class="btn mb-4 btn--success transfer">
                <i class="fa fa-fw fa-plus"></i>
                @lang('Transfer Epin')
            </a>

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
                <div class="card b-radius--10 overflow-hidden">
                    <div class="card-body p-0">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table text-md-nowrap" id="example1">
                                    <thead>
                                        <tr>
                                            <th scope="col">@lang('Name')</th>
                                            <th scope="col">@lang('Status')</th>
                                            <th scope="col">@lang('Created At')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($epins as $epin)
                                            <tr>
                                                <td data-label="@lang('Email')">{{ $epin->epin }}</td>
                                                <td data-label="@lang('Status')">
                                                    @if ($epin->status == 1)
                                                        <span class="badge badge-danger">@lang('Used')</span>
                                                    @elseif($epin->status == 0)
                                                        <span class="badge badge-success">@lang('Unused')</span>
                                                    @endif
                                                <td data-label="@lang('Joined At')">{{ showDateTime($epin->created_at) }}
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
                    </div>
                </div>
            </div>
        </div>

        <div id="transfer-epin" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('Transfer Epin')</h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                    </div>
                    <form method="post" action="{{ route('user.epins.sent') }}">
                        @csrf
                        <div class="modal-body">

                            <input class="form-control epin_id" type="hidden" name="id">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold"> @lang('Name') :</label>
                                    <input class="form-control" name="epin" placeholder="Put your Epin" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold"> @lang('Username') </label>
                                    <input type="text" class="form-control" name="username"
                                        placeholder="Enter the username " required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-block btn--primary">@lang('Transfer')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /container -->
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


@push('scripts')
    <!-- Internal Data tables -->
    <script>
        "use strict";
        (function($) {
            $('.transfer').on('click', function() {
                var modal = $('#transfer-epin');
                modal.modal('show');
            });


        })(jQuery);
    </script>
@endpush
