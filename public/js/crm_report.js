$(document).ready(function() {
    $("form").submit(function(e) {
        ajaxForms(e,$(this));
    });
    let type=("#type");
    DATEPICKER_YYYYMMDD('#fd');
    DATEPICKER_YYYYMMDD('#td');
    

});