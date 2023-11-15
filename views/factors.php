<!-- Content area -->
<div class="content">
    <!--datatable-->
    <div class="card" style="padding: 2px;">
        <div class="col-md-12">
            <button name="initconfirm" class="btn btn-primary col-md-auto float-md-right" id="initconfirm">جستجو<i
                        class="icon-database-edit2 ml-2"></i></button>
            <table id="view_table" class="table table-striped datatable-responsive table-hover">
            </table>
        </div>
    </div>
    <!--/datatable-->
    <!-- boxes -->
    <div class="card" id="st_tab_boxes">
        <div class="card-body factors_tab1 col-lg-12">
            <div class="init_boxes" id="ekhtesase_emkanat_box">اختصاص امکانات</div>
            <div class="init_boxes" id="sefareshe_jadid_box">سفارش جدید</div>
            <div class="init_boxes" id="faktorha_box">فاکتور ها</div>
            <!-- <div class="init_boxes" id="pardakhtha">پرداخت ها</div> -->
            <!-- <div class="init_boxes" id="online_user">گزارش کاربری</div>
            <div class="init_boxes" id="connection_log">گزارش اتصال</div> -->
            <!-- <div class="init_boxes" id="moshkelat_box">مشکلات</div> -->
        </div>
    </div>
    <!-- boxes -->
    <div class="card" id="ekhtesase_emkanat_tab">
        <div class="card-body">
            <div class="col-lg-12" style="position: relative;float: right;display: inline-block">
                <!--<legend class="text-uppercase font-size-sm font-weight-bold">سرویس ها</legend>-->
                <ul class="nav nav-tabs nav-tabs-bottom border-bottom-0 nav-justified">

                    <li class="nav-item">
                        <a href="#ekhtesas-justified-divided-tab1" id="ekhtesas_adsl_tab_link"
                           class="nav-link ekhtesas_tabs" data-toggle="tab">ADSL</a>
                    </li>
                    <li class="nav-item">
                        <a href="#ekhtesas-justified-divided-tab2" id="ekhtesas_vdsl_tab_link"
                           class="nav-link ekhtesas_tabs" data-toggle="tab">VDSL</a>
                    </li>
                    <li class="nav-item">
                        <a href="#ekhtesas-justified-divided-tab3" id="ekhtesas_wireless_tab_link"
                           class="nav-link ekhtesas_tabs" data-toggle="tab">Wireless</a>
                    </li>
                    <li class="nav-item">
                        <a href="#ekhtesas-justified-divided-tab4" id="ekhtesas_tdlte_tab_link"
                           class="nav-link ekhtesas_tabs" data-toggle="tab">TD-LTE/4G</a>
                    </li>
                    <li class="nav-item">
                        <a href="#ekhtesas-justified-divided-tab8" id="ekhtesas_ngn_tab_link"
                           class="nav-link ekhtesas_tabs" data-toggle="tab">NGN</a>
                    </li>

                </ul>

                <div class="tab-content">
                    <!------------Ekhtesas ADSL------------->
                    <div class="adsl_tab sefareshe_jadid_tabs tab-pane fade" data-flag="adsl"
                         id="ekhtesas-justified-divided-tab1">
                        <form action="#" method="POST" name="ekhtesase_emkanat_adsl">
                            <input type="hidden" name="ekhtesase_emkanat_user_id" id="ekhtesase_emkanat_adsl_user_id"
                                   value="empty">
                            <fieldset class="mb-3">
                                <div class="form-group row" style="position: relative;">
                                    <label class="col-form-label col-lg-2">تلفن مورد تقاضا</label>
                                    <div class="col-lg-4">
                                        <select class="form-control form-control-lg custom-select"
                                                name="ekhtesase_emkanat_adsl_telephone_morede_taghaza"
                                                id="ekhtesase_emkanat_adsl_telephone_morede_taghaza">
                                        </select>
                                    </div>

                                    <label class="col-form-label col-lg-2">مرکز مخابراتی</label>
                                    <div class="col-lg-4">
                                        <select class="form-control form-control-lg custom-select"
                                                name="ekhtesase_emkanat_adsl_name_markaz"
                                                id="ekhtesase_emkanat_adsl_name_markaz" disabled>
                                        </select>
                                    </div>

                                    <label class="col-form-label col-lg-2">تیغه</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" name="ekhtesase_emkanat_adsl_tighe"
                                               id="ekhtesase_emkanat_adsl_tighe" disabled>
                                    </div>

                                    <label class="col-form-label col-lg-2">ردیف</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" name="ekhtesase_emkanat_adsl_radif"
                                               id="ekhtesase_emkanat_adsl_radif" disabled>
                                    </div>

                                    <label class="col-form-label col-lg-2">اختصاص اتصال</label>
                                    <div class="col-lg-4">
                                        <select class="form-control form-control-lg custom-select"
                                                name="ekhtesase_emkanat_ekhtesase_adsl_etesal"
                                                id="ekhtesase_emkanat_ekhtesase_adsl_etesal">
                                        </select>
                                    </div>

                                </div>
                            </fieldset>
                            <div class="text-right">
                                <button type="submit" name="send_ekhtesase_emkanat_adsl" class="btn btn-primary">تایید<i
                                            class="icon-paperplane ml-2"></i></button>
                            </div>
                        </form>
                    </div>
                    <!------------Ekhtesas VDSL------------->
                    <div class="vdsl_tab sefareshe_jadid_tabs tab-pane fade" data-flag="vdsl"
                         id="ekhtesas-justified-divided-tab2">
                        <form action="#" method="POST" name="ekhtesase_emkanat_vdsl">
                            <input type="hidden" name="ekhtesase_emkanat_user_id" id="ekhtesase_emkanat_vdsl_user_id"
                                   value="empty">
                            <fieldset class="mb-3">
                                <div class="form-group row" style="position: relative;">
                                    <label class="col-form-label col-lg-2">تلفن مورد تقاضا</label>
                                    <div class="col-lg-4">
                                        <select class="form-control form-control-lg custom-select"
                                                name="ekhtesase_emkanat_vdsl_telephone_morede_taghaza"
                                                id="ekhtesase_emkanat_vdsl_telephone_morede_taghaza">
                                        </select>
                                    </div>

                                    <label class="col-form-label col-lg-2">مرکز مخابراتی</label>
                                    <div class="col-lg-4">
                                        <select class="form-control form-control-lg custom-select"
                                                name="ekhtesase_emkanat_vdsl_name_markaz"
                                                id="ekhtesase_emkanat_vdsl_name_markaz" disabled>
                                        </select>
                                    </div>

                                    <label class="col-form-label col-lg-2">تیغه</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" name="ekhtesase_emkanat_vdsl_tighe"
                                               id="ekhtesase_emkanat_vdsl_tighe" disabled>
                                    </div>

                                    <label class="col-form-label col-lg-2">ردیف</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" name="ekhtesase_emkanat_vdsl_radif"
                                               id="ekhtesase_emkanat_vdsl_radif" disabled>
                                    </div>

                                    <label class="col-form-label col-lg-2">اختصاص اتصال</label>
                                    <div class="col-lg-4">
                                        <select class="form-control form-control-lg custom-select"
                                                name="ekhtesase_emkanat_ekhtesase_vdsl_etesal"
                                                id="ekhtesase_emkanat_ekhtesase_vdsl_etesal">
                                        </select>
                                    </div>

                                </div>
                            </fieldset>
                            <div class="text-right">
                                <button type="submit" name="send_ekhtesase_emkanat_vdsl" class="btn btn-primary">تایید<i
                                            class="icon-paperplane ml-2"></i></button>
                            </div>
                        </form>
                    </div>
                    <!------------Ekhtesas Wireless------------->
                    <div class="wireless_tab sefareshe_jadid_tabs tab-pane fade" data-flag="wireless"
                         id="ekhtesas-justified-divided-tab3">
                        <form action="#" method="POST" name="ekhtesase_emkanat_wireless">
                            <input type="hidden" name="ekhtesase_emkanat_user_id"
                                   id="ekhtesase_emkanat_wireless_user_id" value="empty">
                            <input type="hidden" id="ekhtesas_emkanat_wireless_id" name="ekhtesas_emkanat_wireless_id"
                                   value="empty" class="form-control">
                            <!-- <input type="hidden" id="ekhtesas_emkanat_wireless_code_eshterak" name="ekhtesas_emkanat_wireless_code_eshterak" value="wireless" class="form-control"> -->
                            <fieldset class="mb-3">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-2">استان</label>
                                    <div class="col-lg-4">
                                        <select class="form-control form-control-lg custom-select"
                                                name="ekhtesas_emkanat_wireless_ostan" id="ekhtesas_emkanat_wireless_ostan">
                                        </select>
                                    </div>

                                    <label class="col-form-label col-lg-2">شهر</label>
                                    <div class="col-lg-4">
                                        <select class="form-control form-control-lg custom-select"
                                                name="ekhtesas_emkanat_wireless_shahr" id="ekhtesas_emkanat_wireless_shahr">
                                        </select>
                                    </div>

                                    <label class="col-form-label col-lg-2">نام دکل</label>
                                    <div class="col-lg-4">
                                        <select class="form-control form-control-lg custom-select"
                                                name="ekhtesas_emkanat_wireless_popsite"
                                                id="ekhtesas_emkanat_wireless_popsite">
                                        </select>
                                    </div>

                                    <label class="col-form-label col-lg-2">Wireless AP</label>
                                    <div class="col-lg-4">
                                        <select class="form-control form-control-lg custom-select"
                                                name="ekhtesas_emkanat_wireless_ap" id="ekhtesas_emkanat_wireless_ap">
                                        </select>
                                    </div>
                                    <label class="col-form-label col-lg-2">Wireless Station</label>
                                    <div class="col-lg-4">
                                        <select class="form-control form-control-lg custom-select"
                                                name="ekhtesas_emkanat_wireless_station"
                                                id="ekhtesas_emkanat_wireless_station">
                                        </select>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="text-right">
                                <button type="submit" name="send_ekhtesas_emkanat_wireless"
                                        class="btn btn-primary">تایید <i class="icon-paperplane ml-2"></i></button>
                            </div>
                        </form>
                    </div>
                    <!------------Ekhtesas TD-LTE/4G------------->
                    <div class="tdlte_tab sefareshe_jadid_tabs tab-pane fade" data-flag="tdlte"
                         id="ekhtesas-justified-divided-tab4">
                        <form action="#" method="POST" name="ekhtesase_emkanat_tdlte">
                            <fieldset class="mb-3">
                                <div class="form-group row">
                                    <input type="hidden" name="ekhtesase_emkanat_user_id"
                                           id="ekhtesase_emkanat_tdlte_user_id" value="empty">
                                    <label class="col-form-label col-lg-2">شماره سیمکارت جهت اختصاص به مشترک</label>
                                    <div class="col-lg-4">
                                        <select class="form-control form-control-lg custom-select" name="tdlte_number"
                                                id="ekhtesase_emkanat_tdlte_number">
                                        </select>
                                    </div>
                                    <label class="col-form-label col-lg-2">طول جغرافیایی</label>
                                    <div class="col-lg-4">
                                    <input type="text" class="form-control" name="tol_joghrafiai" id="ekhtesase_emkanat_tdlte_tol_joghrafiai" required>
                                    </div>

                                    <label class="col-form-label col-lg-2">عرض جغرافیایی</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" name="arz_joghrafiai" id="ekhtesase_emkanat_tdlte_arz_joghrafiai" required>
                                    </div>

                                </div>
                            </fieldset>
                            <div class="text-right">
                                <button type="submit" name="send_ekhtesase_emkanat_tdlte" class="btn btn-primary">ارسال
                                    <i class="icon-paperplane ml-2"></i></button>
                            </div>
                        </form>
                    </div>
                    <!------------Ekhtesas Voip------------->
                    <div class="voip_tab sefareshe_jadid_tabs tab-pane fade" data-flag="voip"
                         id="ekhtesas-justified-divided-tab5">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--1st tabs-->
    <div class="card" id="sefareshejadid_tab">
        <div class="card-body">
            <div class="col-lg-2" style="position: relative;float: right;display: inline-block">
                <label for="asd">انتخاب سرویس:</label>
                <ul class="sefareshe_jadid_serviceslist" id="sefareshe_jadid_serviceslist">
                </ul>
            </div>
            <div class="col-lg-10" style="position: relative;float: right;display: inline-block">
                <!--<legend class="text-uppercase font-size-sm font-weight-bold">سرویس ها</legend>-->
                <ul class="nav nav-tabs nav-tabs-bottom border-bottom-0 nav-justified">
                    <li class="nav-item services_tabs">
                        <a href="#bottom-justified-divided-tab0" id="bs_tab_link" class="nav-link"
                           data-toggle="tab">BITSTREAM</a>
                    </li>
                    <li class="nav-item services_tabs">
                        <a href="#bottom-justified-divided-tab1" id="adsl_tab_link" class="nav-link"
                           data-toggle="tab">ADSL/VDSL</a>
                    </li>
                    <li class="nav-item services_tabs">
                        <a href="#bottom-justified-divided-tab2" id="wireless_tab_link" class="nav-link"
                           data-toggle="tab">Wireless</a>
                    </li>
                    <li class="nav-item services_tabs">
                        <a href="#bottom-justified-divided-tab3" id="tdlte_tab_link" class="nav-link"
                           data-toggle="tab">TD-LTE/4G</a>
                    </li>
                    <li class="nav-item services_tabs">
                        <a href="#bottom-justified-divided-tab4" id="voip_tab_link" class="nav-link"
                           data-toggle="tab">Voip(Orgination)</a>
                    </li>
                    <!-- <li class="nav-item services_tabs">
                        <a href="#bottom-justified-divided-tab5" id="ip_adsl_tab_link" class="nav-link"
                           data-toggle="tab">IP (Adsl/Vdsl)</a>
                    </li>
                    <li class="nav-item services_tabs">
                        <a href="#bottom-justified-divided-tab6" id="ip_wireless_tab_link" class="nav-link"
                           data-toggle="tab">IP (Wireless)</a>
                    </li>
                    <li class="nav-item services_tabs">
                        <a href="#bottom-justified-divided-tab7" id="ip_tdlte_tab_link" class="nav-link"
                           data-toggle="tab">IP (Tdlte)</a>
                    </li> -->
                </ul>
                <div class="tab-content">
                    <!------------sefareshe jadid tab BITSTREAM------------->
                    <div class="bs_tab sefareshe_jadid_tabs tab-pane fade" data-flag="bs"
                         id="bottom-justified-divided-tab0">
                        <form action="" method="POST" name="sefareshe_jadid_bs">
                            <input type="hidden" id="sj_bs_subscriber_id" name="subscriber_id" value="empty"
                                   class="form-control">
                            <input type="hidden" id="sj_bs_ibs_username" name="ibs_username" value="empty"
                                   class="form-control">
                            <input type="hidden" id="sj_bs_service_id" name="service_id" value="empty"
                                   class="form-control">
                            <fieldset class="mb-3">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-2">انتخاب تلفن</label>
                                    <div class="col-lg-4">
                                        <select class="form-control form-control-lg custom-select" name="telephone"
                                                id="sj_bs_telephone">
                                        </select>
                                    </div>

                                    <label class="col-form-label col-lg-2">ترافیک(MB)</label>
                                    <div class="col-lg-4">
                                        <input name="terafik" id="sj_bs_terafik" type="text" class="form-control"
                                               placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">مدت استفاده(روز)</label>
                                    <div class="col-lg-4">
                                        <input name="zamane_estefade" id="sj_bs_zamane_estefade" type="text"
                                               class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">تاریخ شروع سرویس</label>
                                    <div class="col-lg-4">
                                        <input name="tarikhe_shoroe_service" id="sj_bs_tarikhe_shoroe_service"
                                               type="text" class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">تاریخ پایان سرویس</label>
                                    <div class="col-lg-4">
                                        <input name="tarikhe_payane_service" id="sj_bs_tarikhe_payane_service"
                                               type="text" class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">قیمت سرویس</label>
                                    <div class="col-lg-4">
                                        <input name="gheymate_service" id="sj_bs_gheymate_service" type="text"
                                               class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">تخفیف</label>
                                    <div class="col-lg-4">
                                        <input name="takhfif" id="sj_bs_takhfif" type="text" class="form-control"
                                               placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">هزینه رانژه</label>
                                    <div class="col-lg-4">
                                        <input name="hazine_ranzhe" id="sj_bs_hazine_ranzhe" type="text"
                                               class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">هزینه درانژه</label>
                                    <div class="col-lg-4">
                                        <input name="hazine_dranzhe" id="sj_bs_hazine_dranzhe" type="text"
                                               class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">هزینه نصب</label>
                                    <div class="col-lg-4">
                                        <input name="hazine_nasb" id="sj_bs_hazine_nasb" type="text"
                                               class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">آبونمان پورت</label>
                                    <div class="col-lg-4">
                                        <input name="abonmane_port" id="sj_bs_abonmane_port" type="text"
                                               class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">آبونمان فضا</label>
                                    <div class="col-lg-4">
                                        <input name="abonmane_faza" id="sj_bs_abonmane_faza" type="text"
                                               class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">آبونمان تجهیزات</label>
                                    <div class="col-lg-4">
                                        <input name="abonmane_tajhizat" id="sj_bs_abonmane_tajhizat" type="text"
                                               class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">درصد عوارض ارزش افزوده</label>
                                    <div class="col-lg-4">
                                        <input name="darsade_avareze_arzeshe_afzode"
                                               id="sj_bs_darsade_avareze_arzeshe_afzode" type="text" class="form-control"
                                               placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">مالیات ارزش افزوده</label>
                                    <div class="col-lg-4">
                                        <input name="maliate_arzeshe_afzode" id="sj_bs_maliate_arzeshe_afzode"
                                               type="text" class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">مبلغ قابل پرداخت</label>
                                    <div class="col-lg-4">
                                        <input name="mablaghe_ghabele_pardakht" id="sj_bs_mablaghe_ghabele_pardakht"
                                               type="text" class="form-control" placeholder="" readonly>
                                    </div>

                                </div>
                            </fieldset>
                            <div class="text-right">
                                <button type="submit" name="send_sefareshe_jadid_bs" id="send_sefareshe_jadid_bs"
                                        class="btn btn-primary">ارسال
                                    <i class="icon-paperplane ml-2"></i></button>
                            </div>
                        </form>
                    </div>
                    <!------------sefareshe jadid tab bitstream------------->
                    <!------------sefareshe jadid tab ADSL------------->
                    <div class="adsl_tab sefareshe_jadid_tabs tab-pane fade" data-flag="adsl"
                         id="bottom-justified-divided-tab1">
                        <form action="" method="POST" name="sefareshe_jadid_adsl">
                            <input type="hidden" id="sj_adsl_subscriber_id" name="subscriber_id" value="empty"
                                   class="form-control">
                            <input type="hidden" id="sj_adsl_ibs_username" name="ibs_username" value="empty"
                                   class="form-control">
                            <input type="hidden" id="sj_adsl_service_id" name="service_id" value="empty"
                                   class="form-control">
                            <fieldset class="mb-3">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-2">انتخاب تلفن</label>
                                    <div class="col-lg-4">
                                        <select class="form-control form-control-lg custom-select" name="port_id"
                                                id="sj_adsl_telephone">
                                        </select>
                                    </div>

                                    <label class="col-form-label col-lg-2">نوع خدمات</label>
                                    <div class="col-lg-4">
                                        <select class="form-control form-control-lg custom-select" name="noe_khadamat"
                                                id="sj_adsl_noe_khadamat">

                                        </select>
                                    </div>

                                    <label class="col-form-label col-lg-2">ترافیک(MB)</label>
                                    <div class="col-lg-4">
                                        <input name="terafik" id="sj_adsl_terafik" type="text" class="form-control"
                                               placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">مدت استفاده(روز)</label>
                                    <div class="col-lg-4">
                                        <input name="zamane_estefade" id="sj_adsl_zamane_estefade" type="text"
                                               class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">تاریخ شروع سرویس</label>
                                    <div class="col-lg-4">
                                        <input name="tarikhe_shoroe_service" id="sj_adsl_tarikhe_shoroe_service"
                                               type="text" class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">تاریخ پایان سرویس</label>
                                    <div class="col-lg-4">
                                        <input name="tarikhe_payane_service" id="sj_adsl_tarikhe_payane_service"
                                               type="text" class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">قیمت سرویس</label>
                                    <div class="col-lg-4">
                                        <input name="gheymate_service" id="sj_adsl_gheymate_service" type="text"
                                               class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">تخفیف</label>
                                    <div class="col-lg-4">
                                        <input name="takhfif" id="sj_adsl_takhfif" type="text" class="form-control"
                                               placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">هزینه رانژه</label>
                                    <div class="col-lg-4">
                                        <input name="hazine_ranzhe" id="sj_adsl_hazine_ranzhe" type="text"
                                               class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">هزینه درانژه</label>
                                    <div class="col-lg-4">
                                        <input name="hazine_dranzhe" id="sj_adsl_hazine_dranzhe" type="text"
                                               class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">هزینه نصب</label>
                                    <div class="col-lg-4">
                                        <input name="hazine_nasb" id="sj_adsl_hazine_nasb" type="text"
                                               class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">آبونمان پورت</label>
                                    <div class="col-lg-4">
                                        <input name="abonmane_port" id="sj_adsl_abonmane_port" type="text"
                                               class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">آبونمان فضا</label>
                                    <div class="col-lg-4">
                                        <input name="abonmane_faza" id="sj_adsl_abonmane_faza" type="text"
                                               class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">آبونمان تجهیزات</label>
                                    <div class="col-lg-4">
                                        <input name="abonmane_tajhizat" id="sj_adsl_abonmane_tajhizat" type="text"
                                               class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">درصد عوارض ارزش افزوده</label>
                                    <div class="col-lg-4">
                                        <input name="darsade_avareze_arzeshe_afzode"
                                               id="sj_adsl_darsade_avareze_arzeshe_afzode" type="text" class="form-control"
                                               placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">مالیات ارزش افزوده</label>
                                    <div class="col-lg-4">
                                        <input name="maliate_arzeshe_afzode" id="sj_adsl_maliate_arzeshe_afzode"
                                               type="text" class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">مبلغ قابل پرداخت</label>
                                    <div class="col-lg-4">
                                        <input name="mablaghe_ghabele_pardakht" id="sj_adsl_mablaghe_ghabele_pardakht"
                                               type="text" class="form-control" placeholder="" readonly>
                                    </div>

                                </div>
                            </fieldset>
                            <div class="text-right">
                                <button type="submit" name="send_sefareshe_jadid_adsl" id="send_sefareshe_jadid_adsl"
                                        class="btn btn-primary">ارسال
                                    <i class="icon-paperplane ml-2"></i></button>
                            </div>
                        </form>
                    </div>
                    <!------------sefareshe jadid tab adsl------------->
                    <!------------sefareshe jadid tab Wireless------------->
                    <div class="wireless_tab sefareshe_jadid_tabs tab-pane fade" data-flag="wireless"
                         id="bottom-justified-divided-tab2">
                        <form action="" method="POST" name="sefareshe_jadid_wireless">
                            <input type="hidden" id="sj_wireless_subscriber_id" name="subscriber_id" value="empty"
                                   class="form-control">
                            <input type="hidden" id="sj_wireless_service_id" name="service_id" value="empty"
                                   class="form-control">
                            <fieldset class="mb-3">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-2">نام ایستگاه</label>
                                    <div class="col-lg-4">
                                        <select class="form-control form-control-lg custom-select" name="istgah_name"
                                                id="sj_wireless_istgah_name">

                                        </select>
                                    </div>

                                    <label class="col-form-label col-lg-2">نوع خدمات</label>
                                    <div class="col-lg-4">
                                        <select class="form-control form-control-lg custom-select" name="noe_khadamat"
                                                id="sj_wireless_noe_khadamat">
                                            <option value="Wireless(Share)">Wireless Share</option>
                                            <option value="Wireless(Transport)">Wireless Transport</option>
                                            <option value="Wireless(Hotspot)">Wireless Hotspot</option>
                                        </select>
                                    </div>

                                    <label class="col-form-label col-lg-2">ترافیک(MB)</label>
                                    <div class="col-lg-4">
                                        <input name="terafik" id="sj_wireless_terafik" type="text" class="form-control"
                                               placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">مدت استفاده(روز)</label>
                                    <div class="col-lg-4">
                                        <input name="zamane_estefade" id="sj_wireless_zamane_estefade" type="text"
                                               class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">تاریخ شروع سرویس</label>
                                    <div class="col-lg-4">
                                        <input name="tarikhe_shoroe_service" id="sj_wireless_tarikhe_shoroe_service"
                                               type="text" class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">تاریخ پایان سرویس</label>
                                    <div class="col-lg-4">
                                        <input name="tarikhe_payane_service" id="sj_wireless_tarikhe_payane_service"
                                               type="text" class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">قیمت سرویس</label>
                                    <div class="col-lg-4">
                                        <input name="gheymate_service" id="sj_wireless_gheymate_service" type="text"
                                               class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">تخفیف</label>
                                    <div class="col-lg-4">
                                        <input name="takhfif" id="sj_wireless_takhfif" type="text" class="form-control"
                                               placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">هزینه نصب</label>
                                    <div class="col-lg-4">
                                        <input name="hazine_nasb" id="sj_wireless_hazine_nasb" type="text"
                                               class="form-control" placeholder="">
                                    </div>


                                    <label class="col-form-label col-lg-2">آبونمان پورت</label>
                                    <div class="col-lg-4">
                                        <input name="abonmane_port" id="sj_wireless_abonmane_port" type="text"
                                               class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">آبونمان فضا</label>
                                    <div class="col-lg-4">
                                        <input name="abonmane_faza" id="sj_wireless_abonmane_faza" type="text"
                                               class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">آبونمان تجهیزات</label>
                                    <div class="col-lg-4">
                                        <input name="abonmane_tajhizat" id="sj_wireless_abonmane_tajhizat" type="text"
                                               class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">درصد عوارض ارزش افزوده</label>
                                    <div class="col-lg-4">
                                        <input name="darsade_avareze_arzeshe_afzode"
                                               id="sj_wireless_darsade_avareze_arzeshe_afzode" type="text"
                                               class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">مالیات ارزش افزوده</label>
                                    <div class="col-lg-4">
                                        <input name="maliate_arzeshe_afzode" id="sj_wireless_maliate_arzeshe_afzode"
                                               type="text" class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">مبلغ قابل پرداخت</label>
                                    <div class="col-lg-4">
                                        <input name="mablaghe_ghabele_pardakht"
                                               id="sj_wireless_mablaghe_ghabele_pardakht" type="text" class="form-control"
                                               placeholder="" readonly>
                                    </div>

                                </div>
                            </fieldset>
                            <div class="text-right">
                                <button type="submit" name="send_sefareshe_jadid_wireless"
                                        id="send_sefareshe_jadid_wireless" class="btn btn-primary">ارسال <i
                                            class="icon-paperplane ml-2"></i></button>
                            </div>
                        </form>
                    </div>
                    <!------------sefareshe jadid tab Wireless/------------->
                    <!------------sefareshe jadid tab TD-LTE/4G------------->
                    <div class="tdlte_tab sefareshe_jadid_tabs tab-pane fade" data-flag="tdlte"
                         id="bottom-justified-divided-tab3">
                        <form action="" method="POST" name="sefareshe_jadid_tdlte">
                            <input type="hidden" id="sj_tdlte_subscriber_id" name="subscriber_id" value="empty"
                                   class="form-control">
                            <input type="hidden" id="sj_tdlte_service_id" name="service_id" value="empty"
                                   class="form-control">
                            <fieldset class="mb-3">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-2">شماره سیمکارت</label>
                                    <div class="col-lg-4">
                                        <select class="form-control form-control-lg custom-select" name="emkanat_id"
                                                id="sj_tdlte_tdlte_number" required>

                                        </select>
                                    </div>
                                    <label class="col-form-label col-lg-2">نوع خدمات</label>
                                    <div class="col-lg-4">
                                        <select class="form-control form-control-lg custom-select" name="noe_khadamat"
                                                id="sj_tdlte_noe_khadamat">
                                            <option value="TD-LTE(Share)">TD-LTE Share</option>
                                            <option value="TD-LTE(Transport)">TD-LTE Transport</option>
                                        </select>
                                    </div>

                                    <label class="col-form-label col-lg-2">ترافیک(MB)</label>
                                    <div class="col-lg-4">
                                        <input name="terafik" id="sj_tdlte_terafik" type="text" class="form-control"
                                               placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">مدت استفاده(روز)</label>
                                    <div class="col-lg-4">
                                        <input name="zamane_estefade" id="sj_tdlte_zamane_estefade" type="text"
                                               class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">تاریخ شروع سرویس</label>
                                    <div class="col-lg-4">
                                        <input name="tarikhe_shoroe_service" id="sj_tdlte_tarikhe_shoroe_service"
                                               type="text" class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">تاریخ پایان سرویس</label>
                                    <div class="col-lg-4">
                                        <input name="tarikhe_payane_service" id="sj_tdlte_tarikhe_payane_service"
                                               type="text" class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">قیمت سرویس</label>
                                    <div class="col-lg-4">
                                        <input name="gheymate_service" id="sj_tdlte_gheymate_service" type="text"
                                               class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">تخفیف</label>
                                    <div class="col-lg-4">
                                        <input name="takhfif" id="sj_tdlte_takhfif" type="text" class="form-control"
                                               placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">هزینه نصب</label>
                                    <div class="col-lg-4">
                                        <input name="hazine_nasb" id="sj_tdlte_hazine_nasb" type="text"
                                               class="form-control" placeholder="">
                                    </div>


                                    <label class="col-form-label col-lg-2">آبونمان پورت</label>
                                    <div class="col-lg-4">
                                        <input name="abonmane_port" id="sj_tdlte_abonmane_port" type="text"
                                               class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">آبونمان فضا</label>
                                    <div class="col-lg-4">
                                        <input name="abonmane_faza" id="sj_tdlte_abonmane_faza" type="text"
                                               class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">آبونمان تجهیزات</label>
                                    <div class="col-lg-4">
                                        <input name="abonmane_tajhizat" id="sj_tdlte_abonmane_tajhizat" type="text"
                                               class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">درصد عوارض ارزش افزوده</label>
                                    <div class="col-lg-4">
                                        <input name="darsade_avareze_arzeshe_afzode"
                                               id="sj_tdlte_darsade_avareze_arzeshe_afzode" type="text"
                                               class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">مالیات ارزش افزوده</label>
                                    <div class="col-lg-4">
                                        <input name="maliate_arzeshe_afzode" id="sj_tdlte_maliate_arzeshe_afzode"
                                               type="text" class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">مبلغ قابل پرداخت</label>
                                    <div class="col-lg-4">
                                        <input name="mablaghe_ghabele_pardakht" id="sj_tdlte_mablaghe_ghabele_pardakht"
                                               type="text" class="form-control" placeholder="" readonly>
                                    </div>

                                </div>
                            </fieldset>
                            <div class="text-right">
                                <button type="submit" name="send_sefareshe_jadid_tdlte" id="send_sefareshe_jadid_tdlte"
                                        class="btn btn-primary">ارسال <i class="icon-paperplane ml-2"></i></button>
                            </div>
                        </form>
                    </div>
                    <!------------sefareshe jadid tab TD-LTE/4G/------------->
                    <!------------sefareshe jadid tab Voip------------->
                    <div class="voip_tab sefareshe_jadid_tabs tab-pane fade" data-flag="voip"
                         id="bottom-justified-divided-tab4">
                        <form action="" method="POST" name="sefareshe_jadid_voip">
                            <input type="hidden" id="sj_voip_subscriber_id" name="subscriber_id" value="empty"
                                   class="form-control">
                            <input type="hidden" id="sj_voip_service_id" name="service_id" value="empty"
                                   class="form-control">
                            <fieldset class="mb-3">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-2">انتخاب تلفن</label>
                                    <div class="col-lg-4">
                                        <select class="form-control form-control-lg custom-select" name="ibs_username"
                                                id="sj_voip_ibs_username">

                                        </select>
                                    </div>

                                    <label class="col-form-label col-lg-2">نوع خدمات</label>
                                    <div class="col-lg-4">
                                        <select class="form-control form-control-lg custom-select" name="noe_khadamat"
                                                id="sj_voip_noe_khadamat">
                                            <option value="carti">کارتی</option>
                                            <option value="etebari">اعتباری</option>
                                        </select>
                                    </div>

                                    <label class="col-form-label col-lg-2">مدت استفاده(روز)</label>
                                    <div class="col-lg-4">
                                        <input name="zamane_estefade" id="sj_voip_zamane_estefade" type="text"
                                               class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">تاریخ شروع سرویس</label>
                                    <div class="col-lg-4">
                                        <input name="tarikhe_shoroe_service" id="sj_voip_tarikhe_shoroe_service"
                                               type="text" class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">تاریخ پایان سرویس</label>
                                    <div class="col-lg-4">
                                        <input name="tarikhe_payane_service" id="sj_voip_tarikhe_payane_service"
                                               type="text" class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">قیمت سرویس</label>
                                    <div class="col-lg-4">
                                        <input name="gheymate_service" id="sj_voip_gheymate_service" type="text"
                                               class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">تخفیف</label>
                                    <div class="col-lg-4">
                                        <input name="takhfif" id="sj_voip_takhfif" type="text" class="form-control"
                                               placeholder="">
                                    </div>


                                    <label class="col-form-label col-lg-2">درصد عوارض ارزش افزوده</label>
                                    <div class="col-lg-4">
                                        <input name="darsade_avareze_arzeshe_afzode"
                                               id="sj_voip_darsade_avareze_arzeshe_afzode" type="text" class="form-control"
                                               placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">مالیات ارزش افزوده</label>
                                    <div class="col-lg-4">
                                        <input name="maliate_arzeshe_afzode" id="sj_voip_maliate_arzeshe_afzode"
                                               type="text" class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">مبلغ قابل پرداخت</label>
                                    <div class="col-lg-4">
                                        <input name="mablaghe_ghabele_pardakht" id="sj_voip_mablaghe_ghabele_pardakht"
                                               type="text" class="form-control" placeholder="" readonly>
                                    </div>

                                    <label class="col-form-label col-lg-2">اعتبار باقیمانده</label>
                                    <div class="col-lg-4">
                                        <input name="etebare_baghimande" id="sj_voip_etebare_baghimande" type="text"
                                               class="form-control" placeholder="" readonly>
                                    </div>

                                    <label class="col-form-label col-lg-2">اعتبار قابل انتقال</label>
                                    <div class="col-lg-4">
                                        <input name="etebare_ghabele_enteghal" id="sj_voip_etebare_ghabele_enteghal"
                                               type="number" min="0" class="form-control" placeholder="" readonly>
                                    </div>

                                </div>
                            </fieldset>
                            <div class="text-right">
                                <button type="submit" name="send_sefareshe_jadid_voip" id="send_sefareshe_jadid_voip"
                                        class="btn btn-primary">ارسال
                                    <i class="icon-paperplane ml-2"></i></button>
                            </div>
                        </form>

                    </div>
                    <!------------sefareshe jadid tab Voip/------------->
                    <!------------sefareshe jadid tab ip adsl/vdsl------------->
                    <div class="ip_tab sefareshe_jadid_tabs tab-pane fade" data-flag="ipadsl"
                         id="bottom-justified-divided-tab5">
                        <form action="" method="POST" name="sefareshe_jadid_ipadsl">
                            <input type="hidden" id="sj_ip_adsl_subscriber_id" name="subscriber_id" value="empty"
                                   class="form-control">
                            <input type="hidden" id="sj_ip_adsl_service_id" name="service_id" value="empty"
                                   class="form-control">
                            <fieldset class="mb-3">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-2">انتخاب سرویس</label>
                                    <div class="col-lg-4">
                                        <select class="form-control form-control-lg custom-select" name="sj_ip_adsl_service_select"
                                                id="sj_ip_adsl_service_select">
                                        </select>
                                    </div>

                                    <label class="col-form-label col-lg-2">نوع خدمات</label>
                                    <div class="col-lg-4">
                                        <select class="form-control form-control-lg custom-select" name="noe_khadamat"
                                                id="sj_ip_adsl_noe_khadamat">
                                            <option value="valid">Valid</option>
                                            <option value="invalid">Invalid</option>
                                        </select>
                                    </div>

                                    <label class="col-form-label col-lg-2">مدت استفاده(روز)</label>
                                    <div class="col-lg-4">
                                        <input name="zamane_estefade" id="sj_ip_adsl_zamane_estefade" type="text"
                                               class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">تاریخ شروع سرویس</label>
                                    <div class="col-lg-4">
                                        <input name="tarikhe_shoroe_service" id="sj_ip_adsl_tarikhe_shoroe_service"
                                               type="text" class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">تاریخ پایان سرویس</label>
                                    <div class="col-lg-4">
                                        <input name="tarikhe_payane_service" id="sj_ip_adsl_tarikhe_payane_service"
                                               type="text" class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">قیمت سرویس</label>
                                    <div class="col-lg-4">
                                        <input name="gheymate_service" id="sj_ip_adsl_gheymate_service" type="text"
                                               class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">تخفیف</label>
                                    <div class="col-lg-4">
                                        <input name="takhfif" id="sj_ip_adsl_takhfif" type="text" class="form-control"
                                               placeholder="">
                                    </div>


                                    <label class="col-form-label col-lg-2">درصد عوارض ارزش افزوده</label>
                                    <div class="col-lg-4">
                                        <input name="darsade_avareze_arzeshe_afzode"
                                               id="sj_ip_adsl_darsade_avareze_arzeshe_afzode" type="text" class="form-control"
                                               placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">مالیات ارزش افزوده</label>
                                    <div class="col-lg-4">
                                        <input name="maliate_arzeshe_afzode" id="sj_ip_adsl_maliate_arzeshe_afzode"
                                               type="text" class="form-control" placeholder="">
                                    </div>

                                    <label class="col-form-label col-lg-2">مبلغ قابل پرداخت</label>
                                    <div class="col-lg-4">
                                        <input name="mablaghe_ghabele_pardakht" id="sj_ip_adsl_mablaghe_ghabele_pardakht"
                                               type="text" class="form-control" placeholder="" readonly>
                                    </div>

                                    <label class="col-form-label col-lg-2">اعتبار باقیمانده</label>
                                    <div class="col-lg-4">
                                        <input name="etebare_baghimande" id="sj_ip_adsl_etebare_baghimande" type="text"
                                               class="form-control" placeholder="" readonly>
                                    </div>

                                    <label class="col-form-label col-lg-2">اعتبار قابل انتقال</label>
                                    <div class="col-lg-4">
                                        <input name="etebare_ghabele_enteghal" id="sj_ip_adsl_etebare_ghabele_enteghal"
                                               type="number" min="0" class="form-control" placeholder="" readonly>
                                    </div>

                                </div>
                            </fieldset>
                            <div class="text-right">
                                <button type="submit" name="send_sefareshe_jadid_ip" id="send_sefareshe_jadid_ip"
                                        class="btn btn-primary">ارسال
                                    <i class="icon-paperplane ml-2"></i></button>
                            </div>
                        </form>

                    </div>
                    <!------------sefareshe jadid tab ip/------------->

                </div>
            </div>
        </div>
    </div>
    <!--FACTORHA TAB-->
    <div class="card" style="padding: 2px;" id="faktorha_tab">
        <div class="col-md-12">
            <button name="factorconfirm" style="float: left !important;"
                    class="btn btn-primary col-md-auto float-md-left" id="factorconfirm">ویرایش<i
                        class="icon-list ml-2"></i></button>
            <button name="factorpardakht_initbtn" style="float: left !important;margin-left: 5px"
                    class="btn btn-primary col-md-auto float-md-left" id="factorpardakht_initbtn">پرداخت<i
                        class="icon-database-edit2 ml-2"></i></button>
            <button name="factorprint_initbtn" style="float: left !important;margin-left: 5px"
                    class="btn btn-primary col-md-auto float-md-left" id="factorprint_initbtn">پرینت<i
                        class="icon-printer ml-2"></i></button>
            <button name="factorshahkar" style="float: right !important;margin-left: 5px"
                    class="btn btn-warning col-md-auto float-md-left" id="factorshahkar">شاهکار<i
                        class="icon-pen6 ml-2"></i></button>
            <table id="factor_tab" class="table table-striped datatable-responsive table-hover">
            </table>
        </div>
        <!-- pardakht modal -->

        <!-- nouser modal -->
        <!-- delete nouser modal -->
        <div id="modal_form_factortab_init_pardakht_nouser" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-full">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title">پرداخت فاکتور</h5>
                        <button type="button" class="close" data-dismiss="modal"
                                style="font-size: 24px !important;">&#215
                        </button>
                    </div>
                    <form action="#" name="ft_nouser_pardakht_form">
                        <input name="id" id="ft_init_id_factor" type="hidden" class="form-control">
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="row">
                                    <legend class="text-uppercase font-size-sm font-weight-bold" style="color: #FB8C00">
                                        واریز
                                        نقدی
                                    </legend>
                                    <div class="col-sm-6 col-md-6">
                                        <label class="col-form-label">شماره کارت</label>
                                        <input name="shomare_cart" id="ft_nouser_shomare_cart" type="text"
                                               class="form-control">
                                        <input name="factor_id" id="ft_nouser_factor_id" type="hidden" value="empty"
                                               class="form-control">
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <label class="col-form-label">شماره پیگیری</label>
                                        <input name="shomare_peygiri" id="ft_nouser_shomare_peygiri" type="text"
                                               class="form-control">
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <label class="col-form-label">مبلغ واریزی</label>
                                        <input name="mablaghe_varizi" id="ft_nouser_mablaghe_varizi" type="text"
                                               class="form-control">
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <label class="col-form-label">تاریخ واریز</label>
                                        <input name="tarikhe_variz" id="ft_nouser_tarikhe_variz" type="text"
                                               class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-dismiss="modal">بستن</button>
                            <button type="submit" name="send_ft_nouser_pardakht" class="btn bg-primary">پرداخت</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--   user expired modal     -->
        <!-- delete user expired modal -->
        <div id="modal_form_factortab_init_pardakht_expired" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-full">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title">پرداخت فاکتور</h5>
                        <button type="button" class="close" data-dismiss="modal"
                                style="font-size: 24px !important;">&#215
                        </button>
                    </div>
                    <form action="#" name="ft_expired_pardakht_form">
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="row">
                                    <legend class="text-uppercase font-size-sm font-weight-bold" style="color: #FB8C00">
                                        واریز
                                        نقدی
                                    </legend>
                                    <div class="col-sm-6 col-md-6">
                                        <label class="col-form-label">شماره کارت</label>
                                        <input name="shomare_cart" id="ft_expired_shomare_cart" type="text"
                                               class="form-control">
                                        <input name="factor_id" id="ft_expired_factor_id" type="hidden" value="empty"
                                               class="form-control">
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <label class="col-form-label">شماره پیگیری</label>
                                        <input name="shomare_peygiri" id="ft_expired_shomare_peygiri" type="text"
                                               class="form-control">
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <label class="col-form-label">مبلغ واریزی</label>
                                        <input name="mablaghe_varizi" id="ft_expired_mablaghe_varizi" type="text"
                                               class="form-control">
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <label class="col-form-label">تاریخ واریز</label>
                                        <input name="tarikhe_variz" id="ft_expired_tarikhe_variz" type="text"
                                               class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-dismiss="modal">بستن</button>
                            <button type="submit" name="send_ft_expired_pardakht" class="btn bg-primary">پرداخت</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- factor pardakht selection -->
        <div id="modal_form_factortab_pardakht_selection" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title">پرداخت فاکتور</h5>
                        <button type="button" class="close" data-dismiss="modal"
                                style="font-size: 24px !important;">&#215
                        </button>
                    </div>
                    <form action="#" name="ft_pardakht_form" method="post">
                        <input type="hidden" name="factor_id" id="ft_pardakht_factor_id" value="empty">
                        <div class="modal-body">
                            <div class="form-group" id="factortab_pardakhte_namayande">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label class="col-form-label">نوع پرداخت</label>
                                        <select class="form-control" name="noe_pardakht" id="ft_noe_pardakht" required>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label">مبلغ فاکتور</label>
                                        <input name="mablaghe_factor" id="ft_pardakht_mablaghe_factor" type="text"
                                               class="form-control" readonly>
                                    </div>

                                    <div class="col-sm-6">
                                        <label class="col-form-label">نام نمایندگی</label>
                                        <input name="name_sherkat" id="ft_pardakht_name_sherkat" type="text"
                                               class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label">موجودی</label>
                                        <input name="mojodi_sherkat" id="ft_pardakht_mojodi_namayande" type="text"
                                               class="form-control" readonly>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group" id="factortab_pardakhte_subscriber">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label class="col-form-label">نام مشترک</label>
                                        <input name="name_subscriber" id="ft_pardakht_name_subscriber" type="text"
                                               class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label">موجودی</label>
                                        <input name="mojodi_subscriber" id="ft_pardakht_mojodi_subscriber" type="text"
                                               class="form-control" readonly>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-dismiss="modal">بستن</button>
                            <div class="text-right">
                                <button type="submit" name="send_ft_pardakht" id="send_ft_pardakht"
                                        class="btn btn-primary">پرداخت
                                    <i class="icon-paperplane ml-2"></i></button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <!-- factor pardakht selection -->
        <!-- adsl modal -->
        <div id="modal_form_factortab_adsl" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-full">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title">ویرایش فاکتور</h5>
                        <button type="button" class="close" data-dismiss="modal"
                                style="font-size: 24px !important;">&#215
                        </button>
                    </div>
                    <form action="#" name="ft_adsl_update_status">
                        <input name="id" id="ft_adsl_id" type="hidden" class="form-control">
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">نوع خدمات</label>
                                        <select class="form-control" name="noe_khadamat" id="ft_adsl_noe_khadamat"
                                                readonly>
                                            <option value="ADSL(Share)">ADSL Share</option>
                                            <option value="ADSL(Transport)">ADSL Transport</option>
                                            <option value="VDSL(Share)">VDSL Share</option>
                                            <option value="VDSL(Transport)">VDSL Transport</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">ترافیک(MB)</label>
                                        <input name="terafik" id="ft_adsl_terafik" type="text" class="form-control"
                                               readonly>

                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">زمان استفاده</label>
                                        <input name="zaname_estefade_be_tarikh" id="ft_adsl_zaname_estefade_be_tarikh"
                                               type="text" class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">تاریخ شروع سرویس</label>
                                        <input name="tarikhe_shoroe_service" id="ft_adsl_tarikhe_shoroe_service"
                                               type="text" class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">تاریخ پایان سرویس</label>
                                        <input name="tarikhe_payane_service" id="ft_adsl_tarikhe_payane_service"
                                               type="text" class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">قیمت سرویس</label>
                                        <input name="gheymate_service" id="ft_adsl_gheymate_service" type="text"
                                               class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">تخفیف</label>
                                        <input name="takhfif" id="ft_adsl_takhfif" type="text" class="form-control"
                                               readonly>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">هزینه رانژه</label>
                                        <input name="hazine_ranzhe" id="ft_adsl_hazine_ranzhe" type="text"
                                               class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">هزینه درانژه</label>
                                        <input name="hazine_dranzhe" id="ft_adsl_hazine_dranzhe" type="text"
                                               class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">هزینه نصب</label>
                                        <input name="hazine_nasb" id="ft_adsl_hazine_nasb" type="text"
                                               class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">آبونمان پورت</label>
                                        <input name="abonmane_port" id="ft_adsl_abonmane_port" type="text"
                                               class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">آبونمان فضا</label>
                                        <input name="abonmane_faza" id="ft_adsl_abonmane_faza" type="text"
                                               class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-4 col-md-3" readonly>
                                        <label class="col-form-label">آبونمان تجهیزات</label>
                                        <input name="abonmane_tajhizat" id="ft_adsl_abonmane_tajhizat" type="text"
                                               class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">درصد عوارض ارزش افزوده</label>
                                        <input name="darsade_avareze_arzeshe_afzode"
                                               id="ft_adsl_darsade_avareze_arzeshe_afzode" type="text" class="form-control"
                                               readonly>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">مالیات ارزش افزوده</label>
                                        <input name="maliate_arzeshe_afzode" id="ft_adsl_maliate_arzeshe_afzode"
                                               type="text" class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">مبلغ قابل پرداخت</label>
                                        <input name="mablaghe_ghabele_pardakht" id="ft_adsl_mablaghe_ghabele_pardakht"
                                               type="text" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <legend class="text-uppercase font-size-sm font-weight-bold" style="color: #FB8C00">
                                        وضعیت
                                        سرویس
                                    </legend>
                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="daryafte_etelaat" id="ft_adsl_daryafte_etelaat">
                                        دریافت
                                        اطلاعات
                                    </div>
                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="ehraze_hoviat" id="ft_adsl_ehraze_hoviat"> احراز
                                        هویت
                                    </div>
                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="eneghade_gharardad"
                                               id="ft_adsl_eneghade_gharardad"> انعقاد
                                        قرارداد
                                    </div>
                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="entezare_mokhaberat"
                                               id="ft_adsl_entezare_mokhaberat"> انتظار
                                        مخابرات
                                    </div>
                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="entezare_ranzhe" id="ft_adsl_entezare_ranzhe">
                                        انتظار رانژه
                                    </div>
                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="faal_sazie_avalie" id="ft_adsl_faal_sazie_avalie">
                                        فعال سازی
                                        اولیه
                                    </div>
                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="entezare_nasb" id="ft_adsl_entezare_nasb"> انتظار
                                        نصب
                                    </div>
                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="faal" id="ft_adsl_faal"> فعال
                                    </div>
                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="marjo" id="ft_adsl_marjo"> مرجوع
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <legend class="text-uppercase font-size-sm font-weight-bold" style="color: #FB8C00">
                                        وضعیت
                                        فاکتور
                                    </legend>
                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="sharje_mojadad" id="ft_adsl_sharje_mojadad"> شارژ
                                        مجدد
                                    </div>
                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="print_shode" id="ft_adsl_print_shode"> پرینت شده
                                    </div>
                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="ersal_shode" id="ft_adsl_ersal_shode"> ارسال شده
                                    </div>
                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="marjo_shode" id="ft_adsl_marjo_shode"> مرجوع شده
                                    </div>

                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="tasvie_shode" id="ft_adsl_tasvie_shode"> تسویه شده
                                    </div>
                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="disable_shode" id="ft_adsl_disable_shode"> Disable
                                    </div>

                                    <div class="col-sm-12">
                                        <label class="col-form-label">توضیحات مرجوع شده</label>
                                        <input name="tozihate_marjo_shode" id="ft_adsl_tozihate_marjo_shode" type="text"
                                               class="form-control">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label">تاریخ مرجوع شده</label>
                                        <input name="tarikhe_marjo_shode" id="ft_adsl_tarikhe_marjo_shode" type="text"
                                               class="form-control">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label">مرجوع کننده</label>
                                        <input name="marjo_konande" id="ft_adsl_marjo_konande" type="text"
                                               class="form-control">
                                    </div>
                                    <div class="col-sm-12">
                                        <label class="col-form-label">توضیحات فیش واریزی</label>
                                        <input name="tozihate_tasvie_shode" id="ft_adsl_tozihate_tasvie_shode"
                                               type="text" class="form-control">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label">تاریخ فیش واریزی</label>
                                        <input name="tarikhe_tasvie_shode" id="ft_adsl_tarikhe_tasvie_shode" type="text"
                                               class="form-control">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label">واریز کننده</label>
                                        <input name="tasvie_konande" id="ft_adsl_tasvie_konande" type="text"
                                               class="form-control">
                                    </div>
                                    <div class="col-sm-12">
                                        <label class="col-form-label">توضیحات غیرفعال(Disable)</label>
                                        <input name="tozihate_disable_shode" id="ft_adsl_tozihate_disable_shode"
                                               type="text" class="form-control">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label">تاریخ غیر فعال شده(Disable)</label>
                                        <input name="tarikhe_disable_shode" id="ft_adsl_tarikhe_disable_shode"
                                               type="text" class="form-control">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label">Disable کننده</label>
                                        <input name="disable_konande" id="ft_adsl_disable_konande" type="text"
                                               class="form-control">
                                    </div>


                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-dismiss="modal">بستن</button>
                            <button type="submit" name="send_ft_adsl_update_status"
                                    class="btn bg-primary">ارسال
                            </button>
                        </div>
                    </form>

                </div>


            </div>
        </div>
        <!-- wireless modal -->
        <div id="modal_form_factortab_wireless" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-full">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title">ویرایش فاکتور</h5>
                        <button type="button" class="close" data-dismiss="modal"
                                style="font-size: 24px !important;">&#215
                        </button>
                    </div>
                    <form action="#" name="ft_wireless_update_status">
                        <input name="id" id="ft_wireless_id" type="hidden" class="form-control">
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">نوع خدمات</label>
                                        <select class="form-control form-control-lg custom-select" name="noe_khadamat"
                                                id="ft_wireless_noe_khadamat" readonly>
                                            <option value="Wireless(Share)">Wireless Share</option>
                                            <option value="Wireless(Transport)">Wireless Transport</option>
                                            <option value="Wireless(Hotspot)">Wireless Hotspot</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">ترافیک(MB)</label>
                                        <input name="terafik" id="ft_wireless_terafik" type="text" class="form-control"
                                               readonly>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">زمان استفاده</label>
                                        <input name="zaname_estefade_be_tarikh"
                                               id="ft_wireless_zaname_estefade_be_tarikh" type="text" class="form-control"
                                               readonly>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">تاریخ شروع سرویس</label>
                                        <input name="tarikhe_shoroe_service" id="ft_wireless_tarikhe_shoroe_service"
                                               type="text" class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">تاریخ پایان سرویس</label>
                                        <input name="tarikhe_payane_service" id="ft_wireless_tarikhe_payane_service"
                                               type="text" class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">قیمت سرویس</label>
                                        <input name="gheymate_service" id="ft_wireless_gheymate_service" type="text"
                                               class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">تخفیف</label>
                                        <input name="takhfif" id="ft_wireless_takhfif" type="text" class="form-control"
                                               readonly>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">هزینه نصب</label>
                                        <input name="hazine_nasb" id="ft_wireless_hazine_nasb" type="text"
                                               class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">آبونمان پورت</label>
                                        <input name="abonmane_port" id="ft_wireless_abonmane_port" type="text"
                                               class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">آبونمان فضا</label>
                                        <input name="abonmane_faza" id="ft_wireless_abonmane_faza" type="text"
                                               class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">آبونمان تجهیزات</label>
                                        <input name="abonmane_tajhizat" id="ft_wireless_abonmane_tajhizat" type="text"
                                               class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">درصد عوارض ارزش افزوده</label>
                                        <input name="darsade_avareze_arzeshe_afzode"
                                               id="ft_wireless_darsade_avareze_arzeshe_afzode" type="text"
                                               class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">مالیات ارزش افزوده</label>
                                        <input name="maliate_arzeshe_afzode" id="ft_wireless_maliate_arzeshe_afzode"
                                               type="text" class="form-control">
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">مبلغ قابل پرداخت</label>
                                        <input name="mablaghe_ghabele_pardakht"
                                               id="ft_wireless_mablaghe_ghabele_pardakht" type="text" class="form-control"
                                               readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <legend class="text-uppercase font-size-sm font-weight-bold" style="color: #FB8C00">
                                        وضعیت
                                        سرویس
                                    </legend>
                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="daryafte_etelaat"
                                               id="ft_wireless_daryafte_etelaat"> دریافت
                                        اطلاعات
                                    </div>
                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="ehraze_hoviat" id="ft_wireless_ehraze_hoviat">
                                        احراز هویت
                                    </div>
                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="eneghade_gharardad"
                                               id="ft_wireless_eneghade_gharardad">
                                        انعقاد قرارداد
                                    </div>
                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="baresie_link" id="ft_wireless_baresie_link"> بررسی
                                        لینک
                                    </div>
                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="entezare_nasb" id="ft_wireless_entezare_nasb">
                                        انتظار نصب
                                    </div>
                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="faal_sazie_avalie"
                                               id="ft_wireless_faal_sazie_avalie"> فعال
                                        سازی اولیه
                                    </div>
                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="faal" id="ft_wireless_faal"> فعال
                                    </div>
                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="marjo" id="ft_wireless_marjo"> مرجوع
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <legend class="text-uppercase font-size-sm font-weight-bold" style="color: #FB8C00">
                                        وضعیت
                                        فاکتور
                                    </legend>
                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="sharje_mojadad" id="ft_wireless_sharje_mojadad">
                                        شارژ مجدد
                                    </div>
                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="print_shode" id="ft_wireless_print_shode"> پرینت
                                        شده
                                    </div>
                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="ersal_shode" id="ft_wireless_ersal_shode"> ارسال
                                        شده
                                    </div>
                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="marjo_shode" id="ft_wireless_marjo_shode"> مرجوع
                                        شده
                                    </div>

                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="tasvie_shode" id="ft_wireless_tasvie_shode"> تسویه
                                        شده
                                    </div>

                                    <div class="col-sm-12">
                                        <label class="col-form-label">توضیحات مرجوع شده</label>
                                        <input name="tozihate_marjo_shode" id="ft_wireless_tozihate_marjo_shode"
                                               type="text" class="form-control">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label">تاریخ مرجوع شده</label>
                                        <input name="tarikhe_marjo_shode" id="ft_wireless_tarikhe_marjo_shode"
                                               type="text" class="form-control">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label">مرجوع کننده</label>
                                        <input name="marjo_konande" id="ft_wireless_marjo_konande" type="text"
                                               class="form-control">
                                    </div>
                                    <div class="col-sm-12">
                                        <label class="col-form-label">توضیحات فیش واریزی</label>
                                        <input name="tozihate_tasvie_shode" id="ft_wireless_tozihate_tasvie_shode"
                                               type="text" class="form-control">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label">تاریخ فیش واریزی</label>
                                        <input name="tarikhe_tasvie_shode" id="ft_wireless_tarikhe_tasvie_shode"
                                               type="text" class="form-control">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label">واریز کننده</label>
                                        <input name="tasvie_konande" id="ft_wireless_tasvie_konande" type="text"
                                               class="form-control">
                                    </div>
                                    <div class="col-sm-12">
                                        <label class="col-form-label">توضیحات غیرفعال(Disable)</label>
                                        <input name="tozihate_disable_shode" id="ft_wireless_tozihate_disable_shode"
                                               type="text" class="form-control">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label">تاریخ غیر فعال شده(Disable)</label>
                                        <input name="tarikhe_disable_shode" id="ft_wireless_tarikhe_disable_shode"
                                               type="text" class="form-control">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label">Disable کننده</label>
                                        <input name="disable_konande" id="ft_wireless_disable_konande" type="text"
                                               class="form-control">
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-dismiss="modal">بستن</button>
                            <button type="submit" name="send_ft_wireless_update_status" class="btn bg-primary">ارسال
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- tdlte modal -->
        <div id="modal_form_factortab_tdlte" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-full">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title">ویرایش فاکتور</h5>
                        <button type="button" class="close" data-dismiss="modal"
                                style="font-size: 24px !important;">&#215
                        </button>
                    </div>
                    <form action="#" name="ft_tdlte_update_status">
                        <input name="id" id="ft_tdlte_id" type="hidden" class="form-control">
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">نوع خدمات</label>
                                        <select class="form-control form-control-lg custom-select" name="noe_khadamat"
                                                id="ft_tdlte_noe_khadamat" readonly>
                                            <option value="TD-LTE(Share)">TD-LTE Share</option>
                                            <option value="TD-LTE(Transport)">TD-LTE Transport</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">ترافیک(MB)</label>
                                        <input name="terafik" id="ft_tdlte_terafik" type="text" class="form-control"
                                               readonly>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">زمان استفاده</label>
                                        <input name="zaname_estefade_be_tarikh" id="ft_tdlte_zaname_estefade_be_tarikh"
                                               type="text" class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">تاریخ شروع سرویس</label>
                                        <input name="tarikhe_shoroe_service" id="ft_tdlte_tarikhe_shoroe_service"
                                               type="text" class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">تاریخ پایان سرویس</label>
                                        <input name="tarikhe_payane_service" id="ft_tdlte_tarikhe_payane_service"
                                               type="text" class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">قیمت سرویس</label>
                                        <input name="gheymate_service" id="ft_tdlte_gheymate_service" type="text"
                                               class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">تخفیف</label>
                                        <input name="takhfif" id="ft_tdlte_takhfif" type="text" class="form-control"
                                               readonly>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">هزینه نصب</label>
                                        <input name="hazine_nasb" id="ft_tdlte_hazine_nasb" type="text"
                                               class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">آبونمان پورت</label>
                                        <input name="abonmane_port" id="ft_tdlte_abonmane_port" type="text"
                                               class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">آبونمان فضا</label>
                                        <input name="abonmane_faza" id="ft_tdlte_abonmane_faza" type="text"
                                               class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">آبونمان تجهیزات</label>
                                        <input name="abonmane_tajhizat" id="ft_tdlte_abonmane_tajhizat" type="text"
                                               class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">درصد عوارض ارزش افزوده</label>
                                        <input name="darsade_avareze_arzeshe_afzode"
                                               id="ft_tdlte_darsade_avareze_arzeshe_afzode" type="text"
                                               class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">مالیات ارزش افزوده</label>
                                        <input name="maliate_arzeshe_afzode" id="ft_tdlte_maliate_arzeshe_afzode"
                                               type="text" class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">مبلغ قابل پرداخت</label>
                                        <input name="mablaghe_ghabele_pardakht" id="ft_tdlte_mablaghe_ghabele_pardakht"
                                               type="text" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <legend class="text-uppercase font-size-sm font-weight-bold" style="color: #FB8C00">
                                        وضعیت
                                        سرویس
                                    </legend>
                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="daryafte_etelaat" id="ft_tdlte_daryafte_etelaat">
                                        دریافت
                                        اطلاعات
                                    </div>
                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="ehraze_hoviat" id="ft_tdlte_ehraze_hoviat"> احراز
                                        هویت
                                    </div>
                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="eneghade_gharardad"
                                               id="ft_tdlte_eneghade_gharardad"> انعقاد
                                        قرارداد
                                    </div>
                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="entezare_nasb" id="ft_tdlte_entezare_nasb"> انتظار
                                        نصب
                                    </div>
                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="faal_sazie_avalie" id="ft_tdlte_faal_sazie_avalie">
                                        فعال سازی
                                        اولیه
                                    </div>
                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="faal" id="ft_tdlte_faal"> فعال
                                    </div>
                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="marjo" id="ft_tdlte_marjo"> مرجوع
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <legend class="text-uppercase font-size-sm font-weight-bold" style="color: #FB8C00">
                                        وضعیت
                                        فاکتور
                                    </legend>
                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="sharje_mojadad" id="ft_tdlte_sharje_mojadad"> شارژ
                                        مجدد
                                    </div>
                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="print_shode" id="ft_tdlte_print_shode"> پرینت شده
                                    </div>
                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="ersal_shode" id="ft_tdlte_ersal_shode"> ارسال شده
                                    </div>
                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="marjo_shode" id="ft_tdlte_marjo_shode"> مرجوع شده
                                    </div>

                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="tasvie_shode" id="ft_tdlte_tasvie_shode"> تسویه شده
                                    </div>

                                    <div class="col-sm-12">
                                        <label class="col-form-label">توضیحات مرجوع شده</label>
                                        <input name="tozihate_marjo_shode" id="ft_tdlte_tozihate_marjo_shode"
                                               type="text" class="form-control">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label">تاریخ مرجوع شده</label>
                                        <input name="tarikhe_marjo_shode" id="ft_tdlte_tarikhe_marjo_shode" type="text"
                                               class="form-control">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label">مرجوع کننده</label>
                                        <input name="marjo_konande" id="ft_tdlte_marjo_konande" type="text"
                                               class="form-control">
                                    </div>
                                    <div class="col-sm-12">
                                        <label class="col-form-label">توضیحات فیش واریزی</label>
                                        <input name="tozihate_tasvie_shode" id="ft_tdlte_tozihate_tasvie_shode"
                                               type="text" class="form-control">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label">تاریخ فیش واریزی</label>
                                        <input name="tarikhe_tasvie_shode" id="ft_tdlte_tarikhe_tasvie_shode"
                                               type="text" class="form-control">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label">واریز کننده</label>
                                        <input name="tasvie_konande" id="ft_tdlte_tasvie_konande" type="text"
                                               class="form-control">
                                    </div>
                                    <div class="col-sm-12">
                                        <label class="col-form-label">توضیحات غیرفعال(Disable)</label>
                                        <input name="tozihate_disable_shode" id="ft_tdlte_tozihate_disable_shode"
                                               type="text" class="form-control">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label">تاریخ غیر فعال شده(Disable)</label>
                                        <input name="tarikhe_disable_shode" id="ft_tdlte_tarikhe_disable_shode"
                                               type="text" class="form-control">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label">Disable کننده</label>
                                        <input name="disable_konande" id="ft_tdlte_disable_konande" type="text"
                                               class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-dismiss="modal">بستن</button>
                            <button type="submit" name="send_ft_tdlte_update_status" class="btn bg-primary">ارسال
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- voip modal -->
        <div id="modal_form_factortab_voip" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-full">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title">ویرایش فاکتور</h5>
                        <button type="button" class="close" data-dismiss="modal"
                                style="font-size: 24px !important;">&#215
                        </button>
                    </div>
                    <form action="#" name="ft_voip_update_status">
                        <input name="id" id="ft_voip_id" type="hidden" class="form-control">
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">نوع خدمات</label>
                                        <select class="form-control form-control-lg custom-select" name="noe_khadamat"
                                                id="ft_voip_noe_khadamat" readonly>
                                            <option value="carti">کارتی</option>
                                            <option value="etebari">اعتباری</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">پین کد</label>
                                        <input name="pin_code" id="ft_voip_pin_code" type="text" class="form-control"
                                               readonly>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">زمان استفاده</label>
                                        <input name="zaname_estefade_be_tarikh" id="ft_voip_zaname_estefade_be_tarikh"
                                               type="text" class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">تاریخ شروع سرویس</label>
                                        <input name="tarikhe_shoroe_service" id="ft_voip_tarikhe_shoroe_service"
                                               type="text" class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">تاریخ پایان سرویس</label>
                                        <input name="tarikhe_payane_service" id="ft_voip_tarikhe_payane_service"
                                               type="text" class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">قیمت سرویس</label>
                                        <input name="gheymate_service" id="ft_voip_gheymate_service" type="text"
                                               class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">تخفیف</label>
                                        <input name="takhfif" id="ft_voip_takhfif" type="text" class="form-control"
                                               readonly>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">درصد عوارض ارزش افزوده</label>
                                        <input name="darsade_avareze_arzeshe_afzode"
                                               id="ft_voip_darsade_avareze_arzeshe_afzode" type="text" class="form-control"
                                               readonly>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">مالیات ارزش افزوده</label>
                                        <input name="maliate_arzeshe_afzode" id="ft_voip_maliate_arzeshe_afzode"
                                               type="text" class="form-control" readonly>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <label class="col-form-label">مبلغ قابل پرداخت</label>
                                        <input name="mablaghe_ghabele_pardakht" id="ft_voip_mablaghe_ghabele_pardakht"
                                               type="text" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <legend class="text-uppercase font-size-sm font-weight-bold" style="color: #FB8C00">
                                        وضعیت
                                        سرویس
                                    </legend>
                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="daryafte_etelaat" id="ft_voip_daryafte_etelaat">
                                        دریافت
                                        اطلاعات
                                    </div>
                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="ehraze_hoviat" id="ft_voip_ehraze_hoviat"> احراز
                                        هویت
                                    </div>
                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="eneghade_gharardad"
                                               id="ft_voip_eneghade_gharardad"> انعقاد
                                        قرارداد
                                    </div>
                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="faal_sazie_avalie" id="ft_voip_faal_sazie_avalie">
                                        فعال سازی
                                        اولیه
                                    </div>
                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="faal" id="ft_voip_faal"> فعال
                                    </div>
                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="marjo" id="ft_voip_marjo"> مرجوع
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <legend class="text-uppercase font-size-sm font-weight-bold" style="color: #FB8C00">
                                        وضعیت
                                        فاکتور
                                    </legend>
                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="sharje_mojadad" id="ft_voip_sharje_mojadad"> شارژ
                                        مجدد
                                    </div>
                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="print_shode" id="ft_voip_print_shode"> پرینت شده
                                    </div>
                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="ersal_shode" id="ft_voip_ersal_shode"> ارسال شده
                                    </div>
                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="marjo_shode" id="ft_voip_marjo_shode"> مرجوع شده
                                    </div>

                                    <div class="col-sm-3 col-md-2">
                                        <input type="checkbox" name="tasvie_shode" id="ft_voip_tasvie_shode"> تسویه شده
                                    </div>

                                    <div class="col-sm-12">
                                        <label class="col-form-label">توضیحات مرجوع شده</label>
                                        <input name="tozihate_marjo_shode" id="ft_voip_tozihate_marjo_shode" type="text"
                                               class="form-control">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label">تاریخ مرجوع شده</label>
                                        <input name="tarikhe_marjo_shode" id="ft_voip_tarikhe_marjo_shode" type="text"
                                               class="form-control">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label">مرجوع کننده</label>
                                        <input name="marjo_konande" id="ft_voip_marjo_konande" type="text"
                                               class="form-control">
                                    </div>
                                    <div class="col-sm-12">
                                        <label class="col-form-label">توضیحات فیش واریزی</label>
                                        <input name="tozihate_tasvie_shode" id="ft_voip_tozihate_tasvie_shode"
                                               type="text" class="form-control">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label">تاریخ فیش واریزی</label>
                                        <input name="tarikhe_tasvie_shode" id="ft_voip_tarikhe_tasvie_shode" type="text"
                                               class="form-control">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label">واریز کننده</label>
                                        <input name="tasvie_konande" id="ft_voip_tasvie_konande" type="text"
                                               class="form-control">
                                    </div>
                                    <div class="col-sm-12">
                                        <label class="col-form-label">توضیحات غیرفعال(Disable)</label>
                                        <input name="tozihate_disable_shode" id="ft_voip_tozihate_disable_shode"
                                               type="text" class="form-control">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label">تاریخ غیر فعال شده(Disable)</label>
                                        <input name="tarikhe_disable_shode" id="ft_voip_tarikhe_disable_shode"
                                               type="text" class="form-control">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label">Disable کننده</label>
                                        <input name="disable_konande" id="ft_voip_disable_konande" type="text"
                                               class="form-control">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-dismiss="modal">بستن</button>
                            <button type="submit" name="send_ft_voip_update_status" class="btn bg-primary">ارسال
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--PARDAKHTHA TAB-->
    <div class="card" style="padding: 2px;" id="pardakhtha_tab">
        <div class="col-md-12">
            <div id=""></div>
        </div>
    </div>
    <!--ONLINE USER TAB-->
    <div class="card" style="padding: 2px;" id="online_user_tab">
        <div class="card-body" id="online_user_tab_content">
        <form action="#">
                <fieldset class="mb-3">
                    <div class="form-group row">
                        <label class="col-form-label col-md-2">نوع سرویس</label>
                        <div class="col-md-4">
                            <select class="form-control form-control-md custom-select" name="type"
                                    id="online_user_servicetype" required>
                                    <option disabled selected value> -- یک مورد را انتخاب کنید -- </option>
                                                <option value="adsl">ADSL</option>
                                                <option value="vdsl">VDSL</option>
                                                <option value="bitstream">Bitstream</option>
                                                <option value="wireless">Wireless</option>
                                                <option value="tdlte">Tdlte</option>
                                                <option value="voip">Voip</option>
                            </select>
                        </div>
                        <label class="col-form-label col-md-2">انتخاب نام کاربری IBSng</label>
                        <div class="col-md-4">
                            <select class="form-control form-control-md custom-select" name="ibsusername"
                                    id="online_user_select_username" required>
                            </select>
                        </div>
                    </div>
                </fieldset>
                <div class="text-right">
                    <button type="submit" name="send_online_user" class="btn btn-primary">تایید<i
                                class="icon-paperplane ml-2"></i></button>
                </div>
        </form>
            <div class="col-sm-12">
                <table id="online_user_table" class="table table-striped datatable-responsive table-hover">
                </table>
            </div>
        </div>
    </div>
    <!--CONNECTION LOG TAB-->
    <div class="card" id="connection_log_tab">
        <div class="card-body">
            <form action="#" name="connection_log_form_request">
                <fieldset class="mb-3">
                    <div class="form-group row">
                        <label class="col-form-label col-md-2">نوع سرویس</label>
                        <div class="col-md-4">
                            <select class="form-control form-control-md custom-select" name="service_type"
                                    id="connection_log_service_type" required>
                                    <option disabled selected value> -- یک مورد را انتخاب کنید -- </option>
                                    <option value="adsl">ADSL</option>
                                    <option value="vdsl">VDSL</option>
                                    <option value="bitstream">Bitstream</option>
                                    <option value="wireless">Wireless</option>
                                    <option value="tdlte">Tdlte</option>
                                    <option value="voip">Voip</option>
                            </select>
                        </div>
                        <label class="col-form-label col-md-2">انتخاب نام کاربری IBSng</label>
                        <div class="col-md-4">
                            <select class="form-control form-control-md custom-select" name="ibsusername"
                                    id="connection_log_select_username" required>
                            </select>
                        </div>
                        <label class="col-form-label col-md-2">نوع مصرف</label>
                        <div class="col-md-4">
                            <select class="form-control form-control-md custom-select" name="noe_service"
                                    id="connection_log_noe_service" required>
                            </select>
                        </div>

                        <label class="col-form-label col-md-2">از تاریخ</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control pwt-datepicker-input-element" name="time_from"
                                   id="connection_log_time_from" placeholder="مثال: 1380/05/20">
                        </div>
                        <label class="col-form-label col-md-2">تا تاریخ</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control pwt-datepicker-input-element" name="time_to"
                                   id="connection_log_time_to" placeholder="مثال: 1380/05/20">
                        </div>
                    </div>
                </fieldset>
                <div class="text-right">
                    <button type="submit" name="send_ft_connection_log" class="btn btn-primary">تایید<i
                                class="icon-paperplane ml-2"></i></button>
                </div>
            </form>
            <div class="col-sm-12">
                <table id="connection_log_table" class="table table-striped datatable-responsive table-hover">
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /content area -->
<!-- <div id="adsl_print_form" style="width:1748;height:2480;border:1px solid">
  <div style="width:100%;height:20%;display:inline;position:relative">
    <span style="width:"></span>
    <span></span>
  </div>
  <div>
    <table style="direction:rtl;text-align:right">
    <tbody>
    <tr>
    <td><strong>Name</strong></td>
    <td><strong>City</strong></td>
    <td><strong>Age</strong></td>
    </tr>
    <tr>
    <td>John</td>
    <td>Chicago</td>
    <td>23</td>
    </tr>
    <tr>
    <td>Lucy</td>
    <td>Wisconsin</td>
    <td>19</td>
    </tr>
    <tr>
    <td>Amanda</td>
    <td>Madison</td>
    <td>22</td>
    </tr>
    </tbody>
    </table>
    </div>
  </div> -->
<!--- print_form_adsl --->
<div style="display:none;width: 500px;height: 650px;margin: auto;border:1px solid black;" id="print_form_adsl">
<table class="prints_tables" dir="rtl" style="width: 500px;height: 650px;margin: auto;table-layout: fixed;border:0;" cellspacing="0" cellpadding="0">
	<tbody>
		<tr>
			<td colspan="2">
                <img class="pt_headerimg" src="<?php echo __ROOT__ . 'public/images/logo1.jpg' ?>" alt=""
                     style=""></td>
			<td colspan="2">
                <ul class="pt_headermatn" style="">
                    <li style="">&lrm;آدرس: تهران شهرک قدس(غرب) بلوار شهید فرحزادی خیابان شهید
                        حافظی(ارغوان غربی) پلاک10 واحد8&lrm;</li>
                    <li style="">تلفن: &lrm;0212376081-5&lrm; و &lrm;02191033501-5&lrm;</li>
                    <li style="">دورنگار: &lrm;0212209750&lrm;</li>
                    <li style="">وب سایت: www.saharertenat.net</li>
                    <li style="">دارای پروانه ارائه خدمات ارتباطی به شماره &lrm;100-95-39&lrm; از سازمان تنظیم مقررات و ارتباطات رادیویی کشور</li>
                </ul>
            </td>
		</tr>
		<tr>
			<td class="pt_imp_td" colspan="4" >
                <div class="pt_imp_span">فاکتور فروش</div>
            </td>
		</tr>
		<tr>
			<td class="pt_nor_td" colspan="2" style="border-right:1px solid black;border-bottom:none !important;border-left:1px solid black;">
                <span class="pt_nor_span" id="pa_shomarefactor">شماره فاکتور</span>
            </td>
			<td class="pt_nor_td" colspan="2" style="border-bottom:none !important;border-left:1px solid black;">
                <span class="pt_nor_span" id="pa_tarikhe_factor">تاریخ فاکتور</span>
            </td>
		</tr>
        <tr>
			<td class="pt_imp_td" colspan="4">
                <div class="pt_imp_span">مشخصات فروشنده</div>
            </td>
		</tr>
        <tr>
            <td class="pt_nor_td" colspan="1" style="border-right:1px solid black !important;">
                <span class="pt_nor_span" id="pa_fo_name">نام</span>
            </td>
            <td class="pt_nor_td" colspan="2">
                <span class="pt_nor_span" id="pa_fo_code_eghtesadi">کد اقتصادی</span>
            </td>
			<td class="pt_nor_td" colspan="1" style="border-left:1px solid black !important;">
                <span class="pt_nor_span" id="pa_fo_shomare_sabt">شماره ثبت</span>
            </td>
		</tr>
		<tr>
			<td class="pt_nor_td" colspan="1" style="border-right:1px solid black !important;">
                <span class="pt_nor_span" id="pa_fo_code_posti">کد پستی</span>
            </td>
			<td class="pt_nor_td" colspan="1">
                <span class="pt_nor_span" id="pa_fo_telephone">تلفن</span>
            </td>
			<td class="pt_nor_td" colspan="1">
                <span class="pt_nor_span" id="pa_fo_ostan">استان</span>
            </td>
			<td class="pt_nor_td" colspan="1" style="border-left:1px solid black !important;">
                <span class="pt_nor_span" id="pa_fo_shahr">شهر</span>
            </td>
		</tr>
        <tr>
            <td class="pt_nor_td" colspan="4" style="border-right:1px solid black !important;border-left:1px solid black;">
                <span class="pt_nor_span" id="pa_fo_address">آدرس</span>
            </td>
        </tr>
		<tr>
			<td class="pt_imp_td" colspan="4">
                <div class="pt_imp_span">مشخصات خریدار</div>
            </td>
		</tr>
		<tr>
            <td class="pt_nor_td" colspan="2" style="border-right:1px solid black;">
                <span class="pt_nor_span" id="pa_name_va_family">نام</span>
            </td>
			<td class="pt_nor_td" colspan="2" style="border-left:1px solid black;">
                <span class="pt_nor_span" id="pa_code_meli">کد ملی</span>
            </td>
		</tr>
		<tr>
			<td class="pt_nor_td" colspan="2" style="border-right:1px solid black;">
                <span class="pt_nor_span" id="pa_code_eshterak">کد اشتراک</span>
            </td>
			<td class="pt_nor_td" colspan="2" style="border-left:1px solid black;">
                <span class="pt_nor_span" id="pa_mobile">تلفن همراه</span>
            </td>
		</tr>
		<tr>
            <td class="pt_nor_td" colspan="1">
                <span class="pt_nor_span" id="pa_code_posti" style="border-right:1px solid black;">کد پستی</span>
            </td>
            <td class="pt_nor_td" colspan="1">
                <span class="pt_nor_span" id="pa_telephone">تلفن</span>
            </td>
            <td class="pt_nor_td" colspan="1">
                <span class="pt_nor_span" id="pa_ostan">استان</span>
            </td>
			<td class="pt_nor_td" colspan="1" style="border-left:1px solid black;">
                <span class="pt_nor_span" id="pa_shahr">شهر</span>
            </td>
		</tr>
		<tr>
			<td class="pt_nor_td" colspan="4" style="border-right:1px solid black;border-left:1px solid black;">

                <span class="pt_nor_span" id="pa_address">آدرس</span>
            </td>
		</tr>
		<tr>
			<td class="pt_imp_td" style="text-align: center;" colspan="2">
                <span class="pt_imp_span">مضخصات سرویس</span>
            </td>
			<td class="pt_imp_td" style="text-align: center;border-right:none !important;" colspan="2">
                <span class="pt_imp_span">توضیحات فاکتور</span>
            </td>
		</tr>
		<tr>
			<td class="pt_nor_tdr" style="border-right:1px solid black;border-bottom:1px solid black;border-left:1px solid black;">
                <span class="pt_nor_span">نوع خدمات</span>
            </td>
			<td class="border_lb pt_nor_span_leftalign">
                <span id="pa_noe_khadamat"></span>
            </td>
			<td class="pt_nor_td" colspan="2" rowspan="15" valign="top" style="border-left:1px solid black;border-right:none !important;">
                <span class="pt_nor_span" id="pa_tozihate_factor"></span>
            </td>
		</tr>
		<tr>
			<td class="pt_nor_tdr" style="border-right:1px solid black;border-bottom:1px solid black;border-left:1px solid black;">
                <span class="pt_nor_span">زمان استفاده (روز)</span>
            </td>
			<td class="border_lb pt_nor_span_leftalign">
                <span id="pa_zaname_estefade"></span>
            </td>
		</tr>
		<tr>
			<td class="pt_nor_tdr" style="border-right:1px solid black;border-bottom:1px solid black;border-left:1px solid black;"><sapn class="pt_nor_span">تاریخ شروع سرویس</span></td>
			<td class="border_lb pt_nor_span_leftalign">
                <span id="pa_tarikhe_shoroe_service"></span>
            </td>
		</tr>
		<tr>
			<td class="pt_nor_tdr" style="border-right:1px solid black;border-bottom:1px solid black;border-left:1px solid black;"><sapn class="pt_nor_span">تاریخ پایان سرویس</span></td>
			<td class="border_lb pt_nor_span_leftalign"><span id="pa_tarikhe_payane_service"></span></td>
		</tr>
		<tr>
			<td class="pt_nor_tdr" style="border-right:1px solid black;border-bottom:1px solid black;border-left:1px solid black;">
                <span class="pt_nor_span">قیمت سرویس</span>
            </td>
			<td class="border_lb pt_nor_span_leftalign">
                <span id="pa_gheymate_service"></span>
            </td>
		</tr>
		<tr>
            <td class="pt_nor_tdr" style="border-right:1px solid black;border-bottom:1px solid black;border-left:1px solid black;">
                <span class="pt_nor_span">تخفیف</span>
            </td>
			<td class="border_lb pt_nor_span_leftalign">
                <span id="pa_takhfif"></span>
            </td>
		</tr>
		<tr>
            <td class="pt_nor_tdr" style="border-right:1px solid black;border-bottom:1px solid black;border-left:1px solid black;">
                <span class="pt_nor_span">هزینه رانژه</span>
            </td>
			<td class="border_lb pt_nor_span_leftalign">
                <span id="pa_hazine_ranzhe"></span>
            </td>
		</tr>
		<tr>
            <td class="pt_nor_tdr" style="border-right:1px solid black;border-bottom:1px solid black;border-left:1px solid black;">
                <span class="pt_nor_span">هزینه درانژه</span>
            </td>
			<td class="border_lb pt_nor_span_leftalign">
                <span id="pa_hazine_dranzhe"></span>
            </td>
		</tr>
		<tr>
            <td class="pt_nor_tdr" style="border-right:1px solid black;border-bottom:1px solid black;border-left:1px solid black;">
                <span class="pt_nor_span">هزینه نصب</span>
            </td>
			<td class="border_lb pt_nor_span_leftalign">
                <span id="pa_hazine_nasb"></span>
            </td>
		</tr>
		<tr>
            <td class="pt_nor_tdr" style="border-right:1px solid black;border-bottom:1px solid black;border-left:1px solid black;">
                <span class="pt_nor_span">آبونمان پورت</span>
            </td>
			<td class="border_lb pt_nor_span_leftalign">
                <span id="pa_abonmane_port"></span>
            </td>
		</tr>
		<tr>
            <td class="pt_nor_tdr" style="border-right:1px solid black;border-bottom:1px solid black;border-left:1px solid black;">
                <span class="pt_nor_span">آبونمان فضا</span>
            </td>
			<td class="border_lb pt_nor_span_leftalign">
                <span id="pa_abonmane_faza"></span>
            </td>
		</tr>
		<tr>
            <td class="pt_nor_tdr" style="border-right:1px solid black;border-bottom:1px solid black;border-left:1px solid black;">
                <span class="pt_nor_span">آبونمان تجهیزات</span>
            </td>
			<td class="border_lb pt_nor_span_leftalign">
                <span id="pa_abonmane_tajhizat"></span>
            </td>
		</tr>
		<tr>
            <td class="pt_nor_tdr" style="border-right:1px solid black;border-bottom:1px solid black;border-left:1px solid black;">
                <span class="pt_nor_span">عوارض ارزش افزوده</span>
            </td>
			<td class="border_lb pt_nor_span_leftalign">
                <span id="pa_darsade_avareze_arzeshe_afzode"></span>
            </td>
		</tr>
		<tr>
            <td class="pt_nor_tdr" style="border-right:1px solid black;border-bottom:1px solid black;border-left:1px solid black;">
                <span class="pt_nor_span">مالیات ارزش افزوده</span>
            </td>
			<td class="border_lb pt_nor_span_leftalign">
                <span id="pa_maliate_arzeshe_afzode"></span>
            </td>
		</tr>
		<tr>
            <td class="" style="border-right:1px solid black !important;border-left:1px solid black !important;">
                <span class="pt_nor_span" style="font-weight:bold;">مبلغ قابل پرداخت (ریال)</span>
            </td>
			<td class="border_lb pt_nor_span_leftalign" style="border-bottom:none !important;font-weight:bold;">
                <span id="pa_mablaghe_ghabele_pardakht" style="font-weight:bold;"></span>
            </td>
		</tr>
        <tr>
			<td class="pt_imp_td" style="text-align: center;border-left:1px solid black !important;border-bottom:none !important;font-weight:bolder;" colspan="2">کارشناس / نماینده فروش</td>
			<td class="pt_imp_td" style="text-align: center;font-weight:bolder;border-right:none !important;" colspan="2">مهر و امضا شرکت / نماینده فروش</td>
		</tr>
        <tr>
			<td class="pt_imp_td" style="height:100px;text-align:right !important;padding-right:5px !important;padding-left:5px !important;padding-top:5px !important;margin-top:auto;border-left:1px solid black !important;font-weight:bold;" valign="top" colspan="2" rowspan="5">
                <span class="pt_imp_span" id="pa_name_sherkat"></span>
            </td>
			<td class="pt_imp_td" style="height:100px;border-right:none !important;padding-right:5px !important;padding-top:5px !important;padding-left:5px !important;" valign="top" colspan="2" rowspan="5">
                <span class="pt_imp_span"></span>
            </td>
		</tr>
	</tbody>
</table>
</div>


<!-- print_form_wireless --->
<div style="display:none;width: 500px;height: 650px;margin: auto;border: 1px solid black;" id="print_form_wireless">
<table class="prints_tables" dir="rtl" style="width: 500px;height: 650px;margin: auto;table-layout: fixed;border:0;" cellspacing="0" cellpadding="0">
	<tbody>
		<tr>
			<td colspan="2">
                <img class="pt_headerimg" src="<?php echo __ROOT__ . 'public/images/logo1.jpg' ?>" alt=""
                     style=""></td>
			<td colspan="2">
                <ul class="pt_headermatn" style="">
                    <li style="">&lrm;آدرس: تهران شهرک قدس(غرب) بلوار شهید فرحزادی خیابان شهید
                        حافظی(ارغوان غربی) پلاک10 واحد8&lrm;</li>
                    <li style="">تلفن: &lrm;0212376081-5&lrm; و &lrm;02191033501-5&lrm;</li>
                    <li style="">دورنگار: &lrm;0212209750&lrm;</li>
                    <li style="">وب سایت: www.saharertenat.net</li>
                    <li style="">دارای پروانه ارائه خدمات ارتباطی به شماره &lrm;100-95-39&lrm; از سازمان تنظیم مقررات و ارتباطات رادیویی کشور</li>
                </ul>
            </td>
		</tr>
		<tr>
			<td class="pt_imp_td" colspan="4" >
                <div class="pt_imp_span">فاکتور فروش</div>
            </td>
		</tr>
		<tr>
			<td class="pt_nor_td" colspan="2" style="border-right:1px solid black;border-bottom:none !important;border-left:1px solid black;">
                <span class="pt_nor_span" id="wa_shomarefactor">شماره فاکتور</span>
            </td>
			<td class="pt_nor_td" colspan="2" style="border-bottom:none !important;border-left:1px solid black;">
                <span class="pt_nor_span" id="wa_tarikhe_factor">تاریخ فاکتور</span>
            </td>
		</tr>
        <tr>
			<td class="pt_imp_td" colspan="4" >
                <div class="pt_imp_span">مشخصات فروشنده</div>
            </td>
		</tr>
        <tr>
            <td class="pt_nor_td" colspan="1" style="border-right:1px solid black;">
                <span class="pt_nor_span" id="wa_fo_name">نام</span>
            </td>
            <td class="pt_nor_td" colspan="2">
                <span class="pt_nor_span" id="wa_fo_code_eghtesadi">کد اقتصادی</span>
            </td>
			<td class="pt_nor_td" colspan="1" style="border-left:1px solid black;">
                <span class="pt_nor_span" id="wa_fo_shomare_sabt">شماره ثبت</span>
            </td>
		</tr>
		<tr>
			<td class="pt_nor_td" colspan="1" style="border-right:1px solid black;">
                <span class="pt_nor_span" id="wa_fo_code_posti">کد پستی</span>
            </td>
			<td class="pt_nor_td" colspan="1">
                <span class="pt_nor_span" id="wa_fo_telephone">تلفن</span>
            </td>
			<td class="pt_nor_td" colspan="1">
                <span class="pt_nor_span" id="wa_fo_ostan">استان</span>
            </td>
			<td class="pt_nor_td" colspan="1" style="border-left:1px solid black;">
                <span class="pt_nor_span" id="wa_fo_shahr">شهر</span>
            </td>
		</tr>
        <tr>
            <td class="pt_nor_td" colspan="4" style="border-right:1px solid black;border-left:1px solid black;">
                <span class="pt_nor_span" id="wa_fo_address">آدرس</span>
            </td>
        </tr>
		<tr>
			<td class="pt_imp_td" colspan="4">
                <div class="pt_imp_span">مشخصات خریدار</div>
            </td>
		</tr>
		<tr>
            <td class="pt_nor_td" colspan="2" style="border-right:1px solid black;">
                <span class="pt_nor_span" id="wa_name_va_family">نام</span>
            </td>
			<td class="pt_nor_td" colspan="2" style="border-left:1px solid black;">
                <span class="pt_nor_span" id="wa_code_meli">کد ملی</span>
            </td>
		</tr>
		<tr>
			<td class="pt_nor_td" colspan="2" style="border-right:1px solid black;">
                <span class="pt_nor_span" id="wa_code_eshterak">کد اشتراک</span>
            </td>
			<td class="pt_nor_td" colspan="2" style="border-left:1px solid black;">
                <span class="pt_nor_span" id="wa_mobile">تلفن همراه</span>
            </td>
		</tr>
		<tr>
            <td class="pt_nor_td" colspan="1">
                <span class="pt_nor_span" id="wa_code_posti" style="border-right:1px solid black;">کد پستی</span>
            </td>
            <td class="pt_nor_td" colspan="1">
                <span class="pt_nor_span" id="wa_telephone">تلفن</span>
            </td>
            <td class="pt_nor_td" colspan="1">
                <span class="pt_nor_span" id="wa_ostan">استان</span>
            </td>
			<td class="pt_nor_td" colspan="1" style="border-left:1px solid black;">
                <span class="pt_nor_span" id="wa_shahr">شهر</span>
            </td>
		</tr>
		<tr>
			<td class="pt_nor_td" colspan="4" style="border-right:1px solid black;border-left:1px solid black;">
            
                <span class="pt_nor_span" id="wa_address">آدرس</span>
            </td>
		</tr>
		<tr>
			<td class="pt_imp_td" style="text-align: center;" colspan="2">
                <span class="pt_imp_span">مضخصات سرویس</span>
            </td>
			<td class="pt_imp_td" style="text-align: center;border-right:none !important;border-left:1px solid black;" colspan="2">
                <span class="pt_imp_span">توضیحات فاکتور</span>
            </td>
		</tr>
		<tr>
			<td class="pt_nor_tdr" style="border-right:1px solid black;">
                <span class="pt_nor_span">نوع خدمات</span>
            </td>
			<td class="border_lb pt_nor_span_leftalign" style="border-right:1px solid black;">
                <span id="wa_noe_khadamat"></span>
            </td>
			<td class="pt_nor_td" colspan="2" rowspan="9" valign="top" style="border-left:1px solid black;">
                <span class="pt_nor_span" id="wa_tozihate_factor"></span>
            </td>
		</tr>
		<tr>
			<td class="pt_nor_tdr" style="border-right:1px solid black;border-bottom:1px solid black;border-left:1px solid black;border-top:1px solid black;">
                <span class="pt_nor_span">زمان استفاده (روز)</span>
            </td>
			<td class="border_lb pt_nor_span_leftalign">
                <span id="wa_zaname_estefade"></span>
            </td>
		</tr>
		<tr>
			<td class="pt_nor_tdr" style="border-right:1px solid black;border-bottom:1px solid black;border-left:1px solid black;"><sapn class="pt_nor_span">تاریخ شروع سرویس</span></td>
			<td class="border_lb pt_nor_span_leftalign">
                <span id="wa_tarikhe_shoroe_service"></span>
            </td>
		</tr>
		<tr>
			<td class="pt_nor_tdr" style="border-right:1px solid black;border-bottom:1px solid black;border-left:1px solid black;"><sapn class="pt_nor_span">تاریخ پایان سرویس</span></td>
			<td class="border_lb pt_nor_span_leftalign"><span id="wa_tarikhe_payane_service"></span></td>
		</tr>
		<tr>
			<td class="pt_nor_tdr" style="border-right:1px solid black;border-bottom:1px solid black;border-left:1px solid black;">
                <span class="pt_nor_span">قیمت سرویس</span>
            </td>
			<td class="border_lb pt_nor_span_leftalign">
                <span id="wa_gheymate_service"></span>
            </td>
		</tr>
		<tr>
            <td class="pt_nor_tdr" style="border-right:1px solid black;border-bottom:1px solid black;border-left:1px solid black;">
                <span class="pt_nor_span">تخفیف</span>
            </td>
			<td class="border_lb pt_nor_span_leftalign">
                <span id="wa_takhfif"></span>
            </td>
		</tr>
		<tr>
            <td class="pt_nor_tdr" style="border-right:1px solid black;border-bottom:1px solid black;border-left:1px solid black;">
                <span class="pt_nor_span">عوارض ارزش افزوده</span>
            </td>
			<td class="border_lb pt_nor_span_leftalign">
                <span id="wa_darsade_avareze_arzeshe_afzode"></span>
            </td>
		</tr>
		<tr>
            <td class="pt_nor_tdr" style="border-right:1px solid black;border-bottom:1px solid black;border-left:1px solid black;">
                <span class="pt_nor_span">مالیات ارزش افزوده</span>
            </td>
			<td class="border_lb pt_nor_span_leftalign">
                <span id="wa_maliate_arzeshe_afzode"></span>
            </td>
		</tr>
		<tr>
            <td class="" style="border-right:1px solid black !important;border-left:1px solid black !important;">
                <span class="pt_nor_span" style="font-weight:bold;">مبلغ قابل پرداخت (ریال)</span>
            </td>
			<td class="border_lb pt_nor_span_leftalign" style="border-bottom:none !important;font-weight:bold;">
                <span id="wa_mablaghe_ghabele_pardakht" style="font-weight:bold;"></span>
            </td>
		</tr>
        <tr>
			<td class="pt_imp_td" style="text-align: center;border-left:1px solid black !important;border-bottom:none !important;font-weight:bolder;" colspan="2">کارشناس / نماینده فروش</td>
			<td class="pt_imp_td" style="text-align: center;font-weight:bolder;border-right:none !important;" colspan="2">مهر و امضا شرکت / نماینده فروش</td>
		</tr>
        <tr>
			<td class="pt_imp_td" style="height:100px;text-align:right !important;padding-right:5px !important;padding-left:5px !important;padding-top:5px !important;margin-top:auto;border-left:1px solid black !important;font-weight:bold;" valign="top" colspan="2" rowspan="5">
                <span class="pt_imp_span" id="wa_name_sherkat"></span>
            </td>
			<td class="pt_imp_td" style="height:100px;border-right:none !important;padding-right:5px !important;padding-top:5px !important;padding-left:5px !important;" valign="top" colspan="2" rowspan="5">
                <span class="pt_imp_span"></span>
            </td>
		</tr>
	</tbody>
</table>
</div>


<!-- print_form_voip -->
<div style="display:none;width:margin: auto;" id="print_form_voip">
<table class="prints_tables" dir="rtl" style="width: 500px;height: 650px;margin: auto;table-layout: fixed;border:1px solid black;" cellspacing="0" cellpadding="0">
	<tbody>
		<tr>
			<td colspan="2">
                <img class="pt_headerimg" src="<?php echo __ROOT__ . 'public/images/logo1.jpg' ?>" alt=""
                     style=""></td>
			<td colspan="2">
                <ul class="pt_headermatn" style="">
                    <li style="">&lrm;آدرس: تهران شهرک قدس(غرب) بلوار شهید فرحزادی خیابان شهید
                        حافظی(ارغوان غربی) پلاک10 واحد8&lrm;</li>
                    <li style="">تلفن: &lrm;0212376081-5&lrm; و &lrm;02191033501-5&lrm;</li>
                    <li style="">دورنگار: &lrm;0212209750&lrm;</li>
                    <li style="">وب سایت: www.saharertenat.net</li>
                    <li style="">دارای پروانه ارائه خدمات ارتباطی به شماره &lrm;100-95-39&lrm; از سازمان تنظیم مقررات و ارتباطات رادیویی کشور</li>
                </ul>
            </td>
		</tr>
		<tr>
			<td class="pt_imp_td" colspan="4" style="border-left:none;border-right:none;">
                <div class="pt_imp_span">فاکتور فروش</div>
            </td>
		</tr>
		<tr>
			<td class="pt_nor_td" colspan="2">
                <span class="pt_nor_span" id="vo_shomarefactor">شماره فاکتور</span>
            </td>
			<td class="pt_nor_td" colspan="2">
                <span class="pt_nor_span" id="vo_tarikhe_factor">تاریخ فاکتور</span>
            </td>
		</tr>
		<tr>
			<td class="pt_imp_td" colspan="4" style="border-left:none;border-right:none;">
                <div class="pt_imp_span">مشخصات فروشنده</div>
            </td>
		</tr>
        <tr>
            <td class="pt_nor_td" colspan="1">
                <span class="pt_nor_span" id="vo_fo_name">نام</span>
            </td>
            <td class="pt_nor_td" colspan="2">
                <span class="pt_nor_span" id="vo_fo_code_eghtesadi">کد اقتصادی</span>
            </td>
			<td class="pt_nor_td" colspan="1">
                <span class="pt_nor_span" id="vo_fo_shomare_sabt">شماره ثبت</span>
            </td>
		</tr>
		<tr>
			<td class="pt_nor_td" colspan="1">
                <span class="pt_nor_span" id="vo_fo_code_posti">کد پستی</span>
            </td>
			<td class="pt_nor_td" colspan="1">
                <span class="pt_nor_span" id="vo_fo_telephone">تلفن</span>
            </td>
			<td class="pt_nor_td" colspan="1">
                <span class="pt_nor_span" id="vo_fo_ostan">استان</span>
            </td>
			<td class="pt_nor_td" colspan="1">
                <span class="pt_nor_span" id="vo_fo_shahr">شهر</span>
            </td>
		</tr>
        <tr>
            <td class="pt_nor_td" colspan="4">
                <span class="pt_nor_span" id="vo_fo_address">آدرس</span>
            </td>
        </tr>
		<tr>
			<td class="pt_imp_td" colspan="4" style="border-left:none;border-right:none;">
                <div class="pt_imp_span">مشخصات خریدار</div>
            </td>
		</tr>
		<tr>
            <td class="pt_nor_td" colspan="2">
                <span class="pt_nor_span" id="vo_name_va_family">نام</span>
            </td>
			<td class="pt_nor_td" colspan="2">
                <span class="pt_nor_span" id="vo_code_meli">کد ملی</span>
            </td>
		</tr>
		<tr>
			<td class="pt_nor_td" colspan="2">
                <span class="pt_nor_span" id="vo_code_eshterak">کد اشتراک</span>
            </td>
			<td class="pt_nor_td" colspan="2">
                <span class="pt_nor_span" id="vo_mobile">تلفن همراه</span>
            </td>
		</tr>
		<tr>
            <td class="pt_nor_td" colspan="1">
                <span class="pt_nor_span" id="vo_code_posti">کد پستی</span>
            </td>
            <td class="pt_nor_td" colspan="1">
                <span class="pt_nor_span" id="vo_telephone">تلفن</span>
            </td>
            <td class="pt_nor_td" colspan="1">
                <span class="pt_nor_span" id="vo_ostan">استان</span>
            </td>
			<td class="pt_nor_td" colspan="1">
                <span class="pt_nor_span" id="vo_shahr">شهر</span>
            </td>
		</tr>
		<tr>
			<td class="pt_nor_td" colspan="4">
                <span class="pt_nor_span" id="vo_address">آدرس</span>
            </td>
		</tr>
		<tr>
			<td class="pt_imp_td" style="text-align: center;" colspan="2">
                <span class="pt_imp_span">مضخصات سرویس</span>
            </td>
			<td class="pt_imp_td" style="text-align: center;" colspan="2">
                <span class="pt_imp_span">توضیحات فاکتور</span>
            </td>
		</tr>
		<tr>
			<td class="pt_nor_tdr" >
                <span class="pt_nor_span" style="border-right:1px solid black;">نوع خدمات</span>
            </td>
			<td class="border_lb pt_nor_span_leftalign" style="border-right:1px solid black;">
                <span id="vo_noe_khadamat"></span>
            </td>
		</tr>
		<tr>
			<td class="pt_nor_tdr" style="border:1px solid black;">
                <span class="pt_nor_span">زمان استفاده (روز)</span>
            </td>
			<td class="border_lb pt_nor_span_leftalign">
                <span id="vo_zaname_estefade"></span>
            </td>
		</tr>
		<tr>
			<td class="pt_nor_tdr" style="border-right:1px solid black;border-bottom:1px solid black;border-left:1px solid black;"><sapn class="pt_nor_span">تاریخ شروع سرویس</span></td>
			<td class="border_lb pt_nor_span_leftalign">
                <span id="vo_tarikhe_shoroe_service"></span>
            </td>
		</tr>
		<tr>
			<td class="pt_nor_tdr" style="border-right:1px solid black;border-bottom:1px solid black;border-left:1px solid black;"><sapn class="pt_nor_span">تاریخ پایان سرویس</span></td>
			<td class="border_lb pt_nor_span_leftalign"><span id="vo_tarikhe_payane_service"></span></td>
		</tr>
		<tr>
			<td class="pt_nor_tdr" style="border-right:1px solid black;border-bottom:1px solid black;border-left:1px solid black;">
                <span class="pt_nor_span">قیمت سرویس</span>
            </td>
			<td class="border_lb pt_nor_span_leftalign">
                <span id="vo_gheymate_service"></span>
            </td>
		</tr>
		<tr>
            <td class="pt_nor_tdr" style="border-right:1px solid black;border-bottom:1px solid black;border-left:1px solid black;">
                <span class="pt_nor_span">تخفیف</span>
            </td>
			<td class="border_lb pt_nor_span_leftalign">
                <span id="vo_takhfif"></span>
            </td>
		</tr>
		<tr>
            <td class="pt_nor_tdr" style="border-right:1px solid black;border-bottom:1px solid black;border-left:1px solid black;">
                <span class="pt_nor_span">پین کد</span>
            </td>
			<td class="border_lb pt_nor_span_leftalign">
                <span id="vo_pin_code"></span>
            </td>
		</tr>
		<tr>
            <td class="pt_nor_tdr" style="border-right:1px solid black;border-bottom:1px solid black;border-left:1px solid black;">
                <span class="pt_nor_span">عوارض ارزش افزوده</span>
            </td>
			<td class="border_lb pt_nor_span_leftalign">
                <span id="vo_darsade_avareze_arzeshe_afzode"></span>
            </td>
		</tr>
		<tr>
            <td class="pt_nor_tdr" style="border-right:1px solid black;border-bottom:1px solid black;border-left:1px solid black;">
                <span class="pt_nor_span">مالیات ارزش افزوده</span>
            </td>
			<td class="border_lb pt_nor_span_leftalign">
                <span id="vo_maliate_arzeshe_afzode"></span>
            </td>
		</tr>
		<tr>
            <td class="" style="border-right:1px solid black !important;border-left:1px solid black !important;">
                <span class="pt_nor_span" style="font-weight:bold;">مبلغ قابل پرداخت (ریال)</span>
            </td>
			<td class="border_lb pt_nor_span_leftalign" style="border-bottom:none !important;font-weight:bold;">
                <span id="vo_mablaghe_ghabele_pardakht" style="font-weight:bold;"></span>
            </td>
		</tr>
        <tr>
			<td class="pt_imp_td" style="text-align: center;border-left:1px solid black !important;border-bottom:none !important;font-weight:bolder;" colspan="2">کارشناس / نماینده فروش</td>
			<td class="pt_imp_td" style="text-align: center;font-weight:bolder;border-right:none !important;" colspan="2">مهر و امضا شرکت / نماینده فروش</td>
		</tr>
        <tr>
			<td class="pt_imp_td" style="height:100px;text-align:right !important;padding-right:5px !important;padding-left:5px !important;padding-top:5px !important;margin-top:auto;border-left:1px solid black !important;font-weight:bold;" valign="top" colspan="2" rowspan="5">
                <span class="pt_imp_span" id="vo_name_sherkat"></span>
            </td>
			<td class="pt_imp_td" style="height:100px;border-right:none !important;padding-right:5px !important;padding-top:5px !important;padding-left:5px !important;" valign="top" colspan="2" rowspan="5">
                <span class="pt_imp_span"></span>
            </td>
		</tr>
	</tbody>
</table>
</div>
