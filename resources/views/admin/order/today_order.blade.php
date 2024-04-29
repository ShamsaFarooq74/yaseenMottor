@extends('layouts.admin.master')
@section('content')


    <!-- Topbar Start -->
    @include('layouts.admin.blocks.inc.topnavbar')
    <!-- end Topbar -->

    <!-- Start Content-->
    <div class="container-fluid">

        <!-- end row-->

        <!-- end row -->

        <div class="row mt-3">
            <div class="col-md-12 home_custome_table mb-3">
                <div class="card-box home_table">
                    <h4 class="header-title_vt mb-3 pl-2">Today's Orders</h4>
{{--                    <div class="form_search_vt">--}}
{{--                        <input type="text" placeholder="Search by username" onkeyup="searchData(this.value);" class="form-control">--}}
{{--                    </div>--}}
                    <div class="card_tabs_vt">

                        <div class="tab-content">
                            <div class="tab-pane show active" id="home-b1">
                                <div class="table-responsive">
                                    <table class="table table-borderless table-hover table-centered m-0">
                                        <thead class="thead-light">
                                        <tr>
                                            <th>Sr</th>
                                            <th>Order By</th>
                                            <th>Total Amount</th>
                                            <th>Ordered At</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody id="activeProducts">
                                        @foreach($approvedOrders as $key => $approvedOrder)
                                            @if($approvedOrder->created_at)
                                                <tr>
                                                    <td>
                                                        {{$key+1}}
                                                    </td>
                                                    <td onclick="window.location='{{route('order.detail',['id'=> $approvedOrder->id])}}'" style="cursor: pointer">
                                                        {{$approvedOrder->username}}
                                                    </td>
                                                    <td>
                                                        {{$approvedOrder->total_amount}}
                                                    </td>
                                                    <td>
                                                        {{$approvedOrder->orderDate}}
                                                    </td>
                                                    <td>
                                                        <div class="btn-group mb-2">
                                                            <button type="button" class="btn btn_info dropdown-toggle"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false" >Action <i
                                                                    class="mdi mdi-chevron-down"></i></button>
                                                            <div class="dropdown-menu">
                                                                <button type="button" class="dropdown-item dispatchOrder" data-toggle="modal" data-target=".dispatch-part-orders" data-id="{{$approvedOrder->id}}">Dispatch</button>
                                                                <button type="button" class="dropdown-item cancelOrder" data-toggle="modal" data-target=".cancel-part-orders" data-id="{{$approvedOrder->id}}">Cancel</button>
                                                            </div>
                                                        </div><!-- /btn-group -->
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @if($approvedOrders)
                                    {!! $approvedOrders->render() !!}
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->

        </div> <!-- container -->

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

<div class="modal fade cancel-part-orders cancelModal" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <input type="hidden" id="cancelOrderID">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <i class="fas fa-exclamation"></i>
                <h4 class="model-heading-vt">Are you sure to cancel <br>this Order ?</h4>
                <div class="modal-footer">
                    <button type="button" class="btn_create_vt cancelConfirm">Yes, Cancel</button>
                    <button type="button" class="btn_close_vt" data-dismiss="modal" id="lead-cancel">Close</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
        <div class="modal fade approve-part-orders approveModal" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <input type="hidden" id="approveOrderID">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <i class="fas fa-exclamation"></i>
                <h4 class="model-heading-vt">Are you sure to accept <br>this Order ?</h4>
                <div class="modal-footer">
                    <button type="button" class="btn_create_vt approveConfirm">Yes, Accept</button>
                    <button type="button" class="btn_close_vt" data-dismiss="modal" id="lead-cancel">Close</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade dispatch-part-orders dispatchModal" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <input type="hidden" id="dispatchOrderID">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <i class="fas fa-exclamation"></i>
                <h4 class="model-heading-vt">Are you sure to Dispatch <br>this Order ?</h4>
                <div class="modal-footer">
                    <button type="button" class="btn_create_vt dispatchConfirm">Yes, Dispatch</button>
                    <button type="button" class="btn_close_vt" data-dismiss="modal" id="lead-cancel">Close</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

        <script>

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
                                            `<button type='button' class='dropdown-item dispatchOrder' data-toggle='modal' data-target='.dispatch-part-orders' data-id='${response.data.data[i]['id']}'  id='deleteTable'>` + 'Dispatched' + "</button>" +
                                            `<button type='button' class='dropdown-item cancelProductId' data-toggle='modal' data-target='.cancel-part-orders' data-id='${response.data.data[i]['id']}'  id='deleteTable'>` + 'Cancel' + "</button>" +
                                            "</div>" +
                                            "</div>" +
                                            "</td>" +
                                            "</tr>"
                                        $("#activeProducts").append(tableBody);
                                        $('.cancelProductId').click(function () {
                                            var data = $(this).attr('data-id');
                                            $('.cancelModal #cancelOrderID').val(data);

                                        });
                                        $('.dispatchOrder').click(function () {
                                            var data = $(this).attr('data-id');
                                            $('.dispatchModal #dispatchOrderID').val(data);

                                        });
                                    }
                                }
                            }
                            if(searchStatus === 'dispatch') {
                                document.getElementById('dispatchProducts').innerHTML = '';
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

                                            "</tr>"
                                        $("#dispatchProducts").append(tableBody);
                                        $('.cancelProductId').click(function () {
                                            var data = $(this).attr('data-id');
                                            $('.cancelModal #cancelOrderID').val(data);

                                        });
                                        $('.dispatchOrder').click(function () {
                                            var data = $(this).attr('data-id');
                                            $('.dispatchModal #dispatchOrderID').val(data);

                                        });
                                    }
                                }
                            }
                            if(searchStatus === 'cancel') {
                                document.getElementById('cancelProducts').innerHTML = '';
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

                                            "</tr>"
                                        $("#cancelProducts").append(tableBody);
                                        $('.cancelProductId').click(function () {
                                            var data = $(this).attr('data-id');
                                            $('.cancelModal #cancelOrderID').val(data);

                                        });
                                        $('.dispatchOrder').click(function () {
                                            var data = $(this).attr('data-id');
                                            $('.dispatchModal #dispatchOrderID').val(data);

                                        });
                                    }
                                }
                            }
                            if(searchStatus === 'pending') {

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
                                            `<button type='button' class='dropdown-item approveProduct' data-toggle='modal' data-target='.approve-part-orders' data-id='${response.data.data[i]['id']}'  id='deleteTable'>` + 'Accept' + "</button>" +

                                            // `<a class="dropdown-item" onclick="approveOrder(${response.data.data[i]['id']})">` + 'Accept' + "</a>" +
                                            `<button type='button' class='dropdown-item cancelProductId' data-toggle='modal' data-target='.cancel-part-orders' data-id='${response.data.data[i]['id']}'  id='deleteTable'>` + 'Cancel' + "</button>" +
                                            "</div>" +
                                            "</div>" +
                                            "</td>" +
                                            "</tr>"
                                        $("#pendingProducts").append(tableBody);
                                        $('.cancelProductId').click(function () {
                                            var data = $(this).attr('data-id');
                                            $('.cancelModal #cancelOrderID').val(data);

                                        });
                                        $('.approveProduct').click(function () {
                                            var data = $(this).attr('data-id');
                                            $('.approveModal #approveOrderID').val(data);

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


            $('.approveProduct').click(function () {
                var data = $(this).attr('data-id');
                $('.approveModal #approveOrderID').val(data);
            });

            $('.approveConfirm').click(function() {

                var id = $('.approveModal #approveOrderID').val();
                $.ajax({
                    url: '{{route('order.approve')}}',
                    type: 'post',
                    data: {"_token": "{{csrf_token()}}",'orderId': id},
                    dataType: 'json',
                    success: function (response) {
                        if(response.status)
                        {
                            swal("Order Accepted Successfully!");
                            document.getElementById('lead-cancel').click();
                            setTimeout(function(){ window.location.reload() }, 1500);
                        }else
                        {
                            swal("Order could not be Accepted!");
                            document.getElementById('lead-cancel').click();
                            setTimeout(function(){ window.location.reload() }, 1500);
                        }

                    }
                });
            });

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


            $('.cancelOrder').click(function () {
                var data = $(this).attr('data-id');
                $('.cancelModal #cancelOrderID').val(data);

            });

            $('.cancelConfirm').click(function() {

                var id = $('.cancelModal #cancelOrderID').val();
                $.ajax({
                    url: '{{route('orders.cancel')}}',
                    type: 'post',
                    data: {"_token": "{{csrf_token()}}",'id' : id},
                    dataType: 'json',
                    success: function (response) {
                        if(response.status)
                        {
                            swal("Order cancelled Successfully!");
                            document.getElementById('lead-cancel').click();
                            setTimeout(function(){ window.location.reload() }, 1500);
                        }else
                        {
                            swal("Order could not be  cancel!");
                            document.getElementById('lead-cancel').click();
                            setTimeout(function(){ window.location.reload() }, 1500);
                        }

                    }
                });
            });
            $('.dispatchOrder').click(function () {
                var data = $(this).attr('data-id');
                $('.dispatchModal #dispatchOrderID').val(data);

            });

            $('.dispatchConfirm').click(function() {

                var id = $('.dispatchModal #dispatchOrderID').val();
                $.ajax({
                    url: '{{route('orders.dispatch')}}',
                    type: 'post',
                    data: {"_token": "{{csrf_token()}}",'id' : id},
                    dataType: 'json',
                    success: function (response) {
                        if(response.status)
                        {
                            swal("Order dispatched Successfully!");
                            document.getElementById('lead-cancel').click();
                            setTimeout(function(){ window.location.reload() }, 1500);
                        }else
                        {
                            swal("Order could not be  dispatch!");
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
