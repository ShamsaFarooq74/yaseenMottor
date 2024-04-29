@extends('layouts.user.block.app')

@section('content')
@php
$bannerImage = DB::table('ads')->where('is_deleted','N')->whereDate('start_date','<=',Date('Y-m-d'))->
    whereDate('end_date','>=',Date('Y-m-d'))->orderBy('created_at','DESC')->first();
    if($bannerImage){
    $bannerImage = 'ads/'.$bannerImage->image;
    }else{
    $bannerImage = "user_assets/img/home-slider/topslider.png";
    }
    @endphp
    <style>
    #top-hero {
        width: 100%;
        height: 300px;
        position: relative;
    }
    </style>
    <div>
        <img style="height:300px; width:100%; position:relative;" src="{{url($bannerImage)}}">
        <div class="top-hero-div">
            <div class="container d-flex justify-content-center flex-wrap">
                <h6>Total Cars In Stock :<span>{{$partsCount}}</span></h6>
                <h6>Cars Added Today : <span>{{$todayParts}}</span></h6>
                <h6>Pakistan Time : <span id="pakistan-time"></span></h6>
            </div>
        </div>
    </div>
    <section id="hero" class="d-flex align-items-center p-5">
        <div class="container mx-auto text-lg-start">
            <div class="row searchMformx mt-2 justify-content-center">
                <div class="col-lg-12 mt-2">
                    <div class="text-center mx-auto custom-home-title"><span class="d-lg-block">
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
                                <label class="form-label custom-label float-start" for="make">Make</label>
                                <select class="custom-select" name="make_id" id="make_id">
                                    <option value="" selected>Select Make</option>
                                    @forelse($make as $mak)
                                    <option value='{{$mak->id}}' {{old('make_id')==$mak->id ? 'selected' : ''}}>
                                        {{ucwords($mak->make)}}</option>
                                    @empty
                                    <option class="text-center py-5">
                                        <h5>No Record Found</h5>
                                    </option>
                                    @endforelse
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
                                    <option value="1000001-1500000"
                                        {{old('price')=='1000001-1500000' ? 'selected' : ''}}>
                                        1000001 - 1500000</option>
                                    <option value="1500001-2000000"
                                        {{old('price')=='1500001-2000000' ? 'selected' : ''}}>
                                        1500001 - 2000000</option>
                                    <option value="2000001-2500000"
                                        {{old('price')=='2000001-2500000' ? 'selected' : ''}}>
                                        2000001 - 2500000</option>
                                    <option value="2500001-3000000"
                                        {{old('price')=='2500001-3000000' ? 'selected' : ''}}>
                                        2500001 - 3000000</option>
                                    <option value="3000001-3500000"
                                        {{old('price')=='3000001-3500000' ? 'selected' : ''}}>
                                        3000001 - 3500000</option>
                                    <option value="3500001-4000000"
                                        {{old('price')=='3500001-4000000' ? 'selected' : ''}}>
                                        3500001 - 4000000</option>
                                    <option value="4000001-4500000"
                                        {{old('price')=='4000001-4500000' ? 'selected' : ''}}>
                                        4000001 - 4500000</option>
                                    <option value="4500001-5000000"
                                        {{old('price')=='4500001-5000000' ? 'selected' : ''}}>
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
                                            <option value='' selected>From</option>
                                            @foreach($years as $year)
                                            <option value="{{$year}}" {{old('from_year')==$year ? 'selected' : ''}}>
                                                {{$year}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 mb-2">
                                        <select class="custom-select" name="to_year" id="to_year">
                                            <option value='' selected>To</option>
                                            @foreach($years as $year)
                                            <option value="{{$year}}" {{old('to_year')==$year ? 'selected' : ''}}>
                                                {{$year}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid">
                            <button class="btn btn-submit-custom btn-lg" id="submitForm" type="submit">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <section id="explore-deal" class="pt-0 mb-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="primary-title text-center">
                        <h5>Explore</h5>
                        <p>Your Trusted Destination for Quality Used Cars!. With our dedication to quality, you can shop
                            with
                            confidence, knowing that every item you find on our website has been chosen with your
                            satisfaction in mind.</p>
                    </div>
                </div>
                <div class="col-lg-3 shop-by text-align-center">
                    <h6 class="mt-3 shop-by-heading">SHOP BY MAKE</h6>
                    <div class="mt-3">
                        @foreach($makes as $make)
                        <div class="d-flex w-100 shop-make">
                            <div class="d-flex custom-mitsubishi"
                                style="width: 50%; justify-content: flex-start; cursor:pointer">
                                <!-- <h6 class="getMakeName " id="getMakeName" data-make-id="{{$make->id}}">{{$make->make}}</h6><span class="mx-1">{{$make->parts_count}}</span> -->
                                <a href="{{route('advance.search',['make_id'=>$make->id])}}" class="getMakeName d-flex">
                                    <h6 class="getMakeName " id="getMakeName" data-make-id="{{$make->id}}">
                                         {{ strlen($make->make) > 15 ? substr(ucfirst($make->make), 0, 15) . '...' : ucfirst($make->make) }}
                                    </h6><span class="mx-1"> ({{$make->parts_count}})</span>
                                </a>
                            </div>
                            <div style="width: 50%; text-align: right;">
                                <a href="#" class="detail-custom-icon pt-5">
                                    @if($make->logo)

                                    <img src="{{ asset('images/settings/' . $make->logo)  }}" />
                                    @else
                                    <img src="{{ asset('user_assets/img/icons/shop-by.png') }}" />
                                    @endif
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-9">
                    <ul class="nav nav-tab nav-fill mb-3 col-lg-8 mx-auto mt-2" id="ex1" role="tablist">
                        <li class="custom-tab me-3 mt-2" role="presentation">
                            <a class="nav-link actis py-3 px-5 {{ $activePage == 'new-arrival' ? 'active' : '' }}" id="ex2-tab-1" data-bs-toggle="tab"
                             href="#ex2-tabs-1" role="tab" aria-controls="ex2-tabs-1" aria-selected="true">New
                                Arrival</a>
                        </li>
                        <li class="custom-tab me-3 mt-2" role="presentation">
                            <a class="nav-link actis py-3 px-5 {{ $activePage == 'featured' ? 'active' : '' }}" id="ex2-tab-2" data-bs-toggle="tab" href="#ex2-tabs-2"
                             role="tab" aria-controls="ex2-tabs-2" aria-selected="false">Featured</a>
                        </li>

                    </ul>
                    <div class="tab-content" id="ex2-content">

                        <div class="tab-pane fade {{ $activePage == 'new-arrival' ? 'show active' : '' }}" id="ex2-tabs-1" role="tabpanel"
                            aria-labelledby="ex2-tab-1">
                            <div class="row">
                               @forelse($newArrival as $part)
                                <div class="col-lg-4 col-md-6 mt-lg-4 mt-2 mb-1 padding-right">
                                    <div class="deal-box img-customiz-slider">
                                        <div id="demo{{$part->id}}"
                                            class="carousel slide slider-img-border carousel-positions w-100"
                                            data-bs-ride="carousel">
                                            <!-- The slideshow/carousel -->
                                            <div class="carousel-inner">
                                                @foreach($partImages[$part->id] ?? [] as $key => $image)
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
                                                <div class="carousel-item {{ $key === 0 ? 'active' : '' }} w-100">
                                                    <img src="{{ asset($image->image) }}" alt="" class="w-100"
                                                        style="height:230px">
                                                </div>
                                                @endforeach
                                            </div>

                                            <!-- Left and right controls/icons -->
                                            <button class="carousel-control-prev" type="button"
                                                data-bs-target="#demo{{$part->id}}" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon"></span>
                                            </button>
                                            <button class="carousel-control-next" type="button"
                                                data-bs-target="#demo{{$part->id}}" data-bs-slide="next">
                                                <span class="carousel-control-next-icon"></span>
                                            </button>

                                            <div class="carousel-indicators indicator-positions">
                                                @foreach($partImages[$part->id] ?? [] as $key => $image)
                                                <button type="button" data-bs-target="#demo{{$part->id}}"
                                                    data-bs-slide-to="{{ $key }}"
                                                    class="{{ $key === 0 ? 'active' : '' }} indicator-color custom-active w-100"></button>
                                                @endforeach
                                            </div>
                                        </div>
                                        @if($part->price_off > 0)
                                        <div class="vertical-div">Save
                                            {{ number_format(str_replace(',', '.', $part->price_off), 0) }}%</div>
                                        @endif
                                        <h6 class="text-center custom-slider-title mt-2"><a
                                                href="{{ route('product.details',['id' => $part->id]) }}">{{ \Carbon\Carbon::parse($part->reg_no)->format('Y').' '.substr(strtoupper($part->make->make),0,7).' '.substr(strtoupper($part->model->model_name),0,3).' '.substr(strtoupper($part->version),0,3) }}
                                                </span></a></h6>
                                        <div class="px-3 d-flex w-100">
                                            <div class="d-flex" style="width: 50%; justify-content: flex-start;">
                                                <img src="{{ asset('user_assets/img/home-slider/location-icon.png') }}"
                                                    class="location-icon">
                                                <span
                                                    class="custom-country">{{ucfirst($part->country->country_name)}}</span>
                                            </div>
                                            <!-- <div style="width: 50%; text-align: right;">
                                            <a href="{{route('add.to.favorite',['id'=>$part->id])}}"><img src="{{ asset('user_assets/img/home-slider/Heart.png') }}"
                                                class="heart-icon"></a>
                                        </div> -->
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
                                                    <img src="{{ asset('user_assets/img/home-slider/Heart.png') }}"
                                                        class="heart-icon">
                                                </span>
                                            </div>
                                            @endif

                                        </div>

                                        <div class="px-3 py-2 d-flex w-100 mt-2 custom-manul">
                                            <div class="d-flex custom-manul-option option-three"
                                                style="width: 36%; justify-content: flex-start;">
                                              {{ strlen($part->transmission) > 9 ? substr(ucfirst($part->transmission), 0, 9) . '...' : ucfirst($part->transmission) }}
                                            </div>
                                            <div class="custom-manul-option option-three"
                                                style="width: 30%; text-align:
                                                center;"> {{strlen($part->fuel) > 6 ?substr(ucfirst($part->fuel), 0, 6) . '...' :ucfirst($part->fuel)}}</div>
                                            <div style="width: 34%; text-align: right;" class="option-three">
                                             {{ strlen($part->engine_code) > 6 ?substr(strtoupper($part->engine_code), 0, 6) . '...' :strtoupper($part->engine_code) }}
                                            </div>
                                        </div>

                                        <div class="px-3 d-flex w-100 pb-3 mt-2">
                                            <div class="d-flex custom-currency"
                                                style="width: 70%; justify-content: flex-start;">
                                                {{ number_format($part->price)}}
                                                <span>{{strtoupper($part->currency->currency)}}</span>
                                            </div>
                                            <div style="width: 30%; text-align: right;">
                                                <a href="{{route('product.details',['id' => $part->id])}}"
                                                    class="detail-custom">Details</a>
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

                        <div class="tab-pane fade {{ $activePage == 'featured' ? 'show active' : '' }}" id="ex2-tabs-2" role="tabpanel" aria-labelledby="ex2-tab-2">
                            <div class=" row">
                              
                                @forelse($featured as $feature)
                                @if(isset($feature->partDetails->id))
                                <div class="col-lg-4 col-md-6 mt-lg-4 mt-2 mb-1">
                                    <div class="deal-box img-customiz-slider">
                                        <div id="demo{{$feature->id}}"
                                            class="carousel slide slider-img-border carousel-positions w-100"
                                            data-bs-ride="carousel">
                                            <!-- The slideshow/carousel -->
                                            <div class="carousel-inner">
                                                @foreach($featuredImgs[$feature->partDetails->id] ?? [] as $key =>
                                                $image)
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
                                                <div class="carousel-item {{ $key === 0 ? 'active' : '' }} w-100">
                                                    <img src="{{ asset($image->image) }}" alt="" class="w-100"
                                                        style="height:230px">
                                                </div>
                                                @endforeach
                                            </div>

                                            <!-- Left and right controls/icons -->
                                            <button class="carousel-control-prev" type="button"
                                                data-bs-target="#demo{{$feature->id}}" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon"></span>
                                            </button>
                                            <button class="carousel-control-next" type="button"
                                                data-bs-target="#demo{{$feature->id}}" data-bs-slide="next">
                                                <span class="carousel-control-next-icon"></span>
                                            </button>

                                            <div class="carousel-indicators indicator-positions">
                                                @foreach($featuredImgs[$feature->partDetails->id] ?? [] as $indicatorKey
                                                =>
                                                $image)
                                                <button type="button" data-bs-target="#demo{{$feature->id}}"
                                                    data-bs-slide-to="{{ $indicatorKey }}"
                                                    class="{{ $indicatorKey === 0 ? 'active' : '' }} indicator-color custom-active w-100"></button>
                                                @endforeach
                                            </div>
                                        </div>
                                        @if($feature->partDetails->price_off > 0)
                                        <div class="vertical-div">Save
                                            {{ number_format(str_replace(',', '.', $feature->partDetails->price_off), 0) }}%
                                        </div>
                                        @endif
                                        <!-- <div class="vertical-div">Save 20%</div> -->
                                        <h6 class="text-center custom-slider-title mt-2">
                                            <a
                                                href="{{ route('product.details',['id' =>$feature->partDetails->id]) }}">{{ \Carbon\Carbon::parse($feature->partDetails->reg_no)->format('Y').' '.substr(strtoupper($feature->partDetails->make->make),0,7).' '.substr(strtoupper($feature->partDetails->model->model_name),0,3).' '.substr(strtoupper($feature->partDetails->version),0,3) }}
                                                </span></a>
                                        </h6>
                                        <div class="px-3 d-flex w-100">
                                            <div class="d-flex" style="width: 50%; justify-content: flex-start;">
                                                <img src="{{ asset('user_assets/img/home-slider/location-icon.png') }}"
                                                    class="location-icon">
                                                <span
                                                    class="custom-country">{{ucfirst($feature->partDetails->country->country_name)}}</span>
                                            </div>
                                            @if(in_array($feature->partDetails->id, $favoriteId))
                                            <div style="width: 50%; text-align: right;" class="favorite-container"
                                                data-part-id="{{ $feature->partDetails->id }}">
                                                <span class="favorite-link" style="cursor: pointer;">
                                                    <img src="{{ asset('user_assets/img/home-slider/filled-Heart.png') }}"
                                                        class="filled-heart-icon">
                                                </span>
                                            </div>
                                            @else
                                            <div style="width: 50%; text-align: right;" class="favorite-container"
                                                data-part-id="{{ $feature->partDetails->id }}">
                                                <span class="favorite-link" style="cursor: pointer;">
                                                    <img src="{{ asset('user_assets/img/home-slider/Heart.png') }}"
                                                        class="heart-icon">
                                                </span>
                                            </div>
                                            @endif
                                        </div>

                                        <div class="px-3 py-2 d-flex w-100 mt-2 custom-manul">
                                            <div class="d-flex custom-manul-option option-three"
                                                style="width: 36%; justify-content: flex-start;">
                                                {{ strlen($feature->partDetails->transmission) > 9 ? substr(ucfirst($feature->partDetails->transmission), 0, 9) . '...' : ucfirst($feature->partDetails->transmission) }}
                                            </div>
                                            <div class="custom-manul-option option-three"
                                                style="width: 30%; text-align: center;">
                                                 {{ strlen($feature->partDetails->fuel->fuel_type) > 6 ? substr(ucfirst($feature->partDetails->fuel->fuel_type), 0, 6) . '...' : ucfirst($feature->partDetails->fuel->fuel_type) }}
                                                </div>
                                            <div style="width: 34%; text-align: right;" class="option-three">
                                            {{ strlen($feature->partDetails->engine_code) > 6 ? substr(strtoupper($feature->partDetails->engine_code), 0, 6) . '...' : strtoupper($feature->partDetails->engine_code) }}
                                            </div>
                                        </div>

                                        <div class="px-3 d-flex w-100 pb-3 mt-2">
                                            <div class="d-flex custom-currency"
                                                style="width: 70%; justify-content: flex-start;">
                                                {{ number_format($feature->partDetails->price)}}
                                                <span>{{strtoupper($feature->partDetails->currency->currency)}}</span>
                                            </div>
                                            <div style="width: 30%; text-align: right;">
                                                <a href="{{route('product.details',['id' =>$feature->partDetails->id])}}"
                                                    class="detail-custom">Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @empty
                                <div class="text-center py-5">
                                    <h5>No Record Found</h5>
                                </div>
                                @endforelse
                            </div>
                           
                        </div>
                    </div>
                </div>
                <!-- Tabs navs -->

                <!-- Tabs navs -->

                <!-- Tabs content -->

                <!-- Tabs content -->

            </div>
                <div class="pagination-div home-screen-navigation" id="featured" style="display:none">
                    {{$featured->appends(['type' => 'featured'])->links()}}
                </div>
                <div class="pagination-div home-screen-navigation"  id="new-arrival-pagination">
                    {{$newArrival->appends(['type' => 'new-arrival'])->links()}}
                </div>
        </div>
    </section>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
        const tabs = document.querySelectorAll('.custom-tab a');

        function hasClass(element, className) {
            return element.classList.contains(className);
        }

        function getActiveTabId() {
            for (const tab of tabs) {
                if (hasClass(tab, 'active')) {
                    return tab.getAttribute('href');
                }
            }
        }

        const activeTabId = getActiveTabId();
        if(activeTabId == '#ex2-tabs-2'){
        var myDiv = document.getElementById("new-arrival-pagination");
        myDiv.style.display = "none";
        var myDiv2 = document.getElementById("featured");
        myDiv2.style.display = "block";
        }else{
        var myDiv = document.getElementById("new-arrival-pagination");
        myDiv.style.display = "block";
        var myDiv2 = document.getElementById("featured-pagination");
        myDiv2.style.display = "none";
        }
    });
    document.addEventListener("DOMContentLoaded", function() {
        const tabs = document.querySelectorAll('.actis');
        tabs.forEach(tab => {
            tab.addEventListener('click', function(event) {
                const tabId = this.getAttribute('href');
                if(tabId == '#ex2-tabs-2'){
                var myDiv = document.getElementById("new-arrival-pagination");
                myDiv.style.display = "none";
                var myDiv2 = document.getElementById("featured");
                myDiv2.style.display = "block";
                }else{
                var myDiv = document.getElementById("new-arrival-pagination");
                myDiv.style.display = "block";
                var myDiv2 = document.getElementById("featured-pagination");
                myDiv2.style.display = "none";
                }
            });
        });
    });
    </script>
    <script>
    // Today date
    function updatePakistanTime() {
        const now = new Date();
        const options = {
            hour: '2-digit',
            minute: '2-digit',
            hour12: true
        };
        const formattedTime = now.toLocaleTimeString('en-US', options);

        document.getElementById('pakistan-time').textContent = formattedTime;
    }

    updatePakistanTime();
    setInterval(updatePakistanTime, 1000);

    $('#submitForm').click(function(e) {
        e.preventDefault();
        var searchForm = $('#searchForm');
        var make = $('#make_id').val();
        var model = $('#model_id').val();
        var steering = $('#steering').val();
        var body_type = $('#body_type_id').val();
        var price = $('#price').val();
        var from_year = $('#from_year').val();
        var to_year = $('#to_year').val();

        // Check if at least one input is filled
        if (make || model || steering || body_type || price || from_year || to_year) {
            if (from_year > to_year) {
                toastr.error("Please select correct date format");
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
            toastr.error("Please fill in at least one input before submitting the form.");
            return;
        }



    });


  
    // to change slider color
    document.addEventListener('DOMContentLoaded', function() {
        var indicatorButtons = document.querySelectorAll('.indicator-color');

        indicatorButtons.forEach(function(button, index) {
            button.addEventListener('click', function() {

                indicatorButtons.forEach(function(btn) {
                    btn.classList.remove('.custom-active');
                });
                button.classList.add('.custom-active');
            });
        });
    });

    $(document).ready(function() {
        $(".getMakeName").on("click", function() {
            var makeValue = $(this).text().trim().split(' ')[0];
            var makeId = $(this).data("make-id");
            $("#make_id").val(makeId);
        });
    });

    
    </script>

    @endsection