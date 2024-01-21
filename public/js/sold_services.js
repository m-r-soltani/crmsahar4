$(document).ready(function() {
    // $("form").submit(function(e) {
    //     ajaxForms(e, $(this));
    // });
    let ostan=$("#ostan");
    let shahr=$("#shahr");
    let service=$("#service");
    let timefrom=$("#timefrom");
    let timeto=$("#timeto");
    var provcit={};
    ostan.select2();
    shahr.select2();
    service.select2();
    DATEPICKER_YYYYMMDD(timefrom);
    DATEPICKER_YYYYMMDD(timeto);
    ajaxRequest('GetProvincesAndCities', { aa: false }, window.location.href.split('/').slice(-1)[0], function(result) {
        if(! check_isset_message(result)){
            provcit=result;
            appendOption(ostan, result, 'id', 'name');
        }
    });

    ostan.on('change', function() {
        shahr.empty();
        if(provcit){
            for (let i = 0; i < provcit.length; i++) {
                if($(this).val()==provcit[i]['id']){
                    appendOption(shahr, provcit[i]['cities'], 'id', 'name');
                }
            }
        }
    });
    $('form[name="sold_services"]').submit(function(e) {
        e.preventDefault();
        
        // var data = $(this).serializeArray();
        let data=$(this).serialize();
        $.ajax({
            type: "post",
            url: 'bootstrap',
            //timeout: 10000,
            data: {
                'send_sold_services': data
            },
            success: function(response) {
                response = JSON.parse(response);
                console.log(response);
                if(check_isset_message(response)){
                    display_Predefiend_Messages(response);
                }else{
                    if(response){
                        let cols = [
                        {
                            title: 'استان'
                        },
                        {
                            title: 'شهر'
                        },
                        {
                            title: 'نام'
                        },
                        {
                            title: 'تلفن'
                        },
                        {
                            title: 'سرویس'
                        },
                        {
                            title: 'وضعیت'
                        },
                        {
                            title: 'تاریخ شروع'
                        },
                        {
                            title: 'تاریخ پایان'
                        },
                    ];
                    let dataset = [];
                    for (let i = 0; i < response.length; i++) {
                        dataset[i] = [];
                        dataset[i].push(response[i]['ostane_sokonat_name_fa']);
                        dataset[i].push(response[i]['shahre_sokonat_name_fa']);
                        dataset[i].push(response[i]['reallegal_name']);
                        dataset[i].push(response[i]['telephone1']);
                        dataset[i].push(response[i]['general_sertype']);
                        dataset[i].push(response[i]['serstatus_fa']);
                        dataset[i].push(response[i]['tts_formatted']);
                        dataset[i].push(response[i]['tps_formatted']);
                    }
                    //sort array
                    dataset = dataset.filter(function() { return true; });
                    if (dataset) {
                        DataTable_array_datasource('#datatable1', dataset, cols, function(table) {});
                    }
                    }
                }
            },
            error: function(req, res, status) {
                alert('مشکل در انجام درخواست');
            }
        });
    });

});