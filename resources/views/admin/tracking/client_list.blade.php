@extends('layouts.admin.master')
@section('content')

    <!-- Topbar Start -->
    @include('layouts.admin.blocks.inc.topnavbar')
    <!-- end Topbar -->

    <!-- Start Content-->
    <div class="container-fluid mt-3">
        @include('admin.alert-message')

        <div class="row">
            <div class="col-xl-3">
                <div class="page_left_bar">
                    <a href="{{route('sellers.parts')}}" class="active"> All Parts </a>
                    <a href="{{route('sellers.parts.add')}}"> Add Part</a>
                </div>
            </div>
            <div class="col-xl-12 home_custome_table">
                <div class="card-box">
                    <h4 class="header-title_vt mb-3 pl-2">Buyers Listing</h4>
                    <div class="form_search_vt">
                        <input type="text" placeholder="search by name" class="form-control" onkeyup="searchData(this.value);">
                    </div>
                    <div class="table-responsive">
                        <table class="table table-borderless table-hover table-centered m-0">
                            <thead class="thead-light">
                            <tr>
                                <th>Sr</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody id="buyersData">
                            @foreach($users as $key => $user)
                                @if($user->username)
                                    <tr>
                                        <td>
                                            {{$key + 1}}
                                        </td>
                                        <td>
                                            <a href="#">
                                                <img src="{{$user->image}}" alt="">

                                                {{$user->username}}
                                            </a>
                                        </td>
                                        <td>
                                            {{$user->email}}
                                        </td>
                                        <td>
                                            {{$user->phone}}
                                        </td>
                                        <td>
                                            <div class="btn-group mb-2">
                                                <button type="button" class="btn btn_info dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">Action <i
                                                        class="mdi mdi-chevron-down"></i></button>
                                                <?php $status = $user->status = 'Y' ? 'Active' : 'Inactive' ?>
                                                <div class="dropdown-menu">
{{--                                                    onclick="window.location='{{route('company.user', ['id' => $user->id])}}'"--}}
                                                    <a class="dropdown-item" data-toggle="modal" data-target=".bs-example-modal-center12" data-id="{{$user->id}}"
                                                    onclick="editBuyer({{$user->id}},{{json_encode($user->username)}},{{json_encode($user->email)}},{{json_encode($user->phone)}},{{json_encode($user->image)}},{{json_encode($status)}})">Edit</a>
                                                    <button type="button" class="dropdown-item deleteUser"
                                                            data-toggle="modal"
                                                            data-target=".bs-example-modal-center"
                                                            data-id="{{$user->id}}">Delete
                                                    </button>
                                                </div>
                                            </div><!-- /btn-group -->
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                        @if($users)
                            {!! $users->render() !!}
                        @endif
                        {{--                        @if ($users->last_page > 1)--}}
                        {{--                        <div class="pagination_vt mt-2">--}}
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
                        {{--                            @endif--}}
                        {{--                    </div>--}}

                    </div>
                </div> <!-- end col -->
            </div>
            <!-- end row -->

        </div> <!-- container -->
        <div class="modal fade bs-example-modal-center deleteModal" tabindex="-1" role="dialog"
             aria-labelledby="myCenterModalLabel"
             aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-dialog-centered">
                <input type="hidden" id="dltUserID">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <i class="fas fa-exclamation"></i>
                        <h4 class="model-heading-vt">Are you sure to delete <br>this Buyers ?</h4>
                        <div class="modal-footer">
                            <button type="button" class="btn_create_vt deleteConfirm">Yes, Delete</button>
                            <button type="button" class="btn_close_vt" data-dismiss="modal" id="user-cancel">Close
                            </button>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <div class="modal fade bs-example-modal-center12 deleteModal" tabindex="-1" role="dialog"
             aria-labelledby="myCenterModalLabel"
             aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-dialog-centered">
                <input type="hidden" id="dltUserID">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <form class="card p-2" method="post"
                          action=""
                          enctype="multipart/form-data" id="buyerForm">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12">
                                <h3 class="page_head_vt" id="adminHeading">Edit Buyer</h3>
                            </div>
                            <div class="col-md-12" id="adminProfilePic">
                                <div class="formgroup_vt">
                                    <img src="{{asset('assets/images/profile.png')}}" alt=""
                                         id="adminImage">
                                    <span >
                                                     <i class="fas fa-pen imageUpload" type="file" >
                                                     </i>
                                                     </span>
                                    <input style="display: none" type="file" name="admin-image" id="imageUploadInput">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="adminName">Name<span class="star_vt">*</span></label>
                                    <input class="form-control" type="text" id="adminName" name="username"
                                           required="" placeholder="Enter Name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Phone<span class="star_vt">*</span></label>
                                    <input class="form-control" type="number" id="phone" name="phone" placeholder="Phone" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="adminEmail">Email<span class="star_vt">*</span></label>
                                    <input class="form-control" type="email" id="adminEmail" name="email"
                                           required="" placeholder="Enter" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="adminStatusField">Status<span
                                            class="star_vt">*</span></label>
                                    <select class="form-control" id="adminStatusField"
                                            name="status">
                                        <option>Active</option>
                                        <option>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div id="editAdmin">
                                <div class="row">
                                    <div class="col-md-12" >
                                        <div class="form-group">
                                            <input type="checkbox" id="editPassword123" name="vehicle1"
                                                   value="false">
                                            <label for="editPassword123"> Edit password</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6" id="show-password12">
                                        <div class="form-group">
                                            <label for="show-password">Password<span
                                                    class="star_vt">*</span></label>
                                            <input class="form-control" type="password"
                                                   name="password" placeholder="***********"
                                                   autocomplete="off" id="show-password">
                                        </div>
                                    </div>
                                    <div class="col-md-6" id="show-confirm-password12">
                                        <div class="form-group">
                                            <label for="confirmPassword">Confirm Password<span
                                                    class="star_vt">*</span></label>
                                            <input class="form-control" type="password"
                                                   id="confirmPassword" name="confirm_password"
                                                   placeholder="***********"
                                                   autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8"></div>
                            <div class="col-md-4">
                                <div class="form-group mb-0 text-center">
                                    <button class="btn btn_btn_vt" type="submit" id="submitButton"> Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script>
            $(function() { $('input[type="email"]').val('');});
            function editBuyer(id,username,email,phone,image,status)
            {
                $(function() { $('input[type="password"]').val('');});
                document.getElementById('adminName').value = username;
                document.getElementById('adminEmail').value = email;
                document.getElementById('phone').value = phone;
                document.getElementById('adminImage').removeAttribute('src');
                document.getElementById('adminImage').setAttribute('src',image);
                let url = '{{ url("/tracking-list/user-detail/edit", ":id") }}';
                url = url.replace('%3Aid', id);
                document.getElementById('buyerForm').setAttribute('action', url);
                let child = document.getElementById('adminStatusField').children;
                for (let i = 0; i < child.length; i++) {
                    if (child[i].innerHTML === status) {
                        child[i].selected = true;
                    }
                }
            }
            let checkbox = document.querySelector("input[type=checkbox]");

            checkbox.addEventListener( 'change', function() {
                if(this.checked) {
                    document.getElementById('show-password12').style.display = 'block';
                    document.getElementById('show-confirm-password12').style.display = 'block';
                } else {
                    document.getElementById('show-confirm-password12').style.display = 'none';
                    document.getElementById('show-confirm-password12').setAttribute('required', '');
                    document.getElementById('show-password12').style.display = 'none';
                }
            });
            $(".imageUpload").click(function () {
                $("input[type='file']").trigger('click');
            });
            $('input[type="file"]').on('change', function() {
                var val = $(this).val();
                var file = $("input[type=file]").get(0).files[0];

                if(file){
                    let reader = new FileReader();

                    reader.onload = function(){
                        document.getElementById('adminImage').style.display = 'block';
                        document.getElementById('adminImage').setAttribute('src', reader.result);
                    }
                    reader.readAsDataURL(file);
                }
            });


            document.getElementById('show-password12').style.display = 'none';
            document.getElementById('show-confirm-password12').style.display = 'none';
            document.getElementById('editAdminTab').style.display = 'none';
            // document.getElementById('adminProfilePic').style.display = 'none';
            // document.getElementById('adminImage').style.display = 'none';
            // document.getElementById('editAdminPassword').style.display = 'none';
            document.getElementById('confirmPassword').innerHTML = '';
            document.getElementById('show-password').innerHTML = '';
            // let editPass = document.getElementById("editPassword123:checkbox");
            // editPass.addEventListener('change',function(e)
            // {
            //     console.log('okkk');
            // })
            // $('#editPassword123:checkbox').bind('change', function (e) {
            //     console.log('okkk');
            //     if ($(this).is(':checked')) {
            //         document.getElementById('show-password12').style.display = 'block';
            //         document.getElementById('show-confirm-password12').style.display = 'block';
            //     } else {
            //         document.getElementById('show-confirm-password12').style.display = 'none';
            //         document.getElementById('show-confirm-password12').setAttribute('required','');
            //         document.getElementById('show-password12').style.display = 'none';
            //     }
            // });


            $('.deleteUser').click(function () {
                var data = $(this).attr('data-id');
                $('.deleteModal #dltUserID').val(data);

            });

            $('.deleteConfirm').click(function () {

                var id = $('.deleteModal #dltUserID').val();
                $.ajax({
                    url: 'delete-user',
                    type: 'post',
                    data: {"_token": "{{csrf_token()}}", 'id': id},
                    dataType: 'json',
                    success: function (response) {
                        if (response.status) {
                            swal("User Deleted Successfully!");
                            document.getElementById('user-cancel').click();
                            window.location.reload();
                        } else {
                            swal("User could not be  deleted!");
                            document.getElementById('user-cancel').click();
                            window.location.reload();
                        }

                    }
                });
            });

            function searchData(value) {
                if (value) {
                    let type = '';
                    $.ajax({
                        url: '{{route('buyer.search')}}',
                        type: 'get',
                        data: {'value': value},
                        dataType: 'json',
                        success: function (response) {
                            let data = response.data;
                            console.log(data);
                            document.getElementById('buyersData').innerHTML = '';
                            for (let i = 0; i < data.length; i++) {
                                var companyProfile = '{{ route("company.profile", ":id") }}';
                                companyProfile = companyProfile.replace(':id', data[i]['id']);
                                var companyUser = '{{ route("company.user", ":id") }}';
                                companyUser = companyUser.replace(':id', data[i]['id']);
                                if (data[i]['username']) {
                                    let id = data[i]['id'];
                                    let tableBody = `<tr>
                                                <td>
                                                    ${id + 1}
                                    </td>
                                    <td>
                                        <a href="${companyProfile}">
                                                        <img src="${data[i]['image']}" alt="">

                                                        ${data[i]['username']}
                                    </a>
                                </td>
                                <td>
                                     ${data[i]['email']}
                                    </td>
                                    <td>
                                     ${data[i]['phone']}
                                    </td>
                                                <td>
                                                    <div class="btn-group mb-2">
                                                        <button type="button" class="btn btn_info dropdown-toggle"
                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">Action <i
                                                                class="mdi mdi-chevron-down"></i></button>
                                                        <div class="dropdown-menu">
                                    <a class="dropdown-item" onclick="window.location='${companyUser}'">Edit</a>
                                                             <button type="button" class="dropdown-item deleteUser" data-toggle="modal" data-target=".bs-example-modal-center" data-id="${data[i]['id']}">Delete</button>
                                                        </div>
                                                    </div><!-- /btn-group -->
                                                </td>
                                            </tr>`
                                    $("#buyersData").append(tableBody);
                                    $('.deleteUser').click(function () {
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
        </script>

@endsection
