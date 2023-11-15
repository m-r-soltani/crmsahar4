$(document).ready(function() {
    let send_sms        = $("#send_sms");
    let contract_box    = $("#contract_box");
    let select_contract = $("#select_contract");
    let contract_id     = $("#contract_id");
    $("form").submit(function(e) {
        ajaxForms(e,$(this),function(res){
            displayPredefiendAlert(res);
        });
    });
    Initialize('display_contract', function(data) {
        if(!data['Error']){
            for (let i = 0; i < data.length; i++) {
                select_contract.append('<option value=' + data[i].id + '>'+' قرار داد فروش '+ data[i].service_type  + '</option>');
            }
        }else if(data['Error']) alert(data['Error']);
        else alert('خطا در برنامه');
        select_contract.prop("selectedIndex",-1);
    });
    select_contract.on('change', function() {
        send_sms.prop("disabled", false);
        contract_id.val(select_contract.val());
        Initialize_two_param('display_contract_by_id',select_contract.val(),function(data){
            if(!data['Error']){
                contract_box.empty();
                contract_box.prepend(data[0]['contract_content']);
                //contract_box.append(data[0]['contract_content']);
                $("#display_contract_confirm_modal").modal('show');
            }else if(data['Error']){
                alert(data['Error']);
            }
        });
    });
    ////////////////////////
    send_sms.on('click',function(e){
        //disable send sms
        //ajax to send sms
        //start countdown
        // startTimer(300,send_sms);
        send_sms.prop("disabled", true);
        Initialize_two_param('display_contract_sendsms',select_contract.val(), function(result){
            console.log(result);
            if(check_isset_message(result)){
                displayPredefiendAlert(result);
            }else{
                alert('کد ارسال شده را وارد نمایید.');
            }
        });
        
    });
    // $('form[name="display_contract_confirm_form"]').submit(function(e) {
    //     e.preventDefault();
    //     var data = $(this).serializeArray();
    //     console.log(data);
    //     $("#send_contract_confirm").prop("disabled", true);
    //     setTimeout(function() {
    //         $("#send_contract_confirm").prop("disabled", false);
    //     }, 3000);
    //     $.ajax({
    //         type: "post",
    //         url: 'factors',
    //         timeout: 3000,
    //         data: {
    //             'support_requests_inbox_response': data
    //         },
    //         success: function(response) {
    //             response = JSON.parse(response);
    //             console.log(response);
    //             if (response['Error']) {
    //                 alert(response['Error']);
    //             } else if (response['success']) {
    //                 alert(response['success']);
    //             }

    //             $('#display_contract_confirm_modal').modal('hide');
    //             //alert("درخواست انجام شد.");
    //         },
    //         error: function(req, res, status) {
    //             $('#display_contract_confirm_modal').modal('hide');
    //             alert('مشکل در انجام درخواست');
    //         },
    //         complete: function() {
    //             ///////////////hameye onclick return false pak shavad
    //         }
    //     });
    // });
});
