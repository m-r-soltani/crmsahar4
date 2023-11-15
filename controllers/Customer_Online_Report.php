<?php defined('__ROOT__') or exit('No direct script access allowed');
class Customer_Online_Report extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
       
        $this->view->pagename = 'customer_online_report';
        $this->view->render('customer_online_report', 'dashboard_template', '/public/js/customer_online_report.js', false);
    }
}
