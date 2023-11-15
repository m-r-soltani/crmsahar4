<!-- Content area -->
<div class="content">
    <!-- Main charts -->

    <!-- /main charts -->


    <!-- Dashboard content -->
    <!-- /dashboard content -->
    <?php
if (Helper::Login_Just_Check()) {
    switch ($_SESSION['user_type']) {
        case __ADMINUSERTYPE__:
        case __ADMINOPERATORUSERTYPE__:
        case __MODIRUSERTYPE__:
        case __MODIR2USERTYPE__:
        case __OPERATORUSERTYPE__:
        case __OPERATOR2USERTYPE__:
            ?>
            <div class="row">
                <div class="col-sm-7" id="internet_section_summary">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <legend class="font-size-sm font-weight-bold" style="padding: 10px;text-align: center">Internet
                                    Information</legend>
                                <table class="table text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>عنوان</th>
                                            <th>تعداد</th>
                                            <th class="text-center" style="width: 20px;">مشاهده</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><span class="badge bg-success">کاربران آنلاین</span></td>
                                            <td><span class="text-default font-weight-semibold"
                                                    id="online_user_count_internet"></span></td>
                                            <td class="text-center">
                                                <div class="list-icons">
                                                    <div class="list-icons-item dropdown">
                                                        <a href="#" class="list-icons-item dropdown-toggle caret-0"
                                                            data-toggle="dropdown"><i class="icon-menu7"></i></a>
                                                        <div class="dropdown-menu">
                                                            <a href="administration_online_report" class="dropdown-item"
                                                                id="dashboard_view_online_users_internet"><i
                                                                    class="icon-file-stats"></i> نمایش کاربران آنلاین</a>
                                                            <div class="dropdown-divider"></div>
                                                            <a href="#" class="dropdown-item"><i class="icon-gear"></i>
                                                                تنظیمات</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span class="badge bg-danger">کاربران Expire شده</span></td>
                                            <td><span class="text-default font-weight-semibold"
                                                    id="expired_user_count_internet"></span></td>
                                            <td class="text-center">
                                                <div class="list-icons">
                                                    <div class="list-icons-item dropdown">
                                                        <a href="#" class="list-icons-item dropdown-toggle caret-0"
                                                            data-toggle="dropdown"><i class="icon-menu7"></i></a>
                                                        <div class="dropdown-menu">
                                                            <a href="administration_connection_log" class="dropdown-item"
                                                                id="dashboard_view_expired_users"><i
                                                                    class="icon-file-stats"></i> نمایش کاربران منقضی شده</a>
                                                            <div class="dropdown-divider"></div>
                                                            <a href="#" class="dropdown-item"><i class="icon-gear"></i>
                                                                تنظیمات</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span class="badge bg-warning">کاربران در حال Expire</span></td>
                                            <td><span class="text-default font-weight-semibold"
                                                    id="seven_days_expired_user_count_internet"></span></td>
                                            <td class="text-center">
                                                <div class="list-icons">
                                                    <div class="list-icons-item dropdown">
                                                        <a href="#" class="list-icons-item dropdown-toggle caret-0"
                                                            data-toggle="dropdown"><i class="icon-menu7"></i></a>
                                                        <div class="dropdown-menu">
                                                            <a href="administration_connection_log" class="dropdown-item"
                                                                id="dashboard_view_internet_near_expire_users"><i
                                                                    class="icon-file-stats"></i> نمایش کاربران در حال انثا</a>
                                                            <div class="dropdown-divider"></div>
                                                            <a href="#" class="dropdown-item"><i class="icon-gear"></i>
                                                                تنظیمات</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center">
                                <canvas id="basic" style="height: 90% !important;width: 90% !important;margin: auto"></canvas>
                            </div>
                            <div class="text-center">

                                <h6 class="font-weight-semibold"><i class="icon-calendar3 icon-1x"></i> تاریخ امروز:</h6>
                                <p class="mb-3" id="today_date"></p>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-sm-7">
                    <div class="card">
                        <div class="card-body" id="voip_section_summary">
                            <div class="table-responsive">
                                <legend class="font-size-sm font-weight-bold" style="padding: 10px;text-align: center">Voip
                                    Information
                                </legend>
                                <table class="table text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>عنوان</th>
                                            <th>تعداد</th>
                                            <th class="text-center" style="width: 20px;">مشاهده</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><span class="badge bg-success">کاربران آنلاین</span></td>
                                            <td><span class="text-default font-weight-semibold"
                                                    id="online_user_count_voip"></span></td>
                                            <td class="text-center">
                                                <div class="list-icons">
                                                    <div class="list-icons-item dropdown">
                                                        <a href="#" class="list-icons-item dropdown-toggle caret-0"
                                                            data-toggle="dropdown"><i class="icon-menu7"></i></a>
                                                        <div class="dropdown-menu">
                                                            <a href="administration_online_report" class="dropdown-item"
                                                                id="dashboard_view_online_users_voip"><i
                                                                    class="icon-file-stats"></i> نمایش کاربران آنلاین</a>
                                                            <div class="dropdown-divider"></div>
                                                            <a href="#" class="dropdown-item"><i class="icon-gear"></i>
                                                                تنظیمات</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span class="badge bg-danger">کاربران Expire شده</span></td>
                                            <td><span class="text-default font-weight-semibold"
                                                    id="expired_user_count_voip"></span>
                                            </td>
                                            <td class="text-center">
                                                <div class="list-icons">
                                                    <div class="list-icons-item dropdown">
                                                        <a href="#" class="list-icons-item dropdown-toggle caret-0"
                                                            data-toggle="dropdown"><i class="icon-menu7"></i></a>
                                                        <div class="dropdown-menu">
                                                            <a href="administration_connection_log" class="dropdown-item"
                                                                id="dashboard_view_expired_users_voip"><i
                                                                    class="icon-file-stats"></i> نمایش کاربران منقضی شده</a>
                                                            <div class="dropdown-divider"></div>
                                                            <a href="#" class="dropdown-item"><i class="icon-gear"></i>
                                                                تنظیمات</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span class="badge bg-warning">کاربران در حال Expire</span></td>
                                            <td><span class="text-default font-weight-semibold"
                                                    id="seven_days_expired_user_count_voip"></span></td>
                                            <td class="text-center">
                                                <div class="list-icons">
                                                    <div class="list-icons-item dropdown">
                                                        <a href="#" class="list-icons-item dropdown-toggle caret-0"
                                                            data-toggle="dropdown"><i class="icon-menu7"></i></a>
                                                        <div class="dropdown-menu">
                                                            <a href="administration_connection_log" class="dropdown-item"
                                                                id="dashboard_view_internet_near_expire_users"><i
                                                                    class="icon-file-stats"></i> نمایش کاربران در حال انقضا</a>
                                                            <div class="dropdown-divider"></div>
                                                            <a href="#" class="dropdown-item"><i class="icon-gear"></i>
                                                                تنظیمات</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="card-img-actions d-inline-block mb-3">
                                <img class="img-fluid rounded-circle"
                                    src="<?php echo __ROOT__ . 'public/images/user-picture.png' ?>" width="170" height="170"
                                    alt="">
                                <div class="card-img-actions-overlay card-img rounded-circle">
                                    <a href="#"
                                        class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round">
                                        <i class="icon-plus3"></i>
                                    </a>
                                    <a href="user_pages_profile.html"
                                        class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round ml-2">
                                        <i class="icon-link"></i>
                                    </a>
                                </div>
                            </div>

                            <h6 class="font-weight-semibold mb-0">
                                <?php echo 'نام: ';
                    echo $_SESSION['name'] . ' ' . $_SESSION['name_khanevadegi']; ?></h6>
                            <h6 class="font-weight-semibold mb-0"><?php echo 'نام شرکت: ';
                    echo $_SESSION['name_branch']; ?></h6>
                            <h6 class="font-weight-semibold mb-0"><?php echo 'سمت سازمانی : ';
                    echo $_SESSION['semat'];
                    echo '<script>var semat="' . $_SESSION["semat"] . '"</script>'; ?>
                            </h6>

                        </div>

                        <div class="card-footer d-flex justify-content-around text-center p-0">
                            <!-- <a href="#" class="list-icons-item flex-fill p-2" data-popup="tooltip" data-container="body" title="" data-original-title="Google Drive">
                                            <i class="icon-google-drive top-0"></i>
                                        </a>
                                        <a href="#" class="list-icons-item flex-fill p-2" data-popup="tooltip" data-container="body" title="" data-original-title="Twitter">
                                            <i class="icon-twitter top-0"></i>
                                        </a>
                                        <a href="#" class="list-icons-item flex-fill p-2" data-popup="tooltip" data-container="body" title="" data-original-title="Github">
                                            <i class="icon-github top-0"></i>
                                        </a>
                                        <a href="#" class="list-icons-item flex-fill p-2" data-popup="tooltip" data-container="body" title="" data-original-title="Dribbble">
                                            <i class="icon-dribbble top-0"></i>
                                        </a> -->
                        </div>
                    </div>


                </div>
            </div>
        <?php
        break;
        case __MOSHTARAKUSERTYPE__:
            ?>
            <div class="row">
                <div class="col-sm-7" id="internet_section_summary">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <legend class="font-size-sm font-weight-bold" style="padding: 10px;text-align: center">
                                    اطلاعات کاربر</legend>
                                <table class="table text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>عنوان</th>
                                            <th>توضیحات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><span class="badge bg-warning">وضعیت احراز هویت</span></td>
                                            <td><span class="text-default font-weight-semibold"
                                                    id="subscriber_ehraze_hoviat"></span></td>
                                            <!-- <td class="text-center">
                                            <div class="list-icons">
                                                <div class="list-icons-item dropdown">
                                                    <a href="#" class="list-icons-item dropdown-toggle caret-0"
                                                        data-toggle="dropdown"><i class="icon-menu7"></i></a>
                                                    <div class="dropdown-menu">
                                                        <a href="#" class="dropdown-item"
                                                            id="dashboard_view_online_users_internet"><i
                                                                class="icon-file-stats"></i> نمایش گزارش کاربری</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a href="#" class="dropdown-item"><i class="icon-gear"></i>
                                                            تنظیمات</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td> -->
                                        </tr>
                                        <tr>
                                            <td><span class="badge bg-primary" >وضعیت حساب کاربری</span></td>
                                            <td><span class="text-default font-weight-semibold"
                                                    id="subscriber_vaziate_hesabe_karbari">فعال</span></td>
                                            <!-- <td class="text-center">
                                            <div class="list-icons">
                                                <div class="list-icons-item dropdown">
                                                    <a href="#" class="list-icons-item dropdown-toggle caret-0"
                                                        data-toggle="dropdown"><i class="icon-menu7"></i></a>
                                                    <div class="dropdown-menu">
                                                        <a href="#" class="dropdown-item"
                                                            id="dashboard_view_internet_near_expire_users"><i
                                                                class="icon-file-stats"></i> نمایش کاربران در حال انثا</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a href="#" class="dropdown-item"><i class="icon-gear"></i>
                                                            تنظیمات</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td> -->
                                        </tr>
                                        <tr>
                                            <td><span class="badge bg-primary">اعتبار مالی</span></td>
                                            <td><span class="text-default font-weight-semibold"
                                                    id="subscriber_etebare_mali"></span></td>
                                            <!-- <td class="text-center">
                                            <div class="list-icons">
                                                <div class="list-icons-item dropdown">
                                                    <a href="#" class="list-icons-item dropdown-toggle caret-0"
                                                        data-toggle="dropdown"><i class="icon-menu7"></i></a>
                                                    <div class="dropdown-menu">
                                                        <a href="#" class="dropdown-item"
                                                            id="dashboard_view_internet_near_expire_users"><i
                                                                class="icon-file-stats"></i> نمایش کاربران در حال انثا</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a href="#" class="dropdown-item"><i class="icon-gear"></i>
                                                            تنظیمات</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td> -->
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-5">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center">
                                <canvas id="basic"
                                    style="height: 90% !important;width: 90% !important;margin: auto"></canvas>
                            </div>
                            <div class="text-center">

                                <h6 class="font-weight-semibold"><i class="icon-calendar3 icon-1x"></i> تاریخ امروز:</h6>
                                <p class="mb-3" id="today_date"></p>

                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <div class="row">
                <div class="col-sm-7" id="services_section_summary">
                    <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <legend class="font-size-sm font-weight-bold" style="padding: 10px;text-align: center">
                                سرویس ها</legend>
                            <table class="table text-nowrap">
                                <thead>
                                    <tr>
                                        <th>نام کاربری</th>
                                        <th>نوع سرویس</th>
                                        <th>زمان اتمام</th>
                                        <th>مانده اعتبار</th>
                                    </tr>
                                </thead>
                                <tbody id="services_tbody">
                                                   
                                </tbody>
                            </table>
                        </div>
                    </div>
        </div>
                </div>



                <div class="col-sm-5">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="card-img-actions d-inline-block mb-3">
                                <img class="img-fluid rounded-circle"
                                    src="<?php echo __ROOT__ . 'public/images/user-picture.png' ?>" width="170" height="170"
                                    alt="">
                                <div class="card-img-actions-overlay card-img rounded-circle">
                                    <a href="#"
                                        class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round">
                                        <i class="icon-plus3"></i>
                                    </a>
                                    <a href="user_pages_profile.html"
                                        class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round ml-2">
                                        <i class="icon-link"></i>
                                    </a>
                                </div>
                            </div>
                            <h6 class="font-weight-semibold mb-0">
                                <?php echo 'نام: ';
                echo $_SESSION['name'] . ' ' . $_SESSION['name_khanevadegi']; ?></h6>
                            <h6 class="font-weight-semibold mb-0"><?php echo 'نام شرکت: ';
                echo $_SESSION['name_branch']; ?></h6>
                            <h6 class="font-weight-semibold mb-0"><?php echo 'سمت سازمانی : ';
                echo $_SESSION['semat'];
                echo '<script>var semat="' . $_SESSION["semat"] . '"</script>'; ?>
                            </h6>
                        </div>
                        <div class="card-footer d-flex justify-content-around text-center p-0">
                            <!-- <a href="#" class="list-icons-item flex-fill p-2" data-popup="tooltip" data-container="body" title="" data-original-title="Google Drive">
                                            <i class="icon-google-drive top-0"></i>
                                        </a>
                                        <a href="#" class="list-icons-item flex-fill p-2" data-popup="tooltip" data-container="body" title="" data-original-title="Twitter">
                                            <i class="icon-twitter top-0"></i>
                                        </a>
                                        <a href="#" class="list-icons-item flex-fill p-2" data-popup="tooltip" data-container="body" title="" data-original-title="Github">
                                            <i class="icon-github top-0"></i>
                                        </a>
                                        <a href="#" class="list-icons-item flex-fill p-2" data-popup="tooltip" data-container="body" title="" data-original-title="Dribbble">
                                            <i class="icon-dribbble top-0"></i>
                                        </a> -->
                        </div>
                    </div>
                </div>
            </div>
        <?php
break;

        default:
            die(Helper::Json_Message('af'));
            break;
    }
} else {
    die(Helper::Json_Message('af'));
}

?>



    </div>

    <!-- /content area -->