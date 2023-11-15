<?php defined('__ROOT__') or exit('No direct script access allowed');
class Customer_Credit_Log extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        /*========sabte shahr========*/
        $this->view->pagename = 'customer_credit_log';
        $this->view->render('customer_credit_log', 'dashboard_template', '/public/js/customer_credit_log.js', false);
    }
}
