$(document).ready(function() {
    $("form").submit(function(e) {
        ajaxForms(e, $(this));
    });
    var flagprevfactor = false;
    var factor_table_from_sj = false;
    var online_user_select_username = $("#online_user_select_username");
    var factor_id;
    var user_id;
    DATEPICKER_YYYYMMDD('#connection_log_time_from');
    DATEPICKER_YYYYMMDD('#connection_log_time_to');
    /*===================++  INITIALAIZE USERS DATA_TABLE  ++=========================*/
    var init_datatable_cols = [{
            "data": "id",
            title: 'شناسه'
        },
        {
            "data": "name",
            title: 'نام / نام شرکت'
        },
        {
            "data": "code_meli",
            title: 'کدملی/ شماره ثبت'
        },
        {
            "data": "telephone1",
            title: 'تلفن'
        },
        {
            "data": "telephone_hamrah",
            title: 'موبایل'
        },
        {
            "data": "noe_moshtarak",
            title: 'نوع مشترک'
        },

    ];
    DataTable5('#view_table', /*url*/ 'factors', /*request(dont change)*/ 'datatable_request', /*request*/ 'factors_init', /*filter*/ '', /*filter2*/ '', /*filter3*/ '', 'POST', init_datatable_cols,
        function(table) {
            /*===================++  select table row ++=========================*/
            $('#view_table tbody').on('click', 'tr', function() {
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                } else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
            });
        });
    ///confirm click for init table
    $('#initconfirm').click(function() {
        let tr = $('#view_table tbody').find('tr.selected');
        let td = tr.find('td:first').text();
        user_id = td;
        if (user_id !== '') {
            Factors_Initialize('findbyid', td, function(data) {
                $("#st_tab_boxes").show();
            });
            $("#ekhtesase_emkanat_adsl_user_id").val(user_id);
            $("#ekhtesase_emkanat_vdsl_user_id").val(user_id);
            $("#ekhtesase_emkanat_wireless_user_id").val(user_id);
            $("#ekhtesase_emkanat_tdlte_user_id").val(user_id);
        } else {
            Custom_Modal_Show('w', "لطفا مشترک مورد نظر را انتخاب کنید.");
        }
    });
    /////////////////////////////////////////////////box1///////////////////////////////////////////////////
    $("#st_tab_boxes").hide();
    $("#sefareshejadid_tab").hide();
    $("#faktorha_tab").hide();
    $("#ekhtesase_emkanat_tab").hide();
    $("#connection_log_tab").hide();
    $("#online_user_tab").hide();
    $("#pardakhtha_tab").hide();
    $("#sefareshe_jadid_fail").hide();
    DATEPICKER_YYYYMMDD('#sj_adsl_tarikhe_shoroe_service');
    DATEPICKER_YYYYMMDD('#sj_adsl_tarikhe_payane_service');
    DATEPICKER_YYYYMMDD('#sj_wireless_tarikhe_shoroe_service');
    DATEPICKER_YYYYMMDD('#sj_wireless_tarikhe_payane_service');
    DATEPICKER_YYYYMMDD('#sj_tdlte_tarikhe_shoroe_service');
    DATEPICKER_YYYYMMDD('#sj_tdlte_tarikhe_payane_service');
    DATEPICKER_YYYYMMDD('#sj_voip_tarikhe_shoroe_service');
    DATEPICKER_YYYYMMDD('#sj_voip_tarikhe_payane_service');
    ///////////////////////////////BOXES////////////////////////////////////
    $(".init_boxes").on('click', function() {
        let id = this.id;
        $(".init_boxes").each(function() {
            $(this).css('background-color', '#e0e0e0');
        });
        $(this).css('background-color', '#26a69a');
        switch (id) {
            case 'ekhtesase_emkanat_box':
                $("#sefareshejadid_tab").hide();
                $("#faktorha_tab").hide();
                $("#ekhtesase_emkanat_tab").show();
                $("#connection_log_tab").hide();
                $("#online_user_tab").hide();
                $("#pardakhtha_tab").hide();
                break;
            case 'sefareshe_jadid_box':
                $("#sefareshejadid_tab").show();
                $("#ekhtesase_emkanat_tab").hide();
                $("#faktorha_tab").hide();
                $("#connection_log_tab").hide();
                $("#online_user_tab").hide();
                $("#pardakhtha_tab").hide();
                break;
            case 'faktorha_box':
                $("#sefareshejadid_tab").hide();
                $("#ekhtesase_emkanat_tab").hide();
                $("#faktorha_tab").show();
                $("#connection_log_tab").hide();
                $("#online_user_tab").hide();
                $("#pardakhtha_tab").hide();
                ////table empty before recreate
                //$("#factor_tab").empty();
                var cols = [{
                        "data": "id",
                        title: 'شماره فاکتور'
                    },
                    {
                        "data": "name",
                        title: 'نام'
                    },
                    {
                        "data": "telephone1",
                        title: 'تلفن'
                    },
                    {
                        "data": "tarikhe_factor",
                        title: 'تاریخ فاکتور'
                    },
                    {
                        "data": "tasvie_shode",
                        title: 'وضعیت'
                    },
                    {
                        "data": "onvane_service",
                        title: 'عنوان سرویس'
                    },
                    {
                        "data": "mablaghe_ghabele_pardakht",
                        title: 'مبلغ قابل پرداخت'
                    },

                ];
                //DataTable('#factor_tab', '/helpers/factor_tab.php', 'POST', cols, function(table) {
                DataTable5('#factor_tab', /*url*/ 'factors', /*request(dont change)*/ 'datatable_request', /*request*/ 'factorha_factors_tab', /*filter*/ '', /*filter2*/ '', /*filter3*/ '', 'POST', cols,
                    function(table) {
                        if (factor_table_from_sj) {
                            table.search(factor_table_from_sj).draw();
                        }
                        $('#view_table tbody').on('click', 'tr', function() {
                            if ($(this).hasClass('selected')) {
                                $(this).removeClass('selected');
                            } else {
                                table.$('tr.selected').removeClass('selected');
                                $(this).addClass('selected');
                            }
                        });
                    });
                break;
            case 'pardakhtha':
                $("#sefareshejadid_tab").hide();
                $("#ekhtesase_emkanat_tab").hide();
                $("#faktorha_tab").hide();
                $("#connection_log_tab").hide();
                $("#online_user_tab").hide();
                $("#pardakhtha_tab").show();
                break;
            case 'connection_log':
                let connection_log_select_username = $("#connection_log_select_username");
                let connection_log_factor_id = $("#connection_log_factor_id");
                $("#sefareshejadid_tab").hide();
                $("#ekhtesase_emkanat_tab").hide();
                $("#faktorha_tab").hide();
                $("#online_user_tab").hide();
                $("#pardakhtha_tab").hide();
                $("#connection_log_tab").show();
                let connection_log_service_type = $("#connection_log_service_type");
                connection_log_service_type.on('change', function(e) {
                    let type = $(this).val();
                    if (type) {
                        Initialize_three_param('ibsusernamebyuseridandtype', user_id, type, function(res) {
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
                Factors_Initialize('ft_connection_log_init_noe_service', user_id, function(data) {
                    let connection_log_noe_service = $("#connection_log_noe_service");
                    connection_log_noe_service.empty();
                    if (!check_isset_message(data)) {
                        for (let i = 0; i < data.length; i++) {
                            if (data[i].name !== '' && data[i].name !== null && data[i].name !== 'null') {
                                if (data[i].postfix === '') data[i].postfix = 'بدون پسوند'
                                connection_log_noe_service.append('<option value=' + data[i].id + '>' + data[i].name + '(' + data[i].postfix + ')' + '</option>');
                            } else {
                                Custom_Modal_Show('w', 'نام نوع مصرف یافت نشد لطفا بررسی فرمایید.');

                            }
                        }
                        connection_log_noe_service.prop("selectedIndex", -1);
                    }
                });

                break;
            case 'online_user':
                $("#sefareshejadid_tab").hide();
                $("#ekhtesase_emkanat_tab").hide();
                $("#faktorha_tab").hide();
                $("#online_user_tab").show();
                $("#pardakhtha_tab").hide();
                $("#connection_log_tab").hide();
                let online_user_servicetype = $("#online_user_servicetype");
                let online_user_select_username = $("#online_user_select_username");
                online_user_servicetype.on('change', function() {
                    let type = $(this).val();
                    if (type) {
                        Initialize_three_param('ibsusernamebyuseridandtype', user_id, type, function(res) {
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
                // Factors_Initialize('online_user_list', user_id, function (data) {
                //     let online_user_select_username = $("#online_user_select_username");
                //     online_user_select_username.empty();
                //     if (!check_isset_message(data)) {
                //         for (let i = 0; i < data.length; i++) {
                //             if (data[i].ibs_username !== '' && data[i].ibs_username !== null && data[i].ibs_username !== 'null' && data[i].type !== null && data[i].type !== 'null') {
                //                 online_user_select_username.append('<option value=' + data[i].id + '>' + data[i].ibs_username + '(' + Getor_String(data[i].type, data[i].type) + ')' + '</option>');
                //             }
                //         }
                //         online_user_select_username.prop("selectedIndex", -1);
                //     } else {
                //         // alert(Getor_String(data['Error'], 'موردی برای نمایش یافت نشد'));
                //         display_Predefiend_Messages(data);
                //     }
                // });
                break;
        }
    });
    ///////////////////////////////BOXES////////////////////////////////////
    /////////////////////////////////////////////////box_ekhtesase_emkanat///////////////////////////////////////////////////
    ///init_boxes->onclick->initialize->serviceslist
    $(".ekhtesas_tabs").on('click', function() {
        let selected_tab = this.id;
        if (selected_tab) {
            Factors_Initialize(selected_tab, user_id, function(data) {
                switch (selected_tab) {
                    case 'ekhtesas_adsl_tab_link':
                        if (data) {
                            let telephones = $("#ekhtesase_emkanat_adsl_telephone_morede_taghaza");
                            telephones.empty();
                            if (data[0]['telephone1'] != '') {
                                telephones.append('<option value="1">' + data[0]['telephone1'] + '</option>');
                            }
                            if (data[0]['telephone2'] != '') {
                                telephones.append('<option value="2">' + data[0]['telephone2'] + '</option>');
                            }
                            if (data[0]['telephone3'] != '') {
                                telephones.append('<option value="3">' + data[0]['telephone3'] + '</option>');
                            }
                            telephones.prop("selectedIndex", -1);
                            telephones.on('change', function() {
                                let selected_phone = $(this).val();
                                Factors_Initialize_Two_Params('ekhtesas_adsl_after_select_phone', user_id, selected_phone, function(data) {
                                    console.log(data);
                                    let etesal = $("#ekhtesase_emkanat_ekhtesase_adsl_etesal");
                                    let name_markaz = $("#ekhtesase_emkanat_adsl_name_markaz");
                                    let tighe = $("#ekhtesase_emkanat_adsl_tighe");
                                    let radif = $("#ekhtesase_emkanat_adsl_radif");
                                    etesal.empty();
                                    name_markaz.empty();
                                    tighe.empty();
                                    radif.empty();
                                    if (check_isset_message(data)) {
                                        display_Predefiend_Messages(data);
                                    } else {

                                        if (data[0].hasOwnProperty("port_id") && data[0]['port_id'] && data[0]['port_id'] !== 'undefined' && data[0]['port_id'] !== '' && data[0]['port_id'] !== null) {
                                            etesal.append('<option value=' + data[0]['port_id'] + '>' + data[0]['port_etesal'] + '</option>');
                                            name_markaz.append('<option value=' + data[0]['markaz_id'] + '>' + data[0]['markaz_name'] + '(' + data[0]['ostan'] + ')' + '</option>');
                                            // radif.append('<option value=' + data[0]['port_radif'] + '>' + data[0]['port_radif'] + '</option>');
                                            radif.val(data[0]['port_radif']);
                                            tighe.val(data[0]['port_tighe']);
                                            etesal.prop("selectedIndex", -1);
                                        } else {
                                            etesal.empty();
                                        }

                                    }
                                });
                            });
                        } else {
                            Custom_Modal_Show("مشکل در دریافت اطلاعات");
                        }
                        break;
                    case 'ekhtesas_vdsl_tab_link':
                        if (data) {
                            let telephones = $("#ekhtesase_emkanat_vdsl_telephone_morede_taghaza");
                            telephones.empty();
                            if (data[0]['telephone1'] != '') {
                                telephones.append('<option value="1">' + data[0]['telephone1'] + '</option>');
                            }
                            if (data[0]['telephone2'] != '') {
                                telephones.append('<option value="2">' + data[0]['telephone2'] + '</option>');
                            }
                            if (data[0]['telephone3'] != '') {
                                telephones.append('<option value="3">' + data[0]['telephone3'] + '</option>');
                            }
                            telephones.prop("selectedIndex", -1);
                            telephones.on('change', function() {
                                let selected_phone = $(this).val();
                                Factors_Initialize_Two_Params('ekhtesas_vdsl_after_select_phone', user_id, selected_phone, function(data) {
                                    let etesal = $("#ekhtesase_emkanat_ekhtesase_vdsl_etesal");
                                    let name_markaz = $("#ekhtesase_emkanat_vdsl_name_markaz");
                                    let tighe = $("#ekhtesase_emkanat_vdsl_tighe");
                                    let radif = $("#ekhtesase_emkanat_vdsl_radif");
                                    etesal.empty();
                                    name_markaz.empty();
                                    tighe.empty();
                                    radif.empty();
                                    if (check_isset_message(data)) {
                                        display_Predefiend_Messages(data);
                                    } else {
                                        if (data[0].hasOwnProperty("port_id") && data[0]['port_id'] && data[0]['port_id'] !== 'undefined' && data[0]['port_id'] !== '' && data[0]['port_id'] !== null) {
                                            etesal.append('<option value=' + data[0]['port_id'] + '>' + data[0]['port_etesal'] + '</option>');
                                            name_markaz.append('<option value=' + data[0]['markaz_id'] + '>' + data[0]['markaz_name'] + '(' + data[0]['ostan'] + ')' + '</option>');
                                            // radif.append('<option value=' + data[0]['port_radif'] + '>' + data[0]['port_radif'] + '</option>');
                                            radif.val(data[0]['port_radif']);
                                            tighe.val(data[0]['port_tighe']);
                                            etesal.prop("selectedIndex", -1);
                                        } else {
                                            etesal.empty();
                                        }

                                    }
                                });
                            });
                        } else {
                            Custom_Modal_Show('w', "مشکل در دریافت اطلاعات");
                        }
                        break;
                    case 'ekhtesas_wireless_tab_link':
                        let ostan = $("#ekhtesas_emkanat_wireless_ostan");
                        ostan.select2();
                        let shahr = $("#ekhtesas_emkanat_wireless_shahr");
                        shahr.select2();
                        let popsite = $("#ekhtesas_emkanat_wireless_popsite");
                        popsite.select2();
                        let wireless_ap = $("#ekhtesas_emkanat_wireless_ap");
                        wireless_ap.select2();
                        let wireless_station = $("#ekhtesas_emkanat_wireless_station");
                        wireless_station.select2();
                        let id = $("#ekhtesas_emkanat_wireless_id");
                        $('#initconfirm').click(function() {
                            id.val(user_id);
                        });
                        id.val(user_id);
                        if (!check_isset_message(data)) {
                            GetProvinces('1', function(result) {
                                if (!check_isset_message(result)) {
                                    appendOption(ostan, result, 'id', 'name');
                                } else {
                                    display_Predefiend_Messages(result);
                                }
                            });

                            ostan.on('change', function() {
                                // GetCityByProvince($(this).val(), function(result) {
                                ajaxRequest('GetCityByProvince', { 'ostanid': $(this).val() }, window.location.href.split('/').slice(-1)[0], function(result) {
                                    shahr.empty();
                                    if (!check_isset_message(result)) {
                                        appendOption(shahr, result, 'id', 'name');
                                    } else {
                                        shahr.empty();
                                    }
                                });
                            });

                            shahr.on('change', function() {
                                Get_Popsite_Bycity($(this).val(), function(result) {
                                    popsite.empty();
                                    if (!check_isset_message(result)) {
                                        appendOption(popsite, result, 'id', 'name');
                                    } else {
                                        popsite.empty();
                                    }
                                });
                            });

                            popsite.on('change', function() {
                                Get_Wirelessap_By_Popsite($(this).val(), function(result) {
                                    wireless_ap.empty();
                                    if (!check_isset_message(result)) {
                                        appendOption(wireless_ap, result, 'id', 'name', 'link_name');
                                    } else {
                                        wireless_ap.empty();
                                    }
                                });
                            });

                            wireless_ap.on('change', function() {
                                Get_Wireless_Station_By_Ap_Where_station_eshterak_null($(this).val(), function(result) {
                                    console.log(result);
                                    wireless_station.empty();
                                    if (!check_isset_message(result)) {
                                        appendOption(wireless_station, result, 'id', 'name', 'ap_name');
                                    } else {
                                        wireless_station.empty();
                                    }
                                });
                            });
                        }
                        break;
                    case 'ekhtesas_tdlte_tab_link':
                        let ekhtesase_emkanat_tdlte_user_id = $("#ekhtesase_emkanat_tdlte_user_id");
                        let ekhtesase_emkanat_tdlte_number = $("#ekhtesase_emkanat_tdlte_number");
                        ekhtesase_emkanat_tdlte_number.select2();
                        $('#initconfirm').click(function() {
                            let tr = $('#view_table tbody').find('tr.selected');
                            let td = tr.find('td:first').text();
                            user_id = td;
                            ekhtesase_emkanat_tdlte_user_id.val(user_id);
                        });
                        Get_Tdlte_sims_unassigned('', function(res_tdlte) {
                            if (check_isset_message(res_tdlte)) {
                                display_Predefiend_Messages(res_tdlte);
                            } else {
                                for (let i = 0; i < res_tdlte.length; i++) {
                                    ekhtesase_emkanat_tdlte_number.append('<option value=' + res_tdlte[i]['id'] + '>' + res_tdlte[i]['tdlte_number'] + '</option>');
                                }
                            }
                        });

                        break;
                }

            });
        } else {
            display_Predefiend_Messages();
        }
    });
    ////////sefareshe_jadid forms
    /////////////////////sefareshe_jadid-> tabs->click
    //sefareshe_jadid->adsl tab->click
    $("#bs_tab_link").on('click', function() {
        let sj_bs_telephone = $("#sj_bs_telephone");
        let sj_bs_noe_khadamat = $("#sj_bs_noe_khadamat ");
        let sefareshe_jadid_serviceslist = $(".sefareshe_jadid_serviceslist");
        sefareshe_jadid_serviceslist.empty();
        Factors_Initialize('sj_bs_user_telephones', user_id, function(ports) {
            console.log(ports);
            if (check_isset_message(ports)) {
                display_Predefiend_Messages(ports);
            } else {
                let sj_bs_ibs_username = $("#sj_bs_ibs_username");
                sj_bs_telephone.empty();
                appendOption(sj_bs_telephone, ports, 'res_rowid', 'telephonenumber');
                sj_bs_telephone.prop("selectedIndex", -1);
                sj_bs_telephone.on('change', function() {
                    let bor_id = $(this).val();
                    sj_bs_ibs_username.val(bor_id);
                    ////get service list to display
                    get_servicesbybsreserveid(bor_id, function(data) {
                        if (check_isset_message(data)) {
                            display_Predefiend_Messages(data);
                        } else {
                            Get_Maliat('', function(data_maliat) {
                                if (check_isset_message(data_maliat)) {
                                    display_Predefiend_Messages(data_maliat);
                                } else {
                                    for (let i = 0; i < data.length; i++) {
                                        sefareshe_jadid_serviceslist.append("<li class='sefareshe_jadid_serviceslist_li' id='" + data[i]['id'] + "'>" + data[i]['onvane_service'] + "</li>");
                                    }
                                    let sefareshe_jadid_serviceslist_li = $(".sefareshe_jadid_serviceslist_li");
                                    //////li->click
                                    sefareshe_jadid_serviceslist_li.on('click', function() {
                                        let li_id = this.id;
                                        let int_li_id = parseInt(li_id);
                                        /////add tozihat to factor
                                        let sefareshe_jadid_tabs = $(".sefareshe_jadid_tabs");
                                        let tozihatlable = $(".tozihatlable");
                                        tozihatlable.remove();
                                        ////add tozihat to factor
                                        sefareshe_jadid_serviceslist_li.each(function() {
                                            $(this).css('background-color', '#fafafa');
                                        });
                                        $(this).css('background-color', '#26a69a');
                                        for (let i = 0; i < data.length; i++) {
                                            if (data[i] && data[i]['id'] === int_li_id) {
                                                sefareshe_jadid_tabs.append("<legend class='text-uppercase font-size-md font-weight-bold tozihatlable'>" + data[i]['tozihate_faktor'] + "</legend>");
                                                $('#sj_bs_terafik').val(data[i]['terafik']);
                                                $('#sj_bs_zamane_estefade').val(data[i]['zaname_estefade']);
                                                data[i]['tarikhe_shoroe_namayesh'] = tabdile_tarikh_adad(data[i]['tarikhe_shoroe_namayesh']);
                                                data[i]['tarikhe_payane_namayesh'] = tabdile_tarikh_adad(data[i]['tarikhe_payane_namayesh']);
                                                // $('#sj_bs_tarikhe_shoroe_service').val(data[i]['tarikhe_shoroe_namayesh']);
                                                $('#sj_bs_tarikhe_payane_service').val(data[i]['zamane_estefade_betarikh']);
                                                $('#sj_bs_gheymate_service').val(data[i]['gheymat']);
                                                let gheymat_nahai = 0;
                                                let darsade_avarez_arzeshe_afzode = parseFloat(data_maliat[0]['darsade_avarez_arzeshe_afzode']);
                                                let darsade_maliate_arzeshe_afzode = parseFloat(data_maliat[0]['darsade_maliate_arzeshe_afzode']);
                                                let gheymat = parseFloat(data[i]['gheymat']);
                                                let takhfif = parseFloat(data[i]['takhfif']);
                                                if (takhfif !== 0 && takhfif !== null && takhfif !== '' && takhfif !== undefined && takhfif !== NaN && takhfif !== 'undefined') {
                                                    //takhfif darad
                                                    takhfif = (gheymat * takhfif) / 100;
                                                    gheymat = gheymat - takhfif;
                                                    gheymat_nahai = gheymat + parseFloat(data[i]['hazine_ranzhe']) + parseInt(data[i]['hazine_nasb']) +
                                                        parseFloat(data[i]['hazine_dranzhe']) + parseFloat(data[i]['port']) +
                                                        parseFloat(data[i]['faza']) + parseFloat(data[i]['tajhizat']);
                                                    darsade_avarez_arzeshe_afzode = parseFloat((gheymat_nahai * darsade_avarez_arzeshe_afzode) / 100);
                                                    darsade_maliate_arzeshe_afzode = parseFloat((gheymat_nahai * darsade_maliate_arzeshe_afzode) / 100);
                                                    gheymat_nahai = parseFloat(gheymat_nahai) + parseFloat(darsade_avarez_arzeshe_afzode) + parseFloat(darsade_maliate_arzeshe_afzode);
                                                    darsade_avarez_arzeshe_afzode = Float_Round(darsade_avarez_arzeshe_afzode, 2);
                                                    darsade_maliate_arzeshe_afzode = Float_Round(darsade_maliate_arzeshe_afzode, 2);
                                                    //console.log(gheymat_nahai);

                                                    // gheymat_nahai = parseFloat(gheymat_nahai + darsade_avarez_arzeshe_afzode + darsade_maliate_arzeshe_afzode);
                                                    // gheymat_nahai = Float_Round(gheymat_nahai, 2);

                                                    $('#sj_bs_darsade_avareze_arzeshe_afzode').val(darsade_avarez_arzeshe_afzode);
                                                    $('#sj_bs_maliate_arzeshe_afzode').val(darsade_maliate_arzeshe_afzode);
                                                    $('#sj_bs_mablaghe_ghabele_pardakht').val(gheymat_nahai);
                                                    $('#sj_bs_takhfif').val(takhfif);
                                                    $('#sj_bs_hazine_ranzhe').val(data[i]['hazine_ranzhe']);
                                                    $('#sj_bs_hazine_nasb').val(data[i]['hazine_nasb']);
                                                    $('#sj_bs_hazine_dranzhe').val(data[i]['hazine_dranzhe']);
                                                    $('#sj_bs_abonmane_port').val(data[i]['port']);
                                                    $('#sj_bs_abonmane_faza').val(data[i]['faza']);
                                                    $('#sj_bs_abonmane_tajhizat').val(data[i]['tajhizat']);
                                                    $('#sj_bs_subscriber_id').val(user_id);
                                                    $('#sj_bs_service_id').val(li_id);
                                                } else {
                                                    //takhfif nadarad
                                                    gheymat_nahai = gheymat + parseFloat(data[i]['hazine_ranzhe']) + parseInt(data[i]['hazine_nasb']) +
                                                        parseFloat(data[i]['hazine_dranzhe']) + parseFloat(data[i]['port']) +
                                                        parseFloat(data[i]['faza']) + parseFloat(data[i]['tajhizat']);
                                                    darsade_avarez_arzeshe_afzode = parseFloat((gheymat_nahai * darsade_avarez_arzeshe_afzode) / 100);
                                                    darsade_maliate_arzeshe_afzode = parseFloat((gheymat_nahai * darsade_maliate_arzeshe_afzode) / 100);
                                                    gheymat_nahai = parseFloat(gheymat_nahai) + parseFloat(darsade_avarez_arzeshe_afzode) + parseFloat(darsade_maliate_arzeshe_afzode);
                                                    darsade_avarez_arzeshe_afzode = Float_Round(darsade_avarez_arzeshe_afzode, 2);
                                                    darsade_maliate_arzeshe_afzode = Float_Round(darsade_maliate_arzeshe_afzode, 2);
                                                    // gheymat_nahai = parseFloat(gheymat_nahai + darsade_avarez_arzeshe_afzode + darsade_maliate_arzeshe_afzode);
                                                    // gheymat_nahai = Float_Round(gheymat_nahai, 2);
                                                    $('#sj_bs_darsade_avareze_arzeshe_afzode').val(darsade_avarez_arzeshe_afzode);
                                                    $('#sj_bs_maliate_arzeshe_afzode').val(darsade_maliate_arzeshe_afzode);
                                                    $('#sj_bs_mablaghe_ghabele_pardakht').val(gheymat_nahai);
                                                    $('#sj_bs_takhfif').val(takhfif);
                                                    $('#sj_bs_hazine_ranzhe').val(data[i]['hazine_ranzhe']);
                                                    $('#sj_bs_hazine_nasb').val(data[i]['hazine_nasb']);
                                                    $('#sj_bs_hazine_dranzhe').val(data[i]['hazine_dranzhe']);
                                                    $('#sj_bs_abonmane_port').val(data[i]['port']);
                                                    $('#sj_bs_abonmane_faza').val(data[i]['faza']);
                                                    $('#sj_bs_abonmane_tajhizat').val(data[i]['tajhizat']);
                                                    $('#sj_bs_subscriber_id').val(user_id);
                                                    $('#sj_bs_service_id').val(li_id);
                                                }
                                            }
                                        }
                                    });

                                }
                            });
                        }
                    });
                });
            }
        });
    });

    //sefareshe_jadid->adsl tab->click
    $("#adsl_tab_link").on('click', function() {
        var sefareshe_jadid_serviceslist = $("#sefareshe_jadid_serviceslist");
        sefareshe_jadid_serviceslist.empty();
        Factors_Initialize('sj_adsl_user_telephones', user_id, function(ports) {
            console.log(ports);
            var ports = ports;
            if (!check_isset_message(ports)) {
                var sj_adsl_telephone = $("#sj_adsl_telephone");
                var sj_adsl_noe_khadamat = $("#sj_adsl_noe_khadamat");
                var sj_adsl_ibs_username = $("#sj_adsl_ibs_username");
                sj_adsl_noe_khadamat.empty();
                sj_adsl_telephone.empty();
                appendOption(sj_adsl_telephone, ports, 'portid', 'telephonenumber');
                sj_adsl_telephone.prop("selectedIndex", -1);
                sj_adsl_telephone.on('change', function() {
                    let selected_phone = parseInt($(this).val());
                    sj_adsl_ibs_username.val(selected_phone);
                    for (let i = 0; i < ports.length; i++) {
                        if (ports[i]['portid'] === selected_phone) {
                            if (ports[i]['adsl_vdsl'] === 'adsl') {
                                sj_adsl_noe_khadamat.empty();
                                sj_adsl_noe_khadamat.append('<option value="ADSL(Share)">ADSL Share</option>');
                                sj_adsl_noe_khadamat.append('<option value="ADSL(Transport)">ADSL Transport</option>');
                                sj_adsl_noe_khadamat.prop("selectedIndex", -1);
                            } else {
                                sj_adsl_noe_khadamat.empty();
                                sj_adsl_noe_khadamat.append('<option value="VDSL(Share)">VDSL Share</option>');
                                sj_adsl_noe_khadamat.append('<option value="VDSL(Transport)">VDSL Transport</option>');
                                sj_adsl_noe_khadamat.prop("selectedIndex", -1);
                            }
                        }
                    }
                    ///////////////////
                    ajaxRequest('checkprevfactor', { 'subid': user_id, 'emkanatid': selected_phone, 'servicetype': 'adsl' }, window.location.href.split('/').slice(-1)[0], function(rescheckprevfactor) {
                        console.log(rescheckprevfactor);
                        if (rescheckprevfactor) {
                            Get_Maliat('', function(data_maliat) {
                                Factors_Initialize('adsl_services', false, function(data) {
                                    console.log(345);
                                    console.log(data);
                                    let sefareshe_jadid_serviceslist = $("#sefareshe_jadid_serviceslist");
                                    sj_adsl_noe_khadamat.on('change', function() {
                                        let noe_khadamat = $(this).val();
                                        switch (noe_khadamat) {
                                            case 'ADSL(Share)':
                                                sefareshe_jadid_serviceslist.empty();
                                                //////initializing->service list by noe_khadamat
                                                for (let i = 0; i < data.length; i++) {
                                                    if (data[i] && data[i]['noe_khadamat'] && data[i]['noe_khadamat'] === noe_khadamat) {
                                                        sefareshe_jadid_serviceslist.append("<li class='sefareshe_jadid_serviceslist_li' id='" + data[i]['id'] + "'>" + data[i]['onvane_service'] + "</li>");
                                                    }
                                                }
                                                break;
                                            case 'ADSL(Transport)':
                                                sefareshe_jadid_serviceslist.empty();
                                                //////initializing->service list by noe_khadamat
                                                for (let i = 0; i < data.length; i++) {
                                                    if (data[i] && data[i]['noe_khadamat'] && data[i]['noe_khadamat'] === noe_khadamat) {
                                                        sefareshe_jadid_serviceslist.append("<li class='sefareshe_jadid_serviceslist_li' id='" + data[i]['id'] + "'>" + data[i]['onvane_service'] + "</li>");
                                                    }
                                                }

                                                break;
                                            case 'VDSL(Share)':
                                                sefareshe_jadid_serviceslist.empty();
                                                //////initializing->service list by noe_khadamat
                                                for (let i = 0; i < data.length; i++) {
                                                    if (data[i] && data[i]['noe_khadamat'] && data[i]['noe_khadamat'] === noe_khadamat) {
                                                        sefareshe_jadid_serviceslist.append("<li class='sefareshe_jadid_serviceslist_li' id='" + data[i]['id'] + "'>" + data[i]['onvane_service'] + "</li>");
                                                    }
                                                }
                                                break;
                                            case 'VDSL(Transport)':
                                                sefareshe_jadid_serviceslist.empty();
                                                //////initializing->service list by noe_khadamat
                                                for (let i = 0; i < data.length; i++) {
                                                    if (data[i] && data[i]['noe_khadamat'] && data[i]['noe_khadamat'] === noe_khadamat) {
                                                        sefareshe_jadid_serviceslist.append("<li class='sefareshe_jadid_serviceslist_li' id='" + data[i]['id'] + "'>" + data[i]['onvane_service'] + "</li>");
                                                    }
                                                }
                                                break;
                                        }
                                        let sefareshe_jadid_serviceslist_li = $(".sefareshe_jadid_serviceslist_li");
                                        //////li->click
                                        //salam amin
                                        sefareshe_jadid_serviceslist_li.on('click', function() {
                                            let li_id = this.id;
                                            let int_li_id = parseInt(li_id);
                                            /////add tozihat to factor
                                            let sefareshe_jadid_tabs = $(".sefareshe_jadid_tabs");
                                            let tozihatlable = $(".tozihatlable");
                                            tozihatlable.remove();
                                            ////add tozihat to factor
                                            sefareshe_jadid_serviceslist_li.each(function() {
                                                $(this).css('background-color', '#fafafa');
                                            });
                                            $(this).css('background-color', '#26a69a');
                                            for (let i = 0; i < data.length; i++) {
                                                if (data[i] && data[i]['id'] === int_li_id) {
                                                    sefareshe_jadid_tabs.append("<legend class='text-uppercase font-size-md font-weight-bold tozihatlable'>" + data[i]['tozihate_faktor'] + "</legend>");
                                                    $('#sj_adsl_terafik').val(data[i]['terafik']);
                                                    $('#sj_adsl_zamane_estefade').val(tabdile_tarikh_adad(data[i]['zaname_estefade_betarikh']));
                                                    data[i]['tarikhe_shoroe_namayesh'] = tabdile_tarikh_adad(data[i]['tarikhe_shoroe_namayesh']);
                                                    data[i]['tarikhe_payane_namayesh'] = tabdile_tarikh_adad(data[i]['tarikhe_payane_namayesh']);
                                                    //$('#sj_adsl_tarikhe_shoroe_service').val(data[i]['tarikhe_shoroe_namayesh']);
                                                    $('#sj_adsl_tarikhe_payane_service').val(data[i]['zamane_estefade_betarikh']);
                                                    $('#sj_adsl_gheymate_service').val(data[i]['gheymat']);
                                                    let gheymat_nahai = 0;
                                                    let darsade_avarez_arzeshe_afzode = parseFloat(data_maliat[0]['darsade_avarez_arzeshe_afzode']);
                                                    let darsade_maliate_arzeshe_afzode = parseFloat(data_maliat[0]['darsade_maliate_arzeshe_afzode']);
                                                    let gheymat = parseFloat(data[i]['gheymat']);
                                                    let takhfif = parseFloat(data[i]['takhfif']);

                                                    if (rescheckprevfactor[0]['tedad'] !== 0) {
                                                        data[i]['hazine_ranzhe'] = 0;
                                                        data[i]['hazine_nasb'] = 0;
                                                        data[i]['hazine_dranzhe'] = 0;
                                                    }

                                                    if (!isEmpty(takhfif)) {
                                                        takhfif = (gheymat * takhfif) / 100;
                                                        gheymat = gheymat - takhfif;
                                                        gheymat_nahai = gheymat + parseFloat(data[i]['hazine_ranzhe']) + parseInt(data[i]['hazine_nasb']) +
                                                            parseFloat(data[i]['hazine_dranzhe']) + parseFloat(data[i]['port']) +
                                                            parseFloat(data[i]['faza']) + parseFloat(data[i]['tajhizat']);
                                                        darsade_avarez_arzeshe_afzode = parseFloat((gheymat_nahai * darsade_avarez_arzeshe_afzode) / 100);
                                                        darsade_maliate_arzeshe_afzode = parseFloat((gheymat_nahai * darsade_maliate_arzeshe_afzode) / 100);
                                                        gheymat_nahai = parseFloat(gheymat_nahai) + parseFloat(darsade_avarez_arzeshe_afzode) + parseFloat(darsade_maliate_arzeshe_afzode);
                                                        darsade_avarez_arzeshe_afzode = Float_Round(darsade_avarez_arzeshe_afzode, 2);
                                                        darsade_maliate_arzeshe_afzode = Float_Round(darsade_maliate_arzeshe_afzode, 2);
                                                        $('#sj_adsl_darsade_avareze_arzeshe_afzode').val(darsade_avarez_arzeshe_afzode);
                                                        $('#sj_adsl_maliate_arzeshe_afzode').val(darsade_maliate_arzeshe_afzode);
                                                        $('#sj_adsl_mablaghe_ghabele_pardakht').val(gheymat_nahai);
                                                        $('#sj_adsl_takhfif').val(takhfif);
                                                        $('#sj_adsl_hazine_ranzhe').val(data[i]['hazine_ranzhe']);
                                                        $('#sj_adsl_hazine_nasb').val(data[i]['hazine_nasb']);
                                                        $('#sj_adsl_hazine_dranzhe').val(data[i]['hazine_dranzhe']);
                                                        $('#sj_adsl_abonmane_port').val(data[i]['port']);
                                                        $('#sj_adsl_abonmane_faza').val(data[i]['faza']);
                                                        $('#sj_adsl_abonmane_tajhizat').val(data[i]['tajhizat']);
                                                        $('#sj_adsl_subscriber_id').val(user_id);
                                                        $('#sj_adsl_service_id').val(li_id);
                                                    } else {
                                                        gheymat_nahai = gheymat + parseFloat(data[i]['hazine_ranzhe']) + parseInt(data[i]['hazine_nasb']) +
                                                            parseFloat(data[i]['hazine_dranzhe']) + parseFloat(data[i]['port']) +
                                                            parseFloat(data[i]['faza']) + parseFloat(data[i]['tajhizat']);
                                                        darsade_avarez_arzeshe_afzode = parseFloat((gheymat_nahai * darsade_avarez_arzeshe_afzode) / 100);
                                                        darsade_maliate_arzeshe_afzode = parseFloat((gheymat_nahai * darsade_maliate_arzeshe_afzode) / 100);
                                                        gheymat_nahai = parseFloat(gheymat_nahai) + parseFloat(darsade_avarez_arzeshe_afzode) + parseFloat(darsade_maliate_arzeshe_afzode);
                                                        darsade_avarez_arzeshe_afzode = Float_Round(darsade_avarez_arzeshe_afzode, 2);
                                                        darsade_maliate_arzeshe_afzode = Float_Round(darsade_maliate_arzeshe_afzode, 2);
                                                        $('#sj_adsl_darsade_avareze_arzeshe_afzode').val(darsade_avarez_arzeshe_afzode);
                                                        $('#sj_adsl_maliate_arzeshe_afzode').val(darsade_maliate_arzeshe_afzode);
                                                        $('#sj_adsl_mablaghe_ghabele_pardakht').val(gheymat_nahai);
                                                        $('#sj_adsl_takhfif').val(takhfif);
                                                        $('#sj_adsl_hazine_ranzhe').val(data[i]['hazine_ranzhe']);
                                                        $('#sj_adsl_hazine_nasb').val(data[i]['hazine_nasb']);
                                                        $('#sj_adsl_hazine_dranzhe').val(data[i]['hazine_dranzhe']);
                                                        $('#sj_adsl_abonmane_port').val(data[i]['port']);
                                                        $('#sj_adsl_abonmane_faza').val(data[i]['faza']);
                                                        $('#sj_adsl_abonmane_tajhizat').val(data[i]['tajhizat']);
                                                        $('#sj_adsl_subscriber_id').val(user_id);
                                                        $('#sj_adsl_service_id').val(li_id);
                                                    }
                                                }
                                            }
                                        });
                                    });
                                });
                            });
                        }
                    });
                });

            } else {
                display_Predefiend_Messages(ports);
            }
        });
    });
    //sefareshe_jadid->wireless tab->click
    $("#wireless_tab_link").on('click', function() {
        let sefareshe_jadid_serviceslist = $(".sefareshe_jadid_serviceslist");
        sefareshe_jadid_serviceslist.empty();
        Factors_Initialize('sj_wireless_stations', user_id, function(stations) {
            let sj_wireless_istgah_name = $("#sj_wireless_istgah_name");
            sj_wireless_istgah_name.empty();
            if (!check_isset_message(stations)) {
                appendOption(sj_wireless_istgah_name, stations, 'emkanatid', 'stationname', 'linkname');
                sj_wireless_istgah_name.prop("selectedIndex", -1);
                sj_wireless_istgah_name.on('change', function(e) {
                    ajaxRequest('checkprevfactor', { 'subid': user_id, 'emkanatid': $(this).val(), 'servicetype': 'wireless' }, window.location.href.split('/').slice(-1)[0], function(rescheckprevfactor) {
                        console.log(rescheckprevfactor);
                        Get_Maliat('', function(data_maliat) {
                            Factors_Initialize('wireless_services', false, function(data) {
                                let sefareshe_jadid_serviceslist = $("#sefareshe_jadid_serviceslist");
                                let sj_wireless_noe_khadamat = $("#sj_wireless_noe_khadamat");
                                sj_wireless_noe_khadamat.prop("selectedIndex", -1);
                                sj_wireless_noe_khadamat.on('change', function() {
                                    //////
                                    //clear form...
                                    //////
                                    let noe_khadamat = $(this).val();
                                    switch (noe_khadamat) {
                                        case 'Wireless(Share)':
                                            sefareshe_jadid_serviceslist.empty();
                                            //////initializing->service list by noe_khadamat
                                            for (let i = 0; i < data.length; i++) {
                                                if (data[i] && data[i]['noe_khadamat'] && data[i]['noe_khadamat'] === noe_khadamat) {
                                                    sefareshe_jadid_serviceslist.append("<li class='sefareshe_jadid_serviceslist_li' id='" + data[i]['id'] + "'>" + data[i]['onvane_service'] + "</li>");
                                                }
                                            }
                                            break;
                                        case 'Wireless(Transport)':
                                            sefareshe_jadid_serviceslist.empty();
                                            //////initializing->service list by noe_khadamat
                                            for (let i = 0; i < data.length; i++) {
                                                if (data[i] && data[i]['noe_khadamat'] && data[i]['noe_khadamat'] === noe_khadamat) {
                                                    sefareshe_jadid_serviceslist.append("<li class='sefareshe_jadid_serviceslist_li' id='" + data[i]['id'] + "'>" + data[i]['onvane_service'] + "</li>");
                                                }
                                            }

                                            break;
                                        case 'Wireless(Hotspot)':
                                            sefareshe_jadid_serviceslist.empty();
                                            //////initializing->service list by noe_khadamat
                                            for (let i = 0; i < data.length; i++) {
                                                if (data[i] && data[i]['noe_khadamat'] && data[i]['noe_khadamat'] === noe_khadamat) {
                                                    sefareshe_jadid_serviceslist.append("<li class='sefareshe_jadid_serviceslist_li' id='" + data[i]['id'] + "'>" + data[i]['onvane_service'] + "</li>");
                                                }
                                            }
                                            break;
                                    }
                                    let sefareshe_jadid_serviceslist_li = $(".sefareshe_jadid_serviceslist_li");
                                    //////li->click
                                    sefareshe_jadid_serviceslist_li.on('click', function() {
                                        let li_id = this.id;
                                        let int_li_id = parseInt(li_id);
                                        /////add tozihat to factor
                                        let sefareshe_jadid_tabs = $(".sefareshe_jadid_tabs");
                                        let tozihatlable = $(".tozihatlable");
                                        tozihatlable.remove();
                                        ////add tozihat to factor
                                        sefareshe_jadid_serviceslist_li.each(function() {
                                            $(this).css('background-color', '#fafafa');
                                        });
                                        $(this).css('background-color', '#26a69a');
                                        for (let i = 0; i < data.length; i++) {
                                            if (data[i] && data[i]['id'] === int_li_id) {
                                                sefareshe_jadid_tabs.append("<legend class='text-uppercase font-size-md font-weight-bold tozihatlable'>" + data[i]['tozihate_faktor'] + "</legend>");
                                                $('#sj_wireless_terafik').val(data[i]['terafik']);
                                                $('#sj_wireless_zamane_estefade').val(data[i]['zaname_estefade']);
                                                data[i]['tarikhe_shoroe_namayesh'] = tabdile_tarikh_adad(data[i]['tarikhe_shoroe_namayesh']);
                                                data[i]['tarikhe_payane_namayesh'] = tabdile_tarikh_adad(data[i]['tarikhe_payane_namayesh']);
                                                //$('#sj_wireless_tarikhe_shoroe_service').val(data[i]['tarikhe_shoroe_namayesh']);
                                                $('#sj_wireless_tarikhe_payane_service').val(data[i]['zamane_estefade_betarikh']);
                                                $('#sj_wireless_gheymate_service').val(data[i]['gheymat']);
                                                let gheymat_nahai = 0;
                                                let darsade_avarez_arzeshe_afzode = parseFloat(data_maliat[0]['darsade_avarez_arzeshe_afzode']);
                                                let darsade_maliate_arzeshe_afzode = parseFloat(data_maliat[0]['darsade_maliate_arzeshe_afzode']);
                                                let gheymat = parseFloat(data[i]['gheymat']);
                                                let takhfif = parseFloat(data[i]['takhfif']);

                                                if (rescheckprevfactor[0]['tedad'] !== 0) {
                                                    data[i]['hazine_ranzhe'] = 0;
                                                    data[i]['hazine_nasb'] = 0;
                                                    data[i]['hazine_dranzhe'] = 0;
                                                }
                                                if (!isEmpty(takhfif)) {
                                                    //takhfif darad
                                                    takhfif = (gheymat * takhfif) / 100;
                                                    gheymat = gheymat - takhfif;
                                                    gheymat_nahai = gheymat + parseInt(data[i]['hazine_nasb']) +
                                                        parseFloat(data[i]['port']) +
                                                        parseFloat(data[i]['faza']) + parseFloat(data[i]['tajhizat']);
                                                    darsade_avarez_arzeshe_afzode = parseFloat((gheymat_nahai * darsade_avarez_arzeshe_afzode) / 100);
                                                    darsade_maliate_arzeshe_afzode = parseFloat((gheymat_nahai * darsade_maliate_arzeshe_afzode) / 100);
                                                    gheymat_nahai = parseFloat(gheymat_nahai) + parseFloat(darsade_avarez_arzeshe_afzode) + parseFloat(darsade_maliate_arzeshe_afzode);
                                                    darsade_avarez_arzeshe_afzode = Float_Round(darsade_avarez_arzeshe_afzode, 2);
                                                    darsade_maliate_arzeshe_afzode = Float_Round(darsade_maliate_arzeshe_afzode, 2);
                                                    // gheymat_nahai = parseFloat(gheymat_nahai + darsade_avarez_arzeshe_afzode + darsade_maliate_arzeshe_afzode);
                                                    // gheymat_nahai = Float_Round(gheymat_nahai, 2);
                                                    $('#sj_wireless_darsade_avareze_arzeshe_afzode').val(darsade_avarez_arzeshe_afzode);
                                                    $('#sj_wireless_maliate_arzeshe_afzode').val(darsade_maliate_arzeshe_afzode);
                                                    $('#sj_wireless_mablaghe_ghabele_pardakht').val(gheymat_nahai);
                                                    $('#sj_wireless_takhfif').val(takhfif);
                                                    $('#sj_wireless_hazine_nasb').val(data[i]['hazine_nasb']);
                                                    $('#sj_wireless_abonmane_port').val(data[i]['port']);
                                                    $('#sj_wireless_abonmane_faza').val(data[i]['faza']);
                                                    $('#sj_wireless_abonmane_tajhizat').val(data[i]['tajhizat']);
                                                    $('#sj_wireless_subscriber_id').val(user_id);
                                                    $('#sj_wireless_service_id').val(li_id);
                                                } else {
                                                    //takhfif nadarad
                                                    gheymat_nahai = gheymat + parseInt(data[i]['hazine_nasb']) +
                                                        parseFloat(data[i]['port']) +
                                                        parseFloat(data[i]['faza']) + parseFloat(data[i]['tajhizat']);
                                                    darsade_avarez_arzeshe_afzode = parseFloat((gheymat_nahai * darsade_avarez_arzeshe_afzode) / 100);
                                                    darsade_maliate_arzeshe_afzode = parseFloat((gheymat_nahai * darsade_maliate_arzeshe_afzode) / 100);
                                                    gheymat_nahai = parseFloat(gheymat_nahai) + parseFloat(darsade_avarez_arzeshe_afzode) + parseFloat(darsade_maliate_arzeshe_afzode);
                                                    darsade_avarez_arzeshe_afzode = Float_Round(darsade_avarez_arzeshe_afzode, 2);
                                                    darsade_maliate_arzeshe_afzode = Float_Round(darsade_maliate_arzeshe_afzode, 2);
                                                    // gheymat_nahai = parseFloat(gheymat_nahai + darsade_avarez_arzeshe_afzode + darsade_maliate_arzeshe_afzode);
                                                    // gheymat_nahai = Float_Round(gheymat_nahai, 2);
                                                    $('#sj_wireless_darsade_avareze_arzeshe_afzode').val(darsade_avarez_arzeshe_afzode);
                                                    $('#sj_wireless_maliate_arzeshe_afzode').val(darsade_maliate_arzeshe_afzode);
                                                    $('#sj_wireless_mablaghe_ghabele_pardakht').val(gheymat_nahai);
                                                    $('#sj_wireless_takhfif').val(takhfif);
                                                    $('#sj_wireless_hazine_nasb').val(data[i]['hazine_nasb']);
                                                    $('#sj_wireless_abonmane_port').val(data[i]['port']);
                                                    $('#sj_wireless_abonmane_faza').val(data[i]['faza']);
                                                    $('#sj_wireless_abonmane_tajhizat').val(data[i]['tajhizat']);
                                                    $('#sj_wireless_subscriber_id').val(user_id);
                                                    $('#sj_wireless_service_id').val(li_id);
                                                }
                                            }
                                        }
                                    });
                                });
                            });
                        });
                    });
                });
            } else {
                display_Predefiend_Messages(stations);
            }
        });
    });
    //sefareshe_jadid->tdlte tab->click
    $("#tdlte_tab_link").on('click', function() {

        let sefareshe_jadid_serviceslist = $(".sefareshe_jadid_serviceslist");
        sefareshe_jadid_serviceslist.empty();
        Factors_Initialize_Two_Params('sj_tdlte_user_sims', user_id, false, function(data_tdlte) {
            var sj_tdlte_tdlte_number = $("#sj_tdlte_tdlte_number");
            if (!check_isset_message(data_tdlte)) {
                // for (let i = 0; i < data_tdlte.length; i++) {
                //     sj_tdlte_tdlte_number.append(`<option value="${data_tdlte[i]['emkanatid']}">${data_tdlte[i]['tdlte_number']}</option>`);
                // }
                appendOption(sj_tdlte_tdlte_number, data_tdlte, 'emkanatid', 'tdlte_number');
                sj_tdlte_tdlte_number.on('change', function(e) {
                    ajaxRequest('checkprevfactor', { 'subid': user_id, 'emkanatid': $(this).val(), 'servicetype': 'tdlte' }, window.location.href.split('/').slice(-1)[0], function(rescheckprevfactor) {
                        Get_Maliat('', function(data_maliat) {
                            Factors_Initialize('tdlte_services', false, function(data) {
                                let sefareshe_jadid_serviceslist = $("#sefareshe_jadid_serviceslist");
                                let sj_tdlte_noe_khadamat = $("#sj_tdlte_noe_khadamat");
                                sj_tdlte_noe_khadamat.prop("selectedIndex", -1);
                                sj_tdlte_noe_khadamat.on('change', function() {
                                    let noe_khadamat = $(this).val();
                                    ///////tdlte
                                    switch (noe_khadamat) {
                                        case 'TD-LTE(Share)':
                                            sefareshe_jadid_serviceslist.empty();
                                            //////initializing->service list by noe_khadamat
                                            for (let i = 0; i < data.length; i++) {
                                                if (data[i] && data[i]['noe_khadamat'] && data[i]['noe_khadamat'] === noe_khadamat) {
                                                    sefareshe_jadid_serviceslist.append("<li class='sefareshe_jadid_serviceslist_li' id='" + data[i]['id'] + "'>" + data[i]['onvane_service'] + "</li>");
                                                }
                                            }
                                            break;
                                        case 'TD-LTE(Transport)':
                                            sefareshe_jadid_serviceslist.empty();
                                            //////initializing->service list by noe_khadamat
                                            for (let i = 0; i < data.length; i++) {
                                                if (data[i] && data[i]['noe_khadamat'] && data[i]['noe_khadamat'] === noe_khadamat) {
                                                    sefareshe_jadid_serviceslist.append("<li class='sefareshe_jadid_serviceslist_li' id='" + data[i]['id'] + "'>" + data[i]['onvane_service'] + "</li>");
                                                }
                                            }
                                            break;
                                    }
                                    let sefareshe_jadid_serviceslist_li = $(".sefareshe_jadid_serviceslist_li");
                                    //////li->click
                                    sefareshe_jadid_serviceslist_li.on('click', function() {
                                        let li_id = this.id;
                                        let int_li_id = parseInt(li_id);
                                        /////add tozihat to factor
                                        let sefareshe_jadid_tabs = $(".sefareshe_jadid_tabs");
                                        let tozihatlable = $(".tozihatlable");
                                        tozihatlable.remove();
                                        ////add tozihat to factor
                                        sefareshe_jadid_serviceslist_li.each(function() {
                                            $(this).css('background-color', '#fafafa');
                                        });
                                        $(this).css('background-color', '#26a69a');
                                        for (let i = 0; i < data.length; i++) {
                                            if (data[i] && data[i]['id'] === int_li_id) {
                                                sefareshe_jadid_tabs.append("<legend class='text-uppercase font-size-md font-weight-bold tozihatlable'>" + data[i]['tozihate_faktor'] + "</legend>");
                                                $('#sj_tdlte_terafik').val(data[i]['terafik']);
                                                $('#sj_tdlte_zamane_estefade').val(data[i]['zaname_estefade']);
                                                data[i]['tarikhe_shoroe_namayesh'] = tabdile_tarikh_adad(data[i]['tarikhe_shoroe_namayesh']);
                                                data[i]['tarikhe_payane_namayesh'] = tabdile_tarikh_adad(data[i]['tarikhe_payane_namayesh']);
                                                //$('#sj_tdlte_tarikhe_shoroe_service').val(data[i]['tarikhe_shoroe_namayesh']);
                                                $('#sj_tdlte_tarikhe_payane_service').val(data[i]['zamane_estefade_betarikh']);
                                                $('#sj_tdlte_gheymate_service').val(data[i]['gheymat']);
                                                let gheymat_nahai = 0;
                                                let darsade_avarez_arzeshe_afzode = parseFloat(data_maliat[0]['darsade_avarez_arzeshe_afzode']);
                                                let darsade_maliate_arzeshe_afzode = parseFloat(data_maliat[0]['darsade_maliate_arzeshe_afzode']);
                                                let gheymat = parseFloat(data[i]['gheymat']);
                                                let takhfif = parseFloat(data[i]['takhfif']);
                                                if (rescheckprevfactor[0]['tedad'] !== 0) {
                                                    data[i]['hazine_ranzhe'] = 0;
                                                    data[i]['hazine_nasb'] = 0;
                                                    data[i]['hazine_dranzhe'] = 0;
                                                }
                                                if (!isEmpty(takhfif)) {
                                                    //takhfif darad
                                                    takhfif = (gheymat * takhfif) / 100;
                                                    gheymat = gheymat - takhfif;
                                                    gheymat_nahai = gheymat +
                                                        parseInt(data[i]['hazine_nasb']) +
                                                        parseFloat(data[i]['port']) +
                                                        parseFloat(data[i]['faza']) +
                                                        parseFloat(data[i]['tajhizat']);
                                                    darsade_avarez_arzeshe_afzode = parseFloat((gheymat_nahai * darsade_avarez_arzeshe_afzode) / 100);
                                                    darsade_maliate_arzeshe_afzode = parseFloat((gheymat_nahai * darsade_maliate_arzeshe_afzode) / 100);
                                                    gheymat_nahai = parseFloat(gheymat_nahai) + parseFloat(darsade_avarez_arzeshe_afzode) + parseFloat(darsade_maliate_arzeshe_afzode);
                                                    darsade_avarez_arzeshe_afzode = Float_Round(darsade_avarez_arzeshe_afzode, 2);
                                                    darsade_maliate_arzeshe_afzode = Float_Round(darsade_maliate_arzeshe_afzode, 2);
                                                    // gheymat_nahai = parseFloat(gheymat_nahai + darsade_avarez_arzeshe_afzode + darsade_maliate_arzeshe_afzode);
                                                    // gheymat_nahai = Float_Round(gheymat_nahai, 2);
                                                    $('#sj_tdlte_darsade_avareze_arzeshe_afzode').val(darsade_avarez_arzeshe_afzode);
                                                    $('#sj_tdlte_maliate_arzeshe_afzode').val(darsade_maliate_arzeshe_afzode);
                                                    $('#sj_tdlte_mablaghe_ghabele_pardakht').val(gheymat_nahai);
                                                    $('#sj_tdlte_takhfif').val(takhfif);
                                                    $('#sj_tdlte_hazine_nasb').val(data[i]['hazine_nasb']);
                                                    $('#sj_tdlte_abonmane_port').val(data[i]['port']);
                                                    $('#sj_tdlte_abonmane_faza').val(data[i]['faza']);
                                                    $('#sj_tdlte_abonmane_tajhizat').val(data[i]['tajhizat']);
                                                    $('#sj_tdlte_subscriber_id').val(user_id);
                                                    $('#sj_tdlte_service_id').val(li_id);
                                                } else {
                                                    //takhfif nadarad
                                                    gheymat_nahai = gheymat + parseInt(data[i]['hazine_nasb']) +
                                                        parseFloat(data[i]['port']) +
                                                        parseFloat(data[i]['faza']) + parseFloat(data[i]['tajhizat']);
                                                    darsade_avarez_arzeshe_afzode = parseFloat((gheymat_nahai * darsade_avarez_arzeshe_afzode) / 100);
                                                    darsade_maliate_arzeshe_afzode = parseFloat((gheymat_nahai * darsade_maliate_arzeshe_afzode) / 100);
                                                    gheymat_nahai = parseFloat(gheymat_nahai) + parseFloat(darsade_avarez_arzeshe_afzode) + parseFloat(darsade_maliate_arzeshe_afzode);
                                                    darsade_avarez_arzeshe_afzode = Float_Round(darsade_avarez_arzeshe_afzode, 2);
                                                    darsade_maliate_arzeshe_afzode = Float_Round(darsade_maliate_arzeshe_afzode, 2);
                                                    // gheymat_nahai = parseFloat(gheymat_nahai + darsade_avarez_arzeshe_afzode + darsade_maliate_arzeshe_afzode);
                                                    // gheymat_nahai = Float_Round(gheymat_nahai, 2);
                                                    $('#sj_tdlte_darsade_avareze_arzeshe_afzode').val(darsade_avarez_arzeshe_afzode);
                                                    $('#sj_tdlte_maliate_arzeshe_afzode').val(darsade_maliate_arzeshe_afzode);
                                                    $('#sj_tdlte_mablaghe_ghabele_pardakht').val(gheymat_nahai);
                                                    $('#sj_tdlte_takhfif').val(takhfif);
                                                    $('#sj_tdlte_hazine_nasb').val(data[i]['hazine_nasb']);
                                                    $('#sj_tdlte_abonmane_port').val(data[i]['port']);
                                                    $('#sj_tdlte_abonmane_faza').val(data[i]['faza']);
                                                    $('#sj_tdlte_abonmane_tajhizat').val(data[i]['tajhizat']);
                                                    $('#sj_tdlte_subscriber_id').val(user_id);
                                                    $('#sj_tdlte_service_id').val(li_id);
                                                }
                                            }
                                        }
                                    });
                                });
                            });
                        });
                    });
                });
            } else {
                display_Predefiend_Messages(data_tdlte);
            }
        });
    });
    //sefareshe_jadid->voip tab->click
    $("#voip_tab_link").on('click', function() {
        let sefareshe_jadid_serviceslist = $(".sefareshe_jadid_serviceslist");
        sefareshe_jadid_serviceslist.empty();
        let sj_voip_subscriber_id = $("#sj_voip_subscriber_id");
        sj_voip_subscriber_id.val(user_id);
        Factors_Initialize('sj_voip_get_user_telephone', user_id, function(data) {

            let sj_voip_etebare_ghabele_enteghal = $("#sj_voip_etebare_ghabele_enteghal");
            let sj_voip_ibs_username = $("#sj_voip_ibs_username");
            let sj_voip_etebare_baghimande = $("#sj_voip_etebare_baghimande");
            sj_voip_ibs_username.empty();
            if (data[0]['telephone1']) {
                sj_voip_ibs_username.append('<option value="1">' + data[0]['telephone1'] + '</option>');
            }
            if (data[0]['telephone2']) {
                sj_voip_ibs_username.append('<option value="2">' + data[0]['telephone2'] + '</option>');
            }
            if (data[0]['telephone3']) {
                sj_voip_ibs_username.append('<option value="3">' + data[0]['telephone3'] + '</option>');
            }
            sj_voip_ibs_username.prop("selectedIndex", -1);
            sj_voip_ibs_username.on('change', function() {
                Factors_Initialize_Two_Params('sj_get_ibs_credit', $(this).val(), user_id, function(ibs_result) {
                    console.log(ibs_result);
                    if (!check_isset_message(ibs_result)) {
                        sj_voip_etebare_baghimande.val(ibs_result['current_credit']);
                        sj_voip_etebare_ghabele_enteghal.val(ibs_result['available_credit']);
                    } else {
                        display_Predefiend_Messages(ibs_result);
                    }
                });
            });
            Get_Maliat('', function(data_maliat) {
                Factors_Initialize('voip_services', false, function(data) {
                    var data = data;
                    let sefareshe_jadid_serviceslist = $("#sefareshe_jadid_serviceslist");
                    let sj_voip_noe_khadamat = $("#sj_voip_noe_khadamat");

                    sj_voip_noe_khadamat.prop("selectedIndex", -1);
                    sj_voip_noe_khadamat.on('change', function() {
                        let noe_khadamat = $(this).val();
                        ////////voip
                        switch (noe_khadamat) {
                            case 'carti':
                                sefareshe_jadid_serviceslist.empty();
                                //////initializing->service list by noe_khadamat
                                for (let i = 0; i < data.length; i++) {
                                    if (data[i] && data[i]['noe_khadamat'] && data[i]['noe_khadamat'] === noe_khadamat) {
                                        sefareshe_jadid_serviceslist.append("<li class='sefareshe_jadid_serviceslist_li' id='" + data[i]['id'] + "'>" + data[i]['onvane_service'] + "</li>");
                                    }
                                }
                                break;
                            case 'etebari':
                                sefareshe_jadid_serviceslist.empty();
                                //////initializing->service list by noe_khadamat
                                for (let i = 0; i < data.length; i++) {
                                    if (data[i] && data[i]['noe_khadamat'] && data[i]['noe_khadamat'] === noe_khadamat) {
                                        sefareshe_jadid_serviceslist.append("<li class='sefareshe_jadid_serviceslist_li' id='" + data[i]['id'] + "'>" + data[i]['onvane_service'] + "</li>");
                                    }
                                }
                                break;
                        }



                        let sefareshe_jadid_serviceslist_li = $(".sefareshe_jadid_serviceslist_li");
                        //////li->click
                        sefareshe_jadid_serviceslist_li.on('click', function() {
                            let li_id = this.id;
                            let int_li_id = parseInt(li_id);
                            /////add tozihat to factor
                            let sefareshe_jadid_tabs = $(".sefareshe_jadid_tabs");
                            let tozihatlable = $(".tozihatlable");
                            tozihatlable.remove();
                            ////add tozihat to factor
                            sefareshe_jadid_serviceslist_li.each(function() {
                                $(this).css('background-color', '#fafafa');
                            });
                            $(this).css('background-color', '#26a69a');
                            for (let i = 0; i < data.length; i++) {
                                if (data[i] && data[i]['id'] === int_li_id) {
                                    sefareshe_jadid_tabs.append("<legend class='text-uppercase font-size-md font-weight-bold tozihatlable'>" + data[i]['tozihate_faktor'] + "</legend>");
                                    // let tarikh = tarikhConvertOrSplit(data[i]['tarikhe_zamane_estefade'], '-', true, 'gtj', '/');
                                    // console.log(tarikh);
                                    // if (tarikh) {
                                    //     $('#sj_voip_tarikhe_payane_service').val(tarikh);
                                    // }
                                    $('#sj_voip_terafik').val(data[i]['terafik']);
                                    $('#sj_voip_zamane_estefade').val(data[i]['zaname_estefade']);
                                    data[i]['tarikhe_shoroe_namayesh'] = tabdile_tarikh_adad(data[i]['tarikhe_shoroe_namayesh']);
                                    data[i]['tarikhe_payane_namayesh'] = tabdile_tarikh_adad(data[i]['tarikhe_payane_namayesh']);
                                    // $('#sj_voip_tarikhe_shoroe_service').val(data[i]['tarikhe_zamane_estefade']);
                                    $('#sj_voip_tarikhe_payane_service').val(data[i]['zamane_estefade_betarikh']);
                                    $('#sj_voip_gheymate_service').val(data[i]['gheymat']);
                                    let gheymat_nahai = 0;
                                    let darsade_avarez_arzeshe_afzode = parseFloat(data_maliat[0]['darsade_avarez_arzeshe_afzode']);
                                    let darsade_maliate_arzeshe_afzode = parseFloat(data_maliat[0]['darsade_maliate_arzeshe_afzode']);
                                    let gheymat = parseFloat(data[i]['gheymat']);
                                    let takhfif = parseFloat(data[i]['takhfif']);
                                    ////////mohasebe gheymate nahai
                                    if (takhfif !== 0 || takhfif !== null || takhfif !== '' || takhfif !== undefined || takhfif !== NaN || takhfif !== 'undefined') {
                                        //takhfif darad
                                        takhfif = (gheymat * takhfif) / 100;
                                        gheymat = gheymat - takhfif;
                                        gheymat_nahai = gheymat;


                                        darsade_avarez_arzeshe_afzode = parseFloat((gheymat_nahai * darsade_avarez_arzeshe_afzode) / 100);
                                        darsade_avarez_arzeshe_afzode = Float_Round(darsade_avarez_arzeshe_afzode, 2);
                                        darsade_maliate_arzeshe_afzode = parseFloat((gheymat_nahai * darsade_maliate_arzeshe_afzode) / 100);
                                        darsade_maliate_arzeshe_afzode = Float_Round(darsade_maliate_arzeshe_afzode, 2);
                                        gheymat_nahai = parseFloat(gheymat_nahai) + parseFloat(darsade_avarez_arzeshe_afzode) + parseFloat(darsade_maliate_arzeshe_afzode);

                                        // gheymat_nahai = parseFloat(gheymat_nahai + darsade_avarez_arzeshe_afzode + darsade_maliate_arzeshe_afzode);
                                        // gheymat_nahai = Float_Round(gheymat_nahai, 2);
                                        $('#sj_voip_darsade_avareze_arzeshe_afzode').val(darsade_avarez_arzeshe_afzode);
                                        $('#sj_voip_maliate_arzeshe_afzode').val(darsade_maliate_arzeshe_afzode);
                                        $('#sj_voip_mablaghe_ghabele_pardakht').val(gheymat_nahai);
                                        $('#sj_voip_takhfif').val(takhfif);
                                        $('#sj_voip_hazine_nasb').val(data[i]['hazine_nasb']);
                                        $('#sj_voip_abonmane_port').val(data[i]['port']);
                                        $('#sj_voip_abonmane_faza').val(data[i]['faza']);
                                        $('#sj_voip_abonmane_tajhizat').val(data[i]['tajhizat']);
                                        $('#sj_voip_subscriber_id').val(user_id);
                                        $('#sj_voip_service_id').val(li_id);
                                    } else {
                                        //takhfif nadarad
                                        gheymat_nahai = gheymat;
                                        darsade_avarez_arzeshe_afzode = parseFloat((gheymat_nahai * darsade_avarez_arzeshe_afzode) / 100);
                                        darsade_avarez_arzeshe_afzode = Float_Round(darsade_avarez_arzeshe_afzode, 2);
                                        darsade_maliate_arzeshe_afzode = parseFloat((gheymat_nahai * darsade_maliate_arzeshe_afzode) / 100);
                                        darsade_maliate_arzeshe_afzode = Float_Round(darsade_maliate_arzeshe_afzode, 2);
                                        gheymat_nahai = parseFloat(gheymat_nahai) + parseFloat(darsade_avarez_arzeshe_afzode) + parseFloat(darsade_maliate_arzeshe_afzode);
                                        $('#sj_voip_darsade_avareze_arzeshe_afzode').val(darsade_avarez_arzeshe_afzode);
                                        $('#sj_voip_maliate_arzeshe_afzode').val(darsade_maliate_arzeshe_afzode);
                                        $('#sj_voip_mablaghe_ghabele_pardakht').val(gheymat_nahai);
                                        $('#sj_voip_takhfif').val(takhfif);
                                        $('#sj_voip_hazine_nasb').val(data[i]['hazine_nasb']);
                                        $('#sj_voip_abonmane_port').val(data[i]['port']);
                                        $('#sj_voip_abonmane_faza').val(data[i]['faza']);
                                        $('#sj_voip_abonmane_tajhizat').val(data[i]['tajhizat']);
                                        $('#sj_voip_subscriber_id').val(user_id);
                                        $('#sj_voip_service_id').val(li_id);
                                    }
                                }
                            }
                        });

                    });
                });
            });
        });
    });
    //sefareshe_jadid->ip tab->click
    $("#ip_adsl_tab_link").on('click', function() {
        let sj_ip_adsl_subscriber_id = $("#sj_ip_adsl_subscriber_id");
        sj_ip_adsl_subscriber_id.empty();
        Factors_Initialize('sj_ip_adsl_get_user_services', user_id, function(data) {
            console.log(data);
            for (let i = 0; i < data.length; i++) {
                sj_ip_adsl_subscriber_id.append('<option value=' + data[i].id + '>' + data[i]['telephone'] + '</option>');
            }
        });
    });
    ///////////////////////////////////////////confirm click for factor ha table
    $('#factorconfirm').on('click', function() {
        let tr = $('#factor_tab tbody').find('tr.selected');
        let td = tr.find('td:first').text();
        factor_id = td;
        if (factor_id !== '') {
            Factors_Initialize('find_factor_by_id', factor_id, function(data) {
                /////Factorha Tab -> ADSL/WIRELESS/TDLTE/VOIP FORM
                switch (data[0]['type']) {
                    case 'adsl':
                    case 'vdsl':
                        $("#modal_form_factortab_adsl").modal('show');
                        $('#ft_adsl_noe_khadamat option[value="' + data[0]["noe_khadamat"] + '"]').attr('selected', 'selected');
                        $('#ft_adsl_id').val(data[0]['id']);

                        $('#ft_adsl_tarikhe_marjo_shode').val(Getor_String(data[0]['tarikhe_marjo_shode'], 'ثبت نشده'));
                        $('#ft_adsl_marjo_konande').val(Getor_String(data[0]['marjo_konande'], 'ثبت نشده'));
                        $('#ft_adsl_tarikhe_tasvie_shode').val(Getor_String(data[0]['tarikhe_tasvie_shode']), 'ثبت نشده');
                        $('#ft_adsl_tasvie_konande').val(Getor_String(data[0]['tasvie_konande']), 'ثبت نشده');
                        $('#ft_adsl_tozihate_disable_shode').val(Getor_String(data[0]['tozihate_disable_shode']), 'ثبت نشده');
                        $('#ft_adsl_tarikhe_disable_shode').val(Getor_String(data[0]['tarikhe_disable_shode']), 'ثبت نشده');
                        $('#ft_adsl_disable_konande').val(Getor_String(data[0]['disable_konande']), 'ثبت نشده');

                        $('#ft_adsl_terafik').val(data[0]['terafik']);
                        $('#ft_adsl_zaname_estefade_be_tarikh').val(data[0]['zaname_estefade_be_tarikh']);
                        $('#ft_adsl_tarikhe_shoroe_service').val(data[0]['tarikhe_shoroe_service']);
                        $('#ft_adsl_tarikhe_payane_service').val(data[0]['tarikhe_payane_service']);
                        $('#ft_adsl_gheymate_service').val(data[0]['gheymate_service']);
                        $('#ft_adsl_takhfif').val(data[0]['takhfif']);
                        $('#ft_adsl_hazine_ranzhe').val(data[0]['hazine_ranzhe']);
                        $('#ft_adsl_hazine_dranzhe').val(data[0]['hazine_dranzhe']);
                        $('#ft_adsl_hazine_nasb').val(data[0]['hazine_nasb']);
                        $('#ft_adsl_abonmane_port').val(data[0]['abonmane_port']);
                        $('#ft_adsl_abonmane_faza').val(data[0]['abonmane_faza']);
                        $('#ft_adsl_abonmane_tajhizat').val(data[0]['abonmane_tajhizat']);
                        $('#ft_adsl_darsade_avareze_arzeshe_afzode').val(data[0]['darsade_avareze_arzeshe_afzode']);
                        $('#ft_adsl_maliate_arzeshe_afzode').val(data[0]['maliate_arzeshe_afzode']);
                        $('#ft_adsl_mablaghe_ghabele_pardakht').val(data[0]['mablaghe_ghabele_pardakht']);
                        ///////////////////////////////////service status checkboxex
                        if (data[0]['daryafte_etelaat'] === '1') {
                            $("#ft_adsl_daryafte_etelaat").prop("checked", true);
                            $("#ft_adsl_daryafte_etelaat").attr("onclick", "return false");
                        } else {
                            $("#ft_adsl_daryafte_etelaat").prop("checked", false);
                        }
                        if (data[0]['ehraze_hoviat'] === '1') {
                            $("#ft_adsl_ehraze_hoviat").prop("checked", true);
                            $("#ft_adsl_ehraze_hoviat").attr("onclick", "return false");
                            $("#ft_adsl_daryafte_etelaat").attr("onclick", "return false");
                        } else {
                            $("#ft_adsl_ehraze_hoviat").prop("checked", false);
                        }
                        if (data[0]['eneghade_gharardad'] === '1') {
                            $("#ft_adsl_eneghade_gharardad").prop("checked", true);
                            $("#ft_adsl_eneghade_gharardad").attr("onclick", "return false");
                            $("#ft_adsl_ehraze_hoviat").attr("onclick", "return false");
                            $("#ft_adsl_daryafte_etelaat").attr("onclick", "return false");
                        } else {
                            $("#ft_adsl_eneghade_gharardad").prop("checked", false);
                        }
                        if (data[0]['entezare_mokhaberat'] === '1') {
                            $("#ft_adsl_entezare_mokhaberat").prop("checked", true);
                            $("#ft_adsl_entezare_mokhaberat").attr("onclick", "return false");
                            $("#ft_adsl_eneghade_gharardad").attr("onclick", "return false");
                            $("#ft_adsl_ehraze_hoviat").attr("onclick", "return false");
                            $("#ft_adsl_daryafte_etelaat").attr("onclick", "return false");
                        } else {
                            $("#ft_adsl_entezare_mokhaberat").prop("checked", false);
                        }
                        if (data[0]['entezare_ranzhe'] === '1') {
                            $("#ft_adsl_entezare_ranzhe").prop("checked", true);
                            $("#ft_adsl_entezare_ranzhe").attr("onclick", "return false");
                            $("#ft_adsl_entezare_mokhaberat").attr("onclick", "return false");
                            $("#ft_adsl_eneghade_gharardad").attr("onclick", "return false");
                            $("#ft_adsl_ehraze_hoviat").attr("onclick", "return false");
                            $("#ft_adsl_daryafte_etelaat").attr("onclick", "return false");
                        } else {
                            $("#ft_adsl_entezare_ranzhe").prop("checked", false);
                        }
                        if (data[0]['faal_sazie_avalie'] === '1') {
                            $("#ft_adsl_faal_sazie_avalie").prop("checked", true);
                            $("#ft_adsl_faal_sazie_avalie").attr("onclick", "return false");
                            $("#ft_adsl_entezare_ranzhe").attr("onclick", "return false");
                            $("#ft_adsl_entezare_mokhaberat").attr("onclick", "return false");
                            $("#ft_adsl_eneghade_gharardad").attr("onclick", "return false");
                            $("#ft_adsl_ehraze_hoviat").attr("onclick", "return false");
                            $("#ft_adsl_daryafte_etelaat").attr("onclick", "return false");
                        } else {
                            $("#ft_adsl_faal_sazie_avalie").prop("checked", false);
                        }
                        if (data[0]['entezare_nasb'] === '1') {
                            $("#ft_adsl_entezare_nasb").prop("checked", true);
                            $("#ft_adsl_entezare_nasb").attr("onclick", "return false");
                            $("#ft_adsl_faal_sazie_avalie").attr("onclick", "return false");
                            $("#ft_adsl_entezare_ranzhe").attr("onclick", "return false");
                            $("#ft_adsl_entezare_mokhaberat").attr("onclick", "return false");
                            $("#ft_adsl_eneghade_gharardad").attr("onclick", "return false");
                            $("#ft_adsl_ehraze_hoviat").attr("onclick", "return false");
                            $("#ft_adsl_daryafte_etelaat").attr("onclick", "return false");
                        } else {
                            $("#ft_adsl_entezare_nasb").prop("checked", false);
                        }
                        if (data[0]['faal'] === '1') {
                            $("#ft_adsl_faal").prop("checked", true);
                            $("#ft_adsl_faal").attr("onclick", "return false");
                            $("#ft_adsl_entezare_nasb").attr("onclick", "return false");
                            $("#ft_adsl_faal_sazie_avalie").attr("onclick", "return false");
                            $("#ft_adsl_entezare_ranzhe").attr("onclick", "return false");
                            $("#ft_adsl_entezare_mokhaberat").attr("onclick", "return false");
                            $("#ft_adsl_eneghade_gharardad").attr("onclick", "return false");
                            $("#ft_adsl_ehraze_hoviat").attr("onclick", "return false");
                            $("#ft_adsl_daryafte_etelaat").attr("onclick", "return false");
                        } else {
                            $("#ft_adsl_faal").prop("checked", false);
                        }
                        if (data[0]['marjo'] === '1') {
                            $("#ft_adsl_marjo").prop("checked", true);
                            $("#ft_adsl_marjo").attr("onclick", "return false");
                            $("#ft_adsl_faal").attr("onclick", "return false");
                            $("#ft_adsl_entezare_nasb").attr("onclick", "return false");
                            $("#ft_adsl_faal_sazie_avalie").attr("onclick", "return false");
                            $("#ft_adsl_entezare_ranzhe").attr("onclick", "return false");
                            $("#ft_adsl_entezare_mokhaberat").attr("onclick", "return false");
                            $("#ft_adsl_eneghade_gharardad").attr("onclick", "return false");
                            $("#ft_adsl_ehraze_hoviat").attr("onclick", "return false");
                            $("#ft_adsl_daryafte_etelaat").attr("onclick", "return false");
                        } else {
                            $("#ft_adsl_marjo").prop("checked", false);
                        }
                        ///////////////////////////////////service status checkboxex
                        ///////////////////////////////////factor status checkboxex
                        if (data[0]['sharje_mojadad'] === '1') {
                            $("#ft_adsl_sharje_mojadad").prop("checked", true);
                            $("#ft_adsl_sharje_mojadad").attr("onclick", "return false");
                        } else {
                            $("#ft_adsl_sharje_mojadad").prop("checked", false);
                            $("#ft_adsl_sharje_mojadad").attr("onclick", "return false");
                        }
                        if (data[0]['print_shode'] === '1') {
                            $("#ft_adsl_print_shode").prop("checked", true);
                            $("#ft_adsl_print_shode").attr("onclick", "return false");
                        } else {
                            $("#ft_adsl_print_shode").prop("checked", false);
                            $("#ft_adsl_print_shode").attr("onclick", "return false");
                        }
                        if (data[0]['ersal_shode'] === '1') {
                            $("#ft_adsl_ersal_shode").prop("checked", true);
                            $("#ft_adsl_ersal_shode").attr("onclick", "return false");
                        } else {
                            $("#ft_adsl_ersal_shode").prop("checked", false);
                            $("#ft_adsl_ersal_shode").attr("onclick", "return false");
                        }
                        if (data[0]['marjo_shode'] === '1') {
                            $("#ft_adsl_marjo_shode").prop("checked", true);
                            //$("#ft_adsl_marjo_shode").attr("onclick","return false");
                        } else {
                            $("#ft_adsl_marjo_shode").prop("checked", false);
                            //$("#ft_adsl_marjo_shode").attr("onclick","return false");
                        }
                        if (data[0]['disable_shode'] === '1') {
                            $("#ft_adsl_disable_shode").prop("checked", true);
                            //$("#ft_adsl_marjo_shode").attr("onclick","return false");
                        } else {
                            $("#ft_adsl_disable_shode").prop("checked", false);
                            //$("#ft_adsl_marjo_shode").attr("onclick","return false");
                        }
                        if (data[0]['tasvie_shode'] === '1') {
                            $("#ft_adsl_tasvie_shode").prop("checked", true);
                            //$("#ft_adsl_tasvie_shode").attr("onclick","return false");
                        } else {
                            $("#ft_adsl_tasvie_shode").prop("checked", false);
                            //$("#ft_adsl_tasvie_shode").attr("onclick","return false");
                        }
                        ///////////////////////////////////factor status checkboxex
                        ///////////////////////////////////factor status tozihat
                        if (data[0]['tozihate_marjo_shode'] != null && data[0]['tozihate_marjo_shode'].length > 0) {
                            $("#ft_adsl_tozihate_marjo_shode").val(data[0]['tozihate_marjo_shode']);
                        }
                        if (data[0]['tozihate_tasvie_shode'] != null && data[0]['tozihate_tasvie_shode'].length > 0) {
                            $("#ft_adsl_tozihate_tasvie_shode").val(data[0]['tozihate_tasvie_shode']);
                        }
                        ///////////////////////////////////factor status tozihat
                        break;
                    case 'wireless':
                        $("#modal_form_factortab_wireless").modal('show');
                        $('#ft_wireless_noe_khadamat option[value="' + data[0]["noe_khadamat"] + '"]').attr('selected', 'selected');
                        $('#ft_wireless_id').val(data[0]['id']);
                        $('#ft_wireless_terafik').val(data[0]['terafik']);
                        $('#ft_wireless_zaname_estefade_be_tarikh').val(data[0]['zaname_estefade_be_tarikh']);
                        $('#ft_wireless_tarikhe_shoroe_service').val(data[0]['tarikhe_shoroe_service']);
                        $('#ft_wireless_tarikhe_payane_service').val(data[0]['tarikhe_payane_service']);
                        $('#ft_wireless_gheymate_service').val(data[0]['gheymate_service']);
                        $('#ft_wireless_takhfif').val(data[0]['takhfif']);
                        $('#ft_wireless_tarikhe_marjo_shode').val(Getor_String(data[0]['tarikhe_marjo_shode'], 'ثبت نشده'));
                        $('#ft_wireless_marjo_konande').val(Getor_String(data[0]['marjo_konande'], 'ثبت نشده'));
                        $('#ft_wireless_tarikhe_tasvie_shode').val(Getor_String(data[0]['tarikhe_tasvie_shode']), 'ثبت نشده');
                        $('#ft_wireless_tasvie_konande').val(Getor_String(data[0]['tasvie_konande']), 'ثبت نشده');
                        $('#ft_wireless_tozihate_disable_shode').val(Getor_String(data[0]['tozihate_disable_shode']), 'ثبت نشده');
                        $('#ft_wireless_tarikhe_disable_shode').val(Getor_String(data[0]['tarikhe_disable_shode']), 'ثبت نشده');
                        $('#ft_wireless_disable_konande').val(Getor_String(data[0]['disable_konande']), 'ثبت نشده');
                        //$('#ft_wireless_hazine_ranzhe').val(data[0]['hazine_ranzhe']);
                        //$('#ft_wireless_hazine_dranzhe').val(data[0]['hazine_dranzhe']);
                        $('#ft_wireless_hazine_nasb').val(data[0]['hazine_nasb']);
                        $('#ft_wireless_abonmane_port').val(data[0]['abonmane_port']);
                        $('#ft_wireless_abonmane_faza').val(data[0]['abonmane_faza']);
                        $('#ft_wireless_abonmane_tajhizat').val(data[0]['abonmane_tajhizat']);
                        $('#ft_wireless_darsade_avareze_arzeshe_afzode').val(data[0]['darsade_avareze_arzeshe_afzode']);
                        $('#ft_wireless_maliate_arzeshe_afzode').val(data[0]['maliate_arzeshe_afzode']);
                        $('#ft_wireless_mablaghe_ghabele_pardakht').val(data[0]['mablaghe_ghabele_pardakht']);
                        ///////////////////////////////////service status checkboxex
                        if (data[0]['daryafte_etelaat'] === '1') {
                            $("#ft_wireless_daryafte_etelaat").prop("checked", true);
                            $("#ft_wireless_daryafte_etelaat").attr("onclick", "return false");
                        } else {
                            $("#ft_wireless_daryafte_etelaat").prop("checked", false);
                        }
                        //
                        if (data[0]['ehraze_hoviat'] === '1') {
                            $("#ft_wireless_ehraze_hoviat").prop("checked", true);
                            $("#ft_wireless_ehraze_hoviat").attr("onclick", "return false");
                            $("#ft_wireless_daryafte_etelaat").attr("onclick", "return false");
                        } else {
                            $("#ft_wireless_ehraze_hoviat").prop("checked", false);
                        }
                        //
                        if (data[0]['eneghade_gharardad'] === '1') {
                            $("#ft_wireless_eneghade_gharardad").prop("checked", true);
                            $("#ft_wireless_eneghade_gharardad").attr("onclick", "return false");
                            $("#ft_wireless_ehraze_hoviat").attr("onclick", "return false");
                            $("#ft_wireless_daryafte_etelaat").attr("onclick", "return false");
                        } else {
                            $("#ft_wireless_eneghade_gharardad").prop("checked", false);
                        }
                        //
                        if (data[0]['baresie_link'] === '1') {
                            $("#ft_wireless_baresie_link").prop("checked", true);
                            $("#ft_wireless_baresie_link").attr("onclick", "return false");
                            $("#ft_wireless_eneghade_gharardad").attr("onclick", "return false");
                            $("#ft_wireless_ehraze_hoviat").attr("onclick", "return false");
                            $("#ft_wireless_daryafte_etelaat").attr("onclick", "return false");
                        } else {
                            $("#ft_wireless_baresie_link").prop("checked", false);
                        }
                        //
                        if (data[0]['entezare_nasb'] === '1') {
                            $("#ft_wireless_entezare_nasb").prop("checked", true);
                            $("#ft_wireless_entezare_nasb").attr("onclick", "return false");
                            $("#ft_wireless_eneghade_gharardad").attr("onclick", "return false");
                            $("#ft_wireless_ehraze_hoviat").attr("onclick", "return false");
                            $("#ft_wireless_daryafte_etelaat").attr("onclick", "return false");
                            $("#ft_wireless_baresie_link").attr("onclick", "return false");
                        } else {
                            $("#ft_wireless_entezare_nasb").prop("checked", false);
                        }
                        //
                        if (data[0]['faal_sazie_avalie'] === '1') {
                            $("#ft_wireless_faal_sazie_avalie").prop("checked", true);
                            $("#ft_wireless_faal_sazie_avalie").attr("onclick", "return false");
                            $("#ft_wireless_eneghade_gharardad").attr("onclick", "return false");
                            $("#ft_wireless_ehraze_hoviat").attr("onclick", "return false");
                            $("#ft_wireless_daryafte_etelaat").attr("onclick", "return false");
                            $("#ft_wireless_baresie_link").attr("onclick", "return false");
                            $("#ft_wireless_entezare_nasb").attr("onclick", "return false");
                        } else {
                            $("#ft_wireless_faal_sazie_avalie").prop("checked", false);
                        }
                        //
                        if (data[0]['faal'] === '1') {
                            $("#ft_wireless_faal").prop("checked", true);
                            $("#ft_wireless_faal").attr("onclick", "return false");
                            $("#ft_wireless_entezare_nasb").attr("onclick", "return false");
                            $("#ft_wireless_faal_sazie_avalie").attr("onclick", "return false");
                            $("#ft_wireless_eneghade_gharardad").attr("onclick", "return false");
                            $("#ft_wireless_ehraze_hoviat").attr("onclick", "return false");
                            $("#ft_wireless_daryafte_etelaat").attr("onclick", "return false");
                            $("#ft_wireless_baresie_link").attr("onclick", "return false");
                        } else {
                            $("#ft_wireless_faal").prop("checked", false);
                        }
                        //
                        if (data[0]['marjo'] === '1') {
                            $("#ft_wireless_marjo").prop("checked", true);
                            $("#ft_wireless_marjo").attr("onclick", "return false");
                            $("#ft_wireless_faal").attr("onclick", "return false");
                            $("#ft_wireless_entezare_nasb").attr("onclick", "return false");
                            $("#ft_wireless_faal_sazie_avalie").attr("onclick", "return false");
                            $("#ft_wireless_eneghade_gharardad").attr("onclick", "return false");
                            $("#ft_wireless_ehraze_hoviat").attr("onclick", "return false");
                            $("#ft_wireless_daryafte_etelaat").attr("onclick", "return false");
                            $("#ft_wireless_baresie_link").attr("onclick", "return false");
                        } else {
                            $("#ft_wireless_marjo").prop("checked", false);
                        }
                        ///////////////////////////////////service status checkboxex
                        ///////////////////////////////////factor status checkboxex
                        if (data[0]['sharje_mojadad'] === '1') {
                            $("#ft_wireless_sharje_mojadad").prop("checked", true);
                            $("#ft_wireless_sharje_mojadad").attr("onclick", "return false");
                        } else {
                            $("#ft_wireless_sharje_mojadad").prop("checked", false);
                            $("#ft_wireless_sharje_mojadad").attr("onclick", "return false");
                        }
                        if (data[0]['print_shode'] === '1') {
                            $("#ft_wireless_print_shode").prop("checked", true);
                            $("#ft_wireless_print_shode").attr("onclick", "return false");
                        } else {
                            $("#ft_wireless_print_shode").prop("checked", false);
                            $("#ft_wireless_print_shode").attr("onclick", "return false");
                        }
                        if (data[0]['ersal_shode'] === '1') {
                            $("#ft_wireless_ersal_shode").prop("checked", true);
                            $("#ft_wireless_ersal_shode").attr("onclick", "return false");
                        } else {
                            $("#ft_wireless_ersal_shode").prop("checked", false);
                            $("#ft_wireless_ersal_shode").attr("onclick", "return false");
                        }
                        if (data[0]['marjo_shode'] === '1') {
                            $("#ft_wireless_marjo_shode").prop("checked", true);
                            //$("#ft_wireless_marjo_shode").attr("onclick","return false");
                        } else {
                            $("#ft_wireless_marjo_shode").prop("checked", false);
                            //$("#ft_wireless_marjo_shode").attr("onclick","return false");
                        }
                        if (data[0]['tasvie_shode'] === '1') {
                            $("#ft_wireless_tasvie_shode").prop("checked", true);
                            //$("#ft_wireless_tasvie_shode").attr("onclick","return false");
                        } else {
                            $("#ft_wireless_tasvie_shode").prop("checked", false);
                            //$("#ft_wireless_tasvie_shode").attr("onclick","return false");
                        }
                        ///////////////////////////////////factor status checkboxex
                        ///////////////////////////////////factor status tozihat
                        if (data[0]['tozihate_marjo_shode'] != null && data[0]['tozihate_marjo_shode'].length > 0) {
                            $("#ft_wireless_tozihate_marjo_shode").val(data[0]['tozihate_marjo_shode']);
                        }
                        if (data[0]['tozihate_tasvie_shode'] != null && data[0]['tozihate_tasvie_shode'].length > 0) {
                            $("#ft_wireless_tozihate_tasvie_shode").val(data[0]['tozihate_tasvie_shode']);
                        }
                        if (data[0]['disable_shode'] === '1') {
                            $("#ft_wireless_disable_shode").prop("checked", true);
                            //$("#ft_adsl_marjo_shode").attr("onclick","return false");
                        } else {
                            $("#ft_wireless_disable_shode").prop("checked", false);
                            //$("#ft_adsl_marjo_shode").attr("onclick","return false");
                        }
                        break;
                    case 'tdlte':
                        $("#modal_form_factortab_tdlte").modal('show');
                        $('#ft_tdlte_noe_khadamat option[value="' + data[0]["noe_khadamat"] + '"]').attr('selected', 'selected');
                        $('#ft_tdlte_id').val(data[0]['id']);
                        $('#ft_tdlte_terafik').val(data[0]['terafik']);
                        $('#ft_tdlte_zaname_estefade_be_tarikh').val(data[0]['zaname_estefade_be_tarikh']);
                        $('#ft_tdlte_tarikhe_shoroe_service').val(data[0]['tarikhe_shoroe_service']);
                        $('#ft_tdlte_tarikhe_payane_service').val(data[0]['tarikhe_payane_service']);
                        $('#ft_tdlte_gheymate_service').val(data[0]['gheymate_service']);
                        $('#ft_tdlte_takhfif').val(data[0]['takhfif']);
                        $('#ft_tdlte_tarikhe_marjo_shode').val(Getor_String(data[0]['tarikhe_marjo_shode'], 'ثبت نشده'));
                        $('#ft_tdlte_marjo_konande').val(Getor_String(data[0]['marjo_konande'], 'ثبت نشده'));
                        $('#ft_tdlte_tarikhe_tasvie_shode').val(Getor_String(data[0]['tarikhe_tasvie_shode']), 'ثبت نشده');
                        $('#ft_tdlte_tasvie_konande').val(Getor_String(data[0]['tasvie_konande']), 'ثبت نشده');
                        $('#ft_tdlte_tozihate_disable_shode').val(Getor_String(data[0]['tozihate_disable_shode']), 'ثبت نشده');
                        $('#ft_tdlte_tarikhe_disable_shode').val(Getor_String(data[0]['tarikhe_disable_shode']), 'ثبت نشده');
                        $('#ft_tdlte_disable_konande').val(Getor_String(data[0]['disable_konande']), 'ثبت نشده');
                        //$('#ft_tdlte_hazine_ranzhe').val(data[0]['hazine_ranzhe']);
                        //$('#ft_tdlte_hazine_dranzhe').val(data[0]['hazine_dranzhe']);
                        $('#ft_tdlte_hazine_nasb').val(data[0]['hazine_nasb']);
                        $('#ft_tdlte_abonmane_port').val(data[0]['abonmane_port']);
                        $('#ft_tdlte_abonmane_faza').val(data[0]['abonmane_faza']);
                        $('#ft_tdlte_abonmane_tajhizat').val(data[0]['abonmane_tajhizat']);
                        $('#ft_tdlte_darsade_avareze_arzeshe_afzode').val(data[0]['darsade_avareze_arzeshe_afzode']);
                        $('#ft_tdlte_maliate_arzeshe_afzode').val(data[0]['maliate_arzeshe_afzode']);
                        $('#ft_tdlte_mablaghe_ghabele_pardakht').val(data[0]['mablaghe_ghabele_pardakht']);
                        ///////////////////////////////////service status checkboxex
                        if (data[0]['daryafte_etelaat'] === '1') {
                            $("#ft_tdlte_daryafte_etelaat").prop("checked", true);
                            $("#ft_tdlte_daryafte_etelaat").attr("onclick", "return false");
                        } else {
                            $("#ft_tdlte_daryafte_etelaat").prop("checked", false);
                        }
                        //
                        if (data[0]['ehraze_hoviat'] === '1') {
                            $("#ft_tdlte_ehraze_hoviat").prop("checked", true);
                            $("#ft_tdlte_ehraze_hoviat").attr("onclick", "return false");
                            $("#ft_tdlte_daryafte_etelaat").attr("onclick", "return false");
                        } else {
                            $("#ft_tdlte_ehraze_hoviat").prop("checked", false);
                        }
                        //
                        if (data[0]['eneghade_gharardad'] === '1') {
                            $("#ft_tdlte_eneghade_gharardad").prop("checked", true);
                            $("#ft_tdlte_eneghade_gharardad").attr("onclick", "return false");
                            $("#ft_tdlte_ehraze_hoviat").attr("onclick", "return false");
                            $("#ft_tdlte_daryafte_etelaat").attr("onclick", "return false");
                        } else {
                            $("#ft_tdlte_eneghade_gharardad").prop("checked", false);
                        }

                        //
                        if (data[0]['entezare_nasb'] === '1') {
                            $("#ft_tdlte_entezare_nasb").prop("checked", true);
                            $("#ft_tdlte_entezare_nasb").attr("onclick", "return false");
                            $("#ft_tdlte_eneghade_gharardad").attr("onclick", "return false");
                            $("#ft_tdlte_ehraze_hoviat").attr("onclick", "return false");
                            $("#ft_tdlte_daryafte_etelaat").attr("onclick", "return false");
                            $("#ft_tdlte_baresie_link").attr("onclick", "return false");
                        } else {
                            $("#ft_tdlte_entezare_nasb").prop("checked", false);
                        }
                        //
                        if (data[0]['faal_sazie_avalie'] === '1') {
                            $("#ft_tdlte_faal_sazie_avalie").prop("checked", true);
                            $("#ft_tdlte_faal_sazie_avalie").attr("onclick", "return false");
                            $("#ft_tdlte_eneghade_gharardad").attr("onclick", "return false");
                            $("#ft_tdlte_ehraze_hoviat").attr("onclick", "return false");
                            $("#ft_tdlte_daryafte_etelaat").attr("onclick", "return false");
                            $("#ft_tdlte_entezare_nasb").attr("onclick", "return false");
                        } else {
                            $("#ft_tdlte_faal_sazie_avalie").prop("checked", false);
                        }
                        //
                        if (data[0]['faal'] === '1') {
                            $("#ft_tdlte_faal").prop("checked", true);
                            $("#ft_tdlte_faal").attr("onclick", "return false");
                            $("#ft_tdlte_entezare_nasb").attr("onclick", "return false");
                            $("#ft_tdlte_faal_sazie_avalie").attr("onclick", "return false");
                            $("#ft_tdlte_eneghade_gharardad").attr("onclick", "return false");
                            $("#ft_tdlte_ehraze_hoviat").attr("onclick", "return false");
                            $("#ft_tdlte_daryafte_etelaat").attr("onclick", "return false");
                        } else {
                            $("#ft_tdlte_faal").prop("checked", false);
                        }
                        //
                        if (data[0]['marjo'] === '1') {
                            $("#ft_tdlte_marjo").prop("checked", true);
                            $("#ft_tdlte_marjo").attr("onclick", "return false");
                            $("#ft_tdlte_faal").attr("onclick", "return false");
                            $("#ft_tdlte_entezare_nasb").attr("onclick", "return false");
                            $("#ft_tdlte_faal_sazie_avalie").attr("onclick", "return false");
                            $("#ft_tdlte_eneghade_gharardad").attr("onclick", "return false");
                            $("#ft_tdlte_ehraze_hoviat").attr("onclick", "return false");
                            $("#ft_tdlte_daryafte_etelaat").attr("onclick", "return false");
                        } else {
                            $("#ft_tdlte_marjo").prop("checked", false);
                        }
                        ///////////////////////////////////service status checkboxex
                        ///////////////////////////////////factor status checkboxex
                        if (data[0]['sharje_mojadad'] === '1') {
                            $("#ft_tdlte_sharje_mojadad").prop("checked", true);
                            $("#ft_tdlte_sharje_mojadad").attr("onclick", "return false");
                        } else {
                            $("#ft_tdlte_sharje_mojadad").prop("checked", false);
                            $("#ft_tdlte_sharje_mojadad").attr("onclick", "return false");
                        }
                        if (data[0]['print_shode'] === '1') {
                            $("#ft_tdlte_print_shode").prop("checked", true);
                            $("#ft_tdlte_print_shode").attr("onclick", "return false");
                        } else {
                            $("#ft_tdlte_print_shode").prop("checked", false);
                            $("#ft_tdlte_print_shode").attr("onclick", "return false");
                        }
                        if (data[0]['ersal_shode'] === '1') {
                            $("#ft_tdlte_ersal_shode").prop("checked", true);
                            $("#ft_tdlte_ersal_shode").attr("onclick", "return false");
                        } else {
                            $("#ft_tdlte_ersal_shode").prop("checked", false);
                            $("#ft_tdlte_ersal_shode").attr("onclick", "return false");
                        }
                        if (data[0]['marjo_shode'] === '1') {
                            $("#ft_tdlte_marjo_shode").prop("checked", true);
                            //$("#ft_tdlte_marjo_shode").attr("onclick","return false");
                        } else {
                            $("#ft_tdlte_marjo_shode").prop("checked", false);
                            //$("#ft_tdlte_marjo_shode").attr("onclick","return false");
                        }
                        if (data[0]['tasvie_shode'] === '1') {
                            $("#ft_tdlte_tasvie_shode").prop("checked", true);
                            //$("#ft_tdlte_tasvie_shode").attr("onclick","return false");
                        } else {
                            $("#ft_tdlte_tasvie_shode").prop("checked", false);
                            //$("#ft_tdlte_tasvie_shode").attr("onclick","return false");
                        }
                        ///////////////////////////////////factor status checkboxex
                        ///////////////////////////////////factor status tozihat
                        if (data[0]['tozihate_marjo_shode'] != null && data[0]['tozihate_marjo_shode'].length > 0) {
                            $("#ft_tdlte_tozihate_marjo_shode").val(data[0]['tozihate_marjo_shode']);
                        }
                        if (data[0]['tozihate_tasvie_shode'] != null && data[0]['tozihate_tasvie_shode'].length > 0) {
                            $("#ft_tdlte_tozihate_tasvie_shode").val(data[0]['tozihate_tasvie_shode']);
                        }
                        if (data[0]['disable_shode'] === '1') {
                            $("#ft_tdlte_disable_shode").prop("checked", true);
                            //$("#ft_adsl_marjo_shode").attr("onclick","return false");
                        } else {
                            $("#ft_tdlte_disable_shode").prop("checked", false);
                            //$("#ft_adsl_marjo_shode").attr("onclick","return false");
                        }
                        break;
                    case 'voip':
                        $("#modal_form_factortab_voip").modal('show');
                        $('#ft_voip_noe_khadamat option[value="' + data[0]["noe_khadamat"] + '"]').attr('selected', 'selected');
                        $('#ft_voip_id').val(data[0]['id']);
                        $('#ft_voip_terafik').val(data[0]['terafik']);
                        $('#ft_voip_zaname_estefade_be_tarikh').val(data[0]['zaname_estefade_be_tarikh']);
                        $('#ft_voip_tarikhe_shoroe_service').val(data[0]['tarikhe_shoroe_service']);
                        $('#ft_voip_tarikhe_payane_service').val(data[0]['tarikhe_payane_service']);
                        $('#ft_voip_gheymate_service').val(data[0]['gheymate_service']);
                        $('#ft_voip_takhfif').val(data[0]['takhfif']);
                        $('#ft_voip_pin_code').val(data[0]['pin_code']);
                        // $('#ft_tdlte_tarikhe_marjo_shode').val(Getor_String(data[0]['tarikhe_marjo_shode'], 'ثبت نشده'));
                        // $('#ft_tdlte_marjo_konande').val(Getor_String(data[0]['marjo_konande'], 'ثبت نشده'));
                        // $('#ft_tdlte_tarikhe_tasvie_shode').val(Getor_String(data[0]['tarikhe_tasvie_shode']), 'ثبت نشده');
                        // $('#ft_tdlte_tasvie_konande').val(Getor_String(data[0]['tasvie_konande']), 'ثبت نشده');
                        // $('#ft_tdlte_tozihate_disable_shode').val(Getor_String(data[0]['tozihate_disable_shode']), 'ثبت نشده');
                        // $('#ft_tdlte_tarikhe_disable_shode').val(Getor_String(data[0]['tarikhe_disable_shode']), 'ثبت نشده');
                        // $('#ft_tdlte_disable_konande').val(Getor_String(data[0]['disable_konande']), 'ثبت نشده');
                        Set_Val($("#ft_voip_tarikhe_marjo_shode"), data[0]['tarikhe_marjo_shode']), '1';
                        Set_Val($("#ft_voip_marjo_konande"), data[0]['marjo_konande']), '1';
                        Set_Val($("#ft_voip_tarikhe_tasvie_shode"), data[0]['tarikhe_tasvie_shode']), '1';
                        Set_Val($("#ft_voip_tasvie_konande"), data[0]['tasvie_konande']), '1';
                        Set_Val($("#ft_voip_tozihate_disable_shode"), data[0]['tozihate_disable_shode']), '1';
                        Set_Val($("#ft_voip_tarikhe_disable_shode"), data[0]['tarikhe_disable_shode']), '1';
                        Set_Val($("#ft_voip_disable_konande"), data[0]['disable_konande']), '1';


                        //$('#ft_voip_hazine_ranzhe').val(data[0]['hazine_ranzhe']);
                        //$('#ft_voip_hazine_dranzhe').val(data[0]['hazine_dranzhe']);
                        //$('#ft_voip_hazine_nasb').val(data[0]['hazine_nasb']);
                        //$('#ft_voip_abonmane_port').val(data[0]['abonmane_port']);
                        //$('#ft_voip_abonmane_faza').val(data[0]['abonmane_faza']);
                        //$('#ft_voip_abonmane_tajhizat').val(data[0]['abonmane_tajhizat']);
                        $('#ft_voip_darsade_avareze_arzeshe_afzode').val(data[0]['darsade_avareze_arzeshe_afzode']);
                        $('#ft_voip_maliate_arzeshe_afzode').val(data[0]['maliate_arzeshe_afzode']);
                        $('#ft_voip_mablaghe_ghabele_pardakht').val(data[0]['mablaghe_ghabele_pardakht']);
                        ///////////////////////////////////service status checkboxex
                        if (data[0]['daryafte_etelaat'] === '1') {
                            $("#ft_voip_daryafte_etelaat").prop("checked", true);
                            $("#ft_voip_daryafte_etelaat").attr("onclick", "return false");
                        } else {
                            $("#ft_voip_daryafte_etelaat").prop("checked", false);
                        }
                        //
                        if (data[0]['ehraze_hoviat'] === '1') {
                            $("#ft_voip_ehraze_hoviat").prop("checked", true);
                            $("#ft_voip_ehraze_hoviat").attr("onclick", "return false");
                            $("#ft_voip_daryafte_etelaat").attr("onclick", "return false");
                        } else {
                            $("#ft_voip_ehraze_hoviat").prop("checked", false);
                        }
                        //
                        if (data[0]['eneghade_gharardad'] === '1') {
                            $("#ft_voip_eneghade_gharardad").prop("checked", true);
                            $("#ft_voip_eneghade_gharardad").attr("onclick", "return false");
                            $("#ft_voip_ehraze_hoviat").attr("onclick", "return false");
                            $("#ft_voip_daryafte_etelaat").attr("onclick", "return false");
                        } else {
                            $("#ft_voip_eneghade_gharardad").prop("checked", false);
                        }
                        //                        
                        if (data[0]['faal_sazie_avalie'] === '1') {
                            $("#ft_voip_faal_sazie_avalie").prop("checked", true);
                            $("#ft_voip_faal_sazie_avalie").attr("onclick", "return false");
                            $("#ft_voip_eneghade_gharardad").attr("onclick", "return false");
                            $("#ft_voip_ehraze_hoviat").attr("onclick", "return false");
                            $("#ft_voip_daryafte_etelaat").attr("onclick", "return false");
                        } else {
                            $("#ft_voip_faal_sazie_avalie").prop("checked", false);
                        }
                        //
                        if (data[0]['faal'] === '1') {
                            $("#ft_voip_faal").prop("checked", true);
                            $("#ft_voip_faal").attr("onclick", "return false");
                            $("#ft_voip_faal_sazie_avalie").attr("onclick", "return false");
                            $("#ft_voip_eneghade_gharardad").attr("onclick", "return false");
                            $("#ft_voip_ehraze_hoviat").attr("onclick", "return false");
                            $("#ft_voip_daryafte_etelaat").attr("onclick", "return false");
                        } else {
                            $("#ft_voip_faal").prop("checked", false);
                        }
                        //
                        if (data[0]['marjo'] === '1') {
                            $("#ft_voip_marjo").prop("checked", true);
                            $("#ft_voip_marjo").attr("onclick", "return false");
                            $("#ft_voip_faal").attr("onclick", "return false");
                            $("#ft_voip_faal_sazie_avalie").attr("onclick", "return false");
                            $("#ft_voip_eneghade_gharardad").attr("onclick", "return false");
                            $("#ft_voip_ehraze_hoviat").attr("onclick", "return false");
                            $("#ft_voip_daryafte_etelaat").attr("onclick", "return false");
                        } else {
                            $("#ft_voip_marjo").prop("checked", false);
                        }
                        ///////////////////////////////////service status checkboxex
                        ///////////////////////////////////factor status checkboxex
                        if (data[0]['sharje_mojadad'] === '1') {
                            $("#ft_voip_sharje_mojadad").prop("checked", true);
                            $("#ft_voip_sharje_mojadad").attr("onclick", "return false");
                        } else {
                            $("#ft_voip_sharje_mojadad").prop("checked", false);
                            $("#ft_voip_sharje_mojadad").attr("onclick", "return false");
                        }
                        if (data[0]['print_shode'] === '1') {
                            $("#ft_voip_print_shode").prop("checked", true);
                            $("#ft_voip_print_shode").attr("onclick", "return false");
                        } else {
                            $("#ft_voip_print_shode").prop("checked", false);
                            $("#ft_voip_print_shode").attr("onclick", "return false");
                        }
                        if (data[0]['ersal_shode'] === '1') {
                            $("#ft_voip_ersal_shode").prop("checked", true);
                            $("#ft_voip_ersal_shode").attr("onclick", "return false");
                        } else {
                            $("#ft_voip_ersal_shode").prop("checked", false);
                            $("#ft_voip_ersal_shode").attr("onclick", "return false");
                        }
                        if (data[0]['marjo_shode'] === '1') {
                            $("#ft_voip_marjo_shode").prop("checked", true);
                            //$("#ft_voip_marjo_shode").attr("onclick","return false");
                        } else {
                            $("#ft_voip_marjo_shode").prop("checked", false);
                            //$("#ft_voip_marjo_shode").attr("onclick","return false");
                        }
                        if (data[0]['tasvie_shode'] === '1') {
                            $("#ft_voip_tasvie_shode").prop("checked", true);
                            //$("#ft_voip_tasvie_shode").attr("onclick","return false");
                        } else {
                            $("#ft_voip_tasvie_shode").prop("checked", false);
                            //$("#ft_voip_tasvie_shode").attr("onclick","return false");
                        }
                        ///////////////////////////////////factor status checkboxex
                        ///////////////////////////////////factor status tozihat
                        if (data[0]['tozihate_marjo_shode'] != null && data[0]['tozihate_marjo_shode'].length > 0) {
                            $("#ft_voip_tozihate_marjo_shode").val(data[0]['tozihate_marjo_shode']);
                        }
                        if (data[0]['tozihate_tasvie_shode'] != null && data[0]['tozihate_tasvie_shode'].length > 0) {
                            $("#ft_voip_tozihate_tasvie_shode").val(data[0]['tozihate_tasvie_shode']);
                        }
                        if (data[0]['disable_shode'] === '1') {
                            $("#ft_voip_disable_shode").prop("checked", true);
                            //$("#ft_adsl_marjo_shode").attr("onclick","return false");
                        } else {
                            $("#ft_voip_disable_shode").prop("checked", false);
                            //$("#ft_adsl_marjo_shode").attr("onclick","return false");
                        }
                        break;
                    default:
                        Custom_Modal_Show('w', 'مشکل در برنامه');
                        break;
                }

            });

        } else {
            Custom_Modal_Show('w', "لطفا فاکتور مورد نظر را انتخاب کنید.");
        }
    });
    ///////////////////////////////////////////confirm click for factor ha table
    $("#factorshahkar").on("click", function() {
        let tr = $('#factor_tab tbody').find('tr.selected');
        let td = tr.find('td:first').text();
        if (!td) {
            alert('لطفا فاکتور مورد نظر را انتخاب کنید');
        }
        ajaxRequest('factorshahkar', { 'factorid': td }, window.location.href.split('/').slice(-1)[0], function(result) {
            if (check_isset_message(result)) {
                display_Predefiend_Messages(result);
            }
        });
    });
    $("#factorprint_initbtn").on("click", function() {
        let tr = $('#factor_tab tbody').find('tr.selected');
        let td = tr.find('td:first').text();
        if (td) {
            Factors_Initialize('print_factor_tasvireshode', td, function(res_print) {
                console.log(res_print);
                if (check_isset_message(res_print)) {
                    display_Predefiend_Messages(res_print);
                } else if (res_print) {
                    switch (res_print[0]['type']) {
                        case 'adsl':
                        case 'vdsl':
                        case 'bitstream':
                            let pa_fo_name = $("#pa_fo_name");
                            let pa_fo_code_eghtesadi = $("#pa_fo_code_eghtesadi");
                            let pa_fo_ostan = $("#pa_fo_ostan");
                            let pa_fo_shahr = $("#pa_fo_shahr");
                            let pa_fo_shomare_sabt = $("#pa_fo_shomare_sabt");
                            let pa_fo_code_posti = $("#pa_fo_code_posti");
                            let pa_fo_telephone = $("#pa_fo_telephone");
                            let pa_fo_address = $("#pa_fo_address");

                            let pa_code_posti = $("#pa_code_posti");
                            let pa_telephone = $("#pa_telephone");
                            let pa_ostan = $("#pa_ostan");
                            let pa_shahr = $("#pa_shahr");

                            let pa_shomarefactor = $("#pa_shomarefactor");
                            let pa_code_meli = $("#pa_code_meli");
                            let pa_tarikhe_factor = $("#pa_tarikhe_factor");
                            let pa_name_va_family = $("#pa_name_va_family");
                            let pa_mobile = $("#pa_mobile");
                            let pa_code_eshterak = $("#pa_code_eshterak");
                            let pa_address = $("#pa_address");
                            let pa_noe_khadamat = $("#pa_noe_khadamat");
                            let pa_terafik = $("#pa_terafik");
                            let pa_zaname_estefade = $("#pa_zaname_estefade");
                            let pa_tarikhe_shoroe_service = $("#pa_tarikhe_shoroe_service");
                            let pa_tarikhe_payane_service = $("#pa_tarikhe_payane_service");
                            let pa_gheymate_service = $("#pa_gheymate_service");
                            let pa_takhfif = $("#pa_takhfif");
                            let pa_hazine_ranzhe = $("#pa_hazine_ranzhe");
                            let pa_hazine_dranzhe = $("#pa_hazine_dranzhe");
                            let pa_hazine_nasb = $("#pa_hazine_nasb");
                            let pa_abonmane_port = $("#pa_abonmane_port");
                            let pa_abonmane_faza = $("#pa_abonmane_faza");
                            let pa_abonmane_tajhizat = $("#pa_abonmane_tajhizat");
                            let pa_darsade_avareze_arzeshe_afzode = $("#pa_darsade_avareze_arzeshe_afzode");
                            let pa_maliate_arzeshe_afzode = $("#pa_maliate_arzeshe_afzode");
                            let pa_mablaghe_ghabele_pardakht = $("#pa_mablaghe_ghabele_pardakht");
                            let pa_name_sherkat = $("#pa_name_sherkat");
                            let pa_tozihate_factor = $("#pa_tozihate_factor");
                            pa_fo_name.text('نام شرکت: ' + res_print[0]['fo_name']);
                            pa_fo_telephone.text('تلفن: ' + res_print[0]['fo_telephone'].toString().toPersinaDigit());
                            pa_fo_code_posti.text('کد پستی: ' + res_print[0]['fo_code_posti'].toString().toPersinaDigit());
                            pa_fo_code_eghtesadi.text('کد اقتصادی: ' + res_print[0]['fo_code_eghtesadi'].toString().toPersinaDigit());
                            pa_fo_shomare_sabt.text('شماره ثبت : ' + res_print[0]['fo_shomare_sabt'].toString().toPersinaDigit());
                            pa_fo_ostan.text('استان: ' + res_print[0]['fo_ostan']);
                            pa_fo_shahr.text('شهر: ' + res_print[0]['fo_shahr']);
                            pa_fo_address.text('آدرس: ' + res_print[0]['fo_address'].toString().toPersinaDigit());
                            pa_ostan.text('استان: ' + res_print[0]['ostane_sokonat']);
                            pa_shahr.text('شهر: ' + res_print[0]['shahre_sokonat']);


                            pa_code_posti.text('کدپستی: ' + res_print[0]['code_posti'].toString().toPersinaDigit());
                            pa_telephone.text('تلفن: ' + res_print[0]['telephone'].toString().toPersinaDigit());
                            pa_tarikhe_factor.text('تاریخ فاکتور :' + tabdile_tarikh_adad(res_print[0]['tarikhe_factor']));
                            pa_shomarefactor.text('شماره فاکتور :' + res_print[0]['shomare_factor'].toString().toPersinaDigit());
                            pa_code_meli.text('کد ملی/کد اقتصادی : ' + res_print[0]['code_meli'].toString().toPersinaDigit());
                            pa_mobile.text('تلفن همراه : ' + res_print[0]['telephone_hamrah'].toString().toPersinaDigit());
                            pa_code_eshterak.text('کد اشتراک : ' + res_print[0]['code_eshterak'].toString().toPersinaDigit());
                            pa_address.text('آدرس : ' + res_print[0]['address']);
                            pa_name_va_family.text('نام مشترک / (شرکت) :' + res_print[0]['name'] + ' ' + res_print[0]['f_name']);
                            pa_tozihate_factor.text(res_print[0]['tozihate_faktor']);
                            pa_noe_khadamat.text(res_print[0]['onvane_service']);
                            pa_terafik.text(res_print[0]['terafik'].toString().toPersinaDigit());
                            pa_zaname_estefade.text(res_print[0]['zamane_estefade'].toString().toPersinaDigit());
                            pa_tarikhe_shoroe_service.text(tabdile_tarikh_adad(res_print[0]['tarikhe_shoroe_service'].toString()));
                            pa_tarikhe_payane_service.text(tabdile_tarikh_adad(res_print[0]['tarikhe_payane_service'].toString()));
                            pa_gheymate_service.text("" + res_print[0]['gheymate_service'].toString().toPersinaDigit());
                            pa_takhfif.text(res_print[0]['takhfif'].toString().toPersinaDigit());
                            pa_hazine_ranzhe.text(res_print[0]['hazine_ranzhe'].toString().toPersinaDigit());
                            pa_hazine_dranzhe.text(res_print[0]['hazine_dranzhe'].toString().toPersinaDigit());
                            pa_hazine_nasb.text(res_print[0]['hazine_nasb'].toString().toPersinaDigit());
                            pa_abonmane_port.text(res_print[0]['abonmane_port'].toString().toPersinaDigit());
                            pa_abonmane_faza.text(res_print[0]['abonmane_faza'].toString().toPersinaDigit());
                            pa_abonmane_tajhizat.text(res_print[0]['abonmane_tajhizat'].toString().toPersinaDigit());
                            pa_darsade_avareze_arzeshe_afzode.text(res_print[0]['darsade_avareze_arzeshe_afzode'].toString().toPersinaDigit());
                            pa_maliate_arzeshe_afzode.text(res_print[0]['maliate_arzeshe_afzode'].toString().toPersinaDigit());
                            pa_mablaghe_ghabele_pardakht.text(res_print[0]['mablaghe_ghabele_pardakht'].toString().toPersinaDigit());
                            pa_name_sherkat.text(res_print[0]['name_sherkat']);
                            Print_Adsl_Factor("print_form_adsl");
                            break;
                        case 'wireless':
                        case 'tdlte':
                            let wa_fo_name = $("#wa_fo_name");
                            let wa_fo_code_eghtesadi = $("#wa_fo_code_eghtesadi");
                            let wa_fo_ostan = $("#wa_fo_ostan");
                            let wa_fo_shahr = $("#wa_fo_shahr");
                            let wa_fo_shomare_sabt = $("#wa_fo_shomare_sabt");
                            let wa_fo_code_posti = $("#wa_fo_code_posti");
                            let wa_fo_telephone = $("#wa_fo_telephone");
                            let wa_fo_address = $("#wa_fo_address");


                            let wa_code_posti = $("#wa_code_posti");
                            let wa_telephone = $("#wa_telephone");
                            let wa_ostan = $("#wa_ostan");
                            let wa_shahr = $("#wa_shahr");

                            let wa_shomarefactor = $("#wa_shomarefactor");
                            let wa_code_meli = $("#wa_code_meli");
                            let wa_tarikhe_factor = $("#wa_tarikhe_factor");
                            let wa_name_va_family = $("#wa_name_va_family");
                            let wa_mobile = $("#wa_mobile");
                            let wa_code_eshterak = $("#wa_code_eshterak");
                            let wa_address = $("#wa_address");
                            let wa_noe_khadamat = $("#wa_noe_khadamat");
                            let wa_terafik = $("#wa_terafik");
                            let wa_zaname_estefade = $("#wa_zaname_estefade");
                            let wa_tarikhe_shoroe_service = $("#wa_tarikhe_shoroe_service");
                            let wa_tarikhe_payane_service = $("#wa_tarikhe_payane_service");
                            let wa_gheymate_service = $("#wa_gheymate_service");
                            let wa_takhfif = $("#wa_takhfif");
                            let wa_darsade_avareze_arzeshe_afzode = $("#wa_darsade_avareze_arzeshe_afzode");
                            let wa_maliate_arzeshe_afzode = $("#wa_maliate_arzeshe_afzode");
                            let wa_mablaghe_ghabele_pardakht = $("#wa_mablaghe_ghabele_pardakht");
                            let wa_name_sherkat = $("#wa_name_sherkat");
                            let wa_tozihate_factor = $("#wa_tozihate_factor");
                            wa_code_posti.text('کدپستی: ' + res_print[0]['code_posti'].toString().toPersinaDigit());
                            wa_telephone.text('تلفن: ' + res_print[0]['telephone'].toString().toPersinaDigit());
                            wa_ostan.text('استان: ' + res_print[0]['ostane_sokonat']);
                            wa_shahr.text('شهر: ' + res_print[0]['shahre_sokonat']);

                            wa_fo_name.text('نام شرکت: ' + res_print[0]['fo_name']);
                            wa_fo_telephone.text('تلفن: ' + res_print[0]['fo_telephone'].toString().toPersinaDigit());
                            wa_fo_code_posti.text('کد پستی: ' + res_print[0]['fo_code_posti'].toString().toPersinaDigit());
                            wa_fo_code_eghtesadi.text('کد اقتصادی: ' + res_print[0]['fo_code_eghtesadi'].toString().toPersinaDigit());
                            wa_fo_shomare_sabt.text('شماره ثبت : ' + res_print[0]['fo_shomare_sabt'].toString().toPersinaDigit());
                            wa_fo_ostan.text('استان: ' + res_print[0]['fo_ostan']);
                            wa_fo_shahr.text('شهر: ' + res_print[0]['fo_shahr']);
                            wa_fo_address.text('آدرس: ' + res_print[0]['fo_address'].toString().toPersinaDigit());
                            wa_ostan.text('استان: ' + res_print[0]['ostane_sokonat']);
                            wa_shahr.text('شهر: ' + res_print[0]['shahre_sokonat']);
                            wa_tarikhe_factor.text('تاریخ فاکتور :' + tabdile_tarikh_adad(res_print[0]['tarikhe_factor']));
                            wa_shomarefactor.text('شماره فاکتور :' + res_print[0]['shomare_factor'].toString().toPersinaDigit());
                            wa_code_meli.text('کد ملی/کد اقتصادی : ' + res_print[0]['code_meli'].toString().toPersinaDigit());
                            wa_mobile.text('تلفن همراه : ' + res_print[0]['telephone_hamrah'].toString().toPersinaDigit());
                            wa_code_eshterak.text('کد اشتراک : ' + res_print[0]['code_eshterak'].toString().toPersinaDigit());
                            wa_address.text('آدرس : ' + res_print[0]['address']);
                            wa_name_va_family.text('نام مشترک / (شرکت) :' + res_print[0]['name'] + ' ' + res_print[0]['f_name']);
                            wa_tozihate_factor.text(res_print[0]['tozihate_faktor']);
                            wa_noe_khadamat.text(res_print[0]['onvane_service']);
                            wa_terafik.text(res_print[0]['terafik'].toString().toPersinaDigit());
                            wa_zaname_estefade.text(res_print[0]['zamane_estefade'].toString().toPersinaDigit());
                            wa_tarikhe_shoroe_service.text(tabdile_tarikh_adad(res_print[0]['tarikhe_shoroe_service'].toString()));
                            wa_tarikhe_payane_service.text(tabdile_tarikh_adad(res_print[0]['tarikhe_payane_service'].toString()));
                            wa_gheymate_service.text("" + res_print[0]['gheymate_service'].toString().toPersinaDigit());
                            wa_takhfif.text(res_print[0]['takhfif'].toString().toPersinaDigit());
                            wa_darsade_avareze_arzeshe_afzode.text(res_print[0]['darsade_avareze_arzeshe_afzode'].toString().toPersinaDigit());
                            wa_maliate_arzeshe_afzode.text(res_print[0]['maliate_arzeshe_afzode'].toString().toPersinaDigit());
                            wa_mablaghe_ghabele_pardakht.text(res_print[0]['mablaghe_ghabele_pardakht'].toString().toPersinaDigit());
                            wa_name_sherkat.text(res_print[0]['name_sherkat']);
                            Print_Adsl_Factor("print_form_wireless");
                            break;
                        case 'voip':
                            let vo_fo_name = $("#vo_fo_name");
                            let vo_fo_code_eghtesadi = $("#vo_fo_code_eghtesadi");
                            let vo_fo_ostan = $("#vo_fo_ostan");
                            let vo_fo_shahr = $("#vo_fo_shahr");
                            let vo_fo_shomare_sabt = $("#vo_fo_shomare_sabt");
                            let vo_fo_code_posti = $("#vo_fo_code_posti");
                            let vo_fo_telephone = $("#vo_fo_telephone");
                            let vo_fo_address = $("#vo_fo_address");
                            let vo_ostan = $("#vo_ostan");
                            let vo_shahr = $("#vo_shahr");
                            let vo_shomare_etesal = $("#vo_shomare_etesal");
                            let vo_shomarefactor = $("#vo_shomarefactor");
                            let vo_code_meli = $("#vo_code_meli");
                            let vo_tarikhe_factor = $("#vo_tarikhe_factor");
                            let vo_name_va_family = $("#vo_name_va_family");
                            let vo_mobile = $("#vo_mobile");
                            let vo_code_eshterak = $("#vo_code_eshterak");
                            let vo_address = $("#vo_address");
                            let vo_code_posti = $("#vo_code_posti");
                            let vo_telephone = $("#vo_telephone");
                            let vo_noe_khadamat = $("#vo_noe_khadamat");
                            let vo_zaname_estefade = $("#vo_zaname_estefade");
                            let vo_tarikhe_shoroe_service = $("#vo_tarikhe_shoroe_service");
                            let vo_tarikhe_payane_service = $("#vo_tarikhe_payane_service");
                            let vo_gheymate_service = $("#vo_gheymate_service");
                            let vo_takhfif = $("#vo_takhfif");
                            let vo_darsade_avareze_arzeshe_afzode = $("#vo_darsade_avareze_arzeshe_afzode");
                            let vo_maliate_arzeshe_afzode = $("#vo_maliate_arzeshe_afzode");
                            let vo_mablaghe_ghabele_pardakht = $("#vo_mablaghe_ghabele_pardakht");
                            let vo_name_sherkat = $("#vo_name_sherkat");
                            let vo_tozihate_factor = $("#vo_tozihate_factor");
                            let vo_pin_code = $("#vo_pin_code");
                            vo_fo_name.text('نام شرکت: ' + res_print[0]['fo_name']);
                            vo_fo_telephone.text('تلفن: ' + res_print[0]['fo_telephone'].toString().toPersinaDigit());
                            vo_fo_code_posti.text('کد پستی: ' + res_print[0]['fo_code_posti'].toString().toPersinaDigit());
                            vo_fo_code_eghtesadi.text('کد اقتصادی: ' + res_print[0]['fo_code_eghtesadi'].toString().toPersinaDigit());
                            vo_fo_shomare_sabt.text('شماره ثبت : ' + res_print[0]['fo_shomare_sabt'].toString().toPersinaDigit());
                            vo_fo_ostan.text('استان: ' + res_print[0]['fo_ostan']);
                            vo_fo_shahr.text('شهر: ' + res_print[0]['fo_shahr']);
                            vo_fo_address.text('آدرس: ' + res_print[0]['fo_address'].toString().toPersinaDigit());

                            vo_ostan.text('استان: ' + res_print[0]['ostane_sokonat']);
                            vo_shahr.text('شهر: ' + res_print[0]['shahre_sokonat']);
                            vo_code_posti.text('کدپستی: ' + res_print[0]['code_posti'].toString().toPersinaDigit());
                            vo_shomarefactor.text('شماره فاکتور:' + res_print[0]['shomare_factor'].toString().toPersinaDigit());
                            vo_code_meli.text('کد ملی/کد اقتصادی: ' + res_print[0]['code_meli'].toString().toPersinaDigit());
                            vo_tarikhe_factor.text('تاریخ فاکتور:' + tabdile_tarikh_adad(res_print[0]['tarikhe_factor']));
                            vo_mobile.text('تلفن همراه: ' + res_print[0]['telephone_hamrah'].toString().toPersinaDigit());
                            vo_code_eshterak.text('کد اشتراک: ' + res_print[0]['code_eshterak'].toString().toPersinaDigit());
                            vo_address.text('آدرس: ' + res_print[0]['address'].toString().toPersinaDigit());
                            vo_telephone.text('تلفن: ' + res_print[0]['telephone'].toString().toPersinaDigit());
                            vo_name_va_family.text('نام مشترک / (شرکت):' + res_print[0]['name'] + ' ' + res_print[0]['f_name']);
                            vo_tozihate_factor.text(res_print[0]['tozihate_faktor'].toString().toPersinaDigit());
                            vo_noe_khadamat.text(res_print[0]['onvane_service']);
                            vo_zaname_estefade.text(res_print[0]['zamane_estefade'].toString().toPersinaDigit());
                            vo_tarikhe_shoroe_service.text(tabdile_tarikh_adad(res_print[0]['tarikhe_shoroe_service'].toString()));
                            vo_tarikhe_payane_service.text(tabdile_tarikh_adad(res_print[0]['tarikhe_payane_service'].toString()));
                            vo_gheymate_service.text("" + res_print[0]['gheymate_service'].toString().toPersinaDigit());
                            vo_takhfif.text(res_print[0]['takhfif'].toString().toPersinaDigit());
                            vo_darsade_avareze_arzeshe_afzode.text(res_print[0]['darsade_avareze_arzeshe_afzode'].toString().toPersinaDigit());
                            vo_maliate_arzeshe_afzode.text(res_print[0]['maliate_arzeshe_afzode'].toString().toPersinaDigit());
                            vo_mablaghe_ghabele_pardakht.text(res_print[0]['mablaghe_ghabele_pardakht'].toString().toPersinaDigit());
                            vo_name_sherkat.text(res_print[0]['name_sherkat']);
                            vo_pin_code.text(res_print[0]['pin_code']);
                            Print_Adsl_Factor("print_form_voip");
                            break;
                        default:
                            display_Predefiend_Messages({ 'Warning': 'نوع سرویس نامشخص.' });
                            break;
                    }
                }

            });
        } else {
            Custom_Modal_Show('w', 'لطفا فاکتور مورد نظر را انتخاب کنید.');
        }
    });
    $('#factorpardakht_initbtn').on('click', function() {
        let tr = $('#factor_tab tbody').find('tr.selected');
        let td = tr.find('td:first').text();
        factor_id = td;
        Factors_Initialize('get_factor_info_by_id_check_date_and_credits', td, function(data) {
            console.log(data);
            let ft_noe_pardakht = $("#ft_noe_pardakht");
            ft_noe_pardakht.empty();
            $("#ft_pardakht_factor_id").val(data['factor_id']);
            $("#ft_pardakht_mablaghe_factor").val(data['mablaghe_factor']);

            if (!check_isset_message(data)) {
                if (data['branch']['status'] === false && data['subscriber']['status'] === false) {
                    let msg = 'شما قادر به پرداخت مبلغ این فاکتور نیستید لطفا ابتدا موجودی حساب نمایندگی یا مشترک مورد نظر را شارژ فرمایید.';
                    display_Predefiend_Messages({ 'Error': msg });
                } else {

                    ////////////////////////////////////////////branch//////////////////////////////////////////////
                    $("#modal_form_factortab_pardakht_selection").modal('show');
                    if (data['branch']['status'] === false) {
                        $("#ft_pardakht_name_sherkat").val(data['branch']['name']);
                        $("#ft_pardakht_mojodi_namayande").val(data['branch']['credit']);
                        $("#ft_pardakht_az_namayande").prop("disabled", "disabled");
                    } else {
                        ft_noe_pardakht.append('<option value="pardakht_az_namayande">از حساب نماینده</option>');
                        $("#ft_pardakht_name_sherkat").val(data['branch']['name']);
                        $("#ft_pardakht_mojodi_namayande").val(data['branch']['credit']);
                    }
                    ////////////////////////////////////////////subscriber//////////////////////////////////////////////
                    if (data['subscriber']['status'] === false) {
                        $("#ft_pardakht_name_subscriber").val(data['subscriber']['name']);
                        $("#ft_pardakht_mojodi_subscriber").val(data['subscriber']['credit']);
                        $("#ft_pardakht_az_subscriber").prop("disabled", "disabled");
                    } else {
                        ft_noe_pardakht.append('<option value="pardakht_az_subscriber">از حساب مشترک</option>');
                        $("#ft_pardakht_name_subscriber").val(data['subscriber']['name']);
                        $("#ft_pardakht_mojodi_subscriber").val(data['subscriber']['credit']);

                    }

                    ft_noe_pardakht.prop("selectedIndex", -1);
                }
            } else {
                display_Predefiend_Messages(data);
            }

        });

    });
    ////////////////////////////////////////ONLINE USER///////////////////////////////////////////////////
    /*    online_user_select_username.on('change', function () {
            let factor_id = $(this).val();
            Factors_Initialize('get_online_user_info', factor_id, function (data) {
                console.log(data);
                if (!check_isset_message(data)) {
                    if (data[1]) {
                        let key = Object.keys(data[1]);
                        key = key[0];
                        if (key) {
                            data = data[1][key];
                            if (data['online_status']) {
                                if (data['internet_onlines'].length > 0) {
                                    var dataset = [];
                                    dataset[0] = [];
                                    let cols = [{
                                        title: 'Login Time'
                                    },
                                    {
                                        title: 'In Bytes'
                                    },
                                    {
                                        title: 'Out Bytes'
                                    },
                                    {
                                        title: 'In Rate'
                                    },
                                    {
                                        title: 'Out Rate'
                                    },
                                    // { title: 'Sub Service' },
                                    //{ title: 'QOS' },
                                    {
                                        title: 'Remote IP'
                                    },
                                    {
                                        title: 'MAC'
                                    },
                                    {
                                        title: 'Port'
                                    },
                                    {
                                        title: 'Ras Desc'
                                    },
                                    ];
                                    dataset[0].push(data['internet_onlines'][0][3]);
                                    dataset[0].push(bytesToSize(data['internet_onlines'][0][9]));
                                    dataset[0].push(bytesToSize(data['internet_onlines'][0][10]));
                                    dataset[0].push(bytesToSize(data['internet_onlines'][0][11]));
                                    dataset[0].push(bytesToSize(data['internet_onlines'][0][12]));
                                    //dataset[0].push(data['internet_onlines'][i][13]);
                                    //dataset[0].push("");
                                    dataset[0].push(data['internet_onlines'][0][4]);
                                    dataset[0].push(data['internet_onlines'][0][7]);
                                    dataset[0].push(data['internet_onlines'][0][8]);
                                    dataset[0].push(data['internet_onlines'][0][1]);
    
                                    DataTable_array_datasource('#online_user_table', dataset, cols, function (table) {
    
                                    });
                                } else if (data['voip_onlines'].length > 0) {
                                    var dataset = [];
                                    dataset[0] = [];
                                    let cols = [{
                                        title: 'Login Time'
                                    },
                                    {
                                        title: 'In Bytes'
                                    },
                                    {
                                        title: 'Out Bytes'
                                    },
                                    {
                                        title: 'In Rate'
                                    },
                                    {
                                        title: 'Out Rate'
                                    },
                                    // { title: 'Sub Service' },
                                    //{ title: 'QOS' },
                                    {
                                        title: 'Remote IP'
                                    },
                                    {
                                        title: 'MAC'
                                    },
                                    {
                                        title: 'Port'
                                    },
                                    {
                                        title: 'Ras Desc'
                                    },
                                    ];
                                    dataset[0].push(data['internet_onlines'][0][3]);
                                    dataset[0].push(bytesToSize(data['internet_onlines'][0][9]));
                                    dataset[0].push(bytesToSize(data['internet_onlines'][0][10]));
                                    dataset[0].push(bytesToSize(data['internet_onlines'][0][11]));
                                    dataset[0].push(bytesToSize(data['internet_onlines'][0][12]));
                                    //dataset[0].push(data['internet_onlines'][i][13]);
                                    //dataset[0].push("");
                                    dataset[0].push(data['internet_onlines'][0][4]);
                                    dataset[0].push(data['internet_onlines'][0][7]);
                                    dataset[0].push(data['internet_onlines'][0][8]);
                                    dataset[0].push(data['internet_onlines'][0][1]);
    
                                    DataTable_array_datasource('#online_user_table', dataset, cols, function (table) {
    
                                    });
                                } else {
                                    alert('اطلاعات گزارش آنلاین کاربر یافت نشد.');
                                }
                            } else {
                                alert('کاربر آنلاین نیست');
                            }
                        } else {
                            alert('کاربر یافت نشد لطفا IBS را بررسی کنید.');
                        }
                    } else {
                        alert('اطلاعات online برای این سرویس کاربر یافت نشد.');
                    }
                } else {
                    display_Predefiend_Messages(data);
                }
            });
        });
    */

    //printDiv('print_form_adsl');

});