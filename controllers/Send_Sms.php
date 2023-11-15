<?php defined('__ROOT__') or exit('No direct script access allowed');
class Send_Sms extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        /*========sabte shahr========*/
        if (isset($_POST['send_sms_form'])) {
            
            unset($_POST['send_sms_form']);
            $_POST = Helper::xss_check_array($_POST);

            try {
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                        if (Helper::Is_Empty_OR_Null($_POST['start_date']) && Helper::Is_Empty_OR_Null($_POST['end_date'])) {
                            $_POST['start_date'] = Helper::Fix_Date_Seperator($_POST['start_date']);
                            $_POST['end_date']   = Helper::Fix_Date_Seperator($_POST['end_date']);
                            $date_arr            = array();
                            $date_arr            = explode("/", $_POST['start_date']);
                            if (count($date_arr) > 2) {
                                $year                = (int) Helper::convert_numbers($date_arr[0], false);
                                $month               = (int) Helper::convert_numbers($date_arr[1], false);
                                $day                 = (int) Helper::convert_numbers($date_arr[2], false);
                                $_POST['start_date'] = Helper::jalali_to_gregorian($year, $month, $day, '/');
                            } else {
                                $_POST['start_date'] = false;
                            }
                            $date_arr = array();
                            $date_arr = explode("/", $_POST['end_date']);
                            if (count($date_arr) > 2) {
                                $year              = (int) Helper::convert_numbers($date_arr[0], false);
                                $month             = (int) Helper::convert_numbers($date_arr[1], false);
                                $day               = (int) Helper::convert_numbers($date_arr[2], false);
                                $_POST['end_date'] = Helper::jalali_to_gregorian($year, $month, $day, '/');
                            } else {
                                $_POST['end_date'] = false;
                            }
                            if ($_POST['start_date'] && $_POST['end_date'] && (isset($_POST['single_phone_number']) || isset($_POST['bank_id']))) {
                                switch ($_POST['send_to']) {
                                    case '1':
                                        if($_POST['start_date'] === $_POST['end_date']){
                                            $arr                  = array();
                                            $arr['receiver']      = $_POST['single_phone_number'];
                                            $arr['start_date']    = $_POST['start_date'];
                                            $arr['end_date']      = $_POST['end_date'];
                                            $arr['receiver_type'] = 1;
                                            $arr['message_id']    = $_POST['single_message'];
                                            $sql                  = Helper::Insert_Generator($arr, 'bnm_send_sms_requests');
                                            $res = Db::secure_insert_array($sql, $arr);
                                            if ($res) {
                                                echo Helper::Alert_Message('s');
                                            } else {
                                                echo Helper::Alert_Message('t3');
                                            }
                                        }else echo Helper::Alert_Message('در پیام های نظریر تاریخ شروع و پایان باید برابر باشند.');
                                    break;
                                    case '3':
                                        if($_POST['start_date'] === $_POST['end_date']){
                                            $_POST['message']  = trim($_POST['message']," ");
                                            $sql               = Helper::Insert_Generator(array('message' => $_POST['message'],'type'=> 2),'bnm_messages');
                                            $res_msg           = Db::secure_insert_array($sql, array('message' => $_POST['message'],'type'=> 2));
                                            if($res_msg){
                                                $arr                    = array();
                                                $arr['receiver']        = $_POST['single_phone_number'];
                                                $arr['start_date']      = $_POST['start_date'];
                                                $arr['end_date']        = $_POST['end_date'];
                                                $arr['receiver_type']   = 1;
                                                $arr['message_id']      = $res_msg;
                                                $sql                    = Helper::Insert_Generator($arr, 'bnm_send_sms_requests');
                                                $res                    = Db::secure_insert_array($sql, $arr);
                                                
                                                if ($res) {
                                                    echo Helper::Alert_Message('s');
                                                } else {
                                                    echo Helper::Alert_Message('f');
                                                }
                                            }else{
                                                echo Helper::Alert_Message('f');
                                            }
                                        }else echo Helper::Alert_Message('در پیام های نظریر تاریخ شروع و پایان باید برابر باشند.');
                                    break;
                                    case '2':
                                        // $reader     = new Excel();
                                        // $reader     = $reader::load(__DIRECTORY__.'\\uploads\\private\\privatesmsbank1.xlsx');
                                        // $arr        = array();
                                        // foreach ($reader as $row) {
                                        //     array_push($arr,$row[0]);
                                        // }
                                        // $res_excel  = Helper::readExcelFirstLine($_POST['bank_id']);
                                        // print_r($res_excel);
                                        // die();
                                        ////////////////////////////
                                        $arr = false;
                                        $arr['start_date']      = $_POST['start_date'];
                                        $arr['end_date']        = $_POST['end_date'];
                                        $arr['receiver']        = $_POST['bank_id'];
                                        $arr['receiver_type']   = 2;
                                        $arr['message_id']      = $_POST['message_id'];
                                        $sql                    = Helper::Insert_Generator($arr, 'bnm_send_sms_requests');
                                        $res                    = Db::secure_insert_array($sql, $arr);
                                        if ($res) {
                                            echo Helper::Alert_Message('s');
                                        } else {
                                            echo Helper::Alert_Message('f');
                                        }
                                    break;
                                    default:
                                        echo Helper::Alert_Message('t2');
                                        break;
                                }
                            } else {
                                echo Helper::Alert_Message('t1');
                            }

                        } else {
                            echo Helper::Alert_Message('t');
                        }

                        break;

                    default:
                        echo Helper::Alert_Message('af');
                        die();
                        break;
                }

                // if ($_POST['id'] == "empty") {
                //     unset($_POST['id']);
                //     $sql = Helper::Insert_Generator($_POST, 'bnm_shahr');
                //     Db::secure_insert_array($sql, $_POST);
                // } else {
                //     $sql = Helper::Update_Generator($_POST, 'bnm_shahr', "WHERE id = :id");
                //     Db::secure_update_array($sql, $_POST);
                // }
            } catch (Throwable $e) {
                $res = Helper::Exc_Error_Debug($e, true, '', true);
                die();
            }
        }

        $this->view->pagename = 'send_sms';
        $this->view->render('send_sms', 'dashboard_template', '/public/js/send_sms.js', false);
    }
}
