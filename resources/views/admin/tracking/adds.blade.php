@extends('layouts.admin.master')
@section('content')

    <!-- Topbar Start -->
    @include('layouts.admin.blocks.inc.topnavbar')
    <!-- end Topbar -->

    <!-- Start Content-->
    <div class="container-fluid mt-3">
        <!-- @include('admin.alert-message') -->
        <div class="row">
            <div class="col-xl-12 home_custome_table">
                <div class="card-box home_table">
                    <h4 class="header-title_vt mb-3 pl-2">Banner Listing</h4>
                    <div class="card_tabs_vt">
                        <ul class="nav nav-tabs nav-bordered" id="addAds">
                            <li class="nav-item">
                                <a href="#home-b1" data-toggle="tab" aria-expanded="false" class="nav-link active" id="adListing">
                                   Banner  Listing
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#profile-b1" data-toggle="tab" aria-expanded="true" class="nav-link " id="createAd">
                                    Create Banner
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-tabs nav-bordered" id="editAds">
                            <li class="nav-item">
                                <a href="#home-b1" data-toggle="tab" aria-expanded="false" class="nav-link active" id="editListing" onclick="editListing()">
                                    Banners Listing
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#profile-b1" data-toggle="tab" aria-expanded="true" class="nav-link " id="editAd">
                                    Edit Banner
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane show active" id="home-b1">
                                <div class="slider_adds_vt">
                                    <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner" role="listbox">
                                                                                    @for($i=0;$i<count($ads);$i++)
                                                                                        @if($i== 0)
                                                                                            <?php $adTime = 3 ?>
                                                                                    <div class="carousel-item active" data-interval="{{$adTime}}">
                                                                                        <img class="d-block img-fluid" src="{{$ads[$i]['image']}}" alt="First slide" />
                                                                                    </div>

                                                                                        @else
                                                                                    <div class="carousel-item" data-interval="3000">
                                                                                        <img class="d-block img-fluid" src="{{$ads[$i]['image']}}" alt="Second slide" />
                                                                                    </div>
                                                                                        @endif

                                                                                    @endfor
                                                                                    
                                        </div>
                                        <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button"
                                           data-slide="prev">
                                            <i class="fas fa-chevron-left"></i>
                                        </a>
                                        <a class="carousel-control-next" href="#carouselExampleCaptions" role="button"
                                           data-slide="next">
                                            <i class="fas fa-chevron-right"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-borderless table-hover table-centered m-0">
                                        <thead class="thead-light">
                                        <tr>
                                            <th>Sr</th>
                                            <th>Banner</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($ads as $key => $ad)
                                            @if($ad->start_date)
                                                <tr>
                                                    <td>
                                                        {{$key + 1}}
                                                    </td>
                                                    <td>
                                                        <img src="{{$ad->image}}" alt="" width="80px">
                                                    </td>
                                                    <td>
                                                        {{$ad->start_date}}
                                                    </td>
                                                    <td>
                                                        {{$ad->end_date}}
                                                    </td>
                                                    <td>
                                                        <div class="btn-group mb-2">
                                                            <button type="button" class="btn btn_info dropdown-toggle"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">Action <i
                                                                    class="mdi mdi-chevron-down"></i></button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" id="editButton" onclick="editAds({{$ad->id}},{{json_encode($ad->start_date)}},{{json_encode($ad->end_date)}},{{json_encode($ad->image)}})">Edit</a>
                                                                <button class="dropdown-item deleteAdds" data-toggle="modal"
                                                                   data-target=".bs-example-modal-center252" data-id="{{$ad->id}}">Delete</button>
                                                            </div>
                                                        </div><!-- /btn-group -->
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @if($ads)
                                    {!! $ads->render() !!}
                                @endif
                            </div>
                            <div class="tab-pane" id="profile-b1">
                                <form id="adForm" class="card p-2" method="post" action="{{route('add.ads',['addId' => $id])}}"
                                      enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3 class="page_head_vt" id="addProductAdds">Create Banner</h3>
                                            <h3 class="page_head_vt" id="editProductAdds">Edit Banner</h3>
                                        </div>
                                        <div class="col-md-12" id="bannerImage">
                                            <div class="formgroup_vt">
                                                <img src="{{asset('assets/images/profile.png')}}" alt="" id="adImage">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1">Banner Image<span class="star_vt">*</span></label>
                                                <div class="file-upload">
                                                    <input type="file" id="myFile" name="banner-image">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group date_clock_vt">
                                                <label for="emailaddress">Start Date<span class="star_vt">*</span></label>
                                                <input class="form-control" type="date" id="startDate" required=""
                                                       placeholder="Enter" name="start_date">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group date_clock_vt">
                                                <label for="emailaddress">End Date<span class="star_vt">*</span></label>
                                                <input class="form-control" type="date" id="endDate" required=""
                                                       placeholder="Enter" name="end_date">
                                            </div>
                                        </div>
                                        <div class="col-md-11"></div>
                                        <div class="col-md-1">
                                            <div class="form-group mb-0 text-center d-flex">
                                                <button class="btn_to_vt" type="submit"> Submit
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

    </div> <!-- container -->
    <div class="modal fade bs-example-modal-center252 deleteModal" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <input type="hidden" id="dltUserID1">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <i class="fas fa-exclamation"></i>
                    <h4 class="model-heading-vt">Are you sure you want to delete <br>this Banner ?</h4>
                    <div class="modal-footer">
                        <button type="button" class="btn_create_vt deleteAdConfirm">Yes, Delete</button>
                        <button type="button" class="btn_close_vt" data-dismiss="modal" id="ad-cancel">Close</button>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>


    <script>
        document.getElementById('editAds').style.display = 'none';
        document.getElementById('editProductAdds').style.display = 'none';
        document.getElementById('bannerImage').style.display = 'none';
        $('.custom-file-input').on('change', function () {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
        $('.deleteAdds').click(function () {
            var data = $(this).attr('data-id');
            console.log(data);
            $('.deleteModal #dltUserID1').val(data);

        });
        function editAds(adId,startDate,endDate,image) {
            document.getElementById('editProductAdds').style.display = 'block';
            document.getElementById('addProductAdds').style.display = 'none';
            document.getElementById('bannerImage').style.display = 'none';
            document.getElementById('addAds').style.display = 'none';
            document.getElementById('editAds').style.display = 'block';
            let url = '{{ url("/adds/add", ":id") }}';
            url = url.replace('%3Aid', adId);
            document.getElementById('startDate').value = startDate;
            document.getElementById('endDate').value = endDate;
            document.getElementById('adForm').setAttribute('action', url);
            document.getElementById('editListing').classList.remove("active");
            document.getElementById('home-b1').style.display = 'none';
            document.getElementById('profile-b1').style.display = 'block';
            document.getElementById('editAd').classList.add("active");
            document.getElementById('adImage').removeAttribute('src');
            document.getElementById('adImage').setAttribute('src',image);
        }

        function editListing()
        {
            window.location.reload();
        }
        $('.deleteAdConfirm').click(function() {

            var id = $('.deleteModal #dltUserID1').val();
            $.ajax({
                url: 'delete-ads',
                type: 'post',
                data: {"_token": "{{csrf_token()}}",'id' : id},
                dataType: 'json',
                success: function (response) {
                    if(response.status)
                    {
                        swal("Ad Deleted Successfully!");
                        document.getElementById('ad-cancel').click();
                        setTimeout(function(){ window.location.reload() }, 2000);
                    }else
                    {
                        swal("Products could not be  deleted!");
                        document.getElementById('ad-cancel').click();
                        setTimeout(function(){ window.location.reload() }, 2000);
                    }

                }
            });
        });
    </script>

@endsection
