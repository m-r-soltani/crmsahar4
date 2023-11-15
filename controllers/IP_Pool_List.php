<?php defined('__ROOT__') or exit('No direct script access allowed');
class IP_Pool_List extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        /*========sabte shahr========*/
        if (isset($_POST['send_ip_pool_list'])) {
            parse_str($_POST[key($_POST)], $_POST);
            $_POST = Helper::xss_check_array($_POST);
            if (Helper::Login_Just_Check()) {
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                        try {
                            unset($_POST['send_ip_pool_list']);
                            $_POST = Helper::xss_check_array($_POST);
                            if ($_POST['id'] == "empty") {
                                unset($_POST['id']);
                                if (Helper::check_add_access('ip_pool_list')) {
                                    $sql = Helper::Insert_Generator($_POST, 'bnm_ip_pool_list');
                                    $res = Db::secure_insert_array($sql, $_POST);
                                    if ($res) {
                                        die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                                    } else {
                                        die(Helper::Custom_Msg(Helper::Messages('f'), 3));
                                    }
                                } else {
                                    die(Helper::Json_Message('na'));
                                }
                            } else {
                                if (Helper::check_update_access('ip_pool_list')) {
                                    $sql = Helper::Update_Generator($_POST, 'ip_pool_list', "WHERE id = :id");
                                    $res = Db::secure_update_array($sql, $_POST);
                                    if ($res) {
                                        die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                                    } else {
                                        die(Helper::Custom_Msg(Helper::Messages('f'), 3));
                                    }
                                } else {
                                    die(Helper::Json_Message('na'));
                                }
                            }
                        } catch (Throwable $e) {
                            $res = Helper::Exc_Error_Debug($e, true, '', true);
                            die();
                        }
                        break;

                    default:
                        die(Helper::Json_Message('na'));
                        break;
                }
            }
        }

        $this->view->pagename = 'ip_pool_list';
        $this->view->render('ip_pool_list', 'dashboard_template', '/public/js/ip_pool_list.js', false);
    }
}
