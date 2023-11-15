        <!-- Content area -->
        <div class="content">
            <!-- Form inputs -->
            <div class="card">
                <div class="card-body">
                    <form action="#" method="POST">
                        <fieldset class="mb-3">
                            <legend class="text-uppercase font-size-lg font-weight-bold"><?php echo $this->pagename_fa; ?></legend>
                            <div class="form-group row">
                            <input type="hidden" id="id" class="form-control" name="id" value="empty">
                                <label class="col-form-label col-sm-2" >نام نمایندگی</label>
                                <div class="col-sm-4">
                                    <select class="form-control form-control-lg custom-select" name="branch_id" id="branch_id" required>
                                    </select>
                                </div>
                                
                                <label class="col-form-label col-sm-2" >نوع سرویس</label>
                                <div class="col-sm-4">
                                    <select class="form-control form-control-lg custom-select" name="service_type" id="service_type">
                                    </select>
                                </div>
                                
                                <label class="col-form-label col-sm-2" >نوع همکاری</label>
                                <div class="col-sm-4">
                                    <select class="form-control form-control-lg custom-select" name="cooperation_type" id="cooperation_type">
                                        <option value="1">درصدی</option>
                                        <option value="2">لایسنسی</option>
                                    </select>
                                </div>
                                
                                <legend class="col-12 text-uppercase font-size-sm font-weight-bold" style="color: #FB8C00">شرایط درصدی</legend>
                                <label class="col-form-label col-md-2">فروش سرویس جدید</label>
                                <div class="col-md-4">
                                    <input type="text" id="foroshe_service_jadid" class="form-control" name="foroshe_service_jadid" placeholder="درصد بدون علامت">
                                </div>
                                
                                <label class="col-form-label col-md-2">فروش سرویس شارژ مجدد</label>
                                <div class="col-md-4">
                                    <input type="text" id="foroshe_service_sharje_mojadad" class="form-control" name="foroshe_service_sharje_mojadad" placeholder="درصد بدون علامت">
                                </div>
                                
                                <label class="col-form-label col-md-2">فروش سرویس بالک</label>
                                <div class="col-md-4">
                                    <input type="text" id="foroshe_service_bulk" class="form-control" name="foroshe_service_bulk" placeholder="درصد بدون علامت">
                                </div>
                                
                                <label class="col-form-label col-md-2">فروش سرویس جشنواره</label>
                                <div class="col-md-4">
                                    <input type="text" id="foroshe_service_jashnvare" class="form-control" name="foroshe_service_jashnvare" placeholder="درصد بدون علامت">
                                </div>
                                
                                <legend class="col-12 text-uppercase font-size-sm font-weight-bold" style="color: #FB8C00">شرایط لایسنسی</legend>
                                <label class="col-form-label col-md-2">هزینه سازمان تنظیم</label>
                                <div class="col-md-4">
                                    <input type="text" id="hazine_sazmane_tanzim" class="form-control" name="hazine_sazmane_tanzim" placeholder="درصد بدون علامت">
                                </div>
                                
                                <label class="col-form-label col-md-2">هزینه سروکو</label>
                                <div class="col-md-4">
                                    <input type="text" id="hazine_servco" class="form-control" name="hazine_servco" placeholder="درصد بدون علامت">
                                </div>
                                
                                <label class="col-form-label col-md-2">هزینه منصوبه</label>
                                <div class="col-md-4">
                                    <input type="text" id="hazine_mansobe" class="form-control" name="hazine_mansobe" placeholder="به ریال">
                                </div>
                            </div>
                        </fieldset>
                        <div class="text-right">
                            <button type="submit" name="send_branch_cooperation_type" class="btn btn-primary">ارسال <i class="icon-paperplane ml-2"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /form inputs -->
            <!--datatable-->
            <div class="card">
                <div class="col-md-12">
                    <button name="delete" class="btn btn-warning col-md-auto float-md-right"  id="delete">حذف<i class="icon-folder-remove ml-2"></i></button>
                    <button name="edit" class="btn btn-primary col-md-auto float-md-right" id="edit">ویرایش<i class="icon-database-edit2 ml-2"></i></button>
                    <table id="view_table" class="table table-striped datatable-responsive table-hover">
                    </table>
                </div>
            </div>
            <!--/datatable-->
        </div>
        <!-- /content area -->