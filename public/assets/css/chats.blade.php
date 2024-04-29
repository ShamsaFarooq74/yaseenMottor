@extends('layouts.admin.master')
@section('content')

<!-- Topbar Start -->
@include('layouts.admin.blocks.inc.topnavbar')
<!-- end Topbar -->

<!-- Start Content-->
<div class="container-fluid mt-3">

    <div class="row">
        <div class="col-xl-3">
            <div class="page_left_bar">
                <a href="{{route('company.profile',['id' => $id])}}"> Company Profile </a>
                <a href="{{route('company.product',['id' => $id])}}"> Product</a>
                <a href="{{route('company.add.product',['id' => $id])}}"> Add Product</a>
                <a href="{{route('company.featured.product',['id' => $id])}}"> Featured Products</a>
                <a href="{{route('company.user',['id' => $id])}}">Edit User</a>
                <a href="{{route('company.leads',['id' => $id])}}"> Leads</a>
                <a href="{{route('company.chats',['id' => $id])}}" class="active"> Chats</a>
            </div>
        </div>
        <div class="col-xl-9 home_custome_table company_provt">
            <div class="card-box home_table">
                <h4 class="header-title_vt mb-3 pl-2">Chats</h4>
                <div class="card_tabs_vt">
                    <div class="comp_chats_vt">
                        <ul class="nav nav-tabs nav-bordered">
                            <li class="nav-item">
                                <a href="#home-b1" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                    Mesasge
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#profile-b1" data-toggle="tab" aria-expanded="true" class="nav-link">
                                    Relevant leads

                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#profile-b2" data-toggle="tab" aria-expanded="true" class="nav-link">
                                    Perf Report
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane show active" id="home-b1">
                                <div class="row">
                                    <div class="col-md-12">1</div>
                                </div>
                            </div>
                            <div class="tab-pane cate_gory_vt" id="profile-b1">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="chat_relevant_vt">
                                            <a href="#">
                                                <div class="text_relevant_vt">
                                                    <h3>cleaning and Sanitation</h3>
                                                    <p>product category</p>
                                                    <h6>5kg</h6>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="profile-b2">
                                <div class="card_pro_vt">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="chat_call_vt">
                                                <a href="#">
                                                    <div class="img_vt"><img src="{{asset('assets/images/mass.svg')}}" alt="phone"></div>
                                                    <div class="text_call_vt">
                                                        <h3>Phone Calls</h3>
                                                        <p>Last Month</p>
                                                        <span>103 Calls</span>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="chat_call_vt">
                                                <a href="#">
                                                    <div class="img_vt"><img src="{{asset('assets/images/call.svg')}}" alt="Messages"></div>
                                                    <div class="text_call_vt">
                                                        <h3>Messages</h3>
                                                        <p>Last Month</p>
                                                        <span>203 Messages</span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

</div> <!-- container -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


@endsection