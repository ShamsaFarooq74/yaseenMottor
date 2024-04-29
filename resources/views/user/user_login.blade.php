<!DOCTYPE html>
<html lang="en-gb">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
@php
  $setting = App\Http\Models\Config::first(['key', 'values']);
@endphp
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title> {{env("APP_NAME")}} - log In</title>

    <!-- Favicons -->
   <link rel="icon" type="image/png" href="{{ asset('assets/images/'.$setting->values) }}"/>
    <link rel="manifest" href="assets/images/site.html">

    <link rel="alternate" hreflang="en-GB" href="index.html" />
    <link rel="canonical" href="index.html" />
    <meta name="wot-verification" content="88dac723032629f81788" />


    <!-- CDN CSS Files -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Vendor CSS Files -->
    <link href="{{ asset('user_assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('user_assets/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <!-- Template Main CSS File -->
    <link href="{{ asset('user_assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('user_assets/css/findcar.css') }}" rel="stylesheet">
    @php
    $div_bg_color = "#D9D9D9";
    $darkblue = "#2D3282";
    $offwhite = "#F5F8FF";
    $green_color = "#00B341";
    $rockblue = "#98A2B3";
    $orange_color = "#EC4A0A";
    $darkRockBlue = "#2D328233";
    $dark_jungle_green ="#101828";
    $yankess_blue = "#1D2939";
    $red_color = "#DD1919";
    $c_green ="#12B76A";
    $white_smoke ="#F4F4F4";
    $white_color = "#FFFFFF";
    $blackgray_color ="#000000B2";
    $slate_gray = "#6C7680";
    $orange_peel = "#FFA32B";
    $linear_header_color = "linear-gradient(180deg, #2D3282 0%, #0E1118 100%)";
    @endphp

    <style>
    :root {
        --linear-header-color: <?=$linear_header_color ?>;
        --div-bg-color: <?=$div_bg_color ?>;
        --darkblue-color: <?=$darkblue ?>;
        --offwhite-color: <?=$offwhite ?>;
        --green-color: <?=$green_color ?>;
        --c-green: <?=$c_green ?>;
        --white-color: <?=$white_color ?>;
        --rockblue-color: <?=$rockblue ?>;
        --orange-color: <?=$orange_color ?>;
        --color-red: <?=$red_color ?>;
        --darkRockBlue-color: <?=$darkRockBlue ?>;
        --dark-jungle-green: <?=$dark_jungle_green ?>;
        --yankess-blue: <?=$yankess_blue ?>;
        --blackgray_color: <?=$blackgray_color ?>;
        --saltegray-color: <?=$slate_gray ?>;
        --white-smoke: <?=$white_smoke ?>;
        --orange-peel-color: <?=$orange_peel ?>;
    }
    </style>
</head>

<body>
    <main id="main">

        <!--=======================login Section Start Here-->
        <section class="p-0">
            @section('title', 'yaseen-motors'.'-'.'login')
            <div class="row custom-login-div">
                <div
                    class="col-lg-6 col-md-6 col-sm-6 custom-div-left p-5 d-flex justify-content-center align-items-center">
                    <div class="trust-cars-heading p-3">
                        <q class="text-light">
                            <h1></i>YOUR TRUSTED PARTNERS FOR USED CARS!</h1>
                            <h6>Upgrade Your Ride: dada
                                Find Your Dream Car among our Handpicked Selection of Used
                                Vehicles.
                            </h6>
                        </q>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 custom-div-right p-5 justify-content-center align-items-center">
                    <div class="col-lg-12 col-md-12 col-sm-12 p-4">
                        <div class="login-heading mt-5">
                            <h2>HELLO! WELCOME BACK</h2>
                            <h5>Please enter your credentials below to get full access.</h5>
                        </div>
                        <div>
                                @include('layouts.admin.blocks.inc.responseMessage')
                        </div>
                        <div class="mt-5 mb-5">
                            <form method="POST" action="{{ url('/login') }}">
                                @csrf
                                <div class="mb-4">
                                    <input type="text" id="email" name="email" value="{{ old('email') }}"
                                        class="form-control" aria-describedby="emailHelp" placeholder="Enter Your Email"
                                        autocomplete="email" required>
                                    @if ($errors->has('email'))
                                    <div class="text-danger">
                                        @foreach ($errors->get('email') as $error)
                                            {{ $error }}
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                                <div class="mb-4">
                                    <div class="password-container w-100">
                                        <input type="password" name="password" id="password" class="form-control p-1"
                                            id="password" placeholder="  Password" value="{{ old('password') }}"
                                            autocomplete="current-password" required>
                                        <i class="fa-solid fa-eye" id="eye"></i>
                                        @if ($errors->has('password'))
                                        <div class="text-danger">
                                            {{ $errors->first('password') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-5 form-check">
                                    <input type="checkbox" class="form-check-input p-1" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Remember
                                        Credentials</label>
                                </div>
                                <div class="mb-3 blue-btn-div rounded-0">
                                    <button type="submit" class="blue-btn p-2 fs-5">LOGIN</button>
                                </div>
                            </form>
                            <h5 class="create-one-acount">Don’t Have An Account?<a
                                    href="{{route('user.signup')}}">Create
                                    One</a></h5>
                        </div>
                        <div class="mt-5 w-100">
                            <h6 class="terms-policies">By clicking “Log in” you agree to <a href="#"> Terms of
                                    Service</a> and <a href="#"> Privacy Policy</a></h6>
                        </div>
                    </div>
                </div>
            </div>

        </section>
        <!--=======================login Section End Here-->
    </main>

    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('user_assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('user_assets/js/jquery-3.6.0.min.js') }}"></script>

    <script>
    const passwordInput = document.querySelector("#password")
    const eye = document.querySelector("#eye")

    eye.addEventListener("click", function(){
    this.classList.toggle("fa-eye-slash")
    const type = passwordInput.getAttribute("type") === "password" ? "text" : "password"
    passwordInput.setAttribute("type", type)
    })

</script>
</body>

</html>