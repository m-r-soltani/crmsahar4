$(document).ready(function() {
    Initialize('personal_information', function(data) {
        console.log(data);
        if (!data['Error']) {
            switch (data[0]['noe_moshtarak']) {
                case 'real':
                    let tarikhe_tabalod = data[0]['tarikhe_tavalod'].split("-");
                    if (tarikhe_tabalod.length > 2) {
                        let tarikhe_tabalod_res = gregorian_to_jalali(parseInt(tarikhe_tabalod[0]), parseInt(tarikhe_tabalod[1]), parseInt(tarikhe_tabalod[2]));
                        tarikhe_tabalod_res[0] = tarikhe_tabalod_res[0].toString();
                        tarikhe_tabalod_res[1] = tarikhe_tabalod_res[1].toString();
                        tarikhe_tabalod_res[2] = tarikhe_tabalod_res[2].toString();
                        data[0]['tarikhe_tavalod'] = tarikhe_tabalod_res[0].toPersinaDigit() + '/' + tarikhe_tabalod_res[1].toPersinaDigit() + '/' + tarikhe_tabalod_res[2].toPersinaDigit();
                    }
                    //tabdile miladi be shamsi+tabdile adade englisi be farsi
                    $('#id').val(data[0]['id']);
                    $('#name').val(data[0]['name']);
                    $('#noe_moshtarak').val(data[0]['noe_moshtarak']);
                    $('#f_name').val(data[0]['f_name']);
                    $('#name_pedar').val(data[0]['name_pedar']);
                    $('#meliat').val(data[0]['meliat']);
                    $('#tabeiat').val(data[0]['tabeiat']);
                    $('#code_meli').val(data[0]['code_meli']);
                    $('#shomare_shenasname').val(data[0]['shomare_shenasname']);
                    $('#tarikhe_tavalod').val(data[0]['tarikhe_tavalod']);
                    $('#ostane_tavalod').val(data[0]['ostane_tavalod']);
                    $('#shahre_tavalod').val(data[0]['shahre_tavalod']);
                    $('#telephone1').val(data[0]['telephone1']);
                    $('#telephone2').val(data[0]['telephone2']);
                    $('#telephone3').val(data[0]['telephone3']);
                    $('#telephone_hamrah').val(data[0]['telephone_hamrah']);
                    $('#email').val(data[0]['email']);
                    $('#fax').val(data[0]['fax']);
                    $('#website').val(data[0]['website']);
                    $('#code_posti1').val(data[0]['code_posti1']);
                    $('#code_posti2').val(data[0]['code_posti2']);
                    $('#code_posti3').val(data[0]['code_posti3']);
                    $('#address1').val(data[0]['address1']);
                    $('#address2').val(data[0]['address2']);
                    $('#address3').val(data[0]['address3']);
                    $('#shoghl').val(data[0]['shoghl']);
                    $('#moaref').val(data[0]['moaref']);
                    $('#tozihat').val(data[0]['tozihat']);
                    //aks
                    if (data[0]['r_t_karte_meli'] && data[0]['r_t_karte_meli'] !== '') {
                        $("#linkrtkartemeli").remove();
                        $('#link_r_t_karte_meli').append("<a id ='linkrtkartemeli' target='_blank' href=" + window.location.origin + '/public/images/' + data[0]['r_t_karte_meli'] + ">مشاهده تصویر</a>");
                    }
                    if (data[0]['r_t_ghabze_telephone'] && data[0]['r_t_ghabze_telephone'] !== '') {
                        $('#linkrtghabzetelephone').remove();
                        $('#link_r_t_ghabze_telephone').append("<a id ='linkrtghabzetelephone' target='_blank' href=" + window.location.origin + '/public/images/' + data[0]['r_t_ghabze_telephone'] + ">مشاهده تصویر</a>");
                    }
                    if (data[0]['r_t_ejare_malekiat'] && data[0]['r_t_ejare_malekiat'] !== '') {
                        $('#linkrtejaremalekiat').remove();
                        $('#link_r_t_ejare_malekiat').append("<a id ='linkrtejaremalekiat' target='_blank' href=" + window.location.origin + '/public/images/' + data[0]['r_t_ejare_malekiat'] + ">مشاهده تصویر</a>");
                    }
                    if (data[0]['r_t_gharardad'] && data[0]['r_t_gharardad'] !== '') {
                        $('#linkrtgharardad').remove();
                        $('#link_r_t_gharardad').append("<a id ='linkrtgharardad' target='_blank' href=" + window.location.origin + '/public/images/' + data[0]['r_t_gharardad'] + ">مشاهده تصویر</a>");
                    }
                    if (data[0]['r_t_sayer'] && data[0]['r_t_sayer'] !== '') {
                        $('#linkrt_sayer').remove();
                        $('#link_r_t_sayer').append("<a id ='linkrt_sayer' target='_blank' href=" + window.location.origin + '/public/images/' + data[0]['r_t_sayer'] + ">مشاهده تصویر</a>");
                    }
                    //aks
                    $('#gorohe_moshtarak option[value="' + data[0]["gorohe_moshtarak"] + '"]').attr('selected', 'selected');
                    $('#nahve_ashnai option[value="' + data[0]["nahve_ashnai"] + '"]').attr('selected', 'selected');
                    $('#noe_shenase_hoviati option[value="' + data[0]["noe_shenase_hoviati"] + '"]').attr('selected', 'selected');
                    $('#jensiat option[value="' + data[0]["jensiat"] + '"]').attr('selected', 'selected');

                    break;
                case 'legal':
                    data[0]['tarikhe_sabt'] = tabdile_tarikh_adad(data[0]['tarikhe_sabt']);
                    data[0]['tarikhe_tavalod'] = tabdile_tarikh_adad(data[0]['tarikhe_tavalod']);
                    $('#tarikhe_tavalod').val(data[0]['tarikhe_tavalod']);
                    $('#tarikhe_sabt').val(data[0]['tarikhe_sabt']);
                    //tabdile miladi be shamsi+tabdile adade englisi be farsi
                    $('#id').val(data[0]['id']);
                    $('#name_en').val(data[0]['name_en']);
                    $('#name_pedare').val(data[0]['name_pedare']);
                    $('#noe_moshtarak').val(data[0]['noe_moshtarak']);
                    $('#name_sherkat').val(data[0]['name_sherkat']);
                    $('#shomare_sabt').val(data[0]['shomare_sabt']);
                    $('#name').val(data[0]['name']);
                    $('#f_name').val(data[0]['f_name']);
                    $('#meliat').val(data[0]['meliat']);
                    $('#tabeiat').val(data[0]['tabeiat']);
                    $('#ostane_tavalod').val(data[0]['ostane_tavalod']);
                    $('#shahre_tavalod').val(data[0]['shahre_tavalod']);
                    $('#shenase_meli').val(data[0]['shenase_meli']);
                    $('#telephone1').val(data[0]['telephone1']);
                    $('#telephone2').val(data[0]['telephone2']);
                    $('#telephone3').val(data[0]['telephone3']);
                    $('#shomare_dakheli').val(data[0]['shomare_dakheli']);
                    $('#telephone_hamrah').val(data[0]['telephone_hamrah']);
                    $('#email').val(data[0]['email']);
                    $('#fax').val(data[0]['fax']);
                    $('#website').val(data[0]['website']);
                    $('#code_posti1').val(data[0]['code_posti1']);
                    $('#code_posti2').val(data[0]['code_posti2']);
                    $('#code_posti3').val(data[0]['code_posti3']);
                    $('#address1').val(data[0]['address1']);
                    $('#address2').val(data[0]['address2']);
                    $('#address3').val(data[0]['address3']);
                    $('#code_eghtesadi').val(data[0]['code_eghtesadi']);
                    $('#code_meli').val(data[0]['code_meli']);
                    $('#shomare_shenasname').val(data[0]['shomare_shenasname']);
                    $('#name_pedar').val(data[0]['name_pedar']);
                    $('#reshteye_faaliat').val(data[0]['reshteye_faaliat']);
                    $('#moaref').val(data[0]['moaref']);
                    $('#tozihat').val(data[0]['tozihat']);
                    ///aks
                    if (data[0]['l_t_agahie_tasis'] && data[0]['l_t_agahie_tasis'] !== '') {
                        $("#linkltagahietasis").remove();
                        $('#link_l_t_agahie_tasis').append("<a id ='linkltagahietasis' target='_blank' href=" + window.location.origin + '/public/images/' + data[0]['l_t_agahie_tasis'] + ">مشاهده تصویر</a>");
                    }
                    if (data[0]['l_t_akharin_taghirat'] && data[0]['l_t_akharin_taghirat'] !== '') {
                        $("#linkltakharintaghirat").remove();
                        $('#link_l_t_akharin_taghirat').append("<a id ='linkltakharintaghirat' target='_blank' href=" + window.location.origin + '/public/images/' + data[0]['l_t_akharin_taghirat'] + ">مشاهده تصویر</a>");
                    }
                    if (data[0]['l_t_saheb_kartemeli_emzaye_aval'] && data[0]['l_t_saheb_kartemeli_emzaye_aval'] !== '') {
                        $('#linkltsahebkartemeliemzaye_aval').remove();
                        $('#link_l_t_saheb_kartemeli_emzaye_aval').append("<a id ='linkltsahebkartemeliemzaye_aval' target='_blank' href=" + window.location.origin + '/public/images/' + data[0]['l_t_saheb_kartemeli_emzaye_aval'] + ">مشاهده تصویر</a>");
                    }
                    if (data[0]['l_t_saheb_kartemeli_emzaye_dovom'] && data[0]['l_t_saheb_kartemeli_emzaye_dovom'] !== '') {
                        $('#linkltsahebkartemeliemzaye_dovom').remove();
                        $('#link_l_t_saheb_kartemeli_emzaye_dovom').append("<a id ='linkltsahebkartemeliemzaye_dovom' target='_blank' href=" + window.location.origin + '/public/images/' + data[0]['l_t_saheb_kartemeli_emzaye_dovom'] + ">مشاهده تصویر</a>");
                    }
                    if (data[0]['l_t_kartemeli_namayande'] && data[0]['l_t_kartemeli_namayande'] !== '') {
                        $('#linkltkartemelinamayande').remove();
                        $('#link_l_t_kartemeli_namayande').append("<a id ='linkltkartemelinamayande' target='_blank' href=" + window.location.origin + '/public/images/' + data[0]['l_t_kartemeli_namayande'] + ">مشاهده تصویر</a>");
                    }
                    if (data[0]['l_t_moarefiname_namayande'] && data[0]['l_t_moarefiname_namayande'] !== '') {
                        $('#linkltmoarefinamenamayande').remove();
                        $('#link_l_t_moarefiname_namayande').append("<a id ='linkltmoarefinamenamayande' target='_blank' href=" + window.location.origin + '/public/images/' + data[0]['l_t_moarefiname_namayande'] + ">مشاهده تصویر</a>");
                    }
                    if (data[0]['l_t_ghabze_telephone'] && data[0]['l_t_ghabze_telephone'] !== '') {
                        $('#linkltghabzetelephone').remove();
                        $('#link_l_t_ghabze_telephone').append("<a id ='linkltghabzetelephone' target='_blank' href=" + window.location.origin + '/public/images/' + data[0]['l_t_ghabze_telephone'] + ">مشاهده تصویر</a>");
                    }
                    if (data[0]['l_t_gharardad'] && data[0]['l_t_gharardad'] !== '') {
                        $('#linkltgharardad').remove();
                        $('#link_l_t_gharardad').append("<a id ='linkltgharardad' target='_blank' href=" + window.location.origin + '/public/images/' + data[0]['l_t_gharardad'] + ">مشاهده تصویر</a>");
                    }
                    if (data[0]['l_t_ejarename_malekiat'] && data[0]['l_t_ejarename_malekiat'] !== '') {
                        $('#linkltejarenamemalekiat').remove();
                        $('#link_l_t_ejarename_malekiat').append("<a id ='linkltejarenamemalekiat' target='_blank' href=" + window.location.origin + '/public/images/' + data[0]['l_t_ejarename_malekiat'] + ">مشاهده تصویر</a>");
                    }
                    if (data[0]['l_t_sayer'] && data[0]['l_t_sayer'] !== '') {
                        $('#linkltsayer').remove();
                        $('#link_l_t_sayer').append("<a id ='linkltsayer' target='_blank' href=" + window.location.origin + '/public/images/' + data[0]['l_t_sayer'] + ">مشاهده تصویر</a>");
                    }
                    ///aks
                    $('#jensiat option[value="' + data[0]["jensiat"] + '"]').attr('selected', 'selected');
                    $('#nahve_moarefi option[value="' + data[0]["nahve_moarefi"] + '"]').attr('selected', 'selected');
                    $('#nahve_ashnai option[value="' + data[0]["nahve_ashnai"] + '"]').attr('selected', 'selected');
                    $('#gorohe_moshtarak option[value="' + data[0]["gorohe_moshtarak"] + '"]').attr('selected', 'selected');
                    $('#noe_shenase_hoviati option[value="' + data[0]["noe_shenase_hoviati"] + '"]').attr('selected', 'selected');

                    break;

                default:
                    break;
            }
        } else if (data['Error']) alert(data['Error']);
        else alert('خطا در برنامه');
    });
});