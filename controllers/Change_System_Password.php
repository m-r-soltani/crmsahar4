<?php defined('__ROOT__') or exit('No direct script access allowed');
class Change_System_Password extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        /*========sabte shahr========*/

        $this->view->pagename = 'change_system_password';
        $this->view->render('change_system_password', 'dashboard_template', '/public/js/change_system_password.js', false);
    }
}
