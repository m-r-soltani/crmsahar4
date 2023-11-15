<!-- Content area -->
<div class="content">
    <!-- Form inputs -->
    <div class="card">
        <div class="card-body">
            <form action="#" method="POST" enctype="multipart/form-data">
                <fieldset class="mb-3">
                    <legend class="text-uppercase font-size-sm font-weight-bold">آپلود فایل</legend>
                    <div class="form-group row">
                       <input type="hidden" id="id" class="form-control" name="id" value="empty">
                        <label class="col-form-label col-lg-2" >کاربرد فایل دریافتی</label>
                        <div class="col-lg-4">
                            <select class="form-control form-control-lg custom-select" required name="file_usage_type" id="file_usage_type">
                            </select>
                        </div>
                        <label class="col-form-label col-lg-2" >عنوان فایل</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="file_subject" id="file_subject" placeholder="عنوان دلخواه جهت یادآوری" required>
                        </div>
                        
                        <label class="col-form-label col-lg-2" style="margin-top: 5px;">بارگزاری فایل</label>
                        <div class="col-lg-4" style="margin-top: 5px;">
                            <input type="file" required name="file" id="file" class="form-control form-control-lg">
                        </div>

                    </div>
                </fieldset>
                <div class="text-right">
                    <button type="submit" name="send_upload_file" class="btn btn-primary">ارسال<i class="icon-paperplane ml-2"></i></button>
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
