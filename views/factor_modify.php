    <!-- Content area -->
    <div class="content">
        <div class="card">
            <div class="card-body">
                <form action="#" method="POST" name="factor_modify_form">
                    <input type="hidden" id="id" class="form-control" name="id" value="empty">
                    <fieldset class="mb-3">
                        <legend class="text-uppercase font-size-sm font-weight-bold">تغییر وضعیت فاکتور</legend>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">انتخاب شماره فاکتور</label>
                            <div class="col-lg-4">
                                <select class="form-control form-control-lg custom-select" required name="factor_id" id="factor_id">
                                </select>
                            </div>
                            
                            <label class="col-form-label col-lg-2">انتخاب نوع تغییر وضعیت</label>
                            <div class="col-lg-4">
                                <select class="form-control form-control-lg custom-select" required name="noe_taghir" id="noe_taghir">
                                    <option value="fishe_varizi">ثبت فیش واریزی</option>
                                    <option value="disable">غیر فعال(Disable)</option>
                                    <option value="marjo">مرجوع شده</option>
                                    <option value="ersal">ارسال شده</option>
                                </select>
                            </div>
                            
                            <label class="col-form-label col-lg-2">توضیحات</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" name="tozihat" id="tozihat" placeholder="">
                            </div>
                            
                        </div>
                    </fieldset>
                    <div class="text-right">
                        <button type="submit" name="send_factor_modify" class="btn btn-primary">ارسال <i class="icon-paperplane ml-2"></i></button>
                </div>
                </form>
            </div>
        </div>
    </div>
