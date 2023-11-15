$(document).ready(function() {
    let cols = [
        {
            "data": "id",
            title: 'شناسه'
        },
        {
            "data": "name",
            title: 'نام ',
        }
    ];

    DataTable3('#view_table', /*path*/ 'equipments_brands', /*request(dont change)*/ 'datatable_request', /*request2*/ 'equipments_brands', 'POST', cols, function(table) {

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
            Hard_Delete(td, 'equipments_brands', function(data) {
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
        Edit_Form('equipments_brands', td, function(data) {
            if(check_isset_message(data)){
                display_Predefiend_Messages(data);
            }else{
            $('#id').val(data[0]['id']);
            $('#name').val(data[0]['name']);
            }
        });
    });
});