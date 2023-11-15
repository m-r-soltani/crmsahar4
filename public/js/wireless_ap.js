$(document).ready(function () {
    $("form").submit(function (e) {
        ajaxForms(e, $(this));
    });
    DATEPICKER_YYYYMMDD('#tarikhe_sabt');
    DATEPICKER_YYYYMMDD('#tarikhe_payan');
    let shahr = $("#shahr");
    shahr.select2();
    let ostan = $('#ostan');
    ostan.select2();
    let popsite = $('#popsite');
    popsite.select2();
    let marke_dastgah = $("#marke_dastgah");
    marke_dastgah.select2();
    let modele_dastgah = $("#modele_dastgah");
    modele_dastgah.select2();
    GetEquipmentsBrands('wireless_ap', function (result) {
        marke_dastgah.empty();
        modele_dastgah.empty();
        if (! check_isset_message(result)) {
            appendOption(marke_dastgah, result, 'id', 'name');
        } else {
            marke_dastgah.empty();
        }
    });

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

    shahr.on('change', function () {
        Get_Popsite_Bycity($(this).val(), function (result) {
            popsite.empty();
            if (!check_isset_message(result)) {
                appendOption(popsite, result, 'id', 'name');
            } else {
                popsite.empty();
            }
        });
    });

    marke_dastgah.on('change', function () {
        let brandid = $(this).val();
        modele_dastgah.empty();
        GetEquipmetsModelsByBrand(brandid, function (result2) {
            if (! check_isset_message(result2)) {
                appendOption(modele_dastgah, result2, 'id', 'name');
            } else {
                modele_dastgah.empty();
            }
        });
    });
    $('#edit').click(function () {
        let tr = $('#view_table tbody').find('tr.selected');
        let td = tr.find('td:first').text();
        Edit_Form('wireless_ap', td, function (data) {
            console.log(data);
            console.log(data[0]['ostan']);
            console.log(data[0]['shahr']);
            data[0]['tarikhe_sabt'] = tabdile_tarikh_adad(data[0]['tarikhe_sabt']);
            data[0]['tarikhe_payan'] = tabdile_tarikh_adad(data[0]['tarikhe_payan']);
            $('#id').val(data[0]['id']);
            $('#ertefae_dakal').val(data[0]['ertefae_dakal']);
            $('#tarikhe_sabt').val(data[0]['tarikhe_sabt']);
            $('#tarikhe_payan').val(data[0]['tarikhe_payan']);
            $('#shenase_dakal').val(data[0]['shenase_dakal']);
            $('#address').val(data[0]['address']);
            $('#link_name').val(data[0]['link_name']);
            $('#ertefae_sakhteman').val(data[0]['ertefae_sakhteman']);
            $('#tol_joghrafiai').val(data[0]['tol_joghrafiai']);
            $('#arz_joghrafiai').val(data[0]['arz_joghrafiai']);
            $('#bahre_anten').val(data[0]['bahre_anten']);
            $('#shomare_seriale_dastgah').val(data[0]['shomare_seriale_dastgah']);
            $('#hadeaxar_tavane_khoroji_ferestande').val(data[0]['hadeaxar_tavane_khoroji_ferestande']);

            ostan.val(data[0]['ostan']).change();
            // GetCityByProvince(data[0]['ostan'], function (result) {
                ajaxRequest('GetCityByProvince', { 'ostanid': data[0]['ostan'] }, window.location.href.split('/').slice(-1)[0], function(result) {
                shahr.empty();
                if (!check_isset_message(result)) {
                    appendOption(shahr, result, 'id', 'name');
                    shahr.val(data[0]['shahr']).change();
                    Get_Popsite_Bycity(data[0]['shahr'], function (result) {
                        popsite.empty();
                        if (!check_isset_message(result)) {
                            appendOption(popsite, result, 'id', 'name');
                            popsite.val(data[0]['popsite']).change();
                        } else {
                            popsite.empty();
                        }
                    });
                } else {
                    shahr.empty();
                }
            });
            marke_dastgah.val(data[0]['marke_dastgah']).change();
            GetEquipmetsModelsByBrand(data[0]['marke_dastgah'], function (result2) {
                modele_dastgah.empty();
                if (!check_isset_message(result2)) {
                    appendOption(modele_dastgah, result2, 'id', 'name');
                    modele_dastgah.val(data[0]['modele_dastgah']).change();
                } else {
                    modele_dastgah.empty();
                }
            });

            $('#ip_address').val(data[0]['ip_address']);
            $('#port').val(data[0]['port']);
            $('#username').val(data[0]['username']);
            $('#password').val(data[0]['password']);
            $('#ssid').val(data[0]['ssid']);
            $('#software').val(data[0]['software']);
            $("#teke_bande_ferekansi").val(data[0]['teke_bande_ferekansi']);
            $("#noe_link").val(data[0]['noe_link']);
            // shahr.val(data[0]['shahr']);
            // ostan.val(data[0]['ostan']);
            // popsite.val(data[0]['popsite']);
            // $('#teke_bande_ferekansi option[value="' + data[0]['teke_bande_ferekansi'] + '"]').attr('selected', 'selected');
            // $('#shahr option[value="' + data[0]['shahr'] + '"]').attr('selected', 'selected');
            // $('#ostan option[value="' + data[0]['ostan'] + '"]').attr('selected', 'selected');
            // $('#popsite option[value="' + data[0]['popsite'] + '"]').attr('selected', 'selected');
            // $('#noe_link option[value="' + data[0]['noe_link'] + '"]').attr('selected', 'selected');
        });
    });

    /*===================++  DATA_TABLE  ++=========================*/
    var cols = [{
        "data": "id",
        title: 'شناسه'
    },
    {
        "data": "tarikhe_sabt",
        title: 'تاریخ ثبت'
    },
    {
        "data": "link_name",
        title: 'نام لینک'
    },
    {
        "data": "popsite",
        title: 'نام دکل'
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
        "data": "ertefae_dakal",
        title: 'ارتفاع دکل'
    },


    ];
    DataTable3('#view_table', /*path*/ 'wireless_ap', /*request(dont change)*/ 'datatable_request', /*request2*/ 'wireless_ap', 'POST', cols, function (table) {
        // DataTable('#view_table', '/helpers/wireless_ap.php', 'POST', cols, function(table) {
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
        $('#delete').click(function () {
            //shenase avalin soton dt mibashad
            let tr = $('#view_table tbody').find('tr.selected');
            let td = tr.find('td:first').text();
            Hard_Delete(td, 'wireless_ap', function (data) {
                if (data) {
                    table.ajax.reload();
                } else {
                    alert('عملیات ناموفق');
                }
            });
        });
    });

});