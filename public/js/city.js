// document.addEventListener("DOMContentLoaded", function() {
//     var elements = document.getElementsByTagName("INPUT");
//     console.log(elements);
//     for (var i = 0; i < elements.length; i++) {
//         elements[i].oninvalid = function(e) {
//             e.target.setCustomValidity("");
//             if (!e.target.validity.valid) {
//                 e.target.setCustomValidity("This field cannot be left blank");
//             }
//         };
//         elements[i].oninput = function(e) {
//             e.target.setCustomValidity("");
//         };
//     }
// });
$(document).ready(function() {
    $("form").submit(function(e) {
        ajaxForms(e,$(this));
    });
    let ostan_id = $('#ostan_id');
    ostan_id.select2();
    GetProvinces('', function(data) {
        if (data) {
            if (ostan_id) {
                for (let i = 0; i < data.length; i++) {
                    ostan_id.append('<option value=' + data[i].id + '>' + data[i].name + '</option>');
                }
            }
        } else {
            //data az db gerefte nashod
            alert('درخواست ناموفق');
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
            "data": "ostan_name",
            title: 'نام استان',
        },
        {
            "data": "name",
            title: 'نام شهر'
        }
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
    //console.log(window.location.origin+'/'+dt_url+'/helpers/city.php');
    //sahar/city
    DataTable3('#view_table', /*path*/ 'city', /*request(dont change)*/ 'datatable_request', /*request2*/ 'city', 'POST', cols, function(table) {
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
            Hard_Delete(td, 'city', function(data) {
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
        Edit_Form('city', td, function(data) {
            if (data) {
                $('#id').val(data[0]['id']);
                $('#name').val(data[0]['name']);
                $('#ostan_id option[value="' + data[0]['ostan_id'] + '"]').attr('selected', 'selected');
            } else {
                alert('مشکل در انجام درخواست لطفا مجددا تلاش کنید.');
            }


            //$('.form-group').each(function(i) {

            //});

        });
    });


});