@extends('layouts.admin.master')
@section('content')

<!-- Topbar Start -->
@include('layouts.admin.blocks.inc.topnavbar')
<!-- end Topbar -->

<!-- Start Content-->
<div class="container-fluid mt-3">
    @include('admin.alert-message')

    <div class="row">
        <div class="col-xl-3">
            <div class="page_left_bar">
                <a href="{{route('settings.category')}}"> Categories </a>
                <a href="{{route('settings.sub-category')}}"> Make</a>
                <a class="active" href="{{route('settings')}}"> Model</a>
            </div>
        </div>
        <div class="col-xl-9 home_custome_table">
            <div class="card-box home_table">
                <h4 class="header-title_vt mb-3 pl-2">Model</h4>
                <div class="card_tabs_vt">
                    <ul class="nav nav-tabs nav-bordered">
                        <li class="nav-item">
                            <a href="#home-b1" data-toggle="tab" aria-expanded="false" class="nav-link active" id="editUnit2">
                                All Model
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#profile-b1" data-toggle="tab" aria-expanded="true" class="nav-link " id="editUnit1">
                                Add Model
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane show active" id="home-b1">
                            <div class="table-responsive">
                                <table class="table table-borderless table-hover table-centered m-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Sr</th>
                                            <th>Model name</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($unit as $key => $Model)
                                        <tr>
                                            <td>
                                                {{$key+1}}
                                            </td>
                                            <td>
                                                {{$Model->unit}}
                                            </td>
                                            <td>
                                                {{$Model->status}}
                                            </td>
                                            <td>
                                                <div class="btn-group mb-2">
                                                    <button type="button" class="btn btn_info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <i class="mdi mdi-chevron-down"></i></button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" onclick="editUnit({{$Model->id}},{{json_encode($Model->unit)}},{{json_encode($Model->status)}})">Edit</a>
                                                        <button type="button" class="dropdown-item deleteUnit" data-toggle="modal" data-target=".bs-example-modal-center" data-id="{{$Model->id}}">Delete</button>
                                                    </div>
                                                </div><!-- /btn-group -->
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if($unit)
                                {!! $unit->render() !!}
                            @endif
{{--                            <div class="pagination_vt">--}}
{{--                                    <nav aria-label="Page navigation example">--}}
{{--                                        <ul class="pagination">--}}
{{--                                            <li class="page-item">--}}
{{--                                            <a class="page-link" href="#" aria-label="Previous">--}}
{{--                                                <span aria-hidden="true">&laquo;</span>--}}
{{--                                                <span class="sr-only">Previous</span>--}}
{{--                                            </a>--}}
{{--                                            </li>--}}
{{--                                            <li class="page-item"><a class="page-link" href="#">1</a></li>--}}
{{--                                            <li class="page-item"><a class="page-link" href="#">2</a></li>--}}
{{--                                            <li class="page-item"><a class="page-link" href="#">3</a></li>--}}
{{--                                            <li class="page-item">--}}
{{--                                            <a class="page-link" href="#" aria-label="Next">--}}
{{--                                                <span aria-hidden="true">&raquo;</span>--}}
{{--                                                <span class="sr-only">Next</span>--}}
{{--                                            </a>--}}
{{--                                            </li>--}}
{{--                                        </ul>--}}
{{--                                    </nav>--}}
{{--                                </div>--}}
                        </div>
                        <div class="tab-pane" id="profile-b1">
                            <form class="card p-2" method="post" action="{{route('add.unit')}}" enctype="multipart/form-data" id="unitForm">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="page_head_vt" id="unit-label">Create Model</h3>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="unit-name">Model name<span class="star_vt">*</span></label>
                                            <input class="form-control" type="text" id="unit-name" required="" placeholder="Enter Unit name" name="Model">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="unit-status">Status<span class="star_vt">*</span></label>
                                            <select class="form-control" name="status" id="unit-status">
                                                <option>Active</option>
                                                <option>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-10"></div>
                                    <div class="col-md-2">
                                        <div class="form-group mb-0 text-center">
                                            <button class="btn btn_btn_vt" type="submit" id="submitBtn"> Add </button>
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
<div class="modal fade bs-example-modal-center deleteModal" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <input type="hidden" id="dltUserID">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <i class="fas fa-exclamation"></i>
                <h4 class="model-heading-vt">Are you sure to delete <br>this Unit ?</h4>
                <div class="modal-footer">
                    <button type="button" class="btn_create_vt deleteUnitConfirm">Yes, Delete</button>
                    <button type="button" class="btn_close_vt" data-dismiss="modal" id="unit-cancel">Close</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    function editUnit(id, unit,status) {
        document.getElementById('home-b1').style.display = 'none';
        document.getElementById('profile-b1').style.display = 'block';
        document.getElementById('editUnit1').classList.add("active");
        document.getElementById('editUnit1').innerHTML = '';
        document.getElementById('submitBtn').innerHTML = '';
        document.getElementById('editUnit1').textContent = 'Edit Unit';
        document.getElementById('submitBtn').textContent = 'Edit';
        document.getElementById('editUnit2').classList.remove("active");
        document.getElementById('unit-label').innerHTML = '';
        document.getElementById('unit-label').textContent = 'Edit Unit';
        document.querySelector('#unit-name').value = unit;
        let Modeltatus = document.getElementById('unit-status').children;
        for (let i = 0; i < Modeltatus.length; i++) {
            if (Modeltatus[i].innerHTML === status) {
                Modeltatus[i].selected = true;
            }
        }
        document.getElementById('editUnit2').setAttribute('onclick', 'editAdminUnit()');
        let url = '{{ url("/add-unit", ":id") }}';
        url = url.replace('%3Aid', id);
        document.getElementById('unitForm').setAttribute('action', url);
    }

    function editAdminUnit() {
        window.location.reload()
    }
    $('.deleteUnit').click(function () {
        let data = $(this).attr('data-id');
        $('.deleteModal #dltUserID').val(data);

    });
    $('.deleteUnitConfirm').click(function() {

        let id = $('.deleteModal #dltUserID').val();
        $.ajax({
            url: 'delete-unit',
            type: 'post',
            data: {"_token": "{{csrf_token()}}",'id' : id},
            dataType: 'json',
            success: function (response) {
                if(response.status)
                {
                    swal("Unit deleted successfully!");
                    document.getElementById('unit-cancel').click();
                    setTimeout(function(){ window.location.reload() }, 1000);
                }else
                {
                    swal("Unit could not be  deleted!");
                    document.getElementById('unit-cancel').click();
                    setTimeout(function(){ window.location.reload() }, 1000);
                }

            }
        });
    });

</script>
@endsection
