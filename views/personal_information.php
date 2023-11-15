<?php
if(Helper::Login_Just_Check()){
    switch ($_SESSION['user_type']) {
        case '1':
        case '2':
        case '3':
        case '4':
            echo Helper::Alert_Message('af');
            break;
        case '5':
            switch ($_SESSION['subscriber_type']) {
                case 'real':
                    ?>
                    
        <!-- Content area -->
        <div class="content">
            <!-- Form inputs -->
            <div class="card">


                <div class="card-body">

                    <form action="#" method="POST" enctype="multipart/form-data">
                        <fieldset class="mb-3">
                            <legend class="text-uppercase font-size-sm font-weight-bold">مشترکین حقیقی</legend>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">نام</label>
                                <div class="col-lg-4">
                                    <input type="hidden" id="id" class="form-control" name="id" value="empty">
                                    <input type="hidden" id="noe_moshtarak" name="noe_moshtarak" class="form-control"  value="real">
                                    <input type="text" class="form-control" name="name" id="name" placeholder="">
                                </div>
                                
                                <label class="col-form-label col-lg-2">نام خانوادگی</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="f_name" id="f_name" placeholder="">
                                </div>
                                
                                <label class="col-form-label col-lg-2">نام پدر</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="name_pedar" id="name_pedar" placeholder="">
                                </div>
                                
                                <label class="col-form-label col-lg-2">ملیت</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="meliat" id="meliat" placeholder="">
                                </div>
                                
                                <label class="col-form-label col-lg-2">تابعیت</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control usage" name="tabeiat" id="tabeiat" placeholder="">
                                </div>
                                
                                <label class="col-form-label col-lg-2">شماره شناسنامه</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control usage" name="shomare_shenasname" id="shomare_shenasname" placeholder="">
                                </div>
                                
                                <label class="col-form-label col-lg-2">کد ملی / شناسه هویتی</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control usage" name="code_meli" id="code_meli" placeholder="">
                                </div>
                                
                                <label class="col-form-label col-lg-2">نوع شناسه هویتی</label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom_select" name="noe_shenase_hoviati" id="noe_shenase_hoviati">
                                        <option value="code_meli">کد ملی</option>
                                        <option value="passport">پاسپورت</option>
                                        <option value="karte_do_tabeiati">کارت دو تابعیتی</option>
                                        <option value="karte_panahandegi">کارت پاهندگی</option>
                                        <option value="karte_hoviat">کارت هویت</option>
                                    </select>
                                </div>
                                                                                                
                                <label class="col-form-label col-lg-2">تاریخ تولد</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control usage" name="tarikhe_tavalod" id="tarikhe_tavalod" placeholder="مثال: 12/12/1350">
                                </div>
                                
                                <label class="col-form-label col-lg-2">جنسیت</label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom_select" id="jensiat" name="jensiat">
                                        <option value="mard">مرد</option>
                                        <option value="zan">زن</option>
                                    </select>
                                </div>
                                
                                <label class="col-form-label col-lg-2">استان محل تولد</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control usage" name="ostane_tavalod" id="ostane_tavalod" placeholder="">
                                </div>
                                
                                <label class="col-form-label col-lg-2">شهر محل تولد</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control usage" name="shahre_tavalod" id="shahre_tavalod" placeholder="">
                                </div>
                                
                                <label class="col-form-label col-lg-2">تلفن ۱</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="telephone1" id="telephone1" placeholder="مثال: 222345677">
                                </div>
                                
                                <label class="col-form-label col-lg-2">کدپستی ۱</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="code_posti1" id="code_posti1" placeholder="مثال: www.saharertebat.net">
                                </div>
                                
                                <label class="col-form-label col-lg-2">آدرس ۱</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="address1" id="address1" placeholder="مثال: www.saharertebat.net">
                                </div>
                                
                                <label class="col-form-label col-lg-2">تلفن ۲</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="telephone2" id="telephone2" placeholder="مثال: 222345678">
                                </div>
                                
                                <label class="col-form-label col-lg-2">کدپستی ۲</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="code_posti2" id="code_posti2" placeholder="مثال: www.saharertebat.net">
                                </div>
                                
                                <label class="col-form-label col-lg-2">آدرس ۲</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="address2" id="address2" placeholder="مثال: www.saharertebat.net">
                                </div>
                                
                                <label class="col-form-label col-lg-2">تلفن ۳</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="telephone3" id="telephone3" placeholder="مثال: 222345679">
                                </div>
                                
                                <label class="col-form-label col-lg-2">کدپستی ۳</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="code_posti3" id="code_posti3" placeholder="مثال: www.saharertebat.net">
                                </div>
                                
                                <label class="col-form-label col-lg-2">آدرس ۳</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="address3" id="address3" placeholder="مثال: www.saharertebat.net">
                                </div>
                                
                                <label class="col-form-label col-lg-2">فکس</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="fax" id="fax" placeholder="">
                                </div>
                                
                                <label class="col-form-label col-lg-2">تلفن همراه</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="telephone_hamrah" id="telephone_hamrah" placeholder="مثال: 09121234567">
                                </div>
                                
                                <label class="col-form-label col-lg-2">پست الکترونیک</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" id="email" name="email" placeholder="مثال: abcd@gmail.com">
                                </div>
                                
                                
                                <label class="col-form-label col-lg-2">وب سایت</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="website" id="website" placeholder="مثال: www.saharertebat.net">
                                </div>
                                

                                <label class="col-form-label col-lg-2">شغل</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="shoghl" id="shoghl" placeholder="مثال: www.saharertebat.net">
                                </div>
                                
                                <label class="col-form-label col-lg-2">معرف</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="moaref" id="moaref" placeholder="مثال: www.saharertebat.net">
                                </div>
                                                                                                
                                <label class="col-form-label col-lg-2">نحوه آشنایی</label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom_select" name="nahve_ashnai_campain" id="nahve_ashnai_campain">
                                    </select>
                                </div>
                                
                                <label class="col-form-label col-lg-2">گروه مشترک</label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom_select" name="gorohe_moshtarak" id="gorohe_moshtarak">
                                    </select>
                                </div>
                                                                
                                <label class="col-form-label col-lg-2">توضیحات</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="tozihat" id="tozihat" placeholder="مثال: www.saharertebat.net">
                                </div>
                                
                                <label class="col-form-label col-lg-2">تصویر کارت ملی</label>
                                <div class="col-lg-4" id="link_r_t_karte_meli">
                                    
                                </div>
                                
                                <label class="col-form-label col-lg-2">تصویر قبض تلفن</label>
                                <div class="col-lg-4" id="link_r_t_ghabze_telephone">
                                    
                                </div>
                                
                                <label class="col-form-label col-lg-2">تصویر اجاره نامه / مالکیت</label>
                                <div class="col-lg-4" id="link_r_t_ejare_malekiat">
                                    
                                </div>
                                
                                <label class="col-form-label col-lg-2">تصویر قرارداد</label>
                                <div class="col-lg-4" id="link_r_t_gharardad">
                                    
                                </div>
                                
                                <label class="col-form-label col-lg-2">تصویر سایر</label>
                                <div class="col-lg-4" id="link_r_t_sayer">
                                    
                                </div>
                                
                            </div>
                        </fieldset>
                        
                    </form>
                </div>
            </div>
        </div>
        <!-- /content area -->



                    <?php
                    break;
                case 'legal':
                    ?>


        <!-- Content area -->
        <div class="content">

            <!-- Form inputs -->
            <div class="card">
                <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="noe_moshtarak" name="noe_moshtarak" class="form-control"  value="legal">
                    <input type="hidden" id="id" class="form-control" name="id" value="empty">
                        <fieldset class="mb-3">
                            <legend class="text-uppercase font-size-sm font-weight-bold">مشترکین حقوقی</legend>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">نام شرکت</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="name_sherkat" id="name_sherkat" placeholder="مثال: سحر ارتباط">
                                </div>
                                
                                <label class="col-form-label col-lg-2">شماره ثبت</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="shomare_sabt" id="shomare_sabt" placeholder="مثال: 12345">
                                </div>
                                
                                <label class="col-form-label col-lg-2">تاریخ ثبت</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control usage" name="tarikhe_sabt" id="tarikhe_sabt" placeholder="مثال: 12-12-1380">
                                </div>
                                
                                <label class="col-form-label col-lg-2">کد اقتصادی</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="code_eghtesadi" id="code_eghtesadi" placeholder="">
                                </div>
                                
                                

                                <label class="col-form-label col-lg-2">شناسه ملی</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="shenase_meli" id="shenase_meli" placeholder="">
                                </div>
                                
                                <div class="col-lg-6">
                                </div>
                                <label class="col-form-label col-lg-2">تلفن ۱</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="telephone1" id="telephone1" placeholder="با پیش شماره">
                                </div>
                                
                                <label class="col-form-label col-lg-2">کد پستی ۱</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="code_posti1" id="code_posti1" placeholder="">
                                </div>
                                

                                <label class="col-form-label col-lg-2">آدرس ۱</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="address1" id="address1" placeholder="">
                                </div>
                                
                                <label class="col-form-label col-lg-2">تلفن ۲</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="telephone2" id="telephone2" placeholder="با پیش شماره">
                                </div>
                                
                                <label class="col-form-label col-lg-2">کد پستی ۲</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="code_posti2" id="code_posti2" placeholder="">
                                </div>
                                
                                <label class="col-form-label col-lg-2">آدرس ۲</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="address2" id="address2" placeholder="">
                                </div>
                                
                                <label class="col-form-label col-lg-2">تلفن ۳</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="telephone3" id="telephone3" placeholder="با پیش شماره">
                                </div>
                                
                                <label class="col-form-label col-lg-2">کد پستی ۳</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="code_posti3" id="code_posti3" placeholder="">
                                </div>
                                
                                <label class="col-form-label col-lg-2">آدرس ۳</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="address3" id="address3" placeholder="">
                                </div>
                                
                                <label class="col-form-label col-lg-2">شماره داخلی</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="shomare_dakheli" id="shomare_dakheli" placeholder="مثال: 100">
                                </div>
                                
                                <label class="col-form-label col-lg-2">فکس</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="fax" id="fax" placeholder="">
                                </div>
                                
                                <label class="col-form-label col-lg-2">وب سایت</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="website" id="website" placeholder="مثال: www.saharertebat.net">
                                </div>
                                
                                <label class="col-form-label col-lg-2">پست الکترونیک</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="email" id="email" placeholder="مثال: abcd@gmail.com">
                                </div>
                                <div class="col-lg-6">
                                </div>
                                
                                <label class="col-form-label col-lg-2">نام مدیر عامل/نماینده</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="name" id="name" placeholder="مثال: محمد">
                                </div>
                                
                                <label class="col-form-label col-lg-2">نام خانوادگی مدیر عامل / نماینده</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="f_name" id="f_name" placeholder="">
                                </div>
                                
                                <label class="col-form-label col-lg-2">نام پدر عامل/نماینده</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="name_pedar" id="name_pedar" placeholder="مثال: محمد">
                                </div>
                                
                                <label class="col-form-label col-lg-2">ملیت مدیر عامل / نماینده</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="meliat" id="meliat" placeholder="مثال: ایران">
                                </div>
                                
                                <label class="col-form-label col-lg-2">تابعیت مدیر عامل / نماینده</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="tabeiat" id="tabeiat" placeholder="">
                                </div>
                                
                                <label class="col-form-label col-lg-2">شماره شناسنامه</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="shomare_shenasname" id="shomare_shenasname" placeholder="">
                                </div>
                                
                                <label class="col-form-label col-lg-2">کد ملی / شناسه هویتی</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="code_meli" id="code_meli" placeholder="">
                                </div>
                                
                                <label class="col-form-label col-lg-2">نوع شناسه هویتی</label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom_select" name="noe_shenase_hoviati" id="noe_shenase_hoviati">
                                        <option value="code_meli">کد ملی</option>
                                        <option value="passport">پاسپورت</option>
                                        <option value="karte_do_tabeiati">کارت دو تابعیتی</option>
                                        <option value="karte_panahandegi">کارت پناهندگی</option>
                                        <option value="karte_hoviat">کارت هویت</option>
                                    </select>
                                </div>
                                
                                <label class="col-form-label col-lg-2">استان محل تولد</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="ostane_tavalod" id="ostane_tavalod" placeholder="مثال: تهران">
                                </div>
                                
                                <label class="col-form-label col-lg-2">شهر محل تولد</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="shahre_tavalod" id="shahre_tavalod" placeholder="مثال: تهران">
                                </div>
                                <label class="col-form-label col-lg-2">تاریخ تولد مدیر عامل / نماینده</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control usage" name="tarikhe_tavalod" id="tarikhe_tavalod" placeholder="مثال: 12/12/1350">
                                </div>
                                <label class="col-form-label col-lg-2">نام پدر مدیر عامل / نماینده</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control usage" name="name_pedare" id="name_pedare" placeholder="">
                                </div>
                                
                                <label class="col-form-label col-lg-2">جنسیت مدیر عامل / نماینده</label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom_select" name="jensiat" id="jensiat">
                                        <option value="man">مرد</option>
                                        <option value="woman">زن</option>
                                    </select>
                                </div>
                                
                                <label class="col-form-label col-lg-2">تلفن همراه</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="telephone_hamrah" id="telephone_hamrah" placeholder="مثال: 09121234567">
                                </div>
                                
                                
                                <label class="col-form-label col-lg-2">گروه مشترک</label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom_select" name="gorohe_moshtarak" id="gorohe_moshtarak">
                                    </select>
                                </div>
                                
                                
                                <label class="col-form-label col-lg-2">رشته فعالیت</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="reshteye_faaliat" id="reshteye_faaliat" placeholder="">
                                </div>
                                
                                <label class="col-form-label col-lg-2">نحوه آشنایی</label>
                                <div class="col-lg-4">
                                    <select class="form-control form-control-lg custom_select" name="nahve_ashnai" id="nahve_ashnai">
                                    </select>
                                </div>
                                
                                <label class="col-form-label col-lg-2">معرف</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="moaref" id="moaref" placeholder="">
                                </div>
                                <div class="col-lg-6">
                                </div>
                                
                                <label class="col-form-label col-lg-2">توضیحات</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="tozihat" id="tozihat" placeholder="">
                                </div>
                                
                                <label class="col-form-label col-lg-2">تصویر آگهری تاسیس</label>
                                <div class="col-lg-4" id="link_l_t_agahie_tasis">
                                </div>
                                
                                <label class="col-form-label col-lg-2">تصویر آخرین تغییرات</label>
                                <div class="col-lg-4" id="link_l_t_akharin_taghirat">
                                </div>
                                
                                <label class="col-form-label col-lg-2">تصویر کارت ملی صاحب امضای اول</label>
                                <div class="col-lg-4" id="link_l_t_saheb_kartemeli_emzaye_aval">
                                </div>
                                
                                <label class="col-form-label col-lg-2">تصویر کارت ملی صاحب امضای دوم</label>
                                <div class="col-lg-4" id="link_l_t_saheb_kartemeli_emzaye_dovom">
                                </div>
                                
                                <label class="col-form-label col-lg-2">تصویر کارت ملی نماینده</label>
                                <div class="col-lg-4" id="link_l_t_kartemeli_namayande">
                                </div>
                                
                                <label class="col-form-label col-lg-2">تصویر معرفی نامه نماینده</label>
                                <div class="col-lg-4" id="link_l_t_moarefiname_namayande">
                                </div>
                                
                                <label class="col-form-label col-lg-2">تصویر قبض تلفن</label>
                                <div class="col-lg-4" id="link_l_t_ghabze_telephone">
                                </div>
                                
                                <label class="col-form-label col-lg-2">تصویر قرارداد</label>
                                <div class="col-lg-4" id="link_l_t_gharardad">
                                </div>
                                
                                <label class="col-form-label col-lg-2">تصویر اجاره نامه / مالکیت</label>
                                <div class="col-lg-4" id="link_l_t_ejarename_malekiat">
                                </div>
                                
                                <label class="col-form-label col-lg-2">تصویر سایر</label>
                                <div class="col-lg-4" id="link_l_t_sayer">
                                </div>
                                
                            </div>
                        </fieldset>
                        
                    </form>
                </div>
            </div>
            <!-- /form inputs -->
        </div>
        <!-- /content area -->





                    <?php
                    break;
                
                default:
                echo Helper::Alert_Message('f');
                    break;
            }







            break;
        
        default:
        echo Helper::Alert_Message('af');
            break;
    }
}else echo Helper::Alert_Message('af');
?>