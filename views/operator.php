<!-- Content area -->
<div class="content">
    <!-- Form inputs -->
    <div class="card">
        <div class="card-body">
            <form action="#" method="POST">
                <input type="hidden" id="id" class="form-control" name="id" value="empty">
                <fieldset class="mb-3">
                    <legend class="text-uppercase font-size-sm font-weight-bold">اپراتور</legend>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2"><span class="text-danger">*</span>نام نمایندگی</label>
                        <div class="col-lg-4">
                            <select class="form-control form-control-lg custom-select" name="branch_id" id="branch_id" required>
                            </select>
                        </div>
                        <label class="col-form-label col-lg-2" for='name'><span class="text-danger">*</span>نام</label>
                        <div class="col-lg-4">
                            <input type="text" name="name" id="name"
                                class="validate langFa form-control"
						        maxlength="40"
						        data-vpKeyboard="keyboard"
                                autocomplete="off"
                                placeholder="محمد"
                                required>
                        </div>

                        <label class="col-form-label col-lg-2" for="name_khanevadegi"><span class="text-danger">*</span>نام خانوادگی</label>
                        <div class="col-lg-4">
                            <input type="text" class="validate langFa form-control"
                            name="name_khanevadegi" id="name_khanevadegi"
                            maxlength="40"
						    data-vpKeyboard="keyboard"
                            autocomplete="off"
                            placeholder="مثال: محمدی"
                            required>
                        </div>

                        <label class="col-form-label col-lg-2" for="national_code"><span class="text-danger">*</span>کد ملی</label>
                        <div class="col-lg-4">
                        <input type="text" class="form-control"
						   data-vpKeyboard="keyboard"
                           maxlength="10" minlength="10"
                           name="national_code"
                           id="national_code"
                           autocomplete="off"
                           placeholder="کد ملی 10 رقمی"
                           required>
                        </div>

                        <label class="col-form-label col-lg-2" for="s_s"><span class="text-danger">*</span>شماره شناسنامه</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control"
                            name="s_s"
                            id="s_s"
                            maxlength="10"
                            autocomplete="off"
                            required>
                        </div>

                        <label class="col-form-label col-lg-2" for="name_pedar"><span class="text-danger">*</span>نام پدر</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control validate langFa"
                            name="name_pedar"
                            maxlength="40"
                            autocomplete="off"
                            id="name_pedar" placeholder=""
                            required>
                        </div>

                        <label for="tarikhe_tavalod" class="col-lg-2 control-label"><span class="text-danger">*</span>تاریخ تولد</label>
                        <div class="col-lg-4">
                            <input type="text" 
                                name="tarikhe_tavalod"
                                id="tarikhe_tavalod" 
                                class="form-control langFa numberValidation timeValidation"
                                mask="____/__/__"
                                maxlength='11'
                                autocomplete='off'
                                placeholder="تاریخ تولد"
                                readonly
                                required>
                        </div>

                        <label class="col-form-label col-lg-2" for="madrake_tahsili">آخرین مدرک تحصیلی</label>
                        <div class="col-lg-4">
                            <select class="form-control form-control-lg custom-select"
                            id="madrake_tahsili" name="madrake_tahsili">
                                <option value="diplom">دیپلم</option>
                                <option value="foghdiplom">فوق دیپلم</option>
                                <option value="lisanse">لیسانس</option>
                                <option value="foghlisanse">فوق لیسانس</option>
                                <option value="doktora">دکتری</option>
                            </select>
                        </div>

                        <label class="col-form-label col-lg-2" for="reshteye_tahsili">رشته نحصیلی</label>
                        <div class="col-lg-4">
                            <input type="text" class="validate langFa form-control"
                            name="reshteye_tahsili" id="reshteye_tahsili" placeholder="مثال: کامپیوتر">
                        </div>

                        <label class="col-form-label col-lg-2" for="ostan_tavalod"><span class="text-danger">*</span>استان محل تولد</label>
                        <div class="col-lg-4">
                            <input type="text" class="validate langFa form-control"
                            name="ostan_tavalod"
                            id="ostan_tavalod" placeholder="مثال: تهران" required>
                        </div>

                        <label class="col-form-label col-lg-2"><span class="text-danger">*</span>شهر محل تولد</label>
                        <div class="col-lg-4">
                            <input type="text" class="validate langFa form-control"
                            name="shahr_tavalod"
                            id="shahr_tavalod" placeholder="مثال: تهران" required>
                        </div>

                        <label class="col-form-label col-lg-2"><span class="text-danger">*</span>تلفن همراه</label>
                        <div class="col-lg-4">
                            <input type="text" class="validate mobileValidation form-control"
                            name="telephone_hamrah"
                            id="telephone_hamrah"
                            pattern="^09\d{9}$"
                            autocomplete="off"
                            maxlength="11" minlength="11"
                            placeholder="مثال: 0912123456789"
                            required>
                        </div>
                        <label class="col-form-label col-lg-2"><span class="text-danger">*</span>شماره تماس محل سکونت</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control"
                            name="telephone_mahale_sokonat"
                            id="telephone_mahale_sokonat"
                            maxlength="11"
                            autocomplete="off"
                            placeholder="مثال: 021123456789"
                            >
                        </div>

                        <label class="col-form-label col-lg-2"><span class="text-danger">*</span>آدرس محل سکونت</label>
                        <div class="col-lg-10">
                            <input type="text" class="validate langFa form-control"
                            name="address"
                            id="address"
                            maxlength="250"
                            placeholder="مثال: تهران خیابان شریعتی کوچه ..."
                            autocomplete="off"
                            required>
                        </div>

                        <label class="col-form-label col-lg-2">پست الکترونیک</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control"
                            name="email"
                            id="email"
                            autocomplete="off"
                            maxlength="100"
                            placeholder="مثال: abcd@gmail.com">
                        </div>

                        <label class="col-form-label col-lg-2" ><span class="text-danger">*</span>سمت</label>
                        <div class="col-lg-10">
                            <select class="form-control form-control-lg custom-select" name="level_id" id="level_id" required>

                            </select>
                        </div>

                       <label class="col-form-label col-lg-2"><span class="text-danger">*</span>نام کاربری</label>
                       <div class="col-lg-4">
                           <input type="text" class="validate langEn form-control" name="username" id="username"
                           minlength="4"
                           maxlength="30"
                           placeholder="حداقل شامل 4 کاراکتر"
                           required>
                       </div>

                       <label class="col-form-label col-lg-2"><span class="text-danger">*</span>رمز عبور</label>
                       <div class="col-lg-4">
                            <input type="text"
                            class="validate langEn form-control"
                            id="password"
                            name="password"
                            minlength="4"
                            maxlength="80"
                            placeholder="حداقل شامل 4 کاراکتر"
                            required>
                       </div>

                        <label class="col-form-label col-lg-2">تصویر کارت ملی</label>
                        <div for="" class="col-lg-4">
                            <input type="file" class="form-control-uniform" maxlength="100" id="t_karte_meli" name="t_karte_meli" placeholder="نام فایل باید کمتر از 100 کاراکتر باشد">
                        </div>

                        <label class="col-form-label col-lg-2">تصویر شناسنامه</label>
                        <div class="col-lg-4">
                            <input type="file" class="form-control-uniform" maxlength="100"  name="t_shenasname" id="t_shenasname">
                        </div>

                        <label class="col-form-label col-lg-2">تصویر مدرک نحصیلی</label>
                        <div class="col-lg-4">
                            <input type="file" class="form-control-uniform" maxlength="100" name="t_madrake_tahsili" id="t_madrake_tahsili" data-fouc>
                        </div>

                        <label class="col-form-label col-lg-2">تصویر چهره</label>
                        <div class="col-lg-4">
                            <input type="file" class="form-control-uniform" maxlength="100" name="t_chehre" id="t_chehre" data-fouc>
                        </div>
                    </div>
                </fieldset>
                <div class="text-right">
                    <button type="submit" name="send_operator" class="btn btn-primary">ارسال <i class="icon-paperplane ml-2"></i></button>
                </div>
            </form>
        </div>
    </div>
    <!-- /form inputs -->
    <div class="card">
        <div class="col-md-12">
            <button name="delete" class="btn btn-warning col-md-auto float-md-right"  id="delete">حذف<i class="icon-folder-remove ml-2"></i></button>
            <button name="edit" class="btn btn-primary col-md-auto float-md-right" id="edit">ویرایش<i class="icon-database-edit2 ml-2"></i></button>
            <table id="view_table" class="table table-striped datatable-responsive table-hover">
            </table>
        </div>
    </div>
</div>
<!-- /content area -->
