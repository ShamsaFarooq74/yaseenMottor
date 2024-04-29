
@extends('layouts.admin.master')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    .header-title_vt {
        font-size: 20px !important;
    }
</style>

    <!-- Topbar Start -->
    @include('layouts.admin.blocks.inc.topnavbar')

<div class="container-fluid mt-3">
    {{--        @include('admin.alert-message')--}}

{{--    <div class="row">--}}
{{--        <meta name="csrf-token" content="{{ csrf_token() }}"/>--}}
{{--        <div class="col-6">--}}
{{--            <a href="{{ $path }}" download>{{$fileName }}</a>--}}
{{--        </div>--}}
{{--        <div class="col-6">--}}
{{--            <label for="exampleFormControlSelect1">Upload File</label>--}}
{{--            <div class="file-upload">--}}
{{--                <input type="file" id="parts-data-file" name="partFile"--}}
{{--                       onchange="readURL(this);">--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <button type="button" class="btn_to_vt" onclick="addUploadedFile()">Submit</button>--}}
{{--        <div id="dataStatus" class="spinner-border text-primary" role="status" style="display: none">--}}
{{--            <span class="sr-only">Loading...</span>--}}
{{--        </div>--}}
{{--        <div class="spinner-border" role="status">--}}
{{--            <span class="sr-only">Loading...</span>--}}
{{--        </div>--}}
    </div>
    <div class="container-fluid mt-3">
        <div class="alert alert-success" style="display: none" id="alert-success-message">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> xyz
        </div>

        <div class="row">
            <div class="col-xl-3">
                <div class="page_left_bar">
                    <a href="{{route('settings.category')}}"> Categories </a>
                    <a href="{{route('settings.make')}}"> Make</a>
                    <a  href="{{route('settings')}}"> Model</a>
                     <a href="{{route('settings.feature')}}"> Features </a>
                    <a class="active" href="{{route('settings.files')}}"> Files</a>
                </div>
            </div>
            <div class="col-xl-9">
            <div class="row">
                <meta name="csrf-token" content="{{ csrf_token() }}"/>
                <div class="col-md-6">
                    <div class="card p-3">
                        <h4 class="header-title_vt mb-3 pl-2"><i class="fas fa-file-csv" style="font-size:18px"></i> Import parts data</h4>
                        <label for="exampleFormControlSelect1">Upload File</label>
                        <div class="file-upload">
                            <input type="file" id="parts-data-file" name="partFile"
                                onchange="readURL(this);">
                        </div>
                        <button type="button" class="btn_to_vt mt-2" onclick="addUploadedFile()">Submit</button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card p-3">
                        <h4 class="header-title_vt mb-3 pl-2">Sample CSV File for Uploading Parts</h4>
                        <a class="btn_to_vt mt-2 text-center m-4" href="{{ $path }}" download style="line-height: 35px;">Download File</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card p-3">
                        <h4 class="header-title_vt mb-3 pl-2"><i class="fa fa-refresh fa-spin" style="font-size:18px"></i> Update Part's Prices</h4>
                        <label for="exampleFormControlSelect1">Upload File</label>
                        <div class="file-upload">
                            <input type="file" id="parts-data-file1" name="partFile1"
                                onchange="readURL(this);">
                        </div>
                        <button type="button" class="btn_to_vt mt-2"  data-toggle="modal" data-target="#exampleModalCenter">Submit</button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card p-3">
                        <h4 class="header-title_vt mb-3 pl-2">Sample CSV File for Updating Part's Prices</h4>
                        <a class="btn_to_vt mt-2 text-center m-4" href="{{ $partPrice }}" download style="line-height: 35px;">Download File</a>
                    </div>
                </div>
                <div id="dataStatus" class="spinner-border text-primary" role="status" style="display: none">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <!-- end row -->
        </div> <!-- container -->
    </div>
    <!-- Modal -->
    </div><!-- /.modal -->
        <div class="modal fade approveModal" id = "exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <input type="hidden" id="approveOrderID">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <i class="fas fa-exclamation"></i>
                <h4 class="model-heading-vt">Are you sure to update <br>Part's Prices ?</h4>
                <div class="modal-footer">
                    <button type="button" class="btn_create_vt approveConfirm" onclick="updateUploadedFile()">Yes</button>
                    <button type="button" class="btn_close_vt" data-dismiss="modal" id="lead-cancel">Close</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    var inputData;
    function readURL(input) {
        // console.log('okkk' + input.value)
        // if (this.value) {
        var ext = input.value.match(/\.(.+)$/)[1];
        switch (ext.toLowerCase()) {
            case 'csv':
                break;
            default:
                alert('This is not an allowed file type.Please try again!');
                input.value = '';
        }
        inputData = input.files.length;

        // console.log(input.files.length)
        // }
        // if (input.files) {
        //     var filesAmount = input.files.length;
        //     for (i = 0; i < filesAmount; i++) {
        //         var reader = new FileReader();
        //
        //         reader.onload = function (e) {
        //             let image = "<li><img src='" + e.target.result + "' width='50' height='50' alt=''> </li>";
        //             $("#partsImages").append(image);
        //         }
        //         reader.readAsDataURL(input.files[i]);
        //     }
        // }
    }
    function addUploadedFile()
    {
        if (inputData > 0)
        {
            var formData = new FormData();
            var totalfiles = document.getElementById('parts-data-file').files.length;
            for (var index = 0; index < totalfiles; index++) {
                formData.append("partFile", document.getElementById('parts-data-file').files[index]);
            }
            document.getElementById('dataStatus').style.display = 'inline'
            $.ajax({
                url: '{{route('parts.data.add')}}',
                type: 'post',
                dataType: 'json',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (response) {

                    if (response.status) {

                        document.getElementById('dataStatus').style.display = 'none';
                        document.getElementById('parts-data-file').value = '';
                        // swal("File Imported Successfully!")
                        // .then(function() {
                        //     window.location = "redirectURL";
                        // });
                        if(confirm("File Imported Successfully!")){
                            window.location='/parts';
                        }
                        // swal.close()
                        // swal.close(function(){ window.location='/parts' });

                    }else
                    {
                        if(confirm("File could not be import!.Please try again")){
                                window.location='/settings/files/view';
                        }

                    }

                }
            });
        }
    }
   
    function updateUploadedFile()
    {
        // document.getElementById("exampleModalCenter").style.display = "none";
        $("#exampleModalCenter .close").click()
        if (inputData > 0)
        {
            var formData = new FormData();
            var totalfiles = document.getElementById('parts-data-file1').files.length;
            for (var index = 0; index < totalfiles; index++) {
                formData.append("partFile1", document.getElementById('parts-data-file1').files[index]);
            }
            document.getElementById('dataStatus').style.display = 'inline'
            $.ajax({
                url: '{{route('parts.data.update')}}',
                type: 'post',
                dataType: 'json',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (response) {

                    if (response.status) {

                        document.getElementById('dataStatus').style.display = 'none';
                        document.getElementById('parts-data-file').value = '';
                        // swal("File Imported Successfully!")
                        // .then(function() {
                        //     window.location = "redirectURL";
                        // });
                        if(confirm("File Imported Successfully!")){
                            window.location='/parts';
                        }
                        // swal.close()
                        // swal.close(function(){ window.location='/parts' });

                    }else
                    {
                        if(confirm("File could not be import!.Please try again")){
                                window.location='/settings/files/view';
                        }

                    }

                }
            });
        }
    }
</script>
@endsection
