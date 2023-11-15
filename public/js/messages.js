$(document).ready(function() {
    //$(".custom_select").select2();
    // Initialize('messages', function(data) {
    //     if (data) {

    //         //has data
    //         var element = $('#ostan_id');
    //         if (element) {
    //             for (let i = 0; i < data.length; i++) {
    //                 element.append('<option value=' + data[i].id + '>' + data[i].name + '</option>')
    //             }
    //         }
    //     } else {
    //         //data az db gerefte nashod
    //         alert('درخواست ناموفق');
    //     }
    // });

    var cols = [
        {
        "data": "id",
        title: 'شناسه',
        },
        {
            "data": "message_subject",
            title: 'عنوان پیام'
        },
        {
            "data": "message",
            title: 'متن پیام',
        },
    ];
    let origin = window.location.origin;
    let pathname = window.location.pathname;
    pathname = pathname.split('/');
    var dt_url = '';
    if (pathname[0] != "") {
        dt_url = pathname[0];
    } else {
        dt_url = pathname[1];
    }
    //console.log(window.location.origin+'/'+dt_url+'/helpers/messages.php');
    //sahar/messages
    DataTable3('#view_table', /*path*/ 'messages', /*request(dont change)*/ 'datatable_request', /*request2*/ 'messages', 'POST', cols, function(table) {
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
            Hard_Delete(td, 'messages', function(data) {
                table.ajax.reload();
                if(check_isset_message(data)){
                    display_Predefiend_Messages(data);
                }
            });
        });
    });
    $('#edit').click(function() {
        let tr = $('#view_table tbody').find('tr.selected');
        let td = tr.find('td:first').text();
        Edit_Form('messages', td, function(data) {
            if (data) {
                $('#id').val(data[0]['id']);
                $('#message').val(data[0]['message']);
                $('#message_subject').val(data[0]['message_subject']);
            } else {
                alert('مشکل در انجام درخواست لطفا مجددا تلاش کنید.');
            }
            //$('.form-group').each(function(i) {

            //});

        });
    });


});