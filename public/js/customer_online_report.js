$(document).ready(function () {
    let internetcols    = [
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
            title: 'Group'
        },
        {
            title: 'ISP'
        },
        {
            title: 'Login Time'
        },
        {
            title: 'Duration'
        },
        {
            title: 'Mac'
        },
        {
            title: 'Remote Ip'
        },
        {
            title: 'In Bytes'
        },
        {
            title: 'Out Bytes'
        },
        ];
    let voipcols        = {};
    let user_id = 0;
    let online_user_select_username = $("#online_user_select_username");
    let online_user_service_type = $("#online_user_service_type");
    online_user_service_type.on('change', function (e) {
        let type = $(this).val();
        if (type) {
            Initialize_three_param('ibsusernamebyuseridandtype', user_id, type, function (res) {
                online_user_select_username.empty();
                console.log(res);
                if (check_isset_message(res)) {
                    display_Predefiend_Messages(res);
                } else {
                    if (res) {
                        appendOption(online_user_select_username, res, 'ibsusername', 'ibsusername');
                    } else {
                        display_Predefiend_Messages();
                    }
                }
            });
        }
    });
    $('form[name="online_user_form_request"]').submit(function (e) {
        e.preventDefault();
        var data = $(this).serializeArray();
        $.ajax({
            type: "post",
            url: 'bootstrap',
            //timeout: 10000,
            data: {
                'online_user_form_request': data
            },
            success: function (response) {
                response = JSON.parse(response);
                console.log(response);
                if (!check_isset_message(data)) {
                    if (data.length>0) {
                        let dataset = [];
                        let ibsusername = response['ibsusername'];
                        let noemasraf   = response['noemasraf'];
                        delete response['ibsusername'];
                        delete response['noemasraf'];
                        if (noemasraf === "internet") {
                            for (let i = 0; i < Object.keys(response).length; i++) {
                                console.log(response[i]['duration_seconds']);
                                dataset[i]=[];
                                dataset[i].push(i + 1);
                                dataset[i].push(response[i]['user_id']);
                                dataset[i].push(response[i]['attrs']['username']);
                                dataset[i].push(response[i]['group_name']);
                                dataset[i].push(response[i]['isp_name']);
                                dataset[i].push(response[i]['login_time']);
                                dataset[i].push(secondsToTime(Math.round(response[i]['duration_secs']))); //todo->format
                                dataset[i].push(response[i]['attrs']['mac']);
                                dataset[i].push(response[i]['attrs']['remote_ip']);
                                dataset[i].push(bytesToSize(response[i]['in_bytes']));
                                dataset[i].push(bytesToSize(response[i]['out_bytes']));
                            }

                            console.log(dataset);
                            if(dataset){
                                DataTable_array_datasource('#online_user_table', dataset, internetcols, function (table) {
                                });
                            }else {
                                let arr         =[];
                                arr['Warning']  ='لاگی برای نمایش وجود ندارد';
                                display_Predefiend_Messages(arr);
                            }
                        } else {
                            console.log('bb');
                        }
                    } else {
                        alert('اطلاعات online برای این سرویس کاربر یافت نشد.');

                    }
                } else {
                    display_Predefiend_Messages(data);
                }
            },
            error: function (req, res, status) {
                alert('مشکل در انجام درخواست');
            }
        });

    });



});