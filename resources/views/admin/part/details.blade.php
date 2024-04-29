@extends('layouts.admin.master')
@section('content')

<!-- Topbar Start -->
@include('layouts.admin.blocks.inc.topnavbar')
<!-- end Topbar -->

<!-- Start Content-->
<div class="container-fluid mt-3">
    <div class="row">
        <div class="col-md-3">
            <div class="page_left_bar">
                <a href="{{route('sellers.parts.details',['partId' => $partId])}}" class="active"> Car Details </a>
                <a href="{{route('sellers.parts')}}">All Car</a>
            </div>
        </div>
        <div class="col-md-9">
            <div class="add_plants_vt">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="page_head_vt">Car Details</h3>
                    </div>
                    <div class="col-md-12 p3">

                        <div class="prod_profile_vt">
                            <div class="container">
                                <div class="row">
                                    <div class=" col-lg-12 col-md-12 w-100 h-70 pb-3  d-flex justify-content-center">
                                        <div class="slider_area_vt">
                                            <div class="slider slider-for p-0 mb-1 mx-auto">
                                                @foreach($partData['images'] as $attachment)
                                                @if($attachment['image'])
                                                <div>
                                                    <a href="{{$attachment['image']}}" data-lightbox="image-1"
                                                        data-title="My caption">
                                                        <img class="d-block w-100 h-100 img-fluid"
                                                            src="{{$attachment['image']}}"
                                                            alt="slide{{$attachment['id']}}">
                                                    </a>
                                                </div>
                                                @else
                                                <div>
                                                    <a href="#" data-lightbox="image-1" data-title="My caption">
                                                        <img class="d-block w-100 h-100 img-fluid"
                                                            src="{{asset('assets/images/parts.png')}}" alt="">
                                                    </a>
                                                </div>
                                                @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" col-md-12  col-lg-12">
                                        <div class="row">
                                            
                                            <div class="col-lg-6 product_detail" style="border-right: 2px solid gray">
                                             <p><span> Ref No:</span>{{ $partData->ref_no }}</p>
                                            <p><span> Price:</span>
                                                 {{ $partData->price }}{{ strtoupper($partData->currency->currency) }}</p>
                                             <h2> <span>Make:</span>
@if($makedata && $makedata->make)
                                                     @if($makedata->make->logo)
                                                         <img class="d-block w-1000 img-fluid mx-4"
                                                             src="{{ $makedata->make->logo }}"
                                                             style="width:30px; height:30px;">
                                                     @else
                                                         <img class="d-block w-1000 img-fluid mx-4"
                                                             src="{{ asset('assets/images/parts.png') }}"
                                                             style="width:30px; height:30px;">
                                                     @endif
                                                     <p> {{ $makedata->make->make }}</p>
                                                 @endif
                                             </h2>
                                               <p class="d-flex">
                                                   <span>Fuel:</span>{{ ucfirst($partData->fuel->fuel_type) }}
                                               </p>
                                               <p class="d-flex">
                                                   <span>Mileage:</span>{{ ucfirst($partData->mileage) }}
                                               </p>
                                               <p class="d-flex"> <span>Weight:</span>{{ ucfirst($partData->weight) }}
                                               </p>
                                               <p class="d-flex"> <span>Load
                                                       Cap:</span>{{ ucfirst($partData->load_cap) }}</p>
                                               <p class="d-flex"> <span>Seats:</span>{{ ucfirst($partData->seats) }}
                                               </p>
                                               <p class="d-flex"> <span>Door:</span>{{ ucfirst($partData->door) }}</p>
                                               <p class="d-flex">
                                                   <span>Drivetrain:</span>{{ ucfirst($partData->drivetrain) }}
                                               </p>
                                               <p class="d-flex">
                                                   <span>Transmission:</span>{{ ucfirst($partData->transmission) }}
                                               </p>
                                                <p class="d-flex">
                                                    <span>Version/Class:</span>{{ ucfirst($partData->version) }}
                                                </p>
                                                <p class="d-flex"> <span>M3/:</span>{{ ucfirst($partData->m3) }}</p>
                                                <p class="d-flex">
                                                    <span>Dimension:</span>{{ ucfirst($partData->dimension) }}
                                                </p>
                                            </div>
                                            <div class="col-lg-6 product_detail ">
                                                     <p class="d-flex"> <span class="product-detail-heading">Manufacturer
                                                    Year:</span>{{$partData->manufacturer}}</p>
                                            <div class="model_vt">
                                                @if ($modeldata && $modeldata->model)
                                                <p class="d-flex"> <span>Model
                                                        Name:</span>{{ $modeldata->model->model_name}}
                                                </p>
                                                <p class="d-flex"> <span>Model
                                                        Code:</span>{{  $modeldata->model->model_code }}
                                                </p>
                                                @endif
                                                <p class="d-flex"> <span>Sub Ref
                                                        No:</span>{{ ucfirst($partData->sub_ref_no)}}</p>
                                                <p class="d-flex"> <span>Engine
                                                        Size:</span>{{ ucfirst($partData->engine_size)}}</p>
                                                <p class="d-flex"> <span>Engine
                                                        Code:</span>{{ ucfirst($partData->engine_code)}}</p>
                                                <p class="d-flex">
                                                    <span>Country:</span>{{ ucfirst($partData->country->country_name)}}
                                                </p>
                                                <p class="d-flex">
                                                    <span>City:</span>{{ ucfirst($partData->city->city_name)}}
                                                </p>
                                                <p class="d-flex">
                                                    <span>Steering:</span>{{ ucfirst($partData->steering)}}
                                                </p>
                                                <p class="d-flex"> <span>Color:</span>{{ ucfirst($partData->color)}}</p>
                                                <p class="d-flex"> <span>Chasis:</span>{{ ucfirst($partData->chasis)}}
                                                </p>
                                               
                                              
                                            </div>
                                        </div>
                                      
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div> <!-- container -->
    <script>
    $(document).ready(function() {
        $('.slider-for').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            prevArrow: '<button type="button" class="slick-prev">Previous</button>',
            nextArrow: '<button type="button" class="slick-next">Next</button>',
            // Add other settings/options as needed
        });
    });
    </script>



    @endsection