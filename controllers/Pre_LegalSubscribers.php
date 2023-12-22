<?php defined('__ROOT__') or exit('No direct script access allowed');
class Pre_LegalSubscribers extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {   
        $this->view->pagename = 'pre_legalsubscribers';
        $this->view->render('pre_legalsubscribers', 'blankdashboard', '/public/js/pre_legalsubscribers.js', false);
    }
}
