$(document).ready(function() {
    let charge_amount= $("#charge_amount");
    let charge_amount_persian= $("#charge_amount_persian");
    thousandCommaSep(charge_amount);
    charge_amount.keyup(function(){
        charge_amount_persian.text(charge_amount.val().num2persian()+" "+ "ریال");
    });
});