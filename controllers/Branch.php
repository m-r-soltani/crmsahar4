<?php defined('__ROOT__') or exit('No direct script access allowed');

class Branch extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        /*========sabte branch========*/
        if (isset($_POST['send_branch'])) {
            unset($_POST['send_branch']);
            try {
                
                if((int)$_POST['noe_namayandegi']===0){
                    if($_POST['tarikhe_sabt']){
                        $_POST['tarikhe_sabt']= Helper::TabdileTarikh($_POST['tarikhe_sabt'], 2, '/', '-');
                    }
                }

                ///////////////////////t_logo
                if (isset($_FILES["t_logo"]) && $_FILES["t_logo"]['name'] != '' && isset($_POST['shomare_sabt']) && $_POST['shomare_sabt'] != '') {
                    $res = Helper::upload_file("t_logo", $_FILES, "namayandegiha\\", $_POST['shomare_sabt'], "tasvire_logo");

                    if ($res) {
                        $_POST['t_logo'] = $res;
                    } else {
                        unset($_POST['t_logo']);
                    }
                } else {
                    unset($_POST['t_logo']);
                }
                ///////////////////////t_mohiti
                if (isset($_FILES["t_mohiti"]) && $_FILES["t_mohiti"]['name'] != '' && isset($_POST['shomare_sabt']) && $_POST['shomare_sabt'] != '') {
                    $res = Helper::upload_file("t_mohiti", $_FILES, "namayandegiha\\", $_POST['shomare_sabt'], "tasvire_mohiti");
                    if ($res) {
                        $_POST['t_mohiti'] = $res;
                    } else {
                        unset($_POST['t_mohiti']);
                    }
                } else {
                    unset($_POST['t_mohiti']);
                }
                ///////////////////////t_tablo
                if (isset($_FILES["t_tablo"]) && $_FILES["t_tablo"]['name'] != '' && isset($_POST['shomare_sabt']) && $_POST['shomare_sabt'] != '') {
                    $res = Helper::upload_file("t_tablo", $_FILES, "namayandegiha\\", $_POST['shomare_sabt'], "tasvire_tablo");
                    if ($res) {
                        $_POST['t_tablo'] = $res;
                    } else {
                        unset($_POST['t_tablo']);
                    }
                } else {
                    unset($_POST['t_tablo']);
                }
                ///////////////////////t_code_eghtesadi
                if (isset($_FILES["t_code_eghtesadi"]) && $_FILES["t_code_eghtesadi"]['name'] != '' && isset($_POST['shomare_sabt']) && $_POST['shomare_sabt'] != '') {
                    $res = Helper::upload_file("t_code_eghtesadi", $_FILES, "namayandegiha\\", $_POST['shomare_sabt'], "tasvire_code_eghtesadi");
                    if ($res) {
                        $_POST['t_code_eghtesadi'] = $res;
                    } else {
                        unset($_POST['t_code_eghtesadi']);
                    }
                } else {
                    unset($_POST['t_code_eghtesadi']);
                }
                ///////////////////////t_rozname_tasis
                if (isset($_FILES["t_rozname_tasis"]) && $_FILES["t_rozname_tasis"]['name'] != '' && isset($_POST['shomare_sabt']) && $_POST['shomare_sabt'] != '') {
                    $res = Helper::upload_file("t_rozname_tasis", $_FILES, "namayandegiha\\", $_POST['shomare_sabt'], "tasvire_rozname_tasis");
                    if ($res) {
                        $_POST['t_rozname_tasis'] = $res;
                    } else {
                        unset($_POST['t_rozname_tasis']);
                    }
                } else {
                    unset($_POST['t_rozname_tasis']);
                }
                ///////////////////////t_shenase_meli
                if (isset($_FILES["t_shenase_meli"]) && $_FILES["t_shenase_meli"]['name'] != '' && isset($_POST['shomare_sabt']) && $_POST['shomare_sabt'] != '') {
                    $res = Helper::upload_file("t_shenase_meli", $_FILES, "namayandegiha\\", $_POST['shomare_sabt'], "tasvire_shenase_meli");
                    if ($res) {
                        $_POST['t_shenase_meli'] = $res;
                    } else {
                        unset($_POST['t_shenase_meli']);
                    }
                } else {
                    unset($_POST['t_shenase_meli']);
                }
                ///////////////////////t_shenase_meli
                if (isset($_FILES["t_akharin_taghirat"]) && $_FILES["t_akharin_taghirat"]['name'] != '' && isset($_POST['shomare_sabt']) && $_POST['shomare_sabt'] != '') {
                    $res = Helper::upload_file("t_akharin_taghirat", $_FILES, "namayandegiha\\", $_POST['shomare_sabt'], "tasvire_akharin_taghirat");
                    if ($res) {
                        $_POST['t_akharin_taghirat'] = $res;
                    } else {
                        unset($_POST['t_akharin_taghirat']);
                    }
                } else {
                    unset($_POST['t_akharin_taghirat']);
                }
                if ($_POST['id'] === "empty") {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            if(Helper::check_add_access('branch')){
                            //$exceptions = array("t_logo", "t_mohiti", "t_tablo", "t_code_eghtesadi", "t_rozname_tasis", "t_shenase_meli", "t_akharin_taghirat");
                            unset($_POST['id']);
                            $sql = Helper::Insert_Generator($_POST, 'bnm_branch');
                            $res = Db::secure_insert_array($sql, $_POST);
                            }else {
                                echo Helper::Alert_Message('na');
                            }
                            break;
                        default:
                            echo Helper::Alert_Message('af');
                            break;
                    }
                } elseif (Helper::Is_Empty_OR_Null($_POST['id'])) {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            if(Helper::check_update_access('branch')){
                            $_POST['id'] = (int) $_POST['id'];
                            $exceptions  = array("t_logo", "t_mohiti", "t_tablo", "t_code_eghtesadi", "t_rozname_tasis", "t_shenase_meli", "t_akharin_taghirat");
                            $sql         = Helper::Update_Generator($_POST, 'bnm_branch', "WHERE id = :id", $exceptions);
                            $res         = Db::secure_update_array($sql, $_POST);
                            }else echo Helper::Alert_Message('na');
                            break;
                        case __MODIRUSERTYPE__:
                        case __OPERATORUSERTYPE__:
                        case __MODIR2USERTYPE__:
                        case __OPERATOR2USERTYPE__:
                            if(Helper::check_update_access('branch')){
                            if ($_SESSION['branch_id'] === (int) $_POST['id']) {
                                $_POST['id'] = (int) $_POST['id'];
                                $exceptions  = array("t_logo", "t_mohiti", "t_tablo", "t_code_eghtesadi", "t_rozname_tasis", "t_shenase_meli", "t_akharin_taghirat");
                                $sql         = Helper::Update_Generator($_POST, 'bnm_branch', "WHERE id = :id", $exceptions);
                                $res         = Db::secure_update_array($sql);
                            } else {
                                echo Helper::Alert_Message('na');
                            }
                        } else {
                            echo Helper::Alert_Message('na');
                        }
                            break;
                        default:
                            echo Helper::Alert_Message('na');
                            break;
                    }
                } else {
                    echo Helper::Alert_Message('f');
                }

            } catch (Throwable $e) {
                $res = Helper::Exc_Error_Debug($e, true, '', false);
                die();
            }

        }
//        $this->view->allUsers = R::findAll( 'bnm_users' );
        //        $this->view->title = 'کاربران';
        $this->view->home     = 'داشبورد';
        $this->view->page     = 'نمایندگی';
        $this->view->page_url = 'branch';
        $this->view->pagename = 'branch';
        $this->view->render('branch', 'dashboard_template', '/public/js/branch.js', false);
    }
}
