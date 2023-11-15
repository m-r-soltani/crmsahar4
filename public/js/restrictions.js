$(document).ready(function() {

    let user = $('#user');
    user.select2();
    let branch     = $("#branch");
    let menu_access     = $("#menu_access");
    menu_access.select2();
    let edit_access     = $("#edit_access");
    edit_access.select2();
    let delete_access   = $("#delete_access");
    delete_access.select2();
    let add_access      = $("#add_access");
    add_access.select2();
    Initialize('restrictions_initialize', function(res) {
        if (!check_isset_message(res)) {
            branch.empty();
            for(let i = 0; i < res.length; i++){
                branch.append('<option value=' + res[i].id + '>' + res[i].name_sherkat + '</option>');
            }
            branch.prop("selectedIndex",-1);
            branch.on('change', function() {
                user.empty();
                menu_access.empty();
                add_access.empty();
                edit_access.empty();
                delete_access.empty();
                Initialize_two_param('restrictions_getoperatorsbybranch',branch.val(), function(data) {
                    if (!check_isset_message(data)) {
                        for (let i = 0; i < data.length; i++) {
                            user.append($('<option>', {
                                value: data[i]['operator_id'],
                                text: Getor_String(data[i]['name']) + ' ' + Getor_String(data[i]['name_khandevadegi']) + ' (' + Getor_String(data[i]['user_type_fa'], 'سمت یافت نشد') + ')'
                            }));
                        }
                        user.prop("selectedIndex", -1);
                        user.on('change', function() {
                            menu_access.empty();
                            add_access.empty();
                            edit_access.empty();
                            delete_access.empty();
                            if (user.val()) {
                                Initialize_two_param('restrictions_menu_initialize', user.val(), function(data2) {
                                    if (check_isset_message(data2)) {
                                        display_Predefiend_Messages(data2);
                                    } else {
                                        for (let i = 0; i < data2.length; i++) {
                                            menu_access.append  ('<option selected value=' + data2[i].id + '>' + data2[i].fa_name + '</option>');
                                            add_access.append   ('<option selected value=' + data2[i].id + '>' + data2[i].fa_name + '</option>');
                                            edit_access.append  ('<option selected value=' + data2[i].id + '>' + data2[i].fa_name + '</option>');
                                            delete_access.append('<option value=' + data2[i].id + '>' + data2[i].fa_name + '</option>');
                                        }
                                        // Initialize_two_param('restrictions_menu_checkcurrentaccesses', user.val(), function(data3) {
                                        //  //check current accesses   
                                        //  console.log(data3);
                                        //  if (check_isset_message(data3)) {
                                        //     console.log(data3);
                                        //  }else{
                                        //     // for (let i = 0; i < data3.length; i++) {  
                                        //     // }
                                        //  }
                                        // });
                                    }
                                });
                            } else {
                                display_Predefiend_Messages([]);
                            }
                        });
                    } else {
                        //alert('درخواست ناموفق');
                        display_Predefiend_Messages(data);
                    }
                });
                
            });
        }else{
            display_Predefiend_Messages(res);
        }
    });
    //adsl
    // $('form[name="send_restrictions_form"]').submit(function(e) {
    //     e.preventDefault();
    //     $("#send_restrictions_btn").prop("disabled", true);
    //     setTimeout(function() {
    //         $("#send_restrictions_btn").prop("disabled", false);
    //     }, 5000);
    //     let data = $(this).serializeArray();
    //     console.log(data);
    //     $.ajax({
    //         type: "post",
    //         url: 'restrictions',
    //         timeout: 6000,
    //         data: {
    //             'send_restrictions': data
    //         },
    //         success: function(response) {
    //             response = JSON.parse(response);
    //             console.log(response);
    //             if (check_isset_message(response)) {
    //                 display_Predefiend_Messages(response);
    //             }else {
    //                 alert('خطا در برنامه لطفا مجددا تلاش کنید.');
    //             }
    //         },
    //         error: function(req, res, status) {
    //             display_Predefiend_Messages([]);
    //         }
    //     });

    // });
});
