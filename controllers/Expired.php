<?php defined('__ROOT__') or exit('No direct script access allowed');
class Expired extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {   
        $this->view->pagename = 'expired';
        $this->view->render('expired', 'dashboard_template', '/public/js/expired.js', false);
    }
}
