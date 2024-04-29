<!DOCTYPE html>
<html lang="en-gb">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
@php
  $setting = App\Http\Models\Config::first(['key', 'values']);
@endphp
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  
    <meta name="csrf-token" content="{{ csrf_token() }}">
       <title> {{env("APP_NAME")}} - Sign up</title>

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

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css">
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
    $c_green ="#12B76A";
    $red_color = "#DD1919";
    $white_color = "#FFFFFF";
    $blackgray_color ="#000000B2";
    $slate_gray = "#6C7680";
    $white_smoke ="#F4F4F4";
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
         --color-red: <?=$red_color ?>;
        --orange-color: <?=$orange_color ?>;
        --darkRockBlue-color: <?=$darkRockBlue ?>;
        --dark-jungle-green: <?=$dark_jungle_green ?>;
        --yankess-blue: <?=$yankess_blue ?>;
        --blackgray_color: <?=$blackgray_color ?>;
        --saltegray-color: <?=$slate_gray ?>;
        --orange-peel-color: <?=$orange_peel ?>;
        --white-smoke: <?=$white_smoke ?>;
    }
    </style>
</head>

<body>
    <main id="main">
         @section('title', 'yaseen-motors'.'-'.'sign','-','up')
        <!--=======================login Section Start Here-->
        <section class="p-0">
                <div class="row custom-login-div">
                    <div
                        class="col-lg-6 col-md-6 col-sm-6 custom-div-left p-5 d-flex justify-content-center align-items-center">
                        <div class="trust-cars-heading p-3">
                            <q class="text-light">
                                <h1>YOUR TRUSTED PARTNERS FOR USED CARS!</h1>
                                <h6>Upgrade Your Ride: dada
                                    Find Your Dream Car among our Handpicked Selection of Used
                                    Vehicles.
                                </h6>
                            </q>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 custom-div-right">
                        <div class="col-lg-12 col-md-12 col-sm-12 p-4">
                            <div class="login-heading mt-5">
                                <h2>CREATE ACCOUNT</h2>
                                <h5>Welcome to the used car website! To get started, you'll need to create a new
                                    account.</h5>
                            </div>
                            <div class="mt-5 mb-5">
                                <form>
                                    <div class="mb-4">
                                        <input type="text" id="username" name="username" value="{{ old('username') }}"
                                            class="form-control" aria-describedby="usename" placeholder="User Name"
                                            required>
                                        <div id="error-username" class="text-danger"></div>
                                        @if ($errors->has('username'))
                                        <div class="text-danger">
                                            {{ $errors->first('username') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-4">
                                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                                            class="form-control" aria-describedby="name" placeholder="Full Name"
                                            autocomplete="off" required>
                                        <div id="error-name" class="text-danger"></div>
                                        @if ($errors->has('name'))
                                        <div class="text-danger">
                                            {{ $errors->first('name') }}
                                        </div>
                                        @endif
                                    </div>

                                    <div class="mb-4">
                                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                                            class="form-control" aria-describedby="emailHelp"
                                            placeholder="Email address" required>
                                        <div id="error-email" class="text-danger"></div>
                                        @if ($errors->has('email'))
                                        <div class="text-danger">
                                            {{ $errors->first('email') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-4">
                                        <div class="password-container w-100">
                                            <input type="password" name="password" id="password"
                                                class="form-control p-1" id="password" placeholder="  Password"
                                                value="{{ old('password') }}" required>
                                            <i class="fa-solid fa-eye" id="eye"></i>
                                            <div id="error-password" class="text-danger"></div>
                                            @if ($errors->has('password'))
                                            <div class="text-danger">
                                                {{ $errors->first('password') }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <div class="password-container w-100">
                                            <input type="password" name="confirm_password" id="confirmPassword"
                                                class="form-control p-1" placeholder="  Confirm Password"
                                                value="{{ old('confirm_password') }}" required>
                                            <i class="fa-solid fa-eye" id="confirm-pass-eye"></i>
                                            <div id="error-conpassword" class="text-danger"></div>
                                            @if ($errors->has('confirm_password'))
                                            <div class="text-danger">
                                                {{ $errors->first('confirm_password') }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3 blue-btn-div rounded-0">
                                        <button id="signup" class="blue-btn p-2 fs-5">Create
                                            Account</button>
                                    </div>
                                </form>
                                <h5 class="create-one-acount">Already Have An Account?<a
                                        href="{{route('user.login')}}">Login</a></h5>
                            </div>
                            <div class="mt-5 w-100">
                                <h6 class="terms-policies">By clicking “Create Account” you agree to <a href="#"> Terms
                                        of
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
     <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.js"></script>
    <script>
        const passwordInput = document.querySelector("#password")
        const eye = document.querySelector("#eye")

        eye.addEventListener("click", function(){
        this.classList.toggle("fa-eye-slash")
        const type = passwordInput.getAttribute("type") === "password" ? "text" : "password"
        passwordInput.setAttribute("type", type)
        })
        const confirmPasswordInput = document.querySelector("#confirmPassword")
        const confirmPassEye = document.querySelector("#confirm-pass-eye")

        confirmPassEye.addEventListener("click", function(){
        this.classList.toggle("fa-eye-slash")
        const type = confirmPasswordInput.getAttribute("type") === "password" ? "text" : "password"
        confirmPasswordInput.setAttribute("type", type)
        })

    </script>
    <script>
    $(document).ready(function() {
        function clearMessages() {
            $("#error-email").text("");
            $("#error-name").text("");
            $("#error-username").text("");
            $("#error-password").text("");
            $("#error-conpassword").text("");
        }
        $("#signup").click(function(event) {
            event.preventDefault();
            var username = $("#username").val();
            var name = $("#name").val();
            var email = $("#email").val().trim();
            var password = $("#password").val();
            var confirm_password = $("#confirmPassword").val();

            if (username === "") {
                $("#error-username").text("Enter Your Name");
                return;
            } else {
                $("#error-username").text("");
            }
            if (name === "") {
                $("#error-name").text("Enter Your Full Name");
                return;
            } else {
                $("#error-name").text("");
            }


            if (email === "") {
                $("#error-email").text("Enter Your Email");
                return;
            } else if (!email.match(/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/)) {
                $("#error-email").text("Enter Email Like usedcar@gmail.com");
                return;
            } else {
                $("#error-email").text("");
            }

            if (password === "") {
                $("#error-password").text("Enter Your Password");
            } else if (password.length < 8) {
                $("#error-password").text("Password must be at least 8 characters");
                return;
            } else {
                $("#error-password").text("");
            }

            if (confirm_password === "") {
                $("#error-conpassword").text("Confirm your password");
            } else if (password !== confirm_password) {
                $("#error-conpassword").text("Passwords do not match");
                return;
            } else {
                $("#error-conpassword").text("");
            }

            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "{{ route('user.store') }}",
                method: 'POST',
                data: {
                    username: username,
                    name: name,
                    email: email,
                    password: password,
                    confirm_password: confirm_password,
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                },
                success: function(response) {
                    $("#username").val("");
                    $("#name").val("");
                    $("#email").val("");
                    $("#password").val("");
                    $("#confirmPassword").val("");
                    $("#alert-success").show();
                    toastr.success('You Are Registered Successfully!');
                    if (response.redirect) {
                        window.location.href = response.redirect;
                    }
                },
                error: function(xhr, status, error) {
                    var responseJSON = xhr.responseJSON;
                    if (responseJSON.errors && responseJSON.errors.email) {
                        $("#error-email").text(responseJSON.errors.email[0]);
                        $("#error-name").text("");
                        $("#error-username").text("");
                        $("#error-password").text("");
                        $("#error-conpassword").text("");
                        setTimeout(clearMessages, 5000);
                    } else {
                        console.error('Error:', error);
                    }
                }
            });
        });
    });
    </script>

</body>

</html>