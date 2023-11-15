$(document).ready(function() {
    let cols3 = [
        {
            "data": "update_time",
            title: 'تاریخ'
        },
        {
            "data": "tozihat",
            title: 'شرح'
        },
        {
            "data": "bedehkar",
            title: 'بدهکار'
        },
        {
            "data": "bestankar",
            title: 'بستانکار'
        },
        {
            "data": "credit",
            title: 'مانده اعتبار'
        },
    ];
    DataTable5('#view_table_display', /*url*/ 'customer_credit_log', /*request(dont change)*/ 'datatable_request', /*request*/ 'credits_display', /*filter*/ '', /*filter2*/ '', '', 'POST', cols3, function(table) {
        // $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        //     var link = $(e.target).attr("href");
        //     if (link === '#bottom-justified-divided-tab2') {
        //         table.columns.adjust().draw();
        //     }
        // });
    });
});