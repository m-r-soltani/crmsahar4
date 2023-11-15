<?php defined('__ROOT__') or exit('No direct script access allowed');

class Sms_Inbox extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

        if (isset($_POST['send_sms_inbox'])) {
            switch ($_SESSION['user_type']) {
                case __ADMINUSERTYPE__:
                case __ADMINOPERATORUSERTYPE__:
                    // parse_str($_POST[key($_POST)], $_POST);
                    // $_POST['aztarikh']          = Helper::convert_numbers($_POST['aztarikh'],false);
                    // $date_arr                   = array();
                    // $date_arr                   = explode("/", $_POST['aztarikh']);
                    // $_POST['aztarikh']          = Helper::jalali_to_gregorian($date_arr[0],$date_arr[1],$date_arr[2],'-');
                    // if($_POST['aztarikh']){
                    //     $result     = Helper::getSentMessagesByTime($_POST['aztarikh']);
                    //     if($result){
                    //         $result = Helper::smsMessagesDateChange($result);
                    //         die(json_encode($result));
                    //     }else{
                    //         die(Helper::Json_Message('f'));
                    //     }
                    // }else{
                    //     die(Helper::Json_Message('f'));
                    // }
                    break;

                default:
                    die(Helper::Alert_Message('na'));
                    break;
            }

        }
//        $this->view->allUsers = R::findAll( 'bnm_users' );
        //        $this->view->title = 'کاربران';
        $this->view->pagename = 'sms_inbox';
        $this->view->render('sms_inbox', 'dashboard_template', '/public/js/sms_inbox.js', false);

    }
}
