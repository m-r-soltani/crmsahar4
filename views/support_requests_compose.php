<!-- Content area -->
<div class="content">
    <!-- Form inputs -->
    <div class="card">
        <div class="card-body">
            <form action="#" method="POST">
                <fieldset class="mb-3">
                    <legend class="text-uppercase font-size-sm font-weight-bold">پشتیبانی</legend>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2" >نوع پیام/درخواست</label>
                        <div class="col-lg-4">
                            <select class="form-control form-control-lg custom-select" required name="noe_payam" id="noe_payam">
                            </select>
                        </div>
                        <div class="col-lg-6">
                        </div>
                        
                        <label class="col-form-label col-lg-2">عنوان درخواست</label>
                        <div class="col-lg-10">
                            <input type="text" id="onvane_payam" required class="form-control" name="onvane_payam" placeholder="">
                        </div>
                        
                        <label class="col-form-label col-lg-2">متن پیام</label>
                        <div class="col-lg-10">
                            <textarea type="" rows="4" cols="4" class="form-control elastic" required id="matne_payam" name="matne_payam" style="overflow: hidden; overflow-wrap: break-word; resize: both; height: 350px;"> </textarea>
                        </div>
                    </div>
                </fieldset>
                <div class="text-right">
                    <button type="submit" name="send_support_requests_compose" class="btn btn-primary">ارسال <i class="icon-paperplane ml-2"></i></button>
                </div>
            </form>
        </div>
    </div>
    <!-- /form inputs -->
</div>
<!-- /content area -->
<!-- /main content -->