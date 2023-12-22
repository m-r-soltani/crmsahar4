$(document).ready(function() {
    $("form").submit(function(e) {
        ajaxForms(e, $(this));
    });
    //$(".custom_select").select2();
    DATEPICKER_YYYYMMDD('#tarikhe_sabt');
    let baladasti_id= $("#baladasti_id");
    let noe_sherkat = $("#noe_sherkat");
    let ostan = $("#ostan");
    let shahr = $("#shahr");
    var provcit={};
    ostan.select2();
    shahr.select2();
    noe_sherkat.select2();
    baladasti_id.select2();
    Initialize('get_branches_list',function(result){
        baladasti_id.append(`<option value="0">سحر ارتباط</option>`);
        if(check_isset_message(result)){
            display_Predefiend_Messages(result);
        }else{
            if (baladasti_id) {
                for (let i = 0; i < result.length; i++) {
                    baladasti_id.append(`<option value="${result[i].id}">${result[i].name_sherkat}</option>`);
                }
            }
        }
    });
    Initialize('get_company_types',function(result){
        console.log(result);
        if(check_isset_message(result)){
            display_Predefiend_Messages(result);
        }else{
            if (noe_sherkat) {
                for (let i = 0; i < result.length; i++) {
                    noe_sherkat.append(`<option value="${result[i].id}">${result[i].noe_sherkat}</option>`);
                }
            }
        }
    });
    // ajaxRequest('confirmprebranch', { aa: false }, window.location.href.split('/').slice(-1)[0], function(result) {
    //     if(! check_isset_message(result)){
    //         provcit=result;
    //         appendOption(ostan, result, 'id', 'name');
    //     }
    // });
    ajaxRequest('GetProvincesAndCities', { aa: false }, window.location.href.split('/').slice(-1)[0], function(result) {
        if(! check_isset_message(result)){
            provcit=result;
            appendOption(ostan, result, 'id', 'name');
        }
    });
    ostan.on('change', function() {
        // GetCityByProvince($(this).val(), function(result) {
        shahr.empty();
        if(provcit){
            for (let i = 0; i < provcit.length; i++) {
                if($(this).val()==provcit[i]['id']){
                    appendOption(shahr, provcit[i]['cities'], 'id', 'name');
                }
            }
        }
    });
    // GetProvinces('1', function(result) {
    //     if(! check_isset_message(result)){
    //         appendOption(ostan, result, 'id', 'name');

    //     }else{
    //         display_Predefiend_Messages(result);
    //     }
    // });

    // ostan.on('change', function() {
    //     // GetCityByProvince($(this).val(), function(result) {
    //     ajaxRequest('GetCityByProvince', { 'ostanid': $(this).val() }, window.location.href.split('/').slice(-1)[0], function(result) {
    //         shahr.empty();
    //         if (! check_isset_message(result)) {
    //             appendOption(shahr, result, 'id', 'name');
    //         } else {
    //             shahr.empty();
    //         }
    //     });
    // });

    /*===================++  DATA_TABLE  ++=========================*/
    var cols = [{
            "data": "id",
            title: 'شناسه'
        },
        {
            "data": "name_sherkat",
            title: 'نام شرکت'
        },
        {
            "data": "shomare_sabt",
            title: 'شماره ثبت',
        },
        {
            "data": "telephone1",
            title: 'تلفن1'
        },
        {
            "data": "telephone2",
            title: 'تلفن2'
        },
        {
            "data": "name_sherkat",
            title: 'نام شرکت'
        },
        {
            "data": "address",
            title: 'آدرس'
        },
        {
            "data": "noe_sherkat",
            title: 'نوع شرکت'
        },

    ];
    DataTable3('#view_table', /*path*/ 'pre_internal_branch', /*request(dont change)*/ 'datatable_request', /*request2*/ 'pre_internal_branch', 'POST', cols, function(table) {
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
        //onclick log row data
        /*$('#view_table tbody').on( 'click', 'tr', function () {
            console.log( table.row( this ).data() );
        } );*/
        // $('#delete').click(function() {
        //     let tr = $('#view_table tbody').find('tr.selected');
        //     let td = tr.find('td:first').text();
        //     Hard_Delete(td, 'pre_internal_branch', function(data) {
        //         if (data) {
        //             table.ajax.reload();
        //         } else {
        //             alert('عملیات ناموفق');
        //         }
        //     });
        // });
    });
    // DataTable('#view_table', '/helpers/pre_internal_branch.php', 'POST', cols, function(table) {
    //     /*===================++  hide first column ++=========================*/
    //     //table.column(0).visible(false);
    //     /*===================++  select table row ++=========================*/
    //     $('#view_table tbody').on('click', 'tr', function() {
    //         if ($(this).hasClass('selected')) {
    //             $(this).removeClass('selected');
    //         } else {
    //             table.$('tr.selected').removeClass('selected');
    //             $(this).addClass('selected');
    //         }
    //     });
    //     $('#delete').click(function() {
    //         //shenase avalin soton dt mibashad
    //         let tr = $('#view_table tbody').find('tr.selected');
    //         let td = tr.find('td:first').text();
    //         Hard_Delete(td, 'pre_internal_branch', function(data) {
    //             if (data) {
    //                 table.ajax.reload();
    //             } else {
    //                 alert('عملیات ناموفق');
    //             }
    //         });
    //     });
    // });
    $('#edit').click(function() {
        let tr = $('#view_table tbody').find('tr.selected');
        let td = tr.find('td:first').text();
        Edit_Form('pre_internal_branch', td, function(data) {
            console.log(data);
            ostan.val(data[0]['ostan']).change();
            // GetCityByProvince(data[0]['ostan'], function(result) {
                ajaxRequest('GetCityByProvince', { 'ostanid': data[0]['ostan'] }, window.location.href.split('/').slice(-1)[0], function(result) {
                console.log(result);
                shahr.empty();
                if (! check_isset_message(result)) {
                    appendOption(shahr, result, 'id', 'name');
                    shahr.val(parseInt(data[0]['shahr'])).change();
                }else{
                    shahr.empty();
                }
            });

            data[0]['tarikhe_sabt']     = tabdile_tarikh_adad(data[0]['tarikhe_sabt']);
            $('#tarikhe_sabt').val(data[0]['tarikhe_sabt']);
            $('#noe_sherkat').val(data[0]['noe_sherkat']).change();
            $('#baladasti_id').val(data[0]['baladasti_id']).change();
            $('#id').val(data[0]['id']);
            $('#ostan').val(data[0]['ostan']);
            $('#noe_namayandegi').val(data[0]['noe_namayandegi']).change();
            $('#shahr').val(data[0]['shahr']);
            $('#name_sherkat').val(data[0]['name_sherkat']);
            $('#shomare_sabt').val(data[0]['shomare_sabt']);
            $('#shenase_meli').val(data[0]['shenase_meli']);
            $('#code_eghtesadi').val(data[0]['code_eghtesadi']);
            $('#website').val(data[0]['website']);
            $('#email').val(data[0]['email']);
            $('#telephone1').val(data[0]['telephone1']);
            $('#telephone2').val(data[0]['telephone2']);
            $('#dornegar').val(data[0]['dornegar']);
            $('#code_posti').val(data[0]['code_posti']);
            $('#address').val(data[0]['address']);
            $('#tozihate_darkhast').val(data[0]['tozihate_darkhast']);
            $('#noedarkhast').val(data[0]['noedarkhast']);
            //aks
            if (data[0]['t_logo'] && data[0]['t_logo'] !== '') {
                $("#linkt_logo").remove();
                $('#link_t_logo').append("<a id ='linkt_logo' target='_blank' href=" + window.location.origin + '/public/images/' + data[0]['t_logo'] + ">مشاهده تصویر</a>");
            }
            if (data[0]['t_mohiti'] && data[0]['t_mohiti'] !== '') {
                $("#linkt_mohiti").remove();
                $('#link_t_mohiti').append("<a id ='linkt_mohiti' target='_blank' href=" + window.location.origin + '/public/images/' + data[0]['t_mohiti'] + ">مشاهده تصویر</a>");
            }
            if (data[0]['t_tablo'] && data[0]['t_tablo'] !== '') {
                $("#linkt_tablo").remove();
                $('#link_t_tablo').append("<a id ='linkt_tablo' target='_blank' href=" + window.location.origin + '/public/images/' + data[0]['t_tablo'] + ">مشاهده تصویر</a>");
            }
            if (data[0]['t_code_eghtesadi'] && data[0]['t_code_eghtesadi'] !== '') {
                $("#linkt_code_eghtesadi").remove();
                $('#link_t_code_eghtesadi').append("<a id ='linkt_code_eghtesadi' target='_blank' href=" + window.location.origin + '/public/images/' + data[0]['t_code_eghtesadi'] + ">مشاهده تصویر</a>");
            }
            if (data[0]['t_rozname_tasis'] && data[0]['t_rozname_tasis'] !== '') {
                $("#linkt_rozname_tasis").remove();
                $('#link_t_rozname_tasis').append("<a id ='linkt_rozname_tasis' target='_blank' href=" + window.location.origin + '/public/images/' + data[0]['t_rozname_tasis'] + ">مشاهده تصویر</a>");
            }
            if (data[0]['t_shenase_meli'] && data[0]['t_shenase_meli'] !== '') {
                $("#linkt_shenase_meli").remove();
                $('#link_t_shenase_meli').append("<a id ='linkt_shenase_meli' target='_blank' href=" + window.location.origin + '/public/images/' + data[0]['t_shenase_meli'] + ">مشاهده تصویر</a>");
            }
            if (data[0]['t_akharin_taghirat'] && data[0]['t_akharin_taghirat'] !== '') {
                $("#linkt_akharin_taghirat").remove();
                $('#link_t_akharin_taghirat').append("<a id ='linkt_akharin_taghirat' target='_blank' href=" + window.location.origin + '/public/images/' + data[0]['t_akharin_taghirat'] + ">مشاهده تصویر</a>");
            }

        });
    });


});