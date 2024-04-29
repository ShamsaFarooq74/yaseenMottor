<!DOCTYPE html>
<html lang="en-gb">
@php
  $setting = App\Http\Models\Config::first(['key', 'values']);
@endphp
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
     <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title>{{env('APP_NAME')}} @yield('title')</title>
   <link rel="icon" type="image/png" href="{{ asset('assets/images/'.$setting->values) }}"/>
    <!--  CSS Files -->
    <link href="{{ asset('user_assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('user_assets/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <!-- Template Main CSS File -->
    <link href="{{ asset('user_assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('user_assets/css/findcar.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="{{ asset('user_assets/js/jquery-3.6.0.min.js') }}"></script>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.js"></script>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css">

</head>

<body>@include('layouts.user.block.header') <main id="main">
        <!--=======================Main Section Start Here-->
        @yield ('content')
        <!--=======================Main Section End Here-->
    </main>
    <!--=======================Footer Start Here-->
    @include('layouts.user.block.footer')
    <!--=======================Footer end Here-->
    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('user_assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>