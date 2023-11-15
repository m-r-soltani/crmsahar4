<?php defined('__ROOT__') or exit('No direct script access allowed');
class Credits extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        /*========sabte shahr========*/
        // if (isset($_POST['send_taghire_etebar'])) {
        //     parse_str($_POST[key($_POST)], $_POST);
        //     $_POST      = Helper::xss_check_array($_POST);
        //     $_POST['change_amount'] = Helper::regulateNumber($_POST['change_amount']);
        //     $_POST['change_amount'] = str_replace(',', '', $_POST['change_amount']);

        //     if($_POST['noe_taghire_etebat']==='afzayesh'){
        //         $_POST['change_amount']=abs($_POST['change_amount']);
        //     }elseif ($_POST['noe_taghire_etebat']==='kahesh') {
        //         $_POST['change_amount']= -1 * abs($_POST['change_amount']);
        //     }
        //     die(json_encode($_POST));
        //     unset($_POST['send_taghire_etebar']);
        //     if (isset($_POST['user_or_branch_name'])) {
        //         unset($_POST['user_or_branch_name']);
        //     }

        //     die(json_encode($_POST));
        //     if (Helper::Login_Just_Check()) {
        //         switch ($_SESSION['user_type']) {
        //             case __ADMINUSERTYPE__:
        //                 if (Helper::Is_Empty_OR_Null($_POST['user_id']) && Helper::Is_Empty_OR_Null($_POST['noe_user'])) {
        //                     $sql      = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user=? AND update_time<>'' ORDER BY id DESC LIMIT 1";
        //                     $res_init = Db::secure_fetchall($sql, array($_POST['user_id'], $_POST['noe_user']));
        //                     //agar etelaat ghablan sabt shode
        //                     if ($res_init && count($res_init) > 0) {
        //                         $_POST['user_or_branch_id'] = $res_init[0]['user_or_branch_id'];
        //                         if (Helper::Is_Empty_OR_Null($res_init[0]['noe_user'])) {
        //                             $_POST['noe_user'] = $res_init[0]['noe_user'];
        //                         } else {
        //                             $_POST['noe_user'] = $_POST['noe_user'];
        //                         }
        //                         $res_init[0]['bestankar']=Helper::getor_string($res_init[0]['bestankar'],0);
        //                         $res_init[0]['bedehkar']=Helper::getor_string($res_init[0]['bedehkar'],0);  
        //                         if(is_numeric(floatval($_POST['change_amount']))){
        //                             if(floatval($_POST['change_amount']>0)){
        //                                 $_POST['bedehkar']  = 0;
        //                                 $_POST['bestankar'] = abs(floatval($res_init[0]['bestankar'])+floatval($_POST['change_amount']));
        //                                 $_POST['credit']    = abs(floatval($res_init[0]['credit'])+floatval($_POST['change_amount'])); 
        //                             }elseif(floatval($_POST['change_amount']<0)){

        //                                 if(floatval($res_init[0]['credit']) >= abs(floatval($_POST['change_amount'] + (floatval($_POST['change_amount']) * 20/100)))){
        //                                         $_POST['credit']= abs(floatval($res_init[0]['credit'])+floatval($_POST['change_amount']));
        //                                         $_POST['bedehkar']=abs(floatval($_POST['change_amount']));
        //                                         $_POST['bestankar']=0;
        //                                 }else{
        //                                     die(Helper::Json_Message('credit_20p_low'));
        //                                 }
        //                             }else{
        //                                 die(Helper::Json_Message('info_not_true'));
        //                             }
        //                         }else{
        //                             die(Helper::Json_Message('info_not_true'));
        //                         }
        //                         //$_POST['credit']            = floatval($res_init[0]['credit']) + (floatval($_POST['change_amount']));
        //                         $_POST['modifier_username'] = $_SESSION['username'];
        //                         $_POST['modifier_id']       = $_SESSION['user_id'];
        //                         $_POST['tozihat']           = Helper::getor_string($_POST['tozihat'], 'بدون توضیحات');
        //                         $_POST['last_row_id']       = Helper::getor_string($res_init[0]['id'],'empty');
        //                         unset($_POST['user_id']);
        //                         unset($_POST['current_credit']);
        //                         $sql = Helper::Insert_Generator($_POST, 'bnm_credits');
        //                         $res = Db::secure_insert_array($sql, $_POST);

        //                         die(json_encode(array('new_credit'=>$_POST['credit'])));
        //                         //die(json_encode(array('new_credit'=>$_POST['credit'])));

        //                     } else {
        //                         //agar credit ghabli vojod nadasht
        //                         if(floatval($_POST['change_amount']>0) && is_numeric(floatval($_POST['change_amount']))){
        //                             $_POST['bedehkar']  = 0;
        //                             $_POST['bestankar'] = abs(0+floatval($_POST['change_amount']));
        //                             $_POST['credit']    = abs(0+floatval($_POST['change_amount']));
        //                         }else{
        //                             die(Helper::Json_Message('charge_first'));
        //                         }
        //                         $_POST['noe_user']          = $_POST['noe_user'];
        //                         $_POST['change_amount']     = abs(Helper::getor_string($_POST['change_amount'], 0));
        //                         $_POST['credit']            = abs(0 + floatval($_POST['change_amount']));
        //                         $_POST['user_or_branch_id'] = $_POST['user_id'];
        //                         $_POST['modifier_username'] = $_SESSION['username'];
        //                         $_POST['modifier_id']       = $_SESSION['user_id'];
        //                         $_POST['last_row_id']       = 'empty';
        //                         unset($_POST['user_id']);
        //                         unset($_POST['current_credit']);
        //                         $sql = Helper::Insert_Generator($_POST, 'bnm_credits');
        //                         $res = Db::secure_insert_array($sql, $_POST);
        //                         if($res){
        //                             die(json_encode(array('new_credit'=>$_POST['credit'])));
        //                         }else{
        //                             die(Helper::Json_Message('unknown_error'));
        //                         }


        //                     }

        //                 } else {
        //                     die(Helper::Json_Message('info_not_true'));
        //                 }
        //                 break;
        //                 ///todo ... namayande & operators
        //                     case __ADMINOPERATORUSERTYPE__:
        //                     case __MODIRUSERTYPE__:
        //                     case __OPERATORUSERTYPE__:
        //                     case __MODIR2USERTYPE__:
        //                     case __OPERATOR2USERTYPE__:
        //                     case __MOSHTARAKUSERTYPE__:
        //                 die(Helper::Json_Message('af'));
        //                 break;

        //             default:
        //                 die(Helper::Json_Message('na'));
        //                 break;
        //         }
        //     } else {
        //         die(Helper::Json_Message('auth_fail'));
        //     }

        // }

        if (isset($_POST['send_taghire_etebar'])) {
            parse_str($_POST[key($_POST)], $_POST);
            $_POST      = Helper::xss_check_array($_POST);
            $_POST['change_amount'] = Helper::regulateNumber($_POST['change_amount']);
            $_POST['change_amount'] = str_replace(',', '', $_POST['change_amount']);
            if ($_POST['noe_taghire_etebat'] === 'afzayesh') {
                $_POST['change_amount'] = abs($_POST['change_amount']);
            } elseif ($_POST['noe_taghire_etebat'] === 'kahesh') {
                $_POST['change_amount'] = -1 * abs($_POST['change_amount']);
            }
            // die(json_encode($_POST));
            $arr=[];
            if (!Helper::Login_Just_Check()) die(Helper::Json_Message('af'));
            switch ($_SESSION['user_type']) {
                case __ADMINUSERTYPE__:
                case __ADMINOPERATORUSERTYPE__:
                    if (Helper::Is_Empty_OR_Null($_POST['user_id']) && Helper::Is_Empty_OR_Null($_POST['noe_user'])) {
                        $sql      = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user=? AND update_time<>'' ORDER BY id DESC LIMIT 1";
                        $res_init = Db::secure_fetchall($sql, array($_POST['user_id'], $_POST['noe_user']));
                        if($res_init){
                            //user exist
                            $arr['credit']              = Helper::getor_string($res_init[0]['credit'], 0)+$_POST['change_amount'];
                            $arr['change_amount']       = $_POST['change_amount'];
                            if($_POST['change_amount']>=0){
                                $arr['bestankar']           = $_POST['change_amount'];
                                $arr['bedehkar']            = 0;
                            }else{
                                $arr['bestankar']           = 0;
                                $arr['bedehkar']            = abs($_POST['change_amount']);
                            }
                            $arr['modifier_username']   = $_SESSION['username'];
                            $arr['modifier_id']         = $_SESSION['id'];
                            $arr['tozihat']             = Helper::getor_string($_POST['tozihat'], 'بدون توضیحات');
                            $arr['last_row_id']         = Helper::getor_string($res_init[0]['id'], '');
                            $arr['user_or_branch_id']   = $res_init[0]['user_or_branch_id'];
                            $arr['noe_user']            = $res_init[0]['noe_user'];
                            $sql = Helper::Insert_Generator($arr, 'bnm_credits');
                            $res = Db::secure_insert_array($sql, $arr);
                        }else{
                            //user not found
                            $arr['credit']              = $_POST['change_amount'];
                            $arr['change_amount']       = $_POST['change_amount'];
                            if($_POST['change_amount']>=0){
                                $arr['bestankar']           = $_POST['change_amount'];
                                $arr['bedehkar']            = 0;
                            }else{
                                $arr['bestankar']           = 0;
                                $arr['bedehkar']            = abs($_POST['change_amount']);
                            }
                            $arr['modifier_username']   = $_SESSION['username'];
                            $arr['modifier_id']         = $_SESSION['id'];
                            $arr['tozihat']             = Helper::getor_string($_POST['tozihat'], 'بدون توضیحات');
                            $arr['last_row_id']         = '';
                            $arr['user_or_branch_id']   = $_POST['user_id'];
                            $arr['noe_user']            = $_POST['noe_user'];
                            $sql = Helper::Insert_Generator($arr, 'bnm_credits');
                            $res = Db::secure_insert_array($sql, $arr);
                        }
                        if($res){
                            $sql="SELECT * FROM bnm_credits WHERE id = ?";
                            $credit=Db::secure_fetchall($sql,[$res]);
                            die(Helper::Custom_Msg('موجودی جدید: '.$credit[0]['credit'],1));
                        }else{
                            die(Helper::Json_Message('e'));
                        }
                        // die(json_encode(array('new_credit' => $_POST['credit'])));

                    } else {
                        die(Helper::Json_Message('info_not_true'));
                    }
                    break;
                    ///todo ... namayande & operators
                case __ADMINOPERATORUSERTYPE__:
                case __MODIRUSERTYPE__:
                case __OPERATORUSERTYPE__:
                case __MODIR2USERTYPE__:
                case __OPERATOR2USERTYPE__:
                case __MOSHTARAKUSERTYPE__:
                    die(Helper::Json_Message('af'));
                    break;
                default:
                    die(Helper::Json_Message('na'));
                    break;
            }
        }

        if (isset($_POST['credits']) && isset($_POST['request1']) && isset($_POST['request2'])) {
            //$_POST['request1']->id
            //$_POST['request2']->subscriber or branch
            $_POST = Helper::xss_check_array($_POST);
            if (Helper::Is_Empty_OR_Null($_POST['request1']) && Helper::Is_Empty_OR_Null($_POST['request2'])) {
                if (Helper::Login_Just_Check()) {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                            if ($_POST['request2'] == 'moshtarak') {
                                $sql            = "SELECT id,noe_moshtarak,name,f_name,branch_id FROM bnm_subscribers WHERE id =?";
                                $res_subscriber = Db::secure_fetchall($sql, array($_POST['request1']));
                                if ($res_subscriber) {
                                    $sql         = "SELECT * FROM bnm_credits WHERE user_or_branch_id = ? AND noe_user=? AND update_time<>'' AND update_time IS NOT NULL ORDER BY update_time DESC LIMIT 1";
                                    $res_credits = Db::secure_fetchall($sql, array($res_subscriber[0]['id'], '1'));

                                    if (!$res_credits) {
                                        $res_credits                     = array();
                                        $res_credits[0]['credit']        = 0;
                                        $res_credits[0]['change_amount'] = 0;
                                        $res_credits[0]['tozihat']       = 0;
                                    }
                                    $res_credits[0]['change_amount'] = 0;
                                    $res_credits['sub_id']           = Helper::getor_string($res_subscriber[0]['id'], 'empty');
                                    $res_credits['name']             = Helper::getor_string($res_subscriber[0]['name'], 'ثبت نشده');
                                    $res_credits['f_name']           = Helper::getor_string($res_subscriber[0]['f_name'], 'ثبت نشده');
                                    $res_credits['noe_moshtarak']    = Helper::getor_string($res_subscriber[0]['noe_moshtarak'], 'ثبت نشده');
                                    $res_credits['branch_id']        = $res_subscriber[0]['branch_id'];
                                    die(json_encode($res_credits));
                                } else {
                                    die(Helper::Json_Message('info_not_true'));
                                }
                            } elseif ($_POST['request2'] == 'namayande') {
                                $sql             = "SELECT id,name_sherkat FROM bnm_branch WHERE id=?";
                                $res_namayandegi = Db::secure_fetchall($sql, array($_POST['request1']));
                                if ($res_namayandegi) {
                                    $sql         = "SELECT * FROM bnm_credits WHERE user_or_branch_id = ? AND noe_user=? AND update_time<>'' AND update_time IS NOT NULL ORDER BY update_time DESC LIMIT 1";
                                    $res_credits = Db::secure_fetchall($sql, array($res_namayandegi[0]['id'], '2'));
                                    if (!$res_credits) {
                                        $res_credits                     = array();
                                        $res_credits[0]['credit']        = 0;
                                        $res_credits[0]['change_amount'] = 0;
                                        $res_credits[0]['tozihat']       = 0;
                                    }
                                    $res_credits[0]['change_amount'] = 0;
                                    $res_credits['branch_id']        = $res_namayandegi[0]['id'];
                                    $res_credits['name_sherkat']     = $res_namayandegi[0]['name_sherkat'];
                                    die(json_encode($res_credits));
                                } else {
                                    die(Helper::Json_Message('info_not_true'));
                                }
                            } else {
                                die(Helper::Json_Message('unknown_error'));
                            }
                            break;
                        case __ADMINOPERATORUSERTYPE__:
                        case __MODIRUSERTYPE__:
                        case __OPERATORUSERTYPE__:
                        case __MODIR2USERTYPE__:
                        case __OPERATOR2USERTYPE__:
                        case __MOSHTARAKUSERTYPE__:
                            ///todo... namayande and operators
                            die(Helper::Json_Message('af'));
                            break;

                        default:
                            die(Helper::Json_Message('auth_fail'));
                            break;
                    }
                    // $_POST['request1']->user_id
                    // $_POST['request2']->branch_id or subscriber_id
                } else {
                    die(Helper::Json_Message('auth_fail'));
                }
            } else {
                die(Helper::Json_Message('info_not_true'));
            }
        }

        $this->view->pagename = 'credits';
        $this->view->render('credits', 'dashboard_template', '/public/js/credits.js', false);
    }
}
