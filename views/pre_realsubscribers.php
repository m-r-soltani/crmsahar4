        <!-- Content area -->
        <div class="content">
            <!-- Form inputs -->
            <div class="card container">
                <div class="card-body">
                    <form action="#" method="POST" enctype="multipart/form-data">
                        <fieldset class="mb-3">
                            <legend class="text-uppercase font-size-lg font-weight-bold" style="color: #FB8C00">پیش ثبت نام مشترکین حقیقی</legend>
                            <div class="form-group row">   
                           
                                <label class="col-form-label col-lg-2">نام <span class="text-danger">*</span></label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control validate langFa" name="name" id="name" 
                                    class="validate langFa form-control"
                                    autocomplete="off" placeholder="..."
                                    required>
                                </div>
                                
                                <label class="col-form-label col-lg-2">نام خانوادگی <span class="text-danger">*</span></label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control validate langFa" name="f_name" id="f_name" 
                                    autocomplete="off"
                                    placeholder="..."
                                    required>
                                </div>
                                
                                <label class="col-form-label col-lg-2">نام پدر <span class="text-danger">*</span></label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control validate langFa" name="name_pedar" id="name_pedar" 
                                    autocomplete="off" 
                                    placeholder="..."
                                    required>
                                </div>
                                
                                <label class="col-form-label col-lg-2">کد ملی / شناسه هویتی <span class="text-danger">*</span></label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control usage" 
                                    name="code_meli"
                                    id="code_meli"
                                    autocomplete="off"
                                    placeholder="کد ملی / شماره پاسپورت..."
                                    required>
                                </div>
                                
                                <label class="col-form-label col-lg-2">نوع شناسه هویتی <span class="text-danger">*</span></label>
                                <div class="col-lg-4">
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
                                                                                                
                                <label class="col-form-label col-lg-2">تاریخ تولد <span class="text-danger">*</span></label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control usage" 
                                    name="tarikhe_tavalod"
                                    id="tarikhe_tavalod" 
                                    class="form-control langFa numberValidation timeValidation"
                                    mask="____/__/__"
                                    minlength='11'
                                    autocomplete='off'
                                    placeholder="01/01/1300"
                                    readonly
                                    required>
                                </div>
                                
                                <label class="col-form-label col-lg-2">جنسیت <span class="text-danger">*</span></label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom-select" id="jensiat" name="jensiat" required>
                                        <option disabled selected> -- یک مورد را انتخاب کنید -- </option>
                                        <option value="1">مرد</option>
                                        <option value="2">زن</option>
                                    </select>
                                </div>

                                <label class="col-form-label col-lg-2">استان محل سکونت <span class="text-danger">*</span></label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom-select" id="ostane_sokonat" name="ostane_sokonat" required>
                                    </select>
                                </div>
                                
                                <label class="col-form-label col-lg-2">شهر محل سکونت <span class="text-danger">*</span></label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom-select" id="shahre_sokonat" name="shahre_sokonat" required>
                                    </select>
                                </div>

                                <label class="col-form-label col-lg-2">تلفن همراه <span class="text-danger">*</span></label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control validate mobileValidation"
                                           name="telephone_hamrah" 
                                           id="telephone_hamrah"
                                           pattern="^09\d{9}$"
                                           autocomplete="off"
                                           placeholder="مثال: 09121234567"
                                           required>
                                </div> 
                                <label class="col-form-label col-lg-2">تلفن ثابت <span class="text-danger">*</span></label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control validate langFa" name="telephone1" id="telephone1" 
                                    autocomplete="off" 
                                    placeholder="مثال: 02122376081"
                                    required>
                                </div>
                                <label class="col-form-label col-lg-2">نوع درخواست <span class="text-danger">*</span></label>
                                <div class="col-lg-4">
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
                            <button type="submit" name="send_pre_realsubscribers" class="btn btn-primary" onsubmit="resetId()">ارسال <i class="icon-paperplane ml-2"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /form inputs -->
        </div>
        <!-- /content area -->