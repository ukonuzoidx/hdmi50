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

            <a href="javascript:void(0)" class="btn mb-4 btn--info claim-all-shares">

                @lang('Claim All Shares')
            </a>
            @if ($settings->h_dshares == 0)
                <a href="javascript:void(0)" class="btn mb-4 btn--danger lock-buy-shares">

                    @lang('Lock Buy Shares')
                </a>
            @else
                <a href="javascript:void(0)" class="btn mb-4 btn--success open-buy-shares">

                    @lang('Open Buy Shares')
                </a>
            @endif
            @if ($settings->h_sell_dshares == 0)
                <a href="javascript:void(0)" class="btn mb-4 btn--danger lock-sell-shares">

                    @lang('Lock Sell Shares')
                </a>
            @else
                <a href="javascript:void(0)" class="btn mb-4 btn--success open-sell-shares">

                    @lang('Open Sell Shares')
                </a>
            @endif
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
                                        <th scope="col">@lang('NAME')</th>
                                        <th scope="col">@lang('ID')</th>
                                        <th scope="col">@lang('TYPE')</th>
                                        <th scope="col">@lang('UNIT')</th>
                                        <th scope="col">@lang('CAPITAL')</th>
                                        <th scope="col">@lang('TRANSACTION DATE')</th>
                                        <th scope="col">@lang('PNL')</th>
                                        <th scope="col">@lang('NEW CAPITAL')</th>
                                        <th scope="col">@lang('ACTIONS')</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($hdshares as $key => $value)
                                        <tr>
                                            <td data-label="@lang('Type')">{{ $value->user->fullname }}</td>
                                            <td data-label="@lang('Type')">{{ $value->user->user_id }}</td>
                                            <td data-label="@lang('Type')">{{ $value->name }}</td>
                                            <td data-label="@lang('Unit bought')">{{ $value->units }}</td>
                                            <td data-label="@lang('Capital')">${{ $value->capital }}</td>
                                            <td data-label="@lang('Transaction Date')">{{ $value->created_at }}</td>
                                            <td data-label="@lang('PNL')">
                                                ${{ ($value->capital * $general->pnl) / 100 }}
                                            </td>
                                            <td data-label="@lang('New Captial')">
                                                ${{ $value->capital + ($value->capital * $general->pnl) / 100 }}</td>
                                            <td data-label="Actions">SELL</td>
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


    </div>
@endsection


@push('scripts')
    <script>
        $(document).on('click', '.lock-buy-shares', function() {
            // var epin = $('#lock-shares').val();
            var token = "{{ csrf_token() }}";
            $.ajax({
                type: "POST",
                url: "{{ route('admin.hdshares.lock.buy') }}",
                data: {
                    // 'lco': epin,
                    '_token': token
                },
                success: function(data) {
                    // refresh the page
                    location.reload();

                }
            });
        });
        $(document).on('click', '.open-buy-shares', function() {
            // var epin = $('#open-shares').val();
            var token = "{{ csrf_token() }}";
            $.ajax({
                type: "POST",
                url: "{{ route('admin.hdshares.open.buy') }}",
                data: {
                    // 'lco': epin,
                    '_token': token
                },
                success: function(data) {
                    // refresh the page
                    location.reload();

                }
            });
        });
        $(document).on('click', '.lock-sell-shares', function() {
            // var epin = $('#lock-shares').val();
            var token = "{{ csrf_token() }}";
            $.ajax({
                type: "POST",
                url: "{{ route('admin.hdshares.lock.sell') }}",
                data: {
                    // 'lco': epin,
                    '_token': token
                },
                success: function(data) {
                    // refresh the page
                    location.reload();

                }
            });
        });
        $(document).on('click', '.open-sell-shares', function() {
            // var epin = $('#open-shares').val();
            var token = "{{ csrf_token() }}";
            $.ajax({
                type: "POST",
                url: "{{ route('admin.hdshares.open.sell') }}",
                data: {
                    // 'lco': epin,
                    '_token': token
                },
                success: function(data) {
                    // refresh the page
                    location.reload();

                }
            });
        });
        $(document).on('click', '.claim-all-shares', function() {
            // var epin = $('#open-shares').val();
            var token = "{{ csrf_token() }}";
            $.ajax({
                type: "POST",
                url: "{{ route('admin.hdshares.claim.all.shares') }}",
                data: {
                    // 'lco': epin,
                    '_token': token
                },
                success: function(data) {
                    // refresh the page
                    location.reload();

                }
            });
        });
    </script>
@endpush
