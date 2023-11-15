<!-- Content area -->
<div class="content">
    <!-- Form inputs -->
    <div class="card">
        <div class="card-body">
            <form action="#" method="POST">
                <fieldset class="mb-3">
                    <legend class="text-uppercase font-size-sm font-weight-bold">پشتیبانی</legend>
                    <div class="form-group row">
                        <input type="hidden" id="id" class="form-control" name="id" value="empty">
                        <label class="col-form-label col-lg-2" >نوع پیام/درخواست</label>
                        <div class="col-lg-4">
                            <select class="form-control form-control-lg custom_select" name="noe_payam" id="noe_payam">

                            </select>
                        </div>
                        
                        <label class="col-form-label col-lg-2"></label>
                        <div class="col-lg-4">
                            <input type="textarea" id="name" class="form-control" name="name" placeholder="مثال: ">
                        </div>
                    </div>
                </fieldset>
                <div class="text-right">
                    <button type="submit" name="send_city" class="btn btn-primary">ارسال <i class="icon-paperplane ml-2"></i></button>
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