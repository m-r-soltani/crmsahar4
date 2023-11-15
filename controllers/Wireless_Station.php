<?php defined('__ROOT__') or exit('No direct script access allowed');

class Wireless_Station extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if (isset($_POST['send_wireless_station'])) {
            parse_str($_POST[key($_POST)], $_POST);
            if (Helper::Login_Just_Check()) {
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                        if (isset($_POST['tarikhe_sabt'])) {
                            $date_arr = array();
                            $date_arr = explode("/", $_POST['tarikhe_sabt']);
                            if (count($date_arr) > 2) {
                                $year                  = (int) Helper::convert_numbers($date_arr[0], false);
                                $month                 = (int) Helper::convert_numbers($date_arr[1], false);
                                $day                   = (int) Helper::convert_numbers($date_arr[2], false);
                                $_POST['tarikhe_sabt'] = Helper::jalali_to_gregorian($year, $month, $day, '/');
                            }
                        }

                        if (isset($_POST['tarikhe_payan'])) {
                            $date_arr = array();

                            $date_arr = explode("/", $_POST['tarikhe_payan']);

                            if (count($date_arr) > 2) {
                                $year                   = (int) Helper::convert_numbers($date_arr[0], false);
                                $month                  = (int) Helper::convert_numbers($date_arr[1], false);
                                $day                    = (int) Helper::convert_numbers($date_arr[2], false);
                                $_POST['tarikhe_payan'] = Helper::jalali_to_gregorian($year, $month, $day, '/');
                            }
                        }
                        if ($_POST['id'] === "empty") {
                            if(Helper::check_add_access('wireless_station')){
                                unset($_POST['id']);
                                unset($_POST['subscriber_id']);
                                $sql = Helper::Insert_Generator($_POST, 'bnm_wireless_station');
                                $res = Db::secure_insert_array($sql, $_POST);
                                if($res){
                                    die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                                }else{
                                    die(Helper::Custom_Msg(Helper::Messages('f'), 2));
                                }
                            } else die(Helper::Custom_Msg(Helper::Messages('f'), 2));
                        } else {
                            if(Helper::check_update_access('wireless_station')){
                                if($_POST['subscriber_id']==''){
                                    $_POST['subscriber_id']=NULL;
                                }else{
                                    unset($_POST['subscriber_id']);
                                }
                                $sql = Helper::Update_Generator($_POST, 'bnm_wireless_station', "WHERE id = :id");
                                $res = Db::secure_update_array($sql, $_POST);
                                if($res){
                                    die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                                }else{
                                    die(Helper::Custom_Msg(Helper::Messages('f'), 2));
                                }
                            } else die(Helper::Custom_Msg(Helper::Messages('f'), 2));
                        }
                        break;
                    case __MODIRUSERTYPE__:
                    case __OPERATORUSERTYPE__:
                    case __MODIR2USERTYPE__:
                    case __OPERATOR2USERTYPE__:
                        unset($_POST['send_wireless_station']);
                        if (isset($_POST['tarikhe_sabt'])) {
                            $date_arr = array();
                            $date_arr = explode("/", $_POST['tarikhe_sabt']);
                            if (count($date_arr) > 2) {
                                $year                  = (int) Helper::convert_numbers($date_arr[0], false);
                                $month                 = (int) Helper::convert_numbers($date_arr[1], false);
                                $day                   = (int) Helper::convert_numbers($date_arr[2], false);
                                $_POST['tarikhe_sabt'] = Helper::jalali_to_gregorian($year, $month, $day, '/');
                            }
                        }
                        if (isset($_POST['tarikhe_payan'])) {
                            $date_arr = array();

                            $date_arr = explode("/", $_POST['tarikhe_payan']);

                            if (count($date_arr) > 2) {
                                $year                   = (int) Helper::convert_numbers($date_arr[0], false);
                                $month                  = (int) Helper::convert_numbers($date_arr[1], false);
                                $day                    = (int) Helper::convert_numbers($date_arr[2], false);
                                $_POST['tarikhe_payan'] = Helper::jalali_to_gregorian($year, $month, $day, '/');
                            }
                        }
                        if ($_POST['id'] === "empty") {
                            if(Helper::check_add_access('wireless_station')){
                                unset($_POST['id']);
                                $sql = Helper::Insert_Generator($_POST, 'bnm_wireless_station');
                                $res = Db::secure_insert_array($sql, $_POST);
                                if($res){
                                    die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                                }else{
                                    die(Helper::Custom_Msg(Helper::Messages('f'), 2));
                                }
                            } else die(Helper::Custom_Msg(Helper::Messages('f'), 2));
                        } else {
                            if(Helper::check_update_access('wireless_station')){
                                if($_POST['subscriber_id']==''){
                                    $_POST['subscriber_id']=NULL;
                                }else{
                                    unset($_POST['subscriber_id']);
                                }
                                $sql = Helper::Update_Generator($_POST, 'bnm_wireless_station', "WHERE id = :id");
                                $res = Db::secure_update_array($sql, $_POST);
                                if($res){
                                    die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                                }else{
                                    die(Helper::Custom_Msg(Helper::Messages('f'), 2));
                                }
                            } else die(Helper::Custom_Msg(Helper::Messages('f'), 2));
                        }
                        break;

                    default:
                    die(Helper::Custom_Msg(Helper::Messages('na'), 3));
                        break;
                }
            }else die(Helper::Custom_Msg(Helper::Messages('af'), 3));
        }
//        $this->view->allUsers = R::findAll( 'bnm_users' );
        //        $this->view->title = 'کاربران';
        $this->view->pagename = 'wireless_station';
        $this->view->render('wireless_station', 'dashboard_template', '/public/js/wireless_station.js', false);

    }
}
