<!-- Content area -->
<div class="content">
    <!-- Form inputs -->
    <div class="card">
        <div class="card-body">
            <form action="#" method="POST">
                <fieldset class="mb-3">
                    <legend class="text-uppercase font-size-sm font-weight-bold">ارسال پیام</legend>
                    <div class="form-group row" id = "form_sms_div">
                        <label class="col-form-label col-lg-2">تاریخ شروع ارسال</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" required name="start_date" id="start_date" placeholder="">
                        </div>
                        <label class="col-form-label col-lg-2">تاریخ پایان ارسال</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" required name="end_date" id="end_date" placeholder="">
                        </div>
                        <label class="col-form-label col-lg-2">ارسال به</label>
                        <div class="col-lg-4">
                            <select class="form-control form-control-lg custom_select" required name="send_to" id="send_to">

                            </select>
                        </div>
                    </div>
                </fieldset>
                <div class="text-right">
                    <button type="submit" name="send_sms_form" class="btn btn-primary">ارسال <i class="icon-paperplane ml-2"></i></button>
                </div>
            </form>
        </div>
    </div>
    <!-- /form inputs -->
</div>
<!-- /content area -->




<!-- /main content -->