$(document).ready(function() {
    //$(".custom_select").select2();
    // GetProvinces('popsite', function(data) {
    //     if (data.length > 0) {
    //         let markaze_mokhaberati = $("#markaze_mokhaberati");
    //         let provinceid = data[0]['id'];
    //         let shahr = $("#shahr");
    //         GetCityByProvince(provinceid, function(result) {
    //             if (result) {
    //                 if (shahr) {
    //                     for (let i = 0; i < result.length; i++) {
    //                         shahr.append('<option value=' + result[i].id + '>' + result[i].name + '</option>');
    //                     }
    //                 }
    //                 Get_Telecenter_Bycity(result[0].id, provinceid, function(result) {
    //                     if (result.length > 0) {
    //                         markaze_mokhaberati.find('option').remove().end().append('').val('');
    //                         if (markaze_mokhaberati) {
    //                             for (let i = 0; i < result.length; i++) {
    //                                 markaze_mokhaberati.append('<option value=' + result[i].id + '>' + result[i].name + '</option>');
    //                             }
    //                         }
    //                     } else {
    //                         markaze_mokhaberati.find('option').remove().end().append('').val('');
    //                     }
    //                 });
    //             }
    //         });
    //         //has data
    //         var element = $('#ostan');
    //         if (element) {
    //             for (let i = 0; i < data.length; i++) {
    //                 element.append('<option value=' + data[i].id + '>' + data[i].name + '</option>');
    //             }
    //         }
    //     } else {
    //         //data az db gerefte nashod
    //         alert('درخواست ناموفق');
    //     }
    // });
    // $('#ostan').on('change', function() {
    //     //alert( this.value );
    //     let provinceid = this.value;
    //     let shahr = $("#shahr");
    //     let markaze_mokhaberati = $("#markaze_mokhaberati");
    //     GetCityByProvince(provinceid, function(result) {
    //         if (result.length > 0) {
    //             shahr.find('option').remove().end().append('').val('');
    //             if (shahr) {
    //                 for (let i = 0; i < result.length; i++) {
    //                     shahr.append('<option value=' + result[i].id + '>' + result[i].name + '</option>');
    //                 }
    //             }
    //             Get_Telecenter_Bycity(result[0].id, provinceid, function(result) {
    //                 if (result.length > 0) {
    //                     markaze_mokhaberati.find('option').remove().end().append('').val('');
    //                     if (markaze_mokhaberati) {
    //                         for (let i = 0; i < result.length; i++) {
    //                             markaze_mokhaberati.append('<option value=' + result[i].id + '>' + result[i].name + '</option>');
    //                         }
    //                     }
    //                 } else {
    //                     markaze_mokhaberati.find('option').remove().end().append('').val('');
    //                 }
    //             });
    //         } else {
    //             shahr.find('option').remove().end().append('').val('');
    //         }
    //     });
    // });
    // $('#shahr').on('change', function() {
    //     //alert( this.value );
    //     let provinceid = $("#ostan").val();
    //     let shahrid = this.value;
    //     let markaze_mokhaberati = $("#markaze_mokhaberati");
    //     Get_Telecenter_Bycity(shahrid, provinceid, function(result) {
    //         if (result.length > 0) {
    //             markaze_mokhaberati.find('option').remove().end().append('').val('');
    //             if (markaze_mokhaberati) {
    //                 for (let i = 0; i < result.length; i++) {
    //                     markaze_mokhaberati.append('<option value=' + result[i].id + '>' + result[i].name + '</option>');
    //                 }
    //             }
    //         } else {
    //             markaze_mokhaberati.find('option').remove().end().append('').val('');
    //         }
    //     });
    // });
    $("form").submit(function(e) {
        ajaxForms(e, $(this));
    });
    // let ostan = $("#ostan");
    // let shahr = $("#shahr");
    let markaze_mokhaberati = $("#markaze_mokhaberati");
    // ostan.select2();
    // shahr.select2();
    markaze_mokhaberati.select2();
    ajaxRequest('GetTeleCenters', { 'aaa': false }, thisPage(), function(result) {
        if(! check_isset_message()){
            appendOption(markaze_mokhaberati, result, 'id', 'name', 'ostan_faname', 'ps');
        }
    });
    // ajaxRequest('GetAllProvinces', { 'provinces': 1 }, thisPage(), function(result) {
    //     if(! check_isset_message()){
    //         appendOption(ostan, result, 'id', 'name', false, 'p');
    //     }
    // });
    // ostan.on('change',function(){
    //     ajaxRequest('GetCityByProvince', { 'ostanid':ostan.val() }, thisPage(), function(result) {
    //         appendOption(shahr, result, 'id', 'name', false, 'p');
    //     });
    // });
    // shahr.on('change',function(){
    //     ajaxRequest('GetTeleCenterByCity', { 'shahrid':shahr.val() }, thisPage(), function(result) {
    //         appendOption(markaze_mokhaberati, result, 'id', 'name', false, 'p');
    //     });
    // });
    /*===================++  DATA_TABLE  ++=========================*/
    var cols = [{
            "data": "id",
            title: 'شناسه'
        },
        {
            "data": "os_tc_name",
            title: 'مرکز / شهر'
        },
        {
            "data": "prenumber",
            title: 'پیش شماره مرکز'
        },


    ];
    DataTable3('#view_table', /*path*/ 'pre_number', /*request(dont change)*/ 'datatable_request', /*request2*/ 'pre_number', 'POST', cols, function(table) {
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
            Hard_Delete(td, 'pre_number', function(data) {
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
        Edit_Form('pre_number', td, function(data) {
            if (data) {
                $('#id').val(data[0]['id']);
                $('#prenumber').val(data[0]['prenumber']);
                $('#tozihat').val(data[0]['tozihat']);
                $('#markaze_mokhaberati').val(data[0]['markaze_mokhaberati']).change();

                // $('#ostan_id option[value="' + data[0]['ostan_id'] + '"]').attr('selected', 'selected');
            } else {
                alert('مشکل در انجام درخواست لطفا مجددا تلاش کنید.');
            }
        });
    });














    // DataTable('#view_table', '/helpers/pre_number.php', 'POST', cols, function(table) {
    //     /*===================++  hide first column ++=========================*/
    //     //table.column(0).visible(false);
    //     /*===================++  select table row ++=========================*/
    //     $('#view_table tbody').on('click', 'tr', function() {
    //         if ($(this).hasClass('selected')) {
    //             $(this).removeClass('selected');
    //         } else {
    //             table.$('tr.selected').removeClass('selected');
    //             $(this).addClass('selected');
    //         }
    //     });
    //     $('#delete').click(function() {
    //         //shenase avalin soton dt mibashad
    //         let tr = $('#view_table tbody').find('tr.selected');
    //         let td = tr.find('td:first').text();
    //         Hard_Delete(td, 'pre_number', function(data) {
    //             if (data) {
    //                 table.ajax.reload();
    //             } else {
    //                 alert('عملیات ناموفق');
    //             }
    //         });
    //     });
    // });
    // $('#edit').click(function() {
    //     let tr = $('#view_table tbody').find('tr.selected');
    //     let td = tr.find('td:first').text();
    //     Edit_Form('pre_number', td, function(data) {
    //         $('#id').val(data[0]['id']);
    //         $('#markaze_mokhaberati').val(data[0]['markaze_mokhaberati']);
    //         //$('#tedade_pishshomare').val(data[0]['tedade_pishshomare']);
    //         //$('#mantaghe').val(data[0]['mantaghe']);
    //         $('#ostan').val(data[0]['ostan']);
    //         $('#shahr').val(data[0]['shahr']);
    //         $('#ostan_prenumber').val(data[0]['ostan_prenumber']);
    //         $('#prenumber').val(data[0]['prenumber']);
    //         //$('#noe_gharardad').val(data[0]['noe_gharardad']);
    //         $('#tozihat').val(data[0]['tozihat']);


    //         //$('#ostan option[value="'+data[0]['ostan_id']+'"]').attr('selected','selected');
    //         //$('#shahr option[value="'+data[0]['shahr_id']+'"]').attr('selected','selected');


    //         //$('#ostan option[value="'+data[0]['ostan_id']+'"]').attr('selected','selected');


    //         //$('.form-group').each(function(i) {

    //         //});

    //     });
    // });
});