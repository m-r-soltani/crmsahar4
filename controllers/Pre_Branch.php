<?php defined('__ROOT__') or exit('No direct script access allowed');
class Pre_Branch extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {   
        $this->view->pagename = 'pre_branch';
        $this->view->render('pre_branch', 'blankdashboard', '/public/js/pre_branch.js', false);
    }
}
