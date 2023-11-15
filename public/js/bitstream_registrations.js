$(document).ready(function() {
    ////////////////////////////////eses////////////////////////////////
    let rm_reserve_type          = $("#rm_reserve_type");
    rm_reserve_type.prop("selectedIndex",-1);
    let eses_markaze_mokhaberati = $("#eses_markaze_mokhaberati");
    let rm_markaze_mokhaberati   = $("#rm_markaze_mokhaberati");
    eses_markaze_mokhaberati.select2();
    rm_markaze_mokhaberati.select2();
        //////////////////////////submit all forms/////////////////////////////////
        $("form").submit(function(e) {
            ajaxForms(e,$(this));
        });
        //////////////////////////submit all forms
    // Initialize('bs_get_telecenters', function(data) {
    //     console.log(111);
    //     console.log(data);
    //     console.log(222);
    //     if(data){
    //         if (!check_isset_message(data)) {
    //                 let tmp = "";
    //                 for (let i = 0; i < data['data'].length; i++) {
    //                     tmp += '<option value=' + data['data'][i].loid + '>' +
    //                         data['data'][i].ciname + '-' + data['data'][i].loname + '-' + data['data'][i].loid + '</option>';
    //                 }
    //                 eses_markaze_mokhaberati.append(tmp);
    //                 rm_markaze_mokhaberati.append(tmp);
                
    //         } else {
    //             display_Predefiend_Messages(data);
    //         }
    //     }
    // });
    ////////////////////////////////smdoss////////////////////////////////
    let smdoss_telephone      = $("#smdoss_telephone");
    let smdoss_moshtarak_id   = $("#smdoss_moshtarak_id");
    smdoss_moshtarak_id.select2();
    // smdoss_telephone.select2();
    Initialize('bs_getallsubscribers', function(data) {
        console.log(data);
        if (!check_isset_message(data)) {
            let tmp = "";
            for (let i = 0; i < data.length; i++) {
                tmp += `<option value="${data[i]['id']}">${data[i]['name']+' '+ data[i]['f_name']} - ${data[i]['code_meli']}</option>`;
            }
            smdoss_moshtarak_id.append(tmp);
            smdoss_moshtarak_id.prop("selectedIndex",-1);
        } else {
            Custom_Modal_Show('d',Getor_String(data['Error'],'خطا در برنامه'));
        }
        smdoss_moshtarak_id.on('change',function(){
            let id = $(this).val();
            getsubtelephonesbyid(id,function(data){
                if(data){
                    // smdoss_telephone.empty();
                    if(!check_isset_message(data)){
                        smdoss_telephone.empty();
                        smdoss_telephone.append(`<option value="1">${Getor_String(data[0]['telephone1'],'شماره ایی ثبت نشده')}</option>`);
                        smdoss_telephone.append(`<option value="2">${Getor_String(data[0]['telephone2'],'شماره ایی ثبت نشده')}</option>`);
                        smdoss_telephone.append(`<option value="3">${Getor_String(data[0]['telephone3'],'شماره ایی ثبت نشده')}</option>`);
                    }else{ Custom_Modal_Show('w',Getor_String(data['Error'],'خطا در برنامه')); }
                }else{Custom_Modal_Show('d','خطا در برنامه');}
            });
        });
    });
    ////////////////////////////////rm////////////////////////////////
    let rm_telephone          = $("#rm_telephone");
    let rm_oss_registred_id   = $("#rm_oss_registred_id");
    rm_oss_registred_id.select2();
    Initialize('bs_getosssubscribers', function(data) {
        console.log(data);
        if (!check_isset_message(data)) {
            let tmp = "";
            for (let i = 0; i < data.length; i++) {
                tmp += `<option value="${data[i]['id']}">${data[i]['name']+' '+ data[i]['f_name']} - ${data[i]['telephone']}</option>`;
            }
            rm_oss_registred_id.append(tmp);
            rm_oss_registred_id.prop("selectedIndex",-1);
        }
        rm_oss_registred_id.on('change',function(){
            let id = $(this).val();
            getosstelephonebyid(id,function(data){
                console.log(1);
                console.log(id);
                console.log(data);
                console.log(2);
                if(data){
                    // rm_telephone.empty();
                    if(!check_isset_message(data)){
                        rm_telephone.empty();
                        rm_telephone.append(`<option value="${data[0]['telephone_id']}">${Getor_String(data[0]['telephone'],'شماره ایی ثبت نشده')}</option>`);
                    }else{ display_Predefiend_Messages(data); }
                }else{Custom_Modal_Show('d','خطا در برنامه');}
            });
        });
    });
    ////////////////////////////////dvdr////////////////////////////////
    let dvdr_reserve_id = $("#dvdr_reserve_id");
    let ldr_res_id      = $("#ldr_res_id");
    dvdr_reserve_id.select2();
    ldr_res_id.select2();
    Initialize('bs_getreserverequests', function(data) {
        console.log('getresreq');
        console.log(data);
        if (!check_isset_message(data)) {
            let tmp = "";
            for (let i = 0; i < data.length; i++) {
                tmp += `<option value="${data[i]['res_rowid']}">${data[i]['name']+' '+ data[i]['f_name']} - ${data[i]['telephonenumber']}</option>`;
            }
            ldr_res_id.append(tmp);
            ldr_res_id.prop("selectedIndex",-1);
            dvdr_reserve_id.append(tmp);
            dvdr_reserve_id.prop("selectedIndex",-1);
        }
    });
    ////////////////////////////////jm & dsmdoss////////////////////////////////
    let dsmdoss_oss_id         = $("#dsmdoss_oss_id");
    let jm_telephone          = $("#jm_telephone");
    let jm_oss_registred_id   = $("#jm_oss_registred_id");
    dsmdoss_oss_id.select2();
    jm_oss_registred_id.select2();
    jm_telephone.select2();
    Initialize('bs_getosssubscribers', function(data) {
        if (!check_isset_message(data)) {
            let tmp = "";
            for (let i = 0; i < data.length; i++) {
                tmp += `<option value="${data[i]['id']}">${data[i]['name']+' '+ data[i]['f_name']} - ${data[i]['code_meli']+'-'+data[i]['telephone']}</option>`;
            }
            jm_oss_registred_id.append(tmp);
            jm_oss_registred_id.prop("selectedIndex",-1);
            dsmdoss_oss_id.append(tmp);
            dsmdoss_oss_id.prop("selectedIndex",-1);
        }
        jm_oss_registred_id.on('change',function(){
            let id = $(this).val();
            getosstelephonebyid(id,function(data){
                if(data){
                    // jm_telephone.empty();
                    if(!check_isset_message(data)){
                        jm_telephone.empty();
                        jm_telephone.append(`<option value="${data[0]['telephone_id']}">${Getor_String(data[0]['telephone'],'شماره ایی ثبت نشده')}</option>`);
                    }else{ Custom_Modal_Show('w',Getor_String(data['Error'],'خطا در برنامه')); }
                }else{Custom_Modal_Show('d','خطا در برنامه');}
            });
        });
    });
    
    



























});