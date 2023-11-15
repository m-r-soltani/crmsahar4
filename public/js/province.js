$(document).ready(function() {
    let country_id = $('#country_id');
    Initialize('ostan',function(data){
        if(check_isset_message(data)){
            display_Predefiend_Messages(data);
        }else{
            
            for (let i = 0; i < data.length; i++) {
                country_id.append('<option value=' + data[i].id + '>' + data[i].name + '</option>');
                
            }
        }
    });
    /*===================++  DATA_TABLE  ++=========================*/
    var cols = [
        {
            "data": "id",
            title: 'شناسه'
        },
        {
            "data": "name",
            title: 'نام استان',
        }, {
            "data": "pish_shomare_ostan",
            title: 'پیش شماره استان',
        }, 
        {
            "data": "code_ostan_shahkar",
            title: 'کد شاهکار',
        },
        {
            "data": "code_markazeostan",
            title: 'کد مرکز استان',
        },
        {
            "data": "code_atrafemarkazeostan",
            title: 'کد اطراف مرکز استان',
        },
        {
            "data": "code_biaban",
            title: 'کد بیابان',
        },
        {
            "data": "code_shahrestan",
            title: 'کد شهرستان',
        },
        {
            "data": "code_atrafeshahrestan",
            title: 'کد اطراف شهرستان',
        },
    ];

    DataTable3('#view_table', /*path*/ 'province', /*request(dont change)*/ 'datatable_request', /*request2*/ 'province', 'POST', cols, function(table) {
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
            Hard_Delete(td, 'ostan', function(data) {
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
        Edit_Form('ostan', td, function(data) {
            $('#id').val(data[0]['id']);
            $('#name').val(data[0]['name']);
            $('#pish_shomare_ostan').val(data[0]['pish_shomare_ostan']);
            $('#code_ostan_shahkar').val(data[0]['code_ostan_shahkar']);
            $('#code_markazeostan').val(data[0]['code_markazeostan']);
            $('#code_atrafemarkazeostan').val(data[0]['code_atrafemarkazeostan']);
            $('#code_biaban').val(data[0]['code_biaban']);
            $('#code_shahrestan').val(data[0]['code_shahrestan']);
            $('#code_atrafeshahrestan').val(data[0]['code_atrafeshahrestan']);
            country_id.val(data[0]['c_id'])
        });
    });
});