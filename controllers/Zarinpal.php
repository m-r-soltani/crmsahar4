<?php defined('__ROOT__') or exit('No direct script access allowed');
class Zarinpal extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index($authority, $status)
    {
        $res=Helper::zarinpalVerifyByCallback($authority, $status);
        Helper::cLog($res);
        // var_dump($res);
        
        // $url=__ROOT__;
        die();
        // if($res){
        //     // Helper::Alert_Custom_Message('پرداخت موفق');
        //     $msg="پرداخت موفق";
        //     echo "<script>alert('$msg');</script>";
        // }else{
        //     $msg="پرداخت ناموفق";
        //     echo "<script>alert('$msg');</script>";
        // }
        

        $this->view->pagename = 'zarinpal';
        $this->view->render('zarinpal', 'dashboard_template', '/public/js/zarinpal.js', false);
    }
}
