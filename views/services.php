        <!-- Content area -->
        <div class="content">

            <!-- Form inputs -->
            <div class="card">
                <div class="card-body">
                    <legend class="text-uppercase font-size-sm font-weight-bold">سرویس ها</legend>
                    <ul class="nav nav-tabs nav-tabs-bottom border-bottom-0 nav-justified">
                        <li class="nav-item services_tabs"><a href="#bottom-justified-divided-tab1" class="nav-link active" data-toggle="tab">BITSTREAM</a></li>
                        <li class="nav-item services_tabs"><a href="#bottom-justified-divided-tab2" class="nav-link" data-toggle="tab">ADSL/VDSL</a></li>
                        <li class="nav-item services_tabs"><a href="#bottom-justified-divided-tab3" class="nav-link" data-toggle="tab">Wireless</a></li>
                        <li class="nav-item services_tabs"><a href="#bottom-justified-divided-tab4" class="nav-link" data-toggle="tab">TD-LTE/4G</a></li>
                        <li class="nav-item services_tabs"><a href="#bottom-justified-divided-tab5" class="nav-link" data-toggle="tab">Voip(Orgination)</a></li>
                    </ul>
                    <div class="tab-content">
                        <!------------BITSTREAM------------->
                        <div class="bs_tab tab-pane show active" id="bottom-justified-divided-tab1">
                            <form action="#" method="POST">
                                <input type="hidden" id="bs_id" name="id" value="empty" class="form-control">
                                <input type="hidden" id="bs_type" name="type" value="bitstream" class="form-control">

                                <fieldset class="mb-3">
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-2">نوع خدمات</label>
                                        <div class="col-lg-4">
                                            <select class="form-control form-control-lg custom-select" name="noe_khadamat" id="bs_noe_khadamat">
                                                <option value='BITSTREAM_ADSL'>ADSL</option>
                                                <option value='BITSTREAM_VDSL'>VDSL</option>
                                            </select>
                                        </div>

                                        <label class="col-form-label col-lg-2">نمایش سرویس</label>
                                        <div class="col-lg-4">
                                            <select class="form-control form-control-lg custom-select" name="namayeshe_service" id="bs_namayeshe_service">
                                                <option value="yes">بلی</option>
                                                <option value="no">خیر</option>
                                            </select>
                                        </div>

                                        <label class="col-form-label col-lg-2">نمایش در پروفایل</label>
                                        <div class="col-lg-4">
                                            <select class="form-control form-control-lg custom-select" name="namayeshe_dar_profile" id="bs_namayeshe_dar_profile">
                                                <option value="yes">بلی</option>
                                                <option value="no">خیر</option>
                                            </select>
                                        </div>

                                        <label class="col-form-label col-lg-2">عنوان سرویس</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="onvane_service" placeholder="مثال: " id="bs_onvane_service">
                                        </div>
                                        <label class="col-form-label col-lg-2">قيمت</label>
                                        <div class="col-lg-4">
                                            <input type="number" class="form-control" name="gheymat" placeholder="به ریال" id="bs_gheymat" required>
                                        </div>

                                        <label class="col-form-label col-lg-2">زمان استفاده</label>
                                        <div class="col-lg-4">
                                            <input type="number" class="form-control" name="zaname_estefade" id="bs_zaname_estefade" placeholder="زمان به روز مثال: 30">
                                        </div>

                                        <label class="col-form-label col-lg-2">تخفيف</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="takhfif" id="bs_takhfif" placeholder="به درصد مثال : 6.5">
                                        </div>

                                        <label class="col-form-label col-lg-2">نام سرویس دهنده</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="name_service_dahande" id="bs_name_service_dahande" placeholder="مثال: سحر ارتباط">
                                        </div>

                                        <label class="col-form-label col-lg-2">پورسانت</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="porsant" id="bs_porsant" placeholder="مثال : 6.5">
                                        </div>

                                        <label class="col-form-label col-lg-2">تاریخ شروع نمایش</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="tarikhe_shoroe_namayesh" id="bs_tarikhe_shoroe_namayesh" placeholder="مثال: 1380/05/20">
                                        </div>

                                        <label class="col-form-label col-lg-2">تاریخ پایان نمایش</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="tarikhe_payane_namayesh" id="bs_tarikhe_payane_namayesh" placeholder="مثال: 1380/05/20">
                                        </div>

                                        <label class="col-form-label col-lg-2">امتیاز جایزه</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="emtiaze_jayeze" id="bs_emtiaze_jayeze" placeholder="مثال : 6">
                                        </div>

                                        <label class="col-form-label col-lg-2">حداقل امتیاز</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="hadeaghale_emtiaz" id="bs_hadeaghale_emtiaz" placeholder="مثال : 6">
                                        </div>

                                        <label class="col-form-label col-lg-2">حداکثر امتیاز</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="hadeaksare_emtiaz" id="bs_hadeaksare_emtiaz" placeholder="مثال : 6">
                                        </div>

                                        <label class="col-form-label col-lg-2">مبلغ هر امتیاز</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="mablaghe_har_emtiaz" id="bs_mablaghe_har_emtiaz" placeholder="مثال : 6">
                                        </div>

                                        <label class="col-form-label col-lg-2">نام گروه مشتری</label>
                                        <div class="col-lg-4">
                                            <select class="form-control form-control-lg custom-select" name="name_grohe_moshtari" id="bs_name_grohe_moshtari">
                                                <option value="1">1</option>
                                            </select>
                                        </div>

                                        <label class="col-form-label col-lg-2">نام گروه</label>
                                        <div class="col-lg-4">
                                            <select class="form-control form-control-lg custom-select" id="bs_name_groh" name="name_groh">
                                                <option value="1">1</option>
                                            </select>
                                        </div>


                                        <label class="col-form-label col-lg-2"></label>
                                        <div class="col-lg-4">
                                        </div>


                                        <label class="col-form-label col-lg-2">رنگ نمایش پروفایل</label>
                                        <div class="col-lg-4">
                                            <div class="card card-body border-top-success text-center">
                                                <div class="d-inline-block">
                                                    <input type="text" class="form-control colorpicker-palette-toggle" name="range_namayeshe_profile" id="bs_range_namayeshe_profile" data-fouc>
                                                </div>
                                            </div>
                                        </div>
                                        <label class="col-form-label col-lg-2">رنگ ویژه سازی پروفایل</label>
                                        <div class="col-lg-4">
                                            <div class="card card-body border-top-success text-center">
                                                <div class="d-inline-block">
                                                    <input type="text" class="form-control colorpicker-palette-toggle" name="range_vizhesazie_profile" id="bs_range_vizhesazie_profile" data-fouc>
                                                </div>
                                            </div>
                                        </div>
                                        <legend class="text-uppercase font-size-sm font-weight-bold" style="color: #FB8C00">وصل موقت
                                        </legend>
                                        <label class="col-form-label col-lg-2">ساعت وصل موقت</label>
                                        <div class="col-lg-4">
                                            <input type="number" class="form-control" name="saat_vasle_movaghat" id="bs_saat_vasle_movaghat" placeholder="مثال : 2">
                                        </div>

                                        <label class="col-form-label col-lg-2">روز وصل موقت</label>
                                        <div class="col-lg-4">
                                            <input type="number" class="form-control" name="roze_vasle_movaghat" id="bs_roze_vasle_movaghat" placeholder="مثال : 5">
                                        </div>

                                        <label class="col-form-label col-lg-2">ترافیک وصل موقت</label>
                                        <div class="col-lg-10">
                                            <input type="number" class="form-control" name="terafike_vasle_movaghat" id="bs_terafike_vasle_movaghat" placeholder="(مگابایت) مثال: 1024">
                                        </div>

                                        <legend class="text-uppercase font-size-sm font-weight-bold" style="color: #FB8C00">ترافیک
                                        </legend>
                                        <label class="col-form-label col-lg-2">ترافیک</label>
                                        <div class="col-lg-4">
                                            <input type="number" class="form-control" name="terafik" id="bs_terafik" placeholder="(مگابایت)">
                                        </div>

                                        <legend class="text-uppercase font-size-sm font-weight-bold" style="color: #FB8C00">هزینه راه اندازی
                                        </legend>
                                        <label class="col-form-label col-lg-2">هزینه رانژه</label>
                                        <div class="col-lg-4">
                                            <input type="number" class="form-control" name="hazine_ranzhe" id="bs_hazine_ranzhe" placeholder="ریال">
                                        </div>

                                        <label class="col-form-label col-lg-2">هزینه نصب</label>
                                        <div class="col-lg-4">
                                            <input type="number" class="form-control" name="hazine_nasb" id="bs_hazine_nasb" placeholder="ریال">
                                        </div>

                                        <label class="col-form-label col-lg-2">هزینه درانژه</label>
                                        <div class="col-lg-4">
                                            <input type="number" class="form-control" name="hazine_dranzhe" id="bs_hazine_dranzhe" placeholder="ریال">
                                        </div>

                                        <legend class="text-uppercase font-size-sm font-weight-bold" style="color: #FB8C00">توضیحات
                                        </legend>
                                        <label class="col-form-label col-lg-2">توضیحات فاکتور</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="tozihate_faktor" id="bs_tozihate_faktor" placeholder="توضیحات فاکتور">
                                        </div>

                                        <label class="col-form-label col-lg-2">توضیحات وب سایت</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="tozihate_website" id="bs_tozihate_website" placeholder="توضیحات وب سایت">
                                        </div>

                                        <legend class="text-uppercase font-size-sm font-weight-bold" style="color: #FB8C00">سرعت اتصال
                                        </legend>
                                        <label class="col-form-label col-lg-2">سرعت پایه دریافت</label>
                                        <div class="col-lg-4">
                                            <input type="number" class="form-control" name="sorate_paye_daryaft" id="bs_sorate_paye_daryaft" placeholder="مگابیت" step="0.1">
                                        </div>

                                        <label class="col-form-label col-lg-2">حداکثر سرعت دریافت</label>
                                        <div class="col-lg-4">
                                            <input type="number" class="form-control" name="hadeaxar_sorat_daryaft" id="bs_hadeaxar_sorat_daryaft" placeholder="مگابیت" step="0.1">
                                        </div>

                                        <label class="col-form-label col-lg-2">سرعت پایه ارسال</label>
                                        <div class="col-lg-4">
                                            <input type="number" class="form-control" name="sorat_paye_ersal" id="bs_sorat_paye_ersal" placeholder="مگابیت" step="0.1">
                                        </div>


                                        <legend class="text-uppercase font-size-sm font-weight-bold" style="color: #FB8C00">آبونمان
                                        </legend>
                                        <label class="col-form-label col-lg-2">پورت</label>
                                        <div class="col-lg-4">
                                            <input type="number" class="form-control" name="port" id="bs_port" placeholder="">
                                        </div>

                                        <label class="col-form-label col-lg-2">تجهیزات</label>
                                        <div class="col-lg-4">
                                            <input type="number" class="form-control" name="tajhizat" id="bs_tajhizat" placeholder="">
                                        </div>

                                        <label class="col-form-label col-lg-2">فضا</label>
                                        <div class="col-lg-4">
                                            <input type="number" class="form-control" name="faza" id="bs_faza" placeholder="">
                                        </div>

                                        <legend class="text-uppercase col-sm-12 font-size-sm font-weight-bold" style="color: #FB8C00">نوع فروش
                                        </legend>
                                        <label class="col-form-label col-lg-2">نوع فروش سرویس</label>
                                        <div class="col-lg-4">
                                            <select class="form-control form-control-lg custom-select" required name="noe_forosh" id="bs_noe_forosh">
                                                <option value="adi">عادی</option>
                                                <option value="bulk">بالک</option>
                                                <option value="jashnvare">جشنواره</option>
                                            </select>
                                        </div>

                                        <label class="col-form-label col-lg-2">شناسه سرویس</label>
                                        <div class="col-lg-4">
                                        <input type="text" class="form-control" name="shenase_service" id="bs_shenase_service" placeholder="">
                                        </div>

                                    </div>
                                </fieldset>
                                <div class="text-right">
                                    <button type="submit" name="send_services_bs" class="btn btn-primary">ارسال <i class="icon-paperplane ml-2"></i></button>
                                </div>
                            </form>
                            <div class="card" style="margin-top: 10px">
                                <div class="col-md-12">
                                    <button name="delete_bs" class="btn btn-warning col-md-auto float-md-right" id="delete_bs">حذف<i class="icon-folder-remove ml-2"></i></button>
                                    <button name="edit_bs" class="btn btn-primary col-md-auto float-md-right" id="edit_bs">ویرایش<i class="icon-database-edit2 ml-2"></i></button>
                                    <table id="view_table_bs" class="table table-striped datatable-responsive table-hover">
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!------------ADSL/VDSL------------->
                        <div class="adsl_tab tab-pane fade" id="bottom-justified-divided-tab2">
                            <form action="#" method="POST">
                                <input type="hidden" id="adsl_id" name="id" value="empty" class="form-control">
                                <input type="hidden" id="adsl_type" name="type" value="adsl" class="form-control">

                                <fieldset class="mb-3">
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-2">نوع خدمات</label>
                                        <div class="col-lg-4">
                                            <select class="form-control form-control-lg custom-select" name="noe_khadamat" id="adsl_noe_khadamat">
                                                <option value="ADSL(Share)">ADSL(Share)</option>
                                                <option value="ADSL(Transport)">ADSL(Transport)</option>
                                                <option value="VDSL(Share)">VDSL(Share)</option>
                                                <option value="VDSL(Transport)">VDSL(Transport)</option>
                                            </select>
                                        </div>

                                        <label class="col-form-label col-lg-2">نمایش سرویس</label>
                                        <div class="col-lg-4">
                                            <select class="form-control form-control-lg custom-select" name="namayeshe_service" id="adsl_namayeshe_service">
                                                <option value="yes">بلی</option>
                                                <option value="no">خیر</option>
                                            </select>
                                        </div>

                                        <label class="col-form-label col-lg-2">نمایش در پروفایل</label>
                                        <div class="col-lg-4">
                                            <select class="form-control form-control-lg custom-select" name="namayeshe_dar_profile" id="adsl_namayeshe_dar_profile">
                                                <option value="yes">بلی</option>
                                                <option value="no">خیر</option>
                                            </select>
                                        </div>

                                        <label class="col-form-label col-lg-2">عنوان سرویس</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="onvane_service" placeholder="مثال: " id="adsl_onvane_service">
                                        </div>
                                        <label class="col-form-label col-lg-2">قيمت</label>
                                        <div class="col-lg-4">
                                            <input type="number" class="form-control" name="gheymat" placeholder="به ریال" id="adsl_gheymat" required>
                                        </div>

                                        <label class="col-form-label col-lg-2">زمان استفاده</label>
                                        <div class="col-lg-4">
                                            <input type="number" class="form-control" name="zaname_estefade" id="adsl_zaname_estefade" placeholder="زمان به روز مثال: 30">
                                        </div>

                                        <label class="col-form-label col-lg-2">تخفيف</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="takhfif" id="adsl_takhfif" placeholder="به درصد مثال : 6.5">
                                        </div>

                                        <label class="col-form-label col-lg-2">نام سرویس دهنده</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="name_service_dahande" id="adsl_name_service_dahande" placeholder="مثال: سحر ارتباط">
                                        </div>

                                        <label class="col-form-label col-lg-2">پورسانت</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="porsant" id="adsl_porsant" placeholder="مثال : 6.5">
                                        </div>

                                        <label class="col-form-label col-lg-2">تاریخ شروع نمایش</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="tarikhe_shoroe_namayesh" id="adsl_tarikhe_shoroe_namayesh" placeholder="مثال: 1380/05/20">
                                        </div>

                                        <label class="col-form-label col-lg-2">تاریخ پایان نمایش</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="tarikhe_payane_namayesh" id="adsl_tarikhe_payane_namayesh" placeholder="مثال: 1380/05/20">
                                        </div>

                                        <label class="col-form-label col-lg-2">امتیاز جایزه</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="emtiaze_jayeze" id="adsl_emtiaze_jayeze" placeholder="مثال : 6">
                                        </div>

                                        <label class="col-form-label col-lg-2">حداقل امتیاز</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="hadeaghale_emtiaz" id="adsl_hadeaghale_emtiaz" placeholder="مثال : 6">
                                        </div>

                                        <label class="col-form-label col-lg-2">حداکثر امتیاز</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="hadeaksare_emtiaz" id="adsl_hadeaksare_emtiaz" placeholder="مثال : 6">
                                        </div>

                                        <label class="col-form-label col-lg-2">مبلغ هر امتیاز</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="mablaghe_har_emtiaz" id="adsl_mablaghe_har_emtiaz" placeholder="مثال : 6">
                                        </div>

                                        <label class="col-form-label col-lg-2">نام گروه مشتری</label>
                                        <div class="col-lg-4">
                                            <select class="form-control form-control-lg custom-select" name="name_grohe_moshtari" id="adsl_name_grohe_moshtari">
                                                <option value="1">1</option>
                                            </select>
                                        </div>

                                        <label class="col-form-label col-lg-2">نام گروه</label>
                                        <div class="col-lg-4">
                                            <select class="form-control form-control-lg custom-select" id="adsl_name_groh" name="name_groh">
                                                <option value="1">1</option>
                                            </select>
                                        </div>


                                        <label class="col-form-label col-lg-2"></label>
                                        <div class="col-lg-4">
                                        </div>


                                        <label class="col-form-label col-lg-2">رنگ نمایش پروفایل</label>
                                        <div class="col-lg-4">
                                            <div class="card card-body border-top-success text-center">
                                                <div class="d-inline-block">
                                                    <input type="text" class="form-control colorpicker-palette-toggle" name="range_namayeshe_profile" id="adsl_range_namayeshe_profile" data-fouc>
                                                </div>
                                            </div>
                                        </div>
                                        <label class="col-form-label col-lg-2">رنگ ویژه سازی پروفایل</label>
                                        <div class="col-lg-4">
                                            <div class="card card-body border-top-success text-center">
                                                <div class="d-inline-block">
                                                    <input type="text" class="form-control colorpicker-palette-toggle" name="range_vizhesazie_profile" id="adsl_range_vizhesazie_profile" data-fouc>
                                                </div>
                                            </div>
                                        </div>
                                        <legend class="text-uppercase font-size-sm font-weight-bold" style="color: #FB8C00">وصل موقت
                                        </legend>
                                        <label class="col-form-label col-lg-2">ساعت وصل موقت</label>
                                        <div class="col-lg-4">
                                            <input type="number" class="form-control" name="saat_vasle_movaghat" id="adsl_saat_vasle_movaghat" placeholder="مثال : 2">
                                        </div>

                                        <label class="col-form-label col-lg-2">روز وصل موقت</label>
                                        <div class="col-lg-4">
                                            <input type="number" class="form-control" name="roze_vasle_movaghat" id="adsl_roze_vasle_movaghat" placeholder="مثال : 5">
                                        </div>

                                        <label class="col-form-label col-lg-2">ترافیک وصل موقت</label>
                                        <div class="col-lg-10">
                                            <input type="number" class="form-control" name="terafike_vasle_movaghat" id="adsl_terafike_vasle_movaghat" placeholder="(مگابایت) مثال: 1024">
                                        </div>

                                        <legend class="text-uppercase font-size-sm font-weight-bold" style="color: #FB8C00">ترافیک
                                        </legend>
                                        <label class="col-form-label col-lg-2">ترافیک</label>
                                        <div class="col-lg-4">
                                            <input type="number" class="form-control" name="terafik" id="adsl_terafik" placeholder="(مگابایت)">
                                        </div>

                                        <legend class="text-uppercase font-size-sm font-weight-bold" style="color: #FB8C00">هزینه راه اندازی
                                        </legend>
                                        <label class="col-form-label col-lg-2">هزینه رانژه</label>
                                        <div class="col-lg-4">
                                            <input type="number" class="form-control" name="hazine_ranzhe" id="adsl_hazine_ranzhe" placeholder="ریال">
                                        </div>

                                        <label class="col-form-label col-lg-2">هزینه نصب</label>
                                        <div class="col-lg-4">
                                            <input type="number" class="form-control" name="hazine_nasb" id="adsl_hazine_nasb" placeholder="ریال">
                                        </div>

                                        <label class="col-form-label col-lg-2">هزینه درانژه</label>
                                        <div class="col-lg-4">
                                            <input type="number" class="form-control" name="hazine_dranzhe" id="adsl_hazine_dranzhe" placeholder="ریال">
                                        </div>

                                        <legend class="text-uppercase font-size-sm font-weight-bold" style="color: #FB8C00">توضیحات
                                        </legend>
                                        <label class="col-form-label col-lg-2">توضیحات فاکتور</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="tozihate_faktor" id="adsl_tozihate_faktor" placeholder="توضیحات فاکتور">
                                        </div>

                                        <label class="col-form-label col-lg-2">توضیحات وب سایت</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="tozihate_website" id="adsl_tozihate_website" placeholder="توضیحات وب سایت">
                                        </div>

                                        <legend class="text-uppercase font-size-sm font-weight-bold" style="color: #FB8C00">سرعت اتصال
                                        </legend>
                                        <label class="col-form-label col-lg-2">سرعت پایه دریافت</label>
                                        <div class="col-lg-4">
                                            <input type="number" class="form-control" name="sorate_paye_daryaft" id="adsl_sorate_paye_daryaft" placeholder="مگابیت" step="0.1">
                                        </div>

                                        <label class="col-form-label col-lg-2">حداکثر سرعت دریافت</label>
                                        <div class="col-lg-4">
                                            <input type="number" class="form-control" name="hadeaxar_sorat_daryaft" id="adsl_hadeaxar_sorat_daryaft" placeholder="مگابیت" step="0.1">
                                        </div>

                                        <label class="col-form-label col-lg-2">سرعت پایه ارسال</label>
                                        <div class="col-lg-4">
                                            <input type="number" class="form-control" name="sorat_paye_ersal" id="adsl_sorat_paye_ersal" placeholder="مگابیت" step="0.1">
                                        </div>


                                        <legend class="text-uppercase font-size-sm font-weight-bold" style="color: #FB8C00">آبونمان
                                        </legend>
                                        <label class="col-form-label col-lg-2">پورت</label>
                                        <div class="col-lg-4">
                                            <input type="number" class="form-control" name="port" id="adsl_port" placeholder="">
                                        </div>

                                        <label class="col-form-label col-lg-2">تجهیزات</label>
                                        <div class="col-lg-4">
                                            <input type="number" class="form-control" name="tajhizat" id="adsl_tajhizat" placeholder="">
                                        </div>

                                        <label class="col-form-label col-lg-2">فضا</label>
                                        <div class="col-lg-4">
                                            <input type="number" class="form-control" name="faza" id="adsl_faza" placeholder="">
                                        </div>

                                        <legend class="text-uppercase col-sm-12 font-size-sm font-weight-bold" style="color: #FB8C00">نوع فروش
                                        </legend>
                                        <label class="col-form-label col-lg-2">نوع فروش سرویس</label>
                                        <div class="col-lg-4">
                                            <select class="form-control form-control-lg custom-select" required name="noe_forosh" id="adsl_noe_forosh">
                                                <option value="adi">عادی</option>
                                                <option value="bulk">بالک</option>
                                                <option value="jashnvare">جشنواره</option>
                                            </select>
                                        </div>
                                        <label class="col-form-label col-lg-2">شناسه سرویس</label>
                                        <div class="col-lg-4">
                                        <input type="text" class="form-control" name="shenase_service" id="adsl_shenase_service" placeholder="">
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="text-right">
                                    <button type="submit" name="send_services_adsl" class="btn btn-primary">ارسال <i class="icon-paperplane ml-2"></i></button>
                                </div>
                            </form>
                            <div class="card" style="margin-top: 10px">
                                <div class="col-md-12">
                                    <button name="delete_adsl" class="btn btn-warning col-md-auto float-md-right" id="delete_adsl">حذف<i class="icon-folder-remove ml-2"></i></button>
                                    <button name="edit_adsl" class="btn btn-primary col-md-auto float-md-right" id="edit_adsl">ویرایش<i class="icon-database-edit2 ml-2"></i></button>
                                    <table id="view_table_adsl" class="table table-striped datatable-responsive table-hover">
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!------------Wireless------------->
                        <div class="wireless_tab tab-pane fade" id="bottom-justified-divided-tab3">
                            <form action="#" method="POST">
                                <input type="hidden" id="wireless_id" name="id" value="empty" class="form-control">
                                <input type="hidden" id="wireless_type" name="type" value="wireless" class="form-control">
                                <fieldset class="mb-3">
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-2">نوع خدمات</label>
                                        <div class="col-lg-4">
                                            <select class="form-control form-control-lg custom-select" name="noe_khadamat" id="wireless_noe_khadamat">
                                                <option value="Wireless(Share)">Wireless(Share)</option>
                                                <option value="Wireless(Transport)">Wireless(Transport)</option>
                                                <option value="Wireless(Hotspot)">Wireless(Hotspot)</option>
                                            </select>
                                        </div>

                                        <label class="col-form-label col-lg-2">نمایش سرویس</label>
                                        <div class="col-lg-4">
                                            <select class="form-control form-control-lg custom-select" name="namayeshe_service" id="wireless_namayeshe_service">
                                                <option value="yes">بلی</option>
                                                <option value="no">خیر</option>
                                            </select>
                                        </div>

                                        <label class="col-form-label col-lg-2">نمایش در پروفایل</label>
                                        <div class="col-lg-4">
                                            <select class="form-control form-control-lg custom-select" name="namayeshe_dar_profile" id="wireless_namayeshe_dar_profile">
                                                <option value="yes">بلی</option>
                                                <option value="no">خیر</option>
                                            </select>
                                        </div>

                                        <label class="col-form-label col-lg-2">عنوان سرویس</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="onvane_service" placeholder="مثال: " id="wireless_onvane_service">
                                        </div>
                                        <label class="col-form-label col-lg-2">قيمت</label>
                                        <div class="col-lg-4">
                                            <input type="number" class="form-control" name="gheymat" placeholder="به ریال" id="wireless_gheymat" required>
                                        </div>

                                        <label class="col-form-label col-lg-2">زمان استفاده</label>
                                        <div class="col-lg-4">
                                            <input type="number" class="form-control" name="zaname_estefade" id="wireless_zaname_estefade" placeholder="زمان به روز مثال: 30">
                                        </div>

                                        <label class="col-form-label col-lg-2">تخفيف</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="takhfif" id="wireless_takhfif" placeholder="به درصد مثال : 6.5">
                                        </div>

                                        <label class="col-form-label col-lg-2">نام سرویس دهنده</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="name_service_dahande" id="wireless_name_service_dahande" placeholder="مثال: سحر ارتباط">
                                        </div>

                                        <label class="col-form-label col-lg-2">پورسانت</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="porsant" id="wireless_porsant" placeholder="مثال : 6.5">
                                        </div>

                                        <label class="col-form-label col-lg-2">تاریخ شروع نمایش</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="tarikhe_shoroe_namayesh" id="wireless_tarikhe_shoroe_namayesh" placeholder="مثال: 1380/05/20">
                                        </div>

                                        <label class="col-form-label col-lg-2">تاریخ پایان نمایش</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="tarikhe_payane_namayesh" id="wireless_tarikhe_payane_namayesh" placeholder="مثال: 1380/05/20">
                                        </div>

                                        <label class="col-form-label col-lg-2">امتیاز جایزه</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="emtiaze_jayeze" id="wireless_emtiaze_jayeze" placeholder="مثال : 6">
                                        </div>

                                        <label class="col-form-label col-lg-2">حداقل امتیاز</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="hadeaghale_emtiaz" id="wireless_hadeaghale_emtiaz" placeholder="مثال : 6">
                                        </div>

                                        <label class="col-form-label col-lg-2">حداکثر امتیاز</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="hadeaksare_emtiaz" id="wireless_hadeaksare_emtiaz" placeholder="مثال : 6">
                                        </div>

                                        <label class="col-form-label col-lg-2">مبلغ هر امتیاز</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="mablaghe_har_emtiaz" id="wireless_mablaghe_har_emtiaz" placeholder="مثال : 6">
                                        </div>

                                        <label class="col-form-label col-lg-2">نام گروه مشتری</label>
                                        <div class="col-lg-4">
                                            <select class="form-control form-control-lg custom-select" name="name_grohe_moshtari" id="wireless_name_grohe_moshtari">
                                                <option value="1">1</option>
                                            </select>
                                        </div>

                                        <label class="col-form-label col-lg-2">نام گروه</label>
                                        <div class="col-lg-4">
                                            <select class="form-control form-control-lg custom-select" id="wireless_name_groh" name="name_groh">
                                                <option value="1">1</option>
                                            </select>
                                        </div>


                                        <label class="col-form-label col-lg-2"></label>
                                        <div class="col-lg-4">
                                        </div>


                                        <label class="col-form-label col-lg-2">رنگ نمایش پروفایل</label>
                                        <div class="col-lg-4">
                                            <div class="card card-body border-top-success text-center">
                                                <div class="d-inline-block">
                                                    <input type="text" class="form-control colorpicker-palette-toggle" name="range_namayeshe_profile" id="wireless_range_namayeshe_profile" value="#27ADCA" data-fouc>
                                                </div>
                                            </div>
                                        </div>
                                        <label class="col-form-label col-lg-2">رنگ ویژه سازی پروفایل</label>
                                        <div class="col-lg-4">
                                            <div class="card card-body border-top-success text-center">
                                                <div class="d-inline-block">
                                                    <input type="text" class="form-control colorpicker-palette-toggle" name="range_vizhesazie_profile" id="wireless_range_vizhesazie_profile" value="#27ADCA" data-fouc>
                                                </div>
                                            </div>
                                        </div>
                                        <legend class="text-uppercase font-size-sm font-weight-bold" style="color: #FB8C00">وصل موقت
                                        </legend>
                                        <label class="col-form-label col-lg-2">ساعت وصل موقت</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="saat_vasle_movaghat" id="wireless_saat_vasle_movaghat" placeholder="مثال : 2">
                                        </div>

                                        <label class="col-form-label col-lg-2">روز وصل موقت</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="roze_vasle_movaghat" id="wireless_roze_vasle_movaghat" placeholder="مثال : 5">
                                        </div>

                                        <label class="col-form-label col-lg-2">ترافیک وصل موقت</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="terafike_vasle_movaghat" id="wireless_terafike_vasle_movaghat" placeholder="(مگابایت) مثال: 1024">
                                        </div>

                                        <legend class="text-uppercase font-size-sm font-weight-bold" style="color: #FB8C00">ترافیک
                                        </legend>
                                        <label class="col-form-label col-lg-2">ترافیک</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="terafik" id="wireless_terafik" placeholder="(مگابایت)">
                                        </div>

                                        <legend class="text-uppercase font-size-sm font-weight-bold" style="color: #FB8C00">هزینه راه اندازی
                                        </legend>

                                        <label class="col-form-label col-lg-2">هزینه نصب</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="hazine_nasb" id="wireless_hazine_nasb" placeholder="ریال">
                                        </div>

                                        <legend class="text-uppercase font-size-sm font-weight-bold" style="color: #FB8C00">توضیحات
                                        </legend>
                                        <label class="col-form-label col-lg-2">توضیحات فاکتور</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="tozihate_faktor" id="wireless_tozihate_faktor" placeholder="توضیحات فاکتور">
                                        </div>

                                        <label class="col-form-label col-lg-2">توضیحات وب سایت</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="tozihate_website" id="wireless_tozihate_website" placeholder="توضیحات وب سایت">
                                        </div>

                                        <legend class="text-uppercase font-size-sm font-weight-bold" style="color: #FB8C00">سرعت اتصال
                                        </legend>
                                        <label class="col-form-label col-lg-2">سرعت پایه دریافت</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="sorate_paye_daryaft" id="wireless_sorate_paye_daryaft" placeholder="مگابیت" step="0.1">
                                        </div>

                                        <label class="col-form-label col-lg-2">حداکثر سرعت دریافت</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="hadeaxar_sorat_daryaft" id="wireless_hadeaxar_sorat_daryaft" placeholder="مگابیت" step="0.1">
                                        </div>

                                        <label class="col-form-label col-lg-2">سرعت پایه ارسال</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="sorat_paye_ersal" id="wireless_sorat_paye_ersal" placeholder="مگابیت" step="0.1">
                                        </div>


                                        <legend class="text-uppercase font-size-sm font-weight-bold" style="color: #FB8C00">آبونمان
                                        </legend>
                                        <label class="col-form-label col-lg-2">پورت</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="port" id="wireless_port" placeholder="">
                                        </div>

                                        <label class="col-form-label col-lg-2">تجهیزات</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="tajhizat" id="wireless_tajhizat" placeholder="">
                                        </div>

                                        <label class="col-form-label col-lg-2">فضا</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="faza" id="wireless_faza" placeholder="">
                                        </div>

                                        <legend class="text-uppercase col-sm-12 font-size-sm font-weight-bold" style="color: #FB8C00">نوع فروش
                                        </legend>
                                        <label class="col-form-label col-lg-2">نوع فروش سرویس</label>
                                        <div class="col-lg-4">
                                            <select class="form-control form-control-lg custom-select" required name="noe_forosh" id="wireless_noe_forosh">
                                                <option value="adi">عادی</option>
                                                <option value="bulk">بالک</option>
                                                <option value="jashnvare">جشنواره</option>
                                            </select>
                                        </div>
                                        <label class="col-form-label col-lg-2">شناسه سرویس</label>
                                        <div class="col-lg-4">
                                        <input type="text" class="form-control" name="shenase_service" id="wireless_shenase_service" placeholder="">
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="text-right">
                                    <button type="submit" name="send_services_wireless" class="btn btn-primary">ارسال <i class="icon-paperplane ml-2"></i></button>
                                </div>
                            </form>
                            <div class="card" style="margin-top: 10px">
                                <div class="col-md-12">
                                    <button name="delete_wireless" class="btn btn-warning col-md-auto float-md-right" id="delete_wireless">حذف<i class="icon-folder-remove ml-2"></i></button>
                                    <button name="edit_wireless" class="btn btn-primary col-md-auto float-md-right" id="edit_wireless">ویرایش<i class="icon-database-edit2 ml-2"></i></button>
                                    <table id="view_table_wireless" class="table table-striped datatable-responsive table-hover">
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!------------TD-LTE/4G------------->
                        <div class="tdlte_tab tab-pane fade" id="bottom-justified-divided-tab4">
                            <form action="#" method="POST">
                                <input type="hidden" id="tdlte_id" name="id" value="empty" class="form-control">
                                <input type="hidden" id="tdlte_type" name="type" value="tdlte" class="form-control">
                                <fieldset class="mb-3">
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-2">نوع خدمات</label>
                                        <div class="col-lg-4">
                                            <select class="form-control form-control-lg custom-select" name="noe_khadamat" id="tdlte_noe_khadamat">
                                                <<option value="TD-LTE(Share)">TD-LTE(Share)</option>
                                                    <option value="TD-LTE(Transport)">TD-LTE(Transport)</option>
                                            </select>
                                        </div>

                                        <label class="col-form-label col-lg-2">نمایش سرویس</label>
                                        <div class="col-lg-4">
                                            <select class="form-control form-control-lg custom-select" name="namayeshe_service" id="tdlte_namayeshe_service">
                                                <option value="yes">بلی</option>
                                                <option value="no">خیر</option>
                                            </select>
                                        </div>

                                        <label class="col-form-label col-lg-2">نمایش در پروفایل</label>
                                        <div class="col-lg-4">
                                            <select class="form-control form-control-lg custom-select" name="namayeshe_dar_profile" id="tdlte_namayeshe_dar_profile">
                                                <option value="yes">بلی</option>
                                                <option value="no">خیر</option>
                                            </select>
                                        </div>

                                        <label class="col-form-label col-lg-2">عنوان سرویس</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="onvane_service" placeholder="مثال: " id="tdlte_onvane_service">
                                        </div>
                                        <label class="col-form-label col-lg-2">قيمت</label>
                                        <div class="col-lg-4">
                                            <input type="number" class="form-control" name="gheymat" placeholder="به ریال" id="tdlte_gheymat" required>
                                        </div>

                                        <label class="col-form-label col-lg-2">زمان استفاده</label>
                                        <div class="col-lg-4">
                                            <input type="number" class="form-control" name="zaname_estefade" id="tdlte_zaname_estefade" placeholder="زمان به روز مثال: 30">
                                        </div>

                                        <label class="col-form-label col-lg-2">تخفيف</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="takhfif" id="tdlte_takhfif" placeholder="به درصد مثال : 6.5">
                                        </div>

                                        <label class="col-form-label col-lg-2">نام سرویس دهنده</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="name_service_dahande" id="tdlte_name_service_dahande" placeholder="مثال: سحر ارتباط">
                                        </div>

                                        <label class="col-form-label col-lg-2">پورسانت</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="porsant" id="tdlte_porsant" placeholder="مثال : 6.5">
                                        </div>

                                        <label class="col-form-label col-lg-2">تاریخ شروع نمایش</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="tarikhe_shoroe_namayesh" id="tdlte_tarikhe_shoroe_namayesh" placeholder="مثال: 1380/05/20">
                                        </div>

                                        <label class="col-form-label col-lg-2">تاریخ پایان نمایش</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="tarikhe_payane_namayesh" id="tdlte_tarikhe_payane_namayesh" placeholder="مثال: 1380/05/20">
                                        </div>

                                        <label class="col-form-label col-lg-2">امتیاز جایزه</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="emtiaze_jayeze" id="tdlte_emtiaze_jayeze" placeholder="مثال : 6">
                                        </div>

                                        <label class="col-form-label col-lg-2">حداقل امتیاز</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="hadeaghale_emtiaz" id="tdlte_hadeaghale_emtiaz" placeholder="مثال : 6">
                                        </div>

                                        <label class="col-form-label col-lg-2">حداکثر امتیاز</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="hadeaksare_emtiaz" id="tdlte_hadeaksare_emtiaz" placeholder="مثال : 6">
                                        </div>

                                        <label class="col-form-label col-lg-2">مبلغ هر امتیاز</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="mablaghe_har_emtiaz" id="tdlte_mablaghe_har_emtiaz" placeholder="مثال : 6">
                                        </div>

                                        <label class="col-form-label col-lg-2">نام گروه مشتری</label>
                                        <div class="col-lg-4">
                                            <select class="form-control form-control-lg custom-select" name="name_grohe_moshtari" id="tdlte_name_grohe_moshtari">
                                                <option value="1">1</option>
                                            </select>
                                        </div>

                                        <label class="col-form-label col-lg-2">نام گروه</label>
                                        <div class="col-lg-4">
                                            <select class="form-control form-control-lg custom-select" id="tdlte_name_groh" name="name_groh">
                                                <option value="1">1</option>
                                            </select>
                                        </div>


                                        <label class="col-form-label col-lg-2"></label>
                                        <div class="col-lg-4">
                                        </div>


                                        <label class="col-form-label col-lg-2">رنگ نمایش پروفایل</label>
                                        <div class="col-lg-4">
                                            <div class="card card-body border-top-success text-center">
                                                <div class="d-inline-block">
                                                    <input type="text" class="form-control colorpicker-palette-toggle" name="range_namayeshe_profile" id="tdlte_range_namayeshe_profile" value="#27ADCA" data-fouc>
                                                </div>
                                            </div>
                                        </div>
                                        <label class="col-form-label col-lg-2">رنگ ویژه سازی پروفایل</label>
                                        <div class="col-lg-4">
                                            <div class="card card-body border-top-success text-center">
                                                <div class="d-inline-block">
                                                    <input type="text" class="form-control colorpicker-palette-toggle" name="range_vizhesazie_profile" id="tdlte_range_vizhesazie_profile" value="#27ADCA" data-fouc>
                                                </div>
                                            </div>
                                        </div>
                                        <legend class="text-uppercase font-size-sm font-weight-bold" style="color: #FB8C00">وصل موقت
                                        </legend>
                                        <label class="col-form-label col-lg-2">ساعت وصل موقت</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="saat_vasle_movaghat" id="tdlte_saat_vasle_movaghat" placeholder="مثال : 2">
                                        </div>

                                        <label class="col-form-label col-lg-2">روز وصل موقت</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="roze_vasle_movaghat" id="tdlte_roze_vasle_movaghat" placeholder="مثال : 5">
                                        </div>

                                        <label class="col-form-label col-lg-2">ترافیک وصل موقت</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="terafike_vasle_movaghat" id="tdlte_terafike_vasle_movaghat" placeholder="(مگابایت) مثال: 1024">
                                        </div>

                                        <legend class="text-uppercase font-size-sm font-weight-bold" style="color: #FB8C00">ترافیک
                                        </legend>
                                        <label class="col-form-label col-lg-2">ترافیک</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="terafik" id="tdlte_terafik" placeholder="(مگابایت)">
                                        </div>

                                        <legend class="text-uppercase font-size-sm font-weight-bold" style="color: #FB8C00">هزینه راه اندازی
                                        </legend>

                                        <label class="col-form-label col-lg-2">هزینه نصب</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="hazine_nasb" id="tdlte_hazine_nasb" placeholder="ریال">
                                        </div>

                                        <legend class="text-uppercase font-size-sm font-weight-bold" style="color: #FB8C00">توضیحات
                                        </legend>
                                        <label class="col-form-label col-lg-2">توضیحات فاکتور</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="tozihate_faktor" id="tdlte_tozihate_faktor" placeholder="توضیحات فاکتور">
                                        </div>

                                        <label class="col-form-label col-lg-2">توضیحات وب سایت</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="tozihate_website" id="tdlte_tozihate_website" placeholder="توضیحات وب سایت">
                                        </div>

                                        <legend class="text-uppercase font-size-sm font-weight-bold" style="color: #FB8C00">سرعت اتصال
                                        </legend>
                                        <label class="col-form-label col-lg-2">سرعت پایه دریافت</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="sorate_paye_daryaft" id="tdlte_sorate_paye_daryaft" placeholder="مگابیت" step="0.1">
                                        </div>

                                        <label class="col-form-label col-lg-2">حداکثر سرعت دریافت</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="hadeaxar_sorat_daryaft" id="tdlte_hadeaxar_sorat_daryaft" placeholder="مگابیت" step="0.1">
                                        </div>

                                        <label class="col-form-label col-lg-2">سرعت پایه ارسال</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="sorat_paye_ersal" id="tdlte_sorat_paye_ersal" placeholder="مگابیت" step="0.1">
                                        </div>


                                        <legend class="text-uppercase font-size-sm font-weight-bold" style="color: #FB8C00">آبونمان
                                        </legend>
                                        <label class="col-form-label col-lg-2">پورت</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="port" id="tdlte_port" placeholder="">
                                        </div>

                                        <label class="col-form-label col-lg-2">تجهیزات</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="tajhizat" id="tdlte_tajhizat" placeholder="">
                                        </div>

                                        <label class="col-form-label col-lg-2">فضا</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="faza" id="tdlte_faza" placeholder="">
                                        </div>

                                        <legend class="text-uppercase col-sm-12 font-size-sm font-weight-bold" style="color: #FB8C00">نوع فروش
                                        </legend>
                                        <label class="col-form-label col-lg-2">نوع فروش سرویس</label>
                                        <div class="col-lg-4">
                                            <select class="form-control form-control-lg custom-select" required name="noe_forosh" id="tdlte_noe_forosh">
                                                <option value="adi">عادی</option>
                                                <option value="bulk">بالک</option>
                                                <option value="jashnvare">جشنواره</option>
                                            </select>
                                        </div>
                                        <label class="col-form-label col-lg-2">شناسه سرویس</label>
                                        <div class="col-lg-4">
                                        <input type="text" class="form-control" name="shenase_service" id="tdlte_shenase_service" placeholder="">
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="text-right">
                                    <button type="submit" name="send_services_tdlte" class="btn btn-primary">ارسال <i class="icon-paperplane ml-2"></i></button>
                                </div>
                            </form>
                            <div class="card" style="margin-top: 10px">
                                <div class="col-md-12">
                                    <button name="delete_tdlte" class="btn btn-warning col-md-auto float-md-right" id="delete_tdlte">حذف<i class="icon-folder-remove ml-2"></i></button>
                                    <button name="edit_tdlte" class="btn btn-primary col-md-auto float-md-right" id="edit_tdlte">ویرایش<i class="icon-database-edit2 ml-2"></i></button>
                                    <table id="view_table_tdlte" class="table table-striped datatable-responsive table-hover">
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!------------Voip------------->
                        <div class="voip_tab tab-pane fade" id="bottom-justified-divided-tab5">
                            <form action="#" method="POST">
                                <input type="hidden" id="voip_id" name="id" value="empty" class="form-control">
                                <input type="hidden" id="voip_type" name="type" value="voip" class="form-control">
                                <fieldset class="mb-3">
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-2">نوع پرداخت</label>
                                        <div class="col-lg-4">
                                            <select class="form-control form-control-lg custom-select" name="noe_khadamat" id="voip_noe_khadamat">
                                                <option value="carti">کارتی</option>
                                                <option value="etebari">اعتباری</option>
                                            </select>
                                        </div>

                                        <label class="col-form-label col-lg-2">نمایش سرویس</label>
                                        <div class="col-lg-4">
                                            <select class="form-control form-control-lg custom-select" name="namayeshe_service" id="voip_namayeshe_service">
                                                <option value="yes">بلی</option>
                                                <option value="no">خیر</option>
                                            </select>
                                        </div>

                                        <label class="col-form-label col-lg-2">نمایش در پروفایل</label>
                                        <div class="col-lg-4">
                                            <select class="form-control form-control-lg custom-select" name="namayeshe_dar_profile" id="voip_namayeshe_dar_profile">
                                                <option value="yes">بلی</option>
                                                <option value="no">خیر</option>
                                            </select>
                                        </div>

                                        <label class="col-form-label col-lg-2">عنوان سرویس</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="onvane_service" placeholder="مثال: " id="voip_onvane_service">
                                        </div>
                                        <label class="col-form-label col-lg-2">قيمت</label>
                                        <div class="col-lg-4">
                                            <input type="number" class="form-control" name="gheymat" placeholder="به ریال" id="voip_gheymat" required>
                                        </div>

                                        <label class="col-form-label col-lg-2">زمان استفاده</label>
                                        <div class="col-lg-4">
                                            <input type="number" class="form-control" name="zaname_estefade" id="voip_zaname_estefade" placeholder="زمان به روز مثال: 30">
                                        </div>

                                        <label class="col-form-label col-lg-2">تخفيف</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="takhfif" id="voip_takhfif" placeholder="به درصد مثال : 6.5">
                                        </div>

                                        <label class="col-form-label col-lg-2">نام سرویس دهنده</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="name_service_dahande" id="voip_name_service_dahande" placeholder="مثال: سحر ارتباط">
                                        </div>

                                        <label class="col-form-label col-lg-2">پورسانت</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="porsant" id="voip_porsant" placeholder="مثال : 6.5">
                                        </div>

                                        <label class="col-form-label col-lg-2">تاریخ شروع نمایش</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="tarikhe_shoroe_namayesh" id="voip_tarikhe_shoroe_namayesh" placeholder="مثال: 1380/05/20">
                                        </div>

                                        <label class="col-form-label col-lg-2">تاریخ پایان نمایش</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="tarikhe_payane_namayesh" id="voip_tarikhe_payane_namayesh" placeholder="مثال: 1380/05/20">
                                        </div>

                                        <label class="col-form-label col-lg-2">امتیاز جایزه</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="emtiaze_jayeze" id="voip_emtiaze_jayeze" placeholder="مثال : 6">
                                        </div>

                                        <label class="col-form-label col-lg-2">حداقل امتیاز</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="hadeaghale_emtiaz" id="voip_hadeaghale_emtiaz" placeholder="مثال : 6">
                                        </div>

                                        <label class="col-form-label col-lg-2">حداکثر امتیاز</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="hadeaksare_emtiaz" id="voip_hadeaksare_emtiaz" placeholder="مثال : 6">
                                        </div>

                                        <label class="col-form-label col-lg-2">مبلغ هر امتیاز</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="mablaghe_har_emtiaz" id="voip_mablaghe_har_emtiaz" placeholder="مثال : 6">
                                        </div>

                                        <label class="col-form-label col-lg-2">نام گروه مشتری</label>
                                        <div class="col-lg-4">
                                            <select class="form-control form-control-lg custom-select" name="name_grohe_moshtari" id="voip_name_grohe_moshtari">
                                                <option value="1">1</option>
                                            </select>
                                        </div>

                                        <label class="col-form-label col-lg-2">نام گروه</label>
                                        <div class="col-lg-4">
                                            <select class="form-control form-control-lg custom-select" id="voip_name_groh" name="name_groh">
                                                <option value="1">1</option>
                                            </select>
                                        </div>


                                        <label class="col-form-label col-lg-2"></label>
                                        <div class="col-lg-4">
                                        </div>


                                        <label class="col-form-label col-lg-2">رنگ نمایش پروفایل</label>
                                        <div class="col-lg-4">
                                            <div class="card card-body border-top-success text-center">
                                                <div class="d-inline-block">
                                                    <input type="text" class="form-control colorpicker-palette-toggle" name="range_namayeshe_profile" id="voip_range_namayeshe_profile" value="#27ADCA" data-fouc>
                                                </div>
                                            </div>
                                        </div>
                                        <label class="col-form-label col-lg-2">رنگ ویژه سازی پروفایل</label>
                                        <div class="col-lg-4">
                                            <div class="card card-body border-top-success text-center">
                                                <div class="d-inline-block">
                                                    <input type="text" class="form-control colorpicker-palette-toggle" name="range_vizhesazie_profile" id="voip_range_vizhesazie_profile" value="#27ADCA" data-fouc>
                                                </div>
                                            </div>
                                        </div>

                                        <legend class="text-uppercase font-size-sm font-weight-bold" style="color: #FB8C00">توضیحات
                                        </legend>
                                        <label class="col-form-label col-lg-2">توضیحات فاکتور</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="tozihate_faktor" id="voip_tozihate_faktor" placeholder="توضیحات فاکتور">
                                        </div>

                                        <label class="col-form-label col-lg-2">توضیحات وب سایت</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="tozihate_website" id="voip_tozihate_website" placeholder="توضیحات وب سایت">
                                        </div>

                                        <legend class="text-uppercase col-sm-12 font-size-sm font-weight-bold" style="color: #FB8C00">نوع فروش
                                        </legend>
                                        <label class="col-form-label col-lg-2">نوع فروش سرویس</label>
                                        <div class="col-lg-4">
                                            <select class="form-control form-control-lg custom-select" required name="noe_forosh" id="voip_noe_forosh">
                                                <option value="adi">عادی</option>
                                                <option value="jashnvare">جشنواره</option>
                                            </select>
                                        </div>
                                        <label class="col-form-label col-lg-2">شناسه سرویس</label>
                                        <div class="col-lg-4">
                                        <input type="text" class="form-control" name="shenase_service" id="voip_shenase_service" placeholder="">
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="text-right">
                                    <button type="submit" name="send_services_voip" class="btn btn-primary">ارسال <i class="icon-paperplane ml-2"></i></button>
                                </div>
                            </form>
                            <div class="card" style="margin-top: 10px">
                                <div class="col-md-12">
                                    <button name="delete_voip" class="btn btn-warning col-md-auto float-md-right" id="delete_voip">حذف<i class="icon-folder-remove ml-2"></i></button>
                                    <button name="edit_voip" class="btn btn-primary col-md-auto float-md-right" id="edit_voip">ویرایش<i class="icon-database-edit2 ml-2"></i></button>
                                    <table id="view_table_voip" class="table table-striped datatable-responsive table-hover">
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!------------IP------------->
                        <div class="ip_tab tab-pane fade" id="bottom-justified-divided-tab6">
                            <form action="#" method="POST">
                                <input type="hidden" id="ip_id" name="id" value="empty" class="form-control">
                                <input type="hidden" id="ip_type" name="type" value="ip" class="form-control">
                                <fieldset class="mb-3">
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-2">نوع خدمات</label>
                                        <div class="col-lg-4">
                                            <select class="form-control form-control-lg custom-select" name="noe_khadamat" id="ip_noe_khadamat">
                                                <option value="1">Valid</option>
                                                <option value="0">Invalid</option>
                                            </select>
                                        </div>

                                        <label class="col-form-label col-lg-2">نمایش سرویس</label>
                                        <div class="col-lg-4">
                                            <select class="form-control form-control-lg custom-select" name="namayeshe_service" id="ip_namayeshe_service">
                                                <option value="yes">بلی</option>
                                                <option value="no">خیر</option>
                                            </select>
                                        </div>

                                        <label class="col-form-label col-lg-2">نمایش در پروفایل</label>
                                        <div class="col-lg-4">
                                            <select class="form-control form-control-lg custom-select" name="namayeshe_dar_profile" id="ip_namayeshe_dar_profile">
                                                <option value="yes">بلی</option>
                                                <option value="no">خیر</option>
                                            </select>
                                        </div>

                                        <label class="col-form-label col-lg-2">تعداد</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="tedad" placeholder="مثال: 64" id="ip_tedad">
                                        </div>
                                        <label class="col-form-label col-lg-2">عنوان سرویس</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="onvane_service" placeholder="مثال: " id="ip_onvane_service">
                                        </div>
                                        <label class="col-form-label col-lg-2">قيمت</label>
                                        <div class="col-lg-4">
                                            <input type="number" class="form-control" name="gheymat" placeholder="به ریال" id="ip_gheymat" required>
                                        </div>

                                        <label class="col-form-label col-lg-2">زمان استفاده</label>
                                        <div class="col-lg-4">
                                            <input type="number" class="form-control" name="zaname_estefade" id="ip_zaname_estefade" placeholder="زمان به روز مثال: 30">
                                        </div>

                                        <label class="col-form-label col-lg-2">تخفيف</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="takhfif" id="ip_takhfif" placeholder="به درصد مثال : 6.5">
                                        </div>

                                        <label class="col-form-label col-lg-2">نام سرویس دهنده</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="name_service_dahande" id="ip_name_service_dahande" placeholder="مثال: سحر ارتباط">
                                        </div>

                                        <label class="col-form-label col-lg-2">پورسانت</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="porsant" id="ip_porsant" placeholder="مثال : 6.5">
                                        </div>

                                        <label class="col-form-label col-lg-2">تاریخ شروع نمایش</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="tarikhe_shoroe_namayesh" id="ip_tarikhe_shoroe_namayesh" placeholder="مثال: 1380/05/20">
                                        </div>

                                        <label class="col-form-label col-lg-2">تاریخ پایان نمایش</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="tarikhe_payane_namayesh" id="ip_tarikhe_payane_namayesh" placeholder="مثال: 1380/05/20">
                                        </div>

                                        <label class="col-form-label col-lg-2">امتیاز جایزه</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="emtiaze_jayeze" id="ip_emtiaze_jayeze" placeholder="مثال : 6">
                                        </div>

                                        <label class="col-form-label col-lg-2">حداقل امتیاز</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="hadeaghale_emtiaz" id="ip_hadeaghale_emtiaz" placeholder="مثال : 6">
                                        </div>

                                        <label class="col-form-label col-lg-2">حداکثر امتیاز</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="hadeaksare_emtiaz" id="ip_hadeaksare_emtiaz" placeholder="مثال : 6">
                                        </div>

                                        <label class="col-form-label col-lg-2">مبلغ هر امتیاز</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="mablaghe_har_emtiaz" id="ip_mablaghe_har_emtiaz" placeholder="مثال : 6">
                                        </div>

                                        <label class="col-form-label col-lg-2">نام گروه مشتری</label>
                                        <div class="col-lg-4">
                                            <select class="form-control form-control-lg custom-select" name="name_grohe_moshtari" id="ip_name_grohe_moshtari">
                                                <option value="1">1</option>
                                            </select>
                                        </div>

                                        <label class="col-form-label col-lg-2">نام گروه</label>
                                        <div class="col-lg-4">
                                            <select class="form-control form-control-lg custom-select" id="ip_name_groh" name="name_groh">
                                                <option value="1">1</option>
                                            </select>
                                        </div>



                                        <label class="col-form-label col-lg-2">رنگ نمایش پروفایل</label>
                                        <div class="col-lg-4">
                                            <div class="card card-body border-top-success text-center">
                                                <div class="d-inline-block">
                                                    <input type="text" class="form-control colorpicker-palette-toggle" name="range_namayeshe_profile" id="ip_range_namayeshe_profile" value="#27ADCA" data-fouc>
                                                </div>
                                            </div>
                                        </div>
                                        <label class="col-form-label col-lg-2">رنگ ویژه سازی پروفایل</label>
                                        <div class="col-lg-4">
                                            <div class="card card-body border-top-success text-center">
                                                <div class="d-inline-block">
                                                    <input type="text" class="form-control colorpicker-palette-toggle" name="range_vizhesazie_profile" id="ip_range_vizhesazie_profile" value="#27ADCA" data-fouc>
                                                </div>
                                            </div>
                                        </div>

                                        <legend class="text-uppercase font-size-sm font-weight-bold" style="color: #FB8C00">توضیحات
                                        </legend>
                                        <label class="col-form-label col-lg-2">توضیحات فاکتور</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="tozihate_faktor" id="ip_tozihate_faktor" placeholder="توضیحات فاکتور">
                                        </div>

                                        <label class="col-form-label col-lg-2">توضیحات وب سایت</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="tozihate_website" id="ip_tozihate_website" placeholder="توضیحات وب سایت">
                                        </div>

                                        
                                    </div>
                                </fieldset>
                                <div class="text-right">
                                    <button type="submit" name="send_services_ip" class="btn btn-primary">ارسال <i class="icon-paperplane ml-2"></i></button>
                                </div>
                            </form>
                            <div class="card" style="margin-top: 10px">
                                <div class="col-md-12">
                                    <button name="delete_ip" class="btn btn-warning col-md-auto float-md-right" id="delete_ip">حذف<i class="icon-folder-remove ml-2"></i></button>
                                    <button name="edit_ip" class="btn btn-primary col-md-auto float-md-right" id="edit_ip">ویرایش<i class="icon-database-edit2 ml-2"></i></button>
                                    <table id="view_table_ip" class="table table-striped datatable-responsive table-hover">
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /form inputs -->

        </div>
        <!-- /content area -->