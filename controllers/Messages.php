<?php defined('__ROOT__') or exit('No direct script access allowed');
class Messages extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        /*========sabte shahr========*/
        if (isset($_POST['send_messages'])) {
            switch ($_SESSION['user_type']) {
                case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                    try {
                        unset($_POST['send_messages']);
                        $_POST = Helper::xss_check_array($_POST);
                        if ($_POST['id'] == "empty") {
                            if(Helper::check_add_access('messages')){
                                unset($_POST['id']);
                                $_POST['type'] = 1;
                                $sql = Helper::Insert_Generator($_POST, 'bnm_messages');
                                Db::secure_insert_array($sql, $_POST);
                            } else echo Helper::Alert_Message('na');
                        } else {
                            if(Helper::check_update_access('Messages')){
                                $_POST['type'] = 1;
                                $sql = Helper::Update_Generator($_POST, 'bnm_messages', "WHERE id = :id");
                                Db::secure_update_array($sql, $_POST);
                            } else echo Helper::Alert_Message('na');
                        }
                    } catch (Throwable $e) {
                        $res = Helper::Exc_Error_Debug($e, true, '', true);
                        die();
                    }
                    break;
                
                default:
                    echo Helper::Alert_Message('af');
                    break;
            }
        }

        $this->view->pagename = 'messages';
        $this->view->render('messages', 'dashboard_template', '/public/js/messages.js', false);
    }
}
