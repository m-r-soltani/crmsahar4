<?php defined('__ROOT__') or exit('No direct script access allowed');

class Dashboard extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {

        ///send sms to 3 days expiring users
        // $ibs=$GLOBALS['ibs_internet']->getUsersAboutToExpire(3);
        // $arrids=[];
        // foreach ($ibs[1][2] as $k => $v) {
        //     $arrids[]=$v;
        // }
        // if($arrids){
        //     $usersibsinfo=Helper::ibsGetUserInfoByArrayId($arrids);
        //     $allusers=Helper::getAllInternetUsersServicesInfoNoAuth();
        //     $arr=[];
        //     foreach ($allusers as $k => $v) {
        //         foreach ($usersibsinfo as $kk => $vv) {
        //             if($v['ibsusername']===$vv['attrs']['normal_username']){
        //                 $v['ibsinfo']=$vv;
        //                 $arr[]=$v;
        //             }
        //         }
        //     }
        // }
        /////////////////////////////////single SMS////////////////////////////////////
        $sql_single_sms = "
        SELECT * FROM bnm_send_sms_requests bssr WHERE bssr.start_date >= CURDATE() AND bssr.end_date <= CURDATE()
        AND bssr.receiver_type =? AND bssr.receiver IS NOT NULL AND bssr.receiver <> ''";
        $res_single_sms = Db::secure_fetchall($sql_single_sms, array('1'));
        if ($res_single_sms) {
            if (is_array($res_single_sms) && count($res_single_sms) > 0) {
                for ($i = 0; $i < count($res_single_sms); $i++) {
                    if ($res_single_sms[$i]['start_date'] === $res_single_sms[$i]['end_date']) {
                        $sql_check_queue = "SELECT * FROM bnm_sms_queue WHERE request_id = ? AND status_code IS NOT NULL";
                        $res_check_queue = Db::secure_fetchall($sql_check_queue,array($res_single_sms[$i]['id']));
                        if (!$res_check_queue) {
                            switch ($res_single_sms[$i]['receiver_type']) {
                                case '1':
                                    ///normal message
                                    $res = Helper::Select_By_Id('bnm_messages', $res_single_sms[$i]['message_id']);
                                    if ($res) {
                                        $result                       = Helper::Send_Sms_Single($res_single_sms[$i]['receiver'], $res[0]['message'], null);
                                        $arr_result                   = array();
                                        $arr_result['request_id']     = $res_single_sms[$i]['id'];
                                        $arr_result['status_code']    = $result['status'];
                                        $arr_result['status_message'] = $result['status_message'];
                                        $arr_result['receiver']       = $res_single_sms[$i]['receiver'];
                                        $arr_result['sender']         = __SMSNUMBER__;
                                        $sql                          = Helper::Insert_Generator($arr_result, 'bnm_sms_queue');
                                        $result_single_sms            = Db::secure_insert_array($sql, $arr_result);
                                    }
                                break;
                                
                                default:
                                    $res = false;
                                break;
                                
                            }
                        }
                    }
                }
            }
        }
        /////////////////////////////////single SMS////////////////////////////////////
        /////////////////////////////////group SMS////////////////////////////////////
        $sql = "
        SELECT * FROM bnm_send_sms_requests bssr WHERE bssr.start_date <= CURDATE() AND bssr.end_date >= CURDATE()
        AND bssr.receiver_type =? AND bssr.receiver IS NOT NULL AND bssr.receiver <> ''";
        $groupsms = Db::secure_fetchall($sql, array('2'));
        if($groupsms){
            if (is_array($groupsms) && count($groupsms) > 0) {
                for ($i=0; $i <count($groupsms) ; $i++) { 
                    $sql = "SELECT * FROM bnm_sms_queue WHERE request_id = ? AND status_code IS NOT NULL";
                    $checksms = Db::secure_fetchall($sql,array($groupsms[$i]['id']));
                    if (!$checksms) {
                        switch ($groupsms[$i]['receiver_type']) {
                            case '2':
                                $sql="SELECT r.id,r.receiver,r.message_id,r.start_date,r.end_date,
                                r.receiver_type,b.file_id,m.message,f.file_path,f.file_name
                                FROM bnm_send_sms_requests r
                                INNER JOIN bnm_banks b       ON r.receiver = b.id
                                INNER JOIN bnm_messages m    ON m.id = r.message_id
                                INNER JOIN bnm_upload_file f ON f.id=b.file_id
                                WHERE r.receiver_type = ? AND r.id = ?";
                                $res= Db::secure_fetchall($sql,array('2',$groupsms[$i]['id']));
                                if($res){
                                    $res_read                     = Helper::readExcelFirstLine($res[0]['file_path'].$res[0]['file_name']);
                                    $res_read                     = Helper::addZeroToNumber($res_read);
                                    $sms_result                   = Helper::multiSend($res_read, $res[0]['message'], strtotime(date('Y-m-d')));
                                    $arr_result                   = array();
                                    $arr_result['request_id']     = $res[0]['id'];
                                    $arr_result['status_code']    = $sms_result['status'];
                                    $arr_result['status_message'] = $sms_result['status_message'];
                                    $arr_result['receiver']       = $res[0]['receiver'];
                                    $arr_result['sender']         = __SMSNUMBER__;
                                    $sql                          = Helper::Insert_Generator($arr_result, 'bnm_sms_queue');
                                    $result_group_sms             = Db::secure_insert_array($sql, $arr_result);
                                }
                            break;
                        }
                    }
                }
            }
        }
        /////////////////////////////////group SMS////////////////////////////////////

        //check each number sms not already sent
        // if($single_sms_arr && count($single_sms_arr)>0){
        //     $sql="SELECT * FROM bnm_messages WHERE id = ?";
        //     $res_msg=Db::secure_fetchall($sql,array($res_single_sms));
        // }
        if (isset($_POST['dashboard'])) {
            if (Helper::Login_Just_Check()) {
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                    case __MODIRUSERTYPE__:
                    case __OPERATORUSERTYPE__:
                    case __MODIR2USERTYPE__:
                    case __OPERATOR2USERTYPE__:

                        if (isset($_POST['request2']) && $_POST['request2'] == 'internet') {
                            if (isset($_POST['request1'])) {
                                switch ($_POST['request1']) {
                                    case 'online_users':
                                        if ($_SESSION['user_type'] == '1') {
                                            $onlines = $GLOBALS['ibs_internet']->findOnlineUsers(true);
                                            $res = Helper::ibsGetOnlineUserInfoByArrayId($onlines);
                                            // $j=0;
                                            // for($i=0;$i<count($res);$i++){
                                            //     if(isset($res[$i]['attrs']['pppoe_service'])){
                                            //         $j++;       
                                            //     }
                                            // }
                                            die(json_encode(count($res)));
                                        }
                                        break;
                                    case 'expired_users':
                                        if ($_SESSION['user_type'] == '1') {
                                            $res = $GLOBALS['ibs_internet']->searchUserRelExpDateTo(date('Y-m-d'));

                                            // die(json_encode($res));
                                            die(json_encode(array(count($res))));
                                        }
                                        break;
                                    case 'seven_days_expired':
                                        if ($_SESSION['user_type'] == '1') {
                                            $res = $GLOBALS['ibs_internet']->getSevenDaysExpiredUsers();
                                            die(json_encode(array(count($res))));
                                        }
                                        break;
                                }
                            }
                        } elseif ($_POST['request2'] == 'voip') {
                            if (isset($_POST['request1'])) {
                                switch ($_POST['request1']) {
                                    case 'online_users':
                                        if ($_SESSION['user_type'] == '1') {
                                            $res = $GLOBALS['ibs_voip']->getAllVoipOnlineUsers();
                                            die(json_encode($res));
                                        }
                                        break;
                                    case 'expired_users':
                                        if ($_SESSION['user_type'] == '1') {
                                            $res = $GLOBALS['ibs_voip']->searchUserRelExpDateTo(date('Y-m-d'));

                                            die(json_encode(array(count($res))));
                                        }
                                        break;
                                    case 'seven_days_expired':
                                        if ($_SESSION['user_type'] == '1') {
                                            $res = $GLOBALS['ibs_voip']->getSevenDaysExpiredUsers();
                                            die(json_encode(array(count($res))));
                                        }
                                        break;
                                }
                            }
                        } elseif ($_POST['request2'] == 'subscriber_request') {
                            die(json_decode(array('1')));
                        }
                        die(json_encode(array()));
                        break;
                    case __MOSHTARAKUSERTYPE__:
                        if (isset($_POST['request1'])) {
                            $sql = "SELECT * FROM bnm_subscribers WHERE id = ?";
                            $res = Db::secure_fetchall($sql, array($_SESSION['user_id']));
                            if ($res) {
                                die(json_encode($res));
                            } else {
                                die(Helper::Json_Message('f'));
                            }
                        } else {
                            die(Helper::Json_Message('f'));
                        }
                        die(json_encode(array()));
                        break;
                    default:
                        die(Helper::Json_Message('af'));
                        break;
                }

            }
        }

        //$this->view->render('dashboard/view','dashboard/dashboard_sidemenu');
        $this->view->home = 'داشبورد';
        //$this->view->page='داشبورد';
        $this->view->pagename = 'dashboard';
//        $this->view->render('dashboard','dashboard_template','/public/js/demo_pages/dashboard.js',false);
        $this->view->render('dashboard', 'dashboard_template', '/public/js/dashboard.js', false);
    }
}
