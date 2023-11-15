<?php defined('__ROOT__') or exit('No direct script access allowed');
class Panel_Messages extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        /*========sabte shahr========*/
        if (isset($_POST['send_panel_messages'])) {
            try {
                unset($_POST['send_panel_messages']);
                // $_POST = Helper::xss_check_array($_POST);
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

        $this->view->pagename = 'panel_messages';
        $this->view->render('panel_messages', 'dashboard_template', '/public/js/panel_messages.js', false);
    }
}
