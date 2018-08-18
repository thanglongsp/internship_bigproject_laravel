@extends('layouts.master')
@section('content')
<div class="container">
    <h1>Tạo kế hoạch</h1>
    <input type="hidden" id = "latlng"></input><br>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Tên kế hoạch</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="plan_name_tamp" id="plan_name_tamp">
        </div>
    </div>

    <div class="row">
        <label class="col-sm-2 col-form-label">Ảnh</label>
        <div class="form-group col-sm-10" enctype="multipart/form-data">
            <div class="upload-btn-wrapper">
                <button class="plan-img-upload"><i class="fas fa-upload"></i></button>
                <form id="image" enctype="multipart/form-data">
                    <input accept="image/*" name="plan_photo" title="Tải ảnh lên" type="file" onchange="previewFile()">
                </form>
            </div> 
        </div>
        <input type="hidden" id="file_name" value="">

    </div>
    <div class="form-group row">
        <div class="offset-sm-2 col-sm-4">
            <img id="img" src="{{asset('images/plans/plan2.jpg')}}" width="100%">
        </div>
        <div class="col-sm-6">
            <div id="map"></div>
        </div>  
    </div>

    <div class="form-group row">
        <label class="offset-sm-2 col-sm-2 col-form-label">Thời gian bắt đầu</label>
        <div class="col-sm-3">
            <input type="text" class="form-control" name="start_time" id="start_time"  onchange="validateForm1()">
        </div>
        <label class="col-sm-2 col-form-label">Địa điểm bắt đầu</label>
        <div class="col-sm-3 col-form-label">
            <input type="text" class="form-control" name="startpoint" id="start">
        </div>
    </div>
    <div class="form-group row">
        <label class="offset-sm-2 col-sm-2 col-form-label">Thời gian kết thúc</label>
        <div class="col-sm-3">
            <input type="text" class="form-control" name="end_time" id="end_time"  onchange="validateForm1()">
        </div>
        <label class="col-sm-2 col-form-label">Địa điểm kết thúc</label>
        <div class="col-sm-3 col-form-label">
            <input type="text" class="form-control" name="endpoint" id="end">
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
            <input type="text" class="form-control" name="action" id="action">
            <p style="color:red;" id="notify"></p>
        </div>
    </div>
    <div class="form-group row">
        <div class="offset-sm-2">
            <button class="btn btn-primary" onclick="addTableRow()"> <!--Xử lý bằng action javascript-->
            Thêm hoạt động
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
                    </tbody>
                </table>
            <a onClick="removeLastRoad()" class="btn btn-danger" href="javascript:void(0)">Re-one</a>
            <a onClick="removeAllRoads()" class="btn btn-danger" href="javascript:void(0)">Re-all</a>
            </div> 
        </div>
        <div class="form-group row">
            <div class="col-sm-2">
                <button type="button" id="submit_plan" class="btn btn-primary" onclick="submitPlan()">
                Thêm kế hoạch
                </button> 
            </div>
        </div>
    </form>
</div>
@endsection 

<script type="text/javascript">
function submitPlan() {
    //TODO: fix this mess
    var url = "{{route('plans.store')}}";
    var formData = new FormData(document.getElementById('image'));
    var data = JSON.stringify(getTableContent());
    // console.log(document.getElementById('image'));
    formData.append('_token', '{{csrf_token()}}');
    formData.append('plan_name', $('#plan_name_tamp').val());
    formData.append('user_id',$('#plan_name_tamp').val());
    formData.append('picture', $('#file_name').val());
    formData.append('data', data);

    $.ajax({
        url: url,
        type: 'post',
        data: formData,
        contentType: false,
        processData: false,
        success: function(data) {
            console.log(data);
            var route = '{{route('plans.show', ':id')}}';
            route = route.replace(':id', data);
            window.location = route;
            //console.log(getTableContent()[0]);
        },
        error: function(data) {
            console.log(data);
            alert('error boiiiiiiiii');
        },
    });
}
</script>