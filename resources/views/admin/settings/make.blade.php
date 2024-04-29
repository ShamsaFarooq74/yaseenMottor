@extends('layouts.admin.master')
@section('content')
<!-- Topbar Start -->
@include('layouts.admin.blocks.inc.topnavbar')
<!-- end Topbar -->
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
    .dt-button{
        background-color: #e02329 !important;
    color: white;
    }
</style>

    <!-- Start Content-->
    <div class="container-fluid mt-3">
{{--        @include('admin.alert-message')--}}

        <div class="row">
            <div class="col-xl-3">
                <div class="page_left_bar">
                    <a href="{{route('settings.category')}}"> Shipment </a>
                    <a class="active" href="{{route('settings.make')}}"> Make</a>
                    <a href="{{route('settings')}}"> Model</a>
                     <a href="{{route('settings.feature')}}"> Features </a>
                     <a href="{{route('settings.fuel')}}"> Fuel Types </a>
                </div>
            </div>
            <div class="col-xl-9 home_custome_table subcata_vt">
                <div class="card-box home_table">
                    <h4 class="header-title_vt mb-3 pl-2">Make</h4>
                    <div class="card_tabs_vt">
                        <ul class="nav nav-tabs nav-bordered">
                            <li class="nav-item">
                                <a href="#home-b1" data-toggle="tab" aria-expanded="false" class="nav-link active" id="editSubCategory2">
                                    All Make
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#profile-b1" data-toggle="tab" aria-expanded="true" class="nav-link" id="editSubCategory1">
                                    Add Make
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane show active" id="home-b1">
                                <div class="table-responsive">
                                    <table id="datatable_hybrid2"
                                    class="table table-borderless table-hover table-centered m-0">
                                        <thead class="thead-light">
                                        <tr>
                                            <th>Sr</th>
                                            <th>Make</th>
                                            <th>Images</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                            
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($makes as $key => $make)
                                            <tr>
                                                <td>
                                                    {{$key + 1}}
                                                </td>
                                                <td>
                                                    {{$make->make}}
                                                </td>
                                                <td>
                                                    <div class="img_table">
                                                    <img  src="{{$make->logo}}" alt="{{$make->logo}}">
                                                    </div>
                                                </td>
                                                <td>
                                                    {{$make->is_active == 1 ? 'Active' : 'InActive'}}
                                                </td>
                                                <td>
                                                    <div class="btn-group mb-2">
                                                        <button type="button" class="btn btn_info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <i class="mdi mdi-chevron-down"></i></button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" onclick="editMake({{$make->id}},{{json_encode($make->make)}},{{json_encode($make->logo)}},{{json_encode($make->is_active)}})">Edit</a>
                                                            <button type="button" class="dropdown-item deleteSubCategory" data-toggle="modal" data-target=".make-delete" data-id="{{$make->id}}">Delete</button>
                                                        </div>
                                                    </div><!-- /btn-group -->
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            <div class="tab-pane" id="profile-b1">
                                <form class="card p-2" method="post" action="{{route('make.add',['makeId' => $makeId])}}" enctype="multipart/form-data" id="makeForm">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-12" id="adminProfilePic">
                                            <div class="formgroup_vt">
                                                <img src="{{asset('assets/images/parts.png')}}" alt=""
                                                     id="makeImage">
                                                <span >
                                                     <i class="fas fa-pen makeImageUpload1122" type="file" >
                                                     </i>
                                                     </span>
                                                <input style="display: none" type="file" name="make_image" id="imageUploadInput">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="make">Make<span class="star_vt">*</span></label>
                                                <input class="form-control" type="text" id="make" required=""
                                                       placeholder="Enter make" name="make" value="{{old('make')}}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="make-status">Status<span class="star_vt">*</span></label>
                                                <select class="form-control" id="make-status" name="status">
                                                    <option value="1">Active</option>
                                                    <option value="0">InActive</option>
                                                </select>
                                            </div>
                                        </div>
{{--                                        <div class="col-md-12">--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label for="exampleFormControlSelect1">Upload Image<span--}}
{{--                                                        class="star_vt">*</span></label>--}}
{{--                                                <div class="file-upload">--}}
{{--                                                    <input type="file" id="myFile" name="make_image" accept="image/*" required>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
                                        <div class="col-md-11"></div>
                                        <div class="col-md-1">
                                            <div class="form-group mb-0 text-center d-flex">
                                                <button class="btn_to_vt" type="submit" id="submitBtn"> Add
                                                </button>
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

    <div class="modal fade make-delete" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <input type="hidden" id="dltUserID">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <i class="fas fa-exclamation"></i>
                    <h4 class="model-heading-vt">Are you sure to delete <br>this make ?</h4>
                    <div class="modal-footer">
                        <button type="button" class="btn_create_vt deleteMakeConfirm">Yes, Delete</button>
                        <button type="button" class="btn_close_vt" data-dismiss="modal" id="make-cancel">Close</button>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#category-detail').find('option').not(':first').remove();
            $.ajax({
                url: '{{route('settings.category.detail')}}',
                type: 'get',
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    if (response.status) {
                        for (let i = 0; i < response.data.length; i++) {
                            let id = response.data[i].id;
                            let category = response.data[i].category;
                            let option = "<option value='" + id + "'>" + category + "</option>";
                            $("#category-detail").append(option);
                        }
                    }
                    else
                    {
                        $("#category-detail").find('option').get(0).remove();
                    }

                }
            });
        });
        $(".makeImageUpload1122").click(function () {
            $("input[type='file']").trigger('click');
        });
        $('input[type="file"]').on('change', function() {
            var val = $(this).val();
            var file = $("input[type=file]").get(0).files[0];

            if(file){
                let reader = new FileReader();

                reader.onload = function(){
                    document.getElementById('makeImage').style.display = 'block';
                    document.getElementById('makeImage').setAttribute('src', reader.result);
                }

                reader.readAsDataURL(file);
            }
        });

        function editMake(id, make,logo,status) {
            console.log(make);
            document.getElementById('home-b1').style.display = 'none';
            document.getElementById('profile-b1').style.display = 'block';
            document.getElementById('editSubCategory1').classList.add("active");
            document.getElementById('makeImage').style.display = 'block';
            document.getElementById('makeImage').setAttribute('src', logo);
            document.getElementById('editSubCategory1').innerHTML = '';
            document.getElementById('submitBtn').innerHTML = '';
            document.getElementById('editSubCategory1').textContent = 'Update Make';
            document.getElementById('submitBtn').textContent = 'Update';
            document.getElementById('editSubCategory2').classList.remove("active");
            document.querySelector('#make').value = make;
            // document.querySelector('#make').value = make;
            if(status === 1)
            {
                status = 'Active';
            }
            else
            {
                status = 'InActive';
            }
            // document.getElementById('editSubCategory2').setAttribute('onclick', 'editAdminSubCategory()');
            let child = document.getElementById('make-status').children;
            for (let i = 0; i < child.length; i++) {
                if (child[i].innerHTML === status) {
                    child[i].selected = true;
                }

            }
            // let subCategoryStatus = document.getElementById('admin-status').children;
            // for (let i = 0; i < subCategoryStatus.length; i++) {
            //     if (subCategoryStatus[i].innerHTML === status) {
            //         subCategoryStatus[i].selected = true;
            //     }
            // }
            let url = '{{ url("/settings/make", ":makeId") }}';
            url = url.replace('%3AmakeId', id);
            document.getElementById('makeForm').setAttribute('action', url);
        }

        function editAdminSubCategory() {
            window.location.reload()
        }
        $('.deleteSubCategory').click(function () {
            let data = $(this).attr('data-id');
            $('.deleteModal #dltUserID').val(data);

        });
        $('.deleteMakeConfirm').click(function() {

            let id = $('.deleteModal #dltUserID').val();
            $.ajax({
                url: '{{route('settings.make.delete')}}',
                type: 'post',
                data: {"_token": "{{csrf_token()}}",'id' : id},
                dataType: 'json',
                success: function (response) {
                    if(response.status)
                    {
                        swal("Make deleted successfully!");
                        document.getElementById('make-cancel').click();
                        setTimeout(function(){ window.location.reload() }, 1000);
                    }else
                    {
                        swal("Make could not be deleted!");
                        document.getElementById('make-cancel').click();
                        setTimeout(function(){ window.location.reload() }, 1000);
                    }

                }
            });
        });

    </script>
    <script>

        ///datatable code.......


        $('#datatable_hybrid2').DataTable({
        "pageLength": 10,
        "paging" :true,
        "bLengthChange": true,
        columnDefs: [
        {
        orderable: false,
        targets: [0, 1, 2, 3, 4]
        },
        ],
        "info": false,
        "scrollX": true,
        dom: 'Bfrtip',
        buttons: [
        {
                extend: 'excelHtml5',
                orientation: 'landscape',
                pageSize: 'LEGAL',
                exportOptions: {
                    columns: [ 0, 1, 3 ]
                },
                text : "Download Excel"
                
            },
            {
                extend: 'csvHtml5',
                exportOptions: {
                    columns: [ 0, 1, 3 ]
                },
                text : "Download CSV"
            },
            {
                extend: 'pdfHtml5',
                customize: function(doc) {
                    console.dir(doc)
                    doc.content[1].margin = [ 150, 0, 100, 0 ],
                    doc.styles.tableHeader.alignment = 'left',
                    doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('')
                },
                exportOptions: {
                    columns: [ 0, 1, 3 ]
                },
                text : "Download PDF"
            }

        ]
        });

</script>
@endsection
