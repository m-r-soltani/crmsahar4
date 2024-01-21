<?php defined('__ROOT__') or exit('No direct script access allowed');
class Sold_Services extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->view->pagename = 'sold_services';
        $this->view->render('sold_services', 'dashboard_template', '/public/js/sold_services.js', false);
    }
}