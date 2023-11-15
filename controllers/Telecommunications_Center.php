<?php defined('__ROOT__') or exit('No direct script access allowed');

class Telecommunications_Center extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        /*========sabte telecommunications_center========*/
        if (isset($_POST['send_telecommunications_center'])) {
            // die(json_encode($_POST));
            // parse_str($_POST[key($_POST)], $_POST);
            // $_POST = Helper::xss_check_array($_POST);
            unset($_POST['send_telecommunications_center']);
            $pre_nums = array();
            if (isset($_POST['pre_nums'])) {
                $pre_nums = $_POST['pre_nums'];
                unset($_POST['pre_nums']);
            }
            $_POST = Helper::xss_check_array($_POST);
            if (Helper::Login_Just_Check()) {
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                        if ($_POST['id'] === "empty") {
                            unset($_POST['id']);
                            $sql = Helper::Insert_Generator($_POST, 'bnm_telecommunications_center');
                            $res = Db::secure_insert_array($sql, $_POST);
                            if ($res) {
                                $flag='insert';
                            } else {
                                die(Helper::Custom_Msg(Helper::Messages('f'), 3));
                            }
                        } else {
                            $sql = Helper::Update_Generator($_POST, 'bnm_telecommunications_center', "WHERE id = :id");
                            $res = Db::secure_update_array($sql, $_POST);
                            if ($res) {
                                $flag='update';
                            } else {
                                die(Helper::Custom_Msg(Helper::Messages('f'), 3));
                            }
                        }

                        if ($pre_nums && $flag === 'insert') {
                            $markaze_mokhaberati  = (int) $res;
                            for ($i = 0; $i < count($pre_nums); $i++) {
                                $prenumber        = (int) $pre_nums[$i];
                                $sql = "INSERT INTO bnm_pre_number (prenumber,markaze_mokhaberati) VALUES(?,?)";
                                $res = Db::secure_insert_array($sql,array($prenumber, $markaze_mokhaberati));
                                if(!$res){
                                    die(Helper::Alert_Message('f'));
                                }else{
                                    die(Helper::Alert_Message('s'));
                                }
                            }
                        } elseif ($pre_nums && $flag === 'update' && $_POST['id'] !== 'empty' && $_POST['id']) {
                            $id                     = $_POST['id'];
                            $markaze_mokhaberati    = $id;
                            $sql                    = "DELETE FROM bnm_pre_number WHERE markaze_mokhaberati= $id";
                            $del                    = Db::justexecute($sql);
                            for ($i = 0; $i < count($pre_nums); $i++) {
                                $prenumber          = (int) $pre_nums[$i];
                                $ostan_prenumber    = $_POST['pish_shomare_ostan'];
                                $sql                = "INSERT INTO bnm_pre_number (prenumber,markaze_mokhaberati) VALUES(?,?)";
                                $res                = Db::secure_insert_array($sql,array($prenumber, $markaze_mokhaberati));
                                if(!$res){
                                    die(Helper::Alert_Message('f'));
                                }else{
                                    die(Helper::Alert_Message('s'));
                                }
                            }
                        }else die(Helper::Alert_Message('f'));
                        break;
                    default:
                        die(Helper::Custom_Msg(Helper::Messages('na'), 3));
                        break;
                }
            }
        }
        // if (isset($_POST['send_telecommunications_center'])) {
        //     try{
        //         if(Helper::Login_Just_Check()){
        //             switch ($_SESSION['user_type']) {
        //                 case __ADMINUSERTYPE__:
        //                 case __ADMINOPERATORUSERTYPE__:
        //                         unset($_POST['send_telecommunications_center']);
        //                         $flag     = false;
        //                         $pre_nums = array();
        //                         if (isset($_POST['pre_nums'])) {
        //                             $pre_nums = $_POST['pre_nums'];
        //                             unset($_POST['pre_nums']);
        //                         }
        //                         $_POST = Helper::xss_check_array($_POST);
        //                         if ($_POST['id'] === "empty") {
        //                             if(Helper::check_add_access('telecommunications_center')){
        //                             unset($_POST['id']);
        //                             $sql = Helper::Insert_Generator($_POST, 'bnm_telecommunications_center');
        //                             $res = Db::secure_insert_array($sql, $_POST);
        //                             if ($res) {
        //                                 $flag = 'insert';
        //                             }else die(Helper::Alert_Message('f'));
        //                         }else echo(Helper::Alert_Message('na'));
        //                         } else {
        //                             if(Helper::check_update_access('telecommunications_center')){
        //                             $sql = Helper::Update_Generator($_POST, 'bnm_telecommunications_center', "WHERE id = :id");
        //                             $res = Db::secure_update_array($sql, $_POST);
        //                             if ($res) {
        //                                 $flag = 'update';
        //                             }else die(Helper::Alert_Message('f'));
        //                             }else echo Helper:: Alert_Message('na');
        //                         }
        //                         /////////////////////sabte pish shomre dar bnm_pre_number
        //                         if ($pre_nums && $flag === 'insert') {
        //                             //$telelastid          = "SELECT LAST_INSERT_ID() FROM bnm_telecommunications_center";
        //                             // $res2                = Db::fetchall_Query($telelastid);
        //                             $markaze_mokhaberati  = (int) $res;
        //                             for ($i = 0; $i < count($pre_nums); $i++) {
        //                                 $prenumber        = (int) $pre_nums[$i];
        //                                 $ostan            = (int) $_POST['ostan'];
        //                                 $shahr            = (int) $_POST['shahr'];
        //                                 $ostan_prenumber  = $_POST['pish_shomare_ostan'];
        //                                 $insert_prenumber = "INSERT INTO bnm_pre_number (prenumber,ostan,shahr,markaze_mokhaberati,ostan_prenumber)
        //                                 VALUES(?,?,?,?,?)";
        //                                 // $res = Db::secure_simple_insert_array($insert_prenumber, array($prenumber, $ostan, $shahr, $markaze_mokhaberati, $ostan_prenumber));
        //                                 $res = Db::secure_insert_array($insert_prenumber,array($prenumber, $ostan, $shahr, $markaze_mokhaberati, $ostan_prenumber));
        //                                 if(!$res){
        //                                     die(Helper::Alert_Message('f'));
        //                                 }
        //                             }
        //                         } elseif ($pre_nums && $flag === 'update' && $_POST['id'] !== 'empty') {
        //                             $id                  = $_POST['id'];
        //                             $markaze_mokhaberati = $id;
        //                             for ($i = 0; $i < count($pre_nums); $i++) {
        //                                 $prenumber        = (int) $pre_nums[$i];
        //                                 $ostan            = (int) $_POST['ostan'];
        //                                 $shahr            = (int) $_POST['shahr'];
        //                                 $ostan_prenumber  = $_POST['pish_shomare_ostan'];
        //                                 $insert_prenumber = "INSERT INTO bnm_pre_number (prenumber,ostan,shahr,markaze_mokhaberati,ostan_prenumber)
        //                                 VALUES(?,?,?,?,?)";
        //                                 // $res = Db::secure_simple_insert_array($insert_prenumber, array($prenumber, $ostan, $shahr, $markaze_mokhaberati, $ostan_prenumber));
        //                                 // if (!$res) {
        //                                 //     echo 'bbb';
        //                                 //     die();
        //                                 // }
        //                                 $res = Db::secure_insert_array($insert_prenumber,array($prenumber, $ostan, $shahr, $markaze_mokhaberati, $ostan_prenumber));
        //                                 if(!$res){
        //                                     die(Helper::Alert_Message('f'));
        //                                 }
        //                             }
        //                         }else die(Helper::Alert_Message('f'));
        //                     break;

        //                 default:
        //                     echo Helper::Alert_Message('na');
        //                     break;
        //             }

        //         }else {
        //             echo Helper::Alert_Message('af');

        //         }
        //     }catch(Throwable $e){
        //         echo Helper::Exc_Error_Debug($e,true,'',false);
        //     }

        // }

        // if ($_POST['id'] == "empty") {
        //     $sql = Insert_Generator($_POST, 'bnm_telecommunications_center');
        //     Db::justexecute($sql);
        // } else {
        //     $id  = $_POST['id'];
        //     $sql = Update_Generator($_POST, 'bnm_telecommunications_center', "WHERE id = $id");
        //     Db::justexecute($sql);
        // }
        // if(count($pre_nums)>0){
        //     $sql2     = "SELECT LAST_INSERT_ID() FROM bnm_terminal";
        //     $res2     = Db::fetchall_Query($sql2);
        //     $markaze_mokhaberati       = (int)$res2[0][0];
        //     for($i=0;$i<count($pre_nums);$i++){
        //         $prenum=(int)$pre_nums[$i];
        //         $ostan=(int)$_POST['ostan'];
        //         $shahr=(int)$_POST['shahr'];
        //         $sql_pre_num="INSERT INTO bnm_port (ostan,shahr,markaze_mokhaberati,prenum)
        //         VALUES($ostan,$shahr,$markaze_mokhaberati,$prenum)";
        //         Db::justexecute($sql_pre_num);
        //     }
        // }

//        $this->view->allUsers = R::findAll( 'bnm_users' );
        //        $this->view->title = 'کاربران';
        $this->view->pagename = 'telecommunications_center';
        $this->view->render('telecommunications_center', 'dashboard_template', '/public/js/telecommunications_center.js', false);

    }
}
