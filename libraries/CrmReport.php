<?php
class CrmReport
{
    public static function reportByCustomDates($fd, $td){
        $arr        = [];
        $sr         = '';
        $sql="SELECT
                f.id,
                f.type,
                f.subscriber_id subid,
                DATE_FORMAT(f.tarikhe_tasvie_shode,'%Y-%m-%d %H:%i') formatted_tarikhe_tasvie_shode,
                f.service_id,
                f.emkanat_id,
                sub.code_meli,
                ser.type sertype,
                IF(ser.noe_khadamat='BITSTREAM_ADSL','adsl',IF(ser.noe_khadamat='BITSTREAM_VDSL','vdsl',ser.type)) general_sertype,
                sl.jresponse,
                sl.response
            FROM bnm_factor f
                INNER JOIN shahkar_log sl ON sl.factor_id = f.id
                INNER JOIN bnm_services ser ON ser.id = f.service_id
                INNER JOIN bnm_subscribers sub ON sub.id = f.subscriber_id
            WHERE 
                sl.response= '200'
                AND ser.noe_forosh IN ('adi', 'jashnvare', 'bulk')
                AND DATE(f.tarikhe_tasvie_shode) BETWEEN ? AND ?
                AND f.tasvie_shode = ?
                ORDER BY f.tarikhe_tasvie_shode DESC";
        $fa=Db::secure_fetchall($sql, [$fd, $td, 1]);
        if($fa){
            for ($i=0; $i <count($fa) ; $i++) {
                $subinfo=Helper::Select_By_Id('bnm_subscribers', $fa[$i]['subid']);
                $shahretavalod=Helper::getShahrinfoById($subinfo[0]['shahre_tavalod']);
                $ostanesokonat=Helper::getOstanInfoById($subinfo[0]['ostane_sokonat']);
                $shahresokonat=Helper::getOstanInfoById($subinfo[0]['shahre_sokonat']);
                $country=Helper::getCountryInfoById($subinfo[0]['meliat']);
                $address=$subinfo[0]['tel1_street'] . ' ' . $subinfo[0]['tel1_street2'] . ' پلاک ' . $subinfo[0]['tel1_housenumber'] . ' طبقه ' . $subinfo[0]['tel1_tabaghe'] . ' واحد ' . $subinfo[0]['tel1_vahed'];
                $serinfo=Helper::getAllServiceInfoLastFactorWithSubidEmkanatSertypeNoAuth($fa[$i]['subid'], $fa[$i]['emkanat_id'], $fa[$i]['sertype']);
                if (!$serinfo) {
                    continue;
                }
                $sr .= self::serCode($fa[$i]['sertype']) . self::sep('f');
                $sr .= 'ACTIVATION' . self::sep('f');
                $sr .= $fa[$i]['formatted_tarikhe_tasvie_shode'] . self::sep('f');
                if($serinfo){
                    $sr .= $serinfo[0]['ibsusername'] . self::sep('f');
                }else{
                    $sr .= '' . self::sep('f');
                }
                $sr .= $subinfo[0]['code_meli'] . self::sep('f');
                $sr .= $subinfo[0]['name'] . self::sep('f');
                $sr .= $subinfo[0]['f_name'] . self::sep('f');
                $sr .= $subinfo[0]['name_pedar'] . self::sep('f');
                $sr .= $subinfo[0]['jensiat'] . self::sep('f');
                $sr .= $subinfo[0]['shomare_shenasname'] . self::sep('f');
                $sr .= '' . self::sep('f');//mahale sodor
                $sr .= '' . self::sep('f');//madrake tahsili
                $sr .= $shahretavalod[0]['faname'] . self::sep('f');//mahale tavalod
                $sr .= $subinfo[0]['tarikhe_tavalod'] . self::sep('f');
                $sr .= $country[0]['code'] . self::sep('f');
                if($country[0]['code']!=="IRN" && $subinfo[0]['noe_shenase_hoviati']!==0){
                    $sr .= $subinfo[0]['code_meli'] . self::sep('f');
                }else{
                    $sr .= '' . self::sep('f');
                }
                $sr .= '' . self::sep('f');//shoghl
                $sr .= $ostanesokonat[0]['faname'] . self::sep('f');
                $sr .= $shahresokonat[0]['faname'] . self::sep('f');
                $sr .= $subinfo[0]['code_posti1'] . self::sep('f');
                $sr .= '' . self::sep('f');//nahie ya mantaghe shahrdari !
                $sr .= $subinfo[0]['telephone1'] . self::sep('f');
                $sr .= '' . self::sep('f');//fax
                $sr .= '' . self::sep('f');//telephone ezterari
                $sr .= $address . self::sep('f');
                if($subinfo[0]['noe_moshtarak']==="real"){
                    $sr .= 'حقیقی' . self::sep('f');
                    $sr .= '' . self::sep('f');
                    $sr .= '' . self::sep('f');
                    $sr .= '' . self::sep('f');
                    $sr .= '' . self::sep('f');

                }else{
                    $sr .= 'حقوقی' . self::sep('f');
                    $sr .= $subinfo[0]['name_sherkat'] . self::sep('f');
                    $sr .= $subinfo[0]['code_eghtesadi'] . self::sep('f');
                    $sr .= $subinfo[0]['shenase_meli'] . self::sep('f');
                    $sr .= $subinfo[0]['shomare_sabt'] . self::sep('f');
                }
                $sr .= '' . self::sep('f');//email
                $sr .= '' . self::sep('f');//fax
                switch ($serinfo[0]['sertype']) {
                    case 'adsl':
                    case 'vdsl':
                        $sql="SELECT * FROM bnm_port WHERE id = ?";
                        $port=Db::secure_fetchall($sql, [$serinfo[0]['emkanat_id']]);
                        $sr .= $port[0]['dslam'] . self::sep('f');//dslam-port-simnumber
                        $sr .= $serinfo[0]['ibsusername'] . self::sep('f');//username/puk1
                        $sr .= '' . self::sep('f');//username/puk2
                        $sr .= '' . self::sep('f');//pin1
                        $sr .= '' . self::sep('f');//pin2
                        $sr .= '' . self::sep('f');//iccid
                        $sr .= '0' . self::sep('f');//reseller code
                        $sr .= 'Active' . self::sep('f');//service status
                        $sr .= '' . self::sep('f');//dalile akharin ghati
                        $sr .= 'PrePaid' . self::sep('f');
                        $shid=json_decode($fa[$i]['jresponse'],true);
                        if(isset($shid['id'])){
                            $shid=$shid['id'];
                            $sr .= $shid . self::sep('r');
                        }else{
                            $sr .= '' . self::sep('r');
                        }
                    break;
                    case 'bitstream':
                        $sql="SELECT * FROM bnm_oss_reserves WHERE id = ?";
                        $ossres=Db::secure_fetchall($sql, [$serinfo[0]['emkanat_id']]);
                        $sr .= $ossres[0]['port'] . self::sep('f');//dslam-port-simnumber
                        $sr .= $serinfo[0]['ibsusername'] . self::sep('f');//username/puk1
                        $sr .= '' . self::sep('f');//username/puk2
                        $sr .= '' . self::sep('f');//pin1
                        $sr .= '' . self::sep('f');//pin2
                        $sr .= '' . self::sep('f');//iccid
                        $sr .= '0' . self::sep('f');//reseller code
                        $sr .= 'Active' . self::sep('f');//service status
                        $sr .= '' . self::sep('f');//dalile akharin ghati
                        $sr .= 'PrePaid' . self::sep('f');
                        $shid=json_decode($fa[$i]['jresponse'],true);
                        if(isset($shid['id'])){
                            $shid=$shid['id'];
                            $sr .= $shid . self::sep('r');
                        }else{
                            $sr .= '' . self::sep('r');
                        }
                    break;
                    case 'tdlte':
                        $sql="SELECT * FROM bnm_tdlte_sim WHERE id = ?";
                        $td=Db::secure_fetchall($sql, [$serinfo[0]['emkanat_id']]);
                        $sr .= $td[0]['tdlte_number'] . self::sep('f');//dslam-port-simnumber
                        $sr .= $td[0]['puk1'] . self::sep('f');//username/puk1
                        $sr .= $td[0]['puk2'] . self::sep('f');//username/puk2
                        $sr .= $td[0]['tdlte_number'] . self::sep('f');//pin1
                        $sr .= $td[0]['tdlte_number'] . self::sep('f');//pin2
                        $sr .= $td[0]['serial'] . self::sep('f');//iccid
                        $sr .= '0' . self::sep('f');//reseller code
                        $sr .= 'Active' . self::sep('f');//service status
                        $sr .= '' . self::sep('f');//dalile akharin ghati
                        $sr .= 'PrePaid' . self::sep('f');
                        $shid=json_decode($fa[$i]['jresponse'],true);
                        if(isset($shid['id'])){
                            $shid=$shid['id'];
                            $sr .= $shid . self::sep('r');
                        }else{
                            $sr .= '' . self::sep('r');
                        }
                    break;
                    case 'wireless':
                        $sr .= '' . self::sep('f');//dslam-port-simnumber
                        $sr .= $serinfo[0]['ibsusername'] . self::sep('f');//username/puk1
                        $sr .= '' . self::sep('f');//username/puk2
                        $sr .= '' . self::sep('f');//pin1
                        $sr .= '' . self::sep('f');//pin2
                        $sr .= '' . self::sep('f');//iccid
                        $sr .= '0' . self::sep('f');//reseller code
                        $sr .= 'Active' . self::sep('f');//service status
                        $sr .= '' . self::sep('f');//dalile akharin ghati
                        $sr .= 'PrePaid' . self::sep('f');
                        $shid=json_decode($fa[$i]['jresponse'],true);
                        if(isset($shid['id'])){
                            $shid=$shid['id'];
                            $sr .= $shid . self::sep('r');
                        }else{
                            $sr .= '' . self::sep('r');
                        }
                    break;
                }
            }
        }
        ////
        $sql="SELECT * FROM bnm_suspensions s WHERE DATE(s.datetime_auto) BETWEEN ? AND ?";
        $susp=Db::secure_fetchall($sql,[$fd, $td]);
        if($susp){
            for ($i=0; $i <count($susp) ; $i++) {
                $subinfo=Helper::Select_By_Id('bnm_subscribers', $susp[$i]['subid']);
                $shahretavalod=Helper::getShahrinfoById($subinfo[0]['shahre_tavalod']);
                $ostanesokonat=Helper::getOstanInfoById($subinfo[0]['ostane_sokonat']);
                $shahresokonat=Helper::getOstanInfoById($subinfo[0]['shahre_sokonat']);
                $country=Helper::getCountryInfoById($subinfo[0]['meliat']);
                $address=$subinfo[0]['tel1_street'] . ' ' . $subinfo[0]['tel1_street2'] . ' پلاک ' . $subinfo[0]['tel1_housenumber'] . ' طبقه ' . $subinfo[0]['tel1_tabaghe'] . ' واحد ' . $subinfo[0]['tel1_vahed'];
                $serinfo=Helper::getAllServiceInfoLastFactorWithSubidEmkanatSertypeNoAuth($susp[$i]['subid'], $susp[$i]['emkanatid'], $susp[$i]['servicetype']);
                if (!$serinfo) {
                    continue;
                }
                $sr .= self::serCode($susp[$i]['servicetype']) . self::sep('f');
                $sr .= 'CHANGE' . self::sep('f');
                $sr .= $serinfo[0]['crm_tarikhe_tasvie_shode'] . self::sep('f');
                if($serinfo){
                    $sr .= $serinfo[0]['ibsusername'] . self::sep('f');
                }else{
                    $sr .= '' . self::sep('f');
                }

                $sr .= $subinfo[0]['code_meli'] . self::sep('f');
                $sr .= $subinfo[0]['name'] . self::sep('f');
                $sr .= $subinfo[0]['f_name'] . self::sep('f');
                $sr .= $subinfo[0]['name_pedar'] . self::sep('f');
                $sr .= $subinfo[0]['jensiat'] . self::sep('f');
                $sr .= $subinfo[0]['shomare_shenasname'] . self::sep('f');
                $sr .= '' . self::sep('f');//mahale sodor
                $sr .= '' . self::sep('f');//madrake tahsili
                $sr .= $shahretavalod[0]['faname'] . self::sep('f');//mahale tavalod
                $sr .= $subinfo[0]['tarikhe_tavalod'] . self::sep('f');
                $sr .= $country[0]['code'] . self::sep('f');
                if($country[0]['code']!=="IRN" && $subinfo[0]['noe_shenase_hoviati']!==0){
                    $sr .= $subinfo[0]['code_meli'] . self::sep('f');
                }else{
                    $sr .= '' . self::sep('f');
                }
                $sr .= '' . self::sep('f');//shoghl
                $sr .= $ostanesokonat[0]['faname'] . self::sep('f');
                $sr .= $shahresokonat[0]['faname'] . self::sep('f');
                $sr .= $subinfo[0]['code_posti1'] . self::sep('f');
                $sr .= '' . self::sep('f');//nahie ya mantaghe shahrdari !
                $sr .= $subinfo[0]['telephone1'] . self::sep('f');
                $sr .= '' . self::sep('f');//fax
                $sr .= '' . self::sep('f');//telephone ezterari
                $sr .= $address . self::sep('f');
                if($subinfo[0]['noe_moshtarak']==="real"){
                    $sr .= 'حقیقی' . self::sep('f');
                    $sr .= '' . self::sep('f');
                    $sr .= '' . self::sep('f');
                    $sr .= '' . self::sep('f');
                    $sr .= '' . self::sep('f');

                }else{
                    $sr .= 'حقوقی' . self::sep('f');
                    $sr .= $subinfo[0]['name_sherkat'] . self::sep('f');
                    $sr .= $subinfo[0]['code_eghtesadi'] . self::sep('f');
                    $sr .= $subinfo[0]['shenase_meli'] . self::sep('f');
                    $sr .= $subinfo[0]['shomare_sabt'] . self::sep('f');
                }
                $sr .= '' . self::sep('f');//email
                $sr .= '' . self::sep('f');//fax
                $sql = "SELECT
                    fa.id,
                    sl.jresponse
                FROM
                    bnm_factor fa
                    INNER JOIN shahkar_log sl ON sl.factor_id = fa.id
                    INNER JOIN bnm_services ser ON ser.id = fa.service_id
                WHERE
                ser.noe_forosh IN ('adi', 'jashnvare', 'bulk')
                    AND fa.emkanat_id = ?
                    AND fa.subscriber_id = ?
                    AND fa.type = ?
                    AND fa.tasvie_shode = ?
                    AND sl.response = ?
                    ";
                $shahkar = Db::secure_fetchall($sql, [$serinfo[0]['emkanat_id'], $serinfo[0]['subid'], $serinfo[0]['sertype'], 1,200]);
                if ($shahkar) {
                    $shid = json_decode($shahkar[0]['jresponse'], true);
                    if (isset($shid['id'])) {
                        $shid = $shid['id'];
                        // $sr .= $shid . self::sep('r');
                    } else {
                        $shid = '';
                        // $sr .= '' . self::sep('r');
                    }
                }
                switch ($serinfo[0]['sertype']) {
                    case 'adsl':
                    case 'vdsl':
                        $sql="SELECT * FROM bnm_port WHERE id = ?";
                        $port=Db::secure_fetchall($sql, [$serinfo[0]['emkanat_id']]);
                        $sr .= $port[0]['dslam'] . self::sep('f');//dslam-port-simnumber
                        $sr .= $serinfo[0]['ibsusername'] . self::sep('f');//username/puk1
                        $sr .= '' . self::sep('f');//username/puk2
                        $sr .= '' . self::sep('f');//pin1
                        $sr .= '' . self::sep('f');//pin2
                        $sr .= '' . self::sep('f');//iccid
                        $sr .= '0' . self::sep('f');//reseller code
                        $sr .= 'Active' . self::sep('f');//service status
                        $sr .= '' . self::sep('f');//dalile akharin ghati
                        $sr .= 'PrePaid' . self::sep('f');
                        $sr .= $shid . self::sep('r');
                    break;
                    case 'bitstream':
                        $sql="SELECT * FROM bnm_oss_reserves WHERE id = ?";
                        $ossres=Db::secure_fetchall($sql, [$serinfo[0]['emkanat_id']]);
                        $sr .= $ossres[0]['port'] . self::sep('f');//dslam-port-simnumber
                        $sr .= $serinfo[0]['ibsusername'] . self::sep('f');//username/puk1
                        $sr .= '' . self::sep('f');//username/puk2
                        $sr .= '' . self::sep('f');//pin1
                        $sr .= '' . self::sep('f');//pin2
                        $sr .= '' . self::sep('f');//iccid
                        $sr .= '0' . self::sep('f');//reseller code
                        $sr .= 'Active' . self::sep('f');//service status
                        $sr .= '' . self::sep('f');//dalile akharin ghati
                        $sr .= 'PrePaid' . self::sep('f');
                        $sr .= $shid . self::sep('r');
                    break;
                    case 'tdlte':
                        $sql="SELECT * FROM bnm_tdlte_sim WHERE id = ?";
                        $td=Db::secure_fetchall($sql, [$serinfo[0]['emkanat_id']]);
                        $sr .= $td[0]['tdlte_number'] . self::sep('f');//dslam-port-simnumber
                        $sr .= $td[0]['puk1'] . self::sep('f');//username/puk1
                        $sr .= $td[0]['puk2'] . self::sep('f');//username/puk2
                        $sr .= $td[0]['tdlte_number'] . self::sep('f');//pin1
                        $sr .= $td[0]['tdlte_number'] . self::sep('f');//pin2
                        $sr .= $td[0]['serial'] . self::sep('f');//iccid
                        $sr .= '0' . self::sep('f');//reseller code
                        $sr .= 'Active' . self::sep('f');//service status
                        $sr .= '' . self::sep('f');//dalile akharin ghati
                        $sr .= 'PrePaid' . self::sep('f');
                        $sr .= $shid . self::sep('r');
                    break;
                    case 'wireless':
                        $sr .= '' . self::sep('f');//dslam-port-simnumber
                        $sr .= $serinfo[0]['ibsusername'] . self::sep('f');//username/puk1
                        $sr .= '' . self::sep('f');//username/puk2
                        $sr .= '' . self::sep('f');//pin1
                        $sr .= '' . self::sep('f');//pin2
                        $sr .= '' . self::sep('f');//iccid
                        $sr .= '0' . self::sep('f');//reseller code
                        $sr .= 'Active' . self::sep('f');//service status
                        $sr .= '' . self::sep('f');//dalile akharin ghati
                        $sr .= 'PrePaid' . self::sep('f');
                        $sr .= $shid . self::sep('r');
                    break;
                }
            }
        }
        ////
        // $sql="SELECT * FROM bnm_ip_assign ia WHERE DATE(ia.tarikh) BETWEEN ? AND ? AND ia.service_type = ?";
        // $bw=Db::secure_fetchall($sql, [$fd, $td, 'bandwidth']);
        ////
        $sql="SELECT * FROM bnm_subinfoupdatelogs WHERE DATE(mtarikh) BETWEEN ? AND ?";
        $subs  = Db::secure_fetchall($sql, [$fd, $td]);
        if($subs){
            for ($i=0; $i <count($subs) ; $i++) {
                $serinfo = Helper::getServiceInfoBySubidNoAuth($subs[$i]['subid']);
                if (!$serinfo) {
                    continue;
                }
                for ($z = 0; $z < count($serinfo); $z++) {
                    $subinfo       = Helper::Select_By_Id('bnm_subscribers', $subs[$i]['subid']);
                    $shahretavalod = Helper::getShahrinfoById($subinfo[0]['shahre_tavalod']);
                    $ostanesokonat = Helper::getOstanInfoById($subinfo[0]['ostane_sokonat']);
                    $shahresokonat = Helper::getOstanInfoById($subinfo[0]['shahre_sokonat']);
                    $country       = Helper::getCountryInfoById($subinfo[0]['meliat']);
                    $address       = $subinfo[0]['tel1_street'] . ' ' . $subinfo[0]['tel1_street2'] . ' پلاک ' . $subinfo[0]['tel1_housenumber'] . ' طبقه ' . $subinfo[0]['tel1_tabaghe'] . ' واحد ' . $subinfo[0]['tel1_vahed'];
                    $sr .= self::serCode($serinfo[0]['sertype']) . self::sep('f');
                    $sr .= 'CHANGE' . self::sep('f');
                    $sr .= $serinfo[0]['crm_tarikhe_tasvie_shode'] . self::sep('f');
                    if ($serinfo) {
                        $sr .= $serinfo[0]['ibsusername'] . self::sep('f');
                    } else {
                        $sr .= '' . self::sep('f');
                    }

                    $sr .= $subinfo[0]['code_meli'] . self::sep('f');
                    $sr .= $subinfo[0]['name'] . self::sep('f');
                    $sr .= $subinfo[0]['f_name'] . self::sep('f');
                    $sr .= $subinfo[0]['name_pedar'] . self::sep('f');
                    $sr .= $subinfo[0]['jensiat'] . self::sep('f');
                    $sr .= $subinfo[0]['shomare_shenasname'] . self::sep('f');
                    $sr .= '' . self::sep('f'); //mahale sodor
                    $sr .= '' . self::sep('f'); //madrake tahsili
                    $sr .= $shahretavalod[0]['faname'] . self::sep('f'); //mahale tavalod
                    $sr .= $subinfo[0]['tarikhe_tavalod'] . self::sep('f');
                    $sr .= $country[0]['code'] . self::sep('f');
                    if ($country[0]['code'] !== "IRN" && $subinfo[0]['noe_shenase_hoviati'] !== 0) {
                        $sr .= $subinfo[0]['code_meli'] . self::sep('f');
                    } else {
                        $sr .= '' . self::sep('f');
                    }
                    $sr .= '' . self::sep('f'); //shoghl
                    $sr .= $ostanesokonat[0]['faname'] . self::sep('f');
                    $sr .= $shahresokonat[0]['faname'] . self::sep('f');
                    $sr .= $subinfo[0]['code_posti1'] . self::sep('f');
                    $sr .= '' . self::sep('f'); //nahie ya mantaghe shahrdari !
                    $sr .= $subinfo[0]['telephone1'] . self::sep('f');
                    $sr .= '' . self::sep('f'); //fax
                    $sr .= '' . self::sep('f'); //telephone ezterari
                    $sr .= $address . self::sep('f');
                    if ($subinfo[0]['noe_moshtarak'] === "real") {
                        $sr .= 'حقیقی' . self::sep('f');
                        $sr .= '' . self::sep('f');
                        $sr .= '' . self::sep('f');
                        $sr .= '' . self::sep('f');
                        $sr .= '' . self::sep('f');
                    } else {
                        $sr .= 'حقوقی' . self::sep('f');
                        $sr .= $subinfo[0]['name_sherkat'] . self::sep('f');
                        $sr .= $subinfo[0]['code_eghtesadi'] . self::sep('f');
                        $sr .= $subinfo[0]['shenase_meli'] . self::sep('f');
                        $sr .= $subinfo[0]['shomare_sabt'] . self::sep('f');
                    }
                    $sr .= '' . self::sep('f'); //email
                    $sr .= '' . self::sep('f'); //fax
                    $sql     = "SELECT
                            fa.id,
                            sl.jresponse
                        FROM
                            bnm_factor fa
                            INNER JOIN shahkar_log sl ON sl.factor_id = fa.id
                            INNER JOIN bnm_services ser ON ser.id = fa.service_id
                        WHERE
                        ser.noe_forosh IN ('adi', 'jashnvare', 'bulk')
                            AND fa.emkanat_id = ?
                            AND fa.subscriber_id = ?
                            AND fa.type = ?
                            AND fa.tasvie_shode = ?
                            AND sl.response = ?
                        ";
                    $shahkar = Db::secure_fetchall($sql, [$serinfo[0]['emkanat_id'], $serinfo[0]['subid'], $serinfo[0]['sertype'], 1, 200]);
                    if ($shahkar) {
                        $shid = json_decode($shahkar[0]['jresponse'], true);
                        if (isset($shid['id'])) {
                            $shid = $shid['id'];
                            // $sr .= $shid . self::sep('r');
                        } else {
                            $shid = '';
                            // $sr .= '' . self::sep('r');
                        }
                    }
                    switch ($serinfo[0]['sertype']) {
                        case 'adsl':
                        case 'vdsl':
                            $sql = "SELECT * FROM bnm_port WHERE id = ?";
                            $port = Db::secure_fetchall($sql, [$serinfo[0]['emkanat_id']]);
                            $sr .= $port[0]['dslam'] . self::sep('f'); //dslam-port-simnumber
                            $sr .= $serinfo[0]['ibsusername'] . self::sep('f'); //username/puk1
                            $sr .= '' . self::sep('f'); //username/puk2
                            $sr .= '' . self::sep('f'); //pin1
                            $sr .= '' . self::sep('f'); //pin2
                            $sr .= '' . self::sep('f'); //iccid
                            $sr .= '0' . self::sep('f'); //reseller code
                            $sr .= 'Active' . self::sep('f'); //service status
                            $sr .= '' . self::sep('f'); //dalile akharin ghati
                            $sr .= 'PrePaid' . self::sep('f');
                            $sr .= $shid . self::sep('r');
                            break;
                        case 'bitstream':
                            $sql = "SELECT * FROM bnm_oss_reserves WHERE id = ?";
                            $ossres = Db::secure_fetchall($sql, [$serinfo[0]['emkanat_id']]);
                            $sr .= $ossres[0]['port'] . self::sep('f'); //dslam-port-simnumber
                            $sr .= $serinfo[0]['ibsusername'] . self::sep('f'); //username/puk1
                            $sr .= '' . self::sep('f'); //username/puk2
                            $sr .= '' . self::sep('f'); //pin1
                            $sr .= '' . self::sep('f'); //pin2
                            $sr .= '' . self::sep('f'); //iccid
                            $sr .= '0' . self::sep('f'); //reseller code
                            $sr .= 'Active' . self::sep('f'); //service status
                            $sr .= '' . self::sep('f'); //dalile akharin ghati
                            $sr .= 'PrePaid' . self::sep('f');
                            $sr .= $shid . self::sep('r');
                            break;
                        case 'tdlte':
                            $sql = "SELECT * FROM bnm_tdlte_sim WHERE id = ?";
                            $td = Db::secure_fetchall($sql, [$serinfo[0]['emkanat_id']]);
                            $sr .= $td[0]['tdlte_number'] . self::sep('f'); //dslam-port-simnumber
                            $sr .= $td[0]['puk1'] . self::sep('f'); //username/puk1
                            $sr .= $td[0]['puk2'] . self::sep('f'); //username/puk2
                            $sr .= $td[0]['tdlte_number'] . self::sep('f'); //pin1
                            $sr .= $td[0]['tdlte_number'] . self::sep('f'); //pin2
                            $sr .= $td[0]['serial'] . self::sep('f'); //iccid
                            $sr .= '0' . self::sep('f'); //reseller code
                            $sr .= 'Active' . self::sep('f'); //service status
                            $sr .= '' . self::sep('f'); //dalile akharin ghati
                            $sr .= 'PrePaid' . self::sep('f');
                            $sr .= $shid . self::sep('r');
                            break;
                        case 'wireless':
                            $sr .= '' . self::sep('f'); //dslam-port-simnumber
                            $sr .= $serinfo[0]['ibsusername'] . self::sep('f'); //username/puk1
                            $sr .= '' . self::sep('f'); //username/puk2
                            $sr .= '' . self::sep('f'); //pin1
                            $sr .= '' . self::sep('f'); //pin2
                            $sr .= '' . self::sep('f'); //iccid
                            $sr .= '0' . self::sep('f'); //reseller code
                            $sr .= 'Active' . self::sep('f'); //service status
                            $sr .= '' . self::sep('f'); //dalile akharin ghati
                            $sr .= 'PrePaid' . self::sep('f');
                            $sr .= $shid . self::sep('r');
                            break;
                    }
                }
            }
        }
        return $sr;
    }
    public static function sep($s){
        switch ($s) {
            case 'field':
            case 'F':
            case 'f':
                return '&|$';
            break;
            case 'row':
            case 'r':
            case 'R':
                return '^@*';
            break;
            
            default:
                return '';    
            break;
        }
    }
    public static function serCode($type){
        switch ($type) {
            case 'ADSL':
            case 'Adsl':
            case 'adsl':
            case 'VDSL':
            case 'Vdsl':
            case 'vdsl':
            case 'BITSTREAM':
            case 'Bitstream':
            case 'bitstream':
                return '3';
            break;
            case 'WIRELESS':
            case 'Wireless':
            case 'wireless':
                return '4';
            break;
            case 'TDLTE':
            case 'Tdlte':
            case 'tdlte':
                return '6';
            break;
            case 'VOIP':
            case 'Voip':
            case 'voip':
                return '14';
            break;
            case 'BANDWIDTH':
            case 'Bandwidth':
            case 'bandwidth':
            case 'bw':
                return '8';
            break;
            default:
                return '';
                break;
        }
    }

}
