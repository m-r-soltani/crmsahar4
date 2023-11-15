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
            if (
                isset($_POST['ekhtesase_emkanat_ekhtesase_adsl_etesal']) && $_POST['ekhtesase_emkanat_ekhtesase_adsl_etesal'] != '' &&
                isset($_POST['ekhtesase_emkanat_user_id']) && $_POST['ekhtesase_emkanat_user_id'] !== 'empty'
            ) {
                $res_sub = Helper::Select_By_Id('bnm_subscribers', $_POST['ekhtesase_emkanat_user_id']);
                $check_sql     = "SELECT * FROM bnm_port WHERE telephone = ? AND user_id = ?";
                $checkres      = Db::secure_fetchall(
                    $check_sql,
                    array(
                        $_POST['ekhtesase_emkanat_adsl_telephone_morede_taghaza'],
                        $_POST['ekhtesase_emkanat_user_id']
                    )
                );

                if (!$checkres && $res_sub) {
                    //check if telephone not registred
                    $arr              = [];
                    $arr['telephone'] = $_POST['ekhtesase_emkanat_adsl_telephone_morede_taghaza'];
                    $arr['user_id']   = $_POST['ekhtesase_emkanat_user_id'];
                    $arr['id']        = $_POST['ekhtesase_emkanat_ekhtesase_adsl_etesal'];
                    $sql              = Helper::Update_Generator($arr, 'bnm_port', "WHERE id = :id");
                    $res              = Db::secure_update_array($sql, $arr);
                    /////////////////////send sms//////////////////
                    if ($res_sub[0]['branch_id'] === 0) {
                        ////user sahar
                        $res_internal = Helper::Internal_Message_By_Karbord('sfadms', '1');
                        if ($res_internal) {
                            $sql = Helper::Insert_Generator(
                                array(
                                    'message'           => $res_internal[0]['message'],
                                    'type'              => 2,
                                    'message_subject'   => $res_internal[0]['karbord'],
                                ),
                                'bnm_messages'
                            );
                            $res_message = Db::secure_insert_array($sql, array(
                                'message'           => $res_internal[0]['message'],
                                'type'              => 2,
                                'message_subject'   => $res_internal[0]['karbord'],
                            ));
                            $res_sms_request = Helper::Write_In_Sms_Request(
                                $res_sub[0]['telephone_hamrah'],
                                Helper::Today_Miladi_Date(),
                                Helper::Today_Miladi_Date(),
                                1,
                                $res_message
                            );
                            if ($res_sms_request) {
                                $arr               = array();
                                $arr['receiver']   = $res_sub[0]['telephone_hamrah'];
                                $arr['sender']     = __SMSNUMBER__;
                                $arr['request_id'] = $res_sms_request;
                                $res               = Helper::Write_In_Sms_Queue($arr);
                            } else {
                                die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns'), 1));
                            }
                            if ($res) {
                                die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                            } else {
                                die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns'), 1));
                            }
                        } else {
                            die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns'), 1));
                        }
                    } elseif (Helper::Is_Empty_OR_Null($res_sub[0]['branch_id'])) {
                        //user namayande
                        $res_internal = Helper::Internal_Message_By_Karbord('sfadmn', '1');
                        if ($res_internal) {
                            $sql = Helper::Insert_Generator(
                                array(
                                    'message'           => $res_internal[0]['message'],
                                    'type'              => 2,
                                    'message_subject'   => $res_internal[0]['karbord'],
                                ),
                                'bnm_messages'
                            );
                            $res_message = Db::secure_insert_array($sql, array(
                                'message'           => $res_internal[0]['message'],
                                'type'              => 2,
                                'message_subject'   => $res_internal[0]['karbord'],
                            ));
                            $res_sms_request = Helper::Write_In_Sms_Request(
                                $res_sub[0]['telephone_hamrah'],
                                Helper::Today_Miladi_Date(),
                                Helper::Today_Miladi_Date(),
                                1,
                                $res_message
                            );
                            if ($res_sms_request) {
                                $arr               = array();
                                $arr['receiver']   = $res_sub[0]['telephone_hamrah'];
                                $arr['sender']     = __SMSNUMBER__;
                                $arr['request_id'] = $res_sms_request;
                                $res               = Helper::Write_In_Sms_Queue($arr);
                            } else {
                                die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns'), 1));
                            }
                            if ($res) {
                                die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                            } else {
                                die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns'), 1));
                            }
                        } else {
                            die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns'), 1));
                        }
                    } else {
                        die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns'), 1));
                    }

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
                    /////////////////////send sms//////////////////
                        if ($res_sub[0]['branch_id'] === 0) {
                            ////user sahar
                            $res_internal = Helper::Internal_Message_By_Karbord('sfvdms', '1');
                            if ($res_internal) {
                                $sql = Helper::Insert_Generator(
                                    array(
                                        'message'           => $res_internal[0]['message'],
                                        'type'              => 2,
                                        'message_subject'   => $res_internal[0]['karbord'],
                                    ),
                                    'bnm_messages'
                                );
                                $res_message = Db::secure_insert_array($sql, array(
                                    'message'           => $res_internal[0]['message'],
                                    'type'              => 2,
                                    'message_subject'   => $res_internal[0]['karbord'],
                                ));
                                $res_sms_request = Helper::Write_In_Sms_Request(
                                    $res_sub[0]['telephone_hamrah'],
                                    Helper::Today_Miladi_Date(),
                                    Helper::Today_Miladi_Date(),
                                    1,
                                    $res_message
                                );
                                if ($res_sms_request) {
                                    $arr               = array();
                                    $arr['receiver']   = $res_sub[0]['telephone_hamrah'];
                                    $arr['sender']     = __SMSNUMBER__;
                                    $arr['request_id'] = $res_sms_request;
                                    $res               = Helper::Write_In_Sms_Queue($arr);
                                } else {
                                    die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns'), 1));
                                }
                                if ($res) {
                                    die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                                } else {
                                    die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns'), 1));
                                }
                            }else{
                                die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns'), 1));
                            }
                        } elseif (Helper::Is_Empty_OR_Null($res_sub[0]['branch_id'])) {
                            //user namayande
                            $res_internal = Helper::Internal_Message_By_Karbord('sfvdmn', '1');
                            if ($res_internal) {
                                $sql = Helper::Insert_Generator(
                                    array(
                                        'message'           => $res_internal[0]['message'],
                                        'type'              => 2,
                                        'message_subject'   => $res_internal[0]['karbord'],
                                    ),
                                    'bnm_messages'
                                );
                                $res_message = Db::secure_insert_array($sql, array(
                                    'message'           => $res_internal[0]['message'],
                                    'type'              => 2,
                                    'message_subject'   => $res_internal[0]['karbord'],
                                ));
                                $res_sms_request = Helper::Write_In_Sms_Request(
                                    $res_sub[0]['telephone_hamrah'],
                                    Helper::Today_Miladi_Date(),
                                    Helper::Today_Miladi_Date(),
                                    1,
                                    $res_message
                                );
                                if ($res_sms_request) {
                                    $arr               = array();
                                    $arr['receiver']   = $res_sub[0]['telephone_hamrah'];
                                    $arr['sender']     = __SMSNUMBER__;
                                    $arr['request_id'] = $res_sms_request;
                                    $res               = Helper::Write_In_Sms_Queue($arr);
                                } else {
                                    die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns'), 1));
                                }
                                if ($res) {
                                    die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                                } else {
                                    die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns'), 1));
                                }
                            }else{
                                die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns'), 1));
                            }
                        }else{
                            die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns'), 1));
                        }
                    
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
            if (Helper::Is_Empty_OR_Null($_POST['ekhtesas_emkanat_wireless_station']) && Helper::Is_Empty_OR_Null($_POST['ekhtesase_emkanat_user_id'])) {
                $user_id       = $_POST['ekhtesase_emkanat_user_id'];
                $user_sql      = "SELECT id,code_eshterak,branch_id FROM bnm_subscribers WHERE id =?";
                $res_sub       = Db::secure_fetchall($user_sql, array($user_id));
                $ap            = $_POST['ekhtesas_emkanat_wireless_ap'];
                $check_sql     = "SELECT id,name FROM bnm_wireless_station WHERE (subscriber_id IS NULL) AND id=?";
                $res_station   = Db::secure_fetchall($check_sql, array($_POST['ekhtesas_emkanat_wireless_station']));
                if (count($res_station) > 0) {
                    $sql = Helper::Update_Generator(array('id' => $res_station[0]['id'], 'subscriber_id' => $res_sub[0]['id']), 'bnm_wireless_station', "WHERE id = :id AND subscriber_id IS NULL");
                    $res = Db::secure_update_array($sql, array('id' => $res_station[0]['id'], 'subscriber_id' => $res_sub[0]['id']));
                    /////////////////////send sms//////////////////
                    if ($res_sub && $res) {
                        if ($res_sub[0]['branch_id'] === 0) {
                            ////user sahar
                            $res_internal = Helper::Internal_Message_By_Karbord('sfwims', '1');
                            if ($res_internal) {
                                $sql = Helper::Insert_Generator(
                                    array(
                                        'message'           => $res_internal[0]['message'],
                                        'type'              => 2,
                                        'message_subject'   => $res_internal[0]['karbord'],
                                    ),
                                    'bnm_messages'
                                );
                                $res_message = Db::secure_insert_array($sql, array(
                                    'message'           => $res_internal[0]['message'],
                                    'type'              => 2,
                                    'message_subject'   => $res_internal[0]['karbord'],
                                ));
                                $res_sms_request = Helper::Write_In_Sms_Request(
                                    $res_sub[0]['telephone_hamrah'],
                                    Helper::Today_Miladi_Date(),
                                    Helper::Today_Miladi_Date(),
                                    1,
                                    $res_message
                                );
                                if ($res_sms_request) {
                                    $arr               = array();
                                    $arr['receiver']   = $res_sub[0]['telephone_hamrah'];
                                    $arr['sender']     = __SMSNUMBER__;
                                    $arr['request_id'] = $res_sms_request;
                                    $res               = Helper::Write_In_Sms_Queue($arr);
                                }
                                if ($res) {
                                    die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                                } else {
                                    die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns'), 1));
                                }
                            }
                        } elseif (Helper::Is_Empty_OR_Null($res_sub[0]['branch_id'])) {
                            //user namayande
                            $res_internal = Helper::Internal_Message_By_Karbord('sfwimn', '1');
                            if ($res_internal) {
                                $sql = Helper::Insert_Generator(
                                    array(
                                        'message'           => $res_internal[0]['message'],
                                        'type'              => 2,
                                        'message_subject'   => $res_internal[0]['karbord'],
                                    ),
                                    'bnm_messages'
                                );
                                $res_message = Db::secure_insert_array($sql, array(
                                    'message'           => $res_internal[0]['message'],
                                    'type'              => 2,
                                    'message_subject'   => $res_internal[0]['karbord'],
                                ));
                                $res_sms_request = Helper::Write_In_Sms_Request(
                                    $res_sub[0]['telephone_hamrah'],
                                    Helper::Today_Miladi_Date(),
                                    Helper::Today_Miladi_Date(),
                                    1,
                                    $res_message
                                );
                                if ($res_sms_request) {
                                    $arr               = array();
                                    $arr['receiver']   = $res_sub[0]['telephone_hamrah'];
                                    $arr['sender']     = __SMSNUMBER__;
                                    $arr['request_id'] = $res_sms_request;
                                    $res               = Helper::Write_In_Sms_Queue($arr);
                                }
                                if ($res) {
                                    die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                                } else {
                                    die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns'), 1));
                                }
                            }
                        }
                    } else {
                        die(Helper::Json_Message('f'));
                    }
                    /////////////////////send sms//////////////////
                    if ($res) {
                        die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                    }
                } else {
                    die(Helper::Custom_Msg('این وایرلس قبلا اختصاص داده شده است.', 3));
                }
            }
        }
        /*========================TDLTE============================= */
        if (isset($_POST['send_ekhtesase_emkanat_tdlte'])) {
            parse_str($_POST[key($_POST)], $_POST);
            $_POST = Helper::xss_check_array($_POST);
            if (Helper::Is_Empty_OR_Null($_POST['ekhtesase_emkanat_user_id'])) {
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                        $sql        = "SELECT * FROM bnm_subscribers WHERE id =?";
                        $res_sub    = Db::secure_fetchall($sql, array($_POST['ekhtesase_emkanat_user_id']));
                        if ($res_sub) {
                            if (Helper::Is_Empty_OR_Null($_POST['tdlte_number'])) {
                                $sql        = Helper::Update_Generator(array('id' => $_POST['tdlte_number'], 'subscriber_id' => $res_sub[0]['id']), 'bnm_tdlte_sim', "WHERE id = :id AND subscriber_id IS NULL");
                                $res_tdlte  = Db::secure_update_array($sql, array('id' => $_POST['tdlte_number'], 'subscriber_id' => $res_sub[0]['id']));

                                /////////////////////send sms//////////////////
                                if ($res_tdlte) {
                                    if ($res_sub[0]['branch_id'] === 0) {
                                        ////user sahar
                                        $res_internal = Helper::Internal_Message_By_Karbord('sftdms', '1');
                                        if ($res_internal) {
                                            $sql = Helper::Insert_Generator(
                                                array(
                                                    'message'           => $res_internal[0]['message'],
                                                    'type'              => 2,
                                                    'message_subject'   => $res_internal[0]['karbord'],
                                                ),
                                                'bnm_messages'
                                            );
                                            $res_message = Db::secure_insert_array($sql, array(
                                                'message'           => $res_internal[0]['message'],
                                                'type'              => 2,
                                                'message_subject'   => $res_internal[0]['karbord'],
                                            ));
                                            $res_sms_request = Helper::Write_In_Sms_Request(
                                                $res_sub[0]['telephone_hamrah'],
                                                Helper::Today_Miladi_Date(),
                                                Helper::Today_Miladi_Date(),
                                                1,
                                                $res_message
                                            );
                                            if ($res_sms_request) {
                                                $arr               = array();
                                                $arr['receiver']   = $res_sub[0]['telephone_hamrah'];
                                                $arr['sender']     = __SMSNUMBER__;
                                                $arr['request_id'] = $res_sms_request;
                                                $res               = Helper::Write_In_Sms_Queue($arr);
                                            }
                                            if ($res) {
                                                die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                                            } else {
                                                // die(Helper::Custom_Msg(Helper::Messages('s'). ' ' . Helper::Messages('sns'),1));
                                                die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns'), 1));
                                            }
                                        }
                                    } elseif (Helper::Is_Empty_OR_Null($res_sub[0]['branch_id'])) {
                                        //user namayande
                                        $res_internal = Helper::Internal_Message_By_Karbord('sftdmn', '1');
                                        if ($res_internal) {
                                            $sql = Helper::Insert_Generator(
                                                array(
                                                    'message'           => $res_internal[0]['message'],
                                                    'type'              => 2,
                                                    'message_subject'   => $res_internal[0]['karbord'],
                                                ),
                                                'bnm_messages'
                                            );
                                            $res_message = Db::secure_insert_array($sql, array(
                                                'message'           => $res_internal[0]['message'],
                                                'type'              => 2,
                                                'message_subject'   => $res_internal[0]['karbord'],
                                            ));
                                            $res_sms_request = Helper::Write_In_Sms_Request(
                                                $res_sub[0]['telephone_hamrah'],
                                                Helper::Today_Miladi_Date(),
                                                Helper::Today_Miladi_Date(),
                                                1,
                                                $res_message
                                            );
                                            if ($res_sms_request) {
                                                $arr               = array();
                                                $arr['receiver']   = $res_sub[0]['telephone_hamrah'];
                                                $arr['sender']     = __SMSNUMBER__;
                                                $arr['request_id'] = $res_sms_request;
                                                $res               = Helper::Write_In_Sms_Queue($arr);
                                            }
                                            if ($res) {
                                                die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                                            } else {
                                                die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns'), 1));
                                            }
                                        }
                                    }
                                } else {
                                    $tdmsg = 'این شماره به شخص دیگری تعلق دارد یا پیدا نشده لطفا جهت بررسی با پشتیبانی تماس بگیرید.';
                                    die(Helper::Custom_Msg($tdmsg));
                                }
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
                            if (Helper::Is_Empty_OR_Null($_POST['tdlte_number'])) {
                                $sql        = Helper::Update_Generator(array('id' => $_POST['tdlte_number'], 'subscriber_id' => $res_sub[0]['id']), 'bnm_tdlte_sim', "WHERE id = :id AND subscriber_id IS NULL AND brand_id = {$_SESSION['brand_id']}");
                                $res_tdlte  = Db::secure_update_array($sql, array('id' => $_POST['tdlte_number'], 'subscriber_id' => $res_sub[0]['id']));
                                /////////////////////send sms//////////////////
                                if ($res_tdlte) {
                                    if ($res_sub[0]['branch_id'] === 0) {
                                        ////user sahar
                                        // $res_internal = Helper::Internal_Message_By_Karbord('sftdms', '1');
                                        // if ($res_internal) {
                                        //     $sql=Helper::Insert_Generator(
                                        //         array(
                                        //             'message'           => $res_internal[0]['message'],
                                        //             'type'              => 2,
                                        //             'message_subject'   => $res_internal[0]['karbord'],
                                        //         ),
                                        //         'bnm_messages');
                                        //         $res_message= Db::secure_insert_array($sql,array(
                                        //             'message'           => $res_internal[0]['message'],
                                        //             'type'              => 2,
                                        //             'message_subject'   => $res_internal[0]['karbord'],
                                        //         ));
                                        //     $res_sms_request = Helper::Write_In_Sms_Request($res_sub[0]['telephone_hamrah'], Helper::Today_Miladi_Date(),
                                        //         Helper::Today_Miladi_Date(), 1, $res_message);
                                        //     if ($res_sms_request) {
                                        //         $arr               = array();
                                        //         $arr['receiver']   = $res_sub[0]['telephone_hamrah'];
                                        //         $arr['sender']     = __SMSNUMBER__;
                                        //         $arr['request_id'] = $res_sms_request;
                                        //         $res               = Helper::Write_In_Sms_Queue($arr);
                                        //     }
                                        // if($res){
                                        //     die (Helper::Custom_Msg(Helper::Messages('s'),1));
                                        // }else{
                                        //     die (Helper::Custom_Msg(Helper::Messages('s'). ' ' . Helper::Messages('sns'),1));
                                        // }
                                        // }
                                        die(Helper::Json_Message('f'));
                                    } elseif (Helper::Is_Empty_OR_Null($res_sub[0]['branch_id'])) {
                                        //user namayande
                                        $res_internal = Helper::Internal_Message_By_Karbord('sftdmn', '1');
                                        if ($res_internal) {
                                            $sql = Helper::Insert_Generator(
                                                array(
                                                    'message'           => $res_internal[0]['message'],
                                                    'type'              => 2,
                                                    'message_subject'   => $res_internal[0]['karbord'],
                                                ),
                                                'bnm_messages'
                                            );
                                            $res_message = Db::secure_insert_array($sql, array(
                                                'message'           => $res_internal[0]['message'],
                                                'type'              => 2,
                                                'message_subject'   => $res_internal[0]['karbord'],
                                            ));
                                            $res_sms_request = Helper::Write_In_Sms_Request(
                                                $res_sub[0]['telephone_hamrah'],
                                                Helper::Today_Miladi_Date(),
                                                Helper::Today_Miladi_Date(),
                                                1,
                                                $res_message
                                            );
                                            if ($res_sms_request) {
                                                $arr               = array();
                                                $arr['receiver']   = $res_sub[0]['telephone_hamrah'];
                                                $arr['sender']     = __SMSNUMBER__;
                                                $arr['request_id'] = $res_sms_request;
                                                $res               = Helper::Write_In_Sms_Queue($arr);
                                            }
                                            if ($res) {
                                                die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                                            } else {
                                                die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns'), 1));
                                            }
                                        }
                                    }
                                    if ($res) {
                                        die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                                    } else {
                                        die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns'), 1));
                                    }
                                } else {
                                    $tdmsg = 'این شماره به شخص دیگری تعلق دارد یا پیدا نشده لطفا جهت بررسی با پشتیبانی تماس بگیرید.';
                                    die(Helper::Custom_Msg($tdmsg, 4));
                                }
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
        if (isset($_POST['send_ft_adsl_update_status'])) {
            parse_str($_POST[key($_POST)], $_POST);
            // $_POST = Helper::xss_check_array($_POST);
            $unset_array = array(
                "noe_khadamat", "terafik", "zaname_estefade_be_tarikh", "tarikhe_shoroe_service", "tarikhe_payane_service",
                "gheymate_service", "takhfif", "hazine_ranzhe", "hazine_dranzhe", "hazine_nasb", "abonmane_port", "abonmane_faza", "abonmane_tajhizat",
                "darsade_avareze_arzeshe_afzode", "maliate_arzeshe_afzode", "mablaghe_ghabele_pardakht"
            );
            for ($i = 0; $i < count($unset_array); $i++) {
                if (isset($_POST[$unset_array[$i]])) {
                    unset($_POST[$unset_array[$i]]);
                }
            }
            $sql = Helper::Update_Generator($_POST, 'bnm_factor', "WHERE id = :id");
            $res = Db::secure_update_array($sql, $_POST);
            //die(json_encode($_POST));
        }
        if (isset($_POST['send_ft_wireless_update_status'])) {
            parse_str($_POST[key($_POST)], $_POST);
            // $_POST = Helper::xss_check_array($_POST);
            $unset_array = array(
                "noe_khadamat", "terafik", "zaname_estefade_be_tarikh", "tarikhe_shoroe_service", "tarikhe_payane_service",
                "gheymate_service", "takhfif", "hazine_ranzhe", "hazine_dranzhe", "hazine_nasb", "abonmane_port", "abonmane_faza", "abonmane_tajhizat",
                "darsade_avareze_arzeshe_afzode", "maliate_arzeshe_afzode", "mablaghe_ghabele_pardakht"
            );
            for ($i = 0; $i < count($unset_array); $i++) {
                if (isset($_POST[$unset_array[$i]])) {
                    unset($_POST[$unset_array[$i]]);
                }
            }
            $sql = Helper::Update_Generator($_POST, 'bnm_factor', "WHERE id = :id");
            $res = Db::secure_update_array($sql, $_POST);
            //            die(json_encode($_POST));
        }
        if (isset($_POST['send_ft_tdlte_update_status'])) {
            parse_str($_POST[key($_POST)], $_POST);
            // $_POST = Helper::xss_check_array($_POST);
            $unset_array = array(
                "noe_khadamat", "terafik", "zaname_estefade_be_tarikh", "tarikhe_shoroe_service", "tarikhe_payane_service",
                "gheymate_service", "takhfif", "hazine_ranzhe", "hazine_dranzhe", "hazine_nasb", "abonmane_port", "abonmane_faza", "abonmane_tajhizat",
                "darsade_avareze_arzeshe_afzode", "maliate_arzeshe_afzode", "mablaghe_ghabele_pardakht"
            );
            for ($i = 0; $i < count($unset_array); $i++) {
                if (isset($_POST[$unset_array[$i]])) {
                    unset($_POST[$unset_array[$i]]);
                }
            }
            $sql = Helper::Update_Generator($_POST, 'bnm_factor', "WHERE id = :id");
            $res = Db::secure_update_array($sql, $_POST);
            //            die(json_encode($_POST));
        }
        if (isset($_POST['send_ft_voip_update_status'])) {
            parse_str($_POST[key($_POST)], $_POST);
            // $_POST = Helper::xss_check_array($_POST);
            $unset_array = array(
                "pin_code", "noe_khadamat", "terafik", "zaname_estefade_be_tarikh", "tarikhe_shoroe_service", "tarikhe_payane_service",
                "gheymate_service", "takhfif", "hazine_ranzhe", "hazine_dranzhe", "hazine_nasb", "abonmane_port", "abonmane_faza", "abonmane_tajhizat",
                "darsade_avareze_arzeshe_afzode", "maliate_arzeshe_afzode", "mablaghe_ghabele_pardakht"
            );
            for ($i = 0; $i < count($unset_array); $i++) {
                if (isset($_POST[$unset_array[$i]])) {
                    unset($_POST[$unset_array[$i]]);
                }
            }
            $sql = Helper::Update_Generator($_POST, 'bnm_factor', "WHERE id = :id");
            $res = Db::secure_update_array($sql, $_POST);
            //            die(json_encode($_POST));
        }
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

                        // $res_addnewuser = $GLOBALS['ibs_internet']->addNewUser(1, $res_factor[0]['gheymate_service'], 'Main', $res_factor[0]['onvane_service'], $res_subscriber[0]['code_meli']);
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
                        $res_addnewuser = $GLOBALS['ibs_internet']->addNewUser(1, $res_factor[0]['gheymate_service'], 'Main', $res_factor[0]['onvane_service'], $res_subscriber[0]['code_meli']);
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
                        $res_addnewuser = $GLOBALS['ibs_internet']->addNewUser(1, $res_factor[0]['gheymate_service'], 'Main', $res_factor[0]['onvane_service'], $res_subscriber[0]['code_meli']);
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
                        $res_addnewuser = $GLOBALS['ibs_voip']->addNewUser(1, $res_factor[0]['gheymate_service'], 'Main', $res_factor[0]['onvane_service'], $res_subscriber[0]['code_meli']);
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

        if (isset($_POST['send_ft_pardakht'])) {
            parse_str($_POST[key($_POST)], $_POST);
            $_POST = Helper::xss_check_array($_POST);
            if (Helper::Login_Just_Check()) {
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                        if (Helper::Is_Empty_OR_Null($_POST['factor_id'])) {
                            $sql_factor     = "SELECT * FROM bnm_factor WHERE id = ? AND DATE(tarikhe_factor)=CURDATE() AND tasvie_shode<>'1'";
                            $res_factor     = Db::secure_fetchall($sql_factor, array($_POST['factor_id']));
                            if ($res_factor) {
                                $sql_service    = "SELECT * FROM bnm_services WHERE id=?";
                                $res_service    = Db::secure_fetchall($sql_service, array($res_factor[0]['service_id']));
                                $sql_subscriber = "SELECT id,name,f_name,branch_id FROM bnm_subscribers WHERE id=?";
                                $res_subscriber = Db::secure_fetchall($sql_subscriber, array($res_factor[0]['subscriber_id']));
                                $sql_subscriber = "SELECT 
                                                sub.id,sub.noe_moshtarak,sub.name,sub.f_name,sub.name_pedar,sub.meliat,sub.tabeiat,sub.noe_shenase_hoviati,
                                                sub.shomare_shenasname,sub.tarikhe_tavalod,sub.ostane_tavalod,sub.shahre_tavalod,sub.telephone1,sub.telephone_hamrah,sub.email,sub.fax,
                                                sub.website,sub.code_posti1,sub.code_posti2,sub.code_posti3,sub.address1,sub.address2,sub.address3,sub.shoghl,sub.nahve_ashnai,sub.gorohe_moshtarak,
                                                sub.moaref,sub.tozihat,sub.jensiat,sub.name_sherkat,sub.shomare_sabt,sub.tarikhe_sabt,sub.ostan,sub.shahr,sub.shomare_dakheli,sub.code_eghtesadi,
                                                sub.shenase_meli,sub.name_pedare,sub.reshteye_faaliat,sub.telephone2,sub.telephone3,sub.code_meli,sub.code_eshterak,sub.branch_id,sub.noe_malekiat1,
                                                sub.noe_malekiat2,sub.noe_malekiat3,sub.name_malek1,sub.name_malek2,sub.name_malek3,sub.f_name_malek1,sub.f_name_malek2,sub.f_name_malek3,
                                                sub.code_meli_malek1,sub.code_meli_malek2,sub.code_meli_malek3,sub.shahkar_status_code,sub.shahkar_status_msg,
                                                ct.name as city_name,os.name as ostan_name
                                                FROM bnm_subscribers sub 
                                                INNER JOIN bnm_shahr ct ON sub.shahre_tavalod = ct.id
                                                INNER JOIN bnm_ostan os ON sub.ostane_tavalod = os.id
                                                WHERE sub.id=?
                                                ";
                                $res_subscriber         = Db::secure_fetchall($sql_subscriber, array($res_factor[0]['subscriber_id']));
                                $sql_branch             = "SELECT id,name_sherkat FROM bnm_branch WHERE id =?";
                                $res_branch             = Db::secure_fetchall($sql_branch, array($res_subscriber[0]['branch_id']));
                                $sql_credit_subscriber  = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                $res_credit_subscriber  = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                $sql_noe_hamkari        = "SELECT * FROM bnm_branch_cooperation_type WHERE branch_id=? AND service_type=? ORDER BY id DESC LIMIT 1";
                                $res_noe_hamkari        = Db::secure_fetchall($sql_noe_hamkari, array($res_subscriber[0]['branch_id'], $res_factor[0]['noe_khadamat']));
                                switch ($_POST['noe_pardakht']) {
                                    case "pardakht_az_subscriber":
                                        if ($res_service) {
                                            if (Helper::Is_Empty_OR_Null($res_service[0]['noe_forosh'])) {
                                                if ($res_subscriber) {
                                                    //die(json_encode($res_subscriber));
                                                    if ($res_subscriber[0]['branch_id'] !== 0) {
                                                        //user braraye namayande ast
                                                        if ($res_credit_subscriber) {
                                                            //moshtarak hesabe bank darad
                                                            if (Helper::checkSubscriberCreditForPay($res_credit_subscriber[0]['credit'], $res_factor[0]['mablaghe_ghabele_pardakht'])) {
                                                                if ($res_noe_hamkari) {
                                                                    //kasre mablaghe factor az moshtarak
                                                                    $subscriber_credit_array                      = array();
                                                                    $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])));
                                                                    $subscriber_credit_array['bedehkar']          = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])));
                                                                    $subscriber_credit_array['bestankar']         = 0;
                                                                    $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                                    $subscriber_credit_array['noe_user']          = '1';
                                                                    $subscriber_credit_array['tozihat']           = 'فاکتور شما توسط نماینده/سروکو در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'] . 'پرداخت شد.';
                                                                    $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                    $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                    $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                    $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                    if ($result) {
                                                                        //kasre mablaghe maliat va arzeshe afzode az moshtarak
                                                                        $subscriber_credit_array                      = array();
                                                                        $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                        $subscriber_credit_array['bedehkar']          = (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                        $subscriber_credit_array['bestankar']         = 0;
                                                                        $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                                        $subscriber_credit_array['noe_user']          = '1';
                                                                        $subscriber_credit_array['tozihat']           = 'کسر مالیات و ارزش افزوده توسط سیستم در تاریخ: ' . Helper::Today_Shamsi_Date('-');
                                                                        $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                        $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                        $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                        $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                        //get noe_hamkari info for this factor
                                                                        //mohasebe soode namayande az in forosh
                                                                        if ($res_noe_hamkari[0]['cooperation_type'] === 1) {
                                                                            //namayande->darsadi
                                                                            $flag_noe_kharid       = "service_jadid";
                                                                            $sql_factor_noe_kharid = "SELECT COUNT(*) AS rows_num FROM bnm_factor WHERE subscriber_id=? AND noe_khadamat=? AND tasvie_shode='1'";
                                                                            $res_factor_noe_kharid = Db::secure_fetchall($sql_factor_noe_kharid, array($res_factor[0]['subscriber_id'], $res_factor[0]['noe_khadamat']));

                                                                            if ($res_factor_noe_kharid) {
                                                                                if ($res_factor_noe_kharid[0]['rows_num'] === 0) {
                                                                                    $flag_noe_kharid = "service_jadid";
                                                                                } else {
                                                                                    $flag_noe_kharid = "sharje_mojadad";
                                                                                }
                                                                            } else {
                                                                                $flag_noe_kharid = "service_jadid";
                                                                            }
                                                                            $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                            $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));

                                                                            switch ($res_service[0]['noe_forosh']) {
                                                                                case 'adi':
                                                                                    if ($flag_noe_kharid == "sharje_mojadad") {
                                                                                        if ($res_credit_branch) {
                                                                                            //pardakhte porsante namayande baraye sharje mojadad zamani ke namayande hesabe bank darad
                                                                                            $branch_credit_array                      = array();
                                                                                            $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) + (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_sharje_mojadad']) / 100);
                                                                                            $branch_credit_array['bestankar']         = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_sharje_mojadad']) / 100);
                                                                                            $branch_credit_array['bedehkar']          = 0;
                                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                            $branch_credit_array['noe_user']          = '2';
                                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                            $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                            $branch_credit_array['tozihat']           = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                            $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                            $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                        } else {
                                                                                            //pardakhte porsante namayande baraye sharje mojadad zamani ke namayande hesabe bank nadarad
                                                                                            $branch_credit_array                      = array();
                                                                                            $branch_credit_array['credit']            = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_sharje_mojadad']) / 100);
                                                                                            $branch_credit_array['bestankar']         = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_sharje_mojadad']) / 100);
                                                                                            $branch_credit_array['bedehkar']          = 0;
                                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                            $branch_credit_array['noe_user']          = '2';
                                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                            $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                            $branch_credit_array['tozihat']           = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                            $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                            $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                        }
                                                                                    } elseif ($flag_noe_kharid == "service_jadid") {

                                                                                        if ($res_credit_branch) {
                                                                                            //pardakhte porsante namayande baraye service jadid zamani ke namayande hesabe bank darad
                                                                                            $branch_credit_array                      = array();
                                                                                            $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) + (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_jadid']) / 100);
                                                                                            $branch_credit_array['bestankar']         = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_jadid']) / 100);
                                                                                            $branch_credit_array['bedehkar']          = 0;
                                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                            $branch_credit_array['noe_user']          = '2';
                                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                            $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                            $branch_credit_array['tozihat']           = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                            $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                            $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                        } else {
                                                                                            //pardakhte porsante namayande baraye service jadid zamani ke namayande hesabe bank nadarad
                                                                                            $branch_credit_array                      = array();
                                                                                            $branch_credit_array['credit']            = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_jadid']) / 100);
                                                                                            $branch_credit_array['bestankar']         = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_jadid']) / 100);
                                                                                            $branch_credit_array['bedehkar']          = 0;
                                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                            $branch_credit_array['noe_user']          = '2';
                                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                            $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                            $branch_credit_array['tozihat']           = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                            $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                            $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                        }
                                                                                    }
                                                                                    break;
                                                                                case 'bulk':
                                                                                    if ($res_credit_branch) {
                                                                                        //pardakhte porsante namayande baraye bulk zamani ke namayande hesabe bank darad
                                                                                        $branch_credit_array                      = array();
                                                                                        $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) + ((floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_bulk']) / 100));
                                                                                        $branch_credit_array['bestankar']         = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_bulk']) / 100);
                                                                                        $branch_credit_array['bedehkar']          = 0;
                                                                                        $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                        $branch_credit_array['noe_user']          = '2';
                                                                                        $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                        $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                        $branch_credit_array['tozihat']           = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                        $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                        $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                    } else {
                                                                                        //pardakhte porsante namayande baraye bulk zamani ke namayande hesabe bank nadarad
                                                                                        $branch_credit_array                      = array();
                                                                                        $branch_credit_array['credit']            = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_bulk']) / 100);
                                                                                        $branch_credit_array['bestankar']         = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_bulk']) / 100);
                                                                                        $branch_credit_array['bedehkar']          = 0;
                                                                                        $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                        $branch_credit_array['noe_user']          = '2';
                                                                                        $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                        $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                        $branch_credit_array['tozihat']           = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                        $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                        $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                    }
                                                                                    break;
                                                                                case 'jashnvare':
                                                                                    if ($res_credit_branch) {
                                                                                        //pardakhte porsante namayande baraye jashnvare zamani ke namayande hesabe bank darad
                                                                                        $branch_credit_array                      = array();
                                                                                        $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) + ((floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_jashnvare']) / 100));
                                                                                        $branch_credit_array['bestankar']         = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_jashnvare']) / 100);
                                                                                        $branch_credit_array['bedehkar']          = 0;
                                                                                        $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                        $branch_credit_array['noe_user']          = '2';
                                                                                        $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                        $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                        $branch_credit_array['tozihat']           = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                        $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                        $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                    } else {
                                                                                        //pardakhte porsante namayande baraye jashnvare zamani ke namayande hesabe bank nadarad
                                                                                        $branch_credit_array                      = array();
                                                                                        $branch_credit_array['credit']            = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_jashnvare']) / 100);
                                                                                        $branch_credit_array['bestankar']         = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_jashnvare']) / 100);
                                                                                        $branch_credit_array['bedehkar']          = 0;
                                                                                        $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                        $branch_credit_array['noe_user']          = '2';
                                                                                        $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                        $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                        $branch_credit_array['tozihat']           = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                        $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                        $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                    }

                                                                                    break;

                                                                                default:
                                                                                    die(Helper::Json_Message('service_info_not_right'));
                                                                                    break;
                                                                            }
                                                                            /////todo... check if service type is bitstream
                                                                            //////ibs/////
                                                                            if ($result) {
                                                                                Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                                                                                if ($res_service[0]['noe_forosh'] === 'adi' || $res_service[0]['noe_forosh'] === 'jashnvare') {
                                                                                    switch ($res_service[0]['type']) {
                                                                                        case 'adsl':
                                                                                        case 'vdsl':
                                                                                        case 'bitstream':
                                                                                        case 'wireless':
                                                                                        case 'tdlte':
                                                                                        case 'voip':
                                                                                            $res_addnewuser = $GLOBALS['ibs_internet']->addNewUser(1, $res_service[0]['terafik'], 'Main', $res_factor[0]['onvane_service'], $res_subscriber[0]['code_meli']);
                                                                                            if (Helper::ibsCheckResponse($res_addnewuser)) {
                                                                                                // $tavalod_tmp            = Helper::dateConvertInitialize($res_subscriber[0]['tarikhe_tavalod']);
                                                                                                // $tavalode_fa            = Helper::gregorian_to_jalali($tavalod_tmp[0],$tavalod_tmp[1],$tavalod_tmp[2],'-');
                                                                                                $res_setuserattrs       = $GLOBALS['ibs_internet']->setUserAttributes(
                                                                                                    $res_addnewuser[1][0],
                                                                                                    array(
                                                                                                        "name"              => $res_subscriber[0]['name'] . ' ' . $res_subscriber[0]['f_name'],
                                                                                                        "comment"           => $res_subscriber[0]['code_meli'],
                                                                                                        "phone"             => $res_factor[0]['ibs_username'],
                                                                                                        "cell_phone"        => $res_subscriber[0]['telephone_hamrah'],
                                                                                                        "postal_code"       => $res_subscriber[0]['shahkar_status_code'],
                                                                                                        "email"             => $res_subscriber[0]['shomare_shenasname'] . ',' . $res_subscriber[0]['city_name'],
                                                                                                        "address"           => $res_service[0]['type'],
                                                                                                        "birthdate"         => $res_subscriber[0]['tarikhe_tavalod'],
                                                                                                        "birthdate_unit"    => 'gregorian',
                                                                                                        "abs_exp_date"      => $res_factor[0]['tarikhe_payane_service'],
                                                                                                        "abs_exp_date_unit" => 'gregorian',
                                                                                                        "normal_user_spec"  => array(
                                                                                                            "normal_username"   => strval($res_factor[0]['ibs_username']),
                                                                                                            "normal_password"   => strval($res_subscriber[0]['code_meli']),
                                                                                                        )
                                                                                                    )
                                                                                                );
                                                                                                if (Helper::ibsCheckResponse($res_setuserattrs)) {
                                                                                                    die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                                                                                                } else {
                                                                                                    die(Helper::Custom_Msg(Helper::Messages('icf') . ' ' . Helper::Messages('ps'), 2));
                                                                                                }
                                                                                            } else {
                                                                                                die(Helper::Custom_Msg(Helper::Messages('icf') . ' ' . Helper::Messages('ps'), 2));
                                                                                            }
                                                                                            break;
                                                                                        default:
                                                                                            die(Helper::Custom_Msg(Helper::Messages('icf') . ' ' . Helper::Messages('ps'), 2));
                                                                                            break;
                                                                                    }
                                                                                } elseif ($res_service[0]['noe_forosh'] === 'bulk') {
                                                                                } else {
                                                                                    die(Helper::Custom_Msg(Helper::Messages('icf') . ' ' . Helper::Messages('ps'), 2));
                                                                                }
                                                                            } else {
                                                                                die(Helper::Json_Message('f'));
                                                                            }
                                                                        } elseif ($res_noe_hamkari[0]['cooperation_type'] === 2) {
                                                                            // license
                                                                            $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                            $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                            if ($res_credit_branch) {
                                                                                //pardakhte porsante(lisence) namayande zamani ke namayande hesabe bank darad
                                                                                //insert credit + mablaghe_ghabele_pardakht
                                                                                $branch_credit_array                      = array();
                                                                                $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) + floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                $branch_credit_array['bestankar']         = floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                $branch_credit_array['bedehkar']          = 0;
                                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                $branch_credit_array['noe_user']          = '2';
                                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                $branch_credit_array['tozihat']           = 'پرداخت مبلغ فاکتور برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                //insert credit - maliat /update tozihat
                                                                                $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                $branch_credit_array                      = array();
                                                                                $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])); //-maliat
                                                                                $branch_credit_array['bestankar']         = 0;
                                                                                $branch_credit_array['bedehkar']          = (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])); //-maliat
                                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                $branch_credit_array['noe_user']          = '2';
                                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                $branch_credit_array['tozihat']           = 'کسر مالیات برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                //insert credit - darsade hazine_sazmane_tanzim /update tozihat
                                                                                $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                $branch_credit_array                      = array();
                                                                                $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) - ((floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['hazine_sazmane_tanzim']) / 100));
                                                                                $branch_credit_array['bestankar']         = 0;
                                                                                $branch_credit_array['bedehkar']          = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['hazine_sazmane_tanzim']) / 100);
                                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                $branch_credit_array['noe_user']          = '2';
                                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                $branch_credit_array['tozihat']           = 'کسر هزینه سازمان تنظیم برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                //insert credit - darsade hazine_servco /update tozihat
                                                                                $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                $branch_credit_array                      = array();
                                                                                $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) - ((floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['hazine_servco']) / 100));
                                                                                $branch_credit_array['bestankar']         = 0;
                                                                                $branch_credit_array['bedehkar']          = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['hazine_servco']) / 100);
                                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                $branch_credit_array['noe_user']          = '2';
                                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                $branch_credit_array['tozihat']           = 'کسر هزینه سروکو برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                //insert credit - darsade hazine_mansobe /update tozihat
                                                                                $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                $branch_credit_array                      = array();
                                                                                $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) - floatval($res_noe_hamkari[0]['hazine_mansobe']);
                                                                                $branch_credit_array['bestankar']         = 0;
                                                                                $branch_credit_array['bedehkar']          = floatval($res_noe_hamkari[0]['hazine_mansobe']);
                                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                $branch_credit_array['noe_user']          = '2';
                                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                $branch_credit_array['tozihat']           = 'کسر هزینه منصوبه برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                                                                                die(Helper::Json_Message('pardakht_success'));
                                                                            } else {
                                                                                //pardakhte porsante(lisence) namayande zamani ke namayande hesabe bank nadarad
                                                                                //NO credit Account
                                                                                //insert credit + mablaghe_ghabele_pardakht
                                                                                $branch_credit_array                      = array();
                                                                                $branch_credit_array['credit']            = floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                $branch_credit_array['bestankar']         = floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                $branch_credit_array['bedehkar']          = 0;
                                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                $branch_credit_array['noe_user']          = '2';
                                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                $branch_credit_array['tozihat']           = 'پرداخت مبلغ فاکتور برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                //insert credit - maliat /update tozihat
                                                                                $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                $branch_credit_array                      = array();
                                                                                $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])); //-maliat
                                                                                $branch_credit_array['bestankar']         = 0;
                                                                                $branch_credit_array['bedehkar']          = (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])); //-maliat
                                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                $branch_credit_array['noe_user']          = '2';
                                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                $branch_credit_array['tozihat']           = 'کسر مالیات برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                //insert credit - darsade hazine_sazmane_tanzim /update tozihat
                                                                                $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                $branch_credit_array                      = array();
                                                                                $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) - ((floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['hazine_sazmane_tanzim']) / 100));
                                                                                $branch_credit_array['bestankar']         = 0;
                                                                                $branch_credit_array['bedehkar']          = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['hazine_sazmane_tanzim']) / 100);
                                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                $branch_credit_array['noe_user']          = '2';
                                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                $branch_credit_array['tozihat']           = 'کسر هزینه سازمان تنظیم برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                //insert credit - darsade hazine_servco /update tozihat
                                                                                $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                $branch_credit_array                      = array();
                                                                                $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) - ((floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['hazine_servco']) / 100));
                                                                                $branch_credit_array['bestankar']         = 0;
                                                                                $branch_credit_array['bedehkar']          = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['hazine_servco']) / 100);
                                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                $branch_credit_array['noe_user']          = '2';
                                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                $branch_credit_array['tozihat']           = 'کسر هزینه سروکو برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                //insert credit - darsade hazine_mansobe /update tozihat
                                                                                $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                $branch_credit_array                      = array();
                                                                                $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) - floatval($res_noe_hamkari[0]['hazine_mansobe']);
                                                                                $branch_credit_array['bestankar']         = 0;
                                                                                $branch_credit_array['bedehkar']          = floatval($res_noe_hamkari[0]['hazine_mansobe']);
                                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                $branch_credit_array['noe_user']          = '2';
                                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                $branch_credit_array['tozihat']           = 'کسر هزینه منصوبه برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                                                                                die(Helper::Json_Message('pardakht_success'));
                                                                            }
                                                                            /////todo... check if service type is bitstream
                                                                        } else {
                                                                            die(Helper::Json_Message('bcinf'));
                                                                        }
                                                                    } else {
                                                                        die(Helper::Json_Message('bcinf'));
                                                                    }
                                                                } else {
                                                                    die(Helper::Json_Message('bcinf'));
                                                                }
                                                            } else {
                                                                die(Helper::Json_Message('subscriber_credit_not_enough'));
                                                            }
                                                        } else {
                                                            die(Helper::Json_Message('subscriber_credit_info_not_found'));
                                                        }
                                                    } elseif ($res_subscriber[0]['branch_id'] === 0) {
                                                        //user sahar
                                                        $sql_credit_subscriber = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                        $res_credit_subscriber = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                        if ($res_credit_subscriber) {
                                                            if (Helper::checkSubscriberCreditForPay($res_credit_subscriber[0]['credit'], $res_factor[0]['mablaghe_ghabele_pardakht'])) {
                                                                //kasre mablaghe factor az moshtarak
                                                                $subscriber_credit_array = array();
                                                                // $subscriber_credit_array['change_amount']  = abs(floatval($res_credit_subscriber[0]['credit'])) - (abs(floatval($res_factor[0]['mablaghe_ghabele_pardakht'])) - (abs(floatval($res_factor[0]['maliate_arzeshe_afzode'])) + abs(floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))));
                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])));
                                                                $subscriber_credit_array['bedehkar']          = floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + abs(floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])));
                                                                $subscriber_credit_array['bestankar']         = 0;
                                                                $subscriber_credit_array['user_or_branch_id'] = $res_factor[0]['subscriber_id'];
                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                $subscriber_credit_array['tozihat']           = 'فاکتور شما توسط نماینده/شرکت در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                if ($result) {
                                                                    $sql_credit_subscriber                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                    $res_credit_subscriber                        = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                    $subscriber_credit_array                      = array();
                                                                    $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + abs(floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])));
                                                                    $subscriber_credit_array['bedehkar']          = floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']);
                                                                    $subscriber_credit_array['bestankar']         = 0;
                                                                    $subscriber_credit_array['user_or_branch_id'] = $res_factor[0]['subscriber_id'];
                                                                    $subscriber_credit_array['noe_user']          = '1';
                                                                    $subscriber_credit_array['tozihat']           = 'کسر مالیات و ارزش افزوده توسط سیستم در تاریخ: ' . Helper::Today_Shamsi_Date('-');
                                                                    $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                    $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                    $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                    $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);

                                                                    //////ibs/////
                                                                    if ($result) {
                                                                        Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                                                                        if ($res_service[0]['noe_forosh'] === 'adi' || $res_service[0]['noe_forosh'] === 'jashnvare') {
                                                                            $sql="SELECT fa.id,fa.emkanat_id,fa.service_id,fa.subscriber_id,ser.type,";
                                                                            switch ($res_service[0]['type']) {
                                                                                case 'adsl':
                                                                                case 'vdsl':
                                                                                case 'bitstream':
                                                                                case 'wireless':
                                                                                case 'tdlte':
                                                                                case 'voip':
                                                                                    $res_addnewuser = $GLOBALS['ibs_internet']->addNewUser(1, $res_service[0]['terafik'], 'Main', $res_factor[0]['onvane_service'], $res_subscriber[0]['code_meli']);
                                                                                    if (Helper::ibsCheckResponse($res_addnewuser)) {
                                                                                        // $tavalod_tmp            = Helper::dateConvertInitialize($res_subscriber[0]['tarikhe_tavalod']);
                                                                                        // $tavalode_fa            = Helper::gregorian_to_jalali($tavalod_tmp[0],$tavalod_tmp[1],$tavalod_tmp[2],'-');
                                                                                        $res_setuserattrs       = $GLOBALS['ibs_internet']->setUserAttributes(
                                                                                            $res_addnewuser[1][0],
                                                                                            array(
                                                                                                "name"              => $res_subscriber[0]['name'] . ' ' . $res_subscriber[0]['f_name'],
                                                                                                "comment"           => $res_subscriber[0]['code_meli'],
                                                                                                "phone"             => $res_subscriber[0]['telephone'],
                                                                                                "cell_phone"        => $res_subscriber[0]['telephone_hamrah'],
                                                                                                "postal_code"       => $res_subscriber[0]['shahkar_status_code'],
                                                                                                "email"             => $res_subscriber[0]['shomare_shenasname'] . ',' . $res_subscriber[0]['city_name'],
                                                                                                "address"           => $res_service[0]['type'],
                                                                                                "birthdate"         => $res_subscriber[0]['tarikhe_tavalod'],
                                                                                                "birthdate_unit"    => 'gregorian',
                                                                                                "abs_exp_date"      => $res_factor[0]['tarikhe_payane_service'],
                                                                                                "abs_exp_date_unit" => 'gregorian',
                                                                                                "normal_user_spec"  => array(
                                                                                                    "normal_username"   => (string) $res_subscriber[0]['telephone'],
                                                                                                    "normal_password"   => (string) $res_subscriber[0]['code_meli'],
                                                                                                )
                                                                                            )
                                                                                        );
                                                                                        if (Helper::ibsCheckResponse($res_setuserattrs)) {
                                                                                            die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                                                                                        } else {
                                                                                            die(Helper::Custom_Msg(Helper::Messages('icf') . ' ' . Helper::Messages('ps'), 2));
                                                                                        }
                                                                                    } else {
                                                                                        die(Helper::Custom_Msg(Helper::Messages('icf') . ' ' . Helper::Messages('ps'), 2));
                                                                                    }
                                                                                    break;
                                                                                default:
                                                                                    die(Helper::Custom_Msg(Helper::Messages('icf') . ' ' . Helper::Messages('ps'), 2));
                                                                                    break;
                                                                            }
                                                                        } elseif ($res_service[0]['noe_forosh'] === 'bulk') {
                                                                            //////todo.... bulk service
                                                                        } else {
                                                                            die(Helper::Custom_Msg(Helper::Messages('icf') . ' ' . Helper::Messages('ps'), 2));
                                                                        }
                                                                    } else {
                                                                        die(Helper::Json_Message('credit_operation_fail'));
                                                                    }
                                                                } else {
                                                                    die(Helper::Json_Message('credit_operation_fail'));
                                                                }
                                                            } else {
                                                                die(Helper::Json_Message('subscriber_credit_not_enough'));
                                                            }
                                                        } else {
                                                            die(Helper::Json_Message('subscriber_info_not_right'));
                                                        }
                                                    } else {
                                                        die(Helper::Json_Message('subscriber_info_not_right'));
                                                    }
                                                } else {
                                                    die(Helper::Json_Message('subscriber_not_found'));
                                                }
                                            } else {
                                                die(Helper::Json_Message('service_info_not_right'));
                                            }
                                        } else {
                                            die(Helper::Json_Message('service_not_found'));
                                        }
                                        break;

                                    case "pardakht_az_namayande":
                                        if ($res_service) {
                                            if (Helper::Is_Empty_OR_Null($res_service[0]['noe_forosh'])) {
                                                if ($res_subscriber) {
                                                    if ($res_branch) {
                                                        if ($res_subscriber[0]['branch_id'] !== 0) {
                                                            //moshtarak baraye namayande ast
                                                            switch ($_SESSION['user_type']) {
                                                                case '1':
                                                                    if ($res_branch[0]['id'] === $res_subscriber[0]['branch_id']) {
                                                                        //sherkat pardakht mikonad
                                                                        $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                        $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                        if ($res_credit_branch) {
                                                                            if (abs($res_credit_branch[0]['credit']) >= (abs($res_factor[0]['mablaghe_ghabele_pardakht']) + (abs($res_factor[0]['mablaghe_ghabele_pardakht']) * __BRANCHESACCEPTABLEBALANCEFORPAY__))) {
                                                                                //namayande credite kafi darad
                                                                                if ($res_noe_hamkari) {
                                                                                    //etelaate noe hamkarie namayande mojod ast
                                                                                    if (Helper::Is_Empty_OR_Null($res_noe_hamkari[0]['cooperation_type']) && Helper::Is_Empty_OR_Null($res_noe_hamkari[0]['service_type']) && Helper::Is_Empty_OR_Null($res_noe_hamkari[0]['foroshe_service_jadid']) && Helper::Is_Empty_OR_Null($res_noe_hamkari[0]['foroshe_service_sharje_mojadad']) && Helper::Is_Empty_OR_Null($res_noe_hamkari[0]['foroshe_service_jashnvare']) && Helper::Is_Empty_OR_Null($res_noe_hamkari[0]['hazine_sazmane_tanzim']) && Helper::Is_Empty_OR_Null($res_noe_hamkari[0]['hazine_servco']) && Helper::Is_Empty_OR_Null($res_noe_hamkari[0]['hazine_mansobe'])) {
                                                                                        if ($res_noe_hamkari[0]['cooperation_type'] === 1) {
                                                                                            //pardakht az namayande->darsadi
                                                                                            //all branch info exists so we can continue
                                                                                            //pardakhte az hesabe namayande kole mablaghe ghabele pardakht
                                                                                            $branch_credit_array                      = array();
                                                                                            $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) - (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])));
                                                                                            $branch_credit_array['bestankar']         = 0;
                                                                                            $branch_credit_array['bedehkar']          = floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (abs(floatval($res_factor[0]['maliate_arzeshe_afzode'])) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                            $branch_credit_array['noe_user']          = '2';
                                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                            $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                            $branch_credit_array['tozihat']           = 'پرداخت مبلغ فاکتور توسط نماینده/شرکت برای شماره : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                            $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                            $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                            //kasre maliat az hesabe namayande
                                                                                            $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                            $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                            $branch_credit_array                      = array();
                                                                                            $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                            $branch_credit_array['bestankar']         = 0;
                                                                                            $branch_credit_array['bedehkar']          = (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                            $branch_credit_array['noe_user']          = '2';
                                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                            $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                            $branch_credit_array['tozihat']           = 'کسر مالیات توسط سیستم برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                            $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                            $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                            $sql_credit_subscriber                    = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                            $res_credit_subscriber                    = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                            if ($res_credit_subscriber) {
                                                                                                // user has an account already
                                                                                                //add mablaghe kol to user credit
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) + floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                                $subscriber_credit_array['bedehkar']          = 0;
                                                                                                $subscriber_credit_array['bestankar']         = floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'بدهکاری مشترک به نماینده در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                                //kasre asle mablaghe kol az moshtarak
                                                                                                $sql_credit_subscriber                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                                $res_credit_subscriber                        = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])));
                                                                                                $subscriber_credit_array['bedehkar']          = floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bestankar']         = 0;
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'کسر اصل مبلغ فاکتور توسط سیستم در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                                //kasre credit - maliat+arzeshe afzoode az moshtarak
                                                                                                $sql_credit_subscriber                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                                $res_credit_subscriber                        = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bedehkar']          = (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bestankar']         = 0;
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'کسر مالیات و ارزش افزوده توسط نماینده/شرکت در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                            } else {
                                                                                                //create user account
                                                                                                //add mablaghe kol to user credit
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                                $subscriber_credit_array['bedehkar']          = 0;
                                                                                                $subscriber_credit_array['bestankar']         = floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_subscriber[0]['id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'بدهکاری مشترک به نماینده در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                                //kasre asle mablaghe kol az moshtarak
                                                                                                $sql_credit_subscriber                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                                $res_credit_subscriber                        = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])));
                                                                                                $subscriber_credit_array['bedehkar']          = floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bestankar']         = 0;
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_subscriber[0]['id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'کسر اصل مبلغ فاکتور توسط سیستم در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                                $sql_credit_subscriber                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id={$res_subscriber[0]['id']} AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                                $res_credit_subscriber                        = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                                //kasre credit - maliat+arzeshe afzoode az moshtarak
                                                                                                $sql_credit_subscriber                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                                $res_credit_subscriber                        = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bedehkar']          = (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bestankar']         = 0;
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_subscriber[0]['id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'کسر مالیات و ارزش افزوده توسط نماینده/شرکت در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                            }
                                                                                            $sql_factor_noe_kharid = "SELECT COUNT(*) AS rows_num FROM bnm_factor WHERE subscriber_id=? AND noe_khadamat=? AND tasvie_shode='1'";
                                                                                            $res_factor_noe_kharid = Db::secure_fetchall($sql_factor_noe_kharid, array($res_factor[0]['subscriber_id'], $res_factor[0]['noe_khadamat']));
                                                                                            $flag_noe_kharid       = "service_jadid";
                                                                                            if ($res_factor_noe_kharid) {
                                                                                                if ($res_factor_noe_kharid[0]['rows_num'] === 0) {
                                                                                                    $flag_noe_kharid = "service_jadid";
                                                                                                } else {
                                                                                                    $flag_noe_kharid = "sharje_mojadad";
                                                                                                }
                                                                                            } else {
                                                                                                $flag_noe_kharid = "service_jadid";
                                                                                            }
                                                                                            switch ($res_service[0]['noe_forosh']) {
                                                                                                case 'adi':
                                                                                                    $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                                    $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                                    if ($flag_noe_kharid == "sharje_mojadad") {
                                                                                                        //pardakhte porsante namayande baraye sharje mojadad zamani ke namayande hesabe bank darad
                                                                                                        $branch_credit_array                      = array();
                                                                                                        $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) + (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * ($res_noe_hamkari[0]['foroshe_service_sharje_mojadad'] / 100);
                                                                                                        $branch_credit_array['bestankar']         = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * ($res_noe_hamkari[0]['foroshe_service_sharje_mojadad'] / 100);
                                                                                                        $branch_credit_array['bedehkar']          = 0;
                                                                                                        $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                                        $branch_credit_array['noe_user']          = '2';
                                                                                                        $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                        $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                        $branch_credit_array['tozihat']           = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                                        $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                                        $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                                    } elseif ($flag_noe_kharid == "service_jadid") {
                                                                                                        //pardakhte porsante namayande baraye service jadid zamani ke namayande hesabe bank darad
                                                                                                        $branch_credit_array                      = array();
                                                                                                        $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) + (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * ($res_noe_hamkari[0]['foroshe_service_jadid'] / 100);
                                                                                                        $branch_credit_array['bestankar']         = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * ($res_noe_hamkari[0]['foroshe_service_jadid'] / 100);
                                                                                                        $branch_credit_array['bedehkar']          = 0;
                                                                                                        $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                                        $branch_credit_array['noe_user']          = '2';
                                                                                                        $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                        $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                        $branch_credit_array['tozihat']           = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                                        $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                                        $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                                    }
                                                                                                    Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                                                                                                    die(Helper::Json_Message('pardakht_success'));
                                                                                                    break;
                                                                                                case 'bulk':
                                                                                                    $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                                    $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                                    //pardakhte porsante namayande baraye bulk zamani ke namayande hesabe bank darad
                                                                                                    $branch_credit_array                      = array();
                                                                                                    $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) + (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * ($res_noe_hamkari[0]['foroshe_service_bulk'] / 100);
                                                                                                    $branch_credit_array['bestankar']         = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * ($res_noe_hamkari[0]['foroshe_service_bulk'] / 100);
                                                                                                    $branch_credit_array['bedehkar']          = 0;
                                                                                                    $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                                    $branch_credit_array['noe_user']          = '2';
                                                                                                    $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                    $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                    $branch_credit_array['tozihat']           = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                                    $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                                    $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                                    Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                                                                                                    die(Helper::Json_Message('pardakht_success'));
                                                                                                    break;
                                                                                                case 'jashnvare':
                                                                                                    $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                                    $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                                    //pardakhte porsante namayande baraye jashnvare zamani ke namayande hesabe bank darad
                                                                                                    $branch_credit_array                      = array();
                                                                                                    $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) + (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * ($res_noe_hamkari[0]['foroshe_service_jashnvare'] / 100);
                                                                                                    $branch_credit_array['bestankar']         = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * ($res_noe_hamkari[0]['foroshe_service_jashnvare'] / 100);
                                                                                                    $branch_credit_array['bedehkar']          = 0;
                                                                                                    $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                                    $branch_credit_array['noe_user']          = '2';
                                                                                                    $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                    $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                    $branch_credit_array['tozihat']           = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                                    $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                                    $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                                    Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                                                                                                    die(Helper::Json_Message('pardakht_success'));
                                                                                                    break;
                                                                                                default:
                                                                                                    die(Helper::Json_Message('service_info_not_right'));
                                                                                                    break;
                                                                                            }
                                                                                        } elseif ($res_noe_hamkari[0]['cooperation_type'] === 2) {
                                                                                            //pardakht az namayande->license
                                                                                            $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                            $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                            //pardakhte porsante(lisence) namayande zamani ke namayande hesabe bank darad
                                                                                            //insert credit ghabli
                                                                                            $branch_credit_array                      = array();
                                                                                            $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']);
                                                                                            $branch_credit_array['bestankar']         = 0;
                                                                                            $branch_credit_array['bedehkar']          = 0;
                                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                            $branch_credit_array['noe_user']          = '2';
                                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                            $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                            $branch_credit_array['tozihat']           = 'پرداخت مبلغ فاکتور برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                            $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                            $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                            //insert credit - maliat /update tozihat
                                                                                            $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                            $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                            $branch_credit_array                      = array();
                                                                                            $branch_credit_array['credit']            = abs(floatval($res_credit_branch[0]['credit'])) - (abs(floatval($res_factor[0]['maliate_arzeshe_afzode'])) + abs(floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))); //-maliat
                                                                                            $branch_credit_array['bestankar']         = 0;
                                                                                            $branch_credit_array['bedehkar']          = (abs(floatval($res_factor[0]['maliate_arzeshe_afzode'])) + abs(floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))); //-maliat
                                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                            $branch_credit_array['noe_user']          = '2';
                                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                            $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                            $branch_credit_array['tozihat']           = 'کسر مالیات برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                            $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                            $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                            //insert credit - darsade hazine_sazmane_tanzim /update tozihat
                                                                                            $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                            $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                            $branch_credit_array                      = array();
                                                                                            $branch_credit_array['credit']            = abs(floatval($res_credit_branch[0]['credit'])) - ((abs(floatval($res_factor[0]['mablaghe_ghabele_pardakht'])) - (abs(floatval($res_factor[0]['maliate_arzeshe_afzode'])) + abs(floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])))) * floatval($res_noe_hamkari[0]['hazine_sazmane_tanzim']) / 100); //-hazine_sazmane_tanzim
                                                                                            $branch_credit_array['bestankar']         = 0;
                                                                                            $branch_credit_array['bedehkar']          = (abs(floatval($res_factor[0]['mablaghe_ghabele_pardakht'])) - (abs(floatval($res_factor[0]['maliate_arzeshe_afzode'])) + abs(floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])))) * floatval($res_noe_hamkari[0]['hazine_sazmane_tanzim']) / 100;
                                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                            $branch_credit_array['noe_user']          = '2';
                                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                            $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                            $branch_credit_array['tozihat']           = 'کسر هزینه سازمان تنظیم برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                            $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                            $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                            //insert credit - darsade hazine_servco /update tozihat
                                                                                            $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                            $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                            $branch_credit_array                      = array();
                                                                                            $branch_credit_array['credit']            = abs(floatval($res_credit_branch[0]['credit'])) - ((abs(floatval($res_factor[0]['mablaghe_ghabele_pardakht'])) - (abs(floatval($res_factor[0]['maliate_arzeshe_afzode'])) + abs(floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])))) * floatval($res_noe_hamkari[0]['hazine_servco']) / 100); //-hazine_servco
                                                                                            $branch_credit_array['bestankar']         = 0;
                                                                                            $branch_credit_array['bedehkar']          = (abs(floatval($res_factor[0]['mablaghe_ghabele_pardakht'])) - (abs(floatval($res_factor[0]['maliate_arzeshe_afzode'])) + abs(floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])))) * floatval($res_noe_hamkari[0]['hazine_servco']) / 100; //-hazine_servco
                                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                            $branch_credit_array['noe_user']          = '2';
                                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                            $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                            $branch_credit_array['tozihat']           = 'کسر هزینه سروکو برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                            $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                            $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                            //insert credit - darsade hazine_mansobe /update tozihat
                                                                                            $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                            $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                            $branch_credit_array                      = array();
                                                                                            $branch_credit_array['credit']            = abs(floatval($res_credit_branch[0]['credit'])) - floatval($res_noe_hamkari[0]['hazine_mansobe']); //-hazine_mansobe
                                                                                            $branch_credit_array['bestankar']         = 0;
                                                                                            $branch_credit_array['bedehkar']          = floatval($res_noe_hamkari[0]['hazine_mansobe']);
                                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                            $branch_credit_array['noe_user']          = '2';
                                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                            $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                            $branch_credit_array['tozihat']           = 'کسر هزینه منصوبه برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                            $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                            $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                            ////////////////////////////subscriber credit //////////////////////////////////////////
                                                                                            $sql_credit_subscriber = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                            $res_credit_subscriber = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                            if ($res_credit_subscriber) {
                                                                                                // user has an account already
                                                                                                //add mablaghe kol to user credit
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) + floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                                $subscriber_credit_array['bedehkar']          = 0;
                                                                                                $subscriber_credit_array['bestankar']         = floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'بدهکاری مشترک به نماینده در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                                //kasre asle mablaghe kol az moshtarak
                                                                                                $sql_credit_subscriber                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                                $res_credit_subscriber                        = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])));
                                                                                                $subscriber_credit_array['bedehkar']          = floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bestankar']         = 0;
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'کسر مالیات توسط سیستم در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                                //kasre credit - maliat+arzeshe afzoode az moshtarak
                                                                                                $sql_credit_subscriber                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                                $res_credit_subscriber                        = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bedehkar']          = (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bestankar']         = 0;
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'کسر مبلغ فاکتور توسط نماینده/شرکت در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                            } else {
                                                                                                //create user account
                                                                                                //add mablaghe kol to user credit
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                                $subscriber_credit_array['bedehkar']          = 0;
                                                                                                $subscriber_credit_array['bestankar']         = floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_factor[0]['subscriber_id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'بدهکاری مشترک به نماینده در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                                //kasre asle mablaghe kol az moshtarak
                                                                                                $sql_credit_subscriber                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                                $res_credit_subscriber                        = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])));
                                                                                                $subscriber_credit_array['bedehkar']          = floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bestankar']         = 0;
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_factor[0]['subscriber_id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'کسر مالیات توسط سیستم در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                                //kasre credit - maliat+arzeshe afzoode az moshtarak
                                                                                                $sql_credit_subscriber                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                                $res_credit_subscriber                        = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bedehkar']          = (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bestankar']         = 0;
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_factor[0]['subscriber_id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'کسر مبلغ فاکتور توسط نماینده/شرکت در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                            }
                                                                                            Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                                                                                            die(Helper::Json_Message('pardakht_success'));
                                                                                        }
                                                                                    } else {
                                                                                        die(Helper::Json_Message('branch_cooperation_info_not_found'));
                                                                                    }
                                                                                } else {
                                                                                    die(Helper::Json_Message('branch_cooperation_info_not_found'));
                                                                                }
                                                                            } else {
                                                                                die(Helper::Json_Message('branch_credit_not_enough'));
                                                                            }
                                                                        } else {
                                                                            die(Helper::Json_Message('branch_credit_account_not_found'));
                                                                        }
                                                                    }
                                                                    break;
                                                                default:
                                                                    die(Helper::Json_Message('auth_fail'));
                                                                    break;
                                                            }
                                                        } else {
                                                            die(Helper::Json_Message('auth_fail'));
                                                        }
                                                    } else {
                                                        die(Helper::json_Message('branch_not_found'));
                                                    }
                                                } else {
                                                    die(Helper::Json_Message('subscriber_not_found'));
                                                }
                                            } else {
                                                die(Helper::Json_Message('service_info_not_right'));
                                            }
                                        } else {
                                            die(Helper::Json_Message('service_not_found'));
                                        }

                                        break;
                                    case "pardakht_dasti":
                                        die(Helper::Json_Message('info_not_true'));
                                        break;

                                    default:
                                        die(Helper::Json_Message('info_not_true'));
                                        break;
                                }
                            } else {
                                die(Helper::Json_Message('factor_not_found'));
                            }
                        } else {
                            die(Helper::Json_Message('required_info_not_found'));
                        }
                        break;
                    case __MODIRUSERTYPE__:
                    case __OPERATORUSERTYPE__:

                        if (Helper::Is_Empty_OR_Null($_POST['factor_id'])) {
                            $sql_factor = "SELECT * FROM bnm_factor WHERE id=? AND DATE(tarikhe_factor)=CURDATE() AND tasvie_shode<>'1'";
                            $res_factor = Db::secure_fetchall($sql_factor, array($_POST['factor_id']));
                            if ($res_factor) {
                                switch ($_POST['noe_pardakht']) {
                                    case "pardakht_az_subscriber":
                                        $sql_service = "SELECT * FROM bnm_services WHERE id=?";
                                        $res_service = Db::secure_fetchall($sql_service, array($res_factor[0]['service_id']));
                                        if ($res_service) {
                                            if (Helper::Is_Empty_OR_Null($res_service[0]['noe_forosh'])) {
                                                $sql_subscriber = "SELECT id,name,f_name,branch_id FROM bnm_subscribers WHERE id=? AND branch_id=?";
                                                $res_subscriber = Db::secure_fetchall($sql_subscriber, array($res_factor[0]['subscriber_id'], $_SESSION['branch_id']));
                                                if ($res_subscriber) {
                                                    if ($res_subscriber[0]['branch_id'] !== 0) {
                                                        //user braraye namayande ast
                                                        $sql_credit_subscriber = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                        $res_credit_subscriber = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                        if ($res_credit_subscriber) {
                                                            //moshtarak hesabe bank darad
                                                            if (abs(floatval($res_credit_subscriber[0]['credit'])) >= (abs(floatval($res_factor[0]['mablaghe_ghabele_pardakht'])) + (abs(floatval($res_factor[0]['mablaghe_ghabele_pardakht']) * __BRANCHESACCEPTABLEBALANCEFORPAY__)))) {
                                                                $sql_noe_hamkari = "SELECT * FROM bnm_branch_cooperation_type WHERE branch_id=? AND service_type=? ORDER BY id DESC LIMIT 1";
                                                                $res_noe_hamkari = Db::secure_fetchall($sql_noe_hamkari, array($res_subscriber[0]['branch_id'], $res_factor[0]['noe_khadamat']));
                                                                if ($res_noe_hamkari) {
                                                                    //kasre mablaghe factor az moshtarak
                                                                    $subscriber_credit_array                      = array();
                                                                    $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])));
                                                                    $subscriber_credit_array['bedehkar']          = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])));
                                                                    $subscriber_credit_array['bestankar']         = 0;
                                                                    $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                                    $subscriber_credit_array['noe_user']          = '1';
                                                                    $subscriber_credit_array['tozihat']           = 'فاکتور شما توسط نماینده/سروکو در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'] . 'پرداخت شد.';
                                                                    $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                    $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                    $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                    $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                    if ($result) {
                                                                        $sql_credit_subscriber = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                        $res_credit_subscriber = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                        //kasre mablaghe maliat va arzeshe afzode az moshtarak
                                                                        $subscriber_credit_array                      = array();
                                                                        $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                        $subscriber_credit_array['bedehkar']          = (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                        $subscriber_credit_array['bestankar']         = 0;
                                                                        $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                                        $subscriber_credit_array['noe_user']          = '1';
                                                                        $subscriber_credit_array['tozihat']           = 'کسر مالیات و ارزش افزوده توسط سیستم در تاریخ: ' . Helper::Today_Shamsi_Date('-');
                                                                        $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                        $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                        $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                        $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                        //get noe_hamkari info for this factor
                                                                        //mohasebe soode namayande az in forosh
                                                                        if ($res_noe_hamkari[0]['cooperation_type'] === 1) {
                                                                            //namayande->darsadi
                                                                            $flag_noe_kharid       = "service_jadid";
                                                                            $sql_factor_noe_kharid = "SELECT COUNT(*) AS rows_num FROM bnm_factor WHERE subscriber_id=? AND noe_khadamat=? AND tasvie_shode='1'";
                                                                            $res_factor_noe_kharid = Db::secure_fetchall($sql_factor_noe_kharid, array($res_factor[0]['subscriber_id'], $res_factor[0]['noe_khadamat']));

                                                                            if ($res_factor_noe_kharid) {
                                                                                if ($res_factor_noe_kharid[0]['rows_num'] === 0) {
                                                                                    $flag_noe_kharid = "service_jadid";
                                                                                } else {
                                                                                    $flag_noe_kharid = "sharje_mojadad";
                                                                                }
                                                                            } else {
                                                                                $flag_noe_kharid = "service_jadid";
                                                                            }
                                                                            $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                            $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                            switch ($res_service[0]['noe_forosh']) {
                                                                                case 'adi':
                                                                                    if ($flag_noe_kharid == "sharje_mojadad") {
                                                                                        if ($res_credit_branch) {
                                                                                            //pardakhte porsante namayande baraye sharje mojadad zamani ke namayande hesabe bank darad
                                                                                            $branch_credit_array                      = array();
                                                                                            $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) + (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_sharje_mojadad']) / 100);
                                                                                            $branch_credit_array['bestankar']         = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_sharje_mojadad']) / 100);
                                                                                            $branch_credit_array['bedehkar']          = 0;
                                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                            $branch_credit_array['noe_user']          = '2';
                                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                            $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                            $branch_credit_array['tozihat']           = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                            $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                            $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                        } else {
                                                                                            //pardakhte porsante namayande baraye sharje mojadad zamani ke namayande hesabe bank nadarad
                                                                                            $branch_credit_array                      = array();
                                                                                            $branch_credit_array['credit']            = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_sharje_mojadad']) / 100);
                                                                                            $branch_credit_array['bestankar']         = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_sharje_mojadad']) / 100);
                                                                                            $branch_credit_array['bedehkar']          = 0;
                                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                            $branch_credit_array['noe_user']          = '2';
                                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                            $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                            $branch_credit_array['tozihat']           = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                            $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                            $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                        }
                                                                                    } elseif ($flag_noe_kharid == "service_jadid") {

                                                                                        if ($res_credit_branch) {
                                                                                            //pardakhte porsante namayande baraye service jadid zamani ke namayande hesabe bank darad
                                                                                            $branch_credit_array                      = array();
                                                                                            $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) + (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_jadid']) / 100);
                                                                                            $branch_credit_array['bestankar']         = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_jadid']) / 100);
                                                                                            $branch_credit_array['bedehkar']          = 0;
                                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                            $branch_credit_array['noe_user']          = '2';
                                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                            $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                            $branch_credit_array['tozihat']           = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                            $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                            $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                        } else {
                                                                                            //pardakhte porsante namayande baraye service jadid zamani ke namayande hesabe bank nadarad
                                                                                            $branch_credit_array                      = array();
                                                                                            $branch_credit_array['credit']            = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_jadid']) / 100);
                                                                                            $branch_credit_array['bestankar']         = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_jadid']) / 100);
                                                                                            $branch_credit_array['bedehkar']          = 0;
                                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                            $branch_credit_array['noe_user']          = '2';
                                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                            $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                            $branch_credit_array['tozihat']           = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                            $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                            $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                        }
                                                                                    }
                                                                                    Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                                                                                    die(Helper::Json_Message('pardakht_success'));
                                                                                    break;
                                                                                case 'bulk':
                                                                                    if ($res_credit_branch) {
                                                                                        //pardakhte porsante namayande baraye bulk zamani ke namayande hesabe bank darad
                                                                                        $branch_credit_array                      = array();
                                                                                        $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) + ((floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_bulk']) / 100));
                                                                                        $branch_credit_array['bestankar']         = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_bulk']) / 100);
                                                                                        $branch_credit_array['bedehkar']          = 0;
                                                                                        $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                        $branch_credit_array['noe_user']          = '2';
                                                                                        $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                        $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                        $branch_credit_array['tozihat']           = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                        $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                        $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                    } else {
                                                                                        //pardakhte porsante namayande baraye bulk zamani ke namayande hesabe bank nadarad
                                                                                        $branch_credit_array                      = array();
                                                                                        $branch_credit_array['credit']            = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_bulk']) / 100);
                                                                                        $branch_credit_array['bestankar']         = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_bulk']) / 100);
                                                                                        $branch_credit_array['bedehkar']          = 0;
                                                                                        $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                        $branch_credit_array['noe_user']          = '2';
                                                                                        $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                        $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                        $branch_credit_array['tozihat']           = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                        $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                        $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                    }
                                                                                    Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                                                                                    die(Helper::Json_Message('pardakht_success'));
                                                                                    break;
                                                                                case 'jashnvare':
                                                                                    if ($res_credit_branch) {
                                                                                        //pardakhte porsante namayande baraye jashnvare zamani ke namayande hesabe bank darad
                                                                                        $branch_credit_array                      = array();
                                                                                        $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) + ((floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_jashnvare']) / 100));
                                                                                        $branch_credit_array['bestankar']         = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_jashnvare']) / 100);
                                                                                        $branch_credit_array['bedehkar']          = 0;
                                                                                        $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                        $branch_credit_array['noe_user']          = '2';
                                                                                        $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                        $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                        $branch_credit_array['tozihat']           = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                        $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                        $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                    } else {
                                                                                        //pardakhte porsante namayande baraye jashnvare zamani ke namayande hesabe bank nadarad
                                                                                        $branch_credit_array                      = array();
                                                                                        $branch_credit_array['credit']            = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_jashnvare']) / 100);
                                                                                        $branch_credit_array['bestankar']         = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_jashnvare']) / 100);
                                                                                        $branch_credit_array['bedehkar']          = 0;
                                                                                        $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                        $branch_credit_array['noe_user']          = '2';
                                                                                        $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                        $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                        $branch_credit_array['tozihat']           = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                        $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                        $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                    }
                                                                                    Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                                                                                    die(Helper::Json_Message('pardakht_success'));
                                                                                    break;

                                                                                default:
                                                                                    die(Helper::Json_Message('service_info_not_right'));
                                                                                    break;
                                                                            }
                                                                        } elseif ($res_noe_hamkari[0]['cooperation_type'] === 2) {
                                                                            // license
                                                                            $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                            $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                            if ($res_credit_branch) {
                                                                                //pardakhte porsante(lisence) namayande zamani ke namayande hesabe bank darad
                                                                                //insert credit + mablaghe_ghabele_pardakht
                                                                                $branch_credit_array                      = array();
                                                                                $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) + floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                $branch_credit_array['bestankar']         = floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                $branch_credit_array['bedehkar']          = 0;
                                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                $branch_credit_array['noe_user']          = '2';
                                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                $branch_credit_array['tozihat']           = 'پرداخت مبلغ فاکتور برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                //insert credit - maliat /update tozihat
                                                                                $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                $branch_credit_array                      = array();
                                                                                $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])); //-maliat
                                                                                $branch_credit_array['bestankar']         = 0;
                                                                                $branch_credit_array['bedehkar']          = (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])); //-maliat
                                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                $branch_credit_array['noe_user']          = '2';
                                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                $branch_credit_array['tozihat']           = 'کسر مالیات برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                //insert credit - darsade hazine_sazmane_tanzim /update tozihat
                                                                                $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                $branch_credit_array                      = array();
                                                                                $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) - ((floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['hazine_sazmane_tanzim']) / 100));
                                                                                $branch_credit_array['bestankar']         = 0;
                                                                                $branch_credit_array['bedehkar']          = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['hazine_sazmane_tanzim']) / 100);
                                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                $branch_credit_array['noe_user']          = '2';
                                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                $branch_credit_array['tozihat']           = 'کسر هزینه سازمان تنظیم برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                //insert credit - darsade hazine_servco /update tozihat
                                                                                $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                $branch_credit_array                      = array();
                                                                                $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) - ((floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['hazine_servco']) / 100));
                                                                                $branch_credit_array['bestankar']         = 0;
                                                                                $branch_credit_array['bedehkar']          = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['hazine_servco']) / 100);
                                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                $branch_credit_array['noe_user']          = '2';
                                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                $branch_credit_array['tozihat']           = 'کسر هزینه سروکو برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                //insert credit - darsade hazine_mansobe /update tozihat
                                                                                $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                $branch_credit_array                      = array();
                                                                                $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) - floatval($res_noe_hamkari[0]['hazine_mansobe']);
                                                                                $branch_credit_array['bestankar']         = 0;
                                                                                $branch_credit_array['bedehkar']          = floatval($res_noe_hamkari[0]['hazine_mansobe']);
                                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                $branch_credit_array['noe_user']          = '2';
                                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                $branch_credit_array['tozihat']           = 'کسر هزینه منصوبه برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                                                                                die(Helper::Json_Message('pardakht_success'));
                                                                            } else {
                                                                                //pardakhte porsante(lisence) namayande zamani ke namayande hesabe bank nadarad
                                                                                //NO credit Account
                                                                                //insert credit + mablaghe_ghabele_pardakht
                                                                                $branch_credit_array                      = array();
                                                                                $branch_credit_array['credit']            = floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                $branch_credit_array['bestankar']         = floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                $branch_credit_array['bedehkar']          = 0;
                                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                $branch_credit_array['noe_user']          = '2';
                                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                $branch_credit_array['tozihat']           = 'پرداخت مبلغ فاکتور برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                //insert credit - maliat /update tozihat
                                                                                $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                $branch_credit_array                      = array();
                                                                                $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])); //-maliat
                                                                                $branch_credit_array['bestankar']         = 0;
                                                                                $branch_credit_array['bedehkar']          = (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])); //-maliat
                                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                $branch_credit_array['noe_user']          = '2';
                                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                $branch_credit_array['tozihat']           = 'کسر مالیات برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                //insert credit - darsade hazine_sazmane_tanzim /update tozihat
                                                                                $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                $branch_credit_array                      = array();
                                                                                $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) - ((floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['hazine_sazmane_tanzim']) / 100));
                                                                                $branch_credit_array['bestankar']         = 0;
                                                                                $branch_credit_array['bedehkar']          = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['hazine_sazmane_tanzim']) / 100);
                                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                $branch_credit_array['noe_user']          = '2';
                                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                $branch_credit_array['tozihat']           = 'کسر هزینه سازمان تنظیم برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                //insert credit - darsade hazine_servco /update tozihat
                                                                                $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                $branch_credit_array                      = array();
                                                                                $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) - ((floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['hazine_servco']) / 100));
                                                                                $branch_credit_array['bestankar']         = 0;
                                                                                $branch_credit_array['bedehkar']          = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['hazine_servco']) / 100);
                                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                $branch_credit_array['noe_user']          = '2';
                                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                $branch_credit_array['tozihat']           = 'کسر هزینه سروکو برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                //insert credit - darsade hazine_mansobe /update tozihat
                                                                                $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                $branch_credit_array                      = array();
                                                                                $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) - floatval($res_noe_hamkari[0]['hazine_mansobe']);
                                                                                $branch_credit_array['bestankar']         = 0;
                                                                                $branch_credit_array['bedehkar']          = floatval($res_noe_hamkari[0]['hazine_mansobe']);
                                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                $branch_credit_array['noe_user']          = '2';
                                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                $branch_credit_array['tozihat']           = 'کسر هزینه منصوبه برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                                                                                die(Helper::Json_Message('pardakht_success'));
                                                                            }
                                                                        } else {
                                                                            die(Helper::Json_Message('credit_operation_fail'));
                                                                        }
                                                                    } else {
                                                                        die(Helper::Json_Message('credit_operation_fail'));
                                                                    }
                                                                } else {
                                                                    die(Helper::Json_Message('credit_operation_fail'));
                                                                }
                                                            } else {
                                                                die(Helper::Json_Message('subscriber_credit_not_enough'));
                                                            }
                                                        } else {
                                                            die(Helper::Json_Message('subscriber_credit_info_not_found'));
                                                        }
                                                    } elseif ($res_subscriber[0]['branch_id'] === 0) {
                                                        //todo... user baraye sahar ast
                                                        die(Helper::Json_Message('auth_fail'));
                                                    } else {
                                                        die(Helper::Json_Message('subscriber_info_not_right'));
                                                    }
                                                } else {
                                                    die(Helper::Json_Message('subscriber_not_found'));
                                                }
                                            } else {
                                                die(Helper::Json_Message('service_info_not_right'));
                                            }
                                        } else {
                                            die(Helper::Json_Message('service_not_found'));
                                        }
                                        break;

                                    case "pardakht_az_namayande":
                                        $sql_service = "SELECT * FROM bnm_services WHERE id=?";
                                        $res_service = Db::secure_fetchall($sql_service, array($res_factor[0]['service_id']));
                                        if ($res_service) {
                                            if (Helper::Is_Empty_OR_Null($res_service[0]['noe_forosh'])) {
                                                $sql_subscriber = "SELECT id,name,f_name,branch_id FROM bnm_subscribers WHERE id=? AND branch_id=?";
                                                $res_subscriber = Db::secure_fetchall($sql_subscriber, array($res_factor[0]['subscriber_id'], $_SESSION['branch_id']));
                                                if ($res_subscriber) {
                                                    $sql_branch = "SELECT id,name_sherkat FROM bnm_branch WHERE id =?";
                                                    $res_branch = Db::secure_fetchall($sql_branch, array($_SESSION['branch_id']));
                                                    if ($res_branch) {
                                                        if ($res_subscriber[0]['branch_id'] !== 0) {
                                                            //moshtarak baraye namayande ast
                                                            switch ($_SESSION['user_type']) {
                                                                case __ADMINUSERTYPE__:
                                                                case __ADMINOPERATORUSERTYPE__:
                                                                    if ($res_branch[0]['id'] === $res_subscriber[0]['branch_id']) {
                                                                        //sherkat pardakht mikonad
                                                                        $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                        $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                        if ($res_credit_branch) {
                                                                            if (abs(floatval($res_credit_branch[0]['credit'])) >= (abs(floatval($res_factor[0]['mablaghe_ghabele_pardakht'])) + (abs(floatval($res_factor[0]['mablaghe_ghabele_pardakht']) * __BRANCHESACCEPTABLEBALANCEFORPAY__)))) {
                                                                                //namayande credite kafi darad
                                                                                $sql_noe_hamkari = "SELECT * FROM bnm_branch_cooperation_type WHERE branch_id=? AND service_type=? ORDER BY id DESC LIMIT 1";
                                                                                $res_noe_hamkari = Db::secure_fetchall($sql_noe_hamkari, array($res_subscriber[0]['branch_id'], $res_factor[0]['noe_khadamat']));
                                                                                if ($res_noe_hamkari) {
                                                                                    //etelaate noe hamkarie namayande mojod ast
                                                                                    if (Helper::Is_Empty_OR_Null($res_noe_hamkari[0]['cooperation_type']) && Helper::Is_Empty_OR_Null($res_noe_hamkari[0]['service_type']) && Helper::Is_Empty_OR_Null($res_noe_hamkari[0]['foroshe_service_jadid']) && Helper::Is_Empty_OR_Null($res_noe_hamkari[0]['foroshe_service_sharje_mojadad']) && Helper::Is_Empty_OR_Null($res_noe_hamkari[0]['foroshe_service_jashnvare']) && Helper::Is_Empty_OR_Null($res_noe_hamkari[0]['hazine_sazmane_tanzim']) && Helper::Is_Empty_OR_Null($res_noe_hamkari[0]['hazine_servco']) && Helper::Is_Empty_OR_Null($res_noe_hamkari[0]['hazine_mansobe'])) {
                                                                                        if ($res_noe_hamkari[0]['cooperation_type'] === 1) {
                                                                                            //pardakht az namayande->darsadi
                                                                                            //all branch info exists so we can continue
                                                                                            //pardakhte az hesabe namayande kole mablaghe ghabele pardakht
                                                                                            $branch_credit_array                      = array();
                                                                                            $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) - (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])));
                                                                                            $branch_credit_array['bestankar']         = 0;
                                                                                            $branch_credit_array['bedehkar']          = floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (abs(floatval($res_factor[0]['maliate_arzeshe_afzode'])) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                            $branch_credit_array['noe_user']          = '2';
                                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                            $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                            $branch_credit_array['tozihat']           = 'پرداخت مبلغ فاکتور توسط نماینده/شرکت برای شماره : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                            $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                            $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                            //kasre maliat az hesabe namayande
                                                                                            $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                            $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                            $branch_credit_array                      = array();
                                                                                            $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                            $branch_credit_array['bestankar']         = 0;
                                                                                            $branch_credit_array['bedehkar']          = (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                            $branch_credit_array['noe_user']          = '2';
                                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                            $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                            $branch_credit_array['tozihat']           = 'کسر مالیات توسط سیستم برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                            $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                            $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                            $sql_credit_subscriber                    = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                            $res_credit_subscriber                    = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                            if ($res_credit_subscriber) {
                                                                                                // user has an account already
                                                                                                //add mablaghe kol to user credit
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) + floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                                $subscriber_credit_array['bedehkar']          = 0;
                                                                                                $subscriber_credit_array['bestankar']         = floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'بدهکاری مشترک به نماینده در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                                //kasre asle mablaghe kol az moshtarak
                                                                                                $sql_credit_subscriber                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                                $res_credit_subscriber                        = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])));
                                                                                                $subscriber_credit_array['bedehkar']          = floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bestankar']         = 0;
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'کسر اصل مبلغ فاکتور توسط سیستم در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                                //kasre credit - maliat+arzeshe afzoode az moshtarak
                                                                                                $sql_credit_subscriber                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                                $res_credit_subscriber                        = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bedehkar']          = (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bestankar']         = 0;
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'کسر مالیات و ارزش افزوده توسط نماینده/شرکت در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                            } else {
                                                                                                //create user account
                                                                                                //add mablaghe kol to user credit
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                                $subscriber_credit_array['bedehkar']          = 0;
                                                                                                $subscriber_credit_array['bestankar']         = floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_subscriber[0]['id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'بدهکاری مشترک به نماینده در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                                //kasre asle mablaghe kol az moshtarak
                                                                                                $sql_credit_subscriber                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                                $res_credit_subscriber                        = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])));
                                                                                                $subscriber_credit_array['bedehkar']          = floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bestankar']         = 0;
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_subscriber[0]['id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'کسر اصل مبلغ فاکتور توسط سیستم در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                                $sql_credit_subscriber                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id={$res_subscriber[0]['id']} AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                                $res_credit_subscriber                        = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                                //kasre credit - maliat+arzeshe afzoode az moshtarak
                                                                                                $sql_credit_subscriber                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                                $res_credit_subscriber                        = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bedehkar']          = (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bestankar']         = 0;
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_subscriber[0]['id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'کسر مالیات و ارزش افزوده توسط نماینده/شرکت در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                            }
                                                                                            $sql_factor_noe_kharid = "SELECT COUNT(*) AS rows_num FROM bnm_factor WHERE subscriber_id=? AND noe_khadamat=? AND tasvie_shode='1'";
                                                                                            $res_factor_noe_kharid = Db::secure_fetchall($sql_factor_noe_kharid, array($res_factor[0]['subscriber_id'], $res_factor[0]['noe_khadamat']));
                                                                                            $flag_noe_kharid       = "service_jadid";
                                                                                            if ($res_factor_noe_kharid) {
                                                                                                if ($res_factor_noe_kharid[0]['rows_num'] === 0) {
                                                                                                    $flag_noe_kharid = "service_jadid";
                                                                                                } else {
                                                                                                    $flag_noe_kharid = "sharje_mojadad";
                                                                                                }
                                                                                            } else {
                                                                                                $flag_noe_kharid = "service_jadid";
                                                                                            }
                                                                                            switch ($res_service[0]['noe_forosh']) {
                                                                                                case 'adi':
                                                                                                    $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                                    $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                                    if ($flag_noe_kharid == "sharje_mojadad") {
                                                                                                        //pardakhte porsante namayande baraye sharje mojadad zamani ke namayande hesabe bank darad
                                                                                                        $branch_credit_array                      = array();
                                                                                                        $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) + (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * ($res_noe_hamkari[0]['foroshe_service_sharje_mojadad'] / 100);
                                                                                                        $branch_credit_array['bestankar']         = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * ($res_noe_hamkari[0]['foroshe_service_sharje_mojadad'] / 100);
                                                                                                        $branch_credit_array['bedehkar']          = 0;
                                                                                                        $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                                        $branch_credit_array['noe_user']          = '2';
                                                                                                        $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                        $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                        $branch_credit_array['tozihat']           = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                                        $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                                        $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                                    } elseif ($flag_noe_kharid == "service_jadid") {
                                                                                                        //pardakhte porsante namayande baraye service jadid zamani ke namayande hesabe bank darad
                                                                                                        $branch_credit_array                      = array();
                                                                                                        $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) + (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * ($res_noe_hamkari[0]['foroshe_service_jadid'] / 100);
                                                                                                        $branch_credit_array['bestankar']         = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * ($res_noe_hamkari[0]['foroshe_service_jadid'] / 100);
                                                                                                        $branch_credit_array['bedehkar']          = 0;
                                                                                                        $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                                        $branch_credit_array['noe_user']          = '2';
                                                                                                        $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                        $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                        $branch_credit_array['tozihat']           = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                                        $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                                        $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                                    }
                                                                                                    Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                                                                                                    die(Helper::Json_Message('pardakht_success'));
                                                                                                    break;
                                                                                                case 'bulk':
                                                                                                    $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                                    $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                                    //pardakhte porsante namayande baraye bulk zamani ke namayande hesabe bank darad
                                                                                                    $branch_credit_array                      = array();
                                                                                                    $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) + (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * ($res_noe_hamkari[0]['foroshe_service_bulk'] / 100);
                                                                                                    $branch_credit_array['bestankar']         = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * ($res_noe_hamkari[0]['foroshe_service_bulk'] / 100);
                                                                                                    $branch_credit_array['bedehkar']          = 0;
                                                                                                    $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                                    $branch_credit_array['noe_user']          = '2';
                                                                                                    $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                    $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                    $branch_credit_array['tozihat']           = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                                    $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                                    $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                                    Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                                                                                                    die(Helper::Json_Message('pardakht_success'));
                                                                                                    break;
                                                                                                case 'jashnvare':
                                                                                                    $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                                    $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                                    //pardakhte porsante namayande baraye jashnvare zamani ke namayande hesabe bank darad
                                                                                                    $branch_credit_array                      = array();
                                                                                                    $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) + (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * ($res_noe_hamkari[0]['foroshe_service_jashnvare'] / 100);
                                                                                                    $branch_credit_array['bestankar']         = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * ($res_noe_hamkari[0]['foroshe_service_jashnvare'] / 100);
                                                                                                    $branch_credit_array['bedehkar']          = 0;
                                                                                                    $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                                    $branch_credit_array['noe_user']          = '2';
                                                                                                    $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                    $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                    $branch_credit_array['tozihat']           = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                                    $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                                    $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                                    Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                                                                                                    die(Helper::Json_Message('pardakht_success'));
                                                                                                    break;
                                                                                                default:
                                                                                                    die(Helper::Json_Message('service_info_not_right'));
                                                                                                    break;
                                                                                            }
                                                                                        } elseif ($res_noe_hamkari[0]['cooperation_type'] === 2) {
                                                                                            //pardakht az namayande->license
                                                                                            $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                            $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                            //pardakhte porsante(lisence) namayande zamani ke namayande hesabe bank darad
                                                                                            //insert credit ghabli
                                                                                            $branch_credit_array                      = array();
                                                                                            $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']);
                                                                                            $branch_credit_array['bestankar']         = 0;
                                                                                            $branch_credit_array['bedehkar']          = 0;
                                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                            $branch_credit_array['noe_user']          = '2';
                                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                            $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                            $branch_credit_array['tozihat']           = 'پرداخت مبلغ فاکتور برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                            $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                            $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                            //insert credit - maliat /update tozihat
                                                                                            $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                            $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                            $branch_credit_array                      = array();
                                                                                            $branch_credit_array['credit']            = abs(floatval($res_credit_branch[0]['credit'])) - (abs(floatval($res_factor[0]['maliate_arzeshe_afzode'])) + abs(floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))); //-maliat
                                                                                            $branch_credit_array['bestankar']         = 0;
                                                                                            $branch_credit_array['bedehkar']          = (abs(floatval($res_factor[0]['maliate_arzeshe_afzode'])) + abs(floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))); //-maliat
                                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                            $branch_credit_array['noe_user']          = '2';
                                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                            $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                            $branch_credit_array['tozihat']           = 'کسر مالیات برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                            $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                            $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                            //insert credit - darsade hazine_sazmane_tanzim /update tozihat
                                                                                            $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                            $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                            $branch_credit_array                      = array();
                                                                                            $branch_credit_array['credit']            = abs(floatval($res_credit_branch[0]['credit'])) - ((abs(floatval($res_factor[0]['mablaghe_ghabele_pardakht'])) - (abs(floatval($res_factor[0]['maliate_arzeshe_afzode'])) + abs(floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])))) * floatval($res_noe_hamkari[0]['hazine_sazmane_tanzim']) / 100); //-hazine_sazmane_tanzim
                                                                                            $branch_credit_array['bestankar']         = 0;
                                                                                            $branch_credit_array['bedehkar']          = (abs(floatval($res_factor[0]['mablaghe_ghabele_pardakht'])) - (abs(floatval($res_factor[0]['maliate_arzeshe_afzode'])) + abs(floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])))) * floatval($res_noe_hamkari[0]['hazine_sazmane_tanzim']) / 100;
                                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                            $branch_credit_array['noe_user']          = '2';
                                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                            $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                            $branch_credit_array['tozihat']           = 'کسر هزینه سازمان تنظیم برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                            $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                            $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                            //insert credit - darsade hazine_servco /update tozihat
                                                                                            $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                            $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                            $branch_credit_array                      = array();
                                                                                            $branch_credit_array['credit']            = abs(floatval($res_credit_branch[0]['credit'])) - ((abs(floatval($res_factor[0]['mablaghe_ghabele_pardakht'])) - (abs(floatval($res_factor[0]['maliate_arzeshe_afzode'])) + abs(floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])))) * floatval($res_noe_hamkari[0]['hazine_servco']) / 100); //-hazine_servco
                                                                                            $branch_credit_array['bestankar']         = 0;
                                                                                            $branch_credit_array['bedehkar']          = (abs(floatval($res_factor[0]['mablaghe_ghabele_pardakht'])) - (abs(floatval($res_factor[0]['maliate_arzeshe_afzode'])) + abs(floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])))) * floatval($res_noe_hamkari[0]['hazine_servco']) / 100; //-hazine_servco
                                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                            $branch_credit_array['noe_user']          = '2';
                                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                            $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                            $branch_credit_array['tozihat']           = 'کسر هزینه سروکو برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                            $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                            $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                            //insert credit - darsade hazine_mansobe /update tozihat
                                                                                            $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                            $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                            $branch_credit_array                      = array();
                                                                                            $branch_credit_array['credit']            = abs(floatval($res_credit_branch[0]['credit'])) - floatval($res_noe_hamkari[0]['hazine_mansobe']); //-hazine_mansobe
                                                                                            $branch_credit_array['bestankar']         = 0;
                                                                                            $branch_credit_array['bedehkar']          = floatval($res_noe_hamkari[0]['hazine_mansobe']);
                                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                            $branch_credit_array['noe_user']          = '2';
                                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                            $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                            $branch_credit_array['tozihat']           = 'کسر هزینه منصوبه برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                            $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                            $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                            ////////////////////////////subscriber credit //////////////////////////////////////////
                                                                                            $sql_credit_subscriber = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                            $res_credit_subscriber = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                            if ($res_credit_subscriber) {
                                                                                                // user has an account already
                                                                                                //add mablaghe kol to user credit
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) + floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                                $subscriber_credit_array['bedehkar']          = 0;
                                                                                                $subscriber_credit_array['bestankar']         = floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'بدهکاری مشترک به نماینده در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                                //kasre asle mablaghe kol az moshtarak
                                                                                                $sql_credit_subscriber                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                                $res_credit_subscriber                        = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])));
                                                                                                $subscriber_credit_array['bedehkar']          = floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bestankar']         = 0;
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'کسر مالیات توسط سیستم در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                                //kasre credit - maliat+arzeshe afzoode az moshtarak
                                                                                                $sql_credit_subscriber                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                                $res_credit_subscriber                        = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bedehkar']          = (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bestankar']         = 0;
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'کسر مبلغ فاکتور توسط نماینده/شرکت در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                            } else {
                                                                                                //create user account
                                                                                                //add mablaghe kol to user credit
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                                $subscriber_credit_array['bedehkar']          = 0;
                                                                                                $subscriber_credit_array['bestankar']         = floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_factor[0]['subscriber_id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'بدهکاری مشترک به نماینده در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                                //kasre asle mablaghe kol az moshtarak
                                                                                                $sql_credit_subscriber                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                                $res_credit_subscriber                        = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])));
                                                                                                $subscriber_credit_array['bedehkar']          = floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bestankar']         = 0;
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_factor[0]['subscriber_id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'کسر مالیات توسط سیستم در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                                //kasre credit - maliat+arzeshe afzoode az moshtarak
                                                                                                $sql_credit_subscriber                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                                $res_credit_subscriber                        = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bedehkar']          = (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bestankar']         = 0;
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_factor[0]['subscriber_id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'کسر مبلغ فاکتور توسط نماینده/شرکت در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                            }
                                                                                            Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                                                                                            die(Helper::Json_Message('pardakht_success'));
                                                                                        }
                                                                                    } else {
                                                                                        die(Helper::Json_Message('branch_cooperation_info_not_found'));
                                                                                    }
                                                                                } else {
                                                                                    die(Helper::Json_Message('branch_cooperation_info_not_found'));
                                                                                }
                                                                            } else {
                                                                                die(Helper::Json_Message('branch_credit_not_enough'));
                                                                            }
                                                                        } else {
                                                                            die(Helper::Json_Message('branch_credit_account_not_found'));
                                                                        }
                                                                    } else {
                                                                        die(Helper::Json_Message('user_info_not_right'));
                                                                    }

                                                                    break;
                                                                case __MODIRUSERTYPE__:
                                                                case __OPERATORUSERTYPE__:
                                                                    if ($_SESSION['branch_id'] === $res_subscriber[0]['branch_id']) {
                                                                        //sherkat pardakht mikonad
                                                                        $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                        $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                        if ($res_credit_branch) {
                                                                            if (abs(floatval($res_credit_branch[0]['credit'])) >= (abs(floatval($res_factor[0]['mablaghe_ghabele_pardakht'])) + (abs(floatval($res_factor[0]['mablaghe_ghabele_pardakht']) * __BRANCHESACCEPTABLEBALANCEFORPAY__)))) {
                                                                                //namayande credite kafi darad
                                                                                $sql_noe_hamkari = "SELECT * FROM bnm_branch_cooperation_type WHERE branch_id=? AND service_type=? ORDER BY id DESC LIMIT 1";
                                                                                $res_noe_hamkari = Db::secure_fetchall($sql_noe_hamkari, array($res_subscriber[0]['branch_id'], $res_factor[0]['noe_khadamat']));
                                                                                if ($res_noe_hamkari) {
                                                                                    //etelaate noe hamkarie namayande mojod ast
                                                                                    if (Helper::Is_Empty_OR_Null($res_noe_hamkari[0]['cooperation_type']) && Helper::Is_Empty_OR_Null($res_noe_hamkari[0]['service_type']) && Helper::Is_Empty_OR_Null($res_noe_hamkari[0]['foroshe_service_jadid']) && Helper::Is_Empty_OR_Null($res_noe_hamkari[0]['foroshe_service_sharje_mojadad']) && Helper::Is_Empty_OR_Null($res_noe_hamkari[0]['foroshe_service_jashnvare']) && Helper::Is_Empty_OR_Null($res_noe_hamkari[0]['hazine_sazmane_tanzim']) && Helper::Is_Empty_OR_Null($res_noe_hamkari[0]['hazine_servco']) && Helper::Is_Empty_OR_Null($res_noe_hamkari[0]['hazine_mansobe'])) {
                                                                                        if ($res_noe_hamkari[0]['cooperation_type'] === 1) {
                                                                                            //pardakht az namayande->darsadi
                                                                                            //all branch info exists so we can continue
                                                                                            //pardakhte az hesabe namayande kole mablaghe ghabele pardakht
                                                                                            $branch_credit_array                      = array();
                                                                                            $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) - (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])));
                                                                                            $branch_credit_array['bestankar']         = 0;
                                                                                            $branch_credit_array['bedehkar']          = floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (abs(floatval($res_factor[0]['maliate_arzeshe_afzode'])) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                            $branch_credit_array['noe_user']          = '2';
                                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                            $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                            $branch_credit_array['tozihat']           = 'پرداخت مبلغ فاکتور توسط نماینده/شرکت برای شماره : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                            $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                            $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                            //kasre maliat az hesabe namayande
                                                                                            $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                            $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                            $branch_credit_array                      = array();
                                                                                            $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                            $branch_credit_array['bestankar']         = 0;
                                                                                            $branch_credit_array['bedehkar']          = (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                            $branch_credit_array['noe_user']          = '2';
                                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                            $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                            $branch_credit_array['tozihat']           = 'کسر مالیات توسط سیستم برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                            $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                            $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                            $sql_credit_subscriber                    = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                            $res_credit_subscriber                    = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                            if ($res_credit_subscriber) {
                                                                                                // user has an account already
                                                                                                //add mablaghe kol to user credit
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) + floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                                $subscriber_credit_array['bedehkar']          = 0;
                                                                                                $subscriber_credit_array['bestankar']         = floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'بدهکاری مشترک به نماینده در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                                //kasre asle mablaghe kol az moshtarak
                                                                                                $sql_credit_subscriber                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                                $res_credit_subscriber                        = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])));
                                                                                                $subscriber_credit_array['bedehkar']          = floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bestankar']         = 0;
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'کسر اصل مبلغ فاکتور توسط سیستم در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                                //kasre credit - maliat+arzeshe afzoode az moshtarak
                                                                                                $sql_credit_subscriber                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                                $res_credit_subscriber                        = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bedehkar']          = (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bestankar']         = 0;
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'کسر مالیات و ارزش افزوده توسط نماینده/شرکت در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                            } else {
                                                                                                //create user account
                                                                                                //add mablaghe kol to user credit
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                                $subscriber_credit_array['bedehkar']          = 0;
                                                                                                $subscriber_credit_array['bestankar']         = floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_subscriber[0]['id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'بدهکاری مشترک به نماینده در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                                //kasre asle mablaghe kol az moshtarak
                                                                                                $sql_credit_subscriber                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                                $res_credit_subscriber                        = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])));
                                                                                                $subscriber_credit_array['bedehkar']          = floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bestankar']         = 0;
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_subscriber[0]['id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'کسر اصل مبلغ فاکتور توسط سیستم در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                                $sql_credit_subscriber                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id={$res_subscriber[0]['id']} AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                                $res_credit_subscriber                        = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                                //kasre credit - maliat+arzeshe afzoode az moshtarak
                                                                                                $sql_credit_subscriber                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                                $res_credit_subscriber                        = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bedehkar']          = (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bestankar']         = 0;
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_subscriber[0]['id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'کسر مالیات و ارزش افزوده توسط نماینده/شرکت در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                            }
                                                                                            $sql_factor_noe_kharid = "SELECT COUNT(*) AS rows_num FROM bnm_factor WHERE subscriber_id=? AND noe_khadamat=? AND tasvie_shode='1'";
                                                                                            $res_factor_noe_kharid = Db::secure_fetchall($sql_factor_noe_kharid, array($res_factor[0]['subscriber_id'], $res_factor[0]['noe_khadamat']));
                                                                                            $flag_noe_kharid       = "service_jadid";
                                                                                            if ($res_factor_noe_kharid) {
                                                                                                if ($res_factor_noe_kharid[0]['rows_num'] === 0) {
                                                                                                    $flag_noe_kharid = "service_jadid";
                                                                                                } else {
                                                                                                    $flag_noe_kharid = "sharje_mojadad";
                                                                                                }
                                                                                            } else {
                                                                                                $flag_noe_kharid = "service_jadid";
                                                                                            }
                                                                                            switch ($res_service[0]['noe_forosh']) {
                                                                                                case 'adi':
                                                                                                    $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                                    $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                                    if ($flag_noe_kharid == "sharje_mojadad") {
                                                                                                        //pardakhte porsante namayande baraye sharje mojadad zamani ke namayande hesabe bank darad
                                                                                                        $branch_credit_array                      = array();
                                                                                                        $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) + (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * ($res_noe_hamkari[0]['foroshe_service_sharje_mojadad'] / 100);
                                                                                                        $branch_credit_array['bestankar']         = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * ($res_noe_hamkari[0]['foroshe_service_sharje_mojadad'] / 100);
                                                                                                        $branch_credit_array['bedehkar']          = 0;
                                                                                                        $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                                        $branch_credit_array['noe_user']          = '2';
                                                                                                        $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                        $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                        $branch_credit_array['tozihat']           = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                                        $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                                        $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                                    } elseif ($flag_noe_kharid == "service_jadid") {
                                                                                                        //pardakhte porsante namayande baraye service jadid zamani ke namayande hesabe bank darad
                                                                                                        $branch_credit_array                      = array();
                                                                                                        $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) + (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * ($res_noe_hamkari[0]['foroshe_service_jadid'] / 100);
                                                                                                        $branch_credit_array['bestankar']         = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * ($res_noe_hamkari[0]['foroshe_service_jadid'] / 100);
                                                                                                        $branch_credit_array['bedehkar']          = 0;
                                                                                                        $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                                        $branch_credit_array['noe_user']          = '2';
                                                                                                        $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                        $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                        $branch_credit_array['tozihat']           = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                                        $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                                        $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                                    }
                                                                                                    Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                                                                                                    die(Helper::Json_Message('pardakht_success'));
                                                                                                    break;
                                                                                                case 'bulk':
                                                                                                    $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                                    $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                                    //pardakhte porsante namayande baraye bulk zamani ke namayande hesabe bank darad
                                                                                                    $branch_credit_array                      = array();
                                                                                                    $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) + (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * ($res_noe_hamkari[0]['foroshe_service_bulk'] / 100);
                                                                                                    $branch_credit_array['bestankar']         = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * ($res_noe_hamkari[0]['foroshe_service_bulk'] / 100);
                                                                                                    $branch_credit_array['bedehkar']          = 0;
                                                                                                    $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                                    $branch_credit_array['noe_user']          = '2';
                                                                                                    $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                    $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                    $branch_credit_array['tozihat']           = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                                    $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                                    $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                                    Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                                                                                                    die(Helper::Json_Message('pardakht_success'));
                                                                                                    break;
                                                                                                case 'jashnvare':
                                                                                                    $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                                    $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                                    //pardakhte porsante namayande baraye jashnvare zamani ke namayande hesabe bank darad
                                                                                                    $branch_credit_array                      = array();
                                                                                                    $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) + (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * ($res_noe_hamkari[0]['foroshe_service_jashnvare'] / 100);
                                                                                                    $branch_credit_array['bestankar']         = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * ($res_noe_hamkari[0]['foroshe_service_jashnvare'] / 100);
                                                                                                    $branch_credit_array['bedehkar']          = 0;
                                                                                                    $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                                    $branch_credit_array['noe_user']          = '2';
                                                                                                    $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                    $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                    $branch_credit_array['tozihat']           = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                                    $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                                    $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                                    Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                                                                                                    die(Helper::Json_Message('pardakht_success'));
                                                                                                    break;
                                                                                                default:
                                                                                                    die(Helper::Json_Message('service_info_not_right'));
                                                                                                    break;
                                                                                            }
                                                                                        } elseif ($res_noe_hamkari[0]['cooperation_type'] === 2) {
                                                                                            //pardakht az namayande->license
                                                                                            $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                            $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                            //pardakhte porsante(lisence) namayande zamani ke namayande hesabe bank darad
                                                                                            //insert credit ghabli
                                                                                            $branch_credit_array                      = array();
                                                                                            $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']);
                                                                                            $branch_credit_array['bestankar']         = 0;
                                                                                            $branch_credit_array['bedehkar']          = 0;
                                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                            $branch_credit_array['noe_user']          = '2';
                                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                            $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                            $branch_credit_array['tozihat']           = 'پرداخت مبلغ فاکتور برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                            $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                            $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                            //insert credit - maliat /update tozihat
                                                                                            $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                            $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                            $branch_credit_array                      = array();
                                                                                            $branch_credit_array['credit']            = abs(floatval($res_credit_branch[0]['credit'])) - (abs(floatval($res_factor[0]['maliate_arzeshe_afzode'])) + abs(floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))); //-maliat
                                                                                            $branch_credit_array['bestankar']         = 0;
                                                                                            $branch_credit_array['bedehkar']          = (abs(floatval($res_factor[0]['maliate_arzeshe_afzode'])) + abs(floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))); //-maliat
                                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                            $branch_credit_array['noe_user']          = '2';
                                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                            $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                            $branch_credit_array['tozihat']           = 'کسر مالیات برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                            $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                            $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                            //insert credit - darsade hazine_sazmane_tanzim /update tozihat
                                                                                            $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                            $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                            $branch_credit_array                      = array();
                                                                                            $branch_credit_array['credit']            = abs(floatval($res_credit_branch[0]['credit'])) - ((abs(floatval($res_factor[0]['mablaghe_ghabele_pardakht'])) - (abs(floatval($res_factor[0]['maliate_arzeshe_afzode'])) + abs(floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])))) * floatval($res_noe_hamkari[0]['hazine_sazmane_tanzim']) / 100); //-hazine_sazmane_tanzim
                                                                                            $branch_credit_array['bestankar']         = 0;
                                                                                            $branch_credit_array['bedehkar']          = (abs(floatval($res_factor[0]['mablaghe_ghabele_pardakht'])) - (abs(floatval($res_factor[0]['maliate_arzeshe_afzode'])) + abs(floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])))) * floatval($res_noe_hamkari[0]['hazine_sazmane_tanzim']) / 100;
                                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                            $branch_credit_array['noe_user']          = '2';
                                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                            $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                            $branch_credit_array['tozihat']           = 'کسر هزینه سازمان تنظیم برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                            $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                            $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                            //insert credit - darsade hazine_servco /update tozihat
                                                                                            $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                            $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                            $branch_credit_array                      = array();
                                                                                            $branch_credit_array['credit']            = abs(floatval($res_credit_branch[0]['credit'])) - ((abs(floatval($res_factor[0]['mablaghe_ghabele_pardakht'])) - (abs(floatval($res_factor[0]['maliate_arzeshe_afzode'])) + abs(floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])))) * floatval($res_noe_hamkari[0]['hazine_servco']) / 100); //-hazine_servco
                                                                                            $branch_credit_array['bestankar']         = 0;
                                                                                            $branch_credit_array['bedehkar']          = (abs(floatval($res_factor[0]['mablaghe_ghabele_pardakht'])) - (abs(floatval($res_factor[0]['maliate_arzeshe_afzode'])) + abs(floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])))) * floatval($res_noe_hamkari[0]['hazine_servco']) / 100; //-hazine_servco
                                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                            $branch_credit_array['noe_user']          = '2';
                                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                            $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                            $branch_credit_array['tozihat']           = 'کسر هزینه سروکو برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                            $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                            $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                            //insert credit - darsade hazine_mansobe /update tozihat
                                                                                            $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                            $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                            $branch_credit_array                      = array();
                                                                                            $branch_credit_array['credit']            = abs(floatval($res_credit_branch[0]['credit'])) - floatval($res_noe_hamkari[0]['hazine_mansobe']); //-hazine_mansobe
                                                                                            $branch_credit_array['bestankar']         = 0;
                                                                                            $branch_credit_array['bedehkar']          = floatval($res_noe_hamkari[0]['hazine_mansobe']);
                                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                            $branch_credit_array['noe_user']          = '2';
                                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                            $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                            $branch_credit_array['tozihat']           = 'کسر هزینه منصوبه برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                            $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                            $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                            ////////////////////////////subscriber credit //////////////////////////////////////////
                                                                                            $sql_credit_subscriber = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                            $res_credit_subscriber = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                            if ($res_credit_subscriber) {
                                                                                                // user has an account already
                                                                                                //add mablaghe kol to user credit
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) + floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                                $subscriber_credit_array['bedehkar']          = 0;
                                                                                                $subscriber_credit_array['bestankar']         = floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'بدهکاری مشترک به نماینده در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                                //kasre asle mablaghe kol az moshtarak
                                                                                                $sql_credit_subscriber                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                                $res_credit_subscriber                        = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])));
                                                                                                $subscriber_credit_array['bedehkar']          = floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bestankar']         = 0;
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'کسر مالیات توسط سیستم در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                                //kasre credit - maliat+arzeshe afzoode az moshtarak
                                                                                                $sql_credit_subscriber                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                                $res_credit_subscriber                        = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bedehkar']          = (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bestankar']         = 0;
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'کسر مبلغ فاکتور توسط نماینده/شرکت در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                            } else {
                                                                                                //create user account
                                                                                                //add mablaghe kol to user credit
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                                $subscriber_credit_array['bedehkar']          = 0;
                                                                                                $subscriber_credit_array['bestankar']         = floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_factor[0]['subscriber_id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'بدهکاری مشترک به نماینده در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                                //kasre asle mablaghe kol az moshtarak
                                                                                                $sql_credit_subscriber                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                                $res_credit_subscriber                        = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])));
                                                                                                $subscriber_credit_array['bedehkar']          = floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bestankar']         = 0;
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_factor[0]['subscriber_id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'کسر مالیات توسط سیستم در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                                //kasre credit - maliat+arzeshe afzoode az moshtarak
                                                                                                $sql_credit_subscriber                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                                $res_credit_subscriber                        = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bedehkar']          = (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bestankar']         = 0;
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_factor[0]['subscriber_id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'کسر مبلغ فاکتور توسط نماینده/شرکت در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                            }
                                                                                            Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                                                                                            die(Helper::Json_Message('pardakht_success'));
                                                                                        }
                                                                                    } else {
                                                                                        die(Helper::Json_Message('branch_cooperation_info_not_found'));
                                                                                    }
                                                                                } else {
                                                                                    die(Helper::Json_Message('branch_cooperation_info_not_found'));
                                                                                }
                                                                            } else {
                                                                                die(Helper::Json_Message('branch_credit_not_enough'));
                                                                            }
                                                                        } else {
                                                                            die(Helper::Json_Message('branch_credit_account_not_found'));
                                                                        }
                                                                    } else {
                                                                        die(Helper::Json_Message('auth_fail'));
                                                                    }
                                                                    break;
                                                                default:
                                                                    die(Helper::Json_Message('auth_fail'));
                                                                    break;
                                                            }
                                                        } else {
                                                            die(Helper::Json_Message('auth_fail'));
                                                        }
                                                    } else {
                                                        die(Helper::json_Message('branch_not_found'));
                                                    }
                                                } else {
                                                    die(Helper::Json_Message('subscriber_not_found'));
                                                }
                                            } else {
                                                die(Helper::Json_Message('service_info_not_right'));
                                            }
                                        } else {
                                            die(Helper::Json_Message('service_not_found'));
                                        }

                                        break;
                                    case "pardakht_dasti":
                                        die(Helper::Json_Message('info_not_true'));
                                        break;

                                    default:
                                        die(Helper::Json_Message('info_not_true'));
                                        break;
                                }
                            } else {
                                die(Helper::Json_Message('factor_not_found'));
                            }
                        } else {
                            die(Helper::Json_Message('required_info_not_found'));
                        }
                        break;
                    case __MODIR2USERTYPE__:
                    case __OPERATOR2USERTYPE__:
                        if (Helper::Is_Empty_OR_Null($_POST['factor_id'])) {
                            $sql_factor = "SELECT * FROM bnm_factor WHERE id=? AND DATE(tarikhe_factor)=CURDATE() AND tasvie_shode<>'1'";
                            $res_factor = Db::secure_fetchall($sql_factor, array($_POST['factor_id']));
                            if ($res_factor) {
                                switch ($_POST['noe_pardakht']) {
                                    case "pardakht_az_subscriber":
                                        $sql_service = "SELECT * FROM bnm_services WHERE id=?";
                                        $res_service = Db::secure_fetchall($sql_service, array($res_factor[0]['service_id']));
                                        if ($res_service) {
                                            if (Helper::Is_Empty_OR_Null($res_service[0]['noe_forosh'])) {
                                                $sql_subscriber = "SELECT id,name,f_name,branch_id FROM bnm_subscribers WHERE id=? AND branch_id=?";
                                                $res_subscriber = Db::secure_fetchall($sql_subscriber, array($res_factor[0]['subscriber_id'], $_SESSION['branch_id']));
                                                if ($res_subscriber) {
                                                    if ($res_subscriber[0]['branch_id'] !== 0) {
                                                        //user braraye namayande ast
                                                        $sql_credit_subscriber = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                        $res_credit_subscriber = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                        if ($res_credit_subscriber) {
                                                            //moshtarak hesabe bank darad
                                                            if (abs(floatval($res_credit_subscriber[0]['credit'])) >= (abs(floatval($res_factor[0]['mablaghe_ghabele_pardakht'])) + (abs(floatval($res_factor[0]['mablaghe_ghabele_pardakht']) * __BRANCHESACCEPTABLEBALANCEFORPAY__)))) {
                                                                $sql_noe_hamkari = "SELECT * FROM bnm_branch_cooperation_type WHERE branch_id=? AND service_type=? ORDER BY id DESC LIMIT 1";
                                                                $res_noe_hamkari = Db::secure_fetchall($sql_noe_hamkari, array($res_subscriber[0]['branch_id'], $res_factor[0]['noe_khadamat']));
                                                                if ($res_noe_hamkari) {
                                                                    //kasre mablaghe factor az moshtarak
                                                                    $subscriber_credit_array                      = array();
                                                                    $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])));
                                                                    $subscriber_credit_array['bedehkar']          = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])));
                                                                    $subscriber_credit_array['bestankar']         = 0;
                                                                    $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                                    $subscriber_credit_array['noe_user']          = '1';
                                                                    $subscriber_credit_array['tozihat']           = 'فاکتور شما توسط نماینده/سروکو در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'] . 'پرداخت شد.';
                                                                    $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                    $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                    $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                    $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                    if ($result) {
                                                                        $sql_credit_subscriber = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                        $res_credit_subscriber = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                        //kasre mablaghe maliat va arzeshe afzode az moshtarak
                                                                        $subscriber_credit_array                      = array();
                                                                        $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                        $subscriber_credit_array['bedehkar']          = (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                        $subscriber_credit_array['bestankar']         = 0;
                                                                        $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                                        $subscriber_credit_array['noe_user']          = '1';
                                                                        $subscriber_credit_array['tozihat']           = 'کسر مالیات و ارزش افزوده توسط سیستم در تاریخ: ' . Helper::Today_Shamsi_Date('-');
                                                                        $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                        $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                        $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                        $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                        //get noe_hamkari info for this factor
                                                                        //mohasebe soode namayande az in forosh
                                                                        if ($res_noe_hamkari[0]['cooperation_type'] === 1) {
                                                                            //namayande->darsadi
                                                                            $flag_noe_kharid       = "service_jadid";
                                                                            $sql_factor_noe_kharid = "SELECT COUNT(*) AS rows_num FROM bnm_factor WHERE subscriber_id=? AND noe_khadamat=? AND tasvie_shode='1'";
                                                                            $res_factor_noe_kharid = Db::secure_fetchall($sql_factor_noe_kharid, array($res_factor[0]['subscriber_id'], $res_factor[0]['noe_khadamat']));

                                                                            if ($res_factor_noe_kharid) {
                                                                                if ($res_factor_noe_kharid[0]['rows_num'] === 0) {
                                                                                    $flag_noe_kharid = "service_jadid";
                                                                                } else {
                                                                                    $flag_noe_kharid = "sharje_mojadad";
                                                                                }
                                                                            } else {
                                                                                $flag_noe_kharid = "service_jadid";
                                                                            }
                                                                            $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                            $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                            switch ($res_service[0]['noe_forosh']) {
                                                                                case 'adi':
                                                                                    if ($flag_noe_kharid == "sharje_mojadad") {
                                                                                        if ($res_credit_branch) {
                                                                                            //pardakhte porsante namayande baraye sharje mojadad zamani ke namayande hesabe bank darad
                                                                                            $branch_credit_array                      = array();
                                                                                            $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) + (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_sharje_mojadad']) / 100);
                                                                                            $branch_credit_array['bestankar']         = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_sharje_mojadad']) / 100);
                                                                                            $branch_credit_array['bedehkar']          = 0;
                                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                            $branch_credit_array['noe_user']          = '2';
                                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                            $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                            $branch_credit_array['tozihat']           = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                            $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                            $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                        } else {
                                                                                            //pardakhte porsante namayande baraye sharje mojadad zamani ke namayande hesabe bank nadarad
                                                                                            $branch_credit_array                      = array();
                                                                                            $branch_credit_array['credit']            = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_sharje_mojadad']) / 100);
                                                                                            $branch_credit_array['bestankar']         = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_sharje_mojadad']) / 100);
                                                                                            $branch_credit_array['bedehkar']          = 0;
                                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                            $branch_credit_array['noe_user']          = '2';
                                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                            $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                            $branch_credit_array['tozihat']           = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                            $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                            $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                        }
                                                                                    } elseif ($flag_noe_kharid == "service_jadid") {

                                                                                        if ($res_credit_branch) {
                                                                                            //pardakhte porsante namayande baraye service jadid zamani ke namayande hesabe bank darad
                                                                                            $branch_credit_array                      = array();
                                                                                            $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) + (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_jadid']) / 100);
                                                                                            $branch_credit_array['bestankar']         = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_jadid']) / 100);
                                                                                            $branch_credit_array['bedehkar']          = 0;
                                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                            $branch_credit_array['noe_user']          = '2';
                                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                            $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                            $branch_credit_array['tozihat']           = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                            $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                            $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                        } else {
                                                                                            //pardakhte porsante namayande baraye service jadid zamani ke namayande hesabe bank nadarad
                                                                                            $branch_credit_array                      = array();
                                                                                            $branch_credit_array['credit']            = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_jadid']) / 100);
                                                                                            $branch_credit_array['bestankar']         = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_jadid']) / 100);
                                                                                            $branch_credit_array['bedehkar']          = 0;
                                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                            $branch_credit_array['noe_user']          = '2';
                                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                            $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                            $branch_credit_array['tozihat']           = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                            $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                            $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                        }
                                                                                    }
                                                                                    Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                                                                                    die(Helper::Json_Message('pardakht_success'));
                                                                                    break;
                                                                                case 'bulk':
                                                                                    if ($res_credit_branch) {
                                                                                        //pardakhte porsante namayande baraye bulk zamani ke namayande hesabe bank darad
                                                                                        $branch_credit_array                      = array();
                                                                                        $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) + ((floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_bulk']) / 100));
                                                                                        $branch_credit_array['bestankar']         = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_bulk']) / 100);
                                                                                        $branch_credit_array['bedehkar']          = 0;
                                                                                        $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                        $branch_credit_array['noe_user']          = '2';
                                                                                        $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                        $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                        $branch_credit_array['tozihat']           = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                        $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                        $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                    } else {
                                                                                        //pardakhte porsante namayande baraye bulk zamani ke namayande hesabe bank nadarad
                                                                                        $branch_credit_array                      = array();
                                                                                        $branch_credit_array['credit']            = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_bulk']) / 100);
                                                                                        $branch_credit_array['bestankar']         = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_bulk']) / 100);
                                                                                        $branch_credit_array['bedehkar']          = 0;
                                                                                        $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                        $branch_credit_array['noe_user']          = '2';
                                                                                        $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                        $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                        $branch_credit_array['tozihat']           = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                        $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                        $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                    }
                                                                                    Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                                                                                    die(Helper::Json_Message('pardakht_success'));
                                                                                    break;
                                                                                case 'jashnvare':
                                                                                    if ($res_credit_branch) {
                                                                                        //pardakhte porsante namayande baraye jashnvare zamani ke namayande hesabe bank darad
                                                                                        $branch_credit_array                      = array();
                                                                                        $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) + ((floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_jashnvare']) / 100));
                                                                                        $branch_credit_array['bestankar']         = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_jashnvare']) / 100);
                                                                                        $branch_credit_array['bedehkar']          = 0;
                                                                                        $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                        $branch_credit_array['noe_user']          = '2';
                                                                                        $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                        $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                        $branch_credit_array['tozihat']           = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                        $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                        $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                    } else {
                                                                                        //pardakhte porsante namayande baraye jashnvare zamani ke namayande hesabe bank nadarad
                                                                                        $branch_credit_array                      = array();
                                                                                        $branch_credit_array['credit']            = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_jashnvare']) / 100);
                                                                                        $branch_credit_array['bestankar']         = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_jashnvare']) / 100);
                                                                                        $branch_credit_array['bedehkar']          = 0;
                                                                                        $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                        $branch_credit_array['noe_user']          = '2';
                                                                                        $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                        $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                        $branch_credit_array['tozihat']           = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                        $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                        $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                    }
                                                                                    Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                                                                                    die(Helper::Json_Message('pardakht_success'));
                                                                                    break;

                                                                                default:
                                                                                    die(Helper::Json_Message('service_info_not_right'));
                                                                                    break;
                                                                            }
                                                                        } elseif ($res_noe_hamkari[0]['cooperation_type'] === 2) {
                                                                            // license
                                                                            $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                            $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                            if ($res_credit_branch) {
                                                                                //pardakhte porsante(lisence) namayande zamani ke namayande hesabe bank darad
                                                                                //insert credit + mablaghe_ghabele_pardakht
                                                                                $branch_credit_array                      = array();
                                                                                $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) + floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                $branch_credit_array['bestankar']         = floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                $branch_credit_array['bedehkar']          = 0;
                                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                $branch_credit_array['noe_user']          = '2';
                                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                $branch_credit_array['tozihat']           = 'پرداخت مبلغ فاکتور برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                //insert credit - maliat /update tozihat
                                                                                $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                $branch_credit_array                      = array();
                                                                                $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])); //-maliat
                                                                                $branch_credit_array['bestankar']         = 0;
                                                                                $branch_credit_array['bedehkar']          = (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])); //-maliat
                                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                $branch_credit_array['noe_user']          = '2';
                                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                $branch_credit_array['tozihat']           = 'کسر مالیات برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                //insert credit - darsade hazine_sazmane_tanzim /update tozihat
                                                                                $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                $branch_credit_array                      = array();
                                                                                $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) - ((floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['hazine_sazmane_tanzim']) / 100));
                                                                                $branch_credit_array['bestankar']         = 0;
                                                                                $branch_credit_array['bedehkar']          = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['hazine_sazmane_tanzim']) / 100);
                                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                $branch_credit_array['noe_user']          = '2';
                                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                $branch_credit_array['tozihat']           = 'کسر هزینه سازمان تنظیم برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                //insert credit - darsade hazine_servco /update tozihat
                                                                                $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                $branch_credit_array                      = array();
                                                                                $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) - ((floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['hazine_servco']) / 100));
                                                                                $branch_credit_array['bestankar']         = 0;
                                                                                $branch_credit_array['bedehkar']          = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['hazine_servco']) / 100);
                                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                $branch_credit_array['noe_user']          = '2';
                                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                $branch_credit_array['tozihat']           = 'کسر هزینه سروکو برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                //insert credit - darsade hazine_mansobe /update tozihat
                                                                                $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                $branch_credit_array                      = array();
                                                                                $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) - floatval($res_noe_hamkari[0]['hazine_mansobe']);
                                                                                $branch_credit_array['bestankar']         = 0;
                                                                                $branch_credit_array['bedehkar']          = floatval($res_noe_hamkari[0]['hazine_mansobe']);
                                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                $branch_credit_array['noe_user']          = '2';
                                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                $branch_credit_array['tozihat']           = 'کسر هزینه منصوبه برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                                                                                die(Helper::Json_Message('pardakht_success'));
                                                                            } else {
                                                                                //pardakhte porsante(lisence) namayande zamani ke namayande hesabe bank nadarad
                                                                                //NO credit Account
                                                                                //insert credit + mablaghe_ghabele_pardakht
                                                                                $branch_credit_array                      = array();
                                                                                $branch_credit_array['credit']            = floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                $branch_credit_array['bestankar']         = floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                $branch_credit_array['bedehkar']          = 0;
                                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                $branch_credit_array['noe_user']          = '2';
                                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                $branch_credit_array['tozihat']           = 'پرداخت مبلغ فاکتور برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                //insert credit - maliat /update tozihat
                                                                                $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                $branch_credit_array                      = array();
                                                                                $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])); //-maliat
                                                                                $branch_credit_array['bestankar']         = 0;
                                                                                $branch_credit_array['bedehkar']          = (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])); //-maliat
                                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                $branch_credit_array['noe_user']          = '2';
                                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                $branch_credit_array['tozihat']           = 'کسر مالیات برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                //insert credit - darsade hazine_sazmane_tanzim /update tozihat
                                                                                $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                $branch_credit_array                      = array();
                                                                                $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) - ((floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['hazine_sazmane_tanzim']) / 100));
                                                                                $branch_credit_array['bestankar']         = 0;
                                                                                $branch_credit_array['bedehkar']          = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['hazine_sazmane_tanzim']) / 100);
                                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                $branch_credit_array['noe_user']          = '2';
                                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                $branch_credit_array['tozihat']           = 'کسر هزینه سازمان تنظیم برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                //insert credit - darsade hazine_servco /update tozihat
                                                                                $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                $branch_credit_array                      = array();
                                                                                $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) - ((floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['hazine_servco']) / 100));
                                                                                $branch_credit_array['bestankar']         = 0;
                                                                                $branch_credit_array['bedehkar']          = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['hazine_servco']) / 100);
                                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                $branch_credit_array['noe_user']          = '2';
                                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                $branch_credit_array['tozihat']           = 'کسر هزینه سروکو برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                //insert credit - darsade hazine_mansobe /update tozihat
                                                                                $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                $branch_credit_array                      = array();
                                                                                $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) - floatval($res_noe_hamkari[0]['hazine_mansobe']);
                                                                                $branch_credit_array['bestankar']         = 0;
                                                                                $branch_credit_array['bedehkar']          = floatval($res_noe_hamkari[0]['hazine_mansobe']);
                                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                $branch_credit_array['noe_user']          = '2';
                                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                $branch_credit_array['tozihat']           = 'کسر هزینه منصوبه برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                                                                                die(Helper::Json_Message('pardakht_success'));
                                                                            }
                                                                        } else {
                                                                            die(Helper::Json_Message('credit_operation_fail'));
                                                                        }
                                                                    } else {
                                                                        die(Helper::Json_Message('credit_operation_fail'));
                                                                    }
                                                                } else {
                                                                    die(Helper::Json_Message('credit_operation_fail'));
                                                                }
                                                            } else {
                                                                die(Helper::Json_Message('subscriber_credit_not_enough'));
                                                            }
                                                        } else {
                                                            die(Helper::Json_Message('subscriber_credit_info_not_found'));
                                                        }
                                                    } elseif ($res_subscriber[0]['branch_id'] === 0) {
                                                        //todo... user baraye sahar ast
                                                        die(Helper::Json_Message('auth_fail'));
                                                    } else {
                                                        die(Helper::Json_Message('subscriber_info_not_right'));
                                                    }
                                                } else {
                                                    die(Helper::Json_Message('subscriber_not_found'));
                                                }
                                            } else {
                                                die(Helper::Json_Message('service_info_not_right'));
                                            }
                                        } else {
                                            die(Helper::Json_Message('service_not_found'));
                                        }
                                        break;

                                    case "pardakht_az_namayande":
                                        $sql_service = "SELECT * FROM bnm_services WHERE id=?";
                                        $res_service = Db::secure_fetchall($sql_service, array($res_factor[0]['service_id']));
                                        if ($res_service) {
                                            if (Helper::Is_Empty_OR_Null($res_service[0]['noe_forosh'])) {
                                                $sql_subscriber = "SELECT id,name,f_name,branch_id FROM bnm_subscribers WHERE id=? AND branch_id=?";
                                                $res_subscriber = Db::secure_fetchall($sql_subscriber, array($res_factor[0]['subscriber_id'], $_SESSION['branch_id']));
                                                if ($res_subscriber) {
                                                    $sql_branch = "SELECT id,name_sherkat FROM bnm_branch WHERE id =?";
                                                    $res_branch = Db::secure_fetchall($sql_branch, array($_SESSION['branch_id']));
                                                    if ($res_branch) {
                                                        if ($res_subscriber[0]['branch_id'] !== 0) {
                                                            //moshtarak baraye namayande ast
                                                            switch ($_SESSION['user_type']) {
                                                                case __ADMINUSERTYPE__:
                                                                case __ADMINOPERATORUSERTYPE__:
                                                                    if ($res_branch[0]['id'] === $res_subscriber[0]['branch_id']) {
                                                                        //sherkat pardakht mikonad
                                                                        $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                        $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                        if ($res_credit_branch) {
                                                                            if (abs(floatval($res_credit_branch[0]['credit'])) >= (abs(floatval($res_factor[0]['mablaghe_ghabele_pardakht'])) + (abs(floatval($res_factor[0]['mablaghe_ghabele_pardakht']) * __BRANCHESACCEPTABLEBALANCEFORPAY__)))) {
                                                                                //namayande credite kafi darad
                                                                                $sql_noe_hamkari = "SELECT * FROM bnm_branch_cooperation_type WHERE branch_id=? AND service_type=? ORDER BY id DESC LIMIT 1";
                                                                                $res_noe_hamkari = Db::secure_fetchall($sql_noe_hamkari, array($res_subscriber[0]['branch_id'], $res_factor[0]['noe_khadamat']));
                                                                                if ($res_noe_hamkari) {
                                                                                    //etelaate noe hamkarie namayande mojod ast
                                                                                    if (Helper::Is_Empty_OR_Null($res_noe_hamkari[0]['cooperation_type']) && Helper::Is_Empty_OR_Null($res_noe_hamkari[0]['service_type']) && Helper::Is_Empty_OR_Null($res_noe_hamkari[0]['foroshe_service_jadid']) && Helper::Is_Empty_OR_Null($res_noe_hamkari[0]['foroshe_service_sharje_mojadad']) && Helper::Is_Empty_OR_Null($res_noe_hamkari[0]['foroshe_service_jashnvare']) && Helper::Is_Empty_OR_Null($res_noe_hamkari[0]['hazine_sazmane_tanzim']) && Helper::Is_Empty_OR_Null($res_noe_hamkari[0]['hazine_servco']) && Helper::Is_Empty_OR_Null($res_noe_hamkari[0]['hazine_mansobe'])) {
                                                                                        if ($res_noe_hamkari[0]['cooperation_type'] === 1) {
                                                                                            //pardakht az namayande->darsadi
                                                                                            //all branch info exists so we can continue
                                                                                            //pardakhte az hesabe namayande kole mablaghe ghabele pardakht
                                                                                            $branch_credit_array                      = array();
                                                                                            $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) - (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])));
                                                                                            $branch_credit_array['bestankar']         = 0;
                                                                                            $branch_credit_array['bedehkar']          = floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (abs(floatval($res_factor[0]['maliate_arzeshe_afzode'])) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                            $branch_credit_array['noe_user']          = '2';
                                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                            $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                            $branch_credit_array['tozihat']           = 'پرداخت مبلغ فاکتور توسط نماینده/شرکت برای شماره : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                            $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                            $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                            //kasre maliat az hesabe namayande
                                                                                            $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                            $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                            $branch_credit_array                      = array();
                                                                                            $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                            $branch_credit_array['bestankar']         = 0;
                                                                                            $branch_credit_array['bedehkar']          = (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                            $branch_credit_array['noe_user']          = '2';
                                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                            $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                            $branch_credit_array['tozihat']           = 'کسر مالیات توسط سیستم برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                            $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                            $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                            $sql_credit_subscriber                    = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                            $res_credit_subscriber                    = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                            if ($res_credit_subscriber) {
                                                                                                // user has an account already
                                                                                                //add mablaghe kol to user credit
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) + floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                                $subscriber_credit_array['bedehkar']          = 0;
                                                                                                $subscriber_credit_array['bestankar']         = floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'بدهکاری مشترک به نماینده در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                                //kasre asle mablaghe kol az moshtarak
                                                                                                $sql_credit_subscriber                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                                $res_credit_subscriber                        = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])));
                                                                                                $subscriber_credit_array['bedehkar']          = floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bestankar']         = 0;
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'کسر اصل مبلغ فاکتور توسط سیستم در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                                //kasre credit - maliat+arzeshe afzoode az moshtarak
                                                                                                $sql_credit_subscriber                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                                $res_credit_subscriber                        = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bedehkar']          = (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bestankar']         = 0;
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'کسر مالیات و ارزش افزوده توسط نماینده/شرکت در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                            } else {
                                                                                                //create user account
                                                                                                //add mablaghe kol to user credit
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                                $subscriber_credit_array['bedehkar']          = 0;
                                                                                                $subscriber_credit_array['bestankar']         = floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_subscriber[0]['id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'بدهکاری مشترک به نماینده در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                                //kasre asle mablaghe kol az moshtarak
                                                                                                $sql_credit_subscriber                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                                $res_credit_subscriber                        = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])));
                                                                                                $subscriber_credit_array['bedehkar']          = floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bestankar']         = 0;
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_subscriber[0]['id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'کسر اصل مبلغ فاکتور توسط سیستم در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                                $sql_credit_subscriber                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id={$res_subscriber[0]['id']} AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                                $res_credit_subscriber                        = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                                //kasre credit - maliat+arzeshe afzoode az moshtarak
                                                                                                $sql_credit_subscriber                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                                $res_credit_subscriber                        = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bedehkar']          = (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bestankar']         = 0;
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_subscriber[0]['id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'کسر مالیات و ارزش افزوده توسط نماینده/شرکت در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                            }
                                                                                            $sql_factor_noe_kharid = "SELECT COUNT(*) AS rows_num FROM bnm_factor WHERE subscriber_id=? AND noe_khadamat=? AND tasvie_shode='1'";
                                                                                            $res_factor_noe_kharid = Db::secure_fetchall($sql_factor_noe_kharid, array($res_factor[0]['subscriber_id'], $res_factor[0]['noe_khadamat']));
                                                                                            $flag_noe_kharid       = "service_jadid";
                                                                                            if ($res_factor_noe_kharid) {
                                                                                                if ($res_factor_noe_kharid[0]['rows_num'] === 0) {
                                                                                                    $flag_noe_kharid = "service_jadid";
                                                                                                } else {
                                                                                                    $flag_noe_kharid = "sharje_mojadad";
                                                                                                }
                                                                                            } else {
                                                                                                $flag_noe_kharid = "service_jadid";
                                                                                            }
                                                                                            switch ($res_service[0]['noe_forosh']) {
                                                                                                case 'adi':
                                                                                                    $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                                    $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                                    if ($flag_noe_kharid == "sharje_mojadad") {
                                                                                                        //pardakhte porsante namayande baraye sharje mojadad zamani ke namayande hesabe bank darad
                                                                                                        $branch_credit_array                      = array();
                                                                                                        $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) + (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * ($res_noe_hamkari[0]['foroshe_service_sharje_mojadad'] / 100);
                                                                                                        $branch_credit_array['bestankar']         = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * ($res_noe_hamkari[0]['foroshe_service_sharje_mojadad'] / 100);
                                                                                                        $branch_credit_array['bedehkar']          = 0;
                                                                                                        $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                                        $branch_credit_array['noe_user']          = '2';
                                                                                                        $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                        $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                        $branch_credit_array['tozihat']           = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                                        $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                                        $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                                    } elseif ($flag_noe_kharid == "service_jadid") {
                                                                                                        //pardakhte porsante namayande baraye service jadid zamani ke namayande hesabe bank darad
                                                                                                        $branch_credit_array                      = array();
                                                                                                        $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) + (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * ($res_noe_hamkari[0]['foroshe_service_jadid'] / 100);
                                                                                                        $branch_credit_array['bestankar']         = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * ($res_noe_hamkari[0]['foroshe_service_jadid'] / 100);
                                                                                                        $branch_credit_array['bedehkar']          = 0;
                                                                                                        $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                                        $branch_credit_array['noe_user']          = '2';
                                                                                                        $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                        $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                        $branch_credit_array['tozihat']           = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                                        $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                                        $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                                    }
                                                                                                    Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                                                                                                    die(Helper::Json_Message('pardakht_success'));
                                                                                                    break;
                                                                                                case 'bulk':
                                                                                                    $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                                    $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                                    //pardakhte porsante namayande baraye bulk zamani ke namayande hesabe bank darad
                                                                                                    $branch_credit_array                      = array();
                                                                                                    $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) + (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * ($res_noe_hamkari[0]['foroshe_service_bulk'] / 100);
                                                                                                    $branch_credit_array['bestankar']         = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * ($res_noe_hamkari[0]['foroshe_service_bulk'] / 100);
                                                                                                    $branch_credit_array['bedehkar']          = 0;
                                                                                                    $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                                    $branch_credit_array['noe_user']          = '2';
                                                                                                    $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                    $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                    $branch_credit_array['tozihat']           = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                                    $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                                    $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                                    Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                                                                                                    die(Helper::Json_Message('pardakht_success'));
                                                                                                    break;
                                                                                                case 'jashnvare':
                                                                                                    $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                                    $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                                    //pardakhte porsante namayande baraye jashnvare zamani ke namayande hesabe bank darad
                                                                                                    $branch_credit_array                      = array();
                                                                                                    $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) + (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * ($res_noe_hamkari[0]['foroshe_service_jashnvare'] / 100);
                                                                                                    $branch_credit_array['bestankar']         = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * ($res_noe_hamkari[0]['foroshe_service_jashnvare'] / 100);
                                                                                                    $branch_credit_array['bedehkar']          = 0;
                                                                                                    $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                                    $branch_credit_array['noe_user']          = '2';
                                                                                                    $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                    $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                    $branch_credit_array['tozihat']           = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                                    $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                                    $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                                    Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                                                                                                    die(Helper::Json_Message('pardakht_success'));
                                                                                                    break;
                                                                                                default:
                                                                                                    die(Helper::Json_Message('service_info_not_right'));
                                                                                                    break;
                                                                                            }
                                                                                        } elseif ($res_noe_hamkari[0]['cooperation_type'] === 2) {
                                                                                            //pardakht az namayande->license
                                                                                            $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                            $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                            //pardakhte porsante(lisence) namayande zamani ke namayande hesabe bank darad
                                                                                            //insert credit ghabli
                                                                                            $branch_credit_array                      = array();
                                                                                            $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']);
                                                                                            $branch_credit_array['bestankar']         = 0;
                                                                                            $branch_credit_array['bedehkar']          = 0;
                                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                            $branch_credit_array['noe_user']          = '2';
                                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                            $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                            $branch_credit_array['tozihat']           = 'پرداخت مبلغ فاکتور برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                            $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                            $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                            //insert credit - maliat /update tozihat
                                                                                            $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                            $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                            $branch_credit_array                      = array();
                                                                                            $branch_credit_array['credit']            = abs(floatval($res_credit_branch[0]['credit'])) - (abs(floatval($res_factor[0]['maliate_arzeshe_afzode'])) + abs(floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))); //-maliat
                                                                                            $branch_credit_array['bestankar']         = 0;
                                                                                            $branch_credit_array['bedehkar']          = (abs(floatval($res_factor[0]['maliate_arzeshe_afzode'])) + abs(floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))); //-maliat
                                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                            $branch_credit_array['noe_user']          = '2';
                                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                            $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                            $branch_credit_array['tozihat']           = 'کسر مالیات برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                            $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                            $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                            //insert credit - darsade hazine_sazmane_tanzim /update tozihat
                                                                                            $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                            $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                            $branch_credit_array                      = array();
                                                                                            $branch_credit_array['credit']            = abs(floatval($res_credit_branch[0]['credit'])) - ((abs(floatval($res_factor[0]['mablaghe_ghabele_pardakht'])) - (abs(floatval($res_factor[0]['maliate_arzeshe_afzode'])) + abs(floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])))) * floatval($res_noe_hamkari[0]['hazine_sazmane_tanzim']) / 100); //-hazine_sazmane_tanzim
                                                                                            $branch_credit_array['bestankar']         = 0;
                                                                                            $branch_credit_array['bedehkar']          = (abs(floatval($res_factor[0]['mablaghe_ghabele_pardakht'])) - (abs(floatval($res_factor[0]['maliate_arzeshe_afzode'])) + abs(floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])))) * floatval($res_noe_hamkari[0]['hazine_sazmane_tanzim']) / 100;
                                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                            $branch_credit_array['noe_user']          = '2';
                                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                            $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                            $branch_credit_array['tozihat']           = 'کسر هزینه سازمان تنظیم برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                            $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                            $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                            //insert credit - darsade hazine_servco /update tozihat
                                                                                            $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                            $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                            $branch_credit_array                      = array();
                                                                                            $branch_credit_array['credit']            = abs(floatval($res_credit_branch[0]['credit'])) - ((abs(floatval($res_factor[0]['mablaghe_ghabele_pardakht'])) - (abs(floatval($res_factor[0]['maliate_arzeshe_afzode'])) + abs(floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])))) * floatval($res_noe_hamkari[0]['hazine_servco']) / 100); //-hazine_servco
                                                                                            $branch_credit_array['bestankar']         = 0;
                                                                                            $branch_credit_array['bedehkar']          = (abs(floatval($res_factor[0]['mablaghe_ghabele_pardakht'])) - (abs(floatval($res_factor[0]['maliate_arzeshe_afzode'])) + abs(floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])))) * floatval($res_noe_hamkari[0]['hazine_servco']) / 100; //-hazine_servco
                                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                            $branch_credit_array['noe_user']          = '2';
                                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                            $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                            $branch_credit_array['tozihat']           = 'کسر هزینه سروکو برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                            $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                            $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                            //insert credit - darsade hazine_mansobe /update tozihat
                                                                                            $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                            $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                            $branch_credit_array                      = array();
                                                                                            $branch_credit_array['credit']            = abs(floatval($res_credit_branch[0]['credit'])) - floatval($res_noe_hamkari[0]['hazine_mansobe']); //-hazine_mansobe
                                                                                            $branch_credit_array['bestankar']         = 0;
                                                                                            $branch_credit_array['bedehkar']          = floatval($res_noe_hamkari[0]['hazine_mansobe']);
                                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                            $branch_credit_array['noe_user']          = '2';
                                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                            $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                            $branch_credit_array['tozihat']           = 'کسر هزینه منصوبه برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                            $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                            $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                            ////////////////////////////subscriber credit //////////////////////////////////////////
                                                                                            $sql_credit_subscriber = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                            $res_credit_subscriber = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                            if ($res_credit_subscriber) {
                                                                                                // user has an account already
                                                                                                //add mablaghe kol to user credit
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) + floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                                $subscriber_credit_array['bedehkar']          = 0;
                                                                                                $subscriber_credit_array['bestankar']         = floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'بدهکاری مشترک به نماینده در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                                //kasre asle mablaghe kol az moshtarak
                                                                                                $sql_credit_subscriber                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                                $res_credit_subscriber                        = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])));
                                                                                                $subscriber_credit_array['bedehkar']          = floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bestankar']         = 0;
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'کسر مالیات توسط سیستم در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                                //kasre credit - maliat+arzeshe afzoode az moshtarak
                                                                                                $sql_credit_subscriber                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                                $res_credit_subscriber                        = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bedehkar']          = (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bestankar']         = 0;
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'کسر مبلغ فاکتور توسط نماینده/شرکت در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                            } else {
                                                                                                //create user account
                                                                                                //add mablaghe kol to user credit
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                                $subscriber_credit_array['bedehkar']          = 0;
                                                                                                $subscriber_credit_array['bestankar']         = floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_factor[0]['subscriber_id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'بدهکاری مشترک به نماینده در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                                //kasre asle mablaghe kol az moshtarak
                                                                                                $sql_credit_subscriber                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                                $res_credit_subscriber                        = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])));
                                                                                                $subscriber_credit_array['bedehkar']          = floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bestankar']         = 0;
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_factor[0]['subscriber_id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'کسر مالیات توسط سیستم در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                                //kasre credit - maliat+arzeshe afzoode az moshtarak
                                                                                                $sql_credit_subscriber                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                                $res_credit_subscriber                        = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bedehkar']          = (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bestankar']         = 0;
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_factor[0]['subscriber_id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'کسر مبلغ فاکتور توسط نماینده/شرکت در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                            }
                                                                                            Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                                                                                            die(Helper::Json_Message('pardakht_success'));
                                                                                        }
                                                                                    } else {
                                                                                        die(Helper::Json_Message('branch_cooperation_info_not_found'));
                                                                                    }
                                                                                } else {
                                                                                    die(Helper::Json_Message('branch_cooperation_info_not_found'));
                                                                                }
                                                                            } else {
                                                                                die(Helper::Json_Message('branch_credit_not_enough'));
                                                                            }
                                                                        } else {
                                                                            die(Helper::Json_Message('branch_credit_account_not_found'));
                                                                        }
                                                                    } else {
                                                                        die(Helper::Json_Message('user_info_not_right'));
                                                                    }

                                                                    break;
                                                                case __MODIRUSERTYPE__:
                                                                case __OPERATORUSERTYPE__:
                                                                    if ($_SESSION['branch_id'] === $res_subscriber[0]['branch_id']) {
                                                                        //sherkat pardakht mikonad
                                                                        $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                        $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                        if ($res_credit_branch) {
                                                                            if (abs(floatval($res_credit_branch[0]['credit'])) >= (abs(floatval($res_factor[0]['mablaghe_ghabele_pardakht'])) + (abs(floatval($res_factor[0]['mablaghe_ghabele_pardakht']) * __BRANCHESACCEPTABLEBALANCEFORPAY__)))) {
                                                                                //namayande credite kafi darad
                                                                                $sql_noe_hamkari = "SELECT * FROM bnm_branch_cooperation_type WHERE branch_id=? AND service_type=? ORDER BY id DESC LIMIT 1";
                                                                                $res_noe_hamkari = Db::secure_fetchall($sql_noe_hamkari, array($res_subscriber[0]['branch_id'], $res_factor[0]['noe_khadamat']));
                                                                                if ($res_noe_hamkari) {
                                                                                    //etelaate noe hamkarie namayande mojod ast
                                                                                    if (Helper::Is_Empty_OR_Null($res_noe_hamkari[0]['cooperation_type']) && Helper::Is_Empty_OR_Null($res_noe_hamkari[0]['service_type']) && Helper::Is_Empty_OR_Null($res_noe_hamkari[0]['foroshe_service_jadid']) && Helper::Is_Empty_OR_Null($res_noe_hamkari[0]['foroshe_service_sharje_mojadad']) && Helper::Is_Empty_OR_Null($res_noe_hamkari[0]['foroshe_service_jashnvare']) && Helper::Is_Empty_OR_Null($res_noe_hamkari[0]['hazine_sazmane_tanzim']) && Helper::Is_Empty_OR_Null($res_noe_hamkari[0]['hazine_servco']) && Helper::Is_Empty_OR_Null($res_noe_hamkari[0]['hazine_mansobe'])) {
                                                                                        if ($res_noe_hamkari[0]['cooperation_type'] === 1) {
                                                                                            //pardakht az namayande->darsadi
                                                                                            //all branch info exists so we can continue
                                                                                            //pardakhte az hesabe namayande kole mablaghe ghabele pardakht
                                                                                            $branch_credit_array                      = array();
                                                                                            $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) - (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])));
                                                                                            $branch_credit_array['bestankar']         = 0;
                                                                                            $branch_credit_array['bedehkar']          = floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (abs(floatval($res_factor[0]['maliate_arzeshe_afzode'])) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                            $branch_credit_array['noe_user']          = '2';
                                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                            $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                            $branch_credit_array['tozihat']           = 'پرداخت مبلغ فاکتور توسط نماینده/شرکت برای شماره : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                            $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                            $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                            //kasre maliat az hesabe namayande
                                                                                            $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                            $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                            $branch_credit_array                      = array();
                                                                                            $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                            $branch_credit_array['bestankar']         = 0;
                                                                                            $branch_credit_array['bedehkar']          = (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                            $branch_credit_array['noe_user']          = '2';
                                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                            $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                            $branch_credit_array['tozihat']           = 'کسر مالیات توسط سیستم برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                            $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                            $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                            $sql_credit_subscriber                    = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                            $res_credit_subscriber                    = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                            if ($res_credit_subscriber) {
                                                                                                // user has an account already
                                                                                                //add mablaghe kol to user credit
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) + floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                                $subscriber_credit_array['bedehkar']          = 0;
                                                                                                $subscriber_credit_array['bestankar']         = floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'بدهکاری مشترک به نماینده در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                                //kasre asle mablaghe kol az moshtarak
                                                                                                $sql_credit_subscriber                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                                $res_credit_subscriber                        = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])));
                                                                                                $subscriber_credit_array['bedehkar']          = floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bestankar']         = 0;
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'کسر اصل مبلغ فاکتور توسط سیستم در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                                //kasre credit - maliat+arzeshe afzoode az moshtarak
                                                                                                $sql_credit_subscriber                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                                $res_credit_subscriber                        = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bedehkar']          = (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bestankar']         = 0;
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'کسر مالیات و ارزش افزوده توسط نماینده/شرکت در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                            } else {
                                                                                                //create user account
                                                                                                //add mablaghe kol to user credit
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                                $subscriber_credit_array['bedehkar']          = 0;
                                                                                                $subscriber_credit_array['bestankar']         = floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_subscriber[0]['id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'بدهکاری مشترک به نماینده در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                                //kasre asle mablaghe kol az moshtarak
                                                                                                $sql_credit_subscriber                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                                $res_credit_subscriber                        = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])));
                                                                                                $subscriber_credit_array['bedehkar']          = floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bestankar']         = 0;
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_subscriber[0]['id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'کسر اصل مبلغ فاکتور توسط سیستم در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                                $sql_credit_subscriber                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id={$res_subscriber[0]['id']} AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                                $res_credit_subscriber                        = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                                //kasre credit - maliat+arzeshe afzoode az moshtarak
                                                                                                $sql_credit_subscriber                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                                $res_credit_subscriber                        = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bedehkar']          = (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bestankar']         = 0;
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_subscriber[0]['id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'کسر مالیات و ارزش افزوده توسط نماینده/شرکت در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                            }
                                                                                            $sql_factor_noe_kharid = "SELECT COUNT(*) AS rows_num FROM bnm_factor WHERE subscriber_id=? AND noe_khadamat=? AND tasvie_shode='1'";
                                                                                            $res_factor_noe_kharid = Db::secure_fetchall($sql_factor_noe_kharid, array($res_factor[0]['subscriber_id'], $res_factor[0]['noe_khadamat']));
                                                                                            $flag_noe_kharid       = "service_jadid";
                                                                                            if ($res_factor_noe_kharid) {
                                                                                                if ($res_factor_noe_kharid[0]['rows_num'] === 0) {
                                                                                                    $flag_noe_kharid = "service_jadid";
                                                                                                } else {
                                                                                                    $flag_noe_kharid = "sharje_mojadad";
                                                                                                }
                                                                                            } else {
                                                                                                $flag_noe_kharid = "service_jadid";
                                                                                            }
                                                                                            switch ($res_service[0]['noe_forosh']) {
                                                                                                case 'adi':
                                                                                                    $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                                    $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                                    if ($flag_noe_kharid == "sharje_mojadad") {
                                                                                                        //pardakhte porsante namayande baraye sharje mojadad zamani ke namayande hesabe bank darad
                                                                                                        $branch_credit_array                      = array();
                                                                                                        $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) + (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * ($res_noe_hamkari[0]['foroshe_service_sharje_mojadad'] / 100);
                                                                                                        $branch_credit_array['bestankar']         = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * ($res_noe_hamkari[0]['foroshe_service_sharje_mojadad'] / 100);
                                                                                                        $branch_credit_array['bedehkar']          = 0;
                                                                                                        $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                                        $branch_credit_array['noe_user']          = '2';
                                                                                                        $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                        $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                        $branch_credit_array['tozihat']           = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                                        $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                                        $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                                    } elseif ($flag_noe_kharid == "service_jadid") {
                                                                                                        //pardakhte porsante namayande baraye service jadid zamani ke namayande hesabe bank darad
                                                                                                        $branch_credit_array                      = array();
                                                                                                        $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) + (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * ($res_noe_hamkari[0]['foroshe_service_jadid'] / 100);
                                                                                                        $branch_credit_array['bestankar']         = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * ($res_noe_hamkari[0]['foroshe_service_jadid'] / 100);
                                                                                                        $branch_credit_array['bedehkar']          = 0;
                                                                                                        $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                                        $branch_credit_array['noe_user']          = '2';
                                                                                                        $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                        $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                        $branch_credit_array['tozihat']           = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                                        $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                                        $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                                    }
                                                                                                    Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                                                                                                    die(Helper::Json_Message('pardakht_success'));
                                                                                                    break;
                                                                                                case 'bulk':
                                                                                                    $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                                    $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                                    //pardakhte porsante namayande baraye bulk zamani ke namayande hesabe bank darad
                                                                                                    $branch_credit_array                      = array();
                                                                                                    $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) + (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * ($res_noe_hamkari[0]['foroshe_service_bulk'] / 100);
                                                                                                    $branch_credit_array['bestankar']         = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * ($res_noe_hamkari[0]['foroshe_service_bulk'] / 100);
                                                                                                    $branch_credit_array['bedehkar']          = 0;
                                                                                                    $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                                    $branch_credit_array['noe_user']          = '2';
                                                                                                    $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                    $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                    $branch_credit_array['tozihat']           = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                                    $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                                    $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                                    Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                                                                                                    die(Helper::Json_Message('pardakht_success'));
                                                                                                    break;
                                                                                                case 'jashnvare':
                                                                                                    $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                                    $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                                    //pardakhte porsante namayande baraye jashnvare zamani ke namayande hesabe bank darad
                                                                                                    $branch_credit_array                      = array();
                                                                                                    $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']) + (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * ($res_noe_hamkari[0]['foroshe_service_jashnvare'] / 100);
                                                                                                    $branch_credit_array['bestankar']         = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * ($res_noe_hamkari[0]['foroshe_service_jashnvare'] / 100);
                                                                                                    $branch_credit_array['bedehkar']          = 0;
                                                                                                    $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                                    $branch_credit_array['noe_user']          = '2';
                                                                                                    $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                    $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                    $branch_credit_array['tozihat']           = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                                    $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                                    $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                                    Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                                                                                                    die(Helper::Json_Message('pardakht_success'));
                                                                                                    break;
                                                                                                default:
                                                                                                    die(Helper::Json_Message('service_info_not_right'));
                                                                                                    break;
                                                                                            }
                                                                                        } elseif ($res_noe_hamkari[0]['cooperation_type'] === 2) {
                                                                                            //pardakht az namayande->license
                                                                                            $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                            $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                            //pardakhte porsante(lisence) namayande zamani ke namayande hesabe bank darad
                                                                                            //insert credit ghabli
                                                                                            $branch_credit_array                      = array();
                                                                                            $branch_credit_array['credit']            = floatval($res_credit_branch[0]['credit']);
                                                                                            $branch_credit_array['bestankar']         = 0;
                                                                                            $branch_credit_array['bedehkar']          = 0;
                                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                            $branch_credit_array['noe_user']          = '2';
                                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                            $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                            $branch_credit_array['tozihat']           = 'پرداخت مبلغ فاکتور برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                            $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                            $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                            //insert credit - maliat /update tozihat
                                                                                            $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                            $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                            $branch_credit_array                      = array();
                                                                                            $branch_credit_array['credit']            = abs(floatval($res_credit_branch[0]['credit'])) - (abs(floatval($res_factor[0]['maliate_arzeshe_afzode'])) + abs(floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))); //-maliat
                                                                                            $branch_credit_array['bestankar']         = 0;
                                                                                            $branch_credit_array['bedehkar']          = (abs(floatval($res_factor[0]['maliate_arzeshe_afzode'])) + abs(floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))); //-maliat
                                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                            $branch_credit_array['noe_user']          = '2';
                                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                            $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                            $branch_credit_array['tozihat']           = 'کسر مالیات برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                            $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                            $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                            //insert credit - darsade hazine_sazmane_tanzim /update tozihat
                                                                                            $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                            $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                            $branch_credit_array                      = array();
                                                                                            $branch_credit_array['credit']            = abs(floatval($res_credit_branch[0]['credit'])) - ((abs(floatval($res_factor[0]['mablaghe_ghabele_pardakht'])) - (abs(floatval($res_factor[0]['maliate_arzeshe_afzode'])) + abs(floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])))) * floatval($res_noe_hamkari[0]['hazine_sazmane_tanzim']) / 100); //-hazine_sazmane_tanzim
                                                                                            $branch_credit_array['bestankar']         = 0;
                                                                                            $branch_credit_array['bedehkar']          = (abs(floatval($res_factor[0]['mablaghe_ghabele_pardakht'])) - (abs(floatval($res_factor[0]['maliate_arzeshe_afzode'])) + abs(floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])))) * floatval($res_noe_hamkari[0]['hazine_sazmane_tanzim']) / 100;
                                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                            $branch_credit_array['noe_user']          = '2';
                                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                            $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                            $branch_credit_array['tozihat']           = 'کسر هزینه سازمان تنظیم برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                            $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                            $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                            //insert credit - darsade hazine_servco /update tozihat
                                                                                            $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                            $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                            $branch_credit_array                      = array();
                                                                                            $branch_credit_array['credit']            = abs(floatval($res_credit_branch[0]['credit'])) - ((abs(floatval($res_factor[0]['mablaghe_ghabele_pardakht'])) - (abs(floatval($res_factor[0]['maliate_arzeshe_afzode'])) + abs(floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])))) * floatval($res_noe_hamkari[0]['hazine_servco']) / 100); //-hazine_servco
                                                                                            $branch_credit_array['bestankar']         = 0;
                                                                                            $branch_credit_array['bedehkar']          = (abs(floatval($res_factor[0]['mablaghe_ghabele_pardakht'])) - (abs(floatval($res_factor[0]['maliate_arzeshe_afzode'])) + abs(floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])))) * floatval($res_noe_hamkari[0]['hazine_servco']) / 100; //-hazine_servco
                                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                            $branch_credit_array['noe_user']          = '2';
                                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                            $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                            $branch_credit_array['tozihat']           = 'کسر هزینه سروکو برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                            $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                            $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                            //insert credit - darsade hazine_mansobe /update tozihat
                                                                                            $sql_credit_branch                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='2' ORDER BY id DESC LIMIT 1";
                                                                                            $res_credit_branch                        = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id']));
                                                                                            $branch_credit_array                      = array();
                                                                                            $branch_credit_array['credit']            = abs(floatval($res_credit_branch[0]['credit'])) - floatval($res_noe_hamkari[0]['hazine_mansobe']); //-hazine_mansobe
                                                                                            $branch_credit_array['bestankar']         = 0;
                                                                                            $branch_credit_array['bedehkar']          = floatval($res_noe_hamkari[0]['hazine_mansobe']);
                                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                                            $branch_credit_array['noe_user']          = '2';
                                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                            $branch_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                            $branch_credit_array['tozihat']           = 'کسر هزینه منصوبه برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                                            $sql                                      = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                                            $result                                   = Db::secure_insert_array($sql, $branch_credit_array);
                                                                                            ////////////////////////////subscriber credit //////////////////////////////////////////
                                                                                            $sql_credit_subscriber = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                            $res_credit_subscriber = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                            if ($res_credit_subscriber) {
                                                                                                // user has an account already
                                                                                                //add mablaghe kol to user credit
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) + floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                                $subscriber_credit_array['bedehkar']          = 0;
                                                                                                $subscriber_credit_array['bestankar']         = floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'بدهکاری مشترک به نماینده در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                                //kasre asle mablaghe kol az moshtarak
                                                                                                $sql_credit_subscriber                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                                $res_credit_subscriber                        = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])));
                                                                                                $subscriber_credit_array['bedehkar']          = floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bestankar']         = 0;
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'کسر مالیات توسط سیستم در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                                //kasre credit - maliat+arzeshe afzoode az moshtarak
                                                                                                $sql_credit_subscriber                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                                $res_credit_subscriber                        = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bedehkar']          = (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bestankar']         = 0;
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'کسر مبلغ فاکتور توسط نماینده/شرکت در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                            } else {
                                                                                                //create user account
                                                                                                //add mablaghe kol to user credit
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                                $subscriber_credit_array['bedehkar']          = 0;
                                                                                                $subscriber_credit_array['bestankar']         = floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_factor[0]['subscriber_id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'بدهکاری مشترک به نماینده در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                                //kasre asle mablaghe kol az moshtarak
                                                                                                $sql_credit_subscriber                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                                $res_credit_subscriber                        = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])));
                                                                                                $subscriber_credit_array['bedehkar']          = floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bestankar']         = 0;
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_factor[0]['subscriber_id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'کسر مالیات توسط سیستم در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                                //kasre credit - maliat+arzeshe afzoode az moshtarak
                                                                                                $sql_credit_subscriber                        = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY id DESC LIMIT 1";
                                                                                                $res_credit_subscriber                        = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                                                                $subscriber_credit_array                      = array();
                                                                                                $subscriber_credit_array['credit']            = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bedehkar']          = (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                                                $subscriber_credit_array['bestankar']         = 0;
                                                                                                $subscriber_credit_array['user_or_branch_id'] = $res_factor[0]['subscriber_id'];
                                                                                                $subscriber_credit_array['noe_user']          = '1';
                                                                                                $subscriber_credit_array['tozihat']           = 'کسر مبلغ فاکتور توسط نماینده/شرکت در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                                                $subscriber_credit_array['modifier_id']       = $_SESSION['user_id'];
                                                                                                $sql                                          = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                                                $result                                       = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                                            }
                                                                                            Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                                                                                            die(Helper::Json_Message('pardakht_success'));
                                                                                        }
                                                                                    } else {
                                                                                        die(Helper::Json_Message('branch_cooperation_info_not_found'));
                                                                                    }
                                                                                } else {
                                                                                    die(Helper::Json_Message('branch_cooperation_info_not_found'));
                                                                                }
                                                                            } else {
                                                                                die(Helper::Json_Message('branch_credit_not_enough'));
                                                                            }
                                                                        } else {
                                                                            die(Helper::Json_Message('branch_credit_account_not_found'));
                                                                        }
                                                                    } else {
                                                                        die(Helper::Json_Message('auth_fail'));
                                                                    }
                                                                    break;
                                                                default:
                                                                    die(Helper::Json_Message('auth_fail'));
                                                                    break;
                                                            }
                                                        } else {
                                                            die(Helper::Json_Message('auth_fail'));
                                                        }
                                                    } else {
                                                        die(Helper::json_Message('branch_not_found'));
                                                    }
                                                } else {
                                                    die(Helper::Json_Message('subscriber_not_found'));
                                                }
                                            } else {
                                                die(Helper::Json_Message('service_info_not_right'));
                                            }
                                        } else {
                                            die(Helper::Json_Message('service_not_found'));
                                        }

                                        break;
                                    case "pardakht_dasti":
                                        die(Helper::Json_Message('info_not_true'));
                                        break;

                                    default:
                                        die(Helper::Json_Message('info_not_true'));
                                        break;
                                }
                            } else {
                                die(Helper::Json_Message('factor_not_found'));
                            }
                        } else {
                            die(Helper::Json_Message('required_info_not_found'));
                        }
                        break;
                    default:
                        die(Helper::Json_Message('auth_fail'));
                        break;
                }
            } else {
                die(Helper::Json_Message('auth_fail'));
            }

            // die(print_r($_POST));
        }
        /////////////////factorha tab modal forms
        $this->view->pagename = 'factors';
        $this->view->render('factors', 'dashboard_template', '/public/js/factors.js', false);
    }
}
