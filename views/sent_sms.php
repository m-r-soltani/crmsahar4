        <!-- Content area -->
        <div class="content">
            <!-- Form inputs -->
            <div class="card">
                <div class="card-body">
                    <form action="#" method="POST" name="sent_sms_form">
                        <fieldset class="mb-3">
                            <legend class="text-uppercase font-size-sm font-weight-bold">پیامک های ارسال شده</legend>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">از تاریخ</label>
                                <div class="col-lg-4">
                                    <input name="aztarikh" id="aztarikh" type="text"
                                        class="form-control" placeholder="">
                                </div>
                            </div>
                        </fieldset>
                        <div class="text-right">
                            <button type="submit" name="send_sent_sms" class="btn btn-primary">ارسال <i class="icon-paperplane ml-2"></i></button>
                        </div>
                    </form>

                </div>
            </div>
            <!-- /form inputs -->
            <!--datatable-->
            <div class="card">
                <div class="col-md-12">
                    <table id="view_table" class="table table-striped datatable-responsive table-hover ltrallexceptfirstcolumn" style="width:100%">
                    </table>
                </div>
            </div>
            <!--/datatable-->
        </div>
        <!-- /content area -->