<?php defined('__ROOT__') or exit('No direct script access allowed');

class Login extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    //0050219022
    //0083780025
    //3358063631
    public function index()
    {
        if (isset($_POST['send_login_form'])) {
            $_POST = Helper::Create_Post_Array_Without_Key($_POST);
            $_POST = Helper::xss_check_array($_POST);
            $msg   = "درخواست ناموفق لطفا مجددا تلاش کنید";
            if (isset($_POST['g-recaptcha-response'])) {
                $captcha = $_POST['g-recaptcha-response'];
            }
            if (!$captcha) {
                die(json_encode(array('login_fail', 'msg' => 'اطلاعات ارسال شده صحیح نمیباشد در صورت تکرار آی پی شما مسدود خواهد شد.')));
            }
            $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LfBEcIZAAAAAEV3QpcrAp3-8il9mOhVWjJgpMHS&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
            $response=json_decode($response, true);
            if ($response['success'] === false) {
                die(json_encode(array('login_fail', 'msg' => 'اطلاعات ارسال شده صحیح نمیباشد در صورت تکرار آی پی شما مسدود خواهد شد.')));
            }
            try {
                $_SESSION['dashboard_menu']          = Helper::get_all_dashboard_menu();
                $_SESSION['dashboard_menu_category'] = Helper::get_all_dashboard_menu_category();
                $username                            = $_POST['username'];
                $username                            = Helper::str_trim($username);
                $password                            = $_POST['password'];
                if (Helper::Is_Empty_OR_Null($username) && Helper::Is_Empty_OR_Null($password)) {
                    $password = Helper::str_trim($password);
                    $password = Helper::str_md5($password, false);
                    $sql      = "SELECT * FROM bnm_users WHERE username=? AND password= ? AND status=? AND user_type<>'' AND user_type IS NOT NULL";
                    $res      = Db::secure_fetchall($sql, array($username, $password, 1));
                    if ($res) {
                        $_SESSION['login']          = "true";
                        $_SESSION['id']             = $res[0]['id'];
                        $_SESSION['username']       = $res[0]['username'];
                        $_SESSION['password']       = $res[0]['password'];
                        $_SESSION['user_type']      = $res[0]['user_type'];
                        $_SESSION['branch_id']      = $res[0]['branch_id'];
                        $_SESSION['user_id']        = $res[0]['user_id'];
                        $_SESSION['status']         = $res[0]['status'];
                        // die(json_encode([$_SESSION['id'], $_SESSION['user_id'],$_SESSION['username'], $_SESSION['password']]));
                        //$_SESSION['baladasti_id']   = $res[0]['baladasti_id'];
                        if (isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP'])) {
                            $_SESSION['HTTP_CLIENT_IP'] = $_SERVER['HTTP_CLIENT_IP'];
                        }
                        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                            $_SESSION['HTTP_X_FORWARDED_FOR'] = $_SERVER['HTTP_X_FORWARDED_FOR'];
                        }
                        if (isset($_SERVER['REMOTE_ADDR']) && !empty($_SERVER['REMOTE_ADDR'])) {
                            $_SESSION['REMOTE_ADDR'] = $_SERVER['REMOTE_ADDR'];
                        }
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                                # admin
                                $_SESSION['name']                       = Helper::getor_string($res[0]['name'], $_SESSION['username']);
                                $_SESSION['name_khanevadegi']           = Helper::getor_string($res[0]['name_khanevadegi'], 'Administrator');
                                $_SESSION['semat']                      = Helper::getor_string($res[0]['semat'], __OWNER__);
                                $_SESSION['name_branch']                = 'سحر ارتباط';
                                $_SESSION['baladasti_id']               = 0;
                                $_SESSION['dashboard_menu_access_list'] = array();
                                $where_menu_ids                         = "";
                                $where_category_ids                     = "";
                                ///ekhtesase dastresiha be user
                                $dashboard_access_list = Db::fetchall_Query("SELECT * FROM bnm_dashboard_menu WHERE admin_display = 1 AND id <> " . __DASHBOARDID__ . "", true);
                                $cat_ids               = Db::fetchall_Query("SELECT DISTINCT category_id FROM bnm_dashboard_menu WHERE admin_display = 1 AND id <> " . __DASHBOARDID__ . "", true);
                                for ($i = 0; $i < count($cat_ids); $i++) {
                                    if ($i == count($cat_ids) - 1) {
                                        $where_category_ids .= $cat_ids[$i]['category_id'];
                                    } else {
                                        $where_category_ids .= $cat_ids[$i]['category_id'] . ',';
                                    }
                                }
                                $_SESSION['dashboard_menu_access_list'] = Db::fetchall_Query("SELECT * FROM bnm_dashboard_menu_category WHERE id IN ($where_category_ids) ORDER BY sort");
                                if ($_SESSION['dashboard_menu_access_list']) {
                                    for ($i = 0; $i < count($_SESSION['dashboard_menu_access_list']); $i++) {
                                        $_SESSION['dashboard_menu_access_list'][$i]['sub_menu'] = array();
                                    }
                                    for ($i = 0; $i < count($_SESSION['dashboard_menu_access_list']); $i++) {
                                        for ($j = 0; $j < count($dashboard_access_list); $j++) {
                                            if ($dashboard_access_list[$j]['category_id'] == $_SESSION['dashboard_menu_access_list'][$i]['id']) {
                                                array_push($_SESSION['dashboard_menu_access_list'][$i]['sub_menu'], $dashboard_access_list[$j]);
                                            }
                                        }
                                    }
                                }
                                break;
                            case __MODIRUSERTYPE__:
                                # modir
                                if (!Helper::Is_Empty_OR_Null($_SESSION['user_id'])) {
                                    session_destroy();
                                    $msg = "اطلاعت شما کامل ثبت نشده لطفا پس از بررسی دوباره تلاش کنید.";
                                    die(json_encode(array('login_fail', 'msg' => $msg)));
                                } else {
                                    if (Helper::Is_Empty_OR_Null($_SESSION['branch_id'])) {
                                        //get branch name
                                        $sql                     = "SELECT id,name_sherkat,baladasti_id FROM bnm_branch WHERE id =?";
                                        $res                     = Db::secure_fetchall($sql, array($_SESSION['branch_id']));
                                        $_SESSION['baladasti_id'] = $res[0]['baladasti_id'];
                                        $_SESSION['name_branch'] = Helper::getor_string($res[0]['name_sherkat'], 'نامشخص');
                                        //ekhtesase subscriber / modir name & family
                                        $sql                          = "SELECT id, name, name_khanevadegi,semat FROM bnm_operator WHERE id = ? AND user_type = ?";
                                        $res                          = Db::secure_fetchall($sql, array($_SESSION['user_id'], __MODIRUSERTYPE__));
                                        if (!$res) {
                                            die(json_encode(array('login_fail', 'msg' => $msg)));
                                        }
                                        $_SESSION['name']             = Helper::getor_string($res[0]['name'], 'مدیر');
                                        $_SESSION['name_khanevadegi'] = Helper::getor_string($res[0]['name_khanevadegi'], 'مدیر');
                                        if (Helper::Is_Empty_OR_Null($res[0]['semat'])) {
                                            $sql               = "SELECT * FROM bnm_organization_level WHERE id = ?";
                                            $semat_result      = Db::secure_fetchall($sql, array($res[0]['semat']));
                                            $_SESSION['semat'] = Helper::getor_string($semat_result[0]['semat'], 'ثبت نشده');
                                        } else {
                                            $_SESSION['semat'] = 'ثبت نشده';
                                        }
                                        $_SESSION['dashboard_menu_access_list'] = array();
                                        $where_menu_ids                         = "";
                                        $where_category_ids                     = "";
                                        ///ekhtesase dastresiha be user
                                        // $menu_access = Db::secure_fetchall("SELECT * FROM bnm_dashboard_menu_access WHERE operator_id = ?", array($_SESSION['id']));
                                        // for ($i = 0; $i < count($menu_access); $i++) {
                                        //     if ($i == count($menu_access) - 1) {
                                        //         $where_menu_ids .= $menu_access[$i]['menu_id'];
                                        //     } else {
                                        //         $where_menu_ids .= $menu_access[$i]['menu_id'] . ',';
                                        //     }
                                        // }
                                        //$dashboard_access_list = Db::fetchall_Query("SELECT * FROM bnm_dashboard_menu WHERE id IN ($where_menu_ids) AND branch_display = 1 AND id <> ".__DASHBOARDID__."");
                                        //$cat_ids               = Db::fetchall_Query("SELECT DISTINCT category_id FROM bnm_dashboard_menu WHERE id IN ($where_menu_ids) AND branch_display = 1 AND id <> ".__DASHBOARDID__."");

                                        $dashboard_access_list = Db::fetchall_Query("SELECT * FROM bnm_dashboard_menu WHERE branch_display = 1 AND id <> " . __DASHBOARDID__ . "");
                                        $cat_ids               = Db::fetchall_Query("SELECT DISTINCT category_id FROM bnm_dashboard_menu WHERE branch_display = 1 AND id <> " . __DASHBOARDID__ . "");
                                        for ($i = 0; $i < count($cat_ids); $i++) {
                                            if ($i == count($cat_ids) - 1) {
                                                $where_category_ids .= $cat_ids[$i]['category_id'];
                                            } else {
                                                $where_category_ids .= $cat_ids[$i]['category_id'] . ',';
                                            }
                                        }
                                        $_SESSION['dashboard_menu_access_list'] = Db::fetchall_Query("SELECT * FROM bnm_dashboard_menu_category WHERE id IN ($where_category_ids) ORDER BY sort");
                                        if ($_SESSION['dashboard_menu_access_list']) {
                                            for ($i = 0; $i < count($_SESSION['dashboard_menu_access_list']); $i++) {
                                                $_SESSION['dashboard_menu_access_list'][$i]['sub_menu'] = array();
                                            }
                                            for ($i = 0; $i < count($_SESSION['dashboard_menu_access_list']); $i++) {
                                                for ($j = 0; $j < count($dashboard_access_list); $j++) {
                                                    if ($dashboard_access_list[$j]['category_id'] == $_SESSION['dashboard_menu_access_list'][$i]['id']) {
                                                        array_push($_SESSION['dashboard_menu_access_list'][$i]['sub_menu'], $dashboard_access_list[$j]);
                                                    }
                                                }
                                            }
                                        }
                                    } else {
                                        session_destroy();
                                        $msg = "اطلاعت شما کامل ثبت نشده لطفا پس از بررسی دوباره تلاش کنید.";
                                        die(json_encode(array('login_fail', 'msg' => $msg)));
                                    }
                                }
                                break;
                            case __MODIR2USERTYPE__:
                                # modir2
                                if (!Helper::Is_Empty_OR_Null($_SESSION['user_id'])) {
                                    session_destroy();
                                    $msg = "اطلاعت شما کامل ثبت نشده لطفا پس از بررسی دوباره تلاش کنید.";
                                    die(json_encode(array('login_fail', 'msg' => $msg)));
                                }
                                if (Helper::Is_Empty_OR_Null($_SESSION['branch_id'])) {
                                    //get branch name
                                    $sql                     = "SELECT id,name_sherkat,baladasti_id FROM bnm_branch WHERE id =?";
                                    $res                     = Db::secure_fetchall($sql, array($_SESSION['branch_id']));
                                    $_SESSION['baladasti_id'] = $res[0]['baladasti_id'];
                                    $_SESSION['name_branch'] = Helper::getor_string($res[0]['name_sherkat'], 'نامشخص');
                                } else {
                                    session_destroy();
                                    $msg = "اطلاعت شما کامل ثبت نشده لطفا پس از بررسی دوباره تلاش کنید.";
                                    die(json_encode(array('login_fail', 'msg' => $msg)));
                                }
                                //ekhtesase subscriber / modir name & family
                                $sql                          = "SELECT id,name,name_khanevadegi,semat FROM bnm_operator WHERE id = ? AND user_type = ?";
                                $res                          = Db::secure_fetchall($sql, array($_SESSION['user_id'], __MODIR2USERTYPE__));
                                $_SESSION['name']             = Helper::getor_string($res[0]['name'], 'مدیر');
                                $_SESSION['name_khanevadegi'] = Helper::getor_string($res[0]['name_khanevadegi'], 'مدیر');

                                if (Helper::Is_Empty_OR_Null($res[0]['semat'])) {
                                    $sql               = "SELECT * FROM bnm_organization_level WHERE id =?";
                                    $semat_result      = Db::secure_fetchall($sql, array($res[0]['semat']));
                                    $_SESSION['semat'] = Helper::getor_string($semat_result[0]['semat'], 'ثبت نشده');
                                } else {
                                    $_SESSION['semat'] = 'ثبت نشده';
                                }
                                $_SESSION['dashboard_menu_access_list'] = array();
                                $where_menu_ids                         = "";
                                $where_category_ids                     = "";
                                ///ekhtesase dastresiha be user
                                // $menu_access = Db::secure_fetchall("SELECT * FROM bnm_dashboard_menu_access WHERE operator_id = ?", array($_SESSION['id']));
                                // for ($i = 0; $i < count($menu_access); $i++) {
                                //     if ($i == count($menu_access) - 1) {
                                //         $where_menu_ids .= $menu_access[$i]['menu_id'];
                                //     } else {
                                //         $where_menu_ids .= $menu_access[$i]['menu_id'] . ',';
                                //     }
                                // }
                                //$dashboard_access_list = Db::fetchall_Query("SELECT * FROM bnm_dashboard_menu WHERE id IN ($where_menu_ids) AND branch_display = 1 AND id <> ".__DASHBOARDID__."");
                                //$cat_ids               = Db::fetchall_Query("SELECT DISTINCT category_id FROM bnm_dashboard_menu WHERE id IN ($where_menu_ids) AND branch_display = 1 AND id <> ".__DASHBOARDID__."");
                                $dashboard_access_list = Db::fetchall_Query("SELECT * FROM bnm_dashboard_menu WHERE branch2_display = 1 AND id <> " . __DASHBOARDID__ . "");
                                $cat_ids               = Db::fetchall_Query("SELECT DISTINCT category_id FROM bnm_dashboard_menu WHERE branch2_display = 1 AND id <> " . __DASHBOARDID__ . "");
                                for ($i = 0; $i < count($cat_ids); $i++) {
                                    if ($i == count($cat_ids) - 1) {
                                        $where_category_ids .= $cat_ids[$i]['category_id'];
                                    } else {
                                        $where_category_ids .= $cat_ids[$i]['category_id'] . ',';
                                    }
                                }
                                $_SESSION['dashboard_menu_access_list'] = Db::fetchall_Query("SELECT * FROM bnm_dashboard_menu_category WHERE id IN ($where_category_ids) ORDER BY sort");
                                if ($_SESSION['dashboard_menu_access_list']) {
                                    for ($i = 0; $i < count($_SESSION['dashboard_menu_access_list']); $i++) {
                                        $_SESSION['dashboard_menu_access_list'][$i]['sub_menu'] = array();
                                    }
                                    for ($i = 0; $i < count($_SESSION['dashboard_menu_access_list']); $i++) {
                                        for ($j = 0; $j < count($dashboard_access_list); $j++) {
                                            if ($dashboard_access_list[$j]['category_id'] == $_SESSION['dashboard_menu_access_list'][$i]['id']) {
                                                array_push($_SESSION['dashboard_menu_access_list'][$i]['sub_menu'], $dashboard_access_list[$j]);
                                            }
                                        }
                                    }
                                }
                                break;
                            case __OPERATORUSERTYPE__:
                                # modir->operator
                                if (!Helper::Is_Empty_OR_Null($_SESSION['user_id'])) {
                                    session_destroy();
                                    $msg = "اطلاعت شما کامل ثبت نشده لطفا پس از بررسی دوباره تلاش کنید.";
                                    die(json_encode(array('login_fail', 'msg' => $msg)));
                                }
                                if (Helper::Is_Empty_OR_Null($_SESSION['branch_id'])) {
                                    //get branch name
                                    $sql                     = "SELECT id,name_sherkat,baladasti_id FROM bnm_branch WHERE id =?";
                                    $res                     = Db::secure_fetchall($sql, array($_SESSION['branch_id']));
                                    $_SESSION['baladasti_id'] = $res[0]['baladasti_id'];
                                    $_SESSION['name_branch'] = Helper::getor_string($res[0]['name_sherkat'], 'نامشخص');
                                } else {
                                    session_destroy();
                                    $msg = "اطلاعت شما کامل ثبت نشده لطفا پس از بررسی دوباره تلاش کنید.";
                                    die(json_encode(array('login_fail', 'msg' => $msg)));
                                }
                                //ekhtesase subscriber / modir name & family
                                $sql                          = "SELECT id,name,name_khanevadegi FROM bnm_operator WHERE id = ? AND user_type = ?";
                                $res                          = Db::secure_fetchall($sql, array($_SESSION['user_id'], __OPERATORUSERTYPE__));
                                $_SESSION['name']             = Helper::getor_string($res[0]['name'], 'اپراتور');
                                $_SESSION['name_khanevadegi'] = Helper::getor_string($res[0]['name_khanevadegi'], 'اپراتور');
                                if ($res[0]['semat'] != '' || $res[0]['semat'] != null) {
                                    $sql               = "SELECT * FROM bnm_organization_level WHERE id =?";
                                    $semat_result      = Db::secure_fetchall($sql, array($res[0]['semat']));
                                    $_SESSION['semat'] = Helper::getor_string($semat_result[0]['semat'], 'ثبت نشده');
                                } else {
                                    $_SESSION['semat'] = 'ثبت نشده';
                                }
                                $_SESSION['dashboard_menu_access_list'] = array();
                                $where_menu_ids                         = "";
                                $where_category_ids                     = "";
                                ///ekhtesase dastresiha be user
                                $menu_access = Db::secure_fetchall("SELECT * FROM bnm_dashboard_menu_access WHERE operator_id = ?", array($_SESSION['id']));
                                for ($i = 0; $i < count($menu_access); $i++) {
                                    if ($i == count($menu_access) - 1) {
                                        $where_menu_ids .= $menu_access[$i]['menu_id'];
                                    } else {
                                        $where_menu_ids .= $menu_access[$i]['menu_id'] . ',';
                                    }
                                }
                                $dashboard_access_list = Db::fetchall_Query("SELECT * FROM bnm_dashboard_menu WHERE id IN ($where_menu_ids) AND branch_display = 1 AND id <> " . __DASHBOARDID__ . "");
                                $cat_ids               = Db::fetchall_Query("SELECT DISTINCT category_id FROM bnm_dashboard_menu WHERE id IN ($where_menu_ids) AND branch_display = 1 AND id <> " . __DASHBOARDID__ . "");
                                for ($i = 0; $i < count($cat_ids); $i++) {
                                    if ($i == count($cat_ids) - 1) {
                                        $where_category_ids .= $cat_ids[$i]['category_id'];
                                    } else {
                                        $where_category_ids .= $cat_ids[$i]['category_id'] . ',';
                                    }
                                }
                                $_SESSION['dashboard_menu_access_list'] = Db::fetchall_Query("SELECT * FROM bnm_dashboard_menu_category WHERE id IN ($where_category_ids) ORDER BY sort");
                                if ($_SESSION['dashboard_menu_access_list']) {
                                    for ($i = 0; $i < count($_SESSION['dashboard_menu_access_list']); $i++) {
                                        $_SESSION['dashboard_menu_access_list'][$i]['sub_menu'] = array();
                                    }
                                    for ($i = 0; $i < count($_SESSION['dashboard_menu_access_list']); $i++) {
                                        for ($j = 0; $j < count($dashboard_access_list); $j++) {
                                            if ($dashboard_access_list[$j]['category_id'] == $_SESSION['dashboard_menu_access_list'][$i]['id']) {
                                                array_push($_SESSION['dashboard_menu_access_list'][$i]['sub_menu'], $dashboard_access_list[$j]);
                                            }
                                        }
                                    }
                                }
                                break;
                            case __OPERATOR2USERTYPE__:
                                # modir->operator
                                if (!Helper::Is_Empty_OR_Null($_SESSION['user_id'])) {
                                    session_destroy();
                                    $msg = "اطلاعت شما کامل ثبت نشده لطفا پس از بررسی دوباره تلاش کنید.";
                                    die(json_encode(array('login_fail', 'msg' => $msg)));
                                }
                                if (Helper::Is_Empty_OR_Null($_SESSION['branch_id'])) {
                                    //get branch name
                                    $sql                     = "SELECT id,name_sherkat,baladasti_id FROM bnm_branch WHERE id =?";
                                    $res                     = Db::secure_fetchall($sql, array($_SESSION['branch_id']));
                                    $_SESSION['baladasti_id'] = $res[0]['baladasti_id'];
                                    $_SESSION['name_branch'] = Helper::getor_string($res[0]['name_sherkat'], 'نامشخص');
                                } else {
                                    session_destroy();
                                    $msg = "اطلاعت شما کامل ثبت نشده لطفا پس از بررسی دوباره تلاش کنید.";
                                    die(json_encode(array('login_fail', 'msg' => $msg)));
                                }
                                //ekhtesase subscriber / modir name & family
                                $sql                          = "SELECT id,name,name_khanevadegi FROM bnm_operator WHERE id = ? AND user_type = ?";
                                $res                          = Db::secure_fetchall($sql, array($_SESSION['user_id'], __OPERATOR2USERTYPE__));
                                $_SESSION['name']             = Helper::getor_string($res[0]['name'], 'اپراتور');
                                $_SESSION['name_khanevadegi'] = Helper::getor_string($res[0]['name_khanevadegi'], 'اپراتور');
                                if ($res[0]['semat'] != '' || $res[0]['semat'] != null) {
                                    $sql               = "SELECT * FROM bnm_organization_level WHERE id =?";
                                    $semat_result      = Db::secure_fetchall($sql, array($res[0]['semat']));
                                    $_SESSION['semat'] = Helper::getor_string($semat_result[0]['semat'], 'ثبت نشده');
                                } else {
                                    $_SESSION['semat'] = 'ثبت نشده';
                                }
                                $_SESSION['dashboard_menu_access_list'] = array();
                                $where_menu_ids                         = "";
                                $where_category_ids                     = "";
                                ///ekhtesase dastresiha be user
                                $menu_access = Db::secure_fetchall("SELECT * FROM bnm_dashboard_menu_access WHERE operator_id = ?", array($_SESSION['id']));
                                for ($i = 0; $i < count($menu_access); $i++) {
                                    if ($i == count($menu_access) - 1) {
                                        $where_menu_ids .= $menu_access[$i]['menu_id'];
                                    } else {
                                        $where_menu_ids .= $menu_access[$i]['menu_id'] . ',';
                                    }
                                }
                                $dashboard_access_list = Db::fetchall_Query("SELECT * FROM bnm_dashboard_menu WHERE id IN ($where_menu_ids) AND branch2_display = 1 AND id <> " . __DASHBOARDID__ . "");
                                $cat_ids               = Db::fetchall_Query("SELECT DISTINCT category_id FROM bnm_dashboard_menu WHERE id IN ($where_menu_ids) AND branch2_display = 1 AND id <> " . __DASHBOARDID__ . "");
                                for ($i = 0; $i < count($cat_ids); $i++) {
                                    if ($i == count($cat_ids) - 1) {
                                        $where_category_ids .= $cat_ids[$i]['category_id'];
                                    } else {
                                        $where_category_ids .= $cat_ids[$i]['category_id'] . ',';
                                    }
                                }
                                $_SESSION['dashboard_menu_access_list'] = Db::fetchall_Query("SELECT * FROM bnm_dashboard_menu_category WHERE id IN ($where_category_ids) ORDER BY sort");
                                if ($_SESSION['dashboard_menu_access_list']) {
                                    for ($i = 0; $i < count($_SESSION['dashboard_menu_access_list']); $i++) {
                                        $_SESSION['dashboard_menu_access_list'][$i]['sub_menu'] = array();
                                    }
                                    for ($i = 0; $i < count($_SESSION['dashboard_menu_access_list']); $i++) {
                                        for ($j = 0; $j < count($dashboard_access_list); $j++) {
                                            if ($dashboard_access_list[$j]['category_id'] == $_SESSION['dashboard_menu_access_list'][$i]['id']) {
                                                array_push($_SESSION['dashboard_menu_access_list'][$i]['sub_menu'], $dashboard_access_list[$j]);
                                            }
                                        }
                                    }
                                }
                                break;
                            case __ADMINOPERATORUSERTYPE__:
                                # admin->operator
                                if (!Helper::Is_Empty_OR_Null($_SESSION['user_id'])) {
                                    session_destroy();
                                    $msg = "اطلاعت شما کامل ثبت نشده لطفا پس از بررسی دوباره تلاش کنید.";
                                    die(json_encode(array('login_fail', 'msg' => $msg)));

                                    // if (Helper::Is_Empty_OR_Null($_SESSION['branch_id'])) {
                                    //     //get branch name
                                    //     $sql                     = "SELECT id,name_sherkat FROM bnm_branch WHERE id =?";
                                    //     $res                     = Db::secure_fetchall($sql, array($_SESSION['branch_id']));
                                    //     $_SESSION['name_branch'] = Helper::getor_string($res[0]['name_sherkat'], __OWNER__);
                                    // } else {
                                    //     session_destroy();
                                    //     $msg = "اطلاعت شما کامل ثبت نشده لطفا پس از بررسی دوباره تلاش کنید.";
                                    //     die(json_encode(array('login_fail', 'msg' => $msg)));
                                    // }
                                    ////////////////////////////////////////////////////////////////////////////////////

                                } else {
                                    $_SESSION['name']                       = Helper::getor_string($res[0]['name'], $_SESSION['username']);
                                    $_SESSION['name_khanevadegi']           = Helper::getor_string($res[0]['name_khanevadegi'], 'Administrator');
                                    $_SESSION['semat']                      = Helper::getor_string($res[0]['semat'], __SEMATOPERATOR__);
                                    $_SESSION['name_branch']                = __OWNER__;
                                    $_SESSION['baladasti_id']               = 0;
                                    $_SESSION['dashboard_menu_access_list'] = array();
                                    $where_menu_ids                         = "";
                                    $where_category_ids                     = "";
                                    ///ekhtesase dastresiha be user //// NEW
                                    $sql = "SELECT DISTINCT(dm.category_id) category_id FROM bnm_dashboard_menu_access dma INNER JOIN bnm_dashboard_menu dm ON dma.menu_id = dm.id WHERE dma.operator_id=? AND user_type = ?";
                                    $cats = Db::secure_fetchall($sql, [$_SESSION['id'], $_SESSION['user_type']]);
                                    ///////
                                    $sql = "SELECT dm.* FROM bnm_dashboard_menu_access dma INNER JOIN bnm_dashboard_menu dm ON dma.menu_id = dm.id WHERE dma.operator_id=? AND user_type = ?";
                                    $dashboard_access_list = Db::secure_fetchall($sql, [$_SESSION['id'], $_SESSION['user_type']]);
                                    for ($i = 0; $i < count($cats); $i++) {
                                        if ($i == count($cats) - 1) {
                                            $where_category_ids .= $cats[$i]['category_id'];
                                        } else {
                                            $where_category_ids .= $cats[$i]['category_id'] . ',';
                                        }
                                    }
                                    $_SESSION['dashboard_menu_access_list'] = Db::fetchall_Query("SELECT * FROM bnm_dashboard_menu_category WHERE id IN ($where_category_ids) ORDER BY sort");
                                    if ($_SESSION['dashboard_menu_access_list']) {
                                        for ($i = 0; $i < count($_SESSION['dashboard_menu_access_list']); $i++) {
                                            $_SESSION['dashboard_menu_access_list'][$i]['sub_menu'] = array();
                                        }
                                        for ($i = 0; $i < count($_SESSION['dashboard_menu_access_list']); $i++) {
                                            for ($j = 0; $j < count($dashboard_access_list); $j++) {
                                                if ($dashboard_access_list[$j]['category_id'] == $_SESSION['dashboard_menu_access_list'][$i]['id']) {
                                                    array_push($_SESSION['dashboard_menu_access_list'][$i]['sub_menu'], $dashboard_access_list[$j]);
                                                }
                                            }
                                        }
                                    }
                                    ///ekhtesase dastresiha be user //// NEW
                                    ///ekhtesase dastresiha be user //// OLD
                                    // $dashboard_access_list = Db::fetchall_Query("SELECT * FROM bnm_dashboard_menu WHERE admin_operator_display = 1 AND id <> ".__DASHBOARDID__."");
                                    // $cat_ids               = Db::fetchall_Query("SELECT DISTINCT category_id FROM bnm_dashboard_menu WHERE admin_operator_display = 1 AND id <> ".__DASHBOARDID__."");
                                    // for ($i = 0; $i < count($cat_ids); $i++) {
                                    //     if ($i == count($cat_ids) - 1) {
                                    //         $where_category_ids .= $cat_ids[$i]['category_id'];
                                    //     } else {
                                    //         $where_category_ids .= $cat_ids[$i]['category_id'] . ',';
                                    //     }
                                    // }
                                    // $_SESSION['dashboard_menu_access_list'] = Db::fetchall_Query("SELECT * FROM bnm_dashboard_menu_category WHERE id IN ($where_category_ids) ORDER BY sort");
                                    // if ($_SESSION['dashboard_menu_access_list']) {
                                    //     for ($i = 0; $i < count($_SESSION['dashboard_menu_access_list']); $i++) {
                                    //         $_SESSION['dashboard_menu_access_list'][$i]['sub_menu'] = array();
                                    //     }
                                    //     for ($i = 0; $i < count($_SESSION['dashboard_menu_access_list']); $i++) {
                                    //         for ($j = 0; $j < count($dashboard_access_list); $j++) {
                                    //             if ($dashboard_access_list[$j]['category_id'] == $_SESSION['dashboard_menu_access_list'][$i]['id']) {
                                    //                 array_push($_SESSION['dashboard_menu_access_list'][$i]['sub_menu'], $dashboard_access_list[$j]);
                                    //             }
                                    //         }
                                    //     }
                                    // }
                                    ///ekhtesase dastresiha be user //// OLD
                                }
                                break;
                            case __MOSHTARAKUSERTYPE__:
                                #subscriber
                                if (Helper::Is_Empty_OR_Null($res[0]['user_id'])) {
                                    $_SESSION['dashboard_menu_access_list'] = array();
                                    $where_menu_ids                         = "";
                                    $where_category_ids                     = "";
                                    $sql_sub                                = "SELECT * FROM bnm_subscribers WHERE id = ?";
                                    $res_sub                                = Db::secure_fetchall($sql_sub, array($res[0]['user_id']));
                                    if ($res_sub) {
                                        if ($_SESSION['branch_id'] !== 0) {
                                            //user namayande
                                            $sql_branch = "SELECT * FROM bnm_branch WHERE id = ?";
                                            $res_branch = Db::secure_fetchall($sql_branch, array($_SESSION['branch_id']));
                                            if ($res_branch) {
                                                //$_SESSION['subscriber_id']    = $res[0]['subscriber_id'];
                                                $_SESSION['semat']            = "مشترک";
                                                $_SESSION['subscriber_type']  = $res_sub[0]['noe_moshtarak'];
                                                $_SESSION['name_sherkat']     = __OWNER__;
                                                $_SESSION['name_branch']      = Helper::getor_string($res_branch[0]['name_sherkat'], 'ثبت نشده');
                                                $_SESSION['name']             = Helper::getor_string($res_sub[0]['name'], $_SESSION['username']);
                                                $_SESSION['name_khanevadegi'] = Helper::getor_string($res_sub[0]['f_name'], '');
                                                $_SESSION['semat']            = Helper::getor_string($res[0]['semat'], __SEMATMOSHTARAK__);
                                            } else {
                                                session_destroy();
                                                $msg = Helper::Messages('binf');
                                                die(json_encode(array('login_fail', 'msg' => $msg)));
                                            }
                                            $dashboard_access_list = Db::fetchall_Query("SELECT * FROM bnm_dashboard_menu WHERE subscriber_display = 1 AND id <> " . __DASHBOARDID__ . "");
                                            $cat_ids               = Db::fetchall_Query("SELECT DISTINCT category_id FROM bnm_dashboard_menu WHERE subscriber_display = 1 AND id <> " . __DASHBOARDID__ . "");
                                            for ($i = 0; $i < count($cat_ids); $i++) {
                                                if ($i == count($cat_ids) - 1) {
                                                    $where_category_ids .= $cat_ids[$i]['category_id'];
                                                } else {
                                                    $where_category_ids .= $cat_ids[$i]['category_id'] . ',';
                                                }
                                            }
                                            $_SESSION['dashboard_menu_access_list'] = Db::fetchall_Query("SELECT * FROM bnm_dashboard_menu_category WHERE id IN ($where_category_ids) ORDER BY sort");
                                            if ($_SESSION['dashboard_menu_access_list']) {
                                                for ($i = 0; $i < count($_SESSION['dashboard_menu_access_list']); $i++) {
                                                    $_SESSION['dashboard_menu_access_list'][$i]['sub_menu'] = array();
                                                }
                                                for ($i = 0; $i < count($_SESSION['dashboard_menu_access_list']); $i++) {
                                                    for ($j = 0; $j < count($dashboard_access_list); $j++) {
                                                        if ($dashboard_access_list[$j]['category_id'] == $_SESSION['dashboard_menu_access_list'][$i]['id']) {
                                                            array_push($_SESSION['dashboard_menu_access_list'][$i]['sub_menu'], $dashboard_access_list[$j]);
                                                        }
                                                    }
                                                }
                                            }
                                        } else {
                                            //user sahar
                                            //$_SESSION['subscriber_id']    = $res[0]['subscriber_id'];
                                            $_SESSION['semat']            = "مشترک";
                                            $_SESSION['name_branch']      = __OWNER__;
                                            $_SESSION['name_sherkat']     = __OWNER__;
                                            $_SESSION['name']             = Helper::getor_string($res_sub[0]['name'], $_SESSION['username']);
                                            $_SESSION['name_khanevadegi'] = Helper::getor_string($res_sub[0]['f_name'], 'ثبت نشده');
                                            $_SESSION['name_branch']      = Helper::getor_string(__OWNER__, 'ثبت نشده');
                                            $dashboard_access_list        = Db::fetchall_Query("SELECT * FROM bnm_dashboard_menu WHERE subscriber_display = 1 AND id <> " . __DASHBOARDID__ . "");
                                            $cat_ids                      = Db::fetchall_Query("SELECT DISTINCT category_id FROM bnm_dashboard_menu WHERE subscriber_display = 1 AND id <> " . __DASHBOARDID__ . "");
                                            for ($i = 0; $i < count($cat_ids); $i++) {
                                                if ($i == count($cat_ids) - 1) {
                                                    $where_category_ids .= $cat_ids[$i]['category_id'];
                                                } else {
                                                    $where_category_ids .= $cat_ids[$i]['category_id'] . ',';
                                                }
                                            }
                                            $_SESSION['dashboard_menu_access_list'] = Db::fetchall_Query("SELECT * FROM bnm_dashboard_menu_category WHERE id IN ($where_category_ids) ORDER BY sort");
                                            if ($_SESSION['dashboard_menu_access_list']) {
                                                for ($i = 0; $i < count($_SESSION['dashboard_menu_access_list']); $i++) {
                                                    $_SESSION['dashboard_menu_access_list'][$i]['sub_menu'] = array();
                                                }
                                                for ($i = 0; $i < count($_SESSION['dashboard_menu_access_list']); $i++) {
                                                    for ($j = 0; $j < count($dashboard_access_list); $j++) {
                                                        if ($dashboard_access_list[$j]['category_id'] == $_SESSION['dashboard_menu_access_list'][$i]['id']) {
                                                            array_push($_SESSION['dashboard_menu_access_list'][$i]['sub_menu'], $dashboard_access_list[$j]);
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    } else {
                                        session_destroy();
                                        $msg = "اطلاعات شما در پابگاه داده به درستی ثبت نشده است لطفا جهت پیگیری با شرکت تماس حاصل فرمایید.";
                                        die(json_encode(array('login_fail', 'msg' => $msg)));
                                    }
                                } else {
                                    session_destroy();
                                    $msg = "اطلاعاتی شما در پابگاه داده به درستی ثبت نشده است لطفا جهت پیگیری با شرکت تماس حاصل فرمایید.";
                                    die(json_encode(array('login_fail', 'msg' => $msg)));
                                }
                                break;
                            default:
                                session_destroy();
                                $msg = "اطلاعت شما کامل ثبت نشده لطفا پس از بررسی دوباره تلاش کنید.";
                                die(json_encode(array('login_fail', 'msg' => $msg)));
                                break;
                        }
                        die(json_encode(array('login_success')));
                    } else {
                        $msg = "نام کاربری یا رمز عبور اشتباه وارد شده لطفا مجددا تلاش کنید.";
                        die(json_encode(array('login_fail', 'msg' => $msg)));
                    }
                } else {
                    $msg = "لطفا نام کاربری و رمز عبور را وارد کنید.";
                    die(json_encode(array('login_fail', 'msg' => $msg)));
                }
            } catch (Throwable $e) {
                Helper::Exc_Error_Debug($e, true, '', false);
                die();
                //die(json_encode(array('login_fail', 'msg' => $msg)));
            }
        }
        if(isset($_POST['send_forgotpassword'])){
            $_POST = Helper::Create_Post_Array_Without_Key($_POST);
            $_POST = Helper::xss_check_array($_POST);
            $sql="SELECT * FROM bnm_subscribers WHERE telephone_hamrah = ?";
            $ressub=Db::secure_fetchall($sql, [$_POST['mobile']]);
            $sql="SELECT * FROM bnm_operator WHERE telephone_hamrah = ?";
            $resoperator=Db::secure_fetchall($sql, [$_POST['mobile']]);
            if(! $ressub && ! $resoperator){
                $msg="تلفن مورد نظر در  سامانه وجود نداشت ";
                die(json_encode(['msg'=>$msg]));
            }
            if($ressub && $resoperator){
                $msg= "تلفن مورد نظر چند بار در سامانه ثبت شده لطفا با پشتیبانی تماس بگیرید.";
                die(json_encode(['msg'=>$msg]));
            }
            if($ressub){
                if(count($ressub)===1){
                    //creating new password
                    $originpassword = Helper::randomNum(10001, 99999);
                    $password       = Helper::str_trim($originpassword);
                    $password       = Helper::str_md5($password, false);
                    //finding user in bnm_users table
                    $sql="SELECT * FROM bnm_users WHERE user_id = ? AND user_type = ?";
                    $user=Db::secure_fetchall($sql, [$ressub[0]['id'], __MOSHTARAKUSERTYPE__]);
                    if(! $user){
                        $msg="اطلاعات کاربر پیدا نشد.";
                        die(json_encode(['msg'=>$msg]));
                    }
                    //sending new password by sms
                    $smsmsg=" مشترک شبکه سحر ارتباط رمز عبور جدید شما";
                    $smsmsg.=$originpassword." ";
                    $smsmsg.="میباشد";
                    $sms=Helper::Send_Sms_Single($ressub[0]['telephone_hamrah'], $smsmsg);
                    $sql=Helper::Update_Generator(['id'=> $user[0]['id'], 'password'=> $password], 'bnm_users', "WHERE id = :id");
                    $resetpass=Db::secure_update_array($sql, ['id'=> $user[0]['id'], 'password'=> $password]);
                    $msg="رمز عبور جدید برای شما پیامک خواهد شد";
                    die(json_encode(['msg'=>$msg]));
                }else{
                    $msg= "تلفن مورد نظر چند بار در سامانه ثبت شده لطفا با پشتیبانی تماس بگیرید.";
                    die(json_encode(['msg'=>$msg]));
                }
            }
            if($resoperator){
                if(count($resoperator)===1){
                    //creating new password
                    $originpassword = Helper::randomNum(10001, 99999);
                    $password       = Helper::str_trim($originpassword);
                    $password       = Helper::str_md5($password, false);
                    //finding user in bnm_users table
                    $sql="SELECT * FROM bnm_users WHERE user_id = ? AND user_type = ?";
                    $user=Db::secure_fetchall($sql, [$resoperator[0]['id'], $resoperator[0]['user_type']]);
                    if(! $user){
                        $msg="اطلاعات کاربر پیدا نشد.";
                        die(json_encode(['msg'=>$msg]));
                    }
                    //sending new password by sms
                    $smsmsg=" نماینده محترم رمز عبور جدید شما";
                    $smsmsg.=$originpassword." ";
                    $smsmsg.="میباشد";
                    $sms=Helper::Send_Sms_Single($resoperator[0]['telephone_hamrah'], $smsmsg);
                    $sql=Helper::Update_Generator(['id'=> $user[0]['id'], 'password'=> $password], 'bnm_users', "WHERE id = :id");
                    $resetpass=Db::secure_update_array($sql, ['id'=> $user[0]['id'], 'password'=> $password]);
                    $msg="رمز عبور جدید برای شما پیامک خواهد شد";
                    die(json_encode(['msg'=>$msg]));
                }else{
                    $msg= "تلفن مورد نظر چند بار در سامانه ثبت شده لطفا با پشتیبانی تماس بگیرید.";
                    die(json_encode(['msg'=>$msg]));
                }
            }

            die(json_encode($_POST));
        }
        $this->view->pagename = 'login';
        $this->view->render('login/view', false, '/public/js/login.js', false);
    }
}
