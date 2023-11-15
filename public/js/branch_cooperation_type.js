$(document).ready(function() {
    //$(".custom_select").select2();
    let service_type=$("#service_type");
    Initialize('get_dist_services_list',function(data){
        if(check_isset_message(data)){
            display_Predefiend_Messages(data);
        }else{
            for (let i = 0; i < data.length; i++) {
                service_type.append(`<option value="${data[i].id}">${data[i].noe_khadamat}</option>`);
            }
        }
    });
    Get_Branch_Info('branch_cooperation_type', function(data) {
        let branch_id = $("#branch_id");
        if (data.length > 0) {
            for (let i = 0; i < data.length; i++) {
                branch_id.append(`<option value="${data[i].id}">${data[i].name_sherkat}</option>`);
            }
        }
        // let cooperation_type = $("#cooperation_type");
        // cooperation_type.prop("selectedIndex", -1);
        // cooperation_type.on('change', function(params) {
        //     let type_value = $(this).val();
        //     console.log(type_value);
        // });
    });
    var cols = [{
            "data": "id",
            title: 'شناسه'
        },
        {
            "data": "branch_id",
            title: 'نمایندگی'
        },
        {
            "data": "service_type",
            title: 'نوع سرویس'
        },
        {
            "data": "cooperation_type",
            title: 'نوع همکاری'
        },
    ];
    DataTable3('#view_table', 'branch_cooperation_type', 'datatable_request', 'branch_cooperation_type', 'POST', cols, function(table) {
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
        //onclick log row data
        /*$('#view_table tbody').on( 'click', 'tr', function () {
            console.log( table.row( this ).data() );
        } );*/
        $('#delete').click(function() {
            let tr = $('#view_table tbody').find('tr.selected');
            let td = tr.find('td:first').text();
            Hard_Delete(td, 'branch_cooperation_type', function(data) {
                if (data) {
                    table.ajax.reload();
                } else {
                    alert('عملیات ناموفق');
                }
            });
        });
    });
    $('#edit').click(function() {
        let tr = $('#view_table tbody').find('tr.selected');
        let td = tr.find('td:first').text();
        Edit_Form('branch_cooperation_type', td, function(data) {
            console.log(data);
            $('#id').val(data[0]['id']);
            $('#cooperation_type').val(data[0]['cooperation_type']);
            $('#foroshe_service_jadid').val(data[0]['foroshe_service_jadid']);
            $('#foroshe_service_sharje_mojadad').val(data[0]['foroshe_service_sharje_mojadad']);
            $('#foroshe_service_bulk').val(data[0]['foroshe_service_bulk']);
            $('#foroshe_service_jashnvare').val(data[0]['foroshe_service_jashnvare']);
            $('#hazine_sazmane_tanzim').val(data[0]['hazine_sazmane_tanzim']);
            $('#hazine_servco').val(data[0]['hazine_servco']);
            $('#hazine_mansobe').val(data[0]['hazine_mansobe']);
            $('#branch_id option[value="' + data[0]['branch_id'] + '"]').attr('selected', 'selected');
            $('#service_type option[value="' + data[0]['service_type'] + '"]').attr('selected', 'selected');
        });
    });
});