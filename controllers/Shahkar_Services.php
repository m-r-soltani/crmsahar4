<?php defined('__ROOT__') or exit('No direct script access allowed');
class Shahkar_Services extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        

        $this->view->pagename = 'shahkar_services';
        $this->view->render('shahkar_services', 'dashboard_template', '/public/js/shahkar_services.js', false);
    }
}
