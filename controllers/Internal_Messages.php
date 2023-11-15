<?php defined('__ROOT__') or exit('No direct script access allowed');
class Internal_messages extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        /*========sabte shahr========*/
        if (isset($_POST['send_internal_messages'])) {
            unset($_POST['send_internal_messages']);
            $_POST = Helper::xss_check_array($_POST);
            switch ($_SESSION['user_type']) {
                case __ADMINUSERTYPE__:
                case __ADMINOPERATORUSERTYPE__:
                    if ($_POST['id'] === "empty") {
                        if(Helper::check_add_access('Internal_messages')){
                        unset($_POST['id']);
                        $sql = Helper::Insert_Generator($_POST, 'bnm_internal_messages');
                        $res = Db::secure_insert_array($sql, $_POST);
                        } else echo Helper::Alert_Message('na');
                    } else {
                        if(Helper::check_update_access('Internal_messages')){
                        $sql = Helper::Update_Generator($_POST, 'bnm_internal_messages', "WHERE id = :id");
                        $res = Db::secure_update_array($sql, $_POST);
                        } else echo Helper::Alert_Message('na');
                    }
                    break;
                default:
                    echo Helper::Alert_Message('af');
                    break;
            }
        }

        $this->view->pagename = 'internal_messages';
        $this->view->render('internal_messages', 'dashboard_template', '/public/js/internal_messages.js', false);
    }
}
