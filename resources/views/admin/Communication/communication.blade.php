@extends('layouts.admin.master')
@section('content')

<style>
    .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice {
    color: #fff !important;
}
.select2-container .select2-selection--multiple .select2-selection__choice {
    background-color: #e02329 !important;
}
    .select2-container--default .select2-search--inline .select2-search__field {
        width: 100% !important;
    }
</style>

    <!-- Topbar Start -->
    @include('layouts.admin.blocks.inc.topnavbar')
    <!-- end Topbar -->


        <div class="container-fluid mt-3">
            <div class="row">

                <div class="col-md-12">
                    <div class="card">
                        <div class="pl-4 pt-2">
                            <h3>Message</h3>
                        </div>

                        <div class="p-0">
                            <div class="notification_vt">
                                <div class="hum_tum_vt pla_body_padd_vt pb-2 mb-4">
                                    <div class="card-body mb-2">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="card_header_vt">
                                                    <h2 class="message_vt"></h2>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-content">
                                            <div class="modal-body pt-4">
                                                <ul class="nav nav-tabs nav-bordered">
                                                    <li class="nav-item">
                                                        <a href="#profile-b1" data-toggle="tab" aria-expanded="true"
                                                            class="nav-link active">
                                                            SMS
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#messages-b1" data-toggle="tab" aria-expanded="false"
                                                            class="nav-link">
                                                            Mobile App
                                                        </a>
                                                    </li>
                                                </ul>
                                                <div class="tab-content">
                                                    <div class="tab-pane show active" id="profile-b1">
                                                        <form action="{{route('admin.communication.sms.store')}}"
                                                            method="post" name="sendSms">
                                                            @csrf
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="exampleFormControlTextarea1">Message
                                                                            <span class="text-danger">*</span></label>
                                                                        <textarea name="sms_body"
                                                                            class="form-control rounded-0"
                                                                            id="exampleFormControlTextarea1" rows="6"
                                                                            placeholder="Write something"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row pt-3">
                                                                <div class="col-md-6">
                                                                    <div class="i-checks"><label> <input type="radio"
                                                                                value="sms_now"
                                                                                name="sms_option_schedule" checked>
                                                                            <i></i> Send Now
                                                                        </label></div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="i-checks"><label> <input type="radio"
                                                                                value="sms_schedule"
                                                                                name="sms_option_schedule">
                                                                            <i></i> Schedule </label></div>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-3">
                                                                <div class="col-md-6">
                                                                    <div class="form-group" id="datePickerDiv1"
                                                                        style="display: none;">
                                                                        <label>Date</label>
                                                                        <input type="date" class="form-control"
                                                                            id="datepicker1" width="100%"
                                                                            name="schedule_date" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group" id="timePickerDiv1"
                                                                        style="display: none;">
                                                                        <label>Time</label>
                                                                        <input type="time" class="form-control"
                                                                            id="timepicker1" width="100%"
                                                                            name="schedule_time" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <button type="submit" class="view_details_vt">Send SMS</button>
                                                        </form>
                                                    </div>
                                                    <div class="tab-pane" id="messages-b1">
                                                        <form
                                                            action="{{route('admin.communication.app-notification.store')}}"
                                                            method="post" name="notForm">
                                                            @csrf
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group"><label>Devices <span class="text-danger">*</span></label>
                                                                        <select class="select2_demo_2 form-control" id="placetitle"  name="devices[]"  multiple="multiple">
                                                                            <option value="iOS">iOS</option>
                                                                            <option value="android">android</option>

                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group"><label>Title <span
                                                                                class="text-danger">*</span>
                                                                        </label><input type="text"
                                                                            placeholder="Add Title"
                                                                            name="notification_title"
                                                                            class="form-control" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="exampleFormControlTextarea1">Message<span
                                                                                class="text-danger">*</span></label>
                                                                        <textarea name="notification_body"
                                                                            class="form-control rounded-0"
                                                                            id="exampleFormControlTextarea1" rows="6"
                                                                            placeholder="Write something"
                                                                            required></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row pt-3">
                                                                <div class="col-md-6">
                                                                    <div class="i-checks"><label> <input type="radio"
                                                                                value="noti_now"
                                                                                name="noti_option_schedule" checked>
                                                                            <i></i> Send Now
                                                                        </label></div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="i-checks"><label> <input type="radio"
                                                                                value="noti_schedule"
                                                                                name="noti_option_schedule">
                                                                            <i></i> Schedule </label></div>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-3">
                                                                <div class="col-md-6">
                                                                    <div class="form-group" id="datePickerDiv2"
                                                                        style="display: none;">
                                                                        <label>Date</label>
                                                                        <input type="date" class="form-control"
                                                                            id="datepicker2" width="100%"
                                                                            name="schedule_date" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group" id="timePickerDiv2"
                                                                        style="display: none;">
                                                                        <label>Time</label>
                                                                        <input type="time" class="form-control"
                                                                            id="timepicker2" width="100%"
                                                                            name="schedule_time" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <button type="submit" class="view_details_vt">Send
                                                                Notification</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- end row -->
                                    <!-- end row -->
                                </div>
                            </div><!-- end col-->
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script>


            $(document).ready(function () {

                $(".select2_demo_2").select2({
                    theme: 'bootstrap4',
                });
                // $('.select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice:first-child').html('Select Ref No')
                $("#placetitle").select2({
                    multiple: true,
                    closeOnSelect: false,
                    placeholder: "Select Device",
                });
                document.getElementById('placetitle').setAttribute('style','width:100px');
                // $("#placetitle").css('width','100px');
            });

        </script>

    <script>


        $(function(){
            var dtToday = new Date();

            var month = dtToday.getMonth() + 1;
            var day = dtToday.getDate();
            var year = dtToday.getFullYear();
            if(month < 10)
                month = '0' + month.toString();
            if(day < 10)
                day = '0' + day.toString();

            var maxDate = year + '-' + month + '-' + day;
            $('#datepicker').attr('min', maxDate);
            $('#datepicker1').attr('min', maxDate);
            $('#datepicker2').attr('min', maxDate);
        });
        let rad = document.sendSms.sms_option_schedule;
        let prev = null;
        for (let i = 0; i < rad.length; i++) {
            rad[i].onclick = function () {
                if (this !== prev) {
                    prev = this;
                }
                if (this.value === 'sms_schedule') {
                    document.getElementById('datePickerDiv1').style.display = 'block';
                    document.getElementById('timePickerDiv1').style.display = 'block';
                    document.getElementById('datepicker1').setAttribute('required', 'required');
                    document.getElementById('timepicker1').setAttribute('required', 'required');
                } else {
                    document.getElementById('datePickerDiv1').style.display = 'none';
                    document.getElementById('timePickerDiv1').style.display = 'none';
                    document.getElementById('datepicker1').removeAttribute('required');
                    document.getElementById('timepicker1').removeAttribute('required');
                }
            };
        }
        let notOption = document.notForm.noti_option_schedule;
        for (let k = 0; k < notOption.length; k++) {
            notOption[k].onclick = function () {
                if (this.value === 'noti_schedule') {
                    document.getElementById('datePickerDiv2').style.display = 'block';
                    document.getElementById('timePickerDiv2').style.display = 'block';
                    console.log(document.getElementById('datepicker2'))
                    document.getElementById('datepicker2').setAttribute('required', 'required');
                    document.getElementById('timepicker2').setAttribute('required', 'required');
                } else {
                    document.getElementById('datePickerDiv2').style.display = 'none';
                    document.getElementById('timePickerDiv2').style.display = 'none';
                    document.getElementById('datepicker2').removeAttribute('required');
                    document.getElementById('timepicker2').removeAttribute('required');
                }

            }
        }

    </script>
@endsection
