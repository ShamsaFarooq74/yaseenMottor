@extends('layouts.admin.master')
@section('content')

    <!-- Topbar Start -->
    @include('layouts.admin.blocks.inc.topnavbar')
    <!-- end Topbar -->

    <!-- Start Content-->
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-xl-12 home_custome_table">
                <div class="card-box three_table">
                    <h4 class="header-title_vt mb-3 pl-2">Products</h4>
                    <div class="card_tabs_vt">
                        <ul class="nav nav-tabs nav-bordered">
                            <li class="nav-item">
                                <a href="#home-b1" data-toggle="tab" aria-expanded="false" class="nav-link">
                                    Featured
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#profile-b1" data-toggle="tab" aria-expanded="true" class="nav-link">
                                    Pending
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#profile-b2" data-toggle="tab" aria-expanded="true" class="nav-link active">
                                    Approved
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
                                            <th>Ref no.</th>
                                            <th>Category</th>
                                            <th>Description</th>
                                            <th>Price</th>
                                            <th>Images</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($featuredProducts as $key => $featuredProduct)
                                            @if($featuredProduct->products_name)
                                                <tr>
                                                    <td>
                                                        {{$key + 1}}
                                                    </td>
                                                    <td style="cursor:pointer" onclick="window.location='{{route('company.product.detail', ['id' => $featuredProduct->id])}}'">
                                                        {{$featuredProduct->products_name}}
                                                    </td>
                                                    <td style="cursor:pointer" onclick="window.location='{{route('company.product.detail', ['id' => $featuredProduct->id])}}'">
                                                        {{$featuredProduct->sellerName}}
                                                    </td>
                                                    <td style="cursor:pointer" onclick="window.location='{{route('company.product.detail', ['id' => $featuredProduct->id])}}'">
                                                        {{$featuredProduct->category}}
                                                    </td>
                                                    <!-- <td style="cursor:pointer" onclick="window.location='{{route('company.product.detail', ['id' => $featuredProduct->id])}}'">
                                                        {{$featuredProduct->sub_category}}
                                                    </td> -->
                                                    <td style="cursor:pointer" onclick="window.location='{{route('company.product.detail', ['id' => $featuredProduct->id])}}'">
                                                        {{$featuredProduct->price}} {{$featuredProduct->currency}}
                                                        /{{$featuredProduct->unit}}
                                                    </td>
                                                    <td>
                                                        <div class="img_table">
                                                            @if($featuredProduct->attachments)
                                                                @foreach($featuredProduct->attachments as $attachment)
                                                                    <img
                                                                        src="product-attachments/{{$attachment->image}}"
                                                                        alt="">
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <!-- <td>
                                                        <div class="star-rating-area">
                                                            <div class="rating-static clearfix " rel="{{$featuredProduct->rating}}">
                                                                <label class="full" title="Awesome - 5 stars"></label>
                                                                <label class="half" title="Pretty good - 4.5 stars"></label>
                                                                <label class="full" title="Pretty good - 4 stars"></label>
                                                                <label class="half" title="Meh - 3.5 stars"></label>
                                                                <label class="full" title="Meh - 3 stars"></label>
                                                                <label class="half" title="Kinda bad - 2.5 stars"></label>
                                                                <label class="full" title="Kinda bad - 2 stars"></label>
                                                                <label class="half" title="Meh - 1.5 stars"></label>
                                                                <label class="full" title="Sucks big time - 1 star"></label>
                                                                <label class="half" title="Sucks big time - 0.5 stars"></label>
                                                            </div>
                                                        </div>
                                                    </td> -->
                                                    <td>
                                                        <div class="btn-group mb-2">
                                                            <button type="button" class="btn btn_info dropdown-toggle"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">Action <i
                                                                    class="mdi mdi-chevron-down"></i></button>
                                                            <div class="dropdown-menu">
                                                                <button type="button" class="dropdown-item deleteProducts"
                                                                        data-toggle="modal"
                                                                        data-target=".bs-example-modal-center" data-id="{{$featuredProduct->id}}">Delete
                                                                </button>

                                                            </div>
                                                        </div><!-- /btn-group -->
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @if($featuredProducts)
                                    {!! $featuredProducts->render() !!}
                                @endif
{{--                                <div class="pagination_vt">--}}
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
                                <div class="table-responsive">
                                    <table class="table table-borderless table-hover table-centered m-0">
                                        <thead class="thead-light">
                                        <tr>
                                            <th>Sr</th>
                                            <th>Ref no.</th>
                                            <th>Category</th>
                                            <th>Description</th>
                                            <th>Price</th>
                                            <th>Images</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($pendingProducts as $key => $pendingProduct)
                                            @if($pendingProduct->products_name)
                                                <tr>
                                                    <td>
                                                        {{$key + 1}}
                                                    </td>
                                                    <td style="cursor:pointer" onclick="window.location='{{route('company.product.detail', ['id' => $pendingProduct->id])}}'">
                                                        {{$pendingProduct->products_name}}
                                                    </td>
                                                    <td style="cursor:pointer" onclick="window.location='{{route('company.product.detail', ['id' => $pendingProduct->id])}}'">
                                                        {{$pendingProduct->sellerName}}
                                                    </td>
                                                    <td style="cursor:pointer" onclick="window.location='{{route('company.product.detail', ['id' => $pendingProduct->id])}}'">
                                                        {{$pendingProduct->category}}
                                                    </td>
                                                    <!-- <td style="cursor:pointer" onclick="window.location='{{route('company.product.detail', ['id' => $pendingProduct->id])}}'">
                                                        {{$pendingProduct->sub_category}}
                                                    </td> -->
                                                    <td style="cursor:pointer" onclick="window.location='{{route('company.product.detail', ['id' => $pendingProduct->id])}}'">
                                                        {{$pendingProduct->price}} {{$pendingProduct->currency}}
                                                        /{{$pendingProduct->unit}}
                                                    </td>
                                                    <td >
                                                        <div class="img_table">
                                                            @if($pendingProduct->attachments)
                                                                @foreach($pendingProduct->attachments as $attachment)
                                                                    <img
                                                                        src="product-attachments/{{$attachment->image}}"
                                                                        alt="">
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <!-- <td>
                                                        <div class="star-rating-area">
                                                            <div class="rating-static clearfix " rel="{{$pendingProduct->rating}}">
                                                                <label class="full" title="Awesome - 5 stars"></label>
                                                                <label class="half" title="Pretty good - 4.5 stars"></label>
                                                                <label class="full" title="Pretty good - 4 stars"></label>
                                                                <label class="half" title="Meh - 3.5 stars"></label>
                                                                <label class="full" title="Meh - 3 stars"></label>
                                                                <label class="half" title="Kinda bad - 2.5 stars"></label>
                                                                <label class="full" title="Kinda bad - 2 stars"></label>
                                                                <label class="half" title="Meh - 1.5 stars"></label>
                                                                <label class="full" title="Sucks big time - 1 star"></label>
                                                                <label class="half" title="Sucks big time - 0.5 stars"></label>
                                                            </div>
                                                        </div>
                                                    </td> -->
                                                    <td>
                                                        <div class="btn-group mb-2">
                                                            <button type="button" class="btn btn_info dropdown-toggle"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">Action <i
                                                                    class="mdi mdi-chevron-down"></i></button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" onclick="approveProducts({{$pendingProduct->id}})">Approve</a>
                                                                <button type="button" class="dropdown-item deleteProducts"
                                                                        data-toggle="modal"
                                                                        data-target=".bs-example-modal-center" data-id="{{$pendingProduct->id}}">Delete
                                                                </button>

                                                            </div>
                                                        </div><!-- /btn-group -->
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @if($pendingProducts)
                                    {!! $pendingProducts->render() !!}
                                @endif
{{--                                <div class="col-md-12 mb-4">--}}
{{--                                    {{ $pendingProducts->links() }}--}}
{{--                                </div>--}}
{{--<div class="pagination_vt">--}}
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
                            <div class="tab-pane show active" id="profile-b2">
                                <div class="table-responsive">
                                    <table class="table table-borderless table-hover table-centered m-0">
                                        <thead class="thead-light">
                                        <tr>
                                            <th>Sr</th>
                                            <th>Ref no.</th>
                                            <th>Category</th>
                                            <th>Description</th>
                                            <th>Price</th>
                                            <th>Images</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($approvedProducts as $key => $approvedProduct)
                                            @if($approvedProduct->products_name)
                                                <tr>
                                                    <td>
                                                        {{$key + 1}}
                                                    </td>
                                                    <td style="cursor:pointer" onclick="window.location='{{route('company.product.detail', ['id' => $approvedProduct->id])}}'">
                                                        {{$approvedProduct->products_name}}
                                                    </td>
                                                    <td style="cursor:pointer" onclick="window.location='{{route('company.product.detail', ['id' => $approvedProduct->id])}}'">
                                                        {{$approvedProduct->sellerName}}
                                                    </td>
                                                    <td style="cursor:pointer" onclick="window.location='{{route('company.product.detail', ['id' => $approvedProduct->id])}}'">
                                                        {{$approvedProduct->category}}
                                                    </td>
                                                    <!-- <td>
                                                        {{$approvedProduct->sub_category}}
                                                    </td> -->
                                                    <td style="cursor:pointer" onclick="window.location='{{route('company.product.detail', ['id' => $approvedProduct->id])}}'">
                                                        {{$approvedProduct->price}} {{$approvedProduct->currency}}
                                                        /{{$approvedProduct->unit}}
                                                    </td>
                                                    <td>
                                                        <div class="img_table">
                                                            @if($approvedProduct->attachments)
                                                                @foreach($approvedProduct->attachments as $attachment)
                                                                    <img
                                                                        src="product-attachments/{{$attachment->image}}"
                                                                        alt="">
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <!-- <td>
                                                        <div class="star-rating-area">
                                                            <div class="rating-static clearfix " rel="{{$approvedProduct->rating}}">
                                                                <label class="full" title="Awesome - 5 stars"></label>
                                                                <label class="half" title="Pretty good - 4.5 stars"></label>
                                                                <label class="full" title="Pretty good - 4 stars"></label>
                                                                <label class="half" title="Meh - 3.5 stars"></label>
                                                                <label class="full" title="Meh - 3 stars"></label>
                                                                <label class="half" title="Kinda bad - 2.5 stars"></label>
                                                                <label class="full" title="Kinda bad - 2 stars"></label>
                                                                <label class="half" title="Meh - 1.5 stars"></label>
                                                                <label class="full" title="Sucks big time - 1 star"></label>
                                                                <label class="half" title="Sucks big time - 0.5 stars"></label>
                                                            </div>
                                                        </div>
                                                    </td> -->
                                                    <td>
                                                        <div class="btn-group mb-2">
                                                            <button type="button" class="btn btn_info dropdown-toggle"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">Action <i
                                                                    class="mdi mdi-chevron-down"></i></button>
                                                            <div class="dropdown-menu">
                                                                <button type="button" class="dropdown-item deleteProducts"
                                                                        data-toggle="modal"
                                                                        data-target=".bs-example-modal-center" data-id="{{$approvedProduct->id}}">Delete
                                                                </button>

                                                            </div>
                                                        </div><!-- /btn-group -->
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @if($approvedProducts)
                                    {!! $approvedProducts->render() !!}
                                @endif
{{--                                <div class="pagination_vt">--}}
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
                    <h4 class="model-heading-vt">Are you sure to delete <br>this Products ?</h4>
                    <div class="modal-footer">
                        <button type="button" class="btn_create_vt deleteProductConfirm">Yes, Delete</button>
                        <button type="button" class="btn_close_vt" data-dismiss="modal" id="lead-cancel">Close</button>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>


    <script>
        $("body").on('click', '.xyz', function () {
            $(this).prev().prop("checked", true);
        });
        function approveProducts(id)
        {
            $.ajax({
                url: 'approve-product',
                type: 'post',
                data: {"_token": "{{csrf_token()}}",'id' : id},
                dataType: 'json',
                success: function (response) {
                    if(response.status) {
                        swal("Products approved Successfully!");
                        setTimeout(function(){ window.location.reload() }, 2000);
                    }
                    else
                    {
                        swal("Products could not be approved!");
                    }
                },

            });
        }
        $('.deleteProducts').click(function () {
            var data = $(this).attr('data-id');
            $('.deleteModal #dltUserID').val(data);

        });

        $('.deleteProductConfirm').click(function() {

            var id = $('.deleteModal #dltUserID').val();
            $.ajax({
                url: 'delete-pending-products',
                type: 'post',
                data: {"_token": "{{csrf_token()}}",'id' : id},
                dataType: 'json',
                success: function (response) {
                    if(response.status)
                    {
                        swal("Products Deleted Successfully!");
                        document.getElementById('lead-cancel').click();
                        setTimeout(function(){ window.location.reload() }, 2000);
                    }else
                    {
                        swal("Products could not be  deleted!");
                        document.getElementById('lead-cancel').click();
                        setTimeout(function(){ window.location.reload() }, 2000);
                    }

                }
            });
        });
        var ENDPOINT = "{{ url('/') }}";
        var page = 1;
        infinteLoadMore(page);

        $(window).scroll(function () {
            if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
                page++;
                infinteLoadMore(page);
            }
        });

        function infinteLoadMore(page) {
            $.ajax({
                url: ENDPOINT + "/blogs?page=" + page,
                datatype: "html",
                type: "get",
                beforeSend: function () {
                    $('.auto-load').show();
                }
            })
                .done(function (response) {
                    if (response.length == 0) {
                        $('.auto-load').html("We don't have more data to display :(");
                        return;
                    }
                    $('.auto-load').hide();
                    $("#data-wrapper").append(response);
                })
                .fail(function (jqXHR, ajaxOptions, thrownError) {
                    console.log('Server error occured');
                });
        }
    </script>
@endsection
