<?php defined('__ROOT__') or exit('No direct script access allowed');
class Factors extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        //======================EKHTESASE_EMKANAT========================//
        //======================adsl========================//
        if (isset($_POST['send_ekhtesase_emkanat_adsl'])) {
            parse_str($_POST[key($_POST)], $_POST);
            $_POST = Helper::xss_check_array($_POST);
            if (isset($_POST['ekhtesase_emkanat_ekhtesase_adsl_etesal']) && $_POST['ekhtesase_emkanat_ekhtesase_adsl_etesal'] !== '' &&
                isset($_POST['ekhtesase_emkanat_user_id']) && $_POST['ekhtesase_emkanat_user_id'] !== 'empty') {
                $res_sub = Helper::Select_By_Id('bnm_subscribers', $_POST['ekhtesase_emkanat_user_id']);
                $check_sql     = "SELECT * FROM bnm_port WHERE telephone = ? AND user_id = ?";
                $checkres      = Db::secure_fetchall(
                    $check_sql,
                    array(
                        $_POST['ekhtesase_emkanat_adsl_telephone_morede_taghaza'],
                        $_POST['ekhtesase_emkanat_user_id']
                    )
                );
                if (! $checkres && $res_sub) {
                    //check if telephone not registred
                    $arr              = [];
                    $arr['telephone'] = $_POST['ekhtesase_emkanat_adsl_telephone_morede_taghaza'];
                    $arr['user_id']   = $_POST['ekhtesase_emkanat_user_id'];
                    $arr['id']        = $_POST['ekhtesase_emkanat_ekhtesase_adsl_etesal'];
                    $sql              = Helper::Update_Generator($arr, 'bnm_port', "WHERE id = :id");
                    $res              = Db::secure_update_array($sql, $arr);
                    if($res){
                        die(Helper::Custom_Msg(Helper::Messages('s'),1));
                    }else{
                        die(Helper::Custom_Msg(Helper::Messages('f'),2));
                    }
                    ///////////////////send sms//////////////////
                    // if ($res_sub[0]['branch_id'] === 0) {
                    //     ////user sahar
                    //     $res_internal = Helper::Internal_Message_By_Karbord('sfadms', '1');
                    //     if ($res_internal) {
                    //         $sql = Helper::Insert_Generator(
                    //             array(
                    //                 'message'           => $res_internal[0]['message'],
                    //                 'type'              => 2,
                    //                 'message_subject'   => $res_internal[0]['karbord'],
                    //             ),
                    //             'bnm_messages'
                    //         );
                    //         $res_message = Db::secure_insert_array($sql, array(
                    //             'message'           => $res_internal[0]['message'],
                    //             'type'              => 2,
                    //             'message_subject'   => $res_internal[0]['karbord'],
                    //         ));
                    //         $res_sms_request = Helper::Write_In_Sms_Request(
                    //             $res_sub[0]['telephone_hamrah'],
                    //             Helper::Today_Miladi_Date(),
                    //             Helper::Today_Miladi_Date(),
                    //             1,
                    //             $res_message
                    //         );
                    //         if ($res_sms_request) {
                    //             $arr               = array();
                    //             $arr['receiver']   = $res_sub[0]['telephone_hamrah'];
                    //             $arr['sender']     = __SMSNUMBER__;
                    //             $arr['request_id'] = $res_sms_request;
                    //             $res               = Helper::Write_In_Sms_Queue($arr);
                    //         } else {
                    //             die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns'), 1));
                    //         }
                    //         if ($res) {
                    //             die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                    //         } else {
                    //             die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns'), 1));
                    //         }
                    //     } else {
                    //         die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns'), 1));
                    //     }
                    // } elseif (isset($res_sub[0]['branch_id'])) {
                    //     //user namayande
                    //     $res_internal = Helper::Internal_Message_By_Karbord('sfadmn', '1');
                    //     if ($res_internal) {
                    //         $sql = Helper::Insert_Generator(
                    //             array(
                    //                 'message'           => $res_internal[0]['message'],
                    //                 'type'              => 2,
                    //                 'message_subject'   => $res_internal[0]['karbord'],
                    //             ),
                    //             'bnm_messages'
                    //         );
                    //         $res_message = Db::secure_insert_array($sql, array(
                    //             'message'           => $res_internal[0]['message'],
                    //             'type'              => 2,
                    //             'message_subject'   => $res_internal[0]['karbord'],
                    //         ));
                    //         $res_sms_request = Helper::Write_In_Sms_Request(
                    //             $res_sub[0]['telephone_hamrah'],
                    //             Helper::Today_Miladi_Date(),
                    //             Helper::Today_Miladi_Date(),
                    //             1,
                    //             $res_message
                    //         );
                    //         if ($res_sms_request) {
                    //             $arr               = array();
                    //             $arr['receiver']   = $res_sub[0]['telephone_hamrah'];
                    //             $arr['sender']     = __SMSNUMBER__;
                    //             $arr['request_id'] = $res_sms_request;
                    //             $res               = Helper::Write_In_Sms_Queue($arr);
                    //         } else {
                    //             die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns'), 1));
                    //         }
                    //         if ($res) {
                    //             die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                    //         } else {
                    //             die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns'), 1));
                    //         }
                    //     } else {
                    //         die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns'), 1));
                    //     }
                    // } else {
                    //     die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns'), 1));
                    // }

                    /////////////////////send sms//////////////////
                } else {
                    $msg = 'برای این شماره تلفن قبلا پورت ثبت شده است.';
                    die(Helper::Custom_Msg($msg, 3));
                }
            } else {

                die(Helper::Custom_Msg(Helper::Messages('sao'), 3));
            }
        }
        /*========================vdsl============================= */
        if (isset($_POST['send_ekhtesase_emkanat_vdsl'])) {
            parse_str($_POST[key($_POST)], $_POST);
            $_POST = Helper::xss_check_array($_POST);
            if (
                isset($_POST['ekhtesase_emkanat_ekhtesase_vdsl_etesal']) && $_POST['ekhtesase_emkanat_ekhtesase_vdsl_etesal'] != '' &&
                isset($_POST['ekhtesase_emkanat_user_id']) && $_POST['ekhtesase_emkanat_user_id'] !== 'empty'
            ) {
                $res_sub = Helper::Select_By_Id('bnm_subscribers', $_POST['ekhtesase_emkanat_user_id']);
                $check_sql     = "SELECT * FROM bnm_port WHERE telephone = ? AND user_id = ?";
                $checkres      = Db::secure_fetchall(
                    $check_sql,
                    array(
                        $_POST['ekhtesase_emkanat_vdsl_telephone_morede_taghaza'],
                        $_POST['ekhtesase_emkanat_user_id']
                    )
                );
                if (!$checkres && $res_sub) {
                    //check if telephone not registred
                    $arr              = [];
                    $arr['telephone'] = $_POST['ekhtesase_emkanat_vdsl_telephone_morede_taghaza'];
                    $arr['user_id']   = $_POST['ekhtesase_emkanat_user_id'];
                    $arr['id']        = $_POST['ekhtesase_emkanat_ekhtesase_vdsl_etesal'];
                    $sql              = Helper::Update_Generator($arr, 'bnm_port', "WHERE id = :id");
                    $res              = Db::secure_update_array($sql, $arr);
                    if($res){
                        die(Helper::Custom_Msg(Helper::Messages('s'),1));
                    }else{
                        die(Helper::Custom_Msg(Helper::Messages('f'),2));
                    }
                    /////////////////////send sms//////////////////
                    // if ($res_sub[0]['branch_id'] === 0) {
                    //     ////user sahar
                    //     $res_internal = Helper::Internal_Message_By_Karbord('sfvdms', '1');
                    //     if ($res_internal) {
                    //         $sql = Helper::Insert_Generator(
                    //             array(
                    //                 'message'           => $res_internal[0]['message'],
                    //                 'type'              => 2,
                    //                 'message_subject'   => $res_internal[0]['karbord'],
                    //             ),
                    //             'bnm_messages'
                    //         );
                    //         $res_message = Db::secure_insert_array($sql, array(
                    //             'message'           => $res_internal[0]['message'],
                    //             'type'              => 2,
                    //             'message_subject'   => $res_internal[0]['karbord'],
                    //         ));
                    //         $res_sms_request = Helper::Write_In_Sms_Request(
                    //             $res_sub[0]['telephone_hamrah'],
                    //             Helper::Today_Miladi_Date(),
                    //             Helper::Today_Miladi_Date(),
                    //             1,
                    //             $res_message
                    //         );
                    //         if ($res_sms_request) {
                    //             $arr               = array();
                    //             $arr['receiver']   = $res_sub[0]['telephone_hamrah'];
                    //             $arr['sender']     = __SMSNUMBER__;
                    //             $arr['request_id'] = $res_sms_request;
                    //             $res               = Helper::Write_In_Sms_Queue($arr);
                    //         } else {
                    //             die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns'), 1));
                    //         }
                    //         if ($res) {
                    //             die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                    //         } else {
                    //             die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns'), 1));
                    //         }
                    //     } else {
                    //         die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns'), 1));
                    //     }
                    // } elseif (isset($res_sub[0]['branch_id'])) {
                    //     //user namayande
                    //     $res_internal = Helper::Internal_Message_By_Karbord('sfvdmn', '1');
                    //     if ($res_internal) {
                    //         $sql = Helper::Insert_Generator(
                    //             array(
                    //                 'message'           => $res_internal[0]['message'],
                    //                 'type'              => 2,
                    //                 'message_subject'   => $res_internal[0]['karbord'],
                    //             ),
                    //             'bnm_messages'
                    //         );
                    //         $res_message = Db::secure_insert_array($sql, array(
                    //             'message'           => $res_internal[0]['message'],
                    //             'type'              => 2,
                    //             'message_subject'   => $res_internal[0]['karbord'],
                    //         ));
                    //         $res_sms_request = Helper::Write_In_Sms_Request(
                    //             $res_sub[0]['telephone_hamrah'],
                    //             Helper::Today_Miladi_Date(),
                    //             Helper::Today_Miladi_Date(),
                    //             1,
                    //             $res_message
                    //         );
                    //         if ($res_sms_request) {
                    //             $arr               = array();
                    //             $arr['receiver']   = $res_sub[0]['telephone_hamrah'];
                    //             $arr['sender']     = __SMSNUMBER__;
                    //             $arr['request_id'] = $res_sms_request;
                    //             $res               = Helper::Write_In_Sms_Queue($arr);
                    //         } else {
                    //             die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns'), 1));
                    //         }
                    //         if ($res) {
                    //             die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                    //         } else {
                    //             die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns'), 1));
                    //         }
                    //     } else {
                    //         die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns'), 1));
                    //     }
                    // } else {
                    //     die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns'), 1));
                    // }

                    /////////////////////send sms//////////////////
                } else {
                    $msg = 'برای این شماره تلفن قبلا پورت ثبت شده است.';
                    die(Helper::Custom_Msg($msg, 3));
                }
            }
        }
        /*========================WIRELESS============================= */
        if (isset($_POST['send_ekhtesas_emkanat_wireless'])) {
            parse_str($_POST[key($_POST)], $_POST);
            $_POST = Helper::xss_check_array($_POST);
            if (isset($_POST['ekhtesas_emkanat_wireless_station']) && isset($_POST['ekhtesase_emkanat_user_id'])) {
                $user_id    = $_POST['ekhtesase_emkanat_user_id'];
                $station_id = $_POST['ekhtesas_emkanat_wireless_station'];
                $sql        = "SELECT count(*) rows_num FROM bnm_sub_station WHERE sub_id = ? AND station_id = ?";
                $check      = Db::secure_fetchall($sql, [$user_id, $station_id]);
                if($check[0]['rows_num']=== 0){
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            $user_sql   = "SELECT id,code_eshterak,branch_id FROM bnm_subscribers WHERE id = ?";
                            $res_sub    = Db::secure_fetchall($user_sql, array($user_id));        
                        break;
                        case __MODIRUSERTYPE__:
                        case __MODIR2USERTYPE__:
                        case __OPERATORUSERTYPE__:
                        case __OPERATOR2USERTYPE__:
                            $user_sql   = "SELECT id,code_eshterak,branch_id FROM bnm_subscribers WHERE id = ? AND branch_id = ?";
                            $res_sub    = Db::secure_fetchall($user_sql, array($user_id, $_SESSION['branch_id']));        
                        break;
                        default:
                            die(Helper::Json_Message('af'));
                        break;
                    }
                    $arr        = [
                        'station_id'    => $station_id,
                        'sub_id'        => $user_id
                    ];
                    if ($res_sub) {
                        $station_sql = "SELECT id FROM bnm_wireless_station WHERE id= ? AND tarikhe_payan >= CURDATE()";
                        $res_station = Db::secure_fetchall($station_sql, array($station_id));
                        if ($res_station) {
                            $sql = Helper::Insert_Generator($arr, 'bnm_sub_station');
                            $res = Db::secure_insert_array($sql, $arr);
                            if($res){
                                
                                die(Helper::Custom_Msg(Helper::Messages('s'),1));

                            }else{
                                
                                die(Helper::Custom_Msg(Helper::Messages('f'),2));
                            }
                        } else {
                            // die(Helper::Json_Message('f'));
                            $msg= "ایستگاه مورد نظر یافت نشد یا تاریخ بهره برداری از ایستگاه به پایان رسیده";
                            die(Helper::Custom_Msg($msg,2));
                        }
                    } else {
                        die(Helper::Json_Message('f'));
                    }
                    
                    /////////////////////send sms//////////////////
                    // if ($res_sub && $res) {
                    //     if ($res_sub[0]['branch_id'] === 0) {
                    //         ////user sahar
                    //         $res_internal = Helper::Internal_Message_By_Karbord('sfwims', '1');
                    //         if ($res_internal) {
                    //             $sql = Helper::Insert_Generator(
                    //                 array('message' => $res_internal[0]['message'], 'type' => 2, 'message_subject' => $res_internal[0]['karbord'],),
                    //                 'bnm_messages'
                    //             );
                    //             $res_message = Db::secure_insert_array($sql, array(
                    //                 'message'           => $res_internal[0]['message'],
                    //                 'type'              => 2,
                    //                 'message_subject'   => $res_internal[0]['karbord'],
                    //             ));
                    //             $res_sms_request = Helper::Write_In_Sms_Request(
                    //                 $res_sub[0]['telephone_hamrah'],
                    //                 Helper::Today_Miladi_Date(),
                    //                 Helper::Today_Miladi_Date(),
                    //                 1,
                    //                 $res_message
                    //             );
                    //             if ($res_sms_request) {
                    //                 $arr               = array();
                    //                 $arr['receiver']   = $res_sub[0]['telephone_hamrah'];
                    //                 $arr['sender']     = __SMSNUMBER__;
                    //                 $arr['request_id'] = $res_sms_request;
                    //                 $res               = Helper::Write_In_Sms_Queue($arr);
                    //             } else {
                    //                 die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns'), 1));
                    //             }
                    //             if ($res) {
                    //                 die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                    //             } else {
                    //                 die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns'), 1));
                    //             }
                    //         } else {
                    //             die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns'), 1));
                    //         }
                    //     } elseif (isset($res_sub[0]['branch_id'])) {
                    //         //user namayande
                    //         $res_internal = Helper::Internal_Message_By_Karbord('sfwimn', '1');
                    //         if ($res_internal) {
                    //             $sql = Helper::Insert_Generator(
                    //                 array(
                    //                     'message'           => $res_internal[0]['message'],
                    //                     'type'              => 2,
                    //                     'message_subject'   => $res_internal[0]['karbord'],
                    //                 ),
                    //                 'bnm_messages'
                    //             );
                    //             $res_message = Db::secure_insert_array($sql, array(
                    //                 'message'           => $res_internal[0]['message'],
                    //                 'type'              => 2,
                    //                 'message_subject'   => $res_internal[0]['karbord'],
                    //             ));
                    //             $res_sms_request = Helper::Write_In_Sms_Request(
                    //                 $res_sub[0]['telephone_hamrah'],
                    //                 Helper::Today_Miladi_Date(),
                    //                 Helper::Today_Miladi_Date(),
                    //                 1,
                    //                 $res_message
                    //             );
                    //             if ($res_sms_request) {
                    //                 $arr               = array();
                    //                 $arr['receiver']   = $res_sub[0]['telephone_hamrah'];
                    //                 $arr['sender']     = __SMSNUMBER__;
                    //                 $arr['request_id'] = $res_sms_request;
                    //                 $res               = Helper::Write_In_Sms_Queue($arr);
                    //             }else{
                    //                 die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns'), 1));
                    //             }
                    //             if ($res) {
                    //                 die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                    //             } else {
                    //                 die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns'), 1));
                    //             }
                    //         } else {
                    //             die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns'), 1));
                    //         }
                    //     } else {
                    //         die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns'), 1));
                    //     }
                    //     if ($res) {
                    //         die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                    //     }
                    // } else {
                    //     die(Helper::Json_Message('f'));
                    // }
                    /////////////////////send sms//////////////////
                }else{
                    die(Helper::Custom_Msg(Helper::Messages('eaa'),2));
                }
            } else {
                die(Helper::Json_Message('inf'));
            }
        }
        /*========================TDLTE============================= */
        if (isset($_POST['send_ekhtesase_emkanat_tdlte'])) {
            parse_str($_POST[key($_POST)], $_POST);
            $_POST = Helper::xss_check_array($_POST);
            if (isset($_POST['ekhtesase_emkanat_user_id'])) {
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                        $sql        = "SELECT * FROM bnm_subscribers WHERE id =?";
                        $res_sub    = Db::secure_fetchall($sql, array($_POST['ekhtesase_emkanat_user_id']));
                        if ($res_sub) {
                            if (isset($_POST['tdlte_number'])) {
                                $sql        = Helper::Update_Generator(array('id' => $_POST['tdlte_number'], 'subscriber_id' => $res_sub[0]['id']), 'bnm_tdlte_sim', "WHERE id = :id AND subscriber_id IS NULL");
                                $res  = Db::secure_update_array($sql, array('id' => $_POST['tdlte_number'], 'subscriber_id' => $res_sub[0]['id']));
                                if($res){
                                    die(Helper::Custom_Msg(Helper::Messages('s'),1));
                                }else{
                                    die(Helper::Custom_Msg(Helper::Messages('f'),2));
                                }
                                /////////////////////send sms//////////////////
                                // if ($res_tdlte) {
                                //     if ($res_sub[0]['branch_id'] === 0) {
                                //         ////user sahar
                                //         $res_internal = Helper::Internal_Message_By_Karbord('sftdms', '1');
                                //         if ($res_internal) {
                                //             $sql = Helper::Insert_Generator(
                                //                 array(
                                //                     'message'           => $res_internal[0]['message'],
                                //                     'type'              => 2,
                                //                     'message_subject'   => $res_internal[0]['karbord'],
                                //                 ),
                                //                 'bnm_messages'
                                //             );
                                //             $res_message = Db::secure_insert_array($sql, array(
                                //                 'message'           => $res_internal[0]['message'],
                                //                 'type'              => 2,
                                //                 'message_subject'   => $res_internal[0]['karbord'],
                                //             ));
                                //             $res_sms_request = Helper::Write_In_Sms_Request(
                                //                 $res_sub[0]['telephone_hamrah'],
                                //                 Helper::Today_Miladi_Date(),
                                //                 Helper::Today_Miladi_Date(),
                                //                 1,
                                //                 $res_message
                                //             );
                                //             if ($res_sms_request) {
                                //                 $arr               = array();
                                //                 $arr['receiver']   = $res_sub[0]['telephone_hamrah'];
                                //                 $arr['sender']     = __SMSNUMBER__;
                                //                 $arr['request_id'] = $res_sms_request;
                                //                 $res               = Helper::Write_In_Sms_Queue($arr);
                                //             }
                                //             if ($res) {
                                //                 die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                                //             } else {
                                //                 // die(Helper::Custom_Msg(Helper::Messages('s'). ' ' . Helper::Messages('sns'),1));
                                //                 die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns'), 1));
                                //             }
                                //         }
                                //     } elseif (isset($res_sub[0]['branch_id'])) {
                                //         //user namayande
                                //         $res_internal = Helper::Internal_Message_By_Karbord('sftdmn', '1');
                                //         if ($res_internal) {
                                //             $sql = Helper::Insert_Generator(
                                //                 array(
                                //                     'message'           => $res_internal[0]['message'],
                                //                     'type'              => 2,
                                //                     'message_subject'   => $res_internal[0]['karbord'],
                                //                 ),
                                //                 'bnm_messages'
                                //             );
                                //             $res_message = Db::secure_insert_array($sql, array(
                                //                 'message'           => $res_internal[0]['message'],
                                //                 'type'              => 2,
                                //                 'message_subject'   => $res_internal[0]['karbord'],
                                //             ));
                                //             $res_sms_request = Helper::Write_In_Sms_Request(
                                //                 $res_sub[0]['telephone_hamrah'],
                                //                 Helper::Today_Miladi_Date(),
                                //                 Helper::Today_Miladi_Date(),
                                //                 1,
                                //                 $res_message
                                //             );
                                //             if ($res_sms_request) {
                                //                 $arr               = array();
                                //                 $arr['receiver']   = $res_sub[0]['telephone_hamrah'];
                                //                 $arr['sender']     = __SMSNUMBER__;
                                //                 $arr['request_id'] = $res_sms_request;
                                //                 $res               = Helper::Write_In_Sms_Queue($arr);
                                //             }
                                //             if ($res) {
                                //                 die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                                //             } else {
                                //                 die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns'), 1));
                                //             }
                                //         }
                                //     }
                                // } else {
                                //     $tdmsg = 'این شماره به شخص دیگری تعلق دارد یا پیدا نشده لطفا جهت بررسی با پشتیبانی تماس بگیرید.';
                                //     die(Helper::Custom_Msg($tdmsg));
                                // }
                            } else {
                                die(Helper::Json_Message('f'));
                            }
                        } else {
                            die(Helper::Json_Message('f'));
                        }
                        break;
                    case __MODIRUSERTYPE__:
                    case __MODIR2USERTYPE__:
                    case __OPERATORUSERTYPE__:
                    case __OPERATOR2USERTYPE__:
                        $sql        = "SELECT * FROM bnm_subscribers WHERE id =? AND branch_id = ?";
                        $res_sub    = Db::secure_fetchall($sql, array($_POST['ekhtesase_emkanat_user_id'], $_SESSION['branch_id']));
                        if ($res_sub) {
                            if (isset($_POST['tdlte_number'])) {
                                $sql        = Helper::Update_Generator(array('id' => $_POST['tdlte_number'], 'subscriber_id' => $res_sub[0]['id']), 'bnm_tdlte_sim', "WHERE id = :id AND subscriber_id IS NULL AND brand_id = {$_SESSION['brand_id']}");
                                $res  = Db::secure_update_array($sql, array('id' => $_POST['tdlte_number'], 'subscriber_id' => $res_sub[0]['id']));
                                if($res){
                                    die(Helper::Custom_Msg(Helper::Messages('s'),1));
                                }else{
                                    die(Helper::Custom_Msg(Helper::Messages('f'),2));
                                }
                                /////////////////////send sms//////////////////
                                // if ($res_tdlte) {
                                //     if ($res_sub[0]['branch_id'] === 0) {
                                //         ////user sahar
                                //         // $res_internal = Helper::Internal_Message_By_Karbord('sftdms', '1');
                                //         // if ($res_internal) {
                                //         //     $sql=Helper::Insert_Generator(
                                //         //         array(
                                //         //             'message'           => $res_internal[0]['message'],
                                //         //             'type'              => 2,
                                //         //             'message_subject'   => $res_internal[0]['karbord'],
                                //         //         ),
                                //         //         'bnm_messages');
                                //         //         $res_message= Db::secure_insert_array($sql,array(
                                //         //             'message'           => $res_internal[0]['message'],
                                //         //             'type'              => 2,
                                //         //             'message_subject'   => $res_internal[0]['karbord'],
                                //         //         ));
                                //         //     $res_sms_request = Helper::Write_In_Sms_Request($res_sub[0]['telephone_hamrah'], Helper::Today_Miladi_Date(),
                                //         //         Helper::Today_Miladi_Date(), 1, $res_message);
                                //         //     if ($res_sms_request) {
                                //         //         $arr               = array();
                                //         //         $arr['receiver']   = $res_sub[0]['telephone_hamrah'];
                                //         //         $arr['sender']     = __SMSNUMBER__;
                                //         //         $arr['request_id'] = $res_sms_request;
                                //         //         $res               = Helper::Write_In_Sms_Queue($arr);
                                //         //     }
                                //         // if($res){
                                //         //     die (Helper::Custom_Msg(Helper::Messages('s'),1));
                                //         // }else{
                                //         //     die (Helper::Custom_Msg(Helper::Messages('s'). ' ' . Helper::Messages('sns'),1));
                                //         // }
                                //         // }
                                //         die(Helper::Json_Message('f'));
                                //     } elseif (isset($res_sub[0]['branch_id'])) {
                                //         //user namayande
                                //         $res_internal = Helper::Internal_Message_By_Karbord('sftdmn', '1');
                                //         if ($res_internal) {
                                //             $sql = Helper::Insert_Generator(
                                //                 array(
                                //                     'message'           => $res_internal[0]['message'],
                                //                     'type'              => 2,
                                //                     'message_subject'   => $res_internal[0]['karbord'],
                                //                 ),
                                //                 'bnm_messages'
                                //             );
                                //             $res_message = Db::secure_insert_array($sql, array(
                                //                 'message'           => $res_internal[0]['message'],
                                //                 'type'              => 2,
                                //                 'message_subject'   => $res_internal[0]['karbord'],
                                //             ));
                                //             $res_sms_request = Helper::Write_In_Sms_Request(
                                //                 $res_sub[0]['telephone_hamrah'],
                                //                 Helper::Today_Miladi_Date(),
                                //                 Helper::Today_Miladi_Date(),
                                //                 1,
                                //                 $res_message
                                //             );
                                //             if ($res_sms_request) {
                                //                 $arr               = array();
                                //                 $arr['receiver']   = $res_sub[0]['telephone_hamrah'];
                                //                 $arr['sender']     = __SMSNUMBER__;
                                //                 $arr['request_id'] = $res_sms_request;
                                //                 $res               = Helper::Write_In_Sms_Queue($arr);
                                //             }
                                //             if ($res) {
                                //                 die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                                //             } else {
                                //                 die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns'), 1));
                                //             }
                                //         }
                                //     }
                                //     if ($res) {
                                //         die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                                //     } else {
                                //         die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns'), 1));
                                //     }
                                // } else {
                                //     $tdmsg = 'این شماره به شخص دیگری تعلق دارد یا پیدا نشده لطفا جهت بررسی با پشتیبانی تماس بگیرید.';
                                //     die(Helper::Custom_Msg($tdmsg, 4));
                                // }
                            } else {
                                die(Helper::Json_Message('f'));
                            }
                        } else {
                            die(Helper::Json_Message('f'));
                        }
                        break;
                    default:
                        die(Helper::Json_Message('f'));
                    break;
                }
            } else die(Helper::Json_Message('f'));
        }
        //======================EKHTESASE_EMKANAT/========================//

        /////////////////factorha edit modal forms
        /// internet pardakht
        if (isset($_POST['send_ft_nouser_pardakht'])) {
            parse_str($_POST[key($_POST)], $_POST);
            $_POST = Helper::xss_check_array($_POST);
            //shomare_cart,shomare_peygiri,mablaghe_varizi,tarikhe_variz
            $shomare_peygiri = true;
            if ($shomare_peygiri) {
                //check pardakht and update factor table
                $factor_id      = $_POST['factor_id'];
                $factor_sql     = "SELECT * FROM bnm_factor WHERE id = ?";
                $res_factor     = Db::secure_fetchall($factor_sql, array($factor_id));
                $subscriber_id  = $res_factor[0]['subscriber_id'];
                $service_id     = $res_factor[0]['service_id'];
                $sql_services   = "SELECT * FROM bnm_services WHERE id = ?";
                $res_services   = Db::secure_fetchall($sql_services, array($service_id));
                $sql_subscriber = "SELECT *,
                                    CASE
                                        WHEN telephone1= ? THEN address1
                                        WHEN telephone2= ? THEN address2
                                        WHEN telephone3= ? THEN address3
                                    END AS address,
                                    CASE
                                        WHEN telephone1= ? THEN code_posti1
                                        WHEN telephone2= ? THEN code_posti2
                                        WHEN telephone3= ? THEN code_posti3
                                    END AS code_posti
                                     FROM bnm_subscribers WHERE id = ?";
                $res_subscriber = Db::secure_fetchall($sql_subscriber, array($res_factor[0]['ibs_username'], $res_factor[0]['ibs_username'], $res_factor[0]['ibs_username'], $res_factor[0]['ibs_username'], $res_factor[0]['ibs_username'], $res_factor[0]['ibs_username'], $subscriber_id));
                switch ($res_factor[0]['type']) {
                    case 'adsl':
                    case 'vdsl':

                        // $res_addnewuser = $GLOBALS['ibs_internet']->addNewUser(1, $res_factor[0]['gheymate_service'], 'Main', $res_services[0]['onvane_service'], $res_subscriber[0]['code_meli']);
                        // if ($res_addnewuser[1]) {
                        //     $ibs_id          = $res_addnewuser[1][0];
                        //     $ibs_password    = Helper::str_split_from_end($res_subscriber[0]['code_meli'], 4);
                        //     $res_setuserattr = $GLOBALS['ibs_internet']->setUserAttributes($ibs_id, array(
                        //         'name'             => $res_subscriber[0]['name'] . ' ' . $res_subscriber[0]['f_name'],
                        //         'comment'          => $res_subscriber[0]['code_meli'],
                        //         'phone'            => $res_factor[0]['ibs_username'],
                        //         'cell_phone'       => $res_subscriber[0]['telephone_hamrah'],
                        //         'address'          => $res_subscriber[0]['address'],
                        //         'postal_code'      => $res_subscriber[0]['code_posti'],
                        //         'normal_user_spec' => array('normal_username' => $res_factor[0]['ibs_username'], 'normal_password' => $res_subscriber[0]['code_meli'])));
                        //     $res_setuserattr = $GLOBALS['ibs_internet']->setUserBirthDate($ibs_id, $res_subscriber[0]['tarikhe_tavalod'], 'gregorian');
                        //     $res_setuserattr = $GLOBALS['ibs_internet']->setAbsExpDate($ibs_id, $res_services[0]['zaname_estefade_be_tarikh']);
                        // }
                        break;
                    case 'wireless':
                        $res_addnewuser = $GLOBALS['ibs_internet']->addNewUser(1, $res_factor[0]['gheymate_service'], 'Main', $res_services[0]['onvane_service'], $res_subscriber[0]['code_meli']);
                        if ($res_addnewuser[1]) {
                            $ibs_id          = $res_addnewuser[1][0];
                            $ibs_password    = Helper::str_split_from_end($res_subscriber[0]['code_meli'], 4);
                            $res_setuserattr = $GLOBALS['ibs_internet']->setUserAttributes($ibs_id, array(
                                'name'             => $res_subscriber[0]['name'] . ' ' . $res_subscriber[0]['f_name'],
                                'comment'          => $res_subscriber[0]['code_meli'],
                                'phone'            => $res_factor[0]['ibs_username'],
                                'cell_phone'       => $res_subscriber[0]['telephone_hamrah'],
                                'address'          => $res_subscriber[0]['address'],
                                'postal_code'      => $res_subscriber[0]['code_posti'],
                                'normal_user_spec' => array('normal_username' => 'w-' . $res_factor[0]['ibs_username'], 'normal_password' => $res_subscriber[0]['code_meli'])
                            ));
                            $res_setuserattr = $GLOBALS['ibs_internet']->setUserBirthDate($ibs_id, $res_subscriber[0]['tarikhe_tavalod'], 'gregorian');
                            $res_setuserattr = $GLOBALS['ibs_internet']->setAbsExpDate($ibs_id, $res_services[0]['zaname_estefade_be_tarikh']);
                        }
                        break;
                    case 'tdlte':
                        $res_addnewuser = $GLOBALS['ibs_internet']->addNewUser(1, $res_factor[0]['gheymate_service'], 'Main', $res_services[0]['onvane_service'], $res_subscriber[0]['code_meli']);
                        if ($res_addnewuser[1]) {
                            $ibs_id          = $res_addnewuser[1][0];
                            $ibs_password    = Helper::str_split_from_end($res_subscriber[0]['code_meli'], 4);
                            $res_setuserattr = $GLOBALS['ibs_internet']->setUserAttributes($ibs_id, array(
                                'name'             => $res_subscriber[0]['name'] . ' ' . $res_subscriber[0]['f_name'],
                                'comment'          => $res_subscriber[0]['code_meli'],
                                'phone'            => $res_factor[0]['ibs_username'],
                                'cell_phone'       => $res_subscriber[0]['telephone_hamrah'],
                                'address'          => $res_subscriber[0]['address'],
                                'postal_code'      => $res_subscriber[0]['code_posti'],
                                'normal_user_spec' => array('normal_username' => 't-' . $res_factor[0]['ibs_username'], 'normal_password' => $res_subscriber[0]['code_meli'])
                            ));
                            $res_setuserattr = $GLOBALS['ibs_internet']->setUserBirthDate($ibs_id, $res_subscriber[0]['tarikhe_tavalod'], 'gregorian');
                            $res_setuserattr = $GLOBALS['ibs_internet']->setAbsExpDate($ibs_id, $res_services[0]['zaname_estefade_be_tarikh']);
                        }
                        break;
                    case 'voip':
                        $res_addnewuser = $GLOBALS['ibs_voip']->addNewUser(1, $res_factor[0]['gheymate_service'], 'Main', $res_services[0]['onvane_service'], $res_subscriber[0]['code_meli']);
                        if ($res_addnewuser[1]) {
                            $ibs_id          = $res_addnewuser[1][0];
                            $ibs_password    = Helper::str_split_from_end($res_subscriber[0]['code_meli'], 4);
                            $res_setuserattr = $GLOBALS['ibs_voip']->setUserAttributes($ibs_id, array(
                                'name'           => $res_subscriber[0]['name'] . ' ' . $res_subscriber[0]['f_name'],
                                'comment'        => $res_subscriber[0]['code_meli'],
                                'phone'          => $res_factor[0]['ibs_username'],
                                'cell_phone'     => $res_subscriber[0]['telephone_hamrah'],
                                'address'        => $res_subscriber[0]['address'],
                                'postal_code'    => $res_subscriber[0]['code_posti'],
                                'voip_user_spec' => array('voip_username' => $res_factor[0]['ibs_username'], 'voip_password' => $res_subscriber[0]['code_meli'])
                            ));
                            $res_setuserattr = $GLOBALS['ibs_voip']->setUserBirthDate($ibs_id, $res_subscriber[0]['tarikhe_tavalod'], 'gregorian');
                            $res_setuserattr = $GLOBALS['ibs_voip']->setAbsExpDate($ibs_id, $res_services[0]['zaname_estefade_be_tarikh']);
                        }
                        break;
                    default:
                        die(Helper::Json_Message('finf'));
                        break;
                }
                //$res = $GLOBALS['ibs_internet']->getUserInfoByNormalUserName($res_factor[0]['ibs_username']);
                die(json_encode(array('Error' => 'اطلاعات با موفقیت انجام شد.')));
            } else {
                die(json_encode(array('Error' => 'مشکل در پرداخت صورتحساب')));
            }
        }


        /////////////////factorha tab modal forms
        $this->view->pagename = 'factors';
        $this->view->render('factors', 'dashboard_template', '/public/js/factors.js', false);
    }
}
