<?php defined('__ROOT__') or exit('No direct script access allowed');
class Speedtest_Report extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->view->pagename = 'speedtest_report';
        $this->view->render('speedtest_report', 'dashboard_template', '/public/js/speedtest_report.js', false);
    }
}
