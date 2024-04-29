@extends('layouts.admin.master')
@section('content')

<!-- Topbar Start -->
@include('layouts.admin.blocks.inc.topnavbar')
<!-- end Topbar -->

<!-- Start Content-->
<div class="container-fluid mt-3">
    @include('admin.alert-message')

    <div class="row">
        <div class="col-xl-12 home_custome_table">
            <div class="card-box home_table">
                <h4 class="header-title_vt mb-3 pl-2">Payment</h4>
                <div class="card_tabs_vt">
                    <ul class="nav nav-tabs nav-bordered">
                        <li class="nav-item">
                            <a href="#home-b1" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                Approved
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#profile-b1" data-toggle="tab" aria-expanded="true" class="nav-link ">
                                Pending
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane show active" id="home-b1">
                            <div class="table-responsive">
                                <table class="table table-borderless table-hover table-centered m-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Id</th>
                                            <th>User Name</th>
                                            <th>Receipt</th>
                                            <th>Transaction</th>
                                            <th>Payment date</th>
                                            <th>Amount</th>
                                            <th>Lead</th>
{{--                                            <th>Action</th>--}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($approvedPayment as $key => $payment)
                                        <tr>
                                            <td>
                                                {{$key+1}}
                                            </td>
                                            <td>
                                                {{$payment->userName}}
                                            </td>
                                            <td>
                                                <a href="" data-toggle="modal" data-target=".bs-example-modal-center"><img src="{{$payment->receipt}}" alt="" onclick="setPayment({{json_encode($payment->receipt)}})"></a>
                                            </td>
                                            <td>
                                                {{$payment->transaction_id}}
                                            </td>
                                            <td>
                                                {{$payment->payment_date}}
                                            </td>
                                            <td>
                                                {{$payment->amount}}
                                            </td>
                                            <td>
                                                {{$payment->leads}}
                                            </td>
{{--                                            <td>--}}
{{--                                                <div class="btn-group mb-2">--}}
{{--                                                    <button type="button" class="btn btn_info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <i class="mdi mdi-chevron-down"></i></button>--}}
{{--                                                    <div class="dropdown-menu">--}}
{{--                                                        <button type="button" class="dropdown-item" data-toggle="modal" data-target=".bs-example-modal-center">Delete</button>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </td>--}}
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if($approvedPayment)
                                {!! $approvedPayment->render() !!}
                            @endif
                        </div>
                        <div class="tab-pane" id="profile-b1">
                            <div class="table-responsive">
                                <table class="table table-borderless table-hover table-centered m-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Id</th>
                                            <th>User Name</th>
                                            <th>Receipt</th>
                                            <th>Transaction</th>
                                            <th>Payment date</th>
                                            <th>Amount</th>
                                            <th>Lead</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($pendingPayment as $key => $payment)
                                        <tr>
                                            <td>
                                                {{$key+1}}
                                            </td>
                                            <td>
                                                {{$payment->userName}}
                                            </td>
                                            <td>
                                                <a href="" data-toggle="modal" data-target=".bs-example-modal-center"><img src="{{$payment->receipt}}" alt="" onclick="setPayment({{json_encode($payment->receipt)}})"></a>
                                            </td>
                                            <td>
                                                {{$payment->transaction_id}}
                                            </td>
                                            <td>
                                                {{$payment->payment_date}}
                                            </td>
                                            <td>
                                                {{$payment->amount}}
                                            </td>
                                            <td>
                                                {{$payment->leads}}
                                            </td>
                                            <td>
                                                <div class="btn-group mb-2">
                                                    <button type="button" class="btn btn_info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <i class="mdi mdi-chevron-down"></i></button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" onclick="approvePayment({{$payment->id}})">Approve</a>
                                                        <button type="button" class="dropdown-item deletePayment" data-toggle="modal" data-target=".bs-example-modal-center12" data-id="{{$payment->id}}">Delete</button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if($pendingPayment)
                                {!! $pendingPayment->render() !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bs-example-modal-center12 deleteModal" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <input type="hidden" id="dltUserID">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <i class="fas fa-exclamation"></i>
                    <h4 class="model-heading-vt">Are you sure to delete <br>this Payment ?</h4>
                    <div class="modal-footer">
                        <button type="button" class="btn_create_vt deleteConfirm">Yes, Delete</button>
                        <button type="button" class="btn_close_vt" data-dismiss="modal" id="lead-cancel">Close</button>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- end row -->
    <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myCenterModalLabel">Receipt</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body text_feed text-center">
                    <img src="{{asset('assets/images/profile.png')}}" alt="" id="paymentImage">
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

<script>
    function setPayment(receipt)
    {
        document.getElementById('paymentImage').removeAttribute('src');
        document.getElementById('paymentImage').setAttribute('src', receipt);
    }
    $('.deletePayment').click(function () {
        let data = $(this).attr('data-id');
        $('.deleteModal #dltUserID').val(data);

    });

    $('.deleteConfirm').click(function() {
        let id = $('.deleteModal #dltUserID').val();
        $.ajax({
            url: '{{route('payment.delete')}}',
            type: 'post',
            data: {"_token": "{{csrf_token()}}",'id' : id},
            dataType: 'json',
            success: function (response) {
                if(response.status)
                {
                    swal("Payment deleted successfully!");
                    document.getElementById('lead-cancel').click();
                    setTimeout(function(){ window.location.reload() }, 1000);
                }else
                {
                    swal("Payment could not be  deleted.Please try again!");
                    document.getElementById('lead-cancel').click();
                    setTimeout(function(){ window.location.reload() }, 1000);
                }

            }
        });
    });
    function approvePayment(id)
    {
        $.ajax({
            url: '{{route('payment.approve')}}',
            type: 'get',
            data: {'id' : id},
            dataType: 'json',
            success: function (response) {
                if(response.status)
                {
                    swal("Payment approved successfully!");
                    document.getElementById('lead-cancel').click();
                    setTimeout(function(){ window.location.reload() }, 1000);
                }else
                {
                    swal("Payment could not be  approve.Please try again!");
                    document.getElementById('lead-cancel').click();
                    setTimeout(function(){ window.location.reload() }, 1000);
                }

            }
        });
    }
</script>
    @endsection
