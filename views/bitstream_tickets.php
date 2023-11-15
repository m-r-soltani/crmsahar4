        <!-- Content area -->
        <div class="content">
            <!-- Form inputs -->
            <div class="card">
                <div class="card-body">


                    <legend class="text-uppercase font-size-sm font-weight-bold">آسیاتک بیت استریم</legend>
                    <ul class="nav nav-tabs nav-tabs-bottom border-bottom-0 nav-justified">

                        <li class="nav-item services_tabs" id='newtickettablink'>
                            <a href="#newticket" class="nav-link active" data-toggle="tab">تیکت جدید</a>
                        </li>


                        <li class="nav-item services_tabs" id='previewtablink'>
                            <a href="#previewticket" class="nav-link" data-toggle="tab">مشاهده تیکت ها</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <!------------new ticket------------->
                        <div class="tab-pane fade show active" id="newticket">
                            <form action="#" method="POST" name="beforeportform">
                                <fieldset class="mb-3">
                                    <div class="form-group row">
                                        <label class="col-form-label col-sm-2">مشترک<span class="text-danger">*</span> </label>
                                        <div class="col-sm-10">
                                            <select class="form-control form-control-lg custom_select" name="sub" id="new_sub" required>
                                                <option disabled selected> -- یک مورد را انتخاب کنید -- </option>
                                            </select>
                                        </div>
                                        <label class="col-form-label col-sm-2">اولویت<span class="text-danger">*</span> </label>
                                        <div class="col-sm-4">
                                            <select class="form-control form-control-lg custom_select" name="olaviat" id="new_olaviat" required>
                                                <option disabled selected> -- یک مورد را انتخاب کنید -- </option>
                                                <option value="1">پایین</option>
                                                <option value="2">معمولی</option>
                                                <option value="3">بالا</option>
                                                <option value="4">خیلی بالا</option>
                                                <option value="5">بحرانی</option>
                                            </select>
                                        </div>

                                        <label class="col-form-label col-sm-2">طبقه تیکت <span class="text-danger">*</span></label>
                                        <div class="col-sm-4">
                                            <select class="form-control form-control-lg custom_select" name="tabaghe" id="new_tabaghe" required>
                                                <option disabled selected> -- یک مورد را انتخاب کنید -- </option>
                                                <option value="707">پشتیبانی</option>
                                                <option value="754">رفع خرابی حضوری</option>
                                                <option value="755">نصب حضوری</option>
                                            </select>
                                        </div>

                                        <label class="col-form-label col-sm-2">عنوان تیکت <span class="text-danger">*</span></label>
                                        <div class="col-sm-10">

                                            <!-- <input class="form-control" rows="18" name="onvan" id="newonvan" type="text" required> -->
                                            <textarea rows="2" cols="4" class="form-control form-control-sm" name="onvan" id="new_onvan" required> </textarea>
                                        </div>

                                        <label class="col-form-label col-sm-2">توضیحات تیکت <span class="text-danger">*</span></label>
                                        <div class="col-sm-10" style="margin-top:2px;">
                                            <textarea rows="18" cols="4" class="form-control form-control-sm" name="description" id="new_description" required> </textarea>
                                        </div>

                                    </div>
                                </fieldset>
                                <div class="text-right">
                                    <button type="submit" name="send_asiatechbs_newticket" class="btn btn-primary">ارسال <i class="icon-paperplane ml-2"></i></button>
                                </div>
                            </form>
                        </div>

                        <!------------Preview------------->
                        <div class="tab-pane fade" id="previewticket">
                            <form action="#" method="POST" name="previewticket">
                                <fieldset class="mb-3">
                                    <div class="form-group row">
                                        <label class="col-form-label col-sm-2">تیکت های باز</label>
                                        <div class="col-sm-10">
                                            <select class="form-control form-control-lg custom_select" name="opentickets" id="opentickets" required>
                                                <option disabled selected> -- یک مورد را انتخاب کنید -- </option>
                                            </select>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>


                    </div>


                    <!-- <div id="modal_form_newticket" class="modal fade" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <h5 class="modal-title">ایجاد تیکت جدید</h5>
                                    <button type="button" class="close" data-dismiss="modal"
                                            style="font-size: 24px !important;">&#215
                                    </button>
                                </div>
                                <form action="#" method="POST">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-form-label col-sm-2" >عنوان تیکت</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" name="title" id="newti_title" type="text" required>
                                                </div>

                                                <label class="col-form-label col-sm-2" >هدف تیکت</label>
                                                <div class="col-sm-12">
                                                    <select class="form-control form-control-lg custom_select" name="maintype" id="newti_maintype" required>
                                                        <option value="port">پورت (چنانچه رزرو یا اختصاص پورت صورت گرفته است)</option>
                                                        <option value="subscriber">مشترک (اگر رزرو یا اختصاص پورت انجام نشده است)</option>
                                                    </select>
                                                </div>
                                                
                                                <label class="col-form-label col-sm-2" >انتخاب هدف تیکت</label>
                                                <div class="col-sm-12">
                                                    <select class="form-control form-control-lg custom_select" name="maintypeid" id="newti_maintypeid">
                                                        
                                                    </select>
                                                </div>

                                                <label class="col-form-label col-sm-2" >اولویت</label>
                                                <div class="col-sm-12">
                                                    <select class="form-control form-control-lg custom_select" name="priority" id="newti_priority" required>
                                                        <option value="1">پایین</option>
                                                        <option value="2">معمولی</option>
                                                        <option value="3">بالا</option>
                                                        <option value="4">خیلی بالا</option>
                                                        <option value="5">بحرانی</option>
                                                    </select>
                                                </div>
                                                                                       
                                                <label class="col-form-label col-sm-2" >طبقه تیکت</label>
                                                <div class="col-sm-12">
                                                    <select class="form-control form-control-lg custom_select" name="ttypeid" id="newti_ttypeid" required>
                                                        <option value="707">پشتیبانی</option>
                                                        <option value="754">رفع خرابی حضوری</option>
                                                        <option value="755">نصب حضوری</option>
                                                    </select>
                                                </div>

                                                <label class="col-form-label col-sm-2" >توضیحات تیکت</label>
                                                <div class="col-sm-12">
                                                    <textarea rows="15" cols="4" class="form-control form-control-sm" name="description" id="newti_description" required> </textarea>
                                                </div>
                                            </div>
                                        </div>    
                                    </div>
                                    <hr>
                                    <div class="modal-footer text-right">
                                        <button type="button" class="btn bg-danger" data-dismiss="modal">بستن</button>
                                        <button type="submit" name="send_new_ticket" id="send_new_ticket" class="btn bg-primary">ارسال</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div> -->
                    <!--tickets_preview-->

                    <div id="modal_ticketspreview" class="modal fade" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <h5 class="modal-title">جریان تیکت</h5>
                                    <button type="button" class="close" data-dismiss="modal" style="font-size: 24px !important;">&#215
                                    </button>
                                </div>
                                <div id= 'tickethistory'>
                                    <!-- <div class="col-xs-12">
                                        <div class="label-block text-right">
                                            <span class="label bg-info" style="padding: 10px; border-radius:3px">right aligned label</span>
                                        </div>
                                    </div>
                                    <div class="col-xs-12">
                                        <div class="label-block text-left">
                                            <span class="label bg-info text-left" style="padding: 10px; border-radius:100px">left afgjhghjghjghjghjghjghjghjghjghjghjghjghjghligned label</span>
                                        </div>
                                    </div> -->
                                </div>
                                <form action="#" method="POST">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <div class="row">
                                                <input class="form-control" name="tiid" id="newc_tiid" type="hidden" required>
                                                    <label class="col-form-label col-sm-2">درج کامنت</label>
                                                    <div class="col-sm-12">
                                                        <textarea rows="5" cols="4" class="form-control form-control-sm" name="comment" id="comment" required> </textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="modal-footer text-right">
                                            <button type="button" class="btn bg-danger" data-dismiss="modal">بستن</button>
                                            <button type="submit" name="AsiatechBitstreamNewComment" id="AsiatechBitstreamNewComment" class="btn bg-primary">ارسال</button>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /form inputs -->

        </div>
        <!-- /content area -->