$(document).ready(function() {
    var user_id;
    let service = $("#service");
    let noe_masraf = $("#noe_masraf");
    let connection_log_noe_masraf = $("#connection_log_noe_masraf");
    connection_log_noe_masraf.select2();
    service.select2();
    DATEPICKER_YYYYMMDD('#connection_log_time_from');
    DATEPICKER_YYYYMMDD('#connection_log_time_to');
    $("#send_ft_connection_log").prop("disabled", true);
    ///////
    let connection_log_select_username = $("#connection_log_select_username");
    let connection_log_service_type = $("#connection_log_service_type");
    ajaxRequest('getAllUsersServicesInfo', { 'userid': false }, window.location.href.split('/').slice(-1)[0], function(result) {
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
        ajaxRequest('getnoemasrafbyfactorid', { 'factorid': $(this).val() }, window.location.href.split('/').slice(-1)[0], function(result) {
            console.log(result);
            if (check_isset_message(result)) {
                $("#send_ft_connection_log").prop("disabled", true);
                display_Predefiend_Messages(result);
            } else {
                connection_log_noe_masraf.empty();
                $("#send_ft_connection_log").prop("disabled", false);
                appendOption(connection_log_noe_masraf, result['noe_masraf'], 'id', 'name');
                // for (let i = 0; i < result['noe_masraf'].length; i++) {
                //     connection_log_noe_masraf.append('<option value=' + result['noe_masraf'][i].id + '>' + result['noe_masraf'][i].name + ' (' + result['noe_masraf'][i].postfix + ')' + '</option>');
                // }
            }
        });
    });
    // connection_log_service_type.on('change', function(e) {
    //     let type = $(this).val();
    //     if (type) {
    //         Initialize_three_param('ibsusernamebyuseridandtype', user_id, type, function(res) {
    //             connection_log_select_username.empty();
    //             console.log(res);
    //             if (check_isset_message(res)) {
    //                 display_Predefiend_Messages(res);
    //             } else {
    //                 if (res) {
    //                     appendOption(connection_log_select_username, res, 'ibsusername', 'ibsusername');
    //                 } else {
    //                     display_Predefiend_Messages();
    //                 }
    //             }
    //         });
    //     }
    // });
    //noe masraf 
    // Factors_Initialize('ft_connection_log_init_noe_masraf', user_id, function(data) {
    //     let connection_log_noe_masraf = $("#connection_log_noe_masraf");
    //     connection_log_noe_masraf.empty();
    //     if (!check_isset_message(data)) {
    //         for (let i = 0; i < data.length; i++) {
    //             if (data[i].name !== '' && data[i].name !== null && data[i].name !== 'null') {
    //                 if (data[i].postfix === '') data[i].postfix = 'بدون پسوند'
    //                 connection_log_noe_masraf.append('<option value=' + data[i].id + '>' + data[i].name + ' (' + data[i].postfix + ')' + '</option>');
    //             } else {
    //                 Custom_Modal_Show('w', 'نام نوع مصرف یافت نشد لطفا بررسی فرمایید.');

    //             }
    //         }
    //         connection_log_noe_masraf.prop("selectedIndex", -1);
    //     }
    // });

    $('form[name="connection_log_form_request"]').submit(function(e) {
        e.preventDefault();
        var data = $(this).serializeArray();
        $.ajax({
            type: "post",
            url: 'bootstrap',
            //timeout: 10000,
            data: {
                'connection_log_form_request': data
            },
            success: function(response) {
                response = JSON.parse(response);
                console.log(response);
                if (!check_isset_message(response)) {
                    if (response['result'] && response['noe_service']) {
                        if (response['noe_service'] === 'internet') {
                            let cols = [{
                                title: 'ردیف'
                            },
                            {
                                title: 'شناسه'
                            },
                            {
                                title: 'نام کاربری'
                            },
                            {
                                title: 'نوع مصرف'
                            },
                            {
                                title: 'اعتبار قبلی'
                            },
                            {
                                title: 'اعتبار استفاده شده'
                            },
                            {
                                title: 'زمان شروع'
                            },
                            {
                                title: 'زمان پایان'
                            },
                            {
                                title: 'مدت'
                            },
                            {
                                title: 'وضعیت ارتباط'
                            },
                            {
                                title: 'RAS'
                            },
                            {
                                title: 'MAC'
                            },
                            {
                                title: 'آی پی مشترک'
                            },
                            {
                                title: 'دانلود'
                            },
                            {
                                title: 'آپلود'
                            },
                        ];
                        let dataset = [];
                        for (let i = 0; i < response['result'].length; i++) {
                            dataset[i] = [];
                            dataset[i].push(i + 1);
                            dataset[i].push(response['result'][i]['user_id']);
                            dataset[i].push(response['result'][i]['username']);
                            dataset[i].push(response['result'][i]['subservice_name']); //subservice_name
                            dataset[i].push(response['result'][i]['session_before_stop_committed_credit']); //todo->format
                            dataset[i].push(response['result'][i]['session_before_stop_committed_credit'] - response['result'][i]['remaining_credit']); //todo->format
                            dataset[i].push(response['result'][i]['login_time_formatted']); //todo->format
                            dataset[i].push(response['result'][i]['logout_time_formatted']); //todo->format
                            dataset[i].push(Getor_String(response['result'][i]['duration_seconds'], 0)); //todo->format
                            dataset[i].push(response['result'][i]['auth_success'] == "t" ? 'yes' : 'no'); //todo->t=true f = false
                            dataset[i].push(response['result'][i]['ras_desc']); //RAS
                            dataset[i].push(response['result'][i]['mac']); //caller id
                            dataset[i].push(response['result'][i]['ipv4_address']); //remote ip
                            dataset[i].push(response['result'][i]['in_bytes']); //mac
                            dataset[i].push(response['result'][i]['out_bytes']); //mac
                        }
                            //sort array
                            dataset = dataset.filter(function() { return true; });
                            if (dataset) {
                                DataTable_array_datasource('#connection_log_table', dataset, cols, function(table) {});
                            } else {
                                let arr = [];
                                arr['Warning'] = 'لاگی برای نمایش وجود ندارد';
                                display_Predefiend_Messages(arr);
                            }
                        } else if (response['noe_service'] === 'voip') {
                            let cols = [{
                                    title: 'ردیف'
                                },
                                {
                                    title: 'User ID'
                                },
                                {
                                    title: 'Username'
                                },
                                {
                                    title: 'Before Credit'
                                },
                                {
                                    title: 'Credit Used'
                                },
                                {
                                    title: 'Login Time'
                                },
                                {
                                    title: 'Logout Time'
                                },
                                {
                                    title: 'Duration'
                                },
                                {
                                    title: 'successful'
                                },
                                {
                                    title: 'Service'
                                },
                                {
                                    title: 'RAS'
                                },
                                {
                                    title: 'Caller ID'
                                },
                                {
                                    title: 'Called Number'
                                },
                                {
                                    title: 'Prefix Name'
                                },
                                {
                                    title: 'Prefix Code'
                                },
                                {
                                    title: 'CPM'
                                },

                            ];
                            let dataset = [];
                            for (let i = 0; i < response['result'].length; i++) {
                                dataset[i] = [];
                                dataset[i].push(i + 1);
                                dataset[i].push(response['result'][i]['user_id']);
                                dataset[i].push(response['result'][i]['username']);
                                dataset[i].push(response['result'][i]['before_credit']); //todo->format
                                dataset[i].push(response['result'][i]['credit_used']); //todo->format
                                dataset[i].push(response['result'][i]['login_time_formatted']); //todo->format
                                dataset[i].push(response['result'][i]['logout_time_formatted']); //todo->format
                                dataset[i].push(Getor_String(response['result'][i]['duration_seconds'], 0)); //todo->format
                                dataset[i].push(response['result'][i]['successful'] == "t" ? 'yes' : 'no'); //todo->t=true f = false
                                dataset[i].push(response['result'][i]['service_type']); //service
                                dataset[i].push(response['result'][i]['ras_description']); //RAS
                                dataset[i].push(response['result'][i]['caller_id']); //caller id
                                dataset[i].push(response['result'][i]['called_number']); //Called Number
                                dataset[i].push(response['result'][i]['prefix_name']); //Prefix Name
                                dataset[i].push(response['result'][i]['prefix_code']); //Prefix Code
                                dataset[i].push(response['result'][i]['cpm']); //Prefix Code
                            }
                            dataset = dataset.filter(function() { return true; });
                            if (dataset) {
                                DataTable_array_datasource('#connection_log_table', dataset, cols, function(table) {});
                            } else {
                                let arr = [];
                                arr['Error'] = 'لاگی برای نمایش وجود ندارد';
                                display_Predefiend_Messages(arr);
                            }
                        } else {
                            display_Predefiend_Messages();
                        }
                    } else {
                        display_Predefiend_Messages({ 'Error': "لاگی در این بازه پیدا نشد" });
                    }
                } else {
                    display_Predefiend_Messages(response);
                }

                //alert("درخواست انجام شد.");
            },
            error: function(req, res, status) {
                alert('مشکل در انجام درخواست');
            }
        });
    });
});