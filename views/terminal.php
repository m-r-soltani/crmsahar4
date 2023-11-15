        <!-- Content area -->
        <div class="content">

            <!-- Form inputs -->
            <div class="card">
                <div class="card-body">
                    <form action="" method="POST">
                        <fieldset class="mb-3">
                            <legend class="text-uppercase font-size-sm font-weight-bold">ثبت ترمینال</legend>
                            <div class="form-group row">
                                <input type="hidden" class="form-control" name="id" id="id" value="empty">
                                <label class="col-form-label col-lg-2">استان</label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom_select" name="ostan" id="ostan">

                                    </select>
                                </div>
                                
                                <label class="col-form-label col-lg-2">شهر</label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom_select" name="shahr" id="shahr">
                                    </select>
                                </div>
                                
                                <label class="col-form-label col-lg-2">مرکز مخابراتی</label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom_select" name="markaze_mokhaberati" id="markaze_mokhaberati">
                                    </select>
                                </div>
                                
                                <label class="col-form-label col-lg-2">نوع ترمینال</label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom_select" name="noe_terminal" id="noe_terminal">
                                    </select>
                                </div>
                                
                                <label class="col-form-label col-lg-2">نام ترمینال</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="name" id="name" placeholder="نام ترمینال">
                                </div>
                                
                                <label class="col-form-label col-lg-2">ردیف</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="radif" id="radif" placeholder="ردیف">
                                </div>
                                
                                <label class="col-form-label col-lg-2">تیغه</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="tighe" id="tighe" placeholder="تیغه">
                                </div>
                                
                                <label class="col-form-label col-lg-2">شروع اتصال</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="shoroe_etesali" id="shoroe_etesali" placeholder="">
                                </div>
                                
                            </div>
                        </fieldset>
                        <div class="text-right">
                            <button type="submit" name="send_terminal" class="btn btn-primary">ارسال <i class="icon-paperplane ml-2"></i></button>
                            <span class=""></span>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /form inputs -->
            <div class="card">
                <div class="col-md-12">
                    <button name="delete" class="btn btn-warning col-md-auto float-md-right"  id="delete">حذف<i class="icon-folder-remove ml-2"></i></button>
                    <table id="view_table" class="table table-striped datatable-responsive table-hover">
                    </table>
                </div>
            </div>
        </div>
        <!-- /content area -->