$(document).ready(function() {
    var cols = [{
        "data": "id",
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
            "data": "telephone_hamrah",
            title: 'تلفن همراه'
        },
        {
            "data": "code",
            title: 'کد ارسال شده'
        },
        {
            "data": "tarikh",
            title: "تاریخ تایید قرارداد"
        },
        {
            "data": "service_type",
            title: "نوع قرارداد"
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
    //console.log(window.location.origin+'/'+dt_url+'/helpers/contracts_report_display.php');
    //sahar/contracts_report_display
    DataTable3('#view_table', /*path*/ 'contracts_report_display', /*request(dont change)*/ 'datatable_request', /*request2*/ 'contracts_report_display', 'POST', cols, function(table) {
        /*===================++  hide first column ++=========================*/
        //table.column(0).visible(false);
        /*===================++  select table row ++=========================*/
        // $('#view_table tbody').on('click', 'tr', function() {
        //     if ($(this).hasClass('selected')) {
        //         $(this).removeClass('selected');
        //     } else {
        //         table.$('tr.selected').removeClass('selected');
        //         $(this).addClass('selected');
        //     }
        // });
    });
});