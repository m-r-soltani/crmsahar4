<?php defined('__ROOT__') or exit('No direct script access allowed');

class Bootstrap
{
    public function __construct()
    {
        $_SESSION['dashboard_menu_names'] = Helper::get_all_dashboard_menu_names();
        if (isset($_POST['send_change_service_password'])) {
            $_POST = Helper::Create_Post_Array_Without_Key($_POST);
            $_POST = Helper::xss_check_array($_POST);
            if (isset($_POST['ibsusername']) && isset($_POST['noeservice']) && isset($_POST['userid']) && isset($_POST['newpassword'])) {
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                    case __MODIRUSERTYPE__:
                    case __MODIR2USERTYPE__:
                    case __OPERATOR2USERTYPE__:
                    case __OPERATORUSERTYPE__:
                        //niazi nist kari anjam she
                        break;
                    case __MOSHTARAKUSERTYPE__:
                        $_POST['userid'] = $_SESSION['user_id'];
                        break;
                }
                switch ($_POST['noeservice']) {
                    case 'adsl':
                    case 'vdsl':
                    case 'bitstream':
                    case 'wireless':
                    case 'tdlte':
                        $res_usrid = $GLOBALS['ibs_internet']->getUserIdByNormalUsername($_POST['ibsusername']);
                        $res = $GLOBALS['ibs_internet']->setNormalUserAuth((string) $res_usrid[1], $_POST['ibsusername'], $_POST['newpassword']);
                        break;
                    case 'voip':
                        $res_usrid = $GLOBALS['ibs_internet']->getUserIdByVoipUsername($_POST['ibsusername']);
                        $res = $GLOBALS['ibs_voip']->setVoipUserAuth((string) $res_usrid[1], $_POST['ibsusername'], $_POST['newpassword']);
                        break;
                    default:
                        die(Helper::Json_Message('f'));
                        break;
                }
                if (isset($res)) {
                    die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                } else {
                    die(Helper::Json_Message('f'));
                }

            }
        }
        if (isset($_POST['State'])) {
            $sql = "SELECT * FROM bnm_sep_payment WHERE resnum = ?";
            $payment = Db::secure_fetchall($sql, [$_POST['ResNum']]);
            switch ($_POST['State']) {
                case 'OK':
                    $sql = "SELECT count(*) as rows_num FROM bnm_sep_payment WHERE refnum = ?";
                    $result = Db::secure_fetchall($sql, array($_POST['RefNum']));
                    if ($result[0]['rows_num'] === 0) {
                        $client = new nusoap_client('https://verify.sep.ir/payments/referencepayment.asmx?wsdl');
                        $err = $client->getError();
                        $res_verify = $client->call('VerifyTransaction', [
                            'RefNum' => $_POST['RefNum'],
                            'MID' => '11604173',
                        ]);
                        die(print_r($res_verify));
                        if (isset($res_verify) && !$err) {
                            if ($res_verify === $payment[0]['amount']) {
                                $arr = array();
                                $arr['id'] = $payment[0]['id'];
                                $arr['state'] = $_POST['State'];
                                $arr['status'] = $_POST['Status'];
                                $arr['resnum'] = $_POST['ResNum'];
                                $arr['refnum'] = $_POST['RefNum'];
                                $arr['cid'] = $_POST['CID'];
                                $arr['traceno'] = $_POST['TRACENO'];
                                $arr['rrn'] = $_POST['RRN'];
                                $arr['amount'] = $_POST['Amount'];
                                $arr['securepan'] = $_POST['SecurePan'];
                                $arr['mid'] = $_POST['MID'];
                                $arr['token'] = $_POST['Token'];
                                $sql = Helper::Update_Generator($arr, 'bnm_sep_payment', "WHERE id = :id");
                                $res = Db::secure_update_array($sql, $arr);
                                // initializing sms panel
                                switch ($payment[0]['user_type']) {
                                    case __ADMINUSERTYPE__:
                                    case __ADMINOPERATORUSERTYPE__:
                                        $noe_user = 0;
                                        echo Helper::Alert_Custom_Message("نوع کاربری شما ادمین است پس شارژی اضافه نمیشود");
                                        break;
                                    case __MODIRUSERTYPE__:
                                    case __MODIR2USERTYPE__:
                                        $noe_user = 2;
                                        $res_user = Helper::Select_By_Id('bnm_operator', $payment[0]['user_id']);
                                        $res_chargecredit = Helper::chargeCreditTransaction($payment[0]['user_id'], $noe_user, $res_verify, $arr['resnum']);
                                        if ($res_user) {
                                            $res_internal = Helper::Internal_Message_By_Karbord('sharje_bn', '1');
                                            if ($res_internal) {
                                                $res_sms_request = Helper::Write_In_Sms_Request(
                                                    $res_user[0]['telephone_hamrah'],
                                                    Helper::Today_Miladi_Date(),
                                                    Helper::Today_Miladi_Date(),
                                                    1,
                                                    $res_internal[0]['id'],
                                                    '2'
                                                );
                                                if ($res_sms_request) {
                                                    $arrsms = array();
                                                    $arrsms['receiver'] = $res_user[0]['telephone_hamrah'];
                                                    $arrsms['sender'] = __SMSNUMBER__;
                                                    $arrsms['request_id'] = $res_sms_request;
                                                    $arrsms = Helper::Write_In_Sms_Queue($arrsms);
                                                } else {
                                                    echo Helper::Alert_Custom_Message('پرداخت با موفقیت انجام شد. شماره تراکنش: ' . $arr['resnum'] . 'مشکل در ارسال پیامک!');
                                                }
                                            } else {
                                                echo Helper::Alert_Custom_Message('پرداخت با موفقیت انجام شد. شماره تراکنش: ' . $arr['resnum'] . 'مشکل در ارسال پیامک!');
                                            }
                                        } else {
                                            echo Helper::Alert_Custom_Message('پرداخت با موفقیت انجام شد. شماره تراکنش: ' . $arr['resnum'] . 'مشکل در ارسال پیامک!');
                                        }
                                        break;
                                    case __MOSHTARAKUSERTYPE__:
                                        $noe_user = 1;
                                        $res_user = Helper::Select_By_Id('bnm_subscribers', $payment[0]['user_id']);
                                        if ($res_user) {
                                            if ($res_user[0]['branch_id'] === 0) {
                                                $res_internal = Helper::Internal_Message_By_Karbord('sharje_bms', '1');
                                                if ($res_internal) {
                                                    $res_sms_request = Helper::Write_In_Sms_Request(
                                                        $res_user[0]['telephone_hamrah'],
                                                        Helper::Today_Miladi_Date(),
                                                        Helper::Today_Miladi_Date(),
                                                        1,
                                                        $res_internal[0]['id'],
                                                        '2'
                                                    );
                                                    if ($res_sms_request) {
                                                        $arrsms = array();
                                                        $arrsms['receiver'] = $res_user[0]['telephone_hamrah'];
                                                        $arrsms['sender'] = __SMSNUMBER__;
                                                        $arrsms['request_id'] = $res_sms_request;
                                                        $arrsms = Helper::Write_In_Sms_Queue($arrsms);
                                                    } else {
                                                        echo Helper::Alert_Custom_Message('پرداخت با موفقیت انجام شد. شماره تراکنش: ' . $arr['resnum'] . 'مشکل در ارسال پیامک!');
                                                    }
                                                } else {
                                                    echo Helper::Alert_Custom_Message('پرداخت با موفقیت انجام شد. شماره تراکنش: ' . $arr['resnum'] . 'مشکل در ارسال پیامک!');
                                                }
                                            } else {
                                                //user namayande
                                                $res_sub = Helper::Select_By_Id('bnm_subscribers', $payment[0]['user_id']);
                                                if ($res_sub) {
                                                    $res_internal = Helper::Internal_Message_By_Karbord('sharje_bmn', '1');
                                                    if ($res_internal) {
                                                        $res_sms_request = Helper::Write_In_Sms_Request(
                                                            $res_sub[0]['telephone_hamrah'],
                                                            Helper::Today_Miladi_Date(),
                                                            Helper::Today_Miladi_Date(),
                                                            1,
                                                            $res_internal[0]['id'],
                                                            '2'
                                                        );
                                                        if ($res_sms_request) {
                                                            $arrsms = array();
                                                            $arrsms['receiver'] = $res_sub[0]['telephone_hamrah'];
                                                            $arrsms['sender'] = __SMSNUMBER__;
                                                            $arrsms['request_id'] = $res_sms_request;
                                                            $arrsms = Helper::Write_In_Sms_Queue($arrsms);
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        break;
                                    default:
                                        echo Helper::Alert_Custom_Message('تراکنش بدرستی انجام شد اما نوع کاربری شما برای ادامه عملییات یافت نشد لطفا با پشتیبانی تماس بگیرید');
                                        break;
                                }

                                if ($res_chargecredit) {
                                    echo Helper::Alert_Custom_Message('شماره تراکنش: ' . $arr['resnum']);
                                } else {
                                    echo Helper::Alert_Custom_Message($arr["resnum"] . ' :تراکنش انجام شد ولیکن مشکلی در ثبت اطلاعات بوجود آمده لطفا با پشتیبانی تماس بگیرید. شماره تراکتش');
                                }
                            } else {
                                // verify is not true
                                echo Helper::Alert_Custom_Message('مشکل در اعتبار سنجی تراکنش در صودت عودت نشدن مبلغ لطفا با پشتیبانی بانک سامان تماس بگیرید.');
                            }
                        } else {
                            //verify nashod
                            echo Helper::Alert_Custom_Message('اعتبار سنجی تراکنش با مشکل مواجه شده جهت عودت مبلغ واریزی با پشتیبانی بانک سامان تماس بگیرید.');
                        }
                    } else {
                        $msg = "تراکنش شما نامعتبر است";
                        echo Helper::Alert_Custom_Message($msg);
                    }
                    break;
                case 'CanceledByUser':
                case 'Failed':
                case 'SessionIsNull':
                case 'InvalidParameters':
                case 'MerchantIpAddressIsInvalid':
                case 'TokenNotFound':
                case 'TokenRequired':
                case 'TerminalNotFound':
                    $arr = array();
                    $arr['state'] = $_POST['State'];
                    $arr['statecode'] = $_POST['StateCode'];
                    $arr['id'] = $_SESSION['sep_id'];
                    $arr['refnum'] = $_POST['RefNum'];
                    $arr['cid'] = $_POST['CID'];
                    $arr['traceno'] = $_POST['TRACENO'];
                    $arr['rrn'] = $_POST['RRN'];
                    $arr['amount'] = $_POST['Amount'];
                    $arr['securepan'] = $_POST['SecurePan'];
                    $arr['mid'] = $_POST['MID'];
                    $arr['final_status'] = 'before_verify';
                    $sql = Helper::Update_Generator($arr, 'bnm_sep_payment', "WHERE id = :id");
                    $res = Db::secure_update_array($sql, $arr);
                    echo "<script>alert('2عملیات ناموفق.');</script>";
                    //echo "<script>{$arr['state']}</script>";
                    break;

                default:
                    echo "<script>alert('3عملیات ناموفق.');</script>";
                    break;
            }
        }

        if (isset($_POST['send_change_system_password'])) {
            try {
                $_POST = Helper::Create_Post_Array_Without_Key($_POST);
                $_POST = Helper::xss_check_array($_POST);
                $_POST['new_password'] = Helper::str_trim($_POST['new_password']);
                $_POST['new_password_confirm'] = Helper::str_trim($_POST['new_password_confirm']);
                $_POST['prev_password'] = Helper::str_trim($_POST['prev_password']);
                if (Helper::Is_Empty_OR_Null($_POST['new_password']) && Helper::Is_Empty_OR_Null($_POST['prev_password'])) {
                    if ($_POST['new_password'] === $_POST['new_password_confirm']) {
                        //check username and last password
                        $_POST['prev_password'] = Helper::str_md5($_POST['prev_password']);
                        $sql_init = "SELECT * FROM bnm_users WHERE id=? AND username=? AND password=?";
                        $res_init = Db::secure_fetchall($sql_init, array($_SESSION['id'], $_SESSION['username'], $_POST['prev_password']));
                        if ($res_init) {
                            //update password
                            $arr = array();
                            $arr['password'] = Helper::str_md5($_POST['new_password']);
                            $arr['id'] = $_SESSION['id'];
                            $sql = Helper::Update_Generator($arr, 'bnm_users', "WHERE id = :id");
                            $res = Db::secure_update_array($sql, $arr);
                            if ($res) {
                                die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                            } else {
                                die(Helper::Json_Message('f'));
                            }
                        } else {
                            die(Helper::Json_Message('f'));
                        }

                    } else {
                        die(Helper::Custom_Msg(Helper::Messages('npacf'), 2));
                    }
                } else {
                    die(Helper::Json_Message('f'));
                }
            } catch (Throwable $e) {
                $res = Helper::Exc_Error_Debug($e, true, '', true);
                die();
            }
        }
        if (isset($_POST['send_administration_change_system_password'])) {
            $_POST = Helper::Create_Post_Array_Without_Key($_POST);
            $_POST = Helper::xss_check_array($_POST);
            if (Helper::Is_Empty_OR_Null($_POST['new_password']) && Helper::Is_Empty_OR_Null($_POST['new_password_confirm'])) {
                $_POST['new_password'] = Helper::str_trim($_POST['new_password']);
                $_POST['new_password_confirm'] = Helper::str_trim($_POST['new_password_confirm']);
                if ($_POST['new_password'] === $_POST['new_password_confirm']) {
                    $arr = array();
                    $arr['password'] = Helper::str_md5($_POST['new_password']);
                    $arr['user_id'] = $_POST['userid'];
                    $arr['user_type'] = __MOSHTARAKUSERTYPE__;
                    // $sql             = Helper::Update_Generator($arr, 'bnm_users', "WHERE id = :id");
                    $sql = "UPDATE bnm_users SET password = :password WHERE user_id = :user_id AND user_type = :user_type";
                    $res = Db::secure_update_array($sql, $arr);
                    if ($res) {
                        die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                    } else {
                        die(Helper::Json_Message('f'));
                    }

                } else {
                    die(Helper::Custom_Msg(Helper::Messages('npacf'), 2));
                }
            } else {
                die(Helper::Json_Message('f'));
            }
        }
        /*=============send_support_requests_inbox_response==============*/
        if (isset($_POST['support_requests_inbox_response'])) {
            $_POST = Helper::Create_Post_Array_Without_Key($_POST);
            $_POST = Helper::xss_check_array($_POST);
            $_POST = Helper::Manual_Unset_Array($_POST, array('reply_id', 'onvane_payam', 'matne_payam'));
            if (Helper::Login_Just_Check()) {
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                        die(Helper::Json_Message('na'));
                        break;
                    case __MODIRUSERTYPE__:
                    case __OPERATORUSERTYPE__:
                    case __MODIR2USERTYPE__:
                    case __OPERATOR2USERTYPE__:
                        die(Helper::Json_Message('na'));
                        break;
                    case __MOSHTARAKUSERTYPE__:
                        if (Helper::Is_Empty_OR_Null($_POST['reply_id'])) {
                            $sql_init = "SELECT * FROM bnm_support_requests
                            WHERE id=? AND
                            sender_user_type IN (" . __ADMINUSERTYPE__ . "," . __ADMINOPERATORUSERTYPE__ . "," . __MODIRUSERTYPE__ . "," . __OPERATORUSERTYPE__ . "," . __MODIR2USERTYPE__ . "," . __OPERATOR2USERTYPE__ . ")
                            AND reciever_id=? AND reciever_type= " . __MOSHTARAKUSERTYPE__ . " AND sender_user_id <> ?";
                            //sender_user_type IN (1,2,3,4) AND reciever_type= 5
                            $res_init = Db::secure_fetchall($sql_init, array($_POST['reply_id'], $_SESSION['user_id'], $_SESSION['user_id']));
                            if ($res_init) {
                                //its ok let send replay
                                $arr = array();
                                $arr['onvane_payam'] = $_POST['onvane_payam'];
                                $arr['matne_payam'] = $_POST['matne_payam'];
                                $arr['matne_payam'] = $_POST['matne_payam'];
                                $arr['reciever_user_id'] = $res_init[0]['sender_user_id'];
                                $arr['reciever_user_type'] = $res_init[0]['sender_user_type'];
                                $arr['sender_user_id'] = $_SESSION['user_id'];
                                $arr['sender_branch_id'] = $_SESSION['branch_id'];
                                $arr['sender_id'] = $_SESSION['id'];
                                $arr['sender_user_type'] = $_SESSION['user_type'];
                                $sql = Helper::Insert_Generator($arr, 'bnm_support_requests');
                                $res = Db::secure_insert_array($sql, $arr);
                                if ($res) {

                                    die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                                } else {
                                    die(Helper::Json_Message('f'));
                                }
                            } else {
                                die(Helper::Json_Message('af'));
                            }
                        } else {
                            die(Helper::Json_Message('f'));
                        }

                        break;
                }
            } else {
                die(Helper::Json_Message('af'));
            }

            die(json_encode($_POST));
        }

        if (isset($_POST['online_user_form_request'])) {
            $_POST = Helper::Create_Post_Array_Without_Key($_POST);
            $_POST = Helper::xss_check_array($_POST);
            if (Helper::Login_Just_Check()) {
                // switch ($_SESSION['user_type']) {
                //     case __ADMINUSERTYPE__:
                //     case __ADMINOPERATORUSERTYPE__:
                //     case __MODIRUSERTYPE__:
                //     case __OPERATORUSERTYPE__:
                //     case __MODIR2USERTYPE__:
                //     case __OPERATOR2USERTYPE__:
                //     break;
                //     case __MOSHTARAKUSERTYPE__:
                //     break;
                // }
                switch ($_POST['service_type']) {
                    case 'adsl':
                    case 'vdsl':
                    case 'bitstream':
                    case 'wireless':
                    case 'tdlte':
                        $noemasraf = "internet";
                        $ibsusername = $_POST['ibsusername'];
                        $res = $GLOBALS['ibs_internet']->getAllInternetOnlineUsers();
                        break;
                    case 'voip':
                        $noemasraf = "voip";
                        $ibsusername = $_POST['ibsusername'];
                        $res = $GLOBALS['ibs_voip']->getAllVoipOnlineUsers();
                        break;
                }
                if (isset($res)) {
                    // $res[2] = $noemasraf;
                    // $res[3] = $ibsusername;

                    $res = Helper::ibsOnlineuserFilterInitialize($res);
                    $res['noemasraf'] = $noemasraf;
                    $res['ibsusername'] = $ibsusername;
                    die(json_encode($res));
                } else {
                    die(Helper::Json_Message('f'));
                }
            }
        }
        if (isset($_POST['connection_log_form_request'])) {
            $_POST = Helper::Create_Post_Array_Without_Key($_POST);
            $_POST = Helper::xss_check_array($_POST);

            if (isset($_POST['noe_masraf'])) {
                $res_noemasraf = Helper::Select_By_Id('bnm_connection_log', $_POST['noe_masraf']);
            } else {
                die(Helper::Json_Message('f'));
            }
            if (isset($_POST['time_from'])) {
                $date_arr = array();
                $date_arr = explode("/", $_POST['time_from']);
                if (count($date_arr) > 2) {
                    $year = (int) Helper::convert_numbers($date_arr[0], false);
                    $month = (int) Helper::convert_numbers($date_arr[1], false);
                    $day = (int) Helper::convert_numbers($date_arr[2], false);
                    $_POST['time_from'] = Helper::jalali_to_gregorian($year, $month, $day, '/');
                } else {
                    die(Helper::Json_Message('f'));
                }
            } else {
                die(Helper::Json_Message('f'));
            }

            if (isset($_POST['time_to'])) {
                $date_arr = array();
                $date_arr = explode("/", $_POST['time_to']);
                if (count($date_arr) > 2) {
                    $year = (int) Helper::convert_numbers($date_arr[0], false);
                    $month = (int) Helper::convert_numbers($date_arr[1], false);
                    $day = (int) Helper::convert_numbers($date_arr[2], false);
                    $_POST['time_to'] = Helper::jalali_to_gregorian($year, $month, $day, '/');
                } else {
                    die(Helper::Json_Message('f'));
                }
            } else {
                die(Helper::Json_Message('f'));
            }
            if (Helper::Login_Just_Check()) {
                // switch ($_SESSION['user_type']) {
                //     case __ADMINUSERTYPE__:
                //     case __ADMINOPERATORUSERTYPE__:
                //     case __MODIRUSERTYPE__:
                //     case __OPERATORUSERTYPE__:
                //     case __MODIR2USERTYPE__:
                //     case __OPERATOR2USERTYPE__:
                //         //todo...
                //         switch ($_POST['service_type']) {
                //             case 'adsl':
                //             case 'vdsl':
                //             case 'bitstream':
                //             case 'wireless':
                //             case 'tdlte':
                //                 $res_ibs_init = $GLOBALS['ibs_internet']->getUserIdByNormalUsername($_POST['ibsusername']);
                //                 if ($res_ibs_init[0]) {
                //                     $res_ibs = $GLOBALS['ibs_internet']->getConnectionLogs($_POST['time_from'], $_POST['time_to'], (string) $res_ibs_init[1]);
                //                     $res_ibs[2] = 'internet';
                //                     //die(json_encode($res_ibs));
                //                 } else {
                //                     $msg = 'نام کاربری کاربر در IBSng وجود ندارد.';
                //                     die(Helper::Custom_Msg($msg, 2));
                //                 }
                //                 break;
                //             case 'voip':
                //                 $res_ibs_init = $GLOBALS['ibs_voip']->getUserIdByVoipUsername($_POST['ibsusername']);
                //                 if ($res_ibs_init[0]) {
                //                     $res_ibs = $GLOBALS['ibs_voip']->getConnectionLogsVoip($_POST['time_from'], $_POST['time_to'], (string) $res_ibs_init[1]);
                //                     $res_ibs[2] = 'voip';
                //                     //die(json_encode($res_ibs));
                //                 } else {
                //                     $msg = 'نام کاربری کاربر در IBSng وجود ندارد.';
                //                     die(Helper::Custom_Msg($msg, 2));
                //                 }
                //                 break;
                //         }
                //         break;
                //     case __MOSHTARAKUSERTYPE__:
                //         switch ($_POST['service_type']) {
                //             case 'adsl':
                //             case 'vdsl':
                //             case 'bitstream':
                //             case 'wireless':
                //             case 'tdlte':
                //                 $res_ibs_init = $GLOBALS['ibs_internet']->getUserIdByNormalUsername($_POST['ibsusername']);
                //                 if ($res_ibs_init[0]) {
                //                     $res_ibs = $GLOBALS['ibs_internet']->getConnectionLogs($_POST['time_from'], $_POST['time_to'], (string) $res_ibs_init[1]);
                //                     $res_ibs[2] = 'internet';
                //                     // die(json_encode($res_ibs));
                //                 } else {
                //                     $msg = 'نام کاربری کاربر در IBSng وجود ندارد.';
                //                     die(Helper::Custom_Msg($msg, 2));
                //                 }
                //                 break;
                //             case 'voip':
                //                 $res_ibs_init = $GLOBALS['ibs_voip']->getUserIdByVoipUsername($_POST['ibsusername']);
                //                 if ($res_ibs_init[0]) {
                //                     $res_ibs = $GLOBALS['ibs_voip']->getConnectionLogsVoip($_POST['time_from'], $_POST['time_to'], (string) $res_ibs_init[1]);
                //                     $res_ibs[2] = 'voip';
                //                     // die(json_encode($res_ibs));
                //                 } else {
                //                     $msg = 'نام کاربری کاربر در IBSng وجود ندارد.';
                //                     die(Helper::Custom_Msg($msg, 2));
                //                 }
                //                 break;
                //         }
                //         break;
                //     default:
                //         die(Helper::Json_Message('af'));
                //         break;
                // }
                switch ($_POST['service_type']) {
                    case 'adsl':
                    case 'vdsl':
                    case 'bitstream':
                    case 'wireless':
                    case 'tdlte':
                        $res_ibs_init = $GLOBALS['ibs_internet']->getUserIdByNormalUsername($_POST['ibsusername']);
                        if ($res_ibs_init[0]) {
                            $res_ibs = $GLOBALS['ibs_internet']->getConnectionLogs($_POST['time_from'], $_POST['time_to'], (string) $res_ibs_init[1]);
                            $flag_type = 'internet';
                        } else {
                            $msg = 'نام کاربری کاربر در IBSng وجود ندارد.';
                            die(Helper::Custom_Msg($msg, 2));
                        }
                        break;
                    case 'voip':
                        $res_ibs_init = $GLOBALS['ibs_voip']->getUserIdByVoipUsername($_POST['ibsusername']);
                        if ($res_ibs_init[0]) {
                            $res_ibs = $GLOBALS['ibs_voip']->getConnectionLogsVoip($_POST['time_from'], $_POST['time_to'], (string) $res_ibs_init[1]);
                            $flag_type = 'voip';
                        } else {
                            $msg = 'نام کاربری کاربر در IBSng وجود ندارد.';
                            die(Helper::Custom_Msg($msg, 2));
                        }
                        break;
                }
                if (isset($res_ibs)) {
                    $res_ibs = Helper::ibsConnectionlogFilterByNoeMasraf($res_ibs, $res_noemasraf[0]['name']);
                    if ($res_ibs) {
                        if (count($res_ibs) > 0) {
                            // $res_ibs['noe_service'] = $flag_type;
                            die(json_encode(['result' => $res_ibs, 'noe_service' => $flag_type]));
                        } else {
                            die(Helper::Custom_Msg(Helper::Messages('f'), 3));
                        }
                    } else {
                        die(Helper::Custom_Msg(Helper::Messages('f'), 3));
                    }
                } else {
                    die(Helper::Custom_Msg(Helper::Messages('f'), 3));
                }
            } else {
                die(Helper::Json_Message('af'));
            }
        }

        ////////////////datatable requests
        if (isset($_POST['datatable_request'])) {
            $result = Helper::datatable_handler($_POST);
            die($result);
        }
        if (isset($_POST['get_servicesbybsreserveid'])) {
            //bitstream
            if (Helper::Login_Just_Check()) {
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                        $sql = "SELECT * FROM bnm_oss_reserves WHERE id = ?";
                        $res = Db::secure_fetchall($sql, array($_POST['get_servicesbybsreserveid']), true);
                        break;
                    case __MODIRUSERTYPE__:
                    case __OPERATORUSERTYPE__:
                    case __MODIR2USERTYPE__:
                    case __OPERATOR2USERTYPE__:
                        $sql = "SELECT * FROM bnm_oss_reserves WHERE id = ? AND branch_id=?";
                        $res = Db::secure_fetchall($sql, array($_POST['get_servicesbybsreserveid'], $_SESSION['branch_id']), true);
                        break;
                    case __MOSHTARAKUSERTYPE__:
                        $sql = "SELECT * FROM bnm_oss_reserves WHERE id = ? AND branch_id=?";
                        $res = Db::secure_fetchall($sql, array($_POST['get_servicesbybsreserveid'], $_SESSION['branch_id']), true);
                        break;
                    default:
                        die(Helper::Json_Message('na'));
                        break;
                }
                if ($res) {
                    if (Helper::Is_Empty_OR_Null($res[0]['interface_type'])) {
                        if ($res[0]['interface_type'] === "adsl") {
                            $sql = "SELECT * FROM bnm_services WHERE noe_khadamat=? AND namayeshe_service=? AND type=? AND tarikhe_shoroe_namayesh<=CURDATE() AND tarikhe_payane_namayesh >= CURDATE()";
                            $res = Db::secure_fetchall($sql, array('BITSTREAM_ADSL', 'yes', 'adsl'), true);
                            if ($res) {
                                die(json_encode($res));
                            } else {
                                die(Helper::Custom_Msg('سرویسی جهت اختصاص به این فاکتور وجود ندارد!'));
                            }
                        } elseif ($res[0]['interface_type'] === "vdsl") {
                            $sql = "SELECT * FROM bnm_services WHERE noe_khadamat=? AND namayeshe_service=? AND type=? AND tarikhe_shoroe_namayesh<=CURDATE() AND tarikhe_payane_namayesh >= CURDATE()";
                            $res = Db::secure_fetchall($sql, array('BITSTREAM_VDSL', 'yes', 'vdsl'), true);
                            if ($res) {
                                die(json_encode($res));
                            } else {
                                die(Helper::Custom_Msg('سرویسی جهت اختصاص به این فاکتور وجود ندارد!'));
                            }
                        } else {
                            die(Helper::Custom_Msg('اطلاعات رزرو پورت به درستی ثبت نشده لطفا پس از بررسی مجددا تلاش کنید'));
                        }
                    } else {
                        die(Helper::Custom_Msg('اطلاعات رزرو پورت به درستی ثبت نشده لطفا پس از بررسی مجددا تلاش کنید'));
                    }
                } else {
                    die(Helper::Json_Message('f'));
                }
            } else {
                die(Helper::Json_Message('af'));
            }
        }
        /*========levels========*/
        if (isset($_POST['get_maliat'])) {
            switch ($_SESSION['user_type']) {
                case __ADMINUSERTYPE__:
                case __ADMINOPERATORUSERTYPE__:

                    $sql1 = "SELECT * FROM bnm_tax order by id asc limit 1";
                    $result1 = Db::fetchall_Query($sql1);
                    $rows = json_encode($result1);
                    die($rows);
                    break;
                case __MODIRUSERTYPE__:
                case __OPERATORUSERTYPE__:
                case __MODIR2USERTYPE__:
                case __OPERATOR2USERTYPE__:

                    $sql1 = "SELECT * FROM bnm_tax order by id asc limit 1";
                    $result1 = Db::fetchall_Query($sql1);
                    $rows = json_encode($result1);
                    die($rows);
                    break;
                case __MOSHTARAKUSERTYPE__:
                    $sql1 = "SELECT * FROM bnm_tax order by id asc limit 1";
                    $result1 = Db::fetchall_Query($sql1);
                    $rows = json_encode($result1);
                    die($rows);
                    break;
                default:
                    die(Helper::Json_Message('af'));
                    break;
            }
        }

        /*========levels========*/
        if (isset($_POST['Get_Tdlte_sims_unassigned'])) {
            //require_once ('../models/city.php');
            if (Helper::Login_Just_Check()) {
                switch ($_SESSION['user_type']) {
                    case __ADMINOPERATORUSERTYPE__:
                    case __ADMINUSERTYPE__:
                        $sql = "SELECT * FROM bnm_tdlte_sim WHERE subscriber_id IS NULL";
                        $res = Db::fetchall_Query($sql);
                        break;
                    case __MODIR2USERTYPE__:
                    case __OPERATOR2USERTYPE__:
                    case __MODIRUSERTYPE__:
                    case __OPERATORUSERTYPE__:
                        $sql = "SELECT * FROM bnm_tdlte_sim WHERE subscriber_id IS NULL AND branch_id = ?";
                        $res = Db::secure_fetchall($sql, array($_SESSION['branch_id']));
                        break;
                    default:
                        $res = false;
                        break;
                }
                if ($res) {
                    die(json_encode($res));
                } else {
                    die(Helper::Json_Message('f'));
                }

            } else {
                die(Helper::Json_Message('af'));
            }

        }
        /*========levels========*/
        if (isset($_POST['get_all_terminal'])) {
            //require_once ('../models/city.php');
            $sql1 = "SELECT * FROM bnm_terminal order by id asc";
            $result1 = Db::fetchall_Query($sql1);
            for ($i = 0; $i < count($result1); $i++) {
                $markaz_id = $result1[$i]['markaze_mokhaberati'];
                $terminal_name = $result1[$i]['name'];
                $sql2 = "SELECT * From bnm_telecommunications_center WHERE id ='$markaz_id'";
                $result2 = Db::fetchall_Query($sql2);
                $result1[$i]['markaz_name'] = $result2[0]['name'] . '-' . $result1[$i]['name'];
            }
            $rows = json_encode($result1);
            die($rows);
        }
        /*=========terminal by markaz=========== */
        if (isset($_POST['get_terminal_by_markazid'])) {
            $sql = "SELECT * FROM bnm_terminal WHERE markaze_mokhaberati= ?";
            $res = Db::secure_fetchall($sql, [$_POST['get_terminal_by_markazid']]);
            if ($res) {
                die(json_encode($res));
            } else {
                die(Helper::Custom_Msg(Helper::Messages('f'), 2));
            }
            // $result1 = Db::fetchall_Query($sql);
            // $rows = json_encode($result1);
            // die($rows);
        }
        /*=========terminal by markaz=========== */
        if (isset($_POST['get_popsite_bycity'])) {
            $sql = "SELECT id,name_dakal as name,ostan,shahr FROM bnm_popsite WHERE shahr= ?";
            $result = Db::secure_fetchall($sql, array($_POST['shahr']));
            if ($result) {
                die(json_encode($result));
            } else {
                die(Helper::Json_Message('f'));
            }

        }
        /*=========terminal by markaz=========== */
        if (isset($_POST['get_wirelessap_by_popsite'])) {
            $sql1 = "SELECT * FROM bnm_wireless_ap WHERE popsite=?";
            $result1 = Db::secure_fetchall($sql1, array($_POST['get_wirelessap_by_popsite']));
            if ($result1) {
                $sql2 = "SELECT * FROM bnm_popsite WHERE id= ?";
                $result2 = Db::secure_fetchall($sql2, array($result1[0]['popsite']));
                for ($i = 0; $i < count($result1); $i++) {
                    $result1[$i]['name'] = $result2[0]['name_dakal'];
                }
            } else {
                //echo "<script>alert('رادیویی با این پاپ سایت یافت نشد.');</script>";
                die(json_encode(array()));
            }
            $rows = json_encode($result1);
            die($rows);
        }
        /*=========terminal by markaz=========== */
        if (isset($_POST['get_wireless_station_by_ap'])) {
            if (Helper::Login_Just_Check()) {
                switch ($_SESSION['user_type']) {
                    case __ADMINOPERATORUSERTYPE__:
                    case __ADMINUSERTYPE__:
                        $sql = "SELECT * FROM bnm_wireless_station WHERE popsite= ?";
                        $res = Db::secure_fetchall($sql, array($_POST['condition1']), true);
                        break;
                    case __MODIR2USERTYPE__:
                    case __OPERATOR2USERTYPE__:
                    case __MODIRUSERTYPE__:
                    case __OPERATORUSERTYPE__:
                        $sql = "SELECT * FROM bnm_wireless_station WHERE popsite= ? AND branch_id=?";
                        $res = Db::secure_fetchall($sql, array($_POST['condition1'], $_SESSION['branch_id']), true);
                        break;
                    default:
                        $res = false;
                        break;
                }
                if ($res) {
                    die(json_encode($res));
                } else {
                    die(Helper::Json_Message('f'));
                }

            } else {
                die(Helper::Json_Message('af'));
            }

        }
        /*=========terminal by markaz=========== */
        if (isset($_POST['get_wireless_station_by_ap_where_station_eshterak_null'])) {
            $ap_id = $_POST['get_wireless_station_by_ap_where_station_eshterak_null'];
            $sql1 = "SELECT id,wireless_ap,name FROM bnm_wireless_station WHERE wireless_ap = ?";
            $result = Db::secure_fetchall($sql1, array($ap_id));
            if ($result) {
                die(json_encode($result));
            } else {
                die(Helper::Json_Message('f'));
            }
        }
        /*========levels========*/
        if (isset($_POST['Get_organization_levels'])) {

            $sql = "SELECT * FROM bnm_organization_level order by id asc";
            $result = Db::fetchall_Query($sql);
            if ($result) {
                die(json_encode($result));
            } else {
                die(Helper::Json_Message('f'));
            }
        }
        /*========Noe_terminal========*/
        if (isset($_POST['Get_Noe_terminal'])) {
            $sql = "SELECT * FROM bnm_noe_terminal";
            $result = Db::fetchall_Query($sql);
            if ($result) {
                die(json_encode($result));
            } else {
                die(Helper::Json_Message('f'));
            }
        }
        /*========branch========*/
        if (isset($_POST['get_branch_info'])) {
            //require_once ('../models/city.php');
            if (Helper::Login_Just_Check()) {
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                        $sql = "SELECT id,name_sherkat FROM bnm_branch";
                        $result = Db::fetchall_Query($sql);
                        break;
                    case __MODIRUSERTYPE__:
                    case __OPERATORUSERTYPE__:
                    case __MODIR2USERTYPE__:
                    case __OPERATOR2USERTYPE__:
                        $sql = "SELECT id,name_sherkat FROM bnm_branch";
                        $result = Db::secure_fetchall($sql, array($_SESSION['branch_id']));
                        break;
                    default:
                        die(Helper::Json_Message('na'));
                        break;
                }
                if ($result) {
                    die(json_encode($result));
                } else {
                    die(Helper::Json_Message('f'));
                }
            } else {
                die(Helper::Json_Message('af'));
            }
        }
        /*========Equipmentsbrands========*/
        if (isset($_POST['GetEquipmentsBrands'])) {
            //require_once ('../models/city.php');
            $sql = "SELECT * FROM bnm_equipments_brands order by id asc";
            $result = Db::fetchall_Query($sql);
            if ($result) {
                die(json_encode($result));
            } else {
                die(Helper::Json_Message('f'));
            }
        }
        /*========Equipments Models BY Brands========*/
        if (isset($_POST['GetEquipmetsModelsByBrand'])) {
            $sql = "SELECT * FROM bnm_equipments_models WHERE brand_id = ? AND exdate >= CURDATE()";
            $result = Db::secure_fetchall($sql, array($_POST['GetEquipmetsModelsByBrand']));
            if ($result) {
                die(json_encode($result));
            } else {
                die(Helper::Custom_Msg('تجهیزاتی یافت نشد یا تاریخ اعتبار آن تمام شده است', 3));
            }
        }
        /*========ostan========*/
        if (isset($_POST['GetProvinces'])) {
            $sql = "SELECT * FROM bnm_ostan order by id asc";
            $result = Db::fetchall_Query($sql);
            if ($result) {
                die(json_encode($result));
            } else {
                die(Helper::Json_Message('f'));
            }
        }
        /*=========shahr========*/
        if (isset($_POST['GetCities'])) {
            $sql = "SELECT * FROM bnm_shahr order by id asc";
            $result = Db::fetchall_Query($sql);
            if ($result) {
                die(json_encode($result));
            } else {
                die(Helper::Json_Message('f'));
            }
        }
        /*=========++shahrbyid++========*/
        if (isset($_POST['getcitybyprovince'])) {
            $sql = "SELECT * FROM bnm_shahr WHERE ostan_id= ?";
            $result = Db::secure_fetchall($sql, array($_POST['getcitybyprovince']));
            if ($result) {
                die(json_encode($result));
            } else {
                die(Helper::Json_Message('f'));
            }
        }
        /*=========++host++========*/
        if (isset($_POST['gethost'])) {
            $sql = "SELECT id,name_service_dahande FROM bnm_host";
            $result = Db::fetchall_Query($sql);
            if ($result) {
                die(json_encode($result));
            } else {
                die(Helper::Json_Message('f'));
            }
        }
        /*=========++popsite++========*/
        if (isset($_POST['get_wireless_ap'])) {
            $sql1 = "SELECT id,link_name,ssid FROM bnm_wireless_ap";
            $result1 = Db::fetchall_Query($sql1);
            $rows = json_encode($result1);
            die($rows);
        }
        if (isset($_POST['gethost_by_gharardad'])) {
            $sql = "SELECT id,name_service_dahande,dsl_license,dsl_bitstream FROM bnm_host WHERE (dsl_license = 'yes' OR dsl_bitstream='yes')";
            $result = Db::fetchall_Query($sql);
            $rows = json_encode($result);
            die($rows);
        }
        if (isset($_POST['getsubtelephonesbyid'])) {
            switch ($_SESSION['user_type']) {
                case __ADMINUSERTYPE__:
                case __ADMINOPERATORUSERTYPE__:
                    $sql = "SELECT id,name,f_name,telephone1,telephone2,telephone3 FROM bnm_subscribers WHERE id = ?";
                    $result = Db::secure_fetchall($sql, array($_POST['getsubtelephonesbyid']), true);
                    break;
                case __MODIRUSERTYPE__:
                case __OPERATORUSERTYPE__:
                case __MODIR2USERTYPE__:
                case __OPERATOR2USERTYPE__:
                    $sql = "SELECT id,name,f_name,telephone1,telephone2,telephone3 FROM bnm_subscribers WHERE id = ? AND branch_id = ?";
                    $result = Db::secure_fetchall($sql, array($_POST['getsubtelephonesbyid'], $_SESSION['branch_id']), true);

                    break;
                default:
                    die(Helper::Json_Message('na'));
                    break;
            }
            if ($result) {
                die(json_encode($result));
            } else {
                die(Helper::Json_Message('af'));
            }
        }
        if (isset($_POST['getosstelephonebyid'])) {
            if (Helper::Login_Just_Check()) {
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                        $sql = "SELECT sub.id id,oss.telephone telephone_id,
                        if(oss.telephone=1,sub.telephone1,if(oss.telephone=2,sub.telephone2,
                        if(oss.telephone=3,sub.telephone3,'شماره ایی ثبت نشده'))) telephone
                        FROM bnm_oss_subscribers oss LEFT JOIN bnm_subscribers sub ON oss.user_id=sub.id WHERE oss.id = ?";
                        $res = Db::secure_fetchall($sql, array($_POST['getosstelephonebyid']));
                        if ($res) {
                            die(json_encode($res));
                        } else {
                            die(Helper::Custom_Msg('اطلاعات مشترک به درستی درج نشده لطفا پس از بررسی مجددا بررسی نمایید'));
                        }
                        break;
                    case __MODIRUSERTYPE__:
                    case __OPERATORUSERTYPE__:
                    case __MODIR2USERTYPE__:
                    case __OPERATOR2USERTYPE__:
                        $sql = "SELECT sub.id id,oss.telephone telephone_id,
                        if(oss.telephone=1,sub.telephone1,if(oss.telephone=2,sub.telephone2,if(oss.telephone=3,sub.telephone3,'شماره ایی ثبت نشده'))) telephone
                        FROM bnm_oss_subscribers oss LEFT JOIN bnm_subscribers sub ON oss.user_id=sub.id WHERE oss.id = ? AND oss.branch_id=? AND sub.branch_id = ?";
                        $res = Db::secure_fetchall($sql, array($_POST['getosstelephonebyid'], $_SESSION['branch_id'], $_SESSION['branch_id']));
                        if ($res) {
                            die(json_encode($res));
                        } else {
                            die(Helper::Custom_Msg('اطلاعات مشترک به درستی درج نشده لطفا پس از بررسی مجددا بررسی نمایید'));
                        }

                        break;
                    default:
                        die(Helper::Json_Message('na'));
                        break;
                }
            } else {
                die(Helper::Json_Message('af'));
            }
        }
        if (isset($_POST['get_mizban_noe_gharardad_by_id'])) {
            $sql = "SELECT id,name_service_dahande,dsl_license,dsl_bitstream FROM bnm_host WHERE (dsl_license = 'yes' OR dsl_bitstream='yes') AND id= ?";
            $result = Db::secure_fetchall($sql, array($_POST['get_mizban_noe_gharardad_by_id']));
            $rows = json_encode($result);
            die($rows);
        }
        if (isset($_POST['getpopsite'])) {
            $sql = "SELECT id,name_dakal FROM bnm_popsite";
            $result = Db::fetchall_Query($sql);
            $rows = json_encode($result);
            die($rows);
        }
        if (isset($_POST['get_telecommunications_center'])) {
            $sql = "SELECT id,name FROM bnm_telecommunications_center";
            $result = Db::fetchall_Query($sql);
            $rows = json_encode($result);
            die($rows);
        }
        if (isset($_POST['getnoeterminal'])) {
            $sql = "SELECT id,esme_terminal FROM bnm_noe_terminal";
            $result = Db::fetchall_Query($sql);
            $rows = json_encode($result);
            die($rows);
        }
        if (isset($_POST['get_telecenter_bycity'])) {
            $sql = "SELECT id,name From bnm_telecommunications_center WHERE shahr= ?";
            $res = Db::secure_fetchall($sql, array($_POST['shahr']));
            if ($res) {
                die(json_encode($res));
            } else {
                die(Helper::Custom_Msg(Helper::Messages('inf'), 2));
            }
            // $rows = json_encode($result);
            // die($rows);
        }

        /*================initializing=================*/

        if (isset($_POST['initialize_request'])) {
            //params:{filter1,filter2}
            $page = $_POST['initialize_request'];
            switch ($page) {
                case 'ibsusernamebyuseridandtype':
                    // die(json_encode($_POST));
                    switch ($_POST['filter2']) {
                        case 'adsl':
                            $res = Helper::adslInfoByUserid((int) $_POST['filter1'], true);
                            break;
                        case 'vdsl':
                            $res = Helper::vdslInfoByUserid((int) $_POST['filter1'], true);
                            break;
                        case 'bitstream':
                            $res = Helper::bitstreamInfoByUserid((int) $_POST['filter1'], true);
                            break;
                        case 'wireless':
                            break;
                        case 'tdlte':
                            $res = Helper::tdlteInfoByUserid((int) $_POST['filter1'], true);
                            break;
                        case 'voip':
                            break;
                        default:
                            die(Helper::Json_Message('f'));
                            break;
                    }
                    if ($res) {
                        die(json_encode($res));
                    } else {
                        die(Helper::Json_Message('nasf'));
                    }
                    break;
                case 'display_contract_sendsms':
                    switch ($_SESSION['user_type']) {
                        case __MOSHTARAKUSERTYPE__:
                            $rescontract = Helper::Select_By_Id('bnm_services_contract', $_POST['request1']);
                            $internalmessage = Helper::Internal_Message_By_Karbord('emzaadsl' . $rescontract[0]['service_type'], 1);
                            if ($rescontract) {
                                $alreadysigned = Helper::checkContractSigned($_SESSION['user_id'], $rescontract[0]['id']);
                                if (!$alreadysigned) {
                                    //gharardad emza nashode
                                    $user = Helper::Select_By_Id('bnm_subscribers', $_SESSION['user_id']);
                                    if ($user) {
                                        if (Helper::Is_Empty_OR_Null($user[0]['telephone_hamrah'])) {
                                            //send sms
                                            //check code tekrari nabashad

                                            $code = Helper::randomNum(1100, 9999);
                                            $arr = [];
                                            $arr['code'] = $code;
                                            $arr['subid'] = $user[0]['id'];
                                            $arr['contractid'] = $rescontract[0]['id'];
                                            $arr['status'] = 0;
                                            $sql = Helper::Insert_Generator($arr, 'bnm_sub_contract');
                                            $res = Db::secure_insert_array($sql, $arr);
                                            if ($res) {
                                                die(json_encode($res));
                                            } else {
                                                die(Helper::Json_Message('f'));
                                            }
                                        } else {
                                            die(Helper::Json_Message('sinf'));
                                        }
                                    } else {
                                        die(Helper::Json_Message('f'));
                                    }
                                } else {
                                    die(Helper::Json_Message('cas'));
                                }
                            } else {
                                die(Helper::Json_Message('f'));
                            }
                            break;
                        default:
                            die(Helper::Json_Message('af'));
                            break;
                    }
                    break;
                case 'get_countries':
                    $sql = "SELECT * FROM bnm_countries";
                    $res = Db::fetchall_Query($sql);
                    if ($res) {
                        die(json_encode($res));
                    } else {
                        die(Helper::Json_Message('f'));
                    }
                    break;
                case 'get_company_types':
                    $sql = "SELECT * FROM bnm_company_types";
                    $res = Db::fetchall_Query($sql);
                    if ($res) {
                        die(json_encode($res));
                    } else {
                        die(Helper::Json_Message('f'));
                    }
                    break;
                case 'ip':
                    $sql = "SELECT * FROM bnm_ip_pool_list";
                    $res = Db::fetchall_Query($sql);
                    if ($res) {
                        die(json_encode($res));
                    } else {
                        die(Helper::Json_Message('f'));
                    }
                    break;
                case 'getsubnet':
                    $sql = "SELECT * FROM bnm_subnetmask";
                    $res = Db::fetchall_Query($sql);
                    if ($res) {
                        die(json_encode($res));
                    } else {
                        die(Helper::Json_Message('f'));
                    }
                    break;
                case 'gettickethistory':
                    if ($_POST['request1']) {
                        $res = Helper::select_by_id('bnm_oss_tickets', $_POST['request1']);
                        if ($res) {
                            die(json_encode($res));
                        } else {
                            die(Helper::Json_Message('f'));
                        }
                    } else {
                        die(Helper::Custom_Msg(Helper::Messages('sao'), 2));
                    }
                    break;
                case 'sms_inbox':
                    $res_inbox = array();
                    $result = Helper::getMessages();
                    if ($result) {
                        $res_inbox = $result;
                        while ($result['messages']) {
                            $endsms = end($res_inbox['messages']);
                            $res_inbox = Helper::smsTimestampToDate($res_inbox);
                            $result = Helper::getMessages($endsms['messageId']);
                            if ($result) {
                                $res_inbox['messages'] = array_merge($res_inbox['messages'], $result['messages']);
                            }
                        }
                        die(json_encode($res_inbox));
                    } else {
                        die(Helper::Json_Message('f'));
                    }
                    break;
                case 'sent_sms':
                    $result = Helper::getSentMessagesByTime();
                    if ($result) {
                        $result = Helper::smsTimestampToDate($result);
                        die(json_encode($result));
                    } else {
                        die(Helper::Json_Message('f'));
                    }
                    break;
                    break;
                case 'equipments_models':
                    $sql = "SELECT * FROM bnm_equipments_brands";
                    $res = Db::fetchall_Query($sql);
                    if ($res) {
                        die(json_encode($res));
                    } else {
                        die(Helper::Json_Message('f'));
                    }
                    break;
                case 'get_branches_list':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                                $sql = "SELECT id,name_sherkat FROM bnm_branch";
                                $res = Db::fetchall_Query($sql);
                                if ($res) {
                                    die(json_encode($res));
                                } else {
                                    die(Helper::Json_Message('f'));
                                }

                                break;
                            default:
                                die(Helper::Json_Message('na'));
                                break;
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }

                    break;
                case 'bs_getportoruser':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                                if ($_POST['request1'] === 'port') {
                                    $sql = "SELECT res.id,res.oss_id,res.port,res.resid,CONCAT(sub.name,' ',sub.f_name) 'name','port' AS 'target',
                                    IF(oss.telephone=1,sub.telephone1,IF(oss.telephone=2,sub.telephone2,IF(oss.telephone=3,sub.telephone3,'شماره ایی ثبت نشده'))) telephone
                                    FROM bnm_oss_reserves res
                                    INNER JOIN bnm_oss_subscribers oss ON res.oss_id= oss.id
                                    INNER JOIN bnm_subscribers sub ON oss.user_id=sub.id
                                    WHERE res.errcode = ?";
                                    $res = Db::secure_fetchall($sql, array(0));
                                } elseif ($_POST['request1'] === 'subscriber') {
                                    $sql = "SELECT oss.id,oss.oss_id,CONCAT(sub.name,' ',sub.f_name) 'name','sub' AS 'target',
                                    IF(oss.telephone=1,sub.telephone1,IF(oss.telephone=2,sub.telephone2,IF(oss.telephone=3,sub.telephone3,'شماره ایی ثبت نشده'))) telephone
                                    FROM bnm_oss_subscribers oss
                                    INNER JOIN bnm_subscribers sub ON oss.user_id=sub.id
                                    ";
                                    $res = Db::fetchall_Query($sql);
                                } else {
                                    die(json_encode(array(array('target' => 'none', 'name' => 'بدون هدف', 'id' => 'none', 'telephone' => ''))));
                                }
                                break;
                        }
                        if ($res) {
                            die(json_encode($res));
                        } else {
                            die(Helper::Json_Message('f'));
                        }
                    }
                    break;
                case 'bs_getreserverequests':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                                $sql = "SELECT sub.id id,sub.name name,sub.f_name f_name,res.id reserve_id,
                                if(oss.telephone=1,sub.telephone1,if(oss.telephone=2,sub.telephone2,if(oss.telephone=3,sub.telephone3,'شماره ایی ثبت نشده'))) telephone
                                FROM bnm_oss_reserves res
                                INNER JOIN bnm_oss_subscribers oss ON res.oss_id = oss.id
                                INNER JOIN bnm_subscribers sub ON oss.user_id = sub.id";
                                $res = Db::fetchall_Query($sql);
                                die(json_encode($res));
                                if ($res) {
                                    die(json_encode($res));
                                } else {
                                    die(Helper::Json_Message('f'));
                                }

                                break;
                            case __MODIRUSERTYPE__:
                            case __OPERATORUSERTYPE__:
                            case __MODIR2USERTYPE__:
                            case __OPERATOR2USERTYPE__:
                                $sql = "SELECT sub.id id,sub.name name,sub.f_name name,res.id reserve_id,
                                if(oss.telephone=1,sub.telephone1,if(oss.telephone=2,sub.telephone2,if(oss.telephone=3,sub.telephone3,'شماره ایی ثبت نشده'))) telephone
                                FROM bnm_oss_reserves res
                                INNER JOIN bnm_oss_subscribers oss ON res.oss_id = oss.id
                                INNER JOIN bnm_subscribers sub ON oss.user_id = sub.id
                                WHERE res.branch_id = ? AND sub.branch_id = ? AND oss.branch_id = ?";
                                $res = Db::secure_fetchall($sql, array($_SESSION['branch_id'], $_SESSION['branch_id'], $_SESSION['branch_id']), true);
                                if ($res) {
                                    die(json_encode($res));
                                } else {
                                    die(Helper::Json_Message('f'));
                                }

                                break;
                            default:
                                die(Helper::Json_Message('na'));
                                break;
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }

                    break;

                case 'bs_getosssubscribers':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                                $sql = "SELECT oss.id id, sub.name name,sub.f_name f_name,
                                if(oss.telephone=1,sub.telephone1,if(oss.telephone=2,sub.telephone2,if(oss.telephone=3,sub.telephone3,'شماره ایی ثبت نشده'))) telephone,
                                sub.code_meli code_meli FROM bnm_oss_subscribers oss LEFT JOIN bnm_subscribers sub ON oss.user_id=sub.id";
                                $res = Db::fetchall_Query($sql);
                                if ($res) {
                                    die(json_encode($res));
                                } else {
                                    die(Helper::Json_Message('f'));
                                }

                                break;
                            case __MODIRUSERTYPE__:
                            case __OPERATORUSERTYPE__:
                            case __MODIR2USERTYPE__:
                            case __OPERATOR2USERTYPE__:
                                $sql = "SELECT oss.id id, sub.name name,sub.f_name f_name,
                                if(oss.telephone=1,sub.telephone1,if(oss.telephone=2,sub.telephone2,if(oss.telephone=3,sub.telephone3,'شماره ایی ثبت نشده'))) telephone,
                                sub.code_meli code_meli FROM bnm_oss_subscribers oss LEFT JOIN bnm_subscribers sub ON oss.user_id=sub.id WHERE oss.branch_id = ? AND sub.branch_id =?";
                                $res = Db::secure_fetchall($sql, array($_SESSION['branch_id'], $_SESSION['branch_id']));
                                if ($res) {
                                    die(json_encode($res));
                                } else {
                                    die(Helper::Json_Message('f'));
                                }

                                break;
                            default:
                                die(Helper::Json_Message('na'));
                                break;
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }

                    break;
                case 'bs_getallsubscribers':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                                $sql = "SELECT id,name,f_name,code_meli FROM bnm_subscribers";
                                $res = Db::fetchall_Query($sql);
                                break;
                            case __MODIRUSERTYPE__:
                            case __OPERATORUSERTYPE__:
                            case __MODIR2USERTYPE__:
                            case __OPERATOR2USERTYPE__:
                                $sql = "SELECT id,name,f_name,code_meli FROM bnm_subscribers WHERE branch_id = ?";
                                $res = Db::secure_fetchall($sql, array($_SESSION['branch_id']), true);
                                break;
                            default:
                                die(Helper::Json_Message('na'));
                                break;
                        }
                        die(json_encode($res));
                        if ($res) {
                            die(json_encode($res));
                        } else {
                            die(Helper::Json_Message('f'));
                        }
                    } else {
                        die(Helper::Json_Message('test'));
                    }

                    break;
                case 'bs_get_telecenters':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                            case __MODIRUSERTYPE__:
                            case __OPERATORUSERTYPE__:
                            case __MODIR2USERTYPE__:
                            case __OPERATOR2USERTYPE__:
                                $res = $GLOBALS['bs']->getLocation();
                                if ($GLOBALS['bs']->errorCheck($res)) {
                                    die(json_encode($res['result']));
                                } else {
                                    die($GLOBALS['bs']->getMessage($res));
                                }

                                break;
                            default:
                                die(Helper::Json_Message('na'));
                                break;
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }

                    break;
                case 'internal_message_by_karbord':
                    $sql = "SELECT * FROM bnm_internal_messages WHERE karbord = ?";
                    $res = Db::secure_fetchall($sql, array($_POST['request1']));
                    if ($res) {
                        die(json_encode($res));
                    } else {
                        die(Helper::Json_Message('f'));
                    }

                    break;
                case 'internal_messages':
                    $sql = "SELECT * FROM bnm_internal_messages WHERE karbord=?";
                    $res = Db::secure_fetchall($sql, array('sms'));
                    if ($res) {
                        die(Json_encode($res));
                    } else {
                        die(Helper::Json_Message('f'));
                    }

                    break;
                case 'get_messages_list_shortend':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                                //$_POST = Helper::xss_check_array($_POST);
                                $sql = "SELECT id,LEFT(message,10) as message,message_subject FROM bnm_messages WHERE type= 1";
                                $res = Db::fetchall_Query($sql);
                                if ($res) {
                                    die(json_encode($res));
                                } else {
                                    die(Helper::Json_Message('f'));
                                }
                                break;
                            default:
                                die(Helper::Json_Message('af'));
                                break;
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }
                    break;
                case 'getassignedbanks':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                                //$_POST = Helper::xss_check_array($_POST);
                                $sql = "SELECT b.id , b.name, f.file_subject
                                FROM bnm_banks b
                                INNER JOIN bnm_upload_file f ON b.file_id = f.id
                                ";
                                $res = Db::fetchall_Query($sql);
                                if ($res) {
                                    die(json_encode($res));
                                } else {
                                    die(Helper::Json_Message('f'));
                                }
                                break;
                            default:
                                die(Helper::Json_Message('af'));
                                break;
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }
                    break;
                case 'add_to_bank_banklist':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                                //$_POST = Helper::xss_check_array($_POST);
                                $sql = "SELECT * FROM bnm_banks";
                                $res = Db::fetchall_Query($sql);
                                if ($res) {
                                    die(json_encode($res));
                                } else {
                                    die(Helper::Json_Message('f'));
                                }
                                break;
                            default:
                                die(Helper::Json_Message('af'));
                                break;
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }
                    break;
                case 'add_to_bank_filelist':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                                //$_POST = Helper::xss_check_array($_POST);
                                $sql = "SELECT * FROM bnm_upload_file WHERE file_type IN ('xlsx','csv')";
                                $res = Db::fetchall_Query($sql);
                                if ($res) {
                                    die(json_encode($res));
                                } else {
                                    die(Helper::Json_Message('f'));
                                }
                                break;
                            default:
                                die(Helper::Json_Message('af'));
                                break;
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }
                    break;
                case 'display_contract_by_id':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __MOSHTARAKUSERTYPE__:
                            case __ADMINUSERTYPE__:
                                $_POST = Helper::xss_check_array($_POST);
                                $sql = "SELECT * FROM bnm_services_contract WHERE id =?";
                                $res = Db::secure_fetchall($sql, array($_POST['request1']));
                                if ($res) {
                                    die(json_encode($res));
                                } else {
                                    die(Helper::Json_Message('f'));
                                }
                                break;
                            default:
                                die(Helper::Json_Message('af'));
                                break;
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }

                    break;
                case 'display_contract':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                            case __MOSHTARAKUSERTYPE__:
                                $sql = "SELECT * FROM bnm_services_contract";
                                $res = Db::fetchall_Query($sql);
                                if ($res) {
                                    die(json_encode($res));
                                } else {
                                    die(Helper::Json_Message('f'));
                                }
                                break;
                            default:
                                die(Helper::Json_Message('af'));
                                break;
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }

                    break;
                case 'services_contract':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                                $sql = "SELECT * FROM bnm_services GROUP BY type";
                                $res = Db::fetchall_Query($sql);
                                if ($res) {
                                    die(json_encode($res));
                                } else {
                                    die(Helper::Json_Message('f'));
                                }

                                break;
                            default:
                                die(Helper::Json_Message('af'));
                                break;
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }

                    break;
                case 'personal_information':
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                        case __MODIRUSERTYPE__:
                        case __OPERATORUSERTYPE__:
                        case __MODIR2USERTYPE__:
                        case __OPERATOR2USERTYPE__:
                            die(Helper::Json_Message('af'));
                            break;
                        case __MOSHTARAKUSERTYPE__:
                            $sql = "SELECT * FROM bnm_subscribers WHERE id=?";
                            $result = Db::secure_fetchall($sql, array($_SESSION['user_id']));
                            if ($result) {
                                die(json_encode($result));
                            } else {
                                die(Helper::Json_Message('sint'));
                            }

                            break;
                        default:
                            die(Helper::Json_Message('af'));
                            break;
                    }
                    break;
                case 'change_service_password':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                                $sql = "SELECT id,ibs_username,
                                IF(type IN ('adsl','vdsl','wireless','tdlte'),'internet',
                                IF(type IN ('voip'),'voip','notfound')) as 'type' FROM bnm_factor WHERE ibs_username<>'' AND ibs_username IS NOT NULL
                                AND type <>'' AND type IS NOT NULL AND tasvie_shode = ?
                                GROUP BY ibs_username,type";
                                $result = Db::secure_fetchall($sql, array(1));
                                if ($result) {
                                    die(json_encode($result));
                                } else {
                                    die(Helper::Json_Message('f'));
                                }
                                break;
                            case __MODIRUSERTYPE__:
                            case __OPERATORUSERTYPE__:
                            case __MODIR2USERTYPE__:
                            case __OPERATOR2USERTYPE__:
                                $sql = "SELECT id,ibs_username,
                                IF(type IN ('adsl','vdsl','wireless','tdlte'),'internet',
                                IF(type IN ('voip'),'voip','notfound')) as 'type' FROM bnm_factor WHERE ibs_username<>'' AND ibs_username IS NOT NULL
                                AND type <>'' AND type IS NOT NULL
                                AND branch_id=? AND tasvie_shode = ?
                                GROUP BY ibs_username,type";
                                $result = Db::secure_fetchall($sql, array($_SESSION['branch_id'], 1));
                                if ($result) {
                                    die(json_encode($result));
                                } else {
                                    die(Helper::Json_Message('f'));
                                }
                                break;
                            case __MOSHTARAKUSERTYPE__:
                                $sql = "SELECT id,ibs_username,
                                IF(type IN ('adsl','vdsl','wireless','tdlte'),'internet',
                                IF(type IN ('voip'),'voip','notfound')) as 'type' FROM bnm_factor WHERE subscriber_id=? AND branch_id=? AND ibs_username<>'' AND ibs_username IS NOT NULL
                                AND type <>'' AND type IS NOT NULL AND tasvie_shode = ?
                                GROUP BY ibs_username,type";
                                $result = Db::secure_fetchall($sql, array($_SESSION['user_id'], $_SESSION['branch_id'], 1));
                                if ($result) {
                                    die(json_encode($result));
                                } else {
                                    die(Helper::Json_Message('f'));
                                }
                                break;

                            default:
                                die(Helper::Json_Message('af'));
                                break;
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }

                    break;
                case 'support_requests_compose':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:

                                die(Helper::Json_Message('no_access'));
                                break;
                            case __MODIRUSERTYPE__:
                            case __OPERATORUSERTYPE__:
                            case __MODIR2USERTYPE__:
                            case __OPERATOR2USERTYPE__:
                            case __MOSHTARAKUSERTYPE__:
                                //1=poshtibani
                                //2=sla
                                //3=jam avari
                                //4=sayer
                                $noe_darkhast = array();
                                array_push($noe_darkhast, '1');
                                array_push($noe_darkhast, '2');
                                array_push($noe_darkhast, '3');
                                array_push($noe_darkhast, '4');
                                die(json_encode($noe_darkhast));
                                break;
                            default:
                                die(Helper::Json_Message('af'));
                                break;
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }

                    break;

                // case 'restrictions_menu':
                //     if (Helper::Login_Just_Check()) {
                //         switch ($_SESSION['user_type']) {
                //             case __ADMINUSERTYPE__:
                //                 $sql    = "select * from bnm_dashboard_menu";
                //                 $result = Db::fetchall_Query($sql);
                //                 die(json_encode($result));
                //                 break;
                //             case __MODIRUSERTYPE__:
                //                 $where_menu_ids = "";
                //                 $menu_access    = Db::secure_fetchall("SELECT * FROM bnm_dashboard_menu_access WHERE operator_id = ?", array($_SESSION['user_id']));
                //                 if ($menu_access) {
                //                     for ($i = 0; $i < count($menu_access); $i++) {
                //                         if ($i == count($menu_access) - 1) {
                //                             $where_menu_ids .= $menu_access[$i]['menu_id'];
                //                         } else {
                //                             $where_menu_ids .= $menu_access[$i]['menu_id'] . ',';
                //                         }
                //                     }
                //                     $dashboard_access_list = Db::fetchall_Query("SELECT * FROM bnm_dashboard_menu WHERE id IN ($where_menu_ids)");
                //                     if ($dashboard_access_list) {
                //                         die(json_encode($dashboard_access_list));
                //                     } else {
                //                         die(Helper::Json_Message('f'));
                //                     }

                //                 } else {
                //                     die(Helper::Json_Message('f'));
                //                 }

                //                 break;
                //             case __MODIR2USERTYPE__:
                //                 $where_menu_ids = "";
                //                 $menu_access    = Db::secure_fetchall("SELECT * FROM bnm_dashboard_menu_access WHERE operator_id = ?", array($_SESSION['user_id']));
                //                 if ($menu_access) {
                //                     for ($i = 0; $i < count($menu_access); $i++) {
                //                         if ($i == count($menu_access) - 1) {
                //                             $where_menu_ids .= $menu_access[$i]['menu_id'];
                //                         } else {
                //                             $where_menu_ids .= $menu_access[$i]['menu_id'] . ',';
                //                         }
                //                     }
                //                     $dashboard_access_list = Db::fetchall_Query("SELECT * FROM bnm_dashboard_menu WHERE id IN ($where_menu_ids)");
                //                     if ($dashboard_access_list) {
                //                         die(json_encode($dashboard_access_list));
                //                     } else {
                //                         die(Helper::Json_Message('f'));
                //                     }

                //                 } else {
                //                     die(Helper::Json_Message('f'));
                //                 }

                //                 break;
                //             case __ADMINOPERATORUSERTYPE__:
                //                 $where_menu_ids = "";
                //                 $menu_access    = Db::secure_fetchall("SELECT * FROM bnm_dashboard_menu_access WHERE operator_id = ?", array($_SESSION['user_id']));
                //                 if ($menu_access) {
                //                     for ($i = 0; $i < count($menu_access); $i++) {
                //                         if ($i == count($menu_access) - 1) {
                //                             $where_menu_ids .= $menu_access[$i]['menu_id'];
                //                         } else {
                //                             $where_menu_ids .= $menu_access[$i]['menu_id'] . ',';
                //                         }
                //                     }
                //                     $dashboard_access_list = Db::fetchall_Query("SELECT * FROM bnm_dashboard_menu WHERE id IN ($where_menu_ids)");
                //                     if ($dashboard_access_list) {
                //                         die(json_encode($dashboard_access_list));
                //                     } else {
                //                         die(Helper::Json_Message('f'));
                //                     }

                //                 } else {
                //                     die(Helper::Json_Message('f'));
                //                 }

                //                 break;
                //             default:
                //                 die(Helper::Json_Message('af'));
                //                 break;
                //         }
                //     } else {
                //         die(Helper::Json_Message('af'));
                //     }

                // break;
                case 'restrictions_initialize':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                                $sql = "SELECT id,name_sherkat,baladasti_id FROM bnm_branch";
                                $res = Db::fetchall_Query($sql);

                                break;
                            case __ADMINOPERATORUSERTYPE__:
                                $sql = "SELECT id,name_sherkat,baladasti_id FROM bnm_branch";
                                $res = Db::fetchall_Query($sql);
                                break;
                            case __MODIRUSERTYPE__:
                            case __MODIR2USERTYPE__:
                                $sql = "SELECT id,name_sherkat,baladasti_id FROM bnm_branch WHERE branch_id = ?";
                                $res = Db::secure_fetchall($sql, array($_SESSION['branch_id']), true);
                                break;
                        }
                        if ($res) {
                            die(json_encode($res));
                        } else {
                            die(Helper::Json_Message('f'));
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }

                    break;
                case 'restrictions_getoperatorsbybranch':
                    // die(json_encode(array('asd')));
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                            $sql = "SELECT o.id operator_id,o.name name,o.name_khanevadegi name_khandevadegi,o.user_type,b.id branch_id,b.name_sherkat,
                            CASE
                                WHEN o.user_type = " . __MODIRUSERTYPE__ . " OR o.user_type = " . __MODIR2USERTYPE__ . " THEN 'مدیر'
                                WHEN o.user_type = " . __OPERATORUSERTYPE__ . " OR o.user_type = " . __OPERATOR2USERTYPE__ . " THEN 'اپراتور'
                                END as user_type_fa
                            FROM bnm_branch b
                            INNER JOIN bnm_operator o ON o.branch_id = b.id
                            WHERE b.id= ? AND o.branch_id IS NOT NULL
                            ";
                            $result = Db::secure_fetchall($sql, array($_POST['request1']));
                            // $sql = "SELECT buser.id as id,boperator.name as name,boperator.name_khanevadegi as name_khanevadegi,bbranch.name_sherkat as name_sherkat
                            //             FROM bnm_users buser
                            //               INNER JOIN bnm_operator boperator ON buser.user_id = boperator.id
                            //               INNER JOIN bnm_branch bbranch ON boperator.branch_id = bbranch.id
                            //             WHERE
                            //                 buser.user_type IN (?,?) AND boperator.user_type IN (?,?)";
                            // $result = Db::secure_fetchall($sql, array(__OPERATORUSERTYPE__,__OPERATOR2USERTYPE__,__OPERATORUSERTYPE__,__OPERATOR2USERTYPE__), true);

                            break;
                        case __MODIRUSERTYPE__:
                            $sql = "SELECT o.id operator_id,o.name name,o.name_khanevadegi name_khandevadegi,o.user_type,b.id branch_id,b.name_sherkat,
                            CASE
                                WHEN o.user_type = " . __OPERATORUSERTYPE__ . " OR o.user_type = " . __OPERATOR2USERTYPE__ . " THEN 'اپراتور'
                                END as user_type_fa
                            FROM bnm_branch b
                            INNER JOIN bnm_operator o ON o.branch_id = b.id
                            WHERE b.id= ? AND o.branch_id IS NOT NULL AND o.branch_id = ?
                            AND o.user_type <> ? AND o.user_type <> ? AND o.id <> ?
                            ";
                            $result = Db::secure_fetchall($sql, array($_POST['request1'], $_SESSION['branch_id'], __MODIRUSERTYPE__, __MODIR2USERTYPE__, $_SESSION['user_id']));
                            // $sql = "SELECT buser.id as id,boperator.name as name,boperator.name_khanevadegi as name_khanevadegi,bbranch.name_sherkat as name_sherkat
                            //             FROM bnm_users buser
                            //               INNER JOIN bnm_operator boperator ON buser.user_id = boperator.id
                            //               INNER JOIN bnm_branch bbranch ON boperator.branch_id = bbranch.id
                            //             WHERE
                            //                 buser.user_type IN (?) AND boperator.user_type IN (?) AND bbranch.branch_id = ? AND boperator.branch_id = ? AND buser.branch_id = ?";
                            // $result = Db::secure_fetchall($sql, array(__OPERATORUSERTYPE__,__OPERATORUSERTYPE__,$_SESSION['branch_id'],$_SESSION['branch_id'],$_SESSION['branch_id'],), true);
                            break;
                        case __MODIR2USERTYPE__:
                            $sql = "SELECT o.id operator_id,o.name name,o.name_khanevadegi name_khandevadegi,o.user_type,b.id branch_id,b.name_sherkat,
                            CASE
                                WHEN o.user_type = " . __OPERATORUSERTYPE__ . " OR o.user_type = " . __OPERATOR2USERTYPE__ . " THEN 'اپراتور'
                                END as user_type_fa
                            FROM bnm_branch b
                            INNER JOIN bnm_operator o ON o.branch_id = b.id
                            WHERE b.id= ? AND o.branch_id IS NOT NULL AND o.branch_id = ?
                            AND o.user_type <> ? AND o.user_type <> ? AND o.id <> ?
                            ";
                            $result = Db::secure_fetchall($sql, array($_POST['request1'], $_SESSION['branch_id'], __MODIR2USERTYPE__, __MODIRUSERTYPE__, $_SESSION['user_id']));
                            // $sql = "SELECT buser.id as id,boperator.name as name,boperator.name_khanevadegi as name_khanevadegi,bbranch.name_sherkat as name_sherkat
                            //             FROM bnm_users buser
                            //               INNER JOIN bnm_operator boperator ON buser.user_id = boperator.id
                            //               INNER JOIN bnm_branch bbranch ON boperator.branch_id = bbranch.id
                            //             WHERE
                            //                 buser.user_type IN (?) AND boperator.user_type IN (?) AND bbranch.branch_id = ? AND boperator.branch_id = ? AND buser.branch_id = ?";
                            // $result = Db::secure_fetchall($sql, array(__OPERATOR2USERTYPE__,__OPERATOR2USERTYPE__,$_SESSION['branch_id'],$_SESSION['branch_id'],$_SESSION['branch_id'],), true);
                            break;
                        default:
                            die(Helper::Json_Message('af'));
                            break;
                    }
                    if ($result) {
                        die(json_encode($result));
                    } else {
                        die(Helper::Json_Message('f'));
                    }

                    break;
                case 'credits_page_initialize':
                    if (Helper::Login_Just_Check()) {
                        die(Helper::Json_Message('af'));
                        // switch ($_SESSION['user_type']) {
                        //     case '1':
                        //         #admin

                        //         break;
                        //     case '2':
                        //         #modir
                        //         break;
                        //     case '3':
                        //         #modir-operator
                        //         break;
                        //     case '4':
                        //         #subscriber
                        //         break;

                        //     default:
                        //         die(Helper::Json_Message('auth_fail'));
                        //         break;
                        // }
                    } else {
                        die(Helper::Json_Message('auth_fail'));
                    }
                    break;
                case 'factor_modify':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                                $sql = "SELECT * FROM bnm_factor";
                                $res = Db::fetchall_Query($sql);
                                if ($res) {
                                    die(json_encode($res));
                                } else {
                                    die(Helper::Json_Message('f'));
                                }

                                break;
                            case __MODIRUSERTYPE__:
                            case __OPERATORUSERTYPE__:
                            case __MODIR2USERTYPE__:
                            case __OPERATOR2USERTYPE__:
                            case __MOSHTARAKUSERTYPE__:
                                $sql = "SELECT * FROM bnm_factor WHERE branch_id=?";
                                $res = Db::secure_fetchall($sql, array($_SESSION['branch_id']));
                                if ($res) {
                                    die(json_encode($res));
                                } else {
                                    die(Helper::Json_Message('f'));
                                }

                                break;

                            default:
                                die(Helper::Json_Message('af'));
                                break;
                        }
                    }

                    break;
                case 'ostan':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                                $sql = "SELECT * FROM bnm_countries";
                                $res = Db::fetchall_Query($sql);
                                die(json_encode($res));
                                break;
                            default:
                                die(Helper::Json_Message('af'));
                                break;
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }

                    break;
                case 'city':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                                $sql = "SELECT * FROM bnm_shahr";
                                $res = Db::fetchall_Query($sql);
                                die(json_encode($res));
                                break;
                            default:
                                die(Helper::Json_Message('af'));
                                break;
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }

                    break;
                case 'get_dist_services_list':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                                $sql = "SELECT id,type,noe_khadamat FROM bnm_services GROUP BY noe_khadamat";
                                $res = Db::fetchall_Query($sql);

                                die(json_encode($res));

                                break;
                            default:
                                die(Helper::Json_Message('na'));
                                break;
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }

                    break;
                case 'restrictions_menu_initialize':
                    if (Helper::Login_Just_Check()) {
                        unset($_POST["restrictions_menu_initialize"]);
                        $_POST = Helper::xss_check_array($_POST);
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                                $sql = "SELECT o.id,o.name,o.name_khanevadegi,o.branch_id,o.user_type,b.baladasti_id baladasti_id
                                FROM bnm_operator o
                                INNER JOIN bnm_branch b ON o.branch_id = b.id
                                WHERE o.id= ?";
                                $res1 = Db::secure_fetchall($sql, array($_POST['request1']));
                                if ($res1) {
                                    if ($res1[0]['baladasti_id'] === 0) {
                                        //namayande sathe 1
                                        $sql = "SELECT d.id, d.fa_name , d.en_name, d.category_id cat_id,c.name,c.sort
                                        FROM bnm_dashboard_menu d
                                        INNER JOIN bnm_dashboard_menu_category c
                                        ON d.category_id = c.id
                                        WHERE d.branch_display = ? ORDER BY c.sort";
                                        $res_menu = Db::secure_fetchall($sql, array(1));
                                    } else {
                                        //namayande sathe 2
                                        $sql = "SELECT d.id, d.fa_name , d.en_name, d.category_id cat_id,c.name,c.sort
                                        FROM bnm_dashboard_menu d
                                        INNER JOIN bnm_dashboard_menu_category c
                                        ON d.category_id = c.id
                                        WHERE d.branch_display = ? ORDER BY c.sort";
                                        $res_menu = Db::secure_fetchall($sql, array(1));
                                    }
                                    if ($res_menu) {
                                    } else {
                                        die(Helper::Custom_Msg(Helper::Messages('f')));
                                    }
                                } else {
                                    die(Helper::Json_Message('f'));
                                }
                                // $sql="SELECT * FROM bnm_dashboard_menu_access";

                                // $sql="SELECT id,branch_id,user_type FROM bnm_users WHERE id = ? AND user_type IN (?,?,?)";
                                // $res1=Db::secure_fetchall($sql,array($_POST['request1'],__ADMINOPERATORUSERTYPE__,__OPERATOR2USERTYPE__,__OPERATORUSERTYPE__),true);
                                // if($res1){
                                //     switch ($res1[0]['user_type']){
                                //         case __ADMINOPERATORUSERTYPE__:
                                //             //$sql="SELECT id,en_name,fa_name,category_id,sort FROM bnm_dashboard_menu WHERE admin_display = ?";
                                //             $sql="SELECT m.id,m.en_name,m.fa_name,c.id,c.name cat_name,c.sort cat_sort
                                //                 FROM bnm_dashboard_menu m
                                //                 LEFT JOIN bnm_dashboard_menu_category c ON m.category_id = c.id
                                //                 WHERE m.admin_display = ? AND m.id <> ? ORDER BY c.sort";
                                //             $res=Db::secure_fetchall($sql, array(1,__DASHBOARDID__), true);
                                //         break;
                                //         case __OPERATORUSERTYPE__:
                                //             $sql="SELECT m.id,m.en_name,m.fa_name,c.id,c.name cat_name,c.sort cat_sort
                                //                 FROM bnm_dashboard_menu m
                                //                 LEFT JOIN bnm_dashboard_menu_category c ON m.category_id = c.id
                                //                 WHERE m.branch_display = ? AND m.id <> ? ORDER BY c.sort";
                                //             $res=Db::secure_fetchall($sql, array(1,__DASHBOARDID__), true);
                                //         break;
                                //         case __OPERATOR2USERTYPE__:
                                //             $sql="SELECT m.id,m.en_name,m.fa_name,c.id,c.name cat_name,c.sort cat_sort
                                //                 FROM bnm_dashboard_menu m
                                //                 LEFT JOIN bnm_dashboard_menu_category c ON m.category_id = c.id
                                //                 WHERE m.branch2_display = ? AND m.id <> ? ORDER BY c.sort";
                                //             $res=Db::secure_fetchall($sql, array(1,__DASHBOARDID__), true);
                                //         break;
                                //         default:
                                //             die(Helper::Json_Message('na'));
                                //         break;
                                //     }
                                //     if($res){
                                //         die(json_encode($res));
                                //     }else{
                                //         die(Helper::Json_Message('f'));
                                //     }
                                // }else{
                                //     die(Helper::Json_Message('f'));
                                // }
                                break;
                            case __MODIRUSERTYPE__:
                                $sql = "SELECT o.id,o.name,o.name_khanevadegi,o.branch_id,o.user_type,b.baladasti_id baladasti_id
                                FROM bnm_operator o
                                INNER JOIN bnm_branch b ON o.branch_id = b.id
                                WHERE o.id= ? AND o.id <> ? AND o.branch_id = ? AND o.user_type = ?";
                                $res1 = Db::secure_fetchall($sql, array($_POST['request1'], $_SESSION['user_id'], $_SESSION['branch_id'], __OPERATORUSERTYPE__));
                                if ($res1) {
                                    if ($res1[0]['baladasti_id'] === 0) {
                                        //namayande sathe 1
                                        $sql = "SELECT d.id, d.fa_name , d.en_name, d.category_id cat_id,c.name,c.sort
                                        FROM bnm_dashboard_menu d
                                        INNER JOIN bnm_dashboard_menu_category c
                                        ON d.category_id = c.id
                                        WHERE d.branch_display = ? ORDER BY c.sort";
                                        $res_menu = Db::secure_fetchall($sql, array(1));
                                    } else {
                                        //namayande sathe 2
                                        $sql = "SELECT d.id, d.fa_name , d.en_name, d.category_id cat_id,c.name,c.sort
                                        FROM bnm_dashboard_menu d
                                        INNER JOIN bnm_dashboard_menu_category c
                                        ON d.category_id = c.id
                                        WHERE d.branch_display = ? ORDER BY c.sort";
                                        $res_menu = Db::secure_fetchall($sql, array(1));
                                    }
                                } else {
                                    die(Helper::Json_Message('f'));
                                }
                                break;
                            case __MODIR2USERTYPE__:
                                $sql = "SELECT o.id,o.name,o.name_khanevadegi,o.branch_id,o.user_type,b.baladasti_id baladasti_id
                                FROM bnm_operator o
                                INNER JOIN bnm_branch b ON o.branch_id = b.id
                                WHERE o.id= ? AND o.id <> ? AND o.branch_id = ? AND o.user_type = ?";
                                $res1 = Db::secure_fetchall($sql, array($_POST['request1'], $_SESSION['user_id'], $_SESSION['branch_id'], __OPERATOR2USERTYPE__));
                                if ($res1) {
                                    if ($res1[0]['baladasti_id'] === 0) {
                                        //namayande sathe 1
                                        $sql = "SELECT d.id, d.fa_name , d.en_name, d.category_id cat_id,c.name,c.sort
                                        FROM bnm_dashboard_menu d
                                        INNER JOIN bnm_dashboard_menu_category c
                                        ON d.category_id = c.id
                                        WHERE d.branch_display = ? ORDER BY c.sort";
                                        $res_menu = Db::secure_fetchall($sql, array(1));
                                    } else {
                                        //namayande sathe 2
                                        $sql = "SELECT d.id, d.fa_name , d.en_name, d.category_id cat_id,c.name,c.sort
                                        FROM bnm_dashboard_menu d
                                        INNER JOIN bnm_dashboard_menu_category c
                                        ON d.category_id = c.id
                                        WHERE d.branch2_display = ? ORDER BY c.sort";
                                        $res_menu = Db::secure_fetchall($sql, array(1));
                                    }
                                } else {
                                    die(Helper::Json_Message('f'));
                                }
                                break;
                            default:
                                die(Helper::Json_Message('na'));
                                break;
                        }
                        if ($res_menu) {
                            die(json_encode($res_menu));
                        } else {
                            die(Helper::Custom_Msg(Helper::Messages('f')));
                        }
                    } else {
                        die(Helper::Json_Message('f'));
                    }
                    break;
                case 'dashboard_menu_group_access_current_access_list':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                                unset($_POST["dashboard_menu_group_access_current_access_list"]);
                                $_POST = Helper::xss_check_array($_POST);
                                if (Helper::Is_Empty_OR_Null($_POST['request1'])) {
                                    switch ($_POST['request1']) {
                                        case '1':
                                            $sql = "SELECT id FROM bnm_dashboard_menu WHERE admin_display=?";
                                            $res = Db::secure_fetchall($sql, array(1));
                                            if ($res) {
                                                die(json_encode($res));
                                            } else {
                                                die(json_encode(array()));
                                            }
                                            break;
                                        case '2':
                                            $sql = "SELECT id FROM bnm_dashboard_menu WHERE branch_display=?";
                                            $res = Db::secure_fetchall($sql, array(1));
                                            if ($res) {
                                                die(json_encode($res));
                                            } else {
                                                die(json_encode(array()));
                                            }
                                            break;
                                        case '3':
                                            $sql = "SELECT id FROM bnm_dashboard_menu WHERE branch2_display=?";
                                            $res = Db::secure_fetchall($sql, array(1));
                                            if ($res) {
                                                die(json_encode($res));
                                            } else {
                                                die(json_encode(array()));
                                            }
                                            break;
                                        case '4':
                                            $sql = "SELECT id FROM bnm_dashboard_menu WHERE admin_operator_display=?";
                                            $res = Db::secure_fetchall($sql, array(1));
                                            if ($res) {
                                                die(json_encode($res));
                                            } else {
                                                die(json_encode(array()));
                                            }
                                            break;
                                        case '5':
                                            $sql = "SELECT id FROM bnm_dashboard_menu WHERE subscriber_display=?";
                                            $res = Db::secure_fetchall($sql, array(1));
                                            if ($res) {
                                                die(json_encode($res));
                                            } else {
                                                die(json_encode(array()));
                                            }
                                            break;

                                        default:
                                            die(Helper::Json_Message('rinf'));
                                            break;
                                    }
                                }
                            default:
                                die(Helper::Json_Message('test2'));
                                break;
                        }
                    } else {
                        die(Helper::Json_Message('test1'));
                    }

                    break;
                case 'dashboard_menu_group_access':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                                $sql = "SELECT * FROM bnm_dashboard_menu";
                                $res = Db::fetchall_Query($sql);
                                die(json_encode($res));
                                break;
                            default:
                                die(Helper::Json_Message('af'));
                                break;
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }

                    break;

                default:
                    die(Helper::Json_Message('f'));
                    break;
            }
        }
        /*==========edit form============*/
        if (isset($_POST['Edit_Form'])) {
            $page = $_POST['Edit_Form'];
            switch ($page) {
                case 'ip_pool_list':
                    if (Helper::check_update_access('ip_pool_list')) {
                        $sql = "SELECT * FROM bnm_ip_pool_list WHERE id=?";
                        $result = Db::secure_fetchall($sql, array($_POST['condition']));
                        if ($result) {
                            $result = json_encode($result);
                            die($result);
                        } else {
                            die(Helper::Json_Message('f'));
                        }

                    } else {
                        die(Helper::Json_Message('na'));
                    }

                    break;
                case 'equipments_models':
                    if (Helper::check_update_access('equipments_models')) {
                        $sql = "SELECT * FROM bnm_equipments_models WHERE id=?";
                        $result = Db::secure_fetchall($sql, array($_POST['condition']));
                        if ($result) {
                            $result = json_encode($result);
                            die($result);
                        } else {
                            die(Helper::Json_Message('f'));
                        }

                    } else {
                        die(Helper::Json_Message('na'));
                    }

                    break;
                case 'equipments_brands':
                    if (Helper::check_update_access('equipments_brands')) {
                        $sql = "SELECT * FROM bnm_equipments_brands WHERE id=?";
                        $result = Db::secure_fetchall($sql, array($_POST['condition']));
                        if ($result) {
                            $result = json_encode($result);
                            die($result);
                        } else {
                            die(Helper::Json_Message('f'));
                        }

                    } else {
                        die(Helper::Json_Message('na'));
                    }

                    break;
                case 'messages':
                    if (Helper::check_update_access('messages')) {
                        $sql = "SELECT * FROM bnm_messages WHERE id=?";
                        $result = Db::secure_fetchall($sql, array($_POST['condition']));
                        $rows = json_encode($result);
                        die($rows);
                    } else {
                        die(Helper::Json_Message('na'));
                    }

                    break;
                case 'banks':
                    $sql = "SELECT * FROM bnm_banks WHERE id=?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'services_contract':
                    $sql = "SELECT * FROM bnm_services_contract WHERE id=?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'organization_level':
                    $sql = "SELECT * FROM bnm_organization_level WHERE id= ?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'branch_cooperation_type':
                    $sql = "SELECT * FROM bnm_branch_cooperation_type WHERE id=?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'pre_number':
                    $sql = "SELECT * FROM bnm_pre_number WHERE id=?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $markaz_id = $result[0]["markaze_mokhaberati"];
                    $sql2 = "SELECT name FROM bnm_telecommunications_center WHERE id = ?";
                    $result2 = Db::secure_fetchall($sql2, array($markaz_id));
                    $result[0]['markaz_name'] = $result2[0]['name'];
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'modir':
                    $sql = "SELECT * FROM bnm_operator WHERE id=? AND user_type=?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition'], __MODIRUSERTYPE__), true);
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'noe_terminal':
                    $sql = "SELECT * FROM bnm_noe_terminal WHERE id=?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'services_voip':
                    $sql = "SELECT * FROM bnm_services WHERE id=?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'equipments_brands':
                    if (Helper::check_update_access('equipments_brands')) {
                        $sql = "SELECT * FROM equipments_brands WHERE id= ?";
                        $result = Db::secure_fetchall($sql, array($_POST['condition']));
                        $rows = json_encode($result);
                        die($rows);
                    } else {
                        die(Helper::Json_Message('na'));
                    }

                    break;
                case 'countries':
                    $sql = "SELECT * FROM bnm_countries WHERE id=?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'ostan':

                    $sql = "SELECT bo.id,bo.name,bo.pish_shomare_ostan,bo.code_ostan_shahkar,bo.code_markazeostan,
                        bo.code_atrafemarkazeostan,bo.code_biaban,bo.code_shahrestan,bo.code_atrafeshahrestan,bc.id c_id,
                        bc.name c_name
                        FROM bnm_ostan bo
                        LEFT JOIN bnm_countries bc ON bo.country_id = bc.id
                        WHERE bo.id= ? ";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'connection_log_postfix':
                    $sql = "SELECT * FROM bnm_connection_log WHERE id=?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'tax':
                    $sql = "SELECT * FROM bnm_tax WHERE id=?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'services_bs':
                    $sql = "SELECT * FROM bnm_services WHERE id=?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'services_adsl':
                    $sql = "SELECT * FROM bnm_services WHERE id=?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'services_wireless':
                    $sql = "SELECT * FROM bnm_services WHERE id=?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'services_tdlte':
                    $sql = "SELECT * FROM bnm_services WHERE id=?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'real_subscribers':
                    $sql = "SELECT s.*,c.id as city_id,c.name city_name,o.id ostan_id , o.name ostan_name FROM bnm_subscribers s
                    LEFT JOIN bnm_shahr c ON s.shahre_tavalod = c.id
                    LEFT JOIN bnm_ostan o ON s.ostane_tavalod = o.id
                    WHERE s.id= ? ";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    if ($result) {
                        die(json_encode($result));
                    } else {
                        die(Helper::Json_Message('f'));
                    }

                    break;
                case 'legal_subscribers':
                    $sql = "SELECT s.*,c.id as city_id,c.name city_name,o.id ostan_id , o.name ostan_name FROM bnm_subscribers s
                    LEFT JOIN bnm_shahr c ON s.shahre_tavalod = c.id
                    LEFT JOIN bnm_ostan o ON s.ostane_tavalod = o.id
                    WHERE s.id= ? ";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    if ($result) {
                        die(json_encode($result));
                    } else {
                        die(Helper::Json_Message('f'));
                    }

                    break;
                case 'city':
                    $sql = "SELECT * FROM bnm_shahr WHERE id=?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'wireless_ap':
                    $sql = "SELECT * FROM bnm_wireless_ap WHERE id = ?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'wireless_station':
                    $sql = "SELECT st.*,CONCAT(sub.name, ' ' ,sub.f_name) subname FROM bnm_wireless_station st
                        LEFT JOIN bnm_subscribers sub ON st.subscriber_id = sub.id
                        WHERE st.id = ?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'popsite':
                    $sql = "SELECT * FROM bnm_popsite WHERE id=?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'host':
                    $sql = "SELECT * FROM bnm_host WHERE id=?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'port':
                    $sql = "SELECT * FROM bnm_port WHERE id=?";
                    $result = Db::fetchall_Query($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'branch':
                    $sql = "SELECT * FROM bnm_branch WHERE id= ?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'tdlte_sim':
                    $sql = "SELECT * FROM bnm_tdlte_sim WHERE id= ?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'operator':
                    $sql = "SELECT * FROM bnm_operator WHERE id= ?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'telecommunications_center':
                    $sql = "SELECT * FROM bnm_telecommunications_center WHERE id=?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
            }
        }
        /*==========hard delete============*/
        if (isset($_POST['harddelete'])) {
            $target = $_POST['target'];
            switch ($target) {
                case 'ip_pool_list':
                    if (Helper::check_delete_access('ip_pool_list')) {
                        $result = Db::secure_delete("DELETE FROM bnm_ip_pool_list WHERE id =:id", $_POST['harddelete']);
                        if ($result) {
                            die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                        } else {
                            die(Helper::Json_Message('f'));
                        }

                    } else {
                        echo Helper::Json_Message('na');
                    }

                    break;
                case 'equipments_models':
                    if (Helper::check_delete_access('equipments_models')) {
                        $result = Db::secure_delete("DELETE FROM bnm_equipments_models WHERE id =:id", $_POST['harddelete']);
                        if ($result) {
                            die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                        } else {
                            die(Helper::Json_Message('f'));
                        }

                        // $result = Db::justexecute($sql);
                    } else {
                        echo Helper::Json_Message('na');
                    }

                    break;
                case 'equipments_brands':
                    if (Helper::check_delete_access('equipments_brands')) {
                        $id = $_POST['harddelete'];
                        $sql = "delete FROM bnm_equipments_brands WHERE id=$id";
                        $result = Db::justexecute($sql);
                    } else {
                        die(Helper::Json_Message('na'));
                    }

                    break;
                case 'branch_cooperation_type':
                    if (Helper::check_delete_access('branch_cooperation_type')) {
                        $id = $_POST['harddelete'];
                        $sql = "delete FROM bnm_branch_cooperation_type WHERE id=$id";
                        $result = Db::justexecute($sql);
                    } else {
                        echo Helper::Alert_Message('na');
                    }

                    break;
                case 'messages':
                    if (Helper::check_delete_access('messages')) {
                        $sql = "delete FROM bnm_messages WHERE id= :id";
                        $result = Db::secure_delete($sql, $_POST['harddelete']);
                        if ($result) {
                            die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                        } else {
                            die(Helper::Json_Message('f'));
                        }

                    } else {
                        echo Helper::Alert_Message('na');
                    }

                    break;
                case 'services_contract':

                    $id = $_POST['harddelete'];
                    $sql = "delete FROM bnm_banks WHERE id=$id";
                    $result = Db::justexecute($sql);
                    break;
                case 'city':
                    if (Helper::check_delete_access('city')) {
                        $id = $_POST['harddelete'];
                        $sql = "delete FROM bnm_shahr WHERE id = $id";
                        $result = Db::justexecute($sql);

                        if ($result) {
                            die(json_encode(array($result)));
                        } else {
                            die(false);
                        }
                    } else {
                        echo Helper::Alert_Message('na');
                    }

                    break;
                case 'tdlte_sim':
                    if (Helper::check_delete_access('tdlte_sim')) {
                        $id = $_POST['harddelete'];
                        $sql = "delete FROM bnm_tdlte_sim WHERE id = $id";
                        $result = Db::justexecute($sql);
                        if ($result) {
                            die(json_encode(true));
                        } else {
                            die(json_encode(false));
                        }
                    } else {
                        echo Helper::Alert_Message('na');
                    }

                    break;
                case 'modir':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                                //get modir info
                                if (Helper::check_delete_access('modir')) {
                                    $res_modir = Helper::Select_By_Id('bnm_operator', array('id' => $id, 'user_type' => __MODIRUSERTYPE__));
                                    if ($res_modir) {
                                        //update modir info
                                        $arr = array();
                                        $arr['id'] = $res_modir[0]['id'];
                                        $arr['panel_status'] = '2';
                                        $sql = Helper::Update_Generator($arr, 'bnm_operator', 'WHERE id= :id');
                                        $res = Db::secure_update_array($sql, $arr, true);
                                        //get user info of modir
                                        $sql = "SELECT * FROM bnm_users WHERE user_id = ? AND user_type=?";
                                        $res_user = Db::secure_fetchall($sql, array($res_modir[0]['id'], '2'), true);
                                        if ($res_user) {
                                            //update user info of modir
                                            $arr = array();
                                            $arr['id'] = $res_user[0]['id'];
                                            $arr['status'] = '2';
                                            $sql = Helper::Update_Generator($arr, 'bnm_users', "WHERE id = :id");
                                            $result = Db::secure_update_array($sql, $arr);
                                        } else {
                                            echo Helper::Alert_Message('f');
                                        }

                                        if ($result) {
                                            die(true);
                                        } else {
                                            die(false);
                                        }
                                    } else {
                                        echo Helper::Alert_Message('f');
                                    }
                                } else {
                                    echo Helper::Alert_Message('na');
                                }

                                break;
                            case '2':
                            case '3':

                                break;

                            default:

                                break;
                        }
                    }
                    echo Helper::Alert_Message('af');
                    break;
                case 'operator':

                    if (Helper::Login_Just_Check()) {
                        if (Helper::check_delete_access('operator')) {
                            switch ($_SESSION['user_type']) {
                                case __ADMINUSERTYPE__:
                                case __ADMINOPERATORUSERTYPE__:
                                    /////////////////////////old codes//////////////////////
                                    $id = $_POST['harddelete'];
                                    // $sql    = "delete FROM bnm_access_menu_operator WHERE operator_id = '$id'";
                                    // $result = Db::justexecute($sql);
                                    // $sql    = "delete FROM bnm_delete_menu_operator WHERE operator_id = '$id'";
                                    // $result = Db::justexecute($sql);
                                    // $sql    = "delete FROM bnm_edit_menu_operator WHERE operator_id = '$id'";
                                    // $result = Db::justexecute($sql);
                                    // $sql    = "delete FROM bnm_add_menu_operator WHERE operator_id = '$id'";
                                    // $result = Db::justexecute($sql);
                                    // //delete from users
                                    // $sql    = "delete FROM bnm_users WHERE id = '$id' AND user_type = '2'";
                                    // $result = Db::justexecute($sql);
                                    // $sql    = "delete FROM bnm_operator WHERE id = '$id'";
                                    // $result = Db::justexecute($sql);
                                    /////////////////////////old codes//////////////////////
                                    //get operator info
                                    $res_operator = Helper::Select_By_Id('bnm_operator', $id);
                                    if ($res_operator) {
                                        //update modir info
                                        $arr = array();
                                        $arr['id'] = $res_operator[0]['id'];
                                        $arr['panel_status'] = '3';
                                        $sql = Helper::Update_Generator($arr, 'bnm_operator', 'WHERE id= :id');
                                        $res = Db::secure_update_array($sql, $arr, true);
                                        //get user info of operator
                                        $sql = "SELECT * FROM bnm_users WHERE user_id = ? AND user_type=?";
                                        $res_user = Db::secure_fetchall($sql, array($res_operator[0]['id'], '3'), true);
                                        if ($res_user) {
                                            //update user info of operator
                                            $arr = array();
                                            $arr['id'] = $res_user[0]['id'];
                                            $arr['status'] = '3';
                                            $sql = Helper::Update_Generator($arr, 'bnm_users', "WHERE id = :id");
                                            $result = Db::secure_update_array($sql, $arr);
                                        } else {
                                            echo Helper::Alert_Message('f');
                                        }

                                        if ($result) {
                                            die(true);
                                        } else {
                                            die(false);
                                        }
                                    } else {
                                        echo Helper::Alert_Message('f');
                                    }
                                    break;
                                case '2':
                                case '3':

                                    break;

                                default:

                                    break;
                            }
                        } else {
                            echo Helper::Alert_Message('na');
                        }

                    }
                    echo Helper::Alert_Message('af');
                    break;
                case 'ostan':
                    if (Helper::check_delete_access('ostan')) {
                        $id = $_POST['harddelete'];
                        $sql = "delete FROM bnm_ostan WHERE id = '$id'";
                        $result = Db::justexecute($sql);
                        if ($result) {
                            die(true);
                        } else {
                            die(false);
                        }
                    } else {
                        echo Helper::Alert_Message('na');
                    }

                    break;
                case 'countries':
                    if (Helper::check_delete_access('countries')) {
                        $id = $_POST['harddelete'];
                        $sql = "delete FROM bnm_countries WHERE id = '$id'";
                        $result = Db::justexecute($sql);
                        if ($result) {
                            die(true);
                        } else {
                            die(false);
                        }
                    } else {
                        echo Helper::Alert_Message('na');
                    }

                    break;
                case 'tax':
                    if (Helper::check_delete_access('tax')) {
                        $id = $_POST['harddelete'];
                        $sql = "delete FROM bnm_tax WHERE id = '$id'";
                        $result = Db::justexecute($sql);
                        if ($result) {
                            die(true);
                        } else {
                            die(false);
                        }
                    } else {
                        echo Helper::Alert_Message('na');
                    }

                    break;
                case 'noe_terminal':
                    if (Helper::check_delete_access('noe_terminal')) {
                        $id = $_POST['harddelete'];
                        $sql = "delete FROM bnm_noe_terminal WHERE id = '$id'";
                        $result = Db::justexecute($sql);
                        if ($result) {
                            die(true);
                        } else {
                            die(false);
                        }
                    } else {
                        echo Helper::Alert_Message('na');
                    }

                    break;
                case 'wireless_ap':
                    if (Helper::check_delete_access('wireless_ap')) {
                        $sql = "delete FROM bnm_wireless_ap WHERE id = :id";
                        $result = Db::secure_delete($sql, $_POST['harddelete']);
                        if ($result) {
                            die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                        } else {
                            die(Helper::Json_Message('f'));
                        }

                        if ($result) {
                            die(true);
                        } else {
                            die(false);
                        }
                    } else {
                        echo Helper::Alert_Message('na');
                    }

                    break;
                case 'wireless_station':
                    if (Helper::check_delete_access('wireless_station')) {
                        $id = $_POST['harddelete'];
                        $sql = "delete FROM bnm_wireless_station WHERE id = $id";
                        $result = Db::justexecute($sql);
                        if ($result) {
                            die(true);
                        } else {
                            die(false);
                        }
                    } else {
                        echo Helper::Alert_Message('na');
                    }

                    break;
                case 'services_adsl':
                    if (Helper::check_delete_access('services')) {
                        $id = $_POST['harddelete'];
                        $sql = "delete FROM bnm_services WHERE id = '$id'";
                        $result = Db::justexecute($sql);
                        if ($result) {
                            die(true);
                        } else {
                            die(false);
                        }
                    } else {
                        echo Helper::Alert_Message('na');
                    }

                    break;
                case 'services_wireless':
                    $id = $_POST['harddelete'];
                    $sql = "delete FROM bnm_services WHERE id = '$id'";
                    $result = Db::justexecute($sql);
                    if ($result) {
                        die(true);
                    } else {
                        die(false);
                    }
                    break;
                case 'services_tdlte':
                    $id = $_POST['harddelete'];
                    $sql = "delete FROM bnm_services WHERE id = '$id'";
                    $result = Db::justexecute($sql);
                    if ($result) {
                        die(true);
                    } else {
                        die(false);
                    }
                    break;
                case 'services_voip':
                    $id = $_POST['harddelete'];
                    $sql = "delete FROM bnm_services WHERE id = '$id'";
                    $result = Db::justexecute($sql);
                    if ($result) {
                        die(true);
                    } else {
                        die(false);
                    }
                    break;
                case 'organization_level':
                    if (Helper::check_delete_access('organization_level')) {
                        $id = $_POST['harddelete'];
                        $sql = "delete FROM bnm_organization_level WHERE id = $id";
                        $result = Db::justexecute($sql);
                        if ($result) {
                            die(true);
                        } else {
                            die(false);
                        }
                    } else {
                        echo Helper::Alert_Message('na');
                    }

                    break;
                case 'real_subscribers':
                    if (Helper::check_delete_access('real_subscribers')) {
                        $id = $_POST['harddelete'];
                        $sql = "delete FROM bnm_subscribers WHERE id = $id";
                        $result = Db::justexecute($sql);
                        if ($result) {
                            die(true);
                        } else {
                            die(false);
                        }
                    } else {
                        echo Helper::Alert_Message('na');
                    }

                    break;
                case 'legal_subscribers':
                    if (Helper::check_delete_access('legal_subscribers`')) {

                        $id = $_POST['harddelete'];
                        $sql = "delete FROM bnm_subscribers WHERE id = $id";
                        $result = Db::justexecute($sql);
                        if ($result) {
                            die(true);
                        } else {
                            die(false);
                        }
                    } else {
                        echo Helper::Alert_Message('na');
                    }

                    break;

                case 'popsite':
                    if (Helper::check_delete_access('popsite')) {

                        $id = $_POST['harddelete'];
                        $sql = "delete FROM bnm_popsite WHERE id = $id";
                        $result = Db::justexecute($sql);
                        if ($result) {
                            die(true);
                        } else {
                            die(false);
                        }
                    } else {
                        echo Helper::Alert_Message('na');
                    }

                    break;
                case 'host':
                    if (Helper::check_delete_access('host')) {
                        $id = $_POST['harddelete'];
                        $sql = "delete FROM bnm_host WHERE id = '$id'";
                        $result = Db::justexecute($sql);
                        if ($result) {
                            die(true);
                        } else {
                            die(false);
                        }
                    } else {
                        echo Helper::Alert_Message('na');
                    }

                    break;
                case 'terminal':
                    //ghabl az delete bayad check shavad ke agar shomare telephone be portha ekhtesas daded nashode mitone pak beshe
                    if (Helper::check_delete_access('terminal')) {

                        $id = $_POST['harddelete'];
                        $sql = "delete FROM bnm_terminal WHERE id = '$id'";
                        $result = Db::justexecute($sql);
                        if ($result) {
                            die(true);
                        } else {
                            die(false);
                        }
                        die(true);
                    } else {
                        echo Helper::Alert_Message('na');
                    }

                    break;
                case 'branch':
                    if (Helper::check_delete_access('branch')) {

                        $id = $_POST['harddelete'];
                        $sql = "delete FROM bnm_branch WHERE id = '$id'";
                        $result = Db::justexecute($sql);
                        if ($result) {
                            die(true);
                        } else {
                            die(false);
                        }
                    } else {
                        echo Helper::Alert_Message('na');
                    }

                    break;
                case 'telecommunications_center':
                    if (Helper::check_delete_access('telecommunications_center')) {

                        $id = $_POST['harddelete'];
                        $sql = "delete FROM bnm_telecommunications_center WHERE id = '$id'";
                        $result = Db::justexecute($sql);
                        if ($result) {
                            die(true);
                        } else {
                            die(false);
                        }
                    } else {
                        echo Helper::Alert_Message('na');
                    }

                    break;
            }
        }
        // 1. router

        /*========factors_initialize========*/
        if (isset($_POST['factors_initialize'])) {
            switch ($_POST['factors_initialize']) {

                case 'sj_tdlte_user_sims':
                    //die(json_encode($_POST));
                    if (Helper::Is_Empty_OR_Null($_POST['condition1'])) {
                        if (Helper::Login_Just_Check()) {
                            switch ($_SESSION['user_type']) {
                                case __ADMINUSERTYPE__:
                                case __ADMINOPERATORUSERTYPE__:
                                    $sql = "SELECT * FROM bnm_tdlte_sim WHERE subscriber_id=?";
                                    $res = Db::secure_fetchall($sql, array($_POST['condition1']), true);
                                    if ($res) {
                                        die(json_encode($res));
                                    } else {
                                        $msg = 'شماره ایی به این مشترک اختصاص داده نشده';
                                        die(Helper::Custom_Msg($msg));
                                    }
                                    break;
                                case __MODIRUSERTYPE__:
                                case __MODIR2USERTYPE__:
                                case __OPERATORUSERTYPE__:
                                case __OPERATOR2USERTYPE__:
                                    $sql = "SELECT * FROM bnm_tdlte_sim WHERE subscriber_id=? AND branch_id =?";
                                    $res = Db::secure_fetchall($sql, array($_POST['condition1'], $_SESSION['branch_id']), true);
                                    if ($res) {
                                        die(json_encode($res));
                                    } else {
                                        $msg = 'شماره ایی به این مشترک اختصاص داده نشده';
                                        die(Helper::Custom_Msg($msg));
                                    }
                                    break;
                                case __MOSHTARAKUSERTYPE__:
                                    $sql = "SELECT * FROM bnm_tdlte_sim WHERE subscriber_id=?";
                                    $res = Db::secure_fetchall($sql, array($_SESSION['user_id']), true);
                                    if ($res) {
                                        die(json_encode($res));
                                    } else {
                                        $msg = 'شماره ایی به این مشترک اختصاص داده نشده';
                                        die(Helper::Custom_Msg($msg));
                                    }
                                    break;
                                default:

                                    break;
                            }
                        } else {
                            die(Helper::Json_Message('af'));
                        }

                    } else {
                        die(Helper::Json_Message('test2'));
                    }

                    break;
                case 'print_factor_tasvireshode':
                    if (isset($_POST['condition'])) {
                        if (Helper::Is_Empty_OR_Null($_POST['condition'])) {
                            if (Helper::Login_Just_Check()) {
                                switch ($_SESSION['user_type']) {
                                    case __ADMINUSERTYPE__:
                                    case __ADMINOPERATORUSERTYPE__:
                                        $sql = "SELECT branch_id,id,subscriber_id FROM bnm_factor WHERE id = ? AND tasvie_shode = ?";
                                        $res = Db::secure_fetchall($sql, array($_POST['condition'], 1));
                                        if ($res) {
                                            if ($res[0]['branch_id'] === 0) {
                                                ///user sherkat
                                                $sql = "SELECT bf.id id,bf.pin_code,bf.shomare_factor shomare_factor,bf.telephone telephone,
                                                bf.terafik terafik,bf.zaname_estefade_be_tarikh zaname_estefade_be_tarikh,
                                                bf.tarikhe_shoroe_service tarikhe_shoroe_service,
                                                bf.tarikhe_payane_service tarikhe_payane_service,bf.gheymate_service gheymate_service,
                                                bf.onvane_service onvane_service,bf.zamane_estefade zamane_estefade,
                                                bf.takhfif takhfif,bf.hazine_ranzhe hazine_ranzhe,bf.hazine_dranzhe hazine_dranzhe,
                                                bf.hazine_nasb hazine_nasb,bf.abonmane_port abonmane_port,bf.abonmane_faza abonmane_faza,
                                                bf.abonmane_tajhizat abonmane_tajhizat,bf.maliate_arzeshe_afzode maliate_arzeshe_afzode,
                                                bf.darsade_avareze_arzeshe_afzode darsade_avareze_arzeshe_afzode,
                                                bf.mablaghe_ghabele_pardakht mablaghe_ghabele_pardakht,
                                                bf.subscriber_id subscriber_id,bf.tarikhe_factor tarikhe_factor,
                                                bs.branch_id branch_id,bs.name name,bs.f_name f_name,bs.code_eshterak code_eshterak,
                                                bs.code_meli code_meli,bs.telephone_hamrah telephone_hamrah,bs.address1 address1,
                                                bs.telephone1 ,ser.type type,ser.noe_khadamat noe_khadamat,ser.tozihate_faktor
                                                FROM bnm_factor bf
                                                INNER JOIN bnm_subscribers bs ON bf.subscriber_id = bs.id
                                                INNER JOIN bnm_services ser ON bf.service_id = ser.id
                                                WHERE bf.id = ? AND bf.tasvie_shode=?";
                                                $res = Db::secure_fetchall($sql, array($_POST['condition'], 1), true);
                                                if ($res) {
                                                    $res[0]['name_sherkat'] = __OWNER__;

                                                    die(json_encode($res));
                                                } else {
                                                    die(Helper::Json_Message('pbp'));
                                                }
                                            } elseif (Helper::Is_Empty_OR_Null($res[0]['branch_id'])) {
                                                ///user namayande
                                                $sql = "SELECT bf.id id,bf.pin_code,bf.shomare_factor shomare_factor,bf.telephone telephone,
                                                bf.terafik terafik,bf.zaname_estefade_be_tarikh zaname_estefade_be_tarikh,
                                                bf.tarikhe_shoroe_service tarikhe_shoroe_service,
                                                bf.tarikhe_payane_service tarikhe_payane_service,bf.gheymate_service gheymate_service,
                                                bf.onvane_service onvane_service,bf.zamane_estefade zamane_estefade,
                                                bf.takhfif takhfif,bf.hazine_ranzhe hazine_ranzhe,bf.hazine_dranzhe hazine_dranzhe,
                                                bf.hazine_nasb hazine_nasb,bf.abonmane_port abonmane_port,bf.abonmane_faza abonmane_faza,
                                                bf.abonmane_tajhizat abonmane_tajhizat,bf.maliate_arzeshe_afzode maliate_arzeshe_afzode,
                                                bf.darsade_avareze_arzeshe_afzode darsade_avareze_arzeshe_afzode,
                                                bf.mablaghe_ghabele_pardakht mablaghe_ghabele_pardakht,
                                                bf.subscriber_id subscriber_id,bf.tarikhe_factor tarikhe_factor,
                                                bs.branch_id branch_id,bs.name name,bs.f_name f_name,bs.code_eshterak code_eshterak,
                                                bs.code_meli code_meli,bs.telephone_hamrah telephone_hamrah,bs.address1 address1,
                                                bs.telephone1,ser.type type,ser.noe_khadamat noe_khadamat,
                                                CONCAT(branches.name_sherkat ,'تلفن : ', branches.telephone1 , 'دورنگار : ',branches.dornegar) name_sherkat,

                                                ser.tozihate_faktor
                                                FROM bnm_factor bf
                                                INNER JOIN bnm_subscribers bs ON bf.subscriber_id = bs.id
                                                INNER JOIN bnm_services ser ON bf.service_id = ser.id
                                                INNER JOIN bnm_branch branches ON bf.branch_id = branches.id
                                                WHERE bf.id = ? AND bf.tasvie_shode=?";
                                                $res = Db::secure_fetchall($sql, array($_POST['condition'], 1), true);
                                                if ($res) {
                                                    die(json_encode($res));
                                                } else {
                                                    die(Helper::Json_Message('pbp'));
                                                }

                                            } else {
                                                die(Helper::Json_Message('f'));
                                            }

                                        } else {
                                            die(Helper::Json_Message('fnf'));
                                        }

                                        break;
                                    case __MODIRUSERTYPE__:
                                    case __MODIR2USERTYPE__:
                                    case __OPERATORUSERTYPE__:
                                    case __OPERATOR2USERTYPE__:
                                        $sql = "SELECT * FROM bnm_factor WHERE id = ? AND tasvie_shode=? AND branch_id=?";
                                        $res = Db::secure_fetchall($sql, array($_POST['condition'], 1, $_SESSION['branch_id']));
                                        if ($res) {
                                            die(json_encode($res));
                                        } else {
                                            die(Helper::Custom_Msg('قبل از پرینت فاکتور از تسویه مبلغ آن اطمینان حاصل کنید.'));
                                        }

                                        break;
                                    case __MOSHTARAKUSERTYPE__:
                                        $sql = "SELECT * FROM bnm_factor WHERE id = ? AND tasvie_shode=? AND branch_id=? AND subscriber_id=?";
                                        $res = Db::secure_fetchall($sql, array($_POST['condition'], 1, $_SESSION['branch_id'], $_SESSION['user_id']));
                                        if ($res) {
                                            die(json_encode($res));
                                        } else {
                                            die(Helper::Custom_Msg('قبل از پرینت فاکتور از تسویه مبلغ آن اطمینان حاصل کنید.'));
                                        }

                                        break;
                                    default:
                                        die(Helper::Json_Message('na'));
                                        break;
                                }
                            } else {
                                die(Helper::Json_Message('af'));
                            }

                        } else {
                            die(Helper::Json_Message('rinf'));
                        }

                    } else {
                        die(Helper::Json_Message('rinf'));
                    }

                    break;
                case 'findbyid':
                    //                    $id=$_POST['condition'];
                    //                    $sql="SELECT * FROM bnm_subscribers WHERE id=$id";
                    //                    $result=Db::fetchall_Query($sql);
                    //                    $rows=json_encode($result);
                    //                    die($rows);
                    //                    break;
                    die(json_encode(array()));
                    break;
                case 'find_factor_by_id':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                                $id = $_POST['condition'];
                                $sql = "SELECT *,DATE(tarikhe_factor) AS date_tarikhe_factor FROM bnm_factor WHERE id=?";
                                $res = Db::secure_fetchall($sql, array($id));
                                die(json_encode($res));
                                break;
                            case __MODIRUSERTYPE__:
                            case __OPERATORUSERTYPE__:
                            case __MODIR2USERTYPE__:
                            case __OPERATOR2USERTYPE__:
                            case __MOSHTARAKUSERTYPE__:
                                $id = $_POST['condition'];
                                $sql = "SELECT *,DATE(tarikhe_factor) AS date_tarikhe_factor FROM bnm_factor WHERE id=? AND branch_id=?";
                                $res = Db::secure_fetchall($sql, array($id, $_SESSION['branch_id']));
                                die(json_encode($res));
                                break;
                            case __MOSHTARAKUSERTYPE__:
                                $id = $_POST['condition'];
                                $sql = "SELECT *,DATE(tarikhe_factor) AS date_tarikhe_factor FROM bnm_factor WHERE id=? AND subscriber_id=?";
                                $res = Db::secure_fetchall($sql, array($id, $_SESSION['user_id']));
                                if ($res) {
                                    die(json_encode($res));
                                } else {
                                    die(Helper::Json_Message('f'));
                                }

                                break;

                            default:
                                die(Helper::Json_Message('af'));
                                break;
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }
                    break;
                case 'get_factor_info_by_id_check_date_and_credits':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                                $sql_factor = "SELECT id,service_id,subscriber_id,tarikhe_factor,mablaghe_ghabele_pardakht,type FROM bnm_factor WHERE id=? AND DATE(tarikhe_factor)=CURDATE() AND tasvie_shode<>'1'";
                                $res_factor = Db::secure_fetchall($sql_factor, array($_POST['condition']), true);
                                if ($res_factor) {
                                    $sql_subscriber = "SELECT id,name,f_name,branch_id FROM bnm_subscribers WHERE id=?";
                                    $res_subscriber = Db::secure_fetchall($sql_subscriber, array($res_factor[0]['subscriber_id']), true);
                                    if ($res_subscriber && Helper::Is_Empty_OR_Null($res_subscriber[0]['branch_id'])) {
                                        //check subscriber info
                                        if ($res_subscriber[0]['branch_id'] !== 0) {
                                            //user namayande
                                            $branch_sql = "SELECT id,name_sherkat FROM bnm_branch WHERE id = ?";
                                            $res_branch = Db::secure_fetchall($branch_sql, array($res_subscriber[0]['branch_id']), true);
                                            if ($res_branch) {
                                                //get credit subscriber info
                                                $sql_credit_subscriber = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY update_time DESC LIMIT 1";
                                                $res_credit_subscriber = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id'], '1'));
                                                $result = array();
                                                $result['subscriber'] = [];
                                                $result['branch'] = [];
                                                $result['subscriber']['status'] = false;
                                                $result['branch']['status'] = false;
                                                if ($res_credit_subscriber && abs($res_credit_subscriber[0]['credit']) >= abs($res_factor[0]['mablaghe_ghabele_pardakht'])) {
                                                    //user bank darad va credit user baraye pardakht kafi ast
                                                    $result['subscriber']['status'] = true;
                                                    $result['subscriber']['credit'] = $res_credit_subscriber[0]['credit'];
                                                    $result['subscriber']['name'] = Helper::getor_string($res_subscriber[0]['name'] . ' ' . $res_subscriber[0]['f_name'], 'ثبت نشده');
                                                    $result['subscriber']['id'] = $res_subscriber[0]['id'];
                                                } else {
                                                    $result['subscriber']['status'] = false;
                                                    $result['subscriber']['name'] = Helper::getor_string($res_subscriber[0]['name'] . ' ' . $res_subscriber[0]['f_name'], 'ثبت نشده');
                                                    if ($res_credit_subscriber) {
                                                        $result['subscriber']['credit'] = $res_credit_subscriber[0]['credit'];
                                                    } else {
                                                        $result['subscriber']['credit'] = 0;
                                                    }
                                                }
                                                //get credit branch info
                                                $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id = ? AND noe_user= ? ORDER BY update_time DESC LIMIT 1";
                                                $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_branch[0]['id'], '2'));

                                                if ($res_credit_branch && abs($res_credit_branch[0]['credit']) >= abs($res_factor[0]['mablaghe_ghabele_pardakht'])) {
                                                    //$flag_branch = true;
                                                    $result['branch']['status'] = true;
                                                    $result['branch']['credit'] = $res_credit_branch[0]['credit'];
                                                    $result['branch']['name'] = Helper::getor_string($res_branch[0]['name_sherkat']);
                                                    $result['branch']['id'] = Helper::getor_string($res_branch[0]['name_sherkat']);
                                                } else {
                                                    //$flag_branch = false;
                                                    $result['branch']['status'] = false;
                                                    if ($res_credit_branch) {
                                                        $result['branch']['credit'] = Helper::getor_string($res_credit_branch[0]['credit'], 0);
                                                        $result['branch']['name'] = Helper::getor_string($res_branch[0]['name_sherkat']);
                                                        $result['branch']['id'] = Helper::getor_string($res_branch[0]['name_sherkat']);
                                                    } else {
                                                        if ($res_branch) {
                                                            $result['branch']['id'] = Helper::getor_string($res_branch[0]['name_sherkat']);
                                                            $result['branch']['credit'] = 0;
                                                            $result['branch']['name'] = Helper::getor_string($res_branch[0]['name_sherkat']);
                                                        } else {
                                                            $result['branch']['credit'] = 0;
                                                            $result['branch']['id'] = 'empty';
                                                            $result['branch']['name'] = 'ثبت نشده';
                                                        }
                                                    }
                                                }
                                                $result['mablaghe_factor'] = $res_factor[0]['mablaghe_ghabele_pardakht'];
                                                $result['factor_id'] = $res_factor[0]['id'];
                                                $result['pardakhte_dasti'] = false;
                                                die(json_encode($result));
                                            } else {
                                                die(Helper::Json_Message('branch_not_right'));
                                            }
                                        } else if ($res_subscriber[0]['branch_id'] === 0) {
                                            //user baraye sahar ast
                                            $sql_credit_subscriber = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY update_time DESC LIMIT 1";
                                            $res_credit_subscriber = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id'], '1'));
                                            $result = array();
                                            $result['subscriber'] = [];
                                            $result['branch'] = [];
                                            $result['subscriber']['status'] = false;
                                            $result['branch']['status'] = false;
                                            if ($res_credit_subscriber && abs($res_credit_subscriber[0]['credit']) >= abs($res_factor[0]['mablaghe_ghabele_pardakht'])) {
                                                $result['subscriber']['status'] = true;
                                                $result['subscriber']['credit'] = $res_credit_subscriber[0]['credit'];
                                                $result['subscriber']['name'] = Helper::getor_string($res_subscriber[0]['name'] . ' ' . $res_subscriber[0]['f_name'], 'ثبت نشده');
                                                $result['subscriber']['id'] = $res_subscriber;
                                            } else {
                                                $result['subscriber']['status'] = false;
                                                $result['subscriber']['name'] = Helper::getor_string($res_subscriber[0]['name'] . ' ' . $res_subscriber[0]['f_name'], 'ثبت نشده');
                                                if ($res_credit_subscriber) {
                                                    $result['subscriber']['credit'] = $res_credit_subscriber[0]['credit'];
                                                } else {
                                                    $result['subscriber']['credit'] = 0;
                                                }
                                                $result['subscriber']['status'] = false;
                                            }
                                            $result['branch']['status'] = false;
                                            $result['branch']['name'] = "سحر ارتباط";
                                            $result['branch']['id'] = "0";
                                            $result['branch']['credit'] = "0";
                                            $result['mablaghe_factor'] = $res_factor[0]['mablaghe_ghabele_pardakht'];
                                            $result['factor_id'] = $res_factor[0]['id'];
                                            $result['pardakhte_dasti'] = true;
                                            die(json_encode($result));
                                        } else {
                                            die(Helper::Json_Message('user_info_not_right'));
                                        }
                                    } else {
                                        die(Helper::Json_Message('user_didnt_found'));
                                    }
                                } else {
                                    die(Helper::Json_Message('fnf'));
                                }
                                break;
                            case __MODIRUSERTYPE__:
                            case __OPERATORUSERTYPE__:
                            case __MODIR2USERTYPE__:
                            case __OPERATOR2USERTYPE__:
                                $sql_factor = "SELECT id,service_id,subscriber_id,tarikhe_factor,mablaghe_ghabele_pardakht,type  FROM bnm_factor WHERE id=? AND branch_id=? AND DATE(tarikhe_factor)=CURDATE() AND tasvie_shode<>'1'";
                                $res_factor = Db::secure_fetchall($sql_factor, array($id, $_SESSION['branch_id']));
                                if ($res_factor) {
                                    $sql_subscriber = "SELECT id,name,f_name,branch_id FROM bnm_subscribers WHERE id=? AND branch_id=?";
                                    $res_subscriber = Db::secure_fetchall($sql_subscriber, array($res_factor[0]['subscriber_id']), $_SESSION['branch_id']);
                                    if ($res_subscriber && Helper::Is_Empty_OR_Null($res_subscriber[0]['branch_id'])) {
                                        //check subscriber info
                                        if ($res_subscriber[0]['branch_id'] !== 0) {
                                            //user baraye namayande ast
                                            $branch_sql = "SELECT id,name_sherkat FROM bnm_branch WHERE id = ?";
                                            $res_branch = Db::secure_fetchall($branch_sql, array($res_subscriber[0]['branch_id']));
                                            if ($res_branch) {
                                                //get credit subscriber info
                                                $sql_credit_subscriber = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user='1' ORDER BY update_time DESC LIMIT 1";
                                                $res_credit_subscriber = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id']));
                                                $result = array();
                                                $result['subscriber'] = [];
                                                $result['branch'] = [];
                                                $result['subscriber']['status'] = false;
                                                $result['branch']['status'] = false;
                                                if ($res_credit_subscriber && abs($res_credit_subscriber[0]['credit']) >= abs($res_factor[0]['mablaghe_ghabele_pardakht']) + abs(($res_factor[0]['mablaghe_ghabele_pardakht']))) {
                                                    //user bank darad va credit user baraye pardakht kafi ast
                                                    $result['subscriber']['status'] = true;
                                                    $result['subscriber']['credit'] = $res_credit_subscriber[0]['credit'];
                                                    $result['subscriber']['name'] = Helper::getor_string($res_subscriber[0]['name'] . ' ' . $res_subscriber[0]['f_name'], 'ثبت نشده');
                                                    $result['subscriber']['id'] = $res_subscriber[0]['id'];
                                                } else {
                                                    $result['subscriber']['status'] = false;
                                                    $result['subscriber']['name'] = Helper::getor_string($res_subscriber[0]['name'] . ' ' . $res_subscriber[0]['f_name'], 'ثبت نشده');
                                                    if ($res_credit_subscriber) {
                                                        $result['subscriber']['credit'] = $res_credit_subscriber[0]['credit'];
                                                    } else {
                                                        $result['subscriber']['credit'] = 0;
                                                    }
                                                }
                                                //get credit branch info
                                                $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id = ? AND noe_user='2' ORDER BY update_time DESC LIMIT 1";
                                                $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_branch[0]['id']));
                                                if ($res_credit_branch && abs($res_credit_branch[0]['credit']) >= abs($res_factor[0]['mablaghe_ghabele_pardakht']) + abs(($res_factor[0]['mablaghe_ghabele_pardakht']) * 20 / 100)) {
                                                    //$flag_branch = true;
                                                    $result['branch'] = true;
                                                    $result['branch']['credit'] = $res_credit_branch[0]['credit'];
                                                    $result['branch']['name'] = Helper::getor_string($res_branch[0]['name_sherkat']);
                                                    $result['branch']['id'] = Helper::getor_string($res_branch[0]['name_sherkat']);
                                                } else {
                                                    //$flag_branch = false;
                                                    $result['branch']['status'] = false;
                                                    if ($res_credit_branch) {
                                                        $result['branch']['credit'] = Helper::getor_string($res_credit_branch[0]['credit'], 0);
                                                        $result['branch']['name'] = Helper::getor_string($res_branch[0]['name_sherkat']);
                                                        $result['branch']['id'] = Helper::getor_string($res_branch[0]['name_sherkat']);
                                                    } else {
                                                        if ($res_branch) {
                                                            $result['branch']['id'] = Helper::getor_string($res_branch[0]['name_sherkat']);
                                                            $result['branch']['credit'] = 0;
                                                            $result['branch']['name'] = Helper::getor_string($res_branch[0]['name_sherkat']);
                                                        } else {
                                                            $result['branch']['credit'] = 0;
                                                            $result['branch']['id'] = 'empty';
                                                            $result['branch']['name'] = 'ثبت نشده';
                                                        }
                                                    }
                                                }
                                                $result['mablaghe_factor'] = $res_factor[0]['mablaghe_ghabele_pardakht'];
                                                $result['factor_id'] = Helper::getor_string($res_factor[0]['id'], 'empty');
                                                $result['pardakhte_dasti'] = false;
                                                die(json_encode($result));
                                            } else {
                                                die(Helper::Json_Message('branch_not_right'));
                                            }
                                        } else if ($res_subscriber[0]['branch_id'] === 0) {
                                            die(Helper::Json_Message('no_access'));
                                        }
                                    } else {
                                        die(Helper::Json_Message('user_didnt_found'));
                                    }
                                } else {
                                    die(Helper::Json_Message('factor_not_ok_for_pardakht'));
                                }
                                break;
                            case __MOSHTARAKUSERTYPE__:
                                $sql_factor = "SELECT id,service_id,subscriber_id,tarikhe_factor,mablaghe_ghabele_pardakht,type FROM bnm_factor WHERE id=? AND DATE(tarikhe_factor)=CURDATE() AND tasvie_shode<>'1'";
                                $res_factor = Db::secure_fetchall($sql_factor, array($_POST['condition']), true);
                                if ($res_factor) {
                                    $sql_subscriber = "SELECT id,name,f_name,branch_id FROM bnm_subscribers WHERE id=?";
                                    $res_subscriber = Db::secure_fetchall($sql_subscriber, array($_SESSION['user_id']), true);
                                    if ($res_subscriber && Helper::Is_Empty_OR_Null($res_subscriber[0]['branch_id'])) {
                                        //check subscriber info
                                        if ($res_subscriber[0]['branch_id'] !== 0) {
                                            //user namayande
                                            $branch_sql = "SELECT id,name_sherkat FROM bnm_branch WHERE id = ?";
                                            $res_branch = Db::secure_fetchall($branch_sql, array($res_subscriber[0]['branch_id']), true);
                                            if ($res_branch) {
                                                //get credit subscriber info
                                                $sql_credit_subscriber = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY update_time DESC LIMIT 1";
                                                $res_credit_subscriber = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id'], '1'));
                                                $result = array();
                                                $result['subscriber'] = [];
                                                $result['branch'] = [];
                                                $result['subscriber']['status'] = false;
                                                $result['branch']['status'] = false;
                                                if ($res_credit_subscriber && abs($res_credit_subscriber[0]['credit']) >= abs($res_factor[0]['mablaghe_ghabele_pardakht'])) {
                                                    //user bank darad va credit user baraye pardakht kafi ast
                                                    $result['subscriber']['status'] = true;
                                                    $result['subscriber']['credit'] = $res_credit_subscriber[0]['credit'];
                                                    $result['subscriber']['name'] = Helper::getor_string($res_subscriber[0]['name'] . ' ' . $res_subscriber[0]['f_name'], 'ثبت نشده');
                                                    $result['subscriber']['id'] = $res_subscriber[0]['id'];
                                                } else {
                                                    $result['subscriber']['status'] = false;
                                                    $result['subscriber']['name'] = Helper::getor_string($res_subscriber[0]['name'] . ' ' . $res_subscriber[0]['f_name'], 'ثبت نشده');
                                                    if ($res_credit_subscriber) {
                                                        $result['subscriber']['credit'] = $res_credit_subscriber[0]['credit'];
                                                    } else {
                                                        $result['subscriber']['credit'] = 0;
                                                    }
                                                }
                                                //get credit branch info
                                                $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id = ? AND noe_user= ? ORDER BY update_time DESC LIMIT 1";
                                                $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_branch[0]['id'], '2'));

                                                if ($res_credit_branch && abs($res_credit_branch[0]['credit']) >= abs($res_factor[0]['mablaghe_ghabele_pardakht'])) {
                                                    //$flag_branch = true;
                                                    $result['branch']['status'] = true;
                                                    $result['branch']['credit'] = $res_credit_branch[0]['credit'];
                                                    $result['branch']['name'] = Helper::getor_string($res_branch[0]['name_sherkat']);
                                                    $result['branch']['id'] = Helper::getor_string($res_branch[0]['name_sherkat']);
                                                } else {
                                                    //$flag_branch = false;
                                                    $result['branch']['status'] = false;
                                                    if ($res_credit_branch) {
                                                        $result['branch']['credit'] = Helper::getor_string($res_credit_branch[0]['credit'], 0);
                                                        $result['branch']['name'] = Helper::getor_string($res_branch[0]['name_sherkat']);
                                                        $result['branch']['id'] = Helper::getor_string($res_branch[0]['name_sherkat']);
                                                    } else {
                                                        if ($res_branch) {
                                                            $result['branch']['id'] = Helper::getor_string($res_branch[0]['name_sherkat']);
                                                            $result['branch']['credit'] = 0;
                                                            $result['branch']['name'] = Helper::getor_string($res_branch[0]['name_sherkat']);
                                                        } else {
                                                            $result['branch']['credit'] = 0;
                                                            $result['branch']['id'] = 'empty';
                                                            $result['branch']['name'] = 'ثبت نشده';
                                                        }
                                                    }
                                                }
                                                $result['mablaghe_factor'] = $res_factor[0]['mablaghe_ghabele_pardakht'];
                                                $result['factor_id'] = $res_factor[0]['id'];
                                                $result['pardakhte_dasti'] = false;
                                                die(json_encode($result));
                                            } else {
                                                die(Helper::Json_Message('branch_not_right'));
                                            }
                                        } else if ($res_subscriber[0]['branch_id'] === 0) {
                                            //user baraye sahar ast
                                            $sql_credit_subscriber = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY update_time DESC LIMIT 1";
                                            $res_credit_subscriber = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id'], '1'));
                                            $result = array();
                                            $result['subscriber'] = [];
                                            $result['branch'] = [];
                                            $result['subscriber']['status'] = false;
                                            $result['branch']['status'] = false;
                                            if ($res_credit_subscriber && abs($res_credit_subscriber[0]['credit']) >= abs($res_factor[0]['mablaghe_ghabele_pardakht'])) {
                                                $result['subscriber']['status'] = true;
                                                $result['subscriber']['credit'] = $res_credit_subscriber[0]['credit'];
                                                $result['subscriber']['name'] = Helper::getor_string($res_subscriber[0]['name'] . ' ' . $res_subscriber[0]['f_name'], 'ثبت نشده');
                                                $result['subscriber']['id'] = $res_subscriber;
                                            } else {
                                                $result['subscriber']['status'] = false;
                                                $result['subscriber']['name'] = Helper::getor_string($res_subscriber[0]['name'] . ' ' . $res_subscriber[0]['f_name'], 'ثبت نشده');
                                                if ($res_credit_subscriber) {
                                                    $result['subscriber']['credit'] = $res_credit_subscriber[0]['credit'];
                                                } else {
                                                    $result['subscriber']['credit'] = 0;
                                                }
                                                $result['subscriber']['status'] = false;
                                            }
                                            $result['branch']['status'] = false;
                                            $result['branch']['name'] = "سحر ارتباط";
                                            $result['branch']['id'] = "0";
                                            $result['branch']['credit'] = "0";
                                            $result['mablaghe_factor'] = $res_factor[0]['mablaghe_ghabele_pardakht'];
                                            $result['factor_id'] = $res_factor[0]['id'];
                                            $result['pardakhte_dasti'] = true;
                                            die(json_encode($result));
                                        } else {
                                            die(Helper::Json_Message('user_info_not_right'));
                                        }
                                    } else {
                                        die(Helper::Json_Message('user_didnt_found'));
                                    }
                                } else {
                                    die(Helper::Json_Message('fnf'));
                                }
                                break;
                            default:
                                die(Helper::Json_Message('auth_fail'));
                                break;
                        }
                    } else {
                        die(Helper::Json_Message('auth_fail'));
                    }
                    break;

                case 'sj_bs_user_telephones':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                                if (Helper::Is_Empty_OR_Null($_POST['condition'])) {
                                    $sql = "SELECT bor.id bos_id,bs.name name,bs.f_name f_name,bor.tarikhe_reserve,bor.id bor_id,bor.interface_type type,
                                        if(bos.telephone=1,bs.telephone1,if(bos.telephone=2,bs.telephone2,if(bos.telephone=3,bs.telephone3,'شماره ایی ثبت نشده'))) telephone
                                        FROM bnm_subscribers bs
                                        INNER JOIN bnm_oss_subscribers bos  ON bos.user_id=bs.id
                                        INNER JOIN bnm_oss_reserves bor ON bor.oss_row_id = bos.id
                                        WHERE bos.user_id=? AND bs.id=? AND bor.latest_error_code = ?
                                        AND bor.tarikhe_reserve <= NOW() AND bor.tarikhe_reserve >=NOW() - INTERVAL 2 DAY";
                                    $res = Db::secure_fetchall($sql, array($_POST['condition'], $_POST['condition'], 0), true);

                                    if ($res) {
                                        if (is_array($res)) {
                                            if (count($res) > 0) {
                                                die(json_encode($res));
                                            } else {
                                                die(Helper::Custom_Msg('پورتی برای این مشترک در oss رزرو نشده یا تاریخ رزرو پورت منقضی شده.'));
                                            }
                                        } else {
                                            die(Helper::Custom_Msg('پورتی برای این مشترک در oss رزرو نشده یا تاریخ رزرو پورت منقضی شده.'));
                                        }
                                    } else {
                                        die(Helper::Custom_Msg('پورتی برای این مشترک در oss رزرو نشده یا تاریخ رزرو پورت منقضی شده.'));
                                    }
                                } else {
                                    die(json_encode(array('Error' => 'لطفا مشترک مورد نظر برای صدور فاکتور را انتخاب نمایید.')));
                                }

                                break;
                            case __MODIRUSERTYPE__:
                            case __OPERATORUSERTYPE__:
                            case __MODIR2USERTYPE__:
                            case __OPERATOR2USERTYPE__:
                                if (Helper::Is_Empty_OR_Null($_POST['condition'])) {
                                    $sql = "SELECT bor.id bos_id,bs.name name,bs.f_name f_name,bor.tarikhe_reserve,bor.id bor_id,bor.interface_type type,
                                        if(bos.telephone=1,bs.telephone1,if(bos.telephone=2,bs.telephone2,if(bos.telephone=3,bs.telephone3,'شماره ایی ثبت نشده'))) telephone
                                        FROM bnm_subscribers bs
                                        INNER JOIN bnm_oss_subscribers bos ON bos.user_id=bs.id
                                        INNER JOIN bnm_oss_reserves bor ON bor.oss_row_id = bos.id
                                        WHERE bos.user_id=? AND bs.id=? AND bs.branch_id=? AND bor.branch_id = ? AND bos.branch_id =? AND bor.latest_error_code = ?
                                        AND bor.tarikhe_reserve <= NOW() AND bor.tarikhe_reserve >=NOW() - INTERVAL 2 DAY";
                                    $res = Db::secure_fetchall($sql, array($_POST['condition'], $_POST['condition'], $_SESSION['branch_id'], $_SESSION['branch_id'], $_SESSION['branch_id'], 0), true);
                                    if ($res) {
                                        if (is_array($res)) {
                                            if (count($res) > 0) {
                                                die(json_encode($res));
                                            } else {
                                                die(Helper::Custom_Msg('پورتی برای این مشترک در oss رزرو نشده یا تاریخ رزرو پورت منقضی شده.'));
                                            }
                                        } else {
                                            die(Helper::Custom_Msg('پورتی برای این مشترک در oss رزرو نشده یا تاریخ رزرو پورت منقضی شده.'));
                                        }
                                    } else {
                                        die(Helper::Custom_Msg('پورتی برای این مشترک در oss رزرو نشده یا تاریخ رزرو پورت منقضی شده.'));
                                    }
                                } else {
                                    die(json_encode(array('Error' => 'لطفا مشترک مورد نظر برای صدور فاکتور را انتخاب نمایید.')));
                                }

                                break;
                            case __MOSHTARAKUSERTYPE__:
                                $sql = "SELECT bor.id bos_id,bs.name name,bs.f_name f_name,bor.tarikhe_reserve,bor.id bor_id,bor.interface_type type,
                                        if(bos.telephone=1,bs.telephone1,if(bos.telephone=2,bs.telephone2,if(bos.telephone=3,bs.telephone3,'شماره ایی ثبت نشده'))) telephone
                                        FROM bnm_subscribers bs
                                        INNER JOIN bnm_oss_subscribers bos  ON bos.user_id=bs.id
                                        INNER JOIN bnm_oss_reserves bor ON bor.oss_row_id = bos.id
                                        WHERE bos.user_id=? AND bs.id=? AND bs.branch_id=? AND bor.branch_id = ? AND bos.branch_id =? AND bor.latest_error_code = ?
                                        AND bor.tarikhe_reserve <= NOW() AND bor.tarikhe_reserve >=NOW() - INTERVAL 2 DAY";
                                $res = Db::secure_fetchall($sql, array($_SESSION['user_id'], $_SESSION['user_id'], $_SESSION['branch_id'], $_SESSION['branch_id'], $_SESSION['branch_id'], 0), true);
                                if ($res) {
                                    if (is_array($res)) {
                                        if (count($res) > 0) {
                                            die(json_encode($res));
                                        } else {
                                            die(Helper::Custom_Msg('پورتی برای این مشترک در oss رزرو نشده یا تاریخ رزرو پورت منقضی شده.'));
                                        }
                                    } else {
                                        die(Helper::Custom_Msg('پورتی برای این مشترک در oss رزرو نشده یا تاریخ رزرو پورت منقضی شده.'));
                                    }
                                } else {
                                    die(Helper::Custom_Msg('پورتی برای این مشترک در oss رزرو نشده یا تاریخ رزرو پورت منقضی شده.'));
                                }
                                break;
                            default:
                                die(Helper::Json_Message('af'));
                                break;
                        }
                        $_POST = Helper::xss_check_array($_POST);
                    } else {
                        die(Helper::Json_Message('af'));
                    }

                    break;

                case 'sj_adsl_user_telephones':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                                if (Helper::Is_Empty_OR_Null($_POST['condition'])) {
                                    $sql = "
                                        SELECT p.id id,p.user_id,p.adsl_vdsl,if(p.telephone=1,s.telephone1,null) telephone1,
                                        if(p.telephone=2,s.telephone2,null) telephone2,
                                        if(p.telephone=3,s.telephone3,null) telephone3
                                        FROM bnm_port p
                                        INNER JOIN bnm_subscribers s ON s.id = p.user_id
                                        WHERE p.user_id = ?
                                    ";
                                    $res = Db::secure_fetchall($sql, array($_POST['condition']));
                                    die(json_encode($res));
                                } else {
                                    die(json_encode(array('Error' => 'لطفا مشترک مورد نظر برای صدور فاکتور را انتخاب نمایید.')));
                                }
                                break;
                            case __MODIRUSERTYPE__:
                            case __OPERATORUSERTYPE__:
                            case __MODIR2USERTYPE__:
                            case __OPERATOR2USERTYPE__:
                                if (Helper::Is_Empty_OR_Null($_POST['condition'])) {
                                    $sql = "
                                        SELECT p.id id,p.user_id,p.adsl_vdsl,if(p.telephone=1,s.telephone1,null) telephone1,
                                        if(p.telephone=2,s.telephone2,null) telephone2,
                                        if(p.telephone=3,s.telephone3,null) telephone3
                                        FROM bnm_port p
                                        INNER JOIN bnm_subscribers s ON s.id = p.user_id
                                        WHERE p.user_id = ?
                                    ";
                                    $res = Db::secure_fetchall($sql, array($_POST['condition']));
                                    die(json_encode($res));
                                } else {
                                    die(json_encode(array('Error' => 'لطفا مشترک مورد نظر برای صدور فاکتور را انتخاب نمایید.')));
                                }
                                // $user_id = $_POST['condition'];
                                // if ($user_id != '' || $user_id != null) {
                                //     $subscriber_phones = array();
                                //     $sql_user = "SELECT id,telephone1,telephone2,telephone3 FROM bnm_subscribers WHERE id=? AND branch_id=?";
                                //     $res_user = Db::secure_fetchall($sql_user, array($user_id, $_SESSION['branch_id']));
                                //     if ($res_user[0]['telephone1'] && Helper::Is_Empty_OR_Null($res_user[0]['telephone1'])) {
                                //         array_push($subscriber_phones, $res_user[0]['telephone1']);
                                //     }
                                //     if ($res_user[0]['telephone2'] && Helper::Is_Empty_OR_Null($res_user[0]['telephone2'])) {
                                //         array_push($subscriber_phones, $res_user[0]['telephone2']);
                                //     }
                                //     if ($res_user[0]['telephone3'] && Helper::Is_Empty_OR_Null($res_user[0]['telephone3'])) {
                                //         array_push($subscriber_phones, $res_user[0]['telephone3']);
                                //     }
                                //     $result = array();
                                //     for ($i = 0; $i < count($subscriber_phones); $i++) {
                                //         $sql_port = "SELECT adsl_vdsl,telephone FROM bnm_port WHERE telephone = ?";
                                //         $res_port = Db::secure_fetchall($sql_port, array($subscriber_phones[$i]));
                                //         if ($res_port) {
                                //             //array_push($result,$res_port[0]['telephone']);
                                //             $result[$i]['telephone'] = $res_port[0]['telephone'];
                                //             $result[$i]['type'] = $res_port[0]['adsl_vdsl'];
                                //         }
                                //     }
                                //     array_multisort($result);
                                //     if (count($result) > 0) {
                                //         die(json_encode($result));
                                //     } else {
                                //         die(json_encode(array('Error' => 'امکاناتی به شماره تلفن این مشترک اختصاص داده نشده.')));
                                //     }
                                // } else {
                                //     die(json_encode(array('Error' => 'لطفا مشترک مورد نظر برای صدور فاکتور را انتخاب نمایید.')));
                                // }
                                break;
                            case __MOSHTARAKUSERTYPE__:
                                $sql = "
                                        SELECT p.id id,p.user_id,p.adsl_vdsl,if(p.telephone=1,s.telephone1,null) telephone1,
                                        if(p.telephone=2,s.telephone2,null) telephone2,
                                        if(p.telephone=3,s.telephone3,null) telephone3
                                        FROM bnm_port p
                                        INNER JOIN bnm_subscribers s ON s.id = p.user_id
                                        WHERE p.user_id = ?
                                    ";
                                $res = Db::secure_fetchall($sql, array($_SESSION['user_id']));
                                die(json_encode($res));

                                //$user_id = $_POST['condition'];

                                // $subscriber_phones = array();
                                // $sql_user = "SELECT id,telephone1,telephone2,telephone3 FROM bnm_subscribers WHERE id=?";
                                // $res_user = Db::secure_fetchall($sql_user, array($_SESSION['user_id']));
                                // //die(json_encode($res_user));
                                // if ($res_user[0]['telephone1'] && Helper::Is_Empty_OR_Null($res_user[0]['telephone1'])) {
                                //     array_push($subscriber_phones, $res_user[0]['telephone1']);
                                // }
                                // if ($res_user[0]['telephone2'] && Helper::Is_Empty_OR_Null($res_user[0]['telephone2'])) {
                                //     array_push($subscriber_phones, $res_user[0]['telephone2']);
                                // }
                                // if ($res_user[0]['telephone3'] && Helper::Is_Empty_OR_Null($res_user[0]['telephone3'])) {
                                //     array_push($subscriber_phones, $res_user[0]['telephone3']);
                                // }
                                // $result = array();
                                // for ($i = 0; $i < count($subscriber_phones); $i++) {
                                //     $sql_port = "SELECT adsl_vdsl,telephone FROM bnm_port WHERE telephone = ?";
                                //     $res_port = Db::secure_fetchall($sql_port, array($subscriber_phones[$i]));
                                //     if ($res_port) {
                                //         //array_push($result,$res_port[0]['telephone']);
                                //         $result[$i]['telephone'] = $res_port[0]['telephone'];
                                //         $result[$i]['type'] = $res_port[0]['adsl_vdsl'];
                                //     }
                                // }
                                // array_multisort($result);
                                // if (count($result) > 0) {
                                //     die(json_encode($result));
                                // } else {
                                //     die(json_encode(array('Error' => 'امکاناتی به شماره تلفن این مشترک اختصاص داده نشده.')));
                                // }

                                break;

                            default:
                                die(Helper::Json_Message('af'));
                                break;
                        }
                        $_POST = Helper::xss_check_array($_POST);
                    } else {
                        die(Helper::Json_Message('af'));
                    }

                    break;
                case 'sj_wireless_stations':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                                $_POST = Helper::xss_check_array($_POST);
                                if (Helper::Is_Empty_OR_Null($_POST['condition'])) {
                                    $sql = "SELECT st.id,st.name,ss.id substation_id FROM bnm_sub_station ss
                                        INNER JOIN bnm_wireless_station st ON st.id = ss.station_id
                                        INNER JOIN bnm_subscribers sub ON sub.id = ss.sub_id
                                        WHERE ss.sub_id = ?";
                                    $res = Db::secure_fetchall($sql, [$_POST['condition']]);
                                    if ($res) {
                                        die(json_encode($res));
                                    } else {
                                        die(Helper::Custom_Msg(Helper::Messages('ens'), '2'));
                                    }
                                } else {
                                    die(Helper::Json_Message('subnf'));
                                }
                                break;
                            case __MODIRUSERTYPE__:
                            case __OPERATORUSERTYPE__:
                            case __MODIR2USERTYPE__:
                            case __OPERATOR2USERTYPE__:
                                $_POST = Helper::xss_check_array($_POST);
                                if (Helper::Is_Empty_OR_Null($_POST['condition'])) {
                                    $sql = "SELECT st.id,st.name,ss.id substation_id FROM bnm_sub_station ss
                                        INNER JOIN bnm_wireless_station st ON st.id = ss.station_id
                                        INNER JOIN bnm_subscribers sub ON sub.id = ss.sub_id
                                        WHERE ss.sub_id = ? AND sub.branch_id = ?";
                                    $res = Db::secure_fetchall($sql, [$_POST['condition'], $_SESSION['branch_id']]);
                                    if ($res) {
                                        die(json_encode($res));
                                    } else {
                                        die(Helper::Custom_Msg(Helper::Messages('ens'), '2'));
                                    }
                                } else {
                                    die(Helper::Json_Message('subnf'));
                                }
                                break;
                            case __MOSHTARAKUSERTYPE__:
                                $_POST = Helper::xss_check_array($_POST);
                                $sql = "SELECT st.id,st.name,ss.id substation_id FROM bnm_sub_station ss
                                        INNER JOIN bnm_wireless_station st ON st.id = ss.station_id
                                        INNER JOIN bnm_subscribers sub ON sub.id = ss.sub_id
                                        WHERE ss.sub_id = ?";
                                $res = Db::secure_fetchall($sql, [$_SESSION['user_id']]);
                                if ($res) {
                                    die(json_encode($res));
                                } else {
                                    die(Helper::Custom_Msg(Helper::Messages('ens'), '2'));
                                }

                                break;
                            default:
                                die(Helper::Json_Message('af'));
                                break;
                        }
                    } else {
                        die(Helper::Json_Message('f'));
                    }
                    break;
                case 'ft_connection_log_init_noe_masraf':
                    //todo ye form dorost kon barash
                    if (Helper::Login_Just_Check()) {
                        $sql = "SELECT * FROM bnm_connection_log";
                        $result = Db::fetchall_query($sql);
                        if ($result) {
                            die(json_encode($result));
                        } else {
                            die(Helper::Json_Message('f'));
                        }
                    }
                    break;
                case 'ft_connection_log_init':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                                $user_id = $_POST['condition'];

                                // $sql     = "SELECT id,ibs_username,
                                // IF(type IN ('adsl','vdsl','wireless','tdlte'),'internet',
                                // IF(type IN ('voip'),'voip','notfound')) as 'type' FROM bnm_factor WHERE subscriber_id=? GROUP BY ibs_username,type";
                                // $result = Db::secure_fetchall($sql, array($user_id));
                                // if ($result) {
                                //     die(json_encode($result));
                                // } else {
                                //     die(Helper::Json_Message('f'));
                                // }

                                break;
                            case __MODIRUSERTYPE__:
                            case __OPERATORUSERTYPE__:
                            case __MODIR2USERTYPE__:
                            case __OPERATOR2USERTYPE__:
                            case __MOSHTARAKUSERTYPE__:
                                $user_id = $_POST['condition'];
                                $sql = "SELECT id,ibs_username,
                                    IF(type IN ('adsl','vdsl','wireless','tdlte'),'internet',
                                    IF(type IN ('voip'),'voip','notfound')) as 'type' FROM bnm_factor WHERE subscriber_id=? AND branch_id=? GROUP BY ibs_username,type";
                                $result = Db::secure_fetchall($sql, array($user_id, $_SESSION['branch_id']));
                                if ($result) {
                                    die(json_encode($result));
                                } else {
                                    die(Helper::Json_Message('f'));
                                }

                                break;
                            case __MOSHTARAKUSERTYPE__:
                                $sql = "SELECT id,ibs_username,
                                    IF(type IN ('adsl','vdsl','wireless','tdlte'),'internet',
                                    IF(type IN ('voip'),'voip','notfound')) as 'type' FROM bnm_factor WHERE subscriber_id=? GROUP BY ibs_username,type";
                                $result = Db::secure_fetchall($sql, array($_SESSION['user_id']));
                                if ($result) {
                                    die(json_encode($result));
                                } else {
                                    die(Helper::Json_Message('f'));
                                }

                                break;
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }

                    break;
                case 'online_user_list':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                                if (Helper::Is_Empty_OR_Null($_POST['condition'])) {
                                    $user_id = $_POST['condition'];
                                    $sql = "SELECT id,ibs_username,
                                    IF(type IN ('adsl','vdsl','wireless','tdlte'),'internet',
                                    IF(type IN ('voip'),'voip','notfound')) as 'type' FROM bnm_factor WHERE subscriber_id=? GROUP BY ibs_username,type";
                                    $result = Db::secure_fetchall($sql, array($user_id));
                                }
                                if ($result) {
                                    die(json_encode($result));
                                } else {
                                    die(Helper::Json_Message('f'));
                                }
                                break;
                            case __MODIRUSERTYPE__:
                            case __OPERATORUSERTYPE__:
                            case __MODIR2USERTYPE__:
                            case __OPERATOR2USERTYPE__:
                            case __MOSHTARAKUSERTYPE__:
                                $user_id = $_POST['condition'];
                                $sql = "SELECT id,ibs_username,
                                    IF(type IN ('adsl','vdsl','wireless','tdlte'),'internet',
                                    IF(type IN ('voip'),'voip','notfound')) as 'type' FROM bnm_factor WHERE subscriber_id=? AND branch_id=? GROUP BY ibs_username,type";
                                $result = Db::secure_fetchall($sql, array($user_id, $_SESSION['branch_id']));
                                if ($result) {
                                    die(json_encode($result));
                                } else {
                                    die(Helper::Json_Message('f'));
                                }
                                break;
                            case __MOSHTARAKUSERTYPE__:
                                //$user_id = $_POST['condition'];
                                $sql = "SELECT id,ibs_username,
                                    IF(type IN ('adsl','vdsl','wireless','tdlte'),'internet',
                                    IF(type IN ('voip'),'voip','notfound')) as 'type' FROM bnm_factor WHERE subscriber_id=? GROUP BY ibs_username,type";
                                $result = Db::secure_fetchall($sql, array($_SESSION['user_id']));
                                if ($result) {
                                    die(json_encode($result));
                                } else {
                                    die(Helper::Json_Message('f'));
                                }
                                break;
                            default:
                                die(Helper::Json_Message('af'));
                                break;
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }
                    break;
                case 'bs_services':
                    if (Helper::Login_Just_Check()) {
                        $sql = "SELECT * FROM bnm_services WHERE noe_khadamat=? OR noe_khadamat = ? AND namayeshe_service=? AND tarikhe_shoroe_namayesh<=CURDATE() AND tarikhe_payane_namayesh >= CURDATE()";
                        $result = Db::secure_fetchall($sql, array('BITSTREAM_ADSL', 'BITSTREAM_VDSL', 'yes'), true);
                        if ($result) {
                            die(json_encode($result));
                        } else {
                            die(Helper::Json_Message('f'));
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }

                    break;
                case 'adsl_services':
                    if (Helper::Login_Just_Check()) {
                        $sql = "SELECT * FROM bnm_services WHERE type= ? AND namayeshe_service= ? AND tarikhe_shoroe_namayesh<=CURDATE() AND tarikhe_payane_namayesh >= CURDATE()";
                        $result = Db::secure_fetchall($sql, array('adsl', 'yes'));
                        if ($result) {
                            die(json_encode($result));
                        } else {
                            die(Helper::Json_Message('snf'));
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }

                    break;
                case 'wireless_services':
                    //$id=$_POST['condition'];
                    if (Helper::Login_Just_Check()) {
                        $sql = "SELECT * FROM bnm_services WHERE type='wireless' AND namayeshe_service='yes' AND tarikhe_shoroe_namayesh<=CURDATE() AND tarikhe_payane_namayesh >= CURDATE()";
                        $result = Db::fetchall_Query($sql);
                        if ($result) {
                            die(json_encode($result));
                        } else {
                            die(Helper::Json_Message('snf'));
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }

                    break;
                case 'tdlte_services':
                    //$id=$_POST['condition'];
                    if (Helper::Login_Just_Check()) {
                        $sql = "SELECT * FROM bnm_services WHERE type= ? AND namayeshe_service= ? AND tarikhe_shoroe_namayesh<=CURDATE() AND tarikhe_payane_namayesh >= CURDATE()";
                        $result = Db::secure_fetchall($sql, array('tdlte', 'yes'));
                        if ($result) {
                            die(json_encode($result));
                        } else {
                            die(Helper::Json_Message('snf'));
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }

                    break;
                case 'voip_services':
                    //get voip service info by dates
                    //$id=$_POST['condition'];
                    if (Helper::Login_Just_Check()) {
                        $sql = "SELECT * FROM bnm_services WHERE type= ? AND namayeshe_service= ? AND tarikhe_shoroe_namayesh<=CURDATE() AND tarikhe_payane_namayesh >= CURDATE()";
                        $result = Db::secure_fetchall($sql, array('voip', 'yes'));
                        if ($result) {
                            for ($i = 0; $i < count($result); $i++) {
                                $result[$i]['tarikhe_zamane_estefade'] = Helper::Add_Or_Minus_Day_To_Date(intval($result[$i]['zaname_estefade']));
                            }
                            die(json_encode($result));
                        } else {
                            die(Helper::Json_Message('snf'));
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }

                    break;
                case 'sj_get_ibs_credit':
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            $_POST = Helper::xss_check_array($_POST);
                            if (Helper::Is_Empty_OR_Null($_POST['condition1'])) {
                                $sql = "SELECT id,
                                    IF({$_POST['condition1']} = 1, telephone1,
                                    IF({$_POST['condition1']} = 2, telephone2,
                                    IF({$_POST['condition1']} = 3, telephone3, null))) telephone
                                    FROM bnm_subscribers
                                    WHERE id = ?
                                    ";
                                $res_telephone = Db::secure_fetchall($sql, array($_POST['condition2']));
                            } else {
                                die(Helper::Json_Message('f'));
                            }
                            break;
                        case __OPERATORUSERTYPE__:
                        case __MODIR2USERTYPE__:
                        case __MODIRUSERTYPE__:
                        case __OPERATOR2USERTYPE__:
                            $_POST = Helper::xss_check_array($_POST);
                            if (Helper::Is_Empty_OR_Null($_POST['condition1'])) {
                                $sql = "SELECT id,
                                    IF({$_POST['condition1']} = 1, telephone1,
                                    IF({$_POST['condition1']} = 2, telephone2,
                                    IF({$_POST['condition1']} = 3, telephone3, null))) telephone
                                    FROM bnm_subscribers
                                    WHERE id = ? AND branch_id = ?
                                    ";
                                $res_telephone = Db::secure_fetchall($sql, array($_POST['condition2'], $_SESSION['branch_id']));
                            } else {
                                die(Helper::Json_Message('f'));
                            }
                            break;
                        case __MOSHTARAKUSERTYPE__:
                            if (Helper::Is_Empty_OR_Null($_POST['condition1'])) {
                                $sql = "SELECT id,
                                    IF({$_POST['condition1']} = 1, telephone1,
                                    IF({$_POST['condition1']} = 2, telephone2,
                                    IF({$_POST['condition1']} = 3, telephone3, null))) telephone
                                    FROM bnm_subscribers
                                    WHERE id = ?
                                    ";
                                $res_telephone = Db::secure_fetchall($sql, array($_SESSION['user_id']));
                            } else {
                                die(Helper::Json_Message('f'));
                            }
                            break;
                        default:
                            die(Helper::Json_Message('af'));
                            break;
                    }
                    if ($res_telephone) {
                        $res = $GLOBALS['ibs_voip']->getUserInfoByViopUserName($res_telephone[0]['telephone']);
                        //02122074852 test
                        if (Helper::ibsCheckResponse($res)) {
                            //dar ibs vojod darad
                            $current_credit = intval($res[1][key($res[1])]['basic_info']['credit']);
                            $unixtime = strtotime($res[1][key($res[1])]['attrs']['abs_exp_date']);
                            $exp_date = date("Y-m-d", $unixtime);
                            $today_date = Helper::Today_Miladi_Date();
                            if ($exp_date <= $today_date) {
                                //expire shode pas 1/3 credit ro behesh midim
                                $available_credit = intval($current_credit / 3);
                            } else {
                                //expire nashode pas kole credit ro behesh midim
                                $available_credit = intval($res[1][key($res[1])]['basic_info']['credit']);
                            }
                            die(json_encode(array(
                                'current_credit' => $current_credit,
                                'available_credit' => $available_credit,
                            )));
                            die(json_encode($res[1][key($res[1])]));
                        } else {
                            //factor aval
                            die(json_encode(array(
                                'current_credit' => 0,
                                'available_credit' => 0,
                            )));
                        }
                    } else {
                        die(Helper::Json_Message('f'));
                    }

                    break;
                case 'sj_ip_adsl_get_user_services':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                                $sql = "SELECT
                                        fa.id,
                                        fa.emkanat_id,
                                        fa.service_id,
                                        fa.subscriber_id,
                                        sub.branch_id,
                                        ser.type
                                    FROM bnm_factor fa
                                        INNER JOIN bnm_services ser ON ser.id = fa.service_id
                                        INNER JOIN bnm_subscribers sub ON sub.id = fa.subscriber_id
                                    WHERE fa.subscriber_id = ? AND fa.tasvie_shode = ?
                                    GROUP BY fa.emkanat_id,ser.type";
                                $result = Db::secure_fetchall($sql, [$_POST['condition'], 1]);
                                break;
                            case __MODIRUSERTYPE__:
                            case __OPERATORUSERTYPE__:
                            case __MODIR2USERTYPE__:
                            case __OPERATOR2USERTYPE__:
                                $sql = "SELECT
                                        fa.id,
                                        fa.emkanat_id,
                                        fa.subscriber_id,
                                        fa.service_id,
                                        sub.branch_id,
                                        ser.type
                                    FROM bnm_factor fa
                                        INNER JOIN bnm_services ser ON ser.id = fa.service_id
                                        INNER JOIN bnm_subscribers sub ON sub.id = fa.subscriber_id
                                    WHERE fa.subscriber_id = ? AND fa.tasvie_shode = ? AND sub.branch_id = ?
                                    GROUP BY fa.emkanat_id,ser.type";
                                $result = Db::secure_fetchall($sql, [$_POST['condition'], 1, $_SESSION['branch_id']]);
                                break;
                            case __MOSHTARAKUSERTYPE__:
                                $sql = "SELECT
                                        fa.id,
                                        fa.emkanat_id,
                                        fa.service_id,
                                        fa.subscriber_id,
                                        sub.branch_id,
                                        ser.type
                                    FROM bnm_factor fa
                                        INNER JOIN bnm_services ser ON ser.id = fa.service_id
                                        INNER JOIN bnm_subscribers sub ON sub.id = fa.subscriber_id
                                    WHERE fa.subscriber_id = ? AND fa.tasvie_shode = ?
                                    GROUP BY fa.emkanat_id,ser.type";
                                $result = Db::secure_fetchall($sql, [$_SESSION['user_id'], 1]);
                                break;
                        }
                    }
                    if ($result) {
                        if (isset($result[0])) {
                            $res = Helper::adslUserInfo((int) $result[0]['id'], (int) $result[0]['branch_id']);
                            $result[0]['telephone'] = $res1[0]['telephone'];
                        }
                        if (isset($result[1])) {
                            $res2 = Helper::adslUserInfo((int) $result[1]['id'], (int) $result[1]['branch_id']);
                            $result[1]['telephone'] = $res2[0]['telephone'];
                        }
                        if (isset($result[2])) {
                            $res3 = Helper::adslUserInfo((int) $result[2]['id'], (int) $result[2]['branch_id']);
                            $result[2]['telephone'] = $res3[0]['telephone'];
                        }
                        // die(json_encode($result));
                    } else {
                        die(Helper::Json_Message('f'));
                    }
                    break;
                case 'sj_voip_get_user_telephone':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                                $sql = "SELECT id,telephone1,telephone2,telephone3 FROM bnm_subscribers WHERE id = ?";
                                $result = Db::secure_fetchall($sql, array($_POST['condition']));
                                if ($result) {
                                    $rows = json_encode($result);
                                    die($rows);
                                } else {
                                    die(Helper::Json_Message('f'));
                                }

                                break;
                            case __MODIRUSERTYPE__:
                            case __OPERATORUSERTYPE__:
                            case __MODIR2USERTYPE__:
                            case __OPERATOR2USERTYPE__:
                                $id = $_POST['condition'];
                                $sql = "SELECT id,telephone1,telephone2,telephone3 FROM bnm_subscribers WHERE id = ? AND branch_id=?";
                                $result = Db::secure_fetchall($sql, array($id, $_SESSION['branch_id']));
                                if ($result) {
                                    $rows = json_encode($result);
                                    die($rows);
                                } else {
                                    die(Helper::Json_Message('f'));
                                }

                                break;
                            case __MOSHTARAKUSERTYPE__:
                                $sql = "SELECT id,telephone1,telephone2,telephone3 FROM bnm_subscribers WHERE id = ?";
                                $result = Db::secure_fetchall($sql, array($_SESSION['user_id']));
                                if ($result) {
                                    $rows = json_encode($result);
                                    die($rows);
                                } else {
                                    die(Helper::Json_Message('f'));
                                }

                                break;
                        }
                    }
                    break;
                case 'ekhtesas_adsl_tab_link':
                case 'ekhtesas_vdsl_tab_link':
                case 'ekhtesas_wireless_tab_link':
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                        case __OPERATORUSERTYPE__:
                        case __MODIR2USERTYPE__:
                        case __MODIRUSERTYPE__:
                        case __OPERATOR2USERTYPE__:
                            $result = Helper::Select_By_Id('bnm_subscribers', $_POST['condition']);
                            die(json_encode($result));
                            break;
                        case __MOSHTARAKUSERTYPE__:
                            die(Helper::Json_Message('af'));
                            $result = Helper::Select_By_Id('bnm_subscribers', $_SESSION['user_id']);
                            die(json_encode($result));
                            break;

                        default:
                            die(Helper::Json_Message('af'));
                            break;
                    }

                    break;
                case 'ekhtesas_tdlte_tab_link':
                    $result = Helper::Select_By_Id('bnm_subscribers', $_POST['condition']);
                    if ($result) {
                        //get tdlte simcards where sim card not assigned to user
                        $sim_sql = "SELECT * FROM bnm_tdlte_sim WHERE subscriber_id IS NULL AND subscriber_code_eshterak IS NULL";
                        $res_sim = Db::fetchall_Query($sim_sql);
                        $rows = json_encode($res_sim);
                        die($rows);
                    } else {
                        die(json_encode(array('Error' => 'مشترک مورد تظر یافت نشد پس از بررسی مجددا تلاش کنید.')));
                    }
                    break;
                case 'connection_log':
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                        case __OPERATORUSERTYPE__:
                        case __MODIR2USERTYPE__:
                        case __MODIRUSERTYPE__:
                        case __OPERATOR2USERTYPE__:
                            $user_id = $_POST['condition'];
                            $sql = "SELECT * FROM bnm_factor WHERE subscriber_id=? LIMIT 1";
                            $result = Db::secure_fetchall($sql, array($user_id));
                            if ($result) {
                                $res_ibs = $GLOBALS['ibs_internet']->getUserInfoByNormalUserName($result[0]['ibs_username']);
                                //$res_ibs=$GLOBALS['ibs_internet']->getConnectionLogs(date('Y-m-d').' 23:59:59',date('Y-m-d').' 00:00:00');
                                die(json_encode($res_ibs));
                            } else {
                                die(json_encode(array('factor not found')));
                            }
                            break;
                        case __MOSHTARAKUSERTYPE__:
                            $user_id = $_SESSION['user_id'];
                            $sql = "SELECT * FROM bnm_factor WHERE subscriber_id=? LIMIT 1";
                            $result = Db::secure_fetchall($sql, array($user_id));
                            if ($result) {
                                $res_ibs = $GLOBALS['ibs_internet']->getUserInfoByNormalUserName($result[0]['ibs_username']);
                                //$res_ibs=$GLOBALS['ibs_internet']->getConnectionLogs(date('Y-m-d').' 23:59:59',date('Y-m-d').' 00:00:00');
                                die(json_encode($res_ibs));
                            } else {
                                die(json_encode(array('factor not found')));
                            }
                            break;
                        default:
                            die(Helper::Json_Message('af'));
                            break;
                    }

                    break;
                case 'ekhtesas_adsl_after_select_phone':
                case 'ekhtesas_vdsl_after_select_phone':
                    $result = array();
                    $res_sub = Helper::Select_By_Id('bnm_subscribers', $_POST['condition1']);
                    if ($res_sub) {
                        switch ($_POST['condition2']) {
                            case '1':
                                $selected_phone = $res_sub[0]['telephone1'];
                                break;
                            case '2':
                                $selected_phone = $res_sub[0]['telephone2'];
                                break;
                            case '3':
                                $selected_phone = $res_sub[0]['telephone3'];
                                break;
                            default:
                                die(Helper::Json_Message('f'));
                                break;
                        }
                        $res_telecenter = $res_sar_shomare = $res_shahr = $res_port = $res_ostan = array();
                        $splitnum = array();
                        $splitnum = str_split($selected_phone);
                        $ostan_prenum = $splitnum[0] . $splitnum[1] . $splitnum[2];
                        $markaz_prenum = $splitnum[3] . $splitnum[4] . $splitnum[5] . $splitnum[6];
                        $res_sar_shomare = Db::secure_fetchall("SELECT * FROM bnm_pre_number WHERE prenumber=? ORDER BY id limit 1", array($markaz_prenum));
                        if (!$res_sar_shomare) {
                            die(json_encode(array('Error' => 'امکان ارائه پورت با این پیش شماره وجود ندارد')));
                        }
                        $markaz_id = $res_sar_shomare[0]['markaze_mokhaberati'];
                        $res_telecenter = Db::fetchall_Query("SELECT * FROM bnm_telecommunications_center WHERE id=$markaz_id");
                        if (!$res_telecenter) {
                            die(json_encode(array('Error' => 'مرکز مخابراتی با این پیش شماره یافت نشد')));
                        }
                        $ostan_id = $res_telecenter[0]['ostan'];
                        $shahr_id = $res_telecenter[0]['shahr'];
                        $res_ostan = Db::fetchall_Query("SELECT * FROM bnm_ostan WHERE id =$ostan_id");
                        if (!$res_ostan) {
                            die(json_encode(array('Error' => 'استانی یافت نشد')));
                        }
                        $res_shahr = Db::fetchall_Query("SELECT * FROM bnm_shahr WHERE id =$shahr_id");
                        if (!$res_shahr) {
                            die(json_encode(array('Error' => 'شهری یافت نشد')));
                        }
                        $res_port = Db::fetchall_Query("SELECT * FROM bnm_port WHERE status='salem' AND telephone='' AND adsl_vdsl='adsl' order by id asc limit 1");
                        if (!$res_port) {
                            die(json_encode(array('Error' => 'پورتی یافت نشد!')));
                        }
                        //////////////////initializing result///////////////////////
                        $result[0]['markaz_id'] = $res_telecenter[0]['id'];
                        $result[0]['pish_shomare_ostan'] = $res_telecenter[0]['pish_shomare_ostan'];
                        $result[0]['markaz_id'] = $res_telecenter[0]['id'];
                        $result[0]['markaz_name'] = $res_telecenter[0]['name'];
                        $result[0]['ostan'] = $res_ostan[0]['name'];
                        $result[0]['shahr'] = $res_shahr[0]['name'];
                        $result[0]['port_id'] = $res_port[0]['id'];
                        $result[0]['port_radif'] = $res_port[0]['radif'];
                        $result[0]['port_tighe'] = $res_port[0]['tighe'];
                        $result[0]['port_etesal'] = $res_port[0]['etesal'];
                        $result[0]['telephone'] = $_POST['condition2'];
                        $rows = json_encode($result);
                        die($rows);
                    } else {
                        die(Helper::Json_Message('f'));
                    }
                    // $rows = json_encode($result);
                    // die($rows);
                    break;
                case 'wireless_services':
                    //$id=$_POST['condition'];
                    $sql = "SELECT * FROM bnm_services WHERE type='wireless'";
                    $result = Db::secure_fetchall($sql, array('wireless'));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'tdlte_services':
                    //$id=$_POST['condition'];
                    $sql = "SELECT * FROM bnm_services WHERE type= ?";
                    $result = Db::secure_fetchall($sql, array('tdlte'));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'sefareshe_jadid_serviceslist_li':
                    $sql = "select * FROM bnm_services WHERE id=?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'factors_serviceslist_li':
                    $id = $_POST['condition'];
                    $sql = "select * FROM bnm_services WHERE id='$id'";
                    $result = Db::fetchall_Query($sql);
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'factors':
                    $id = $_POST['condition'];
                    $sql = "select * FROM bnm_services";
                    $result = Db::fetchall_Query($sql);
                    $rows = json_encode($result);
                    die($rows);
                    break;
            }
        }

        ///sefareshe jadid -> factor
        if (isset($_POST['send_sefareshe_jadid_bs']) || isset($_POST['send_sefareshe_jadid_adsl']) || isset($_POST['send_sefareshe_jadid_wireless']) || isset($_POST['send_sefareshe_jadid_tdlte']) || isset($_POST['send_sefareshe_jadid_voip'])) {
            try {
                $_POST = Helper::Create_Post_Array_Without_Key($_POST);
                $_POST = Helper::xss_check_array($_POST);
                if (Helper::Login_Just_Check()) {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            $sql_tax = "SELECT * FROM bnm_tax ORDER BY id DESC LIMIT 1";
                            $res_tax = Db::fetchall_Query($sql_tax);
                            if (!$res_tax) {
                                die(Helper::Json_Message('tinf'));
                            }
                            $sql_services = "SELECT * FROM bnm_services WHERE id = ? AND namayeshe_service='yes' AND tarikhe_shoroe_namayesh<=CURDATE() AND tarikhe_payane_namayesh >= CURDATE()";
                            $res_services = Db::secure_fetchall($sql_services, array($_POST['service_id']), true);
                            $sql_subscriber = "SELECT * FROM bnm_subscribers WHERE id = ?";
                            $res_subscriber = Db::secure_fetchall($sql_subscriber, array($_POST['subscriber_id']), true);
                            if ($res_services) {
                                if ($res_subscriber) {
                                    if (Helper::Is_Empty_OR_Null($res_services[0]['zaname_estefade_be_tarikh']) && Helper::Is_Empty_OR_Null($res_services[0]['onvane_service']) && Helper::Is_Empty_OR_Null($res_subscriber[0]['code_eshterak'])) {
                                        $_POST['zaname_estefade_be_tarikh'] = $res_services[0]['zaname_estefade_be_tarikh'];
                                        $_POST['onvane_service'] = $res_services[0]['onvane_service'];
                                        $_POST['type'] = $res_services[0]['type'];
                                        $_POST['zaname_estefade'] = $res_services[0]['zaname_estefade'];
                                        $_POST['abonmane_port'] = floatval($res_services[0]['port']);
                                        $_POST['abonmane_faza'] = floatval($res_services[0]['faza']);
                                        $_POST['abonmane_tajhizat'] = floatval($res_services[0]['tajhizat']);
                                        $_POST['hazine_ranzhe'] = floatval($res_services[0]['hazine_ranzhe']);
                                        $_POST['hazine_dranzhe'] = floatval($res_services[0]['hazine_dranzhe']);
                                        $_POST['hazine_nasb'] = floatval($res_services[0]['hazine_nasb']);
                                        $_POST['code_eshterak'] = $res_subscriber[0]['code_eshterak'];
                                        $_POST['subscriber_id'] = $res_subscriber[0]['id'];
                                        $_POST['branch_id'] = $res_subscriber[0]['branch_id'];
                                        $_POST['darsade_avareze_arzeshe_afzode'] = floatval($res_tax[0]['darsade_avarez_arzeshe_afzode']);
                                        $_POST['maliate_arzeshe_afzode'] = floatval($res_tax[0]['darsade_maliate_arzeshe_afzode']);
                                        $_POST['sazande_factor_id'] = $_SESSION['id'];
                                        $_POST['sazande_factor_username'] = $_SESSION['username'];
                                        $_POST['sazande_factor_user_type'] = $_SESSION['user_type'];
                                        $_POST['tarikhe_akharin_virayesh'] = Helper::Today_Miladi_Date('/');
                                        $_POST['tarikhe_payane_service'] = Helper::Add_Or_Minus_Day_To_Date($res_services[0]['zaname_estefade']);
                                        $_POST['tarikhe_shoroe_service'] = Helper::Today_Miladi_Date();
                                        $_POST['mablaghe_ghabele_pardakht'] = 0;
                                        $_POST['gheymate_service'] = floatval($res_services[0]['gheymat']);
                                        $_POST['noe_khadamat'] = $res_services[0]['noe_khadamat'];
                                        $_POST['takhfif'] = floatval($res_services[0]['takhfif']);
                                        $_POST['hazine_kharabi'] = $res_services[0]['hazine_kharabi'];
                                        switch ($res_services[0]['type']) {
                                            case 'adsl':
                                                $internal_message_karbord = 'sfadm';
                                                if ($res_user_factors[0]['rows_num'] === 0) {
                                                    //factore aval hazine ranzhe & dranzhe & hazine_nasb hesab shavad
                                                    $_POST['hazine_ranzhe'] = floatval($res_services[0]['hazine_ranzhe']);
                                                    $_POST['hazine_dranzhe'] = floatval($res_services[0]['hazine_dranzhe']);
                                                    $_POST['hazine_nasb'] = floatval($res_services[0]['hazine_nasb']);
                                                } else {
                                                    //factore chandom
                                                    $_POST['hazine_ranzhe'] = 0;
                                                    $_POST['hazine_dranzhe'] = 0;
                                                    $_POST['hazine_nasb'] = 0;
                                                }
                                                if ($_POST['takhfif'] !== 0 && Helper::Is_Empty_OR_Null($_POST['takhfif'])) {
                                                    $_POST['takhfif'] = floatval($_POST['takhfif']);
                                                    $_POST['takhfif'] = ($_POST['takhfif'] * $_POST['gheymate_service']) / 100;
                                                    $gheymat = $_POST['gheymate_service'] - $_POST['takhfif'];
                                                } else {
                                                    $gheymat = $_POST['gheymate_service'];
                                                }
                                                $_POST['mablaghe_ghabele_pardakht'] = $gheymat + floatval($res_services[0]['hazine_ranzhe'])
                                                 + floatval($res_services[0]['hazine_nasb']) + floatval($res_services[0]['hazine_dranzhe'])
                                                 + floatval($res_services[0]['port']) + floatval($res_services[0]['faza'])
                                                 + floatval($res_services[0]['tajhizat']);
                                                $_POST['darsade_avareze_arzeshe_afzode'] = floatval($_POST['mablaghe_ghabele_pardakht'] * (floatval($_POST['darsade_avareze_arzeshe_afzode'] / 100)));
                                                $_POST['maliate_arzeshe_afzode'] = floatval($_POST['mablaghe_ghabele_pardakht'] * (floatval($_POST['maliate_arzeshe_afzode'] / 100)));
                                                $_POST['mablaghe_ghabele_pardakht'] = $_POST['mablaghe_ghabele_pardakht'] + $_POST['darsade_avareze_arzeshe_afzode'] + $_POST['maliate_arzeshe_afzode'];
                                                $_POST['gheymate_service'] = floatval($res_services[0]['gheymat']);

                                                $_POST['emkanat_id'] = $_POST['port_id'];
                                                unset($_POST['port_id']);
                                                break;
                                            case 'vdsl':
                                                $internal_message_karbord = 'sfvdm';
                                                //$_POST['ibs_username']    = $res_subscriber[0]['code_meli'];
                                                if ($res_user_factors[0]['rows_num'] === 0) {
                                                    //factore aval hazine ranzhe & dranzhe & hazine_nasb hesab shavad
                                                    $_POST['hazine_ranzhe'] = floatval($res_services[0]['hazine_ranzhe']);
                                                    $_POST['hazine_dranzhe'] = floatval($res_services[0]['hazine_dranzhe']);
                                                    $_POST['hazine_nasb'] = floatval($res_services[0]['hazine_nasb']);
                                                } else {
                                                    //factore chandom
                                                    $_POST['hazine_ranzhe'] = 0;
                                                    $_POST['hazine_dranzhe'] = 0;
                                                    $_POST['hazine_nasb'] = 0;
                                                }
                                                if ($_POST['takhfif'] !== 0 && Helper::Is_Empty_OR_Null($_POST['takhfif'])) {
                                                    $_POST['takhfif'] = floatval($_POST['takhfif']);
                                                    $_POST['takhfif'] = ($_POST['takhfif'] * $_POST['gheymate_service']) / 100;
                                                    $gheymat = $_POST['gheymate_service'] - $_POST['takhfif'];
                                                } else {
                                                    $gheymat = $_POST['gheymate_service'];
                                                }
                                                $_POST['mablaghe_ghabele_pardakht'] = $gheymat + floatval($res_services[0]['hazine_ranzhe'])
                                                 + floatval($res_services[0]['hazine_nasb']) + floatval($res_services[0]['hazine_dranzhe'])
                                                 + floatval($res_services[0]['port']) + floatval($res_services[0]['faza'])
                                                 + floatval($res_services[0]['tajhizat']);
                                                $_POST['darsade_avareze_arzeshe_afzode'] = floatval($_POST['mablaghe_ghabele_pardakht'] * (floatval($_POST['darsade_avareze_arzeshe_afzode'] / 100)));
                                                $_POST['maliate_arzeshe_afzode'] = floatval($_POST['mablaghe_ghabele_pardakht'] * (floatval($_POST['maliate_arzeshe_afzode'] / 100)));
                                                $_POST['mablaghe_ghabele_pardakht'] = $_POST['mablaghe_ghabele_pardakht'] + $_POST['darsade_avareze_arzeshe_afzode'] + $_POST['maliate_arzeshe_afzode'];
                                                $_POST['gheymate_service'] = floatval($res_services[0]['gheymat']);

                                                $_POST['emkanat_id'] = $_POST['port_id'];
                                                unset($_POST['port_id']);
                                                ///1-check user has factor or not

                                                break;
                                            case 'wireless':
                                                $_POST['emkanat_id'] = $_POST['istgah_name'];
                                                unset($_POST['istgah_name']);
                                                // $_POST['ibs_username']      = $res_subscriber[0]['code_meli'];
                                                $internal_message_karbord = 'sfwim';
                                                $_POST['hazine_ranzhe'] = 0;
                                                $_POST['hazine_dranzhe'] = 0;
                                                if ($res_user_factors[0]['rows_num'] === 0) {
                                                    $_POST['hazine_nasb'] = floatval($res_services[0]['hazine_nasb']);
                                                } else {
                                                    $_POST['hazine_nasb'] = 0;
                                                }
                                                $_POST['takhfif'] = floatval($_POST['takhfif']);
                                                $_POST['takhfif'] = ($_POST['takhfif'] * $_POST['gheymate_service']) / 100;
                                                if ($_POST['takhfif'] !== 0 && Helper::Is_Empty_OR_Null($_POST['takhfif'])) {
                                                    $gheymat = $_POST['gheymate_service'] - $_POST['takhfif'];
                                                } else {
                                                    $gheymat = $_POST['gheymate_service'];
                                                }
                                                $_POST['mablaghe_ghabele_pardakht'] = $gheymat
                                                 + floatval($res_services[0]['hazine_nasb']) + floatval($res_services[0]['faza'])
                                                 + floatval($res_services[0]['port']) + floatval($res_services[0]['tajhizat']);
                                                $_POST['darsade_avareze_arzeshe_afzode'] = floatval($_POST['mablaghe_ghabele_pardakht'] * (floatval($_POST['darsade_avareze_arzeshe_afzode'] / 100)));
                                                $_POST['maliate_arzeshe_afzode'] = floatval($_POST['mablaghe_ghabele_pardakht'] * (floatval($_POST['maliate_arzeshe_afzode'] / 100)));
                                                $_POST['mablaghe_ghabele_pardakht'] = $_POST['mablaghe_ghabele_pardakht'] + $_POST['darsade_avareze_arzeshe_afzode'] + $_POST['maliate_arzeshe_afzode'];
                                                $_POST['gheymate_service'] = floatval($res_services[0]['gheymat']);
                                                break;
                                            case 'tdlte':
                                                unset($_POST['ibs_username']);
                                                $internal_message_karbord = 'sftdm';
                                                unset($_POST['istgah_name']);
                                                $_POST['hazine_ranzhe'] = 0;
                                                $_POST['hazine_dranzhe'] = 0;
                                                if ($res_user_factors[0]['rows_num'] === 0) {
                                                    $_POST['hazine_nasb'] = floatval($res_services[0]['hazine_nasb']);
                                                } else {
                                                    $_POST['hazine_nasb'] = 0;
                                                }
                                                $_POST['takhfif'] = floatval($_POST['takhfif']);
                                                $_POST['takhfif'] = ($_POST['takhfif'] * $_POST['gheymate_service']) / 100;
                                                if ($_POST['takhfif'] !== 0 && Helper::Is_Empty_OR_Null($_POST['takhfif'])) {
                                                    $gheymat = $_POST['gheymate_service'] - $_POST['takhfif'];
                                                } else {
                                                    $gheymat = $_POST['gheymate_service'];
                                                }
                                                $_POST['mablaghe_ghabele_pardakht'] = $gheymat
                                                 + floatval($res_services[0]['hazine_nasb']) + floatval($res_services[0]['faza'])
                                                 + floatval($res_services[0]['port']) + floatval($res_services[0]['tajhizat']);
                                                $_POST['darsade_avareze_arzeshe_afzode'] = floatval($_POST['mablaghe_ghabele_pardakht'] * (floatval($_POST['darsade_avareze_arzeshe_afzode'] / 100)));
                                                $_POST['maliate_arzeshe_afzode'] = floatval($_POST['mablaghe_ghabele_pardakht'] * (floatval($_POST['maliate_arzeshe_afzode'] / 100)));
                                                $_POST['mablaghe_ghabele_pardakht'] = $_POST['mablaghe_ghabele_pardakht'] + $_POST['darsade_avareze_arzeshe_afzode'] + $_POST['maliate_arzeshe_afzode'];
                                                $_POST['gheymate_service'] = floatval($res_services[0]['gheymat']);
                                                break;
                                            case 'voip':
                                                $_POST['emkanat_id'] = $_POST['ibs_username'];
                                                unset($_POST['ibs_username']);
                                                $internal_message_karbord = 'sfvom';
                                                $_POST['hazine_ranzhe'] = 0;
                                                $_POST['hazine_dranzhe'] = 0;
                                                $_POST['hazine_nasb'] = 0;
                                                $_POST['takhfif'] = floatval($_POST['takhfif']);
                                                $_POST['takhfif'] = ($_POST['takhfif'] * $_POST['gheymate_service']) / 100;
                                                if ($_POST['takhfif'] !== 0 && Helper::Is_Empty_OR_Null($_POST['takhfif'])) {
                                                    $gheymat = $_POST['gheymate_service'] - $_POST['takhfif'];
                                                } else {
                                                    $gheymat = $_POST['gheymate_service'];
                                                }
                                                // $_POST['mablaghe_ghabele_pardakht'] = $gheymat + floatval($res_services[0]['hazine_ranzhe'])
                                                //  + floatval($res_services[0]['hazine_nasb']) + floatval($res_services[0]['hazine_dranzhe'])
                                                //  + floatval($res_services[0]['port']) + floatval($res_services[0]['faza'])
                                                //  + floatval($res_services[0]['tajhizat']);
                                                $_POST['mablaghe_ghabele_pardakht'] = $gheymat;
                                                $_POST['darsade_avareze_arzeshe_afzode'] = floatval($_POST['mablaghe_ghabele_pardakht'] * (floatval($_POST['darsade_avareze_arzeshe_afzode'] / 100)));
                                                $_POST['maliate_arzeshe_afzode'] = floatval($_POST['mablaghe_ghabele_pardakht'] * (floatval($_POST['maliate_arzeshe_afzode'] / 100)));
                                                $_POST['mablaghe_ghabele_pardakht'] = $_POST['mablaghe_ghabele_pardakht'] + $_POST['darsade_avareze_arzeshe_afzode'] + $_POST['maliate_arzeshe_afzode'];
                                                $_POST['gheymate_service'] = floatval($res_services[0]['gheymat']);
                                                break;
                                            default:
                                                die(Helper::Json_Message('sinf'));
                                                break;
                                        }
                                        unset($_POST['ibs_username']);
                                        // die(json_encode($_POST));
                                        $sql = "SELECT f.id,f.emkanat_id,s.id,s.type,s.noe_forosh FROM bnm_factor f
                                                    INNER JOIN bnm_services s ON f.service_id = s.id
                                                    WHERE f.emkanat_id = ? AND s.type = ? AND f.subscriber_id = ? AND f.tasvie_shode = ?";
                                        $res = Db::secure_fetchall($sql, array(
                                            $_POST['emkanat_id'],
                                            $res_services[0]['type'],
                                            $res_subscriber[0]['id'],
                                            1,
                                        ));

                                        if ($res_services[0]['type'] !== 'voip') {
                                            if (!$res) {
                                                //moshtarak jadid ast
                                                if ($res_services[0]['noe_forosh'] === 'adi' || $res_services[0]['noe_forosh'] === 'jashnvare') {
                                                    $sql = Helper::Insert_Generator($_POST, 'bnm_factor');
                                                    $result = Db::secure_insert_array($sql, $_POST);
                                                } elseif ($res[0]['noe_forosh'] === 'bulk') {
                                                    die(Helper::Custom_Msg(Helper::Messages('ffcbb'), 3));
                                                } else {
                                                    die(Helper::Json_Message('f'));
                                                }
                                            } else {
                                                //check tarikhe akharin factor adi ya jashnvare
                                                $sql = "
                                                        SELECT f.id FROM bnm_factor f
                                                        INNER JOIN bnm_services s ON s.id = f.service_id
                                                        WHERE f.emkanat_id = ? AND f.subscriber_id = ? AND s.type = ? AND s.noe_forosh IN ('adi','jashnvare') AND DATE(f.tarikhe_payane_service) > CURDATE()
                                                        ";
                                                $res2 = Db::secure_fetchall($sql, array(
                                                    $_POST['emkanat_id'],
                                                    $res_subscriber[0]['id'],
                                                    $res_services[0]['type'],
                                                ));
                                                if ($res2) {
                                                    //faghat bulk
                                                    if ($res_services[0]['noe_forosh'] === "bulk") {
                                                        $_POST['hazine_ranzhe'] = 0;
                                                        $_POST['hazine_dranzhe'] = 0;
                                                        $_POST['hazine_nasb'] = 0;
                                                        $sql = Helper::Insert_Generator($_POST, 'bnm_factor');
                                                        $result = Db::secure_insert_array($sql, $_POST);
                                                    } else {
                                                        die(Helper::Custom_Msg(Helper::Messages('bbso'), 3));
                                                    }
                                                } else {
                                                    //faghat adi
                                                    if ($res_services[0]['noe_forosh'] === "adi") {
                                                        // $checkpreviousefactor=Helper::checkNormalPreviousFactorExist($res_subscriber[0]['id'], $)
                                                        $sql = Helper::Insert_Generator($_POST, 'bnm_factor');
                                                        $result = Db::secure_insert_array($sql, $_POST);
                                                    } else {
                                                        die(Helper::Custom_Msg(Helper::Messages('baso'), 3));
                                                    }
                                                }
                                            }
                                        } else {
                                            if (!$res) {
                                                //moshtarak jadid ast
                                                if ($res_services[0]['noe_forosh'] === 'adi' || $res_services[0]['noe_forosh'] === 'jashnvare') {
                                                    $_POST['etebare_baghimande'] = 0;
                                                    $_POST['etebare_ghabele_enteghal'] = 0;
                                                    $sql = Helper::Insert_Generator($_POST, 'bnm_factor');
                                                    $result = Db::secure_insert_array($sql, $_POST);
                                                } elseif ($res_services[0]['noe_forosh'] === 'bulk') {
                                                    die(Helper::Custom_Msg(Helper::Messages('ffcbb'), 3));
                                                } else {
                                                    die(Helper::Json_Message('f'));
                                                }
                                            } else {
                                                //ghablan ro in shomare service kharide
                                                $sql = "SELECT
                                                            id,
                                                            IF({$_POST['emkanat_id']} = 1, telephone1,
                                                            IF({$_POST['emkanat_id']} = 2, telephone2,
                                                            IF({$_POST['emkanat_id']} = 3, telephone3, null))) telephone
                                                            FROM bnm_subscribers
                                                            WHERE id = ?
                                                        ";
                                                $res_telephone = Db::secure_fetchall($sql, array($res_subscriber[0]['id']));
                                                if ($res_telephone) {
                                                    if (Helper::Is_Empty_OR_Null($res_telephone)) {
                                                        $res = $GLOBALS['ibs_voip']->getUserInfoByViopUserName($res_telephone[0]['telephone']);
                                                        if (Helper::ibsCheckResponse($res)) {
                                                            //dar ibs vojod darad
                                                            $unixtime = strtotime($res[1][key($res[1])]['attrs']['abs_exp_date']);
                                                            $exp_date = date("Y-m-d", $unixtime);
                                                            $today_date = Helper::Today_Miladi_Date();
                                                            if ($exp_date <= $today_date) {
                                                                //expire shode pas 1/3 credit ro behesh midim
                                                                $_POST['etebare_baghimande'] = intval($res[1][key($res[1])]['basic_info']['credit']);
                                                                $_POST['etebare_ghabele_enteghal'] = intval($_POST['etebare_baghimande'] / 3);
                                                                $sql = Helper::Insert_Generator($_POST, 'bnm_factor');
                                                                $result = Db::secure_insert_array($sql, $_POST);
                                                            } else {
                                                                //expire nashode pas kole credit ro behesh midim
                                                                $_POST['etebare_baghimande'] = intval($res[1][key($res[1])]['basic_info']['credit']);
                                                                $_POST['etebare_ghabele_enteghal'] = intval($res[1][key($res[1])]['basic_info']['credit']);
                                                                $sql = Helper::Insert_Generator($_POST, 'bnm_factor');
                                                                $result = Db::secure_insert_array($sql, $_POST);
                                                            }
                                                        } else {
                                                            //moshtarak factor darad vali dar ibs nist !!!!!
                                                            $_POST['etebare_baghimande'] = 0;
                                                            $_POST['etebare_ghabele_enteghal'] = 0;
                                                        }
                                                    } else {
                                                        die(Helper::Json_Message('f'));
                                                    }
                                                } else {
                                                    die(Helper::Json_Message('f'));
                                                }
                                            }
                                        }
                                        if ($result) {
                                            $id = (int) $result;
                                            $arr = array();
                                            $arr['shomare_factor'] = $id + 1000;
                                            $arr['id'] = $id;
                                            $sql3 = Helper::Update_Generator($arr, 'bnm_factor', "WHERE id = :id");
                                            $res3 = Db::secure_update_array($sql3, $arr);
                                            /////////////////////////send sms///////////////////////////
                                            $res_factor = Helper::Select_By_Id('bnm_factor', $id);
                                            $res_sub = Helper::Select_By_Id('bnm_subscribers', $res_factor[0]['subscriber_id']);
                                            $msg = 'شناسه فاکتور: ' . $result;
                                            if ($res_sub) {
                                                if ($res_sub[0]['branch_id'] === 0) {
                                                    ////user sahar
                                                    $res_internal = Helper::Internal_Message_By_Karbord($internal_message_karbord . 's', '1');
                                                    if ($res_internal) {
                                                        $sql = Helper::Insert_Generator(
                                                            array(
                                                                'message' => $res_internal[0]['message'],
                                                                'type' => 2,
                                                                'message_subject' => $res_internal[0]['karbord'],
                                                            ),
                                                            'bnm_messages'
                                                        );
                                                        $res_message = Db::secure_insert_array($sql, array(
                                                            'message' => $res_internal[0]['message'],
                                                            'type' => 2,
                                                            'message_subject' => $res_internal[0]['karbord'],
                                                        ));
                                                        $res_sms_request = Helper::Write_In_Sms_Request(
                                                            $res_sub[0]['telephone_hamrah'],
                                                            Helper::Today_Miladi_Date(),
                                                            Helper::Today_Miladi_Date(),
                                                            1,
                                                            $res_message
                                                        );
                                                        if ($res_sms_request) {
                                                            $arr = array();
                                                            $arr['receiver'] = $res_sub[0]['telephone_hamrah'];
                                                            $arr['sender'] = __SMSNUMBER__;
                                                            $arr['request_id'] = $res_sms_request;
                                                            $res = Helper::Write_In_Sms_Queue($arr);
                                                        }
                                                        die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . $msg, 1));
                                                    } else {
                                                        die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns')));
                                                    }
                                                } elseif (Helper::Is_Empty_OR_Null($res_sub[0]['branch_id'])) {
                                                    //user namayande
                                                    $res_internal = Helper::Internal_Message_By_Karbord($internal_message_karbord . 'n', '1');
                                                    if ($res_internal) {
                                                        $sql = Helper::Insert_Generator(
                                                            array(
                                                                'message' => $res_internal[0]['message'],
                                                                'type' => 2,
                                                                'message_subject' => $res_internal[0]['karbord'],
                                                            ),
                                                            'bnm_messages'
                                                        );
                                                        $res_message = Db::secure_insert_array($sql, array(
                                                            'message' => $res_internal[0]['message'],
                                                            'type' => 2,
                                                            'message_subject' => $res_internal[0]['karbord'],
                                                        ));
                                                        $res_sms_request = Helper::Write_In_Sms_Request(
                                                            $res_sub[0]['telephone_hamrah'],
                                                            Helper::Today_Miladi_Date(),
                                                            Helper::Today_Miladi_Date(),
                                                            1,
                                                            $res_message
                                                        );
                                                        if ($res_sms_request) {
                                                            $arr = array();
                                                            $arr['receiver'] = $res_sub[0]['telephone_hamrah'];
                                                            $arr['sender'] = __SMSNUMBER__;
                                                            $arr['request_id'] = $res_sms_request;
                                                            $res = Helper::Write_In_Sms_Queue($arr);
                                                        }

                                                        die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . $msg, 1));
                                                    } else {
                                                        die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns')));
                                                    }
                                                }
                                            } else {
                                                die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . $msg, 1));
                                            }
                                            die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . $msg, 1));
                                        } else {
                                            ////age be har dalili natonestim factor sabt konim
                                            die(Helper::Json_Message('f'));
                                        }
                                    } else {
                                        ////age etelaate karbar naghes bod
                                        die(Helper::Json_Message('sinr'));
                                    }
                                } else {
                                    die(Helper::Json_Message('subscriber_info_not_found'));
                                }
                            } else {
                                die(Helper::Json_Message('service_info_not_found'));
                            }
                            break;
                        case __MODIRUSERTYPE__:
                        case __OPERATORUSERTYPE__:
                        case __MODIR2USERTYPE__:
                        case __OPERATOR2USERTYPE__:
                            $_POST = Helper::Create_Post_Array_Without_Key($_POST);
                            $_POST = Helper::xss_check_array($_POST);
                            $service_id = $_POST['service_id'];
                            $sql_tax = "SELECT * FROM bnm_tax ORDER BY id DESC LIMIT 1";
                            $res_tax = Db::fetchall_Query($sql_tax);
                            if (!$res_tax) {
                                die(Helper::Json_Message('tinf'));
                            }
                            $sql_services = "SELECT * FROM bnm_services WHERE id =? AND namayeshe_service='yes' AND tarikhe_shoroe_namayesh<=CURDATE() AND tarikhe_payane_namayesh >= CURDATE()";
                            $res_services = Db::secure_fetchall($sql_services, array($_POST['service_id']));
                            $sql_subscriber = "SELECT * FROM bnm_subscribers WHERE id = ? AND branch_id=?";
                            $res_subscriber = Db::secure_fetchall($sql_subscriber, array($_POST['subscriber_id'], $_SESSION['branch_id']));
                            ///check ke factor avale user hast ya na
                            $factor_sql = "SELECT count(*) as rows_num FROM bnm_factor WHERE subscriber_id=? AND tasvie_shode='1' AND type = ? AND branch_id=?";
                            $res_user_factors = Db::secure_fetchall($factor_sql, array($res_subscriber[0]['id'], $res_services[0]['type'], $_SESSION['branch_id']));
                            if ($res_services) {
                                if ($res_subscriber) {
                                    if ($res_user_factors) {
                                        if (Helper::Is_Empty_OR_Null($res_services[0]['zaname_estefade_be_tarikh']) && Helper::Is_Empty_OR_Null($res_services[0]['onvane_service']) && Helper::Is_Empty_OR_Null($res_subscriber[0]['code_eshterak'])) {
                                            $_POST['zaname_estefade_be_tarikh'] = $res_services[0]['zaname_estefade_be_tarikh'];
                                            $_POST['onvane_service'] = $res_services[0]['onvane_service'];
                                            $_POST['type'] = $res_services[0]['type'];
                                            $_POST['zaname_estefade'] = $res_services[0]['zaname_estefade'];
                                            $_POST['abonmane_port'] = floatval($res_services[0]['port']);
                                            $_POST['abonmane_faza'] = floatval($res_services[0]['faza']);
                                            $_POST['abonmane_tajhizat'] = floatval($res_services[0]['tajhizat']);
                                            $_POST['hazine_ranzhe'] = floatval($res_services[0]['hazine_ranzhe']);
                                            $_POST['hazine_dranzhe'] = floatval($res_services[0]['hazine_dranzhe']);
                                            $_POST['hazine_nasb'] = floatval($res_services[0]['hazine_nasb']);
                                            $_POST['code_eshterak'] = $res_subscriber[0]['code_eshterak'];
                                            $_POST['subscriber_id'] = $res_subscriber[0]['id'];
                                            $_POST['branch_id'] = $res_subscriber[0]['branch_id'];
                                            $_POST['darsade_avareze_arzeshe_afzode'] = floatval($res_tax[0]['darsade_avarez_arzeshe_afzode']);
                                            $_POST['maliate_arzeshe_afzode'] = floatval($res_tax[0]['darsade_maliate_arzeshe_afzode']);
                                            $_POST['sazande_factor_id'] = $_SESSION['id'];
                                            $_POST['sazande_factor_username'] = $_SESSION['username'];
                                            $_POST['sazande_factor_user_type'] = $_SESSION['user_type'];
                                            $_POST['tarikhe_akharin_virayesh'] = date('Y-m-d');
                                            $_POST['mablaghe_ghabele_pardakht'] = 0;
                                            $_POST['gheymate_service'] = floatval($res_services[0]['gheymat']);
                                            $_POST['noe_khadamat'] = $res_services[0]['noe_khadamat'];
                                            $_POST['takhfif'] = floatval($res_services[0]['takhfif']);
                                            $_POST['hazine_kharabi'] = $res_services[0]['hazine_kharabi'];
                                            switch ($res_services[0]['type']) {
                                                case 'adsl':
                                                    $internal_message_karbord = 'sfadm';
                                                    if ($res_user_factors[0]['rows_num'] === 0) {
                                                        //factore aval hazine ranzhe & dranzhe & hazine_nasb hesab shavad
                                                        $_POST['hazine_ranzhe'] = floatval($res_services[0]['hazine_ranzhe']);
                                                        $_POST['hazine_dranzhe'] = floatval($res_services[0]['hazine_dranzhe']);
                                                        $_POST['hazine_nasb'] = floatval($res_services[0]['hazine_nasb']);
                                                    } else {
                                                        //factore chandom
                                                        $_POST['hazine_ranzhe'] = 0;
                                                        $_POST['hazine_dranzhe'] = 0;
                                                        $_POST['hazine_nasb'] = 0;
                                                    }
                                                    if ($_POST['takhfif'] !== 0 && Helper::Is_Empty_OR_Null($_POST['takhfif'])) {
                                                        $_POST['takhfif'] = floatval($_POST['takhfif']);
                                                        $_POST['takhfif'] = ($_POST['takhfif'] * $_POST['gheymate_service']) / 100;
                                                        $gheymat = $_POST['gheymate_service'] - $_POST['takhfif'];
                                                    } else {
                                                        $gheymat = $_POST['gheymate_service'];
                                                    }
                                                    $_POST['mablaghe_ghabele_pardakht'] = $gheymat + floatval($res_services[0]['hazine_ranzhe'])
                                                     + floatval($res_services[0]['hazine_nasb']) + floatval($res_services[0]['hazine_dranzhe'])
                                                     + floatval($res_services[0]['port']) + floatval($res_services[0]['faza'])
                                                     + floatval($res_services[0]['tajhizat']);
                                                    $_POST['darsade_avareze_arzeshe_afzode'] = floatval($_POST['mablaghe_ghabele_pardakht'] * (floatval($_POST['darsade_avareze_arzeshe_afzode'] / 100)));
                                                    $_POST['maliate_arzeshe_afzode'] = floatval($_POST['mablaghe_ghabele_pardakht'] * (floatval($_POST['maliate_arzeshe_afzode'] / 100)));
                                                    $_POST['mablaghe_ghabele_pardakht'] = $_POST['mablaghe_ghabele_pardakht'] + $_POST['darsade_avareze_arzeshe_afzode'] + $_POST['maliate_arzeshe_afzode'];
                                                    $_POST['gheymate_service'] = floatval($res_services[0]['gheymat']);
                                                    break;
                                                case 'vdsl':
                                                    $internal_message_karbord = 'sfvdm';
                                                    if ($res_user_factors[0]['rows_num'] === 0) {
                                                        //factore aval hazine ranzhe & dranzhe & hazine_nasb hesab shavad
                                                        $_POST['hazine_ranzhe'] = floatval($res_services[0]['hazine_ranzhe']);
                                                        $_POST['hazine_dranzhe'] = floatval($res_services[0]['hazine_dranzhe']);
                                                        $_POST['hazine_nasb'] = floatval($res_services[0]['hazine_nasb']);
                                                    } else {
                                                        //factore chandom
                                                        $_POST['hazine_ranzhe'] = 0;
                                                        $_POST['hazine_dranzhe'] = 0;
                                                        $_POST['hazine_nasb'] = 0;
                                                    }
                                                    if ($_POST['takhfif'] !== 0 && Helper::Is_Empty_OR_Null($_POST['takhfif'])) {
                                                        $_POST['takhfif'] = floatval($_POST['takhfif']);
                                                        $_POST['takhfif'] = ($_POST['takhfif'] * $_POST['gheymate_service']) / 100;
                                                        $gheymat = $_POST['gheymate_service'] - $_POST['takhfif'];
                                                    } else {
                                                        $gheymat = $_POST['gheymate_service'];
                                                    }
                                                    $_POST['mablaghe_ghabele_pardakht'] = $gheymat + floatval($res_services[0]['hazine_ranzhe'])
                                                     + floatval($res_services[0]['hazine_nasb']) + floatval($res_services[0]['hazine_dranzhe'])
                                                     + floatval($res_services[0]['port']) + floatval($res_services[0]['faza'])
                                                     + floatval($res_services[0]['tajhizat']);
                                                    $_POST['darsade_avareze_arzeshe_afzode'] = floatval($_POST['mablaghe_ghabele_pardakht'] * (floatval($_POST['darsade_avareze_arzeshe_afzode'] / 100)));
                                                    $_POST['maliate_arzeshe_afzode'] = floatval($_POST['mablaghe_ghabele_pardakht'] * (floatval($_POST['maliate_arzeshe_afzode'] / 100)));
                                                    $_POST['mablaghe_ghabele_pardakht'] = $_POST['mablaghe_ghabele_pardakht'] + $_POST['darsade_avareze_arzeshe_afzode'] + $_POST['maliate_arzeshe_afzode'];
                                                    $_POST['gheymate_service'] = floatval($res_services[0]['gheymat']);
                                                    break;
                                                case 'wireless':
                                                    $internal_message_karbord = 'sfwim';
                                                    unset($_POST['istgah_name']);
                                                    $_POST['hazine_ranzhe'] = 0;
                                                    $_POST['hazine_dranzhe'] = 0;
                                                    if ($res_user_factors[0]['rows_num'] === 0) {
                                                        $_POST['hazine_nasb'] = floatval($res_services[0]['hazine_nasb']);
                                                    } else {
                                                        $_POST['hazine_nasb'] = 0;
                                                    }
                                                    $_POST['takhfif'] = floatval($_POST['takhfif']);
                                                    $_POST['takhfif'] = ($_POST['takhfif'] * $_POST['gheymate_service']) / 100;
                                                    if ($_POST['takhfif'] !== 0 && Helper::Is_Empty_OR_Null($_POST['takhfif'])) {
                                                        $gheymat = $_POST['gheymate_service'] - $_POST['takhfif'];
                                                    } else {
                                                        $gheymat = $_POST['gheymate_service'];
                                                    }
                                                    $_POST['mablaghe_ghabele_pardakht'] = $gheymat
                                                     + floatval($res_services[0]['hazine_nasb']) + floatval($res_services[0]['faza'])
                                                     + floatval($res_services[0]['port']) + floatval($res_services[0]['tajhizat']);
                                                    $_POST['darsade_avareze_arzeshe_afzode'] = floatval($_POST['mablaghe_ghabele_pardakht'] * (floatval($_POST['darsade_avareze_arzeshe_afzode'] / 100)));
                                                    $_POST['maliate_arzeshe_afzode'] = floatval($_POST['mablaghe_ghabele_pardakht'] * (floatval($_POST['maliate_arzeshe_afzode'] / 100)));
                                                    $_POST['mablaghe_ghabele_pardakht'] = $_POST['mablaghe_ghabele_pardakht'] + $_POST['darsade_avareze_arzeshe_afzode'] + $_POST['maliate_arzeshe_afzode'];
                                                    $_POST['gheymate_service'] = floatval($res_services[0]['gheymat']);
                                                    break;
                                                    break;
                                                case 'tdlte':
                                                    $internal_message_karbord = 'sftdm';
                                                    unset($_POST['istgah_name']);
                                                    $_POST['hazine_ranzhe'] = 0;
                                                    $_POST['hazine_dranzhe'] = 0;
                                                    if ($res_user_factors[0]['rows_num'] === 0) {
                                                        $_POST['hazine_nasb'] = floatval($res_services[0]['hazine_nasb']);
                                                    } else {
                                                        $_POST['hazine_nasb'] = 0;
                                                    }
                                                    $_POST['takhfif'] = floatval($_POST['takhfif']);
                                                    $_POST['takhfif'] = ($_POST['takhfif'] * $_POST['gheymate_service']) / 100;
                                                    if ($_POST['takhfif'] !== 0 && Helper::Is_Empty_OR_Null($_POST['takhfif'])) {
                                                        $gheymat = $_POST['gheymate_service'] - $_POST['takhfif'];
                                                    } else {
                                                        $gheymat = $_POST['gheymate_service'];
                                                    }
                                                    $_POST['mablaghe_ghabele_pardakht'] = $gheymat
                                                     + floatval($res_services[0]['hazine_nasb']) + floatval($res_services[0]['faza'])
                                                     + floatval($res_services[0]['port']) + floatval($res_services[0]['tajhizat']);
                                                    $_POST['darsade_avareze_arzeshe_afzode'] = floatval($_POST['mablaghe_ghabele_pardakht'] * (floatval($_POST['darsade_avareze_arzeshe_afzode'] / 100)));
                                                    $_POST['maliate_arzeshe_afzode'] = floatval($_POST['mablaghe_ghabele_pardakht'] * (floatval($_POST['maliate_arzeshe_afzode'] / 100)));
                                                    $_POST['mablaghe_ghabele_pardakht'] = $_POST['mablaghe_ghabele_pardakht'] + $_POST['darsade_avareze_arzeshe_afzode'] + $_POST['maliate_arzeshe_afzode'];
                                                    $_POST['gheymate_service'] = floatval($res_services[0]['gheymat']);
                                                    break;
                                                case 'voip':
                                                    $internal_message_karbord = 'sfvom';
                                                    $_POST['hazine_ranzhe'] = 0;
                                                    $_POST['hazine_dranzhe'] = 0;
                                                    $_POST['hazine_nasb'] = 0;
                                                    $_POST['takhfif'] = floatval($_POST['takhfif']);
                                                    $_POST['takhfif'] = ($_POST['takhfif'] * $_POST['gheymate_service']) / 100;
                                                    if ($_POST['takhfif'] !== 0 && Helper::Is_Empty_OR_Null($_POST['takhfif'])) {
                                                        $gheymat = $_POST['gheymate_service'] - $_POST['takhfif'];
                                                    } else {
                                                        $gheymat = $_POST['gheymate_service'];
                                                    }
                                                    // $_POST['mablaghe_ghabele_pardakht'] = $gheymat + floatval($res_services[0]['hazine_ranzhe'])
                                                    //  + floatval($res_services[0]['hazine_nasb']) + floatval($res_services[0]['hazine_dranzhe'])
                                                    //  + floatval($res_services[0]['port']) + floatval($res_services[0]['faza'])
                                                    //  + floatval($res_services[0]['tajhizat']);
                                                    $_POST['darsade_avareze_arzeshe_afzode'] = floatval($_POST['mablaghe_ghabele_pardakht'] * (floatval($_POST['darsade_avareze_arzeshe_afzode'] / 100)));
                                                    $_POST['maliate_arzeshe_afzode'] = floatval($_POST['mablaghe_ghabele_pardakht'] * (floatval($_POST['maliate_arzeshe_afzode'] / 100)));
                                                    $_POST['mablaghe_ghabele_pardakht'] = $_POST['mablaghe_ghabele_pardakht'] + $_POST['darsade_avareze_arzeshe_afzode'] + $_POST['maliate_arzeshe_afzode'];
                                                    $_POST['gheymate_service'] = floatval($res_services[0]['gheymat']);
                                                    break;
                                                default:
                                                    die(Helper::Json_Message('sinf'));
                                                    break;
                                            }
                                            //////////////////////////SET IBSNG Attrs//////////////////
                                            $sql = Helper::Insert_Generator($_POST, 'bnm_factor');
                                            $result = Db::secure_insert_array($sql, $_POST);
                                            if ($result) {
                                                $id = (int) $result;
                                                $arr = array();
                                                $arr['shomare_factor'] = $id + 1000;
                                                $arr['id'] = $id;
                                                $sql3 = Helper::Update_Generator($arr, 'bnm_factor', "WHERE id = :id");
                                                $res3 = Db::secure_update_array($sql3, $arr);
                                                /////////////////////////send sms///////////////////////////
                                                $res_factor = Helper::Select_By_Id('bnm_factor', $id);
                                                $res_sub = Helper::Select_By_Id('bnm_subscribers', $res_factor[0]['subscriber_id']);
                                                $msg = 'شناسه فاکتور: ' . $result;
                                                if ($res_sub) {
                                                    if ($res_sub[0]['branch_id'] === 0) {
                                                        ////user sahar
                                                        $res_internal = Helper::Internal_Message_By_Karbord($internal_message_karbord . 's', '1');
                                                        if ($res_internal) {
                                                            $sql = Helper::Insert_Generator(
                                                                array(
                                                                    'message' => $res_internal[0]['message'],
                                                                    'type' => 2,
                                                                    'message_subject' => $res_internal[0]['karbord'],
                                                                ),
                                                                'bnm_messages'
                                                            );
                                                            $res_message = Db::secure_insert_array($sql, array(
                                                                'message' => $res_internal[0]['message'],
                                                                'type' => 2,
                                                                'message_subject' => $res_internal[0]['karbord'],
                                                            ));
                                                            $res_sms_request = Helper::Write_In_Sms_Request(
                                                                $res_sub[0]['telephone_hamrah'],
                                                                Helper::Today_Miladi_Date(),
                                                                Helper::Today_Miladi_Date(),
                                                                1,
                                                                $res_message
                                                            );
                                                            if ($res_sms_request) {
                                                                $arr = array();
                                                                $arr['receiver'] = $res_sub[0]['telephone_hamrah'];
                                                                $arr['sender'] = __SMSNUMBER__;
                                                                $arr['request_id'] = $res_sms_request;
                                                                $res = Helper::Write_In_Sms_Queue($arr);
                                                            }
                                                            die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . $msg, 1));
                                                        }
                                                    } elseif (Helper::Is_Empty_OR_Null($res_sub[0]['branch_id'])) {
                                                        //user namayande
                                                        $res_internal = Helper::Internal_Message_By_Karbord($internal_message_karbord . 'n', '1');
                                                        if ($res_internal) {
                                                            $sql = Helper::Insert_Generator(
                                                                array(
                                                                    'message' => $res_internal[0]['message'],
                                                                    'type' => 2,
                                                                    'message_subject' => $res_internal[0]['karbord'],
                                                                ),
                                                                'bnm_messages'
                                                            );
                                                            $res_message = Db::secure_insert_array($sql, array(
                                                                'message' => $res_internal[0]['message'],
                                                                'type' => 2,
                                                                'message_subject' => $res_internal[0]['karbord'],
                                                            ));
                                                            $res_sms_request = Helper::Write_In_Sms_Request(
                                                                $res_sub[0]['telephone_hamrah'],
                                                                Helper::Today_Miladi_Date(),
                                                                Helper::Today_Miladi_Date(),
                                                                1,
                                                                $res_message
                                                            );
                                                            if ($res_sms_request) {
                                                                $arr = array();
                                                                $arr['receiver'] = $res_sub[0]['telephone_hamrah'];
                                                                $arr['sender'] = __SMSNUMBER__;
                                                                $arr['request_id'] = $res_sms_request;
                                                                $res = Helper::Write_In_Sms_Queue($arr);
                                                            }
                                                            die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . $msg, 1));
                                                        }
                                                    }
                                                }
                                                /////////////////////////sms///////////////////////////
                                            } else {
                                                ////age be har dalili natonestim factor sabt konim
                                                die(Helper::Json_Message('f'));
                                            }
                                        } else {
                                            ////age etelaate karbar naghes bod
                                            die(Helper::Json_Message('sinr'));
                                        }
                                    } else {
                                        die(Helper::Json_Message('factor_not_found'));
                                    }
                                } else {
                                    die(Helper::Json_Message('subscriber_info_not_found'));
                                }
                            } else {
                                die(Helper::Json_Message('service_info_not_found'));
                            }
                            break;
                        case __MOSHTARAKUSERTYPE__:
                            $sql_tax = "SELECT * FROM bnm_tax ORDER BY id DESC LIMIT 1";
                            $res_tax = Db::fetchall_Query($sql_tax);
                            if (!$res_tax) {
                                die(Helper::Json_Message('tinf'));
                            }
                            $sql_services = "SELECT * FROM bnm_services WHERE id = ? AND namayeshe_service='yes' AND tarikhe_shoroe_namayesh<=CURDATE() AND tarikhe_payane_namayesh >= CURDATE()";
                            $res_services = Db::secure_fetchall($sql_services, array($_POST['service_id']), true);
                            $sql_subscriber = "SELECT * FROM bnm_subscribers WHERE id = ?";
                            $res_subscriber = Db::secure_fetchall($sql_subscriber, array($_SESSION['user_id']), true);
                            ///check ke factor avale user hast ya na
                            $factor_sql = "SELECT count(*) as rows_num FROM bnm_factor WHERE subscriber_id=? AND tasvie_shode='1' AND type = ?";
                            $res_user_factors = Db::secure_fetchall($factor_sql, array($res_subscriber[0]['id'], $res_services[0]['type']), true);
                            if ($res_services) {
                                if ($res_subscriber) {
                                    if ($res_user_factors) {
                                        if (Helper::Is_Empty_OR_Null($res_services[0]['zaname_estefade_be_tarikh']) && Helper::Is_Empty_OR_Null($res_services[0]['onvane_service']) && Helper::Is_Empty_OR_Null($res_subscriber[0]['code_eshterak'])) {
                                            $_POST['zaname_estefade_be_tarikh'] = $res_services[0]['zaname_estefade_be_tarikh'];
                                            $_POST['onvane_service'] = $res_services[0]['onvane_service'];
                                            $_POST['type'] = $res_services[0]['type'];
                                            $_POST['zaname_estefade'] = $res_services[0]['zaname_estefade'];
                                            $_POST['abonmane_port'] = floatval($res_services[0]['port']);
                                            $_POST['abonmane_faza'] = floatval($res_services[0]['faza']);
                                            $_POST['abonmane_tajhizat'] = floatval($res_services[0]['tajhizat']);
                                            $_POST['hazine_ranzhe'] = floatval($res_services[0]['hazine_ranzhe']);
                                            $_POST['hazine_dranzhe'] = floatval($res_services[0]['hazine_dranzhe']);
                                            $_POST['hazine_nasb'] = floatval($res_services[0]['hazine_nasb']);
                                            $_POST['code_eshterak'] = $res_subscriber[0]['code_eshterak'];
                                            $_POST['subscriber_id'] = $res_subscriber[0]['id'];
                                            $_POST['branch_id'] = $res_subscriber[0]['branch_id'];
                                            $_POST['darsade_avareze_arzeshe_afzode'] = floatval($res_tax[0]['darsade_avarez_arzeshe_afzode']);
                                            $_POST['maliate_arzeshe_afzode'] = floatval($res_tax[0]['darsade_maliate_arzeshe_afzode']);
                                            $_POST['sazande_factor_id'] = $_SESSION['id'];
                                            $_POST['sazande_factor_username'] = $_SESSION['username'];
                                            $_POST['sazande_factor_user_type'] = $_SESSION['user_type'];
                                            $_POST['tarikhe_akharin_virayesh'] = Helper::Today_Miladi_Date('/');
                                            $_POST['tarikhe_payane_service'] = Helper::Add_Or_Minus_Day_To_Date($res_services[0]['zaname_estefade']);
                                            $_POST['tarikhe_shoroe_service'] = Helper::Today_Miladi_Date();
                                            $_POST['mablaghe_ghabele_pardakht'] = 0;
                                            $_POST['gheymate_service'] = floatval($res_services[0]['gheymat']);
                                            $_POST['noe_khadamat'] = $res_services[0]['noe_khadamat'];
                                            $_POST['takhfif'] = floatval($res_services[0]['takhfif']);
                                            $_POST['hazine_kharabi'] = $res_services[0]['hazine_kharabi'];

                                            switch ($res_services[0]['type']) {
                                                case 'adsl':
                                                    $internal_message_karbord = 'sfadm';
                                                    if ($res_user_factors[0]['rows_num'] === 0) {
                                                        //factore aval hazine ranzhe & dranzhe & hazine_nasb hesab shavad
                                                        $_POST['hazine_ranzhe'] = floatval($res_services[0]['hazine_ranzhe']);
                                                        $_POST['hazine_dranzhe'] = floatval($res_services[0]['hazine_dranzhe']);
                                                        $_POST['hazine_nasb'] = floatval($res_services[0]['hazine_nasb']);
                                                    } else {
                                                        //factore chandom
                                                        $_POST['hazine_ranzhe'] = 0;
                                                        $_POST['hazine_dranzhe'] = 0;
                                                        $_POST['hazine_nasb'] = 0;
                                                    }
                                                    if ($_POST['takhfif'] !== 0 && Helper::Is_Empty_OR_Null($_POST['takhfif'])) {
                                                        $_POST['takhfif'] = floatval($_POST['takhfif']);
                                                        $_POST['takhfif'] = ($_POST['takhfif'] * $_POST['gheymate_service']) / 100;
                                                        $gheymat = $_POST['gheymate_service'] - $_POST['takhfif'];
                                                    } else {
                                                        $gheymat = $_POST['gheymate_service'];
                                                    }
                                                    $_POST['mablaghe_ghabele_pardakht'] = $gheymat + floatval($res_services[0]['hazine_ranzhe'])
                                                     + floatval($res_services[0]['hazine_nasb']) + floatval($res_services[0]['hazine_dranzhe'])
                                                     + floatval($res_services[0]['port']) + floatval($res_services[0]['faza'])
                                                     + floatval($res_services[0]['tajhizat']);
                                                    $_POST['darsade_avareze_arzeshe_afzode'] = floatval($_POST['mablaghe_ghabele_pardakht'] * (floatval($_POST['darsade_avareze_arzeshe_afzode'] / 100)));
                                                    $_POST['maliate_arzeshe_afzode'] = floatval($_POST['mablaghe_ghabele_pardakht'] * (floatval($_POST['maliate_arzeshe_afzode'] / 100)));
                                                    $_POST['mablaghe_ghabele_pardakht'] = $_POST['mablaghe_ghabele_pardakht'] + $_POST['darsade_avareze_arzeshe_afzode'] + $_POST['maliate_arzeshe_afzode'];
                                                    $_POST['gheymate_service'] = floatval($res_services[0]['gheymat']);

                                                    $_POST['emkanat_id'] = $_POST['port_id'];
                                                    unset($_POST['port_id']);
                                                    break;
                                                case 'vdsl':
                                                    $internal_message_karbord = 'sfvdm';
                                                    //$_POST['ibs_username']    = $res_subscriber[0]['code_meli'];
                                                    if ($res_user_factors[0]['rows_num'] === 0) {
                                                        //factore aval hazine ranzhe & dranzhe & hazine_nasb hesab shavad
                                                        $_POST['hazine_ranzhe'] = floatval($res_services[0]['hazine_ranzhe']);
                                                        $_POST['hazine_dranzhe'] = floatval($res_services[0]['hazine_dranzhe']);
                                                        $_POST['hazine_nasb'] = floatval($res_services[0]['hazine_nasb']);
                                                    } else {
                                                        //factore chandom
                                                        $_POST['hazine_ranzhe'] = 0;
                                                        $_POST['hazine_dranzhe'] = 0;
                                                        $_POST['hazine_nasb'] = 0;
                                                    }
                                                    if ($_POST['takhfif'] !== 0 && Helper::Is_Empty_OR_Null($_POST['takhfif'])) {
                                                        $_POST['takhfif'] = floatval($_POST['takhfif']);
                                                        $_POST['takhfif'] = ($_POST['takhfif'] * $_POST['gheymate_service']) / 100;
                                                        $gheymat = $_POST['gheymate_service'] - $_POST['takhfif'];
                                                    } else {
                                                        $gheymat = $_POST['gheymate_service'];
                                                    }
                                                    $_POST['mablaghe_ghabele_pardakht'] = $gheymat + floatval($res_services[0]['hazine_ranzhe'])
                                                     + floatval($res_services[0]['hazine_nasb']) + floatval($res_services[0]['hazine_dranzhe'])
                                                     + floatval($res_services[0]['port']) + floatval($res_services[0]['faza'])
                                                     + floatval($res_services[0]['tajhizat']);
                                                    $_POST['darsade_avareze_arzeshe_afzode'] = floatval($_POST['mablaghe_ghabele_pardakht'] * (floatval($_POST['darsade_avareze_arzeshe_afzode'] / 100)));
                                                    $_POST['maliate_arzeshe_afzode'] = floatval($_POST['mablaghe_ghabele_pardakht'] * (floatval($_POST['maliate_arzeshe_afzode'] / 100)));
                                                    $_POST['mablaghe_ghabele_pardakht'] = $_POST['mablaghe_ghabele_pardakht'] + $_POST['darsade_avareze_arzeshe_afzode'] + $_POST['maliate_arzeshe_afzode'];
                                                    $_POST['gheymate_service'] = floatval($res_services[0]['gheymat']);

                                                    $_POST['emkanat_id'] = $_POST['port_id'];
                                                    unset($_POST['port_id']);
                                                    ///1-check user has factor or not

                                                    break;
                                                case 'wireless':
                                                    $_POST['emkanat_id'] = $_POST['istgah_name'];
                                                    unset($_POST['istgah_name']);
                                                    // $_POST['ibs_username']      = $res_subscriber[0]['code_meli'];
                                                    $internal_message_karbord = 'sfwim';
                                                    $_POST['hazine_ranzhe'] = 0;
                                                    $_POST['hazine_dranzhe'] = 0;
                                                    if ($res_user_factors[0]['rows_num'] === 0) {
                                                        $_POST['hazine_nasb'] = floatval($res_services[0]['hazine_nasb']);
                                                    } else {
                                                        $_POST['hazine_nasb'] = 0;
                                                    }
                                                    $_POST['takhfif'] = floatval($_POST['takhfif']);
                                                    $_POST['takhfif'] = ($_POST['takhfif'] * $_POST['gheymate_service']) / 100;
                                                    if ($_POST['takhfif'] !== 0 && Helper::Is_Empty_OR_Null($_POST['takhfif'])) {
                                                        $gheymat = $_POST['gheymate_service'] - $_POST['takhfif'];
                                                    } else {
                                                        $gheymat = $_POST['gheymate_service'];
                                                    }
                                                    $_POST['mablaghe_ghabele_pardakht'] = $gheymat
                                                     + floatval($res_services[0]['hazine_nasb']) + floatval($res_services[0]['faza'])
                                                     + floatval($res_services[0]['port']) + floatval($res_services[0]['tajhizat']);
                                                    $_POST['darsade_avareze_arzeshe_afzode'] = floatval($_POST['mablaghe_ghabele_pardakht'] * (floatval($_POST['darsade_avareze_arzeshe_afzode'] / 100)));
                                                    $_POST['maliate_arzeshe_afzode'] = floatval($_POST['mablaghe_ghabele_pardakht'] * (floatval($_POST['maliate_arzeshe_afzode'] / 100)));
                                                    $_POST['mablaghe_ghabele_pardakht'] = $_POST['mablaghe_ghabele_pardakht'] + $_POST['darsade_avareze_arzeshe_afzode'] + $_POST['maliate_arzeshe_afzode'];
                                                    $_POST['gheymate_service'] = floatval($res_services[0]['gheymat']);
                                                    break;
                                                case 'tdlte':
                                                    unset($_POST['ibs_username']);
                                                    $internal_message_karbord = 'sftdm';
                                                    unset($_POST['istgah_name']);
                                                    $_POST['hazine_ranzhe'] = 0;
                                                    $_POST['hazine_dranzhe'] = 0;
                                                    if ($res_user_factors[0]['rows_num'] === 0) {
                                                        $_POST['hazine_nasb'] = floatval($res_services[0]['hazine_nasb']);
                                                    } else {
                                                        $_POST['hazine_nasb'] = 0;
                                                    }
                                                    $_POST['takhfif'] = floatval($_POST['takhfif']);
                                                    $_POST['takhfif'] = ($_POST['takhfif'] * $_POST['gheymate_service']) / 100;
                                                    if ($_POST['takhfif'] !== 0 && Helper::Is_Empty_OR_Null($_POST['takhfif'])) {
                                                        $gheymat = $_POST['gheymate_service'] - $_POST['takhfif'];
                                                    } else {
                                                        $gheymat = $_POST['gheymate_service'];
                                                    }
                                                    $_POST['mablaghe_ghabele_pardakht'] = $gheymat
                                                     + floatval($res_services[0]['hazine_nasb']) + floatval($res_services[0]['faza'])
                                                     + floatval($res_services[0]['port']) + floatval($res_services[0]['tajhizat']);
                                                    $_POST['darsade_avareze_arzeshe_afzode'] = floatval($_POST['mablaghe_ghabele_pardakht'] * (floatval($_POST['darsade_avareze_arzeshe_afzode'] / 100)));
                                                    $_POST['maliate_arzeshe_afzode'] = floatval($_POST['mablaghe_ghabele_pardakht'] * (floatval($_POST['maliate_arzeshe_afzode'] / 100)));
                                                    $_POST['mablaghe_ghabele_pardakht'] = $_POST['mablaghe_ghabele_pardakht'] + $_POST['darsade_avareze_arzeshe_afzode'] + $_POST['maliate_arzeshe_afzode'];
                                                    $_POST['gheymate_service'] = floatval($res_services[0]['gheymat']);
                                                    break;
                                                case 'voip':
                                                    $_POST['emkanat_id'] = $_POST['ibs_username'];
                                                    unset($_POST['ibs_username']);
                                                    $internal_message_karbord = 'sfvom';
                                                    $_POST['hazine_ranzhe'] = 0;
                                                    $_POST['hazine_dranzhe'] = 0;
                                                    $_POST['hazine_nasb'] = 0;
                                                    $_POST['takhfif'] = floatval($_POST['takhfif']);
                                                    $_POST['takhfif'] = ($_POST['takhfif'] * $_POST['gheymate_service']) / 100;
                                                    if ($_POST['takhfif'] !== 0 && Helper::Is_Empty_OR_Null($_POST['takhfif'])) {
                                                        $gheymat = $_POST['gheymate_service'] - $_POST['takhfif'];
                                                    } else {
                                                        $gheymat = $_POST['gheymate_service'];
                                                    }
                                                    // $_POST['mablaghe_ghabele_pardakht'] = $gheymat + floatval($res_services[0]['hazine_ranzhe'])
                                                    //  + floatval($res_services[0]['hazine_nasb']) + floatval($res_services[0]['hazine_dranzhe'])
                                                    //  + floatval($res_services[0]['port']) + floatval($res_services[0]['faza'])
                                                    //  + floatval($res_services[0]['tajhizat']);
                                                    $_POST['mablaghe_ghabele_pardakht'] = $gheymat;
                                                    $_POST['darsade_avareze_arzeshe_afzode'] = floatval($_POST['mablaghe_ghabele_pardakht'] * (floatval($_POST['darsade_avareze_arzeshe_afzode'] / 100)));
                                                    $_POST['maliate_arzeshe_afzode'] = floatval($_POST['mablaghe_ghabele_pardakht'] * (floatval($_POST['maliate_arzeshe_afzode'] / 100)));
                                                    $_POST['mablaghe_ghabele_pardakht'] = $_POST['mablaghe_ghabele_pardakht'] + $_POST['darsade_avareze_arzeshe_afzode'] + $_POST['maliate_arzeshe_afzode'];
                                                    $_POST['gheymate_service'] = floatval($res_services[0]['gheymat']);
                                                    break;
                                                default:
                                                    die(Helper::Json_Message('sinf'));
                                                    break;
                                            }
                                            unset($_POST['ibs_username']);
                                            // die(json_encode($_POST));
                                            $sql = "SELECT f.id,f.emkanat_id,s.id,s.type,s.noe_forosh FROM bnm_factor f
                                                    INNER JOIN bnm_services s ON f.service_id = s.id
                                                    WHERE f.emkanat_id = ? AND s.type = ? AND f.subscriber_id = ? AND f.tasvie_shode = ?";
                                            $res = Db::secure_fetchall($sql, array(
                                                $_POST['emkanat_id'],
                                                $res_services[0]['type'],
                                                $res_subscriber[0]['id'],
                                                1,
                                            ));

                                            if ($res_services[0]['type'] !== 'voip') {
                                                if (!$res) {
                                                    //moshtarak jadid ast
                                                    if ($res_services[0]['noe_forosh'] === 'adi' || $res_services[0]['noe_forosh'] === 'jashnvare') {
                                                        $sql = Helper::Insert_Generator($_POST, 'bnm_factor');
                                                        $result = Db::secure_insert_array($sql, $_POST);
                                                    } elseif ($res[0]['noe_forosh'] === 'bulk') {
                                                        die(Helper::Custom_Msg(Helper::Messages('ffcbb'), 3));
                                                    } else {
                                                        die(Helper::Json_Message('f'));
                                                    }
                                                } else {
                                                    //check tarikhe akharin factor adi ya jashnvare
                                                    $sql = "
                                                        SELECT f.id FROM bnm_factor f
                                                        INNER JOIN bnm_services s ON s.id = f.service_id
                                                        WHERE f.emkanat_id = ? AND f.subscriber_id = ? AND s.type = ? AND s.noe_forosh IN ('adi','jashnvare') AND DATE(f.tarikhe_payane_service) > CURDATE()
                                                        ";
                                                    $res2 = Db::secure_fetchall($sql, array(
                                                        $_POST['emkanat_id'],
                                                        $res_subscriber[0]['id'],
                                                        $res_services[0]['type'],
                                                    ));
                                                    if ($res2) {
                                                        //faghat bulk
                                                        if ($res_services[0]['noe_forosh'] === "bulk") {
                                                            $sql = Helper::Insert_Generator($_POST, 'bnm_factor');
                                                            $result = Db::secure_insert_array($sql, $_POST);
                                                        } else {
                                                            die(Helper::Custom_Msg(Helper::Messages('bbso'), 3));
                                                        }
                                                    } else {
                                                        //faghat adi
                                                        if ($res_services[0]['noe_forosh'] === "adi") {
                                                            $sql = Helper::Insert_Generator($_POST, 'bnm_factor');
                                                            $result = Db::secure_insert_array($sql, $_POST);
                                                        } else {
                                                            die(Helper::Custom_Msg(Helper::Messages('baso'), 3));
                                                        }
                                                    }
                                                }
                                            } else {
                                                if (!$res) {
                                                    //moshtarak jadid ast
                                                    if ($res_services[0]['noe_forosh'] === 'adi' || $res_services[0]['noe_forosh'] === 'jashnvare') {
                                                        $_POST['etebare_baghimande'] = 0;
                                                        $_POST['etebare_ghabele_enteghal'] = 0;
                                                        $sql = Helper::Insert_Generator($_POST, 'bnm_factor');
                                                        $result = Db::secure_insert_array($sql, $_POST);
                                                    } elseif ($res_services[0]['noe_forosh'] === 'bulk') {
                                                        die(Helper::Custom_Msg(Helper::Messages('ffcbb'), 3));
                                                    } else {
                                                        die(Helper::Json_Message('f'));
                                                    }
                                                } else {
                                                    //ghablan ro in shomare service kharide
                                                    $sql = "SELECT
                                                            id,
                                                            IF({$_POST['emkanat_id']} = 1, telephone1,
                                                            IF({$_POST['emkanat_id']} = 2, telephone2,
                                                            IF({$_POST['emkanat_id']} = 3, telephone3, null))) telephone
                                                            FROM bnm_subscribers
                                                            WHERE id = ?
                                                        ";
                                                    $res_telephone = Db::secure_fetchall($sql, array($res_subscriber[0]['id']));
                                                    if ($res_telephone) {
                                                        if (Helper::Is_Empty_OR_Null($res_telephone)) {
                                                            $res = $GLOBALS['ibs_voip']->getUserInfoByViopUserName($res_telephone[0]['telephone']);
                                                            if (Helper::ibsCheckResponse($res)) {
                                                                //dar ibs vojod darad
                                                                $unixtime = strtotime($res[1][key($res[1])]['attrs']['abs_exp_date']);
                                                                $exp_date = date("Y-m-d", $unixtime);
                                                                $today_date = Helper::Today_Miladi_Date();
                                                                if ($exp_date <= $today_date) {
                                                                    //expire shode pas 1/3 credit ro behesh midim
                                                                    $_POST['etebare_baghimande'] = intval($res[1][key($res[1])]['basic_info']['credit']);
                                                                    $_POST['etebare_ghabele_enteghal'] = intval($_POST['etebare_baghimande'] / 3);
                                                                    $sql = Helper::Insert_Generator($_POST, 'bnm_factor');
                                                                    $result = Db::secure_insert_array($sql, $_POST);
                                                                } else {
                                                                    //expire nashode pas kole credit ro behesh midim
                                                                    $_POST['etebare_baghimande'] = intval($res[1][key($res[1])]['basic_info']['credit']);
                                                                    $_POST['etebare_ghabele_enteghal'] = intval($res[1][key($res[1])]['basic_info']['credit']);
                                                                    $sql = Helper::Insert_Generator($_POST, 'bnm_factor');
                                                                    $result = Db::secure_insert_array($sql, $_POST);
                                                                }
                                                            } else {
                                                                //moshtarak factor darad vali dar ibs nist !!!!!
                                                                $_POST['etebare_baghimande'] = 0;
                                                                $_POST['etebare_ghabele_enteghal'] = 0;
                                                            }
                                                        } else {
                                                            die(Helper::Json_Message('f'));
                                                        }
                                                    } else {
                                                        die(Helper::Json_Message('f'));
                                                    }
                                                }
                                            }
                                            if ($result) {
                                                $id = (int) $result;
                                                $arr = array();
                                                $arr['shomare_factor'] = $id + 1000;
                                                $arr['id'] = $id;
                                                $sql3 = Helper::Update_Generator($arr, 'bnm_factor', "WHERE id = :id");
                                                $res3 = Db::secure_update_array($sql3, $arr);
                                                /////////////////////////send sms///////////////////////////
                                                $res_factor = Helper::Select_By_Id('bnm_factor', $id);
                                                $res_sub = Helper::Select_By_Id('bnm_subscribers', $res_factor[0]['subscriber_id']);
                                                $msg = 'شناسه فاکتور: ' . $result;
                                                if ($res_sub) {
                                                    if ($res_sub[0]['branch_id'] === 0) {
                                                        ////user sahar
                                                        $res_internal = Helper::Internal_Message_By_Karbord($internal_message_karbord . 's', '1');
                                                        if ($res_internal) {
                                                            $sql = Helper::Insert_Generator(
                                                                array(
                                                                    'message' => $res_internal[0]['message'],
                                                                    'type' => 2,
                                                                    'message_subject' => $res_internal[0]['karbord'],
                                                                ),
                                                                'bnm_messages'
                                                            );
                                                            $res_message = Db::secure_insert_array($sql, array(
                                                                'message' => $res_internal[0]['message'],
                                                                'type' => 2,
                                                                'message_subject' => $res_internal[0]['karbord'],
                                                            ));
                                                            $res_sms_request = Helper::Write_In_Sms_Request(
                                                                $res_sub[0]['telephone_hamrah'],
                                                                Helper::Today_Miladi_Date(),
                                                                Helper::Today_Miladi_Date(),
                                                                1,
                                                                $res_message
                                                            );
                                                            if ($res_sms_request) {
                                                                $arr = array();
                                                                $arr['receiver'] = $res_sub[0]['telephone_hamrah'];
                                                                $arr['sender'] = __SMSNUMBER__;
                                                                $arr['request_id'] = $res_sms_request;
                                                                $res = Helper::Write_In_Sms_Queue($arr);
                                                            }
                                                            die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . $msg, 1));
                                                        } else {
                                                            die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns')));
                                                        }
                                                    } elseif (Helper::Is_Empty_OR_Null($res_sub[0]['branch_id'])) {
                                                        //user namayande
                                                        $res_internal = Helper::Internal_Message_By_Karbord($internal_message_karbord . 'n', '1');
                                                        if ($res_internal) {
                                                            $sql = Helper::Insert_Generator(
                                                                array(
                                                                    'message' => $res_internal[0]['message'],
                                                                    'type' => 2,
                                                                    'message_subject' => $res_internal[0]['karbord'],
                                                                ),
                                                                'bnm_messages'
                                                            );
                                                            $res_message = Db::secure_insert_array($sql, array(
                                                                'message' => $res_internal[0]['message'],
                                                                'type' => 2,
                                                                'message_subject' => $res_internal[0]['karbord'],
                                                            ));
                                                            $res_sms_request = Helper::Write_In_Sms_Request(
                                                                $res_sub[0]['telephone_hamrah'],
                                                                Helper::Today_Miladi_Date(),
                                                                Helper::Today_Miladi_Date(),
                                                                1,
                                                                $res_message
                                                            );
                                                            if ($res_sms_request) {
                                                                $arr = array();
                                                                $arr['receiver'] = $res_sub[0]['telephone_hamrah'];
                                                                $arr['sender'] = __SMSNUMBER__;
                                                                $arr['request_id'] = $res_sms_request;
                                                                $res = Helper::Write_In_Sms_Queue($arr);
                                                            }

                                                            die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . $msg, 1));
                                                        } else {
                                                            die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns')));
                                                        }
                                                    }
                                                } else {
                                                    die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . $msg, 1));
                                                }
                                                die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . $msg, 1));
                                            } else {
                                                ////age be har dalili natonestim factor sabt konim
                                                die(Helper::Json_Message('f'));
                                            }
                                        } else {
                                            ////age etelaate karbar naghes bod
                                            die(Helper::Json_Message('sinr'));
                                        }
                                    } else {
                                        die(Helper::Json_Message('factor_not_found'));
                                    }
                                } else {
                                    die(Helper::Json_Message('subscriber_info_not_found'));
                                }
                            } else {
                                die(Helper::Json_Message('service_info_not_found'));
                            }
                            break;
                        default:
                            die(Helper::Json_Message('af'));
                            break;
                    }
                } else {
                    die(Helper::Json_Message('af'));
                }
            } catch (Throwable $e) {
                Helper::Exc_Error_Debug($e, true);
                die();
            }
        }

        if (isset($_POST['send_ft_pardakht'])) {
            $_POST = Helper::Create_Post_Array_Without_Key($_POST);
            $_POST = Helper::xss_check_array($_POST);
            if (Helper::Login_Just_Check()) {
                /////////////fetch data operations
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                        if (Helper::Is_Empty_OR_Null($_POST['factor_id'])) {
                            $sql_factor = "SELECT
                                fa.id,fa.emkanat_id,fa.subscriber_id,fa.service_id,
                                fa.mablaghe_ghabele_pardakht,fa.maliate_arzeshe_afzode,fa.darsade_avareze_arzeshe_afzode,
                                fa.status,fa.tasvie_shode,fa.hazine_nasb,fa.hazine_dranzhe,fa.hazine_ranzhe,fa.hazine_kharabi,
                                fa.takhfif,fa.etebare_baghimande,fa.etebare_ghabele_enteghal,fa.zaname_estefade,fa.zaname_estefade_be_tarikh,fa.gheymate_service,
                                fa.tarikhe_payane_service,fa.tarikhe_shoroe_service,fa.zamane_estefade,fa.tarikhe_factor,fa.abonmane_port,fa.abonmane_faza,fa.abonmane_tajhizat,ser.type,
                                ser.noe_forosh,ser.noe_khadamat,ser.terafik,sub.branch_id,sub.code_meli ,sub.noe_moshtarak,ct.name city_name,os.name ostan_name
                            FROM bnm_factor fa
                                INNER JOIN bnm_services ser ON ser.id = fa.service_id
                                INNER JOIN bnm_subscribers sub ON sub.id = fa.subscriber_id
                                INNER JOIN bnm_shahr ct ON sub.shahre_tavalod = ct.id
                                INNER JOIN bnm_ostan os ON ct.ostan_id = os.id
                            WHERE fa.id = ? AND DATE( fa.tarikhe_factor )= CURDATE() AND fa.tasvie_shode <> '1' ";
                            $res_factor = Db::secure_fetchall($sql_factor, array($_POST['factor_id']));
                        } else {
                            die(Helper::Json_Message('required_info_not_found'));
                        }
                        break;
                    case __MODIR2USERTYPE__:
                    case __MODIRUSERTYPE__:
                    case __OPERATOR2USERTYPE__:
                    case __OPERATORUSERTYPE__:
                        if (Helper::Is_Empty_OR_Null($_POST['factor_id'])) {
                            $sql_factor = "SELECT
                                fa.id,fa.emkanat_id,fa.subscriber_id,fa.service_id,
                                fa.mablaghe_ghabele_pardakht,fa.maliate_arzeshe_afzode,fa.darsade_avareze_arzeshe_afzode,
                                fa.status,fa.tasvie_shode,fa.hazine_nasb,fa.hazine_dranzhe,fa.hazine_ranzhe,fa.hazine_kharabi,
                                fa.takhfif,fa.etebare_baghimande,fa.etebare_ghabele_enteghal,fa.zaname_estefade,fa.zaname_estefade_be_tarikh,fa.gheymate_service,
                                fa.tarikhe_payane_service,fa.tarikhe_shoroe_service,fa.zamane_estefade,fa.tarikhe_factor,fa.abonmane_port,fa.abonmane_faza,fa.abonmane_tajhizat,ser.type,
                                ser.noe_forosh,ser.noe_khadamat,ser.terafik,sub.branch_id,sub.code_meli ,sub.noe_moshtarak,ct.name city_name,os.name ostan_name
                            FROM bnm_factor fa
                                INNER JOIN bnm_services ser ON ser.id = fa.service_id
                                INNER JOIN bnm_subscribers sub ON sub.id = fa.subscriber_id
                                INNER JOIN bnm_shahr ct ON sub.shahre_tavalod = ct.id
                                INNER JOIN bnm_ostan os ON ct.ostan_id = os.id
                            WHERE fa.id = ? AND DATE( fa.tarikhe_factor )= CURDATE() AND fa.tasvie_shode <> '1' AND sub.branch_id = ?";
                            $res_factor = Db::secure_fetchall($sql_factor, array($_POST['factor_id'], $_SESSION['branch_id']));
                        } else {
                            die(Helper::Json_Message('required_info_not_found'));
                        }
                        break;
                    case __MOSHTARAKUSERTYPE__:
                        $sql_factor = "SELECT
                            fa.id,fa.emkanat_id,fa.subscriber_id,fa.service_id,
                            fa.mablaghe_ghabele_pardakht,fa.maliate_arzeshe_afzode,fa.darsade_avareze_arzeshe_afzode,
                            fa.status,fa.tasvie_shode,fa.hazine_nasb,fa.hazine_dranzhe,fa.hazine_ranzhe,fa.hazine_kharabi,
                            fa.takhfif,fa.etebare_baghimande,fa.etebare_ghabele_enteghal,fa.zaname_estefade,fa.zaname_estefade_be_tarikh,fa.gheymate_service,
                            fa.tarikhe_payane_service,fa.tarikhe_shoroe_service,fa.zamane_estefade,fa.tarikhe_factor,fa.abonmane_port,fa.abonmane_faza,fa.abonmane_tajhizat,ser.type,
                            ser.noe_forosh,ser.noe_khadamat,ser.terafik,sub.branch_id,sub.code_meli ,sub.noe_moshtarak,ct.name city_name,os.name ostan_name
                        FROM bnm_factor fa
                            INNER JOIN bnm_services ser ON ser.id = fa.service_id
                            INNER JOIN bnm_subscribers sub ON sub.id = fa.subscriber_id
                            INNER JOIN bnm_shahr ct ON sub.shahre_tavalod = ct.id
                            INNER JOIN bnm_ostan os ON ct.ostan_id = os.id
                        WHERE fa.id = ? AND DATE( fa.tarikhe_factor )= CURDATE() AND fa.tasvie_shode <> '1' AND sub.branch_id = ? AND sub.id = ?";
                        $res_factor = Db::secure_fetchall($sql_factor, array($_POST['factor_id'], $_SESSION['branch_id'], $_SESSION['user_id']));
                        break;
                    default:
                        die(Helper::Json_Message('auth_fail'));
                        break;
                }
                //////////////check queries
                if ($res_factor) {
                    $sql_service = "SELECT * FROM bnm_services WHERE id = ?";
                    $res_service = Db::secure_fetchall($sql_service, array($res_factor[0]['service_id']));
                    $sql_subscriber = "SELECT * FROM bnm_subscribers WHERE id =?";
                    $res_subscriber = Db::secure_fetchall($sql_subscriber, array($res_factor[0]['subscriber_id']));
                    if ($res_subscriber) {
                        if ($res_subscriber[0]['branch_id'] !== 0) {
                            $sql_noe_hamkari = "SELECT * FROM bnm_branch_cooperation_type WHERE branch_id=? AND service_type=? ORDER BY id DESC LIMIT 1";
                            $res_noe_hamkari = Db::secure_fetchall($sql_noe_hamkari, array($res_subscriber[0]['branch_id'], $res_service[0]['noe_khadamat']));
                            $sql_branch = "SELECT * FROM bnm_branch WHERE id =?";
                            $res_branch = Db::secure_fetchall($sql_branch, array($res_subscriber[0]['branch_id'], 2));
                        }
                    } else {
                        die(Helper::Json_Message('subscriber_not_found'));
                    }
                } else {
                    die(Helper::Json_Message('factor_not_found'));
                }
                $sql = "SELECT
                    COUNT(*) AS rows_num
                    FROM
                        bnm_factor f
                        INNER JOIN bnm_services s ON f.service_id = s.id
                    WHERE
                        f.emkanat_id = ?
                        AND s.type = ?
                        AND f.subscriber_id = ?
                        AND f.tasvie_shode = ?";
                $res_factor_noe_kharid = Db::secure_fetchall($sql, array(
                    $res_factor[0]['emkanat_id'],
                    $res_service[0]['type'],
                    $res_subscriber[0]['id'],
                    1,
                ));
                $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id'], 2));
                $sql_credit_subscriber = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                $res_credit_subscriber = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id'], 1));

                ///ibs initializing
                switch ($res_service[0]['type']) {
                    case 'adsl':
                    case 'vdsl':
                        //gereftane ibs_username
                        $sql = "SELECT
                                        fa.id,
                                        fa.etebare_ghabele_enteghal,
                                        fa.etebare_baghimande,
                                        fa.emkanat_id,
                                        p.telephone,
                                        ser.type,
                                        IF(p.telephone=1, sub.telephone1, IF(p.telephone=2, sub.telephone2, IF(p.telephone=3, sub.telephone3, null))) ibs_username
                                    FROM bnm_factor fa
                                        INNER JOIN bnm_subscribers sub ON sub.id = fa.subscriber_id
                                        INNER JOIN bnm_services ser ON ser.id = fa.service_id
                                        INNER JOIN bnm_port p ON fa.emkanat_id = p.id AND p.user_id = fa.subscriber_id
                                        WHERE fa.id = ? AND p.id = ?
                                    ";
                        $res_ibsusername = Db::secure_fetchall($sql, [$res_factor[0]['id'], $res_factor[0]['emkanat_id']]);
                        if ($res_ibsusername) {
                            if ($res_ibsusername[0]['ibs_username']) {
                                $sql = "SELECT fa.id, fa.tarikhe_payane_service, fa.tarikhe_shoroe_service, ser.terafik
                                FROM
                                    bnm_factor fa
                                    INNER JOIN bnm_subscribers sub ON sub.id = fa.subscriber_id
                                    INNER JOIN bnm_services ser ON ser.id = fa.service_id
                                WHERE
                                    fa.id <> ? AND fa.emkanat_id = ? AND fa.subscriber_id = ?
                                    AND ser.type = ? AND ser.noe_forosh IN (?,?)
                                    ORDER BY fa.tarikhe_factor DESC Limit 1";
                                $prefactor = Db::secure_fetchall($sql, [
                                    $res_factor[0]['id'],
                                    $res_factor[0]['emkanat_id'],
                                    $res_subscriber[0]['id'],
                                    1,
                                    $res_service[0]['type'],
                                    "adi",
                                    "jashnvare",
                                ]);
                            } else {
                                die(Helper::Json_Message('f'));
                            }
                        } else {
                            $prefactor = false;
                        }

                        break;
                    case 'bitstream':

                        break;
                    case 'wireless':

                        break;
                    case 'tdlte':
                        $sql = "SELECT
                                fa.id,
                                fa.etebare_ghabele_enteghal,
                                fa.etebare_baghimande,
                                fa.emkanat_id,
                                ser.type,
                                sim.tdlte_number as ibs_username
                            FROM bnm_factor fa
                                INNER JOIN bnm_subscribers sub ON sub.id = fa.subscriber_id
                                INNER JOIN bnm_services ser ON ser.id = fa.service_id
                                INNER JOIN bnm_tdlte_sim sim ON sim.id = fa.emkanat_id
                                WHERE fa.id = ? AND sim.subscriber_id = ?
                            ";
                        $res_ibsusername = Db::secure_fetchall($sql, [$res_factor[0]['id'], 1, $res_subscriber[0]['id']]);
                        if ($res_ibsusername) {
                            if ($res_ibsusername[0]['ibs_username']) {
                                $sql = "SELECT fa.id, fa.tarikhe_payane_service, fa.tarikhe_shoroe_service, ser.terafik
                                FROM
                                    bnm_factor fa
                                    INNER JOIN bnm_subscribers sub ON sub.id = fa.subscriber_id
                                    INNER JOIN bnm_services ser ON ser.id = fa.service_id
                                WHERE
                                    fa.id <> ? AND fa.emkanat_id = ? AND fa.subscriber_id = ?
                                    AND ser.type = ? AND ser.noe_forosh IN (?,?)
                                    ORDER BY fa.tarikhe_factor DESC Limit 1";
                                $prefactor = Db::secure_fetchall($sql, [
                                    $res_factor[0]['id'],
                                    $res_factor[0]['emkanat_id'],
                                    $res_subscriber[0]['id'],
                                    1,
                                    $res_service[0]['type'],
                                    "adi",
                                    "jashnvare",
                                ]);
                            } else {
                                die(Helper::Json_Message('f'));
                            }
                        } else {
                            $prefactor = false;
                        }
                        break;
                    case 'voip':
                        $sql = "SELECT
                                fa.id,
                                fa.etebare_ghabele_enteghal,
                                fa.etebare_baghimande,
                                fa.emkanat_id,
                                ser.type,
                                IF(fa.emkanat_id = 1,sub.telephone1,IF(fa.emkanat_id=2,sub.telephone2,IF(fa.emkanat_id=3,sub.telephone3,null))) ibs_username
                            FROM bnm_factor fa
                                INNER JOIN bnm_subscribers sub ON sub.id = fa.subscriber_id
                                INNER JOIN bnm_services ser ON ser.id = fa.service_id
                                WHERE fa.id = ?
                            ";
                        $res_ibsusername = Db::secure_fetchall($sql, [$res_factor[0]['id'], 1]);
                        if ($res_ibsusername) {
                            if ($res_ibsusername[0]['ibs_username']) {
                                $sql = "SELECT fa.id, fa.tarikhe_payane_service, fa.tarikhe_shoroe_service, ser.terafik
                                FROM
                                    bnm_factor fa
                                    INNER JOIN bnm_subscribers sub ON sub.id = fa.subscriber_id
                                    INNER JOIN bnm_services ser ON ser.id = fa.service_id
                                WHERE
                                    fa.id <> ? AND fa.emkanat_id = ? AND fa.subscriber_id = ?
                                    AND ser.type = ? AND ser.noe_forosh IN (?,?)
                                    ORDER BY fa.tarikhe_factor DESC Limit 1";
                                $prefactor = Db::secure_fetchall($sql, [
                                    $res_factor[0]['id'],
                                    $res_factor[0]['emkanat_id'],
                                    $res_subscriber[0]['id'],
                                    1,
                                    $res_service[0]['type'],
                                    "adi",
                                    "jashnvare",
                                ]);
                            } else {
                                die(Helper::Json_Message('f'));
                            }
                        } else {
                            $prefactor = false;
                        }
                        break;
                    default:
                        die(Helper::Custom_Msg(Helper::Messages('icf') . ' ' . Helper::Messages('ps'), 2));
                        break;
                }
                /////////////credits operations
                switch ($_POST['noe_pardakht']) {
                    case "pardakht_az_subscriber":
                        if (Helper::Is_Empty_OR_Null($res_service[0]['noe_forosh'])) {
                            if ($res_subscriber[0]['branch_id'] !== 0) {
                                //user braraye namayande ast
                                if ($res_credit_subscriber) {
                                    //moshtarak hesabe bank darad
                                    if (Helper::checkSubscriberCreditForPay($res_credit_subscriber[0]['credit'], $res_factor[0]['mablaghe_ghabele_pardakht'])) {
                                        if ($res_noe_hamkari) {
                                            //kasre mablaghe factor az moshtarak
                                            $subscriber_credit_array = array();
                                            $subscriber_credit_array['credit'] = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])));
                                            $subscriber_credit_array['bedehkar'] = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])));
                                            $subscriber_credit_array['bestankar'] = 0;
                                            $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                            $subscriber_credit_array['noe_user'] = '1';
                                            $subscriber_credit_array['tozihat'] = 'فاکتور شما توسط نماینده/سروکو در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'] . 'پرداخت شد.';
                                            $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                            $subscriber_credit_array['modifier_id'] = $_SESSION['user_id'];
                                            $sql = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                            $result = Db::secure_insert_array($sql, $subscriber_credit_array);
                                            if ($result) {
                                                //kasre mablaghe maliat va arzeshe afzode az moshtarak
                                                $subscriber_credit_array = array();
                                                $subscriber_credit_array['credit'] = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                $subscriber_credit_array['bedehkar'] = (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                $subscriber_credit_array['bestankar'] = 0;
                                                $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                $subscriber_credit_array['noe_user'] = '1';
                                                $subscriber_credit_array['tozihat'] = 'کسر مالیات و ارزش افزوده توسط سیستم در تاریخ: ' . Helper::Today_Shamsi_Date('-');
                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                $subscriber_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                $sql = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                $result = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                //get noe_hamkari info for this factor
                                                //mohasebe soode namayande az in forosh
                                                if ($res_noe_hamkari[0]['cooperation_type'] === 1) {
                                                    //namayande->darsadi
                                                    $flag_noe_kharid = "service_jadid";
                                                    if ($res_factor_noe_kharid) {
                                                        if ($res_factor_noe_kharid[0]['rows_num'] === 0) {
                                                            $flag_noe_kharid = "service_jadid";
                                                        } else {
                                                            $flag_noe_kharid = "sharje_mojadad";
                                                        }
                                                    } else {
                                                        $flag_noe_kharid = "service_jadid";
                                                    }
                                                    $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user=? ORDER BY id DESC LIMIT 1";
                                                    $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id'], 2));
                                                    switch ($res_service[0]['noe_forosh']) {
                                                        case 'adi':
                                                            if ($flag_noe_kharid == "sharje_mojadad") {
                                                                if ($res_credit_branch) {
                                                                    //pardakhte porsante namayande baraye sharje mojadad zamani ke namayande hesabe bank darad
                                                                    $branch_credit_array = array();
                                                                    $branch_credit_array['credit'] = floatval($res_credit_branch[0]['credit']) + (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_sharje_mojadad']) / 100);
                                                                    $branch_credit_array['bestankar'] = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_sharje_mojadad']) / 100);
                                                                    $branch_credit_array['bedehkar'] = 0;
                                                                    $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                    $branch_credit_array['noe_user'] = '2';
                                                                    $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                    $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                    $branch_credit_array['tozihat'] = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                    $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                    $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                                } else {
                                                                    //pardakhte porsante namayande baraye sharje mojadad zamani ke namayande hesabe bank nadarad
                                                                    $branch_credit_array = array();
                                                                    $branch_credit_array['credit'] = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_sharje_mojadad']) / 100);
                                                                    $branch_credit_array['bestankar'] = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_sharje_mojadad']) / 100);
                                                                    $branch_credit_array['bedehkar'] = 0;
                                                                    $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                    $branch_credit_array['noe_user'] = '2';
                                                                    $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                    $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                    $branch_credit_array['tozihat'] = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                    $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                    $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                                }
                                                            } elseif ($flag_noe_kharid == "service_jadid") {

                                                                if ($res_credit_branch) {
                                                                    //pardakhte porsante namayande baraye service jadid zamani ke namayande hesabe bank darad
                                                                    $branch_credit_array = array();
                                                                    $branch_credit_array['credit'] = floatval($res_credit_branch[0]['credit']) + (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_jadid']) / 100);
                                                                    $branch_credit_array['bestankar'] = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_jadid']) / 100);
                                                                    $branch_credit_array['bedehkar'] = 0;
                                                                    $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                    $branch_credit_array['noe_user'] = '2';
                                                                    $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                    $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                    $branch_credit_array['tozihat'] = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                    $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                    $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                                } else {
                                                                    //pardakhte porsante namayande baraye service jadid zamani ke namayande hesabe bank nadarad
                                                                    $branch_credit_array = array();
                                                                    $branch_credit_array['credit'] = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_jadid']) / 100);
                                                                    $branch_credit_array['bestankar'] = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_jadid']) / 100);
                                                                    $branch_credit_array['bedehkar'] = 0;
                                                                    $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                    $branch_credit_array['noe_user'] = '2';
                                                                    $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                    $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                    $branch_credit_array['tozihat'] = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                    $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                    $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                                }
                                                            }
                                                            break;
                                                        case 'bulk':
                                                            if ($res_credit_branch) {
                                                                //pardakhte porsante namayande baraye bulk zamani ke namayande hesabe bank darad
                                                                $branch_credit_array = array();
                                                                $branch_credit_array['credit'] = floatval($res_credit_branch[0]['credit']) + ((floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_bulk']) / 100));
                                                                $branch_credit_array['bestankar'] = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_bulk']) / 100);
                                                                $branch_credit_array['bedehkar'] = 0;
                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                $branch_credit_array['noe_user'] = '2';
                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                $branch_credit_array['tozihat'] = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                            } else {
                                                                //pardakhte porsante namayande baraye bulk zamani ke namayande hesabe bank nadarad
                                                                $branch_credit_array = array();
                                                                $branch_credit_array['credit'] = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_bulk']) / 100);
                                                                $branch_credit_array['bestankar'] = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_bulk']) / 100);
                                                                $branch_credit_array['bedehkar'] = 0;
                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                $branch_credit_array['noe_user'] = '2';
                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                $branch_credit_array['tozihat'] = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                            }
                                                            break;
                                                        case 'jashnvare':
                                                            if ($res_credit_branch) {
                                                                //pardakhte porsante namayande baraye jashnvare zamani ke namayande hesabe bank darad
                                                                $branch_credit_array = array();
                                                                $branch_credit_array['credit'] = floatval($res_credit_branch[0]['credit']) + ((floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_jashnvare']) / 100));
                                                                $branch_credit_array['bestankar'] = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_jashnvare']) / 100);
                                                                $branch_credit_array['bedehkar'] = 0;
                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                $branch_credit_array['noe_user'] = '2';
                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                $branch_credit_array['tozihat'] = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                            } else {
                                                                //pardakhte porsante namayande baraye jashnvare zamani ke namayande hesabe bank nadarad
                                                                $branch_credit_array = array();
                                                                $branch_credit_array['credit'] = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_jashnvare']) / 100);
                                                                $branch_credit_array['bestankar'] = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['foroshe_service_jashnvare']) / 100);
                                                                $branch_credit_array['bedehkar'] = 0;
                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                $branch_credit_array['noe_user'] = '2';
                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                $branch_credit_array['tozihat'] = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                            }

                                                            break;

                                                        default:
                                                            die(Helper::Json_Message('service_info_not_right'));
                                                            break;
                                                    }
                                                } elseif ($res_noe_hamkari[0]['cooperation_type'] === 2) {
                                                    // license
                                                    $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user=? ORDER BY id DESC LIMIT 1";
                                                    $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id'], 2));
                                                    if ($res_credit_branch) {
                                                        //pardakhte porsante(lisence) namayande zamani ke namayande hesabe bank darad
                                                        //insert credit + mablaghe_ghabele_pardakht
                                                        $branch_credit_array = array();
                                                        $branch_credit_array['credit'] = floatval($res_credit_branch[0]['credit']) + floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                        $branch_credit_array['bestankar'] = floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                        $branch_credit_array['bedehkar'] = 0;
                                                        $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                        $branch_credit_array['noe_user'] = '2';
                                                        $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                        $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                        $branch_credit_array['tozihat'] = 'پرداخت مبلغ فاکتور برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                        $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                        $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                        //insert credit - maliat /update tozihat
                                                        $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                        $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id'], 2));
                                                        $branch_credit_array = array();
                                                        $branch_credit_array['credit'] = floatval($res_credit_branch[0]['credit']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])); //-maliat
                                                        $branch_credit_array['bestankar'] = 0;
                                                        $branch_credit_array['bedehkar'] = (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])); //-maliat
                                                        $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                        $branch_credit_array['noe_user'] = '2';
                                                        $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                        $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                        $branch_credit_array['tozihat'] = 'کسر مالیات برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                        $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                        $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                        //insert credit - darsade hazine_sazmane_tanzim /update tozihat
                                                        $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                        $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id'], 2));
                                                        $branch_credit_array = array();
                                                        $branch_credit_array['credit'] = floatval($res_credit_branch[0]['credit']) - ((floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['hazine_sazmane_tanzim']) / 100));
                                                        $branch_credit_array['bestankar'] = 0;
                                                        $branch_credit_array['bedehkar'] = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['hazine_sazmane_tanzim']) / 100);
                                                        $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                        $branch_credit_array['noe_user'] = '2';
                                                        $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                        $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                        $branch_credit_array['tozihat'] = 'کسر هزینه سازمان تنظیم برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                        $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                        $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                        //insert credit - darsade hazine_servco /update tozihat
                                                        $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                        $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id'], 2));
                                                        $branch_credit_array = array();
                                                        $branch_credit_array['credit'] = floatval($res_credit_branch[0]['credit']) - ((floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['hazine_servco']) / 100));
                                                        $branch_credit_array['bestankar'] = 0;
                                                        $branch_credit_array['bedehkar'] = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['hazine_servco']) / 100);
                                                        $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                        $branch_credit_array['noe_user'] = '2';
                                                        $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                        $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                        $branch_credit_array['tozihat'] = 'کسر هزینه سروکو برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                        $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                        $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                        //insert credit - darsade hazine_mansobe /update tozihat
                                                        $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                        $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id'], 2));
                                                        $branch_credit_array = array();
                                                        $branch_credit_array['credit'] = floatval($res_credit_branch[0]['credit']) - floatval($res_noe_hamkari[0]['hazine_mansobe']);
                                                        $branch_credit_array['bestankar'] = 0;
                                                        $branch_credit_array['bedehkar'] = floatval($res_noe_hamkari[0]['hazine_mansobe']);
                                                        $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                        $branch_credit_array['noe_user'] = '2';
                                                        $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                        $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                        $branch_credit_array['tozihat'] = 'کسر هزینه منصوبه برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                        $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                        $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                        // Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                                                        // die(Helper::Json_Message('pardakht_success'));
                                                    } else {
                                                        //pardakhte porsante(lisence) namayande zamani ke namayande hesabe bank nadarad
                                                        //NO credit Account
                                                        //insert credit + mablaghe_ghabele_pardakht
                                                        $branch_credit_array = array();
                                                        $branch_credit_array['credit'] = floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                        $branch_credit_array['bestankar'] = floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                        $branch_credit_array['bedehkar'] = 0;
                                                        $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                        $branch_credit_array['noe_user'] = '2';
                                                        $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                        $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                        $branch_credit_array['tozihat'] = 'پرداخت مبلغ فاکتور برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                        $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                        $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                        //insert credit - maliat /update tozihat
                                                        $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                        $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id'], 2));
                                                        $branch_credit_array = array();
                                                        $branch_credit_array['credit'] = floatval($res_credit_branch[0]['credit']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])); //-maliat
                                                        $branch_credit_array['bestankar'] = 0;
                                                        $branch_credit_array['bedehkar'] = (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])); //-maliat
                                                        $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                        $branch_credit_array['noe_user'] = '2';
                                                        $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                        $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                        $branch_credit_array['tozihat'] = 'کسر مالیات برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                        $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                        $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                        //insert credit - darsade hazine_sazmane_tanzim /update tozihat
                                                        $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                        $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id'], 2));
                                                        $branch_credit_array = array();
                                                        $branch_credit_array['credit'] = floatval($res_credit_branch[0]['credit']) - ((floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['hazine_sazmane_tanzim']) / 100));
                                                        $branch_credit_array['bestankar'] = 0;
                                                        $branch_credit_array['bedehkar'] = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['hazine_sazmane_tanzim']) / 100);
                                                        $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                        $branch_credit_array['noe_user'] = '2';
                                                        $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                        $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                        $branch_credit_array['tozihat'] = 'کسر هزینه سازمان تنظیم برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                        $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                        $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                        //insert credit - darsade hazine_servco /update tozihat
                                                        $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                        $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id'], 2));
                                                        $branch_credit_array = array();
                                                        $branch_credit_array['credit'] = floatval($res_credit_branch[0]['credit']) - ((floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['hazine_servco']) / 100));
                                                        $branch_credit_array['bestankar'] = 0;
                                                        $branch_credit_array['bedehkar'] = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * (floatval($res_noe_hamkari[0]['hazine_servco']) / 100);
                                                        $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                        $branch_credit_array['noe_user'] = '2';
                                                        $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                        $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                        $branch_credit_array['tozihat'] = 'کسر هزینه سروکو برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                        $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                        $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                        //insert credit - darsade hazine_mansobe /update tozihat
                                                        $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                        $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id'], 2));
                                                        $branch_credit_array = array();
                                                        $branch_credit_array['credit'] = floatval($res_credit_branch[0]['credit']) - floatval($res_noe_hamkari[0]['hazine_mansobe']);
                                                        $branch_credit_array['bestankar'] = 0;
                                                        $branch_credit_array['bedehkar'] = floatval($res_noe_hamkari[0]['hazine_mansobe']);
                                                        $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                        $branch_credit_array['noe_user'] = '2';
                                                        $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                        $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                        $branch_credit_array['tozihat'] = 'کسر هزینه منصوبه برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                        $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                        $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                        // Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                                                        // die(Helper::Json_Message('pardakht_success'));
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
                                if ($res_credit_subscriber) {
                                    if (Helper::checkSubscriberCreditForPay($res_credit_subscriber[0]['credit'], $res_factor[0]['mablaghe_ghabele_pardakht'])) {
                                        //kasre mablaghe factor az moshtarak
                                        $subscriber_credit_array = array();
                                        // $subscriber_credit_array['change_amount']  = abs(floatval($res_credit_subscriber[0]['credit'])) - (abs(floatval($res_factor[0]['mablaghe_ghabele_pardakht'])) - (abs(floatval($res_factor[0]['maliate_arzeshe_afzode'])) + abs(floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))));
                                        $subscriber_credit_array['credit'] = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])));
                                        $subscriber_credit_array['bedehkar'] = floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + abs(floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])));
                                        $subscriber_credit_array['bestankar'] = 0;
                                        $subscriber_credit_array['user_or_branch_id'] = $res_factor[0]['subscriber_id'];
                                        $subscriber_credit_array['noe_user'] = '1';
                                        $subscriber_credit_array['tozihat'] = 'فاکتور شما توسط نماینده/شرکت در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                        $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                        $subscriber_credit_array['modifier_id'] = $_SESSION['user_id'];
                                        $sql = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                        $result = Db::secure_insert_array($sql, $subscriber_credit_array);
                                        if ($result) {
                                            $sql_credit_subscriber = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                            $res_credit_subscriber = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id'], 1));
                                            $subscriber_credit_array = array();
                                            $subscriber_credit_array['credit'] = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + abs(floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])));
                                            $subscriber_credit_array['bedehkar'] = floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']);
                                            $subscriber_credit_array['bestankar'] = 0;
                                            $subscriber_credit_array['user_or_branch_id'] = $res_factor[0]['subscriber_id'];
                                            $subscriber_credit_array['noe_user'] = '1';
                                            $subscriber_credit_array['tozihat'] = 'کسر مالیات و ارزش افزوده توسط سیستم در تاریخ: ' . Helper::Today_Shamsi_Date('-');
                                            $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                            $subscriber_credit_array['modifier_id'] = $_SESSION['user_id'];
                                            $sql = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                            $result = Db::secure_insert_array($sql, $subscriber_credit_array);
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
                            die(Helper::Json_Message('service_info_not_right'));
                        }
                        Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                        break;
                    case "pardakht_az_namayande":
                        if (Helper::Is_Empty_OR_Null($res_service[0]['noe_forosh'])) {
                            if ($res_subscriber[0]['branch_id'] !== 0) {
                                //moshtarak baraye namayande ast
                                switch ($_SESSION['user_type']) {
                                    case __ADMINUSERTYPE__:
                                        if ($res_branch[0]['id'] === $res_subscriber[0]['branch_id']) {
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
                                                                $branch_credit_array = array();
                                                                $branch_credit_array['credit'] = floatval($res_credit_branch[0]['credit']) - (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])));
                                                                $branch_credit_array['bestankar'] = 0;
                                                                $branch_credit_array['bedehkar'] = floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (abs(floatval($res_factor[0]['maliate_arzeshe_afzode'])) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                $branch_credit_array['noe_user'] = '2';
                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                $branch_credit_array['tozihat'] = 'پرداخت مبلغ فاکتور توسط نماینده/شرکت برای شماره : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                                //kasre maliat az hesabe namayande
                                                                $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                                $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id'], 2));
                                                                $branch_credit_array = array();
                                                                $branch_credit_array['credit'] = floatval($res_credit_branch[0]['credit']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                $branch_credit_array['bestankar'] = 0;
                                                                $branch_credit_array['bedehkar'] = (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                $branch_credit_array['noe_user'] = '2';
                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                $branch_credit_array['tozihat'] = 'کسر مالیات توسط سیستم برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                                if ($res_credit_subscriber) {
                                                                    // user has an account already
                                                                    //add mablaghe kol to user credit
                                                                    $subscriber_credit_array = array();
                                                                    $subscriber_credit_array['credit'] = floatval($res_credit_subscriber[0]['credit']) + floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                    $subscriber_credit_array['bedehkar'] = 0;
                                                                    $subscriber_credit_array['bestankar'] = floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                    $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                                    $subscriber_credit_array['noe_user'] = '1';
                                                                    $subscriber_credit_array['tozihat'] = 'بدهکاری مشترک به نماینده در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                    $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                    $subscriber_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                    $sql = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                    $result = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                    //kasre asle mablaghe kol az moshtarak
                                                                    $sql_credit_subscriber = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                                    $res_credit_subscriber = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id'], 1));
                                                                    $subscriber_credit_array = array();
                                                                    $subscriber_credit_array['credit'] = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])));
                                                                    $subscriber_credit_array['bedehkar'] = floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                    $subscriber_credit_array['bestankar'] = 0;
                                                                    $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                                    $subscriber_credit_array['noe_user'] = '1';
                                                                    $subscriber_credit_array['tozihat'] = 'کسر اصل مبلغ فاکتور توسط سیستم در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                    $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                    $subscriber_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                    $sql = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                    $result = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                    //kasre credit - maliat+arzeshe afzoode az moshtarak
                                                                    $sql_credit_subscriber = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                                    $res_credit_subscriber = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id'], 1));
                                                                    $subscriber_credit_array = array();
                                                                    $subscriber_credit_array['credit'] = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                    $subscriber_credit_array['bedehkar'] = (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                    $subscriber_credit_array['bestankar'] = 0;
                                                                    $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                                    $subscriber_credit_array['noe_user'] = '1';
                                                                    $subscriber_credit_array['tozihat'] = 'کسر مالیات و ارزش افزوده توسط نماینده/شرکت در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                    $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                    $subscriber_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                    $sql = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                    $result = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                } else {
                                                                    //create user account
                                                                    //add mablaghe kol to user credit
                                                                    $subscriber_credit_array = array();
                                                                    $subscriber_credit_array['credit'] = floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                    $subscriber_credit_array['bedehkar'] = 0;
                                                                    $subscriber_credit_array['bestankar'] = floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                    $subscriber_credit_array['user_or_branch_id'] = $res_subscriber[0]['id'];
                                                                    $subscriber_credit_array['noe_user'] = '1';
                                                                    $subscriber_credit_array['tozihat'] = 'بدهکاری مشترک به نماینده در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                    $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                    $subscriber_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                    $sql = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                    $result = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                    //kasre asle mablaghe kol az moshtarak
                                                                    $sql_credit_subscriber = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                                    $res_credit_subscriber = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id'], 1));
                                                                    $subscriber_credit_array = array();
                                                                    $subscriber_credit_array['credit'] = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])));
                                                                    $subscriber_credit_array['bedehkar'] = floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                    $subscriber_credit_array['bestankar'] = 0;
                                                                    $subscriber_credit_array['user_or_branch_id'] = $res_subscriber[0]['id'];
                                                                    $subscriber_credit_array['noe_user'] = '1';
                                                                    $subscriber_credit_array['tozihat'] = 'کسر اصل مبلغ فاکتور توسط سیستم در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                    $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                    $subscriber_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                    $sql = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                    $result = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                    $sql_credit_subscriber = "SELECT * FROM bnm_credits WHERE user_or_branch_id={$res_subscriber[0]['id']} AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                                    $res_credit_subscriber = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id'], 1));
                                                                    //kasre credit - maliat+arzeshe afzoode az moshtarak
                                                                    $sql_credit_subscriber = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                                    $res_credit_subscriber = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id'], 1));
                                                                    $subscriber_credit_array = array();
                                                                    $subscriber_credit_array['credit'] = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                    $subscriber_credit_array['bedehkar'] = (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                    $subscriber_credit_array['bestankar'] = 0;
                                                                    $subscriber_credit_array['user_or_branch_id'] = $res_subscriber[0]['id'];
                                                                    $subscriber_credit_array['noe_user'] = '1';
                                                                    $subscriber_credit_array['tozihat'] = 'کسر مالیات و ارزش افزوده توسط نماینده/شرکت در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                    $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                    $subscriber_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                    $sql = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                    $result = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                }
                                                                // $sql_factor_noe_kharid = "SELECT COUNT(*) AS rows_num FROM bnm_factor WHERE subscriber_id=? AND noe_khadamat=? AND tasvie_shode='1'";
                                                                // $res_factor_noe_kharid = Db::secure_fetchall($sql_factor_noe_kharid, array($res_factor[0]['subscriber_id'], $res_service[0]['noe_khadamat']));
                                                                $flag_noe_kharid = "service_jadid";
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
                                                                        $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                                        $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id'], 2));
                                                                        if ($flag_noe_kharid == "sharje_mojadad") {
                                                                            //pardakhte porsante namayande baraye sharje mojadad zamani ke namayande hesabe bank darad
                                                                            $branch_credit_array = array();
                                                                            $branch_credit_array['credit'] = floatval($res_credit_branch[0]['credit']) + (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * ($res_noe_hamkari[0]['foroshe_service_sharje_mojadad'] / 100);
                                                                            $branch_credit_array['bestankar'] = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * ($res_noe_hamkari[0]['foroshe_service_sharje_mojadad'] / 100);
                                                                            $branch_credit_array['bedehkar'] = 0;
                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                            $branch_credit_array['noe_user'] = '2';
                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                            $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                            $branch_credit_array['tozihat'] = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                            $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                            $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                                        } elseif ($flag_noe_kharid == "service_jadid") {
                                                                            //pardakhte porsante namayande baraye service jadid zamani ke namayande hesabe bank darad
                                                                            $branch_credit_array = array();
                                                                            $branch_credit_array['credit'] = floatval($res_credit_branch[0]['credit']) + (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * ($res_noe_hamkari[0]['foroshe_service_jadid'] / 100);
                                                                            $branch_credit_array['bestankar'] = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * ($res_noe_hamkari[0]['foroshe_service_jadid'] / 100);
                                                                            $branch_credit_array['bedehkar'] = 0;
                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                            $branch_credit_array['noe_user'] = '2';
                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                            $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                            $branch_credit_array['tozihat'] = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                            $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                            $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                                        }
                                                                        // Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                                                                        // die(Helper::Json_Message('pardakht_success'));
                                                                        break;
                                                                    case 'bulk':
                                                                        $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                                        $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id'], 2));
                                                                        //pardakhte porsante namayande baraye bulk zamani ke namayande hesabe bank darad
                                                                        $branch_credit_array = array();
                                                                        $branch_credit_array['credit'] = floatval($res_credit_branch[0]['credit']) + (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * ($res_noe_hamkari[0]['foroshe_service_bulk'] / 100);
                                                                        $branch_credit_array['bestankar'] = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * ($res_noe_hamkari[0]['foroshe_service_bulk'] / 100);
                                                                        $branch_credit_array['bedehkar'] = 0;
                                                                        $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                        $branch_credit_array['noe_user'] = '2';
                                                                        $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                        $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                        $branch_credit_array['tozihat'] = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                        $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                        $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                                        // Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                                                                        // die(Helper::Json_Message('pardakht_success'));
                                                                        break;
                                                                    case 'jashnvare':
                                                                        $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                                        $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id'], 2));
                                                                        //pardakhte porsante namayande baraye jashnvare zamani ke namayande hesabe bank darad
                                                                        $branch_credit_array = array();
                                                                        $branch_credit_array['credit'] = floatval($res_credit_branch[0]['credit']) + (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * ($res_noe_hamkari[0]['foroshe_service_jashnvare'] / 100);
                                                                        $branch_credit_array['bestankar'] = (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))) * ($res_noe_hamkari[0]['foroshe_service_jashnvare'] / 100);
                                                                        $branch_credit_array['bedehkar'] = 0;
                                                                        $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                        $branch_credit_array['noe_user'] = '2';
                                                                        $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                        $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                        $branch_credit_array['tozihat'] = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                        $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                        $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                                        // Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                                                                        // die(Helper::Json_Message('pardakht_success'));
                                                                        break;
                                                                    default:
                                                                        die(Helper::Json_Message('service_info_not_right'));
                                                                        break;
                                                                }
                                                            } elseif ($res_noe_hamkari[0]['cooperation_type'] === 2) {
                                                                //pardakht az namayande->license
                                                                $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                                $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id'], 2));
                                                                //pardakhte porsante(lisence) namayande zamani ke namayande hesabe bank darad
                                                                //insert credit ghabli
                                                                $branch_credit_array = array();
                                                                $branch_credit_array['credit'] = floatval($res_credit_branch[0]['credit']);
                                                                $branch_credit_array['bestankar'] = 0;
                                                                $branch_credit_array['bedehkar'] = 0;
                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                $branch_credit_array['noe_user'] = '2';
                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                $branch_credit_array['tozihat'] = 'پرداخت مبلغ فاکتور برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                                //insert credit - maliat /update tozihat
                                                                $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                                $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id'], 2));
                                                                $branch_credit_array = array();
                                                                $branch_credit_array['credit'] = abs(floatval($res_credit_branch[0]['credit'])) - (abs(floatval($res_factor[0]['maliate_arzeshe_afzode'])) + abs(floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))); //-maliat
                                                                $branch_credit_array['bestankar'] = 0;
                                                                $branch_credit_array['bedehkar'] = (abs(floatval($res_factor[0]['maliate_arzeshe_afzode'])) + abs(floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']))); //-maliat
                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                $branch_credit_array['noe_user'] = '2';
                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                $branch_credit_array['tozihat'] = 'کسر مالیات برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                                //insert credit - darsade hazine_sazmane_tanzim /update tozihat
                                                                $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                                $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id'], 2));
                                                                $branch_credit_array = array();
                                                                $branch_credit_array['credit'] = abs(floatval($res_credit_branch[0]['credit'])) - ((abs(floatval($res_factor[0]['mablaghe_ghabele_pardakht'])) - (abs(floatval($res_factor[0]['maliate_arzeshe_afzode'])) + abs(floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])))) * floatval($res_noe_hamkari[0]['hazine_sazmane_tanzim']) / 100); //-hazine_sazmane_tanzim
                                                                $branch_credit_array['bestankar'] = 0;
                                                                $branch_credit_array['bedehkar'] = (abs(floatval($res_factor[0]['mablaghe_ghabele_pardakht'])) - (abs(floatval($res_factor[0]['maliate_arzeshe_afzode'])) + abs(floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])))) * floatval($res_noe_hamkari[0]['hazine_sazmane_tanzim']) / 100;
                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                $branch_credit_array['noe_user'] = '2';
                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                $branch_credit_array['tozihat'] = 'کسر هزینه سازمان تنظیم برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                                //insert credit - darsade hazine_servco /update tozihat
                                                                $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                                $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id'], 2));
                                                                $branch_credit_array = array();
                                                                $branch_credit_array['credit'] = abs(floatval($res_credit_branch[0]['credit'])) - ((abs(floatval($res_factor[0]['mablaghe_ghabele_pardakht'])) - (abs(floatval($res_factor[0]['maliate_arzeshe_afzode'])) + abs(floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])))) * floatval($res_noe_hamkari[0]['hazine_servco']) / 100); //-hazine_servco
                                                                $branch_credit_array['bestankar'] = 0;
                                                                $branch_credit_array['bedehkar'] = (abs(floatval($res_factor[0]['mablaghe_ghabele_pardakht'])) - (abs(floatval($res_factor[0]['maliate_arzeshe_afzode'])) + abs(floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])))) * floatval($res_noe_hamkari[0]['hazine_servco']) / 100; //-hazine_servco
                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                $branch_credit_array['noe_user'] = '2';
                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                $branch_credit_array['tozihat'] = 'کسر هزینه سروکو برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                                //insert credit - darsade hazine_mansobe /update tozihat
                                                                $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                                $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id'], 2));
                                                                $branch_credit_array = array();
                                                                $branch_credit_array['credit'] = abs(floatval($res_credit_branch[0]['credit'])) - floatval($res_noe_hamkari[0]['hazine_mansobe']); //-hazine_mansobe
                                                                $branch_credit_array['bestankar'] = 0;
                                                                $branch_credit_array['bedehkar'] = floatval($res_noe_hamkari[0]['hazine_mansobe']);
                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                $branch_credit_array['noe_user'] = '2';
                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                $branch_credit_array['tozihat'] = 'کسر هزینه منصوبه برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                                ////////////////////////////subscriber credit //////////////////////////////////////////
                                                                $sql_credit_subscriber = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                                $res_credit_subscriber = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id'], 1));
                                                                if ($res_credit_subscriber) {
                                                                    // user has an account already
                                                                    //add mablaghe kol to user credit
                                                                    $subscriber_credit_array = array();
                                                                    $subscriber_credit_array['credit'] = floatval($res_credit_subscriber[0]['credit']) + floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                    $subscriber_credit_array['bedehkar'] = 0;
                                                                    $subscriber_credit_array['bestankar'] = floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                    $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                                    $subscriber_credit_array['noe_user'] = '1';
                                                                    $subscriber_credit_array['tozihat'] = 'بدهکاری مشترک به نماینده در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                    $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                    $subscriber_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                    $sql = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                    $result = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                    //kasre asle mablaghe kol az moshtarak
                                                                    $sql_credit_subscriber = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                                    $res_credit_subscriber = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id'], 1));
                                                                    $subscriber_credit_array = array();
                                                                    $subscriber_credit_array['credit'] = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])));
                                                                    $subscriber_credit_array['bedehkar'] = floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                    $subscriber_credit_array['bestankar'] = 0;
                                                                    $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                                    $subscriber_credit_array['noe_user'] = '1';
                                                                    $subscriber_credit_array['tozihat'] = 'کسر مالیات توسط سیستم در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                    $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                    $subscriber_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                    $sql = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                    $result = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                    //kasre credit - maliat+arzeshe afzoode az moshtarak
                                                                    $sql_credit_subscriber = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                                    $res_credit_subscriber = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id'], 1));
                                                                    $subscriber_credit_array = array();
                                                                    $subscriber_credit_array['credit'] = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                    $subscriber_credit_array['bedehkar'] = (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                    $subscriber_credit_array['bestankar'] = 0;
                                                                    $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                                    $subscriber_credit_array['noe_user'] = '1';
                                                                    $subscriber_credit_array['tozihat'] = 'کسر مبلغ فاکتور توسط نماینده/شرکت در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                    $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                    $subscriber_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                    $sql = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                    $result = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                } else {
                                                                    //create user account
                                                                    //add mablaghe kol to user credit
                                                                    $subscriber_credit_array = array();
                                                                    $subscriber_credit_array['credit'] = floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                    $subscriber_credit_array['bedehkar'] = 0;
                                                                    $subscriber_credit_array['bestankar'] = floatval($res_factor[0]['mablaghe_ghabele_pardakht']);
                                                                    $subscriber_credit_array['user_or_branch_id'] = $res_factor[0]['subscriber_id'];
                                                                    $subscriber_credit_array['noe_user'] = '1';
                                                                    $subscriber_credit_array['tozihat'] = 'بدهکاری مشترک به نماینده در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                    $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                    $subscriber_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                    $sql = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                    $result = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                    //kasre asle mablaghe kol az moshtarak
                                                                    $sql_credit_subscriber = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                                    $res_credit_subscriber = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id'], 1));
                                                                    $subscriber_credit_array = array();
                                                                    $subscriber_credit_array['credit'] = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode'])));
                                                                    $subscriber_credit_array['bedehkar'] = floatval($res_factor[0]['mablaghe_ghabele_pardakht']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                    $subscriber_credit_array['bestankar'] = 0;
                                                                    $subscriber_credit_array['user_or_branch_id'] = $res_factor[0]['subscriber_id'];
                                                                    $subscriber_credit_array['noe_user'] = '1';
                                                                    $subscriber_credit_array['tozihat'] = 'کسر مالیات توسط سیستم در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                    $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                    $subscriber_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                    $sql = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                    $result = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                    //kasre credit - maliat+arzeshe afzoode az moshtarak
                                                                    $sql_credit_subscriber = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                                    $res_credit_subscriber = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id'], 1));
                                                                    $subscriber_credit_array = array();
                                                                    $subscriber_credit_array['credit'] = floatval($res_credit_subscriber[0]['credit']) - (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                    $subscriber_credit_array['bedehkar'] = (floatval($res_factor[0]['maliate_arzeshe_afzode']) + floatval($res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                    $subscriber_credit_array['bestankar'] = 0;
                                                                    $subscriber_credit_array['user_or_branch_id'] = $res_factor[0]['subscriber_id'];
                                                                    $subscriber_credit_array['noe_user'] = '1';
                                                                    $subscriber_credit_array['tozihat'] = 'کسر مبلغ فاکتور توسط نماینده/شرکت در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                    $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                    $subscriber_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                    $sql = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                    $result = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                }
                                                                // Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                                                                // die(Helper::Json_Message('pardakht_success'));
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
                            die(Helper::Json_Message('service_info_not_right'));
                        }
                        Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                        break;
                    case "pardakht_dasti":
                        die(Helper::Json_Message('info_not_true'));
                        break;

                    default:
                        die(Helper::Json_Message('info_not_true'));
                        break;
                }
                //////ibs operations/////
                if ($result) {
                    if ($res_service[0]['noe_forosh'] === "adi" || $res_service[0]['noe_forosh'] === "jashnvare") {
                        if ($res_factor_noe_kharid[0]['rows_num'] === 0) {
                            //new user
                            $res_addnewuser = $GLOBALS['ibs_internet']->addNewUser(1, $res_service[0]['terafik'], 'Main', $res_service[0]['onvane_service'], $res_subscriber[0]['code_meli']);
                            if (Helper::ibsCheckResponse($res_addnewuser)) {
                                if ($res_factor[0]['noe_moshtarak'] === "real") {
                                    $res_setuserattrs = $GLOBALS['ibs_internet']->setUserAttributes(
                                        (string) $res_addnewuser[1][0],
                                        array(
                                            "name" => $res_subscriber[0]['name'] . ' ' . $res_subscriber[0]['f_name'],
                                            "comment" => $res_subscriber[0]['code_meli'],
                                            "phone" => (string) $res_ibsusername[0]['ibs_username'],
                                            "cell_phone" => $res_subscriber[0]['telephone_hamrah'],
                                            "postal_code" => $res_subscriber[0]['shahkar_status_code'],
                                            "email" => $res_subscriber[0]['shomare_shenasname'] . ',' . $res_factor[0]['city_name'],
                                            "address" => $res_service[0]['type'],
                                            "birthdate" => $res_subscriber[0]['tarikhe_tavalod'],
                                            "birthdate_unit" => 'gregorian',
                                            "abs_exp_date" => $res_factor[0]['tarikhe_payane_service'],
                                            "abs_exp_date_unit" => 'gregorian',
                                            "normal_user_spec" => array(
                                                "normal_username" => (string) $res_ibsusername[0]['ibs_username'],
                                                "normal_password" => (string) $res_subscriber[0]['code_meli'],
                                            ),
                                        )
                                    );
                                } else {
                                    $res_setuserattrs = $GLOBALS['ibs_internet']->setUserAttributes(
                                        (string) $res_addnewuser[1][0],
                                        array(
                                            "name" => $res_subscriber[0]['name_sherkat'],
                                            "comment" => $res_subscriber[0]['shenase_meli'],
                                            "phone" => (string) $res_ibsusername[0]['ibs_username'],
                                            "cell_phone" => $res_subscriber[0]['telephone_hamrah'],
                                            "postal_code" => $res_subscriber[0]['shahkar_status_code'],
                                            "email" => $res_subscriber[0]['shomare_sabt'] . ',' . $res_factor[0]['city_name'],
                                            "address" => $res_service[0]['type'],
                                            "birthdate" => $res_subscriber[0]['tarikhe_sabt'],
                                            "birthdate_unit" => 'gregorian',
                                            "abs_exp_date" => $res_factor[0]['tarikhe_payane_service'],
                                            "abs_exp_date_unit" => 'gregorian',
                                            "normal_user_spec" => array(
                                                "normal_username" => (string) $res_ibsusername[0]['ibs_username'],
                                                "normal_password" => (string) $res_subscriber[0]['shenase_meli'],
                                            ),
                                        )
                                    );
                                }
                                die(json_encode($res_setuserattrs));
                                if (Helper::ibsCheckResponse($res_setuserattrs)) {
                                    die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                                } else {
                                    die(Helper::Custom_Msg(Helper::Messages('icf') . ' ' . Helper::Messages('ps'), 2));
                                }
                            } else {
                                die(Helper::Custom_Msg(Helper::Messages('icf') . ' ' . Helper::Messages('ps'), 2));
                            }
                        } else {
                            //sharje mojadad
                            //peyda kardane akharin factor baraye in emkanat jahate mohasebe credit ghabele enteghal
                            $availblecredit = 0;
                            if ($prefactor) {
                                //finding bulk services in prefactor date range
                                $sql = "SELECT
                                            fa.id, fa.etebare_ghabele_enteghal, fa.etebare_baghimande,ser.terafik
                                        FROM
                                            bnm_factor fa
                                            INNER JOIN bnm_subscribers sub ON sub.id = fa.subscriber_id
                                            INNER JOIN bnm_services ser ON ser.id = fa.service_id
                                        WHERE
                                            fa.id NOT IN (?,?) AND fa.emkanat_id = ? AND fa.subscriber_id = ? AND fa.tasvie_shode = ?
                                            AND ser.type = ? AND ser.noe_forosh = ? AND fa.tarikhe_factor BETWEEN ? AND ?
                                        ORDER BY fa.tarikhe_factor DESC LIMIT 1";
                                $prebulk = Db::secure_fetchall($sql, [
                                    $res_factor[0]['id'],
                                    $prefactor[0]['id'],
                                    $res_factor[0]['emkanat_id'],
                                    $res_subscriber[0]['id'],
                                    1,
                                    $res_service[0]['type'],
                                    "bulk",
                                    $prefactor[0]['tarikhe_shoroe_service'],
                                    $prefactor[0]['tarikhe_payane_service'],
                                ]);
                                if ($prebulk) {
                                    $availblecredit = $prebulk[0]['etebare_ghabele_enteghal'];
                                } else {
                                    $availblecredit = 0;
                                }
                            } else {
                                $availblecredit = 0;
                            }
                            $user_id = $GLOBALS['ibs_internet']->getUserIdByNormalUsername($res_ibsusername[0]['ibs_username']);
                            if (Helper::ibsCheckResponse($user_id)) {
                                if ($res_factor[0]['noe_moshtarak'] === "real") {
                                    $res_setuserattrs = $GLOBALS['ibs_internet']->setUserAttributes(
                                        (string) $user_id[1],
                                        array(
                                            "name" => $res_subscriber[0]['name'] . ' ' . $res_subscriber[0]['f_name'],
                                            "comment" => $res_subscriber[0]['code_meli'],
                                            "phone" => (string) $res_ibsusername[0]['ibs_username'],
                                            "group_name" => (string) $res_service[0]['onvane_service'],
                                            "cell_phone" => $res_subscriber[0]['telephone_hamrah'],
                                            "postal_code" => $res_subscriber[0]['shahkar_status_code'],
                                            "email" => $res_subscriber[0]['shomare_shenasname'] . ',' . $res_factor[0]['city_name'],
                                            "address" => $res_service[0]['type'],
                                            "birthdate" => $res_subscriber[0]['tarikhe_tavalod'],
                                            "birthdate_unit" => 'gregorian',
                                            "abs_exp_date" => $res_factor[0]['tarikhe_payane_service'],
                                            "abs_exp_date_unit" => 'gregorian',
                                            "normal_user_spec" => array(
                                                "normal_username" => (string) $res_ibsusername[0]['ibs_username'],
                                                "normal_password" => (string) $res_subscriber[0]['code_meli'],
                                            ),
                                        )
                                    );
                                } else {
                                    $res_setuserattrs = $GLOBALS['ibs_internet']->setUserAttributes(
                                        (string) $user_id[1],
                                        array(
                                            "name" => $res_subscriber[0]['name_sherkat'],
                                            "comment" => $res_subscriber[0]['shenase_meli'],
                                            "phone" => (string) $res_ibsusername[0]['ibs_username'],
                                            "group_name" => (string) $res_service[0]['onvane_service'],
                                            "cell_phone" => $res_subscriber[0]['telephone_hamrah'],
                                            "postal_code" => $res_subscriber[0]['shahkar_status_code'],
                                            "email" => $res_subscriber[0]['shomare_sabt'] . ',' . $res_factor[0]['city_name'],
                                            "address" => $res_service[0]['type'],
                                            "birthdate" => $res_subscriber[0]['tarikhe_sabt'],
                                            "birthdate_unit" => 'gregorian',
                                            "abs_exp_date" => $res_factor[0]['tarikhe_payane_service'],
                                            "abs_exp_date_unit" => 'gregorian',
                                            "normal_user_spec" => array(
                                                "normal_username" => (string) $res_ibsusername[0]['ibs_username'],
                                                "normal_password" => (string) $res_subscriber[0]['shenase_meli'],
                                            ),
                                        )
                                    );
                                }
                                if (Helper::ibsCheckResponse($res_setuserattrs)) {
                                    $renew = $GLOBALS['ibs_internet']->renewUser((string) $user_id[1], (string) $availblecredit);
                                    $addtocredit = $GLOBALS['ibs_internet']->addToUserCredit((string) $user_id[1], (string) $availblecredit, (string) $availblecredit);
                                    die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                                } else {
                                    die(Helper::Custom_Msg(Helper::Messages('aof'), 3));
                                }
                            } else {
                                die(Helper::Custom_Msg(Helper::Messages('aof'), 3));
                            }
                        }
                    } elseif ($res_service[0]['noe_forosh'] === "bulk") {
                        $user_id = $GLOBALS['ibs_internet']->getUserIdByNormalUsername($res_ibsusername[0]['ibs_username']);
                        $addtocredit = $GLOBALS['ibs_internet']->addToUserCredit((string) $user_id[1], (string) $res_service[0]['terafik'], (string) $res_service[0]['terafik']);
                        die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                    } else {
                        die(Helper::Json_Message('f'));
                    }
                } else {
                    die(Helper::Json_Message('credit_operation_fail'));
                }
            } else {
                die(Helper::Json_Message('auth_fail'));
            }
        }

        if (isset($_GET['path'])) {
            if ($_GET['path'] == 'logout') {
                session_destroy();

                $controllerName = 'login';
                $controller = new $controllerName();
                $controller->index();
            }
            $tokens = explode('/', rtrim($_GET['path'], '/'));
            $controllerName = ucfirst(array_shift($tokens));
            $requested_page = strtolower($controllerName);
            if (file_exists('Controllers/' . $controllerName . '.php')) {
                $controller = new $controllerName();
                if (!empty($tokens)) {
                    $actionName = array_shift($tokens);
                    if (method_exists($controller, $actionName)) {
                        $controller->{$actionName}(@$tokens);
                    } else {
                        //nemidonam daghighan chikar mikone :D
                        //if action not found error page
                        $controllerName = 'Error404';
                        $controller = new $controllerName();
                        $controller->index();
                    }
                } else {
                    if (in_array($requested_page, $_SESSION['dashboard_menu_names'])) {
                        //todo... safhe index.php handle shavad
                        if (Helper::Login_Just_Check()) {
                            //check if request in $_SESSION['dashboard_menu_names'] AND IF user has access show page to user
                            //check user access
                            switch ($_SESSION['user_type']) {
                                case __ADMINUSERTYPE__:
                                    $controller = new $controllerName();
                                    $controller->index();
                                    break;
                                case __MODIRUSERTYPE__:
                                case __MODIR2USERTYPE__:
                                case __OPERATORUSERTYPE__:
                                case __OPERATOR2USERTYPE__:
                                    ///user admin nist pas dastresi ha bayad check shavad
                                    // var_dump(Helper::check_user_has_access_or_not($controllerName));
                                    // die();
                                    if (Helper::check_user_has_access_or_not($controllerName)) {

                                        $controller = new $controllerName();
                                        $controller->index();
                                    } else {
                                        if ($controllerName === 'dashboard' || $controllerName === 'Dashboard') {
                                            $controller = new $controllerName();
                                            $controller->index();
                                        } else {
                                            $controllerName = 'Error404';
                                            $controller = new $controllerName();
                                            $controller->index();
                                        }
                                    }
                                    break;
                                case __ADMINOPERATORUSERTYPE__:
                                    if (Helper::check_user_has_access_or_not($controllerName)) {
                                        $controller = new $controllerName();
                                        $controller->index();
                                    } else {
                                        if ($controllerName === 'dashboard' || $controllerName === 'Dashboard') {
                                            $controller = new $controllerName();
                                            $controller->index();
                                        } else {

                                            $controllerName = 'Error404';
                                            $controller = new $controllerName();
                                            $controller->index();
                                        }
                                    }
                                    break;
                                case __MOSHTARAKUSERTYPE__:
                                    if (Helper::check_user_has_access_or_not($controllerName)) {
                                        $controller = new $controllerName();
                                        $controller->index();
                                    } else {
                                        if ($controllerName === 'dashboard' || $controllerName === 'Dashboard') {
                                            $controller = new $controllerName();
                                            $controller->index();
                                        } else {
                                            $controllerName = 'Error404';
                                            $controller = new $controllerName();
                                            $controller->index();
                                        }
                                    }
                                    break;
                                default:
                                    $controllerName = 'Error404';
                                    $controller = new $controllerName();
                                    $controller->index();
                                    break;
                            }
                        } else {

                            ///user not login correctly
                            $controllerName = 'login';
                            $controller = new $controllerName();
                            $controller->index();
                        }
                    } else {
                        //request is not in dashboard panel(public website)
                        //todo... safhe index.php handle shavad
                        if ($requested_page == "login") {
                            if (isset($_SESSION['login']) && $_SESSION['login'] == "true") {
                                $controllerName = 'dashboard';
                                $controller = new $controllerName();
                                $controller->index();
                            } else {

                                $controller = new $controllerName();
                                $controller->index();
                            }
                        } else {
                            $controller = new $controllerName();
                            $controller->index();
                            //no access to page or page not exists then show page error404
                        }
                    }
                }
            } else {
                //echo ('444');
                ////if url exist but not found in controllers

                $controllerName = 'Error404';
                $controller = new $controllerName();
                $controller->index();
                //if controller not found render an error page
                $flag = true;
            }
        } else {
            //if no controller entred go to home page
            $controllerName = 'Home';
            $controller = new $controllerName();
            $controller->index();
        }
    }
}
