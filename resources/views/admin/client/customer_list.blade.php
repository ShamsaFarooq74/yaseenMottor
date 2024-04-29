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

        .home_table .form_search_vt {
            margin-right: 200px;
            display: flex;
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

        .toggle input[type="checkbox"]:hover+label:after {
            box-shadow: 0 2px 15px 0 #0002, 0 3px 8px 0 #0001;
        }

        .toggle input[type="checkbox"]:checked+label:before {
            background: #E02329;
        }

        .toggle input[type="checkbox"]:checked+label:after {
            background: #ffffff;
            left: 21px;
        } 
        } 

        }

    </style>
    <!-- Start Content-->
    <div class="container-fluid mt-3">
        {{-- @include('admin.alert-message') --}}

        <div class="row">
            <div class="col-xl-12 home_custome_table">
                <div class="card-box home_table">
                    <h4 class="header-title_vt mb-3 pl-2">Users</h4>
                    <div class="card_tabs_vt">
                        <ul class="nav nav-tabs nav-bordered" id="dashboardSearch">
                            <!-- <li class="nav-item">
                                <a href="#home-b1" data-toggle="tab" aria-expanded="true" id="approved_usersLink"
                                    class="nav-link  @if ($type == 'default') active @endif"
                                    onclick="status('approved')">
                                    Approved
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#profile-b1" data-toggle="tab" aria-expanded="false" id="pending_usersLink"
                                    class="nav-link @if ($type == 'pending_user') active @endif"
                                    onclick="status('pending')">
                                    Pending
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#block-b1" data-toggle="tab" aria-expanded="false" class="nav-link"
                                    id="blocked_usersLink" onclick="status('block')">
                                    Block
                                </a>
                            </li> -->
                        </ul>
                        <div class="tab-content">
                            <div>
                                <h4 class="header-title_vt mb-3 pl-2">Filters</h4>
                            <div class="form_search_vt" style="transform: translate(184px, -4px);">
                                <input type="text" placeholder="Search by username" id="user_name"
                                    onkeyup="searchData(this.value);" class="form-control">
                                <input type="text" placeholder="Search by Phone Number" id="user_phone"
                                    onkeyup="searchData(this.value);" class="form-control">
                            </div>
                            </div>
                            <div class="tab-pane  @if ($type == 'default') show active @endif" id="home-b1">
                                <div class="table-responsive">
                                    <table class="table table-borderless table-hover table-centered m-0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Sr</th>
                                                <th>Name</th>
                                                <th>Phone Number</th>
                                                <th>Email</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="approved">
                                           
                                            @foreach ($users as $key => $user)
                                                @if ($user->username)
                                                    <tr>
                                                        <td>
                                                            {{ $key + $users->firstItem() }}
                                                        </td>
                                                        <td>
                                                         <a>
                                                                @if ($user->image)
                                                                    <img src="{{ $user->image }}" alt="">
                                                                @else
                                                                    <img src="{{ asset('images/defaultImages/user-icon.jpg') }}"
                                                                        alt="">
                                                                @endif
                                                                {{ $user->username }}
                                                            </a>
                                                        </td>
                                                        <td>
                                                            {{ $user->phone }}
                                                        </td>
                                                        <!-- <td>
                                                            {{ $user->customer_type }}
                                                        </td> -->
                                                        <td>
                                                            {{ $user->email }}
                                                        </td>

                                                        <td>
                                                            <div class="btn-group mb-2">
                                                                <button type="button" class="btn btn_info dropdown-toggle"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">Action <i
                                                                        class="mdi mdi-chevron-down"></i></button>
                                                                <?php $status = $user->is_active == 'Y' ? 'Active' : 'Inactive'; ?>
                                                                <div class="dropdown-menu">
                                                                    {{-- onclick="window.location='{{route('company.user', ['id' => $user->id])}}'" --}}
                                                                    <a class="dropdown-item" data-toggle="modal"
                                                                        data-target=".bs-example-modal-center12"
                                                                        data-id="{{ $user->id }}"
                                                                        onclick="editBuyer({{ $user->id }},{{ json_encode($user->show_price) }},{{ json_encode($user->username) }},{{ json_encode($user->email) }},{{ json_encode($user->phone) }},{{ json_encode($user->image) }},{{ json_encode($status) }},{{ json_encode($user['discount']) }},{{ json_encode($user['manufacturer_id']) }},{{ json_encode($user['manufacturer_name']) }} )">Edit</a>
                                                                    <button type="button" class="dropdown-item deleteUser"
                                                                        data-toggle="modal" data-target=".client-list-2345"
                                                                        data-id="{{ $user->id }}">Block
                                                                    </button>
                                                                </div>
                                                            </div><!-- /btn-group -->
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @if ($users)
                                        {!! $users->render() !!}
                                    @endif

                                </div>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                    </div> <!-- container -->


                    <div class="modal fade unblock-customer-23 unBlockModal" tabindex="-1" role="dialog"
                        aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog modal-dialog-centered">
                            <input type="hidden" id="unblockUserID">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <i class="fas fa-exclamation"></i>
                                    <h4 class="model-heading-vt">Are you sure to Unblock <br>this user ?</h4>
                                    <div class="modal-footer">
                                        <button type="button" class="btn_create_vt unBlockConfirm">Yes, Unblock</button>
                                        <button type="button" class="btn_close_vt" data-dismiss="modal"
                                            id="unBlock-cancel">Close
                                        </button>
                                    </div>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                    <!-- <div class="modal fade bs-example-modal-center12 deleteModal" tabindex="-1" role="dialog"
                                             aria-labelledby="myCenterModalLabel"
                                             aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <input type="hidden" id="unblockUserID">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                                                        </button>
                                                    </div> -->


                    <div class="modal fade client-list-2345 deleteModal" tabindex="-1" role="dialog"
                        aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog modal-dialog-centered">
                            <input type="hidden" id="dltUserID">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <i class="fas fa-exclamation"></i>
                                    <h4 class="model-heading-vt">Are you sure to Block <br>this User ?</h4>
                                    <div class="modal-footer">
                                        <button type="button" class="btn_create_vt deleteConfirm">Yes, Block</button>
                                        <button type="button" class="btn_close_vt" data-dismiss="modal"
                                            id="user-cancel">Close
                                        </button>
                                    </div>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->

                    <div class="modal fade bs-example-modal-center12 deleteModal" tabindex="-1" role="dialog"
                        aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog modal-dialog-centered">
                            <input type="hidden" id="dltUserID">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                                    </button>
                                </div>
                                <form class="card p-2" method="post" action="" enctype="multipart/form-data"
                                    id="buyerForm">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3 class="page_head_vt" id="adminHeading">Edit User</h3>
                                        </div>
                                        <div class="col-md-12" id="adminProfilePic">
                                            <div class="formgroup_vt">
                                                <img src="{{ asset('assets/images/profile.png') }}" alt=""
                                                    id="adminImage">
                                                <span>
                                                    <i class="fas fa-pen imageUpload" type="file">
                                                    </i>
                                                </span>
                                                <input style="display: none" type="file" name="admin-image"
                                                    id="imageUploadInput">
                                            </div>
                                        </div>
                                        <input class="form-control" type="hidden" id="check-user-status"
                                            name="checkedStatus">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="adminName">Name<span class="star_vt">*</span></label>
                                                <input class="form-control" type="text" id="adminName"
                                                    name="username" required="" placeholder="Enter Name">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="adminEmail">Email<span class="star_vt">*</span></label>
                                                <input class="form-control" type="email" id="email"
                                                    name="email" required="" placeholder="Enter Email"
                                                    autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phone">Phone<span class="star_vt">*</span></label>
                                                <input class="form-control" type="text" id="user-phone"
                                                    name="phone" placeholder="Phone" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="adminStatusField">Status<span class="star_vt">*</span></label>
                                                <select class="form-control" id="adminStatusField" name="status">
                                                    <option>Active</option>
                                                    <option>Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="user_role">Select Role<span class="star_vt">*</span></label>
                                                <select class="form-control" id="user_role" name="user_role">
                                                    <option value="1">Admin</option>
                                                    <option value="2" selected>User</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="toggle">
                                                <!-- <input type="checkbox" name="price_visibility" id="showPrice"
                                                    class="checkbox">
                                                <label for="option1" class="switch">Price Visibility</label> -->
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group" id="discount">
                                                <!-- <label for="phone">User Discount(%)</label>
                                                    <input class="form-control" type="text" id="discount" name="discount"
                                                        placeholder="Add User Discount" autocomplete="off">-->
                                            </div>
                                        </div>

                                        <div id="editAdmin">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <input type="checkbox" id="editPassword123" name="vehicle1"
                                                            value="false" class="my-class">
                                                        <label for="editPassword123"> Edit password</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6" id="show-password1244">
                                                    <div class="form-group">
                                                        <label for="show-password">Password<span
                                                                class="star_vt">*</span></label>
                                                        <input class="form-control" type="password" name="password"
                                                            placeholder="***********" autocomplete="off"
                                                            id="show-password">
                                                    </div>
                                                </div>
                                                <div class="col-md-6" id="show-confirm-password1256">
                                                    <div class="form-group">
                                                        <label for="confirmPassword">Confirm Password<span
                                                                class="star_vt">*</span></label>
                                                        <input class="form-control" type="password" id="confirmPassword"
                                                            name="confirm_password" placeholder="***********"
                                                            autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8"></div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-0 text-center">
                                                <button class="btn btn_btn_vt" type="submit" id="submitButton"> Update
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->

                    <script>
                         

                        var userType = {!! json_encode($type) !!};
                        if (userType == 'pending_user') {
                            var userStatus = 'pending';

                        } else {
                            var userStatus = 'approved';
                        }

                        $(document).ready(function() {
                            status(userStatus);
                        });

                        function status(status) {
                            userStatus = status;
                        }
                        document.getElementById('show-password1244').style.display = 'none';
                        document.getElementById('show-confirm-password1256').style.display = 'none';
                        $('.my-class').on('change', function() {
                            if ($(this)[0].checked) {
                                document.getElementById('show-password1244').style.display = 'inline';
                                document.getElementById('show-confirm-password1256').style.display = 'inline';
                                document.getElementById('check-user-status').setAttribute('value', 'true');
                            } else {
                                document.getElementById('show-confirm-password1256').style.display = 'none';
                                document.getElementById('show-confirm-password1256').setAttribute('required', '');
                                document.getElementById('show-password1244').style.display = 'none';
                                document.getElementById('check-user-status').setAttribute('value', 'false');
                            }
                        });
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
                        // document.getElementsByClassName('pagination').setAttribute('style', "background-color: red;");
                        // console.log('hellthough' + className);
                        $(function() {
                            $('input[type="email"]').val('');
                        });

                        function editBuyer(id, showPrice, username, email, phone, image, status, discount,manufacturer_name, manufacturer_ids) {

                            if (typeof(manufacturer_name) === 'string') {
                                var manufacturer_ids = manufacturer_ids.split(",");
                                var discount = discount.split(",");
                                var manufacturer_name = manufacturer_name.split(",")
                                }
                            $(function() {
                                $('input[type="password"]').val('');
                            });
                            document.getElementById('adminName').value = username;

                            document.getElementById('email').value = email;
                            document.getElementById('user-phone').value = phone;
                            document.getElementById('adminImage').removeAttribute('src');
                            document.getElementById('adminImage').setAttribute('src', image);
                            let url = '{{ url('/tracking-list/user-detail/edit', ':id') }}';
                            url = url.replace('%3Aid', id);
                            document.getElementById('buyerForm').setAttribute('action', url);
                            let child = document.getElementById('adminStatusField').children;
                            for (let i = 0; i < child.length; i++) {
                                if (child[i].innerHTML === status) {
                                    child[i].selected = true;
                                }
                            }
                            var discounts= null;
                            $('#discount').empty();
                            for (let j = 0; j < manufacturer_name.length; j++) {
                                const label = document.createElement('LABEL');
                                // const labelText = document.createTextNode('Discount of ' + manufacturer_ids[j]);
                                discounts = document.createElement("input");
                                discounts.setAttribute("type", "number");
                                discounts.setAttribute("value", discount[j]);
                                discounts.setAttribute("name", manufacturer_name[j]);
                                discounts.setAttribute("placeholder", "Enter Value");
                                let form = document.getElementById("discount");
                                form.append(labelText);
                                form.append(discounts);
                           
                            }
                        }
                        
                        document.getElementById('confirmPassword').innerHTML = '';
                        document.getElementById('show-password').innerHTML = '';

                        $('.deleteUser').click(function() {
                            var data = $(this).attr('data-id');
                            $('.deleteModal #dltUserID').val(data);

                        });
                        $('.UnBlockUser').click(function() {
                            var data = $(this).attr('data-id');
                            console.log(data);
                            $('.unBlockModal #unblockUserID').val(data);

                        });

                        $('.unBlockConfirm').click(function() {
                            // alert('hellll');
                            var id = $('.unBlockModal #unblockUserID').val();
                            $.ajax({
                                url: 'unblock-user',
                                type: 'post',
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    'id': id
                                },
                                dataType: 'json',
                                success: function(response) {
                                    if (response.status) {
                                        swal("User Unblocked Successfully!");
                                        document.getElementById('unBlock-cancel').click();
                                        window.location.reload();
                                    } else {
                                        // swal("User could not be  Unblocked!");
                                        // document.getElementById('unBlock-cancel').click();
                                        // window.location.reload();
                                    }

                                }
                            });
                        });
                        $('.deleteConfirm').click(function() {
                            // alert('hellll');
                            var id = $('.deleteModal #dltUserID').val();
                            $.ajax({
                                url: 'delete-user',
                                type: 'post',
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    'id': id
                                },
                                dataType: 'json',
                                success: function(response) {
                                    if (response.status) {
                                        swal("User Blocked Successfully!");
                                        document.getElementById('user-cancel').click();
                                        window.location.reload();
                                    } else {
                                        swal("User could not be blocked!");
                                        document.getElementById('user-cancel').click();
                                        window.location.reload();
                                    }

                                }
                            });
                        });

                        function searchData(value) {
                            if (value) {
                                // var CustomerType = document.getElementById('CustomerType').value;
                                var Phone = document.getElementById('user_phone').value;
                                var Name = document.getElementById('user_name').value;
                                let type = '';
                                $.ajax({
                                    url: '{{ route('buyer.search') }}',
                                    type: 'get',
                                    data: {
                                        // 'CustomerType': CustomerType,
                                        'usersname': Name,
                                        'value': Phone,
                                        'userStatus': userStatus
                                    },
                                    dataType: 'json',
                                    success: function(response) {
                                        // console.log(response);
                                        let data = response.data;
                                        if (userStatus == 'approved') {
                                            document.getElementById('approved').innerHTML = '';
                                        }
                                        if (userStatus == 'pending') {
                                            document.getElementById('pending').innerHTML = '';
                                        }
                                        if (userStatus == 'block') {
                                            document.getElementById('block').innerHTML = '';
                                        }
                                        for (let i = 0; i < data.length; i++) {
                                            var companyProfile = '{{ route('company.profile', ':id') }}';
                                            companyProfile = companyProfile.replace(':id', data[i]['id']);
                                            var companyUser = '{{ route('company.user', ':id') }}';
                                            var show_price = data[i].show_price === 'Y' ? 1 : 0;
                                            var discount = data[i]['discount'];
                                            var manufacturer_name = data[i]['manufacturer_name'];
                                            var manufacturer_id = data[i]['manufacturer_id'];
                                            var status = data[i]['is_active'] === 'Y' ? 'Active' : 'Inactive';
                                            companyUser = companyUser.replace(':id', data[i]['id']);
                                            if (data[i]['username']) {
                                                let id = data[i]['id'];
                                                let tableBody = `<tr>
                                                <td>
                                                    ${id + 1}
                                            </td>
                                            <td>
                                                <a href="#">
                                                                <img src="${data[i]['image']}" alt="">

                                                                ${data[i]['username']}
                                            </a>
                                            </td>
                                            <td>
                                            ${data[i]['phone']}
                                            </td>
                                            <td>
                                            ${data[i]['email']}
                                            </td>
                                   
                                                <td>
                                                    <div class="btn-group mb-2">
                                                        <button type="button" class="btn btn_info dropdown-toggle"
                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">Action <i
                                                                class="mdi mdi-chevron-down"></i></button>
                                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" data-toggle="modal"
                                                                   data-target=".bs-example-modal-center12"
                                                                   data-id="${data[i]['id']}" 
                                                                   onclick="editBuyer('${data[i]['id']}','${show_price}','${data[i]['username']}','${data[i]['email']}','${data[i]['phone']}','${data[i]['image']}','${status}','${discount}','${manufacturer_id}','${manufacturer_name}')"> Edit</a>
                                                             <button type="button" class="dropdown-item deleteUser"
                                                                        data-toggle="modal"
                                                                        data-target=".client-list-2345" data-id="${data[i]['id']}">Block</button>
                                                        </div>
                                                    </div><!-- /btn-group -->
                                                </td>
                                            </tr>`;
                                                if (userStatus == 'approved') {
                                                    $("#approved").append(tableBody);
                                                }
                                                if (userStatus == 'pending') {
                                                    $("#pending").append(tableBody);
                                                }
                                                if (userStatus == 'block') {
                                                    $("#block").append(tableBody);
                                                }
                                                $('.deleteUser').click(function() {
                                                    var data = $(this).attr('data-id');
                                                    $('.deleteModal #dltUserID').val(data);
                                                });
                                            }
                                        }
                                    },

                                });
                            } else {
                                window.location.reload()
                            }
                        }

                        function approveUser(userId) {
                            if (confirm('Are you sure you want to approve this customer ?')) {
                                $.ajax({
                                    url: '{{ route('approve.user') }}',
                                    type: 'get',
                                    data: {
                                        'id': userId
                                    },
                                    dataType: 'json',
                                    success: function(response) {
                                        if (response.status) {
                                            swal("User approved Successfully!");
                                            setTimeout(function() {
                                                window.location.reload()
                                            }, 1500);
                                        } else {
                                            swal("User could not be approved.Please try again later");
                                        }

                                    },

                                });
                            }
                        }
                    </script>
                @endsection
