@extends('layouts.admin.master')
@section('content')
    <!-- Topbar Start -->
    @include('layouts.admin.blocks.inc.topnavbar')
    <style>
        table#datatable_hybrid2 {
            width: 1100px !important;
        }

        select {
            word-wrap: normal;
            border: 1px solid #ced4da !important;
            padding: 7px;
            border-radius: 4px;
        }

        .select2-container .select2-selection--multiple .select2-selection__choice {
            background-color: #e02329 !important;
        }

        .select2-container .select2-search--inline .select2-search__field {
            box-sizing: border-box;
            border: none;
            font-size: 100%;
            margin-top: 8px;
            padding: 0;
        }

        .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice {
            color: #ffffff !important;
            border: 1px solid #e02329;
        }

        .form-control:disabled, .form-control[readonly] {
            background-color: rgb(221 221 223 / 48%) !important;
        }
        /* .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice:first-child{
                                               background: #FFF !important;
                                                color: #000 !important;
                                                border: none !important;
                                                margin-top: 8px !important;
                                                font-weight: 400 !important;
                                            }
                                            .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice .select2-selection__choice__remove:first-child{
                                                display: none;
                                            }
                                            .select2-container--default .select2-results__option[aria-selected=true]:hover {
                                                background-color: #e02329;
                                                color: #fff;
                                            }

                                            .select2-container--default .select2-results__option--highlighted[aria-selected] {
                                                background-color: #e02329;
                                            }*/
        span.select2.select2-container.select2-container--bootstrap4 {
            display: none;
        }

        */ .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
            color: #fff;
        }

        .dataTables_wrapper .dataTables_filter input {
            padding: 5px 8px !important;
            border-radius: 0 !important;
        }

        table.dataTable tbody th,
        table.dataTable tbody td {
            padding: 8px 18px !important;
        }

        /*select.form-control {*/
        /*    text-transform: capitalize;*/
        /*    max-width: 150px;*/
        /*}*/
        /*select#Part-No {*/
        /*    display: none;*/
        /*}*/
    </style>
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-xl-3">
                <div class="page_left_bar">
                    <a href="{{ route('sellers.parts') }}"> All Cars </a>
                    <a href="{{ route('sellers.parts.add') }}"> Add Car</a>
                    <!-- <a href="{{ route('sellers.parts.export') }}"> Export Car</a> -->
                    <a class="active" href="{{ route('trends.parts') }}"> Top Featured Cars</a>


                </div>
            </div>

            <div class="col-xl-9 home_custome_table">
                <div class="card-box">
                    <div class="col-xl-12 home_custome_table">
                        <div class="card-box home_table">
                            <h4 class="header-title_vt mb-3 pl-2">Featured Cars</h4>
                            <div class="card_tabs_vt">
                                <ul class="nav nav-tabs nav-bordered" id="addAds">
                                    <li class="nav-item">
                                        <a href="#profile-b1" data-toggle="tab" aria-expanded="false"
                                            class="nav-link  active" id="createAd">
                                            Create Featured
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#home-b1" data-toggle="tab" aria-expanded="true" class="nav-link"
                                            id="adListing">
                                            All Featured
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane" id="home-b1">
                                        <div class="table-responsive">

                                            <table class="table table-borderless table-hover table-centered m-0">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Sr</th>
                                                        <th>Ref No</th>
                                                        <th>Make</th>
                                                        <th>Manufacturer</th>
                                                        <th>Start Date</th>
                                                        <th>End Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($featuredParts as $key => $part)
                                                        @if ($part->ref_no)
                                                            <tr>
                                                                <td>
                                                                    {{ $key + 1 }}
                                                                </td>
                                                                <td onclick="window.location='{{route('sellers.parts.details', ['partId' => $part->id])}}'" style="cursor: pointer">
                                                                    {{ $part->ref_no }}
                                                                </td>
                                                                <td onclick="window.location='{{route('sellers.parts.details', ['partId' => $part->id])}}'" style="cursor: pointer">
                                                                    {{ $part->make }}
                                                                </td>
                                                                <td onclick="window.location='{{route('sellers.parts.details', ['partId' => $part->id])}}'" style="cursor: pointer">
                                                                    {{ $part->manufacturer }}
                                                                </td>
                                                                <td onclick="window.location='{{route('sellers.parts.details', ['partId' => $part->id])}}'" style="cursor: pointer">
                                                                {{ $part->start_date }}
                                                                </td>
                                                                <td onclick="window.location='{{route('sellers.parts.details', ['partId' => $part->id])}}'" style="cursor: pointer">
                                                                    {{ $part->end_date }}
                                                                </td>
                                                                <td>
                                                                    <div class="btn-group mb-2">
                                                                        <button type="button"
                                                                            class="btn btn_info dropdown-toggle"
                                                                            data-toggle="dropdown" aria-haspopup="true"
                                                                            aria-expanded="false">Action <i
                                                                                class="mdi mdi-chevron-down"></i></button>
                                                                        <!--                                                --><?php //$status = $user->status = 'Y' ? 'Active' : 'Inactive'
                                                                        ?>
                                                                        <div class="dropdown-menu">

                                                                            <a class="dropdown-item" data-toggle="modal"
                                                                                data-target=".bs-example-modal-center12"
                                                                                data-id="{{ $part->id }}"
                                                                                onclick="editBuyer({{ $part->id }},{{ json_encode($part->ref_no) }},{{ json_encode($part->make) }},{{ json_encode(date('d-m-Y',strtotime($part->manufacturer))) }},{{ json_encode($part->start_date) }},{{ json_encode($part->end_date) }})">Edit</a>
                                                                            <button type="button " class="dropdown-item"
                                                                                onclick=deletepart('{{ $part->id }}')>Remove
                                                                           

                                                                                Featured</button>
                                                                        </div>
                                                                    </div><!-- /btn-group -->
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>


                                    {{-- The add trending section page 2 goes here --}}
                                    <div class="tab-pane show active" id="profile-b1">
                                        <div class="table-responsive">

                                            <table id="datatable_hybrid2"
                                                class="table table-borderless table-hover table-centered m-0">
                                                <div class="tab-content">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>Sr</th>
                                                            <th>Ref No</th>
                                                            <!-- <th>Reg no</th> -->
                                                            <th>Make</th>
                                                            <th>Manufacturer</th>
                                                            <th>Price</th>
                                                            <th>Action</th>
                                                            <th>Add Featured</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="buyersData">
                                                        @foreach ($parts as $key => $part)
                                                            @if ($part->ref_no)
                                                                <tr>
                                                                    <td id="parts-id" value='{{ $part->id }}'>
                                                                        {{ $key + 1 }}
                                                                    </td>
                                                                    <td onclick="window.location='{{route('sellers.parts.details', ['partId' => $part->id])}}'" style="cursor: pointer" id="part-reference" value='{{ $part->ref_no }}'>
                                                                        {{ $part->ref_no }}
                                                                    </td>
                                                                    <!-- <td id="part-regNo">
                                                                        {{ $part->reg_no }}
                                                                    </td> -->
                                                                    <td id="part-make" value='{{ $part->make }}'>
                                                                        {{ $part->make }}
                                                                    </td>
                                                                    <td id="part-manufactureName"
                                                                        value='{{ $part->manufacturer }}'>
                                                                        {{ $part->manufacturer }}
                                                                    </td>
                                                                    <!-- <td id="part-category" value='{{ $part->category }}'>
                                                                        {{ $part->category }}
                                                                    </td> -->
                                                                    <td id="part-price" value='{{ $part->price }}'>
                                                                        {{ $part->price }}
                                                                    </td>
                                                                    <td>
                                                                        <div class="btn-group mb-2">
                                                                            <button type="button"
                                                                                class="btn btn_info dropdown-toggle"
                                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                                aria-expanded="false">Action <i
                                                                                    class="mdi mdi-chevron-down"></i></button>
                                                                            <!--                                                --><?php //$status = $user->status = 'Y' ? 'Active' : 'Inactive'
                                                                            ?>
                                                                            <div class="dropdown-menu">

                                                                                <a class="dropdown-item"
                                                                                    onclick="window.location='{{ route('sellers.parts.add', ['partId' => $part->id]) }}'">Edit</a>
                                                                                <button type="button"
                                                                                    class="dropdown-item deleteParts"
                                                                                    data-toggle="modal"
                                                                                    data-target=".parts-list-details"
                                                                                    data-id="{{ $part->id }}">Delete
                                                                                </button>

                                                                            </div>
                                                                        </div><!-- /btn-group -->
                                                                    </td>
                                                                    <td>
                                                                        <button type="button" class="btn_info_romve mb-2"
                                                                            class="btn-class"
                                                                            onclick=addPart('{{ $part->id }}')><i
                                                                                class="fa fa-plus"></i></button>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                            </table>
                                        </div>
                                        <br>
                                        <h3 class="page_head_vt borde-top">Featured Cars</h3>
                                        <div class="table-responsive">
                                            <table class="table table-borderless table-hover table-centered m-0">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Sr</th>
                                                        <th>Part No</th>
                                                        <th>Make</th>
                                                        <th>Manufacturer</th>
                                                        <!-- <th>Category</th> -->
                                                        <th>Price</th>
                                                        <th>Remove</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="model-table99">
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="start_time">Start Date</label>
                                                    <input type="date" class="form-control" id="start-time"
                                                        placeholder="14 July, 2022" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="end_time">End Date</label>
                                                    <input type="date" class="form-control" id="end-time"
                                                        placeholder="20 July, 2022" required>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group flot-right">
                                                    <button class="btn_to_vt" type="button" onclick=savedata()> Save
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
            <!-- end row -->

        </div> <!-- container -->
        <div class="modal fade bs-example-modal-center12 deleteModal" tabindex="-1" role="dialog"
            aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-dialog-centered">
                <input type="hidden" id="dltUserID">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                        </button>
                    </div>
                    <form class="card p-2" method="post" action="" enctype="multipart/form-data" id="buyerForm">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12">
                                <h3 class="page_head_vt" id="adminHeading">Update Featured Cars</h3>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="adminEmail">Car</label>
                                    <input class="form-control" type="text" id="PartName" name="PartName"
                                    disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="adminEmail">Make</label>
                                    <input class="form-control" type="text" id="MakeName" name="MakeName"
                                    disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="adminEmail">Manufacture</label>
                                    <input class="form-control" type="text" id="manufacturer" name="manufacturer"
                                    disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="StartDate">Start-Date</label>
                                    <input class="form-control" type="date" id="StartDate" name="StartDate"
                                        required="" placeholder="Select New Date">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="EndDate">End-Date<span class="star_vt">*</span></label>
                                    <input class="form-control" type="date" id="EndDate" name="EndDate"
                                        required="" placeholder="Select New Date">
                                </div>
                            </div>
                            <div class="col-md-8"></div>
                            <div class="col-md-4">
                                <div class="form-group mb-0 text-center">
                                    <button class="btn btn_btn_vt" type="submit" id="submitButton"> Update
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>




    </div>


    <script type="text/javascript">
        var dataArray = [];
        var idArray = [];

        function addPart(id) {
            idArray.push(id);
            var ref = event.target.closest('tr').querySelector('#part-reference').innerText;
            var make = event.target.closest('tr').querySelector('#part-make').innerText;
            var manufacture = event.target.closest('tr').querySelector('#part-manufactureName').innerText;
            // var category = event.target.closest('tr').querySelector('#part-category').innerText;
            var price = event.target.closest('tr').querySelector('#part-price').innerText;

            dataArray.push({
                'parts-id': id,
                'part-reference': ref,
                'part-make': make,
                'part-manufactureName': manufacture,
                // 'part-category': category,
                'part-price': price
            });
            $('#model-table99').empty();
            for (let i = 0; i < dataArray.length; i++) {
                let tableData = ` <tr>
                                    <th scope="row">${i + 1}</th>
                                    <td>${dataArray[i]['part-reference']}</td>
                                    <td>${dataArray[i]['part-make']}</td>
                                    <td>${dataArray[i]['part-manufactureName']}</td>
                                    <td>${dataArray[i]['part-price']}</td>
                                    <td><i class="fa fa-times" onclick="deleteIndex(${i})" style="cursor: pointer"></i></td>
                                </tr>`;
                $('#model-table99').append(tableData);
            }
        }

        function deleteIndex(index) {
            dataArray.splice(index, 1);

            $('#model-table99').empty();
            for (let i = 0; i < dataArray.length; i++) {
                let tableData = ` <tr>
                    <th scope="row">${i + 1}</th>
                                    <td>${dataArray[i]['part-reference']}</td>
                                    <td>${dataArray[i]['part-make']}</td>
                                    <td>${dataArray[i]['part-manufactureName']}</td>
                                    // <td>${dataArray[i]['part-category']}</td>
                                    <td>${dataArray[i]['part-price']}</td>
                                    <td><i class="fa fa-times" onclick="deleteIndex(${i})" style="cursor: pointer"></i></td>
                                </tr>`;
                $('#model-table99').append(tableData);
            }
            // document.getElementById('model-parts-iddd').setAttribute('value', dataArray);
            // document.getElementById('model-parts-iddd').val(dataArray);
        }
        $('.deleteParts').click(function() {
            var data = $(this).attr('data-id');
            $('.deleteModal #dltUserID').val(data);

        });

        function savedata() {
            let startDate = document.getElementById('start-time').value;
            let endDate = document.getElementById('end-time').value;
            let id = idArray;
            $.ajax({
                type: "POST",
                url: '{{ route('add.trends') }}',
                data: {
                    "id": id,
                    "startDate": startDate,
                    "endDate": endDate,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(data) {
                    if (data) {
                        swal("Featured Part Added");
                        window.location.reload();
                    } else {
                        swal("Parts could not be  deleted!");

                    }
                }
            });
        }

        function deletepart(id) {
            $.ajax({
                type: "POST",
                url: '{{ route('delete.trends') }}',
                data: {
                    "id": id,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(data) {
                    if (data) {
                        swal("Featured Car has been removed");
                        window.location.reload();
                    } else {
                        swal("Cars could not be  deleted!");

                    }
                }
            });
        }
        ///datatable code.......

        $('#datatable_hybrid2').DataTable({
            "pageLength": 5,
            "bLengthChange": true,
            columnDefs: [{
                orderable: false,
                targets: [0, 1, 2, 3, 4, 5]
            }, ],
            "info": false,
            "scrollX": true,
            initComplete: function() {
                count = 0;
                // var val = 'Select Ref No';
                this.api().columns([1]).every(function() {
                    var title = this.header();
                    title = $(title).html().replace(/[\W]/g, '-');
                    var column = this;
                    var select = $('<select id="' + title + '" class="select2"></select>')
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
                        val = $('<div/>').html(d).text();
                        select.append('<option value="' + val + '">' + val + '</option>');
                    });

                    $('#' + title).select2({
                        multiple: true,
                        closeOnSelect: false,
                        placeholder: title,
                    });

                    $('.select2').val(null).trigger('change');
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
    <script>
        $(document).ready(function() {

            $(".select2_demo_2").select2({
                theme: 'bootstrap4',
            });
        });

        function editBuyer(id, part, make, manufacture, startDate, endDate) {
            console.log(id + part + make + manufacture + startDate + endDate);
            document.getElementById('PartName').value = part;
            document.getElementById('MakeName').value = make;
            document.getElementById('manufacturer').value = manufacture;
            document.getElementById('StartDate').value = startDate;
            document.getElementById('EndDate').value = endDate;
            let url = '{{ url('/top-trending/part/edit', ':id') }}';
                            url = url.replace('%3Aid', id);
                            document.getElementById('buyerForm').setAttribute('action', url);
        }
    </script>
@endsection
