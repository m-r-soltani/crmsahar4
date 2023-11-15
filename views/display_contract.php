<!-- Content area -->
<div class="content">
    <!-- Form inputs -->
    <div class="card">
        <div class="card-body">
            <label class="col-form-label col-lg-2">انتخاب قرارداد</label>
            <div class="col-lg-4">
                <select class="form-control form-control-lg custom-select" name="select_contract" id="select_contract">
                    <!--entekhab noe gharar dad baraye taeed-->
                </select>
            </div>
            
        </div>
    </div>
</div>
<div id="display_contract_confirm_modal" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-full">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title">فرم مشاهه و تایید قرارداد</h5>
                        <button type="button" class="close" data-dismiss="modal"
                            style="font-size: 24px !important;">&#215
                        </button>
                    </div>
                    <div class="modal-body">
                        
                        <div class="contract_box" id="contract_box">
                        </div>
                    </div>
                    
                    <form action="#">
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="form-check">
                                        <input type="hidden" id="contract_id" name="contract_id" value="empty">
                                        <div class="col-sm-12">
                                            <input type="text" id="code" class="form-control" name="code" placeholder="کد تایید ارسال شده را وارد کنید"
                                            required>
                                            <button type="button" id="send_sms" class="btn btn-link">ارسال پیامک</button>
                                            <label class="col-form-label col-lg-4" id= "countdown"></label>
                                        </div>
                                        <label class="col-form-label col-lg-4"></label>
                                        <div class="col-sm-12">
                                        <input type="checkbox" name="contract_confirm" id="contract_confirm" 
                                               required> قرارداد را مطالعه کرده و تایید میکنم
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-dismiss="modal">بستن</button>
                            <button type="submit" name="send_contract_confirm" class="btn bg-primary">تایید و ارسال</button>
                        </div>
                    </form>                    
                </div>
            </div>
        </div>
<!-- /content area -->
<!-- /main content -->