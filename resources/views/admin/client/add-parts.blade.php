@extends('layouts.admin.master')
@section('content')

<!-- Topbar Start -->
@include('layouts.admin.blocks.inc.topnavbar')
<style>
.boxq [type="checkbox"]:not(:checked),
.boxq [type="checkbox"]:checked {
    position: absolute;
    left: -9999px;
}

.boxq [type="checkbox"]:not(:checked)+label,
.boxq [type="checkbox"]:checked+label {
    position: relative;
    padding-left: 2.95em;
    cursor: pointer;
    padding-top: 2px;
}

.boxq [type="checkbox"]:not(:checked)+label:before,
.boxq [type="checkbox"]:checked+label:before {
    content: '-';
    position: absolute;
    top: .1em;
    left: .2em;
    font-size: 50px;
    width: 80px;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 80px;
    padding-bottom: 0px;
    line-height: 0.8;
    color: black;
    border: 2px solid #ccc;
    background: #ccc;
    border-radius: 0px;
    box-shadow: inset 0 1px 3px rgb(0 0 0 / 10%);
    opacity: 0.1;
    margin: 0 15px;
}

.boxq [type="checkbox"]:not(:checked)+label:after,
.boxq [type="checkbox"]:checked+label:after {
    /* content: '✔'; */
    content: '-';
    position: absolute;
    top: .1em;
    left: .2em;
    font-size: 50px;
    width: 80px;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 80px;
    padding-bottom: 0px;
    line-height: 0.8;
    color: #fff;
    background: #f00;
    transition: all .2s;
    margin: 0 15px;
}

.boxq [type="checkbox"]:not(:checked)+label:after {
    opacity: 0;
    transform: scale(0);
}

.boxq [type="checkbox"]:checked+label:after {
    opacity: 1;
    transform: scale(1);
}

.boxq [type="checkbox"]:disabled:not(:checked)+label:before,
.boxq [type="checkbox"]:disabled:checked+label:before {
    box-shadow: none;
    border-color: #bbb;
    background-color: #ddd;
}

.boxq [type="checkbox"]:disabled:checked+label:after {
    color: #999;
}

.boxq [type="checkbox"]:disabled+label {
    color: #aaa;
}

.boxq [type="checkbox"]:checked:focus+label:before,
.boxq [type="checkbox"]:not(:checked):focus+label:before {
    border: 2px dotted blue;
}

.boxq label:hover:before {
    border: 2px solid #ccc !important;
}


body {
    font-family: "Open sans", "Segoe UI", "Segoe WP", Helvetica, Arial, sans-serif;
    color: #777;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #e02329 !important;
    padding-right: 7px;
    padding-left: 26px;
    /*padding: 2px !important;*/
}

.switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
}

.slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
}

input:checked+.slider {
    background-color: #2196F3;
}

input:focus+.slider {
    box-shadow: 0 0 1px #2196F3;
}

input:checked+.slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
    border-radius: 34px;
}

.slider.round:before {
    border-radius: 50%;
}
</style>
<!-- end Topbar -->

<!-- Start Content-->
<div class="container-fluid mt-3">
    <div class="row">
        <div class="col-md-3">
            <div class="page_left_bar">
                <a href="{{route('sellers.parts')}}"> All Cars</a>
                <a href="{{route('sellers.parts.add')}}" class="active">Add Car</a>
                <!-- <a href="{{route('sellers.parts.export')}}"> Export Car</a> -->
                <a href="{{route('trends.parts')}}"> Top Featured Cars</a>
            </div>
        </div>

        <div class="col-md-9">
            <div class="add_plants_vt">


                <form class="card p-2">
                    <meta name="csrf-token" content="{{ csrf_token() }}" />
                    <div class="row">
                        <div class="col-md-12">
                            @if($partId)
                            <h3 class="page_head_vt">Update Car</h3>
                            @else
                            <h3 class="page_head_vt">Add Car</h3>
                            @endif
                        </div>
                        @if($partId)
                        <input type="hidden" id="{{$partId}}" name="partId" class="addPart">
                        @else
                        <input type="hidden" class="addPart">
                        @endif
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="feature-parts1212">Features<span class="star_vt">*</span></label>
                                <select class="multiple_select form-control" id="feature-parts1212" name="feature"
                                    multiple>
                                    <option  value="" disabled >Select Feature</option>
                                    @foreach($features as $key => $feature)
                                    <option value='{{$feature->id}}'>{{$feature->feature}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Reference No<span
                                        class="star_vt">*</span></label>
                                <input class="form-control" id="parts-number" type="text" placeholder="A4470"
                                    name="part_number">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="registration">Registration Date<span class="star_vt">*</span></label>
                                <input class="form-control" id="parts-registration" type="text" placeholder="03-2013"
                                    name="parts-registration">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="parts-manufacture">Manufacturer Date<span class="star_vt">*</span></label>
                                <input class="form-control" id="parts-manufacture" type="text" placeholder="12-2006"
                                    name="parts-manufacture">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="subRef">Sub Ref No<span class="star_vt">*</span></label>
                                <input class="form-control" id="parts-subref" type="text" placeholder="Sub Ref No"
                                    name="subRef">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="engineSize">Engine Size<span class="star_vt">*</span></label>
                                <input class="form-control" id="parts-engineSize" type="text" placeholder="1200cc"
                                    name="subRef">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="make-parts1212">Make<span class="star_vt">*</span></label>
                                <select class="form-control" id="part-make" name="make">
                                    @foreach($make as $key => $makes)
                                    <option value='{{$makes->id}}'>{{$makes->make}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mode_code">Model code<span class="star_vt">*</span></label>
                                <select class="form-control" id="parts-modelcode" name="model_code">
                                    @foreach($model as $key => $models)
                                    <option value="{{$models->id}}">{{$models->model_code}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="country">Country<span class="star_vt">*</span></label>
                                <select class="form-control" id="parts-country" name="country">
                                    @foreach($countries as $key => $country)
                                    <option value='{{$country->id}}'>{{$country->country_name}}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="location">location<span class="star_vt">*</span></label>
                                <select class="form-control" id="parts-location" name="location">
                                    @foreach($cities as $key => $city)
                                    <option value='{{$city->id}}'>{{$city->city_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bodyType">Body Type<span class="star_vt">*</span></label>
                                <select class="form-control" id="parts-bodyType" name="bodyType">
                                    @foreach($bodyTypes as $key =>$type )
                                    <option value='{{$type->id}}'>{{$type->body_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="steering">Steering<span class="star_vt">*</span></label>
                                <select class="form-control" id="parts-steering" name="steering">
                                    <option value="left">Left</option>
                                    <option value="right">Right</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="engine">Engine Code<span class="star_vt">*</span></label>
                                <input class="form-control" id="parts-engine" type="text" placeholder="4B11"
                                    name="engine">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="color">Color<span class="star_vt">*</span></label>
                                <input class="form-control" id="parts-color" type="text" placeholder="color"
                                    name="color">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="chasis">Chasis #<span class="star_vt">*</span></label>
                                <input class="form-control" id="parts-chasis" type="text" placeholder="CZ4A-0600514"
                                    name="chasis">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="version">Version/Class<span class="star_vt">*</span></label>
                                <input class="form-control" id="parts-version" type="text"
                                    placeholder="240G L PACKAGE PRIME SELECTION" name="version">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="m3">M3<span class="star_vt">*</span></label>
                                <input class="form-control" id="parts-m3" type="text" placeholder="14.621" name="m3">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dimension">Dimension<span class="star_vt">*</span></label>
                                <input class="form-control" id="parts-dimension" type="text"
                                    placeholder="4.73×1.84×1.68 m" name="dimension">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fuel">Fuel<span class="star_vt">*</span></label>
                                <select class="form-control" id="parts-fuel" name="fuel">
                                    @foreach($fuelTypes as $key => $fuelType)
                                    <option value='{{$fuelType->id}}'>{{$fuelType->fuel_type}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mileage">Mileage<span class="star_vt">*</span></label>
                                <input class="form-control" id="parts-mileage" type="text" placeholder="161,71 KM"
                                    name="mileage">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="weight">Weight<span class="star_vt">*</span></label>
                                <input class="form-control" id="parts-weight" type="text" placeholder="1,550 Kg"
                                    name="weight">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="maxcap">Cap<span class="star_vt">*</span></label>
                                <input class="form-control" id="parts-loadcap" type="text" placeholder="load-cap"
                                    name="load_cap">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="seats">Seats<span class="star_vt">*</span></label>
                                <select class="form-control" id="parts-seats" name="seats">
                                    <option value="2">2 seats</option>
                                    <option value="4">4 seats</option>
                                    <option value="6">6 seats</option>
                                    <option value="8">8 seats</option>
                                    <option value="10">10 seats</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="door">Doors<span class="star_vt">*</span></label>
                                <select class="form-control" id="parts-door" name="door">
                                    <option value="2">2 doors</option>
                                    <option value="4">4 doors</option>
                                    <option value="6">6 doors</option>
                                    <option value="8">8 doors</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="drive">Drive<span class="star_vt">*</span></label>
                                <select class="form-control" id="parts-drive" name="drive">
                                    <option value="2WD">2WD</option>
                                    <option value="4WD">4WD</option>
                                    <option value="6WD">6WD</option>
                                    <option value="8WD">8WD</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="transmission">Transmission<span class="star_vt">*</span></label>
                                <select class="form-control" id="parts-transmission" name="transmission">
                                    <option value="automatic">Automatic</option>
                                    <option value="manual">Manual</option>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Price<span class="star_vt">*</span></label>
                                <input class="form-control" id="parts-price" type="number" placeholder="35,000"
                                    name="price">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Price Off<span class="star_vt">*</span></label>
                                <input class="form-control" id="parts-priceoff" type="number" placeholder="0.01"
                                    name="priceoff" min="1" max="100" step="0.01">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5>Is Stock<span class="star_vt">*</span></h5>
                            <div class="form-group d-flex justify-content-center">
                                <label class="switch">
                                    <input type="checkbox" id="isStock" name="isStock">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="parts-status">Status<span class="star_vt">*</span></label>
                                <select class="form-control" id="parts-status" name="status">
                                    <option value='1'>Active</option>
                                    <option value='0'>InActive</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="parts-currency">Currency<span class="star_vt">*</span></label>
                                <select class="form-control" id="parts-currency" name="currency">
                                    @foreach($currency as $key => $currecies)
                                    <option value='{{$currecies->id}}'>{{$currecies->currency}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- <div class="col-md-6">
                            <div class="form-group">
                            <label for="isStock">Featured Car<span class="star_vt">*</span></label> 
                            <div class="d-flex justify-content-center">
                            <input type="checkbox" id="isStock" name="isStock">
                            <span class=""></span>
                             </div>
                          </div>
                        </div> -->
                    </div>

                    <!-- <div class="col-md-12">
                        <div class="form-group">
                            <label for="parts-description">Description<span class="star_vt">*</span></label>
                            <textarea class="form-control" type="text" placeholder="Enter Description"
                                id="parts-description" rows="3" name="description"></textarea>
                        </div>
                    </div> -->

                    <div class="col-md-12 mt-3 mb-3">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Upload Images<span class="star_vt">*</span></label>
                            <div class="file-upload">
                                <input type="file" id="parts-images-files" multiple name="files[]"
                                    onchange="readURL(this);" value="{{old('files[]')}}">
                            </div>
                        </div>
                        <div class="col-md-12 img_upload">
                            <div class="form-group">
                                <div class="img_vt_add">
                                    <ul id="partsImages">
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @if($partId)
                        <div class="col-md-12 mt-3">
                            <label for="exampleFormControlFile1" id="remove-part-images-data">Remove Images</label>
                            <input type="hidden" id="imagesDataArray" name="imagesArrays[]">
                            <div class="form-group" id="part-check-box-fields" style="display: flex">
                            </div>
                        </div>
                        <div class="col-md-12 img_upload">
                            <div class="form-group">
                                <div class="img_vt_add">
                                    <ul id="partsImagesss">
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if(!$partId)
                        <div style="display: none" class="col-md-12 mt-3">
                            <label for="exampleFormControlFile1" id="remove-part-images-data">Remove Images</label>
                            <input type="hidden" id="imagesDataArray" name="imagesArrays[]">
                            <div class="form-group" id="part-check-box-fields">
                            </div>
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label for="videolink">Video Links<span class="star_vt">*</span></label>
                                    <input class="form-control" id="videolink" name="videolink" type="text"
                                        placeholder="Enter video links">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="button_bt_area" onclick="addVideo()"><i
                                        class="fa fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="col-12 mb-2" id="videolink-fields-error" style="display: none">
                            <span class="text-danger">Please fill out all above fields</span>
                        </div>
                    </div>
                    {{--                            <input type="hidden" id="model-parts-iddd" name="modelParts[]">--}}
                    <div class="col-md-12 tabs_vt_parts">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Sr.</th>
                                    <th scope="col">video Links</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="videolink-table99">
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-8"></div>
                    <div class="col-md-4">
                        <div class="form-group mb-0 text-center d-flex">
                            <button class="btn_cancel_vt"> Cancel
                            </button>
                            @if(!$partId)
                            <button class="btn_to_vt" type="button" onclick="addParts()"> Add Car
                            </button>
                            @else
                            <button class="btn_to_vt" type="button" onclick="addParts()"> Update Car
                            </button>
                            @endif

                        </div>
                    </div>
                    <div class="col-12">
                        <div class="alert alert-success" style="display: none" id="alert-success-message">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> xyz
                        </div>
                        <div class="alert alert-danger" style="display: none" id="alert-error-message">
                            {{--                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('errors') }}--}}
                        </div>
                    </div>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- end row -->
</div> <!-- container -->

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('#parts-country').on('change', function() {
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

                    $('#parts-location').empty();
                    $('#parts-location').append(
                        '<option value="" selected disabled>--Choose location--</option>'
                    );
                    $.each(data, function(key, location) {
                        $('#parts-location').append('<option value="' + location
                            .id +
                            '">' + location.city_name + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        } else {
            $('#parts-location').empty();
            $('#parts-location').prop('disabled', true);
        }
    });
});
</script>
<script>
// Find the toggle button elements
const toggleButtons = document.querySelectorAll('.toggle-button');

// Attach click event listeners to toggle buttons
toggleButtons.forEach((toggleButton) => {
    const hiddenInput = toggleButton.querySelector('input');

    toggleButton.addEventListener('click', () => {
        hiddenInput.value = hiddenInput.value === '1' ? '0' : '1';
    });
});
</script>
<script>
$(document).ready(function() {
    $('.multiple_select').select2();
});

var featureArray = [];
var dataArray = [];
let element = document.getElementsByClassName('addPart');

function addVideo() {
    let videolink = document.getElementById('videolink').value;
    if (!videolink) {
        document.getElementById('videolink-fields-error').style.display = 'block';
        return;
    } else {
        document.getElementById('videolink-fields-error').style.display = 'none';
    }
    dataArray.push({
        'videolink': videolink,
    });
    $('#videolink-table99').empty();
    for (let i = 0; i < dataArray.length; i++) {
        let tableData = ` <tr>
                                    <th scope="row">${i + 1}</th>
                                    <td>${dataArray[i]['videolink']}</td>
                                    <td><i class="fa fa-times" onclick="deleteIndex(${i})" style="cursor: pointer"></i></td>
                                </tr>`;
        $('#videolink-table99').append(tableData);
    }
}

function deleteIndex(index) {
    dataArray.splice(index, 1);
    $('#videolink-table99').empty();
    for (let i = 0; i < dataArray.length; i++) {
        let tableData = ` <tr>
                                    <th scope="row">${i + 1}</th>
                                    <td>${dataArray[i]['videolink']}</td>
                                    <td><i class="fa fa-times" onclick="deleteIndex(${i})" style="cursor: pointer"></i></td>
                                </tr>`;
        $('#videolink-table99').append(tableData);
    }
}

function readURL(input) {
    if (input.files) {
        var filesAmount = input.files.length;
        for (i = 0; i < filesAmount; i++) {
            var reader = new FileReader();

            reader.onload = function(e) {
                let image = "<li><img src='" + e.target.result + "' width='50' height='50' alt=''> </li>";
                $("#partsImages").append(image);
            }
            reader.readAsDataURL(input.files[i]);
        }
    }
}

$('#feature-parts1212').change(function() {
    let value = $(this).val();
    featureArray = value;
});

function readImages() {
    if (confirm('Your all files will be removed.Are you sure you want to proceed ?')) {
        let parent = document.getElementById('partsImages');
        parent.innerHTML = '';
    }
}

let idExists = element[0].hasAttribute('id');
if (idExists) {
    let id = element[0].getAttribute('id')
    $.ajax({
        url: "{{ route('part.edit') }}",
        type: 'get',
        dataType: 'json',
        data: {
            'id': id
        },
        success: function(response) {
            console.log(response.data['videolink']);
            if (response.status) {
                $('#parts-number').val(response.data['ref_no']);
                // $('#parts-registration').val(response.data['reg_no']);
                let originalReg = response.data['reg_no'];
                let years = originalReg.split('-')[0];
                let months = originalReg.split('-')[1];

                let yearMonths = `${parseInt(months)}-${years}`;
                console.log(yearMonths);
                $('#parts-registration').val(yearMonths);
                $('#part-make').val(response.data['make_id']);
                $('#parts-modelcode').val(response.data['model_id']);
                // $('#parts-manufacture').val(response.data['manufacturer']);
                let originalValue = response.data['manufacturer'];
                let year = originalValue.split('-')[0];
                let month = originalValue.split('-')[1];

                let yearMonth = `${parseInt(month)}-${year}`;
                console.log(yearMonth);
                $('#parts-manufacture').val(yearMonth);

                $('#parts-transmission').val(response.data['transmission']);
                $('#parts-location').val(response.data['city_id']);
                $('#parts-bodyType').val(response.data['body_type_id']);
                $('#parts-country').val(response.data['country_id']);
                $('#parts-steering').val(response.data['steering']);
                $('#parts-engine').val(response.data['engine_code']);
                $('#parts-engineSize').val(response.data['engine_size']);
                $('#parts-subref').val(response.data['sub_ref_no']);
                $('#parts-color').val(response.data['color']);
                $('#parts-chasis').val(response.data['chasis']);
                $('#parts-version').val(response.data['version']);
                $('#parts-m3').val(response.data['m3']);
                $('#parts-dimension').val(response.data['dimension']);
                $('#parts-fuel').val(response.data['fuel_id']);
                $('#parts-mileage').val(response.data['mileage']);
                $('#parts-weight').val(response.data['weight']);
                $('#parts-loadcap').val(response.data['load_cap']);
                $('#parts-seats').val(response.data['seats']);
                $('#parts-door').val(response.data['door']);
                $('#parts-drive').val(response.data['drivetrain']);
                $('#parts-currency').val(response.data['currency_id']);
                $('#parts-price').val(response.data['price']);
                $('#parts-priceoff').val(response.data['price_off']);
                // $('#parts-description').val(response.data['description']);
                let partfeature = document.getElementById('feature-parts1212').childNodes;

                for (let l = 0; l < partfeature.length; l++) {
                    var feature = response.data['feature'];
                    console.log(feature);
                    for (let i = 0; i < feature.length; i++) {
                        $('#feature-parts1212 option[value="' + feature[i] + '"]').attr(
                            "selected", "selected");
                        $('#feature-parts1212').trigger('change');
                    }
                    for (let m = 0; m < feature.length; m++) {
                        var obj1 = Object.values(feature)[m];
                        if (obj1 === partfeature[l].text) {
                            console.log(partfeature[l].text);
                            partfeature[l].selected = true;

                        }
                    }
                }

                let partStatus = document.getElementById('parts-status').childNodes;
                if (response.data['is_active'] === 1) {
                    response.data['is_active'] = 'Active';
                } else {
                    response.data['is_active'] = 'InActive';
                }

                for (let l = 0; l < partStatus.length; l++) {
                    if (response.data['is_active'] === partStatus[l].text) {
                        partStatus[l].selected = 'selected';
                    }
                }

                if (response.data['is_stock'] == 1) {
                    document.getElementById('isStock').checked = true;
                } else {
                    document.getElementById('isStock').checked = false;
                }

                document.getElementById('part-check-box-fields').innerHTML = '';
                if (response.data['images'].length > 0) {
                    document.getElementById("remove-part-images-data").style.display = 'inline';
                } else {
                    document.getElementById("remove-part-images-data").style.display = 'none';
                }
                for (let i = 0; i < response.data['images'].length; i++) {
                    // console.log(response.data['images'][i]['image']);
                    let array = response.data['images'][i]['image'].split('/');
                    let checkBoxData =
                        `<div class="form-group boxq" style="display: flex; position: relative;"> <li style="list-style: none"><img style="margin: 0 15px;" src="${response.data['images'][i]['image']}" width='80' height='80' alt=''> </li><input  onclick="checkedImages(this.checked,${response.data['images'][i]['id']},this)" type="checkbox" value="${response.data['images'][i]['id']}" id='partsImage${response.data['images'][i]['id']}'>
                             <label style="position: absolute; top: -5px; left: -9px;" for="partsImage${response.data['images'][i]['id']}"></label> </div>`;
                    $("#part-check-box-fields").append(checkBoxData);
                }
                console.log(response.data['videolink']);

                for (let i = 0; i < response.data['videolink'].length; i++) {
                    dataArray.push({

                        'videolink': response.data['videolink'][i]['videolink'],
                    });
                    let tableData = ` <tr>
                                    <th scope="row">${i + 1}</th>
                                    <td>${response.data['videolink'][i]['videolink']}</td>
                                    <td><i class="fa fa-times" onclick="deleteIndex(${i})" style="cursor: pointer"></i></td>
                                </tr>`;
                    $('#videolink-table99').append(tableData);
                }
            } else {}

        }
    });
}

let imagesArray = [];


function checkedImages(checked, id, checkbox) {
    document.getElementById('alert-success-message').style.display = 'none';
    document.getElementById('alert-error-message').style.display = 'none';

    if (checked) {
        checkbox.classList.remove('boxq');

        // Provide the actual URL for the delete image route
        const url = "/delete-image/" + id;

        $.ajax({
            url: url,
            method: 'DELETE',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response) {
                if (response.status) {
                    document.getElementById('alert-success-message').style.display = 'block';
                    $('#alert-success-message').text(response.message);
                } else {
                    document.getElementById('alert-error-message').style.display = 'block';
                    $('#alert-error-message').text(response.message);
                }
                // You can add more code here if needed
            },
            error: function(xhr, status, error) {
                var responseJSON = xhr.responseJSON;
                console.error('Error:', error);
                // You can handle the error response as needed
            }
        });
    } else {
        const index = imagesArray.indexOf(id);
        if (index !== -1) {
            imagesArray.splice(index, 1);
        }

        checkbox.classList.add('boxq');

        document.getElementById('imagesDataArray').setAttribute('value', imagesArray);
    }
}

// function checkedImages(checked, id, checkbox) {
//     if (checked) {
//         checkbox.removeAttribute('class');
//         checkbox.setAttribute('class', 'boxq');
//     }
//     let check = imagesArray.includes(id);
//     if (checked && !check) {
//         imagesArray.push(id);
//     } else {
//         for (let i = 0; i < imagesArray.length; i++) {
//             if (imagesArray[i] === id) {
//                 imagesArray.splice(i, 1);
//             }
//         }
//     }
//     document.getElementById('imagesDataArray').setAttribute('value', imagesArray);
// }




document.getElementById('imagesDataArray').setAttribute('value', imagesArray);

function addParts() {
    let partsFiles = document.getElementById('parts-images-files').files;
    let partNumber = document.getElementById('parts-number').value;
    let partmake = document.getElementById('part-make').value;
    let features = featureArray;
    let partRegistration = document.getElementById('parts-registration').value;
    let partmodelcode = document.getElementById('parts-modelcode').value;
    let partcountry = document.getElementById('parts-country').value;
    let partlocation = document.getElementById('parts-location').value;
    let partbodytype = document.getElementById('parts-bodyType').value;
    let manufacturer = document.getElementById('parts-manufacture').value;
    let transmission = document.getElementById('parts-transmission').value;
    let steering = document.getElementById('parts-steering').value;
    let engine = document.getElementById('parts-engine').value;
    let engineSize = document.getElementById('parts-engineSize').value;
    let subref = document.getElementById('parts-subref').value;
    let color = document.getElementById('parts-color').value;
    let chasis = document.getElementById('parts-chasis').value;
    let version = document.getElementById('parts-version').value;
    let pM3 = document.getElementById('parts-m3').value;
    let dimension = document.getElementById('parts-dimension').value;
    let fuel = document.getElementById('parts-fuel').value;
    let weight = document.getElementById('parts-weight').value;
    let mileage = document.getElementById('parts-mileage').value;
    let loadcap = document.getElementById('parts-loadcap').value;
    let seats = document.getElementById('parts-seats').value;
    let doors = document.getElementById('parts-door').value;
    let drive = document.getElementById('parts-drive').value;
    let currency = document.getElementById('parts-currency').value;
    let price = document.getElementById('parts-price').value;
    let priceoff = document.getElementById('parts-priceoff').value;
    // let description = document.getElementById('parts-description').value;
    let status = document.getElementById('parts-status').value;
    let isStock = document.getElementById('isStock').checked;
    console.log(partsFiles.length);
    let partImageArray = document.getElementById('imagesDataArray').value;
    let images = [];
    for (let i = 0; i < partsFiles.length; i++) {
        var tmppath = URL.createObjectURL(partsFiles[i]);
        images.push(tmppath)
    }
    var formData = new FormData();
    var totalfiles = document.getElementById('parts-images-files').files.length;
    for (var index = 0; index < totalfiles; index++) {
        formData.append("files[]", document.getElementById('parts-images-files').files[index]);
    }
    let element = document.getElementsByClassName('addPart');
    let idExists = element[0].hasAttribute('id');
    var partId = '';
    if (idExists) {
        partId = element[0].getAttribute('id')
    }
    formData.append("ref_no", partNumber);
    formData.append("reg_no", partRegistration);
    formData.append("engine_size", engineSize);
    formData.append("sub_ref_no", subref);
    formData.append("modelcode", partmodelcode);
    formData.append("country", partcountry);
    formData.append("features", features);
    formData.append("location", partlocation);
    formData.append("body_type_id", partbodytype);
    formData.append("manufacturer", manufacturer);
    formData.append("transmission", transmission);
    formData.append("steering", steering);
    formData.append("engine", engine);
    formData.append("color", color);
    formData.append("chasis", chasis);
    formData.append("version", version);
    formData.append("pM3", pM3);
    formData.append("dimension", dimension);
    formData.append("fuel", fuel);
    formData.append("weight", weight);
    formData.append("mileage", mileage);
    formData.append("loadcap", loadcap);
    formData.append("seats", seats);
    formData.append("doors", doors);
    formData.append("drive", drive);
    formData.append("make", partmake);
    formData.append("currency", currency);
    formData.append("price", price);
    formData.append("priceoff", priceoff);
    formData.append("status", status);
    formData.append("isStock", isStock);
    // formData.append("description", description);
    formData.append("partId", partId);
    formData.append("videoData", JSON.stringify(dataArray));
    formData.append("imagesArrayData", JSON.stringify(imagesArray));
    document.getElementById('alert-success-message').style.display = 'none';
    document.getElementById('alert-error-message').style.display = 'none';
    $.ajax({
        url: '{{route('parts.add')}}',
        type: 'post',
        dataType: 'json',
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.status) {
                document.getElementById('alert-success-message').style.display = 'block';
                $('#alert-success-message').empty()
                let message =
                    ` <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> ${response.message}`;
                $('#alert-success-message').append(message);
                // location.reload(true);
                window.location = '{{ route('sellers.parts')}}';
            } else {
                document.getElementById('alert-error-message').style.display = 'block';
                $('#alert-error-message').empty()
                let message =
                    ` <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> ${response.message}`;
                $('#alert-error-message').append(message);
            }
        }
    });
}
</script>

<script>
$('#parts-registration, #parts-manufacture').datepicker({
    format: "mm-yyyy",
    startView: "months",
    minViewMode: "months",
    autoclose: true
});
</script>

@endsection