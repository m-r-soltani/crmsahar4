        <!-- Content area -->
        <div class="content">
            <!-- Form inputs -->
            <div class="card">
                <div class="card-body">
                    <form action="#" method="POST" enctype="multipart/form-data">
                        <fieldset class="mb-3">
                            <legend class="text-uppercase font-size-md font-weight-bold">پیش ثبت نام مشترکین حقیقی</legend>
                            <div class="form-group row">
                                <legend class="text-uppercase font-size-md font-weight-bold" style="color: #FB8C00">اطلاعات هویتی مشترک ( اجباری )</legend>
                                <label class="col-form-label col-md-2" for="branch_id"><span class="text-danger">*</span>نماینده</label>
                                <div class="col-md-4">
                                    <select class="form-control form-control-lg custom-select" 
                                        name="branch_id" id="branch_id" required>
                                    </select>
                                </div>
                                
                                <label class="col-form-label col-md-2"><span class="text-danger">*</span>نام</label>
                                <div class="col-md-4">
                                    <input type="hidden" id="id" class="form-control" name="id" value="empty">
                                    <input type="hidden" id="noe_moshtarak" name="noe_moshtarak" class="form-control"  value="real">
                                    <input type="text" class="form-control validate langFa" name="name" id="name" 
                                    class="validate langFa form-control"
                                    autocomplete="off" placeholder="محمد"
                                    required>
                                </div>
                                
                                <label class="col-form-label col-md-2"><span class="text-danger">*</span>نام خانوادگی</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control validate langFa" name="f_name" id="f_name" 
                                    autocomplete="off"
                                    placeholder="مثال: محمدی"
                                    required>
                                </div>
                                
                                <label class="col-form-label col-md-2"><span class="text-danger">*</span>نام پدر</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control validate langFa" name="name_pedar" id="name_pedar" 
                                    autocomplete="off" 
                                    placeholder="محمد"
                                    required>
                                </div>

                                <label class="col-form-label col-md-2" for="meliat"><span class="text-danger">*</span>ملیت</label>
                                <div class="col-md-4">
                                    <select class="form-control form-control-lg custom-select" 
                                        name="meliat" id="meliat" required>
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
                                
                                <label class="col-form-label col-md-2"><span class="text-danger">*</span>شماره شناسنامه</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control usage" 
                                    name="s_s"
                                    id="s_s"
                                    autocomplete="off">
                                </div>
                                
                                <label class="col-form-label col-md-2"><span class="text-danger">*</span>کد ملی / شناسه هویتی</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control usage" 
                                    name="national_code"
                                    id="national_code"
                                    autocomplete="off"
                                    placeholder="کد ملی 10 رقمی"
                                    required>
                                </div>
                                
                                <label class="col-form-label col-md-2"><span class="text-danger">*</span>نوع شناسه هویتی</label>
                                <div class="col-md-4">
                                    <select class="form-control form-control-lg custom-select" 
                                    name="noe_shenase_hoviati" id="noe_shenase_hoviati" required>
                                        <option value="0">کد ملی</option>
                                        <option value="1">پاسپورت</option>
                                        <option value="2">کارت آمایش</option>
                                        <option value="3">کارت پاهندگی</option>
                                        <option value="4">کارت هویت</option>
                                        <option value="5">شناسه ملی</option>
                                        <option value="6">شماره فراگیر گذرنامه</option>
                                    </select>
                                </div>
                                                                                                
                                <label class="col-form-label col-md-2"><span class="text-danger">*</span>تاریخ تولد</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control usage" 
                                    name="tarikhe_tavalod"
                                    id="tarikhe_tavalod" 
                                    class="form-control langFa numberValidation timeValidation"
                                    mask="____/__/__"
                                    minlength='11'
                                    autocomplete='off'
                                    placeholder="تاریخ تولد"
                                    readonly
                                    required>
                                </div>
                                
                                <label class="col-form-label col-md-2"><span class="text-danger">*</span>جنسیت</label>
                                <div class="col-md-4">
                                    <select class="form-control form-control-lg custom-select" id="jensiat" name="jensiat" required>
                                        <option disabled selected> -- یک مورد را انتخاب کنید -- </option>
                                        <option value="1">مرد</option>
                                        <option value="2">زن</option>
                                    </select>
                                </div>
                                
                                <label class="col-form-label col-md-2"><span class="text-danger">*</span>استان محل تولد</label>
                                <div class="col-md-4">
                                    <select class="form-control form-control-lg custom-select" id="ostane_tavalod" name="ostane_tavalod" required>
                                    </select>
                                </div>
                                
                                <label class="col-form-label col-md-2"><span class="text-danger">*</span>شهر محل تولد</label>
                                <div class="col-md-4">
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

                                <label class="col-form-label col-md-2"><span class="text-danger">*</span>تلفن همراه</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control validate mobileValidation"
                                           name="telephone_hamrah" 
                                           id="telephone_hamrah"
                                           pattern="^09\d{9}$"
                                           autocomplete="off"
                                           placeholder="مثال: 0912123456789">
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
                                    <input type="text" class="form-control validate langFa" name="tel1_street" id="tel1_street" required>
                                </div>
                                
                                <label class="col-form-label col-md-2">معبر فرعی(کوچه / خیابان فرعی)<span class="text-danger">*</span></label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control validate langFa" name="tel1_street2" id="tel1_street2" required>
                                </div>

                                <label class="col-form-label col-md-2"><span class="text-danger">*</span>پلاک</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control validate langFa" name="tel1_housenumber" id="tel1_housenumber" required>
                                </div>

                                <label class="col-form-label col-md-2"><span class="text-danger">*</span>طبقه(عدد)</label>
                                <div class="col-md-4">
                                    <input type="number" class="form-control validate langFa" name="tel1_tabaghe" id="tel1_tabaghe" required>
                                </div>

                                <label class="col-form-label col-md-2"><span class="text-danger">*</span>واحد(عدد)</label>
                                <div class="col-md-4">
                                    <input type="number" class="form-control validate langFa" name="tel1_vahed" id="tel1_vahed" required>
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
                                    <input type="text" class="form-control validate langFa" name="tel2_street" id="tel2_street">
                                </div>
                                
                                <label class="col-form-label col-md-2">معبر فرعی(کوچه / خیابان فرعی)</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control validate langFa" name="tel2_street2" id="tel2_street2">
                                </div>

                                <label class="col-form-label col-md-2">پلاک</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control validate langFa" name="tel2_housenumber" id="tel2_housenumber">
                                </div>

                                <label class="col-form-label col-md-2">طبقه(عدد)</label>
                                <div class="col-md-4">
                                    <input type="number" class="form-control validate langFa" name="tel2_tabaghe" id="tel2_tabaghe">
                                </div>

                                <label class="col-form-label col-md-2">واحد(عدد)</label>
                                <div class="col-md-4">
                                    <input type="number" class="form-control validate langFa" name="tel2_vahed" id="tel2_vahed">
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
                                    <input type="text" class="form-control validate langFa" name="tel3_street" id="tel3_street">
                                </div>
                                
                                <label class="col-form-label col-md-2">معبر فرعی(کوچه / خیابان فرعی)</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control validate langFa" name="tel3_street2" id="tel3_street2">
                                </div>

                                <label class="col-form-label col-md-2">پلاک</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control validate langFa" name="tel3_housenumber" id="tel3_housenumber">
                                </div>

                                <label class="col-form-label col-md-2">طبقه(عدد)</label>
                                <div class="col-md-4">
                                    <input type="number" class="form-control validate langFa" name="tel3_tabaghe" id="tel3_tabaghe">
                                </div>

                                <label class="col-form-label col-md-2">واحد(عدد)</label>
                                <div class="col-md-4">
                                    <input type="number" class="form-control validate langFa" name="tel3_vahed" id="tel3_vahed">
                                </div>
                                <legend class="text-uppercase font-size-md font-weight-bold" style="color: #FB8C00">اطلاعات تکمیلی مشترک ( اختیاری )</legend>
                                
                                <label class="col-form-label col-md-2">فکس</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="fax" id="fax" placeholder="">
                                </div>
                                
                                <label class="col-form-label col-md-2">پست الکترونیک</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control validate langEn"
                                    id="email" 
                                    name="email" autocomplete="off"
                                           maxlength="100"
                                           placeholder="مثال: abcd@gmail.com">
                                </div>
                                
                                
                                <label class="col-form-label col-md-2">وب سایت</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control validate langEn" name="website" id="website" placeholder="مثال: www.saharertebat.net">
                                </div>
                                

                                <label class="col-form-label col-md-2">شغل</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="shoghl validate langFa" id="shoghl">
                                </div>
                                
                                <label class="col-form-label col-md-2">معرف</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="moaref" id="moaref" >
                                </div>
                                                                                                
                                <label class="col-form-label col-md-2">نحوه آشنایی</label>
                                <div class="col-md-4">
                                    <select class="form-control form-control-lg custom-select" name="nahve_ashnai_campain" id="nahve_ashnai_campain">
                                    </select>
                                </div>
                                
                                <label class="col-form-label col-md-2">گروه مشترک</label>
                                <div class="col-md-4">
                                    <select class="form-control form-control-lg custom-select" name="gorohe_moshtarak" id="gorohe_moshtarak">
                                    </select>
                                </div>
                                <div class="col-md-12">
                                </div>                         
                                <label class="col-form-label col-md-2">توضیحات</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="tozihat" id="tozihat">
                                </div>
                                <legend class="text-uppercase font-size-md font-weight-bold" style="color: #FB8C00">تصویر مدارک ( اختیاری )</legend>
                                <label class="col-form-label col-md-2">تصویر کارت ملی</label>
                                <div class="col-md-4" id="link_r_t_karte_meli">
                                    <input type="file" name="r_t_karte_meli" id="r_t_karte_meli"  class="form-control-uniform">
                                </div>
                                
                                <label class="col-form-label col-md-2">تصویر قبض تلفن</label>
                                <div class="col-md-4" id="link_r_t_ghabze_telephone">
                                    <input type="file" name="r_t_ghabze_telephone" id="r_t_ghabze_telephone" class="form-control-uniform">
                                </div>
                                
                                <label class="col-form-label col-md-2">تصویر اجاره نامه / مالکیت</label>
                                <div class="col-md-4" id="link_r_t_ejare_malekiat">
                                    <input type="file" name="r_t_ejare_malekiat" id="r_t_ejare_malekiat" class="form-control-uniform">
                                </div>
                                
                                <label class="col-form-label col-md-2">تصویر قرارداد</label>
                                <div class="col-md-4" id="link_r_t_gharardad">
                                    <input type="file" name="r_t_gharardad" id="r_t_gharardad" class="form-control-uniform">
                                </div>
                                
                                <label class="col-form-label col-md-2">تصویر سایر</label>
                                <div class="col-md-4" id="link_r_t_sayer">
                                    <input type="file" name="r_t_sayer" id="r_t_sayer" class="form-control-uniform">
                                </div>
                                <legend class="text-uppercase font-size-md font-weight-bold" style="color: #FB8C00">درخواست ها</legend>
                                <label class="col-form-label col-lg-2">نوع درخواست</label>
                                <div class="col-lg-10">
                                    <select class="form-control form-control-lg custom-select" id="noedarkhast" name="noedarkhast">
                                        <option disabled selected> -- یک مورد را انتخاب کنید -- </option>
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
                                        <option value="13">سایر درخواست ها</option>
                                    </select>
                                </div>
                                <label class="col-form-label col-lg-2 ">توضیحات</label>
                                <div class="col-lg-10">
                                    <textarea class="form-control" id="tozihate_darkhast" name="tozihate_darkhast" style="height: 100px;"></textarea>
                                </div>
                            </div>
                        </fieldset>
                        <div class="text-right">
                            <button type="submit" name="send_pre_internal_real_subscribers" class="btn btn-primary" onsubmit="resetId()">ارسال <i class="icon-paperplane ml-2"></i></button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- /form inputs -->
            <div class="card">
                <div class="col-md-12">
                    <button name="delete" class="btn btn-warning col-md-auto float-md-right"  id="delete">حذف<i class="icon-folder-remove ml-2"></i></button>
                    <button name="edit" class="btn btn-primary col-md-auto float-md-right" id="edit">ویرایش<i class="icon-database-edit2 ml-2"></i></button>
                    <!-- <button name="estauth" class="btn btn-danger col-md-auto float-md-left" id="estauth">احراز هویت مشترک<i class="icon-pen6 ml-2"></i></button> -->
                    <button name="confirmsub" class="btn btn-success col-md-auto float-md-left" id="confirmsub">تایید و انتقال به لیست مشترکین<i class="icon-database ml-2"></i></button>
                    <table id="view_table" class="table table-striped datatable-responsive table-hover">
                    </table>
                </div>
            </div>
        </div>
        <!-- /content area -->