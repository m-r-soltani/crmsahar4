        <!-- Content area -->
        <div class="content">

            <!-- Form inputs -->
            <div class="card">
                <div class="card-body">
                    <form action="" method="POST">
                        <fieldset class="mb-3">
                            <legend class="text-uppercase font-size-sm font-weight-bold">نوع ترمینال</legend>
                            <div class="form-group row">
                                <input type="hidden" id="id" class="form-control" name="id" value="empty">
                                <label class="col-form-label col-lg-2">اسم ترمینال</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="esme_terminal" id="esme_terminal" placeholder="">
                                </div>
                                
                                <label class="col-form-label col-lg-2">نعداد پورت</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="tedade_port" id="tedade_port" placeholder="">
                                </div>
                                
                                <label class="col-form-label col-lg-2">ترتیب رانژه</label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom_select" name="tartibe_ranzhe" id="tartibe_ranzhe">
                                        <option value="zoj">زوج</option>
                                        <option value="fard">فرد</option>
                                        <option value="poshte_sare_ham">پشت سر هم</option>
                                    </select>
                                </div>
                                
                                <label class="col-form-label col-lg-2">نعداد تیغه</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="tedade_tighe" id="tedade_tighe" placeholder="">
                                </div>
                                
                                <label class="col-form-label col-lg-2">نعداد پورت در هر تیغه</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="tedade_port_dar_har_tighe" id="tedade_port_dar_har_tighe" placeholder="">
                                </div>
                                
                                
                            </div>
                        </fieldset>
                        <div class="text-right">
                            <button type="submit" name="send_noe_terminal" class="btn btn-primary">ارسال <i class="icon-paperplane ml-2"></i></button>
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