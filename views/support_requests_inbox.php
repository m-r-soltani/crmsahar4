
<div class="content">
    <div class="card">
        <div class="card-body">
            <legend class="text-uppercase font-size-sm font-weight-bold">پیام های دریافت شده</legend>
            <div class="col-md-12">
                <button name="edit" class="btn btn-primary col-md-auto float-md-right" id="response_to_message">پاسخ به پیام مورد نظر<i class="icon-paperplane ml-2"></i></button>
                <table id="view_table" class="table table-striped datatable-responsive table-hover">
                </table>
            </div>
        </div>
        <div id="modal_form_support_requests_inbox_response" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-medium">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title">پاسخ به پیام</h5>
                        <button type="button" class="close" data-dismiss="modal"
                            style="font-size: 24px !important;">&#215
                        </button>
                    </div>
                    <form action="#" name="support_requests_inbox_response">
                        <input name="reply_id" id="support_requests_inbox_form_message_id" type="hidden" class="form-control">
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-6 col-md-6">
                                        <label class="col-form-label">عنوان</label>
                                        <input name="onvane_payam" id="onvane_payam" type="text" class="form-control">
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <label class="col-form-label">متن پیام</label>
                                        <input name="matne_payam" id="matne_payam" type="text" class="form-control">
                                    </div>

                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-dismiss="modal">بستن</button>
                            <button type="submit" name="send_support_requests_inbox_response" id="send_support_requests_inbox_response" class="btn bg-primary">ارسال</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
