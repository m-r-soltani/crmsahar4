<!-- Content area -->
<div class="content">
    <!-- Form inputs -->
    <div class="card">
        <div class="card-body">
            <form action="#" method="POST">
                <fieldset class="mb-3">
                    <legend class="text-uppercase font-size-sm font-weight-bold">تعریف IP</legend>
                    <div class="form-group row">
                        <input type="hidden" id="id" class="form-control" name="id" value="empty">
                        <label class="col-form-label col-md-2">انتخاب IP Pool</label>
                        <div class="col-md-4">
                            <select class="form-control form-control-md custom_select" required name="pool" id="pool">
                            </select>
                        </div>
                        <label class="col-form-label col-md-2">IP Gender</label>
                        <div class="col-md-4">
                            <select class="form-control form-control-md custom_select" required name="gender" id="gender">
                                <option value="1">Valid</option>
                                <option value="2">InValid</option>
                            </select>
                        </div>
                        <label class="col-form-label col-md-2">نوع مالکیت</label>
                        <div class="col-md-4">
                            <select class="form-control form-control-md custom_select" required name="ownership" id="ownership">
                                <option value="1">مالک</option>
                                <option value="2">اجاره</option>
                                <option value="3">غیره</option>
                            </select>
                        </div>
                        <label class="col-form-label col-md-2">نوع IP</label>
                        <div class="col-md-4">
                            <select class="form-control form-control-md custom_select" required name="iptype" id="iptype">
                                <option value="1">Static</option>
                                <option value="0">Dynamic</option>
                            </select>
                        </div>
                        <label class="col-form-label col-md-2">کاربرد IP</label>
                        <div class="col-md-4">
                            <select class="form-control form-control-md custom_select" required name="ipusage" id="ipusage">
                                <option value="1">شبکه داخلی</option>
                                <option value="2">واگذاری به مشترکین</option>
                                <option value="3">رزرو</option>
                            </select>
                        </div>
                        <label class="col-form-label col-md-2">Service Type</label>
                        <div class="col-md-4">
                            <select class="form-control form-control-md custom_select" required name="servicetype" id="servicetype">
                                <option value="adsl">ADSL</option>
                                <option value="vdsl">VDSL</option>
                                <option value="wireless">Wireless</option>
                                <option value="ngn">NGN</option>
                                <option value="tdlte">TDLTE</option>
                                <option value="ethernet">Ethernet</option>
                                <option value="uplink">Uplink</option>
                                <option value="combo">combo</option>
                            </select>
                        </div>
                        <label class="col-form-label col-md-2">Subnet Mask</label>
                        <div class="col-md-4">
                            <select class="form-control form-control-md custom_select" required name="subnet" id="subnet">

                            </select>
                        </div>
                        
                        <label class="col-form-label col-md-2">IP Start</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" required name="ipstart" id="ipstart" placeholder="192.168.1.0">
                        </div>

                        <label class="col-form-label col-md-2">IP End</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" required name="ipend" id="ipend" placeholder="192.168.1.255">
                        </div>                      
                    </div>
                </fieldset>
                <div class="text-right">
                    <button type="submit" name="send_ip" id="send_ip" class="btn btn-primary">ارسال <i class="icon-paperplane ml-2"></i></button>
                </div>
            </form>
        </div>
    </div>
    <!-- /form inputs -->
    <!--datatable-->
    <div class="card">
        <div class="col-md-12">
            <button name = "delete" class="btn btn-warning col-md-auto float-md-right"  id = "delete" > حذف<i class="icon-folder-remove ml-2" ></i ></button >
            <button name="edit" class="btn btn-primary col-md-auto float-md-right" id="edit">ویرایش<i class="icon-database-edit2 ml-2"></i></button>
            <table id="view_table" class="table table-striped datatable-responsive table-hover">
            </table>
        </div>
    </div>
    <!--/datatable-->

</div>
<!-- /content area -->




<!-- /main content -->