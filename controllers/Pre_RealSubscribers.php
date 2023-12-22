<?php defined('__ROOT__') or exit('No direct script access allowed');
class Pre_RealSubscribers extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {   
        $this->view->pagename = 'pre_realsubscribers';
        $this->view->render('pre_realsubscribers', 'blankdashboard', '/public/js/pre_realsubscribers.js', false);
    }
}
