<?php defined('__ROOT__') or exit('No direct script access allowed');
class Connection_Log_postfix extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        /*========sabte shahr========*/
        if (isset($_POST['send_connection_log_postfix'])) {
            unset($_POST['send_connection_log_postfix']);
            if (Helper::Login_Just_Check()) {
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                        $_POST = Helper::xss_check_array($_POST);
                        if ($_POST['id'] == "empty") {
                            if(Helper::check_add_access('Connection_Log_postfix')){
                            unset($_POST['id']);
                            $sql = Helper::Insert_Generator($_POST, 'bnm_connection_log');
                            Db::secure_insert_array($sql, $_POST);
                            } else echo Helper::Alert_Message('na');
                        } else {
                            if(Helper::check_update_access('connection_log_postfix')){
                            $sql = Helper::Update_Generator($_POST, 'bnm_connection_log', "WHERE id = :id");
                            Db::secure_update_array($sql, $_POST);
                            } else echo Helper::Alert_Message('na');
                        }
                        break;
                    default:
                        echo Helper::Alert_Message('na');
                        break;
                }
            }
        }

        $this->view->pagename = 'connection_log_postfix';
        $this->view->render('connection_log_postfix', 'dashboard_template', '/public/js/connection_log_postfix.js', false);
    }
}
