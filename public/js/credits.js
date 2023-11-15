$(document).ready(function() {
    $("form").submit(function(e) {
        ajaxForms(e, $(this));
    });
    var credits_tabs = $("#credits_tabs");
    credits_tabs.hide();
    var user_id;
    var init_table = "<button name='initconfirm' class='btn btn-primary col-md-auto float-md-right' id='initconfirm'>جستجو<i class='icon-database-edit2 ml-2'></i></button><table id='view_table_search' class='table table-striped datatable-responsive table-hover'></table>";
    var lookingfor = $("#lookingfor");
    var init_search_table_div = $("#init_search_table_div");
    let change_amount=$("#change_amount");
    thousandCommaSep(change_amount);
    // charge_amount.keyup(function(){
    //     charge_amount_persian.text(charge_amount.val().num2persian()+" "+ "ریال");
    // });
    lookingfor.prop("selectedIndex", -1);
    //$('#view_table_search').ajax.reload();
    //view_table_search.DataTable().destroy();
    lookingfor.on('change', function() {
        credits_tabs.hide();
        user_id = '';
        init_search_table_div.empty();
        init_search_table_div.append(init_table);
        switch (lookingfor.val()) {
            case 'moshtarak':
                var cols1 = [
                    {
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
                DataTable4('#view_table_search', /*path*/ 'credits', /*request(dont change)*/ 'datatable_request', /*request*/ 'credits', /*request2*/ lookingfor.val(), 'POST', cols1, function(table) {

                    /*===================++  hide first column ++=========================*/
                    //table.column(0).visible(false);
                    /*===================++  select table row ++=========================*/
                    $('#view_table_search tbody').on('click', 'tr', function() {
                        if ($(this).hasClass('selected')) {
                            $(this).removeClass('selected');
                        } else {
                            table.$('tr.selected').removeClass('selected');
                            $(this).addClass('selected');
                        }
                    });
                    //ajax request with user_id and lookingfor.val()
                    $('#initconfirm').click(function() {
                        let tr = $('#view_table_search tbody').find('tr.selected');
                        let td = tr.find('td:first').text();
                        user_id = td;
                        if (user_id !== '') {
                            credits_tabs.show();
                            page_requests('credits', window.location.href, user_id, 'moshtarak', '', function(data) {
                                if (!data[0]['credit']) data[0]['credit'] = '0';
                                //if (!data[0]['change_amount']) data[0]['change_amount'] = '0';
                                if (!data[0]['tozihat']) data[0]['tozihat'] = '0';

                                if (!data['Error'] && !data['error']) {
                                    //$("#last_row_id").val(Getor_String(data[0]['last_row_id'], 'empty'));
                                    $("#user_id").val(Getor_String(data['sub_id'], 'empty'));
                                    $("#noe_user").val('1');
                                    $("#user_or_branch_name").val(Getor_String(data['name'] + ' ' + data['f_name'], 'ثبت نشده'));
                                    $("#current_credit").val(Getor_String(data[0]['credit'], '0'));
                                    //$("#change_amount").val(Getor_String(data[0]['change_amount'], '0'));
                                    //$("#tozihat").val(Getor_String(data[0]['tozihat'], ''));
                                    var cols3 = [{
                                            "data": "id",
                                            title: 'شناسه'
                                        },
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
                                    DataTable5('#view_table_display', /*url*/ 'credits', /*request(dont change)*/ 'datatable_request', /*request*/ 'credits_display', /*filter*/ 'moshtarak', /*filter2*/ Getor_String(data['sub_id'], 'empty'), '', 'POST', cols3, function(table) {
                                        // $('#view_table_display').ajax.reload();
                                        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                                            var link = $(e.target).attr("href");
                                            if (link === '#bottom-justified-divided-tab2') {
                                                table.columns.adjust().draw();
                                            }
                                        });
                                        //
                                        // /*===================++  select table row ++=========================*/
                                        // $('#view_table tbody').on('click', 'tr', function () {
                                        //     if ($(this).hasClass('selected')) {
                                        //         $(this).removeClass('selected');
                                        //     } else {
                                        //         table.$('tr.selected').removeClass('selected');
                                        //         $(this).addClass('selected');
                                        //     }
                                        // });
                                    });
                                } else {
                                    alert('مشکل در برنامه.');
                                }
                            });
                        } else {
                            alert("لطفا مشترک/نماینده مورد نظر را انتخاب کنید.");
                        }
                    });

                });
                break;
            case 'namayande':

                var cols2 = [{
                        "data": "id",
                        title: 'شناسه'
                    },
                    {
                        "data": "name_sherkat",
                        title: 'نام نمایندگی'
                    },
                ];
                DataTable4('#view_table_search', /*path*/ 'credits', /*request(dont change)*/ 'datatable_request', /*request*/ 'credits', /*request2*/ lookingfor.val(), 'POST', cols2, function(table) {

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
                    $('#initconfirm').click(function() {
                        let tr = $('#view_table_search tbody').find('tr.selected');
                        let td = tr.find('td:first').text();
                        user_id = td;
                        if (user_id !== '') {
                            credits_tabs.show();
                            page_requests('credits', window.location.href, user_id, 'namayande', '', function(data) {
                                if (!data['Error']) {
                                    //$("#last_row_id").val(Getor_String(data[0]['last_row_id'], 'empty'));
                                    $("#user_id").val(Getor_String(data['branch_id'], 'empty'));
                                    $("#noe_user").val('2');
                                    $("#user_or_branch_name").val(Getor_String(data['name_sherkat'], 'ثبت نشده'));
                                    $("#current_credit").val(Getor_String(data[0]['credit'], '0'));
                                    //$("#change_amount").val(Getor_String(data[0]['change_amount'], '0'));
                                    //$("#tozihat").val(Getor_String(data[0]['tozihat'], ''));
                                    var cols3 = [
                                        {
                                            "data": "id",
                                            title: 'شناسه'
                                        },
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
                                    DataTable5('#view_table_display', /*url*/ 'credits', /*request(dont change)*/ 'datatable_request', /*request*/ 'credits_display', /*filter*/ 'namayande', /*filter2*/ Getor_String(data['branch_id'], ''), '', 'POST', cols3, function(table) {
                                        //$('#view_table_search').ajax.reload();
                                        // $('#view_table_display').ajax.reload();
                                        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                                            var link = $(e.target).attr("href");
                                            if (link === '#bottom-justified-divided-tab2') {
                                                table.columns.adjust().draw();
                                            }
                                        });
                                        //
                                        // /*===================++  select table row ++=========================*/
                                        // $('#view_table tbody').on('click', 'tr', function () {
                                        //     if ($(this).hasClass('selected')) {
                                        //         $(this).removeClass('selected');
                                        //     } else {
                                        //         table.$('tr.selected').removeClass('selected');
                                        //         $(this).addClass('selected');
                                        //     }
                                        // });
                                    });
                                } else {
                                    alert(data['Error']);
                                }
                            });
                        } else {
                            alert("لطفا مشترک/نماینده مورد نظر را انتخاب کنید.");
                        }
                    });
                });
                break;

            default:
                alert('لطفا از انجام دوباره این کار خودداری کنید.');
                break;
        }
    });
    // $('form[name="taghire_etebar_form"]').submit(function(e) {
    //     e.preventDefault();
    //     var data = $(this).serializeArray();
    //     for (let i = 0; i < data.length; i++) {
    //         if (data[i]['name'] == "change_amount") {
    //             if (data[i]['value'] != "" && data[i]['value'] != 0 && data[i]['value'] != "0") {
    //                 $.ajax({
    //                     type: "post",
    //                     url: 'Credits',
    //                     timeout: 10000,
    //                     data: {
    //                         'send_taghire_etebar': data
    //                     },
    //                     success: function(response) {
    //                         response = JSON.parse(response);
    //                         console.log(response);
    //                         if (response['Error']) {
    //                             alert(response['Error']);
    //                         } else if (!response['Error']) {
    //                             alert('موجودی جدید = ' + response['new_credit']);
    //                         } else {
    //                             alert('مشکل در انجام درخواست');
    //                         }
    //                         //alert("درخواست انجام شد.");
    //                     },
    //                     error: function(req, res, status) {
    //                         alert('مشکل در انجام درخواست');
    //                     },
    //                     complete: function() {
    //                         ///////////////hameye onclick return false pak shavad
    //                     }
    //                 });
    //             } else {
    //                 alert('مقدار تغییر اعتبار نمیتواند 0 باشد');
    //             }
    //         }

    //     }
    // });

});