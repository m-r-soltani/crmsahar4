        <!-- Content area -->
        <div class="content">
            <!-- Form inputs -->
            <div class="card container">
                <div class="card-body">
                    <form action="#" method="POST" enctype="multipart/form-data">
                        <fieldset class="mb-3">
                        <div class="form-group row">
                        <legend class="text-uppercase font-size-lg font-weight-bold center" style="color: #FB8C00">پیش ثبت نام نمایندگی </legend>
                                <legend class="text-uppercase font-size-md font-weight-bold" style="color: #FB8C00">اطلاعات نمایندگی ( ستاره دار اجباری )</legend>
                                <label class="col-form-label col-lg-2">نام شرکت/موسسه <span class="text-danger">*</span></label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="name_sherkat" id="name_sherkat" placeholder="مثال: سحر ارتباط" required>
                                </div>
                                
                                <label class="col-form-label col-lg-2">شماره ثبت/پروانه</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="shomare_sabt" id="shomare_sabt" placeholder="...">
                                </div>
                                <label class="col-form-label col-lg-2">تاریخ ثبت <span class="text-danger">*</span></label>
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
                                    <input type="text" class="form-control" name="shenase_meli" id="shenase_meli" placeholder="...">
                                </div>
                                
                                <label class="col-form-label col-lg-2">کد اقتصادی</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="code_eghtesadi" id="code_eghtesadi" placeholder="...">
                                </div>
                                
                                <label class="col-form-label col-lg-2">نوع شرکت/موسسه</label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom-select" name="noe_sherkat" id="noe_sherkat">
                                    </select>
                                </div>
                                
                                <label class="col-form-label col-lg-2">وب سایت</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="website" id="website" placeholder="www.saharertebat.net">
                                </div>
                                
                                <label class="col-form-label col-lg-2">پست الکترونیک</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="email" id="email" placeholder="saharertebat@gmail.com">
                                </div>
                                
                                <label class="col-form-label col-lg-2">تلفن ثابت <span class="text-danger">*</span></label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="telephone1" id="telephone1" pattern="^0\d{2,3}\d{8}$" placeholder="مثال: 02122376081"  required>
                                </div>
                                <label class="col-form-label col-lg-2">تلفن همراه <span class="text-danger">*</span></label>
                                <div class="col-lg-4">
                                    <input type="text" class="validate mobileValidation form-control"
                                           name="telephone_hamrah"
                                           id="telephone_hamrah"
                                           pattern="^09\d{9}$"
                                           autocomplete="off"
                                           placeholder="مثال: 09121234567"
                                           required>
                                </div>
                                

                                
                                <label class="col-form-label col-lg-2">دورنگار</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="dornegar" id="dornegar" placeholder="مثال: 02122376081">
                                </div>
                                
                                <label class="col-form-label col-lg-2">استان <span class="text-danger">*</span></label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom_select" name="ostan" id="ostan" required>
                                    </select>
                                </div>
                                
                                <label class="col-form-label col-lg-2">شهر <span class="text-danger">*</span></label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom_select" name="shahr" id="shahr" required>
                                    </select>
                                </div>

                                <label class="col-form-label col-lg-2">کد پستی</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="code_posti" id="code_posti" placeholder="فقط عدد">
                                </div>
                                
                                <label class="col-form-label col-lg-2">آدرس <span class="text-danger">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="address" id="address" placeholder="مثال: تهران خیابان شریعتی کوچه ..." required>
                                </div>
                                <label class="col-form-label col-lg-2">توضیحات تجهیزات</label>
                                <div class="col-lg-10">
                                    <textarea class="form-control" id="tozihatetajhizat" name="tozihatetajhizat" style="height: 75px;"></textarea>
                                </div>
                                <label class="col-form-label col-lg-2">توضیحات برنامه فروش</label>
                                <div class="col-lg-10">
                                    <textarea class="form-control" id="tozihatebarnameforosh" name="tozihatebarnameforosh" style="height: 75px;"></textarea>
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
                            <button type="submit" name="send_pre_branch" class="btn btn-primary" onsubmit="resetId()">ارسال <i class="icon-paperplane ml-2"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /form inputs -->
        </div>
        <!-- /content area -->