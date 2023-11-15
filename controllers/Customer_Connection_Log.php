<?php defined('__ROOT__') or exit('No direct script access allowed');
class Customer_Connection_Log extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
                    
        $this->view->pagename = 'customer_connection_log';
        $this->view->render('customer_connection_log', 'dashboard_template', '/public/js/customer_connection_log.js', false);
    }
}
