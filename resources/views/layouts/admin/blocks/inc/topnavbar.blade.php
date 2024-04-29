<!-- Topbar Start -->
<style>
    .modal-lg, .modal-xl {
        max-width: 600px !important;
    }
</style>
<div class="container-fluid">
    @include('admin.alert-message')
    <div class="navbar-custom">
        <div class="nav_bar_custom">
            <ul class="list-unstyled topnav-menu float-right mb-0">

                <!-- <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle  waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <i class=" mdi mdi-bell noti-icon"></i>
                        <span class="badge badge-danger rounded-circle noti-icon-badge">9</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-lg">
                        <div class="dropdown-item noti-title">
                            <h5 class="m-0">
                                <span class="float-right">
                                    <a href="#" class="text-dark">
                                        <small>Clear All</small>
                                    </a>
                                </span>Notification
                            </h5>
                        </div>

                        <div class="slimscroll noti-scroll">
                            <a href="javascript:void(0);" class="dropdown-item notify-item active">
                                <div class="notify-icon">
                                    <img src="assets/images/users/user-1.jpg" class="img-fluid rounded-circle" alt="" />
                                </div>
                                <p class="notify-details">Cristina Pride</p>
                                <p class="text-muted mb-0 user-msg">
                                    <small>Hi, How are you? What about our next meeting</small>
                                </p>
                            </a>
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <div class="notify-icon bg-primary">
                                    <i class="mdi mdi-comment-account-outline"></i>
                                </div>
                                <p class="notify-details">Caleb Flakelar commented on Admin
                                    <small class="text-muted">1 min ago</small>
                                </p>
                            </a>
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <div class="notify-icon">
                                    <img src="assets/images/users/user-4.jpg" class="img-fluid rounded-circle" alt="" />
                                </div>
                                <p class="notify-details">Karen Robinson</p>
                                <p class="text-muted mb-0 user-msg">
                                    <small>Wow ! this admin looks good and awesome design</small>
                                </p>
                            </a>
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <div class="notify-icon bg-warning">
                                    <i class="mdi mdi-account-plus"></i>
                                </div>
                                <p class="notify-details">New user registered.
                                    <small class="text-muted">5 hours ago</small>
                                </p>
                            </a>
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <div class="notify-icon bg-info">
                                    <i class="mdi mdi-comment-account-outline"></i>
                                </div>
                                <p class="notify-details">Caleb Flakelar commented on Admin
                                    <small class="text-muted">4 days ago</small>
                                </p>
                            </a>
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <div class="notify-icon bg-secondary">
                                    <i class="mdi mdi-heart"></i>
                                </div>
                                <p class="notify-details">Carlos Crouch liked
                                    <b>Admin</b>
                                    <small class="text-muted">13 days ago</small>
                                </p>
                            </a>
                        </div>
                        <a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">
                            View all
                            <i class="fi-arrow-right"></i>
                        </a>

                    </div>
                </li> -->

                <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    @if(Auth::user()->image)
                        <img src="{{asset('images/profile-pic/'.Auth::user()->image)}}" alt="user-image" class="rounded-circle">
                        @else
                        <img src="{{asset('assets/images/users/user-icon.jpg')}}" alt="user-image" class="rounded-circle">
                        @endif
                        <span class="pro-user-name ml-1">
                            {{Auth::user()->username}} <i class="mdi mdi-chevron-down"></i>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                        <!-- item-->
                        <div class="dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Welcome !</h6>
                        </div>

                        <!-- item-->
                        <a data-toggle="modal" data-target="#exampleModal" class="dropdown-item notify-item">
                            <i class="fe-user"></i>
                            <span>My Account</span>
                        </a>



                        <!-- item-->
                        {{--<a href="javascript:void(0);" class="dropdown-item notify-item">--}}
                            {{--<i class="fas fa-unlock"></i>--}}
                            {{--<span>Change Password</span>--}}
                        {{--</a>--}}

                        <div class="dropdown-divider"></div>

                        <!-- item-->
                        <a class="dropdown-item notify-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                            <i class="fe-log-out"></i>
                            <span>Logout</span>
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>

                    </div>
                </li>


            </ul>

            <!-- LOGO -->

            <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
                <li>
                    <button class="button-menu-mobile waves-effect waves-light">
                        <i class="fe-menu"></i>
                    </button>
                </li>
{{--                <li>--}}
{{--                    <span class="All_page_name_vt"> Dashboard </span>--}}
{{--                </li>--}}
                <li>
                    <h4 class="top_title_page">

                        @if((Request::is('dashboard')))
                            {{ 'Dashboard' }}
                        @elseif(Session::get('role') == '1')
                        {{( (Request::is('add-clients')) ||(Request::is('add-assets')) ||(Request::is('add-tasks')) ||(Request::is('add-users')) ||(Request::is('add-files'))  ||(Request::is('add-notes')) ||  (Request::is('client-profile')) || (Request::is('edit-client')) || (Request::is('edit-client-user')) ? Session::get('client_name') : '')}}
                        @else
                        {{Session::get('client_name')}}
                        @endif
                    </h4>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- end Topbar -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Account Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-xl-12 home_custome_table profile_vt">
                    <div class="p-0 p-md-3">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="custm_profile_to">
                                    <div class="profile">
                                        <div class="icon_account_vt">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <h4>Username : <span>Test Register</span></h4>
                                        <h4>Email :<span>N/A</span></h4>
                                        <h4>Contact number :<span>03174231919</span></h4>
                                        <h4>Password :
                                        <a href="#" type="button" class="btn btn-primary" data-toggle="modal"
                                       data-target=".bs-example-modal-center"
                                       data-id="11">Change Passwords</a>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div> -->
            </div>
    </div>
</div>
<div class="modal fade bs-example-modal-center deleteModal" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <input type="hidden" id="dltUserID">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form class="card p-2" method="post"
                        action="{{route('password.change',['userId' => Auth::user()->id])}}"
                        enctype="multipart/form-data" id="changePassword">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="page_head_vt" id="adminHeading">Change Password</h3>
                        </div>
                <div class="col-md-12" id="show-password12">
                    <div class="form-group">
                        <label for="show-password">Previous Password<span
                                class="star_vt">*</span></label>
                        <input class="form-control" type="password"
                                name="old_password" placeholder="***********"
                                autocomplete="off" id="show-password">
                    </div>
                </div>
                <div class="col-md-12" id="show-password12">
                    <div class="form-group">
                        <label for="show-password">New Password<span
                                class="star_vt">*</span></label>
                        <input class="form-control" type="password"
                                name="new_password" placeholder="***********"
                                autocomplete="off" id="show-password">
                    </div>
                </div>
                <div class="col-md-12" id="show-confirm-password12">
                    <div class="form-group">
                        <label for="confirmPassword">Confirm Password<span
                                class="star_vt">*</span></label>
                        <input class="form-control" type="password"
                                id="confirmPassword" name="confirm_password"
                                placeholder="***********"
                                autocomplete="off">
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
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

