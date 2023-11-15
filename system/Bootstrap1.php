<?php defined('__ROOT__') or exit('No direct script access allowed');
//02176270588 user hamid factor adsk khorde dasti to ibs renew kardam
//02644267845
class Bootstrap
{
    public function __construct()
    {
        $_SESSION['dashboard_menu_names'] = Helper::get_all_dashboard_menu_names();
        //todo... check lock & unlock before apply lock or unlock in helper class

        if(isset($_POST['GetAllProvinces'])){
            if(! Helper::Login_Just_Check()) die(Helper::Json_Message('f'));
            $sql="SELECT * FROM bnm_ostan";
            $res=Db::fetchall_Query($sql);
            if(! $res) die(Helper::Json_Message('f'));
            die(json_encode($res,JSON_UNESCAPED_UNICODE));
        }

        if(isset($_POST['GetCityByProvince'])){
            if(! Helper::Login_Just_Check()) die(Helper::Json_Message('f'));
            $_POST = Helper::reformAjaxRequest($_POST);
            $sql="SELECT * FROM bnm_shahr shahr WHERE ostan_id = ?";
            $res=Db::secure_fetchall($sql, [$_POST['ostanid']]);
            if(! $res) die(Helper::Json_Message('f'));
            die(json_encode($res,JSON_UNESCAPED_UNICODE));
        }
        // if(isset($_POST['getcitybyprovince'])){
        //     die(json_encode($_POST));
        //     if(! Helper::Login_Just_Check()) die(Helper::Json_Message('f'));
        //     $_POST = Helper::reformAjaxRequest($_POST);
        //     $sql="SELECT * FROM bnm_shahr shahr WHERE ostan_id = ?";
        //     $res=Db::secure_fetchall($sql, [$_POST['ostanid']]);
        //     if(! $res) die(Helper::Json_Message('f'));
        //     die(json_encode($res,JSON_UNESCAPED_UNICODE));
        // }

        if(isset($_POST['GetTeleCenters'])){
            if(! Helper::Login_Just_Check()) die(Helper::Json_Message('f'));
            $_POST = Helper::reformAjaxRequest($_POST);
            $sql="SELECT tc.*,os.name ostan_faname, os.pish_shomare_ostan ostan_prenumber
                FROM bnm_telecommunications_center tc 
                INNER JOIN bnm_ostan os ON os.id = tc.ostan";
            // $res=Db::secure_fetchall($sql, [$_POST['shahrid']]);
            $res=Db::fetchall_Query($sql);
            if(! $res) die(Helper::Json_Message('f'));
            die(json_encode($res,JSON_UNESCAPED_UNICODE));
        }

        if(isset($_POST['GetTeleCenterByCity'])){
            if(! Helper::Login_Just_Check()) die(Helper::Json_Message('f'));
            $_POST = Helper::reformAjaxRequest($_POST);
            $sql="SELECT * FROM bnm_telecommunications_center telec WHERE shahr = ?";
            $res=Db::secure_fetchall($sql, [$_POST['shahrid']]);
            if(! $res) die(Helper::Json_Message('f'));
            die(json_encode($res,JSON_UNESCAPED_UNICODE));
        }

        if(isset($_POST['getallservicestatuses'])){
            $sql="SELECT * FROM shahkar_log WHERE requestname = ? AND response=?";
            $res=Db::secure_fetchall($sql, array('estservicestatus', 200));
            if($res){
                die(json_encode($res));
            }else{
                die(Helper::Json_Message('inf'));
            }
        }
        //get serviceinfo by service type (no user filter)
        if(isset($_POST['getServicesInfoWithServiceType'])){
            $_POST = Helper::reformAjaxRequest($_POST);
            (! $_POST['sertype'])? die(Helper::Json_Message('e')): '';
            $res=Helper::getServiceInfoByServiceType($_POST['sertype']);
            (! $res)? die(Helper::Custom_Msg('اطلاعاتی پیدا نشد')): '';
            die(json_encode($res));
        }
        //get serviceinfo by Multiple service types (no user filter)
        if(isset($_POST['getServicesInfoWithMultipleServiceTypes'])){
            $_POST = Helper::reformAjaxRequest($_POST);
            // die(json_encode($_POST));
            if(! isset($_POST['sertypes'])) die(Helper::Json_Message('e'));
            (! $_POST['sertypes'])? die(Helper::Json_Message('e')): '';
            $res=Helper::getServiceInfoByMultipleServiceTypes($_POST['sertypes']);
            if(! isset($res)) die(Helper::Json_Message('inf'));
            (! $res)? die(Helper::Custom_Msg('اطلاعاتی پیدا نشد')): '';
            die(json_encode($res));
        }

        //get get Port's Vpi Vci Vlan By Factorid
        if(isset($_POST['getAsiatechPortVpiVciVlanByFactorid'])){
            $_POST = Helper::reformAjaxRequest($_POST);
            (! $_POST['factorid'])? die(Helper::Json_Message('e')): '';
            $factor=Helper::getServiceInfoByFactorid($_POST['factorid']);
            (! $factor)? die(Helper::Custom_Msg('اطلاعاتی پیدا نشد')): '';
            $port=$GLOBALS['bs']->getPortID($factor[0]['ibsusername']);
            if(! Helper::checkAsiatechBitstreamResponse($port)){
                if(! $port['result']['errmsg']) die(Helper::Custom_Msg(Helper::Messages('absnr'),2));
                die(Helper::Custom_Msg($port['result']['errmsg']));
            }
            $vpi_vci_vlan=$GLOBALS['bs']->getInterfaceServicePort($port['result']['data']['portid']);
            if(! Helper::checkAsiatechBitstreamResponse($vpi_vci_vlan)) {
                if(! $vpi_vci_vlan['result']['errmsg']) die(Helper::Custom_Msg(Helper::Messages('absnr'),2));
                die(Helper::Custom_Msg($vpi_vci_vlan['result']['errmsg']));
            }
            
            // die(json_encode($vpi_vci_vlan));
            $msg="";
            $msg.="IP: ".$vpi_vci_vlan['result']['data']['ip']."<br/>";
            $msg.="LineProfile: ".$vpi_vci_vlan['result']['data']['lineprofile']."<br/>";
            $msg.="Port: ".$vpi_vci_vlan['result']['data']['port']."<br/>";
            $msg.="Shelf: ".$vpi_vci_vlan['result']['data']['shelf']."<br/>";
            $msg.="Slot: ".$vpi_vci_vlan['result']['data']['slot']."<br/>";
            $msg.="SubSlot: ".$vpi_vci_vlan['result']['data']['subslot']."<br/>";
            $msg.="ServicePort: "."<br/>";
            for ($i=0; $i <count($vpi_vci_vlan['result']['data']['servicePort']) ; $i++) { 
                $msg.='Vpi: '.$vpi_vci_vlan['result']['data']['servicePort'][$i]['vpi']." ";
                $msg.='Vci: '.$vpi_vci_vlan['result']['data']['servicePort'][$i]['vci']." ";
                $msg.='Vlan: '.$vpi_vci_vlan['result']['data']['servicePort'][$i]['vlan']." ";
                $msg.="<br/>";
            }
            // die(Helper::Json_Message('test2'));
            // die(json_encode(Helper::Custom_Msg('asdsad', 1),JSON_UNESCAPED_UNICODE));
            die(Helper::Custom_Msg($msg,1));


        }

        if(isset($_POST['currentuserservicesinfo'])){
            if($_SESSION['user_type'] === (string) __MOSHTARAKUSERTYPE__){
                // die(json_encode([$_SESSION['user_id']]));
                    $services=Helper::getServiceInfoBySubid($_SESSION['user_id']);
                    if(! $services) die(json_encode(false));
                    for ($i=0; $i <count($services) ; $i++) {
                        switch ($services[$i]['sertype']) {
                            case 'adsl':
                            case 'vdsl':
                            case 'bitstream':
                            case 'wireless':
                            case 'tdlte':
                                $ibs=$GLOBALS['ibs_internet']->getUserInfoByNormalUserName($services[$i]['ibsusername']);
                                if(Helper::checkIbsUserInfo($ibs)){
                                    $ibs=Helper::reformIbsUserInfo($ibs);
                                    $services[$i]['ibsinfo']=$ibs;
                                }else{
                                    $services[$i]['ibsinfo']=false;
                                }
                                if($services[$i]['ibsinfo']){
                                    $services[$i]['ibsinfo']['basic_info']['nearest_exp_date']=Helper::tabdileTarikh($services[$i]['ibsinfo']['basic_info']['nearest_exp_date'], 1, '-', '/', false);
                                    $services[$i]['ibsinfo']['basic_info']['credit']=str_replace('.', ',', Helper::byteConvert((int) Helper::toByteSize((string)$services[$i]['ibsinfo']['basic_info']['credit'] . 'MB')));
                                    

                                }
                            break;
                            case 'voip':
                                $ibs=$GLOBALS['ibs_voip']->getUserInfoByVoipUserName($services[$i]['ibsusername']);
                                if(Helper::checkIbsUserInfo($ibs)){
                                    $ibs=Helper::reformIbsUserInfo($ibs);
                                    $services[$i]['ibsinfo']=$ibs;
                                }else{
                                    $services[$i]['ibsinfo']=false;
                                }
                                if($services[$i]['ibsinfo']){
                                    $services[$i]['ibsinfo']['basic_info']['nearest_exp_date']=Helper::tabdileTarikh($services[$i]['ibsinfo']['basic_info']['nearest_exp_date'], 1, '-', '/', false);
                                    $services[$i]['ibsinfo']['basic_info']['credit']=number_format($services[$i]['ibsinfo']['basic_info']['credit'])." "."تومان";
                                }
                            break;
                            default:
                                $services[$i]['ibsinfo']=false;
                            break;
                        }
                        $services[$i]['sertype']=strtoupper($services[$i]['sertype']);
                        
                    }
                    die(json_encode($services));
            }else{
                die(json_encode(false));
            } 
            
        }

        if(isset($_POST['getServiceIbsInfoByFactorid'])){
            $_POST = Helper::reformAjaxRequest($_POST);
            $res=false;
            if(! isset($_POST['factorid'])) die(Helper::Custom_Msg('اطلاعات سرویس یافت نشد.'));
            if(! $_POST['factorid']) die(Helper::Custom_Msg('اطلاعات سرویس یافت نشد.'));
            $factor=Helper::getServiceInfoByFactorid($_POST['factorid']);
            if(! $factor) die(Helper::Custom_Msg('اطلاعات سرویس یافت نشد.'));
            if(! $factor[0]['ibsusername']) die(Helper::Custom_Msg('اطلاعات سرویس یافت نشد.'));
            switch ($factor[0]['sertype']) {
                case 'bitstream':
                case 'adsl':
                case 'vdsl':
                case 'wireless':
                case 'tdlte':
                    $res= $GLOBALS['ibs_internet']->getUserInfoByNormalUserName($factor[0]['ibsusername']);
                    if(! Helper::checkIbsUserInfo($res)) die(Helper::Custom_Msg('اطلاعات سرویس در اکانتینگ یافت نشد'));
                    $res=Helper::reformIbsUserInfo($res);
                    $factor[0]['ibsinfo']=$res;
                    $factor[0]['ibsinfo']['basic_info']['credit']=str_replace('.', ',', Helper::byteConvert((int) Helper::toByteSize((string)$factor[0]['ibsinfo']['basic_info']['credit'] . 'MB')));
                break;
                case 'voip':
                    $res= $GLOBALS['ibs_voip']->getUserInfoByVoipUserName($factor[0]['ibsusername']);
                    if(! Helper::checkIbsUserInfo($res)) die(Helper::Custom_Msg('اطلاعات سرویس در اکانتینگ یافت نشد'));
                    $res=Helper::reformIbsUserInfo($res);
                    $factor[0]['ibsinfo']=$res;
                    $factor[0]['ibsinfo']['basic_info']['credit']=number_format($factor[0]['ibsinfo']['basic_info']['credit'], 0 );
                    
                break;
                default:
                    die(Helper::Custom_Msg('امکان دریافت اطلاعات این سرویس از اکانتینگ وجود ندارد'));
                break;
            }
            $tmp=[];
            $datearr=[];
            $factor[0]['ibsinfo']['basic_info']['creation_date']=Helper::tabdileTarikh($factor[0]['ibsinfo']['basic_info']['creation_date']);
            if(isset($factor[0]['ibsinfo']['basic_info']['nearest_exp_date'])){
                $datearr=Helper::dateConvertInitialize($factor[0]['ibsinfo']['basic_info']['nearest_exp_date'],'-',false);
                $flag=Helper::isSeperatedDateGregorian($datearr);
                if($flag){
                    //tarikh miladi ast
                    $factor[0]['ibsinfo']['en_expireation_date']=$factor[0]['ibsinfo']['basic_info']['nearest_exp_date'];
                    $factor[0]['ibsinfo']['basic_info']['nearest_exp_date']=Helper::tabdileTarikh($factor[0]['ibsinfo']['basic_info']['nearest_exp_date']);
                    $factor[0]['ibsinfo']['fa_expireation_date']=$factor[0]['ibsinfo']['basic_info']['nearest_exp_date'];
                }else{
                    //tarikh miladi ast
                }
                
                
                
            }
            if(isset($factor[0]['ibsinfo']['attrs']['nearest_exp_date'])){
                $factor[0]['ibsinfo']['attrs']['nearest_exp_date']=Helper::tabdileTarikh($factor[0]['ibsinfo']['attrs']['nearest_exp_date']);
            }
            if(isset($factor[0]['ibsinfo']['attrs']['abs_exp_date'])){
                $factor[0]['ibsinfo']['attrs']['abs_exp_date']=Helper::tabdileTarikh($factor[0]['ibsinfo']['attrs']['abs_exp_date']);
            }
            if(isset($factor[0]['ibsinfo']['attrs']['real_first_login'])){
                $factor[0]['ibsinfo']['attrs']['real_first_login']=Helper::tabdileTarikh($factor[0]['ibsinfo']['attrs']['real_first_login']);
            }
            if(isset($factor[0]['ibsinfo']['attrs']['first_login'])){
                $factor[0]['ibsinfo']['attrs']['first_login']=Helper::tabdileTarikh($factor[0]['ibsinfo']['attrs']['first_login']);
            }
            die(json_encode($factor));
        }

        if(isset($_POST['getServicePasswordByFactorid'])){
            $_POST = Helper::reformAjaxRequest($_POST);
            $res=false;
            if(! isset($_POST['factorid'])) die(Helper::Custom_Msg('اطلاعات سرویس یافت نشد.'));
            if(! $_POST['factorid']) die(Helper::Custom_Msg('اطلاعات سرویس یافت نشد.'));
            $factor=Helper::getServiceInfoByFactorid($_POST['factorid']);
            if(! $factor) die(Helper::Custom_Msg('اطلاعات سرویس یافت نشد.'));
            if(! $factor[0]['ibsusername']) die(Helper::Custom_Msg('اطلاعات سرویس یافت نشد.'));
            switch ($factor[0]['sertype']) {
                case 'bitstream':
                case 'adsl':
                case 'vdsl':
                case 'wireless':
                case 'tdlte':
                     $res= $GLOBALS['ibs_internet']->getUserInfoByNormalUserName($factor[0]['ibsusername']);
                break;
                case 'voip':
                    $res= $GLOBALS['ibs_voip']->getUserInfoByVoipUserName($factor[0]['ibsusername']);
                    die(json_encode($res));        
                    break;
                default:
                    die(Helper::Custom_Msg('امکان دریافت اطلاعات این سرویس از اکانتینگ وجود ندارد'));
                break;
            }
            if(! $res) die(Helper::Custom_Msg('اطلاعات سرویس در اکانتینگ یافت نشد'));
            if(! isset($res[1])) die(Helper::Custom_Msg('اطلاعات سرویس در اکانتینگ یافت نشد'));
            if(! $res[1]) die(Helper::Custom_Msg('اطلاعات سرویس در اکانتینگ یافت نشد'));
            $res=Helper::reformIbsUserInfo($res);
            die(json_encode(['password'=>$res['attrs']['normal_password']],JSON_UNESCAPED_UNICODE));
        }
        if(isset($_POST['checkServiceIbsInfoByFactorid'])){
            $_POST = Helper::reformAjaxRequest($_POST);
            $res=false;
            if(! isset($_POST['factorid'])) die(Helper::Custom_Msg('اطلاعات سرویس یافت نشد.'));
            if(! $_POST['factorid']) die(Helper::Custom_Msg('اطلاعات سرویس یافت نشد.'));
            $factor=Helper::getServiceInfoByFactorid($_POST['factorid']);
            if(! $factor) die(Helper::Custom_Msg('اطلاعات سرویس یافت نشد.'));
            if(! $factor[0]['ibsusername']) die(Helper::Custom_Msg('اطلاعات سرویس یافت نشد.'));
            switch ($factor[0]['sertype']) {
                case 'bitstream':
                case 'adsl':
                case 'vdsl':
                case 'wireless':
                case 'tdlte':
                    $service_group_type='internet';
                    $res= $GLOBALS['ibs_internet']->getUserInfoByNormalUserName($factor[0]['ibsusername']);
                break;
                case 'voip':
                    $service_group_type='voip';
                    $res= $GLOBALS['ibs_voip']->getUserInfoByVoipUserName($factor[0]['ibsusername']);
                    break;
                default:
                    die(Helper::Custom_Msg('امکان دریافت اطلاعات این سرویس از اکانتینگ وجود ندارد'));
                break;
            }
            if(! $res) die(Helper::Custom_Msg('اطلاعات سرویس در اکانتینگ یافت نشد'));
            if(! isset($res[1])) die(Helper::Custom_Msg('اطلاعات سرویس در اکانتینگ یافت نشد'));
            if(! $res[1]) die(Helper::Custom_Msg('اطلاعات سرویس در اکانتینگ یافت نشد'));
            $res=Helper::reformIbsUserInfo($res);
            if(! $res) die(Helper::Custom_Msg("سرویس انتخاب شده با این نام کاربری در اکانتینگ وجود نداشت"));
            die(json_encode(['service_group_type'=>$service_group_type,'user_id'=>$res['basic_info']['user_id']],JSON_UNESCAPED_UNICODE));
        }

        if(isset($_POST['getnoemasrafbyfactorid'])){
            $_POST = Helper::reformAjaxRequest($_POST);
            $res=false;
            if(! isset($_POST['factorid'])) die(Helper::Custom_Msg('اطلاعات سرویس یافت نشد.'));
            if(! $_POST['factorid']) die(Helper::Custom_Msg('اطلاعات سرویس یافت نشد.'));
            $factor=Helper::getServiceInfoByFactorid($_POST['factorid']);
            if(! $factor) die(Helper::Custom_Msg('اطلاعات سرویس یافت نشد.'));
            if(! $factor[0]['ibsusername']) die(Helper::Custom_Msg('اطلاعات سرویس یافت نشد.'));
            switch ($factor[0]['sertype']) {
                case 'bitstream':
                case 'adsl':
                case 'vdsl':
                case 'wireless':
                case 'tdlte':
                    $service_group_type='internet';
                    $sql="SELECT * FROM bnm_connection_log";
                    $noemasraf= Db::fetchall_Query($sql);
                    $res= $GLOBALS['ibs_internet']->getUserInfoByNormalUserName($factor[0]['ibsusername']);
                break;
                case 'voip':
                    $service_group_type='voip';
                    $sql="SELECT * FROM bnm_connection_log WHERE name = ?";
                    $noemasraf= Db::secure_fetchall($sql, ['All']);
                    $res= $GLOBALS['ibs_voip']->getUserInfoByVoipUserName($factor[0]['ibsusername']);
                    break;
                default:
                    die(Helper::Custom_Msg('امکان دریافت اطلاعات این سرویس از اکانتینگ وجود ندارد'));
                break;
            }
            if(! $res) die(Helper::Custom_Msg('اطلاعات سرویس در اکانتینگ یافت نشد'));
            if(! isset($res[1])) die(Helper::Custom_Msg('اطلاعات سرویس در اکانتینگ یافت نشد'));
            if(! $res[1]) die(Helper::Custom_Msg('اطلاعات سرویس در اکانتینگ یافت نشد'));
            $res=Helper::reformIbsUserInfo($res);
            if(! $res) die(Helper::Custom_Msg("سرویس انتخاب شده با این نام کاربری در اکانتینگ وجود نداشت"));
            
            die(json_encode(['service_group_type'=>$service_group_type, 'user_id'=>$res['basic_info']['user_id'],'noe_masraf'=>$noemasraf],JSON_UNESCAPED_UNICODE));
        }

        if(isset($_POST['getInternetUsersServicesInfo'])){
            $res=Helper::getInternetUsersServicesInfo();
            if(! $res){
                die(Helper::Json_Message('e'));
            }
            die(json_encode($res,JSON_UNESCAPED_UNICODE));
        }
        if(isset($_POST['getAllUsersServicesInfo'])){
            $res=Helper::getAllUsersServicesInfo();
            if(! $res){
                die(Helper::Json_Message('e'));
            }
            die(json_encode($res,JSON_UNESCAPED_UNICODE));
        }

        if(isset($_POST['ipassign_getservicesinfobysertypeandsubid'])){
            $_POST=Helper::reformAjaxRequest($_POST);
            $_POST=Helper::xss_check_array($_POST);
            if(! isset($_POST['sertype'])) die(Helper::Custom_Msg(Helper::Messages('inf')));
            if(! isset($_POST['subid'])) die(Helper::Custom_Msg(Helper::Messages('inf')));
            if(! $_POST['sertype'] || ! $_POST['subid']) die(Helper::Custom_Msg(Helper::Messages('inf')));
            $res=Helper::getServiceInfoByServiceTypeAndSubid($_POST['subid'], $_POST['sertype']);
            // $arr=[];
            if(! $res){
                // $arr['noservice']
                
                die(json_encode(false));
            }else{
                die(json_encode($res,JSON_UNESCAPED_UNICODE));
            }
            // if(! $res) die(Helper::Json_Message('ndf'));
            // die(json_encode($res,JSON_UNESCAPED_UNICODE));
        }

        if(isset($_POST['get_ips_by_poolid'])){
            $_POST = Helper::reformAjaxRequest($_POST);
            if(isset($_POST['poolid'])){             
                // $sql="SELECT
                    // ip.id,
                    // IF( ip.gender = '1', 'Valid', 'Invalid' ) gender,
                    // IF( ip.iptype = '1', 'Static', 'Dynamic' ) iptype,
                //     ip.ip
                // FROM bnm_ip ip
                //     INNER JOIN bnm_ip_pool_list pool ON ip.pool = pool.id
                // WHERE ip.pool= ?
                //     ORDER BY ip.ip ASC";
                // $sql="SELECT * 
                //         FROM (SELECT
                //             ip.id,
                //             ip.ip,
                //             IF( ip.gender = '1', 'Valid', 'Invalid' ) gender,
                //             IF( ip.iptype = '1', 'Static', 'Dynamic' ) iptype,
                //             ipass.ip ipid
                //         FROM
                //             bnm_ip ip
                //             INNER JOIN bnm_ip_pool_list pool ON ip.pool = pool.id
                //             LEFT JOIN bnm_ip_assign ipass ON ipass.ip = ip.id 
                //             WHERE ip.pool= ?
                //         ) tmp
                //         WHERE
                //             ipid IS NULL 
                //             OR ipid = ''";
                $sql= "SELECT ip.id,
                ip.ip,
                IF( ip.gender = '1', 'Valid', 'Invalid' ) gender,
                IF( ip.iptype = '1', 'Static', 'Dynamic' ) iptype
                FROM bnm_ip ip
                WHERE ip.id NOT IN (SELECT ip from bnm_ip_assign)
                AND ip.pool = ?";
                $res=Db::secure_fetchall($sql, array($_POST['poolid']));
                if(! $res){
                    die(Helper::Custom_Msg('آی پی یافت نشد'));
                }
                die(json_encode($res,JSON_UNESCAPED_UNICODE));
            }
            die(Helper::Custom_Msg('Ip Pool یافت نشد'));
        }

        
        if(isset($_POST['getInternetServiceTypesByUserid'])){
            $_POST = Helper::reformAjaxRequest($_POST);
            $_POST = Helper::xss_check_array($_POST);
            (! $_POST)? die(Helper::Custom_Msg(Helper::Messages('e'),2)):'';
            (! $_POST['subid'])? die(Helper::Custom_Msg(Helper::Messages('inf'),2)):'';
            // $services=Helper::getInternetServiceTypesByUserid($_POST['subid']);
            $services=Helper::getInternetServiceTypesByUserid($_POST['subid']);
            // die(json_encode($services));
            $arr=[];
            $arr[0]=['sertype'=>'bandwidth', 'display_sertype'=> strtoupper('bandwidth')];
            if(! $services){
                die(json_encode($arr));
            }
            $arr=[];
            $bwi=count($services)+1;
            // $services[$bwindex]=
            for ($i=0; $i < count($services) ; $i++) { 
                $services[$i]['display_sertype']=strtoupper($services[$i]['sertype']);
            }
            $services[$bwi]['sertype']='bandwidth';
            $services[$bwi]['display_sertype']=strtoupper('bandwidth');
            die(json_encode($services, JSON_UNESCAPED_UNICODE));
            
            // if(isset($_POST['poolid'])){             
            //     $sql="SELECT
            //         ip.id,
            //         IF( ip.gender = '1', 'Valid', 'Invalid' ) gender,
            //         IF( ip.iptype = '1', 'Static', 'Dynamic' ) iptype,
            //         ip.ip
            //     FROM bnm_ip ip
            //         INNER JOIN bnm_ip_pool_list pool ON ip.pool = pool.id
            //     WHERE ip.pool= ?
            //         ORDER BY ip.ip ASC";
            //     $res=Db::secure_fetchall($sql, array($_POST['poolid']));
            //     if(! $res){
            //         die(Helper::Custom_Msg('آی پی یافت نشد'));
            //     }
            //     die(json_encode($res,JSON_UNESCAPED_UNICODE));
            // }
            // die(Helper::Custom_Msg('Ip Pool یافت نشد'));
        }

        if(isset($_POST['get_all_ippools'])){
            $sql="SELECT * FROM bnm_ip_pool_list";
            $res=Db::fetchall_Query($sql);
            if(! $res) {
                $msg1='خطا در برنامه:';
                $msg2="مشکل در دریافت IP Pool";
                die(Helper::Custom_Msg($msg1.'<br/>'.$msg2,2));
            }
            die(json_encode($res,JSON_UNESCAPED_UNICODE));
        }

        if(isset($_POST['send_suspensions'])){
            $_POST = Helper::Create_Post_Array_Without_Key($_POST);
            if(Helper::Login_Just_Check()){
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                        if(! isset($_POST['time']) || ! isset($_POST['sub']) || ! isset($_POST['service']) || ! isset($_POST['tozihat']) || ! isset($_POST['operationtype'])){
                            die(Helper::Custom_Msg(Helper::Messages('inf'), 2));
                        }
                        if($_POST['operationtype']==="1"){
                            //Azad
                            $res=Helper::unlockWithLog($_POST['operationtype'], $_POST['service'], $_POST['tozihat']);
                            // die(json_encode('asdsad'));
                            if(! $res){
                                die(Helper::Json_Message('e'));
                            }else{
                                die(Helper::displayPredefiendMessage($res));
                            }
                        }else {
                            //masdod
                            $res=Helper::lockWithLog($_POST['operationtype'], $_POST['service'], $_POST['time'], $_POST['tozihat']);
                            if(! $res){
                                die(Helper::Json_Message('e'));
                            }else{
                                die(Helper::displayPredefiendMessage($res));
                            }
                        }
                    break;
                    default:
                        die(Helper::Json_Message('f'));
                    break;
                }
            }
        }

        if(isset($_POST['getallsubscribers'])){
            $res=Helper::getAllUsers();
            ($res) ? die(json_encode($res,JSON_UNESCAPED_UNICODE)) : die(Helper::Json_Message('f'));
        }
        if(isset($_POST['getuserservices'])){
            // die(json_encode($_POST['getalluserservices']['user_id']));
            $res=Helper::getUserServices($_POST['getuserservices']['user_id'], $_POST['getuserservices']['sertype']);
            if($res){
                die(json_encode($res,JSON_UNESCAPED_UNICODE));
            }else{
                die(Helper::Json_Message('f'));
            }
        }


        if(isset($_POST['currentuserecredit'])){
            if(Helper::Login_Just_Check()){
                    $res=Helper::getUserCurrentCredit();
                    if(isset($res)){
                        if($res){
                            die(json_encode($res));
                        }else{
                            die(Helper::Json_Message('f'));
                        }
                    }else{
                        die(Helper::Json_Message('f'));
                    }
            }else{
                die(Helper::Json_Message('f'));
            }
        }

        if(isset($_POST['currentuserestauth'])){
            if(Helper::Login_Just_Check()){
                $res=Helper::checkEstAuthSub($_SESSION['user_id']);
                if(! $res) die(json_encode(['HasError'=>true,'Message'=>'احراز هویت نشده']));
                if($res) die(json_encode(['HasError'=>false,'Message'=>'احراز هویت موفق']));
            }else{
                die(Helper::Json_Message('f'));
            }
        }
        
        if(isset($_POST['estauthsub'])){
            if(isset($_POST['estauthsub']['subid'])){
                if($_POST['estauthsub']['subid']){
                    $res=ShahkarHelper::estAuthSub($_POST['estauthsub']['subid']);
                    if($res){
                        $msg="شناسه استعلام: ".$res;
                        die(Helper::Custom_Msg($msg,1));
                        
                    }else{
                        die(Helper::Json_Message('f'));    
                    }
                    // die(json_encode($res));
                    // die(Helper::Custom_Msg($res['response'],2));
                }else{
                    die(Helper::Json_Message('f'));
                }
            }else{
                die(Helper::Json_Message('f'));
            }
        }

        if(isset($_POST['factorshahkar'])){
            if(isset($_POST['factorshahkar']['factorid'])){
                if($_POST['factorshahkar']['factorid']){
                    $res=ShahkarHelper::putServices($_POST['factorshahkar']['factorid']);
                    // die(json_encode($res));
                    if($res){
                        $msg="شناسه : ".$res;
                        die(Helper::Custom_Msg($msg,1));
                        
                    }else{
                        die(Helper::Json_Message('f'));    
                    }
                    // die(json_encode($res));
                    // die(Helper::Custom_Msg($res['response'],2));
                }else{
                    die(Helper::Json_Message('f'));
                }
            }else{
                die(Helper::Json_Message('f'));
            }
        }
                /////////////////factorha edit modal forms
                if (isset($_POST['send_ft_adsl_update_status'])) {
                    $_POST = Helper::Create_Post_Array_Without_Key($_POST);
                    switch ($_SESSION['user_type']) {
                        case __MOSHTARAKUSERTYPE__:
                            die(Helper::Json_Message('na'));
                            break;
                    }
                    // die(json_encode($_POST));
                    // $_POST = Helper::xss_check_array($_POST);
                    $unset_array = array(
                        "noe_khadamat", "terafik", "zaname_estefade_be_tarikh", "tarikhe_shoroe_service", "tarikhe_payane_service",
                        "gheymate_service", "takhfif", "hazine_ranzhe", "hazine_dranzhe", "hazine_nasb", "abonmane_port", "abonmane_faza", "abonmane_tajhizat",
                        "darsade_avareze_arzeshe_afzode", "maliate_arzeshe_afzode", "mablaghe_ghabele_pardakht"
                    );
                    for ($i = 0; $i < count($unset_array); $i++) {
                        if (isset($_POST[$unset_array[$i]])) {
                            unset($_POST[$unset_array[$i]]);
                        }
                    }
                    $sql = Helper::Update_Generator($_POST, 'bnm_factor', "WHERE id = :id");
                    $res = Db::secure_update_array($sql, $_POST);
                    if($res){
                        die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                    }else{
                        die(Helper::Custom_Msg(Helper::Messages('f'), 2));
                    }
                    //die(json_encode($_POST));
                }
                if (isset($_POST['send_ft_wireless_update_status'])) {
                    $_POST = Helper::Create_Post_Array_Without_Key($_POST);
                    switch ($_SESSION['user_type']) {
                        case __MOSHTARAKUSERTYPE__:
                            die(Helper::Json_Message('na'));
                            break;
                    }
                    // $_POST = Helper::xss_check_array($_POST);
                    $unset_array = array(
                        "noe_khadamat", "terafik", "zaname_estefade_be_tarikh", "tarikhe_shoroe_service", "tarikhe_payane_service",
                        "gheymate_service", "takhfif", "hazine_ranzhe", "hazine_dranzhe", "hazine_nasb", "abonmane_port", "abonmane_faza", "abonmane_tajhizat",
                        "darsade_avareze_arzeshe_afzode", "maliate_arzeshe_afzode", "mablaghe_ghabele_pardakht"
                    );
                    for ($i = 0; $i < count($unset_array); $i++) {
                        if (isset($_POST[$unset_array[$i]])) {
                            unset($_POST[$unset_array[$i]]);
                        }
                    }
                    $sql = Helper::Update_Generator($_POST, 'bnm_factor', "WHERE id = :id");
                    $res = Db::secure_update_array($sql, $_POST);
                    if($res){
                        die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                    }else{
                        die(Helper::Custom_Msg(Helper::Messages('f'), 2));
                    }
                    //            die(json_encode($_POST));
                }
                if (isset($_POST['send_ft_tdlte_update_status'])) {
                    $_POST = Helper::Create_Post_Array_Without_Key($_POST);
                    switch ($_SESSION['user_type']) {
                        case __MOSHTARAKUSERTYPE__:
                            die(Helper::Json_Message('na'));
                            break;
                    }
                    // $_POST = Helper::xss_check_array($_POST);
                    $unset_array = array(
                        "noe_khadamat", "terafik", "zaname_estefade_be_tarikh", "tarikhe_shoroe_service", "tarikhe_payane_service",
                        "gheymate_service", "takhfif", "hazine_ranzhe", "hazine_dranzhe", "hazine_nasb", "abonmane_port", "abonmane_faza", "abonmane_tajhizat",
                        "darsade_avareze_arzeshe_afzode", "maliate_arzeshe_afzode", "mablaghe_ghabele_pardakht"
                    );
                    for ($i = 0; $i < count($unset_array); $i++) {
                        if (isset($_POST[$unset_array[$i]])) {
                            unset($_POST[$unset_array[$i]]);
                        }
                    }
                    $sql = Helper::Update_Generator($_POST, 'bnm_factor', "WHERE id = :id");
                    $res = Db::secure_update_array($sql, $_POST);
                    if($res){
                        die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                    }else{
                        die(Helper::Custom_Msg(Helper::Messages('f'), 2));
                    }
                    //            die(json_encode($_POST));
                }
                if (isset($_POST['send_ft_voip_update_status'])) {
                    $_POST = Helper::Create_Post_Array_Without_Key($_POST);
                    switch ($_SESSION['user_type']) {
                        case __MOSHTARAKUSERTYPE__:
                            die(Helper::Json_Message('na'));
                            break;
                    }
                    // $_POST = Helper::xss_check_array($_POST);
                    $unset_array = array(
                        "pin_code", "noe_khadamat", "terafik", "zaname_estefade_be_tarikh", "tarikhe_shoroe_service", "tarikhe_payane_service",
                        "gheymate_service", "takhfif", "hazine_ranzhe", "hazine_dranzhe", "hazine_nasb", "abonmane_port", "abonmane_faza", "abonmane_tajhizat",
                        "darsade_avareze_arzeshe_afzode", "maliate_arzeshe_afzode", "mablaghe_ghabele_pardakht"
                    );
                    for ($i = 0; $i < count($unset_array); $i++) {
                        if (isset($_POST[$unset_array[$i]])) {
                            unset($_POST[$unset_array[$i]]);
                        }
                    }
                    $sql = Helper::Update_Generator($_POST, 'bnm_factor', "WHERE id = :id");
                    $res = Db::secure_update_array($sql, $_POST);
                    if($res){
                        die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                    }else{
                        die(Helper::Custom_Msg(Helper::Messages('f'), 2));
                    }
                    //            die(json_encode($_POST));
                }
        if (isset($_POST['send_administration_online_report'])) {
            $_POST = Helper::Create_Post_Array_Without_Key($_POST);
            $_POST = Helper::xss_check_array($_POST);
            if ($_POST['servicetype'] === "internet") {
                $res = $GLOBALS['ibs_internet']->getOnlineUsers();
                die(json_encode($res));
                if(! Helper::checkIbsResultExist($res)){
                    die(Helper::Custom_Msg("اطلاعاتی برای نمایش وجود ندارد.", 2));
                }
                die(json_encode($res));
                $res = Helper::ibsOnlineuserFilterInitialize($res);
                // $res['servicetype']="internet";
                die(json_encode($res));
            } elseif ($_POST['servicetype'] === "voip") {
                // $res=$GLOBALS['ibs_voip']->getUserIdByVoipUsername('02122074852');
                // $res = $GLOBALS['ibs_voip']->searchUserOnlines();
                // $res = $GLOBALS['ibs_voip']->getAllInternetOnlineUsers();
                // $res = $GLOBALS['ibs_voip']->getAllVoipOnlineUsers();
                // die(json_encode($res));
                // $res['voip']="internet";
                die(Helper::Custom_Msg(Helper::Messages('inf'), 2));
            } else {
                die(Helper::Custom_Msg(Helper::Messages('f'), 2));
            }
        }
        if (isset($_POST['checkprevfactor'])) {
            $_POST = Helper::reformAjaxRequest($_POST);
            $res = Helper::checkNormalPreviousFactorExist($_POST['subid'], $_POST['emkanatid'], $_POST['servicetype']);
            die(json_encode($res));
        }
        if (isset($_POST['send_change_service_password'])) {
            $_POST = Helper::Create_Post_Array_Without_Key($_POST);
            $_POST = Helper::xss_check_array($_POST);
            unset($_POST['send_change_service_password']);
            unset($_POST['currentpassword']);
            $checkvalues= Helper::allArrayElementsHasValue($_POST);
            if(! $checkvalues){
                $msg="هیچ فیلدی نباید خالی ارسال شود";
                die(json_encode(Helper::Custom_Msg($msg),JSON_UNESCAPED_UNICODE));
            }
            $res_factor=Helper::getServiceInfoByFactorid($_POST['service']);
            if(! $res_factor){
                $msg="خطای سیستمی! اطلاعات سرویس انتخاب شده یافت نشد لطفا با پشتیبانی تماس بگیرید";
                die(json_encode(Helper::Custom_Msg($msg),JSON_UNESCAPED_UNICODE));
            }
            if(! $res_factor) die(Helper::Custom_Msg('اطلاعات سرویس یافت نشد با پشتیبانی تماس بگیرید'));
            if(! $res_factor[0]['ibsusername']) die(Helper::Custom_Msg('اطلاعات سرویس یافت نشد با پشتیبانی تماس بگیرید'));
            // die(json_encode($res_factor));
            switch ($res_factor[0]['sertype']) {
                    case 'adsl':
                    case 'vdsl':
                    case 'bitstream':
                    case 'wireless':
                    case 'tdlte':
                        $res_usrid = $GLOBALS['ibs_internet']->getUserIdByNormalUsername($res_factor[0]['ibsusername']);
                        $res = $GLOBALS['ibs_internet']->setNormalUserAuth((string) $res_usrid[1], $res_factor[0]['ibsusername'], $_POST['newpassword']);
                        $userinfo = $GLOBALS['ibs_internet']->getUserInfoByNormalUserName($res_factor[0]['ibsusername']);
                        break;
                    case 'voip':
                        die(Helper::Json_Message('e'));
                        $res_usrid = $GLOBALS['ibs_internet']->getUserIdByVoipUsername($res_factor[0]['ibsusername']);
                        $res = $GLOBALS['ibs_voip']->setVoipUserAuth((string) $res_usrid, $res_factor[0]['ibsusername'], $_POST[0]['newpassword']);
                        $userinfo = $GLOBALS['ibs_internet']->getUserInfoByViopUserName($res_factor[0]['ibsusername']);
                        break;
                    default:
                        die(Helper::Json_Message('f'));
                        break;
                }
                if(! $userinfo) die(Helper::Json_Message('e'));
                //todo... send sms to user
                $smsmessage=__OWNER__." ";
                $smsmessage.="نام کاربری سرویس:"." ";
                $smsmessage.=$res_factor[0]['ibsusername']." ";
                $smsmessage.="رمز عبور جدید:"." ";
                $smsmessage.=$_POST['newpassword'];
                $sms=Helper::Send_Sms_Single($res_factor[0]['telephone_hamrah'], $smsmessage);
                $msg="نام کاربری سرویس:"." ";
                $msg.=$res_factor[0]['ibsusername']." ";
                $msg.="رمز عبور جدید:"." ";
                $msg.=$_POST['newpassword'];
                die(Helper::Custom_Msg(Helper::Messages('s')." ".$msg, 1));
            // if($_POST['new_password'] && $_POST[''])
            // if (isset($_POST['ibsusername']) && isset($_POST['noeservice']) && isset($_POST['userid']) && isset($_POST['newpassword'])) {
            //     switch ($_SESSION['user_type']) {
            //         case __ADMINUSERTYPE__:
            //         case __ADMINOPERATORUSERTYPE__:
            //         case __MODIRUSERTYPE__:
            //         case __MODIR2USERTYPE__:
            //         case __OPERATOR2USERTYPE__:
            //         case __OPERATORUSERTYPE__:
            //             //niazi nist kari anjam she
            //             break;
            //         case __MOSHTARAKUSERTYPE__:
            //             $_POST['userid'] = $_SESSION['user_id'];
            //             break;
            //     }
            //     switch ($_POST['noeservice']) {
            //         case 'adsl':
            //         case 'vdsl':
            //         case 'bitstream':
            //         case 'wireless':
            //         case 'tdlte':
            //             $res_usrid = $GLOBALS['ibs_internet']->getUserIdByNormalUsername($_POST['ibsusername']);
            //             $res = $GLOBALS['ibs_internet']->setNormalUserAuth((string) $res_usrid[1], $_POST['ibsusername'], $_POST['newpassword']);
            //             break;
            //         case 'voip':
            //             $res_usrid = $GLOBALS['ibs_internet']->getUserIdByVoipUsername($_POST['ibsusername']);
            //             $res = $GLOBALS['ibs_voip']->setVoipUserAuth((string) $res_usrid[1], $_POST['ibsusername'], $_POST['newpassword']);
            //             break;
            //         default:
            //             die(Helper::Json_Message('f'));
            //             break;
            //     }
            //     if (isset($res)) {
            //         die(Helper::Custom_Msg(Helper::Messages('s'), 1));
            //     } else {
            //         die(Helper::Json_Message('f'));
            //     }

            // }
        }
        if (isset($_POST['State'])) {
            $sql = "SELECT * FROM bnm_sep_payment WHERE resnum = ?";
            $payment = Db::secure_fetchall($sql, [$_POST['ResNum']]);
            switch ($_POST['State']) {
                case 'OK':
                    $sql = "SELECT count(*) as rows_num FROM bnm_sep_payment WHERE refnum = ?";
                    $result = Db::secure_fetchall($sql, array($_POST['RefNum']));
                    if ($result[0]['rows_num'] === 0) {
                        $client = new nusoap_client('https://verify.sep.ir/payments/referencepayment.asmx?wsdl');
                        $err = $client->getError();
                        $res_verify = $client->call('VerifyTransaction', [
                            'RefNum' => $_POST['RefNum'],
                            'MID' => '11604173',
                        ]);
                        die(print_r($res_verify));
                        if (isset($res_verify) && !$err) {
                            if ($res_verify === $payment[0]['amount']) {
                                $arr = array();
                                $arr['id'] = $payment[0]['id'];
                                $arr['state'] = $_POST['State'];
                                $arr['status'] = $_POST['Status'];
                                $arr['resnum'] = $_POST['ResNum'];
                                $arr['refnum'] = $_POST['RefNum'];
                                $arr['cid'] = $_POST['CID'];
                                $arr['traceno'] = $_POST['TRACENO'];
                                $arr['rrn'] = $_POST['RRN'];
                                $arr['amount'] = $_POST['Amount'];
                                $arr['securepan'] = $_POST['SecurePan'];
                                $arr['mid'] = $_POST['MID'];
                                $arr['token'] = $_POST['Token'];
                                $sql = Helper::Update_Generator($arr, 'bnm_sep_payment', "WHERE id = :id");
                                $res = Db::secure_update_array($sql, $arr);
                                // initializing sms panel
                                switch ($payment[0]['user_type']) {
                                    case __ADMINUSERTYPE__:
                                    case __ADMINOPERATORUSERTYPE__:
                                        $noe_user = 0;
                                        echo Helper::Alert_Custom_Message("نوع کاربری شما ادمین است پس شارژی اضافه نمیشود");
                                        break;
                                    case __MODIRUSERTYPE__:
                                    case __MODIR2USERTYPE__:
                                        $noe_user = 2;
                                        $res_user = Helper::Select_By_Id('bnm_operator', $payment[0]['user_id']);
                                        $res_chargecredit = Helper::chargeCreditTransaction($payment[0]['user_id'], $noe_user, $res_verify, $arr['resnum']);
                                        if ($res_user) {
                                            $res_internal = Helper::Internal_Message_By_Karbord('sharje_bn', '1');
                                            if ($res_internal) {
                                                $res_sms_request = Helper::Write_In_Sms_Request(
                                                    $res_user[0]['telephone_hamrah'],
                                                    Helper::Today_Miladi_Date(),
                                                    Helper::Today_Miladi_Date(),
                                                    1,
                                                    $res_internal[0]['id'],
                                                    '2'
                                                );
                                                if ($res_sms_request) {
                                                    $arrsms = array();
                                                    $arrsms['receiver'] = $res_user[0]['telephone_hamrah'];
                                                    $arrsms['sender'] = __SMSNUMBER__;
                                                    $arrsms['request_id'] = $res_sms_request;
                                                    $arrsms = Helper::Write_In_Sms_Queue($arrsms);
                                                } else {
                                                    echo Helper::Alert_Custom_Message('پرداخت با موفقیت انجام شد. شماره تراکنش: ' . $arr['resnum'] . 'مشکل در ارسال پیامک!');
                                                }
                                            } else {
                                                echo Helper::Alert_Custom_Message('پرداخت با موفقیت انجام شد. شماره تراکنش: ' . $arr['resnum'] . 'مشکل در ارسال پیامک!');
                                            }
                                        } else {
                                            echo Helper::Alert_Custom_Message('پرداخت با موفقیت انجام شد. شماره تراکنش: ' . $arr['resnum'] . 'مشکل در ارسال پیامک!');
                                        }
                                        break;
                                    case __MOSHTARAKUSERTYPE__:
                                        $noe_user = 1;
                                        $res_user = Helper::Select_By_Id('bnm_subscribers', $payment[0]['user_id']);
                                        if ($res_user) {
                                            if ($res_user[0]['branch_id'] === 0) {
                                                $res_internal = Helper::Internal_Message_By_Karbord('sharje_bms', '1');
                                                if ($res_internal) {
                                                    $res_sms_request = Helper::Write_In_Sms_Request(
                                                        $res_user[0]['telephone_hamrah'],
                                                        Helper::Today_Miladi_Date(),
                                                        Helper::Today_Miladi_Date(),
                                                        1,
                                                        $res_internal[0]['id'],
                                                        '2'
                                                    );
                                                    if ($res_sms_request) {
                                                        $arrsms = array();
                                                        $arrsms['receiver'] = $res_user[0]['telephone_hamrah'];
                                                        $arrsms['sender'] = __SMSNUMBER__;
                                                        $arrsms['request_id'] = $res_sms_request;
                                                        $arrsms = Helper::Write_In_Sms_Queue($arrsms);
                                                    } else {
                                                        echo Helper::Alert_Custom_Message('پرداخت با موفقیت انجام شد. شماره تراکنش: ' . $arr['resnum'] . 'مشکل در ارسال پیامک!');
                                                    }
                                                } else {
                                                    echo Helper::Alert_Custom_Message('پرداخت با موفقیت انجام شد. شماره تراکنش: ' . $arr['resnum'] . 'مشکل در ارسال پیامک!');
                                                }
                                            } else {
                                                //user namayande
                                                $res_sub = Helper::Select_By_Id('bnm_subscribers', $payment[0]['user_id']);
                                                if ($res_sub) {
                                                    $res_internal = Helper::Internal_Message_By_Karbord('sharje_bmn', '1');
                                                    if ($res_internal) {
                                                        $res_sms_request = Helper::Write_In_Sms_Request(
                                                            $res_sub[0]['telephone_hamrah'],
                                                            Helper::Today_Miladi_Date(),
                                                            Helper::Today_Miladi_Date(),
                                                            1,
                                                            $res_internal[0]['id'],
                                                            '2'
                                                        );
                                                        if ($res_sms_request) {
                                                            $arrsms = array();
                                                            $arrsms['receiver'] = $res_sub[0]['telephone_hamrah'];
                                                            $arrsms['sender'] = __SMSNUMBER__;
                                                            $arrsms['request_id'] = $res_sms_request;
                                                            $arrsms = Helper::Write_In_Sms_Queue($arrsms);
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        break;
                                    default:
                                        echo Helper::Alert_Custom_Message('تراکنش بدرستی انجام شد اما نوع کاربری شما برای ادامه عملییات یافت نشد لطفا با پشتیبانی تماس بگیرید');
                                        break;
                                }

                                if ($res_chargecredit) {
                                    echo Helper::Alert_Custom_Message('شماره تراکنش: ' . $arr['resnum']);
                                } else {
                                    echo Helper::Alert_Custom_Message($arr["resnum"] . ' :تراکنش انجام شد ولیکن مشکلی در ثبت اطلاعات بوجود آمده لطفا با پشتیبانی تماس بگیرید. شماره تراکتش');
                                }
                            } else {
                                // verify is not true
                                echo Helper::Alert_Custom_Message('مشکل در اعتبار سنجی تراکنش در صودت عودت نشدن مبلغ لطفا با پشتیبانی بانک سامان تماس بگیرید.');
                            }
                        } else {
                            //verify nashod
                            echo Helper::Alert_Custom_Message('اعتبار سنجی تراکنش با مشکل مواجه شده جهت عودت مبلغ واریزی با پشتیبانی بانک سامان تماس بگیرید.');
                        }
                    } else {
                        $msg = "تراکنش شما نامعتبر است";
                        echo Helper::Alert_Custom_Message($msg);
                    }
                    break;
                case 'CanceledByUser':
                case 'Failed':
                case 'SessionIsNull':
                case 'InvalidParameters':
                case 'MerchantIpAddressIsInvalid':
                case 'TokenNotFound':
                case 'TokenRequired':
                case 'TerminalNotFound':
                    $arr = array();
                    $arr['state'] = $_POST['State'];
                    $arr['statecode'] = $_POST['StateCode'];
                    $arr['id'] = $_SESSION['sep_id'];
                    $arr['refnum'] = $_POST['RefNum'];
                    $arr['cid'] = $_POST['CID'];
                    $arr['traceno'] = $_POST['TRACENO'];
                    $arr['rrn'] = $_POST['RRN'];
                    $arr['amount'] = $_POST['Amount'];
                    $arr['securepan'] = $_POST['SecurePan'];
                    $arr['mid'] = $_POST['MID'];
                    $arr['final_status'] = 'before_verify';
                    $sql = Helper::Update_Generator($arr, 'bnm_sep_payment', "WHERE id = :id");
                    $res = Db::secure_update_array($sql, $arr);
                    echo "<script>alert('2عملیات ناموفق.');</script>";
                    //echo "<script>{$arr['state']}</script>";
                    break;

                default:
                    echo "<script>alert('3عملیات ناموفق.');</script>";
                    break;
            }
        }
        if (isset($_POST['checkisirani'])) {
            if (isset($_POST['checkisirani'])) {
                $res = Helper::checkNationalityById($_POST['checkisirani']);
                die(json_encode($res));
            } else {
                die(Helper::Json_Message('inf'));
            }
            // $res=Helper::
        }
        if (isset($_POST['send_change_system_password'])) {
            try {
                $_POST = Helper::Create_Post_Array_Without_Key($_POST);
                $_POST = Helper::xss_check_array($_POST);
                $_POST['new_password'] = Helper::str_trim($_POST['new_password']);
                $_POST['new_password_confirm'] = Helper::str_trim($_POST['new_password_confirm']);
                $_POST['prev_password'] = Helper::str_trim($_POST['prev_password']);
                if (isset($_POST['new_password']) && isset($_POST['prev_password'])) {
                    if ($_POST['new_password'] === $_POST['new_password_confirm']) {
                        //check username and last password
                        $_POST['prev_password'] = Helper::str_md5($_POST['prev_password']);
                        $sql_init = "SELECT * FROM bnm_users WHERE id=? AND username=? AND password=?";
                        $res_init = Db::secure_fetchall($sql_init, array($_SESSION['id'], $_SESSION['username'], $_POST['prev_password']));
                        if ($res_init) {
                            //update password
                            $arr = array();
                            $arr['password'] = Helper::str_md5($_POST['new_password']);
                            $arr['id'] = $_SESSION['id'];
                            $sql = Helper::Update_Generator($arr, 'bnm_users', "WHERE id = :id");
                            $res = Db::secure_update_array($sql, $arr);
                            if ($res) {
                                die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                            } else {
                                die(Helper::Json_Message('f'));
                            }
                        } else {
                            die(Helper::Json_Message('f'));
                        }

                    } else {
                        die(Helper::Custom_Msg(Helper::Messages('npacf'), 2));
                    }
                } else {
                    die(Helper::Json_Message('f'));
                }
            } catch (Throwable $e) {
                $res = Helper::Exc_Error_Debug($e, true, '', true);
                die();
            }
        }
        if (isset($_POST['send_administration_change_system_password'])) {
            $_POST = Helper::Create_Post_Array_Without_Key($_POST);
            $_POST = Helper::xss_check_array($_POST);
            if($_POST['new_password'])
            if (isset($_POST['new_password']) && isset($_POST['new_password_confirm'])) {
                if($_POST['new_password']===$_POST['new_password_confirm']){
                    // $sql=Helper::Update_Generator(['password'=>$_POST['password'],'user_id'=>$_POST['userid'], 'user_type'=>__MOSHTARAKUSERTYPE__], 'bnm_users', 'WHERE user_id=:user_id AND user_type=:'.__MOSHTARAKUSERTYPE__);
                    $arr=[
                        'password'=>Helper::str_md5($_POST['new_password']),
                        'user_id'=>$_POST['userid'],
                        'user_type'=>__MOSHTARAKUSERTYPE__
                    ];
                    $sql="SELECT * FROM bnm_users WHERE user_id = ? AND user_type = ?";
                    $userinfo=Db::secure_fetchall($sql, [$arr['user_id'], $arr['user_type']]);
                    if(! $userinfo) die(Helper::Custom_Msg(Helper::Messages('f'), 3));
                    if(isset($userinfo['errorInfo'])) die(Helper::Custom_Msg(Helper::Messages('f'), 3));
                    $sql=Helper::Update_Generator(['id'=>$userinfo[0]['id'], 'password'=>$arr['password']], 'bnm_users', "WHERE id= :id");
                    $res=Db::secure_update_array($sql, ['id'=>$userinfo[0]['id'], 'password'=>$arr['password']]);
                    if($res){
                        die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                    }else{
                        die(Helper::Custom_Msg("مشکلی در انجام درخواست شما بوجود آمده و یا رمز عبور تکراری است", 3));
                        
                    }
                }else{
                    die(Helper::Json_Message('inf'));
                }
            }else{
                die(Helper::Json_Message('inf'));
            }
            // if (isset($_POST['new_password']) && isset($_POST['new_password_confirm'])) {
            //     $_POST['new_password'] = Helper::str_trim($_POST['new_password']);
            //     $_POST['new_password_confirm'] = Helper::str_trim($_POST['new_password_confirm']);
            //     if ($_POST['new_password'] === $_POST['new_password_confirm']) {
            //         $arr = array();
            //         $arr['password'] = Helper::str_md5($_POST['new_password']);
            //         $arr['user_id'] = $_POST['userid'];
            //         $arr['user_type'] = __MOSHTARAKUSERTYPE__;
            //         // $sql             = Helper::Update_Generator($arr, 'bnm_users', "WHERE id = :id");
            //         $sql = "UPDATE bnm_users SET password = :password WHERE user_id = :user_id AND user_type = :user_type";
            //         $res = Db::secure_update_array($sql, $arr);
            //         if ($res) {
            //             die(Helper::Custom_Msg(Helper::Messages('s'), 1));
            //         } else {
            //             die(Helper::Json_Message('f'));
            //         }

            //     } else {
            //         die(Helper::Custom_Msg(Helper::Messages('npacf'), 2));
            //     }
            // } else {
            //     die(Helper::Json_Message('f'));
            // }
        }
        /*=============send_support_requests_inbox_response==============*/
        if (isset($_POST['support_requests_inbox_response'])) {
            $_POST = Helper::Create_Post_Array_Without_Key($_POST);
            $_POST = Helper::xss_check_array($_POST);
            $_POST = Helper::Manual_Unset_Array($_POST, array('reply_id', 'onvane_payam', 'matne_payam'));
            if (Helper::Login_Just_Check()) {
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                        die(Helper::Json_Message('na'));
                        break;
                    case __MODIRUSERTYPE__:
                    case __OPERATORUSERTYPE__:
                    case __MODIR2USERTYPE__:
                    case __OPERATOR2USERTYPE__:
                        die(Helper::Json_Message('na'));
                        break;
                    case __MOSHTARAKUSERTYPE__:
                        if (isset($_POST['reply_id'])) {
                            $sql_init = "SELECT * FROM bnm_support_requests
                            WHERE id=? AND
                            sender_user_type IN (" . __ADMINUSERTYPE__ . "," . __ADMINOPERATORUSERTYPE__ . "," . __MODIRUSERTYPE__ . "," . __OPERATORUSERTYPE__ . "," . __MODIR2USERTYPE__ . "," . __OPERATOR2USERTYPE__ . ")
                            AND reciever_id=? AND reciever_type= " . __MOSHTARAKUSERTYPE__ . " AND sender_user_id <> ?";
                            //sender_user_type IN (1,2,3,4) AND reciever_type= 5
                            $res_init = Db::secure_fetchall($sql_init, array($_POST['reply_id'], $_SESSION['user_id'], $_SESSION['user_id']));
                            if ($res_init) {
                                //its ok let send replay
                                $arr = array();
                                $arr['onvane_payam'] = $_POST['onvane_payam'];
                                $arr['matne_payam'] = $_POST['matne_payam'];
                                $arr['matne_payam'] = $_POST['matne_payam'];
                                $arr['reciever_user_id'] = $res_init[0]['sender_user_id'];
                                $arr['reciever_user_type'] = $res_init[0]['sender_user_type'];
                                $arr['sender_user_id'] = $_SESSION['user_id'];
                                $arr['sender_branch_id'] = $_SESSION['branch_id'];
                                $arr['sender_id'] = $_SESSION['id'];
                                $arr['sender_user_type'] = $_SESSION['user_type'];
                                $sql = Helper::Insert_Generator($arr, 'bnm_support_requests');
                                $res = Db::secure_insert_array($sql, $arr);
                                if ($res) {

                                    die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                                } else {
                                    die(Helper::Json_Message('f'));
                                }
                            } else {
                                die(Helper::Json_Message('af'));
                            }
                        } else {
                            die(Helper::Json_Message('f'));
                        }

                        break;
                }
            } else {
                die(Helper::Json_Message('af'));
            }

            die(json_encode($_POST));
        }

        if (isset($_POST['online_user_form_request'])) {
            $_POST = Helper::Create_Post_Array_Without_Key($_POST);
            $_POST = Helper::xss_check_array($_POST);
            if (Helper::Login_Just_Check()) {
                // switch ($_SESSION['user_type']) {
                //     case __ADMINUSERTYPE__:
                //     case __ADMINOPERATORUSERTYPE__:
                //     case __MODIRUSERTYPE__:
                //     case __OPERATORUSERTYPE__:
                //     case __MODIR2USERTYPE__:
                //     case __OPERATOR2USERTYPE__:
                //     break;
                //     case __MOSHTARAKUSERTYPE__:
                //     break;
                // }
                switch ($_POST['service_type']) {
                    case 'adsl':
                    case 'vdsl':
                    case 'bitstream':
                    case 'wireless':
                    case 'tdlte':
                        $noemasraf = "internet";
                        $ibsusername = $_POST['ibsusername'];
                        $res = $GLOBALS['ibs_internet']->getAllInternetOnlineUsers();
                        break;
                    case 'voip':
                        $noemasraf = "voip";
                        $ibsusername = $_POST['ibsusername'];
                        $res = $GLOBALS['ibs_voip']->getAllVoipOnlineUsers();
                        break;
                }
                if (isset($res)) {
                    // $res[2] = $noemasraf;
                    // $res[3] = $ibsusername;

                    $res = Helper::ibsOnlineuserFilterInitialize($res);
                    $res['noemasraf'] = $noemasraf;
                    $res['ibsusername'] = $ibsusername;
                    die(json_encode($res));
                } else {
                    die(Helper::Json_Message('f'));
                }
            }
        }
        if (isset($_POST['connection_log_form_request'])) {
            $_POST = Helper::Create_Post_Array_Without_Key($_POST);
            $_POST = Helper::xss_check_array($_POST);
            if(! $_POST['service']) die(Helper::Custom_Msg('سرویس کاربر را مشخص کنید'));
            if(! $_POST['noe_masraf']) die(Helper::Custom_Msg('نوع مصرف را مشخص کنید'));
            if(! $_POST['time_from']) die(Helper::Custom_Msg('تاریخ شروع را مشخص کنید'));
            if(! $_POST['time_to']) die(Helper::Custom_Msg('تاریخ پایان را مشخص کنید'));
            $noemasraf = Helper::Select_By_Id('bnm_connection_log', $_POST['noe_masraf']);
            if(! $noemasraf) die(Helper::Custom_Msg('نوع مصرف با اطلاعات از پیش ساخته شده پایگاه داده مطابقت ندارد.'));
            $factor=Helper::getServiceInfoByFactorid($_POST['service']);
            if(! $factor) die(Helper::Custom_Msg('اطلاعات سرویس مشترک در پایگاه داده ثبت نشده است.'));
            if(! isset($factor[0]['ibsusername'])) die(Helper::Custom_Msg('اطلاعات سرویس مشترک در پایگاه داده ثبت نشده است.'));
            $logs=Helper::getIbsLogsByArrayUsernamesDesc([$factor[0]['ibsusername']], Helper::regulateNumber($_POST['time_from']), Helper::regulateNumber($_POST['time_to']), 10000, 'jalali');
            if(! $logs) die(Helper::Custom_Msg('مشترک لاگی در بازه مشخص شده ندارند.'));
            $logs=$logs[1][1];
            foreach ($logs as $k => $v) {
                if(! ip2long($v['ipv4_address'])){
                    unset($logs[$k]);
                }
            }
            array_values($logs);
            if(! $logs) die(Helper::Custom_Msg('مشترک لاگ معتبری در بازه مشخص شده ندارند.'));
            

            die(json_encode($logs));
        }
        // if (isset($_POST['connection_log_form_request'])) {
        //     $_POST = Helper::Create_Post_Array_Without_Key($_POST);
        //     $_POST = Helper::xss_check_array($_POST);

        //     if (isset($_POST['noe_masraf'])) {
        //         $res_noemasraf = Helper::Select_By_Id('bnm_connection_log', $_POST['noe_masraf']);
        //     } else {
        //         die(Helper::Json_Message('f'));
        //     }
        //     $_POST['time_from']=Helper::tabdileTarikh($_POST['time_from'], 2, '/');
        //     $_POST['time_to']=Helper::tabdileTarikh($_POST['time_to'], 2, '/');
        //     $factor=Helper::getServiceInfoByFactorid($_POST['service']);
        //     if(! $factor) die(Helper::Custom_Msg("اطلاعات سرویس یافت نشد"));
        //     if(! isset($factor[0]['ibsusername'])) die(Helper::Custom_Msg("اطلاعات سرویس یافت نشد"));
        //     if(! $factor[0]['ibsusername']) die(Helper::Custom_Msg("اطلاعات سرویس یافت نشد"));
        //     if (Helper::Login_Just_Check()) {
        //         switch ($factor[0]['sertype']) {
        //             case 'adsl':
        //             case 'vdsl':
        //             case 'bitstream':
        //             case 'wireless':
        //             case 'tdlte':
        //                 //get ibs id
        //                 // die(json_encode($factor));
        //                 $res_ibs_init = $GLOBALS['ibs_internet']->getUserIdByNormalUsername($factor[0]['ibsusername']);
        //                 if ($res_ibs_init) {
                            
        //                     $res_ibs = $GLOBALS['ibs_internet']->getConnectionByUsernameAndDateTimeDesc((string) $factor[0]['ibsusername'], $_POST['time_from'], $_POST['time_to'], 10000);
        //                     if(! Helper::checkIbsResultStrict($res_ibs)) die(Helper::Custom_Msg("لاگی از این سرویس یافت نشد"));
        //                     $res_ibs=$res_ibs[1][1];
                            
        //                     // $res_ibs = $GLOBALS['ibs_internet']->getConnectionLogs($_POST['time_from'], $_POST['time_to'], (string) $res_ibs_init);
        //                     $res_ibs=Helper::byteConvertArray($res_ibs, 'bytes_in');
        //                     $res_ibs=Helper::byteConvertArray($res_ibs, 'bytes_out');
        //                     $res_ibs=Helper::creditFormatArray($res_ibs, 'before_credit');
        //                     $res_ibs=Helper::secondsToTimeIndexArray($res_ibs, 'duration_seconds');
        //                     $res_ibs=Helper::tabdileTarikhIndexArray($res_ibs, 'login_time_formatted',1,'-','/',false);
        //                     $res_ibs=Helper::tabdileTarikhIndexArray($res_ibs, 'logout_time_formatted',1,'-','/',false);
        //                     $flag_type = 'internet';
        //                 } else {
        //                     $msg = 'نام کاربری کاربر در IBSng وجود ندارد.';
        //                     die(Helper::Custom_Msg($msg, 2));
        //                 }
        //                 break;
        //             case 'voip':
        //                 //get ibs id
        //                 $res_ibs_init = $GLOBALS['ibs_voip']->getUserIdByVoipUsername($factor[0]['ibsusername']);
        //                 if (Helper::checkIbsUserInfo($res_ibs_init)) {
        //                     $res_ibs = $GLOBALS['ibs_voip']->getConnectionLogsVoip($_POST['time_from'], $_POST['time_to'], (string) $res_ibs_init);
        //                     if(isset($res_ibs[1])){
        //                         if($res_ibs[1]){
        //                             $res_ibs=$res_ibs[1];
        //                             $res_ibs=Helper::numberFormatArray($res_ibs, 'before_credit', 1, '.', ',');
        //                             $res_ibs=Helper::numberFormatArray($res_ibs, 'credit_used', 1, '.', ',');
        //                             $res_ibs=Helper::secondsToTimeIndexArray($res_ibs, 'duration_seconds');
        //                             $res_ibs=Helper::tabdileTarikhIndexArray($res_ibs, 'login_time_formatted',1,'-','/',false);
        //                             $res_ibs=Helper::tabdileTarikhIndexArray($res_ibs, 'logout_time_formatted',1,'-','/',false);
        //                         }else{
        //                             $msg="لاگی در بازه زمانی انتخاب شده وجود نداشت";
        //                             die(Helper::Custom_Msg($msg, 3));
        //                         }
        //                     }else{
        //                         $msg="لاگی در بازه زمانی انتخاب شده وجود نداشت";
        //                         die(Helper::Custom_Msg($msg, 3));
        //                     }
        //                     $flag_type = 'voip';
        //                 } else {
        //                     $msg = 'نام کاربری کاربر در IBSng وجود ندارد.';
        //                     die(Helper::Custom_Msg($msg, 2));
        //                 }
        //                 break;
        //         }
        //         die(json_encode($res_ibs));
        //         if (isset($res_ibs)) {
        //             $res_ibs = Helper::ibsConnectionlogFilterByNoeMasraf($res_ibs, $res_noemasraf[0]['name']);
        //             if ($res_ibs) {
        //                 if (count($res_ibs) > 0) {
        //                     // die(json_encode($res_ibs));
        //                     die(json_encode(['result' => $res_ibs, 'noe_service' => $flag_type]));
                            
        //                 } else {
        //                     $msg="لاگی در بازه زمانی انتخاب شده وجود نداشت";
        //                     die(Helper::Custom_Msg($msg, 3));
        //                 }
        //             } else {
        //                 $msg="لاگی در بازه زمانی انتخاب شده وجود نداشت";
        //                 die(Helper::Custom_Msg($msg, 3));
        //             }
        //         } else {
        //             $msg="لاگی در بازه زمانی انتخاب شده وجود نداشت";
        //             die(Helper::Custom_Msg($msg, 3));
        //         }
        //     } else {
        //         die(Helper::Json_Message('af'));
        //     }
        //     ///voip example
        //     // [
        //                 //     true,
        //                 //     [
        //                 //         {
        //                 //             "called_number": "",
        //                 //             "voip_provider_prefix_name": "",
        //                 //             "logout_time_formatted": "2022-12-04 17:32",
        //                 //             "caller_id": "2144724759",
        //                 //             "user_id": 785293,
        //                 //             "login_time_formatted": "2022-12-04 17:32",
        //                 //             "details": [
        //                 //                 [
        //                 //                     "kill_reason",
        //                 //                     "invalid literal for int() with base 10: ''"
        //                 //                 ],
        //                 //                 [
        //                 //                     "dnis",
        //                 //                     "2191012459"
        //                 //                 ],
        //                 //                 [
        //                 //                     "asterisk_channel",
        //                 //                     "SIP/Asiya-00001f5d"
        //                 //                 ]
        //                 //             ],
        //                 //             "ras_description": "asterisk",
        //                 //             "service_type": "VoIP",
        //                 //             "username": "02144718283",
        //                 //             "voip_provider_credit_used": 0,
        //                 //             "successful": "f",
        //                 //             "prefix_code": "N/A",
        //                 //             "before_credit": 49797.5,
        //                 //             "called_ip": "",
        //                 //             "disconnect_cause": "",
        //                 //             "voip_provider_id": -1,
        //                 //             "connection_log_id": 30853175,
        //                 //             "billed_duration": 0,
        //                 //             "cpm": 0,
        //                 //             "credit_used": 0,
        //                 //             "voip_provider_prefix_code": "",
        //                 //             "retry_count": 1,
        //                 //             "parent_isp_credit_used": 0,
        //                 //             "voip_provider_cpm": 0,
        //                 //             "duration_seconds": 0,
        //                 //             "prefix_name": "N/A"
        //                 //         },
        //                 //         {
        //                 //             "called_number": "1336865973",
        //                 //             "voip_provider_prefix_name": "United States",
        //                 //             "logout_time_formatted": "2022-12-04 17:40",
        //                 //             "caller_id": "2144724759",
        //                 //             "voip_provider": "MVTS-IPC-VP",
        //                 //             "user_id": 785293,
        //                 //             "login_time_formatted": "2022-12-04 17:40",
        //                 //             "details": [
        //                 //                 [
        //                 //                     "original_called_number",
        //                 //                     "1336865973"
        //                 //                 ],
        //                 //                 [
        //                 //                     "dnis",
        //                 //                     "2191012459"
        //                 //                 ],
        //                 //                 [
        //                 //                     "asterisk_channel",
        //                 //                     "SIP/Asiya-00001f63"
        //                 //                 ]
        //                 //             ],
        //                 //             "ras_description": "asterisk",
        //                 //             "service_type": "VoIP",
        //                 //             "username": "02144718283",
        //                 //             "voip_provider_credit_used": 6.75,
        //                 //             "successful": "t",
        //                 //             "prefix_code": "1336",
        //                 //             "before_credit": 49415,
        //                 //             "called_ip": "185.98.113.221",
        //                 //             "disconnect_cause": "ANSWER",
        //                 //             "voip_provider_id": 2,
        //                 //             "connection_log_id": 30853178,
        //                 //             "billed_duration": 60,
        //                 //             "cpm": 202.5,
        //                 //             "credit_used": 202.5,
        //                 //             "voip_provider_prefix_code": "1336",
        //                 //             "retry_count": 1,
        //                 //             "parent_isp_credit_used": 0,
        //                 //             "voip_provider_cpm": 202.5,
        //                 //             "duration_seconds": 2,
        //                 //             "prefix_name": "United States"
        //                 //         },
        //                 //         {
        //                 //             "called_number": "02144718283",
        //                 //             "voip_provider_prefix_name": "",
        //                 //             "logout_time_formatted": "2022-12-04 17:45",
        //                 //             "caller_id": "2144724759",
        //                 //             "user_id": 785293,
        //                 //             "login_time_formatted": "2022-12-04 17:45",
        //                 //             "details": [
        //                 //                 [
        //                 //                     "kill_reason",
        //                 //                     "No rule can be applied"
        //                 //                 ],
        //                 //                 [
        //                 //                     "dnis",
        //                 //                     "2191012459"
        //                 //                 ],
        //                 //                 [
        //                 //                     "asterisk_channel",
        //                 //                     "SIP/Asiya-00001f69"
        //                 //                 ]
        //                 //             ],
        //                 //             "ras_description": "asterisk",
        //                 //             "service_type": "VoIP",
        //                 //             "username": "02144718283",
        //                 //             "voip_provider_credit_used": 0,
        //                 //             "successful": "f",
        //                 //             "prefix_code": "N/A",
        //                 //             "before_credit": 48807.5,
        //                 //             "called_ip": "",
        //                 //             "disconnect_cause": "",
        //                 //             "voip_provider_id": -1,
        //                 //             "connection_log_id": 30853181,
        //                 //             "billed_duration": 0,
        //                 //             "cpm": 0,
        //                 //             "credit_used": 0,
        //                 //             "voip_provider_prefix_code": "",
        //                 //             "retry_count": 1,
        //                 //             "parent_isp_credit_used": 0,
        //                 //             "voip_provider_cpm": 0,
        //                 //             "duration_seconds": 0,
        //                 //             "prefix_name": "N/A"
        //                 //         },
        //                 //         {
        //                 //             "called_number": "014166488048",
        //                 //             "voip_provider_prefix_name": "",
        //                 //             "logout_time_formatted": "2022-12-04 17:47",
        //                 //             "caller_id": "2144724759",
        //                 //             "user_id": 785293,
        //                 //             "login_time_formatted": "2022-12-04 17:47",
        //                 //             "details": [
        //                 //                 [
        //                 //                     "kill_reason",
        //                 //                     "No rule can be applied"
        //                 //                 ],
        //                 //                 [
        //                 //                     "dnis",
        //                 //                     "2191012459"
        //                 //                 ],
        //                 //                 [
        //                 //                     "asterisk_channel",
        //                 //                     "SIP/Asiya-00001f6a"
        //                 //                 ]
        //                 //             ],
        //                 //             "ras_description": "asterisk",
        //                 //             "service_type": "VoIP",
        //                 //             "username": "02144718283",
        //                 //             "voip_provider_credit_used": 0,
        //                 //             "successful": "f",
        //                 //             "prefix_code": "N/A",
        //                 //             "before_credit": 48807.5,
        //                 //             "called_ip": "",
        //                 //             "disconnect_cause": "",
        //                 //             "voip_provider_id": -1,
        //                 //             "connection_log_id": 30853183,
        //                 //             "billed_duration": 0,
        //                 //             "cpm": 0,
        //                 //             "credit_used": 0,
        //                 //             "voip_provider_prefix_code": "",
        //                 //             "retry_count": 1,
        //                 //             "parent_isp_credit_used": 0,
        //                 //             "voip_provider_cpm": 0,
        //                 //             "duration_seconds": 0,
        //                 //             "prefix_name": "N/A"
        //                 //         },
        //                 //         {
        //                 //             "called_number": "",
        //                 //             "voip_provider_prefix_name": "",
        //                 //             "logout_time_formatted": "2022-12-04 17:45",
        //                 //             "caller_id": "2144724759",
        //                 //             "user_id": 785293,
        //                 //             "login_time_formatted": "2022-12-04 17:45",
        //                 //             "details": [
        //                 //                 [
        //                 //                     "kill_reason",
        //                 //                     "invalid literal for int() with base 10: ''"
        //                 //                 ],
        //                 //                 [
        //                 //                     "dnis",
        //                 //                     "2191012459"
        //                 //                 ],
        //                 //                 [
        //                 //                     "asterisk_channel",
        //                 //                     "SIP/Asiya-00001f69"
        //                 //                 ]
        //                 //             ],
        //                 //             "ras_description": "asterisk",
        //                 //             "service_type": "VoIP",
        //                 //             "username": "02144718283",
        //                 //             "voip_provider_credit_used": 0,
        //                 //             "successful": "f",
        //                 //             "prefix_code": "N/A",
        //                 //             "before_credit": 48807.5,
        //                 //             "called_ip": "",
        //                 //             "disconnect_cause": "",
        //                 //             "voip_provider_id": -1,
        //                 //             "connection_log_id": 30853182,
        //                 //             "billed_duration": 0,
        //                 //             "cpm": 0,
        //                 //             "credit_used": 0,
        //                 //             "voip_provider_prefix_code": "",
        //                 //             "retry_count": 1,
        //                 //             "parent_isp_credit_used": 0,
        //                 //             "voip_provider_cpm": 0,
        //                 //             "duration_seconds": 0,
        //                 //             "prefix_name": "N/A"
        //                 //         },
        //                 //         {
        //                 //             "called_number": "13306865973",
        //                 //             "voip_provider_prefix_name": "United States",
        //                 //             "logout_time_formatted": "2022-12-04 17:32",
        //                 //             "caller_id": "2144724759",
        //                 //             "voip_provider": "MVTS-IPC-VP",
        //                 //             "user_id": 785293,
        //                 //             "login_time_formatted": "2022-12-04 17:31",
        //                 //             "details": [
        //                 //                 [
        //                 //                     "original_called_number",
        //                 //                     "13306865973"
        //                 //                 ],
        //                 //                 [
        //                 //                     "dnis",
        //                 //                     "2191012459"
        //                 //                 ],
        //                 //                 [
        //                 //                     "asterisk_channel",
        //                 //                     "SIP/Asiya-00001f5a"
        //                 //                 ]
        //                 //             ],
        //                 //             "ras_description": "asterisk",
        //                 //             "service_type": "VoIP",
        //                 //             "username": "02144718283",
        //                 //             "voip_provider_credit_used": 172.125,
        //                 //             "successful": "t",
        //                 //             "prefix_code": "1330",
        //                 //             "before_credit": 50000,
        //                 //             "called_ip": "185.98.113.221",
        //                 //             "disconnect_cause": "ANSWER",
        //                 //             "voip_provider_id": 2,
        //                 //             "connection_log_id": 30853173,
        //                 //             "billed_duration": 60,
        //                 //             "cpm": 202.5,
        //                 //             "credit_used": 202.5,
        //                 //             "voip_provider_prefix_code": "1330",
        //                 //             "retry_count": 1,
        //                 //             "parent_isp_credit_used": 0,
        //                 //             "voip_provider_cpm": 202.5,
        //                 //             "duration_seconds": 51,
        //                 //             "prefix_name": "United States"
        //                 //         },
        //                 //         {
        //                 //             "called_number": "19057705839",
        //                 //             "voip_provider_prefix_name": "Canada",
        //                 //             "logout_time_formatted": "2022-12-04 17:36",
        //                 //             "caller_id": "2144724759",
        //                 //             "voip_provider": "MVTS-IPC-VP",
        //                 //             "user_id": 785293,
        //                 //             "login_time_formatted": "2022-12-04 17:35",
        //                 //             "details": [
        //                 //                 [
        //                 //                     "original_called_number",
        //                 //                     "19057705839"
        //                 //                 ],
        //                 //                 [
        //                 //                     "dnis",
        //                 //                     "2191012459"
        //                 //                 ],
        //                 //                 [
        //                 //                     "asterisk_channel",
        //                 //                     "SIP/Asiya-00001f61"
        //                 //                 ]
        //                 //             ],
        //                 //             "ras_description": "asterisk",
        //                 //             "service_type": "VoIP",
        //                 //             "username": "02144718283",
        //                 //             "voip_provider_credit_used": 120,
        //                 //             "successful": "t",
        //                 //             "prefix_code": "1905",
        //                 //             "before_credit": 49595,
        //                 //             "called_ip": "185.98.113.221",
        //                 //             "disconnect_cause": "ANSWER",
        //                 //             "voip_provider_id": 2,
        //                 //             "connection_log_id": 30853177,
        //                 //             "billed_duration": 120,
        //                 //             "cpm": 90,
        //                 //             "credit_used": 180,
        //                 //             "voip_provider_prefix_code": "1905",
        //                 //             "retry_count": 1,
        //                 //             "parent_isp_credit_used": 0,
        //                 //             "voip_provider_cpm": 90,
        //                 //             "duration_seconds": 80,
        //                 //             "prefix_name": "Canada"
        //                 //         },
        //                 //         {
        //                 //             "called_number": "02144718283",
        //                 //             "voip_provider_prefix_name": "",
        //                 //             "logout_time_formatted": "2022-12-04 17:32",
        //                 //             "caller_id": "2144724759",
        //                 //             "user_id": 785293,
        //                 //             "login_time_formatted": "2022-12-04 17:32",
        //                 //             "details": [
        //                 //                 [
        //                 //                     "kill_reason",
        //                 //                     "No rule can be applied"
        //                 //                 ],
        //                 //                 [
        //                 //                     "dnis",
        //                 //                     "2191012459"
        //                 //                 ],
        //                 //                 [
        //                 //                     "asterisk_channel",
        //                 //                     "SIP/Asiya-00001f5d"
        //                 //                 ]
        //                 //             ],
        //                 //             "ras_description": "asterisk",
        //                 //             "service_type": "VoIP",
        //                 //             "username": "02144718283",
        //                 //             "voip_provider_credit_used": 0,
        //                 //             "successful": "f",
        //                 //             "prefix_code": "N/A",
        //                 //             "before_credit": 49797.5,
        //                 //             "called_ip": "",
        //                 //             "disconnect_cause": "",
        //                 //             "voip_provider_id": -1,
        //                 //             "connection_log_id": 30853174,
        //                 //             "billed_duration": 0,
        //                 //             "cpm": 0,
        //                 //             "credit_used": 0,
        //                 //             "voip_provider_prefix_code": "",
        //                 //             "retry_count": 1,
        //                 //             "parent_isp_credit_used": 0,
        //                 //             "voip_provider_cpm": 0,
        //                 //             "duration_seconds": 0,
        //                 //             "prefix_name": "N/A"
        //                 //         },
        //                 //         {
        //                 //             "called_number": "18185346626",
        //                 //             "voip_provider_prefix_name": "United States",
        //                 //             "logout_time_formatted": "2022-12-04 17:42",
        //                 //             "caller_id": "2144724759",
        //                 //             "voip_provider": "MVTS-IPC-VP",
        //                 //             "user_id": 785293,
        //                 //             "login_time_formatted": "2022-12-04 17:41",
        //                 //             "details": [
        //                 //                 [
        //                 //                     "original_called_number",
        //                 //                     "18185346626"
        //                 //                 ],
        //                 //                 [
        //                 //                     "dnis",
        //                 //                     "2191012459"
        //                 //                 ],
        //                 //                 [
        //                 //                     "asterisk_channel",
        //                 //                     "SIP/Asiya-00001f65"
        //                 //                 ]
        //                 //             ],
        //                 //             "ras_description": "asterisk",
        //                 //             "service_type": "VoIP",
        //                 //             "username": "02144718283",
        //                 //             "voip_provider_credit_used": 189,
        //                 //             "successful": "t",
        //                 //             "prefix_code": "1818",
        //                 //             "before_credit": 49212.5,
        //                 //             "called_ip": "185.98.113.221",
        //                 //             "disconnect_cause": "ANSWER",
        //                 //             "voip_provider_id": 2,
        //                 //             "connection_log_id": 30853179,
        //                 //             "billed_duration": 60,
        //                 //             "cpm": 202.5,
        //                 //             "credit_used": 202.5,
        //                 //             "voip_provider_prefix_code": "1818",
        //                 //             "retry_count": 1,
        //                 //             "parent_isp_credit_used": 0,
        //                 //             "voip_provider_cpm": 202.5,
        //                 //             "duration_seconds": 56,
        //                 //             "prefix_name": "United States"
        //                 //         },
        //                 //         {
        //                 //             "called_number": "",
        //                 //             "voip_provider_prefix_name": "",
        //                 //             "logout_time_formatted": "2022-12-04 17:47",
        //                 //             "caller_id": "2144724759",
        //                 //             "user_id": 785293,
        //                 //             "login_time_formatted": "2022-12-04 17:47",
        //                 //             "details": [
        //                 //                 [
        //                 //                     "kill_reason",
        //                 //                     "invalid literal for int() with base 10: ''"
        //                 //                 ],
        //                 //                 [
        //                 //                     "dnis",
        //                 //                     "2191012459"
        //                 //                 ],
        //                 //                 [
        //                 //                     "asterisk_channel",
        //                 //                     "SIP/Asiya-00001f6a"
        //                 //                 ]
        //                 //             ],
        //                 //             "ras_description": "asterisk",
        //                 //             "service_type": "VoIP",
        //                 //             "username": "02144718283",
        //                 //             "voip_provider_credit_used": 0,
        //                 //             "successful": "f",
        //                 //             "prefix_code": "N/A",
        //                 //             "before_credit": 48807.5,
        //                 //             "called_ip": "",
        //                 //             "disconnect_cause": "",
        //                 //             "voip_provider_id": -1,
        //                 //             "connection_log_id": 30853184,
        //                 //             "billed_duration": 0,
        //                 //             "cpm": 0,
        //                 //             "credit_used": 0,
        //                 //             "voip_provider_prefix_code": "",
        //                 //             "retry_count": 1,
        //                 //             "parent_isp_credit_used": 0,
        //                 //             "voip_provider_cpm": 0,
        //                 //             "duration_seconds": 0,
        //                 //             "prefix_name": "N/A"
        //                 //         },
        //                 //         {
        //                 //             "called_number": "13306865973",
        //                 //             "voip_provider_prefix_name": "United States",
        //                 //             "logout_time_formatted": "2022-12-04 17:34",
        //                 //             "caller_id": "2144724759",
        //                 //             "voip_provider": "MVTS-IPC-VP",
        //                 //             "user_id": 785293,
        //                 //             "login_time_formatted": "2022-12-04 17:33",
        //                 //             "details": [
        //                 //                 [
        //                 //                     "original_called_number",
        //                 //                     "13306865973"
        //                 //                 ],
        //                 //                 [
        //                 //                     "dnis",
        //                 //                     "2191012459"
        //                 //                 ],
        //                 //                 [
        //                 //                     "asterisk_channel",
        //                 //                     "SIP/Asiya-00001f5f"
        //                 //                 ]
        //                 //             ],
        //                 //             "ras_description": "asterisk",
        //                 //             "service_type": "VoIP",
        //                 //             "username": "02144718283",
        //                 //             "voip_provider_credit_used": 121.5,
        //                 //             "successful": "t",
        //                 //             "prefix_code": "1330",
        //                 //             "before_credit": 49797.5,
        //                 //             "called_ip": "185.98.113.221",
        //                 //             "disconnect_cause": "ANSWER",
        //                 //             "voip_provider_id": 2,
        //                 //             "connection_log_id": 30853176,
        //                 //             "billed_duration": 60,
        //                 //             "cpm": 202.5,
        //                 //             "credit_used": 202.5,
        //                 //             "voip_provider_prefix_code": "1330",
        //                 //             "retry_count": 1,
        //                 //             "parent_isp_credit_used": 0,
        //                 //             "voip_provider_cpm": 202.5,
        //                 //             "duration_seconds": 36,
        //                 //             "prefix_name": "United States"
        //                 //         }
        //                 //     ]
        //                 // ]
        // }

        ////////////////datatable requests
        if (isset($_POST['datatable_request'])) {
            $result = Helper::datatable_handler($_POST);
            die($result);
        }
        if (isset($_POST['get_servicesbybsreserveid'])) {
            //bitstream
            if (Helper::Login_Just_Check()) {
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                        $sql = "SELECT * FROM bnm_oss_reserves WHERE id = ?";
                        $res = Db::secure_fetchall($sql, array($_POST['get_servicesbybsreserveid']), true);
                        break;
                    case __MODIRUSERTYPE__:
                    case __OPERATORUSERTYPE__:
                    case __MODIR2USERTYPE__:
                    case __OPERATOR2USERTYPE__:
                        $sql = "SELECT * FROM bnm_oss_reserves WHERE id = ? AND branch_id=?";
                        $res = Db::secure_fetchall($sql, array($_POST['get_servicesbybsreserveid'], $_SESSION['branch_id']), true);
                        break;
                    case __MOSHTARAKUSERTYPE__:
                        $sql = "SELECT * FROM bnm_oss_reserves WHERE id = ? AND branch_id=?";
                        $res = Db::secure_fetchall($sql, array($_POST['get_servicesbybsreserveid'], $_SESSION['branch_id']), true);
                        break;
                    default:
                        die(Helper::Json_Message('na'));
                        break;
                }
                if(! isset($res)){ die(Helper::Json_Message('inf'));}
                if ($res) {
                    if (isset($res[0]['interfacetype'])) {
                        if ($res[0]['interfacetype'] === "adsl") {
                            $sql = "SELECT * FROM bnm_services WHERE noe_khadamat=? AND namayeshe_service=? AND type=? AND tarikhe_shoroe_namayesh<=CURDATE() AND tarikhe_payane_namayesh >= CURDATE()";
                            $res = Db::secure_fetchall($sql, array('BITSTREAM_ADSL', 'yes', 'bitstream'), true);
                            if ($res) {
                                die(json_encode($res));
                            } else {
                                die(Helper::Custom_Msg('سرویسی جهت اختصاص به این فاکتور وجود ندارد!'));
                            }
                        } elseif ($res[0]['interfacetype'] === "vdsl") {
                            $sql = "SELECT * FROM bnm_services WHERE noe_khadamat=? AND namayeshe_service=? AND type=? AND tarikhe_shoroe_namayesh<=CURDATE() AND tarikhe_payane_namayesh >= CURDATE()";
                            $res = Db::secure_fetchall($sql, array('BITSTREAM_VDSL', 'yes', 'bitstream'), true);
                            if ($res) {
                                die(json_encode($res));
                            } else {
                                die(Helper::Custom_Msg('سرویسی جهت اختصاص به این فاکتور وجود ندارد!'));
                            }
                        } else {
                            die(Helper::Custom_Msg('اطلاعات رزرو پورت به درستی ثبت نشده لطفا پس از بررسی مجددا تلاش کنید'));
                        }
                    } else {
                        die(Helper::Custom_Msg('اطلاعات رزرو پورت به درستی ثبت نشده لطفا پس از بررسی مجددا تلاش کنید'));
                    }
                } else {
                    die(Helper::Json_Message('f'));
                }
            } else {
                die(Helper::Json_Message('af'));
            }
        }
        /*========levels========*/
        if (isset($_POST['get_maliat'])) {
            switch ($_SESSION['user_type']) {
                case __ADMINUSERTYPE__:
                case __ADMINOPERATORUSERTYPE__:

                    $sql1 = "SELECT * FROM bnm_tax order by id asc limit 1";
                    $result1 = Db::fetchall_Query($sql1);
                    $rows = json_encode($result1);
                    die($rows);
                    break;
                case __MODIRUSERTYPE__:
                case __OPERATORUSERTYPE__:
                case __MODIR2USERTYPE__:
                case __OPERATOR2USERTYPE__:

                    $sql1 = "SELECT * FROM bnm_tax order by id asc limit 1";
                    $result1 = Db::fetchall_Query($sql1);
                    $rows = json_encode($result1);
                    die($rows);
                    break;
                case __MOSHTARAKUSERTYPE__:
                    $sql1 = "SELECT * FROM bnm_tax order by id asc limit 1";
                    $result1 = Db::fetchall_Query($sql1);
                    $rows = json_encode($result1);
                    die($rows);
                    break;
                default:
                    die(Helper::Json_Message('af'));
                    break;
            }
        }

        /*========levels========*/
        if (isset($_POST['Get_Tdlte_sims_unassigned'])) {
            //require_once ('../models/city.php');
            if (Helper::Login_Just_Check()) {
                switch ($_SESSION['user_type']) {
                    case __ADMINOPERATORUSERTYPE__:
                    case __ADMINUSERTYPE__:
                        $sql = "SELECT * FROM bnm_tdlte_sim WHERE subscriber_id IS NULL";
                        $res = Db::fetchall_Query($sql);
                        break;
                    case __MODIR2USERTYPE__:
                    case __OPERATOR2USERTYPE__:
                    case __MODIRUSERTYPE__:
                    case __OPERATORUSERTYPE__:
                        $sql = "SELECT * FROM bnm_tdlte_sim WHERE subscriber_id IS NULL AND branch_id = ?";
                        $res = Db::secure_fetchall($sql, array($_SESSION['branch_id']));
                        break;
                    default:
                        $res = false;
                        break;
                }
                if ($res) {
                    die(json_encode($res));
                } else {
                    die(Helper::Json_Message('f'));
                }

            } else {
                die(Helper::Json_Message('af'));
            }

        }
        /*========levels========*/
        if (isset($_POST['get_all_terminal'])) {
            //require_once ('../models/city.php');
            $sql1 = "SELECT * FROM bnm_terminal order by id asc";
            $result1 = Db::fetchall_Query($sql1);
            for ($i = 0; $i < count($result1); $i++) {
                $markaz_id = $result1[$i]['markaze_mokhaberati'];
                $terminal_name = $result1[$i]['name'];
                $sql2 = "SELECT * From bnm_telecommunications_center WHERE id ='$markaz_id'";
                $result2 = Db::fetchall_Query($sql2);
                $result1[$i]['markaz_name'] = $result2[0]['name'] . '-' . $result1[$i]['name'];
            }
            $rows = json_encode($result1);
            die($rows);
        }
        /*=========terminal by markaz=========== */
        if (isset($_POST['get_terminal_by_markazid'])) {
            $sql = "SELECT * FROM bnm_terminal WHERE markaze_mokhaberati= ?";
            $res = Db::secure_fetchall($sql, [$_POST['get_terminal_by_markazid']]);
            if ($res) {
                die(json_encode($res));
            } else {
                die(Helper::Custom_Msg(Helper::Messages('f'), 2));
            }
            // $result1 = Db::fetchall_Query($sql);
            // $rows = json_encode($result1);
            // die($rows);
        }
        /*=========terminal by markaz=========== */
        if (isset($_POST['get_popsite_bycity'])) {
            $sql = "SELECT id,name_dakal as name,ostan,shahr FROM bnm_popsite WHERE shahr= ?";
            $result = Db::secure_fetchall($sql, array($_POST['shahr']));
            if ($result) {
                die(json_encode($result));
            } else {
                die(Helper::Custom_Msg(Helper::Messages('inf'), 2));
            }
        }
        /*=========terminal by markaz=========== */
        if (isset($_POST['get_wirelessap_by_popsite'])) {
            $sql1 = "SELECT * FROM bnm_wireless_ap WHERE popsite=?";
            $result1 = Db::secure_fetchall($sql1, array($_POST['get_wirelessap_by_popsite']));
            if ($result1) {
                $sql2 = "SELECT * FROM bnm_popsite WHERE id= ?";
                $result2 = Db::secure_fetchall($sql2, array($result1[0]['popsite']));
                for ($i = 0; $i < count($result1); $i++) {
                    $result1[$i]['name'] = $result2[0]['name_dakal'];
                }
            } else {
                //echo "<script>alert('رادیویی با این پاپ سایت یافت نشد.');</script>";
                die(json_encode(array()));
            }
            $rows = json_encode($result1);
            die($rows);
        }
        /*=========terminal by markaz=========== */
        if (isset($_POST['get_wireless_station_by_ap'])) {
            if (Helper::Login_Just_Check()) {
                switch ($_SESSION['user_type']) {
                    case __ADMINOPERATORUSERTYPE__:
                    case __ADMINUSERTYPE__:
                        $sql = "SELECT * FROM bnm_wireless_station WHERE popsite= ?";
                        $res = Db::secure_fetchall($sql, array($_POST['condition1']), true);
                        break;
                    case __MODIR2USERTYPE__:
                    case __OPERATOR2USERTYPE__:
                    case __MODIRUSERTYPE__:
                    case __OPERATORUSERTYPE__:
                        $sql = "SELECT * FROM bnm_wireless_station WHERE popsite= ? AND branch_id=?";
                        $res = Db::secure_fetchall($sql, array($_POST['condition1'], $_SESSION['branch_id']), true);
                        break;
                    default:
                        $res = false;
                        break;
                }
                if ($res) {
                    die(json_encode($res));
                } else {
                    die(Helper::Json_Message('f'));
                }

            } else {
                die(Helper::Json_Message('af'));
            }

        }
        /*=========terminal by markaz=========== */
        if (isset($_POST['get_wireless_station_by_ap_where_station_eshterak_null'])) {
            $ap_id = $_POST['get_wireless_station_by_ap_where_station_eshterak_null'];
            $sql1 = "SELECT st.id id, st.wireless_ap wireless_ap,st.name name,ap.link_name ap_name
            FROM bnm_wireless_station st
            INNER JOIN bnm_wireless_ap ap ON ap.id=st.wireless_ap
            WHERE st.wireless_ap = ?";
            $result = Db::secure_fetchall($sql1, array($ap_id));
            if ($result) {
                die(json_encode($result));
            } else {
                die(Helper::Json_Message('f'));
            }
        }
        /*========levels========*/
        if (isset($_POST['Get_organization_levels'])) {

            $sql = "SELECT * FROM bnm_organization_level order by id asc";
            $result = Db::fetchall_Query($sql);
            if ($result) {
                die(json_encode($result));
            } else {
                die(Helper::Json_Message('f'));
            }
        }
        /*========Noe_terminal========*/
        if (isset($_POST['Get_Noe_terminal'])) {
            $sql = "SELECT * FROM bnm_noe_terminal";
            $result = Db::fetchall_Query($sql);
            if ($result) {
                die(json_encode($result));
            } else {
                die(Helper::Json_Message('f'));
            }
        }
        /*========branch========*/
        if (isset($_POST['get_branch_info'])) {
            //require_once ('../models/city.php');
            if (Helper::Login_Just_Check()) {
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                        $sql = "SELECT id,name_sherkat FROM bnm_branch";
                        $result = Db::fetchall_Query($sql);
                        break;
                    case __MODIRUSERTYPE__:
                    case __OPERATORUSERTYPE__:
                    case __MODIR2USERTYPE__:
                    case __OPERATOR2USERTYPE__:
                        $sql = "SELECT id,name_sherkat FROM bnm_branch";
                        $result = Db::secure_fetchall($sql, array($_SESSION['branch_id']));
                        break;
                    default:
                        die(Helper::Json_Message('na'));
                        break;
                }
                if ($result) {
                    die(json_encode($result));
                } else {
                    die(Helper::Json_Message('f'));
                }
            } else {
                die(Helper::Json_Message('af'));
            }
        }
        /*========Equipmentsbrands========*/
        if (isset($_POST['GetEquipmentsBrands'])) {
            //require_once ('../models/city.php');
            $sql = "SELECT * FROM bnm_equipments_brands order by id asc";
            $result = Db::fetchall_Query($sql);
            if ($result) {
                die(json_encode($result));
            } else {
                die(Helper::Json_Message('f'));
            }
        }
        /*========Equipments Models BY Brands========*/
        if (isset($_POST['GetEquipmetsModelsByBrand'])) {
            $sql = "SELECT * FROM bnm_equipments_models WHERE brand_id = ? AND exdate >= CURDATE()";
            $result = Db::secure_fetchall($sql, array($_POST['GetEquipmetsModelsByBrand']));
            if ($result) {
                die(json_encode($result));
            } else {
                die(Helper::Custom_Msg('تجهیزاتی یافت نشد یا تاریخ اعتبار آن تمام شده است', 3));
            }
        }
        /*========ostan========*/
        if (isset($_POST['GetProvinces'])) {
            $sql = "SELECT * FROM bnm_ostan order by id asc";
            $result = Db::fetchall_Query($sql);
            if ($result) {
                die(json_encode($result));
            } else {
                die(Helper::Json_Message('f'));
            }
        }
        /*=========shahr========*/
        if (isset($_POST['GetCities'])) {
            $sql = "SELECT * FROM bnm_shahr order by id asc";
            $result = Db::fetchall_Query($sql);
            if ($result) {
                die(json_encode($result));
            } else {
                die(Helper::Json_Message('f'));
            }
        }
        /*=========++host++========*/
        if (isset($_POST['gethost'])) {
            $sql = "SELECT id,name_service_dahande FROM bnm_host";
            $result = Db::fetchall_Query($sql);
            if ($result) {
                die(json_encode($result));
            } else {
                die(Helper::Json_Message('f'));
            }
        }
        /*=========++popsite++========*/
        if (isset($_POST['get_wireless_ap'])) {
            $sql1 = "SELECT id,link_name,ssid FROM bnm_wireless_ap";
            $result1 = Db::fetchall_Query($sql1);
            $rows = json_encode($result1);
            die($rows);
        }
        if (isset($_POST['gethost_by_gharardad'])) {
            $sql = "SELECT id,name_service_dahande,dsl_license,dsl_bitstream FROM bnm_host WHERE (dsl_license = 'yes' OR dsl_bitstream='yes')";
            $result = Db::fetchall_Query($sql);
            $rows = json_encode($result);
            die($rows);
        }
        if (isset($_POST['getsubtelephonesbyid'])) {
            switch ($_SESSION['user_type']) {
                case __ADMINUSERTYPE__:
                case __ADMINOPERATORUSERTYPE__:
                    $sql = "SELECT id,name,f_name,telephone1,telephone2,telephone3 FROM bnm_subscribers WHERE id = ?";
                    $result = Db::secure_fetchall($sql, array($_POST['getsubtelephonesbyid']), true);
                    break;
                case __MODIRUSERTYPE__:
                case __OPERATORUSERTYPE__:
                case __MODIR2USERTYPE__:
                case __OPERATOR2USERTYPE__:
                    $sql = "SELECT id,name,f_name,telephone1,telephone2,telephone3 FROM bnm_subscribers WHERE id = ? AND branch_id = ?";
                    $result = Db::secure_fetchall($sql, array($_POST['getsubtelephonesbyid'], $_SESSION['branch_id']), true);

                    break;
                default:
                    die(Helper::Json_Message('na'));
                    break;
            }
            if ($result) {
                die(json_encode($result));
            } else {
                die(Helper::Json_Message('af'));
            }
        }
        if (isset($_POST['getosstelephonebyid'])) {
            if (Helper::Login_Just_Check()) {
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                        $sql = "SELECT sub.id id,oss.telephone telephone_id,
                        if(oss.telephone=1,sub.telephone1,if(oss.telephone=2,sub.telephone2,
                        if(oss.telephone=3,sub.telephone3,'شماره ایی ثبت نشده'))) telephone
                        FROM bnm_oss_subscribers oss LEFT JOIN bnm_subscribers sub ON oss.user_id=sub.id WHERE oss.id = ?";
                        $res = Db::secure_fetchall($sql, array($_POST['getosstelephonebyid']));
                        if ($res) {
                            die(json_encode($res));
                        } else {
                            die(Helper::Custom_Msg('اطلاعات مشترک به درستی درج نشده لطفا پس از بررسی مجددا تلاش کنید'));
                        }
                        break;
                    case __MODIRUSERTYPE__:
                    case __OPERATORUSERTYPE__:
                    case __MODIR2USERTYPE__:
                    case __OPERATOR2USERTYPE__:
                        $sql = "SELECT sub.id id,oss.telephone telephone_id,
                        if(oss.telephone=1,sub.telephone1,if(oss.telephone=2,sub.telephone2,if(oss.telephone=3,sub.telephone3,'شماره ایی ثبت نشده'))) telephone
                        FROM bnm_oss_subscribers oss LEFT JOIN bnm_subscribers sub ON oss.user_id=sub.id WHERE oss.id = ? AND oss.branch_id=? AND sub.branch_id = ?";
                        $res = Db::secure_fetchall($sql, array($_POST['getosstelephonebyid'], $_SESSION['branch_id'], $_SESSION['branch_id']));
                        if ($res) {
                            die(json_encode($res));
                        } else {
                            die(Helper::Custom_Msg('اطلاعات مشترک به درستی درج نشده لطفا پس از بررسی مجددا بررسی نمایید'));
                        }

                        break;
                    default:
                        die(Helper::Json_Message('na'));
                        break;
                }
            } else {
                die(Helper::Json_Message('af'));
            }
        }
        if (isset($_POST['get_mizban_noe_gharardad_by_id'])) {
            $sql = "SELECT id,name_service_dahande,dsl_license,dsl_bitstream FROM bnm_host WHERE (dsl_license = 'yes' OR dsl_bitstream='yes') AND id= ?";
            $result = Db::secure_fetchall($sql, array($_POST['get_mizban_noe_gharardad_by_id']));
            $rows = json_encode($result);
            die($rows);
        }
        if (isset($_POST['getpopsite'])) {
            $sql = "SELECT id,name_dakal FROM bnm_popsite";
            $result = Db::fetchall_Query($sql);
            $rows = json_encode($result);
            die($rows);
        }
        if (isset($_POST['get_telecommunications_center'])) {
            $sql = "SELECT id,name FROM bnm_telecommunications_center";
            $result = Db::fetchall_Query($sql);
            $rows = json_encode($result);
            die($rows);
        }
        if (isset($_POST['getnoeterminal'])) {
            $sql = "SELECT id,esme_terminal FROM bnm_noe_terminal";
            $result = Db::fetchall_Query($sql);
            $rows = json_encode($result);
            die($rows);
        }
        if (isset($_POST['get_telecenter_bycity'])) {
            $sql = "SELECT id,name From bnm_telecommunications_center WHERE shahr= ?";
            $res = Db::secure_fetchall($sql, array($_POST['shahr']));
            if ($res) {
                die(json_encode($res));
            } else {
                die(Helper::Custom_Msg(Helper::Messages('inf'), 2));
            }
            // $rows = json_encode($result);
            // die($rows);
        }

        /*================initializing=================*/

        if (isset($_POST['initialize_request'])) {
            //params:{filter1,filter2}
            $page = $_POST['initialize_request'];
            switch ($page) {
                case 'ibsusernamebyuseridandtype':
                    // die(json_encode($_POST));
                    switch ($_POST['filter2']) {
                        case 'adsl':
                            $res = Helper::adslInfoByUserid((int) $_POST['filter1'], true);
                            break;
                        case 'vdsl':
                            $res = Helper::vdslInfoByUserid((int) $_POST['filter1'], true);
                            break;
                        case 'bitstream':
                            $res = Helper::bitstreamInfoByUserid((int) $_POST['filter1'], true);
                            break;
                        case 'wireless':
                            $res=Helper::getIbsUsername($_SESSION['user_id'],'wireless');
                            // $res= Helper::wirelessInfoByUserid($_POST['filter1'], true);
                            break;
                        case 'tdlte':
                            $res = Helper::tdlteInfoByUserid((int) $_POST['filter1'], true);
                            break;
                        case 'voip':
                            $res = Helper::voipInfoByUserid((int) $_SESSION['user_id']);
                            break;
                        default:
                            die(Helper::Json_Message('f'));
                            break;
                    }
                    if ($res) {
                        die(json_encode($res));
                    } else {
                        die(Helper::Json_Message('nasf'));
                    }
                    break;
                case 'display_contract_sendsms':
                    switch ($_SESSION['user_type']) {
                        case __MOSHTARAKUSERTYPE__:
                            $rescontract = Helper::Select_By_Id('bnm_services_contract', (int) $_POST['request1']);
                            if (!$rescontract) {
                                die(Helper::Json_Message('f'));
                            }
                            switch ($rescontract[0]['service_type']) {
                                case 'adsl':
                                    $internalmessage = Helper::Internal_Message_By_Karbord('emzaadsl', 1);
                                    break;
                                case 'vdsl':
                                    $internalmessage = Helper::Internal_Message_By_Karbord('emzavdsl', 1);
                                    break;
                                case 'bitstream':
                                    $internalmessage = Helper::Internal_Message_By_Karbord('emzabitstream', 1);
                                    break;
                                case 'wireless':
                                    $internalmessage = Helper::Internal_Message_By_Karbord('emzawireless', 1);
                                    break;
                                case 'voip':
                                    $internalmessage = Helper::Internal_Message_By_Karbord('emzavoip', 1);
                                    break;
                                case 'tdlte':
                                    $internalmessage = Helper::Internal_Message_By_Karbord('emzatdlte', 1);
                                    break;
                                case 'ngn':
                                    $internalmessage = Helper::Internal_Message_By_Karbord('emzangn', 1);
                                    break;
                                default:
                                    die(Helper::Custom_Msg(Helper::Messages('inf'), 2));
                                    break;
                            }
                            if ($rescontract) {
                                if ($internalmessage) {
                                    $alreadysigned = Helper::checkContractSigned($_SESSION['user_id'], $rescontract[0]['id']);
                                    if (!$alreadysigned) {
                                        //gharardad emza nashode
                                        $user = Helper::Select_By_Id('bnm_subscribers', $_SESSION['user_id']);
                                        if ($user) {
                                            if (isset($user[0]['telephone_hamrah'])) {
                                                $code = Helper::randomNum(1100, 987654);
                                                if ($code) {
                                                    $_SESSION['contractcode'] = $code;
                                                    $sms = Helper::Send_Sms_Single($user[0]['telephone_hamrah'], $internalmessage[0]['message'] . ' ' . $_SESSION['contractcode']);
                                                    if (Helper::checkSmsResult($sms)) {
                                                        die(Helper::Custom_Msg(Helper::Messages('css'), 1));
                                                    } else {
                                                        $_SESSION['contractcode'] = false;
                                                        die(Helper::Custom_Msg(Helper::Messages('smsnotsent'), 2));
                                                    }
                                                } else {
                                                    die(Helper::Json_Message('f'));
                                                }
                                            } else {
                                                die(Helper::Json_Message('sinf'));
                                            }
                                        } else {
                                            die(Helper::Json_Message('f'));
                                        }
                                    } else {
                                        die(Helper::Json_Message('cas'));
                                    }
                                } else {
                                    die(Helper::Custom_Msg(Helper::Messages('inf'), 2));
                                }
                            } else {
                                die(Helper::Json_Message('f'));
                            }
                            break;
                        default:
                            die(Helper::Json_Message('af'));
                            break;
                    }
                    break;
                case 'get_countries':
                    $sql = "SELECT * FROM bnm_countries";
                    $res = Db::fetchall_Query($sql);
                    if ($res) {
                        die(json_encode($res));
                    } else {
                        die(Helper::Json_Message('f'));
                    }
                    break;
                case 'get_company_types':
                    $sql = "SELECT * FROM bnm_company_types";
                    $res = Db::fetchall_Query($sql);
                    if ($res) {
                        die(json_encode($res));
                    } else {
                        die(Helper::Json_Message('f'));
                    }
                    break;
                case 'ip':
                    $sql = "SELECT * FROM bnm_ip_pool_list";
                    $res = Db::fetchall_Query($sql);
                    if ($res) {
                        die(json_encode($res));
                    } else {
                        die(Helper::Json_Message('f'));
                    }
                    break;
                case 'getsubnet':
                    $sql = "SELECT * FROM bnm_subnetmask";
                    $res = Db::fetchall_Query($sql);
                    if ($res) {
                        die(json_encode($res));
                    } else {
                        die(Helper::Json_Message('f'));
                    }
                    break;
                case 'gettickethistory':
                    if ($_POST['request1']) {
                        $res = Helper::select_by_id('bnm_oss_tickets', $_POST['request1']);
                        if ($res) {
                            die(json_encode($res));
                        } else {
                            die(Helper::Json_Message('f'));
                        }
                    } else {
                        die(Helper::Custom_Msg(Helper::Messages('sao'), 2));
                    }
                    break;
                case 'sms_inbox':
                    $res_inbox = array();
                    $result = Helper::getMessages();
                    if ($result) {
                        $res_inbox = $result;
                        while ($result['messages']) {
                            $endsms = end($res_inbox['messages']);
                            $res_inbox = Helper::smsTimestampToDate($res_inbox);
                            $result = Helper::getMessages($endsms['messageId']);
                            if ($result) {
                                $res_inbox['messages'] = array_merge($res_inbox['messages'], $result['messages']);
                            }
                        }
                        die(json_encode($res_inbox));
                    } else {
                        die(Helper::Json_Message('f'));
                    }
                    break;
                case 'sent_sms':
                    $result = Helper::getSentMessagesByTime();
                    if ($result) {
                        $result = Helper::smsTimestampToDate($result);
                        die(json_encode($result));
                    } else {
                        die(Helper::Json_Message('f'));
                    }
                    break;
                    break;
                case 'equipments_models':
                    $sql = "SELECT * FROM bnm_equipments_brands";
                    $res = Db::fetchall_Query($sql);
                    if ($res) {
                        die(json_encode($res));
                    } else {
                        die(Helper::Json_Message('f'));
                    }
                    break;
                case 'get_branches_list':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                                $sql = "SELECT id,name_sherkat FROM bnm_branch";
                                $res = Db::fetchall_Query($sql);
                                if ($res) {
                                    die(json_encode($res));
                                } else {
                                    die(Helper::Json_Message('f'));
                                }

                                break;
                            default:
                                die(Helper::Json_Message('na'));
                                break;
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }

                    break;
                case 'bs_getportoruser':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                                if ($_POST['request1'] === 'port') {
                                    $sql = "SELECT res.id,res.oss_id,res.port,res.resid,CONCAT(sub.name,' ',sub.f_name) 'name','port' AS 'target',
                                    IF(oss.telephone=1,sub.telephone1,IF(oss.telephone=2,sub.telephone2,IF(oss.telephone=3,sub.telephone3,'شماره ایی ثبت نشده'))) telephone
                                    FROM bnm_oss_reserves res
                                    INNER JOIN bnm_oss_subscribers oss ON res.oss_id= oss.id
                                    INNER JOIN bnm_subscribers sub ON oss.user_id=sub.id
                                    WHERE res.errcode = ?";
                                    $res = Db::secure_fetchall($sql, array(0));
                                } elseif ($_POST['request1'] === 'subscriber') {
                                    $sql = "SELECT oss.id,oss.oss_id,CONCAT(sub.name,' ',sub.f_name) 'name','sub' AS 'target',
                                    IF(oss.telephone=1,sub.telephone1,IF(oss.telephone=2,sub.telephone2,IF(oss.telephone=3,sub.telephone3,'شماره ایی ثبت نشده'))) telephone
                                    FROM bnm_oss_subscribers oss
                                    INNER JOIN bnm_subscribers sub ON oss.user_id=sub.id
                                    ";
                                    $res = Db::fetchall_Query($sql);
                                } else {
                                    die(json_encode(array(array('target' => 'none', 'name' => 'بدون هدف', 'id' => 'none', 'telephone' => ''))));
                                }
                                break;
                        }
                        if ($res) {
                            die(json_encode($res));
                        } else {
                            die(Helper::Json_Message('f'));
                        }
                    }
                    break;
                case 'bs_getreserverequests':
                    if (Helper::Login_Just_Check()) {
                        $res = Helper::getOssReserveWaitingActive();
                        if ($res) {
                            die(json_encode($res));
                        } else {
                            die(Helper::Custom_Msg(Helper::Messages('inf'), 2));
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }

                    break;

                case 'bs_getosssubscribers':
                    if (Helper::Login_Just_Check()) {
                        $res = Helper::getBitstreamSubscribers();
                        if ($res) {
                            die(json_encode($res));
                        } else {
                            die(Helper::Custom_Msg(Helper::Messages('inf'), 2));
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }

                    break;
                case 'bs_getallsubscribers':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                                $sql = "SELECT id,name,f_name,code_meli FROM bnm_subscribers";
                                $res = Db::fetchall_Query($sql);
                                break;
                            case __MODIRUSERTYPE__:
                            case __OPERATORUSERTYPE__:
                            case __MODIR2USERTYPE__:
                            case __OPERATOR2USERTYPE__:
                                $sql = "SELECT id,name,f_name,code_meli FROM bnm_subscribers WHERE branch_id = ?";
                                $res = Db::secure_fetchall($sql, array($_SESSION['branch_id']), true);
                                break;
                            default:
                                die(Helper::Json_Message('na'));
                                break;
                        }
                        die(json_encode($res));
                        if ($res) {
                            die(json_encode($res));
                        } else {
                            die(Helper::Json_Message('f'));
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }

                    break;
                case 'bs_get_telecenters':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                            case __MODIRUSERTYPE__:
                            case __OPERATORUSERTYPE__:
                            case __MODIR2USERTYPE__:
                            case __OPERATOR2USERTYPE__:
                                $res = $GLOBALS['bs']->getLocation();
                                // die(json_encode($res));
                                if ($GLOBALS['bs']->errorCheck($res)) {
                                    die(json_encode($res['result']));
                                } else {
                                    die($GLOBALS['bs']->getMessage($res));
                                }

                                break;
                            default:
                                die(Helper::Json_Message('na'));
                                break;
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }

                    break;
                case 'internal_message_by_karbord':
                    $sql = "SELECT * FROM bnm_internal_messages WHERE karbord = ?";
                    $res = Db::secure_fetchall($sql, array($_POST['request1']));
                    if ($res) {
                        die(json_encode($res));
                    } else {
                        die(Helper::Json_Message('f'));
                    }

                    break;
                case 'internal_messages':
                    $sql = "SELECT * FROM bnm_internal_messages WHERE karbord=?";
                    $res = Db::secure_fetchall($sql, array('sms'));
                    if ($res) {
                        die(Json_encode($res));
                    } else {
                        die(Helper::Json_Message('f'));
                    }

                    break;
                case 'get_messages_list_shortend':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                                //$_POST = Helper::xss_check_array($_POST);
                                $sql = "SELECT id,LEFT(message,10) as message,message_subject FROM bnm_messages WHERE type= 1";
                                $res = Db::fetchall_Query($sql);
                                if ($res) {
                                    die(json_encode($res));
                                } else {
                                    die(Helper::Json_Message('f'));
                                }
                                break;
                            default:
                                die(Helper::Json_Message('af'));
                                break;
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }
                    break;
                case 'getassignedbanks':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                                //$_POST = Helper::xss_check_array($_POST);
                                $sql = "SELECT b.id , b.name, f.file_subject
                                FROM bnm_banks b
                                INNER JOIN bnm_upload_file f ON b.file_id = f.id
                                ";
                                $res = Db::fetchall_Query($sql);
                                if ($res) {
                                    die(json_encode($res));
                                } else {
                                    die(Helper::Json_Message('f'));
                                }
                                break;
                            default:
                                die(Helper::Json_Message('af'));
                                break;
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }
                    break;
                case 'add_to_bank_banklist':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                                //$_POST = Helper::xss_check_array($_POST);
                                $sql = "SELECT * FROM bnm_banks";
                                $res = Db::fetchall_Query($sql);
                                if ($res) {
                                    die(json_encode($res));
                                } else {
                                    die(Helper::Json_Message('f'));
                                }
                                break;
                            default:
                                die(Helper::Json_Message('af'));
                                break;
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }
                    break;
                case 'add_to_bank_filelist':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                                //$_POST = Helper::xss_check_array($_POST);
                                $sql = "SELECT * FROM bnm_upload_file WHERE file_type IN ('xlsx','csv')";
                                $res = Db::fetchall_Query($sql);
                                if ($res) {
                                    die(json_encode($res));
                                } else {
                                    die(Helper::Json_Message('f'));
                                }
                                break;
                            default:
                                die(Helper::Json_Message('af'));
                                break;
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }
                    break;
                case 'display_contract_by_id':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __MOSHTARAKUSERTYPE__:
                            case __ADMINUSERTYPE__:
                                $_POST = Helper::xss_check_array($_POST);
                                $sql = "SELECT * FROM bnm_services_contract WHERE id =?";
                                $res = Db::secure_fetchall($sql, array($_POST['request1']));
                                if ($res) {
                                    die(json_encode($res));
                                } else {
                                    die(Helper::Json_Message('f'));
                                }
                                break;
                            default:
                                die(Helper::Json_Message('af'));
                                break;
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }

                    break;
                case 'display_contract':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                            case __MOSHTARAKUSERTYPE__:
                                $sql = "SELECT * FROM bnm_services_contract";
                                $res = Db::fetchall_Query($sql);
                                if ($res) {
                                    die(json_encode($res));
                                } else {
                                    die(Helper::Json_Message('f'));
                                }
                                break;
                            default:
                                die(Helper::Json_Message('af'));
                                break;
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }

                    break;
                case 'services_contract':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                                $sql = "SELECT * FROM bnm_services GROUP BY type";
                                $res = Db::fetchall_Query($sql);
                                if ($res) {
                                    die(json_encode($res));
                                } else {
                                    die(Helper::Json_Message('f'));
                                }

                                break;
                            default:
                                die(Helper::Json_Message('af'));
                                break;
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }

                    break;
                case 'personal_information':
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                        case __MODIRUSERTYPE__:
                        case __OPERATORUSERTYPE__:
                        case __MODIR2USERTYPE__:
                        case __OPERATOR2USERTYPE__:
                            die(Helper::Json_Message('af'));
                            break;
                        case __MOSHTARAKUSERTYPE__:
                            $sql = "SELECT * FROM bnm_subscribers WHERE id=?";
                            $result = Db::secure_fetchall($sql, array($_SESSION['user_id']));
                            if ($result) {
                                die(json_encode($result));
                            } else {
                                die(Helper::Json_Message('sint'));
                            }

                            break;
                        default:
                            die(Helper::Json_Message('af'));
                            break;
                    }
                    break;
                case 'change_service_password':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                                $sql = "SELECT id,ibs_username,
                                IF(type IN ('adsl','vdsl','wireless','tdlte'),'internet',
                                IF(type IN ('voip'),'voip','notfound')) as 'type' FROM bnm_factor WHERE ibs_username<>'' AND ibs_username IS NOT NULL
                                AND type <>'' AND type IS NOT NULL AND tasvie_shode = ?
                                GROUP BY ibs_username,type";
                                $result = Db::secure_fetchall($sql, array(1));
                                if ($result) {
                                    die(json_encode($result));
                                } else {
                                    die(Helper::Json_Message('f'));
                                }
                                break;
                            case __MODIRUSERTYPE__:
                            case __OPERATORUSERTYPE__:
                            case __MODIR2USERTYPE__:
                            case __OPERATOR2USERTYPE__:
                                $sql = "SELECT id,ibs_username,
                                IF(type IN ('adsl','vdsl','wireless','tdlte'),'internet',
                                IF(type IN ('voip'),'voip','notfound')) as 'type' FROM bnm_factor WHERE ibs_username<>'' AND ibs_username IS NOT NULL
                                AND type <>'' AND type IS NOT NULL
                                AND branch_id=? AND tasvie_shode = ?
                                GROUP BY ibs_username,type";
                                $result = Db::secure_fetchall($sql, array($_SESSION['branch_id'], 1));
                                if ($result) {
                                    die(json_encode($result));
                                } else {
                                    die(Helper::Json_Message('f'));
                                }
                                break;
                            case __MOSHTARAKUSERTYPE__:
                                $sql = "SELECT id,ibs_username,
                                IF(type IN ('adsl','vdsl','wireless','tdlte'),'internet',
                                IF(type IN ('voip'),'voip','notfound')) as 'type' FROM bnm_factor WHERE subscriber_id=? AND branch_id=? AND ibs_username<>'' AND ibs_username IS NOT NULL
                                AND type <>'' AND type IS NOT NULL AND tasvie_shode = ?
                                GROUP BY ibs_username,type";
                                $result = Db::secure_fetchall($sql, array($_SESSION['user_id'], $_SESSION['branch_id'], 1));
                                if ($result) {
                                    die(json_encode($result));
                                } else {
                                    die(Helper::Json_Message('f'));
                                }
                                break;

                            default:
                                die(Helper::Json_Message('af'));
                                break;
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }

                    break;
                case 'support_requests_compose':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:

                                die(Helper::Json_Message('no_access'));
                                break;
                            case __MODIRUSERTYPE__:
                            case __OPERATORUSERTYPE__:
                            case __MODIR2USERTYPE__:
                            case __OPERATOR2USERTYPE__:
                            case __MOSHTARAKUSERTYPE__:
                                //1=poshtibani
                                //2=sla
                                //3=jam avari
                                //4=sayer
                                $noe_darkhast = array();
                                array_push($noe_darkhast, '1');
                                array_push($noe_darkhast, '2');
                                array_push($noe_darkhast, '3');
                                array_push($noe_darkhast, '4');
                                die(json_encode($noe_darkhast));
                                break;
                            default:
                                die(Helper::Json_Message('af'));
                                break;
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }

                    break;

                // case 'restrictions_menu':
                //     if (Helper::Login_Just_Check()) {
                //         switch ($_SESSION['user_type']) {
                //             case __ADMINUSERTYPE__:
                //                 $sql    = "select * from bnm_dashboard_menu";
                //                 $result = Db::fetchall_Query($sql);
                //                 die(json_encode($result));
                //                 break;
                //             case __MODIRUSERTYPE__:
                //                 $where_menu_ids = "";
                //                 $menu_access    = Db::secure_fetchall("SELECT * FROM bnm_dashboard_menu_access WHERE operator_id = ?", array($_SESSION['user_id']));
                //                 if ($menu_access) {
                //                     for ($i = 0; $i < count($menu_access); $i++) {
                //                         if ($i == count($menu_access) - 1) {
                //                             $where_menu_ids .= $menu_access[$i]['menu_id'];
                //                         } else {
                //                             $where_menu_ids .= $menu_access[$i]['menu_id'] . ',';
                //                         }
                //                     }
                //                     $dashboard_access_list = Db::fetchall_Query("SELECT * FROM bnm_dashboard_menu WHERE id IN ($where_menu_ids)");
                //                     if ($dashboard_access_list) {
                //                         die(json_encode($dashboard_access_list));
                //                     } else {
                //                         die(Helper::Json_Message('f'));
                //                     }

                //                 } else {
                //                     die(Helper::Json_Message('f'));
                //                 }

                //                 break;
                //             case __MODIR2USERTYPE__:
                //                 $where_menu_ids = "";
                //                 $menu_access    = Db::secure_fetchall("SELECT * FROM bnm_dashboard_menu_access WHERE operator_id = ?", array($_SESSION['user_id']));
                //                 if ($menu_access) {
                //                     for ($i = 0; $i < count($menu_access); $i++) {
                //                         if ($i == count($menu_access) - 1) {
                //                             $where_menu_ids .= $menu_access[$i]['menu_id'];
                //                         } else {
                //                             $where_menu_ids .= $menu_access[$i]['menu_id'] . ',';
                //                         }
                //                     }
                //                     $dashboard_access_list = Db::fetchall_Query("SELECT * FROM bnm_dashboard_menu WHERE id IN ($where_menu_ids)");
                //                     if ($dashboard_access_list) {
                //                         die(json_encode($dashboard_access_list));
                //                     } else {
                //                         die(Helper::Json_Message('f'));
                //                     }

                //                 } else {
                //                     die(Helper::Json_Message('f'));
                //                 }

                //                 break;
                //             case __ADMINOPERATORUSERTYPE__:
                //                 $where_menu_ids = "";
                //                 $menu_access    = Db::secure_fetchall("SELECT * FROM bnm_dashboard_menu_access WHERE operator_id = ?", array($_SESSION['user_id']));
                //                 if ($menu_access) {
                //                     for ($i = 0; $i < count($menu_access); $i++) {
                //                         if ($i == count($menu_access) - 1) {
                //                             $where_menu_ids .= $menu_access[$i]['menu_id'];
                //                         } else {
                //                             $where_menu_ids .= $menu_access[$i]['menu_id'] . ',';
                //                         }
                //                     }
                //                     $dashboard_access_list = Db::fetchall_Query("SELECT * FROM bnm_dashboard_menu WHERE id IN ($where_menu_ids)");
                //                     if ($dashboard_access_list) {
                //                         die(json_encode($dashboard_access_list));
                //                     } else {
                //                         die(Helper::Json_Message('f'));
                //                     }

                //                 } else {
                //                     die(Helper::Json_Message('f'));
                //                 }

                //                 break;
                //             default:
                //                 die(Helper::Json_Message('af'));
                //                 break;
                //         }
                //     } else {
                //         die(Helper::Json_Message('af'));
                //     }

                // break;
                case 'restrictions_initialize':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                                $sql = "SELECT id,name_sherkat,baladasti_id FROM bnm_branch";
                                $res = Db::fetchall_Query($sql);

                                break;
                            case __ADMINOPERATORUSERTYPE__:
                                $sql = "SELECT id,name_sherkat,baladasti_id FROM bnm_branch";
                                $res = Db::fetchall_Query($sql);
                                break;
                            case __MODIRUSERTYPE__:
                            case __MODIR2USERTYPE__:
                                $sql = "SELECT id,name_sherkat,baladasti_id FROM bnm_branch WHERE id = ?";
                                $res = Db::secure_fetchall($sql, array($_SESSION['branch_id']), true);
                                break;
                        }
                        if ($res) {
                            die(json_encode($res));
                        } else {
                            die(Helper::Json_Message('f'));
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }

                    break;
                case 'restrictions_getoperatorsbybranch':
                    // die(json_encode(array('asd')));
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                            $sql = "SELECT o.id operator_id,o.name name,o.name_khanevadegi name_khandevadegi,o.user_type,b.id branch_id,b.name_sherkat,
                            CASE
                                WHEN o.user_type = " . __MODIRUSERTYPE__ . " OR o.user_type = " . __MODIR2USERTYPE__ . " THEN 'مدیر'
                                WHEN o.user_type = " . __OPERATORUSERTYPE__ . " OR o.user_type = " . __OPERATOR2USERTYPE__ . " THEN 'اپراتور'
                                END as user_type_fa
                            FROM bnm_branch b
                            INNER JOIN bnm_operator o ON o.branch_id = b.id
                            WHERE b.id= ? AND o.branch_id IS NOT NULL
                            ";
                            $result = Db::secure_fetchall($sql, array($_POST['request1']));
                            // $sql = "SELECT buser.id as id,boperator.name as name,boperator.name_khanevadegi as name_khanevadegi,bbranch.name_sherkat as name_sherkat
                            //             FROM bnm_users buser
                            //               INNER JOIN bnm_operator boperator ON buser.user_id = boperator.id
                            //               INNER JOIN bnm_branch bbranch ON boperator.branch_id = bbranch.id
                            //             WHERE
                            //                 buser.user_type IN (?,?) AND boperator.user_type IN (?,?)";
                            // $result = Db::secure_fetchall($sql, array(__OPERATORUSERTYPE__,__OPERATOR2USERTYPE__,__OPERATORUSERTYPE__,__OPERATOR2USERTYPE__), true);

                            break;
                        case __MODIRUSERTYPE__:
                            $sql = "SELECT o.id operator_id,o.name name,o.name_khanevadegi name_khandevadegi,o.user_type,b.id branch_id,b.name_sherkat,
                            CASE
                                WHEN o.user_type = " . __OPERATORUSERTYPE__ . " OR o.user_type = " . __OPERATOR2USERTYPE__ . " THEN 'اپراتور'
                                END as user_type_fa
                            FROM bnm_branch b
                            INNER JOIN bnm_operator o ON o.branch_id = b.id
                            WHERE b.id= ? AND o.branch_id IS NOT NULL AND o.branch_id = ?
                            AND o.user_type <> ? AND o.user_type <> ? AND o.id <> ?
                            ";
                            $result = Db::secure_fetchall($sql, array($_POST['request1'], $_SESSION['branch_id'], __MODIRUSERTYPE__, __MODIR2USERTYPE__, $_SESSION['user_id']));
                            // $sql = "SELECT buser.id as id,boperator.name as name,boperator.name_khanevadegi as name_khanevadegi,bbranch.name_sherkat as name_sherkat
                            //             FROM bnm_users buser
                            //               INNER JOIN bnm_operator boperator ON buser.user_id = boperator.id
                            //               INNER JOIN bnm_branch bbranch ON boperator.branch_id = bbranch.id
                            //             WHERE
                            //                 buser.user_type IN (?) AND boperator.user_type IN (?) AND bbranch.branch_id = ? AND boperator.branch_id = ? AND buser.branch_id = ?";
                            // $result = Db::secure_fetchall($sql, array(__OPERATORUSERTYPE__,__OPERATORUSERTYPE__,$_SESSION['branch_id'],$_SESSION['branch_id'],$_SESSION['branch_id'],), true);
                            break;
                        case __MODIR2USERTYPE__:
                            $sql = "SELECT o.id operator_id,o.name name,o.name_khanevadegi name_khandevadegi,o.user_type,b.id branch_id,b.name_sherkat,
                            CASE
                                WHEN o.user_type = " . __OPERATORUSERTYPE__ . " OR o.user_type = " . __OPERATOR2USERTYPE__ . " THEN 'اپراتور'
                                END as user_type_fa
                            FROM bnm_branch b
                            INNER JOIN bnm_operator o ON o.branch_id = b.id
                            WHERE b.id= ? AND o.branch_id IS NOT NULL AND o.branch_id = ?
                            AND o.user_type <> ? AND o.user_type <> ? AND o.id <> ?
                            ";
                            $result = Db::secure_fetchall($sql, array($_POST['request1'], $_SESSION['branch_id'], __MODIR2USERTYPE__, __MODIRUSERTYPE__, $_SESSION['user_id']));
                            // $sql = "SELECT buser.id as id,boperator.name as name,boperator.name_khanevadegi as name_khanevadegi,bbranch.name_sherkat as name_sherkat
                            //             FROM bnm_users buser
                            //               INNER JOIN bnm_operator boperator ON buser.user_id = boperator.id
                            //               INNER JOIN bnm_branch bbranch ON boperator.branch_id = bbranch.id
                            //             WHERE
                            //                 buser.user_type IN (?) AND boperator.user_type IN (?) AND bbranch.branch_id = ? AND boperator.branch_id = ? AND buser.branch_id = ?";
                            // $result = Db::secure_fetchall($sql, array(__OPERATOR2USERTYPE__,__OPERATOR2USERTYPE__,$_SESSION['branch_id'],$_SESSION['branch_id'],$_SESSION['branch_id'],), true);
                            break;
                        default:
                            die(Helper::Json_Message('af'));
                            break;
                    }
                    if ($result) {
                        die(json_encode($result));
                    } else {
                        die(Helper::Json_Message('f'));
                    }

                    break;
                case 'credits_page_initialize':
                    if (Helper::Login_Just_Check()) {
                        die(Helper::Json_Message('af'));
                        // switch ($_SESSION['user_type']) {
                        //     case '1':
                        //         #admin

                        //         break;
                        //     case '2':
                        //         #modir
                        //         break;
                        //     case '3':
                        //         #modir-operator
                        //         break;
                        //     case '4':
                        //         #subscriber
                        //         break;

                        //     default:
                        //         die(Helper::Json_Message('auth_fail'));
                        //         break;
                        // }
                    } else {
                        die(Helper::Json_Message('auth_fail'));
                    }
                    break;
                case 'factor_modify':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                                $sql = "SELECT * FROM bnm_factor";
                                $res = Db::fetchall_Query($sql);
                                if ($res) {
                                    die(json_encode($res));
                                } else {
                                    die(Helper::Json_Message('f'));
                                }

                                break;
                            case __MODIRUSERTYPE__:
                            case __OPERATORUSERTYPE__:
                            case __MODIR2USERTYPE__:
                            case __OPERATOR2USERTYPE__:
                            case __MOSHTARAKUSERTYPE__:
                                $sql = "SELECT * FROM bnm_factor WHERE branch_id=?";
                                $res = Db::secure_fetchall($sql, array($_SESSION['branch_id']));
                                if ($res) {
                                    die(json_encode($res));
                                } else {
                                    die(Helper::Json_Message('f'));
                                }

                                break;

                            default:
                                die(Helper::Json_Message('af'));
                                break;
                        }
                    }

                    break;
                case 'ostan':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                                $sql = "SELECT * FROM bnm_countries";
                                $res = Db::fetchall_Query($sql);
                                die(json_encode($res));
                                break;
                            default:
                                die(Helper::Json_Message('af'));
                                break;
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }

                    break;
                case 'city':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                                $sql = "SELECT * FROM bnm_shahr";
                                $res = Db::fetchall_Query($sql);
                                die(json_encode($res));
                                break;
                            default:
                                die(Helper::Json_Message('af'));
                                break;
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }

                    break;
                case 'get_dist_services_list':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                                $sql = "SELECT id,type,noe_khadamat FROM bnm_services GROUP BY noe_khadamat";
                                $res = Db::fetchall_Query($sql);

                                die(json_encode($res));

                                break;
                            default:
                                die(Helper::Json_Message('na'));
                                break;
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }

                    break;
                case 'restrictions_menu_initialize':
                    if (Helper::Login_Just_Check()) {
                        unset($_POST["restrictions_menu_initialize"]);
                        $_POST = Helper::xss_check_array($_POST);
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                                $sql = "SELECT o.id,o.name,o.name_khanevadegi,o.branch_id,o.user_type,b.baladasti_id baladasti_id
                                FROM bnm_operator o
                                INNER JOIN bnm_branch b ON o.branch_id = b.id
                                WHERE o.id= ?";
                                $res1 = Db::secure_fetchall($sql, array($_POST['request1']));
                                if ($res1) {
                                    if ($res1[0]['baladasti_id'] === 0) {
                                        //namayande sathe 1
                                        $sql = "SELECT d.id, d.fa_name , d.en_name, d.category_id cat_id,c.name,c.sort
                                        FROM bnm_dashboard_menu d
                                        INNER JOIN bnm_dashboard_menu_category c
                                        ON d.category_id = c.id
                                        WHERE d.branch_display = ? ORDER BY c.sort";
                                        $res_menu = Db::secure_fetchall($sql, array(1));
                                    } else {
                                        //namayande sathe 2
                                        $sql = "SELECT d.id, d.fa_name , d.en_name, d.category_id cat_id,c.name,c.sort
                                        FROM bnm_dashboard_menu d
                                        INNER JOIN bnm_dashboard_menu_category c
                                        ON d.category_id = c.id
                                        WHERE d.branch_display = ? ORDER BY c.sort";
                                        $res_menu = Db::secure_fetchall($sql, array(1));
                                    }
                                    if ($res_menu) {
                                    } else {
                                        die(Helper::Custom_Msg(Helper::Messages('f')));
                                    }
                                } else {
                                    die(Helper::Json_Message('f'));
                                }
                            break;
                            case __MODIRUSERTYPE__:
                                $sql = "SELECT o.id,o.name,o.name_khanevadegi,o.branch_id,o.user_type,b.baladasti_id baladasti_id
                                FROM bnm_operator o
                                INNER JOIN bnm_branch b ON o.branch_id = b.id
                                WHERE o.id= ? AND o.id <> ? AND o.branch_id = ? AND o.user_type = ?";
                                $res1 = Db::secure_fetchall($sql, array($_POST['request1'], $_SESSION['user_id'], $_SESSION['branch_id'], __OPERATORUSERTYPE__));
                                if ($res1) {
                                    if ($res1[0]['baladasti_id'] === 0) {
                                        //namayande sathe 1
                                        $sql = "SELECT d.id, d.fa_name , d.en_name, d.category_id cat_id,c.name,c.sort
                                        FROM bnm_dashboard_menu d
                                        INNER JOIN bnm_dashboard_menu_category c
                                        ON d.category_id = c.id
                                        WHERE d.branch_display = ? ORDER BY c.sort";
                                        $res_menu = Db::secure_fetchall($sql, array(1));
                                    } else {
                                        //namayande sathe 2
                                        $sql = "SELECT d.id, d.fa_name , d.en_name, d.category_id cat_id,c.name,c.sort
                                        FROM bnm_dashboard_menu d
                                        INNER JOIN bnm_dashboard_menu_category c
                                        ON d.category_id = c.id
                                        WHERE d.branch_display = ? ORDER BY c.sort";
                                        $res_menu = Db::secure_fetchall($sql, array(1));
                                    }
                                } else {
                                    die(Helper::Json_Message('f'));
                                }
                                break;
                            case __MODIR2USERTYPE__:
                                $sql = "SELECT o.id,o.name,o.name_khanevadegi,o.branch_id,o.user_type,b.baladasti_id baladasti_id
                                FROM bnm_operator o
                                INNER JOIN bnm_branch b ON o.branch_id = b.id
                                WHERE o.id= ? AND o.id <> ? AND o.branch_id = ? AND o.user_type = ?";
                                $res1 = Db::secure_fetchall($sql, array($_POST['request1'], $_SESSION['user_id'], $_SESSION['branch_id'], __OPERATOR2USERTYPE__));
                                if ($res1) {
                                    if ($res1[0]['baladasti_id'] === 0) {
                                        //namayande sathe 1
                                        $sql = "SELECT d.id, d.fa_name , d.en_name, d.category_id cat_id,c.name,c.sort
                                        FROM bnm_dashboard_menu d
                                        INNER JOIN bnm_dashboard_menu_category c
                                        ON d.category_id = c.id
                                        WHERE d.branch_display = ? ORDER BY c.sort";
                                        $res_menu = Db::secure_fetchall($sql, array(1));
                                    } else {
                                        //namayande sathe 2
                                        $sql = "SELECT d.id, d.fa_name , d.en_name, d.category_id cat_id,c.name,c.sort
                                        FROM bnm_dashboard_menu d
                                        INNER JOIN bnm_dashboard_menu_category c
                                        ON d.category_id = c.id
                                        WHERE d.branch2_display = ? ORDER BY c.sort";
                                        $res_menu = Db::secure_fetchall($sql, array(1));
                                    }
                                } else {
                                    die(Helper::Json_Message('f'));
                                }
                                break;
                            default:
                                die(Helper::Json_Message('na'));
                                break;
                        }
                        if ($res_menu) {
                            die(json_encode($res_menu));
                        } else {
                            die(Helper::Custom_Msg(Helper::Messages('f')));
                        }
                    } else {
                        die(Helper::Json_Message('f'));
                    }
                    break;
                case 'dashboard_menu_group_access_current_access_list':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                                unset($_POST["dashboard_menu_group_access_current_access_list"]);
                                $_POST = Helper::xss_check_array($_POST);
                                if (isset($_POST['request1'])) {
                                    switch ($_POST['request1']) {
                                        case '1':
                                            $sql = "SELECT id FROM bnm_dashboard_menu WHERE admin_display=?";
                                            $res = Db::secure_fetchall($sql, array(1));
                                            if ($res) {
                                                die(json_encode($res));
                                            } else {
                                                die(json_encode(array()));
                                            }
                                            break;
                                        case '2':
                                            $sql = "SELECT id FROM bnm_dashboard_menu WHERE branch_display=?";
                                            $res = Db::secure_fetchall($sql, array(1));
                                            if ($res) {
                                                die(json_encode($res));
                                            } else {
                                                die(json_encode(array()));
                                            }
                                            break;
                                        case '3':
                                            $sql = "SELECT id FROM bnm_dashboard_menu WHERE branch2_display=?";
                                            $res = Db::secure_fetchall($sql, array(1));
                                            if ($res) {
                                                die(json_encode($res));
                                            } else {
                                                die(json_encode(array()));
                                            }
                                            break;
                                        case '4':
                                            $sql = "SELECT id FROM bnm_dashboard_menu WHERE admin_operator_display=?";
                                            $res = Db::secure_fetchall($sql, array(1));
                                            if ($res) {
                                                die(json_encode($res));
                                            } else {
                                                die(json_encode(array()));
                                            }
                                            break;
                                        case '5':
                                            $sql = "SELECT id FROM bnm_dashboard_menu WHERE subscriber_display=?";
                                            $res = Db::secure_fetchall($sql, array(1));
                                            if ($res) {
                                                die(json_encode($res));
                                            } else {
                                                die(json_encode(array()));
                                            }
                                            break;

                                        default:
                                            die(Helper::Json_Message('rinf'));
                                            break;
                                    }
                                }
                            default:
                                die(Helper::Json_Message('f'));
                                break;
                        }
                    } else {
                        die(Helper::Json_Message('f'));
                    }

                    break;
                case 'dashboard_menu_group_access':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                                $sql = "SELECT * FROM bnm_dashboard_menu";
                                $res = Db::fetchall_Query($sql);
                                die(json_encode($res));
                                break;
                            default:
                                die(Helper::Json_Message('af'));
                                break;
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }

                    break;

                default:
                    die(Helper::Json_Message('f'));
                    break;
            }
        }
        /*==========edit form============*/
        if (isset($_POST['Edit_Form'])) {
            $page = $_POST['Edit_Form'];
            switch ($page) {
                case 'ip_pool_list':
                    if (Helper::check_update_access('ip_pool_list')) {
                        $sql = "SELECT * FROM bnm_ip_pool_list WHERE id=?";
                        $result = Db::secure_fetchall($sql, array($_POST['condition']));
                        if ($result) {
                            $result = json_encode($result);
                            die($result);
                        } else {
                            die(Helper::Json_Message('f'));
                        }

                    } else {
                        die(Helper::Json_Message('na'));
                    }

                    break;
                case 'equipments_models':
                    if (Helper::check_update_access('equipments_models')) {
                        $sql = "SELECT * FROM bnm_equipments_models WHERE id=?";
                        $result = Db::secure_fetchall($sql, array($_POST['condition']));
                        if ($result) {
                            $result = json_encode($result);
                            die($result);
                        } else {
                            die(Helper::Json_Message('f'));
                        }

                    } else {
                        die(Helper::Json_Message('na'));
                    }

                    break;
                case 'equipments_brands':
                    if (Helper::check_update_access('equipments_brands')) {
                        $sql = "SELECT * FROM bnm_equipments_brands WHERE id=?";
                        $result = Db::secure_fetchall($sql, array($_POST['condition']));
                        if ($result) {
                            $result = json_encode($result);
                            die($result);
                        } else {
                            die(Helper::Json_Message('f'));
                        }

                    } else {
                        die(Helper::Json_Message('na'));
                    }

                    break;
                case 'messages':
                    if (Helper::check_update_access('messages')) {
                        $sql = "SELECT * FROM bnm_messages WHERE id=?";
                        $result = Db::secure_fetchall($sql, array($_POST['condition']));
                        $rows = json_encode($result);
                        die($rows);
                    } else {
                        die(Helper::Json_Message('na'));
                    }

                    break;
                case 'banks':
                    $sql = "SELECT * FROM bnm_banks WHERE id=?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'services_contract':
                    $sql = "SELECT * FROM bnm_services_contract WHERE id=?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'organization_level':
                    $sql = "SELECT * FROM bnm_organization_level WHERE id= ?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'branch_cooperation_type':
                    $sql = "SELECT * FROM bnm_branch_cooperation_type WHERE id=?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'pre_number':
                        $sql="SELECT
                            pr.id,
                            pr.prenumber,
                            pr.markaze_mokhaberati
                            -- CONCAT(tc.name, ' (',sh.name,') ') os_tc_name
                        FROM
                            bnm_pre_number pr
                            INNER JOIN bnm_telecommunications_center tc ON tc.id = pr.markaze_mokhaberati
                            INNER JOIN bnm_ostan os ON os.id = tc.ostan
                            INNER JOIN bnm_shahr sh ON sh.id = tc.shahr
                            WHERE pr.id = ?";

                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    // $markaz_id = $result[0]["markaze_mokhaberati"];
                    // $sql2 = "SELECT name FROM bnm_telecommunications_center WHERE id = ?";
                    // $result2 = Db::secure_fetchall($sql2, array($markaz_id));
                    // $result[0]['markaz_name'] = $result2[0]['name'];
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'modir':
                    // $sql = "SELECT * FROM bnm_operator WHERE id=? AND user_type=?";
                    // $result = Db::secure_fetchall($sql, array($_POST['condition'], __MODIRUSERTYPE__), true);
                    $sql="SELECT
                            s.*,
                            c.id AS city_id,
                            c.name city_name,
                            o.id ostan_tavalod_id,
                            o.name ostan_tavalod_name,
                            os.id ostan_sokonat_id,
                            os.name ostan_sokonat_name,
                            cs.id shahr_sokonat_id,
                            cs.name shahr_sokonat_name 
                        FROM
                            bnm_operator s
                            LEFT JOIN bnm_shahr c ON s.shahr_tavalod = c.id
                            LEFT JOIN bnm_shahr cs ON s.shahr_sokonat = cs.id
                            LEFT JOIN bnm_ostan o ON s.ostan_tavalod = o.id
                            LEFT JOIN bnm_ostan os ON s.ostan_sokonat = os.id
                        WHERE
                            s.id = ?";
                    $result= Db::secure_fetchall($sql, array($_POST['condition']));
                    die(json_encode($result));
                    break;
                case 'noe_terminal':
                    $sql = "SELECT * FROM bnm_noe_terminal WHERE id=?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'services_voip':
                    $sql = "SELECT * FROM bnm_services WHERE id=?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'equipments_brands':
                    if (Helper::check_update_access('equipments_brands')) {
                        $sql = "SELECT * FROM equipments_brands WHERE id= ?";
                        $result = Db::secure_fetchall($sql, array($_POST['condition']));
                        $rows = json_encode($result);
                        die($rows);
                    } else {
                        die(Helper::Json_Message('na'));
                    }

                    break;
                case 'countries':
                    $sql = "SELECT * FROM bnm_countries WHERE id=?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'ostan':

                    $sql = "SELECT bo.id,bo.name,bo.pish_shomare_ostan,bo.code_ostan_shahkar,bo.code_markazeostan,
                        bo.code_atrafemarkazeostan,bo.code_biaban,bo.code_shahrestan,bo.code_atrafeshahrestan,bc.id c_id,
                        bc.name c_name
                        FROM bnm_ostan bo
                        LEFT JOIN bnm_countries bc ON bo.country_id = bc.id
                        WHERE bo.id= ? ";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'connection_log_postfix':
                    $sql = "SELECT * FROM bnm_connection_log WHERE id=?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'tax':
                    $sql = "SELECT * FROM bnm_tax WHERE id=?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'services_bs':
                    $sql = "SELECT * FROM bnm_services WHERE id=?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'services_adsl':
                    $sql = "SELECT * FROM bnm_services WHERE id=?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'services_wireless':
                    $sql = "SELECT * FROM bnm_services WHERE id=?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'services_tdlte':
                    $sql = "SELECT * FROM bnm_services WHERE id=?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'real_subscribers':
                    $sql = "SELECT
                            s.*,
                            c.id AS city_id,
                            c.name city_name,
                            o.id ostan_id,
                            o.name ostan_name,
                            t1o.id tel1_ostan_id,
                            t1o.name tel1_ostan_name,
                            t2o.id tel2_ostan_id,
                            t2o.name tel2_ostan_name,
                            t3o.id tel3_ostan_id,
                            t3o.name tel3_ostan_name,
                            t1s.id tel1_shahr_id,
                            t1s.name tel1_shahr_name,
                            t2s.id tel2_shahr_id,
                            t2s.name tel2_shahr_name,
                            t3s.id tel3_shahr_id,
                            t3s.name tel3_shahr_name,
                            os.id ostane_sokonat_id,
                            os.name ostane_sokonat_name,
                            cs.id shahre_sokonat_id,
                            cs.name shahre_sokonat_name
                        FROM
                            bnm_subscribers s
                            LEFT JOIN bnm_shahr c ON s.shahre_tavalod = c.id
                            LEFT JOIN bnm_shahr cs ON s.shahre_sokonat = cs.id
                            LEFT JOIN bnm_ostan o ON s.ostane_tavalod = o.id
                            LEFT JOIN bnm_ostan os ON s.ostane_sokonat = os.id
                            LEFT JOIN bnm_ostan t1o ON s.tel1_ostan = t1o.id
                            LEFT JOIN bnm_ostan t2o ON s.tel2_ostan = t2o.id
                            LEFT JOIN bnm_ostan t3o ON s.tel3_ostan = t3o.id
                            LEFT JOIN bnm_shahr t1s ON s.tel1_ostan = t1s.id
                            LEFT JOIN bnm_ostan t2s ON s.tel2_ostan = t2s.id
                            LEFT JOIN bnm_ostan t3s ON s.tel3_ostan = t3s.id 
                        WHERE
                            s.id = ?
                        ";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    if ($result) {
                        die(json_encode($result));
                    } else {
                        die(Helper::Json_Message('f'));
                    }

                    break;
                case 'legal_subscribers':
                    $sql = "SELECT
                            s.*,
                            c.id AS city_id,
                            c.name city_name,
                            o.id ostan_id,
                            o.name ostan_name,
                            t1o.id tel1_ostan_id,
                            t1o.name tel1_ostan_name,
                            t2o.id tel2_ostan_id,
                            t2o.name tel2_ostan_name,
                            t3o.id tel3_ostan_id,
                            t3o.name tel3_ostan_name,
                            t1s.id tel1_shahr_id,
                            t1s.name tel1_shahr_name,
                            t2s.id tel2_shahr_id,
                            t2s.name tel2_shahr_name,
                            t3s.id tel3_shahr_id,
                            t3s.name tel3_shahr_name,
                            os.id ostane_sokonat_id,
                            os.name ostane_sokonat_name,
                            cs.id shahre_sokonat_id,
                            cs.name shahre_sokonat_name
                        FROM
                            bnm_subscribers s
                            LEFT JOIN bnm_shahr c ON s.shahre_tavalod = c.id
                            LEFT JOIN bnm_shahr cs ON s.shahre_sokonat = cs.id
                            LEFT JOIN bnm_ostan o ON s.ostane_tavalod = o.id
                            LEFT JOIN bnm_ostan os ON s.ostane_sokonat = os.id
                            LEFT JOIN bnm_ostan t1o ON s.tel1_ostan = t1o.id
                            LEFT JOIN bnm_ostan t2o ON s.tel2_ostan = t2o.id
                            LEFT JOIN bnm_ostan t3o ON s.tel3_ostan = t3o.id
                            LEFT JOIN bnm_shahr t1s ON s.tel1_ostan = t1s.id
                            LEFT JOIN bnm_ostan t2s ON s.tel2_ostan = t2s.id
                            LEFT JOIN bnm_ostan t3s ON s.tel3_ostan = t3s.id 
                        WHERE
                            s.id = ?
                        ";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    if ($result) {
                        die(json_encode($result));
                    } else {
                        die(Helper::Json_Message('f'));
                    }

                    break;
                case 'city':
                    $sql = "SELECT * FROM bnm_shahr WHERE id=?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'wireless_ap':
                    $sql = "SELECT * FROM bnm_wireless_ap WHERE id = ?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'wireless_station':
                    $sql = "SELECT st.*,CONCAT(sub.name, ' ' ,sub.f_name) subname FROM bnm_wireless_station st
                        LEFT JOIN bnm_subscribers sub ON st.subscriber_id = sub.id
                        WHERE st.id = ?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'popsite':
                    $sql = "SELECT * FROM bnm_popsite WHERE id=?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'host':
                    $sql = "SELECT * FROM bnm_host WHERE id=?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'port':
                    $sql = "SELECT * FROM bnm_port WHERE id=?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    if($result){
                        die(json_encode($result, JSON_UNESCAPED_UNICODE));
                    }else{
                        $msg="اطلاعات پورت یافت نشد";
                        die(Helper::Custom_Msg($msg,2));
                    }
                    
                    break;
                case 'branch':
                    $sql = "SELECT * FROM bnm_branch WHERE id= ?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'tdlte_sim':
                    $sql = "SELECT * FROM bnm_tdlte_sim WHERE id= ?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'operator':
                    $sql = "SELECT * FROM bnm_operator WHERE id= ?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'telecommunications_center':
                    $sql = "SELECT * FROM bnm_telecommunications_center WHERE id=?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
            }
        }
        /*==========hard delete============*/
        if (isset($_POST['harddelete'])) {
            $target = $_POST['target'];
            switch ($target) {
                case 'ip_pool_list':
                    if (Helper::check_delete_access('ip_pool_list')) {
                        $result = Db::secure_delete("DELETE FROM bnm_ip_pool_list WHERE id =:id", $_POST['harddelete']);
                        if ($result) {
                            die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                        } else {
                            die(Helper::Json_Message('f'));
                        }

                    } else {
                        echo Helper::Json_Message('na');
                    }

                    break;
                case 'equipments_models':
                    if (Helper::check_delete_access('equipments_models')) {
                        $result = Db::secure_delete("DELETE FROM bnm_equipments_models WHERE id =:id", $_POST['harddelete']);
                        if ($result) {
                            die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                        } else {
                            die(Helper::Json_Message('f'));
                        }

                        // $result = Db::justexecute($sql);
                    } else {
                        echo Helper::Json_Message('na');
                    }

                    break;
                case 'equipments_brands':
                    if (Helper::check_delete_access('equipments_brands')) {
                        $id = $_POST['harddelete'];
                        $sql = "delete FROM bnm_equipments_brands WHERE id=$id";
                        $result = Db::justexecute($sql);
                    } else {
                        die(Helper::Json_Message('na'));
                    }

                    break;
                case 'branch_cooperation_type':
                    if (Helper::check_delete_access('branch_cooperation_type')) {
                        $id = $_POST['harddelete'];
                        $sql = "delete FROM bnm_branch_cooperation_type WHERE id=$id";
                        $result = Db::justexecute($sql);
                    } else {
                        echo Helper::Alert_Message('na');
                    }

                    break;
                case 'messages':
                    if (Helper::check_delete_access('messages')) {
                        $sql = "delete FROM bnm_messages WHERE id= :id";
                        $result = Db::secure_delete($sql, $_POST['harddelete']);
                        if ($result) {
                            die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                        } else {
                            die(Helper::Json_Message('f'));
                        }

                    } else {
                        echo Helper::Alert_Message('na');
                    }

                    break;
                case 'services_contract':

                    $id = $_POST['harddelete'];
                    $sql = "delete FROM bnm_banks WHERE id=$id";
                    $result = Db::justexecute($sql);
                    break;
                case 'city':
                    if (Helper::check_delete_access('city')) {
                        $id = $_POST['harddelete'];
                        $sql = "delete FROM bnm_shahr WHERE id = $id";
                        $result = Db::justexecute($sql);

                        if ($result) {
                            die(json_encode(array($result)));
                        } else {
                            die(false);
                        }
                    } else {
                        echo Helper::Alert_Message('na');
                    }

                    break;
                case 'tdlte_sim':
                    if (Helper::check_delete_access('tdlte_sim')) {
                        $id = $_POST['harddelete'];
                        $sql = "delete FROM bnm_tdlte_sim WHERE id = $id";
                        $result = Db::justexecute($sql);
                        if ($result) {
                            die(json_encode(true));
                        } else {
                            die(json_encode(false));
                        }
                    } else {
                        echo Helper::Alert_Message('na');
                    }

                    break;
                case 'modir':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                                //get modir info
                                if (Helper::check_delete_access('modir')) {
                                    $res_modir = Helper::Select_By_Id('bnm_operator', array('id' => $id, 'user_type' => __MODIRUSERTYPE__));
                                    if ($res_modir) {
                                        //update modir info
                                        $arr = array();
                                        $arr['id'] = $res_modir[0]['id'];
                                        $arr['panel_status'] = '2';
                                        $sql = Helper::Update_Generator($arr, 'bnm_operator', 'WHERE id= :id');
                                        $res = Db::secure_update_array($sql, $arr, true);
                                        //get user info of modir
                                        $sql = "SELECT * FROM bnm_users WHERE user_id = ? AND user_type=?";
                                        $res_user = Db::secure_fetchall($sql, array($res_modir[0]['id'], '2'), true);
                                        if ($res_user) {
                                            //update user info of modir
                                            $arr = array();
                                            $arr['id'] = $res_user[0]['id'];
                                            $arr['status'] = '2';
                                            $sql = Helper::Update_Generator($arr, 'bnm_users', "WHERE id = :id");
                                            $result = Db::secure_update_array($sql, $arr);
                                        } else {
                                            echo Helper::Alert_Message('f');
                                        }

                                        if ($result) {
                                            die(true);
                                        } else {
                                            die(false);
                                        }
                                    } else {
                                        echo Helper::Alert_Message('f');
                                    }
                                } else {
                                    echo Helper::Alert_Message('na');
                                }

                                break;
                            case '2':
                            case '3':

                                break;

                            default:

                                break;
                        }
                    }
                    echo Helper::Alert_Message('af');
                    break;
                case 'operator':

                    if (Helper::Login_Just_Check()) {
                        if (Helper::check_delete_access('operator')) {
                            switch ($_SESSION['user_type']) {
                                case __ADMINUSERTYPE__:
                                case __ADMINOPERATORUSERTYPE__:
                                    /////////////////////////old codes//////////////////////
                                    $id = $_POST['harddelete'];
                                    // $sql    = "delete FROM bnm_access_menu_operator WHERE operator_id = '$id'";
                                    // $result = Db::justexecute($sql);
                                    // $sql    = "delete FROM bnm_delete_menu_operator WHERE operator_id = '$id'";
                                    // $result = Db::justexecute($sql);
                                    // $sql    = "delete FROM bnm_edit_menu_operator WHERE operator_id = '$id'";
                                    // $result = Db::justexecute($sql);
                                    // $sql    = "delete FROM bnm_add_menu_operator WHERE operator_id = '$id'";
                                    // $result = Db::justexecute($sql);
                                    // //delete from users
                                    // $sql    = "delete FROM bnm_users WHERE id = '$id' AND user_type = '2'";
                                    // $result = Db::justexecute($sql);
                                    // $sql    = "delete FROM bnm_operator WHERE id = '$id'";
                                    // $result = Db::justexecute($sql);
                                    /////////////////////////old codes//////////////////////
                                    //get operator info
                                    $res_operator = Helper::Select_By_Id('bnm_operator', $id);
                                    if ($res_operator) {
                                        //update modir info
                                        $arr = array();
                                        $arr['id'] = $res_operator[0]['id'];
                                        $arr['panel_status'] = '3';
                                        $sql = Helper::Update_Generator($arr, 'bnm_operator', 'WHERE id= :id');
                                        $res = Db::secure_update_array($sql, $arr, true);
                                        //get user info of operator
                                        $sql = "SELECT * FROM bnm_users WHERE user_id = ? AND user_type=?";
                                        $res_user = Db::secure_fetchall($sql, array($res_operator[0]['id'], '3'), true);
                                        if ($res_user) {
                                            //update user info of operator
                                            $arr = array();
                                            $arr['id'] = $res_user[0]['id'];
                                            $arr['status'] = '3';
                                            $sql = Helper::Update_Generator($arr, 'bnm_users', "WHERE id = :id");
                                            $result = Db::secure_update_array($sql, $arr);
                                        } else {
                                            echo Helper::Alert_Message('f');
                                        }

                                        if ($result) {
                                            die(true);
                                        } else {
                                            die(false);
                                        }
                                    } else {
                                        echo Helper::Alert_Message('f');
                                    }
                                    break;
                                case '2':
                                case '3':

                                    break;

                                default:

                                    break;
                            }
                        } else {
                            echo Helper::Alert_Message('na');
                        }

                    }
                    echo Helper::Alert_Message('af');
                    break;
                case 'ostan':
                    if (Helper::check_delete_access('ostan')) {
                        $id = $_POST['harddelete'];
                        $sql = "delete FROM bnm_ostan WHERE id = '$id'";
                        $result = Db::justexecute($sql);
                        if ($result) {
                            die(true);
                        } else {
                            die(false);
                        }
                    } else {
                        echo Helper::Alert_Message('na');
                    }

                    break;
                case 'countries':
                    if (Helper::check_delete_access('countries')) {
                        $id = $_POST['harddelete'];
                        $sql = "delete FROM bnm_countries WHERE id = '$id'";
                        $result = Db::justexecute($sql);
                        if ($result) {
                            die(true);
                        } else {
                            die(false);
                        }
                    } else {
                        echo Helper::Alert_Message('na');
                    }

                    break;
                case 'tax':
                    if (Helper::check_delete_access('tax')) {
                        $id = $_POST['harddelete'];
                        $sql = "delete FROM bnm_tax WHERE id = '$id'";
                        $result = Db::justexecute($sql);
                        if ($result) {
                            die(true);
                        } else {
                            die(false);
                        }
                    } else {
                        echo Helper::Alert_Message('na');
                    }

                    break;
                case 'noe_terminal':
                    if (Helper::check_delete_access('noe_terminal')) {
                        $id = $_POST['harddelete'];
                        $sql = "delete FROM bnm_noe_terminal WHERE id = '$id'";
                        $result = Db::justexecute($sql);
                        if ($result) {
                            die(true);
                        } else {
                            die(false);
                        }
                    } else {
                        echo Helper::Alert_Message('na');
                    }

                    break;
                case 'wireless_ap':
                    if (Helper::check_delete_access('wireless_ap')) {
                        $sql = "delete FROM bnm_wireless_ap WHERE id = :id";
                        $result = Db::secure_delete($sql, $_POST['harddelete']);
                        if ($result) {
                            die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                        } else {
                            die(Helper::Json_Message('f'));
                        }

                        if ($result) {
                            die(true);
                        } else {
                            die(false);
                        }
                    } else {
                        echo Helper::Alert_Message('na');
                    }

                    break;
                case 'wireless_station':
                    if (Helper::check_delete_access('wireless_station')) {
                        $id = $_POST['harddelete'];
                        $sql = "delete FROM bnm_wireless_station WHERE id = $id";
                        $result = Db::justexecute($sql);
                        if ($result) {
                            die(true);
                        } else {
                            die(false);
                        }
                    } else {
                        echo Helper::Alert_Message('na');
                    }

                    break;
                case 'services_adsl':
                    if (Helper::check_delete_access('services')) {
                        $id = $_POST['harddelete'];
                        $sql = "delete FROM bnm_services WHERE id = '$id'";
                        $result = Db::justexecute($sql);
                        if ($result) {
                            die(true);
                        } else {
                            die(false);
                        }
                    } else {
                        echo Helper::Alert_Message('na');
                    }

                    break;
                case 'services_wireless':
                    $id = $_POST['harddelete'];
                    $sql = "delete FROM bnm_services WHERE id = '$id'";
                    $result = Db::justexecute($sql);
                    if ($result) {
                        die(true);
                    } else {
                        die(false);
                    }
                    break;
                case 'services_tdlte':
                    $id = $_POST['harddelete'];
                    $sql = "delete FROM bnm_services WHERE id = '$id'";
                    $result = Db::justexecute($sql);
                    if ($result) {
                        die(true);
                    } else {
                        die(false);
                    }
                    break;
                case 'services_voip':
                    $id = $_POST['harddelete'];
                    $sql = "delete FROM bnm_services WHERE id = '$id'";
                    $result = Db::justexecute($sql);
                    if ($result) {
                        die(true);
                    } else {
                        die(false);
                    }
                    break;
                case 'organization_level':
                    if (Helper::check_delete_access('organization_level')) {
                        $id = $_POST['harddelete'];
                        $sql = "delete FROM bnm_organization_level WHERE id = $id";
                        $result = Db::justexecute($sql);
                        if ($result) {
                            die(true);
                        } else {
                            die(false);
                        }
                    } else {
                        echo Helper::Alert_Message('na');
                    }

                    break;
                case 'real_subscribers':
                    if (Helper::check_delete_access('real_subscribers')) {
                        $id = $_POST['harddelete'];
                        $sql = "delete FROM bnm_subscribers WHERE id = ?";
                        $result = Db::secure_fetchall($sql, [$id]);
                        $sql = "delete FROM bnm_users WHERE user_id = ? AND user_type= ?";
                        $result= Db::secure_fetchall($sql, [$id, __MOSHTARAKUSERTYPE__]);
                        if ($result) {
                            die(true);
                        } else {
                            die(false);
                        }
                    } else {
                        echo Helper::Alert_Message('na');
                    }

                    break;
                case 'legal_subscribers':
                    if (Helper::check_delete_access('legal_subscribers`')) {

                        $id = $_POST['harddelete'];
                        $sql = "delete FROM bnm_subscribers WHERE id = ?";
                        $result = Db::secure_fetchall($sql, [$id]);
                        $sql = "delete FROM bnm_users WHERE user_id = ? AND user_type= ?";
                        $result= Db::secure_fetchall($sql, [$id, __MOSHTARAKUSERTYPE__]);
                        if ($result) {
                            die(true);
                        } else {
                            die(false);
                        }
                    } else {
                        echo Helper::Alert_Message('na');
                    }

                    break;

                case 'popsite':
                    if (Helper::check_delete_access('popsite')) {

                        $id = $_POST['harddelete'];
                        $sql = "delete FROM bnm_popsite WHERE id = $id";
                        $result = Db::justexecute($sql);
                        if ($result) {
                            die(true);
                        } else {
                            die(false);
                        }
                    } else {
                        echo Helper::Alert_Message('na');
                    }

                    break;
                case 'host':
                    if (Helper::check_delete_access('host')) {
                        $id = $_POST['harddelete'];
                        $sql = "delete FROM bnm_host WHERE id = '$id'";
                        $result = Db::justexecute($sql);
                        if ($result) {
                            die(true);
                        } else {
                            die(false);
                        }
                    } else {
                        echo Helper::Alert_Message('na');
                    }

                    break;
                case 'terminal':
                    //ghabl az delete bayad check shavad ke agar shomare telephone be portha ekhtesas daded nashode mitone pak beshe
                    if (Helper::check_delete_access('terminal')) {

                        $id = $_POST['harddelete'];
                        $sql = "delete FROM bnm_terminal WHERE id = '$id'";
                        $result = Db::justexecute($sql);
                        if ($result) {
                            die(true);
                        } else {
                            die(false);
                        }
                        die(true);
                    } else {
                        echo Helper::Alert_Message('na');
                    }

                    break;
                case 'branch':
                    if (Helper::check_delete_access('branch')) {

                        $id = $_POST['harddelete'];
                        $sql = "delete FROM bnm_branch WHERE id = '$id'";
                        $result = Db::justexecute($sql);
                        if ($result) {
                            die(true);
                        } else {
                            die(false);
                        }
                    } else {
                        echo Helper::Alert_Message('na');
                    }

                    break;
                case 'telecommunications_center':
                    if (Helper::check_delete_access('telecommunications_center')) {

                        $id = $_POST['harddelete'];
                        $sql = "delete FROM bnm_telecommunications_center WHERE id = '$id'";
                        $result = Db::justexecute($sql);
                        if ($result) {
                            die(true);
                        } else {
                            die(false);
                        }
                    } else {
                        echo Helper::Alert_Message('na');
                    }

                    break;
            }
        }
        // 1. router

        /*========factors_initialize========*/
        if (isset($_POST['factors_initialize'])) {
            switch ($_POST['factors_initialize']) {
                case 'sj_tdlte_user_sims':
                    if (isset($_POST['condition1'])) {
                        if (Helper::Login_Just_Check()) {
                            $res = Helper::getTdlteEmkanatBySubId($_POST['condition1']);
                            if ($res) {
                                die(json_encode($res));
                            } else {
                                die(Helper::Json_Message('ens'));
                            }
                        } else {
                            die(Helper::Json_Message('af'));
                        }

                    } else {
                        die(Helper::Json_Message('f'));
                    }

                    break;
                case 'print_factor_tasvireshode':
                    if (isset($_POST['condition'])) {
                        if (isset($_POST['condition'])) {
                            if (Helper::Login_Just_Check()) {
                                switch ($_SESSION['user_type']) {
                                    case __ADMINUSERTYPE__:
                                    case __ADMINOPERATORUSERTYPE__:
                                    case __MODIRUSERTYPE__:
                                    case __MODIR2USERTYPE__:
                                    case __OPERATORUSERTYPE__:
                                    case __OPERATOR2USERTYPE__:
                                    case __MOSHTARAKUSERTYPE__:
                                        $sql = "SELECT branch_id,id,subscriber_id FROM bnm_factor WHERE id = ? AND tasvie_shode = ?";
                                        $res = Db::secure_fetchall($sql, array($_POST['condition'], 1));
                                        if ($res) {
                                            if ($res[0]['branch_id'] === 0) {
                                                ///user sherkat ".__OPERATORUSERTYPE__."
                                                $sql = "SELECT
                                                '".__OWNER__."' AS fo_name,
                                                '".__OWNERTELEPHONE__."' AS fo_telephone,
                                                '".__OWNERCODEPOSTI__."' AS fo_code_posti,
                                                '".__OWNERCODEEGHTESADI__."' AS fo_code_eghtesadi,
                                                '".__OWNEROSTAN__."' AS fo_ostan,
                                                '".__OWNERSHOMARESABT__."' AS fo_shomare_sabt,
                                                '".__OWNERSHAHR__."' AS fo_shahr,
                                                '".__OWNERADDRESS__."' fo_address,
                                                '".__OWNERMOBILE__."' AS fo_mobile,
                                                bf.id id,
                                                bf.pin_code,
                                                bf.shomare_factor shomare_factor,
                                                bf.terafik terafik,
                                                bf.zaname_estefade_be_tarikh zaname_estefade_be_tarikh,
                                                bf.tarikhe_shoroe_service tarikhe_shoroe_service,
                                                bf.tarikhe_payane_service tarikhe_payane_service,
                                                bf.gheymate_service gheymate_service,
                                                bf.zamane_estefade zamane_estefade,
                                                bf.takhfif takhfif,
                                                bf.hazine_ranzhe hazine_ranzhe,
                                                bf.hazine_dranzhe hazine_dranzhe,
                                                bf.hazine_nasb hazine_nasb,
                                                bf.abonmane_port abonmane_port,
                                                bf.abonmane_faza abonmane_faza,
                                                bf.abonmane_tajhizat abonmane_tajhizat,
                                                bf.maliate_arzeshe_afzode maliate_arzeshe_afzode,
                                                bf.darsade_avareze_arzeshe_afzode darsade_avareze_arzeshe_afzode,
                                                bf.mablaghe_ghabele_pardakht mablaghe_ghabele_pardakht,
                                                bf.subscriber_id subscriber_id,
                                                bf.tarikhe_factor tarikhe_factor,
                                                bs.branch_id branch_id,
                                                bs.name name,
                                                bs.f_name f_name,
                                                bs.code_eshterak code_eshterak,
                                                bs.code_meli code_meli,
                                                bs.telephone_hamrah telephone_hamrah,
                                                bs.address1 address1,
                                                bs.code_posti1 code_posti,
                                                bs.telephone1 telephone,
                                                CONCAT(
                                                    bs.tel1_street,
                                                    ' ',
                                                    bs.tel1_street2,
                                                    'پلاک ',
                                                    bs.tel1_housenumber,
                                                    'طبقه ',
                                                    bs.tel1_tabaghe,
                                                    'واحد ',
                                                    bs.tel1_vahed 
                                                ) AS address,
                                                subostan.name ostane_sokonat,
                                                subshahr.name shahre_sokonat,
                                                ser.type type,
                                                ser.onvane_service,
                                                ser.tozihate_faktor,
                                                CONCAT( '".__OWNER__."', ' ', 'تلفن : ', '".__OWNERTELEPHONE__."' ) AS name_sherkat
                                            FROM
                                                bnm_factor bf
                                                INNER JOIN bnm_subscribers bs ON bf.subscriber_id = bs.id
                                                INNER JOIN bnm_services ser ON bf.service_id = ser.id 
                                                INNER JOIN bnm_ostan subostan ON subostan.id = bs.ostane_sokonat
                                                INNER JOIN bnm_shahr subshahr ON subshahr.id = bs.shahre_sokonat
                                            WHERE
                                                bf.id = ? 
                                                AND bf.tasvie_shode =?";
                                                $res = Db::secure_fetchall($sql, array($_POST['condition'], 1), true);
                                                if ($res) {
                                                    die(json_encode($res));
                                                } else {
                                                    $msg=':خطا در برنامه لطفا موارد ذیل را بررسی نمایید';
                                                    $msg.="<br/>";
                                                    $msg.="اطلاعات استان و شهر مشترک";
                                                    $msg.="<br/>";
                                                    $msg.="اطلاعات سرویس باید کامل باشد";
                                                    $msg.="<br/>";
                                                    $msg.="فاکتور تسویه شده باشد";
                                                    die(Helper::Custom_Msg($msg,2));

                                                }
                                            } elseif (isset($res[0]['branch_id'])) {
                                                ///user namayande
                                                $sql = "SELECT
                                                '".__OWNER__."' AS fo_name,
                                                '".__OWNERTELEPHONE__."' AS fo_telephone,
                                                '".__OWNERCODEPOSTI__."' AS fo_code_posti,
                                                '".__OWNERCODEEGHTESADI__."' AS fo_code_eghtesadi,
                                                '".__OWNEROSTAN__."' AS fo_ostan,
                                                '".__OWNERSHOMARESABT__."' AS fo_shomare_sabt,
                                                '".__OWNERSHAHR__."' AS fo_shahr,
                                                '".__OWNERADDRESS__."' fo_address,
                                                '".__OWNERMOBILE__."' AS fo_mobile,
                                                bf.id id,
                                                bf.pin_code,
                                                bf.shomare_factor shomare_factor,
                                                bf.terafik terafik,
                                                bf.zaname_estefade_be_tarikh zaname_estefade_be_tarikh,
                                                bf.tarikhe_shoroe_service tarikhe_shoroe_service,
                                                bf.tarikhe_payane_service tarikhe_payane_service,
                                                bf.gheymate_service gheymate_service,
                                                bf.zamane_estefade zamane_estefade,
                                                bf.takhfif takhfif,
                                                bf.hazine_ranzhe hazine_ranzhe,
                                                bf.hazine_dranzhe hazine_dranzhe,
                                                bf.hazine_nasb hazine_nasb,
                                                bf.abonmane_port abonmane_port,
                                                bf.abonmane_faza abonmane_faza,
                                                bf.abonmane_tajhizat abonmane_tajhizat,
                                                bf.maliate_arzeshe_afzode maliate_arzeshe_afzode,
                                                bf.darsade_avareze_arzeshe_afzode darsade_avareze_arzeshe_afzode,
                                                bf.mablaghe_ghabele_pardakht mablaghe_ghabele_pardakht,
                                                bf.subscriber_id subscriber_id,
                                                bf.tarikhe_factor tarikhe_factor,
                                                bs.branch_id branch_id,
                                                bs.name name,
                                                bs.f_name f_name,
                                                bs.telephone1 AS telephone,
                                                bs.code_posti1 AS code_posti,
                                                bs.code_eshterak code_eshterak,
                                                bs.code_meli code_meli,
                                                bs.telephone_hamrah telephone_hamrah,
                                                bs.address1 address1,
                                                CONCAT(
                                                    bs.tel1_street,
                                                    ' ',
                                                    bs.tel1_street2,
                                                    'پلاک ',
                                                    bs.tel1_housenumber,
                                                    'طبقه ',
                                                    bs.tel1_tabaghe,
                                                    'واحد ',
                                                    bs.tel1_vahed 
                                                ) AS address,
                                                CONCAT( '".__OWNER__."', ' ', 'تلفن : ', '".__OWNERTELEPHONE__."' ) AS name_sherkat,
                                                subostan.name ostane_sokonat,
                                                subshahr.name shahre_sokonat,
                                                ser.type type,
                                                ser.onvane_service,
                                                ser.tozihate_faktor ,
                                                CONCAT(branches.name_sherkat ,'تلفن : ', branches.telephone1 , 'دورنگار : ',branches.dornegar) name_sherkat
                                            FROM
                                                bnm_factor bf
                                                INNER JOIN bnm_subscribers bs ON bf.subscriber_id = bs.id
                                                INNER JOIN bnm_services ser ON bf.service_id = ser.id 
                                                INNER JOIN bnm_branch branches ON bf.branch_id = branches.id
                                                INNER JOIN bnm_ostan subostan ON subostan.id = bs.ostane_sokonat
                                                INNER JOIN bnm_shahr subshahr ON subshahr.id = bs.shahre_sokonat
                                            WHERE
                                                bf.id = ? 
                                                AND bf.tasvie_shode =?";
                                                $res = Db::secure_fetchall($sql, array($_POST['condition'], 1), true);
                                                if ($res) {
                                                    die(json_encode($res));
                                                } else {
                                                    $msg=':خطا در برنامه لطفا موارد ذیل را بررسی نمایید';
                                                    $msg.="<br/>";
                                                    $msg.="اطلاعات استان و شهر مشترک";
                                                    $msg.="<br/>";
                                                    $msg.="اطلاعات سرویس باید کامل باشد";
                                                    $msg.="<br/>";
                                                    $msg.="فاکتور تسویه شده باشد";
                                                    die(Helper::Custom_Msg($msg,2));
                                                }
                                            } else {
                                                die(Helper::Json_Message('f'));
                                            }
                                        } else {
                                            die(Helper::Json_Message('fnf'));
                                        }
                                        break;
                                    default:
                                        die(Helper::Json_Message('na'));
                                        break;
                                }
                            } else {
                                die(Helper::Json_Message('af'));
                            }
                        } else {
                            die(Helper::Json_Message('rinf'));
                        }

                    } else {
                        die(Helper::Json_Message('rinf'));
                    }

                    break;
                case 'findbyid':
                    //                    $id=$_POST['condition'];
                    //                    $sql="SELECT * FROM bnm_subscribers WHERE id=$id";
                    //                    $result=Db::fetchall_Query($sql);
                    //                    $rows=json_encode($result);
                    //                    die($rows);
                    //                    break;
                    die(json_encode(array()));
                    break;
                case 'find_factor_by_id':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                                $id = $_POST['condition'];
                                $sql = "SELECT *,DATE(tarikhe_factor) AS date_tarikhe_factor FROM bnm_factor WHERE id=?";
                                $res = Db::secure_fetchall($sql, array($id));
                                die(json_encode($res));
                                break;
                            case __MODIRUSERTYPE__:
                            case __OPERATORUSERTYPE__:
                            case __MODIR2USERTYPE__:
                            case __OPERATOR2USERTYPE__:
                            case __MOSHTARAKUSERTYPE__:
                                $id = $_POST['condition'];
                                $sql = "SELECT *,DATE(tarikhe_factor) AS date_tarikhe_factor FROM bnm_factor WHERE id=? AND branch_id=?";
                                $res = Db::secure_fetchall($sql, array($id, $_SESSION['branch_id']));
                                die(json_encode($res));
                                break;
                            case __MOSHTARAKUSERTYPE__:
                                $id = $_POST['condition'];
                                $sql = "SELECT *,DATE(tarikhe_factor) AS date_tarikhe_factor FROM bnm_factor WHERE id=? AND subscriber_id=?";
                                $res = Db::secure_fetchall($sql, array($id, $_SESSION['user_id']));
                                if ($res) {
                                    die(json_encode($res));
                                } else {
                                    die(Helper::Json_Message('f'));
                                }

                                break;

                            default:
                                die(Helper::Json_Message('af'));
                                break;
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }
                    break;
                case 'get_factor_info_by_id_check_date_and_credits':
                    if (Helper::Login_Just_Check()) {
                        $sql_factor = "SELECT id,service_id,subscriber_id,tarikhe_factor,mablaghe_ghabele_pardakht,type FROM bnm_factor WHERE id=? AND DATE(tarikhe_factor)=CURDATE() AND tasvie_shode<>'1'";
                        $res_factor = Db::secure_fetchall($sql_factor, array($_POST['condition']), true);
                        $res_subscriber=false;
                        if ($res_factor) {
                            switch ($_SESSION['user_type']) {
                                case __ADMINUSERTYPE__:
                                case __ADMINOPERATORUSERTYPE__:
                                    $sql_subscriber = "SELECT id,name,f_name,branch_id FROM bnm_subscribers WHERE id=?";
                                    $res_subscriber = Db::secure_fetchall($sql_subscriber, array($res_factor[0]['subscriber_id']), true);
                                break;
                                case __MODIRUSERTYPE__:
                                case __MODIR2USERTYPE__:
                                case __OPERATORUSERTYPE__:
                                case __OPERATOR2USERTYPE__:
                                    $sql_subscriber = "SELECT id,name,f_name,branch_id FROM bnm_subscribers WHERE id=? AND branch_id= ?";
                                    $res_subscriber = Db::secure_fetchall($sql_subscriber, array($res_factor[0]['subscriber_id'], $_SESSION['branch_id']), true);
                                break;
                                case __MOSHTARAKUSERTYPE__:
                                    $sql_subscriber = "SELECT id,name,f_name,branch_id FROM bnm_subscribers WHERE id=?";
                                    $res_subscriber = Db::secure_fetchall($sql_subscriber, array($_SESSION['user_id']), true);
                                break;
                                
                                default:
                                    die(Helper::Json_Message('af'));
                                    break;
                            }
                            
                            if ($res_subscriber) {
                                //check subscriber info
                                if ($res_subscriber[0]['branch_id'] !== 0) {
                                    //user namayande
                                    $branch_sql = "SELECT id,name_sherkat FROM bnm_branch WHERE id = ?";
                                    $res_branch = Db::secure_fetchall($branch_sql, array($res_subscriber[0]['branch_id']), true);
                                    if ($res_branch) {
                                        //get credit subscriber info
                                        $sql_credit_subscriber = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY update_time DESC LIMIT 1";
                                        $res_credit_subscriber = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id'], '1'));
                                        $result = array();
                                        $result['subscriber'] = [];
                                        $result['branch'] = [];
                                        $result['subscriber']['status'] = false;
                                        $result['branch']['status'] = false;
                                        if ($res_credit_subscriber && $res_credit_subscriber[0]['credit'] >= $res_factor[0]['mablaghe_ghabele_pardakht']) {
                                            //user bank darad va credit user baraye pardakht kafi ast
                                            $result['subscriber']['status'] = true;
                                            $result['subscriber']['credit'] = $res_credit_subscriber[0]['credit'];
                                            $result['subscriber']['name'] = Helper::getor_string($res_subscriber[0]['name'] . ' ' . $res_subscriber[0]['f_name'], 'ثبت نشده');
                                            $result['subscriber']['id'] = $res_subscriber[0]['id'];
                                        } else {
                                            $result['subscriber']['status'] = false;
                                            $result['subscriber']['name'] = Helper::getor_string($res_subscriber[0]['name'] . ' ' . $res_subscriber[0]['f_name'], 'ثبت نشده');
                                            if ($res_credit_subscriber) {
                                                $result['subscriber']['credit'] = $res_credit_subscriber[0]['credit'];
                                            } else {
                                                $result['subscriber']['credit'] = 0;
                                            }
                                        }
                                        //get credit branch info
                                        if($_SESSION['user_type'] !== __MOSHTARAKUSERTYPE__){
                                            $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id = ? AND noe_user= ? ORDER BY update_time DESC LIMIT 1";
                                            $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_branch[0]['id'], '2'));

                                            if ($res_credit_branch && $res_credit_branch[0]['credit'] >= $res_factor[0]['mablaghe_ghabele_pardakht']) {
                                                //$flag_branch = true;
                                                $result['branch']['status'] = true;
                                                $result['branch']['credit'] = $res_credit_branch[0]['credit'];
                                                $result['branch']['name'] = Helper::getor_string($res_branch[0]['name_sherkat']);
                                                $result['branch']['id'] = Helper::getor_string($res_branch[0]['name_sherkat']);
                                            } else {
                                                //$flag_branch = false;
                                                $result['branch']['status'] = false;
                                                if ($res_credit_branch) {
                                                    $result['branch']['credit'] = Helper::getor_string($res_credit_branch[0]['credit'], 0);
                                                    $result['branch']['name'] = Helper::getor_string($res_branch[0]['name_sherkat']);
                                                    $result['branch']['id'] = Helper::getor_string($res_branch[0]['name_sherkat']);
                                                } else {
                                                    if ($res_branch) {
                                                        $result['branch']['id'] = Helper::getor_string($res_branch[0]['name_sherkat']);
                                                        $result['branch']['credit'] = 0;
                                                        $result['branch']['name'] = Helper::getor_string($res_branch[0]['name_sherkat']);
                                                    } else {
                                                        $result['branch']['credit'] = 0;
                                                        $result['branch']['id'] = 'empty';
                                                        $result['branch']['name'] = 'ثبت نشده';
                                                    }
                                                }
                                            }
                                        }
                                        $result['mablaghe_factor'] = $res_factor[0]['mablaghe_ghabele_pardakht'];
                                        $result['factor_id'] = $res_factor[0]['id'];
                                        $result['pardakhte_dasti'] = false;
                                        die(json_encode($result));
                                    } else {
                                        die(Helper::Json_Message('branch_not_right'));
                                    }
                                } else if ($res_subscriber[0]['branch_id'] === 0) {
                                    //user baraye sahar ast
                                    $sql_credit_subscriber = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY update_time DESC LIMIT 1";
                                    $res_credit_subscriber = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id'], '1'));
                                    $result = array();
                                    $result['subscriber'] = [];
                                    $result['branch'] = [];
                                    $result['subscriber']['status'] = false;
                                    $result['branch']['status'] = false;
                                    if ($res_credit_subscriber && $res_credit_subscriber[0]['credit'] >= $res_factor[0]['mablaghe_ghabele_pardakht']) {
                                        $result['subscriber']['status'] = true;
                                        $result['subscriber']['credit'] = $res_credit_subscriber[0]['credit'];
                                        $result['subscriber']['name'] = Helper::getor_string($res_subscriber[0]['name'] . ' ' . $res_subscriber[0]['f_name'], 'ثبت نشده');
                                        $result['subscriber']['id'] = $res_subscriber;
                                    } else {
                                        $result['subscriber']['status'] = false;
                                        $result['subscriber']['name'] = Helper::getor_string($res_subscriber[0]['name'] . ' ' . $res_subscriber[0]['f_name'], 'ثبت نشده');
                                        if ($res_credit_subscriber) {
                                            $result['subscriber']['credit'] = $res_credit_subscriber[0]['credit'];
                                        } else {
                                            $result['subscriber']['credit'] = 0;
                                        }
                                        $result['subscriber']['status'] = false;
                                    }
                                    $result['branch']['status'] = false;
                                    $result['branch']['name'] = "سحر ارتباط";
                                    $result['branch']['id'] = "0";
                                    $result['branch']['credit'] = "0";
                                    $result['mablaghe_factor'] = $res_factor[0]['mablaghe_ghabele_pardakht'];
                                    $result['factor_id'] = $res_factor[0]['id'];
                                    $result['pardakhte_dasti'] = true;
                                    die(json_encode($result));
                                } else {
                                    die(Helper::Json_Message('user_info_not_right'));
                                }
                            } else {
                                die(Helper::Json_Message('user_didnt_found'));
                            }
                        } else {
                            die(Helper::Json_Message('fnofp'));
                        }
                    } else {
                        die(Helper::Json_Message('auth_fail'));
                    }
                    break;

                case 'sj_bs_user_telephones':
                    if (Helper::Login_Just_Check()) {
                        if (isset($_POST['condition'])) {
                            $res = Helper::getOssReserveWaitingActiveBySubid($_POST['condition']);
                            if ($res) {
                                die(json_encode($res));
                            } else {
                                $res = Helper::getOssActiveReserveBySubid($_POST['condition']);
                                // die(json_encode($_SESSION));
                                if ($res) {
                                    die(json_encode($res));
                                } else {
                                    $msg = "پورتی برای این مشترک رزرو نشده یا تاریخ رزرو پورت به اتمام رسیده.";
                                    die(Helper::Custom_Msg($msg));
                                }
                            }
                        } else {
                            die(json_encode(array('Error' => 'لطفا مشترک مورد نظر برای صدور فاکتور را انتخاب نمایید.')));
                        }
                        $_POST = Helper::xss_check_array($_POST);
                    } else {
                        die(Helper::Json_Message('af'));
                    }

                    break;
                case 'sj_adsl_user_telephones':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                                if (isset($_POST['condition'])) {
                                    $res = Helper::getAdslVdslEmkanatBySubId($_POST['condition']);
                                    if ($res) {
                                        for ($i = 0; $i < count($res); $i++) {
                                            $checkprev = Helper::checkNormalPreviousFactorExist($res[$i]['subid'], $res[$i]['portid'], $res[$i]['adsl_vdsl']);
                                            if ($checkprev[0]['tedad'] === 0) {
                                                $res[$i]['prevfactor'] = true;
                                            } else {
                                                $res[$i]['prevfactor'] = false;
                                            }
                                        }
                                        die(json_encode($res));
                                    } else {
                                        die(Helper::Json_Message('f'));
                                    }
                                } else {
                                    die(json_encode(array('Error' => 'لطفا مشترک مورد نظر برای صدور فاکتور را انتخاب نمایید.')));
                                }
                                break;
                            case __MODIRUSERTYPE__:
                            case __OPERATORUSERTYPE__:
                            case __MODIR2USERTYPE__:
                            case __OPERATOR2USERTYPE__:
                                if (isset($_POST['condition'])) {
                                    $res = Helper::getAdslVdslEmkanatBySubId($_POST['condition']);
                                    die(json_encode($res));
                                } else {
                                    die(json_encode(array('Error' => 'لطفا مشترک مورد نظر برای صدور فاکتور را انتخاب نمایید.')));
                                }
                                break;
                            case __MOSHTARAKUSERTYPE__:
                                $res = Helper::getAdslVdslEmkanatBySubId($_SESSION['user_id']);
                                die(json_encode($res));
                                break;
                            default:
                                die(Helper::Json_Message('af'));
                                break;
                        }
                        $_POST = Helper::xss_check_array($_POST);
                    } else {
                        die(Helper::Json_Message('af'));
                    }

                    break;
                case 'sj_wireless_stations':
                    if (Helper::Login_Just_Check()) {
                        $res = Helper::getWirelessEmkanatBySubId($_POST['condition']);
                        if ($res) {
                            die(json_encode($res));
                        } else {
                            die(Helper::Json_Message('f'));
                        }
                    } else {
                        die(Helper::Json_Message('f'));
                    }
                    break;
                case 'ft_connection_log_init_noe_masraf':
                    //todo ye form dorost kon barash
                    if (Helper::Login_Just_Check()) {
                        $sql = "SELECT * FROM bnm_connection_log";
                        $result = Db::fetchall_query($sql);
                        if ($result) {
                            die(json_encode($result));
                        } else {
                            die(Helper::Json_Message('f'));
                        }
                    }
                    break;
                case 'ft_connection_log_init':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                                $user_id = $_POST['condition'];

                                // $sql     = "SELECT id,ibs_username,
                                // IF(type IN ('adsl','vdsl','wireless','tdlte'),'internet',
                                // IF(type IN ('voip'),'voip','notfound')) as 'type' FROM bnm_factor WHERE subscriber_id=? GROUP BY ibs_username,type";
                                // $result = Db::secure_fetchall($sql, array($user_id));
                                // if ($result) {
                                //     die(json_encode($result));
                                // } else {
                                //     die(Helper::Json_Message('f'));
                                // }

                                break;
                            case __MODIRUSERTYPE__:
                            case __OPERATORUSERTYPE__:
                            case __MODIR2USERTYPE__:
                            case __OPERATOR2USERTYPE__:
                            case __MOSHTARAKUSERTYPE__:
                                $user_id = $_POST['condition'];
                                $sql = "SELECT id,ibs_username,
                                    IF(type IN ('adsl','vdsl','wireless','tdlte'),'internet',
                                    IF(type IN ('voip'),'voip','notfound')) as 'type' FROM bnm_factor WHERE subscriber_id=? AND branch_id=? GROUP BY ibs_username,type";
                                $result = Db::secure_fetchall($sql, array($user_id, $_SESSION['branch_id']));
                                if ($result) {
                                    die(json_encode($result));
                                } else {
                                    die(Helper::Json_Message('f'));
                                }

                                break;
                            case __MOSHTARAKUSERTYPE__:
                                $sql = "SELECT id,ibs_username,
                                    IF(type IN ('adsl','vdsl','wireless','tdlte'),'internet',
                                    IF(type IN ('voip'),'voip','notfound')) as 'type' FROM bnm_factor WHERE subscriber_id=? GROUP BY ibs_username,type";
                                $result = Db::secure_fetchall($sql, array($_SESSION['user_id']));
                                if ($result) {
                                    die(json_encode($result));
                                } else {
                                    die(Helper::Json_Message('f'));
                                }

                                break;
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }

                    break;
                case 'online_user_list':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                                if (isset($_POST['condition'])) {
                                    $user_id = $_POST['condition'];
                                    $sql = "SELECT id,ibs_username,
                                    IF(type IN ('adsl','vdsl','wireless','tdlte'),'internet',
                                    IF(type IN ('voip'),'voip','notfound')) as 'type' FROM bnm_factor WHERE subscriber_id=? GROUP BY ibs_username,type";
                                    $result = Db::secure_fetchall($sql, array($user_id));
                                }
                                if ($result) {
                                    die(json_encode($result));
                                } else {
                                    die(Helper::Json_Message('f'));
                                }
                                break;
                            case __MODIRUSERTYPE__:
                            case __OPERATORUSERTYPE__:
                            case __MODIR2USERTYPE__:
                            case __OPERATOR2USERTYPE__:
                            case __MOSHTARAKUSERTYPE__:
                                $user_id = $_POST['condition'];
                                $sql = "SELECT id,ibs_username,
                                    IF(type IN ('adsl','vdsl','wireless','tdlte'),'internet',
                                    IF(type IN ('voip'),'voip','notfound')) as 'type' FROM bnm_factor WHERE subscriber_id=? AND branch_id=? GROUP BY ibs_username,type";
                                $result = Db::secure_fetchall($sql, array($user_id, $_SESSION['branch_id']));
                                if ($result) {
                                    die(json_encode($result));
                                } else {
                                    die(Helper::Json_Message('f'));
                                }
                                break;
                            case __MOSHTARAKUSERTYPE__:
                                //$user_id = $_POST['condition'];
                                $sql = "SELECT id,ibs_username,
                                    IF(type IN ('adsl','vdsl','wireless','tdlte'),'internet',
                                    IF(type IN ('voip'),'voip','notfound')) as 'type' FROM bnm_factor WHERE subscriber_id=? GROUP BY ibs_username,type";
                                $result = Db::secure_fetchall($sql, array($_SESSION['user_id']));
                                if ($result) {
                                    die(json_encode($result));
                                } else {
                                    die(Helper::Json_Message('f'));
                                }
                                break;
                            default:
                                die(Helper::Json_Message('af'));
                                break;
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }
                    break;
                case 'bs_services':
                    if (Helper::Login_Just_Check()) {
                        $sql = "SELECT *,DATE_ADD(CURDATE(),INTERVAL zaname_estefade DAY) zamane_estefade_betarikh FROM bnm_services WHERE noe_khadamat=? OR noe_khadamat = ? AND namayeshe_service=? AND tarikhe_shoroe_namayesh<=CURDATE() AND tarikhe_payane_namayesh >= CURDATE()";
                        $res = Db::secure_fetchall($sql, array('BITSTREAM_ADSL', 'BITSTREAM_VDSL', 'yes'), true);
                        if ($res) {
                            for ($i = 0; $i < count($res); $i++) {
                                $shamsi1 = Helper::tabdileTarikh($res[$i]['zamane_estefade_betarikh'], 1, '-', '/');
                                $res[$i]['zamane_estefade_betarikh'] = $shamsi1;
                            }
                            die(json_encode($res));
                        } else {
                            die(Helper::Json_Message('snf'));
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }

                    break;
                case 'adsl_services':
                    if (Helper::Login_Just_Check()) {
                        $sql = "SELECT *,DATE_ADD(CURDATE(),INTERVAL zaname_estefade DAY) zamane_estefade_betarikh FROM bnm_services WHERE type= ? AND namayeshe_service= ? AND tarikhe_shoroe_namayesh<=CURDATE() AND tarikhe_payane_namayesh >= CURDATE()";
                        $res = Db::secure_fetchall($sql, array('adsl', 'yes'));
                        if ($res) {
                            for ($i = 0; $i < count($res); $i++) {
                                $shamsi1 = Helper::tabdileTarikh($res[$i]['zamane_estefade_betarikh'], 1, '-', '/');
                                $res[$i]['zamane_estefade_betarikh'] = $shamsi1;
                            }
                            die(json_encode($res));
                        } else {
                            die(Helper::Json_Message('snf'));
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }

                    break;
                case 'wireless_services':
                    //$id=$_POST['condition'];
                    if (Helper::Login_Just_Check()) {
                        $sql = "SELECT *,DATE_ADD(CURDATE(),INTERVAL zaname_estefade DAY) zamane_estefade_betarikh FROM bnm_services WHERE type= ? AND namayeshe_service= ? AND tarikhe_shoroe_namayesh<=CURDATE() AND tarikhe_payane_namayesh >= CURDATE()";
                        $res = Db::secure_fetchall($sql, array('wireless', 'yes'));
                        if ($res) {
                            for ($i = 0; $i < count($res); $i++) {
                                $shamsi1 = Helper::tabdileTarikh($res[$i]['zamane_estefade_betarikh'], 1, '-', '/');
                                $res[$i]['zamane_estefade_betarikh'] = $shamsi1;
                            }
                            die(json_encode($res));
                        } else {
                            die(Helper::Json_Message('snf'));
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }

                    break;
                case 'tdlte_services':
                    //$id=$_POST['condition'];
                    if (Helper::Login_Just_Check()) {
                        $sql = "SELECT *,DATE_ADD(CURDATE(),INTERVAL zaname_estefade DAY) zamane_estefade_betarikh FROM bnm_services WHERE type= ? AND namayeshe_service= ? AND tarikhe_shoroe_namayesh<=CURDATE() AND tarikhe_payane_namayesh >= CURDATE()";
                        $res = Db::secure_fetchall($sql, array('tdlte', 'yes'));
                        if ($res) {
                            for ($i = 0; $i < count($res); $i++) {
                                $shamsi1 = Helper::tabdileTarikh($res[$i]['zamane_estefade_betarikh'], 1, '-', '/');
                                $res[$i]['zamane_estefade_betarikh'] = $shamsi1;
                            }
                            die(json_encode($res));
                        } else {
                            die(Helper::Json_Message('snf'));
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }

                    break;
                case 'voip_services':
                    //get voip service info by dates
                    //$id=$_POST['condition'];
                    if (Helper::Login_Just_Check()) {
                        $sql = "SELECT *,DATE_ADD(CURDATE(),INTERVAL zaname_estefade DAY) zamane_estefade_betarikh FROM bnm_services WHERE type= ? AND namayeshe_service= ? AND tarikhe_shoroe_namayesh<=CURDATE() AND tarikhe_payane_namayesh >= CURDATE()";
                        $res = Db::secure_fetchall($sql, array('voip', 'yes'));
                        if ($res) {
                            for ($i = 0; $i < count($res); $i++) {
                                $shamsi1 = Helper::tabdileTarikh($res[$i]['zamane_estefade_betarikh'], 1, '-', '/');
                                $res[$i]['zamane_estefade_betarikh'] = $shamsi1;
                            }
                            die(json_encode($res));
                        } else {
                            die(Helper::Json_Message('snf'));
                        }
                    } else {
                        die(Helper::Json_Message('af'));
                    }

                    break;
                case 'sj_get_ibs_credit':
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            $_POST = Helper::xss_check_array($_POST);
                            if (isset($_POST['condition1'])) {
                                $sql = "SELECT id,
                                    IF({$_POST['condition1']} = 1, telephone1,
                                    IF({$_POST['condition1']} = 2, telephone2,
                                    IF({$_POST['condition1']} = 3, telephone3, null))) telephone
                                    FROM bnm_subscribers
                                    WHERE id = ?
                                    ";
                                $res_telephone = Db::secure_fetchall($sql, array($_POST['condition2']));
                            } else {
                                die(Helper::Json_Message('f'));
                            }
                            break;
                        case __OPERATORUSERTYPE__:
                        case __MODIR2USERTYPE__:
                        case __MODIRUSERTYPE__:
                        case __OPERATOR2USERTYPE__:
                            $_POST = Helper::xss_check_array($_POST);
                            if (isset($_POST['condition1'])) {
                                $sql = "SELECT id,
                                    IF({$_POST['condition1']} = 1, telephone1,
                                    IF({$_POST['condition1']} = 2, telephone2,
                                    IF({$_POST['condition1']} = 3, telephone3, null))) telephone
                                    FROM bnm_subscribers
                                    WHERE id = ? AND branch_id = ?
                                    ";
                                $res_telephone = Db::secure_fetchall($sql, array($_POST['condition2'], $_SESSION['branch_id']));
                            } else {
                                die(Helper::Json_Message('f'));
                            }
                            break;
                        case __MOSHTARAKUSERTYPE__:
                            if (isset($_POST['condition1'])) {
                                $sql = "SELECT id,
                                    IF({$_POST['condition1']} = 1, telephone1,
                                    IF({$_POST['condition1']} = 2, telephone2,
                                    IF({$_POST['condition1']} = 3, telephone3, null))) telephone
                                    FROM bnm_subscribers
                                    WHERE id = ?
                                    ";
                                $res_telephone = Db::secure_fetchall($sql, array($_SESSION['user_id']));
                            } else {
                                die(Helper::Json_Message('f'));
                            }
                            break;
                        default:
                            die(Helper::Json_Message('af'));
                            break;
                    }
                    if ($res_telephone) {
                        $res = $GLOBALS['ibs_voip']->getUserInfoByViopUserName($res_telephone[0]['telephone']);
                        //02122074852 test
                        if (Helper::ibsCheckUserinfoExist($res)) {
                            //dar ibs vojod darad
                            $current_credit = intval($res[1][key($res[1])]['basic_info']['credit']);
                            $unixtime = strtotime($res[1][key($res[1])]['attrs']['abs_exp_date']);
                            $exp_date = date("Y-m-d", $unixtime);
                            $today_date = Helper::Today_Miladi_Date();
                            if ($exp_date <= $today_date) {
                                //expire shode pas 1/3 credit ro behesh midim
                                $available_credit = intval($current_credit / 3);
                            } else {
                                //expire nashode pas kole credit ro behesh midim
                                $available_credit = intval($res[1][key($res[1])]['basic_info']['credit']);
                            }
                            die(json_encode(array(
                                'current_credit' => $current_credit,
                                'available_credit' => $available_credit,
                            )));
                            die(json_encode($res[1][key($res[1])]));
                        } else {
                            //factor aval
                            die(json_encode(array(
                                'current_credit' => 0,
                                'available_credit' => 0,
                            )));
                        }
                    } else {
                        die(Helper::Json_Message('f'));
                    }

                    break;
                case 'sj_ip_adsl_get_user_services':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                                $sql = "SELECT
                                        fa.id,
                                        fa.emkanat_id,
                                        fa.service_id,
                                        fa.subscriber_id,
                                        sub.branch_id,
                                        ser.type
                                    FROM bnm_factor fa
                                        INNER JOIN bnm_services ser ON ser.id = fa.service_id
                                        INNER JOIN bnm_subscribers sub ON sub.id = fa.subscriber_id
                                    WHERE fa.subscriber_id = ? AND fa.tasvie_shode = ?
                                    GROUP BY fa.emkanat_id,ser.type";
                                $result = Db::secure_fetchall($sql, [$_POST['condition'], 1]);
                                break;
                            case __MODIRUSERTYPE__:
                            case __OPERATORUSERTYPE__:
                            case __MODIR2USERTYPE__:
                            case __OPERATOR2USERTYPE__:
                                $sql = "SELECT
                                        fa.id,
                                        fa.emkanat_id,
                                        fa.subscriber_id,
                                        fa.service_id,
                                        sub.branch_id,
                                        ser.type
                                    FROM bnm_factor fa
                                        INNER JOIN bnm_services ser ON ser.id = fa.service_id
                                        INNER JOIN bnm_subscribers sub ON sub.id = fa.subscriber_id
                                    WHERE fa.subscriber_id = ? AND fa.tasvie_shode = ? AND sub.branch_id = ?
                                    GROUP BY fa.emkanat_id,ser.type";
                                $result = Db::secure_fetchall($sql, [$_POST['condition'], 1, $_SESSION['branch_id']]);
                                break;
                            case __MOSHTARAKUSERTYPE__:
                                $sql = "SELECT
                                        fa.id,
                                        fa.emkanat_id,
                                        fa.service_id,
                                        fa.subscriber_id,
                                        sub.branch_id,
                                        ser.type
                                    FROM bnm_factor fa
                                        INNER JOIN bnm_services ser ON ser.id = fa.service_id
                                        INNER JOIN bnm_subscribers sub ON sub.id = fa.subscriber_id
                                    WHERE fa.subscriber_id = ? AND fa.tasvie_shode = ?
                                    GROUP BY fa.emkanat_id,ser.type";
                                $result = Db::secure_fetchall($sql, [$_SESSION['user_id'], 1]);
                                break;
                        }
                    }
                    if ($result) {
                        if (isset($result[0])) {
                            $res = Helper::adslUserInfo((int) $result[0]['id'], (int) $result[0]['branch_id']);
                            $result[0]['telephone'] = $res1[0]['telephone'];
                        }
                        if (isset($result[1])) {
                            $res2 = Helper::adslUserInfo((int) $result[1]['id'], (int) $result[1]['branch_id']);
                            $result[1]['telephone'] = $res2[0]['telephone'];
                        }
                        if (isset($result[2])) {
                            $res3 = Helper::adslUserInfo((int) $result[2]['id'], (int) $result[2]['branch_id']);
                            $result[2]['telephone'] = $res3[0]['telephone'];
                        }
                        // die(json_encode($result));
                    } else {
                        die(Helper::Json_Message('f'));
                    }
                    break;
                case 'sj_voip_get_user_telephone':
                    if (Helper::Login_Just_Check()) {
                        switch ($_SESSION['user_type']) {
                            case __ADMINUSERTYPE__:
                            case __ADMINOPERATORUSERTYPE__:
                                $sql = "SELECT id,telephone1,telephone2,telephone3 FROM bnm_subscribers WHERE id = ?";
                                $result = Db::secure_fetchall($sql, array($_POST['condition']));
                                if ($result) {
                                    $rows = json_encode($result);
                                    die($rows);
                                } else {
                                    die(Helper::Json_Message('f'));
                                }

                                break;
                            case __MODIRUSERTYPE__:
                            case __OPERATORUSERTYPE__:
                            case __MODIR2USERTYPE__:
                            case __OPERATOR2USERTYPE__:
                                $id = $_POST['condition'];
                                $sql = "SELECT id,telephone1,telephone2,telephone3 FROM bnm_subscribers WHERE id = ? AND branch_id=?";
                                $result = Db::secure_fetchall($sql, array($id, $_SESSION['branch_id']));
                                if ($result) {
                                    $rows = json_encode($result);
                                    die($rows);
                                } else {
                                    die(Helper::Json_Message('f'));
                                }

                                break;
                            case __MOSHTARAKUSERTYPE__:
                                $sql = "SELECT id,telephone1,telephone2,telephone3 FROM bnm_subscribers WHERE id = ?";
                                $result = Db::secure_fetchall($sql, array($_SESSION['user_id']));
                                if ($result) {
                                    $rows = json_encode($result);
                                    die($rows);
                                } else {
                                    die(Helper::Json_Message('f'));
                                }

                                break;
                        }
                    }
                    break;
                case 'ekhtesas_adsl_tab_link':
                case 'ekhtesas_vdsl_tab_link':
                case 'ekhtesas_wireless_tab_link':
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                        case __OPERATORUSERTYPE__:
                        case __MODIR2USERTYPE__:
                        case __MODIRUSERTYPE__:
                        case __OPERATOR2USERTYPE__:
                            $result = Helper::Select_By_Id('bnm_subscribers', $_POST['condition']);
                            die(json_encode($result));
                            break;
                        case __MOSHTARAKUSERTYPE__:
                            die(Helper::Json_Message('af'));
                            $result = Helper::Select_By_Id('bnm_subscribers', $_SESSION['user_id']);
                            die(json_encode($result));
                            break;

                        default:
                            die(Helper::Json_Message('af'));
                            break;
                    }

                    break;
                case 'ekhtesas_tdlte_tab_link':
                    $result = Helper::Select_By_Id('bnm_subscribers', $_POST['condition']);
                    if ($result) {
                        //get tdlte simcards where sim card not assigned to user
                        $sim_sql = "SELECT * FROM bnm_tdlte_sim WHERE subscriber_id IS NULL AND subscriber_code_eshterak IS NULL";
                        $res_sim = Db::fetchall_Query($sim_sql);
                        $rows = json_encode($res_sim);
                        die($rows);
                    } else {
                        die(json_encode(array('Error' => 'مشترک مورد تظر یافت نشد پس از بررسی مجددا تلاش کنید.')));
                    }
                    break;
                case 'connection_log':
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                        case __OPERATORUSERTYPE__:
                        case __MODIR2USERTYPE__:
                        case __MODIRUSERTYPE__:
                        case __OPERATOR2USERTYPE__:
                            $user_id = $_POST['condition'];
                            $sql = "SELECT * FROM bnm_factor WHERE subscriber_id=? LIMIT 1";
                            $result = Db::secure_fetchall($sql, array($user_id));
                            if ($result) {
                                $res_ibs = $GLOBALS['ibs_internet']->getUserInfoByNormalUserName($result[0]['ibs_username']);
                                //$res_ibs=$GLOBALS['ibs_internet']->getConnectionLogs(date('Y-m-d').' 23:59:59',date('Y-m-d').' 00:00:00');
                                die(json_encode($res_ibs));
                            } else {
                                die(json_encode(array('factor not found')));
                            }
                            break;
                        case __MOSHTARAKUSERTYPE__:
                            $user_id = $_SESSION['user_id'];
                            $sql = "SELECT * FROM bnm_factor WHERE subscriber_id=? LIMIT 1";
                            $result = Db::secure_fetchall($sql, array($user_id));
                            if ($result) {
                                $res_ibs = $GLOBALS['ibs_internet']->getUserInfoByNormalUserName($result[0]['ibs_username']);
                                //$res_ibs=$GLOBALS['ibs_internet']->getConnectionLogs(date('Y-m-d').' 23:59:59',date('Y-m-d').' 00:00:00');
                                die(json_encode($res_ibs));
                            } else {
                                die(json_encode(array('factor not found')));
                            }
                            break;
                        default:
                            die(Helper::Json_Message('af'));
                            break;
                    }

                    break;
                case 'ekhtesas_adsl_after_select_phone':
                case 'ekhtesas_vdsl_after_select_phone':
                    $result = array();
                    $res_sub = Helper::Select_By_Id('bnm_subscribers', $_POST['condition1']);
                    if ($res_sub) {
                        switch ($_POST['condition2']) {
                            case '1':
                                $selected_phone = $res_sub[0]['telephone1'];
                                break;
                            case '2':
                                $selected_phone = $res_sub[0]['telephone2'];
                                break;
                            case '3':
                                $selected_phone = $res_sub[0]['telephone3'];
                                break;
                            default:
                                die(Helper::Json_Message('f'));
                                break;
                        }
                        $res_telecenter = $res_sar_shomare = $res_shahr = $res_port = $res_ostan = array();
                        $splitnum = array();
                        $splitnum = str_split($selected_phone);
                        $ostan_prenum = $splitnum[0] . $splitnum[1] . $splitnum[2];
                        $markaz_prenum = $splitnum[3] . $splitnum[4] . $splitnum[5] . $splitnum[6];
                        $res_sar_shomare = Db::secure_fetchall("SELECT * FROM bnm_pre_number WHERE prenumber=? ORDER BY id limit 1", array($markaz_prenum));
                        if (!$res_sar_shomare) {
                            die(json_encode(array('Error' => 'امکان ارائه پورت با این پیش شماره وجود ندارد')));
                        }
                        $markaz_id = $res_sar_shomare[0]['markaze_mokhaberati'];
                        $res_telecenter = Db::fetchall_Query("SELECT * FROM bnm_telecommunications_center WHERE id=$markaz_id");
                        if (!$res_telecenter) {
                            die(json_encode(array('Error' => 'مرکز مخابراتی با این پیش شماره یافت نشد')));
                        }
                        $ostan_id = $res_telecenter[0]['ostan'];
                        $shahr_id = $res_telecenter[0]['shahr'];
                        $res_ostan = Db::fetchall_Query("SELECT * FROM bnm_ostan WHERE id =$ostan_id");
                        if (!$res_ostan) {
                            die(json_encode(array('Error' => 'استانی یافت نشد')));
                        }
                        $res_shahr = Db::fetchall_Query("SELECT * FROM bnm_shahr WHERE id =$shahr_id");
                        if (!$res_shahr) {
                            die(json_encode(array('Error' => 'شهری یافت نشد')));
                        }
                        $res_port = Db::fetchall_Query("SELECT * FROM bnm_port WHERE status='salem' AND telephone='' AND adsl_vdsl='adsl' order by id asc limit 1");
                        if (!$res_port) {
                            die(json_encode(array('Error' => 'پورتی یافت نشد!')));
                        }
                        //////////////////initializing result///////////////////////
                        $result[0]['markaz_id'] = $res_telecenter[0]['id'];
                        $result[0]['pish_shomare_ostan'] = $res_telecenter[0]['pish_shomare_ostan'];
                        $result[0]['markaz_id'] = $res_telecenter[0]['id'];
                        $result[0]['markaz_name'] = $res_telecenter[0]['name'];
                        $result[0]['ostan'] = $res_ostan[0]['name'];
                        $result[0]['shahr'] = $res_shahr[0]['name'];
                        $result[0]['port_id'] = $res_port[0]['id'];
                        $result[0]['port_radif'] = $res_port[0]['radif'];
                        $result[0]['port_tighe'] = $res_port[0]['tighe'];
                        $result[0]['port_etesal'] = $res_port[0]['etesal'];
                        $result[0]['telephone'] = $_POST['condition2'];
                        $rows = json_encode($result);
                        die($rows);
                    } else {
                        die(Helper::Json_Message('f'));
                    }
                    // $rows = json_encode($result);
                    // die($rows);
                    break;
                case 'wireless_services':
                    //$id=$_POST['condition'];
                    $sql = "SELECT * FROM bnm_services WHERE type='wireless'";
                    $result = Db::secure_fetchall($sql, array('wireless'));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'tdlte_services':
                    //$id=$_POST['condition'];
                    $sql = "SELECT * FROM bnm_services WHERE type= ?";
                    $result = Db::secure_fetchall($sql, array('tdlte'));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'sefareshe_jadid_serviceslist_li':
                    $sql = "select * FROM bnm_services WHERE id=?";
                    $result = Db::secure_fetchall($sql, array($_POST['condition']));
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'factors_serviceslist_li':
                    $id = $_POST['condition'];
                    $sql = "select * FROM bnm_services WHERE id='$id'";
                    $result = Db::fetchall_Query($sql);
                    $rows = json_encode($result);
                    die($rows);
                    break;
                case 'factors':
                    $id = $_POST['condition'];
                    $sql = "select * FROM bnm_services";
                    $result = Db::fetchall_Query($sql);
                    $rows = json_encode($result);
                    die($rows);
                    break;
            }
        }

        ///sefareshe jadid -> factor
        if (isset($_POST['send_sefareshe_jadid_bs']) || isset($_POST['send_sefareshe_jadid_adsl']) || isset($_POST['send_sefareshe_jadid_wireless']) || isset($_POST['send_sefareshe_jadid_tdlte']) || isset($_POST['send_sefareshe_jadid_voip'])) {
            try {
                $_POST = Helper::Create_Post_Array_Without_Key($_POST);
                $_POST = Helper::xss_check_array($_POST);
                if (Helper::Login_Just_Check()) {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            $sql_tax = "SELECT * FROM bnm_tax ORDER BY id DESC LIMIT 1";
                            $res_tax = Db::fetchall_Query($sql_tax);
                            if (!$res_tax) {
                                die(Helper::Json_Message('tinf'));
                            }
                            $sql_services = "SELECT * FROM bnm_services WHERE id = ? AND namayeshe_service='yes' AND tarikhe_shoroe_namayesh<=CURDATE() AND tarikhe_payane_namayesh >= CURDATE()";
                            $res_services = Db::secure_fetchall($sql_services, array($_POST['service_id']), true);
                            $sql_subscriber = "SELECT * FROM bnm_subscribers WHERE id = ?";
                            $res_subscriber = Db::secure_fetchall($sql_subscriber, array($_POST['subscriber_id']), true);
                            break;
                        case __MODIRUSERTYPE__:
                        case __OPERATORUSERTYPE__:
                        case __MODIR2USERTYPE__:
                        case __OPERATOR2USERTYPE__:
                            $service_id = $_POST['service_id'];
                            $sql_tax = "SELECT * FROM bnm_tax ORDER BY id DESC LIMIT 1";
                            $res_tax = Db::fetchall_Query($sql_tax);
                            if (!$res_tax) {
                                die(Helper::Json_Message('tinf'));
                            }
                            $sql_services = "SELECT * FROM bnm_services WHERE id =? AND namayeshe_service='yes' AND tarikhe_shoroe_namayesh<=CURDATE() AND tarikhe_payane_namayesh >= CURDATE()";
                            $res_services = Db::secure_fetchall($sql_services, array($_POST['service_id']));
                            $sql_subscriber = "SELECT * FROM bnm_subscribers WHERE id = ? AND branch_id=?";
                            $res_subscriber = Db::secure_fetchall($sql_subscriber, array($_POST['subscriber_id'], $_SESSION['branch_id']));
                            break;
                        case __MOSHTARAKUSERTYPE__:
                            $sql_tax = "SELECT * FROM bnm_tax ORDER BY id DESC LIMIT 1";
                            $res_tax = Db::fetchall_Query($sql_tax);
                            if (!$res_tax) {
                                die(Helper::Json_Message('tinf'));
                            }
                            $sql_services = "SELECT * FROM bnm_services WHERE id = ? AND namayeshe_service='yes' AND tarikhe_shoroe_namayesh<=CURDATE() AND tarikhe_payane_namayesh >= CURDATE()";
                            $res_services = Db::secure_fetchall($sql_services, array($_POST['service_id']), true);
                            $sql_subscriber = "SELECT * FROM bnm_subscribers WHERE id = ?";
                            $res_subscriber = Db::secure_fetchall($sql_subscriber, array($_SESSION['user_id']), true);
                            break;
                        default:
                            die(Helper::Json_Message('af'));
                            break;
                    }
                    

                    if(! isset($res_services)){die(Helper::Json_Message('inf'));}
                    if(! isset($res_subscriber)){die(Helper::Json_Message('inf'));}
                    if ($res_services) {
                        if ($res_subscriber) {
                            if (isset($res_services[0]['zaname_estefade_be_tarikh']) && isset($res_services[0]['onvane_service']) && isset($res_subscriber[0]['code_eshterak'])) {
                                $_POST['zaname_estefade_be_tarikh'] = $res_services[0]['zaname_estefade_be_tarikh'];
                                $_POST['onvane_service'] = $res_services[0]['onvane_service'];
                                $_POST['type'] = $res_services[0]['type'];
                                $_POST['zaname_estefade'] = $res_services[0]['zaname_estefade'];
                                $_POST['abonmane_port'] = floatval($res_services[0]['port']);
                                $_POST['abonmane_faza'] = floatval($res_services[0]['faza']);
                                $_POST['abonmane_tajhizat'] = floatval($res_services[0]['tajhizat']);
                                $_POST['hazine_ranzhe'] = floatval($res_services[0]['hazine_ranzhe']);
                                $_POST['hazine_dranzhe'] = floatval($res_services[0]['hazine_dranzhe']);
                                $_POST['hazine_nasb'] = floatval($res_services[0]['hazine_nasb']);
                                $_POST['code_eshterak'] = $res_subscriber[0]['code_eshterak'];
                                $_POST['subscriber_id'] = $res_subscriber[0]['id'];
                                $_POST['branch_id'] = $res_subscriber[0]['branch_id'];
                                $_POST['darsade_avareze_arzeshe_afzode'] = floatval($res_tax[0]['darsade_avarez_arzeshe_afzode']);
                                $_POST['maliate_arzeshe_afzode'] = floatval($res_tax[0]['darsade_maliate_arzeshe_afzode']);
                                $_POST['sazande_factor_id'] = $_SESSION['id'];
                                $_POST['sazande_factor_username'] = $_SESSION['username'];
                                $_POST['sazande_factor_user_type'] = $_SESSION['user_type'];
                                $_POST['tarikhe_akharin_virayesh'] = Helper::Today_Miladi_Date('/');
                                $_POST['tarikhe_payane_service'] = Helper::Add_Or_Minus_Day_To_Date($res_services[0]['zaname_estefade'])." ". Helper::nowTimeTehran(':', true, true);
                                $_POST['tarikhe_shoroe_service'] = Helper::Today_Miladi_Date()." ". Helper::nowTimeTehran(':', true, true);
                                $_POST['mablaghe_ghabele_pardakht'] = 0;
                                $_POST['gheymate_service'] = floatval($res_services[0]['gheymat']);
                                $_POST['noe_khadamat'] = $res_services[0]['noe_khadamat'];
                                $_POST['takhfif'] = floatval($res_services[0]['takhfif']);
                                switch ($res_services[0]['type']) {
                                    case 'bitstream':
                                        $internal_message_karbord = 'sfadm';                                        
                                        $checkpreviousefactorexist = Helper::checkNormalPreviousFactorExist($res_subscriber[0]['id'], $_POST['telephone'], $res_services[0]['type']);
                                        if ($checkpreviousefactorexist[0]['tedad'] === 0) {
                                            //factore aval hazine ranzhe & dranzhe & hazine_nasb hesab shavad
                                            $_POST['hazine_ranzhe'] = floatval($res_services[0]['hazine_ranzhe']);
                                            $_POST['hazine_dranzhe'] = floatval($res_services[0]['hazine_dranzhe']);
                                            $_POST['hazine_nasb'] = floatval($res_services[0]['hazine_nasb']);
                                        } else {
                                            //factore chandom
                                            $_POST['hazine_ranzhe'] = 0;
                                            $_POST['hazine_dranzhe'] = 0;
                                            $_POST['hazine_nasb'] = 0;
                                        }
                                        if ($_POST['takhfif'] !== 0 && isset($_POST['takhfif'])) {
                                            $_POST['takhfif'] = floatval($_POST['takhfif']);
                                            $_POST['takhfif'] = ($_POST['takhfif'] * $_POST['gheymate_service']) / 100;
                                            $gheymat = $_POST['gheymate_service'] - $_POST['takhfif'];
                                        } else {
                                            $gheymat = $_POST['gheymate_service'];
                                        }
                                        $_POST['mablaghe_ghabele_pardakht'] = $gheymat + floatval($_POST['hazine_ranzhe'])
                                        + floatval($_POST['hazine_nasb']) + floatval($_POST['hazine_dranzhe'])
                                        + floatval($res_services[0]['port']) + floatval($res_services[0]['faza'])
                                        + floatval($res_services[0]['tajhizat']);
                                        $_POST['darsade_avareze_arzeshe_afzode']    = (floatval($_POST['mablaghe_ghabele_pardakht']) * floatval($_POST['darsade_avareze_arzeshe_afzode'])) / 100;
                                        $_POST['maliate_arzeshe_afzode']            = (floatval($_POST['mablaghe_ghabele_pardakht']) * floatval($_POST['maliate_arzeshe_afzode'])) / 100;
                                        $_POST['mablaghe_ghabele_pardakht']         = $_POST['mablaghe_ghabele_pardakht'] + $_POST['darsade_avareze_arzeshe_afzode'] + $_POST['maliate_arzeshe_afzode'];
                                        $_POST['gheymate_service']                  = floatval($res_services[0]['gheymat']);
                                        $_POST['emkanat_id']                        = $_POST['telephone'];
                                        unset($_POST['telephone']);
                                        break;
                                    case 'adsl':
                                        $internal_message_karbord = 'sfadm';
                                        $checkpreviousefactorexist = Helper::checkNormalPreviousFactorExist($res_subscriber[0]['id'], $_POST['port_id'], $res_services[0]['type']);
                                        if ($checkpreviousefactorexist[0]['tedad'] === 0) {
                                            //factore aval hazine ranzhe & dranzhe & hazine_nasb hesab shavad
                                            $_POST['hazine_ranzhe'] = floatval($res_services[0]['hazine_ranzhe']);
                                            $_POST['hazine_dranzhe'] = floatval($res_services[0]['hazine_dranzhe']);
                                            $_POST['hazine_nasb'] = floatval($res_services[0]['hazine_nasb']);
                                        } else {
                                            //factore chandom
                                            $_POST['hazine_ranzhe'] = 0;
                                            $_POST['hazine_dranzhe'] = 0;
                                            $_POST['hazine_nasb'] = 0;
                                        }
                                        if ($_POST['takhfif'] !== 0 && isset($_POST['takhfif'])) {
                                            $_POST['takhfif'] = floatval($_POST['takhfif']);
                                            $_POST['takhfif'] = ($_POST['takhfif'] * $_POST['gheymate_service']) / 100;
                                            $gheymat = $_POST['gheymate_service'] - $_POST['takhfif'];
                                        } else {
                                            $gheymat = $_POST['gheymate_service'];
                                        }
                                        $_POST['mablaghe_ghabele_pardakht'] = $gheymat + floatval($_POST['hazine_ranzhe'])
                                         + floatval($_POST['hazine_nasb']) + floatval($_POST['hazine_dranzhe'])
                                         + floatval($res_services[0]['port']) + floatval($res_services[0]['faza'])
                                         + floatval($res_services[0]['tajhizat']);
                                         
                                        $_POST['darsade_avareze_arzeshe_afzode'] = (floatval($_POST['mablaghe_ghabele_pardakht']) * floatval($_POST['darsade_avareze_arzeshe_afzode'])) / 100;
                                        $_POST['maliate_arzeshe_afzode'] = (floatval($_POST['mablaghe_ghabele_pardakht']) * floatval($_POST['maliate_arzeshe_afzode'])) / 100;
                                        $_POST['mablaghe_ghabele_pardakht'] = $_POST['mablaghe_ghabele_pardakht'] + $_POST['darsade_avareze_arzeshe_afzode'] + $_POST['maliate_arzeshe_afzode'];
                                        $_POST['gheymate_service'] = floatval($res_services[0]['gheymat']);
                                        $_POST['emkanat_id'] = $_POST['port_id'];
                                        unset($_POST['port_id']);
                                        
                                        break;
                                    case 'vdsl':
                                        $internal_message_karbord = 'sfvdm';
                                        $checkpreviousefactorexist = Helper::checkNormalPreviousFactorExist($res_subscriber[0]['id'], $_POST['port_id'], $res_services[0]['type']);
                                        if ($checkpreviousefactorexist[0]['tedad'] === 0) {
                                            //factore aval hazine ranzhe & dranzhe & hazine_nasb hesab shavad
                                            $_POST['hazine_ranzhe'] = floatval($res_services[0]['hazine_ranzhe']);
                                            $_POST['hazine_dranzhe'] = floatval($res_services[0]['hazine_dranzhe']);
                                            $_POST['hazine_nasb'] = floatval($res_services[0]['hazine_nasb']);
                                        } else {
                                            //factore chandom
                                            $_POST['hazine_ranzhe'] = 0;
                                            $_POST['hazine_dranzhe'] = 0;
                                            $_POST['hazine_nasb'] = 0;
                                        }
                                        if ($_POST['takhfif'] !== 0 && isset($_POST['takhfif'])) {
                                            $_POST['takhfif'] = floatval($_POST['takhfif']);
                                            $_POST['takhfif'] = ($_POST['takhfif'] * $_POST['gheymate_service']) / 100;
                                            $gheymat = $_POST['gheymate_service'] - $_POST['takhfif'];
                                        } else {
                                            $gheymat = $_POST['gheymate_service'];
                                        }
                                        $_POST['mablaghe_ghabele_pardakht'] = $gheymat + floatval($_POST['hazine_ranzhe'])
                                        + floatval($_POST['hazine_nasb']) + floatval($_POST['hazine_dranzhe'])
                                         + floatval($res_services[0]['port']) + floatval($res_services[0]['faza'])
                                         + floatval($res_services[0]['tajhizat']);
                                         $_POST['darsade_avareze_arzeshe_afzode']   = (floatval($_POST['mablaghe_ghabele_pardakht']) * floatval($_POST['darsade_avareze_arzeshe_afzode'])) / 100;
                                         $_POST['maliate_arzeshe_afzode']           = (floatval($_POST['mablaghe_ghabele_pardakht']) * floatval($_POST['maliate_arzeshe_afzode'])) / 100;
                                        $_POST['mablaghe_ghabele_pardakht']         = $_POST['mablaghe_ghabele_pardakht'] + $_POST['darsade_avareze_arzeshe_afzode'] + $_POST['maliate_arzeshe_afzode'];
                                        $_POST['gheymate_service']                  = floatval($res_services[0]['gheymat']);
                                        $_POST['emkanat_id']                        = $_POST['port_id'];
                                        unset($_POST['port_id']);
                                        break;
                                    case 'wireless':
                                        $internal_message_karbord = 'sfwim';
                                        $_POST['emkanat_id'] = $_POST['istgah_name'];
                                        unset($_POST['istgah_name']);
                                        $checkpreviousefactorexist = Helper::checkNormalPreviousFactorExist($res_subscriber[0]['id'], $_POST['emkanat_id'], $res_services[0]['type']);
                                        $_POST['hazine_ranzhe'] = 0;
                                        $_POST['hazine_dranzhe'] = 0;
                                        if ($checkpreviousefactorexist[0]['tedad'] === 0) {
                                            $_POST['hazine_nasb'] = floatval($res_services[0]['hazine_nasb']);
                                        } else {
                                            $_POST['hazine_nasb'] = 0;
                                        }
                                        $_POST['takhfif'] = floatval($_POST['takhfif']);
                                        $_POST['takhfif'] = ($_POST['takhfif'] * $_POST['gheymate_service']) / 100;
                                        if ($_POST['takhfif'] !== 0 && isset($_POST['takhfif'])) {
                                            $gheymat = $_POST['gheymate_service'] - $_POST['takhfif'];
                                        } else {
                                            $gheymat = $_POST['gheymate_service'];
                                        }
                                        $_POST['mablaghe_ghabele_pardakht'] = $gheymat
                                         + floatval($_POST['hazine_nasb']) + floatval($res_services[0]['faza'])
                                         + floatval($res_services[0]['port']) + floatval($res_services[0]['tajhizat']);
                                         $_POST['darsade_avareze_arzeshe_afzode'] = (floatval($_POST['mablaghe_ghabele_pardakht']) * floatval($_POST['darsade_avareze_arzeshe_afzode'])) / 100;
                                         $_POST['maliate_arzeshe_afzode'] = (floatval($_POST['mablaghe_ghabele_pardakht']) * floatval($_POST['maliate_arzeshe_afzode'])) / 100;
                                        $_POST['mablaghe_ghabele_pardakht'] = $_POST['mablaghe_ghabele_pardakht'] + $_POST['darsade_avareze_arzeshe_afzode'] + $_POST['maliate_arzeshe_afzode'];
                                        $_POST['gheymate_service'] = floatval($res_services[0]['gheymat']);
                                        break;
                                    case 'tdlte':
                                        unset($_POST['ibs_username']);
                                        unset($_POST['istgah_name']);
                                        $internal_message_karbord = 'sftdm';
                                        $checkpreviousefactorexist = Helper::checkNormalPreviousFactorExist($res_subscriber[0]['id'], $_POST['emkanat_id'], $res_services[0]['type']);
                                        $_POST['hazine_ranzhe'] = 0;
                                        $_POST['hazine_dranzhe'] = 0;
                                        if ($checkpreviousefactorexist[0]['tedad'] === 0) {
                                            $_POST['hazine_nasb'] = floatval($res_services[0]['hazine_nasb']);
                                        } else {
                                            $_POST['hazine_nasb'] = 0;
                                        }
                                        $_POST['takhfif'] = floatval($_POST['takhfif']);
                                        $_POST['takhfif'] = ($_POST['takhfif'] * $_POST['gheymate_service']) / 100;
                                        if ($_POST['takhfif'] !== 0 && isset($_POST['takhfif'])) {
                                            $gheymat = $_POST['gheymate_service'] - $_POST['takhfif'];
                                        } else {
                                            $gheymat = $_POST['gheymate_service'];
                                        }
                                        $_POST['mablaghe_ghabele_pardakht'] = $gheymat
                                         + floatval($_POST['hazine_nasb']) + floatval($res_services[0]['faza'])
                                         + floatval($res_services[0]['port']) + floatval($res_services[0]['tajhizat']);
                                        $_POST['darsade_avareze_arzeshe_afzode']    = (floatval($_POST['mablaghe_ghabele_pardakht']) * floatval($_POST['darsade_avareze_arzeshe_afzode'])) / 100;
                                        $_POST['maliate_arzeshe_afzode']            = (floatval($_POST['mablaghe_ghabele_pardakht']) * floatval($_POST['maliate_arzeshe_afzode'])) / 100;
                                        $_POST['mablaghe_ghabele_pardakht']         = $_POST['mablaghe_ghabele_pardakht'] + $_POST['darsade_avareze_arzeshe_afzode'] + $_POST['maliate_arzeshe_afzode'];
                                        $_POST['gheymate_service']                  = floatval($res_services[0]['gheymat']);
                                        break;
                                    case 'voip':
                                        $_POST['emkanat_id'] = $_POST['ibs_username'];
                                        unset($_POST['ibs_username']);
                                        $internal_message_karbord = 'sfvom';
                                        $_POST['hazine_ranzhe'] = 0;
                                        $_POST['hazine_dranzhe'] = 0;
                                        $_POST['hazine_nasb'] = 0;
                                        $_POST['takhfif'] = floatval($_POST['takhfif']);
                                        $_POST['takhfif'] = ($_POST['takhfif'] * $_POST['gheymate_service']) / 100;
                                        if ($_POST['takhfif'] !== 0 && isset($_POST['takhfif'])) {
                                            $gheymat = $_POST['gheymate_service'] - $_POST['takhfif'];
                                        } else {
                                            $gheymat = $_POST['gheymate_service'];
                                        }
                                        $_POST['mablaghe_ghabele_pardakht']         = $gheymat;
                                        $_POST['darsade_avareze_arzeshe_afzode']    = (floatval($_POST['mablaghe_ghabele_pardakht']) * floatval($_POST['darsade_avareze_arzeshe_afzode'])) / 100;
                                        $_POST['maliate_arzeshe_afzode']            = (floatval($_POST['mablaghe_ghabele_pardakht']) * floatval($_POST['maliate_arzeshe_afzode'])) / 100;
                                        $_POST['mablaghe_ghabele_pardakht']         = $_POST['mablaghe_ghabele_pardakht'] + $_POST['darsade_avareze_arzeshe_afzode'] + $_POST['maliate_arzeshe_afzode'];
                                        $_POST['gheymate_service']                  = floatval($res_services[0]['gheymat']);
                                        break;
                                    default:
                                        die(Helper::Json_Message('sinf'));
                                        break;
                                }
                                unset($_POST['ibs_username']);
                                ////factore ghabli
                                // $sql = "SELECT f.id,f.emkanat_id,s.id,s.type,s.noe_forosh FROM bnm_factor f
                                //             INNER JOIN bnm_services s ON f.service_id = s.id
                                //             WHERE f.emkanat_id = ? AND s.type = ? AND f.subscriber_id = ? AND f.tasvie_shode = ?
                                //             ORDER BY f.tarikhe_factor DESC LIMIT 1";

                                // $res = Db::secure_fetchall($sql, array(
                                //     $_POST['emkanat_id'],
                                //     $res_services[0]['type'],
                                //     $res_subscriber[0]['id'],
                                //     1,
                                // ));
                                $res = Helper::checkNormalPreviousFactorExist($res_subscriber[0]['id'], $_POST['emkanat_id'], $res_services[0]['type']);
                                if ($res_services[0]['type'] !== 'voip') {
                                    if ($res[0]['tedad'] === 0) {
                                        //moshtarak jadid ast
                                        if ($res_services[0]['noe_forosh'] === 'adi' || $res_services[0]['noe_forosh'] === 'jashnvare') {
                                            $sql = Helper::Insert_Generator($_POST, 'bnm_factor');
                                            $result = Db::secure_insert_array($sql, $_POST);
                                        } elseif ($res_services[0]['noe_forosh'] === 'bulk') {
                                            die(Helper::Custom_Msg(Helper::Messages('ffcbb'), 3));
                                        } else {
                                            die(Helper::Json_Message('f'));
                                        }
                                    } else {
                                        //check factor faal darad ya na
                                        $sql = "SELECT
                                                f.id,f.tarikhe_factor,f.tarikhe_payane_service
                                            FROM
                                                bnm_factor f
                                                INNER JOIN bnm_services s ON s.id = f.service_id
                                            WHERE
                                                f.emkanat_id = ?
                                                AND f.subscriber_id = ?
                                                AND s.type = ?
                                                AND f.tasvie_shode = ?
                                                AND s.noe_forosh IN ( 'adi', 'jashnvare' )
                                                AND f.tarikhe_payane_service >= CURRENT_TIMESTAMP()
                                            ORDER BY
                                                f.tarikhe_factor DESC
                                                LIMIT 1
                                                ";
                                        $res2 = Db::secure_fetchall($sql, array(
                                            $_POST['emkanat_id'],
                                            $res_subscriber[0]['id'],
                                            $res_services[0]['type'],
                                            1,
                                        ));
                                        if ($res2) {
                                            //faghat bulk
                                            if ($res_services[0]['noe_forosh'] === "bulk") {
                                                $_POST['tarikhe_payane_service'] = $res2[0]['tarikhe_payane_service'];
                                                $sql = Helper::Insert_Generator($_POST, 'bnm_factor');
                                                $result = Db::secure_insert_array($sql, $_POST);
                                            } else {
                                                die(Helper::Custom_Msg(Helper::Messages('bbso'), 3));
                                            }
                                        } else {
                                            //faghat adi(expire shode)
                                            if ($res_services[0]['noe_forosh'] === "adi" || $res_services[0]['noe_forosh'] === "jashnvare") {
                                                ///akharin factor adi
                                                $sql = "SELECT
                                                    f.id,f.tarikhe_factor,f.tarikhe_payane_service,s.terafik
                                                FROM
                                                    bnm_factor f
                                                    INNER JOIN bnm_services s ON s.id = f.service_id
                                                WHERE
                                                    f.emkanat_id = ?
                                                    AND f.subscriber_id = ?
                                                    AND s.type = ?
                                                    AND f.tasvie_shode = ?
                                                    AND s.noe_forosh IN ( 'adi', 'jashnvare' )
                                                    AND f.tarikhe_factor < CURRENT_TIMESTAMP()
                                                ORDER BY
                                                    f.tarikhe_factor DESC
                                                    LIMIT 1
                                                ";
                                                $res2 = Db::secure_fetchall($sql, array(
                                                    $_POST['emkanat_id'],
                                                    $res_subscriber[0]['id'],
                                                    $res_services[0]['type'],
                                                    1,
                                                ));
                                                ///factor avali nist pas terafik bulk haye ghabli ro migirim
                                                $sql = "SELECT
                                                    f.id,
                                                    SUM( ser.terafik ) sumterafik
                                                FROM
                                                    bnm_factor f
                                                    INNER JOIN bnm_services ser ON ser.id = f.service_id
                                                WHERE
                                                    f.tarikhe_factor >= ?
                                                    AND f.tarikhe_factor <= CURDATE()
                                                    AND f.subscriber_id = ?
                                                    AND f.emkanat_id = ?
                                                    AND ser.type = ?
                                                    AND ser.noe_forosh = 'bulk'
                                                ";
                                                $res_checkbulks = Db::secure_fetchall($sql, [$res2[0]['tarikhe_factor'], $res_subscriber[0]['id'], $_POST['emkanat_id'], $res_services[0]['type']]);
                                                if ($res_checkbulks) {
                                                    $ibsusername = Helper::getIbsUsername($res_subscriber[0]['id'], $res_services[0]['type'], $_POST['emkanat_id']);
                                                    
                                                    if ($ibsusername) {
                                                        
                                                        // mohasebe etebare ghabele enteghal ba tavajoh be credit baghimande
                                                        $res_ibs = $GLOBALS['ibs_internet']->getUserInfoByNormalUserName($ibsusername[0]['ibsusername']);
                                                        // die(json_encode($res_ibs));
                                                        if (Helper::ibsCheckUserinfoExist($res_ibs)) {
                                                            $key = key($res_ibs[1]);
                                                            $credit = $res_ibs[1][$key]['basic_info']['credit'];
                                                            if (floatval($credit / 1024) <= $res_checkbulks[0]['sumterafik']) {
                                                                $_POST['etebare_baghimande'] = $credit;
                                                                $_POST['etebare_ghabele_enteghal'] = $credit;
                                                                $sql = Helper::Insert_Generator($_POST, 'bnm_factor');
                                                                $result = Db::secure_insert_array($sql, $_POST);
                                                            } else {
                                                                $_POST['etebare_baghimande'] = $credit;
                                                                $_POST['etebare_ghabele_enteghal'] = $res_checkbulks[0]['sumterafik'];
                                                                $sql = Helper::Insert_Generator($_POST, 'bnm_factor');
                                                                $result = Db::secure_insert_array($sql, $_POST);
                                                            }
                                                        } else {
                                                            die(Helper::Custom_Msg(Helper::Messages('inf'), 3));
                                                        }
                                                    } else {
                                                        die(Helper::Custom_Msg(Helper::Messages('inf'), 3));
                                                    }

                                                } else {
                                                    //user bulk nakharide pas hich hajmi be baste jadid enteghal peyda nemikone
                                                    $_POST['etebare_ghabele_enteghal'] = 0;
                                                    $_POST['etebare_baghimande'] = 0;
                                                    $sql = Helper::Insert_Generator($_POST, 'bnm_factor');
                                                    $result = Db::secure_insert_array($sql, $_POST);
                                                }
                                            } else {
                                                die(Helper::Custom_Msg(Helper::Messages('baso'), 3));
                                            }
                                        }
                                    }
                                } else {
                                    if (!$res) {
                                        //moshtarak jadid ast
                                        if ($res_services[0]['noe_forosh'] === 'adi' || $res_services[0]['noe_forosh'] === 'jashnvare') {
                                            $sql = Helper::Insert_Generator($_POST, 'bnm_factor');
                                            $result = Db::secure_insert_array($sql, $_POST);
                                        } elseif ($res_services[0]['noe_forosh'] === 'bulk') {
                                            die(Helper::Custom_Msg(Helper::Messages('ffcbb'), 3));
                                        } else {
                                            die(Helper::Json_Message('f'));
                                        }
                                    } else {
                                        //ghablan ro in shomare service kharide
                                        $sql = "SELECT
                                                    id,
                                                    IF({$_POST['emkanat_id']} = 1, telephone1,
                                                    IF({$_POST['emkanat_id']} = 2, telephone2,
                                                    IF({$_POST['emkanat_id']} = 3, telephone3, null))) telephone
                                                    FROM bnm_subscribers
                                                    WHERE id = ?
                                                ";
                                        $res_telephone = Db::secure_fetchall($sql, array($res_subscriber[0]['id']));
                                        if ($res_telephone) {
                                            if (isset($res_telephone)) {
                                                $res = $GLOBALS['ibs_voip']->getUserInfoByViopUserName($res_telephone[0]['telephone']);
                                                if (Helper::ibsCheckUserinfoExist($res)) {
                                                    //dar ibs vojod darad
                                                    $unixtime = strtotime($res[1][key($res[1])]['attrs']['abs_exp_date']);
                                                    $exp_date = date("Y-m-d", $unixtime);
                                                    $today_date = Helper::Today_Miladi_Date();
                                                    if ($exp_date <= $today_date) {
                                                        //expire shode pas 1/3 credit ro behesh midim
                                                        $_POST['etebare_baghimande'] = floatval($res[1][key($res[1])]['basic_info']['credit']);
                                                        $_POST['etebare_ghabele_enteghal'] = floatval($_POST['etebare_baghimande'] / 3);
                                                        $sql = Helper::Insert_Generator($_POST, 'bnm_factor');
                                                        $result = Db::secure_insert_array($sql, $_POST);
                                                    } else {
                                                        //expire nashode pas kole credit ro behesh midim
                                                        $_POST['etebare_baghimande'] = floatval($res[1][key($res[1])]['basic_info']['credit']);
                                                        $_POST['etebare_ghabele_enteghal'] = floatval($res[1][key($res[1])]['basic_info']['credit']);
                                                        $sql = Helper::Insert_Generator($_POST, 'bnm_factor');
                                                        $result = Db::secure_insert_array($sql, $_POST);
                                                    }
                                                } else {
                                                    //moshtarak factor darad vali dar ibs nist !!!!!
                                                    $_POST['etebare_baghimande'] = 0;
                                                    $_POST['etebare_ghabele_enteghal'] = 0;
                                                    $sql = Helper::Insert_Generator($_POST, 'bnm_factor');
                                                    $result = Db::secure_insert_array($sql, $_POST);
                                                }
                                            } else {
                                                die(Helper::Json_Message('f'));
                                            }
                                        } else {
                                            die(Helper::Json_Message('f'));
                                        }
                                    }
                                }
                                if ($result) {
                                    $id = (int) $result;
                                    $arr = array();
                                    $arr['shomare_factor'] = $id + 1000;
                                    $arr['id'] = $id;
                                    $sql3 = Helper::Update_Generator($arr, 'bnm_factor', "WHERE id = :id");
                                    $res3 = Db::secure_update_array($sql3, $arr);
                                    /////////////////////////send sms///////////////////////////
                                    $res_factor = Helper::Select_By_Id('bnm_factor', $id);
                                    $res_sub = Helper::Select_By_Id('bnm_subscribers', $res_factor[0]['subscriber_id']);
                                    $msg = 'شناسه فاکتور: ' . $result;
                                    if ($res_sub) {
                                        if ($res_sub[0]['branch_id'] === 0) {
                                            ////user sahar
                                            $res_internal = Helper::Internal_Message_By_Karbord($internal_message_karbord . 's', '1');
                                            if ($res_internal) {
                                                $sql = Helper::Insert_Generator(
                                                    array(
                                                        'message' => $res_internal[0]['message'],
                                                        'type' => 2,
                                                        'message_subject' => $res_internal[0]['karbord'],
                                                    ),
                                                    'bnm_messages'
                                                );
                                                $res_message = Db::secure_insert_array($sql, array(
                                                    'message' => $res_internal[0]['message'],
                                                    'type' => 2,
                                                    'message_subject' => $res_internal[0]['karbord'],
                                                ));
                                                $res_sms_request = Helper::Write_In_Sms_Request(
                                                    $res_sub[0]['telephone_hamrah'],
                                                    Helper::Today_Miladi_Date(),
                                                    Helper::Today_Miladi_Date(),
                                                    1,
                                                    $res_message
                                                );
                                                if ($res_sms_request) {
                                                    $arr = array();
                                                    $arr['receiver'] = $res_sub[0]['telephone_hamrah'];
                                                    $arr['sender'] = __SMSNUMBER__;
                                                    $arr['request_id'] = $res_sms_request;
                                                    $res = Helper::Write_In_Sms_Queue($arr);
                                                }
                                                die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . $msg, 1));
                                            } else {
                                                die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns')));
                                            }
                                        } elseif (isset($res_sub[0]['branch_id'])) {
                                            //user namayande
                                            $res_internal = Helper::Internal_Message_By_Karbord($internal_message_karbord . 'n', '1');
                                            if ($res_internal) {
                                                $sql = Helper::Insert_Generator(
                                                    array(
                                                        'message' => $res_internal[0]['message'],
                                                        'type' => 2,
                                                        'message_subject' => $res_internal[0]['karbord'],
                                                    ),
                                                    'bnm_messages'
                                                );
                                                $res_message = Db::secure_insert_array($sql, array(
                                                    'message' => $res_internal[0]['message'],
                                                    'type' => 2,
                                                    'message_subject' => $res_internal[0]['karbord'],
                                                ));
                                                $res_sms_request = Helper::Write_In_Sms_Request(
                                                    $res_sub[0]['telephone_hamrah'],
                                                    Helper::Today_Miladi_Date(),
                                                    Helper::Today_Miladi_Date(),
                                                    1,
                                                    $res_message
                                                );
                                                if ($res_sms_request) {
                                                    $arr = array();
                                                    $arr['receiver'] = $res_sub[0]['telephone_hamrah'];
                                                    $arr['sender'] = __SMSNUMBER__;
                                                    $arr['request_id'] = $res_sms_request;
                                                    $res = Helper::Write_In_Sms_Queue($arr);
                                                }

                                                die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . $msg, 1));
                                            } else {
                                                die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . Helper::Messages('sns')));
                                            }
                                        }
                                    } else {
                                        die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . $msg, 1));
                                    }
                                    die(Helper::Custom_Msg(Helper::Messages('s') . ' ' . $msg, 1));
                                } else {
                                    ////age be har dalili natonestim factor sabt konim
                                    die(Helper::Json_Message('f'));
                                }
                            } else {
                                ////age etelaate karbar naghes bod
                                die(Helper::Json_Message('sinr'));
                            }
                        } else {
                            die(Helper::Json_Message('subscriber_info_not_found'));
                        }
                    } else {
                        die(Helper::Json_Message('service_info_not_found'));
                    }
                } else {
                    die(Helper::Json_Message('af'));
                }
            } catch (Throwable $e) {
                Helper::Exc_Error_Debug($e, true);
                die();
            }
        }

        if (isset($_POST['send_ft_pardakht'])) {
            $_POST = Helper::Create_Post_Array_Without_Key($_POST);
            $_POST = Helper::xss_check_array($_POST);
            if (Helper::Login_Just_Check()) {
                /////////////fetch data operations
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                        if (isset($_POST['factor_id'])) {
                            $sql_factor = "SELECT
                                fa.id,fa.emkanat_id,fa.subscriber_id,fa.service_id,
                                fa.mablaghe_ghabele_pardakht,fa.maliate_arzeshe_afzode,fa.darsade_avareze_arzeshe_afzode,
                                fa.status,fa.tasvie_shode,fa.hazine_nasb,fa.hazine_dranzhe,fa.hazine_ranzhe,
                                fa.takhfif,fa.etebare_baghimande,fa.etebare_ghabele_enteghal,fa.zaname_estefade,fa.zaname_estefade_be_tarikh,fa.gheymate_service,
                                fa.tarikhe_payane_service,fa.tarikhe_shoroe_service,fa.zamane_estefade,fa.tarikhe_factor,fa.abonmane_port,fa.abonmane_faza,fa.abonmane_tajhizat,ser.type,
                                ser.noe_forosh,ser.noe_khadamat,ser.terafik,sub.branch_id,sub.code_meli ,sub.noe_moshtarak,ct.name city_name,os.name ostan_name
                            FROM bnm_factor fa
                                INNER JOIN bnm_services ser ON ser.id = fa.service_id
                                INNER JOIN bnm_subscribers sub ON sub.id = fa.subscriber_id
                                INNER JOIN bnm_shahr ct ON sub.shahre_tavalod = ct.id
                                INNER JOIN bnm_ostan os ON ct.ostan_id = os.id
                            WHERE fa.id = ? AND DATE( fa.tarikhe_factor )= CURDATE() AND fa.tasvie_shode <> '1' ";
                            $res_factor = Db::secure_fetchall($sql_factor, array($_POST['factor_id']));
                        } else {
                            die(Helper::Json_Message('required_info_not_found'));
                        }
                        break;
                    case __MODIR2USERTYPE__:
                    case __MODIRUSERTYPE__:
                    case __OPERATOR2USERTYPE__:
                    case __OPERATORUSERTYPE__:
                        if (isset($_POST['factor_id'])) {
                            $sql_factor = "SELECT
                                fa.id,fa.emkanat_id,fa.subscriber_id,fa.service_id,
                                fa.mablaghe_ghabele_pardakht,fa.maliate_arzeshe_afzode,fa.darsade_avareze_arzeshe_afzode,
                                fa.status,fa.tasvie_shode,fa.hazine_nasb,fa.hazine_dranzhe,fa.hazine_ranzhe,
                                fa.takhfif,fa.etebare_baghimande,fa.etebare_ghabele_enteghal,fa.zaname_estefade,fa.zaname_estefade_be_tarikh,fa.gheymate_service,
                                fa.tarikhe_payane_service,fa.tarikhe_shoroe_service,fa.zamane_estefade,fa.tarikhe_factor,fa.abonmane_port,fa.abonmane_faza,fa.abonmane_tajhizat,ser.type,
                                ser.noe_forosh,ser.noe_khadamat,ser.terafik,sub.branch_id,sub.code_meli ,sub.noe_moshtarak,ct.name city_name,os.name ostan_name
                            FROM bnm_factor fa
                                INNER JOIN bnm_services ser ON ser.id = fa.service_id
                                INNER JOIN bnm_subscribers sub ON sub.id = fa.subscriber_id
                                INNER JOIN bnm_shahr ct ON sub.shahre_tavalod = ct.id
                                INNER JOIN bnm_ostan os ON ct.ostan_id = os.id
                            WHERE fa.id = ? AND DATE( fa.tarikhe_factor )= CURDATE() AND fa.tasvie_shode <> '1' AND sub.branch_id = ?";
                            $res_factor = Db::secure_fetchall($sql_factor, array($_POST['factor_id'], $_SESSION['branch_id']));
                        } else {
                            die(Helper::Json_Message('required_info_not_found'));
                        }
                        break;
                    case __MOSHTARAKUSERTYPE__:
                        $sql_factor = "SELECT
                            fa.id,fa.emkanat_id,fa.subscriber_id,fa.service_id,
                            fa.mablaghe_ghabele_pardakht,fa.maliate_arzeshe_afzode,fa.darsade_avareze_arzeshe_afzode,
                            fa.status,fa.tasvie_shode,fa.hazine_nasb,fa.hazine_dranzhe,fa.hazine_ranzhe,
                            fa.takhfif,fa.etebare_baghimande,fa.etebare_ghabele_enteghal,fa.zaname_estefade,fa.zaname_estefade_be_tarikh,fa.gheymate_service,
                            fa.tarikhe_payane_service,fa.tarikhe_shoroe_service,fa.zamane_estefade,fa.tarikhe_factor,fa.abonmane_port,fa.abonmane_faza,fa.abonmane_tajhizat,ser.type,
                            ser.noe_forosh,ser.noe_khadamat,ser.terafik,sub.branch_id,sub.code_meli ,sub.noe_moshtarak,ct.name city_name,os.name ostan_name
                        FROM bnm_factor fa
                            INNER JOIN bnm_services ser ON ser.id = fa.service_id
                            INNER JOIN bnm_subscribers sub ON sub.id = fa.subscriber_id
                            INNER JOIN bnm_shahr ct ON sub.shahre_tavalod = ct.id
                            INNER JOIN bnm_ostan os ON ct.ostan_id = os.id
                        WHERE fa.id = ? AND DATE( fa.tarikhe_factor )= CURDATE() AND fa.tasvie_shode <> '1' AND sub.branch_id = ? AND sub.id = ?";
                        $res_factor = Db::secure_fetchall($sql_factor, array($_POST['factor_id'], $_SESSION['branch_id'], $_SESSION['user_id']));
                        break;
                    default:
                        die(Helper::Json_Message('fa'));
                        break;
                }
                //////////////check queries
                if ($res_factor) {
                    $sql_service = "SELECT * FROM bnm_services WHERE id = ?";
                    $res_service = Db::secure_fetchall($sql_service, array($res_factor[0]['service_id']));
                    $sql_subscriber = "SELECT * FROM bnm_subscribers WHERE id =?";
                    $res_subscriber = Db::secure_fetchall($sql_subscriber, array($res_factor[0]['subscriber_id']));
                    if ($res_subscriber) {
                        if ($res_subscriber[0]['branch_id'] !== 0) {
                            $sql_noe_hamkari = "SELECT * FROM bnm_branch_cooperation_type WHERE branch_id=? AND service_type=? ORDER BY id DESC LIMIT 1";
                            $res_noe_hamkari = Db::secure_fetchall($sql_noe_hamkari, array($res_subscriber[0]['branch_id'], $res_service[0]['noe_khadamat']));
                            $sql_branch = "SELECT * FROM bnm_branch WHERE id =?";
                            $res_branch = Db::secure_fetchall($sql_branch, array($res_subscriber[0]['branch_id'], 2));
                        }
                    } else {
                        die(Helper::Json_Message('subscriber_not_found'));
                    }
                } else {

                    die(Helper::Json_Message('factor_not_found'));
                }
                $res_factor_noe_kharid  = Helper::checkNormalPreviousFactorExist($res_subscriber[0]['id'], $res_factor[0]['emkanat_id'], $res_service[0]['type']);
                $sql_credit_branch      = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                $res_credit_branch      = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id'], 2));
                $sql_credit_subscriber  = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                $res_credit_subscriber  = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id'], 1));
                $res_ibsusername        = Helper::getIbsUsername($res_subscriber[0]['id'], $res_service[0]['type'], $res_factor[0]['emkanat_id']);
                if($res_ibsusername){
                    if($res_service[0]['type']!=='voip'){
                        $userunfoinibs=$GLOBALS['ibs_internet']->getUserInfoByNormalUserName($res_ibsusername);
                    }else{
                        $userunfoinibs=$GLOBALS['ibs_voip']->getUserInfoByViopUserName($res_ibsusername);
                    }
                }else{
                    die(Helper::Custom_Msg(Helper::Messages('inf'),2));
                }
                //check ibs & crm info for any conflict
                //check if sub exist in ibs but doesnt exist in crm
                if(Helper::ibsCheckUserinfoExist($userunfoinibs)){
                    if($res_factor_noe_kharid[0]['tedad']===0){
                        die(Helper::Custom_Msg(Helper::Messages('siescne'),2));
                    }
                }
                // $sql="SELECT response FROM shahkar_log WHERE subscriber_id = ? AND requestname = ? ORDER BY date DESC LIMIT 1";
                // $shahkar= Db::secure_fetchall($sql, [$res_subscriber[0]['id'],"estAuthsub"]);
                // $shahkar=Helper::checkEstAuthSub($res_subscriber[0]['id']);
                // if(! $shahkar){
                //     die(Helper::Json_Message('sap'));
                // }
                $result=[];

















                /////////////credits operations2
                switch ($_POST['noe_pardakht']) {
                    case "pardakht_az_subscriber":
                        if (isset($res_service[0]['noe_forosh'])) {
                            if ($res_subscriber[0]['branch_id'] !== 0) {
                                //user braraye namayande ast
                                if ($res_credit_subscriber) {
                                    //moshtarak hesabe bank darad
                                    if (Helper::checkSubscriberCreditForPay($res_credit_subscriber[0]['credit'], $res_factor[0]['mablaghe_ghabele_pardakht'])) {
                                        if ($res_noe_hamkari) {
                                            //kasre mablaghe factor az moshtarak
                                            $subscriber_credit_array = array();
                                            $subscriber_credit_array['credit'] = $res_credit_subscriber[0]['credit'] - ($res_factor[0]['mablaghe_ghabele_pardakht'] - ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                            $subscriber_credit_array['bedehkar'] = ($res_factor[0]['mablaghe_ghabele_pardakht'] - ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode']));;
                                            $subscriber_credit_array['bestankar'] = 0;
                                            $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                            $subscriber_credit_array['noe_user'] = '1';
                                            $subscriber_credit_array['tozihat'] = 'فاکتور شما توسط نماینده/سروکو در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'] . 'پرداخت شد.';
                                            $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                            $subscriber_credit_array['modifier_id'] = $_SESSION['user_id'];
                                            $sql = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                            $result = Db::secure_insert_array($sql, $subscriber_credit_array);
                                            if ($result) {
                                                $sql_credit_subscriber  = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                $res_credit_subscriber  = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id'], 1));
                                                //kasre mablaghe maliat va arzeshe afzode az moshtarak
                                                $subscriber_credit_array = array();
                                                $subscriber_credit_array['credit'] = $res_credit_subscriber[0]['credit'] - ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode']);
                                                $subscriber_credit_array['bedehkar'] = ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode']);
                                                $subscriber_credit_array['bestankar'] = 0;
                                                $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                $subscriber_credit_array['noe_user'] = '1';
                                                $subscriber_credit_array['tozihat'] = 'کسر مالیات و ارزش افزوده توسط سیستم در تاریخ: ' . Helper::Today_Shamsi_Date('-');
                                                $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                $subscriber_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                $sql = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                $result = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                //get noe_hamkari info for this factor
                                                //mohasebe soode namayande az in forosh
                                                if ($res_noe_hamkari[0]['cooperation_type'] === 1) {
                                                    //namayande->darsadi
                                                    $flag_noe_kharid = "service_jadid";
                                                    if ($res_factor_noe_kharid[0]['tedad'] === 0) {
                                                        $flag_noe_kharid = "service_jadid";
                                                    } else {
                                                        $flag_noe_kharid = "sharje_mojadad";
                                                    }
                                                    $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user=? ORDER BY id DESC LIMIT 1";
                                                    $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id'], 2));
                                                    switch ($res_service[0]['noe_forosh']) {
                                                        case 'adi':
                                                            if ($flag_noe_kharid == "sharje_mojadad") {
                                                                if ($res_credit_branch) {
                                                                    //pardakhte porsante namayande baraye sharje mojadad zamani ke namayande hesabe bank darad
                                                                    $branch_credit_array = array();
                                                                    $branch_credit_array['credit'] = $res_credit_branch[0]['credit']+($res_factor[0]['mablaghe_ghabele_pardakht'] * ($res_noe_hamkari[0]['foroshe_service_sharje_mojadad'] / 100));
                                                                    $branch_credit_array['bestankar'] = ($res_factor[0]['mablaghe_ghabele_pardakht'] * ($res_noe_hamkari[0]['foroshe_service_sharje_mojadad'] / 100));
                                                                    $branch_credit_array['bedehkar'] = 0;
                                                                    $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                    $branch_credit_array['noe_user'] = '2';
                                                                    $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                    $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                    $branch_credit_array['tozihat'] = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                    $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                    $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                                } else {
                                                                    //pardakhte porsante namayande baraye sharje mojadad zamani ke namayande hesabe bank nadarad
                                                                    $branch_credit_array = array();
                                                                    $branch_credit_array['credit'] = ($res_factor[0]['mablaghe_ghabele_pardakht'] * ($res_noe_hamkari[0]['foroshe_service_sharje_mojadad'] / 100));
                                                                    $branch_credit_array['bestankar'] = ($res_factor[0]['mablaghe_ghabele_pardakht'] * ($res_noe_hamkari[0]['foroshe_service_sharje_mojadad'] / 100));
                                                                    $branch_credit_array['bedehkar'] = 0;
                                                                    $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                    $branch_credit_array['noe_user'] = '2';
                                                                    $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                    $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                    $branch_credit_array['tozihat'] = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                    $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                    $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                                }
                                                            } elseif ($flag_noe_kharid == "service_jadid") {

                                                                if ($res_credit_branch) {
                                                                    //pardakhte porsante namayande baraye service jadid zamani ke namayande hesabe bank darad
                                                                    $branch_credit_array = array();
                                                                    $branch_credit_array['credit'] = $res_credit_branch[0]['credit'] + ($res_factor[0]['mablaghe_ghabele_pardakht'] * ($res_noe_hamkari[0]['foroshe_service_jadid'] / 100));
                                                                    $branch_credit_array['bestankar'] = ($res_factor[0]['mablaghe_ghabele_pardakht'] * ($res_noe_hamkari[0]['foroshe_service_jadid'] / 100));
                                                                    $branch_credit_array['bedehkar'] = 0;
                                                                    $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                    $branch_credit_array['noe_user'] = '2';
                                                                    $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                    $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                    $branch_credit_array['tozihat'] = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                    $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                    $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                                } else {
                                                                    //pardakhte porsante namayande baraye service jadid zamani ke namayande hesabe bank nadarad
                                                                    $branch_credit_array = array();
                                                                    $branch_credit_array['credit'] = ($res_factor[0]['mablaghe_ghabele_pardakht'] * ($res_noe_hamkari[0]['foroshe_service_jadid'] / 100));
                                                                    $branch_credit_array['bestankar'] = ($res_factor[0]['mablaghe_ghabele_pardakht'] * ($res_noe_hamkari[0]['foroshe_service_jadid'] / 100));
                                                                    $branch_credit_array['bedehkar'] = 0;
                                                                    $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                    $branch_credit_array['noe_user'] = '2';
                                                                    $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                    $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                    $branch_credit_array['tozihat'] = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                    $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                    $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                                }
                                                            }
                                                            break;
                                                        case 'bulk':
                                                            if ($res_credit_branch) {
                                                                //pardakhte porsante namayande baraye bulk zamani ke namayande hesabe bank darad
                                                                //foroshe_service_bulk
                                                                $branch_credit_array = array();
                                                                $branch_credit_array['credit'] = $res_credit_branch[0]['credit'] + ($res_factor[0]['mablaghe_ghabele_pardakht'] * ($res_noe_hamkari[0]['foroshe_service_bulk'] / 100));
                                                                $branch_credit_array['bestankar'] = ($res_factor[0]['mablaghe_ghabele_pardakht'] * ($res_noe_hamkari[0]['foroshe_service_bulk'] / 100));
                                                                $branch_credit_array['bedehkar'] = 0;
                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                $branch_credit_array['noe_user'] = '2';
                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                $branch_credit_array['tozihat'] = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                            } else {
                                                                //pardakhte porsante namayande baraye bulk zamani ke namayande hesabe bank nadarad
                                                                $branch_credit_array = array();
                                                                $branch_credit_array['credit'] = ($res_factor[0]['mablaghe_ghabele_pardakht'] * ($res_noe_hamkari[0]['foroshe_service_bulk'] / 100));
                                                                $branch_credit_array['bestankar'] = ($res_factor[0]['mablaghe_ghabele_pardakht'] * ($res_noe_hamkari[0]['foroshe_service_bulk'] / 100));
                                                                $branch_credit_array['bedehkar'] = 0;
                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                $branch_credit_array['noe_user'] = '2';
                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                $branch_credit_array['tozihat'] = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                            }
                                                            break;
                                                        case 'jashnvare':
                                                            if ($res_credit_branch) {
                                                                //pardakhte porsante namayande baraye jashnvare zamani ke namayande hesabe bank darad
                                                                //foroshe_service_jashnvare
                                                                $branch_credit_array = array();
                                                                $branch_credit_array['credit'] = $res_credit_branch[0]['credit'] + ($res_factor[0]['mablaghe_ghabele_pardakht'] * ($res_noe_hamkari[0]['foroshe_service_jashnvare'] / 100));
                                                                $branch_credit_array['bestankar'] = ($res_factor[0]['mablaghe_ghabele_pardakht'] * ($res_noe_hamkari[0]['foroshe_service_jashnvare'] / 100));
                                                                $branch_credit_array['bedehkar'] = 0;
                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                $branch_credit_array['noe_user'] = '2';
                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                $branch_credit_array['tozihat'] = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                            } else {
                                                                //pardakhte porsante namayande baraye jashnvare zamani ke namayande hesabe bank nadarad
                                                                $branch_credit_array = array();
                                                                $branch_credit_array['credit'] = ($res_factor[0]['mablaghe_ghabele_pardakht'] * ($res_noe_hamkari[0]['foroshe_service_jashnvare'] / 100));
                                                                $branch_credit_array['bestankar'] = ($res_factor[0]['mablaghe_ghabele_pardakht'] * ($res_noe_hamkari[0]['foroshe_service_jashnvare'] / 100));
                                                                $branch_credit_array['bedehkar'] = 0;
                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                $branch_credit_array['noe_user'] = '2';
                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                $branch_credit_array['tozihat'] = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                            }

                                                            break;

                                                        default:
                                                            die(Helper::Json_Message('service_info_not_right'));
                                                            break;
                                                    }
                                                } elseif ($res_noe_hamkari[0]['cooperation_type'] === 2) {
                                                    // license
                                                    $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user=? ORDER BY id DESC LIMIT 1";
                                                    $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id'], 2));
                                                    if ($res_credit_branch) {
                                                        //pardakhte porsante(lisence) namayande zamani ke namayande hesabe bank darad
                                                        //insert credit + mablaghe_ghabele_pardakht
                                                        $branch_credit_array                        = array();
                                                        $branch_credit_array['credit']              = $res_credit_branch[0]['credit'] + $res_factor[0]['mablaghe_ghabele_pardakht'];
                                                        $branch_credit_array['bestankar']           = $res_factor[0]['mablaghe_ghabele_pardakht'];
                                                        $branch_credit_array['bedehkar']            = 0;
                                                        $branch_credit_array['user_or_branch_id']   = $res_subscriber[0]['branch_id'];
                                                        $branch_credit_array['noe_user']            = '2';
                                                        $branch_credit_array['modifier_username']   = $_SESSION['username'];
                                                        $branch_credit_array['modifier_id']         = $_SESSION['user_id'];
                                                        $branch_credit_array['tozihat']             = 'پرداخت مبلغ فاکتور برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                        $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                        $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                        //insert credit - maliat /update tozihat
                                                        $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                        $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id'], 2));
                                                        $branch_credit_array = array();
                                                        $branch_credit_array['credit'] = $res_credit_branch[0]['credit'] - ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode']); //-maliat
                                                        $branch_credit_array['bestankar'] = 0;
                                                        $branch_credit_array['bedehkar'] = ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode']); //-maliat
                                                        $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                        $branch_credit_array['noe_user'] = '2';
                                                        $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                        $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                        $branch_credit_array['tozihat'] = 'کسر مالیات برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                        $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                        $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                        //insert credit - darsade hazine_sazmane_tanzim /update tozihat
                                                        $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                        $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id'], 2));
                                                        $branch_credit_array = array();
                                                        $branch_credit_array['credit'] = $res_credit_branch[0]['credit'] - (($res_factor[0]['mablaghe_ghabele_pardakht'] - ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode'])) * ($res_noe_hamkari[0]['hazine_sazmane_tanzim'] / 100));
                                                        $branch_credit_array['bestankar'] = 0;
                                                        $branch_credit_array['bedehkar'] = ($res_factor[0]['mablaghe_ghabele_pardakht'] - ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode'])) * ($res_noe_hamkari[0]['hazine_sazmane_tanzim'] / 100);
                                                        $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                        $branch_credit_array['noe_user'] = '2';
                                                        $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                        $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                        $branch_credit_array['tozihat'] = 'کسر هزینه سازمان تنظیم برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                        $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                        $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                        //insert credit - darsade hazine_servco /update tozihat
                                                        $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                        $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id'], 2));
                                                        $branch_credit_array = array();
                                                        $branch_credit_array['credit'] = $res_credit_branch[0]['credit'] - (($res_factor[0]['mablaghe_ghabele_pardakht'] - ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode'])) * ($res_noe_hamkari[0]['hazine_servco'] / 100));
                                                        $branch_credit_array['bestankar'] = 0;
                                                        $branch_credit_array['bedehkar'] = ($res_factor[0]['mablaghe_ghabele_pardakht'] - ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode'])) * ($res_noe_hamkari[0]['hazine_servco'] / 100);
                                                        $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                        $branch_credit_array['noe_user'] = '2';
                                                        $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                        $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                        $branch_credit_array['tozihat'] = 'کسر هزینه سروکو برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                        $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                        $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                        //insert credit - darsade hazine_mansobe /update tozihat
                                                        $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                        $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id'], 2));
                                                        $branch_credit_array = array();
                                                        $branch_credit_array['credit'] = $res_credit_branch[0]['credit'] - $res_noe_hamkari[0]['hazine_mansobe'];
                                                        $branch_credit_array['bestankar'] = 0;
                                                        $branch_credit_array['bedehkar'] = $res_noe_hamkari[0]['hazine_mansobe'];
                                                        $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                        $branch_credit_array['noe_user'] = '2';
                                                        $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                        $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                        $branch_credit_array['tozihat'] = 'کسر هزینه منصوبه برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                        $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                        $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                        // Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                                                        // die(Helper::Json_Message('pardakht_success'));
                                                    } else {
                                                        //pardakhte porsante(lisence) namayande zamani ke namayande hesabe bank nadarad
                                                        //NO credit Account
                                                        //insert credit + mablaghe_ghabele_pardakht
                                                        $branch_credit_array = array();
                                                        $branch_credit_array['credit'] = $res_factor[0]['mablaghe_ghabele_pardakht'];
                                                        $branch_credit_array['bestankar'] = $res_factor[0]['mablaghe_ghabele_pardakht'];
                                                        $branch_credit_array['bedehkar'] = 0;
                                                        $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                        $branch_credit_array['noe_user'] = '2';
                                                        $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                        $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                        $branch_credit_array['tozihat'] = 'پرداخت مبلغ فاکتور برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                        $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                        $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                        //insert credit - maliat /update tozihat
                                                        $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                        $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id'], 2));
                                                        $branch_credit_array = array();
                                                        $branch_credit_array['credit'] = $res_credit_branch[0]['credit'] - ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode']); //-maliat
                                                        $branch_credit_array['bestankar'] = 0;
                                                        $branch_credit_array['bedehkar'] = ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode']); //-maliat
                                                        $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                        $branch_credit_array['noe_user'] = '2';
                                                        $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                        $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                        $branch_credit_array['tozihat'] = 'کسر مالیات برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                        $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                        $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                        //insert credit - darsade hazine_sazmane_tanzim /update tozihat
                                                        $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                        $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id'], 2));
                                                        $branch_credit_array = array();
                                                        $branch_credit_array['credit'] = $res_credit_branch[0]['credit'] - (($res_factor[0]['mablaghe_ghabele_pardakht'] - ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode'])) * (floatval($res_noe_hamkari[0]['hazine_sazmane_tanzim']) / 100));
                                                        $branch_credit_array['bestankar'] = 0;
                                                        $branch_credit_array['bedehkar'] = ($res_factor[0]['mablaghe_ghabele_pardakht'] - ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode'])) * (floatval($res_noe_hamkari[0]['hazine_sazmane_tanzim']) / 100);
                                                        $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                        $branch_credit_array['noe_user'] = '2';
                                                        $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                        $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                        $branch_credit_array['tozihat'] = 'کسر هزینه سازمان تنظیم برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                        $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                        $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                        //insert credit - darsade hazine_servco /update tozihat
                                                        $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                        $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id'], 2));
                                                        $branch_credit_array = array();
                                                        $branch_credit_array['credit'] = $res_credit_branch[0]['credit'] - (($res_factor[0]['mablaghe_ghabele_pardakht'] - ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode'])) * (floatval($res_noe_hamkari[0]['hazine_servco']) / 100));
                                                        $branch_credit_array['bestankar'] = 0;
                                                        $branch_credit_array['bedehkar'] = ($res_factor[0]['mablaghe_ghabele_pardakht'] - ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode'])) * (floatval($res_noe_hamkari[0]['hazine_servco']) / 100);
                                                        $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                        $branch_credit_array['noe_user'] = '2';
                                                        $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                        $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                        $branch_credit_array['tozihat'] = 'کسر هزینه سروکو برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                        $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                        $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                        //insert credit - darsade hazine_mansobe /update tozihat
                                                        $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                        $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id'], 2));
                                                        $branch_credit_array = array();
                                                        $branch_credit_array['credit'] = $res_credit_branch[0]['credit'] - $res_noe_hamkari[0]['hazine_mansobe'];
                                                        $branch_credit_array['bestankar'] = 0;
                                                        $branch_credit_array['bedehkar'] = $res_noe_hamkari[0]['hazine_mansobe'];
                                                        $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                        $branch_credit_array['noe_user'] = '2';
                                                        $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                        $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                        $branch_credit_array['tozihat'] = 'کسر هزینه منصوبه برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                        $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                        $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                        // Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                                                        // die(Helper::Json_Message('pardakht_success'));
                                                    }
                                                    /////todo... check if service type is bitstream
                                                } else {
                                                    die(Helper::Json_Message('bcinf'));
                                                }
                                            } else {
                                                die(Helper::Json_Message('bcinf'));
                                            }
                                        } else {
                                            die(Helper::Json_Message('bcinf'));
                                        }
                                    } else {
                                        die(Helper::Json_Message('subscriber_credit_not_enough'));
                                    }
                                } else {
                                    die(Helper::Json_Message('subscriber_credit_info_not_found'));
                                }
                            } elseif ($res_subscriber[0]['branch_id'] === 0) {
                                //user sahar
                                if ($res_credit_subscriber) {
                                    if (Helper::checkSubscriberCreditForPay($res_credit_subscriber[0]['credit'], $res_factor[0]['mablaghe_ghabele_pardakht'])){
                                        //kasre mablaghe factor az moshtarak
                                        $subscriber_credit_array = array();
                                        // $subscriber_credit_array['change_amount']  = $res_credit_subscriber[0]['credit'] - ($res_factor[0]['mablaghe_ghabele_pardakht'] - ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                        $subscriber_credit_array['credit'] = $res_credit_subscriber[0]['credit'] - ($res_factor[0]['mablaghe_ghabele_pardakht'] - ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                        $subscriber_credit_array['bedehkar'] = ($res_factor[0]['mablaghe_ghabele_pardakht'] - ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                        $subscriber_credit_array['bestankar'] = 0;
                                        $subscriber_credit_array['user_or_branch_id'] = $res_factor[0]['subscriber_id'];
                                        $subscriber_credit_array['noe_user'] = '1';
                                        $subscriber_credit_array['tozihat'] = 'فاکتور شما توسط نماینده/شرکت در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                        $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                        $subscriber_credit_array['modifier_id'] = $_SESSION['user_id'];
                                        $sql = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                        $result = Db::secure_insert_array($sql, $subscriber_credit_array);
                                        if ($result) {
                                            $sql_credit_subscriber = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                            $res_credit_subscriber = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id'], 1));
                                            $subscriber_credit_array = array();
                                            $subscriber_credit_array['credit'] = $res_credit_subscriber[0]['credit'] - ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode']);
                                            $subscriber_credit_array['bedehkar'] = $res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode'];
                                            $subscriber_credit_array['bestankar'] = 0;
                                            $subscriber_credit_array['user_or_branch_id'] = $res_factor[0]['subscriber_id'];
                                            $subscriber_credit_array['noe_user'] = '1';
                                            $subscriber_credit_array['tozihat'] = 'کسر مالیات و ارزش افزوده توسط سیستم در تاریخ: ' . Helper::Today_Shamsi_Date('-');
                                            $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                            $subscriber_credit_array['modifier_id'] = $_SESSION['user_id'];
                                            $sql = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                            $result = Db::secure_insert_array($sql, $subscriber_credit_array);

                                        } else {
                                            die(Helper::Json_Message('credit_operation_fail'));
                                        }
                                    } else {
                                        die(Helper::Json_Message('subscriber_credit_not_enough'));
                                    }
                                } else {
                                    die(Helper::Json_Message('subscriber_info_not_right'));
                                }
                            } else {
                                die(Helper::Json_Message('subscriber_info_not_right'));
                            }
                        } else {
                            die(Helper::Json_Message('service_info_not_right'));
                        }
                        Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                        break;
                    case "pardakht_az_namayande":
                        if (isset($res_service[0]['noe_forosh'])) {
                            if ($res_subscriber[0]['branch_id'] !== 0) {
                                //moshtarak baraye namayande ast
                                switch ($_SESSION['user_type']) {
                                    case __ADMINUSERTYPE__:
                                    case __ADMINOPERATORUSERTYPE__:
                                    case __MODIRUSERTYPE__:
                                    case __MODIR2USERTYPE__:
                                    case __OPERATORUSERTYPE__:
                                    case __OPERATOR2USERTYPE__:
                                            if ($res_credit_branch) {
                                                // if ($res_credit_branch[0]['credit'] >= ($res_factor[0]['mablaghe_ghabele_pardakht'] + ($res_factor[0]['mablaghe_ghabele_pardakht'] * __BRANCHESACCEPTABLEBALANCEFORPAY__))) {
                                                if (Helper::checkbranchCreditForpay($res_credit_branch[0]['credit'], $res_factor[0]['mablaghe_ghabele_pardakht'],__BRANCHESACCEPTABLEBALANCEFORPAY__ )) {
                                                    //namayande credite kafi darad
                                                    if ($res_noe_hamkari) {
                                                        //etelaate noe hamkarie namayande mojod ast
                                                        if (isset($res_noe_hamkari[0]['cooperation_type']) && isset($res_noe_hamkari[0]['service_type']) && isset($res_noe_hamkari[0]['foroshe_service_jadid']) && isset($res_noe_hamkari[0]['foroshe_service_sharje_mojadad']) && isset($res_noe_hamkari[0]['foroshe_service_jashnvare']) && isset($res_noe_hamkari[0]['hazine_sazmane_tanzim']) && isset($res_noe_hamkari[0]['hazine_servco']) && isset($res_noe_hamkari[0]['hazine_mansobe'])) {
                                                            if ($res_noe_hamkari[0]['cooperation_type'] === 1) {
                                                                //pardakht az namayande->darsadi
                                                                //all branch info exists so we can continue
                                                                //pardakhte az hesabe namayande kole mablaghe ghabele pardakht
                                                                $branch_credit_array = array();
                                                                $branch_credit_array['credit'] = $res_credit_branch[0]['credit'] - ($res_factor[0]['mablaghe_ghabele_pardakht'] - ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                $branch_credit_array['bestankar'] = 0;
                                                                $branch_credit_array['bedehkar'] = ($res_factor[0]['mablaghe_ghabele_pardakht'] - ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                $branch_credit_array['noe_user'] = '2';
                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                $branch_credit_array['tozihat'] = 'پرداخت مبلغ فاکتور توسط نماینده/شرکت برای شماره : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                                //kasre maliat az hesabe namayande
                                                                $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                                $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id'], 2));
                                                                $branch_credit_array = array();
                                                                $branch_credit_array['credit'] = $res_credit_branch[0]['credit'] - ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode']);
                                                                $branch_credit_array['bestankar'] = 0;
                                                                $branch_credit_array['bedehkar'] = ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode']);
                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                $branch_credit_array['noe_user'] = '2';
                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                $branch_credit_array['tozihat'] = 'کسر مالیات توسط سیستم برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                                if ($res_credit_subscriber) {
                                                                    // user has an account already
                                                                    //add mablaghe kol to user credit
                                                                    $subscriber_credit_array = array();
                                                                    $subscriber_credit_array['credit'] = $res_credit_subscriber[0]['credit'] + $res_factor[0]['mablaghe_ghabele_pardakht'];
                                                                    $subscriber_credit_array['bedehkar'] = 0;
                                                                    $subscriber_credit_array['bestankar'] = $res_factor[0]['mablaghe_ghabele_pardakht'];
                                                                    $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                                    $subscriber_credit_array['noe_user'] = '1';
                                                                    $subscriber_credit_array['tozihat'] = 'بدهکاری مشترک به نماینده در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                    $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                    $subscriber_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                    $sql = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                    $result = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                    //kasre asle mablaghe kol az moshtarak
                                                                    $sql_credit_subscriber = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                                    $res_credit_subscriber = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id'], 1));
                                                                    $subscriber_credit_array = array();
                                                                    $subscriber_credit_array['credit'] = $res_credit_subscriber[0]['credit'] - ($res_factor[0]['mablaghe_ghabele_pardakht'] - ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                    $subscriber_credit_array['bedehkar'] = $res_factor[0]['mablaghe_ghabele_pardakht'] - ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode']);
                                                                    $subscriber_credit_array['bestankar'] = 0;
                                                                    $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                                    $subscriber_credit_array['noe_user'] = '1';
                                                                    $subscriber_credit_array['tozihat'] = 'کسر اصل مبلغ فاکتور توسط سیستم در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                    $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                    $subscriber_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                    $sql = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                    $result = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                    //kasre credit - maliat+arzeshe afzoode az moshtarak
                                                                    $sql_credit_subscriber = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                                    $res_credit_subscriber = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id'], 1));
                                                                    $subscriber_credit_array = array();
                                                                    $subscriber_credit_array['credit'] = $res_credit_subscriber[0]['credit'] - ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode']);
                                                                    $subscriber_credit_array['bedehkar'] = ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode']);
                                                                    $subscriber_credit_array['bestankar'] = 0;
                                                                    $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                                    $subscriber_credit_array['noe_user'] = '1';
                                                                    $subscriber_credit_array['tozihat'] = 'کسر مالیات و ارزش افزوده توسط نماینده/شرکت در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                    $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                    $subscriber_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                    $sql = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                    $result = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                } else {
                                                                    //create user account
                                                                    //add mablaghe kol to user credit
                                                                    $subscriber_credit_array = array();
                                                                    $subscriber_credit_array['credit'] = $res_factor[0]['mablaghe_ghabele_pardakht'];
                                                                    $subscriber_credit_array['bedehkar'] = 0;
                                                                    $subscriber_credit_array['bestankar'] = $res_factor[0]['mablaghe_ghabele_pardakht'];
                                                                    $subscriber_credit_array['user_or_branch_id'] = $res_subscriber[0]['id'];
                                                                    $subscriber_credit_array['noe_user'] = '1';
                                                                    $subscriber_credit_array['tozihat'] = 'بدهکاری مشترک به نماینده در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                    $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                    $subscriber_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                    $sql = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                    $result = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                    //kasre asle mablaghe kol az moshtarak
                                                                    $sql_credit_subscriber = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                                    $res_credit_subscriber = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id'], 1));
                                                                    $subscriber_credit_array = array();
                                                                    $subscriber_credit_array['credit'] = $res_credit_subscriber[0]['credit'] - ($res_factor[0]['mablaghe_ghabele_pardakht'] - ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                    $subscriber_credit_array['bedehkar'] = $res_factor[0]['mablaghe_ghabele_pardakht'] - ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode']);
                                                                    $subscriber_credit_array['bestankar'] = 0;
                                                                    $subscriber_credit_array['user_or_branch_id'] = $res_subscriber[0]['id'];
                                                                    $subscriber_credit_array['noe_user'] = '1';
                                                                    $subscriber_credit_array['tozihat'] = 'کسر اصل مبلغ فاکتور توسط سیستم در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                    $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                    $subscriber_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                    $sql = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                    $result = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                    // $sql_credit_subscriber = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                                    // $res_credit_subscriber = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id'], 1));
                                                                    //kasre credit - maliat+arzeshe afzoode az moshtarak
                                                                    $sql_credit_subscriber = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                                    $res_credit_subscriber = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id'], 1));
                                                                    $subscriber_credit_array = array();
                                                                    $subscriber_credit_array['credit'] = $res_credit_subscriber[0]['credit'] - ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode']);
                                                                    $subscriber_credit_array['bedehkar'] = ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode']);
                                                                    $subscriber_credit_array['bestankar'] = 0;
                                                                    $subscriber_credit_array['user_or_branch_id'] = $res_subscriber[0]['id'];
                                                                    $subscriber_credit_array['noe_user'] = '1';
                                                                    $subscriber_credit_array['tozihat'] = 'کسر مالیات و ارزش افزوده توسط نماینده/شرکت در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                    $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                    $subscriber_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                    $sql = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                    $result = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                }
                                                                $flag_noe_kharid = "service_jadid";
                                                                if ($res_factor_noe_kharid[0]['tedad'] === 0) {
                                                                    $flag_noe_kharid = "service_jadid";
                                                                } else {
                                                                    $flag_noe_kharid = "sharje_mojadad";
                                                                }

                                                                switch ($res_service[0]['noe_forosh']) {
                                                                    case 'adi':
                                                                        $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                                        $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id'], 2));
                                                                        if ($flag_noe_kharid == "sharje_mojadad") {
                                                                            //pardakhte porsante namayande baraye sharje mojadad zamani ke namayande hesabe bank darad
                                                                            $branch_credit_array = array();
                                                                            $branch_credit_array['credit'] = $res_credit_branch[0]['credit'] + ($res_factor[0]['mablaghe_ghabele_pardakht'] + ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode'])) * ($res_noe_hamkari[0]['foroshe_service_sharje_mojadad'] / 100);
                                                                            $branch_credit_array['bestankar'] = ($res_factor[0]['mablaghe_ghabele_pardakht'] - ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode'])) * ($res_noe_hamkari[0]['foroshe_service_sharje_mojadad'] / 100);
                                                                            $branch_credit_array['bedehkar'] = 0;
                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                            $branch_credit_array['noe_user'] = '2';
                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                            $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                            $branch_credit_array['tozihat'] = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                            $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                            $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                                        } elseif ($flag_noe_kharid == "service_jadid") {
                                                                            //pardakhte porsante namayande baraye service jadid zamani ke namayande hesabe bank darad
                                                                            $branch_credit_array = array();
                                                                            $branch_credit_array['credit'] = $res_credit_branch[0]['credit'] + ($res_factor[0]['mablaghe_ghabele_pardakht'] + ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode'])) * ($res_noe_hamkari[0]['foroshe_service_jadid'] / 100);
                                                                            $branch_credit_array['bestankar'] = ($res_factor[0]['mablaghe_ghabele_pardakht'] - ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode'])) * ($res_noe_hamkari[0]['foroshe_service_jadid'] / 100);
                                                                            $branch_credit_array['bedehkar'] = 0;
                                                                            $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                            $branch_credit_array['noe_user'] = '2';
                                                                            $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                            $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                            $branch_credit_array['tozihat'] = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                            $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                            $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                                        }
                                                                        // Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                                                                        // die(Helper::Json_Message('pardakht_success'));
                                                                        break;
                                                                    case 'bulk':
                                                                        $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                                        $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id'], 2));
                                                                        //pardakhte porsante namayande baraye bulk zamani ke namayande hesabe bank darad
                                                                        $branch_credit_array = array();
                                                                        $branch_credit_array['credit'] = $res_credit_branch[0]['credit'] + ($res_factor[0]['mablaghe_ghabele_pardakht'] - ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode'])) * ($res_noe_hamkari[0]['foroshe_service_bulk'] / 100);
                                                                        $branch_credit_array['bestankar'] = ($res_factor[0]['mablaghe_ghabele_pardakht'] - ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode'])) * ($res_noe_hamkari[0]['foroshe_service_bulk'] / 100);
                                                                        $branch_credit_array['bedehkar'] = 0;
                                                                        $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                        $branch_credit_array['noe_user'] = '2';
                                                                        $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                        $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                        $branch_credit_array['tozihat'] = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                        $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                        $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                                        // Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                                                                        // die(Helper::Json_Message('pardakht_success'));
                                                                        break;
                                                                    case 'jashnvare':
                                                                        $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                                        $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id'], 2));
                                                                        //pardakhte porsante namayande baraye jashnvare zamani ke namayande hesabe bank darad
                                                                        $branch_credit_array = array();
                                                                        $branch_credit_array['credit'] = $res_credit_branch[0]['credit'] + ($res_factor[0]['mablaghe_ghabele_pardakht'] - ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode'])) * ($res_noe_hamkari[0]['foroshe_service_jashnvare'] / 100);
                                                                        $branch_credit_array['bestankar'] = ($res_factor[0]['mablaghe_ghabele_pardakht'] - ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode'])) * ($res_noe_hamkari[0]['foroshe_service_jashnvare'] / 100);
                                                                        $branch_credit_array['bedehkar'] = 0;
                                                                        $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                        $branch_credit_array['noe_user'] = '2';
                                                                        $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                        $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                        $branch_credit_array['tozihat'] = 'پرداخت پورسانت برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                        $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                        $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                                        // Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                                                                        // die(Helper::Json_Message('pardakht_success'));
                                                                        break;
                                                                    default:
                                                                        die(Helper::Json_Message('service_info_not_right'));
                                                                        break;
                                                                }
                                                            } elseif ($res_noe_hamkari[0]['cooperation_type'] === 2) {
                                                                //pardakht az namayande->license
                                                                $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                                $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id'], 2));
                                                                //pardakhte porsante(lisence) namayande zamani ke namayande hesabe bank darad
                                                                //insert credit ghabli
                                                                $branch_credit_array = array();
                                                                $branch_credit_array['credit'] = $res_credit_branch[0]['credit']-($res_factor[0]['mablaghe_ghabele_pardakht'] - ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode']));;
                                                                $branch_credit_array['bestankar'] = 0;
                                                                $branch_credit_array['bedehkar'] = ($res_factor[0]['mablaghe_ghabele_pardakht'] - ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                $branch_credit_array['noe_user'] = '2';
                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                $branch_credit_array['tozihat'] = 'پرداخت مبلغ فاکتور برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                                //insert credit - maliat /update tozihat
                                                                $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                                $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id'], 2));
                                                                $branch_credit_array = array();
                                                                $branch_credit_array['credit'] = $res_credit_branch[0]['credit'] - ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode']); //-maliat
                                                                $branch_credit_array['bestankar'] = 0;
                                                                $branch_credit_array['bedehkar'] = ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode']); //-maliat
                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                $branch_credit_array['noe_user'] = '2';
                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                $branch_credit_array['tozihat'] = 'کسر مالیات برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                                //insert credit - darsade hazine_sazmane_tanzim /update tozihat
                                                                $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                                $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id'], 2));
                                                                $branch_credit_array = array();
                                                                $branch_credit_array['credit'] = $res_credit_branch[0]['credit'] - (($res_factor[0]['mablaghe_ghabele_pardakht'] - ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode'])) * floatval($res_noe_hamkari[0]['hazine_sazmane_tanzim']) / 100); //-hazine_sazmane_tanzim
                                                                $branch_credit_array['bestankar'] = 0;
                                                                $branch_credit_array['bedehkar'] = ($res_factor[0]['mablaghe_ghabele_pardakht'] - ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode'])) * floatval($res_noe_hamkari[0]['hazine_sazmane_tanzim']) / 100;
                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                $branch_credit_array['noe_user'] = '2';
                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                $branch_credit_array['tozihat'] = 'کسر هزینه سازمان تنظیم برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                                //insert credit - darsade hazine_servco /update tozihat
                                                                $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                                $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id'], 2));
                                                                $branch_credit_array = array();
                                                                $branch_credit_array['credit'] = $res_credit_branch[0]['credit'] - (($res_factor[0]['mablaghe_ghabele_pardakht'] - ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode'])) * floatval($res_noe_hamkari[0]['hazine_servco']) / 100); //-hazine_servco
                                                                $branch_credit_array['bestankar'] = 0;
                                                                $branch_credit_array['bedehkar'] = ($res_factor[0]['mablaghe_ghabele_pardakht'] - ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode'])) * floatval($res_noe_hamkari[0]['hazine_servco']) / 100; //-hazine_servco
                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                $branch_credit_array['noe_user'] = '2';
                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                $branch_credit_array['tozihat'] = 'کسر هزینه سروکو برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                                //insert credit - darsade hazine_mansobe /update tozihat
                                                                $sql_credit_branch = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                                $res_credit_branch = Db::secure_fetchall($sql_credit_branch, array($res_subscriber[0]['branch_id'], 2));
                                                                $branch_credit_array = array();
                                                                $branch_credit_array['credit'] = $res_credit_branch[0]['credit'] - $res_noe_hamkari[0]['hazine_mansobe']; //-hazine_mansobe
                                                                $branch_credit_array['bestankar'] = 0;
                                                                $branch_credit_array['bedehkar'] = $res_noe_hamkari[0]['hazine_mansobe'];
                                                                $branch_credit_array['user_or_branch_id'] = $res_subscriber[0]['branch_id'];
                                                                $branch_credit_array['noe_user'] = '2';
                                                                $branch_credit_array['modifier_username'] = $_SESSION['username'];
                                                                $branch_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                $branch_credit_array['tozihat'] = 'کسر هزینه منصوبه برای شماره فاکتور : ' . $res_factor[0]['id'] . ' مورخ : ' . Helper::Today_Shamsi_Date();
                                                                $sql = Helper::Insert_Generator($branch_credit_array, 'bnm_credits');
                                                                $result = Db::secure_insert_array($sql, $branch_credit_array);
                                                                ////////////////////////////subscriber credit //////////////////////////////////////////
                                                                $sql_credit_subscriber = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                                $res_credit_subscriber = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id'], 1));
                                                                if ($res_credit_subscriber) {
                                                                    // user has an account already
                                                                    //add mablaghe kol to user credit
                                                                    $subscriber_credit_array = array();
                                                                    $subscriber_credit_array['credit'] = $res_credit_subscriber[0]['credit'] + $res_factor[0]['mablaghe_ghabele_pardakht'];
                                                                    $subscriber_credit_array['bedehkar'] = 0;
                                                                    $subscriber_credit_array['bestankar'] = $res_factor[0]['mablaghe_ghabele_pardakht'];
                                                                    $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                                    $subscriber_credit_array['noe_user'] = '1';
                                                                    $subscriber_credit_array['tozihat'] = 'بدهکاری مشترک به نماینده در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                    $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                    $subscriber_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                    $sql = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                    $result = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                    //kasre asle mablaghe kol az moshtarak
                                                                    $sql_credit_subscriber = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                                    $res_credit_subscriber = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id'], 1));
                                                                    $subscriber_credit_array = array();
                                                                    $subscriber_credit_array['credit'] = $res_credit_subscriber[0]['credit'] - ($res_factor[0]['mablaghe_ghabele_pardakht'] - ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                    $subscriber_credit_array['bedehkar'] = $res_factor[0]['mablaghe_ghabele_pardakht'] - ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode']);
                                                                    $subscriber_credit_array['bestankar'] = 0;
                                                                    $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                                    $subscriber_credit_array['noe_user'] = '1';
                                                                    $subscriber_credit_array['tozihat'] = 'کسر مالیات توسط سیستم در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                    $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                    $subscriber_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                    $sql = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                    $result = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                    //kasre credit - maliat+arzeshe afzoode az moshtarak
                                                                    $sql_credit_subscriber = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                                    $res_credit_subscriber = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id'], 1));
                                                                    $subscriber_credit_array = array();
                                                                    $subscriber_credit_array['credit'] = $res_credit_subscriber[0]['credit'] - ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode']);
                                                                    $subscriber_credit_array['bedehkar'] = ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode']);
                                                                    $subscriber_credit_array['bestankar'] = 0;
                                                                    $subscriber_credit_array['user_or_branch_id'] = $res_credit_subscriber[0]['user_or_branch_id'];
                                                                    $subscriber_credit_array['noe_user'] = '1';
                                                                    $subscriber_credit_array['tozihat'] = 'کسر مبلغ فاکتور توسط نماینده/شرکت در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                    $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                    $subscriber_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                    $sql = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                    $result = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                } else {
                                                                    //create user account
                                                                    //add mablaghe kol to user credit
                                                                    $subscriber_credit_array = array();
                                                                    $subscriber_credit_array['credit'] = $res_factor[0]['mablaghe_ghabele_pardakht'];
                                                                    $subscriber_credit_array['bedehkar'] = 0;
                                                                    $subscriber_credit_array['bestankar'] = $res_factor[0]['mablaghe_ghabele_pardakht'];
                                                                    $subscriber_credit_array['user_or_branch_id'] = $res_factor[0]['subscriber_id'];
                                                                    $subscriber_credit_array['noe_user'] = '1';
                                                                    $subscriber_credit_array['tozihat'] = 'بدهکاری مشترک به نماینده در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                    $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                    $subscriber_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                    $sql = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                    $result = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                    //kasre asle mablaghe kol az moshtarak
                                                                    $sql_credit_subscriber = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                                    $res_credit_subscriber = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id'], 1));
                                                                    $subscriber_credit_array = array();
                                                                    $subscriber_credit_array['credit'] = $res_credit_subscriber[0]['credit'] - ($res_factor[0]['mablaghe_ghabele_pardakht'] - ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode']));
                                                                    $subscriber_credit_array['bedehkar'] = $res_factor[0]['mablaghe_ghabele_pardakht'] - ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode']);
                                                                    $subscriber_credit_array['bestankar'] = 0;
                                                                    $subscriber_credit_array['user_or_branch_id'] = $res_factor[0]['subscriber_id'];
                                                                    $subscriber_credit_array['noe_user'] = '1';
                                                                    $subscriber_credit_array['tozihat'] = 'کسر مالیات توسط سیستم در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                    $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                    $subscriber_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                    $sql = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                    $result = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                    //kasre credit - maliat+arzeshe afzoode az moshtarak
                                                                    $sql_credit_subscriber = "SELECT * FROM bnm_credits WHERE user_or_branch_id=? AND noe_user= ? ORDER BY id DESC LIMIT 1";
                                                                    $res_credit_subscriber = Db::secure_fetchall($sql_credit_subscriber, array($res_subscriber[0]['id'], 1));
                                                                    $subscriber_credit_array = array();
                                                                    $subscriber_credit_array['credit'] = $res_credit_subscriber[0]['credit'] - ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode']);
                                                                    $subscriber_credit_array['bedehkar'] = ($res_factor[0]['maliate_arzeshe_afzode'] + $res_factor[0]['darsade_avareze_arzeshe_afzode']);
                                                                    $subscriber_credit_array['bestankar'] = 0;
                                                                    $subscriber_credit_array['user_or_branch_id'] = $res_factor[0]['subscriber_id'];
                                                                    $subscriber_credit_array['noe_user'] = '1';
                                                                    $subscriber_credit_array['tozihat'] = 'کسر مبلغ فاکتور توسط نماینده/شرکت در تاریخ : ' . Helper::Today_Shamsi_Date('-') . 'برای شماره فاکتور : ' . $res_factor[0]['id'];
                                                                    $subscriber_credit_array['modifier_username'] = $_SESSION['username'];
                                                                    $subscriber_credit_array['modifier_id'] = $_SESSION['user_id'];
                                                                    $sql = Helper::Insert_Generator($subscriber_credit_array, 'bnm_credits');
                                                                    $result = Db::secure_insert_array($sql, $subscriber_credit_array);
                                                                }
                                                                // Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                                                                // die(Helper::Json_Message('pardakht_success'));
                                                            }
                                                        } else {
                                                            die(Helper::Json_Message('branch_cooperation_info_not_found'));
                                                        }
                                                    } else {
                                                        die(Helper::Json_Message('branch_cooperation_info_not_found'));
                                                    }
                                                } else {
                                                    die(Helper::Json_Message('branch_credit_not_enough'));
                                                }
                                            } else {
                                                die(Helper::Json_Message('branch_credit_account_not_found'));
                                            }
                                        break;
                                    default:
                                        die(Helper::Json_Message('auth_fail'));
                                        break;
                                }
                            } else {
                                die(Helper::Json_Message('auth_fail'));
                            }
                        } else {
                            die(Helper::Json_Message('service_info_not_right'));
                        }
                        Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                        break;
                    case "pardakht_dasti":
                        die(Helper::Json_Message('info_not_true'));
                        break;

                    default:
                        die(Helper::Json_Message('info_not_true'));
                        break;
                }
                /////////////credits operations2///////////
                //////ibs operations/////
                if ($result) {
                    Helper::Set_Factor_Tasvie_Shode($res_factor[0]['id']);
                    if($res_service[0]['type'] === 'bitstream'){
                        //if its bitstream then we update oss_reserves
                        $bsarr=[];
                        $bsarr['ranzhe']=1;
                        $bsarr['id']=$res_factor[0]['emkanat_id'];
                        $bsarr['laghv']=0;
                        $bsarr['jamavari']=0;
                        $sql=Helper::Update_Generator($bsarr, 'bnm_oss_reserves', "WHERE id = :id");
                        $res_bs=Db::secure_update_array($sql, $bsarr);
                    }
                    if ($res_service[0]['type'] !== "voip") {
                        if ($res_service[0]['noe_forosh'] === "adi" || $res_service[0]['noe_forosh'] === "jashnvare") {
                            if ($res_factor_noe_kharid[0]['tedad'] === 0) {
                                //new user
                                $res_addnewuser = $GLOBALS['ibs_internet']->addNewUser(1, $res_service[0]['terafik'], 'Main', $res_service[0]['onvane_service'], $res_subscriber[0]['code_meli']);
                                if (Helper::ibsCheckUserinfoExist($res_addnewuser)) {
                                    if ($res_factor[0]['noe_moshtarak'] === "real") {
                                        $res_setuserattrs = $GLOBALS['ibs_internet']->setUserAttributes(
                                            (string) $res_addnewuser[1][0],
                                            array(
                                                "name" => $res_subscriber[0]['name'] . ' ' . $res_subscriber[0]['f_name'],
                                                "comment" => $res_subscriber[0]['code_meli'],
                                                "phone" => (string) $res_ibsusername[0]['ibsusername'],
                                                "cell_phone" => $res_subscriber[0]['telephone_hamrah'],
                                                "postal_code" => "0", //shahkar_code
                                                "email" => $res_subscriber[0]['shomare_shenasname'] . ',' . $res_factor[0]['city_name'],
                                                "address" => $res_service[0]['type'],
                                                "birthdate" => $res_subscriber[0]['tarikhe_tavalod'],
                                                "birthdate_unit" => 'gregorian',
                                                "abs_exp_date" => $res_factor[0]['tarikhe_payane_service'],
                                                "abs_exp_date_unit" => 'gregorian',
                                                "normal_user_spec" => array(
                                                    "normal_username" => (string) $res_ibsusername[0]['ibsusername'],
                                                    "normal_password" => (string) $res_subscriber[0]['code_meli'],
                                                ),
                                            )
                                        );
                                        switch (strtolower($res_service[0]['type'])) {
                                            case 'bitstream':
                                            case 'adsl':
                                            case 'vdsl':
                                                $cf_sername='ADSL';
                                                $userid=$GLOBALS['ibs_internet']->getUserIdByNormalUsername((string) $res_ibsusername[0]['ibsusername']);
                                                if($userid[0] && isset($cf_sername)){
                                                    $id=$userid[1];
                                                    $res=$GLOBALS['ibs_internet']->setUserCustomField((string) $id, 'service_name', $cf_sername);
                                                }
                                            break;
                                            case 'wireless':
                                                $cf_sername='WIRELESS';
                                                $userid=$GLOBALS['ibs_internet']->getUserIdByNormalUsername((string) $res_ibsusername[0]['ibsusername']);
                                                if($userid[0] && isset($cf_sername)){
                                                    $id=$userid[1];
                                                    $res=$GLOBALS['ibs_internet']->setUserCustomField((string) $id, 'service_name', $cf_sername);
                                                }
                                            break;
                                            case 'tdlte':
                                                $cf_sername='TD_LTE';
                                                $userid=$GLOBALS['ibs_internet']->getUserIdByNormalUsername((string) $res_ibsusername[0]['ibsusername']);
                                                if($userid[0] && isset($cf_sername)){
                                                    $id=$userid[1];
                                                    $res=$GLOBALS['ibs_internet']->setUserCustomField((string) $id, 'service_name', $cf_sername);
                                                }
                                            break;
                                            default:
                                                
                                            break;
                                        }
                                    } else {
                                        $res_setuserattrs = $GLOBALS['ibs_internet']->setUserAttributes(
                                            (string) $res_addnewuser[1][0],
                                            array(
                                                "name" => $res_subscriber[0]['name_sherkat'],
                                                "comment" => $res_subscriber[0]['shenase_meli'],
                                                "phone" => (string) $res_ibsusername[0]['ibsusername'],
                                                "cell_phone" => $res_subscriber[0]['telephone_hamrah'],
                                                "postal_code" => "0", //shahkar_code
                                                "email" => $res_subscriber[0]['shomare_sabt'] . ',' . $res_factor[0]['city_name'],
                                                "address" => $res_service[0]['type'],
                                                "birthdate" => $res_subscriber[0]['tarikhe_sabt'],
                                                "birthdate_unit" => 'gregorian',
                                                "abs_exp_date" => $res_factor[0]['tarikhe_payane_service'],
                                                "abs_exp_date_unit" => 'gregorian',
                                                "normal_user_spec" => array(
                                                    "normal_username" => (string) $res_ibsusername[0]['ibsusername'],
                                                    "normal_password" => (string) $res_subscriber[0]['shenase_meli'],
                                                ),
                                            )
                                        );
                                        switch (strtolower($res_service[0]['type'])) {
                                            case 'bitstream':
                                            case 'adsl':
                                            case 'vdsl':
                                                $cf_sername='ADSL';
                                                $userid=$GLOBALS['ibs_internet']->getUserIdByNormalUsername((string) $res_ibsusername[0]['ibsusername']);
                                                if($userid[0] && isset($cf_sername)){
                                                    $id=$userid[1];
                                                    $res=$GLOBALS['ibs_internet']->setUserCustomField((string) $id, 'service_name', $cf_sername);
                                                }
                                            break;
                                            case 'wireless':
                                                $cf_sername='WIRELESS';
                                                $userid=$GLOBALS['ibs_internet']->getUserIdByNormalUsername((string) $res_ibsusername[0]['ibsusername']);
                                                if($userid[0] && isset($cf_sername)){
                                                    $sql="SELECT
                                                        ss.id ssid,
                                                        ss.station_id stationid,
                                                        ss.sub_id subid,
                                                        ws.arz_joghrafiai,
                                                        ws.tol_joghrafiai 
                                                    FROM
                                                        bnm_sub_station ss
                                                        INNER JOIN bnm_wireless_station ws ON ss.station_id = ws.id
                                                        INNER JOIN bnm_wireless_ap wa 
                                                    WHERE
                                                        ss.id = ?
                                                        GROUP BY ss.id";
                                                    $res_station=Db::secure_fetchall($sql, [$res_factor[0]['emkanat_id']]);
                                                    if($res_station){
                                                        $tol=Helper::decimalToLL($res_station[0]['tol_joghrafiai']);
                                                        $arz=Helper::decimalToLL($res_station[0]['arz_joghrafiai']);
                                                        $id=$userid[1];
                                                        $res=$GLOBALS['ibs_internet']->setUserCustomField((string) $id, 'service_name', $cf_sername);
                                                        $res=$GLOBALS['ibs_internet']->setUserCustomField((string) $id, 'location1', $tol.','.$arz);
                                                    }
                                                }
                                            break;
                                            case 'tdlte':
                                                $cf_sername='TD_LTE';
                                                $userid=$GLOBALS['ibs_internet']->getUserIdByNormalUsername((string) $res_ibsusername[0]['ibsusername']);
                                                if($userid[0] && isset($cf_sername)){
                                                    $id=$userid[1];
                                                    $res=$GLOBALS['ibs_internet']->setUserCustomField((string) $id, 'service_name', $cf_sername);
                                                }
                                            break;
                                            default:
                                                
                                            break;
                                        }
                                    }
                                    
                                    // ShahkarHelper::putServices($res_factor[0]['id'], $res_service[0]['type']);
                                    if($res_service[0]['type']==='bitstream'){
                                        //1-get reserve info
                                        $sql="SELECT id, resid FROM bnm_oss_reserves WHERE id = ?";
                                        $oss= Db::secure_fetchall($sql, [$res_factor[0]['emkanat_id']]);
                                        if(! $oss)die(Helper::Json_Message('e'));
                                        $res_bs=$GLOBALS['bs']->activateResource($oss[0]['resid']);
                                        Helper::resetIbsChargeRulesByUsername((string) $res_ibsusername[0]['ibsusername'], 'internet');
                                        die(Helper::Custom_Msg(Helper::Messages('s')."<br>".$GLOBALS['bs']->getMessage($res_bs), 1));
                                    }else{
                                        Helper::resetIbsChargeRulesByUsername((string) $res_ibsusername[0]['ibsusername'], 'internet');
                                        die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                                    }
                                } else {
                                    die(Helper::Custom_Msg(Helper::Messages('icf') . ' ' . Helper::Messages('ps'), 2));
                                }
                            } else {
                                //sharje mojadad
                                $availblecredit = 0;
                                if(isset($res_factor[0]['etebare_ghabele_enteghal'])){
                                    $availblecredit=$res_factor[0]['etebare_ghabele_enteghal'];
                                }else{
                                    $availblecredit=0;
                                }
                                $user_id = $GLOBALS['ibs_internet']->getUserIdByNormalUsername($res_ibsusername[0]['ibsusername']);
                                // die(json_encode($user_id));
                                if ($user_id) {
                                    if ($res_factor[0]['noe_moshtarak'] === "real") {
                                        $res_setuserattrs = $GLOBALS['ibs_internet']->setUserAttributes(
                                            (string) $user_id,
                                            array(
                                                "name" => $res_subscriber[0]['name'] . ' ' . $res_subscriber[0]['f_name'],
                                                "comment" => $res_subscriber[0]['code_meli'],
                                                "phone" => (string) $res_ibsusername[0]['ibsusername'],
                                                "group_name" => (string) $res_service[0]['onvane_service'],
                                                "cell_phone" => $res_subscriber[0]['telephone_hamrah'],
                                                "postal_code" => "0",
                                                "email" => $res_subscriber[0]['shomare_shenasname'] . ',' . $res_factor[0]['city_name'],
                                                "address" => $res_service[0]['type'],
                                                "birthdate" => $res_subscriber[0]['tarikhe_tavalod'],
                                                "birthdate_unit" => 'gregorian',
                                                "abs_exp_date" => $res_factor[0]['tarikhe_payane_service'],
                                                "abs_exp_date_unit" => 'gregorian',
                                                // "normal_user_spec" => array(
                                                //     "normal_username" => (string) $res_ibsusername[0]['ibsusername'],
                                                //     "normal_password" => (string) $res_subscriber[0]['code_meli'],
                                                // ),
                                            )
                                        );
                                    } else {
                                        $res_setuserattrs = $GLOBALS['ibs_internet']->setUserAttributes(
                                            (string) $user_id,
                                            array(
                                                "name" => $res_subscriber[0]['name_sherkat'],
                                                "comment" => $res_subscriber[0]['shenase_meli'],
                                                "phone" => (string) $res_ibsusername[0]['ibsusername'],
                                                "group_name" => (string) $res_service[0]['onvane_service'],
                                                "cell_phone" => $res_subscriber[0]['telephone_hamrah'],
                                                "postal_code" => "0",
                                                "email" => $res_subscriber[0]['shomare_sabt'] . ',' . $res_factor[0]['city_name'],
                                                "address" => $res_service[0]['type'],
                                                "birthdate" => $res_subscriber[0]['tarikhe_sabt'],
                                                "birthdate_unit" => 'gregorian',
                                                "abs_exp_date" => $res_factor[0]['tarikhe_payane_service'],
                                                "abs_exp_date_unit" => 'gregorian',
                                                // "normal_user_spec" => array(
                                                //     "normal_username" => (string) $res_ibsusername[0]['ibsusername'],
                                                //     "normal_password" => (string) $res_subscriber[0]['shenase_meli'],
                                                // ),
                                            )
                                        );
                                    }
                                    switch (strtolower($res_service[0]['type'])) {
                                        case 'bitstream':
                                        case 'adsl':
                                        case 'vdsl':
                                            $cf_sername='ADSL';
                                            $userid=$GLOBALS['ibs_internet']->getUserIdByNormalUsername((string) $res_ibsusername[0]['ibsusername']);
                                            if($userid && isset($cf_sername)){
                                                $id=$userid[1];
                                                $res=$GLOBALS['ibs_internet']->setUserCustomField((string) $id, 'service_name', $cf_sername);
                                            }
                                        break;
                                        case 'wireless':
                                            $cf_sername='WIRELESS';
                                            $userid=$GLOBALS['ibs_internet']->getUserIdByNormalUsername((string) $res_ibsusername[0]['ibsusername']);
                                            if($userid && isset($cf_sername)){
                                                $sql="SELECT
                                                    ss.id ssid,
                                                    ss.station_id stationid,
                                                    ss.sub_id subid,
                                                    ws.arz_joghrafiai,
                                                    ws.tol_joghrafiai 
                                                FROM
                                                    bnm_sub_station ss
                                                    INNER JOIN bnm_wireless_station ws ON ss.station_id = ws.id
                                                    INNER JOIN bnm_wireless_ap wa 
                                                WHERE
                                                    ss.id = ?
                                                    GROUP BY ss.id";
                                                $res_station=Db::secure_fetchall($sql, [$res_factor[0]['emkanat_id']]);
                                                if($res_station){
                                                    $tol=Helper::decimalToLL($res_station[0]['tol_joghrafiai']);
                                                    $arz=Helper::decimalToLL($res_station[0]['arz_joghrafiai']);
                                                    $id=$userid[1];
                                                    $res=$GLOBALS['ibs_internet']->setUserCustomField((string) $id, 'service_name', $cf_sername);
                                                    $res=$GLOBALS['ibs_internet']->setUserCustomField((string) $id, 'location1', $tol.','.$arz);
                                                }
                                            }
                                        break;
                                        case 'tdlte':
                                            $cf_sername='TD_LTE';
                                            $userid=$GLOBALS['ibs_internet']->getUserIdByNormalUsername((string) $res_ibsusername[0]['ibsusername']);
                                            if($userid && isset($cf_sername)){
                                                $id=$userid[1];
                                                $res=$GLOBALS['ibs_internet']->setUserCustomField((string) $id, 'service_name', $cf_sername);
                                            }
                                        break;
                                        default:
                                            
                                        break;
                                    }
                                    $changegroup = $GLOBALS['ibs_internet']->changeUserGroupByUserId((string) $user_id, (string) $res_service[0]['onvane_service']);
                                    $renew = $GLOBALS['ibs_internet']->renewUser((string) $user_id, (string) $availblecredit);
                                    $addtocredit = $GLOBALS['ibs_internet']->addToUserCredit((string) $user_id, (string) $availblecredit, (string) $availblecredit);
                                    // ShahkarHelper::putServices($res_factor[0]['id'], $res_service[0]['type']);
                                    if($res_service[0]['type']==='bitstream'){
                                        //1-get reserve info
                                        $sql="SELECT id, resid FROM bnm_oss_reserves WHERE id = ?";
                                        $oss= Db::secure_fetchall($sql, [$res_factor[0]['emkanat_id']]);
                                        if(! $oss)die(Helper::Json_Message('e'));
                                        $res_bs=$GLOBALS['bs']->activateResource($oss[0]['resid']);
                                        Helper::resetIbsChargeRulesByUsername((string) $res_ibsusername[0]['ibsusername'], 'internet');
                                        die(Helper::Custom_Msg(Helper::Messages('s')."<br>".$GLOBALS['bs']->getMessage($res_bs), 1));
                                    }else{
                                        Helper::resetIbsChargeRulesByUsername((string) $res_ibsusername[0]['ibsusername'], 'internet');
                                        die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                                    }
                                } else {
                                    die(Helper::Custom_Msg(Helper::Messages('aof'), 3));
                                }
                            }
                        } elseif ($res_service[0]['noe_forosh'] === "bulk") {
                            ///for bulk no need to reset charge rules
                            $user_id = $GLOBALS['ibs_internet']->getUserIdByNormalUsername($res_ibsusername[0]['ibsusername']);
                            $addtocredit = $GLOBALS['ibs_internet']->addToUserCredit((string) $user_id, (string) $res_service[0]['terafik'], (string) $res_service[0]['terafik']);
                            
                            // switch (strtolower($res_service[0]['type'])) {
                            //     case 'bitstream':
                            //     case 'adsl':
                            //     case 'vdsl':
                            //         $cf_sername='ADSL';
                            //         $userid=$GLOBALS['ibs_internet']->getUserIdByNormalUsername((string) $res_ibsusername[0]['ibsusername']);
                            //         if($userid[0] && isset($cf_sername)){
                            //             $id=$userid[1];
                            //             $res=$GLOBALS['ibs_internet']->setUserCustomField((string) $id, 'service_name', $cf_sername);
                            //         }
                            //     break;
                            //     case 'wireless':
                            //         $cf_sername='WIRELESS';
                            //         $userid=$GLOBALS['ibs_internet']->getUserIdByNormalUsername((string) $res_ibsusername[0]['ibsusername']);
                            //         if($userid[0] && isset($cf_sername)){
                            //             $sql="SELECT
                            //                 ss.id ssid,
                            //                 ss.station_id stationid,
                            //                 ss.sub_id subid,
                            //                 ws.arz_joghrafiai,
                            //                 ws.tol_joghrafiai 
                            //             FROM
                            //                 bnm_sub_station ss
                            //                 INNER JOIN bnm_wireless_station ws ON ss.station_id = ws.id
                            //                 INNER JOIN bnm_wireless_ap wa 
                            //             WHERE
                            //                 ss.id = ?
                            //                 GROUP BY ss.id";
                            //             $res_station=Db::secure_fetchall($sql, [$res_factor[0]['emkanat_id']]);
                            //             if($res_station){
                            //                 $tol=Helper::decimalToLL($res_station[0]['tol_joghrafiai']);
                            //                 $arz=Helper::decimalToLL($res_station[0]['arz_joghrafiai']);
                            //                 $id=$userid[1];
                            //                 $res=$GLOBALS['ibs_internet']->setUserCustomField((string) $id, 'service_name', $cf_sername);
                            //                 $res=$GLOBALS['ibs_internet']->setUserCustomField((string) $id, 'location1', $tol.','.$arz);
                            //             }
                            //         }
                            //     break;
                            //     case 'tdlte':
                            //         $cf_sername='TD_LTE';
                            //         $userid=$GLOBALS['ibs_internet']->getUserIdByNormalUsername((string) $res_ibsusername[0]['ibsusername']);
                            //         if($userid[0] && isset($cf_sername)){
                            //             $id=$userid[1];
                            //             $res=$GLOBALS['ibs_internet']->setUserCustomField((string) $id, 'service_name', $cf_sername);
                            //         }
                            //     break;
                            //     default:
                                    
                            //     break;
                            // }
                            // ShahkarHelper::putServices($res_factor[0]['id'], $res_service[0]['type']);
                            
                            die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                        } else {
                            die(Helper::Json_Message('f'));
                        }
                    } else {
                        ////voip
                        if ($res_service[0]['noe_forosh'] === "adi" || $res_service[0]['noe_forosh'] === "jashnvare") {
                            if ($res_factor_noe_kharid[0]['tedad'] === 0) {
                                //new user
                                $res_addnewuser = $GLOBALS['ibs_voip']->addNewUser(1,(string) $res_service[0]['gheymat']/10, 'Main', $res_service[0]['onvane_service'], $res_subscriber[0]['code_meli']);
                                if (Helper::ibsCheckUserinfoExist($res_addnewuser)) {
                                    if ($res_factor[0]['noe_moshtarak'] === "real") {
                                        $res_setuserattrs = $GLOBALS['ibs_voip']->setUserAttributes(
                                            (string) $res_addnewuser[1][0],
                                            array(
                                                "name" => $res_subscriber[0]['name'] . ' ' . $res_subscriber[0]['f_name'],
                                                "comment" => $res_subscriber[0]['code_meli'],
                                                "phone" => (string) $res_ibsusername[0]['ibsusername'],
                                                "cell_phone" => $res_subscriber[0]['telephone_hamrah'],
                                                "postal_code" => "0", //shahkar_code
                                                "email" => $res_subscriber[0]['shomare_shenasname'] . ',' . $res_factor[0]['city_name'],
                                                "address" => $res_service[0]['type'],
                                                "birthdate" => $res_subscriber[0]['tarikhe_tavalod'],
                                                "birthdate_unit" => 'gregorian',
                                                "abs_exp_date" => $res_factor[0]['tarikhe_payane_service'],
                                                "abs_exp_date_unit" => 'gregorian',
                                                "voip_user_spec" => array(
                                                    "voip_username" => (string) $res_ibsusername[0]['ibsusername'],
                                                    "voip_password" => (string) $res_ibsusername[0]['ibsusername'],
                                                ),
                                            )
                                        );
                                    } else {
                                        $res_setuserattrs = $GLOBALS['ibs_voip']->setUserAttributes(
                                            (string) $res_addnewuser[1][0],
                                            array(
                                                "name" => $res_subscriber[0]['name_sherkat'],
                                                "comment" => $res_subscriber[0]['shenase_meli'],
                                                "phone" => (string) $res_ibsusername[0]['ibsusername'],
                                                "cell_phone" => $res_subscriber[0]['telephone_hamrah'],
                                                "postal_code" => "0", //shahkar_code
                                                "email" => $res_subscriber[0]['shomare_sabt'] . ',' . $res_factor[0]['city_name'],
                                                "address" => $res_service[0]['type'],
                                                "birthdate" => $res_subscriber[0]['tarikhe_sabt'],
                                                "birthdate_unit" => 'gregorian',
                                                "abs_exp_date" => $res_factor[0]['tarikhe_payane_service'],
                                                "abs_exp_date_unit" => 'gregorian',
                                                "voip_user_spec" => array(
                                                    "voip_username" => (string) $res_ibsusername[0]['ibsusername'],
                                                    "voip_password" => (string) $res_ibsusername[0]['ibsusername'],
                                                ),
                                            )
                                        );
                                    }
                                    // ShahkarHelper::putServices($res_factor[0]['id'], $res_service[0]['type']);
                                    die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                                } else {
                                    die(Helper::Custom_Msg(Helper::Messages('icf') . ' ' . Helper::Messages('ps'), 2));
                                }
                            } else {
                                //sharje mojadad
                                $availblecredit = 0;
                                if(isset($res_factor[0]['etebare_ghabele_enteghal'])){
                                    $availblecredit=$res_factor[0]['etebare_ghabele_enteghal'];
                                }else{
                                    $availblecredit=0;
                                }
                                $user_id = $GLOBALS['ibs_voip']->getUserIdByVoipUsername($res_ibsusername[0]['ibsusername']);
                                
                                if(! $user_id){
                                    die(Helper::Custom_Msg(Helper::Messages('fts').' '."کاربر در اکانتینگ پیدا نشد"));
                                }
                                
                                if ($user_id) {
                                    if ($res_factor[0]['noe_moshtarak'] === "real") {
                                        $res_setuserattrs = $GLOBALS['ibs_voip']->setUserAttributes(
                                            (string) $user_id,
                                            array(
                                                "name" => $res_subscriber[0]['name'] . ' ' . $res_subscriber[0]['f_name'],
                                                "comment" => $res_subscriber[0]['code_meli'],
                                                "phone" => (string) $res_ibsusername[0]['ibsusername'],
                                                "group_name" => (string) $res_service[0]['onvane_service'],
                                                "cell_phone" => $res_subscriber[0]['telephone_hamrah'],
                                                "postal_code" => "0",
                                                "email" => $res_subscriber[0]['shomare_shenasname'] . ',' . $res_factor[0]['city_name'],
                                                "address" => $res_service[0]['type'],
                                                "birthdate" => $res_subscriber[0]['tarikhe_tavalod'],
                                                "birthdate_unit" => 'gregorian',
                                                "abs_exp_date" => $res_factor[0]['tarikhe_payane_service'],
                                                "abs_exp_date_unit" => 'gregorian',
                                                "voip_user_spec" => array(
                                                    "voip_username" => (string) $res_ibsusername[0]['ibsusername'],
                                                    "voip_password" => (string) $res_ibsusername[0]['ibsusername'],
                                                ),
                                            )
                                        );
                                    } else {
                                        $res_setuserattrs = $GLOBALS['ibs_voip']->setUserAttributes(
                                            (string) $user_id,
                                            array(
                                                "name" => $res_subscriber[0]['name_sherkat'],
                                                "comment" => $res_subscriber[0]['shenase_meli'],
                                                "phone" => (string) $res_ibsusername[0]['ibsusername'],
                                                "group_name" => (string) $res_service[0]['onvane_service'],
                                                "cell_phone" => $res_subscriber[0]['telephone_hamrah'],
                                                "postal_code" => "0",
                                                "email" => $res_subscriber[0]['shomare_sabt'] . ',' . $res_factor[0]['city_name'],
                                                "address" => $res_service[0]['type'],
                                                "birthdate" => $res_subscriber[0]['tarikhe_sabt'],
                                                "birthdate_unit" => 'gregorian',
                                                "abs_exp_date" => $res_factor[0]['tarikhe_payane_service'],
                                                "abs_exp_date_unit" => 'gregorian',
                                                "voip_user_spec" => array(
                                                    "voip_username" => (string) $res_ibsusername[0]['ibsusername'],
                                                    "voip_password" => (string) $res_ibsusername[0]['ibsusername'],
                                                ),
                                            )
                                        );
                                    }
                                        $changegroup    = $GLOBALS['ibs_voip']->changeUserGroupByUserId((string) $user_id, (string) $res_service[0]['onvane_service']);
                                        $renew          = $GLOBALS['ibs_voip']->renewUser((string) $user_id, (string) $availblecredit);
                                        $addtocredit    = $GLOBALS['ibs_voip']->addToUserCredit((string) $user_id, (string) $availblecredit, (string) $availblecredit);
                                        $aa             = $GLOBALS['ibs_voip']->setAbsExpDate($user_id, $res_factor[0]['tarikhe_payane_service'], 'gregorian');
                                        // ShahkarHelper::putServices($res_factor[0]['id'], $res_service[0]['type']);
                                        die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                                } else {
                                    die(Helper::Custom_Msg(Helper::Messages('aof'), 3));
                                }
                            }
                        } else {
                            die(Helper::Json_Message('inf'));
                        }
                    }
                } else {
                    die(Helper::Json_Message('credit_operation_fail'));
                }
            } else {
                die(Helper::Json_Message('test2'));
            }
        }

        if (isset($_GET['path'])) {
            if ($_GET['path'] == 'logout') {
                session_destroy();

                $controllerName = 'login';
                $controller = new $controllerName();
                $controller->index();
            }elseif($_GET['path']==="Zarinpal"){
                $controllerName="Zarinpal";
                $controller = new $controllerName();
                
                $controller->index($_GET['Authority'], $_GET['Status']);
            }elseif($_GET['path']==="CrmLastDayReport"){
                $controllerName="CrmLastDayReport";
                $controller = new $controllerName();
                // $controller->index($_GET['Authority'], $_GET['Status']);
            }elseif($_GET['path']==="Expired"){
                $controllerName ="Expired";
                $controller     = new $controllerName();
                // $controller->index($_GET['Authority'], $_GET['Status']);
            }
            $tokens = explode('/', rtrim($_GET['path'], '/'));
            $controllerName = ucfirst(array_shift($tokens));
            $requested_page = strtolower($controllerName);
            if (file_exists('Controllers/' . $controllerName . '.php')) {
                $controller = new $controllerName();
                if (!empty($tokens)) {
                    $actionName = array_shift($tokens);
                    if (method_exists($controller, $actionName)) {
                        $controller->{$actionName}(@$tokens);
                    } else {
                        //nemidonam daghighan chikar mikone :D
                        //if action not found error page
                        $controllerName = 'Error404';
                        $controller = new $controllerName();
                        $controller->index();
                    }
                } else {
                    if (in_array($requested_page, $_SESSION['dashboard_menu_names'])) {
                        //todo... safhe index.php handle shavad
                        if (Helper::Login_Just_Check()) {
                            //check if request in $_SESSION['dashboard_menu_names'] AND IF user has access show page to user
                            //check user access
                            switch ($_SESSION['user_type']) {
                                case __ADMINUSERTYPE__:
                                    $controller = new $controllerName();
                                    $controller->index();
                                    break;
                                case __MODIRUSERTYPE__:
                                case __MODIR2USERTYPE__:
                                case __OPERATORUSERTYPE__:
                                case __OPERATOR2USERTYPE__:
                                    ///user admin nist pas dastresi ha bayad check shavad
                                    // var_dump(Helper::check_user_has_access_or_not($controllerName));
                                    // die();
                                    if (Helper::check_user_has_access_or_not($controllerName)) {

                                        $controller = new $controllerName();
                                        $controller->index();
                                    }elseif($requested_page==="zarinpal"){
                                        $controller = new $controllerName();
                                        $controller->index($_GET['Authority'], $_GET['status']);
                                    } else {
                                        if ($controllerName === 'dashboard' || $controllerName === 'Dashboard') {
                                            $controller = new $controllerName();
                                            $controller->index();
                                        } else {
                                            $controllerName = 'Error404';
                                            $controller = new $controllerName();
                                            $controller->index();
                                        }
                                    }
                                    break;
                                case __ADMINOPERATORUSERTYPE__:
                                    if (Helper::check_user_has_access_or_not($controllerName)) {
                                        $controller = new $controllerName();
                                        $controller->index();
                                    } else {
                                        if ($controllerName === 'dashboard' || $controllerName === 'Dashboard') {
                                            $controller = new $controllerName();
                                            $controller->index();
                                        } else {

                                            $controllerName = 'Error404';
                                            $controller = new $controllerName();
                                            $controller->index();
                                        }
                                    }
                                    break;
                                case __MOSHTARAKUSERTYPE__:
                                    if (Helper::check_user_has_access_or_not($controllerName)) {
                                        $controller = new $controllerName();
                                        $controller->index();
                                    } else {
                                        if ($controllerName === 'dashboard' || $controllerName === 'Dashboard') {
                                            $controller = new $controllerName();
                                            $controller->index();
                                        } elseif($requested_page==="zarinpal"){
                                            $controller = new $controllerName();
                                            $controller->index($_GET['Authority'], $_GET['status']);
                                        }else {
                                            $controllerName = 'Error404';
                                            $controller = new $controllerName();
                                            $controller->index();
                                        }
                                    }
                                    break;
                                default:
                                    $controllerName = 'Error404';
                                    $controller = new $controllerName();
                                    $controller->index();
                                    break;
                            }
                        } else {
                            ///user not login correctly
                            $controllerName = 'login';
                            $controller = new $controllerName();
                            $controller->index();
                        }
                    } else {
                        //request is not in dashboard panel(public website)
                        //todo... safhe index.php handle shavad
                        if ($requested_page == "login") {
                            if (isset($_SESSION['login']) && $_SESSION['login'] == "true") {
                                $controllerName = 'dashboard';
                                $controller = new $controllerName();
                                $controller->index();
                            } else {
                                $controller = new $controllerName();
                                $controller->index();
                            }
                        } else {
                            $controller = new $controllerName();
                            $controller->index();
                            //no access to page or page not exists then show page error404
                        }
                    }
                }
            } else {
                //echo ('444');
                ////if url exist but not found in controllers

                $controllerName = 'Error404';
                $controller = new $controllerName();
                $controller->index();
                //if controller not found render an error page
                $flag = true;
            }
        } else {
            $controllerName = 'Home';
            $controller = new $controllerName();
            $controller->index();
        }
    }
}

          $controller = new $controllerName();
                                $controller->index();
                            } else {
                                $controller = new $controllerName();
                                $controller->index();
                            }
                        } else {
                            $controller = new $controllerName();
                            $controller->index();
                            //no access to page or page not exists then show page error404
                        }
                    }
                }
            } else {
                //echo ('444');
                ////if url exist but not found in controllers

                $controllerName = 'Error404';
                $controller = new $controllerName();
                $controller->index();
                //if controller not found render an error page
                $flag = true;
            }
        } else {
            $controllerName = 'Home';
            $controller = new $controllerName();
            $controller->index();
        }
    }
}

