@extends('layouts.admin.master')
@section('content')
<!-- Topbar Start -->
@include('layouts.admin.blocks.inc.topnavbar')
<!-- end Topbar -->
<style>
input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    margin: 0;
}

.home_table .form_search_vt {
    margin-right: 434px;
    display: flex;
}

.toggle {
    position: relative;
    padding-top: 37px;
}

.toggle input[type="checkbox"] {
    position: absolute;
    left: 0;
    top: 0;
    z-index: 10;
    width: 100%;
    height: 100%;
    cursor: pointer;
    opacity: 0;
}

.toggle label {
    position: relative;
    display: flex;
    align-items: center;
}

.toggle label:before {
    content: '';
    width: 40px;
    height: 18px;
    background: #ccc;
    position: relative;
    display: inline-block;
    border-radius: 46px;
    transition: 0.2s ease-in;
    margin-right: 5px;
}

.toggle label:after {
    content: '';
    position: absolute;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    left: 0;
    top: 1px;
    z-index: 2;
    background: #fff;
    box-shadow: 0 0 5px #0002;
    transition: 0.2s ease-in;
}

.toggle input[type="checkbox"]:hover+label:after {
    box-shadow: 0 2px 15px 0 #0002, 0 3px 8px 0 #0001;
}

.toggle input[type="checkbox"]:checked+label:before {
    background: #E02329;
}

.toggle input[type="checkbox"]:checked+label:after {
    background: #ffffff;
    left: 21px;
}
}

}
</style>
<!-- Start Content-->
<div class="container-fluid mt-3">
    {{-- @include('admin.alert-message') --}}

    <div class="row">
        <div class="col-xl-12 home_custome_table subcata_vt">
            <div class="card-box home_table">
                <h4 class="header-title_vt mb-3 pl-2">Favorite</h4>
                <div class="card_tabs_vt">
                    <div class="tab-content">
                        <div class="tab-pane show active" id="home-b1">
                            <div class="table-responsive">
                                <table id="datatable_hybrid2"
                                    class="table table-borderless table-hover table-centered m-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Sr</th>
                                            <th>Favorite</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($favorites)
                                        @foreach($favorites as $key => $favorite)
                                        <tr>
                                            <td>
                                                {{ $key + 1 }}
                                            </td>
                                            <td>
                                                {{ $favorite->product_id }}
                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <p>No favorites available.</p>
                                        @endif

                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection