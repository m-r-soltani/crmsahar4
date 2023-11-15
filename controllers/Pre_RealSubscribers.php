<?php defined('__ROOT__') or exit('No direct script access allowed');

class Pre_Realsubscribers extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        /*========pre real_subscribers ========*/

        $this->view->pagename = 'pre_realsubscribers';
        $this->view->render('pre_realsubscribers', 'dashboard_template', '/public/js/pre_realsubscribers.js', false);

    }
}
