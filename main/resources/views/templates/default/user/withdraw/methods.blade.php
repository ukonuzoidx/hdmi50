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
            <div class="d-flex align-items-end flex-wrap my-auto right-content breadcrumb-right">
                <button class="btn btn-primary mt-2 mt-xl-0">Current Rank<br>
                    <span class="badge badge-light">Member</span>
                    {{-- <span class="badge badge-light">{{ auth()->user()->rank }}</span> --}}
                </button>
            </div>
        </div>
        <!-- /breadcrumb -->
        <div class="row  mt-2">
            @foreach ($withdrawMethod as $data)
                <div class="col-lg-3 col-md-4 mb-4">
                    <div class="card card-deposit">
                        <h5 class="card-header text-center">{{ __($data->name) }}</h5>
                        <div class="card-body card-body-deposit">
                            <img src="{{ getImage(imagePath()['withdraw']['method']['path'] . '/' . $data->image) }}"
                                class="card-img-top w-100" alt="{{ __($data->name) }}">
                            <ul class="list-group text-center font-15">
                                <li class="list-group-item">@lang('Limit')
                                    : {{ getAmount($data->min_limit) }}
                                    - {{ getAmount($data->max_limit) }} USD</li>
                                <li class="list-group-item"> @lang('Charge')
                                    - {{ getAmount($data->fixed_charge) }} USD
                                    + {{ getAmount($data->percent_charge) }}%
                                </li>
                                <li class="list-group-item">@lang('Processing Time')
                                    - {{ $data->delay }}</li>
                            </ul>

                        </div>
                        <div class="card-footer">
                            <a href="javascript:void(0)" data-id="{{ $data->id }}" data-resource="{{ $data }}"
                                data-min_amount="{{ getAmount($data->min_limit) }}"
                                data-max_amount="{{ getAmount($data->max_limit) }}"
                                data-fix_charge="{{ getAmount($data->fixed_charge) }}"
                                data-percent_charge="{{ getAmount($data->percent_charge) }}" data-base_symbol="USD"
                                class="btn btn-block  btn--success deposit" data-toggle="modal" data-target="#exampleModal">
                                @lang('Withdraw Now')</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title method-name" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('user.withdraw.money') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="currency" class="edit-currency form-control" value="">
                            <input type="hidden" name="method_code" class="edit-method-code  form-control" value="">
                        </div>
                        <div class="form-group">
                            <label>@lang('Enter Amount'):</label>
                            <div class="input-group">
                                <input id="amount" type="text" class="form-control form-control-lg"
                                    onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" name="amount"
                                    placeholder="0.00" required="" value="{{ old('amount') }}">
                                <div class="input-group-append">
                                    <span class="input-group-text addon-bg currency-addon">USD</span>
                                </div>
                            </div>
                        </div>
                        <p class="text-danger text-center depositLimit"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--secondary" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--success">@lang('Confirm')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        'use strict';
        (function($) {
            $('.deposit').on('click', function() {
                var id = $(this).data('id');
                var result = $(this).data('resource');
                var minAmount = $(this).data('min_amount');
                var maxAmount = $(this).data('max_amount');
                var fixCharge = $(this).data('fix_charge');
                var percentCharge = $(this).data('percent_charge');

                var depositLimit = `@lang('Withdraw Limit:') ${minAmount} - ${maxAmount}  USD`;
                $('.depositLimit').text(depositLimit);
                var depositCharge =
                    `@lang('Charge:') ${fixCharge} USD ${(0 < percentCharge) ? ' + ' + percentCharge + ' %' : ''}`
                $('.depositCharge').text(depositCharge);
                $('.method-name').text(`@lang('Withdraw Via ') ${result.name}`);
                $('.edit-currency').val(result.currency);
                $('.edit-method-code').val(result.id);
            });
        })(jQuery)
    </script>
@endpush
