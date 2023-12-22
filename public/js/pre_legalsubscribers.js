$(document).ready(function() {
    $("form").submit(function(e) {
        ajaxForms(e, $(this));
    });
    let noe_sherkat = $("#noe_sherkat");
    Initialize('get_company_types', function (result) {
        appendOption(noe_sherkat, result, 'id', 'noe_sherkat');
    });
    // DATEPICKER_YYYYMMDD('#tarikhe_tavalod');
    // let ostane_sokonat = $("#ostane_sokonat");
    // let shahre_sokonat = $("#shahre_sokonat");
    // ostane_sokonat.select2();
    // shahre_sokonat.select2();
    // ajaxRequest('GetProvincesAndCities', { aa: false }, window.location.href.split('/').slice(-1)[0], function(result) {
    //     if(! check_isset_message(result)){
    //         provcit=result;
    //         // appendOption(ostane_tavalod, result, 'id', 'name');
    //         appendOption(ostane_sokonat, result, 'id', 'name');
    //         // appendOption(tel1_ostan, result, 'id', 'name');
    //         // appendOption(tel2_ostan, result, 'id', 'name');
    //         // appendOption(tel3_ostan, result, 'id', 'name');
    //     }
    // });
    // ostane_sokonat.on('change', function() {
    //     shahre_sokonat.empty();
    //     if(provcit){
    //         for (let i = 0; i < provcit.length; i++) {
    //             if($(this).val()==provcit[i]['id']){
    //                 appendOption(shahre_sokonat, provcit[i]['cities'], 'id', 'name');
    //             }
    //         }
    //     }
    // });
});