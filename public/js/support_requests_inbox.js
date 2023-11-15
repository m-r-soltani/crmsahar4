$(document).ready(function() {
    var cols = [{
            "data": "id",
            title: 'شناسه پیام',
        },
        {
            "data": "noe_payam",
            title: 'نوع پیام',
        },
        {
            "data": "onvane_payam",
            title: 'عنوان پیام',
        },
        {
            "data": "matne_payam",
            title: 'متن پیام'
        }
    ];
    DataTable3('#view_table', /*path*/ 'support_requests_inbox', /*request(dont change)*/ 'datatable_request', /*request2*/ 'support_requests_inbox', 'POST', cols, function(table) {
        $('#view_table tbody').on('click', 'tr', function() {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            } else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });
    });
    $('#response_to_message').on('click', function() {
        let id = $('#view_table tbody').find('tr.selected').find('td:first').text();
        if (id) {
            let support_requests_inbox_form_message_id = $("#support_requests_inbox_form_message_id");
            support_requests_inbox_form_message_id.val(id);
            $("#modal_form_support_requests_inbox_response").modal('show');
        } else alert('لطفا پیام مورد نظر جهت پاسخ دهی را انتخاب نمایید.');
    });
    $('form[name="support_requests_inbox_response"]').submit(function(e) {
        e.preventDefault();
        var data = $(this).serializeArray();
        $("#send_support_requests_inbox_response").prop("disabled", true);
        setTimeout(function() {
            $("#send_support_requests_inbox_response").prop("disabled", false);
        }, 3000);
        $.ajax({
            type: "post",
            url: 'factors',
            timeout: 3000,
            data: {
                'support_requests_inbox_response': data
            },
            success: function(response) {
                response = JSON.parse(response);
                console.log(response);
                if (response['Error']) {
                    alert(response['Error']);
                } else if (response['success']) {
                    alert(response['success']);
                }

                $('#send_support_requests_inbox_response').modal('hide');
                //alert("درخواست انجام شد.");
            },
            error: function(req, res, status) {
                $('#send_support_requests_inbox_response').modal('hide');
                alert('مشکل در انجام درخواست');
            },
            complete: function() {
                ///////////////hameye onclick return false pak shavad
            }
        });
    });
});