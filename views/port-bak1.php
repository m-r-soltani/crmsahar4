        <!-- Content area -->
        <div class="content">

            <!-- Form inputs -->
            <div class="card">
                <div class="card-body">
                    <form action="" method="POST">
                        <fieldset class="mb-3">
                            <legend class="text-uppercase font-size-sm font-weight-bold">ثبت ترمینال</legend>
                            <div class="form-group row">
                                <input type="hidden" id="id" class="form-control" name="id" value="empty">
                                <label class="col-form-label col-lg-2">ترمینال</label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom_select" name="terminal" id="terminal">
                                    </select>
                                </div>
                                <br><br>
                                <label class="col-form-label col-lg-2">اتصال</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="etesal" id="etesal" placeholder="اتصال">
                                </div>
                                <br><br>
                                <label class="col-form-label col-lg-2">ردیف</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="radif" id="radif" placeholder="ردیف">
                                </div>
                                <br><br>
                                <label class="col-form-label col-lg-2">تیغه</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="tighe" id="tighe" placeholder="تیغه">
                                </div>
                                <br><br>
                                <label class="col-form-label col-lg-2">پورت</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="port" id="port" placeholder="پورت">
                                </div>
                                <br><br>
                                <label class="col-form-label col-lg-2">کارت</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="kart" id="kart" placeholder="کارت">
                                </div>
                                <br><br>
                                <label class="col-form-label col-lg-2">نوع</label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom_select" name="adsl_vdsl" id="adsl_vdsl">
                                        <option value="adsl">ADSL</option>
                                        <option value="vdsl">VDSL</option>
                                    </select>
                                </div>
                                <br><br>
                                <label class="col-form-label col-lg-2">وضعیت</label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom_select" name="status" id="status">
                                        <option value="salem">سالم</option>
                                        <option value="kharab">خراب</option>
                                    </select>
                                </div>
                                <br><br>
                                <label class="col-form-label col-lg-2">dslam</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="dslam" id="dslam" placeholder="dslam">
                                </div>
                                <br><br>
                                <label class="col-form-label col-lg-2">تلفن</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="telephone" id="telephone" placeholder="پورت">
                                </div>
                                <br><br>
                            </div>
                        </fieldset>
                        <div class="text-right">
                            <button type="submit" name="send_port" class="btn btn-primary">ارسال <i class="icon-paperplane ml-2"></i></button>
                            <span class=""></span>
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