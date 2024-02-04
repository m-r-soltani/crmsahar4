<?php defined('__ROOT__') or exit('No direct script access allowed');
class Helper
{
    //09155820616
    public static function Login_Just_Check()
    {
        if (isset($_SESSION['login']) && $_SESSION['login'] === 'true' && isset($_SESSION['user_id']) && $_SESSION['user_id'] !== '' && $_SESSION['user_id'] !== null && $_SESSION['user_id'] !== 'null' && isset($_SESSION['user_type']) && $_SESSION['user_type'] !== '' && $_SESSION['user_type'] !== 'null' && $_SESSION['user_type'] !== 'NULL' && $_SESSION['user_type'] !== 'Null' && $_SESSION['user_type'] !== null) {
            return true;
        } else {
            return false;
        }
    }
    public static function asiatechEmkanSanji(string $tel, string $sertype, bool $chechotherpap)
    {
        $arr = [];
        $telecenter = $GLOBALS['bs']->getLocationFromPhonePrefix($tel);
        if ($GLOBALS['bs']->errorCheck($telecenter)) {
            $telename = "مرکز : " . $telecenter['result']['data']['ciname'] . '-' . $telecenter['result']['data']['loname'];
            $markaze_mokhaberati = $telecenter['result']['data']['loid'];
        } else {
            // return $telecenter['result']['errmsg'];
            // die(Helper::Custom_Msg($GLOBALS['bs']->getMessage($telecenter)));
            return ['hasError' => true, 'msg' => $telecenter['result']['errmsg']];
        }
        $arr['interfacetype']       = $sertype;
        $arr['checkOtherPap']       = $chechotherpap;
        $arr['loid']                = (int) $telecenter['result']['data']['loid'];
        $arr['phone']               = $tel;
        $arr['vspid']               = __ASIATECHALTVSPID__;
        $arr['bmsPriorityCheck']    = "high";
        $result = $GLOBALS['bs']->resourceFeasibilityCheck($arr);
        if ($GLOBALS['bs']->errorCheck($result)) {
            return ['hasError' => false, 'msg' => $result['result']['errmsg']];
        } else {
            // die(Helper::Custom_Msg($GLOBALS['bs']->getMessage($result) . '<br>' . $telename, 2));
            return ['hasError' => true, 'msg' => $result['result']['errmsg'] . '<br>' . $telename];
        }
    }
    public static function getClientIp()
    {
        $ip = isset($_SERVER['HTTP_CLIENT_IP'])
            ? $_SERVER['HTTP_CLIENT_IP']
            : (isset($_SERVER['HTTP_X_FORWARDED_FOR'])
                ? $_SERVER['HTTP_X_FORWARDED_FOR']
                : $_SERVER['REMOTE_ADDR']);
        if ($ip) {
            return $ip;
        } else {
            return false;
        }
    }
    // public static function 
    public static function getCurrentUserInfo()
    {
        $arr = [];
        switch ($_SESSION['user_type']) {
            case __ADMINUSERTYPE__:
            case __ADMINOPERATORUSERTYPE__:
                $sql = "SELECT * FROM bnm_users WHERE id = ?";
                $user = Db::secure_fetchall($sql, [$_SESSION['id']]);
                if (!$user) return false;
                $arr['name'] = $user[0]['name'];
                $arr['fname'] = $user[0]['name_khanevadegi'];
                $arr['mobile'] = $user[0]['mobile'];
                $arr['code_meli'] = $user[0]['code_meli'];
                break;
            case __MODIRUSERTYPE__:
            case __MODIR2USERTYPE__:
            case __OPERATORUSERTYPE__:
            case __OPERATOR2USERTYPE__:
                $sql = "SELECT * FROM bnm_operator WHERE id = ?";
                $user = Db::secure_fetchall($sql, [$_SESSION['user_id']]);
                if (!$user) return false;
                $arr['name'] = $user[0]['name'];
                $arr['fname'] = $user[0]['name_khanevadegi'];
                $arr['mobile'] = $user[0]['telephone_hamrah'];
                $arr['code_meli'] = $user[0]['code_meli'];
                break;
                //todo get subinfo...

            default:
                return false;
                break;
        }
        return $arr;
    }

    public static function onlyAdminAndBranches()
    {
        switch ($_SESSION['user_type']) {
            case __ADMINUSERTYPE__:
            case __ADMINOPERATORUSERTYPE__:
            case __MODIRUSERTYPE__:
            case __MODIR2USERTYPE__:
            case __OPERATORUSERTYPE__:
            case __OPERATOR2USERTYPE__:
                return true;
                break;

            default:
                return false;
                break;
        }
        return false;
    }

    public static function IsDateValid($myDateString)
    {
        return (bool)strtotime($myDateString);
    }

    public static function logLockInternetService($username, $requestedby, $susptype, $susporder = '', $refnum = '', $comment = '')
    {
        $id = $GLOBALS['ibs_internet']->getUserIdByNormalUsername($username);
        if (!$id) return 111;
        $arr = [];
        $arr['username'] = $username;
        $arr['ibsid'] = $id;
        $arr['suspid'] = 0;
        $arr['susptype'] = $susptype;
        $arr['susporder'] = $susporder;
        $arr['requestedby'] = $requestedby;
        $arr['isvalid'] = 1;
        $arr['refnum'] = $refnum;
        $arr['comment'] = $comment;
        switch ((int)$susptype) {
            case 0:
                $arr['tarikhe_darkhast'] = Helper::Today_Miladi_Date('-') . ' ' . Helper::nowTimeTehran();
                $arr['tarikhe_vasl'] = Helper::Today_Miladi_Date('-') . ' ' . Helper::nowTimeTehran();
                break;
            case 1:
                $arr['tarikhe_darkhast'] = Helper::Today_Miladi_Date('-') . ' ' . Helper::nowTimeTehran();
                $arr['tarikhe_vasl'] = date('Y-m-d', strtotime("+5 year")) . ' ' . Helper::nowTimeTehran();
                break;
            case 2:
                $arr['tarikhe_darkhast'] = Helper::Today_Miladi_Date('-') . ' ' . Helper::nowTimeTehran();
                $arr['tarikhe_vasl'] = date('Y-m-d', strtotime("+1 day")) . ' ' . Helper::nowTimeTehran();
                break;
            case 3:
                $arr['tarikhe_darkhast'] = Helper::Today_Miladi_Date('-') . ' ' . Helper::nowTimeTehran();
                $arr['tarikhe_vasl'] = date('Y-m-d', strtotime("+3 day")) . ' ' . Helper::nowTimeTehran();
                break;
            case 4:
                $arr['tarikhe_darkhast'] = Helper::Today_Miladi_Date('-') . ' ' . Helper::nowTimeTehran();
                $arr['tarikhe_vasl'] = date('Y-m-d', strtotime("+7 day")) . ' ' . Helper::nowTimeTehran();
                break;
            case 5:
                $arr['tarikhe_darkhast'] = Helper::Today_Miladi_Date('-') . ' ' . Helper::nowTimeTehran();
                $arr['tarikhe_vasl'] = date('Y-m-d', strtotime("+15 day")) . ' ' . Helper::nowTimeTehran();
                break;
            case 6:
                $arr['tarikhe_darkhast'] = Helper::Today_Miladi_Date('-') . ' ' . Helper::nowTimeTehran();
                $arr['tarikhe_vasl'] = date('Y-m-d', strtotime("+30 day")) . ' ' . Helper::nowTimeTehran();
                break;
            default:
                return 222;
                break;
        }

        $sql = self::Insert_Generator($arr, 'bnm_susp');
        $res = Db::secure_insert_array($sql, $arr);
        if (is_numeric($res)) {
            return $res;
        } else {
            return 333;
        }
    }

    public static function logUnlockInternetService($username, $requestedby, $susptype, $susporder = '', $refnum = '', $comment = '')
    {
        $id = $GLOBALS['ibs_internet']->getUserIdByNormalUsername($username);
        $foundlockrow = false;
        $sql = "SELECT
                    * 
                FROM
                    bnm_susp 
                WHERE
                    username = ? 
                    AND requestedby = ?
                    AND suspid = 0
                    AND susptype <> 0
                    AND isvalid = 1 
                    AND tarikhe_vasl >= CURRENT_TIMESTAMP()";
        $locks = Db::secure_fetchall($sql, [$username, $requestedby]);
        if ($locks) {
            if ($refnum) {
                foreach ($locks as $k => $v) {
                    if ($v['refnum'] === $refnum) {
                        $foundlockrow = true;
                        // $sql="UPDATE bnm_susp SET isvalid=0 WHERE ";
                        $sql = Helper::Update_Generator(['id' => $v['id'], 'isvalid' => 0], 'bnm_susp', 'WHERE id=:id', ['refnum']);
                        $query = Db::secure_update_array($sql, ['id' => $v['id'], 'isvalid' => 0]);
                        break;
                    }
                }
                if (!$foundlockrow) {
                    $sql = Helper::Update_Generator(['id' => $locks[0]['id'], 'isvalid' => 0], 'bnm_susp', 'WHERE id=:id', ['refnum']);
                    $query = Db::secure_update_array($sql, ['id' => $locks[0]['id'], 'isvalid' => 0]);
                }
            }
        }
        if (!$id) return false;
        $arr = [];
        $arr['username'] = $username;
        $arr['ibsid'] = $id;
        $arr['suspid'] = 1;
        $arr['susptype'] = $susptype;
        $arr['susporder'] = $susporder;
        $arr['tarikhe_darkhast'] = Helper::Today_Miladi_Date('-') . ' ' . Helper::nowTimeTehran();
        $arr['requestedby'] = $requestedby;
        $arr['isvalid'] = 1;
        $arr['refnum'] = $refnum;
        $arr['comment'] = $comment;
        $sql = self::Insert_Generator($arr, 'bnm_susp');
        $res = Db::secure_insert_array($sql, $arr);
        if (is_numeric($res)) {
            return $res;
        } else {
            return false;
        }
    }

    public static function checkUserCanBeUnsuspended($username, $requestedby)
    {
        //$requestedby 1= crm, 2= siam
        $isitok = false;
        $sql = "SELECT
                count(*) num
            FROM
                bnm_susp 
            WHERE
                tarikhe_vasl >= CURRENT_TIMESTAMP() 
                AND suspid = 0
                AND susptype <> 0 
                AND username= ?
                AND requestedby = ?
                AND isvalid = ?";
        $sghat = Db::secure_fetchall($sql, [$username, $requestedby, 1]);
        // if($sghat){
        //     $sql="SELECT
        //             count(*) num
        //         FROM
        //             bnm_susp 
        //         WHERE
        //             suspid = 1
        //             AND tarikhe_darkhast >= ?
        //             AND username= ?
        //             AND requestedby = ?";
        //     $svasl=Db::secure_fetchall($sql, [$sghat[0]['tarikhe_darkhast'], $username, $requestedby]);
        //     if($svasl[0]['num'] >= count($sghat)) $isitok=true;
        // }else{
        //     $isitok=true;
        // }
        if ($sghat[0]['num'] > 0) {
            return false;
        } else {
            return true;
        }
        // return $isitok;
    }

    public static function ibsGetUserInfoByArrayId($ids, $resultfix = true, $groupservicetype = 'internet')
    {
        if (!$ids) return false;
        $str = '';
        for ($i = 0; $i < count($ids); $i++) {
            if ($i !== array_key_last($ids)) {
                $str .= (string)$ids[$i] . ",";
            } else {
                $str .= (string)$ids[$i];
            }
        }
        if (!$str) return false;
        if ($groupservicetype === 'internet') {
            $res = $GLOBALS['ibs_internet']->getUserInfoByUserID($str, true);
        } else {
            $res = $GLOBALS['ibs_voip']->getUserInfoByUserID($str, true);
        }
        $arr = [];
        if ($resultfix) {
            if (isset($res)) {
                if ($res) {
                    foreach ($res as $k => $v) {
                        $arr[] = $v;
                    }
                    if (!$arr) return false;
                    return $arr;
                }
            }
        }
        if (!isset($res)) {
            return false;
        }
        if (!$res) {
            return false;
        }
        return $res;
    }

    public static function GetIbsiUserInfoByArrayUsername($usernames, $resultfix = true)
    {
        if (!$usernames) return false;
        $ids = [];
        $usernames = array_unique($usernames);
        foreach ($usernames as $k => $v) {
            if (!in_array($v, $ids) && $v) {
                $ids[] = $GLOBALS['ibs_internet']->getUserIdByNormalUsername($v);
            }
        }
        if (!$ids) return false;
        $ids = array_unique($ids);
        $str = '';
        for ($i = 0; $i < count($ids); $i++) {
            if ($i !== array_key_last($ids)) {
                $str .= (string)$ids[$i] . ",";
            } else {
                $str .= (string)$ids[$i];
            }
        }
        if (!$str) return false;
        $res = $GLOBALS['ibs_internet']->getUserInfoByUserID($str, true);
        $arr = [];
        if ($resultfix) {
            if (isset($res)) {
                if ($res) {
                    foreach ($res as $k => $v) {
                        $arr[] = $v;
                    }
                    if (!$arr) return false;
                    return $arr;
                }
            }
        }
        if (!isset($res)) {
            return false;
        }
        if (!$res) {
            return false;
        }
        return $res;
    }

    public static function ibsGetOnlineUserInfoByArrayId($ids, $fixresult = true)
    {
        if (!$ids) return false;
        $str = '';
        for ($i = 0; $i < count($ids); $i++) {
            if ($i !== array_key_last($ids)) {
                $str .= (string)$ids[$i] . ",";
            } else {
                $str .= (string)$ids[$i];
            }
        }
        if (!$str) return false;
        if ($fixresult) {
            $res = $GLOBALS['ibs_internet']->getUserInfoByUserID($str, true);
            $arr = [];
            foreach ($res as $key => $value) {
                if ($res[$key]) {
                    if ($res[$key]['online_status']) {
                        $res[$key]['user_id'] = $key;
                        $arr[] = $res[$key];
                    }
                }
            }
            if ($arr) {
                return $arr;
            } else {
                return false;
            }
        } else {
            $res = $GLOBALS['ibs_internet']->getUserInfoByUserID($str, false);
            return $res;
        }
    }
    public static function multipleSelectWithId($table, $ids)
    {
        $sql = "SELECT * FROM " . $table . " WHERE id IN ";
        for ($i = 0; $i < count($ids); $i++) {
            if ($i === array_key_first($ids)) {
                $sql .= "(?,";
            } elseif ($i === array_key_last($ids)) {
                $sql .= "?)";
            } else {
                $sql .= "?,";
            }
        }
        $res = Db::secure_fetchall($sql, $ids);
        return $res;
    }

    public static function checkIbsResultExist($ibsresult)
    {
        if (isset($ibsresult)) {
            if ($ibsresult) {
                if (isset($ibsresult[0])) {
                    if ($ibsresult[0]) {
                        if (isset($ibsresult[1])) {
                            if ($ibsresult[1]) {
                                return true;
                            }
                        }
                    }
                }
            }
        }
        return false;
    }
    public static function checkIbsResultStrict($ibsresult)
    {
        if (isset($ibsresult)) {
            if ($ibsresult) {
                if (isset($ibsresult[0])) {
                    if ($ibsresult[0]) {
                        if (isset($ibsresult[1])) {
                            if ($ibsresult[1]) {
                                if (isset($ibsresult[1][1])) {
                                    if ($ibsresult[1][1]) {
                                        return true;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return false;
    }
    public static function createDateRange($first, $last, $step = '+1 day', $format = 'Y-m-d')
    {
        $dates = [];
        $current = strtotime($first);
        $last = strtotime($last);

        while ($current <= $last) {

            $dates[] = date($format, $current);
            $current = strtotime($step, $current);
        }

        return $dates;
    }

    public static function setIbsCustomfieldsByFactorid($fid)
    {
        if (!$fid) return false;
        $serinfo = self::getServiceInfoByFactoridNoAuth($fid);
        if ($serinfo) {
            $subinfo = self::Select_By_Id('bnm_subscribers', $serinfo[0]['subid']);
            switch (strtolower($serinfo[0]['general_sertype'])) {
                case 'bitstream':
                case 'adsl':
                case 'vdsl':
                    $service_name = 'ADSL';
                    $userid = $GLOBALS['ibs_internet']->getUserIdByNormalUsername($serinfo[0]['ibsusername']);
                    if ($userid[0] && isset($service_name)) {
                        $id = $userid[1];
                        $res = $GLOBALS['ibs_internet']->setUserCustomField((string) $id, 'service_name', $service_name);
                    }
                    break;
                case 'wireless':
                    $service_name = 'WIRELESS';
                    $userid = $GLOBALS['ibs_internet']->getUserIdByNormalUsername($serinfo[0]['ibsusername']);
                    if ($userid[0] && isset($service_name)) {
                        $sql = "SELECT
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
                        $res_station = Db::secure_fetchall($sql, [$serinfo[0]['emkanat_id']]);
                        if ($res_station) {
                            // $tol=self::decimalToLL($res_station[0]['tol_joghrafiai']);
                            // $arz=self::decimalToLL($res_station[0]['arz_joghrafiai']);
                            $id = $userid[1];
                            $res = $GLOBALS['ibs_internet']->setUserCustomField((string) $id, 'service_name', $service_name);
                            $res = $GLOBALS['ibs_internet']->setUserCustomField((string) $id, 'location1', $res_station[0]['tol_joghrafiai'] . ',' . $res_station[0]['arz_joghrafiai']);
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }

                    break;
                case 'tdlte':
                    $service_name = 'TD_LTE';
                    $userid = $GLOBALS['ibs_internet']->getUserIdByNormalUsername($serinfo[0]['ibsusername']);
                    if ($userid[0] && isset($service_name)) {
                        $id = $userid[1];
                        $res = $GLOBALS['ibs_internet']->setUserCustomField((string) $id, 'service_name', $service_name);
                    }
                    break;

                default:

                    break;
            }
            return true;
        }
    }

    public static function crmDailyReportLog($mtarikh, $status = 1)
    {
        $tmp = ['status' => $status, 'mtarikh' => $mtarikh . ' ' . self::nowShamsihisv()];
        $sql = self::Insert_Generator($tmp, 'bnm_crmdailyreportlog');
        $res = Db::secure_insert_array($sql, $tmp);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }
    public static function quickCrmReport($date, $fd, $td)
    {
        $name   = "CRM_" . $date . "_" . "SaharErtebat.csv";
        $res    = CrmReport::reportByCustomDates($fd, $td);
        $csv    = self::createCrmReportCsv($res, 'dump');
        if ($csv) {
            $ftp = self::sendCrmReportFileWithFtp(__CRMFTPHOST__, __CRMFTPUSER__, __CRMFTPPASS__, __ROOT__, 'dump.csv', __CRMFTPDESTPATH__, $name);
            return $ftp;
        }
        return false;
    }
    public static function sendCrmReportFileWithFtp($host, $user, $pass, $localfilepath, $localfilename, $destfilepath, $destfilename)
    {
        // $user='Sahar_Ertebat';
        // $pass='XxeNhfmq';
        // connect to FTP server
        $ftp_conn = ftp_connect($host);
        if (!$ftp_conn) {
            return false;
        }
        //login to FTP server
        $login = ftp_login($ftp_conn, $user, $pass);
        // upload file
        if (ftp_put($ftp_conn, $destfilepath . $destfilename, $localfilepath . $localfilename, FTP_ASCII)) {
            //success
            ftp_close($ftp_conn);
            return true;
        } else {
            //fail
            ftp_close($ftp_conn);
            return false;
        }
    }

    public static function createCrmReportCsv(string $data, string $filename, $path = '')
    {
        $data       = [[$data]];
        $f = fopen($path . $filename . ".csv", 'w+');
        if (!$f) {
            return false;
        }
        foreach ($data as $row) {
            fprintf($f, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($f, $row);
        }
        fclose($f);
        return true;
    }

    public static function ToLL($north, $east, $utmZone)
    {
        // This is the lambda knot value in the reference
        $LngOrigin = Deg2Rad($utmZone * 6 - 183);

        // The following set of class constants define characteristics of the
        // ellipsoid, as defined my the WGS84 datum.  These values need to be
        // changed if a different dataum is used.    

        $FalseNorth = 0;   // South or North?
        //if (lat < 0.) FalseNorth = 10000000.  // South or North?
        //else          FalseNorth = 0.   

        $Ecc = 0.081819190842622;       // Eccentricity
        $EccSq = $Ecc * $Ecc;
        $Ecc2Sq = $EccSq / (1. - $EccSq);
        $Ecc2 = sqrt($Ecc2Sq);      // Secondary eccentricity
        $E1 = (1 - sqrt(1 - $EccSq)) / (1 + sqrt(1 - $EccSq));
        $E12 = $E1 * $E1;
        $E13 = $E12 * $E1;
        $E14 = $E13 * $E1;

        $SemiMajor = 6378137.0;         // Ellipsoidal semi-major axis (Meters)
        $FalseEast = 500000.0;          // UTM East bias (Meters)
        $ScaleFactor = 0.9996;          // Scale at natural origin

        // Calculate the Cassini projection parameters

        $M1 = ($north - $FalseNorth) / $ScaleFactor;
        $Mu1 = $M1 / ($SemiMajor * (1 - $EccSq / 4.0 - 3.0 * $EccSq * $EccSq / 64.0 - 5.0 * $EccSq * $EccSq * $EccSq / 256.0));

        $Phi1 = $Mu1 + (3.0 * $E1 / 2.0 - 27.0 * $E13 / 32.0) * sin(2.0 * $Mu1);
        + (21.0 * $E12 / 16.0 - 55.0 * $E14 / 32.0)           * sin(4.0 * $Mu1);
        + (151.0 * $E13 / 96.0)                          * sin(6.0 * $Mu1);
        + (1097.0 * $E14 / 512.0)                        * sin(8.0 * $Mu1);

        $sin2phi1 = sin($Phi1) * sin($Phi1);
        $Rho1 = ($SemiMajor * (1.0 - $EccSq)) / pow(1.0 - $EccSq * $sin2phi1, 1.5);
        $Nu1 = $SemiMajor / sqrt(1.0 - $EccSq * $sin2phi1);

        // Compute parameters as defined in the POSC specification.  T, C and D

        $T1 = tan($Phi1) * tan($Phi1);
        $T12 = $T1 * $T1;
        $C1 = $Ecc2Sq * cos($Phi1) * cos($Phi1);
        $C12 = $C1 * $C1;
        $D  = ($east - $FalseEast) / ($ScaleFactor * $Nu1);
        $D2 = $D * $D;
        $D3 = $D2 * $D;
        $D4 = $D3 * $D;
        $D5 = $D4 * $D;
        $D6 = $D5 * $D;

        // Compute the Latitude and Longitude and convert to degrees
        $lat = $Phi1 - $Nu1 * tan($Phi1) / $Rho1 * ($D2 / 2.0 - (5.0 + 3.0 * $T1 + 10.0 * $C1 - 4.0 * $C12 - 9.0 * $Ecc2Sq) * $D4 / 24.0 + (61.0 + 90.0 * $T1 + 298.0 * $C1 + 45.0 * $T12 - 252.0 * $Ecc2Sq - 3.0 * $C12) * $D6 / 720.0);

        $lat = Rad2Deg($lat);

        $lon = $LngOrigin + ($D - (1.0 + 2.0 * $T1 + $C1) * $D3 / 6.0 + (5.0 - 2.0 * $C1 + 28.0 * $T1 - 3.0 * $C12 + 8.0 * $Ecc2Sq + 24.0 * $T12) * $D5 / 120.0) / cos($Phi1);

        $lon = Rad2Deg($lon);

        // Create a object to store the calculated Latitude and Longitude values
        $PC_LatLon['lat'] = $lat;
        $PC_LatLon['lon'] = $lon;

        // Returns a PC_LatLon object
        return $PC_LatLon;
    }
    public static function getShahrinfoById($id)
    {
        $sql = "SELECT
            id,
            NAME faname,
            name_en enname,
            latitude lat,
            longitude lon
        FROM
            bnm_shahr 
        WHERE
            id = ?";
        $res = Db::secure_fetchall($sql, [$id]);
        if (!$res) {
            return false;
        }
        return $res;
    }
    public static function getOstanInfoById($id)
    {
        $sql = "SELECT
            id,
            NAME faname,
            name_en enname,
            latitude lat,
            longitude lon,
                        o.pish_shomare_ostan
        FROM
            bnm_ostan o
        WHERE
            id = ?";
        $res = Db::secure_fetchall($sql, [$id]);
        if (!$res) {
            return false;
        }
        return $res;
    }
    public static function getCountryInfoById($id)
    {
        $sql = "SELECT c.id, c.`code`, c.`name` FROM bnm_countries c WHERE id = ?";
        $res = Db::secure_fetchall($sql, [$id]);
        if (!$res) {
            return false;
        }
        return $res;
    }

    public static function logUserInfoUpdate($subid)
    {
        $factors = self::getInternetServiceInfoBySubidNoAuth($subid);
        $ipass = self::getBandWidthServiceBySubidNoAuth($subid);
        if ($factors || $ipass) {
            $arr = [];
            $arr['mtarikh'] = self::Today_Miladi_Date('-') . ' ' . self::nowTimeTehran(':', true, true);
            $arr['subid'] = $subid;
            $sql = self::Insert_Generator($arr, 'bnm_subinfoupdatelogs');
            $res = Db::secure_insert_array($sql, $arr);
            if ($res) {
                return true;
            }
        }
        return false;
    }
    public static function getBandWidthServiceBySubidNoAuth($subid)
    {
        $sql = "SELECT * FROM bnm_ip_assign WHERE sub = ?";
        $res = Db::secure_fetchall($sql, [$subid]);
        if (!$res) return false;
        return $res;
    }

    public static function getIbsLogsByArrayUsernamesDesc($usernames, $fdate = false, $tdate = false, $rows = 200, $date_unit = false)
    {
        if (!is_array($usernames)) {
            return false;
        }
        if (!$fdate) {
            $fdate = date("Y-m-d H:i:s", strtotime("-6 months"));
        }
        if (!$tdate) {
            $tdate = date("Y-m-d") . " " . self::nowTimeTehran();
        }
        if (!$date_unit) {
            $date_unit = 'gregorian';
        }
        $ids = [];
        for ($i = 0; $i < count($usernames); $i++) {
            if ($usernames[$i]) {
                $id = $GLOBALS['ibs_internet']->getUserIdByNormalUsername($usernames[$i]);
                if ($id) {
                    $ids[] = $id;
                }
            }
        }
        if (!$ids) return false;
        $ids = array_unique($ids);
        if (!$ids) return false;
        $strids = '';
        for ($i = 0; $i < count($ids); $i++) {
            if ($ids[$i] && $i === array_key_last($ids)) {
                $strids .= (string)$ids[$i];
            } elseif ($ids[$i] && $i !== array_key_last($ids)) {
                $strids .= (string)$ids[$i] . ",";
            }
        }
        if (!$strids) return false;
        $res = $GLOBALS['ibs_internet']->getConnectionByUserIdAndDateTimeDesc($strids, $fdate, $tdate, $rows, $date_unit);
        if (self::checkIbsResultStrict($res)) {
            return $res;
        } else {
            return false;
        }
    }

    public static function getIbsLogsByArrayUsernamesAndRemoteIpDesc($usernames, $ip, $fdate = false, $tdate = false, $rows = 200, $date_unit = false)
    {
        if (!is_array($usernames)) {
            return false;
        }
        if (!$fdate) {
            $fdate = date("Y-m-d H:i:s", strtotime("-6 months"));
        }
        if (!$tdate) {
            $tdate = date("Y-m-d H:i:s") . " " . self::nowTimeTehran();
        }
        if (!$date_unit) {
            $date_unit = 'gregorian';
        }
        $ids = [];
        for ($i = 0; $i < count($usernames); $i++) {
            if ($usernames[$i]) {
                $id = $GLOBALS['ibs_internet']->getUserIdByNormalUsername($usernames[$i]);
                if ($id) {
                    $ids[] = $id;
                }
            }
        }
        if (!$ids) return false;
        $ids = array_unique($ids);
        if (!$ids) return false;
        $strids = '';
        for ($i = 0; $i < count($ids); $i++) {
            if ($ids[$i] && $i === array_key_last($ids)) {
                $strids .= (string)$ids[$i];
            } elseif ($ids[$i] && $i !== array_key_last($ids)) {
                $strids .= (string)$ids[$i] . ",";
            }
        }
        if (!$strids) return false;
        $res = $GLOBALS['ibs_internet']->getConnectionByUserIdAndUserIdAndDateTimeDesc($strids, $ip, $fdate, $tdate, $rows, $date_unit);
        if (self::checkIbsResultStrict($res)) {
            return $res;
        } else {
            return false;
        }
    }

    public static function getIbsUserinfoByUsernameAndSertype($username, $sertype = "internet")
    {
        if (!$username || !$sertype) return false;
        switch ($sertype) {
            case 'Internet':
            case 'internet':
            case 'adsl':
            case 'vdsl':
            case 'bitstream':
            case 'wireless':
            case 'tdlte':
                // $res_usrid = $GLOBALS['ibs_internet']->getUserIdByNormalUsername($res_factor[0]['ibsusername']);
                // $res = $GLOBALS['ibs_internet']->setNormalUserAuth((string) $res_usrid[1], $res_factor[0]['ibsusername'], $_POST['newpassword']);
                $res = $GLOBALS['ibs_internet']->getUserInfoByNormalUserName($username);
                if (!$res) return 1;
                if (!isset($res[1])) {
                    return false;
                }
                if (!$res[1]) {
                    return false;
                }
                $key = array_keys($res[1])[0];
                if (!isset($key)) {
                    return false;
                }
                if (!$key) {
                    return false;
                }
                if (isset($res[1][$key]['attrs']) && isset($res[1][$key]['basic_info'])) {
                    return $res[1][$key];
                } else {
                    return false;
                }
                break;
            case 'voip':
                return false;
                // die(self::Json_Message('e'));
                // $res_usrid = $GLOBALS['ibs_internet']->getUserIdByVoipUsername($res_factor[0]['ibsusername']);
                // $res = $GLOBALS['ibs_voip']->setVoipUserAuth((string) $res_usrid[1], $res_factor[0]['ibsusername'], $_POST[0]['newpassword']);
                // $userinfo = $GLOBALS['ibs_internet']->getUserInfoByViopUserName($res_factor[0]['ibsusername']);
                break;
            default:
                return false;
                // die(self::Json_Message('f'));
                break;
        }
    }

    public static function checkAsiatechBitstreamResponse($res)
    {
        if (!isset($res)) return false;
        if (!$res) return false;
        if (!isset($res['result'])) return false;
        if ($res['result']['errcode'] !== 0) return false;
        return true;
        // if(isset($res['error']) &&)

    }

    static public function verifyDate($date, $strict = true)
    {
        $dateTime = DateTime::createFromFormat('m/d/Y', $date);
        if ($strict) {
            $errors = DateTime::getLastErrors();
            if (!empty($errors['warning_count'])) {
                return false;
            }
        }
        return $dateTime !== false;
    }
    public static function validateDate($date, $format = 'Y-m-d H:i:s')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
    public static function displayPredefiendMessage($res)
    {
        if ($res['HasError']) {
            return self::Custom_Msg($res['Message'], 2);
        } else {
            return self::Custom_Msg($res['Message'], 1);
        }
    }
    public static function array2csv($data, $path = 'c:/', $delimiter = ',', $enclosure = '"', $escape_char = "\\")
    {
        $f = fopen($path, 'w+');
        foreach ($data as $item) {
            fputcsv($f, $item, $delimiter, $enclosure, $escape_char);
        }
        rewind($f);
        return stream_get_contents($f);
    }

    public static function Get_Ip()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return  $ip;
    }

    public static function decimalToLL($coord,/* */ $resultformat = 'string')
    {

        $isnorth = $coord >= 0;
        $coord = abs($coord);
        $deg = floor($coord);
        $coord = ($coord - $deg) * 60;
        $min = floor($coord);
        $sec = floor(($coord - $min) * 60);
        // return array($deg, $min, $sec, $isnorth ? 'N' : 'S');
        // or if you want the string representation
        return sprintf("%d&deg;%d'%d\"%s", $deg, $min, $sec, $isnorth ? 'N' : 'S');
    }
    ///convert latitude longitude to decimal
    public static function DMStoDD($deg, $min, $sec)
    {
        return $deg + ((($min * 60) + ($sec)) / 3600);
    }
    ///convert decimal to latitude longitude ( Degrees / minutes / seconds ) 
    public static function DDtoDMS($dec)
    {
        $vars = explode(".", $dec);
        $deg = $vars[0];
        $tempma = "0." . $vars[1];

        $tempma = $tempma * 3600;
        $min = floor($tempma / 60);
        $sec = $tempma - ($min * 60);

        return array("deg" => $deg, "min" => $min, "sec" => $sec);
    }

    public static function DECtoDMS($latitude, $longitude)
    {
        $latitudeDirection = $latitude < 0 ? 'S' : 'N';
        $longitudeDirection = $longitude < 0 ? 'W' : 'E';

        $latitudeNotation = $latitude < 0 ? '-' : '';
        $longitudeNotation = $longitude < 0 ? '-' : '';

        $latitudeInDegrees = floor(abs($latitude));
        $longitudeInDegrees = floor(abs($longitude));

        $latitudeDecimal = abs($latitude) - $latitudeInDegrees;
        $longitudeDecimal = abs($longitude) - $longitudeInDegrees;

        $_precision = 3;
        $latitudeMinutes = round($latitudeDecimal * 60, $_precision);
        $longitudeMinutes = round($longitudeDecimal * 60, $_precision);

        return sprintf(
            '%s%s° %s %s %s%s° %s %s',
            $latitudeNotation,
            $latitudeInDegrees,
            $latitudeMinutes,
            $latitudeDirection,
            $longitudeNotation,
            $longitudeInDegrees,
            $longitudeMinutes,
            $longitudeDirection
        );
    }
    public static function resultArray(bool $haserror, $result = [], string $msg = 'f')
    {
        if ($haserror) {
            return [
                'HasError' => $haserror,
                'Result' => $result,
                'Message' => ($msg) ? $msg : 'f'
            ];
        } else {
            return [
                'HasError' => $haserror,
                'Result' => $result,
                'Message' => ($msg) ? $msg : 's'
            ];
        }
    }

    public static function checkEstAuthSub($subid)
    {
        $sql = "SELECT response, requestname FROM shahkar_log WHERE subscriber_id = ? AND LOWER(requestname) = LOWER('estauthsub') ORDER BY id DESC LIMIT 1";
        $shahkar = Db::secure_fetchall($sql, [$subid]);
        if ($shahkar) {
            if ($shahkar[0]['response'] === 200) {
                return true;
                // die(self::Json_Message('sap'));
            } else {
                return false;
            }
        } else {
            // die(self::Json_Message('sanf'));
            return false;
        }
    }
    public static function makeRequestId($providercode)
    {
        $date       = DateTime::createFromFormat('U.u', microtime(TRUE));
        $date->setTimeZone(new DateTimeZone('Asia/Tehran'));
        $resultdate = $date->format('YmdHisu');
        $request_id = $providercode . $resultdate;
        if ($request_id) {
            return $request_id;
        } else {
            return false;
        }
    }

    public static function suspensionMessages($optype)
    {
        switch ((int)$optype) {
            case 1:
                return 'فعالسازی: ';
                break;
            case 2:
                return 'تعلیق دوطرفه: ';
                break;
            case 3:
                return 'تخلیه: ';
                break;
            case 4:
                return 'تعلیق یک طرفه: ';
                break;
            case 5:
                return 'سلب امتیاز: ';
                break;
            case 6:
                return 'مسدودی: ';
                break;
            default:
                return false;
                break;
        }
    }
    public static function unixTimestampToDateTime($unixts, $format = 'Y-m-d H:i:s')
    {
        $res = date($format, (int)$unixts);
        return $res;
    }
    public static function lastSuspensionStatus($subid, $sertype, $emkanatid)
    {
        $sql = "SELECT * FROM bnm_suspensions sus WHERE subid= ? AND servicetype= ? AND emkanatid= ? ORDER BY datetime_auto DESC LIMIT 1";
        $res = Db::secure_fetchall($sql, [$subid, $sertype, $emkanatid]);
        if (!$res) {
            return 'unlocked';
        } else {
            if ($res[0]['lockstatus'] === 1) {
                return 'locked';
            } else {
                return 'unlocked';
            }
        }
    }
    public static function lockWithLogByUsername($username, $optype, $comment, $time = '0', $refnum = '')
    {
        $premsg = self::suspensionMessages($optype);
        $sers = self::getAllInternetUsersServicesInfoNoAuth();
        if ($time === '0' || $time === 0) {
            $unlockdatetime = '';
        } else {
            $unlockdatetime = self::Today_Miladi_Date() . ' ' . self::nowTimeTehran(':', true, true);
            $unlockdatetime = self::Add_Or_Minus_Day_To_Date($time, '+', $unlockdatetime);
        }
        $arr = [];
        foreach ($sers as $k => $v) {
            if ($v['ibsusername'] === $username) {
                $arr['emkanatid'] = $v['emkanat_id'];
                $arr['subid'] = $v['subid'];
                $arr['factorid'] = $v['fid'];
                $arr['servicetype'] = $v['sertype'];
                $arr['modat'] = $time;
                $arr['lockstatus'] = 1;
                $arr['lock_datetime'] = self::Today_Miladi_Date() . ' ' . self::nowTimeTehran(':', true, true);
                $arr['tozihate_lock'] = $comment;
                $arr['siam_refnum'] = $refnum;
                break;
            }
        }
        if (!$arr) return false;
        $result = self::lockService($username, 'internet', $premsg . $comment);
        if (!$result) return false;
        $sql = self::Insert_Generator($arr, 'bnm_suspensions');
        $ressus = Db::secure_insert_array($sql, $arr);
        if (!$ressus) {
            return self::resultArray(true, [], self::Messages('e'));
        }
        return true;
        // if(! $result){
        //     $sql="DELETE FROM bnm_suspensions WHERE id = ?";
        //     $del=Db::secure_fetchall($sql, [$ressus]);
        //     return self::resultArray(false, [], self::Messages('s'));
        // }

    }
    public static function lockWithLog($operationtype, $factorid, $time = "0", $tozihat = "قطع بصورت سیستمی", $refnum = "")
    {
        $premsg = self::suspensionMessages($operationtype);
        if (!$premsg) self::resultArray(true, [], 'نوع عملیات ناشناخته درخواست خود را اصلاح کنید.');
        $sql = "SELECT fa.subscriber_id , ser.type, fa.emkanat_id FROM bnm_factor fa
        INNER JOIN bnm_services ser ON ser.id = fa.service_id
        INNER JOIN bnm_subscribers sub ON sub.id = fa.subscriber_id
        WHERE fa.id = ?";
        $res = Db::secure_fetchall($sql, array($factorid));
        if (!$res) {
            return self::resultArray(true, [], 'اطلاعات سرویس یا مشخصات مشترک یافت نشد.');
        }
        $ibsusername = self::getIbsUsername($res[0]['subscriber_id'], $res[0]['type'], $res[0]['emkanat_id']);
        if (!$ibsusername) {
            return self::resultArray(true, [], 'اطلاعات سرویس یا مشخصات مشترک یافت نشد.');
        }
        $laststatus = self::lastSuspensionStatus($res[0]['subscriber_id'], $res[0]['type'], $res[0]['emkanat_id']);
        if ($laststatus === "locked") {
            return self::resultArray(true, [], 'این سرویس قبلا مسدود شده');
        }
        if ($time === '0') {
            $unlockdatetime = '';
        } else {
            $unlockdatetime = self::Today_Miladi_Date() . ' ' . self::nowTimeTehran(':', true, true);
            $unlockdatetime = self::Add_Or_Minus_Day_To_Date($time, '+', $unlockdatetime);
        }
        $arr = [
            'subid'             => $res[0]['subscriber_id'],
            'factorid'          => $factorid,
            'tozihate_lock'     => $premsg . $tozihat,
            'emkanatid'         => $res[0]['emkanat_id'],
            'servicetype'       => $res[0]['type'],
            'modat'             => $time,
            'lock_datetime'     => self::Today_Miladi_Date() . ' ' . self::nowTimeTehran(':', true, true),
            'lockstatus'        => $operationtype,
        ];
        if ($refnum) {
            $arr['siam_refnum']     = $refnum;
        }
        $sql    = self::Insert_Generator($arr, 'bnm_suspensions');
        $ressus = Db::secure_insert_array($sql, $arr);
        if (!$ressus) {
            return self::resultArray(true, [], self::Messages('e'));
        }
        // return self::resultArray(true, [], self::Messages('test'));
        // return $ressus;
        if ($res[0]['type'] === "voip") {
            $result = self::lockService($ibsusername[0]['ibsusername'], 'voip', $premsg . $tozihat);
            if (!$result) {
                $sql = "DELETE FROM bnm_suspensions WHERE id = ?";
                $del = Db::secure_fetchall($sql, [$ressus]);
            }
            return self::resultArray(false, [], self::Messages('s'));
        } else {
            $result = self::lockService($ibsusername[0]['ibsusername'], 'internet', $premsg . $tozihat);
            if (!$result) {
                $sql = "DELETE FROM bnm_suspensions WHERE id = ?";
                $del = Db::secure_fetchall($sql, [$ressus]);
                return self::resultArray(false, [], self::Messages('s'));
            }
        }
    }

    public static function unlockWithLog($operationtype, $factorid, $tozihat = "وصل شده بصورت سیستمی", $refnum = "")
    {
        $premsg = self::suspensionMessages($operationtype);
        if (!$premsg) self::resultArray(true, [], 'نوع عملیات ناشناخته درخواست خود را اصلاح کنید.');
        $sql = "SELECT fa.subscriber_id , ser.type, fa.emkanat_id FROM bnm_factor fa
        INNER JOIN bnm_services ser ON ser.id = fa.service_id
        INNER JOIN bnm_subscribers sub ON sub.id = fa.subscriber_id
        WHERE fa.id = ?";
        $res = Db::secure_fetchall($sql, array($factorid));
        if (!$res) return self::resultArray(true, [], self::Messages('serinf'));
        $ibsusername = self::getIbsUsername($res[0]['subscriber_id'], $res[0]['type'], $res[0]['emkanat_id']);
        if (!$ibsusername) return self::resultArray(true, [], self::Messages('serinf'));
        $arr                    = [];
        $arr['subid']           = $res[0]['subscriber_id'];
        $arr['emkanatid']       = $res[0]['emkanat_id'];
        $arr['servicetype']     = $res[0]['type'];
        $arr['tozihate_unlock'] = $premsg . $tozihat;
        $arr['unlock_datetime'] = self::Today_Miladi_Date() . ' ' . self::nowTimeTehran(':', true, true);
        $arr['lockstatus']      = $operationtype;
        if ($refnum) {
            $arr['siam_refnum']     = $refnum;
        }
        $sql = "SELECT * FROM bnm_suspensions WHERE subid=? AND emkanatid=? AND servicetype=? ORDER BY datetime_auto DESC LIMIT 1";
        $check = Db::secure_fetchall($sql, [$arr['subid'], $arr['emkanatid'], $arr['servicetype']]);

        if ($check) {
            //update
            $arr['id'] = $check[0]['id'];
            $sql = self::Update_Generator($arr, 'bnm_suspensions', "WHERE id=:id");
            $ressus = Db::secure_update_array($sql, $arr);
            if (!$ressus) {
                return self::resultArray(true, [], self::Messages('e'));
            }
            $ressus = $arr['id'];
        } else {
            //insert
            $arr['modat'] = 1;
            $arr['lock_datetime'] = self::Add_Or_Minus_Day_To_Date(1, '-', self::Today_Miladi_Date() . ' ' . self::nowTimeTehran(':', true, true));
            $arr['factorid'] = $factorid;
            $arr['tozihate_lock'] = 'قطع شده بصورت سیستمی';
            $sql = self::Insert_Generator($arr, 'bnm_suspensions');
            $ressus = Db::secure_insert_array($sql, $arr);
        }
        if (!$ressus) {
            return self::resultArray(true, [], self::Messages('e'));
        }
        // return self::resultArray(true, [], self::Messages('test'));
        if ($res[0]['type'] === "voip") {
            $result = self::unlockService($ibsusername[0]['ibsusername'], 'voip');
            if (!$result) {
                $sql = "DELETE FROM bnm_suspensions WHERE id = ?";
                $del = Db::secure_fetchall($sql, [$ressus]);
            }
            return self::resultArray(false, [], self::Messages('s'));
        } else {
            $result = self::unlockService($ibsusername[0]['ibsusername'], 'internet');
            if (!$result) {
                $sql = "DELETE FROM bnm_suspensions WHERE id = ?";
                $del = Db::secure_fetchall($sql, [$ressus]);
            }
            return self::resultArray(false, [], self::Messages('s'));
        }
    }

    public static function lockService(string $ibsusername, $sertype = 'internet', $comment = '')
    {
        if ($sertype === "internet") {
            $ibsinfo = $GLOBALS['ibs_internet']->getUserInfoByNormalUserName($ibsusername);
        } else {
            $ibsinfo = $GLOBALS['ibs_voip']->getUserInfoByVoipUserName($ibsusername);
        }
        if (isset($ibsinfo)) {
            if ($ibsinfo[1]) {
                $key = key($ibsinfo[1]);
                if (!$key) {
                    return false;
                }
                $ibsuserid = $ibsinfo[1][$key]['basic_info']['user_id'];
                if (!$ibsuserid) {
                    return false;
                }
                if ($sertype === "internet") {
                    $res = $GLOBALS['ibs_internet']->lockUser((string) $ibsuserid, $comment);
                } else {
                    $res = $GLOBALS['ibs_voip']->lockUser((string) $ibsuserid, $comment);
                }
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function unlockService(string $ibsusername, $sertype = 'internet')
    {
        if ($sertype === "internet") {
            $ibsinfo = $GLOBALS['ibs_internet']->getUserInfoByNormalUserName($ibsusername);
        } else {
            $ibsinfo = $GLOBALS['ibs_voip']->getUserInfoByVoipUserName($ibsusername);
        }
        if (isset($ibsinfo)) {
            if ($ibsinfo[1]) {
                $key = key($ibsinfo[1]);
                if (!$key) {
                    return false;
                }
                $ibsuserid = $ibsinfo[1][$key]['basic_info']['user_id'];
                if (!$ibsuserid) {
                    return false;
                }
                if ($sertype === "internet") {
                    $res = $GLOBALS['ibs_internet']->unlockUser((string) $ibsuserid);
                    // $res=$GLOBALS['ibs_internet']->setUserAttribute((string) $ibsuserid, 'unlock', 'no');
                    // $res=$GLOBALS['ibs_internet']->deleteUserAttribute((string) $ibsuserid, 'lock');

                } else {
                    $res = $GLOBALS['ibs_voip']->unlockUser((string) $ibsuserid);
                }
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function seconds2MDH($ss)
    {
        $s = $ss % 60;
        $m = floor(($ss % 3600) / 60);
        $h = floor(($ss % 86400) / 3600);
        $d = floor(($ss % 2592000) / 86400);
        $M = floor($ss / 2592000);
        // return "$M M, $d d, $h h, $m m, $s s";
        if ($M) {
            return $M . "M," . $d . "d," . $h . "h," . $m . "m," . $s . "s";
        } else {
            if ($d) {
                return $d . "d," . $h . "h," . $m . "m," . $s . "s";
            } else {
                return $h . "h," . $m . "m," . $s . "s";
            }
        }
    }

    public static function formatMac($string, $formatInput, $formatOutput)
    {
        // $string = "0025.9073.3014";
        // echo formatMac($string,'%02s%02s.%02s%02s.%02s%02s','%02s:%02s:%02s:%02s:%02s:%02s');
        // //00:25:90:73:30:14

        // $string = '00:a0:3d:08:ef:63';
        // echo formatMac($string,'%x:%x:%x:%x:%x:%x','%02X%02X%02X:%02X%02X%02X');
        // //00A03D:08EF63

        // $string = '00A03D:08EF63';
        // echo formatMac($string,'%02X%02X%02X:%02X%02X%02X','%02x:%02x:%02x:%02x:%02x:%02x');
        // //00:a0:3d:08:ef:63
        return vsprintf($formatOutput, sscanf($string, $formatInput));
    }
    public static function byteConvertArray(array $arr, string $paramname, $force_unit = NULL, $format = NULL, $si = TRUE)
    {
        for ($i = 0; $i < count($arr); $i++) {
            if ($arr[$i][$paramname] < 1) {
                $arr[$i][$paramname] = 0;
            }
            $arr[$i][$paramname] = self::byteConvert($arr[$i][$paramname], $force_unit, $format, $si);
        }
        return $arr;
    }
    public static function byteConvert($bytes, $force_unit = NULL, $format = NULL, $si = TRUE)
    {
        // Format string
        $format = ($format === NULL) ? '%01.2f %s' : (string) $format;

        // IEC prefixes (binary)
        if ($si == FALSE or strpos($force_unit, 'i') !== FALSE) {
            $units = array('B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB');
            $mod   = 1024;
        }
        // SI prefixes (decimal)
        else {
            $units = array('B', 'kB', 'MB', 'GB', 'TB', 'PB');
            $mod   = 1000;
        }

        // Determine unit to use
        if (($power = array_search((string) $force_unit, $units)) === FALSE) {
            $power = ($bytes > 0) ? floor(log($bytes, $mod)) : 0;
        }

        return sprintf($format, $bytes / pow($mod, $power), $units[$power]);
    }

    public static function isMobile(string $phoneNumber)
    {
        if (preg_match("/^(\+98|0|0098)?9\d{9}$/", $phoneNumber)) {
            return true;
        } else {
            return false;
        }
    }

    public static function isPhone($m)
    {
        if (preg_match("/^0[0-9]{2,}[0-9]{7,}$/", $m)) {
            return true;
        } else {
            return false;
        }
    }
    public static function isWirelessUsername($m)
    {
        if (preg_match("/^w-[0-9]{1,9}-[0-9]{10,}$/", $m)) {
            return true;
        } else {
            return false;
        }
    }
    public static function toByteSize($p_sFormatted)
    {
        $aUnits = array('B' => 0, 'KB' => 1, 'MB' => 2, 'GB' => 3, 'TB' => 4, 'PB' => 5, 'EB' => 6, 'ZB' => 7, 'YB' => 8);
        $sUnit = strtoupper(trim(substr($p_sFormatted, -2)));
        if (intval($sUnit) !== 0) {
            $sUnit = 'B';
        }
        if (!in_array($sUnit, array_keys($aUnits))) {
            return false;
        }
        $iUnits = trim(substr($p_sFormatted, 0, strlen($p_sFormatted) - 2));
        if (!intval($iUnits) == $iUnits) {
            return false;
        }
        return $iUnits * pow(1024, $aUnits[$sUnit]);
    }

    public static function getAllUsers()
    {
        $sql = "SELECT
            sub.id,
            IF(sub.noe_moshtarak = 'real', CONCAT( sub.name, ' ', sub.f_name ),sub.name_sherkat) name,
            IF(sub.noe_moshtarak = 'real', sub.code_meli,sub.shomare_sabt) code_meli,
            sub.telephone1,
            sub.telephone_hamrah,
            IF(sub.noe_moshtarak = 'real', 'حقیقی', 'حقوقی') noe_moshtarak
            FROM bnm_subscribers sub ORDER BY id DESC";
        $res = Db::fetchall_Query($sql);
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }
    public static function getDistinctUserServicesInfo($subid)
    {
        $sql = "SELECT
            fa.id fid,
            fa.emkanat_id,
            fa.subscriber_id,
            IF(ser.noe_khadamat='BITSTREAM_ADSL','adsl',IF(ser.noe_khadamat='BITSTREAM_VDSL','vdsl',ser.type)) sertype,
            ser.type 
        FROM
            bnm_factor fa
            INNER JOIN bnm_services ser ON ser.id = fa.service_id 
            INNER JOIN bnm_subscribers sub ON sub.id = fa.subscriber_id
        WHERE
            ser.noe_forosh IN ( 'adi', 'jashnvare' ) 
            AND fa.tasvie_shode = ?
            AND fa.subscriber_id = ?
            AND sub.id = ?
        GROUP BY fa.subscriber_id,ser.type,fa.emkanat_id";
        $res = Db::secure_fetchall($sql, [1, $subid, $subid]);
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }
    public static function getAllUserServices($subid)
    {
        $sql = "SELECT
            fa.id fid,
            fa.emkanat_id,
            fa.subscriber_id,
            ser.noe_khadamat,
            IF(ser.noe_khadamat='bitstream_adsl','adsl',IF(ser.noe_khadamat='bitstream_vdsl','vdsl',ser.type)) sertype,
            ser.type 
        FROM
            bnm_factor fa
            INNER JOIN bnm_services ser ON ser.id = fa.service_id 
        WHERE
            ser.noe_forosh IN ( 'adi', 'jashnvare' ) 
            AND fa.tasvie_shode = ?
            AND fa.subscriber_id =?";
        $res = Db::secure_fetchall($sql, [1, $subid]);

        if ($res) {
            return $res;
        } else {
            return false;
        }
    }

    public static function allArrayElementsHasValue($arr)
    {
        foreach ($arr as $key => $value) {
            if (!isset($key)) {
                return false;
            }
            if (!$value) {
                return false;
            }
        }
        return true;
    }

    public static function getUserServices(/*all OR subscriber_id*/$subid = 'all',/*all-internet-voip-adsl-wireless-tdlte*/ $service_group = 'all')
    {
        $res = false;
        $sql = "SELECT
            sub.name,
            sub.f_name,
            sub.name_sherkat,
            sub.code_meli,
            sub.shenase_meli,
            sub.noe_moshtarak,
            sub.telephone1,
            fa.id factorid,
            fa.emkanat_id,
            fa.tarikhe_tasvie_shode,
            fa.subscriber_id,
            IF(ser.type = 'bitstream', 'adsl', IF( ser.type = 'vdsl', 'adsl',ser.type )) service_type,
            ser.type sertype,
            ser.id serviceid,
            ser.hadeaxar_sorat_daryaft 
            FROM
                bnm_factor fa
                INNER JOIN bnm_services ser ON ser.id = fa.service_id
                INNER JOIN bnm_subscribers sub ON sub.id = fa.subscriber_id 
            WHERE ";

        switch ($service_group) {
            case 'all':
                if ($subid === 'all') {
                    $sql .= "
                    ser.noe_forosh IN ('adi','jashnvare')
                    AND fa.tasvie_shode = ?
                    AND ser.type NOT IN ('ip')
                    GROUP BY
                        fa.subscriber_id,
                        fa.emkanat_id
                    ORDER BY
                        fa.id DESC";
                    $res = Db::secure_fetchall($sql, [1]);
                } else {
                    $sql .= "
                    fa.subscriber_id = ?
                    AND ser.noe_forosh IN ('adi','jashnvare')
                    AND fa.tasvie_shode = ?
                    AND ser.type NOT IN ('ip')
                    GROUP BY
                        fa.subscriber_id,
                        fa.emkanat_id
                    ORDER BY
                        fa.id DESC";
                    $res = Db::secure_fetchall($sql, [$subid, 1]);
                }
                break;
            case 'internet':
                if ($subid === 'all') {
                    $sql .= "
                    ser.noe_forosh IN ('adi','jashnvare')
                    AND fa.tasvie_shode = ?
                    AND ser.type IN ('adsl', 'vdsl', 'bitstream', 'wireless', 'tdlte')
                    GROUP BY
                        fa.subscriber_id,
                        fa.emkanat_id
                    ORDER BY
                        fa.id DESC";
                    $res = Db::secure_fetchall($sql, [1]);
                } else {
                    $sql .= "
                    fa.subscriber_id = ?
                    AND ser.noe_forosh IN ('adi','jashnvare')
                    AND fa.tasvie_shode = ?
                    AND ser.type IN ('adsl', 'vdsl', 'bitstream', 'wireless', 'tdlte')
                    GROUP BY
                        fa.subscriber_id,
                        fa.emkanat_id
                    ORDER BY
                        fa.id DESC";
                    $res = Db::secure_fetchall($sql, [$subid, 1]);
                }
                break;
            case 'voip':
                if ($subid === 'all') {
                    $sql .= "
                    ser.noe_forosh IN ('adi','jashnvare')
                    AND fa.tasvie_shode = ?
                    AND ser.type IN ('voip')
                    GROUP BY
                        fa.subscriber_id,
                        fa.emkanat_id
                    ORDER BY
                        fa.id DESC";
                    $res = Db::secure_fetchall($sql, [1]);
                } else {
                    $sql .= "
                    fa.subscriber_id = ?
                    AND ser.noe_forosh IN ('adi','jashnvare')
                    AND fa.tasvie_shode = ?
                    AND ser.type IN('voip')
                    GROUP BY
                        fa.subscriber_id,
                        fa.emkanat_id,
                        
                    ORDER BY
                        fa.id DESC";
                    $res = Db::secure_fetchall($sql, [$subid, 1]);
                }
                break;
            default:
                return false;
                break;
        }
        if ($res) {
            for ($i = 0; $i < count($res); $i++) {
                $ibsusername = self::getIbsUsername($subid, $res[$i]['sertype'], $res[$i]['emkanat_id']);
                if ($ibsusername) {
                    $res[$i]['ibsusername'] = $ibsusername[0]['ibsusername'];
                } else {
                    $res[$i]['ibsusername'] = false;
                }
            }
            return $res;
        } else {
            return false;
        }
    }

    public static function getLastSubShahkarEst()
    {
        $sql = "SELECT count(*) rownum FROM shahkar_log WHERE subscriber_id= ? AND noe_darkhast= ? AND response = ? ORDER BY date DESC LIMIT 1";
        $res = Db::secure_update_array($sql, [$_SESSION['user_id'], 2, 200]);
        if ($res[0]['rownum'] > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function getUserCurrentCredit()
    {
        switch ($_SESSION['user_type']) {
            case __MOSHTARAKUSERTYPE__:
                $sql = "SELECT credit FROM bnm_credits WHERE user_or_branch_id= ? AND noe_user = ? ORDER BY update_time DESC LIMIT 1";
                $res = Db::secure_fetchall($sql, [$_SESSION['user_id'], 1]);
                if ($res) {
                    return $res;
                } else {
                    return false;
                }
                break;
            case __MODIRUSERTYPE__:
            case __MODIR2USERTYPE__:
            case __OPERATORUSERTYPE__:
            case __OPERATOR2USERTYPE__:
                $sql = "SELECT credit FROM bnm_credits WHERE user_or_branch_id= ? AND noe_user = ? ORDER BY update_time DESC LIMIT 1";
                $res = Db::secure_fetchall($sql, [$_SESSION['branch_id'], 2]);
                if ($res) {
                    return $res;
                } else {
                    return false;
                }
                break;

            default:
                return false;
                break;
        }
    }

    public static function cLog($res, $tojson = true)
    {
        if ($tojson) {
            $res = json_encode($res, JSON_UNESCAPED_UNICODE);
            echo "<script>console.log($res);</script>";
        } else {
            echo "<script>console.log($res);</script>";
        }
    }

    public static function zarinpalVerifyByCallback($authority, $status)
    {
        if ($status === "OK") {
            $sql = "SELECT * FROM bnm_zarinpal WHERE authority = ?";
            $beforepayment = Db::secure_fetchall($sql, [$authority]);
            if ($beforepayment) {
                $data = array("merchant_id" => __ZARINPALMERCHANTCODE__, "authority" => $authority, "amount" => $beforepayment[0]['amount']);
                $jsonData = json_encode($data);
                $ch = curl_init(__ZARINPALVERIFYURL__);
                curl_setopt($ch, CURLOPT_USERAGENT, __ZARINPALUSERAGENT__);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($jsonData),
                ));
                $result = curl_exec($ch);
                $err = curl_error($ch);
                curl_close($ch);
                $result = json_decode($result, true);
                if ($err) {
                    return "cURL Error #:" . $err . " " . self::Messages('e');
                } else {
                    if ($result['data']['code'] === 100) {
                        $arr = [];
                        $arr['status'] = $status;
                        $arr['verifycode'] = $result['data']['code'];
                        $arr['ref_id'] = $result['data']['ref_id'];
                        $arr['card_pan'] = $result['data']['card_pan'];
                        $arr['card_hash'] = $result['data']['card_hash'];
                        $arr['fee_type'] = $result['data']['fee_type'];
                        $arr['fee'] = $result['data']['fee'];
                        $arr['id'] = $beforepayment[0]['id'];
                        $sql = self::Update_Generator($arr, 'bnm_zarinpal', "WHERE id = :id");
                        $res = Db::secure_update_array($sql, $arr);
                        if (!$res) {
                            $msg = 'مشکل در برنامه لطفا با پشتیبانی تماس بگیرید و کد پیگیری ذیل را اعلام فرمایید:';
                            $msg .= ' ' . $result['data']['ref_id'];
                            echo self::Alert_Custom_Message($msg);
                            return false;
                        }
                        $result_credit = self::addUserCreditByPayment($beforepayment[0]['userid'], $beforepayment[0]['usertype'], $beforepayment[0]['amount'], $result['data']['ref_id']);
                        // return json_encode($result_credit);
                        if ($result_credit) {
                            $msg = 'تراکنش موفق کد پیگیری ';
                            $msg .= $result['data']['ref_id'] . "<br><br>";
                            $redirectmsg = "<a href=" . __ROOT__ . 'dashboard' . ">" . "جهت بازگشت به صفحه اصلی اینجا کلیک کنید" . "</a>";
                            echo "<div style='margin-top:50px;text-align:center;font-size:18px;'>" . $msg . $redirectmsg . "</div>";
                            return true;
                        } else {
                            //transaction success add to credit failed
                            $msg = 'تراکنش موفق مشکل در بروزرسانی اعتبار لطفا کد پیگیری ذیل را به پشتیبانی اعلام نمایید';
                            $msg .= $result['data']['ref_id'] . "<br><br>";
                            $redirectmsg = "<a href=" . __ROOT__ . 'dashboard' . ">" . "جهت بازگشت به صفحه اصلی اینجا کلیک کنید" . "</a>";
                            echo "<div style='margin-top:50px;text-align:center;font-size:18px;'>" . $msg . $redirectmsg . "</div>";
                            return true;
                        }
                    } elseif ($result['data']['code'] === 101) {
                        $msg = ' تراکنش با موفقیت انجام شده و قبلا استعلام شده است کد پیگیری ';
                        $msg .= $result['data']['ref_id'] . "<br><br>";
                        $redirectmsg = "<a href=" . __ROOT__ . 'dashboard' . ">" . "جهت بازگشت به صفحه اصلی اینجا کلیک کنید" . "</a>";
                        echo "<div style='margin-top:50px;text-align:center;font-size:18px;'>" . $msg . $redirectmsg . "</div>";
                        return true;
                    } else {
                        $msg = "وضعیت تراکنش نامشخص" . $result['data']['ref_id'] . "<br><br>";
                        $redirectmsg = "<a href=" . __ROOT__ . 'dashboard' . ">" . "جهت بازگشت به صفحه اصلی اینجا کلیک کنید" . "</a>";
                        echo "<div style='margin-top:50px;text-align:center;font-size:18px;'>" . $msg . $redirectmsg . "</div>";
                        return false;
                    }
                }
            } else {
                return false;
            }
        } else {
            $sql = "UPDATE bnm_zarinpal SET status = ? WHERE authority = ?";
            $res = Db::secure_update_array($sql, [$status, $authority]);
            $msg = "وضعیت تراکنش نامشخص" . "<br><br>";
            $redirectmsg = "<a href=" . __ROOT__ . 'dashboard' . ">" . "جهت بازگشت به صفحه اصلی اینجا کلیک کنید" . "</a>";
            echo "<div style='margin-top:50px;text-align:center;font-size:18px;'>" . $msg . $redirectmsg . "</div>";
            return false;
        }
        // $sql="SELECT * FROM bnm_zarinpal WHERE authority = ? AND ";
    }

    public static function isDateValid1($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && $d->format($format) === $date;
    }

    public static function isDateValid2($myDateString)
    {
        return (bool)strtotime($myDateString);
    }

    public static function dateOfDateTime($s)
    {
        $dt = new DateTime($s);
        $date = $dt->format('Y-m-d');
        return $date;
    }
    public static function ibsConnectionLogFindIp($cl, $ip)
    {
        for ($i = count($cl); $i > 0; $i++) {
            if (isset($cl[$i]['sub_service_name'])) {
                if ($cl[$i]['sub_service_name'] === "Master") {
                    if ($cl[$i]['remote_ip'] === $ip) {
                    }
                }
            }
        }
    }
    public static function getServiceInfoWithIbsusername($username)
    {
        $allservices = self::getAllIbsusername();
        for ($i = 0; $i < count($allservices); $i++) {
            $ibsusername = self::getIbsUsername($allservices[$i]['subid'], $allservices[$i]['type'], $allservices[$i]['emkanat_id']);
            if ($ibsusername) {
                if ((string)$ibsusername[0]['ibsusername'] === (string)$username) {
                    $allservices[$i]['ibsusername'] = $ibsusername[0]['ibsusername'];
                    return $allservices[$i];
                }
            }
        }
        return false;
    }
    public static function checkIbsUserInfo($res)
    {
        if (!isset($res)) return false;
        if (!isset($res[1])) return false;
        if (!$res[1]) return false;
        return true;
    }
    public static function getIbsUserInfoId($res)
    {
        if (!isset($res)) return false;
        if (!isset($res[1])) return false;
        $key = array_keys($res[1]);
        return $key;
    }
    public static function reformIbsUserInfo($ibsuserinfo)
    {
        if (!$ibsuserinfo) return false;
        if (!$ibsuserinfo[1]) return false;
        $key = key($ibsuserinfo[1]);
        if (!$key) return false;
        return $ibsuserinfo[1][$key];
    }
    // public static function like_match($pattern, $subject)
    // {
    //     $pattern = str_replace('%', '.*', preg_quote($pattern, '/'));
    //     return (bool) preg_match("/^{$pattern}$/i", $subject);
    // }
    public static function like($str, $searchTerm)
    {
        $searchTerm = mb_strtolower($searchTerm);
        $str = mb_strtolower($str);
        $pos = strpos($str, $searchTerm);
        if ($pos === false)
            return false;
        else
            return true;
    }







    public static function regulateNumber($string, $type = 1)
    {
        if ($type === 1) {
            return strtr(trim($string), array('۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9', '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4', '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9'));
        } elseif ($type === 2) {
            return strtr(trim($string), array_flip(array('۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9', '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4', '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9')));
        } else {
            return false;
        }
    }
    public static function siamTelephoneForResult($t)
    {
        if (!$t) return false;
        if ($t[0] === "0") {
            $t = substr($t, 1);
            $t = "98" . $t;
        } else {
            $t = "98" . $t;
        }
        return self::regulateNumber($t, 2);
    }
    public static function resetIbsChargeRulesByUsername($username = '02144755050', $sertype = 'internet')
    {
        if ($sertype === "internet") {
            $ibsuserinfo = $GLOBALS['ibs_internet']->getUserInfoByNormalUserName($username);
            $check = self::checkIbsUserInfo($ibsuserinfo);
            if (!$check) return false;
            $ibsuserinfo = self::reformIbsUserInfo($ibsuserinfo);
            $ibsid = $ibsuserinfo['basic_info']['user_id'];
            for ($i = 0; $i < count($ibsuserinfo['attrs']['charge_rule_usage']); $i++) {
                // self::cLog($ibsuserinfo['attrs']['charge_rule_usage'][$i]);
                $res = $GLOBALS['ibs_internet']->resetOneChargeRuleUsage((string) $ibsid, (string) $ibsuserinfo['attrs']['charge_rule_usage'][$i][0]);
            }
        } elseif ($sertype === "voip") {
            $ibsuserinfo = $GLOBALS['ibs_voip']->getUserInfoByNormalUserName($username);
            $check = self::checkIbsUserInfo($ibsuserinfo);
            if (!$check) return false;
            $ibsuserinfo = self::reformIbsUserInfo($ibsuserinfo);
            $ibsid = $ibsuserinfo['basic_info']['user_id'];
            for ($i = 0; $i < count($ibsuserinfo['attrs']['charge_rule_usage']); $i++) {
                // self::cLog($ibsuserinfo['attrs']['charge_rule_usage'][$i]);
                $res = $GLOBALS['ibs_voip']->resetOneChargeRuleUsage((string) $ibsid, (string) $ibsuserinfo['attrs']['charge_rule_usage'][$i][0]);
            }
        } else {
            return false;
        }
        if (!isset($res)) return false;
        return true;
    }

    public static function getInternetServiceInfoBySubidEmkanatSertypeNoAuthentication($subid, $emkanat, $sertype)
    {
        $sql = "SELECT * FROM (
            SELECT fid,emkanat_id,fsertype,sertype,telephone1,code_meli,noe_moshtarak,shenase_meli,ssid,reallegal_name,
            subid,telephone_hamrah,branch_id,general_sertype,name_sherkat,
                CASE 
                    WHEN adslvdsl_ibsu THEN adslvdsl_ibsu
                    WHEN bitasiatech_ibsu THEN bitasiatech_ibsu
                    WHEN wireless_ibsu THEN IF(noe_moshtarak='real', CONCAT('w-', ssid, '-', code_meli),CONCAT('w-', ssid, '-', shenase_meli))
                    WHEN tdlte_ibsu THEN tdlte_ibsu
                    WHEN voip_ibsu THEN voip_ibsu
                    ELSE Null
                END AS ibsusername
            FROM
                (SELECT
                    sub.telephone1,
                    sub.id subid,
                    sub.branch_id,
                    sub.telephone_hamrah,
                    sub.code_meli,
                    sub.noe_moshtarak,
                    sub.shenase_meli,
                    IF(sub.noe_moshtarak='real',CONCAT(sub.name,' ',sub.f_name),sub.name_sherkat) reallegal_name,
                    sub.name name,
                    sub.f_name,
                    sub.name_sherkat,
                    f.id fid,
                    f.emkanat_id,
                    f.type fsertype,
                    ss.id ssid,
                    ser.type sertype,
                    IF(ports.telephone=1, sub.telephone1,IF(ports.telephone=2, sub.telephone2, IF(ports.telephone=3, sub.telephone3,NULL))) adslvdsl_ibsu,
                    IF(oss.telephone=1, sub.telephone1, IF(oss.telephone=2, sub.telephone2, IF(oss.telephone=3, sub.telephone3, false))) bitasiatech_ibsu,
                    IF(ser.noe_khadamat='BITSTREAM_ADSL','adsl',IF(ser.noe_khadamat='BITSTREAM_VDSL','vdsl',ser.type)) general_sertype,
                    IF(ser.type='wireless',111,null) wireless_ibsu,
                    lte.tdlte_number tdlte_ibsu,
                    CASE WHEN ser.type = 'voip' THEN IF(f.emkanat_id=1,sub.telephone1,IF(f.emkanat_id=2,sub.telephone2, IF(f.emkanat_id=3,sub.telephone3,NULL)))
                    ELSE NULL
                    END AS voip_ibsu
                FROM
                    bnm_factor f
                    INNER JOIN bnm_subscribers sub ON f.subscriber_id = sub.id
                    INNER JOIN bnm_services ser ON ser.id = f.service_id 
                    LEFT JOIN bnm_port ports ON f.emkanat_id = ports.id AND ser.type IN ('adsl','vdsl') AND ports.user_id = sub.id
                    LEFT JOIN bnm_oss_subscribers oss ON oss.user_id=f.subscriber_id AND ser.type IN ('bitstream')
                    LEFT JOIN bnm_sub_station ss ON ss.id = f.emkanat_id AND ss.sub_id= f.subscriber_id AND ser.type IN ('wireless')
                    LEFT JOIN bnm_tdlte_sim lte ON lte.id = f.emkanat_id AND lte.subscriber_id = f.subscriber_id AND ser.type IN ('tdlte')
                WHERE
                    f.type IN ( 'bitstream', 'adsl', 'vdsl', 'wireless', 'tdlte' ) 
                    AND (f.emkanat_id IS NOT NULL OR f.emkanat_id <> '')
                    AND (f.type IS NOT NULL OR f.type <> '')
                    AND (f.subscriber_id IS NOT NULL OR f.subscriber_id <> '')
                    AND f.tasvie_shode = 1 
                    GROUP BY
                        f.subscriber_id,
                        f.type,
                        f.emkanat_id) tmp
                        )tmp2
                    WHERE ibsusername <> '' AND ibsusername IS NOT NULL AND subid = ? AND emkanat_id = ? AND sertype = ?";
        $res = Db::secure_fetchall($sql, [$subid, $emkanat, $sertype]);
    }
    public static function getServiceInfoByFactorid($factorid)
    {
        switch ($_SESSION['user_type']) {
            case __ADMINUSERTYPE__:
            case __ADMINOPERATORUSERTYPE__:
                $sql = "SELECT * FROM (
                    SELECT fid,emkanat_id,fsertype,sertype,telephone1,code_meli,noe_moshtarak,shenase_meli,ssid,reallegal_name,
                    subid,telephone_hamrah,branch_id,general_sertype,name_sherkat,
                        CASE 
                            WHEN adslvdsl_ibsu THEN adslvdsl_ibsu
                            WHEN bitasiatech_ibsu THEN bitasiatech_ibsu
                            WHEN wireless_ibsu THEN IF(noe_moshtarak='real', CONCAT('w-', ssid, '-', code_meli),CONCAT('w-', ssid, '-', shenase_meli))
                            WHEN tdlte_ibsu THEN tdlte_ibsu
                            WHEN voip_ibsu THEN voip_ibsu
                            ELSE Null
                        END AS ibsusername
                    FROM
                        (SELECT
                            sub.telephone1,
                            sub.id subid,
                            sub.branch_id,
                            sub.telephone_hamrah,
                            sub.code_meli,
                            sub.noe_moshtarak,
                            sub.shenase_meli,
                            IF(sub.noe_moshtarak='real',CONCAT(sub.name,' ',sub.f_name),sub.name_sherkat) reallegal_name,
                            sub.name name,
                            sub.f_name,
                            sub.name_sherkat,
                            f.id fid,
                            f.emkanat_id,
                            f.type fsertype,
                            ss.id ssid,
                            ser.type sertype,
                            IF(ports.telephone=1, sub.telephone1,IF(ports.telephone=2, sub.telephone2, IF(ports.telephone=3, sub.telephone3,NULL))) adslvdsl_ibsu,
                            IF(oss.telephone=1, sub.telephone1, IF(oss.telephone=2, sub.telephone2, IF(oss.telephone=3, sub.telephone3, false))) bitasiatech_ibsu,
                            IF(ser.noe_khadamat='BITSTREAM_ADSL','adsl',IF(ser.noe_khadamat='BITSTREAM_VDSL','vdsl',ser.type)) general_sertype,
                            IF(ser.type='wireless',111,null) wireless_ibsu,
                            lte.tdlte_number tdlte_ibsu,
                            CASE WHEN ser.type = 'voip' THEN IF(f.emkanat_id=1,sub.telephone1,IF(f.emkanat_id=2,sub.telephone2, IF(f.emkanat_id=3,sub.telephone3,NULL)))
                            ELSE NULL
                            END AS voip_ibsu
                        FROM
                            bnm_factor f
                            INNER JOIN bnm_subscribers sub ON f.subscriber_id = sub.id
                            INNER JOIN bnm_services ser ON ser.id = f.service_id 
                            LEFT JOIN bnm_port ports ON f.emkanat_id = ports.id AND ser.type IN ('adsl','vdsl') AND ports.user_id = sub.id
                            LEFT JOIN bnm_oss_subscribers oss ON oss.user_id=f.subscriber_id AND ser.type IN ('bitstream')
                            LEFT JOIN bnm_sub_station ss ON ss.id = f.emkanat_id AND ss.sub_id= f.subscriber_id AND ser.type IN ('wireless')
                            LEFT JOIN bnm_tdlte_sim lte ON lte.id = f.emkanat_id AND lte.subscriber_id = f.subscriber_id AND ser.type IN ('tdlte')
                        WHERE
                            f.type IN ( 'bitstream', 'adsl', 'vdsl', 'wireless', 'tdlte', 'voip' ) 
                            AND (f.emkanat_id IS NOT NULL OR f.emkanat_id <> '')
                            AND (f.type IS NOT NULL OR f.type <> '')
                            AND (f.subscriber_id IS NOT NULL OR f.subscriber_id <> '')
                            AND f.tasvie_shode = 1 ";
                $sql .= " AND f.id = ? 
                        GROUP BY
                            f.subscriber_id,
                            f.type,
                            f.emkanat_id) tmp
                            )tmp2
                        WHERE ibsusername <> '' AND ibsusername IS NOT NULL";
                $res = Db::secure_fetchall($sql, [$factorid]);
                break;
            case __MODIRUSERTYPE__:
            case __MODIR2USERTYPE__:
            case __OPERATORUSERTYPE__:
            case __OPERATOR2USERTYPE__:
                $sql = "SELECT * FROM (
                    SELECT fid,emkanat_id,fsertype,sertype,telephone1,code_meli,noe_moshtarak,shenase_meli,ssid,reallegal_name,
                    subid,telephone_hamrah,branch_id,general_sertype,name_sherkat,
                    CASE 
                        WHEN adslvdsl_ibsu THEN adslvdsl_ibsu
                        WHEN bitasiatech_ibsu THEN bitasiatech_ibsu
                        WHEN wireless_ibsu THEN IF(noe_moshtarak='real', CONCAT('w-', ssid, '-', code_meli),CONCAT('w-', ssid, '-', shenase_meli))
                        WHEN tdlte_ibsu THEN tdlte_ibsu
                        WHEN voip_ibsu THEN voip_ibsu
                        ELSE Null
                        END AS ibsusername
                    FROM
                        (SELECT
                            sub.telephone1,
                            sub.id subid,
                            sub.branch_id,
                            sub.telephone_hamrah,
                            sub.code_meli,
                            sub.noe_moshtarak,
                            sub.shenase_meli,
                            IF(sub.noe_moshtarak='real',CONCAT(sub.name,' ',sub.f_name),sub.name_sherkat) reallegal_name,
                            sub.name name,
                            sub.f_name,
                            sub.name_sherkat,
                            f.id fid,
                            f.emkanat_id,
                            f.type fsertype,
                            ss.id ssid,
                            ser.type sertype,
                            IF(ports.telephone=1, sub.telephone1,IF(ports.telephone=2, sub.telephone2, IF(ports.telephone=3, sub.telephone3,NULL))) adslvdsl_ibsu,
                            IF(oss.telephone=1, sub.telephone1, IF(oss.telephone=2, sub.telephone2, IF(oss.telephone=3, sub.telephone3, false))) bitasiatech_ibsu,
                            IF(ser.noe_khadamat='BITSTREAM_ADSL','adsl',IF(ser.noe_khadamat='BITSTREAM_VDSL','vdsl',ser.type)) general_sertype,
                            IF(ser.type='wireless',111,null) wireless_ibsu,
                            lte.tdlte_number tdlte_ibsu,
                            CASE WHEN ser.type = 'voip' THEN IF(f.emkanat_id=1,sub.telephone1,IF(f.emkanat_id=2,sub.telephone2, IF(f.emkanat_id=3,sub.telephone3,NULL)))
                            ELSE NULL
                            END AS voip_ibsu
                        FROM
                            bnm_factor f
                            INNER JOIN bnm_subscribers sub ON f.subscriber_id = sub.id
                            INNER JOIN bnm_services ser ON ser.id = f.service_id 
                            LEFT JOIN bnm_port ports ON f.emkanat_id = ports.id AND ser.type IN ('adsl','vdsl') AND ports.user_id = sub.id
                            LEFT JOIN bnm_oss_subscribers oss ON oss.user_id=f.subscriber_id AND ser.type IN ('bitstream')
                            LEFT JOIN bnm_sub_station ss ON ss.id = f.emkanat_id AND ss.sub_id= f.subscriber_id AND ser.type IN ('wireless')
                            LEFT JOIN bnm_tdlte_sim lte ON lte.id = f.emkanat_id AND lte.subscriber_id = f.subscriber_id AND ser.type IN ('tdlte')
                        WHERE
                            f.type IN ( 'bitstream', 'adsl', 'vdsl', 'wireless', 'tdlte', 'voip' ) 
                            AND (f.emkanat_id IS NOT NULL OR f.emkanat_id <> '')
                            AND (f.type IS NOT NULL OR f.type <> '')
                            AND (f.subscriber_id IS NOT NULL OR f.subscriber_id <> '')
                            AND f.tasvie_shode = 1 ";
                $sql .= "
                            AND f.id = ?
                            AND sub.branch_id = ?
                        GROUP BY
                            f.subscriber_id,
                            f.type,
                            f.emkanat_id) tmp
                            )tmp2
                        WHERE ibsusername <> '' AND ibsusername IS NOT NULL";
                $res = Db::secure_fetchall($sql, [$factorid, $_SESSION['branch_id']]);
                break;
            case __MOSHTARAKUSERTYPE__:
                $sql = "SELECT * FROM (
                    SELECT fid,emkanat_id,fsertype,sertype,telephone1,code_meli,noe_moshtarak,shenase_meli,ssid,reallegal_name,
                    subid,telephone_hamrah,branch_id,general_sertype,name_sherkat,
                    CASE 
                        WHEN adslvdsl_ibsu THEN adslvdsl_ibsu
                        WHEN bitasiatech_ibsu THEN bitasiatech_ibsu
                        WHEN wireless_ibsu THEN IF(noe_moshtarak='real', CONCAT('w-', ssid, '-', code_meli),CONCAT('w-', ssid, '-', shenase_meli))
                        WHEN tdlte_ibsu THEN tdlte_ibsu
                        WHEN voip_ibsu THEN voip_ibsu
                        ELSE Null
                        END AS ibsusername
                    FROM
                        (SELECT
                            sub.telephone1,
                            sub.id subid,
                            sub.branch_id,
                            sub.telephone_hamrah,
                            sub.code_meli,
                            sub.noe_moshtarak,
                            sub.shenase_meli,
                            IF(sub.noe_moshtarak='real',CONCAT(sub.name,' ',sub.f_name),sub.name_sherkat) reallegal_name,
                            sub.name name,
                            sub.f_name,
                            sub.name_sherkat,
                            f.id fid,
                            f.emkanat_id,
                            f.type fsertype,
                            ss.id ssid,
                            ser.type sertype,
                            IF(ports.telephone=1, sub.telephone1,IF(ports.telephone=2, sub.telephone2, IF(ports.telephone=3, sub.telephone3,NULL))) adslvdsl_ibsu,
                            IF(oss.telephone=1, sub.telephone1, IF(oss.telephone=2, sub.telephone2, IF(oss.telephone=3, sub.telephone3, false))) bitasiatech_ibsu,
                            IF(ser.noe_khadamat='BITSTREAM_ADSL','adsl',IF(ser.noe_khadamat='BITSTREAM_VDSL','vdsl',ser.type)) general_sertype,
                            IF(ser.type='wireless',111,null) wireless_ibsu,
                            lte.tdlte_number tdlte_ibsu,
                            CASE WHEN ser.type = 'voip' THEN IF(f.emkanat_id=1,sub.telephone1,IF(f.emkanat_id=2,sub.telephone2, IF(f.emkanat_id=3,sub.telephone3,NULL)))
                            ELSE NULL
                            END AS voip_ibsu
                        FROM
                            bnm_factor f
                            INNER JOIN bnm_subscribers sub ON f.subscriber_id = sub.id
                            INNER JOIN bnm_services ser ON ser.id = f.service_id 
                            LEFT JOIN bnm_port ports ON f.emkanat_id = ports.id AND ser.type IN ('adsl','vdsl') AND ports.user_id = sub.id
                            LEFT JOIN bnm_oss_subscribers oss ON oss.user_id=f.subscriber_id AND ser.type IN ('bitstream')
                            LEFT JOIN bnm_sub_station ss ON ss.id = f.emkanat_id AND ss.sub_id= f.subscriber_id AND ser.type IN ('wireless')
                            LEFT JOIN bnm_tdlte_sim lte ON lte.id = f.emkanat_id AND lte.subscriber_id = f.subscriber_id AND ser.type IN ('tdlte')
                        WHERE
                            f.type IN ( 'bitstream', 'adsl', 'vdsl', 'wireless', 'tdlte', 'voip' ) 
                            AND (f.emkanat_id IS NOT NULL OR f.emkanat_id <> '')
                            AND (f.type IS NOT NULL OR f.type <> '')
                            AND (f.subscriber_id IS NOT NULL OR f.subscriber_id <> '')
                            AND f.tasvie_shode = 1 ";
                $sql .= "
                            AND f.id = ?
                            AND sub.branch_id = ?
                            AND sub.id = ?
                            AND f.subscriber_id = ?
                        GROUP BY
                            f.subscriber_id,
                            f.type,
                            f.emkanat_id) tmp
                            )tmp2
                        WHERE ibsusername <> '' AND ibsusername IS NOT NULL";
                $res = Db::secure_fetchall($sql, [$factorid, $_SESSION['branch_id'], $_SESSION['user_id'], $_SESSION['user_id']]);
                break;
            default:
                return false;
                break;
        }

        if (!$res) {
            return false;
        }
        return $res;
    }
    public static function getServiceInfoByFactoridNoAuth($factorid)
    {
        $sql = "SELECT * FROM (
                    SELECT fid,emkanat_id,fsertype,sertype,telephone1,code_meli,noe_moshtarak,shenase_meli,ssid,reallegal_name,
                    subid,telephone_hamrah,branch_id,general_sertype,name_sherkat,
                        CASE 
                            WHEN adslvdsl_ibsu THEN adslvdsl_ibsu
                            WHEN bitasiatech_ibsu THEN bitasiatech_ibsu
                            WHEN wireless_ibsu THEN IF(noe_moshtarak='real', CONCAT('w-', ssid, '-', code_meli),CONCAT('w-', ssid, '-', shenase_meli))
                            WHEN tdlte_ibsu THEN tdlte_ibsu
                            WHEN voip_ibsu THEN voip_ibsu
                            ELSE Null
                        END AS ibsusername
                    FROM
                        (SELECT
                            sub.telephone1,
                            sub.id subid,
                            sub.branch_id,
                            sub.telephone_hamrah,
                            sub.code_meli,
                            sub.noe_moshtarak,
                            sub.shenase_meli,
                            IF(sub.noe_moshtarak='real',CONCAT(sub.name,' ',sub.f_name),sub.name_sherkat) reallegal_name,
                            sub.name name,
                            sub.f_name,
                            sub.name_sherkat,
                            f.id fid,
                            f.emkanat_id,
                            f.type fsertype,
                            ss.id ssid,
                            ser.type sertype,
                            IF(ports.telephone=1, sub.telephone1,IF(ports.telephone=2, sub.telephone2, IF(ports.telephone=3, sub.telephone3,NULL))) adslvdsl_ibsu,
                            IF(oss.telephone=1, sub.telephone1, IF(oss.telephone=2, sub.telephone2, IF(oss.telephone=3, sub.telephone3, false))) bitasiatech_ibsu,
                            IF(ser.noe_khadamat='BITSTREAM_ADSL','adsl',IF(ser.noe_khadamat='BITSTREAM_VDSL','vdsl',ser.type)) general_sertype,
                            IF(ser.type='wireless',111,null) wireless_ibsu,
                            lte.tdlte_number tdlte_ibsu,
                            CASE WHEN ser.type = 'voip' THEN IF(f.emkanat_id=1,sub.telephone1,IF(f.emkanat_id=2,sub.telephone2, IF(f.emkanat_id=3,sub.telephone3,NULL)))
                            ELSE NULL
                            END AS voip_ibsu
                        FROM
                            bnm_factor f
                            INNER JOIN bnm_subscribers sub ON f.subscriber_id = sub.id
                            INNER JOIN bnm_services ser ON ser.id = f.service_id 
                            LEFT JOIN bnm_port ports ON f.emkanat_id = ports.id AND ser.type IN ('adsl','vdsl') AND ports.user_id = sub.id
                            LEFT JOIN bnm_oss_subscribers oss ON oss.user_id=f.subscriber_id AND ser.type IN ('bitstream')
                            LEFT JOIN bnm_sub_station ss ON ss.id = f.emkanat_id AND ss.sub_id= f.subscriber_id AND ser.type IN ('wireless')
                            LEFT JOIN bnm_tdlte_sim lte ON lte.id = f.emkanat_id AND lte.subscriber_id = f.subscriber_id AND ser.type IN ('tdlte')
                        WHERE
                            f.type IN ( 'bitstream', 'adsl', 'vdsl', 'wireless', 'tdlte', 'voip' ) 
                            AND (f.emkanat_id IS NOT NULL OR f.emkanat_id <> '')
                            AND (f.type IS NOT NULL OR f.type <> '')
                            AND (f.subscriber_id IS NOT NULL OR f.subscriber_id <> '')
                            AND f.tasvie_shode = 1 ";
        $sql .= " AND f.id = ? 
                        GROUP BY
                            f.subscriber_id,
                            f.type,
                            f.emkanat_id) tmp
                            )tmp2
                        WHERE ibsusername <> '' AND ibsusername IS NOT NULL";
        $res = Db::secure_fetchall($sql, [$factorid]);

        if (!$res) {
            return false;
        }
        return $res;
    }

    public static function getServiceInfoBySubid($subid)
    {
        $res = false;
        $sql = "SELECT * FROM (
            SELECT fid,emkanat_id,fsertype,sertype,telephone1,code_meli,noe_moshtarak,shenase_meli,ssid,reallegal_name,
            subid,telephone_hamrah,branch_id,
            CASE 
                WHEN adslvdsl_ibsu THEN adslvdsl_ibsu
                WHEN bitasiatech_ibsu THEN bitasiatech_ibsu
                WHEN wireless_ibsu THEN IF(noe_moshtarak='real', CONCAT('w-', ssid, '-', code_meli),CONCAT('w-', ssid, '-', shenase_meli))
                WHEN tdlte_ibsu THEN tdlte_ibsu
                WHEN voip_ibsu THEN voip_ibsu
                ELSE Null
                END AS ibsusername
            FROM
                (SELECT
                    sub.telephone1,
                    sub.id subid,
                    sub.branch_id,
                    sub.telephone_hamrah,
                    sub.code_meli,
                    sub.noe_moshtarak,
                    sub.shenase_meli,
                    IF(sub.noe_moshtarak='real',CONCAT(sub.name,' ',sub.f_name),sub.name_sherkat) reallegal_name,
                    sub.name name,
                    sub.f_name,
                    sub.name_sherkat,
                    f.id fid,
                    f.emkanat_id,
                    f.type fsertype,
                    ss.id ssid,
                    ser.type sertype,
                    IF(ports.telephone=1, sub.telephone1,IF(ports.telephone=2, sub.telephone2, IF(ports.telephone=3, sub.telephone3,NULL))) adslvdsl_ibsu,
                    IF(oss.telephone=1, sub.telephone1, IF(oss.telephone=2, sub.telephone2, IF(oss.telephone=3, sub.telephone3, false))) bitasiatech_ibsu,
                    IF(ser.type='wireless',111,null) wireless_ibsu,
                    lte.tdlte_number tdlte_ibsu,
                    CASE WHEN ser.type = 'voip' THEN IF(f.emkanat_id=1,sub.telephone1,IF(f.emkanat_id=2,sub.telephone2, IF(f.emkanat_id=3,sub.telephone3,NULL)))
                    ELSE NULL
                    END AS voip_ibsu
                FROM
                    bnm_factor f
                    INNER JOIN bnm_subscribers sub ON f.subscriber_id = sub.id
                    INNER JOIN bnm_services ser ON ser.id = f.service_id 
                    LEFT JOIN bnm_port ports ON f.emkanat_id = ports.id AND ser.type IN ('adsl','vdsl') AND ports.user_id = sub.id
                    LEFT JOIN bnm_oss_subscribers oss ON oss.user_id=f.subscriber_id AND ser.type IN ('bitstream')
                    LEFT JOIN bnm_sub_station ss ON ss.id = f.emkanat_id AND ss.sub_id= f.subscriber_id AND ser.type IN ('wireless')
                    LEFT JOIN bnm_tdlte_sim lte ON lte.id = f.emkanat_id AND lte.subscriber_id = f.subscriber_id AND ser.type IN ('tdlte')
                WHERE
                    f.type IN ( 'bitstream', 'adsl', 'vdsl', 'wireless', 'tdlte', 'voip' ) ";
        switch ($_SESSION['user_type']) {
            case __ADMINUSERTYPE__:
            case __ADMINOPERATORUSERTYPE__:
                $sql .= " AND (f.emkanat_id IS NOT NULL OR f.emkanat_id <> '')
                    AND (f.type IS NOT NULL OR f.type <> '')
                    AND (f.subscriber_id IS NOT NULL OR f.subscriber_id <> '')
                    AND f.tasvie_shode = 1
                    AND f.subscriber_id = ?
                        GROUP BY f.subscriber_id,f.type,f.emkanat_id) tmp
                        )tmp2
                    WHERE ibsusername <> '' AND ibsusername IS NOT NULL";
                $res = Db::secure_fetchall($sql, [$subid]);
                break;
            case __MODIRUSERTYPE__:
            case __MODIR2USERTYPE__:
            case __OPERATORUSERTYPE__:
            case __OPERATOR2USERTYPE__:
                $sql .= " AND (f.emkanat_id IS NOT NULL OR f.emkanat_id <> '')
                    AND (f.type IS NOT NULL OR f.type <> '')
                    AND (f.subscriber_id IS NOT NULL OR f.subscriber_id <> '')
                    AND f.tasvie_shode = 1
                    AND f.subscriber_id = ?
                    AND sub.branch_id = ?
                        GROUP BY f.subscriber_id,f.type,f.emkanat_id) tmp
                        )tmp2
                    WHERE ibsusername <> '' AND ibsusername IS NOT NULL";
                $res = Db::secure_fetchall($sql, [$subid, $_SESSION['branch_id']]);
                break;
            case __MOSHTARAKUSERTYPE__:
                $sql .= " AND (f.emkanat_id IS NOT NULL OR f.emkanat_id <> '')
                    AND (f.type IS NOT NULL OR f.type <> '')
                    AND (f.subscriber_id IS NOT NULL OR f.subscriber_id <> '')
                    AND f.tasvie_shode = 1
                    AND f.subscriber_id = ?
                    GROUP BY f.subscriber_id,f.type,f.emkanat_id) tmp )tmp2
                    WHERE ibsusername <> '' AND ibsusername IS NOT NULL";
                $res = Db::secure_fetchall($sql, [$_SESSION['user_id']]);
                break;
            default:
                return false;
                break;
        }
        if (!$res) {
            return false;
        }
        return $res;
    }
    public static function getServiceInfoBySubidNoAuth($subid)
    {
        $res = false;
        $sql = "SELECT * FROM (
            SELECT fid,emkanat_id,fsertype,sertype,telephone1,code_meli,noe_moshtarak,shenase_meli,ssid,reallegal_name,
            subid,telephone_hamrah,branch_id,siam_tarikhe_tasvie_shode,crm_tarikhe_tasvie_shode,
            CASE 
                WHEN adslvdsl_ibsu THEN adslvdsl_ibsu
                WHEN bitasiatech_ibsu THEN bitasiatech_ibsu
                WHEN wireless_ibsu THEN IF(noe_moshtarak='real', CONCAT('w-', ssid, '-', code_meli),CONCAT('w-', ssid, '-', shenase_meli))
                WHEN tdlte_ibsu THEN tdlte_ibsu
                WHEN voip_ibsu THEN voip_ibsu
                ELSE Null
                END AS ibsusername
            FROM
                (SELECT
                    sub.telephone1,
                    sub.id subid,
                    sub.branch_id,
                    sub.telephone_hamrah,
                    sub.code_meli,
                    sub.noe_moshtarak,
                    sub.shenase_meli,
                    IF(sub.noe_moshtarak='real',CONCAT(sub.name,' ',sub.f_name),sub.name_sherkat) reallegal_name,
                    sub.name name,
                    sub.f_name,
                    sub.name_sherkat,
                    f.id fid,
                    f.emkanat_id,
                    f.type fsertype,
                    DATE_FORMAT(f.tarikhe_tasvie_shode,'%Y-%m-%d %H:%i') siam_tarikhe_tasvie_shode,
                    DATE_FORMAT(f.tarikhe_tasvie_shode,'%Y-%m-%d %H:%i') crm_tarikhe_tasvie_shode,
                    ss.id ssid,
                    ser.type sertype,
                    IF(ports.telephone=1, sub.telephone1,IF(ports.telephone=2, sub.telephone2, IF(ports.telephone=3, sub.telephone3,NULL))) adslvdsl_ibsu,
                    IF(oss.telephone=1, sub.telephone1, IF(oss.telephone=2, sub.telephone2, IF(oss.telephone=3, sub.telephone3, false))) bitasiatech_ibsu,
                    IF(ser.type='wireless',111,null) wireless_ibsu,
                    lte.tdlte_number tdlte_ibsu,
                    CASE WHEN ser.type = 'voip' THEN IF(f.emkanat_id=1,sub.telephone1,IF(f.emkanat_id=2,sub.telephone2, IF(f.emkanat_id=3,sub.telephone3,NULL)))
                    ELSE NULL
                    END AS voip_ibsu
                FROM
                    bnm_factor f
                    INNER JOIN bnm_subscribers sub ON f.subscriber_id = sub.id
                    INNER JOIN bnm_services ser ON ser.id = f.service_id 
                    LEFT JOIN bnm_port ports ON f.emkanat_id = ports.id AND ser.type IN ('adsl','vdsl') AND ports.user_id = sub.id
                    LEFT JOIN bnm_oss_subscribers oss ON oss.user_id=f.subscriber_id AND ser.type IN ('bitstream')
                    LEFT JOIN bnm_sub_station ss ON ss.id = f.emkanat_id AND ss.sub_id= f.subscriber_id AND ser.type IN ('wireless')
                    LEFT JOIN bnm_tdlte_sim lte ON lte.id = f.emkanat_id AND lte.subscriber_id = f.subscriber_id AND ser.type IN ('tdlte')
                WHERE
                    f.type IN ( 'bitstream', 'adsl', 'vdsl', 'wireless', 'tdlte', 'voip' ) ";
        $sql .= " AND (f.emkanat_id IS NOT NULL OR f.emkanat_id <> '')
                    AND (f.type IS NOT NULL OR f.type <> '')
                    AND (f.subscriber_id IS NOT NULL OR f.subscriber_id <> '')
                    AND f.tasvie_shode = 1
                    AND f.subscriber_id = ?
                        GROUP BY f.subscriber_id,f.type,f.emkanat_id) tmp
                        )tmp2
                    WHERE ibsusername <> '' AND ibsusername IS NOT NULL";
        $res = Db::secure_fetchall($sql, [$subid]);
        if (!$res) {
            return false;
        }
        return $res;
    }
    public static function getInternetServiceInfoBySubidNoAuth($subid)
    {
        $res = false;
        $sql = "SELECT * FROM (
            SELECT fid,emkanat_id,fsertype,sertype,telephone1,code_meli,noe_moshtarak,shenase_meli,ssid,reallegal_name,
            subid,telephone_hamrah,branch_id,
            CASE 
                WHEN adslvdsl_ibsu THEN adslvdsl_ibsu
                WHEN bitasiatech_ibsu THEN bitasiatech_ibsu
                WHEN wireless_ibsu THEN IF(noe_moshtarak='real', CONCAT('w-', ssid, '-', code_meli),CONCAT('w-', ssid, '-', shenase_meli))
                WHEN tdlte_ibsu THEN tdlte_ibsu
                WHEN voip_ibsu THEN voip_ibsu
                ELSE Null
                END AS ibsusername
            FROM
                (SELECT
                    sub.telephone1,
                    sub.id subid,
                    sub.branch_id,
                    sub.telephone_hamrah,
                    sub.code_meli,
                    sub.noe_moshtarak,
                    sub.shenase_meli,
                    IF(sub.noe_moshtarak='real',CONCAT(sub.name,' ',sub.f_name),sub.name_sherkat) reallegal_name,
                    sub.name name,
                    sub.f_name,
                    sub.name_sherkat,
                    f.id fid,
                    f.emkanat_id,
                    f.type fsertype,
                    ss.id ssid,
                    ser.type sertype,
                    IF(ports.telephone=1, sub.telephone1,IF(ports.telephone=2, sub.telephone2, IF(ports.telephone=3, sub.telephone3,NULL))) adslvdsl_ibsu,
                    IF(oss.telephone=1, sub.telephone1, IF(oss.telephone=2, sub.telephone2, IF(oss.telephone=3, sub.telephone3, false))) bitasiatech_ibsu,
                    IF(ser.type='wireless',111,null) wireless_ibsu,
                    lte.tdlte_number tdlte_ibsu,
                    CASE WHEN ser.type = 'voip' THEN IF(f.emkanat_id=1,sub.telephone1,IF(f.emkanat_id=2,sub.telephone2, IF(f.emkanat_id=3,sub.telephone3,NULL)))
                    ELSE NULL
                    END AS voip_ibsu
                FROM
                    bnm_factor f
                    INNER JOIN bnm_subscribers sub ON f.subscriber_id = sub.id
                    INNER JOIN bnm_services ser ON ser.id = f.service_id 
                    LEFT JOIN bnm_port ports ON f.emkanat_id = ports.id AND ser.type IN ('adsl','vdsl') AND ports.user_id = sub.id
                    LEFT JOIN bnm_oss_subscribers oss ON oss.user_id=f.subscriber_id AND ser.type IN ('bitstream')
                    LEFT JOIN bnm_sub_station ss ON ss.id = f.emkanat_id AND ss.sub_id= f.subscriber_id AND ser.type IN ('wireless')
                    LEFT JOIN bnm_tdlte_sim lte ON lte.id = f.emkanat_id AND lte.subscriber_id = f.subscriber_id AND ser.type IN ('tdlte')
                WHERE
                    f.type IN ( 'bitstream', 'adsl', 'vdsl', 'wireless', 'tdlte' ) ";
        $sql .= " AND (f.emkanat_id IS NOT NULL OR f.emkanat_id <> '')
                    AND (f.type IS NOT NULL OR f.type <> '')
                    AND (f.subscriber_id IS NOT NULL OR f.subscriber_id <> '')
                    AND f.tasvie_shode = 1
                    AND f.subscriber_id = ?
                        GROUP BY f.subscriber_id,f.type,f.emkanat_id) tmp
                        )tmp2
                    WHERE ibsusername <> '' AND ibsusername IS NOT NULL";
        $res = Db::secure_fetchall($sql, [$subid]);
        if (!$res) {
            return false;
        }
        return $res;
    }
    public static function getInternetServiceTypesByUserid($subid)
    {
        $res = false;
        $sql = "SELECT DISTINCT(sertype) dsertype,IF(noe_khadamat='BITSTREAM_ADSL','adsl',IF(noe_khadamat='BITSTREAM_VDSL','vdsl',sertype)) sertype FROM (
            SELECT fid,emkanat_id,fsertype,sertype,telephone1,code_meli,noe_moshtarak,shenase_meli,ssid,reallegal_name,
            subid,telephone_hamrah,branch_id,noe_khadamat,
            CASE 
                WHEN adslvdsl_ibsu THEN adslvdsl_ibsu
                WHEN bitasiatech_ibsu THEN bitasiatech_ibsu
                WHEN wireless_ibsu THEN IF(noe_moshtarak='real', CONCAT('w-', ssid, '-', code_meli),CONCAT('w-', ssid, '-', shenase_meli))
                WHEN tdlte_ibsu THEN tdlte_ibsu
                WHEN voip_ibsu THEN voip_ibsu
                ELSE Null
                END AS ibsusername
            FROM
                (SELECT
                    sub.telephone1,
                    sub.id subid,
                    sub.branch_id,
                    sub.telephone_hamrah,
                    sub.code_meli,
                    sub.noe_moshtarak,
                    sub.shenase_meli,
                    IF(sub.noe_moshtarak='real',CONCAT(sub.name,' ',sub.f_name),sub.name_sherkat) reallegal_name,
                    sub.name name,
                    sub.f_name,
                    sub.name_sherkat,
                    f.id fid,
                    f.emkanat_id,
                    f.type fsertype,
                    ss.id ssid,
                    ser.type sertype,
                    ser.noe_khadamat,
                    IF(ports.telephone=1, sub.telephone1,IF(ports.telephone=2, sub.telephone2, IF(ports.telephone=3, sub.telephone3,NULL))) adslvdsl_ibsu,
                    IF(oss.telephone=1, sub.telephone1, IF(oss.telephone=2, sub.telephone2, IF(oss.telephone=3, sub.telephone3, false))) bitasiatech_ibsu,
                    IF(ser.type='wireless',111,null) wireless_ibsu,
                    lte.tdlte_number tdlte_ibsu,
                    CASE WHEN ser.type = 'voip' THEN IF(f.emkanat_id=1,sub.telephone1,IF(f.emkanat_id=2,sub.telephone2, IF(f.emkanat_id=3,sub.telephone3,NULL)))
                    ELSE NULL
                    END AS voip_ibsu
                FROM
                    bnm_factor f
                    INNER JOIN bnm_subscribers sub ON f.subscriber_id = sub.id
                    INNER JOIN bnm_services ser ON ser.id = f.service_id 
                    LEFT JOIN bnm_port ports ON f.emkanat_id = ports.id AND ser.type IN ('adsl','vdsl') AND ports.user_id = sub.id
                    LEFT JOIN bnm_oss_subscribers oss ON oss.user_id=f.subscriber_id AND ser.type IN ('bitstream')
                    LEFT JOIN bnm_sub_station ss ON ss.id = f.emkanat_id AND ss.sub_id= f.subscriber_id AND ser.type IN ('wireless')
                    LEFT JOIN bnm_tdlte_sim lte ON lte.id = f.emkanat_id AND lte.subscriber_id = f.subscriber_id AND ser.type IN ('tdlte')
                WHERE
                    f.type IN ( 'bitstream', 'adsl', 'vdsl', 'wireless', 'tdlte') ";
        switch ($_SESSION['user_type']) {
            case __ADMINUSERTYPE__:
            case __ADMINOPERATORUSERTYPE__:
                $sql .= " AND (f.emkanat_id IS NOT NULL OR f.emkanat_id <> '')
                    AND (f.type IS NOT NULL OR f.type <> '')
                    AND (f.subscriber_id IS NOT NULL OR f.subscriber_id <> '')
                    AND f.tasvie_shode = 1
                    AND f.subscriber_id = ?
                        GROUP BY f.subscriber_id,f.type,f.emkanat_id) tmp
                        )tmp2
                    WHERE ibsusername <> '' AND ibsusername IS NOT NULL";
                $res = Db::secure_fetchall($sql, [$subid]);
                break;
            case __MODIRUSERTYPE__:
            case __MODIR2USERTYPE__:
            case __OPERATORUSERTYPE__:
            case __OPERATOR2USERTYPE__:
                $sql .= " AND (f.emkanat_id IS NOT NULL OR f.emkanat_id <> '')
                    AND (f.type IS NOT NULL OR f.type <> '')
                    AND (f.subscriber_id IS NOT NULL OR f.subscriber_id <> '')
                    AND f.tasvie_shode = 1
                    AND f.subscriber_id = ?
                    AND sub.branch_id = ?
                        GROUP BY f.subscriber_id,f.type,f.emkanat_id) tmp
                        )tmp2
                    WHERE ibsusername <> '' AND ibsusername IS NOT NULL";
                $res = Db::secure_fetchall($sql, [$subid, $_SESSION['branch_id']]);
                break;
            case __MOSHTARAKUSERTYPE__:
                $sql .= " AND (f.emkanat_id IS NOT NULL OR f.emkanat_id <> '')
                    AND (f.type IS NOT NULL OR f.type <> '')
                    AND (f.subscriber_id IS NOT NULL OR f.subscriber_id <> '')
                    AND f.tasvie_shode = 1
                    AND f.subscriber_id = ?
                    GROUP BY f.subscriber_id,f.type,f.emkanat_id) tmp )tmp2
                    WHERE ibsusername <> '' AND ibsusername IS NOT NULL";
                $res = Db::secure_fetchall($sql, [$_SESSION['user_id']]);
                break;
            default:
                return false;
                break;
        }
        if (!$res) {
            return false;
        }
        return $res;
    }
    public static function getServiceInfoByDynamicSubInfo(array $dsinfo)
    {
        $tmp = "";
        for ($i = 0; $i < count($dsinfo); $i++) {
        }
        $res = false;
        $sql = "SELECT * FROM (
            SELECT fid,emkanat_id,fsertype,sertype,telephone1,code_meli,noe_moshtarak,shenase_meli,ssid,reallegal_name,
            subid,telephone_hamrah,branch_id,
            CASE 
                WHEN adslvdsl_ibsu THEN adslvdsl_ibsu
                WHEN bitasiatech_ibsu THEN bitasiatech_ibsu
                WHEN wireless_ibsu THEN IF(noe_moshtarak='real', CONCAT('w-', ssid, '-', code_meli),CONCAT('w-', ssid, '-', shenase_meli))
                WHEN tdlte_ibsu THEN tdlte_ibsu
                WHEN voip_ibsu THEN voip_ibsu
                ELSE Null
                END AS ibsusername
            FROM
                (SELECT
                    sub.telephone1,
                    sub.id subid,
                    sub.branch_id,
                    sub.telephone_hamrah,
                    sub.code_meli,
                    sub.noe_moshtarak,
                    sub.shenase_meli,
                    IF(sub.noe_moshtarak='real',CONCAT(sub.name,' ',sub.f_name),sub.name_sherkat) reallegal_name,
                    sub.name name,
                    sub.f_name,
                    sub.name_sherkat,
                    f.id fid,
                    f.emkanat_id,
                    f.type fsertype,
                    ss.id ssid,
                    ser.type sertype,
                    IF(ports.telephone=1, sub.telephone1,IF(ports.telephone=2, sub.telephone2, IF(ports.telephone=3, sub.telephone3,NULL))) adslvdsl_ibsu,
                    IF(oss.telephone=1, sub.telephone1, IF(oss.telephone=2, sub.telephone2, IF(oss.telephone=3, sub.telephone3, false))) bitasiatech_ibsu,
                    IF(ser.type='wireless',111,null) wireless_ibsu,
                    lte.tdlte_number tdlte_ibsu,
                    CASE WHEN ser.type = 'voip' THEN IF(f.emkanat_id=1,sub.telephone1,IF(f.emkanat_id=2,sub.telephone2, IF(f.emkanat_id=3,sub.telephone3,NULL)))
                    ELSE NULL
                    END AS voip_ibsu
                FROM
                    bnm_factor f
                    INNER JOIN bnm_subscribers sub ON f.subscriber_id = sub.id
                    INNER JOIN bnm_services ser ON ser.id = f.service_id 
                    LEFT JOIN bnm_port ports ON f.emkanat_id = ports.id AND ser.type IN ('adsl','vdsl') AND ports.user_id = sub.id
                    LEFT JOIN bnm_oss_subscribers oss ON oss.user_id=f.subscriber_id AND ser.type IN ('bitstream')
                    LEFT JOIN bnm_sub_station ss ON ss.id = f.emkanat_id AND ss.sub_id= f.subscriber_id AND ser.type IN ('wireless')
                    LEFT JOIN bnm_tdlte_sim lte ON lte.id = f.emkanat_id AND lte.subscriber_id = f.subscriber_id AND ser.type IN ('tdlte')
                WHERE
                    f.type IN ( 'bitstream', 'adsl', 'vdsl', 'wireless', 'tdlte', 'voip' ) ";
        switch ($_SESSION['user_type']) {
            case __ADMINUSERTYPE__:
            case __ADMINOPERATORUSERTYPE__:
                $sql .= " AND (f.emkanat_id IS NOT NULL OR f.emkanat_id <> '')
                    AND (f.type IS NOT NULL OR f.type <> '')
                    AND (f.subscriber_id IS NOT NULL OR f.subscriber_id <> '')
                    AND f.tasvie_shode = 1
                    AND f.subscriber_id = ?
                        GROUP BY f.subscriber_id,f.type,f.emkanat_id) tmp
                        )tmp2
                    WHERE ibsusername <> '' AND ibsusername IS NOT NULL";
                $res = Db::secure_fetchall($sql, [$subid]);
                break;
            case __MODIRUSERTYPE__:
            case __MODIR2USERTYPE__:
            case __OPERATORUSERTYPE__:
            case __OPERATOR2USERTYPE__:
                $sql .= " AND (f.emkanat_id IS NOT NULL OR f.emkanat_id <> '')
                    AND (f.type IS NOT NULL OR f.type <> '')
                    AND (f.subscriber_id IS NOT NULL OR f.subscriber_id <> '')
                    AND f.tasvie_shode = 1
                    AND f.subscriber_id = ?
                    AND sub.branch_id = ?
                        GROUP BY f.subscriber_id,f.type,f.emkanat_id) tmp
                        )tmp2
                    WHERE ibsusername <> '' AND ibsusername IS NOT NULL";
                $res = Db::secure_fetchall($sql, [$subid, $_SESSION['branch_id']]);
                break;
            case __MOSHTARAKUSERTYPE__:
                $sql .= " AND (f.emkanat_id IS NOT NULL OR f.emkanat_id <> '')
                    AND (f.type IS NOT NULL OR f.type <> '')
                    AND (f.subscriber_id IS NOT NULL OR f.subscriber_id <> '')
                    AND f.tasvie_shode = 1
                    AND f.subscriber_id = ?
                    GROUP BY f.subscriber_id,f.type,f.emkanat_id) tmp )tmp2
                    WHERE ibsusername <> '' AND ibsusername IS NOT NULL";
                $res = Db::secure_fetchall($sql, [$_SESSION['user_id']]);
                break;
            default:
                return false;
                break;
        }
        if (!$res) {
            return false;
        }
        return $res;
    }

    public static function getAllAsiatechBitstreamReservedOrUnReservedPortUsers()
    {
        switch ($_SESSION['user_type']) {
            case __ADMINUSERTYPE__:
            case __ADMINOPERATORUSERTYPE__:
                $sql = "SELECT * FROM (SELECT
                oss.id ossid,
                res.id resid,
                res.port,
                sub.name,
                sub.branch_id,
                sub.f_name,
                IF(oss.telephone = 1, sub.telephone1, IF(oss.telephone = 2 , sub.telephone2, IF(oss.telephone= 3 , sub.telephone3, ''))) tel,
                sub.id subid,
                IF(sub.noe_moshtarak='real', CONCAT(sub.name,' ', sub.f_name), sub.name_sherkat) reallegal_name
                FROM
                    bnm_oss_subscribers oss
                LEFT JOIN bnm_oss_reserves res ON res.oss_id = oss.id
                INNER JOIN bnm_subscribers sub ON sub.id = oss.user_id
                GROUP BY oss.user_id, oss.telephone
                ORDER BY oss.tarikh DESC)tmp WHERE tel <> '' AND LENGTH(tel>10)";
                $res = Db::fetchall_Query($sql);
                break;
            case __MODIRUSERTYPE__:
            case __MODIR2USERTYPE__:
            case __OPERATORUSERTYPE__:
            case __OPERATOR2USERTYPE__:
                $sql = "SELECT * FROM (SELECT
                oss.id ossid,
                res.id resid,
                res.port,
                sub.name,
                sub.branch_id,
                sub.f_name,
                IF(oss.telephone = 1, sub.telephone1, IF(oss.telephone = 2 , sub.telephone2, IF(oss.telephone= 3 , sub.telephone3, ''))) tel,
                sub.id subid,
                IF(sub.noe_moshtarak='real', CONCAT(sub.name,' ', sub.f_name), sub.name_sherkat) reallegal_name
                FROM
                    bnm_oss_subscribers oss
                LEFT JOIN bnm_oss_reserves res ON res.oss_id = oss.id
                INNER JOIN bnm_subscribers sub ON sub.id = oss.user_id
                WHERE sub.branch_id = ?
                GROUP BY oss.user_id, oss.telephone
                ORDER BY oss.tarikh DESC)tmp WHERE tel <> '' AND LENGTH(tel>10)";
                $res = Db::secure_fetchall($sql, [$_SESSION['branch_id']]);
                break;
        }

        return $res;
    }

    public static function getServiceInfoByServiceTypeNoAuth($sertype)
    {
        $res = false;
        $sql = "SELECT * FROM (
            SELECT fid,emkanat_id,fsertype,sertype,telephone1,code_meli,noe_moshtarak,shenase_meli,ssid,reallegal_name,
            subid,telephone_hamrah,branch_id,general_sertype,
            CASE 
                WHEN adslvdsl_ibsu THEN adslvdsl_ibsu
                WHEN bitasiatech_ibsu THEN bitasiatech_ibsu
                WHEN wireless_ibsu THEN IF(noe_moshtarak='real', CONCAT('w-', ssid, '-', code_meli),CONCAT('w-', ssid, '-', shenase_meli))
                WHEN tdlte_ibsu THEN tdlte_ibsu
                WHEN voip_ibsu THEN voip_ibsu
                ELSE Null
                END AS ibsusername
            FROM
                (SELECT
                    sub.telephone1,
                    sub.id subid,
                    sub.branch_id,
                    sub.telephone_hamrah,
                    sub.code_meli,
                    sub.noe_moshtarak,
                    sub.shenase_meli,
                    IF(sub.noe_moshtarak='real',CONCAT(sub.name,' ',sub.f_name),sub.name_sherkat) reallegal_name,
                    sub.name name,
                    sub.f_name,
                    sub.name_sherkat,
                    f.id fid,
                    f.emkanat_id,
                    f.type fsertype,
                    ss.id ssid,
                    ser.type sertype,
                    IF(ser.noe_khadamat='BITSTREAM_ADSL','adsl',IF(ser.noe_khadamat='BITSTREAM_VDSL','vdsl',ser.type)) general_sertype,
                    IF(ports.telephone=1, sub.telephone1,IF(ports.telephone=2, sub.telephone2, IF(ports.telephone=3, sub.telephone3,NULL))) adslvdsl_ibsu,
                    IF(oss.telephone=1, sub.telephone1, IF(oss.telephone=2, sub.telephone2, IF(oss.telephone=3, sub.telephone3, false))) bitasiatech_ibsu,
                    IF(ser.type='wireless',111,null) wireless_ibsu,
                    lte.tdlte_number tdlte_ibsu,
                    CASE WHEN ser.type = 'voip' THEN IF(f.emkanat_id=1,sub.telephone1,IF(f.emkanat_id=2,sub.telephone2, IF(f.emkanat_id=3,sub.telephone3,NULL)))
                    ELSE NULL
                    END AS voip_ibsu
                FROM
                    bnm_factor f
                    INNER JOIN bnm_subscribers sub ON f.subscriber_id = sub.id
                    INNER JOIN bnm_services ser ON ser.id = f.service_id 
                    LEFT JOIN bnm_port ports ON f.emkanat_id = ports.id AND ser.type IN ('adsl','vdsl') AND ports.user_id = sub.id
                    LEFT JOIN bnm_oss_subscribers oss ON oss.user_id=f.subscriber_id AND ser.type IN ('bitstream')
                    LEFT JOIN bnm_sub_station ss ON ss.id = f.emkanat_id AND ss.sub_id= f.subscriber_id AND ser.type IN ('wireless')
                    LEFT JOIN bnm_tdlte_sim lte ON lte.id = f.emkanat_id AND lte.subscriber_id = f.subscriber_id AND ser.type IN ('tdlte')
                WHERE
                    f.type = ? 
                    AND (f.emkanat_id IS NOT NULL OR f.emkanat_id <> '')
                    AND (f.type IS NOT NULL OR f.type <> '')
                    AND (f.subscriber_id IS NOT NULL OR f.subscriber_id <> '')
                    AND f.tasvie_shode = 1
                        GROUP BY f.subscriber_id, f.type, f.emkanat_id) tmp
                        )tmp2
                    WHERE ibsusername <> '' AND ibsusername IS NOT NULL";
        $res = Db::secure_fetchall($sql, [$sertype]);
        if (!$res) {
            return false;
        }
        return $res;
    }
    public static function getServiceInfoByServiceType($sertype)
    {
        $res = false;
        $sql = "SELECT * FROM (
            SELECT fid,emkanat_id,fsertype,sertype,telephone1,code_meli,noe_moshtarak,shenase_meli,ssid,reallegal_name,
            subid,telephone_hamrah,branch_id,general_sertype,
            CASE 
                WHEN adslvdsl_ibsu THEN adslvdsl_ibsu
                WHEN bitasiatech_ibsu THEN bitasiatech_ibsu
                WHEN wireless_ibsu THEN IF(noe_moshtarak='real', CONCAT('w-', ssid, '-', code_meli),CONCAT('w-', ssid, '-', shenase_meli))
                WHEN tdlte_ibsu THEN tdlte_ibsu
                WHEN voip_ibsu THEN voip_ibsu
                ELSE Null
                END AS ibsusername
            FROM
                (SELECT
                    sub.telephone1,
                    sub.id subid,
                    sub.branch_id,
                    sub.telephone_hamrah,
                    sub.code_meli,
                    sub.noe_moshtarak,
                    sub.shenase_meli,
                    IF(sub.noe_moshtarak='real',CONCAT(sub.name,' ',sub.f_name),sub.name_sherkat) reallegal_name,
                    sub.name name,
                    sub.f_name,
                    sub.name_sherkat,
                    f.id fid,
                    f.emkanat_id,
                    f.type fsertype,
                    ss.id ssid,
                    ser.type sertype,
                    IF(ser.noe_khadamat='BITSTREAM_ADSL','adsl',IF(ser.noe_khadamat='BITSTREAM_VDSL','vdsl',ser.type)) general_sertype,
                    IF(ports.telephone=1, sub.telephone1,IF(ports.telephone=2, sub.telephone2, IF(ports.telephone=3, sub.telephone3,NULL))) adslvdsl_ibsu,
                    IF(oss.telephone=1, sub.telephone1, IF(oss.telephone=2, sub.telephone2, IF(oss.telephone=3, sub.telephone3, false))) bitasiatech_ibsu,
                    IF(ser.type='wireless',111,null) wireless_ibsu,
                    lte.tdlte_number tdlte_ibsu,
                    CASE WHEN ser.type = 'voip' THEN IF(f.emkanat_id=1,sub.telephone1,IF(f.emkanat_id=2,sub.telephone2, IF(f.emkanat_id=3,sub.telephone3,NULL)))
                    ELSE NULL
                    END AS voip_ibsu
                FROM
                    bnm_factor f
                    INNER JOIN bnm_subscribers sub ON f.subscriber_id = sub.id
                    INNER JOIN bnm_services ser ON ser.id = f.service_id 
                    LEFT JOIN bnm_port ports ON f.emkanat_id = ports.id AND ser.type IN ('adsl','vdsl') AND ports.user_id = sub.id
                    LEFT JOIN bnm_oss_subscribers oss ON oss.user_id=f.subscriber_id AND ser.type IN ('bitstream')
                    LEFT JOIN bnm_sub_station ss ON ss.id = f.emkanat_id AND ss.sub_id= f.subscriber_id AND ser.type IN ('wireless')
                    LEFT JOIN bnm_tdlte_sim lte ON lte.id = f.emkanat_id AND lte.subscriber_id = f.subscriber_id AND ser.type IN ('tdlte')
                WHERE
                    f.type = ? ";
        switch ($_SESSION['user_type']) {
            case __ADMINUSERTYPE__:
            case __ADMINOPERATORUSERTYPE__:
                $sql .= " AND (f.emkanat_id IS NOT NULL OR f.emkanat_id <> '')
                    AND (f.type IS NOT NULL OR f.type <> '')
                    AND (f.subscriber_id IS NOT NULL OR f.subscriber_id <> '')
                    AND f.tasvie_shode = 1
                        GROUP BY f.subscriber_id, f.type, f.emkanat_id) tmp
                        )tmp2
                    WHERE ibsusername <> '' AND ibsusername IS NOT NULL";
                $res = Db::secure_fetchall($sql, [$sertype]);
                break;
            case __MODIRUSERTYPE__:
            case __MODIR2USERTYPE__:
            case __OPERATORUSERTYPE__:
            case __OPERATOR2USERTYPE__:
                $sql .= " AND (f.emkanat_id IS NOT NULL OR f.emkanat_id <> '')
                    AND (f.type IS NOT NULL OR f.type <> '')
                    AND (f.subscriber_id IS NOT NULL OR f.subscriber_id <> '')
                    AND f.tasvie_shode = 1
                    AND sub.branch_id = ?
                        GROUP BY f.subscriber_id,f.type,f.emkanat_id) tmp
                        )tmp2
                    WHERE ibsusername <> '' AND ibsusername IS NOT NULL";
                $res = Db::secure_fetchall($sql, [$sertype, $_SESSION['branch_id']]);
                break;
            case __MOSHTARAKUSERTYPE__:
                $sql .= " AND (f.emkanat_id IS NOT NULL OR f.emkanat_id <> '')
                    AND (f.type IS NOT NULL OR f.type <> '')
                    AND (f.subscriber_id IS NOT NULL OR f.subscriber_id <> '')
                    AND f.tasvie_shode = 1
                    AND f.subscriber_id = ?
                    GROUP BY f.subscriber_id,f.type,f.emkanat_id) tmp )tmp2
                    WHERE ibsusername <> '' AND ibsusername IS NOT NULL";
                $res = Db::secure_fetchall($sql, [$sertype, $_SESSION['user_id']]);
                break;
            default:
                return false;
                break;
        }
        if (!$res) {
            return false;
        }
        return $res;
    }
    public static function getServiceInfoByMultipleServiceTypes(array $sertype)
    {

        $res = false;
        $sql = "SELECT * FROM (
            SELECT fid,emkanat_id,fsertype,sertype,telephone1,code_meli,noe_moshtarak,shenase_meli,ssid,reallegal_name,
            subid,telephone_hamrah,branch_id,
            CASE 
                WHEN adslvdsl_ibsu THEN adslvdsl_ibsu
                WHEN bitasiatech_ibsu THEN bitasiatech_ibsu
                WHEN wireless_ibsu THEN IF(noe_moshtarak='real', CONCAT('w-', ssid, '-', code_meli),CONCAT('w-', ssid, '-', shenase_meli))
                WHEN tdlte_ibsu THEN tdlte_ibsu
                WHEN voip_ibsu THEN voip_ibsu
                ELSE Null
                END AS ibsusername
            FROM
                (SELECT
                    sub.telephone1,
                    sub.id subid,
                    sub.branch_id,
                    sub.telephone_hamrah,
                    sub.code_meli,
                    sub.noe_moshtarak,
                    sub.shenase_meli,
                    IF(sub.noe_moshtarak='real',CONCAT(sub.name,' ',sub.f_name),sub.name_sherkat) reallegal_name,
                    sub.name name,
                    sub.f_name,
                    sub.name_sherkat,
                    f.id fid,
                    f.emkanat_id,
                    f.type fsertype,
                    ss.id ssid,
                    ser.type sertype,
                    IF(ports.telephone=1, sub.telephone1,IF(ports.telephone=2, sub.telephone2, IF(ports.telephone=3, sub.telephone3,NULL))) adslvdsl_ibsu,
                    IF(oss.telephone=1, sub.telephone1, IF(oss.telephone=2, sub.telephone2, IF(oss.telephone=3, sub.telephone3, false))) bitasiatech_ibsu,
                    IF(ser.type='wireless',111,null) wireless_ibsu,
                    lte.tdlte_number tdlte_ibsu,
                    CASE WHEN ser.type = 'voip' THEN IF(f.emkanat_id=1,sub.telephone1,IF(f.emkanat_id=2,sub.telephone2, IF(f.emkanat_id=3,sub.telephone3,NULL)))
                    ELSE NULL
                    END AS voip_ibsu
                FROM
                    bnm_factor f
                    INNER JOIN bnm_subscribers sub ON f.subscriber_id = sub.id
                    INNER JOIN bnm_services ser ON ser.id = f.service_id 
                    LEFT JOIN bnm_port ports ON f.emkanat_id = ports.id AND ser.type IN ('adsl','vdsl') AND ports.user_id = sub.id
                    LEFT JOIN bnm_oss_subscribers oss ON oss.user_id=f.subscriber_id AND ser.type IN ('bitstream')
                    LEFT JOIN bnm_sub_station ss ON ss.id = f.emkanat_id AND ss.sub_id= f.subscriber_id AND ser.type IN ('wireless')
                    LEFT JOIN bnm_tdlte_sim lte ON lte.id = f.emkanat_id AND lte.subscriber_id = f.subscriber_id AND ser.type IN ('tdlte')
                WHERE
                    f.type IN (";
        for ($i = 0; $i < count($sertype); $i++) {
            if ($i < count($sertype) && isset($sertype[$i + 1])) {
                $sql .= '?' . ",";
            } else {
                $sql .= '?' . ")";
            }
        }
        switch ($_SESSION['user_type']) {
            case __ADMINUSERTYPE__:
            case __ADMINOPERATORUSERTYPE__:
                $sql .= " AND (f.emkanat_id IS NOT NULL OR f.emkanat_id <> '')
                    AND (f.type IS NOT NULL OR f.type <> '')
                    AND (f.subscriber_id IS NOT NULL OR f.subscriber_id <> '')
                    AND f.tasvie_shode = 1
                        GROUP BY f.subscriber_id, f.type, f.emkanat_id) tmp
                        )tmp2
                    WHERE ibsusername <> '' AND ibsusername IS NOT NULL";
                // array_push($sertype,'922');
                // return $sertype;
                // return $sql; 
                $res = Db::secure_fetchall($sql, $sertype);
                break;
            case __MODIRUSERTYPE__:
            case __MODIR2USERTYPE__:
            case __OPERATORUSERTYPE__:
            case __OPERATOR2USERTYPE__:
                $sql .= " AND (f.emkanat_id IS NOT NULL OR f.emkanat_id <> '')
                    AND (f.type IS NOT NULL OR f.type <> '')
                    AND (f.subscriber_id IS NOT NULL OR f.subscriber_id <> '')
                    AND f.tasvie_shode = 1
                    AND sub.branch_id = ?
                        GROUP BY f.subscriber_id,f.type,f.emkanat_id) tmp
                        )tmp2
                    WHERE ibsusername <> '' AND ibsusername IS NOT NULL";
                array_push($sertype, $_SESSION['branch_id']);
                $res = Db::secure_fetchall($sql, $sertype);
                break;
            case __MOSHTARAKUSERTYPE__:
                $sql .= " AND (f.emkanat_id IS NOT NULL OR f.emkanat_id <> '')
                    AND (f.type IS NOT NULL OR f.type <> '')
                    AND (f.subscriber_id IS NOT NULL OR f.subscriber_id <> '')
                    AND f.tasvie_shode = 1
                    AND f.subscriber_id = ?
                    GROUP BY f.subscriber_id,f.type,f.emkanat_id) tmp )tmp2
                    WHERE ibsusername <> '' AND ibsusername IS NOT NULL";
                array_push($sertype, $_SESSION['user_id']);
                $res = Db::secure_fetchall($sql, $sertype);
                break;
            default:
                return false;
                break;
        }
        if (!$res) {
            return false;
        }
        return $res;
    }
    public static function getServiceInfoByMultipleServiceTypesNoAuth(array $sertype)
    {

        $res = false;
        $sql = "SELECT * FROM (
            SELECT fid,emkanat_id,fsertype,sertype,telephone1,code_meli,noe_moshtarak,shenase_meli,ssid,reallegal_name,
            subid,telephone_hamrah,branch_id,
            CASE 
                WHEN adslvdsl_ibsu THEN adslvdsl_ibsu
                WHEN bitasiatech_ibsu THEN bitasiatech_ibsu
                WHEN wireless_ibsu THEN IF(noe_moshtarak='real', CONCAT('w-', ssid, '-', code_meli),CONCAT('w-', ssid, '-', shenase_meli))
                WHEN tdlte_ibsu THEN tdlte_ibsu
                WHEN voip_ibsu THEN voip_ibsu
                ELSE Null
                END AS ibsusername
            FROM
                (SELECT
                    sub.telephone1,
                    sub.id subid,
                    sub.branch_id,
                    sub.telephone_hamrah,
                    sub.code_meli,
                    sub.noe_moshtarak,
                    sub.shenase_meli,
                    IF(sub.noe_moshtarak='real',CONCAT(sub.name,' ',sub.f_name),sub.name_sherkat) reallegal_name,
                    sub.name name,
                    sub.f_name,
                    sub.name_sherkat,
                    osokonat.name ostane_sokonat_name_fa,
                    ssokonat.name shahre_sokonat_name_fa,
                    f.id fid,
                    f.emkanat_id,
                    f.type fsertype,
                    ss.id ssid,
                    ser.type sertype,
                    IF(ser.noe_khadamat='BITSTREAM_ADSL','adsl',IF(ser.noe_khadamat='BITSTREAM_VDSL','vdsl',ser.type)) general_sertype,
                    IF(ports.telephone=1, sub.telephone1,IF(ports.telephone=2, sub.telephone2, IF(ports.telephone=3, sub.telephone3,NULL))) adslvdsl_ibsu,
                    IF(oss.telephone=1, sub.telephone1, IF(oss.telephone=2, sub.telephone2, IF(oss.telephone=3, sub.telephone3, false))) bitasiatech_ibsu,
                    IF(ser.type='wireless',111,null) wireless_ibsu,
                    lte.tdlte_number tdlte_ibsu,
                    CASE WHEN ser.type = 'voip' THEN IF(f.emkanat_id=1,sub.telephone1,IF(f.emkanat_id=2,sub.telephone2, IF(f.emkanat_id=3,sub.telephone3,NULL)))
                    ELSE NULL
                    END AS voip_ibsu
                FROM
                    bnm_factor f
                    INNER JOIN bnm_subscribers sub ON f.subscriber_id = sub.id
                    INNER JOIN bnm_services ser ON ser.id = f.service_id 
                    INNER JOIN bnm_ostan osokonat ON osokonat.id= sub.ostane_sokonat
                    INNER JOIN bnm_shahr ssokonat ON ssokonat.id= sub.shahre_sokonat
                    LEFT JOIN bnm_port ports ON f.emkanat_id = ports.id AND ser.type IN ('adsl','vdsl') AND ports.user_id = sub.id
                    LEFT JOIN bnm_oss_subscribers oss ON oss.user_id=f.subscriber_id AND ser.type IN ('bitstream')
                    LEFT JOIN bnm_sub_station ss ON ss.id = f.emkanat_id AND ss.sub_id= f.subscriber_id AND ser.type IN ('wireless')
                    LEFT JOIN bnm_tdlte_sim lte ON lte.id = f.emkanat_id AND lte.subscriber_id = f.subscriber_id AND ser.type IN ('tdlte')
                WHERE
                    f.type IN (";
        for ($i = 0; $i < count($sertype); $i++) {
            if ($i < count($sertype) && isset($sertype[$i + 1])) {
                $sql .= '?' . ",";
            } else {
                $sql .= '?' . ")";
            }
        }
        $sql .= " AND (f.emkanat_id IS NOT NULL OR f.emkanat_id <> '')
        AND (f.type IS NOT NULL OR f.type <> '')
        AND (f.subscriber_id IS NOT NULL OR f.subscriber_id <> '')
        AND f.tasvie_shode = 1
            GROUP BY f.subscriber_id, f.type, f.emkanat_id) tmp
            )tmp2
        WHERE ibsusername <> '' AND ibsusername IS NOT NULL";
        $res = Db::secure_fetchall($sql, $sertype);
        return $res;
    }
    public static function getServiceInfoBySertypeOstanShahr(array $sertype, $ostan, $shahr, $fd, $td, int $status)
    {

        $res = false;
        $sql = "SELECT * FROM (
            SELECT fid,emkanat_id,fsertype,sertype,telephone1,code_meli,noe_moshtarak,shenase_meli,ssid,reallegal_name,
            subid,telephone_hamrah,branch_id,general_sertype,serstatus,ostane_sokonat_name_fa,shahre_sokonat_name_fa,
            tarikhe_tasvie_shode,tarikhe_payane_service,serstatus_fa,tts_formatted,tps_formatted,
            CASE 
                WHEN adslvdsl_ibsu THEN adslvdsl_ibsu
                WHEN bitasiatech_ibsu THEN bitasiatech_ibsu
                WHEN wireless_ibsu THEN IF(noe_moshtarak='real', CONCAT('w-', ssid, '-', code_meli),CONCAT('w-', ssid, '-', shenase_meli))
                WHEN tdlte_ibsu THEN tdlte_ibsu
                WHEN voip_ibsu THEN voip_ibsu
                ELSE Null
                END AS ibsusername
            FROM
                (SELECT
                    sub.telephone1,
                    sub.id subid,
                    sub.branch_id,
                    sub.telephone_hamrah,
                    sub.code_meli,
                    sub.noe_moshtarak,
                    sub.shenase_meli,
                    osokonat.name ostane_sokonat_name_fa,
                    ssokonat.name shahre_sokonat_name_fa,
                    IF(sub.noe_moshtarak='real',CONCAT(sub.name,' ',sub.f_name),sub.name_sherkat) reallegal_name,
                    sub.name name,
                    sub.f_name,
                    sub.name_sherkat,
                    f.id fid,
                    f.emkanat_id,
                    f.type fsertype,
                    IF(DATE(f.tarikhe_payane_service)>DATE(NOW()), 1,2) serstatus,
                    IF(DATE(f.tarikhe_payane_service)>DATE(NOW()), 'فعال','غیر فعال') serstatus_fa,
                    f.tarikhe_tasvie_shode,
                    DATE_FORMAT(f.tarikhe_tasvie_shode,'%Y-%m-%d %H:%i') tts_formatted,
                    f.tarikhe_payane_service,
                    DATE_FORMAT(f.tarikhe_payane_service,'%Y-%m-%d %H:%i') tps_formatted,
                    ss.id ssid,
                    ser.type sertype,
                    IF(ser.noe_khadamat='BITSTREAM_ADSL','adsl',IF(ser.noe_khadamat='BITSTREAM_VDSL','vdsl',ser.type)) general_sertype,
                    IF(ports.telephone=1, sub.telephone1,IF(ports.telephone=2, sub.telephone2, IF(ports.telephone=3, sub.telephone3,NULL))) adslvdsl_ibsu,
                    IF(oss.telephone=1, sub.telephone1, IF(oss.telephone=2, sub.telephone2, IF(oss.telephone=3, sub.telephone3, false))) bitasiatech_ibsu,
                    IF(ser.type='wireless',111,null) wireless_ibsu,
                    lte.tdlte_number tdlte_ibsu,
                    CASE WHEN ser.type = 'voip' THEN IF(f.emkanat_id=1,sub.telephone1,IF(f.emkanat_id=2,sub.telephone2, IF(f.emkanat_id=3,sub.telephone3,NULL)))
                    ELSE NULL
                    END AS voip_ibsu
                FROM
                    bnm_factor f
                    INNER JOIN bnm_subscribers sub ON f.subscriber_id = sub.id
                    INNER JOIN bnm_services ser ON ser.id = f.service_id 
                    INNER JOIN bnm_ostan osokonat ON osokonat.id= sub.ostane_sokonat
                    INNER JOIN bnm_shahr ssokonat ON ssokonat.id= sub.shahre_sokonat
                    LEFT JOIN bnm_port ports ON f.emkanat_id = ports.id AND ser.type IN ('adsl','vdsl') AND ports.user_id = sub.id
                    LEFT JOIN bnm_oss_subscribers oss ON oss.user_id=f.subscriber_id AND ser.type IN ('bitstream')
                    LEFT JOIN bnm_sub_station ss ON ss.id = f.emkanat_id AND ss.sub_id= f.subscriber_id AND ser.type IN ('wireless')
                    LEFT JOIN bnm_tdlte_sim lte ON lte.id = f.emkanat_id AND lte.subscriber_id = f.subscriber_id AND ser.type IN ('tdlte')
                WHERE
                    f.type IN (";
        for ($i = 0; $i < count($sertype); $i++) {
            if ($i < count($sertype) && isset($sertype[$i + 1])) {
                $sql .= '?' . ",";
            } else {
                $sql .= '?' . ")";
            }
        }
        if ($status !== 0) {
            if ($status === 1) {
                // faal
                $sql .= " AND DATE(f.tarikhe_payane_service)>DATE(NOW())";
            } else {
                //expire
                $sql .= " AND DATE(f.tarikhe_payane_service)<=DATE(NOW())";
            }
        }
        $sql .= " AND DATE(f.tarikhe_tasvie_shode) >= ?
                AND DATE(f.tarikhe_tasvie_shode) <= ?
                AND sub.shahre_sokonat = ?
                AND sub.ostane_sokonat = ?
                AND (f.emkanat_id IS NOT NULL OR f.emkanat_id <> '')
                AND (f.type IS NOT NULL OR f.type <> '')
                AND (f.subscriber_id IS NOT NULL OR f.subscriber_id <> '')
                AND f.tasvie_shode = ?) tmp )tmp2
                WHERE ibsusername <> '' AND ibsusername IS NOT NULL";
        //-- GROUP BY f.subscriber_id, f.type, f.emkanat_id
        $params = [];
        foreach ($sertype as $key => $value) {
            $params[] = $value;
        }
        $params[] = $fd;
        $params[] = $td;
        $params[] = $shahr;
        $params[] = $ostan;
        $params[] = 1;
        $res = Db::secure_fetchall($sql, $params);
        if (!$res) {
            return false;
        }
        return $res;
    }
    public static function getServiceInfoByServiceTypeAndSubid($subid, $sertype)
    {
        $res = false;
        $sql = "SELECT * FROM (
            SELECT fid,emkanat_id,fsertype,sertype,telephone1,code_meli,noe_moshtarak,shenase_meli,ssid,reallegal_name,
            subid,telephone_hamrah,branch_id,general_sertype,
            CASE 
                WHEN adslvdsl_ibsu THEN adslvdsl_ibsu
                WHEN bitasiatech_ibsu THEN bitasiatech_ibsu
                WHEN wireless_ibsu THEN IF(noe_moshtarak='real', CONCAT('w-', ssid, '-', code_meli),CONCAT('w-', ssid, '-', shenase_meli))
                WHEN tdlte_ibsu THEN tdlte_ibsu
                WHEN voip_ibsu THEN voip_ibsu
                ELSE Null
                END AS ibsusername
            FROM
                (SELECT
                    sub.telephone1,
                    sub.id subid,
                    sub.branch_id,
                    sub.telephone_hamrah,
                    sub.code_meli,
                    sub.noe_moshtarak,
                    sub.shenase_meli,
                    IF(sub.noe_moshtarak='real',CONCAT(sub.name,' ',sub.f_name),sub.name_sherkat) reallegal_name,
                    sub.name name,
                    sub.f_name,
                    sub.name_sherkat,
                    f.id fid,
                    f.emkanat_id,
                    f.type fsertype,
                    ss.id ssid,
                    ser.type sertype,
                    IF(ser.noe_khadamat='BITSTREAM_ADSL','adsl',IF(ser.noe_khadamat='BITSTREAM_VDSL','vdsl',ser.type)) general_sertype,
                    IF(ports.telephone=1, sub.telephone1,IF(ports.telephone=2, sub.telephone2, IF(ports.telephone=3, sub.telephone3,NULL))) adslvdsl_ibsu,
                    IF(oss.telephone=1, sub.telephone1, IF(oss.telephone=2, sub.telephone2, IF(oss.telephone=3, sub.telephone3, false))) bitasiatech_ibsu,
                    IF(ser.type='wireless',111,null) wireless_ibsu,
                    lte.tdlte_number tdlte_ibsu,
                    CASE WHEN ser.type = 'voip' THEN IF(f.emkanat_id=1,sub.telephone1,IF(f.emkanat_id=2,sub.telephone2, IF(f.emkanat_id=3,sub.telephone3,NULL)))
                    ELSE NULL
                    END AS voip_ibsu
                FROM
                    bnm_factor f
                    INNER JOIN bnm_subscribers sub ON f.subscriber_id = sub.id
                    INNER JOIN bnm_services ser ON ser.id = f.service_id 
                    LEFT JOIN bnm_port ports ON f.emkanat_id = ports.id AND ser.type IN ('adsl','vdsl') AND ports.user_id = sub.id
                    LEFT JOIN bnm_oss_subscribers oss ON oss.user_id=f.subscriber_id AND ser.type IN ('bitstream')
                    LEFT JOIN bnm_sub_station ss ON ss.id = f.emkanat_id AND ss.sub_id= f.subscriber_id AND ser.type IN ('wireless')
                    LEFT JOIN bnm_tdlte_sim lte ON lte.id = f.emkanat_id AND lte.subscriber_id = f.subscriber_id AND ser.type IN ('tdlte')
                WHERE
                    f.type = ?
                    AND f.subscriber_id = ? ";
        switch ($_SESSION['user_type']) {
            case __ADMINUSERTYPE__:
            case __ADMINOPERATORUSERTYPE__:
                $sql .= " AND (f.emkanat_id IS NOT NULL OR f.emkanat_id <> '')
                    AND (f.type IS NOT NULL OR f.type <> '')
                    AND (f.subscriber_id IS NOT NULL OR f.subscriber_id <> '')
                    AND f.tasvie_shode = 1
                        GROUP BY f.subscriber_id, f.type, f.emkanat_id) tmp
                        )tmp2
                    WHERE ibsusername <> '' AND ibsusername IS NOT NULL";
                $res = Db::secure_fetchall($sql, [$sertype, $subid]);
                break;
            case __MODIRUSERTYPE__:
            case __MODIR2USERTYPE__:
            case __OPERATORUSERTYPE__:
            case __OPERATOR2USERTYPE__:
                $sql .= " AND (f.emkanat_id IS NOT NULL OR f.emkanat_id <> '')
                    AND (f.type IS NOT NULL OR f.type <> '')
                    AND (f.subscriber_id IS NOT NULL OR f.subscriber_id <> '')
                    AND f.tasvie_shode = 1
                    AND sub.branch_id = ?
                        GROUP BY f.subscriber_id,f.type,f.emkanat_id) tmp
                        )tmp2
                    WHERE ibsusername <> '' AND ibsusername IS NOT NULL";
                $res = Db::secure_fetchall($sql, [$sertype, $subid, $_SESSION['branch_id']]);
                break;
            case __MOSHTARAKUSERTYPE__:
                $sql .= " AND (f.emkanat_id IS NOT NULL OR f.emkanat_id <> '')
                    AND (f.type IS NOT NULL OR f.type <> '')
                    AND (f.subscriber_id IS NOT NULL OR f.subscriber_id <> '')
                    AND f.tasvie_shode = 1
                    AND f.subscriber_id = ?
                    GROUP BY f.subscriber_id,f.type,f.emkanat_id) tmp )tmp2
                    WHERE ibsusername <> '' AND ibsusername IS NOT NULL";
                $res = Db::secure_fetchall($sql, [$sertype, $_SESSION['user_id'], $_SESSION['user_id']]);
                break;
            default:
                return false;
                break;
        }
        if (!$res) {
            return false;
        }
        return $res;
    }

    public static function getInternetUsersServicesInfo()
    {
        switch ($_SESSION['user_type']) {
            case __ADMINUSERTYPE__:
            case __ADMINOPERATORUSERTYPE__:
                $sql = "SELECT * FROM (
                    SELECT fid,emkanat_id,fsertype,sertype,telephone1,code_meli,noe_moshtarak,shenase_meli,ssid,reallegal_name,
                    subid,telephone_hamrah,branch_id,name_sherkat,general_sertype,
                    CASE 
                        WHEN adslvdsl_ibsu THEN adslvdsl_ibsu
                        WHEN bitasiatech_ibsu THEN bitasiatech_ibsu
                        WHEN wireless_ibsu THEN IF(noe_moshtarak='real', CONCAT('w-', ssid, '-', code_meli),CONCAT('w-', ssid, '-', shenase_meli))
                        WHEN tdlte_ibsu THEN tdlte_ibsu
                        WHEN voip_ibsu THEN voip_ibsu
                        ELSE Null
                        END AS ibsusername
                    FROM
                        (SELECT
                            sub.telephone1,
                            sub.id subid,
                            sub.branch_id,
                            sub.telephone_hamrah,
                            sub.code_meli,
                            sub.noe_moshtarak,
                            sub.shenase_meli,
                            IF(sub.noe_moshtarak='real',CONCAT(sub.name,' ',sub.f_name),sub.name_sherkat) reallegal_name,
                            sub.name name,
                            sub.f_name,
                            sub.name_sherkat,
                            f.id fid,
                            f.emkanat_id,
                            f.type fsertype,
                            ss.id ssid,
                            ser.type sertype,
                            IF(ports.telephone=1, sub.telephone1,IF(ports.telephone=2, sub.telephone2, IF(ports.telephone=3, sub.telephone3,NULL))) adslvdsl_ibsu,
                            IF(oss.telephone=1, sub.telephone1, IF(oss.telephone=2, sub.telephone2, IF(oss.telephone=3, sub.telephone3, false))) bitasiatech_ibsu,
                            IF(ser.noe_khadamat='BITSTREAM_ADSL','adsl',IF(ser.noe_khadamat='BITSTREAM_VDSL','vdsl',ser.type)) general_sertype,
                            IF(ser.type='wireless',111,null) wireless_ibsu,
                            lte.tdlte_number tdlte_ibsu,
                            CASE WHEN ser.type = 'voip' THEN IF(f.emkanat_id=1,sub.telephone1,IF(f.emkanat_id=2,sub.telephone2, IF(f.emkanat_id=3,sub.telephone3,NULL)))
                            ELSE NULL
                            END AS voip_ibsu
                        FROM
                            bnm_factor f
                            INNER JOIN bnm_subscribers sub ON f.subscriber_id = sub.id
                            INNER JOIN bnm_services ser ON ser.id = f.service_id 
                            LEFT JOIN bnm_port ports ON f.emkanat_id = ports.id AND ser.type IN ('adsl','vdsl') AND ports.user_id = sub.id
                            LEFT JOIN bnm_oss_subscribers oss ON oss.user_id=f.subscriber_id AND ser.type IN ('bitstream')
                            LEFT JOIN bnm_sub_station ss ON ss.id = f.emkanat_id AND ss.sub_id= f.subscriber_id AND ser.type IN ('wireless')
                            LEFT JOIN bnm_tdlte_sim lte ON lte.id = f.emkanat_id AND lte.subscriber_id = f.subscriber_id AND ser.type IN ('tdlte')
                        WHERE
                            f.type IN ( 'bitstream', 'adsl', 'vdsl', 'wireless', 'tdlte' ) 
                            AND (f.emkanat_id IS NOT NULL OR f.emkanat_id <> '')
                            AND (f.type IS NOT NULL OR f.type <> '')
                            AND (f.subscriber_id IS NOT NULL OR f.subscriber_id <> '')
                            AND f.tasvie_shode = 1
                        GROUP BY
                            f.subscriber_id,
                            f.type,
                            f.emkanat_id) tmp
                            )tmp2
                        WHERE ibsusername <> '' AND ibsusername IS NOT NULL";
                $res = Db::fetchall_Query($sql);
                break;
            case __MODIRUSERTYPE__:
            case __MODIR2USERTYPE__:
            case __OPERATORUSERTYPE__:
            case __OPERATOR2USERTYPE__:
                $sql = "SELECT * FROM (
                    SELECT fid,emkanat_id,fsertype,sertype,telephone1,code_meli,noe_moshtarak,shenase_meli,ssid,reallegal_name,
                    subid,telephone_hamrah,branch_id,
                    CASE 
                        WHEN adslvdsl_ibsu THEN adslvdsl_ibsu
                        WHEN bitasiatech_ibsu THEN bitasiatech_ibsu
                        WHEN wireless_ibsu THEN IF(noe_moshtarak='real', CONCAT('w-', ssid, '-', code_meli),CONCAT('w-', ssid, '-', shenase_meli))
                        WHEN tdlte_ibsu THEN tdlte_ibsu
                        WHEN voip_ibsu THEN voip_ibsu
                        ELSE Null
                        END AS ibsusername
                    FROM
                        (SELECT
                            sub.telephone1,
                            sub.id subid,
                            sub.branch_id,
                            sub.telephone_hamrah,
                            sub.code_meli,
                            sub.noe_moshtarak,
                            sub.shenase_meli,
                            IF(sub.noe_moshtarak='real',CONCAT(sub.name,' ',sub.f_name),sub.name_sherkat) reallegal_name,
                            sub.name name,
                            sub.f_name,
                            sub.name_sherkat,
                            f.id fid,
                            f.emkanat_id,
                            f.type fsertype,
                            ss.id ssid,
                            ser.type sertype,
                            IF(ports.telephone=1, sub.telephone1,IF(ports.telephone=2, sub.telephone2, IF(ports.telephone=3, sub.telephone3,NULL))) adslvdsl_ibsu,
                            IF(oss.telephone=1, sub.telephone1, IF(oss.telephone=2, sub.telephone2, IF(oss.telephone=3, sub.telephone3, false))) bitasiatech_ibsu,
                            IF(ser.noe_khadamat='BITSTREAM_ADSL','adsl',IF(ser.noe_khadamat='BITSTREAM_VDSL','vdsl',ser.type)) general_sertype,
                            IF(ser.type='wireless',111,null) wireless_ibsu,
                            lte.tdlte_number tdlte_ibsu,
                            CASE WHEN ser.type = 'voip' THEN IF(f.emkanat_id=1,sub.telephone1,IF(f.emkanat_id=2,sub.telephone2, IF(f.emkanat_id=3,sub.telephone3,NULL)))
                            ELSE NULL
                            END AS voip_ibsu
                        FROM
                            bnm_factor f
                            INNER JOIN bnm_subscribers sub ON f.subscriber_id = sub.id
                            INNER JOIN bnm_services ser ON ser.id = f.service_id 
                            LEFT JOIN bnm_port ports ON f.emkanat_id = ports.id AND ser.type IN ('adsl','vdsl') AND ports.user_id = sub.id
                            LEFT JOIN bnm_oss_subscribers oss ON oss.user_id=f.subscriber_id AND ser.type IN ('bitstream')
                            LEFT JOIN bnm_sub_station ss ON ss.id = f.emkanat_id AND ss.sub_id= f.subscriber_id AND ser.type IN ('wireless')
                            LEFT JOIN bnm_tdlte_sim lte ON lte.id = f.emkanat_id AND lte.subscriber_id = f.subscriber_id AND ser.type IN ('tdlte')
                        WHERE
                            f.type IN ( 'bitstream', 'adsl', 'vdsl', 'wireless', 'tdlte' ) 
                            AND (f.emkanat_id IS NOT NULL OR f.emkanat_id <> '')
                            AND (f.type IS NOT NULL OR f.type <> '')
                            AND (f.subscriber_id IS NOT NULL OR f.subscriber_id <> '')
                            AND f.tasvie_shode = 1 ";
                $sql .= "
                            AND sub.branch_id = ?
                        GROUP BY
                            f.subscriber_id,
                            f.type,
                            f.emkanat_id) tmp
                            )tmp2
                        WHERE ibsusername <> '' AND ibsusername IS NOT NULL";
                $res = Db::secure_fetchall($sql, [$_SESSION['branch_id']]);
                break;
            case __MOSHTARAKUSERTYPE__:
                $sql = "SELECT * FROM (
                    SELECT fid,emkanat_id,fsertype,sertype,telephone1,code_meli,noe_moshtarak,shenase_meli,ssid,reallegal_name,
                    subid,telephone_hamrah,branch_id,
                    CASE 
                        WHEN adslvdsl_ibsu THEN adslvdsl_ibsu
                        WHEN bitasiatech_ibsu THEN bitasiatech_ibsu
                        WHEN wireless_ibsu THEN IF(noe_moshtarak='real', CONCAT('w-', ssid, '-', code_meli),CONCAT('w-', ssid, '-', shenase_meli))
                        WHEN tdlte_ibsu THEN tdlte_ibsu
                        WHEN voip_ibsu THEN voip_ibsu
                        ELSE Null
                        END AS ibsusername
                    FROM
                        (SELECT
                            sub.telephone1,
                            sub.id subid,
                            sub.branch_id,
                            sub.telephone_hamrah,
                            sub.code_meli,
                            sub.noe_moshtarak,
                            sub.shenase_meli,
                            IF(sub.noe_moshtarak='real',CONCAT(sub.name,' ',sub.f_name),sub.name_sherkat) reallegal_name,
                            sub.name name,
                            sub.f_name,
                            sub.name_sherkat,
                            f.id fid,
                            f.emkanat_id,
                            f.type fsertype,
                            ss.id ssid,
                            ser.type sertype,
                            IF(ports.telephone=1, sub.telephone1,IF(ports.telephone=2, sub.telephone2, IF(ports.telephone=3, sub.telephone3,NULL))) adslvdsl_ibsu,
                            IF(oss.telephone=1, sub.telephone1, IF(oss.telephone=2, sub.telephone2, IF(oss.telephone=3, sub.telephone3, false))) bitasiatech_ibsu,
                            IF(ser.noe_khadamat='BITSTREAM_ADSL','adsl',IF(ser.noe_khadamat='BITSTREAM_VDSL','vdsl',ser.type)) general_sertype,
                            IF(ser.type='wireless',111,null) wireless_ibsu,
                            lte.tdlte_number tdlte_ibsu,
                            CASE WHEN ser.type = 'voip' THEN IF(f.emkanat_id=1,sub.telephone1,IF(f.emkanat_id=2,sub.telephone2, IF(f.emkanat_id=3,sub.telephone3,NULL)))
                            ELSE NULL
                            END AS voip_ibsu
                        FROM
                            bnm_factor f
                            INNER JOIN bnm_subscribers sub ON f.subscriber_id = sub.id
                            INNER JOIN bnm_services ser ON ser.id = f.service_id 
                            LEFT JOIN bnm_port ports ON f.emkanat_id = ports.id AND ser.type IN ('adsl','vdsl') AND ports.user_id = sub.id
                            LEFT JOIN bnm_oss_subscribers oss ON oss.user_id=f.subscriber_id AND ser.type IN ('bitstream')
                            LEFT JOIN bnm_sub_station ss ON ss.id = f.emkanat_id AND ss.sub_id= f.subscriber_id AND ser.type IN ('wireless')
                            LEFT JOIN bnm_tdlte_sim lte ON lte.id = f.emkanat_id AND lte.subscriber_id = f.subscriber_id AND ser.type IN ('tdlte')
                        WHERE
                            f.type IN ( 'bitstream', 'adsl', 'vdsl', 'wireless', 'tdlte' ) 
                            AND (f.emkanat_id IS NOT NULL OR f.emkanat_id <> '')
                            AND (f.type IS NOT NULL OR f.type <> '')
                            AND (f.subscriber_id IS NOT NULL OR f.subscriber_id <> '')
                            AND f.tasvie_shode = 1 ";
                $sql .= "
                            AND sub.branch_id = ?
                            AND sub.id = ?
                            AND f.subscriber_id = ?
                        GROUP BY
                            f.subscriber_id,
                            f.type,
                            f.emkanat_id) tmp
                            )tmp2
                        WHERE ibsusername <> '' AND ibsusername IS NOT NULL";
                $res = Db::secure_fetchall($sql, [$_SESSION['branch_id'], $_SESSION['user_id'], $_SESSION['user_id']]);
                break;
            default:
                return false;
                break;
        }

        if (!$res) {
            return false;
        }
        return $res;
    }
    public static function getInternetServicesInfoWithIbsusernameNoAuth($username)
    {
        $sql = "SELECT * FROM (
            SELECT fid,emkanat_id,fsertype,sertype,telephone1,code_meli,noe_moshtarak,shenase_meli,ssid,reallegal_name,
            subid,telephone_hamrah,branch_id,name_sherkat,general_sertype,siam_tarikhe_tasvie_shode,
            CASE 
                WHEN adslvdsl_ibsu THEN adslvdsl_ibsu
                WHEN bitasiatech_ibsu THEN bitasiatech_ibsu
                WHEN wireless_ibsu THEN IF(noe_moshtarak='real', CONCAT('w-', ssid, '-', code_meli),CONCAT('w-', ssid, '-', shenase_meli))
                WHEN tdlte_ibsu THEN tdlte_ibsu
                WHEN voip_ibsu THEN voip_ibsu
                ELSE Null
                END AS ibsusername
            FROM
                (SELECT
                    sub.telephone1,
                    sub.id subid,
                    sub.branch_id,
                    sub.telephone_hamrah,
                    sub.code_meli,
                    sub.noe_moshtarak,
                    sub.shenase_meli,
                    IF(sub.noe_moshtarak='real',CONCAT(sub.name,' ',sub.f_name),sub.name_sherkat) reallegal_name,
                    sub.name name,
                    sub.f_name,
                    sub.name_sherkat,
                    f.id fid,
                    f.emkanat_id,
                    f.type fsertype,
                    ss.id ssid,
                    ser.type sertype,
                    DATE_FORMAT(f.tarikhe_tasvie_shode,'%Y-%m-%d %H:%i') siam_tarikhe_tasvie_shode,
                    IF(ports.telephone=1, sub.telephone1,IF(ports.telephone=2, sub.telephone2, IF(ports.telephone=3, sub.telephone3,NULL))) adslvdsl_ibsu,
                    IF(oss.telephone=1, sub.telephone1, IF(oss.telephone=2, sub.telephone2, IF(oss.telephone=3, sub.telephone3, false))) bitasiatech_ibsu,
                    IF(ser.noe_khadamat='BITSTREAM_ADSL','adsl',IF(ser.noe_khadamat='BITSTREAM_VDSL','vdsl',ser.type)) general_sertype,
                    IF(ser.type='wireless',111,null) wireless_ibsu,
                    lte.tdlte_number tdlte_ibsu,
                    CASE WHEN ser.type = 'voip' THEN IF(f.emkanat_id=1,sub.telephone1,IF(f.emkanat_id=2,sub.telephone2, IF(f.emkanat_id=3,sub.telephone3,NULL)))
                    ELSE NULL
                    END AS voip_ibsu
                FROM
                    bnm_factor f
                    INNER JOIN bnm_subscribers sub ON f.subscriber_id = sub.id
                    INNER JOIN bnm_services ser ON ser.id = f.service_id 
                    LEFT JOIN bnm_port ports ON f.emkanat_id = ports.id AND ser.type IN ('adsl','vdsl') AND ports.user_id = sub.id
                    LEFT JOIN bnm_oss_subscribers oss ON oss.user_id=f.subscriber_id AND ser.type IN ('bitstream')
                    LEFT JOIN bnm_sub_station ss ON ss.id = f.emkanat_id AND ss.sub_id= f.subscriber_id AND ser.type IN ('wireless')
                    LEFT JOIN bnm_tdlte_sim lte ON lte.id = f.emkanat_id AND lte.subscriber_id = f.subscriber_id AND ser.type IN ('tdlte')
                WHERE
                    f.type IN ( 'bitstream', 'adsl', 'vdsl', 'wireless', 'tdlte' ) 
                    AND (f.emkanat_id IS NOT NULL OR f.emkanat_id <> '')
                    AND (f.type IS NOT NULL OR f.type <> '')
                    AND (f.subscriber_id IS NOT NULL OR f.subscriber_id <> '')
                    AND f.tasvie_shode = 1
                GROUP BY
                    f.subscriber_id,
                    f.type,
                    f.emkanat_id) tmp
                    )tmp2
                WHERE ibsusername <> '' AND ibsusername IS NOT NULL AND ibsusername like '%$username'";
        $res = Db::fetchall_Query($sql);
        if (!isset($res)) return false;
        if (!$res) return false;
        return $res;
    }
    public static function getInternetUsersServicesInfoWithoutLogincheck()
    {
        $sql = "SELECT * FROM (
            SELECT fid,emkanat_id,fsertype,sertype,telephone1,code_meli,noe_moshtarak,shenase_meli,ssid,reallegal_name,
            subid,telephone_hamrah,branch_id,name_sherkat,general_sertype,
            CASE 
                WHEN adslvdsl_ibsu THEN adslvdsl_ibsu
                WHEN bitasiatech_ibsu THEN bitasiatech_ibsu
                WHEN wireless_ibsu THEN IF(noe_moshtarak='real', CONCAT('w-', ssid, '-', code_meli),CONCAT('w-', ssid, '-', shenase_meli))
                WHEN tdlte_ibsu THEN tdlte_ibsu
                WHEN voip_ibsu THEN voip_ibsu
                ELSE Null
                END AS ibsusername
            FROM
                (SELECT
                    sub.telephone1,
                    sub.id subid,
                    sub.branch_id,
                    sub.telephone_hamrah,
                    sub.code_meli,
                    sub.noe_moshtarak,
                    sub.shenase_meli,
                    IF(sub.noe_moshtarak='real',CONCAT(sub.name,' ',sub.f_name),sub.name_sherkat) reallegal_name,
                    sub.name name,
                    sub.f_name,
                    sub.name_sherkat,
                    f.id fid,
                    f.emkanat_id,
                    f.type fsertype,
                    ss.id ssid,
                    ser.type sertype,
                    IF(ports.telephone=1, sub.telephone1,IF(ports.telephone=2, sub.telephone2, IF(ports.telephone=3, sub.telephone3,NULL))) adslvdsl_ibsu,
                    IF(oss.telephone=1, sub.telephone1, IF(oss.telephone=2, sub.telephone2, IF(oss.telephone=3, sub.telephone3, false))) bitasiatech_ibsu,
                    IF(ser.noe_khadamat='BITSTREAM_ADSL','adsl',IF(ser.noe_khadamat='BITSTREAM_VDSL','vdsl',ser.type)) general_sertype,
                    IF(ser.type='wireless',111,null) wireless_ibsu,
                    lte.tdlte_number tdlte_ibsu,
                    CASE WHEN ser.type = 'voip' THEN IF(f.emkanat_id=1,sub.telephone1,IF(f.emkanat_id=2,sub.telephone2, IF(f.emkanat_id=3,sub.telephone3,NULL)))
                    ELSE NULL
                    END AS voip_ibsu
                FROM
                    bnm_factor f
                    INNER JOIN bnm_subscribers sub ON f.subscriber_id = sub.id
                    INNER JOIN bnm_services ser ON ser.id = f.service_id 
                    LEFT JOIN bnm_port ports ON f.emkanat_id = ports.id AND ser.type IN ('adsl','vdsl') AND ports.user_id = sub.id
                    LEFT JOIN bnm_oss_subscribers oss ON oss.user_id=f.subscriber_id AND ser.type IN ('bitstream')
                    LEFT JOIN bnm_sub_station ss ON ss.id = f.emkanat_id AND ss.sub_id= f.subscriber_id AND ser.type IN ('wireless')
                    LEFT JOIN bnm_tdlte_sim lte ON lte.id = f.emkanat_id AND lte.subscriber_id = f.subscriber_id AND ser.type IN ('tdlte')
                WHERE
                    f.type IN ( 'bitstream', 'adsl', 'vdsl', 'wireless', 'tdlte' ) 
                    AND (f.emkanat_id IS NOT NULL OR f.emkanat_id <> '')
                    AND (f.type IS NOT NULL OR f.type <> '')
                    AND (f.subscriber_id IS NOT NULL OR f.subscriber_id <> '')
                    AND f.tasvie_shode = 1
                GROUP BY
                    f.subscriber_id,
                    f.type,
                    f.emkanat_id) tmp
                    )tmp2
                WHERE ibsusername <> '' AND ibsusername IS NOT NULL";
        $res = Db::fetchall_Query($sql);
        if (!$res) return false;
        return $res;
    }
    public static function getInternetUsersServicesInfoWithoutLogincheckAndDynamicSelect($in)
    {
        $sql = "SELECT * FROM (
            SELECT fid,emkanat_id,fsertype,sertype,telephone1,code_meli,noe_moshtarak,shenase_meli,ssid,reallegal_name,
            subid,telephone_hamrah,branch_id,name_sherkat,general_sertype,
            CASE 
                WHEN adslvdsl_ibsu THEN adslvdsl_ibsu
                WHEN bitasiatech_ibsu THEN bitasiatech_ibsu
                WHEN wireless_ibsu THEN IF(noe_moshtarak='real', CONCAT('w-', ssid, '-', code_meli),CONCAT('w-', ssid, '-', shenase_meli))
                WHEN tdlte_ibsu THEN tdlte_ibsu
                WHEN voip_ibsu THEN voip_ibsu
                ELSE Null
                END AS ibsusername
            FROM
                (SELECT
                    sub.telephone1,
                    sub.id subid,
                    sub.branch_id,
                    sub.telephone_hamrah,
                    sub.code_meli,
                    sub.noe_moshtarak,
                    sub.shenase_meli,
                    IF(sub.noe_moshtarak='real',CONCAT(sub.name,' ',sub.f_name),sub.name_sherkat) reallegal_name,
                    sub.name name,
                    sub.f_name,
                    sub.name_sherkat,
                    f.id fid,
                    f.emkanat_id,
                    f.type fsertype,
                    ss.id ssid,
                    ser.type sertype,
                    IF(ports.telephone=1, sub.telephone1,IF(ports.telephone=2, sub.telephone2, IF(ports.telephone=3, sub.telephone3,NULL))) adslvdsl_ibsu,
                    IF(oss.telephone=1, sub.telephone1, IF(oss.telephone=2, sub.telephone2, IF(oss.telephone=3, sub.telephone3, false))) bitasiatech_ibsu,
                    IF(ser.noe_khadamat='BITSTREAM_ADSL','adsl',IF(ser.noe_khadamat='BITSTREAM_VDSL','vdsl',ser.type)) general_sertype,
                    IF(ser.type='wireless',111,null) wireless_ibsu,
                    lte.tdlte_number tdlte_ibsu,
                    CASE WHEN ser.type = 'voip' THEN IF(f.emkanat_id=1,sub.telephone1,IF(f.emkanat_id=2,sub.telephone2, IF(f.emkanat_id=3,sub.telephone3,NULL)))
                    ELSE NULL
                    END AS voip_ibsu
                FROM
                    bnm_factor f
                    INNER JOIN bnm_subscribers sub ON f.subscriber_id = sub.id
                    INNER JOIN bnm_services ser ON ser.id = f.service_id 
                    LEFT JOIN bnm_port ports ON f.emkanat_id = ports.id AND ser.type IN ('adsl','vdsl') AND ports.user_id = sub.id
                    LEFT JOIN bnm_oss_subscribers oss ON oss.user_id=f.subscriber_id AND ser.type IN ('bitstream')
                    LEFT JOIN bnm_sub_station ss ON ss.id = f.emkanat_id AND ss.sub_id= f.subscriber_id AND ser.type IN ('wireless')
                    LEFT JOIN bnm_tdlte_sim lte ON lte.id = f.emkanat_id AND lte.subscriber_id = f.subscriber_id AND ser.type IN ('tdlte')
                WHERE
                    f.type IN ( 'bitstream', 'adsl', 'vdsl', 'wireless', 'tdlte' ) 
                    AND (f.emkanat_id IS NOT NULL OR f.emkanat_id <> '')
                    AND (f.type IS NOT NULL OR f.type <> '')
                    AND (f.subscriber_id IS NOT NULL OR f.subscriber_id <> '')
                    AND f.tasvie_shode = 1
                GROUP BY
                    f.subscriber_id,
                    f.type,
                    f.emkanat_id) tmp
                    )tmp2
                WHERE ibsusername <> '' AND ibsusername IS NOT NULL";
        $res = Db::fetchall_Query($sql);
        if (!$res) return false;
        return $res;
    }
    public static function getAllInternetUsersServicesInfoNoAuth()
    {
        $sql = "SELECT * FROM (
            SELECT fid,emkanat_id,fsertype,sertype,telephone1,code_meli,noe_moshtarak,shenase_meli,ssid,reallegal_name,
            subid,telephone_hamrah,branch_id,general_sertype,hadeaxar_sorat_daryaft,siam_tarikhe_tasvie_shode,crm_tarikhe_tasvie_shode,
            CASE 
                WHEN adslvdsl_ibsu THEN adslvdsl_ibsu
                WHEN bitasiatech_ibsu THEN bitasiatech_ibsu
                WHEN wireless_ibsu THEN IF(noe_moshtarak='real', CONCAT('w-', ssid, '-', code_meli),CONCAT('w-', ssid, '-', shenase_meli))
                WHEN tdlte_ibsu THEN tdlte_ibsu
                WHEN voip_ibsu THEN voip_ibsu
                ELSE Null
                END AS ibsusername
            FROM
                (SELECT
                    sub.telephone1,
                    sub.id subid,
                    sub.branch_id,
                    sub.telephone_hamrah,
                    sub.code_meli,
                    sub.noe_moshtarak,
                    sub.shenase_meli,
                    sub.noe_shenase_hoviati,
                    IF(sub.noe_moshtarak='real',CONCAT(sub.name,' ',sub.f_name),sub.name_sherkat) reallegal_name,
                    sub.name name,
                    sub.f_name,
                    sub.name_sherkat,
                    f.id fid,
                    f.emkanat_id,
                    f.type fsertype,
                    DATE_FORMAT(f.tarikhe_tasvie_shode,'%Y-%m-%d %H:%i') siam_tarikhe_tasvie_shode,
                    DATE_FORMAT(f.tarikhe_tasvie_shode,'%Y-%m-%d %H:%i') crm_tarikhe_tasvie_shode,
                    ss.id ssid,
                    ser.type sertype,
                    ser.hadeaxar_sorat_daryaft,
                    IF(ports.telephone=1, sub.telephone1,IF(ports.telephone=2, sub.telephone2, IF(ports.telephone=3, sub.telephone3,NULL))) adslvdsl_ibsu,
                    IF(oss.telephone=1, sub.telephone1, IF(oss.telephone=2, sub.telephone2, IF(oss.telephone=3, sub.telephone3, false))) bitasiatech_ibsu,
                    IF(ser.noe_khadamat='BITSTREAM_ADSL','adsl',IF(ser.noe_khadamat='BITSTREAM_VDSL','vdsl',ser.type)) general_sertype,
                    IF(ser.type='wireless',111,null) wireless_ibsu,
                    lte.tdlte_number tdlte_ibsu,
                    CASE WHEN ser.type = 'voip' THEN IF(f.emkanat_id=1,sub.telephone1,IF(f.emkanat_id=2,sub.telephone2, IF(f.emkanat_id=3,sub.telephone3,NULL)))
                    ELSE NULL
                    END AS voip_ibsu
                FROM
                    bnm_factor f
                    INNER JOIN bnm_subscribers sub ON f.subscriber_id = sub.id
                    INNER JOIN bnm_services ser ON ser.id = f.service_id 
                    LEFT JOIN bnm_port ports ON f.emkanat_id = ports.id AND ser.type IN ('adsl','vdsl') AND ports.user_id = sub.id
                    LEFT JOIN bnm_oss_subscribers oss ON oss.user_id=f.subscriber_id AND ser.type IN ('bitstream')
                    LEFT JOIN bnm_sub_station ss ON ss.id = f.emkanat_id AND ss.sub_id= f.subscriber_id AND ser.type IN ('wireless')
                    LEFT JOIN bnm_tdlte_sim lte ON lte.id = f.emkanat_id AND lte.subscriber_id = f.subscriber_id AND ser.type IN ('tdlte')
                WHERE
                    f.type IN ( 'bitstream', 'adsl', 'vdsl', 'wireless', 'tdlte' ) 
                    AND (f.emkanat_id IS NOT NULL OR f.emkanat_id <> '')
                    AND (f.type IS NOT NULL OR f.type <> '')
                    AND (f.subscriber_id IS NOT NULL OR f.subscriber_id <> '')
                    AND f.tasvie_shode = 1
                GROUP BY
                    f.subscriber_id,
                    f.type,
                    f.emkanat_id) tmp
                    )tmp2
                WHERE ibsusername <> '' AND ibsusername IS NOT NULL";
        $res = Db::fetchall_Query($sql);
        if (!$res) {
            return false;
        }
        return $res;
    }
    public static function getAllUsersServicesInfo()
    {
        switch ($_SESSION['user_type']) {
            case __ADMINUSERTYPE__:
            case __ADMINOPERATORUSERTYPE__:
                $sql = "SELECT * FROM (
                    SELECT fid,emkanat_id,fsertype,sertype,telephone1,code_meli,noe_moshtarak,shenase_meli,ssid,reallegal_name,
                    subid,telephone_hamrah,branch_id,
                    CASE 
                        WHEN adslvdsl_ibsu THEN adslvdsl_ibsu
                        WHEN bitasiatech_ibsu THEN bitasiatech_ibsu
                        WHEN wireless_ibsu THEN IF(noe_moshtarak='real', CONCAT('w-', ssid, '-', code_meli),CONCAT('w-', ssid, '-', shenase_meli))
                        WHEN tdlte_ibsu THEN tdlte_ibsu
                        WHEN voip_ibsu THEN voip_ibsu
                        ELSE Null
                        END AS ibsusername
                    FROM
                        (SELECT
                            sub.telephone1,
                            sub.id subid,
                            sub.branch_id,
                            sub.telephone_hamrah,
                            sub.code_meli,
                            sub.noe_moshtarak,
                            sub.shenase_meli,
                            sub.noe_shenase_hoviati,
                            IF(sub.noe_moshtarak='real',CONCAT(sub.name,' ',sub.f_name),sub.name_sherkat) reallegal_name,
                            sub.name name,
                            sub.f_name,
                            sub.name_sherkat,
                            f.id fid,
                            f.emkanat_id,
                            f.type fsertype,
                            ss.id ssid,
                            ser.type sertype,
                            IF(ports.telephone=1, sub.telephone1,IF(ports.telephone=2, sub.telephone2, IF(ports.telephone=3, sub.telephone3,NULL))) adslvdsl_ibsu,
                            IF(oss.telephone=1, sub.telephone1, IF(oss.telephone=2, sub.telephone2, IF(oss.telephone=3, sub.telephone3, false))) bitasiatech_ibsu,
                            IF(ser.type='wireless',111,null) wireless_ibsu,
                            lte.tdlte_number tdlte_ibsu,
                            CASE WHEN ser.type = 'voip' THEN IF(f.emkanat_id=1,sub.telephone1,IF(f.emkanat_id=2,sub.telephone2, IF(f.emkanat_id=3,sub.telephone3,NULL)))
                            ELSE NULL
                            END AS voip_ibsu
                        FROM
                            bnm_factor f
                            INNER JOIN bnm_subscribers sub ON f.subscriber_id = sub.id
                            INNER JOIN bnm_services ser ON ser.id = f.service_id 
                            LEFT JOIN bnm_port ports ON f.emkanat_id = ports.id AND ser.type IN ('adsl','vdsl') AND ports.user_id = sub.id
                            LEFT JOIN bnm_oss_subscribers oss ON oss.user_id=f.subscriber_id AND ser.type IN ('bitstream')
                            LEFT JOIN bnm_sub_station ss ON ss.id = f.emkanat_id AND ss.sub_id= f.subscriber_id AND ser.type IN ('wireless')
                            LEFT JOIN bnm_tdlte_sim lte ON lte.id = f.emkanat_id AND lte.subscriber_id = f.subscriber_id AND ser.type IN ('tdlte')
                        WHERE
                            f.type IN ( 'bitstream', 'adsl', 'vdsl', 'wireless', 'tdlte', 'voip' ) 
                            AND (f.emkanat_id IS NOT NULL OR f.emkanat_id <> '')
                            AND (f.type IS NOT NULL OR f.type <> '')
                            AND (f.subscriber_id IS NOT NULL OR f.subscriber_id <> '')
                            AND f.tasvie_shode = 1
                        GROUP BY
                            f.subscriber_id,
                            f.type,
                            f.emkanat_id) tmp
                            )tmp2
                        WHERE ibsusername <> '' AND ibsusername IS NOT NULL";
                $res = Db::fetchall_Query($sql);
                break;
            case __MODIRUSERTYPE__:
            case __MODIR2USERTYPE__:
            case __OPERATORUSERTYPE__:
            case __OPERATOR2USERTYPE__:
                $sql = "SELECT * FROM (
                    SELECT fid,emkanat_id,fsertype,sertype,telephone1,code_meli,noe_moshtarak,shenase_meli,ssid,reallegal_name,
                    subid,telephone_hamrah,branch_id,
                    CASE 
                        WHEN adslvdsl_ibsu THEN adslvdsl_ibsu
                        WHEN bitasiatech_ibsu THEN bitasiatech_ibsu
                        WHEN wireless_ibsu THEN IF(noe_moshtarak='real', CONCAT('w-', ssid, '-', code_meli),CONCAT('w-', ssid, '-', shenase_meli))
                        WHEN tdlte_ibsu THEN tdlte_ibsu
                        WHEN voip_ibsu THEN voip_ibsu
                        ELSE Null
                        END AS ibsusername
                    FROM
                        (SELECT
                            sub.telephone1,
                            sub.id subid,
                            sub.branch_id,
                            sub.telephone_hamrah,
                            sub.code_meli,
                            sub.noe_moshtarak,
                            sub.shenase_meli,
                            IF(sub.noe_moshtarak='real',CONCAT(sub.name,' ',sub.f_name),sub.name_sherkat) reallegal_name,
                            sub.name name,
                            sub.f_name,
                            sub.name_sherkat,
                            f.id fid,
                            f.emkanat_id,
                            f.type fsertype,
                            ss.id ssid,
                            ser.type sertype,
                            IF(ports.telephone=1, sub.telephone1,IF(ports.telephone=2, sub.telephone2, IF(ports.telephone=3, sub.telephone3,NULL))) adslvdsl_ibsu,
                            IF(oss.telephone=1, sub.telephone1, IF(oss.telephone=2, sub.telephone2, IF(oss.telephone=3, sub.telephone3, false))) bitasiatech_ibsu,
                            IF(ser.type='wireless',111,null) wireless_ibsu,
                            lte.tdlte_number tdlte_ibsu,
                            CASE WHEN ser.type = 'voip' THEN IF(f.emkanat_id=1,sub.telephone1,IF(f.emkanat_id=2,sub.telephone2, IF(f.emkanat_id=3,sub.telephone3,NULL)))
                            ELSE NULL
                            END AS voip_ibsu
                        FROM
                            bnm_factor f
                            INNER JOIN bnm_subscribers sub ON f.subscriber_id = sub.id
                            INNER JOIN bnm_services ser ON ser.id = f.service_id 
                            LEFT JOIN bnm_port ports ON f.emkanat_id = ports.id AND ser.type IN ('adsl','vdsl') AND ports.user_id = sub.id
                            LEFT JOIN bnm_oss_subscribers oss ON oss.user_id=f.subscriber_id AND ser.type IN ('bitstream')
                            LEFT JOIN bnm_sub_station ss ON ss.id = f.emkanat_id AND ss.sub_id= f.subscriber_id AND ser.type IN ('wireless')
                            LEFT JOIN bnm_tdlte_sim lte ON lte.id = f.emkanat_id AND lte.subscriber_id = f.subscriber_id AND ser.type IN ('tdlte')
                        WHERE
                            f.type IN ( 'bitstream', 'adsl', 'vdsl', 'wireless', 'tdlte', 'voip' ) 
                            AND (f.emkanat_id IS NOT NULL OR f.emkanat_id <> '')
                            AND (f.type IS NOT NULL OR f.type <> '')
                            AND (f.subscriber_id IS NOT NULL OR f.subscriber_id <> '')
                            AND f.tasvie_shode = 1 ";
                $sql .= "
                            AND sub.branch_id = ?
                        GROUP BY
                            f.subscriber_id,
                            f.type,
                            f.emkanat_id) tmp
                            )tmp2
                        WHERE ibsusername <> '' AND ibsusername IS NOT NULL";
                $res = Db::secure_fetchall($sql, [$_SESSION['branch_id']]);
                break;
            case __MOSHTARAKUSERTYPE__:
                $sql = "SELECT * FROM (
                    SELECT fid,emkanat_id,fsertype,sertype,telephone1,code_meli,noe_moshtarak,shenase_meli,ssid,reallegal_name,
                    subid,telephone_hamrah,branch_id,
                    CASE 
                        WHEN adslvdsl_ibsu THEN adslvdsl_ibsu
                        WHEN bitasiatech_ibsu THEN bitasiatech_ibsu
                        WHEN wireless_ibsu THEN IF(noe_moshtarak='real', CONCAT('w-', ssid, '-', code_meli),CONCAT('w-', ssid, '-', shenase_meli))
                        WHEN tdlte_ibsu THEN tdlte_ibsu
                        WHEN voip_ibsu THEN voip_ibsu
                        ELSE Null
                        END AS ibsusername
                    FROM
                        (SELECT
                            sub.telephone1,
                            sub.id subid,
                            sub.branch_id,
                            sub.telephone_hamrah,
                            sub.code_meli,
                            sub.noe_moshtarak,
                            sub.shenase_meli,
                            IF(sub.noe_moshtarak='real',CONCAT(sub.name,' ',sub.f_name),sub.name_sherkat) reallegal_name,
                            sub.name name,
                            sub.f_name,
                            sub.name_sherkat,
                            f.id fid,
                            f.emkanat_id,
                            f.type fsertype,
                            ss.id ssid,
                            ser.type sertype,
                            IF(ports.telephone=1, sub.telephone1,IF(ports.telephone=2, sub.telephone2, IF(ports.telephone=3, sub.telephone3,NULL))) adslvdsl_ibsu,
                            IF(oss.telephone=1, sub.telephone1, IF(oss.telephone=2, sub.telephone2, IF(oss.telephone=3, sub.telephone3, false))) bitasiatech_ibsu,
                            IF(ser.type='wireless',111,null) wireless_ibsu,
                            lte.tdlte_number tdlte_ibsu,
                            CASE WHEN ser.type = 'voip' THEN IF(f.emkanat_id=1,sub.telephone1,IF(f.emkanat_id=2,sub.telephone2, IF(f.emkanat_id=3,sub.telephone3,NULL)))
                            ELSE NULL
                            END AS voip_ibsu
                        FROM
                            bnm_factor f
                            INNER JOIN bnm_subscribers sub ON f.subscriber_id = sub.id
                            INNER JOIN bnm_services ser ON ser.id = f.service_id 
                            LEFT JOIN bnm_port ports ON f.emkanat_id = ports.id AND ser.type IN ('adsl','vdsl') AND ports.user_id = sub.id
                            LEFT JOIN bnm_oss_subscribers oss ON oss.user_id=f.subscriber_id AND ser.type IN ('bitstream')
                            LEFT JOIN bnm_sub_station ss ON ss.id = f.emkanat_id AND ss.sub_id= f.subscriber_id AND ser.type IN ('wireless')
                            LEFT JOIN bnm_tdlte_sim lte ON lte.id = f.emkanat_id AND lte.subscriber_id = f.subscriber_id AND ser.type IN ('tdlte')
                        WHERE
                            f.type IN ( 'bitstream', 'adsl', 'vdsl', 'wireless', 'tdlte', 'voip' ) 
                            AND (f.emkanat_id IS NOT NULL OR f.emkanat_id <> '')
                            AND (f.type IS NOT NULL OR f.type <> '')
                            AND (f.subscriber_id IS NOT NULL OR f.subscriber_id <> '')
                            AND f.tasvie_shode = 1 ";
                $sql .= "
                            AND sub.branch_id = ?
                            AND sub.id = ?
                            AND f.subscriber_id = ?
                        GROUP BY
                            f.subscriber_id,
                            f.type,
                            f.emkanat_id) tmp
                            )tmp2
                        WHERE ibsusername <> '' AND ibsusername IS NOT NULL";
                $res = Db::secure_fetchall($sql, [$_SESSION['branch_id'], $_SESSION['user_id'], $_SESSION['user_id']]);
                break;
            default:
                return false;
                break;
        }

        if (!$res) {
            return false;
        }
        return $res;
    }
    public static function getAllUsersAllServices($servicegroup = "all")
    {
        //gereftane tamame user ha ba tamame service ha shoon
        $res = false;
        if ($servicegroup === "all") {
            $sql = "SELECT
            f.id fid,
                f.emkanat_id,
                f.type fsertype,
                f.subscriber_id ,
                ser.type sertype,
                ser.noe_khadamat,
                sub.id subid
            FROM
                bnm_factor f
            INNER JOIN bnm_subscribers sub ON sub.id = f.subscriber_id
            INNER JOIN bnm_services ser ON ser.id = f.service_id
            WHERE ser.type IN ('bitstream', 'adsl', 'vdsl', 'wireless', 'tdlte', 'voip')
            GROUP BY f.subscriber_id, ser.type,f.emkanat_id";
            $res = Db::fetchall_Query($sql);
        } elseif ($servicegroup === "internet") {
            $sql = "SELECT
                f.id fid,
                f.emkanat_id,
                f.type fsertype,
                f.subscriber_id ,
                ser.type sertype,
                ser.noe_khadamat,
                sub.id subid
                FROM
                    bnm_factor f
                INNER JOIN bnm_subscribers sub ON sub.id = f.subscriber_id
                INNER JOIN bnm_services ser ON ser.id = f.service_id
                WHERE ser.type IN ('bitstream', 'adsl', 'vdsl', 'wireless', 'tdlte')
                GROUP BY f.subscriber_id, ser.type,f.emkanat_id";
            $res = Db::fetchall_Query($sql);
        } elseif ($servicegroup === "voip") {
            $sql = "SELECT
                f.id fid,
                f.emkanat_id,
                f.type fsertype,
                f.subscriber_id ,
                ser.type sertype,
                ser.noe_khadamat,
                sub.id subid
                FROM
                    bnm_factor f
                INNER JOIN bnm_subscribers sub ON sub.id = f.subscriber_id
                INNER JOIN bnm_services ser ON ser.id = f.service_id
                WHERE ser.type IN ('voip')
                GROUP BY f.subscriber_id, ser.type,f.emkanat_id";
            $res = Db::fetchall_Query($sql);
        } else {
            return false;
        }
        if (!$res) return false;
        for ($i = 0; $i < $res; $i++) {
            $ibsusername = self::getIbsUsername($res[0]['subid'], $res[0]['sertype'], $res[0]['emkanat_id']);

            if ($ibsusername) {
                if ($ibsusername[0]['ibsusername']) {
                    $res[$i]['ibsusername'] = $ibsusername[0]['ibsusername'];
                } else {
                    $res[$i]['ibsusername'] = '';
                }
            } else {
                $res[$i]['ibsusername'] = '';
            }
        }
        return $res;
    }
    public static function getAllIbsusername($username = false, $isinternet = true)
    {
        if ($isinternet) {
            //internet
            $sql = "SELECT
                    fa.id fid,
                    fa.subscriber_id subid,
                    fa.emkanat_id,
                    ser.noe_khadamat,
                    ser.type
                FROM
                    bnm_factor fa
                INNER JOIN bnm_services ser ON ser.id = fa.service_id
                INNER JOIN bnm_subscribers sub ON sub.id = fa.subscriber_id
                WHERE ser.type <> ?
                GROUP BY ser.type, fa.emkanat_id, fa.subscriber_id";
            $res = Db::secure_fetchall($sql, ['voip']);
        } else {
            //voip
            $sql = "SELECT
            fa.id fid,
            fa.subscriber_id subid,
            fa.emkanat_id,
            ser.noe_khadamat,
            ser.type
            FROM
                bnm_factor fa
            INNER JOIN bnm_services ser ON ser.id = fa.service_id
            INNER JOIN bnm_subscribers sub ON sub.id = fa.subscriber_id
            GROUP BY ser.type, fa.emkanat_id, fa.subscriber_id";
            $res = Db::fetchall_Query($sql);
        }
        // return $res;
        $rc = count($res);
        if ($username) {
            for ($i = 0; $i < $rc; $i++) {
                $ibsusername = self::getIbsUsername($res[$i]['subid'], $res[$i]['type'], $res[$i]['emkanat_id']);
                if ($ibsusername[0]['ibsusername'] == $username) {
                    if (isset($ibsusername[0]['ibsusername'])) {
                        $res[$i]['ibsusername'] = $ibsusername[0]['ibsusername'];
                    }
                    return $res[$i];
                }
            }
            return false;
        } else {
            return $res;
        }
    }
    public static function getIbsUsernameByFactorid($factorid)
    {
        $sql = "SELECT f.emkanat_id, ser.type sertype, sub.id subid FROM bnm_factor f 
        INNER JOIN bnm_services ser ON ser.id = f.service_id
        INNER JOIN bnm_subscribers sub ON sub.id = f.subscriber_id
        WHERE f.id = ? ";
        $factor = Db::secure_fetchall($sql, [$factorid]);
        if (!$factor) {
            return false;
        }
        $res = self::getIbsUsername($factor[0]['subid'], $factor[0]['sertype'], $factor[0]['emkanat_id']);
        if (!$res) return false;
        return $res;
    }
    public static function getIbsUsername($userid, $servicetype, $emkanatid = false)
    {
        switch ($servicetype) {
            case 'bitstream':
                $sql = "SELECT
                    IF(oss.telephone=1, sub.telephone1, IF(oss.telephone=2, sub.telephone2, IF(oss.telephone=3, sub.telephone3, false))) ibsusername
                    FROM bnm_oss_reserves res
                    INNER JOIN bnm_oss_subscribers oss ON oss.id = res.oss_id
                    INNER JOIN bnm_subscribers sub ON sub.id = oss.user_id
                    WHERE sub.id = ? AND oss.user_id = ? AND res.id = ?";
                $res = Db::secure_fetchall($sql, [$userid, $userid, $emkanatid]);
                break;
            case 'adsl':
            case 'vdsl':
                $sql = "SELECT
                            IF(p.telephone=1, sub.telephone1, IF(p.telephone=2, sub.telephone2, IF(p.telephone=3, sub.telephone3, false))) ibsusername
                        FROM bnm_port p
                            INNER JOIN bnm_subscribers sub ON p.user_id = sub.id
                        WHERE sub.id = ? AND p.id = ?";
                $res = Db::secure_fetchall($sql, [$userid, $emkanatid]);
                break;
            case 'wireless':
                if ($emkanatid) {
                    $sql = "SELECT
                                ss.id,
                                IF(sub.noe_moshtarak='real', CONCAT('w-', ss.id, '-', sub.code_meli),CONCAT('w-', ss.id, '-', sub.shenase_meli))AS ibsusername,
                                ser.type 
                            FROM
                                bnm_factor fa
                                INNER JOIN bnm_services ser ON ser.id = fa.service_id 
                                INNER JOIN bnm_sub_station ss ON ss.id = fa.emkanat_id
                                INNER JOIN bnm_wireless_station station ON station.id = ss.station_id
                                INNER JOIN bnm_subscribers sub ON ss.sub_id = sub.id
                            WHERE
                                fa.emkanat_id = ? 
                                AND ser.type = ?
                                AND fa.subscriber_id = ?
                                ";
                    $res = Db::secure_fetchall($sql, [$emkanatid, $servicetype, $userid]);
                } else {
                    $sql = "SELECT
                            ss.id,
                            'wirelless' type,
                            IF(sub.noe_moshtarak='real', CONCAT('w-', ss.id, '-', sub.code_meli), CONCAT('w-', ss.id, '-', sub.shenase_meli))AS ibsusername
                        FROM
                            bnm_sub_station ss
                            INNER JOIN bnm_subscribers sub ON sub.id = ss.sub_id
                            INNER JOIN bnm_wireless_station station ON station.id = ss.station_id
                        WHERE
                        sub.id = ? AND ss.sub_id = ?";
                    $res = Db::secure_fetchall($sql, [$userid, $userid]);
                }
                break;
            case 'tdlte':
                $sql = "SELECT
                            sim.tdlte_number ibsusername
                        FROM
                            bnm_tdlte_sim sim
                            INNER JOIN bnm_subscribers sub ON sim.subscriber_id = sub.id
                        WHERE
                        sub.id = ?
                        AND sim.id = ?";
                $res = Db::secure_fetchall($sql, [$userid, $emkanatid]);
                break;
            case 'voip':
                if ((int) $emkanatid === 1) {
                    $sql = "SELECT telephone1 ibsusername FROM bnm_subscribers WHERE id = ?";
                } elseif ((int) $emkanatid === 2) {
                    $sql = "SELECT telephone2 ibsusername FROM bnm_subscribers WHERE id = ?";
                } elseif ((int) $emkanatid === 3) {
                    $sql = "SELECT telephone3 ibsusername FROM bnm_subscribers WHERE id = ?";
                } else {
                    return false;
                }
                $res = Db::secure_fetchall($sql, [$userid]);
                break;
            default:
                return false;
                break;
        }
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }

    public static function checkNoeService($noekhadamat)
    {
        switch ($noekhadamat) {
            case "BITSTREAM_ADSL":
                return $noekhadamat;
                break;
            case "BITSTREAM_VDSL":
                return $noekhadamat;
                break;
            case "ADSL(Share)":
            case "ADSL(Transport)":
                return 'adsl';
                break;
            case "VDSL(Share)":
            case "VDSL(Transport)":
                return 'vdsl';
                break;
            case "Wireless(Share)":
            case "Wireless(Transport)":
            case "Wireless(Hotspot)":
                return 'wireless';
                break;
            case "TD-LTE(Share)":
            case "TD-LTE(Transport)":
                return 'tdlte';
                break;
            case "carti":
            case "etebari":
                return 'voip';
                break;
            default:
                return $noekhadamat;
                break;
        }
    }
    public static function _uniord($c)
    {
        if (ord($c[0]) >= 0 && ord($c[0]) <= 127) {
            return ord($c[0]);
        }

        if (ord($c[0]) >= 192 && ord($c[0]) <= 223) {
            return (ord($c[0]) - 192) * 64 + (ord($c[1]) - 128);
        }

        if (ord($c[0]) >= 224 && ord($c[0]) <= 239) {
            return (ord($c[0]) - 224) * 4096 + (ord($c[1]) - 128) * 64 + (ord($c[2]) - 128);
        }

        if (ord($c[0]) >= 240 && ord($c[0]) <= 247) {
            return (ord($c[0]) - 240) * 262144 + (ord($c[1]) - 128) * 4096 + (ord($c[2]) - 128) * 64 + (ord($c[3]) - 128);
        }

        if (ord($c[0]) >= 248 && ord($c[0]) <= 251) {
            return (ord($c[0]) - 248) * 16777216 + (ord($c[1]) - 128) * 262144 + (ord($c[2]) - 128) * 4096 + (ord($c[3]) - 128) * 64 + (ord($c[4]) - 128);
        }

        if (ord($c[0]) >= 252 && ord($c[0]) <= 253) {
            return (ord($c[0]) - 252) * 1073741824 + (ord($c[1]) - 128) * 16777216 + (ord($c[2]) - 128) * 262144 + (ord($c[3]) - 128) * 4096 + (ord($c[4]) - 128) * 64 + (ord($c[5]) - 128);
        }

        if (ord($c[0]) >= 254 && ord($c[0]) <= 255) {
            return false;
        }
        return 0;
    }

    public static function checkOssSubExist($user_id, $telephone)
    {
        $sql = "SELECT COUNT(*) rowsnum FROM bnm_oss_subscribers WHERE user_id = ? AND telephone = ?";
        $res = Db::secure_fetchall($sql, [$_POST['smdoss_moshtarak_id'], $_POST['smdoss_telephone']]);
        if ($res[0]['rowsnum'] > 0) {
            return true;
        } else {
            return false;
        }
    }
    public static function getSubNationality($subid)
    {
        $sql = "
		SELECT
			sub.id,
			sub.noe_moshtarak,
			country.code meliatcode,
            country.name fa_meliat,
		    IF( country.code = 'IRN', 1, 0 ) isirani
		FROM
			bnm_subscribers sub
			INNER JOIN bnm_countries country ON country.id = sub.meliat
		WHERE
			sub.id = ?
		";
        $res = Db::secure_fetchall($sql, [$subid]);
        if (!$res)
            return false;
        return $res;
    }

    public static function subIsIrani($subid)
    {
        $sql = "
            SELECT
                count(*) isirani
            FROM
                bnm_subscribers sub
                INNER JOIN bnm_countries country ON country.id = sub.meliat
            WHERE
			sub.id = ? AND country.code = 'IRN'
		";
        $res = Db::secure_fetchall($sql, [$subid]);
        return $res[0]['isirani'];
    }

    public static function checkNationalityById($code)
    {
        $sql = "
		SELECT
		    IF( code = 'IRN', 1, 0 ) isirani
		FROM bnm_countries country
		WHERE
            id = ?
		";
        $res = Db::secure_fetchall($sql, [$code]);
        if ($res) {
            if ($res[0]['isirani'] === 1) {
                die(json_encode(true));
            } else {
                die(json_encode(false));
            }
        } else {
            die(self::Json_Message('inf'));
        }
    }
    public static function checkNationalityByCode($code)
    {
        $sql = "
		SELECT
		    IF( code = 'IRN', 1, 0 ) isirani
		FROM bnm_countries country
		WHERE
            id = ?
		";
        $res = Db::secure_fetchall($sql, [$code]);
        if ($res) {
            if ($res[0]['isirani'] === 1) {
                return true;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    public static function getSubInfoByTelephone($telephone, $nozero = true)
    {

        if (!$telephone) {
            return false;
        }
        $sql = "SELECT *,1 AS telid FROM bnm_subscribers WHERE telephone1= ?";
        $res = Db::secure_fetchall($sql, [$telephone]);
        if (!$res) {
            $sql = "SELECT *,2 AS telid FROM bnm_subscribers WHERE telephone2= ?";
            $res = Db::secure_fetchall($sql, [$telephone]);
            if (!$res) {
                $sql = "SELECT *,3 AS telid FROM bnm_subscribers WHERE telephone3= ?";
                $res = Db::secure_fetchall($sql, [$telephone]);
                if (!$res) {
                    return false;
                } else {
                    return $res;
                }
            }
        }

        if ($res) {
            return $res;
        } else {
            return false;
        }
    }
    public static function getSubInfoByMobile($mobile)
    {
        if (!$mobile) {
            return false;
        }
        $sql = "SELECT * FROM bnm_subscribers WHERE SUBSTR(telephone_hamrah,2)= ?";
        $res = Db::secure_fetchall($sql, [$mobile]);

        if ($res) {
            return $res;
        } else {
            return false;
        }
    }

    public static function getServiceInfoLastFactorWithSubidEmkanatSertypeNoAuth($subid, $emkanatid, $servicetype)
    {
        $sql = "SELECT * FROM (
            SELECT fid,tarikhe_tasvie_shode,siam_tarikhe_tasvie_shode,emkanat_id,fsertype,sertype,hadeaxar_sorat_daryaft,
            telephone1,code_meli,noe_moshtarak,shenase_meli,ssid,reallegal_name,
            subid,telephone_hamrah,branch_id,general_sertype,name_pedar,shomare_shenasname,name,f_name,jensiat,
            tarikhe_tavalod,code_posti1,tabeiat,passno,address1,noe_malekiat1,fa_noe_malekiat1,address,
            name_sherkat,shomare_sabt,code_eghtesadi,crm_tarikhe_tasvie_shode,
                CASE 
                    WHEN adslvdsl_ibsu THEN adslvdsl_ibsu
                    WHEN bitasiatech_ibsu THEN bitasiatech_ibsu
                    WHEN wireless_ibsu THEN IF(noe_moshtarak='real', CONCAT('w-', ssid, '-', code_meli),CONCAT('w-', ssid, '-', shenase_meli))
                    WHEN tdlte_ibsu THEN tdlte_ibsu
                    WHEN voip_ibsu THEN voip_ibsu
                    ELSE Null
                END AS ibsusername
            FROM
                (SELECT
                    sub.telephone1,
                    sub.id subid,
                    sub.branch_id,
                    sub.telephone_hamrah,
                    sub.code_meli,
                    sub.noe_moshtarak,
                    sub.name_pedar,
                    sub.shomare_shenasname,
                    sub.tarikhe_tavalod,
                    sub.code_posti1,
                    sub.address1,
                    sub.noe_malekiat1,
                    sub.jensiat,
                    IF(sub.noe_malekiat1 = 1,'مالک', 'مستاجر') fa_noe_malekiat1,
                    CONCAT(sub.tel1_street, ' ', sub.tel1_street2, ' پلاک ', sub.tel1_housenumber, ' طبقه ', sub.tel1_tabaghe, ' واحد ',sub.tel1_vahed ) address,
                    sub.tabeiat,
                    sub.name_sherkat,
                    sub.shomare_sabt,
                    sub.code_eghtesadi,
                    IF(sub.noe_shenase_hoviati='1',sub.code_meli, '') passno ,
                    sub.shenase_meli,
                    IF(sub.noe_moshtarak='real',CONCAT(sub.name,' ',sub.f_name),sub.name_sherkat) reallegal_name,
                    sub.name name,
                    sub.f_name,
                    f.id fid,
                    f.emkanat_id,
                    f.type fsertype,
                    f.tarikhe_tasvie_shode,
                    DATE_FORMAT(f.tarikhe_tasvie_shode,'%Y-%m-%d %H:%i') siam_tarikhe_tasvie_shode,
                    DATE_FORMAT(f.tarikhe_tasvie_shode,'%Y-%m-%d %H:%i') crm_tarikhe_tasvie_shode,
                    ss.id ssid,
                    ser.hadeaxar_sorat_daryaft,
                    ser.type sertype,
                    IF(ports.telephone=1, sub.telephone1,IF(ports.telephone=2, sub.telephone2, IF(ports.telephone=3, sub.telephone3,NULL))) adslvdsl_ibsu,
                    IF(oss.telephone=1, sub.telephone1, IF(oss.telephone=2, sub.telephone2, IF(oss.telephone=3, sub.telephone3, false))) bitasiatech_ibsu,
                    IF(ser.noe_khadamat='BITSTREAM_ADSL','adsl',IF(ser.noe_khadamat='BITSTREAM_VDSL','vdsl',ser.type)) general_sertype,
                    IF(ser.type='wireless',111,null) wireless_ibsu,
                    lte.tdlte_number tdlte_ibsu,
                    CASE WHEN ser.type = 'voip' THEN IF(f.emkanat_id=1,sub.telephone1,IF(f.emkanat_id=2,sub.telephone2, IF(f.emkanat_id=3,sub.telephone3,NULL)))
                    ELSE NULL
                    END AS voip_ibsu
                FROM
                    bnm_factor f
                    INNER JOIN bnm_subscribers sub ON f.subscriber_id = sub.id
                    INNER JOIN bnm_services ser ON ser.id = f.service_id 
                    LEFT JOIN bnm_port ports ON f.emkanat_id = ports.id AND ser.type IN ('adsl','vdsl') AND ports.user_id = sub.id
                    LEFT JOIN bnm_oss_subscribers oss ON oss.user_id=f.subscriber_id AND ser.type IN ('bitstream')
                    LEFT JOIN bnm_sub_station ss ON ss.id = f.emkanat_id AND ss.sub_id= f.subscriber_id AND ser.type IN ('wireless')
                    LEFT JOIN bnm_tdlte_sim lte ON lte.id = f.emkanat_id AND lte.subscriber_id = f.subscriber_id AND ser.type IN ('tdlte')
                WHERE
                    f.type IN ( 'bitstream', 'adsl', 'vdsl', 'wireless', 'tdlte' ) 
                    AND (f.emkanat_id IS NOT NULL OR f.emkanat_id <> '')
                    AND (f.type IS NOT NULL OR f.type <> '')
                    AND (f.subscriber_id IS NOT NULL OR f.subscriber_id <> '')
                    AND f.tasvie_shode = 1 
                GROUP BY
                    f.subscriber_id,
                    f.type,
                    f.emkanat_id) tmp
                    )tmp2
                WHERE ibsusername <> '' AND ibsusername IS NOT NULL
                AND subid = ? AND emkanat_id = ? AND sertype= ?";
        $res = Db::secure_fetchall($sql, [$subid, $emkanatid, $servicetype]);
        if (!isset($res)) return false;
        if (!$res) return false;
        return $res;
    }

    public static function getAllServiceInfoLastFactorWithSubidEmkanatSertypeNoAuth($subid, $emkanatid, $servicetype)
    {
        $sql = "SELECT * FROM (
            SELECT fid,tarikhe_tasvie_shode,siam_tarikhe_tasvie_shode,emkanat_id,fsertype,sertype,hadeaxar_sorat_daryaft,
            telephone1,code_meli,noe_moshtarak,shenase_meli,ssid,reallegal_name,
            subid,telephone_hamrah,branch_id,general_sertype,name_pedar,shomare_shenasname,name,f_name,jensiat,
            tarikhe_tavalod,code_posti1,tabeiat,passno,address1,noe_malekiat1,fa_noe_malekiat1,address,
            name_sherkat,shomare_sabt,code_eghtesadi,crm_tarikhe_tasvie_shode,
                CASE 
                    WHEN adslvdsl_ibsu THEN adslvdsl_ibsu
                    WHEN bitasiatech_ibsu THEN bitasiatech_ibsu
                    WHEN wireless_ibsu THEN IF(noe_moshtarak='real', CONCAT('w-', ssid, '-', code_meli),CONCAT('w-', ssid, '-', shenase_meli))
                    WHEN tdlte_ibsu THEN tdlte_ibsu
                    WHEN voip_ibsu THEN voip_ibsu
                    ELSE Null
                END AS ibsusername
            FROM
                (SELECT
                    sub.telephone1,
                    sub.id subid,
                    sub.branch_id,
                    sub.telephone_hamrah,
                    sub.code_meli,
                    sub.noe_moshtarak,
                    sub.name_pedar,
                    sub.shomare_shenasname,
                    sub.tarikhe_tavalod,
                    sub.code_posti1,
                    sub.address1,
                    sub.noe_malekiat1,
                    sub.jensiat,
                    IF(sub.noe_malekiat1 = 1,'مالک', 'مستاجر') fa_noe_malekiat1,
                    CONCAT(sub.tel1_street, ' ', sub.tel1_street2, ' پلاک ', sub.tel1_housenumber, ' طبقه ', sub.tel1_tabaghe, ' واحد ',sub.tel1_vahed ) address,
                    sub.tabeiat,
                    sub.name_sherkat,
                    sub.shomare_sabt,
                    sub.code_eghtesadi,
                    IF(sub.noe_shenase_hoviati='1',sub.code_meli, '') passno ,
                    sub.shenase_meli,
                    IF(sub.noe_moshtarak='real',CONCAT(sub.name,' ',sub.f_name),sub.name_sherkat) reallegal_name,
                    sub.name name,
                    sub.f_name,
                    f.id fid,
                    f.emkanat_id,
                    f.type fsertype,
                    f.tarikhe_tasvie_shode,
                    DATE_FORMAT(f.tarikhe_tasvie_shode,'%Y-%m-%d %H:%i') siam_tarikhe_tasvie_shode,
                    DATE_FORMAT(f.tarikhe_tasvie_shode,'%Y-%m-%d %H:%i') crm_tarikhe_tasvie_shode,
                    ss.id ssid,
                    ser.hadeaxar_sorat_daryaft,
                    ser.type sertype,
                    IF(ports.telephone=1, sub.telephone1,IF(ports.telephone=2, sub.telephone2, IF(ports.telephone=3, sub.telephone3,NULL))) adslvdsl_ibsu,
                    IF(oss.telephone=1, sub.telephone1, IF(oss.telephone=2, sub.telephone2, IF(oss.telephone=3, sub.telephone3, false))) bitasiatech_ibsu,
                    IF(ser.noe_khadamat='BITSTREAM_ADSL','adsl',IF(ser.noe_khadamat='BITSTREAM_VDSL','vdsl',ser.type)) general_sertype,
                    IF(ser.type='wireless',111,null) wireless_ibsu,
                    lte.tdlte_number tdlte_ibsu,
                    CASE WHEN ser.type = 'voip' THEN IF(f.emkanat_id=1,sub.telephone1,IF(f.emkanat_id=2,sub.telephone2, IF(f.emkanat_id=3,sub.telephone3,NULL)))
                    ELSE NULL
                    END AS voip_ibsu
                FROM
                    bnm_factor f
                    INNER JOIN bnm_subscribers sub ON f.subscriber_id = sub.id
                    INNER JOIN bnm_services ser ON ser.id = f.service_id 
                    LEFT JOIN bnm_port ports ON f.emkanat_id = ports.id AND ser.type IN ('adsl','vdsl') AND ports.user_id = sub.id
                    LEFT JOIN bnm_oss_subscribers oss ON oss.user_id=f.subscriber_id AND ser.type IN ('bitstream')
                    LEFT JOIN bnm_sub_station ss ON ss.id = f.emkanat_id AND ss.sub_id= f.subscriber_id AND ser.type IN ('wireless')
                    LEFT JOIN bnm_tdlte_sim lte ON lte.id = f.emkanat_id AND lte.subscriber_id = f.subscriber_id AND ser.type IN ('tdlte')
                WHERE
                    f.type IN ( 'bitstream', 'adsl', 'vdsl', 'wireless', 'tdlte', 'voip' ) 
                    AND (f.emkanat_id IS NOT NULL OR f.emkanat_id <> '')
                    AND (f.type IS NOT NULL OR f.type <> '')
                    AND (f.subscriber_id IS NOT NULL OR f.subscriber_id <> '')
                    AND f.tasvie_shode = 1 
                GROUP BY
                    f.subscriber_id,
                    f.type,
                    f.emkanat_id) tmp
                    )tmp2
                WHERE ibsusername <> '' AND ibsusername IS NOT NULL
                AND subid = ? AND emkanat_id = ? AND sertype= ?";
        $res = Db::secure_fetchall($sql, [$subid, $emkanatid, $servicetype]);
        if (!isset($res)) return false;
        if (!$res) return false;
        return $res;
    }
    public static function getServiceInfoByLastFactorWithSubEmkanatSertype($subid, $emkanatid, $servicetype)
    {
        $sql = "SELECT
            fa.*,
            ser.type sertype, ser.noe_khadamat,ser.terafik,ser.noe_forosh,
            sub.name,sub.f_name,sub.noe_moshtarak,sub.name_sherkat
            FROM bnm_factor fa
                INNER JOIN bnm_services ser ON ser.id = fa.service_id
                INNER JOIN bnm_subscribers sub ON sub.id = fa.subscriber_id 
            WHERE
                ser.noe_forosh IN ( 'adi', 'jashnvare' ) 
                AND fa.subscriber_id = ? 
                AND fa.emkanat_id = ? 
                AND ser.type = ? 
                AND tasvie_shode = ?
            ORDER BY fa.tarikhe_factor DESC LIMIT 1
        ";
        $res = Db::secure_fetchall($sql, [$subid, $emkanatid, $servicetype, 1]);
        if (!isset($res)) return false;
        if (!$res) return false;
        return $res;
    }
    public static function getLastIpassignInfoByServiceinfo($subid, $emkanatid, $sertype)
    {
        $sql = "SELECT
        ass.*,
        ip.ip ipaddress,
        ip.gender,
        IF(ip.gender='1','valid','invalid') en_gender,
        ip.iptype,
        IF(ip.iptype='1','static','dynamic') en_iptype,
        ip.ownership,
        IF(ip.ownership='1','malek',IF(ip.ownership='2','ejare','gheyre')) en_ownership,
        ip.servicetype ipservicetype
    FROM
        bnm_ip_assign ass
        INNER JOIN bnm_ip ip ON ip.id = ass.ip 
    WHERE
        ass.sub = ?
        AND ass.emkanat_id = ?
        AND ass.servicetype = ?
    ORDER BY
        ass.tarikh DESC 
        LIMIT 1";
        $res = Db::secure_fetchall($sql, [$subid, $emkanatid, $sertype]);
        if (!isset($res)) return false;
        if (!$res) return false;
        return $res;
    }
    public static function getServiceInfoByLastFactor($subid, $emkanatid, $sertype)
    {
        $sql = "SELECT
            fa.*,
            sub.noe_moshtarak,
            sub.telephone1,
            sub.NAME name,
            sub.f_name,
            sub.name_sherkat,
            sub.shenase_meli,
            sub.code_meli,
            ser.hadeaxar_sorat_daryaft
        FROM
            bnm_factor fa
            INNER JOIN bnm_subscribers sub ON sub.id = fa.subscriber_id
            INNER JOIN bnm_services ser ON ser.id = fa.service_id 
        WHERE
        fa.subscriber_id = ?
        AND fa.emkanat_id = ?
        AND ser.type = ?
        AND fa.tasvie_shode = 1
        ORDER BY fa.tarikhe_factor DESC LIMIT 1";
        $res = Db::secure_fetchall($sql, [$subid, $emkanatid, $sertype]);
        if (!$res) return false;
        return $res;
    }
    public static function checkIpExist($ip)
    {
        $sql = "SELECT count(*) rowsnum FROM bnm_ip WHERE ip=?";
        $res = Db::secure_fetchall($sql, [$ip]);

        if ($res[0]['rowsnum']) {
            return true;
        } else {
            return false;
        }
    }
    public static function getIpinfoByip($ip)
    {
        if (!$ip) return false;
        $sql = "SELECT
            ass.*,
            ass.id assignid,
            ip.ip ipaddress,
            ip.gender,
            ip.ipstart,
            ip.ipend,
            IF(ip.gender='1','valid','invalid') en_gender,
            ip.iptype,
            IF(ip.iptype='1','static','dynamic') en_iptype,
            ip.ownership,
            IF(ip.ownership='1','malek',IF(ip.ownership='2','ejare','gheyre')) en_ownership,
            ip.servicetype ipservicetype
        FROM
        bnm_ip_assign ass
        INNER JOIN bnm_ip ip ON ip.id = ass.ip
        INNER JOIN bnm_subscribers sub ON sub.id = ass.sub
        WHERE
            ip.ip = ?
        ORDER BY
            ass.tarikh DESC LIMIT 1";
        $res = Db::secure_fetchall($sql, [$ip]);
        if (!isset($res)) return false;
        if (!$res) return false;
        return $res;
    }
    public static function pdodbIpdrInstance()
    {
        //https://github.com/tommyknocker/pdo-database-class
        $db = new PDODb([
            'type' => __IPDRDBTYPE__,
            'host' => __IPDRDBHOST__,
            'username' => __IPDRDBUSERNAME__,
            'password' => __IPDRDBPASS__,
            'dbname' => __IPDRDBDBNAME__,
            'port' => __IPDRDBPORT__,
            'prefix' => __IPDRDBPERFIX__,
            'charset' => __IPDRDBCHARSET__
        ]);
        if (!$db) return false;
        return $db;
    }
    public static function getIpinfoBySubidEmkanatSertypeNoAuth($subid, $emkanatid, $sertype)
    {
        $sql = "SELECT
            ass.*,
            ass.id assignid,
            ip.ip ipaddress,
            ip.gender,
            ip.ipstart,
            ip.ipend,
            IF(ip.gender='1','valid','invalid') en_gender,
            ip.iptype,
            IF(ip.iptype='1','static','dynamic') en_iptype,
            ip.ownership,
            IF(ip.ownership='1','malek',IF(ip.ownership='2','ejare','gheyre')) en_ownership,
            ip.servicetype ipservicetype
        FROM
        bnm_ip_assign ass
        INNER JOIN bnm_ip ip ON ip.id = ass.ip
        INNER JOIN bnm_subscribers sub ON sub.id = ass.sub
        WHERE
            ass.sub = ?
            AND ass.emkanat_id = ?
            AND ass.servicetype = ?
        ORDER BY
            ass.tarikh DESC LIMIT 1";
        $res = Db::secure_fetchall($sql, [$subid, $emkanatid, $sertype]);
        if (!isset($res)) return false;
        if (!$res) return false;
        return $res;
    }
    public static function getNormalPreviousFactor($subid, $emkanatid, $servicetype)
    {
        $sql = "SELECT
            fa.id fid, fa.tasvie_shode, ser.hadeaxar_sorat_daryaft bandwidth
            FROM bnm_factor fa
                INNER JOIN bnm_services ser ON ser.id = fa.service_id
                INNER JOIN bnm_subscribers sub ON sub.id = fa.subscriber_id 
            WHERE
                ser.noe_forosh IN ( 'adi', 'jashnvare' ) 
                AND fa.subscriber_id = ? 
                AND fa.emkanat_id = ? 
                AND ser.type = ? 
                AND fa.tasvie_shode = ?
            ORDER BY fa.tarikhe_factor DESC
        ";
        $res = Db::secure_fetchall($sql, [$subid, $emkanatid, $servicetype, 1]);
        return $res;
    }

    public static function checkNormalPreviousFactorExist($subid, $emkanatid, $servicetype)
    {
        $sql = "SELECT count(*) tedad
        FROM bnm_factor fa
        INNER JOIN bnm_services ser ON ser.id = fa.service_id
        INNER JOIN bnm_subscribers sub ON sub.id = fa.subscriber_id
        WHERE
        fa.subscriber_id = ?
        AND fa.emkanat_id = ?
        AND ser.type = ?
        AND fa.tasvie_shode = ? 
        ORDER BY fa.id DESC";
        $res = Db::secure_fetchall($sql, [$subid, $emkanatid, $servicetype, 1]);
        return $res;
    }
    public static function getShahkarConfig()
    {
        $sql = "SELECT * FROM bnm_shahkar_config WHERE id= ?";
        $res = Db::secure_fetchall($sql, [1]);
        return $res;
    }
    public static function getConnectionlogById($id)
    {
        $sql = "SELECT * FROM bnm_connection_log WHERE id = ?";
        $result = Db::secure_fetchall($sql, array($id));
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
    public static function ibsOnlineuserFilterInitialize($res)
    {
        $arr = [];
        $j = 0;
        for ($i = 0; $i < count($res); $i++) {
            if (isset($res[$i]['attrs']['pppoe_service'])) {
                $arr[] = $res[$i];
            }
        }
        // sort($arr);
        return $arr;
    }
    public static function findIbsUsernameByIp($arr, $ip)
    {
        $res = '';
        for ($i = 0; $i < count($arr); $i++) {
            if (isset($arr[$i]['attrs'])) {
                if (isset($arr[$i]['attrs']['remote_ip'])) {
                    if ($arr[$i]['attrs']['remote_ip'] === $ip) {
                        if (isset($arr[$i]['normal_username'])) {
                            return $arr[$i]['normal_username'];
                        }
                    }
                }
            }
        }
        return false;
    }
    public static function ibsConnectionlogFilterByNoeMasraf($ibs, $noemasraf = "ALL")
    {
        $arr = [];
        if ($noemasraf == "ALL") {
            return $ibs;
        } else {
            for ($i = 0; $i < count($ibs); $i++) {
                if ($ibs[$i]['subservice_name'] === $noemasraf) {
                    $arr[] = $ibs[$i];
                }
            }
            return $arr;
        }
    }

    public static function checkResults($result)
    {
        if (isset($result)) {
            if ($result) {
                return $result;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function checkContractSigned($user_id, $contractidortype, $condition_type = 'id')
    {
        if ($condition_type === "id") {
            $sql = "SELECT subcontract.* FROM bnm_sub_contract subcontract
                    INNER JOIN bnm_services_contract sercontract ON subcontract.contractid = sercontract.id
                    WHERE subcontract.subid = ? AND sercontract.id = ? AND subcontract.status = ?";
            $res = Db::secure_fetchall($sql, [$user_id, $contractidortype, 1]);
        } elseif ($condition_type === "type") {
            $sql = "SELECT subcontract.* FROM bnm_sub_contract subcontract
                    INNER JOIN bnm_services_contract sercontract ON subcontract.contractid = sercontract.id
                    WHERE subcontract.subid = ? AND sercontract.service_type = ? AND subcontract.status = ?";
            $res = Db::secure_fetchall($sql, [$user_id, $contractidortype, 1]);
            return self::checkResults($res);
        }
        return self::checkResults($res);
    }

    public static function ip_range($start, $end)
    {
        $start = ip2long($start);
        $end = ip2long($end);
        return array_map('long2ip', range($start, $end));
    }

    public static function getBitstreamSubscribers()
    {
        switch ($_SESSION['user_type']) {
            case __ADMINUSERTYPE__:
            case __ADMINOPERATORUSERTYPE__:
                $sql = "SELECT sub.id subid, sub.name, sub.f_name, oss.id id, oss.telephone telid,
                if(oss.telephone=1,sub.telephone1,if(oss.telephone=2,sub.telephone2,if(oss.telephone=3,sub.telephone3,false))) telephone
                FROM bnm_subscribers sub
                INNER JOIN bnm_oss_subscribers oss ON sub.id = oss.user_id";
                $res = Db::fetchall_Query($sql);
                break;
            case __MODIRUSERTYPE__:
            case __MODIR2USERTYPE__:
            case __OPERATORUSERTYPE__:
            case __OPERATOR2USERTYPE__:
                $sql = "SELECT sub.id subid, sub.name, sub.f_name, oss.id id, oss.telephone telid,
                if(oss.telephone=1,sub.telephone1,if(oss.telephone=2,sub.telephone2,if(oss.telephone=3,sub.telephone3,false))) telephone
                FROM bnm_subscribers sub
                INNER JOIN bnm_oss_subscribers oss ON sub.id = oss.user_id
                WHERE sub.branch_id = ?";
                $res = Db::secure_fetchall($sql, [$_SESSION['branch_id']]);
                break;
        }
        return $res;
    }

    public static function getBitstreamSubscribersBySubId($subid)
    {
        $sql = "SELECT sub.id subid, sub.name, sub.f_name, oss.id emkanatid, oss.telephone telid,
            if(oss.telephone=1,sub.telephone1,if(oss.telephone=2,sub.telephone2,if(oss.telephone=3,sub.telephone3,false))) telephonenumber
            FROM bnm_subscribers sub
            INNER JOIN bnm_oss_subscribers oss ON sub.id = oss.user_id
            WHERE sub.id = ?";
        $res = Db::secure_fetchall($sql, [$subid]);
        return $res;
    }

    public static function getBitstreamEmkanatBySubId($subid)
    {
        $sql = "SELECT
        oss.id ossid,
        oss.telephone telid,
        sub.id subid,
        sub.telephone1,
        sub.telephone2,
        sub.telephone3,
        if(oss.telephone=1,sub.telephone1,if(oss.telephone=2,sub.telephone2,if(oss.telephone=3,sub.telephone3,null))) telephonenumber,
        res.id resid,
        res.errcode,
        res.reservestatus,
        res.tarikh
    FROM
        bnm_subscribers sub
        INNER JOIN bnm_oss_subscribers oss ON oss.user_id = sub.id
        INNER JOIN bnm_oss_reserves res ON res.oss_id = oss.id
    WHERE
        sub.id = ?
        AND res.errcode = ?";
        $res = Db::secure_fetchall($sql, [$subid, 0]);
        for ($i = 0; $i < count($res); $i++) {
            $shamsi = self::tabdileTarikh($res[$i]['tarikh']);
            $res[$i]['tarikheshamsi'] = $shamsi;
        }
        return $res;
    }

    public static function getPortBySubAndTel($subid, $telid)
    {
        $sql = "SELECT * FROM bnm_port WHERE user_id = ? AND telephone = ?";
        $res = Db::secure_fetchall($sql, [$subid, $telid]);
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }

    public static function getAdslVdslEmkanatBySubId($subid)
    {
        $sql = "SELECT p.id portid, p.telephone telid, sub.id subid, p.adsl_vdsl ,
            if(p.telephone=1,sub.telephone1,if(p.telephone=2,sub.telephone2,if(p.telephone=3,sub.telephone3,null))) telephonenumber
            FROM
                bnm_subscribers sub
                INNER JOIN bnm_port p ON p.user_id = sub.id
            WHERE
                sub.id = ?";
        $res = Db::secure_fetchall($sql, [$subid]);
        return $res;
    }
    public static function getWirelessEmkanatBySubId($subid)
    {
        $sql = "SELECT
            ss.id emkanatid,
            ss.station_id stationid,
            ss.sub_id subid,
            st.name stationname,
            ap.link_name linkname ,
            sub.name,
            sub.f_name
        FROM
            bnm_subscribers sub
            INNER JOIN bnm_sub_station ss ON sub.id = ss.sub_id
            INNER JOIN bnm_wireless_station st ON st.id = ss.station_id
            INNER JOIN bnm_wireless_ap ap ON ap.id = st.wireless_ap
        WHERE
            sub.id = ? ";
        $res = Db::secure_fetchall($sql, [$subid]);
        return $res;
    }

    public static function getTdlteEmkanatBySubId($subid)
    {
        $sql = "SELECT
            sim.id emkanatid,
            sim.puk1 puk1,
            sim.puk2 puk2,
            sim.tdlte_number,
            sub.id subid,
            sub.name name,
            sub.f_name,
            sub.branch_id subbranch,
            sim.branch_id simbranch
        FROM
        bnm_subscribers sub
            INNER JOIN bnm_tdlte_sim sim ON sim.subscriber_id = sub.id
        WHERE
            sub.id = ?";
        $res = Db::secure_fetchall($sql, [$subid]);
        return $res;
    }

    public static function getVoipEmkanatBySubId($subid)
    {
        switch ($_SESSION['user_type']) {
            case __ADMINUSERTYPE__:
            case __ADMINOPERATORUSERTYPE__:
                $sql = "SELECT
                sub.id subid,
                sub.name,
                sub.f_name,
                IF( sub.telephone1, sub.telephone1, FALSE ) telephone1,
                IF( sub.telephone2, sub.telephone2, FALSE ) telephone2,
                IF( sub.telephone3, sub.telephone3, FALSE ) telephone3
                FROM
                    bnm_subscribers sub
                WHERE
                    sub.id = ?";
                $res = Db::secure_fetchall($sql, [$subid]);
                break;
            case __MODIRUSERTYPE__:
            case __MODIR2USERTYPE__:
            case __OPERATORUSERTYPE__:
            case __OPERATOR2USERTYPE__:
                $sql = "SELECT
                sub.id subid,
                sub.name,
                sub.f_name,
                IF( sub.telephone1, sub.telephone1, FALSE ) telephone1,
                IF( sub.telephone2, sub.telephone2, FALSE ) telephone2,
                IF( sub.telephone3, sub.telephone3, FALSE ) telephone3
                FROM
                    bnm_subscribers sub
                WHERE
                    sub.id = ? AND sub.branch_id = ?";
                $res = Db::secure_fetchall($sql, [$subid, $_SESSION['branch_id']]);
                break;
            case __MOSHTARAKUSERTYPE__:
                $sql = "SELECT
                sub.id subid,
                sub.name,
                sub.f_name,
                IF( sub.telephone1, sub.telephone1, FALSE ) telephone1,
                IF( sub.telephone2, sub.telephone2, FALSE ) telephone2,
                IF( sub.telephone3, sub.telephone3, FALSE ) telephone3
                FROM
                    bnm_subscribers sub
                WHERE
                    sub.id = ?";
                $res = Db::secure_fetchall($sql, [$_SESSION['user_id']]);
                break;
            default:
                return false;
                break;
        }
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }

    public static function bitstreamInfoByUserid($userid, $groupby = true)
    {
        $sub = self::Select_By_Id('bnm_subscribers', $userid);
        $sql = "SELECT
                    fa.id, fa.emkanat_id, ser.type service_type,
                    CASE
                        WHEN osssub.telephone= 1 THEN sub.telephone1
                        WHEN osssub.telephone= 2 THEN sub.telephone2
                        WHEN osssub.telephone= 3 THEN sub.telephone3
                    END AS ibsusername
                FROM bnm_factor fa
                    INNER JOIN bnm_services ser ON ser.id = fa.service_id
                    INNER JOIN bnm_oss_reserves ossres ON ossres.id= fa.emkanat_id
                    INNER JOIN bnm_subscribers sub ON sub.id= fa.subscriber_id
                    INNER JOIN bnm_oss_subscribers osssub ON osssub.id= ossres.oss_id
                WHERE fa.subscriber_id = ? AND ser.type = ? AND fa.tasvie_shode = ?";
        if ($groupby) {
            $sql .= 'GROUP BY fa.emkanat_id,ser.type';
        }
        $res = Db::secure_fetchall($sql, array($sub[0]['id'], 'bitstream', 1));
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }
    public static function adslInfoByUserid(int $userid, $groupby = true)
    {
        switch ($_SESSION['user_type']) {
            case __ADMINUSERTYPE__:
            case __ADMINOPERATORUSERTYPE__:
            case __MODIRUSERTYPE__:
            case __MODIR2USERTYPE__:
            case __OPERATORUSERTYPE__:
                $sub = self::Select_By_Id('bnm_subscribers', $userid);
                $sql = "SELECT
                fa.id, ser.type service_type, fa.emkanat_id, p.id portid,
                CASE
                    WHEN p.telephone= 1 THEN sub.telephone1
                    WHEN p.telephone= 2 THEN sub.telephone2
                    WHEN p.telephone= 3 THEN sub.telephone3
                END AS ibsusername
                FROM bnm_factor fa
                    INNER JOIN bnm_services ser ON ser.id = fa.service_id
                    INNER JOIN bnm_subscribers sub ON sub.id= fa.subscriber_id
                    INNER JOIN bnm_port p ON p.id = fa.emkanat_id
                WHERE fa.subscriber_id = ? AND ser.type = ? AND p.user_id = ? AND fa.tasvie_shode = ?";
                if ($groupby) {
                    $sql .= ' GROUP BY fa.emkanat_id,ser.type';
                }
                $res = Db::secure_fetchall($sql, array($sub[0]['id'], 'adsl', $sub[0]['id'], 1));
                if ($res) {
                    return $res;
                } else {
                    return false;
                }
                break;
            case __MOSHTARAKUSERTYPE__:
                $sub = self::Select_By_Id('bnm_subscribers', $_SESSION['user_id']);
                $sql = "SELECT
                fa.id, ser.type service_type, fa.emkanat_id, p.id portid,
                CASE
                    WHEN p.telephone= 1 THEN sub.telephone1
                    WHEN p.telephone= 2 THEN sub.telephone2
                    WHEN p.telephone= 3 THEN sub.telephone3
                END AS ibsusername
                FROM bnm_factor fa
                    INNER JOIN bnm_services ser ON ser.id = fa.service_id
                    INNER JOIN bnm_subscribers sub ON sub.id= fa.subscriber_id
                    INNER JOIN bnm_port p ON p.id = fa.emkanat_id
                WHERE fa.subscriber_id = ? AND ser.type = ? AND p.user_id = ? AND fa.tasvie_shode = ?";
                if ($groupby) {
                    $sql .= ' GROUP BY fa.emkanat_id,ser.type';
                }
                $res = Db::secure_fetchall($sql, array($sub[0]['id'], 'adsl', $sub[0]['id'], 1));
                if ($res) {
                    return $res;
                } else {
                    return false;
                }
                break;

            default:
                return false;
                break;
        }
    }
    public static function vdslInfoByUserid(int $userid, $groupby = true)
    {
        switch ($_SESSION['user_type']) {
            case __ADMINUSERTYPE__:
            case __ADMINOPERATORUSERTYPE__:
            case __MODIRUSERTYPE__:
            case __MODIR2USERTYPE__:
            case __OPERATORUSERTYPE__:
                $sub = self::Select_By_Id('bnm_subscribers', $userid);
                $sql = "SELECT
                            fa.id, ser.type service_type, fa.emkanat_id, p.id portid,
                            CASE
                                WHEN p.telephone= 1 THEN sub.telephone1
                                WHEN p.telephone= 2 THEN sub.telephone2
                                WHEN p.telephone= 3 THEN sub.telephone3
                            END AS ibsusername
                        FROM bnm_factor fa
                            INNER JOIN bnm_services ser ON ser.id = fa.service_id
                            INNER JOIN bnm_subscribers sub ON sub.id= fa.subscriber_id
                            INNER JOIN bnm_port p ON p.id = fa.emkanat_id
                        WHERE fa.subscriber_id = ? AND ser.type = ? AND p.user_id = ? AND fa.tasvie_shode = ?";
                if ($groupby) {
                    $sql .= ' GROUP BY fa.emkanat_id,ser.type';
                }
                $res = Db::secure_fetchall($sql, array($sub[0]['id'], 'vdsl', $sub[0]['id'], 1));
                if ($res) {
                    return $res;
                } else {
                    return false;
                }
                break;
            case __MOSHTARAKUSERTYPE__:
                $sub = self::Select_By_Id('bnm_subscribers', $_SESSION['user_id']);
                $sql = "SELECT
                            fa.id, ser.type service_type, fa.emkanat_id, p.id portid,
                            CASE
                                WHEN p.telephone= 1 THEN sub.telephone1
                                WHEN p.telephone= 2 THEN sub.telephone2
                                WHEN p.telephone= 3 THEN sub.telephone3
                            END AS ibsusername
                        FROM bnm_factor fa
                            INNER JOIN bnm_services ser ON ser.id = fa.service_id
                            INNER JOIN bnm_subscribers sub ON sub.id= fa.subscriber_id
                            INNER JOIN bnm_port p ON p.id = fa.emkanat_id
                        WHERE fa.subscriber_id = ? AND ser.type = ? AND p.user_id = ? AND fa.tasvie_shode = ?";
                if ($groupby) {
                    $sql .= ' GROUP BY fa.emkanat_id,ser.type';
                }
                $res = Db::secure_fetchall($sql, array($sub[0]['id'], 'vdsl', $sub[0]['id'], 1));
                if ($res) {
                    return $res;
                } else {
                    return false;
                }
                break;
        }
    }
    public static function tdlteInfoByUserid(int $userid, $groupby = true)
    {
        switch ($_SESSION['user_type']) {
            case __ADMINUSERTYPE__:
            case __ADMINOPERATORUSERTYPE__:
            case __MODIRUSERTYPE__:
            case __MODIR2USERTYPE__:
            case __OPERATORUSERTYPE__:
                $sub = self::Select_By_Id('bnm_subscribers', $userid);
                $sql = "SELECT
                    fa.id, ser.type service_type, fa.emkanat_id, td.id tdid, td.puk1, td.puk2, td.tdlte_number ibsusername
                FROM bnm_factor fa
                    INNER JOIN bnm_services ser ON ser.id = fa.service_id
                    INNER JOIN bnm_tdlte_sim td ON td.id = fa.emkanat_id
                WHERE fa.subscriber_id = ? AND ser.type = ? AND fa.tasvie_shode = ?";
                if ($groupby) {
                    $sql .= ' GROUP BY fa.emkanat_id,ser.type';
                }
                $res = Db::secure_fetchall($sql, array($sub[0]['id'], 'tdlte', 1));
                if ($res) {
                    return $res;
                } else {
                    return false;
                }
                break;
            case __MOSHTARAKUSERTYPE__:
                $sub = self::Select_By_Id('bnm_subscribers', $_SESSION['user_id']);
                $sql = "SELECT
                        fa.id, ser.type service_type, fa.emkanat_id, td.id tdid, td.puk1, td.puk2, td.tdlte_number ibsusername
                    FROM bnm_factor fa
                        INNER JOIN bnm_services ser ON ser.id = fa.service_id
                        INNER JOIN bnm_tdlte_sim td ON td.id = fa.emkanat_id
                    WHERE fa.subscriber_id = ? AND ser.type = ? AND fa.tasvie_shode = ?";
                if ($groupby) {
                    $sql .= ' GROUP BY fa.emkanat_id,ser.type';
                }
                $res = Db::secure_fetchall($sql, array($sub[0]['id'], 'tdlte', 1));
                if ($res) {
                    return $res;
                } else {
                    return false;
                }
                break;
        }
    }
    public static function wirelessInfoByUserid(int $userid, $groupby = true)
    {
        switch ($_SESSION['user_type']) {
            case __ADMINUSERTYPE__:
            case __ADMINOPERATORUSERTYPE__:
            case __MODIRUSERTYPE__:
            case __MODIR2USERTYPE__:
            case __OPERATORUSERTYPE__:
                $sub = self::Select_By_Id('bnm_subscribers', $userid);
                $sql = "SELECT
                            fa.id faid,
                            ser.type sertype,
                            fa.emkanat_id faemkanatid,
                            ss.id ssid,
                            CONCAT(st.name,'---',ss.sub_id) ibusername
                        FROM
                            bnm_factor fa
                            INNER JOIN bnm_services ser ON ser.id = fa.service_id
                            INNER JOIN bnm_sub_station ss ON ss.id = fa.emkanat_id
                            INNER JOIN bnm_wireless_station st ON st.id = ss.station_id
                        WHERE
                            fa.subscriber_id = ?
                            AND ser.type = ?
                            AND fa.tasvie_shode = ?";
                if ($groupby) {
                    $sql .= ' GROUP BY fa.emkanat_id,ser.type';
                }
                $res = Db::secure_fetchall($sql, array($sub[0]['id'], 'wireless', 1));
                if ($res) {
                    return $res;
                } else {
                    return false;
                }
                break;
            case __MOSHTARAKUSERTYPE__:
                $sub = self::Select_By_Id('bnm_subscribers', $_SESSION['user_id']);
                $sql = "SELECT
                            fa.id faid,
                            ser.type sertype,
                            fa.emkanat_id faemkanatid,
                            ss.id ssid,
                            CONCAT(st.name,'---',ss.sub_id) ibusername
                        FROM
                            bnm_factor fa
                            INNER JOIN bnm_services ser ON ser.id = fa.service_id
                            INNER JOIN bnm_sub_station ss ON ss.id = fa.emkanat_id
                            INNER JOIN bnm_wireless_station st ON st.id = ss.station_id
                        WHERE
                            fa.subscriber_id = ?
                            AND ser.type = ?
                            AND fa.tasvie_shode = ?";
                if ($groupby) {
                    $sql .= ' GROUP BY fa.emkanat_id,ser.type';
                }
                $res = Db::secure_fetchall($sql, array($sub[0]['id'], 'wireless', 1));
                if ($res) {
                    return $res;
                } else {
                    return false;
                }
                break;
        }
    }

    public static function voipInfoByUserid(int $userid, $groupby = true)
    {
        switch ($_SESSION['user_type']) {
            case __ADMINUSERTYPE__:
            case __ADMINOPERATORUSERTYPE__:
            case __MODIRUSERTYPE__:
            case __MODIR2USERTYPE__:
            case __OPERATORUSERTYPE__:
                $sql = "SELECT fa.id , fa.emkanat_id, sub.name, sub.f_name,
                if(fa.emkanat_id=1,sub.telephone1,if(fa.emkanat_id=2,sub.telephone2,if(fa.emkanat_id=3,sub.telephone3,false))) ibsusername
               FROM
                   bnm_factor fa
                   INNER JOIN bnm_services ser ON fa.service_id = ser.id
                   INNER JOIN bnm_subscribers sub ON fa.subscriber_id = sub.id
               WHERE
                   fa.subscriber_id = ?
                   AND fa.tasvie_shode = ?
                   AND ser.type = ? ";
                if ($groupby) {
                    $sql .= ' GROUP BY fa.emkanat_id';
                }
                $res = Db::secure_fetchall($sql, array($userid, 1, 'voip'));
                if ($res) {
                    return $res;
                } else {
                    return false;
                }
                break;
            case __MOSHTARAKUSERTYPE__:
                $sql = "SELECT fa.id , fa.emkanat_id, sub.name, sub.f_name,
                if(fa.emkanat_id=1,sub.telephone1,if(fa.emkanat_id=2,sub.telephone2,if(fa.emkanat_id=3,sub.telephone3,false))) ibsusername
               FROM
                   bnm_factor fa
                   INNER JOIN bnm_services ser ON fa.service_id = ser.id
                   INNER JOIN bnm_subscribers sub ON fa.subscriber_id = sub.id
               WHERE
                   fa.subscriber_id = ?
                   AND fa.tasvie_shode = ?
                   AND ser.type = ? ";
                if ($groupby) {
                    $sql .= ' GROUP BY fa.emkanat_id';
                }
                $res = Db::secure_fetchall($sql, array($userid, 1, 'voip'));
                return $res;
                if ($res) {
                    return $res;
                } else {
                    return false;
                }
                break;
        }
    }

    public static function adslUserInfo(int $factorid, int $branch_id)
    {
        //daryafte kamele etelaate moshtarak va service kharidari shode
        if ($branch_id === 0) {
            //user sahar ertebat
            $sql = "SELECT
            sub.*,
            ser.type servicetype,
            ser.id serviceid,
            ser.sorate_paye_daryaft bandWidth,
            fa.id fid,
            fa.emkanat_id emkanatid,
            fa.tarikhe_shoroe_service start_service,
            fa.tarikhe_payane_service end_service,
            ostan.pish_shomare_ostan codeostan,
            ostan.name ostane_tavalod,
            shahr.name shahre_tavalod,
            country.code meliatcode,
            IF(country.code='IRN',1,0) isirani,
            CASE
                WHEN p.telephone= 1 THEN sub.telephone1
                WHEN p.telephone= 2 THEN sub.telephone2
                WHEN p.telephone= 3 THEN sub.telephone3
            END AS telephone,
            CASE
                WHEN p.telephone= 1 THEN sub.noe_malekiat1
                WHEN p.telephone= 2 THEN sub.noe_malekiat1
                WHEN p.telephone= 3 THEN sub.noe_malekiat1
            END AS noe_malekiat,
            CASE
                WHEN p.telephone= 1 THEN sub.address1
                WHEN p.telephone= 2 THEN sub.address2
                WHEN p.telephone= 3 THEN sub.address3
            END AS address,
                CASE
                WHEN p.telephone= 1 THEN sub.code_posti1
                WHEN p.telephone= 2 THEN sub.code_posti2
                WHEN p.telephone= 3 THEN sub.code_posti3
            END AS code_posti,
        CASE
                WHEN p.telephone= 1 THEN sub.name_malek1
                WHEN p.telephone= 2 THEN sub.name_malek2
                WHEN p.telephone= 3 THEN sub.name_malek3
            END AS name_malek,
            CASE
                WHEN p.telephone= 1 THEN sub.f_name_malek1
                WHEN p.telephone= 2 THEN sub.f_name_malek2
                WHEN p.telephone= 3 THEN sub.f_name_malek3
            END AS f_name_malek
        FROM
            bnm_factor fa
            INNER JOIN bnm_subscribers sub ON sub.id = fa.subscriber_id
            INNER JOIN bnm_services ser ON ser.id = fa.service_id
            INNER JOIN bnm_ostan ostan ON ostan.id = sub.ostane_tavalod
            INNER JOIN bnm_shahr shahr ON shahr.id = sub.shahre_tavalod
            INNER JOIN bnm_countries country ON country.id = sub.meliat
            INNER JOIN bnm_port p ON p.id = fa.emkanat_id
            WHERE fa.id = ?";
            $res = Db::secure_fetchall($sql, [$factorid]);
            // return $res;
            return $sql;
        } else {
            //user namayande
            $sql = "SELECT
            sub.*,
            ser.type serviceType,
            ser.id serviceId,
            ser.sorate_paye_daryaft bandWidth,
            fa.id fid,
            fa.emkanat_id emkanatId,
            fa.tarikhe_shoroe_service start_service,
            fa.tarikhe_payane_service end_service,
            ostan.pish_shomare_ostan codeOstan,
            shahr.name shahre_tavalod,
            branch.id branch_id,
            country.code codeCountry,
            IF(country.code='IRN',1,0) isirani,
            company.code_noe_sherkat companyType,
            company.noe_sherkat companyTypeFarsi,
            CASE
                WHEN p.telephone= 1 THEN sub.telephone1
                WHEN p.telephone= 2 THEN sub.telephone2
                WHEN p.telephone= 3 THEN sub.telephone3
            END AS telephone,
            CASE
                WHEN p.telephone= 1 THEN sub.noe_malekiat1
                WHEN p.telephone= 2 THEN sub.noe_malekiat1
                WHEN p.telephone= 3 THEN sub.noe_malekiat1
            END AS noe_malekiat,
            CASE
                WHEN p.telephone= 1 THEN sub.address1
                WHEN p.telephone= 2 THEN sub.address2
                WHEN p.telephone= 3 THEN sub.address3
            END AS address,
                CASE
                WHEN p.telephone= 1 THEN sub.code_posti1
                WHEN p.telephone= 2 THEN sub.code_posti2
                WHEN p.telephone= 3 THEN sub.code_posti3
            END AS code_posti,
        CASE
                WHEN p.telephone= 1 THEN sub.name_malek1
                WHEN p.telephone= 2 THEN sub.name_malek2
                WHEN p.telephone= 3 THEN sub.name_malek3
            END AS name_malek,
            CASE
                WHEN p.telephone= 1 THEN sub.f_name_malek1
                WHEN p.telephone= 2 THEN sub.f_name_malek2
                WHEN p.telephone= 3 THEN sub.f_name_malek3
            END AS f_name_malek
        FROM
            bnm_factor fa
            INNER JOIN bnm_subscribers sub ON sub.id = fa.subscriber_id
            INNER JOIN bnm_services ser ON ser.id = fa.service_id
            INNER JOIN bnm_ostan ostan ON ostan.id = sub.ostane_tavalod
            INNER JOIN bnm_shahr shahr ON shahr.id = sub.shahre_tavalod
            INNER JOIN bnm_countries country ON country.id = sub.meliat
            LEFT  JOIN bnm_company_types company ON company.id = sub.noe_sherkat
            INNER JOIN bnm_port p ON p.id = fa.emkanat_id
            INNER JOIN bnm_branch branch ON branch.id = sub.branch_id
            WHERE fa.id = ?";
            $res = Db::secure_fetchall($sql, [$factorid]);
            return $res;
        }
    }

    public static function voipUserInfo(int $factorid, int $branch_id)
    {
        //daryafte kamele etelaate moshtarak va service kharidari shode
        if ($branch_id === 0) {
            //user sahar ertebat
            $sql = "SELECT
            sub.*,
            ser.type serviceType,
            ser.id serviceId,
            fa.id fid,
            fa.emkanat_id emkanatId,
            fa.tarikhe_shoroe_service start_service,
            fa.tarikhe_payane_service end_service,
            fa.disable_shode disable_shode,
            ostan.pish_shomare_ostan codeOstan,
            country.code codeCountry,
            IF(country.code='IRN',1,0) isirani,
            shahr.name shahre_tavalod,
            company.code_noe_sherkat companyType,
            company.noe_sherkat companyTypeFarsi,
            CASE
                WHEN p.telephone= 1 THEN sub.telephone1
                WHEN p.telephone= 2 THEN sub.telephone2
                WHEN p.telephone= 3 THEN sub.telephone3
            END AS telephone,
            CASE
                WHEN fa.emkanat_id= 1 THEN sub.noe_malekiat1
                WHEN fa.emkanat_id= 2 THEN sub.noe_malekiat1
                WHEN fa.emkanat_id= 3 THEN sub.noe_malekiat1
            END AS noe_malekiat,
            CASE
                WHEN p.telephone= 1 THEN sub.address1
                WHEN p.telephone= 2 THEN sub.address2
                WHEN p.telephone= 3 THEN sub.address3
            END AS address,
                CASE
                WHEN p.telephone= 1 THEN sub.code_posti1
                WHEN p.telephone= 2 THEN sub.code_posti2
                WHEN p.telephone= 3 THEN sub.code_posti3
            END AS code_posti,
        CASE
                WHEN fa.emkanat_id= 1 THEN sub.name_malek1
                WHEN fa.emkanat_id= 2 THEN sub.name_malek2
                WHEN fa.emkanat_id= 3 THEN sub.name_malek3
            END AS name_malek,
            CASE
                WHEN fa.emkanat_id= 1 THEN sub.f_name_malek1
                WHEN fa.emkanat_id= 2 THEN sub.f_name_malek2
                WHEN fa.emkanat_id= 3 THEN sub.f_name_malek3
            END AS f_name_malek
        FROM
            bnm_factor fa
            INNER JOIN bnm_subscribers sub ON sub.id = fa.subscriber_id
            INNER JOIN bnm_services ser ON ser.id = fa.service_id
            INNER JOIN bnm_ostan ostan ON ostan.id = sub.ostane_tavalod
            INNER JOIN bnm_shahr shahr ON shahr.id = sub.shahre_tavalod
            INNER JOIN bnm_countries country ON country.id = sub.meliat
            LEFT  JOIN bnm_company_types company ON company.id = sub.noe_sherkat
            INNER JOIN bnm_port p ON p.id = fa.emkanat_id
            WHERE fa.id = ?";
            $res = Db::secure_fetchall($sql, [$factorid]);
            return $res;
        } else {
            //user namayande
            $sql = "SELECT
            sub.*,
            ser.type serviceType,
            ser.id serviceId,
            ser.sorate_paye_daryaft bandWidth,
            fa.id fid,
            fa.emkanat_id emkanatId,
            fa.tarikhe_shoroe_service start_service,
            fa.tarikhe_payane_service end_service,
            fa.disable_shode disable_shode,
            ostan.pish_shomare_ostan codeOstan,
            branch.id branch_id,
            shahr.name shahre_tavalod,
            country.code codeCountry,
            IF(country.code='IRN',1,0) isirani,
            company.code_noe_sherkat companyType,
            company.noe_sherkat companyTypeFarsi,
            CASE
                WHEN p.telephone= 1 THEN sub.telephone1
                WHEN p.telephone= 2 THEN sub.telephone2
                WHEN p.telephone= 3 THEN sub.telephone3
            END AS telephone,
            CASE
                WHEN fa.emkanat_id= 1 THEN sub.noe_malekiat1
                WHEN fa.emkanat_id= 2 THEN sub.noe_malekiat1
                WHEN fa.emkanat_id= 3 THEN sub.noe_malekiat1
            END AS noe_malekiat,
            CASE
                WHEN p.telephone= 1 THEN sub.address1
                WHEN p.telephone= 2 THEN sub.address2
                WHEN p.telephone= 3 THEN sub.address3
            END AS address,
                CASE
                WHEN p.telephone= 1 THEN sub.code_posti1
                WHEN p.telephone= 2 THEN sub.code_posti2
                WHEN p.telephone= 3 THEN sub.code_posti3
            END AS code_posti,
        CASE
                WHEN fa.emkanat_id= 1 THEN sub.name_malek1
                WHEN fa.emkanat_id= 2 THEN sub.name_malek2
                WHEN fa.emkanat_id= 3 THEN sub.name_malek3
            END AS name_malek,
            CASE
                WHEN fa.emkanat_id= 1 THEN sub.f_name_malek1
                WHEN fa.emkanat_id= 2 THEN sub.f_name_malek2
                WHEN fa.emkanat_id= 3 THEN sub.f_name_malek3
            END AS f_name_malek
        FROM
            bnm_factor fa
            INNER JOIN bnm_subscribers sub ON sub.id = fa.subscriber_id
            INNER JOIN bnm_services ser ON ser.id = fa.service_id
            INNER JOIN bnm_ostan ostan ON ostan.id = sub.ostane_tavalod
            INNER JOIN bnm_shahr shahr ON shahr.id = sub.shahre_tavalod
            INNER JOIN bnm_countries country ON country.id = sub.meliat
            LEFT JOIN bnm_company_types company ON company.id = sub.noe_sherkat
            INNER JOIN bnm_port p ON p.id = fa.emkanat_id
            INNER JOIN bnm_branch branch ON branch.id = sub.branch_id
            WHERE fa.id = ?";
            $res = Db::secure_fetchall($sql, [$factorid]);
            return $res;
        }
    }

    public static function wirelessUserInfo(int $factorid, int $branch_id)
    {
        //daryafte kamele etelaate moshtarak va service kharidari shode
        if ($branch_id === 0) {
            //user sahar ertebat
            $sql = "SELECT
            sub.*,
            ser.type serviceType,
            ser.id serviceId,
            fa.id fid,
            fa.tarikhe_shoroe_service start_service,
            fa.tarikhe_payane_service end_service,
            fa.emkanat_id emkanatId,
            ostan.pish_shomare_ostan codeOstan,
            country.code codeCountry,
            IF(country.code='IRN',1,0) isirani,
            company.code_noe_sherkat companyType,
            company.noe_sherkat companyTypeFarsi,
            shahr.name shahre_tavalod,
            station.id stationid,
            station.add,
            station.dish_type dishType,
            ap.address ap_address,
        CASE
                WHEN p.telephone= 1 THEN sub.telephone1
                WHEN p.telephone= 2 THEN sub.telephone2
                WHEN p.telephone= 3 THEN sub.telephone3
            END AS telephone,
            CASE
                WHEN p.telephone= 1 THEN sub.noe_malekiat1
                WHEN p.telephone= 2 THEN sub.noe_malekiat1
                WHEN p.telephone= 3 THEN sub.noe_malekiat1
            END AS noe_malekiat,
            CASE
                WHEN p.telephone= 1 THEN sub.address1
                WHEN p.telephone= 2 THEN sub.address2
                WHEN p.telephone= 3 THEN sub.address3
            END AS address,
                CASE
                WHEN p.telephone= 1 THEN sub.code_posti1
                WHEN p.telephone= 2 THEN sub.code_posti2
                WHEN p.telephone= 3 THEN sub.code_posti3
            END AS code_posti,
        FROM
            bnm_factor fa
            INNER JOIN bnm_subscribers sub ON sub.id = fa.subscriber_id
            INNER JOIN bnm_services ser ON ser.id = fa.service_id
            INNER JOIN bnm_ostan ostan ON ostan.id = sub.ostane_tavalod
            INNER JOIN bnm_shahr shahr ON shahr.id = sub.shahre_tavalod
            INNER JOIN bnm_countries country ON country.id = sub.meliat
            LEFT JOIN bnm_company_types company ON company.id = sub.noe_sherkat
            INNER JOIN bnm_wireless_station station ON station.id = fa.emkanat_id
            INNER JOIN bnm_port p ON p.id = fa.emkanat_id
            INNER JOIN bnm_wireless_ap ap ON station.wireless_ap = ap.id
            WHERE fa.id = ?";
            $res = Db::secure_fetchall($sql, [$factorid]);
            return $res;
        } else {
            //user namayande
            $sql = "SELECT
            sub.*,
            ser.type serviceType,
            ser.id serviceId,
            ser.sorate_paye_daryaft bandWidth,
            fa.id fid,
            fa.subscriber_id,
            fa.emkanat_id emkanatId,
            fa.tarikhe_shoroe_service start_service,
            fa.tarikhe_payane_service end_service,
            ostan.pish_shomare_ostan codeOstan,
            branch.id branch_id,
            country.code codeCountry,
            IF(country.code='IRN',1,0) isirani,
            company.code_noe_sherkat companyType,
            company.noe_sherkat companyTypeFarsi,
            shahr.name shahre_tavalod,
            station.id stationid,
            station.address stationaddress,
            station.tol_joghrafiai tol,
            station.arz_joghrafiai arz,
            station.dish_type dishType,
            ap.address ap_address,
              CASE
                WHEN p.telephone= 1 THEN sub.telephone1
                WHEN p.telephone= 2 THEN sub.telephone2
                WHEN p.telephone= 3 THEN sub.telephone3
            END AS telephone,
            CASE
                WHEN p.telephone= 1 THEN sub.noe_malekiat1
                WHEN p.telephone= 2 THEN sub.noe_malekiat1
                WHEN p.telephone= 3 THEN sub.noe_malekiat1
            END AS noe_malekiat,
            CASE
                WHEN p.telephone= 1 THEN sub.address1
                WHEN p.telephone= 2 THEN sub.address2
                WHEN p.telephone= 3 THEN sub.address3
            END AS address,
                CASE
                WHEN p.telephone= 1 THEN sub.code_posti1
                WHEN p.telephone= 2 THEN sub.code_posti2
                WHEN p.telephone= 3 THEN sub.code_posti3
            END AS code_posti,
        CASE
                WHEN p.telephone= 1 THEN sub.name_malek1
                WHEN p.telephone= 2 THEN sub.name_malek2
                WHEN p.telephone= 3 THEN sub.name_malek3
            END AS name_malek,
            CASE
                WHEN p.telephone= 1 THEN sub.f_name_malek1
                WHEN p.telephone= 2 THEN sub.f_name_malek2
                WHEN p.telephone= 3 THEN sub.f_name_malek3
            END AS f_name_malek
        FROM
            bnm_factor fa
            INNER JOIN bnm_subscribers sub ON sub.id = fa.subscriber_id
            INNER JOIN bnm_services ser ON ser.id = fa.service_id
            INNER JOIN bnm_ostan ostan ON ostan.id = sub.ostane_tavalod
            INNER JOIN bnm_shahr shahr ON shahr.id = sub.shahre_tavalod
            INNER JOIN bnm_countries country ON country.id = sub.meliat
            LEFT JOIN bnm_company_types company ON company.id = sub.noe_sherkat
            INNER JOIN bnm_branch branch ON branch.id = sub.branch_id
            INNER JOIN bnm_wireless_station station ON station.id = fa.emkanat_id
            INNER JOIN bnm_port p ON p.id = fa.emkanat_id
            INNER JOIN bnm_wireless_ap ap ON station.wireless_ap = ap.id
            WHERE fa.id = ?";
            $res = Db::secure_fetchall($sql, [$factorid]);
            return $res;
        }
    }

    public static function checkCodeMeli($code)
    {
        if (!preg_match('/^[0-9]{10}$/', $code)) {
            return false;
        }

        for ($i = 0; $i < 10; $i++) {
            if (preg_match('/^' . $i . '{10}$/', $code)) {
                return false;
            }
        }

        for ($i = 0, $sum = 0; $i < 9; $i++) {
            $sum += ((10 - $i) * intval(substr($code, $i, 1)));
        }

        $ret = $sum % 11;
        $parity = intval(substr($code, 9, 1));
        if (($ret < 2 && $ret == $parity) || ($ret >= 2 && $ret == 11 - $parity)) {
            return true;
        }

        return false;
    }

    public static function addUserCreditByPayment($user_id, $noe_user, $amount, $resnum)
    {
        switch ($noe_user) {
            case __ADMINUSERTYPE__:
            case __ADMINOPERATORUSERTYPE__:
                return false;
                break;
            case __MODIRUSERTYPE__:
            case __MODIR2USERTYPE__:
            case __OPERATORUSERTYPE__:
            case __OPERATOR2USERTYPE__:
                $noe_user = 2;
                break;
            case __MOSHTARAKUSERTYPE__:
                $noe_user = 1;
                break;
            default:
                return false;
                break;
        }
        $sql = "SELECT * FROM bnm_credits WHERE user_or_branch_id = ? AND noe_user = ? ORDER BY id DESC LIMIT 1";
        $res_credit = Db::secure_fetchall($sql, array($user_id, $noe_user));

        if ($res_credit) {
            //ghablan hesab darad
            $credit_array = array();
            $credit_array['noe_user'] = $noe_user;
            $credit_array['user_or_branch_id'] = $user_id;
            $credit_array['credit'] = $res_credit[0]['credit'] + $amount;
            $credit_array['bestankar'] = $amount;
            $credit_array['tozihat'] = 'پرداخت از درگاه بانکی در تاریخ ' . self::Today_Shamsi_Date() . ' ' . self::nowTimeTehran(':', false) . 'شماره پیگیری' . $resnum;
            $sql = self::Insert_Generator($credit_array, 'bnm_credits');
            $res_new_credit = Db::secure_insert_array($sql, $credit_array);
            return $res_new_credit;
            // if ($res_new_credit) {
            //     echo "<script>alert('تراکنش با موفقیت انجام شد و حساب شما شارژ شد.');</script>";
            //     echo "<script>alert('شماره پیگیری : {$_POST['TRACENO']}');</script>";
            // } else {
            //     echo "<script>alert('کاربر محترم تراکنش شما با موفقیت انجام شد اما متاسفانه حساب شما شارژ نشد لطفا جهت پیگیری با شرکت تماس حاصل فرمایید.');</script>";
            //     echo "<script>alert('شماره پیگیری : {$_POST['TRACENO']}');</script>";
            // }
        } else {
            //sakhte hesabe credit baraye user
            $credit_array = array();
            $credit_array['noe_user'] = $noe_user;
            $credit_array['user_or_branch_id'] = $user_id;
            $credit_array['credit'] = $amount;
            $credit_array['bestankar'] = $amount;
            $credit_array['tozihat'] = 'پرداخت از درگاه بانکی در تاریخ ' . self::Today_Shamsi_Date() . ' ' . self::nowTimeTehran(':', false) . 'شماره پیگیری' . $resnum;
            $sql = self::Insert_Generator($credit_array, 'bnm_credits');
            $res_new_credit = Db::secure_insert_array($sql, $credit_array);
            return $res_new_credit;
            // if ($res_new_credit) {
            //     echo "<script>alert('تراکنش با موفقیت انجام شد و حساب شما شارژ شد اکنون میتوانید فاکتور مورد نظر را پرداخت کنید.');</script>";
            //     echo "<script>alert('شماره پیگیری : {$_POST['TRACENO']}');</script>";
            // } else {
            //     echo "<script>alert('کاربر محترم تراکنش شما با موفقیت انجام شد اما متاسفانه حساب شما شارژ نشد لطفا جهت پیگیری با شرکت تماس حاصل فرمایید.');</script>";
            //     echo "<script>alert('شماره پیگیری : {$_POST['TRACENO']}');</script>";
            // }
        }
    }
    public static function randomNum(int $min = 1000000, int $max = 1000000000)
    {
        return rand($min, $max);
    }
    public static function checkSubExist($codemeli, $telephone_hamrah, $telephone1)
    {
        $sql = "SELECT
        COUNT(*) rowsnum
    FROM
        bnm_subscribers
    WHERE
        code_meli = ?
        OR telephone_hamrah = ?
        OR telephone1 = ?";
        $res = Db::secure_fetchall($sql, [$codemeli, $telephone_hamrah, $telephone1]);
        if ($res[0]['rowsnum'] === 0) {
            return false;
        } else {
            return true;
        }
    }
    public static function checkPreSubExist($codemeli, $telephone_hamrah, $telephone1)
    {
        $sql = "SELECT
        COUNT(*) rowsnum
    FROM
        bnm_presubscribers
    WHERE
        code_meli = ?
        OR telephone_hamrah = ?
        OR telephone1 = ?";
        $res = Db::secure_fetchall($sql, [$codemeli, $telephone_hamrah, $telephone1]);
        if ($res[0]['rowsnum'] === 0) {
            return false;
        } else {
            return true;
        }
    }
    public static function checkSubscriberCreditForPay($credit, $factorprice)
    {
        if ($credit && $factorprice) {
            if (abs($credit) >= abs($factorprice)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public static function checkbranchCreditForpay($credit, $factorprice, $extrabalance = __BRANCHESACCEPTABLEBALANCEFORPAY__)
    {
        if ($credit && $factorprice) {
            // if (abs($res_credit_branch[0]['credit']) >= (abs($res_factor[0]['mablaghe_ghabele_pardakht']) + (abs($res_factor[0]['mablaghe_ghabele_pardakht']) * __BRANCHESACCEPTABLEBALANCEFORPAY__))) {
            if (abs($credit) >= abs($factorprice) + (abs($factorprice) * $extrabalance)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function checkTelephone($telephone)
    {
        if (self::Is_Empty_OR_Null($telephone)) {
            if (strlen($telephone) === 11) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public static function readExcelFirstLine(string $file)
    {
        // $bank   =self::select_By_Id($bankid);
        if ($file) {
            $reader = new Excel();
            // ($bank[0]['usage_type']===1) ? $bank[0]['usage_type'] = 'public' : 'private';
            $reader = $reader::load($file);
            $arr = array();
            foreach ($reader as $row) {
                array_push($arr, (string) $row[0]);
            }
            return $arr;
        } else {
            return false;
        }
    }
    public static function Decjson($data)
    {
        return json_decode($data);
    }
    public static function timestampToDateTime($timestamp)
    {
        if ($timestamp) {
            return date('Y-m-d H:i:s', $timestamp);
        } else {
            return false;
        }
    }
    public static function Custom_Msg($msg, /*1=Success,2=Error,3=Warning,4=Info*/ $msg_type = 2, $json = true)
    {
        //
        if ($json) {
            switch ($msg_type) {
                case 1:
                    return json_encode(array('Success' => $msg), JSON_UNESCAPED_UNICODE);
                    break;
                case 2:
                    return json_encode(array('Warning' => $msg), JSON_UNESCAPED_UNICODE);
                    break;
                case 3:
                    return json_encode(array('Error' => $msg), JSON_UNESCAPED_UNICODE);
                    break;
                case 4:
                    return json_encode(array('Info' => $msg), JSON_UNESCAPED_UNICODE);
                    break;
                default:
                    return self::Json_Message('f');
                    break;
            }
        } else {
            return "<script>alert('{$msg}');</script>";
        }
    }
    public static function getUserIp()
    {
        $arr = [];
        if (isset($_SESSION['HTTP_CLIENT_IP'])) {
            $arr['http_c_ip'] = $_SESSION['HTTP_CLIENT_IP'];
        }
        if (isset($_SESSION['HTTP_X_FORWARDED_FOR'])) {
            $arr['http_x_f_f_ip'] = $_SESSION['HTTP_X_FORWARDED_FOR'];
        }
        if (isset($_SESSION['REMOTE_ADDR'])) {
            $arr['remote_addr_ip'] = $_SESSION['REMOTE_ADDR'];
        }
        return $arr;
    }
    public static function simplePost(string $url, array $request)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        if (!curl_error($ch)) {
            curl_close($ch);
            return $server_output;
        } else {
            curl_close($ch);
            return false;
        }
    }

    public static function httpPost($url, $data = [])
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    public static function simplePost2($url, $data)
    {
        $jsonData = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        //     'Content-Type: application/json',
        //     'Content-Length: ' . strlen($jsonData)
        // ));
        $result = curl_exec($ch);
        $err = curl_error($ch);
        // $result = json_decode($result, true, JSON_PRETTY_PRINT);
        curl_close($ch);
        if ($err) {
            return $err;
        } else {
            return $result;
        }
    }

    public static function redirect($url)
    {
        ob_start();
        header('Location: ' . $url);
        ob_end_flush();
        die();
    }

    public static function curlPost(string $url, array $data = null, $headers = null)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if (!empty($data)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        if (!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        $response = curl_exec($ch);

        if (curl_error($ch)) {
            trigger_error('Curl Error:' . curl_error($ch));
        }

        curl_close($ch);
        return $response;
    }

    public static function Simple_Rest($method, $dataResult = [], $url, $username = "sahar_ertebat", $password = "abz1bhdgu2g3", $hashheader = true)
    {
        $data = json_encode($dataResult);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        switch ($method) {
            case "GET":
            case "get":
            case "Get":
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
                break;
            case "POST":
            case "post":
            case "Post":
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                break;
            case "PUT":
            case "put":
            case "Put":
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                break;
            case "PATCH":
            case "patch":
            case "Patch":
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PATCH");
                break;
            case "DELETE":
            case "delete":
            case "Delete":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                break;
            default:
                return false;
                break;
        }
        //hash username & password
        if ($hashheader) {
            $hash = base64_encode($username . ":" . $password);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                "Authorization: Basic $hash",
                'Content-Type: application/json',
            ));
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        }
        // EXECUTE:
        $result = curl_exec($curl);
        curl_close($curl);
        if (!curl_error($ch)) {
            return json_decode($result, true);
        } else {
            return false;
        }
    }
    public static function ibsCheckResponse($res)
    {
        if (isset($res)) {
            if (isset($res[1])) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public static function ibsCheckUserinfoExist($res)
    {
        if (isset($res)) {
            if (isset($res[1])) {
                if ($res[1]) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public static function ibsAttrInit()
    {
        switch ($type) {
            case 'adsl':
            case 'vdsl':
            case 'bitstream':
            case 'wireless':
            case 'tdlte':
            case 'voip':

                return $res;
                break;
        }
        return $res;
    }
    public static function ibsSetAbsExpDate(string $type, int $ibs_id, string $date, $datetype = "gregorian")
    {
        switch ($type) {
            case 'adsl':
            case 'vdsl':
            case 'bitstream':
            case 'wireless':
            case 'tdlte':
            case 'voip':
                $res = $GLOBALS['ibs_internet']->setAbsExpDate(
                    $ibs_id,
                    $params['zaname_estefade_be_tarikh'],
                    $datetype
                );
                return $res;
                break;
        }
        return $res;
    }
    public static function ibsSetRelExpDate(string $type, int $ibs_id, string $date, $datetype = "gregorian")
    {
        switch ($type) {
            case 'adsl':
            case 'vdsl':
            case 'bitstream':
            case 'wireless':
            case 'tdlte':
            case 'voip':
                $res = $GLOBALS['ibs_internet']->setRelExpDate(
                    $ibs_id,
                    $params['zaname_estefade_be_tarikh']
                );
                return $res;
                break;
        }
        return $res;
    }
    public static function ibsSetBirthDateById(string $type, int $ibs_id, string $date, $datetype = "gregorian")
    {
        //todo...code posti ibs bayad code shahkar bezarim
        //todo...email bayad noe service bashad(masalan adsl ya wireless ya tdlte)
        switch ($type) {
            case 'adsl':
            case 'vdsl':
            case 'bitstream':
                $res = $GLOBALS['ibs_internet']->setUserBirthDate(
                    $ibs_id,
                    $date,
                    $datetype
                );
                break;
            case 'tdlte':
            case 'wireless':
                $res = $GLOBALS['ibs_internet']->setUserBirthDate(
                    $ibs_id,
                    $date,
                    $datetype
                );
                break;
            case 'voip':
                $res = $GLOBALS['ibs_internet']->setUserBirthDate(
                    $ibs_id,
                    $date,
                    $datetype
                );
                break;
            default:
                return false;
                break;
        }
        return $res;
        // if(isset($res)){
        //     return $res;
        // }else{
        //     return false;
        // }
    }
    public static function ibsitest()
    {
        $res_setuserattrs = $GLOBALS['ibs_internet']->setUserAttributes(
            1662,
            array(
                'name' => 'fff' . ' ' . 'family',
                'comment' => 'codemeli',
                'phone' => 'test_telephone',
                'cell_phone' => 'test_telephone_hamrah',
                'postal_code' => 0,
                'email' => 'test_shomare_shenasname' . ',' . 'test_city_name',
                'address' => 'test_type',
                'birthdate' => '1992-12-01',
                'birthdate_unit' => 'gregorian',
                'abs_exp_date' => '2021-12-12',
                'abs_exp_date_unit' => 'gregorian',
                "normal_user_spec" => array(
                    "normal_username" => 'rrttyy',
                    "normal_password" => 'rrttyy',
                ),

            )
        );
        return (json_encode($res_setuserattrs));
    }
    public static function ibsiSetAttrsNewUser(
        string $type,
        int $ibs_id,
        $name,
        $f_name,
        $code_meli,
        $ibs_username,
        $shomare_shenasname,
        $city_name,
        $telephone_hamrah,
        $shahkar_status_code,
        $tavalode_fa,
        $tarikhe_payane_service
    ) {
        switch ($type) {
            case 'adsl':
            case 'vdsl':
            case 'bitstream':
            case 'tdlte':
            case 'wireless':
                $res = $GLOBALS['ibs_internet']->setUserAttributes(
                    $ibs_id,
                    array(
                        'name' => $name . ' ' . $f_name,
                        'comment' => $code_meli,
                        'phone' => $ibs_username,
                        'cell_phone' => $telephone_hamrah,
                        'postal_code' => $shahkar_status_code,
                        'email' => $shomare_shenasname . ',' . $shahre_tavalod,
                        'address' => $type,
                        'birthdate' => $tavalode_fa,
                        'birthdate_unit' => 'gregorian',
                        'abs_exp_date' => $tarikhe_payane_service,
                        'abs_exp_date_unit' => 'gregorian',
                        "normal_user_spec" => array(
                            "normal_username" => $ibs_username,
                            "normal_password" => $code_meli,
                        ),
                    )
                );

                break;
            default:
                return false;
                break;
        }
        return $GLOBALS['ibs_internet'];
        if (isset($res)) {
            return $res;
        } else {
            return false;
        }
    }
    public static function ibsvSetAttrsNewUser(
        string $type,
        int $ibs_id,
        $name,
        $f_name,
        $code_meli,
        $ibs_username,
        $shomare_shenasname,
        $shahre_tavalod,
        $telephone_hamrah,
        $shahkar_status_code,
        $tavalode_fa,
        $tarikhe_payane_service
    ) {
        //todo...code posti ibs bayad code shahkar bezarim
        //todo...email bayad noe service bashad(masalan adsl ya wireless ya tdlte)
        switch ($type) {
            case 'voip':
                $res = $GLOBALS['ibs_voip']->setUserAttributes(
                    $ibs_id,
                    array(
                        'name' => $params['name'] . ' ' . $params['f_name'],
                        'comment' => $params['code_meli'],
                        'phone' => $params['ibs_username'],
                        'cell_phone' => $params['telephone_hamrah'],
                        'address' => $params['address'],
                        'postal_code' => $params['code_posti'],
                        'normal_user_spec' => array('normal_username' => $params['ibs_username'], 'normal_password' => $params['code_meli'])
                    )
                );

                break;
            default:
                return false;
                break;
        }
        return $res;
        // if(isset($res)){
        //     return $res;
        // }else{
        //     return false;
        // }
    }
    public static function ibsAddNewUser(string $type, int $count, float $credit, string $isp_name, string $group_name, string $credit_comment)
    {
        switch ($type) {
            case 'adsl':
            case 'vdsl':
            case 'bitstream':
            case 'tdlte':
            case 'wireless':
                $res = $GLOBALS['ibs_internet']->addNewUser(
                    $params['count'],
                    $params['credit'],
                    $params['isp_name'],
                    $params['group_name'],
                    $params['credit_comment']
                );
                return $res;
                break;
            case 'voip':
                $res = $GLOBALS['ibs_voip']->addNewUser(
                    $params['count'],
                    $params['credit'],
                    $params['isp_name'],
                    $params['group_name'],
                    $params['credit_comment']
                );
                break;
        }
        return $res;
        if (self::ibsCheckResponse($res)) {
            return $res;
        } else {
            return false;
        }
    }
    public static function ibsiGetUserByUsername($username = false)
    {
        //ibsi_getuserbyusername //old name
        if (isset($username)) {
            $res = $GLOBALS['ibs_internet']->getUserInfoByNormalUserName($username);
            return $res;
            if ($res[1]) {
                return $res[1];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public static function getIbsinfoByUsername($username, $sertype = 'internet')
    {
        switch (strtolower($sertype)) {
            case 'internet':
            case 'adsl':
            case 'vdsl':
            case 'wireless':
            case 'tdlte':
                $res = $GLOBALS['ibs_internet']->getUserInfoByNormalUserName($username);
                break;
            case 'voip':
                $res = $GLOBALS['ibs_voip']->getUserInfoByVoipUserName($username);
                break;
            default:
                return false;
                break;
        }

        if (isset($res[1])) {
            if ($res[1]) {
                if ($res[1][key($res[1])]) {
                    return $res[1][key($res[1])];
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
        return $res;
    }
    public static function ibsvGetUserbyUsername($username = false)
    {
        //ibsv_getuserbyusername //old name
        if ($username) {
            $res = $GLOBALS['ibs_voip']->getUserInfoByVoipUserName($username);
            if ($res[1]) {
                return $res[1];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public static function Internal_Message_By_Karbord($karbord = false, $status = 1)
    {
        if ($karbord) {
            $sql = "SELECT * FROM bnm_internal_messages WHERE karbord = ? AND status = ? ORDER BY id LIMIT 1";
            $res = Db::secure_fetchall($sql, array($karbord, $status));
            return $res;
        } else {
            return false;
        }
    }
    public static function IsJson($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
    public static function Select_Simple($table_name = false)
    {
        if ($table_name) {
            $sql = "SELECT * FROM {$table_name}";
            $res = Db::fetchall_Query($sql);
            return $res;
        } else {
            return false;
        }
    }
    public static function getSubTelephoneInfo(array $userinfo, string $telid)
    {
        $res = [];
        if ($telid === "1") {
            if ((int) $userinfo[0]['noe_malekiat1'] === 1) {
                $res['telephone'] = $userinfo[0]['telephone1'];
                $res['codemelimoshtarak'] = $userinfo[0]['code_meli'];
                $res['codeposti'] = $userinfo[0]['code_posti1'];
                $res['address'] = $userinfo[0]['address1'];
                $res['namemoshtarak'] = $userinfo[0]['name'];
                $res['fnamemoshtarak'] = $userinfo[0]['f_name'];
                $res['noemalekiat'] = $userinfo[0]['noe_malekiat1'];
            } else {
                $res['telephone'] = $userinfo[0]['telephone1'];
                $res['codemelimoshtarak'] = $userinfo[0]['code_meli'];
                $res['codemelimalek'] = $userinfo[0]['code_meli1'];
                $res['codeposti'] = $userinfo[0]['code_posti1'];
                $res['address'] = $userinfo[0]['address1'];
                $res['namemoshtarak'] = $userinfo[0]['name'];
                $res['fnamemoshtarak'] = $userinfo[0]['f_name'];
                $res['namemalek'] = $userinfo[0]['name_malek1'];
                $res['fnamemalek'] = $userinfo[0]['f_name_malek1'];
            }
        } elseif ($telid === "2") {
            if ((int) $userinfo[0]['noe_malekiat2'] === 1) {
                $res['telephone'] = $userinfo[0]['telephone2'];
                $res['codemelimoshtarak'] = $userinfo[0]['code_meli'];
                $res['codeposti'] = $userinfo[0]['code_posti2'];
                $res['address'] = $userinfo[0]['address2'];
                $res['namemoshtarak'] = $userinfo[0]['name'];
                $res['fnamemoshtarak'] = $userinfo[0]['f_name'];
                $res['noemalekiat'] = $userinfo[0]['noe_malekiat2'];
            } else {
                $res['telephone'] = $userinfo[0]['telephone2'];
                $res['codemelimoshtarak'] = $userinfo[0]['code_meli'];
                $res['codemelimalek'] = $userinfo[0]['code_meli2'];
                $res['codeposti'] = $userinfo[0]['code_posti2'];
                $res['address'] = $userinfo[0]['address2'];
                $res['namemoshtarak'] = $userinfo[0]['name'];
                $res['fnamemoshtarak'] = $userinfo[0]['f_name'];
                $res['namemalek'] = $userinfo[0]['name_malek2'];
                $res['fnamemalek'] = $userinfo[0]['f_name_malek2'];
            }
        } elseif ($telid === "3") {
            if ((int) $userinfo[0]['noe_malekiat3'] === 1) {
                $res['telephone'] = $userinfo[0]['telephone3'];
                $res['codemelimoshtarak'] = $userinfo[0]['code_meli'];
                $res['codeposti'] = $userinfo[0]['code_posti3'];
                $res['address'] = $userinfo[0]['address3'];
                $res['namemoshtarak'] = $userinfo[0]['name'];
                $res['fnamemoshtarak'] = $userinfo[0]['f_name'];
                $res['noemalekiat'] = $userinfo[0]['noe_malekiat3'];
            } else {
                $res['telephone'] = $userinfo[0]['telephone3'];
                $res['codemelimoshtarak'] = $userinfo[0]['code_meli'];
                $res['codemelimalek'] = $userinfo[0]['code_meli3'];
                $res['codeposti'] = $userinfo[0]['code_posti3'];
                $res['address'] = $userinfo[0]['address3'];
                $res['namemoshtarak'] = $userinfo[0]['name'];
                $res['fnamemoshtarak'] = $userinfo[0]['f_name'];
                $res['namemalek'] = $userinfo[0]['name_malek3'];
                $res['fnamemalek'] = $userinfo[0]['f_name_malek3'];
            }
        } else {
            return false;
        }
        return $res;
    }
    public static function getSubInfoBySessionType($id = false)
    {
        //old name = userInfoByUserType
        switch ($_SESSION['user_type']) {
            case __ADMINUSERTYPE__:
            case __ADMINOPERATORUSERTYPE__:
                if ($id) {
                    $sql = "SELECT * FROM bnm_subscribers WHERE id= ?";
                    $res = Db::secure_fetchall($sql, [$id]);
                } else {
                    $res = false;
                }
                break;
            case __MODIRUSERTYPE__:
            case __MODIR2USERTYPE__:
            case __OPERATOR2USERTYPE__:
            case __OPERATORUSERTYPE__:
                if ($id) {
                    $sql = "SELECT * FROM bnm_subscribers WHERE id= ? AND branch_id = ?";
                    $res = Db::secure_fetchall($sql, [$id, $_SESSION['branch_id']]);
                } else {
                    $res = false;
                }
                break;
            case __MOSHTARAKUSERTYPE__:
                $sql = "SELECT * FROM bnm_subscribers WHERE id= ?";
                $res = Db::secure_fetchall($sql, [$_SESSION['user_id']]);
                break;
            default:
                return false;
                break;
        }
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }
    public static function Select_By_Id($table_name = false, $id = false)
    {
        if ($table_name && $id) {
            $sql = "SELECT * FROM {$table_name} WHERE id=?";
            $res = Db::secure_fetchall($sql, array($id));
            return $res;
        } else {
            return false;
        }
    }
    public static function Select_By_Multiple_Params($table_name = false, $params = false)
    {
        if ($table_name && $params && count($params) > 0) {
            $keys = array_keys($params);
            $sql = "SELECT * FROM {$table_name} WHERE ";
            for ($i = 0; $i < count($keys); $i++) {
                if ($i === count($params) - 1) {
                    $sql .= "{$keys[$i]}" . '=' . '?';
                } else {
                    $sql .= "{$keys[$i]}" . '=' . '?' . ' AND ';
                }
            }
            die($sql);
            $res = Db::secure_fetchall($sql, $params, true);
            return $res;
        } else {
            return false;
        }
    }
    public static function smsTimestampToDate($result)
    {
        for ($i = 0; $i < count($result['messages']); $i++) {
            $result['messages'][$i]['timestamp'] = self::timestampToDateTime($result['messages'][$i]['timestamp']);
            $datetime = new DateTime($result['messages'][$i]['timestamp']);
            $date = $datetime->format('Y-m-d');
            $time = $datetime->format('H:i:s');
            $date_arr = array();
            $date_arr = explode("-", $date);
            $date = self::gregorian_to_jalali($date_arr[0], $date_arr[1], $date_arr[2], '-');
            $result['messages'][$i]['timestamp'] = $date . ' ' . $time;
        }
        return $result;
    }
    public static function Send_Sms_Single($reciever_number, $msg = '', $date = null)
    {
        if (self::Is_Empty_OR_Null($reciever_number)) {
            $client = new nusoap_client(__SMSWEBSERVICEURL__);
            $client->decodeUTF8(false);
            $arr = array(
                'username' => __SMSUSERNAME__,
                'password' => __SMSPASSWORD__,
                'to' => $reciever_number,
                'from' => __SMSNUMBER__,
                'message' => $msg,
                'send_time' => $date, // set this parameter to null if you dont want to schedule message
            );
            $res = $client->call('send', $arr);
            if (!$res) {
                return false;
            }
            $client = null;
            if (is_array($res) && isset($res['status']) && $res['status'] === 0) {
                return $res;
            } elseif (is_array($res) && isset($res['status']) && $res['status'] !== 0) {
                return $res;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public static function addZeroToNumber($number, $type = 'array')
    {
        if ($type === 'array') {
            $res = array();
            foreach ($number as $row) {
                $row = '0' . (string) $row;
                array_push($res, $row);
            }
            return $res;
        } elseif ($type === 'string') {
            $number = '0' . (string) $number;
            return $number;
        }
    }
    public static function multiSend($to, string $msg, $send_time = null, $check_duplicate = null, $udh = null)
    {
        $client = new nusoap_client(__SMSWEBSERVICEURL__);
        $client->decodeUTF8(false);
        $arr = array(
            'username' => __SMSUSERNAME__,
            'password' => __SMSPASSWORD__,
            'to' => $to,
            'from' => __SMSNUMBER__,
            'message' => $msg,
            'send_time' => $send_time, // set this parameter to null if you dont want to schedule message
            'check_duplicate' => $check_duplicate, // set this parameter to null if you dont want to schedule message
            'udh' => $udh, // set this parameter to null if you dont want to schedule message
        );
        $res = $client->call('multiSend', $arr);
        return $res;
        $client = null;

        if ($res && is_array($res) && isset($res['status']) && $res['status'] === 0) {
            //success
            return $res;
        } elseif (is_array($res)) {
            //error message message not sent for some reason
            return $res;
        } else {
            //programming error
            return false;
        }
    }
    public static function checkSmsResult($result)
    {
        if (isset($result)) {
            if ($result) {
                if (is_array($result) && isset($result['status'])) {
                    if ($result['status'] === 0) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public static function getMessages($fromId = false)
    {
        $client = new nusoap_client(__SMSWEBSERVICEURL__);
        $client->decodeUTF8(false);
        $arr = array(
            'username' => __SMSUSERNAME__,
            'password' => __SMSPASSWORD__,
            'fromId' => $fromId,
        );
        $result = $client->call('getMessages', $arr);
        $client = null;
        if (self::checkSmsResult($result)) {
            return $result;
        } else {
            return false;
        }
    }
    public static function getNewMessages()
    {
        $client = new nusoap_client(__SMSWEBSERVICEURL__);
        $client->decodeUTF8(false);
        $arr = array(
            'username' => __SMSUSERNAME__,
            'password' => __SMSPASSWORD__,
        );
        $result = $client->call('getMessages', $arr);
        $client = null;
        return $result;
        // if (is_array($result) && isset($result['status']) && $result['status'] === 0) {
        // echo $result['count'] . "messages successfully received.<br />";
        // var_dump($result['messages']);
        // } elseif (is_array($result)) {
        // echo "Error: ".@$result['status_message'];
        // } else {
        // echo $client->getError();
    }
    public static function changeReceiveURL()
    {
        $client = new nusoap_client(__SMSWEBSERVICEURL__);
        $client->decodeUTF8(false);
        $arr = array(
            'username' => __SMSUSERNAME__,
            'password' => __SMSPASSWORD__,
            'receive_url' => __SMSRECEIVEURL__,
        );
        $result = $client->call('changeReceiveURL', $arr);
        $client = null;
        return $result;
        // if ($result && is_array($result) && isset($result['status']) && $result['status'] === 0) {
        //     //success
        //     return $result;
        // } elseif (is_array($result)) {
        //     //error message message not sent for some reason
        //     return $result;
        // } else {
        //     //programming error
        //     return false;
        // }
    }
    public static function accountInfo()
    {
        $client = new nusoap_client(__SMSWEBSERVICEURL__);
        $client->decodeUTF8(false);
        $arr = array(
            'username' => __SMSUSERNAME__,
            'password' => __SMSPASSWORD__,
        );
        $res = $client->call('accountInfo', $arr);
        $client = null;
        return $res;
    }
    public static function getSentMessages($fromId = '')
    {
        $client = new nusoap_client(__SMSWEBSERVICEURL__);
        $client->decodeUTF8(false);
        $arr = array(
            'username' => __SMSUSERNAME__,
            'password' => __SMSPASSWORD__,
            'fromId' => $fromId,
        );
        $res = $client->call('getSentMessages', $arr);
        $client = null;
        return $res;
        if ($res && is_array($res) && isset($res['status']) && $res['status'] === 0) {
            //success
            return $res;
        } elseif (is_array($res)) {
            //error message message not sent for some reason
            return $res;
        } else {
            //programming error
            return false;
        }
    }
    public static function smsMessagesDateChange($result)
    {
        for ($i = 0; $i < count($result['messages']); $i++) {
            $result['messages'][$i]['timestamp'] = self::timestampToDateTime($result['messages'][$i]['timestamp']);
            $datetime = new DateTime($result['messages'][$i]['timestamp']);
            $date = $datetime->format('Y-m-d');
            $time = $datetime->format('H:i:s');
            $date_arr = array();
            $date_arr = explode("-", $date);
            $date = self::gregorian_to_jalali($date_arr[0], $date_arr[1], $date_arr[2], '-');
            $result['messages'][$i]['timestamp'] = $date . ' ' . $time;
        }
        return $result;
    }
    public static function getSentMessagesByTime($date = false)
    {

        if (!$date) {
            $date = strtotime(date('Y-m-d 00:00:00'));
        } else {
            $date = strtotime($date);
        }
        $client = new nusoap_client(__SMSWEBSERVICEURL__);
        $client->decodeUTF8(false);
        $arr = array(
            'username' => __SMSUSERNAME__,
            'password' => __SMSPASSWORD__,
            'fromTime' => $date,
        );
        $res = $client->call('getSentMessagesByTime', $arr);
        $client = null;
        if (self::checkSmsResult($res)) {
            return $res;
        } else {
            return false;
        }
    }
    public static function Write_In_Sms_Request($receiver, $start_date, $end_date, $receiver_type, $message_id)
    {
        $arr = array();
        $arr['receiver'] = $receiver;
        $arr['start_date'] = $start_date;
        $arr['end_date'] = $end_date;
        $arr['receiver_type'] = $receiver_type;
        $arr['message_id'] = $message_id;
        // $arr['message_type']  = $message_type;
        $sql = self::Insert_Generator($arr, 'bnm_send_sms_requests');
        return Db::secure_insert_array($sql, $arr);
    }
    public static function Write_In_Sms_Queue($res)
    {
        $sql = self::Insert_Generator($res, 'bnm_sms_queue');
        return Db::secure_insert_array($sql, $res);
    }
    public static function Send_Sms_Multi_Send($arr_number, $msg = '', $date = null)
    {
        if (is_array($arr_number)) {
            $client = new nusoap_client(__SMSWEBSERVICEURL__);
            $client->decodeUTF8(false);
            $arr = array(
                'username' => __SMSUSERNAME__,
                'password' => __SMSPASSWORD__,
                'to' => $arr_number,
                'from' => __SMSNUMBER__,
                'message' => $msg,
                'send_time' => $date, // set this parameter to null if you dont want to schedule message
            );
            $res = $client->call('multiSend', $arr);
            if ($res && is_array($res) && isset($res['status']) && $res['status'] === 0) {
                //success
                return $res;
            } elseif (is_array($res)) {
                //error message
                return $res;
            } else {
                //programming error
                return false;
            }
        } else {
            return false;
        }
    }
    public static function Auto_Unset_By_Tbl_Name($data, $table_name = false)
    {
        if ($table_name) {
            $tbl_cols = Db::Get_Column_Names($table_name);
            //$valid_requests = array('noe_payam', 'onvane_payam', 'matne_payam');
            foreach ($data as $key => $value) {
                if (!in_array($key, $tbl_cols)) {
                    unset($data[$key]);
                }
            }
            return $data;
        } else {
            return false;
        }
    }
    public static function Manual_Unset_Array($data, $valid_requests = false)
    {
        if ($valid_requests) {
            foreach ($data as $key => $value) {
                if (!in_array($key, $valid_requests)) {
                    unset($data[$key]);
                }
            }
            return $data;
        } else {
            return false;
        }
    }
    public static function Unset_IN_Array(array $data, array $unset_properties)
    {
        if ($unset_properties) {
            foreach ($data as $key => $value) {
                if (in_array($key, $unset_properties)) {
                    unset($data[$key]);
                }
            }
            return $data;
        } else {
            return false;
        }
    }
    public static function Exc_Error_Debug($e, $print = false, $printdelimiter = '', $printkey = false)
    {
        $res = array();
        array_push($res, "Error Message: " . $e->getMessage());
        array_push($res, "Error File: " . $e->getFile());
        array_push($res, "Error Code: " . $e->getCode());
        array_push($res, "Error Line: " . $e->getLine());
        array_push($res, "Error Previous: " . $e->getPrevious());
        array_push($res, $e->getTrace());
        array_push($res, "Error TraceAsString: " . $e->getTraceAsString());
        if ($print) {
            self::Print_Array( /*array*/$res, /*delimiter*/ $printdelimiter, /*keyprint*/ $printkey);
        } else {
            return $res;
        }
    }
    public static function Print_Array($variable, $delimiter = ' ', $k = false)
    {
        if ($k) {
            foreach ($variable as $key => $val) {
                if (is_array($val)) {
                    echo $key . $delimiter . "<br/>";
                    print_r($val);
                    echo "<br/>";
                } else {
                    echo $key . $delimiter . $val . "<br/>";
                }
            }
        } else {
            foreach ($variable as $key => $val) {
                if (is_array($val)) {
                    print_r($val);
                    echo "<br/>";
                } else {
                    echo $delimiter . $val . "<br/>";
                }
            }
        }
    }
    public static function Exc_Pretty_Error($e, $encode = false)
    {
        $result = array();
        $result['msg'] = 'Error on file-> ' . $e->getMessage();
        $result['Error'] = 'برنامه با مشکل مواجه شده است';
        if ($encode) {
            return self::Tojson($result);
        } else {
            return $result;
        }
    }
    public static function Tojson($data)
    {
        return json_encode($data);
    }
    public static function getor_string($data, $param = "")
    {
        if (!$data || $data === "" || $data === " " || $data === null || $data === 'null' || $data === 'NULL' || $data === 'undefined') {
            return $param;
        } else {
            return $data;
        }
    }

    public static function Fix_Date_Seperator($string)
    {
        //eslahe joda konande tarikh be slash (/)
        $string = str_replace("-", "/", $string);
        $string = str_replace("+", "/", $string);
        $string = str_replace(".", "/", $string);
        $string = str_replace("|", "/", $string);
        $string = str_replace("*", "/", $string);
        return $string = str_replace("\\", "/", $string);
    }
    public static function Replace_In_String(String $string, $search_char = '-', $replace_char = '')
    {
        return str_replace($search_char, $replace_char, $string);
        // return $string = str_replace("\\", "/", $string);
    }
    public static function check_user_has_access_or_not($controllerName)
    {
        $controllerName = strtolower($controllerName);
        switch ($_SESSION['user_type']) {
            case __ADMINUSERTYPE__:
                return true;
                break;
            case __MODIRUSERTYPE__:
            case __OPERATORUSERTYPE__:
            case __MODIR2USERTYPE__:
            case __OPERATOR2USERTYPE__:
                $where_menu_ids = "";
                $menu_access = Db::secure_fetchall("SELECT * FROM bnm_dashboard_menu_access WHERE operator_id = ? AND user_type = ?", array($_SESSION['user_id'], $_SESSION['user_type']));
                for ($i = 0; $i < count($menu_access); $i++) {
                    if ($i == count($menu_access) - 1) {
                        $where_menu_ids .= $menu_access[$i]['menu_id'];
                    } else {
                        $where_menu_ids .= $menu_access[$i]['menu_id'] . ',';
                    }
                }
                $flag = false;
                $dashboard_access_list = Db::fetchall_Query("SELECT id,en_name FROM bnm_dashboard_menu WHERE id IN ($where_menu_ids) AND en_name='$controllerName' AND (branch_display=1 OR branch2_display=1)");
                if ($dashboard_access_list && $dashboard_access_list[0] && $dashboard_access_list[0]['en_name'] == $controllerName) {
                    return true;
                } else {
                    return false;
                }
                break;
            case __ADMINOPERATORUSERTYPE__:
                $controllerName = strtolower($controllerName);
                $where_menu_ids = "";
                $menu_access = Db::secure_fetchall("SELECT * FROM bnm_dashboard_menu_access WHERE operator_id = ?", array($_SESSION['id']));
                for ($i = 0; $i < count($menu_access); $i++) {
                    if ($i == count($menu_access) - 1) {
                        $where_menu_ids .= $menu_access[$i]['menu_id'];
                    } else {
                        $where_menu_ids .= $menu_access[$i]['menu_id'] . ',';
                    }
                }
                $flag = false;
                $dashboard_access_list = Db::fetchall_Query("SELECT id,en_name FROM bnm_dashboard_menu WHERE id IN ($where_menu_ids) AND en_name='$controllerName' AND admin_operator_display=1");
                if ($dashboard_access_list && $dashboard_access_list[0] && $dashboard_access_list[0]['en_name'] == $controllerName) {
                    return true;
                } else {
                    return false;
                }
                break;
            case __MOSHTARAKUSERTYPE__:
                //customer || subscriber
                $sql = "SELECT id,fa_name,en_name,subscriber_display FROM bnm_dashboard_menu WHERE en_name=? AND subscriber_display=?";
                $res = Db::secure_fetchall($sql, array($controllerName, 1));
                if ($res && $res[0] && $res[0]['en_name'] == $controllerName) {
                    return true;
                } else {
                    return false;
                }
                break;
            default:
                return false;
                break;
        }
    }
    public static function check_add_access(string $controllerName)
    {
        switch ($_SESSION['user_type']) {
            case __ADMINUSERTYPE__:
                return true;
                break;
            case __ADMINOPERATORUSERTYPE__:
                $controllerName = strtolower($controllerName);
                $sql = "SELECT ad.id add_id,ad.operator_id,ad.user_type FROM bnm_dashboard_menu d
                INNER JOIN bnm_dashboard_menu_add ad
                ON d.id=ad.menu_id
                WHERE d.en_name = ? AND ad.operator_id = ? AND ad.user_type = ?
                AND (ad.menu_id IS NOT NULL OR ad.menu_id <> '')
                AND (ad.operator_id IS NOT NULL OR ad.operator_id <> '')
                AND (ad.user_type IS NOT NULL OR ad.user_type <> '')";
                $res = Db::secure_fetchall($sql, array($controllerName, $_SESSION['user_id'], $_SESSION['user_type']));
                break;
            case __OPERATORUSERTYPE__:
            case __MODIRUSERTYPE__:
            case __MODIR2USERTYPE__:
            case __OPERATOR2USERTYPE__:
                $controllerName = strtolower($controllerName);
                $sql = "SELECT ad.id add_id,ad.operator_id,ad.user_type  FROM bnm_dashboard_menu d INNER JOIN bnm_dashboard_menu_add ad
                ON d.id=ad.menu_id
                WHERE d.en_name = ? AND ad.operator_id = ? AND ad.user_type = ?
                AND (ad.menu_id IS NOT NULL OR ad.menu_id <> '')
                AND (ad.operator_id IS NOT NULL OR ad.operator_id <> '')
                AND (ad.user_type IS NOT NULL OR ad.user_type <> '')";
                $res = Db::secure_fetchall($sql, array($controllerName, $_SESSION['user_id'], $_SESSION['user_type']));
                break;
            default:
                return false;
                break;
        }
        if ($res) {
            if (isset($res[0]['add_id']) && isset($res[0]['operator_id']) && isset($res[0]['user_type'])) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public static function check_update_access(string $controllerName)
    {
        switch ($_SESSION['user_type']) {
            case __ADMINUSERTYPE__:
                return true;
                break;
            case __ADMINOPERATORUSERTYPE__:
            case __OPERATORUSERTYPE__:
            case __MODIRUSERTYPE__:
            case __MODIR2USERTYPE__:
            case __OPERATOR2USERTYPE__:
                $controllerName = strtolower($controllerName);
                $sql = "SELECT e.id add_id,e.operator_id,e.user_type FROM bnm_dashboard_menu d
                INNER JOIN bnm_dashboard_menu_edit e
                ON d.id=e.menu_id
                WHERE d.en_name = ? AND e.operator_id = ? AND e.user_type = ?
                AND (e.menu_id IS NOT NULL OR e.menu_id <> '')
                AND (e.operator_id IS NOT NULL OR e.operator_id <> '')
                AND (e.user_type IS NOT NULL OR e.user_type <> '')";
                $res = Db::secure_fetchall($sql, array($controllerName, $_SESSION['user_id'], $_SESSION['user_type']));
                break;
            default:
                return false;
                break;
        }
        if ($res) {
            if (isset($res[0]['add_id']) && isset($res[0]['operator_id']) && isset($res[0]['user_type'])) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public static function check_delete_access(string $controllerName)
    {
        switch ($_SESSION['user_type']) {
            case __ADMINUSERTYPE__:
                return true;
                break;
            case __ADMINOPERATORUSERTYPE__:
            case __OPERATORUSERTYPE__:
            case __MODIRUSERTYPE__:
            case __MODIR2USERTYPE__:
            case __OPERATOR2USERTYPE__:
                $controllerName = strtolower($controllerName);
                $sql = "SELECT e.id add_id,e.operator_id,e.user_type FROM bnm_dashboard_menu d
                INNER JOIN bnm_dashboard_menu_edit e
                ON d.id=e.menu_id
                WHERE d.en_name = ? AND e.operator_id = ? AND e.user_type = ?
                AND (e.menu_id IS NOT NULL OR e.menu_id <> '')
                AND (e.operator_id IS NOT NULL OR e.operator_id <> '')
                AND (e.user_type IS NOT NULL OR e.user_type <> '')";
                $res = Db::secure_fetchall($sql, array($controllerName, $_SESSION['user_id'], $_SESSION['user_type']));
                break;
            default:
                return false;
                break;
        }
        if ($res) {
            if (isset($res[0]['add_id']) && isset($res[0]['operator_id']) && isset($res[0]['user_type'])) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function Create_Post_Array_Without_Key($data)
    {
        $key = key($data);
        $res = [];
        for ($i = 0; $i < count($data[$key]); $i++) {
            $res[$data[$key][$i]['name']] = $data[$key][$i]['value'];
        }
        // foreach ($data as $k => $v) {
        //     if($v)
        // }

        return $res;
    }

    public static function reformAjaxRequest($data)
    {
        $key = key($data);
        $res = array();
        $res = $data[$key];
        return $res;
    }

    public static function xss_check_array($arraydata)
    {
        $keys = array_keys($arraydata);
        $key = key($arraydata);
        for ($i = 0; $i < count($keys); $i++) {
            $arraydata[$keys[$i]] = trim($arraydata[$keys[$i]]);
            $arraydata[$keys[$i]] = stripslashes($arraydata[$keys[$i]]);
            $arraydata[$keys[$i]] = htmlspecialchars($arraydata[$keys[$i]]);
        }
        return $arraydata;
    }
    public static function Filter_Post_Input()
    {
        $array = filter_input_array(INPUT_POST);
        $newArray = array();
        foreach (array_keys($array) as $fieldKey) {
            foreach ($array[$fieldKey] as $key => $value) {
                $newArray[$key][$fieldKey] = $value;
            }
        }
        return $newArray;
    }

    public static function getOssReserveWaitingActive()
    {
        switch ($_SESSION['user_type']) {
            case __ADMINUSERTYPE__:
            case __ADMINOPERATORUSERTYPE__:
                $sql = "SELECT
                sub.id sub_rowid,
                res.id res_rowid,
                oss.id oss_rowid,
                res.resid oss_resid,
                oss.oss_id oss_subid,
                sub.name name,
                sub.f_name f_name,
                res.ranzhe,
                res.jamavari,
                IF(oss.telephone = 1,sub.telephone1,IF(oss.telephone = 2,sub.telephone2,IF( oss.telephone = 3, sub.telephone3, 'شماره ایی ثبت نشده' ))) telephonenumber
                FROM
                bnm_oss_reserves res
                INNER JOIN bnm_oss_subscribers oss ON res.oss_id = oss.id
                INNER JOIN bnm_subscribers sub ON oss.user_id = sub.id
                WHERE res.ranzhe <> 1
                AND res.laghv <> 1
                AND res.jamavari <> 1
                AND res.reservetime >= CURRENT_DATE()
                GROUP BY oss.user_id, oss.telephone ORDER BY res.tarikhe_darkhast DESC";
                $res = Db::fetchall_Query($sql);
                break;
            case __MODIRUSERTYPE__:
            case __OPERATORUSERTYPE__:
            case __MODIR2USERTYPE__:
            case __OPERATOR2USERTYPE__:
                $sql = "SELECT
                sub.id sub_rowid,
                res.id res_rowid,
                oss.id oss_rowid,
                res.resid oss_resid,
                oss.oss_id oss_subid,
                sub.name name,
                sub.f_name f_name,
                res.ranzhe,
                res.jamavari,
            IF(oss.telephone = 1,sub.telephone1,IF(oss.telephone = 2,sub.telephone2,IF( oss.telephone = 3, sub.telephone3, 'شماره ایی ثبت نشده' ))) telephonenumber
            FROM
                bnm_oss_reserves res
                INNER JOIN bnm_oss_subscribers oss ON res.oss_id = oss.id
                INNER JOIN bnm_subscribers sub ON oss.user_id = sub.id
                WHERE res.ranzhe <> 1
                AND res.laghv <> 1
                AND res.jamavari <> 1
                AND res.reservetime >= CURRENT_DATE() AND sub.branch_id = ?
                GROUP BY oss.user_id, oss.telephone ORDER BY res.tarikhe_darkhast DESC";
                $res = Db::secure_fetchall($sql, array($_SESSION['branch_id']), true);
                break;
            default:
                return false;
                break;
        }
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }
    public static function getOssReserveWaitingActiveBySubid($subid)
    {
        switch ($_SESSION['user_type']) {
            case __ADMINUSERTYPE__:
            case __ADMINOPERATORUSERTYPE__:
                $sql = "SELECT
                sub.id sub_rowid,
                res.id res_rowid,
                oss.id oss_rowid,
                res.resid oss_resid,
                oss.oss_id oss_subid,
                sub.name name,
                sub.f_name f_name,
                res.ranzhe,
                res.jamavari,
            IF(oss.telephone = 1,sub.telephone1,IF(oss.telephone = 2,sub.telephone2,IF( oss.telephone = 3, sub.telephone3, 'شماره ایی ثبت نشده' ))) telephonenumber
            FROM
                bnm_oss_reserves res
                INNER JOIN bnm_oss_subscribers oss ON res.oss_id = oss.id
                INNER JOIN bnm_subscribers sub ON oss.user_id = sub.id
                WHERE res.ranzhe <> 1
                AND res.laghv <> 1
                AND res.jamavari <> 1
                AND res.reservetime >= CURRENT_DATE() AND sub.id = ?
                GROUP BY oss.user_id, oss.telephone ORDER BY res.tarikhe_darkhast DESC";
                $res = Db::secure_fetchall($sql, [$subid]);
                break;
            case __MODIRUSERTYPE__:
            case __OPERATORUSERTYPE__:
            case __MODIR2USERTYPE__:
            case __OPERATOR2USERTYPE__:
                $sql = "SELECT
                sub.id sub_rowid,
                res.id res_rowid,
                oss.id oss_rowid,
                res.resid oss_resid,
                oss.oss_id oss_subid,
                sub.name name,
                sub.f_name f_name,
                res.ranzhe,
                res.jamavari,
            IF(oss.telephone = 1,sub.telephone1,IF(oss.telephone = 2,sub.telephone2,IF( oss.telephone = 3, sub.telephone3, 'شماره ایی ثبت نشده' ))) telephonenumber
            FROM
                bnm_oss_reserves res
                INNER JOIN bnm_oss_subscribers oss ON res.oss_id = oss.id
                INNER JOIN bnm_subscribers sub ON oss.user_id = sub.id
                WHERE res.ranzhe <> 1
                AND res.laghv <> 1
                AND res.jamavari <> 1
                AND res.reservetime >= CURRENT_DATE() AND sub.branch_id = ? AND sub.id = ?
                GROUP BY oss.user_id, oss.telephone ORDER BY res.tarikhe_darkhast DESC";
                $res = Db::secure_fetchall($sql, array($_SESSION['branch_id'], $subid), true);
                break;
            case __OPERATOR2USERTYPE__:
                $sql = "SELECT
                sub.id sub_rowid,
                res.id res_rowid,
                oss.id oss_rowid,
                res.resid oss_resid,
                oss.oss_id oss_subid,
                sub.name name,
                sub.f_name f_name,
                res.ranzhe,
                res.jamavari,
            IF(oss.telephone = 1,sub.telephone1,IF(oss.telephone = 2,sub.telephone2,IF( oss.telephone = 3, sub.telephone3, 'شماره ایی ثبت نشده' ))) telephonenumber
            FROM
                bnm_oss_reserves res
                INNER JOIN bnm_oss_subscribers oss ON res.oss_id = oss.id
                INNER JOIN bnm_subscribers sub ON oss.user_id = sub.id
                WHERE res.ranzhe <> 1
                AND res.laghv <> 1
                AND res.jamavari <> 1
                AND res.reservetime >= CURRENT_DATE() AND sub.id = ?
                GROUP BY oss.user_id, oss.telephone ORDER BY res.tarikhe_darkhast DESC";
                $res = Db::secure_fetchall($sql, array($_SESSION['user_id']), true);
                break;
            default:
                return false;
                break;
        }
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }

    public static function getOssActiveReserveBySubid($subid)
    {
        switch ($_SESSION['user_type']) {
            case __ADMINUSERTYPE__:
            case __ADMINOPERATORUSERTYPE__:
                $sql = "SELECT
                sub.id sub_rowid,
                res.id res_rowid,
                oss.id oss_rowid,
                res.resid oss_resid,
                oss.oss_id oss_subid,
                sub.name name,
                sub.f_name f_name,
                res.ranzhe,
                res.jamavari,
            IF(oss.telephone = 1,sub.telephone1,IF(oss.telephone = 2,sub.telephone2,IF( oss.telephone = 3, sub.telephone3, 'شماره ایی ثبت نشده' ))) telephonenumber
            FROM
                bnm_oss_reserves res
                INNER JOIN bnm_oss_subscribers oss ON res.oss_id = oss.id
                INNER JOIN bnm_subscribers sub ON oss.user_id = sub.id
                WHERE res.ranzhe = ?
                AND res.laghv <> 1
                AND res.jamavari <> 1
                AND sub.id = ?
                GROUP BY oss.user_id, oss.telephone ORDER BY res.tarikhe_darkhast DESC";
                $res = Db::secure_fetchall($sql, [1, $subid]);
                break;
            case __MODIRUSERTYPE__:
            case __OPERATORUSERTYPE__:
            case __MODIR2USERTYPE__:
            case __OPERATOR2USERTYPE__:
                $sql = "SELECT
                sub.id sub_rowid,
                res.id res_rowid,
                oss.id oss_rowid,
                res.resid oss_resid,
                oss.oss_id oss_subid,
                sub.name name,
                sub.f_name f_name,
                res.ranzhe,
                res.jamavari,
            IF(oss.telephone = 1,sub.telephone1,IF(oss.telephone = 2,sub.telephone2,IF( oss.telephone = 3, sub.telephone3, 'شماره ایی ثبت نشده' ))) telephonenumber
            FROM
                bnm_oss_reserves res
                INNER JOIN bnm_oss_subscribers oss ON res.oss_id = oss.id
                INNER JOIN bnm_subscribers sub ON oss.user_id = sub.id
                WHERE res.ranzhe = ?
                AND res.laghv <> 1
                AND res.jamavari <> 1
                AND sub.branch_id = ? AND sub.id = ?
                GROUP BY oss.user_id, oss.telephone ORDER BY res.tarikhe_darkhast DESC";
                $res = Db::secure_fetchall($sql, array(1, $_SESSION['branch_id'], $subid), true);
                break;
            case __MOSHTARAKUSERTYPE__:
                $sql = "SELECT
                sub.id sub_rowid,
                res.id res_rowid,
                oss.id oss_rowid,
                res.resid oss_resid,
                oss.oss_id oss_subid,
                sub.name name,
                sub.f_name f_name,
                res.ranzhe,
                res.jamavari,
            IF(oss.telephone = 1,sub.telephone1,IF(oss.telephone = 2,sub.telephone2,IF( oss.telephone = 3, sub.telephone3, 'شماره ایی ثبت نشده' ))) telephonenumber
            FROM
                bnm_oss_reserves res
                INNER JOIN bnm_oss_subscribers oss ON res.oss_id = oss.id
                INNER JOIN bnm_subscribers sub ON oss.user_id = sub.id
                WHERE res.ranzhe = ?
                AND res.laghv <> 1
                AND res.jamavari <> 1
                AND sub.id = ?
                GROUP BY oss.user_id, oss.telephone ORDER BY res.tarikhe_darkhast DESC";
                $res = Db::secure_fetchall($sql, [1, $_SESSION['user_id']]);
                break;
            default:
                return false;
                break;
        }
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }
    // public static function checkServiceLockStatus($subid, $servicetype, $emkanatid, $status= 1){
    //     if((int) $status===1){
    //         $sql="SELECT count(*) rowsnum FROM bnm_suspensions WHERE servicetype= ? AND subid = ? AND emkanatid = ? AND lockstatus = ? AND tarikhe_unlock > CURRENT_TIMESTAMP";
    //         $check=Db::secure_fetchall($sql, [$servicetype, $subid, $emkanatid, $status]);
    //     }elseif((int) $status===2){
    //         $sql="SELECT count(*) rowsnum FROM bnm_suspensions WHERE servicetype= ? AND subid = ? AND emkanatid = ? AND lockstatus = ? AND tarikhe_unlock > CURRENT_TIMESTAMP";
    //         $check=Db::secure_fetchall($sql, [$servicetype, $subid, $emkanatid, $status]);
    //     }
    // }
    public static function isUserLocked($subid, $servicetype, $emkanatid)
    {
    }

    public static function isUserUnlocked($subid, $servicetype, $emkanatid)
    {
    }

    public static function logout()
    {
        unset($_SESSION['login']);
        unset($_SESSION['username']);
        unset($_SESSION['password']);
        unset($_SESSION['user_type']);
        unset($_SESSION['branch_id']);
        unset($_SESSION['user_id']);
    }
    public static function Add_Or_Minus_Day_To_Date($rooz, $add_minus = '+', $date = false, $seprate_date_by = ' ')
    {
        $rooz = (string) $rooz;
        if (!$date) {
            return date('Y-m-d', strtotime(date('Y-m-d') . $add_minus . $rooz . ' days'));
        } else {
            //todo...
            $arr_datetime = explode($seprate_date_by, $date);
            if (!isset($arr_datetime[0])) {
                return false;
            }
            $newdate = date('Y-m-d', strtotime($arr_datetime[0] . $add_minus . $rooz . ' days'));
            $newdate .= " " . $arr_datetime[1];
            return $newdate;


            return false;
        }
    }
    public static function checkmydate($date, $format = 'Y-m-d')
    {
        // $tempDate = explode('-', $date);
        // // checkdate(month, day, year)
        // return checkdate($tempDate[1], $tempDate[2], $tempDate[0]);
        //////////////////function2
        // return (bool)strtotime($date);
        //////////////////function3
        $d = DateTime::createFromFormat($format, $date);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && $d->format($format) === $date;
    }
    public static function Operator_Has_Access_To_User($user_id)
    {
        if (self::Is_Empty_OR_Null($user_id)) {
            //$user_id=(int)$user_id;
            if (is_numeric($user_id)) {
                $sql = "SELECT id FROM bnm_subscribers WHERE id=?";
                $res = Db::secure_fetchall($sql, array($user_id));
                if ($res) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return self::Json_Message('info_not_true');
            }
        } else {
            return self::Json_Message('info_not_true');
        }
    }
    public static function Is_Empty_OR_Null($data)
    {
        if (isset($data) && $data !== '' && $data !== 'empty' && $data !== null && $data !== 'null' && $data !== 'NULL' && $data !== 'Null' && $data !== 'undefiend') {
            return true;
        } else {
            return false;
        }
    }
    public static function Json_Message($msg_code = 'f')
    {
        $msg = '';
        $msg = self::Messages($msg_code);
        return json_encode(array('Error' => $msg), JSON_UNESCAPED_UNICODE);
    }
    public static function Messages($message_code)
    {
        switch ($message_code) {

            case 'nf':
            case 'nothingfound':
                return "موردی یافت نشد.";
                break;
            case 'pcae':
            case 'pleasechooseanelement':
                return "لطفا یک مورد را انتخاب کنید";
                break;
            case 'absnr':
            case 'asiatechbitstreamnoresponse':
                return "پیامی دریافت نشد";
                break;
            case 'subauthproblem':
            case 'sap':
                return 'احراز هویت مشترک موفق نبوده پس از بررسی و تکمیل اطلاعات هویتی مشترک مجددا تلاش کنید';
                break;
            case 'sanf':
            case 'subauthshahkarnotfound':
                return "استعلام احراز هویت مشترک یاقت نشد پس از بررسی مجددا تلاش کنید.";
                break;
            case 'siescne':
            case 'sub_ibs_exist_sub_crmn_exist':
                return 'اطلاعات مشترک در اکانتینگ قبلا وجود دارد ولی در سامانه یافت نشد لطفا با پشتیبانی تماس بگیرید.';
                break;
            case 'contractsmssent':
            case 'css':
                return 'پیامک تایید قرارداد برای شما ارسال شد لطفا کد ارسال شده را درج نمایید.';
                break;
            case 'inf':
            case 'informationnotfound':
                return '.اطلاعات لازم برای انجام درخواست یافت نشد';
                break;
            case 'ipnip':
            case 'ipnotinpool':
                return 'آیپی شما جزو رنج آیپی های این مجموعه نمیباشد اگر از فیلتر شکن استفاده میکنید آنرا خاموش کرده و مجددا تلاش کنید .';
                break;
            case 'newpasswordandconfirmfault':
            case 'npacf':
                return 'رمز جدید و تاییدیه آن یکسان نیست لطفا مجددا تلاش کنید';
                break;
            case 'codeiswrong':
            case 'ciw':
                return 'کد وارد شده صحیح نیست لطفا مجددا تلاش کنید.';
                break;
            case 'cas':
            case 'contract_already_signed':
                return 'این قرارداد قبلا تایید شده';
                break;
            case 'aof':
            case 'accounting_operation_failed':
                return 'عملیات اکانتینگ با مشکل مواجه شده لطفا با پشتیبانی تماس گرفته و جهت رفع مشکل اطلاع رسانی کنید';
                break;
            case 'nodatafound':
            case 'ndf':
                return 'اطلاعاتی یافت نشد.';
                break;
            case 'confail':
            case 'connection_fail':
                return 'مشکل در ارتباط با سرور لطفا مجددا تلاش کنید';

                break;
            case 'baso':
            case 'buyadiserviceonly':
                return 'سرویس قبلی شما به اتمام رسیده فقط میتوانید سرویس های عادی را خریداری کنید.';
                break;
            case 'bbso':
            case 'buybulkserviceonly':
                return 'مدت سرویس فعلی شما تمام نشده و فقط میتوانید سرویسهای حجمی را خریداری کنید.';
                break;
            case 'ffcbb':
            case 'firstfactorcannotbebulk':
                return 'اولین سرویس نمیتواند حجمی باشد لطفا سرویس های عادی یا جشنواره را انتخاب نمایید. ';
                break;
            case 'fpbip':
            case 'factor_payed_but_ibs_problem':
                return 'مشکل در اعمال فاکتور در اکانتینگ لطفا با پشتیبانی تماس گرفته و جهت بررسی موضوع اطلاع رسانی کنید. ';
                break;
            case 'icf':
            case 'ibscreateuserfailed':
                return 'مشکل انجام عملیات کاربر در اکانتینگ لطفا با پشتیبانی تماس بگیرید.';
                break;
            case 'secnei':
            case 'notfoundinibs':
            case 'subexistcrmnotexistibs':
                return 'مشترک در سامانه یافت شد اما در اکانتینگ وجود ندارد.';
                break;
            case 'sinv':
            case 'subinfonotvalid':
                return 'اطلاعات مشترک صحیح نمیباشد';
                break;
            case 'pbp':
            case 'pay_before_print':
                return 'لطفا قبل از پرینت فاکتور از تسویه مبلغ آن اطمینان حاصل کنید.';
                break;
            case 'subscriberalreadycreated':
            case 'sac':
                return 'مشترک قبلا ساخته شده';
                break;
            case 'asiatechce':
            case 'asiatech_connection_error':
                return 'برقراری ارتباط با وب سرویس OSS برقرار نشد. ';
                break;
            case 'asiatechf':
            case 'asiatech_failure':
                return 'عملیات مورد نظر با وب سرویس OSS انجام نشد لطفا پس از بررسی مجددا تلاش کنید';
                break;
            case 'ule':
            case 'username_lenght_error':
                return 'حداقل طول نام کاربری 4 کاراکتر میباشد.';
                break;
            case 'ple':
            case 'password_lenght_error':
                return 'حداقل طول پسورد 4 کاراکتر میباشد.';
                break;

            case 'af':
            case 'auth_fail':
                return 'احراز هویت شما برای درخواست مورد نظر با مشکل مواجه شد.';
                break;
            case 'sae':
            case 'subalreadyexist':
                return 'اطلاعات مشترک در سامانه قبلا ثبت شده است.';
                break;
            case 'f':
            case 'failure':
                return 'انجام درخواست شما با مشکل مواجه شد.';
                break;
            case 'e':
            case 'E':
            case 'Error':
            case 'error':
                return 'خطای سیستمی مجددا تلاش کنید یا با پشتیبانی تماس بگیرید.';
                break;
            case 'smsnotsent':
            case 'sns':
                return 'مشکل در ارسال پیامک.';
                break;
            case 'smssent':
            case 'ss':
                return 'پیامک برای مشترک ارسال شد.';
                break;
            case 'servicealreadylocked':
                return 'سرویس قبلا مسدود شده.';
                break;
            case 'filenamealreadyexist':
            case 'fnae':
                return 'فایل با این نام قبلا ساخته شده';
                break;
            case 'filesizeexceed':
            case 'fse':
                return 'حجم فایل بیش از مقدار مجاز (100 مگابایت) است';
                break;
            case 'fileextentionnotvalid':
            case 'fenv':
                return 'پسوند فایل قابل پذیرش نیست';
                break;
            case 's':
            case 'success':
                return 'درخواست با موفقیت انجام شد.';
                break;
            case 'ffna':
            case 'seffna':
            case 'subscriber_enter_first_factor_not_allowed':
                return 'ثبت اولین فاکتور باید توسط شرکت انجام شود.';
                break;
            case 'tinf':
            case 'tnf':
            case 'tax_info_not_found':
                return 'اطلاعات مالیات و ارزش افزوده یافت نشد لطفا پس از بررسی مجددا تلاش کنید.';
                break;
            case 'required':
                return 'اطلاعات مالیات و ارزش افزوده با مشکل مواجه شد لطفا پس از بررسی مجددا تلاش کنید.';
                break;
            case 'ps':
            case 'pardakht_success':
                return 'عملیات پرداخت با موفقیت انجام شد.';
                break;
            case 'pns':
            case 'pardakht_not_success':
                return 'عملیات پرداخت با مشکل مواجه شد.';
                break;
            case 'snf':
            case 'service_not_found':
            case 'service_info_not_found':
                return 'اطلاعات سرویس مورد نظر جهت ادامه عملیات یافت نشد.';
                break;
            case 'sinr':
            case 'service_info_not_right':
                return 'اطلاعات سرویس به درستی ثبت نشده لطفا پس از بررسی دوباره تلاش کنید.';
                break;
            case 'uinr':
            case 'user_info_not_right':
                return 'اطلاعات کاربری مشترک مورد نظر بدرستی ثبت نشده بنابراین امکان ادامه عملیات مورد نظر وجود ندارد.';
                break;
            case 'ens':
            case 'emkanat_not_set':
                return 'امکاناتی برای سرویس مورد نظر یافت نشده.';
                break;
            case 'eaa':
            case 'emkanat_already_asigned':
                return 'امکانات مورد نظر برای مشترک فعال است.';
                break;
            case 'fde':
            case 'factor_date_exceeded':
                return 'تاریخ فاکتور شما برای پرداخت به پایان رسیده است لطفا مجددا فاکتور مورد نظر را ثبت کنید.';
                break;
            case 'fnofp':
            case 'factor_not_ok_for_pardakht':
                return 'شما نمیتوانید این فاکتور را پرداخت کنید لطفا بررسی کنید که تاریخ فاکتور برای امروز باشد یا قبلا پرداخت نشده است.';
                break;
            case 'factor_not_found':
            case 'fnf':
                return 'اطلاعات فاکتور مورد نظر یافت نشد و یا فاکتور معتبر نیست.';
                break;
            case 'fts':
            case 'factor_tasvie_shode':
                return 'فاکتور تسویه شد.';
                break;
            case 'file_nf':
            case 'file_n_f':
            case 'file_not_found':
                return 'فایل مورد نظر در پیگاه داده یافت نشد';
                break;
            case 'bank_nf':
            case 'bank_n_f':
            case 'bank_not_found':
                return 'بانک مورد نظر در پیگاه داده یافت نشد';
                break;
            case 'nu':
            case 'no_upload':
                return 'متاسفانه قادر به آپلود این فایل نیستیم';
                break;
            case 'fint':
            case 'factor_info_not_true':
                return 'اطلاعات فاکتور صحیح نمیباشد.';
                break;
            case 'nasf':
            case 'no_active_service_found':
                return 'سرویس فعالی از این نوع وجود ندارد';
                break;
            case 'subscriber_info_not_found':
            case 'sinf':
            case 'subnf':
            case 'subscriber_not_found':
                return 'اطلاعات مشترک یافت نشد.';
                break;
            case 'serviceinf':
            case 'serinf':
            case 'service_info_not_found':
                return 'اطلاعات سرویس مورد نظر یافت نشد.';
                break;
            case 'sinetbi':
            case 'subscriber_info_not_equal_to_branch_info':
                return 'اطلاعات نماینده با مشترک مورد نظر مغایرت دارد بنابراین قادر به ادامه درخواست مورد نظر نیستیم.';
                break;
            case 'snr':
            case 'shahkar_no_response':
                return 'پاسخی از شاهکار دریافت نشد لطفا اتصال سرور را بررسی نمایید.';
                break;
            case 'sinr':
            case 'subscriber_info_not_right':
                return 'اطلاعات مشترک جهت ادامه عملیات مورد نظر یافت نشد.';
                break;
            case 'scinf':
            case 'subscriber_credit_info_not_found':
                return 'اطلاعات حساب جهت ادامه عملیات مورد نظر یافت نشد.';
                break;
            case 'scne':
            case 'subscriber_credit_not_enough':
                return 'موجودی حساب مشترک کافی نمیباشد.';
                break;
            case 'bcinf':
            case 'branch_cooperation_info_not_found':
                return 'اطلاعات نحوه همکاری نماینده جهت ادامه عملیات یافت نشد.';
                break;
            case 'bnr':
            case 'binr':
            case 'branch_not_right':
                return 'اطلاعات نماینده به درستی ثبت نشده بنابراین قادر به ادامه این عملیات نیستیم';
                break;
            case 'bnf':
            case 'binf':
            case 'branch_not_found':
                return 'اطلاعات نماینده جهت ادامه عملیات مورد نظر یافت نشد.';
                break;
            case 'bcne':
            case 'branch_credit_not_enough':
                return 'موجودی حساب نماینده کافی نمیباشد.';
                break;
            case 'bcanf':
            case 'branch_credit_account_not_found':
                return 'اطلاعات موجودی حساب نماینده مورد نظر یافت نشد بنابراین قادر به ادامه عملیات نیستیم.';
                break;
            case 'user_didnt_found':
                return 'مشترک مورد نظر برای ادامه این عملیات یافت نشد لطفا پس از بررسی مجددا تلاش کنید.';
                break;
            case 'rinf':
            case 'required_info_not_found':
                return 'اطلاعات مورد نیاز برای ادامه این عملیات یافت نشد لطفا پس از بررسی دوباره تلاش کنید.';
                break;
            case 'cne':
            case 'credit_not_enough':
                return 'موجودی حساب برای ادامه این عملیات کافی نیست.';
                break;
            case 'cof':
            case 'credit_operation_fail':
                return 'عملیات پرداخت با مشکل مواجه شد.';
                break;
            case 'c20l':
            case 'credit_20p_low':
                return 'مانده اعتبار شما کافی نمیباشد میبایست همیشه 20% اعتبار بالاتر از سطح خرید باشد.';
                break;
            case 'cf':
            case 'charge_first':
                return 'اپراتور محترم جهت کاهش اعتبار میبایست ابتدا مشترک/نماینده مورد نظر را شارژ فرمایید';
                break;
            case 'na':
            case 'no_access':
                return 'شما مجاز به انجام این عملیات نیستید.';
                break;
            case 'int':
            case 'info_not_true':
                return 'اطلاعات دریافت شده صحیح نمیباشد لطفا پس از بررسی دوباره تلاش کنید.';
                break;
            case 'unknown_error':
            case 'un':
            case 'ue':
                return 'متاسفانه برنامه با مشکل مواجه شده است لطفا دوباره تلاش کنید.';
                break;
            case 'uae':
            case 'user_already_exist':
                return 'این نام کاربری و رمز عبور هم اکنون وجود دارد لطفا نام کاربری و رمز عبور خود را عوض کنید.';
                break;
            case 'ecm':
            case 'enter_code_meli':
                return 'لطفا کد ملی را وارد نمایید.';
                break;
            case 'en':
            case 'enter_name':
                return 'لطفا نام را وارد نمایید.';
                break;
            case 'ef_n':
            case 'efn':
            case 'enter_family_name':
                return 'لطفا نام خانوادگی را وارد نمایید.';
                break;
            case 'efi':
            case 'enter_full_info':
            case 'ine':
                return 'لطفا اطلاعات مورد نیاز را بطور کامل وارد نمایید.';
                break;
            case 'cmr':
                return 'لطفا کد ملی را وارد نمایید';
                break;
            case 'cmnv':
            case 'code_meli_not_valid':
                return 'فرمت کد ملی وار شده معتبر نمیباشد لطفا پس از بررسی مجددا تلاش کنید';
                break;
            case 'selectanoption':
            case 'sao':
                return 'ابتدا لطفا گزینه مورد نظر را انتخاب کنید';
                break;
            case 't':
            case 'test':
                return 'پیغام تستی';
                break;
            case 't1':
            case 'test1':
                return '1پیغام تستی';
                break;
            case 't2':
            case 'test2':
                return '2پیغام تستی';
                break;
            case 't3':
            case 'test3':
                return '3پیغام تستی';
                break;
            case 't4':
            case 'test4':
                return '4پیغام تستی';
                break;
            default:
                return 'برنامه با مشکل مواجه شده است.';
                break;
        }
    }
    public static function Alert_Message($msg_code = 'f')
    {
        $msg = '';
        $msg = self::Messages($msg_code);
        return "<script>alert('{$msg}');</script>";
    }
    public static function Alert_Custom_Message($msg)
    {
        return "<script>alert('{$msg}');</script>";
    }
    public static function Set_Factor_Tasvie_Shode($id)
    {

        $arr = array();
        $arr['id'] = $id;
        $arr['tasvie_shode'] = '1';
        $arr['tarikhe_tasvie_shode'] = self::Today_Miladi_Date() . " " . self::nowTimeTehran(':', true, true);
        $sql = self::Update_Generator($arr, 'bnm_factor', "WHERE id = :id");
        return Db::secure_update_array($sql, $arr);
    }

    public static function checkQueryResult($res)
    {
        if (gettype($res) === 'object') {
            return false;
        }
        if (!isset($res)) {
            return false;
        }

        if (!$res) {
            return false;
        }

        if (!isset($res[0])) {
            return false;
        }
        return $res;
    }

    public static function dynamicSelect($data, $table, $exceptions = false, $andor = 'AND')
    {
        if ($exceptions) {
            foreach ($exceptions as $key => $val) {
                // if (key_exists($val, $data) && $data[$val] && $data[$val] == '' || $data[$val] == ' ' || $data[$val] == null) {
                if (key_exists($val, $data)) {
                    unset($data[$val]);
                }
            }
        }
        if (!$data) {
            return false;
        }
        $firstKey = array_key_first($data);
        $lastkey = array_key_last($data);
        $sql = "SELECT * FROM " . $table . " WHERE ";
        foreach ($data as $key => $value) {
            if ($key === $firstKey) {
                $sql .= $key . '= ? ';
            } elseif ($key === $lastkey) {
                $sql .= $andor . ' ' . $key . '= ?';
            } else {
                $sql .= $andor . ' ' . $key . '= ?';
            }
        }
        return $sql;
    }
    public static function Update_Generator($data, $table, $where, $exceptions = [])
    {
        if ($exceptions) {
            foreach ($exceptions as $key => $val) {
                // if (key_exists($val, $data) && $data[$val] && $data[$val] == '' || $data[$val] == ' ' || $data[$val] == null) {
                if (key_exists($val, $data)) {
                    unset($data[$val]);
                }
                // if(isset($data[$val])){
                //     unset($data[$val]);
                // }
            }
        }
        if (key_exists('id', $data)) {
            unset($data['id']);
        }
        //array_pop($data);
        end($data);
        $lastkey = key($data);
        $sql = "UPDATE $table SET ";
        foreach ($data as $key => $value) {
            if ($key != $lastkey) {
                $sql .= $key . '= :' . $key . ',';
            } else {
                $sql .= $key . '= :' . $key;
                $sql .= ' ' . $where;
            }
        }
        return $sql;
    }
    public static function str_trim($str, $pattern = " ")
    {
        return trim($str, $pattern);
    }
    public static function str_rtrim($str, $pattern = " ")
    {
        return rtrim($str, $pattern);
    }

    public static function str_lrtrim($str, $pattern = " ")
    {
        return ltrim($str, $pattern);
    }

    public static function get_all_dashboard_menu()
    {
        return Db::fetchall_query("SELECT * FROM bnm_dashboard_menu");
    }

    public static function get_all_dashboard_menu_names()
    {
        $result = Db::fetchall_query("SELECT en_name FROM bnm_dashboard_menu");
        for ($i = 0; $i < count($result); $i++) {
            $key = key($result[$i]);
            $result[$i] = $result[$i][$key];
        }
        return $result;
    }

    public static function get_all_dashboard_menu_category()
    {
        return Db::fetchall_query("SELECT * FROM bnm_dashboard_menu_category");
    }

    public static function str_md5($str, $pattern = false)
    {
        return md5($str, $pattern);
    }

    public static function Password_Hash($str)
    {
        return password_hash($str, PASSWORD_DEFAULT);
    }

    public static function Password_Verify($str, $phrase)
    {
        return password_verify($str, $phrase);
    }

    public static function str_split_from_end($str, $split_num)
    {
        if (is_string($str) && self::Is_Empty_OR_Null($str)) {
            $output = '';
            $res = str_split($str);
            for ($i = count($res) - 1; $i >= count($res) - $split_num; $i--) {
                $output .= $res[$i];
            }
            return strrev($output);
        } else {
            return false;
        }
    }
    public static function splitBycharachter($str, $char = " ")
    {
        if (is_string($str) && self::Is_Empty_OR_Null($str)) {
            return explode($char, $str);
        } else {
            return false;
        }
    }
    public static function createIpRange(string $prefix, int $start, int $end)
    {
        $arr = [];
        for ($start; $start <= $end; $start++) {
            array_push($arr, (string) $prefix . $start);
        }
        return $arr;
    }

    //insert_Generator(data_array($_POSTED array),'table_name')
    public static function Insert_Generator($data, $table)
    {
        if (isset($data['id'])) {
            unset($data['id']);
        }
        //array_pop($data);
        end($data);
        $lastkey = key($data);
        $sql = "INSERT INTO $table (";
        foreach ($data as $key => $value) {
            if ($key != $lastkey) {
                $sql .= $key . ',';
            } else {
                $sql .= $key . ') VALUES(';
                foreach ($data as $k => $val) {
                    if ($k != $lastkey) {
                        $sql .= "?" . ',';
                    } else {
                        $sql .= "?" . ')';
                    }
                }
            }
        }
        return $sql;
    }
    public static function creditFormatArray($arr, $paramname)
    {
        for ($i = 0; $i < count($arr); $i++) {
            // $arr[$i][$paramname]=number_format($arr[$i][$paramname],2,'.',',');
            $arr[$i][$paramname] = str_replace('.', ',', self::byteConvert((int) self::toByteSize((string)$arr[$i][$paramname] . 'MB')));
        }
        return $arr;
    }
    public static function creditFormat($param)
    {
        $param = str_replace('.', ',', self::byteConvert((int) self::toByteSize((string)$param . 'MB')));
        return $param;
    }
    public static function numberFormatArray($arr, $paramname, int $decimals = 0, string $decimals_seperator = '.', string $thousends_sep = ',')
    {
        for ($i = 0; $i < count($arr); $i++) {
            $arr[$i][$paramname] = number_format($arr[$i][$paramname], $decimals, $decimals_seperator, $thousends_sep);
        }
        return $arr;
    }

    public static function xss_check_data($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    public static function isSeperatedDateGregorian($d)
    {
        if ((int) $d[0] < 1800) {
            return true;
        } else {
            return false;
        }
    }
    public static function dateConvertInitialize($date, $seperator = '-', $digitconvert = true)
    {

        if ($date) {
            $date_arr = array();
            $date_arr = explode($seperator, $date);
            if (count($date_arr) === 3) {
                if ($digitconvert) {
                    $year = (int) self::convert_numbers($date_arr[0], false);
                    $month = (int) self::convert_numbers($date_arr[1], false);
                    $day = (int) self::convert_numbers($date_arr[2], false);
                    // $result                = self::jalali_to_gregorian($year, $month, $day, '/');
                    return array($year, $month, $day);
                } else {
                    return array($date_arr[0], $date_arr[1], $date_arr[2]);
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public static function tabdileTarikhIndexArray(array $arr, string $paramname, int $noe_tabdil = 1, string $dateseperator = '-', string $resultseperator = '-', $digitconvert = true)
    {
        for ($i = 0; $i < count($arr); $i++) {
            $arr[$i][$paramname] = self::TabdileTarikh($arr[$i][$paramname], $noe_tabdil, $dateseperator, $resultseperator, $digitconvert);
        }
        return $arr;
    }
    public static function TabdileTarikh($date,/*1= miladi be shamsi , 2=shamsi be miladi*/ $noe_tabdil = 1, $dateseperator = '-', $resultseperator = '-', $digitconvert = true)
    {
        if ($date) {
            $date_arr = array();
            $alltimes = explode(' ', $date);
            $date_arr = explode($dateseperator, $alltimes[0]);
            if (count($date_arr) === 3) {
                if ($noe_tabdil === 1) {
                    $year = (int) $date_arr[0];
                    $month = (int) $date_arr[1];
                    $day = (int) $date_arr[2];
                    $result = self::gregorian_to_jalali($year, $month, $day, $resultseperator);
                    $dt = self::dateConvertInitialize($result, $resultseperator);
                    if (isset($dt[1]) && isset($dt[2]) && isset($dt[0])) {
                        if (strlen($dt[1]) < 2) {
                            $dt[1] = "0" . (string) $dt[1];
                        }
                        if (strlen($dt[2]) < 2) {
                            $dt[2] = "0" . (string) $dt[2];
                        }
                        $dt[0] = (string)$dt[0];
                        $result = $dt[0] . $resultseperator . $dt[1] . $resultseperator . $dt[2];
                    }

                    if (isset($alltimes[1])) {
                        $result = $result . ' ' . $alltimes[1];
                    }

                    return $result;
                } else {
                    if ($digitconvert) {
                        $year = (int)self::convert_numbers($date_arr[0], false);
                        $month = (int) self::convert_numbers($date_arr[1], false);
                        $day = (int) self::convert_numbers($date_arr[2], false);
                    } else {
                        $year = (int) $date_arr[0];
                        $month = (int) $date_arr[1];
                        $day = (int) $date_arr[2];
                    }

                    $result = self::jalali_to_gregorian($year, $month, $day, $resultseperator);
                    if (isset($alltimes[1])) {
                        $result = $result . ' ' . $alltimes[1];
                    }
                    return $result;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function secondsToTimeIndexArray(array $arr, string $paramname, $sep = ':')
    {
        for ($i = 0; $i < count($arr); $i++) {
            $arr[$i][$paramname] = self::seconds2MDH($arr[$i][$paramname]);
        }
        return $arr;
    }
    public static function secondsToTime($seconds, $sep = ',', $spec = false)
    {
        $seconds = (int) $seconds;
        $t = round($seconds);
        if ($spec) {
            return sprintf('%02d' . 'h' . $sep . '%02d' . 'm' . $sep . '%02d' . 's', ($t / 3600), ($t / 60 % 60), $t % 60);
        } else {
            return sprintf('%02d' . $sep . '%02d' . $sep . '%02d', ($t / 3600), ($t / 60 % 60), $t % 60);
        }
    }

    public static function fixDateDigit($date, $sep = "/", $timesep = " ")
    {
        $time = "";
        $darr   = explode($sep, $date);
        if (!isset($darr[0]) && !isset($darr[1]) && !isset($darr[2])) return false;
        $darr[0] = (string)$darr[0];
        $darr[1] = (string)$darr[1];
        $darr[2] = (string)$darr[2];
        $dt     = explode($timesep, $darr[2]);
        if (strlen($darr[1]) < 2) {
            $darr[1] = "0" . $darr[1];
        }
        if (isset($dt)) {
            if ($dt) {
                if (count($dt) > 1) {
                    $time = $dt[1];
                    if (strlen($dt[0]) < 2) {
                        $dt[0] = "0" . $dt[0];
                        return $darr[0] . $sep . $darr[1] . $sep . $dt[0] . $timesep . $time;
                    } else {
                        return $darr[0] . $sep . $darr[1] . $sep . $dt[0] . $timesep . $time;
                    }
                }
            }
        }
        if (strlen($darr[2]) < 2) {
            $darr[2] = "0" . $darr[2];
            return $darr[0] . $sep . $darr[1] . $sep . $darr[2];
        }
        return $darr[0] . $sep . $darr[1] . $sep . $darr[2];
        return $date;
    }

    public static function Today_Shamsi_Date($seperator = '-')
    {
        $test_date = explode($seperator, date('Y' . $seperator . 'm' . $seperator . 'd'));
        $res = self::gregorian_to_jalali((int) $test_date[0], (int) $test_date[1], (int) $test_date[2], $seperator);
        return $res;
    }

    public static function nowShamsiYmd($sep = "-")
    {
        $test_date = explode($sep, date("Y" . $sep . "m" . $sep . "d"));
        // return $test_date;
        return $res = self::gregorian_to_jalali((int) $test_date[0], (int) $test_date[1], (int) $test_date[2], $sep);
    }

    public static function nowShamsihisv($sep = ":")
    {
        // $test_date = explode($sep, date("Y".$sep."m".$sep."d"));
        // return $test_date;
        $date = new DateTime("now", new DateTimeZone("Asia/Tehran"));
        // return $res = self::gregorian_to_jalali((int) $test_date[0], (int) $test_date[1], (int) $test_date[2], $sep);
        return $date->format("H" . $sep . "i" . $sep . "s" . "." . "v");
    }

    public static function Today_Miladi_Date($seperator = '-')
    {
        return date('Y' . $seperator . 'm' . $seperator . 'd');
    }
    public static function nowTimeTehran($sep = ':', $displayseconds = true, $microseconds = false)
    {
        $date = new DateTime("now", new DateTimeZone("Asia/Tehran"));
        if ($displayseconds) {
            if ($microseconds) {
                return $date->format("H" . $sep . "i" . $sep . "s.u");
            } else {
                return $date->format("H" . $sep . "i" . $sep . "s");
            }
        } else {
            return $date->format("H" . $sep . "i");
        }
    }
    public static function nowMilliseconds()
    {
        $mt = explode(' ', microtime());
        return ((int) $mt[1]) * 1000 + ((int) round($mt[0] * 1000));
    }

    public static function gregorian_to_jalali($gy, $gm, $gd, $mod = '')
    {
        $g_d_m = array(0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334);
        if ($gy > 1600) {
            $jy = 979;
            $gy -= 1600;
        } else {
            $jy = 0;
            $gy -= 621;
        }
        $gy2 = ($gm > 2) ? ($gy + 1) : $gy;
        $days = (365 * $gy) + ((int) (($gy2 + 3) / 4)) - ((int) (($gy2 + 99) / 100)) + ((int) (($gy2 + 399) / 400)) - 80 + $gd + $g_d_m[$gm - 1];
        $jy += 33 * ((int) ($days / 12053));
        $days %= 12053;
        $jy += 4 * ((int) ($days / 1461));
        $days %= 1461;
        if ($days > 365) {
            $jy += (int) (($days - 1) / 365);
            $days = ($days - 1) % 365;
        }
        $jm = ($days < 186) ? 1 + (int) ($days / 31) : 7 + (int) (($days - 186) / 30);
        $jd = 1 + (($days < 186) ? ($days % 31) : (($days - 186) % 30));
        return ($mod === '') ? array($jy, $jm, $jd) : $jy . $mod . $jm . $mod . $jd;
    }

    public static function jalali_to_gregorian($jy, $jm, $jd, $mod = '')
    {
        if ($jy > 979) {
            $gy = 1600;
            $jy -= 979;
        } else {
            $gy = 621;
        }
        $days = (365 * $jy) + (((int) ($jy / 33)) * 8) + ((int) ((($jy % 33) + 3) / 4)) + 78 + $jd + (($jm < 7) ? ($jm - 1) * 31 : (($jm - 7) * 30) + 186);
        $gy += 400 * ((int) ($days / 146097));
        $days %= 146097;
        if ($days > 36524) {
            $gy += 100 * ((int) (--$days / 36524));
            $days %= 36524;
            if ($days >= 365) {
                $days++;
            }
        }
        $gy += 4 * ((int) ($days / 1461));
        $days %= 1461;
        if ($days > 365) {
            $gy += (int) (($days - 1) / 365);
            $days = ($days - 1) % 365;
        }
        $gd = $days + 1;
        foreach (array(0, 31, (($gy % 4 == 0 and $gy % 100 != 0) or ($gy % 400 == 0)) ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31) as $gm => $v) {
            if ($gd <= $v) {
                break;
            }

            $gd -= $v;
        }
        return ($mod == '') ? array($gy, $gm, $gd) : $gy . $mod . $gm . $mod . $gd;
    }

    public static function convert_numbers($string, $toPersian = true)
    {
        $e_num = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        $f_num = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        //todo... change $f_num to this
        // array('۰'=>'0', '۱'=>'1', '۲'=>'2', '۳'=>'3', '۴'=>'4', '۵'=>'5', '۶'=>'6', '۷'=>'7', '۸'=>'8', '۹'=>'9', '٠'=>'0', '١'=>'1', '٢'=>'2', '٣'=>'3', '٤'=>'4', '٥'=>'5', '٦'=>'6', '٧'=>'7', '٨'=>'8', '٩'=>'9');
        if ($toPersian) {
            return str_replace($e_num, $f_num, $string);
        } else {
            return str_replace($f_num, $e_num, $string);
        }
    }

    public static function upload_file($key, $file, $folder, $file_info, $postfix)
    {
        if ($folder && $file_info && $postfix) {
            //$key = key($_FILES);
            $target_dir = __IMAGESPATH__ . $folder;
            $target_file = $target_dir; //. basename($file[$key]["name"]);
            $uploadOk = false;
            $imageFileType = strtolower(pathinfo(basename($file[$key]["name"]), PATHINFO_EXTENSION));
            //init

            if (!file_exists($target_file . $file_info)) {
                $dir_created = mkdir($target_file . $file_info, 0777, true);
            }
            $check = getimagesize($file[$key]["tmp_name"]);
            //$check=Array ( [0] => 1024 [1] => 768 [2] => 2 [3] => width="1024" height="768" [bits] => 8 [channels] => 3 [mime] => image/jpeg )
            if ($file[$key]["size"] < 5000000) {
                $uploadOk = true;
            }
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                $uploadOk = true;
            }
            if ($uploadOk) {
                if (move_uploaded_file($file[$key]["tmp_name"], $target_file . $file_info . '\\' . $file_info . "_" . $postfix . '.' . $imageFileType)) {
                    //return "The file " . basename($file[$key]["name"]) . " has been uploaded.";
                    return $folder . '\\' . $file_info . '\\' . '\\' . $file_info . "_" . $postfix . '.' . $imageFileType;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function datatable_handler($data)
    {
        switch ($data['request']) {
            case 'ip_assign':
                if (self::Login_Just_Check()) {
                    unset($data['datatable_request']);
                    unset($data['request']);
                    $primaryKey = 'id';
                    $columns = array(
                        array('db' => 'id', 'dt' => 'id'),
                        array('db' => 'name', 'dt' => 'name'),
                        array('db' => 'telephone', 'dt' => 'telephone'),
                        array('db' => 'servicetype', 'dt' => 'servicetype'),
                        array('db' => 'ip', 'dt' => 'ip'),
                        array('db' => 'bandwidth', 'dt' => 'bandwidth'),
                        array('db' => 'tarikhe_shoroe_ip', 'dt' => 'tarikhe_shoroe_ip'),
                        array('db' => 'tarikhe_payane_ip', 'dt' => 'tarikhe_payane_ip'),
                        array('db' => 'poolname', 'dt' => 'poolname'),
                    );
                    //modify date
                    // array(
                    //     'db'        => 'start_date',
                    //     'dt'        => 4,
                    //     'formatter' => function( $d, $row ) {
                    //         return date( 'jS M y', strtotime($d));
                    //     }
                    // ),
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            $table = "( SELECT
                                            ass.id,
                                            ip.ip AS ip,
                                            pool.name poolname,
                                            IF( sub.noe_moshtarak = 'real', CONCAT( sub.NAME, ' ', sub.f_name ), sub.name_sherkat ) AS name ,
                                            sub.telephone1 telephone,
                                            ass.servicetype,
                                            ass.bandwidth,
                                            ass.tarikhe_shoroe_ip,
                                            ass.tarikhe_payane_ip
                                        FROM bnm_ip_assign ass
                                            INNER JOIN bnm_subscribers sub ON sub.id = ass.sub
                                            INNER JOIN bnm_ip ip ON ip.id= ass.ip
                                            INNER JOIN bnm_ip_pool_list pool ON pool.id = ip.pool
                                    ) tmp";
                            break;
                        case __MODIRUSERTYPE__:
                        case __MODIR2USERTYPE__:
                        case __OPERATORUSERTYPE__:
                        case __OPERATOR2USERTYPE__:
                            $table = "( SELECT
                                            ass.id,
                                            ip.ip AS ip,
                                            pool.name poolname,
                                            IF( sub.noe_moshtarak = 'real', CONCAT( sub.NAME, ' ', sub.f_name ), sub.name_sherkat ) AS name ,
                                            sub.telephone1 telephone,
                                            ass.servicetype,
                                            ass.bandwidth,
                                            ass.tarikhe_shoroe_ip,
                                            ass.tarikhe_payane_ip
                                        FROM bnm_ip_assign ass
                                            INNER JOIN bnm_subscribers sub ON sub.id = ass.sub
                                            INNER JOIN bnm_ip ip ON ip.id= ass.ip
                                            INNER JOIN bnm_ip_pool_list pool ON pool.id = ip.pool
                                        WHERE sub.branch_id = {$_SESSION['branch_id']}
                                    ) tmp";
                            break;
                        default:
                            return false;
                            break;
                    }
                    $where = false;
                    return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                    break;
                } else {
                    die(self::Json_Message('af'));
                }
                break;
            case 'speedtest_report':
                if (self::Login_Just_Check()) {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            unset($data['datatable_request']);
                            unset($data['request']);
                            $primaryKey = 'id';
                            $table = "bnm_customer_speedtest";
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'ip', 'dt' => 'ip'),
                                array('db' => 'username', 'dt' => 'username'),
                                array('db' => 'download', 'dt' => 'download'),
                                array('db' => 'upload', 'dt' => 'upload'),
                                array('db' => 'ping', 'dt' => 'ping'),
                                array('db' => 'tarikh', 'dt' => 'tarikh'),
                            );
                            $table = "(
                                SELECT
                                    bcs.id id,
                                    bcs.ip ip,
                                    bcs.username username,
                                    bcs.download download,
                                    bcs.upload upload,
                                    bcs.ping ping,
                                    bcs.tarikh tarikh
                                FROM bnm_customer_speedtest bcs
                                INNER JOIN bnm_subscribers sub ON sub.id = bcs.subid
                            )tmp";
                            $where = false;
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        case __MOSHTARAKUSERTYPE__:
                            unset($data['datatable_request']);
                            unset($data['request']);
                            $primaryKey = 'id';
                            $table = "bnm_customer_speedtest";
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'ip', 'dt' => 'ip'),
                                array('db' => 'username', 'dt' => 'username'),
                                array('db' => 'download', 'dt' => 'download'),
                                array('db' => 'upload', 'dt' => 'upload'),
                                array('db' => 'ping', 'dt' => 'ping'),
                                array('db' => 'tarikh', 'dt' => 'tarikh'),
                            );
                            $table = "(
                                SELECT
                                    bcs.id id,
                                    bcs.ip ip,
                                    bcs.username username,
                                    bcs.download download,
                                    bcs.upload upload,
                                    bcs.ping ping,
                                    bcs.tarikh tarikh
                                FROM bnm_customer_speedtest bcs
                                INNER JOIN bnm_subscribers sub ON sub.id = bcs.subid
                                WHERE sub.id = {$_SESSION['user_id']}
                            )tmp";
                            $where = false;
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        case __MODIRUSERTYPE__:
                        case __MODIR2USERTYPE__:
                        case __OPERATORUSERTYPE__:
                        case __OPERATOR2USERTYPE__:
                            unset($data['datatable_request']);
                            unset($data['request']);
                            $primaryKey = 'id';
                            $table = "bnm_customer_speedtest";
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'ip', 'dt' => 'ip'),
                                array('db' => 'username', 'dt' => 'username'),
                                array('db' => 'download', 'dt' => 'download'),
                                array('db' => 'upload', 'dt' => 'upload'),
                                array('db' => 'ping', 'dt' => 'ping'),
                                array('db' => 'tarikh', 'dt' => 'tarikh'),
                            );
                            $table = "(
                                SELECT
                                    bcs.id id,
                                    bcs.ip ip,
                                    bcs.username username,
                                    bcs.download download,
                                    bcs.upload upload,
                                    bcs.ping ping,
                                    bcs.tarikh tarikh
                                FROM bnm_customer_speedtest bcs
                                INNER JOIN bnm_subscribers sub ON sub.id = bcs.subid AND sub.branch_id = {$_SESSION['branch_id']}
                            )tmp";
                            $where = false;
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        default:
                            die(self::Json_Message('af'));
                            break;
                    }
                } else {
                    die(self::Json_Message('af'));
                }
                break;
            case 'customer_speedtest':
                if (self::Login_Just_Check()) {
                    switch ($_SESSION['user_type']) {
                        case __MOSHTARAKUSERTYPE__:
                            unset($data['datatable_request']);
                            unset($data['request']);
                            $primaryKey = 'id';
                            $table = "bnm_customer_speedtest";
                            $columns = array(
                                array('db' => 'ip', 'dt' => 'ip'),
                                array('db' => 'username', 'dt' => 'username'),
                                array('db' => 'download', 'dt' => 'download'),
                                array('db' => 'upload', 'dt' => 'upload'),
                                array('db' => 'ping', 'dt' => 'ping'),
                                array('db' => 'tarikh', 'dt' => 'tarikh'),
                            );
                            $where = "userid = {$_SESSION['user_id']}";
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        default:
                            die(self::Json_Message('af'));
                            break;
                    }
                } else {
                    die(self::Json_Message('af'));
                }
                break;
            case 'osstickets':
                if (self::Login_Just_Check()) {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            unset($data['datatable_request']);
                            unset($data['request']);
                            $primaryKey = 'id';
                            $table = "bnm_oss_tickets";
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'tiid', 'dt' => 'tiid'),
                                array('db' => 'title', 'dt' => 'title'),
                            );
                            $where = false;
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        default:
                            die(self::Json_Message('af'));
                            break;
                    }
                } else {
                    die(self::Json_Message('af'));
                }
                break;
            case 'add_to_bank':
                if (self::Login_Just_Check()) {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            unset($data['datatable_request']);
                            unset($data['request']);
                            $primaryKey = 'id';
                            $table = "(
                                SELECT b.id,b.name,f.file_name filename
                                FROM bnm_banks b
                                INNER JOIN bnm_upload_file f ON f.id = b.file_id
                            )tmp";
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'name', 'dt' => 'name'),
                                array('db' => 'filename', 'dt' => 'filename'),

                            );
                            $where = false;
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        default:
                            die(self::Json_Message('af'));
                            break;
                    }
                } else {
                    die(self::Json_Message('af'));
                }
                break;
            case 'tdlte_sim':
                if (self::Login_Just_Check()) {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            unset($data['datatable_request']);
                            unset($data['request']);
                            $primaryKey = 'id';
                            $table = "(
                                SELECT if(td.branch_id = 0,'" . __OWNER__ . "',bb.name_sherkat) name_sherkat,
                                td.id id,td.serial serial,td.puk1 puk1,td.puk2 puk2,td.tarikhe_sabt tarikhe_sabt,
                                td.tdlte_number tdlte_number,CONCAT_WS(' ',bs.name,bs.f_name) full_name
                                FROM bnm_tdlte_sim td
                                LEFT JOIN bnm_branch bb ON td.branch_id = bb.id
                                LEFT JOIN bnm_subscribers bs ON td.subscriber_id=bs.id
                            )tmp";
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'serial', 'dt' => 'serial'),
                                array('db' => 'name_sherkat', 'dt' => 'name_sherkat'),
                                array('db' => 'tdlte_number', 'dt' => 'tdlte_number'),
                                array('db' => 'puk1', 'dt' => 'puk1'),
                                array('db' => 'puk2', 'dt' => 'puk2'),
                                array('db' => 'full_name', 'dt' => 'full_name'),
                                array('db' => 'tarikhe_sabt', 'dt' => 'tarikhe_sabt'),
                            );
                            $where = false;
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        default:
                            die(self::Json_Message('af'));
                            break;
                    }
                } else {
                    die(self::Json_Message('af'));
                }
                break;
            case 'noe_terminal':
                if (self::Login_Just_Check()) {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                        case __MODIRUSERTYPE__:
                        case __OPERATORUSERTYPE__:
                            unset($data['datatable_request']);
                            unset($data['request']);
                            $primaryKey = 'id';
                            $table = "bnm_noe_terminal";
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'esme_terminal', 'dt' => 'esme_terminal'),
                                array('db' => 'tedade_port', 'dt' => 'tedade_port'),
                                array('db' => 'tartibe_ranzhe', 'dt' => 'tartibe_ranzhe'),
                                array('db' => 'tedade_tighe', 'dt' => 'tedade_tighe'),
                                array('db' => 'tedade_port_dar_har_tighe', 'dt' => 'tedade_port_dar_har_tighe'),
                            );
                            $where = false;
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        default:
                            die(self::Json_Message('af'));
                            break;
                    }
                } else {
                    die(self::Json_Message('af'));
                }
                break;
            case 'services_bs':
                if (self::Login_Just_Check()) {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            unset($data['datatable_request']);
                            unset($data['request']);
                            $primaryKey = 'id';
                            $table = "bnm_services";
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'noe_khadamat', 'dt' => 'noe_khadamat'),
                                array('db' => 'onvane_service', 'dt' => 'onvane_service'),
                                array('db' => 'tarikhe_shoroe_namayesh', 'dt' => 'tarikhe_shoroe_namayesh'),
                                array('db' => 'tarikhe_payane_namayesh', 'dt' => 'tarikhe_payane_namayesh'),
                                array('db' => 'gheymat', 'dt' => 'gheymat'),
                            );
                            $where = "type='bitstream'";
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        default:
                            die(self::Json_Message('af'));
                            break;
                    }
                } else {
                    die(self::Json_Message('af'));
                }
                break;
            case 'services_adsl':
                if (self::Login_Just_Check()) {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            unset($data['datatable_request']);
                            unset($data['request']);
                            $primaryKey = 'id';
                            $table = "bnm_services";
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'noe_khadamat', 'dt' => 'noe_khadamat'),
                                array('db' => 'onvane_service', 'dt' => 'onvane_service'),
                                array('db' => 'tarikhe_shoroe_namayesh', 'dt' => 'tarikhe_shoroe_namayesh'),
                                array('db' => 'tarikhe_payane_namayesh', 'dt' => 'tarikhe_payane_namayesh'),
                                array('db' => 'gheymat', 'dt' => 'gheymat'),
                            );
                            $where = "type='adsl'";
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        default:
                            die(self::Json_Message('af'));
                            break;
                    }
                } else {
                    die(self::Json_Message('af'));
                }
                break;
            case 'services_vdsl':
                if (self::Login_Just_Check()) {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            unset($data['datatable_request']);
                            unset($data['request']);
                            $primaryKey = 'id';
                            $table = "bnm_services";
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'noe_khadamat', 'dt' => 'noe_khadamat'),
                                array('db' => 'onvane_service', 'dt' => 'onvane_service'),
                                array('db' => 'tarikhe_shoroe_namayesh', 'dt' => 'tarikhe_shoroe_namayesh'),
                                array('db' => 'tarikhe_payane_namayesh', 'dt' => 'tarikhe_payane_namayesh'),
                                array('db' => 'gheymat', 'dt' => 'gheymat'),
                            );
                            $where = "type='vdsl'";
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        default:
                            die(self::Json_Message('af'));
                            break;
                    }
                } else {
                    die(self::Json_Message('af'));
                }
                break;
            case 'services_wireless':
                if (self::Login_Just_Check()) {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            unset($data['datatable_request']);
                            unset($data['request']);
                            $primaryKey = 'id';
                            $table = "bnm_services";
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'noe_khadamat', 'dt' => 'noe_khadamat'),
                                array('db' => 'onvane_service', 'dt' => 'onvane_service'),
                                array('db' => 'tarikhe_shoroe_namayesh', 'dt' => 'tarikhe_shoroe_namayesh'),
                                array('db' => 'tarikhe_payane_namayesh', 'dt' => 'tarikhe_payane_namayesh'),
                                array('db' => 'gheymat', 'dt' => 'gheymat'),
                            );
                            $where = "type='wireless'";
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        default:
                            die(self::Json_Message('af'));
                            break;
                    }
                } else {
                    die(self::Json_Message('af'));
                }
                break;
            case 'services_tdlte':
                if (self::Login_Just_Check()) {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            unset($data['datatable_request']);
                            unset($data['request']);
                            $primaryKey = 'id';
                            $table = "bnm_services";
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'noe_khadamat', 'dt' => 'noe_khadamat'),
                                array('db' => 'onvane_service', 'dt' => 'onvane_service'),
                                array('db' => 'tarikhe_shoroe_namayesh', 'dt' => 'tarikhe_shoroe_namayesh'),
                                array('db' => 'tarikhe_payane_namayesh', 'dt' => 'tarikhe_payane_namayesh'),
                                array('db' => 'gheymat', 'dt' => 'gheymat'),
                            );
                            $where = "type='tdlte'";
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        default:
                            die(self::Json_Message('af'));
                            break;
                    }
                } else {
                    die(self::Json_Message('af'));
                }
                break;
            case 'services_voip':
                if (self::Login_Just_Check()) {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            unset($data['datatable_request']);
                            unset($data['request']);
                            $primaryKey = 'id';
                            $table = "bnm_services";
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'noe_khadamat', 'dt' => 'noe_khadamat'),
                                array('db' => 'onvane_service', 'dt' => 'onvane_service'),
                                array('db' => 'tarikhe_shoroe_namayesh', 'dt' => 'tarikhe_shoroe_namayesh'),
                                array('db' => 'tarikhe_payane_namayesh', 'dt' => 'tarikhe_payane_namayesh'),
                                array('db' => 'gheymat', 'dt' => 'gheymat'),
                            );
                            $where = "type='voip'";
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        default:
                            die(self::Json_Message('af'));
                            break;
                    }
                } else {
                    die(self::Json_Message('af'));
                }
                break;
            case 'services_ip':
                if (self::Login_Just_Check()) {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            unset($data['datatable_request']);
                            unset($data['request']);
                            $primaryKey = 'id';
                            $table = "bnm_services";
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'noe_khadamat', 'dt' => 'noe_khadamat'),
                                array('db' => 'onvane_service', 'dt' => 'onvane_service'),
                                array('db' => 'tarikhe_shoroe_namayesh', 'dt' => 'tarikhe_shoroe_namayesh'),
                                array('db' => 'tarikhe_payane_namayesh', 'dt' => 'tarikhe_payane_namayesh'),
                                array('db' => 'tedad', 'dt' => 'tedad'),
                            );
                            $where = "type='ip'";
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        default:
                            die(self::Json_Message('af'));
                            break;
                    }
                } else {
                    die(self::Json_Message('af'));
                }
                break;
            case 'modir':
                if (self::Login_Just_Check()) {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            unset($data['datatable_request']);
                            unset($data['request']);
                            $primaryKey = 'id';
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'name', 'dt' => 'name'),
                                array('db' => 'branch_id', 'dt' => 'branch_id'),
                                array('db' => 'telephone_hamrah', 'dt' => 'telephone_hamrah'),
                                array('db' => 'telephone_mahale_sokonat', 'dt' => 'telephone_mahale_sokonat'),
                                array('db' => 'email', 'dt' => 'email'),
                                array('db' => 'username', 'dt' => 'username'),
                            );
                            $table = "(SELECT bop.id as id , bop.name as name , bbranch.name_sherkat as branch_id,
                                bop.telephone_hamrah as telephone_hamrah , bop.telephone_mahale_sokonat as telephone_mahale_sokonat,
                                bop.email as email,bop.username as username FROM bnm_operator bop LEFT JOIN bnm_branch bbranch ON
                                bop.branch_id = bbranch.id
                                WHERE bop.user_type IN (" . __MODIRUSERTYPE__ . "," . __MODIR2USERTYPE__ . ")
                                ) tmp";
                            $where = false;
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        case __MODIRUSERTYPE__:
                        case __OPERATORUSERTYPE__:
                            unset($data['datatable_request']);
                            unset($data['request']);
                            //$table      = 'bnm_branch';
                            $primaryKey = 'id';
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'name', 'dt' => 'name'),
                                array('db' => 'branch_id', 'dt' => 'branch_id'),
                                array('db' => 'telephone_hamrah', 'dt' => 'telephone_hamrah'),
                                array('db' => 'telephone_mahale_sokonat', 'dt' => 'telephone_mahale_sokonat'),
                                array('db' => 'email', 'dt' => 'email'),
                                array('db' => 'username', 'dt' => 'username'),
                            );
                            $table = "(SELECT bop.id as id , bop.name as name , bbranch.name_sherkat as branch_id,
                                    bop.telephone_hamrah as telephone_hamrah , bop.telephone_mahale_sokonat as telephone_mahale_sokonat,
                                    bop.email as email,bop.username as username FROM bnm_operator bop LEFT JOIN bnm_branch bbranch ON
                                    bop.branch_id = bbranch.id
                                    WHERE bop.panel_status = " . __PANELACTIVESTATUS__ . " AND bop.branch_id={$_SESSION['branch_id']}
                                    AND bop.user_type = " . __MODIRUSERTYPE__ . "
                                ) tmp";
                            $where = false;
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        case __MODIR2USERTYPE__:
                        case __OPERATOR2USERTYPE__:
                            unset($data['datatable_request']);
                            unset($data['request']);
                            //$table      = 'bnm_branch';
                            $primaryKey = 'id';
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'name', 'dt' => 'name'),
                                array('db' => 'branch_id', 'dt' => 'branch_id'),
                                array('db' => 'telephone_hamrah', 'dt' => 'telephone_hamrah'),
                                array('db' => 'telephone_mahale_sokonat', 'dt' => 'telephone_mahale_sokonat'),
                                array('db' => 'email', 'dt' => 'email'),
                                array('db' => 'username', 'dt' => 'username'),
                            );
                            $table = "(SELECT bop.id as id , bop.name as name , bbranch.name_sherkat as branch_id,
                                    bop.telephone_hamrah as telephone_hamrah , bop.telephone_mahale_sokonat as telephone_mahale_sokonat,
                                    bop.email as email,bop.username as username FROM bnm_operator bop LEFT JOIN bnm_branch bbranch ON
                                    bop.branch_id = bbranch.id
                                    WHERE bop.panel_status = " . __PANELACTIVESTATUS__ . " AND bop.branch_id={$_SESSION['branch_id']}
                                    AND bop.user_type = " . __MODIR2USERTYPE__ . "
                                ) tmp";
                            $where = false;
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        default:
                            die(self::Json_Message('af'));
                            break;
                    }
                } else {
                    die(self::Json_Message('af'));
                }
                break;
            case 'operator':
                if (self::Login_Just_Check()) {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            unset($data['datatable_request']);
                            unset($data['request']);
                            $table = 'bnm_operator';
                            $primaryKey = 'id';
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'name', 'dt' => 'name'),
                                array('db' => 'branch_id', 'dt' => 'branch_id'),
                                array('db' => 'telephone_hamrah', 'dt' => 'telephone_hamrah'),
                                array('db' => 'telephone_mahale_sokonat', 'dt' => 'telephone_mahale_sokonat'),
                                array('db' => 'email', 'dt' => 'email'),
                                array('db' => 'username', 'dt' => 'username'),
                            );
                            $table = "(SELECT bop.id as id , bop.name as name , bbranch.name_sherkat as branch_id,
                                bop.telephone_hamrah as telephone_hamrah , bop.telephone_mahale_sokonat as telephone_mahale_sokonat,
                                bop.email as email,bop.username as username FROM bnm_operator bop LEFT JOIN bnm_branch bbranch ON
                                bop.branch_id = bbranch.id
                                WHERE bop.panel_status = " . __PANELACTIVESTATUS__ . " AND bop.user_type=" . __OPERATORUSERTYPE__ . "
                                ) tmp";
                            $active_panel = 1;
                            $where = false;
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        case __MODIRUSERTYPE__:
                        case __OPERATORUSERTYPE__:
                            unset($data['datatable_request']);
                            unset($data['request']);
                            $primaryKey = 'id';
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'name', 'dt' => 'name'),
                                array('db' => 'branch_id', 'dt' => 'branch_id'),
                                array('db' => 'telephone_hamrah', 'dt' => 'telephone_hamrah'),
                                array('db' => 'telephone_mahale_sokonat', 'dt' => 'telephone_mahale_sokonat'),
                                array('db' => 'email', 'dt' => 'email'),
                                array('db' => 'username', 'dt' => 'username'),
                            );
                            $table = "(SELECT bop.id as id , bop.name as name , bbranch.name_sherkat as branch_id,
                                bop.telephone_hamrah as telephone_hamrah , bop.telephone_mahale_sokonat as telephone_mahale_sokonat,
                                bop.email as email,bop.username as username FROM bnm_operator bop LEFT JOIN bnm_branch bbranch ON
                                bop.branch_id = bbranch.id
                                WHERE bop.panel_status = " . __PANELACTIVESTATUS__ . " AND bop.branch_id={$_SESSION['branch_id']}
                                AND bop.user_type = " . __OPERATORUSERTYPE__ . "
                                ) tmp";
                            $where = false;
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        case __MODIR2USERTYPE__:
                        case __OPERATOR2USERTYPE__:
                            unset($data['datatable_request']);
                            unset($data['request']);
                            $primaryKey = 'id';
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'name', 'dt' => 'name'),
                                array('db' => 'branch_id', 'dt' => 'branch_id'),
                                array('db' => 'telephone_hamrah', 'dt' => 'telephone_hamrah'),
                                array('db' => 'telephone_mahale_sokonat', 'dt' => 'telephone_mahale_sokonat'),
                                array('db' => 'email', 'dt' => 'email'),
                                array('db' => 'username', 'dt' => 'username'),
                            );
                            $table = "(SELECT bop.id as id , bop.name as name , bbranch.name_sherkat as branch_id,
                                bop.telephone_hamrah as telephone_hamrah , bop.telephone_mahale_sokonat as telephone_mahale_sokonat,
                                bop.email as email,bop.username as username FROM bnm_operator bop LEFT JOIN bnm_branch bbranch ON
                                bop.branch_id = bbranch.id
                                WHERE bop.panel_status = " . __PANELACTIVESTATUS__ . " AND bop.branch_id={$_SESSION['branch_id']}
                                AND bop.user_type = " . __OPERATOR2USERTYPE__ . "
                                ) tmp";
                            $where = false;
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        default:
                            die(self::Json_Message('af'));
                            break;
                    }
                } else {
                    die(self::Json_Message('af'));
                }

                break;
            case 'pre_internal_branch':
                if (self::Login_Just_Check()) {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            unset($data['datatable_request']);
                            unset($data['request']);
                            $table = 'bnm_prebranch';
                            $primaryKey = 'id';

                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'name_sherkat', 'dt' => 'name_sherkat'),
                                array('db' => 'shomare_sabt', 'dt' => 'shomare_sabt'),
                                array('db' => 'telephone1', 'dt' => 'telephone1'),
                                array('db' => 'telephone2', 'dt' => 'telephone2'),
                                array('db' => 'address', 'dt' => 'address'),
                                array('db' => 'noe_sherkat', 'dt' => 'noe_sherkat'),
                            );
                            $where = "confirmstatus = 2";
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        case __MODIRUSERTYPE__:
                        case __OPERATORUSERTYPE__:
                            unset($data['datatable_request']);
                            unset($data['request']);
                            $table = 'bnm_prebranch';
                            $primaryKey = 'id';
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'name_sherkat', 'dt' => 'name_sherkat'),
                                array('db' => 'shomare_sabt', 'dt' => 'shomare_sabt'),
                                array('db' => 'telephone1', 'dt' => 'telephone1'),
                                array('db' => 'telephone2', 'dt' => 'telephone2'),
                                array('db' => 'address', 'dt' => 'address'),
                                array('db' => 'noe_sherkat', 'dt' => 'noe_sherkat'),
                            );
                            $where = "id = {$_SESSION['branch_id']} AND confirmstatus = 2";
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        default:
                            die(self::Json_Message('af'));
                            break;
                    }
                } else {
                    die(self::Json_Message('af'));
                }

                break;
            case 'branch':
                if (self::Login_Just_Check()) {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            unset($data['datatable_request']);
                            unset($data['request']);
                            $table = 'bnm_branch';
                            $primaryKey = 'id';
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'name_sherkat', 'dt' => 'name_sherkat'),
                                array('db' => 'shomare_sabt', 'dt' => 'shomare_sabt'),
                                array('db' => 'telephone1', 'dt' => 'telephone1'),
                                array('db' => 'telephone2', 'dt' => 'telephone2'),
                                array('db' => 'address', 'dt' => 'address'),
                                array('db' => 'noe_sherkat', 'dt' => 'noe_sherkat'),
                            );
                            $where = false;
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        case __MODIRUSERTYPE__:
                        case __OPERATORUSERTYPE__:
                            unset($data['datatable_request']);
                            unset($data['request']);
                            $table = 'bnm_branch';
                            $primaryKey = 'id';
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'name_sherkat', 'dt' => 'name_sherkat'),
                                array('db' => 'shomare_sabt', 'dt' => 'shomare_sabt'),
                                array('db' => 'telephone1', 'dt' => 'telephone1'),
                                array('db' => 'telephone2', 'dt' => 'telephone2'),
                                array('db' => 'address', 'dt' => 'address'),
                                array('db' => 'noe_sherkat', 'dt' => 'noe_sherkat'),
                            );
                            $where = "id = {$_SESSION['branch_id']}";
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        default:
                            die(self::Json_Message('af'));
                            break;
                    }
                } else {
                    die(self::Json_Message('af'));
                }

                break;
            case 'upload_file':
                if (self::Login_Just_Check()) {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            unset($data['datatable_request']);
                            unset($data['request']);
                            $table = 'bnm_messages';
                            $primaryKey = 'id';
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'message_subject', 'dt' => 'message_subject'),
                                array('db' => 'message', 'dt' => 'message'),
                            );
                            // $table="SELECT b.id as id,b.name as name,count(c.id) as count_content FROM bnm_banks AS b
                            // LEFT JOIN bnm_bank_content ON b.id=c.bank_id";
                            $where = false;
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        default:
                            die(self::Json_Message('af'));
                            break;
                    }
                } else {
                    die(self::Json_Message('af'));
                }

                break;
            case 'messages':
                if (self::Login_Just_Check()) {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            unset($data['datatable_request']);
                            unset($data['request']);
                            $table = 'bnm_messages';
                            $primaryKey = 'id';
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'message_subject', 'dt' => 'message_subject'),
                                array('db' => 'message', 'dt' => 'message'),
                            );
                            // $table="SELECT b.id as id,b.name as name,count(c.id) as count_content FROM bnm_banks AS b
                            // LEFT JOIN bnm_bank_content ON b.id=c.bank_id";
                            $where = "type = '1'";
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        default:
                            die(self::Json_Message('af'));
                            break;
                    }
                } else {
                    die(self::Json_Message('af'));
                }

                break;
            case 'banks':
                if (self::Login_Just_Check()) {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            unset($data['datatable_request']);
                            unset($data['request']);
                            $table = 'bnm_banks';
                            $primaryKey = 'id';
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'name', 'dt' => 'name'),
                                // array('db' => 'count_content', 'dt' => 'count_content'),
                            );
                            // $table="SELECT b.id as id,b.name as name,count(c.id) as count_content FROM bnm_banks AS b
                            // LEFT JOIN bnm_bank_content ON b.id=c.bank_id";
                            $where = false;
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        default:
                            die(self::Json_Message('af'));
                            break;
                    }
                } else {
                    die(self::Json_Message('af'));
                }

                break;
            case 'services_contract':
                if (self::Login_Just_Check()) {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            unset($data['datatable_request']);
                            unset($data['request']);
                            $table = 'bnm_services_contract';
                            $primaryKey = 'id';
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'service_type', 'dt' => 'service_type'),
                                array('db' => 'contract_subject', 'dt' => 'contract_subject'),
                            );
                            $where = false;
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        default:
                            die(self::Json_Message('af'));
                            break;
                    }
                } else {
                    die(self::Json_Message('af'));
                }

                break;
            case 'support_requests_inbox':
                if (self::Login_Just_Check()) {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            //get all messages
                            unset($data['datatable_request']);
                            unset($data['request']);
                            $table = 'bnm_support_requests';
                            $primaryKey = 'id';
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'noe_payam', 'dt' => 'noe_payam'),
                                array('db' => 'onvane_payam', 'dt' => 'onvane_payam'),
                                array('db' => 'matne_payam', 'dt' => 'matne_payam'),
                            );
                            $where = false;
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        case __MODIRUSERTYPE__:
                        case __OPERATORUSERTYPE__:
                            //get branch messages
                            unset($data['datatable_request']);
                            unset($data['request']);
                            $table = 'bnm_support_requests';
                            $primaryKey = 'id';
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'noe_payam', 'dt' => 'noe_payam'),
                                array('db' => 'onvane_payam', 'dt' => 'onvane_payam'),
                                array('db' => 'matne_payam', 'dt' => 'matne_payam'),
                            );
                            //parantez1 -> moshahede payamhaye moshtarakine namayande
                            //parantez1 -> moshahede payamhaye admin ya operator
                            $where = "(sender_id <> {$_SESSION['id']}
                            AND sender_user_type NOT IN (" . __MODIRUSERTYPE__ . "," . __OPERATORUSERTYPE__ . "," . __MODIR2USERTYPE__ . "," . __OPERATOR2USERTYPE__ . ")
                            AND sender_branch_id = {$_SESSION['branch_id']})
                            OR (sender_id <> {$_SESSION['id']}
                            AND sender_user_type NOT IN (" . __MODIRUSERTYPE__ . "," . __OPERATORUSERTYPE__ . "," . __MODIR2USERTYPE__ . "," . __OPERATOR2USERTYPE__ . ")
                            AND reciever_user_id={$_SESSION['user_id']}
                            AND reciever_user_type IN (" . __ADMINUSERTYPE__ . "," . __ADMINOPERATORUSERTYPE__ . "," . __MOSHTARAKUSERTYPE__ . "))";

                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        case __MOSHTARAKUSERTYPE__:
                            //get messages where reci
                            unset($data['datatable_request']);
                            unset($data['request']);
                            $table = 'bnm_support_requests';
                            $primaryKey = 'id';
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'noe_payam', 'dt' => 'noe_payam'),
                                array('db' => 'onvane_payam', 'dt' => 'onvane_payam'),
                                array('db' => 'matne_payam', 'dt' => 'matne_payam'),
                            );
                            $where = "sender_id <> {$_SESSION['id']}
                            AND sender_user_type IN (" . __ADMINUSERTYPE__ . "," . __ADMINOPERATORUSERTYPE__ . "," . __MODIRUSERTYPE__ . "," . __OPERATORUSERTYPE__ . "," . __MODIR2USERTYPE__ . "," . __OPERATOR2USERTYPE__ . ")
                            AND reciever_user_id={$_SESSION['user_id']}
                            AND reciever_user_type=" . __MOSHTARAKUSERTYPE__ . "";
                            $where = false;
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                    }
                } else {
                    die(self::Json_Message('af'));
                }

                break;
            case 'equipments_models':
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                        unset($data['datatable_request']);
                        unset($data['request']);
                        $columns = array(
                            array('db' => 'id', 'dt' => 'id'),
                            array('db' => 'name', 'dt' => 'name'),
                            array('db' => 'exdate', 'dt' => 'exdate'),
                            array('db' => 'brand_id', 'dt' => 'brand_id'),
                        );
                        $where = false;
                        return json_encode(Db::simple($data, 'bnm_equipments_models', 'id', $columns, $where));
                        break;
                    default:
                        return (self::Json_Message('af'));
                        break;
                }
                break;
            case 'equipments_brands':
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                        unset($data['datatable_request']);
                        unset($data['request']);
                        $table = 'bnm_equipments_brands';
                        $primaryKey = 'id';
                        $columns = array(
                            array('db' => 'id', 'dt' => 'id'),
                            array('db' => 'name', 'dt' => 'name'),
                        );
                        $where = false;
                        return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                        break;
                    default:
                        return (self::Json_Message('af'));
                        break;
                }
                break;
            case 'sent_sms':
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                    case __MODIR2USERTYPE__:
                    case __MODIRUSERTYPE__:
                    case __OPERATOR2USERTYPE__:
                    case __OPERATORUSERTYPE__:
                        unset($data['datatable_request']);
                        unset($data['request']);
                        $table = 'bnm_sms_queue';
                        $primaryKey = 'id';
                        $columns = array(
                            array('db' => 'id', 'dt' => 'id'),
                            array('db' => 'sender', 'dt' => 'sender'),
                            array('db' => 'receiver', 'dt' => 'receiver'),
                            array('db' => 'message', 'dt' => 'message'),
                            array('db' => 'status_message', 'dt' => 'status_message'),
                            array('db' => 'date', 'dt' => 'date'),
                        );
                        $table = "(
                            SELECT sq.id , sq.receiver,m.message,sq.sender,sq.status_message,sq.date
                            FROM bnm_sms_queue sq
                            LEFT JOIN bnm_send_sms_requests ssr ON sq.request_id = ssr.id
                            INNER JOIN bnm_messages m ON ssr.message_id = m.id
                        )tmp";
                        $where = false;
                        return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                        break;
                    default:
                        return (self::Json_Message('af'));
                        break;
                }
                break;
            case 'province':
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                        unset($data['datatable_request']);
                        unset($data['request']);
                        $table = 'bnm_ostan';
                        $primaryKey = 'id';
                        $columns = array(
                            array('db' => 'id', 'dt' => 'id'),
                            array('db' => 'name', 'dt' => 'name'),
                            array('db' => 'pish_shomare_ostan', 'dt' => 'pish_shomare_ostan'),
                            array('db' => 'code_ostan_shahkar', 'dt' => 'code_ostan_shahkar'),
                            array('db' => 'code_markazeostan', 'dt' => 'code_markazeostan'),
                            array('db' => 'code_atrafemarkazeostan', 'dt' => 'code_atrafemarkazeostan'),
                            array('db' => 'code_biaban', 'dt' => 'code_biaban'),
                            array('db' => 'code_shahrestan', 'dt' => 'code_shahrestan'),
                            array('db' => 'code_atrafeshahrestan', 'dt' => 'code_atrafeshahrestan'),
                        );
                        $where = false;
                        return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                        break;
                    default:
                        return (self::Json_Message('af'));
                        break;
                }

                break;
            case 'wireless_ap':
                if (self::Login_Just_Check()) {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                        case __MODIRUSERTYPE__:
                        case __MODIR2USERTYPE__:
                        case __OPERATOR2USERTYPE__:
                        case __OPERATORUSERTYPE__:
                            unset($data['datatable_request']);
                            unset($data['request']);
                            $table = 'bnm_wireless_ap';
                            $primaryKey = 'id';
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'tarikhe_sabt', 'dt' => 'tarikhe_sabt'),
                                array('db' => 'link_name', 'dt' => 'link_name'),
                                array('db' => 'popsite', 'dt' => 'popsite'),
                                array('db' => 'tol_joghrafiai', 'dt' => 'tol_joghrafiai'),
                                array('db' => 'arz_joghrafiai', 'dt' => 'arz_joghrafiai'),
                                array('db' => 'ertefae_dakal', 'dt' => 'ertefae_dakal'),
                            );
                            $where = false;
                            $table = "
                                (SELECT
                                ap.id,ap.tarikhe_sabt,ap.link_name,ap.tol_joghrafiai,ap.arz_joghrafiai,pop.name_dakal popsite,ap.ertefae_dakal
                                FROM bnm_wireless_ap ap
                                LEFT JOIN bnm_popsite pop ON ap.popsite = pop.id
                                ) tmp
                            ";
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;

                        default:
                            die(self::Json_Message('af'));
                            break;
                    }
                } else {
                    die(self::Json_Message('af'));
                }
                break;
            case 'wireless_station':
                if (self::Login_Just_Check()) {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            unset($data['datatable_request']);
                            unset($data['request']);
                            // $table      = 'bnm_wireless_station';
                            $primaryKey = 'id';
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'tarikhe_sabt', 'dt' => 'tarikhe_sabt'),
                                array('db' => 'popsite', 'dt' => 'popsite'),
                                array('db' => 'link_name', 'dt' => 'link_name'),
                                array('db' => 'mokhtasat', 'dt' => 'mokhtasat'),
                                array('db' => 'istgahe_dovom', 'dt' => 'istgahe_dovom'),

                            );
                            $where = false;
                            $table = "
                                (SELECT
                                    st.id,
                                    pop.name_dakal popsite,
                                    st.tarikhe_sabt tarikhe_sabt,
                                    CONCAT('N',st.arz_joghrafiai,'-','E',st.tol_joghrafiai) AS mokhtasat,
                                    st.istgahe_dovom istgahe_dovom,
                                    ap.link_name link_name
                                FROM bnm_wireless_station st
                                LEFT JOIN bnm_wireless_ap ap ON st.wireless_ap = ap.id
                                LEFT JOIN bnm_popsite pop ON ap.popsite = pop.id
                                ) tmp
                            ";
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        case __MODIRUSERTYPE__:
                        case __MODIR2USERTYPE__:
                        case __OPERATOR2USERTYPE__:
                        case __OPERATORUSERTYPE__:
                            unset($data['datatable_request']);
                            unset($data['request']);
                            // $table      = 'bnm_wireless_station';
                            $primaryKey = 'id';
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'tarikhe_sabt', 'dt' => 'tarikhe_sabt'),
                                array('db' => 'popsite', 'dt' => 'popsite'),
                                array('db' => 'link_name', 'dt' => 'link_name'),
                                array('db' => 'mokhtasat', 'dt' => 'mokhtasat'),
                                array('db' => 'istgahe_dovom', 'dt' => 'istgahe_dovom'),

                            );
                            $where = false;
                            $table = "
                                (SELECT
                                    st.id,
                                    pop.name_dakal popsite,
                                    st.tarikhe_sabt tarikhe_sabt,
                                    CONCAT('N',st.arz_joghrafiai,'-','E',st.tol_joghrafiai) AS mokhtasat,
                                    st.istgahe_dovom istgahe_dovom,
                                    ap.link_name link_name
                                FROM bnm_wireless_station st
                                LEFT JOIN bnm_wireless_ap ap ON st.wireless_ap = ap.id
                                LEFT JOIN bnm_popsite pop ON ap.popsite = pop.id
                                ) tmp
                            ";
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;

                        default:
                            die(self::Json_Message('af'));
                            break;
                    }
                } else {
                    die(self::Json_Message('af'));
                }
                break;
            case 'city':
                if (self::Login_Just_Check()) {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            unset($data['datatable_request']);
                            unset($data['request']);
                            $table = 'bnm_shahr';
                            $primaryKey = 'id';
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'name', 'dt' => 'name'),
                                array('db' => 'ostan_name', 'dt' => 'ostan_name'),
                            );
                            $where = false;
                            $table = "
                                (SELECT
                                city.id AS id ,city.name AS name , ostan.name AS ostan_name
                                FROM bnm_shahr city
                                LEFT JOIN bnm_ostan ostan
                                ON city.ostan_id = ostan.id) tmp
                            ";
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;

                        default:
                            die(self::Json_Message('af'));
                            break;
                    }
                } else {
                    die(self::Json_Message('af'));
                }

                break;
            case 'terminal':
                if (self::Login_Just_Check()) {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            unset($data['datatable_request']);
                            unset($data['request']);
                            $primaryKey = 'id';
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'tername', 'dt' => 'tername'),
                                array('db' => 'tcname', 'dt' => 'tcname'),
                                array('db' => 'radif', 'dt' => 'radif'),
                                array('db' => 'tighe', 'dt' => 'tighe'),
                                array('db' => 'shoroe_etesali', 'dt' => 'shoroe_etesali'),
                            );
                            // $table = 'bnm_terminal';
                            $table = "(SELECT ter.id,ter.name tername, tc.name tcname, ter.radif, ter.tighe, ter.shoroe_etesali FROM bnm_terminal ter 
                            INNER JOIN bnm_telecommunications_center tc ON tc.id = ter.markaze_mokhaberati) tmp";
                            $where = false;
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;

                        default:
                            die(self::Json_Message('af'));
                            break;
                    }
                } else {
                    die(self::Json_Message('af'));
                }
                break;
            case 'telecommunications_center':
                if (self::Login_Just_Check()) {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            unset($data['datatable_request']);
                            unset($data['request']);
                            $table = 'bnm_telecommunications_center';
                            $primaryKey = 'id';
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'name', 'dt' => 'name'),
                                array('db' => 'pish_shomare_ostan', 'dt' => 'pish_shomare_ostan'),
                                array('db' => 'shomare_tamas_markaz', 'dt' => 'shomare_tamas_markaz'),
                                array('db' => 'masire_avale_faktorha', 'dt' => 'masire_avale_faktorha'),
                                array('db' => 'masire_dovome_faktorha', 'dt' => 'masire_dovome_faktorha'),
                                array('db' => 'noe_gharardad', 'dt' => 'noe_gharardad')
                            );
                            $where = false;
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;

                        default:
                            die(self::Json_Message('af'));
                            break;
                    }
                } else {
                    die(self::Json_Message('af'));
                }
                break;
            case 'pre_number':
                if (self::Login_Just_Check()) {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            unset($data['datatable_request']);
                            unset($data['request']);
                            // $table = 'bnm_shahr';
                            $primaryKey = 'id';
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'prenumber', 'dt' => 'prenumber'),
                                array('db' => 'os_tc_name', 'dt' => 'os_tc_name'),
                            );
                            $where = false;
                            // CONCAT(tc.telecentername,' ( ',os.name,' ) ',' پیش شماره استان ',os.pish_shomare_ostan) tcname_osname_osprenum
                            $table = "(
                                SELECT
                                    pr.id,
                                    pr.prenumber,
                                    CONCAT(tc.name, ' (',sh.name,') ') os_tc_name
                            FROM
                                bnm_pre_number pr
                                INNER JOIN bnm_telecommunications_center tc ON tc.id = pr.markaze_mokhaberati
                                INNER JOIN bnm_ostan os ON os.id = tc.ostan
                                INNER JOIN bnm_shahr sh ON sh.id = tc.shahr
                            )tmp";
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;

                        default:
                            die(self::Json_Message('af'));
                            break;
                    }
                } else {
                    die(self::Json_Message('af'));
                }

                break;
            case 'port':

                if (self::Login_Just_Check()) {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            unset($data['datatable_request']);
                            unset($data['request']);
                            $table = 'bnm_port';
                            $primaryKey = 'id';
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'terminal', 'dt' => 'terminal'),
                                array('db' => 'etesal', 'dt' => 'etesal'),
                                array('db' => 'radif', 'dt' => 'radif'),
                                array('db' => 'tighe', 'dt' => 'tighe'),
                                array('db' => 'dslam', 'dt' => 'dslam'),
                                array('db' => 'kart', 'dt' => 'kart'),
                                array('db' => 'port', 'dt' => 'port'),
                                array('db' => 'adsl_vdsl', 'dt' => 'adsl_vdsl'),
                                array('db' => 'status', 'dt' => 'status'),
                                array('db' => 'telephone', 'dt' => 'telephone'),
                            );
                            // $where = false;
                            if (isset($_POST['filter'])) {
                                $terminal = $_POST['filter'];
                                if ($terminal != '') {
                                    $where = "terminal = '$terminal'";
                                } else {
                                    $where = false;
                                }
                            }
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;

                        default:
                            die(self::Json_Message('af'));
                            break;
                    }
                } else {
                    die(self::Json_Message('af'));
                }

                break;
            case 'test':
                if (self::Login_Just_Check()) {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            unset($data['datatable_request']);
                            unset($data['request']);
                            $table = 'eusers';
                            $primaryKey = 'id';
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'name', 'dt' => 'name'),
                                array('db' => 'lname', 'dt' => 'lname'),
                                array('db' => 'fathername', 'dt' => 'fathername'),
                                array('db' => 'ncode', 'dt' => 'ncode'),
                                array('db' => 'birth', 'dt' => 'birth'),
                                array('db' => 'mobile', 'dt' => 'mobile'),
                                array('db' => 'tel', 'dt' => 'tel'),
                                array('db' => 'address', 'dt' => 'address'),
                                array('db' => 'noe_moshtarak', 'dt' => 'noe_moshtarak'),
                                array('db' => 'pin', 'dt' => 'pin'),
                            );
                            $where = false;
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;

                        default:
                            die(self::Json_Message('af'));
                            break;
                    }
                } else {
                    die(self::Json_Message('af'));
                }

                break;
            case 'country':
                if (self::Login_Just_Check()) {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            unset($data['datatable_request']);
                            unset($data['request']);
                            $table = 'bnm_countries';
                            $primaryKey = 'id';
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'name', 'dt' => 'name'),
                                array('db' => 'code', 'dt' => 'code'),
                            );
                            $where = false;
                            // $table = "
                            //     (SELECT
                            //     city.id AS id ,city.name AS name , ostan.name AS ostan_name
                            //     FROM bnm_shahr city
                            //     LEFT JOIN bnm_ostan ostan
                            //     ON city.ostan_id = ostan.id) tmp
                            // ";
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;

                        default:
                            die(self::Json_Message('af'));
                            break;
                    }
                } else {
                    die(self::Json_Message('af'));
                }

                break;
            case 'connection_log_postfix':
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                        unset($data['connection_log_postfix']);
                        unset($data['request']);
                        $table = 'bnm_connection_log';
                        $primaryKey = 'id';
                        $columns = array(
                            array('db' => 'id', 'dt' => 'id'),
                            array('db' => 'name', 'dt' => 'name'),
                            array('db' => 'postfix', 'dt' => 'postfix'),
                        );

                        $where = false;
                        return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                        break;
                    default:
                        die(self::Json_Message('af'));
                        break;
                }
                break;
            case 'branch_cooperation_type':

                // unset($data['branch_cooperation_type']);
                // unset($data['request']);
                if (self::Login_Just_Check()) {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            $table = 'bnm_branch_cooperation_type';
                            $primaryKey = 'id';
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'service_type', 'dt' => 'service_type'),
                                array('db' => 'cooperation_type', 'dt' => 'cooperation_type'),
                                array('db' => 'branch_id', 'dt' => 'branch_id'),
                            );
                            $table = "
                                            (SELECT
                                            bc.id AS id ,bc.service_type AS service_type ,bc.cooperation_type AS cooperation_type,branch.name_sherkat as branch_id
                                            FROM bnm_branch_cooperation_type bc
                                            LEFT JOIN bnm_branch branch
                                            ON bc.branch_id = branch.id) tmp
                                        ";
                            $where = false;
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        default:
                            return self::Json_Message('af');
                            break;
                    }
                } else {
                    return self::Json_Message('af');
                }

                break;
            case 'credits':
                if (self::Login_Just_Check()) {
                    if (isset($data['filter'])) {
                        if ($data['filter'] == 'moshtarak') {
                            switch ($_SESSION['user_type']) {
                                case __ADMINUSERTYPE__:
                                case __ADMINOPERATORUSERTYPE__:
                                    $table = 'bnm_subscribers';
                                    $primaryKey = 'id';
                                    $columns = array(
                                        array('db' => 'id', 'dt' => 'id'),
                                        array('db' => 'name', 'dt' => 'name'),
                                        array('db' => 'code_meli', 'dt' => 'code_meli'),
                                        array('db' => 'telephone1', 'dt' => 'telephone1'),
                                        array('db' => 'telephone_hamrah', 'dt' => 'telephone_hamrah'),
                                        array('db' => 'noe_moshtarak', 'dt' => 'noe_moshtarak'),
                                    );
                                    $table = "(
                                        SELECT
                                            sub.id,
                                            IF(sub.noe_moshtarak = 'real', CONCAT( sub.name, ' ', sub.f_name ),sub.name_sherkat) name,
                                            IF(sub.noe_moshtarak = 'real', sub.code_meli,sub.shomare_sabt) code_meli,
                                            sub.telephone1,
                                            sub.telephone_hamrah,
                                            IF(sub.noe_moshtarak = 'real', 'حقیقی', 'حقوقی') noe_moshtarak
                                            FROM bnm_subscribers sub ORDER BY id DESC
                                        )tmp";
                                    $where = false;
                                    return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                                    break;

                                default:
                                    die(self::Json_Message('auth_fail'));
                                    break;
                            }
                        } elseif ($data['filter'] == 'namayande') {
                            switch ($_SESSION['user_type']) {
                                case __ADMINUSERTYPE__:
                                    $table = 'bnm_branch';
                                    $primaryKey = 'id';
                                    $columns = array(
                                        array('db' => 'id', 'dt' => 'id'),
                                        array('db' => 'name_sherkat', 'dt' => 'name_sherkat'),
                                    );
                                    $where = false;
                                    return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                                    break;
                                case __MODIRUSERTYPE__:
                                    $table = 'bnm_branch';
                                    $primaryKey = 'id';
                                    $columns = array(
                                        array('db' => 'id', 'dt' => 'id'),
                                        array('db' => 'name_sherkat', 'dt' => 'name_sherkat'),
                                    );
                                    $where = "branch_id={$_SESSION['branch_id']}";
                                    return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                                    break;
                                case __OPERATORUSERTYPE__:
                                    $table = 'bnm_branch';
                                    $primaryKey = 'id';
                                    $columns = array(
                                        array('db' => 'id', 'dt' => 'id'),
                                        array('db' => 'name_sherkat', 'dt' => 'name_sherkat'),
                                    );
                                    $where = "branch_id={$_SESSION['branch_id']}";
                                    return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                                    break;

                                default:
                                    die(self::Json_Message('auth_fail'));
                                    break;
                            }
                        }
                    }
                } else {
                    return json_encode(array('error'));
                }
                break;
            case 'credits_display':
                if (self::Login_Just_Check()) {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            if (self::Is_Empty_OR_Null($data['filter']) && self::Is_Empty_OR_Null($data['filter2'])) {
                                if ($data['filter'] == 'moshtarak') {
                                    $data['filter'] = '1';
                                } elseif ($data['filter'] == 'namayande') {
                                    $data['filter'] = '2';
                                } else {
                                    die(self::Json_Message('info_not_true'));
                                }
                                $table = 'bnm_credits';
                                $primaryKey = 'id';
                                $columns = array(
                                    array('db' => 'id', 'dt' => 'id'),
                                    array('db' => 'credit', 'dt' => 'credit'),
                                    array('db' => 'update_time', 'dt' => 'update_time'),
                                    array('db' => 'bedehkar', 'dt' => 'bedehkar'),
                                    array('db' => 'bestankar', 'dt' => 'bestankar'),
                                    array('db' => 'tozihat', 'dt' => 'tozihat'),
                                );
                                $table = "(SELECT
                                            id, update_time, FORMAT(credit,0) credit, FORMAT(bedehkar,0) bedehkar,
                                            FORMAT(bestankar,0) bestankar, tozihat
                                            FROM bnm_credits WHERE user_or_branch_id= {$data['filter2']} AND noe_user={$data['filter']}
                                            ) tmp
                                        ";
                                $where = false;
                            } else {
                                die(self::Json_Message('info_not_true'));
                            }
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                        case __MODIRUSERTYPE__:
                        case __MODIR2USERTYPE__:
                        case __OPERATORUSERTYPE__:
                        case __OPERATOR2USERTYPE__:
                            $table = 'bnm_credits';
                            $primaryKey = 'id';
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'credit', 'dt' => 'credit'),
                                array('db' => 'update_time', 'dt' => 'update_time'),
                                array('db' => 'bedehkar', 'dt' => 'bedehkar'),
                                array('db' => 'bestankar', 'dt' => 'bestankar'),
                                array('db' => 'tozihat', 'dt' => 'tozihat'),
                            );
                            // $table= "(
                            //     SELECT c.id, c.credit, c.update_time, c.bedehkar, c.bestankar, c.tozihat
                            //     FROM bnm_credits c
                            //     WHERE noe_user = '2' AND user_or_branch_id = ".$_SESSION['user_id']." 
                            // )tmp";
                            // $table= "(
                            //     SELECT 
                            // )tmp";
                            // $table = 
                            // $where = "user_or_branch_id= {$data['filter2']} AND noe_user={$data['filter']}";
                            $table = "(SELECT
                                            id, update_time, FORMAT(credit,0) credit, FORMAT(bedehkar,0) bedehkar,
                                            FORMAT(bestankar,0) bestankar, tozihat
                                            FROM bnm_credits WHERE user_or_branch_id= {$_SESSION['user_id']} AND noe_user='2'
                                            ) tmp
                                        ";
                            $where = false;
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        case __MOSHTARAKUSERTYPE__:
                            $table = 'bnm_credits';
                            $primaryKey = 'id';
                            $columns = array(
                                array('db' => 'credit', 'dt' => 'credit'),
                                array('db' => 'update_time', 'dt' => 'update_time'),
                                array('db' => 'bedehkar', 'dt' => 'bedehkar'),
                                array('db' => 'bestankar', 'dt' => 'bestankar'),
                                array('db' => 'tozihat', 'dt' => 'tozihat'),
                            );
                            $table = "(SELECT
                                            id, update_time, FORMAT(credit,0) credit, FORMAT(bedehkar,0) bedehkar,
                                            FORMAT(bestankar,0) bestankar, tozihat
                                            FROM bnm_credits WHERE user_or_branch_id= {$_SESSION['user_id']} AND noe_user='1'
                                            ) tmp
                                        ";
                            $where = false;
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        default:
                            die(self::Json_Message('auth_fail'));
                            break;
                    }
                } else {
                    die(self::Json_Message('auth_fail'));
                }
                return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                break;
            case 'pre_internal_real_subscribers':
                if (self::Login_Just_Check()) {
                    $table = 'bnm_presubscribers';
                    $primaryKey = 'id';
                    $columns = array(
                        array('db' => 'id', 'dt' => 'id'),
                        array('db' => 'code_eshterak', 'dt' => 'code_eshterak'),
                        array('db' => 'name', 'dt' => 'name'),
                        array('db' => 'f_name', 'dt' => 'f_name'),
                        array('db' => 'code_meli', 'dt' => 'code_meli'),
                        array('db' => 'telephone_hamrah', 'dt' => 'telephone_hamrah'),
                        array('db' => 'telephone1', 'dt' => 'telephone1'),
                        array('db' => 'shomare_shenasname', 'dt' => 'shomare_shenasname'),
                        array('db' => 'code_posti1', 'dt' => 'code_posti1'),
                    );
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            $where = "noe_moshtarak='real' AND confirmstatus = 2";
                            break;
                        case __MODIRUSERTYPE__:
                        case __MODIR2USERTYPE__:
                        case __OPERATORUSERTYPE__:
                        case __OPERATOR2USERTYPE__:
                            $where = "branch_id = {$_SESSION['branch_id']} AND noe_moshtarak='real' AND confirmstatus = 2";
                            break;
                        case __MOSHTARAKUSERTYPE__:
                            $where = "id={$_SESSION['user_id']} AND noe_moshtarak='real' AND confirmstatus = 2";
                            break;
                        default:
                            return self::Json_Message('auth_fail');
                            break;
                    }
                    return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                }
                break;
            case 'real_subscribers':
                if (self::Login_Just_Check()) {
                    $table = 'bnm_subscribers';
                    $primaryKey = 'id';
                    $columns = array(
                        array('db' => 'id', 'dt' => 'id'),
                        array('db' => 'code_eshterak', 'dt' => 'code_eshterak'),
                        array('db' => 'name', 'dt' => 'name'),
                        array('db' => 'f_name', 'dt' => 'f_name'),
                        array('db' => 'code_meli', 'dt' => 'code_meli'),
                        array('db' => 'telephone_hamrah', 'dt' => 'telephone_hamrah'),
                        array('db' => 'telephone1', 'dt' => 'telephone1'),
                        array('db' => 'shomare_shenasname', 'dt' => 'shomare_shenasname'),
                        array('db' => 'code_posti1', 'dt' => 'code_posti1'),
                    );
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            $where = "noe_moshtarak='real'";
                            break;
                        case __MODIRUSERTYPE__:
                        case __MODIR2USERTYPE__:
                        case __OPERATORUSERTYPE__:
                        case __OPERATOR2USERTYPE__:
                            $where = "branch_id = {$_SESSION['branch_id']} AND noe_moshtarak='real'";
                            break;
                        case __MOSHTARAKUSERTYPE__:
                            $where = "id={$_SESSION['user_id']} AND noe_moshtarak='real'";
                            break;
                        default:
                            return self::Json_Message('auth_fail');
                            break;
                    }
                    return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                }
                break;
            case 'pre_internal_legal_subscribers':
                if (self::Login_Just_Check()) {
                    $table = 'bnm_presubscribers';
                    $primaryKey = 'id';
                    $columns = array(
                        array('db' => 'id', 'dt' => 'id'),
                        array('db' => 'name', 'dt' => 'name'),
                        array('db' => 'f_name', 'dt' => 'f_name'),
                        array('db' => 'name_sherkat', 'dt' => 'name_sherkat'),
                        array('db' => 'code_meli', 'dt' => 'code_meli'),
                        array('db' => 'telephone1', 'dt' => 'telephone1'),
                        array('db' => 'telephone_hamrah', 'dt' => 'telephone_hamrah'),
                        array('db' => 'code_posti1', 'dt' => 'code_posti1'),
                    );

                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            $where = "noe_moshtarak='legal' AND confirmstatus = 2";
                            break;
                        case __MODIRUSERTYPE__:
                        case __OPERATORUSERTYPE__:
                        case __MODIR2USERTYPE__:
                        case __OPERATOR2USERTYPE__:
                            $where = "branch_id = {$_SESSION['branch_id']} AND noe_moshtarak='legal' AND confirmstatus = 2";
                            break;
                        case __MOSHTARAKUSERTYPE__:
                            $where = "id={$_SESSION['user_id']} AND noe_moshtarak='legal' AND confirmstatus = 2";
                            break;
                        default:
                            return self::Json_Message('auth_fail');
                            break;
                    }
                    return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                }
                break;
            case 'legal_subscribers':
                if (self::Login_Just_Check()) {
                    $table = 'bnm_subscribers';
                    $primaryKey = 'id';
                    $columns = array(
                        array('db' => 'id', 'dt' => 'id'),
                        array('db' => 'name', 'dt' => 'name'),
                        array('db' => 'f_name', 'dt' => 'f_name'),
                        array('db' => 'name_sherkat', 'dt' => 'name_sherkat'),
                        array('db' => 'code_eshterak', 'dt' => 'code_eshterak'),
                        array('db' => 'code_meli', 'dt' => 'code_meli'),
                        array('db' => 'telephone1', 'dt' => 'telephone1'),
                        array('db' => 'telephone_hamrah', 'dt' => 'telephone_hamrah'),
                        array('db' => 'code_posti1', 'dt' => 'code_posti1'),
                    );

                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            $where = "noe_moshtarak='legal'";
                            break;
                        case __MODIRUSERTYPE__:
                        case __OPERATORUSERTYPE__:
                        case __MODIR2USERTYPE__:
                        case __OPERATOR2USERTYPE__:
                            $where = "branch_id = {$_SESSION['branch_id']} AND noe_moshtarak='legal'";
                            break;
                        case __MOSHTARAKUSERTYPE__:
                            $where = "id={$_SESSION['user_id']} AND noe_moshtarak='legal'";
                            break;
                        default:
                            return self::Json_Message('auth_fail');
                            break;
                    }
                    return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                }
                break;
            case 'factors_init':
                if (self::Login_Just_Check()) {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                            //die(json_encode(array('bbb')));
                            $table = 'bnm_subscribers';
                            $primaryKey = 'id';
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'name', 'dt' => 'name'),
                                array('db' => 'code_meli', 'dt' => 'code_meli'),
                                array('db' => 'telephone1', 'dt' => 'telephone1'),
                                array('db' => 'telephone_hamrah', 'dt' => 'telephone_hamrah'),
                                array('db' => 'noe_moshtarak', 'dt' => 'noe_moshtarak'),
                            );
                            $table = "(
                                SELECT
                                    sub.id,
                                    IF(sub.noe_moshtarak = 'real', CONCAT( sub.name, ' ', sub.f_name ),sub.name_sherkat) name,
                                    IF(sub.noe_moshtarak = 'real', sub.code_meli,sub.shomare_sabt) code_meli,
                                    sub.telephone1,
                                    sub.telephone_hamrah,
                                    IF(sub.noe_moshtarak = 'real', 'حقیقی', 'حقوقی') noe_moshtarak
                                    FROM bnm_subscribers sub ORDER BY id DESC
                                )tmp";
                            $where = false;
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        case __MODIRUSERTYPE__:
                        case __MODIR2USERTYPE__:
                        case __OPERATORUSERTYPE__:
                        case __OPERATOR2USERTYPE__:
                            $table = 'bnm_subscribers';
                            $primaryKey = 'id';
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'name', 'dt' => 'name'),
                                array('db' => 'code_meli', 'dt' => 'code_meli'),
                                array('db' => 'telephone1', 'dt' => 'telephone1'),
                                array('db' => 'telephone_hamrah', 'dt' => 'telephone_hamrah'),
                                array('db' => 'noe_moshtarak', 'dt' => 'noe_moshtarak'),
                            );
                            $table = "(
                                SELECT
                                    sub.id,
                                    IF(sub.noe_moshtarak = 'real', CONCAT( sub.name, ' ', sub.f_name ),sub.name_sherkat) name,
                                    IF(sub.noe_moshtarak = 'real', sub.code_meli,sub.shomare_sabt) code_meli,
                                    sub.telephone1,
                                    sub.telephone_hamrah,
                                    IF(sub.noe_moshtarak = 'real', 'حقیقی', 'حقوقی') noe_moshtarak
                                FROM bnm_subscribers sub 
                                WHERE sub.branch_id = {$_SESSION['branch_id']}
                                ORDER BY id DESC
                                )tmp";
                            $where = false;
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        case __MOSHTARAKUSERTYPE__:
                            $table = 'bnm_subscribers';
                            $primaryKey = 'id';
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'name', 'dt' => 'name'),
                                array('db' => 'code_meli', 'dt' => 'code_meli'),
                                array('db' => 'telephone1', 'dt' => 'telephone1'),
                                array('db' => 'telephone_hamrah', 'dt' => 'telephone_hamrah'),
                                array('db' => 'noe_moshtarak', 'dt' => 'noe_moshtarak'),
                            );
                            $table = "(
                                    SELECT
                                        sub.id,
                                        IF(sub.noe_moshtarak = 'real', CONCAT( sub.name, ' ', sub.f_name ),sub.name_sherkat) name,
                                        IF(sub.noe_moshtarak = 'real', sub.code_meli,sub.shomare_sabt) code_meli,
                                        sub.telephone1,
                                        sub.telephone_hamrah,
                                        IF(sub.noe_moshtarak = 'real', 'حقیقی', 'حقوقی') noe_moshtarak
                                    FROM bnm_subscribers sub 
                                    WHERE sub.id = {$_SESSION['user_id']}
                                    ORDER BY id DESC
                                    )tmp";
                            $where = false;
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        default:
                            die(self::Json_Message('auth_fail'));
                            break;
                    }
                } else {
                    die(self::Json_Message('auth_fail'));
                }
                break;
            case 'factorha_factors_tab':
                if (self::Login_Just_Check()) {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            $table = 'bnm_factor';
                            $primaryKey = 'id';
                            $where = false;
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'name', 'dt' => 'name'),
                                array('db' => 'telephone1', 'dt' => 'telephone1'),
                                array(
                                    'db' => 'tarikhe_factor', 'dt' => 'tarikhe_factor',
                                    'formatter' => function ($d, $row) {
                                        $tmp = $d;
                                        if ($d) {
                                            $tmp = date("Y-m-d H:i:s", strtotime($d));
                                        }
                                        if (!$tmp) return $d;
                                        return Helper::TabdileTarikh($tmp, 1, '-', '-', false);
                                    }
                                ),
                                array('db' => 'tasvie_shode', 'dt' => 'tasvie_shode'),
                                array('db' => 'onvane_service', 'dt' => 'onvane_service'),
                                array('db' => 'mablaghe_ghabele_pardakht', 'dt' => 'mablaghe_ghabele_pardakht'),
                                //modify date
                                // array(
                                //     'db'        => 'start_date',
                                //     'dt'        => 4,
                                //     'formatter' => function( $d, $row ) {
                                //         return date( 'jS M y', strtotime($d));
                                //     }
                                // ),
                            );
                            $table = "(
                                SELECT
                                    fa.id,
                                    IF(sub.noe_moshtarak = 'real',CONCAT( sub.name, ' ', sub.f_name ),sub.name_sherkat) name,
                                    sub.telephone1,
                                    fa.tarikhe_factor,
                                    fa.onvane_service,
                                    fa.mablaghe_ghabele_pardakht,
                                    IF( fa.tasvie_shode = 1, 'تسویه شده', 'تسویه نشده' ) tasvie_shode 
                                FROM
                                    bnm_factor fa
                                    INNER JOIN bnm_subscribers sub ON sub.id = fa.subscriber_id
                                    INNER JOIN bnm_services ser ON ser.id = fa.service_id 
                                ORDER BY
                                    tarikhe_factor DESC
                            )tmp";
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        case __MODIRUSERTYPE__:
                        case __OPERATORUSERTYPE__:
                        case __MODIR2USERTYPE__:
                        case __OPERATOR2USERTYPE__:
                            $table = 'bnm_factor';
                            $primaryKey = 'id';
                            $where = false;
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'name', 'dt' => 'name'),
                                array('db' => 'telephone1', 'dt' => 'telephone1'),
                                array('db' => 'tarikhe_factor', 'dt' => 'tarikhe_factor'),
                                array('db' => 'tasvie_shode', 'dt' => 'tasvie_shode'),
                                array('db' => 'onvane_service', 'dt' => 'onvane_service'),
                                array('db' => 'mablaghe_ghabele_pardakht', 'dt' => 'mablaghe_ghabele_pardakht'),
                            );
                            $table = "(
                                SELECT
                                    fa.id,
                                    IF(sub.noe_moshtarak = 'real',CONCAT( sub.name, ' ', sub.f_name ),sub.name_sherkat) name,
                                    sub.telephone1,
                                    fa.tarikhe_factor,
                                    fa.onvane_service,
                                    fa.mablaghe_ghabele_pardakht,
                                    IF( fa.tasvie_shode = 1, 'تسویه شده', 'تسویه نشده' ) tasvie_shode 
                                FROM
                                    bnm_factor fa
                                    INNER JOIN bnm_subscribers sub ON sub.id = fa.subscriber_id
                                    INNER JOIN bnm_services ser ON ser.id = fa.service_id 
                                WHERE sub.branch_id = {$_SESSION['branch_id']}
                                ORDER BY
                                    tarikhe_factor DESC
                            )tmp";
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        case __MOSHTARAKUSERTYPE__:
                            $table = 'bnm_factor';
                            $primaryKey = 'id';
                            $where = false;
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'name', 'dt' => 'name'),
                                array('db' => 'telephone1', 'dt' => 'telephone1'),
                                array('db' => 'tarikhe_factor', 'dt' => 'tarikhe_factor'),
                                array('db' => 'tasvie_shode', 'dt' => 'tasvie_shode'),
                                array('db' => 'onvane_service', 'dt' => 'onvane_service'),
                                array('db' => 'mablaghe_ghabele_pardakht', 'dt' => 'mablaghe_ghabele_pardakht'),
                            );
                            $table = "(
                                SELECT
                                    fa.id,
                                    IF(sub.noe_moshtarak = 'real',CONCAT( sub.name, ' ', sub.f_name ),sub.name_sherkat) name,
                                    sub.telephone1,
                                    fa.tarikhe_factor,
                                    fa.onvane_service,
                                    fa.mablaghe_ghabele_pardakht,
                                    IF( fa.tasvie_shode = 1, 'تسویه شده', 'تسویه نشده' ) tasvie_shode 
                                FROM
                                    bnm_factor fa
                                    INNER JOIN bnm_subscribers sub ON sub.id = fa.subscriber_id
                                    INNER JOIN bnm_services ser ON ser.id = fa.service_id 
                                WHERE sub.id = {$_SESSION['user_id']}
                                ORDER BY
                                    tarikhe_factor DESC
                            )tmp";
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        default:
                            die(self::Json_Message('auth_fail'));
                            break;
                    }
                } else {
                    die(self::Json_Message('auth_fail'));
                }
                break;
            case 'ip_pool_list':

                // unset($data['branch_cooperation_type']);
                // unset($data['request']);
                if (self::Login_Just_Check()) {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            $table = 'bnm_ip_pool_list';
                            $primaryKey = 'id';
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'name', 'dt' => 'name'),
                                array('db' => 'discription', 'dt' => 'discription'),
                            );

                            $where = false;
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        default:
                            return self::Json_Message('af');
                            break;
                    }
                } else {
                    return self::Json_Message('af');
                }
                break;
            case 'ip':
                if (self::Login_Just_Check()) {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            $table = 'bnm_ip';
                            $primaryKey = 'id';
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'gender', 'dt' => 'gender'),
                                array('db' => 'pool', 'dt' => 'pool'),
                                array('db' => 'iptype', 'dt' => 'iptype'),
                                array('db' => 'ip', 'dt' => 'ip'),
                            );
                            $table = "(
                                    SELECT
                                        ip.id,
                                        pool.name pool,
                                        ip.ip ip,
                                        IF(ip.gender=1,'valid','invalid') gender,
                                        IF(ip.iptype=1,'static','dynamic') iptype
                                    FROM bnm_ip ip
                                    INNER JOIN bnm_ip_pool_list pool ON pool.id = ip.pool
                                )tmp";
                            $where = false;
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        default:
                            return self::Json_Message('af');
                            break;
                    }
                } else {
                    return self::Json_Message('af');
                }
                break;
            case 'contracts_report_display':
                if (self::Login_Just_Check()) {
                    $columns = array(
                        array('db' => 'id', 'dt' => 'id'),
                        array('db' => 'name', 'dt' => 'name'),
                        array('db' => 'f_name', 'dt' => 'f_name'),
                        array('db' => 'code_meli', 'dt' => 'code_meli'),
                        array('db' => 'telephone_hamrah', 'dt' => 'telephone_hamrah'),
                        array('db' => 'code', 'dt' => 'code'),
                        array('db' => 'tarikh', 'dt' => 'tarikh'),
                        array('db' => 'service_type', 'dt' => 'service_type'),
                    );
                    $table = 'bnm_subscribers';
                    $primaryKey = 'id';
                    $where = false;
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            $table = "(
                                    SELECT
                                        con.id id,
                                        sub.name name,
                                        sub.f_name f_name,
                                        sub.code_meli code_meli,
                                        sub.telephone_hamrah telephone_hamrah,
                                        con.code code,
                                        con.tarikh tarikh,
                                        sercon.service_type service_type
                                    FROM bnm_subscribers sub
                                    INNER JOIN bnm_sub_contract con ON con.subid= sub.id
                                    INNER JOIN bnm_services_contract sercon ON sercon.id= con.contractid
                                    WHERE con.status = 1
                                )tmp";
                            break;
                        case __MOSHTARAKUSERTYPE__:
                            $table = "(
                                    SELECT
                                    con.id id,
                                        sub.name name,
                                        sub.f_name f_name,
                                        sub.code_meli code_meli,
                                        sub.telephone_hamrah telephone_hamrah,
                                        con.code code,
                                        con.tarikh tarikh,
                                        sercon.service_type service_type
                                    FROM bnm_subscribers sub
                                    INNER JOIN bnm_sub_contract con ON con.subid= sub.id
                                    INNER JOIN bnm_services_contract sercon ON sercon.id= con.contractid
                                    WHERE con.status = 1 AND con.subid = {$_SESSION['user_id']}
                                )tmp";
                            break;
                        case __MODIRUSERTYPE__:
                        case __MODIR2USERTYPE__:
                        case __OPERATORUSERTYPE__:
                        case __OPERATOR2USERTYPE__:
                            $table = "(
                                    SELECT
                                    con.id id,
                                        sub.name name,
                                        sub.f_name f_name,
                                        sub.code_meli code_meli,
                                        sub.telephone_hamrah telephone_hamrah,
                                        con.code code,
                                        con.tarikh tarikh,
                                        sercon.service_type service_type
                                    FROM bnm_subscribers sub
                                    INNER JOIN bnm_sub_contract con ON con.subid= sub.id
                                    INNER JOIN bnm_services_contract sercon ON sercon.id= con.contractid
                                    WHERE con.status = 1 AND sub.branch_id = {$_SESSION['branch_id']}
                                )tmp";
                            break;
                        default:
                            return self::Json_Message('af');
                            break;
                    }
                    return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                } else {
                    return self::Json_Message('af');
                }
                break;
            case 'shahkar_services':
                if (self::Login_Just_Check()) {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            $table = 'shahkar_log';
                            $primaryKey = 'tarikh';
                            $columns = array(
                                array('db' => 'shenase_shahkar', 'dt' => 'shenase_shahkar'),
                                array('db' => 'shenase_factor', 'dt' => 'shenase_factor'),
                                array('db' => 'name', 'dt' => 'name'),
                                array('db' => 'telephone', 'dt' => 'telephone'),
                                array('db' => 'tarikh', 'dt' => 'tarikh'),
                                array('db' => 'comment', 'dt' => 'comment'),
                                array('db' => 'response', 'dt' => 'response'),
                                array('db' => 'responseid', 'dt' => 'responseid'),
                                array('db' => 'classifier', 'dt' => 'classifier'),
                            );
                            $table = "(
                                        SELECT
                                        sh.id shenase_shahkar,
                                        fa.id shenase_factor,
                                        CONCAT( sub.name, ' ', sub.f_name ) name,
                                        sh.comment,
                                        sh.response response,
                                        sh.classifier,
                                        sh.responseid,
                                        sub.telephone1 telephone,
                                        DATE_FORMAT( sh.tarikh, '%Y-%m-%d %H:%i' ) tarikh
                                    FROM shahkar_log sh
                                        INNER JOIN bnm_subscribers sub ON sub.id = sh.subscriber_id
                                        INNER JOIN bnm_factor fa ON sh.factor_id = fa.id
                                        INNER JOIN bnm_services ser ON fa.service_id = ser.id
                                    WHERE sh.noe_darkhast = 1
                                )tmp";
                            $where = false;
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        case __MODIRUSERTYPE__:
                        case __MODIR2USERTYPE__:
                        case __OPERATORUSERTYPE__:
                        case __OPERATOR2USERTYPE__:
                            $table = 'shahkar_log';
                            $primaryKey = 'tarikh';
                            $columns = array(
                                array('db' => 'shenase_shahkar', 'dt' => 'shenase_shahkar'),
                                array('db' => 'shenase_factor', 'dt' => 'shenase_factor'),
                                array('db' => 'name', 'dt' => 'name'),
                                array('db' => 'telephone', 'dt' => 'telephone'),
                                array('db' => 'tarikh', 'dt' => 'tarikh'),
                                array('db' => 'comment', 'dt' => 'comment'),
                                array('db' => 'response', 'dt' => 'response'),
                                array('db' => 'responseid', 'dt' => 'responseid'),
                                array('db' => 'classifier', 'dt' => 'classifier'),
                            );
                            $table = "(
                                        SELECT
                                        sh.id shenase_shahkar,
                                        fa.id shenase_factor,
                                        CONCAT( sub.name, ' ', sub.f_name ) name,
                                        sh.comment,
                                        sh.response response,
                                        sh.classifier,
                                        sh.responseid,
                                        sub.telephone1 telephone,
                                        DATE_FORMAT( sh.tarikh, '%Y-%m-%d %H:%i' ) tarikh
                                    FROM shahkar_log sh
                                        INNER JOIN bnm_subscribers sub ON sub.id = sh.subscriber_id
                                        INNER JOIN bnm_factor fa ON sh.factor_id = fa.id
                                        INNER JOIN bnm_services ser ON fa.service_id = ser.id
                                    WHERE sh.noe_darkhast = 1 AND sub.branch_id = {$_SESSION['branch_id']}
                                )tmp";
                            $where = false;
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        case __MOSHTARAKUSERTYPE__:
                            $table = 'shahkar_log';
                            $primaryKey = 'tarikh';
                            $columns = array(
                                array('db' => 'shenase_shahkar', 'dt' => 'shenase_shahkar'),
                                array('db' => 'shenase_factor', 'dt' => 'shenase_factor'),
                                array('db' => 'name', 'dt' => 'name'),
                                array('db' => 'telephone', 'dt' => 'telephone'),
                                array('db' => 'tarikh', 'dt' => 'tarikh'),
                                array('db' => 'comment', 'dt' => 'comment'),
                                array('db' => 'response', 'dt' => 'response'),
                                array('db' => 'responseid', 'dt' => 'responseid'),
                                array('db' => 'classifier', 'dt' => 'classifier'),
                            );
                            $table = "(
                                        SELECT
                                        sh.id shenase_shahkar,
                                        fa.id shenase_factor,
                                        CONCAT( sub.name, ' ', sub.f_name ) name,
                                        sh.comment,
                                        sh.response response,
                                        sh.classifier,
                                        sh.responseid,
                                        sub.telephone1 telephone,
                                        DATE_FORMAT( sh.tarikh, '%Y-%m-%d %H:%i' ) tarikh
                                    FROM shahkar_log sh
                                        INNER JOIN bnm_subscribers sub ON sub.id = sh.subscriber_id
                                        INNER JOIN bnm_factor fa ON sh.factor_id = fa.id
                                        INNER JOIN bnm_services ser ON fa.service_id = ser.id
                                    WHERE sh.noe_darkhast = 1 AND sub.id = {$_SESSION['user_id']}
                                )tmp";
                            $where = false;
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        default:
                            return self::Json_Message('af');
                            break;
                    }
                } else {
                    return self::Json_Message('af');
                }
                break;
            case 'shahkar_operations':
                if (self::Login_Just_Check()) {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            $primaryKey = 'tarikh';
                            $columns = array(
                                // array('db' => 'id',             'dt' => 'id'),
                                array('db' => 'shenase', 'dt' => 'shenase'),
                                array('db' => 'classifier', 'dt' => 'classifier'),
                                array('db' => 'telephone', 'dt' => 'telephone'),
                                array('db' => 'tarikh', 'dt' => 'tarikh'),
                                array('db' => 'comment', 'dt' => 'comment'),
                                array('db' => 'response', 'dt' => 'response'),
                                array('db' => 'requestid', 'dt' => 'requestid'),
                            );
                            $table = "(
                                    SELECT
                                        sh.id shenase,
                                        classifier,
                                        telephone,
                                        DATE_FORMAT(`datem`, '%Y-%m-%d %H:%i:%s') tarikh,
                                        comment,
                                        response,
                                        requestid
                                    FROM shahkar_log sh
                                    WHERE sh.requestname IN ('estservicestatus', 'deleteservice', 'closeservice')
                                    ORDER BY id DESC
                                )tmp";
                            $where = false;
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        default:

                            break;
                    }
                } else {
                    return self::Json_Message('af');
                }
                break;
            case 'shahkar_estelam_log':
                if (self::Login_Just_Check()) {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            $table = 'bnm_ip';
                            $primaryKey = 'tarikh';
                            $columns = array(
                                // array('db' => 'id',             'dt' => 'id'),
                                array('db' => 'shenase', 'dt' => 'shenase'),
                                array('db' => 'name', 'dt' => 'name'),
                                array('db' => 'f_name', 'dt' => 'f_name'),
                                array('db' => 'code_meli', 'dt' => 'code_meli'),
                                array('db' => 'tarikh', 'dt' => 'tarikh'),
                                array('db' => 'comment', 'dt' => 'comment'),
                                array('db' => 'responsecodefarsi', 'dt' => 'responsecodefarsi'),
                                array('db' => 'response', 'dt' => 'response'),
                            );
                            $table = "(
                                    SELECT
                                        sh.id shenase,
                                        DATE_FORMAT(`tarikh`, '%Y-%m-%d %H:%i') tarikh,
                                        sh.comment,
                                        sub.name,
                                        sub.f_name,
                                        sub.code_meli,
                                        if(sh.response=200,'احراز هویت موفق','مشکل در احراز هویت') responsecodefarsi,
                                        sh.response response
                                    FROM shahkar_log sh
                                    INNER JOIN bnm_subscribers sub ON sub.id=sh.subscriber_id
                                )tmp";
                            $where = false;
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        case __MODIRUSERTYPE__:
                        case __MODIR2USERTYPE__:
                        case __OPERATORUSERTYPE__:
                        case __OPERATOR2USERTYPE__:
                            $table = 'bnm_ip';
                            $primaryKey = 'tarikh';
                            $columns = array(
                                // array('db' => 'id',             'dt' => 'id'),
                                array('db' => 'shenase', 'dt' => 'shenase'),
                                array('db' => 'name', 'dt' => 'name'),
                                array('db' => 'f_name', 'dt' => 'f_name'),
                                array('db' => 'code_meli', 'dt' => 'code_meli'),
                                array('db' => 'tarikh', 'dt' => 'tarikh'),
                                array('db' => 'comment', 'dt' => 'comment'),
                                array('db' => 'responsecodefarsi', 'dt' => 'responsecodefarsi'),
                                array('db' => 'response', 'dt' => 'response'),
                            );
                            $table = "(
                                    SELECT
                                    sh.id shenase,
                                    DATE_FORMAT(`tarikh`, '%Y-%m-%d %H:%i') tarikh,
                                        sh.comment,
                                        sub.name,
                                        sub.f_name,
                                        sub.code_meli,
                                        if(sh.response=200,'احراز هویت موفق','مشکل در احراز هویت') responsecodefarsi,
                                        sh.response response
                                    FROM shahkar_log sh
                                    INNER JOIN bnm_subscribers sub ON sub.id=sh.subscriber_id
                                    WHERE sub.branch_id = {$_SESSION['branch_id']}

                                )tmp";
                            $where = false;
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        case __MOSHTARAKUSERTYPE__:
                            $table = 'bnm_ip';
                            $primaryKey = 'tarikh';
                            $columns = array(
                                // array('db' => 'id',             'dt' => 'id'),
                                array('db' => 'shenase', 'dt' => 'shenase'),
                                array('db' => 'name', 'dt' => 'name'),
                                array('db' => 'f_name', 'dt' => 'f_name'),
                                array('db' => 'code_meli', 'dt' => 'code_meli'),
                                array('db' => 'tarikh', 'dt' => 'tarikh'),
                                array('db' => 'comment', 'dt' => 'comment'),
                                array('db' => 'responsecodefarsi', 'dt' => 'responsecodefarsi'),
                                array('db' => 'response', 'dt' => 'response'),
                            );
                            $table = "(
                                    SELECT
                                    sh.id shenase,
                                    DATE_FORMAT(`tarikh`, '%Y-%m-%d %H:%i') tarikh,
                                        sh.comment,
                                        sub.name,
                                        sub.f_name,
                                        sub.code_meli,
                                        if(sh.response=200,'احراز هویت موفق','مشکل در احراز هویت') responsecodefarsi,
                                        sh.response response
                                    FROM shahkar_log sh
                                    INNER JOIN bnm_subscribers sub ON sub.id=sh.subscriber_id
                                    WHERE sub.id = {$_SESSION['user_id']}

                                )tmp";
                            $where = false;
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                        default:
                            return self::Json_Message('af');
                            break;
                    }
                } else {
                    return self::Json_Message('af');
                }
                break;
            case 'tax':
                if (self::Login_Just_Check()) {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            $table = 'bnm_tax';
                            $primaryKey = 'id';
                            $columns = array(
                                array('db' => 'id', 'dt' => 'id'),
                                array('db' => 'darsade_arzeshe_afzode', 'dt' => 'darsade_arzeshe_afzode'),
                                array('db' => 'darsade_maliate_arzeshe_afzode', 'dt' => 'darsade_maliate_arzeshe_afzode'),
                                array('db' => 'darsade_avarez_arzeshe_afzode', 'dt' => 'darsade_avarez_arzeshe_afzode'),
                            );
                            $where = false;
                            return (json_encode(Db::simple($data, $table, $primaryKey, $columns, $where)));
                            break;
                            return self::Json_Message('af');
                            break;
                    }
                } else {
                    return self::Json_Message('af');
                }
                break;
            default:
                die(self::Json_Message('unknown_error'));
                break;
        }
    }
}
