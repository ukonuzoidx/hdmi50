@php
$marketing_tools = getContent('marketing_tool.element');
@endphp
@if ($marketing_tools)

    <section class=" feature-section pt-60 pb-120">
        <div class="container">
            <div class="row g-3 g-sm-4">
                @foreach ($marketing_tools as $marketing_tool)
                    <div class="col-xl-12">
                        <div class="feature__item">
                            <div class="feature__item-icon">
                                <div class="icon">
                                    <i class="fas fa-bullhorn"></i>
                                </div>
                            </div>
                            <div class="feature__item-cont">
                                <h6 class="feature__item-cont-title">{{ __(@$marketing_tool->data_values->title) }}
                                </h6>
                                <p>@php echo @$marketing_tool->data_values->description; @endphp</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
