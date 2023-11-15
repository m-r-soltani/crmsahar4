$(document).ready(function () {
    // $("form").submit(function(e) {
    //     ajaxForms(e,$(this));
    // });
    let shahr = $("#shahr");
    let ostan = $("#ostan");
    let mizban = $("#mizban");
    let noe_gharardad = $("#noe_gharardad");
    ostan.select2();
    shahr.select2();
    mizban.select2();
    GetProvinces('1', function (result) {
        if (!check_isset_message(result)) {
            appendOption(ostan, result, 'id', 'name');
        } else {
            display_Predefiend_Messages(result);
        }
    });
    ostan.on('change', function () {
        // ajaxRequest('GetCityByProvince', )
        ajaxRequest('GetProvinces', { 'GetCityByProvince': ostan.val() }, window.location.href.split('/').slice(-1)[0], function(result) {
            appendOption(shahr, result, 'id', 'name');    
        });
        // GetCityByProvince($(this).val(), function (result) {
        //     shahr.empty();
        //     if (!check_isset_message(result)) {
        //         appendOption(shahr, result, 'id', 'name');
        //     } else {
        //         shahr.empty();
        //     }
        // });
    });

    //////////////////////////
    GetHost_BY_Gharardad('telecommunications_center', function (result) {
        if (!check_isset_message(result)) {
            mizban.empty();
            appendOption(mizban, result, 'id', 'name_service_dahande');
            if (result[0]['dsl_license'] === 'yes') {
                noe_gharardad.append('<option value="dsl_license">dsl_license</option>');
            }
            if (result[0]['dsl_bitstream'] === 'yes') {
                noe_gharardad.append('<option value="dsl_bitstream">dsl_bitstream</option>');
            }
        } else {
            mizban.empty();
        }
    });
    mizban.on('change', function () {
        Get_Mizban_Noe_Gharardad_BY_id($(this).val(), function (result) {
            if (!check_isset_message(result)) {
                noe_gharardad.empty();
                for (let i = 0; i < result.length; i++) {
                    if (result[0]['dsl_license'] === 'yes') {
                        noe_gharardad.append('<option value="dsl_license">dsl_license</option>');
                    }
                    if (result[0]['dsl_bitstream'] === 'yes') {
                        noe_gharardad.append('<option value="dsl_bitstream">dsl_bitstream</option>');
                    }
                }
            } else {
                noe_gharardad.empty();
            }
        });
    });
    $("#tedade_pish_shomare").on('keyup', function () {
        var selector = $("#before_pre_num");
        var pre_nums = $(".pre_nums");
        var pre_nums_label = $(".pre_nums_label")
        if (pre_nums.length > 0) {
            pre_nums.remove();
        }
        if (pre_nums_label.length > 0) {
            pre_nums_label.remove();
        }
        var tedad = $(this).val();
        tedad = parseInt(tedad);
        var element = [];
        for (let i = 1; i < tedad + 1; i++) {
            element[i] = '<label class="col-form-label col-lg-2 pre_nums_label">پیش شماره ' + i + '</label> ' +
                '<div class="col-lg-4 pre_nums">' +
                '<input type="text" value="" placeholder="' + i + '" class="form-control" name="pre_nums[]" id="num_' + i + '">' +
                '</div>';
        }
        for (let i = tedad; i >= 1; i--) {
            selector.after(element[i]);
        }
        $(".pre_nums_label").before('<br><br>');

    });
    /*===================++  DATA_TABLE  ++=========================*/
    var cols = [{
        "data": "id",
        title: 'شناسه'
    },
    {
        "data": "name",
        title: 'نام مرکز'
    },
    {
        "data": "pish_shomare_ostan",
        title: 'پیش شماره استان'
    },
    {
        "data": "shomare_tamas_markaz",
        title: 'شماره تماس مرکز'
    },
    {
        "data": "masire_avale_faktorha",
        title: 'مسیر اول فاکتورها'
    },
    {
        "data": "masire_dovome_faktorha",
        title: 'مسیر دوم فاکتورها'
    },
    {
        "data": "noe_gharardad",
        title: 'نوع قرارداد'
    }
    ];
    let origin = window.location.origin;
    let pathname = window.location.pathname;
    pathname = pathname.split('/');
    var dt_url = '';
    if (pathname[0] != "") {
        dt_url = pathname[0];
    } else {
        dt_url = pathname[1];
    }
    //console.log(window.location.origin+'/'+dt_url+'/helpers/city.php');
    //sahar/city
    DataTable3('#view_table', /*path*/ 'telecommunications_center', /*request(dont change)*/ 'datatable_request', /*request2*/ 'telecommunications_center', 'POST', cols, function(table) {
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
        $('#delete').click(function() {
            let tr = $('#view_table tbody').find('tr.selected');
            let td = tr.find('td:first').text();
            Hard_Delete(td, 'telecommunications_center', function(data) {
                if (data) {
                    table.ajax.reload();
                } else {
                    alert('عملیات ناموفق');
                }
            });
        });
    });
    $('#edit').click(function () {
        var selector = $("#before_pre_num");
        var pre_nums = $(".pre_nums");
        var pre_nums_label = $(".pre_nums_label");
        if (pre_nums.length > 0) {
            pre_nums.remove();

        }
        if (pre_nums_label.length > 0) {
            pre_nums_label.remove();
        }
        var tedad = $(this).val();
        tedad = parseInt(tedad);
        let tr = $('#view_table tbody').find('tr.selected');
        let td = tr.find('td:first').text();
        Edit_Form('telecommunications_center', td, function (data) {
            $('#id').val(data[0]['id']);
            $('#name').val(data[0]['name']);
            ajaxRequest('GetProvinces', { 'qwe': false }, window.location.href.split('/').slice(-1)[0], function(result) {
                appendOption(ostan, result, 'id', 'name', false, 'p', function(aaa) {
                    ostan.val(data[0]['ostan']);
                    ostan.change();
                    console.log(ostan.val());

                    // ajaxRequest('GetCityByProvince', { 'ostanid': ostan.val() }, window.location.href.split('/').slice(-1)[0], function(result) {
                    //     console.log(result);
                    //     appendOption(shahr, result, 'id', 'name', false, 'p', function(aaa) {
                    //         shahr.val(data[0]['shahr']);
                    //         shahr.change();
                    //     });
                    // });
                });
            });
                
            // $('#shahr').val(data[0]['shahr']);
            
            //$('#ostan option[value="'+data[0]['ostan_id']+'"]').attr('selected','selected');
            //$('#shahr option[value="'+data[0]['shahr_id']+'"]').attr('selected','selected');
            $('#pish_shomare_ostan').val(data[0]['pish_shomare_ostan']);
            $('#tedade_pish_shomare').val(data[0]['tedade_pish_shomare']);
            $('#shomare_tamas_mdf').val(data[0]['shomare_tamas_mdf']);
            $('#address').val(data[0]['address']);
            $('#masire_avale_faktorha').val(data[0]['masire_avale_faktorha']);
            $('#masire_dovome_faktorha').val(data[0]['masire_dovome_faktorha']);
            $('#mizban').val(data[0]['mizban']);
            $('#ip_ppoe_server').val(data[0]['ip_ppoe_server']);
            $('#user_ppoe_server').val(data[0]['user_ppoe_server']);
            $('#password_ppoe_server').val(data[0]['password_ppoe_server']);
            $('#snmp_ppoe_server').val(data[0]['snmp_ppoe_server']);

            $('#noe_gharadad option[value="' + data[0]['noe_gharadad'] + '"]').attr('selected', 'selected');


            //$('.form-group').each(function(i) {

            //});

        });
    });
});