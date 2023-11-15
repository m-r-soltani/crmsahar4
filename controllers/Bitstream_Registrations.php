<?php defined('__ROOT__') or exit('No direct script access allowed');

class Bitstream_Registrations extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        /*========sabte bitstream_registrations========*/
        /*========kalamate mokhafaf harfe avale anha ast ========*/
        /*========mesal:eses=emkan sanhi erae service ========*/
        if (isset($_POST['send_bitstream_eses'])) {
            parse_str($_POST[key($_POST)], $_POST);
            $_POST = Helper::xss_check_array($_POST);
            // $aaaa=new AsiatechJsonrpc();
            // die(json_encode($aaaa));
            //////////////get telecenter
            // $aaaa=new AsiatechJsonrpc();
            // die(json_encode($aaaa));
            $telecenter = $GLOBALS['bs']->getLocationFromPhonePrefix($_POST['eses_telephone']);
            if ($GLOBALS['bs']->errorCheck($telecenter)) {
                $telename = "مرکز : " . $telecenter['result']['data']['ciname'] . '-' . $telecenter['result']['data']['loname'];
                $_POST['eses_markaze_mokhaberati'] = $telecenter['result']['data']['loid'];
            } else {
                die(Helper::Custom_Msg($GLOBALS['bs']->getMessage($telecenter)));
            }
            $arr = array();
            switch ($_POST['eses_noe_service']) {
                case '1':
                    # ADSL
                    $arr['interfacetype'] = "adsl";
                    break;
                case '2':
                    # VDSL
                    $arr['interfacetype'] = "vdsl";
                    break;

                default:
                    die(Helper::Json_Message('f'));
                    break;
            }
            if ($_POST['eses_checkotherpap'] === '1') {
                $arr['checkOtherPap'] = true;
            } elseif ($_POST['eses_checkotherpap'] === '2') {
                $arr['checkOtherPap'] = false;
            } else {
                die(Helper::Json_Message('f'));
            }
            ///baraye in method vspid bayad 1 bashad
            $arr['loid']                = (int) $_POST['eses_markaze_mokhaberati'];
            $arr['phone']               = $_POST['eses_telephone'];
            $arr['vspid']               = __ASIATECHALTVSPID__;
            $arr['bmsPriorityCheck']    = "high";
            
            $result = $GLOBALS['bs']->resourceFeasibilityCheck($arr);
            // die(json_encode($result,JSON_UNESCAPED_UNICODE));
            if ($GLOBALS['bs']->errorCheck($result)) {
                die(Helper::Custom_Msg($GLOBALS['bs']->getMessage($result) . '<br>' . $telename, 1));
            } else {
                die(Helper::Custom_Msg($GLOBALS['bs']->getMessage($result) . '<br>' . $telename, 2));
            }
            // die(Helper::Custom_Msg($result));
            // die($GLOBALS['bs']->getMessage($result));
        }

        if (isset($_POST['send_bitstream_smdoss'])) {
            parse_str($_POST[key($_POST)], $_POST);
            $_POST = Helper::xss_check_array($_POST);
            //interfacetype,loid,phone
            if (Helper::Is_Empty_OR_Null($_POST['smdoss_moshtarak_id'])) {
                if (Helper::Is_Empty_OR_Null($_POST['smdoss_telephone'])) {
                    if (Helper::Login_Just_Check()) {
                        $check = Helper::checkOssSubExist($_POST['smdoss_moshtarak_id'], $_POST['smdoss_telephone']);
                        if (!$check) {
                            $ressub = Helper::getSubInfoBySessionType($_POST['smdoss_moshtarak_id']);
                            $restel = Helper::getSubTelephoneInfo($ressub, (string) $_POST['smdoss_telephone']);
                            if ($ressub[0]['noe_moshtarak'] === 'real') {
                                $ressub[0]['noe_moshtarak'] = 1;
                            } elseif ($ressub[0]['noe_moshtarak'] === 'legal') {
                                $ressub[0]['noe_moshtarak'] = 2;
                            } else {
                                die(Helper::Json_Message('sinv'));
                            }
                            if (Helper::checkTelephone($restel['telephone'])) {
                                if (Helper::checkCodeMeli($ressub[0]['code_meli'])) {
                                    $arr = [];
                                    $arr['subscriberid'] = $restel['codemelimoshtarak'] . '-' . $restel['telephone'];
                                    $arr['vspid'] = __ASIATECHVSPID__;
                                    $arr['name'] = $restel['namemoshtarak'];
                                    $arr['family'] = $restel['fnamemoshtarak'];
                                    $arr['usertype'] = $ressub[0]['noe_moshtarak'];
                                    $arr['uid'] = $restel['codemelimoshtarak'];
                                    $arr['tel'] = $restel['telephone'];
                                    $arr['priority'] = 1000;
                                    $result = $GLOBALS['bs']->createSubscriber($arr);
                                    if ($GLOBALS['bs']->errorCheck($result)) {
                                        //insert into bnm_oss_subscribers
                                        $oss_arr = array();
                                        $oss_arr['user_id'] = $ressub[0]['id'];
                                        $oss_arr['telephone'] = $_POST['smdoss_telephone'];
                                        $oss_arr['branch_id'] = $ressub[0]['branch_id'];
                                        if (isset($result['result']['data'])) {
                                            if (isset($result['result']['data']['subid'])) {
                                                $oss_arr['oss_id'] = $result['result']['data']['subid'];
                                            }
                                        }
                                        $sql = Helper::Insert_Generator($oss_arr, 'bnm_oss_subscribers');
                                        $res_oss = Db::secure_insert_array($sql, $oss_arr);
                                        die($GLOBALS['bs']->getMessage($result));
                                    } else {
                                        die(Helper::Json_Message('f'));
                                    }
                                    die($GLOBALS['bs']->getMessage($result));
                                } else {
                                    die(Helper::Custom_Msg('فرمت کدملی اشتباه است'));
                                }
                            } else {
                                die(Helper::Json_Message('sinv'));
                            }
                        } else {
                            die(Helper::Json_Message('sac'));
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }
                } else {
                    die(Helper::Json_Message('f'));
                }
            } else {
                die(Helper::Json_Message('f'));
            }
        }
        if (isset($_POST['send_bitstream_rm'])) {
            parse_str($_POST[key($_POST)], $_POST);
            $_POST = Helper::xss_check_array($_POST);
            try {
                //check noe reserve
                if (isset($_POST['rm_reserve_type'])) {
                    if ($_POST['rm_reserve_type'] === "1") {
                        $_POST['rm_reserve_type'] = "adsl";
                    } elseif ($_POST['rm_reserve_type'] === "2") {
                        $_POST['rm_reserve_type'] = "vdsl";
                    } else {
                        die(Helper::Json_Message('f'));
                    }
                } else {
                    die(Helper::Json_Message('f'));
                }

                //check noe reserve
                if (Helper::Login_Just_Check()) {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            $sql = "SELECT oss.id oss_row_id,oss.oss_id oss_id,sub.branch_id branch_id,
                                    if(oss.telephone=1,sub.telephone1,if(oss.telephone=2,sub.telephone2,if(oss.telephone=3,sub.telephone3,false))) telephone,
                                    CASE
                                        WHEN (oss.telephone=1) THEN
                                        CASE WHEN(sub.noe_malekiat1=1) THEN
                                            (sub.noe_malekiat1) ELSE (sub.noe_malekiat1)
                                        END
                                        WHEN (oss.telephone=2) THEN
                                        CASE WHEN(sub.noe_malekiat1=1) THEN
                                            (sub.noe_malekiat2) ELSE (sub.noe_malekiat2)
                                        END
                                        WHEN (oss.telephone=3) THEN
                                        CASE WHEN(sub.noe_malekiat1=1) THEN
                                            (sub.noe_malekiat3) ELSE (sub.noe_malekiat3)
                                        END
                                    END AS 'noe_malekiat',
                                    CASE
                                        WHEN (oss.telephone=1) THEN
                                        CASE WHEN(sub.noe_malekiat1=1) THEN
                                            (sub.name) ELSE (sub.name_malek1)
                                        END
                                        WHEN (oss.telephone=2) THEN
                                        CASE WHEN(sub.noe_malekiat1=1) THEN
                                            (sub.name) ELSE (sub.name_malek2)
                                        END
                                        WHEN (oss.telephone=3) THEN
                                        CASE WHEN(sub.noe_malekiat1=1) THEN
                                            (sub.name) ELSE (sub.name_malek3)
                                        END
                                    END AS 'name',
                                    CASE
                                        WHEN (oss.telephone=1) THEN
                                        CASE WHEN(sub.noe_malekiat1=1) THEN
                                            (sub.f_name) ELSE (sub.f_name_malek1)
                                        END
                                        WHEN (oss.telephone=2) THEN
                                        CASE WHEN(sub.noe_malekiat1=1) THEN
                                            (sub.f_name) ELSE (sub.f_name_malek2)
                                        END
                                        WHEN (oss.telephone=3) THEN
                                        CASE WHEN(sub.noe_malekiat1=1) THEN
                                            (sub.f_name) ELSE (sub.f_name_malek3)
                                        END
                                    END AS 'f_name',
                                    CASE
                                        WHEN (oss.telephone=1) THEN
                                        CASE WHEN(sub.noe_malekiat1=1) THEN
                                            (sub.code_meli) ELSE (sub.code_meli_malek1)
                                        END
                                        WHEN (oss.telephone=2) THEN
                                        CASE WHEN(sub.noe_malekiat1=1) THEN
                                            (sub.code_meli) ELSE (sub.code_meli_malek1)
                                        END
                                        WHEN (oss.telephone=3) THEN
                                        CASE WHEN(sub.noe_malekiat1=1) THEN
                                            (sub.code_meli) ELSE (sub.code_meli_malek1)
                                        END
                                    END AS 'code_meli'
                                    FROM bnm_oss_subscribers oss LEFT JOIN bnm_subscribers sub ON oss.user_id = sub.id
                                    WHERE oss.id=? AND oss.telephone = ?";
                            $res = Db::secure_fetchall($sql, array($_POST['rm_oss_registred_id'], $_POST['rm_telephone']), true);
                            break;
                        case __MODIRUSERTYPE__:
                        case __OPERATORUSERTYPE__:
                        case __MODIR2USERTYPE__:
                        case __OPERATOR2USERTYPE__:
                            $sql = "SELECT oss.id oss_row_id,oss.oss_id oss_id,sub.branch_id branch_id,
                                    if(oss.telephone=1,sub.telephone1,if(oss.telephone=2,sub.telephone2,if(oss.telephone=3,sub.telephone3,false))) telephone,
                                    CASE
                                        WHEN (oss.telephone=1) THEN
                                        CASE WHEN(sub.noe_malekiat1=1) THEN
                                            (sub.noe_malekiat1) ELSE (sub.noe_malekiat1)
                                        END
                                        WHEN (oss.telephone=2) THEN
                                        CASE WHEN(sub.noe_malekiat1=1) THEN
                                            (sub.noe_malekiat2) ELSE (sub.noe_malekiat2)
                                        END
                                        WHEN (oss.telephone=3) THEN
                                        CASE WHEN(sub.noe_malekiat1=1) THEN
                                            (sub.noe_malekiat3) ELSE (sub.noe_malekiat3)
                                        END
                                    END AS 'noe_malekiat',
                                    CASE
                                        WHEN (oss.telephone=1) THEN
                                        CASE WHEN(sub.noe_malekiat1=1) THEN
                                            (sub.name) ELSE (sub.name_malek1)
                                        END
                                        WHEN (oss.telephone=2) THEN
                                        CASE WHEN(sub.noe_malekiat1=1) THEN
                                            (sub.name) ELSE (sub.name_malek2)
                                        END
                                        WHEN (oss.telephone=3) THEN
                                        CASE WHEN(sub.noe_malekiat1=1) THEN
                                            (sub.name) ELSE (sub.name_malek3)
                                        END
                                    END AS 'name',
                                    CASE
                                        WHEN (oss.telephone=1) THEN
                                        CASE WHEN(sub.noe_malekiat1=1) THEN
                                            (sub.f_name) ELSE (sub.f_name_malek1)
                                        END
                                        WHEN (oss.telephone=2) THEN
                                        CASE WHEN(sub.noe_malekiat1=1) THEN
                                            (sub.f_name) ELSE (sub.f_name_malek2)
                                        END
                                        WHEN (oss.telephone=3) THEN
                                        CASE WHEN(sub.noe_malekiat1=1) THEN
                                            (sub.f_name) ELSE (sub.f_name_malek3)
                                        END
                                    END AS 'f_name',
                                    CASE
                                        WHEN (oss.telephone=1) THEN
                                        CASE WHEN(sub.noe_malekiat1=1) THEN
                                            (sub.code_meli) ELSE (sub.code_meli_malek1)
                                        END
                                        WHEN (oss.telephone=2) THEN
                                        CASE WHEN(sub.noe_malekiat1=1) THEN
                                            (sub.code_meli) ELSE (sub.code_meli_malek1)
                                        END
                                        WHEN (oss.telephone=3) THEN
                                        CASE WHEN(sub.noe_malekiat1=1) THEN
                                            (sub.code_meli) ELSE (sub.code_meli_malek1)
                                        END
                                    END AS 'code_meli'
                                    FROM bnm_oss_subscribers oss LEFT JOIN bnm_subscribers sub ON oss.user_id = sub.id
                                    WHERE oss.id=? AND oss.branch_id=? AND sub.branch_id=? AND oss.telephone=?";
                            $res = Db::secure_fetchall($sql, array($_POST['rm_oss_registred_id'], $_SESSION['branch_id'], $_SESSION['branch_id'], $_POST['rm_telephone']), true);
                            break;
                        default:
                            die(Helper::Json_Message('na'));
                            break;
                    }

                    if ($res) {
                        $telecenter = $GLOBALS['bs']->getLocationFromPhonePrefix($res[0]['telephone']);
                        if ($GLOBALS['bs']->errorCheck($telecenter)) {
                            $telename = "مرکز : " . $telecenter['result']['data']['ciname'] . '-' . $telecenter['result']['data']['loname'];
                            $_POST['rm_markaze_mokhaberati'] = $telecenter['result']['data']['loid'];
                        } else {
                            die(Helper::Custom_Msg($GLOBALS['bs']->getMessage($telecenter)));
                        }
                        $arr = array();
                        $arr['subid'] = (int) $res[0]['oss_id'];
                        $arr['ownertype'] = (int) $res[0]['noe_malekiat'];
                        $arr['ownername'] = $res[0]['name'];
                        $arr['ownerfamily'] = $res[0]['f_name'];
                        $arr['owneruid'] = $res[0]['code_meli'];
                        $arr['loid'] = (int) $_POST['rm_markaze_mokhaberati'];
                        $arr['interfacetype'] = $_POST['rm_reserve_type'];
                        $arr['restime'] = (int) $_POST['rm_reserve_time'];
                        $arr['phone'] = $res[0]['telephone'];
                        $arr['vspid'] = 1; //asiatech goft inja vspid bayad 1 bashe!
                        $result = $GLOBALS['bs']->reserveResource($arr);
                        // if($GLOBALS['bs']->errorCheck($result)){
                        //     die(Helper::Custom_Msg($GLOBALS['bs']->getMessage($result).'<br>'.$telename,1));
                        // }else{
                        //     die(Helper::Custom_Msg($GLOBALS['bs']->getMessage($result).'<br>'.$telename,2));
                        // }
                        if ($GLOBALS['bs']->errorCheck($result)) {
                            //insert into bnm_oss_reserves
                            $reserve_arr = array();
                            $reserve_arr['reservetime'] = (int) $_POST['rm_reserve_time'];
                            if ($reserve_arr['reservetime'] === 48) {
                                $reserve_arr['reservetime'] = Helper::Add_Or_Minus_Day_To_Date(2, '+');
                            } elseif ($reserve_arr['reservetime'] === 72) {
                                $reserve_arr['reservetime'] = Helper::Add_Or_Minus_Day_To_Date(3, '+');
                            }
                            $reserve_arr['branch_id'] = $res[0]['branch_id'];
                            $reserve_arr['oss_id'] = $res[0]['oss_row_id'];
                            $reserve_arr['errcode'] = $result['result']['errcode'];
                            $reserve_arr['errmsg'] = $result['result']['errmsg'];
                            $reserve_arr['bitstreamingexpiredate'] = $result['result']['data']['bitstreamingExpireDate'];
                            $reserve_arr['bitstreamingpaymentid'] = $result['result']['data']['bitstreamingPaymentId'];
                            $reserve_arr['bitstreamingrequestid'] = $result['result']['data']['bitstreamingRequestId'];
                            $reserve_arr['bitstreamingresourceid'] = $result['result']['data']['bitstreamingResourceId'];
                            $reserve_arr['bukht'] = $result['result']['data']['bukht'];
                            $reserve_arr['dename'] = $result['result']['data']['dename'];
                            $reserve_arr['ip'] = $result['result']['data']['ip'];
                            $reserve_arr['tarikhe_darkhast'] = Helper::Today_Miladi_Date() . " " . Helper::nowTimeTehran();
                            $reserve_arr['lineno'] = $result['result']['data']['lineno'];
                            $reserve_arr['phone'] = $result['result']['data']['phone'];
                            $reserve_arr['port'] = $result['result']['data']['port'];
                            // $reserve_arr['reservestatus']               = $result['result']['data']['reserveStatus'];
                            $reserve_arr['resid'] = $result['result']['data']['resid'];
                            $sql = Helper::Insert_Generator($reserve_arr, 'bnm_oss_reserves');
                            $res_reserve = Db::secure_insert_array($sql, $reserve_arr);
                            // echo Helper::Custom_Msg(Helper::Messages('s'),1);
                            // die(json_encode($result,JSON_UNESCAPED_UNICODE));
                            die(Helper::Custom_Msg($GLOBALS['bs']->getMessage($result) . '<br>' . $telename, 1));
                        } else {
                            die(Helper::Custom_Msg($GLOBALS['bs']->getMessage($result) . '<br>' . $telename, 2));
                        }
                    } else {
                        die(Helper::Json_Message('inf'));
                    }
                } else {
                    die(Helper::Json_Message('fa'));
                }
            } catch (Throwable $e) {
                echo Helper::Exc_Error_Debug($e, true, '', false);
                die();
            }
        }
        if (isset($_POST['send_bitstream_ldr'])) {
            parse_str($_POST[key($_POST)], $_POST);
            $_POST = Helper::xss_check_array($_POST);
            switch ($_SESSION['user_type']) {
                case __ADMINUSERTYPE__:
                case __ADMINOPERATORUSERTYPE__:
                    $sql = "SELECT sub.id userid,sub.code_meli,sub.name name,sub.f_name name,res.id reserve_id,res.resid,oss.oss_id,oss.telephone telid,
                            if(oss.telephone=1,sub.telephone1,if(oss.telephone=2,sub.telephone2,if(oss.telephone=3,sub.telephone3,'شماره ایی ثبت نشده'))) telephone
                            FROM bnm_oss_reserves res
                            INNER JOIN bnm_oss_subscribers oss ON res.oss_id = oss.id
                            INNER JOIN bnm_subscribers sub ON oss.user_id = sub.id
                            WHERE res.id = ?";
                    $res = Db::secure_fetchall($sql, array($_POST['ldr_res_id']));
                    break;
                case __MODIR2USERTYPE__:
                case __OPERATOR2USERTYPE__:
                case __MODIRUSERTYPE__:
                case __OPERATORUSERTYPE__:
                    $sql = "SELECT sub.id userid, sub.code_meli, sub.name name, sub.f_name name, res.id reserve_id, res.resid,oss.oss_id,oss.telephone telid,
                            if(oss.telephone=1,sub.telephone1,if(oss.telephone=2,sub.telephone2,if(oss.telephone=3,sub.telephone3,'شماره ایی ثبت نشده'))) telephone
                            FROM bnm_oss_reserves res
                            INNER JOIN bnm_oss_subscribers oss ON res.oss_id = oss.id
                            INNER JOIN bnm_subscribers sub ON oss.user_id = sub.id
                            WHERE res.id = ? AND sub.branch_id = ? AND oss.branch_id = ?";
                    $res = Db::secure_fetchall($sql, array($_POST['ldr_res_id'], $_SESSION['branch_id']));
                    break;
                default:
                    die(Helper::Json_Message('na'));
                    break;
            }
            if ($res) {
                $result = $GLOBALS['bs']->cancelReserveResource($res[0]['resid'], __ASIATECHVSPID__);
                if ($GLOBALS['bs']->errorCheck($result)) {
                    $arr = [];
                    $arr['userid'] = $res[0]['userid'];
                    $arr['telid'] = $res[0]['telid'];
                    $sql = "UPDATE bnm_oss_reserves res INNER JOIN bnm_oss_subscribers oss ON oss.id=res.oss_id SET res.laghv = 1 WHERE oss.user_id = :userid AND oss.telephone = :telid AND oss.ranzhe <> 1";
                    $res = Db::secure_update_array($sql, $arr);
                    die($GLOBALS['bs']->getMessage($result));
                } else {
                    die($GLOBALS['bs']->getMessage($result));
                }
            } else {
                die(Helper::Json_Message('f'));
            }
        }
        if (isset($_POST['send_bitstream_dvdr'])) {
            parse_str($_POST[key($_POST)], $_POST);
            $_POST = Helper::xss_check_array($_POST);
            try {
                //check noe reserve
                if (Helper::Login_Just_Check()) {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            $sql = "SELECT sub.id userid,sub.code_meli,sub.name name,sub.f_name name,res.id reserve_id,res.resid,oss.oss_id,
                            if(oss.telephone=1,sub.telephone1,if(oss.telephone=2,sub.telephone2,if(oss.telephone=3,sub.telephone3,'شماره ایی ثبت نشده'))) telephone
                            FROM bnm_oss_reserves res
                            INNER JOIN bnm_oss_subscribers oss ON res.oss_id = oss.id
                            INNER JOIN bnm_subscribers sub ON oss.user_id = sub.id
                            WHERE res.id = ?";
                            $res = Db::secure_fetchall($sql, array($_POST['dvdr_reserve_id']));
                            break;
                        case __MODIRUSERTYPE__:
                        case __OPERATORUSERTYPE__:
                        case __MODIR2USERTYPE__:
                        case __OPERATOR2USERTYPE__:
                            $sql = "SELECT sub.id userid,sub.code_meli,sub.name name,sub.f_name name,res.id reserve_id,res.resid,oss.oss_id,
                            if(oss.telephone=1,sub.telephone1,if(oss.telephone=2,sub.telephone2,if(oss.telephone=3,sub.telephone3,'شماره ایی ثبت نشده'))) telephone
                            FROM bnm_oss_reserves res
                            INNER JOIN bnm_oss_subscribers oss ON res.oss_id = oss.id
                            INNER JOIN bnm_subscribers sub ON oss.user_id = sub.id
                            WHERE res.id = ? AND sub.branch_id = ? AND oss.branch_id = ?";
                            $res = Db::secure_fetchall($sql, array($_POST['dvdr_reserve_id'], $_SESSION['branch_id'], $_SESSION['branch_id']));
                            break;
                        default:
                            die(Helper::Json_Message('na'));
                            break;
                    }
                    if ($res) {
                        $arr = array();
                        $result = $GLOBALS['bs']->getReserveResourceStatus($res[0]['resid'], __ASIATECHVSPID__);
                        if ($GLOBALS['bs']->errorCheck($result)) {
                            die(Helper::Custom_Msg($result['result']['data']['description'], 2));
                        } else {
                            die($GLOBALS['bs']->getMessage($result));
                        }
                    } else {
                        die(Helper::Json_Message('f'));
                    }
                } else {
                    die(Helper::Json_Message('fa'));
                }
            } catch (Throwable $e) {
                echo Helper::Exc_Error_Debug($e, true, '', false);
                die();
            }
        }
        if (isset($_POST['send_bitstream_dsmdoss'])) {
            parse_str($_POST[key($_POST)], $_POST);
            $_POST = Helper::xss_check_array($_POST);
            try {
                if (Helper::Login_Just_Check()) {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            $sql = "SELECT oss.id row_id,oss.oss_id oss_id,sub.branch_id branch_id,
                            if(oss.telephone=1,sub.telephone1,if(oss.telephone=2,sub.telephone2,if(oss.telephone=3,sub.telephone3,'شماره ایی ثبت نشده'))) telephone,
                            CASE
                                WHEN (oss.telephone=1) THEN
                                CASE WHEN(sub.noe_malekiat1=1) THEN
                                    (sub.noe_malekiat1) ELSE (sub.noe_malekiat1)
                                END
                                WHEN (oss.telephone=2) THEN
                                CASE WHEN(sub.noe_malekiat1=1) THEN
                                    (sub.noe_malekiat2) ELSE (sub.noe_malekiat2)
                                END
                                WHEN (oss.telephone=3) THEN
                                CASE WHEN(sub.noe_malekiat1=1) THEN
                                    (sub.noe_malekiat3) ELSE (sub.noe_malekiat3)
                                END
                            END AS 'noe_malekiat',
                            CASE
                                WHEN (oss.telephone=1) THEN
                                CASE WHEN(sub.noe_malekiat1=1) THEN
                                    (sub.name) ELSE (sub.name_malek1)
                                END
                                WHEN (oss.telephone=2) THEN
                                CASE WHEN(sub.noe_malekiat1=1) THEN
                                    (sub.name) ELSE (sub.name_malek2)
                                END
                                WHEN (oss.telephone=3) THEN
                                CASE WHEN(sub.noe_malekiat1=1) THEN
                                    (sub.name) ELSE (sub.name_malek3)
                                END
                            END AS 'name',
                            CASE
                                WHEN (oss.telephone=1) THEN
                                CASE WHEN(sub.noe_malekiat1=1) THEN
                                    (sub.f_name) ELSE (sub.f_name_malek1)
                                END
                                WHEN (oss.telephone=2) THEN
                                CASE WHEN(sub.noe_malekiat1=1) THEN
                                    (sub.f_name) ELSE (sub.f_name_malek2)
                                END
                                WHEN (oss.telephone=3) THEN
                                CASE WHEN(sub.noe_malekiat1=1) THEN
                                    (sub.f_name) ELSE (sub.f_name_malek3)
                                END
                            END AS 'f_name',
                            CASE
                                WHEN (oss.telephone=1) THEN
                                CASE WHEN(sub.noe_malekiat1=1) THEN
                                    (sub.code_meli) ELSE (sub.code_meli_malek1)
                                END
                                WHEN (oss.telephone=2) THEN
                                CASE WHEN(sub.noe_malekiat1=1) THEN
                                    (sub.code_meli) ELSE (sub.code_meli_malek1)
                                END
                                WHEN (oss.telephone=3) THEN
                                CASE WHEN(sub.noe_malekiat1=1) THEN
                                    (sub.code_meli) ELSE (sub.code_meli_malek1)
                                END
                            END AS 'code_meli'
                            FROM bnm_oss_subscribers oss LEFT JOIN bnm_subscribers sub ON oss.user_id = sub.id
                            WHERE oss.id=?";
                            $res = Db::secure_fetchall($sql, array($_POST['dsmdoss_oss_id']), true);
                            break;
                        default:
                            die(Helper::Json_Message('na'));
                            break;
                    }
                    if ($res) {
                        $arr = array();
                        $result = $GLOBALS['bs']->getSubscriberByID($res[0]['code_meli'] . '-' . $res[0]['telephone'], __ASIATECHVSPID__);
                        if ($GLOBALS['bs']->errorCheck($result)) {
                            die(Helper::Custom_Msg(
                                'شناسه مشترک در &rlm;OSS : &rlm; ' . "\"" . $result['result']['data']['subid'] . "\"" . "<br>" .
                                    'شناسه مشترک در &rlm;BSS : &rlm; ' . "\"" . $res[0]['code_meli'] . '-' . $res[0]['telephone'] . "\"",
                                1
                            ));
                        } else {
                            die($GLOBALS['bs']->getMessage($result));
                        }
                    } else {
                        die(Helper::Json_Message('f'));
                    }
                } else {
                    die(Helper::Json_Message('fa'));
                }
            } catch (Throwable $e) {
                echo Helper::Exc_Error_Debug($e, true, '', false);
            }
        }
        $this->view->home = 'داشبورد';
        $this->view->page = 'نمایندگی';
        $this->view->page_url = 'bitstream_registrations';
        $this->view->pagename = 'bitstream_registrations';
        $this->view->render('bitstream_registrations', 'dashboard_template', '/public/js/bitstream_registrations.js', false);
    }
}
