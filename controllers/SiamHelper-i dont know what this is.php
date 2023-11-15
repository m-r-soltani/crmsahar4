<?php
class SiamHelper
{
// Https://IpAddress:port/..../DServices/....?WSDL
    public static function checkSubAlreadyAdded($sers, $subs){
        if(count($subs)===0) return true;
        $flag=true;
        for ($i=0; $i <count($subs) ; $i++) { 
            if($sers['subid']==$subs[$i]['id']){
                $flag=false;
            }
        }
        return $flag;
    }

    public static function combinSearch($username, $password, $tel = '', $ip = '', $name = '', $family = '', $ss = '', $code_posti = '', $code_meli = '', $passno = '')
    {
        
        $auth = self::authentication($username, $password);
        if(! $auth) return json_encode('QryResult=3'.self::sep('f')."نام کاربری یا رمز عبور اشتباه است", JSON_UNESCAPED_UNICODE);
        $regulatedip=false;
        $subs=false;
        if($ip) $regulatedip=Helper::regulateNumber($ip,1);
        if($regulatedip){
            $checkipexists=Helper::checkIpExist(Helper::regulateNumber($regulatedip, 1));
            if(! $checkipexists) return json_encode('QryResult=5'.self::sep('f')."DbError".self::sep('f').self::messages('ipnf'), JSON_UNESCAPED_UNICODE);   
        }
        $sa=[];
        // if($tel) $sa['telephone1']=self::siamTel($tel,1);
        if($tel){
            $formattedtel = self::siamTel($tel, 1);
            if (Helper::isMobile($formattedtel)) {
                $sa['telephone_hamrah'] = $formattedtel;
                $ismobile = true;
            } else {
                $sa['telephone1'] = $formattedtel;
            }
        }
        if($name) $sa['name']=$name;
        if($family) $sa['family']=$family;
        if($ss) Helper::regulateNumber($sa['shomare_shenasname']=$ss);
        if($code_posti) Helper::regulateNumber($sa['code_posti1']=$code_posti);
        if($code_meli) Helper::regulateNumber($sa['code_meli']=$code_meli);
        if($passno) Helper::regulateNumber($sa['passno']=$passno);
        $subs=self::combineSearchDynamicQuery($sa);
        if(! $subs && !$regulatedip) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        if($subs && $regulatedip){
            for ($i=0; $i <count($subs) ; $i++) { 
                $services=Helper::getInternetServiceInfoBySubidNoAuth($subs[$i]['id']);
                if(! $services){
                    unset($subs[$i]);
                    continue;
                }
                for ($s=0; $s <count($services) ; $s++){
                    if(! $services[$s]['ibsusername']){
                        continue;
                    }
                    $logs=$GLOBALS['ibs_internet']->getConnectionByUsernameAndRemoteIpDesc($services[$s]['ibsusername'], $regulatedip, false, false, 201);
                    if(! Helper::checkIbsResultStrict($logs)){
                        continue;
                    }
                    $subs[$i]['serviceinfo'][]=[$services[$s], $logs[1][1]];
                }

            }
        }elseif($subs && ! $regulatedip){
            for ($i=0; $i <count($subs) ; $i++) { 
                $services=Helper::getInternetServiceInfoBySubidNoAuth($subs[$i]['id']);
                if(! $services){
                    unset($subs[$i]);
                    continue;
                }
                for ($s=0; $s <count($services) ; $s++){
                    if(! $services[$s]['ibsusername']){
                        continue;
                    }
                    $logs=$GLOBALS['ibs_internet']->getConnectionByUsernameAndDateTimeDesc($services[$s]['ibsusername']);
                    if(! Helper::checkIbsResultStrict($logs)){
                        continue;
                    }
                    $subs[$i]['serviceinfo'][]=[$services[$s], $logs[1][1]];
                }
            }
        }else {
            $logs=$GLOBALS['ibs_internet']->getConnectionByRemoteIpAndDateTimeDesc($regulatedip, false, false, 2001);
            if(! Helper::checkIbsResultStrict($logs)){
                return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
            }
            $logs=$logs[1][1];
            
            $subs=[];
            $i=0;
            $allservices=Helper::getAllInternetUsersServicesInfoNoAuth();
            if(! $allservices) return json_encode('QryResult=5'.self::sep('f')."DbError".self::sep('f')."ارتباط با پایگاه داده قطع شده لطفا مجددا تلاش نمایید", JSON_UNESCAPED_UNICODE);
            
            
            // for ($l=0; $l <count($logs) ; $l++) { 
            //     for ($s=0; $s <count($allservices) ; $s++) {
            //         if(! $allservices[$s]['ibsusername']){
            //             continue;
            //         }
            //         if(Helper::like($logs[$l]['username'], $allservices[$s]['ibsusername'])){
            //             $subs[$i]['id']=$allservices[$s]['subid'];
            //             $subs[$i]['serviceinfo'][]=[$allservices[$s],$logs[$l]];
            //             $i++;                            
            //         }
                    
            //     }
            // }
        }
        //////
        if(! isset($subs)) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        if(! $subs) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        $subs=array_values($subs);
        if(! $subs) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        //let finish this shit
        $res=[];
        $z=0;
        for ($i=0; $i <count($subs) ; $i++) { 
            if(! isset($subs[$i])) continue;
            if(! isset($subs[$i]['id'])) continue;
            if(! $subs[$i]['id']) continue;
            if(! isset($subs[$i]['serviceinfo'])) continue;
            if(! isset($subs[$i]['serviceinfo'][0][0])) continue;
            if(! isset($subs[$i]['serviceinfo'][0][1])) continue;
            if(! $subs[$i]['serviceinfo']) continue;
            if(! $subs[$i]['serviceinfo'][0][0]) continue;
            if(! $subs[$i]['serviceinfo'][0][1]) continue;
            $lastf = false;
            $lastf = Helper::getServiceInfoLastFactorWithSubidEmkanatSertypeNoAuth($subs[$i]['id'], $subs[$i]['serviceinfo'][0][0]['emkanat_id'], $subs[$i]['serviceinfo'][0][0]['sertype']);
            $sql = "SELECT sub.*,c.name tabeiat_fa_name FROM bnm_subscribers sub
            INNER JOIN bnm_countries c ON c.id=sub.tabeiat WHERE sub.id = ?";
            $res_sub = Db::secure_fetchall($sql, [$subs[$i]['id']]);
            if(! $res_sub) continue; 
            if (!$lastf) continue;
            if ($lastf[0]['tabeiat']) {
                $nationality = Helper::getSubNationality($res_sub[0]['id']);
                $tabeiat     = $nationality[0]['fa_meliat'];
            } else {
                $tabeiat = '';
            }
            $res[$z][]= self::siamTel($lastf[0]['telephone1'], 2);
            $res[$z][]= Helper::regulateNumber($subs[$i]['serviceinfo'][0][1]['ipv4_address'], 2);
            $sesstart=date('Y-m-d H:i', strtotime($subs[$i]['serviceinfo'][0][1]['session_start_time']));
            $sesstop=date('Y-m-d H:i', strtotime($subs[$i]['serviceinfo'][0][1]['session_stop_time']));
            $res[$z][]= Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($sesstart, 1, '-', '/', false)), 2);
            $res[$z][]= Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($sesstop, 1, '-', '/', false)), 2);
            $res[$z][]= Helper::regulateNumber($lastf[0]['hadeaxar_sorat_daryaft'], 2) . " " . "Mb" ;
            $res[$z][]= $lastf[0]['general_sertype'] ;
            $res[$z][]= Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($lastf[0]['siam_tarikhe_tasvie_shode'], 1, '-', '/', false)), 2) ;
            $res[$z][]= Helper::regulateNumber($lastf[0]['code_meli'], 2) ;
            $res[$z][]= $lastf[0]['name'] ;
            $res[$z][]= $lastf[0]['f_name'] ;
            $res[$z][]= $lastf[0]['name_pedar'] ;
            $res[$z][]= $lastf[0]['shomare_shenasname'] ;
            $res[$z][]= Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($lastf[0]['tarikhe_tavalod'], 1, '-', '/', false)), 2) ;
            $res[$z][]= Helper::regulateNumber($lastf[0]['code_posti1'], 2) ;
            if ($lastf[0]['noe_moshtarak'] === "real") {
                $res[$z][]= $tabeiat ; //tabeiat
                $res[$z][]= $lastf[0]['passno'] ;
                $res[$z][]= $lastf[0]['address'] ;
                $res[$z][]= '' ;
                $res[$z][]= '' ;
                $res[$z][]= '' ;
                $res[$z][]= $lastf[0]['fa_noe_malekiat1'];
            } else {
                $res[$z][]= '' ; //tabeiat
                $res[$z][]= '' ;
                $res[$z][]= $lastf[0]['address'] ;
                $res[$z][]= $lastf[0]['name_sherkat'] ;
                $res[$z][]= Helper::regulateNumber($lastf[0]['shomare_sabt'], 1) ;
                $res[$z][]= Helper::regulateNumber($lastf[0]['code_eghtesadi'], 1) ;
                $res[$z][]= $lastf[0]['fa_noe_malekiat1'];
            }
            $z++;
        }
        if(! $res) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE); 
        $res=array_values($res);
        /////////////making result
        $qr="QryResult=";
        $firstKey=array_key_first($res);
        $lastkey=array_key_first($res);
        for ($i=0; $i <count($res) ; $i++) { 
            //rows
            for ($j=0; $j <count($res[$i]) ; $j++) { 
                if($res[$i][$j]){
                    // $qr.=$j.self::sep('f');
                    $qr.=$res[$i][$j].self::sep('f');
                }else{
                    // $qr.='qwe'.$j.self::sep('f');
                    $qr.=''.self::sep('f');
                }
            }
            $qr.=self::sep('r');
        }
        if(! $qr) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE); 
        $qr.="0";
        return json_encode($qr, JSON_UNESCAPED_UNICODE);


    }

    public static function combinSearch_notacceptable($username, $password, $tel = '', $ip = '', $name = '', $family = '', $ss = '', $code_posti = '', $code_meli = '', $passno = '')
    {
        
        $auth = self::authentication($username, $password);
        if(! $auth) return json_encode('QryResult=3'.self::sep('f')."نام کاربری یا رمز عبور اشتباه است", JSON_UNESCAPED_UNICODE);
        $regulatedip=false;
        $subs=false;
        if($ip) $regulatedip=Helper::regulateNumber($ip,1);
        if($regulatedip){
            $checkipexists=Helper::checkIpExist(Helper::regulateNumber($regulatedip, 1));
            if(! $checkipexists) return json_encode('QryResult=5'.self::sep('f')."DbError".self::sep('f').self::messages('ipnf'), JSON_UNESCAPED_UNICODE);   
        }
        $sa=[];
        // if($tel) $sa['telephone1']=self::siamTel($tel,1);
        if($tel){
            $formattedtel = self::siamTel($tel, 1);
            if (Helper::isMobile($formattedtel)) {
                $sa['telephone_hamrah'] = $formattedtel;
                $ismobile = true;
            } else {
                $sa['telephone1'] = $formattedtel;
            }
        }
        if($name) $sa['name']=$name;
        if($family) $sa['family']=$family;
        if($ss) Helper::regulateNumber($sa['shomare_shenasname']=$ss);
        if($code_posti) Helper::regulateNumber($sa['code_posti1']=$code_posti);
        if($code_meli) Helper::regulateNumber($sa['code_meli']=$code_meli);
        if($passno) Helper::regulateNumber($sa['passno']=$passno);
        $subs=self::combineSearchDynamicQuery($sa);
        if(! $subs && !$regulatedip) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        if($subs && $regulatedip){
            for ($i=0; $i <count($subs) ; $i++) {
                $services=Helper::getInternetServiceInfoBySubidNoAuth($subs[$i]['id']);
                if($services){
                    for ($s=0; $s <count($services) ; $s++){
                        if($services[$s]['ibsusername']){
                            $ibs=$GLOBALS['ibs_internet']->getConnectionByUsernameAndRemoteIpDesc($services[$s]['ibsusername'], $regulatedip, 2);
                            if(Helper::checkIbsResultExist($ibs)){
                                $subs[$i]['serviceinfo'][]=[$services[$s], $ibs[1][1][0]];
                            }else{
                                unset($subs[$i]);
                                continue;
                            }
                        }else{
                            unset($subs[$i]);
                            continue;
                        }
                    }
                }else{
                    unset($subs[$i]);
                    continue;
                }
            }
        }elseif($subs && ! $regulatedip){
            for ($i=0; $i <count($subs) ; $i++) {
                $services=Helper::getInternetServiceInfoBySubidNoAuth($subs[$i]['id']);
                if($services){
                    for ($s=0; $s <count($services) ; $s++){
                        $ibs=$GLOBALS['ibs_internet']->getConnectionByUsernameDesc($services[$s]['ibsusername'], 2);
                        if(Helper::checkIbsResultExist($ibs)){
                            $subs[$i]['serviceinfo'][]=[$services[$s], $ibs[1][1][0]];
                        }else{
                            unset($subs[$i]);
                            continue;
                        }
                    }
                }else{
                    unset($subs[$i]);
                    continue;
                }
            }
        }else {
            $resibs=$GLOBALS['ibs_internet']->getConnectionByRemoteIpDesc($regulatedip, 201);
            if($resibs){
                if(! Helper::checkIbsResultExist($resibs)){
                    return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
                }else{
                    $logs=$resibs[1][1];
                }
            }
            $subs=[];
            $i=0;
            $allservices=Helper::getAllInternetUsersServicesInfoNoAuth();
            if(! $allservices) return json_encode('QryResult=5'.self::sep('f')."DbError".self::sep('f')."ارتباط با پایگاه داده قطع شده لطفا مجددا تلاش نمایید", JSON_UNESCAPED_UNICODE);
            for ($l=0; $l <count($logs) ; $l++) { 
                for ($s=0; $s <count($allservices) ; $s++) {
                    if($allservices[$s]['ibsusername']){
                        if(Helper::like($logs[$l]['username'], $allservices[$s]['ibsusername']) && self::checkSubAlreadyAdded($allservices[$s], $subs)){
                            $subs[$i]['id']=$allservices[$s]['subid'];
                            $subs[$i]['serviceinfo'][]=[$allservices[$s],$logs[$l]];
                            $i++;                            
                        }
                    }
                }
            }
        }
        if(! isset($subs)) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        if(! $subs) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        $subs=array_values($subs);
        if(! $subs) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        //let finish this shit
        $res=[];
        $z=0;
        for ($i=0; $i <count($subs) ; $i++) { 
            if(! isset($subs[$i])) continue;
            if(! isset($subs[$i]['id'])) continue;
            if(! $subs[$i]['id']) continue;
            if(! isset($subs[$i]['serviceinfo'])) continue;
            if(! isset($subs[$i]['serviceinfo'][0][0])) continue;
            if(! isset($subs[$i]['serviceinfo'][0][1])) continue;
            if(! $subs[$i]['serviceinfo']) continue;
            if(! $subs[$i]['serviceinfo'][0][0]) continue;
            if(! $subs[$i]['serviceinfo'][0][1]) continue;
            $lastf = false;
            $lastf = Helper::getServiceInfoLastFactorWithSubidEmkanatSertypeNoAuth($subs[$i]['id'], $subs[$i]['serviceinfo'][0][0]['emkanat_id'], $subs[$i]['serviceinfo'][0][0]['sertype']);
            $sql = "SELECT sub.*,c.name tabeiat_fa_name FROM bnm_subscribers sub
            INNER JOIN bnm_countries c ON c.id=sub.tabeiat WHERE sub.id = ?";
            $res_sub = Db::secure_fetchall($sql, [$subs[$i]['id']]);
            if(! $res_sub) continue; 
            if (!$lastf) continue;
            if ($lastf[0]['tabeiat']) {
                $nationality = Helper::getSubNationality($res_sub[0]['id']);
                $tabeiat     = $nationality[0]['fa_meliat'];
            } else {
                $tabeiat = '';
            }
            $res[$z][]= self::siamTel($lastf[0]['telephone1'], 2);
            $res[$z][]= Helper::regulateNumber($subs[$i]['serviceinfo'][0][1]['ipv4_address'], 2);
            $sesstart=date('Y-m-d H:i', strtotime($subs[$i]['serviceinfo'][0][1]['session_start_time']));
            $sesstop=date('Y-m-d H:i', strtotime($subs[$i]['serviceinfo'][0][1]['session_stop_time']));
            $res[$z][]= Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($sesstart, 1, '-', '/', false)), 2);
            $res[$z][]= Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($sesstop, 1, '-', '/', false)), 2);
            $res[$z][]= Helper::regulateNumber($lastf[0]['hadeaxar_sorat_daryaft'], 2) . " " . "Mb" ;
            $res[$z][]= $lastf[0]['general_sertype'] ;
            $res[$z][]= Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($lastf[0]['siam_tarikhe_tasvie_shode'], 1, '-', '/', false)), 2) ;
            $res[$z][]= Helper::regulateNumber($lastf[0]['code_meli'], 2) ;
            $res[$z][]= $lastf[0]['name'] ;
            $res[$z][]= $lastf[0]['f_name'] ;
            $res[$z][]= $lastf[0]['name_pedar'] ;
            $res[$z][]= $lastf[0]['shomare_shenasname'] ;
            $res[$z][]= Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($lastf[0]['tarikhe_tavalod'], 1, '-', '/', false)), 2) ;
            $res[$z][]= Helper::regulateNumber($lastf[0]['code_posti1'], 2) ;
            if ($lastf[0]['noe_moshtarak'] === "real") {
                $res[$z][]= $tabeiat ; //tabeiat
                $res[$z][]= $lastf[0]['passno'] ;
                $res[$z][]= $lastf[0]['address'] ;
                $res[$z][]= '' ;
                $res[$z][]= '' ;
                $res[$z][]= '' ;
                $res[$z][]= $lastf[0]['fa_noe_malekiat1'];
            } else {
                $res[$z][]= '' ; //tabeiat
                $res[$z][]= '' ;
                $res[$z][]= $lastf[0]['address'] ;
                $res[$z][]= $lastf[0]['name_sherkat'] ;
                $res[$z][]= Helper::regulateNumber($lastf[0]['shomare_sabt'], 1) ;
                $res[$z][]= Helper::regulateNumber($lastf[0]['code_eghtesadi'], 1) ;
                $res[$z][]= $lastf[0]['fa_noe_malekiat1'];
            }
            $z++;
        }
        if(! $res) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE); 
        $res=array_values($res);
        /////////////making result
        $qr="QryResult=";
        $firstKey=array_key_first($res);
        $lastkey=array_key_first($res);
        for ($i=0; $i <count($res) ; $i++) { 
            //rows
            for ($j=0; $j <count($res[$i]) ; $j++) { 
                if($res[$i][$j]){
                    // $qr.=$j.self::sep('f');
                    $qr.=$res[$i][$j].self::sep('f');
                }else{
                    // $qr.='qwe'.$j.self::sep('f');
                    $qr.=''.self::sep('f');
                }
            }
            $qr.=self::sep('r');
        }
        if(! $qr) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE); 

        return json_encode($qr, JSON_UNESCAPED_UNICODE);


    }

    public static function combinSearch_old($username, $password, $tel = '', $ip = '', $name = '', $family = '', $ss = '', $code_posti = '', $code_meli = '', $passno = '')
    {
        $auth = self::authentication($username, $password);
        if(! $auth) return json_encode('QryResult=3'.self::sep('f')."نام کاربری یا رمز عبور اشتباه است", JSON_UNESCAPED_UNICODE);
        $ip_assign = false;
        $connectionlogs = false;
        $isfound = false;
        $user = false;
        $service = false;
        $username = false;
        $subinfo = [];
        //////flags & checks
        $ismobile = false;
        $searcharr = [];
        //search by ip
        //first we try to find data with ip
        if ($ip) {
            $ip_assign=Helper::getIpinfoByip(Helper::regulateNumber($ip, 1));
            if (! $ip_assign) {
                ///find user by connectionlogs
                $connectionlogs = $GLOBALS['ibs_internet']->getConnectionLogs(date("Y-m-d", strtotime("-6 months")) . " 00:00:00", date("Y-m-d") . " 23:59:59", null, Helper::regulateNumber($ip, 1));
                if ($connectionlogs) {
                    $lastkey = array_key_last($connectionlogs);
                    $username = $connectionlogs[$lastkey]['username'];
                    $allservices=Helper::getInternetUsersServicesInfoWithoutLogincheck();
                    for ($i=count($allservices); $i > 0 ; $i--) { 
                        if((string) $allservices[$i]['ibsusername'] === (string) $username){
                            // $subinfo['subid'] = $allservices[$i]['subid'];
                            // $subinfo['sertype'] = $allservices[$i]['type'];
                            // $subinfo['sertype'] = $allservices[$i]['emkanat_id'];
                            $tmp=$allservices[$i];
                            break;
                        }
                    }
                    if(isset($tmp)){
                        if($tmp){
                            $subinfo['howifoundit']='ibs';
                            $subinfo['hasassignedip']=false;
                            $subinfo['sertype']=$tmp['sertype'];
                            $subinfo['subid']=$tmp['subid'];
                            $subinfo['emkanat_id']=$tmp['emkanat_id'];
                        }
                    }
                }
                if(! $connectionlogs){
                    //todo ... 
                    //find by ipdr
                }
            } else {
                ///find user by ip_assign
                if ($ip_assign[0]['servicetype'] === "bandwidth") {
                    //band width
                    $subinfo['howifoundit']='ipassign';
                    $subinfo['hasassignedip']=true;
                    $subinfo['sertype'] = $ip_assign[0]['servicetype'];
                    if ($ip_assign[0]['servicetype'] === "bitstream") {
                        $subinfo['general_sertype'] = 'adsl';
                    } else {
                        $subinfo['general_sertype'] = $subinfo['sertype'];
                    }
                    $subinfo['subid'] = $ip_assign[0]['sub'];
                    $subinfo['ipaddress'] = $ip_assign[0]['ipaddress'];
                    $subinfo['taligh'] = $ip_assign[0]['taligh']; //1=yes//2=no
                    $subinfo['bandwidth'] = $ip_assign[0]['bandwidth']; //1=yes//2=no
                    $subinfo['tarikhe_shoroe_ip'] = $ip_assign[0]['tarikhe_shoroe_ip'];
                    $subinfo['tarikhe_payane_ip'] = $ip_assign[0]['tarikhe_payane_ip'];
                    $subinfo['tarikhe_talighe_ip'] = $ip_assign[0]['tarikhe_talighe_ip'];
                    $subinfo['tarikhe_shoroe_service'] = $ip_assign[0]['tarikhe_shoroe_service'];
                    $subinfo['tarikhe_payane_service'] = $ip_assign[0]['tarikhe_payane_service'];
                    $subinfo['tol'] = $ip_assign[0]['tol'];
                    $subinfo['arz'] = $ip_assign[0]['arz'];
                } else {
                    //adsl,vdsl,wireless,tdlte, bitstream
                    $services = Helper::getServiceInfoLastFactorWithSubidEmkanatSertypeNoAuth($ip_assign[0]['sub'], $ip_assign[0]['emkanat_id'], $ip_assign[0]['servicetype']);
                    $subinfo['howifoundit']='ipassign';
                    $subinfo['hasassignedip']=true;
                    $subinfo['sertype'] = $ip_assign[0]['servicetype'];
                    $subinfo['emkanat_id'] = $ip_assign[0]['emkanat_id'];
                    $subinfo['subid'] = $ip_assign[0]['sub'];
                    $subinfo['ipaddress'] = $ip_assign[0]['ipaddress'];
                    $subinfo['taligh'] = $ip_assign[0]['taligh']; //1=yes//2=no
                    $subinfo['bandwidth'] = $ip_assign[0]['bandwidth']; //1=yes//2=no
                    $subinfo['tarikhe_shoroe_ip'] = $ip_assign[0]['tarikhe_shoroe_ip'];
                    $subinfo['tarikhe_payane_ip'] = $ip_assign[0]['tarikhe_payane_ip'];
                    $subinfo['tarikhe_talighe_ip'] = $ip_assign[0]['tarikhe_talighe_ip'];
                    $subinfo['tarikhe_shoroe_service'] = $ip_assign[0]['tarikhe_shoroe_service'];
                    $subinfo['tarikhe_payane_service'] = $ip_assign[0]['tarikhe_payane_service'];
                    $subinfo['tol'] = $ip_assign[0]['tol'];
                    $subinfo['arz'] = $ip_assign[0]['arz'];
                }
            }
        }
        ////////////////////////////////////////////////search by user info
        //initializing $searcharr (dynamic)
        if ($tel) {
            // $formattedtel = Helper::regulateNumber("0" . substr($tel, 2),1);
            $formattedtel = self::siamTel($tel, 1);
            if (Helper::isMobile($formattedtel)) {
                $searcharr['telephone_hamrah'] = $formattedtel;
                $ismobile = true;
            } else {
                $searcharr['telephone1'] = $formattedtel;
            }
        }
        ($name) ? $searcharr['name'] = $name:'';
        ($family) ? $searcharr['f_name'] = $family:'';
        ($ss) ? $searcharr['shomare_shenasname'] = Helper::regulateNumber($ss,1):'';
        ($code_posti) ? $searcharr['code_posti1'] = Helper::regulateNumber($code_posti,1):'';
        ($code_meli) ? $searcharr['code_meli'] = Helper::regulateNumber($code_meli,1):'';
        if ($searcharr) {
            //we try to find user by what we have
            $sql = Helper::dynamicSelect($searcharr, 'bnm_subscribers', false, 'AND');
            $user = Db::secure_fetchall($sql, $searcharr);
            if (!$user) {
                //query with passport
                if ($passno) {
                    $searcharr['code_meli'] = Helper::regulateNumber($passno,1);
                    $searcharr['noe_shenase_hoviati'] = '1';
                    $sql = Helper::dynamicSelect($searcharr, 'bnm_subscribers', false, 'AND');
                    $user = Db::secure_fetchall($sql, $searcharr);
                }
            }
            if (!$user) {
                //try query with shenase meli
                if ($code_meli) {
                    //search by shenase meli
                    unset($searcharr['code_meli']);
                    unset($searcharr['noe_shenase_hoviati']);
                    $searcharr['shenase_meli'] = Helper::regulateNumber($code_meli,1);
                    $searcharr['noe_moshtarak'] = 'legal';
                    $sql = Helper::dynamicSelect($searcharr, 'bnm_subscribers', false, 'AND');
                    $user = Db::secure_fetchall($sql, $searcharr);
                }
            }
            // return $user;
            if ($user && ! isset($subinfo['howifoundit'])) {
                for ($i=0; $i <count($user) ; $i++) { 
                    // $userservices= Helper::getServiceInfoBySubidNoAuth($user[$i]['id']);
                    $userservices= Helper::getInternetServiceInfoBySubidNoAuth($user[$i]['id']);
                    if($userservices) break;
                }
                
                //fetch user services
                if (isset($userservices)) {
                    if ($userservices) {
                        $serinfo = self::findInternetServiceByAdslVdslPriority($userservices);
                        if ($serinfo) {
                            // $ipassign=Helper::
                            $subinfo['howifoundit'] = 'userinfo';
                            // $subinfo['howifoundit'] = $serinfo['userinfo'];
                            $subinfo['sertype'] = $serinfo['sertype'];
                            $subinfo['subid'] = $serinfo['subid'];
                            $subinfo['emkanat_id'] = $serinfo['emkanat_id'];
                        }
                    }
                }
            }
        }
        if(! isset($subinfo)) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        if(! $subinfo) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        $sql = "SELECT sub.*,c.name tabeiat_fa_name FROM bnm_subscribers sub
            INNER JOIN bnm_countries c ON c.id=sub.tabeiat WHERE sub.id = ?";
        $res_sub = Db::secure_fetchall($sql, [$subinfo['subid']]);
        if(! isset($res_sub)) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        if (!$res_sub) {
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }
        
        ///check all parameters with user info
            if ($name) {
                if ($name !== $res_sub[0]['name']) {
                    return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
                }
            }

            if ($family) {
                if ($family !== $res_sub[0]['f_name']) {
                    return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
                }
            }

            if ($ss) {
                if (Helper::regulateNumber($ss,1) !== $res_sub[0]['shomare_shenasname']) {
                    return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
                }
            }

            if ($code_posti) {
                if (Helper::regulateNumber($code_posti,1) !== $res_sub[0]['code_posti1']) {
                    return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
                }
            }

            if ($code_meli) {
                if (Helper::regulateNumber($code_meli,1) !== $res_sub[0]['code_meli']) {
                    return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
                }
            }

            if ($passno) {
                if ($res_sub[0]['noe_shenase_hoviati'] === 1) {
                    if (Helper::regulateNumber($passno,1) !== $res_sub[0]['code_meli']) {
                        return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
                    }
                }
            }
        ///all parameters are true compared to user info we can create result and done

        
        // if (!$lastf) return 'db Error';
        $qr = "QryResult=";
        // return $subinfo;
        // return $subinfo;
        switch ($subinfo['howifoundit']) {
            case 'ibs':
                $lastf = false;
                $lastf = Helper::getServiceInfoLastFactorWithSubidEmkanatSertypeNoAuth($subinfo['subid'], $subinfo['emkanat_id'], $subinfo['sertype']);
                if (!$lastf) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
                $ip_assign = Helper::getIpinfoBySubidEmkanatSertypeNoAuth($lastf[0]['subid'], $lastf[0]['emkanat_id'], $lastf[0]['sertype']);
                if ($ip_assign) {
                    //userinfo adsl,vdsl,wireless... with ipassigned
                    //todo... get last dynamic ip address by ibsng or ipdr
                    $subinfo['ipaddress']              = '';
                    $subinfo['hasassignedip']          = true;
                    $subinfo['ipaddress']              = $ip_assign[0]['ipaddress'];
                    $subinfo['taligh']                 = $ip_assign[0]['taligh']; //1=yes//2=no
                    $subinfo['bandwidth']              = $ip_assign[0]['bandwidth']; //1=yes//2=no
                    $subinfo['tarikhe_shoroe_ip']      = $ip_assign[0]['tarikhe_shoroe_ip'];
                    $subinfo['tarikhe_payane_ip']      = $ip_assign[0]['tarikhe_payane_ip'];
                    $subinfo['tarikhe_talighe_ip']     = $ip_assign[0]['tarikhe_talighe_ip'];
                    $subinfo['tarikhe_shoroe_service'] = $ip_assign[0]['tarikhe_shoroe_service'];
                    $subinfo['tarikhe_payane_service'] = $ip_assign[0]['tarikhe_payane_service'];
                    $subinfo['tol']                    = $ip_assign[0]['tol'];
                    $subinfo['arz']                    = $ip_assign[0]['arz'];
                    if ($lastf[0]['tabeiat']) {
                        $nationality = Helper::getSubNationality($res_sub[0]['id']);
                        $tabeiat     = $nationality[0]['fa_meliat'];
                    } else {
                        $tabeiat = '';
                    }
                    $qr .= self::siamTel($lastf[0]['telephone1'], 2) . self::sep('f');
                    $qr .= Helper::regulateNumber($subinfo['ipaddress'], 2) . self::sep('f');
                    $qr .= Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($subinfo['tarikhe_shoroe_ip'] . " " . "00:00", 1, '-', '/', false)), 2) . self::sep('f');
                    $qr .= Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($subinfo['tarikhe_payane_ip'] . " " . "00:00", 1, '-', '/', false)), 2) . self::sep('f');
                    $qr .= Helper::regulateNumber($lastf[0]['hadeaxar_sorat_daryaft'], 2) . " " . "Mb" . self::sep('f');
                    $qr .= $lastf[0]['general_sertype'] . self::sep('f');
                    $qr .= Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($lastf[0]['siam_tarikhe_tasvie_shode'], 1, '-', '/', false)), 2) . self::sep('f');
                    $qr .= Helper::regulateNumber($lastf[0]['code_meli'], 2) . self::sep('f');
                    $qr .= $lastf[0]['name'] . self::sep('f');
                    $qr .= $lastf[0]['f_name'] . self::sep('f');
                    $qr .= $lastf[0]['name_pedar'] . self::sep('f');
                    $qr .= $lastf[0]['shomare_shenasname'] . self::sep('f');
                    $qr .= Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($lastf[0]['tarikhe_tavalod'], 1, '-', '/', false)), 2) . self::sep('f');
                    $qr .= Helper::regulateNumber($lastf[0]['code_posti1'], 2) . self::sep('f');
                    if ($lastf[0]['noe_moshtarak'] === "real") {
                        $qr .= $tabeiat . self::sep('f'); //tabeiat
                        $qr .= $lastf[0]['passno'] . self::sep('f');
                        $qr .= $lastf[0]['address'] . self::sep('f');
                        $qr .= '' . self::sep('f');
                        $qr .= '' . self::sep('f');
                        $qr .= '' . self::sep('f');
                        $qr .= $lastf[0]['fa_noe_malekiat1'] . self::sep('r') . "0";
                    } else {
                        $qr .= '' . self::sep('f'); //tabeiat
                        $qr .= '' . self::sep('f');
                        $qr .= $lastf[0]['address'] . self::sep('f');
                        $qr .= $lastf[0]['name_sherkat'] . self::sep('f');
                        $qr .= Helper::regulateNumber($lastf[0]['shomare_sabt'], 1) . self::sep('f');
                        $qr .= Helper::regulateNumber($lastf[0]['code_eghtesadi'], 1) . self::sep('f');
                        $qr .= $lastf[0]['fa_noe_malekiat1'] . self::sep('r') . "0";
                    }
                }else{
                    //userinfo adsl,vdsl,wireless... no ip
                    if ($lastf[0]['tabeiat']) {
                        $nationality = Helper::getSubNationality($res_sub[0]['id']);
                        $tabeiat     = $nationality[0]['fa_meliat'];
                    } else {
                        $tabeiat = '';
                    }
                    $qr .= self::siamTel($lastf[0]['telephone1'], 2) . self::sep('f');
                    $qr .= ''. self::sep('f');
                    $qr .= ''. self::sep('f');
                    $qr .= ''. self::sep('f');
                    $qr .= Helper::regulateNumber($lastf[0]['hadeaxar_sorat_daryaft'], 2) . " " . "Mb" . self::sep('f');
                    $qr .= $lastf[0]['general_sertype'] . self::sep('f');
                    $qr .= Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($lastf[0]['siam_tarikhe_tasvie_shode'], 1, '-', '/', false)), 2) . self::sep('f');
                    $qr .= Helper::regulateNumber($lastf[0]['code_meli'], 2) . self::sep('f');
                    $qr .= $lastf[0]['name'] . self::sep('f');
                    $qr .= $lastf[0]['f_name'] . self::sep('f');
                    $qr .= $lastf[0]['name_pedar'] . self::sep('f');
                    $qr .= $lastf[0]['shomare_shenasname'] . self::sep('f');
                    $qr .= Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($lastf[0]['tarikhe_tavalod'], 1, '-', '/', false)), 2) . self::sep('f');
                    $qr .= Helper::regulateNumber($lastf[0]['code_posti1'], 2) . self::sep('f');
                    if ($lastf[0]['noe_moshtarak'] === "real") {
                        $qr .= $tabeiat . self::sep('f'); //tabeiat
                        $qr .= $lastf[0]['passno'] . self::sep('f');
                        $qr .= $lastf[0]['address'] . self::sep('f');
                        $qr .= '' . self::sep('f');
                        $qr .= '' . self::sep('f');
                        $qr .= '' . self::sep('f');
                        $qr .= $lastf[0]['fa_noe_malekiat1'] . self::sep('r') . "0";
                    } else {
                        $qr .= '' . self::sep('f'); //tabeiat
                        $qr .= '' . self::sep('f');
                        $qr .= $lastf[0]['address'] . self::sep('f');
                        $qr .= $lastf[0]['name_sherkat'] . self::sep('f');
                        $qr .= Helper::regulateNumber($lastf[0]['shomare_sabt'], 1) . self::sep('f');
                        $qr .= Helper::regulateNumber($lastf[0]['code_eghtesadi'], 1) . self::sep('f');
                        $qr .= $lastf[0]['fa_noe_malekiat1'] . self::sep('r') . "0";
                    }
                }
                

            break;
            case 'ipassign':
                if ($subinfo['sertype'] === "bandwidth") {
                    // $lastf = Helper::getServiceInfoLastFactorWithSubidEmkanatSertypeNoAuth($subinfo['subid'], $subinfo['emkanat_id'], $subinfo['sertype']);
                    // if (!$lastf) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
                    if($res_sub[0]['tabeiat']){
                        $nationality = Helper::getSubNationality($res_sub[0]['id']);
                        $tabeiat     = $nationality[0]['fa_meliat'];
                        // ($isirani==="IRN") ? $tabeiat = 'ایران' : $tabeiat = $isirani;
                    } else {
                        $tabeiat = '';
                    }
                    //ipassign bandwidth
                    $qr .= self::siamTel($res_sub[0]['telephone1'], 2).self::sep('f');
                    $qr .= Helper::regulateNumber($subinfo['ipaddress'],2).self::sep('f');
                    $qr .= Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($subinfo['tarikhe_shoroe_ip']." "."00:00", 1, '-', '/', false)),2).self::sep('f');
                    $qr .= Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($subinfo['tarikhe_payane_ip']." "."23:59", 1, '-', '/', false)),2).self::sep('f');
                    $qr .= Helper::regulateNumber($subinfo['bandwidth'],2)." "."Mb".self::sep('f');
                    $qr .= $subinfo['sertype'].self::sep('f');
                    $qr .= Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($subinfo['tarikhe_shoroe_service']." "."00:00", 1, '-', '/', false)),2).self::sep('f');
                    $qr .= Helper::regulateNumber($res_sub[0]['code_meli'],2).self::sep('f');
                    $qr .= $res_sub[0]['name'].self::sep('f');
                    $qr .= $res_sub[0]['f_name'].self::sep('f');
                    $qr .= $res_sub[0]['name_pedar'].self::sep('f');
                    $qr .= $res_sub[0]['shomare_shenasname'].self::sep('f');
                    $qr .= Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($res_sub[0]['tarikhe_tavalod'], 1, '-', '/', false)),2).self::sep('f');
                    $qr .= Helper::regulateNumber($res_sub[0]['code_posti1'],2).self::sep('f');
                    if($res_sub[0]['noe_moshtarak']==="real"){
                        //ipassign bandwidth real
                        $qr .= $tabeiat.self::sep('f');
                        if ($res_sub[0]['noe_shenase_hoviati']=== 1) {
                            $qr .= $res_sub[0]['code_meli'].self::sep('f');
                        } else {
                            $qr .= "".self::sep('f');
                        }
                        $address=$res_sub[0]['tel1_street'] . ' ' . $res_sub[0]['tel1_street2'] . ' پلاک ' . $res_sub[0]['tel1_housenumber'] . ' طبقه ' . $res_sub[0]['tel1_tabaghe'] . ' واحد ' . $res_sub[0]['tel1_vahed'];
                        $qr .= $address.self::sep('f');
                        $qr .= ''.self::sep('f');
                        $qr .= ''.self::sep('f');
                        $qr .= ''.self::sep('f');                     
                        if ($res_sub[0]['noe_malekiat1'] === 1) {
                            $noe_malekiat = 'مالک';
                        } else {
                            $noe_malekiat = 'مستاجر';
                        }
                        $qr .= $noe_malekiat.self::sep('r')."0";
                    } else {
                        //ipassign bandwidth legal
                        $qr .= ''.self::sep('f');//tabeiat
                        $qr .= ''.self::sep('f');
                        $address=$res_sub[0]['tel1_street'] . ' ' . $res_sub[0]['tel1_street2'] . ' پلاک ' . $res_sub[0]['tel1_housenumber'] . ' طبقه ' . $res_sub[0]['tel1_tabaghe'] . ' واحد ' . $res_sub[0]['tel1_vahed'];
                        $qr .= $address.self::sep('f');
                        $qr .= $res_sub[0]['name_sherkat'].self::sep('f');
                        $qr .= Helper::regulateNumber($res_sub[0]['shomare_sabt'],1).self::sep('f');
                        $qr .= Helper::regulateNumber($res_sub[0]['code_eghtesadi'],1).self::sep('f');
                        if ($res_sub[0]['noe_malekiat1'] === 1) {
                            $noe_malekiat = 'مالک';
                        } else {
                            $noe_malekiat = 'مستاجر';
                        }
                        $qr .= $noe_malekiat.self::sep('r')."0";
                    }
                } else {
                    //ipassign adsl wireless tdlte
                    $lastf = false;
                    $lastf = Helper::getServiceInfoLastFactorWithSubidEmkanatSertypeNoAuth($subinfo['subid'], $subinfo['emkanat_id'], $subinfo['sertype']);
                    if (!$lastf) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
                    if($lastf[0]['tabeiat']){
                        $nationality = Helper::getSubNationality($res_sub[0]['id']);
                        $tabeiat     = $nationality[0]['fa_meliat'];
                    } else {
                        $tabeiat = '';
                    }
                    $qr .= self::siamTel($lastf[0]['telephone1'], 2).self::sep('f');
                    $qr .= Helper::regulateNumber($subinfo['ipaddress'],2).self::sep('f');
                    $qr .= Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($subinfo['tarikhe_shoroe_ip']." "."00:00", 1, '-', '/', false)),2).self::sep('f');
                    $qr .= Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($subinfo['tarikhe_payane_ip']." "."00:00", 1, '-', '/', false)),2).self::sep('f');
                    $qr .= Helper::regulateNumber($lastf[0]['hadeaxar_sorat_daryaft'],2)." "."Mb".self::sep('f');
                    $qr .= $lastf[0]['general_sertype'].self::sep('f');
                    $qr .= Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($lastf[0]['siam_tarikhe_tasvie_shode'], 1, '-', '/', false)),2).self::sep('f');
                    $qr .= Helper::regulateNumber($lastf[0]['code_meli'],2).self::sep('f');
                    $qr .= $lastf[0]['name'].self::sep('f');
                    $qr .= $lastf[0]['f_name'].self::sep('f');
                    $qr .= $lastf[0]['name_pedar'].self::sep('f');
                    $qr .= $lastf[0]['shomare_shenasname'].self::sep('f');
                    $qr .= Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($lastf[0]['tarikhe_tavalod'], 1, '-', '/', false)),2).self::sep('f');
                    $qr .= Helper::regulateNumber($lastf[0]['code_posti1'],2).self::sep('f');
                    if($lastf[0]['noe_moshtarak']==="real"){
                        $qr .= $tabeiat.self::sep('f');//tabeiat
                        $qr .= $lastf[0]['passno'].self::sep('f');
                        $qr .= $lastf[0]['address'].self::sep('f');
                        $qr .= ''.self::sep('f');
                        $qr .= ''.self::sep('f');
                        $qr .= ''.self::sep('f');
                        $qr .= $lastf[0]['fa_noe_malekiat1'].self::sep('r')."0";
                    } else {
                        $qr .= ''.self::sep('f');//tabeiat
                        $qr .= ''.self::sep('f');
                        $qr .= $lastf[0]['address'].self::sep('f');
                        $qr .= $lastf[0]['name_sherkat'].self::sep('f');
                        $qr .= Helper::regulateNumber($lastf[0]['shomare_sabt'],1).self::sep('f');
                        $qr .= Helper::regulateNumber($lastf[0]['code_eghtesadi'],1).self::sep('f');
                        $qr .= $lastf[0]['fa_noe_malekiat1'].self::sep('r')."0";
                    }
                }
                return json_encode($qr, JSON_UNESCAPED_UNICODE);
            break;
            case 'userinfo':
                //userinfo adsl,vdsl,wireless,tdlte, bitstream
                $lastf = false;
                $lastf = Helper::getServiceInfoLastFactorWithSubidEmkanatSertypeNoAuth($subinfo['subid'], $subinfo['emkanat_id'], $subinfo['sertype']);
                if (!$lastf) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
                $ip_assign = Helper::getIpinfoBySubidEmkanatSertypeNoAuth($lastf[0]['subid'], $lastf[0]['emkanat_id'], $lastf[0]['sertype']);
                if ($ip_assign) {
                    //userinfo adsl,vdsl,wireless... with ipassigned
                    //todo... get last dynamic ip address by ibsng or ipdr
                    $subinfo['ipaddress']              = '';
                    $subinfo['hasassignedip']          = true;
                    $subinfo['ipaddress']              = $ip_assign[0]['ipaddress'];
                    $subinfo['taligh']                 = $ip_assign[0]['taligh']; //1=yes//2=no
                    $subinfo['bandwidth']              = $ip_assign[0]['bandwidth']; //1=yes//2=no
                    $subinfo['tarikhe_shoroe_ip']      = $ip_assign[0]['tarikhe_shoroe_ip'];
                    $subinfo['tarikhe_payane_ip']      = $ip_assign[0]['tarikhe_payane_ip'];
                    $subinfo['tarikhe_talighe_ip']     = $ip_assign[0]['tarikhe_talighe_ip'];
                    $subinfo['tarikhe_shoroe_service'] = $ip_assign[0]['tarikhe_shoroe_service'];
                    $subinfo['tarikhe_payane_service'] = $ip_assign[0]['tarikhe_payane_service'];
                    $subinfo['tol']                    = $ip_assign[0]['tol'];
                    $subinfo['arz']                    = $ip_assign[0]['arz'];
                    if ($lastf[0]['tabeiat']) {
                        $nationality = Helper::getSubNationality($res_sub[0]['id']);
                        $tabeiat     = $nationality[0]['fa_meliat'];
                    } else {
                        $tabeiat = '';
                    }
                    $qr .= self::siamTel($lastf[0]['telephone1'], 2) . self::sep('f');
                    $qr .= Helper::regulateNumber($subinfo['ipaddress'], 2) . self::sep('f');
                    $qr .= Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($subinfo['tarikhe_shoroe_ip'] . " " . "00:00", 1, '-', '/', false)), 2) . self::sep('f');
                    $qr .= Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($subinfo['tarikhe_payane_ip'] . " " . "00:00", 1, '-', '/', false)), 2) . self::sep('f');
                    $qr .= Helper::regulateNumber($lastf[0]['hadeaxar_sorat_daryaft'], 2) . " " . "Mb" . self::sep('f');
                    $qr .= $lastf[0]['general_sertype'] . self::sep('f');
                    $qr .= Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($lastf[0]['siam_tarikhe_tasvie_shode'], 1, '-', '/', false)), 2) . self::sep('f');
                    $qr .= Helper::regulateNumber($lastf[0]['code_meli'], 2) . self::sep('f');
                    $qr .= $lastf[0]['name'] . self::sep('f');
                    $qr .= $lastf[0]['f_name'] . self::sep('f');
                    $qr .= $lastf[0]['name_pedar'] . self::sep('f');
                    $qr .= $lastf[0]['shomare_shenasname'] . self::sep('f');
                    $qr .= Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($lastf[0]['tarikhe_tavalod'], 1, '-', '/', false)), 2) . self::sep('f');
                    $qr .= Helper::regulateNumber($lastf[0]['code_posti1'], 2) . self::sep('f');
                    if ($lastf[0]['noe_moshtarak'] === "real") {
                        $qr .= $tabeiat . self::sep('f'); //tabeiat
                        $qr .= $lastf[0]['passno'] . self::sep('f');
                        $qr .= $lastf[0]['address'] . self::sep('f');
                        $qr .= '' . self::sep('f');
                        $qr .= '' . self::sep('f');
                        $qr .= '' . self::sep('f');
                        $qr .= $lastf[0]['fa_noe_malekiat1'] . self::sep('r') . "0";
                    } else {
                        $qr .= '' . self::sep('f'); //tabeiat
                        $qr .= '' . self::sep('f');
                        $qr .= $lastf[0]['address'] . self::sep('f');
                        $qr .= $lastf[0]['name_sherkat'] . self::sep('f');
                        $qr .= Helper::regulateNumber($lastf[0]['shomare_sabt'], 1) . self::sep('f');
                        $qr .= Helper::regulateNumber($lastf[0]['code_eghtesadi'], 1) . self::sep('f');
                        $qr .= $lastf[0]['fa_noe_malekiat1'] . self::sep('r') . "0";
                    }
                }else{
                    //userinfo adsl,vdsl,wireless... no ip
                    if ($lastf[0]['tabeiat']) {
                        $nationality = Helper::getSubNationality($res_sub[0]['id']);
                        $tabeiat     = $nationality[0]['fa_meliat'];
                    } else {
                        $tabeiat = '';
                    }
                    $qr .= self::siamTel($lastf[0]['telephone1'], 2) . self::sep('f');
                    $qr .= ''. self::sep('f');
                    $qr .= ''. self::sep('f');
                    $qr .= ''. self::sep('f');
                    $qr .= Helper::regulateNumber($lastf[0]['hadeaxar_sorat_daryaft'], 2) . " " . "Mb" . self::sep('f');
                    $qr .= $lastf[0]['general_sertype'] . self::sep('f');
                    $qr .= Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($lastf[0]['siam_tarikhe_tasvie_shode'], 1, '-', '/', false)), 2) . self::sep('f');
                    $qr .= Helper::regulateNumber($lastf[0]['code_meli'], 2) . self::sep('f');
                    $qr .= $lastf[0]['name'] . self::sep('f');
                    $qr .= $lastf[0]['f_name'] . self::sep('f');
                    $qr .= $lastf[0]['name_pedar'] . self::sep('f');
                    $qr .= $lastf[0]['shomare_shenasname'] . self::sep('f');
                    $qr .= Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($lastf[0]['tarikhe_tavalod'], 1, '-', '/', false)), 2) . self::sep('f');
                    $qr .= Helper::regulateNumber($lastf[0]['code_posti1'], 2) . self::sep('f');
                    if ($lastf[0]['noe_moshtarak'] === "real") {
                        $qr .= $tabeiat . self::sep('f'); //tabeiat
                        $qr .= $lastf[0]['passno'] . self::sep('f');
                        $qr .= $lastf[0]['address'] . self::sep('f');
                        $qr .= '' . self::sep('f');
                        $qr .= '' . self::sep('f');
                        $qr .= '' . self::sep('f');
                        $qr .= $lastf[0]['fa_noe_malekiat1'] . self::sep('r') . "0";
                    } else {
                        $qr .= '' . self::sep('f'); //tabeiat
                        $qr .= '' . self::sep('f');
                        $qr .= $lastf[0]['address'] . self::sep('f');
                        $qr .= $lastf[0]['name_sherkat'] . self::sep('f');
                        $qr .= Helper::regulateNumber($lastf[0]['shomare_sabt'], 1) . self::sep('f');
                        $qr .= Helper::regulateNumber($lastf[0]['code_eghtesadi'], 1) . self::sep('f');
                        $qr .= $lastf[0]['fa_noe_malekiat1'] . self::sep('r') . "0";
                    }
                }
                
            break;
            default:
                return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
            break;
        }
        return json_encode($qr, JSON_UNESCAPED_UNICODE);

    }

    public static function TechnicalSearch($username, $password, $ip, $fdate, $tdate){
        $auth=self::authentication($username, $password);
        if(! $auth) return json_encode('QryResult=3'.self::sep('f')."نام کاربری یا رمز عبور اشتباه است", JSON_UNESCAPED_UNICODE);
        $regulatedip=Helper::regulateNumber($ip, 1);
        $checkipexists=Helper::checkIpExist(Helper::regulateNumber($regulatedip, 1));
        if(! $checkipexists) return json_encode('QryResult=5'.self::sep('f')."DbError".self::sep('f').self::messages('ipnf'), JSON_UNESCAPED_UNICODE);
        $en_fdate=Helper::regulateNumber($fdate);
        $en_tdate=Helper::regulateNumber($tdate);
        $dashed_enfdate=Helper::TabdileTarikh($en_fdate, 2, '/', '-', true);
        $dashed_entdate=Helper::TabdileTarikh($en_tdate, 2, '/', '-', true);
        $en_fdate= Helper::TabdileTarikh($en_fdate, 2, '/', '/', false );
        $en_tdate= Helper::TabdileTarikh($en_tdate, 2, '/', '/', false );
        $en_fdate= Helper::fixDateDigit($en_fdate, '/');
        $en_tdate= Helper::fixDateDigit($en_tdate, '/');
        $str_fdate = (string) strtotime($en_fdate);
        $str_tdate = (string) strtotime($en_tdate);
        $ibsresult=$GLOBALS['ibs_internet']->getConnectionByRemoteIpAndDateTimeDesc($regulatedip, $en_fdate, $en_tdate, 10000);
        if(! Helper::checkIbsResultStrict($ibsresult)){
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }
        $logs=$ibsresult[1][1];
        $services=Helper::getInternetServicesInfoWithIbsusernameNoAuth($logs[0]['username']);
        $subs=[];
        $i=0;
        if(! $services) return json_encode('QryResult=5'.self::sep('f')."DbError".self::sep('f')."ارتباط با پایگاه داده قطع شده لطفا مجددا تلاش نمایید", JSON_UNESCAPED_UNICODE);
        for ($l=0; $l <count($logs) ; $l++) { 
            for ($s=0; $s <count($services) ; $s++) {
                if($services[$s]['ibsusername']){
                    // $subs[$i]['id']=$services[$s]['subid'];
                    //     $subs[$i]['serviceinfo'][]=[$services[$s],$logs[$l]];
                    if(Helper::like($logs[$l]['username'], $services[$s]['ibsusername']) && self::checkSubAlreadyAdded($services[$s], $subs)){
                        $subs[$i]['id']=$services[$s]['subid'];
                        $subs[$i]['serviceinfo'][]=[$services[$s],$logs[$l]];
                        $i++;                            
                    }
                }
            }
        }
        if(! isset($subs)) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        if(! $subs) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        $subs=array_values($subs);
        $res=[];
        $z=0;
        for ($i=0; $i <count($subs) ; $i++) { 
            if(! isset($subs[$i])) continue;
            if(! isset($subs[$i]['id'])) continue;
            if(! $subs[$i]['id']) continue;
            if(! isset($subs[$i]['serviceinfo'])) continue;
            if(! isset($subs[$i]['serviceinfo'][0][0])) continue;
            if(! isset($subs[$i]['serviceinfo'][0][1])) continue;
            if(! $subs[$i]['serviceinfo']) continue;
            if(! $subs[$i]['serviceinfo'][0][0]) continue;
            if(! $subs[$i]['serviceinfo'][0][1]) continue;
            $lastf = false;
            $lastf = Helper::getServiceInfoLastFactorWithSubidEmkanatSertypeNoAuth($subs[$i]['id'], $subs[$i]['serviceinfo'][0][0]['emkanat_id'], $subs[$i]['serviceinfo'][0][0]['sertype']);
            $sql="SELECT *,DATE_FORMAT(tarikhe_sabtenam,'%Y-%m-%d %H:%i') siam_tarikhe_sabtenam FROM bnm_subscribers WHERE id = ?";
            $res_sub=Db::secure_fetchall($sql,[$services[0]['subid']]);
            if(! $res_sub) continue; 
            if (!$lastf) continue;
            if ($lastf[0]['tabeiat']) {
                $nationality = Helper::getSubNationality($res_sub[0]['id']);
                $tabeiat     = $nationality[0]['fa_meliat'];
            } else {
                $tabeiat = '';
            }
            $sql="SELECT *,name ostan_faname FROM bnm_ostan WHERE id = ?";
            $ostan=Db::secure_fetchall($sql,[$res_sub[0]['ostane_sokonat']]);
            if($ostan){
                $ostanesokonat=$ostan[0]['ostan_faname'];
            }else{
                $ostanesokonat='';
            }
            $sql="SELECT *,name shahr_faname FROM bnm_shahr WHERE id = ?";
            $shahr=Db::secure_fetchall($sql,[$res_sub[0]['shahre_sokonat']]);
            if($shahr){
                $shahresokonat=$shahr[0]['shahr_faname'];
            }else{
                $shahresokonat='';
            }
            $branchname="شبکه سحر ارتباط";
            $res[$z][]= (string)self::siamTel($services[0]['telephone1'], 2);
            $res[$z][]= (string)Helper::regulateNumber($logs[0]['ipv4_address'],2);
            $res[$z][]= (string)Helper::regulateNumber($lastf[0]['hadeaxar_sorat_daryaft'],2)." "."Mb";
            $res[$z][]= (string)$services[0]['general_sertype'];
            if($res_sub[0]['noe_shenase_hoviati']===0){
                $code_meli=$res_sub[0]['code_meli'];
            }else{
                $code_meli='';
            }
            $res[$z][]= (string)Helper::regulateNumber($code_meli,2);
            $res[$z][]= $res_sub[0]['name'];
            $res[$z][]= $res_sub[0]['f_name'];
            $res[$z][]= $res_sub[0]['name_pedar'];
            $res[$z][]= (string)$res_sub[0]['shomare_shenasname'];
            $res[$z][]= (string)Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($res_sub[0]['tarikhe_tavalod'], 1, '-', '/', false)),2);
            $res[$z][]= (string)Helper::regulateNumber($res_sub[0]['code_posti1'],2);
            if($res_sub[0]['noe_moshtarak']==="real"){
                if($res_sub[0]['tabeiat']){
                    $nationality = Helper::getSubNationality($res_sub[0]['id']);
                    if($nationality){
                        $tabeiat     = $nationality[0]['fa_meliat'];
                    }else{
                        $tabeiat     = '';
                    }
                } else {
                    $tabeiat = '';
                }
                if($res_sub[0]['noe_shenase_hoviati']===1){
                    $passno=$res_sub[0]['code_meli'];
                }else{
                    $passno='';
                }
                $res[$z][]= (string)$tabeiat;
                $res[$z][]= (string)$passno;
            }else{
                $res[$z][]= '';//tabiat
                $res[$z][]= '';//passno
            }
            $address=$res_sub[0]['tel1_street'] . ' ' . $res_sub[0]['tel1_street2'] . ' پلاک ' . $res_sub[0]['tel1_housenumber'] . ' طبقه ' . $res_sub[0]['tel1_tabaghe'] . ' واحد ' . $res_sub[0]['tel1_vahed'];
            $res[$z][]=$address;
            $res[$z][]=Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($res_sub[0]['siam_tarikhe_sabtenam'], 1, '-', '/', false)),2);
            $res[$z][]= Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($lastf[0]['siam_tarikhe_tasvie_shode'], 1, '-', '/', false)),2);
            if($res_sub[0]['noe_moshtarak']==="real"){
                $res[$z][]='';//name sherkat
                $res[$z][]='';//shomare sabt
                $res[$z][]='';//shomare eghtesadi
            }else{
                $res [$z][]= Helper::regulateNumber($res_sub[0]['name_sherkat'],1);
                $res [$z][]= Helper::regulateNumber($res_sub[0]['shomare_sabt'],1);
                $res [$z][]= Helper::regulateNumber($res_sub[0]['code_eghtesadi'],1);
            }
            $res[$z][]=$ostanesokonat;
            $res[$z][]=$shahresokonat;
            $res[$z][]=$branchname;
            if ($res_sub[0]['noe_malekiat1'] === 1) {
                $noe_malekiat = 'مالک';
            } else {
                $noe_malekiat = 'مستاجر';
            }
            $res[$z][]= $noe_malekiat;
            $res[$z][]="";//todo ... akharin tarikhe ghat ya talighe service
            $res[$z][]="";//todo ... moshakhase goroh ya vahede ghat konande
            $res[$z][]="اینترنت";
            $res[$z][]="PrePaid";
            $res[$z][]=$logs[0]['mac'];
            $res[$z][]='';//todo ... etelate daryafti az modem
            $res[$z][]=$services[0]['ibsusername'];//todo ... username
            $ibsinfo = Helper::getIbsUserinfoByUsernameAndSertype($services[0]['ibsusername']);
            if (isset($ibsinfo['attrs']['normal_password'])) {
                    $res[$z][]= $ibsinfo['attrs']['normal_password'];
                    // $res .= str_replace('.', ',', Helper::byteConvert((int) Helper::toByteSize((string) $ibsinfo['basic_info']['credit'] . 'MB')));
            } else {
                $res[$z][]= '';//password
            }
            if(isset($ibsinfo['basic_info']['credit'])){
                $res[$z][]= str_replace('.', ',', Helper::byteConvert((int) Helper::toByteSize((string) $ibsinfo['basic_info']['credit'] . 'MB')));
            }else{
                $res[$z][]= '';//mande etebar
            }
            $res[$z][]=Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh(Helper::unixTimestampToDateTime($logs[0]['session_start_time']), 1, '-', '/', false)),2);
            $res[$z][]=Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh(Helper::unixTimestampToDateTime($logs[0]['session_stop_time']), 1, '-', '/', false)),2);
            $res[$z][]=Helper::regulateNumber($logs[0]['user_id']);
        }
        if(! isset($res)) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE); 
        if(! $res) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE); 
        if(count($res)===0) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE); 
        $qr="QryResult=";
        $firstKey=array_key_first($res);
        $lastkey=array_key_first($res);
        for ($i=0; $i <count($res) ; $i++) { 
            //rows
            for ($j=0; $j <count($res[$i]) ; $j++) { 
                if($res[$i][$j]){
                    // $qr.=$j.self::sep('f');
                    $qr.=$res[$i][$j].self::sep('f');
                }else{
                    // $qr.='qwe'.$j.self::sep('f');
                    $qr.=''.self::sep('f');
                }
            }
            $qr.=self::sep('r');
        }
        if(! $qr) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE); 
        return json_encode($qr, JSON_UNESCAPED_UNICODE);        
    }

    public static function TechnicalSearch_old2($username, $password, $ip){
        $auth=self::authentication($username, $password);
        if(! $auth) return json_encode('QryResult=3'.self::sep('f')."نام کاربری یا رمز عبور اشتباه است", JSON_UNESCAPED_UNICODE);
        $regulatedip=Helper::regulateNumber($ip, 1);
        $checkipexists=Helper::checkIpExist(Helper::regulateNumber($regulatedip, 1));
        if(! $checkipexists) return json_encode('QryResult=5'.self::sep('f')."DbError".self::sep('f').self::messages('ipnf'), JSON_UNESCAPED_UNICODE);
        $ibsresult=$GLOBALS['ibs_internet']->getConnectionByRemoteIpAndDateTimeDesc($regulatedip,);
        if(! Helper::checkIbsResultStrict($ibsresult)){
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }
        $logs=$ibsresult[1][1];
        $services=Helper::getInternetServicesInfoWithIbsusernameNoAuth($logs[0]['username']);
        if(! $services){
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }
        // return $logs;
        //ipassign adsl wireless tdlte
        $sql="SELECT *,DATE_FORMAT(tarikhe_sabtenam,'%Y-%m-%d %H:%i') siam_tarikhe_sabtenam FROM bnm_subscribers WHERE id = ?";
        $res_sub=Db::secure_fetchall($sql,[$services[0]['subid']]);
        if(! $res_sub) return json_encode('QryResult=3'.self::sep('f').self::messages('in'), JSON_UNESCAPED_UNICODE);
        $sql="SELECT *,name ostan_faname FROM bnm_ostan WHERE id = ?";
        $ostan=Db::secure_fetchall($sql,[$res_sub[0]['ostane_sokonat']]);
        if($ostan){
            $ostanesokonat=$ostan[0]['ostan_faname'];
        }else{
            $ostanesokonat='';
        }
        $sql="SELECT *,name shahr_faname FROM bnm_shahr WHERE id = ?";
        $shahr=Db::secure_fetchall($sql,[$res_sub[0]['shahre_sokonat']]);
        if($shahr){
            $shahresokonat=$shahr[0]['shahr_faname'];
        }else{
            $shahresokonat='';
        }
        $branchname="شبکه سحر ارتباط";
        $qr = "QryResult=";
        $lastf = false;
        $lastf = Helper::getServiceInfoLastFactorWithSubidEmkanatSertypeNoAuth($services[0]['subid'], $services[0]['emkanat_id'], $services[0]['sertype']);
        
        if (!$lastf) return json_encode('QryResult=3'.self::sep('f').self::messages('in'), JSON_UNESCAPED_UNICODE);
        if($lastf[0]['tabeiat']){
            $nationality = Helper::getSubNationality($res_sub[0]['id']);
            $tabeiat     = $nationality[0]['fa_meliat'];
        } else {
            $tabeiat = '';
        }
        $qr .= (string)self::siamTel($services[0]['telephone1'], 2).self::sep('f');
        
        $qr .= (string)Helper::regulateNumber($logs[0]['ipv4_address'],2).self::sep('f');
        
        $qr .= (string)Helper::regulateNumber($lastf[0]['hadeaxar_sorat_daryaft'],2)." "."Mb".self::sep('f');
        $qr .= (string)$services[0]['general_sertype'].self::sep('f');
        if($res_sub[0]['noe_shenase_hoviati']===0){
            $code_meli=$res_sub[0]['code_meli'];
        }else{
            $code_meli='';
        }
        $qr .= (string)Helper::regulateNumber($code_meli,2).self::sep('f');
        $qr .= $res_sub[0]['name'].self::sep('f');
        $qr .= $res_sub[0]['f_name'].self::sep('f');
        $qr .= $res_sub[0]['name_pedar'].self::sep('f');
        $qr .= (string)$res_sub[0]['shomare_shenasname'].self::sep('f');
        $qr .= (string)Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($res_sub[0]['tarikhe_tavalod'], 1, '-', '/', false)),2).self::sep('f');
        $qr .= (string)Helper::regulateNumber($res_sub[0]['code_posti1'],2).self::sep('f');
        if($res_sub[0]['noe_moshtarak']==="real"){
            if($res_sub[0]['tabeiat']){
                $nationality = Helper::getSubNationality($res_sub[0]['id']);
                if($nationality){
                    $tabeiat     = $nationality[0]['fa_meliat'];
                }else{
                    $tabeiat     = '';
                }
            } else {
                $tabeiat = '';
            }
            if($res_sub[0]['noe_shenase_hoviati']===1){
                $passno=$res_sub[0]['code_meli'];
            }else{
                $passno='';
            }
            $qr .= (string)$tabeiat.self::sep('f');
            $qr .= (string)$passno.self::sep('f');
        }else{
            $qr .= ''.self::sep('f');//tabiat
            $qr .= ''.self::sep('f');//passno
        }
        $address=$res_sub[0]['tel1_street'] . ' ' . $res_sub[0]['tel1_street2'] . ' پلاک ' . $res_sub[0]['tel1_housenumber'] . ' طبقه ' . $res_sub[0]['tel1_tabaghe'] . ' واحد ' . $res_sub[0]['tel1_vahed'];
        $qr.=$address.self::sep('f');
        $qr.=Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($res_sub[0]['siam_tarikhe_sabtenam'], 1, '-', '/', false)),2).self::sep('f');
        $qr .= Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($lastf[0]['siam_tarikhe_tasvie_shode'], 1, '-', '/', false)),2).self::sep('f');
        if($res_sub[0]['noe_moshtarak']==="real"){
            $qr.=''.self::sep('f');//name sherkat
            $qr.=''.self::sep('f');//shomare sabt
            $qr.=''.self::sep('f');//shomare eghtesadi
        }else{
            $qr .= Helper::regulateNumber($res_sub[0]['name_sherkat'],1).self::sep('f');
            $qr .= Helper::regulateNumber($res_sub[0]['shomare_sabt'],1).self::sep('f');
            $qr .= Helper::regulateNumber($res_sub[0]['code_eghtesadi'],1).self::sep('f');
        }
        $qr.=$ostanesokonat.self::sep('f');
        $qr.=$shahresokonat.self::sep('f');
        $qr.=$branchname.self::sep('f');
        if ($res_sub[0]['noe_malekiat1'] === 1) {
            $noe_malekiat = 'مالک';
        } else {
            $noe_malekiat = 'مستاجر';
        }
        $qr .= $noe_malekiat.self::sep('f');
        $qr.="".self::sep('f');//todo ... akharin tarikhe ghat ya talighe service
        $qr.="".self::sep('f');//todo ... moshakhase goroh ya vahede ghat konande
        $qr.="اینترنت".self::sep('f');
        $qr.="PrePaid".self::sep('f');
        $qr.=$logs[0]['mac'].self::sep('f');
        $qr.=''.self::sep('f');//todo ... etelate daryafti az modem
        // return $subinfo;
        $qr.=$services[0]['ibsusername'].self::sep('f');//todo ... username
        
        $ibsinfo = Helper::getIbsUserinfoByUsernameAndSertype($services[0]['ibsusername']);
        // return $ibsinfo;
        if (isset($ibsinfo['attrs']['normal_password'])) {
                $qr .= $ibsinfo['attrs']['normal_password'] . self::sep('f');
                // $qr .= str_replace('.', ',', Helper::byteConvert((int) Helper::toByteSize((string) $ibsinfo['basic_info']['credit'] . 'MB'))). self::sep('f');
        } else {
            $qr .= '' . self::sep('f');//password
        }
        if(isset($ibsinfo['basic_info']['credit'])){
            $qr .= str_replace('.', ',', Helper::byteConvert((int) Helper::toByteSize((string) $ibsinfo['basic_info']['credit'] . 'MB'))). self::sep('f');
        }else{
            $qr .= '' . self::sep('f');//mande etebar
        }
        $qr.=Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh(Helper::unixTimestampToDateTime($logs[0]['session_start_time']), 1, '-', '/', false)),2);
        $qr.=Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh(Helper::unixTimestampToDateTime($logs[0]['session_stop_time']), 1, '-', '/', false)),2);
        $qr.=Helper::regulateNumber($logs[0]['user_id']);
        $qr.=self::sep('r')."0";
        return json_encode($qr, JSON_UNESCAPED_UNICODE);
    }

    public static function TechnicalSearch_old1($username, $password, $ip){
        $auth=self::authentication($username, $password);
        if(! $auth) return json_encode('QryResult=3'.self::sep('f')."نام کاربری یا رمز عبور اشتباه است", JSON_UNESCAPED_UNICODE);
        // if(! $auth) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        $subinfo=[];
        //ex:95.38.38.152
        //1- search in ipdr if not found 2
        //2- search by ibs
        //if not found return 0
        $regulatedip=Helper::regulateNumber($ip);
        try{
            $lip=ip2long($regulatedip);
            if(! $lip) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
            $db=Helper::pdodbIpdrInstance();
            if(! $db) return json_encode('QryResult=3'.self::sep('f').self::messages('dbe'), JSON_UNESCAPED_UNICODE);
            // $ipdr = $db->rawQuery('SELECT * FROM (SELECT *,INET_NTOA(ip) netip FROM tbl_ipdr WHERE ip = ? ORDER BY ses_stop DESC LIMIT 100)tmp ORDER BY ses_stop ASC', [$lip]);
            $ipdr = $db->rawQuery('SELECT * FROM (SELECT * FROM tbl_ipdr WHERE ip=? ORDER BY ses_start DESC LIMIT 100) qwe ORDER By ses_start ASC', [$lip]);
            // return $ipdr;
            if(! $ipdr) return json_encode('QryResult=3'.self::sep('f').self::messages('in'), JSON_UNESCAPED_UNICODE);
            $ipdr_last_username=$ipdr[array_key_last($ipdr)]['username'];
            //last ipdr row
            $ipdrl=$ipdr[array_key_last($ipdr)];
            //second to last ipdr row
            if(isset($ipdr[array_key_last($ipdr)-1])){
                $ipdrsl=$ipdr[array_key_last($ipdr)-1];
            }else{
                $ipdrsl=false;
            }
            $services=Helper::getInternetUsersServicesInfoWithoutLogincheck();
            if(! $services) return json_encode('QryResult=3'.self::sep('f').self::messages('dbe'), JSON_UNESCAPED_UNICODE);
            // $ip_assign=Helper::getIpinfoByip($regulatedip);
            $ip_assign=Helper::getIpinfoByip(Helper::regulateNumber($ip, 1));
            //find info by ipassign
            if ($ip_assign) {
                if ($ip_assign[0]['servicetype'] === "bandwidth") {
                    //band width
                    $subinfo['howifoundit']='ipassign';
                    $subinfo['hasassignedip']=true;
                    $subinfo['sertype'] = $ip_assign[0]['servicetype'];
                    if ($ip_assign[0]['servicetype'] === "bitstream") {
                        $subinfo['general_sertype'] = 'adsl';
                    } else {
                        $subinfo['general_sertype'] = $subinfo['sertype'];
                    }
                    $subinfo['subid'] = $ip_assign[0]['sub'];
                    $subinfo['ipaddress'] = $ip_assign[0]['ipaddress'];
                    $subinfo['taligh'] = $ip_assign[0]['taligh']; //1=yes//2=no
                    $subinfo['bandwidth'] = $ip_assign[0]['bandwidth']; //1=yes//2=no
                    $subinfo['tarikhe_shoroe_ip'] = $ip_assign[0]['tarikhe_shoroe_ip'];
                    $subinfo['tarikhe_payane_ip'] = $ip_assign[0]['tarikhe_payane_ip'];
                    $subinfo['tarikhe_talighe_ip'] = $ip_assign[0]['tarikhe_talighe_ip'];
                    $subinfo['tarikhe_shoroe_service'] = $ip_assign[0]['tarikhe_shoroe_service'];
                    $subinfo['tarikhe_payane_service'] = $ip_assign[0]['tarikhe_payane_service'];
                    $subinfo['tol'] = $ip_assign[0]['tol'];
                    $subinfo['arz'] = $ip_assign[0]['arz'];
                    $subinfo['username']=$ip_assign[0]['username'];
                    $subinfo['password']=$ip_assign[0]['password'];
                } else {
                    //adsl,vdsl,wireless,tdlte, bitstream
                    $services = Helper::getServiceInfoLastFactorWithSubidEmkanatSertypeNoAuth($ip_assign[0]['sub'], $ip_assign[0]['emkanat_id'], $ip_assign[0]['servicetype']);
                    $subinfo['howifoundit']='ipassign';
                    $subinfo['hasassignedip']=true;
                    $subinfo['sertype'] = $ip_assign[0]['servicetype'];
                    $subinfo['emkanat_id'] = $ip_assign[0]['emkanat_id'];
                    $subinfo['subid'] = $ip_assign[0]['sub'];
                    $subinfo['ipaddress'] = $ip_assign[0]['ipaddress'];
                    $subinfo['taligh'] = $ip_assign[0]['taligh']; //1=yes//2=no
                    $subinfo['bandwidth'] = $ip_assign[0]['bandwidth']; //1=yes//2=no
                    $subinfo['tarikhe_shoroe_ip'] = $ip_assign[0]['tarikhe_shoroe_ip'];
                    $subinfo['tarikhe_payane_ip'] = $ip_assign[0]['tarikhe_payane_ip'];
                    $subinfo['tarikhe_talighe_ip'] = $ip_assign[0]['tarikhe_talighe_ip'];
                    $subinfo['tarikhe_shoroe_service'] = $ip_assign[0]['tarikhe_shoroe_service'];
                    $subinfo['tarikhe_payane_service'] = $ip_assign[0]['tarikhe_payane_service'];
                    $subinfo['tol'] = $ip_assign[0]['tol'];
                    $subinfo['arz'] = $ip_assign[0]['arz'];
                }
            }
            
            //find info by userinfo
            if(! ($subinfo)){
                if(! ($subinfo)){
                    //search by ibsusername
                    // $serinfo=Helper::getInternetUsersServicesInfoWithoutLogincheck();
                    $serinfo=Helper::getInternetServicesInfoWithIbsusernameNoAuth($ipdr[0]['username']);
                    if($serinfo){
                        $serinfo=$serinfo[0];
                            $subinfo['howifoundit']='userinfo';
                            $subinfo['sertype']=$serinfo['sertype'];
                            $subinfo['emkanat_id']=$serinfo['emkanat_id'];
                            $subinfo['subid']=$serinfo['subid'];
                            $subinfo['username']=$serinfo['ibsusername'];
                    }
                }
                // if(Helper::isMobile($ipdr_last_username)){
                //     //search by mobile
                //     $sql="SELECT * FROM bnm_subscribers WHERE telephone_hamrah LIKE '%".$ipdr_last_username."'";
                //     $res=Db::fetchall_Query($sql);
                //     if($res){
                //         $serinfo=Helper::getInternetServiceInfoBySubidNoAuth($res[0]['id']);
                //         $serinfo=self::findInternetServiceByAdslVdslPriority($serinfo);
                //         if($serinfo){
                //             $subinfo['howifoundit']='userinfo';
                //             $subinfo['sertype']=$serinfo['sertype'];
                //             $subinfo['emkanat_id']=$serinfo['emkanat_id'];
                //             $subinfo['subid']=$serinfo['subid'];
                //         }
                //     }
                // }
                // if(! ($subinfo)){
                //     //search by telephone1
                //     $sql="SELECT * FROM bnm_subscribers WHERE telephone1 LIKE '%".$ipdr_last_username."'";
                //     $res=Db::fetchall_Query($sql);
                //     if($res){
                //         $serinfo=Helper::getInternetServiceInfoBySubidNoAuth($res[0]['id']);
                //         $serinfo=self::findInternetServiceByAdslVdslPriority($serinfo);
                //         if($serinfo){
                //             $subinfo['howifoundit']='userinfo';
                //             $subinfo['sertype']=$serinfo['sertype'];
                //             $subinfo['emkanat_id']=$serinfo['emkanat_id'];
                //             $subinfo['subid']=$serinfo['subid'];
                //             $subinfo['username']=$serinfo['ibsusername'];
                //         }
                //     }
                // }
                // if(! ($subinfo)){
                //     //search by code_meli
                //     $sql="SELECT * FROM bnm_subscribers WHERE code_meli =?";
                //     $res=Db::secure_fetchall($sql,[$ipdr_last_username]);
                //     // $res=Db::fetchall_Query($sql);
                //     if($res){
                //         $serinfo=Helper::getInternetServiceInfoBySubidNoAuth($res[0]['id']);
                //         $serinfo=self::findInternetServiceByAdslVdslPriority($serinfo);
                //         if($serinfo){
                //             $subinfo['howifoundit']='userinfo';
                //             $subinfo['sertype']=$serinfo['sertype'];
                //             $subinfo['emkanat_id']=$serinfo['emkanat_id'];
                //             $subinfo['subid']=$serinfo['subid'];
                //             $subinfo['username']=$serinfo['ibsusername'];
                //         }
                //     }
                // }
                
            }
            if(! ($subinfo)) {
                //todo... agar subinfo peyda nashod hachi az ipdr dari befrest ?
                return json_encode('QryResult=3'.self::sep('f').self::messages('in'), JSON_UNESCAPED_UNICODE);
            }
            if(! isset($subinfo['howifoundit'])) {
                //todo... agar subinfo peyda nashod hachi az ipdr dari befrest ?
                return json_encode('QryResult=0'.self::sep('f').'نتیجه ایی یافت نشد', JSON_UNESCAPED_UNICODE);
            }
            switch ($subinfo['howifoundit']) {
                case 'ipassign':
                    $sql="SELECT *,DATE_FORMAT(tarikhe_sabtenam,'%Y-%m-%d %H:%i') siam_tarikhe_sabtenam FROM bnm_subscribers WHERE id = ?";
                    $res_sub=Db::secure_fetchall($sql,[$subinfo['subid']]);
                    if(! $res_sub) return json_encode('QryResult=3'.self::sep('f').self::messages('in'), JSON_UNESCAPED_UNICODE);
                    $sql="SELECT *,name ostan_faname FROM bnm_ostan WHERE id = ?";
                    $ostan=Db::secure_fetchall($sql,[$res_sub[0]['ostane_sokonat']]);
                    if($ostan){
                        $ostanesokonat=$ostan[0]['ostan_faname'];
                    }else{
                        $ostanesokonat='';
                    }
                    $sql="SELECT *,name shahr_faname FROM bnm_shahr WHERE id = ?";
                    $shahr=Db::secure_fetchall($sql,[$res_sub[0]['shahre_sokonat']]);
                    if($shahr){
                        $shahresokonat=$shahr[0]['shahr_faname'];
                    }else{
                        $shahresokonat='';
                    }
                    $branchname="شبکه سحر ارتباط";
                    $qr = "QryResult=";
                    if ($subinfo['sertype'] === "bandwidth") {
                        $qr .= self::siamTel($res_sub[0]['telephone1'], 2).self::sep('f');
                        $qr .= Helper::regulateNumber($subinfo['ipaddress'],2).self::sep('f');
                        $qr .= Helper::regulateNumber($subinfo['bandwidth'],2)." "."Mb".self::sep('f');
                        $qr .= $subinfo['sertype'].self::sep('f');
                        if($res_sub[0]['noe_shenase_hoviati']===0){
                            $code_meli=$res_sub[0]['code_meli'];
                        }else{
                            $code_meli='';
                        }
                        $qr .= Helper::regulateNumber($code_meli,2).self::sep('f');
                        $qr .= $res_sub[0]['name'].self::sep('f');
                        $qr .= $res_sub[0]['f_name'].self::sep('f');
                        $qr .= $res_sub[0]['name_pedar'].self::sep('f');
                        $qr .= $res_sub[0]['shomare_shenasname'].self::sep('f');
                        $qr .= Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($res_sub[0]['tarikhe_tavalod'], 1, '-', '/', false)),2).self::sep('f');
                        $qr .= Helper::regulateNumber($res_sub[0]['code_posti1'],2).self::sep('f');
                        if($res_sub[0]['noe_moshtarak']==="real"){
                            if($res_sub[0]['tabeiat']){
                                $nationality = Helper::getSubNationality($res_sub[0]['id']);
                                if($nationality){
                                    $tabeiat     = $nationality[0]['fa_meliat'];
                                }else{
                                    $tabeiat     = '';
                                }
                            } else {
                                $tabeiat = '';
                            }
                            if($res_sub[0]['noe_shenase_hoviati']===1){
                                $passno=$res_sub[0]['code_meli'];
                            }else{
                                $passno='';
                            }
                            $qr .= $tabeiat.self::sep('f');
                            $qr .= $passno.self::sep('f');
                        }else{
                            $qr .= ''.self::sep('f');//tabiat
                            $qr .= ''.self::sep('f');//passno
                        }
                        $address=$res_sub[0]['tel1_street'] . ' ' . $res_sub[0]['tel1_street2'] . ' پلاک ' . $res_sub[0]['tel1_housenumber'] . ' طبقه ' . $res_sub[0]['tel1_tabaghe'] . ' واحد ' . $res_sub[0]['tel1_vahed'];
                        $qr.=$address.self::sep('f');
                        $qr.=Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($res_sub[0]['siam_tarikhe_sabtenam'], 1, '-', '/', false)),2).self::sep('f');
                        $qr .= Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($subinfo['tarikhe_shoroe_service']." "."00:00", 1, '-', '/', false)),2).self::sep('f');
                        if($res_sub[0]['noe_moshtarak']==="real"){
                            $qr.=''.self::sep('f');//name sherkat
                            $qr.=''.self::sep('f');//shomare sabt
                            $qr.=''.self::sep('f');//shomare eghtesadi
                        }else{
                            $qr .= Helper::regulateNumber($res_sub[0]['name_sherkat'],1).self::sep('f');
                            $qr .= Helper::regulateNumber($res_sub[0]['shomare_sabt'],1).self::sep('f');
                            $qr .= Helper::regulateNumber($res_sub[0]['code_eghtesadi'],1).self::sep('f');
                        }
                        $qr.=$ostanesokonat.self::sep('f');
                        $qr.=$shahresokonat.self::sep('f');
                        $qr.=$branchname.self::sep('f');
                        if ($res_sub[0]['noe_malekiat1'] === 1) {
                            $noe_malekiat = 'مالک';
                        } else {
                            $noe_malekiat = 'مستاجر';
                        }
                        $qr .= $noe_malekiat.self::sep('f');
                        $qr.="".self::sep('f');//todo ... akharin tarikhe ghat ya talighe service
                        $qr.="".self::sep('f');//todo ... moshakhase goroh ya vahede ghat konande
                        $qr.="اینترنت".self::sep('f');
                        $qr.="PrePaid".self::sep('f');
                        $qr.=$ipdrl['mac'].self::sep('f');
                        $qr.=''.self::sep('f');//todo ... etelate daryafti az modem
                        $qr.=$subinfo['username'].self::sep('f');//todo ... username
                        $qr.=$subinfo['password'].self::sep('f');//todo ... password
                        $qr.="".self::sep('f');
                        $qr.=Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh(Helper::unixTimestampToDateTime($ipdrsl['ses_stop']), 1, '-', '/', false)),2);
                        $qr.=Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh(Helper::unixTimestampToDateTime($ipdrl['ses_start']), 1, '-', '/', false)),2);
                        $qr.=Helper::regulateNumber($ipdrl['user_id']);
                        //tamam
                    } else {
                        //ipassign adsl wireless tdlte
                        $lastf = false;
                        $lastf = Helper::getServiceInfoLastFactorWithSubidEmkanatSertypeNoAuth($subinfo['subid'], $subinfo['emkanat_id'], $subinfo['sertype']);
                        if (!$lastf) return json_encode('QryResult=3'.self::sep('f').self::messages('in'), JSON_UNESCAPED_UNICODE);
                        if($lastf[0]['tabeiat']){
                            $nationality = Helper::getSubNationality($res_sub[0]['id']);
                            $tabeiat     = $nationality[0]['fa_meliat'];
                        } else {
                            $tabeiat = '';
                        }
                        $qr .= self::siamTel($lastf[0]['telephone1'], 2).self::sep('f');
                        $qr .= Helper::regulateNumber($subinfo['ipaddress'],2).self::sep('f');
                        $qr .= Helper::regulateNumber($lastf[0]['hadeaxar_sorat_daryaft'],2)." "."Mb".self::sep('f');
                        $qr .= $subinfo['sertype'].self::sep('f');
                        if($res_sub[0]['noe_shenase_hoviati']===0){
                            $code_meli=$res_sub[0]['code_meli'];
                        }else{
                            $code_meli='';
                        }
                        $qr .= Helper::regulateNumber($code_meli,2).self::sep('f');
                        $qr .= $res_sub[0]['name'].self::sep('f');
                        $qr .= $res_sub[0]['f_name'].self::sep('f');
                        $qr .= $res_sub[0]['name_pedar'].self::sep('f');
                        $qr .= $res_sub[0]['shomare_shenasname'].self::sep('f');
                        $qr .= Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($res_sub[0]['tarikhe_tavalod'], 1, '-', '/', false)),2).self::sep('f');
                        $qr .= Helper::regulateNumber($res_sub[0]['code_posti1'],2).self::sep('f');
                        if($res_sub[0]['noe_moshtarak']==="real"){
                            if($res_sub[0]['tabeiat']){
                                $nationality = Helper::getSubNationality($res_sub[0]['id']);
                                if($nationality){
                                    $tabeiat     = $nationality[0]['fa_meliat'];
                                }else{
                                    $tabeiat     = '';
                                }
                            } else {
                                $tabeiat = '';
                            }
                            if($res_sub[0]['noe_shenase_hoviati']===1){
                                $passno=$res_sub[0]['code_meli'];
                            }else{
                                $passno='';
                            }
                            $qr .= $tabeiat.self::sep('f');
                            $qr .= $passno.self::sep('f');
                        }else{
                            $qr .= ''.self::sep('f');//tabiat
                            $qr .= ''.self::sep('f');//passno
                        }
                        $address=$res_sub[0]['tel1_street'] . ' ' . $res_sub[0]['tel1_street2'] . ' پلاک ' . $res_sub[0]['tel1_housenumber'] . ' طبقه ' . $res_sub[0]['tel1_tabaghe'] . ' واحد ' . $res_sub[0]['tel1_vahed'];
                        $qr.=$address.self::sep('f');
                        $qr.=Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($res_sub[0]['siam_tarikhe_sabtenam'], 1, '-', '/', false)),2).self::sep('f');
                        $qr .= Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($lastf[0]['siam_tarikhe_tasvie_shode'], 1, '-', '/', false)),2).self::sep('f');
                        if($res_sub[0]['noe_moshtarak']==="real"){
                            $qr.=''.self::sep('f');//name sherkat
                            $qr.=''.self::sep('f');//shomare sabt
                            $qr.=''.self::sep('f');//shomare eghtesadi
                        }else{
                            $qr .= Helper::regulateNumber($res_sub[0]['name_sherkat'],1).self::sep('f');
                            $qr .= Helper::regulateNumber($res_sub[0]['shomare_sabt'],1).self::sep('f');
                            $qr .= Helper::regulateNumber($res_sub[0]['code_eghtesadi'],1).self::sep('f');
                        }
                        $qr.=$ostanesokonat.self::sep('f');
                        $qr.=$shahresokonat.self::sep('f');
                        $qr.=$branchname.self::sep('f');
                        if ($res_sub[0]['noe_malekiat1'] === 1) {
                            $noe_malekiat = 'مالک';
                        } else {
                            $noe_malekiat = 'مستاجر';
                        }
                        $qr .= $noe_malekiat.self::sep('f');
                        $qr.="".self::sep('f');//todo ... akharin tarikhe ghat ya talighe service
                        $qr.="".self::sep('f');//todo ... moshakhase goroh ya vahede ghat konande
                        $qr.="اینترنت".self::sep('f');
                        $qr.="PrePaid".self::sep('f');
                        $qr.=$ipdrl['mac'].self::sep('f');
                        $qr.=''.self::sep('f');//todo ... etelate daryafti az modem
                        $qr.=$subinfo['username'].self::sep('f');//todo ... username
                        // return 'asdasdasds';
                        $ibsinfo = Helper::getIbsUserinfoByUsernameAndSertype($lastf[0]['ibsusername']);

                        if (isset($ibsinfo['attrs']['normal_password'])) {
                                $qr .= $ibsinfo['attrs']['normal_password'] . self::sep('f');
                                // $qr .= str_replace('.', ',', Helper::byteConvert((int) Helper::toByteSize((string) $ibsinfo['basic_info']['credit'] . 'MB'))). self::sep('f');
                        } else {
                            $qr .= '' . self::sep('f');//password
                        }
                        if(isset($ibsinfo['basic_info']['credit'])){
                            $qr .= str_replace('.', ',', Helper::byteConvert((int) Helper::toByteSize((string) $ibsinfo['basic_info']['credit'] . 'MB'))). self::sep('f');
                        }else{
                            $qr .= '' . self::sep('f');//mande etebar
                        }
                        $qr.=Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh(Helper::unixTimestampToDateTime($ipdrsl['ses_stop']), 1, '-', '/', false)),2);
                        $qr.=Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh(Helper::unixTimestampToDateTime($ipdrl['ses_start']), 1, '-', '/', false)),2);
                        $qr.=Helper::regulateNumber($ipdrl['user_id']);
                    }
                break;
                case 'userinfo':
                    //ipassign adsl wireless tdlte
                    $sql="SELECT *,DATE_FORMAT(tarikhe_sabtenam,'%Y-%m-%d %H:%i') siam_tarikhe_sabtenam FROM bnm_subscribers WHERE id = ?";
                    $res_sub=Db::secure_fetchall($sql,[$subinfo['subid']]);
                    if(! $res_sub) return json_encode('QryResult=3'.self::sep('f').self::messages('in'), JSON_UNESCAPED_UNICODE);
                    $sql="SELECT *,name ostan_faname FROM bnm_ostan WHERE id = ?";
                    $ostan=Db::secure_fetchall($sql,[$res_sub[0]['ostane_sokonat']]);
                    if($ostan){
                        $ostanesokonat=$ostan[0]['ostan_faname'];
                    }else{
                        $ostanesokonat='';
                    }
                    $sql="SELECT *,name shahr_faname FROM bnm_shahr WHERE id = ?";
                    $shahr=Db::secure_fetchall($sql,[$res_sub[0]['shahre_sokonat']]);
                    if($shahr){
                        $shahresokonat=$shahr[0]['shahr_faname'];
                    }else{
                        $shahresokonat='';
                    }
                    $branchname="شبکه سحر ارتباط";
                    $qr = "QryResult=";
                    $lastf = false;
                    $lastf = Helper::getServiceInfoLastFactorWithSubidEmkanatSertypeNoAuth($subinfo['subid'], $subinfo['emkanat_id'], $subinfo['sertype']);
                    
                    if (!$lastf) return json_encode('QryResult=3'.self::sep('f').self::messages('in'), JSON_UNESCAPED_UNICODE);
                    if($lastf[0]['tabeiat']){
                        $nationality = Helper::getSubNationality($res_sub[0]['id']);
                        $tabeiat     = $nationality[0]['fa_meliat'];
                    } else {
                        $tabeiat = '';
                    }
                    $qr .= self::siamTel($lastf[0]['telephone1'], 2).self::sep('f');
                    $qr .= Helper::regulateNumber(long2ip($ipdrl['ip']),2).self::sep('f');
                    $qr .= Helper::regulateNumber($lastf[0]['hadeaxar_sorat_daryaft'],2)." "."Mb".self::sep('f');
                    $qr .= $subinfo['sertype'].self::sep('f');
                    if($res_sub[0]['noe_shenase_hoviati']===0){
                        $code_meli=$res_sub[0]['code_meli'];
                    }else{
                        $code_meli='';
                    }
                    $qr .= Helper::regulateNumber($code_meli,2).self::sep('f');
                    $qr .= $res_sub[0]['name'].self::sep('f');
                    $qr .= $res_sub[0]['f_name'].self::sep('f');
                    $qr .= $res_sub[0]['name_pedar'].self::sep('f');
                    $qr .= $res_sub[0]['shomare_shenasname'].self::sep('f');
                    $qr .= Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($res_sub[0]['tarikhe_tavalod'], 1, '-', '/', false)),2).self::sep('f');
                    $qr .= Helper::regulateNumber($res_sub[0]['code_posti1'],2).self::sep('f');
                    if($res_sub[0]['noe_moshtarak']==="real"){
                        if($res_sub[0]['tabeiat']){
                            $nationality = Helper::getSubNationality($res_sub[0]['id']);
                            if($nationality){
                                $tabeiat     = $nationality[0]['fa_meliat'];
                            }else{
                                $tabeiat     = '';
                            }
                        } else {
                            $tabeiat = '';
                        }
                        if($res_sub[0]['noe_shenase_hoviati']===1){
                            $passno=$res_sub[0]['code_meli'];
                        }else{
                            $passno='';
                        }
                        $qr .= $tabeiat.self::sep('f');
                        $qr .= $passno.self::sep('f');
                    }else{
                        $qr .= ''.self::sep('f');//tabiat
                        $qr .= ''.self::sep('f');//passno
                    }
                    $address=$res_sub[0]['tel1_street'] . ' ' . $res_sub[0]['tel1_street2'] . ' پلاک ' . $res_sub[0]['tel1_housenumber'] . ' طبقه ' . $res_sub[0]['tel1_tabaghe'] . ' واحد ' . $res_sub[0]['tel1_vahed'];
                    $qr.=$address.self::sep('f');
                    $qr.=Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($res_sub[0]['siam_tarikhe_sabtenam'], 1, '-', '/', false)),2).self::sep('f');
                    $qr .= Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($lastf[0]['siam_tarikhe_tasvie_shode'], 1, '-', '/', false)),2).self::sep('f');
                    if($res_sub[0]['noe_moshtarak']==="real"){
                        $qr.=''.self::sep('f');//name sherkat
                        $qr.=''.self::sep('f');//shomare sabt
                        $qr.=''.self::sep('f');//shomare eghtesadi
                    }else{
                        $qr .= Helper::regulateNumber($res_sub[0]['name_sherkat'],1).self::sep('f');
                        $qr .= Helper::regulateNumber($res_sub[0]['shomare_sabt'],1).self::sep('f');
                        $qr .= Helper::regulateNumber($res_sub[0]['code_eghtesadi'],1).self::sep('f');
                    }
                    $qr.=$ostanesokonat.self::sep('f');
                    $qr.=$shahresokonat.self::sep('f');
                    $qr.=$branchname.self::sep('f');
                    if ($res_sub[0]['noe_malekiat1'] === 1) {
                        $noe_malekiat = 'مالک';
                    } else {
                        $noe_malekiat = 'مستاجر';
                    }
                    $qr .= $noe_malekiat.self::sep('f');
                    $qr.="".self::sep('f');//todo ... akharin tarikhe ghat ya talighe service
                    $qr.="".self::sep('f');//todo ... moshakhase goroh ya vahede ghat konande
                    $qr.="اینترنت".self::sep('f');
                    $qr.="PrePaid".self::sep('f');
                    $qr.=$ipdrl['mac'].self::sep('f');
                    $qr.=''.self::sep('f');//todo ... etelate daryafti az modem
                    // return $subinfo;
                    $qr.=$subinfo['username'].self::sep('f');//todo ... username
                    
                    $ibsinfo = Helper::getIbsUserinfoByUsernameAndSertype($lastf[0]['ibsusername']);
                    // return $ibsinfo;
                    if (isset($ibsinfo['attrs']['normal_password'])) {
                            $qr .= $ibsinfo['attrs']['normal_password'] . self::sep('f');
                            // $qr .= str_replace('.', ',', Helper::byteConvert((int) Helper::toByteSize((string) $ibsinfo['basic_info']['credit'] . 'MB'))). self::sep('f');
                    } else {
                        $qr .= '' . self::sep('f');//password
                    }
                    if(isset($ibsinfo['basic_info']['credit'])){
                        $qr .= str_replace('.', ',', Helper::byteConvert((int) Helper::toByteSize((string) $ibsinfo['basic_info']['credit'] . 'MB'))). self::sep('f');
                    }else{
                        $qr .= '' . self::sep('f');//mande etebar
                    }
                    $qr.=Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh(Helper::unixTimestampToDateTime($ipdrsl['ses_stop']), 1, '-', '/', false)),2);
                    $qr.=Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh(Helper::unixTimestampToDateTime($ipdrl['ses_start']), 1, '-', '/', false)),2);
                    $qr.=Helper::regulateNumber($ipdrl['user_id']);
                    
                break;
                default:
                    return json_encode('QryResult=3'.self::sep('f').self::messages('in'), JSON_UNESCAPED_UNICODE);
                break;
            }
            //todo ... ? if ipdr && !isset subinfo
            if (isset($qr)) {
                if ($qr) {
                    return json_encode($qr.self::sep('r')."0", JSON_UNESCAPED_UNICODE);
                } else {
                    return json_encode('QryResult=3'.self::sep('f').self::messages('in'), JSON_UNESCAPED_UNICODE);    
                }
            } else {
                return json_encode('QryResult=3'.self::sep('f').self::messages('in'), JSON_UNESCAPED_UNICODE);
            }

        }catch(Exception $e){
            return json_encode('QryResult=3'.self::sep('f').self::messages('in'), JSON_UNESCAPED_UNICODE);
        }
        
     
    }

    public static function MacSearch($username, $password, $macaddr, $fdate, $tdate){
        $auth=self::authentication($username, $password);
        // if(! $auth) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        if(! $auth) return json_encode('QryResult=3'.self::sep('f')."نام کاربری یا رمز عبور اشتباه است", JSON_UNESCAPED_UNICODE);
        if(! $macaddr || ! $fdate || ! $tdate) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        $en_fdate=Helper::regulateNumber($fdate);
        $en_tdate=Helper::regulateNumber($tdate);
        $dashed_enfdate=Helper::TabdileTarikh($en_fdate, 2, '/', '-', true);
        $dashed_entdate=Helper::TabdileTarikh($en_tdate, 2, '/', '-', true);
        $en_fdate= Helper::TabdileTarikh($en_fdate, 2, '/', '/', false );
        $en_tdate= Helper::TabdileTarikh($en_tdate, 2, '/', '/', false );
        
        $en_fdate= Helper::fixDateDigit($en_fdate, '/');
        $en_tdate= Helper::fixDateDigit($en_tdate, '/');
        $str_fdate = (string) strtotime($en_fdate);
        $str_tdate = (string) strtotime($en_tdate);
        if(! $str_fdate || ! $str_tdate) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        $ibsresult=$GLOBALS['ibs_internet']->getConnectionsByMacAndDateTimeASC($macaddr, $dashed_enfdate, $dashed_entdate);
        if(! Helper::checkIbsResultStrict($ibsresult)){
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }
        $logs=$ibsresult[1][1];
        $services=Helper::getInternetUsersServicesInfoWithoutLogincheck();
        $qr='QryResult=';
        for ($i=0; $i <count($logs) ; $i++) { 
            ////mac
            $qr.=$macaddr.self::sep('f');
            ////start datetime
            $start_time=date("Y-m-d h:i", strtotime($logs[$i]['session_start_time']));
            $fa_fdate=Helper::TabdileTarikh($start_time, 1, '-', '/', true);
            $qr.=Helper::regulateNumber(Helper::fixDateDigit($fa_fdate, '/'), 2).self::sep('f');
            ////////stop datetime
            $end_time=date("Y-m-d h:i", strtotime($logs[$i]['session_stop_time']));
            $fa_tdate=Helper::TabdileTarikh($end_time, 1, '-', '/', true);
            $qr.=Helper::regulateNumber(Helper::fixDateDigit($fa_tdate, '/'), 2).self::sep('f');
            ///////////////////////alternativ not clean code
            // $ser=Helper::getInternetServicesInfoWithIbsusernameNoAuth($logs[$i]['username']);
            // if($ser){
            //     //telephne1
            //     $qr.=Helper::siamTelephoneForResult($services[0]['telephone1']).self::sep('f');
            //     //ip
            //     $qr.=$logs[$i]['ipv4_address'].self::sep('f');
            //     //sertype
            //     $qr.= strtoupper($services[0]['general_sertype']).self::sep('r');
            // }else{
            //     $qr.=self::sep('f');
            //     $qr.=self::sep('f');
            //     $qr.=self::sep('r').self::sep('f').self::messages('inf');
            // }
            ///////////////////////alternativ not clean code

            /////////////////////////todo... use preg_match
            for ($z=0; $z <count($services) ; $z++) { 
                if(Helper::like($logs[$i]['username'], $services[$z]['ibsusername'])){
                // if ($logs[$i]['username']===$services[$z]['ibsusername']) {
                    //telephone1
                    $qr.=Helper::siamTelephoneForResult($services[$z]['telephone1']).self::sep('f');
                    /////////ip
                    $qr.=$logs[$i]['ipv4_address'].self::sep('f');
                    ///sertype
                    $qr.= strtoupper($services[$z]['general_sertype']).self::sep('r');
                    break;
                }
            }
        }
        return json_encode($qr.="0", JSON_UNESCAPED_UNICODE);
    }

    public static function MacSearch_old($username, $password, $macaddr, $fdate, $tdate){
        
        $auth=self::authentication($username, $password);
        // if(! $auth) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        if(! $auth) return json_encode('QryResult=3'.self::sep('f')."نام کاربری یا رمز عبور اشتباه است", JSON_UNESCAPED_UNICODE);
        if(! $macaddr || ! $fdate || ! $tdate) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        $en_fdate=Helper::regulateNumber($fdate);
        $en_tdate=Helper::regulateNumber($tdate);
        $en_fdate= Helper::TabdileTarikh($en_fdate, 2, '/', '/', false );
        $en_tdate= Helper::TabdileTarikh($en_tdate, 2, '/', '/', false );
        $en_fdate= Helper::fixDateDigit($en_fdate, '/');
        $en_tdate= Helper::fixDateDigit($en_tdate, '/');
        $str_fdate = (string) strtotime($en_fdate);
        $str_tdate = (string) strtotime($en_tdate);
        if(! $str_fdate || ! $str_tdate) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        $db = Helper::pdodbIpdrInstance();
        $db->where('ses_start', $str_fdate, ">=");
        $db->where('ses_stop', $str_tdate, "<=");
        $db->where('mac', $macaddr);
        $db->orderBy("ses_start","ASC");
        $ipdr = $db->get("tbl_ipdr");
        return json_encode(json_encode($ipdr));
        $db=null;
        return json_encode('asddfgdfgfdgasdasd');
        if(! $ipdr) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        $ipdr_last_username=$ipdr[array_key_last($ipdr)]['username'];
        //last ipdr row
        $ipdrf=$ipdr[array_key_first($ipdr)];
        $ipdrl=$ipdr[array_key_last($ipdr)];
        //second to last ipdr row
        if(isset($ipdr[array_key_last($ipdr)-1])){
            $ipdrsl=$ipdr[array_key_last($ipdr)-1];
        }else{
            $ipdrsl=false;
        }
        $services=Helper::getInternetUsersServicesInfoWithoutLogincheck();
        if(! $services) return json_encode('QryResult=0',JSON_UNESCAPED_UNICODE);
        $ip_assign=Helper::getIpinfoByip(long2ip($ipdrl['ip']));
        //find info by ipassign
        if ($ip_assign) {
            if ($ip_assign[0]['servicetype'] === "bandwidth") {
                //band width
                $subinfo['howifoundit']='ipassign';
                $subinfo['hasassignedip']=true;
                $subinfo['sertype'] = $ip_assign[0]['servicetype'];
                if ($ip_assign[0]['servicetype'] === "bitstream") {
                    $subinfo['general_sertype'] = 'adsl';
                } else {
                    $subinfo['general_sertype'] = $subinfo['sertype'];
                }
                $subinfo['subid'] = $ip_assign[0]['sub'];
                $subinfo['ipaddress'] = $ip_assign[0]['ipaddress'];
                $subinfo['taligh'] = $ip_assign[0]['taligh']; //1=yes//2=no
                $subinfo['bandwidth'] = $ip_assign[0]['bandwidth']; //1=yes//2=no
                $subinfo['tarikhe_shoroe_ip'] = $ip_assign[0]['tarikhe_shoroe_ip'];
                $subinfo['tarikhe_payane_ip'] = $ip_assign[0]['tarikhe_payane_ip'];
                $subinfo['tarikhe_talighe_ip'] = $ip_assign[0]['tarikhe_talighe_ip'];
                $subinfo['tarikhe_shoroe_service'] = $ip_assign[0]['tarikhe_shoroe_service'];
                $subinfo['tarikhe_payane_service'] = $ip_assign[0]['tarikhe_payane_service'];
                $subinfo['tol'] = $ip_assign[0]['tol'];
                $subinfo['arz'] = $ip_assign[0]['arz'];
                $subinfo['username']=$ip_assign[0]['username'];
                $subinfo['password']=$ip_assign[0]['password'];
            } else {
                //adsl,vdsl,wireless,tdlte, bitstream
                $services = Helper::getServiceInfoLastFactorWithSubidEmkanatSertypeNoAuth($ip_assign[0]['sub'], $ip_assign[0]['emkanat_id'], $ip_assign[0]['servicetype']);
                $subinfo['howifoundit']='ipassign';
                $subinfo['hasassignedip']=true;
                $subinfo['sertype'] = $ip_assign[0]['servicetype'];
                $subinfo['emkanat_id'] = $ip_assign[0]['emkanat_id'];
                $subinfo['subid'] = $ip_assign[0]['sub'];
                $subinfo['ipaddress'] = $ip_assign[0]['ipaddress'];
                $subinfo['taligh'] = $ip_assign[0]['taligh']; //1=yes//2=no
                $subinfo['bandwidth'] = $ip_assign[0]['bandwidth']; //1=yes//2=no
                $subinfo['tarikhe_shoroe_ip'] = $ip_assign[0]['tarikhe_shoroe_ip'];
                $subinfo['tarikhe_payane_ip'] = $ip_assign[0]['tarikhe_payane_ip'];
                $subinfo['tarikhe_talighe_ip'] = $ip_assign[0]['tarikhe_talighe_ip'];
                $subinfo['tarikhe_shoroe_service'] = $ip_assign[0]['tarikhe_shoroe_service'];
                $subinfo['tarikhe_payane_service'] = $ip_assign[0]['tarikhe_payane_service'];
                $subinfo['tol'] = $ip_assign[0]['tol'];
                $subinfo['arz'] = $ip_assign[0]['arz'];
            }
        }
        //find info by userinfo
        if(! isset($subinfo)){
            if(! isset($subinfo)){
                //search by ibsusername
                $serinfo=Helper::getInternetUsersServicesInfoWithoutLogincheck();
                if($serinfo){
                    for ($i=0; $i <count($serinfo) ; $i++) { 
                        if($serinfo[$i]['ibsusername']===$ipdr_last_username){
                            $serinfo=$serinfo[$i];
                            $subinfo['howifoundit']='userinfo';
                            $subinfo['sertype']=$serinfo['sertype'];
                            $subinfo['emkanat_id']=$serinfo['emkanat_id'];
                            $subinfo['subid']=$serinfo['subid'];
                            break;
                        }
                    }
                }
            }
            if(Helper::isMobile($ipdr_last_username)){
                //search by mobile
                $sql="SELECT * FROM bnm_subscribers WHERE telephone_hamrah LIKE '%".$ipdr_last_username."'";
                $res=Db::fetchall_Query($sql);
                if($res){
                    $serinfo=Helper::getInternetServiceInfoBySubidNoAuth($res[0]['id']);
                    $serinfo=self::findInternetServiceByAdslVdslPriority($serinfo);
                    if($serinfo){
                        $subinfo['howifoundit']='userinfo';
                        $subinfo['sertype']=$serinfo['sertype'];
                        $subinfo['emkanat_id']=$serinfo['emkanat_id'];
                        $subinfo['subid']=$serinfo['subid'];
                    }
                }
            }
            if(! isset($subinfo)){
                //search by telephone1
                $sql="SELECT * FROM bnm_subscribers WHERE telephone1 LIKE '%".$ipdr_last_username."'";
                $res=Db::fetchall_Query($sql);
                if($res){
                    $serinfo=Helper::getInternetServiceInfoBySubidNoAuth($res[0]['id']);
                    $serinfo=self::findInternetServiceByAdslVdslPriority($serinfo);
                    if($serinfo){
                        $subinfo['howifoundit']='userinfo';
                        $subinfo['sertype']=$serinfo['sertype'];
                        $subinfo['emkanat_id']=$serinfo['emkanat_id'];
                        $subinfo['subid']=$serinfo['subid'];
                    }
                }
            }
            if(! isset($subinfo)){
                //search by code_meli
                $sql="SELECT * FROM bnm_subscribers WHERE code_meli =?";
                $res=Db::secure_fetchall($sql,[$ipdr_last_username]);
                // $res=Db::fetchall_Query($sql);
                if($res){
                    $serinfo=Helper::getInternetServiceInfoBySubidNoAuth($res[0]['id']);
                    $serinfo=self::findInternetServiceByAdslVdslPriority($serinfo);
                    if($serinfo){
                        $subinfo['howifoundit']='userinfo';
                        $subinfo['sertype']=$serinfo['sertype'];
                        $subinfo['emkanat_id']=$serinfo['emkanat_id'];
                        $subinfo['subid']=$serinfo['subid'];
                    }
                }
            }
            
        }
        if(! isset($subinfo)) {
            //todo... agar subinfo peyda nashod hachi az ipdr dari befrest ?
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }
        $sql="SELECT *,DATE_FORMAT(tarikhe_sabtenam,'%Y-%m-%d %H:%i') siam_tarikhe_sabtenam FROM bnm_subscribers WHERE id = ?";
        $res_sub=Db::secure_fetchall($sql,[$subinfo['subid']]);
        $qr = "QryResult=";
        if(! $res_sub) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        switch ($subinfo['howifoundit']) {
            case 'ipassign':        
                if ($subinfo['sertype'] === "bandwidth") {
                    $qr.=$macaddr.self::sep('f');
                    if($ipdrf){
                        $startdate=Helper::unixTimestampToDateTime($ipdrf['ses_start'], 'Y-m-d H:i');
                        $startdate=Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($startdate, 1, '-', '/', false)),2).self::sep('f');
                        $qr.=$startdate.self::sep('f');
                    }else{
                        $qr.=''.self::sep('f');
                    }
                    if($ipdrl){
                        $enddate=Helper::unixTimestampToDateTime($ipdrl['ses_stop'], 'Y-m-d H:i');
                        $enddate=Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($enddate, 1, '-', '/', false)),2).self::sep('f');
                        if($enddate){
                            $qr.=$enddate.self::sep('f');
                        }else{
                            $qr.=''.self::sep('f');    
                        }
                    }else{
                        $qr.=''.self::sep('f');
                    }
                    $qr.=Helper::regulateNumber($res_sub[0]['telephone1']).self::sep('f');
                    $qr.=Helper::regulateNumber($subinfo['ipaddress']).self::sep('f');
                    $qr.=$subinfo['sertype'].self::sep('f');
                } else {
                    //ipassign adsl wireless tdlte
                    $lastf = false;
                    $lastf = Helper::getServiceInfoLastFactorWithSubidEmkanatSertypeNoAuth($subinfo['subid'], $subinfo['emkanat_id'], $subinfo['sertype']);
                    if(! $lastf) return json_encode('QryResult=0',JSON_UNESCAPED_UNICODE);
                    $qr.=$macaddr.self::sep('f');
                    if($ipdrf){
                        $startdate=Helper::unixTimestampToDateTime($ipdrf['ses_start'], 'Y-m-d H:i');
                        $startdate=Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($startdate, 1, '-', '/', false)),2).self::sep('f');
                        $qr.=$startdate.self::sep('f');
                    }else{
                        $qr.=''.self::sep('f');
                    }
                    if($ipdrl){
                        $enddate=Helper::unixTimestampToDateTime($ipdrl['ses_stop'], 'Y-m-d H:i');
                        $enddate=Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($enddate, 1, '-', '/', false)),2).self::sep('f');
                        if($enddate){
                            $qr.=$enddate.self::sep('f');
                        }else{
                            $qr.=''.self::sep('f');    
                        }
                    }else{
                        $qr.=''.self::sep('f');
                    }
                    $qr.=Helper::regulateNumber($res_sub[0]['telephone1']).self::sep('f');
                    $qr.=Helper::regulateNumber($subinfo['ipaddress']).self::sep('f');
                    $qr.=$subinfo['sertype'].self::sep('f');
                }
            break;
            case 'userinfo':
                //userinfo adsl wireless tdlte
                $lastf = false;
                $lastf = Helper::getServiceInfoLastFactorWithSubidEmkanatSertypeNoAuth($subinfo['subid'], $subinfo['emkanat_id'], $subinfo['sertype']);
                if(! $lastf) return json_encode('QryResult=0',JSON_UNESCAPED_UNICODE);
                $qr.=$macaddr.self::sep('f');
                if($ipdrf){
                    $startdate=Helper::unixTimestampToDateTime($ipdrf['ses_start'], 'Y-m-d H:i');
                    $startdate=Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($startdate, 1, '-', '/', false)),2).self::sep('f');
                    $qr.=$startdate.self::sep('f');
                }else{
                    $qr.=''.self::sep('f');
                }
                if($ipdrl){
                    $enddate=Helper::unixTimestampToDateTime($ipdrl['ses_stop'], 'Y-m-d H:i');
                    $enddate=Helper::regulateNumber(Helper::fixDateDigit((string) Helper::TabdileTarikh($enddate, 1, '-', '/', false)),2).self::sep('f');
                    if($enddate){
                        $qr.=$enddate.self::sep('f');
                    }else{
                        $qr.=''.self::sep('f');    
                    }
                }else{
                    $qr.=''.self::sep('f');
                }
                $qr.=Helper::regulateNumber((string) $res_sub[0]['telephone1']).self::sep('f');
                $qr.=Helper::regulateNumber((string) long2ip($ipdrl['ip'])).self::sep('f');
                $qr.=$subinfo['sertype'];
            break;
            default:
                return json_encode('QryResult=0',JSON_UNESCAPED_UNICODE);
            break;
        }
        //todo ... ? if ipdr && !isset subinfo
        if (isset($qr)) {
            if ($qr) {
                return json_encode($qr.self::sep('r')."0",JSON_UNESCAPED_UNICODE);
            } else {
                return json_encode('QryResult=0',JSON_UNESCAPED_UNICODE);   
            }
        } else {
            return json_encode('QryResult=0',JSON_UNESCAPED_UNICODE);
        }
    }

    public static function ListOfBPlan($username, $password, $fdate, $tdate){
        $auth=self::authentication($username, $password);  
        // if(! $auth) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);     
        if(! $auth) return json_encode('QryResult=3'.self::sep('f')."نام کاربری یا رمز عبور اشتباه است", JSON_UNESCAPED_UNICODE);
        $en_fdate=  Helper::regulateNumber($fdate);
        $en_tdate= Helper::regulateNumber($tdate);
        $en_fdate= Helper::TabdileTarikh($en_fdate, 2, '/', '/', true );
        $en_tdate= Helper::TabdileTarikh($en_tdate, 2, '/', '/', true );
        $arr=[];
        $sql="SELECT
                f.id fid,
                ser.id serid,
                ser.shenase_service,
                ser.onvane_service,
                ser.tozihate_faktor,
                ser.zaname_estefade,
                ser.tarikhe_shoroe_namayesh,
                ser.tarikhe_payane_namayesh,
                ser.namayeshe_service
            FROM
                bnm_factor f 
            INNER JOIN bnm_services ser ON ser.id=f.service_id
            WHERE
                f.tasvie_shode = 1
            AND ser.noe_forosh IN ('adi','jashnvare')
            AND ser.type IN ('adsl', 'vdsl', 'bitstream', 'wireless', 'tdlte')
            AND tarikhe_factor BETWEEN ? AND ? ";
        $res=Db::secure_fetchall($sql, [$en_fdate, $en_tdate]);
        if(! $res) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        $qr = "QryResult=";
        for ($i=0; $i <count($res) ; $i++) {

            if($res[$i]['shenase_service']){
                $qr.=Helper::regulateNumber($res[$i]['shenase_service'],2).self::sep('f');
            }else{
                $qr.=''.self::sep('f');
            }
            ////////////////////////////
            if($res[$i]['onvane_service']){
                $qr.=$res[$i]['onvane_service'].self::sep('f');
            }else{
                $qr.=''.self::sep('f');
            }
            ////////////////////////////
            if($res[$i]['tozihate_faktor']){
                $qr.=$res[$i]['tozihate_faktor'].self::sep('f');
            }else{
                $qr.=''.self::sep('f');
            }
            ////////////////////////////
            if($res[$i]['zaname_estefade']){
                $qr.=$res[$i]['zaname_estefade']." "."روز".self::sep('f');
            }else{
                $qr.=''.self::sep('f');
            }
            ////////////////////////////
            if($res[$i]['namayeshe_service']==="no"){
                $qr.='غیر فعال'.self::sep('f');
            }else{
                if(($res[$i]['tarikhe_shoroe_namayesh'] <= date("Y-m-d H:i:s")) && ($res[$i]['tarikhe_payane_namayesh'] >= date("Y-m-d H:i:s")))
                {
                    $qr.='فعال'.self::sep('f');
                }else{
                    $qr.='غیر فعال'.self::sep('f');
                }
            }
            $qr .= self::sep('r')."0";
        }
        $qr .= "0";
        return json_encode($qr, JSON_UNESCAPED_UNICODE);
    }

    public static function GetIPDR($username, $password, $fdate, $tdate, $tel='', $ip='', $cid=''){
//         SELECT
// 	dip,
// 	domain,
// 	dport,
// 	group_name,
// 	ip,
// 	ip_p,
// 	mac,
// 	mac_p,
// 	net_name,
// 	rcv_btes,
// 	rcv_pkts,
// 	service_name,
// 	ses_start,
// 	ses_stop,
// 	sip,
// 	snd_bytes,
// 	snd_pkts,
// 	sport,
// 	url,
// 	user_id,
// 	username
// FROM
// 	tbl_ipdr t
// WHERE
// 	ses_start >= UNIX_TIMESTAMP( "2022-11-22 00:00:00" ) 
// 	AND ses_stop <= UNIX_TIMESTAMP(
// 	"2022-12-21 23:59:59")
        // return json_encode('asdasdasdasd');
        $auth=self::authentication($username, $password);
        // if(! $auth) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        if(! $auth) return json_encode('QryResult=3'.self::sep('f')."نام کاربری یا رمز عبور اشتباه است", JSON_UNESCAPED_UNICODE);
        if(!$tel && !$ip && !$cid) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        if($tel) {
            $ntel=self::siamTel($tel, 1);
        }
        $ipdr=false;
        if($ip){
            $ip2l=Helper::regulateNumber($ip);
            $ip2l=ip2long($ip);
        }
        $en_fdate   = Helper::regulateNumber($fdate);
        $en_tdate   = Helper::regulateNumber($tdate);
        $en_fdate   = Helper::TabdileTarikh($en_fdate, 2, '/', '/', false );
        $en_tdate   = Helper::TabdileTarikh($en_tdate, 2, '/', '/', false );
        $en_fdate   = Helper::fixDateDigit($en_fdate, '/');
        $en_tdate   = Helper::fixDateDigit($en_tdate, '/');
        $str_fdate  = (string) strtotime($en_fdate);
        $str_tdate  = (string) strtotime($en_tdate);
        /////
        $siam_date_limit   = Helper::Add_Or_Minus_Day_To_Date(180, '-', date('Y-m-d H:i:s'));
        if($str_fdate < strtotime($siam_date_limit) || $str_tdate < strtotime($siam_date_limit)){
            // return [$str_fdate,strtotime($siam_date_limit)];
            return json_encode('QryResult=3'.self::sep('f').'حداکثر میتوانید رکوردهای شش ماه گذشته را درخواست کنید', JSON_UNESCAPED_UNICODE);
        }
        if(! $str_fdate || ! $str_tdate) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        $year1=date("Y", $str_fdate);
        $year2=date("Y", $str_tdate);
        if(! $year1 || ! $year2) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        if($year1 === $year2){
            //query is second half of year
            $str_fdate=strtotime(date("Y-m-d H:i", $str_fdate). "-1 year");
            $str_tdate=strtotime(date("Y-m-d H:i", $str_tdate). "-1 year");
            $db = Helper::pdodbIpdrInstance();
            $db->where('ses_start', $str_fdate, ">=");
            $db->where('ses_stop', $str_tdate, "<=");
            if($cid){
                $db->where('user_id', $cid);
            }
            if($tel){
                $db->where('username', $ntel);
            }
            if($ip){
                $db->where('ip', $ip2l);
            }
            $db->orderBy("ses_start","DESC");
            $ipdr = $db->get("tbl_ipdr", 201);
            $db=null;
        }else{
            //query is first half of year
            //fdate
            $str_fdate1=strtotime(date("Y-m-d H:i", $str_fdate));
            $str_tdate1=strtotime(date("Y", $str_fdate)."-12-30 23:59:59");
            //tdate
            $str_fdate2=strtotime(date("Y", $str_tdate)."-01-01 00:00:00". "-1 year");
            $str_tdate2=strtotime(date("Y-m-d H:i", $str_tdate). "-1 year");
            // return [
            //     date("Y-m-d H:i",$str_fdate1),
            //     date("Y-m-d H:i",$str_tdate1),
            //     date("Y-m-d H:i",$str_fdate2),
            //     date("Y-m-d H:i",$str_tdate2)
            // ];
            //ipdr1
            $db = Helper::pdodbIpdrInstance();
            $db->where('ses_start', $str_fdate1, ">=");
            $db->where('ses_stop', $str_tdate1, "<=");
            if($cid) $db->where('user_id', $cid);
            if($tel) $db->where('username', $ntel);            
            if($ip) $db->where('ip', $ip2l);
            $db->orderBy("ses_start","DESC");
            $ipdr1 = $db->get("tbl_ipdr", 201);
            $db=null;
            //ipdr2
            $db = Helper::pdodbIpdrInstance();
            $db->where('ses_start', $str_fdate2, ">=");
            $db->where('ses_stop', $str_tdate2, "<=");
            if($cid) $db->where('user_id', $cid);
            if($tel) $db->where('username', $ntel);            
            if($ip) $db->where('ip', $ip2l);
            $db->orderBy("ses_start","DESC");
            $ipdr2 = $db->get("tbl_ipdr", 201);
            $db=null;
            if(! isset($ipdr1) && ! isset($ipdr2)) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
            if($ipdr1 && $ipdr2){
                $ipdr=array_merge($ipdr2, $ipdr1);
            }elseif($ipdr1 && ! $ipdr2){
                $ipdr=$ipdr1;
            }elseif (! $ipdr && $ipdr2) {
                $ipdr=$ipdr2;
            }else{
                return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
            }
        }
        if(! isset($ipdr)) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        if(! $ipdr) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        $moreavailble=false;
        if(count($ipdr)>200){
            // unset($ipdr[200]);
            for ($i=200; $i <count($ipdr) ; $i++) { 
                if(isset($ipdr[$i])){
                    unset($ipdr[$i]);
                }
            }
            $moreavailble=true;
        }
        $ipdr=array_values($ipdr);
        // return $ipdr;
        $res=[];
        $flag=false;
        $iswireless=false;
        $sertype='';
        $allservices=Helper::getAllInternetUsersServicesInfoNoAuth();
        $z=0;
        for ($i=0; $i <count($ipdr) ; $i++) { 
            for ($j=0; $j <count($allservices) ; $j++) { 
                if(Helper::like($ipdr[$i]['username'], $allservices[$j]['ibsusername'])){
                    $flag=true;
                    $sertype=$allservices[$j]['general_sertype'];
                    break;
                }
            }
            if(! $flag) continue;
            if(! strpos($ipdr[$i]['username'], 'w')){
                //  not wireless
                $res[$z][]=self::siamTel($ipdr[$i]['username'], 2);
                $iswireless=false;
            }else{
                //  wireless
                $iswireless=true;
                $res[$z][]=$ipdr[$i]['username'];
            }
            if(! $res[$z]) continue;
            $res[$z][]=Helper::regulateNumber(long2ip($ipdr[$i]['ip']),2);
            $res[$z][]=$ipdr[$i]['user_id'];
            $res[$z][]=strtoupper($sertype);
            // $res[$z][]=$ipdr[$i]['ses_stop'];
            // $res[$z][]=$ipdr[$i]['ses_stop'];
            $stdate=$ipdr[$i]['ses_start'];
            $stdate=Helper::unixTimestampToDateTime($stdate, 'Y-m-d H:i');
            $stdate=Helper::TabdileTarikh($stdate, 1, '-', '/',false);
            $stdate=Helper::fixDateDigit($stdate);
            $stdate=Helper::regulateNumber($stdate, 2);
            $res[$z][]=$stdate;
            $stopdate=$ipdr[$i]['ses_stop'];
            $stopdate=Helper::unixTimestampToDateTime($stopdate, 'Y-m-d H:i');
            $stopdate=Helper::TabdileTarikh($stopdate, 1, '-', '/',false);
            $stopdate=Helper::fixDateDigit($stopdate);
            $stopdate=Helper::regulateNumber($stopdate, 2);
            $res[$z][]=$stopdate;
            $res[$z][]=(string)long2ip($ipdr[$i]['sip']);
            $res[$z][]=(string)long2ip($ipdr[$i]['dip']);
            $res[$z][]=$ipdr[$i]['sport'];
            $res[$z][]=$ipdr[$i]['dport'];
            $res[$z][]=Helper::byteConvert($ipdr[$i]['snd_bytes']);
            $res[$z][]=Helper::byteConvert($ipdr[$i]['rcv_btes']);
            // $res[$z][]=$ipdr[$i]['rcv_btes'];
            // $res[$z][]=Helper::formatMac($ipdr[$i]['mac']);
            $res[$z][]=Helper::formatMac($ipdr[$i]['mac'], '%02s%02s.%02s%02s.%02s%02s','%02s:%02s:%02s:%02s:%02s:%02s');
            $res[$z][]=$ipdr[$i]['ip_p'];
            $res[$z][]="";
            $res[$z][]=$ipdr[$i]['url'];
            if($iswireless){
                $res[$z][]=$ipdr[$i]['user_id'];
            }else{
                $res[$z][]="";
            }
            $z++;
        }
        
        if(! isset($res)) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE); 
        if(! $res) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE); 
        $res=array_values($res);
        /////////////making result
        $qr="QryResult=";
        $firstKey=array_key_first($res);
        $lastkey=array_key_first($res);
        for ($i=0; $i <count($res) ; $i++) { 
            //rows
            for ($j=0; $j <count($res[$i]) ; $j++) { 
                if($res[$i][$j]){
                    // $qr.=$j.self::sep('f');
                    $qr.=$res[$i][$j].self::sep('f');
                }else{
                    // $qr.='qwe'.$j.self::sep('f');
                    $qr.=''.self::sep('f');
                }
            }
            $qr.=self::sep('r');
        }
        if(! $qr) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE); 
        if($moreavailble){
            $qr.="MoreAnswerExisting".self::sep('f')."تعداد رکوردهای پاسخ در بانک اطلاعاتی اپراتور از سقف تعیین شده برای ارسال بیشتر است";
        }
        return json_encode($qr, JSON_UNESCAPED_UNICODE);


        
       
        
    }

    public static function GetIPDR_old($username, $password, $fdate, $tdate, $tel='', $ip='', $cid=''){
        // return json_encode('asdasdasdasd');
        $auth=self::authentication($username, $password);
        // if(! $auth) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        if(! $auth) return json_encode('QryResult=3'.self::sep('f')."نام کاربری یا رمز عبور اشتباه است", JSON_UNESCAPED_UNICODE);
        if(!$tel && !$ip && !$cid) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        if($tel) {
            $ntel=self::siamTel($tel, 1);
        }
        $ipdr=false;
        if($ip){
            $ip2l=Helper::regulateNumber($ip);
            $ip2l=ip2long($ip);

        }
        $en_fdate= Helper::regulateNumber($fdate);
        $en_tdate= Helper::regulateNumber($tdate);
        $en_fdate= Helper::TabdileTarikh($en_fdate, 2, '/', '/', false );
        $en_tdate= Helper::TabdileTarikh($en_tdate, 2, '/', '/', false );
        $en_fdate= Helper::fixDateDigit($en_fdate, '/');
        $en_tdate= Helper::fixDateDigit($en_tdate, '/');
        // return json_encode($en_fdate."   ".$en_tdate);
        $sixagof=Helper::Add_Or_Minus_Day_To_Date('365', '-', $en_fdate, '/');
        // return json_encode($sixagof);
        $str_fdate = (string) strtotime($en_fdate);
        $str_tdate = (string) strtotime($en_tdate);
        if(! $str_fdate || ! $str_tdate) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        
        $db = Helper::pdodbIpdrInstance();
        $db->where('ses_start', $str_fdate, ">=");
        $db->where('ses_stop', $str_tdate, "<=");
        if($cid){
            $db->where('user_id', $cid);
        }
        if($tel){
            $db->where('username', $ntel);
        }
        if($ip){
            $db->where('ip', $ip2l);
        }
        $db->orderBy("ses_stop","DESC");
        $ipdr = $db->get("tbl_ipdr", 100);
        $db=null;
        if(! $ipdr) {
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }
        // return json_encode(json_encode($ipdr));
        $ipdr_last_username=$ipdr[array_key_last($ipdr)]['username'];
        //last ipdr row
        $ipdrf=$ipdr[array_key_first($ipdr)];
        $ipdrl=$ipdr[array_key_last($ipdr)];
        //second to last ipdr row
        if(isset($ipdr[array_key_last($ipdr)-1])){
            $ipdrsl=$ipdr[array_key_last($ipdr)-1];
        }else{
            $ipdrsl=false;
        }
        $services=Helper::getInternetUsersServicesInfoWithoutLogincheck();
        if(! $services) return json_encode('QryResult=0',JSON_UNESCAPED_UNICODE);


        $ip_assign=Helper::getIpinfoByip(long2ip($ipdrl['ip']));
        //find info by ipassign
        if ($ip_assign) {
            if ($ip_assign[0]['servicetype'] === "bandwidth") {
                //band width
                $subinfo['howifoundit']='ipassign';
                $subinfo['hasassignedip']=true;
                $subinfo['sertype'] = $ip_assign[0]['servicetype'];
                if ($ip_assign[0]['servicetype'] === "bitstream") {
                    $subinfo['general_sertype'] = 'adsl';
                } else {
                    $subinfo['general_sertype'] = $subinfo['sertype'];
                }
                $subinfo['subid'] = $ip_assign[0]['sub'];
                $subinfo['ipaddress'] = $ip_assign[0]['ipaddress'];
                $subinfo['taligh'] = $ip_assign[0]['taligh']; //1=yes//2=no
                $subinfo['bandwidth'] = $ip_assign[0]['bandwidth']; //1=yes//2=no
                $subinfo['tarikhe_shoroe_ip'] = $ip_assign[0]['tarikhe_shoroe_ip'];
                $subinfo['tarikhe_payane_ip'] = $ip_assign[0]['tarikhe_payane_ip'];
                $subinfo['tarikhe_talighe_ip'] = $ip_assign[0]['tarikhe_talighe_ip'];
                $subinfo['tarikhe_shoroe_service'] = $ip_assign[0]['tarikhe_shoroe_service'];
                $subinfo['tarikhe_payane_service'] = $ip_assign[0]['tarikhe_payane_service'];
                $subinfo['tol'] = $ip_assign[0]['tol'];
                $subinfo['arz'] = $ip_assign[0]['arz'];
                $subinfo['username']=$ip_assign[0]['username'];
                $subinfo['password']=$ip_assign[0]['password'];
            } else {
                //adsl,vdsl,wireless,tdlte, bitstream
                $services = Helper::getServiceInfoLastFactorWithSubidEmkanatSertypeNoAuth($ip_assign[0]['sub'], $ip_assign[0]['emkanat_id'], $ip_assign[0]['servicetype']);
                $subinfo['howifoundit']='ipassign';
                $subinfo['hasassignedip']=true;
                $subinfo['sertype'] = $ip_assign[0]['servicetype'];
                $subinfo['emkanat_id'] = $ip_assign[0]['emkanat_id'];
                $subinfo['subid'] = $ip_assign[0]['sub'];
                $subinfo['ipaddress'] = $ip_assign[0]['ipaddress'];
                $subinfo['taligh'] = $ip_assign[0]['taligh']; //1=yes//2=no
                $subinfo['bandwidth'] = $ip_assign[0]['bandwidth']; //1=yes//2=no
                $subinfo['tarikhe_shoroe_ip'] = $ip_assign[0]['tarikhe_shoroe_ip'];
                $subinfo['tarikhe_payane_ip'] = $ip_assign[0]['tarikhe_payane_ip'];
                $subinfo['tarikhe_talighe_ip'] = $ip_assign[0]['tarikhe_talighe_ip'];
                $subinfo['tarikhe_shoroe_service'] = $ip_assign[0]['tarikhe_shoroe_service'];
                $subinfo['tarikhe_payane_service'] = $ip_assign[0]['tarikhe_payane_service'];
                $subinfo['tol'] = $ip_assign[0]['tol'];
                $subinfo['arz'] = $ip_assign[0]['arz'];
            }
        }
        if(! isset($subinfo)){
            if(! isset($subinfo)){
                //search by ibsusername
                $serinfo=Helper::getInternetUsersServicesInfoWithoutLogincheck();
                if($serinfo){
                    for ($i=0; $i <count($serinfo) ; $i++) { 
                        if($serinfo[$i]['ibsusername']===$ipdr_last_username){
                            $serinfo=$serinfo[$i];
                            $subinfo['howifoundit']='userinfo';
                            $subinfo['sertype']=$serinfo['sertype'];
                            $subinfo['emkanat_id']=$serinfo['emkanat_id'];
                            $subinfo['subid']=$serinfo['subid'];
                            break;
                        }
                    }
                }
            }
            if(Helper::isMobile($ipdr_last_username)){
                //search by mobile
                $sql="SELECT * FROM bnm_subscribers WHERE telephone_hamrah LIKE '%".$ipdr_last_username."'";
                $res=Db::fetchall_Query($sql);
                if($res){
                    $serinfo=Helper::getInternetServiceInfoBySubidNoAuth($res[0]['id']);
                    $serinfo=self::findInternetServiceByAdslVdslPriority($serinfo);
                    if($serinfo){
                        $subinfo['howifoundit']='userinfo';
                        $subinfo['sertype']=$serinfo['sertype'];
                        $subinfo['emkanat_id']=$serinfo['emkanat_id'];
                        $subinfo['subid']=$serinfo['subid'];
                    }
                }
            }
            if(! isset($subinfo)){
                //search by telephone1
                $sql="SELECT * FROM bnm_subscribers WHERE telephone1 LIKE '%".$ipdr_last_username."'";
                $res=Db::fetchall_Query($sql);
                if($res){
                    $serinfo=Helper::getInternetServiceInfoBySubidNoAuth($res[0]['id']);
                    $serinfo=self::findInternetServiceByAdslVdslPriority($serinfo);
                    if($serinfo){
                        $subinfo['howifoundit']='userinfo';
                        $subinfo['sertype']=$serinfo['sertype'];
                        $subinfo['emkanat_id']=$serinfo['emkanat_id'];
                        $subinfo['subid']=$serinfo['subid'];
                    }
                }
            }
            if(! isset($subinfo)){
                //search by code_meli
                $sql="SELECT * FROM bnm_subscribers WHERE code_meli =?";
                $res=Db::secure_fetchall($sql,[$ipdr_last_username]);
                // $res=Db::fetchall_Query($sql);
                if($res){
                    $serinfo=Helper::getInternetServiceInfoBySubidNoAuth($res[0]['id']);
                    $serinfo=self::findInternetServiceByAdslVdslPriority($serinfo);
                    if($serinfo){
                        $subinfo['howifoundit']='userinfo';
                        $subinfo['sertype']=$serinfo['sertype'];
                        $subinfo['emkanat_id']=$serinfo['emkanat_id'];
                        $subinfo['subid']=$serinfo['subid'];
                    }
                }
            }
            
        }

        if(! isset($subinfo)) {
            //todo... agar subinfo peyda nashod hachi az ipdr dari befrest ?
            return json_encode('QryResult=3'.self::sep('f').self::messages('in'), JSON_UNESCAPED_UNICODE);
        }
        $sql="SELECT *,DATE_FORMAT(tarikhe_sabtenam,'%Y-%m-%d %H:%i') siam_tarikhe_sabtenam FROM bnm_subscribers WHERE id = ?";
        $res_sub=Db::secure_fetchall($sql,[$subinfo['subid']]);
        if(! $res_sub) return json_encode('QryResult=3'.self::sep('f').self::messages('in'), JSON_UNESCAPED_UNICODE);
        $qr = "QryResult=";
        
        for ($i=0; $i < count($ipdr); $i++) { 
            $qr.=self::siamTel($res_sub[0]['telephone1'],2).self::sep('f');
            $qr.=Helper::regulateNumber(long2ip($ipdr[$i]['ip']),2).self::sep('f');
            $qr.=$ipdr[$i]['user_id'].self::sep('f');
            if(isset($subinfo['sertype'])){
                $qr.=$subinfo['sertype'].self::sep('f');
            }else{
                $qr.=$ipdr[$i]['service_name'].self::sep('f');
            }
            $stdate=$ipdr[$i]['ses_start'];
            $stdate=Helper::unixTimestampToDateTime($stdate, 'Y-m-d H:i');
            $stdate=Helper::TabdileTarikh($stdate, 1, '-', '/',false);
            $stdate=Helper::fixDateDigit($stdate);
            $stdate=Helper::regulateNumber($stdate);
            $qr.=$stdate.self::sep('f');
            $stdate=$ipdr[$i]['ses_stop'];
            $stdate=Helper::unixTimestampToDateTime($stdate, 'Y-m-d H:i');
            $stdate=Helper::TabdileTarikh($stdate, 1, '-', '/',false);
            $stdate=Helper::fixDateDigit($stdate);
            $stdate=Helper::regulateNumber($stdate);
            $qr.=$stdate.self::sep('f');
            $qr.=(string)Helper::regulateNumber(long2ip($ipdr[$i]['sip']),2).self::sep('f');
            $qr.=(string)Helper::regulateNumber(long2ip($ipdr[$i]['dip']),2).self::sep('f');
            $qr.=Helper::regulateNumber($ipdr[$i]['sport'],2).self::sep('f');
            $qr.=Helper::regulateNumber($ipdr[$i]['dport'],2).self::sep('f');
            $qr.=Helper::regulateNumber($ipdr[$i]['snd_bytes'],2).self::sep('f');
            $qr.=Helper::regulateNumber($ipdr[$i]['rcv_btes'],2).self::sep('f');
            $qr.=$ipdr[$i]['mac'].self::sep('f');
            $qr.=$ipdr[$i]['mac_p'].self::sep('f');
            $qr.=$ipdr[$i]['ip_p'].self::sep('f');
            $qr.=$ipdr[$i]['url'].self::sep('f');
            if(isset($subinfo['sertype'])){
                switch ($subinfo['sertype']) {
                    case 'bandwidth':
                        if(isset($subinfo['tol']) && isset($subinfo['arz'])){
                            if($subinfo['tol'] && $subinfo['arz']){
                                $tol=Helper::DDtoDMS($subinfo['tol']);
                                $arz=Helper::DDtoDMS($subinfo['arz']);
                                if($tol && $arz){
                                    $qr.=$tol.",".$arz.self::sep('r');
                                }
                            }else{
                                $qr.="".self::sep('r');
                            }
                        }else{
                            $qr.="".self::sep('r');
                        }
                    break;
                    case 'wireless':
                    case 'tdlte':
                        $qr.="".self::sep('r');
                    break;
                    default:
                        $qr.="".self::sep('r');
                    break;
                }
            }else{
                $qr.="".self::sep('r');
            }
            $qr.="0";
        }
        if(! isset($qr)){
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }
        
        if(! $qr){
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }
        return json_encode($qr, JSON_UNESCAPED_UNICODE);
        
    }

    // public static function ApplySusp($username, $password, )

    public static function ApplySuspIp($username, $password, $RefNum, $SuspId, $SuspType, $SuspOrder, $tel='', $ip='', $cid=''){
        $auth=self::authentication($username, $password);
        // if(! $auth) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        if(! $auth) return json_encode('QryResult=3'.self::sep('f')."نام کاربری یا رمز عبور اشتباه است", JSON_UNESCAPED_UNICODE);
        if(!$tel && !$ip && !$cid) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        if($tel) {
            $ntel=self::siamTel($tel, 1);
        }
        $ipdr=false;
        if($ip){
            $ip2l=Helper::regulateNumber($ip);
            $ip2l=ip2long($ip);

        }
        $db = Helper::pdodbIpdrInstance();
        if($cid){
            $db->where('user_id', $cid);
        }
        if($tel){
            $db->where('username', $ntel);
        }
        if($ip){
            $db->where('ip', $ip2l);
        }
        $db->orderBy("ses_stop","DESC");
        $ipdr = $db->get("tbl_ipdr", 100);
        $db=null;
        if(! $ipdr) {
            return json_encode('QryResult=3'.self::sep('f').self::messages('in'), JSON_UNESCAPED_UNICODE);
        }
        $ipdr_last_username=$ipdr[array_key_last($ipdr)]['username'];
        //last ipdr row
        $ipdrf=$ipdr[array_key_first($ipdr)];
        $ipdrl=$ipdr[array_key_last($ipdr)];
        //second to last ipdr row
        if(isset($ipdr[array_key_last($ipdr)-1])){
            $ipdrsl=$ipdr[array_key_last($ipdr)-1];
        }else{
            $ipdrsl=false;
        }
        $services=Helper::getInternetUsersServicesInfoWithoutLogincheck();
        if(! $services) return json_encode('QryResult=3'.self::sep('f').self::messages('in'),JSON_UNESCAPED_UNICODE);
        $ip_assign=Helper::getIpinfoByip(long2ip($ipdrl['ip']));
        if ($ip_assign) {
            if ($ip_assign[0]['servicetype'] === "bandwidth") {
                //band width
                $subinfo['howifoundit']='ipassign';
                $subinfo['hasassignedip']=true;
                $subinfo['sertype'] = $ip_assign[0]['servicetype'];
                if ($ip_assign[0]['servicetype'] === "bitstream") {
                    $subinfo['general_sertype'] = 'adsl';
                } else {
                    $subinfo['general_sertype'] = $subinfo['sertype'];
                }
                $subinfo['subid'] = $ip_assign[0]['sub'];
                $subinfo['ipaddress'] = $ip_assign[0]['ipaddress'];
                $subinfo['taligh'] = $ip_assign[0]['taligh']; //1=yes//2=no
                $subinfo['bandwidth'] = $ip_assign[0]['bandwidth']; //1=yes//2=no
                $subinfo['tarikhe_shoroe_ip'] = $ip_assign[0]['tarikhe_shoroe_ip'];
                $subinfo['tarikhe_payane_ip'] = $ip_assign[0]['tarikhe_payane_ip'];
                $subinfo['tarikhe_talighe_ip'] = $ip_assign[0]['tarikhe_talighe_ip'];
                $subinfo['tarikhe_shoroe_service'] = $ip_assign[0]['tarikhe_shoroe_service'];
                $subinfo['tarikhe_payane_service'] = $ip_assign[0]['tarikhe_payane_service'];
                $subinfo['tol'] = $ip_assign[0]['tol'];
                $subinfo['arz'] = $ip_assign[0]['arz'];
                $subinfo['username']=$ip_assign[0]['username'];
                $subinfo['password']=$ip_assign[0]['password'];
            } else {
                //adsl,vdsl,wireless,tdlte, bitstream
                $services = Helper::getServiceInfoLastFactorWithSubidEmkanatSertypeNoAuth($ip_assign[0]['sub'], $ip_assign[0]['emkanat_id'], $ip_assign[0]['servicetype']);
                $subinfo['howifoundit']='ipassign';
                $subinfo['hasassignedip']=true;
                $subinfo['sertype'] = $ip_assign[0]['servicetype'];
                $subinfo['emkanat_id'] = $ip_assign[0]['emkanat_id'];
                $subinfo['subid'] = $ip_assign[0]['sub'];
                $subinfo['ipaddress'] = $ip_assign[0]['ipaddress'];
                $subinfo['taligh'] = $ip_assign[0]['taligh']; //1=yes//2=no
                $subinfo['bandwidth'] = $ip_assign[0]['bandwidth']; //1=yes//2=no
                $subinfo['tarikhe_shoroe_ip'] = $ip_assign[0]['tarikhe_shoroe_ip'];
                $subinfo['tarikhe_payane_ip'] = $ip_assign[0]['tarikhe_payane_ip'];
                $subinfo['tarikhe_talighe_ip'] = $ip_assign[0]['tarikhe_talighe_ip'];
                $subinfo['tarikhe_shoroe_service'] = $ip_assign[0]['tarikhe_shoroe_service'];
                $subinfo['tarikhe_payane_service'] = $ip_assign[0]['tarikhe_payane_service'];
                $subinfo['tol'] = $ip_assign[0]['tol'];
                $subinfo['arz'] = $ip_assign[0]['arz'];
            }
        }
        if(! isset($subinfo)){
            if(! isset($subinfo)){
                //search by ibsusername
                $serinfo=Helper::getInternetUsersServicesInfoWithoutLogincheck();
                if($serinfo){
                    for ($i=0; $i <count($serinfo) ; $i++) { 
                        if($serinfo[$i]['ibsusername']===$ipdr_last_username){
                            $serinfo=$serinfo[$i];
                            $subinfo['howifoundit']='userinfo';
                            $subinfo['sertype']=$serinfo['sertype'];
                            $subinfo['emkanat_id']=$serinfo['emkanat_id'];
                            $subinfo['subid']=$serinfo['subid'];
                            break;
                        }
                    }
                }
            }
            if(Helper::isMobile($ipdr_last_username)){
                //search by mobile
                $sql="SELECT * FROM bnm_subscribers WHERE telephone_hamrah LIKE '%".$ipdr_last_username."'";
                $res=Db::fetchall_Query($sql);
                if($res){
                    $serinfo=Helper::getInternetServiceInfoBySubidNoAuth($res[0]['id']);
                    $serinfo=self::findInternetServiceByAdslVdslPriority($serinfo);
                    if($serinfo){
                        $subinfo['howifoundit']='userinfo';
                        $subinfo['sertype']=$serinfo['sertype'];
                        $subinfo['emkanat_id']=$serinfo['emkanat_id'];
                        $subinfo['subid']=$serinfo['subid'];
                    }
                }
            }
            if(! isset($subinfo)){
                //search by telephone1
                $sql="SELECT * FROM bnm_subscribers WHERE telephone1 LIKE '%".$ipdr_last_username."'";
                $res=Db::fetchall_Query($sql);
                if($res){
                    $serinfo=Helper::getInternetServiceInfoBySubidNoAuth($res[0]['id']);
                    $serinfo=self::findInternetServiceByAdslVdslPriority($serinfo);
                    if($serinfo){
                        $subinfo['howifoundit']='userinfo';
                        $subinfo['sertype']=$serinfo['sertype'];
                        $subinfo['emkanat_id']=$serinfo['emkanat_id'];
                        $subinfo['subid']=$serinfo['subid'];
                    }
                }
            }
            if(! isset($subinfo)){
                //search by code_meli
                $sql="SELECT * FROM bnm_subscribers WHERE code_meli =?";
                $res=Db::secure_fetchall($sql,[$ipdr_last_username]);
                // $res=Db::fetchall_Query($sql);
                if($res){
                    $serinfo=Helper::getInternetServiceInfoBySubidNoAuth($res[0]['id']);
                    $serinfo=self::findInternetServiceByAdslVdslPriority($serinfo);
                    if($serinfo){
                        $subinfo['howifoundit']='userinfo';
                        $subinfo['sertype']=$serinfo['sertype'];
                        $subinfo['emkanat_id']=$serinfo['emkanat_id'];
                        $subinfo['subid']=$serinfo['subid'];
                    }
                }
            }
            
        }

        if(! isset($subinfo)) {
            //todo... agar subinfo peyda nashod hachi az ipdr dari befrest ?
            return json_encode('QryResult=3'.self::sep('f').self::messages('in'), JSON_UNESCAPED_UNICODE);
        }

        $sql="SELECT *,DATE_FORMAT(tarikhe_sabtenam,'%Y-%m-%d %H:%i') siam_tarikhe_sabtenam FROM bnm_subscribers WHERE id = ?";
        $res_sub=Db::secure_fetchall($sql,[$subinfo['subid']]);
        switch ($subinfo['howifoundit']) {
            case 'ipassign':
                if($subinfo['sertype']==="bandwidth"){
                    return json_encode('QryResult=1'.self::sep('f')."سرویس مورد نظر پهنای باند است و بصورت سیستمی قابل قطع یا وصل کردن نیست.", JSON_UNESCAPED_UNICODE);
                }else{
                    $laststatus=Helper::lastSuspensionStatus($subinfo['subid'], $subinfo['sertype'], $subinfo['emkanat_id']);
                    //service currently locked
                    if((int) Helper::regulateNumber($SuspId)===0){
                        if(isset($laststatus) && isset($laststatus[0]['lockstatus'])){
                            if($laststatus[0]['lockstatus']===1){
                                //lockstatus 1 = ghat, 2=vasl
                                //service already locked
                                $factor=Helper::getServiceInfoLastFactorWithSubidEmkanatSertypeNoAuth($subinfo['subid'], $subinfo['emkanat_id'], $subinfo['sertype']);
                                if(! $factor){
                                    return json_encode('QryResult=1'.self::sep('f')."خطا در برنامه انجام درخواست با مشکل مواجه شد و عملیات موفق نبود", JSON_UNESCAPED_UNICODE);
                                }
                                if((int)Helper::regulateNumber($SuspType)===0){
                                   $time=1; 
                                }elseif ((int)Helper::regulateNumber($SuspType)===1) {
                                    $time=0;
                                }elseif ((int)Helper::regulateNumber($SuspType)===2) {
                                    $time=2;
                                }elseif ((int)Helper::regulateNumber($SuspType)===3) {
                                    $time=3;
                                }elseif ((int)Helper::regulateNumber($SuspType)===4) {
                                    $time=7;
                                }elseif ((int)Helper::regulateNumber($SuspType)===5) {
                                    $time=15;
                                }else{
                                    $time=1;
                                }
                                if(! isset($time)){
                                    return json_encode('QryResult=1'.self::sep('f')."خطای برنامه زمان قطع (susptype) برای سیستم تعریف نشده است", JSON_UNESCAPED_UNICODE);
                                }
                                $res_lock=Helper::lockWithLog(6, $factor[0]['fid'], $time , "قطع از طریق سامانه سیام", $RefNum);
                                return json_encode('QryResult=0'.self::sep('f')."درخواست با موفقیت انجام شد", JSON_UNESCAPED_UNICODE);
                            }else{
                                //service is open
                                $factor=Helper::getServiceInfoLastFactorWithSubidEmkanatSertypeNoAuth($subinfo['subid'], $subinfo['emkanat_id'], $subinfo['sertype']);
                                if(! $factor){
                                    return json_encode('QryResult=1'.self::sep('f')."خطا در برنامه انجام درخواست با مشکل مواجه شد و عملیات موفق نبود", JSON_UNESCAPED_UNICODE);
                                }
                                if((int)Helper::regulateNumber($SuspType)===0){
                                   $time=1; 
                                }elseif ((int)Helper::regulateNumber($SuspType)===1) {
                                    $time=0;
                                }elseif ((int)Helper::regulateNumber($SuspType)===2) {
                                    $time=2;
                                }elseif ((int)Helper::regulateNumber($SuspType)===3) {
                                    $time=3;
                                }elseif ((int)Helper::regulateNumber($SuspType)===4) {
                                    $time=7;
                                }elseif ((int)Helper::regulateNumber($SuspType)===5) {
                                    $time=15;
                                }else{
                                    $time=1;
                                }
                                if(! isset($time)){
                                    return json_encode('QryResult=1'.self::sep('f')."خطای برنامه زمان قطع (susptype) برای سیستم تعریف نشده است", JSON_UNESCAPED_UNICODE);
                                }
                                $res_lock=Helper::lockWithLog(6, $factor[0]['fid'], $time , "قطع از طریق سامانه سیام", $RefNum);
                                return json_encode('QryResult=0'.self::sep('f')."درخواست با موفقیت انجام شد", JSON_UNESCAPED_UNICODE);
                            }
                        }else{
                            //no data about service lock status just do it !
                            $factor=Helper::getServiceInfoLastFactorWithSubidEmkanatSertypeNoAuth($subinfo['subid'], $subinfo['emkanat_id'], $subinfo['sertype']);
                            if(! $factor){
                                return json_encode('QryResult=1'.self::sep('f')."خطا در برنامه انجام درخواست با مشکل مواجه شد و عملیات موفق نبود", JSON_UNESCAPED_UNICODE);
                            }
                            if((int)Helper::regulateNumber($SuspType)===0){
                               $time=1; 
                            }elseif ((int)Helper::regulateNumber($SuspType)===1) {
                                $time=0;
                            }elseif ((int)Helper::regulateNumber($SuspType)===2) {
                                $time=2;
                            }elseif ((int)Helper::regulateNumber($SuspType)===3) {
                                $time=3;
                            }elseif ((int)Helper::regulateNumber($SuspType)===4) {
                                $time=7;
                            }elseif ((int)Helper::regulateNumber($SuspType)===5) {
                                $time=15;
                            }else{
                                $time=1;
                            }
                            if(! isset($time)){
                                return json_encode('QryResult=1'.self::sep('f')."خطای برنامه زمان قطع (susptype) برای سیستم تعریف نشده است", JSON_UNESCAPED_UNICODE);
                            }
                            $res_lock=Helper::lockWithLog(6, $factor[0]['fid'], $time , "قطع از طریق سامانه سیام", $RefNum);
                            return json_encode('QryResult=0'.self::sep('f')."درخواست با موفقیت انجام شد", JSON_UNESCAPED_UNICODE);
                        }
                    }else{
                        ///unlock service
                        $factor=Helper::getServiceInfoLastFactorWithSubidEmkanatSertypeNoAuth($subinfo['subid'], $subinfo['emkanat_id'], $subinfo['sertype']);
                        if(! $factor){
                            return json_encode('QryResult=1'.self::sep('f')."خطا در برنامه انجام درخواست با مشکل مواجه شد و عملیات موفق نبود", JSON_UNESCAPED_UNICODE);
                        }
                        $res_unlock=Helper::unlockWithLog(1, $factor[0]['fid'], "وصل از طریق سامانه سیام", $RefNum);
                        if(! $res_unlock){
                            return json_encode('QryResult=1'.self::sep('f')."خطا در برنامه انجام درخواست با مشکل مواجه شد و عملیات موفق نبود", JSON_UNESCAPED_UNICODE);
                        }else{
                            return json_encode('QryResult=0'.self::sep('f')."درخواست با موفقیت انجام شد", JSON_UNESCAPED_UNICODE);
                        }
                    }
                }
            break;
            case 'userinfo':
                $laststatus=Helper::lastSuspensionStatus($subinfo['subid'], $subinfo['sertype'], $subinfo['emkanat_id']);
                //service currently locked
                if((int) Helper::regulateNumber($SuspId)===0){
                    if(isset($laststatus) && isset($laststatus[0]['lockstatus'])){
                        if($laststatus[0]['lockstatus']===1){
                            //lockstatus 1 = ghat, 2=vasl
                            //service already locked
                            $factor=Helper::getServiceInfoLastFactorWithSubidEmkanatSertypeNoAuth($subinfo['subid'], $subinfo['emkanat_id'], $subinfo['sertype']);
                            if(! $factor){
                                return json_encode('QryResult=1'.self::sep('f')."خطا در برنامه انجام درخواست با مشکل مواجه شد و عملیات موفق نبود", JSON_UNESCAPED_UNICODE);
                            }
                            if((int)Helper::regulateNumber($SuspType)===0){
                               $time=1; 
                            }elseif ((int)Helper::regulateNumber($SuspType)===1) {
                                $time=0;
                            }elseif ((int)Helper::regulateNumber($SuspType)===2) {
                                $time=2;
                            }elseif ((int)Helper::regulateNumber($SuspType)===3) {
                                $time=3;
                            }elseif ((int)Helper::regulateNumber($SuspType)===4) {
                                $time=7;
                            }elseif ((int)Helper::regulateNumber($SuspType)===5) {
                                $time=15;
                            }else{
                                $time=1;
                            }
                            if(! isset($time)){
                                return json_encode('QryResult=1'.self::sep('f')."خطای برنامه زمان قطع (susptype) برای سیستم تعریف نشده است", JSON_UNESCAPED_UNICODE);
                            }
                            $res_lock=Helper::lockWithLog(6, $factor[0]['fid'], $time , "قطع از طریق سامانه سیام", $RefNum);
                            return json_encode('QryResult=0'.self::sep('f')."درخواست با موفقیت انجام شد", JSON_UNESCAPED_UNICODE);
                        }else{
                            //service is open
                            $factor=Helper::getServiceInfoLastFactorWithSubidEmkanatSertypeNoAuth($subinfo['subid'], $subinfo['emkanat_id'], $subinfo['sertype']);
                            if(! $factor){
                                return json_encode('QryResult=1'.self::sep('f')."خطا در برنامه انجام درخواست با مشکل مواجه شد و عملیات موفق نبود", JSON_UNESCAPED_UNICODE);
                            }
                            if((int)Helper::regulateNumber($SuspType)===0){
                               $time=1; 
                            }elseif ((int)Helper::regulateNumber($SuspType)===1) {
                                $time=0;
                            }elseif ((int)Helper::regulateNumber($SuspType)===2) {
                                $time=2;
                            }elseif ((int)Helper::regulateNumber($SuspType)===3) {
                                $time=3;
                            }elseif ((int)Helper::regulateNumber($SuspType)===4) {
                                $time=7;
                            }elseif ((int)Helper::regulateNumber($SuspType)===5) {
                                $time=15;
                            }else{
                                $time=1;
                            }
                            if(! isset($time)){
                                return json_encode('QryResult=1'.self::sep('f')."خطای برنامه زمان قطع (susptype) برای سیستم تعریف نشده است", JSON_UNESCAPED_UNICODE);
                            }
                            $res_lock=Helper::lockWithLog(6, $factor[0]['fid'], $time , "قطع از طریق سامانه سیام", $RefNum);
                            return json_encode('QryResult=0'.self::sep('f')."درخواست با موفقیت انجام شد", JSON_UNESCAPED_UNICODE);
                        }
                    }else{
                        //no data about service lock status just do it !
                        $factor=Helper::getServiceInfoLastFactorWithSubidEmkanatSertypeNoAuth($subinfo['subid'], $subinfo['emkanat_id'], $subinfo['sertype']);
                        if(! $factor){
                            return json_encode('QryResult=1'.self::sep('f')."خطا در برنامه انجام درخواست با مشکل مواجه شد و عملیات موفق نبود", JSON_UNESCAPED_UNICODE);
                        }
                        if((int)Helper::regulateNumber($SuspType)===0){
                           $time=1; 
                        }elseif ((int)Helper::regulateNumber($SuspType)===1) {
                            $time=0;
                        }elseif ((int)Helper::regulateNumber($SuspType)===2) {
                            $time=2;
                        }elseif ((int)Helper::regulateNumber($SuspType)===3) {
                            $time=3;
                        }elseif ((int)Helper::regulateNumber($SuspType)===4) {
                            $time=7;
                        }elseif ((int)Helper::regulateNumber($SuspType)===5) {
                            $time=15;
                        }else{
                            $time=1;
                        }
                        if(! isset($time)){
                            return json_encode('QryResult=1'.self::sep('f')."خطای برنامه زمان قطع (susptype) برای سیستم تعریف نشده است", JSON_UNESCAPED_UNICODE);
                        }
                        $res_lock=Helper::lockWithLog(6, $factor[0]['fid'], $time , "قطع از طریق سامانه سیام", $RefNum);
                        return json_encode('QryResult=0'.self::sep('f')."درخواست با موفقیت انجام شد", JSON_UNESCAPED_UNICODE);
                    }
                }else{
                    ///unlock service
                    $factor=Helper::getServiceInfoLastFactorWithSubidEmkanatSertypeNoAuth($subinfo['subid'], $subinfo['emkanat_id'], $subinfo['sertype']);
                    if(! $factor){
                        return json_encode('QryResult=1'.self::sep('f')."خطا در برنامه انجام درخواست با مشکل مواجه شد و عملیات موفق نبود", JSON_UNESCAPED_UNICODE);
                    }
                    $res_unlock=Helper::unlockWithLog(1, $factor[0]['fid'], "وصل از طریق سامانه سیام", $RefNum);
                    return json_encode('QryResult=0'.self::sep('f')."درخواست با موفقیت انجام شد", JSON_UNESCAPED_UNICODE);
                }
            break;
            default:
                return json_encode('QryResult=3'.self::sep('f').self::messages('in'), JSON_UNESCAPED_UNICODE);
            break;
        }
    }

    public static function GetIpPool($username, $password){
        $auth=self::authentication($username, $password);
        // if(! $auth) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        if(! $auth) return json_encode('QryResult=3'.self::sep('f')."نام کاربری یا رمز عبور اشتباه است", JSON_UNESCAPED_UNICODE);
        $arr=[];
        $sql="SELECT ip.ip ipaddress,
            ip.gender,
            ip.ipstart,
			ip.ipend,
            IF(ip.gender='1','valid','invalid') en_gender,
            ip.iptype,
            IF(ip.iptype='1','static','dynamic') en_iptype,
            ip.ownership,
            ip.ipusage,
            IF(ip.ownership='1','malek',IF(ip.ownership='2','ejare','gheyre')) en_ownership,
            ip.servicetype ipservicetype
            FROM bnm_ip ip GROUP BY pool";
        $res=Db::fetchall_Query($sql);
        if(! $res) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        $qr = "QryResult=";
        for ($i=0; $i <count($res) ; $i++) { 
            if(! isset($res[$i])) continue;
            if(! $res[$i]) continue;
            $qr.=$res[$i]['ipstart'].self::sep('f');
            $qr.=$res[$i]['ipend'].self::sep('f');
            $qr.=$res[$i]['en_iptype'].self::sep('f');
            if($res[$i]['en_ownership']==="malek"){
                $qr.='مالک'.self::sep('f');
            }elseif ($res[$i]['en_ownership']==="ejare") {
                $qr.='اجاره'.self::sep('f');
            }else{
                $qr.='غیره'.self::sep('f');
            }
            switch ($res[$i]['ipusage']) {
                case '1':
                    $qr.="شبکه داخلی";
                break;
                case '2':
                    $qr.="اختصاص به مشترکین";
                break;
                case '3':
                    $qr.="رزرو";
                break;
                default:
                    $qr.="";
                break;
            }
            $qr.=self::sep('r');
        }
        $qr .= "0";
        return json_encode($qr, JSON_UNESCAPED_UNICODE);
    }

    public static function PassChange($username, $password, $NAutStr){
        $auth=self::authentication($username, $password);
        if(! $auth) return json_encode('QryResult=3'.self::sep('f')."نام کاربری یا رمز عبور اشتباه است", JSON_UNESCAPED_UNICODE);
        $sql="UPDATE bnm_siamconfig SET password=:nautstr WHERE username=:username AND password=:password";
        $res=Db::secure_update_array($sql, ['username'=>$username, 'nautstr'=>$NAutStr, 'password'=>$password]);
        if(! $res) return json_encode('QryResult=3'.self::sep('f')."خطای پایگاه داده عملیات موفق نبوده و یا رمز عبور تکراری میباشد.", JSON_UNESCAPED_UNICODE);
        return json_encode('QryResult=0'.self::sep('f')."رمز عبور با موفقیت تغییر یافت", JSON_UNESCAPED_UNICODE);

    }

    public static function findInternetServiceByAdslVdslPriority($services)
    {
        for ($i = 0; $i < count($services); $i++) {
            if ($services[$i]['sertype'] === "adsl" || $services[$i]['sertype'] = 'vdsl' || $services[$i]['sertype'] = 'bitstream') {
                return $services[$i];
            }
        }
        for ($i = 0; $i < count($services); $i++) {
            if ($services[$i]['sertype'] === "wireless" || $services[$i]['sertype'] = 'tdlte') {
                return $services[$i];
            }
        }
        return false;
    }
    public static function siamTel($t,$convertype=1)
    {
        //1=from siam to normal(stn)
        //1=from normal to siam(nts)
        if ($convertype === 1) {
            $t = Helper::regulateNumber($t, 1);
            // $t = substr($t, 2);
            $t = "0" . $t;
        } else {
            $t = Helper::regulateNumber($t, 1);
            if($t[0]==="0"){
                $t=substr($t, 1);
                // $t=$t;
                $t = Helper::regulateNumber($t, 2);
            }else{
                // $t=$t;
                $t = Helper::regulateNumber($t, 2);
            }
            
        }
        return $t;
    }
    public static function messages($mid){
        switch ($mid) {
            case 11:
            case '11':
            case 'moreanswerexisting':
            case 'mae':
                return "تعداد رکوردهای پاسخ در بانک اطلاعاتی اپراتور از سقف تعیین شده برای ارسال بیشتر است.";
            break;
            case 'al':
            case 'alreadylocked':
                return "این سرویس قبلا به درخواست شما قطع شده.";
            break;
            case 3:
            case '3':
            case 'dberror':
            case 'dbe':
                return "خطا در ارتباط با پایگاه داده لطفا مجددا تلاش نمایید.";
            break;
            case 'ipnotinippool':
            case 'iniip':
            case 'ipnotfound':
            case 'ipnf':
                return "آی پی مورد نظر تحت اختیار این اپراتور نمیباشد";
            break;
            case 'inf':
            case 'informationnotfound':
            case 'dbeinf':
                return "اطلاعات مورد نظر در پایگاه داده یافت نشد";
            break;
            case 5:
            case '5':
            case 'invalidnumber':
            case 'in':
                return "شماره (آی پی- تلفن- سریال) مورد نظر خارج از محدوده در اختیار این اپراتور یا مشترکین آن است.";
            break;
            default:
                return 'خطا در برنامه';
            break;
        }
    }
    public static function sep($sep)
    {
        switch ($sep) {
            case 'r':
            case 'row':
                return '\\r\\n';
                break;
            case 'field':
            case 'f':
                return '^&';
                break;
            case 'i':
            case 'insidefield':
                return '^#';
                break;
            default:
                return '';
                break;
        }
    }

    public static function authentication($user, $pass)
    {
        if (!isset($user)) {
            return false;
        }
        if(! isset($pass)) return false;
        if(! $user) return false;
        if(! $pass) return false;
        $sql = "SELECT count(*) rowsnum FROM bnm_siamconfig WHERE username = ? AND password= ?";
        $res = Db::secure_fetchall($sql, [$user, $pass]);
        if ($res[0]['rowsnum'] === 1) {
            return true;
        } else {
            return false;
        }
        return false;
    }
    public static function combineSearchDynamicQuery(array $arr){
        if(isset($arr['code_meli'])){
            if(isset($arr['passno'])) unset($arr['passno']);
            $arr['noe_shenase_hoviati']='0';
            $sql="SELECT sub.* FROM bnm_subscribers sub
                WHERE ";
                $firstKey = array_key_first($arr);
                $lastkey = array_key_last($arr);
                foreach ($arr as $key => $value) {
                    if($key === $firstKey ){
                        $sql.= "sub.".$key. '= ? ';
                    }elseif ($key === $lastkey) {
                        $sql.= 'AND'.' sub.'.$key.'= ? ';                        
                    }else{
                        $sql.= 'AND'.' sub.'.$key.'= ? ';
                    }
                }
        }elseif (isset($arr['passno'])) {
            if(isset($arr['code_meli'])) unset($arr['code_meli']);
            $arr['code_meli']=$arr['passno'];
            unset($arr['passno']);
            $arr['noe_shenase_hoviati']='1';
            $sql="SELECT sub.* FROM bnm_subscribers sub
                WHERE ";
                $firstKey = array_key_first($arr);
                $lastkey = array_key_last($arr);
                foreach ($arr as $key => $value) {
                    if($key === $firstKey ){
                        $sql.= "sub.".$key. '= ? ';
                    }elseif ($key === $lastkey) {
                        $sql.= 'AND'.' sub.'.$key.'= ? ';
                    }else{
                        $sql.= 'AND'.' sub.'.$key.'= ? ';
                    }
                }
        }else{
            $sql="SELECT sub.* FROM bnm_subscribers sub
            WHERE ";
            $firstKey = array_key_first($arr);
            $lastkey = array_key_last($arr);
            foreach ($arr as $key => $value) {
                if($key === $firstKey ){
                    $sql.= "sub.".$key. '= ? ';
                }elseif ($key === $lastkey) {
                    $sql.= 'AND'.' sub.'.$key.'= ? ';
                    $sql.= 'AND'.' sub.noe_shenase_hoviati= ? ';
                    $arr['noe_shenase_hoviati']='0';
                }else{
                    $sql.= 'AND'.' sub.'.$key.'= ? ';
                }
            }
        }
        $res=Db::secure_fetchall($sql,$arr);
        if(! $res) return false;
        if(! isset($res)) return false;
        if(isset(($res['errorInfo']))) return false;//mysql error
        return $res;
    }


}
