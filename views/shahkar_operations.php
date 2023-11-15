        <!-- Content area -->
        <div class="content">

            <!-- Form inputs -->
            <div class="card">
                <div class="card-body">
                    <legend class="text-uppercase font-size-sm font-weight-bold">عملیات های شاهکار</legend>
                    <ul class="nav nav-tabs nav-tabs-bottom border-bottom-0 nav-justified">
                        <li class="nav-item operations_tabs"><a href="#bottom-justified-divided-eststatus" class="nav-link active" data-toggle="tab">استعلام وضعیت سرویس</a></li>
                        <li class="nav-item operations_tabs"><a href="#bottom-justified-divided-closedelete" class="nav-link" data-toggle="tab">حذف/ بستن</a></li>
                        <li class="nav-item operations_tabs"><a href="#bottom-justified-divided-sehatsalamat" class="nav-link" data-toggle="tab">صحت سلامت شاهکار</a></li>
                    </ul>
                    <div class="tab-content">
                        <!------------status------------->
                        <div class="bs_tab tab-pane show active" id="bottom-justified-divided-eststatus">
                            <form action="#" method="POST">
                                <fieldset class="mb-3">
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-2">نوع سرویس</label>
                                        <div class="col-lg-4">
                                            <select class="form-control form-control-lg custom-select" name="sertype" id="status_servicetype" required>
                                                <option value="adsl">ADSL</option>
                                                <option value="vdsl">VDSL</option>
                                                <option value="wireless">Wireless</option>
                                                <option value="tdlte">Tdlte</option>
                                                <option value="voip">Voip</option>
                                                <option value="ngn">NGN</option>
                                            </select>
                                        </div>

                                        <label class="col-form-label col-lg-2"> تلفن/ شناسه سرویس مشترک</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="service" id="status_service" required>
                                        </div>
                                        
                                    </div>
                                </fieldset>
                                <div class="text-right">
                                    <button type="submit" name="send_shahkar_operations_servicestatus" class="btn btn-primary">ارسال <i class="icon-paperplane ml-2"></i></button>
                                </div>
                            </form>
                        </div>
                        <!------------Close/Delete Manual------------->
                        <div class="bs_tab tab-pane" id="bottom-justified-divided-closedelete">
                            <form action="#" method="POST">
                                <fieldset class="mb-3">
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-2">نوع عملیات</label>
                                        <div class="col-lg-4">
                                            <select class="form-control form-control-lg custom-select" name="operationtype" id="closedelete_operationtype">
                                                <option value="1">Close</option>
                                                <option value="2">Delete</option>
                                            </select>
                                        </div> 
                                        <label class="col-form-label col-lg-2">شناسه شاهکار</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="shahkarid" id="closedelete_shahkarid">
                                        </div>
                                        <label class="col-form-label col-lg-2">تلفن/ سرویس مشترک</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="telephone" id="closedelete_telephone">
                                        </div>
                                        <label class="col-form-label col-lg-2">کد نماینده فروش</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="resellercode" id="closedelete_resellercode" placeholder="(پیش فرض صفر)">
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="text-right">
                                    <button type="submit" name="send_shahkar_operations_closedelete" class="btn btn-primary">ارسال <i class="icon-paperplane ml-2"></i></button>
                                </div>
                            </form>
                        </div>
                        <!------------Close/Delete auto------------->
                        <div class="bs_tab tab-pane" id="bottom-justified-divided-sehatsalamat">
                            <form action="#" method="POST">
                                <fieldset class="mb-3">
                                    <div class="form-group row">
                                    <input type="hidden" class="form-control" name="sehatsalamat" id="sehatsalamat" required>                          
                                    </div>
                                </fieldset>
                                <div class="text-right">
                                    <button type="submit" name="send_shahkar_operations_sehatsalamat" class="btn btn-primary">استعلام صحت سلامت <i class="icon-paperplane ml-2"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /form inputs -->
            <!--datatable-->
            <div class="card">
                <div class="col-md-12">
                    <table id="view_table" class="table table-striped datatable-responsive table-hover">
                    </table>
                </div>
            </div>
        </div>
        <!-- /content area -->