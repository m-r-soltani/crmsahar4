<!-- Content area -->
<div class="content">
    <!-- Form inputs -->
    <div class="card">
        <div class="card-body">
            <form action="#" method="POST">
                <fieldset class="mb-3">
                    <legend class="text-uppercase font-size-sm font-weight-bold">ارسال گزارش Crm امنیت</legend>
                    <legend class="text-uppercase font-size-sm font-weight-bold" style="color: red">هشدار: نمیتوانید گزارش امروز را بگیرید و باید تا ساعت 24 صبر کنید</legend>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">از تاریخ</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" required name="fd" id = "fd" placeholder="">
                        </div>
                        <label class="col-form-label col-lg-2" >تا تاریخ</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" required name="td" id = "td" placeholder="">
                        </div>
                        <legend class="text-uppercase font-size-sm font-weight-bold" style="color: red">اگر بازه انتخابی یک روز باشد فرقی ندارد کدامیک ازین گزینه ها را انتخاب کنید</legend>
                        <label class="col-form-label col-lg-2" >نوع گزارش</label>
                        <div class="col-lg-4">
                            <select class="form-control form-control-lg custom_select" required name="type" id="type">
                                <option value="1">ارسال گزارش یکجا</option>
                                <option value="2">ارسال گزارش روزانه</option>
                            </select>
                        </div>
                    </div>
                </fieldset>
                <div class="text-right">
                    <button type="submit" name="send_crm_report" id="send_crm_report" class="btn btn-primary">ارسال <i class="icon-paperplane ml-2"></i></button>
                </div>
            </form>
        </div>
    </div>
    <!-- /form inputs -->
    <!--datatable-->
    <!-- <div class="card">
        <div class="col-md-12">

            <button name = "delete" class="btn btn-warning col-md-auto float-md-right"  id = "delete" > حذف<i class="icon-folder-remove ml-2" ></i ></button >
            <button name="edit" class="btn btn-primary col-md-auto float-md-right" id="edit">ویرایش<i class="icon-database-edit2 ml-2"></i></button>

            <table id="view_table" class="table table-striped datatable-responsive table-hover">
            </table>
        </div>
    </div> -->
    <!--/datatable-->

</div>
<!-- /content area -->




<!-- /main content -->