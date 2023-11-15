<!-- Content area -->
<div class="content">
    <!-- Form inputs -->
    <div class="card">
        <div class="card-body">
            <form action="#" method="POST">
                <fieldset class="mb-3">
                    <legend class="text-uppercase font-size-sm font-weight-bold">تعریف پیام های داخلی</legend>
                    <div class="form-group row">
                        <input type="hidden" id="id" class="form-control" name="id" value="empty">
                        <label class="col-form-label col-lg-2" >استفاده در</label>
                        <div class="col-lg-4">
                            <select class="form-control form-control-lg custom-select" required name="karbord" id="karbord">
                                <option value="sms">ثبت مشترک شرکت</option>
                                <option value="smn">ثبت مشترک نماینده</option>
                                <option value="vms">ویرایش مشترک شرکت</option>
                                <option value="vmn">ویرایش مشترک نماینده</option>
                                <option value="sfadms">ثبت فاکتور ADSL مشترک شرکت</option>
                                <option value="sfvdms">ثبت فاکتور VDSL مشترک شرکت</option>
                                <option value="sfwims">ثبت فاکتور WIRELESS مشترک شرکت</option>
                                <option value="sftdms">ثبت فاکتور TDLTE مشترک شرکت</option>
                                <option value="sfvoms">ثبت فاکتور VOIP مشترک شرکت</option>
                                <option value="sfadmn">ثبت فاکتور ADSL مشترک نماینده</option>
                                <option value="sfvdmn">ثبت فاکتور VDSL مشترک نماینده</option>
                                <option value="sfwimn">ثبت فاکتور WIRELESS مشترک نماینده</option>
                                <option value="sftdmn">ثبت فاکتور TDLTE مشترک نماینده</option>
                                <option value="sfvomn">ثبت فاکتور VOIP مشترک نماینده</option>
                                <option value="sharje_bn">شارژ بانک حساب نماینده</option>
                                <option value="sharje_bms">شارژ بانک مشترک شرکت</option>
                                <option value="sharje_bmn">شارژ بانک مشترک نماینده</option>
                                <option value="sems">ثبت امکانات مشترک شرکت</option>
                                <option value="semn">ثبت امکانات مشترک نماینده</option>
                                <option value="mdhexs">مشترک درحال Expire شرکت</option>
                                <option value="mdhexn">مشترک درحال Expire نماینده</option>
                                <option value="mess">مشترک Expire شده شرکت</option>
                                <option value="mesn">مشترک Expire شده نماینده</option>
                                <option value="emzaadsl">امضا قرارداد Adsl</option>
                                <option value="emzavdsl">امضا قرارداد Vdsl</option>
                                <option value="emzabitstream">امضا قرارداد Bitstream</option>
                                <option value="emzawireless">امضا قرارداد Wireless</option>
                                <option value="emzavoip">امضا قرارداد Voip</option>
                                <option value="emzangn">امضا قرارداد NGN</option>
                            </select>
                        </div>
                        <label class="col-form-label col-lg-2" >وضعیت</label>
                            <div class="col-lg-4">
                                <select class="form-control form-control-lg custom-select" required name="status" id="status">
                                    <option value="1">فعال</option>
                                    <option value="2">غیر فعال</option>
                                </select>
                            </div>
                        
                        <label class="col-form-label col-lg-2" >متن پیام</label>
                        <div class="col-lg-10">
                            <textarea class="form-control" id="message" name="message" style="height: 250px;"></textarea>
                        </div>
                        
                    </div>
                </fieldset>
                <div class="text-right">
                    <button type="submit" name="send_internal_messages" class="btn btn-primary">ارسال <i class="icon-paperplane ml-2"></i></button>
                </div>
            </form>
        </div>
    </div>
    <!-- /form inputs -->
</div>
<!-- /content area -->
