$(document).ready(function () {
    //$(".custom_select").select2();
    Get_Branch_Info('tdlte_sim',function (result) {
        let branch_id=$("#branch_id");
        if(result){
            branch_id.append('<option value="0">شبکه سحر ارتباط</option>');
            for (let i = 0; i < result.length; i++) {
                branch_id.append('<option value=' + result[i].id + '>' + result[i].name_sherkat + '</option>');
            }
            
            //branch_id.prop("selectedIndex",-1);
        }else{
            alert('نمایندگی یافت نشد.');
        }
    });

    
    
    /*===================++  DATA_TABLE  ++=========================*/
    var cols = [{
        "data": "id",
        title: 'شناسه'
        },
        {
            "data": "serial",
            title: 'سریال'
        },
        {
            "data": "tdlte_number",
            title: 'شماره سیمکارت',
        },
        {
            "data": "name_sherkat",
            title: 'نام شرکت',
        },
        {
            "data": "full_name",
            title: 'نام مشترک',
        },
        {
            "data": "puk1",
            title: 'puk1',
        },
        {
            "data": "puk2",
            title: 'puk2',
        },
        {
            "data": "tarikhe_sabt",
            title: 'تاریخ ثبت',
        },


    ];
    // DataTable('#view_table', '/helpers/tdlte_sim.php', 'POST', cols, function (table) {
    DataTable3('#view_table', /*path*/ 'tdlte_sim', /*request(dont change)*/ 'datatable_request', /*request2*/ 'tdlte_sim', 'POST', cols, function(table) {
        /*===================++  select table row ++=========================*/
        $('#view_table tbody').on('click', 'tr', function () {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            } else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });
        $('#delete').click(function () {
            //shenase avalin soton dt mibashad
            let tr = $('#view_table tbody').find('tr.selected');
            let td = tr.find('td:first').text();
            Hard_Delete(td, 'tdlte_sim', function (data) {                
                if (data) {
                    table.ajax.reload();
                } else {
                    alert('عملیات ناموفق');
                }
            });
        });
    });
    $('#edit').click(function () {
        // $(".form-group").find("input").each(function () {
        //     console.log(123);
        // });
        let tr = $('#view_table tbody').find('tr.selected');
        let td = tr.find('td:first').text();
        Edit_Form('tdlte_sim', td, function (data) {
            $('#id').val(data[0]['id']);
            $('#puk1').val(data[0]['puk1']);
            $('#puk2').val(data[0]['puk2']);
            $('#serial').val(data[0]['serial']);
            $('#tdlte_number').val(data[0]['tdlte_number']);
            $('#branch_id option[value="'+data[0]['branch_id']+'"]').attr('selected','selected');
            //$('#subscriber_id option[value="'+data[0]['subscriber_id']+'"]').attr('selected','selected');

            // if(data[0]['batrie_poshtiban']==="on") {
            //     $('#batrie_poshtiban').prop('checked', true);
            // }else{
            //     $('#batrie_poshtiban').prop('checked', false);
            // }


            


            //$('.form-group').each(function(i) {

            //});

        });
    });

});