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
       .toggle {
            position: relative;
            padding-top: 37px;
            }
        .toggle input[type="checkbox"] {
            position: absolute;
            left: 0;
            top: 0;
            z-index: 10;
            width: 100%;
            height: 100%;
            cursor: pointer;
            opacity: 0;
        }
        .toggle label {
            position: relative;
            display: flex;
            align-items: center;
        }
        .toggle label:before {
            content: '';
            width: 40px;
            height: 18px;
            background: #ccc;
            position: relative;
            display: inline-block;
            border-radius: 46px;
            transition: 0.2s ease-in;
            margin-right: 5px;
        }
        .toggle label:after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            left: 0;
            top: 1px;
            z-index: 2;
            background: #fff;
            box-shadow: 0 0 5px #0002;
            transition: 0.2s ease-in;
        }
        .toggle input[type="checkbox"]:hover + label:after  {
            box-shadow: 0 2px 15px 0 #0002, 0 3px 8px 0 #0001;
        }
        .toggle input[type="checkbox"]:checked + label:before {
            background: #E02329;
        }
        .toggle input[type="checkbox"]:checked + label:after {
            background: #ffffff;
            left: 21px;
        } 
    </style>
    <!-- Start Content-->
    <div class="container-fluid mt-3">
        {{-- @include('admin.alert-message') --}}

        <div class="row">
            <div class="col-xl-12 home_custome_table">
                <div class="card-box three_table">
                    <h4 class="header-title_vt mb-3 pl-2">Admin</h4>
                    <div class="card_tabs_vt">
                        <ul class="nav nav-tabs nav-bordered" id="addAdminTab">
                            <li class="nav-item">
                                <a href="#home-b1" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                    All Admins
                                </a>
                            </li>
                            <!-- <li class="nav-item">
                                                            <a href="" data-toggle="tab" aria-expanded="true" class="nav-link">
                                                                All Customers
                                                            </a>
                                                        </li> -->
                            <li class="nav-item">
                                <a href="#profile-b1" data-toggle="tab" aria-expanded="true" class="nav-link"
                                    id="editAdmin1" onclick="createAdmin()">
                                    Create User
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-tabs nav-bordered" id="editAdminTab">
                            <li class="nav-item">
                                <a href="#home-b1" data-toggle="tab" aria-expanded="false" class="nav-link active"
                                    onclick="editAdminTab()">
                                    All Admins
                                </a>
                            </li>
                            <!-- <li class="nav-item">
                                                            <a href="" data-toggle="tab" aria-expanded="false" class="nav-link">
                                                                All Customers
                                                            </a>
                                                        </li> -->
                            <li class="nav-item">
                                <a href="#profile-b1" data-toggle="tab" aria-expanded="true" class="nav-link"
                                    id="editAdmin1">
                                    Update Admin
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
                                                <th>Name</th>
                                                <th>Phone</th>
                                                <th>Email</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $key => $user)
                                                @if ($user->username)
                                                    <tr>
                                                        <td>
                                                            {{ $key + 1 }}
                                                        </td>
                                                        <td>
                                                            <a href="#">
                                                                <img src="{{ $user->image }}" alt="">

                                                                {{ $user->username }}
                                                            </a>

                                                        </td>
                                                        <td>
                                                            {{ $user->phone }}
                                                        </td>
                                                        <td>
                                                            {{ $user->email }}
                                                        </td>
                                                        <td>
                                                            {{ $user->is_active == 'Y' ? ($user->is_active = 'Active') : ($user->is_active = 'Inactive') }}
                                                        </td>
                                                        <td>
                                                            <div class="btn-group mb-2">
                                                                <button type="button" class="btn btn_info dropdown-toggle"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">Action <i
                                                                        class="mdi mdi-chevron-down"></i></button>
                                                                <div class="dropdown-menu">
                                                                    <a class="dropdown-item"
                                                                        onclick="editAdmin({{ $user->id }},{{ json_encode($user->username) }},{{ json_encode($user->email) }},{{ json_encode($user->is_active) }},{{ json_encode($user->image) }},{{ json_encode($user->phone) }})">Edit</a>
                                                                    <button type="button" class="dropdown-item deleteAdmin"
                                                                        data-toggle="modal"
                                                                        data-target=".bs-example-modal-center115"
                                                                        data-id="{{ $user->id }}">Delete
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
                                @if ($users)
                                    {{ $users->links() }}
                                @endif
                            </div>
                            <div class="tab-pane" id="home-b2">
                                <div class="table-responsive">
                                    <table class="table table-borderless table-hover table-centered m-0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Sr</th>
                                                <th>Name</th>
                                                <th>Phone</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($customers as $key => $customer)
                                                @if ($customer->username)
                                                    <tr>
                                                        <td>
                                                            {{ $key + 1 }}
                                                        </td>
                                                        <td>
                                                            <a href="#">
                                                                <img src="{{ $customer->image }}" alt="">

                                                                {{ $customer->username }}
                                                            </a>

                                                        </td>
                                                        <td>
                                                            {{ $customer->phone }}
                                                        </td>
                                                        <td>
                                                            {{ $customer->is_active == 'Y' ? ($customer->is_active = 'Active') : ($customer->is_active = 'Inactive') }}
                                                        </td>
                                                        <td>
                                                            <div class="btn-group mb-2">
                                                                <button type="button" class="btn btn_info dropdown-toggle"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">Action <i
                                                                        class="mdi mdi-chevron-down"></i></button>
                                                                <div class="dropdown-menu">
                                                                    <a class="dropdown-item"
                                                                        onclick="editAdmin({{ $customer->id }},{{ json_encode($customer->username) }},{{ json_encode($customer->email) }},{{ json_encode($customer->is_active) }},{{ json_encode($customer->image) }},{{ json_encode($customer->phone) }})">Edit</a>
                                                                    <button type="button" class="dropdown-item deleteAdmin"
                                                                        data-toggle="modal"
                                                                        data-target=".bs-example-modal-center"
                                                                        data-id="{{ $customer->id }}">Delete
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
                                @if ($customers)
                                    {{ $customers->links() }}
                                @endif
                            </div>
                            <div class="tab-pane" id="profile-b1">
                                <form class="card p-2" method="post"
                                    action="{{ route('admin.add', ['adminId' => $adminId]) }}"
                                    enctype="multipart/form-data" id="adminForm">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3 class="page_head_vt" id="adminHeading12">Create User</h3>
                                        </div>
                                        <div class="col-md-12" id="adminProfilePic">
                                            <div class="formgroup_vt">
                                                <img src="{{ asset('assets/images/users/user-icon.jpg') }}" alt=""
                                                    id="adminImage">
                                                <span>
                                                    <i class="fas fa-pen imageUpload" type="file">
                                                    </i>
                                                </span>
                                                <input style="display: none" type="file" name="admin-image"
                                                    id="imageUploadInput">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="adminName">Name<span class="star_vt">*</span></label>
                                                <input class="form-control" type="text" id="adminName" name="name"
                                                    required="" placeholder="Enter Name">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                                   <div class="form-group">
                                                       <label for="adminemail">Email<span class="star_vt">*</span></label>
                                                        <input class="form-control" type="email" id="email12" name="email"
                                                      required="" placeholder="Enter email" autocomplete="off">
                                                  </div>
                                               </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="user-type">Type<span class="star_vt">*</span></label>
                                                <select class="form-control" id="user-type" name="type">
                                                    <option value='1'>Admin</option>
                                                    <option value='2'>User</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="adminPhone">Phone<span class="star_vt">*</span></label>
                                                <input class="form-control" type="phone" id="phone12" name="phone"
                                                    required="" placeholder="Enter Phone" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="adminStatusField">Status<span
                                                        class="star_vt">*</span></label>
                                                <select class="form-control" id="adminStatusField" name="status">
                                                    <option>Active</option>
                                                    <option>Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div id="editAdmin">
                                            <div class="row">
                                                <div class="col-md-12" id="editAdminPassword">
                                                    <div class="form-group">
                                                        <input type="checkbox" id="editPassword" name="vehicle1"
                                                            value="false">
                                                        <label for="editPassword"> Edit password</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6" id="PasswordDiv">
                                                    <div class="form-group">
                                                        <label for="show-password">Password<span
                                                                class="star_vt">*</span></label>
                                                        <input class="form-control" type="text" name="password"
                                                            placeholder="***********" autocomplete="off" id="show-password">
                                                    </div>
                                                </div>
                                                <div class="col-md-6" id="ConfirmPasswordDiv">
                                                    <div class="form-group">
                                                        <label for="confirmPassword">Confirm Password<span
                                                                class="star_vt">*</span></label>
                                                        <input class="form-control" type="text" id="confirmPassword"
                                                            name="confirm_password" placeholder="***********"
                                                            autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="col-md-12" id="ConfirmPasswordDiv">
                                                    {{-- <div style="display: none" id="select-manufacturer"
                                                        class="form-group">

                                                        <label for="manufacturer-data">Manufacturer</label>
                                                        <div id="manufact" class="manufact">
                                                            <select class="js-example-basic-multiple" name="manufacturer"
                                                                id="manufacturer-data" onChange="myNewFunction(this)">
                                                                <option value="">-Select Manufacturer-</option>
                                                                @foreach ($manufacturer as $key => $manufact)
                                                                    <option value='{{ $manufact->id }}'>
                                                                        {{ $manufact->manufacture }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                    </div> --}}
                                                         <div style="display: none;" id="discount" class="row" id="ConfirmPasswordDiv">
                                                         
                                                            @foreach ($manufacturer as $key => $manufact)
                                                            <div class="col-md-6 mb-3">
                                                                <label for="discount">Discount of
                                                                    {{ $manufact->manufacture }}</label>

                                                                <input class="form-control" type="number" id="discount" value="{{ $manufact->discount_per }}"
                                                                    name="{{$manufact->id }}"
                                                                    placeholder="Enter discount" autocomplete="off">
                                                            </div>
                                                                @endforeach  
                                                        </div> 
                                                        
                                                        <!-- <div style="display: none;" id="discount" class="row" id="ConfirmPasswordDiv">
                                                            <div class="col-md-6 mb-3">
                                                                <label for="discount">Add User Discount(%)</label>

                                                                <input class="form-control" type="number" id="discount" value=""
                                                                    name="discount"
                                                                    placeholder="Enter discount" autocomplete="off">
                                                            </div>
                                                        </div> -->


                                                    {{-- <div class="col-md-10"></div>
                                                    <div class="col-md-2">
                                                        <div class="form-group mb-0 text-center">
                                                            <button id="addMore" style="display: none">Add More
                                                                Manufacturer</button>
                                                        </div>

                                                    </div> --}}

                                                </div>
                                            </div>
                                            <div class="col-md-10"></div>
                                            <div class="col-md-2 pl-0">
                                                <div class="form-group mb-0 text-center">
                                                    <button class="btn btn_btn_vt" type="submit" id="submitButton112"> Add
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
    <div class="modal fade bs-example-modal-center115 deleteModal" tabindex="-1" role="dialog"
        aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <input type="hidden" id="dltUserID">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <i class="fas fa-exclamation"></i>
                    <h4 class="model-heading-vt">Are you sure to delete <br>this admin ?</h4>
                    <div class="modal-footer">
                        <button type="button" class="btn_create_vt deleteAdminConfirm">Yes, Delete</button>
                        <button type="button" class="btn_close_vt" data-dismiss="modal" id="admin-cancel">Close</button>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script>
        var errorData = "{{ Session::get('error') }}";
        console.log(errorData);
        $(".imageUpload").click(function() {
            $("input[type='file']").trigger('click');
        });
        $('input[type="file"]').on('change', function() {
            var val = $(this).val();
            var file = $("input[type=file]").get(0).files[0];

            if (file) {
                let reader = new FileReader();

                reader.onload = function() {
                    document.getElementById('adminImage').style.display = 'block';
                    document.getElementById('adminImage').setAttribute('src', reader.result);
                }

                reader.readAsDataURL(file);
            }
        });
        $("#user-type").change(function() {
            if ($(this).val() === '1') {
                $("#select-manufacturer").css("display", "none");

                $("#addMore").css("display", "none");
                $("#discount").css("display", "none");
                $("#user_type").css("display", "none");

            } else {

                $("#select-manufacturer").show();
                $("#addMore").show();
                $("#discount").show();
                $("#user_type").show();
            }
        });
        var id;
        function myNewFunction(sel) {
            var id = sel.options[sel.selectedIndex].value;
            console.log(id);
            document.getElementById("discount").value=id;

        }
        $(function() {
            $("#addMore").click(function(e) {
                var newSelect = $("#manufacturer-data").clone();
                var newField = $("#discount").clone();
                // newSelect.val("");

                $("#manufact").append(newSelect, newField);
            });
        });


        document.getElementById('PasswordDiv').style.display = 'block';
        document.getElementById('ConfirmPasswordDiv').style.display = 'block';
        document.getElementById('editAdminTab').style.display = 'none';
        // document.getElementById('adminProfilePic').style.display = 'none';
        // document.getElementById('adminImage').style.display = 'none';
        document.getElementById('editAdminPassword').style.display = 'none';
        document.getElementById('confirmPassword').innerHTML = '';
        document.getElementById('show-password').innerHTML = '';
        $('#editPassword:checkbox').bind('change', function(e) {
            if ($(this).is(':checked')) {
                document.getElementById('PasswordDiv').style.display = 'block';
                document.getElementById('ConfirmPasswordDiv').style.display = 'block';
            } else {
                document.getElementById('ConfirmPasswordDiv').style.display = 'none';
                document.getElementById('ConfirmPasswordDiv').setAttribute('required', '');
                document.getElementById('PasswordDiv').style.display = 'none';
            }
        });

        function editAdmin(id, username, email, status, image, phone) {
            $(function() {
                $('input[type="password"]').val('');
            });
            // document.getElementById('adminProfilePic').style.display = 'block';
            document.getElementById('PasswordDiv').style.display = 'none';
            document.getElementById('ConfirmPasswordDiv').style.display = 'none';
            document.getElementById('editAdminTab').style.display = 'block';
            document.getElementById('editAdminPassword').style.display = 'block';
            document.getElementById('addAdminTab').style.display = 'none';
            document.getElementById('home-b1').style.display = 'none';
            document.getElementById('profile-b1').style.display = 'block';
            document.getElementById('editAdmin1').classList.add("active");
            document.getElementById('adminImage').style.display = 'block';
            document.getElementById('adminImage').setAttribute('src', image);
            document.getElementById('adminName').value = username;
            document.getElementById('phone12').value = phone;
              document.getElementById('email12').value = email;
            document.getElementById('submitButton').innerHTML = '';
            document.getElementById('adminHeading').innerHTML = '';
            // console.log(document.getElementById('adminHeading'));
            document.getElementById('adminHeading12').innerHTML = 'Update Admin';
            document.getElementById('submitButton112').innerHTML = 'Update';
            let url = '{{ url('/add-admin', ':id') }}';
            url = url.replace('%3Aid', id);
            console.log(url);
            document.getElementById('adminForm').setAttribute('action', url);
            let child = document.getElementById('adminStatusField').children;
            for (let i = 0; i < child.length; i++) {
                if (child[i].innerHTML === status) {
                    child[i].selected = true;
                }
            }
        }

        function createAdmin() {
            document.getElementById('show-password12').style.display = 'block';
            document.getElementById('show-confirm-password12').style.display = 'block';
        }

        function editAdminTab() {
            window.location.reload()
        }

        $('.deleteAdmin').click(function() {
            var data = $(this).attr('data-id');
            $('.deleteModal #dltUserID').val(data);

        });
        $('.deleteAdminConfirm').click(function() {

            var id = $('.deleteModal #dltUserID').val();
            $.ajax({
                url: 'delete-admin',
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'id': id
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status) {
                        swal("Admin Deleted Successfully!");
                        document.getElementById('admin-cancel').click();
                        setTimeout(function() {
                            window.location.reload()
                        }, 2000);
                    } else {
                        swal("Admin could not be  deleted!");
                        document.getElementById('admin-cancel').click();
                        setTimeout(function() {
                            window.location.reload()
                        }, 2000);
                    }

                }
            });
        });
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
    </script>
@endsection
