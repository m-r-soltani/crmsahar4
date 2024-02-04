<!-- Content area -->
<div class="content">
    <!-- Form inputs -->
    <div class="card">
        <div class="card-body">
            <div class="filters">
                    <legend class="text-uppercase font-size-sm font-weight-bold text-warning">فیلتر های دلخواه</legend>
                    <div class="col-md-12">
                        <label class="col-form-label col-md-2 text-secondary">انتخاب استان:</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ostanchoose" id="ostanchoose1" value="1">
                            <label class="form-check-label">بله</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ostanchoose" id="ostanchoose2" value="2">
                            <label class="form-check-label">خیر</label>
                        </div>
                        <label class="col-form-label col-md-2 text-secondary">انتخاب شهر:</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="shahrchoose" id="shahrchoose1" value="1">
                            <label class="form-check-label">بله</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="shahrchoose" id="shahrchoose2" value="2">
                            <label class="form-check-label">خیر</label>
                        </div>   
                        <label class="col-form-label col-md-2 text-secondary">انتخاب تاریخ:</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="tarikhchoose" id="tarikhchoose1" value="1">
                            <label class="form-check-label">بله</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="tarikhchoose" id="tarikhchoose2" value="2">
                            <label class="form-check-label">خیر</label>
                        </div>   
                        <div class="text-right">
                            <button type="button" name="filtersbtn" id="filtersbtn" class="btn btn-secondary">تایید <i class="icon-list ml-2"></i></button>
                        </div>                                
                    </div>
            </div>
        </div>
    </div>
    <div class="card" style="display:none;" id="formcardbody">
        <div class="card-body">
            <form action="#" method="POST" name="active_services">
                <fieldset class="mb-3">
                    <legend class="text-uppercase font-size-sm font-weight-bold text-warning">گزارش سرویس های فعال</legend>
                    <div class="form-group row" id="activeservicesformbody">
                        <!-- <label class="col-form-label col-md-2">استان</label>
                        <span class="col-md-4">
                            <select class="form-control form-control-md custom_select" required name="ostan" id="ostan">
                            </select>
                        </span> -->
                        <!-- <label class="col-form-label col-md-2">شهر</label>
                        <div class="col-md-4">
                            <select class="form-control form-control-md custom_select" required name="shahr" id="shahr">
                            </select>
                        </div> -->
                        <!-- <label class="col-form-label col-md-2">نوع سرویس</label>
                        <div class="col-md-4">
                            <select class="form-control form-control-md custom_select" required name="service" id="service">
                                <option value="dsl" selected>DSL(ADSL & VDSL)</option>
                                <option value="adsl">ADSL</option>
                                <option value="vdsl">VDSL</option>
                                <option value="wireless">Wireless</option>
                                <option value="tdlte">TDLTE</option>
                                <option value="voip">Voip(Orgination)</option>
                            </select>
                        </div> -->
                        <!-- <label class="col-form-label col-md-2">وضعیت</label>
                        <div class="col-md-4">
                            <select class="form-control form-control-md custom_select" required name="status" id="status">
                                <option value="1" selected>فعال</option>
                                <option value="2">غیر فعال</option>
                                <option value="0">همه</option>
                            </select>
                        </div> -->
                        <!-- <label class="col-form-label col-md-2">از تاریخ</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="timefrom" name="timefrom" placeholder="" required>
                        </div>
                        <label class="col-form-label col-md-2">تا تاریخ</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="timeto" name="timeto" placeholder="" required>
                        </div> -->
                    </div>
                </fieldset>
                <div class="text-right">
                    <button type="submit" name="send_active_services" id="send_active_services" class="btn btn-primary">ارسال <i class="icon-paperplane ml-2"></i></button>
                </div>
            </form>
        </div>
    </div>
    <!-- /form inputs -->
    <!--datatable-->
    <div class="card" style="display:none;" id="datatablecardbody">
        <div class="card-body">
            <table id="datatable1" class="table table-striped datatable-responsive table-hover">
            </table>
        </div>
    </div>
    <!--/datatable-->

</div>
<!-- /content area -->




<!-- /main content -->