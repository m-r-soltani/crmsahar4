<!-- Content area -->
<div class="content">
    <!-- Form inputs -->
    <div class="card">
        <div class="card-body">
            <legend class="text-uppercase font-size-sm font-weight-bold">اختصاص IP</legend>
            <ul class="nav nav-tabs nav-tabs-bottom border-bottom-0 nav-justified">
                <li class="nav-item services_tabs"><a href="#bottom-justified-divided-bandwidth" class="nav-link active" data-toggle="tab">BandWidth</a></li>
                <li class="nav-item services_tabs"><a href="#bottom-justified-divided-adslvdsl" class="nav-link" data-toggle="tab">ADSL/VDSL</a></li>
                <li class="nav-item services_tabs"><a href="#bottom-justified-divided-wireless" class="nav-link" data-toggle="tab">Wireless</a></li>
                <li class="nav-item services_tabs"><a href="#bottom-justified-divided-tdlte" class="nav-link" data-toggle="tab">TD-LTE</a></li>
            </ul>
            <div class="tab-content">
                <!------------BandWidth------------->
                <div class="bs_tab tab-pane show active" id="bottom-justified-divided-bandwidth">
                    <form action="#" method="POST">
                        <fieldset class="mb-3">
                            <div class="form-group row">
                                <input type="hidden" id="bw_id" class="form-control" name="id" value="empty">
                                <label class="col-form-label col-lg-2">IP Pool</label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom_select" required name="ippool" id="bw_ippool">
                                    </select>
                                </div>
                                <label class="col-form-label col-lg-2">IP</label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom_select" required name="ip" id="bw_ip">
                                    </select>
                                </div>
                                <label class="col-form-label col-lg-2">انتخاب مشترک</label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom_select" required name="sub" id="bw_sub">
                                    </select>
                                </div>
                                <label class="col-form-label col-lg-2">پهنای باند (مگابایت)</label>
                                <div class="col-lg-4">
                                    <input type="number" id="bw_bandwidth" class="form-control" name="bandwidth" placeholder="مثال: 10" pattern="[0-9]" required>
                                </div>
                                <label class="col-form-label col-lg-2">تاریخ شروع اختصاص</label>
                                <div class="col-lg-4">
                                    <input type="text" id="bw_tarikhe_shoroe_ip" class="form-control" name="tarikhe_shoroe_ip" readonly required>
                                </div>
                                <label class="col-form-label col-lg-2">تاریخ پایان اختصاص</label>
                                <div class="col-lg-4">
                                    <input type="text" id="bw_tarikhe_payane_ip" class="form-control" name="tarikhe_payane_ip" readonly required>
                                </div>
                                <label class="col-form-label col-lg-2">تعلیق ip</label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom_select" name="taligh" id="bw_taligh" required>
                                        <option disabled selected> -- یک مورد را انتخاب کنید -- </option>
                                        <option value="1">بله</option>
                                        <option value="2">خیر</option>
                                    </select>
                                </div>
                                <label class="col-form-label col-lg-2">تاریخ تعلیق IP</label>
                                <div class="col-lg-4">
                                    <input type="text" id="bw_tarikhe_talighe_ip" class="form-control" name="tarikhe_talighe_ip" readonly required>
                                </div>
                                <label class="col-form-label col-lg-2">تاریخ شروع سرویس</label>
                                <div class="col-lg-4">
                                    <input type="text" id="bw_tarikhe_shoroe_service" class="form-control" name="tarikhe_shoroe_service" required readonly>
                                </div>
                                <label class="col-form-label col-lg-2">تاریخ پایان سرویس</label>
                                <div class="col-lg-4">
                                    <input type="text" id="bw_tarikhe_payane_service" name="tarikhe_payane_service" class="form-control" required readonly>
                                </div>
                                <label class="col-form-label col-lg-2">طول جغرافیایی (N)</label>
                                <div class="col-lg-4">
                                    <input type="number" name="tol" id="bw_tol" class="form-control" required>
                                </div>
                                <label class="col-form-label col-lg-2">عرض جغرافیایی(E)</label>
                                <div class="col-lg-4">
                                    <input type="number" name="arz" id="bw_arz" class="form-control" required>
                                </div>
                            </div>
                        </fieldset>
                        <div class="text-right">
                            <button type="submit" name="send_bandwidth_ipassign" class="btn btn-primary">ارسال <i class="icon-paperplane ml-2"></i></button>
                        </div>
                    </form>
                </div>
                <!------------ADSL/VDSL------------->
                <div class="adsl_tab tab-pane fade" id="bottom-justified-divided-adslvdsl">
                    <form action="#" method="POST">
                        <fieldset class="mb-3">
                            <div class="form-group row">
                                <input type="hidden" id="av_id" class="form-control" name="id" value="empty">
                                <label class="col-form-label col-lg-2">IP Pool</label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom_select" required name="ippool" id="av_ippool">
                                    </select>
                                </div>
                                <label class="col-form-label col-lg-2">IP</label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom_select" required name="ip" id="av_ip">
                                    </select>
                                </div>
                                <label class="col-form-label col-lg-2">سرویس مشترک</label>
                                <div class="col-lg-10">
                                    <select class="form-control form-control-lg custom_select" required name="service" id="av_service">
                                    </select>
                                </div>
                                <label class="col-form-label col-lg-2">تاریخ شروع اختصاص</label>
                                <div class="col-lg-4">
                                    <input type="text" id="av_tarikhe_shoroe_ip" class="form-control" name="tarikhe_shoroe_ip" readonly required>
                                </div>
                                <label class="col-form-label col-lg-2">تاریخ پایان اختصاص</label>
                                <div class="col-lg-4">
                                    <input type="text" id="av_tarikhe_payane_ip" class="form-control" name="tarikhe_payane_ip" readonly required>
                                </div>
                                <label class="col-form-label col-lg-2">تعلیق ip</label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom_select" name="taligh" id="av_taligh" required>
                                        <option disabled selected> -- یک مورد را انتخاب کنید -- </option>
                                        <option value="1">بله</option>
                                        <option value="2">خیر</option>
                                    </select>
                                </div>
                                <label class="col-form-label col-lg-2">تاریخ تعلیق IP</label>
                                <div class="col-lg-4">
                                    <input type="text" id="av_tarikhe_talighe_ip" class="form-control" name="tarikhe_talighe_ip" readonly required>
                                </div>
                            </div>
                        </fieldset>
                        <div class="text-right">
                            <button type="submit" name="send_adslvdsl_ipassign" class="btn btn-primary">ارسال <i class="icon-paperplane ml-2"></i></button>
                        </div>
                    </form>
                </div>
                <!------------Wireless------------->
                <div class="adsl_tab tab-pane fade" id="bottom-justified-divided-wireless">
                    <form action="#" method="POST">
                        <fieldset class="mb-3">
                            <div class="form-group row">
                                <input type="hidden" id="w_id" class="form-control" name="id" value="empty">
                                <label class="col-form-label col-lg-2">IP Pool</label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom_select" required name="ippool" id="w_ippool">
                                    </select>
                                </div>
                                <label class="col-form-label col-lg-2">IP</label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom_select" required name="ip" id="w_ip">
                                    </select>
                                </div>
                                <label class="col-form-label col-lg-2">سرویس مشترک</label>
                                <div class="col-lg-10">
                                    <select class="form-control form-control-lg custom_select" required name="service" id="w_service">
                                    </select>
                                </div>
                                <label class="col-form-label col-lg-2">تاریخ شروع اختصاص</label>
                                <div class="col-lg-4">
                                    <input type="text" id="w_tarikhe_shoroe_ip" class="form-control" name="tarikhe_shoroe_ip" readonly required>
                                </div>
                                <label class="col-form-label col-lg-2">تاریخ پایان اختصاص</label>
                                <div class="col-lg-4">
                                    <input type="text" id="w_tarikhe_payane_ip" class="form-control" name="tarikhe_payane_ip" readonly required>
                                </div>
                                <label class="col-form-label col-lg-2">تعلیق ip</label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom_select" name="taligh" id="w_taligh" required>
                                        <option disabled selected> -- یک مورد را انتخاب کنید -- </option>
                                        <option value="1">بله</option>
                                        <option value="2">خیر</option>
                                    </select>
                                </div>
                                <label class="col-form-label col-lg-2">تاریخ تعلیق IP</label>
                                <div class="col-lg-4">
                                    <input type="text" id="w_tarikhe_talighe_ip" class="form-control" name="tarikhe_talighe_ip" readonly required>
                                </div>
                            </div>
                        </fieldset>
                        <div class="text-right">
                            <button type="submit" name="send_wireless_ipassign" class="btn btn-primary">ارسال <i class="icon-paperplane ml-2"></i></button>
                        </div>
                    </form>
                </div>
                <!------------Tdlte------------->
                <div class="tdlte_tab tab-pane fade" id="bottom-justified-divided-tdlte">
                    <form action="#" method="POST">
                        <fieldset class="mb-3">
                            <div class="form-group row">
                                <input type="hidden" id="t_id" class="form-control" name="id" value="empty">
                                <label class="col-form-label col-lg-2">IP Pool</label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom_select" required name="ippool" id="t_ippool">
                                    </select>
                                </div>
                                <label class="col-form-label col-lg-2">IP</label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom_select" required name="ip" id="t_ip">
                                    </select>
                                </div>
                                <label class="col-form-label col-lg-2">سرویس مشترک</label>
                                <div class="col-lg-10">
                                    <select class="form-control form-control-lg custom_select" required name="service" id="t_service">
                                    </select>
                                </div>
                                <label class="col-form-label col-lg-2">تاریخ شروع اختصاص</label>
                                <div class="col-lg-4">
                                    <input type="text" id="t_tarikhe_shoroe_ip" class="form-control" name="tarikhe_shoroe_ip" readonly required>
                                </div>
                                <label class="col-form-label col-lg-2">تاریخ پایان اختصاص</label>
                                <div class="col-lg-4">
                                    <input type="text" id="t_tarikhe_payane_ip" class="form-control" name="tarikhe_payane_ip" readonly required>
                                </div>
                                <label class="col-form-label col-lg-2">تعلیق ip</label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom_select" name="taligh" id="t_taligh" required>
                                        <option disabled selected> -- یک مورد را انتخاب کنید -- </option>
                                        <option value="1">بله</option>
                                        <option value="2">خیر</option>
                                    </select>
                                </div>
                                <label class="col-form-label col-lg-2">تاریخ تعلیق IP</label>
                                <div class="col-lg-4">
                                    <input type="text" id="t_tarikhe_talighe_ip" class="form-control" name="tarikhe_talighe_ip" readonly required>
                                </div>
                            </div>
                        </fieldset>
                        <div class="text-right">
                            <button type="submit" name="send_tdlte_ipassign" class="btn btn-primary">ارسال <i class="icon-paperplane ml-2"></i></button>
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

            <button name="delete" class="btn btn-warning col-md-auto float-md-right" id="delete"> حذف<i class="icon-folder-remove ml-2"></i></button>
            <button name="edit" class="btn btn-primary col-md-auto float-md-right" id="edit">ویرایش<i class="icon-database-edit2 ml-2"></i></button>

            <table id="view_table" class="table table-striped datatable-responsive table-hover">
            </table>
        </div>
    </div>
    <!--/datatable-->

</div>
<!-- /content area -->




<!-- /main content -->