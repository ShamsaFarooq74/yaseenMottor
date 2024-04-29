@php
$light_silver = "#D9D9D9";
$darkblue = "#2D3282";
$offwhite = "#F5F8FF";
$green_color = "#00B341";
$rockblue = "#98A2B3";
$orange_color = "#EC4A0A";
$darkRockBlue = "#2D328233";
$dark_jungle_green ="#101828";
$yankess_blue = "#1D2939";
$c_green ="#12B76A";
$white_color = "#FFFFFF";
$linear_header_color = "#34343366";
$pale_chestnut = "#D92D2033";
$red_color = "#DD1919";
$maximum_red = "#DD191926";
$dark_pink = "#DD191933";
$prussian_blue = "#073D63";
$very_dark_gray = "#666666";
$very_maximum_red = "#DD1C1A33";
$light_gray ="#1018280D";
$black_russian ="#101828";
$solitude_color ="#EAECF0";
$white_smoke ="#F4F4F4";
$sangria ="#7B0004";
$very_black_russian ="#0000001A" ;
$overlay_color ="#00000040";
$blue_color ="#1849A9";
$light_grayish_blue ="#E2E8F0";
$medium_slate_blue ="#6172F3";
$v_dark_gray ="#4C4C4C";
@endphp

<style>
:root {
    --linear-header-color: <?=$linear_header_color ?>;
    --light-silver: <?=$light_silver ?>;
    --darkblue-color: <?=$darkblue ?>;
    --offwhite-color: <?=$offwhite ?>;
    --green-color: <?=$green_color ?>;
    --c-green: <?=$c_green ?>;
    --white-color: <?=$white_color ?>;
    --rockblue-color: <?=$rockblue ?>;
    --orange-color: <?=$orange_color ?>;
    --darkRockBlue-color: <?=$darkRockBlue ?>;
    --dark-jungle-green: <?=$dark_jungle_green ?>;
    --yankess-blue: <?=$yankess_blue ?>;
    --pale-chestnut: <?=$pale_chestnut ?>;
    --color-red: <?=$red_color ?>;
    --maximum-red: <?=$maximum_red ?>;
    --dark-pink: <?=$dark_pink ?>;
    --prussian-blue: <?=$prussian_blue ?>;
    --very-darkgray: <?=$very_dark_gray ?>;
    --very-maximum-red: <?=$very_maximum_red ?>;
    --light-gray: <?=$light_gray ?>;
    --black-russian: <?=$black_russian ?>;
    --solitude-color: <?=$solitude_color ?>;
    --white-smoke: <?=$white_smoke ?>;
    --sangria: <?=$sangria ?>;
    --very-black-russian: <?=$very_black_russian ?>;
    --overlay-color: <?=$overlay_color ?>;
    --blue-color: <?=$blue_color ?>;
    --light-grayish-blue: <?=$light_grayish_blue ?>;
   --medium-slate-blue: <?=$medium_slate_blue ?>;
   --v-dark-gray: <?=$v_dark_gray ?>;
}
</style>


<header class="custom-header fixed-top">
    <div class="container ">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{url('/')}}"><img class="logo"
                        src="{{asset('assets/images/'.$setting->values) }}" /></a>
                <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <!-- <span class="navbar-toggler-icon"></span> -->
                    <img class="toggle-img" src="{{ asset('user_assets/img/home-slider/toggle-bar.png') }}" />
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 mx-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('aboutus') ? 'active' : '' }}"
                                href="{{ route('aboutus') }}">ABOUT US</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('user-payment') ? 'active' : '' }}"
                                href="{{ route('user.payment') }}">PAYMENT</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('stock') ? 'active' : '' }}"
                                href="{{ route('stock') }}">STOCKS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('services') ? 'active' : '' }}"
                                href="{{ route('services') }}">SERVICES</a>
                        </li>
                        <li class="nav-item-last">
                            <a class="nav-link {{ request()->is('contactus') ? 'active' : '' }}"
                                href="{{ route('contactus') }}">CONTACT US</a>
                        </li>
                    </ul>
                    @if(Auth::user())
                    <div class="d-flex">
                        <a class="d-flex text-dark" href="{{route('favorites')}}">
                            <div class="favorites me-3">
                                <img src="{{asset('user_assets/img/home-slider/favorite.png') }}" />
                            </div>
                            <div class="counter">
                                <h6>{{$favoriteCount}}</h6>
                            </div>
                        </a>
                        <div class="d-flex user-div">
                            @if(Auth::user()->image)
                            <img src="{{asset('images/profile-pic/'.Auth::user()->image)}}" alt="user-image"
                                class="rounded-circle">
                            @else
                            <img src="{{asset('user_assets/img/home-slider/users.png') }}" />
                            @endif
                            <!-- <span class="pt-2"> {{Auth::user()->username}}</span> -->
                            <div class="dropdown pt-1">
                                <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    {{Auth::user()->username}}
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li> <a class="dropdown-item notify-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">Log out</a></li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </ul>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="d-flex">
                        <a href="{{route('user.login')}}" class="btn light-btn mx-1">
                            <div>Login</div>
                        </a>
                        <a href="{{route('user.signup')}}" class="btn light-btn mx-1 active-btn">
                            <div>Register</div>
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </nav>
    </div>
</header>
<!-- Inquire Modal Start Here  -->
<div class="modal fade" id="formModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="contact-form pt-4">
                <h2>Get A Price Quote!</h2>
                <h5>Inquire Now!</h5>
            </div>
            <div class="modal-body">
                <input type="hidden" id="partIdInput" name="part_id">
                <div class="mb-4">
                    <label for="userName" class="mb-2 contact-label">Full Name<span class="star_vt">*</span></label>
                    <input type="text" id="userName" name="userName" value="{{ old('userName') }}" class="form-control"
                        aria-describedby="usename" placeholder="Enter Your Name" required>
                    <div id="error-userName" class="text-danger"></div>
                    @if ($errors->has('userName'))
                    <div class="text-danger">
                        {{ $errors->first('userName') }}
                    </div>
                    @endif
                </div>
                <div class="mb-4">
                    <label for="userEmail" class="mb-2 contact-label">Email<span class="star_vt">*</span></label>
                    <input type="email" id="userEmail" name="userEmail" value="{{ old('userEmail') }}"
                        class="form-control" aria-describedby="emailHelp" placeholder="Enter Email address" required>
                    <div id="error-userEmail" class="text-danger"></div>
                    @if ($errors->has('userEmail'))
                    <div class="text-danger">
                        {{ $errors->first('userEmail') }}
                    </div>
                    @endif
                </div>
                <div class="mb-4">
                    <label for="userPhone" class="mb-2 contact-label">Phone Number<span class="star_vt">*</span></label>
                    <input type="text" id="userPhone" name="userPhone" value="{{ old('userPhone') }}"
                        class="form-control" aria-describedby="userPhone" placeholder="Phone Number">
                    <div id="error-userPhone" class="text-danger"></div>
                    @if ($errors->has('userPhone'))
                    <div class="text-danger">
                        {{ $errors->first('userPhone') }}
                    </div>
                    @endif
                </div>
                <div class="mb-4">
                    <label for="country" class="mb-3 contact-label">Country<span class="star_vt">*</span></label>
                    <select class="form-control" id="country" name="country">
                        @foreach($countries as $key => $country)
                        <option value='{{$country->id}}'>{{$country->country_name}}</option>
                        @endforeach
                    </select>
                    <div id="error-country" class="text-danger"></div>
                </div>
                <div class="mb-4">
                    <label for="city" class="mb-3 contact-label">City<span class="star_vt">*</span></label>
                    <select class="form-control" id="city" name="city">
                        @foreach($cities as $key => $city)
                        <option value='{{$city->id}}'>{{$city->city_name}}</option>
                        @endforeach
                    </select>
                    <div id="error-city" class="text-danger"></div>
                </div>
                <div class="mb-4">
                    <label for="userAddress" class="mb-3 contact-label">Address<span class="star_vt">*</span></label>
                    <input type="text" id="userAddress" name="userAddress" value="{{ old('userAddress') }}"
                        class="form-control" aria-describedby="userAddress" placeholder="Enter Your Address" required>
                    <div id="error-userAddress" class="text-danger"></div>
                    @if ($errors->has('userAddress'))
                    <div class="text-danger">
                        {{ $errors->first('userAddress') }}
                    </div>
                    @endif
                </div>
                <div class="mb-3 red-btn-div p-1 rounded-2">
                    <button id="userButton" class="red-btn p-2">GET NOW</button>
                </div>

            </div>
            <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
        </div>
    </div>
</div>

<!-- Inquire Modal End Here  -->
<script>
function partId(partId) {
    document.getElementById('partIdInput').value = partId;
}

</script>
<script>
$(document).ready(function() {
    // Add active class on click and remove from siblings
    $('.navbar-nav a').click(function() {
        $(this).addClass('active').siblings().removeClass('active');
    });
});
</script>
<script>
// form ajax
$(document).ready(function() {
    function clearMessages() {
        $("#error-userEmail").text("");
        $("#error-userName").text("");
        $("#error-userPhone").text("");
        $("#error-country").text("");
        $("#error-city").text("");
        $("#error-userAddress").text("");
    }
    $("#userButton").click(function() {
        var userName = $("#userName").val();
        var userEmail = $("#userEmail").val().trim();
        var userPhone = $("#userPhone").val();
        var country = $("#country").val();
        var city = $("#city").val();
        var userAddress = $("#userAddress").val();
        if (userName === "") {
            $("#error-userName").text("Enter Your Name");
            return;
        } else if (!userName.match(/^[A-Za-z ]+$/)) {
            $("#error-userName").text("Name must contain only letters");
            return;
        } else {
            $("#error-userName").text("");
        }
        if (userEmail === "") {
            $("#error-userEmail").text("Enter Your Email");
            return;
        } else if (!userEmail.match(/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/)) {
            $("#error-userEmail").text("Enter Email Like UsedCar@gmail.com");
            return;
        } else {
            $("#error-userEmail").text("");

        }
        if (userPhone === "") {
            $("#error-userPhone").text("Enter Your Phone Number");
            return;
        } else {
            $("#error-userPhone").text("");
        }
        if (country === "") {
            $("#error-country").text("Enter Your Country");
            return;
        } else {
            $("#error-country").text("");
        }
        if (city === "") {
            $("#error-city").text("Enter Your City");
            return;
        } else {
            $("#error-city").text("");
        }
        if (userAddress === "") {
            $("#error-userAddress").text("Enter Your Address");
            return;
        } else {
            $("#error-userAddress").text("");
        }
        let partIdValue = document.getElementById('partIdInput').value;
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "{{route('partInquire.store') }}",
            method: 'POST',
            data: {
                email: userEmail,
                name: userName,
                phone: userPhone,
                country: country,
                city: city,
                address: userAddress,
                part_id: partIdValue,
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            },
            success: function(response) {
                console.log(response);
                $("#userName").val("");
                $("#userEmail").val("");
                $("#userPhone").val("");
                $("#country").val("");
                $("#city").val("");
                $("#userAddress").val("");
                $("#alert-success").show();
                // Swal.fire({
                //     icon: 'success',
                //     title: 'Success!',
                //     text: response.success,
                //     showConfirmButton: false,
                //     timer: 3000 // Set the duration for the success message
                // })
                toastr.success('Your Message Recieved Successfully!');
                $('#formModel').modal('hide');
            },
            error: function(xhr, status, error) {
                var responseJSON = xhr.responseJSON;
                if (responseJSON.errors && responseJSON.errors.email) {
                    $("#error-userEmail").text(responseJSON.errors.email[0]);
                    $("#error-userName").text("");
                    $("#error-userAddress").text("");
                    $("#error-userPhone").text("");
                    $("#error-country").text("");
                    $("#error-city").text("");
                    setTimeout(clearMessages, 5000);
                } else {
                    console.error('Error:', error);
                }
            }
        });


    });
});
</script>
<!-- <script>
$(document).ready(function() {
    $('#country').on('change', function() {
        var countryId = $(this).val();
        if (countryId) {
            $.ajax({
                type: 'POST',
                url: '{{ route('getlocationBycountry') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    county_id: countryId
                },
                success: function(data) {

                    $('#city').empty();
                    $('#city').append(
                        '<option value="" selected disabled>--Choose city--</option>'
                    );
                    $.each(data, function(key, location) {
                        $('#city').append('<option value="' + location
                            .id +
                            '">' + location.city_name + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        } else {
            $('#city').empty();
            $('#city').prop('disabled', true);
        }
    });
});
</script> -->
<script>
      $(document).ready(function() {
        $('.pagination li:first-child .page-link').html(
            '<i class="fa fa-arrow-left" aria-hidden="true"></i> Previous');
        $('.pagination li:last-child .page-link').html(
            'Next <i class="fa fa-arrow-right" aria-hidden="true"></i>');
        $('.favorite-link').click(function(e) {
            e.preventDefault();
            var favoriteContainer = $(this).closest('.favorite-container');
            var partId = favoriteContainer.data('part-id');
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            if ({{
                        auth()-> check() ? 'true' : 'false'
                    }}) {
                $.ajax({
                    url: "{{ url('add-to-favorite') }}/" + partId,
                    method: 'POST',
                    data: {
                        id: partId,
                    },
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    success: function(response) {
                        location.reload();
                        console.log(response);
                        var heartIconSrc = response.favoriteCount > 0 ?
                            '{{ asset("user_assets/img/home-slider/filled-Heart.png") }}' :
                            '{{ asset("user_assets/img/home-slider/Heart.png") }}';

                        console.log('heartIconSrc:', heartIconSrc);

                        favoriteContainer.find('.heart-icon').attr('src', heartIconSrc);
                    }
                });
            } else {

                window.location.href = "{{ route('user.login') }}";
            }
        });
    });
</script>