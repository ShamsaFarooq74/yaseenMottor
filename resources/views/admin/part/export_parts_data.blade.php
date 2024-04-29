@extends('layouts.admin.master')
@section('content')

<!-- Topbar Start -->
@include('layouts.admin.blocks.inc.topnavbar')


<div class="container-fluid mt-3">
</div>
<div class="container-fluid mt-3">
    <div class="row">
        <div class="col-xl-3">
            <div class="page_left_bar">
                <a href="{{route('sellers.parts')}}"> All Cars </a>
                <a href="{{route('sellers.parts.add')}}"> Add Car</a>
                <!-- <a href="{{route('sellers.parts.export')}}" class="active"> Export Car</a> -->
                <a href="{{route('trends.parts')}}"> Top Featured Cars</a>
            </div>
        </div>
        <div class="col-xl-9">
            <div class="row">
                <meta name="csrf-token" content="{{ csrf_token() }}" />
                <div class="col-md-12">
                    <div class="card p-3">
                        <h4 class="header-title_vt mb-3">Export Non Image Cars Data</h4>
                        <a class="btn_to_vt mt-2 text-center my-4 col-md-4" href="{{route('sellers.parts.export.csv')}}"
                            download style="line-height: 35px;">Export Non Image Cars File</a>
                    </div>
                </div>
                <div id="dataStatus" class="spinner-border text-primary" role="status" style="display: none">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <!-- end row -->
        </div> <!-- container -->
    </div>

    {{--        <script>--}}
    {{--            var inputData;--}}
    {{--            function readURL(input) {--}}
    {{--                // console.log('okkk' + input.value)--}}
    {{--                // if (this.value) {--}}
    {{--                var ext = input.value.match(/\.(.+)$/)[1];--}}
    {{--                switch (ext.toLowerCase()) {--}}
    {{--                    case 'csv':--}}
    {{--                        break;--}}
    {{--                    default:--}}
    {{--                        alert('This is not an allowed file type.Please try again!');--}}
    {{--                        input.value = '';--}}
    {{--                }--}}
    {{--                inputData = input.files.length;--}}

    {{--                // console.log(input.files.length)--}}
    {{--                // }--}}
    {{--                // if (input.files) {--}}
    {{--                //     var filesAmount = input.files.length;--}}
    {{--                //     for (i = 0; i < filesAmount; i++) {--}}
    {{--                //         var reader = new FileReader();--}}
    {{--                //--}}
    {{--                //         reader.onload = function (e) {--}}
    {{--                //             let image = "<li><img src='" + e.target.result + "' width='50' height='50' alt=''> </li>";--}}
    {{--                //             $("#partsImages").append(image);--}}
    {{--                //         }--}}
    {{--                //         reader.readAsDataURL(input.files[i]);--}}
    {{--                //     }--}}
    {{--                // }--}}
    {{--            }--}}
    {{--            function addUploadedFile()--}}
    {{--            {--}}
    {{--                if (inputData > 0)--}}
    {{--                {--}}
    {{--                    var formData = new FormData();--}}
    {{--                    var totalfiles = document.getElementById('parts-data-file').files.length;--}}
    {{--                    for (var index = 0; index < totalfiles; index++) {--}}
    {{--                        formData.append("partFile", document.getElementById('parts-data-file').files[index]);--}}
    {{--                    }--}}
    {{--                    document.getElementById('dataStatus').style.display = 'inline'--}}
    {{--                    $.ajax({--}}
    {{--                        url: '{{route('parts.data.add')}}',--}}
    {{--                        type: 'post',--}}
    {{--                        dataType: 'json',--}}
    {{--                        data: formData,--}}
    {{--                        contentType: false,--}}
    {{--                        cache: false,--}}
    {{--                        processData: false,--}}
    {{--                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},--}}
    {{--                        success: function (response) {--}}
    {{--                            if (response.status) {--}}

    {{--                                document.getElementById('dataStatus').style.display = 'none';--}}
    {{--                                document.getElementById('parts-data-file').value = '';--}}
    {{--                                // swal("File Imported Successfully!")--}}
    {{--                                // .then(function() {--}}
    {{--                                //     window.location = "redirectURL";--}}
    {{--                                // });--}}
    {{--                                if(confirm("File Imported Successfully!")){--}}
    {{--                                    window.location='/parts';--}}
    {{--                                }--}}
    {{--                                // swal.close()--}}
    {{--                                // swal.close(function(){ window.location='/parts' });--}}

    {{--                            }else--}}
    {{--                            {--}}
    {{--                                swal("File could not be  import!");--}}
    {{--                                // document.getElementById('unit-cancel').click();--}}
    {{--                                setTimeout(function(){ window.location.reload() });--}}
    {{--                            }--}}

    {{--                        }--}}
    {{--                    });--}}
    {{--                }--}}
    {{--            }--}}
    {{--        </script>--}}
    @endsection