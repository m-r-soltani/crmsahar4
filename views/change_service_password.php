<!-- Content area -->
<div class="content">
    <!-- Form inputs -->
    <div class="card" id="formdiv">
            <div class="card-body">
                <form action="#" method="POST">
                    <fieldset class="mb-3">
                        <legend class="text-uppercase font-size-sm font-weight-bold">تغییر رمز سرویس</legend>
                        <div class="form-group row">
                            <label class="col-form-label col-md-2">انتخاب سرویس مشترک</label>
                            <div class="col-md-10">
                                <select class="form-control form-control-md custom_select" required name="service" id="service">
                                    <option value="" selected disabled hidden>یک مورد را انتخاب کنید</option>
                                </select>
                            </div>
                            <label class="col-form-label col-md-2">رمز فعلی</label>
                            <div class="col-md-10">
                                <input type="text" readonly name="currentpassword" id="currentpassword" class="form-control" required >
                            </div>
                            <label class="col-form-label col-md-2">رمز جدید</label>
                            <div class="col-md-10">
                                <input type="text" name="newpassword" id="newpassword" class="form-control" required>
                            </div>
                    </fieldset>
                    <div class="text-right">
                        <button type="submit" name="send_change_service_password" id="send_change_service_password" class="btn btn-primary">ارسال <i class="icon-paperplane ml-2"></i></button>
                    </div>
            </form>
        </div>
    </div>
</div>
<!-- /content area -->




<!-- /main content -->