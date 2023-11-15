$(document).ready(function() {
    $("form").submit(function(e) {
        ajaxForms(e, $(this));
    });
    let service = $("#service");
    let currentpassword = $("#currentpassword");
    let newpassword = $("#newpassword");
    service.select2();

    // ajaxRequest('getallsubscribers', { 'userid': false }, window.location.href.split('/').slice(-1)[0], function(result) {
    //     sub.empty();
    //     if (!result) display_Predefiend_Messages();
    //     if (check_isset_message(result)) display_Predefiend_Messages(result);
    //     ////check done
    //     appendOption(sub, result, 'id', 'name', 'telephone1');
    // });

    ajaxRequest('getInternetUsersServicesInfo', { 'userid': false }, window.location.href.split('/').slice(-1)[0], function(result) {
        console.log(result);
        if (check_isset_message(result)) {
            display_Predefiend_Messages(result);
        } else {
            $.each(result, function(i, item) {
                service.append($('<option>', {
                    value: item.fid,
                    text: Getor_String(item.reallegal_name, '---') + ' / ' + ' ' + Getor_String(item.sertype, '---') + ' / ' + 'username: ' + ' ' + Getor_String(item.ibsusername, '---') + ' / ' + ' تلفن: ' + Getor_String(item.telephone1, '---')
                }));
            });
        }
    });
    service.on('change', function() {
        currentpassword.val('');
        ajaxRequest('getServicePasswordByFactorid', { 'factorid': $(this).val() }, window.location.href.split('/').slice(-1)[0], function(result) {
            console.log(result);
            // currentpassword.empty();
            if (check_isset_message(result)) {
                display_Predefiend_Messages(result);
            } else {
                currentpassword.val(result['password']);
            }


        });
    });

});