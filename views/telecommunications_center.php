        <!-- Content area -->
        <div class="content">

            <!-- Form inputs -->
            <div class="card">
                <div class="card-body">
                    <form action="" method="POST" name="telecommunications_center_form">
                        <fieldset class="mb-3">
                            <legend class="text-uppercase font-size-sm font-weight-bold">مراکز مخابراتی</legend>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">نام مرکز مخابراتی</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="name" id="name" placeholder="مثال: تهران">
                                    <input type="hidden" id="id" name="id" class="form-control" value="empty">
                                </div>
                                
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
                                
                                <label class="col-form-label col-lg-2">پیش شماره استان</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="pish_shomare_ostan" id="pish_shomare_ostan" placeholder="مثال: 021">
                                </div>
                                
                                <label class="col-form-label col-lg-2">تعداد پیش شماره</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="tedade_pish_shomare" id="tedade_pish_shomare" placeholder="مثال: 10">
                                </div>
                                
                                <label class="col-form-label col-lg-2">شماره تماس با مرکز</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="shomare_tamas_markaz" id="shomare_tamas_markaz" placeholder="مثال: 1234567">
                                </div>
                                
                                <label class="col-form-label col-lg-2">شماره تماس MDF مرکز</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="shomare_tamas_mdf" id="shomare_tamas_mdf" placeholder="مثال: 021">
                                </div>
                                
                                <label class="col-form-label col-lg-2">مسیر اول فاکتورهای مرکز</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="masire_avale_faktorha" id="masire_avale_faktorha" placeholder="مثال: 021">
                                </div>
                                
                                <label class="col-form-label col-lg-2">مسیر دوم فاکتورهای مرکز</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="masire_dovome_faktorha" id="masire_dovome_faktorha" placeholder="مثال: 021">
                                </div>
                                
                                <label class="col-form-label col-lg-2">میزبان</label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom_select" name="mizban" id="mizban">

                                    </select>
                                </div>
                                
                                <label class="col-form-label col-lg-2">نوع قرار داد</label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom_select" name="noe_gharardad" id="noe_gharardad">
                                    </select>
                                </div>
                                
                                <label class="col-form-label col-lg-2">ip ppoe server</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="ip_ppoe_server" id="ip_ppoe_server" placeholder="ip ppoe server">
                                </div>
                                
                                <label class="col-form-label col-lg-2">user ppoe server</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="user_ppoe_server" id="user_ppoe_server" placeholder="user ppoe server">
                                </div>
                                
                                <label class="col-form-label col-lg-2">password ppoe server</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="password_ppoe_server" id="password_ppoe_server" placeholder="password ppoe server">
                                </div>
                                
                                <label class="col-form-label col-lg-2">snmp ppoe server</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="snmp_ppoe_server" id="snmp_ppoe_server" placeholder="snmp ppoe server">
                                </div>
                                
                                <div class="col-lg-6">
                                </div>
                                <label class="col-form-label col-lg-2">نشانی مرکز</label>
                                <div class="col-lg-10" id="before_pre_num">
                                    <input type="text" class="form-control" name="address" id="address" placeholder="مثال: 021">
                                </div>
                            </div>
                        </fieldset>
                        <div class="text-right">
                            <button type="submit" name="send_telecommunications_center" class="btn btn-primary">ارسال <i class="icon-paperplane ml-2"></i></button>
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