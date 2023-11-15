$(document).ready(function() {
    $("form").submit(function(e) {
        ajaxForms(e,$(this));
    });
    let ostan               = $("#ostan");
    let shahr               = $("#shahr");
    let markaze_mokhaberati = $("#markaze_mokhaberati");
    let noe_terminal        = $("#noe_terminal");
    let terminal            = $("#terminal");
    GetProvinces('popsite', function(result) {
        if(! check_isset_message(result)){
            appendOption(ostan, result, 'id', 'name');
        }else{
            display_Predefiend_Messages(result);
        }
    });

    ostan.on('change', function() {
        let provinceid = $(this).val();
        // GetCityByProvince(provinceid, function(result) {
        ajaxRequest('GetCityByProvince', { 'ostanid': $(this).val() }, window.location.href.split('/').slice(-1)[0], function(result) {
            shahr.empty();
            markaze_mokhaberati.empty();
            terminal.empty();
            if (! check_isset_message(result)) {
                appendOption(shahr, result, 'id', 'name');
            } else {
                shahr.empty();
            }
        });
    });

    shahr.on('change', function() {
        let shahrid = $(this).val();
        Get_Telecenter_Bycity(shahrid, function(result) {
            markaze_mokhaberati.empty();
            terminal.empty();
            if(! check_isset_message(result)){
                appendOption(markaze_mokhaberati, result, 'id', 'name');
            }else{
                display_Predefiend_Messages(result);
            }
        });
    });

    Get_Noe_Terminal('terminal', function(result) {
        if (! check_isset_message(result)) {
            noe_terminal.empty();
            if (noe_terminal) {
                for (let i = 0; i < result.length; i++) {
                    noe_terminal.append('<option value=' + result[i]['id'] + '>' + result[i]['esme_terminal'] + '</option>');
                }
            } else {
                noe_terminal.empty();
            }
        }
    });

    Get_Noe_terminal(function(result) {
        if (result.length > 0) {
            $('form').on('submit', function(e) {
                var shoroe_etesali = parseInt($("#shoroe_etesali").val());
                var noe_terminal = $("#noe_terminal").val();
                var tmp = '';
                var flag = false;
                if (shoroe_etesali % 2 === 0) {
                    tmp = 'zoj';
                } else {
                    tmp = 'fard';
                }
                for (var i = 0; i < result.length; i++) {
                    if (result[i]['id'] == noe_terminal) {
                        if (result[i]['tartibe_ranzhe'] === 'zoj' && tmp === 'zoj') {
                            flag = true;
                        } else if (result[i]['tartibe_ranzhe'] === 'fard' && tmp === 'fard') {
                            flag = true;
                        } else if (result[i]['tartibe_ranzhe'] === 'poshte_sare_ham') {
                            flag = true;
                        } else {
                            flag = false;
                        }
                    }
                }
                if (!flag) {
                    e.preventDefault();
                    alert("نوع ترمینال با شروع اتصالی همخانی ندارد لطفا پس از بررسی مجددا تلاش کنید.");
                }
            });
        } else {
            $('form').on('submit', function(e) {
                e.preventDefault();
                alert('نوع ترمینال پیدا نشد!');
            });
        }
    });



    /*===================++  DATA_TABLE  ++=========================*/
    var cols = [{
            "data": "id",
            title: 'شناسه ترمینال'
        },
        {
            "data": "tername",
            title: 'ترمینال'
        },
        {
            "data": "tcname",
            title: 'مرکز مخابراتی'
        },
        {
            "data": "radif",
            title: 'ردیف'
        },
        {
            "data": "tighe",
            title: 'تیغه'
        },
        {
            "data": "shoroe_etesali",
            title: 'شروع اتصال'
        },
    ];
    DataTable3('#view_table', /*path*/ 'terminal', /*request(dont change)*/ 'datatable_request', /*request2*/ 'terminal', 'POST', cols, function(table) {
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
            Hard_Delete(td, 'terminal', function(data) {
                if (data) {
                    table.ajax.reload();
                } else {
                    alert('عملیات ناموفق');
                }
            });
        });
    });
    // DataTable('#view_table', '/helpers/terminal.php', 'POST', cols, function(table) {
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
    //         Hard_Delete(td, 'terminal', function(data) {
    //             if (data) {
    //                 table.ajax.reload();
    //             } else {
    //                 alert('عملیات ناموفق');
    //             }
    //         });
    //     });
    // });
    // $('#edit').click(function() {
    //     let tr = $('#view_table tbody').find('tr.selected');
    //     let td = tr.find('td:first').text();
    //     Edit_Form('terminal', td, function(data) {
    //         $('#id').val(data[0]['id']);
    //         $('#radif').val(data[0]['radif']);
    //         $('#tighe').val(data[0]['tighe']);
    //         $('#shoroe_etesali').val(data[0]['shoroe_etesali']);

    //         // $('#markaze_mokhaberati').val(data[0]['markaze_mokhaberati']);
    //         // $('#noe_terminal').val(data[0]['noe_terminal']);
    //         // $('#ostan').val(data[0]['ostan']);
    //         // $('#shahr').val(data[0]['shahr']);

    //         $('#ostan option[value="' + data[0]['ostan'] + '"]').attr('selected', 'selected');
    //         $('#shahr option[value="' + data[0]['shahr'] + '"]').attr('selected', 'selected');
    //         $('#markaze_mokhaberati option[value="' + data[0]['markaze_mokhaberati'] + '"]').attr('selected', 'selected');
    //         $('#noe_terminal option[value="' + data[0]['noe_terminal'] + '"]').attr('selected', 'selected');


    //         //$('.form-group').each(function(i) {

    //         //});

    //     });
    // });
});