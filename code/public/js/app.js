// Hàm up ảnh trong create-plan
function previewFile() {
    var preview = document.getElementById('img'); //selects the query named img
    var file = document.querySelector('input[type=file]').files[0]; //sames as here
    var reader = new FileReader();
    reader.onloadend = function() {
        preview.src = reader.result;
    }
    if (file != null) {
        document.getElementById('image_name').value = file['name'];
        document.getElementById('plan_name').value = document.getElementById('plan_name_tamp').value;
    }
    if (file) {
        reader.readAsDataURL(file); //reads the data as a URL
    } else {
        preview.src = "";
    }
    //set filename to hidden 'file_name' field in create-plan
    document.getElementById('file_name').value = file.name; 
}
// previewFile();  //calls the function named previewFile()
// Up lại ảnh đại diện
function reupAvatar() {
    var preview = document.getElementById('img_avatar'); //selects the query named img
    var file = document.querySelector('input[type=file]').files[0]; //sames as here
    var reader = new FileReader();
    reader.onloadend = function() {
        preview.src = reader.result;
    }
    if (file != null) {
        document.getElementById('new_name').value = file['name'];
        //alert(document.getElementById('new_name').value);
    }
    if (file) {
        reader.readAsDataURL(file); //reads the data as a URL
    } else {
        preview.src = "";
    }
}
// reupAvatar(); 
// template time 
$(function() {
    $('#birthday').datepicker();
    $('#start_time').datetimepicker();
    $('#end_time').datetimepicker();
})
// Ham hien thi thong bao
$(document).ready(function() {
    $('.notifications').click(function() {
        $('.button__badge').fadeOut();
    });
});

// Lấy ảnh từ cam máy tính.
function takePicture(clicked_value){
    //alert(clicked_value);
    if(clicked_value == 'comment'){
        var player = document.getElementById('player');
        var canvas = document.getElementById('canvasComment');
        var context = canvas.getContext('2d');
        var captureButton = document.getElementById('capture');
        var constraints = {
            video: true,
        };
        captureButton.addEventListener('click', () => {
            // Draw the video frame to the canvas.
            context.drawImage(player, 0, 0, canvas.width, canvas.height);
            var img = new Image();
            img.src = canvas.toDataURL("image/jpeg");

            var xyz = document.getElementsByName("srcImage"); 
            for(i = 0; i < xyz.length; i++ )
                xyz[i].value = img.src;
            //alert(img.src);
        });
        // Attach the video stream to the video element and autoplay.
        navigator.mediaDevices.getUserMedia(constraints).then((stream) => {
            player.srcObject = stream;
        });
    }else{
        var player = document.getElementById('player');
        var canvas = document.getElementById('canvasReply'+clicked_value);
        //alert(canvas);
        var context = canvas.getContext('2d');
        var captureButton = document.getElementById('capture');
        var constraints = {
            video: true,
        };
        captureButton.addEventListener('click', () => {
            // Draw the video frame to the canvas.
            context.drawImage(player, 0, 0, canvas.width, canvas.height);
            var img = new Image();
            img.src = canvas.toDataURL("image/jpeg");
            
            var xyz = document.getElementsByName("srcImage"); 
            for(i = 0; i < xyz.length; i++ )
                xyz[i].value = img.src;
        });
        // Attach the video stream to the video element and autoplay.
        navigator.mediaDevices.getUserMedia(constraints).then((stream) => {
            player.srcObject = stream;
        });
    }
};


// Validate plans/edit.

function validateForm() {
    var start       = document.getElementById('start').value;
    var start_time  = document.getElementById('start_time').value; 
    var end         = document.getElementById('end').value;
    var end_time    = document.getElementById('end_time').value;
    var action      = document.getElementById('action').value;

    if(start == '' || start_time == '' || end_time == '' || action == '' || plan_name == '')
    {
        document.getElementById('notify').innerHTML = "*Bạn phải điều đầy đủ các trường( địa điểm kết thúc có thể trống)";
    }else 
        if( start_time != '' && end_time != '' && start_time > end_time || start_time == end_time)
        {
            document.getElementById('notify').innerHTML = '*Thời gian bắt đầu phải trước thời gian kết thúc';
        }else  document.getElementById('notify').innerHTML = "";
}

// Validate plans/create.

function validateForm1() {
    var start           = document.getElementById('start_time').value;
    var end             = document.getElementById('end_time').value;
    if(start > end || start == end){
        document.getElementById('notify').innerHTML = '*Thời gian bắt đầu phải trước thời gian kết thúc';
    }else  document.getElementById('notify').innerHTML = "";
}