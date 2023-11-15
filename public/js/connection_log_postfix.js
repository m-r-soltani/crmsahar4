$(document).ready(function() {
    /*===================++  DATA_TABLE  ++=========================*/
    var cols = [{
            "data": "id",
            title: 'شناسه'
        },
        {
            "data": "name",
            title: 'نام استان',
        },
        {
            "data": "postfix",
            title: 'پیش شماره استان',
        }
    ];

    DataTable3('#view_table', 'connection_log_postfix', 'datatable_request', 'connection_log_postfix', 'POST', cols, function(table) {
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
            let tr = $('#view_table tbody').find('tr.selected');
            let td = tr.find('td:first').text();
            Hard_Delete(td, 'connection_log_postfix', function(data) {
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
        Edit_Form('connection_log_postfix', td, function(data) {
            $('#id').val(data[0]['id']);
            $('#name').val(data[0]['name']);
            $('#postfix').val(data[0]['postfix']);


            //$('.form-group').each(function(i) {

            //});

        });
    });


});