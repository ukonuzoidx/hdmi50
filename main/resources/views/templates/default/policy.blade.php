@extends($activeTemplate . 'layouts.master')

@section('content')
    @if ($sections)
        {{-- {{ dd($sections->data_values) }} --}}
        <section class="policy-section pt-60 pb-120">
            <div class="container">
                <div class="row g-3 g-sm-4">
                    <div class="col-xl-12">
                        <div class="policy__item">
                            <div class="feature__item-cont">
                                <h6 class="feature__item-cont-title">{{ __(@$sections->data_values->title) }}
                                </h6>
                                <p>@php echo @$sections->data_values->details; @endphp</p>
                            </div>
                        </div>
                    </div>
                    {{-- @endforeach --}}
                </div>
            </div>
        </section>
    @endif
@endsection
