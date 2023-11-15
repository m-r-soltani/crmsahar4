$(document).ready(function() {
    DATEPICKER_YYYYMMDD('#exdate');
    let element = $('#brand_id');
    Initialize('equipments_models', function(data) {
        if (check_isset_message(data)) {
            display_Predefiend_Messages(data);
        } else {
            if (element) {
                for (let i = 0; i < data.length; i++) {
                    element.append('<option value=' + data[i].id + '>' + data[i].name + '</option>');
                }
            }
        }
    });

    var cols = [
        {
        "data": "id",
        title: 'شناسه',
        },
        {
            "data": "name",
            title: 'نام',
        },
        {
            "data": "exdate",
            title: 'تاریخ اعتبار'
        }
    ];
    DataTable3('#view_table', /*path*/ 'equipments_models', /*request(dont change)*/ 'datatable_request', /*request2*/ 'equipments_models', 'POST', cols, function(table) {

        $('#view_table tbody').on('click', 'tr', function() {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            } else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });

        $('#delete').click(function() {
            let tr = $('#view_table tbody').find('tr.selected');
            let td = tr.find('td:first').text();
            Hard_Delete(td, 'equipments_models', function(data) {
                console.log(data);
                if (check_isset_message(data)) {
                    table.ajax.reload();
                    display_Predefiend_Messages(data);
                } else {
                    //todo bebin bayad chekar koni
                    table.ajax.reload();
                    display_Predefiend_Messages(data);
                    
                }
            });
        });
    });
    $('#edit').click(function() {
        let tr = $('#view_table tbody').find('tr.selected');
        let td = tr.find('td:first').text();
        Edit_Form('equipments_models', td, function(data) {
            if (data) {
                data[0]['exdate'] = tabdile_tarikh_adad(data[0]['exdate']);
                $('#id').val(data[0]['id']);
                $('#name').val(data[0]['name']);
                $('#exdate').val(data[0]['exdate']);
                $('#brand_id option[value="' + data[0]['brand_id'] + '"]').attr('selected', 'selected');
            } else {
                alert('مشکل در انجام درخواست لطفا مجددا تلاش کنید.');
            }


            //$('.form-group').each(function(i) {

            //});

        });
    });


});