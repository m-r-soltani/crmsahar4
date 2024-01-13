<?php defined('__ROOT__') or exit('No direct script access allowed');
class Test extends Controller
{
    public function __construct()
    {
        parent::__construct();

    }
    
    public function index()
    {
        // $st="id	noe_moshtarak	name	f_name	name_pedar	jensiat	meliat	tabeiat	noe_shenase_hoviati	shomare_shenasname	tarikhe_tavalod	ostane_tavalod	shahre_tavalod	telephone1	telephone_hamrah	email	fax	website	code_posti1	code_posti2	code_posti3	address1	address2	address3	shoghl	nahve_ashnai	gorohe_moshtarak	moaref	tozihat	r_t_karte_meli	r_t_ghabze_telephone	r_t_ejare_malekiat	r_t_gharardad	r_t_sayer	name_sherkat	shomare_sabt	tarikhe_sabt	shomare_dakheli	code_eghtesadi	shenase_meli	name_pedare	reshteye_faaliat	l_t_agahie_tasis	l_t_akharin_taghirat	l_t_saheb_kartemeli_emzaye_aval	l_t_saheb_kartemeli_emzaye_dovom	l_t_kartemeli_namayande	l_t_moarefiname_namayande	l_t_ghabze_telephone	l_t_gharardad	l_t_ejarename_malekiat	l_t_sayer	telephone2	telephone3	code_meli	code_eshterak	branch_id	noe_malekiat1	noe_malekiat2	noe_malekiat3	name_malek1	name_malek2	name_malek3	f_name_malek1	f_name_malek2	f_name_malek3	code_meli_malek1	code_meli_malek2	code_meli_malek3	noe_sherkat	code_faragire_haghighi_pezhvak	tarikhe_sabte_sherkat	shenase_hoviati_sherkat	code_namayande_forosh	telephone_hamrahe_sherkat	noe_shenase_hoviati_sherkat	shahre_sokonat	ostane_sokonat	tarikhe_tavalod_namayande	code_pezhvak	meliat_namayande	tel1_ostan	tel2_ostan	tel3_ostan	tel1_shahr	tel2_shahr	tel3_shahr	tel1_street	tel2_street	tel3_street	tel1_street2	tel2_street2	tel3_street2	tel1_housenumber	tel2_housenumber	tel3_housenumber	tel1_tabaghe	tel2_tabaghe	tel3_tabaghe	tel1_vahed	tel2_vahed	tel3_vahed	tarikhe_sabtenam	ipaddress	creatorid	lasteditor	confirmstatus";
        // $st=str_replace('	', ', ', $st);
        // echo $st;
        $res=ShahkarHelper::estServiceStatusByFactorID(6443);
        Helper::cLog($res);
        die();
                ///send sms to 3 days and 1 day expiring users
                // $ibs=$GLOBALS['ibs_voip']->getUsersAboutToExpire(3,3);
                // $arrids=[];
                // foreach ($ibs[1][2] as $k => $v) {
                //     $arrids[]=$v;
                // }
                // if($arrids){
                //     $usersibsinfo=Helper::ibsGetUserInfoByArrayId($arrids, true, 'voip');
                //     $allusers=Helper::getServiceInfoByServiceTypeNoAuth('voip');
                //     $arr=[];
                //     foreach ($allusers as $k => $v) {
                //         foreach ($usersibsinfo as $kk => $vv) {
                //             if($v['ibsusername']===$vv['attrs']['voip_username']){
                //                 $v['ibsinfo']=$vv;
                //                 $arr[]=$v;
                //             }
                //         }
                //     }
                // }
                // if($arr){
                //     foreach ($arr as $k => $v) {
                //         if($v['branch_id']===0){
                //             $res_internal = Helper::Internal_Message_By_Karbord('mdhexs', '1');
                //         }else{
                //             $res_internal = Helper::Internal_Message_By_Karbord('mdhexn', '1');
                //         }
                //         if ($res_internal) {
                //             $res_sms_request = Helper::Write_In_Sms_Request($v['telephone_hamrah'], Helper::Today_Miladi_Date(),
                //                 Helper::Today_Miladi_Date(), 1, $res_internal[0]['id'], '2');
                //             if ($res_sms_request) {
                //                 $arr = array();
                //                 $arr['receiver'] = $v['telephone_hamrah'];
                //                 $arr['sender'] = __SMSNUMBER__;
                //                 $arr['request_id'] = $res_sms_request;
                //                 $res = Helper::Write_In_Sms_Queue($arr);
                //             }
                //         }
                //     }                    
                // }
                // Helper::cLog($arr);
                // die();
                

















        // $ibs=$GLOBALS['ibs_internet']->getUserInfoByNormalUserName('02122145068');
        // // var_dump($ibs);
        // Helper::cLog($ibs);
        // die();

        // $y1= date("Y-m-d", strtotime("-1 year"));
        // $y1.=" "."00:00:00" ;
        // $y1=strtotime($y1);
        // $y2= date("Y-m-d", strtotime("-1 year"));
        // $y2.=" "."23:59:59" ;
        // $y2=strtotime($y2);
        // // Helper::cLog([$y1, $y2]);
        // // die();

        // // $y2=strtotime($y2);   
        // $username='w-20-0550007822';
        // $db = Helper::pdodbIpdrInstance();
        // $db->where('username', $username, "=");     
        // $db->where('ses_start', $y1, ">=");
        // $db->where('ses_stop', $y2, "<=");
        // // if($cid) $db->where('user_id', $cid);
        // // if($tel) $db->where('username', $ntel);            
        // // if($ip) $db->where('ip', $ip2l);
        // // $db->orderBy("ses_start");
        // $res = $db->get("tbl_ipdr");
        // $db=null;
        // Helper::cLog($res);
        // die();



        // $res=$GLOBALS['ibs_internet']->searchUser(['normal_username'=>'02144755050', 'has_assign_ip'=>true]);
        // $a1=[100,300];
        // $a2=[200];
        // $res=strtotime('2023-05-21 12:10');
        // $res=validateDate('2023-05-21 12:10');
        
        // $res=$GLOBALS['ibs_internet']->getUserInfoByUserID('1684');
        // $res=$GLOBALS['ibs_internet']->getConnectionsByMacAndDateTimeASC('1E:CC:20:67:F5:5E', '1402/01/01', '1402/02/30 23:59', 200, "jalali");
        // $res=Helper::getIbsLogsByArrayUsernamesDesc(["02144755050", "01133409828"]);
        // filter_var(false,FILTER_VALIDATE_IP);
        // if(filter_var('192.168.192.111', FILTER_VALIDATE_IP)){
        //     echo 'Valid IP';
        // } else {
        //     echo 'Not Valid IP';
        // }
        // $ips=["ipv4_address"=>"2.2.2.2", "ipv4_address"=>"0.0.0.0", "ipv4_address"=>"192.168.1.4"];
        // $res=SiamHelper::unsetLogIfIPNotValid($ips);
        // $res=$GLOBALS['ibs_voip']->getUserIdByVoipUsername('02144755050');
        ////siam//////٢١٦٦٥٥٤٤٣٣

        // $res=$GLOBALS['ibs_internet']->findUserByMac('74:DA:DA:88:40:9C');

        // $res = SiamHelper::combinSearch('saharertebat', '12345', '١١٣٣٤٠٩٨٢٨', '95.38.38.73', '', "", '', "", "", '', true);
        // $res = SiamHelper::combinSearch('saharertebat', '12345', '2144755050', '', '', "", '', "", "", '', true);
        // $res = SiamHelper::combinSearch('saharertebat', '12345', '٢١٨١٧٧٣٢٤٦', '', '', "", '', "", "", '', true);
        $res=SiamHelper::TechnicalSearch('saharertebat', '12345', '95.38.38.182', '1402/04/04 00:00', '1402/04/04 14:00', true);
        // $res=SiamHelper::MacSearch('saharertebat', '12345', '1E:CC:20:67:F5:5E', '1402/04/03 00:00', '1402/04/03 17:59', true);
        // $res=SiamHelper::MacSearch('saharertebat', '12345', '74:DA:DA:88:40:9C', '1402/03/31 17:00', '1402/03/31 23:59', true);
        // $res=ip2long('95.38.38.56');
        // $res=SiamHelper::ListOfBPlan('saharertebat', '12345', '1402/03/20 00:00', '1402/03/20 23:59');
        // $res=SiamHelper::GetIPDR('saharertebat','12345', '١٤٠٢/٠٣/20 22:00', '١٤٠٢/٠٣/21 22:15', '1133409828', '', '', true);        
        // $res=SiamHelper::ApplySuspIp('saharertebat', '12345', "gfhfh", "1", "0", '' , '', '95.38.38.186', '');
        // $res=SiamHelper::ApplySuspIp('saharertebat', '12345', "kj", "1", "1", '' , '2144755050', '', '');
        // $res=[];
        // $res[]=Helper::checkUserCanBeUnsuspended('02144755050', 1);
        // $res[]=Helper::checkUserCanBeUnsuspended('02144755050', 2);
            // $res=Helper::logUnlockInternetService('02144755050', 1, 2, 0, 'qw213', 'dfg');
        // $res=SiamHelper::GetIpPool('saharertebat', '12345');
        // $res=Helper::lockInternetService('02144755050', '1');
        // $res=date('Y-m-d', strtotime("+1 year")).' '.Helper::nowTimeTehran();
        // $res=Helper::logLockInternetService('02144755050', 2, 1);
        // $res=Helper::logUnlockInternetService('02144755050', 2, 1, '', 'abc');
        Helper::cLog($res);
        die();


        
        // $res=Helper::logLockInternetService($username, 2, $SuspType, $SuspOrder, $RefNum, 'قطع از طریق سیام');

        // //siam///////
        // $res=$GLOBALS['ibs_internet']->searchUser(['is_online'=>TRUE]);
        // $res=date("Y-m-d H:i:s", strtotime("-1 day"));
        // $res=Helper::getIbsLogsByArrayUsernamesDesc(["02144755050", "01133409828"],date("Y-m-d H:i:s", strtotime("-2 hour")), date("Y-m-d H:i:s"));
        // $res=$GLOBALS['ibs_internet']->getConnectionByUserIdAndDateTimeDesc("1684,1778", date("Y-m-d H:i:s", strtotime("-1 day")), date("Y-m-d H:i:s"));
        // $res=$GLOBALS['ibs_internet']->getUserInfoByNormalUserName("02144755050");
        // Helper::cLog($res);
        // die();
        // for ($i=0; $i <count($res) ; $i++) { 
        //     if($res[$i] && $i===array_key_last($res)){
        //         $st.=(string)$res[$i];
        //     }elseif ($res[$i] && $i !== array_key_last($res)) {
        //         $st.=(string)$res[$i].",";
        //     }
        // }
        // $res=date("Y-m-d H:i:s", strtotime("-6 months"));
        
        // $res=$GLOBALS['ibs_internet']->getConnectionByUsernameAndDateTimeDesc("1684");
        // 1684,1773
        // $res=$GLOBALS['ibs_internet']->getConnectionByUserIdDesc("1684,1773");
        // $res=$GLOBALS['ibs_internet']->getUserIdByNormalUsername("02144755050,");

        // 
        
        
        // $res=SiamHelper::siamTel('0912۴۴755۰5۰', 2);
        // Helper::cLog($res);
        // die();
        // $res=$GLOBALS['ibs_internet']->getOnlineUsers();
        // Helper::cLog($res);
        // die();
        
            // $d1=strtotime("2022-11-29");
            // $d2=strtotime("2022-11-29");
            // // echo $d1."///". $d2;
            // // die();
            // $db = Helper::pdodbIpdrInstance();
            // $db->where('ses_start', $d1, ">=");
            // $db->where('ses_stop', $d2, "<=");
            // // if($cid) $db->where('user_id', $cid);
            // // if($tel) $db->where('username', $ntel);            
            // // if($ip) $db->where('ip', $ip2l);
            // $db->orderBy("ses_start");
            // $res = $db->get("tbl_ipdr");
            // $db=null;
            // Helper::cLog($res);
            // die();
        // $a1=[15, 12];
        // $a2=[2, 1];
        // $res=SiamHelper::GetIPDR('saharertebat','12345', '۱۴۰۱/۰8/10 01:02', '۱۴۰2/۰۲/10 23:58', '', '95.38.38.187', '');
        // $res="2022-".date("m-d H:i:s");
        // $res=array_merge($a2, $a1);
        // Helper::cLog($res);
        // die();
        

        // $res=strtotime("2022");

        // $a1=[['id'=>0,'usernaem'=>'02144755050']];
        // $a2=[];
        // Helper::cLog(array_merge($a1,$a2));
        // die();
        // $res=Helper::TabdileTarikh('1401/08/08', 2, '/', '-');
        // Helper::cLog(strtotime('2022-11-01'));
        // $res=Helper::Add_Or_Minus_Day_To_Date(180,'-', '');
        // $db=Helper::pdodbIpdrInstance();
        // $res = $db->rawQuery('SELECT COUNT(*) FROM tbl_ipdr WHERE ses_start >= ');
        // $res = $db->rawQuery('SELECT * rowsnum FROM tbl_ipdr ORDER BY id DESC LIMIT 100');
        // $db=null;
        // for ($i=0; $i <count($res) ; $i++) { 
        //     $res[$i]['ses_start_11111111']=date("Y-m-d H:i:s", $res[$i]['ses_start']); 
        //     echo "<br>";
        //     print_r($res[$i]);
        //     echo "<br>";
        // }
        
        // Helper::cLog($res);
        // die();
        // $arr=[];
        // for ($i=0; $i <190 ; $i++) { 
        //     $arr[]=$i;
        // }
        // for ($i=0; $i <count($arr) ; $i++) { 
        //     if($i%20===0 && $i!== 0){
        //         $arr[$i]="b";
        //     }
        // }
        // Helper::cLog($arr);
        // die();
        // $res=[3=>'aa', 0=>'dd', 1=>'bb'];
        // array_map()
        // sort($res);
        // $subs=[];
        // $subs[0]['id']=10;
        // $a1=[['subid'=>10],['subid'=>20]];
        // $res=SiamHelper::checkSubAlreadyAdded($a1, $subs);
        // ۱۴۰۱/۰۲/۰۴ ۱۱:۴۴
        // ۱۴۰۲/۰۱/۳۰
        // $res=SiamHelper::combinSearch2('saharertebat', '12345', '۹۸۲۱۴۴۷۵۵۰۵۰', '', '', '', '', '', '');
        // $res=json_decode($res);
        // $res=SiamHelper::combinSearch2('saharertebat', '12345', '', '95.38.38.185');
        // $res=$GLOBALS['ibs_internet']->getConnectionByUsernameAndRemoteIpAndDateTimeDesc200Rows('02144755050', '95.38.38.65');
        // $res=SiamHelper::combinSearch2('saharertebat', '12345', '', '', 'asd');
        // $res=SiamHelper::combineSearchDynamicQuery(['code_meli'=>'0066187559', 'name'=>'سیامک']);
        // $res=SiamHelper::siamTel("01133264389", 2);
        // $res=Helper::getIbsUserinfoByUsernameAndSertype("02144755050");

        // $res=$GLOBALS['ibs_internet']->getConnectionByRemoteIpAndDateTimeDescLastTenRows("95.38.38.77");
        // $res=Helper::checkIpExist('95.38.455.79');
        // $res=SiamHelper::TechnicalSearch('saharertebat', '12345', '95.38.38.185', '1402/01/01 00:00', '1402/01/31 23:59');

        // $res=$GLOBALS['ibs_internet']->getConnectionsByIpAndDateTimeASC("95.38.38.39", "2023-01-01 00:00", "2023-04-30 23:59");

        // $res=Helper::like('02144755050', '50');

        // $string = "02144755050";
        // $pattern = "/02144755050/i"; 
        // var_dump(preg_match($pattern, $string));
        // if() {
        //     var_dump("A match was found.");
        // }
        // $string = '2144755050';
        // $regex = "/02144755050/i";
        // $res= preg_match($regex, $string);
        // $res=strpos('02144755050', '982144755050',3);
        // $res=substr('02144755050', 1);
        // $res=Helper::TabdileTarikh();
        // $res=SiamHelper::MacSearch('saharertebat', '12345', '1E:CC:20:67:F5:5E', '1402/01/01 00:00', '1402/04/30 23:59');
        // $res=$GLOBALS['ibs_internet']->getConnectionsByMacAndDateTimeASC('1E:CC:20:67:F5:5E','2023-04-01', '2023-04-11');
        // var_dump($res);
        // Helper::cLog($res);
        // die();
        // $res=$GLOBALS['ibs_internet']->listISPsWithIDs();

        // $res=$GLOBALS['ibs_internet']->getConnectionsByUserIdAndDateTimeASC('1772','2023-04-01', '2023-04-11');
        // $res=$GLOBALS['ibs_internet']->getConnectionsByMacAndDateTimeASC('1E:CC:20:67:F5:5E','2023-04-01', '2023-04-11');

        // $res=$GLOBALS['ibs_internet']->getConnectionLogsForMac('2023-04-01 00:00:00', )
        
        // $tel=Helper::regulateNumber('982144755050',2);
        // $res = $GLOBALS['ibs_internet']->getUserInfoByNormalUserName('05143337943');
        // $res=Helper::getInternetServicesInfoWithIbsusernameNoAuth('05143337943');
        // $res=SiamHelper::TechnicalSearch('saharertebat', '12345', 'TechnicalSearch');
        // $res=SiamHelper::TechnicalSearch('saharertebat', '12345', '95.38.38.79');
        // $res=SiamHelper::TechnicalSearch('saharertebat', '12345', '404a.03c5.5741');

        //////////////
        // $db=Helper::pdodbIpdrInstance();
        // $res = $db->rawQuery('SELECT *,INET_NTOA (ip) FROM tbl_ipdr ORDER BY ses_start ASC LIMIT 100');
        // // // $res = $db->rawQuery('SELECT * rowsnum FROM tbl_ipdr ORDER BY id DESC LIMIT 100');
        // // $db=null;
        // for ($i=0; $i <count($res) ; $i++) { 
        //     $res[$i]['ses_start_11111111']=date("Y-m-d H:i:s", $res[$i]['ses_start']); 
        //     echo "<br>";
        //     print_r($res[$i]);
        //     echo "<br>";
        // }
        // var_dump($res);

        // $res[99]['ses_start1']=date("Y-m-d H:i:s", $res[99]['ses_start']);
        // Helper::cLog($res);
        // die();
        // $username='2144755050';
        // $ser=Helper::getInternetServicesInfoWithIbsusernameNoAuth($username);
        // Helper::cLog($ser);
        // die();
        // $ipdrpdodb=Helper::pdodbIpdrInstance();
        // $res = $ipdrpdodb->rawQuery('SELECT * FROM tbl_ipdr ORDER BY ses_start desc LIMIT 100');
        // Helper::cLog($res);
        // die();
        /////////////////ipdr getipdr test
        // $res=SiamHelper::GetIPDR('saharertebat','12345', '۱۴۰۱/۰۱/۰۴ ۱۱:۴۴', '۱۴۰۱/۱۱/۰۱ ۱۱:۴۴', '', '', "09034899814");
        // // $res=SiamHelper::GetIPDR('saharertebat', '12345', '982144755050','1401/03/30','1401/09/30');
        // $res=json_decode($res);
        // echo $res;
        // die();
        /////////////////ipdr getipdr test
        // $username='saharertebat';
        // $password="123456";
        // $NAutStr='qwerty';
        // $sql="UPDATE bnm_siamconfig SET password=:nautstr WHERE username=:username AND password=:password";
        // $res=Db::secure_update_array($sql, ['username'=>$username, 'nautstr'=>$NAutStr, 'password'=>$password]);
        // Helper::cLog($res);
        // die();
        ///////////////crmdailyreport-create report by each day for a range of date
        // $dates=Helper::createDateRange('2023-01-21', '2023-03-18');
        // for ($i=0; $i < count($dates); $i++) {
        //     $d=date("Ymd", strtotime($dates[$i]));
        //     $name   = "CRM_".$d."_"."SaharErtebat.csv";
        //     $fd=date("Y-m-d", strtotime($dates[$i]));
        //     $td=date("Y-m-d", strtotime($dates[$i]));
        //     echo $fd."<br>";
        //     echo $td."<br>";
            // $res    = CrmReport::reportByCustomDates($fd, $td);
            // $csv    = Helper::createCrmReportCsv($res, 'dump');
            // if ($csv) {
            //     $ftp = Helper::sendCrmReportFileWithFtp(__CRMFTPHOST__, __CRMFTPUSER__, __CRMFTPPASS__, __ROOT__, 'dump.csv', __CRMFTPDESTPATH__, $name);
            // }
            // echo $d.'('.$ftp.')'."<br>";
            // Helper::cLog($ftp);
        // }
        // die();
        





        // $begin = new DateTime('2023-01-21');
        // $fd = date("Y-m-d", strtotime($begin));
        // echo $fd;
        // $end = new DateTime('2023-03-19');
        // $interval = DateInterval::createFromDateString('1 day');
        // $period = new DatePeriod($begin, $interval, $end);
        // foreach ($period as $dt) {
        //     echo $dt->format("Y-m-d")."<br>";
        // }

        // $name   = '';
        // // $date   = '20230209';
        // // $fd     = Helper::Today_Miladi_Date('-');
        // $fd     = '2023-01-21';
        // $td     = '2023-03-19';
        // // $td     = Helper::Today_Miladi_Date('-');
        // $name   = "CRM_".$date."_"."SaharErtebat.csv";
        // $res    = CrmReport::reportByCustomDates($fd, $td);
        // $csv    = Helper::createCrmReportCsv($res, 'dump');
        // if ($csv) {
        //     $ftp = Helper::sendCrmReportFileWithFtp(__CRMFTPHOST__, __CRMFTPUSER__, __CRMFTPPASS__, __ROOT__, 'dump.csv', __CRMFTPDESTPATH__, $name);
        // }
        // echo $ftp;
        // Helper::cLog($ftp);
        // die();
        ///////////////crmdailyreport



        // $res=Helper::getServiceInfoByFactoridNoAuth(6926);
        // Helper::cLog($res);
        // die();
        // $res=$GLOBALS['ibs_internet']->getUserInfoByNormalUserName('02144755050');
        // var_dump($res);
        // Helper::cLog($res);
        // die();
        // $gpc=new GpointConverter();
        // die();
        // $cords=new coordinates();
        // $res=Helper::fraction_to_min_sec(51.81051);

        // echo $res;
        
        // Helper::cLog($res);
        // die();
        // $utm=Helper::ll2utm(51.81051, 35.75127);
        // Helper::cLog($utm);
        // die();
        // // $res=$GLOBALS['ibs_internet']->setUserCustomField((string) 1684, 'service_name', 'ADSL');
        // $aa=Helper::DDtoDMS(51.81051);
        // $bb=Helper::DDtoDMS(35.75127);
        // // Helper::cLog($res);
        // // $bb=Helper::DDtoDMS(35.75127);

        // // Helper::cLog()
        // $res1=Helper::DMStoDD((string)$aa['deg'],(string)$aa['min'],(string)$aa['sec']);
        // $res2=Helper::DMStoDD((string)$bb['deg'],(string)$bb['min'],(string)$bb['sec']);
        // Helper::cLog($aa);
        // Helper::cLog($bb);
        // Helper::cLog($res1);
        // Helper::cLog($res2);
        // // Helper::cLog();
        // die();

        // $GLOBALS['ibs_internet']->setUserAttributes((string) 1684, ['comment'=>'salam', 'address'=>'qwe']);
        // die();
        /////////////////set customfields
        // $sers=Helper::getAllInternetUsersServicesInfoNoAuth();
        // for ($i=0; $i <count($sers) ; $i++) {
        //     if(! $sers[$i]['ibsusername']){
        //         continue;
        //     }
        //     $customfields=Helper::setIbsCustomfieldsByFactorid($sers[$i]['fid']);
        //     // $subinfo=Helper::Select_By_Id('bnm_subscribers', $sers[$i]['subid']);
        //     // if($subinfo){
        //     //     switch (strtolower($sers[$i]['general_sertype'])) {
        //     //         case 'bitstream':
        //     //         case 'adsl':
        //     //         case 'vdsl':
        //     //             $service_name='ADSL';
        //     //             $userid=$GLOBALS['ibs_internet']->getUserIdByNormalUsername($sers[$i]['ibsusername']);
        //     //             // Helper::cLog($userid);
        //     //             if(isset($service_name)){
        //     //                 if($subinfo[0]['noe_moshtarak']=='real'){
        //     //                     $address=$subinfo[0]['code_meli'];
        //     //                 }else{
        //     //                     $address=$subinfo[0]['shenase_meli'];
        //     //                 }
        //     //             }
        //     //             if($userid[0] && isset($service_name)){
        //     //                 $id=$userid[1];
        //     //                 $res=$GLOBALS['ibs_internet']->setUserCustomField((string) $id, 'service_name', $service_name);
        //     //             }
        //     //         break;
        //     //         case 'wireless':
        //     //             $service_name='WIRELESS';
        //     //             $userid=$GLOBALS['ibs_internet']->getUserIdByNormalUsername($sers[$i]['ibsusername']);
        //     //             if($userid[0] && isset($service_name)){
        //     //                 $id=$userid[1];
        //     //                 $res=$GLOBALS['ibs_internet']->setUserCustomField((string) $id, 'service_name', $service_name);
        //     //             }
        //     //         break;
        //     //         case 'tdlte':
        //     //             $service_name='TD_LTE';
        //     //             $userid=$GLOBALS['ibs_internet']->getUserIdByNormalUsername($sers[$i]['ibsusername']);
        //     //             if($userid[0] && isset($service_name)){
        //     //                 $id=$userid[1];
        //     //                 $res=$GLOBALS['ibs_internet']->setUserCustomField((string) $id, 'service_name', $service_name);
        //     //             }
        //     //         break;
                    
        //     //         default:
                        
        //     //         break;
        //     //     }
                
                
        //     // }
        // }
        // die();
        //////////////////////set user attributes
        // $sers=Helper::getAllInternetUsersServicesInfoNoAuth();
        // for ($i=0; $i <count($sers) ; $i++) {
        //     if(! $sers[$i]['ibsusername']){
        //         continue;
        //     }
        //     $subinfo=Helper::Select_By_Id('bnm_subscribers', $sers[$i]['subid']);
        //     if($subinfo){
        //         switch (strtolower($sers[$i]['general_sertype'])) {
        //             case 'bitstream':
        //             case 'adsl':
        //             case 'vdsl':
        //                 $comment='ADSL';
                        
        //             break;
        //             case 'wireless':
        //                 $comment='Wireless';
        //             break;
        //             case 'tdlte':
        //                 $comment='TD_LTE';
        //             break;
                    
        //             default:
                        
        //             break;
        //         }
        //         if(isset($comment)){
        //             if($subinfo[0]['noe_moshtarak']=='real'){
        //                 $address=$subinfo[0]['code_meli'];
        //             }else{
        //                 $address=$subinfo[0]['shenase_meli'];
        //             }
        //         }
        //         $userid=$GLOBALS['ibs_internet']->getUserIdByNormalUsername($sers[$i]['ibsusername']);
           
        //      if($userid[0]){
        //             // Helper::cLog($userid);
        //             $id=$userid[1];
        //             $GLOBALS['ibs_internet']->setUserAttributes((string) $id, ['comment'=>$comment, 'address'=>$address]);
        //         }
        //     }
        // }
        // die();
        
        // Helper::cLog($sers);
        // die();

        // $id= 7897465;
        // $sql="DELETE FROM bnm_pre_number WHERE markaze_mokhaberati= $id";
        // $del=Db::justexecute($sql);
        // Helper::cLog($del);
        // var_dump($del);
        // die();



















        ////////////////////
        // $name   = '';
        // $date   = '20230209';
        // // $fd     = Helper::Today_Miladi_Date('-');
        // $fd     = '2023-02-09';
        // $td     = '2023-02-09';
        // // $td     = Helper::Today_Miladi_Date('-');
        // $name   = "CRM_".$date."_"."SaharErtebat.csv";
        // $res    = CrmReport::reportByCustomDates($fd, $td);
        // $csv    = Helper::createCrmReportCsv($res, 'dump');
        // if ($csv) {
        //     $ftp = Helper::sendCrmReportFileWithFtp(__CRMFTPHOST__, __CRMFTPUSER__, __CRMFTPPASS__, __ROOT__, 'dump.csv', __CRMFTPDESTPATH__, $name);
        // }
        // echo $ftp;
        // Helper::cLog($ftp);
        // die();
        // $host='80.253.151.2';
        // $user='root';
        // $pass='hp76hp1798';
        // $user='Sahar_Ertebat';
        // $pass='XxeNhfmq';
        // // connect to FTP server
        // $ftp_conn = ftp_connect($host) or die("Could not connect to $host");
        // //login to FTP server
        // $login = ftp_login($ftp_conn, $user, $pass);
        // // $file = fopen(__ROOT__."aaa.csv", "r") or die("Unable to open file!");
        // $file = "http://80.253.151.15/dump.csv";
        // // upload file
        // if (ftp_put($ftp_conn, "CRM/dump.csv", $file, FTP_ASCII))
        // {
        // echo "Successfully uploaded $file.";
        // }
        // else
        // {
        // echo "Error uploading $file.";
        // }

        // close connection
        // ftp_close($ftp_conn);
        // die();
        //////////////////////////
        // $ftp = ftp_connect($host);
        // $login=ftp_login($ftp, $user, $pass);
        // $ret = ftp_nb_put($ftp, 'aaa.csv', __ROOT__."aaa.csv", FTP_BINARY, FTP_AUTORESUME);
        // while (FTP_MOREDATA == $ret)
        //     {
        //         // display progress bar, or something
        //         $ret = ftp_nb_continue($ftp);
        //         Helper::cLog($ret);
        //     }
        //     $ftp=null;
        //     $login=null;
        //     die();
        /////////////////////////////
        // $tmpfname = tempnam(sys_get_temp_dir(), "Pre_");
        // $rename=rename($tmpfname, $tmpfname .= '.csv');
        // $res=Helper::crmFtpFilePutContents('amin.txt', 'qweqwe');
        // ftp_file_put_contents('my-file.txt', 'This text will be written to your text file via FTP.');
//////////////////////////////////
                
        
        // Function call
        // ftp_file_put_contents('my-file.txt', 'This text will be written to your text file via FTP.');
        // $ftp_server = "80.253.151.2";
        // $ftp_conn = ftp_connect($ftp_server);
        // $login = ftp_login($ftp_conn, 'Sahar_Ertebat', 'XxeNhfmq');
        // $remote_path = "/usr/CRA/CRM/test.csv";
        // $tmp_handle = fopen('php://temp', 'r+');

        // if (ftp_fget($ftp_conn, $tmp_handle, $remote_path, FTP_ASCII)) {
        //     rewind($tmp_handle);
        //     while ($csv_row = fgetcsv($tmp_handle)) {
        //         // do stuff
        //         echo 'yes';
        //     }
        // }else{
        //     die('no file found!');
        // }
        // fclose($tmp_handle);
        // die();
        /////////////////////////////ftp connection
        // connect and login to FTP server
        // $ftp_server = "80.253.151.2";
        // $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
        // $remote_path = "/usr/CRA/CRM/test.csv";
        // $login = ftp_login($ftp_conn, 'Sahar_Ertebat', 'XxeNhfmq');
        // $tmp_handle = fopen('php://temp', 'r+');
        // if (ftp_fget($ftp_conn, $tmp_handle, $remote_path, FTP_ASCII)) {
        //     rewind($tmp_handle);
        //     while ($csv_row = fgetcsv($tmp_handle)) {
        //         // do stuff
        //         Helper::cLog($csv_row);
        //     }
        // }else{
        //     die('no file found!');
        // }
        // die();
        // Helper::cLog($ftp_conn);
        // then do something...

        // close connection
        // ftp_close($ftp_conn);
        
        // $res = $GLOBALS['ibs_internet']->getConnectionLogs('2023-01-01 00:00:00', '2023-01-05 00:00:00');
        // $res = $GLOBALS['ibs_internet']->getAllInternetOnlineUsers();
        // $fd='2023-01-30';
        // $td=date('Y-m-d');
        // $res = CrmReport::reportByCustomDates($fd, $td);
        // // print_r(explode("^@*",$res));
        // Helper::cLog($res);
        // die();
        // $sql="SELECT
        //         f.id,
        //         f.type,
        //         f.subscriber_id subid,
        //         DATE_FORMAT(f.tarikhe_tasvie_shode,'%Y-%m-%d %H:%i') formatted_tarikhe_tasvie_shode,
        //         f.service_id,
        //         f.emkanat_id,
        //         sub.code_meli,
        //         ser.type sertype,
        //         IF(ser.noe_khadamat='BITSTREAM_ADSL','adsl',IF(ser.noe_khadamat='BITSTREAM_VDSL','vdsl',ser.type)) general_sertype,
        //         sl.jresponse,
        //         sl.response
        //     FROM bnm_factor f
        //         INNER JOIN shahkar_log sl ON sl.factor_id = f.id
        //         INNER JOIN bnm_services ser ON ser.id = f.service_id
        //         INNER JOIN bnm_subscribers sub ON sub.id = f.subscriber_id
        //     WHERE sl.response= '200'
        //         AND ser.noe_forosh IN ('adi', 'jashnvare', 'bulk')
        //         AND DATE(f.tarikhe_tasvie_shode) BETWEEN ? AND ?
        //         AND f.tasvie_shode = ?
        //         ORDER BY f.tarikhe_tasvie_shode DESC";
        // $res=Db::secure_fetchall($sql, [$fd, $td, 1]);
        // Helper::cLog(json_decode($res[0]['jresponse'],true));
        // for ($i=0; $i <count($res) ; $i++) { 

        //     $shid=json_decode($res[$i]['jresponse'],true);
        //     $shid=$shid['id'];
        //     Helper::cLog($shid);    
        // }
        // die();
        // $l2ip=ip2long("95.38.38.1");
        // // echo $l2ip;
        // // die();
        // // $res=SiamHelper::MacSearch('saharer','123', "f8e9.0390.6a14", '۱۴۰۱/۱۰/۰۱ ۱۱:۴۴', '۱۴۰۱/۱۱/۰۱ ۱۱:۴۴');
        // $res=SiamHelper::GetIPDR('saharer','123', '۱۴۰۱/۱۰/۰۱ ۱۱:۴۴', '۱۴۰۱/۱۱/۰۱ ۱۱:۴۴', '', '', "09034899814");
        // // $res=SiamHelper::TechnicalSearch('saharer','123', $l2ip);
        // Helper::cLog($res);
        // die();
        // $l2ip=ip2long("95.38.72.1");
        
        // $tel=Helper::regulateNumber('982144755050',2);
        
        

        // $arr      = ['a'=>[1,2]];
        // $username = '02144755050';
        // $res = $GLOBALS['ibs_internet']->getUserInfoByNormalUserName($username);
        // print_r(array_keys($res[1]));
        // if (isset($arr['b'][0])) {
            // Helper::cLog($res[1]);
        // } else {
            // Helper::cLog('no');
        // }
        // die();

        // $num=['111','222','333'];
        // $numl=$num[array_key_last($num)];
        // if(isset($num[array_key_last($num)-1])){
        //     $numsl=$num[array_key_last($num)-1];
        // }else{
        //     $numsl=false;
        // }
        // // $sql="SELECT * FROM bnm_subscribers WHERE code_meli LIKE '%".$tel[0]."'";
        // $res=Db::fetchall_Query($sql);
        // Helper::cLog([$numl,$numsl]);

        // die();
        // $res = SiamHelper::siamTel('۹۸۹1202476۹6', 1);
        // $res = SiamHelper::combinSearch('saharertebat', '123456789', '', '','سیامک');
        // $res = SiamHelper::combinSearch('saharertebat', '123456789', '', '', '', '', '', '', '0066187559','');
        // $res = SiamHelper::combinSearch('saharertebat', '123456789', '1133409828', '95.38.38.7', '', '', '', '', '','');
        // echo "<div style='direction:rtl;float:right'>".$res."</div>";
        // $res=SiamHelper::TechnicalSearch('saharertebat', '123456', '95.38.38.32');
        // $res=SiamHelper::TechnicalSearch2('saharertebat', '123456', '95.38.38.32');
        // $res=Helper::pdodbIpdrInstance();
        // $res=null;
        // $str_fdate = strtotime('-7 day', strtotime(date('Y-m-d H:i')));
        // $str_tdate = strtotime(date('Y-m-d H:i'));
        // die(Helper::cLog([$str_fdate, $str_tdate]));
        // $ip = "95.38.38.54";
        // $ip_split = explode('.', $ip);
        // $HEXIP = sprintf('%02x%02x%02x%02x', $ip_split[0], $ip_split[1], $ip_split[2], $ip_split[3]);
        // Helper::cLog($HEXIP);
        // $res=long2ip('95.38.38.54')
        // $res=ip2long('95.38.38.54');
        // echo $res;
        // die($res);
        // $res=strtotime("1669939144",);
        // echo $time = date("Y/m/d h:i:s","1673958080");
        // Helper::cLog($time);
        // die();

        // $sql="SELECT * FROM (SELECT *,INET_NTOA (ip) netip FROM tbl_ipdr LIMIT 100000) WHERE netip = '95.38.38.152'";
        // $sql="SELECT * FROM (SELECT *,INET_NTOA(ip) netip FROM tbl_ipdr) WHERE netip = '95.38.38.152'";
        // $sql="SELECT * FROM (SELECT *,INET_NTOA(ip) netip FROM tbl_ipdr ORDER BY ses_start LIMIT 1000)tmp WHERE netip = '95.38.38.54'";
        // $sql="SELECT * FROM (SELECT *,INET_NTOA(ip) netip FROM tbl_ipdr)tmp WHERE netip = '95.38.38.54'";
        // $sql="SELECT *,INET_NTOA (ip) netip FROM tbl_ipdr WHERE ses_start >= '1673278980' AND ses_end <='1673883780' AND ip = '1596335670'";
        // $sql="SELECT *,INET_NTOA (ip) netip FROM tbl_ipdr ORDER BY id DESC LIMIT 1000";
        // $users=$db->rawQuery($sql);
        // $db=null;
        // foreach ($users as $user) {
        //     print_r($user);
        // }
        // Helper::cLog($users);
        // die();

        // $users = $db->rawQuery('SELECT * FROM users WHERE name=:name', ['name' => 'user1']);
        // foreach ($users as $user) {
        //     print_r($user);
        // }

        // $sql="SELECT * FROM bnm_subscribers WHERE telephone1 LIKE". "'%"."?'";

        // $res=Db::secure_fetchall($sql,['2144755050']);
        // // $res=SiamHelper::TechnicalSearch('saharertebat', '123456789', '95.38.38.152');

        // // var_dump($res);
        // Helper::cLog($res);
        // die();
        // $res_factor=[];
        // $res_factor[0]=[];
        // $res_factor[0]['emkanat_id']=24;
        // $bsarr=[];
        // $bsarr['ranzhe']=1;
        // $bsarr['id']=$res_factor[0]['emkanat_id'];
        // $bsarr['laghv']=0;
        // $bsarr['jamavari']=0;
        // $sql=Helper::Update_Generator($bsarr, 'bnm_oss_reserves', "WHERE id = :id");
        // $res_bs=Db::secure_update_array($sql, $bsarr);
        // Helper::cLog($sql);
        // Helper::cLog($res_bs);
        // die();
        // $res=Helper::isWirelessUsername("w-1215w-123-0820195782");
        // return strtr(trim($string), array('۰'=>'0', '۱'=>'1', '۲'=>'2', '۳'=>'3', '۴'=>'4', '۵'=>'5', '۶'=>'6', '۷'=>'7', '۸'=>'8', '۹'=>'9', '٠'=>'0', '١'=>'1', '٢'=>'2', '٣'=>'3', '٤'=>'4', '٥'=>'5', '٦'=>'6', '٧'=>'7', '٨'=>'8', '٩'=>'9'));
        // print_r(array('۰'=>'0', '۱'=>'1', '۲'=>'2', '۳'=>'3', '۴'=>'4', '۵'=>'5', '۶'=>'6', '۷'=>'7', '۸'=>'8', 'c'=>'9', '٠'=>'0', '١'=>'1', '٢'=>'2', '٣'=>'3', '٤'=>'4', '٥'=>'5', '٦'=>'6', '٧'=>'7', '٨'=>'8', '٩'=>'9'));
        // echo "<br>";
        // print_r(array_flip(array('۰'=>'0', '۱'=>'1', '۲'=>'2', '۳'=>'3', '۴'=>'4', '۵'=>'5', '۶'=>'6', '۷'=>'7', '۸'=>'8', '۹'=>'9', '٠'=>'0', '١'=>'1', '٢'=>'2', '٣'=>'3', '٤'=>'4', '٥'=>'5', '٦'=>'6', '٧'=>'7', '٨'=>'8', '٩'=>'9')));
        // print_r(array_flip(['a'=>1,'b'=>2]));
        // echo "<br>";
        // $ipassign=[];
        // $ipassign[0]=[];
        // $ipassign[0]['tarikhe_shoroe_ip']='2022-01-01';
        // $res=Helper::TabdileTarikh($ipassign[0]['tarikhe_shoroe_ip']." "."00:00", 1, '-', '/', false );
        // $ipassign[0]['tarikhe_shoroe_ip']=Helper::fixDateDigit($ipassign[0]['tarikhe_shoroe_ip']);
        // echo $ipassign;
        // Helper::cLog($res);
        // $res=Helper::siamTelephoneForResult('02144755050');
        // var_dump($ipassign);
        // print_r(array_reverse(array('۰'=>'0', '۱'=>'1', '۲'=>'2', '۳'=>'3', '۴'=>'4', '۵'=>'5', '۶'=>'6', '۷'=>'7', '۸'=>'8', '۹'=>'9', '٠'=>'0', '١'=>'1', '٢'=>'2', '٣'=>'3', '٤'=>'4', '٥'=>'5', '٦'=>'6', '٧'=>'7', '٨'=>'8', '٩'=>'9')));
        // echo "<br>";
        // Helper::cLog(array_reverse(array('۰'=>'0', '۱'=>'1', '۲'=>'2', '۳'=>'3', '۴'=>'4', '۵'=>'5', '۶'=>'6', '۷'=>'7', '۸'=>'8', '۹'=>'9', '٠'=>'0', '١'=>'1', '٢'=>'2', '٣'=>'3', '٤'=>'4', '٥'=>'5', '٦'=>'6', '٧'=>'7', '٨'=>'8', '٩'=>'9')));
        // die();
        // $tel='123465';
        // $cp='778899';
        // $name='';
        // $family='';
        // $cm='';
        // $ss='';
        // $in=[];
        //     ($tel)? $in['tel']      =$tel: $in['tel']='';
        //     ($name)? $in['name']    =$name: $in['name']='';
        //     ($family)? $in['family']=$family: $in['family']='';
        //     ($ss)? $in['ss']        =$ss: $in['ss']='';
        //     ($cp)? $in['cp']        =$cp: $in['cp']='';
        //     ($cm)? $in['cm']        =$cm: $in['cm']='';
        //     foreach($in as $x => $val){
        //         echo $x;
        //         echo "<br>";
        //     }
        //     die();
        // $str_fdate = strtotime('-180 day', strtotime(date('Y-m-d H:i')));
        // $str_tdate = strtotime(date('Y-m-d H:i'));
        // $db = new PDODb(['type' => __IPDRDBTYPE__,
        //     'host'      => __IPDRDBHOST__,
        //     'username'  => __IPDRDBUSERNAME__, 
        //     'password'  => __IPDRDBPASS__,
        //     'dbname'    => __IPDRDBDBNAME__,
        //     'port'      => __IPDRDBPORT__,
        //     'prefix'    => __IPDRDBPERFIX__,
        //     'charset'   => __IPDRDBCHARSET__]);
        // // if($ip) $db->where('ip', $ip);
        // $db->orderBy("ses_stop");
        // $res = $db->get("tbl_ipdr", 1000);

        // $str1="0051511215,N:51.32295,E:35.76280";
        
        // $str1="0051511215";
        
        // $str1="051511215";
        
        // $str1="2092200577";
        
        // $str1="9123092363";
        // $str1="w-15-051511215";
        
        // $str1="9123092363";
        // $str1="9123092363";
        // $str1="w-22-1234567819";
        // Helper::cLog(Helper::isMobile($str1));
        // Helper::cLog($str1[0]);
        // die();
        // $str1="2144755050";
        // $str1="02144755050";

        // $strtime = "1668643444";
        // $res=gmdate("Y-m-d H:i:s.u", $strtime);
        // strtotime()
        // $res=strtotime('2012-03-27 18:47:00');
        // $res = SiamHelper::MacSearch('saharertebat', '123456789', "d4ca.6d1c.542b", "۱۴۰۱/۱۰/۰۱ ۱۶:۱۶", "۱۴۰۱/۱۰/۱۶ ۱۶:۱۶");
        // $res = SiamHelper::PassChange('saharertebat', '123456789', 'qazwsx');
        // $tel = "982144755050";
        // $tel = "۹۸۲۱۴۴۷۵۵۰۵۰";
        // $tel = Helper::regulateNumber($tel);
        // if ($tel) {
        //     $formattedtel = "0" . substr($tel, 2);
        //     if (Helper::isMobile($formattedtel)) {
        //         $res = $formattedtel;
        //     } else {
        //         $res = $formattedtel;
        //     }
        // }
        // $res = SiamHelper::TechnicalSearch2('asd','123','1596335670');
        // Helper::cLog($res);
        // die();
        
        // $res = strtotime();
        // $res=date('Y-m-d H:i:s', 1669902137/1000);
        // $fdate = strtotime('-180 day', strtotime(date('Y-m-d H:i')));
        // $tdate = strtotime(date('Y-m-d H:i'));
        
        // Helper::cLog($res);
        // die();
        // $fdate="۱۴۰۱/۱۰/۱۶ ۱۶:۱۶";
        // $tdate="۱۴۰۱/۱۰/۱۶ ۱۶:۱۶";
        // $en_fdate=Helper::convert_numbers($fdate, false);
        // $en_tdate=Helper::convert_numbers($tdate, false);
        // $en_fdate= Helper::TabdileTarikh($en_fdate, 2, '/', '/', true );
        // $en_tdate= Helper::TabdileTarikh($en_tdate, 2, '/', '/', true );
        // $en_fdate= Helper::fixDateDigit($en_fdate, '/');
        // $en_tdate= Helper::fixDateDigit($en_tdate, '/');
        // $str_fdate = (string)strtotime($en_fdate);
        // $str_tdate = (string) strtotime($en_tdate);

        
        // $db = new PDODb(['type' => 'mysql',
        //     'host' => '80.253.151.18',
        //     'username' => 'ipdr', 
        //     'password' => 'ipdrdbpass',
        //     'dbname'=> 'jetsib_ts',
        //     'port' => 3306,
        //     'prefix' => '',
        //     'charset' => 'utf8']);
        // $db->where('service_name', 'admin');
        // $res = $db->get("tbl_ipdr", 100);
        // var_dump($res);
        // Helper::cLog($res);
        // die();
        /////////getpackageusage
        // $res=DidebanHelper::getPackageUsageDetails("0jh312h3jkh12jk3hj132", '2144755050', "1401/01/01 00:00:00.000", "1401/05/17 23:59:59.999", '', 0);
        // $res=json_decode($res,true);
        // Helper::cLog($res);
        // die();
        // $res=Helper::toByteSize("656");
        // Helper::cLog($res);
        // die();
        $this->view->pagename = 'test';
        $this->view->render('test', 'dashboard_template', '/public/js/test.js', false);
    }

}
