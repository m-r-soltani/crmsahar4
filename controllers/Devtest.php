<?php defined('__ROOT__') OR exit('No direct script access allowed');
class Devtest extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
//		$this->view->allUsers = R::findAll( 'bnm_users' );
//		$this->view->title = 'کاربران';
        $this->view->render('devtest','dashboard_template','/public/js/devtest.js','/public/js/devtest2.js');
    }
}
