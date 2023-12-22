$(document).ready(function() {
    $("form").submit(function(e) {
        ajaxForms(e, $(this));
    });
    //$(".custom_select").select2();
    DATEPICKER_YYYYMMDD('#tarikhe_sabt');
    // let baladasti_id= $("#baladasti_id");
    let noe_sherkat = $("#noe_sherkat");
    let ostan = $("#ostan");
    let shahr = $("#shahr");
    ostan.select2();
    shahr.select2();
    noe_sherkat.select2();
    ajaxRequest('GetProvincesAndCities', { aa: false }, window.location.href.split('/').slice(-1)[0], function(result) {
        if(! check_isset_message(result)){
            provcit=result;
            // appendOption(ostane_tavalod, result, 'id', 'name');
            appendOption(ostan, result, 'id', 'name');
            // appendOption(tel1_ostan, result, 'id', 'name');
            // appendOption(tel2_ostan, result, 'id', 'name');
            // appendOption(tel3_ostan, result, 'id', 'name');
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
    Initialize('get_company_types',function(result){
        console.log(result);
        if(check_isset_message(result)){
            display_Predefiend_Messages(result);
        }else{
            if (noe_sherkat) {
                for (let i = 0; i < result.length; i++) {
                    noe_sherkat.append(`<option value="${result[i].id}">${result[i].noe_sherkat}</option>`);
                }
            }
        }
    });



});