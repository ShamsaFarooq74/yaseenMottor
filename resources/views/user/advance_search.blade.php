@extends('layouts.user.block.app')

@section('content')
<style>
.highlighted {
    background: rgb(194, 187, 187) !important;
}

.align-items-center {
    align-items: baseline !important;
}
</style>
<!-- ======================= HeroSection Start Here-->
@php $active_tab = isset($requested_data['active_tab'])?$requested_data['active_tab']:'newArrival'; @endphp

<section id="hero" class="d-flex align-items-center p-5">
    <div class="container mx-auto text-lg-start">
        <div class="row searchMformx mt-2 justify-content-center">
            <div class="col-lg-12 mt-5">
                <div class="text-center mx-auto custom-title"><span class="d-none d-lg-block">
                        <h1>Find Used Cars</h1>
                    </span>
                </div>
                <div class="slider-p text-center mx-auto custom-subtitle mb-3">At Best
                    Prices</div>
            </div>
            <div class="col-lg-8">
                <form id="contactForm" method="post" action="{{route('advance.search')}}">
                    @csrf
                    <div class="row">
                        <!-- Name input -->
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                            <input type="hidden" name="active_tab" id="active_tab">
                            <label class="form-label custom-label float-start" for="make_id">Make</label>
                            <select class="custom-select {{$requested_data['make_id'] != null ? 'highlighted':''}}"
                                id="make_id" name="make_id">
                                <option value="" selected>Select Make</option>
                                @foreach($makes as $mak)
                                <option value='{{$mak->id}}' {{$requested_data['make_id'] == $mak->id ? 'selected':''}}>
                                    {{ucwords($mak->make)}}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Email input -->
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                            <!-- Added col-lg-6 here -->
                            <label class="form-label custom-label" for="model_id">Model</label>
                            <select class="custom-select {{$requested_data['model_id'] != null ? 'highlighted':''}}"
                                id="model_id" name="model_id">
                                <option value="" selected>Select Model</option>
                                @foreach($models as $key => $model)
                                <option value='{{$model->id}}'
                                    {{$requested_data['model_id'] == $model->id ? 'selected':''}}>
                                    {{ucwords($model->model_name)}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                            <!-- Added col-lg-6 here -->
                            <label class="form-label custom-label" for="fuel_types">Fuel</label>
                            <select class="custom-select {{$requested_data['fuel_types'] != '' ? 'highlighted':''}}"
                                id="fuel_types" name="fuel_types">
                                <option value="" selected>Select Fuel</option>
                                @foreach($fuel_types as $type)
                                <option value="{{$type->id}}"
                                    {{ $requested_data['fuel_types'] == $type->id ? 'selected':''}}>
                                    {{ucwords($type->fuel_type)}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <!-- Added col-lg-6 here -->
                             <?php                    
                            $currencyType = DB::table('currency')->first()->currency;
                        ?>
                            <label class="form-label custom-label" for="price">Price ({{$currencyType}})</label>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                                    <select class="custom-select {{$minPrice != null ? 'highlighted':''}}"
                                        id="min_price" name="min_price">
                                        <option value="" selected>Min</option>
                                        @foreach($priceUnits as $units)
                                        <option value="{{$units}}" {{ $minPrice == $units ? 'selected':''}}>
                                            {{number_format($units)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                                    <select class="custom-select {{$maxPrice != null ? 'highlighted':''}}"
                                        id="max_price" name="max_price">
                                        <option value="" selected>Max</option>
                                        @foreach($priceUnits as $units)
                                        <option value="{{$units}}" {{ $maxPrice == $units ? 'selected':''}}>
                                            {{number_format($units)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- Email input -->
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                            <!-- Added col-lg-6 here -->
                            <label class="form-label custom-label" for="body_type">Body Type</label>
                            <select class="custom-select {{$requested_data['body_type_id'] != '' ? 'highlighted':''}}"
                                id="body_type_id" name="body_type_id">
                                <option value="" selected>Select Type</option>
                                @foreach($body_types as $type)
                                <option value="{{$type->id}}"
                                    {{ $requested_data['body_type_id'] == $type->id ? 'selected':''}}>
                                    {{ucwords($type->body_name)}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                            <!-- Added col-lg-6 here -->
                            <label class="form-label custom-label" for="steering">Steering</label>
                            <select class="custom-select {{$requested_data['steering'] != '' ? 'highlighted':''}}"
                                id="steering" name="steering">
                                <option value="" selected>Select Steering</option>
                                <option value="left" {{$requested_data['steering']=='left' ? 'selected' : ''}}>Left
                                </option>
                                <option value="right" {{$requested_data['steering']=='right' ? 'selected' : ''}}>Right
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                            <!-- Added col-lg-6 here -->
                            <label class="form-label custom-label" for="transmission">Transmission</label>
                            <select class="custom-select  {{$requested_data['transmission'] != '' ? 'highlighted':''}}"
                                id="transmission" name="transmission">
                                <option value="" selected>Select Transmission</option>
                                <option value="automatic"
                                    {{$requested_data['transmission']=='automatic' ? 'selected' : ''}}>Automatic
                                </option>
                                <option value="manual" {{$requested_data['transmission']=='manual' ? 'selected' : ''}}>
                                    Manual</option>
                            </select>
                        </div>
                        <!-- Name input -->
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <!-- Added col-lg-6 here -->
                            <label class="form-label custom-label" for="mileage">Mileage</label>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                                    <select
                                        class="custom-select {{$requested_data['min_mileage'] != '' ? 'highlighted':''}}"
                                        id="min_mileage" name="min_mileage">
                                        <option value="" selected>Min</option>
                                        @php $mileageArray =
                                        ['50000','80000','100000','150000','200000','250000','300000','350000','400000','450000','500000'];
                                        @endphp

                                        @foreach($mileageArray as $mileage)
                                        <option value="{{$mileage}}"
                                            {{$requested_data['min_mileage'] == $mileage ? 'selected' : ''}}>
                                            {{$mileage}} km</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                                    <select
                                        class="custom-select {{$requested_data['max_mileage'] != '' ? 'highlighted':''}}"
                                        id="max_mileage" name="max_mileage">
                                        <option value="" selected>Max</option>
                                        @php $mileageArray =
                                        ['50000','80000','100000','150000','200000','250000','300000','350000','400000','450000','500000'];
                                        @endphp

                                        @foreach($mileageArray as $mileage)
                                        <option value="{{$mileage}}"
                                            {{$requested_data['max_mileage'] == $mileage ? 'selected' : ''}}>
                                            {{$mileage}} km</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 ">
                            <label class="form-label custom-label" for="year">Year</label>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                                    <select
                                        class=" custom-select {{$requested_data['from_year'] != '' ? 'highlighted':''}}"
                                        id="from_year">
                                        <option value='' selected>From</option>
                                        @foreach($years as $year)
                                        <option value="{{$year}}"
                                            {{$requested_data['from_year'] == $year ? 'selected':''}}>{{$year}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                                    <select
                                        class="custom-select {{$requested_data['to_year'] != '' ? 'highlighted':''}}"
                                        id="to_year">
                                        <option value='' selected>To</option>
                                        @foreach($years as $year)
                                        <option value="{{$year}}"
                                            {{$requested_data['to_year'] == $year ? 'selected':''}}>{{$year}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Name input -->
                        <div class="col-lg-4 col-md-4 col-sm-12 ">
                            <!-- Added col-lg-6 here -->
                            <label class="form-label custom-label" for="engine">Engine CC</label>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                                    <select
                                        class=" custom-select {{$requested_data['min_engine'] != '' ? 'highlighted':''}}"
                                        id="min_engine" name="min_engine">
                                        <option value="" selected>Min</option>
                                        <option value="700" {{$requested_data['min_engine'] == '700' ? 'selected':''}}>
                                            700cc</option>
                                        <option value="1000"
                                            {{$requested_data['min_engine'] == '1000' ? 'selected':''}}>1000cc</option>
                                        <option value="1500"
                                            {{$requested_data['min_engine'] == '1500' ? 'selected':''}}>1500cc</option>
                                        <option value="1800"
                                            {{$requested_data['min_engine'] == '1800' ? 'selected':''}}>1800cc</option>
                                        <option value="2000"
                                            {{$requested_data['min_engine'] == '2000' ? 'selected':''}}>2000cc</option>
                                        <option value="2500"
                                            {{$requested_data['min_engine'] == '2500' ? 'selected':''}}>2500cc</option>
                                        <option value="3000"
                                            {{$requested_data['min_engine'] == '3000' ? 'selected':''}}>3000cc</option>
                                        <option value="4000"
                                            {{$requested_data['min_engine'] == '4000' ? 'selected':''}}>4000cc</option>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                                    <select
                                        class="custom-select {{$requested_data['max_engine'] != '' ? 'highlighted':''}}"
                                        id="max_engine" name="max_engine">
                                        <option value="" selected>Max</option>
                                        <option value="700" {{$requested_data['max_engine'] == '700' ? 'selected':''}}>
                                            700cc</option>
                                        <option value="1000"
                                            {{$requested_data['max_engine'] == '1000' ? 'selected':''}}>1000cc</option>
                                        <option value="1500"
                                            {{$requested_data['max_engine'] == '1500' ? 'selected':''}}>1500cc</option>
                                        <option value="1800"
                                            {{$requested_data['max_engine'] == '1800' ? 'selected':''}}>1800cc</option>
                                        <option value="2000"
                                            {{$requested_data['max_engine'] == '2000' ? 'selected':''}}>2000cc</option>
                                        <option value="2500"
                                            {{$requested_data['max_engine'] == '2500' ? 'selected':''}}>2500cc</option>
                                        <option value="3000"
                                            {{$requested_data['max_engine'] == '3000' ? 'selected':''}}>3000cc</option>
                                        <option value="4000"
                                            {{$requested_data['max_engine'] == '4000' ? 'selected':''}}>4000cc</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-6 col-sm-12 mb-3">
                            <div class="d-grid mt-4 ">

                                <a class="btn btn-more-options" data-bs-toggle="collapse" href="#collapseExample"
                                    role="button" aria-expanded="false" aria-controls="collapseExample">Show More
                                    Options <img src="{{ asset('user_assets/img/icons/arrowicon.png') }}" /></a>
                            </div>
                        </div>

                        <div class="collapse col-lg-12 col-md-12 col-sm-12 mb-3" id="collapseExample">
                            <div class="row">
                                <!-- Name input -->
                                <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                                    <label class="form-label custom-label float-start"
                                        for="drivetrain">Drivetrain</label>
                                    <select
                                        class="custom-select {{$requested_data['drivetrain'] != '' ? 'highlighted':''}}"
                                        id="drivetrain" name="drivetrain">
                                        <option value>Select Drivetrain</option>
                                        <option value="2WD" {{$requested_data['drivetrain'] == '2WD' ? 'selected':''}}>
                                            2WD</option>
                                        <option value="4WD" {{$requested_data['drivetrain'] == '4WD' ? 'selected':''}}>
                                            4WD</option>
                                        <option value="6WD" {{$requested_data['drivetrain'] == '6WD' ? 'selected':''}}>
                                            6WD</option>
                                    </select>
                                </div>

                                <!-- Email input -->
                                <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                                    <!-- Added col-lg-6 here -->
                                    <label class="form-label custom-label" for="color">Color</label>
                                    <select class="custom-select {{$requested_data['color'] != '' ? 'highlighted':''}}"
                                        id="color" name="color">
                                        <option value="" selected>Select Color</option>
                                        @php $colors =
                                        ['beige','black','blue','bronze','brown','gold','gray','green','maroon','orange','pearl','pink','purple','red','silver','white','yellow'];
                                        @endphp
                                        @foreach($colors as $color)
                                        <option value="{{$color}}"
                                            {{$requested_data['color'] == $color ? 'selected':''}}>{{ucwords($color)}}
                                        </option>
                                        @endforeach
                                        <option value="other">Other</option>
                                    </select>
                                    </select>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                                    <!-- Added col-lg-6 here -->
                                    <label class="form-label custom-label" for="country_id">Stock Country</label>
                                    <select
                                        class="custom-select {{$requested_data['country_id'] != '' ? 'highlighted':''}}"
                                        id="country_id" name="country_id" onchange="getCities()">
                                        <option value>Select Country</option>
                                        @foreach($countries as $country)
                                        <option value="{{$country->id}}"
                                            {{$requested_data['country_id'] == $country->id ? 'selected':''}}>
                                            {{ucwords($country->country_name)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                                    <!-- Added col-lg-6 here -->
                                    <label class="form-label custom-label" for="city_id">Stock Location</label>
                                    <select
                                        class="custom-select {{$requested_data['city_id'] != '' ? 'highlighted':''}}"
                                        id="city_id" name="city_id">
                                        <option value>Select Location</option>
                                    </select>
                                </div>
                                <!-- Name input -->
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <!-- Added col-lg-6 here -->
                                    <label class="form-label custom-label" for="year">Passenger</label>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                                            <select
                                                class="custom-select {{$requested_data['min_pass'] != '' ? 'highlighted':''}}"
                                                name="min_pass" id="min_pass">
                                                <option value selected>Min</option>
                                                <option value="2"
                                                    {{$requested_data['min_pass'] == '2' ? 'selected':''}}>2</option>
                                                <option value="4"
                                                    {{$requested_data['min_pass'] == '4' ? 'selected':''}}>4</option>
                                                <option value="7"
                                                    {{$requested_data['min_pass'] == '7' ? 'selected':''}}>7</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                                            <select
                                                class="custom-select {{$requested_data['max_pass'] != '' ? 'highlighted':''}}"
                                                name="max_pass" id="max_pass">
                                                <option value selected> Max</option>
                                                <option value="2"
                                                    {{$requested_data['max_pass'] == '2' ? 'selected':''}}>2</option>
                                                <option value="4"
                                                    {{$requested_data['max_pass'] == '4' ? 'selected':''}}>4</option>
                                                <option value="7"
                                                    {{$requested_data['max_pass'] == '7' ? 'selected':''}}>7</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <!-- Added col-lg-6 here -->
                                    <label class="form-label custom-label" for="load_cap">Load Cap</label>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                                            <select
                                                class="custom-select {{$requested_data['min_load'] != '' ? 'highlighted':''}}"
                                                id="min_load" name="min_load">
                                                <option value="" selected>Min</option>
                                                <option value="1000"
                                                    {{$requested_data['min_load'] == '1000' ? 'selected':''}}>1.00 ton
                                                </option>
                                                <option value="1250"
                                                    {{$requested_data['min_load'] == '1250' ? 'selected':''}}>1.25 ton
                                                </option>
                                                <option value="1500"
                                                    {{$requested_data['min_load'] == '1500' ? 'selected':''}}>1.50 ton
                                                </option>
                                                <option value="1750"
                                                    {{$requested_data['min_load'] == '1750' ? 'selected':''}}>1.75 ton
                                                </option>
                                                <option value="2000"
                                                    {{$requested_data['min_load'] == '2000' ? 'selected':''}}>2.00 ton
                                                </option>
                                                <option value="2500"
                                                    {{$requested_data['min_load'] == '2500' ? 'selected':''}}>2.50 ton
                                                </option>
                                                <option value="3000"
                                                    {{$requested_data['min_load'] == '3000' ? 'selected':''}}>3.00 ton
                                                </option>
                                                <option value="3500"
                                                    {{$requested_data['min_load'] == '3500' ? 'selected':''}}>3.50 ton
                                                </option>
                                                <option value="4000"
                                                    {{$requested_data['min_load'] == '4000' ? 'selected':''}}>4.00 ton
                                                </option>
                                                <option value="4500"
                                                    {{$requested_data['min_load'] == '4500' ? 'selected':''}}>4.50 ton
                                                </option>
                                                <option value="5000"
                                                    {{$requested_data['min_load'] == '5000' ? 'selected':''}}>5.00 ton
                                                </option>
                                                <option value="6000"
                                                    {{$requested_data['min_load'] == '6000' ? 'selected':''}}>6.00 ton
                                                </option>
                                                <option value="7000"
                                                    {{$requested_data['min_load'] == '7000' ? 'selected':''}}>7.00 ton
                                                </option>
                                                <option value="8000"
                                                    {{$requested_data['min_load'] == '8000' ? 'selected':''}}>8.00 ton
                                                </option>
                                                <option value="9000"
                                                    {{$requested_data['min_load'] == '9000' ? 'selected':''}}>9.00 ton
                                                </option>
                                                <option value="10000"
                                                    {{$requested_data['min_load'] == '10000' ? 'selected':''}}>10.00 ton
                                                </option>
                                            </select>
                                            </select>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                                            <select
                                                class="custom-select {{$requested_data['max_load'] != '' ? 'highlighted':''}}"
                                                id="max_load" name="max_load">
                                                <option value="" selected>Max</option>
                                                <option value="1000"
                                                    {{$requested_data['max_load'] == '1000' ? 'selected':''}}>1.00 ton
                                                </option>
                                                <option value="1250"
                                                    {{$requested_data['max_load'] == '1250' ? 'selected':''}}>1.25 ton
                                                </option>
                                                <option value="1500"
                                                    {{$requested_data['max_load'] == '1500' ? 'selected':''}}>1.50 ton
                                                </option>
                                                <option value="1750"
                                                    {{$requested_data['max_load'] == '1750' ? 'selected':''}}>1.75 ton
                                                </option>
                                                <option value="2000"
                                                    {{$requested_data['max_load'] == '2000' ? 'selected':''}}>2.00 ton
                                                </option>
                                                <option value="2500"
                                                    {{$requested_data['max_load'] == '2500' ? 'selected':''}}>2.50 ton
                                                </option>
                                                <option value="3000"
                                                    {{$requested_data['max_load'] == '3000' ? 'selected':''}}>3.00 ton
                                                </option>
                                                <option value="3500"
                                                    {{$requested_data['max_load'] == '3500' ? 'selected':''}}>3.50 ton
                                                </option>
                                                <option value="4000"
                                                    {{$requested_data['max_load'] == '4000' ? 'selected':''}}>4.00 ton
                                                </option>
                                                <option value="4500"
                                                    {{$requested_data['max_load'] == '4500' ? 'selected':''}}>4.50 ton
                                                </option>
                                                <option value="5000"
                                                    {{$requested_data['max_load'] == '5000' ? 'selected':''}}>5.00 ton
                                                </option>
                                                <option value="6000"
                                                    {{$requested_data['max_load'] == '6000' ? 'selected':''}}>6.00 ton
                                                </option>
                                                <option value="7000"
                                                    {{$requested_data['max_load'] == '7000' ? 'selected':''}}>7.00 ton
                                                </option>
                                                <option value="8000"
                                                    {{$requested_data['max_load'] == '8000' ? 'selected':''}}>8.00 ton
                                                </option>
                                                <option value="9000"
                                                    {{$requested_data['max_load'] == '9000' ? 'selected':''}}>9.00 ton
                                                </option>
                                                <option value="10000"
                                                    {{$requested_data['max_load'] == '10000' ? 'selected':''}}>10.00 ton
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                    <label class="form-label custom-label float-start" for="make">Sub Body Type</label>
                                    <select class="custom-select" id="make">
                                        <option value>Select Make</option>
                                        <option value="make1">Make 1</option>
                                        <option value="make2">Make 2</option>
                                        <!-- Add more options as needed -->
                                    </select>
                                </div>
                            </div> --}}
                            <div class="row justify-content-space-around mt-2">
                                @foreach($featuresArray as $featureData)
                                <div class="col-lg-3 col-md-3 mb-3 d-flex align-items-center">
                                    <input type="checkbox" id="feature_{{ $featureData->id }}"
                                        {{in_array($featureData->id,$requested_data['filterfeatures']) ? 'checked' : ''}}
                                        name="features[]" value="{{ $featureData->id }}">&nbsp;
                                    <label for="feature_{{ $featureData->id }}"
                                        class="text-light">{{ ucwords($featureData->feature) }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!-- Message input -->

                    <!-- Form submit button -->
                    <div class="d-grid">
                        <button class="btn btn-submit-custom btn-lg" type="submit">Search</button>
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-clear-custom btn-lg" id="search-clear" class="search-clear">Clear
                            Search</button>
                    </div>
                </form>
            </div>

        </div>

    </div>
</section>
<!-- ======================= Topbar  HeroSection End Here-->

<!-- ======================= Topbar  carDetail start Here-->

<section id="explore-deal" class="pt-0">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <ul class="nav nav-tab nav-fill mb-3 col-lg-6 mt-5" id="ex1" role="tablist">
                    <li class="custom-tab me-3 mt-2" role="presentation">
                        <a class="nav-link active-tab  py-3 px-5 tab-button {{$active_tab  == 'newArrival'?'active':''}}"
                            id="ex2-tab-1" data-bs-toggle="tab" href="#ex2-tabs-1" role="tab" aria-controls="ex2-tabs-1"
                            aria-selected="true" data-id="newArrival">New
                            Arrival</a>
                    </li>
                    <li class="custom-tab me-3 mt-2" role="presentation">
                        <a class="nav-link py-3 px-5 tab-button {{$active_tab  == 'featured'?'active':''}}"
                            id="ex2-tab-2" data-bs-toggle="tab" href="#ex2-tabs-2" role="tab" aria-controls="ex2-tabs-2"
                            aria-selected="false" data-id="featured">Featured</a>

                    </li>
                </ul>
                <div class="tab-content" id="ex2-content">
                    <div class="tab-pane fade show active" id="ex2-tabs-1" role="tabpanel" aria-labelledby="ex2-tab-1">
                        @forelse($partsData as $data)
                        <div class="row  bottom-border py-5">
                            <div class="col-lg-3 col-md-12 col-sm-12 refrence-stock-div">
                                <a href="{{route('product.details',['id' => $data->id])}}">
                                    <div class="d-flex flex-column w-100 v-main-div">
                                        @php
                                        if ($data->image) {
                                        $imagePath = public_path('images/parts/'.$data->image);
                                        if (File::exists($imagePath)) {
                                        $data->image ='images/parts/'.$data->image;
                                        } else {
                                        $data->image = 'images/sample_part.png';
                                        }
                                        } else {
                                        $data->image ='images/sample_part.png';
                                        }
                                        @endphp
                                        <div id="demo{{$data->id}}"
                                            class="carousel slide sliders-img-border carousel-positions w-100"
                                            data-bs-ride="carousel">
                                            <!-- The slideshow/carousel -->
                                            <div class="carousel-inner">
                                                <!-- Check if it's an array -->
                                                <!-- @foreach($data['images'] ?? [] as $key => $images)
                                                <div class="carousel-item {{ $key === 0 ? 'active' : '' }} w-100">
                                                    <img src="{{ asset('/images/parts/' . $images->image) }}"
                                                        alt="{{ $key }}" class="w-100" style="height:210px">
                                                </div>
                                                @endforeach -->
                                                @foreach($data['images'] ?? [] as $key => $image)
                                                @if(file_exists(public_path('images/parts/' . $image->image)))
                                                <div class="carousel-item {{ $key === 0 ? 'active' : '' }} w-100">
                                                    <img src="{{ asset('/images/parts/' . $image->image) }}"
                                                        alt="{{ $key }}" class="w-100" style="height:210px">
                                                </div>
                                                @else
                                                <!-- Show a default/static image when the image file doesn't exist in public directory -->
                                                <div class="carousel-item {{ $key === 0 ? 'active' : '' }} w-100">
                                                    <img src="{{ asset('images/sample_part.png') }}" alt="Default Image"
                                                        class="w-100" style="height:210px">
                                                </div>
                                                <!-- You may choose to break the loop here if you want to show only one default image -->
                                                @endif
                                                @endforeach

                                            </div>

                                            <!-- Left and right controls/icons -->
                                            <button class="carousel-control-prev" type="button"
                                                data-bs-target="#demo{{$data->id}}" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon"></span>
                                            </button>
                                            <button class="carousel-control-next" type="button"
                                                data-bs-target="#demo{{$data->id}}" data-bs-slide="next">
                                                <span class="carousel-control-next-icon"></span>
                                            </button>

                                            <div class="carousel-indicators indicators-positions">
                                                @foreach($data['images']?? [] as $key => $images)
                                                <button type="button" data-bs-target="#demo{{$data->id}}"
                                                    data-bs-slide-to="{{ $key }}"
                                                    class="{{ $key === 0 ? 'active' : '' }} indicator-color custom-active w-100"></button>
                                                @endforeach
                                            </div>

                                        </div>
                                        @if($data->price_off > 0)
                                        <div class="verticals-div">Save
                                            {{ number_format(str_replace(',', '.', $data->price_off), 0) }}%
                                        </div>
                                        @endif
                                        <div class="mb-4 mt-3 refrence-stock-heading p-2">
                                            <h5>Reference #<span>{{strtoupper($data->ref_no)}}</span></h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <a href="{{route('product.details',['id' => $data->id])}}">
                                    <h1 class="stock-heading">
                                        <!-- {{date('Y',strtotime($data->manufacturer)).' '.strtoupper($data->model)}} -->
                                        {{ \Carbon\Carbon::parse($data->manufacturer)->format('Y') .' '.strtoupper($data->make).' '.strtoupper($data->model).' '.strtoupper($data->version)}}
                                    </h1>
                                    <div class="row text-center mt-2">
                                        <div class="w-100 d-flex mb-2">
                                            <div class="mileage-detail border-right">
                                                <img src="{{ asset('user_assets/img/details/mileage.png') }}">
                                                <h6>Mileage</h6>
                                                <h5>{{substr(ucfirst($data->mileage),0,6)}} KM</h5>
                                            </div>
                                            <div class="mileage-detail border-right">
                                                <img src="{{ asset('user_assets/img/details/year.png') }}">
                                                <h6>Year</h6>
                                                <h5>{{ \Carbon\Carbon::parse($data->manufacturer)->format('Y/m') }}</h5>
                                            </div>
                                            <div class="mileage-detail border-right">
                                                <img src="{{ asset('user_assets/img/details/engine.png') }}">
                                                <h6>Engine</h6>
                                                <h5>{{substr(strtoupper($data->engine_size),0,6)}}cc</h5>
                                            </div>
                                            <div class="mileage-detail border-right">
                                                <img src="{{ asset('user_assets/img/details/trans.png') }}">
                                                <h6>Trans</h6>
                                                <h5>
                                                    @if($data->transmission == 'automatic')
                                                    AT
                                                    @elseif($data->transmission == 'manual')
                                                    MN
                                                    @endif
                                                </h5>
                                            </div>
                                            <div class="mileage-detail me-4">
                                                <img src="{{ asset('user_assets/img/details/location.png') }}">
                                                <h6>Location</h6>
                                                <h5>{{ucwords($data->country_name)}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 spc-pr p-2">
                                        <div class="diplay-flex-r px-2">
                                            <div class="product-detail  d-flex">
                                                <h6 class="mx-1">Model Code</h6>
                                                <span class="mx-1">{{$data->model_code}}</span>
                                            </div>
                                            <div class="product-detail  d-flex">
                                                <h6 class="mx-1">Steering </h6>
                                                <span class="mx-1">{{ucwords($data->steering)}}</span>
                                            </div>
                                            <div class="product-detail  d-flex">
                                                <h6 class="mx-1">Fuel Type</h6>
                                                <span class="mx-1">{{ucwords($data->fuel_type)}}</span>
                                            </div>
                                            <div class="product-detail  d-flex">
                                                <h6 class="mx-1">Seats</h6>
                                                <span class="mx-1">{{ucwords($data->seats)}}</span>
                                            </div>
                                            <div class="product-detail  d-flex">
                                                <h6 class="mx-1">Engine Code</h6>
                                                <span class="mx-1">{{strtoupper($data->engine_code)}}</span>
                                            </div>
                                            <div class="product-detail  d-flex">
                                                <h6 class="mx-1">Color</h6>
                                                <span class="mx-1">{{ucwords($data->color)}}</span>
                                            </div>
                                            <div class="product-detail  d-flex">
                                                <h6 class="mx-1">Drivetrain</h6>
                                                <span class="mx-1">{{strtoupper($data->drivetrain)}}</span>
                                            </div>
                                            <div class="product-detail  d-flex">
                                                <h6 class="mx-1">Doors</h6>
                                                <span class="mx-1">{{$data->door}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-lg-12 d-flex sunroof-details">
                                            <h5>
                                                @php $i=0; @endphp
                                                @foreach($data['features'] as $features)
                                                @if($i < 5) {{$features['features']['feature']}} <span>/ </span>
                                                    @php $i++; @endphp
                                                    @endif
                                                    @endforeach
                                            </h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-12 col-sm-12 price-div-stock pt-4 div-overlay text-decoration">
                                <a href="{{route('product.details',['id' => $data->id])}}">
                                    <div class="w-100 border-1 mb-3">
                                        <div class="price-stock w-100 d-flex">
                                            <h6>Price Before:</h6>
                                            <span>{{ number_format($data->price) }}
                                                {{strtoupper($data->currency)}}</span>
                                        </div>
                                        <div class="w-100 price-stock-off">
                                            OFF @if($data->price_off != null)
                                            {{ number_format(str_replace(',', '.', $data->price_off), 0) }}%
                                            @else
                                            0%
                                            @endif
                                        </div>
                                        <div class="price-stock w-100 d-flex">
                                            <h6>Price After:</h6>
                                            <span>
                                                @php
                                                if($data->price_off != null){
                                                $offPrice = ($data->price * $data->price_off)/100;
                                                $actualPrice = $data->price - $offPrice;
                                                }else{
                                                $actualPrice = $data->price;
                                                }
                                                @endphp
                                                {{ number_format($actualPrice )}}
                                                {{strtoupper($data->currency)}}
                                            </span>
                                        </div>
                                        <hr>
                                        <div class="price-stock-p w-100 d-flex">
                                            <div class="left-content">
                                                <h6>Total Price:</h6>
                                            </div>
                                            <div class="right-content">
                                                <span>{{ number_format($actualPrice ) }}
                                                    {{strtoupper($data->currency)}}</span>
                                                <p class="right-content-p">C&F To <span class="port-div"></span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="w-100 blue-btn-div mt-3 p-2 rounded-2">
                                            <a class="btn blue-btn" data-bs-toggle="modal" data-bs-target="#formModel"
                                                onclick="partId({{ $data->id }})">Inquire</a>

                                        </div>
                                        <!-- Overlay starts here -->

                                        @if($data->is_stock == 0)
                                        <div class="overlay">
                                            <h2>SOLD OUT!</h2>
                                        </div>
                                        @endif
                                        <!-- End of overlay -->
                                    </div>
                                </a>

                            </div>

                        </div>
                        @empty
                        <div class="text-center py-5">
                            <h5>No Record Found</h5>
                        </div>
                        @endforelse
                    </div>
                    <div class="tab-pane fade" id="ex2-tabs-2" role="tabpanel" aria-labelledby="ex2-tab-2">
                        @forelse($featured as $feature)
                        @if(isset($feature->partDetails->id))
                        <div class="row  bottom-border py-5">
                            <div class="col-lg-3 col-md-12 col-sm-12 refrence-stock-div text-decoration">
                                <a href="{{route('product.details',['id' => $feature->partDetails->id])}}">
                                    <div class="d-flex flex-column w-100">
                                        <div id="demo{{$feature->id}}"
                                            class="carousel slide sliders-img-border carousel-positions w-100"
                                            data-bs-ride="carousel">

                                            <div class="carousel-inner">
                                                @foreach($partImages[$feature->partDetails->id] ?? [] as $key => $image)
                                                @if(file_exists(public_path('images/parts/' . $image->image)))
                                                <div class="carousel-item {{ $key === 0 ? 'active' : '' }} w-100">
                                                    <img src="{{ asset('/images/parts/' . $image->image) }}"
                                                        alt="{{ $key }}" class="w-100" style="height:210px">
                                                </div>
                                                @else
                                                <!-- Show a default/static image when the image file doesn't exist in public directory -->
                                                <div class="carousel-item {{ $key === 0 ? 'active' : '' }} w-100">
                                                    <img src="{{ asset('images/sample_part.png') }}" alt="Default Image"
                                                        class="w-100" style="height:210px">
                                                </div>
                                                <!-- You may choose to break the loop here if you want to show only one default image -->
                                                @endif
                                                @endforeach
                                            </div>


                                            <button class="carousel-control-prev" type="button"
                                                data-bs-target="#demo{{$feature->id}}" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon"></span>
                                            </button>
                                            <button class="carousel-control-next" type="button"
                                                data-bs-target="#demo{{$feature->id}}" data-bs-slide="next">
                                                <span class="carousel-control-next-icon"></span>
                                            </button>

                                            <div class="carousel-indicators indicators-positions">
                                                @foreach($partImages[$feature->partDetails->id] ?? [] as $key => $image)
                                                <button type="button" data-bs-target="#demo{{$feature->id}}"
                                                    data-bs-slide-to="{{ $key }}"
                                                    class="{{ $key === 0 ? 'active' : '' }} indicator-color custom-active w-100"></button>
                                                @endforeach
                                            </div>
                                        </div>
                                        @if($feature->partDetails->price_off > 0)
                                        <div class="verticals-div">Save
                                            {{ number_format(str_replace(',', '.', $feature->partDetails->price_off), 0) }}%
                                        </div>
                                        @endif
                                        <div class="mb-4 mt-3 refrence-stock-heading p-2">
                                            <h5>Reference
                                                #<span>{{ substr(strtoupper($feature->partDetails->ref_no),0,19)}}</span>
                                            </h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 text-decoration">

                                <a href="{{route('product.details',['id' => $feature->partDetails->id])}}">
                                    <h1 class="stock-heading">
                                        {{ \Carbon\Carbon::parse($feature->partDetails->manufacturer)->format('Y') .' '.strtoupper($feature->partDetails->make->make).' '.strtoupper($feature->partDetails->model->model_name).' '.strtoupper($feature->partDetails->version)}}
                                    </h1>

                                    <div class="row text-center mt-2">
                                        <div class="w-100 d-flex mb-2">
                                            <div class="mileage-detail border-right">
                                                <img src="{{ asset('user_assets/img/details/mileage.png') }}">
                                                <h6>Mileage</h6>
                                                <h5>{{substr(ucfirst($feature->partDetails->mileage),0,6)}} KM</h5>
                                            </div>
                                            <div class="mileage-detail border-right">
                                                <img src="{{ asset('user_assets/img/details/year.png') }}">
                                                <h6>Year</h6>
                                                <h5>{{ \Carbon\Carbon::parse($feature->partDetails->manufacturer)->format('Y/m') }}
                                                </h5>
                                            </div>
                                            <div class="mileage-detail border-right">
                                                <img src="{{ asset('user_assets/img/details/engine.png') }}">
                                                <h6>Engine</h6>
                                                <h5>{{substr(strtoupper($feature->partDetails->engine_size),0,6)}}cc
                                                </h5>
                                            </div>
                                            <div class="mileage-detail border-right">
                                                <img src="{{ asset('user_assets/img/details/trans.png') }}">
                                                <h6>Trans</h6>
                                                <h5>
                                                    @if($feature->partDetails->transmission == 'automatic')
                                                    AT
                                                    @elseif($feature->partDetails->transmission == 'manual')
                                                    MN
                                                    @endif
                                                </h5>
                                            </div>
                                            <div class="mileage-detail me-4">
                                                <img src="{{ asset('user_assets/img/details/location.png') }}">
                                                <h6>Location</h6>
                                                <h5>{{ucwords($feature->partDetails->country->country_name)}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 spc-pr p-2">
                                        <div class="diplay-flex-r px-2">
                                            <div class="product-detail  d-flex">
                                                <h6 class="mx-1">Model Code </h6>
                                                <span class="mx-1">{{$feature->partDetails->model->model_code}}</span>
                                            </div>
                                            <div class="product-detail  d-flex">
                                                <h6 class="mx-1">Steering</h6>
                                                <span class="mx-1">{{ucwords($feature->partDetails->steering)}}</span>
                                            </div>
                                            <div class="product-detail  d-flex">
                                                <h6 class="mx-1">Fuel Type</h6>
                                                <span class="mx-1">{{ucwords($feature->partDetails->fuel_type)}}</span>
                                            </div>
                                            <div class="product-detail  d-flex">
                                                <h6 class="mx-1">Seets</h6>
                                                <span class="mx-1">{{ucwords($feature->partDetails->seats)}}</span>
                                            </div>
                                            <div class="product-detail  d-flex">
                                                <h6 class="mx-1">Engine</h6>
                                                <span
                                                    class="mx-1">{{strtoupper($feature->partDetails->engine_code)}}</span>
                                            </div>
                                            <div class="product-detail  d-flex">
                                                <h6 class="mx-1">Color</h6>
                                                <span class="mx-1">{{ucwords($feature->partDetails->color)}}</span>
                                            </div>
                                            <div class="product-detail  d-flex">
                                                <h6 class="mx-1">Drivetrain</h6>
                                                <span
                                                    class="mx-1">{{strtoupper($feature->partDetails->drivetrain)}}</span>
                                            </div>
                                            <div class="product-detail  d-flex">
                                                <h6 class="mx-1">Doors</h6>
                                                <span class="mx-1">{{$feature->partDetails->door}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-lg-12 d-flex sunroof-details">
                                            <h5>
                                                @if(isset($featuresByPart[$feature->partDetails->id]) &&
                                                count($featuresByPart[$feature->partDetails->id]) > 0)
                                                @foreach($featuresByPart[$feature->partDetails->id]->take(5) as
                                                $featurepart)
                                                {{$featurepart}} <span> / </span>
                                                @endforeach
                                                @endif
                                            </h5>
                                        </div>
                                    </div>

                                </a>
                            </div>
                            <div class="col-lg-3 col-md-12 col-sm-12 price-div-stock pt-4  div-overlay text-decoration">
                                <a href="">
                                    <div class="w-100 border-1 mb-3">
                                        <div class="price-stock w-100 d-flex">
                                            <h6>Price Before:</h6>
                                            <span>{{ number_format($feature->partDetails->price) }}
                                                {{strtoupper($feature->partDetails->currency->currency)}}</span>
                                        </div>
                                        <div class="w-100 price-stock-off">
                                            OFF @if($feature->partDetails->price_off != null)
                                            {{ number_format(str_replace(',', '.', $feature->partDetails->price_off), 0) }}%
                                            @else
                                            0%
                                            @endif
                                        </div>

                                        <div class="price-stock w-100 d-flex">
                                            <h6>Price After:</h6>
                                            <span>
                                                @php
                                                if($feature->partDetails->price_off != null){
                                                $offPrice = ($feature->partDetails->price *
                                                $feature->partDetails->price_off)/100;
                                                $actualPrice = $feature->partDetails->price - $offPrice;
                                                }else{
                                                $actualPrice = $feature->partDetails->price;
                                                }
                                                @endphp
                                                {{ number_format($actualPrice)}}
                                                {{strtoupper($feature->partDetails->currency->currency)}}
                                            </span>
                                        </div>
                                        <hr>
                                        <div class="price-stock-p w-100 d-flex">
                                            <div class="left-content">
                                                <h6>Total Price:</h6>
                                            </div>
                                            <div class="right-content">
                                                <span>{{ number_format($actualPrice ) }}
                                                    {{strtoupper($feature->partDetails->currency->currency)}}</span>
                                                <p class="right-content-p">C&F To <span class="port-div"></span>
                                                </p>

                                            </div>
                                        </div>
                                        <div class="w-100 blue-btn-div mt-3 p-2 rounded-2">
                                            <a class="btn blue-btn" data-bs-toggle="modal" data-bs-target="#formModel"
                                                onclick="partId()">Inquire</a>
                                        </div>
                                    </div>
                                    <!-- Overlay starts here -->
                                    @if($feature->partDetails->is_stock == 0)
                                    <div class="overlay">
                                        <h2>SOLD OUT!</h2>
                                    </div>
                                    @endif
                                    <!-- End of overlay -->
                                </a>
                            </div>

                        </div>
                        @endif
                        @empty
                        <div class="text-center py-5">
                            <h5>No Record Found</h5>
                        </div>
                        @endforelse
                        {{$featured->links()}}

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
$(document).ready(function() {
    $('#search-clear').click(function(e) {
        e.preventDefault();

        $('#contactForm')[0].reset();
        $('input[type="checkbox"]').prop('checked', false);
        $('.custom-select').val('');

        $('.custom-select option[value=""]').prop('selected', true);
        $('.highlighted').removeClass('highlighted');
    });
});
</script>
<script>
$(document).ready(function() {
    getCities();
    $('.tab-button:first').each(getDataIdValue);
    if (localStorage.getItem("portName")) {
        $('.port-div').html(localStorage.getItem("portName"));
    } else {
        $('.port-div').html("{{ $shipment->portname }}");
    }
});


// Function to retrieve data-id value
function getDataIdValue() {
    var dataIdValue = $(this).data('id');
    // Use dataIdValue as needed, for example:
    $('#active_tab').val(dataIdValue);
}
// On click of elements with class .tab-button
$('.tab-button').on('click', getDataIdValue);



function getCities() {
    var country_id = $('#country_id').val();
    $.ajax({
        method: 'get',
        dataType: 'json',
        url: '{{ route('get-cities') }}',
        data: {
            country_id: country_id
        },
        success: function(response) {
            var data = response.data;
            $('#city_id').html('');
            var html = '<option selected disabled>Select Location</option>';
            for (var i = 0; i < data.length; ++i) {
                html += `<option value="${data[i].id}">${data[i].city_name}</option>`;
            }
            $('#city_id').html(html);
        }
    });
}
</script>
@endsection