
<!-- Content area -->
<div class="content">
    <!-- Form inputs -->
    <div class="card">
        <div class="card-body">
            <form action="#" method="POST">
                <fieldset class="mb-3">
                    <legend class="text-uppercase font-size-sm font-weight-bold">اختصاص دسترسی کلی </legend>
                    
                    <div class="form-group row">
                        <input type="hidden" id="id" class="form-control" name="id" value="empty">
                        <label class="col-form-label col-lg-2" >گروه کاربری</label>
                        <div class="col-lg-4">
                            <select class="form-control form-control-lg custom-select" name="user_type" id="user_type" required>
                                <option value="1">ادمین</option>
                                <option value="4">اپراتور ادمین</option>
                                <option value="2">نمایندگی سطح 1</option>
                                <option value="3">نمایندگی سطح 2</option>
                                <option value="5">مشنرکین</option>
                            </select>
                        </div>
                        <div class="col-lg-12"></div>
                        <label class="col-form-label col-lg-2" >انتخاب منو</label>
                        <div class="col-lg-10">
                            <select class="form-control form-control-lg custom_select" name="dashboard_menu[]" id="dashboard_menu" multiple required>
                            </select>
                        </div>
                        
                    </div>
                </fieldset>
                <div class="text-right">
                    <button type="submit" name="send_dashboard_menu_group_access" class="btn btn-primary">ارسال <i class="icon-paperplane ml-2"></i></button>
                </div>
            </form>
        </div>
    </div>
    <!-- /form inputs -->
    <!--datatable-->

    <!--/datatable-->

</div>
<!-- /content area -->




<!-- /main content -->