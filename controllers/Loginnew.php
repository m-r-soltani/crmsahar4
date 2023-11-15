<?php defined('__ROOT__') or exit('No direct script access allowed');

class Loginnew extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    //0050219022
    //0083780025
    //3358063631
    public function index()
    {
        $this->view->pagename = 'loginnew';
        // $this->view->render('loginnew/view', false, '/public/js/loginnew.js', false);
        $this->view->render('loginnew/view', false, '/public/js/loginnew.js', false);
    }
}
