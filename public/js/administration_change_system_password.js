$(document).ready(function() {
    var user_id;
    let userid = $("#userid");
    let change_password_form = $("#change_password_form");
    change_password_form.hide();
    /*===================++  INITIALAIZE USERS DATA_TABLE  ++=========================*/
    // var init_datatable_cols = [{
    //         "data": "id",
    //         title: 'شناسه'
    //     },
    //     {
    //         "data": "name",
    //         title: 'نام'
    //     },
    //     {
    //         "data": "f_name",
    //         title: 'نام خانوادگی'
    //     },
    //     {
    //         "data": "name_sherkat",
    //         title: 'نام شرکت'
    //     },
    //     {
    //         "data": "telephone1",
    //         title: 'تلفن 1'
    //     },
    //     {
    //         "data": "telephone2",
    //         title: 'تلفن 2'
    //     },
    //     {
    //         "data": "telephone3",
    //         title: 'تلفن 3'
    //     },
    //     {
    //         "data": "telephone_hamrah",
    //         title: 'تلفن همراه'
    //     },
    //     {
    //         "data": "code_meli",
    //         title: 'کد ملی'
    //     }
    // ];
    // DataTable5('#view_table', /*url*/ 'factors', /*request(dont change)*/ 'datatable_request', /*request*/ 'factors_init', /*filter*/ '', /*filter2*/ '', /*filter3*/ '', 'POST', init_datatable_cols, function(table) {
    //     /*===================++  select table row ++=========================*/
    //     $('#view_table tbody').on('click', 'tr', function() {
    //         if ($(this).hasClass('selected')) {
    //             $(this).removeClass('selected');
    //         } else {
    //             table.$('tr.selected').removeClass('selected');
    //             $(this).addClass('selected');
    //         }
    //     });
    // });
    // $('#initconfirm').click(function() {
    //     let tr = $('#view_table tbody').find('tr.selected');
    //     let td = tr.find('td:first').text();
    //     user_id = td;
    //     console.log(user_id);
    //     if (user_id !== '') {
    //         userid.val(user_id);
    //         change_password_form.show();
    //     } else {
    //         Custom_Modal_Show('w', "لطفا مشترک مورد نظر را انتخاب کنید.");
    //     }
    // });
    $("form").submit(function(e) {
        ajaxForms(e, $(this));
    });
    var init_datatable_cols = [{
            "data": "id",
            title: 'شناسه'
        },
        {
            "data": "name",
            title: 'نام / نام شرکت'
        },
        {
            "data": "code_meli",
            title: 'کدملی/ شماره ثبت'
        },
        {
            "data": "telephone1",
            title: 'تلفن'
        },
        {
            "data": "telephone_hamrah",
            title: 'موبایل'
        },
        {
            "data": "noe_moshtarak",
            title: 'نوع مشترک'
        },

    ];
    DataTable5('#view_table', /*url*/ 'factors', /*request(dont change)*/ 'datatable_request', /*request*/ 'factors_init', /*filter*/ '', /*filter2*/ '', /*filter3*/ '', 'POST', init_datatable_cols,
        function(table) {
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
    ///confirm click for init table
    $('#initconfirm').click(function() {
        let tr = $('#view_table tbody').find('tr.selected');
        let td = tr.find('td:first').text();
        user_id = td;
        console.log(user_id);
        if (user_id !== '') {
            userid.val(user_id);
            change_password_form.show();
        } else {
            Custom_Modal_Show('w', "لطفا مشترک مورد نظر را انتخاب کنید.");
        }
    });

});