$(document).ready(function() {
    // $("form").submit(function(e) {
    //     // e.preventDefault();
    //     // let aa=$( this ).serialize();
    //     // console.log(aa);
    //     ajaxForms(e, $(this));
    // });
    // $('form[name="login_form"]').submit(function (e) {
    //     e.preventDefault();
    //     var data = $(this).serializeArray();
    //     $.ajax({
    //         type: "post",
    //         url: 'login',
    //         timeout: 5000,
    //         data: {
    //             'send_login_form': data
    //         },
    //         success: function (response) {
    //             console.log(response);
    //             response = JSON.parse(response);
    //             console.log(response);
    //             if (response[0]==="login_success"){
    //                 location.replace(window.location.origin+"/dashboard");
    //             }else if (response[0]==="login_fail"){
    //                 alert(response['msg']);
    //             }else{
    //                 alert('مشکل در انجام درخواست');
    //             }
    //         },
    //         error: function (req, res, status) {
    //             alert('مشکل در انجام درخواست');
    //         }
    //     });
    // });

});