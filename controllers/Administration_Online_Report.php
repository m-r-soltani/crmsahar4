<?php defined('__ROOT__') or exit('No direct script access allowed');
class Administration_Online_Report extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
       
        $this->view->pagename = 'administration_online_report';
        $this->view->render('administration_online_report', 'dashboard_template', '/public/js/administration_online_report.js', false);
    }
}
