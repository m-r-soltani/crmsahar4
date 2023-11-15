$(document).ready(function() {
    $("form").submit(function(e) {
        // e.preventDefault();
        // let aa=$( this ).serialize();
        // console.log(aa);
        ajaxForms(e, $(this));
    });
    let ded_operator=$("#ded_operator");
    let vd_operator=$("#vd_operator");
    let vd_menu=$("#vd_menu");
    let vd_omenu = $('#vd_menu option');
    let vd_add=$("#vd_add");
    let vd_edit=$("#vd_edit");
    let vd_delete=$("#vd_delete");
    let ded_operation=$("#ded_operation");
    let vd_modal_form=$("#vd_modal_form");
    let restrictionsmodal=$("#restrictionsmodal");
    vd_menu.select2();
    vd_add.select2();
    vd_edit.select2();
    vd_delete.select2();
    vd_operator.select2();
    ded_operator.select2();
    ded_operation.select2();
    ajaxRequest('GetAllDashboardMenusForAdminOperator', { 'operator': 1 }, window.location.href.split('/').slice(-1)[0], function(result) {
        console.log(result);
        if (check_isset_message(result)) {
            display_Predefiend_Messages(result);
        } else {
            $.each(result, function(i, item) {
                vd_menu.append($('<option>', {
                    value: item.did,
                    text: Getor_String(item.dfaname, '---')
                }));
                vd_menu.prop("selectedIndex",-1);
                vd_add.append($('<option>', {
                    value: item.did,
                    text: Getor_String(item.dfaname, '---')
                }));
                vd_add.prop("selectedIndex",-1);
                vd_edit.append($('<option>', {
                    value: item.did,
                    text: Getor_String(item.dfaname, '---')
                }));
                vd_edit.prop("selectedIndex",-1);
                vd_delete.append($('<option>', {
                    value: item.did,
                    text: Getor_String(item.dfaname, '---')
                }));
                vd_delete.prop("selectedIndex",-1);
            });
        }
    });
    ajaxRequest('GetAllAdminOperators', { 'userid': false }, window.location.href.split('/').slice(-1)[0], function(result) {
        console.log(result);
        if (check_isset_message(result)) {
            // display_Predefiend_Messages(result);
        } else {
            $.each(result, function(i, item) {
                ded_operator.append($('<option>', {
                    value: item.id,
                    text: Getor_String(item.name, '---')+ ' ' + Getor_String(item.name_khanevadegi, '---') + ' '+ ' سمت: ' + Getor_String(item.semat, '---') 
                }));
            });
            $.each(result, function(i, item) {
                vd_operator.append($('<option>', {
                    value: item.id,
                    text: Getor_String(item.name, '---')+ ' ' + Getor_String(item.name_khanevadegi, '---') + ' '+ ' سمت: ' + Getor_String(item.semat, '---') 
                }));
            });
        }
    });
    vd_operator.on('change', function () {
        ajaxRequest('GetAdminOperatorRestrictions', { 'operator': vd_operator.val() }, window.location.href.split('/').slice(-1)[0], function(result) {
            if (check_isset_message(result)) {
                display_Predefiend_Messages(result);
            } else {
                console.log(888);
                console.log(result);
                console.log(888);
                vd_menu.find('option').each(function() {
                    $(this).prop("selected", false).change();
                });
                vd_add.find('option').each(function() {
                    $(this).prop("selected", false).change();
                });
                vd_edit.find('option').each(function() {
                    $(this).prop("selected", false).change();
                });
                vd_delete.find('option').each(function() {
                    $(this).prop("selected", false).change();
                });
                if(result['access']){
                    $.each(result['access'], function(i, item) {
                        vd_menu.find('option').each(function() {                                
                            if($(this).val()==item['menu_id']){
                                $(this).prop("selected", true).change();
                            }
                        });
                    });
                }
                if(result['add']){
                    $.each(result['add'], function(i, item) {
                        vd_add.find('option').each(function() {                                
                            if($(this).val()==item['menu_id']){
                                $(this).prop("selected", true).change();
                            }
                        });
                    });
                }
                if(result['edit']){
                    $.each(result['edit'], function(i, item) {
                        vd_edit.find('option').each(function() {                                
                            if($(this).val()==item['menu_id']){
                                $(this).prop("selected", true).change();
                            }
                        });
                    });
                }
                if(result['delete']){
                    $.each(result['delete'], function(i, item) {
                        vd_delete.find('option').each(function() {                                
                            if($(this).val()==item['menu_id']){
                                $(this).prop("selected", true).change();
                            }
                        });
                    });
                }
            }
        });
    });
    


});