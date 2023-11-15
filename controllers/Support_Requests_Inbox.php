<?php defined('__ROOT__') or exit('No direct script access allowed');
class Support_Requests_Inbox extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

        $this->view->pagename = 'support_requests_inbox';
        $this->view->render('support_requests_inbox', 'dashboard_template', '/public/js/support_requests_inbox.js', false);
    }
}
