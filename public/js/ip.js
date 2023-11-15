$(document).ready(function() {
    let pool = $("#pool")
    let subnet  = $("#subnet")
    $("form").submit(function(e) {
        ajaxForms(e,$(this));
    });
    Initialize('ip',function(data){
        for (let i = 0; i < data.length; i++) {
            pool.append('<option value=' + data[i].id + '>' + data[i].name + '</option>');
        }
    });
    Initialize('getsubnet',function(data){
        for (let i = 0; i < data.length; i++) {
            subnet.append('<option value=' + data[i].id + '>' + data[i].subnet +' '+ '('+data[i].subnet_value+')' + '</option>');
        }
    });
    var cols = [
        {
            "data": "id",
            title: 'شناسه',
        },
        {
            "data": "ip",
            title: 'IP',
            
        },
        {
            "data": "gender",
            title: 'Gender',
        },
        {
            "data": "iptype",
            title: 'iptype',
        },
        {
            "data": "pool",
            title: 'Pool',
        },



    ];
    DataTable3('#view_table', /*path*/ 'ip', /*request(dont change)*/ 'datatable_request', /*request2*/ 'ip', 'POST', cols, function(table) {
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
            Hard_Delete(td, 'ip', function(data) {
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
        Edit_Form('ip', td, function(data) {
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