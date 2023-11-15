$(document).ready(function() {
    //$(".custom_select").select2();

    /*===================++  DATA_TABLE  ++=========================*/
    var cols = [{
            "data": "id",
            title: 'شناسه'
        },
        {
            "data": "esme_terminal",
            title: 'اسم ترمینال'
        },
        {
            "data": "tedade_port",
            title: 'تعداد پورت'
        },
        {
            "data": "tartibe_ranzhe",
            title: 'ترتیب رانژه'
        },
        {
            "data": "tedade_tighe",
            title: "تعداد تیغه"
        },
        {
            "data": "tedade_port_dar_har_tighe",
            title: "تعداد پورت در هر تیغه"
        }
    ];
    DataTable3('#view_table', /*path*/ 'noe_terminal', /*request(dont change)*/ 'datatable_request', /*request2*/ 'noe_terminal', 'POST', cols, function(table) {
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
            Hard_Delete(td, 'noe_terminal', function(data) {
                if (data) {
                    table.ajax.reload();
                } else {
                    alert('عملیات ناموفق');
                }
            });
        });
    });
    $('#edit').click(function() {
        let tr = $('#view_table tbody').find('tr.selected');
        let td = tr.find('td:first').text();
        Edit_Form('noe_terminal', td, function(data) {
            $('#id').val(data[0]['id']);
            $('#esme_terminal').val(data[0]['esme_terminal']);
            $('#tedade_port').val(data[0]['tedade_port']);
            $('#tartibe_ranzhe option[value="' + data[0]['tartibe_ranzhe'] + '"]').attr('selected', 'selected');
            $('#tedade_tighe').val(data[0]['tedade_tighe']);
            $('#tedade_port_dar_har_tighe').val(data[0]['tedade_port_dar_har_tighe']);



            //$('#shahr option[value="'+data[0]['shahr_id']+'"]').attr('selected','selected');


            //$('#ostan option[value="'+data[0]['ostan_id']+'"]').attr('selected','selected');


            //$('.form-group').each(function(i) {

            //});

        });
    });
});