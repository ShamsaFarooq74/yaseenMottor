@extends('layouts.user.block.app')

@section('content')
@section('title','-About-us')
<!--=======================AboutUs Slider Section Start Here-->
<section id="contact-slider" class="p-5">
    <div class="container mx-auto text-lg-start p-5">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="text-center mx-auto custom-title pt-4"><span class="d-lg-block">
                        <h1>ABOUT US</h1>
                    </span>
                </div>
                <div class="slider-p text-center mx-auto contact-title">Your one stop shop for quality vehicle!</div>
            </div>
        </div>
    </div>
</section>
<!--=======================AboutUs Slider Section End Here-->

<!--=======================AboutUs Section Start Here-->
<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-sm-12 about-buyer p-3">
                <h2>Yaseen Motors Co., Ltd, established <span>Japanese</span> and <span>Global</span> New and Used Vehicle Exporter and Import</h2>
                <!-- <h2>Redefining the Used Car Buying Experience with <span>Quality</span>, <span>Trust</span>, and
                    <span>Value</span>."</h2> -->
                <p>Yaseen Motors Co., Ltd, takes pride as exporters of new and used Japanese and Global Brands worldwide. Since our establishment in 2003, we have successfully met the expectations of customers around the globe. Our journey to success has been filled with challenges, but we have overcome those challenges with innovative ideas and technology based solutions.</p>
                <br>
                <p>We consider ourselves to be more than a company; Yaseen Motors Co., Ltd embodies a deep desire and passion to serve and grow. Our success story has been driven by the relentless hard work, dedication, and commitment of our team members. By embracing this challenge, we have excelled in providing our customers with chosen new and used vehicles of the highest quality at affordable prices.</p>
                <br>
                <p>At Yaseen Motors Co., Ltd, we boast an extensive inventory that includes a wide selection of pre-owned (used) and brand-new vehicles. Whether you’re in search of hypercars, supercars, sports cars, exotic cars, sedans, hatchbacks, Suv , commercial vans, pickups, buses, or trucks, etc., we have you covered. Our competitive prices are made possible as we are proud members of all 125+ major auto auctions in Japan. Additionally, as authorized new and used car exporters, importers, and members of the Chambers of Commerce, Japan Company Trust Organization, Japan Used Motor Vehicle Exporters Association (JUMVEA), and Used Car Dealers Association, we ensure the utmost professionalism and integrity in all our dealings.</p>
                <br>
                <p>Our commitment to success and customer satisfaction remains steadfast as we strive to make the future brighter for both ourselves and our valued customers. From the very beginning, we have set out on a mission to provide warm customer service, offer the best quality vehicles, maintain low prices, and ensure prompt shipment. After more than two decades in the automobile industry, we are proud to say that we are on the road of success and growth.
Throughout our journey, we have focused on three vital aspects of our mission: quality, service, and prices. By upholding these parameters, we have gained trust and loyalty of our customers. We are determined to maintain these standards.</p>
                <br>
                <p>Yaseen Motors Co., Ltd, takes pride in serving customers and partners . Please feel free to reach out to us with any inquiries, suggestions, or feedback. Customers will be assured of a prompt and satisfactory response.</p>
                 <a href="{{ route('contactus') }}"><div class="mb-3 mt-5 red-btn-div rounded-2">
                    <button type="submit" class="red-btn p-3 fs-6">CONTACT NOW</button>
                </div></a>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12  custom-contact-right pt-3 align-items-center">
            
                    <img src="{{ asset('user_assets/img/details/about-car.png') }}" class="aboutus-Img"
                        alt="Background Image">

            </div>

        </div>
    </div>
</section>
<!--=======================AboutUs  Section End Here-->
@endsection