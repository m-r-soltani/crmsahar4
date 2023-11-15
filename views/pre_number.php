        <!-- Content area -->
        <div class="content">

            <!-- Form inputs -->
            <div class="card">
                <div class="card-body">
                    <form action="" method="POST">
                    <input type="hidden" id="id" class="form-control" name="id" value="empty">
                        <fieldset class="mb-3">
                            <legend class="text-uppercase font-size-sm font-weight-bold">پیش شماره</legend>
                            <div class="form-group row">                                
                                <label class="col-form-label col-lg-2">مرکز مخابراتی</label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom_select" name="markaze_mokhaberati" id="markaze_mokhaberati">
                                    </select>
                                </div>
                                
                                <label class="col-form-label col-lg-2">پیش شماره</label>
                                <div class="col-lg-4">
                                <input type="text" class="form-control" name="prenumber" id="prenumber" placeholder="مثال: 2237">

                                </div>
                                
                                <label class="col-form-label col-lg-2">توضیحات</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="tozihat" id="tozihat" placeholder="">
                                </div>
                                
                            </div>
                        </fieldset>
                        <div class="text-right">
                            <button type="submit" name="send_pre_number" class="btn btn-primary">ارسال <i class="icon-paperplane ml-2"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /form inputs -->
            <div class="card">
                <div class="col-md-12">
                    <button name="delete" class="btn btn-warning col-md-auto float-md-right"  id="delete">حذف<i class="icon-folder-remove ml-2"></i></button>
                    <button name="edit" class="btn btn-primary col-md-auto float-md-right" id="edit">ویرایش<i class="icon-database-edit2 ml-2"></i></button>
                    <table id="view_table" class="table table-striped datatable-responsive table-hover">
                    </table>
                </div>
            </div>
        </div>
        <!-- /content area -->