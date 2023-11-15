        <!-- Content area -->
        <div class="content">

            <!-- Form inputs -->
            <div class="card">
                <div class="card-body">
                    <form action="#" method="POST">
                        <fieldset class="mb-3">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">نوع جستجو</label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom_select" name="lookingfor"
                                        id="lookingfor">
                                        <option value="moshtarak">مشترک</option>
                                        <option value="namayande">نماینده</option>
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                    <div class="col-sm-12" id="init_search_table_div">

                    </div>
                </div>
            </div>
            <div class="card" id="credits_tabs">
                <div class="card-body">
                    <legend class="text-uppercase font-size-sm font-weight-bold"></legend>
                    <ul class="nav nav-tabs nav-tabs-bottom border-bottom-0 nav-justified">
                        <li class="nav-item services_tabs"><a href="#bottom-justified-divided-tab1"
                                class="nav-link active" data-toggle="tab">تغییر اعتبار</a></li>
                        <li class="nav-item services_tabs"><a href="#bottom-justified-divided-tab2" class="nav-link"
                                data-toggle="tab">مشاهده اطلاعات</a></li>
                    </ul>
                    <div class="tab-content">
                        <!------------taghire_etebar------------->
                        <div class="tab-pane fade show active" id="bottom-justified-divided-tab1">
                            <form action="#" method="POST" name="taghire_etebar_form">
                                <fieldset class="mb-3">
                                    <div class="form-group row">
                                        <input type="hidden" name="last_row_id" id="last_row_id" value="empty">
                                        <input type="hidden" name="user_id" id="user_id" value="empty">
                                        <input type="hidden" name="noe_user" id="noe_user" value="empty">
                                        <label class="col-form-label col-lg-2">نام نماینده / شرکت</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="user_or_branch_name"
                                                id="user_or_branch_name" readonly>
                                        </div>
                                        
                                        <label class="col-form-label col-lg-2">اعتبار فعلی</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="current_credit"
                                                id="current_credit" readonly>
                                        </div>
                                        
                                        <label class="col-form-label col-lg-2">میزان افزایش / کاهش اعتبار</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="change_amount"
                                                id="change_amount" required>
                                        </div>
                                        <label class="col-form-label col-lg-2">نوع تغییر اعتبار</label>
                                        <div class="col-lg-4">
                                            <select class="form-control form-control-lg custom_select" name="noe_taghire_etebat"
                                                id="noe_taghire_etebat" required>
                                                <option value="" selected disabled hidden>یک مورد را انتخاب کنید</option>
                                                <option value="afzayesh">افزایش</option>
                                                <option value="kahesh">کاهش</option>
                                            </select>
                                        </div>
                                        <label class="col-form-label col-md-2">توضیحات</label>
                                        <div class="col-md-10">
                                            <textarea rows="3" cols="3" id="tozihat" name="tozihat" class="form-control"
                                                placeholder="حداکثر ۲۰۰ حرف قابل نوشتن است"></textarea>
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="text-right">
                                    <button type="submit" name="send_taghire_etebar" id="send_taghire_etebar" class="btn btn-primary">ارسال <i class="icon-paperplane ml-2"></i></button>
                                </div>
                            </form>
                            
                        </div>
                        <!------------namayeshe etelaat------------->
                        <div class="tab-pane fade" id="bottom-justified-divided-tab2">
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-md-12">
                                        <table id="view_table_display"
                                            class="table table-striped datatable-responsive table-hover"></table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /form inputs -->

        </div>
        <!-- /content area -->