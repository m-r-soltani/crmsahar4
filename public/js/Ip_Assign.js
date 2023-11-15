$(document).ready(function() {
    $("form").submit(function(e) {
        ajaxForms(e, $(this));
    });
    let bw_ippool = $("#bw_ippool");
    let av_ippool = $("#av_ippool");
    let w_ippool = $("#w_ippool");
    let t_ippool = $("#t_ippool");
    bw_ippool.select2();
    av_ippool.select2();
    w_ippool.select2();
    t_ippool.select2();
    let bw_ip = $("#bw_ip");
    let av_ip = $("#av_ip");
    let w_ip = $("#w_ip");
    let t_ip = $("#t_ip");
    bw_ip.select2();
    av_ip.select2();
    w_ip.select2();
    t_ip.select2();
    let bw_sub = $("#bw_sub");
    bw_sub.select2();
    let av_service = $("#av_service");
    let w_service = $("#w_service");
    let t_service = $("#t_service");
    av_service.select2();
    w_service.select2();
    t_service.select2();
    let bw_tarikhe_shoroe_ip = $("#bw_tarikhe_shoroe_ip");
    let av_tarikhe_shoroe_ip = $("#av_tarikhe_shoroe_ip");
    let w_tarikhe_shoroe_ip = $("#w_tarikhe_shoroe_ip");
    let t_tarikhe_shoroe_ip = $("#t_tarikhe_shoroe_ip");
    DATEPICKER_YYYYMMDD(bw_tarikhe_shoroe_ip);
    DATEPICKER_YYYYMMDD(av_tarikhe_shoroe_ip);
    DATEPICKER_YYYYMMDD(w_tarikhe_shoroe_ip);
    DATEPICKER_YYYYMMDD(t_tarikhe_shoroe_ip);
    let bw_tarikhe_payane_ip = $("#bw_tarikhe_payane_ip");
    let av_tarikhe_payane_ip = $("#av_tarikhe_payane_ip");
    let w_tarikhe_payane_ip = $("#w_tarikhe_payane_ip");
    let t_tarikhe_payane_ip = $("#t_tarikhe_payane_ip");
    DATEPICKER_YYYYMMDD(bw_tarikhe_payane_ip);
    DATEPICKER_YYYYMMDD(av_tarikhe_payane_ip);
    DATEPICKER_YYYYMMDD(w_tarikhe_payane_ip);
    DATEPICKER_YYYYMMDD(t_tarikhe_payane_ip);
    let bw_tarikhe_talighe_ip = $("#bw_tarikhe_talighe_ip");
    let av_tarikhe_talighe_ip = $("#av_tarikhe_talighe_ip");
    let w_tarikhe_talighe_ip = $("#w_tarikhe_talighe_ip");
    let t_tarikhe_talighe_ip = $("#t_tarikhe_talighe_ip");
    DATEPICKER_YYYYMMDD(bw_tarikhe_talighe_ip);
    DATEPICKER_YYYYMMDD(av_tarikhe_talighe_ip);
    DATEPICKER_YYYYMMDD(w_tarikhe_talighe_ip);
    DATEPICKER_YYYYMMDD(t_tarikhe_talighe_ip);
    let bw_tarikhe_shoroe_service = $("#bw_tarikhe_shoroe_service");
    let bw_tarikhe_payane_service = $("#bw_tarikhe_payane_service");  
    DATEPICKER_YYYYMMDD(bw_tarikhe_shoroe_service);
    DATEPICKER_YYYYMMDD(bw_tarikhe_payane_service);
    /////BandWidth/////
    ajaxRequest('get_all_ippools', { 'aa': 1 }, thisPage(), function(result) {
        if(result['Warning']) console.log(1);
        bw_ippool.empty();
        av_ippool.empty();
        w_ippool.empty();
        t_ippool.empty();
        if (check_isset_message(result)) {
            display_Predefiend_Messages(result);
        } else {
            console.log(22);
            appendOption(bw_ippool, result, 'id', 'name', 'discription');
            appendOption(av_ippool, result, 'id', 'name', 'discription');
            appendOption(w_ippool, result, 'id', 'name', 'discription');
            appendOption(t_ippool, result, 'id', 'name', 'discription');
        }
    });
    bw_ippool.on('change', function() {
        ajaxRequest('get_ips_by_poolid', { 'poolid': $(this).val() }, thisPage(), function(result) {
            bw_ip.empty();
            if (check_isset_message(result)) {
                display_Predefiend_Messages(result);
            } else {
                appendOption(bw_ip, result, 'id', 'ip', 'iptype');
            }
        });
    });
    av_ippool.on('change', function() {
        ajaxRequest('get_ips_by_poolid', { 'poolid': $(this).val() }, thisPage(), function(result) {
            av_ip.empty();
            if (check_isset_message(result)) {
                display_Predefiend_Messages(result);
            } else {
                appendOption(av_ip, result, 'id', 'ip', 'iptype');
            }
        });
    });
    w_ippool.on('change', function() {
        ajaxRequest('get_ips_by_poolid', { 'poolid': $(this).val() }, thisPage(), function(result) {
            w_ip.empty();
            if (check_isset_message(result)) {
                display_Predefiend_Messages(result);
            } else {
                appendOption(w_ip, result, 'id', 'ip', 'iptype');
            }
        });
    });
    t_ippool.on('change', function() {
        ajaxRequest('get_ips_by_poolid', { 'poolid': $(this).val() }, thisPage(), function(result) {
            t_ip.empty();
            if (check_isset_message(result)) {
                display_Predefiend_Messages(result);
            } else {
                appendOption(t_ip, result, 'id', 'ip', 'iptype');
            }
        });
    });
    ajaxRequest('getallsubscribers', { 'aa': 1 }, thisPage(), function(result) {
        bw_sub.empty();
        if (check_isset_message(result)) {
            display_Predefiend_Messages(result);
        } else {
            appendOption(bw_sub, result, 'id', 'name', 'telephone1');
        }
    });
    /////BandWidth/////
    //ADSL-VDSL///
    ajaxRequest('getServicesInfoWithMultipleServiceTypes', { 'sertypes':{'0': 'adsl', '1':'vdsl', '2':'bitstream'} }, thisPage(), function(result) {
        if (check_isset_message(result)) {
            // display_Predefiend_Messages(result);
        } else {
            // appendOption(av_service, result, 'id', 'name', 'telephone1');
            $.each(result, function(i, item) {
                av_service.append($('<option>', {
                    value: item.fid,
                    text: Getor_String(item.reallegal_name, '---') + ' / ' + ' ' + Getor_String(item.sertype, '---') + ' / ' + 'username: ' + ' ' + Getor_String(item.ibsusername, '---') + ' / ' + ' تلفن: ' + Getor_String(item.telephone1, '---')
                }));
            });
        }
    });
    ajaxRequest('getServicesInfoWithMultipleServiceTypes', { 'sertypes':{'0': 'wireless'} }, thisPage(), function(result) {
        if (check_isset_message(result)) {
            // display_Predefiend_Messages(result);
        } else {
            // appendOption(av_service, result, 'id', 'name', 'telephone1');
            $.each(result, function(i, item) {
                w_service.append($('<option>', {
                    value: item.fid,
                    text: Getor_String(item.reallegal_name, '---') + ' / ' + ' ' + Getor_String(item.sertype, '---') + ' / ' + 'username: ' + ' ' + Getor_String(item.ibsusername, '---') + ' / ' + ' تلفن: ' + Getor_String(item.telephone1, '---')
                }));
            });
        }
    });
    
    ajaxRequest('getServicesInfoWithMultipleServiceTypes', { 'sertypes':{'0': 'tdlte'} }, thisPage(), function(result) {
        if (check_isset_message(result)) {
            // display_Predefiend_Messages(result);
        } else {
            // appendOption(av_service, result, 'id', 'name', 'telephone1');
            $.each(result, function(i, item) {
                w_service.append($('<option>', {
                    value: item.fid,
                    text: Getor_String(item.reallegal_name, '---') + ' / ' + ' ' + Getor_String(item.sertype, '---') + ' / ' + 'username: ' + ' ' + Getor_String(item.ibsusername, '---') + ' / ' + ' تلفن: ' + Getor_String(item.telephone1, '---')
                }));
            });
        }
    });
    

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
            title: 'مشترک',
        },
        {
            "data": "telephone",
            title: 'تلفن'
        },
        {
            "data": "servicetype",
            title: 'سرویس'
        },
        {
            "data": "ip",
            title: 'IP'
        },
        {
            "data": "bandwidth",
            title: "پهنای باند"
        },
        {
            "data": "tarikhe_shoroe_ip",
            title: 'تاریخ شروع اختصاص'
        },
        {
            "data": "tarikhe_payane_ip",
            title: 'تاریخ پایان اختصاص'
        },
        {
            "data": "poolname",
            title: "Pool"
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
    DataTable3('#view_table', /*path*/ 'ip_assign', /*request(dont change)*/ 'datatable_request', /*request2*/ 'ip_assign', 'POST', cols, function(table) {
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
    $('#delete').click(function() {
        let tr = $('#view_table tbody').find('tr.selected');
        let td = tr.find('td:first').text();
        Hard_Delete(td, 'ip_assign', function(data) {
            if (data) {
                table.ajax.reload();
            } else {
                alert('عملیات ناموفق');
            }
        });
    });
    $('#edit').click(function() {
        let tr = $('#view_table tbody').find('tr.selected');
        let td = tr.find('td:first').text();
        Edit_Form('ip_assign', td, function(data) {
            if (data) {
                $('#id').val(data[0]['id']);
                $('#name').val(data[0]['name']);
                $('#ostan_id option[value="' + data[0]['ostan_id'] + '"]').attr('selected', 'selected');
            } else {
                alert('مشکل در انجام درخواست لطفا مجددا تلاش کنید.');
            }

        });
    });


});