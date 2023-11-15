<?php defined('__ROOT__') or exit('No direct script access allowed');
class DidebanHelper
{
    public static function Messages($code, $data1 = false, $data2 = false)
    {
        switch ($code) {
            case 's':
                return ".عملیات با موفقیت انجام شد";
                break;
            case 'ts':
            case 'tarabordshode':
                return "خط مورد نظر ترابرد شده است";
                break;
            case 'en':
            case 'estefadenashode':
                return " خط مورد نظر تاکنون استفاده نشده است";
                break;
            case 'kt':
            case 'khattakhlie':
                return "خط مورد نظر تخلیه می باشد";
                break;
            case 'fsn':
            case 'formatsahihnist':
                if ($data1) {
                    $msg = "فرمت ورودی ";
                    $msg .= " " . $data1 . " ";
                    $msg .= "صحیح نمیباشد";
                    return $msg;
                } elseif ($data2) {
                    return "صحیح نمیباشد " . $data2 . " و " . $data1 . "فرمت ورودی ";
                } else {
                    $msg = "فرمت ورودی اطلاعات صحیح نمیباشد";
                    return $msg;
                }
                break;
            case 'nrate':
            case 'noresultaccordingtoenteries':
                $msg = "براساس ورودی های ارسالی نتیجه ای یافت نشد";
                return $msg;
                break;
            case 'hdz':
            case 'hajmedarkhastziad':
                $msg = "تاریخ شروع و پایان گزارش باید در طول ";
                $msg .= " " . __DIDBANLIMITINDAY__ . " ";
                $msg .= "روز باشد";
                return $msg;
                break;
            case 'ks':
            case 'khatayesistemi':
                if ($data1) {
                    $msg = "خطای سیستمی در اپراتور ";
                    $msg .= $data1;
                    $msg .= " پیش آمده ";
                    return $msg;
                } else {
                    return "خطای سیستمی در اپراتور شبکه سحر ارتباط پیش آمده";
                }
                break;
            case 'mpn':
            case 'moshatarakpeydanashod':
                return "مشترک مورد نظر در شبکه سحر ارتباط یافت نشد";
                break;
            case 'ns':
            case 'no_service':
                return "این سرویس در حال حاظر از سمت اپراتور شبکه سحر ارتباط ارائه نمیشود";
            break;
            case 'servicenumber_not_found':
            case 'snf':
                return "شماره خط مورد نظر متعلق به شبکه سحر ارتباط نمیباشد.";
            break;
            default:
                return "خطای سیستمی در اپراتور شبکه سحر ارتباط پیش آمده";
                break;
        }
    }

    public static function calculatePageNumber(int $count, int $order = 10)
    {
        $res = $count / $order;
        if ($res < 1) {
            return $res = 1;
        } else {
            if (is_float($res)) {
                return $res = ceil($res);
            } else {
                return $res;
            }
        }
    }

    public static function checkHealth()
    {
        $nowtime        = Helper::nowShamsiYmd("/") . " " . Helper::nowShamsihisv(":");
        $sql            = Helper::Insert_Generator(['reqname' => "Checkhealth", 'datem' => $nowtime], 'bnm_didban_logs');
        $res_insert     = Db::secure_insert_array($sql, ['reqname' => "Checkhealth", 'datem' => $nowtime]);
        if (!$res_insert) {
            return $result = json_encode([
                'HasError' => true,
                'Message' => self::Messages('ks', __OWNER__),
                'Result' => null
            ],JSON_UNESCAPED_UNICODE);
        }
        $sql            = "SELECT count(*) rownum FROM bnm_didban_logs WHERE reqname = ?";
        $res            = Db::secure_fetchall($sql, ['reqname' => "Checkhealth"]);
        return $result = json_encode([
            'HasError' => false,
            'Message' => self::Messages('s'),
            'Result' => [
                'DateTime' => Helper::fixDateDigit($nowtime,'/'),
                'Count' => (string)$res[0]['rownum']
            ]
        ],JSON_UNESCAPED_UNICODE);
    }

    public static function GetCallUsage(string $trackingcode, string $tel, string $from_date, string $to_date, string $type, string $pagenumber)
    {
        return $result = json_encode([
            'HasError' => true,
            'Message' => self::Messages('ns'),
            'Result' => null
        ],JSON_UNESCAPED_UNICODE);
    }

    public static function getRequestLog(string $trackingcode){
        $sql="SELECT * FROM bnm_didban_logs WHERE trackingcode = ?";
        $res=Db::secure_fetchall($sql, [$trackingcode]);
        if(! $res){return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);}
        $result=[
            'HasError'=>false,
            "Message"=>self::Messages('s'),
            "Result"=>[
                "ServiceName"=>$res[0]['reqname'],
                "Request"=>$res[0]['reqbody'],
                "Response"=>$res[0]['resbody']
            ]
        ];
        return json_encode($result,JSON_UNESCAPED_UNICODE);
    }

    public static function searchOwner(string $trackingcode, string $tel)
    {
        if (!$trackingcode) {
            return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        }
        //check servicenumber
        $ismobile = Helper::isMobile((string) $tel);
        if ($ismobile) {
            $user = Helper::getSubInfoByMobile("0".$tel);
        } else {
            $user = Helper::getSubInfoByTelephone("0".$tel);
        }
        if (!$user) {
            return json_encode(self::createErrorArray(self::Messages('fsn', 'شماره خط')), JSON_UNESCAPED_UNICODE);
        }

        if (!$user[0]['code_meli']) {
            return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        }
        //making result json
        $res = [
            "HasError" => false,
            "Message" => self::Messages('s'),
            "Result" => [
                "MaskedNationalCode" => $user[0]['code_meli'],
                "Date" => Helper::TabdileTarikh(Helper::Today_Miladi_Date('-'), 1, '-', '/', false)
            ]
        ];
        $req=[
            'TrackingCode'=>$trackingcode,
            'ServiceNumber'=>$tel
        ];
        $save=self::saveRequest('SearchOwner', $trackingcode, json_encode($req,JSON_UNESCAPED_UNICODE), json_encode($res, JSON_UNESCAPED_UNICODE));
        if(! $save){
            return json_encode(self::createErrorArray(self::Messages('ks')), JSON_UNESCAPED_UNICODE);
        }
        return json_encode($res, JSON_UNESCAPED_UNICODE);
    }
    public static function getPrePaidBillInfo(string $trackingcode, string $tel, string $from_date, string $to_date, string $pagenumber)
    {
        if (!$trackingcode) {
            return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        }
        // tabdile tarikh
        $fromdatetime_en = Helper::TabdileTarikh($from_date, 2, '/', '-', false);
        $todatetime_en = Helper::TabdileTarikh($to_date, 2, '/', '-', false);
        // return json_encode($fromdatetime_en);
        $fromdate_en = Helper::dateOfDateTime($fromdatetime_en);
        $todate_en = Helper::dateOfDateTime($todatetime_en);
        $d1 = new DateTime($fromdatetime_en);
        $d2 = new DateTime($todatetime_en);
        // return ['todate_en'=>$todate_en];
        if (!$fromdatetime_en && $todatetime_en && $fromdate_en && $todate_en) {
            return json_encode(self::createErrorArray(self::Messages('ks')), JSON_UNESCAPED_UNICODE);
        }
        if ($d2 < $d1) {
            return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        }
        //check mikonim ke baze zamani darkhast moshkeli nadashte bashe
        $diff           = $d2->getTimestamp() - $d1->getTimestamp();
        // return [
        //     'from_date'=>$from_date,
        //     'to_date'=> $to_date,
        //     'fromdatetime_en'=> $fromdatetime_en, 
        //     'todatetime_en'=> $todatetime_en, 
        //     'fromdate_en'=>$fromdate_en,
        //     'todate_en'=>$todate_en,
        //     'diff'=>$diff
        // ];
        if (!$diff) {
            return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        }
        if ($diff > __DIDBANLIMITINSECOND__) {
            return json_encode(self::createErrorArray(self::Messages('hdz')), JSON_UNESCAPED_UNICODE);
        }
        //check servicenumber
        $ismobile = Helper::isMobile((string) $tel);
        if ($ismobile) {
            $user = Helper::getSubInfoByMobile("0".$tel);
        } else {
            $user = Helper::getSubInfoByTelephone("0".$tel);
        }
        if (!$user) {
            return json_encode(self::createErrorArray(self::Messages('fsn', 'شماره خط')), JSON_UNESCAPED_UNICODE);
        }

        //get all user services (adi , jashnvare)
        $userservices = Helper::getAllUserServices($user[0]['id']);
        if (!$userservices) {
            //todo payam avaz kon
            return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        }
        //check which service user has with us
        $service = self::whichInternetService($userservices);
        if (!$service) {
            //todo payam avaz kon
            return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        }
        $ibsusername = Helper::getIbsUsername($service['subscriber_id'], $service['type'], $service['emkanat_id']);
        if (!isset($ibsusername)) {
            return json_encode(self::createErrorArray(self::Messages('ks')), JSON_UNESCAPED_UNICODE);
        }
        if (!$ibsusername) {
            return json_encode(self::createErrorArray(self::Messages('ks')), JSON_UNESCAPED_UNICODE);
        }
        //get all factors in period given
        $sql = "SELECT
            f.id,
            f.mablaghe_ghabele_pardakht,
            f.maliate_arzeshe_afzode,
            f.subscriber_id,
            DATE(f.tarikhe_tasvie_shode) date_tarikhetasvieshode,
            DATE(f.tarikhe_payane_service) date_tarikhepayaneservice,
            f.emkanat_id,
            f.tasvie_shode,
            f.onvane_service,
            f.zamane_estefade,
            SUBSTR(f.tarikhe_tasvie_shode, 1, 23) tarikhe_tasvie_shode,
            SUBSTR(f.tarikhe_shoroe_service, 1, 23) tarikhe_shoroe_service,
            SUBSTR(f.tarikhe_payane_service, 1, 23) tarikhe_payane_service,
            ser.id serid,
            ser.shenase_service,
            ser.onvane_service,
            ser.terafik,
            ser.gheymat,
            if(ser.type='bitstream','adsl', if(ser.type='adsl', 'adsl', if(ser.type='vdsl', 'adsl', if(ser.type= 'wireless', 'wireless', if(ser.type= 'tdlte', 'tdlte', 'یافت نشد'))))) service_type,
            ser.noe_forosh,
            'PrePaid' AS noepardakht,
            ser.zaname_estefade
            FROM
                bnm_factor f
            INNER JOIN bnm_services ser ON ser.id = f.service_id
            INNER JOIN bnm_subscribers sub ON sub.id = f.subscriber_id
            WHERE
            f.tasvie_shode = ?
            AND f.tarikhe_tasvie_shode >= ?
            AND f.tarikhe_tasvie_shode < ?
            AND f.subscriber_id = ?
            And f.emkanat_id = ?
            AND ser.type = ?
            ORDER BY f.tarikhe_tasvie_shode ASC
        ";
        $factors = Db::secure_fetchall($sql, [1, $fromdatetime_en, $todatetime_en, $service['subscriber_id'], $service['emkanat_id'], $service['type']]);
        if (!isset($factors)) {
            return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        }
        if (!$factors) {
            return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        }
        if (!is_array($factors)) {
            return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        }
        if (!isset($factors[0])) {
            return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        }
        $facount = count($factors);
        $arr                        = [];
        $arr['Result']              = [];
        $arr['Result']['Billings']  = [];
        $fakey                      = key($factors);
        for ($i = 0, $p = 0, $s = 0; $i < $facount; $i++, $s++) {
            if ($i % 10 === 0 && $i !== 0) {
                $p++;
                $s = 0;
            }
            $bytesin    = 0;
            $bytesout   = 0;
            $duration   = 0;
            //agar service bulk bood bayad az tarikhe shoro va payane service asli(adi) estefade konim
            if ($factors[$i]['noe_forosh'] === "bulk") {
                for ($k = $i; $i <= $fakey; $k--) {
                    if ($factors[$k]['noe_forosh'] === "adi" || $factors[$k]['noe_forosh'] === "jashnvare") {
                        $factors[$i]['tarikhe_shoroe_service'] = $factors[$k]['tarikhe_shoroe_service'];
                        $factors[$i]['tarikhe_payane_service'] = $factors[$k]['tarikhe_payane_service'];
                    }
                }
            }
            $arr['Result']['Billings'][$p][$s]['Type'] = (string) $factors[$i]['service_type'];
            $arr['Result']['Billings'][$p][$s]['Title'] = (string) $factors[$i]['onvane_service'];
            $arr['Result']['Billings'][$p][$s]['Price'] = (string) number_format((int) $factors[$i]['gheymat'], 0, '.', ',') . "R";
            $arr['Result']['Billings'][$p][$s]['Period'] = self::zamanEtebarBaste((int) $factors[$i]['zaname_estefade']);
            $arr['Result']['Billings'][$p][$s]['StartDateTime'] = Helper::TabdileTarikh($factors[$i]['tarikhe_tasvie_shode'], 1, '-', '/', false);
            $arr['Result']['Billings'][$p][$s]['EndDateTime'] = Helper::TabdileTarikh($factors[$i]['tarikhe_payane_service'], 1, '-', '/', false);
            $arr['Result']['Billings'][$p][$s]['AcvtivationDate'] = Helper::TabdileTarikh($factors[$i]['tarikhe_tasvie_shode'], 1, '-', '/', false);
            $arr['Result']['Billings'][$p][$s]['Gateway'] = "درگاه اینترنتی";
            $arr['Result']['Billings'][$p][$s]['PaidAmount'] = (string) number_format((int) $factors[$i]['mablaghe_ghabele_pardakht'], 0, '.', ',') . "R";
            $arr['Result']['Billings'][$p][$s]['PaidDateTime'] = Helper::TabdileTarikh($factors[$i]['tarikhe_tasvie_shode'], 1, '-', '/', false);
            $arr['Result']['Billings'][$p][$s]['Status'] = "موفق";
            $arr['Result']['Billings'][$p][$s]['Details']['Type'] = "مالیات ارزش افزوده"; //todo ... detail bayad az 0 beshmodir dobare
            $arr['Result']['Billings'][$p][$s]['Details']['Amount'] = (string) number_format((int) $factors[$i]['maliate_arzeshe_afzode'], 0, '.', ',') . "R"; //todo ... detail bayad az 0 beshmodir dobare
            $arr['Result']['Billings'][$p][$s]['Details']['Type'] = "نرخ بسته"; //todo ... detail bayad az 0 beshmodir dobare
            $arr['Result']['Billings'][$p][$s]['Details']['Amount'] = (string) number_format((int) $factors[$i]['gheymat'], 0, '.', ',') . "R"; //todo ... detail bayad az 0 beshmodir dobare

        }

        if (!$arr) {
            return json_encode(self::createErrorArray(self::Messages('ks')), JSON_UNESCAPED_UNICODE);
        }

        $totalpages=count($arr['Result']['Billings']);
        if(! $totalpages){
            return json_encode(self::createErrorArray(self::Messages('ks')), JSON_UNESCAPED_UNICODE);
        }

        $arr['Result']['TotalPage']=(string)$totalpages;
        if(isset($arr['Result']['Billings'][(int)$pagenumber])){
            for ($i=0; $i < $totalpages; $i++) { 
                if($i!==(int)$pagenumber){
                    unset($arr['Result']['Billings'][$i]);
                }
            }
        }else{
            //error no page found
            return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        }
        ///save
        $req=[
            'TrackingCode'=>$trackingcode,
            'ServiceNumber'=>$tel,
            'FromDate'=>$from_date,
            'ToDate'=>$to_date,
            'PageNumber'=>$pagenumber,
        ];
        $save=self::saveRequest('GetPrePaidBillInfo', $trackingcode, json_encode($req,JSON_UNESCAPED_UNICODE), json_encode($arr,JSON_UNESCAPED_UNICODE));
        if(! $save){
            return json_encode(self::createErrorArray(self::Messages('ks')), JSON_UNESCAPED_UNICODE);
        }
        return json_encode($arr,JSON_UNESCAPED_UNICODE);
    }

    public static function getPackageUsageDetails(string $trackingcode, string $tel, string $from_date, string $to_date, $packageid, string $pagenumber)
    {
        // return json_encode('QryResult:asdsadad654645s/r/ndsfsdfdfsdfsdf/r/na46546sddsaddfgsdsfds/r/n0/r/n0asdsasdadsda8789', JSON_UNESCAPED_UNICODE);
        if (!$trackingcode && $packageid) {
            return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        }
        // tabdile tarikh
        $fromdatetime_en = Helper::TabdileTarikh($from_date, 2, '/', '-', false);
        $todatetime_en = Helper::TabdileTarikh($to_date, 2, '/', '-', false);
        $fromdate_en = Helper::dateOfDateTime($fromdatetime_en);
        $todate_en = Helper::dateOfDateTime($todatetime_en);
        $d1 = new DateTime($fromdatetime_en);
        $d2 = new DateTime($todatetime_en);
        // return ['todate_en'=>$todate_en];
        if (!$fromdatetime_en && $todatetime_en && $fromdate_en && $todate_en) {
            return json_encode(self::createErrorArray(self::Messages('ks')), JSON_UNESCAPED_UNICODE);
        }
        if ($d2 < $d1) {
            return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        }
        //check mikonim ke baze zamani darkhast moshkeli nadashte bashe
        $diff           = $d2->getTimestamp() - $d1->getTimestamp();
        // return [
        //     'from_date'=>$from_date,
        //     'to_date'=> $to_date,
        //     'fromdatetime_en'=> $fromdatetime_en, 
        //     'todatetime_en'=> $todatetime_en, 
        //     'fromdate_en'=>$fromdate_en,
        //     'todate_en'=>$todate_en,
        //     'diff'=>$diff
        // ];
        if (!$diff) {
            return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        }
        if ($diff > __DIDBANLIMITINSECOND__) {
            return json_encode(self::createErrorArray(self::Messages('hdz')), JSON_UNESCAPED_UNICODE);
        }
        //check servicenumber
        $ismobile = Helper::isMobile((string) $tel);
        if ($ismobile) {
            $user = Helper::getSubInfoByMobile("0" . $tel);
        } else {
            $user = Helper::getSubInfoByTelephone("0" . (string)$tel);
        }
        if (!$user) {
            return json_encode(self::createErrorArray(self::Messages('fsn', 'شماره خط')), JSON_UNESCAPED_UNICODE);
        }


        //get all user services (adi , jashnvare)
        $userservices = Helper::getAllUserServices($user[0]['id']);
        if (!$userservices) {
            //todo payam avaz kon
            return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        }
        //check which service user has with us
        $service = self::whichInternetService($userservices);
        if (!$service) {
            //todo payam avaz kon
            return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        }
        $ibsusername = Helper::getIbsUsername($service['subscriber_id'], $service['type'], $service['emkanat_id']);
        if (!isset($ibsusername)) {
            return json_encode(self::createErrorArray(self::Messages('ks')), JSON_UNESCAPED_UNICODE);
        }
        if (!$ibsusername) {
            return json_encode(self::createErrorArray(self::Messages('ks')), JSON_UNESCAPED_UNICODE);
        }
        //get all factors in baze zamani given
        $sql = "SELECT
                f.id,
                f.subscriber_id,
                DATE(f.tarikhe_tasvie_shode) date_tarikhetasvieshode,
                DATE(f.tarikhe_payane_service) date_tarikhepayaneservice,
                f.emkanat_id,
                f.tasvie_shode,
                f.onvane_service,
                f.zamane_estefade,
                SUBSTR(f.tarikhe_tasvie_shode, 1, 23) tarikhe_tasvie_shode,
                SUBSTR(f.tarikhe_shoroe_service, 1, 23) tarikhe_shoroe_service,
                SUBSTR(f.tarikhe_payane_service, 1, 23) tarikhe_payane_service,
                ser.id serid,
                ser.shenase_service,
                ser.onvane_service,
                ser.terafik,
                ser.gheymat,
                if(ser.type='bitstream','adsl', if(ser.type='adsl', 'adsl', if(ser.type='vdsl', 'adsl', if(ser.type= 'wireless', 'wireless', if(ser.type= 'tdlte', 'tdlte', 'یافت نشد'))))) service_type,
                ser.noe_forosh,
                'PrePaid' AS noepardakht,
                ser.zaname_estefade
                FROM
                    bnm_factor f
                INNER JOIN bnm_services ser ON ser.id = f.service_id
                INNER JOIN bnm_subscribers sub ON sub.id = f.subscriber_id
                WHERE
                f.tasvie_shode = ?
                AND f.tarikhe_tasvie_shode >= ?
                AND f.tarikhe_tasvie_shode < ?
                AND f.subscriber_id = ?
                And f.emkanat_id = ?
                AND ser.type = ?
                AND ser.shenase_service = ?
                ORDER BY f.tarikhe_tasvie_shode ASC
            ";
        $factors = Db::secure_fetchall($sql, [1, $fromdatetime_en, $todatetime_en, $service['subscriber_id'], $service['emkanat_id'], $service['type'], $packageid]);
        if (!isset($factors)) {
            return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        }
        if (!$factors) {
            return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        }
        if (!is_array($factors)) {
            return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        }
        if (!isset($factors[0])) {
            return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        }
        //get userinfo from ibsng
        $ibsinfo = $GLOBALS['ibs_internet']->getUserInfoByNormalUserName($ibsusername[0]['ibsusername']);
        if (!isset($ibsinfo[1])) {
            return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        }
        if (!$ibsinfo[1]) {
            return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        }
        $key = key($ibsinfo[1]);
        if (!$key) {
            return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        }
        $ibsuserid = $ibsinfo[1][$key]['basic_info']['user_id'];
        if (!$ibsuserid) {
            return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        }

        $facount        = count($factors);
        if (!$facount) {
            return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        }
        $internetbi=0;
        $internetbo=0;
        $internetdur=0;
        $intranetbi=0;
        $intranetbo=0;
        $intranetdur=0;
        $msgbi=0;
        $msgbo=0;
        $msgdur=0;
        $freebi=0;
        $freebo=0;
        $freedur=0;
        $arr                        = [];
        $arr['Result']              = [];
        $fakey                      = key($factors);
        // $totalpages                 = self::calculatePageNumber($facount);

        // return $facount;
        for ($i = 0, $p = 0, $s = 0; $i < $facount; $i++, $s++) {
            if ($i % 10 === 0 && $i !== 0) {
                $p++;
                $s = 0;
            }
            //agar service bulk bood bayad az tarikhe shoro va payane service asli(adi) estefade konim
            if ($factors[$i]['noe_forosh'] === "bulk") {
                for ($k = $i; $i <= $fakey; $k--) {
                    if ($factors[$k]['noe_forosh'] === "adi" || $factors[$k]['noe_forosh'] === "jashnvare") {
                        $factors[$i]['tarikhe_shoroe_service'] = $factors[$k]['tarikhe_shoroe_service'];
                        $factors[$i]['tarikhe_payane_service'] = $factors[$k]['tarikhe_payane_service'];
                    }
                }
            }

            //////connection log by tarikhe shoro va payane service
            $connectionlogs = $GLOBALS['ibs_internet']->getConnectionLogs($factors[$i]['date_tarikhetasvieshode'], $factors[$i]['date_tarikhepayaneservice'], (string) $ibsuserid);
            if ($connectionlogs) {
                $logcount = count($connectionlogs);
                for ($j = 0; $j < $logcount; $j++) {
                    $login = 0;
                    $logout = 0;
                    if ($connectionlogs[$j]['login_time_formatted'] && $connectionlogs[$j]['logout_time_formatted']) {
                        if (strtotime($connectionlogs[$j]['login_time_formatted']) >= strtotime($factors[$i]['tarikhe_tasvie_shode']) && strtotime($connectionlogs[$j]['logout_time_formatted']) <= strtotime($todatetime_en)) {
                            if ($j === 0) {
                                $arr['Result']['PackageDetails'][$p][$s]['FirstDateTime'] = Helper::TabdileTarikh($connectionlogs[$j]['login_time_formatted'] . ".000", 1, '-', '/', false); //todo get from ibs
                            }
                            if($connectionlogs[$j]){
                                if($connectionlogs[$j]['sub_service_name']==="INTRANET"){
                                    $intranetbi     += (int)$connectionlogs[$j]['bytes_in'];
                                    $intranetbo     += (int)$connectionlogs[$j]['bytes_out'];
                                    $intranetdur    += (int)$connectionlogs[$j]['duration_seconds'];
                                }
                                if($connectionlogs[$j]['sub_service_name']==="MSG"){
                                    $msgbi  += (int)$connectionlogs[$j]['bytes_in'];
                                    $msgbo  += (int)$connectionlogs[$j]['bytes_out'];
                                    $msgdur += (int)$connectionlogs[$j]['duration_seconds'];
                                }
                                if($connectionlogs[$j]['sub_service_name']==="INTERNET"){
                                    $internetbi     += (int)$connectionlogs[$j]['bytes_in'];
                                    $internetbo     += (int)$connectionlogs[$j]['bytes_out'];
                                    $internetdur    += (int)$connectionlogs[$j]['duration_seconds'];
                                }
                                if($connectionlogs[$j]['sub_service_name']==="FREE"){
                                    $freebi     += (int)$connectionlogs[$j]['bytes_in'];
                                    $freebo     += (int)$connectionlogs[$j]['bytes_out'];
                                    $freedur    += (int)$connectionlogs[$j]['duration_seconds'];
                                }
                            }
                        }
                    }
                }
            }
            $arr['Result']['PackageDetails'][$p][$s]=[
                [
                'Type'=>"بین الملل",
                'TotalSize'=>(string)Helper::byteConvert($internetbi + $internetbo),
                'UploadSize'=>(string)Helper::byteConvert($internetbo),
                'DownloadSize'=>(string)Helper::byteConvert($internetbi),
                'DateTime'=>(string)Helper::seconds2MDH($internetdur)
            ],[
                'Type'=>"نیم بها",
                'TotalSize'=>(string)Helper::byteConvert($intranetbi + $intranetbo),
                'UploadSize'=>(string)Helper::byteConvert($intranetbo),
                'DownloadSize'=>(string)Helper::byteConvert($intranetbi),
                'DateTime'=>(string)Helper::seconds2MDH($intranetdur)
            ],[
                'Type'=>"یک سوم",
                'TotalSize'=>(string)Helper::byteConvert($msgbi + $msgbo),
                'UploadSize'=>(string)Helper::byteConvert($msgbo),
                'DownloadSize'=>(string)Helper::byteConvert($msgbi),
                'DateTime'=>(string)Helper::seconds2MDH($msgdur)
            ],[
                'Type'=>"رایگان",
                'TotalSize'=>(string)Helper::byteConvert($freebi + $freebo),
                'UploadSize'=>(string)Helper::byteConvert($freebo),
                'DownloadSize'=>(string)Helper::byteConvert($freebi),
                'DateTime'=>(string)Helper::seconds2MDH($freedur)
            ]];
        }
        if (!$arr) {
            return json_encode(self::createErrorArray(self::Messages('ks')), JSON_UNESCAPED_UNICODE);
        }
        $totalpages = count($arr['Result']['PackageDetails']);
        if (!$totalpages) {
            return json_encode(self::createErrorArray(self::Messages('ks')), JSON_UNESCAPED_UNICODE);
        }
        // $totalsize=$internetbi + $internetbo+$intranetbi + $intranetbo+$msgbi + $msgbo+$freebi + $freebo;
        $arr['HasError']                = false;
        $arr['Message']                 = self::Messages('s');
        // $arr['Result']['TotalSize']     = str_replace('.', ',', Helper::byteConvert((int) Helper::toByteSize((string)$totalsize . 'MB')));
        // $arr['Result']['TotalUsage']    = str_replace('.', ',', Helper::byteConvert($totalbytesin + $totalbytesout));
        // $arr['Result']['TotalRemain']   = str_replace('.', ',', Helper::byteConvert((int) Helper::toByteSize((string)$totalsize . "MB") - ($totalbytesin + $totalbytesout)));
        $arr['Result']['TotalPage']     = (string)$totalpages;
        /////request saving & removing unnecessary packages 
        $req=[
            'TrackingCode'=>$trackingcode,
            'ServiceNumber'=>$tel,
            'FromDate'=>$from_date,
            'ToDate'=>$to_date,
            'PackageId'=>$packageid,
            'PageNumber'=>$pagenumber
        ];
        return json_encode($arr, JSON_UNESCAPED_UNICODE);
        if(isset($arr['Result']['PackageDetails'][(int)$pagenumber])){
            for ($i=0; $i < $totalpages; $i++) { 
                if($i!==(int)$pagenumber){
                    unset($arr['Result']['PackageDetails'][$i]);
                }
            }
        }else{
            return json_encode($arr, JSON_UNESCAPED_UNICODE);
            //error no page found
            return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        }
        $save=self::saveRequest('GetPackageUsageDetails', $trackingcode, json_encode($req,JSON_UNESCAPED_UNICODE), json_encode($arr,JSON_UNESCAPED_UNICODE));
        if(! $save){
            return json_encode(self::createErrorArray(self::Messages('ks')), JSON_UNESCAPED_UNICODE);
        }
        return json_encode($arr,JSON_UNESCAPED_UNICODE);

        // }catch(Throwable $e){
        //     return 'حاج امین ارور داری'.' حالا بگرد دنبال بابای بچه';
        //     return json_encode(self::createErrorArray(self::Messages('ks')), JSON_UNESCAPED_UNICODE);
        // }
    }
    

    public static function getPackageUsage(string $trackingcode, string $tel, string $from_date, string $to_date, string $pagenumber)
    {
        if (!$trackingcode) {
            return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        }
        // tabdile tarikh
        $fromdatetime_en = Helper::TabdileTarikh($from_date, 2, '/', '-', false);
        $todatetime_en = Helper::TabdileTarikh($to_date, 2, '/', '-', false);
        $fromdate_en = Helper::dateOfDateTime($fromdatetime_en);
        $todate_en = Helper::dateOfDateTime($todatetime_en);
        $d1 = new DateTime($fromdatetime_en);
        $d2 = new DateTime($todatetime_en);
        // return ['todate_en'=>$todate_en];
        if (!$fromdatetime_en && $todatetime_en && $fromdate_en && $todate_en) {
            return json_encode(self::createErrorArray(self::Messages('ks')), JSON_UNESCAPED_UNICODE);
        }
        if ($d2 < $d1) {
            return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        }
        //check mikonim ke baze zamani darkhast moshkeli nadashte bashe
        $diff           = $d2->getTimestamp() - $d1->getTimestamp();
        if (!$diff) {
            return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        }
        if ($diff > __DIDBANLIMITINSECOND__) {
            return json_encode(self::createErrorArray(self::Messages('hdz')), JSON_UNESCAPED_UNICODE);
        }
        //check servicenumber
        $ismobile = Helper::isMobile((string) $tel);
        if ($ismobile) {
            $user = Helper::getSubInfoByMobile("0" . $tel);
        } else {
            $user = Helper::getSubInfoByTelephone("0" . (string)$tel);
        }
        if (!$user) {
            // return json_encode(self::createErrorArray(self::Messages('fsn', 'شماره خط')), JSON_UNESCAPED_UNICODE);
            return json_encode(self::createErrorArray(self::Messages('snf')), JSON_UNESCAPED_UNICODE);
        }

        //get all user services (adi , jashnvare)
        $userservices = Helper::getAllUserServices($user[0]['id']);
        if (!$userservices) {
            //todo payam avaz kon
            return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        }
        //check which service user has with us
        $service = self::whichInternetService($userservices);
        if (!$service) {
            //todo payam avaz kon
            return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        }
        $ibsusername = Helper::getIbsUsername($service['subscriber_id'], $service['type'], $service['emkanat_id']);
        if (!isset($ibsusername)) {
            return json_encode(self::createErrorArray(self::Messages('ks')), JSON_UNESCAPED_UNICODE);
        }
        if (!$ibsusername) {
            return json_encode(self::createErrorArray(self::Messages('ks')), JSON_UNESCAPED_UNICODE);
        }
        //get all factors in baze zamani given
        $sql = "SELECT
                f.id,
                f.subscriber_id,
                DATE(f.tarikhe_tasvie_shode) date_tarikhetasvieshode,
                DATE(f.tarikhe_payane_service) date_tarikhepayaneservice,
                f.emkanat_id,
                f.tasvie_shode,
                f.onvane_service,
                f.zamane_estefade,
                SUBSTR(f.tarikhe_tasvie_shode, 1, 23) tarikhe_tasvie_shode,
                SUBSTR(f.tarikhe_shoroe_service, 1, 23) tarikhe_shoroe_service,
                SUBSTR(f.tarikhe_payane_service, 1, 23) tarikhe_payane_service,
                ser.id serid,
                ser.shenase_service,
                ser.onvane_service,
                ser.terafik,
                ser.gheymat,
                if(ser.type='bitstream','adsl', if(ser.type='adsl', 'adsl', if(ser.type='vdsl', 'adsl', if(ser.type= 'wireless', 'wireless', if(ser.type= 'tdlte', 'tdlte', 'یافت نشد'))))) service_type,
                ser.noe_forosh,
                'PrePaid' AS noepardakht,
                ser.zaname_estefade
                FROM
                    bnm_factor f
                INNER JOIN bnm_services ser ON ser.id = f.service_id
                INNER JOIN bnm_subscribers sub ON sub.id = f.subscriber_id
                WHERE
                f.tasvie_shode = ?
                AND f.tarikhe_tasvie_shode >= ?
                AND f.tarikhe_tasvie_shode < ?
                AND f.subscriber_id = ?
                And f.emkanat_id = ?
                AND ser.type = ?
                ORDER BY f.tarikhe_tasvie_shode ASC
            ";
        $factors = Db::secure_fetchall($sql, [1, $fromdatetime_en, $todatetime_en, $service['subscriber_id'], $service['emkanat_id'], $service['type']]);
        if (!isset($factors)) {
            return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        }
        if (!$factors) {
            return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        }
        if (!is_array($factors)) {
            return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        }
        if (!isset($factors[0])) {
            return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        }
        //get userinfo from ibsng
        $ibsinfo = $GLOBALS['ibs_internet']->getUserInfoByNormalUserName($ibsusername[0]['ibsusername']);
        if (!isset($ibsinfo[1])) {
            return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        }
        if (!$ibsinfo[1]) {
            return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        }
        $key = key($ibsinfo[1]);
        if (!$key) {
            return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        }
        $ibsuserid = $ibsinfo[1][$key]['basic_info']['user_id'];
        if (!$ibsuserid) {
            return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        }

        $facount        = count($factors);
        if (!$facount) {
            return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        }
        $totalbytesin               = 0;
        $totalbytesout              = 0;
        $bytesin                    = 0;
        $bytesout                   = 0;
        $totalsize                  = 0;
        $duration                   = 0;
        $arr                        = [];
        $arr['Result']              = [];
        $arr['Result']['Packages']  = [];
        $fakey                      = key($factors);
        // $totalpages                 = self::calculatePageNumber($facount);

        // return $facount;
        for ($i = 0, $p = 0, $s = 0; $i < $facount; $i++, $s++) {
            if ($i % 10 === 0 && $i !== 0) {
                $p++;
                $s = 0;
            }
            $bytesin    = 0;
            $bytesout   = 0;
            $duration   = 0;
            $totalsize  += (int) $factors[$i]['terafik'];
            //agar service bulk bood bayad az tarikhe shoro va payane service asli(adi) estefade konim
            if ($factors[$i]['noe_forosh'] === "bulk") {
                for ($k = $i; $i <= $fakey; $k--) {
                    if ($factors[$k]['noe_forosh'] === "adi" || $factors[$k]['noe_forosh'] === "jashnvare") {
                        $factors[$i]['tarikhe_shoroe_service'] = $factors[$k]['tarikhe_shoroe_service'];
                        $factors[$i]['tarikhe_payane_service'] = $factors[$k]['tarikhe_payane_service'];
                    }
                }
            }
            //////connection log by tarikhe shoro va payane service
            $connectionlogs = $GLOBALS['ibs_internet']->getConnectionLogs($factors[$i]['date_tarikhetasvieshode'], $factors[$i]['date_tarikhepayaneservice'], (string) $ibsuserid);
            if ($connectionlogs) {
                $logcount = count($connectionlogs);
                for ($j = 0; $j < $logcount; $j++) {
                    $login = 0;
                    $logout = 0;
                    if ($connectionlogs[$j]['login_time_formatted'] && $connectionlogs[$j]['logout_time_formatted']) {
                        if (strtotime($connectionlogs[$j]['login_time_formatted']) >= strtotime($factors[$i]['tarikhe_tasvie_shode']) && strtotime($connectionlogs[$j]['logout_time_formatted']) <= strtotime($todatetime_en)) {
                            if ($j === 0) {
                                $arr['Result']['Packages'][$p][$s]['FirstDateTime'] = Helper::TabdileTarikh($connectionlogs[$j]['login_time_formatted'] . ".000", 1, '-', '/', false); //todo get from ibs
                            }
                            if ($j === $logcount - 1) {
                                $arr['Result']['Packages'][$p][$s]['LastDateTime'] = Helper::TabdileTarikh($connectionlogs[$j]['logout_time_formatted'] . ".999", 1, '-', '/', false); //todo get from ibs
                            }
                            //upload and download counter
                            $totalbytesin    += (int) $connectionlogs[$j]['bytes_in'];
                            $totalbytesout   += (int) $connectionlogs[$j]['bytes_out'];
                            $bytesin         += (int) $connectionlogs[$j]['bytes_in'];
                            $bytesout        += (int) $connectionlogs[$j]['bytes_out'];
                            $duration        += (int) $connectionlogs[$j]['duration_seconds'];
                        }
                    }
                    $arr['Result']['Packages'][$p][$s]['id'] = (string) $factors[$i]['shenase_service'];
                    $arr['Result']['Packages'][$p][$s]['Title'] = $factors[$i]['onvane_service'];
                    $arr['Result']['Packages'][$p][$s]['Volume'] = (string) number_format((int) $factors[$i]['terafik'], 0, '.', ',') . "MB";
                    $arr['Result']['Packages'][$p][$s]['ConnectionType'] = $factors[$i]['service_type'];
                    $arr['Result']['Packages'][$p][$s]['Type'] = "روزانه";
                    $arr['Result']['Packages'][$p][$s]['Period'] = self::zamanEtebarBaste((int) $factors[$i]['zaname_estefade']);
                    $arr['Result']['Packages'][$p][$s]['Price'] = (string) number_format((int) $factors[$i]['gheymat'], 0, '.', ',') . "R";
                    $arr['Result']['Packages'][$p][$s]['PaymentType'] = $factors[$i]['noepardakht'];
                    $arr['Result']['Packages'][$p][$s]['PurchaseDateTime'] = Helper::TabdileTarikh($factors[$i]['tarikhe_tasvie_shode'], 1, '-', '/', false);
                    $arr['Result']['Packages'][$p][$s]['AutoActivate'] = "بله";
                    $arr['Result']['Packages'][$p][$s]['ActivateDateTime'] = Helper::TabdileTarikh($factors[$i]['tarikhe_tasvie_shode'], 1, '-', '/', false);
                    $arr['Result']['Packages'][$p][$s]['StartDateTime'] = Helper::TabdileTarikh($factors[$i]['tarikhe_tasvie_shode'], 1, '-', '/', false);
                    $arr['Result']['Packages'][$p][$s]['EndDateTime'] = Helper::TabdileTarikh($factors[$i]['tarikhe_payane_service'], 1, '-', '/', false);
                    $arr['Result']['Packages'][$p][$s]['Duration'] = Helper::seconds2MDH($duration);
                    $arr['Result']['Packages'][$p][$s]['Status'] = ($ibsinfo[1][$ibsuserid]['online_status']) ? 'فعال' : 'غیر فعال';
                    $arr['Result']['Packages'][$p][$s]['TotalTraffic'] = str_replace('.', ',', Helper::byteConvert(($bytesin + $bytesout)));
                    $arr['Result']['Packages'][$p][$s]['UploadTraffic'] = str_replace('.', ',', Helper::byteConvert($bytesout));
                    $arr['Result']['Packages'][$p][$s]['DownloadTraffic'] = str_replace('.', ',', Helper::byteConvert($bytesin));
                    $arr['Result']['Packages'][$p][$s]['RemainTraffic'] = str_replace('.', ',', Helper::byteConvert((int) Helper::toByteSize((string)$factors[$i]['terafik'] . "MB") - ((int) $bytesin + (int) $bytesout)));
                }
            }
        }
        if (!$arr) {
            return json_encode(self::createErrorArray(self::Messages('ks')), JSON_UNESCAPED_UNICODE);
        }
        $totalpages = count($arr['Result']['Packages']);
        if (!$totalpages) {
            return json_encode(self::createErrorArray(self::Messages('ks')), JSON_UNESCAPED_UNICODE);
        }
        $arr['HasError']                = false;
        $arr['Message']                 = self::Messages('s');
        $arr['Result']['TotalSize']     = str_replace('.', ',', Helper::byteConvert((int) Helper::toByteSize((string)$totalsize . 'MB')));
        $arr['Result']['TotalUsage']    = str_replace('.', ',', Helper::byteConvert($totalbytesin + $totalbytesout));
        $arr['Result']['TotalRemain']   = str_replace('.', ',', Helper::byteConvert((int) Helper::toByteSize((string)$totalsize . "MB") - ($totalbytesin + $totalbytesout)));
        $arr['Result']['TotalPage']     = (string) $totalpages;
        /////request saving & removing unnecessary packages 
        $req=[
            'TrackingCode'=>$trackingcode,
            'ServiceNumber'=>$tel,
            'FromDate'=>$from_date,
            'ToDate'=>$to_date,
            'PageNumber'=>$pagenumber
        ];
        if(isset($arr['Result']['Packages'][(int)$pagenumber])){
            for ($i=0; $i < $totalpages; $i++) { 
                if($i!==(int)$pagenumber){
                    unset($arr['Result']['Packages'][$i]);
                }
            }
        }else{
            //error no page found
            return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        }
        $save=self::saveRequest('GetPackageUsage', $trackingcode, json_encode($req,JSON_UNESCAPED_UNICODE), json_encode($arr,JSON_UNESCAPED_UNICODE));
        if(! $save){
            return json_encode(self::createErrorArray(self::Messages('ks')), JSON_UNESCAPED_UNICODE);
        }
        return json_encode($arr,JSON_UNESCAPED_UNICODE);

        // }catch(Throwable $e){
        //     return 'حاج امین ارور داری'.' حالا بگرد دنبال بابای بچه';
        //     return json_encode(self::createErrorArray(self::Messages('ks')), JSON_UNESCAPED_UNICODE);
        // }
    }

    public static function GetSuspentionHistory(string $trackingcode, string $tel, string $from_date, string $to_date){
        if (!$trackingcode) {
            return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        }
        // tabdile tarikh
        $fromdatetime_en = Helper::TabdileTarikh($from_date, 2, '/', '-', false);
        $todatetime_en = Helper::TabdileTarikh($to_date, 2, '/', '-', false);
        $fromdate_en = Helper::dateOfDateTime($fromdatetime_en);
        $todate_en = Helper::dateOfDateTime($todatetime_en);
        $d1 = new DateTime($fromdatetime_en);
        $d2 = new DateTime($todatetime_en);
        // return ['todate_en'=>$todate_en];
        if (!$fromdatetime_en && $todatetime_en && $fromdate_en && $todate_en) {
            return json_encode(self::createErrorArray(self::Messages('ks')), JSON_UNESCAPED_UNICODE);
        }
        if ($d2 < $d1) {
            return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        }
        //check mikonim ke baze zamani darkhast moshkeli nadashte bashe
        $diff           = $d2->getTimestamp() - $d1->getTimestamp();
        if (!$diff) {
            return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        }
        if ($diff > __DIDBANLIMITINSECOND__) {
            return json_encode(self::createErrorArray(self::Messages('hdz')), JSON_UNESCAPED_UNICODE);
        }
        //check servicenumber
        $ismobile = Helper::isMobile((string) $tel);
        if ($ismobile) {
            $user = Helper::getSubInfoByMobile("0" . $tel);
        } else {
            $user = Helper::getSubInfoByTelephone("0" . (string)$tel);
        }
        if (!$user) {
            return json_encode(self::createErrorArray(self::Messages('fsn', 'شماره خط')), JSON_UNESCAPED_UNICODE);
        }
        //get all user services (adi , jashnvare)
        $userservices = Helper::getAllUserServices($user[0]['id']);
        if (!$userservices) {
            //todo payam avaz kon
            return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        }
        //check which service user has with us
        $service = self::whichInternetService($userservices);
        if (!$service) {
            //todo payam avaz kon
            return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        }
        $ibsusername = Helper::getIbsUsername($service['subscriber_id'], $service['type'], $service['emkanat_id']);
        if (!isset($ibsusername)) {
            return json_encode(self::createErrorArray(self::Messages('ks')), JSON_UNESCAPED_UNICODE);
        }
        if (!$ibsusername) {
            return json_encode(self::createErrorArray(self::Messages('ks')), JSON_UNESCAPED_UNICODE);
        }
        $sql="SELECT
        sus.id,
        SUBSTR(sus.lock_datetime, 1, 23) lock_datetime,
        SUBSTR(sus.unlock_datetime, 1, 23) unlock_datetime,
        lock_datetime lock_datetime_raw,
        sus.lockstatus,
        sus.tozihate_lock,
        sus.tozihate_unlock,
        sus.modat,
        sub.code_meli 
        FROM
            bnm_suspensions sus
            INNER JOIN bnm_subscribers sub ON sub.id = sus.subid 
        WHERE
        sus.subid = ?
        AND sus.servicetype =?
        AND sus.emkanatid = ?
        AND lock_datetime BETWEEN ? AND ? 
        AND unlock_datetime BETWEEN ? AND ?
        AND lockstatus =1";
        $sus= Db::secure_fetchall($sql, [$service['subscriber_id'], $service['type'], $service['emkanat_id'], $fromdatetime_en, $todatetime_en, $fromdatetime_en, $todatetime_en]);
        if(! $sus) return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        $countsus=count($sus);
        if(! $countsus) return json_encode(self::createErrorArray(self::Messages('nrate')), JSON_UNESCAPED_UNICODE);
        //todo...just save and send result
        
        $arr['HasError']                = false;
        $arr['Message']                 = self::Messages('s');
        for ($i=0; $i < $countsus; $i++) { 
            $sql="SELECT SUBSTR(tarikhe_tasvie_shode, 1, 23) tarikhe_tasvie_shode FROM bnm_factor WHERE tarikhe_tasvie_shode <= ? AND subscriber_id = ? AND emkanat_id = ? AND type = ? AND tasvie_shode = ? ORDER BY tarikhe_tasvie_shode DESC Limit 1";
            $lastfactor=Db::secure_fetchall($sql, [$sus[0]['lock_datetime_raw'], $service['subscriber_id'], $service['emkanat_id'], $service['type'], 1]);
                $arr['Result'][$i]['MaskedNationalCode']        = $sus[$i]['code_meli'];
                $arr['Result'][$i]['FromDate']                  = Helper::TabdileTarikh($sus[$i]['lock_datetime'], 1, '-', '/', false);
                $arr['Result'][$i]['ToDate']                    = Helper::TabdileTarikh($sus[$i]['unlock_datetime'], 1, '-', '/', false);
                $arr['Result'][$i]['OperationType']             = "قطع";
                $arr['Result'][$i]['BlockCause']                = $sus[$i]['tozihate_lock'];
                $arr['Result'][$i]['ApplyDateTime']             = Helper::TabdileTarikh($sus[$i]['lock_datetime'], 1, '-', '/', false);
                $arr['Result'][$i]['Status']                    = "مالک";
                $arr['Result'][$i]['PaidDateTime']              = Helper::TabdileTarikh($lastfactor[0]['tarikhe_tasvie_shode'], 1, '-', '/', false);
        }
        $req=[
            'TrackingCode'=>$trackingcode,
            'ServiceNumber'=>$tel,
            'FromDate'=>$from_date,
            'ToDate'=>$to_date,
        ];
        $save=self::saveRequest('GetSuspentionHistory', $trackingcode, json_encode($req,JSON_UNESCAPED_UNICODE), json_encode($arr,JSON_UNESCAPED_UNICODE));
        if(! $save){
            return json_encode(self::createErrorArray(self::Messages('ks')), JSON_UNESCAPED_UNICODE);
        }
        return json_encode($arr,JSON_UNESCAPED_UNICODE);
        
        

    }
    
    public static function saveRequest($servicename, $trackingcode,string $req,string $res){        
        $arr                = [];
        $arr['reqname']     = $servicename;
        $arr['trackingcode']= $trackingcode;
        $arr['reqbody']     = $req;
        $arr['resbody']     = $res;
        $arr['datem']       = Helper::Today_Miladi_Date()." ". Helper::nowTimeTehran();
        $sql=Helper::Insert_Generator($arr, 'bnm_didban_logs');
        $res= Db::secure_insert_array($sql, $arr);
        return $res;
    }

    public static function createErrorArray(string $msg)
    {
        return [
            'HasError' => true,
            'Message' => $msg,
            'result' => NULL
        ];
    }

    public static function zamanEtebarBaste(int $rooz)
    {
        if ($rooz) {
            switch ($rooz) {
                case 30:
                    return "یک ماه";
                    break;
                case 60:
                    return "دو ماه";
                    break;
                case  90:
                    return "سه ماه";
                    break;
                case  120:
                    return "چهار ماه";
                    break;
                case  150:
                    return "پنج ماه";
                    break;
                case  180:
                    return "شش ماه";
                    break;
                case  210:
                    return "هفت ماه";
                    break;
                case  240:
                    return "هشت ماه";
                    break;
                case  270:
                    return "نه ماه";
                    break;
                case  300:
                    return "ده ماه";
                    break;
                case  330:
                    return "یازده ماه";
                    break;
                case  360:
                    return "دوازده ماه";
                    break;
            }
        } else {
            return "زمان سرویس های جحمی بر اساس سرویس اصلی محاسبه میشود";
        }
    }

    public static function whichInternetService($res, $sertype=false)
    {
        if($sertype){
            for ($i = 0; $i < count($res); $i++) {
                if ($res[$i]['type'] === $sertype) {
                    return $res[$i];
                }
            }
            return false;
        }else{
            for ($i = 0; $i < count($res); $i++) {
                if ($res[$i]['type'] === "adsl" || $res[$i]['type'] === "vdsl" || $res[$i]['type'] === "bitstream") {
                    return $res[$i];
                } elseif ($res[$i]['type'] === "wireless") {
                    return $res[$i];
                } elseif ($res[$i]['type'] === "tdlte") {
                    return $res[$i];
                }
            }
            return false;
        }
    }


}
