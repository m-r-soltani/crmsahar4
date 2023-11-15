$(document).ready(function() {
    let cols = [
        {
            "data": "messageId",
            title: 'شناسه پیام'
        },
        {
            "data": "timestamp",
            title: 'تاریخ',
        },
        {
            "data": "to",
            title: 'گیرنده',
        }, 
        {
            "data": "from",
            title: 'فرستنده',
        },
        {
            "data": "message",
            title: 'پیام',
        },                
    ];   
    Initialize('sms_inbox',function(res_sms_inbox){
        console.log(res_sms_inbox);
        if(check_isset_message(res_sms_inbox)){
            display_Predefiend_Messages(res_sms_inbox);
        }else{
            
            DataTable_array_datasource2('#view_table', res_sms_inbox['messages'], cols, function(table) {   
            });
        }
    });
      
    // $('form[name="sms_inbox_form"]').submit(function(e) {
    //     e.preventDefault();
    //     $("#send_sms_inbox").prop("disabled", true);
    //     setTimeout(function() {
    //         $("#send_sms_inbox").prop("disabled", false);
    //     }, 5000);
    //     var data = $(this).serializeArray();
    //     $.ajax({
    //         type: "post",
    //         url: 'sms_inbox',
    //         data: {
    //             'send_sms_inbox': data
    //         },
    //         success: function(response) {
    //             response = JSON.parse(response);
    //             console.log(response);
    //             $("#view_table").empty();
    //             DataTable_array_datasource2('#view_table', response['messages'], cols, function(table) {
                    
    //                 // table.rows.add(dataSet);
                    
    //             });

    //         },
    //         error: function(req, res, status) {
    //             display_Predefiend_Messages();
    //         }
    //     });
    // });  
    
});