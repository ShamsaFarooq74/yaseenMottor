@extends('layouts.user.block.app')

@section('content')
<!-- ======================= HeroSection Start Here-->
<section id="contact-slider" class="p-5">
    <div class="container mx-auto text-lg-start p-5">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="text-center mx-auto custom-title pt-4"><span class="d-none d-lg-block">
                        <h1>Favorites</h1>
                    </span>
                </div>
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
            <div class="col-lg-3 col-md-12 col-sm-12 refrence-stock-div text-decoration">
                <a href="{{route('product.details',['id' => $part->id])}}">
                    <div class="d-flex flex-column w-100 v-main-div">
                        <div id="demo{{$part->id}}" class="carousel slide sliders-img-border carousel-positions w-100"
                            data-bs-ride="carousel">
                            <!-- The slideshow/carousel -->
                            <div class="carousel-inner">
                                <!-- Check if it's an array -->
                                <!-- @foreach($part['images'] ?? [] as $key => $images)
                                <div class="carousel-item {{ $key === 0 ? 'active' : '' }} w-100">
                                    <img src="{{ asset('/images/parts/' . $images->image) }}" alt="{{ $key }}"
                                        class="w-100" style="height:210px">
                                </div>
                                @endforeach -->
                                @foreach($part['images'] ?? [] as $key => $image)
                                @if(file_exists(public_path('images/parts/' . $image->image)))
                                <div class="carousel-item {{ $key === 0 ? 'active' : '' }} w-100">
                                    <img src="{{ asset('/images/parts/' . $image->image) }}" alt="{{ $key }}"
                                        class="w-100" style="height:210px">
                                </div>
                                @else
                                <!-- Show a default/static image when the image file doesn't exist in public directory -->
                                <div class="carousel-item {{ $key === 0 ? 'active' : '' }} w-100">
                                    <img src="{{ asset('images/sample_part.png') }}" alt="Default Image" class="w-100"
                                        style="height:210px">
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
                                @foreach($part['images']?? [] as $key => $images)
                                <button type="button" data-bs-target="#demo{{$part->id}}" data-bs-slide-to="{{ $key }}"
                                    class="{{ $key === 0 ? 'active' : '' }} indicator-color custom-active w-100"></button>
                                @endforeach
                            </div>
                        </div>
                        @if($part->price_off > 0)
                        <div class="verticals-div">Save {{ number_format(str_replace(',', '.', $part->price_off), 0) }}%
                        </div>
                        @endif
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
                    <div class="col-lg-12 d-flex sunroof-detail">
                        <h5> @foreach($featuresByPart[$part->id]->take(5) as $feature)
                            {{$feature}} <span>/ </span>
                            @endforeach</h5>
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
                                <span class="mx-1">{{ ucfirst($part->fuel->fuel_types)}}</span>
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
                            <h5> @foreach($featuresByPart[$part->id]->skip(5)->take(5) as $feature)
                                <span>{{$feature}} / </span>
                                @endforeach
                            </h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-12 col-sm-12 price-div-stock pt-4 div-overlay text-decoration">
                <a href="{{route('product.details',['id' => $part->id])}}">
                    <div class="w-100 border-1 mb-3">
                        <div class="price-stock w-100 d-flex">
                            <h6>Price Before:</h6>
                            <span>{{ number_format($part->price ) }}
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
                                {{ number_format($actualPrice )}}
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
                                <p class="right-content-p">{{$part->country->country_name}} To
                                    {{$part->city->city_name}}</p>
                            </div>
                        </div>
                        <div class="w-100 blue-btn-div mt-3 p-2 rounded-2">
                            <a class="btn blue-btn">Inquire</a>
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


@endsection