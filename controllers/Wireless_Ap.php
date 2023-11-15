<?php defined('__ROOT__') or exit('No direct script access allowed');

class Wireless_Ap extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if (isset($_POST['send_wireless_ap'])) {
            parse_str($_POST[key($_POST)], $_POST);
            // $_POST = Helper::xss_check_array($_POST);
            if (Helper::Login_Just_Check()) {
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                    case __MODIRUSERTYPE__:
                    case __OPERATORUSERTYPE__:
                    case __MODIR2USERTYPE__:
                    case __OPERATOR2USERTYPE__:
                        if (isset($_POST['tarikhe_sabt'])) {
                            $date_arr = array();
                            $date_arr = explode("/", $_POST['tarikhe_sabt']);

                            if (count($date_arr) > 2) {
                                $year = (int) Helper::convert_numbers($date_arr[0], false);
                                $month = (int) Helper::convert_numbers($date_arr[1], false);
                                $day = (int) Helper::convert_numbers($date_arr[2], false);
                                $_POST['tarikhe_sabt'] = Helper::jalali_to_gregorian($year, $month, $day, '/');
                            }
                        }
                        if (isset($_POST['tarikhe_payan'])) {
                            $date_arr = array();

                            $date_arr = explode("/", $_POST['tarikhe_payan']);

                            if (count($date_arr) > 2) {
                                $year = (int) Helper::convert_numbers($date_arr[0], false);
                                $month = (int) Helper::convert_numbers($date_arr[1], false);
                                $day = (int) Helper::convert_numbers($date_arr[2], false);
                                $_POST['tarikhe_payan'] = Helper::jalali_to_gregorian($year, $month, $day, '/');
                            }
                        }
                        if ($_POST['id'] == "empty") {
                            if (Helper::check_add_access('wireless_ap')) {
                                unset($_POST['id']);
                                $_POST['branch_id'] = $_SESSION['branch_id'];
                                $sql = Helper::Insert_Generator($_POST, 'bnm_wireless_ap');
                                $res = Db::secure_insert_array($sql, $_POST);
                                if ($res) {
                                    die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                                } else {
                                    die(Helper::Custom_Msg(Helper::Messages('f'), 2));
                                }
                            }else{
                                die(Helper::Custom_Msg(Helper::Messages('na'), 3));
                            }
                        } else {
                            if (Helper::check_update_access('wireless_ap')) {
                                $sql = Helper::Update_Generator($_POST, 'bnm_wireless_ap', "WHERE id = :id");
                                $res = Db::secure_update_array($sql, $_POST);
                                
                                if ($res) {
                                    die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                                } else {
                                    die(Helper::Custom_Msg(Helper::Messages('f'), 2));
                                }
                            } else {
                                die(Helper::Custom_Msg(Helper::Messages('na'), 3));
                            }

                        }
                        break;

                    default:
                        die(Helper::Custom_Msg(Helper::Messages('na'), 3));
                    break;
                }
            } else {
                die(Helper::Custom_Msg(Helper::Messages('fa'), 3));
            }

        }
//        $this->view->allUsers = R::findAll( 'bnm_users' );
        //        $this->view->title = 'کاربران';
        $this->view->pagename = 'wireless_ap';
        $this->view->render('wireless_ap', 'dashboard_template', '/public/js/wireless_ap.js', false);

    }
}
