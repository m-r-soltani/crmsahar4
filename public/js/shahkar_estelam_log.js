$(document).ready(function() {
    let cols = [

        {
            "data": "shenase",
            title: 'شناسه',
        },
        {
            "data": "name",
            title: 'نام',
        },
        {
            "data": "f_name",
            title: 'نام خانوادگی'
        },
        {
            "data": "code_meli",
            title: 'کد ملی / شناسه ملی'
        },
        {
            "data": "tarikh",
            title: 'تاریخ و ساعت درخواست'
        },
        {
            "data": "comment",
            title: 'پیغام دریافت شده'
        },
        {
            "data": "responsecodefarsi",
            title: 'نتیجه'
        },
        {
            "data": "response",
            title: 'کد'
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
    //console.log(window.location.origin+'/'+dt_url+'/helpers/shahkar_estelam_log.php');
    //sahar/shahkar_estelam_log
    DataTable3('#view_table', /*path*/ 'shahkar_estelam_log', /*request(dont change)*/ 'datatable_request', /*request2*/ 'shahkar_estelam_log', 'POST', cols, function(table) {
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