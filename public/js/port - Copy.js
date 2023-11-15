$(document).ready(function() {
    //first init
    let terminal            = $("#terminal");
    let shahr               = $("#shahr");
    let ostan               = $("#ostan");
    let markaze_mokhaberati = $("#markaze_mokhaberati");

    GetProvinces('popsite', function(data) {
        if(! check_isset_message(data)){
            appendOption(ostan,data,'id','name');
        }else{
            display_Predefiend_Messages(data);
        }
    });
    //////////////////on stan change
    ostan.on('change', function() {
        //alert( $(this).val() );
        let provinceid = $(this).val();
        GetCityByProvince(provinceid, function(result) {
            if (! check_isset_message(result)) {
                shahr.empty();
                appendOption(shahr,result,'id','name');
                Get_Telecenter_Bycity(result[0].id, function(result) {
                    if (! check_isset_message(result)) {
                        markaze_mokhaberati.empty();
                        appendOption(markaze_mokhaberati, result, 'id', 'name');
                        Get_terminal_by_markazid(result[0].id, function(result) {
                            if (! check_isset_message(result)) {
                                    terminal.empty();
                                    appendOption(terminal, result, 'id', 'name');
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
                                    DataTable2('#view_table', '/helpers/port.php', 'POST', cols, data[0].id, function(table) {
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
                                            Hard_Delete(td, 'port', function(data) {
                                                if (data) {
                                                    table.ajax.reload();
                                                } else {
                                                    alert('عملیات ناموفق');
                                                }
                                            });
                                        });
                                    });
                                
                            } else {
                                //data az db gerefte nashod
                                alert('ترمینالی پیدا نشد لطفا مجددا تلاش کنید.');
                            }
                        });
                    } else {
                        terminal.empty();
                    }
                });
            } else {
                shahr.empty();
            }
        });
    });
    $('#shahr').on('change', function() {
        //alert( $(this).val() );
        let provinceid = $("#ostan").val();
        let shahrid = $(this).val();
        Get_Telecenter_Bycity(shahrid, function(result) {
            if(! check_isset_message(result)){
                appendOption(markaze_mokhaberati, result, 'id', 'name');
            }else{
                display_Predefiend_Messages(result);
            }
        });
    });
    
    $('#terminal').on('change', function() {
        //alert( $(this).val() );
        let terminal_id = $(this).val();
        $('#view_table').DataTable().destroy();
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
        DataTable2('#view_table', '/helpers/port.php', 'POST', cols, terminal_id, function(table) {
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
                Hard_Delete(td, 'port', function(data) {
                    if (data) {
                        table.ajax.reload();
                    } else {
                        alert('عملیات ناموفق');
                    }
                });
            });
        });

    });


    $('#edit').click(function() {
        let tr = $('#view_table tbody').find('tr.selected');
        let td = tr.find('td:first').text();
        Edit_Form('port', td, function(data) {
            $('#id').val(data[0]['id']);
            $('#etesal').val(data[0]['etesal']);
            $('#port').val(data[0]['port']);
            $('#radif').val(data[0]['radif']);
            $('#tighe').val(data[0]['tighe']);
            $('#kart').val(data[0]['kart']);
            $('#tighe').val(data[0]['tighe']);
            $('#dslam').val(data[0]['dslam']);
            $('#telephone').val(data[0]['telephone']);

            $('#terminal option[value="' + data[0]['terminal'] + '"]').attr('selected', 'selected');
            $('#adsl_vdsl option[value="' + data[0]['adsl_vdsl'] + '"]').attr('selected', 'selected');
            $('#status option[value="' + data[0]['status'] + '"]').attr('selected', 'selected');
        });
    });
});