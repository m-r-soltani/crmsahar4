<?php defined('__ROOT__') or exit('No direct script access allowed');

class Real_Subscribers extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        /*========real_subscribers========*/
        if (isset($_POST['send_real_subscribers'])) {

            unset($_POST['shoghl_validate_langFa']);
            if (isset($_POST['national_code'])) {
                $_POST['code_meli'] = $_POST['national_code'];
                unset($_POST['national_code']);
            }
            if (isset($_POST['s_s'])) {
                $_POST['shomare_shenasname'] = $_POST['s_s'];
                unset($_POST['s_s']);
            }
            //todo... code meli replace charachter ('-','/') with ('')
            if (Helper::Login_Just_Check()) {
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                    case __MODIRUSERTYPE__:
                    case __OPERATORUSERTYPE__:
                    case __MODIR2USERTYPE__:
                    case __OPERATOR2USERTYPE__:
                        unset($_POST['send_real_subscribers']);
                        if (isset($_POST['tarikhe_tavalod'])) {
                            $date_arr = array();
                            $date_arr = explode("/", $_POST['tarikhe_tavalod']);
                            if (count($date_arr) > 2) {
                                $year = (int) Helper::convert_numbers($date_arr[0], false);
                                $month = (int) Helper::convert_numbers($date_arr[1], false);
                                $day = (int) Helper::convert_numbers($date_arr[2], false);
                                $_POST['tarikhe_tavalod'] = Helper::jalali_to_gregorian($year, $month, $day, '/');
                            }
                        }
                        if (isset($_FILES["r_t_karte_meli"]) && $_FILES["r_t_karte_meli"]['name'] != '' && isset($_POST['code_meli']) && $_POST['code_meli'] != '') {
                            $res = Helper::upload_file("r_t_karte_meli", $_FILES, "moshtarakine_haghighi\\", $_POST['code_meli'], "tasvire_codemeli");
                            if ($res) {
                                $_POST['r_t_karte_meli'] = $res;
                            } else {
                                unset($_POST['r_t_karte_meli']);
                            }
                        } else {
                            unset($_POST['r_t_karte_meli']);
                        }
                        if (isset($_FILES["r_t_ghabze_telephone"]) && $_FILES["r_t_ghabze_telephone"]['name'] != '' && isset($_POST['code_meli']) && $_POST['code_meli'] != '') {
                            $res = Helper::upload_file("r_t_ghabze_telephone", $_FILES, "moshtarakine_haghighi\\", $_POST['code_meli'], "tasvire_ghabzetelephone");
                            if ($res) {
                                $_POST['r_t_ghabze_telephone'] = $res;
                            } else {
                                unset($_POST['r_t_ghabze_telephone']);
                            }
                        } else {
                            unset($_POST['r_t_ghabze_telephone']);

                        }
                        if (isset($_FILES["r_t_ejare_malekiat"]) && $_FILES["r_t_ejare_malekiat"]['name'] != '' && isset($_POST['code_meli']) && $_POST['code_meli'] != '') {
                            $res = Helper::upload_file("r_t_ejare_malekiat", $_FILES, "moshtarakine_haghighi\\", $_POST['code_meli'], "tasvire_ejaremalekiat");
                            if ($res) {
                                $_POST['r_t_ejare_malekiat'] = $res;
                            } else {
                                unset($_POST['r_t_ejare_malekiat']);
                            }
                        } else {
                            unset($_POST['r_t_ejare_malekiat']);
                        }
                        if (isset($_FILES["r_t_gharardad"]) && $_FILES["r_t_gharardad"]['name'] != '' && isset($_POST['code_meli']) && $_POST['code_meli'] != '') {
                            $res = Helper::upload_file("r_t_gharardad", $_FILES, "moshtarakine_haghighi\\", $_POST['code_meli'], "tasvire_gharardad");
                            if ($res) {
                                $_POST['r_t_gharardad'] = $res;

                            } else {
                                unset($_POST['r_t_gharardad']);

                            }
                        } else {
                            unset($_POST['r_t_gharardad']);

                        }
                        if (isset($_FILES["r_t_sayer"]) && $_FILES["r_t_sayer"]['name'] != '' && isset($_POST['code_meli']) && $_POST['code_meli'] != '') {
                            $res = Helper::upload_file("r_t_sayer", $_FILES, "moshtarakine_haghighi\\", $_POST['code_meli'], "tasvire_sayer");
                            if ($res) {
                                $_POST['r_t_sayer'] = $res;
                            } else {
                                unset($_POST['r_t_sayer']);
                            }
                        } else {
                            unset($_POST['r_t_sayer']);
                        }
                        if((int)$_POST['noe_shenase_hoviati']===0 && Helper::str_trim($_POST['shomare_shenasname'])===''){
                            echo Helper::Alert_Custom_Message("شماره شناسنامه مشترک خالی ارسال شده!");
                        }else{
                        $_POST = Helper::xss_check_array($_POST);
                        if ($_POST['id'] == "empty") {
                            if (!Helper::checkSubExist($_POST['code_meli'], $_POST['telephone_hamrah'], $_POST['telephone1'])) {
                                unset($_POST['id']);
                                $sql = Helper::Insert_Generator($_POST, 'bnm_subscribers');
                                $res = Db::secure_insert_array($sql, $_POST);
                                if ($res) {
                                    $id = (int) $res;
                                    $sql_update = "UPDATE bnm_subscribers SET code_eshterak=$id+1000 WHERE id='$id'";
                                    $res_update = Db::justexecute($sql_update);
                                    ///create user panel account
                                    $sql_sub = "SELECT * FROM bnm_subscribers WHERE id = ?";
                                    $res_sub = Db::secure_fetchall($sql_sub, array($id));
                                    $user_arr = array();
                                    $user_arr['user_id'] = $id;
                                    $user_arr['branch_id']= $_POST['branch_id'];
                                    $user_arr['username'] = $res_sub[0]['code_meli'];
                                    $user_arr['password'] = Helper::str_split_from_end($res_sub[0]['code_meli'], 4);
                                    $user_arr['password'] = Helper::str_md5($user_arr['password']);
                                    $user_arr['user_type'] = __MOSHTARAKUSERTYPE__;
                                    $user_arr['semat'] = 'مشترک';
                                    $sql = Helper::Insert_Generator($user_arr, 'bnm_users');
                                    $res = Db::secure_insert_array($sql, $user_arr);
                                    
                                    if($res){
                                    //     $sub=Helper::Select_By_Id('bnm_subscribers',$res);
                                    //     Helper::cLog($sub);
                                    // call_user_func(ShahkarHelper::estAuthSub($res));
                                    
                                    }

                                    // Helper::cLog($res);
                                    // Helper::cLog($shahkar);
                                    // echo Helper::Alert_Message('s');
                                    ///////////////////////send sms to user/////////////////////////////
                                    //$res_sub = Helper::Select_By_Id('bnm_subscribers', $id);
                                    // if ($res_sub) {
                                    //     if ($res) {
                                    //         if ($res_sub[0]['branch_id'] === 0) {
                                    //             ////user sahar
                                    //             $res_internal = Helper::Internal_Message_By_Karbord('sms', '1');
                                    //             if ($res_internal) {
                                    //                 $res_sms_request = Helper::Write_In_Sms_Request($res_sub[0]['telephone_hamrah'], Helper::Today_Miladi_Date(),
                                    //                     Helper::Today_Miladi_Date(), 1, $res_internal[0]['id'], '2');
                                    //                 if ($res_sms_request) {
                                    //                     $arr = array();
                                    //                     $arr['receiver'] = $res_sub[0]['telephone_hamrah'];
                                    //                     $arr['sender'] = __SMSNUMBER__;
                                    //                     $arr['request_id'] = $res_sms_request;
                                    //                     $res = Helper::Write_In_Sms_Queue($arr);
                                    //                 }
                                    //             }
                                    //         } elseif (Helper::Is_Empty_OR_Null($res_sub[0]['branch_id'])) {
                                    //             //user namayande
                                    //             $res_internal = Helper::Internal_Message_By_Karbord('smn', '1');
                                    //             if ($res_internal) {
                                    //                 $res_sms_request = Helper::Write_In_Sms_Request($res_sub[0]['telephone_hamrah'], Helper::Today_Miladi_Date(),
                                    //                     Helper::Today_Miladi_Date(), 1, $res_internal[0]['id'], '2');
                                    //                 if ($res_sms_request) {
                                    //                     $arr = array();
                                    //                     $arr['receiver'] = $res_sub[0]['telephone_hamrah'];
                                    //                     $arr['sender'] = __SMSNUMBER__;
                                    //                     $arr['request_id'] = $res_sms_request;
                                    //                     $res = Helper::Write_In_Sms_Queue($arr);
                                    //                 }
                                    //             }
                                    //         }
                                    //     } else {

                                    //     }
                                    // }
                                    ///////////////////////send sms to user/////////////////////////////

                                }else{
                                    echo Helper::Alert_Message('f');    
                                }
                            } else {
                                echo Helper::Alert_Message('sae');
                            }
                        } else {
                            // $_POST['branch_id']=$_SESSION['branch_id'];
                            $res_sub = Helper::Select_By_Id('bnm_subscribers', $_POST['id']);

                            if ($res_sub) {
                                if (Helper::Is_Empty_OR_Null($_POST['id'])) {
                                    switch ($_SESSION['user_type']) {
                                        case __ADMINUSERTYPE__:
                                        case __ADMINOPERATORUSERTYPE__:
                                            $sql = Helper::Update_Generator($_POST, 'bnm_subscribers', "WHERE id = :id");
                                            $res = Db::secure_update_array($sql, $_POST);
                                            // ShahkarHelper::estAuthSub($res);
                                            $res_sub = Helper::Select_By_Id('bnm_subscribers', $_POST['id']);
                                            if ($res_sub) {
                                                if ($res) {
                                                    //log update user info
                                                    Helper::logUserInfoUpdate($_POST['id']);
                                                    if ($res_sub[0]['branch_id'] === 0) {
                                                        ////user sahar
                                                        $res_internal = Helper::Internal_Message_By_Karbord('vms', '1');
                                                        if ($res_internal) {
                                                            $res_sms_request = Helper::Write_In_Sms_Request($res_sub[0]['telephone_hamrah'], Helper::Today_Miladi_Date(),
                                                                Helper::Today_Miladi_Date(), 1, $res_internal[0]['id'], '2');
                                                            if ($res_sms_request) {
                                                                $arr = array();
                                                                $arr['receiver'] = $res_sub[0]['telephone_hamrah'];
                                                                $arr['sender'] = __SMSNUMBER__;
                                                                $arr['request_id'] = $res_sms_request;
                                                                $res = Helper::Write_In_Sms_Queue($arr);
                                                            }
                                                        }
                                                    } elseif (Helper::Is_Empty_OR_Null($res_sub[0]['branch_id'])) {
                                                        //user namayande
                                                        $res_internal = Helper::Internal_Message_By_Karbord('vmn', '1');
                                                        if ($res_internal) {
                                                            $res_sms_request = Helper::Write_In_Sms_Request($res_sub[0]['telephone_hamrah'], Helper::Today_Miladi_Date(),
                                                                Helper::Today_Miladi_Date(), 1, $res_internal[0]['id'], '2');
                                                            if ($res_sms_request) {
                                                                $arr = array();
                                                                $arr['receiver'] = $res_sub[0]['telephone_hamrah'];
                                                                $arr['sender'] = __SMSNUMBER__;
                                                                $arr['request_id'] = $res_sms_request;
                                                                $res = Helper::Write_In_Sms_Queue($arr);
                                                            }
                                                        }
                                                    }
                                                } else {

                                                }
                                            }
                                            break;
                                        case __MODIRUSERTYPE__:
                                        case __OPERATORUSERTYPE__:
                                            if ($res_sub[0]['branch_id'] == $_SESSION['branch_id']) {
                                                unset($_POST['branch_id']);
                                                $sql = Helper::Update_Generator($_POST, 'bnm_subscribers', "WHERE id = :id");
                                                $res = Db::secure_update_array($sql, $_POST);
                                                $res_sub = Helper::Select_By_Id('bnm_subscribers', $_POST['id']);
                                                // call_user_func(ShahkarHelper::estAuthSub($res));
                                                if ($res_sub) {
                                                    if ($res) {
                                                        //log update user info
                                                        Helper::logUserInfoUpdate($_POST['id']);
                                                        if ($res_sub[0]['branch_id'] === 0) {
                                                            ////user sahar
                                                            $res_internal = Helper::Internal_Message_By_Karbord('vms', '1');
                                                            if ($res_internal) {
                                                                $res_sms_request = Helper::Write_In_Sms_Request($res_sub[0]['telephone_hamrah'], Helper::Today_Miladi_Date(),
                                                                    Helper::Today_Miladi_Date(), 1, $res_internal[0]['id'], '2');
                                                                if ($res_sms_request) {
                                                                    $arr = array();
                                                                    $arr['receiver'] = $res_sub[0]['telephone_hamrah'];
                                                                    $arr['sender'] = __SMSNUMBER__;
                                                                    $arr['request_id'] = $res_sms_request;
                                                                    $res = Helper::Write_In_Sms_Queue($arr);
                                                                }
                                                            }
                                                        } elseif (Helper::Is_Empty_OR_Null($res_sub[0]['branch_id'])) {
                                                            //user namayande
                                                            $res_internal = Helper::Internal_Message_By_Karbord('vmn', '1');
                                                            if ($res_internal) {
                                                                $res_sms_request = Helper::Write_In_Sms_Request($res_sub[0]['telephone_hamrah'], Helper::Today_Miladi_Date(),
                                                                    Helper::Today_Miladi_Date(), 1, $res_internal[0]['id'], '2');
                                                                if ($res_sms_request) {
                                                                    $arr = array();
                                                                    $arr['receiver'] = $res_sub[0]['telephone_hamrah'];
                                                                    $arr['sender'] = __SMSNUMBER__;
                                                                    $arr['request_id'] = $res_sms_request;
                                                                    $res = Helper::Write_In_Sms_Queue($arr);
                                                                }
                                                            }
                                                        }
                                                    } else {

                                                    }
                                                }
                                            } else {
                                                echo Helper::Alert_Message('na');
                                            }
                                            break;
                                        default:
                                            echo Helper::Alert_Message('f');
                                            break;
                                    }

                                } else {
                                    echo Helper::Alert_Message('f');
                                }

                            } else {
                                echo Helper::Alert_Message('f');
                            }

                        }
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
        $this->view->pagename = 'real_subscribers';
        $this->view->render('real_subscribers', 'dashboard_template', '/public/js/real_subscribers.js', false);

    }
}
