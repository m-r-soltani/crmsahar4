    <!-- Content area -->
    <div class="content">
        <!-- Form inputs -->
        <!-- <script src="https://www.zarinpal.com/webservice/TrustCode" type="text/javascript"></script> -->

        <div class="card">
            <div class="card-body">
                <form action="#" name="charge_credit_form" method="POST">
                    <fieldset class="mb-3">
                        <legend class="text-uppercase font-size-sm font-weight-bold">مبلغ مورد نظر جهت پرداخت</legend>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2" >انتخاب درگاه بانکی</label>
                            <div class="col-lg-4">
                                <select class="form-control form-control-lg custom_select" required name="dargah" id="dargah">
                                <!-- <option disabled selected> -- یک مورد را انتخاب کنید -- </option> -->
                                    <option value="1" selected>درگاه زرین پال</option>
                                    <!-- <option value="2" disabled>سامان بانک</option> -->
                                </select>
                            </div>
                            <label class="col-form-label col-lg-2" >شارژ حساب (مبلغ به ریال)</label>
                            <div class="col-lg-4">
                                <input type="text" id="charge_amount" required class="form-control charge_amount" name="charge_amount"
                                    placeholder="مبلغ به ریال">
                                    <span id= "charge_amount_persian"></span>
                            </div>
                            <div class="col-lg-4">
                            </div>
                            <!-- <legend class="text-uppercase font-size-sm font-weight-bold" style="color: red;">*توجه: حداقل مبلغ قابل پرداخت&lrm;25,000 &lrm; ریال میباشد</legend> -->
                        </div>
                    </fieldset>
                    <div class="text-right">
                        <button type="submit" name="send_charge_credit" id="send_charge_credit" class="btn btn-primary">برو به درگاه بانک <i
                            class="icon-coins ml-1"></i></button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /form inputs -->
    </div>
    <!-- /content area -->




    <!-- /main content -->
