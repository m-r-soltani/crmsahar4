
        <!-- Content area -->
        <div class="content">

            <!-- Form inputs -->
            <div class="card">
                <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="noe_moshtarak" name="noe_moshtarak" class="form-control"  value="legal">
                    <input type="hidden" id="id" class="form-control" name="id" value="empty">
                        <fieldset class="mb-3">
                            
                            <legend class="text-uppercase font-size-sm font-weight-bold">مشترکین حقوقی</legend>
                            
                            <div class="form-group row">
                                <legend class="text-uppercase font-size-md font-weight-bold" style="color: #FB8C00">اطلاعات هویتی شرکت ( اجباری )</legend>
                                <label class="col-form-label col-md-2" for="branch_id"><span class="text-danger">*</span>نماینده</label>
                                <div class="col-lg-10">
                                    <select class="form-control form-control-lg custom-select" 
                                        name="branch_id" id="branch_id" required>
                                    </select>
                                </div>
                                <label class="col-form-label col-lg-2"><span class="text-danger">*</span>نام شرکت</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control"
                                           name="name_sherkat"
                                           id="name_sherkat"
                                           maxlength="100"
                                           autocomplete="off"
                                           placeholder="مثال: سحر ارتباط"
                                           required>
                                </div>
                                
                                <label class="col-form-label col-lg-2"><span class="text-danger">*</span>شماره ثبت</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="shomare_sabt" id="shomare_sabt"
                                           maxlength="20"
                                           autocomplete="off"
                                           required>
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
                                           placeholder="تاریخ تولد"
                                           readonly
                                           required>
                                </div>
                                
                                <label class="col-form-label col-lg-2"><span class="text-danger">*</span>کد اقتصادی</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="code_eghtesadi" id="code_eghtesadi"
                                           autocomplete="off"
                                           required>
                                </div>
                                
                                <label class="col-form-label col-lg-2"><span class="text-danger">*</span>شناسه ملی</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control"
                                           name="shenase_meli"
                                           id="shenase_meli"
                                           placeholder=""
                                           required>
                                </div>
                                
                                <label class="col-form-label col-md-2" for="meliat"><span class="text-danger">*</span>ملیت شرکت</label>
                                <div class="col-md-4">
                                    <select class="form-control form-control-lg custom-select" 
                                        name="meliat" id="meliat" required>
                                        <option disabled selected> -- یک مورد را انتخاب کنید -- </option>
                                    </select>
                                </div>

                                <label class="col-form-label col-md-2" for="meliat"><span class="text-danger">*</span>نوع شرکت</label>
                                <div class="col-md-4">
                                    <select class="form-control form-control-lg custom-select" 
                                        name="noe_sherkat" id="noe_sherkat" required>
                                        <option disabled selected> -- یک مورد را انتخاب کنید -- </option>
                                    </select>
                                </div>

                                <legend class="text-uppercase font-size-md font-weight-bold" style="color: #FB8C00">اطلاعات هویتی مدیرعامل / نماینده ( اجباری )</legend>
                                <label class="col-form-label col-lg-2"><span class="text-danger">*</span>نام مدیر عامل/نماینده</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="name" id="name"
                                           maxlength="40"
                                           autocomplete="off"
                                           placeholder="محمد"
                                           required>
                                </div>
                                
                                <label class="col-form-label col-lg-2"><span class="text-danger">*</span>نام خانوادگی مدیر عامل / نماینده</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="f_name" id="f_name"
                                           maxlength="40"
                                           autocomplete="off"
                                           placeholder="مثال: محمدی"
                                           required>
                                </div>
                                
                                <label class="col-form-label col-lg-2"><span class="text-danger">*</span>نام پدر عامل/نماینده</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="name_pedar" id="name_pedar"
                                           maxlength="40"
                                           autocomplete="off"
                                           placeholder="محمد"
                                           required>
                                </div>
                                
                                <label class="col-form-label col-md-2" for="meliat_namayande"><span class="text-danger">*</span>ملیت مدیرعامل/ نماینده</label>
                                <div class="col-md-4">
                                    <select class="form-control form-control-lg custom-select" 
                                        name="meliat_namayande" id="meliat_namayande" required>
                                        <option disabled selected> -- یک مورد را انتخاب کنید -- </option>
                                    </select>
                                </div>
                                
                                <label class="col-form-label col-md-2"><span class="text-danger">*</span>تابعیت</label>
                                <div class="col-md-4">
                                    <select class="form-control form-control-lg custom-select" 
                                        name="tabeiat" id="tabeiat" required>
                                        <option disabled selected> -- یک مورد را انتخاب کنید -- </option>
                                    </select>
                                </div>
                                
                                <label class="col-form-label col-lg-2">شماره شناسنامه<span class="text-danger">*</span></label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="s_s" id="s_s" placeholder="" required>
                                </div>
                                <label class="col-form-label col-lg-2"><span class="text-danger">*</span>نوع شناسه هویتی</label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom-select" name="noe_shenase_hoviati" id="noe_shenase_hoviati" required>
                                        <option disabled selected> -- یک مورد را انتخاب کنید -- </option>
                                        <option value="0">کد ملی</option>
                                        <option value="1">پاسپورت</option>
                                        <option value="2">کارت آمایش</option>
                                        <option value="3">کارت پاهندگی</option>
                                        <option value="4">کارت هویت</option>
                                        <option value="5">شناسه ملی</option>
                                        <option value="6">شماره فراگیر گذرنامه</option>
                                    </select>
                                </div>
                                <label class="col-form-label col-lg-2"><span class="text-danger">*</span>کد ملی / شناسه هویتی</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control"
                                           name="national_code"
                                           id="national_code"
                                           autocomplete="off"
                                           required>
                                </div>
                                
                                
                                
                                <label class="col-form-label col-lg-2"><span class="text-danger">*</span>استان محل تولد</label>
                                <div class="col-lg-4">
                                <select class="form-control form-control-lg custom-select" id="ostane_tavalod" name="ostane_tavalod" required>
                                </select>
                                </div>
                                
                                <label class="col-form-label col-lg-2"><span class="text-danger">*</span>شهر محل تولد</label>
                                <div class="col-lg-4">
                                <select class="form-control form-control-lg custom-select" id="shahre_tavalod" name="shahre_tavalod" required>
                                </select>
                                </div>

                                <label class="col-form-label col-md-2"><span class="text-danger">*</span>استان محل سکونت</label>
                                <div class="col-md-4">
                                    <select class="form-control form-control-lg custom-select" id="ostane_sokonat" name="ostane_sokonat" required>
                                    </select>
                                </div>
                                
                                <label class="col-form-label col-md-2"><span class="text-danger">*</span>شهر محل سکونت</label>
                                <div class="col-md-4">
                                    <select class="form-control form-control-lg custom-select" id="shahre_sokonat" name="shahre_sokonat" required>
                                    </select>
                                </div>
                                
                                <label class="col-form-label col-lg-2"><span class="text-danger">*</span>تاریخ تولد مدیر عامل / نماینده</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control usage" name="tarikhe_tavalod" id="tarikhe_tavalod"
                                           class="form-control"
                                           mask="____/__/__"
                                           minlength='11'
                                           autocomplete='off'
                                           placeholder="تاریخ تولد"
                                           readonly
                                           required>
                                </div>
                                
                                
                                <label class="col-form-label col-lg-2"><span class="text-danger">*</span>جنسیت مدیر عامل / نماینده</label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom-select" name="jensiat" id="jensiat" required>
                                        <option disabled selected> -- یک مورد را انتخاب کنید -- </option>
                                        <option value="1">مرد</option>
                                        <option value="2">زن</option>
                                    </select>
                                </div>
                                
                                <label class="col-form-label col-lg-2"><span class="text-danger">*</span>تلفن همراه</label>
                                <div class="col-lg-4">
                                    <input type="text" class="validate mobileValidation form-control"
                                           name="telephone_hamrah"
                                           id="telephone_hamrah"
                                           pattern="^09\d{9}$"
                                           autocomplete="off"
                                           placeholder="مثال: 0912123456789"
                                           required>
                                </div>

                                <legend class="text-uppercase font-size-md font-weight-bold" style="color: #FB8C00">اطلاعات مربوط به تلفن اول ( اجباری )</legend>
                                <label class="col-form-label col-md-2">شماره تلفن<span class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="telephone1" id="telephone1" 
                                    autocomplete="off"
                                    placeholder="مثال: 02112345678" required>
                                </div>
                                <label class="col-form-label col-md-2">نوع مالکیت خط<span class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <select class="form-control form-control-lg custom-select" id="noe_malekiat1" name="noe_malekiat1" required>
                                        <option value="1">مالک</option>
                                        <option value="2">مستاجر</option>
                                    </select>
                                </div>
                                <label class="col-form-label col-md-2">نام مالک خط<span class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="name_malek1" id="name_malek1">
                                </div>

                                <label class="col-form-label col-md-2">نام خانوادگی مالک خط<span class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="f_name_malek1" id="f_name_malek1" required>
                                </div>
                                <label class="col-form-label col-md-2">کد ملی مالک خط<span class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="code_meli_malek1" id="code_meli_malek1" required>
                                </div>

                                <label class="col-form-label col-md-2">کد پستی خط<span class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="code_posti1" id="code_posti1" required>
                                </div>
                                
                                <label class="col-form-label col-md-2">استان<span class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <select class="form-control form-control-lg custom-select" id="tel1_ostan" name="tel1_ostan" required>
                                    </select>
                                </div>
                                
                                <label class="col-form-label col-md-2">شهر <span class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <select class="form-control form-control-lg custom-select" id="tel1_shahr" name="tel1_shahr" required>
                                    </select>
                                </div>
                                
                                <label class="col-form-label col-md-2"> معبر اصلی(خیابان اصلی) <span class="text-danger">*</span></label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="tel1_street" id="tel1_street" required>
                                </div>
                                
                                <label class="col-form-label col-md-2">معبر فرعی(کوچه / خیابان فرعی)<span class="text-danger">*</span></label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="tel1_street2" id="tel1_street2" required>
                                </div>

                                <label class="col-form-label col-md-2"><span class="text-danger">*</span>پلاک</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="tel1_housenumber" id="tel1_housenumber" required>
                                </div>

                                <label class="col-form-label col-md-2"><span class="text-danger">*</span>طبقه(عدد)</label>
                                <div class="col-md-4">
                                    <input type="number" class="form-control" name="tel1_tabaghe" id="tel1_tabaghe" required>
                                </div>

                                <label class="col-form-label col-md-2"><span class="text-danger">*</span>واحد(عدد)</label>
                                <div class="col-md-4">
                                    <input type="number" class="form-control" name="tel1_vahed" id="tel1_vahed" required>
                                </div>

                                <legend class="text-uppercase font-size-md font-weight-bold" style="color: #FB8C00">اطلاعات مربوط به تلفن دوم ( اختیاری )</legend>
                                <label class="col-form-label col-md-2">شماره تلفن</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="telephone2" id="telephone2" 
                                    autocomplete="off"
                                    placeholder="مثال: 02112345678">
                                </div>
                                <label class="col-form-label col-md-2">نوع مالکیت خط</label>
                                <div class="col-md-4">
                                    <select class="form-control form-control-lg custom-select" id="noe_malekiat2" name="noe_malekiat2">
                                        <option value="1">مالک</option>
                                        <option value="2">مستاجر</option>
                                    </select>
                                </div>
                                <label class="col-form-label col-md-2">نام مالک خط</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="name_malek2" id="name_malek2">
                                </div>

                                <label class="col-form-label col-md-2">نام خانوادگی مالک خط</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="f_name_malek2" id="f_name_malek2">
                                </div>
                                <label class="col-form-label col-md-2">کد ملی مالک خط</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="code_meli_malek2" id="code_meli_malek2">
                                </div>

                                <label class="col-form-label col-md-2">کد پستی خط</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="code_posti2" id="code_posti2">
                                </div>
                                
                                <label class="col-form-label col-md-2">استان</label>
                                <div class="col-md-4">
                                    <select class="form-control form-control-lg custom-select" id="tel2_ostan" name="tel2_ostan">
                                    </select>
                                </div>
                                
                                <label class="col-form-label col-md-2">شهر</label>
                                <div class="col-md-4">
                                    <select class="form-control form-control-lg custom-select" id="tel2_shahr" name="tel2_shahr">
                                    </select>
                                </div>
                                
                                <label class="col-form-label col-md-2"> معبر اصلی(خیابان اصلی)</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="tel2_street" id="tel2_street">
                                </div>
                                
                                <label class="col-form-label col-md-2">معبر فرعی(کوچه / خیابان فرعی)</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="tel2_street2" id="tel2_street2">
                                </div>

                                <label class="col-form-label col-md-2">پلاک</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="tel2_housenumber" id="tel2_housenumber">
                                </div>

                                <label class="col-form-label col-md-2">طبقه(عدد)</label>
                                <div class="col-md-4">
                                    <input type="number" class="form-control" name="tel2_tabaghe" id="tel2_tabaghe">
                                </div>

                                <label class="col-form-label col-md-2">واحد(عدد)</label>
                                <div class="col-md-4">
                                    <input type="number" class="form-control" name="tel2_vahed" id="tel2_vahed">
                                </div>

                                <legend class="text-uppercase font-size-md font-weight-bold" style="color: #FB8C00">اطلاعات مربوط به تلفن سوم ( اختیاری )</legend>

                                <label class="col-form-label col-md-2">شماره تلفن</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="telephone3" id="telephone3" 
                                    autocomplete="off"
                                    placeholder="مثال: 02112345678">
                                </div>
                                <label class="col-form-label col-md-2">نوع مالکیت خط</label>
                                <div class="col-md-4">
                                    <select class="form-control form-control-lg custom-select" id="noe_malekiat3" name="noe_malekiat3">
                                        <option value="1">مالک</option>
                                        <option value="2">مستاجر</option>
                                    </select>
                                </div>
                                <label class="col-form-label col-md-2">نام مالک خط</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="name_malek3" id="name_malek3">
                                </div>

                                <label class="col-form-label col-md-2">نام خانوادگی مالک خط</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="f_name_malek3" id="f_name_malek3">
                                </div>
                                <label class="col-form-label col-md-2">کد ملی مالک خط</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="code_meli_malek3" id="code_meli_malek3">
                                </div>

                                <label class="col-form-label col-md-2">کد پستی خط</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="code_posti3" id="code_posti3">
                                </div>
                                

                                <label class="col-form-label col-md-2">استان</label>
                                <div class="col-md-4">
                                    <select class="form-control form-control-lg custom-select" id="tel3_ostan" name="tel3_ostan">
                                    </select>
                                </div>
                                
                                <label class="col-form-label col-md-2">شهر</label>
                                <div class="col-md-4">
                                    <select class="form-control form-control-lg custom-select" id="tel3_shahr" name="tel3_shahr">
                                    </select>
                                </div>
                                
                                <label class="col-form-label col-md-2">معبر اصلی(خیابان اصلی)</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="tel3_street" id="tel3_street">
                                </div>
                                
                                <label class="col-form-label col-md-2">معبر فرعی(کوچه / خیابان فرعی)</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="tel3_street2" id="tel3_street2">
                                </div>

                                <label class="col-form-label col-md-2">پلاک</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="tel3_housenumber" id="tel3_housenumber">
                                </div>

                                <label class="col-form-label col-md-2">طبقه(عدد)</label>
                                <div class="col-md-4">
                                    <input type="number" class="form-control" name="tel3_tabaghe" id="tel3_tabaghe">
                                </div>

                                <label class="col-form-label col-md-2">واحد(عدد)</label>
                                <div class="col-md-4">
                                    <input type="number" class="form-control" name="tel3_vahed" id="tel3_vahed">
                                </div>
                                <legend class="text-uppercase font-size-md font-weight-bold" style="color: #FB8C00">اطلاعات تکمیلی شرکت (اختیاری)</legend>
                                
                                <label class="col-form-label col-lg-2">فکس</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="fax" id="fax"
                                           maxlength="11"
                                           minlength="11"
                                           autocomplete="off"
                                           placeholder="با پیش شماره">
                                </div>
                                
                                <label class="col-form-label col-lg-2">وب سایت</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="website" id="website"
                                           placeholder="مثال: www.saharertebat.net">
                                </div>
                                
                                <label class="col-form-label col-lg-2">پست الکترونیک</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control langEn" name="email" id="email"
                                           autocomplete="off"
                                           maxlength="100"
                                           placeholder="مثال: abcd@gmail.com">
                                </div>
                                
                                
                                
                                
                                <label class="col-form-label col-lg-2">گروه مشترک</label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom-select" name="gorohe_moshtarak" id="gorohe_moshtarak">
                                    </select>
                                </div>
                                
                                
                                <label class="col-form-label col-lg-2">رشته فعالیت</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="reshteye_faaliat" id="reshteye_faaliat" placeholder="">
                                </div>
                                
                                <label class="col-form-label col-lg-2">نحوه آشنایی</label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom-select" name="nahve_ashnai" id="nahve_ashnai">
                                    </select>
                                </div>
                                
                                <label class="col-form-label col-lg-2">معرف</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="moaref" id="moaref" placeholder="">
                                </div>
                                <div class="col-lg-6">
                                </div>
                                
                                <label class="col-form-label col-lg-2">توضیحات</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="tozihat" id="tozihat" placeholder="">
                                </div>
                                <legend class="text-uppercase font-size-md font-weight-bold" style="color: #FB8C00">تصاویر هویتی شرکت (اختیاری)</legend>
                                <label class="col-form-label col-lg-2">تصویر آگهری تاسیس</label>
                                <div class="col-lg-4" id="link_l_t_agahie_tasis">
                                    <input type="file" name="l_t_agahie_tasis" id="l_t_agahie_tasis" class="form-control-uniform">
                                </div>
                                
                                <label class="col-form-label col-lg-2">تصویر آخرین تغییرات</label>
                                <div class="col-lg-4" id="link_l_t_akharin_taghirat">
                                    <input type="file" name="l_t_akharin_taghirat" id="l_t_akharin_taghirat" class="form-control-uniform">
                                </div>
                                
                                <label class="col-form-label col-lg-2">تصویر کارت ملی صاحب امضای اول</label>
                                <div class="col-lg-4" id="link_l_t_saheb_kartemeli_emzaye_aval">
                                    <input type="file" name="l_t_saheb_kartemeli_emzaye_aval" id="l_t_saheb_kartemeli_emzaye_aval" class="form-control-uniform">
                                </div>
                                
                                <label class="col-form-label col-lg-2">تصویر کارت ملی صاحب امضای دوم</label>
                                <div class="col-lg-4" id="link_l_t_saheb_kartemeli_emzaye_dovom">
                                    <input type="file" name="l_t_saheb_kartemeli_emzaye_dovom" id="l_t_saheb_kartemeli_emzaye_dovom" class="form-control-uniform">
                                </div>
                                
                                <label class="col-form-label col-lg-2">تصویر کارت ملی نماینده</label>
                                <div class="col-lg-4" id="link_l_t_kartemeli_namayande">
                                    <input type="file" name="l_t_kartemeli_namayande" id="l_t_kartemeli_namayande" class="form-control-uniform">
                                </div>
                                
                                <label class="col-form-label col-lg-2">تصویر معرفی نامه نماینده</label>
                                <div class="col-lg-4" id="link_l_t_moarefiname_namayande">
                                    <input type="file" name="l_t_moarefiname_namayande" id="l_t_moarefiname_namayande" class="form-control-uniform">
                                </div>
                                
                                <label class="col-form-label col-lg-2">تصویر قبض تلفن</label>
                                <div class="col-lg-4" id="link_l_t_ghabze_telephone">
                                    <input type="file" name="l_t_ghabze_telephone" id="l_t_ghabze_telephone" class="form-control-uniform">
                                </div>
                                
                                <label class="col-form-label col-lg-2">تصویر قرارداد</label>
                                <div class="col-lg-4" id="link_l_t_gharardad">
                                    <input type="file" name="l_t_gharardad" id="l_t_gharardad" class="form-control-uniform">
                                </div>
                                
                                <label class="col-form-label col-lg-2">تصویر اجاره نامه / مالکیت</label>
                                <div class="col-lg-4" id="link_l_t_ejarename_malekiat">
                                    <input type="file" name="l_t_ejarename_malekiat" id="l_t_ejarename_malekiat" class="form-control-uniform">
                                </div>
                                
                                <label class="col-form-label col-lg-2">تصویر سایر</label>
                                <div class="col-lg-4" id="link_l_t_sayer">
                                    <input type="file" name="l_t_sayer" id="l_t_sayer" class="form-control-uniform">
                                </div>
                                
                            </div>
                        </fieldset>
                        <div class="text-right">
                            <button type="submit" name="send_legal_subscribers" class="btn btn-primary" onsubmit="resetId()">ارسال <i class="icon-paperplane ml-2"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /form inputs -->
            <div class="card">
                <div class="col-md-12">
                    <button name="delete" class="btn btn-warning col-md-auto float-md-right"  id="delete">حذف<i class="icon-folder-remove ml-2"></i></button>
                    <button name="edit" class="btn btn-primary col-md-auto float-md-right" id="edit">ویرایش<i class="icon-database-edit2 ml-2"></i></button>
                    <button name="estauth" class="btn btn-danger col-md-auto float-md-left" id="estauth">احراز هویت مشترک<i class="icon-pen6 ml-2"></i></button>
                    <table id="view_table" class="table table-striped datatable-responsive table-hover">
                    </table>
                </div>
            </div>
        </div>
        <!-- /content area -->
