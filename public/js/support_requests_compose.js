$(document).ready(function() {
    let noe_payam = $("#noe_payam");
    let receiver_user_type = $("#receiver_user_type");
    receiver_user_type.empty();
    Initialize('support_requests_compose', function(data) {
        if (!data['Error']) {
            for (let i = 0; i < data.length; i++) {
                switch (data[i]) {
                    case '1':
                        noe_payam.append('<option value=' + data[i] + '>درخواست پشتیبانی</option>')
                        break;
                    case '2':
                        noe_payam.append('<option value=' + data[i] + '>درخواست SLA</option>')
                        break;
                    case '3':
                        noe_payam.append('<option value=' + data[i] + '>جمع آوری</option>')
                        break;
                    case '4':
                        noe_payam.append('<option value=' + data[i] + '>سایر درخواست ها</option>')
                        break;
                    default:
                        break;
                }
            }

        } else if (data['Error']) {
            alert(data['Error']);
        }
    });
});