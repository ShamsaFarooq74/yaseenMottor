
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from coderthemes.com/ubold/layouts/material/pages-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 04 Sep 2019 05:03:34 GMT -->

<head>
    <meta charset="utf-8" />
    <title>NTC</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="NTC" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
       @php
     $setting = App\Http\Models\Config::first(['key', 'values']);
   @endphp
    <link rel="icon" type="image/png" href="{{ asset('assets/images/'.$setting->values) }}"/>
    <!-- plugin css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="{{ asset('assets/css/custom_style.css') }}" rel="stylesheet" type="text/css" />
    <!-- App css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />

</head>
<style>
    .form-control {
    text-transform: none !important;
    }
    @keyframes fadeInDown {
    from {
        opacity:0;
        -webkit-transform: translatey(-50px);
        -moz-transform: translatey(-50px);
        -o-transform: translatey(-50px);
        transform: translatey(-50px);
    }
    to {
        opacity:1;
        -webkit-transform: translatey(0);
        -moz-transform: translatey(0);
        -o-transform: translatey(0);
        transform: translatey(0);
    }
}
.in-down {
    -webkit-animation-name: fadeInDown;
    -moz-animation-name: fadeInDown;
    -o-animation-name: fadeInDown;
    animation-name: fadeInDown;
    -webkit-animation-fill-mode: both;
    -moz-animation-fill-mode: both;
    -o-animation-fill-mode: both;
    animation-fill-mode: both;
    -webkit-animation-duration: 1s;
    -moz-animation-duration: 1s;
    -o-animation-duration: 1s;
    animation-duration: 1s;
}


/** fadeInLeft **/
</style>
<body class="authentication-bg">
@section('title', 'yaseen-motors/login')
    <div class="account-pages mt-2 mb-2">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5 mt-5">
                    <div class="card bg-pattern">
                        <div class="card-body px-4 py-5">

                            <div class="logo_head_vt in-down" >
                                <a href="index.html">
                                    <span><img src="{{ asset('assets/images/'.$setting->values) }}" alt="" height="60"></span>
                                </a>
                                <p>Welcome, Let's get Started!</p>
                            </div>

                            <div>
                                @include('layouts.admin.blocks.inc.responseMessage')
                            </div>

                            <form method="POST" action="{{ url('/login') }}">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="email">{{ __('Phone no') }}<span class="star_vt">*</span></label>
                                    <input id="phone" type="text" placeholder="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone" autofocus>

                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="password">{{ __('Password') }}<span class="star_vt">*</span></label>
                                    <input id="password" type="password" placeholder="********" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Remember me</label>
                                </div>

                                <div class="form_groupvt">
                                    <a href="{{route('password.request')}}" class="float-right">Forgot Password?</a>
                                </div>


                                <div class="form-group mb-0 logone_vt">
                                    <button type="submit" class="btn btn_btn_vt">
                                        {{ __('Login') }}
                                    </button>
                                </div>

                            </form>

                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->
                    <!-- end row -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    <!-- Vendor js -->
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <!-- App js -->
    <script src="{{ asset('assets/js/app.min.js') }}"></script>

</body>
</html>


