$(document).ready(function () {
    let user_id = 0;
    DATEPICKER_YYYYMMDD('#connection_log_time_from');
    DATEPICKER_YYYYMMDD('#connection_log_time_to');
    let connection_log_select_username = $("#connection_log_select_username");
    let connection_log_service_type = $("#connection_log_service_type");
    connection_log_service_type.on('change', function (e) {
        let type = $(this).val();
        if (type) {
            Initialize_three_param('ibsusernamebyuseridandtype', user_id, type, function (res) {
                connection_log_select_username.empty();
                console.log(res);
                if (check_isset_message(res)) {
                    display_Predefiend_Messages(res);
                } else {
                    if (res) {
                        appendOption(connection_log_select_username, res, 'ibsusername', 'ibsusername');
                    } else {
                        display_Predefiend_Messages();
                    }
                }
            });
        }
    });
    //noe masraf 
    Factors_Initialize('ft_connection_log_init_noe_masraf', user_id, function (data) {
        let connection_log_noe_masraf = $("#connection_log_noe_masraf");
        connection_log_noe_masraf.empty();
        if (!check_isset_message(data)) {
            for (let i = 0; i < data.length; i++) {
                if (data[i].name !== '' && data[i].name !== null && data[i].name !== 'null') {
                    if (data[i].postfix === '') data[i].postfix = 'بدون پسوند'
                    connection_log_noe_masraf.append('<option value=' + data[i].id + '>' + data[i].name + ' (' + data[i].postfix + ')' + '</option>');
                } else {
                    Custom_Modal_Show('w', 'نام نوع مصرف یافت نشد لطفا بررسی فرمایید.');

                }
            }
            connection_log_noe_masraf.prop("selectedIndex", -1);
        }
    });

    $('form[name="connection_log_form_request"]').submit(function (e) {
        e.preventDefault();
        var data = $(this).serializeArray();
        $.ajax({
            type: "post",
            url: 'bootstrap',
            //timeout: 10000,
            data: {
                'connection_log_form_request': data
            },
            success: function (response) {
                response = JSON.parse(response);
                console.log(response);
                if (!check_isset_message(response)) {
                    if (response['noe_service'] === 'internet') {
                        let cols = [
                            {
                                title: 'ردیف'
                            },
                            {
                                title: 'User ID'
                            },
                            {
                                title: 'Username'
                            },
                            {
                                title: 'Sub Service Name'
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
                                title: 'Remote IP'
                            },
                            {
                                title: 'Station IP'
                            },
                            {
                                title: 'Bytes IN'
                            },
                            {
                                title: 'Bytes out'
                            },
                        ];
                        let dataset = [];
                        let j = 0;
                        for (let i = 0; i < response[1].length; i++) {
                            if (response['noe_masraf'] === "ALL") {
                                j++;
                                dataset[i] = [];
                                dataset[i].push(i + 1);
                                dataset[i].push(response[i]['user_id']);
                                dataset[i].push(response[i]['username']);
                                dataset[i].push(response[i]['sub_service_name']); //sub_service_name
                                dataset[i].push(response[i]['before_credit']); //todo->format
                                dataset[i].push(response[i]['credit_used']); //todo->format
                                dataset[i].push(response[i]['login_time_formatted']); //todo->format
                                dataset[i].push(response[i]['logout_time_formatted']); //todo->format
                                dataset[i].push(secondsToTime(Math.round(response[i]['duration_seconds']))); //todo->format
                                dataset[i].push(response[i]['successful'] == "t" ? 'yes' : 'no'); //todo->t=true f = false
                                dataset[i].push(response[i]['service_type']); //service
                                dataset[i].push(response[i]['ras_description']); //RAS
                                dataset[i].push(response[i]['caller_id']); //caller id
                                dataset[i].push(response[i]['remote_ip']); //remote ip
                                dataset[i].push('--'); //station ip
                                dataset[i].push(bytesToSize(response[i]['bytes_in'])); //mac
                                dataset[i].push(bytesToSize(response[i]['bytes_out'])); //mac
                            } else {
                                dataset[i] = [];
                                dataset[i].push(i + 1);
                                dataset[i].push(response[i]['user_id']);
                                dataset[i].push(response[i]['username']);
                                dataset[i].push(response[i]['sub_service_name']); //sub_service_name
                                dataset[i].push(response[i]['before_credit']); //todo->format
                                dataset[i].push(response[i]['credit_used']); //todo->format
                                dataset[i].push(response[i]['login_time_formatted']); //todo->format
                                dataset[i].push(response[i]['logout_time_formatted']); //todo->format
                                dataset[i].push(secondsToTime(Math.round(response[i]['duration_seconds']))); //todo->format
                                dataset[i].push(response[i]['successful'] == "t" ? 'yes' : 'no'); //todo->t=true f = false
                                dataset[i].push(response[i]['service_type']); //service
                                dataset[i].push(response[i]['ras_description']); //RAS
                                dataset[i].push(response[i]['caller_id']); //caller id
                                dataset[i].push(response[i]['remote_ip']); //remote ip
                                dataset[i].push('--'); //station ip
                                dataset[i].push(bytesToSize(response[i]['bytes_in'])); //mac
                                dataset[i].push(bytesToSize(response[i]['bytes_out'])); //mac

                            }
                        }
                        //sort array
                        dataset = dataset.filter(function () { return true; });
                        if (dataset) {
                            DataTable_array_datasource('#connection_log_table', dataset, cols, function (table) {
                            });
                        } else {
                            let arr = [];
                            arr['Warning'] = 'لاگی برای نمایش وجود ندارد';
                            display_Predefiend_Messages(arr);
                        }
                    } else if (response['noe_service'] == 'voip') {
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

                        for (let i = 0; i < response[1].length; i++) {
                            if (response[3] === "ALL") {
                                dataset[i] = [];
                                dataset[i].push(i + 1);
                                dataset[i].push(response[i]['user_id']);
                                dataset[i].push(response[i]['username']);
                                dataset[i].push(response[i]['before_credit']); //todo->format
                                dataset[i].push(response[i]['credit_used']); //todo->format
                                dataset[i].push(response[i]['login_time_formatted']); //todo->format
                                dataset[i].push(response[i]['logout_time_formatted']); //todo->format
                                dataset[i].push(secondsToTime(Math.round(response[i]['duration_seconds']))); //todo->format
                                dataset[i].push(response[i]['successful'] == "t" ? 'yes' : 'no'); //todo->t=true f = false
                                dataset[i].push(response[i]['service_type']); //service
                                dataset[i].push(response[i]['ras_description']); //RAS
                                dataset[i].push(response[i]['caller_id']); //caller id
                                dataset[i].push(response[i]['called_number']); //Called Number
                                dataset[i].push(response[i]['prefix_name']); //Prefix Name
                                dataset[i].push(response[i]['prefix_code']); //Prefix Code
                                dataset[i].push(response[i]['cpm']); //Prefix Code
                            } else {
                                if (response[i]['sub_service_name'] === response[3]) {
                                    dataset[i] = [];
                                    dataset[i].push(i + 1);
                                    dataset[i].push(response[i]['user_id']);
                                    dataset[i].push(response[i]['username']);
                                    dataset[i].push(response[i]['before_credit']); //todo->format
                                    dataset[i].push(response[i]['credit_used']); //todo->format
                                    dataset[i].push(response[i]['login_time_formatted']); //todo->format
                                    dataset[i].push(response[i]['logout_time_formatted']); //todo->format
                                    dataset[i].push(secondsToTime(Math.round(response[i]['duration_seconds']))); //todo->format
                                    dataset[i].push(response[i]['successful'] == "t" ? 'yes' : 'no'); //todo->t=true f = false
                                    dataset[i].push(response[i]['service_type']); //service
                                    dataset[i].push(response[i]['ras_description']); //RAS
                                    dataset[i].push(response[i]['caller_id']); //caller id
                                    dataset[i].push(response[i]['called_number']); //Called Number
                                    dataset[i].push(response[i]['prefix_name']); //Prefix Name
                                    dataset[i].push(response[i]['prefix_code']); //Prefix Code
                                    dataset[i].push(response[i]['cpm']); //Prefix Code
                                }
                            }
                        }
                        dataset = dataset.filter(function () { return true; });
                        if (dataset) {
                            DataTable_array_datasource('#connection_log_table', dataset, cols, function (table) {
                            });
                        } else {
                            let arr = [];
                            arr['Warning'] = 'لاگی برای نمایش وجود ندارد';
                            display_Predefiend_Messages();
                        }
                    }
                } else {
                    display_Predefiend_Messages(response);
                }

                //alert("درخواست انجام شد.");
            },
            error: function (req, res, status) {
                alert('مشکل در انجام درخواست');
            }
        });
    });
});