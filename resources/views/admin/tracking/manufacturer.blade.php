@extends('layouts.admin.master')
@section('content')
    <!-- Topbar Start -->
    @include('layouts.admin.blocks.inc.topnavbar')
    <!-- end Topbar -->
    <style>
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            margin: 0;
        }
    </style>
    <!-- Start Content-->
    <div class="container-fluid mt-3">
        {{-- @include('admin.alert-message') --}}

        <div class="row">
            <div class="col-xl-12 home_custome_table">
                <div class="card-box three_table">
                    <h4 class="header-title_vt mb-3 pl-2">Manufacture</h4>
                    <div class="card_tabs_vt">
                        <!-- <ul class="nav nav-tabs nav-bordered" id="editAdminTab">
                            <li class="nav-item">
                                <a href="#home-b1" data-toggle="tab" aria-expanded="false" class="nav-link active"
                                    onclick="editAdminTab()">
                                    All Admins
                                </a>
                            </li>
                        </ul> -->
                        <div class="tab-content">
                            <div class="tab-pane show active" id="home-b1">
                                <div class="table-responsive">
                                    <table class="table table-borderless table-hover table-centered m-0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Sr</th>
                                                <th>Manufacture</th>
                                                <!-- <th>Discount(%)</th> -->
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($allManufacturer as $key => $manufacturer)
                                                    <tr>
                                                        <td>
                                                            {{ $key + 1 }}
                                                        </td>
                                                        <td>
                                                                {{ $manufacturer->manufacture }}
                                                        </td>
                                                        <!-- <td>
                                                            {{ $manufacturer->discount_per }}%
                                                        </td> -->
                                                        <td>
                                                            {{ $manufacturer->is_active == 'Y' ? "Active" : "InActive" }}
                                                        </td>
                                                        <td>
                                                            <div class="btn-group mb-2">
                                                                <button type="button" class="btn btn_info dropdown-toggle"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">Action <i
                                                                        class="mdi mdi-chevron-down"></i></button>
                                                                <div class="dropdown-menu">
                                                                    <a class="dropdown-item"
                                                                        onclick="editAdmin({{ $manufacturer->id }})">Edit</a>
                                                                    <!-- <button type="button" class="dropdown-item deleteAdmin"
                                                                        data-toggle="modal"
                                                                        data-target=".bs-example-modal-center115"
                                                                        data-id="{{ $manufacturer->id }}">Delete
                                                                    </button> -->
                                                                </div>
                                                            </div><!-- /btn-group -->
                                                        </td>
                                                    </tr>
                                                
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="profile-b1" style="display: none">
                                <form class="card p-2" method="post"
                                    action="{{ route('manufacturer.update') }}"
                                    enctype="multipart/form-data" id="adminForm">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3 class="page_head_vt" id="adminHeading12">Update Manufacture</h3>
                                        </div>
                                        <input type="hidden" id="manufacturer_id" name="manufacturer_id">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="manufacturerName">Manufacturer Name<span class="star_vt">*</span></label>
                                                <input class="form-control" type="text" id="manufacturerName" name="manufacturerName"
                                                    required="" placeholder="Enter Name">
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="discount">Discount(%)<span class="star_vt">*</span></label>
                                                <input class="form-control" type="number" id="discount" name="discount"
                                                    required="" placeholder="Enter discount" autocomplete="off">
                                            </div>
                                        </div> -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="manufacture_status">Status<span class="star_vt">*</span></label>
                                                <select class="form-control" id="manufacture_status" name="manufacture_status" disabled>
                                                    <option value='Y'>Active</option>
                                                    <option value='N'>Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-end">
                                        <div class="col-md-2 pl-0">
                                            <div class="form-group mb-0 text-center">
                                                <button class="btn btn_btn_vt" type="submit" id="submitButton112"> Update</button>
                                            </div>
                                        </div>
                                    </div>        
                                </form>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div> <!-- container -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script>
        function editAdmin(id) {
            document.getElementById("profile-b1").style.display="block";
            document.getElementById("home-b1").style.display="none";
            $.ajax({
                url: '{{route('manufacturer.fetch')}}',
                type: 'get',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'id': id
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status) {
                        document.getElementById('manufacturer_id').value = response.data.id;
                        document.getElementById('manufacturerName').value = response.data.manufacture;
                        document.getElementById('discount').value = response.data.discount_per;
                        document.getElementById("manufacture_status").value = response.data.is_active;
                    }

                    
                }
            });
        }

    
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
    </script>
@endsection
