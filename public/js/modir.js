$(document).ready(function() {
    DATEPICKER_YYYYMMDD('#tarikhe_tavalod');
    //int
    let national_code = $("#national_code");
    let s_s = $("#s_s");
    let telephone_hamrah = $("#telephone_hamrah");
    let telephone_mahale_sokonat = $("#telephone_mahale_sokonat");
    //int
    // validateInteger([s_s, telephone_mahale_sokonat]);
    // var plugin_options = {
    //     plugin_main_method: 'qtip',
    //     show_method: 'show',
    //     hide_method: 'hide',
    //     default_text: 'This is default text',
    //     plugin_attr_options: 'title',
    //     plugin_options: {
    //         position: {
    //             my: 'right bottom', // Position my top left...
    //             at: 'left down' // at the bottom right of...
    //         }
    //     }
    // };
    // $('form').validationPower({
    //     letterFlash: {
    //         flashShow: '',
    //         flashLastChars: 1,
    //         flashStyle: {
    //             display: 'none',
    //             position: 'absolute',
    //             right: '100%',
    //             top: '-50%',
    //             width: '100px',
    //             'font-size': '50px'
    //         }
    //     }
    // });
    // var timeout;
    // $('#national_code').on('input', function() {
    //     var elem = $(this);
    //     var val = elem.val();
    //     clearTimeout(timeout);
    //     elem.vp_external_check('vp-error-2', 'add');
    //     if (val.length >= 10) {
    //         var nationals = [val];
    //         timeout = setTimeout(function() {
    //             if ($.inArray(val, nationals) != -1) {
    //                 elem.vp_external_check('vp-error-2', 'remove');
    //             }
    //         }, 1000);
    //     }
    // });
    let ostan_tavalod      = $("#ostan_tavalod");
    let shahr_tavalod      = $("#shahr_tavalod");
    let ostan_sokonat      = $("#ostan_sokonat");
    let shahr_sokonat      = $("#shahr_sokonat");
    ostan_tavalod.select2();
    shahr_tavalod.select2();
    ostan_sokonat.select2();
    shahr_sokonat.select2();
    GetProvinces('1', function(result) {
        if(! check_isset_message(result)){
            appendOption(ostan_tavalod, result, 'id', 'name');
            appendOption(ostan_sokonat, result, 'id', 'name');
        }else{
            display_Predefiend_Messages(result);
        }
    });
    ostan_tavalod.on('change', function() {
        // GetCityByProvince($(this).val(), function(result) {
            ajaxRequest('GetCityByProvince', { 'ostanid': $(this).val() }, window.location.href.split('/').slice(-1)[0], function(result) {
            shahr_tavalod.empty();
            if (! check_isset_message(result)) {
                appendOption(shahr_tavalod, result, 'id', 'name');
            } else {
                shahr_tavalod.empty();
            }
        });
    });

    ostan_sokonat.on('change', function() {
        // GetCityByProvince($(this).val(), function(result) {
            ajaxRequest('GetCityByProvince', { 'ostanid': $(this).val() }, window.location.href.split('/').slice(-1)[0], function(result) {
            shahr_sokonat.empty();
            if (! check_isset_message(result)) {
                appendOption(shahr_sokonat, result, 'id', 'name');
            } else {
                shahr_sokonat.empty();
            }
        });
    });
    Get_Branch_Info('modir', function(data) {
        if (!check_isset_message(data)) {
            var element = $('#branch_id');
            if (element) {
                for (let i = 0; i < data.length; i++) {
                    element.append('<option value=' + data[i]['id'] + '>' + data[i]['name_sherkat'] + '</option>')
                }
            }
        } else {
            display_Predefiend_Messages(data);
        }
    });
    //$(".custom_select").select2();

    Get_organization_levels('modir', function(data) {
        if (data) {
            //has data
            var element = $('#level_id');
            if (element) {
                for (let i = 0; i < data.length; i++) {
                    element.append('<option value=' + data[i]['id'] + '>' + data[i]['semat'] + '</option>')
                }
            }
        } else {
            //data az db gerefte nashod
            alert('درخواست ناموفق');
        }
    });


    /*===================++  DATA_TABLE  ++=========================*/
    var cols = [{
            "data": "id",
            title: 'شناسه'
        },
        {
            "data": "name",
            title: 'نام'
        },
        {
            "data": "branch_id",
            title: 'نام نمایندگی'
        },
        {
            "data": "telephone_hamrah",
            title: 'تلفن همراه'
        },
        {
            "data": "telephone_mahale_sokonat",
            title: 'تلفن محل سکونت'
        },
        {
            "data": "email",
            title: 'ایمیل'
        },
        {
            "data": "username",
            title: 'نام کاربری'
        }
    ];
    DataTable3('#view_table', /*path*/ 'modir', /*request(dont change)*/ 'datatable_request', /*request2*/ 'modir', 'POST', cols, function(table) {

        /*===================++  hide first column ++=========================*/
        //table.column(0).visible(false);
        /*===================++  select table row ++=========================*/
        $('#view_table tbody').on('click', 'tr', function() {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            } else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });
        $('#delete').click(function() {
            //shenase avalin soton dt mibashad
            let tr = $('#view_table tbody').find('tr.selected');
            let td = tr.find('td:first').text();
            Hard_Delete(td, 'modir', function(data) {
                if (data) {
                    table.ajax.reload();
                } else {
                    alert('عملیات ناموفق');
                }
            });
        });
    });
    $('#edit').click(function() {
        let tr = $('#view_table tbody').find('tr.selected');
        let td = tr.find('td:first').text();
        Edit_Form('modir', td, function(data) {
            console.log(data);
            ostan_tavalod.val(data[0]['ostan_tavalod_id']).change();
            // GetCityByProvince(data[0]['ostan_tavalod_id'], function(result) {
                ajaxRequest('GetCityByProvince', { 'ostanid': data[0]['ostan_tavalod_id'] }, window.location.href.split('/').slice(-1)[0], function(result) {
                shahr_tavalod.empty();
                if (! check_isset_message(result)) {
                    appendOption(shahr_tavalod, result, 'id', 'name');
                    shahr_tavalod.val(data[0]['shahr_tavalod']).change();
                }else{
                    shahr_tavalod.empty();
                }
            });
            
            ostan_sokonat.val(data[0]['ostan_sokonat_id']).change();
            // GetCityByProvince(data[0]['ostan_sokonat_id'], function(result) {
                ajaxRequest('GetCityByProvince', { 'ostanid': data[0]['ostan_sokonat_id'] }, window.location.href.split('/').slice(-1)[0], function(result) {
                shahr_sokonat.empty();
                if (! check_isset_message(result)) {
                    appendOption(shahr_sokonat, result, 'id', 'name');
                    shahr_sokonat.val(data[0]['shahr_sokonat']).change();
                }else{
                    shahr_sokonat.empty();
                }
            });
            $('#id').val(data[0]['id']);
            $('#street').val(data[0]['street']);
            $('#street2').val(data[0]['street2']);
            $('#housenumber').val(data[0]['housenumber']);
            $('#tabaghe').val(data[0]['tabaghe']);
            $('#vahed').val(data[0]['vahed']);
            $('#code_posti').val(data[0]['code_posti']);
            $('#ismodir').val(data[0]['ismodir']).change();;
            $("#branch_id").attr('readonly', true);
            $('#branch_id option[value="' + data[0]['branch_id'] + '"]').attr('selected', 'selected');
            // $("#branch_id").val(data[0]['branch_id']);
            $('#name').val(data[0]['name']);
            $('#name_khanevadegi').val(data[0]['name_khanevadegi']);
            $('#national_code').val(data[0]['code_meli']);
            $('#s_s').val(data[0]['shomare_shenasname']);
            $('#name_pedar').val(data[0]['name_pedar']);
            $('#tarihke_tavalod').val(data[0]['tarihke_tavalod']);
            $('#madrake_tahsili option[value="' + data[0]['madrake_tahsili'] + '"]').attr('selected', 'selected');
            $('#reshteye_tahsili').val(data[0]['reshteye_tahsili']);
            $('#ostan_tavalod').val(data[0]['ostan_tavalod']);
            $('#shahr_tavalod').val(data[0]['shahr_tavalod']);
            $('#telephone_hamrah').val(data[0]['telephone_hamrah']);
            $('#telephone_mahale_sokonat').val(data[0]['telephone_mahale_sokonat']);
            $('#address').val(data[0]['address']);
            $('#email').val(data[0]['email']);
            $('#level_id option[value="' + data[0]['level_id'] + '"]').attr('selected', 'selected');
            //$('#level_id').val(data[0]['semat']);
            $('#username').val(data[0]['username']);
            $('#password').val(data[0]['password']);
            $('#t_karte_meli').val(data[0]['t_karte_meli']);
            $('#t_shenasname').val(data[0]['t_shenasname']);
            $('#t_madrake_tahsili').val(data[0]['t_madrake_tahsili']);
            $('#t_chehre').val(data[0]['t_chehre']);

            //$('#ostan option[value="'+data[0]['ostan_id']+'"]').attr('selected','selected');


            //$('.form-group').each(function(i) {

            //});

        });
    });


});