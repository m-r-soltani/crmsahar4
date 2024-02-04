$(document).ready(function() {
    $("form").submit(function(e) {
        ajaxForms(e, $(this));
    });
    let formcardbody=$("#formcardbody");
    let datatablecardbody=$("#datatablecardbody");
    let filtersbtn=$("#filtersbtn");
    let activeservicesformbody=$("#activeservicesformbody");

    filtersbtn.on('click', function(){
        let ostanfilter=$('input[name=ostanchoose]:checked').val();
        let shahrfilter=$('input[name=shahrchoose]:checked').val();
        let tarikhfilter=$('input[name=tarikhchoose]:checked').val();
        let tmp="";
        if(ostanfilter && shahrfilter && tarikhfilter){
            activeservicesformbody.empty();
            if(ostanfilter==="1"){
                tmp+='<label class="col-form-label col-md-2">استان</label>';
                tmp+='<span class="col-md-4">';
                tmp+='<select class="form-control form-control-md custom_select" required name="ostan" id="ostan"></select> </span>';
            }
            if(shahrfilter==="1"){
                tmp+='<label class="col-form-label col-md-2">شهر</label>';
                tmp+='<span class="col-md-4">';
                tmp+='<select class="form-control form-control-md custom_select" required name="shahr" id="shahr"></select> </span>';
            }
            if(tarikhfilter==="1"){
                tmp+='<label class="col-form-label col-md-2">از تاریخ</label>'
                +'<div class="col-md-4">'
                    +'<input type="text" class="form-control" id="timefrom" name="timefrom" placeholder="" required>'
                +'</div>'
                +'<label class="col-form-label col-md-2">تا تاریخ</label>'
                +'<div class="col-md-4">'
                    +'<input type="text" class="form-control" id="timeto" name="timeto" placeholder="" required>'
                +'</div>';
            }
            tmp+='<label class="col-form-label col-md-2">وضعیت</label>'
            +'<div class="col-md-4">'
                +'<select class="form-control form-control-md custom_select" required name="status" id="status">'
                    +'<option value="1" selected>فعال</option>'
                    +'<option value="2">غیر فعال</option>'
                    +'<option value="0">همه</option>'
                +'</select>'
            +'</div>';
            tmp+='<label class="col-form-label col-md-2">نوع سرویس</label>'
            +'<div class="col-md-4">'
                +'<select class="form-control form-control-md custom_select" required name="service" id="service">'
                    +'<option value="dsl" selected>DSL(ADSL & VDSL)</option>'
                    +'<option value="adsl">ADSL</option>'
                    +'<option value="vdsl">VDSL</option>'
                    +'<option value="wireless">Wireless</option>'
                    +'<option value="tdlte">TDLTE</option>'
                    +'<option value="voip">Voip(Orgination)</option>'
                +'</select>'
            +'</div>';
            activeservicesformbody.append(tmp);
            formcardbody.css({'display':'block'});
            datatablecardbody.css({'display':'block'});
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
        }else{
            display_Predefiend_Messages({'Warning':"ابتدا فیلترهای جستجو را انتخاب کنید"});
        }
    });
    // $('form[name="active_services"]').submit(function(e) {
    //     e.preventDefault();
        
    //     // var data = $(this).serializeArray();
    //     let data=$(this).serialize();
    //     $.ajax({
    //         type: "post",
    //         url: 'bootstrap',
    //         //timeout: 10000,
    //         data: {
    //             'send_active_services': data
    //         },
    //         success: function(response) {
    //             response = JSON.parse(response);
    //             console.log(response);
    //             if(check_isset_message(response)){
    //                 display_Predefiend_Messages(response);
    //             }else{
    //                 if(response){
    //                     let cols = [
    //                     {
    //                         title: 'استان'
    //                     },
    //                     {
    //                         title: 'شهر'
    //                     },
    //                     {
    //                         title: 'نام'
    //                     },
    //                     {
    //                         title: 'تلفن'
    //                     },
    //                     {
    //                         title: 'سرویس'
    //                     },
    //                     {
    //                         title: 'وضعیت'
    //                     },
    //                     {
    //                         title: 'تاریخ شروع'
    //                     },
    //                     {
    //                         title: 'تاریخ پایان'
    //                     },
    //                 ];
    //                 let dataset = [];
    //                 for (let i = 0; i < response.length; i++) {
    //                     dataset[i] = [];
    //                     dataset[i].push(response[i]['ostane_sokonat_name_fa']);
    //                     dataset[i].push(response[i]['shahre_sokonat_name_fa']);
    //                     dataset[i].push(response[i]['reallegal_name']);
    //                     dataset[i].push(response[i]['telephone1']);
    //                     dataset[i].push(response[i]['general_sertype']);
    //                     dataset[i].push(response[i]['serstatus_fa']);
    //                     dataset[i].push(response[i]['tts_formatted']);
    //                     dataset[i].push(response[i]['tps_formatted']);
    //                 }
    //                 //sort array
    //                 dataset = dataset.filter(function() { return true; });
    //                 if (dataset) {
    //                     DataTable_array_datasource('#datatable1', dataset, cols, function(table) {});
    //                 }
    //                 }
    //             }
    //         },
    //         error: function(req, res, status) {
    //             alert('مشکل در انجام درخواست');
    //         }
    //     });
    // });

});