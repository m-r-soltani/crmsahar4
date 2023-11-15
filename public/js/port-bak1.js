$(document).ready(function() {
    Get_all_Terminal(function(data) {
        if (data.length > 0) {
            //let provinceid = data[0]['id'];
            //has data
            var element = $('#terminal');
            if (element) {
                for (let i = 0; i < data.length; i++) {
                    element.append('<option value=' + data[i]['id'] + '>' + data[i]['markaz_name'] + '</option>');
                }
                var cols = [{
                        "data": "id",
                        title: 'شناسه'
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
            }
        } else {
            //data az db gerefte nashod
            alert('ترمینالی پیدا نشد لطفا مجددا تلاش کنید.');
        }
    });
    $('#terminal').on('change', function() {
        //alert( this.value );
        let terminal_id = this.value;
        $('#view_table').DataTable().destroy();
        var cols = [{
                "data": "id",
                title: 'شناسه'
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