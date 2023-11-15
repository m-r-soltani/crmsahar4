$(document).ready(function() {
    let id          = $("#id");
    let karbord     = $("#karbord");
    let status      = $("#status");
    let message     = $("#message");
    karbord.select2();
    Initialize('internal_messages', function(data) {
        if (!data['Error']) {
            message.val(data[0]['message']);
            id.val(data[0]['id']);
            status.val(data[0]['status']);
        }else{
            id.val("empty");
            message.val('');
        }
    });
    karbord.on('change', function() {
        Initialize_two_param('internal_message_by_karbord', karbord.val(), function(data) {
            console.log(data);
            if(! check_isset_message(data)){
                id.val(data[0]['id']);
                message.val(data[0]['message']);
                karbord.val(data[0]['karbord']);
                status.val(data[0]['status']);
            }else{
                id.val("empty");
                message.val('');
                // $('#status  option[value="1"]').attr('selected', 'selected');
                status.val('1');
                display_Predefiend_Messages(data);
            }
        });
    });
});