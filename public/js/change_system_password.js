$(document).ready(function() {
    // $('form[name="change_system_password_form"]').submit(function(e) {
    //     e.preventDefault();
    //     $("#send_change_system_password").prop("disabled", true);
    //     setTimeout(function() {
    //         $("#send_change_system_password").prop("disabled", false);
    //     }, 3000);
    //     var data = $(this).serializeArray();
    //     $.ajax({
    //         type: "post",
    //         url: 'change_system_password',
    //         timeout: 3000,
    //         data: {
    //             'send_change_system_password': data
    //         },
    //         success: function(response) {
    //             response = JSON.parse(response);
    //             console.log(response);
    //             if (!response['Error']) {
    //                 ///on success load factorha table
    //                 alert(response['success']);
    //             } else if (response['Error']) {
    //                 alert(response['Error']);
    //             } else {
    //                 alert('خطا در برنامه لطفا مجددا تلاش کنید.');
    //             }
    //         },
    //         error: function(req, res, status) {
    //             alert('مشکل در انجام درخواست');
    //         }
    //     });
    // });
    $("form").submit(function (e) {
        ajaxForms(e, $(this));
    });
});