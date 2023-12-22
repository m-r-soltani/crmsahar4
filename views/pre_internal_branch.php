        <!-- Content area -->
        <div class="content">
            <!-- Form inputs -->
            <div class="card">
                <div class="card-body">
                    <form action="#" method="POST" enctype="multipart/form-data">
                        <fieldset class="mb-3">
                            <legend class="text-uppercase font-size-sm font-weight-bold">نماینده</legend>
                            
                            <div class="form-group row">
                                <legend class="text-uppercase font-size-md font-weight-bold" style="color: #FB8C00">اطلاعات هویتی نمایندگی ( ستاره دار اجباری )</legend>
                                <label class="col-form-label col-lg-2">نماینده بالادستی <span class="text-danger">*</span></label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom-select" name="baladasti_id" id="baladasti_id" required>
                                    <option disabled selected> -- یک مورد را انتخاب کنید -- </option>
                                    </select>
                                </div>
                                <label class="col-form-label col-lg-2">نوع نمایندگی <span class="text-danger">*</span></label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom-select" name="noe_namayandegi" id="noe_namayandegi" required>
                                        <option disabled selected> -- یک مورد را انتخاب کنید -- </option>
                                        <option value="1">حقیقی</option>
                                        <option value="0">حقوقی</option>
                                        
                                    </select>
                                </div>
                                <label class="col-form-label col-lg-2">نام شرکت/موسسه <span class="text-danger">*</span></label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="name_sherkat" id="name_sherkat" placeholder="مثال: سحر ارتباط" required>
                                    <input type="hidden" id="id" class="form-control" name="id" value="empty">
                                </div>
                                
                                <label class="col-form-label col-lg-2">شماره ثبت/پروانه</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="shomare_sabt" id="shomare_sabt" placeholder="">
                                </div>
                                <label class="col-form-label col-lg-2"><span class="text-danger">*</span>تاریخ ثبت</label>
                                <div class="col-lg-4">
                                    <input type="text"
                                           name="tarikhe_sabt"
                                           id="tarikhe_sabt"
                                           class="form-control"
                                           mask="____/__/__"
                                           minlength='11'
                                           autocomplete='off'
                                           placeholder=""
                                           readonly
                                           required>
                                </div>
                                <label class="col-form-label col-lg-2">شناسه ملی شرکت</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="shenase_meli" id="shenase_meli" placeholder="مثال: 0011111111">
                                </div>
                                
                                <label class="col-form-label col-lg-2">کد اقتصادی</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="code_eghtesadi" id="code_eghtesadi" placeholder="">
                                </div>
                                
                                <label class="col-form-label col-lg-2">نوع شرکت/موسسه</label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom-select" name="noe_sherkat" id="noe_sherkat">
                                        <option disabled selected> -- یک مورد را انتخاب کنید -- </option>
                                    </select>
                                </div>
                                
                                <label class="col-form-label col-lg-2">وب سایت</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="website" id="website" placeholder="www.abc.com">
                                </div>
                                
                                <label class="col-form-label col-lg-2">پست الکترونیک</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="email" id="email" placeholder="abc@gmail.com">
                                </div>
                                
                                <label class="col-form-label col-lg-2">تلفن اول <span class="text-danger">*</span></label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="telephone1" id="telephone1" placeholder="به همراه پیش شماره بدون خط فاصله یا کاراکتر های دیگر" required>
                                </div>
                                
                                <label class="col-form-label col-lg-2">تلفن دوم</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="telephone2" id="telephone2" placeholder="به همراه پیش شماره بدون خط فاصله یا کاراکتر های دیگر">
                                </div>
                                
                                <label class="col-form-label col-lg-2">دورنگار</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="dornegar" id="dornegar" placeholder="به همراه پیش شماره بدون خط فاصله یا کاراکتر های دیگر">
                                </div>
                                
                                <label class="col-form-label col-lg-2">استان <span class="text-danger">*</span></label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom_select" name="ostan" id="ostan" required>
                                    <option disabled selected> -- یک مورد را انتخاب کنید -- </option>
                                    </select>
                                </div>
                                
                                <label class="col-form-label col-lg-2">شهر <span class="text-danger">*</span></label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom_select" name="shahr" id="shahr" required>
                                    <option disabled selected> -- یک مورد را انتخاب کنید -- </option>
                                    </select>
                                </div>
                                <div class="col-lg-12">
                                </div>
                                <label class="col-form-label col-lg-2">کد پستی</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="code_posti" id="code_posti" placeholder="فقط عدد وارد نمایید" required>
                                </div>
                                
                                <label class="col-form-label col-lg-2">آدرس</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="address" id="address" placeholder="مثال: تهران خیابان شریعتی کوچه ..." required>
                                </div>
                                <legend class="text-uppercase font-size-md font-weight-bold" style="color: #FB8C00">تصاویر نمایندگی (اختیاری)</legend>
                                <label class="col-form-label col-lg-2">لوگو شرکت/موسسه</label>
                                    <div class="col-lg-4" id="link_t_logo">
                                        <input type="file" name="t_logo" id="t_logo" class="form-control-uniform">
                                    </div>
                                
                                <label class="col-form-label col-lg-2">تصاویر محیطی شرکت</label>
                                <div class="col-lg-4" id="link_t_mohiti">
                                    <input type="file" name="t_mohiti" id="t_mohiti" class="form-control-uniform">
                                </div>
                                
                                <label class="col-form-label col-lg-2">تصاوریر تابلو</label>
                                <div class="col-lg-4" id="link_t_tablo">
                                    <input type="file" name="t_tablo" id="t_tablo" class="form-control-uniform">
                                </div>
                                
                                <label class="col-form-label col-lg-2">تصویر کد اقتصادی</label>
                                <div class="col-lg-4" id="link_t_code_eghtesadi">
                                    <input type="file" name="t_code_eghtesadi" id="t_code_eghtesadi" class="form-control-uniform">
                                </div>
                                
                                <label class="col-form-label col-lg-2">تصویر روزنامه تاسیس</label>
                                <div class="col-lg-4" id="link_t_rozname_tasis">
                                    <input type="file" name="t_rozname_tasis" id="t_rozname_tasis" class="form-control-uniform">
                                </div>
                                
                                <label class="col-form-label col-lg-2">تصویر شناسه ملی</label>
                                <div class="col-lg-4" id="link_t_shenase_meli">
                                    <input type="file" name="t_shenase_meli" id="t_shenase_meli" class="form-control-uniform">
                                </div>
                                
                                <label class="col-form-label col-lg-2">تصویر آخرین تغیرات</label>
                                <div class="col-lg-4" id="link_t_akharin_taghirat">
                                    <input type="file" name="t_akharin_taghirat" id="t_akharin_taghirat" class="form-control-uniform">
                                </div>
                                <legend class="text-uppercase font-size-md font-weight-bold" style="color: #FB8C00">نوع درخواست نمایندگی</legend>
                                <label class="col-form-label col-lg-2">نوع درخواست <span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <select class="form-control form-control-lg custom-select" id="noedarkhast" name="noedarkhast" required>
                                        <option value="1">ADSL</option>
                                        <option value="2">VDSL</option>
                                        <option value="3">TD LTE (4.5G )</option>
                                        <option value="4">Wireless OWA ( وایرلس  اشتراکی )</option>
                                        <option value="5">VoIP origination ( تلفن بین الملل )</option>
                                        <option value="6">NGN  ( تلفن ثابت مبتنی بر IP )</option>
                                        <option value="7">Bandwidth (پهنای باند اختصاصی )</option>
                                        <option value="8">Intranet ( تزانزیت بین استانی و شهری )</option>
                                        <option value="9">FTTH   ( اینترنت اشتراکی بر بستر فیبر نوری)</option>
                                        <option value="10">Internet Portal  ( سرویس پرتال ویژه مجتمع ها )</option>
                                        <option value="11">Domain , Hosting</option>
                                        <option value="12">CRM , LMS , ERP, CMS</option>
                                        <option value="13">سایر</option>
                                    </select>
                                </div>
                                <label class="col-form-label col-lg-2 ">توضیحات</label>
                                <div class="col-lg-10">
                                    <textarea class="form-control" id="tozihate_darkhast" name="tozihate_darkhast" style="height: 75px;"></textarea>
                                </div>
                            </div>
                        </fieldset>
                        <div class="text-right">
                            <button type="submit" name="send_pre_internal_branch" class="btn btn-primary">ارسال <i class="icon-paperplane ml-2"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /form inputs -->
            <div class="card">
                <div class="col-md-12">
                    <button name="delete" class="btn btn-warning col-md-auto float-md-right"  id="delete">حذف<i class="icon-folder-remove ml-2"></i></button>
                    <button name="edit" class="btn btn-primary col-md-auto float-md-right" id="edit">ویرایش<i class="icon-database-edit2 ml-2"></i></button>
                    <button name="confirmsub" class="btn btn-success col-md-auto float-md-left" id="confirmsub">تایید و انتقال به لیست نمایندگان<i class="icon-database ml-2"></i></button>
                    <table id="view_table" class="table table-striped datatable-responsive table-hover">
                    </table>
                </div>
            </div>
        </div>
        <!-- /content area -->
