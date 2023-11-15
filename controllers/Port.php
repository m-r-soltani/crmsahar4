<?php defined('__ROOT__') or exit('No direct script access allowed');

class Port extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if (isset($_POST['send_port'])) {
            unset($_POST['send_port']);
            $_POST = Helper::xss_check_array($_POST);
            if (!$_POST['id'] != "empty") {
                if(Helper::check_update_access('port')){
                    $sql = Helper::Update_Generator($_POST, 'bnm_port', "WHERE id = :id");
                    $res = Db::secure_update_array($sql, $_POST);
                }else echo Helper::Alert_Message('na');
            }
        }
//        $this->view->allUsers = R::findAll( 'bnm_users' );
        //        $this->view->title = 'کاربران';
        $this->view->home     = 'داشبورد';
        $this->view->page     = 'پورت';
        $this->view->page_url = 'port';
        $this->view->pagename = 'port';
        $this->view->render('port', 'dashboard_template', '/public/js/port.js', false);

    }
}
