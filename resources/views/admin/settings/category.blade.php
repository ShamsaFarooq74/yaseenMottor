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

.form-control:disabled,
.form-control[readonly] {
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
.dt-button {
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
                <a class="active" href="{{route('settings.category')}}">Shipment</a>
                <a href="{{route('settings.make')}}"> Make</a>
                <a href="{{route('settings')}}"> Model</a>
                <a href="{{route('settings.feature')}}"> Features </a>
                <a href="{{route('settings.fuel')}}"> Fuel Types </a>
            </div>
        </div>
        <div class="col-xl-9 home_custome_table">
            <div class="card-box home_table">
                <h4 class="header-title_vt mb-3 pl-2">Shipment</h4>
                <div class="card_tabs_vt">
                    <ul class="nav nav-tabs nav-bordered">
                        <li class="nav-item">
                            <a href="#home-b1" data-toggle="tab" aria-expanded="false" class="nav-link active"
                                id="editCategory2">
                                All Shipment
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#profile-b1" data-toggle="tab" aria-expanded="true" class="nav-link"
                                id="editCategory1">
                                Add Shipment
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
                                            <th>Country</th>
                                            <th>Port</th>
                                            <th>Price</th>
                                            <th>Insurance Price</th>
                                            <th>Warranty Price</th>
                                            <th>RoRo</th>
                                            <th>Container</th>
                                            <th>Insurance</th>
                                            <th>BF Warranty</th>

                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($shipments as $key => $shipment)
                                        <tr>
                                            <td>
                                                {{$key + 1}}
                                            </td>
                                            <td>
                                                {{$shipment->country->country_name}}
                                            </td>
                                            <td>
                                                {{$shipment->portname}}
                                            </td>
                                            <td>
                                                {{$shipment->price}}
                                            </td>
                                            <td>
                                                {{$shipment->insurance_price}}
                                            </td>
                                            <td>
                                                {{$shipment->warranty_price}}
                                            </td>
                                            <td> {{$shipment->roro == 1 ? 'Active' : 'InActive'}}</td>
                                            <td> {{$shipment->portcontainer == 1 ? 'Active' : 'InActive'}}</td>
                                            <td> {{$shipment->insurance == 1 ? 'Active' : 'InActive'}}</td>
                                            <td> {{$shipment->warranty == 1 ? 'Active' : 'InActive'}}</td>
                                            <td>
                                                <div class="btn-group mb-2">
                                                    <button type="button" class="btn btn_info dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">Action <i
                                                            class="mdi mdi-chevron-down"></i></button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item"
                                                            onclick="editCategory({{$shipment->id}},{{json_encode($shipment->country_id)}},{{json_encode($shipment->portname)}},{{json_encode($shipment->price)}},{{json_encode($shipment->insurance_price)}},{{json_encode($shipment->warranty_price)}},{{json_encode($shipment->insurance)}},{{json_encode($shipment->warranty)}},{{json_encode($shipment->roro)}}, {{json_encode($shipment->portcontainer)}})">Edit</a>
                                                        <button type="button" class="dropdown-item deleteCategory"
                                                            data-toggle="modal" data-target=".category-deletee"
                                                            data-id="{{$shipment->id}}">Delete
                                                        </button>
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
                            <form class="card p-2" method="post"
                                action="{{route('settings.add.category',['categoryId' => $categoryId])}}"
                                enctype="multipart/form-data" id="categoryForm">
                                {{ csrf_field() }}
                                <div class="row">
                                    <!-- <div class="col-md-12" id="adminProfilePic">
                                            <div class="formgroup_vt">
                                                <img src="{{asset('assets/images/parts.png')}}" alt=""
                                                     id="categoryImage">
                                                <span >
                                                     <i class="fas fa-pen categoryImageUpload1122" type="file" >
                                                     </i>
                                                     </span>
                                                <input style="display: none" type="file" name="category_image" id="imageUploadInput">
                                            </div>
                                        </div> -->
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="country">Country<span class="star_vt">*</span></label>
                                                    <select class="form-control" id="country" name="country">
                                                        @foreach($countries as $key => $country)
                                                        <option value='{{$country->id}}'>{{$country->country_name}}
                                                        </option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="portname">Port/City<span
                                                            class="star_vt">*</span></label>
                                                    <input class="form-control" id="portname" type="text"
                                                        placeholder="Enter Port Name" name="portname">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1">Price<span
                                                        class="star_vt">*</span></label>
                                                <input class="form-control" id="price" type="number"
                                                    placeholder="35,000" name="price">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h5>Shipping Method</h5>
                                                <div class="form-group d-flex">
                                                    <div class="mx-3">
                                                        <input type="checkbox" id="roro" name="roro">
                                                          <label for="roro">RoRo</label>
                                                    </div>
                                                    <div class="mx-3">
                                                        <input type="checkbox" id="portcontainer" name="portcontainer">
                                                          <label for="portcontainer">Container</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <h5>Additional Options</h5>
                                            <div class="form-group d-flex">
                                                <div class="mx-3">
                                                    <input type="checkbox" id="insurance" name="insurance">
                                                    <label for="insurance">Marine Insurance</label><br>
                                                    <input class="form-control" id="insurancePrice" type="number"
                                                        placeholder="3,000" name="insurancePrice" style="display: none;">
                                                </div>
                                                <div class="mx-3">
                                                    <input type="checkbox" id="warranty" name="warranty">
                                                    <label for="warranty"> BF Warranty</label><br>
                                                    <input class="form-control" id="warrantyPrice" type="number"
                                                        placeholder="2,000" name="warrantyPrice" style="display: none;">
                                                   
                                                </div>
                                            </div>
                                        </div>


                                        <!-- <div class="form-group">
                                                <label for="category" id="categoryLabel">Add Shipment<span
                                                        class="star_vt">*</span></label>
                                                <input class="form-control" type="text" id="category" required=""
                                                       placeholder="Enter category name" name="category">
                                            </div> -->
                                    </div>
                                    <div class="col-md-11"></div>
                                    <div class="col-md-1">
                                        <div class="form-group mb-0 text-center d-flex">
                                            <button class="btn_to_vt" type="submit" id="submitBtn"> Create
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


<div class="modal fade category-deletee deleteModal" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel"
    aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <input type="hidden" id="dltUserID">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <i class="fas fa-exclamation"></i>
                <h4 class="model-heading-vt">Are you sure to delete <br>this Shipment ?</h4>
                <div class="modal-footer">
                    <button type="button" class="btn_create_vt deleteCategoryConfirm">Yes, Delete</button>
                    <button type="button" class="btn_close_vt" data-dismiss="modal" id="category-cancel">Close</button>
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
$(".categoryImageUpload1122").click(function() {
    $("input[type='file']").trigger('click');
});
$('input[type="file"]').on('change', function() {
    var val = $(this).val()
    // if (val) {
    //     var ext = val.match(/\.(.+)$/)[1];
    //     switch (ext.toLowerCase()) {
    //         case 'jpg':
    //         case 'jpeg':
    //         case 'png':
    //         case 'gif':
    //             break;
    //         default:
    //             alert('This is not an allowed file type.Please try again!');
    //             val = '';
    //             return
    //     }
    var file = $("input[type=file]").get(0).files[0];

    if (file) {
        let reader = new FileReader();

        reader.onload = function() {
            document.getElementById('categoryImage').style.display = 'block';
            document.getElementById('categoryImage').setAttribute('src', reader.result);
        }

        reader.readAsDataURL(file);
    }
    // }

});

function editCategory(id, country_id, portname, price,insurance_price,warranty_price, insurance, warranty, roro, portcontainer) {
    console.log(country_id);
    document.getElementById('home-b1').style.display = 'none';
    document.getElementById('profile-b1').style.display = 'block';
    document.getElementById('editCategory1').classList.add("active");
    document.getElementById('editCategory1').innerHTML = '';
    // document.getElementById('categoryLabel').innerHTML = '';
    document.getElementById('submitBtn').innerHTML = '';
    document.getElementById('editCategory1').textContent = 'Update Shipment';
    // document.getElementById('categoryLabel').textContent = 'Edit Category';
    // document.getElementById('categoryImage').style.display = 'block';
    // document.getElementById('categoryImage').setAttribute('src', image);
    document.getElementById('submitBtn').textContent = 'Update';
    document.getElementById('editCategory2').classList.remove("active");
    document.getElementById('editCategory2').setAttribute('onclick', 'editAdminCategory()');
    var countrySelect = document.getElementById('country').value = country_id;
    // var selectedCountryValue = countrySelect.value = country_id;

    document.getElementById('portname').value = portname;
    console.log(portname);
    document.getElementById('price').value = price;
    document.getElementById('insurancePrice').value = insurance_price;
    document.getElementById('warrantyPrice').value = warranty_price; 
    document.getElementById('insurance').checked = insurance;
    document.getElementById('warranty').checked = warranty;
    document.getElementById('portcontainer').checked = portcontainer;
    document.getElementById('roro').checked = roro;
    let url = '{{ url("/settings/add-category/details", ":id") }}';
    url = url.replace('%3Aid', id);
    document.getElementById('categoryForm').setAttribute('action', url);
     handleCheckboxInputVisibility('insurance', 'insurancePrice', insurance);
    handleCheckboxInputVisibility('warranty', 'warrantyPrice', warranty);
}
function handleCheckboxInputVisibility(checkboxId, inputId, isChecked) {
    var checkbox = document.getElementById(checkboxId);
    var inputField = document.getElementById(inputId);

    checkbox.checked = isChecked; // Check/uncheck the checkbox based on database value

    if (isChecked) {
        inputField.style.display = 'block'; // Show the input field if checked
    } else {
        inputField.style.display = 'none'; // Hide the input field if unchecked
    }
}
function editAdminCategory() {
    window.location.reload()
}
$('.deleteCategory').click(function() {
    let data = $(this).attr('data-id');
    $('.deleteModal #dltUserID').val(data);

});
$('.deleteCategoryConfirm').click(function() {

    let id = $('.deleteModal #dltUserID').val();
    $.ajax({
        url: '{{route('admin.category.delete')}}',
        type: 'post',
        data: {
            "_token": "{{csrf_token()}}",
            'id': id
        },
        dataType: 'json',
        success: function(response) {
            if (response.status) {
                swal("Shipment deleted successfully!");
                document.getElementById('category-cancel').click();
                setTimeout(function() {
                    window.location.reload()
                }, 2000);
            } else {
                swal("Shipment could not be  deleted!");
                document.getElementById('category-cancel').click();
                setTimeout(function() {
                    window.location.reload()
                }, 2000);
            }

        }
    });
});
</script>
<script>
///datatable code.......


$('#datatable_hybrid2').DataTable({
    "pageLength": 10,
    "bLengthChange": true,
    columnDefs: [{
        orderable: false,
        targets: [0, 1, 2, 3]
    }, ],
    "info": false,
    "scrollX": true,
    dom: 'Bfrtip',
    buttons: [{
            extend: 'excelHtml5',
            orientation: 'landscape',
            pageSize: 'LEGAL',
            exportOptions: {
                columns: [0, 1]
            },
            text: "Download Excel"

        },
        {
            extend: 'csvHtml5',
            exportOptions: {
                columns: [0, 1]
            },
            text: "Download CSV"
        },
        {
            extend: 'pdfHtml5',
            customize: function(doc) {
                console.dir(doc)
                doc.content[1].margin = [150, 0, 100, 0],
                    doc.styles.tableHeader.alignment = 'left',
                    doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join(
                        '*').split('')
            },
            exportOptions: {
                columns: [0, 1]
            },
            text: "Download PDF"
        }

    ]
});
</script>
<script>
function toggleInputVisibility(checkboxId, inputId) {
    var checkbox = document.getElementById(checkboxId);
    var inputField = document.getElementById(inputId);

    checkbox.addEventListener('change', function() {
        if (this.checked) {
            inputField.style.display = 'block';
        } else {
            inputField.style.display = 'none';
        }
    });
}

toggleInputVisibility('insurance', 'insurancePrice');
toggleInputVisibility('warranty', 'warrantyPrice');

</script>
@endsection