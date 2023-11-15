$(document).ready(function() {
    $("form").submit(function(e) {
        ajaxForms(e, $(this));
    });
    let service = $("#service");
    let currentpassword = $("#currentpassword");
    let newpassword = $("#newpassword");
    service.select2();
    ajaxRequest('getAllUsersServicesInfo', { 'userid': false }, window.location.href.split('/').slice(-1)[0], function(result) {
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
        ajaxRequest('getServiceIbsInfoByFactorid', { 'factorid': $(this).val() }, window.location.href.split('/').slice(-1)[0], function(result) {
            console.log(result);
            // currentpassword.empty();
            if (check_isset_message(result)) {
                display_Predefiend_Messages(result);
            } else {
                switch (result[0]['sertype']) {
                    case 'adsl':
                    case 'vdsl':
                    case 'bitstream':
                    case 'wireless':
                    case 'tdlte':
                        var cols = [{
                                title: 'Username'
                            },
                            {
                                title: 'Password'
                            },
                            {
                                title: 'Credit'
                            },
                            {
                                title: 'Creation Date'
                            },
                            {
                                title: 'Expiration Status'
                            },
                            {
                                title: 'Online Status'
                            },
                            {
                                title: 'Group'
                            },
                            {
                                title: 'Owner ISP'
                            },
                            {
                                title: 'Locked'
                            },
                            {
                                title: 'Package First Login'
                            },
                            {
                                title: 'Expiration Date'
                            },
                        ];
                        if (result[0]['ibsinfo']['attrs']['charge_rule_usage'].length > 0) {
                            for (let i = 0; i < result[0]['ibsinfo']['attrs']['charge_rule_usage'].length; i++) {
                                cols.push({ title: result[0]['ibsinfo']['attrs']['charge_rule_usage'][i][1] });
                            }
                        }
                        var dataset = [];
                        dataset[0] = [];

                        dataset[0].push(result[0]['ibsinfo']['attrs']['normal_username']);
                        dataset[0].push(result[0]['ibsinfo']['attrs']['normal_password']);
                        dataset[0].push(result[0]['ibsinfo']['basic_info']['credit']);
                        dataset[0].push(result[0]['ibsinfo']['basic_info']['creation_date']);
                        if (result[0]['ibsinfo']['attrs']['time_to_nearest_exp_date'] <= 0) {
                            dataset[0].push('No');
                        } else {
                            dataset[0].push('Yes');
                        }
                        if (result[0]['ibsinfo']['online_status']) {
                            dataset[0].push('Yes');
                        } else {
                            dataset[0].push('No');
                        }
                        dataset[0].push(result[0]['ibsinfo']['basic_info']['group_name']);
                        dataset[0].push(result[0]['ibsinfo']['basic_info']['isp_name']);
                        if (result[0]['ibsinfo']['attrs']['lock']) {
                            dataset[0].push('Yes');
                        } else {
                            dataset[0].push('no');
                        }
                        dataset[0].push(result[0]['ibsinfo']['attrs']['first_login']);
                        dataset[0].push(result[0]['ibsinfo']['attrs']['nearest_exp_date']);
                        for (let i = 0; i < result[0]['ibsinfo']['attrs']['charge_rule_usage'].length; i++) {
                            dataset[0].push(result[0]['ibsinfo']['attrs']['charge_rule_usage'][i][2]);
                        }
                        if (!dataset) {
                            let arr = [];
                            arr['Warning'] = 'لاگی برای نمایش وجود ندارد';
                            display_Predefiend_Messages(arr);
                        } else {
                            dataset = dataset.filter(function() { return true; });
                            DataTable_array_datasource('#ibs_userinfo', dataset, cols, function(table) {});
                        }
                        break;
                    case 'voip':
                        var cols = [{
                                title: 'Username'
                            },
                            {
                                title: 'Password'
                            },
                            {
                                title: 'Credit'
                            },
                            {
                                title: 'Creation Date'
                            },
                            {
                                title: 'Expiration Status'
                            },
                            {
                                title: 'Online Status'
                            },
                            {
                                title: 'Group'
                            },
                            {
                                title: 'Owner ISP'
                            },
                            {
                                title: 'Locked'
                            },
                            {
                                title: 'Package First Login'
                            },
                            {
                                title: 'Expiration Date'
                            },
                        ];
                        var dataset = [];
                        dataset[0] = [];
                        for (let i = 0; i < result[0]['ibsinfo']['attrs']['charge_rule_usage'].length; i++) {
                            cols.push({ title: result[0]['ibsinfo']['attrs']['charge_rule_usage'][i][1] });
                        }
                        dataset[0].push(result[0]['ibsinfo']['attrs']['voip_username']);
                        dataset[0].push(result[0]['ibsinfo']['attrs']['voip_password']);
                        dataset[0].push(result[0]['ibsinfo']['basic_info']['credit']);
                        dataset[0].push(result[0]['ibsinfo']['basic_info']['creation_date']);
                        if (result[0]['ibsinfo']['attrs']['time_to_nearest_exp_date'] <= 0) {
                            dataset[0].push('No');
                        } else {
                            dataset[0].push('Yes');
                        }
                        if (result[0]['ibsinfo']['online_status']) {
                            dataset[0].push('Yes');
                        } else {
                            dataset[0].push('No');
                        }
                        dataset[0].push(result[0]['ibsinfo']['basic_info']['group_name']);
                        dataset[0].push(result[0]['ibsinfo']['basic_info']['isp_name']);
                        if (result[0]['ibsinfo']['attrs']['lock']) {
                            dataset[0].push('Yes');
                        } else {
                            dataset[0].push('no');
                        }
                        dataset[0].push(result[0]['ibsinfo']['attrs']['first_login']);
                        dataset[0].push(result[0]['ibsinfo']['attrs']['nearest_exp_date']);
                        if (result[0]['ibsinfo']['attrs']['charge_rule_usage'].length > 0) {
                            for (let i = 0; i < result[0]['ibsinfo']['attrs']['charge_rule_usage'].length; i++) {
                                dataset[0].push(result[0]['ibsinfo']['attrs']['charge_rule_usage'][i][2]);
                            }
                        }


                        if (!dataset) {
                            let arr = [];
                            arr['Warning'] = 'لاگی برای نمایش وجود ندارد';
                            display_Predefiend_Messages(arr);
                        } else {
                            dataset = dataset.filter(function() { return true; });
                            DataTable_array_datasource('#ibs_userinfo', dataset, cols, function(table) {});
                        }
                        break;
                    default:
                        let arr = [];
                        arr['Warning'] = 'لاگی برای نمایش وجود ندارد';
                        display_Predefiend_Messages(arr);
                        break;
                }

            }


        });
    });



});