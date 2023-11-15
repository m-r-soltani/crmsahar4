$(document).ready(function() {
    /*===================++  DATA_TABLE  ++=========================*/
    var cols = [
        {
            "data": "id",
            title: 'شناسه'
        },
        {
            "data": "name",
            title: 'نام کشور',
        }, {
            "data": "code",
            title: 'کد کشور',
        }
    ];

    DataTable3('#view_table', /*path*/ 'country', /*request(dont change)*/ 'datatable_request', /*request2*/ 'country', 'POST', cols, function(table) {
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
            Hard_Delete(td, 'countries', function(data) {
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
        Edit_Form('countries', td, function(data) {
            $('#id').val(data[0]['id']);
            $('#name').val(data[0]['name']);
            $('#code').val(data[0]['code']);
        });
    });


});