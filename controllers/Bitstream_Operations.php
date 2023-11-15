<?php defined('__ROOT__') or exit('No direct script access allowed');

class Bitstream_Operations extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        /*========sabte bitstream_operations========*/
        /*========kalamate mokhafaf harfe avale anha ast ========*/
        /*========mesal:eses=emkan sanhi erae service ========*/
        if(isset($_POST['send_bitstream_edr'])){
            parse_str($_POST[key($_POST)], $_POST);
            $_POST = Helper::xss_check_array($_POST);
            if (Helper::Login_Just_Check()) {
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                        $sql = "SELECT
                            sub.id userid,
                            res.resid,
                            oss.oss_id,
                            IF(oss.telephone = 1, sub.telephone1, IF(oss.telephone = 2, sub.telephone2, IF(oss.telephone = 3, sub.telephone3, 'شماره ایی ثبت نشده'))) telephone,
                            CASE WHEN (oss.telephone = 1) THEN CASE WHEN (sub.noe_malekiat1 = 1) THEN (sub.noe_malekiat1) ELSE (sub.noe_malekiat1) END WHEN (oss.telephone = 2) THEN CASE WHEN (sub.noe_malekiat1 = 1) THEN (sub.noe_malekiat2) ELSE (sub.noe_malekiat2) END WHEN (oss.telephone = 3) THEN CASE WHEN (sub.noe_malekiat1 = 1) THEN (sub.noe_malekiat3) ELSE (sub.noe_malekiat3) END END AS 'noe_malekiat',
                            CASE WHEN (oss.telephone = 1) THEN CASE WHEN (sub.noe_malekiat1 = 1) THEN (sub.name) ELSE (sub.name_malek1) END WHEN (oss.telephone = 2) THEN CASE WHEN (sub.noe_malekiat1 = 1) THEN (sub.name) ELSE (sub.name_malek2) END WHEN (oss.telephone = 3) THEN CASE WHEN (sub.noe_malekiat1 = 1) THEN (sub.name) ELSE (sub.name_malek3) END END AS 'name',
                            CASE WHEN (oss.telephone = 1) THEN CASE WHEN (sub.noe_malekiat1 = 1) THEN (sub.f_name) ELSE (sub.f_name_malek1) END WHEN (oss.telephone = 2) THEN CASE WHEN (sub.noe_malekiat1 = 1) THEN (sub.f_name) ELSE (sub.f_name_malek2) END WHEN (oss.telephone = 3) THEN CASE WHEN (sub.noe_malekiat1 = 1) THEN (sub.f_name) ELSE (sub.f_name_malek3) END END AS 'f_name',
                            CASE WHEN (oss.telephone = 1) THEN CASE WHEN (sub.noe_malekiat1 = 1) THEN (sub.code_meli) ELSE (sub.code_meli_malek1) END WHEN (oss.telephone = 2) THEN CASE WHEN (sub.noe_malekiat1 = 1) THEN (sub.code_meli) ELSE (sub.code_meli_malek1) END WHEN (oss.telephone = 3) THEN CASE WHEN (sub.noe_malekiat1 = 1) THEN (sub.code_meli) ELSE (sub.code_meli_malek1) END END AS 'code_meli'
                        FROM bnm_oss_reserves res
                            INNER JOIN bnm_oss_subscribers oss
                                ON res.oss_id = oss.id
                            INNER JOIN bnm_subscribers sub
                                ON oss.user_id = sub.id
                            WHERE res.id = ?";
                        $res= Db::secure_fetchall($sql, array($_POST['edr_reserve_id']));
                    break;
                }
                if($res){
                    $result = $GLOBALS['bs']->modifyResourceInfo($res[0]['resid'],$res[0]['noe_malekiat'],$res[0]['telephone'],__ASIATECHVSPID__);
                    die(json_encode($result));
                    if($GLOBALS['bs']->errorCheck($result)){
                        die($GLOBALS['bs']->getMessage($result));
                    }else{
                        die($GLOBALS['bs']->getMessage($result));
                    }
                }else{
                    die(Helper::Json_Message('f'));
                }
            }
        }
        //new jamavari manabe
        if(isset($_POST['send_bitstream_jm'])){
            parse_str($_POST[key($_POST)], $_POST);
            $_POST = Helper::xss_check_array($_POST);
            if(! isset($_POST['jm_userservice'])){
                die(Helper::Json_Message('e'));
            }
            if(! $_POST['jm_userservice']){
                die(Helper::Json_Message('e'));
            }

            $sql="SELECT * FROM bnm_oss_reserves WHERE id = ?";
            $ossreserve=Db::secure_fetchall($sql,[$_POST['jm_userservice']]);
            if(! $ossreserve){
                die(Helper::Json_Message('e'));
            }
            $jamavari=$GLOBALS['bs']->roundupResource($ossreserve[0]['resid'],__ASIATECHVSPID__);
            if($jamavari){
                // die($GLOBALS['bs']->getMessage($jamavari));
                die(Helper::Custom_Msg($GLOBALS['bs']->getMessage($jamavari), 2));
            }else{
                $msg='پیامی از oss دریافت نشد';
                die(Helper::Custom_Msg($msg, 2));
            }
        }
        //old jamavari manabe
        // if(isset($_POST['send_bitstream_jm'])){
        //     parse_str($_POST[key($_POST)], $_POST);
        //     $_POST = Helper::xss_check_array($_POST);
        //     try{
        //         if (Helper::Login_Just_Check()) {
        //             switch ($_SESSION['user_type']) {
        //                 case __ADMINUSERTYPE__:
        //                 case __ADMINOPERATORUSERTYPE__:
        //                     $sql = "SELECT oss.id row_id,oss.oss_id oss_id,sub.branch_id branch_id,
        //                             if(oss.telephone=1,sub.telephone1,if(oss.telephone=2,sub.telephone2,if(oss.telephone=3,sub.telephone3,'شماره ایی ثبت نشده'))) telephone,
        //                             CASE
        //                                 WHEN (oss.telephone=1) THEN
        //                                 CASE WHEN(sub.noe_malekiat1=1) THEN
        //                                     (sub.noe_malekiat1) ELSE (sub.noe_malekiat1)
        //                                 END
        //                                 WHEN (oss.telephone=2) THEN
        //                                 CASE WHEN(sub.noe_malekiat1=1) THEN
        //                                     (sub.noe_malekiat2) ELSE (sub.noe_malekiat2)
        //                                 END
        //                                 WHEN (oss.telephone=3) THEN
        //                                 CASE WHEN(sub.noe_malekiat1=1) THEN
        //                                     (sub.noe_malekiat3) ELSE (sub.noe_malekiat3)
        //                                 END
        //                             END AS 'noe_malekiat',
        //                             CASE
        //                                 WHEN (oss.telephone=1) THEN
        //                                 CASE WHEN(sub.noe_malekiat1=1) THEN
        //                                     (sub.name) ELSE (sub.name_malek1)
        //                                 END
        //                                 WHEN (oss.telephone=2) THEN
        //                                 CASE WHEN(sub.noe_malekiat1=1) THEN
        //                                     (sub.name) ELSE (sub.name_malek2)
        //                                 END
        //                                 WHEN (oss.telephone=3) THEN
        //                                 CASE WHEN(sub.noe_malekiat1=1) THEN
        //                                     (sub.name) ELSE (sub.name_malek3)
        //                                 END
        //                             END AS 'name',
        //                             CASE
        //                                 WHEN (oss.telephone=1) THEN
        //                                 CASE WHEN(sub.noe_malekiat1=1) THEN
        //                                     (sub.f_name) ELSE (sub.f_name_malek1)
        //                                 END
        //                                 WHEN (oss.telephone=2) THEN
        //                                 CASE WHEN(sub.noe_malekiat1=1) THEN
        //                                     (sub.f_name) ELSE (sub.f_name_malek2)
        //                                 END
        //                                 WHEN (oss.telephone=3) THEN
        //                                 CASE WHEN(sub.noe_malekiat1=1) THEN
        //                                     (sub.f_name) ELSE (sub.f_name_malek3)
        //                                 END
        //                             END AS 'f_name',
        //                             CASE
        //                                 WHEN (oss.telephone=1) THEN
        //                                 CASE WHEN(sub.noe_malekiat1=1) THEN
        //                                     (sub.code_meli) ELSE (sub.code_meli_malek1)
        //                                 END
        //                                 WHEN (oss.telephone=2) THEN
        //                                 CASE WHEN(sub.noe_malekiat1=1) THEN
        //                                     (sub.code_meli) ELSE (sub.code_meli_malek1)
        //                                 END
        //                                 WHEN (oss.telephone=3) THEN
        //                                 CASE WHEN(sub.noe_malekiat1=1) THEN
        //                                     (sub.code_meli) ELSE (sub.code_meli_malek1)
        //                                 END
        //                             END AS 'code_meli'
        //                             FROM bnm_oss_subscribers oss LEFT JOIN bnm_subscribers sub ON oss.user_id = sub.id
        //                             WHERE oss.id=? AND oss.telephone = ?";
        //                     $res = Db::secure_fetchall($sql, array($_POST['jm_oss_registred_id'], $_POST['jm_telephone']), true);
        //                     if($res){
        //                         $result=$GLOBALS['bs']->roundupResource($res[0]['oss_id'],__ASIATECHVSPID__);
        //                         die(json_encode($result));
        //                     }else{
        //                         die(Helper::Json_Message('f'));
        //                     }
        //                 break;
        //                 default:
        //                     die(Helper::Json_Message('na'));
        //                 break;
        //             }
        //         } else{
        //             die(Helper::Json_Message('f'));
        //         }
        //     }catch (Throwable $e) {
        //         echo Helper::Exc_Error_Debug($e, true, '', false);
        //         die();
        //     }
        // }
        if(isset($_POST['send_bitstream_dsmdoss'])){
            parse_str($_POST[key($_POST)], $_POST);
            $_POST = Helper::xss_check_array($_POST);
            try{
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
                        $arr                  = array();    
                        $result     = $GLOBALS['bs']->getSubscriberByID($res[0]['code_meli'].'-'.$res[0]['telephone'],__ASIATECHVSPID__);
                        if ($GLOBALS['bs']->errorCheck($result)) {
                            die(Helper::Custom_Msg(
                                'شناسه مشترک در &rlm;OSS : &rlm; '."\"".$result['result']['data']['subid']."\""."<br>".
                                'شناسه مشترک در &rlm;BSS : &rlm; '."\"".$res[0]['code_meli'].'-'.$res[0]['telephone']."\""
                            ,1));
                        }else{
                            die($GLOBALS['bs']->getMessage($result));
                        }
                    } else {
                        die(Helper::Json_Message('f'));
                    }
                } else {
                    die(Helper::Json_Message('fa'));
                }
            }catch(Throwable $e){
                echo Helper::Exc_Error_Debug($e, true, '', false);
            }
        }
        if(isset($_POST['send_bitstream_emdrbm'])){
            parse_str($_POST[key($_POST)], $_POST);
            $_POST = Helper::xss_check_array($_POST);
            if (Helper::Login_Just_Check()) {
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                        $sql = "SELECT
                            sub.id userid,
                            res.resid,
                            oss.oss_id,
                            IF(oss.telephone = 1, sub.telephone1, IF(oss.telephone = 2, sub.telephone2, IF(oss.telephone = 3, sub.telephone3, 'شماره ایی ثبت نشده'))) telephone
                        FROM bnm_oss_reserves res
                        INNER JOIN bnm_oss_subscribers oss ON res.oss_id = oss.id
                        INNER JOIN bnm_subscribers sub ON oss.user_id = sub.id
                        WHERE 
                        res.id = ?";
                        $res= Db::secure_fetchall($sql, array($_POST['emdrbm_res_id']));
                    break;
                }                
                if($res){
                    $result = $GLOBALS['bs']->reinstallADSLPort($res[0]['telephone'] ,__ASIATECHVSPID__);
                    if(Helper::checkAsiatechBitstreamResponse($result)){
                        die(Helper::Custom_Msg($result['result']['errmsg'], 1));
                    }else{
                        die(Helper::Custom_Msg($result['result']['errmsg'], 2));
                    }
                }else{
                    die(Helper::Json_Message('e'));
                }
            }
        }
        if(isset($_POST['send_bitstream_enbtp'])){
            parse_str($_POST[key($_POST)], $_POST);
            $_POST = Helper::xss_check_array($_POST);
            if (Helper::Login_Just_Check()) {
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                        $sql = "SELECT
                            sub.id userid,
                            res.resid resid,
                            oss.oss_id,
                            IF(oss.telephone = 1, sub.telephone1, IF(oss.telephone = 2, sub.telephone2, IF(oss.telephone = 3, sub.telephone3, 'شماره ایی ثبت نشده'))) telephone
                        FROM bnm_oss_reserves res
                        INNER JOIN bnm_oss_subscribers oss ON res.oss_id = oss.id
                        INNER JOIN bnm_subscribers sub ON oss.user_id = sub.id
                        WHERE res.id = ?";
                        $res= Db::secure_fetchall($sql, array($_POST['enbtp_res_id']));
                    break;
                }
                if($res){
                    $result = $GLOBALS['bs']->needChangePort($res[0]['resid'] ,__ASIATECHVSPID__);
                    if(Helper::checkAsiatechBitstreamResponse($result)){
                        die(Helper::Custom_Msg($result['result']['errmsg'], 1));
                    }else{
                        die(Helper::Custom_Msg($result['result']['errmsg'], 2));
                    }
                }else{
                    die(Helper::Json_Message('e'));
                }
            }
        }
        if(isset($_POST['send_bitstream_devvv'])){
            parse_str($_POST[key($_POST)], $_POST);
            $_POST = Helper::xss_check_array($_POST);
            die(json_encode($_POST));
            if (Helper::Login_Just_Check()) {
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                        $sql = "SELECT
                            sub.id userid,
                            res.resid,
                            oss.oss_id,
                            IF(oss.telephone = 1, sub.telephone1, IF(oss.telephone = 2, sub.telephone2, IF(oss.telephone = 3, sub.telephone3, 'شماره ایی ثبت نشده'))) telephone,
                            CASE WHEN (oss.telephone = 1) THEN CASE WHEN (sub.noe_malekiat1 = 1) THEN (sub.noe_malekiat1) ELSE (sub.noe_malekiat1) END WHEN (oss.telephone = 2) THEN CASE WHEN (sub.noe_malekiat1 = 1) THEN (sub.noe_malekiat2) ELSE (sub.noe_malekiat2) END WHEN (oss.telephone = 3) THEN CASE WHEN (sub.noe_malekiat1 = 1) THEN (sub.noe_malekiat3) ELSE (sub.noe_malekiat3) END END AS 'noe_malekiat',
                            CASE WHEN (oss.telephone = 1) THEN CASE WHEN (sub.noe_malekiat1 = 1) THEN (sub.name) ELSE (sub.name_malek1) END WHEN (oss.telephone = 2) THEN CASE WHEN (sub.noe_malekiat1 = 1) THEN (sub.name) ELSE (sub.name_malek2) END WHEN (oss.telephone = 3) THEN CASE WHEN (sub.noe_malekiat1 = 1) THEN (sub.name) ELSE (sub.name_malek3) END END AS 'name',
                            CASE WHEN (oss.telephone = 1) THEN CASE WHEN (sub.noe_malekiat1 = 1) THEN (sub.f_name) ELSE (sub.f_name_malek1) END WHEN (oss.telephone = 2) THEN CASE WHEN (sub.noe_malekiat1 = 1) THEN (sub.f_name) ELSE (sub.f_name_malek2) END WHEN (oss.telephone = 3) THEN CASE WHEN (sub.noe_malekiat1 = 1) THEN (sub.f_name) ELSE (sub.f_name_malek3) END END AS 'f_name',
                            CASE WHEN (oss.telephone = 1) THEN CASE WHEN (sub.noe_malekiat1 = 1) THEN (sub.code_meli) ELSE (sub.code_meli_malek1) END WHEN (oss.telephone = 2) THEN CASE WHEN (sub.noe_malekiat1 = 1) THEN (sub.code_meli) ELSE (sub.code_meli_malek1) END WHEN (oss.telephone = 3) THEN CASE WHEN (sub.noe_malekiat1 = 1) THEN (sub.code_meli) ELSE (sub.code_meli_malek1) END END AS 'code_meli'
                        FROM bnm_oss_reserves res
                            INNER JOIN bnm_oss_subscribers oss
                                ON res.oss_id = oss.id
                            INNER JOIN bnm_subscribers sub
                                ON oss.user_id = sub.id
                            WHERE res.id = ?";
                        $res= Db::secure_fetchall($sql, array($_POST['devvv_res_id']));
                    break;
                }
                if($res){
                    $result1=array();
                    $result2=array();
                    $result1 = $GLOBALS['bs']->getPortID($res[0]['telephone'],__ASIATECHVSPID__);
                    $result2 = $GLOBALS['bs']->getInterfaceServicePort($res['result']['data']['portid'],__ASIATECHVSPID__);
                    die(json_encode(array($result1,$result2)));
                    if($GLOBALS['bs']->errorCheck($result)){
                        
                    }else{
                        die(Helper::Json_Message('f'));
                    }
                    
                    
                    // if($GLOBALS['bs']->errorCheck($result)){
                    //     die($GLOBALS['bs']->getMessage($result));
                    // }else{
                    //     die($GLOBALS['bs']->getMessage($result));
                    // }
                }else{
                    die(Helper::Json_Message('f'));
                }
            }
        }
        if(isset($_POST['send_new_ticket'])){
            parse_str($_POST[key($_POST)], $_POST);
            $_POST = Helper::xss_check_array($_POST);
            if(Helper::Login_Just_Check()){
                switch ($_SESSION['user_type']) {
                case __ADMINUSERTYPE__:
                case __ADMINOPERATORUSERTYPE__:
                    if($_POST['maintype']==='port'){
                        $sql            = "SELECT * FROM bnm_oss_reserves WHERE id = ?";
                        $res            = Db::secure_fetchall($sql, array($_POST['maintypeid']));
                    }elseif($_POST['maintype']==='subscriber'){
                        $sql            = "SELECT * FROM bnm_oss_subscribers WHERE id = ?";
                        $res            = Db::secure_fetchall($sql, array($_POST['maintypeid']));
                    }else{
                        unset($_POST['maintypeid']);
                        unset($_POST['maintype']);
                        die(Helper::Json_Message('f'));
                    }
                break;
                }
                $arr = array();
                if(isset($res)){
                    if(isset($_POST['maintype'])){
                        $arr['maintype']= $_POST['maintype'];
                        if($_POST['maintype']==='port'){
                            $arr['maintypeid']= $res[0]['resid'];
                        }elseif($_POST['maintype']==='subscriber'){
                            $arr['maintypeid']= $res[0]['oss_id'];
                        }
                    }
                }else{
                    die(Helper::Json_Message('f'));
                }
                $arr['tiwflowid']           = 25;
                $arr['title']               = $_POST['title'];
                $arr['description']         = $_POST['description'];
                $arr['priority']            = (int)$_POST['priority'];
                $arr['ttypeid']             = (int)$_POST['ttypeid'];
                $arr['ownertype']           = 'operator';
                $arr['ownerid']             = 40;
                $arr['source']              = 1;
                $arr['sourcevalue']         = __ROOT__;
                $arr['coordinatorName']     = Helper::getor_string($_SESSION['name'].' '.$_SESSION['name_khanevadegi'],__OWNER__);
                $arr['coordinatorMobile']   = __OWNERMOBILE__;
                $arr['vspid']               = __ASIATECHVSPID__;
                $result=false;
                $result                     = $GLOBALS['bs']->createTicket($arr);
                if(! $result) die(Helper::Json_Message('f'));
                    $arr['user_id']  = $_SESSION['id'];
                    $arr['errcode']  = $result['errcode'];
                    $arr['errmsg']   = $result['errmsg'];
                    $arr['ticketID'] = $result['data']['ticketID'];
                    $arr['tiid']     = $result['data']['tiid'];
                    $sql2            = Helper::Insert_Generator($arr,'bnm_oss_tickets');
                    $res2            = Db::secure_insert_array($sql2, $arr);
                    if($res2){
                        die($GLOBALS['bs']->getMessage($result));
                    }else{
                        $msg="متاسفانه درج اطلاعات تیکت با مشکل مواجه شد!";
                        die(Helper::Custom_Msg($GLOBALS['bs']->getMessageNormal($result).' '.$msg,1));
                    }
                   
                //die(json_encode($result));
            }else{
                die(Helper::Json_Message('na'));
            }
        }
        $this->view->home     = 'داشبورد';
        $this->view->page     = 'نمایندگی';
        $this->view->page_url = 'bitstream_operations';
        $this->view->pagename = 'bitstream_operations';
        $this->view->render('bitstream_operations', 'dashboard_template', '/public/js/bitstream_operations.js', false);
    }
}
