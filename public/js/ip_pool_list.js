$(document).ready(function() {
    $("form").submit(function(e) {
        ajaxForms(e,$(this));
    });
    var cols = [
        {
            "data": "id",
            title: 'شناسه',
        },
        {
            "data": "name",
            title: 'نام',
        },
        {
            "data": "discription",
            title: 'توضیحات'
        }
    ];
    DataTable3('#view_table', /*path*/ 'ip_pool_list', /*request(dont change)*/ 'datatable_request', /*request2*/ 'ip_pool_list', 'POST', cols, function(table) {
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
            Hard_Delete(td, 'ip_pool_list', function(data) {
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
        Edit_Form('ip_pool_list', td, function(data) {
            if (data) {
                $('#id').val(data[0]['id']);
                $('#name').val(data[0]['name']);
                $('#discription').val(data[0]['discription']);
            } else {
                alert('مشکل در انجام درخواست لطفا مجددا تلاش کنید.');
            }
        });
    });


});