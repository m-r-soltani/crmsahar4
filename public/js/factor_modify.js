$(document).ready(function() {
    Initialize_two_param('factor_modify', '', function(data) {
        let factor_id = $("#factor_id");
        let noe_taghir = $("#noe_taghir");
        noe_taghir.prop("selectedIndex", "-1");
        factor_id.select2();
        for (let i = 0; i < data.length; i++) {
            if (data[0]['id']) {
                factor_id.append('<option value=' + data[i].id + '>' + data[i].id + '</option>');
            }
        }

    });
});