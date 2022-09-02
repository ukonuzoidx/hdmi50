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
            {{-- check if general --}}
            @if ($settings->h_dshares == 0)
                <a href="javascript:void(0)" class="btn mb-4 btn--warning buy-shares">
                    {{-- <i class="fa fa-fw fa-minus"></i> --}}
                    @lang('Buy HDShares')
                </a>
            @endif

            <div class="d-flex align-items-end flex-wrap my-auto right-content breadcrumb-right">
                <button class="btn btn-primary mt-2 mt-xl-0">Current Rank<br>
                    <span class="badge badge-light">Member</span>
                    {{-- <span class="badge badge-light">{{ auth()->user()->rank }}</span> --}}
                </button>
            </div>
        </div>
        <!-- /breadcrumb -->
        <div class="row mb-none-30">
            <div class="col-lg-12">
                <div class="card b-radius--10 overflow-hidden">
                    <div class="card-body p-0">
                        <div class="table-responsive--sm">
                            <table class="table table--light style--two">
                                <thead>
                                    <tr>
                                        <th scope="col">@lang('TYPE')</th>
                                        <th scope="col">@lang('UNIT')</th>
                                        <th scope="col">@lang('CAPITAL')</th>
                                        <th scope="col">@lang('TRANSACTION DATE')</th>
                                        <th scope="col">@lang('PNL')</th>
                                        <th scope="col">@lang('NEW CAPITAL')</th>
                                        @if ($settings->h_dshares == 0)
                                            <th scope="col">@lang('ACTIONS')</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($hd_shares as $key => $value)
                                        <tr>
                                            <td data-label="@lang('Type')">{{ $value->name }}</td>
                                            <td data-label="@lang('Unit bought')">{{ $value->units }}</td>
                                            <td data-label="@lang('Capital')">${{ $value->capital }}</td>
                                            <td data-label="@lang('Transaction Date')">{{ $value->created_at }}</td>
                                            <td data-label="@lang('PNL')">
                                                ${{ ($value->capital * $general->pnl) / 100 }}
                                            </td>
                                            <td data-label="@lang('New Captial')">
                                                ${{ $value->capital + ($value->capital * $general->pnl) / 100 }}</td>
                                            {{-- Sell hdshares --}}
                                            @if ($settings->h_dshares == 0)
                                                <td data-label="@lang('Actions')">
                                                    <a href="javascript:void(0)" class="btn btn-success btn-sm sell-shares"
                                                        data-id="{{ $value->id }}" data-units="{{ $value->units }}">
                                                        <i class="fa fa-fw fa-plus"></i>
                                                        @lang('Sell')
                                                    </a>
                                                </td>
                                            @endif
                                        </tr>

                                    @empty
                                        <tr>
                                            <td colspan="3">@lang('No data')</td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div id="sell-shares" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('Edit Plan')</h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                    </div>
                    <form method="post" action="{{ route('user.h_dshares.sell') }}">
                        @csrf
                        <div class="modal-body">

                            <input class="form-control user_id" type="hidden" name="id">

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="font-weight-bold"> @lang('How many do you want to sell') :</label>
                                    {{-- using select 
                                        option 1 25%
                                        option 2 50%
                                        option 3 75%
                                        option 4 100% --}}
                                    <select class="form-control" name="units">
                                        <option value="25">25%</option>
                                        <option value="50">50%</option>
                                        <option value="75">75%</option>
                                        <option value="100">100%</option>
                                    </select>
                                </div>

                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-block btn--primary">@lang('Sell')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="buy-shares" class="modal  fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('Buy HDShares')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="{{ route('user.h_dshares.buy') }}">
                        @csrf
                        <div class="modal-body">

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="font-weight-bold"> @lang('Price') :</label>
                                    <input type="text" class="form-control" id="units-bought" name="price" required>
                                    {{-- <span>This price cost <span id="total"></span> units </span> --}}


                                </div>

                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn-block btn btn--primary">@lang('Buy')</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>


    </div>
@endsection

@push('scripts')
    <script>
        "use strict";
        (function($) {
            $('.sell-shares').on('click', function() {
                var modal = $('#sell-shares');
                // modal.find('.units').val($(this).data('units'));


                modal.find('input[name=id]').val($(this).data('id'));
                modal.modal('show');

            });

            $('.buy-shares').on('click', function() {
                var modal = $('#buy-shares');
                modal.modal('show');


            });
        })(jQuery);
    </script>
@endpush
