<!-- Content area -->
<div class="content">
        <!-- users table/-->
    <div class="card">
        <div class="col-md-12">
            <button name="initconfirm" class="btn btn-primary col-md-auto float-md-right" id="initconfirm">جستجو<i
                        class="icon-database-edit2 ml-2"></i></button>
            <table id="view_table" class="table table-striped datatable-responsive table-hover">
            </table>
        </div>
    </div>
    <!-- Form inputs -->
    <div class="card" id="change_password_form">
        <div class="card-body">
            <form action="#" method="POST">
                <input type="hidden" id="userid" name="userid">
                <fieldset class="mb-3">
                    <legend class="text-uppercase font-size-sm font-weight-bold">تغییر رمز عبور سامانه</legend>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">رمز عبور جدید</label>
                        <div class="col-lg-4">
                            <input type="text" id="new_password" name="new_password" class="form-control"  placeholder="">
                        </div>
                        <label class="col-form-label col-lg-2">تکرار رمز</label>
                        <div class="col-lg-4">
                            <input type="text" id="new_password_confirm" name="new_password_confirm" class="form-control"  placeholder="">
                            
                        </div>
                    </div>
                </fieldset>
                <div class="text-right">
                    <button type="submit" name="send_administration_change_system_password" id="send_change_system_password" class="btn btn-primary">ارسال <i class="icon-paperplane ml-2"></i></button>
                </div>
            </form>
        </div>
    </div>
    <!-- /form inputs -->
</div>
<!-- /content area -->




<!-- /main content -->