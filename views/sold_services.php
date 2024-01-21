<!-- Content area -->
<div class="content">
    <!-- Form inputs -->
    <div class="card">
        <div class="card-body">
            <form action="#" method="POST" name="sold_services">
                <fieldset class="mb-3">
                    <legend class="text-uppercase font-size-sm font-weight-bold text-warning">گزارش سرویس های فروخته شده</legend>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2" >استان</label>
                        <div class="col-lg-4">
                            <select class="form-control form-control-lg custom_select" required name="ostan" id="ostan">
                            </select>
                        </div>
                        <label class="col-form-label col-lg-2" >شهر</label>
                        <div class="col-lg-4">
                            <select class="form-control form-control-lg custom_select" required name="shahr" id="shahr">
                            </select>
                        </div>
                        <label class="col-form-label col-lg-2" >نوع سرویس</label>
                        <div class="col-lg-4">
                            <select class="form-control form-control-lg custom_select" required name="service" id="service">
                                <option value="dsl" selected>DSL(ADSL & VDSL)</option>
                                <option value="adsl" >ADSL</option>
                                <option value="vdsl" >VDSL</option>
                                <option value="wireless" >Wireless</option>
                                <option value="tdlte" >TDLTE</option>
                                <option value="voip" >Voip(Orgination)</option>
                                <!-- <option value="bandwidth" >BandWidth</option> -->
                            </select>
                        </div>
                        <label class="col-form-label col-lg-2" >وضعیت</label>
                        <div class="col-lg-4">
                            <select class="form-control form-control-lg custom_select" required name="status" id="status">
                                <option value="1" selected>فعال</option>
                                <option value="2">غیر فعال</option>
                                <option value="0">همه</option>
                            </select>
                        </div>
                        <label class="col-form-label col-lg-2">از تاریخ</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" id="timefrom" name="timefrom" placeholder="" required>
                        </div>
                        <label class="col-form-label col-lg-2">تا تاریخ</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" id="timeto" name="timeto" placeholder="" required>
                        </div>
                    </div>
                </fieldset>
                <div class="text-right">
                    <button type="submit" name="send_sold_services" id="send_sold_services" class="btn btn-primary">ارسال <i class="icon-paperplane ml-2"></i></button>
                </div>
            </form>
        </div>
    </div>
    <!-- /form inputs -->
    <!--datatable-->
    <div class="card">
        <div class="col-md-12">
            <table id="datatable1" class="table table-striped datatable-responsive table-hover">
            </table>
        </div>
    </div>
    <!--/datatable-->

</div>
<!-- /content area -->




<!-- /main content -->