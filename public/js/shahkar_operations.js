$(document).ready(function() {
    // $("form").submit(function(e) {
    //     ajaxFormsWithConfirm(e, $(this));
    // });
    $("form").submit(function(e) {
        ajaxFormsWithConfirm(e, $(this));
    });
    // ajaxRequest('getallservicestatuses', [], window.location.href.split('/').slice(-1)[0], function(result){
    //     console.log(result);
    //     if(check_isset_message(result)){
            
    //         appendOption();
    //     }
    // });
    var cols = [
        {
            "data": "shenase",
            title: 'شناسه',
        },
        {
            "data": "telephone",
            title: 'تلفن/ سرویس مشترک',
        },
        {
            "data": "comment",
            title: 'پیام دریافت شده'
        },
        {
            "data": "response",
            title: 'کد پیام'
        },
        {
            "data": "tarikh",
            title: 'تاریخ'
        },
        {
            "data": "requestid",
            title: 'شناسه درخواست'
        },
        {
            "data": "classifier",
            title: 'شماره کلاسه',
        },
    ];
    // let origin = window.location.origin;
    // let pathname = window.location.pathname;
    // pathname = pathname.split('/');
    // var dt_url = '';
    // if (pathname[0] != "") {
    //     dt_url = pathname[0];
    // } else {
    //     dt_url = pathname[1];
    // }
    DataTable3('#view_table', /*path*/ 'shahkar_operations', /*request(dont change)*/ 'datatable_request', /*request2*/ 'shahkar_operations', 'POST', cols, function(table) {
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
            Hard_Delete(td, 'shahkar_operations', function(data) {
                if (data) {
                    table.ajax.reload();
                } else {
                    alert('عملیات ناموفق');
                }
            });
        });
    });
});