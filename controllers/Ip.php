<?php defined('__ROOT__') or exit('No direct script access allowed');
class Ip extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        /*========sabte shahr========*/
        if (isset($_POST['send_ip'])) {
            parse_str($_POST[key($_POST)], $_POST);
            $_POST = Helper::xss_check_array($_POST);
            if (Helper::Login_Just_Check()) {
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                        try {
                            unset($_POST['send_ip']);
                            $_POST = Helper::xss_check_array($_POST);
                            if ($_POST['id'] == "empty") {
                                unset($_POST['id']);
                                $spl1 = Helper::splitBycharachter($_POST['ipstart'], '.');
                                $spl2 = Helper::splitBycharachter($_POST['ipend'], '.');
                                if($spl1 && $spl2){
                                    $prefix=(string)$spl1[0].'.'.$spl1[1].'.'.$spl1[2].'.';
                                    if((int)$spl1[3] <= (int)(int)$spl2[3]){
                                        $res_range = Helper::createIpRange($prefix, (int)$spl1[3], (int)$spl2[3]);
                                        if(Helper::check_add_access('ip') && $res_range){
                                            for ($i=0; $i < count($res_range) ; $i++) {
                                                $_POST['ip'] = $res_range[$i];
                                                $sql         = Helper::Insert_Generator($_POST, 'bnm_ip');
                                                $res         = Db::secure_insert_array($sql, $_POST);
                                            }
                                            if ($res) {
                                                die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                                            } else {
                                                die(Helper::Custom_Msg(Helper::Messages('f'), 3));
                                            }
                                        } else {
                                            die(Helper::Json_Message('na'));
                                        }
                                    } else {
                                        die(Helper::Custom_Msg('فرمت آی پی های وارد شده مورد قبول نیست', 3));
                                    }
                                }else{
                                    Helper::Custom_Msg('لطفا آی پی ابتدایی و انتهایی را مجددا بررسی کنید');
                                }
                            } else {
                                if(Helper::check_update_access('ip')){
                                    $sql = Helper::Update_Generator($_POST, 'bnm_ip', "WHERE id = :id");
                                    $res = Db::secure_update_array($sql, $_POST);
                                    if($res){
                                        die(Helper::Custom_Msg(Helper::Messages('s'),1));
                                    }else{
                                        die(Helper::Custom_Msg(Helper::Messages('f'),3));
                                    }
                                } else {
                                    die(Helper::Json_Message('na'));
                                }
                            }
                        } catch (Throwable $e) {
                            $res = Helper::Exc_Error_Debug($e, true, '', true);
                            die();
                        }
                        break;

                    default:
                        die(Helper::Json_Message('na'));
                        break;
                }

            }
        }

        $this->view->pagename = 'ip';
        $this->view->render('ip', 'dashboard_template', '/public/js/ip.js', false);
    }
}
