$(document).ready(function() {
    $("form").submit(function(e) {
        ajaxForms(e, $(this));
    });
    //$(".custom_select").select2();
    DATEPICKER_YYYYMMDD('#tarikhe_tavalod');
    let s_s = $("#s_s");
    let telephone1 = $("#telephone1");
    let telephone2 = $("#telephone2");
    let telephone3 = $("#telephone3");
    let telephone_hamrah = $("#telephone_hamrah");
    let ostane_tavalod = $("#ostane_tavalod");
    let shahre_tavalod = $("#shahre_tavalod");
    let ostane_sokonat = $("#ostane_sokonat");
    let shahre_sokonat = $("#shahre_sokonat");
    let tel1_ostan = $("#tel1_ostan");
    let tel2_ostan = $("#tel2_ostan");
    let tel3_ostan = $("#tel3_ostan");
    let tel1_shahr = $("#tel1_shahr");
    let tel2_shahr = $("#tel2_shahr");
    let tel3_shahr = $("#tel3_shahr");
    let tel1_street = $("#tel1_street");
    let tel2_street = $("#tel2_street");
    let tel3_street = $("#tel3_street");
    let tel1_stree2 = $("#tel1_street2");
    let tel2_stree2 = $("#tel2_street2");
    let tel3_stree2 = $("#tel3_street2");
    let tel1_housenumber = $("#tel1_housenumber");
    let tel2_housenumber = $("#tel2_housenumber");
    let tel3_housenumber = $("#tel3_housenumber");
    let meliat = $("#meliat");
    let tabeiat = $("#tabeiat");
    let tarikhe_tavalod = $("#tarikhe_tavalod");
    let noe_shenase_hoviati = $("#noe_shenase_hoviati");
    let noedarkhast=("#noedarkhast");
    var provcit={};
    tel1_ostan.select2();
    tel2_ostan.select2();
    tel3_ostan.select2();
    tel1_shahr.select2();
    tel2_shahr.select2();
    tel3_shahr.select2();
    ostane_tavalod.select2();
    shahre_tavalod.select2();
    ostane_sokonat.select2();
    shahre_sokonat.select2();
    meliat.select2();
    tabeiat.select2();
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
    Initialize('get_countries', function(result) {
        for (let i = 0; i < result.length; i++) {
            meliat.append('<option value=' + result[i].id + '>' + result[i].name + '</option>');
            tabeiat.append('<option value=' + result[i].id + '>' + result[i].name + '</option>');
        }
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

    meliat.on('change', function() {
        ajaxRequest('checkisirani', $(this).val(), window.location.href.split('/').slice(-1)[0], function(result) {
            if (!check_isset_message(result)) {
                if (result) {
                    s_s.prop("required", "true");
                } else {
                    s_s.prop("required", "false");
                }
            } else {
                display_Predefiend_Messages(result);
            }
        });
    });
    //////////////////////__CONFIRM SUB/////////////////////////////
    $('#confirmsub').click(function() {
        
        let tr = $('#view_table tbody').find('tr.selected');
        let td = tr.find('td:first').text();
        ajaxRequest('confirmprerealsub', { 'subid': td }, window.location.href.split('/').slice(-1)[0], function(result) {
            if (check_isset_message(result)) {
                display_Predefiend_Messages(result);
            }
        });
    });
    //////////////////////___E D I T___///////////////////////////
    $('#edit').click(function() {
        let tr = $('#view_table tbody').find('tr.selected');
        let td = tr.find('td:first').text();
        Edit_Form('pre_internal_real_subscribers', td, function(data) {
            console.log(data);
            branch_id.empty();
            $.each(data[0]['branches_list'], function(i, item) {
                branch_id.append($('<option>', {
                    value: item.id,
                    text: Getor_String(item.name_sherkat, '---')
                }));
            });
            
            branch_id.val(data[0]['branch_id']);
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

            // tarikhe_tavalod.val(tabdile_tarikh_adad(data[0]['tarikhe_tavalod']));
            // tabdile miladi be shamsi+tabdile adade englisi be farsi
            let tt = data[0]['tarikhe_tavalod'].split("-");
            if (tt.length > 2) {
                let tt_res = gregorian_to_jalali(parseInt(tt[0]), parseInt(tt[1]), parseInt(tt[2]));
                tt_res[0] = tt_res[0].toString();
                tt_res[1] = tt_res[1].toString();
                tt_res[2] = tt_res[2].toString();
                data[0]['tarikhe_tavalod'] = tt_res[0].toPersinaDigit() + '/' + tt_res[1].toPersinaDigit() + '/' + tt_res[2].toPersinaDigit();
            }
            tarikhe_tavalod.val(data[0]['tarikhe_tavalod']);
            //tabdile miladi be shamsi+tabdile adade englisi be farsi
            $('#id').val(data[0]['id']);
            $('#name').val(data[0]['name']);
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

            $('#noe_moshtarak').val(data[0]['noe_moshtarak']);
            $('#f_name').val(data[0]['f_name']);
            $('#name_pedar').val(data[0]['name_pedar']);
            $('#meliat').val(data[0]['meliat']).change();
            $('#tabeiat').val(data[0]['tabeiat']).change();
            $('#national_code').val(data[0]['code_meli']);
            $('#s_s').val(data[0]['shomare_shenasname']);
            $('#tarikhe_tavalod').val(data[0]['tarikhe_tavalod']);

            // $('#ostane_tavalod option[value="' + data[0]["ostane_tavalod"] + '"]').attr('selected', 'selected');
            // $('#shahre_tavalod option[value="' + data[0]["shahre_tavalod"] + '"]').attr('selected', 'selected');

            // GetCityByProvince(data[0]['ostan_id'], function(res_city) {
            //     shahre_tavalod.empty();
            //     if (! check_isset_message(res_city)) {                    
            //         shahre_tavalod.val(data[0]['city_id']);
            //     }
            // });
            $('#telephone1').val(data[0]['telephone1']);
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
            $('#telephone2').val(data[0]['telephone2']);
            $('#telephone3').val(data[0]['telephone3']);
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
            $('#shoghl').val(data[0]['shoghl']);
            $('#moaref').val(data[0]['moaref']);
            $('#tozihat').val(data[0]['tozihat']);
            $('#tozihate_darkhast').val(data[0]['tozihate_darkhast']);
            $('#noedarkhast').val(data[0]['noedarkhast']);
            //aks
            if (data[0]['r_t_karte_meli'] && data[0]['r_t_karte_meli'] !== '') {
                $("#linkrtkartemeli").remove();
                $('#link_r_t_karte_meli').append("<a id ='linkrtkartemeli' target='_blank' href=" + window.location.origin + '/public/images/' + data[0]['r_t_karte_meli'] + ">مشاهده تصویر</a>");
            }
            if (data[0]['r_t_ghabze_telephone'] && data[0]['r_t_ghabze_telephone'] !== '') {
                $('#linkrtghabzetelephone').remove();
                $('#link_r_t_ghabze_telephone').append("<a id ='linkrtghabzetelephone' target='_blank' href=" + window.location.origin + '/public/images/' + data[0]['r_t_ghabze_telephone'] + ">مشاهده تصویر</a>");
            }
            if (data[0]['r_t_ejare_malekiat'] && data[0]['r_t_ejare_malekiat'] !== '') {
                $('#linkrtejaremalekiat').remove();
                $('#link_r_t_ejare_malekiat').append("<a id ='linkrtejaremalekiat' target='_blank' href=" + window.location.origin + '/public/images/' + data[0]['r_t_ejare_malekiat'] + ">مشاهده تصویر</a>");
            }
            if (data[0]['r_t_gharardad'] && data[0]['r_t_gharardad'] !== '') {
                $('#linkrtgharardad').remove();
                $('#link_r_t_gharardad').append("<a id ='linkrtgharardad' target='_blank' href=" + window.location.origin + '/public/images/' + data[0]['r_t_gharardad'] + ">مشاهده تصویر</a>");
            }
            if (data[0]['r_t_sayer'] && data[0]['r_t_sayer'] !== '') {
                $('#linkrt_sayer').remove();
                $('#link_r_t_sayer').append("<a id ='linkrt_sayer' target='_blank' href=" + window.location.origin + '/public/images/' + data[0]['r_t_sayer'] + ">مشاهده تصویر</a>");
            }
            //aks
            // $('#gorohe_moshtarak option[value="' + data[0]["gorohe_moshtarak"] + '"]').attr('selected', 'selected');
            $("#gorohe_moshtarak").val(data[0]['gorohe_moshtarak']);
            // $('#nahve_ashnai option[value="' + data[0]["nahve_ashnai"] + '"]').attr('selected', 'selected');
            $("#nahve_ashnai").val(data[0]['nahve_ashnai']);
            // $('#noe_shenase_hoviati option[value="' + data[0]["noe_shenase_hoviati"] + '"]').attr('selected', 'selected');
            $("#noe_shenase_hoviati").val(data[0]['noe_shenase_hoviati']);
            // $('#jensiat option[value="' + data[0]["jensiat"] + '"]').attr('selected', 'selected');
            $("#jensiat").val(data[0]['jensiat']);
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
            "data": "code_eshterak",
            title: 'کد اشتراک'
        },
        {
            "data": "code_meli",
            title: 'کد ملی'
        },
        {
            "data": "telephone_hamrah",
            title: 'تلفن همراه'
        },
        {
            "data": "telephone1",
            title: 'تلفن'
        },
        {
            "data": "code_posti1",
            title: 'کد پستی'
        },
        {
            "data": "shomare_shenasname",
            title: 'شماره شناسنامه'
        },

    ];
    //DataTable('#view_table', '/helpers/bnm_presubscribers.php', 'POST', cols, function(table) {
    DataTable5('#view_table', /*url*/ 'pre_internal_real_subscribers', /*request(dont change)*/ 'datatable_request', /*request*/ 'pre_internal_real_subscribers', /*filter*/ '', /*filter2*/ '', '', 'POST', cols, function(table) {
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
        // $('#delete').click(function() {
        //     //shenase avalin soton dt mibashad
        //     let tr = $('#view_table tbody').find('tr.selected');
        //     let td = tr.find('td:first').text();
        //     Hard_Delete(td, 'pre_real_subscribers', function(data) {
        //         if (data) {
        //             table.ajax.reload();
        //         } else {
        //             alert('عملیات ناموفق');
        //         }
        //     });
        // });
    });

});