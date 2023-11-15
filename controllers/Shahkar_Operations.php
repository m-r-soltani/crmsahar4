<?php defined('__ROOT__') or exit('No direct script access allowed');
class Shahkar_Operations extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        /*========sabte shahr========*/
        if (isset($_POST['send_shahkar_operations_servicestatus'])) {
            parse_str($_POST[key($_POST)], $_POST);
            $_POST = Helper::xss_check_array($_POST);
            $_POST['service']=Helper::convert_numbers($_POST['service'], false);
            if (Helper::Login_Just_Check()) {
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                        $res=false;
                        $data=ShahkarHelper::EstServiceStatus($_POST['sertype'], $_POST['service']);
                        if(! $data) die(Helper::Json_Message('e'));
                        $res=Shahkar_Requests::estServiceStatus($data);
                        $emsg='پاسخی از سرور شاهکار دریافت نشد.';
                        if(! $res) die(Helper::Custom_Msg($emsg)); 
                        $res    =json_decode($res,true);
                        $res    =json_encode($res, JSON_UNESCAPED_UNICODE);
                        $result = ShahkarHelper::saveEstServiceStatus($res, $_POST['service'], 'estservicestatus');
                        $res    =json_decode($res, true);
                        $msg    ='';
                        if($res['response']===200 && isset($res['classifier'])){
                            $msg="classifier: ". $res['classifier'];
                        }
                        if(! $res['comment']){die(Helper::Custom_Msg(Helper::Messages('shahkar_no_response'), 2));}
                        $msg.="<br>".$res['comment'];
                        die(Helper::Custom_Msg($msg, 1));
                        
                    break;
                    default:
                        die(Helper::Json_Message('na'));
                    break;
                }
            }else{ 
                die(Helper::Json_Message('fa'));
            }
        }

        if (isset($_POST['send_shahkar_operations_closedelete'])) {
            parse_str($_POST[key($_POST)], $_POST);
            $_POST = Helper::xss_check_array($_POST);
            $res   = false;
            if (Helper::Login_Just_Check()) {
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                        if(isset($_POST['shahkarid']) && isset($_POST['telephone'])){
                            if($_POST['shahkarid']){
                                if($_POST['operationtype']==="1"){
                                    if(isset($_POST['resellercode'])){
                                        if($_POST['resellercode']===""){
                                            $_POST['resellercode']="0";
                                        }
                                    }else{
                                        $_POST['resellercode']="0";
                                    }
                                    $res=ShahkarHelper::closeService(trim($_POST['shahkarid']), trim($_POST['telephone'], trim($_POST['resellercode'])));
                                }elseif($_POST['operationtype']==="2"){
                                    if(isset($_POST['resellercode'])){
                                        if($_POST['resellercode']===""){
                                            $_POST['resellercode']="0";
                                        }
                                    }else{
                                        $_POST['resellercode']="0";
                                    }
                                    $res=ShahkarHelper::deleteService(trim($_POST['shahkarid']), trim($_POST['telephone'], trim($_POST['resellercode'])));
                                }else{
                                    die(Helper::Json_Message('f'));
                                }
                                if($res){
                                    // die($res);
                                   $res=json_decode($res, true);
                                   
                                   die(Helper::Custom_Msg($res['comment'], 1));
                                }else{
                                    die(Helper::Json_Message('snr'));
                                }
                                
                            }else{
                                die(Helper::Json_Message('inf'));
                            }
                        }else{
                            die(Helper::Json_Message('inf'));    
                        }
                        break;
                    default:
                        die(Helper::Json_Message('na'));
                        break;
                }

            }else{ 
                die(Helper::Json_Message('fa'));
            }
        }
        if (isset($_POST['send_shahkar_operations_sehatsalamat'])) {
            if (Helper::Login_Just_Check()) {
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                        $res=Shahkar_Requests::sehatSalamat();
                        if(isset($res)){
                            if(strtolower($res)==="ok"){
                                die(Helper::Custom_Msg('ارتباط برقرار است.', 1));
                            }else{
                                $m="پاسخ دریافت شده: ";
                                die(Helper::Custom_Msg($m.' '.$res));
                            }
                        }else{
                            die(Helper::Json_Message('shahkar_no_response'));    
                        }
                    break;
                    default:
                        die(Helper::Json_Message('na'));
                        break;
                }

            }else{ 
                die(Helper::Json_Message('fa'));
            }
        }

        $this->view->pagename = 'shahkar_operations';
        $this->view->render('shahkar_operations', 'dashboard_template', '/public/js/shahkar_operations.js', false);
    }
}
