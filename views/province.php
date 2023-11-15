        <!-- Content area -->
        <div class="content">
            <!-- Form inputs -->
            <div class="card">
                <div class="card-body">
                    <form action="#" method="POST">
                        <fieldset class="mb-3">
                            <legend class="text-uppercase font-size-sm font-weight-bold">استان</legend>
                            <div class="form-group row">
                            <input type="hidden" id="id" class="form-control" name="id" value="empty">
                                <label class="col-form-label col-lg-2">کشور</label>
                                <div class="col-lg-10">
                                    <select class="form-control form-control-lg custom_select" required name="country_id" id="country_id">
                                    </select>
                                </div>
                                <label class="col-form-label col-lg-2">نام استان</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="name" id="name" placeholder="مثال: تهران">
                                </div>
                                
                                <label class="col-form-label col-lg-2">پیش شماره استان</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="pish_shomare_ostan" id="pish_shomare_ostan" placeholder="مثال: 021">
                                </div>
                                
                                <label class="col-form-label col-lg-2">کد شاهکار</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="code_ostan_shahkar" id="code_ostan_shahkar" placeholder="مثال: ورود اطلاعات">

                                </div>
                                <label class="col-form-label col-lg-2">کد مرکز استان</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="code_markazeostan" id="code_markazeostan" placeholder="مثال: ورود اطلاعات">

                                </div>
                                <label class="col-form-label col-lg-2">کداطراف مرکز استان</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="code_atrafemarkazeostan" id="code_atrafemarkazeostan" placeholder="مثال: ورود اطلاعات">

                                </div>
                                <label class="col-form-label col-lg-2">کد بیابان</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="code_biaban" id="code_biaban" placeholder="مثال: ورود اطلاعات">

                                </div>
                                <label class="col-form-label col-lg-2">کد شهرستان</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="code_shahrestan" id="code_shahrestan" placeholder="مثال: ورود اطلاعات">

                                </div>
                                <label class="col-form-label col-lg-2">کداطراف شهرستان</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="code_atrafeshahrestan" id="code_atrafeshahrestan" placeholder="مثال: ورود اطلاعات">

                                </div>
                            </div>
                        </fieldset>
                        <div class="text-right">
                            <button type="submit" name="send_province" class="btn btn-primary">ارسال <i class="icon-paperplane ml-2"></i></button>
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