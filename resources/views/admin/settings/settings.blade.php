@extends('layouts.admin.master')
@section('content')

<!-- Topbar Start -->
@include('layouts.admin.blocks.inc.topnavbar')
<!-- end Topbar -->

<style>
    .home_table .form_search_vt {
        min-width: 190px;
        float: right;
        margin-right: 314px;
        margin-top: -101px;
        border-radius: 100px;
        overflow: hidden;
}

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

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
        color: #fff;
    }
    .dataTables_wrapper .dataTables_filter input{
        padding: 5px 8px !important;
        border-radius: 0 !important;
    }
    table.dataTable tbody th, table.dataTable tbody td {
        padding: 8px 18px !important;
    }
    .dt-button {
        background-color: #e02329 !important;
        color: white;
    }
</style>
<!-- Start Content-->
<div class="container-fluid mt-3">
{{-- @include('admin.alert-message')--}}

    <div class="row">
        <div class="col-xl-3">
            <div class="page_left_bar">
                <a href="{{route('settings.category')}}">Shipment</a>
                <a href="{{route('settings.make')}}"> Make</a>
                <a class="active" href="{{route('settings')}}"> Model</a>
                 <a href="{{route('settings.feature')}}"> Features </a>
               <a href="{{route('settings.fuel')}}"> Fuel Types </a>
            </div>
            <!-- <span data-href="/Database/Backup" id="export" class="btn btn-success btn-sm" onclick ="dbBackup(event.target);">Database Backup</span> -->
            <!-- <button type="button" class="custom_btn_create_vt" onclick="deleteRecords()">Delete All Records</button> -->
        </div>
        <div class="col-xl-9 home_custome_table">
            <div class="card-box home_table">
                <h4 class="header-title_vt mb-3 pl-2">Model</h4>
                <div class="card_tabs_vt">
{{--                <div class="form_search_vt">--}}
{{--                        <input type="text" placeholder="Search Model by Name" onkeyup="searchModel(this.value);"--}}
{{--                               class="form-control">--}}
{{--                    </div>--}}
                    <ul class="nav nav-tabs nav-bordered">
                        <li class="nav-item">
                            <a href="#home-b1" data-toggle="tab" aria-expanded="false" class="nav-link active" id="editUnit2">
                                All Model
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#profile-b1" data-toggle="tab" aria-expanded="true" class="nav-link " id="editUnit1">
                                Add Model
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane show active" id="home-b1">
                            <div class="table-responsive">
                                <table
                                    id="datatable_hybrid2"
                                    class="table table-borderless table-hover table-centered m-0">
{{--                                <table class="table table-borderless table-hover table-centered m-0">--}}
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Sr</th>
                                            <th>Model name</th>
                                            <th>Model code</th>
                                            <th>Make</th>
                                            <th>Image</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="modeltable">
                                    @foreach($model as $key => $models)
                                        <tr>
                                            <td>
                                                {{$key+1}}
                                            </td>
                                            <td>
                                                <a href={{url('model-details/'.$models->id)}}>{{$models->model_name}}</a>
                                            </td>
                                            <td>
                                                {{$models->model_code}}
                                            </td>
                                            <td>
                                                {{$models->make}}
                                            </td>
                                            <td>
                                                <div class="img_table">
                                                    <img  src="{{$models->image}}" alt="{{$models->image}}">
                                                </div>
                                            </td>
                                            <td>
                                                {{$models->is_active == 1 ? 'Active' : 'InActive'}}
                                            </td>
                                            <td>
                                                <div class="btn-group mb-2">
                                                    <button type="button" class="btn btn_info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <i class="mdi mdi-chevron-down"></i></button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" onclick="editModel({{$models->id}},{{json_encode($models->model_name)}},{{json_encode($models->model_code)}},{{json_encode($models->is_active)}},{{json_encode($models->image)}},{{json_encode($models->make)}})">Edit</a>
                                                        <button type="button" class="dropdown-item deleteUnit" data-toggle="modal" data-target=".model-delete" data-id="{{$models->id}}">Delete</button>
                                                    </div>
                                                </div><!-- /btn-group -->
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
{{--                            @if($model)--}}
{{--                                {!! $model->render() !!}--}}
{{--                            @endif--}}
                        </div>
                        <div class="tab-pane" id="profile-b1">
                            <form class="card p-2" method="post" action="{{route('add.settings',['makeId' => $modelId])}}" enctype="multipart/form-data" id="modelForm">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="page_head_vt" id="unit-label">Create Model</h3>
                                    </div>
                                    <div class="col-md-12" id="adminProfilePic">
                                        <div class="formgroup_vt">
                                            <img src="{{asset('assets/images/parts.png')}}" alt=""
                                                 id="modelImage">
                                            <span >
                                                     <i class="fas fa-pen modelImageUpload1122" type="file" >
                                                     </i>
                                                     </span>
                                            <input style="display: none" type="file" name="model_image" id="imageUploadInput">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="make-id">Make<span class="star_vt">*</span></label>
                                            <select class="form-control" id="make-id" name="make_id">
                                                @foreach($make as $key => $makes)
                                                    <option value='{{$makes->id}}'>{{$makes->make}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                     <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="model_code">Model code<span class="star_vt">*</span></label>
                                            <input class="form-control" type="text" id="model_code" required="" placeholder="Enter model code" name="model_code">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="model_name">Model name<span class="star_vt">*</span></label>
                                            <input class="form-control" type="text" id="model_name" required="" placeholder="Enter model name" name="model_name">
                                        </div>
                                    </div>
                                   
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="model-status">Status<span class="star_vt">*</span></label>
                                            <select class="form-control" name="status" id="model-status">
                                                <option value="1">Active</option>
                                                <option value="0">InActive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-10"></div>
                                    <div class="col-md-2">
                                        <div class="form-group mb-0 text-center">
                                            <button class="btn btn_btn_vt" type="submit" id="submitBtn"> Add </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

</div> <!-- container -->
<div class="modal fade model-delete deleteModal" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <input type="hidden" id="dltUserID">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <i class="fas fa-exclamation"></i>
                <h4 class="model-heading-vt">Are you sure to delete <br>this Model ?</h4>
                <div class="modal-footer">
                    <button type="button" class="btn_create_vt" onclick="deleteModelData()" >Yes, Delete</button>
                    <button type="button" class="btn_close_vt" data-dismiss="modal" id="model-cancel">Close</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    $(".modelImageUpload1122").click(function () {
        $("input[type='file']").trigger('click');
    });
    $('input[type="file"]').on('change', function() {
        var val = $(this).val();
        var file = $("input[type=file]").get(0).files[0];

        if(file){
            let reader = new FileReader();

            reader.onload = function(){
                document.getElementById('modelImage').style.display = 'block';
                document.getElementById('modelImage').setAttribute('src', reader.result);
            }

            reader.readAsDataURL(file);
        }
    });
    function deleteModelData()
    {
        var id = $('.deleteModal #dltUserID').val();
        $.ajax({
            url: '{{route('delete.model')}}',
            type: 'post',
            data: {"_token": "{{csrf_token()}}", 'id': id},
            dataType: 'json',
            success: function (response) {
                if (response.status) {
                    swal("Model Deleted Successfully!");
                    document.getElementById('model-cancel').click();
                    window.location.reload();
                } else {
                    swal("Model could not be  deleted!");
                    document.getElementById('model-cancel').click();
                    window.location.reload();
                }

            }
        });
    };
    function editModel(id,model, model_code,status,image,modelMake) {
        console.log(status);
        document.getElementById('home-b1').style.display = 'none';
        document.getElementById('profile-b1').style.display = 'block';
        document.getElementById('editUnit1').classList.add("active");
        document.getElementById('editUnit1').innerHTML = '';
        document.getElementById('submitBtn').innerHTML = '';
        document.getElementById('modelImage').style.display = 'block';
        document.getElementById('modelImage').setAttribute('src', image);
        document.getElementById('editUnit1').textContent = 'Update Model';
        document.getElementById('submitBtn').textContent = 'Update';
        document.getElementById('editUnit2').classList.remove("active");
        document.getElementById('unit-label').innerHTML = '';
        document.getElementById('unit-label').textContent = 'Update Model';
        document.querySelector('#model_name').value = model;
        document.querySelector('#model_code').value = model_code;
        let make = document.getElementById('make-id').children;
        for (let i = 0; i < make.length; i++) {
            if (make[i].innerHTML === modelMake) {
                make[i].selected = true;
            }
        }
        if(status === 1 || status === '1')
        {
            status = 'Active';
        }
        else
        {
            status = 'InActive';
        }
        console.log(status);
        let modelStatus = document.getElementById('model-status').children;
        for (let i = 0; i < modelStatus.length; i++) {
            if (modelStatus[i].innerHTML === status) {
                modelStatus[i].selected = true;
            }
        }
        document.getElementById('editUnit2').setAttribute('onclick', 'editAdminUnit()');
        let url = '{{ url("/settings/add", ":modelId") }}';
        url = url.replace('%3AmodelId', id);
        document.getElementById('modelForm').setAttribute('action', url);
    }

    function editAdminUnit() {
        window.location.reload()
    }
    $('.deleteUnit').click(function () {
        let data = $(this).attr('data-id');
        $('.deleteModal #dltUserID').val(data);

    });
    function deleteRecord() {

        // let id = $('.deleteModal #dltUserID').val();
        $.ajax({
            url: '{{route('settings.delete')}}',
            type: 'post',
            data: {"_token": "{{csrf_token()}}"},
            dataType: 'json',
            success: function (response) {
                console.log(response.status);
                if(response.status)
                {
                    swal("All Record deleted successfully!");
                    // document.getElementById('unit-cancel').click();
                    setTimeout(function(){ window.location.reload() }, 1000);
                }else
                {
                    swal("Record could not be  deleted!");
                    // document.getElementById('unit-cancel').click();
                    setTimeout(function(){ window.location.reload() }, 1000);
                }

            }
        });
    }


    function searchModel(value) {
        if (value) {
            let type = '';
            $.ajax({
                url: '{{route('model.search')}}',
                type: 'get',
                data: {
                    'value': value
                },
                dataType: 'json',
                success: function(response) {
                    let data = response.data;
                    console.log(data);
                    let status;
                    document.getElementById('modeltable').innerHTML = '';

                                            // var id = data[i]['id'];
                                            // let modelname = data[i]['model_name'].toString();
                                            // let makename = data[i]['make'].toString();
                                            // let image = data[i]['image'].toString();
                                            // let status = data[i]['is_active'].toString();

                    for (let i = 0; i < data.length; i++) {
                        console.log(data[i]);
                        // document.getElementById('buyersData').innerHTML = '';

                        if(data[i]['is_active'] == 1){
                            status = "Active";
                        }else{
                             status = "InActive";

                        }

                        if (data[i]['model_name']) {
                            let id = data[i]['id'];
                            let tableBody =
                             `<tr>
                                     <td>
                                        ${id + 1}
                                    </td>
                                    <td>
                                        ${data[i]['model_name']}
                                    </td>
                                    <td>
                                        ${data[i]['model_code']}
                                    </td>
                                    <td>
                                     ${data[i]['make']}
                                    </td>
                                    <td>
                                    <a href="">
                                                        <img src="${data[i]['image']}" alt="">
                                    </a>
                                    </td>
                                    <td>
                                     ${status}
                                    </td>
                                    <td>
                                        <div class="btn-group mb-2">
                                            <button type="button" class="btn btn_info dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">Action <i
                                                    class="mdi mdi-chevron-down"></i></button>
                                            <div class="dropdown-menu">
                                             <a class="dropdown-item" data-toggle="modal"
                                                        data-target=".bs-example-modal-center12"
                                                        data-id="${data[i]['id']}"
                                                        onclick="editModel('${data[i]['id']}','${data[i]['model_name']}','${data[i]['model_code']}','${data[i]['is_active']}','${data[i]['image']}','${data[i]['make']}')" > Update</a>
                                                    <button type="button" class="dropdown-item deleteUnit"
                                                            data-toggle="modal"
                                                            data-target=".model-delete" data-id="${data[i]['id']}">Delete</button>
                                            </div>
                                        </div><!-- /btn-group -->
                                    </td>
                                </tr>`

                                $("#modeltable").append(tableBody);

                                $('.deleteUnit').click(function () {
                                let data = $(this).attr('data-id');
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

</script>
<script>
    function exportTasks(_this) {
      let _url = $(_this).data('href');
      window.location.href = _url;
   }
   function dbBackup(_this) {
      let _url = $(_this).data('href');
      window.location.href = _url;
   }

        ///datatable code.......


        $('#datatable_hybrid2').DataTable({
        "pageLength": 10,
        "bLengthChange": true,
        columnDefs: [
        {
        orderable: false,
        targets: [0, 1, 2, 3, 4, 5]
        },
        ],
        "info": false,
        "scrollX": true,
        initComplete: function() {
        count = 0;
        // var val = 'Select Ref No';
        this.api().columns([1]).every(function() {
        var title = this.header();

        title = $(title).html().replace(/[\W]/g, '-');
        var column = this;
        var select = $('<select id="' + title + '" class="select2" ></select>')
        .appendTo($(column.header()).empty())
        .on('change', function() {

        var data = $.map($(this).select2('data'), function(value, key) {
        return value.text ? '^' + $.fn.dataTable.util.escapeRegex(value.text) + '$' : null;
        });

        if (data.length === 0) {
        data = [""];
        }

        var val = data.join('|');

        column.search(val ? val : '', true, false).draw();
        });
        // console.log(select.html())
        // console.log(select)
        column.data().unique().sort().each(function(d, j) {
        // if(j === 0)
        // {
        //     select.append('<option value="' + val + '">' + val + '</option>');
        // }
        // else
        // {
        val = $('<div/>').html(d).text();
        select.append('<option value="' + val + '">' + val + '</option>');
        // }


        });

        $('#' + title).select2({
        multiple: true,
        closeOnSelect: false,
        placeholder: title,
        });
        // document.getElementsByClassName('select2-selection__choice__remove').remove();
        // console.log();
        // select.children()[0].css('display','none');
        $('.select2').val(null).trigger('change');
        });

        this.api().columns([2,4]).every(function(d) {
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
        },
        // dom: 'Bfrtip',
        // buttons: [
        // {
        //         extend: 'excelHtml5',
        //         orientation: 'landscape',
        //         pageSize: 'LEGAL',
        //         exportOptions: {
        //             columns: [ 0, 1, 3 ]
        //         },
        //         text : "Download Excel"

        //     },
        //     {
        //         extend: 'csvHtml5',
        //         exportOptions: {
        //             columns: [ 0, 1, 2, 4 ],
        //             modifier : {
        //             // DataTables core
        //             // order : 'index', // 'current', 'applied',
        //             // //'index', 'original'
        //             // page : 'all', // 'all', 'current'
        //             search : 'none' // 'none', 'applied', 'removed'
        //         }
        //         },
        //         text : "Download CSV"
        //     },
        //     {
        //         extend: 'pdfHtml5',
        //         customize: function(doc) {
        //             console.dir(doc)
        //             doc.content[1].margin = [ 150, 0, 100, 0 ],
        //             doc.styles.tableHeader.alignment = 'left',
        //             doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('')
        //         },
        //         exportOptions: {
        //             columns: [ 0, 1, 2 ],
        //             modifier : {
        //             // DataTables core
        //             order : 'index', // 'current', 'applied',
        //             //'index', 'original'
        //             page : 'all', // 'all', 'current'
        //             search : 'none' // 'none', 'applied', 'removed'
        //         }
        //         },
        //         text : "Download PDF"
        //     }

        // ]
        });

</script>
<script>
            $(document).ready(function () {

                $(".select2_demo_2").select2({
                    theme: 'bootstrap4',
                });
                // $('.select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice:first-child').html('Select Ref No')

            });

</script>
@endsection
