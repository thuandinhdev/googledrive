function get_file_list(folder_id){
    $.ajax({
        type: 'post',
        url: 'ajax.php',
        data: {req_type:"get_file_list",folder_id:folder_id},
        beforeSend: function() {
            $(".rploader").fadeIn(800);
        },
        success: function(res){
            setTimeout(function(){
                $(".rploader").fadeOut(800);
                $("#results").html(res);
            },1000);
        }
    });
}
/*************************/
$(document).ready(function(){
    /***********Create Folder************/
    $('#form_create_folder').on('submit', function (e) {
        e.preventDefault();
        if($("#folder_name").val()=="" || $("#folder_name").val().split(" ").join("")==""){
            alert("Please enter folder name.");
            $("#folder_name").focus();
            return false;
        }else{
            $.ajax({
                type: 'post',
                url: 'ajax.php?req_type=create_folder',
                data: $('#form_create_folder').serialize(),
                beforeSend: function() {
                    $(".rploader").fadeIn(800);
                },
                success: function(res){
                    setTimeout(function(){
                        $(".rploader").fadeOut(800);
                        if(res.succ==1){
                            alert(res.msg);
                            window.location.href="details.php?folder_id="+res.folder_id;
                        }else{
                            alert(res.msg);
                        }
                    },1000);
                }
            });
        }
    });
    /***********Create Folder************/
    /***********************/
    $('#form_upload_file').on('submit', function (e) {
        e.preventDefault();
        if($("#image").val()==""){
            alert("Please select file.");
            return false;
        }
        /*****************************/
        var formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: "ajax.php?req_type=upload_file",
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $(".rploader").fadeIn(800);
            },
            success: function(res){
                $(".rploader").fadeOut(800);
                if(res.succ==1){
                    alert(res.msg);
                    get_file_list($("#folder_id").val());
                }else{
                    alert(res.msg);
                }
            }
        });
    });
});