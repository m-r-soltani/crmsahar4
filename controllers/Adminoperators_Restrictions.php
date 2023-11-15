<?php defined('__ROOT__') or exit('No direct script access allowed');
class Adminoperators_Restrictions extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }


    public function index()
    {
        // __ADMINOPERATORUSERTYPE__
        $this->view->pagename = 'adminoperators_restrictions';
        $this->view->render('adminoperators_restrictions', 'dashboard_template', '/public/js/adminoperators_restrictions.js', false);
    }
}
