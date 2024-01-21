<?php defined('__ROOT__') or exit('No direct script access allowed');
class Active_Services extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->view->pagename = 'active_services';
        $this->view->render('active_services', 'dashboard_template', '/public/js/active_services.js', false);
    }
}