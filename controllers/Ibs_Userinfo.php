<?php defined('__ROOT__') or exit('No direct script access allowed');
class Ibs_Userinfo extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        /*========sabte shahr========*/

        $this->view->pagename = 'ibs_userinfo';
        $this->view->render('ibs_userinfo', 'dashboard_template', '/public/js/ibs_userinfo.js', false);
    }
}
