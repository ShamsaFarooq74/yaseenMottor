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
                    <a class="active" href="{{route('settings.category')}}"> Categories </a>
                    <a href="{{route('settings.sub-category')}}"> Make</a>
                    <a href="{{route('settings')}}"> Model</a>
                </div>
            </div>
            <div class="col-xl-9 home_custome_table">
                <div class="card-box home_table">
                    <h4 class="header-title_vt mb-3 pl-2">Categories</h4>
                    <div class="card_tabs_vt">
                        <ul class="nav nav-tabs nav-bordered">
                            <li class="nav-item">
                                <a href="#home-b1" data-toggle="tab" aria-expanded="false" class="nav-link active"
                                   id="editCategory2">
                                    All Categories
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#profile-b1" data-toggle="tab" aria-expanded="true" class="nav-link"
                                   id="editCategory1">
                                    Add Category
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
                                            <th>Categories</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($productCategory as $key => $category)
                                            <tr>
                                                <td>
                                                    {{$key + 1}}
                                                </td>
                                                <td>
                                                    {{$category->category}}
                                                </td>
                                                <td>
                                                    <div class="btn-group mb-2">
                                                        <button type="button" class="btn btn_info dropdown-toggle"
                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">Action <i
                                                                class="mdi mdi-chevron-down"></i></button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item"
                                                               onclick="editCategory({{$category->id}},{{json_encode($category->category)}})">Edit</a>
                                                            <button type="button" class="dropdown-item deleteCategory"
                                                                    data-toggle="modal"
                                                                    data-target=".bs-example-modal-center" data-id="{{$category->id}}">Delete
                                                            </button>
                                                        </div>
                                                    </div><!-- /btn-group -->
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @if($productCategory)
                                    {!! $productCategory->render() !!}
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
                                <form class="card p-2" method="post" action="{{route('settings.add.category',['categoryId' => $categoryId])}}"
                                      enctype="multipart/form-data" id="categoryForm">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="category" id="categoryLabel">Add Category<span
                                                        class="star_vt">*</span></label>
                                                <input class="form-control" type="text" id="category" required=""
                                                       placeholder="Enter category name" name="category">
                                            </div>
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


    <div class="modal fade bs-example-modal-center deleteModal" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel"
         aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <input type="hidden" id="dltUserID">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <i class="fas fa-exclamation"></i>
                    <h4 class="model-heading-vt">Are you sure to delete <br>this category ?</h4>
                    <div class="modal-footer">
                        <button type="button" class="btn_create_vt deleteCategoryConfirm">Yes, Delete</button>
                        <button type="button" class="btn_close_vt" data-dismiss="modal" id="category-cancel">Close</button>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <script>
        function editCategory(id, category) {
            document.getElementById('home-b1').style.display = 'none';
            document.getElementById('profile-b1').style.display = 'block';
            document.getElementById('editCategory1').classList.add("active");
            document.getElementById('editCategory1').innerHTML = '';
            document.getElementById('categoryLabel').innerHTML = '';
            document.getElementById('submitBtn').innerHTML = '';
            document.getElementById('editCategory1').textContent = 'Edit Category';
            document.getElementById('categoryLabel').textContent = 'Edit Category';
            document.getElementById('submitBtn').textContent = 'Update';
            document.getElementById('editCategory2').classList.remove("active");
            document.getElementById('editCategory2').setAttribute('onclick', 'editAdminCategory()');
            document.getElementById('category').value = category;
            let url = '{{ url("/settings/add-category/details", ":id") }}';
            url = url.replace('%3Aid', id);
            document.getElementById('categoryForm').setAttribute('action', url);
        }

        function editAdminCategory() {
            window.location.reload()
        }
        $('.deleteCategory').click(function () {
            let data = $(this).attr('data-id');
            $('.deleteModal #dltUserID').val(data);

        });
        $('.deleteCategoryConfirm').click(function() {

            let id = $('.deleteModal #dltUserID').val();
            $.ajax({
                url: '{{route('admin.category.delete')}}',
                type: 'post',
                data: {"_token": "{{csrf_token()}}",'id' : id},
                dataType: 'json',
                success: function (response) {
                    if(response.status)
                    {
                        swal("Category deleted successfully!");
                        document.getElementById('category-cancel').click();
                        setTimeout(function(){ window.location.reload() }, 2000);
                    }else
                    {
                        swal("Category could not be  deleted!");
                        document.getElementById('category-cancel').click();
                        setTimeout(function(){ window.location.reload() }, 2000);
                    }

                }
            });
        });
    </script>

@endsection
