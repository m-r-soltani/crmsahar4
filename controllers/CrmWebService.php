<?php defined('__ROOT__') or exit('No direct script access allowed');
class CrmWebService extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

        if(isset($_POST['crm_webservice_request'])){
            if($_POST['crm_webservice_request']==="daily"){
                
            }elseif ($_POST['crm_webservice_request']==="dump") {
                
            }else{
                echo false;
                die();
            }
        }
        $this->view->pagename = 'crmwebservice';
        $this->view->render('crmwebservice', 'dashboard_template', '/public/js/crmwebservice.js', false);
    }
}
