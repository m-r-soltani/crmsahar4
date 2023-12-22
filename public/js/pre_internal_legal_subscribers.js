$(document).ready(function () {
    $("form").submit(function(e) {
        ajaxForms(e, $(this));
    });
    //$(".custom_select").select2();
    DATEPICKER_YYYYMMDD('#tarikhe_sabt');
    DATEPICKER_YYYYMMDD('#tarikhe_tavalod');
    let national_code = $("#national_code");
    let s_s = $("#s_s");
    let shenase_meli = $("#shenase_meli");
    let shomare_sabt = $("#shomare_sabt");
    let telephone1 = $("#telephone1");
    let telephone2 = $("#telephone2");
    let telephone3 = $("#telephone3");
    let code_posti1 = $("#code_posti1");
    let code_posti2 = $("#code_posti2");
    let code_posti3 = $("#code_posti3");
    let telephone_hamrah = $("#telephone_hamrah");
    let shomare_dakheli = $("#shomare_dakheli");
    let fax = $("#fax");
    let ostane_tavalod = $("#ostane_tavalod");
    let shahre_tavalod = $("#shahre_tavalod");
    let ostane_sokonat      = $("#ostane_sokonat");
    let shahre_sokonat      = $("#shahre_sokonat");
    let tel1_ostan          = $("#tel1_ostan");
    let tel2_ostan          = $("#tel2_ostan");
    let tel3_ostan          = $("#tel3_ostan");
    let tel1_shahr          = $("#tel1_shahr");
    let tel2_shahr          = $("#tel2_shahr");
    let tel3_shahr          = $("#tel3_shahr");
    let tel1_street         = $("#tel1_street");
    let tel2_street         = $("#tel2_street");
    let tel3_street         = $("#tel3_street");
    let tel1_stree2         = $("#tel1_street2");
    let tel2_stree2         = $("#tel2_street2");
    let tel3_stree2         = $("#tel3_street2");
    let tel1_housenumber    = $("#tel1_housenumber");
    let tel2_housenumber    = $("#tel2_housenumber");
    let tel3_housenumber    = $("#tel3_housenumber");
    let meliat = $("#meliat");
    let meliat_namayande = $("#meliat_namayande");
    let tabeiat = $("#tabeiat");
    let noe_sherkat = $("#noe_sherkat");
    ostane_sokonat.select2();
    shahre_sokonat.select2();
    ostane_tavalod.select2();
    shahre_tavalod.select2();
    let branch_id = $("#branch_id");
    branch_id.select2();
    ajaxRequest('GetBranchesListByCurrentUserAuthorities', { aa: false }, window.location.href.split('/').slice(-1)[0], function(result) {
        if(! check_isset_message(result)){
            branch_id.empty();
            if(result.length>1){
                appendOption(branch_id, result, 'id', 'name_sherkat');
            }else{
                $.each(result, function(i, item) {
                    branch_id.append($('<option>', {
                        value: item.id,
                        selected:true,
                        text: Getor_String(item.name_sherkat, '---')
                    }));
                });
            }
        }
    });
    Initialize('get_company_types', function (result) {
        appendOption(noe_sherkat, result, 'id', 'noe_sherkat');
    });
    Initialize('get_countries', function (result) {
        appendOption(meliat, result, 'id', 'name');
        appendOption(meliat_namayande, result, 'id', 'name');
        appendOption(tabeiat, result, 'id', 'name');
    });

    ajaxRequest('GetProvincesAndCities', { aa: false }, window.location.href.split('/').slice(-1)[0], function(result) {
        if(! check_isset_message(result)){
            provcit=result;
            appendOption(ostane_tavalod, result, 'id', 'name');
            appendOption(ostane_sokonat, result, 'id', 'name');
            appendOption(tel1_ostan, result, 'id', 'name');
            appendOption(tel2_ostan, result, 'id', 'name');
            appendOption(tel3_ostan, result, 'id', 'name');
        }
    });

    ostane_tavalod.on('change', function() {
        shahre_tavalod.empty();
        if(provcit){
            for (let i = 0; i < provcit.length; i++) {
                if($(this).val()==provcit[i]['id']){
                    appendOption(shahre_tavalod, provcit[i]['cities'], 'id', 'name');
                }
            }
        }
    });

    ostane_sokonat.on('change', function() {
        // GetCityByProvince($(this).val(), function(result) {
        shahre_sokonat.empty();
        if(provcit){
            for (let i = 0; i < provcit.length; i++) {
                if($(this).val()==provcit[i]['id']){
                    appendOption(shahre_sokonat, provcit[i]['cities'], 'id', 'name');
                }
            }
        }
    });

    tel1_ostan.on('change', function() {
        tel1_shahr.empty();
        if(provcit){
            for (let i = 0; i < provcit.length; i++) {
                if($(this).val()==provcit[i]['id']){
                    appendOption(tel1_shahr, provcit[i]['cities'], 'id', 'name');
                }
            }
        }
    });

    tel2_ostan.on('change', function() {
        tel2_shahr.empty();
        if(provcit){
            for (let i = 0; i < provcit.length; i++) {
                if($(this).val()==provcit[i]['id']){
                    appendOption(tel2_shahr, provcit[i]['cities'], 'id', 'name');
                }
            }
        }
    });
    
    tel3_ostan.on('change', function() {
        tel3_shahr.empty();
        if(provcit){
            for (let i = 0; i < provcit.length; i++) {
                if($(this).val()==provcit[i]['id']){
                    appendOption(tel3_shahr, provcit[i]['cities'], 'id', 'name');
                }
            }
        }
    });





    // GetProvinces('1', function(result) {
    //     if(! check_isset_message(result)){
    //         appendOption(ostane_tavalod, result, 'id', 'name');
    //         appendOption(ostane_sokonat, result, 'id', 'name');
    //         appendOption(tel1_ostan, result, 'id', 'name');
    //         appendOption(tel2_ostan, result, 'id', 'name');
    //         appendOption(tel3_ostan, result, 'id', 'name');
    //     }else{
    //         display_Predefiend_Messages(result);
    //     }
    // });

    // ostane_tavalod.on('change', function() {
    //     // GetCityByProvince($(this).val(), function(result) {
    //     ajaxRequest('GetCityByProvince', { 'ostanid': $(this).val() }, window.location.href.split('/').slice(-1)[0], function(result) {
    //         shahre_tavalod.empty();
    //         if (! check_isset_message(result)) {
    //             appendOption(shahre_tavalod, result, 'id', 'name');
    //         } else {
    //             shahre_tavalod.empty();
    //         }
    //     });
    // });

    // ostane_sokonat.on('change', function() {
    //     // GetCityByProvince($(this).val(), function(result) {
    //     ajaxRequest('GetCityByProvince', { 'ostanid': $(this).val() }, window.location.href.split('/').slice(-1)[0], function(result) {
    //         shahre_sokonat.empty();
    //         if (! check_isset_message(result)) {
    //             appendOption(shahre_sokonat, result, 'id', 'name');
    //         } else {
    //             shahre_sokonat.empty();
    //         }
    //     });
    // });
    // tel1_ostan.on('change', function() {
    //     // GetCityByProvince($(this).val(), function(result) {
    //     ajaxRequest('GetCityByProvince', { 'ostanid': $(this).val() }, window.location.href.split('/').slice(-1)[0], function(result) {
    //         tel1_shahr.empty();
    //         if (! check_isset_message(result)) {
    //             appendOption(tel1_shahr, result, 'id', 'name');
    //         } else {
    //             tel1_shahr.empty();
    //         }
    //     });
    // });
    // tel2_ostan.on('change', function() {
    //     // GetCityByProvince($(this).val(), function(result) {
    //     ajaxRequest('GetCityByProvince', { 'ostanid': $(this).val() }, window.location.href.split('/').slice(-1)[0], function(result) {            
    //         tel2_shahr.empty();
    //         if (! check_isset_message(result)) {
    //             appendOption(tel2_shahr, result, 'id', 'name');
    //         } else {
    //             tel2_shahr.empty();
    //         }
    //     });
    // });
    // tel3_ostan.on('change', function() {
    //     // GetCityByProvince($(this).val(), function(result) {
    //     ajaxRequest('GetCityByProvince', { 'ostanid': $(this).val() }, window.location.href.split('/').slice(-1)[0], function(result) {
    //         tel3_shahr.empty();
    //         if (! check_isset_message(result)) {
    //             appendOption(tel3_shahr, result, 'id', 'name');
    //         } else {
    //             tel3_shahr.empty();
    //         }
    //     });
    // });
    meliat.on('change',function(){
        ajaxRequest('checkisirani', $(this).val(), window.location.href.split('/').slice(-1)[0], function(result){
            if(! check_isset_message(result)){
                if(result){
                    s_s.prop("required", "true");
                }else{
                    s_s.prop("required", "false");
                }               
            }else{                
                display_Predefiend_Messages(result);
            }
        });
    });
    //////////////////////__CONFIRM SUB/////////////////////////////
    $('#confirmsub').click(function() {
        let tr = $('#view_table tbody').find('tr.selected');
        let td = tr.find('td:first').text();
        ajaxRequest('confirmprelegalsub', { 'subid': td }, window.location.href.split('/').slice(-1)[0], function(result) {
            if (check_isset_message(result)) {
                display_Predefiend_Messages(result);
            }
        });
    });
    $('#edit').click(function () {
        let tr = $('#view_table tbody').find('tr.selected');
        let td = tr.find('td:first').text();
        Edit_Form('pre_internal_legal_subscribers', td, function (data) {
            console.log(data);
            branch_id.empty();
            $.each(data[0]['branches_list'], function(i, item) {
                branch_id.append($('<option>', {
                    value: item.id,
                    text: Getor_String(item.name_sherkat, '---')
                }));
            });
            branch_id.val(data[0]['branch_id']);

            data[0]['tarikhe_sabt']     = tabdile_tarikh_adad(data[0]['tarikhe_sabt']);
            data[0]['tarikhe_tavalod']  = tabdile_tarikh_adad(data[0]['tarikhe_tavalod']);
            national_code.val(data[0]['code_meli']);
            $('#tarikhe_tavalod').val(data[0]['tarikhe_tavalod']);
            $('#tarikhe_sabt').val(data[0]['tarikhe_sabt']);
            $('#noe_sherkat').val(data[0]['noe_sherkat']);
            //tabdile miladi be shamsi+tabdile adade englisi be farsi
            $('#id').val(data[0]['id']);
            $('#name_en').val(data[0]['name_en']);
            $('#name_pedare').val(data[0]['name_pedare']);
            $('#noe_moshtarak').val(data[0]['noe_moshtarak']);
            $('#name_sherkat').val(data[0]['name_sherkat']);
            $('#shomare_sabt').val(data[0]['shomare_sabt']);
            $('#name').val(data[0]['name']);
            $('#f_name').val(data[0]['f_name']);
            meliat.val(data[0]['meliat']);
            meliat_namayande.val(data[0]['meliat_namayande']);
            tabeiat.val(data[0]['tabeiat']);

            ostane_tavalod.val(data[0]['ostane_tavalod']).change();
            shahre_tavalod.val(data[0]['shahre_tavalod']);

            ostane_sokonat.val(data[0]['ostane_sokonat']).change();
            shahre_sokonat.val(data[0]['shahre_sokonat']);
            
            tel1_ostan.val(data[0]['tel1_ostan']).change();
            tel1_shahr.val(data[0]['tel1_shahr']);
            
            tel2_ostan.val(data[0]['tel2_ostan']).change();
            tel2_shahr.val(data[0]['tel2_shahr']);
            
            tel3_ostan.val(data[0]['tel3_ostan']).change();
            tel3_shahr.val(data[0]['tel3_shahr']);

            // ostane_tavalod.val(data[0]['ostan_id']).change();
            // GetCityByProvince(data[0]['ostan_id'], function(result) {
            // ajaxRequest('GetCityByProvince', { 'ostanid': data[0]['ostan_id'] }, window.location.href.split('/').slice(-1)[0], function(result) {
            //     shahre_tavalod.empty();
            //     if (! check_isset_message(result)) {
            //         appendOption(shahre_tavalod, result, 'id', 'name');
            //         shahre_tavalod.val(data[0]['city_id']).change();
            //     }else{
            //         shahre_tavalod.empty();
            //     }
            // });
            
            // ostane_sokonat.val(data[0]['ostane_sokonat_id']).change();
            // // GetCityByProvince(data[0]['ostane_sokonat_id'], function(result) {
            //     ajaxRequest('GetCityByProvince', { 'ostanid': data[0]['ostane_sokonat_id'] }, window.location.href.split('/').slice(-1)[0], function(result) {
            //     shahre_sokonat.empty();
            //     if (! check_isset_message(result)) {
            //         appendOption(shahre_sokonat, result, 'id', 'name');
            //         shahre_sokonat.val(data[0]['shahre_sokonat_id']).change();
            //     }else{
            //         shahre_sokonat.empty();
            //     }
            // });
            
            // tel1_ostan.val(data[0]['tel1_ostan_id']).change();
            // // GetCityByProvince(data[0]['tel1_ostan_id'], function(result) {
            //     ajaxRequest('GetCityByProvince', { 'ostanid': data[0]['tel1_ostan_id'] }, window.location.href.split('/').slice(-1)[0], function(result) {
            //     tel1_shahr.empty();
            //     if (! check_isset_message(result)) {
            //         appendOption(tel1_shahr, result, 'id', 'name');
            //         tel1_shahr.val(data[0]['tel1_shahr_id']).change();
            //     }else{
            //         tel1_shahr.empty();
            //     }
            // });
            $('#tel1_street').val(data[0]['tel1_street']);
            $('#tel2_street').val(data[0]['tel2_street']);
            $('#tel3_street').val(data[0]['tel3_street']);
            $('#tel1_street2').val(data[0]['tel1_street2']);
            $('#tel2_street2').val(data[0]['tel2_street2']);
            $('#tel3_street2').val(data[0]['tel3_street2']);

            $('#tel1_housenumber').val(data[0]['tel1_housenumber']);
            $('#tel1_tabaghe').val(data[0]['tel1_tabaghe']);
            $('#tel1_vahed').val(data[0]['tel1_vahed']);

            $('#tel2_housenumber').val(data[0]['tel2_housenumber']);
            $('#tel2_tabaghe').val(data[0]['tel2_tabaghe']);
            $('#tel2_vahed').val(data[0]['tel2_vahed']);
            
            $('#tel3_housenumber').val(data[0]['tel3_housenumber']);
            $('#tel3_tabaghe').val(data[0]['tel3_tabaghe']);
            $('#tel3_vahed').val(data[0]['tel3_vahed']);
            $('#shenase_meli').val(data[0]['shenase_meli']);
            $('#telephone1').val(data[0]['telephone1']);
            $('#telephone2').val(data[0]['telephone2']);
            $('#telephone3').val(data[0]['telephone3']);

            $('#noe_malekiat1').val(data[0]['noe_malekiat1']);
            $('#name_malek1').val(data[0]['name_malek1']);
            $('#f_name_malek1').val(data[0]['f_name_malek1']);
            $('#code_meli_malek1').val(data[0]['code_meli_malek1']);

            $('#noe_malekiat2').val(data[0]['noe_malekiat2']);
            $('#name_malek2').val(data[0]['name_malek2']);
            $('#f_name_malek2').val(data[0]['f_name_malek2']);
            $('#code_meli_malek2').val(data[0]['code_meli_malek2']);

            $('#noe_malekiat3').val(data[0]['noe_malekiat3']);
            $('#name_malek3').val(data[0]['name_malek3']);
            $('#f_name_malek3').val(data[0]['f_name_malek3']);
            $('#code_meli_malek3').val(data[0]['code_meli_malek3']);

            $('#shomare_dakheli').val(data[0]['shomare_dakheli']);
            $('#telephone_hamrah').val(data[0]['telephone_hamrah']);
            $('#email').val(data[0]['email']);
            $('#fax').val(data[0]['fax']);
            $('#website').val(data[0]['website']);
            $('#code_posti1').val(data[0]['code_posti1']);
            $('#code_posti2').val(data[0]['code_posti2']);
            $('#code_posti3').val(data[0]['code_posti3']);
            $('#address1').val(data[0]['address1']);
            $('#address2').val(data[0]['address2']);
            $('#address3').val(data[0]['address3']);
            $('#code_eghtesadi').val(data[0]['code_eghtesadi']);
            $('#code_meli').val(data[0]['code_meli']);
            $('#s_s').val(data[0]['shomare_shenasname']);
            $('#name_pedar').val(data[0]['name_pedar']);
            $('#reshteye_faaliat').val(data[0]['reshteye_faaliat']);
            $('#moaref').val(data[0]['moaref']);
            $('#tozihat').val(data[0]['tozihat']);
            $('#tozihate_darkhast').val(data[0]['tozihate_darkhast']);
            $('#noedarkhast').val(data[0]['noedarkhast']);
            ///aks
            if (data[0]['l_t_agahie_tasis'] && data[0]['l_t_agahie_tasis'] !== '') {
                $("#linkltagahietasis").remove();
                $('#link_l_t_agahie_tasis').append("<a id ='linkltagahietasis' target='_blank' href=" + window.location.origin + '/public/images/' + data[0]['l_t_agahie_tasis'] + ">مشاهده تصویر</a>");
            }
            if (data[0]['l_t_akharin_taghirat'] && data[0]['l_t_akharin_taghirat'] !== '') {
                $("#linkltakharintaghirat").remove();
                $('#link_l_t_akharin_taghirat').append("<a id ='linkltakharintaghirat' target='_blank' href=" + window.location.origin + '/public/images/' + data[0]['l_t_akharin_taghirat'] + ">مشاهده تصویر</a>");
            }
            if (data[0]['l_t_saheb_kartemeli_emzaye_aval'] && data[0]['l_t_saheb_kartemeli_emzaye_aval'] !== '') {
                $('#linkltsahebkartemeliemzaye_aval').remove();
                $('#link_l_t_saheb_kartemeli_emzaye_aval').append("<a id ='linkltsahebkartemeliemzaye_aval' target='_blank' href=" + window.location.origin + '/public/images/' + data[0]['l_t_saheb_kartemeli_emzaye_aval'] + ">مشاهده تصویر</a>");
            }
            if (data[0]['l_t_saheb_kartemeli_emzaye_dovom'] && data[0]['l_t_saheb_kartemeli_emzaye_dovom'] !== '') {
                $('#linkltsahebkartemeliemzaye_dovom').remove();
                $('#link_l_t_saheb_kartemeli_emzaye_dovom').append("<a id ='linkltsahebkartemeliemzaye_dovom' target='_blank' href=" + window.location.origin + '/public/images/' + data[0]['l_t_saheb_kartemeli_emzaye_dovom'] + ">مشاهده تصویر</a>");
            }
            if (data[0]['l_t_kartemeli_namayande'] && data[0]['l_t_kartemeli_namayande'] !== '') {
                $('#linkltkartemelinamayande').remove();
                $('#link_l_t_kartemeli_namayande').append("<a id ='linkltkartemelinamayande' target='_blank' href=" + window.location.origin + '/public/images/' + data[0]['l_t_kartemeli_namayande'] + ">مشاهده تصویر</a>");
            }
            if (data[0]['l_t_moarefiname_namayande'] && data[0]['l_t_moarefiname_namayande'] !== '') {
                $('#linkltmoarefinamenamayande').remove();
                $('#link_l_t_moarefiname_namayande').append("<a id ='linkltmoarefinamenamayande' target='_blank' href=" + window.location.origin + '/public/images/' + data[0]['l_t_moarefiname_namayande'] + ">مشاهده تصویر</a>");
            }
            if (data[0]['l_t_ghabze_telephone'] && data[0]['l_t_ghabze_telephone'] !== '') {
                $('#linkltghabzetelephone').remove();
                $('#link_l_t_ghabze_telephone').append("<a id ='linkltghabzetelephone' target='_blank' href=" + window.location.origin + '/public/images/' + data[0]['l_t_ghabze_telephone'] + ">مشاهده تصویر</a>");
            }
            if (data[0]['l_t_gharardad'] && data[0]['l_t_gharardad'] !== '') {
                $('#linkltgharardad').remove();
                $('#link_l_t_gharardad').append("<a id ='linkltgharardad' target='_blank' href=" + window.location.origin + '/public/images/' + data[0]['l_t_gharardad'] + ">مشاهده تصویر</a>");
            }
            if (data[0]['l_t_ejarename_malekiat'] && data[0]['l_t_ejarename_malekiat'] !== '') {
                $('#linkltejarenamemalekiat').remove();
                $('#link_l_t_ejarename_malekiat').append("<a id ='linkltejarenamemalekiat' target='_blank' href=" + window.location.origin + '/public/images/' + data[0]['l_t_ejarename_malekiat'] + ">مشاهده تصویر</a>");
            }
            if (data[0]['l_t_sayer'] && data[0]['l_t_sayer'] !== '') {
                $('#linkltsayer').remove();
                $('#link_l_t_sayer').append("<a id ='linkltsayer' target='_blank' href=" + window.location.origin + '/public/images/' + data[0]['l_t_sayer'] + ">مشاهده تصویر</a>");
            }
            ///aks
            $('#jensiat option[value="' + data[0]["jensiat"] + '"]').attr('selected', 'selected');
            // $("#jensiat").val(data[0]["jensiat"]);
            $('#nahve_moarefi option[value="' + data[0]["nahve_moarefi"] + '"]').attr('selected', 'selected');
            $('#nahve_ashnai option[value="' + data[0]["nahve_ashnai"] + '"]').attr('selected', 'selected');
            $('#gorohe_moshtarak option[value="' + data[0]["gorohe_moshtarak"] + '"]').attr('selected', 'selected');
            $('#noe_shenase_hoviati option[value="' + data[0]["noe_shenase_hoviati"] + '"]').attr('selected', 'selected');
            ////////////////tasvire logo dorost shavad
            //$('#t_logo').val(data[0]['name_service_dahande']);
            // if (data[0]['dsl_license'] === "on") {
            //     $('#dsl_license').prop('checked', true);
            // } else {
            //     $('#dsl_license').prop('checked', false);
            // }


        });
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
        "data": "f_name",
        title: 'نام خانوادگی'
    },
    {
        "data": "name_sherkat",
        title: 'نام شرکت'
    },
    {
        "data": "code_meli",
        title: 'کد ملی نماینده/مدیرعامل'
    },
    {
        "data": "telephone1",
        title: 'تلفن تماس'
    },
    {
        "data": "telephone_hamrah",
        title: 'تلفن همراه'
    },
    {
        "data": "code_posti1",
        title: 'کد پستی'
    },
    ];
    // DataTable('#view_table', '/helpers/pre_internal_legal_subscribers.php', 'POST', cols, function(table) {
    DataTable5('#view_table', /*url*/ 'pre_internal_legal_subscribers', /*request(dont change)*/ 'datatable_request', /*request*/ 'pre_internal_legal_subscribers', /*filter*/ '', /*filter2*/ '', '', 'POST', cols, function (table) {
        /*===================++  hide first column ++=========================*/
        //table.column(0).visible(false);
        /*===================++  select table row ++=========================*/
        $('#view_table tbody').on('click', 'tr', function () {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            } else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });
        // $('#delete').click(function () {
        //     //shenase avalin soton dt mibashad
        //     let tr = $('#view_table tbody').find('tr.selected');
        //     let td = tr.find('td:first').text();
        //     Hard_Delete(td, 'pre_internal_legal_subscribers', function (data) {
        //         if (data) {
        //             table.ajax.reload();
        //         } else {
        //             alert('عملیات ناموفق');
        //         }
        //     });
        // });
    });

});