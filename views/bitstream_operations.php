        <!-- Content area -->
        <div class="content">
            <!-- Form inputs -->
            <div class="card">
                <div class="card-body">
                    <legend class="text-uppercase font-size-sm font-weight-bold">آسیاتک بیت استریم</legend>
                    <ul class="nav nav-tabs nav-tabs-bottom border-bottom-0 nav-justified">

                        <li class="nav-item services_tabs"><a href="#bottom-justified-divided-tab1" class="nav-link active"
                                                              data-toggle="tab">اصلاح اطلاعات درخواست رزرو</a></li>

                        <li class="nav-item services_tabs"><a href="#bottom-justified-divided-tab2" class="nav-link"
                                                              data-toggle="tab">جمع آوری منابع</a></li>

                        <li class="nav-item services_tabs"><a href="#bottom-justified-divided-tab3" class="nav-link"
                                                              data-toggle="tab">دریافت شناسه مشترک در OSS</a></li>

                        <li class="nav-item services_tabs"><a href="#bottom-justified-divided-tab4" class="nav-link"
                                                              data-toggle="tab">ارسال مجدد رانژه به مخابرات</a></li>

                        <li class="nav-item services_tabs"><a href="#bottom-justified-divided-tab5" class="nav-link"
                                                              data-toggle="tab">اعلام نیاز به تعویض پورت</a></li>

                        <li class="nav-item services_tabs"><a href="#bottom-justified-divided-tab6" class="nav-link"
                                                              data-toggle="tab">دریافت اطلاعات vpi-vci-vlan پورت</a></li>

                        
                    </ul>
                    <div class="tab-content">
                        <!------------edr------------->
                        <div class="tab-pane fade show active" id="bottom-justified-divided-tab1">
                            <form action="#" method="POST" name="edr_form">
                                <fieldset class="mb-3">
                                    <label class="col-form-label col-md-2" >انتخاب درخواست رزرو</label>
                                    <div class="col-md-6">
                                        <select class="form-control form-control-lg custom_select" 
                                        name="edr_reserve_id" id="edr_reserve_id" required>
                                        </select>
                                    </div>
                                </fieldset>
                                <div class="text-right">
                                    <button type="submit" name="send_bitstream_edr" class="btn btn-primary">ارسال <i
                                                class="icon-paperplane ml-2"></i></button>
                                </div>
                            </form>
                        </div>
                        <!------------/edr------------->
                        <!------------jm------------->
                        <div class="tab-pane fade" id="bottom-justified-divided-tab2">
                            <form action="#" method="POST" name="jm_form">
                                <fieldset class="mb-3">
                                    
                                        <label class="col-form-label col-md-2">انتخاب مشترک</label>
                                        <div class="col-md-6">
                                            <select class="form-control form-control-lg custom_select" 
                                                name="jm_userservice" id="jm_userservice" required>
                                            </select>
                                        </div>
                                    
                                </fieldset>
                                <div class="text-right">
                                    <button type="submit" name="send_bitstream_jm" class="btn btn-primary">ارسال <i
                                                class="icon-paperplane ml-2"></i></button>
                                </div>
                            </form>
                        </div>
                        <!------------/jm------------->
                        <!------------dsmdoss------------->
                        <div class="tab-pane fade" id="bottom-justified-divided-tab3">
                            <form action="#" method="POST" name="dsmdoss_form">
                                <fieldset class="mb-3">
                                    <label class="col-form-label col-md-2" >انتخاب کاربر</label>
                                    <div class="col-md-6">
                                        <select class="form-control form-control-lg custom_select" 
                                        name="dsmdoss_oss_id" id="dsmdoss_oss_id" required>
                                        </select>
                                    </div>
                                </fieldset>
                                <div class="text-right">
                                    <button type="submit" name="send_bitstream_dsmdoss" class="btn btn-primary">ارسال <i
                                                class="icon-paperplane ml-2"></i></button>
                                </div>
                            </form>
                        </div>
                        <!------------emdrbm------------->
                        <div class="tab-pane fade" id="bottom-justified-divided-tab4">
                            <form action="#" method="POST" name="emdrbm_form">
                                <fieldset class="mb-3">
                                    <label class="col-form-label col-md-2" >انتخاب کاربر</label>
                                    <div class="col-md-6">
                                        <select class="form-control form-control-lg custom_select" 
                                        name="emdrbm_res_id" id="emdrbm_res_id" required>
                                        </select>
                                    </div>
                                </fieldset>
                                <div class="text-right">
                                    <button type="submit" name="send_bitstream_emdrbm" class="btn btn-primary">ارسال <i
                                                class="icon-paperplane ml-2"></i></button>
                                </div>
                            </form>
                        </div>
                        <!------------enbtp------------->
                        <div class="tab-pane fade" id="bottom-justified-divided-tab5">
                            <form action="#" method="POST" name="enbtp_form">
                                <fieldset class="mb-3">
                                    <label class="col-form-label col-md-2" >انتخاب کاربر</label>
                                    <div class="col-md-6">
                                        <select class="form-control form-control-lg custom_select" 
                                        name="enbtp_res_id" id="enbtp_res_id" required>
                                        </select>
                                    </div>
                                </fieldset>
                                <div class="text-right">
                                    <button type="submit" name="send_bitstream_enbtp" class="btn btn-primary">ارسال <i
                                                class="icon-paperplane ml-2"></i></button>
                                </div>
                            </form>
                        </div>
                        
                        <!------------devvv------------->
                        <div class="tab-pane fade" id="bottom-justified-divided-tab6">
                            <form action="#" method="POST" name="devvv_form">
                                <fieldset class="mb-3">
                                    <label class="col-form-label col-md-2" >انتخاب کاربر</label>
                                    <div class="col-md-6">
                                        <select class="form-control form-control-lg custom_select" 
                                        name="devvv_res_id" id="devvv_res_id" required>
                                        <option value="" selected disabled>یک مورد را انتخاب کنید</option>
                                        </select>
                                    </div>
                                </fieldset>
                                <!-- <div class="text-right">
                                    <button type="submit" name="send_bitstream_devvv" class="btn btn-primary">ارسال <i
                                                class="icon-paperplane ml-2"></i></button>
                                </div> -->
                            </form>
                        </div>
                        
                    </div>



                </div>
            </div>
            <!-- /form inputs -->

        </div>
        <!-- /content area -->
