@extends('admin.layouts.app')

@section('title')
    {{ $page_title }}
@endsection


@push('css')
    <link href={{ asset('assets/admin/css/tree.css') }} rel="stylesheet">
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
            <form action="{{ route('user.other.tree.search') }}" method="GET" class="form-inline float-right">
                <div class="input-group has_append">
                    <input type="text" name="username" class="form-control" placeholder="@lang('Search by username')">
                    <div class="input-group-append">
                        <button class="btn btn--success" type="submit"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>
            <div class="d-flex align-items-end flex-wrap my-auto right-content breadcrumb-right">
                <button class="btn btn-primary mt-2 mt-xl-0">Current Rank<br>
                    <span class="badge badge-light">Silver Rank</span>
                    {{-- <span class="badge badge-light">{{ auth()->user()->rank }}</span> --}}
                </button>
            </div>
        </div>

       {{--  <div class="card card_container">

            <?php
                $i=0;
                $id = [$tree->user_id];
                for ($i; $i <= 3; $i++ ) { 
                    $divider = pow(2, $i);
                    $temp_index = 0;
            ?>

            <div class="row text-center justify-content-center llll ">
                <?php 
                    for ($j=0; $j < $divider; $j++) { 
                         
                ?>


                @if ($divider == 1)
                    <div class="w-<?= $divider ?>">
                     
                        @php echo showSingleUserInTree($id[$j]); @endphp
                    </div>
                @elseif ($divider == 2)
                    <div class="w-<?= $divider ?>">
                        @php echo showSingleUserInTree($id[$j]); @endphp
                    </div>
                @elseif ($divider == 4)
                    <div class="w-<?= $divider ?>">
                        @php echo showSingleUserInTree($id[$j]); @endphp
                    </div>
                @elseif ($divider == 8)
                    <div class="w-<?= $divider ?>">
                        @php echo showSingleUserInTree($id[$j]); @endphp
                    </div>
                @else
                    <div class="w-<?= $divider ?>">
                        @php echo showSingleUserInTree($id[$j]); @endphp
                    </div>
                @endif



                <?php
                    $temp_id;
                    $showId = $id[$j];
                    for ($k=0; $k < 2; $k++) { 
                        $temp_id[$temp_index] = getPositionUserSide($showId, $k);
                        $temp_index++;
                    }
                }
                $id = $temp_id;
                ?>

            </div>

            <?php } ?> 
    </div> --}}
    <div class="card card_container">
        <div class="row text-center justify-content-center llll">
            <!-- <div class="col"> -->
            <div class="w-1">
                @php echo showSingleUserinTree($tree['a']); @endphp
            </div>
        </div>
        <div class="row text-center justify-content-center llll">
            <!-- <div class="col"> -->
            <div class="w-2">
                @php echo showSingleUserinTree($tree['b']);  @endphp
            </div>
            <!-- <div class="col"> -->
            <div class="w-2 ">
                @php echo showSingleUserinTree($tree['c']); @endphp
            </div>
        </div>
        <div class="row text-center justify-content-center llll">
            <!-- <div class="col"> -->
            <div class="w-4 ">
                @php echo showSingleUserinTree($tree['d']); @endphp
            </div>
            <!-- <div class="col"> -->
            <div class="w-4 ">
                @php echo showSingleUserinTree($tree['e']); @endphp
            </div>
            <!-- <div class="col"> -->
            <div class="w-4 ">
                @php echo showSingleUserinTree($tree['f']); @endphp
            </div>
            <!-- <div class="col"> -->
            <div class="w-4 ">
                @php echo showSingleUserinTree($tree['g']); @endphp
            </div>
            <!-- <div class="col"> -->

        </div>
        <div class="row text-center justify-content-center llll">
            <!-- <div class="col"> -->
            <div class="w-8">
                @php echo showSingleUserinTree($tree['h']); @endphp
            </div>
            <!-- <div class="col"> -->
            <div class="w-8">
                @php echo showSingleUserinTree($tree['i']); @endphp
            </div>
            <!-- <div class="col"> -->
            <div class="w-8">
                @php echo showSingleUserinTree($tree['j']); @endphp
            </div>
            <!-- <div class="col"> -->
            <div class="w-8">
                @php echo showSingleUserinTree($tree['k']); @endphp
            </div>
            <!-- <div class="col"> -->
            <div class="w-8">
                @php echo showSingleUserinTree($tree['l']); @endphp
            </div>
            <!-- <div class="col"> -->
            <div class="w-8">
                @php echo showSingleUserinTree($tree['m']); @endphp
            </div>
            <!-- <div class="col"> -->
            <div class="w-8">
                @php echo showSingleUserinTree($tree['n']); @endphp
            </div>
            <!-- <div class="col"> -->
            <div class="w-8">
                @php echo showSingleUserinTree($tree['o']); @endphp
            </div>


        </div>
    </div> 

    <!-- Large Modal -->
    <div class="modal" id="modaldemo3">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Large Modal</h6><button aria-label="Close" class="close"
                        data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <h6>Modal Body</h6>
                    <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur
                        magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
                </div>
                <div class="modal-footer">
                    <button class="btn ripple btn-primary" type="button">Save changes</button>
                    <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!--End Large Modal -->

    <div class="modal fade user-details-modal-area" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">@lang('User Details')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="@lang('Close')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="user-details-modal">
                        <div class="user-details-header ">
                            <div class="thumb"><img src="#" alt="*" class="tree_image w-h-100-p"></div>
                            <div class="content">
                                <a class="user-name tree_url tree_name" href=""></a>
                                <span class="user-status tree_status"></span>
                                <span class="user-status tree_plan"></span>
                            </div>
                        </div>
                        <div class="user-details-body text-center">

                            <h6 class="my-3">@lang('Referred By'): <span class="tree_ref"></span></h6>


                            <table class="table table-bordered">
                                <tr>
                                    <th>&nbsp;</th>
                                    <th>@lang('LEFT')</th>
                                    <th>@lang('RIGHT')</th>
                                </tr>

                                <tr>
                                    <td>@lang('Current PV')</td>
                                    <td><span class="lpv"></span></td>
                                    <td><span class="rpv"></span></td>
                                </tr>

                                <tr>
                                    <td>@lang('Free Member')</td>
                                    <td><span class="lfree"></span></td>
                                    <td><span class="rfree"></span></td>
                                </tr>
                                <tr>
                                    <td>@lang('Paid Member')</td>
                                    <td><span class="lpaid"></span></td>
                                    <td><span class="rpaid"></span></td>
                                </tr>
                                
                                {{-- <tr>
                                        <td>@lang('Check Dowline')</td>
                                        <td> 
                                             <a class="tree_url">
                                                <span class="tree_url"></span>
                                            </a>
                                        </td>
                                    </tr> --}}
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    </div>
@endsection
@push('scripts')
    <script>
        "use strict";
        (function($) {
            $('.showDetails').on('click', function() {
                var modal = $('#exampleModalCenter');

                $('.tree_name').text($(this).data('name'));
                $('.tree_url').attr({
                    "href": $(this).data('treeurl')
                });
                $('.tree_status').text($(this).data('status'));
                $('.tree_plan').text($(this).data('plan'));
                $('.tree_image').attr({
                    "src": $(this).data('image')
                });
                $('.user-details-header').removeClass('Paid');
                $('.user-details-header').removeClass('Free');
                $('.user-details-header').addClass($(this).data('status'));
                $('.tree_ref').text($(this).data('refby'));
                $('.lpv').text($(this).data('lpv'));
                $('.rpv').text($(this).data('rpv'));
                $('.lfree').text($(this).data('lfree'));
                $('.rfree').text($(this).data('rfree'));
                $('.lpaid').text($(this).data('lpaid'));
                $('.rpaid').text($(this).data('rpaid'));
                $('.rfree').text($(this).data('rfree'));
                $('.lRef').attr({
                    "value": $(this).data('leftref')
                });
                $('.rRef').attr({
                    "value": $(this).data('rightref')
                });
                // $('.lRef').attr({
                //     "href": $(this).data('leftref')
                // });
                // $('.rRef').attr({
                //     "href": $(this).data('rightref')
                // });
                // $(".lRef").text($(this).data('leftref'));
                // $(".rRef").text($(this).data('rightref'));

                $('#exampleModalCenter').modal('show');
            });
        })(jQuery);
    </script>
    <script>
        'use strict';
        (function($) {
            document.body.addEventListener('click', copy, true);

            function copy(e) {
                var
                    t = e.target,
                    c = t.dataset.copytarget,
                    inp = (c ? document.querySelector(c) : null);
                if (inp && inp.select) {
                    inp.select();
                    try {
                        document.execCommand('copy');
                        inp.blur();
                        t.classList.add('copied');
                        setTimeout(function() {
                            t.classList.remove('copied');
                        }, 1500);
                    } catch (err) {
                        alert(`@lang('Please press Ctrl/Cmd+C to copy')`);
                    }
                }
            }
        })(jQuery);
    </script>
@endpush
