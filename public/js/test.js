$(document).ready(function() {
    $("form").submit(function(e) {
        ajaxForms(e,$(this));
    });

    let text    = "Howareyou/rdoing/rtoday?";
    let arr = text.split("&^");
    console.log(arr);
    /*===================++  DATA_TABLE  ++=========================*/
    // var ostan={
    //     findostan:function (data) {
    //         return 'asd';
    //     }
    // };
    var cols = [{
        "data": "id",
        title: 'شناسه',
    },
        {
            "data": "name",
            title: 'نام',
        },
        {
            "data": "lname",
            title: 'نام خانوادگی'
        },
        {
            "data": "fathername",
            title: 'نام پدر'
        },
        {
            "data": "ncode",
            title: 'کد ملی'
        },
        {
            "data": "tel",
            title: 'تلفن'
        },
        {
            "data": "mobile",
            title: 'موبایل'
        },
        {
            "data": "birth",
            title: 'تاریخ تولد'
        },
        {
            "data": "pin",
            title: 'پین'
        },
        {
            "data": "noe_moshtarak",
            title: 'حقیقی / حقوقی'
        },
        {
            "data": "address",
            title: 'آدرس'
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
    //console.log(window.location.origin+'/'+dt_url+'/helpers/test.php');
    //sahar/test
    DataTable3('#view_table', /*path*/ 'test', /*request(dont change)*/ 'datatable_request', /*request2*/ 'test', 'POST', cols, function(table) {
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
            Hard_Delete(td, 'test', function(data) {
                if (data) {
                    table.ajax.reload();
                } else {
                    alert('عملیات ناموفق');
                }
            });
        });
    });
});