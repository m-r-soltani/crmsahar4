<!-- Content area -->
<div class="content">
    <!-- Form inputs -->
    <div class="card" id="formdiv">
            <div class="card-body">
                <form action="#" method="POST">
                    <fieldset class="mb-3">
                        <legend class="text-uppercase font-size-sm font-weight-bold">مسدود / آزادسازی سرویس</legend>
                        <div class="form-group row">
                            <label class="col-form-label col-md-2">انتخاب مشترک</label>
                            <div class="col-md-10">
                                <select class="form-control form-control-md custom_select" required name="sub" id="sub">
                                    <option disabled selected> -- یک مورد را انتخاب کنید -- </option>
                                </select>
                            </div>
                            <label class="col-form-label col-md-2">انتخاب سرویس مشترک</label>
                            <div class="col-md-4">
                                <select class="form-control form-control-md custom_select" required name="service" id="service">
                                    <option disabled selected> -- یک مورد را انتخاب کنید -- </option>
                                </select>
                            </div>
                            <label class="col-form-label col-md-2">نوع عملیات</label>
                            <div class="col-md-4">
                                <select class="form-control form-control-md custom_select" required name="operationtype" id="operationtype">
                                    
                                </select>
                            </div>
                            
                            <label class="col-form-label col-md-2">توضیحات</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="tozihat" id="tozihat">
                            </div>

                            <label class="col-form-label col-md-2 masdoditime" style="display: none;">مدت زمان مسدودی</label>
                            <div class="col-md-4 masdoditime" style="display: none;">
                                <select class="form-control form-control-md custom_select" required name="time" id="time">
                                    <option value="1">24 ساعت</option>
                                    <option value="2">48 ساعت</option>
                                    <option value="3">72 ساعت</option>
                                    <option value="7">هفت روز</option>
                                    <option value="15">پانزده روز</option>
                                    <option value="30">یک ماه</option>
                                    <option value="0">بدون محدودیت</option>
                                </select>
                            </div>
                        </div>
                    </fieldset>
                    <div class="text-right">
                        <button type="submit" name="send_suspensions" id="send_suspensions" class="btn btn-primary">ارسال <i class="icon-paperplane ml-2"></i></button>
                    </div>
                </form>
            </div>
        </div>
</div>
<!-- /content area -->




<!-- /main content -->