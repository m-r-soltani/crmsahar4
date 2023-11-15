<?php defined('__ROOT__') or exit('No direct script access allowed');

class Forgotpassword extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        if(isset($_POST['send_forgotpassword'])){

        }
        $this->view->pagename = 'forgotpassword';
        $this->view->render('forgotpassword/view', false, '/public/js/forgotpassword.js', false);
    }
}
