
<!-- Content area -->
<div class="content">

    <!-- Form inputs -->
    <div class="card">
        <div class="card-body">
            <form action="" method="POST">
                <fieldset class="mb-3">
                    <legend class="text-uppercase font-size-sm font-weight-bold">تعریف سیمکارت TDLTE</legend>
                    <div class="form-group row">
                    <label class="col-form-label col-lg-2" >انتخاب نمایندگی</label>
                        <div class="col-lg-4">
                            <select class="form-control form-control-lg custom-select" name="branch_id" id="branch_id">
                            
                            </select>
                        </div>
                        
                       <label class="col-form-label col-lg-2" >مشترک صاحب سیمکارت</label>
                       <div class="col-lg-4">
                            <input type="text" class="form-control" name="subscriber_id" id="subscriber_id" placeholder="">
                       </div>

                        <label class="col-form-label col-lg-2">سریال سیمکارت</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="serial" id="serial" placeholder="سریال">
                            <input type="hidden" id="id" class="form-control" name="id" value="empty">
                        </div>
                        
                        <label class="col-form-label col-lg-2">شماره سیمکارت</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="tdlte_number" id="tdlte_number" placeholder="شماره">
                        </div>
                        
                        <label class="col-form-label col-lg-2">puk1</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="puk1" id="puk1" placeholder="puk1">
                        </div>
                        
                        <label class="col-form-label col-lg-2">puk2</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="puk2" id="puk2" placeholder="puk2">
                        </div>
                        
                    </div>
                </fieldset>
                <div class="text-right">
                    <button type="submit" name="send_tdlte_sim" class="btn btn-primary">ارسال <i class="icon-paperplane ml-2"></i></button>
                </div>
            </form>
        </div>
    </div>
    <!-- /form inputs -->
    <!--datatable-->
    <!--datatable-->
    <div class="card">
        <div class="col-md-12">
            <button name="delete" class="btn btn-warning col-md-auto float-md-right"  id="delete">حذف<i class="icon-folder-remove ml-2"></i></button>
            <button name="delete" class="btn btn-primary col-md-auto float-md-right" id="edit">ویرایش<i class="icon-database-edit2 ml-2"></i></button>
            <table id="view_table" class="table table-striped datatable-responsive">
            </table>
        </div>
    </div>
</div>
<!-- /content area -->