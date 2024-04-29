@extends('layouts.user.block.app')

@section('content')
@section('title', '- '. \Carbon\Carbon::parse($partsDetail->manufacturer)->format('Y') .'
'.strtoupper($partsDetail->make->make).' '.strtoupper($partsDetail->model->model_name).'
'.strtoupper($partsDetail->version))
<!-- ======================= Topbar Section Start Here-->
<section id="topbar" class="pb-0">
    <div class=" container">
        <div class="row mt-5">
            <div class="col-lg-12 d-flex">
                <span>Home<img src="{{ asset('user_assets/img/details/double-arrow.png') }}"
                        class="me-1">{{strtoupper($partsDetail->make->make)}}<img
                        src="{{ asset('user_assets/img/details/double-arrow.png') }}"
                        class="me-1">{{ucfirst($partsDetail->model->model_name)}}<img
                        src="{{ asset('user_assets/img/details/double-arrow.png') }}"
                        class="me-1" />{{ \Carbon\Carbon::parse($partsDetail->reg_no)->format('Y') }}</span>
                </span>
            </div>
        </div>
    </div>
</section>
<!-- ======================= Topbar Section Start Here-->

<!-- =======================Fort Explore Section Start Here-->

@php
$countryName = session()->get('countryName');
$portName = session()->get('portName');
@endphp
<section id="fort-explore" class="pt-0 pb-0">
    <div class="container">
        <div class="row mt-3">
            <div class="col-lg-6">
                <div class="v-main-div">
                    <div id="demo{{$partsDetail->id}}" class="carousel slide carousel-slide-positions"
                        data-bs-ride="carousel">
                        <!-- The slideshow/carousel -->
                        <div class="carousel-inner">
                            @foreach($partImages as $key => $image)
                            @php
                            if ($image->image) {
                            $imagePath = public_path('images/parts/'.$image->image);
                            if (File::exists($imagePath)) {
                            $image->image ='images/parts/'.$image->image;
                            } else {
                            $image->image = 'images/sample_part.png';
                            }
                            } else {
                            $image->image ='images/sample_part.png';
                            }
                            @endphp
                            <div class="carousel-item {{ $key === 0 ? 'active' : '' }}  tyler-clemmen-div">
                                <img src="{{ asset($image->image) }}" alt="">
                            </div>
                            @endforeach
                        </div>

                        <!-- Left and right controls/icons -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#demo{{$partsDetail->id}}"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#demo{{$partsDetail->id}}"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>

                        <div class="carousel-indicators indicator-slide-positions">
                            @foreach($partImages as $key => $image)
                            <button type="button" data-bs-target="#demo{{$partsDetail->id}}"
                                data-bs-slide-to="{{ $key }}"
                                class="{{ $key === 0 ? 'active' : '' }} indicator-color custom-active w-100"></button>
                            @endforeach
                        </div>
                    </div>
                    @if($partsDetail->price_off > 0)
                    <div class="verticals-details-div">Save
                        {{ number_format(str_replace(',', '.', $partsDetail->price_off), 0) }}%
                    </div>
                    @endif
                    <div class="col-lg-12 mt-4 mb-4">
                        <h5 class="browse-video">Browse Our Videos</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 pt-4">
                <h1 class="ford-heading">
                    {{ \Carbon\Carbon::parse($partsDetail->manufacturer)->format('Y') .' '.strtoupper($partsDetail->make->make).' '.strtoupper($partsDetail->model->model_name).' '.strtoupper($partsDetail->version)}}
                </h1>
                <h5 class="dba-16cbz">
                    {{strtoupper($partsDetail->model->model_code)}}<span>{{strtoupper($partsDetail->ref_no)}}</span>
                </h5>
                <div class="d-flex main-price" style="width: 50%; justify-content: flex-start;">
                    <p id="main-price">{{ number_format($partsDetail->price ) }} </p>
                    <span>{{strtoupper($partsDetail->currency->currency)}}</span>
                </div>
                <div class="w-100 border-1 price-div mb-3">
                    <div class="price-on-off w-100 mb-2">
                        <h6>Original Price:<span>{{ number_format($partsDetail->price ) }}
                                {{strtoupper($partsDetail->currency->currency)}}</span></h6>
                    </div>
                    <div class="w-100 price-off">
                        <h6>@if($partsDetail->price_off != null)
                            {{ number_format(str_replace(',', '.', $partsDetail->price_off), 0) }}%
                            @else
                            0%
                            @endif</h6>
                    </div>
                    <div class="w-100  price-on-off mb-2">
                        <h6>Price After Off:<span id="off-price"> @php
                                if($partsDetail->price_off != null){
                                $offPrice = ($partsDetail->price * $partsDetail->price_off)/100;
                                $actualPrice = $partsDetail->price - $offPrice;
                                }else{
                                $actualPrice = $partsDetail->price;
                                }
                                @endphp
                                {{ number_format($actualPrice)}}
                                {{strtoupper($partsDetail->currency->currency)}}</span></h6>
                    </div>
                    <div class="w-100 d-flex">
                        <div class="total-price">
                            <h6>Total<span class="t-price">@php
                                    if($partsDetail->price_off != null){
                                    $offPrice = ($partsDetail->price * $partsDetail->price_off)/100;
                                    $actualPrice = $partsDetail->price - $offPrice;
                                    }else{
                                    $actualPrice = $partsDetail->price;
                                    }
                                    @endphp
                                    {{ number_format($actualPrice )}}
                                </span><span>{{strtoupper($partsDetail->currency->currency)}}</span></h6>

                            <p class="price-custom">C&F to
                                {{ucfirst($shipment->portname)}}@if ($shipment->roro == 1 && $shipment->portcontainer ==
                                1)
                                (RORO And Container)
                                @elseif ($shipment->roro == 1)
                                (RORO)
                                @elseif ($shipment->portcontainer == 1)
                                (Container)
                                @endif</p>
                        </div>
                        <div class="inquire-car text-center d-flex align-items-center">
                            <div class="text-center p-2"><img
                                    src="{{ asset('user_assets/img/details/stars.png') }}"><span>{{$inquireCount}}
                                    People are
                                    inquiring the car.</span>
                            </div>
                        </div>
                    </div>
                    <div class="w-100 blue-btn-div mt-3 p-2">
                        <a class="btn blue-btn" data-bs-toggle="modal" data-bs-target="#formModel"
                            onclick="partId({{ $partsDetail->id }})">Get A Price Quote
                            Now</a>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class=" row text-center">
                        <div class="col-lg-6 col-md-6 d-flex mb-2 padding-left-right">
                            <div class="mileage-detail">
                                <img src="{{ asset('user_assets/img/details/mileage.png') }}">
                                <h6>Mileage</h6>
                                <h5>{{substr(ucfirst($partsDetail->mileage),0,6)}}</h5>
                            </div>
                            <div class="mileage-detail">
                                <img src="{{ asset('user_assets/img/details/year.png') }}">
                                <h6>Year</h6>
                                <h5>{{ \Carbon\Carbon::parse($partsDetail->manufacturer)->format('Y/m') }}</h5>
                            </div>
                            <div class="mileage-detail">
                                <img src="{{ asset('user_assets/img/details/engine.png') }}">
                                <h6>Engine</h6>
                                <h5>{{substr(strtoupper($partsDetail->engine_size),0,6)}}</h5>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 d-flex mb-2 padding-left-right">
                            <div class="mileage-detail">
                                <img src="{{ asset('user_assets/img/details/trans.png') }}">
                                <h6>Trans</h6>
                                <h5>{{substr(strtoupper($partsDetail->transmission),0,2)}}</h5>
                            </div>

                            <div class="mileage-detail">
                                <img src="{{ asset('user_assets/img/details/fuel.png') }}">
                                <h6>Fuel</h6>
                                <h5>{{ucfirst($partsDetail->fuel->fuel_type)}}</h5>
                            </div>
                            <div class="mileage-detail">
                                <img src="{{ asset('user_assets/img/details/location.png') }}">
                                <h6>Location</h6>
                                <h5>{{ucfirst($partsDetail->city->city_name)}}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- stop  -->
        </div>

    </div>
</section>
<!-- ======================= Fort Explore Section End Here-->

<!-- =======================Garage Section start Here-->
<!-- <section id="Garage-Cars" class="pt-0 pb-0">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-4">
                <h5 class="browse-video">Browse Our Videos</h5>
            </div>
            <div class="col-lg-6">
                <div class=" row text-center">
                    <div class="col-lg-6 col-md-6 d-flex mb-2">
                        <div class="mileage-detail me-4">
                            <img src="{{ asset('user_assets/img/details/mileage.png') }}">
                            <h6>Mileage</h6>
                            <h5>{{ucfirst($partsDetail->mileage)}}</h5>
                        </div>
                        <div class="mileage-detail me-4">
                            <img src="{{ asset('user_assets/img/details/year.png') }}">
                            <h6>Year</h6>
                            <h5>2002/1</h5>
                        </div>
                        <div class="mileage-detail me-4">
                            <img src="{{ asset('user_assets/img/details/engine.png') }}">
                            <h6>Engine</h6>
                            <h5>{{strtoupper($partsDetail->engine_code)}}</h5>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 d-flex mb-2">
                        <div class="mileage-detail me-4">
                            <img src="{{ asset('user_assets/img/details/trans.png') }}">
                            <h6>Trans</h6>
                            <h5>AT</h5>
                        </div>
                        <div class="mileage-detail me-4">
                            <img src="{{ asset('user_assets/img/details/location.png') }}">
                            <h6>Location</h6>
                            <h5>{{ucfirst($partsDetail->city->city_name)}}</h5>
                        </div>
                        <div class="mileage-detail me-4">
                            <img src="{{ asset('user_assets/img/details/fuel.png') }}">
                            <h6>Fuel</h6>
                            <h5>{{ucfirst($partsDetail->fuel)}}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> -->
<!-- =======================Garage Section End Here-->

<!-- =======================Spacification Section Start Here-->
<section class="pt-0 pb-0">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="row">
                    @foreach($videoLinks as $videoLink)

                    @if ($loop->first)
                    <div class="col-lg-12">
                        @if (isset($videoLink->videolink))
                        @php
                        parse_str( parse_url( $videoLink->videolink, PHP_URL_QUERY ), $my_array_of_vars );
                        $videoId = isset($my_array_of_vars['v']) ? $my_array_of_vars['v'] :
                        substr($videoLink->videolink, strrpos($videoLink->videolink, '/') + 1);
                        @endphp
                        <iframe width="100%" height="460" src="https://www.youtube.com/embed/{{ $videoId }}"
                            frameborder="0" allowfullscreen></iframe>
                        @else
                        <p>No valid YouTube video URL found</p>
                        @endif
                    </div>
                    @else
                    <div class="col-lg-6">
                        @if (isset($videoLink->videolink))
                        @php
                        parse_str( parse_url( $videoLink->videolink, PHP_URL_QUERY ), $my_array_of_vars );
                        $videoId = isset($my_array_of_vars['v']) ? $my_array_of_vars['v'] :
                        substr($videoLink->videolink, strrpos($videoLink->videolink, '/') + 1);
                        @endphp
                        <iframe width="100%" height="305" src="https://www.youtube.com/embed/{{ $videoId }}"
                            frameborder="0" allowfullscreen></iframe>
                        @else
                        <p>No valid YouTube video URL found</p>
                        @endif

                    </div>
                    @endif

                    @endforeach




                </div>
            </div>
            <div class="col-lg-6">
                <div class="row spc-pr p-2 mb-3">
                    <div class="spc-pr-div w-100">
                        <h6>Specifications</h6>
                    </div>
                    <!-- <div class="row "> -->
                        <div class="col-lg-6" style="border-right: 2px solid #e9e7e7;">
                            <div class="d-flex">
                                <div class="car-detail-h ">
                                    <h6>Ref #</h6>
                                </div>
                                <div class="car-detail-r">
                                    <h5>{{ substr(strtoupper($partsDetail->ref_no),0,19)}}</h5>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="car-detail-h">
                                    <h6>Mileage</h6>
                                </div>
                                <div class="car-detail-r">
                                    <h5>{{ substr(strtoupper($partsDetail->mileage),0,19)}}</h5>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="car-detail-h">
                                    <h6>Chasis #</h6>
                                </div>
                                <div class="car-detail-r">
                                    <h5>{{ substr(strtoupper($partsDetail->chasis),0,19)}}</h5>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="car-detail-h">
                                    <h6>Engine Code</h6>
                                </div>
                                <div class="car-detail-r">
                                    <h5>{{ substr(strtoupper($partsDetail->engine_code),0,19)}}</h5>
                                </div>
                            </div>


                            <div class=" d-flex ">
                                <div class="car-detail-h">
                                    <h6>Model Code</h6>
                                </div>
                                <div class="car-detail-r">
                                    <h5>{{ substr(strtoupper($partsDetail->model->model_code),0,19)}}</h5>
                                </div>
                            </div>
                            <div class="d-flex ">
                                <div class="car-detail-h">
                                    <h6>Steering</h6>
                                </div>
                                <div class="car-detail-r">
                                    <h5>{{ substr(ucfirst($partsDetail->steering),0,19)}}</h5>
                                </div>
                            </div>


                            <div class="d-flex">
                                <div class="car-detail-h">
                                    <h6>Engine Size</h6>
                                </div>
                                <div class="car-detail-r">
                                    <h5>{{ substr(strtoupper($partsDetail->engine_size),0,19)}}</h5>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="car-detail-h">
                                    <h6>Ext Color</h6>
                                </div>
                                <div class="car-detail-r">
                                    <h5>{{ substr(ucfirst($partsDetail->color),0,19)}}</h5>
                                </div>
                            </div>



                            <div class="d-flex">
                                <div class="car-detail-h">
                                    <h6>Location</h6>
                                </div>
                                <div class="car-detail-r">
                                    <h5>{{ substr(ucfirst($partsDetail->city->city_name),0,19)}}</h5>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="car-detail-h">
                                    <h6>Fuel</h6>
                                </div>
                                <div class="car-detail-r">
                                    <h5>{{ substr(ucfirst($partsDetail->fuel->fuel_type),0,19)}}</h5>
                                </div>
                            </div>


                        </div>
                        <!-- <hr> -->
                        <div class="col-lg-6">
                            <div class="d-flex">
                                <div class="car-detail-h">
                                    <h6>Version/Class</h6>
                                </div>
                                <div class="car-detail-r">
                                    <h5>{{ substr(ucfirst($partsDetail->version),0,19)}}</h5>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="car-detail-h">
                                    <h6>Seats</h6>
                                </div>
                                <div class="car-detail-r">
                                    <h5>{{ substr(ucfirst($partsDetail->seats),0,19)}}</h5>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="car-detail-h">
                                    <h6>Drive</h6>
                                </div>
                                <div class="car-detail-r">
                                    <h5>{{ substr(ucfirst($partsDetail->drivetrain),0,19)}}</h5>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="car-detail-h">
                                    <h6>Doors</h6>
                                </div>
                                <div class="car-detail-r">
                                    <h5>{{ substr(ucfirst($partsDetail->door),0,19)}}</h5>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="car-detail-h">
                                    <h6>Transmission</h6>
                                </div>
                                <div class="car-detail-r">
                                    <h5>{{ substr(ucfirst($partsDetail->transmission),0,19)}}</h5>
                                </div>
                            </div>
                            <div class="d-flex ">
                                <div class="car-detail-h">
                                    <h6>M3</h6>
                                </div>
                                <div class="car-detail-r">
                                    <h5>{{ substr(ucfirst($partsDetail->m3),0,19)}}</h5>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="car-detail-h">
                                    <h6>Registration</h6>
                                </div>
                                <div class="car-detail-r">
                                    <h5> {{ \Carbon\Carbon::parse($partsDetail->reg_no)->format('Y/m') }}</h5>
                                </div>
                            </div>
                            <div class=" d-flex">
                                <div class="car-detail-h">
                                    <h6>Dimensions</h6>
                                </div>
                                <div class="car-detail-r">
                                    <h5>{{ substr(ucfirst($partsDetail->dimension),0,19)}}</h5>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="car-detail-h">
                                    <h6>Manufacture Year / Month</h6>
                                </div>
                                <div class="car-detail-r">
                                    <h5> {{ \Carbon\Carbon::parse($partsDetail->manufacturer)->format('Y/m') }}</h5>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="car-detail-h">
                                    <h6>Weight</h6>
                                </div>
                                <div class="car-detail-r">
                                    <h5>{{ substr(ucfirst($partsDetail->weight),0,19)}}</h5>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="car-detail-h">
                                    <h6>Max Cap</h6>
                                </div>
                                <div class="car-detail-r">
                                    <h5>{{ substr(ucfirst($partsDetail->load_cap),0,19)}}</h5>
                                </div>
                            </div>

                        </div>
                    <!-- </div> -->
                </div>
                <div class="col-lg-12 spc-pr p-2">
                    <div class="spc-pr-div w-100">
                        <h6>Features</h6>
                    </div>
                    <div class="diplay-flex-r px-2 features-btn-main">
                        @foreach($features as $feature)
                        <div
                            class="features-btn d-flex {{ $partfeatures->where('part_id', $partsDetail->id)->contains('feature_id', $feature->id) ? 'active-style' : '' }}">
                            <h6 class="">{{ $feature->feature }}</h6>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ======================= Spacification Section End Here-->

<!-- =======================Sippment Section Start Here-->
<section class="pt-3 pb-0">
    <div class="container">
        <div class="row sippment-main-div">
            <form>
                <h1 class="d-flex shipment-detail-heading mt-3">
                    <img src="{{ asset('user_assets/img/icons/Globe.png') }}" />
                    <span class="mt-1 mx-1">SHIPPING DESTINATION</span>
                </h1>
                <div class="mb-4 mt-3">
                    <label for="country" class="mb-2 contact-label">Country<span class="star_vt">*</span></label>
                    <select class="form-control" id="parts-country" name="country"
                        onchange="getShipmentDetails(this.value)">
                        @foreach($countries as $key => $country)
                        <option value='{{$country->id}}'  {{ $shipment->country_id == $country->id ? 'selected' : '' }}>{{$country->country_name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="fullname" class="mb-2 contact-label">Shipping Method<span
                            class="star_vt">*</span></label>
                    <div class="d-flex">
                        <input type="checkbox" id="roro" name="roro" value="roro"
                            {{ $shipment->roro == 1 ? 'checked' : '' }}>
                          <label for="roro" class="custom-checkbox">RORO</label>
                          <input type="checkbox" id="container" name="container" value="container"
                            {{ $shipment->portcontainer == 1 ? 'checked' : '' }}>
                          <label for="container">Container</label>
                    </div>
                </div>
                <h5 class="callo-port ">From<span id="cityPortName"> {{$shipment->portname}}</span> Port To</h5>
                <!--  start foreach -->
                <div id="port-ship">
                    <div class="px-3 d-flex w-100  mt-3 portContainer" id="portContainer">
                        <div class="d-flex custom-port flex-wrap " id="portName"
                            style="width: 50%; justify-content: flex-start;">
                            <input type="radio" id="portname" name="portname" value="portid" checked><label
                                for="portname">{{$shipment->portname}}</label>
                            <span>
                                @if ($shipment->roro == 1 && $shipment->portcontainer == 1)
                                Pick Up At Port (RORO And Container)
                                @elseif ($shipment->roro == 1)
                                Pick Up At Port (RORO)
                                @elseif ($shipment->portcontainer == 1)
                                Pick Up At Port (Container)
                                @endif
                            </span>
                        </div>
                        <div style="width: 50%; text-align: right;">
                            <a href="#" class="port-currency">{{ number_format($shipment->price) }}
                                {{strtoupper($partsDetail->currency->currency)}}</a>
                        </div>
                    </div>
                </div>
                <!-- endforeach  -->
                <!-- <div class="px-3 d-flex w-100 pb-2  mt-3">
                    <div class="d-flex custom-port" id="portName" style="width: 50%; justify-content: flex-start;">
                        <input type="radio" id="portname" name="portname" value="portid"><label
                            for="html">MATARNI</label><span>Pick Up At Port (Container)</span>
                    </div>
                    <div style="width: 50%; text-align: right;">
                        <a href="#" class="port-currency">29LAC PKR</a>
                    </div>
                </div> -->
                <h5 class="mt-3">Additional Options</h5>
                <div class="d-flex"> <input type="checkbox" name="insurance" id="insurance" value="insurance"
                        class="mx-2" {{ $shipment->insurance == 1 ? 'checked' : '' }}>
                    <span class="d-flex mt-3">Marine Insurance<p>(Not Available)</p></span>
                    <input type="checkbox" name="warranty" id="warranty" value="warranty" class="mx-2"
                        {{ $shipment->warranty == 1 ? 'checked' : '' }}> <span class="mt-3">BF Warranty</p>
                    </span>
                </div>
                <h5>Port/City</h5>
                <div class="pickport p-name" id="portname">{{$shipment->portname}}<span> @if ($shipment->roro == 1 &&
                        $shipment->portcontainer == 1)
                        Pick Up At Port (RORO And Container)
                        @elseif ($shipment->roro == 1)
                        Pick Up At Port (RORO)
                        @elseif ($shipment->portcontainer == 1)
                        Pick Up At Port (Container)
                        @endif</span></div>
                <hr>
                <div class="px-3 d-flex w-100 pb-3 mt-3">
                    <div class="d-flex total-price-last" style="width: 50%; justify-content: flex-start;">
                        <h6 class="text-dark">Total Price</h6>
                    </div>
                    <div style="width: 50%; text-align: right;" class="currency-port-div">
                        <a href="#"
                            class="currency-port">{{($shipment->price + $shipment->warranty_price + $shipment->insurance_price) }}
                        </a><span> {{ strtoupper($partsDetail->currency->currency)}}</span>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<!-- =======================Sippment Section end Here-->
<!-- =======================Similar Vehicles Section end Here-->
<section class="pt-0">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="primary-title text-center">
                    <h5>Similar Vehicles</h5>
                    <p>Explore Similar Products that Match Your Preferences</p>
                </div>
            </div>
        </div>
        <div class="row">
            @forelse($partsInfo->take(4) as $part)

            <div class="col-lg-3 col-md-6 mt-lg-4 mt-2 mb-4">
                <div class="deal-box img-customiz-slider">
                    <div id="demo{{$part->id}}" class="carousel slide slider-img-border carousel-positions w-100"
                        data-bs-ride="carousel">
@php
    $images = App\Http\Models\PartImage::where('part_id', $part->id)->get();
@endphp 
                        <!-- The slideshow/carousel -->
                        <div class="carousel-inner">
                            <!-- @foreach($images as $key => $image)
                            <div class="carousel-item {{ $key === 0 ? 'active' : '' }} w-100">
                                <img src="{{ asset('/images/parts/' . $image->image) }}" alt="{{ $key }}" class="w-100"
                                    style="height:230px">
                            </div>
                            @endforeach -->

                            @foreach($images as $key => $image)
                            @php
                            if($image->image != ''){
                            if(file_exists(public_path('/images/parts/' . $image->image))){
                            $image->image = '/images/parts/' . $image->image;
                            }else{
                            $image->image = 'images/sample_part.png';
                            }
                            }else{
                            $image->image = 'images/sample_part.png';
                            }
                            @endphp
                            <div class="carousel-item {{ $key === 0 ? 'active' : '' }} w-100">
                                <img src="{{ asset($image->image) }}" alt="{{ $key }}" class="w-100"
                                    style="height:230px">
                            </div>
                            @endforeach
                        </div>

                        <!-- Left and right controls/icons -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#demo{{$part->id}}"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#demo{{$part->id}}"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>

                        <div class="carousel-indicators indicator-positions">
                            @foreach($images as $key => $image)
                            <button type="button" data-bs-target="#demo{{$part->id}}" data-bs-slide-to="{{ $key }}"
                                class="{{ $key === 0 ? 'active' : '' }} indicator-color custom-active w-100"></button>
                            @endforeach
                        </div>
                    </div>
                    @if($part->price_off > 0)
                    <div class="verticals-div">Save {{ number_format(str_replace(',', '.', $part->price_off), 0) }}%
                    </div>
                    @endif
                    <!-- <div class="vertical-div">Save 20%</div> -->
                    <h6 class="text-center custom-slider-title mt-2"><a
                            href="{{ route('product.details',['id' => $part->id]) }}">
                            {{ \Carbon\Carbon::parse($part->reg_no)->format('Y').' '.substr(strtoupper($part->make->make),0,7).' '.substr(strtoupper($part->model->model_name),0,3).' '.substr(strtoupper($part->version),0,3) }}
                            </span></a></h6>
                    <div class="px-3 d-flex w-100">
                        <div class="d-flex" style="width: 50%; justify-content: flex-start;">
                            <img src="{{ asset('user_assets/img/home-slider/location-icon.png') }}"
                                class="location-icon">
                            <span class="custom-country">{{ucfirst($part->country->country_name)}}</span>
                        </div>
                        @if(in_array($part->id, $favoriteId))
                        <div style="width: 50%; text-align: right;" class="favorite-container"
                            data-part-id="{{ $part->id }}">
                            <span class="favorite-link" style="cursor: pointer;">
                                <img src="{{ asset('user_assets/img/home-slider/filled-Heart.png') }}"
                                    class="filled-heart-icon">
                            </span>
                        </div>
                        @else
                        <div style="width: 50%; text-align: right;" class="favorite-container"
                            data-part-id="{{ $part->id }}">
                            <span class="favorite-link" style="cursor: pointer;">
                                <img src="{{ asset('user_assets/img/home-slider/Heart.png') }}" class="heart-icon">
                            </span>
                        </div>
                        @endif
                    </div>

                    <div class="px-3 py-2 d-flex w-100 mt-2 custom-manul">
                        <div class="d-flex custom-manul-option options-three"
                            style="width: 45%; justify-content: flex-start;">
                            {{ substr(ucfirst($part->transmission),0,6) }}
                        </div>
                        <div class="custom-manul-option options-three" style="width: 35%; text-align: center;">
                            {{ substr(ucfirst($part->fuel->fuel_type),0,6) }}
                        </div>
                        <div style="width: 45%; text-align: right;" class="options-three">
                            {{ substr(strtoupper($part->engine_size),0,6) }}
                        </div>
                    </div>
                    <div class="px-3 d-flex w-100 pb-3 mt-2">
                        <div class="d-flex custom-currency" style="width: 70%; justify-content: flex-start;">
                            {{ number_format($part->price)}}
                            <span>{{strtoupper($part->currency->currency)}}</span>
                        </div>
                        <div style="width: 30%; text-align: right;">
                            <a href="{{route('product.details',['id' => $part->id])}}" class="detail-custom">Details</a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-5">
                <h5>No Record Found</h5>
            </div>
            @endforelse
        </div>
    </div>
</section>
<!-- =======================Similar Vehicles Section End Here-->

<!-- <script>
function getShipmentDetails(countryId) {

    $.ajax({
        url: '/get-shipment-details', // Create a route for this URL
        method: 'POST',
        data: {
            countryId: countryId,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
          response.forEach(function(shipment, index) {
                var portname = shipment.portname;
                var portElements = $('.custom-port label'); // Corrected selector

                if (portElements.length > index) {
                    $(portElements[index]).text(portname); // Use 'portname' variable here
                }
            });
            var portname = response.portname;
            $('#portname-placeholder').text(portname);
            if (response.roro == 1) {
                $('#roro').prop('checked', true);
            } else {
                $('#roro').prop('checked', false);
            }
            if (response.portcontainer == 1) {
                $('#container').prop('checked', true);
            } else {
                $('#container').prop('checked', false);
            }
            if (response.insurance == 1) {
                $('#insurance').prop('checked', true);
            } else {
                $('#insurance').prop('checked', false);
            }
            if (response.warranty == 1) {
                $('#warranty').prop('checked', true);
            } else {
                $('#warranty').prop('checked', false);
            }
        },
        error: function(error) {
            console.log(error);
        }
    });
}
</script> -->

<script>
function getShipmentDetails(countryId, roroChecked, containerChecked) {

    function calculateTotalPrice(basePrice, insurancePrice, warrantyPrice) {
        console.log(basePrice, insurancePrice, warrantyPrice);
        var total = basePrice + insurancePrice + warrantyPrice;
        return total;
    }

    function updateDisplayedPrice(total) {
        var mainPriceText = $('#off-price').text();
        // console.log(mainPriceText);
        var mainPrice = parseFloat(mainPriceText.replace(",", ""));
        // console.log(mainPrice);
        $('.currency-port').text(total);
        var currencytotalText = $('.currency-port').text();
        var currencyPrice = parseFloat(currencytotalText);
        var totalPrice = mainPrice + currencyPrice;

        $('.t-price').text(totalPrice);
    }

    $.ajax({
        url: "{{ url('/get-shipment-details') }}",
        method: 'POST',
        data: {
            countryId: countryId,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            var portContainer = $('#port-ship');
            portContainer.empty();

            response.forEach(function(shipment, index) {
                var portname = shipment.portname;
                var portLabel = $('<label>').attr('for', 'portname_' + index).text(portname);
                var portRadio = $('<input>').attr({
                    type: 'radio',
                    id: 'portname_' + index,
                    name: 'portname',
                    value: shipment.portid,
                    'data-roro': shipment.roro,
                    'data-container': shipment.portcontainer,
                    'data-insurance': shipment.insurance,
                    'data-warranty': shipment.warranty,
                    'data-insurance_price': shipment.insurance_price,
                    'data-warranty_price': shipment.warranty_price,
                    'data-price': shipment.price,
                    'data-shipment-country': shipment.country_id,
                });
                var portContentContainer = $('<span>');

                if (shipment.roro == 1) {
                    var roroContent = $('<span>').text('Pick Up At Port (RORO)');
                    portContentContainer.append(roroContent);
                }

                $('input[name="roro"]').on('change', function() {
                    var roroChecked = $(this).prop('checked');
                    if (roroChecked) {
                        console.log('true');
                        roroContent.show();
                    } else {
                        roroContent.hide();
                        console.log('false');
                    }
                });
                if (shipment.portcontainer == 1) {
                    var containerContent = $('<span>').text('Pick Up At Port (Container)');
                    portContentContainer.append(containerContent);
                }
                $('input[name="container"]').on('change', function() {
                    var containerChecked = $(this).prop('checked');
                    if (containerChecked) {
                        console.log('true');
                        containerContent.show();
                    } else {
                        containerContent.hide();
                        console.log('false');
                    }
                });


                var portDiv = $('<div>')
                    .addClass('px-3 d-flex w-100 mt-3 portContainer')
                    .append(
                        $('<div>')
                        .addClass('custom-port')
                        .css('width', '50%')
                        .css('justify-content', 'flex-start')
                        .append(portRadio)
                        .append(portLabel)
                        .append(portContentContainer)
                    )
                    .append(
                        $('<div>')
                        .css('width', '50%')
                        .css('text-align', 'right')
                        .append($('<a>').addClass('port-currency').text(shipment.price))
                    );

                portContainer.append(portDiv);

                portRadio.on('click', function() {
                    localStorage.setItem("portName", portname);
                    $('.p-name').html(
                        `${portname}<span> ${portContentContainer.text()}</span> `);
                    $('.price-custom').html(` C&F ${portname} ${portContentContainer.text()}`);
                    $('#cityPortName').html(` ${portname}`);
                    var selectedPortId = $(this).val();
                    var insurance = $(this).data('insurance');
                    var warranty = $(this).data('warranty');
                    var roro = $(this).data('roro');
                    var container = $(this).data('container');

                    if (insurance === 1) {
                        $('#insurance').prop('checked', true);
                    } else {
                        $('#insurance').prop('checked', false);
                    }

                    if (warranty === 1) {
                        $('#warranty').prop('checked', true);
                    } else {
                        $('#warranty').prop('checked', false);
                    }

                    if (roro === 1) {
                        $('#roro').prop('checked', true);
                    } else {
                        $('#roro').prop('checked', false);
                    }
                    if (container === 1) {
                        $('#container').prop('checked', true);
                    } else {
                        $('#container').prop('checked', false);
                    }


                    var insurancePrice = parseFloat($(this).data('insurance_price'));
                    var warrantyPrice = parseFloat($(this).data('warranty_price'));
                    var basePrice = parseFloat($(this).data('price'));
                    var total = calculateTotalPrice(basePrice, insurancePrice,
                        warrantyPrice);
                    updateDisplayedPrice(total);

                    $('input[name="insurance"]').on('change', function() {
                        var insuranceChecked = $(this).prop('checked');
                        if (insuranceChecked) {
                            basePrice += insurancePrice;
                        } else {
                            basePrice -= insurancePrice;
                        }
                        var total = calculateTotalPrice(basePrice, insurancePrice,
                            warrantyPrice);
                        updateDisplayedPrice(total);
                    });

                    $('input[name="warranty"]').on('change', function() {
                        var warrantyeChecked = $(this).prop('checked');
                        if (warrantyeChecked) {
                            basePrice += warrantyPrice;
                        } else {
                            basePrice -= warrantyPrice;
                        }
                        var total = calculateTotalPrice(basePrice, insurancePrice,
                            warrantyPrice);
                        updateDisplayedPrice(total);
                    });

                });
            });


        },
        error: function(error) {
            console.log(error);
        }
    });
}
</script>
@endsection