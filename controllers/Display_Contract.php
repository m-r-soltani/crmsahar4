<?php defined('__ROOT__') or exit('No direct script access allowed');
class Display_Contract extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if (isset($_POST['send_contract_confirm'])) {
            
            // $_POST=Helper::reformAjaxRequest($_POST);

            switch ($_SESSION['user_type']) {
                case __MOSHTARAKUSERTYPE__:
                    // $_POST = Helper::Create_Post_Array_Without_Key($_POST);
                    parse_str($_POST[key($_POST)], $_POST);
                    $_POST = Helper::xss_check_array($_POST);
                    $sql= "SELECT count(*) rowsnum FROM bnm_services_contract WHERE id = ?";
                    $checkcontractexist= Db::secure_fetchall($sql, [$_POST['contract_id']]);
                    if($checkcontractexist[0]['rowsnum']===1){
                        
                        if($_POST['code'] === (string) $_SESSION['contractcode']){
                            $arr                = [];
                            $arr['tarikh']      = Helper::Today_Miladi_Date().' '.Helper::nowTimeTehran();
                            $arr['status']      = 1;
                            $arr['subid']       = $_SESSION['user_id'];
                            $arr['code']        = $_SESSION['contractcode'];
                            $arr['contractid']  = $_POST['contract_id'];
                            $sql=Helper::Insert_Generator($arr, 'bnm_sub_contract');
                            $res=Db::secure_insert_array($sql, $arr);
                            if($res){
                                die(Helper::Custom_Msg(Helper::Messages('s'),1));
                            }else{
                                die(Helper::Custom_Msg(Helper::Messages('f'),2));
                            }
                        }else{
                            $msg="کد وارد شده اشتباه است.";
                            die(Helper::Custom_Msg($msg,2));
                        }
                    }else{
                        die(Helper::Custom_Msg(Helper::Messages('f'),3));
                    }
                    break;
                default:
                    die(Helper::Json_Message('f'));
                    break;
            }
        }

        $this->view->pagename = 'display_contract';
        $this->view->render('display_contract', 'dashboard_template', '/public/js/display_contract.js', false);
    }
}
