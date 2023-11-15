<?php defined('__ROOT__') or exit('No direct script access allowed');
class Shahkar_Config extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if(isset($_POST['send_shahkar_config'])){
            die('این صفحه هنوز تکمیل نشده برو ببین برنامه نویست داره چه گهی میخوره!');
        }
        $this->view->pagename = 'shahkar_config';
        $this->view->render('shahkar_config', 'dashboard_template', '/public/js/shahkar_config.js', false);
    }
}
