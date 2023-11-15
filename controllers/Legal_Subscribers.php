<?php defined('__ROOT__') or exit('No direct script access allowed');

class Legal_Subscribers extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        /*========legal_subscribers========*/
        if (isset($_POST['send_legal_subscribers'])) {
            if (isset($_POST['national_code'])){
                $_POST['code_meli']=$_POST['national_code'];
                unset($_POST['national_code']);
            }
            if (isset($_POST['s_s'])){
                $_POST['shomare_shenasname']=$_POST['s_s'];
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
                            unset($_POST['send_legal_subscribers']);
                            
                            // if (isset($_POST['tarikhe_sabt'])) {
                            //     $date_arr = array();
                            //     $date_arr = explode("/", $_POST['tarikhe_sabt']);
                            //     if (count($date_arr) > 2) {
                            //         $year                  = (int) Helper::convert_numbers($date_arr[0], false);
                            //         $month                 = (int) Helper::convert_numbers($date_arr[1], false);
                            //         $day                   = (int) Helper::convert_numbers($date_arr[2], false);
                            //         $_POST['tarikhe_sabt'] = Helper::jalali_to_gregorian($year, $month, $day, '/');
                            //     }
                            // }
                            // if (isset($_POST['tarikhe_tavalode_modir_amel'])) {
                            //     $date_arr = array();
                            //     $date_arr = explode("/", $_POST['tarikhe_tavalode_modir_amel']);
                            //     if (count($date_arr) > 2) {
                            //         $year                                 = (int) Helper::convert_numbers($date_arr[0], false);
                            //         $month                                = (int) Helper::convert_numbers($date_arr[1], false);
                            //         $day                                  = (int) Helper::convert_numbers($date_arr[2], false);
                            //         $_POST['tarikhe_tavalode_modir_amel'] = Helper::jalali_to_gregorian($year, $month, $day, '/');
                            //     }
                            // }
                            $_POST['tarikhe_sabt']= Helper::TabdileTarikh($_POST['tarikhe_sabt'], 2, '/', '-');
                            $_POST['tarikhe_tavalod']= Helper::TabdileTarikh($_POST['tarikhe_tavalod'], 2, '/', '-');
                            // Helper::cLog($_POST);
                            // die();
                            if (isset($_FILES["l_t_agahie_tasis"]) && $_FILES["l_t_agahie_tasis"]['name'] != '' && isset($_POST['code_meli']) && $_POST['code_meli'] != '') {
                                $res = Helper::upload_file("l_t_agahie_tasis", $_FILES, "moshtarakine_hoghoghi\\", $_POST['code_meli'], "tasvire_agahietasis");
                                if ($res) {
                                    $_POST['l_t_agahie_tasis'] = $res;
                                }
                            } else {
                                unset($_POST['l_t_agahie_tasis']);

                            }
                            if (isset($_FILES["l_t_akharin_taghirat"]) && $_FILES["l_t_akharin_taghirat"]['name'] != '' && isset($_POST['code_meli']) && $_POST['code_meli'] != '') {
                                $res = Helper::upload_file("l_t_akharin_taghirat", $_FILES, "moshtarakine_hoghoghi\\", $_POST['code_meli'], "tasvire_akharintaghirat");
                                if ($res) {
                                    $_POST['l_t_akharin_taghirat'] = $res;

                                }
                            } else {
                                unset($_POST['l_t_akharin_taghirat']);

                            }
                            if (isset($_FILES["l_t_saheb_kartemeli_emzaye_aval"]) && $_FILES["l_t_saheb_kartemeli_emzaye_aval"]['name'] != '' && isset($_POST['code_meli']) && $_POST['code_meli'] != '') {
                                $res = Helper::upload_file("l_t_saheb_kartemeli_emzaye_aval", $_FILES, "moshtarakine_hoghoghi\\", $_POST['code_meli'], "tasvire_saheb_kartemeliemzayeaval");
                                if ($res) {
                                    $_POST['l_t_saheb_kartemeli_emzaye_aval'] = $res;

                                }
                            } else {
                                unset($_POST['l_t_saheb_kartemeli_emzaye_aval']);

                            }
                            if (isset($_FILES["l_t_saheb_kartemeli_emzaye_dovom"]) && $_FILES["l_t_saheb_kartemeli_emzaye_dovom"]['name'] != '' && isset($_POST['code_meli']) && $_POST['code_meli'] != '') {
                                $res = Helper::upload_file("l_t_saheb_kartemeli_emzaye_dovom", $_FILES, "moshtarakine_hoghoghi\\", $_POST['code_meli'], "tasvire_sahebkartemeliemzayedovom");
                                if ($res) {
                                    $_POST['l_t_saheb_kartemeli_emzaye_dovom'] = $res;
                                }
                            } else {
                                unset($_POST['l_t_saheb_kartemeli_emzaye_dovom']);

                            }
                            if (isset($_FILES["l_t_kartemeli_namayande"]) && $_FILES["l_t_kartemeli_namayande"]['name'] != '' && isset($_POST['code_meli']) && $_POST['code_meli'] != '') {
                                $res = Helper::upload_file("l_t_kartemeli_namayande", $_FILES, "moshtarakine_hoghoghi\\", $_POST['code_meli'], "tasvire_kartemelinamayande");
                                if ($res) {
                                    $_POST['l_t_kartemeli_namayande'] = $res;

                                }
                            } else {
                                unset($_POST['l_t_kartemeli_namayande']);

                            }
                            if (isset($_FILES["l_t_moarefiname_namayande"]) && $_FILES["l_t_moarefiname_namayande"]['name'] != '' && isset($_POST['code_meli']) && $_POST['code_meli'] != '') {
                                $res = Helper::upload_file("l_t_moarefiname_namayande", $_FILES, "moshtarakine_hoghoghi\\", $_POST['code_meli'], "tasvire_moarefinamenamayande");
                                if ($res) {
                                    $_POST['l_t_moarefiname_namayande'] = $res;

                                }
                            } else {
                                unset($_POST['l_t_moarefiname_namayande']);

                            }
                            if (isset($_FILES["l_t_ghabze_telephone"]) && $_FILES["l_t_ghabze_telephone"]['name'] != '' && isset($_POST['code_meli']) && $_POST['code_meli'] != '') {
                                $res = Helper::upload_file("l_t_ghabze_telephone", $_FILES, "moshtarakine_hoghoghi\\", $_POST['code_meli'], "tasvire_ghabzetelephone");
                                if ($res) {
                                    $_POST['l_t_ghabze_telephone'] = $res;

                                }
                            } else {
                                unset($_POST['l_t_ghabze_telephone']);

                            }
                            if (isset($_FILES["l_t_gharardad"]) && $_FILES["l_t_gharardad"]['name'] != '' && isset($_POST['code_meli']) && $_POST['code_meli'] != '') {
                                $res = Helper::upload_file("l_t_gharardad", $_FILES, "moshtarakine_hoghoghi\\", $_POST['code_meli'], "tasvire_gharardad");
                                if ($res) {
                                    $_POST['l_t_gharardad'] = $res;

                                }
                            } else {
                                unset($_POST['l_t_gharardad']);

                            }
                            if (isset($_FILES["l_t_ejarename_malekiat"]) && $_FILES["l_t_ejarename_malekiat"]['name'] != '' && isset($_POST['code_meli']) && $_POST['code_meli'] != '') {
                                $res = Helper::upload_file("l_t_ejarename_malekiat", $_FILES, "moshtarakine_hoghoghi\\", $_POST['code_meli'], "tasvire_ejarenamemalekiat");
                                if ($res) {
                                    $_POST['l_t_ejarename_malekiat'] = $res;

                                }
                            } else {
                                unset($_POST['l_t_ejarename_malekiat']);

                            }
                            if (isset($_FILES["l_t_sayer"]) && $_FILES["l_t_sayer"]['name'] != '' && isset($_POST['code_meli']) && $_POST['code_meli'] != '') {

                                $res = Helper::upload_file("l_t_sayer", $_FILES, "moshtarakine_hoghoghi\\", $_POST['code_meli'], "tasvire_sayer");
                                if ($res) {
                                    $_POST['l_t_sayer'] = $res;

                                }
                            } else {
                                unset($_POST['l_t_sayer']);
                            }

                            $_POST = Helper::xss_check_array($_POST);
                            if ($_POST['id'] == "empty") {
                                if(! Helper::checkSubExist($_POST['code_meli'], $_POST['telephone_hamrah'], $_POST['telephone1'])){
                                    unset($_POST['id']);
                                    $sql                = Helper::Insert_Generator($_POST, 'bnm_subscribers');
                                    $res                = Db::secure_insert_array($sql, $_POST);
                                    if ($res) {
                                        $id         = (int) $res;
                                        $sql_update = "UPDATE bnm_subscribers SET code_eshterak=$id+1000 WHERE id='$id'";
                                        $res_update = Db::justexecute($sql_update);
                                        ///create user panel account
                                        $sql_sub               = "SELECT * FROM bnm_subscribers WHERE id = ?";
                                        $res_sub               = Db::secure_fetchall($sql_sub, array($id));
                                        $user_arr              = array();
                                        $user_arr['branch_id'] = $_POST['branch_id'];
                                        $user_arr['user_id']   = $id;
                                        $user_arr['username']  = $_POST['code_meli'];
                                        $user_arr['password']  = Helper::str_split_from_end($_POST['code_meli'], 4);
                                        $user_arr['password']  = Helper::str_md5($user_arr['password']);
                                        $user_arr['user_type'] = '5';
                                        $user_arr['semat']     = 'مشترک';
                                        $sql                   = Helper::Insert_Generator($user_arr, 'bnm_users');
                                        $res                   = Db::secure_insert_array($sql, $user_arr);
                                        // ShahkarHelper::estAuthSub($res);
                                        echo Helper::Alert_Message('s');
                                        ////////////////send sms///////////////
                                        // $res_sub = Helper::Select_By_Id('bnm_subscribers', $id);
                                        // if ($res_sub) {
                                        //     if ($res) {
                                        //         if ($res_sub[0]['branch_id'] === 0) {
                                        //             ////user sahar
                                        //             $res_internal = Helper::Internal_Message_By_Karbord('sms', '1');
                                        //             if ($res_internal) {
                                        //                 $res_sms_request = Helper::Write_In_Sms_Request($res_sub[0]['telephone_hamrah'], Helper::Today_Miladi_Date(),
                                        //                     Helper::Today_Miladi_Date(), 1, $res_internal[0]['id'], '2');
                                        //                 if ($res_sms_request) {
                                        //                     $arr               = array();
                                        //                     $arr['receiver']   = $res_sub[0]['telephone_hamrah'];
                                        //                     $arr['sender']     = __SMSNUMBER__;
                                        //                     $arr['request_id'] = $res_sms_request;
                                        //                     $res               = Helper::Write_In_Sms_Queue($arr);
                                        //                 }
                                        //             }
                                        //         } elseif (Helper::Is_Empty_OR_Null($res_sub[0]['branch_id'])) {
                                        //             //user namayande
                                        //             $res_internal = Helper::Internal_Message_By_Karbord('smn', '1');
                                        //             if ($res_internal) {
                                        //                 $res_sms_request = Helper::Write_In_Sms_Request($res_sub[0]['telephone_hamrah'], Helper::Today_Miladi_Date(),
                                        //                     Helper::Today_Miladi_Date(), 1, $res_internal[0]['id'], '2');
                                        //                 if ($res_sms_request) {
                                        //                     $arr               = array();
                                        //                     $arr['receiver']   = $res_sub[0]['telephone_hamrah'];
                                        //                     $arr['sender']     = __SMSNUMBER__;
                                        //                     $arr['request_id'] = $res_sms_request;
                                        //                     $res               = Helper::Write_In_Sms_Queue($arr);
                                        //                 }
                                        //             }
                                        //         }
                                        //     } else {

                                        //     }
                                        // }else{
                                        //     echo Helper::Alert_Message('f');
                                        // }
                                        if (!$res) {
                                            echo Helper::Alert_Message('f');
                                        }

                                    } else {
                                        echo Helper::Alert_Message('f');
                                    }
                                }else{
                                    echo Helper::Alert_Message('sae');
                                }
                            } else {
                                $sql     = Helper::Update_Generator($_POST, 'bnm_subscribers', "WHERE id = :id");
                                $res     = Db::secure_update_array($sql, $_POST);
                                $res_sub = Helper::Select_By_Id('bnm_subscribers', $_POST['id']);
                                // ShahkarHelper::estAuthSub($res_sub);
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
                                                    $arr               = array();
                                                    $arr['receiver']   = $res_sub[0]['telephone_hamrah'];
                                                    $arr['sender']     = __SMSNUMBER__;
                                                    $arr['request_id'] = $res_sms_request;
                                                    $res               = Helper::Write_In_Sms_Queue($arr);
                                                }
                                            }
                                        } elseif (Helper::Is_Empty_OR_Null($res_sub[0]['branch_id'])) {
                                            //user namayande
                                            $res_internal = Helper::Internal_Message_By_Karbord('vmn', '1');
                                            if ($res_internal) {
                                                $res_sms_request = Helper::Write_In_Sms_Request($res_sub[0]['telephone_hamrah'], Helper::Today_Miladi_Date(),
                                                    Helper::Today_Miladi_Date(), 1, $res_internal[0]['id'], '2');
                                                if ($res_sms_request) {
                                                    $arr               = array();
                                                    $arr['receiver']   = $res_sub[0]['telephone_hamrah'];
                                                    $arr['sender']     = __SMSNUMBER__;
                                                    $arr['request_id'] = $res_sms_request;
                                                    $res               = Helper::Write_In_Sms_Queue($arr);
                                                }
                                            }
                                        }
                                    } else {

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
        //        $this->view->allUsers = R::findAll( 'bnm_users' );
        //        $this->view->title = 'کاربران';
        $this->view->pagename = 'legal_subscribers';
        $this->view->render('legal_subscribers', 'dashboard_template', '/public/js/legal_subscribers.js', false);

    }
}
