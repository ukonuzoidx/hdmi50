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
            @if ($settings->h_dshares == 0)
                <a href="javascript:void(0)" class="btn mb-4 btn--danger lock-shares">

                    @lang('Lock')
                </a>
            @else
                <a href="javascript:void(0)" class="btn mb-4 btn--success open-shares">

                    @lang('Open')
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
                                        <th scope="col">@lang('Type')</th>
                                        <th scope="col">@lang('Unit bought')</th>
                                        <th scope="col">@lang('Date bought/sold')</th>
                                        <th scope="col">@lang('Actions')</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($hdshares as $key => $value)
                                        <tr>
                                            <td data-label="@lang('Type')">{{ $value->name }}</td>
                                            <td data-label="@lang('Unit bought')">{{ $value->units }}</td>
                                            <td data-label="@lang('Date bought/sold')">{{ $value->created_at }}</td>

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
        $(document).on('click', '.lock-shares', function() {
            // var epin = $('#lock-shares').val();
            var token = "{{ csrf_token() }}";
            $.ajax({
                type: "POST",
                url: "{{ route('admin.hdshares.lock') }}",
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
        $(document).on('click', '.open-shares', function() {
            // var epin = $('#open-shares').val();
            var token = "{{ csrf_token() }}";
            $.ajax({
                type: "POST",
                url: "{{ route('admin.hdshares.open') }}",
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
