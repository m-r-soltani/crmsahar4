<?php defined('__ROOT__') or exit('No direct script access allowed');
class Contracts_Report_Display extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        /*========sabte shahr========*/
        if (isset($_POST['send_contracts_report_display'])) {
            die(Helper::Json_Message('f'));
        }

        $this->view->pagename = 'contracts_report_display';
        $this->view->render('contracts_report_display', 'dashboard_template', '/public/js/contracts_report_display.js', false);
    }
}
