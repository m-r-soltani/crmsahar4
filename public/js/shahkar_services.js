$(document).ready(function() {
    let cols = [
        {
            "data": "shenase_shahkar",
            title: "شناسه",
        },
        {
            "data": "shenase_factor",
            title: "شماره فاکتور",
        },
        {
            "data": "name",
            title: 'نام و نام خانوادگی',
        },
        {
            "data": "telephone",
            title: 'تلفن مشترک'
        },
        {
            "data": "response",
            title: 'کد پاسخ دریافت شده'
        },
        {
            "data": "comment",
            title: 'پیغام دریافت شده'
        },

        {
            "data": "tarikh",
            title: 'تاریخ و ساعت درخواست'
        },
        {
            "data": "classifier",
            title: 'شماره کلاسه'
        },
        {
            "data": "responseid",
            title: 'شناسه شاهکار'
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
    //console.log(window.location.origin+'/'+dt_url+'/helpers/shahkar_services.php');
    //sahar/shahkar_services
    DataTable3('#view_table', /*path*/ 'shahkar_services', /*request(dont change)*/ 'datatable_request', /*request2*/ 'shahkar_services', 'POST', cols, function(table) {
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
    });
});