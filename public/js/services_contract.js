$(document).ready(function() {
    tinymce_editor("#contract_content");
    
    let service_type=$("#service_type");
    Initialize('services_contract', function(data) {
        if(!data['Error']){
            for (let i = 0; i < data.length; i++) {
                service_type.append('<option value=' + data[i].type + '>'+ data[i].type  + '</option>');
            }
        }else if(data['Error']) alert(data['Error']);
        else alert('خطا در برنامه');
    });
    

        var cols = [
        {
            "data": "id",
            title: 'شناسه',
        },
        {
            "data": "service_type",
            title: 'نوع سرویس',
        },
        {
            "data": "contract_subject",
            title: 'عنوان قرارداد',
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
        //console.log(window.location.origin+'/'+dt_url+'/helpers/services_contract.php');
        //sahar/services_contract
        DataTable3('#view_table', /*path*/ 'services_contract', /*request(dont change)*/ 'datatable_request', /*request2*/ 'services_contract', 'POST', cols, function(table) {
            
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
                Hard_Delete(td, 'services_contract', function(data) {
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
            Edit_Form('services_contract', td, function(data) {
                if (data) {
                    document.getElementById("contract_content").value = "Fifth Avenue, New York City";
                    $('#id').val(data[0]['id']);
                    $('#service_type option[value="' + data[0]['service_type'] + '"]').attr('selected', 'selected');
                    $('#contract_subject').val(data[0]['contract_subject']);
                    tinymce.get('contract_content').setContent(data[0]['contract_content']);
                } else {
                    alert('مشکل در انجام درخواست لطفا مجددا تلاش کنید.');
                }   
            });
        });
        $('form[name="services_contract_form"]').submit(function(e) {
            e.preventDefault();
            $("#send_services_contract").prop("disabled", true);
            setTimeout(function() {
                $("#send_services_contract").prop("disabled", false);
            }, 6000);
            var data = $(this).serializeArray();
            $.ajax({
                type: "post",
                url: 'services_contract',
                timeout: 6000,
                data: {
                    'send_services_contract': data
                },
                success: function(response) {
                    response = JSON.parse(response);
                    if(! check_isset_message(response)){
                        $("#send_services_contract").delay(5000).fadeOut('slow', function() {
                            $("#send_services_contract").remove();
                        });
                    }else{
                        display_Predefiend_Messages(response);
                    }
                    
                },
                error: function(req, res, status) {
                    alert('مشکل در انجام درخواست');
                }
            });
    
        });
});