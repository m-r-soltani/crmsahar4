$(document).ready(function () {
    DATEPICKER_YYYYMMDD('#start_date');
    DATEPICKER_YYYYMMDD('#end_date');
    let form_sms_div=$("#form_sms_div");
    let send_to=$("#send_to");
    send_to.append('<option value="1">ارسال نظیر (از پیش ساخته)</option>');
    send_to.append('<option value="3">ارسال نظیر (ایجاد دستی پیام)</option>');
    send_to.append('<option value="2">ارسال گروهی</option>');
    send_to.prop("selectedIndex",'-1');
    send_to.on('change',function () {
        switch (send_to.val()) {
            case '1':
                $(".group_sends").remove();
                $(".manual_single_sends").remove();
                form_sms_div.append("<label class='col-form-label col-lg-2 single_sends'>شماره موبایل</label>");
                form_sms_div.append("<div class='col-lg-4 single_sends'>" +
                    "<input class='form-control form-control-lg' type='text' id = 'single_phone_number' name='single_phone_number'>"+
                    "</div>");
                form_sms_div.append("<label class='col-form-label col-lg-2 single_sends' style='margin-top: 5px'>انتخاب پیام</label>");
                form_sms_div.append(
                    "<div class='col-lg-10 single_sends' style='margin-top: 5px'>" +
                        "<select class='form-control form-control-lg custom_select single_sends' required name='single_message' id='single_message'>"+
                        '</select>'+
                    "</div>");
                    Initialize('get_messages_list_shortend',function(data){
                        let single_message=$("#single_message");
                        for (let i = 0; i < data.length; i++) {
                            single_message.append('<option value=' + data[i].id + '>' + data[i].message_subject + '(' + data[i].message + ')' + '</option>');
                        }
                        single_message.select2();
                    });
                break;
            case '2':
                $(".single_sends").remove();
                $(".manual_single_sends").remove();
                form_sms_div.append("<label class='col-form-label col-lg-2 group_sends'>انتخاب گروه (بانک)<label>");
                form_sms_div.append("<div class='col-lg-4 group_sends'>" +
                    "<select class='form-control form-control-lg custom_select group_sends' required name='bank_id' id='bank_id'>"+
                    '</select>'+
                    "</div>");
                    form_sms_div.append("<label class='col-form-label col-lg-2 group_sends'>انتخاب پیام<label>");
                form_sms_div.append("<div class='col-lg-10 group_sends'>" +
                    "<select class='form-control form-control-lg custom_select group_sends' required name='message_id' id='message_id'>"+
                    '</select>'+
                    "</div>");
                    Initialize('get_messages_list_shortend',function(data){
                        let message_id=$("#message_id");
                        for (let i = 0; i < data.length; i++) {
                            message_id.append('<option value=' + data[i].id + '>' + data[i].message_subject + '(' + data[i].message + ')' + '</option>');
                        }
                        message_id.select2();
                    });
                    Initialize('getassignedbanks',function(data){
                        console.log(data);
                        let bank_id=$("#bank_id");
                        for (let i = 0; i < data.length; i++) {
                            bank_id.append('<option value=' + data[i].id + '>' + data[i].name + '(' + data[i].file_subject + ')' + '</option>');
                        }
                        bank_id.select2();
                    });
                break;
                case '3':
                $(".single_sends").remove();
                $(".group_sends").remove();
                form_sms_div.append("<label class='col-form-label col-lg-2 manual_single_sends'>شماره موبایل</label>");
                form_sms_div.append("<div class='col-lg-4 manual_single_sends'>" +
                    "<input class='form-control form-control-lg' type='text' id = 'single_phone_number' name='single_phone_number'>"+
                    "</div>");
                form_sms_div.append("<label class='col-form-label col-lg-2 manual_single_sends' style='margin-top: 5px'>متن پیام</label>");
                form_sms_div.append(
                    "<div class='col-lg-10 manual_single_sends'> <textarea type='text' style='height: 200px;' id='message' class='form-control manual_single_sends' required name='message' ></textarea></div>" 
                );
                break;
            default:
                alert('خطا دربرنامه');
                break;
        }
    });
});