<?php defined('__ROOT__') or exit('No direct script access allowed');
class Customer_Factors extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        

        $this->view->pagename = 'customer_factors';
        $this->view->render('customer_factors', 'dashboard_template', '/public/js/customer_factors.js', false);
    }
}
