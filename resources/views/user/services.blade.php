@extends('layouts.user.block.app')

@section('content')
@section('title', '-Services')
<!--=======================Services Slider Section Start Here-->
<section id="contact-slider" class="p-5">
    <div class="container mx-auto text-lg-start p-5">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="text-center mx-auto custom-title pt-4"><span class="d-lg-block">
                        <h1>Services</h1>
                    </span>
                </div>
                <div class="slider-p text-center mx-auto contact-title">Tailored Services to Meet Your Unique Needs
                    and Exceed Expectations.</div>
            </div>
        </div>
    </div>
</section>
<!--=======================Services Slider Section End Here-->

<!--=======================Services Section Start Here-->
<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 service-provider p-3">
                <h2>Our Best Services We Provide!</h2>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6  custom-payment-div pt-4 align-items-center">
               <p> Our used car website offers a comprehensive range of services to ensure a seamless and satisfying car
                buying experience. With an extensive inventory of quality used cars from various makes, models, and
                variants, we provide diverse options to suit different preferences and budgets.</p>
            </div>
        </div>
    </div>
</section>
<!--=======================Services  Section End Here-->

<!--=======================Cards Section Start Here-->
<section class="pt-0">
    <div class="container">
        <div class="mx-auto my-5">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card testimonial-card mt-2 mb-3 px-3">
                        <div class="mx-auto div-border rounded-circle my-3">
                            <img src="{{ asset('user_assets/img/details/mask-group.png') }}"
                                class="rounded-circle img-border img-fluid" alt="car img">
                        </div>
                        <div class="card-body text-center">
                            <h4 class="card-title">Extensive inventory</h4>
                            <p>Assistance in securing financing options or connecting buyers with trusted lending
                                partners to facilitate the purchase of a used car.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card testimonial-card mt-2 mb-3 px-3">
                        <div class="mx-auto div-border rounded-circle my-3">
                            <img src="{{ asset('user_assets/img/details/mask-group.png') }}"
                                class="rounded-circle img-border img-fluid" alt="car img">
                        </div>
                        <div class="card-body text-center">
                            <h4 class="card-title">Extensive inventory</h4>
                            <p> Assistance in securing financing options or connecting buyers with trusted lending
                                partners to facilitate the purchase of a used car.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card testimonial-card mt-2 mb-3 px-3">
                        <div class="mx-auto div-border rounded-circle my-3">
                            <img src="{{ asset('user_assets/img/details/mask-group.png') }}"
                                class="rounded-circle img-border img-fluid" alt="car img">
                        </div>
                        <div class="card-body text-center">
                            <h4 class="card-title">Extensive inventory</h4>
                            <p> Assistance in securing financing options or connecting buyers with trusted lending
                                partners to facilitate the purchase of a used car.</p>
                        </div>
                    </div>
                </div>
             
               
            </div>
        </div>
    </div>
</section>
<!--=======================Cards  Section End Here-->
@endsection