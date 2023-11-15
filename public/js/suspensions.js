$(document).ready(function() {
    $("form").submit(function (e) {
        ajaxForms(e, $(this));
    });
    let sub             = $("#sub");
    let operationtype   = $("#operationtype");
    let service         = $("#service");
    let time            = $("#time");
    let masdoditime     = $(".masdoditime");
    time.select2();
    operationtype.select2();
    sub.select2();
    service.select2();
    ajaxRequest('getallsubscribers', {'userid':false}, window.location.href.split('/').slice(-1)[0], function(result){
        sub.empty();
        if(! result) display_Predefiend_Messages();
        if(check_isset_message(result)) display_Predefiend_Messages(result);
        ////check done
        appendOption(sub, result, 'id', 'name', 'telephone1');
    });
    sub.on('change',function(){
        ajaxRequest('getuserservices', {'user_id':$(this).val(), 'sertype':'all'}, window.location.href.split('/').slice(-1)[0], function(result){
            service.empty();
            // appendOption(service, result, 'factorid', 'ibsusername', 'ibsusername');
            if(! result){
                display_Predefiend_Messages();
            }
            if(! check_isset_message(result)){
                $.each(result, function (i, item) {
                    service.append($('<option>', { 
                        value: item.factorid,
                        text : 'نام کاربری اکانتینگ: '+' '+Getor_String(item.ibsusername, '---') + ' ' + '(' +' سرویس ' + Getor_String(item.sertype, '---')+')'
                    }));
                });
                operationtype.empty();
                operationtype.append($('<option>', {
                    value: 1,
                    text: 'فعال'
                }));
                operationtype.append($('<option>', {
                    value: 2,
                    text: 'تعلیق دوطرفه'
                }));
                operationtype.append($('<option>', {
                    value: 3,
                    text: 'تخلیه'
                }));
                operationtype.append($('<option>', {
                    value: 4,
                    text: 'تعلیق یک طرفه'
                }));
                operationtype.append($('<option>', {
                    value: 5,
                    text: 'سلب امتیاز'
                }));
                operationtype.append($('<option>', {
                    value: 6,
                    text: 'مسدودی'
                }));

                operationtype.prop("selectedIndex","-1");
            } else{
                display_Predefiend_Messages(result);
            }
            
        });
    });
    ///bana be noe amaliat form taghir mikonad

    operationtype.on('change',function(e){
        if($(this).val()==='1'){
            masdoditime.hide();
            // let masdod='<label class="col-form-label col-md-2 masdoditime">مدت زمان مسدودی</label>'+
            //     '<div class="col-md-4 masdoditime">'+
            //         '<select class="form-control form-control-md custom_select" required name="time" id="time">'+
            //             '<option value="1">۲۴ ساعت</option>'+
            //             '<option value="2">۴۸ ساعت</option>'+
            //             '<option value="3">۷۲ ساعت</option>'+
            //             '<option value="7">یک هفته</option>'+
            //             '<option value="14">دو هفته</option>'+
            //             '<option value="30">یک ماه</option>'+
            //             '<option value="0">بدون محدودیت</option>'+
            //             '</select></div>';
            // $(".form-group").append(masdod);
        }else{
            masdoditime.show();
        }
    });
});