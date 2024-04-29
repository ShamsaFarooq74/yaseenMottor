@extends('layouts.admin.master')
@section('content')

<!-- Topbar Start -->
@include('layouts.admin.blocks.inc.topnavbar')
<!-- end Topbar -->

<!-- Start Content-->
<div class="container-fluid mt-3">
    @include('admin.alert-message')

    <div class="row">
        <div class="col-xl-3">
            <div class="page_left_bar">
                <a href="{{route('settings.category')}}"> Categories </a>
                <a class="active" href="{{route('settings.sub-category')}}"> Make</a>
                <a href="{{route('settings')}}"> Model</a>
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
                                <table class="table table-borderless table-hover table-centered m-0">
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
                                    @foreach($subCategory as $key => $productSubCategory)
                                        <tr>
                                            <td>
                                                {{$key + 1}}
                                            </td>
                                            <td>
                                                {{$productSubCategory->category['category']}}
                                            </td>
                                            <td>
                                                {{$productSubCategory->sub_category}}
                                            </td>
                                            <td>
                                                {{$productSubCategory->status}}
                                            </td>
                                            <td>
                                                <div class="btn-group mb-2">
                                                    <button type="button" class="btn btn_info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <i class="mdi mdi-chevron-down"></i></button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" onclick="editSubCategory({{$productSubCategory->id}},{{json_encode($productSubCategory->sub_category)}},{{json_encode($productSubCategory->category['category'])}},{{json_encode($productSubCategory->status)}})">Edit</a>
                                                        <button type="button" class="dropdown-item deleteSubCategory" data-toggle="modal" data-target=".bs-example-modal-center" data-id="{{$productSubCategory->id}}">Delete</button>
                                                    </div>
                                                </div><!-- /btn-group -->
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if($subCategory)
                                {!! $subCategory->render() !!}
                            @endif
{{--                            <div class="pagination_vt">--}}
{{--                                    <nav aria-label="Page navigation example">--}}
{{--                                        <ul class="pagination">--}}
{{--                                            <li class="page-item">--}}
{{--                                            <a class="page-link" href="#" aria-label="Previous">--}}
{{--                                                <span aria-hidden="true">&laquo;</span>--}}
{{--                                                <span class="sr-only">Previous</span>--}}
{{--                                            </a>--}}
{{--                                            </li>--}}
{{--                                            <li class="page-item"><a class="page-link" href="#">1</a></li>--}}
{{--                                            <li class="page-item"><a class="page-link" href="#">2</a></li>--}}
{{--                                            <li class="page-item"><a class="page-link" href="#">3</a></li>--}}
{{--                                            <li class="page-item">--}}
{{--                                            <a class="page-link" href="#" aria-label="Next">--}}
{{--                                                <span aria-hidden="true">&raquo;</span>--}}
{{--                                                <span class="sr-only">Next</span>--}}
{{--                                            </a>--}}
{{--                                            </li>--}}
{{--                                        </ul>--}}
{{--                                    </nav>--}}
{{--                                </div>--}}
                        </div>
                        <div class="tab-pane" id="profile-b1">
                            <form class="card p-2" method="post" action="{{route('sub-category.add',['subCategoryId' => $subCategoryId])}}" enctype="multipart/form-data" id="categoryForm">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Make<span class="star_vt">*</span></label>
                                            <select class="form-control" id="category-detail" name="category">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="admin-status">Status<span class="star_vt">*</span></label>
                                            <select class="form-control" id="admin-status" name="status">
                                                <option>Active</option>
                                                <option>InActive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Upload Image<span
                                                    class="star_vt">*</span></label>
                                            <div class="file-upload">
                                                <input type="file" id="myFile" name="make-image">
                                            </div>
                                        </div>
                                    </div>
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

<div class="modal fade bs-example-modal-center deleteModal" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <input type="hidden" id="dltUserID">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <i class="fas fa-exclamation"></i>
                <h4 class="model-heading-vt">Are you sure to delete <br>this Sub-category ?</h4>
                <div class="modal-footer">
                    <button type="button" class="btn_create_vt deleteSubCategoryConfirm">Yes, Delete</button>
                    <button type="button" class="btn_close_vt" data-dismiss="modal" id="sub-category-cancel">Close</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



    <script>
        $(document).ready(function () {
                $('#category-detail').find('option').not(':first').remove();
                $.ajax({
                    url: '{{route('settings.category.detail')}}',
                    type: 'get',
                    dataType: 'json',
                    success: function (response) {
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

        function editSubCategory(id, subCategory,category,status) {
            document.getElementById('home-b1').style.display = 'none';
            document.getElementById('profile-b1').style.display = 'block';
            document.getElementById('editSubCategory1').classList.add("active");
            document.getElementById('editSubCategory1').innerHTML = '';
            document.getElementById('submitBtn').innerHTML = '';
            document.getElementById('editSubCategory1').textContent = 'Edit Make';
            document.getElementById('submitBtn').textContent = 'Edit';
            document.getElementById('editSubCategory2').classList.remove("active");
            document.querySelector('#sub-category').value = subCategory;
            document.getElementById('editSubCategory2').setAttribute('onclick', 'editAdminSubCategory()');
            let child = document.getElementById('category-detail').children;
            for (let i = 0; i < child.length; i++) {
                if (child[i].innerHTML === category) {
                    child[i].selected = true;
                }

            } let subCategoryStatus = document.getElementById('admin-status').children;
            for (let i = 0; i < subCategoryStatus.length; i++) {
                if (subCategoryStatus[i].innerHTML === status) {
                    subCategoryStatus[i].selected = true;
                }
            }
            let url = '{{ url("/settings/add-sub-category", ":id") }}';
            url = url.replace('%3Aid', id);
            document.getElementById('categoryForm').setAttribute('action', url);
        }

        function editAdminSubCategory() {
            window.location.reload()
        }
        $('.deleteSubCategory').click(function () {
            let data = $(this).attr('data-id');
            $('.deleteModal #dltUserID').val(data);

        });
        $('.deleteSubCategoryConfirm').click(function() {

            let id = $('.deleteModal #dltUserID').val();
            $.ajax({
                url: 'delete-sub-category',
                type: 'post',
                data: {"_token": "{{csrf_token()}}",'id' : id},
                dataType: 'json',
                success: function (response) {
                    if(response.status)
                    {
                        swal("Category deleted successfully!");
                        document.getElementById('sub-category-cancel').click();
                        setTimeout(function(){ window.location.reload() }, 1000);
                    }else
                    {
                        swal("Category could not be  deleted!");
                        document.getElementById('sub-category-cancel').click();
                        setTimeout(function(){ window.location.reload() }, 1000);
                    }

                }
            });
        });

    </script>
@endsection
