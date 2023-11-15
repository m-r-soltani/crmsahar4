<?php defined('__ROOT__') or exit('No direct script access allowed');
class Administration_Connection_Log extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
                    
        $this->view->pagename = 'administration_connection_log';
        $this->view->render('administration_connection_log', 'dashboard_template', '/public/js/administration_connection_log.js', false);
    }
}
