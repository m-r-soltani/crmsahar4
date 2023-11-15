$(document).ready(function() {
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
            "data": "username",
            title: 'نام کاربری سرویس'
        },
        {
            "data": "download",
            title: 'دانلود'
        },
        {
            "data": "upload",
            title: 'آپلود'
        },
        {
            "data": "ping",
            title: 'پینگ'
        },
        {
            "data": "tarikh",
            title: 'تاریخ'
        },
    ];
    // let origin = window.location.origin;
    // let pathname = window.location.pathname;
    // pathname = pathname.split('/');
    // var dt_url = '';
    // if (pathname[0] != "") {
    // 	dt_url = pathname[0];
    // } else {
    // 	dt_url = pathname[1];
    // }
    //console.log(window.location.origin+'/'+dt_url+'/helpers/city.php');
    //sahar/city
    DataTable3('#view_table', /*path*/ 'speedtest_report', /*request(dont change)*/ 'datatable_request', /*request2*/ 'speedtest_report', 'POST', cols, function(table) {
        /*===================++  hide first column ++=========================*/
        //table.column(0).visible(false);
        /*===================++  select table row ++=========================*/
    });
});