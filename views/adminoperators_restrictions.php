<!-- Content area -->
<div class="content">
    <!-- Form inputs -->
    <div class="card">
        <div class="card-body">
            <legend class="text-uppercase font-size-sm font-weight-bold">اپراتورهای پنل</legend>
            <ul class="nav nav-tabs nav-tabs-bottom border-bottom-0 nav-justified">
                <li class="nav-item services_tabs"><a href="#bottom-justified-divided-tab1" class="nav-link " data-toggle="tab">ساختن اپراتور</a></li>
                <li class="nav-item services_tabs"><a href="#bottom-justified-divided-tab2" class="nav-link active" data-toggle="tab">ویرایش دسترسی ها</a></li>
                <li class="nav-item services_tabs"><a href="#bottom-justified-divided-tab3" class="nav-link" data-toggle="tab">حذف/فعال و غیرفعال کردن</a></li>
            </ul>
            <div class="tab-content">
                <!------------Create------------->
                <div class="bs_tab tab-pane" id="bottom-justified-divided-tab1">
                    <form action="#" method="POST">
                        <fieldset class="mb-3">
                            <div class="form-group row">
                                <label class="col-form-label col-md-2">نام<span class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="name" placeholder="" id="c_name" required>
                                </div>
                                <label class="col-form-label col-md-2">نام خانوادگی<span class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="name_khanevadegi" placeholder="" id="c_name_khanevadegi">
                                </div>
                                <label class="col-form-label col-md-2">سمت<span class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="semat" placeholder="" id="c_semat">
                                </div>
                                <label class="col-form-label col-md-2">موبایل<span class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="mobile" placeholder="" id="c_mobile" required>
                                </div>
                                <label class="col-form-label col-md-2">نام کاربری<span class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="username" placeholder="" id="c_username">
                                </div>
                                <label class="col-form-label col-md-2">رمز عبور<span class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="password" placeholder="" id="c_password">
                                </div>
                            </div>
                        </fieldset>
                        <div class="text-right">
                            <button type="submit" name="send_adminoprator_create" class="btn btn-primary">ارسال <i class="icon-paperplane ml-2"></i></button>
                        </div>
                    </form>
                </div>
                <!------------restrictions------------->
                <div class="adsl_tab tab-pane show active" id="bottom-justified-divided-tab2">
                    <form action="#" method="POST">
                        <fieldset class="mb-3">
                            <div class="form-group row">
                                <label class="col-form-label col-md-2">اپراتور</label>
                                <div class="col-md-10">
                                    <select class="form-control form-control-md custom-select" name="operator" id="vd_operator" required>
                                        <option value="" selected disabled>یک مورد را انتخاب کنید</option>
                                    </select>
                                </div>
                                <label class="col-form-label col-md-2">صفحات</label>
                                <div class="col-md-10">
                                    <select class="form-control form-control-lg" name="menu[]" multiple="multiple" id="vd_menu" style="margin:15px !important;" data-placeholder="انتخاب کنید" required>
                                    </select>
                                </div>
                                <label class="col-form-label col-md-2">اجازه ثبت</label>
                                <div class="col-md-10">
                                    <select class="form-control form-control-lg" name="add[]" multiple="multiple" id="vd_add" data-placeholder="انتخاب کنید">
                                    </select>
                                </div>
                                <label class="col-form-label col-md-2">اجازه ویرایش</label>
                                <div class="col-md-10">
                                    <select class="form-control form-control-lg" name="edit[]" multiple="multiple" id="vd_edit" data-placeholder="انتخاب کنید" >
                                    </select>
                                </div>
                                <label class="col-form-label col-md-2">اجازه حذف</label>
                                <div class="col-md-10">
                                    <select class="form-control form-control-lg" name="delete[]" multiple="multiple" id="vd_delete" data-placeholder="انتخاب کنید">
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                        <div class="text-right">
                            <button type="submit" name="send_adminoperator_restrictions" class="btn btn-primary">ثبت<i class="icon-pen ml-2"></i></button>
                        </div>
                    </form>
                </div>
                <!------------operation------------->
                <div class="adsl_tab tab-pane fade" id="bottom-justified-divided-tab3">
                    <form action="#" method="POST">
                        <fieldset class="mb-3">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">اپراتور</label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom-select" name="operator" id="ded_operator" required>
                                        <option value="" selected disabled>یک مورد را انتخاب کنید</option>
                                    </select>
                                </div>
                                <label class="col-form-label col-lg-2">درخواست</label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom-select" name="operation" id="ded_operation" required>
                                        <option value="" selected disabled>یک مورد را انتخاب کنید</option>
                                        <option value="1">فعال کردن</option>
                                        <option value="2">غیر فعال</option>
                                        <option value="3">حذف اپراتور</option>
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                        <div class="text-right">
                            <button type="submit" name="send_adminoperator_operation" class="btn btn-warning">ارسال<i class="icon-pen ml-2"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>