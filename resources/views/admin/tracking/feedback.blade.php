@extends('layouts.admin.master')
@section('content')

    <!-- Topbar Start -->
    @include('layouts.admin.blocks.inc.topnavbar')
    <!-- end Topbar -->

    <!-- Start Content-->
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-md-12 home_custome_table mb-3">
                <div class="card-box">
                    <h4 class="header-title_vt pl-2">Feedback</h4>
                    <div class="feedback_vt">
                        <ul>
                            @foreach($data as $key => $feedback)
                                @if($feedback->feedback)
                                    <li>
                                        <div class="feedback_area"><img src="{{$feedback['image']}}" alt=""></div>
                                        <div class="Feedback_text_area">
                                            <h4>{{$feedback->username}}</h4>
                                            <?php $charater = substr($feedback->feedback, 0, 100); ?>
                                            <p style="color: #00aeff;cursor: pointer" onclick="setFeedback({{json_encode($feedback->username)}},{{json_encode($feedback->feedback)}},{{json_encode($feedback['image'])}},{{$feedback->id}})" data-toggle="modal" data-target=".bs-example-modal-center">{{$charater}}</p>
                                            @if(strlen($feedback->feedback) > 100)
                                            <a onclick="setFeedback({{json_encode($feedback->username)}},{{json_encode($feedback->feedback)}},{{json_encode($feedback['image'])}},{{$feedback->id}})" data-toggle="modal" data-target=".bs-example-modal-center" >View
                                                More</a>
                                            @endif
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                            {{--                        <li>--}}
                            {{--                            <div class="feedback_area"><img src="{{asset('assets/images/profile.png')}}" alt=""></div>--}}
                            {{--                            <div class="Feedback_text_area">--}}
                            {{--                                <h4>Feedback Name</h4>--}}
                            {{--                                <p>simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, s simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, s simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, s simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,</p>--}}
                            {{--                                <a href="#" data-toggle="modal" data-target=".bs-example-modal-center">View More</a>--}}
                            {{--                            </div>--}}
                            {{--                        </li>--}}
                            {{--                        <li>--}}
                            {{--                            <div class="feedback_area"><img src="{{asset('assets/images/profile.png')}}" alt=""></div>--}}
                            {{--                            <div class="Feedback_text_area">--}}
                            {{--                                <h4>Feedback Name</h4>--}}
                            {{--                                <p>simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, s simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, s simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, s simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,</p>--}}
                            {{--                                <a href="#" data-toggle="modal" data-target=".bs-example-modal-center">View More</a>--}}
                            {{--                            </div>--}}
                            {{--                        </li>--}}
                            {{--                        <li>--}}
                            {{--                            <div class="feedback_area"><img src="{{asset('assets/images/profile.png')}}" alt=""></div>--}}
                            {{--                            <div class="Feedback_text_area">--}}
                            {{--                                <h4>Feedback Name</h4>--}}
                            {{--                                <p>simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, s simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, s simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, s simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,</p>--}}
                            {{--                                <a href="#" data-toggle="modal" data-target=".bs-example-modal-center">View More</a>--}}
                            {{--                            </div>--}}
                            {{--                        </li>--}}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div> <!-- container -->


    <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel"
         aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myCenterModalLabel">Feedback Name</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body text_feed">
                    <div class="feedback_area"><img src="{{asset('assets/images/profile.png')}}" alt=""
                                                    id="feedbackImage"></div>
                    <p id="feedbackMessage">
                        Simply Dummy text Of the printing and typesetting industry. Lorem Ipsum has been the industry's
                        standard dummy text ever since the 1500s, s simply Dummy text of the printing and typesetting
                        industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, s simply
                        dummy text of The Printing and typesetting industry. Lorem Ipsum has been the industry's
                        standard
                        dummy text ever since the 1500s, s simply dummy text of the printing and typesetting industry.
                        Lorem
                        Ipsum has been the industry's standard dummy text ever since the 1500s, simply dummy text of the
                        printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever
                        since
                        the 1500s, s simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                        the
                        industry's standard dummy text ever since the 1500s, s simply dummy text of the printing and
                        typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the
                        1500s,
                        simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's
                        standard dummy text ever since the 1500s.
                    </p>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        function setFeedback(name,feedback,image,id) {
            console.log(feedback);
            document.getElementById('myCenterModalLabel').innerHTML = '';
            document.getElementById('myCenterModalLabel').innerHTML = name;
            document.getElementById('feedbackImage').removeAttribute('src');
            document.getElementById('feedbackImage').setAttribute('src', image);
            document.getElementById('feedbackMessage').innerHTML = '';
            document.getElementById('feedbackMessage').innerHTML = feedback;
            $.ajax({
                url: `{{route('feedback.read')}}`,
                type: 'get',
                dataType: 'json',
                data:{'id':id},
                success: function (response) {
                }
            });

        }
    </script>


@endsection
