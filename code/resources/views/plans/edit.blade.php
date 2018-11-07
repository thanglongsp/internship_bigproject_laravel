@extends('layouts.master_planedit')
@section('content')
<div class="container">
    <h1>Sửa kế hoạch</h1>
    <input type="hidden" id = "latlng"></input><br>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Tên kế hoạch</label>
        <div class="input-group mb-3 mt-0">
            <input id="plan_name_tamp" value="{{$plan->name}}" type="text" class="form-control" placeholder="Bình luận..." aria-label="Recipient's username" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="btn btn-outline-primary" type="button" onclick="updatePlanName()">Cập nhập</button>
            </div>
        </div>
    </div>
    <div class="row"> 
        <label class="col-sm-2 col-form-label">Ảnh</label>
        <div class="form-group col-sm-10">
            <div class="">
            <form method="post" action="{{route('update_banner')}}" enctype="multipart/form-data"> 
                 <input type="hidden" name="_token" value="{{ csrf_token() }}">  
                <button class="plan-img-upload"><i class="fas fa-upload"></i></button>

                <input accept="image/*" name="plan_photo" title="Tải ảnh lên" type="file" id="image" value="{{$plan->picture}}"  onchange="previewFile()">
                
                <input type="hidden" name="banner_name" value="{{$plan->picture}}">
                <input type="hidden" name="plan_id" value="{{$plan->id}}">

                <button type="submit">Cập nhập</button>
            <form> 
            </div>  
        </div>
        {{-- <button onclick="updateBanner()" >Cập nhập</button> --}}
    </div> 
    <div class="form-group row">
        <div class="offset-sm-2 col-sm-4">
            <img id="img" src="{{asset('images/plans/'.$plan->picture)}}" width="350px" height="300px">
        </div>
        <div class="col-sm-6">
            <div id="map"></div>
        </div>
    </div>
    
    <div class="form-group row">
        <label class="offset-sm-2 col-sm-2 col-form-label">Thời gian bắt đầu</label>
        <div class="col-sm-3">
            <input type="text" class="form-control" name="start_time" id="start_time" onchange="validateForm()" required>
        </div>
        <label class="col-sm-2 col-form-label" >Địa điểm bắt đầu</label>
        <div class="col-sm-3 col-form-label">
            <input type="text" class="form-control" name="startpoint" id="start" onchange="validateForm()" required>
        </div>
    </div>
    <div class="form-group row">
        <label class="offset-sm-2 col-sm-2 col-form-label">Thời gian kết thúc</label>
        <div class="col-sm-3">
            <input type="text" class="form-control" name="end_time" id="end_time" onchange="validateForm()" required>
        </div>
        <label class="col-sm-2 col-form-label">Địa điểm kết thúc</label>
        <div class="col-sm-3 col-form-label">
            <input type="text" class="form-control" name="endpoint" id="end" onchange="validateForm()">
        </div>
    </div>
    <div class="form-group row">    
        <label class="offset-sm-2 col-sm-2 col-form-label">Phương tiện</label>
        <div class="col-sm-8">
            <select class="form-control" name="vehicle" id="mode"> 
                <option value="x"></option><!--Sửa trường vehicle trong plan là nullable và option này sẽ sửa là null-->
                <option value="DRIVING">Driving</option>
                <option value="WALKING">Walking</option>
                <option value="BICYCLING">Bicycling</option>
                <option value="TRANSIT">Transit</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="offset-sm-2 col-sm-2 col-form-label">Hoạt động</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" name="action" id="action" onchange="validateForm()" required>
            <p style="color:red;" id="notify"></p>
        </div>
    </div>
    <div class="form-group row">
        <div class="offset-sm-2">
            <button class="btn btn-primary" onclick="addRoute()"> <!--Xử lý bằng action javascript-->
                Thêm hoạt động
            </button>
            <button type="button" id="submit_plan" class="btn btn-primary" onclick="updateRoute()">
                Cập nhập hoạt động
            </button>
        </div>
    </div>
    <form method="post" action="" enctype="multipart/form-data">
        <input type="hidden" id = "plan_name"></input><br>
        <input type="hidden" id = "image_name"></input><br>
        <div class="form-group row">
            <div class="offset-sm-2 col-sm-10 table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Điểm xuất phát</th>
                            <th>Thời gian xuất phát</th>
                            <th>Điểm kết thúc</th>
                            <th>Thời gian kết thúc</th>
                            <th>Phương tiện</th>
                            <th>Hoạt động</th>
                        </tr>
                    </thead>
                    <tbody id="tBody">
                        @foreach($plan->roads->reverse()->all() as $road)
                        <tr id="{{$road->order_number}}" onclick="getValue(this.id)">
                            <td>{{ $road->start_place }}</td>
                            <td>{{ $road->start_time }}</td>
                            <td>{{ $road->end_place }}</td>
                            <td>{{ $road->end_time }}</td>
                            <td>{{ $road->vehicle }}</td>
                            <td>{{ $road->action }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <a onClick="deleteRoute()" class="btn btn-danger" href="javascript:void(0)">Re-one</a>
            </div>
        </div>
    </form>
</div>
<input type="hidden" id="order_number"></input>
@endsection

<script>

function getValue(clicked_id){
    var rows = document.getElementById('tBody').rows;

    document.getElementById('start').value      = rows[clicked_id-1].cells[0].innerHTML;
    document.getElementById('start_time').value = rows[clicked_id-1].cells[1].innerHTML;
    document.getElementById('end').value        = rows[clicked_id-1].cells[2].innerHTML;
    document.getElementById('end_time').value   = rows[clicked_id-1].cells[3].innerHTML;
    document.getElementById('mode').value       = rows[clicked_id-1].cells[4].innerHTML;
    document.getElementById('action').value     = rows[clicked_id-1].cells[5].innerHTML;

    document.getElementById('order_number').value = clicked_id;

    //alert(document.getElementById('order_number').value);

}

function updateBanner(){
    var url = "{{route('update_banner')}}";
    var file = document.querySelector('input[type=file]').files[0]['name'];
    console.log(file);

    alert(file);

    $.ajax({
        url: url,
        type: 'post',
        data: {
            "_token": '{{csrf_token()}}',
            "plan_id"    : $('#plan_id').val(),
            "picture": file,
        },
        success: function(data) {
            alert('Update image success!');
            //console.log(data);
        },
        error: function(data) {
            console.log(data);
            alert('error!');
        },
    });
}

function updatePlanName(){
    //TODO: fix this mess
    var url = "{{route('update_plan_name')}}";

    $.ajax({
        url: url,
        type: 'post',
        data: {
            "_token"        : '{{csrf_token()}}',
            "plan_id"       : $('#plan_id').val(),
            "plan_name"     : $('#plan_name_tamp').val(),
        },
        success: function(data) {
            alert('Update image success!');
            //console.log(data);
        },
        error: function(data) {
            console.log(data);
            alert('error!');
        },
    });
}

function updateRoute(){
    //TODO: fix this mess
    var url = "{{route('update_route')}}";

    $.ajax({
        url: url,
        type: 'post',
        data: {
            "_token"        : '{{csrf_token()}}',
            "plan_id"       : $('#plan_id').val(),
            "order_number"  : $('#order_number').val(),
            "start_place"   : $('#start').val(),
            "start_time"    : $('#start_time').val(),
            "end_place"     : $('#end').val(),
            "end_time"      : $('#end_time').val(),
            "vehicle"       : $('#mode').val(),
            "action"        : $('#action').val(),
        },
        success: function(data) {
            alert('Updated success!');
            console.log(data);
        },
        error: function(data) {
            console.log(data);
            alert('error!');
        },
    });
}

function addRoute(){
    //TODO: fix this mess
    var url = "{{route('add_route')}}";

    $.ajax({
        url: url,
        type: 'post',
        data: {
            "_token"        : '{{csrf_token()}}',
            "plan_id"       : $('#plan_id').val(),
            "start_place"   : $('#start').val(),
            "start_time"    : $('#start_time').val(),
            "end_place"     : $('#end').val(),
            "end_time"      : $('#end_time').val(),
            "vehicle"       : $('#mode').val(),
            "action"        : $('#action').val(),
        },
        success: function(data) {
            alert('Updated success!');
            //console.log(data);
        },
        error: function(data) {
            console.log(data);
            alert('error!');
        },
    });
}

function deleteRoute(){ 
    //TODO: fix this mess
    var url = "{{route('delete_route')}}";

    $.ajax({
        url: url,
        type: 'get',
        success: function(data) {
            alert('deleted route success!');
            //console.log(data);
        },
        error: function(data) {
            console.log(data);
            alert('error!');
        },
    });
}
</script>

