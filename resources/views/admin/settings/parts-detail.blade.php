@extends('layouts.admin.master')
@section('content')
<style>
table#datatable_hybrid2 {
    width: 1100px !important;
}

select {
    word-wrap: normal;
    border: 1px solid #ced4da !important;
}

.select2-container .select2-selection--multiple .select2-selection__choice {
    background-color: #e02329 !important;
}

.select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice {
    color: #ffffff !important;
    border: 1px solid #e02329;
}

.select2-container--default .select2-results__option[aria-selected=true]:hover {
    background-color: #e02329;
    color: #fff;
}

.select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: #e02329;
}

span.select2.select2-container.select2-container--bootstrap4 {
    display: none;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
    color: #fff;
}

.dataTables_wrapper .dataTables_filter input {
    padding: 5px 8px !important;
    border-radius: 0 !important;
}

/*select.form-control {*/
/*    text-transform: capitalize;*/
/*    max-width: 150px;*/
/*}*/
/*select#Part-No {*/
/*    display: none;*/
/*}*/
</style>
<!-- Topbar Start -->
@include('layouts.admin.blocks.inc.topnavbar')
<!-- end Topbar -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

<!-- Start Content-->
<div class="container-fluid mt-3">
    @include('admin.alert-message')
    <div class="row">
        <div class="col-xl-3">
            @if(Request::path() === "show-trending")
            <div class="page_left_bar">
                <a href="{{route('sellers.parts')}}"> All Parts </a>
                <a href="{{route('sellers.parts.add')}}"> Add Part</a>
                <a class="active" href="{{route('show.trends')}}"> Top Trending Part </a>
            </div>
            @else
            <div class="page_left_bar">
                <a href="{{route('settings.category')}}"> Categories </a>
                <a href="{{route('settings.make')}}"> Make</a>
                <a class="active" href="{{route('settings')}}"> Model</a>
                <a href="{{route('settings.files')}}"> Files</a>

            </div>
            @endif
        </div>
        <div class="col-xl-9 home_custome_table">
            <div class="card-box">
                @if(Request::path() === "show-trending")
                <h4 class="header-title_vt mb-3 pl-2">Top Trending Cars</h4>
                @else
                <h4 class="header-title_vt mb-3 pl-2">Cars Listing</h4>
                @endif

                <div class="table-responsive">
                    <table id="datatable_hybrid2" class="table table-borderless table-hover table-centered m-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Sr</th>
                                <th>Part No</th>
                                <th>Make</th>
                                <th>Manufacturer</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Image</th>
                                <th>Action</th>
                                @if(Request::path() === "show-trending")
                                <th>Remove</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody id="buyersData">
                            @foreach($parts as $key => $part)
                            @if($part->ref_no)
                            <tr>
                                <td>
                                    {{$key + 1}}
                                </td>
                                <td onclick='window.open("{{ url('/parts/part-details/'.$part->id)}}")'
                                    style="cursor: pointer">
                                    {{$part->ref_no}}
                                </td>
                                <td onclick='window.open("{{ url('/parts/part-details/'.$part->id)}}")'
                                    style="cursor: pointer">
                                    {{$part->make}}
                                </td>
                                <td onclick='window.open("{{ url('/parts/part-details/'.$part->id)}}")'
                                    style="cursor: pointer">
                                    {{$part->manufactureName}}
                                </td>
                                <td onclick='window.open("{{ url('/parts/part-details/'.$part->id)}}")'
                                    style="cursor: pointer">
                                    {{$part->category}}
                                </td>
                                <td onclick='window.open("{{ url('/parts/part-details/'.$part->id)}}")'
                                    style="cursor: pointer">
                                    {{$part->price}}
                                </td>
                                <td>
                                    @if(!empty($part->images))
                                    @foreach($part->images as $key => $image)
                                    <a>
                                        <img src="{{$image->image}}" alt="">

                                        {{--                                                        {{$image->image}}--}}
                                    </a>
                                    @endforeach
                                    @else
                                    <a><img src="{{asset('images/defaultImages/partsimage.png')}}" alt=""></a>

                                    @endif
                                </td>
                                {{--                                        </div>--}}
                                <td>
                                    <div class="btn-group mb-2">
                                        <button type="button" class="btn btn_info dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <i
                                                class="mdi mdi-chevron-down"></i></button>
                                        <!--                                                --><?php //$status = $user->status = 'Y' ? 'Active' : 'Inactive' ?>
                                        <div class="dropdown-menu">
                                            {{--                                                    onclick="window.location='{{route('company.user', ['id' => $user->id])}}'"--}}
                                            {{--                                                    data-id="{{$user->id}}--}}
                                            {{--                                                    onclick="editBuyer({{$user->id}},{{json_encode($user->username)}},{{json_encode($user->email)}},{{json_encode($user->phone)}},{{json_encode($user->image)}},{{json_encode($status)}})"--}}
                                            <a class="dropdown-item"
                                                onclick='window.open("{{ url('/add-parts/'.$part->id)}}")'>Edit</a>
                                            <button type="button" class="dropdown-item deleteParts" data-toggle="modal"
                                                data-target=".parts-list-details" data-id="{{$part->id}}">Remove Part
                                                Model
                                            </button>
                                        </div>
                                    </div><!-- /btn-group -->
                                </td>
                                @if(Request::path() === "show-trending")
                                <td>
                                    <button type="button"
                                        onclick="window.location='{{route('delete.trends', ['partId' => $part->id])}}'">Remove</button>
                                </td>
                                @endif
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                    {{--                        @if($parts)--}}
                    {{--                            {!! $parts->render() !!}--}}
                    {{--                        @endif--}}

                </div>
            </div> <!-- end col -->
        </div>
        <!-- end row -->

    </div> <!-- container -->
    <div class="modal fade parts-list-details deleteModal" tabindex="-1" role="dialog"
        aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <input type="hidden" id="dltUserID">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <i class="fas fa-exclamation"></i>
                    <h4 class="model-heading-vt">Are you sure to remove this part from the Modal?</h4>
                    <div class="modal-footer">
                        <button type="button" class="btn_create_vt" onclick="deletePartsData()">Yes, Remove</button>
                        <button type="button" class="btn_close_vt" data-dismiss="modal" id="user-cancel123">Close
                        </button>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script type="text/javascript">
    $('.deleteParts').click(function() {
        var data = $(this).attr('data-id');
        $('.deleteModal #dltUserID').val(data);

    });

    function deletePartsData() {
        var id = $('.deleteModal #dltUserID').val();
        var model_id = {
            !!$model_id!!
        };
        $.ajax({
            url: '{{route('delete.part.modal')}}',
            type: 'post',
            data: {
                "_token": "{{csrf_token()}}",
                'id': id,
                'modelID': model_id
            },
            dataType: 'json',
            success: function(response) {
                if (response.status == true) {
                    swal("Part Removed Successfully!");
                    document.getElementById('user-cancel123').click();
                    window.location.reload();
                } else if (response.status == false) {
                    swal({
                        text: "Sorry! This part has only one model. It can't be removed!",
                        timer: 5000,
                    });
                    document.getElementById('user-cancel123').click();
                    // window.location.reload();
                } else {
                    swal("The part has only one modal");
                    document.getElementById('user-cancel123').click();
                    window.location.reload();
                }

            }
        });
    };

    function searchData(value) {
        if (value) {
            let type = '';
            $.ajax({
                url: '{{route('parts.search')}}',
                type: 'get',
                data: {
                    'value': value
                },
                dataType: 'json',
                success: function(response) {
                    let data = response.parts.data;
                    // console.log(data);
                    document.getElementById('buyersData').innerHTML = '';
                    for (let i = 0; i < data.length; i++) {
                        var PartImage = '{{ route("company.profile", ":id") }}';
                        PartImage = PartImage.replace(':id', data[i]['id']);
                        var EditPart = '{{ route("sellers.parts.add", ":id") }}';
                        EditPart = EditPart.replace(':id', data[i]['id']);
                        var PartDetail = '{{ route("sellers.parts.details", ":id") }}';
                        PartDetail = PartDetail.replace(':id', data[i]['id']);

                        if (data[i]['id']) {
                            let id = data[i]['id'];
                            // console.log(id);
                            // console.log(data[i].images);
                            let tableBody = `<tr>
                                    <td>
                                       ${id + 1}
                                    </td>
                                    <td>
                                    <a class="dropdown-item" onclick="window.location='${PartDetail}'">${data[i]['ref_no']}</a>
                                    </td>
                                    <td>
                                    <a class="dropdown-item" onclick="window.location='${PartDetail}'">${data[i]['make']}</a>
                                    </td>
                                    <td>
                                    <a class="dropdown-item" onclick="window.location='${PartDetail}'">${data[i]['manufactureName']}</a>
                                    </td>
                                    <td>
                                    <a class="dropdown-item" onclick="window.location='${PartDetail}'">${data[i]['category']}</a>
                                    </td>
                                    <td>
                                    <a class="dropdown-item" onclick="window.location='${PartDetail}'">${data[i]['price']}</a>
                                    </td>
                                    if(data[i].images[i].image){
                                    <td>
                                        <a href="${PartDetail}">
                                        </a>
                                    </td>
                                    }
                                    else{
                                        <td>
                                            <a href="${PartDetail}">
                                                <img src="${data[i]['categoryImage']}" alt="">
                                            </a>
                                        </td>
                                    }
                                    <td>
                                        <div class="btn-group mb-2">
                                        <button type="button" class="btn btn_info dropdown-toggle"data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <i class="mdi mdi-chevron-down"></i></button>
                                        <div class="dropdown-menu">
                                        <a class="dropdown-item" onclick="window.location='${EditPart}'">Edit</a>
                                         <button type="button" class="dropdown-item deleteParts" data-toggle="modal" data-target=".parts-list-details" data-id="${data[i]['id']}">Delete</button>
                                        </div>
                                        </div><!-- /btn-group -->
                                    </td>
                                    </tr>`
                            $("#buyersData").append(tableBody);
                            $('.deleteParts').click(function() {
                                var data = $(this).attr('data-id');
                                $('.deleteModal #dltUserID').val(data);
                            });
                        }
                    }
                },

            });
        } else {
            window.location.reload()
        }
    }

    ///datatable code.......


    $('#datatable_hybrid2').DataTable({
        "pageLength": 10,
        "bLengthChange": true,
        columnDefs: [{
            orderable: false,
            targets: [0, 1, 2, 3, 4, 5]
        }, ],
        "info": false,
        "scrollX": true,
        initComplete: function() {
            count = 0;
            this.api().columns([1]).every(function() {
                var title = this.header();

                title = $(title).html().replace(/[\W]/g, '-');
                var column = this;
                var select = $('<select id="' + title +
                        '" class="select2_demo_2 form-control" ></select>')
                    .appendTo($(column.header()).empty())
                    .on('change', function() {

                        var data = $.map($(this).select2('data'), function(value, key) {
                            return value.text ? '^' + $.fn.dataTable.util.escapeRegex(
                                value.text) + '$' : null;
                        });

                        if (data.length === 0) {
                            data = [""];
                        }

                        var val = data.join('|');

                        column.search(val ? val : '', true, false).draw();
                    });

                column.data().unique().sort().each(function(d, j) {
                    var val = $('<div/>').html(d).text();
                    select.append('<option value="' + val + '">' + val + '</option>');
                });

                $('#' + title).select2({
                    multiple: true,
                    closeOnSelect: false,
                    placeholder: title,
                });

                $('.select2_demo_2 form-control').val(null).trigger('change');
            });

            this.api().columns([2, 3, 4, 5]).every(function(d) {
                var column = this;
                var theadname = $("#datatable_hybrid2 th").eq([d]).text();
                var select = $('<select><option value="">' + theadname + "</option></select>")
                    .appendTo($(column.header()).empty())
                    .on('change', function() {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );

                        column
                            .search(val ? '^' + val + '$' : '', true, false)
                            .draw();
                    });

                column.data().unique().sort().each(function(d, j) {
                    var val = $('<div/>').html(d).text();
                    select.append('<option value="' + val + '">' + val + '</option>');
                });
            });
        }
    });
    </script>

    <!-- <link href="{{ asset('assets/css/css/select2/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/css/select2/select2.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/css/select2/select2-bootstrap4.min.css') }}" rel="stylesheet"> -->

    <!-- <script src="{{ asset('assets/css/css/select2/jquery-3.1.1.min.js') }}"></script> -->
    <!-- <script src="{{ asset('assets/css/css/select2/select2.full.min.js') }}"></script> -->
    <script>
    $(document).ready(function() {

        $(".select2_demo_2").select2({
            theme: 'bootstrap4',
        });


    });
    </script>

    @endsection