@extends('layouts.user.block.app')

@section('content')
@section('title','-Stock')
<!-- ======================= HeroSection Start Here-->



<section id="hero" class="d-flex align-items-center p-5">
    <div class="container mx-auto text-lg-start">
        <div class="row searchMformx mt-2 justify-content-center">
            <div class="col-lg-12 mt-5">
                <div class="text-center mx-auto custom-title"><span class="d-lg-block">
                        <h1>Find Used Cars</h1>
                    </span>
                </div>
                <div class="slider-p text-center mx-auto custom-subtitle mb-3">At Best
                    Prices</div>
            </div>
            <div class="col-lg-8">
                <form id="searchForm" method="post" action="{{route('advance.search')}}">
                    @csrf
                    <div class="row">
                        <!-- Name input -->
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-2 custom-select-container">
                            <input type="hidden" name="is_stock" value="is_stock">
                            <label class="form-label custom-label float-start" for="make">Make</label>
                            <select class="custom-select" name="make_id" id="make_id">
                                <option value="" selected>Select Make</option>
                                @foreach($make as $mak)
                                <option value='{{$mak->id}}' {{old('make_id')==$mak->id ? 'selected' : ''}}>
                                    {{ucwords($mak->make)}}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Email input -->
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                            <!-- Added col-lg-6 here -->
                            <label class="form-label custom-label" for="emailAddress">Model</label>
                            <select class="custom-select" name="model_id" id="model_id">
                                <option value="" selected>Select Model</option>
                                @foreach($models as $key => $model)
                                <option value='{{$model->id}}' {{old('model_id')==$model->id ? 'selected' : ''}}>
                                    {{ucwords($model->model_name)}}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                            <!-- Added col-lg-6 here -->
                            <label class="form-label custom-label" for="name">Steering</label>
                            <select class="custom-select" name="steering" id="steering">
                                <option value="" selected>Select Steering</option>
                                <option value="left" {{old('steering')=='left' ? 'selected' : ''}}>Left</option>
                                <option value="right" {{old('steering')=='right' ? 'selected' : ''}}>Right</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Email input -->
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                            <!-- Added col-lg-6 here -->
                            <label class="form-label custom-label" for="body_type_id">Body Type</label>
                            <select class="custom-select" name="body_type_id" id="body_type_id">
                                <option value="" selected>Select Type</option>
                                @foreach($body_types as $type)
                                <option value="{{$type->id}}">{{ucwords($type->body_name)}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                            <!-- Added col-lg-6 here -->
                            <?php                    
                                $currencyType = DB::table('currency')->first()->currency;
                            ?>
                            <label class="form-label custom-label" for="name">Price ({{$currencyType}})</label>
                            <select class="custom-select" name="price" id="price">
                                <option value="" selected>Select Price</option>

                                <option value="500000" {{old('price')=='500000' ? 'selected' : ''}}>Under
                                    500000</option>
                                <option value="500001-1000000" {{old('price')=='500001-1000000' ? 'selected' : ''}}>
                                    500001 - 1000000</option>
                                <option value="1000001-1500000" {{old('price')=='1000001-1500000' ? 'selected' : ''}}>
                                    1000001 - 1500000</option>
                                <option value="1500001-2000000" {{old('price')=='1500001-2000000' ? 'selected' : ''}}>
                                    1500001 - 2000000</option>
                                <option value="2000001-2500000" {{old('price')=='2000001-2500000' ? 'selected' : ''}}>
                                    2000001 - 2500000</option>
                                <option value="2500001-3000000" {{old('price')=='2500001-3000000' ? 'selected' : ''}}>
                                    2500001 - 3000000</option>
                                <option value="3000001-3500000" {{old('price')=='3000001-3500000' ? 'selected' : ''}}>
                                    3000001 - 3500000</option>
                                <option value="3500001-4000000" {{old('price')=='3500001-4000000' ? 'selected' : ''}}>
                                    3500001 - 4000000</option>
                                <option value="4000001-4500000" {{old('price')=='4000001-4500000' ? 'selected' : ''}}>
                                    4000001 - 4500000</option>
                                <option value="4500001-5000000" {{old('price')=='4500001-5000000' ? 'selected' : ''}}>
                                    4500001 - 5000000</option>
                                <option value="5000001" {{old('price')=='5000001' ? 'selected' : ''}}>Greater than
                                    5000001</option>
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                            <label class="form-label custom-label" for="year">Year</label>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 mb-2">
                                    <select class="custom-select" name="from_year" id="from_year">
                                        <option value='' selected>Min</option>
                                        @foreach($years as $year)
                                        <option value="{{$year}}" {{old('from_year')==$year ? 'selected' : ''}}>
                                            {{$year}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 mb-2">
                                    <select class="custom-select" name="to_year" id="to_year">
                                        <option value='' selected>Max</option>
                                        @foreach($years as $year)
                                        <option value="{{$year}}" {{old('to_year')==$year ? 'selected' : ''}}>{{$year}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-submit-custom btn-lg" id="submitForm" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- ======================= Topbar  HeroSection End Here-->

<!-- =======================Fort Explore Section Start Here-->

<section id="fort-explore">
    <div class="container">
@forelse($partsDetail as $part)
        <div class="row  bottom-border py-5">
            <!-- <div class="alert alert-success" role="alert" id="alert-success" style="display:none"></div> -->
            <div class="col-lg-3 col-md-12 col-sm-12 refrence-stock-div text-decoration">
                <a href="{{route('product.details',['id' => $part->id])}}">
                    <div class="d-flex flex-column w-100 v-main-div">
                        <div id="demo{{$part->id}}" class="carousel slide sliders-img-border carousel-positions w-100"
                            data-bs-ride="carousel">
                            <!-- The slideshow/carousel -->
                            <div class="carousel-inner">
                                <!-- @foreach($partImages[$part->id] ?? [] as $key => $image)

                                <div class="carousel-item {{ $key === 0 ? 'active' : '' }} w-100">
                                    <img src="{{ asset('/images/parts/' . $image->image) }}" alt="{{ $key }}"
                                        class="w-100" style="height:210px">
                                </div>
                                @endforeach -->
                                @foreach($partImages[$part->id] ?? [] as $key => $image)
                                @if(file_exists(public_path('images/parts/' . $image->image)))
                                <div class="carousel-item {{ $key === 0 ? 'active' : '' }} w-100">
                                    <img src="{{ asset('/images/parts/' . $image->image) }}" alt="{{ $key }}"
                                        class="w-100" style="height:210px">
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
                            <button class="carousel-control-prev" type="button" data-bs-target="#demo{{$part->id}}"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#demo{{$part->id}}"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>

                            <div class="carousel-indicators indicators-positions">
                                @foreach($partImages[$part->id] ?? [] as $key => $image)
                                <button type="button" data-bs-target="#demo{{$part->id}}" data-bs-slide-to="{{ $key }}"
                                    class="{{ $key === 0 ? 'active' : '' }} indicator-color custom-active w-100"></button>
                                @endforeach
                            </div>

                        </div>
                        @if($part->price_off > 0)
                        <div class="verticals-div">Save {{ number_format(str_replace(',', '.', $part->price_off), 0) }}%
                        </div>
                        @endif
                        <!-- <img src="{{ asset('user_assets/img/home-slider/tyler-clemmensen-4gSavS9pe1s-unsplash 3.png')}}"
                            class=" img-fluid slider-img-border mt-3"> -->
                        <div class="mb-4 mt-3 refrence-stock-heading p-2">
                            <h5>Reference #<span>{{ substr(strtoupper($part->ref_no),0,19)}}</span></h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 text-decoration">
                <a href="{{route('product.details',['id' => $part->id])}}">
                    <h1 class="stock-heading">
                        {{ \Carbon\Carbon::parse($part->manufacturer)->format('Y') .' '.strtoupper($part->make->make).' '.strtoupper($part->model->model_name).' '.strtoupper($part->version)}}
                    </h1>
                    <div class="col-lg-12 d-flex sunroof-details">
                        <h5>
                            @foreach($featuresByPart[$part->id]->take(5) as $feature)
                            {{$feature}}<span> /</span>
                            @endforeach
                        </h5>
                    </div>
                    <div class="row text-center mt-2">
                        <div class="w-100 d-flex mb-2">
                            <div class="mileage-detail border-right">
                                <img src="{{ asset('user_assets/img/details/mileage.png') }}">
                                <h6>Mileage</h6>
                                <h5>{{substr(ucfirst($part->mileage),0,6)}}</h5>
                            </div>
                            <div class="mileage-detail border-right">
                                <img src="{{ asset('user_assets/img/details/year.png') }}">
                                <h6>Year</h6>
                                <h5>2002/1</h5>
                            </div>
                            <div class="mileage-detail border-right">
                                <img src="{{ asset('user_assets/img/details/engine.png') }}">
                                <h6>Engine</h6>
                                <h5>{{substr(strtoupper($part->engine_code),0,6)}}</h5>
                            </div>
                            <div class="mileage-detail border-right">
                                <img src="{{ asset('user_assets/img/details/trans.png') }}">
                                <h6>Trans</h6>
                                <h5>AT</h5>
                            </div>
                            <div class="mileage-detail me-4">
                                <img src="{{ asset('user_assets/img/details/location.png') }}">
                                <h6>Location</h6>
                                <h5>{{ucfirst($part->city->city_name)}}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 spc-pr p-2">
                        <div class="diplay-flex-r px-2">
                            <div class="product-detail  d-flex">
                                <h6 class="mx-1">Model Code </h6>
                                <span class="mx-1">{{strtoupper($part->model->model_code)}}</span>
                            </div>
                            <div class="product-detail  d-flex">
                                <h6 class="mx-1">Steering</h6>
                                <span class="mx-1">{{ substr(ucfirst($part->steering),0,6)}}</span>
                            </div>
                            <div class="product-detail  d-flex">
                                <h6 class="mx-1">Fuel</h6>
                                <span class="mx-1">{{ ucfirst($part->fuel->fuel_type)}}</span>
                            </div>
                            <div class="product-detail  d-flex">
                                <h6 class="mx-1">Seets</h6>
                                <span class="mx-1">{{ ucfirst($part->seats)}}</span>
                            </div>
                            <div class="product-detail  d-flex">
                                <h6 class="mx-1">Engine code</h6>
                                <span class="mx-1">{{substr(strtoupper($part->engine_code),0,6)}}</span>
                            </div>
                            <div class="product-detail  d-flex">
                                <h6 class="mx-1">Color</h6>
                                <span class="mx-1">{{substr(ucfirst($part->color),0,6)}}</span>
                            </div>
                            <div class="product-detail  d-flex">
                                <h6 class="mx-1">Drive</h6>
                                <span class="mx-1">{{substr(strtoupper($part->drivetrain),0,6)}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-lg-12 d-flex sunroof-detail">
                            <h5>
                                <span>@foreach($featuresByPart[$part->id]->skip(5)->take(5) as $feature)
                                    {{$feature}} /
                                    @endforeach </span>
                            </h5>
                        </div>
                    </div>

                </a>
            </div>
            <div class="col-lg-3 col-md-12 col-sm-12 price-div-stock pt-4  div-overlay text-decoration">
                <a href="{{route('product.details',['id' => $part->id])}}">
                    <div class="w-100 border-1 mb-3">
                        <div class="price-stock w-100 d-flex">
                            <h6>Price Before:</h6>
                            <span>{{ number_format($part->price) }}
                                {{strtoupper($part->currency->currency)}}</span>
                        </div>
                        <div class="w-100 price-stock-off">
                            @if($part->price_off != null)
                                {{ number_format(str_replace(',', '.', $part->price_off), 0) }}%
                                @else
                                0%
                                @endif
                        </div>
                     
                        <div class="price-stock w-100 d-flex">
                            <h6>Price After:</h6>
                            <span> @php
                                if($part->price_off != null){
                                $offPrice = ($part->price * $part->price_off)/100;
                                $actualPrice = $part->price - $offPrice;
                                }else{
                                $actualPrice = $part->price;
                                }
                                @endphp
                                {{ number_format($actualPrice)}}
                                {{strtoupper($part->currency->currency)}}</span>
                        </div>
                        <hr>
                        <div class="price-stock-p w-100 d-flex">
                            <div class="left-content">
                                <h6>Total Price:</h6>
                            </div>
                            <div class="right-content">
                                <span>{{ number_format($actualPrice) }} 
                                    {{strtoupper($part->currency->currency)}}</span>
                                <p class="right-content-p">C&F To <span class="port-div"></span>
                                    </p>
                            </div>
                        </div>

                        <div class="w-100 blue-btn-div mt-3 p-2 rounded-2">
                            <a class="btn blue-btn" data-bs-toggle="modal" data-bs-target="#formModel"
                                onclick="partId({{ $part->id }})">Inquire</a>
                        </div>

                    </div>
                </a>
                <a href="{{route('product.details',['id' => $part->id])}}">
                    <!-- Overlay starts here -->
                    @if($part->is_stock == 0)
                    <div class="overlay">
                        <h2>SOLD OUT!</h2>
                    </div>
                    @endif
                    <!-- End of overlay -->
                </a>
            </div>

        </div>
@empty
<div class="text-center py-5">
    <h5>No Record Found</h5>
</div>
@endforelse
        {{$partsDetail->links()}}
    </div>
</section>
<!-- ======================= Fort Explore Section End Here-->
<script>
$('#submitForm').click(function(e) {
    e.preventDefault();
    var searchForm = $('#searchForm');
    var make = $('#make_id').val();
    var model = $('#model_id').val();
    var steering = $('#steering').val();
    var type = $('#type_id').val();
    var price = $('#price').val();
    var from_year = $('#from_year').val();
    var to_year = $('#to_year').val();

    // Check if at least one input is filled
    if (make || model || steering || type || price || from_year || to_year) {
        if (from_year > to_year) {
            alert("Please select correct date format");
            return;
        }

        // if(from_year == ''){
        //     alert("Please select min year");
        //     return;
        // }
        // At least one input is filled, you can proceed with the form submission or other actions
        searchForm.submit(); // or any other action you want to perform
    } else {
        // None of the inputs is filled, you can show an alert or perform other actions
        alert("Please fill in at least one input before submitting the form.");
        return;
    }



});

if (localStorage.getItem("portName")) {
$('.port-div').html(localStorage.getItem("portName"));
} else {
$('.port-div').html("{{ $shipment->portname }}");
}


// $('.port-div').html(localStorage.getItem("portName"));
</script>

@endsection