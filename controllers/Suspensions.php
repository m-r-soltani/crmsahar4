<?php defined('__ROOT__') or exit('No direct script access allowed');
class Suspensions extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        /*========sabte shahr========*/


        $this->view->pagename = 'suspensions';
        $this->view->render('suspensions', 'dashboard_template', '/public/js/suspensions.js', false);
    }
}
