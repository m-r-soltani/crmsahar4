<?php defined('__ROOT__') OR exit('No direct script access allowed');

class Index extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
//		$this->view->allUsers = R::findAll( 'bnm_users' );
//		$this->view->title = 'کاربران';
        //$this->view->home='داشبورد';
        //$this->view->page='نمایندگی';
        //$this->view->page_url='branch';
        //$this->view->pagename='branch';
        $this->view->render('index',false,'/public/js/index.js',false);

    }
}
