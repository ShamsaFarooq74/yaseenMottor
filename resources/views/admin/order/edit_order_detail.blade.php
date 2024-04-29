@extends('layouts.admin.master')
@section('content')

    <!-- Topbar Start -->
    @include('layouts.admin.blocks.inc.topnavbar')
    <!-- end Topbar -->
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
        }

        /* Firefox */
        input[type=number] {
        -moz-appearance: textfield;
        }
        .form-group p {
            width: 100%;
            float: left;
            border: 1px solid #ccc;
            line-height: 30px;
            padding: 0 15px;
        }

        .fa-check-circle {
            color: green;
        }

        .fa-uncheck-circle {
            color: #ccc;
        }
        .btn_btn2_vt {
            width: 100%;
            height: 35px;
            background: #7aab05 !important;
            box-shadow: none !important;
            border-radius: 4px !important;
            border: none !important;
            margin-left: 165px;
            color: #fff !important;
            font-weight: 500 !important;
            font-size: 12px !important;
        }
        .btn_btn3_vt {
            width: 100%;
            height: 35px;
            background: #ea061d !important;
            box-shadow: none !important;
            border-radius: 4px !important;
            border: none !important;
            margin-left: 165px;
            color: #fff !important;
            font-weight: 500 !important;
            font-size: 12px !important;
        }
        .btn_btn4_vt {
            width: 100%;
            height: 35px;
            background: #7aab05 !important;
            box-shadow: none !important;
            border-radius: 4px !important;
            border: none !important;
            color: #fff !important;
            font-weight: 500 !important;
            font-size: 12px !important;
        }
        .print_btn_icon_vt{
            position: absolute;
            right: 40px;
            top: 13px;
            font-size: 30px;
            color: #000;
            border: none;
            background: none;
        }
        .btn-wrappe_vt{
            display:flex;
            justify-content:end;
        }
        @media print {
            body * {
                visibility: hidden;
            }
            #diary, #diary * {
                visibility: visible;
            }
            #diary {
                position: absolute;
                left: 0;
                top: 0;
            }

        }
    </style>
    <!-- Start Content-->
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-xl-12 order_detail_vt" id="diary">
                <div class="card-box">
                    <h4 class="header-title_vt mb-3 pl-2" style="box-shadow:none;">Order Details <button class="print_btn_icon_vt" type="button" value="Print" onclick="window.print()"><i class="fa fa-print" aria-hidden="true"></i></button></h4>
                    <form class="card p-2" method="POST" action="{{route('update.order.detail',['orderId' => $orderInformation->id])}}" id="orderUpdateForm">
                    @csrf
                    <div class="table-responsive">                   
                        <table class="table table-borderless table-hover table-centered m-0">
                            <div class="order_information">Order Details</div>
                            <thead class="thead-light">
                            <tr>
                                <th>Part Name</th>
                                <th>Category</th>
                                <th>Quantity</th>
                                <th>Dispatched Quantity</th>
                                <th>Price(PKR)</th>
                            </tr>
                            </thead>
                            <tbody id="buyersData">
                            @foreach($OrderDetail as $key => $Order)
                                <tr>
                                    <td>
                                        {{$Order['ref_no']}}
                                    </td>
                                    <td>
                                        {{$Order->category}}
                                    </td>
                                    <td>
                                        {{$Order->quantity}}
                                    </td>
                                    <td>
                                    <input  type="number" id="{{$Order->part_id}}" name="{{$Order->part_id}}" value="{{$Order->quantity}}" placeholder="Enter Quantity" style="border: 1px solid #9F9F9F;border-radius: 5px;outline: none; padding: 2px 6px;">
                                    </td>
                                    <td>
                                        {{$Order->price}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        

                    </div>
                    <div class="btn-wrappe_vt">
                        <!-- <button type="submit" class="dropdown-item dispatchOrder" data-toggle="modal" data-target=".dispatch-part-orders">Dispatch</button> -->
                        <button type="button" class="dropdown-item cancelOrder btn btn_btn_vt" onclick="window.location='{{route('order.list')}}'" style="width:auto; background-color:#ADADAD !important; margin-right:10px;">Cancel</button>
                        <input type="button" class="btn btn_btn_vt" value="Dispatch" class="dropdown-item dispatchOrder" data-toggle="modal" data-target=".dispatch-part-orders" style="width:auto;">
                    </div>
                    </form>
                    <div class="Grand_total_vt">
                        <p>Total Amount : <span id="total_amount">PKR {{number_format($orderInformation->total_amount+$orderInformation->discount_amount)}}</span></p>
                        <p>Discount({{$orderInformation->discount_per}}%) : <span id="discount_per">PKR {{number_format($orderInformation->discount_amount)}}</span></p>
                        <p>Grand Total : <span id="grand_total">PKR {{number_format($orderInformation->total_amount)}}</span></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div> 
    <div class="modal fade dispatch-part-orders dispatchModal" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script type="text/javascript">
      $('.dispatchConfirm').click(function() {
        document.getElementById("orderUpdateForm").submit();
            var id = {!! $orderInformation->id !!}
            $.ajax({
                url: '{{route('orders.dispatch')}}',
                type: 'post',
                data: {"_token": "{{csrf_token()}}",'id' : id},
                dataType: 'json',
                success: function (response) {
                    if(response.status)
                    {

                        // document.getElementById("total_amount").textContent= response.data['amount_after_dispatch']+response.data['discount_amount'];
                        // document.getElementById("discount_per").textContent= response.data['amount_after_dispatch']+response.data['discount_per'];
                        // document.getElementById("grand_total").textContent= response.data['amount_after_dispatch'];
                        // swal("Order dispatched Successfully!");
                        // document.getElementById('lead-cancel').click();
                        // setTimeout(function(){ window.location.reload() }, 1500);
                    }else
                    {
                        // swal("Order could not be  dispatch!");
                        // document.getElementById('lead-cancel').click();
                        // setTimeout(function(){ window.location.reload() }, 1500);
                    }

                }
            });
            });



        //     $('.cancelConfirm').click(function() {

        //         var id = {!! $orderInformation->id !!}
        //     // alert(id);
        //     $.ajax({
        //         url: '{{route('orders.cancel')}}',
        //         type: 'post',
        //         data: {"_token": "{{csrf_token()}}",'id' : id},
        //         dataType: 'json',
        //         success: function (response) {
        //             if(response.status)
        //             {
        //                 console.log(response)
        //                 swal("Order cancelled Successfully!");
        //                 document.getElementById('lead-cancel').click();
        //                 setTimeout(function(){ window.location.reload() }, 1500);
        //             }else
        //             {
        //                 swal("Order could not be  cancel!");
        //                 document.getElementById('lead-cancel').click();
        //                 setTimeout(function(){ window.location.reload() }, 1500);
        //             }

        //         }
        //     });
        // });
    </script>
@endsection
