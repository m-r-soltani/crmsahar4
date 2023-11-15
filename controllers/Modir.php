<?php defined('__ROOT__') or exit('No direct script access allowed');

class Modir extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

        if (isset($_POST['send_modir'])) {
            ///sabte modir va operator ro dar bnm_operator anjam mishavad va ba user_type joda mishan
            $_POST['code_meli']          = $_POST['national_code'];
            $_POST['shomare_shenasname'] = $_POST['s_s'];
            unset($_POST['send_modir']);
            unset($_POST['national_code']);
            unset($_POST['s_s']);
            if (Helper::Login_Just_Check()) {
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                        $_POST              = Helper::xss_check_array($_POST);
                        $sql_branch                = "SELECT * FROM bnm_branch WHERE id = ?";
                        $res_branch         = Db::secure_fetchall($sql_branch, array($_POST['branch_id']), true);
                        $_POST['code_meli'] = Helper::str_trim($_POST['code_meli']);
                        if ($res_branch) {
                                if (Helper::checkCodeMeli($_POST['code_meli'])) {
                                    if (isset($_POST['tarikhe_tavalod'])) {
                                        $_POST['tarikhe_tavalod'] = Helper::Fix_Date_Seperator($_POST['tarikhe_tavalod']);
                                        $date_arr                 = array();
                                        $date_arr                 = explode("/", $_POST['tarikhe_tavalod']);
                                        if (count($date_arr) > 2) {
                                            $year                     = (int) Helper::convert_numbers($date_arr[0], false);
                                            $month                    = (int) Helper::convert_numbers($date_arr[1], false);
                                            $day                      = (int) Helper::convert_numbers($date_arr[2], false);
                                            $_POST['tarikhe_tavalod'] = Helper::jalali_to_gregorian($year, $month, $day, '/');
                                        }
                                    }
                                    if ($_POST['id'] === "empty") {
                                        /////////////////insert request///////////////////
                                        if ($res_branch[0]['baladasti_id'] === 0) {
                                            ///namayande asli
                                            if (Helper::Is_Empty_OR_Null($_POST['username']) && strlen($_POST['username']) > 3) {
                                                if (Helper::Is_Empty_OR_Null($_POST['password']) && strlen($_POST['password']) > 3) {
                                                    $sql      = "SELECT count(*) as rows_num FROM bnm_users WHERE username=?";
                                                    $res_init = Db::secure_fetchall($sql, array($_POST['username']), true);
                                                    if ($res_init[0]['rows_num'] === 0) {
                                                        if((int) $_POST['ismodir']===1){
                                                            $sql="UPDATE bnm_operator SET ismodir= :ismodir WHERE branch_id=:branch_id";
                                                            $resismodir=Db::secure_update_array($sql, ['ismodir'=>0,'branch_id'=>$_POST['branch_id']]);
                                                        }
                                                        unset($_POST['id']);
                                                        $_POST['user_type'] = __MODIRUSERTYPE__;
                                                        $sql                = Helper::Insert_Generator($_POST, 'bnm_operator');
                                                        $res                = Db::secure_insert_array($sql, $_POST);
                                                        if (!$res) {
                                                            echo "<script>alert('عملیات ناموفق لطفا دوباره تلاش کنید.');</script>";
                                                        } elseif ($res) {
                                                            //user operation
                                                            $user_id             = (int) $res;
                                                            $password            = Helper::str_md5($_POST['password']);
                                                            $arr                 = array();
                                                            $arr['user_type']    = __MODIRUSERTYPE__;
                                                            $arr['username']     = $_POST['username'];
                                                            $arr['password']     = $password;
                                                            $arr['branch_id']    = $res_branch[0]['id'];
                                                            $arr['user_id']      = $user_id;
                                                            $arr['baladasti_id'] = $res_branch[0]['baladasti_id'];
                                                            $sql                 = Helper::Insert_Generator($arr, 'bnm_users');
                                                            $res                 = Db::secure_insert_array($sql, $arr);
                                                            if (!$res) {
                                                                $sql_del = "DELETE FROM bnm_operator WHERE id = ?";
                                                                Db::secure_fetchall($sql_del, array($user_id));
                                                                echo Helper::Alert_Message('f');
                                                            } elseif ($res) {
                                                                echo Helper::Alert_Message('s');
                                                            }
                                                        }
                                                    } else {
                                                        echo Helper::Alert_Message('uae');
                                                    }

                                                } else {
                                                    echo Helper::Alert_Message('ple');
                                                }
                                            } else {
                                                echo Helper::Alert_Message('ule');
                                            }
                                        } else {
                                            //namayande sathe 2

                                            if (Helper::Is_Empty_OR_Null($_POST['username']) && strlen($_POST['username']) > 3) {
                                                if (Helper::Is_Empty_OR_Null($_POST['password']) && strlen($_POST['password']) > 3) {
                                                    $sql      = "SELECT count(*) as rows_num FROM bnm_users WHERE username=?";
                                                    $res_init = Db::secure_fetchall($sql, array($_POST['username']), true);
                                                    if ($res_init[0]['rows_num'] === 0) {
                                                        if((int) $_POST['ismodir']===1){
                                                            $sql="UPDATE bnm_operator SET ismodir= :ismodir WHERE branch_id=:branch_id";
                                                            $resismodir=Db::secure_update_array($sql, ['ismodir'=>0,'branch_id'=>$_POST['branch_id']]);
                                                        }
                                                        unset($_POST['id']);
                                                        $_POST['user_type'] = __MODIR2USERTYPE__;
                                                        $sql                = Helper::Insert_Generator($_POST, 'bnm_operator');
                                                        $res                = Db::secure_insert_array($sql, $_POST);
                                                        if (!$res) {
                                                            echo "<script>alert('عملیات ناموفق لطفا دوباره تلاش کنید.');</script>";
                                                        } elseif ($res) {
                                                            $user_id             = (int) $res;
                                                            $arr                 = array();
                                                            $password            = Helper::str_md5($_POST['password']);
                                                            $arr['user_type']    = __MODIR2USERTYPE__;
                                                            $arr['username']     = $_POST['username'];
                                                            $arr['password']     = $password;
                                                            $arr['branch_id']    = $res_branch[0]['id'];
                                                            $arr['user_id']      = $user_id;
                                                            $arr['baladasti_id'] = $res_branch[0]['baladasti_id'];
                                                            $sql                 = Helper::Insert_Generator($arr, 'bnm_users');
                                                            $res                 = Db::secure_insert_array($sql, $arr);
                                                            if (!$res) {
                                                                echo Helper::Alert_Message('f');
                                                            } elseif ($res) {
                                                                echo Helper::Alert_Message('s');
                                                            }
                                                            ////agar sabt nashod operator delete shavad????
                                                        }
                                                    } else {
                                                        echo Helper::Alert_Message('uae');
                                                    }

                                                } else {
                                                    echo Helper::Alert_Message('ple');
                                                }
                                            } else {
                                                echo Helper::Alert_Message('ule');
                                            }
                                        }
                                    } elseif (Helper::Is_Empty_OR_Null($_POST['id'])) {
                                        /////////////////update request///////////////////
                                        /////////////////hal nadashtam tamiz benevisam mhaminja dobare neveshtamesh ta betonam copish konam
                                        if((int) $_POST['ismodir']===1){
                                            $sql="UPDATE bnm_operator SET ismodir= :ismodir WHERE branch_id=:branch_id";
                                            $resismodir=Db::secure_update_array($sql, ['ismodir'=>0,'branch_id'=>$_POST['branch_id']]);
                                        }
                                        $_POST=Helper::Unset_IN_Array($_POST,array('username','password','user_type'));
                                        
                                        $sql = Helper::Update_Generator($_POST, 'bnm_operator', "WHERE id = :id");
                                        $res = Db::secure_update_array($sql, $_POST);
                                    } else {
                                        echo Helper::Alert_Message('cmnv');
                                    }
                                }

                        } else {
                            echo Helper::Alert_Message('binf');
                        }
                        break;
                    case __MODIRUSERTYPE__:
                    case __OPERATORUSERTYPE__:
                        $_POST              = Helper::xss_check_array($_POST);
                        $sql_branch         = "SELECT * FROM bnm_branch WHERE id = ?";
                        $res_branch         = Db::secure_fetchall($sql_branch, array($_SESSION['branch_id']), true);
                        $_POST['code_meli'] = Helper::str_trim($_POST['code_meli']);
                        if ($res_branch) {
                                if (Helper::checkCodeMeli($_POST['code_meli'])) {
                                    if (isset($_POST['tarikhe_tavalod'])) {
                                        $_POST['tarikhe_tavalod'] = Helper::Fix_Date_Seperator($_POST['tarikhe_tavalod']);
                                        $date_arr                 = array();
                                        $date_arr                 = explode("/", $_POST['tarikhe_tavalod']);
                                        if (count($date_arr) > 2) {
                                            $year                     = (int) Helper::convert_numbers($date_arr[0], false);
                                            $month                    = (int) Helper::convert_numbers($date_arr[1], false);
                                            $day                      = (int) Helper::convert_numbers($date_arr[2], false);
                                            $_POST['tarikhe_tavalod'] = Helper::jalali_to_gregorian($year, $month, $day, '/');
                                        }
                                    }
                                    if ($_POST['id'] === "empty") {
                                        /////////////////insert request///////////////////
                                        if ($res_branch[0]['baladasti_id'] === 0) {
                                            if(Helper::check_add_access('modir')){
                                            ///namayande asli
                                                if (Helper::Is_Empty_OR_Null($_POST['username']) && strlen($_POST['username']) > 3) {
                                                    if (Helper::Is_Empty_OR_Null($_POST['password']) && strlen($_POST['password']) > 3) {
                                                        $sql      = "SELECT count(*) as rows_num FROM bnm_users WHERE username=?";
                                                        $res_init = Db::secure_fetchall($sql, array($_POST['username']), true);
                                                        if ($res_init[0]['rows_num'] === 0) {
                                                            if(Helper::check_add_access('Modir')){
                                                                if((int) $_POST['ismodir']===1){
                                                                    $sql="UPDATE bnm_operator SET ismodir= :ismodir WHERE branch_id=:branch_id";
                                                                    $resismodir=Db::secure_update_array($sql, ['ismodir'=>0,'branch_id'=>$_POST['branch_id']]);
                                                                }
                                                            unset($_POST['id']);
                                                            $_POST['user_type'] = __MODIRUSERTYPE__;
                                                            $sql                = Helper::Insert_Generator($_POST, 'bnm_operator');
                                                            $res                = Db::secure_insert_array($sql, $_POST);
                                                            } else echo Helper::Alert_Message('na');
                                                            if (!$res) {
                                                                echo "<script>alert('عملیات ناموفق لطفا دوباره تلاش کنید.');</script>";
                                                            } elseif ($res) {
                                                                
                                                                    $user_id          = (int) $res;
                                                                    $password         = Helper::str_md5($_POST['password']);
                                                                    $arr              = array();
                                                                    $arr['user_type'] = __MODIRUSERTYPE__;
                                                                    $arr['username']  = $_POST['username'];
                                                                    $arr['password']  = $password;
                                                                    $arr['branch_id'] = $_SESSION['branch_id'];
                                                                    $arr['user_id']   = $user_id;
                                                                    $sql              = Helper::Insert_Generator($arr, 'bnm_users');
                                                                    $res              = Db::secure_insert_array($sql, $arr);
                                                                    if (!$res) {
                                                                        $sql_del = "DELETE FROM bnm_operator WHERE id = ?";
                                                                        Db::secure_fetchall($sql_del, array($user_id));
                                                                        echo Helper::Alert_Message('f');
                                                                    } elseif ($res) {
                                                                        echo Helper::Alert_Message('s');
                                                                    }
                                                                
                                                            }
                                                        } else {
                                                            echo Helper::Alert_Message('uae');
                                                        }

                                                    } else {
                                                        echo Helper::Alert_Message('ple');
                                                    }
                                                } else {
                                                    echo Helper::Alert_Message('ule');
                                                }
                                            }else echo Helper::Alert_Message('na');
                                        } else {
                                            echo Helper::Alert_Message('na');
                                        }
                                    } elseif (Helper::Is_Empty_OR_Null($_POST['id'])) {
                                        if ($res_branch) {
                                            if ($res_branch[0]['id'] === $_SESSION['branch_id']) {
                                                // $_POST['user_type'] = __MODIRUSERTYPE__;
                                                if((int) $_POST['ismodir']===1){
                                                    $sql="UPDATE bnm_operator SET ismodir= :ismodir WHERE branch_id=:branch_id";
                                                    $resismodir=Db::secure_update_array($sql, ['ismodir'=>0,'branch_id'=>$_POST['branch_id']]);
                                                }
                                                $_POST              = Helper::Unset_IN_Array($_POST, array('username', 'password', 'branch_id','user_type'));
                                                $sql                = Helper::Update_Generator($_POST, 'bnm_operator', "WHERE id = :id");
                                                $res                = Db::secure_update_array($sql, $_POST);
                                            } else {
                                                die(Helper::Json_Message('f'));
                                            }

                                        } else {
                                            echo Helper::Alert_Message('binf');
                                        }

                                    } else {
                                        echo Helper::Alert_Message('na');
                                    }
                                } else {
                                    echo Helper::Alert_Message('cmnv');
                                }
                        } else {
                            echo Helper::Alert_Message('binf');
                        }
                        break;
                    case __MODIR2USERTYPE__:
                    case __OPERATOR2USERTYPE__:
                        $_POST              = Helper::xss_check_array($_POST);
                        $sql_branch         = "SELECT * FROM bnm_branch WHERE id = ?";
                        $res_branch         = Db::secure_fetchall($sql_branch, array($_SESSION['branch_id']), true);
                        $_POST['code_meli'] = Helper::str_trim($_POST['code_meli']);
                        if ($res_branch) {
                                if (Helper::checkCodeMeli($_POST['code_meli'])) {
                                    if (isset($_POST['tarikhe_tavalod'])) {
                                        $_POST['tarikhe_tavalod'] = Helper::Fix_Date_Seperator($_POST['tarikhe_tavalod']);
                                        $date_arr                 = array();
                                        $date_arr                 = explode("/", $_POST['tarikhe_tavalod']);
                                        if (count($date_arr) > 2) {
                                            $year                     = (int) Helper::convert_numbers($date_arr[0], false);
                                            $month                    = (int) Helper::convert_numbers($date_arr[1], false);
                                            $day                      = (int) Helper::convert_numbers($date_arr[2], false);
                                            $_POST['tarikhe_tavalod'] = Helper::jalali_to_gregorian($year, $month, $day, '/');
                                        }
                                    }
                                    if ($_POST['id'] === "empty") {
                                        if(Helper::check_add_access('modir')){
                                        /////////////////insert request///////////////////
                                        if ($res_branch[0]['baladasti_id'] === 0) {
                                            ///namayande asli
                                            echo Helper::Alert_Message('na');
                                        } else {
                                            //namayande sathe 2
                                            if (Helper::Is_Empty_OR_Null($_POST['username']) && strlen($_POST['username']) > 3) {
                                                if (Helper::Is_Empty_OR_Null($_POST['password']) && strlen($_POST['password']) > 3) {
                                                    $sql      = "SELECT count(*) as rows_num FROM bnm_users WHERE username=?";
                                                    $res_init = Db::secure_fetchall($sql, array($_POST['username']), true);
                                                    if ($res_init[0]['rows_num'] === 0) {
                                                        if((int) $_POST['ismodir']===1){
                                                            $sql="UPDATE bnm_operator SET ismodir= :ismodir WHERE branch_id=:branch_id";
                                                            $resismodir=Db::secure_update_array($sql, ['ismodir'=>0,'branch_id'=>$_POST['branch_id']]);
                                                        }
                                                        unset($_POST['id']);
                                                        $_POST['user_type'] = __MODIR2USERTYPE__;
                                                        $sql                = Helper::Insert_Generator($_POST, 'bnm_operator');
                                                        $res                = Db::secure_insert_array($sql, $_POST);
                                                        if (!$res) {
                                                            echo "<script>alert('عملیات ناموفق لطفا دوباره تلاش کنید.');</script>";
                                                        } elseif ($res) {
                                                            $user_id          = (int) $res;
                                                            $arr              = array();
                                                            $password         = Helper::str_md5($_POST['password']);
                                                            $arr['user_type'] = __MODIR2USERTYPE__;
                                                            $arr['username']  = $_POST['username'];
                                                            $arr['password']  = $password;
                                                            $arr['branch_id'] = $res_branch[0]['id'];
                                                            $arr['user_id']   = $user_id;
                                                            $sql              = Helper::Insert_Generator($arr, 'bnm_users');
                                                            $res              = Db::secure_insert_array($sql, $arr);
                                                            if (!$res) {
                                                                echo Helper::Alert_Message('f');
                                                            } elseif ($res) {
                                                                echo Helper::Alert_Message('s');
                                                            }
                                                            ////agar sabt nashod operator delete shavad????
                                                        }
                                                    } else {
                                                        echo Helper::Alert_Message('uae');
                                                    }

                                                } else {
                                                    echo Helper::Alert_Message('ple');
                                                }
                                            } else {
                                                echo Helper::Alert_Message('ule');
                                            }
                                        }
                                    } else echo Helper::Alert_Message('na');
                                    } elseif (Helper::Is_Empty_OR_Null($_POST['id'])) {
                                        if(Helper::check_update_access('modir')){
                                        $res_branch=Db::secure_fetchall($sql_branch,array($_SESSION['branch_id']));
                                            if ($res_branch) {
                                                if ($res_branch[0]['id'] === $_SESSION['branch_id']) {
                                                    // $_POST['user_type'] = __MODIR2USERTYPE__;
                                                    if((int) $_POST['ismodir']===1){
                                                        $sql="UPDATE bnm_operator SET ismodir= :ismodir WHERE branch_id=:branch_id";
                                                        $resismodir=Db::secure_update_array($sql, ['ismodir'=>0,'branch_id'=>$_POST['branch_id']]);
                                                    }
                                                    $_POST            = Helper::Unset_IN_Array($_POST, array('username', 'password', 'branch_id','user_type'));
                                                    $sql              = Helper::Update_Generator($_POST, 'bnm_operator', "WHERE id = :id");
                                                    $res              = Db::secure_update_array($sql, $_POST);
                                                } else {
                                                    die(Helper::Json_Message('f'));
                                                }

                                            } else {
                                                echo Helper::Alert_Message('binf');
                                            }
                                        } else echo Helper::Alert_Message('na');
                                    } else {
                                        echo Helper::Alert_Message('na');
                                    }
                                } else {
                                    echo Helper::Alert_Message('cmnv');
                                }
                        } else {
                            echo Helper::Alert_Message('binf');
                        }
                        break;
                    default:
                        echo Helper::Alert_Message('na');
                        break;
                }
            } else {
                echo Helper::Alert_Message('af');
            }

        }
        $this->view->pagename = 'modir';
        $this->view->render('modir', 'dashboard_template', '/public/js/modir.js', false);
    }
}
