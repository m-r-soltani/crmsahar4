$(document).ready(function() {
    $("form").submit(function(e) {
        ajaxForms(e, $(this));
    });
    ////////////////////New Ticket
    let new_sub=$("#new_sub");
    let send_newcomment=("#send_newcomment");
    let new_olaviat=$("#new_olaviat");
    let new_tabaghe=$("#new_tabaghe");
    let newc_tiid=$("#newc_tiid");
    let opentickets=$("#opentickets");
    let modal_ticketspreview= $("#modal_ticketspreview");
    let tickethistory=$("#tickethistory");
    opentickets.select2();
    new_sub.select2();
    new_olaviat.select2();
    new_tabaghe.select2();
    ajaxRequest('getAsiatechBitstreamBeforeAndAfterPortReserveUsers', {a:false}, window.location.href.split('/').slice(-1)[0], function(result) {
        if (check_isset_message(result)) {
            display_Predefiend_Messages(result);
        } else {
            $.each(result, function(i, item) {
                if(item.port){
                    new_sub.append($('<option>', {
                        value: item.ossid,
                        text: Getor_String(item.reallegal_name, '---') + ' / ' + ' ' + 'تلفن: ' + ' ' + Getor_String(item.tel, '---')
                    }));
                }else{
                    new_sub.append($('<option>', {
                        value: item.ossid,
                        text: Getor_String(item.reallegal_name, '---') + ' / ' + ' ' + 'تلفن: ' + ' ' + Getor_String(item.tel, '---') + ' / ' + ' بدون پورت '
                    }));
                }
            });
        }
    });
    
    ///////////////////Preview Ticket
    
    ajaxRequest('getAsiatechBitstreamOpenTickets', {a:false}, window.location.href.split('/').slice(-1)[0], function(result) {
        console.log(11);
        console.log(result);
        console.log(11);
        if (check_isset_message(result)) {
            // display_Predefiend_Messages(res);
        } else {
            $.each(result, function(i, item) {
                opentickets.append($('<option>', {
                    value: item.id,
                    text: Getor_String(item.rlname, '---') + ' / ' + ' تلفن: ' + ' ' + Getor_String(item.tel, '---')+ ' / ' + ' عنوان: ' + Getor_String(item.onvan50, '---') + ' / ' + ' تاریخ: ' +Getor_String(item.fmtarikh, '---')
                }));
            });
        }
    });
    

    opentickets.on('change', function(){
        newc_tiid.val(opentickets.val());
        ajaxRequest('getAsiatechBitstreamTicketHistoryAndDetail', {'tiid': opentickets.val()}, window.location.href.split('/').slice(-1)[0], function(result) {
            console.log(result);
            if (check_isset_message(result)) {
                display_Predefiend_Messages(res);
            }else{
                tickethistory.empty();
                let onvan='';
                let description='';
                let chat='';
                let onvantext='عنوان : ';
                let desctext='تیکت : ';
                onvan='<label class="row col-sm-12 text-left bg-info rounded" style="font-size: 14px;margin: 10px 10px 0 10px !important;padding:10px;width: fit-content;">'+onvantext+result['onvan']+'</label>'
                description='<label class="row col-sm-12 text-left bg-info rounded" style="font-size: 14px;margin: 10px 10px 0 10px !important;padding:10px;width: fit-content;">'+desctext+result['description']+'</label>'
                tickethistory.append(onvan);
                tickethistory.append(description);
                for (let i = 0; i < result['chat'].length; i++) {
                    
                    if(result['chat'][i]['whoisit']==='comment'){
                        chat+='<label class="row col-sm-12 text-left bg-info rounded" style="font-size: 14px;margin: 10px 10px 0 10px !important;padding:10px;width: fit-content;">'+result['chat'][i]['operator']+' : '+result['chat'][i]['comment']+'</label>';
                    }else{
                        chat+='<label class="row col-sm-12 text-right bg-grey rounded" style="font-size: 14px;margin: 10px 10px 0 10px !important;padding:10px;width: fit-content;">'+result['chat'][i]['operator']+' : '+result['chat'][i]['comment']+'</label>'
                    }
                }
                tickethistory.append(chat);                
                modal_ticketspreview.modal('toggle');
            }
        });
        
    });

    
    /////////new comment
    // send_newcomment.on('click',function(e){
    //     ajaxRequest('sendAsiatechBitstreamNewComment', {'tiid': opentickets.val()}, window.location.href.split('/').slice(-1)[0], function(result) {
    //         console.log(result);
    //         if (check_isset_message(result)) {
    //             display_Predefiend_Messages(result);
    //         }else{
    //             display_Predefiend_Messages();
    //         }
    //     });
    // });
    //////////////////////history
    
});
