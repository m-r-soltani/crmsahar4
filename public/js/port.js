$(document).ready(function() {
    $("form").submit(function(e) {
        ajaxForms(e,$(this));
    });
    let terminal            = $("#terminal");
    let shahr               = $("#shahr");
    let ostan               = $("#ostan");
    let markaze_mokhaberati = $("#markaze_mokhaberati");
    ostan.select2();
    shahr.select2();
    terminal.select2();
    markaze_mokhaberati.select2();
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
        ajaxRequest('GetCityByProvince', { 'ostanid': provinceid }, window.location.href.split('/').slice(-1)[0], function(result) {
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

    markaze_mokhaberati.on('change', function() {
        let markazid = $(this).val();
        Get_terminal_by_markazid(markazid, function(result) {
            terminal.empty();
            if(! check_isset_message(result)){
                appendOption(terminal, result, 'id', 'name');
            }else{
                display_Predefiend_Messages(result);
            }
        });
    });

    terminal.on('change', function() {
        //alert( $(this).val() );
        let terminal_id = $(this).val();
        // $('#view_table').DataTable().destroy();
        var cols = [{
                "data": "id",
                title: 'شناسه'
            },
            {
                "data": "terminal",
                title: 'ترمینال'
            },
            {
                "data": "etesal",
                title: 'اتصال'
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
                "data": "dslam",
                title: 'dslam'
            },
            {
                "data": "kart",
                title: 'کارت'
            },
            {
                "data": "port",
                title: 'پورت'
            },
            {
                "data": "adsl_vdsl",
                title: 'نوع'
            },
            {
                "data": "telephone",
                title: 'تلفن'
            },

            {
                "data": "status",
                title: 'وضعیت'
            },
        ];
        DataTable4('#view_table', /*path*/ 'port', /*request(dont change)*/ 'datatable_request', /*request2*/ 'port', terminal_id, 'POST', cols, function(table) {
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
                Hard_Delete(td, 'port', function(data) {
                    if (data) {
                        table.ajax.reload();
                    } else {
                        alert('عملیات ناموفق');
                    }
                });
            });
        });
        // DataTable2('#view_table', '/helpers/port.php', 'POST', cols, terminal_id, function(table) {
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
        //         Hard_Delete(td, 'port', function(data) {
        //             if (data) {
        //                 table.ajax.reload();
        //             } else {
        //                 alert('عملیات ناموفق');
        //             }
        //         });
        //     });
        // });
    });


    $('#edit').click(function() {
        let tr = $('#view_table tbody').find('tr.selected');
        let td = tr.find('td:first').text();
        Edit_Form('port', td, function(data) {
            // console.log(data);
            $('#id').val(data[0]['id']);
            $('#etesal').val(data[0]['etesal']);
            ostan.val(data[0]['ostan']);
            shahr.val(data[0]['shahr']);
            markaze_mokhaberati.val(data[0]['markaze_mokhaberati']);
            terminal.val(data[0]['terminal']);
            $('#etesal').val(data[0]['etesal']);
            $('#port').val(data[0]['port']);
            $('#radif').val(data[0]['radif']);
            $('#tighe').val(data[0]['tighe']);
            $('#kart').val(data[0]['kart']);
            $('#tighe').val(data[0]['tighe']);
            $('#dslam').val(data[0]['dslam']);
            $('#telephone').val(data[0]['telephone']);
            $('#adsl_vdsl').val(data[0]['adsl_vdsl']);
            $('#status').val(data[0]['status']);
            if(! check_isset_message(data)){

                
                
                // $('#terminal option[value="' + data[0]['terminal'] + '"]').attr('selected', 'selected');
                // $('#adsl_vdsl option[value="' + data[0]['adsl_vdsl'] + '"]').attr('selected', 'selected');
                // $('#status option[value="' + data[0]['status'] + '"]').attr('selected', 'selected');
            }else{
                display_Predefiend_Messages(data);
            }
        });
    });
});