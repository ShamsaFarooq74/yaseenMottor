@extends('layouts.admin.master')
@section('content')

    <!-- Topbar Start -->
    @include('layouts.admin.blocks.inc.topnavbar')
    <!-- end Topbar -->
    <style>
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
            <div class="col-xl-3">
                <div class="page_left_bar">
                    <a href="" class="active"> Order Details </a>
                    <a href="/order-list">All Orders</a>
                </div>
            </div>
            <div class="col-xl-9 order_detail_vt" id="diary">
                <div class="card-box">
                    <h4 class="header-title_vt mb-3 pl-2">Order Details <button class="print_btn_icon_vt" type="button" value="Print" onclick="window.print()"><i class="fa fa-print" aria-hidden="true"></i></button></h4>
                    <div class="table-responsive">
                        <table class="table table-borderless table-hover table-centered m-0">
                            <div class="order_information">Order Information</div>
                            <thead class="thead-light">
                            <tr>
                                <th>Order ID :</th>
                                <th>Payment Method:</th>
                                <th>Transaction Date :</th>
                                <th>Order Status :</th>
                            </tr>
                            </thead>
                            <tbody id="buyersData">
                            <tr>
                                <td>
                                    {{$orderInformation->id}}
                                </td>
                                <td>
                                    @if($paymentDetail['paymethod'])
                                        @if($paymentDetail['paymethod'] == "Bank Transfer")
                                            @if($paymentDetail['status'] == "Clear")
                                                <i class="fas fa-check-circle"></i>
                                            @else
                                                <i class="fas fa-check-circle fa-uncheck-circle"></i>
                                            @endif
                                        @if(isset($paymentDetail->id))
                                            <a type="button" data-toggle="modal" data-target="#exampleModalCenter"
                                               style="text-decoration: underline; color: #1b4b72; font-weight: 500;">{{$paymentDetail['paymethod']}}</a>
                                         @endif
                                        @else
                                            <a>{{$paymentDetail['paymethod']}}</a>
                                        @endif
                                   @endif
                                </td>
                                <td>
                                    {{$orderInformation->created_at}}
                                </td>
                                <td>
                                    {{$orderInformation->status}}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <div class="table-responsive">
                        <table class="table table-borderless table-hover table-centered m-0">
                            <div class="order_information">Order Details</div>
                            <thead class="thead-light">
                            <tr>
                                <th>Part Name</th>
                                <th>Category</th>
                                <th>Ordered Quantity</th>
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
                                        {{$Order->dispatched_quantity}}
                                    </td>
                                    <td>
                                        {{$Order->price}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <!-- <nav>
                            <ul class="pagination">
                                <li class="page-item disabled" aria-disabled="true" aria-label="« Previous">
                                    <span class="page-link" aria-hidden="true">‹</span>
                                </li>
                                <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>
                                <li class="page-item"><a class="page-link" href="http://192.168.1.250:81/parts?page=2">2</a></li>
                                <li class="page-item"><a class="page-link" href="http://192.168.1.250:81/parts?page=3">3</a></li>
                                <li class="page-item"><a class="page-link" href="http://192.168.1.250:81/parts?page=4">4</a></li>
                                <li class="page-item"><a class="page-link" href="http://192.168.1.250:81/parts?page=5">5</a></li>
                                <li class="page-item"><a class="page-link" href="http://192.168.1.250:81/parts?page=6">6</a></li>
                                <li class="page-item"><a class="page-link" href="http://192.168.1.250:81/parts?page=7">7</a></li>
                                <li class="page-item"><a class="page-link" href="http://192.168.1.250:81/parts?page=8">8</a></li>
                                <li class="page-item"><a class="page-link" href="http://192.168.1.250:81/parts?page=9">9</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="http://192.168.1.250:81/parts?page=2" rel="next" aria-label="Next »">›</a>
                                </li>
                            </ul>
                        </nav> -->
                    </div>
                   
                    <div class="Grand_total_vt">
                        @foreach($orderCalculation as $data)
                        <p>{{$data['manufacture_name']}}({{$data['discount_per']}}%): <span>PKR {{number_format($data['Discounted_amount'])}}</span></p> 
                        @endforeach
                        <p>Total Amount : <span>PKR {{number_format($orderInformation->total_amount+$orderInformation->discount_amount)}}</span></p>
                        <p>Discount Amount: <span>PKR {{number_format($orderInformation->discount_amount)}}</span></p>
                        <p>Grand Total : <span>PKR {{number_format($orderInformation->total_amount )}}</span></p>
                    </div>
    
                </div>
            </div>
        </div>
        <!-- end row -->
    </div> <!-- container -->




    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Payment Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Payment Method</label>
                                    <p>{{$paymentDetail['paymethod']}}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Date</label>
                                    @if( isset($paymentDetail->date))
                                    <p>{{$paymentDetail->date}}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Receipt number</label>
                                    @if(isset($paymentDetail->receiptno))
                                        <p>{{$paymentDetail->receiptno}}</p>
                                    @endif
                                </div>
                            </div>
{{--                            <div class="col-md-12">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="exampleFormControlSelect1">Status</label>--}}
{{--                                    <div class="ptagStatus" id="ifClear">--}}
{{--                                        <p>Clear</p>--}}
{{--                                    </div>--}}
{{--                                    <div class="getStatus" id="getstatus">--}}
{{--                                        <select class="form-control" id="change-pay-status" >--}}
{{--                                            <option value="pending">Pending</option>--}}
{{--                                            <option value="clear">Clear</option>--}}
{{--                                            <option value="cancel">Cancel</option>--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="col-md-12" id="adminProfilePic">
                                <div class="formgroup_vt">
                                    @if(isset($paymentDetail->image))
                                        <img src="{{asset('assets/Ordersdetail/').'/'.$paymentDetail->image}}" alt="">
                                    @else
                                        <img src="{{asset('assets/images/parts.png')}}" alt="">
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                            <div class="row">
                                @if(isset($paymentDetail->status))
                                    @if($paymentDetail->status == 'Pending')
                                        <div class="col-md-4"><button type="button" class="btn_btn4_vt" id="ifClear"  onclick="approve()">Approve</button></div>
                                        <div class="col-md-4"></div>
                                        <div class="col-md-4"><button type="button" class="btn_btn_vt" onclick="reject()">Reject</button></div>
                                    @elseif($paymentDetail->status == 'Clear')
                                        <div class="col-md-4"><button type="button" class="btn_btn2_vt" >Approved</button></div>

                                    @elseif($paymentDetail->status == 'Cancel')
                                        <div class="col-md-4"><button type="button" class="btn_btn3_vt" >Rejected</button></div>
                                    @endif
                                @endif
                                <div class="col-md-4"></div>
                            </div>
                        </div>
                        </div>
                    </form>
                </div>
                <!-- <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-8"></div>
                        <div class="col-md-4"><button type="button" class="btn btn_btn_vt">Save changes</button></div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
    <script type="text/javascript">
        // document.getElementById('ifClear').style.display='none';
        // document.getElementById('getstatus').style.display='block';
        var id = {!! $paymentDetail['id'] !!};

        var getstatus = {!! json_encode($paymentDetail['status']) !!};
        {{--    console.log(getstatus);--}}
        {{--// $("div.getStatus").val(getstatus).change();--}}
        //     if(getstatus == "Clear") {
        //         document.getElementById('ifClear').style.display ='none';
        //         document.getElementById('ifnotSelect').style.display='block';
        //     }


        {{--$("select option").filter(function() {--}}
        {{--    return $(this).text() == getstatus;--}}
        {{--}).prop('selected', true);--}}

         function approve(){
             $.ajax({
                 url: '{{route('pay.status')}}',
                 type: 'post',
                 data: {"_token": "{{csrf_token()}}", 'id': id, 'status': 'clear'},
                 dataType: 'json',
                 success: function (response) {
                     if (response.status) {
                         console.log(response.status);
                         swal("Payment Status change Successfully!");
                         setTimeout(function () {
                             window.location.reload()
                         }, 1500);
                     } else {
                         swal("Payment Status can not be change!");
                         setTimeout(function () {
                             window.location.reload()
                         }, 1500);
                     }

                 }
             });
         }

        function reject(){
            $.ajax({
                url: '{{route('pay.status')}}',
                type: 'post',
                data: {"_token": "{{csrf_token()}}", 'id': id, 'status': 'cancel'},
                dataType: 'json',
                success: function (response) {
                    if (response.status) {
                        console.log(response.status);
                        swal("Payment Status change Successfully!");
                        setTimeout(function () {
                            window.location.reload()
                        }, 1500);
                    } else {
                        swal("Payment Status can not be change!");
                        setTimeout(function () {
                            window.location.reload()
                        }, 1500);
                    }

                }
            });
        }

        {{--$(document).ready(function () {--}}

        {{--    $('#change-pay-status').change(function () {--}}
        {{--        var status = $('#change-pay-status').find(":selected").text();--}}
        {{--        $.ajax({--}}
        {{--            url: '{{route('pay.status')}}',--}}
        {{--            type: 'post',--}}
        {{--            data: {"_token": "{{csrf_token()}}", 'id': id, 'status': status},--}}
        {{--            dataType: 'json',--}}
        {{--            success: function (response) {--}}
        {{--                if (response.status) {--}}
        {{--                    console.log(response.status);--}}
        {{--                    swal("Payment Status change Successfully!");--}}
        {{--                    setTimeout(function () {--}}
        {{--                        window.location.reload()--}}
        {{--                    }, 1500);--}}
        {{--                } else {--}}
        {{--                    swal("Payment Status can not be change!");--}}
        {{--                    setTimeout(function () {--}}
        {{--                        window.location.reload()--}}
        {{--                    }, 1500);--}}
        {{--                }--}}

        {{--            }--}}
        {{--        });--}}
        {{--    });--}}
        {{--});--}}
    </script>
@endsection
