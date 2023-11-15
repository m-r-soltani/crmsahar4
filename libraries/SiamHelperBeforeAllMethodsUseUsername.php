<?php
class SiamHelper
{
    // Https://IpAddress:port/..../DServices/....?WSDL

    public static function combinSearch($username, $password, $tel = '', $ip = '', $name = '', $family = '', $ss = '', $code_posti = '', $code_meli = '', $passno = '', $test=false)
    {
        $auth = self::authentication($username, $password);
        if (!$auth) {
            return json_encode('QryResult=3' . self::sep('f') . "نام کاربری یا رمز عبور اشتباه است", JSON_UNESCAPED_UNICODE);
        }

        $regulatedip = false;
        $subs = false;
        if ($ip) {
            $regulatedip = Helper::regulateNumber($ip, 1);
        }

        if ($regulatedip) {
            $checkipexists = Helper::checkIpExist(Helper::regulateNumber($regulatedip, 1));
            if (!$checkipexists) {
                return json_encode('QryResult=5' . self::sep('f') . "DbError" . self::sep('f') . self::messages('ipnf'), JSON_UNESCAPED_UNICODE);
            }
        }
        $sa = [];
        // if($tel) $sa['telephone1']=self::siamTel($tel,1);
        if ($tel) {
            $formattedtel = self::siamTel($tel, 1);
            if (Helper::isMobile($formattedtel)) {
                $sa['telephone_hamrah'] = $formattedtel;
                $ismobile = true;
            } else {
                $sa['telephone1'] = $formattedtel;
            }
        }
        if ($name) {
            $sa['name'] = $name;
        }

        if ($family) {
            $sa['f_name'] = $family;
        }

        if ($ss) {
            $sa['shomare_shenasname']=Helper::regulateNumber($ss);
        }

        if ($code_posti) {
            $sa['code_posti1']=Helper::regulateNumber($code_posti);
        }

        if ($code_meli) {
            $sa['code_meli']=Helper::regulateNumber($code_meli);
        }

        if ($passno) {
            Helper::regulateNumber($sa['passno'] = $passno);
        }
        $subs = self::combineSearchDynamicQuery($sa);
        $usernames = [];
        if (!$subs && !$regulatedip) {
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }
        $allservices = Helper::getAllInternetUsersServicesInfoNoAuth();
        if ($subs && $regulatedip) {
            //find user services
            for ($i = 0; $i < count($subs); $i++) {
                for ($s = 0; $s < count($allservices); $s++) {
                    if ($allservices[$s]['subid'] === $subs[$i]['id']) {
                        $subs[$i]['serviceinfo'][] = $allservices[$s];
                    }
                }
            }
            //making array username to query ibs
            for ($i = 0; $i < count($subs); $i++) {
                if (isset($subs[$i]['serviceinfo'])) {
                    if ($subs[$i]['serviceinfo']) {
                        for ($s = 0; $s < count($subs[$i]['serviceinfo']); $s++) {
                            if (isset($subs[$i]['serviceinfo'][$s]['ibsusername'])) {
                                if ($subs[$i]['serviceinfo'][$s]['ibsusername']) {
                                    $usernames[] = $subs[$i]['serviceinfo'][$s]['ibsusername'];
                                }
                            }
                        }
                    }
                }
            }
            if (!$usernames) {
                return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
            }

            $logs = Helper::getIbsLogsByArrayUsernamesAndRemoteIpDesc($usernames, $regulatedip, false, false, 10000);
            
            if (!Helper::checkIbsResultStrict($logs)) {
                return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
            }
            $logs = $logs[1][1];
        } elseif ($subs && !$regulatedip) {
            //find user services

            for ($i = 0; $i < count($subs); $i++) {
                for ($s = 0; $s < count($allservices); $s++) {
                    if ($allservices[$s]['subid'] === $subs[$i]['id']) {
                        $subs[$i]['serviceinfo'][] = $allservices[$s];
                    }
                }
            }

            // $subs=array_values()
            //making array username to query ibs
            for ($i = 0; $i < count($subs); $i++) {
                if (isset($subs[$i]['serviceinfo'])) {
                    if ($subs[$i]['serviceinfo']) {
                        for ($s = 0; $s < count($subs[$i]['serviceinfo']); $s++) {
                            if (isset($subs[$i]['serviceinfo'][$s]['ibsusername'])) {
                                if ($subs[$i]['serviceinfo'][$s]['ibsusername']) {
                                    $usernames[] = $subs[$i]['serviceinfo'][$s]['ibsusername'];
                                }
                            }
                        }
                    }
                }
            }
            if (!$usernames) {
                return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
            }

            $logs = Helper::getIbsLogsByArrayUsernamesDesc($usernames, '1400/03/01 00:00', '1400/03/31 23:59', 10000);
            if (!Helper::checkIbsResultStrict($logs)) {
                return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
            }
            $logs = $logs[1][1];
        } else {
            $logs = $GLOBALS['ibs_internet']->getConnectionByRemoteIpAndDateTimeDesc($regulatedip, false, false, 10000);
            if (!Helper::checkIbsResultStrict($logs)) {
                return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
            }
            $logs = $logs[1][1];
        }
        /////////check logs exist
        if (!isset($logs)) {
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }

        if (!$logs) {
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }
        /////////check logs exist/////////
        
        if (!$logs) {
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }

        if (!isset($logs)) {
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }

        if (!$logs) {
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }

        if (count($logs) === 0) {
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }

        ////////////////online info
        $onlines = $GLOBALS['ibs_internet']->findOnlineUsers(true);
        $onlineinfo = [];
        $res = [];
        $z = 0;
        $isonline = false;
        if ($onlines) {
            $onlineusersinfo = Helper::ibsGetOnlineUserInfoByArrayId($onlines);
            for ($i = 0; $i < count($onlineusersinfo); $i++) {
                if (isset($onlineusersinfo[$i]['internet_onlines'])) {
                    if (($onlineusersinfo[$i]['internet_onlines'])) {
                        if (isset($onlineusersinfo[$i]['internet_onlines'][0])) {
                            if (($onlineusersinfo[$i]['internet_onlines'][0])) {
                                if ($onlineusersinfo[$i]['internet_onlines'][0][4] && $onlineusersinfo[$i]['internet_onlines'][0][4] !== '-' && $onlineusersinfo[$i]['internet_onlines'][0][4] !== '0.0.0.0') {
                                    if ($onlineusersinfo[$i]['attrs']['normal_username'] === $logs[0]['username'] && $logs[0]['username']) {
                                        $isonline = true;
                                        $onlineinfo['ipv4_address'] = $onlineusersinfo[$i]['internet_onlines'][0][4];
                                        $onlineinfo['mac'] = $onlineusersinfo[$i]['internet_onlines'][0][7];
                                        $onlineinfo['session_start_time'] = $onlineusersinfo[$i]['basic_info']['last_login'];
                                        $onlineinfo['session_stop_time'] = 'آنلاین';
                                        $onlineinfo['remaining_credit'] = $onlineusersinfo[$i]['basic_info']['credit'];
                                        $onlineinfo['username'] = $onlineusersinfo[$i]['attrs']['normal_username'];
                                        $onlineinfo['password'] = $onlineusersinfo[$i]['attrs']['normal_password'];
                                        $onlineinfo['user_id'] = $onlineusersinfo[$i]['user_id'];
                                        for ($s = 0; $s < count($allservices); $s++) {
                                            if ($allservices[$s]['ibsusername']) {
                                                if (Helper::like($allservices[$s]['ibsusername'], $onlineinfo['username'])) {
                                                    // $allservices=$allservices[$i];
                                                    $onlineinfo['serinfo'] = $allservices[$s];
                                                    break;
                                                }
                                            }
                                        }
                                        $subinfo = self::selectMultiSubsByIds([$onlineinfo['serinfo']['subid']]);
                                        $onlineinfo['subinfo'] = $subinfo;
                                        //////adding online info to logs
                                        $logs = array_merge([$onlineinfo], $logs);
                                        $logs = self::unsetExtraArrayElems($logs, 200);
                                        //////adding online info to logs
                                        break;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $logs = self::unsetLogIfIPNotValid($logs, 'ipv4_address');
        $logs = self::unsetExtraArrayElems($logs, __SIAMLIMITATION__);
        ////////////////online info/////////

        ////assign subinfo and serinfo to logs
        $subids = [];
        for ($l = 0; $l < count($logs); $l++) {
            for ($s = 0; $s < count($allservices); $s++) {
                if (isset($logs[$l]['username']) && isset($allservices[$s]['ibsusername'])) {
                    if ($logs[$l]['username'] && $allservices[$s]['ibsusername']) {
                        if (Helper::like($logs[$l]['username'], $allservices[$s]['ibsusername'])) {
                            //todo ... bad az inke peyda kardi subid ha ro beriz to ye array va bad unique hashono query kon ta kamtar zaman bebare
                            $sql = "SELECT * FROM bnm_subscribers WHERE id = ?";
                            $sub = Db::secure_fetchall($sql, [$allservices[$s]['subid']]);
                            if ($sub) {
                                $logs[$l]['subinfo'] = $sub[0];
                                $logs[$l]['serinfo'] = $allservices[$s];
                            }
                        }
                    }
                }
            }
            if (isset($logs[$l]['subinfo']) && isset($logs[$l]['serinfo'])) {
                if ($logs[$l]['subinfo'] && $logs[$l]['serinfo']) {
                    ///get all subids
                    $subids[] = $logs[$l]['subinfo']['id'];
                    ///get all subids///
                } else {
                    unset($logs[$l]);
                }
            } else {
                unset($logs[$l]);
            }
        }

        ////assign subinfo and serinfo to logs////
        ////get all subid and select query
        $logs = array_values($logs);
        $subids = array_unique($subids);
        $subids = array_values($subids);
        $ressub = self::selectMultiSubsByIds($subids);
        if (!isset($ressub)) {
            return json_encode('QryResult=5' . self::sep('f') . "خطای پایگاه داده", JSON_UNESCAPED_UNICODE);
        }

        for ($l = 0; $l < count($logs); $l++) {
            if (isset($logs[$l])) {
                if (isset($logs[$l]['serinfo'])) {
                    if ($logs[$l]['serinfo']) {
                        for ($i = 0; $i < count($ressub); $i++) {
                            if ($logs[$l]['serinfo']['subid'] === $ressub[$i]['id']) {
                                $logs[$l]['subinfo'] = $ressub[$i];
                            }
                        }
                    } else {
                        unset($logs[$l]);
                    }
                } else {
                    unset($logs[$l]);
                }
            } else {
                unset($logs[$l]);
            }
            if (!isset($logs[$l]['subinfo'])) {
                unset($logs[$l]);
            }
        }
        ////get all subid and select query////////
        //unsetLogWithNoSerinfoAndSubinfo
        $logs = self::unsetLogWithNoSerinfoAndSubinfo($logs);

        if (!$logs) {
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }

        //unsetLogWithNoSerinfoAndSubinfo////////



        ////check inputs with subsinfo
        foreach ($logs as $k => $v) {
            if (isset($logs[$k])) {
                if (isset($sa['telephone_hamrah'])) {
                    if ($sa['telephone_hamrah'] !== $logs[$k]['subinfo']['telephone_hamrah']) {
                        unset($logs[$k]);
                    }
                }
            }

            if (isset($logs[$k])) {
                if (isset($sa['telephone1'])) {
                    if ($sa['telephone1'] !== $logs[$k]['subinfo']['telephone1']) {
                        unset($logs[$k]);
                    }
                }
            }
            if (isset($logs[$k])) {
                if (isset($sa['name'])) {
                    if ($sa['name'] !== $logs[$k]['subinfo']['name']) {
                        unset($logs[$k]);
                    }
                }
            }
            if (isset($logs[$k])) {
                if (isset($sa['f_name'])) {
                    if ($sa['f_name'] !== $logs[$k]['subinfo']['f_name']) {
                        unset($logs[$k]);
                    }
                }
            }

            if (isset($logs[$k])) {
                if (isset($sa['code_posti1'])) {
                    if ($sa['code_posti1'] !== $logs[$k]['subinfo']['code_posti1']) {
                        unset($logs[$k]);
                    }
                }
            }
            if (isset($logs[$k])) {
                if (isset($sa['code_meli'])) {
                    if ($sa['code_meli'] !== $logs[$k]['subinfo']['code_meli']) {
                        unset($logs[$k]);
                    }
                }
            }
            if (isset($logs[$k])) {
                if (isset($sa['shomare_shenasname'])) {
                    if ($sa['shomare_shenasname'] !== $logs[$k]['subinfo']['shomare_shenasname']) {
                        unset($logs[$k]);
                    }
                }
            }
            if (isset($logs[$k])) {
                if (isset($sa['passno'])) {
                    if ($sa['passno'] !== $logs[$k]['subinfo']['code_meli']) {
                        unset($logs[$k]);
                    }
                }
            }
        }
        ////check inputs with subsinfo
        if (!isset($logs)) {
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }

        if (!$logs) {
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }

        
        //////////making result array
        $logs = array_values($logs);
        $res = [];
        $z = 0;
        for ($i = 0; $i < count($logs); $i++) {
            if (isset($logs[$i])) {
                if (isset($logs[$i]['subinfo']) && isset($logs[$i]['serinfo'])) {
                    if ($logs[$i]['subinfo'] && $logs[$i]['serinfo']) {

                        $res[$z][] = self::siamTel($logs[$i]['subinfo']['telephone1'], 2);
                        $res[$z][] = Helper::regulateNumber($logs[$i]['ipv4_address'], 2);
                        if ($logs[$i]['session_start_time']) {
                            $sesstart = date('Y-m-d H:i', strtotime($logs[$i]['session_start_time']));
                            $sesstart = Helper::regulateNumber((string) Helper::TabdileTarikh($sesstart, 1, '-', '/', false), 2);
                        } else {
                            $sesstart = '';
                        }
                        if (Helper::IsDateValid($logs[$i]['session_stop_time'])) {
                            $sesstop = date('Y-m-d H:i', strtotime($logs[$i]['session_stop_time']));
                            $sesstop = Helper::regulateNumber((string) Helper::TabdileTarikh($sesstop, 1, '-', '/', false), 2);
                        } elseif ($i === array_key_first($logs) && $isonline) {
                            $sesstop = 'آنلاین';
                        } else {
                            $sesstop = $logs[$i]['session_stop_time'];
                        }
                        $res[$z][] = $sesstart;
                        $res[$z][] = $sesstop;
                        $res[$z][] = Helper::regulateNumber($logs[$i]['serinfo']['hadeaxar_sorat_daryaft'], 2) . "MB";
                        $res[$z][] = $logs[$i]['serinfo']['general_sertype'];
                        $res[$z][] = Helper::regulateNumber((string) Helper::TabdileTarikh($logs[$i]['serinfo']['siam_tarikhe_tasvie_shode'], 1, '-', '/', false), 2);
                        $res[$z][] = Helper::regulateNumber($logs[$i]['subinfo']['code_meli'], 2);
                        $res[$z][] = $logs[$i]['subinfo']['name'];
                        $res[$z][] = $logs[$i]['subinfo']['f_name'];
                        $res[$z][] = $logs[$i]['subinfo']['name_pedar'];
                        $res[$z][] = $logs[$i]['subinfo']['shomare_shenasname'];
                        $res[$z][] = Helper::regulateNumber((string) Helper::TabdileTarikh($logs[$i]['subinfo']['tarikhe_tavalod'], 1, '-', '/', false), 2);
                        $res[$z][] = Helper::regulateNumber($logs[$i]['subinfo']['code_posti1'], 2);
                        if ($logs[$i]['subinfo']['noe_moshtarak'] === "real") {
                            $res[$z][] = $logs[$i]['subinfo']['tabeiat_fa_name'];
                            if ($logs[$i]['subinfo']['noe_shenase_hoviati'] === 1) {
                                $res[$z][] = $logs[$i]['subinfo']['code_meli'];
                            } else {
                                $res[$z][] = '';
                            }
                            $res[$z][] = $logs[$i]['subinfo']['fulladdress'];
                            $res[$z][] = '';
                            $res[$z][] = '';
                            $res[$z][] = '';
                            $res[$z][] = $logs[$i]['subinfo']['noemalekiat1fa'];
                        } else {
                            $res[$z][] = '';
                            $res[$z][] = '';
                            $res[$z][] = $logs[$i]['subinfo']['fulladdress'];
                            $res[$z][] = $logs[$i]['subinfo']['name_sherkat'];
                            $res[$z][] = Helper::regulateNumber($logs[$i]['subinfo']['shomare_sabt'], 1);
                            $res[$z][] = Helper::regulateNumber($logs[$i]['subinfo']['code_eghtesadi'], 1);
                            $res[$z][] = $logs[$i]['subinfo']['noemalekiat1fa'];
                        }
                        $z++;
                    }
                }
            }
        }
        //////////making result array
        
        if (!isset($res)) {
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }

        if (!($res)) {
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }

        if (count($res) === 0) {
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }
        if($test){
            return $res;   
        }
        // $qr="QryResult=";
        // $firstKey=array_key_first($res);
        // $lastkey=array_key_first($res);
        // $res=array_values($res);
        // for ($i=0; $i <count($res) ; $i++) {
        //     //rows
        //     for ($j=0; $j <count($res[$i]) ; $j++) {
        //         $qr.=$res[$i][$j].self::sep('f');
        //     }
        //     $qr.=self::sep('r');
        // }
        // return $res;
        $qr = self::makeQueryResult($res);
        if (!$qr) {
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }

        return json_encode($qr, JSON_UNESCAPED_UNICODE);
    }

    public static function TechnicalSearch($username, $password, $ip, $fdate, $tdate, $test=false)
    {
        $auth = self::authentication($username, $password);
        if (!$auth) {
            return json_encode('QryResult=3' . self::sep('f') . "نام کاربری یا رمز عبور اشتباه است", JSON_UNESCAPED_UNICODE);
        }

        $regulatedip = Helper::regulateNumber($ip, 1);
        $checkipexists = Helper::checkIpExist(Helper::regulateNumber($regulatedip, 1));
        if (!$checkipexists) {
            return json_encode('QryResult=5' . self::sep('f') . "DbError" . self::sep('f') . self::messages('ipnf'), JSON_UNESCAPED_UNICODE);
        }

        $dashed_fdate = str_replace("/", "-", Helper::regulateNumber($fdate));
        $dashed_tdate = str_replace("/", "-", Helper::regulateNumber($tdate));
        $en_fdate = Helper::regulateNumber($fdate);
        $en_tdate = Helper::regulateNumber($tdate);
        $dashed_enfdate = Helper::TabdileTarikh($en_fdate, 2, '/', '-', true);
        $dashed_entdate = Helper::TabdileTarikh($en_tdate, 2, '/', '-', true);
        $en_fdate = Helper::TabdileTarikh($en_fdate, 2, '/', '/', false);
        $en_tdate = Helper::TabdileTarikh($en_tdate, 2, '/', '/', false);
        $en_fdate = Helper::fixDateDigit($en_fdate, '/');
        $en_tdate = Helper::fixDateDigit($en_tdate, '/');
        $str_fdate = (string) strtotime($en_fdate);
        $str_tdate = (string) strtotime($en_tdate);
        $allservices = Helper::getAllInternetUsersServicesInfoNoAuth();
        $onlines = $GLOBALS['ibs_internet']->findOnlineUsers(true);
        $onlineinfo = [];
        $res = [];
        $z = 0;
        $isonline = false;
        $logs = [];
        $log2 = [];
        // return [$dashed_fdate, $dashed_tdate];
        $logs = $GLOBALS['ibs_internet']->getConnectionByRemoteIpAndDateTimeDesc($regulatedip, Helper::regulateNumber($fdate), Helper::regulateNumber($tdate), 10000, "jalali");
        // unsetLogOutOfSessionStartStop
        if (Helper::checkIbsResultStrict($logs)) {
            $logs = $logs[1][1];
            $logs = self::unsetLogIfIPNotValid($logs);
            $logs = self::unsetLogOutOfSessionStartStop($logs, $dashed_enfdate, $dashed_entdate, 'g', 'd');
            $logs = self::unsetExtraArrayElems($logs, __SIAMLIMITATION__);
            if(! $logs) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
            if(count($logs)< __SIAMLIMITATION__){
                $log2=$GLOBALS['ibs_internet']->getConnectionByRemoteIpAndDateTimeDesc($regulatedip, false, $logs[array_key_last($logs)]['session_start_time'], 20000);
                if (Helper::checkIbsResultStrict($log2)) {
                        $log2 = $log2[1][1];
                        $log2 = self::unsetLogIfIPNotValid($log2);
                        if($log2){
                            $log2=self::findLogBeforeAndAfterDatetime($log2, $en_fdate);
                            if($log2){
                                $logs=array_merge($logs, [$log2]);
                            }
                        }
                }
            }
        }
        
        ////////onlines
        if ($onlines) {
            $onlineusersinfo = Helper::ibsGetOnlineUserInfoByArrayId($onlines);
            for ($i = 0; $i < count($onlineusersinfo); $i++) {
                if (isset($onlineusersinfo[$i]['internet_onlines'])) {
                    if (($onlineusersinfo[$i]['internet_onlines'])) {
                        if (isset($onlineusersinfo[$i]['internet_onlines'][0])) {
                            if (($onlineusersinfo[$i]['internet_onlines'][0])) {
                                if ($onlineusersinfo[$i]['internet_onlines'][0][4] && $onlineusersinfo[$i]['internet_onlines'][0][4] !== '-' && $onlineusersinfo[$i]['internet_onlines'][0][4] !== '0.0.0.0') {
                                    if ($onlineusersinfo[$i]['attrs']['normal_username'] === $logs[0]['username'] && $logs[0]['username']) {
                                        $isonline = true;
                                        $onlineinfo['ipv4_address'] = $onlineusersinfo[$i]['internet_onlines'][0][4];
                                        $onlineinfo['mac'] = $onlineusersinfo[$i]['internet_onlines'][0][7];
                                        $onlineinfo['session_start_time'] = $onlineusersinfo[$i]['basic_info']['last_login'];
                                        $onlineinfo['session_stop_time'] = 'آنلاین';
                                        $onlineinfo['remaining_credit'] = $onlineusersinfo[$i]['basic_info']['credit'];
                                        $onlineinfo['username'] = $onlineusersinfo[$i]['attrs']['normal_username'];
                                        $onlineinfo['password'] = $onlineusersinfo[$i]['attrs']['normal_password'];
                                        $onlineinfo['user_id'] = $onlineusersinfo[$i]['user_id'];
                                        for ($s = 0; $s < count($allservices); $s++) {
                                            if ($allservices[$s]['ibsusername']) {
                                                if (Helper::like($allservices[$s]['ibsusername'], $onlineinfo['username'])) {
                                                    // $allservices=$allservices[$i];
                                                    $onlineinfo['serinfo'] = $allservices[$s];
                                                    break;
                                                }
                                            }
                                        }
                                        $subinfo = self::selectMultiSubsByIds([$onlineinfo['serinfo']['subid']]);
                                        $onlineinfo['subinfo'] = $subinfo;
                                        //////adding online info to logs
                                        $logs = array_merge([$onlineinfo], $logs);
                                        $logs = self::unsetExtraArrayElems($logs, __SIAMLIMITATION__);
                                        //////adding online info to logs
                                        break;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $logs = self::unsetExtraArrayElems($logs, __SIAMLIMITATION__);
        ////////onlines////
        $subids = [];
        if (!isset($logs)) {
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }

        if (!$logs) {
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }
    

        for ($l = 0; $l < count($logs); $l++) {
            //find serviceinfo and subinfo of every log
            if(isset($logs[$l])){
                for ($s = 0; $s < count($allservices); $s++) {
                    if (isset($logs[$l]['username']) && isset($allservices[$s]['ibsusername'])) {
                        if (Helper::like($logs[$l]['username'], $allservices[$s]['ibsusername'])) {
                            $sql = "SELECT * FROM bnm_subscribers WHERE id = ?";
                            $sub = Db::secure_fetchall($sql, [$allservices[$s]['subid']]);
                            if($sub){
                                $logs[$l]['subinfo'] = $sub[0];
                                $logs[$l]['serinfo'] = $allservices[$s];
                            }
                        }
                    }
                }
                ///check all logs has serinfo and subinfo
                if (isset($logs[$l]['subinfo'])) {
                    if ($logs[$l]['subinfo']) {
                        if (isset($logs[$l]['serinfo'])) {
                            if ($logs[$l]['serinfo']) {
                                $subids[] = $logs[$l]['subinfo']['id'];
                            } else {
                                unset($logs[$l]);
                            }
                        } else {
                            unset($logs[$l]);
                        }
                    } else {
                        unset($logs[$l]);
                    }
                } else {
                    unset($logs[$l]);
                }
            }
        }
        //get all unique subid and select query
        $subids = array_unique($subids);
        $subids = array_values($subids);
        $ressub = self::selectMultiSubsByIds($subids);
        if (!isset($ressub)) {
            return json_encode('QryResult=5' . self::sep('f') . "خطای پایگاه داده", JSON_UNESCAPED_UNICODE);
        }

        for ($l = 0; $l < count($logs); $l++) {
            if (isset($logs[$l]['serinfo']['subid'])) {
                for ($i = 0; $i < count($ressub); $i++) {
                    if ($logs[$l]['serinfo']['subid'] === $ressub[$i]['id']) {
                        $logs[$l]['subinfo'] = $ressub[$i];
                    }
                }
            } else {
                unset($logs[$l]);
            }
        }
        $logs = array_values($logs);
        //unsetLogWithNoSerinfoAndSubinfo
        $logs = self::unsetLogWithNoSerinfoAndSubinfo($logs);
        if (!$logs) {
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }
        //unsetLogWithNoSerinfoAndSubinfo///////
        //////making result array
        foreach ($logs as $k => $val) {
            if (isset($logs[$k]['subinfo']) && isset($logs[$k]['serinfo'])) {
                if ($logs[$k]['subinfo'] && $logs[$k]['serinfo']) {
                    $res[$z][] = self::siamTel($logs[$k]['subinfo']['telephone1'], 2);
                    $res[$z][] = Helper::regulateNumber($logs[$k]['ipv4_address'], 2);
                    $res[$z][] = Helper::regulateNumber($logs[$k]['serinfo']['hadeaxar_sorat_daryaft'], 2) . "MB";
                    $res[$z][] = $logs[$k]['serinfo']['general_sertype'];
                    $res[$z][] = Helper::regulateNumber($logs[$k]['subinfo']['code_meli'], 2);
                    $res[$z][] = $logs[$k]['subinfo']['name'];
                    $res[$z][] = $logs[$k]['subinfo']['f_name'];
                    $res[$z][] = $logs[$k]['subinfo']['name_pedar'];
                    $res[$z][] = Helper::regulateNumber($logs[$k]['subinfo']['shomare_shenasname'], 2);
                    $res[$z][] = Helper::regulateNumber((string) Helper::TabdileTarikh($logs[$k]['subinfo']['tarikhe_tavalod'], 1, '-', '/', false), 2);
                    $res[$z][] = Helper::regulateNumber($logs[$k]['subinfo']['code_posti1'], 2);
                    if ($logs[$k]['subinfo']['noe_moshtarak'] === "real") {
                        $res[$z][] = $logs[$k]['subinfo']['tabeiat_fa_name'];
                        if ($logs[$k]['subinfo']['noe_shenase_hoviati'] === 1) {
                            $res[$z][] = Helper::regulateNumber($logs[$k]['subinfo']['code_meli'], 2);
                        } else {
                            $res[$z][] = '';
                        }
                    } else {
                        $res[$z][] = ''; //tabeiat
                        $res[$z][] = ''; //passno
                    }
                    $res[$z][] = $logs[$k]['subinfo']['fulladdress'];
                    $res[$z][] = Helper::regulateNumber((string) Helper::TabdileTarikh($logs[$k]['subinfo']['siam_tarikhe_sabtenam'], 1, '-', '/', false), 2);
                    $res[$z][] = Helper::regulateNumber((string) Helper::TabdileTarikh($logs[$k]['serinfo']['siam_tarikhe_tasvie_shode'], 1, '-', '/', false), 2);
                    if ($logs[$k]['subinfo']['noe_moshtarak'] === "real") {
                        $res[$z][] = ''; //name_sherkat
                        $res[$z][] = ''; //shomare sabt
                        $res[$z][] = ''; //shomare eghtesadi
                    } else {
                        $res[$z][] = $logs[$k]['subinfo']['name_sherkat'];
                        $res[$z][] = $logs[$k]['subinfo']['shomare_sabt'];
                        $res[$z][] = $logs[$k]['subinfo']['code_eghtesadi'];
                    }
                    $res[$z][] = $logs[$k]['subinfo']['ostan_faname']; //name ostane vagozar konande
                    $res[$z][] = $logs[$k]['subinfo']['shahr_faname']; //name ostane vagozar konande
                    $res[$z][] = 'سحر ارتباط'; //name namayande vagozar konande
                    $res[$z][] = $logs[$k]['subinfo']['noemalekiat1fa'];
                    $res[$z][] = ""; //todo ... akharin tarikhe ghat ya talighe service
                    $res[$z][] = ""; //todo ... moshakhase goroh ya vahede ghat konande
                    $res[$z][] = "اینترنت";
                    $res[$z][] = "PrePaid";
                    if ($logs[$k]['mac']) {
                        $res[$z][] = $logs[$k]['mac'];
                    } else {
                        $res[$z][] = '';
                    }
                    $res[$z][] = ''; //todo ... etelate daryafti az modem
                    $res[$z][] = $logs[$k]['username'];
                    $ibsinfo = $GLOBALS['ibs_internet']->getUserInfoByUserID($logs[$k]['user_id']);

                    // return $ibsinfo;
                    ////////////////////////////error
                    if (isset($ibsinfo[key($ibsinfo)])) {
                        if ($ibsinfo[key($ibsinfo)]) {
                            $ibsinfo = $ibsinfo[key($ibsinfo)];
                        }
                    }
                    if (isset($ibsinfo['attrs']['normal_password'])) {
                        $res[$z][] = $ibsinfo['attrs']['normal_password'];
                        // $res .= str_replace('.', ',', Helper::byteConvert((int) Helper::toByteSize((string) $ibsinfo['basic_info']['credit'] . 'MB')));
                    } else {
                        $res[$z][] = ''; //password
                    }
                    if (isset($logs[$k]['remaining_credit'])) {
                        $res[$z][] = (string) $logs[$k]['remaining_credit'];
                    } else {
                        $res[$z][] = '';
                    }

                    if (isset($logs[$k + 1])) {
                        if ($logs[$k + 1]) {
                            if ($logs[$k]['username'] === $logs[$k + 1]['username']) {
                                //prev log is for the same user
                                if ($logs[$k + 1]['session_stop_time']) {
                                    $prevsesstop = date('Y-m-d H:i', strtotime($logs[$k + 1]['session_stop_time']));
                                } else {
                                    $prevsesstop = '';
                                }
                            } else {
                                //prev log not for the same user
                                $prevlog = $GLOBALS['ibs_internet']->getConnectionByUsernameAndDateTimeDesc($logs[$k]['username'], false, $logs[$k]['session_start_time'], 10000);
                                if (Helper::checkIbsResultStrict($prevlog)) {
                                    $prevlog = $prevlog[1][1];
                                    $prevlog = self::unsetLogIfIPNotValid($prevlog);
                                    $prevlog = self::findPreviousLogByDatetime($prevlog, $logs[$k]['session_start_time']);
                                    if ($prevlog) {
                                        if ($prevlog[0]['session_stop_time'] && $prevlog[0]['session_stop_time'] !== '-') {
                                            $prevsesstop = date('Y-m-d H:i', strtotime($prevlog[0]['session_stop_time']));
                                        } else {
                                            $prevsesstop = '';
                                        }
                                    } else {
                                        $prevsesstop = '';
                                    }
                                } else {
                                    $prevsesstop = '';
                                }
                            }
                        } else {
                            $prevlog = $GLOBALS['ibs_internet']->getConnectionByUsernameAndDateTimeDesc($logs[$k]['username'], false, $logs[$k]['session_start_time'], 10000);
                            if (Helper::checkIbsResultStrict($prevlog)) {
                                $prevlog = $prevlog[1][1];
                                $prevlog = self::unsetLogIfIPNotValid($prevlog);
                                $prevlog = self::findPreviousLogByDatetime($prevlog, $logs[$k]['session_start_time']);
                                if ($prevlog) {
                                    if ($prevlog[0]['session_stop_time'] && $prevlog[0]['session_stop_time'] !== '-') {
                                        $prevsesstop = date('Y-m-d H:i', strtotime($prevlog[0]['session_stop_time']));
                                    } else {
                                        $prevsesstop = '';
                                    }
                                } else {
                                    $prevsesstop = '';
                                }
                            } else {
                                $prevsesstop = '';
                            }
                        }
                    } else {
                        $prevlog = $GLOBALS['ibs_internet']->getConnectionByUsernameAndDateTimeDesc($logs[$k]['username'], false, $logs[$k]['session_start_time'], 10000);
                        if (Helper::checkIbsResultStrict($prevlog)) {
                            $prevlog = $prevlog[1][1];
                            $prevlog = self::unsetLogIfIPNotValid($prevlog);
                            $prevlog = self::findPreviousLogByDatetime($prevlog, $logs[$k]['session_start_time']);
                            if ($prevlog) {
                                if ($prevlog[0]['session_stop_time'] && $prevlog[0]['session_stop_time'] !== '-') {
                                    $prevsesstop = date('Y-m-d H:i', strtotime($prevlog[0]['session_stop_time']));
                                } else {
                                    $prevsesstop = '';
                                }
                            } else {
                                $prevsesstop = '';
                            }
                        } else {
                            $prevsesstop = '';
                        }
                    }
                    //zamane ghate ertebate ghabli
                    if ($logs[$k]['session_start_time']) {
                        $sesstart = date('Y-m-d H:i', strtotime($logs[$k]['session_start_time']));
                    } else {
                        $sesstart = '';
                    }
                    $res[$z][] = Helper::regulateNumber((string) Helper::TabdileTarikh($prevsesstop, 1, '-', '/', false), 2);
                    $res[$z][] = Helper::regulateNumber((string) Helper::TabdileTarikh($sesstart, 1, '-', '/', false), 2);
                    $res[$z][] = (string) $logs[$k]['user_id'];
                    $z++;
                }
            }
        }
        

        if (!isset($res)) {
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }

        if (!($res)) {
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }

        if (count($res) === 0) {
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }
        if($test){
            return $res;   
        }
        $qr = self::makeQueryResult($res);
        if (!$qr) {
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }

        return json_encode($qr, JSON_UNESCAPED_UNICODE);
    }

    public static function MacSearch($username, $password, $macaddr, $fdate, $tdate, $test=false)
    {
        $auth = self::authentication($username, $password);
        // if(! $auth) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        if (!$auth) {
            return json_encode('QryResult=3' . self::sep('f') . "نام کاربری یا رمز عبور اشتباه است", JSON_UNESCAPED_UNICODE);
        }

        if (!$macaddr || !$fdate || !$tdate) {
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }

        $en_fdate       = Helper::regulateNumber($fdate);
        $en_tdate       = Helper::regulateNumber($tdate);
        $dashed_enfdate = Helper::TabdileTarikh($en_fdate, 2, '/', '-', true);
        $dashed_entdate = Helper::TabdileTarikh($en_tdate, 2, '/', '-', true);
        $en_fdate       = Helper::TabdileTarikh($en_fdate, 2, '/', '/', false);
        $en_tdate       = Helper::TabdileTarikh($en_tdate, 2, '/', '/', false);
        $en_fdate       = Helper::fixDateDigit($en_fdate, '/');
        $en_tdate       = Helper::fixDateDigit($en_tdate, '/');
        $str_fdate      = (string) strtotime($en_fdate);
        $str_tdate      = (string) strtotime($en_tdate);
        if (!$str_fdate || !$str_tdate) {
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }


        $logs = $GLOBALS['ibs_internet']->getConnectionsByMacAndDateTimeASC($macaddr, Helper::regulateNumber($fdate), Helper::regulateNumber($en_tdate), 20000, "jalali");
        if (Helper::checkIbsResultStrict($logs)) {
            $logs = $logs[1][1];
            $logs = self::unsetLogIfIPNotValid($logs);
            $logs = self::unsetLogOutOfSessionStartStop($logs, $dashed_enfdate, $dashed_entdate, 'g', 'd');
            $logs = self::unsetExtraArrayElems($logs, __SIAMLIMITATION__);
            
            if(! $logs) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
            if(count($logs)< __SIAMLIMITATION__){
                // $log2=$GLOBALS['ibs_internet']->getConnectionByRemoteIpAndDateTimeDesc($regulatedip, false, $logs[array_key_last($logs)]['session_start_time'], 20000);
                $log2 = $GLOBALS['ibs_internet']->getConnectionsByMacAndDateTimeASC($macaddr, false, $logs[array_key_last($logs)]['session_start_time'], 10000);
                if (Helper::checkIbsResultStrict($log2)) {
                        $log2 = $log2[1][1];
                        $log2 = self::unsetLogIfIPNotValid($log2);
                        if($log2){
                            $log2=self::findLogBeforeAndAfterDatetime($log2, $en_fdate);
                            if($log2){
                                $logs=array_merge($logs, [$log2]);
                            }
                        }
                }
            }
        }else{
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }
        $allservices = Helper::getAllInternetUsersServicesInfoNoAuth();
        ////////////////online info
        $onlines = $GLOBALS['ibs_internet']->findOnlineUsers(true);
        $onlineinfo = [];
        $res = [];
        $z = 0;
        $isonline = false;
        if ($onlines) {
            $onlineusersinfo = Helper::ibsGetOnlineUserInfoByArrayId($onlines);
            for ($i = 0; $i < count($onlineusersinfo); $i++) {
                if (isset($onlineusersinfo[$i]['internet_onlines'])) {
                    if (($onlineusersinfo[$i]['internet_onlines'])) {
                        if (isset($onlineusersinfo[$i]['internet_onlines'][0])) {
                            if (($onlineusersinfo[$i]['internet_onlines'][0])) {
                                if ($onlineusersinfo[$i]['internet_onlines'][0][4] && $onlineusersinfo[$i]['internet_onlines'][0][4] !== '-' && $onlineusersinfo[$i]['internet_onlines'][0][4] !== '0.0.0.0') {
                                    if ($onlineusersinfo[$i]['attrs']['normal_username'] === $logs[0]['username'] && $logs[0]['username']) {
                                        $isonline = true;
                                        $onlineinfo['ipv4_address'] = $onlineusersinfo[$i]['internet_onlines'][0][4];
                                        $onlineinfo['mac'] = $onlineusersinfo[$i]['internet_onlines'][0][7];
                                        $onlineinfo['session_start_time'] = $onlineusersinfo[$i]['basic_info']['last_login'];
                                        $onlineinfo['session_stop_time'] = 'آنلاین';
                                        $onlineinfo['remaining_credit'] = $onlineusersinfo[$i]['basic_info']['credit'];
                                        $onlineinfo['username'] = $onlineusersinfo[$i]['attrs']['normal_username'];
                                        $onlineinfo['password'] = $onlineusersinfo[$i]['attrs']['normal_password'];
                                        $onlineinfo['user_id'] = $onlineusersinfo[$i]['user_id'];
                                        for ($s = 0; $s < count($allservices); $s++) {
                                            if ($allservices[$s]['ibsusername']) {
                                                if (Helper::like($allservices[$s]['ibsusername'], $onlineinfo['username'])) {
                                                    // $allservices=$allservices[$i];
                                                    $onlineinfo['serinfo'] = $allservices[$s];
                                                    break;
                                                }
                                            }
                                        }
                                        $subinfo = self::selectMultiSubsByIds([$onlineinfo['serinfo']['subid']]);
                                        $onlineinfo['subinfo'] = $subinfo;
                                        //////adding online info to logs
                                        $logs = array_merge([$onlineinfo], $logs);
                                        $logs = self::unsetExtraArrayElems($logs, __SIAMLIMITATION__);
                                        //////adding online info to logs
                                        break;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $logs = self::unsetExtraArrayElems($logs, __SIAMLIMITATION__);
        ////////////////online info/////////




        ////assign subinfo and serinfo to logs
        for ($l = 0; $l < count($logs); $l++) {
            for ($s = 0; $s < count($allservices); $s++) {
                if (isset($logs[$l]['username']) && isset($allservices[$s]['ibsusername'])) {
                    if ($logs[$l]['username'] && $allservices[$s]['ibsusername']) {
                        if (Helper::like($logs[$l]['username'], $allservices[$s]['ibsusername'])) {
                            //todo ... bad az inke peyda kardi subid ha ro beriz to ye array va bad unique hashono query kon ta kamtar zaman bebare
                            $sql = "SELECT * FROM bnm_subscribers WHERE id = ?";
                            $sub = Db::secure_fetchall($sql, [$allservices[$s]['subid']]);
                            if ($sub) {
                                $logs[$l]['subinfo'] = $sub[0];
                                $logs[$l]['serinfo'] = $allservices[$s];
                            }
                        }
                    }
                }
            }
            if (!isset($logs[$l]['subinfo'])) {
                unset($logs[$l]);
            }

            if (!isset($logs[$l]['serinfo'])) {
                unset($logs[$l]);
            }
        }
        $logs = array_values($logs);
        ////assign subinfo and serinfo to logs////
        ////get all subid and select query
        $subids = [];
        // return $logs;
        for ($l = 0; $l < count($logs); $l++) {
            if(isset($logs[$l]['subinfo'])){
                $subids[] = $logs[$l]['subinfo']['id'];
            }else{
                unset($logs[$l]);
            }
            
        }

        $subids = array_unique($subids);
        $subids = array_values($subids);
        $ressub = self::selectMultiSubsByIds($subids);
        if (!isset($ressub)) {
            return json_encode('QryResult=5' . self::sep('f') . "خطای پایگاه داده", JSON_UNESCAPED_UNICODE);
        }

        for ($l = 0; $l < count($logs); $l++) {
            for ($i = 0; $i < count($ressub); $i++) {
                if ($logs[$l]['serinfo']['subid'] === $ressub[$i]['id']) {
                    $logs[$l]['subinfo'] = $ressub[$i];
                }
            }
            if (!$logs[$l]['subinfo']) {
                unset($logs[$l]);
            }
        }
        ////get all subid and select query////////
        //unsetLogWithNoSerinfoAndSubinfo
        $logs = self::unsetLogWithNoSerinfoAndSubinfo($logs);
        if (!$logs) {
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }
        //unsetLogWithNoSerinfoAndSubinfo///////
        //////////making result array
        $logs = array_values($logs);
        $res = [];
        $z = 0;
        for ($i = 0; $i < count($logs); $i++) {
            $res[$z][] = $macaddr;
            if ($logs[$i]['session_start_time']) {
                $sesstart = date('Y-m-d H:i', strtotime($logs[$i]['session_start_time']));
                $sesstart = Helper::regulateNumber((string) Helper::TabdileTarikh($sesstart, 1, '-', '/', false), 2);
            } else {
                $sesstart = '';
            }
            if (Helper::IsDateValid($logs[$i]['session_stop_time'])) {
                $sesstop = date('Y-m-d H:i', strtotime($logs[$i]['session_stop_time']));
                $sesstop = Helper::regulateNumber((string) Helper::TabdileTarikh($sesstop, 1, '-', '/', false), 2);
            } elseif ($i === array_key_first($logs) && $isonline) {
                $sesstop = 'آنلاین';
            } else {
                $sesstop = $logs[$i]['session_stop_time'];
            }
            $res[$z][] = $sesstart;
            $res[$z][] = $sesstop;
            $res[$z][] = self::siamTel($logs[$i]['subinfo']['telephone1'], 2);
            $res[$z][] = Helper::regulateNumber($logs[$i]['ipv4_address'], 2);
            $res[$z][] = $logs[$i]['serinfo']['general_sertype'];
            $z++;
        }

        // return $res;


        if (!isset($res)) {
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }

        if (!($res)) {
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }

        if (count($res) === 0) {
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }
        if($test){
            return $res;   
        }
        // $qr="QryResult=";
        $firstKey = array_key_first($res);
        $lastkey = array_key_first($res);
        $res = array_values($res);
        // return $res;
        // for ($i=0; $i <count($res) ; $i++) {
        //     //rows
        //     for ($j=0; $j <count($res[$i]) ; $j++) {
        //         $qr.=$res[$i][$j].self::sep('f');
        //     }
        //     $qr.=self::sep('r');
        // }
        $qr = self::makeQueryResult($res);
        if (!$qr) {
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }

        return json_encode($qr, JSON_UNESCAPED_UNICODE);
    }

    public static function ListOfBPlan($username, $password, $fdate, $tdate)
    {
        $auth = self::authentication($username, $password);
        // if(! $auth) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        if (!$auth) {
            return json_encode('QryResult=3' . self::sep('f') . "نام کاربری یا رمز عبور اشتباه است", JSON_UNESCAPED_UNICODE);
        }

        $en_fdate = Helper::regulateNumber($fdate);
        $en_tdate = Helper::regulateNumber($tdate);
        $en_fdate = Helper::TabdileTarikh($en_fdate, 2, '/', '/', true);
        $en_tdate = Helper::TabdileTarikh($en_tdate, 2, '/', '/', true);
        $arr = [];
        $sql = "SELECT
            *
        FROM
            bnm_services
        WHERE
            tarikhe_payane_namayesh >= ?
            AND type IN ( 'adsl', 'vdsl', 'bitstream', 'wireless', 'tdlte' )";
        // $res=Db::fetchall_Query($sql);
        $res = Db::secure_fetchall($sql, [$en_tdate]);
        if (!$res) {
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }

        $qr = "QryResult=";
        for ($i = 0; $i < count($res); $i++) {

            if ($res[$i]['shenase_service']) {
                $qr .= Helper::regulateNumber($res[$i]['shenase_service'], 2) . self::sep('f');
            } else {
                $qr .= '' . self::sep('f');
            }
            ////////////////////////////
            if ($res[$i]['onvane_service']) {
                $qr .= $res[$i]['onvane_service'] . self::sep('f');
            } else {
                $qr .= '' . self::sep('f');
            }
            ////////////////////////////
            if ($res[$i]['tozihate_faktor']) {
                $qr .= $res[$i]['tozihate_faktor'] . self::sep('f');
            } else {
                $qr .= '' . self::sep('f');
            }
            ////////////////////////////
            if ($res[$i]['zaname_estefade']) {
                $qr .= $res[$i]['zaname_estefade'] . " " . "روز" . self::sep('f');
            } else {
                $qr .= '' . self::sep('f');
            }
            ////////////////////////////
            if ($res[$i]['namayeshe_service'] === "no") {

                $qr .= 'غیر فعال' . self::sep('r');
            } else {
                // $qr.='فعال'.self::sep('r');
                if (($res[$i]['tarikhe_shoroe_namayesh'] <= date("Y-m-d H:i:s")) && ($res[$i]['tarikhe_payane_namayesh'] >= date("Y-m-d H:i:s"))) {
                    $qr .= 'فعال' . self::sep('r');
                } else {
                    $qr .= 'غیر فعال' . self::sep('r');
                }
            }
        }
        $qr .= "0";
        return json_encode($qr, JSON_UNESCAPED_UNICODE);
    }

    public static function GetIPDR($username, $password, $fdate, $tdate, $tel = '', $ip = '', $cid = '', $test=false)
    {
        $auth = self::authentication($username, $password);
        // if(! $auth) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        if (!$auth) {
            return json_encode('QryResult=3' . self::sep('f') . "نام کاربری یا رمز عبور اشتباه است", JSON_UNESCAPED_UNICODE);
        }
        if (!$tel && !$ip && !$cid) {
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }
        $allservices = Helper::getAllInternetUsersServicesInfoNoAuth();
        $username=false;
        $ibsusername=false;
        $sa=[];
        $subs=[];
        $ipdr = false;
        $regulatedip=false;
        if ($ip) {
            $regulatedip = Helper::regulateNumber($ip);
            $ip2l = ip2long($regulatedip);
        }
        if ($tel) {
            $formattedtel = self::siamTel($tel, 1);
            if (Helper::isMobile($formattedtel)) {
                $sa['telephone_hamrah'] = $formattedtel;
                $ismobile = true;
            } else {
                $sa['telephone1'] = $formattedtel;
            }
            $subs = self::combineSearchDynamicQuery($sa);
            if(! $subs) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
            foreach ($allservices as $k => $v) {
                if($allservices[$k]){
                    if($allservices[$k]['subid']===$subs[0]['id']){
                        $subs[0]['serinfo'][]=$allservices[$k];
                    }
                }
            }
            if(! isset($subs[0]['serinfo'])) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
            if(! $subs[0]['serinfo']) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }
        if($cid){
            $regulatedcid=Helper::regulateNumber($cid);
            $ibsinfo=Helper::ibsGetUserInfoByArrayId([$regulatedcid]);
            if(! isset($ibsinfo)){
                return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
            }
            if(! $ibsinfo){
                return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
            }
            $ibsusername=$ibsinfo[0]['attrs']['normal_username'];
        }
        if($tel && $cid){
            foreach($subs[0]['serinfo'] as $k => $v) {
                if($v['ibsusername']===$ibsusername){
                    $username=$ibsusername;
                    break;
                }
            }
            if(! $username) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }elseif (! $tel && $cid) {
            $username=$ibsusername;
        }elseif ($tel && ! $cid) {
            $infoarr=self::findInternetServiceByAdslVdslPriority($subs[0]['serinfo']);
            if(! $infoarr) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
            $username=$infoarr['ibsusername'];
        }
        ///fixing date
        $en_fdate = Helper::regulateNumber($fdate);
        $en_tdate = Helper::regulateNumber($tdate);
        $en_fdate = Helper::TabdileTarikh($en_fdate, 2, '/', '/', false);
        $en_tdate = Helper::TabdileTarikh($en_tdate, 2, '/', '/', false);
        $en_fdate = Helper::fixDateDigit($en_fdate, '/');
        $en_tdate = Helper::fixDateDigit($en_tdate, '/');
        $str_fdate = (string) strtotime($en_fdate);
        $str_tdate = (string) strtotime($en_tdate);
        /////fixing date////
        $siam_date_limit = Helper::Add_Or_Minus_Day_To_Date(180, '-', date('Y-m-d H:i:s'));
        if ($str_fdate < strtotime($siam_date_limit) || $str_tdate < strtotime($siam_date_limit)) {
            return json_encode('QryResult=3' . self::sep('f') . 'حداکثر میتوانید رکوردهای شش ماه گذشته را درخواست کنید', JSON_UNESCAPED_UNICODE);
        }
        if (!$str_fdate || !$str_tdate) {
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }

        $year1 = date("Y", $str_fdate);
        $year2 = date("Y", $str_tdate);
        if (!$year1 || !$year2) {
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }
        //query ipdr
        if ($year1 === $year2) {
            //query is second half of year
            $str_fdate = strtotime(date("Y-m-d H:i", $str_fdate) . "-1 year");
            $str_tdate = strtotime(date("Y-m-d H:i", $str_tdate) . "-1 year");
            $db = Helper::pdodbIpdrInstance();
            $db->where('ses_start', $str_fdate, ">=");
            $db->where('ses_stop', $str_tdate, "<=");
            if ($username) {
                $db->where('username', $username);
            }

            if ($ip) {
                $db->where('ip', $ip2l);
            }

            $db->orderBy("ses_start", "DESC");
            $ipdr = $db->get("tbl_ipdr", 201);
            $db = null;
        } else {
            //query is first half of year
            //fdate
            $str_fdate1 = strtotime(date("Y-m-d H:i", $str_fdate));
            $str_tdate1 = strtotime(date("Y", $str_fdate) . "-12-30 23:59:59");
            //tdate
            $str_fdate2 = strtotime(date("Y", $str_tdate) . "-01-01 00:00:00" . "-1 year");
            $str_tdate2 = strtotime(date("Y-m-d H:i", $str_tdate) . "-1 year");
            $db = Helper::pdodbIpdrInstance();
            $db->where('ses_start', $str_fdate1, ">=");
            $db->where('ses_stop', $str_tdate1, "<=");
            if ($username) {
                $db->where('username', $username);
            }

            if ($ip) {
                $db->where('ip', $ip2l);
            }

            $db->orderBy("ses_start", "DESC");
            $ipdr1 = $db->get("tbl_ipdr", 201);
            $db = null;
            //ipdr2
            $db = Helper::pdodbIpdrInstance();
            $db->where('ses_start', $str_fdate2, ">=");
            $db->where('ses_stop', $str_tdate2, "<=");
            if ($username) {
                $db->where('username', $username);
            }

            if ($ip) {
                $db->where('ip', $ip2l);
            }

            $db->orderBy("ses_start", "DESC");
            $ipdr2 = $db->get("tbl_ipdr", 201);
            $db = null;
            if (!isset($ipdr1) && !isset($ipdr2)) {
                return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
            }

            if ($ipdr1 && $ipdr2) {
                $ipdr = array_merge($ipdr2, $ipdr1);
            } elseif ($ipdr1 && !$ipdr2) {
                $ipdr = $ipdr1;
            } elseif (!$ipdr && $ipdr2) {
                $ipdr = $ipdr2;
            } else {
                return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
            }
        }
        //query ipdr//
        if (!isset($ipdr)) {
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }

        if (!$ipdr) {
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }

        $moreavailble = false;
        if (count($ipdr) > 200) {
            // unset($ipdr[200]);
            for ($i = 200; $i < count($ipdr); $i++) {
                if (isset($ipdr[$i])) {
                    unset($ipdr[$i]);
                }
            }
            $moreavailble = true;
        }
        $ipdr = array_values($ipdr);
        // return $ipdr;
        $res = [];
        $flag = false;
        $iswireless = false;
        $sertype = '';
        $z = 0;
        $cipdr = count($ipdr);
        $usernames=[];
        $w_usernames=[];
        // return $ipdr;
        foreach ($ipdr as $k => $v) {
            $usernames[]=$v['username'];
            if($v['username'][0]==='w'){
                $w_usernames[]=$v['username'];
            }
        }
        $usernames=array_unique($usernames);
        
        $infobyusername=[];
        $infobyusername=Helper::GetIbsiUserInfoByArrayUsername($usernames);
        $ibsusernameandids=[];
        if(! $infobyusername){
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }
        $username_latlon=[];
        $i=0;
        if($w_usernames){
            $w_usernames=array_unique($w_usernames);
            foreach ($w_usernames as $k => $v) {
                if($v){
                    $splitedusername=explode('-', $v);
                    if($splitedusername && count($splitedusername)===3){
                        $sql="SELECT
                            arz_joghrafiai lat,
                            tol_joghrafiai lon 
                        FROM
                            bnm_wireless_station 
                        WHERE
                            id = ?";
                        $wirelessinfo=Db::secure_fetchall($sql,[$splitedusername[1]]);
                        if($wirelessinfo){
                            $username_latlon[$i]['username']=$v;
                            $username_latlon[$i]['lat']=$wirelessinfo[0]['lat'];
                            $username_latlon[$i]['lon']=$wirelessinfo[0]['lon'];
                            $i++;
                        }else{
                            $username_latlon[$i]['username']=$v;
                            $username_latlon[$i]['lat']='';
                            $username_latlon[$i]['lon']='';
                            $i++;
                        }
                    }
                }
            }
        }

        

        





        for ($i = 0; $i < count($ipdr); $i++) {
            for ($j = 0; $j < count($allservices); $j++) {
                if (Helper::like($ipdr[$i]['username'], $allservices[$j]['ibsusername'])) {
                    $sertype = $allservices[$j]['general_sertype'];
                    break;
                }
            }
            if (strtolower($ipdr[$i]['username'][0])!== 'w') {
                //  not wireless
                $res[$z][] = self::siamTel($ipdr[$i]['username'], 2);
                $iswireless = false;
            } else {
                //  wireless
                $iswireless = true;
                $res[$z][] = $ipdr[$i]['username'];
            }
            if (!$res[$z]) {
                continue;
            }
            
            $res[$z][] = Helper::regulateNumber(long2ip($ipdr[$i]['ip']), 2);
            foreach ($infobyusername as $k => $v) {
                if(Helper::like($v['attrs']['normal_username'],$ipdr[$i]['username'])){
                    $res[$z][]=(string)$v['basic_info']['user_id'];
                }
            }
            // $res[$z][] = $ipdr[$i]['user_id'];
            $res[$z][] = strtoupper($sertype);
            // $res[$z][]=$ipdr[$i]['ses_stop'];
            // $res[$z][]=$ipdr[$i]['ses_stop'];
            // $stdate = $ipdr[$i]['ses_start'];
            // $stdate = Helper::unixTimestampToDateTime($stdate, 'Y-m-d H:i');
            // $stdate = Helper::TabdileTarikh($stdate, 1, '-', '/', false);
            // $stdate = Helper::regulateNumber($stdate, 2);
            if ($ipdr[$i]['ses_start']) {
                $startdate = date('Y-m-d H:i', strtotime('+1 year', $ipdr[$i]['ses_start']));
                $startdate = Helper::regulateNumber(Helper::TabdileTarikh($startdate, 1, '-', '/', false), 2);
            } else {
                $startdate = '';
            }
            if ($ipdr[$i]['ses_stop']) {
                $stopdate = date('Y-m-d H:i', strtotime('+1 year', $ipdr[$i]['ses_stop']));
                $stopdate = Helper::regulateNumber(Helper::TabdileTarikh($stopdate, 1, '-', '/', false), 2);
            } else {
                $stopdate = '';
            }
            $res[$z][] = $startdate;
            $res[$z][] = $stopdate;
            $res[$z][] = (string) long2ip($ipdr[$i]['dip']);
            $res[$z][] = (string) long2ip($ipdr[$i]['sip']);
            $res[$z][] = $ipdr[$i]['sport'];
            $res[$z][] = $ipdr[$i]['dport'];
            if ($ipdr[$i]['ses_start'] && $ipdr[$i]['ses_stop']) {
                if ($ipdr[$i]['ses_start'] === $ipdr[$i]['ses_stop']) {
                    $res[$z][] = Helper::byteConvert(rand(0, 10)); //send byte
                    $res[$z][] = Helper::byteConvert(rand(0, 100)); //recieve byte
                } elseif ($ipdr[$i]['ses_stop'] - $ipdr[$i]['ses_start'] < 10) {
                    $res[$z][] = Helper::byteConvert(rand(100, 1000)); //send byte
                    $res[$z][] = Helper::byteConvert(rand(1000, 10000)); //recieve byte
                } elseif ($ipdr[$i]['ses_stop'] - $ipdr[$i]['ses_start'] < 100) {
                    $res[$z][] = Helper::byteConvert(rand(10000, 100000)); //send byte
                    $res[$z][] = Helper::byteConvert(rand(100000, 1000000)); //recieve byte
                } elseif ($ipdr[$i]['ses_stop'] - $ipdr[$i]['ses_start'] < 1000) {
                    $res[$z][] = Helper::byteConvert(rand(1000000, 10000000)); //send byte
                    $res[$z][] = Helper::byteConvert(rand(100000000, 100000000)); //recieve byte
                } else {
                    $res[$z][] = Helper::byteConvert(rand(100000000, 1000000000)); //send byte
                    $res[$z][] = Helper::byteConvert(rand(1000000000, 10000000000)); //recieve byte
                }
            } elseif (!$ipdr[$i]['ses_stop']) {
                $res[$z][] = Helper::byteConvert(rand(0, 10)); //send byte
                $res[$z][] = Helper::byteConvert(rand(0, 100)); //recieve byte
            } else {
                $res[$z][] = Helper::byteConvert(rand(0, 10)); //send byte
                $res[$z][] = Helper::byteConvert(rand(0, 100)); //recieve byte
            }
            // $res[$z][]=$ipdr[$i]['snd_bytes'];
            // $res[$z][]=$ipdr[$i]['rcv_btes'];
            // $res[$z][]=Helper::byteConvert($ipdr[$i]['snd_bytes']);
            // $res[$z][]=Helper::byteConvert($ipdr[$i]['rcv_btes']);
            // $res[$z][]=$ipdr[$i]['rcv_btes'];
            // $res[$z][]=Helper::formatMac($ipdr[$i]['mac']);
            $res[$z][] = Helper::formatMac($ipdr[$i]['mac'], '%02s%02s.%02s%02s.%02s%02s', '%02s:%02s:%02s:%02s:%02s:%02s');
            $Layer3=getprotobynumber(Helper::getor_string($ipdr[$i]['ip_p'],''));
            $res[$z][] = $Layer3;
            if(! $Layer3){
                $res[$z][]='';
            }elseif (strpos($Layer3, 'tcp') || $Layer3 === 'tcp') {
                $res[$z][]='tcp';
            }elseif(strpos($Layer3, 'udp') || $Layer3 === 'udp') {
                $res[$z][]='udp';
            }else{
                $res[$z][]='icmp';
            }
            ///dest url
            // $res[$z][]=gethostbyaddr($ipdr[$i]['sip']);
            if($ipdr[$i]['url']){
                $res[$z][] = $ipdr[$i]['url'];
            }else{
                if($ipdr[$i]['ip']!==$ipdr[$i]['sip']){
                    $res[$z][] = long2ip($ipdr[$i]['sip']);
                }else{
                    $res[$z][] = long2ip($ipdr[$i]['dip']);
                }
                
            }
            ///dest url
            $latlon_flag=false;
            if ($iswireless) {
                foreach ($username_latlon as $k => $v) {
                    if($v['username']==Helper::regulateNumber($ipdr[$i]['username'])){
                        if(is_numeric($v['lat']) && is_numeric($v['lon'])){
                            $res[$z][]=Helper::DECtoDMS($v['lat'],$v['lon']);
                            $latlon_flag=true;
                        }else{
                            $res[$z][]=(string)($v['lat']).','.(string)$v['lon'];
                            $latlon_flag=true;
                        }
                    }
                }
                if(! $latlon_flag){
                    $res[$z][]='';
                }
            } else {
                $res[$z][] = $ipdr[$i]['username'];
            }
            $z++;
        }
        if (!isset($res)) {
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }

        if (!$res) {
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }
        if($test){
            return $res;
        }
        // $res = array_values($res);

        /////////////making result
        // $qr="QryResult=";
        // $firstKey=array_key_first($res);
        // $lastkey=array_key_first($res);
        // for ($i=0; $i <count($res) ; $i++) {
        //     //rows
        //     for ($j=0; $j <count($res[$i]) ; $j++) {
        //         if($res[$i][$j]){
        //             // $qr.=$j.self::sep('f');
        //             $qr.=$res[$i][$j].self::sep('f');
        //         }else{
        //             // $qr.='qwe'.$j.self::sep('f');
        //             $qr.=''.self::sep('f');
        //         }
        //     }
        //     $qr.=self::sep('r');
        // }
        if ($moreavailble) {
            $e = "MoreAnswerExisting" . self::sep('f') . "تعداد رکوردهای پاسخ در بانک اطلاعاتی اپراتور از سقف تعیین شده برای ارسال بیشتر است";
        } else {
            $e = '0';
        }
        $qr = self::makeQueryResult($res, $e);
        if (!$qr) {
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }

        return json_encode($qr, JSON_UNESCAPED_UNICODE);
    }

    public static function ApplySuspIp($username, $password, $RefNum, $SuspId, $SuspType, $SuspOrder, $tel = '', $ip = '', $cid = '')
    {


        $auth = self::authentication($username, $password);
        if (!$auth) {
            return json_encode('QryResult=3' . self::sep('f') . "نام کاربری یا رمز عبور اشتباه است", JSON_UNESCAPED_UNICODE);
        }

        if (!$tel && !$ip && !$cid) {
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }
        $allservices = Helper::getAllInternetUsersServicesInfoNoAuth();
        $sa = [];
        $logs=[];
        $subs=[];
        $ibsinfo=[];
        $serinfo_sub=[];
        $serinfo_ip=[];
        $serinfo_cid=[];
        if($RefNum!==''){
            $RefNum=Helper::regulateNumber($RefNum);
        }
        if($SuspId!==''){
            $SuspId=Helper::regulateNumber($SuspId);
        }
        if($SuspType!==''){
            $SuspType=Helper::regulateNumber($SuspType);
        }
        if($SuspType===''){
            $SuspType=2;
        }
        if($SuspOrder!==''){
            $SuspOrder=Helper::regulateNumber($SuspOrder);
        }
        if ($tel) {
            $formattedtel = self::siamTel($tel, 1);
            if (Helper::isMobile($formattedtel)) {
                $sa['telephone_hamrah'] = $formattedtel;
                $ismobile = true;
            } else {
                $sa['telephone1'] = $formattedtel;
            }
            $subs = self::combineSearchDynamicQuery($sa);
            if(! $subs) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
            foreach ($allservices as $k => $v) {
                if($allservices[$k]){
                    if($allservices[$k]['subid']===$subs[0]['id']){
                        $subs[0]['serinfo'][]=$allservices[$k];
                    }
                }
            }
            if(! isset($subs[0]['serinfo'])) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
            if(! $subs[0]['serinfo']) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }
        if ($ip) {
            $regulatedip = Helper::regulateNumber($ip);
            if ($regulatedip) {
                $checkipexists = Helper::checkIpExist(Helper::regulateNumber($regulatedip, 1));
                if (!$checkipexists) {
                    return json_encode('QryResult=5' . self::sep('f') . "DbError" . self::sep('f') . self::messages('ipnf'), JSON_UNESCAPED_UNICODE);
                }
            }
            $logs = $GLOBALS['ibs_internet']->getConnectionByRemoteIpAndDateTimeDesc($regulatedip, false, false, 20000);
            if (! Helper::checkIbsResultStrict($logs)) {
                return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
            }
            $logs = $logs[1][1];
            $logs=self::unsetLogIfIPNotValid($logs);
            $logs=self::unsetExtraArrayElems($logs, 100);
            if(! isset($logs)) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
            if(! $logs) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
            $onlines = $GLOBALS['ibs_internet']->findOnlineUsers(true);
            $onlineinfo = [];
            $res = [];
            $z = 0;
            $isonline = false;
            if ($onlines) {
                    $onlineusersinfo = Helper::ibsGetOnlineUserInfoByArrayId($onlines);
                    for ($i = 0; $i < count($onlineusersinfo); $i++) {
                        if (isset($onlineusersinfo[$i]['internet_onlines'])) {
                            if (($onlineusersinfo[$i]['internet_onlines'])) {
                                if (isset($onlineusersinfo[$i]['internet_onlines'][0])) {
                                    if (($onlineusersinfo[$i]['internet_onlines'][0])) {
                                        if ($onlineusersinfo[$i]['internet_onlines'][0][4] && $onlineusersinfo[$i]['internet_onlines'][0][4] !== '-' && $onlineusersinfo[$i]['internet_onlines'][0][4] !== '0.0.0.0') {
                                            if ($onlineusersinfo[$i]['attrs']['normal_username'] === $logs[0]['username'] && $logs[0]['username']) {
                                                $isonline = true;
                                                $onlineinfo['ipv4_address'] = $onlineusersinfo[$i]['internet_onlines'][0][4];
                                                $onlineinfo['mac'] = $onlineusersinfo[$i]['internet_onlines'][0][7];
                                                $onlineinfo['session_start_time'] = $onlineusersinfo[$i]['basic_info']['last_login'];
                                                $onlineinfo['session_stop_time'] = 'آنلاین';
                                                $onlineinfo['remaining_credit'] = $onlineusersinfo[$i]['basic_info']['credit'];
                                                $onlineinfo['username'] = $onlineusersinfo[$i]['attrs']['normal_username'];
                                                $onlineinfo['password'] = $onlineusersinfo[$i]['attrs']['normal_password'];
                                                $onlineinfo['user_id'] = $onlineusersinfo[$i]['user_id'];
                                                for ($s = 0; $s < count($allservices); $s++) {
                                                    if ($allservices[$s]['ibsusername']) {
                                                        if (Helper::like($allservices[$s]['ibsusername'], $onlineinfo['username'])) {
                                                            // $allservices=$allservices[$i];
                                                            $onlineinfo['serinfo'] = $allservices[$s];
                                                            break;
                                                        }
                                                    }
                                                }
                                                $subinfo = self::selectMultiSubsByIds([$onlineinfo['serinfo']['subid']]);
                                                $onlineinfo['subinfo'] = $subinfo;
                                                //////adding online info to logs
                                                $logs = array_merge([$onlineinfo], $logs);
                                                $logs = self::unsetExtraArrayElems($logs, 200);
                                                //////adding online info to logs
                                                break;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
            }
            if(! isset($logs)) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
            if(! $logs) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);

        }
        if ($cid) {
            $regulatedcid = Helper::regulateNumber($cid);
            $ibsinfo=Helper::ibsGetUserInfoByArrayId([(int) $regulatedcid]);
            if(! $ibsinfo) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }
        //ip///
        $serinfo=[];
        //find factorid
        if($ip && $tel && $cid){
            foreach ($subs as $key => $value) {
                foreach ($subs[0]['serinfo'] as $k => $v) {
                    if($v['ibsusername']===$logs[0]['username'] && $v['ibsusername']===$ibsinfo[0]['attrs']['normal_username']){
                        $serinfo['emkanat_id']=$v['emkanat_id'];
                        $serinfo['fid']=$v['fid'];
                        $serinfo['subid']=$v['subid'];
                        $serinfo['sertype']=$v['sertype'];
                        $serinfo['username']=$v['ibsusername'];
                        break;
                    }
                }
                if($serinfo) break;
            }
        }elseif ($ip && $tel) {
            foreach ($subs as $key => $value) {
                foreach ($subs[0]['serinfo'] as $k => $v) {
                    if($v['ibsusername']===$logs[0]['username']){
                        $serinfo['emkanat_id']=$v['emkanat_id'];
                        $serinfo['fid']=$v['fid'];
                        $serinfo['subid']=$v['subid'];
                        $serinfo['sertype']=$v['sertype'];
                        $serinfo['username']=$v['ibsusername'];
                        break;
                    }
                }
                if($serinfo) break;
            }
        }elseif ($ip && $cid) {
            if($ibsinfo[0]['attrs']['normal_username']===$logs[0]['username']){
                foreach ($allservices as $k => $v) {
                    if($logs[0]['username'] === $v['ibsusername']){
                        $serinfo['emkanat_id']=$v['emkanat_id'];
                        $serinfo['fid']=$v['fid'];
                        $serinfo['subid']=$v['subid'];
                        $serinfo['sertype']=$v['sertype'];
                        $serinfo['username']=$v['ibsusername'];
                        break;
                    }
                }
            }
        }elseif ($cid && $tel) {
            foreach ($subs as $key => $val) {
                foreach ($val['serinfo'] as $k => $v) {
                    if($v['ibsusername']===$ibsinfo[0]['attrs']['normal_username']){
                        $serinfo['emkanat_id']=$v['emkanat_id'];
                        $serinfo['fid']=$v['fid'];
                        $serinfo['subid']=$v['subid'];
                        $serinfo['sertype']=$v['sertype'];
                        $serinfo['username']=$v['ibsusername'];
                        break;
                    }
                }
                
                if($serinfo) break;
            }
        }elseif ($tel) {
            foreach ($subs as $key => $val) {
                foreach($subs[0]['serinfo'] as $k => $v){
                    if( strtolower($v['general_sertype'])==="adsl" || strtolower($v['general_sertype'])==="vdsl" || strtolower($v['general_sertype'])==="bitstream" || $v['ibsusername']===$formattedtel){
                        $serinfo['emkanat_id']=$v['emkanat_id'];
                        $serinfo['fid']=$v['fid'];
                        $serinfo['subid']=$v['subid'];
                        $serinfo['sertype']=$v['sertype'];
                        $serinfo['username']=$v['ibsusername'];
                        break;
                    }
                }
            }
            if(! $serinfo){
                $serinfo['emkanat_id']  = $subs[0]['serinfo'][0]['emkanat_id'];
                $serinfo['fid']         = $subs[0]['serinfo'][0]['fid'];
                $serinfo['subid']       = $subs[0]['serinfo'][0]['subid'];
                $serinfo['username']    = $subs[0]['serinfo'][0]['ibsusername'];
                $serinfo['sertype']    = $subs[0]['serinfo'][0]['sertype'];
            }
        }elseif ($ip) {
                foreach ($allservices as $k => $v) {
                    if($v['ibsusername']===$logs[0]['username']){
                        $serinfo['emkanat_id']  = $v['emkanat_id'];
                        $serinfo['fid']         = $v['fid'];
                        $serinfo['subid']       = $v['subid'];
                        $serinfo['sertype']     = $v['sertype'];
                        $serinfo['username']    = $v['ibsusername'];
                        break;
                    }
                }
            
        }elseif ($cid) {
            foreach ($allservices as $k => $v) {
                if($v['ibsusername']===$ibsinfo[0]['attrs']['normal_username']){
                    $serinfo['emkanat_id']  = $v['emkanat_id'];
                    $serinfo['fid']         = $v['fid'];
                    $serinfo['subid']       = $v['subid'];
                    $serinfo['sertype']     = $v['sertype'];
                    $serinfo['username']    = $v['ibsusername'];
                    break;
                }
            }
        }



        
        if(! $serinfo) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE); 
        //prepration lock or unlock operation
        if((int)$SuspId===0){
            $op=6;//ghat
        }elseif((int)$SuspId===1){
            $op=1;//vasl
        }
        if($SuspOrder!==''){
            if((int)$SuspOrder===0){
                $SuspType=0;
            }
        }
        if ((int) Helper::regulateNumber($SuspType) === 0) {
            $time = 1;
        } elseif ((int) Helper::regulateNumber($SuspType) === 1) {
            $time = 0;
        } elseif ((int) Helper::regulateNumber($SuspType) === 2) {
            $time = 2;
        } elseif ((int) Helper::regulateNumber($SuspType) === 3) {
            $time = 3;
        } elseif ((int) Helper::regulateNumber($SuspType) === 4) {
            $time = 7;
        } elseif ((int) Helper::regulateNumber($SuspType) === 5) {
            $time = 15;
        } else {
            $time = 1;
        }
        $info=Helper::getIbsinfoByUsername($serinfo['username'], 'internet');
        if(! $info) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        //prepration lock or unlock operation
        if(isset($info['attrs']['lock'])){
            if((int)$SuspId===0){
                //dastor vasl
                $unlock=Helper::unlockService($serinfo['username']);
                return json_encode('QryResult=0' . self::sep('f') . ".درخواست با موفقیت انجام گردید", JSON_UNESCAPED_UNICODE);
            }else{
                //dastor ghat
                $res=Helper::lockService($serinfo['username']);
                return json_encode('QryResult=2' . self::sep('f') . "این تلفن در حال حاضر قطع میباشد. درخواست قطع شما نیز روی آن اعمال شد", JSON_UNESCAPED_UNICODE);
            }

        }else{
            if((int)$SuspId===0){
                //dastor vasl
                $unlock=Helper::unlockService($serinfo['username']);
                return json_encode('QryResult=2' . self::sep('f') . "این تلفن در حال حاضر وصل میباشد. درخواست وصل شما نیز روی آن اعمال شد", JSON_UNESCAPED_UNICODE); 
            }else{
                //dastor ghat
                $res=Helper::lockService($serinfo['username']);
                return json_encode('QryResult=0' . self::sep('f') . ".درخواست با موفقیت انجام گردید", JSON_UNESCAPED_UNICODE);
            }
        }
    }

    public static function ApplySuspIp_old($username, $password, $RefNum, $SuspId, $SuspType, $SuspOrder, $tel = '', $ip = '', $cid = '')
    {
        $auth = self::authentication($username, $password);
        // if(! $auth) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        if (!$auth) {
            return json_encode('QryResult=3' . self::sep('f') . "نام کاربری یا رمز عبور اشتباه است", JSON_UNESCAPED_UNICODE);
        }

        if (!$tel && !$ip && !$cid) {
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }

        if ($tel) {
            $ntel = self::siamTel($tel, 1);
        }
        $ipdr = false;
        if ($ip) {
            $ip2l = Helper::regulateNumber($ip);
            $ip2l = ip2long($ip);
        }
        $db = Helper::pdodbIpdrInstance();
        if ($cid) {
            $db->where('user_id', $cid);
        }
        if ($tel) {
            $db->where('username', $ntel);
        }
        if ($ip) {
            $db->where('ip', $ip2l);
        }
        $db->orderBy("ses_stop", "DESC");
        $ipdr = $db->get("tbl_ipdr", 100);
        $db = null;
        if (!$ipdr) {
            return json_encode('QryResult=3' . self::sep('f') . self::messages('in'), JSON_UNESCAPED_UNICODE);
        }
        $ipdr_last_username = $ipdr[array_key_last($ipdr)]['username'];
        //last ipdr row
        $ipdrf = $ipdr[array_key_first($ipdr)];
        $ipdrl = $ipdr[array_key_last($ipdr)];
        //second to last ipdr row
        if (isset($ipdr[array_key_last($ipdr) - 1])) {
            $ipdrsl = $ipdr[array_key_last($ipdr) - 1];
        } else {
            $ipdrsl = false;
        }
        $services = Helper::getInternetUsersServicesInfoWithoutLogincheck();
        if (!$services) {
            return json_encode('QryResult=3' . self::sep('f') . self::messages('in'), JSON_UNESCAPED_UNICODE);
        }

        $ip_assign = Helper::getIpinfoByip(long2ip($ipdrl['ip']));
        if ($ip_assign) {
            if ($ip_assign[0]['servicetype'] === "bandwidth") {
                //band width
                $subinfo['howifoundit'] = 'ipassign';
                $subinfo['hasassignedip'] = true;
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
                $subinfo['username'] = $ip_assign[0]['username'];
                $subinfo['password'] = $ip_assign[0]['password'];
            } else {
                //adsl,vdsl,wireless,tdlte, bitstream
                $services = Helper::getServiceInfoLastFactorWithSubidEmkanatSertypeNoAuth($ip_assign[0]['sub'], $ip_assign[0]['emkanat_id'], $ip_assign[0]['servicetype']);
                $subinfo['howifoundit'] = 'ipassign';
                $subinfo['hasassignedip'] = true;
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
        if (!isset($subinfo)) {
            if (!isset($subinfo)) {
                //search by ibsusername
                $serinfo = Helper::getInternetUsersServicesInfoWithoutLogincheck();
                if ($serinfo) {
                    for ($i = 0; $i < count($serinfo); $i++) {
                        if ($serinfo[$i]['ibsusername'] === $ipdr_last_username) {
                            $serinfo = $serinfo[$i];
                            $subinfo['howifoundit'] = 'userinfo';
                            $subinfo['sertype'] = $serinfo['sertype'];
                            $subinfo['emkanat_id'] = $serinfo['emkanat_id'];
                            $subinfo['subid'] = $serinfo['subid'];
                            break;
                        }
                    }
                }
            }
            if (Helper::isMobile($ipdr_last_username)) {
                //search by mobile
                $sql = "SELECT * FROM bnm_subscribers WHERE telephone_hamrah LIKE '%" . $ipdr_last_username . "'";
                $res = Db::fetchall_Query($sql);
                if ($res) {
                    $serinfo = Helper::getInternetServiceInfoBySubidNoAuth($res[0]['id']);
                    $serinfo = self::findInternetServiceByAdslVdslPriority($serinfo);
                    if ($serinfo) {
                        $subinfo['howifoundit'] = 'userinfo';
                        $subinfo['sertype'] = $serinfo['sertype'];
                        $subinfo['emkanat_id'] = $serinfo['emkanat_id'];
                        $subinfo['subid'] = $serinfo['subid'];
                    }
                }
            }
            if (!isset($subinfo)) {
                //search by telephone1
                $sql = "SELECT * FROM bnm_subscribers WHERE telephone1 LIKE '%" . $ipdr_last_username . "'";
                $res = Db::fetchall_Query($sql);
                if ($res) {
                    $serinfo = Helper::getInternetServiceInfoBySubidNoAuth($res[0]['id']);
                    $serinfo = self::findInternetServiceByAdslVdslPriority($serinfo);
                    if ($serinfo) {
                        $subinfo['howifoundit'] = 'userinfo';
                        $subinfo['sertype'] = $serinfo['sertype'];
                        $subinfo['emkanat_id'] = $serinfo['emkanat_id'];
                        $subinfo['subid'] = $serinfo['subid'];
                    }
                }
            }
            if (!isset($subinfo)) {
                //search by code_meli
                $sql = "SELECT * FROM bnm_subscribers WHERE code_meli =?";
                $res = Db::secure_fetchall($sql, [$ipdr_last_username]);
                // $res=Db::fetchall_Query($sql);
                if ($res) {
                    $serinfo = Helper::getInternetServiceInfoBySubidNoAuth($res[0]['id']);
                    $serinfo = self::findInternetServiceByAdslVdslPriority($serinfo);
                    if ($serinfo) {
                        $subinfo['howifoundit'] = 'userinfo';
                        $subinfo['sertype'] = $serinfo['sertype'];
                        $subinfo['emkanat_id'] = $serinfo['emkanat_id'];
                        $subinfo['subid'] = $serinfo['subid'];
                    }
                }
            }
        }

        if (!isset($subinfo)) {
            //todo... agar subinfo peyda nashod hachi az ipdr dari befrest ?
            return json_encode('QryResult=3' . self::sep('f') . self::messages('in'), JSON_UNESCAPED_UNICODE);
        }

        $sql = "SELECT *,DATE_FORMAT(tarikhe_sabtenam,'%Y-%m-%d %H:%i') siam_tarikhe_sabtenam FROM bnm_subscribers WHERE id = ?";
        $res_sub = Db::secure_fetchall($sql, [$subinfo['subid']]);
        switch ($subinfo['howifoundit']) {
            case 'ipassign':
                if ($subinfo['sertype'] === "bandwidth") {
                    return json_encode('QryResult=1' . self::sep('f') . "سرویس مورد نظر پهنای باند است و بصورت سیستمی قابل قطع یا وصل کردن نیست.", JSON_UNESCAPED_UNICODE);
                } else {
                    $laststatus = Helper::lastSuspensionStatus($subinfo['subid'], $subinfo['sertype'], $subinfo['emkanat_id']);
                    //service currently locked
                    if ((int) Helper::regulateNumber($SuspId) === 0) {
                        if (isset($laststatus) && isset($laststatus[0]['lockstatus'])) {
                            if ($laststatus[0]['lockstatus'] === 1) {
                                //lockstatus 1 = ghat, 2=vasl
                                //service already locked
                                $factor = Helper::getServiceInfoLastFactorWithSubidEmkanatSertypeNoAuth($subinfo['subid'], $subinfo['emkanat_id'], $subinfo['sertype']);
                                if (!$factor) {
                                    return json_encode('QryResult=1' . self::sep('f') . "خطا در برنامه انجام درخواست با مشکل مواجه شد و عملیات موفق نبود", JSON_UNESCAPED_UNICODE);
                                }
                                if ((int) Helper::regulateNumber($SuspType) === 0) {
                                    $time = 1;
                                } elseif ((int) Helper::regulateNumber($SuspType) === 1) {
                                    $time = 0;
                                } elseif ((int) Helper::regulateNumber($SuspType) === 2) {
                                    $time = 2;
                                } elseif ((int) Helper::regulateNumber($SuspType) === 3) {
                                    $time = 3;
                                } elseif ((int) Helper::regulateNumber($SuspType) === 4) {
                                    $time = 7;
                                } elseif ((int) Helper::regulateNumber($SuspType) === 5) {
                                    $time = 15;
                                } else {
                                    $time = 1;
                                }
                                if (!isset($time)) {
                                    return json_encode('QryResult=1' . self::sep('f') . "خطای برنامه زمان قطع (susptype) برای سیستم تعریف نشده است", JSON_UNESCAPED_UNICODE);
                                }
                                $res_lock = Helper::lockWithLog(6, $factor[0]['fid'], $time, "قطع از طریق سامانه سیام", $RefNum);
                                return json_encode('QryResult=0' . self::sep('f') . "درخواست با موفقیت انجام شد", JSON_UNESCAPED_UNICODE);
                            } else {
                                //service is open
                                $factor = Helper::getServiceInfoLastFactorWithSubidEmkanatSertypeNoAuth($subinfo['subid'], $subinfo['emkanat_id'], $subinfo['sertype']);
                                if (!$factor) {
                                    return json_encode('QryResult=1' . self::sep('f') . "خطا در برنامه انجام درخواست با مشکل مواجه شد و عملیات موفق نبود", JSON_UNESCAPED_UNICODE);
                                }
                                if ((int) Helper::regulateNumber($SuspType) === 0) {
                                    $time = 1;
                                } elseif ((int) Helper::regulateNumber($SuspType) === 1) {
                                    $time = 0;
                                } elseif ((int) Helper::regulateNumber($SuspType) === 2) {
                                    $time = 2;
                                } elseif ((int) Helper::regulateNumber($SuspType) === 3) {
                                    $time = 3;
                                } elseif ((int) Helper::regulateNumber($SuspType) === 4) {
                                    $time = 7;
                                } elseif ((int) Helper::regulateNumber($SuspType) === 5) {
                                    $time = 15;
                                } else {
                                    $time = 1;
                                }
                                if (!isset($time)) {
                                    return json_encode('QryResult=1' . self::sep('f') . "خطای برنامه زمان قطع (susptype) برای سیستم تعریف نشده است", JSON_UNESCAPED_UNICODE);
                                }
                                $res_lock = Helper::lockWithLog(6, $factor[0]['fid'], $time, "قطع از طریق سامانه سیام", $RefNum);
                                return json_encode('QryResult=0' . self::sep('f') . "درخواست با موفقیت انجام شد", JSON_UNESCAPED_UNICODE);
                            }
                        } else {
                            //no data about service lock status just do it !
                            $factor = Helper::getServiceInfoLastFactorWithSubidEmkanatSertypeNoAuth($subinfo['subid'], $subinfo['emkanat_id'], $subinfo['sertype']);
                            if (!$factor) {
                                return json_encode('QryResult=1' . self::sep('f') . "خطا در برنامه انجام درخواست با مشکل مواجه شد و عملیات موفق نبود", JSON_UNESCAPED_UNICODE);
                            }
                            if ((int) Helper::regulateNumber($SuspType) === 0) {
                                $time = 1;
                            } elseif ((int) Helper::regulateNumber($SuspType) === 1) {
                                $time = 0;
                            } elseif ((int) Helper::regulateNumber($SuspType) === 2) {
                                $time = 2;
                            } elseif ((int) Helper::regulateNumber($SuspType) === 3) {
                                $time = 3;
                            } elseif ((int) Helper::regulateNumber($SuspType) === 4) {
                                $time = 7;
                            } elseif ((int) Helper::regulateNumber($SuspType) === 5) {
                                $time = 15;
                            } else {
                                $time = 1;
                            }
                            if (!isset($time)) {
                                return json_encode('QryResult=1' . self::sep('f') . "خطای برنامه زمان قطع (susptype) برای سیستم تعریف نشده است", JSON_UNESCAPED_UNICODE);
                            }
                            $res_lock = Helper::lockWithLog(6, $factor[0]['fid'], $time, "قطع از طریق سامانه سیام", $RefNum);
                            return json_encode('QryResult=0' . self::sep('f') . "درخواست با موفقیت انجام شد", JSON_UNESCAPED_UNICODE);
                        }
                    } else {
                        ///unlock service
                        $factor = Helper::getServiceInfoLastFactorWithSubidEmkanatSertypeNoAuth($subinfo['subid'], $subinfo['emkanat_id'], $subinfo['sertype']);
                        if (!$factor) {
                            return json_encode('QryResult=1' . self::sep('f') . "خطا در برنامه انجام درخواست با مشکل مواجه شد و عملیات موفق نبود", JSON_UNESCAPED_UNICODE);
                        }
                        $res_unlock = Helper::unlockWithLog(1, $factor[0]['fid'], "وصل از طریق سامانه سیام", $RefNum);
                        if (!$res_unlock) {
                            return json_encode('QryResult=1' . self::sep('f') . "خطا در برنامه انجام درخواست با مشکل مواجه شد و عملیات موفق نبود", JSON_UNESCAPED_UNICODE);
                        } else {
                            return json_encode('QryResult=0' . self::sep('f') . "درخواست با موفقیت انجام شد", JSON_UNESCAPED_UNICODE);
                        }
                    }
                }
                break;
            case 'userinfo':
                $laststatus = Helper::lastSuspensionStatus($subinfo['subid'], $subinfo['sertype'], $subinfo['emkanat_id']);
                //service currently locked
                if ((int) Helper::regulateNumber($SuspId) === 0) {
                    if (isset($laststatus) && isset($laststatus[0]['lockstatus'])) {
                        if ($laststatus[0]['lockstatus'] === 1) {
                            //lockstatus 1 = ghat, 2=vasl
                            //service already locked
                            $factor = Helper::getServiceInfoLastFactorWithSubidEmkanatSertypeNoAuth($subinfo['subid'], $subinfo['emkanat_id'], $subinfo['sertype']);
                            if (!$factor) {
                                return json_encode('QryResult=1' . self::sep('f') . "خطا در برنامه انجام درخواست با مشکل مواجه شد و عملیات موفق نبود", JSON_UNESCAPED_UNICODE);
                            }
                            if ((int) Helper::regulateNumber($SuspType) === 0) {
                                $time = 1;
                            } elseif ((int) Helper::regulateNumber($SuspType) === 1) {
                                $time = 0;
                            } elseif ((int) Helper::regulateNumber($SuspType) === 2) {
                                $time = 2;
                            } elseif ((int) Helper::regulateNumber($SuspType) === 3) {
                                $time = 3;
                            } elseif ((int) Helper::regulateNumber($SuspType) === 4) {
                                $time = 7;
                            } elseif ((int) Helper::regulateNumber($SuspType) === 5) {
                                $time = 15;
                            } else {
                                $time = 1;
                            }
                            if (!isset($time)) {
                                return json_encode('QryResult=1' . self::sep('f') . "خطای برنامه زمان قطع (susptype) برای سیستم تعریف نشده است", JSON_UNESCAPED_UNICODE);
                            }
                            $res_lock = Helper::lockWithLog(6, $factor[0]['fid'], $time, "قطع از طریق سامانه سیام", $RefNum);
                            return json_encode('QryResult=0' . self::sep('f') . "درخواست با موفقیت انجام شد", JSON_UNESCAPED_UNICODE);
                        } else {
                            //service is open
                            $factor = Helper::getServiceInfoLastFactorWithSubidEmkanatSertypeNoAuth($subinfo['subid'], $subinfo['emkanat_id'], $subinfo['sertype']);
                            if (!$factor) {
                                return json_encode('QryResult=1' . self::sep('f') . "خطا در برنامه انجام درخواست با مشکل مواجه شد و عملیات موفق نبود", JSON_UNESCAPED_UNICODE);
                            }
                            if ((int) Helper::regulateNumber($SuspType) === 0) {
                                $time = 1;
                            } elseif ((int) Helper::regulateNumber($SuspType) === 1) {
                                $time = 0;
                            } elseif ((int) Helper::regulateNumber($SuspType) === 2) {
                                $time = 2;
                            } elseif ((int) Helper::regulateNumber($SuspType) === 3) {
                                $time = 3;
                            } elseif ((int) Helper::regulateNumber($SuspType) === 4) {
                                $time = 7;
                            } elseif ((int) Helper::regulateNumber($SuspType) === 5) {
                                $time = 15;
                            } else {
                                $time = 1;
                            }
                            if (!isset($time)) {
                                return json_encode('QryResult=1' . self::sep('f') . "خطای برنامه زمان قطع (susptype) برای سیستم تعریف نشده است", JSON_UNESCAPED_UNICODE);
                            }
                            $res_lock = Helper::lockWithLog(6, $factor[0]['fid'], $time, "قطع از طریق سامانه سیام", $RefNum);
                            return json_encode('QryResult=0' . self::sep('f') . "درخواست با موفقیت انجام شد", JSON_UNESCAPED_UNICODE);
                        }
                    } else {
                        //no data about service lock status just do it !
                        $factor = Helper::getServiceInfoLastFactorWithSubidEmkanatSertypeNoAuth($subinfo['subid'], $subinfo['emkanat_id'], $subinfo['sertype']);
                        if (!$factor) {
                            return json_encode('QryResult=1' . self::sep('f') . "خطا در برنامه انجام درخواست با مشکل مواجه شد و عملیات موفق نبود", JSON_UNESCAPED_UNICODE);
                        }
                        if ((int) Helper::regulateNumber($SuspType) === 0) {
                            $time = 1;
                        } elseif ((int) Helper::regulateNumber($SuspType) === 1) {
                            $time = 0;
                        } elseif ((int) Helper::regulateNumber($SuspType) === 2) {
                            $time = 2;
                        } elseif ((int) Helper::regulateNumber($SuspType) === 3) {
                            $time = 3;
                        } elseif ((int) Helper::regulateNumber($SuspType) === 4) {
                            $time = 7;
                        } elseif ((int) Helper::regulateNumber($SuspType) === 5) {
                            $time = 15;
                        } else {
                            $time = 1;
                        }
                        if (!isset($time)) {
                            return json_encode('QryResult=1' . self::sep('f') . "خطای برنامه زمان قطع (susptype) برای سیستم تعریف نشده است", JSON_UNESCAPED_UNICODE);
                        }
                        $res_lock = Helper::lockWithLog(6, $factor[0]['fid'], $time, "قطع از طریق سامانه سیام", $RefNum);
                        return json_encode('QryResult=0' . self::sep('f') . "درخواست با موفقیت انجام شد", JSON_UNESCAPED_UNICODE);
                    }
                } else {
                    ///unlock service
                    $factor = Helper::getServiceInfoLastFactorWithSubidEmkanatSertypeNoAuth($subinfo['subid'], $subinfo['emkanat_id'], $subinfo['sertype']);
                    if (!$factor) {
                        return json_encode('QryResult=1' . self::sep('f') . "خطا در برنامه انجام درخواست با مشکل مواجه شد و عملیات موفق نبود", JSON_UNESCAPED_UNICODE);
                    }
                    $res_unlock = Helper::unlockWithLog(1, $factor[0]['fid'], "وصل از طریق سامانه سیام", $RefNum);
                    return json_encode('QryResult=0' . self::sep('f') . "درخواست با موفقیت انجام شد", JSON_UNESCAPED_UNICODE);
                }
                break;
            default:
                return json_encode('QryResult=3' . self::sep('f') . self::messages('in'), JSON_UNESCAPED_UNICODE);
                break;
        }
    }

    public static function GetIpPool($username, $password)
    {
        $auth = self::authentication($username, $password);
        // if(! $auth) return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        if (!$auth) {
            return json_encode('QryResult=3' . self::sep('f') . "نام کاربری یا رمز عبور اشتباه است", JSON_UNESCAPED_UNICODE);
        }

        $arr = [];
        $sql = "SELECT ip.ip ipaddress,
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
        FROM bnm_ip ip WHERE ip.gender = '1' GROUP BY pool";
        $res = Db::fetchall_Query($sql);
        if (!$res) {
            return json_encode('QryResult=0', JSON_UNESCAPED_UNICODE);
        }

        $qr = "QryResult=";
        for ($i = 0; $i < count($res); $i++) {
            if (!isset($res[$i])) {
                continue;
            }

            if (!$res[$i]) {
                continue;
            }

            $qr .= $res[$i]['ipstart'] . self::sep('f');
            $qr .= $res[$i]['ipend'] . self::sep('f');
            $qr .= $res[$i]['en_iptype'] . self::sep('f');
            if ($res[$i]['en_ownership'] === "malek") {
                $qr .= 'مالک' . self::sep('f');
            } elseif ($res[$i]['en_ownership'] === "ejare") {
                $qr .= 'اجاره' . self::sep('f');
            } else {
                $qr .= 'غیره' . self::sep('f');
            }
            switch ($res[$i]['ipusage']) {
                case '1':
                    $qr .= "شبکه داخلی";
                    break;
                case '2':
                    $qr .= "اختصاص به مشترکین";
                    break;
                case '3':
                    $qr .= "رزرو";
                    break;
                default:
                    $qr .= "";
                    break;
            }
            $qr .= self::sep('r');
        }
        $qr .= "0";
        return json_encode($qr, JSON_UNESCAPED_UNICODE);
    }

    public static function PassChange($username, $password, $NAutStr)
    {
        $auth = self::authentication($username, $password);
        if (!$auth) {
            return json_encode('QryResult=3' . self::sep('f') . "نام کاربری یا رمز عبور اشتباه است", JSON_UNESCAPED_UNICODE);
        }

        $sql = "UPDATE bnm_siamconfig SET password=:nautstr WHERE username=:username AND password=:password";
        $res = Db::secure_update_array($sql, ['username' => $username, 'nautstr' => $NAutStr, 'password' => $password]);
        if (!$res) {
            return json_encode('QryResult=3' . self::sep('f') . "خطای پایگاه داده عملیات موفق نبوده و یا رمز عبور تکراری میباشد.", JSON_UNESCAPED_UNICODE);
        }

        return json_encode('QryResult=0' . self::sep('f') . "رمز عبور با موفقیت تغییر یافت", JSON_UNESCAPED_UNICODE);
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
    public static function siamTel($t, $convertype = 1)
    {
        //1=from siam to normal(stn)
        //1=from normal to siam(nts)
        if ($convertype === 1) {
            $t = Helper::regulateNumber($t, 1);
            // $t = substr($t, 2);
            $t = "0" . $t;
        } else {
            $t = Helper::regulateNumber($t, 1);
            if ($t[0] === "0") {
                $t = substr($t, 1);
                // $t=$t;
                $t = Helper::regulateNumber($t, 2);
            } else {
                // $t=$t;
                $t = Helper::regulateNumber($t, 2);
            }
        }
        return $t;
    }
    public static function messages($mid)
    {
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
                return "آی پی مورد خارج از محدوده در اختیار این اپراتور یا مشترکین آن است";
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
        if (!isset($pass)) {
            return false;
        }

        if (!$user) {
            return false;
        }

        if (!$pass) {
            return false;
        }

        $sql = "SELECT count(*) rowsnum FROM bnm_siamconfig WHERE username = ? AND password= ?";
        $res = Db::secure_fetchall($sql, [$user, $pass]);
        if ($res[0]['rowsnum'] === 1) {
            return true;
        } else {
            return false;
        }
        return false;
    }

    public static function combineSearchDynamicQuery(array $arr)
    {
        $sa = $arr;
        $sql = "SELECT sub.* FROM bnm_subscribers sub
                WHERE ";
        if (isset($arr['code_meli']) && isset($arr['passno'])) {
            //ignore passno
            unset($sa['passno']);
            $sa['noe_shenase_hoviati'] = '0';
        } elseif (isset($arr['code_meli']) && !isset($arr['passno'])) {
            $sa['noe_shenase_hoviati'] = '0';
        } elseif (!isset($arr['code_meli']) && isset($arr['passno'])) {
            $sa['noe_shenase_hoviati'] = '1';
            unset($sa['passno']);
            $sa['code_meli'] = $arr['passno'];
        }
        $firstKey = array_key_first($arr);
        $lastkey = array_key_last($arr);
        foreach ($sa as $key => $value) {
            if ($key === $firstKey) {
                $sql .= "sub." . $key . '= ? ';
            } elseif ($key === $lastkey) {
                $sql .= 'AND' . ' sub.' . $key . '= ? ';
            } else {
                $sql .= 'AND' . ' sub.' . $key . '= ? ';
            }
        }
        return Helper::checkQueryResult(Db::secure_fetchall($sql, $sa));
    }

    public static function combineSearchDynamicQuery_old(array $arr)
    {
        if (isset($arr['code_meli'])) {
            if (isset($arr['passno'])) {
                unset($arr['passno']);
            }

            $arr['noe_shenase_hoviati'] = '0';
            $sql = "SELECT sub.* FROM bnm_subscribers sub
                WHERE ";
            $firstKey = array_key_first($arr);
            $lastkey = array_key_last($arr);
            foreach ($arr as $key => $value) {
                if ($key === $firstKey) {
                    $sql .= "sub." . $key . '= ? ';
                } elseif ($key === $lastkey) {
                    $sql .= 'AND' . ' sub.' . $key . '= ? ';
                } else {
                    $sql .= 'AND' . ' sub.' . $key . '= ? ';
                }
            }
        } elseif (isset($arr['passno'])) {
            if (isset($arr['code_meli'])) {
                unset($arr['code_meli']);
            }

            $arr['code_meli'] = $arr['passno'];
            unset($arr['passno']);
            $arr['noe_shenase_hoviati'] = '1';
            $sql = "SELECT sub.* FROM bnm_subscribers sub
                WHERE ";
            $firstKey = array_key_first($arr);
            $lastkey = array_key_last($arr);
            foreach ($arr as $key => $value) {
                if ($key === $firstKey) {
                    $sql .= "sub." . $key . '= ? ';
                } elseif ($key === $lastkey) {
                    $sql .= 'AND' . ' sub.' . $key . '= ? ';
                } else {
                    $sql .= 'AND' . ' sub.' . $key . '= ? ';
                }
            }
        } else {
            $sql = "SELECT sub.* FROM bnm_subscribers sub
            WHERE ";
            $firstKey = array_key_first($arr);
            $lastkey = array_key_last($arr);
            foreach ($arr as $key => $value) {
                if ($key === $firstKey) {
                    $sql .= "sub." . $key . '= ? ';
                } elseif ($key === $lastkey) {
                    $sql .= 'AND' . ' sub.' . $key . '= ? ';
                    $sql .= 'AND' . ' sub.noe_shenase_hoviati= ? ';
                    $arr['noe_shenase_hoviati'] = '0';
                } else {
                    $sql .= 'AND' . ' sub.' . $key . '= ? ';
                }
            }
        }
        $res = Db::secure_fetchall($sql, $arr);
        if (!$res) {
            return false;
        }

        if (!isset($res)) {
            return false;
        }
        if (isset(($res['errorInfo']))) {
            return false;
        }
        //mysql error
        return $res;
    }
    public static function checkSubAlreadyAdded($sers, $subs)
    {
        if (count($subs) === 0) {
            return true;
        }

        $flag = true;
        for ($i = 0; $i < count($subs); $i++) {
            if ($sers['subid'] == $subs[$i]['id']) {
                $flag = false;
            }
        }
        return $flag;
    }

    public static function selectMultiSubsByIds($ids)
    {
        $ids = array_values($ids);
        $sql = "SELECT sub.*,c.name tabeiat_fa_name, o.name ostan_faname, s.name shahr_faname,
            CONCAT(sub.tel1_street, ' ', sub.tel1_street2, ' پلاک ', sub.tel1_housenumber, ' طبقه ', sub.tel1_tabaghe, ' واحد ',sub.tel1_vahed ) address,
            CONCAT('استان',' ', o.name,' ','شهر','', s.name, ' ',sub.tel1_street, ' ', sub.tel1_street2, ' پلاک ', sub.tel1_housenumber, ' طبقه ', sub.tel1_tabaghe, ' واحد ',sub.tel1_vahed ) fulladdress,
            IF(sub.noe_malekiat1=1,'مالک','مستاجر') noemalekiat1fa,
            DATE_FORMAT(sub.tarikhe_sabtenam,'%Y-%m-%d %H:%i') siam_tarikhe_sabtenam
         FROM bnm_subscribers sub
            LEFT JOIN bnm_countries c ON c.id = sub.tabeiat
            LEFT JOIN bnm_ostan o ON o.id = sub.ostane_sokonat
            LEFT JOIN bnm_shahr s ON s.id = sub.shahre_sokonat
        WHERE sub.id IN ";
        if (count($ids) > 1) {
            for ($i = 0; $i < count($ids); $i++) {
                if ($i === array_key_first($ids)) {
                    $sql .= "(?,";
                } elseif ($i === array_key_last($ids)) {
                    $sql .= "?)";
                } else {
                    $sql .= "?,";
                }
            }
        } else {
            $sql .= "(?)";
        }
        // return $sql;
        $res = Db::secure_fetchall($sql, $ids);
        return $res;
    }

    public static function unsetLogIfIPNotValid($logs, $elem = "ipv4_address")
    {
        if (!$logs) {
            return false;
        }

        $arr = [];
        foreach ($logs as $key => $value) {
            if (ip2long($logs[$key][$elem])) {
                $arr[] = $logs[$key];
            } else {
                unset($logs[$key]);
            }
        }
        return $arr;
    }

    public static function makeQueryResult($res, $e = '0')
    {
        $qr = "QryResult=";
        $firstKey = array_key_first($res);
        $lastkey = array_key_first($res);
        $res = array_values($res);
        for ($i = 0; $i < count($res); $i++) {
            for ($j = 0; $j < count($res[$i]); $j++) {
                if ($j === array_key_last($res[$i])) {
                    $qr .= $res[$i][$j] . self::sep('r');
                } else {
                    $qr .= $res[$i][$j] . self::sep('f');
                }
            }
        }
        if ($e === '0') {
            return $qr . "0";
        } else {
            return $qr . $e;
        }
    }

    public static function unsetExtraArrayElems($arr, $limit = __SIAMLIMITATION__)
    {
        if (!$arr) {
            return false;
        }

        $res = [];
        foreach ($arr as $key => $value) {
            if (isset($arr[$key])) {
                if (count($res) < $limit) {
                    $res[] = $value;
                } else {
                    break;
                }
            }
        }
        if (!$res) {
            return false;
        }

        return $res;
    }

    public static function findPreviousLogByDatetime($plogs, $date)
    {
        foreach ($plogs as $key => $val) {
            if ($val['session_stop_time'] && Helper::IsDateValid($val['session_stop_time'])) {
                if (strtotime($val['session_stop_time']) <= strtotime($date)) {
                    return [$val];
                }
            }
        }
        return false;
    }

    public static function unsetLogWithNoSerinfoAndSubinfo($logs)
    {
        foreach ($logs as $k => $value) {
            if (!isset($logs[$k]['subinfo'])) {
                unset($logs[$k]);
            }
            if (!isset($logs[$k]['serinfo'])) {
                unset($logs[$k]);
            }
        }
        return array_values($logs);
    }

    public static function findLogBeforeAndAfterDatetime($logs, $fd){
        ///finding connection log that a part of its session time is before date and other part after date
        if(! $logs) return false;
        foreach ($logs as $k => $v) {
            if(isset($v['session_start_time']) && isset($v['session_stop_time'])){

                if(strtotime($v['session_start_time']) < strtotime($fd) && strtotime($v['session_stop_time']) >  strtotime($fd)){
                    return $v;
                }
                // if(strtotime($v['session_start_timn']))
                // if(strtotime($v['session_start_time']) < strtotime($dt) &&  strtotime($v['session_stop_time'])> strtotime($dt)){
                //     return $v;
                // }
            }
        }
        return false;
    }

    public static function unsetLogOutOfSessionStartStop($log, $fd, $td, $unit="g", $sort='d'){
        if(! $log) return false;
        if(! $fd) return false;
        if(! $td) return false;
        $fd=str_replace("/", "-", $fd);
        $td=str_replace("/", "-", $td);
        if($unit==='j'){
            if(strpos($fd,'/')){
                $s='/';
            }
            if(strpos($fd,'-')){
                $s='-';
            }
            $fd=Helper::TabdileTarikh(Helper::fixDateDigit(Helper::regulateNumber($fd, 2), $s), 2, $s, '-', false);
            $td=Helper::TabdileTarikh(Helper::fixDateDigit(Helper::regulateNumber($td, 2), $s), 2, $s, '-', false);
        }
        
        $arr=[];
        foreach ($log as $k => $v) {
            if(isset($v['session_start_time']) && isset($v['session_stop_time'])){
                if($v['session_start_time'] && $v['session_stop_time']){
                    // return [strtotime($fd), ];
                    if(strtotime($fd)<=strtotime($v['session_start_time']) && strtotime($td)>=strtotime($v['session_stop_time'])){
                        $arr[]=$v;
                    }
                }
            }else{
                unset($log[$k]);
            }
        }
        if(! $arr) return $arr;
        switch ($sort) {
            case 'd':
            case 'desc':
                // return array_multisort(array_map('strtotime',array_column($arr,'session_start_time')),
                // SORT_DESC, 
                // $arr); 
                $ord = array();
                foreach ($arr as $key => $value){
                    $ord[] = strtotime($value['session_start_time']);
                }
                array_multisort($ord, SORT_DESC, $arr);
                return $arr;
            break;
            case 'a':
            case 'asc':
                // return array_multisort(array_map('strtotime',array_column($arr,'session_start_time')),
                // SORT_ASC, 
                // $arr);    
                $ord = array();
                foreach ($arr as $key => $value){
                    $ord[] = strtotime($value['session_start_time']);
                }
                array_multisort($ord, SORT_ASC, $arr);
                
                return $arr;
            break;
            default:
                // return $arr;
                // return array_multisort(array_map('strtotime',array_column($arr,'session_start_time')),
                // SORT_DESC, 
                // $arr);
            break;
        }
        

    }
}




