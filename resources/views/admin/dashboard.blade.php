@extends('layouts.admin.master')
@section('content')
@section('title', '- Dashboard')
<style>
    .home_table .form_search_vt {
        margin-right: 312px !important;
    }
</style>
    <!-- Topbar Start -->
    @include('layouts.admin.blocks.inc.topnavbar')
    <!-- end Topbar -->

    <!-- Start Content-->
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12 mt-3">
                <div class="widget_area_vt">
                    <ul>

                            <li>
                                <a href="{{route('sellers.parts')}}">
                                <h6>Total Cars</h6>
                                <h4>{{$totalParts}}</h4>
                                <small>Total Cars</small>
                                <div class="a_1"><img src="{{asset('assets/images/Group_20.png')}}" alt=""></div>
                                </a>
                            </li>

                        <li><a href="{{ route('settings.make') }}">
                            <h6>Total Makes</h6>
                            <h4>{{$totalMake}}</h4>
                            <small>Total Makes</small>
                            <div class="a_1"><img src="{{asset('assets/images/Group_2.png')}}" alt=""></div>
                            </a>

                        </li>
                        <li><a href="{{route('customer.list')}}">
                            <h6>Total Users</h6>
                            <h4>{{$approvedCustomers}}</h4>
                            <small>Approved Users</small>
                            <div class="a_1"><img src="{{asset('assets/images/Group_5.png')}}" alt=""></div>
                            </a>
                        </li>
                        <li><a href="{{ route('order.list') }}">
                            <h6>Total Inquires</h6>
                            <h4>{{$totalInquires}}</h4>
                            <small>Total Inquires</small>
                            <div class="a_1"><img src="{{asset('assets/images/Group_4.png')}}" alt=""></div>
                            </a>
                        </li>
                        <li>
                            <h6>Cars In Stock</h6>
                            <h4>{{$carInStock}}</h4>
                            <small>Cars In Stock</small>
                            <div class="a_1"><img src="{{asset('assets/images/Group_1.png')}}" alt=""></div>
                        </li>
                    </ul>
                </div>
            </div> <!-- end col-->
        </div>
        <!-- end row-->

        <div class="row">
            <div class="col-md-12 home_custome_table mb-3">
                <div class="card-box">
                    <h4 class="header-title_vt mb-3 pl-2">Cars</h4>
                    <div class="table-responsive">
                        <table class="table table-borderless table-hover table-centered m-0">
                            <thead class="thead-light">
                            <tr>
                                <th>Sr</th>
                                <th>Ref No</th>
                                <th>Make</th>
                                <th>Name</th>
                                <!-- <th>Category</th> -->
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($parts as $key => $part)
                                @if($part->ref_no)
                                    <tr >
                                        {{--                                        <div >--}}
                                        <td>
                                            {{$key + 1}}
                                        </td>
                                        <td onclick="window.location='{{route('sellers.parts.details', ['partId' => $part->id])}}'" style="cursor: pointer">
                                            {{$part->ref_no}}
                                        </td>
                                        {{-- @for($i=0; $i<2; $i++)

                                            @if($part->make[$i] !=null)
                                            <td onclick="window.location='{{route('sellers.parts.details', ['partId' => $part->id])}}'" style="cursor: pointer">
                                                {{$part->make[$i]}}
                                            </td>
                                            @else
                                            <td onclick="window.location='{{route('sellers.parts.details', ['partId' => $part->id])}}'" style="cursor: pointer">
                                                    ...
                                            </td>
                                            @endif
                                        @endfor --}}
                                        {{-- @dd($part['make'][1]) --}}
                                        <!-- @if($part->make)
                                            <td onclick="window.location='{{route('sellers.parts.details', ['partId' => $part->id])}}'" style="cursor: pointer">
                                                {{$part->make[0]}}{{isset($part->make[1]) ? ", ".$part->make[1]."..." : ""}}
                                            </td>
                                        @endif -->
                                              
                                        <td onclick="window.location='{{route('sellers.parts.details', ['partId' => $part->id])}}'" style="cursor: pointer">
                                             {{ $part->make->make }}
                                        </td>
                                        <td onclick="window.location='{{route('sellers.parts.details', ['partId' => $part->id])}}'" style="cursor: pointer">
                                            <!-- {{$part->manufacturer}} -->
                                            {{ \Carbon\Carbon::parse($part->reg_no)->format('Y').' '.strtoupper($part->make->make).'  '.substr(strtoupper($part->version),0,3)}}
                                        </td>
                                        <!-- <td onclick="window.location='{{route('sellers.parts.details', ['partId' => $part->id])}}'" style="cursor: pointer">
                                            {{$part->category}}
                                        </td> -->
                                        <td onclick="window.location='{{route('sellers.parts.details', ['partId' => $part->id])}}'" style="cursor: pointer">
                                            {{$part->price}}
                                        </td>
                                        <!-- <td>
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
                                        </td> -->
                                        {{--                                        </div>--}}
                                        <td>
                                            <div class="btn-group mb-2">
                                                <button type="button" class="btn btn_info dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">Action <i
                                                        class="mdi mdi-chevron-down"></i></button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" onclick="window.location='{{route('sellers.parts.add', ['partId' => $part->id])}}'">Edit</a>
                                                    <button type="button" class="dropdown-item deletePartDetails"
                                                            data-toggle="modal"
                                                            data-target=".parts-dashboard-data"
                                                            data-id="{{$part->id}}">Delete
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
                </div>
            </div>
        </div>
        <!-- end row -->
        <div class="modal fade parts-dashboard-data deleteModal" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-dialog-centered">
                <input type="hidden" id="dltUserID">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <i class="fas fa-exclamation"></i>
                        <h4 class="model-heading-vt">Are you sure to delete <br>this Part ?</h4>
                        <div class="modal-footer">
                            <button type="button" class="btn_create_vt deleteProductConfirm">Yes, Delete</button>
                            <button type="button" class="btn_close_vt" data-dismiss="modal" id="lead-cancel">Close</button>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->        
    </div>
         <!-- container -->

<div class="modal fade delete-part-orders deleteModal" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <input type="hidden" id="dltUserID">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <i class="fas fa-exclamation"></i>
                <h4 class="model-heading-vt">Are you sure to delete <br>this Order ?</h4>
                <div class="modal-footer">
                    <button type="button" class="btn_create_vt deleteConfirm">Yes, Delete</button>
                    <button type="button" class="btn_close_vt" data-dismiss="modal" id="lead-cancel">Close</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


        <img id="mapMarkerIcon" src="{{ asset('assets/images/map_marker.svg')}}" alt="setting" style="display: none;">


        <script>
            if(window.location.search.match('approved_order')){
                    document.getElementById('activeTab').className ="nav-link active";
                    document.getElementById('nonActive').className ="nav-link";
                    var x = "true";
                    var y = "false"
                    document.getElementById('nonActive').setAttribute("aria-expanded",x);
                    document.getElementById('activeTab').setAttribute('aria-expanded',y);
                    $('#home-b1').addClass("show active");
                    $('#profile-b1').removeClass("show active");

                    }


            function approveOrder(orderId) {
                if (confirm('Are you sure you want to approve this order?')) {
                    $.ajax({
                        url: '{{route('order.approve')}}',
                        type: 'post',
                        data: {"_token": "{{csrf_token()}}",'orderId': orderId},
                        dataType: 'json',
                        success: function (response) {
                            if (response.status) {
                                swal("Order approved Successfully!");
                                setTimeout(function () {
                                    window.location.reload()
                                }, 1500);
                            } else {
                                swal("Order could not be approved.Please try again later");
                            }

                        },

                    });
                }
            }
            let searchStatus = 'pending';
            function status(status)
            {
                searchStatus = status;
            }
            function searchData(value)
            {
                console.log(searchStatus);
                if(value) {
                    let type = '';
                    $.ajax({
                        url: 'search-orders',
                        type: 'get',
                        data: {"_token": "{{csrf_token()}}", 'value': value, 'type': searchStatus},
                        dataType: 'json',
                        success: function (response) {
                            console.log(response.data.data);
                            // let table = document.getElementById('activeProducts');
                            if(searchStatus === 'active') {
                                document.getElementById('activeProducts').innerHTML = '';
                                for (let i = 0; i < response.data.data.length; i++) {
                                    if (response.data.data[i]['username']) {
                                        // console.log(response.data.data[i]);

                                        let id = response.data.data[i]['id'];
                                        let tableBody = "<tr>" +
                                            "<td>"
                                            +
                                            i + 1
                                            +
                                            "</td>" +
                                            "<td>"
                                            +
                                            response.data.data[i]['username']
                                            +
                                            "</td>" +
                                            "<td>"
                                            +
                                            response.data.data[i]['total_amount']
                                            +
                                            "</td>"
                                            +
                                            "<td>"
                                            +
                                            response.data.data[i]['orderDate']
                                            +
                                            "</td>"

                                            +
                                            "<td>"
                                            +
                                            "<div class='btn-group mb-2'>" +
                                            "<button type='button' class='btn btn_info dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' >" + 'Action' +
                                            "<i class='mdi mdi-chevron-down'> " + "</i>" + "</button>" +
                                            "<div class='dropdown-menu'>" +
                                            `<button type='button' class='dropdown-item deleteProductId' data-toggle='modal' data-target='.bs-example-modal-center' data-id='${response.data.data[i]['id']}'  id='deleteTable'>` + 'Delete' + "</button>" +
                                            "</div>" +
                                            "</div>" +
                                            "</td>" +
                                            "</tr>"
                                        $("#activeProducts").append(tableBody);
                                        $('.deleteProductId').click(function () {
                                            var data = $(this).attr('data-id');
                                            $('.deleteModal #dltUserID').val(data);

                                        });
                                    }
                                }
                            }
                            else
                            {

                                document.getElementById('pendingProducts').innerHTML = '';
                                for (let i = 0; i < response.data.data.length; i++) {
                                    if (response.data.data[i]['username']) {
                                        let id = response.data.data[i]['id'];
                                        let tableBody = "<tr>" +
                                            "<td>"
                                            +
                                            i + 1
                                            +
                                            "</td>" +
                                            "<td>"
                                            +
                                            response.data.data[i]['username']
                                            +
                                            "</td>" +
                                            "<td>"
                                            +
                                            response.data.data[i]['total_amount']
                                            +
                                            "</td>"
                                            +
                                            "<td>"
                                            +
                                            response.data.data[i]['orderDate']
                                            +
                                            "</td>"
                                            +
                                            "<td>"
                                            +
                                            "<div class='btn-group mb-2'>" +
                                            "<button type='button' class='btn btn_info dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' >" + 'Action' +
                                            "<i class='mdi mdi-chevron-down'> " + "</i>" + "</button>" +
                                            "<div class='dropdown-menu'>" +
                                            `<a class="dropdown-item" onclick="approveLeads(${response.data.data[i]['id']})">` + 'Approve' + "</a>" +
                                            `<button type='button' class='dropdown-item deleteProductId' data-toggle='modal' data-target='.bs-example-modal-center' data-id='${response.data.data[i]['id']}'  id='deleteTable'>` + 'Delete' + "</button>" +
                                            "</div>" +
                                            "</div>" +
                                            "</td>" +
                                            "</tr>"
                                        $("#pendingProducts").append(tableBody);
                                        $('.deleteProductId').click(function () {
                                            var data = $(this).attr('data-id');
                                            $('.deleteModal #dltUserID').val(data);

                                        });
                                    }
                                }
                            }
                        },

                    });
                }
                else
                {
                    window.location.reload()
                }
            }
            function approveLeads(id)
            {
                $.ajax({
                    url: 'approve-leads',
                    type: 'post',
                    data: {"_token": "{{csrf_token()}}",'id' : id},
                    dataType: 'json',
                    success: function (response) {
                        if(response.status) {
                            swal("Leads approved Successfully!");
                           setTimeout(function(){ window.location.reload() }, 2000);
                        }
                        else
                        {
                            swal("Leads could not be approved!");
                        }
                    },

                });
            }
            $('.deleteProduct').click(function () {
                var data = $(this).attr('data-id');
                $('.deleteModal #dltUserID').val(data);

            });

            $('.deleteConfirm').click(function() {

                var id = $('.deleteModal #dltUserID').val();
                $.ajax({
                    url: '{{route('orders.delete')}}',
                    type: 'post',
                    data: {"_token": "{{csrf_token()}}",'id' : id},
                    dataType: 'json',
                    success: function (response) {
                        if(response.status)
                        {
                            swal("Orders Deleted Successfully!");
                            document.getElementById('lead-cancel').click();
                            setTimeout(function(){ window.location.reload() }, 1500);
                        }else
                        {
                            swal("Orders could not be  deleted!");
                            document.getElementById('lead-cancel').click();
                            setTimeout(function(){ window.location.reload() }, 1500);
                        }

                    }
                });
            });
            $('.deletePartDetails').click(function () {
                var data = $(this).attr('data-id');
                $('.deleteModal #dltUserID').val(data);

            });

            $('.deleteProductConfirm').click(function() {

                var id = $('.deleteModal #dltUserID').val();
                $.ajax({
                    url: '{{route('delete.parts')}}',
                    type: 'post',
                    data: {"_token": "{{csrf_token()}}",'id' : id},
                    dataType: 'json',
                    success: function (response) {
                        if(response.status)
                        {
                            swal("Parts Deleted Successfully!");
                            document.getElementById('lead-cancel').click();
                            setTimeout(function(){ window.location.reload() }, 1500);
                        }else
                        {
                            swal("Parts could not be  deleted!");
                            document.getElementById('lead-cancel').click();
                            setTimeout(function(){ window.location.reload() }, 1500);
                        }

                    }
                });
            });
        </script>


@endsection
