<?php defined('__ROOT__') or exit('No direct script access allowed');

class Personal_Information extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        /*========personal_information========*/
        
        $this->view->pagename = 'personal_information';
        $this->view->render('personal_information', 'dashboard_template', '/public/js/personal_information.js', false);

    }
}
