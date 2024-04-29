@extends('layouts.user.block.app')

@section('content')
@section('title','-Contact-us')
<!--=======================ConntactUs Slider Section Start Here-->
<section id="contact-slider" class="p-5">
    <div class="container mx-auto text-lg-start p-5">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="text-center mx-auto custom-title pt-4"><span class="d-lg-block">
                        <h1>CONTACT US</h1>
                    </span>
                </div>
                <div class="slider-p text-center mx-auto contact-title">Let’s start a conversation, Ask how can we
                    help you.</div>
            </div>
        </div>
    </div>
</section>
<!--=======================ConntactUs Slider Section End Here-->

<!--=======================ConntactUs Section Start Here-->
<section>
    <div class="container">
        <div class="row custom-contact-div">
            <div class="col-lg-6 col-md-6 col-sm-6 custom-contact-left">
                <div class="col-lg-12 col-md-12 col-sm-12 p-4">
                    <div class="contact-form mt-2">
                        <h2>Talk To Us</h2>
                        <h5>How Can We Help You?</h5>
                    </div>
                    <div class="mt-5">
                            <div class="alert alert-success" role="alert" id="alert-success" style="display:none"></div>
                            <div class="mb-4">
                                <label for="fullname" class="mb-2 contact-label">Full Name<span
                                        class="star_vt">*</span></label>
                                <input type="text" id="customName" name="fullname" value="{{ old('fullname') }}"
                                    class="form-control" aria-describedby="usename" placeholder="Enter Your Name"
                                    required>
                                <div id="error-fullname" class="text-danger"></div>
                                @if ($errors->has('fullname'))
                                <div class="text-danger">
                                    {{ $errors->first('fullname') }}
                                </div>
                                @endif
                            </div>
                            <div class="mb-4">
                                <label for="email" class="mb-2 contact-label">Email<span
                                        class="star_vt">*</span></label>
                                <input type="email" id="customEmail" name="email" value="{{ old('email') }}"
                                    class="form-control" aria-describedby="emailHelp" placeholder="Enter Email address"
                                    required>
                                <div id="error-email" class="text-danger"></div>
                                @if ($errors->has('email'))
                                <div class="text-danger">
                                    {{ $errors->first('email') }}
                                </div>
                                @endif
                            </div>
                            <div class="mb-4">
                                <label for="phoneno" class="mb-2 contact-label">Phone Number<span
                                        class="star_vt">*</span></label>
                                <input type="text" id="customPhoneNo" name="phoneNo" value="{{ old('phoneNo') }}"
                                    class="form-control" aria-describedby="phoneNo" placeholder="Phone Number">
                                <div id="error-phoneNo" class="text-danger"></div>
                                @if ($errors->has('phoneNo'))
                                <div class="text-danger">
                                    {{ $errors->first('phoneNo') }}
                                </div>
                                @endif
                            </div>
                            <div class="mb-4">
                                <label for="message" class="mb-3 contact-label">Your Message<span
                                        class="star_vt">*</span></label>
                                <textarea class="form-control" cols="6" rows="5"
                                    placeholder="Enter Your Message" id="customMessage"></textarea>
                                <div id="error-message" class="text-danger"></div>

                            </div>
                            <div class="mb-3 red-btn-div p-1 rounded-0">
                                <button id="customButton" class="red-btn p-2">SUBMIT MESSAGE</button>
                            </div>

                    </div>

                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6  custom-contact-right pt-3 align-items-center">
                <div class="p-3">
                    <h1>Get in touch</h1>
                    <p>We're here to help! If you have any questions, please don't hesitate to get in touch. You can
                        reach us by phone , by email or by filling out the form on our contact page. We look forward to
                        hearing from you!</p>
                </div>
                <div class="d-flex w-100 px-4 py-3">
                    <div class="d-flex contact-address justify-contant-center text-center mx-3">
                        <a href="#" class="mt-1"><img src="{{ asset('user_assets/img/icons/location.png')}}" /></a>

                    </div>
                    <div class="mx-3 contact-address-heading" style="width: 50%; text-align: left;">
                        <h2>Address</h2>
                        <h6>Yaseen Motors Pte Ltd 41 Toh Guan Road East, Singapore 608605.</h6>
                    </div>
                </div>
                <div class="d-flex w-100 px-4 py-3">
                    <div class="d-flex contact-address justify-contant-center text-center mx-3">
                        <a href="mailto:yaseenjapan111@gmail.com" class="mt-1"><img src="{{ asset('user_assets/img/icons/email.png')}}" /></a>

                    </div>
                    <div class="mx-3 contact-address-heading" style="width: 50%; text-align: left;">
                        <h2>Email</h2>
                        <h6>yaseenmotors111@gmail.com</h6>
                    </div>
                </div>
                <div class="d-flex w-100 px-4 py-3">
                    <div class="d-flex contact-address justify-contant-center text-center mx-3">
                        <a href="https://wa.link/nniz1z" class="mt-1"><img src="{{ asset('user_assets/img/icons/phone.png')}}" /></a>

                    </div>
                    <div class="mx-3 contact-address-heading" style="width: 50%; text-align: left;">
                        <h2>Phone</h2>
                        <h6>+819087774398</h6>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!--=======================ContactUs  Section Start Here-->
<script>
$(document).ready(function() {
    function clearMessages() {
        $("#error-email").text("");
        $("#error-name").text("");
        $("#error-phoneNo").text("");
        $("#error-message").text("");
    }
    $("#customButton").click(function() {
        var customerName = $("#customName").val();
        var customerEmail = $("#customEmail").val().trim();
       var customPhoneNo = $("#customPhoneNo").val();
        var customerMessage = $("#customMessage").val();
        if (customerName === "") {
            $("#error-fullname").text("Enter Your Name");
            return;
        } else if (!customerName.match(/^[A-Za-z ]+$/)) {
            $("#error-fullname").text("Name must contain only letters");
            return;
        } else {
            $("#error-fullname").text("");
        }
        if (customerEmail === "") {
            $("#error-email").text("Enter Your Email");
            return;
        } else if (!customerEmail.match(/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/)) {
            $("#error-email").text("Enter Email Like UsedCar@gmail.com");
            return;
        } else {
            $("#error-email").text("");

        }
      if (customPhoneNo === "") {
            $("#error-phoneNo").text("Enter Your Phone Number");
            return;
        } else {
            $("#error-phoneNo").text("");
        }

        
        if (customerMessage === "") {
            $("#error-message").text("Enter Your message");
        } else if (customerMessage.length < 10) {
            $("#error-message").text("Message must be at least 10");
            return;
        } else {
            $("#error-message").text("");
        }

        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "{{route('contactUs.store') }}",
            method: 'POST',
            data: {
                email: customerEmail,
                name: customerName,
                phone:customPhoneNo,
                message: customerMessage,
            },
            headers: {
                    'X-CSRF-TOKEN': csrfToken,
                },
            success: function(response) {
                $("#customEmail").val("");
                $("#customName").val("");
                $("#customPhoneNo").val("");
                $("#customMessage").val("");
                $("#alert-success").show();
                $("#alert-success").text(response.success);
                $("#alert-success").fadeOut(5000);
            },
            error: function(xhr, status, error) {
                var responseJSON = xhr.responseJSON;
                if (responseJSON.errors && responseJSON.errors.email) {
                    $("#error-email").text(responseJSON.errors.email[0]);
                    $("#error-name").text("");
                    $("#error-phoneNo").text("");
                    $("#error-message").text("");
                    setTimeout(clearMessages, 5000);
                } else {
                    console.error('Error:', error);
                }
            }
        });


    });
});
</script>
@endsection