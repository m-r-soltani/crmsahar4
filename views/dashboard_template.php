<?php defined('__ROOT__') OR exit('No direct script access allowed');
//include('components/header.php');
try{
    require_once('components/dashboard_header.php');
    include_once($this->view . '.php');
    // if(file_exists($this->view.'.php')){
    //     include_once($this->view . '.php');
    // }else{
    //     echo "<div style='font-size:24px !important;color:red; margin:auto;'>"."متاسفانه فایل ".$this->view.'.php'. ' یافت نشد لطفا با پشتیبانی تماس بگیرید. '."</div>";
    // }
    require_once('components/dashboard_footer.php');
}catch(Throwable $e){
    $res=Helper::Exc_Error_Debug($e,true,'',false);
    // print_r($res);
    die();
}
//include('components/footer.php');
