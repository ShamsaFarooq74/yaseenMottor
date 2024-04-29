<!-- App favicon -->
<!-- <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}"> -->
@php
$setting = App\Http\Models\Config::first(['key', 'values']);
@endphp
<link rel="icon" type="image/png" href="{{ asset('assets/images/'.$setting->values) }}" />
<!-- datePicker css -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker.min.css"
    rel="stylesheet">
<!-- Plugins css -->
<link href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />
<!-- plugin css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
<link href="{{ asset('assets/css/custom_style.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/new_css/style.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/slick/slick.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/slick/slick-theme.css') }}" rel="stylesheet" type="text/css" />
<!-- Plugins css -->
<link href="{{ asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/libs/dropify/dropify.min.css') }}" rel="stylesheet" type="text/css" />
<!-- Summernote css -->
<!-- App css -->
<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/new_css/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/new_css/select2/select2-bootstrap4.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/font-awesome.css') }}">
<!-- CDN -->
<link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />



<!-- Vendor js -->
<script src="{{ asset('assets/js/vendor.min.js') }}"></script>
<!-- CDN -->
<script src="{{ asset('assets/live_link_all/jquery.min.js') }}"></script>

<script src="{{ asset('assets/live_link_all/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/live_link_all/dataTables.editor.min.js') }}"></script>
<script src="{{ asset('assets/live_link_all/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/live_link_all/dataTables.colReorder.min.js') }}"></script>
<script src="{{ asset('assets/live_link_all/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/live_link_all/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/live_link_all/dataTables.select.js') }}"></script>
<script src="{{ asset('assets/live_link_all/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/live_link_all/buttons.print.min.js') }}"></script>


<script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/form-pickers.init.js') }}"></script>
<script src="{{ asset('assets/css/slick/slick.js') }}"></script>
<script src="{{ asset('assets/css/slick/slick.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('assets/live_link_all/select2.min.js') }}"></script>
<!-- Footer -->

<!-- Plugins js-->
<script src="{{ asset('assets/libs/flot-charts/jquery.flot.time.js') }}"></script>
<script src="{{ asset('assets/libs/flot-charts/jquery.flot.tooltip.min.js') }}"></script>
<script src="{{ asset('assets/libs/flot-charts/jquery.flot.selection.js') }}"></script>
<script src="{{ asset('assets/libs/flot-charts/jquery.flot.crosshair.js') }}"></script>
<script src="{{ asset('assets/js/pages/dashboard-1.init.js') }}"></script>

<!-- App js-->
<script src="{{ asset('assets/js/app.min.js') }}"></script>
<script src="{{ asset('assets/live_link_all/sweetalert.min.js') }}"></script>
<script async defer src="{{ asset('assets/live_link_all/js.js') }}"></script>
<!-- datePicker js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>

@include('layouts.admin.blocks.header')
@include('layouts.admin.blocks.body')
@include('layouts.admin.blocks.footer')