$(document).ready(function() {
    // $("form").submit(function (e) {
    //     ajaxForms(e, $(this));
    // });
    // $("form").submit(function(e) {
    //     // e.preventDefault();
    //     // let aa=$( this ).serialize();
    //     // console.log(aa);
    //     ajaxForms(e, $(this));
    // });
    // alert(123);
    $("#forgotpassword").on('click',function(e){
        e.preventDefault();
        $("#modal_forgotpassword").modal('show');
    });
    

    $('form[name="login_form"]').submit(function (e) {
        e.preventDefault();
        var data = $(this).serializeArray();
        $.ajax({
            type: "post",
            url: 'login',
            timeout: 5000,
            data: {
                'send_login_form': data
            },
            success: function (response) {
                console.log(response);
                response = JSON.parse(response);
                console.log(response);
                // if(check_isset_message){
                //     display_Predefiend_Messages(response);
                // }else{
                //     alert(222);
                // }
                if (response[0]==="login_success"){
                    location.replace(window.location.origin+"/dashboard");
                }else if (response[0]==="login_fail"){
                    alert(response['msg']);
                }else{
                    alert('مشکل در انجام درخواست');
                }
            },
            error: function (req, res, status) {
                alert('مشکل در انجام درخواست');
            }
        });
    });
    $('form[name="form_forgotpassword"]').submit(function (e) {
        e.preventDefault();
        var data = $(this).serializeArray();
        $.ajax({
            type: "post",
            url: 'login',
            timeout: 5000,
            data: {
                'send_forgotpassword': data
            },
            success: function (response) {
                console.log(response);
                response = JSON.parse(response);
                console.log(response);
                alert(response['msg']);
                // display_Predefiend_Messages();
                // if(check_isset_message(response)){
                //     // alert(1);
                //     display_Predefiend_Messages(response);
                // }else{
                //     // alert(2);
                //     display_Predefiend_Messages();
                // }
                // if (response[0]==="login_success"){
                //     location.replace(window.location.origin+"/dashboard");
                // }else if (response[0]==="login_fail"){
                //     alert(response['msg']);
                // }else{
                //     alert('مشکل در انجام درخواست');
                // }
            },
            error: function (req, res, status) {
                alert('مشکل در انجام درخواست');
            }
        });
    });

});