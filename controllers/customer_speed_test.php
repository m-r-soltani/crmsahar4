<?php defined('__ROOT__') or exit('No direct script access allowed');
class Customer_Speed_Test extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if(isset($_POST['send_customer_speedtest'])){
            $_POST          = Helper::reformAjaxRequest($_POST);
            // die(json_encode($_POST));
            switch ($_SESSION['user_type']) {
                case __MOSHTARAKUSERTYPE__:
                    $_POST['ip']    = $_SERVER['REMOTE_ADDR'];
                    $res            = $GLOBALS['ibs_internet']->getAllInternetOnlineUsers();
                    $res            = Helper::ibsOnlineuserFilterInitialize($res);
                    $username       = Helper::findIbsUsernameByIp($res, $_POST['ip']);
                    if($username){
                        $_POST['username']  = $username;
                        $_POST['userid']    = $_SESSION['id'];
                        $_POST['subid']     = $_SESSION['user_id'];
                        $date               = Helper::Today_Miladi_Date();
                        $time               = Helper::nowTimeTehran(':',true);
                        $_POST['tarikh']    = $date.' '.$time;
                        $sql                = Helper::Insert_Generator($_POST, 'bnm_customer_speedtest');
                        $res                = Db::secure_insert_array($sql,$_POST);
                        if($res){
                            die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                        }
                    }else{
                        die(Helper::Custom_Msg(Helper::Messages('ipnip'),2));
                    }
                    die(json_encode($res));
                    break;
                
                default:
                    die(Helper::Custom_Msg(Helper::Messages('f'),2));
                    break;
            }
            
        }

        $this->view->pagename = 'customer_speed_test';
        $this->view->render('customer_speed_test', 'dashboard_template');
    }
}
