$(document).ready(function() {
    //////////////////////////submit all forms/////////////////////////////////
    $("form").submit(function(e) {
        ajaxForms(e, $(this));
    });
    let bs_tabs = $('a[data-toggle="tab"]');
    let emdrbm_res_id = $("#emdrbm_res_id");
    let devvv_res_id = $("#devvv_res_id");
    let enbtp_res_id = $("#enbtp_res_id");
    let edr_reserve_id = $("#edr_reserve_id");
    
    emdrbm_res_id.select2();
    devvv_res_id.select2();
    enbtp_res_id.select2();
    edr_reserve_id.select2();
    
    
    ////////////////////////////////eses////////////////////////////////
    let rm_reserve_type = $("#rm_reserve_type");
    rm_reserve_type.prop("selectedIndex", -1);
    let eses_markaze_mokhaberati = $("#eses_markaze_mokhaberati");
    let rm_markaze_mokhaberati = $("#rm_markaze_mokhaberati");
    eses_markaze_mokhaberati.select2();
    rm_markaze_mokhaberati.select2();
    

    ////////////////////////////////jm & dsmdoss////////////////////////////////
    let dsmdoss_oss_id = $("#dsmdoss_oss_id");
    let jm_telephone = $("#jm_telephone");
    // let jm_oss_registred_id = $("#jm_oss_registred_id");
    let jm_userservice= $("#jm_userservice");
    dsmdoss_oss_id.select2();
    // jm_oss_registred_id.select2();
    jm_telephone.select2();
    jm_userservice.select2();
    ajaxRequest('getServicesInfoWithServiceType', { 'sertype': 'bitstream' }, window.location.href.split('/').slice(-1)[0], function(result) {
        if(result){
            if(! check_isset_message(result)){
                $.each(result, function(i, item) {
                    jm_userservice.append($('<option>', {
                        value: item.emkanat_id,
                        text: Getor_String(item.reallegal_name, '---') + ' ' + Getor_String(item.general_sertype, '---') + ' ' + 'username: ' + ' ' + Getor_String(item.ibsusername, '---')
                    }));
                });

            }
        }
    });
    Initialize('bs_getosssubscribers', function(data) {
        console.log(222);
        console.log(data);
        console.log(222);
        if (!check_isset_message(data)) {
            let tmp = "";
            for (let i = 0; i < data.length; i++) {
                tmp += `<option value="${data[i]['id']}">${data[i]['name']+' '+ data[i]['f_name']} ${data[i]['telephone']}</option>`;
            }
            // jm_oss_registred_id.append(tmp);
            // jm_oss_registred_id.prop("selectedIndex", -1);
            dsmdoss_oss_id.append(tmp);
            dsmdoss_oss_id.prop("selectedIndex", -1);

            emdrbm_res_id.append(tmp);
            emdrbm_res_id.prop("selectedIndex", -1);

            devvv_res_id.append(tmp);
            devvv_res_id.prop("selectedIndex", -1);
            
            enbtp_res_id.append(tmp);
            enbtp_res_id.prop("selectedIndex", -1);
            
            edr_reserve_id.append(tmp);
            edr_reserve_id.prop("selectedIndex", -1);

                //emdrbm_res_id
                // devvv_res_id
                // enbtp_res_id
                // edr_reserve_id
                // $.each(result, function(i, item) {
                //     emdrbm_res_id.append($('<option>', {
                //         value: item.emkanat_id,
                //         text: Getor_String(item.reallegal_name, '---')+ ' ' + Getor_String(item.general_sertype, '---')+ ' ' + 'username: ' + ' ' + Getor_String(item.ibsusername, '---')
                //     }));
                // });
                // $.each(result, function(i, item) {
                //     devvv_res_id.append($('<option>', {
                //         value: item.emkanat_id,
                //         text: Getor_String(item.reallegal_name, '---') + ' ' + Getor_String(item.general_sertype, '---')+ ' ' + 'username: ' + ' ' + Getor_String(item.ibsusername, '---')
                //     }));
                // });
                // $.each(result, function(i, item) {
                //     enbtp_res_id.append($('<option>', {
                //         value: item.emkanat_id,
                //         text: Getor_String(item.reallegal_name, '---') + ' ' + Getor_String(item.general_sertype, '---')+ ' ' + 'username: ' + ' ' + Getor_String(item.ibsusername, '---')
                //     }));
                // });
                // $.each(result, function(i, item) {
                //     edr_reserve_id.append($('<option>', {
                //         value: item.emkanat_id,
                //         text: Getor_String(item.reallegal_name, '---') + ' ' + Getor_String(item.general_sertype, '---')+ ' ' + 'username: ' + ' ' + Getor_String(item.ibsusername, '---')
                //     }));
                // });
        }
        // jm_oss_registred_id.on('change', function() {
        //     let id = $(this).val();
        //     getosstelephonebyid(id, function(data) {
        //         if (data) {
        //             // jm_telephone.empty();
        //             if (!check_isset_message(data)) {
        //                 jm_telephone.empty();
        //                 jm_telephone.append(`<option value="${data[0]['telephone_id']}">${Getor_String(data[0]['telephone'],'شماره ایی ثبت نشده')}</option>`);
        //             } else { Custom_Modal_Show('w', Getor_String(data['Error'], 'خطا در برنامه')); }
        //         } else { Custom_Modal_Show('d', 'خطا در برنامه'); }
        //     });
        // });
    });
    //////////////////////////////edr////////////////////////////////

    // Initialize('bs_getreserverequests', function(data) {
    //     if (!check_isset_message(data)) {
    //         console.log(1111);
    //         console.log(data);
    //         console.log(1111);
    //         let tmp = "";
    //         for (let i = 0; i < data.length; i++) {
    //             tmp += `<option value="${data[i]['res_rowid']}">${data[i]['name']+' '+ data[i]['f_name']} - ${data[i]['telephonenumber']}</option>`;
    //         }
    //         edr_reserve_id.append(tmp);
    //         emdrbm_res_id.append(tmp);
    //         enbtp_res_id.append(tmp);
    //     }
    // });
    ajaxRequest('getServicesInfoWithServiceType', { 'sertype': 'bitstream' }, window.location.href.split('/').slice(-1)[0], function(result) {
        console.log(result);
        if (!check_isset_message(result)) {
            $.each(result, function(i, item) {
                devvv_res_id.append($('<option>', {
                    value: item.fid,
                    selected: false,
                    text: Getor_String(item.reallegal_name, '---') + ' / ' + ' ' + Getor_String(item.sertype, '---') + ' / ' + 'username: ' + ' ' + Getor_String(item.ibsusername, '---')
                }));
            });
            // devvv_res_id.porp("selectedIndex", "-1");
            // devvv_res_id.prop('selectedIndex', '-1');
        }
    });
    devvv_res_id.on('change', function() {
        // currentpassword.val('');
        ajaxRequest('getAsiatechPortVpiVciVlanByFactorid', { 'factorid': $(this).val() }, window.location.href.split('/').slice(-1)[0], function(result) {
            console.log(1);
            console.log(result);
            console.log(2);

            // // currentpassword.empty();
            if (check_isset_message(result)) {
                centerdisplay_Predefiend_Messages(result);
            }


        });
    });
    // var cols = [{
    //         "data": "id",
    //         title: 'شناسه',
    //     },
    //     {
    //         "data": "tiid",
    //         title: 'شناسه تیکت در OSS',
    //     },
    //     {
    //         "data": "title",
    //         title: 'عنوان تیکت'
    //     }
    // ];
    // DataTable3('#ticketstable', /*path*/ 'osstickets', /*request(dont change)*/ 'datatable_request', /*request2*/ 'osstickets', 'POST', cols, function(table) {
    //     /*===================++  hide first column ++=========================*/
    //     //table.column(0).visible(false);
    //     /*===================++  select table row ++=========================*/
    //     bs_tabs.on('shown.bs.tab', function(e) {
    //         var link = $(e.target).attr("href");
    //         if (link === '#bottom-justified-divided-tab7') {
    //             // table.columns.adjust().draw();
    //             table.columns.adjust();
    //         }
    //     });
    //     $('#ticketstable tbody').on('click', 'tr', function() {
    //         if ($(this).hasClass('selected')) {
    //             $(this).removeClass('selected');
    //         } else {
    //             table.$('tr.selected').removeClass('selected');
    //             $(this).addClass('selected');
    //         }
    //     });
    //     $('#tickets_preview').click(function() {
    //         let tr = $('#ticketstable tbody').find('tr.selected');
    //         let td = tr.find('td:first').text();
    //         Initialize_two_param('gettickethistory', td, function(data) {
    //             if (check_isset_message) {
    //                 display_Predefiend_Messages(data);
    //             } else {
    //                 table.ajax.reload();
    //                 ///todo...
    //             }
    //         });
    //     });
    // });
    /********************************new Ticket**********************************/
    // let nt_type=$("#nt_type");
    // nt_type.select2();
    ////////////////////////old codes///////////////////////
    // let tickets_new = $("#tickets_new");
    // let modal_form_newticket = $("#modal_form_newticket");
    // let newti_maintype = $("#newti_maintype");
    // let newti_maintypeid = $("#newti_maintypeid");
    // newti_maintype.prop('selectedIndex', -1);
    // tickets_new.click(function() {
    //     modal_form_newticket.modal('show');
    // });
    // newti_maintype.on('change', function() {
    //     let id = $(this).val();
    //     Initialize_two_param('bs_getportoruser', id, function(res_maintype) {
    //         console.log(res_maintype);
    //         if (!check_isset_message(res_maintype)) {
    //             newti_maintypeid.empty();
    //             for (let i = 0; i < res_maintype.length; i++) {
    //                 newti_maintypeid.append(`<option value="${res_maintype[i]['id']}">${res_maintype[i]['name']} ${res_maintype[i]['telephone']}</option>`);
    //             }
    //         }
    //     });
    // });
    ////////////////////////old codes///////////////////////
    /********************************preview Ticket**********************************/


});