$(document).ready(function() {
    //$(".custom_select").select2();
    GetProvinces('popsite', function(data) {
        if (data.length > 0) {
            let markaze_mokhaberati = $("#markaze_mokhaberati");
            let provinceid = data[0]['id'];
            let shahr = $("#shahr");
            // GetCityByProvince(provinceid, function(result) {
                ajaxRequest('GetCityByProvince', { 'ostanid': provinceid }, window.location.href.split('/').slice(-1)[0], function(result) {
                if (result) {
                    if (shahr) {
                        for (let i = 0; i < result.length; i++) {
                            shahr.append('<option value=' + result[i].id + '>' + result[i].name + '</option>');
                        }
                    }
                    Get_Telecenter_Bycity(result[0].id, provinceid, function(result) {
                        if (result.length > 0) {
                            markaze_mokhaberati.find('option').remove().end().append('').val('');
                            if (markaze_mokhaberati) {
                                for (let i = 0; i < result.length; i++) {
                                    markaze_mokhaberati.append('<option value=' + result[i].id + '>' + result[i].name + '</option>');
                                }
                            }
                        } else {
                            markaze_mokhaberati.find('option').remove().end().append('').val('');
                        }
                    });
                }
            });
            //has data
            var element = $('#ostan');
            if (element) {
                for (let i = 0; i < data.length; i++) {
                    element.append('<option value=' + data[i].id + '>' + data[i].name + '</option>');
                }
            }
        } else {
            //data az db gerefte nashod
            alert('درخواست ناموفق');
        }
    });
    $('#ostan').on('change', function() {
        //alert( this.value );
        let provinceid = this.value;
        let shahr = $("#shahr");
        let markaze_mokhaberati = $("#markaze_mokhaberati");
        // GetCityByProvince(provinceid, function(result) {
            ajaxRequest('GetCityByProvince', { 'ostanid': provinceid }, window.location.href.split('/').slice(-1)[0], function(result) {
            if (result.length > 0) {
                shahr.find('option').remove().end().append('').val('');
                if (shahr) {
                    for (let i = 0; i < result.length; i++) {
                        shahr.append('<option value=' + result[i].id + '>' + result[i].name + '</option>');
                    }
                }
                Get_Telecenter_Bycity(result[0].id, provinceid, function(result) {
                    if (result.length > 0) {
                        markaze_mokhaberati.find('option').remove().end().append('').val('');
                        if (markaze_mokhaberati) {
                            for (let i = 0; i < result.length; i++) {
                                markaze_mokhaberati.append('<option value=' + result[i].id + '>' + result[i].name + '</option>');
                            }
                        }
                    } else {
                        markaze_mokhaberati.find('option').remove().end().append('').val('');
                    }
                });
            } else {
                shahr.find('option').remove().end().append('').val('');
            }
        });
    });
    $('#shahr').on('change', function() {
        //alert( this.value );
        let provinceid = $("#ostan").val();
        let shahrid = this.value;
        let markaze_mokhaberati = $("#markaze_mokhaberati");
        Get_Telecenter_Bycity(shahrid, provinceid, function(result) {
            if (result.length > 0) {
                markaze_mokhaberati.find('option').remove().end().append('').val('');
                if (markaze_mokhaberati) {
                    for (let i = 0; i < result.length; i++) {
                        markaze_mokhaberati.append('<option value=' + result[i].id + '>' + result[i].name + '</option>');
                    }
                }
            } else {
                markaze_mokhaberati.find('option').remove().end().append('').val('');
            }
        });
    });



    /*===================++  DATA_TABLE  ++=========================*/
    var cols = [{
            "data": "id",
            title: 'شناسه'
        },
        {
            "data": "ostan",
            title: 'استان'
        },
        {
            "data": "shahr",
            title: 'شهر'
        },

        {
            "data": "markaze_mokhaberati",
            title: 'مرکز مخابراتی'
        },
        {
            "data": "sar_shomare",
            title: 'سر شماره'
        },
    ];
    DataTable('#view_table', '/helpers/sar_shomare.php', 'POST', cols, function(table) {
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
        $('#delete').click(function() {
            //shenase avalin soton dt mibashad
            let tr = $('#view_table tbody').find('tr.selected');
            let td = tr.find('td:first').text();
            Hard_Delete(td, 'sar_shomare', function(data) {
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
        Edit_Form('sar_shomare', td, function(data) {
            console.log(data);

            $('#id').val(data[0]['id']);
            $('#sar_shomare').val(data[0]['sar_shomare']);
            $('#tozihat').val(data[0]['tozihat']);
            $('#ostan option[value="' + data[0]['ostan'] + '"]').attr('selected', 'selected');
            $('#shahr option[value="' + data[0]['shahr'] + '"]').attr('selected', 'selected');
            $('#markaze_mokhaberati option[value="' + data[0]['markaze_mokhaberati'] + '"]').attr('selected', 'selected');


            //$('.form-group').each(function(i) {

            //});

        });
    });
});