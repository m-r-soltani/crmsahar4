$(document).ready(function() {
    $("form").submit(function(e) {
        ajaxForms(e,$(this));
    });
    let ostan = $('#ostan');
    let shahr = $("#shahr");
    ostan.select2();
    shahr.select2();
    
    GetProvinces('1', function (result) {
        if (!check_isset_message(result)) {
            appendOption(ostan, result, 'id', 'name');
        } else {
            display_Predefiend_Messages(result);
        }
    });

    ostan.on('change', function () {
        // GetCityByProvince($(this).val(), function (result) {
            ajaxRequest('GetCityByProvince', { 'ostanid': $(this).val() }, window.location.href.split('/').slice(-1)[0], function(result) {
            shahr.empty();
            if (!check_isset_message(result)) {
                appendOption(shahr, result, 'id', 'name');
            } else {
                shahr.empty();
            }
        });
    });
    $('#edit').click(function() {
        let tr = $('#view_table tbody').find('tr.selected');
        let td = tr.find('td:first').text();
        Edit_Form('popsite', td, function(data) {
            console.log(data);
            $('#id').val(data[0]['id']);
            $('#name_dakal').val(data[0]['name_dakal']);
            $('#address').val(data[0]['address']);
            $('#ertefa_sakhteman').val(data[0]['ertefa_sakhteman']);
            $('#ertefa_dakal').val(data[0]['ertefa_dakal']);
            $('#majmoe_ertefa').val(data[0]['majmoe_ertefa']);
            $('#tol_joghrafiai').val(data[0]['tol_joghrafiai']);
            $('#arz_joghrafiai').val(data[0]['arz_joghrafiai']);
            $('#shomare_sabt').val(data[0]['shomare_sabt']);
            $('#code_posti').val(data[0]['code_posti']);
            $('#maleke_dakal').val(data[0]['maleke_dakal']);
            $('#shomare_tamas_malek').val(data[0]['shomare_tamas_malek']);
            ////
            $('#mizbane_dakal').val(data[0]['mizbane_dakal']);
            $('#name_poshtiban').val(data[0]['name_poshtiban']);
            $('#family_poshtiban').val(data[0]['family_poshtiban']);
            $('#shoamre_tamas_poshtiban').val(data[0]['shoamre_tamas_poshtiban']);
            $('#masire_avale_faktorha').val(data[0]['masire_avale_faktorha']);
            $('#shomare_tamas_malek').val(data[0]['shomare_tamas_malek']);
            $('#ejare_mahiane_nasbe_anten_roye_dakal').val(data[0]['ejare_mahiane_nasbe_anten_roye_dakal']);
            ////////options
            $('#noe_dakal option[value="' + data[0]['noe_dakal'] + '"]').attr('selected', 'selected');
            $('#ostan option[value="' + data[0]['ostan'] + '"]').attr('selected', 'selected');
            $('#shahr option[value="' + data[0]['shahr'] + '"]').attr('selected', 'selected');
            $('#noe_malekiat option[value="' + data[0]['noe_malekiat'] + '"]').attr('selected', 'selected');
            $('#rotbe_dakal option[value="' + data[0]['rotbe_dakal'] + '"]').attr('selected', 'selected');
            $('#bime_dakal option[value="' + data[0]['bime_dakal'] + '"]').attr('selected', 'selected');
            $('#barghe_ezterari option[value="' + data[0]['barghe_ezterari'] + '"]').attr('selected', 'selected');
            $('#batrie_poshtiban option[value="' + data[0]['batrie_poshtiban'] + '"]').attr('selected', 'selected');
            $('#cheraghe_dakal option[value="' + data[0]['cheraghe_dakal'] + '"]').attr('selected', 'selected');
            $('#ert option[value="' + data[0]['ert'] + '"]').attr('selected', 'selected');
            $('#emkane_nasbe_anten option[value="' + data[0]['emkane_nasbe_anten'] + '"]').attr('selected', 'selected');
            $('#ejaze_dastresi_24_saate option[value="' + data[0]['ejaze_dastresi_24_saate'] + '"]').attr('selected', 'selected');

            ostan.val(data[0]['ostan']).change();
            // GetCityByProvince(data[0]['ostan'], function(result) {
                ajaxRequest('GetCityByProvince', { 'ostanid': data[0]['ostan'] }, window.location.href.split('/').slice(-1)[0], function(result) {
                shahr.empty();
                if (! check_isset_message(result)) {
                    appendOption(shahr, result, 'id', 'name');
                    shahr.val(data[0]['shahr']).change();
                }else{
                    shahr.empty();
                }
            });
            // if(data[0]['batrie_poshtiban']==="on") {
            //     $('#batrie_poshtiban').prop('checked', true);
            // }else{
            //     $('#batrie_poshtiban').prop('checked', false);
            // }


            //$('#ostan option[value="'+data[0]['ostan']+'"]').attr('selected','selected');


            //$('.form-group').each(function(i) {

            //});

        });
    });
    /*===================++  DATA_TABLE  ++=========================*/
    var cols = [{
        "data": "id",
        title: 'شناسه دکل'
    },
        {
            "data": "name_dakal",
            title: 'نام دکل'
        },
        {
            "data": "noe_dakal",
            title: 'نوع دکل',
        },
        {
            "data": "ertefa_dakal",
            title: 'ارتفاع دکل'
        },
        {
            "data": "tol_joghrafiai",
            title: 'طول جغرافیایی'
        },
        {
            "data": "arz_joghrafiai",
            title: 'عرض جغرافیایی'
        },
        {
            "data": "shomare_sabt",
            title: 'آدرس'
        },
        {
            "data": "maleke_dakal",
            title: 'مالک دکل'
        },
        {
            "data": "shomare_tamas_malek",
            title: 'شماره تماس مالک'
        },
        {
            "data": "name_poshtiban",
            title: 'نام پشتیبان'
        },
    ];
    DataTable('#view_table', '/helpers/popsite.php', 'POST', cols, function(table) {
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
            Hard_Delete(td, 'popsite', function(data) {
                if (data) {
                    table.ajax.reload();
                } else {
                    alert('عملیات ناموفق');
                }
            });
        });
    });


});