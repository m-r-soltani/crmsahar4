<!-- Content area -->
<div class="content">
    <!-- Form inputs -->
    <div class="card">
        <div class="card-body">
            <form action="" method="POST">
                <fieldset class="mb-3">
                    <legend class="text-uppercase font-size-sm font-weight-bold">Wireless-AP</legend>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">تاریخ ثبت بهره برداری</label>
                        <div class="col-lg-4">
                            <input type="hidden" id="id" class="form-control" name="id" value="empty">
                            <input type="text" class="form-control usage" name="tarikhe_sabt" id="tarikhe_sabt"
                                   placeholder="مثال: 12/12/1350" required>
                        </div>
                        
                        <label class="col-form-label col-lg-2">تاریخ پایان بهره برداری</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control usage" name="tarikhe_payan" id="tarikhe_payan"
                                   placeholder="مثال: 12/12/1350" required>
                        </div>
                        
                        <label class="col-form-label col-lg-2">استان</label>
                        <div class="col-lg-4">
                            <select class="form-control form-control-lg custom_select" name="ostan" id="ostan" required>

                            </select>
                        </div>
                        
                        <label class="col-form-label col-lg-2">شهر</label>
                        <div class="col-lg-4">
                            <select class="form-control form-control-lg custom_select" name="shahr" id="shahr" required>

                            </select>
                        </div>
                        
                        <label class="col-form-label col-lg-2">نام دکل/ایستگاه</label>
                        <div class="col-lg-4">
                            <select class="form-control form-control-lg custom_select" name="popsite" id="popsite" required>
                            </select>
                        </div>
                        
                        <label class="col-form-label col-lg-2">نام لینک</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" maxlength="40" name="link_name" id="link_name" placeholder="مثال: نام دلخواه خود را وارد کنید" required>
                        </div>
                        <label class="col-form-label col-lg-2">SSID</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" name="ssid" id="ssid"
                                   placeholder="1009539DC822001" required>
                        </div>
                        
                        <label class="col-form-label col-lg-2">نشانی</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" name="address" id="address">
                        </div>
                        
                        <label class="col-form-label col-lg-2">ارتفاع ساختمان</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="ertefae_sakhteman" id="ertefae_sakhteman"
                                   placeholder="مثال: 20 متر">
                        </div>
                        
                        <label class="col-form-label col-lg-2">ارتفاع دکل</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="ertefae_dakal" id="ertefae_dakal"
                                   placeholder="مثال: 20 متر">
                        </div>
                        
                        <label class="col-form-label col-lg-2">طول جغرافیایی (E)</label>
                        <div class="col-lg-4">
                            <input type="text" step="any" class="form-control" name="tol_joghrafiai" id="tol_joghrafiai">
                        </div>
                        
                        <label class="col-form-label col-lg-2">عرض جغرافیایی (N)</label>
                        <div class="col-lg-4">
                            <input type="text" step="any" class="form-control" name="arz_joghrafiai" id="arz_joghrafiai">
                        </div>
                        
                        <label class="col-form-label col-lg-2">بهره آنتن(dbi)</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="bahre_anten" id="bahre_anten"
                                   placeholder="مثال: 27 ">
                        </div>
                        
                        <label class="col-form-label col-lg-2">شماره سریال دستگاه</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="shomare_seriale_dastgah"
                                   id="shomare_seriale_dastgah" placeholder="مثال: 831207D90E6">
                        </div>
                        
                        <label class="col-form-label col-lg-2">نوع لینک</label>
                        <div class="col-lg-4">
                            <select class="form-control form-control-lg custom_select" name="noe_link"
                                    id="noe_link" required>
                                <option value="ptp">PTP</option>
                                <option value="ptmp">PTMP</option>

                            </select>
                        </div>
                        
                        <label class="col-form-label col-lg-2">تکه باند فرکانسی</label>
                        <div class="col-lg-4">
                            <select class="form-control form-control-lg custom_select" name="teke_bande_ferekansi"
                                    id="teke_bande_ferekansi">
                                <option value="5470-5725-Mhz">5470-5725-Mhz</option>
                                <option value="5725-5850-Mhz">5725-5850-Mhz</option>
                                <option value="5250-5350-Mhz">5250-5350-Mhz</option>
                                <option value="2400-2483/5-Mhz">2400-2483/5-Mhz</option>

                            </select>
                        </div>
                        
                        <label class="col-form-label col-lg-2">حداکثر توان خروجی دستگاه فرستنده</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="hadeaxar_tavane_khoroji_ferestande"
                                   id="hadeaxar_tavane_khoroji_ferestande"
                                   placeholder="مثال: mW">
                        </div>
                        
                        <label class="col-form-label col-lg-2">مارک دستگاه</label>
                        <div class="col-lg-4">
                            <select class="form-control form-control-lg custom_select" name="marke_dastgah" id="marke_dastgah" required>
                            </select>
                        </div>
                        
                        <label class="col-form-label col-lg-2">مدل دستگاه</label>
                        <div class="col-lg-4">
                            <select class="form-control form-control-lg custom_select" name="modele_dastgah" id="modele_dastgah" required>
                            </select>
                        </div>
                        
                        <label class="col-form-label col-lg-2">Software</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="software" id="software"
                                   placeholder="مثال: winbox">
                        </div>
                        
                        <label class="col-form-label col-lg-2">IP Address</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="ip_address" id="ip_address"
                                   placeholder="مثال: 192.168.1.1">
                        </div>
                        
                        <label class="col-form-label col-lg-2">Port</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="port" id="port"
                                   placeholder="مثال: 80">
                        </div>
                        
                        <label class="col-form-label col-lg-2">username</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="username" id="username"
                                   placeholder="مثال: Mohammad">
                        </div>
                        
                        <label class="col-form-label col-lg-2">password</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="password" id="password" placeholder="">
                        </div>
                    </div>
                </fieldset>
                <div class="text-right">
                    <button type="submit" name="send_wireless_ap" class="btn btn-primary">ارسال <i
                                class="icon-paperplane ml-2"></i></button>
                </div>
            </form>
        </div>
    </div>
    <!-- /form inputs -->
    <div class="card">
        <div class="col-md-12">
            <button name="delete" class="btn btn-warning col-md-auto float-md-right" id="delete">حذف<i
                        class="icon-folder-remove ml-2"></i></button>
            <button name="edit" class="btn btn-primary col-md-auto float-md-right" id="edit">ویرایش<i
                        class="icon-database-edit2 ml-2"></i></button>
            <table id="view_table" class="table table-striped datatable-responsive table-hover">
            </table>
        </div>
    </div>
</div>
<!-- /content area -->