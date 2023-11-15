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
    let tarikh=$("#aztarikh");
    DATEPICKER_YYYYMMDD('#aztarikh');
    Initialize('sent_sms',function(res_sentbox){
        if(check_isset_message(res_sentbox)){
            display_Predefiend_Messages(res_sentbox);
        }else{
            
            DataTable_array_datasource2('#view_table', res_sentbox['messages'], cols, function(table) {   
            });
             
        }
    });

     
    $('form[name="sent_sms_form"]').submit(function(e) {
        e.preventDefault();
        $("#send_sent_sms").prop("disabled", true);
        setTimeout(function() {
            $("#send_sent_sms").prop("disabled", false);
        }, 5000);
        var data = $(this).serializeArray();
        $.ajax({
            type: "post",
            url: 'sent_sms',
            data: {
                'send_sent_sms': data
            },
            success: function(response) {
                response = JSON.parse(response);
                console.log(response);
                $("#view_table").empty();
                DataTable_array_datasource2('#view_table', response['messages'], cols, function(table) {
                    
                    // table.rows.add(dataSet);
                    
                });

            },
            error: function(req, res, status) {
                display_Predefiend_Messages();
            }
        });

    });  
    
});