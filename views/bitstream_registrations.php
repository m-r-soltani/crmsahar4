        <!-- Content area -->
        <div class="content">

            <!-- Form inputs -->
            <div class="card">
                <div class="card-body">
                    <legend class="text-uppercase font-size-sm font-weight-bold">آسیاتک بیت استریم</legend>
                    <ul class="nav nav-tabs nav-tabs-bottom border-bottom-0 nav-justified">
                        <li class="nav-item services_tabs"><a href="#bottom-justified-divided-tab1" class="nav-link active"
                                                              data-toggle="tab">امکان سنجی ارائه سرویس</a></li>

                        <li class="nav-item services_tabs"><a href="#bottom-justified-divided-tab2" class="nav-link"
                                                              data-toggle="tab">ساخت مشترک در OSS</a></li>

                        <li class="nav-item services_tabs"><a href="#bottom-justified-divided-tab3" class="nav-link"
                                                              data-toggle="tab">رزرو منابع</a></li>
                        <li class="nav-item services_tabs"><a href="#bottom-justified-divided-tab4" class="nav-link"
                                                              data-toggle="tab">لغو درخواست رزرو</a></li>

                        <li class="nav-item services_tabs"><a href="#bottom-justified-divided-tab5" class="nav-link"
                                                              data-toggle="tab">دریافت وضعیت درخواست رزرو</a></li>
                    </ul>
                    <div class="tab-content">
                        <!------------eses------------->
                        <div class="tab-pane fade show active" id="bottom-justified-divided-tab1">
                            <form action="#" method="POST" name="eses_form">
                                <fieldset class="mb-3">
                                    <div class="group-row row">
                                        <label class="col-form-label col-md-2" >نوع سرویس</label>
                                        <div class="col-md-4">
                                            <select class="form-control form-control-lg custom-select" 
                                            name="eses_noe_service" id="eses_noe_service" required>
                                                <option value="1">ADSL</option>
                                                <option value="2">VDSL</option>
                                            </select>
                                        </div>
                                        <label class="col-form-label col-md-2" >بررسی دایری از دیگر شرکت ها</label>
                                        <div class="col-md-4">
                                            <select class="form-control form-control-lg custom-select" 
                                            name="eses_checkotherpap" id="eses_checkotherpap" required>
                                                <option value="1">بله</option>
                                                <option value="2">خیر</option>
                                            </select>
                                        </div>
                                        <!-- <label class="col-form-label col-md-2" >مرکز مخابراتی</label>
                                        <div class="col-md-4">
                                            <select class="form-control form-control-lg custom-select" 
                                            name="eses_markaze_mokhaberati" id="eses_markaze_mokhaberati" required>
                                            </select>
                                        </div> -->
                                        <label class="col-form-label col-md-2">شماره تلفن</label>
                                            <div class="col-md-4">
                                                <input type="text" 
                                                id="eses_telephone" name="eses_telephone" class="form-control" minlength="11" maxlength="11" 
                                                placeholder="شماره تلفن 11 رقمی" required>
                                            </div>
                                    </div>
                                </fieldset>
                                <div class="text-right">
                                    <button type="submit" name="send_bitstream_eses" id="send_bitstream_eses" class="btn btn-primary submitbutton">ارسال <i
                                                class="icon-paperplane ml-2"></i></button>
                                </div>
                            </form>
                        </div>
                        <!------------/eses------------->
                        <!------------smdoss------------->
                        <div class="tab-pane fade" id="bottom-justified-divided-tab2">
                            <form action="#" method="POST" name="smdoss_form">
                                <fieldset class="mb-3">
                                    <div class="group-row row">
                                        <label class="col-form-label col-md-2">انتخاب مشترک</label>
                                        <div class="col-md-4">
                                            <select class="form-control form-control-lg custom-select" 
                                            name="smdoss_moshtarak_id" id="smdoss_moshtarak_id" required>
                                            </select>
                                        </div>        
                                        <label class="col-form-label col-md-2">انتخاب تلفن مشترک</label>
                                        <div class="col-md-4">
                                            <select class="form-control form-control-lg custom-select" 
                                                name="smdoss_telephone" id="smdoss_telephone" required>
                                            </select>
                                        </div>        
                                    </div>
                                </fieldset>
                                <div class="text-right">
                                    <button type="submit" name="send_bitstream_smdoss" class="btn btn-primary">ارسال <i
                                                class="icon-paperplane ml-2"></i></button>
                                </div>
                            </form>
                        </div>
                        <!------------/smdoss------------->
                        <!------------rm------------->
                        <div class="tab-pane fade" id="bottom-justified-divided-tab3">
                            <form action="#" method="POST" name="rm_form">
                                <fieldset class="mb-3">
                                    <div class="group-row row">
                                        <!-- <label class="col-form-label col-md-2" >مرکز مخابراتی</label>
                                        <div class="col-md-4">
                                            <select class="form-control form-control-lg custom-select" 
                                            name="rm_markaze_mokhaberati" id="rm_markaze_mokhaberati" required>
                                            </select>
                                        </div> -->
                                        <label class="col-form-label col-md-2">انتخاب مشترک</label>
                                        <div class="col-md-4">
                                            <select class="form-control form-control-lg custom-select" 
                                            name="rm_oss_registred_id" id="rm_oss_registred_id" required>
                                            </select>
                                        </div>        
                                        <label class="col-form-label col-md-2">انتخاب تلفن مشترک</label>
                                        <div class="col-md-4">
                                            <select class="form-control form-control-lg custom-select" 
                                                name="rm_telephone" id="rm_telephone" required>
                                            </select>
                                        </div>  
                                        <label class="col-form-label col-md-2">نوع درخواست رزرو</label>
                                        <div class="col-md-4">
                                            <select class="form-control form-control-lg custom-select" 
                                                name="rm_reserve_type" id="rm_reserve_type" required>
                                                <option value="1">ADSL</option>
                                                <option value="2">VDSL</option>
                                            </select>
                                        </div>
                                        <label class="col-form-label col-md-2">مدت زمان رزرو</label>
                                        <div class="col-md-4">
                                            <select class="form-control form-control-lg custom-select" 
                                                name="rm_reserve_time" id="rm_reserve_time" required>
                                                <option value="48">48 ساعت</option>
                                                <option value="72">72 ساعت</option>
                                                
                                            </select>
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="text-right">
                                    <button type="submit" name="send_bitstream_rm" class="btn btn-primary">ارسال <i
                                                class="icon-paperplane ml-2"></i></button>
                                </div>
                            </form>
                        </div>
                        <!------------/rm------------->
                        <!------------ldr------------->
                        <div class="tab-pane fade" id="bottom-justified-divided-tab4">
                            <form action="#" method="POST" name="ldr_form">
                                <fieldset class="mb-3">
                                    <label class="col-form-label col-md-2" >انتخاب درخواست رزرو</label>
                                    <div class="col-md-4">
                                        <select class="form-control form-control-lg custom-select" 
                                        name="ldr_res_id" id="ldr_res_id" required>
                                        </select>
                                    </div>
                                </fieldset>
                                <div class="text-right">
                                    <button type="submit" name="send_bitstream_ldr" class="btn btn-primary">ارسال <i
                                                class="icon-paperplane ml-2"></i></button>
                                </div>
                            </form>
                        </div>
                        <!------------/ldr------------->
                        <!------------dvdr------------->
                        <div class="tab-pane fade" id="bottom-justified-divided-tab5">
                            <form action="#" method="POST" name="dvdr_form">
                                <fieldset class="mb-3">
                                    <label class="col-form-label col-md-2" >انتخاب درخواست رزرو</label>
                                    <div class="col-md-4">
                                        <select class="form-control form-control-lg custom-select" 
                                        name="dvdr_reserve_id" id="dvdr_reserve_id" required>
                                        </select>
                                    </div>
                                </fieldset>
                                <div class="text-right">
                                    <button type="submit" name="send_bitstream_dvdr" class="btn btn-primary">ارسال <i
                                                class="icon-paperplane ml-2"></i></button>
                                </div>
                            </form>
                        </div>
                        <!------------/dvdr------------->
                    </div>
                </div>
            </div>
            <!-- /form inputs -->

        </div>
        <!-- /content area -->
