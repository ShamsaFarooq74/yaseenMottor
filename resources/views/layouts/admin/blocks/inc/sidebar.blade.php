<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">
    <div class="slimscroll-menu">
        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul class="metismenu" id="side-menu">
                <div class="logo-box">
                    <a href="{{url('/dashboard')}}" class="logo text-center">
                        <span class="">
                            <img src="{{ asset('assets/images/'.$setting->values) }}" alt="logo" width="30%" class="mt-1">
                            <!-- <span class="logo-lg-text-light">UBold</span> -->
                        </span>
                        <span class="logo-sm">
                            <!-- <span class="logo-sm-text-dark">U</span> -->
                            <img src="{{asset('assets/images/'.$setting->values) }}" alt="" width="35">
                        </span>
                    </a>
                </div>

                <li>
                    <a href="{{url('/dashboard')}}" class="{{(Request::is('dashboard') ? 'active' : '')}}">
                        <img src="{{ asset('assets/images/left-bar-icon/dashboard.svg') }}" alt="Dashboard">
                        <span> Dashboard </span>
                    </a>
                </li>

                @if(Auth::user()->role == '1')

                <li>

                    <a href="{{route('customer.list')}}" class="{{(Request::is('customer-list') ? 'active' : '')}}">

                        <img src="{{ asset('assets/images/left-bar-icon/Buyers.svg') }}">
                        <span> Users </span>
                    </a>
                </li>
                @endif
                <li>
                    <a href="{{route('sellers.parts')}}"
                        class="{{((Request::is('parts') || (Request::is('add-parts')) || (Request::is('export-parts-data')) || (Request::is('top-trending/parts'))) ? 'active' : '')}}">
                        <img src="{{ asset('assets/images/left-bar-icon/brake.svg') }}" width="17px">
                        <span> Cars </span>
                    </a>
                </li>
                <li>
                    <a href="{{route('order.list')}}"
                        class="{{((Request::is('order-list') || (Request::is('order-detail')) || (Request::is('edit-tracking'))) ? 'active' : '')}}">
                        <img src="{{ asset('assets/images/left-bar-icon/Products.svg') }}">
                        <span>Car Inquire</span>
                    </a>
                </li>
                @if(Session::get('role') == '3')
                <li>
                    <a href='{{url("client-profile?info=".Session::get('client_id'))}}'
                        class="{{((Request::is('assets-list') || Request::is('client-profile')) ? 'active' : '')}}">
                        <img src="assets/images/left-bar-icon/tracker_listing.svg" alt=""> Assets Listing</a>
                </li>

                <li>
                    <a href="{{url("add-assets?info=".Session::get('client_id'))}}"
                        class="{{(Request::is('add-assets') ? 'active' : '')}}">
                        <img src="assets/images/left-bar-icon/create_tracker.svg" alt=""> Create Assets</a>
                </li>
                <li>
                    <a href="{{route('create.notes')}}" class="{{(Request::is('add-notes') ? 'active' : '')}}">
                        <img src="assets/images/left-bar-icon/notes.svg" alt=""> Notes</a>

                </li>
                <li>
                    <a href="{{route('create.tasks')}}" class="{{(Request::is('add-tasks') ? 'active' : '')}}">
                        <img src="assets/images/left-bar-icon/task.svg" alt=""> Tasks</a>
                </li>
                <li><a href="{{route('create.files')}}" class="{{(Request::is('add-files') ? 'active' : '')}}">
                        <img src="assets/images/left-bar-icon/file.svg" alt=""> Files</a>

                </li>
                <li>
                    <a href="{{route('create.users')}}"
                        class="{{(Request::is('add-users') || (Request::is('edit-client-user')) ? 'active' : '')}}">
                        <img src="assets/images/left-bar-icon/user.svg" alt=""> Users</a>
                </li>

                @endif

                <li>
                    <a href="{{route('adds')}}" class="{{(Request::is('adds') ? 'active' : '')}}"><img
                            src="{{asset('assets/images/left-bar-icon/Ads.svg')}}" alt=""> <span>Banners</span></a>
                </li>
                <!-- <li>
                    <a href="{{route('index.communication')}}"
                        class="{{(Request::is('communication/index') ? 'active' : '')}}"><img
                            src="{{asset('assets/images/left-bar-icon/Membership.svg')}}" alt="">
                        <span>Communication</span></a>
                </li> -->

                <li>
                    <a href="{{route('settings')}}"
                        class="{{(((Request::is('settings')) || (Request::is('settings/*'))) ? 'active' : '')}}">
                        <img src="{{asset('assets/images/left-bar-icon/Setting.svg')}}" alt="">
                        <span>Setup Forms</span></a>
                </li>
                <li>
                    <a href="{{route('admin')}}" class="{{(Request::is('admin') ? 'active' : '')}}"><img
                            src="{{asset('assets/images/left-bar-icon/Admin.svg')}}" alt=""> <span>User
                            Settings</span></a>
                </li>
                <!-- <li>
                    <a href="{{route('manufacturer')}}" class="{{(Request::is('manufacturers') ? 'active' : '')}}"><img
                            src="{{asset('assets/images/left-bar-icon/manufacturer.svg')}}" alt="">
                        <span>Manufacturer</span></a>
                </li> -->
                <!-- <li>
                        <a href="{{route('feedback')}}"><img src="{{asset('assets/images/left-bar-icon/Feedback.svg')}}" alt=""> <span>Feedback</span></a>
                    </li>
                    <li>
                        <a href="{{route('payment')}}"><img src="{{asset('assets/images/left-bar-icon/Membership.svg')}}" alt=""> <span>Payments</span></a>
                    </li> -->
            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->