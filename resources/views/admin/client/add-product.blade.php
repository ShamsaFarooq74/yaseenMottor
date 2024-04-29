@extends('layouts.admin.master')
@section('content')

    <!-- Topbar Start -->
    @include('layouts.admin.blocks.inc.topnavbar')
    <!-- end Topbar -->

    <!-- Start Content-->
    <div class="container-fluid mt-3">

        <div class="row">
            <div class="col-xl-3">
                <div class="page_left_bar">
                    <a href="{{route('company.profile', ['id' => $id])}}"> Company Profile </a>
                    <a href="{{route('company.product', ['id' => $id])}}"> Product</a>
                    <a href="{{route('company.add.product', ['id' => $id])}}" class="active"> Add Product</a>
                    <a href="{{route('company.featured.product', ['id' => $id])}}"> Featured Products</a>
                    <a href="{{route('company.user', ['id' => $id])}}"> Edit User</a>
                    <a href="{{route('company.leads', ['id' => $id])}}"> Leads</a>
                    <a href="{{route('company.chats',['id' => $id])}}"> Chats</a>
                </div>
            </div>
            <div class="col-xl-9 home_custome_table company_pro_vt">

                <div class="card-box home_table">
                    @if($productId)
                    <h4 class="header-title_vt mb-3 pl-2">Edit Product</h4>
                    @else
                    <h4 class="header-title_vt mb-3 pl-2">Add Product</h4>
                    @endif
                    <form class="card p-2" method="post"
                          action="{{route('products.add',['id' => $id,'productId' => $productId])}}"
                          enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            @if($productId)
                                <input type="hidden" id="{{$productId}}" class="addProduct">
                            @else
                                <input type="hidden" class="addProduct">
                            @endif
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="emailaddress">Product name<span class="star_vt">*</span></label>
                                    <input class="form-control" type="text" id="productName" required=""
                                           placeholder="Enter Product name" name="product_name" value="{{old('product_name')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category-detail">Category<span class="star_vt">*</span></label>
                                    <select class="form-control" id="category-detail" name="category">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sub-category">Sub Category<span class="star_vt">*</span></label>
                                    <select class="form-control" id="sub-category" name="sub_category">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="emailaddress">Price<span class="star_vt">*</span></label>
                                    <input class="form-control" type="number" id="price" required=""
                                           placeholder="Enter Price" name="price" value="{{old('price')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="unit-detail">Unit<span class="star_vt">*</span></label>
                                    <select class="form-control" id="unit-detail" name="unit">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="status-detail">Status<span class="star_vt">*</span></label>
                                    <select class="form-control" id="status-detail" name="status">
                                        <option>Active</option>
                                        <option>InActive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Description</label>
                                    <textarea placeholder="Enter Description" class="form-control" name="description"
                                              rows="4"
                                              cols="50" id="description" > {{{ old('description') }}}</textarea>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Upload Images<span
                                            class="star_vt">*</span></label>
                                    <div class="file-upload">
                                        <input type="file" id="myFile" multiple name="productImage[]"
                                               onchange="readURL(this);"  value="{{old('productImage[]')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 img_upload">
                                <ul id="productImages">
                                </ul>
                            </div>
                            <div class="col-md-8"></div>
                            <div class="col-md-4">
                                <div class="form-group mb-0 text-center d-flex">
                                    <button class="btn_cancel_vt pr-2"> Cancel
                                    </button>
                                    @if($productId)
                                    <button class="btn_to_vt" type="submit"> Edit Product
                                    </button>
                                    @else
                                        <button class="btn_to_vt" type="submit"> Add Product
                                        </button>
                                    @endif
                                    @if (session()->has('success'))
                                        <div class="alert alert-success">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('success') }}
                                        </div>
                                    @endif

                                    @if (session()->has('errors'))
                                        <div class="alert alert-danger">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('errors') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- end row -->

    </div> <!-- container -->

    <script>
        $(document).ready(function () {
            $('#category-detail').empty();
            $("#sub-category").empty();
            $("#unit-detail").empty();
            $.ajax({
                url: '{{route('product.category')}}',
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
                        for (let i = 0; i < response.sub_category.length; i++) {
                            let subcategoryId = response.sub_category[i].id;
                            let subCategory = response.sub_category[i].sub_category;
                            let option = "<option value='" + subCategory + "'>" + subCategory + "</option>";
                            $("#sub-category").append(option);
                        }
                        for (let i = 0; i < response.unit.length; i++) {
                            let unitId = response.unit[i].id;
                            let unit = response.unit[i].unit;
                            let option = "<option value='" + unitId + "'>" + unit + "</option>";
                            $("#unit-detail").append(option);
                        }
                    } else {
                        $("#category-detail").empty();
                        $("#sub-category").empty();
                        $("#unit-detail").empty();
                    }
    ``
                }
            });
            let element = document.getElementsByClassName('addProduct');
            let idExists = element[0].hasAttribute('id');
            {{--var url = "{{ route('product.edit', ":id") }}";--}}
                {{--url = url.replace(':id', id);--}}
            if (idExists) {
                let id = element[0].getAttribute('id');
                $.ajax({
                    url: "{{ route('product.edit') }}",
                    type: 'get',
                    dataType: 'json',
                    data: {"_token": "{{csrf_token()}}", 'id': id},
                    success: function (response) {
                        if (response.status) {
                            $('#productName').val(response.data['products_name']);
                            $('#price').val(response.data['price']);
                            $('#description').val(response.data['description']);
                            let allcategory = document.getElementById('category-detail').childNodes;
                            for (let k = 0; k < allcategory.length; k++) {
                                if (response.data['category'] === allcategory[k].text) {
                                    allcategory[k].selected = 'selected';
                                }
                            }
                            document.getElementById('sub-category').innerHTML='';
                            let option = "<option value='" + response.data['sub_category'] + "'>" + response.data['sub_category'] + "</option>";
                            $("#sub-category").append(option);
                            // for (let i = 0; i < subCategory.length; i++) {
                            //     if (response.data['sub_category'] === subCategory[i].text) {
                            //         subCategory[i].selected = 'selected';
                            //     }
                            // }
                            let productUnit = document.getElementById('unit-detail').childNodes;
                            for (let l = 0; l < productUnit.length; l++) {
                                if (response.data['unit'] === productUnit[l].text) {
                                    productUnit[l].selected = 'selected';
                                }
                            }
                            let statusDetail = document.getElementById('status-detail').childNodes;
                            if (response.data['is_active'] === 'Y') {
                                response.data['is_active'] = 'Active';

                            } else {
                                response.data['is_active'] = 'Inactive';
                            }
                            for (let m = 0; m < statusDetail.length; m++) {

                                if (response.data['is_active'] === statusDetail[m].text) {
                                    statusDetail[m].selected = 'selected';
                                }
                            }
                            for (let i = 0; i < response.data['attachments'].length; i++) {
                                let image = "<li><img src='" + response.data['attachments'][i]['image'] + "' width='50' height='50' alt=''> </li>";
                                $("#productImages").append(image);
                            }
                        } else {
                        }

                    }
                });
            }
            $('#category-detail').change(function () {
                let id = $(this).val();
                let companyId = id.length > 0 ? id : [];
                // $('#sub-category').find('option').empty();
                document.getElementById('sub-category').innerHTML = '';
                document.getElementById('unit-detail').innerHTML = '';
                $.ajax({
                    url: '{{route('product.sub-category')}}',
                    type: 'get',
                    dataType: 'json',
                    data: {'id': id},
                    success: function (response) {
                        if (response.status) {
                            for (let i = 0; i < response.data.length; i++) {
                                let id = response.data[i].id;
                                let subCategory = response.data[i].sub_category;
                                let option = "<option value='" + subCategory + "'>" + subCategory + "</option>";
                                $("#sub-category").append(option);
                            }
                            if(response.unit)
                            {
                                for (let i = 0; i < response.unit.length; i++) {
                                    let id = response.unit[i].id;
                                    let subCategoryUnit = response.unit[i].unit;
                                    let option = "<option value='" + id + "'>" + subCategoryUnit + "</option>";
                                    $("#unit-detail").append(option);
                                }
                            }
                        } else {
                            $("#sub-category").empty();
                            $("#unit-detail").empty();
                        }

                    }
                });
            });
            $('#sub-category').change(function () {
                let id = $(this).val();
                let subCategory = id.length > 0 ? id : '';
                // $('#sub-category').find('option').empty();
                document.getElementById('unit-detail').innerHTML = '';
                $.ajax({
                    url: '{{route('product.sub-category.unit')}}',
                    type: 'get',
                    dataType: 'json',
                    data: {'sub_category': subCategory},
                    success: function (response) {
                        if (response.status) {
                            for (let i = 0; i < response.data.length; i++) {
                                let id = response.data[i].id;
                                let subCategoryUnit = response.data[i].unit;
                                let option = "<option value='" + id + "'>" + subCategoryUnit + "</option>";
                                $("#unit-detail").append(option);
                            }
                        } else {
                            $("#unit-detail").empty();
                        }

                    }
                });
            });

        });
        {{--$('#unit-detail').empty();--}}
        {{--$.ajax({--}}
        {{--    url: '{{route('product.unit')}}',--}}
        {{--    type: 'get',--}}
        {{--    dataType: 'json',--}}
        {{--    success: function (response) {--}}
        {{--        if (response.status) {--}}
        {{--            for (let i = 0; i < response.data.length; i++) {--}}
        {{--                let id = response.data[i].id;--}}
        {{--                let unit = response.data[i].unit;--}}
        {{--                let option = "<option value='" + id + "'>" + unit + "</option>";--}}
        {{--                $("#unit-detail").append(option);--}}
        {{--            }--}}
        {{--        } else {--}}
        {{--            $("#unit-detail").empty();--}}
        {{--        }--}}

        {{--    }--}}
        {{--});--}}


        function readURL(input) {
            if (input.files) {
                // console.log(input)
                // console.log(input.files)
                var filesAmount = input.files.length;

                for (i = 0; i < filesAmount; i++) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        let image = "<li><img src='" + e.target.result + "' width='50' height='50' alt=''> </li>";
                        $("#productImages").append(image);
                    }

                    reader.readAsDataURL(input.files[i]);
                }
                let parent = document.getElementById('productImages');
                parent.innerHTML = '';
            }
        }
    </script>
@endsection
