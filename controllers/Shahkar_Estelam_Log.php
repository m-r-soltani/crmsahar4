<?php defined('__ROOT__') or exit('No direct script access allowed');
class Shahkar_Estelam_Log extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        

        $this->view->pagename = 'shahkar_estelam_log';
        $this->view->render('shahkar_estelam_log', 'dashboard_template', '/public/js/shahkar_estelam_log.js', false);
    }
}
