$(document).ready(function() {
    var dashboard_menu = $('#dashboard_menu');
    var user_type = $('#user_type');
    dashboard_menu.select2();
    Initialize('dashboard_menu_group_access', function(data) {
        console.log(data);
        if (check_isset_message(data['Error'])) {
            display_Predefiend_Messages(data);
            
        } else {
            //data az db gerefte nashod
            dashboard_menu.empty();
            if (dashboard_menu) {
                for (let i = 0; i < data.length; i++) {
                    dashboard_menu.append('<option value=' + data[i].id + '>' + data[i].fa_name + '</option>');
                }
            }
        }
        user_type.prop("selectedIndex", -1);
        user_type.on('change', function() {
            let selected_user = user_type.val();
            if (selected_user) {
                Initialize_two_param('dashboard_menu_group_access_current_access_list', selected_user, function(data) {
                    //console.log(data);
                    if (data && data.length > 0) {
                        if (!data['Error']) {
                            var values = new Array();
                            for (let i = 0; i < data.length; i++) {
                                values.push(data[i]['id']);
                            }
                            dashboard_menu.val(values).trigger('change');
                        } else alert(data['Error']);
                    }
                });
            } else alert('لطفا نوع کاربری را انتخاب کنید.');
        });
    });
    
});