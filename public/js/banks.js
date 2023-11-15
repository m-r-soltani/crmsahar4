$(document).ready(function () {
    let cols = [
        {
            "data": "id",
            title: 'شناسه',
        },
        {
            "data": "name",
            title: 'نام'
        },
        // {
        //     "data": "count_content",
        //     title: 'تعداد رکورد'
        // }
    ];
    DataTable3('#view_table', /*path*/ 'banks', /*request(dont change)*/ 'datatable_request', /*request2*/ 'banks', 'POST', cols, function(table) {
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
            Hard_Delete(td, 'banks', function(data) {
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
        Edit_Form('banks', td, function(data) {
            if (data) {
                $('#id').val(data[0]['id']);
                $('#name').val(data[0]['name']);
                
            } else {
                alert('مشکل در انجام درخواست لطفا مجددا تلاش کنید.');
            }


            //$('.form-group').each(function(i) {

            //});

        });
    });
});
