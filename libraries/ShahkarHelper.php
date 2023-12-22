<?php
// require_once "shahkar.php";
// $shahkar = new Shahkar();
class ShahkarHelper
{
//databases
 ///shahkar close & delete
        // $data=[
        //         "id"=>"UV4dY2O_ePjDPKLuk86qe8sioTvIp4-5EuwoJScZzsBHVl1nJOObEI2yDs6ZXDzqE7SQjFMAXAyAb2NtSzO5jg",//shahkarid
        //         "resellerCode"=>"0",
        //         "serviceNumber"=>"05143342179"
        // ];
        // $data=[
        //     "id"=> "UV4dY2O_ePjDPKLuk86qe8sioTvIp4-5EuwoJScZzsBHVl1nJOObEI2yDs6ZXDzqE7SQjFMAXAyAb2NtSzO5jg",
        //     "serviceNumber"=> "05143342179",
        //     "resellerCode"=> "0",
        //     "close"=> 1
        // ];
        // $res=Shahkar_Requests::deleteService($data);
        // $res=Shahkar_Requests::closeService($data);
        // $data=ShahkarHelper::EstServiceStatus(['servicetype'=>'adsl', 'telephone'=>'0586225773']);
        // $res=Shahkar_Requests::estServiceStatus($data);
        // print_r($res);
        // Helper::cLog($res);
        // die();
        ///shahkar close & delete
    public static function saveEstSub($res, $subid, $reqname="estAuthsub"){
        $res=json_decode($res, true);
        $arr=[];
        if(isset($res['id'])){
            $arr['responseid']= $res['id'];
        }
        if(isset($res['result'])){
            $arr['result']          = $res['result'];
        }
        if(isset($res['requestId'])){
            $arr['requestid']       = $res['requestId'];
        }
        if(isset($res['response'])){
            $arr['response']        = $res['response'];
        }
        if(isset($res['comment'])){
            $arr['comment']         = $res['comment'];
        }
        $arr['jresponse']       = json_encode($res);
        $arr['subscriber_id']   = $subid;
        $arr['noe_darkhast']    = 2;
        $arr['request_type']    = 'post';
        $arr['creator']         = $_SESSION['id'];
        $arr['tarikh']          = Helper::Today_Miladi_Date().' '.Helper::nowTimeTehran(':', false);
        $arr['datem']           = Helper::Today_Miladi_Date().' '.Helper::nowTimeTehran(':', true, true);
        $arr['requestname']     = $reqname;
        $sql                    = Helper::Insert_Generator($arr, 'shahkar_log');
        $result                 = Db::secure_insert_array($sql, $arr);
        return $result;
    }

    public static function savePutService($res, $subid, $factorid, $reqname="putservice"){
        $res=json_decode($res, true);
        $arr=[];
        if(isset($res['id'])){
            $arr['responseid']= $res['id'];
        }
        if(isset($res['result'])){
            $arr['result']    = $res['result'];
        }
        if(isset($res['requestId'])){
            $arr['requestid'] = $res['requestId'];
        }
        if(isset($res['response'])){
            $arr['response']  = $res['response'];
        }
        if(isset($res['comment'])){
            $arr['comment']   = $res['comment'];
        }
        if(isset($res['classifier'])){
            $arr['classifier']= $res['classifier'];
        }
        $arr['jresponse']       = json_encode($res);
        $arr['subscriber_id']   = $subid;
        $arr['factor_id']       = $factorid;
        $arr['noe_darkhast']    = 1;
        $arr['request_type']    = 'post';
        $arr['creator']         = $_SESSION['id'];
        $arr['tarikh']          = Helper::Today_Miladi_Date().' '.Helper::nowTimeTehran(':', false);
        $arr['datem']           = Helper::Today_Miladi_Date().' '.Helper::nowTimeTehran(':', true, true);
        $arr['requestname']     = $reqname;
        $sql                    = Helper::Insert_Generator($arr, 'shahkar_log');
        $result                 = Db::secure_insert_array($sql, $arr);
        return $result;
    }

    public static function saveEstServiceStatus($res,$tel='',string $reqname){
        $res=json_decode($res, true);
        $arr=[];
        if(isset($res['id'])){
            $arr['responseid']= $res['id'];
        }
        if(isset($res['result'])){
            $arr['result']    = $res['result'];
        }
        if(isset($res['requestId'])){
            $arr['requestid'] = $res['requestId'];
        }
        if(isset($res['response'])){
            $arr['response']  = $res['response'];
        }
        if(isset($res['comment'])){
            $arr['comment']   = $res['comment'];
        }
        if(isset($res['classifier'])){
            $arr['classifier']= $res['classifier'];
        }
        $arr['telephone']       = $tel;
        $arr['jresponse']       = json_encode($res);
        $arr['subscriber_id']   = null;
        $arr['factor_id']       = null;
        $arr['noe_darkhast']    = 2;
        $arr['request_type']    = 'post';
        $arr['creator']         = $_SESSION['id'];
        $arr['tarikh']          = Helper::Today_Miladi_Date().' '.Helper::nowTimeTehran(':', false);
        $arr['datem']           = Helper::Today_Miladi_Date().' '.Helper::nowTimeTehran(':', true, true);
        $arr['requestname']     = $reqname;
        $sql                    = Helper::Insert_Generator($arr, 'shahkar_log');
        $result                 = Db::secure_insert_array($sql, $arr);
        return $result;
    }
    public static function closeService($shahkarid, $servicenumber, $resellercode="0"){
        $response=false;
        $data=[
            "id"=>$shahkarid,
            "resellerCode"=>(string)$resellercode,
            "serviceNumber"=>$servicenumber,
            "close"=> 1
        ];
        $response=Shahkar_Requests::closeService($data);
        if(! $response) return false;
        $res=self::saveEstServiceStatus($response, $servicenumber,'closeservice');
        return $response;
    }
    public static function deleteService($shahkarid, $servicenumber, $resellercode="0"){

        $response=false;
        $data=[
            "id"=>$shahkarid,
            "resellerCode"=>(string)$resellercode,
            "serviceNumber"=>$servicenumber
        ];
        $response=Shahkar_Requests::deleteService($data);
        if(! $response) return false;
        $res=self::saveEstServiceStatus($response, $servicenumber,'deleteservice');
        return $response;
    }

    public static function putServices($factorid, $service_type=false){
        $sql="SELECT fa.id fid, ser.type service_type, ser.noe_forosh, sub.id subid,fa.emkanat_id  FROM bnm_factor fa 
        INNER JOIN bnm_services ser ON ser.id = fa.service_id 
        INNER JOIN bnm_subscribers sub ON sub.id = fa.subscriber_id 
        WHERE fa.id = ?";
        $check=Db::secure_fetchall($sql, [$factorid]);
        if(! $check){
            return false;
        }
        switch ($check[0]['service_type']) {
            case 'adsl':
            case 'vdsl':
            case 'bitstream':
                $info=self::adslUserInfo($factorid);
                if(! $info){
                    return false;
                }
                return $info;
                
                if($check[0]['noe_forosh']=="bulk"){
                    $prevfactor=Helper::getNormalPreviousFactor($check[0]['subid'], $check[0]['emkanat_id'], $check[0]['service_type']);
                    
                    if(! $prevfactor){
                        return false;
                    }else{
                        $info[0]['bandwidth']=$prevfactor[0]['bandwidth'];
                    }
                }
                $data=self::putAdsl($info);
                if(! $data){
                    return false;
                }
                return $data;
                $res=Shahkar_Requests::putService($data);
                
                if(! $res){
                    return false;
                }
                $id=self::savePutService($res, $info[0]['subscriber_id'], $factorid);
            break;
            case 'wireless':
                $info=self::wirelessUserInfo($factorid);
                if(! $info){
                    return false;
                }
                if($check[0]['noe_forosh']=="bulk"){
                    $prevfactor=Helper::getNormalPreviousFactor($check[0]['subid'], $check[0]['emkanat_id'], $check[0]['service_type']);
                    if(! $prevfactor){
                        return false;
                    }else{
                        $info[0]['bandwidth']=$prevfactor[0]['bandwidth'];
                    }
                }
                $data=self::putWireless($info);
                if(! $data){
                    return false;
                }
                $res=Shahkar_Requests::putService($data);
                if(! $res){
                    return false;
                }
                $id=self::savePutService($res, $info[0]['subscriber_id'], $factorid);
            break;
            case 'voip':
                $info=self::voipUserInfo($factorid);
                if(! $info){
                    return false;
                }
                $data=self::putOrgination($info);
                if(! $data){
                    return false;
                }
                $res=Shahkar_Requests::putService($data);
                if(! $res){
                    return false;
                }
                $id=self::savePutService($res, $info[0]['subscriber_id'], $factorid);
            break;
            default:
                return false;
                break;
        }     
        if($id){
            return $id;
        }else{
            return false;
        }
    }

    public static function estAuthSub($subid){
        $subid=(int) $subid;
        if($subid){
            $userinfo   = self::getSubInfo($subid);
            if($userinfo){
                $nationality= Helper::subIsIrani($subid);
                if($nationality){
                    if($userinfo[0]['noe_moshtarak']==='real'){
                        $data       = self::DataEstAuthenticationIranianReal($userinfo);
                    }else{
                        $data       = self::DataEstAuthenticationIranianLegal($userinfo);
                    }
                }else{
                    if($userinfo[0]['noe_moshtarak']==='real'){
                        $data       = self::DataEstAuthenticationForeignReal($userinfo);
                    }else{
                        $data       = self::DataEstAuthenticationForeignLegal($userinfo);
                    }
                }
                if($data){
                    $res_shahkar= Shahkar_Requests::estAuthSub($data);
                    $res_save   = self::saveEstSub($res_shahkar, $subid);
                    return $res_save;
                }else{
                    return 'aaa';
                }    
            }else{
                return 'bbb';
            }
        }else{
            return 'cccc';
        }
    }

    public static function resellerInfo($id){
        $sql= "SELECT
            b.name_sherkat,
            b.id bid,
            b.noe_sherkat,
            b.noe_namayandegi,
            b.shomare_sabt,
            b.telephone1 btelephone,
            b.shenase_meli,
            b.address baddress,
            b.code_posti bcode_posti,
            b.tarikhe_sabt,
            company.code_noe_sherkat,
            bostan.code_ostan_shahkar bostan_code,
            bostan.name bostan_name,
            bshahr.name bshahr_name,
            operator.id opid,
            operator.name,
            operator.name_khanevadegi,
            operator.name_pedar,
            operator.shomare_shenasname,
            operator.code_meli,
            operator.branch_id,
            operator.telephone_hamrah,
            operator.address oaddress,
            operator.telephone_mahale_sokonat otelephone,
            operator.tarikhe_tavalod,
            operator.code_posti,
            operator.street2,
            operator.housenumber,
            CONCAT(operator.street, ' ', operator.street2, ' پلاک ', operator.housenumber, ' طبقه ', operator.tabaghe, ' واحد ',operator.vahed ) address,
            ostan.code_ostan_shahkar ostan_code,
            ostan.name ostan_name,
            shahr.name shahr_name,
            shahr.name shahr_name,
            sokonat_ostan.name ostan_sokonat_name,
            sokonat_ostan.code_ostan_shahkar ostan_sokonat_code
            FROM
                bnm_branch b
                INNER JOIN bnm_operator operator ON operator.branch_id = b.id AND operator.ismodir = 1
                INNER JOIN bnm_ostan ostan ON ostan.id = operator.ostan_tavalod 
                LEFT JOIN bnm_ostan bostan ON bostan.id = b.ostan
                LEFT JOIN bnm_shahr bshahr ON bshahr.id = b.shahr
                INNER JOIN bnm_shahr shahr ON shahr.id = operator.shahr_tavalod 
                INNER JOIN bnm_ostan sokonat_ostan ON sokonat_ostan.id = operator.ostan_sokonat 
                INNER JOIN bnm_shahr sokonat_shahr ON sokonat_shahr.id = operator.shahr_sokonat
                LEFT JOIN bnm_company_types company ON company.id = b.noe_sherkat
            WHERE
                b.id = ? AND operator.ismodir = ?
        ";
        $res= Db::secure_fetchall($sql, [$id, 1]);
        if($res){
            return $res;
        }else{
            return false;
        }
    }

    public static function putReseller($userinfo){
        if($userinfo[0]['noe_namayandegi']){
            $date = Helper::dateConvertInitialize($userinfo[0]['tarikhe_tavalod'], '-');
            $date = Helper::gregorian_to_jalali($date[0], $date[1], $date[2]);
            $date[0] = (string) $date[0];
            if(strlen($date[1])<2){
                $date[1] = "0" . (string) $date[1];
            }
            if(strlen($date[2])<2){
                $date[2] = "0" . (string) $date[2];
            }
            $date = $date[0] . $date[1] . $date[2];
            $servicecode=self::service_type('reseller');
            $data = [
                "resellerCode" => "0",
                "name" => $userinfo[0]["name"],
                "family" => $userinfo[0]["name_khanevadegi"],
                "fatherName" => $userinfo[0]["name_pedar"],
                "certificateNo" => $userinfo[0]["shomare_shenasname"],
                "iranian" => 1,
                "identificationType" => 0,
                "birthDate" => $date,
                "identificationNo" => $userinfo[0]["code_meli"],
                "birthPlace" => $userinfo[0]["shahr_name"],
                "mobile" => $userinfo[0]["telephone_hamrah"],
                "person" => (int) $userinfo[0]['noe_namayandegi'],
                
                "address" => [
                    // "street2" => $userinfo[0]["address"],
                    "street2" => $userinfo[0]["street2"],
                    "address" => $userinfo[0]["address"],
                    "provinceName" => $userinfo[0]["ostan_sokonat_name"],
                    "houseNumber" => $userinfo[0]["housenumber"],
                    "postalCode" => $userinfo[0]["code_posti"],
                    "tel" => $userinfo[0]["otelephone"],
                ],
                "service" => [
                    "type" => $servicecode,
                    "resellerCode" =>"0",
                    "province" => (string) $userinfo[0]['ostan_code'],
                    "ipStatic" => 0, //ToDo
                    "ip" => 0, //ToDo
                    "subnet" => 0, //ToDo
                ],
            ];
        }else{
            //hoghoghi
            $date = Helper::dateConvertInitialize($userinfo[0]['tarikhe_tavalod'], '-');
            $date = Helper::gregorian_to_jalali($date[0], $date[1], $date[2]);
            $date[0] = (string) $date[0];
            if(strlen($date[1])<2){
                $date[1] = "0" . (string) $date[1];
            }
            if(strlen($date[2])<2){
                $date[2] = "0" . (string) $date[2];
            }
            $date = $date[0] . $date[1] . $date[2];
            $servicecode=self::service_type('reseller');
            //////////
            $tarikhe_sabt = Helper::dateConvertInitialize($userinfo[0]['tarikhe_sabt'], '-');
            $tarikhe_sabt = Helper::gregorian_to_jalali($tarikhe_sabt[0], $tarikhe_sabt[1], $tarikhe_sabt[2]);
            $tarikhe_sabt[0] = (string) $tarikhe_sabt[0];
            if(strlen($tarikhe_sabt[1])<2){
                $tarikhe_sabt[1] = "0" . (string) $tarikhe_sabt[1];
            }
            if(strlen($tarikhe_sabt[2])<2){
                $tarikhe_sabt[2] = "0" . (string) $tarikhe_sabt[2];
            }
            $tarikhe_sabt = $tarikhe_sabt[0] . $tarikhe_sabt[1] . $tarikhe_sabt[2];
            $servicecode=self::service_type('reseller');

            //put reseller legal
            $data = [
                "person" => (string)0,
                "companyName" => $userinfo[0]["name_sherkat"],
                "iranian" => (string)1,
                "identificationType" =>(string)5,
                "registrationDate" =>(string) $userinfo[0]["tarikhe_sabt"],
                "registrationNo" =>(string) $userinfo[0]["shomare_sabt"],
                "identificationNo" =>(string) $userinfo[0]["shenase_meli"],
                "companyType" =>(string) $userinfo[0]["code_noe_sherkat"],
                "resellerCode" => "0",
                "agentFirstName" => $userinfo[0]["name"],
                "agentLastName" => $userinfo[0]["name_khanevadegi"],
                "agentFatherName" => $userinfo[0]["name_pedar"],
                "agentCertificateNo" =>(string) $userinfo[0]["shomare_shenasname"],
                "agentIdentificationType" => (string)0,
                "agentIdentificationNo" => $userinfo[0]["code_meli"],
                "agentBirthDate" =>(string) $date,
                "agentBirthPlace" => $userinfo[0]["shahr_name"],
                "agentMobile" => $userinfo[0]["telephone_hamrah"],
                "agentNationality" => "IRN",
                "address" => [
                    // "street2" => $userinfo[0]["address"],
                    "street2" => $userinfo[0]["street2"],
                    "address" => $userinfo[0]["address"],
                    "provinceName" => $userinfo[0]["ostan_sokonat_name"],
                    "houseNumber" =>(string) $userinfo[0]["housenumber"],
                    "postalCode" => (string)$userinfo[0]["code_posti"],
                    "tel" =>(string) $userinfo[0]["otelephone"],
                ],
                "service" => [
                    "type" =>(string) $servicecode,
                    "province" => (string)$userinfo[0]['ostan_code'],
                    "resellerCode" => "0",
                    "ipStatic" => (string) 0, //ToDo
                    "ip" =>(string) 0, //ToDo
                    "subnet" => (string)0, //ToDo
                ],
            ];
            // $data = [
            //     "companyName" => $userinfo[0]["name_sherkat"],
            //     "registrationNo" =>(string) $userinfo[0]["shomare_sabt"],
            //     "identificationNo" =>(string) $userinfo[0]["shenase_meli"],
            //     "identificationType" =>5,
            //     "companyType" =>(int) $userinfo[0]["code_noe_sherkat"],
            //     // "registrationDate" =>(int) $userinfo[0]["tarikhe_sabt"],
            //     "resellerCode" => (string) $userinfo[0]["branch_id"],
            //     "agentFirstName" => $userinfo[0]["name"],
            //     "agentLastName" => $userinfo[0]["name_khanevadegi"],
            //     "agentFatherName" => $userinfo[0]["name_pedar"],
            //     "agentCertificateNo" =>(string) $userinfo[0]["shomare_shenasname"],
            //     "iranian" => 1,
            //     "agentIdentificationType" => 0,
            //     "agentBirthDate" => $date,
            //     "agentIdentificationNo" => $userinfo[0]["code_meli"],
            //     "agentBirthPlace" => $userinfo[0]["shahr_name"],
            //     "agentMobile" => $userinfo[0]["telephone_hamrah"],
            //     "person" => (int) $userinfo[0]['noe_namayandegi'],
            //     "address" => [
            //         // "street2" => $userinfo[0]["address"],
            //         "street2" => $userinfo[0]["street2"],
            //         "address" => $userinfo[0]["address"],
            //         "provinceName" => $userinfo[0]["ostan_sokonat_name"],
            //         "houseNumber" => $userinfo[0]["housenumber"],
            //         "postalCode" => $userinfo[0]["code_posti"],
            //         "tel" => $userinfo[0]["btelephone"],
            //     ],
            //     "service" => [
            //         "type" => $servicecode,
            //         "province" => (string)$userinfo[0]['ostan_code'],
            //         "resellerCode" => "0",
            //         "ipStatic" => 0, //ToDo
            //         "ip" => 0, //ToDo
            //         "subnet" => 0, //ToDo
            //     ],
            // ];


        }
        if($data){
            return $data;
        }else{
            return false;
        }
    }

    public static function checkUserInfo(int $factor_id)
    {
        //daryafte etelaate moshtarak va service kharidari shode
        $sql = "SELECT
            sub.*,
            country.code meliatcode,
            ser.type servicetype
        FROM
            bnm_factor fa
            INNER JOIN bnm_subscribers sub ON sub.id = fa.subscriber_id
            INNER JOIN bnm_services ser ON ser.id = fa.service_id
            INNER JOIN bnm_country country ON sub.meliat = country.id
        WHERE
            fa.id = ?";
        $userinfo = Db::secure_fetchall($sql, [$factor_id]);
        if ($userinfo) {
            return $userinfo;
        }
    }

    public static function adslUserInfo(int $factorid)
    {
        $sql = "SELECT
        sub.id subscriber_id,
        sub.name,
        sub.f_name,
        sub.name_pedar,
        sub.code_meli,
        sub.branch_id,
        sub.email,
        sub.telephone_hamrah,
        sub.telephone_hamrahe_sherkat,
        sub.jensiat,
        sub.tarikhe_tavalod,
        sub.shomare_shenasname,
        sub.shenase_meli,
        sub.name_sherkat,
        sub.shomare_sabt,
        sub.tarikhe_sabt,
        sub.tel1_street,
        sub.tel2_street,
        sub.tel3_street,
        sub.tel1_street2,
        sub.tel2_street2,
        sub.tel3_street2,
        sub.tel1_housenumber,
        sub.tel2_housenumber,
        sub.tel3_housenumber,
        sub.tel1_tabaghe,
        sub.tel2_tabaghe,
        sub.tel3_tabaghe,
        sub.tel1_vahed,
        sub.tel2_vahed,
        sub.tel3_vahed,
        sub.code_posti1,
        if(sub.noe_moshtarak='real',1,0) noe_moshtarak,
        sub.noe_shenase_hoviati,
        ser.hadeaxar_sorat_daryaft bandwidth,
        ser.type servicetype,
        ser.id serviceid,
        ser.hadeaxar_sorat_daryaft,
        fa.id fid,
        fa.emkanat_id emkanatid,
        fa.tarikhe_shoroe_service start_service,
        fa.tarikhe_payane_service end_service,
        ostan.code_ostan_shahkar ostane_tavalod_code,
        os.name ostane_sokonat_name,
        os.name_en ostane_sokonat_name_en,
        os.code_ostan_shahkar ostane_sokonat_code,
        o1.name tel1_ostan_name,
        o1.code_ostan_shahkar tel1_ostan_code,
        o1.name_en tel1_ostan_name_en,
        s1.name tel1_shahr_name,
        shahr.name shahre_tavalod_name,
        country.code meliatcode,
        ncountry.code namayande_meliatcode,
        IF( country.code = 'IRN', 1, 0 ) isirani,
        IF( ncountry.code = 'IRN', 1, 0 ) namayande_isirani,
        company.code_noe_sherkat companytype,
        company.noe_sherkat companytypefarsi,
        CASE
                WHEN p.telephone = 1 THEN
                sub.telephone1
                WHEN p.telephone = 2 THEN
                sub.telephone2
                WHEN p.telephone = 3 THEN
                sub.telephone3
            END AS telephone,
        CASE
                WHEN p.telephone = 1 THEN
                sub.noe_malekiat1
                WHEN p.telephone = 2 THEN
                sub.noe_malekiat1
                WHEN p.telephone = 3 THEN
                sub.noe_malekiat1
            END AS noe_malekiat,
        CASE
                WHEN p.telephone = 1 THEN
                CONCAT(sub.tel1_street, ' ', sub.tel1_street2, ' پلاک ', sub.tel1_housenumber, ' طبقه ', sub.tel1_tabaghe, ' واحد ',sub.tel1_vahed )
                WHEN p.telephone = 2 THEN
                CONCAT(sub.tel2_street, ' ', sub.tel2_street2, ' پلاک ', sub.tel2_housenumber, ' طبقه ', sub.tel2_tabaghe, ' واحد ',sub.tel2_vahed )
                WHEN p.telephone = 3 THEN
                CONCAT(sub.tel3_street, ' ', sub.tel3_street2, ' پلاک ', sub.tel3_housenumber, ' طبقه ', sub.tel3_tabaghe, ' واحد ',sub.tel3_vahed )
            END AS address,
        CASE
                WHEN p.telephone = 1 THEN
                sub.code_posti1
                WHEN p.telephone = 2 THEN
                sub.code_posti2
                WHEN p.telephone = 3 THEN
                sub.code_posti3
            END AS code_posti,
        CASE
                WHEN p.telephone = 1 THEN
                sub.name_malek1
                WHEN p.telephone = 2 THEN
                sub.name_malek2
                WHEN p.telephone = 3 THEN
                sub.name_malek3
            END AS name_malek,
        CASE
                WHEN p.telephone = 1 THEN
                sub.f_name_malek1
                WHEN p.telephone = 2 THEN
                sub.f_name_malek2
                WHEN p.telephone = 3 THEN
                sub.f_name_malek3
            END AS f_name_malek
        FROM
            bnm_factor fa
            INNER JOIN bnm_subscribers sub ON sub.id = fa.subscriber_id
            INNER JOIN bnm_services ser ON ser.id = fa.service_id
                            
            INNER JOIN bnm_ostan ostan ON ostan.id = sub.ostane_tavalod
            INNER JOIN bnm_ostan os ON os.id = sub.ostane_sokonat
            INNER JOIN bnm_ostan o1 ON o1.id = sub.tel1_ostan
            INNER JOIN bnm_shahr s1 ON s1.id = sub.tel1_shahr
            INNER JOIN bnm_shahr ss ON ss.id = sub.shahre_sokonat
            INNER JOIN bnm_shahr shahr ON shahr.id = sub.shahre_tavalod
                            
            INNER JOIN bnm_countries country ON country.id = sub.meliat
            INNER JOIN bnm_port p ON p.id = fa.emkanat_id
            LEFT JOIN bnm_countries ncountry ON ncountry.id = sub.meliat_namayande
            LEFT JOIN bnm_company_types company ON company.id = sub.noe_sherkat
        WHERE
        fa.id = ?
        ";
        $res = Db::secure_fetchall($sql, [$factorid]);
        if($res){
            return $res;
        }else{
            return false;
        }
    }

    //adsl put data
    public static function putAdsl($userinfo)
    {
        //todo ... check ip static and fill parameters
        //service type code
        if(! $userinfo){
            return false;
        }
        $servicecode=self::serviceCode($userinfo[0]['servicetype']);
        if(! $servicecode){
            return false;
        }
        //start service
        $start_service = Helper::dateConvertInitialize($userinfo[0]["start_service"], '-');
        $start_service = Helper::gregorian_to_jalali($start_service[0], $start_service[1], $start_service[2]);
        $start_service[0] = (string) $start_service[0];
        if ($start_service[1] < 10) {
            $start_service[1] = "0" . (string) $start_service[1];
        }
        if ($start_service[2] < 10) {
            $start_service[2] = "0" . (string) $start_service[2];
        }
        $start_service = $start_service[0] . $start_service[1] . $start_service[2];
        //end service
        $end_service = Helper::dateConvertInitialize($userinfo[0]["end_service"], '-');
        $end_service = Helper::gregorian_to_jalali($end_service[0], $end_service[1], $end_service[2]);
        $end_service[0] = (string) $end_service[0];
        if ($end_service[1] < 10) {
            $end_service[1] = "0" . (string) $end_service[1];
        }
        if ($end_service[2] < 10) {
            $end_service[2] = "0" . (string) $end_service[2];
        }
        $end_service = $end_service[0] . $end_service[1] . $end_service[2];
        /////////////////////////////////////////////////////////////////////////////////////
        if ($userinfo[0]['isirani'] === 1) {
            if ($userinfo[0]['noe_moshtarak'] === 1) {
                //haghighi irani
                if ($userinfo[0]['noe_shenase_hoviati'] !== 0) {
                    return false;
                }
                $date = Helper::dateConvertInitialize($userinfo[0]['tarikhe_tavalod'], '-');
                $date = Helper::gregorian_to_jalali($date[0], $date[1], $date[2]);
                $date[0] = (string) $date[0];
                if(strlen($date[1])<2){
                    $date[1] = "0" . (string) $date[1];
                }
                if(strlen($date[2])<2){
                    $date[2] = "0" . (string) $date[2];
                }
                $date = $date[0] . $date[1] . $date[2];
                $data = [
                    "name" => Helper::str_trim($userinfo[0]["name"]),
                    "family" => Helper::str_trim($userinfo[0]["f_name"]),
                    "fatherName" => Helper::str_trim($userinfo[0]["name_pedar"]),
                    "certificateNo" => Helper::str_trim($userinfo[0]["shomare_shenasname"]),
                    "iranian" => Helper::str_trim($userinfo[0]["isirani"]),
                    "identificationType" => Helper::str_trim($userinfo[0]["noe_shenase_hoviati"]),
                    "birthDate" => Helper::str_trim($date),
                    "identificationNo" => Helper::str_trim($userinfo[0]["code_meli"]),
                    "birthPlace" => Helper::str_trim($userinfo[0]["shahre_tavalod_name"]),
                    "mobile" => Helper::str_trim($userinfo[0]["telephone_hamrah"]),
                    "email" => Helper::str_trim($userinfo[0]["email"]),
                    "gender" => Helper::str_trim($userinfo[0]["jensiat"]),
                    "person" => Helper::str_trim($userinfo[0]['noe_moshtarak']),
                    "resellerCode" => "0",
                    "address" => [
                        "street2" => Helper::str_trim($userinfo[0]["tel1_street2"]),
                        "address" => Helper::str_trim($userinfo[0]["address"]),
                        "houseNumber" => Helper::str_trim($userinfo[0]["tel1_vahed"]),
                        "tel" => Helper::str_trim($userinfo[0]["telephone"]),
                        "provinceName" => Helper::str_trim($userinfo[0]["tel1_ostan_name"]),
                        "townshipName" => Helper::str_trim($userinfo[0]["tel1_shahr_name"]),
                        "postalCode" => Helper::str_trim($userinfo[0]["code_posti"]),
                    ],
                    "service" => [
                        "type" => Helper::str_trim($servicecode),
                        "ipStatic" => 0, //ToDo
                        "ip" => "", //ToDo
                        "subnet" => "", //ToDo
                        
                        "ownershipType" => Helper::str_trim($userinfo[0]["noe_malekiat"]),
                        "startDate" => Helper::str_trim($start_service),
                        "endDate" => Helper::str_trim($end_service),
                        "bandwidth" => Helper::str_trim($userinfo[0]["hadeaxar_sorat_daryaft"]),
                        "province" =>(string) Helper::str_trim($userinfo[0]["tel1_ostan_code"]),
                        "phoneNumber" => Helper::str_trim($userinfo[0]["telephone"]),

                    ],
                ];
            } else {
                //hoghoghi irani

                ///tarikhe sabt
                $tarikhe_sabt_sherkat = Helper::dateConvertInitialize($userinfo[0]['tarikhe_sabt'], '-');
                $tarikhe_sabt_sherkat = Helper::gregorian_to_jalali($tarikhe_sabt_sherkat[0], $tarikhe_sabt_sherkat[1], $tarikhe_sabt_sherkat[2]);
                $tarikhe_sabt_sherkat[0] = (string) $tarikhe_sabt_sherkat[0];
                if ($tarikhe_sabt_sherkat[1] < 10) {
                    $tarikhe_sabt_sherkat[1] = "0" . (string) $tarikhe_sabt_sherkat[1];
                }
                if ($tarikhe_sabt_sherkat[2] < 10) {
                    $tarikhe_sabt_sherkat[2] = "0" . (string) $tarikhe_sabt_sherkat[2];
                }
                $tarikhe_sabt_sherkat = $tarikhe_sabt_sherkat[0] . $tarikhe_sabt_sherkat[1] . $tarikhe_sabt_sherkat[2];
                //check namayande meliat va noeshenasehoviati
                if($userinfo[0]['namayande_isirani']===1){
                    //bayad code meli bashad
                    if($userinfo[0]['noe_shenase_hoviati']===0){
                        //passport miladi sayer shamsi
                        $date = Helper::dateConvertInitialize($userinfo[0]['tarikhe_tavalod'], '-');
                        $date = Helper::gregorian_to_jalali($date[0], $date[1], $date[2]);
                        $date[0] = (string) $date[0];
                        if(strlen($date[1])<2){
                            $date[1] = "0" . (string) $date[1];
                        }
                        if(strlen($date[2])<2){
                            $date[2] = "0" . (string) $date[2];
                        }
                        $date = $date[0] . $date[1] . $date[2];
                    }else{
                        return false;
                    }
                }else{
                    //namayande khareji
                    if($userinfo[0]['noe_shenase_hoviati']===1){
                        //passport miladi sayer shamsi
                        $date=explode('-',$userinfo[0]['tarikhe_tavalod']);
                        if(strlen($date[1])<2){
                            $date[1] = "0" . (string) $date[1];
                        }
                        if(strlen($date[2])<2){
                            $date[2] = "0" . (string) $date[2];
                        }
                        $date = $date[0] . $date[1] . $date[2];
                    }else{
                        $date = Helper::dateConvertInitialize($userinfo[0]['tarikhe_tavalod'], '-');
                        $date = Helper::gregorian_to_jalali($date[0], $date[1], $date[2]);
                        $date[0] = (string) $date[0];
                        if(strlen($date[1])<2){
                            $date[1] = "0" . (string) $date[1];
                        }
                        if(strlen($date[2])<2){
                            $date[2] = "0" . (string) $date[2];
                        }
                        $date = $date[0] . $date[1] . $date[2];
                    }
                }
                $data = [
                    "companyName" => Helper::str_trim($userinfo[0]["name_sherkat"]),
                    "iranian" => Helper::str_trim($userinfo[0]["isirani"]),
                    "identificationType" => 5,
                    "registrationDate" => Helper::str_trim($tarikhe_sabt_sherkat),
                    "identificationNo" => Helper::str_trim($userinfo[0]["shenase_meli"]),
                    "companyType" => Helper::str_trim($userinfo[0]['companytype']),
                    "registrationNo" => Helper::str_trim($userinfo[0]['shomare_sabt']),
                    "agentFirstName" => Helper::str_trim($userinfo[0]["name"]),
                    "agentLastName" => Helper::str_trim($userinfo[0]["f_name"]),
                    "agentFatherName" => Helper::str_trim($userinfo[0]["name_pedar"]),
                    "agentIdentificationType" => Helper::str_trim($userinfo[0]["noe_shenase_hoviati"]),
                    "agentIdentificationNo" => Helper::str_trim($userinfo[0]["code_meli"]),
                    "agentNationality" => Helper::str_trim($userinfo[0]["meliatcode"]),
                    "agentBirthCertificateNo" => Helper::str_trim($userinfo[0]["shomare_shenasname"]),
                    "agentBirthDate" => Helper::str_trim($date),
                    "agentbirthPlace" => Helper::str_trim($userinfo[0]["shahre_tavalod"]),
                    "mobile" => Helper::str_trim($userinfo[0]["telephone_hamrah"]),
                    "email" => Helper::str_trim($userinfo[0]["email"]),
                    "gender" => Helper::str_trim($userinfo[0]["jensiat"]),
                    "person" => Helper::str_trim($userinfo[0]['noe_moshtarak']),
                    "resellerCode" => "0",
                    "address" => [
                        "street2" => Helper::str_trim($userinfo[0]["tel1_street2"]),
                        "address" => Helper::str_trim($userinfo[0]["address"]),
                        "houseNumber" => Helper::str_trim($userinfo[0]["tel1_vahed"]),
                        "tel" => Helper::str_trim($userinfo[0]["telephone"]),
                        "provinceName" => Helper::str_trim($userinfo[0]["tel1_ostan_name"]),
                        "townshipName" => Helper::str_trim($userinfo[0]["tel1_shahr_name"]),
                        "postalCode" => Helper::str_trim($userinfo[0]["code_posti"]),
                    ],
                    "service" => [
                        "type" => Helper::str_trim($servicecode),
                        "ipStatic" => 0, //ToDo
                        "ip" => "", //ToDo
                        "subnet" => "", //ToDo
                        "bandwidth" => Helper::str_trim($userinfo[0]["hadeaxar_sorat_daryaft"]),
                        "ownershipType" => Helper::str_trim($userinfo[0]["noe_malekiat"]),
                        "startDate" => Helper::str_trim($start_service),
                        "endDate" => Helper::str_trim($end_service),
                        "province" =>(string) Helper::str_trim($userinfo[0]["tel1_ostan_code"]),
                        "phoneNumber" => Helper::str_trim($userinfo[0]["telephone"]),

                    ],
                ];
            }
        } else {
            if ($userinfo[0]['noe_moshtarak'] === 1) {
                //haghighi khareji
                if($userinfo[0]['noe_shenase_hoviati']===1){
                    //passport miladi sayer shamsi
                    $date=explode('-',$userinfo[0]['tarikhe_tavalod']);
                    if(strlen($date[1])<2){
                        $date[1] = "0" . (string) $date[1];
                    }
                    if(strlen($date[2])<2){
                        $date[2] = "0" . (string) $date[2];
                    }
                    $date = $date[0] . $date[1] . $date[2];
                }else{
                    $date = Helper::dateConvertInitialize($userinfo[0]['tarikhe_tavalod'], '-');
                    $date = Helper::gregorian_to_jalali($date[0], $date[1], $date[2]);
                    $date[0] = (string) $date[0];
                    if(strlen($date[1])<2){
                        $date[1] = "0" . (string) $date[1];
                    }
                    if(strlen($date[2])<2){
                        $date[2] = "0" . (string) $date[2];
                    }
                    $date = $date[0] . $date[1] . $date[2];
                }
                $data = [
                    "name" => Helper::str_trim($userinfo[0]["name"]),
                    "family" => Helper::str_trim($userinfo[0]["f_name"]),
                    "fatherName" => Helper::str_trim($userinfo[0]["name_pedar"]),
                    "certificateNo" => Helper::str_trim($userinfo[0]["shomare_shenasname"]),
                    "iranian" => Helper::str_trim($userinfo[0]["isirani"]),
                    "identificationType" => Helper::str_trim($userinfo[0]["noe_shenase_hoviati"]),
                    "birthDate" => Helper::str_trim($date),
                    "identificationNo" => Helper::str_trim($userinfo[0]["code_meli"]),
                    "birthPlace" => Helper::str_trim($userinfo[0]["shahre_tavalod"]),
                    "mobile" => Helper::str_trim($userinfo[0]["telephone_hamrah"]),
                    "email" => Helper::str_trim($userinfo[0]["email"]),
                    "gender" => Helper::str_trim($userinfo[0]["jensiat"]),
                    "person" => Helper::str_trim($userinfo[0]['noe_moshtarak']),
                    "resellerCode" => "0",
                    "address" => [
                        // "address" => $userinfo[0]["address"],
                        "street2" => Helper::str_trim($userinfo[0]["tel1_street2"]),
                        "address" => Helper::str_trim($userinfo[0]["address"]),
                        "houseNumber" => Helper::str_trim($userinfo[0]["tel1_vahed"]),
                        "tel" => Helper::str_trim($userinfo[0]["telephone"]),
                        "provinceName" => Helper::str_trim($userinfo[0]["tel1_ostan_name"]),
                        "townshipName" => Helper::str_trim($userinfo[0]["tel1_shahr_name"]),
                        "postalCode" => Helper::str_trim($userinfo[0]["code_posti"]),
                    ],
                    "service" => [
                        "type" => Helper::str_trim($servicecode),
                        "ipStatic" => 0, //ToDo
                        "ip" => "", //ToDo
                        "subnet" => "", //ToDo
                        "bandwidth" => Helper::str_trim($userinfo[0]["hadeaxar_sorat_daryaft"]),
                        "ownershipType" => Helper::str_trim($userinfo[0]["noe_malekiat"]),
                        "startDate" => Helper::str_trim($start_service),
                        "endDate" => Helper::str_trim($end_service),
                        "province" =>(string) Helper::str_trim($userinfo[0]["tel1_ostan_code"]),
                        "phoneNumber" => Helper::str_trim($userinfo[0]["telephone"]),

                    ],
                ];
            }else{
                //hoghoghi khareji
                if($userinfo[0]['noe_shenase_hoviati']===1){
                    //passport miladi sayer shamsi
                    $date=explode('-',$userinfo[0]['tarikhe_tavalod']);
                    if(strlen($date[1])<2){
                        $date[1] = "0" . (string) $date[1];
                    }
                    if(strlen($date[2])<2){
                        $date[2] = "0" . (string) $date[2];
                    }
                    $date = $date[0] . $date[1] . $date[2];
                }else{
                    $date = Helper::dateConvertInitialize($userinfo[0]['tarikhe_tavalod'], '-');
                    $date = Helper::gregorian_to_jalali($date[0], $date[1], $date[2]);
                    $date[0] = (string) $date[0];
                    if(strlen($date[1])<2){
                        $date[1] = "0" . (string) $date[1];
                    }
                    if(strlen($date[2])<2){
                        $date[2] = "0" . (string) $date[2];
                    }
                    $date = $date[0] . $date[1] . $date[2];
                }


                if($userinfo[0]['namayande_isirani']===1){
                    //bayad code meli bashad
                    if($userinfo[0]['noe_shenase_hoviati']===0){
                        $date = Helper::dateConvertInitialize($userinfo[0]['tarikhe_tavalod'], '-');
                        $date = Helper::gregorian_to_jalali($date[0], $date[1], $date[2]);
                        $date[0] = (string) $date[0];
                        if(strlen($date[1])<2){
                            $date[1] = "0" . (string) $date[1];
                        }
                        if(strlen($date[2])<2){
                            $date[2] = "0" . (string) $date[2];
                        }
                        $date = $date[0] . $date[1] . $date[2];
                    }else{
                        return false;
                    }
                }else{
                    //namayande khareji
                    if($userinfo[0]['noe_shenase_hoviati']===1){
                        //passport miladi sayer shamsi
                        $date=explode('-',$userinfo[0]['tarikhe_tavalod']);
                        if(strlen($date[1])<2){
                            $date[1] = "0" . (string) $date[1];
                        }
                        if(strlen($date[2])<2){
                            $date[2] = "0" . (string) $date[2];
                        }
                        $date = $date[0] . $date[1] . $date[2];
                    }else{
                        $date = Helper::dateConvertInitialize($userinfo[0]['tarikhe_tavalod'], '-');
                        $date = Helper::gregorian_to_jalali($date[0], $date[1], $date[2]);
                        $date[0] = (string) $date[0];
                        if(strlen($date[1])<2){
                            $date[1] = "0" . (string) $date[1];
                        }
                        if(strlen($date[2])<2){
                            $date[2] = "0" . (string) $date[2];
                        }
                        $date = $date[0] . $date[1] . $date[2];
                    }
                }
                $data = [
                    "name" => Helper::str_trim($userinfo[0]["name"]),
                    "family" => Helper::str_trim($userinfo[0]["f_name"]),
                    "fatherName" => Helper::str_trim($userinfo[0]["name_pedar"]),
                    "certificateNo" => Helper::str_trim($userinfo[0]["shomare_shenasname"]),
                    "iranian" => Helper::str_trim($userinfo[0]["isirani"]),
                    "identificationType" => Helper::str_trim($userinfo[0]["noe_shenase_hoviati"]),
                    "birthDate" => Helper::str_trim($date),
                    "identificationNo" => Helper::str_trim($userinfo[0]["code_meli"]),
                    "birthPlace" => Helper::str_trim($userinfo[0]["shahre_tavalod"]),
                    "mobile" => Helper::str_trim($userinfo[0]["telephone_hamrah"]),
                    "email" => Helper::str_trim($userinfo[0]["email"]),
                    "gender" => Helper::str_trim($userinfo[0]["jensiat"]),
                    "person" => Helper::str_trim($userinfo[0]['noe_moshtarak']),
                    "resellerCode" => "0",
                    "address" => [
                        "street2" => Helper::str_trim($userinfo[0]["tel1_street2"]),
                        "address" => Helper::str_trim($userinfo[0]["address"]),
                        "houseNumber" => Helper::str_trim($userinfo[0]["tel1_vahed"]),
                        "tel" => Helper::str_trim($userinfo[0]["telephone"]),
                        "provinceName" => Helper::str_trim($userinfo[0]["tel1_ostan_name"]),
                        "townshipName" => Helper::str_trim($userinfo[0]["tel1_shahr_name"]),
                        "postalCode" => Helper::str_trim($userinfo[0]["code_posti"]),
                    ],
                    "service" => [
                        "type" => Helper::str_trim($servicecode),
                        "ipStatic" => 0, //ToDo
                        "ip" => "", //ToDo
                        "subnet" => "", //ToDo
                        "bandwidth" => Helper::str_trim($userinfo[0]["hadeaxar_sorat_daryaft"]),
                        "ownershipType" => Helper::str_trim($userinfo[0]["noe_malekiat"]),
                        "startDate" => Helper::str_trim($start_service),
                        "endDate" => Helper::str_trim($end_service),
                        "province" =>(string) Helper::str_trim($userinfo[0]["tel1_ostan_code"]),
                        "phoneNumber" => Helper::str_trim($userinfo[0]["telephone"]),

                    ],
                ];
            }
        }
        return $data;
    }

    public static function voipUserInfo(int $factorid)
    {
        //daryafte kamele etelaate moshtarak va service kharidari shode
        $sql = "SELECT
            sub.id subscriber_id,
            sub.name,
            sub.f_name,
            sub.name_pedar,
            sub.code_meli,
            sub.branch_id,
            sub.email,
            sub.telephone_hamrah,
            sub.telephone_hamrahe_sherkat,
            sub.jensiat,
            sub.tarikhe_tavalod,
            sub.shomare_shenasname,
            sub.shenase_meli,
            sub.name_sherkat,
            sub.shomare_sabt,
            sub.tarikhe_sabt,
            sub.tel1_street,
            sub.tel2_street,
            sub.tel3_street,
            sub.tel1_street2,
            sub.tel2_street2,
            sub.tel3_street2,
            sub.tel1_housenumber,
            sub.tel2_housenumber,
            sub.tel3_housenumber,
            sub.tel1_tabaghe,
            sub.tel2_tabaghe,
            sub.tel3_tabaghe,
            sub.tel1_vahed,
            sub.tel2_vahed,
            sub.tel3_vahed,
            if(sub.noe_moshtarak='real',1,0) noe_moshtarak,
            sub.noe_shenase_hoviati,
            ser.hadeaxar_sorat_daryaft bandwidth,
            ser.type servicetype,
            ser.id serviceid,
            ser.hadeaxar_sorat_daryaft,
            fa.id fid,
            fa.emkanat_id emkanatid,
            fa.tarikhe_shoroe_service start_service,
            fa.tarikhe_payane_service end_service,

            ostan.code_ostan_shahkar ostane_tavalod_code,
            os.name ostane_sokonat_name,
            os.name_en ostane_sokonat_name_en,
            os.code_ostan_shahkar ostane_sokonat_code,
            t1ostan.name tel1_ostan_name,
            t1ostan.code_ostan_shahkar tel1_ostan_code,
            t1ostan.name_en tel1_ostan_name_en,
            shahr.name shahre_tavalod_name,
            
            country.code meliatcode,
            ncountry.code namayande_meliatcode,
            IF( country.code = 'IRN', 1, 0 ) isirani,
            IF( ncountry.code = 'IRN', 1, 0 ) namayande_isirani,
            company.code_noe_sherkat companytype,
            company.noe_sherkat companytypefarsi,
            CASE
                    WHEN fa.emkanat_id = 1 THEN
                    sub.telephone1
                    WHEN fa.emkanat_id = 2 THEN
                    sub.telephone2
                    WHEN fa.emkanat_id = 3 THEN
                    sub.telephone3
                END AS telephone,
            CASE
                    WHEN fa.emkanat_id = 1 THEN
                    sub.noe_malekiat1
                    WHEN fa.emkanat_id = 2 THEN
                    sub.noe_malekiat1
                    WHEN fa.emkanat_id = 3 THEN
                    sub.noe_malekiat1
                END AS noe_malekiat,
            CASE
                    WHEN fa.emkanat_id = 1 THEN
                    CONCAT(sub.tel1_street, ' ', sub.tel1_street2, ' پلاک ', sub.tel1_housenumber, ' طبقه ', sub.tel1_tabaghe, ' واحد ',sub.tel1_vahed )
                    WHEN fa.emkanat_id = 2 THEN
                    CONCAT(sub.tel2_street, ' ', sub.tel2_street2, ' پلاک ', sub.tel2_housenumber, ' طبقه ', sub.tel2_tabaghe, ' واحد ',sub.tel2_vahed )
                    WHEN fa.emkanat_id = 3 THEN
                    CONCAT(sub.tel3_street, ' ', sub.tel3_street2, ' پلاک ', sub.tel3_housenumber, ' طبقه ', sub.tel3_tabaghe, ' واحد ',sub.tel3_vahed )
                END AS address,
            CASE
                    WHEN fa.emkanat_id = 1 THEN
                    sub.code_posti1
                    WHEN fa.emkanat_id = 2 THEN
                    sub.code_posti2
                    WHEN fa.emkanat_id = 3 THEN
                    sub.code_posti3
                END AS code_posti,
            CASE
                    WHEN fa.emkanat_id = 1 THEN
                    sub.name_malek1
                    WHEN fa.emkanat_id = 2 THEN
                    sub.name_malek2
                    WHEN fa.emkanat_id = 3 THEN
                    sub.name_malek3
                END AS name_malek,
            CASE
                    WHEN fa.emkanat_id = 1 THEN
                    sub.f_name_malek1
                    WHEN fa.emkanat_id = 2 THEN
                    sub.f_name_malek2
                    WHEN fa.emkanat_id = 3 THEN
                    sub.f_name_malek3
                END AS f_name_malek
            FROM
                bnm_factor fa
                INNER JOIN bnm_subscribers sub ON sub.id = fa.subscriber_id
                INNER JOIN bnm_services ser ON ser.id = fa.service_id
                INNER JOIN bnm_ostan ostan ON ostan.id = sub.ostane_tavalod
                INNER JOIN bnm_shahr shahr ON shahr.id = sub.shahre_tavalod
                INNER JOIN bnm_ostan os ON os.id = sub.ostane_sokonat
                INNER JOIN bnm_ostan t1ostan ON t1ostan.id = sub.tel1_ostan
                INNER JOIN bnm_shahr ss ON ss.id = sub.shahre_sokonat
                INNER JOIN bnm_shahr t1shahr ON t1shahr.id = sub.tel1_shahr
                INNER JOIN bnm_countries country ON country.id = sub.meliat
                LEFT JOIN bnm_countries ncountry ON ncountry.id = sub.meliat_namayande
                LEFT JOIN bnm_company_types company ON company.id = sub.noe_sherkat
            WHERE
            fa.id = ?";
        $res = Db::secure_fetchall($sql, [$factorid]);
        if($res){
            return $res;
        }else{
            return false;
        }
    }

    public static function putVoip($userinfo)
    {
        //todo ... check ip static and fill parameters
        //service type code
        if(! $userinfo){
            return false;
        }
        $servicecode=self::serviceCode($userinfo[0]['servicetype']);
        if(! $servicecode){
            return false;
        }
        //start service
        $start_service = Helper::dateConvertInitialize($userinfo[0]["start_service"], '-');
        $start_service = Helper::gregorian_to_jalali($start_service[0], $start_service[1], $start_service[2]);
        $start_service[0] = (string) $start_service[0];
        if ($start_service[1] < 10) {
            $start_service[1] = "0" . (string) $start_service[1];
        }
        if ($start_service[2] < 10) {
            $start_service[2] = "0" . (string) $start_service[2];
        }
        $start_service = $start_service[0] . $start_service[1] . $start_service[2];
        //end service
        $end_service = Helper::dateConvertInitialize($userinfo[0]["end_service"], '-');
        $end_service = Helper::gregorian_to_jalali($end_service[0], $end_service[1], $end_service[2]);
        $end_service[0] = (string) $end_service[0];
        if ($end_service[1] < 10) {
            $end_service[1] = "0" . (string) $end_service[1];
        }
        if ($end_service[2] < 10) {
            $end_service[2] = "0" . (string) $end_service[2];
        }
        $end_service = $end_service[0] . $end_service[1] . $end_service[2];
        /////////////////////////////////////////////////////////////////////////////////////
        if ($userinfo[0]['isirani'] === 1) {
            if ($userinfo[0]['noe_moshtarak'] === 1) {
                //haghighi irani
                if ($userinfo[0]['noe_shenase_hoviati'] !== 0) {
                    return false;
                }
                $date = Helper::dateConvertInitialize($userinfo[0]['tarikhe_tavalod'], '-');
                $date = Helper::gregorian_to_jalali($date[0], $date[1], $date[2]);
                $date[0] = (string) $date[0];
                if(strlen($date[1])<2){
                    $date[1] = "0" . (string) $date[1];
                }
                if(strlen($date[2])<2){
                    $date[2] = "0" . (string) $date[2];
                }
                $date = $date[0] . $date[1] . $date[2];
                $data = [
                    "name" => $userinfo[0]["name"],
                    "family" => $userinfo[0]["f_name"],
                    "fatherName" => $userinfo[0]["name_pedar"],
                    "certificateNo" => $userinfo[0]["shomare_shenasname"],
                    "iranian" => $userinfo[0]["isirani"],
                    "identificationType" => $userinfo[0]["noe_shenase_hoviati"],
                    "birthDate" => $date,
                    "identificationNo" => $userinfo[0]["code_meli"],
                    "birthPlace" => $userinfo[0]["shahre_tavalod_name"],
                    "mobile" => $userinfo[0]["telephone_hamrah"],
                    "email" => $userinfo[0]["email"],
                    "gender" => $userinfo[0]["jensiat"],
                    "person" => $userinfo[0]['noe_moshtarak'],
                    "resellerCode" => "0",
                    "address" => [
                        "street2" => $userinfo[0]["tel1_street2"],
                        "address" => $userinfo[0]["address"],
                        "houseNumber" => $userinfo[0]["tel1_vahed"],
                        "tel" => $userinfo[0]["telephone"],
                        "provinceName" => $userinfo[0]["tel1_ostan_name"],
                        "postalCode" => $userinfo[0]["code_posti"],
                    ],
                    "service" => [
                        "type" => $servicecode,
                        "phoneNumber" => $userinfo[0]["telephone"],
                        "province" =>(string) $userinfo[0]["tel1_ostan_code"],
                        "county" => $userinfo[0]["tel1_ostan_name_en"],
                        "ownershipType" => $userinfo[0]["noe_malekiat"],
                        "status" => 1,
                        "credit" => 1,
                        "general" => 0,
                        "provincialCountry" => 0,
                        "ipStatic" => 0, //ToDo
                        "ip" => "", //ToDo
                        "subnet" => "", //ToDo                        
                        "startDate" => $start_service,
                        "endDate" => $end_service,
                    ],
                ];
            } else {
                //hoghoghi irani

                ///tarikhe sabt
                $tarikhe_sabt_sherkat = Helper::dateConvertInitialize($userinfo[0]['tarikhe_sabt'], '-');
                $tarikhe_sabt_sherkat = Helper::gregorian_to_jalali($tarikhe_sabt_sherkat[0], $tarikhe_sabt_sherkat[1], $tarikhe_sabt_sherkat[2]);
                $tarikhe_sabt_sherkat[0] = (string) $tarikhe_sabt_sherkat[0];
                if ($tarikhe_sabt_sherkat[1] < 10) {
                    $tarikhe_sabt_sherkat[1] = "0" . (string) $tarikhe_sabt_sherkat[1];
                }
                if ($tarikhe_sabt_sherkat[2] < 10) {
                    $tarikhe_sabt_sherkat[2] = "0" . (string) $tarikhe_sabt_sherkat[2];
                }
                $tarikhe_sabt_sherkat = $tarikhe_sabt_sherkat[0] . $tarikhe_sabt_sherkat[1] . $tarikhe_sabt_sherkat[2];
                //check namayande meliat va noeshenasehoviati
                if($userinfo[0]['namayande_isirani']===1){
                    //bayad code meli bashad
                    if($userinfo[0]['noe_shenase_hoviati']===0){
                        //passport miladi sayer shamsi
                        $date = Helper::dateConvertInitialize($userinfo[0]['tarikhe_tavalod'], '-');
                        $date = Helper::gregorian_to_jalali($date[0], $date[1], $date[2]);
                        $date[0] = (string) $date[0];
                        if(strlen($date[1])<2){
                            $date[1] = "0" . (string) $date[1];
                        }
                        if(strlen($date[2])<2){
                            $date[2] = "0" . (string) $date[2];
                        }
                        $date = $date[0] . $date[1] . $date[2];
                    }else{
                        return false;
                    }
                }else{
                    //namayande khareji
                    if($userinfo[0]['noe_shenase_hoviati']===1){
                        //passport miladi sayer shamsi
                        $date=explode('-',$userinfo[0]['tarikhe_tavalod']);
                        if(strlen($date[1])<2){
                            $date[1] = "0" . (string) $date[1];
                        }
                        if(strlen($date[2])<2){
                            $date[2] = "0" . (string) $date[2];
                        }
                        $date = $date[0] . $date[1] . $date[2];
                    }else{
                        $date = Helper::dateConvertInitialize($userinfo[0]['tarikhe_tavalod'], '-');
                        $date = Helper::gregorian_to_jalali($date[0], $date[1], $date[2]);
                        $date[0] = (string) $date[0];
                        if(strlen($date[1])<2){
                            $date[1] = "0" . (string) $date[1];
                        }
                        if(strlen($date[2])<2){
                            $date[2] = "0" . (string) $date[2];
                        }
                        $date = $date[0] . $date[1] . $date[2];
                    }
                }
                $data = [
                    "companyName" => $userinfo[0]["name_sherkat"],
                    "iranian" => $userinfo[0]["isirani"],
                    "identificationType" => 5,
                    "registrationDate" => $tarikhe_sabt_sherkat,
                    "identificationNo" => $userinfo[0]["shenase_meli"],
                    "companyType" => $userinfo[0]['companytype'],
                    "registrationNo" => $userinfo[0]['shomare_sabt'],
                    "agentFirstName" => $userinfo[0]["name"],
                    "agentLastName" => $userinfo[0]["f_name"],
                    "agentFatherName" => $userinfo[0]["name_pedar"],
                    "agentIdentificationType" => $userinfo[0]["noe_shenase_hoviati"],
                    "agentIdentificationNo" => $userinfo[0]["code_meli"],
                    "agentNationality" => $userinfo[0]["meliatcode"],
                    "agentBirthCertificateNo" => $userinfo[0]["shomare_shenasname"],
                    "agentBirthDate" => $date,
                    "agentbirthPlace" => $userinfo[0]["shahre_tavalod"],
                    "mobile" => $userinfo[0]["telephone_hamrah"],
                    "email" => $userinfo[0]["email"],
                    "gender" => $userinfo[0]["jensiat"],
                    "person" => $userinfo[0]['noe_moshtarak'],
                    "resellerCode" => "0",
                    "address" => [                        
                        "street2" => $userinfo[0]["tel1_street2"],
                        "address" => $userinfo[0]["address"],
                        "houseNumber" => $userinfo[0]["tel1_vahed"],
                        "tel" => $userinfo[0]["telephone"],
                        "provinceName" => $userinfo[0]["tel1_ostan_name"],
                        "postalCode" => $userinfo[0]["code_posti"],
                    ],
                    "service" => [
                        "type" => $servicecode,
                        "phoneNumber" => $userinfo[0]["telephone"],
                        "province" =>(string) $userinfo[0]["tel1_ostan_code"],
                        "county" => $userinfo[0]["tel1_ostan_name_en"],
                        "ownershipType" => $userinfo[0]["noe_malekiat"],
                        "status" => 1,
                        "credit" => 1,
                        "general" => 0,
                        "provincialCountry" => 0,
                        "ipStatic" => 0, //ToDo
                        "ip" => "", //ToDo
                        "subnet" => "", //ToDo                        
                        "startDate" => $start_service,
                        "endDate" => $end_service,

                    ],
                ];
            }
        } else {
            if ($userinfo[0]['noe_moshtarak'] === 1) {
                //haghighi khareji
                if($userinfo[0]['noe_shenase_hoviati']===1){
                    //passport miladi sayer shamsi
                    $date=explode('-',$userinfo[0]['tarikhe_tavalod']);
                    if(strlen($date[1])<2){
                        $date[1] = "0" . (string) $date[1];
                    }
                    if(strlen($date[2])<2){
                        $date[2] = "0" . (string) $date[2];
                    }
                    $date = $date[0] . $date[1] . $date[2];
                }else{
                    $date = Helper::dateConvertInitialize($userinfo[0]['tarikhe_tavalod'], '-');
                    $date = Helper::gregorian_to_jalali($date[0], $date[1], $date[2]);
                    $date[0] = (string) $date[0];
                    if(strlen($date[1])<2){
                        $date[1] = "0" . (string) $date[1];
                    }
                    if(strlen($date[2])<2){
                        $date[2] = "0" . (string) $date[2];
                    }
                    $date = $date[0] . $date[1] . $date[2];
                }
                $data = [
                    "name" => $userinfo[0]["name"],
                    "family" => $userinfo[0]["f_name"],
                    "fatherName" => $userinfo[0]["name_pedar"],
                    "certificateNo" => $userinfo[0]["shomare_shenasname"],
                    "iranian" => $userinfo[0]["isirani"],
                    "identificationType" => $userinfo[0]["noe_shenase_hoviati"],
                    "birthDate" => $date,
                    "identificationNo" => $userinfo[0]["code_meli"],
                    "birthPlace" => $userinfo[0]["shahre_tavalod"],
                    "mobile" => $userinfo[0]["telephone_hamrah"],
                    "email" => $userinfo[0]["email"],
                    "gender" => $userinfo[0]["jensiat"],
                    "person" => $userinfo[0]['noe_moshtarak'],
                    "resellerCode" => "0",
                    "address" => [                        
                        "street2" => $userinfo[0]["tel1_street2"],
                        "address" => $userinfo[0]["address"],
                        "houseNumber" => $userinfo[0]["tel1_vahed"],
                        "tel" => $userinfo[0]["telephone"],
                        "provinceName" => $userinfo[0]["tel1_ostan_name"],
                        "postalCode" => $userinfo[0]["code_posti"],
                    ],
                    "service" => [
                        "type" => $servicecode,
                        "phoneNumber" => $userinfo[0]["telephone"],
                        "province" =>(string) $userinfo[0]["tel1_ostan_code"],
                        "county" => $userinfo[0]["tel1_ostan_name_en"],
                        "ownershipType" => $userinfo[0]["noe_malekiat"],
                        "status" => 1,
                        "credit" => 1,
                        "general" => 0,
                        "provincialCountry" => 0,
                        "ipStatic" => 0, //ToDo
                        "ip" => "", //ToDo
                        "subnet" => "", //ToDo                        
                        "startDate" => $start_service,
                        "endDate" => $end_service,

                    ],
                ];
            }else{
                //hoghoghi khareji
                if($userinfo[0]['noe_shenase_hoviati']===1){
                    //passport miladi sayer shamsi
                    $date=explode('-',$userinfo[0]['tarikhe_tavalod']);
                    if(strlen($date[1])<2){
                        $date[1] = "0" . (string) $date[1];
                    }
                    if(strlen($date[2])<2){
                        $date[2] = "0" . (string) $date[2];
                    }
                    $date = $date[0] . $date[1] . $date[2];
                }else{
                    $date = Helper::dateConvertInitialize($userinfo[0]['tarikhe_tavalod'], '-');
                    $date = Helper::gregorian_to_jalali($date[0], $date[1], $date[2]);
                    $date[0] = (string) $date[0];
                    if(strlen($date[1])<2){
                        $date[1] = "0" . (string) $date[1];
                    }
                    if(strlen($date[2])<2){
                        $date[2] = "0" . (string) $date[2];
                    }
                    $date = $date[0] . $date[1] . $date[2];
                }


                if($userinfo[0]['namayande_isirani']===1){
                    //bayad code meli bashad
                    if($userinfo[0]['noe_shenase_hoviati']===0){
                        $date = Helper::dateConvertInitialize($userinfo[0]['tarikhe_tavalod'], '-');
                        $date = Helper::gregorian_to_jalali($date[0], $date[1], $date[2]);
                        $date[0] = (string) $date[0];
                        if(strlen($date[1])<2){
                            $date[1] = "0" . (string) $date[1];
                        }
                        if(strlen($date[2])<2){
                            $date[2] = "0" . (string) $date[2];
                        }
                        $date = $date[0] . $date[1] . $date[2];
                    }else{
                        return false;
                    }
                }else{
                    //namayande khareji
                    if($userinfo[0]['noe_shenase_hoviati']===1){
                        //passport miladi sayer shamsi
                        $date=explode('-',$userinfo[0]['tarikhe_tavalod']);
                        if(strlen($date[1])<2){
                            $date[1] = "0" . (string) $date[1];
                        }
                        if(strlen($date[2])<2){
                            $date[2] = "0" . (string) $date[2];
                        }
                        $date = $date[0] . $date[1] . $date[2];
                    }else{
                        $date = Helper::dateConvertInitialize($userinfo[0]['tarikhe_tavalod'], '-');
                        $date = Helper::gregorian_to_jalali($date[0], $date[1], $date[2]);
                        $date[0] = (string) $date[0];
                        if(strlen($date[1])<2){
                            $date[1] = "0" . (string) $date[1];
                        }
                        if(strlen($date[2])<2){
                            $date[2] = "0" . (string) $date[2];
                        }
                        $date = $date[0] . $date[1] . $date[2];
                    }
                }
                $data = [
                    "name" => $userinfo[0]["name"],
                    "family" => $userinfo[0]["f_name"],
                    "fatherName" => $userinfo[0]["name_pedar"],
                    "certificateNo" => $userinfo[0]["shomare_shenasname"],
                    "iranian" => $userinfo[0]["isirani"],
                    "identificationType" => $userinfo[0]["noe_shenase_hoviati"],
                    "birthDate" => $date,
                    "identificationNo" => $userinfo[0]["code_meli"],
                    "birthPlace" => $userinfo[0]["shahre_tavalod"],
                    "mobile" => $userinfo[0]["telephone_hamrah"],
                    "email" => $userinfo[0]["email"],
                    "gender" => $userinfo[0]["jensiat"],
                    "person" => $userinfo[0]['noe_moshtarak'],
                    "resellerCode" => "0",
                    "address" => [                        
                        "street2" => $userinfo[0]["tel1_street2"],
                        "address" => $userinfo[0]["address"],
                        "houseNumber" => $userinfo[0]["tel1_vahed"],
                        "tel" => $userinfo[0]["telephone"],
                        "provinceName" => $userinfo[0]["tel1_ostan_name"],
                        "postalCode" => $userinfo[0]["code_posti"],
                    ],
                    "service" => [
                        "type" => $servicecode,
                        "phoneNumber" => $userinfo[0]["telephone"],
                        "province" =>(string) $userinfo[0]["tel1_ostan_code"],
                        "county" => $userinfo[0]["tel1_ostan_name_en"],
                        "ownershipType" => $userinfo[0]["noe_malekiat"],
                        "status" => 1,
                        "credit" => 1,
                        "general" => 0,
                        "provincialCountry" => 0,
                        "ipStatic" => 0, //ToDo
                        "ip" => "", //ToDo
                        "subnet" => "", //ToDo                        
                        "startDate" => $start_service,
                        "endDate" => $end_service,
                    ],
                ];
            }
        }
        return $data;
    }

    public static function putOrgination($userinfo)
    {
        //todo ... check ip static and fill parameters
        //service type code
        if(! $userinfo){
            return false;
        }
        $servicecode=self::serviceCode($userinfo[0]['servicetype']);
        if(! $servicecode){
            return false;
        }
        //start service
        $start_service = Helper::dateConvertInitialize($userinfo[0]["start_service"], '-');
        $start_service = Helper::gregorian_to_jalali($start_service[0], $start_service[1], $start_service[2]);
        $start_service[0] = (string) $start_service[0];
        if ($start_service[1] < 10) {
            $start_service[1] = "0" . (string) $start_service[1];
        }
        if ($start_service[2] < 10) {
            $start_service[2] = "0" . (string) $start_service[2];
        }
        $start_service = $start_service[0] . $start_service[1] . $start_service[2];
        //end service
        $end_service = Helper::dateConvertInitialize($userinfo[0]["end_service"], '-');
        $end_service = Helper::gregorian_to_jalali($end_service[0], $end_service[1], $end_service[2]);
        $end_service[0] = (string) $end_service[0];
        if ($end_service[1] < 10) {
            $end_service[1] = "0" . (string) $end_service[1];
        }
        if ($end_service[2] < 10) {
            $end_service[2] = "0" . (string) $end_service[2];
        }
        $end_service = $end_service[0] . $end_service[1] . $end_service[2];
        /////////////////////////////////////////////////////////////////////////////////////
        if ($userinfo[0]['isirani'] === 1) {
            if ($userinfo[0]['noe_moshtarak'] === 1) {
                //haghighi irani
                if ($userinfo[0]['noe_shenase_hoviati'] !== 0) {
                    return false;
                }
                $date = Helper::dateConvertInitialize($userinfo[0]['tarikhe_tavalod'], '-');
                $date = Helper::gregorian_to_jalali($date[0], $date[1], $date[2]);
                $date[0] = (string) $date[0];
                if(strlen($date[1])<2){
                    $date[1] = "0" . (string) $date[1];
                }
                if(strlen($date[2])<2){
                    $date[2] = "0" . (string) $date[2];
                }
                $date = $date[0] . $date[1] . $date[2];
                $data = [
                    "name" => $userinfo[0]["name"],
                    "family" => $userinfo[0]["f_name"],
                    "fatherName" => $userinfo[0]["name_pedar"],
                    "certificateNo" => $userinfo[0]["shomare_shenasname"],
                    "iranian" => $userinfo[0]["isirani"],
                    "identificationType" => $userinfo[0]["noe_shenase_hoviati"],
                    "birthDate" => $date,
                    "identificationNo" => $userinfo[0]["code_meli"],
                    "birthPlace" => $userinfo[0]["shahre_tavalod_name"],
                    "mobile" => $userinfo[0]["telephone_hamrah"],
                    "email" => $userinfo[0]["email"],
                    "gender" => $userinfo[0]["jensiat"],
                    "person" => $userinfo[0]['noe_moshtarak'],
                    "resellerCode" => "0",
                    "address" => [
                        "street2" => $userinfo[0]["tel1_street2"],
                        "address" => $userinfo[0]["address"],
                        "houseNumber" => $userinfo[0]["tel1_vahed"],
                        "tel" => $userinfo[0]["telephone"],
                        "provinceName" => $userinfo[0]["tel1_ostan_name"],
                        "postalCode" => $userinfo[0]["code_posti"],
                    ],
                    "service" => [
                        "type" => $servicecode,
                        "cardSerial" => $userinfo[0]['fid'],
                        // "phoneNumber" => $userinfo[0]["telephone"],
                        // "province" =>(string) $userinfo[0]["tel1_ostan_code"],
                        // "county" => $userinfo[0]["tel1_ostan_name_en"],
                        // "ownershipType" => $userinfo[0]["noe_malekiat"],
                        // "status" => 1,
                        // "credit" => 1,
                        // "general" => 0,
                        // "provincialCountry" => 0,
                        // "ipStatic" => 0, //ToDo
                        // "ip" => "", //ToDo
                        // "subnet" => "", //ToDo                        
                        // "startDate" => $start_service,
                        "endDate" => $end_service,
                    ],
                ];
            } else {
                //hoghoghi irani

                ///tarikhe sabt
                $tarikhe_sabt_sherkat = Helper::dateConvertInitialize($userinfo[0]['tarikhe_sabt'], '-');
                $tarikhe_sabt_sherkat = Helper::gregorian_to_jalali($tarikhe_sabt_sherkat[0], $tarikhe_sabt_sherkat[1], $tarikhe_sabt_sherkat[2]);
                $tarikhe_sabt_sherkat[0] = (string) $tarikhe_sabt_sherkat[0];
                if ($tarikhe_sabt_sherkat[1] < 10) {
                    $tarikhe_sabt_sherkat[1] = "0" . (string) $tarikhe_sabt_sherkat[1];
                }
                if ($tarikhe_sabt_sherkat[2] < 10) {
                    $tarikhe_sabt_sherkat[2] = "0" . (string) $tarikhe_sabt_sherkat[2];
                }
                $tarikhe_sabt_sherkat = $tarikhe_sabt_sherkat[0] . $tarikhe_sabt_sherkat[1] . $tarikhe_sabt_sherkat[2];
                //check namayande meliat va noeshenasehoviati
                if($userinfo[0]['namayande_isirani']===1){
                    //bayad code meli bashad
                    if($userinfo[0]['noe_shenase_hoviati']===0){
                        //passport miladi sayer shamsi
                        $date = Helper::dateConvertInitialize($userinfo[0]['tarikhe_tavalod'], '-');
                        $date = Helper::gregorian_to_jalali($date[0], $date[1], $date[2]);
                        $date[0] = (string) $date[0];
                        if(strlen($date[1])<2){
                            $date[1] = "0" . (string) $date[1];
                        }
                        if(strlen($date[2])<2){
                            $date[2] = "0" . (string) $date[2];
                        }
                        $date = $date[0] . $date[1] . $date[2];
                    }else{
                        return false;
                    }
                }else{
                    //namayande khareji
                    if($userinfo[0]['noe_shenase_hoviati']===1){
                        //passport miladi sayer shamsi
                        $date=explode('-',$userinfo[0]['tarikhe_tavalod']);
                        if(strlen($date[1])<2){
                            $date[1] = "0" . (string) $date[1];
                        }
                        if(strlen($date[2])<2){
                            $date[2] = "0" . (string) $date[2];
                        }
                        $date = $date[0] . $date[1] . $date[2];
                    }else{
                        $date = Helper::dateConvertInitialize($userinfo[0]['tarikhe_tavalod'], '-');
                        $date = Helper::gregorian_to_jalali($date[0], $date[1], $date[2]);
                        $date[0] = (string) $date[0];
                        if(strlen($date[1])<2){
                            $date[1] = "0" . (string) $date[1];
                        }
                        if(strlen($date[2])<2){
                            $date[2] = "0" . (string) $date[2];
                        }
                        $date = $date[0] . $date[1] . $date[2];
                    }
                }
                $data = [
                    "companyName" => $userinfo[0]["name_sherkat"],
                    "iranian" => $userinfo[0]["isirani"],
                    "identificationType" => 5,
                    "registrationDate" => $tarikhe_sabt_sherkat,
                    "identificationNo" => $userinfo[0]["shenase_meli"],
                    "companyType" => $userinfo[0]['companytype'],
                    "registrationNo" => $userinfo[0]['shomare_sabt'],
                    "agentFirstName" => $userinfo[0]["name"],
                    "agentLastName" => $userinfo[0]["f_name"],
                    "agentFatherName" => $userinfo[0]["name_pedar"],
                    "agentIdentificationType" => $userinfo[0]["noe_shenase_hoviati"],
                    "agentIdentificationNo" => $userinfo[0]["code_meli"],
                    "agentNationality" => $userinfo[0]["meliatcode"],
                    "agentBirthCertificateNo" => $userinfo[0]["shomare_shenasname"],
                    "agentBirthDate" => $date,
                    "agentbirthPlace" => $userinfo[0]["shahre_tavalod"],
                    "mobile" => $userinfo[0]["telephone_hamrah"],
                    "email" => $userinfo[0]["email"],
                    "gender" => $userinfo[0]["jensiat"],
                    "person" => $userinfo[0]['noe_moshtarak'],
                    "resellerCode" => "0",
                    "address" => [                        
                        "street2" => $userinfo[0]["tel1_street2"],
                        "address" => $userinfo[0]["address"],
                        "houseNumber" => $userinfo[0]["tel1_vahed"],
                        "tel" => $userinfo[0]["telephone"],
                        "provinceName" => $userinfo[0]["tel1_ostan_name"],
                        "postalCode" => $userinfo[0]["code_posti"],
                    ],
                    "service" => [
                        "type" => $servicecode,
                        "cardSerial" => $userinfo[0]['fid'],
                        // "phoneNumber" => $userinfo[0]["telephone"],
                        // "province" =>(string) $userinfo[0]["tel1_ostan_code"],
                        // "county" => $userinfo[0]["tel1_ostan_name_en"],
                        // "ownershipType" => $userinfo[0]["noe_malekiat"],
                        // "status" => 1,
                        // "credit" => 1,
                        // "general" => 0,
                        // "provincialCountry" => 0,
                        // "ipStatic" => 0, //ToDo
                        // "ip" => "", //ToDo
                        // "subnet" => "", //ToDo                        
                        // "startDate" => $start_service,
                        "endDate" => $end_service,

                    ],
                ];
            }
        } else {
            if ($userinfo[0]['noe_moshtarak'] === 1) {
                //haghighi khareji
                if($userinfo[0]['noe_shenase_hoviati']===1){
                    //passport miladi sayer shamsi
                    $date=explode('-',$userinfo[0]['tarikhe_tavalod']);
                    if(strlen($date[1])<2){
                        $date[1] = "0" . (string) $date[1];
                    }
                    if(strlen($date[2])<2){
                        $date[2] = "0" . (string) $date[2];
                    }
                    $date = $date[0] . $date[1] . $date[2];
                }else{
                    $date = Helper::dateConvertInitialize($userinfo[0]['tarikhe_tavalod'], '-');
                    $date = Helper::gregorian_to_jalali($date[0], $date[1], $date[2]);
                    $date[0] = (string) $date[0];
                    if(strlen($date[1])<2){
                        $date[1] = "0" . (string) $date[1];
                    }
                    if(strlen($date[2])<2){
                        $date[2] = "0" . (string) $date[2];
                    }
                    $date = $date[0] . $date[1] . $date[2];
                }
                $data = [
                    "name" => $userinfo[0]["name"],
                    "family" => $userinfo[0]["f_name"],
                    "fatherName" => $userinfo[0]["name_pedar"],
                    "certificateNo" => $userinfo[0]["shomare_shenasname"],
                    "iranian" => $userinfo[0]["isirani"],
                    "identificationType" => $userinfo[0]["noe_shenase_hoviati"],
                    "birthDate" => $date,
                    "identificationNo" => $userinfo[0]["code_meli"],
                    "birthPlace" => $userinfo[0]["shahre_tavalod"],
                    "mobile" => $userinfo[0]["telephone_hamrah"],
                    "email" => $userinfo[0]["email"],
                    "gender" => $userinfo[0]["jensiat"],
                    "person" => $userinfo[0]['noe_moshtarak'],
                    "resellerCode" => "0",
                    "address" => [                        
                        "street2" => $userinfo[0]["tel1_street2"],
                        "address" => $userinfo[0]["address"],
                        "houseNumber" => $userinfo[0]["tel1_vahed"],
                        "tel" => $userinfo[0]["telephone"],
                        "provinceName" => $userinfo[0]["tel1_ostan_name"],
                        "postalCode" => $userinfo[0]["code_posti"],
                    ],
                    "service" => [
                        "type" => $servicecode,
                        "cardSerial" => $userinfo[0]['fid'],
                        // "phoneNumber" => $userinfo[0]["telephone"],
                        // "province" =>(string) $userinfo[0]["tel1_ostan_code"],
                        // "county" => $userinfo[0]["tel1_ostan_name_en"],
                        // "ownershipType" => $userinfo[0]["noe_malekiat"],
                        // "status" => 1,
                        // "credit" => 1,
                        // "general" => 0,
                        // "provincialCountry" => 0,
                        // "ipStatic" => 0, //ToDo
                        // "ip" => "", //ToDo
                        // "subnet" => "", //ToDo                        
                        // "startDate" => $start_service,
                        "endDate" => $end_service,

                    ],
                ];
            }else{
                //hoghoghi khareji
                if($userinfo[0]['noe_shenase_hoviati']===1){
                    //passport miladi sayer shamsi
                    $date=explode('-',$userinfo[0]['tarikhe_tavalod']);
                    if(strlen($date[1])<2){
                        $date[1] = "0" . (string) $date[1];
                    }
                    if(strlen($date[2])<2){
                        $date[2] = "0" . (string) $date[2];
                    }
                    $date = $date[0] . $date[1] . $date[2];
                }else{
                    $date = Helper::dateConvertInitialize($userinfo[0]['tarikhe_tavalod'], '-');
                    $date = Helper::gregorian_to_jalali($date[0], $date[1], $date[2]);
                    $date[0] = (string) $date[0];
                    if(strlen($date[1])<2){
                        $date[1] = "0" . (string) $date[1];
                    }
                    if(strlen($date[2])<2){
                        $date[2] = "0" . (string) $date[2];
                    }
                    $date = $date[0] . $date[1] . $date[2];
                }


                if($userinfo[0]['namayande_isirani']===1){
                    //bayad code meli bashad
                    if($userinfo[0]['noe_shenase_hoviati']===0){
                        $date = Helper::dateConvertInitialize($userinfo[0]['tarikhe_tavalod'], '-');
                        $date = Helper::gregorian_to_jalali($date[0], $date[1], $date[2]);
                        $date[0] = (string) $date[0];
                        if(strlen($date[1])<2){
                            $date[1] = "0" . (string) $date[1];
                        }
                        if(strlen($date[2])<2){
                            $date[2] = "0" . (string) $date[2];
                        }
                        $date = $date[0] . $date[1] . $date[2];
                    }else{
                        return false;
                    }
                }else{
                    //namayande khareji
                    if($userinfo[0]['noe_shenase_hoviati']===1){
                        //passport miladi sayer shamsi
                        $date=explode('-',$userinfo[0]['tarikhe_tavalod']);
                        if(strlen($date[1])<2){
                            $date[1] = "0" . (string) $date[1];
                        }
                        if(strlen($date[2])<2){
                            $date[2] = "0" . (string) $date[2];
                        }
                        $date = $date[0] . $date[1] . $date[2];
                    }else{
                        $date = Helper::dateConvertInitialize($userinfo[0]['tarikhe_tavalod'], '-');
                        $date = Helper::gregorian_to_jalali($date[0], $date[1], $date[2]);
                        $date[0] = (string) $date[0];
                        if(strlen($date[1])<2){
                            $date[1] = "0" . (string) $date[1];
                        }
                        if(strlen($date[2])<2){
                            $date[2] = "0" . (string) $date[2];
                        }
                        $date = $date[0] . $date[1] . $date[2];
                    }
                }
                $data = [
                    "name" => $userinfo[0]["name"],
                    "family" => $userinfo[0]["f_name"],
                    "fatherName" => $userinfo[0]["name_pedar"],
                    "certificateNo" => $userinfo[0]["shomare_shenasname"],
                    "iranian" => $userinfo[0]["isirani"],
                    "identificationType" => $userinfo[0]["noe_shenase_hoviati"],
                    "birthDate" => $date,
                    "identificationNo" => $userinfo[0]["code_meli"],
                    "birthPlace" => $userinfo[0]["shahre_tavalod"],
                    "mobile" => $userinfo[0]["telephone_hamrah"],
                    "email" => $userinfo[0]["email"],
                    "gender" => $userinfo[0]["jensiat"],
                    "person" => $userinfo[0]['noe_moshtarak'],
                    "resellerCode" => "0",
                    "address" => [                        
                        "street2" => $userinfo[0]["tel1_street2"],
                        "address" => $userinfo[0]["address"],
                        "houseNumber" => $userinfo[0]["tel1_vahed"],
                        "tel" => $userinfo[0]["telephone"],
                        "provinceName" => $userinfo[0]["tel1_ostan_name"],
                        "postalCode" => $userinfo[0]["code_posti"],
                    ],
                    "service" => [
                        "type" => $servicecode,
                        "cardSerial" => $userinfo[0]['fid'],
                        // "phoneNumber" => $userinfo[0]["telephone"],
                        // "province" =>(string) $userinfo[0]["tel1_ostan_code"],
                        // "county" => $userinfo[0]["tel1_ostan_name_en"],
                        // "ownershipType" => $userinfo[0]["noe_malekiat"],
                        // "status" => 1,
                        // "credit" => 1,
                        // "general" => 0,
                        // "provincialCountry" => 0,
                        // "ipStatic" => 0, //ToDo
                        // "ip" => "", //ToDo
                        // "subnet" => "", //ToDo                        
                        // "startDate" => $start_service,
                        "endDate" => $end_service,
                    ],
                ];
            }
        }
        return $data;
    }

    public static function wirelessUserInfo(int $factorid)
    {
        //daryafte kamele etelaate moshtarak va service kharidari shode
        $sql = "SELECT
        sst.id substationid,
        sst.station_id,
        sub.id subscriber_id,
        sub.telephone1 telephone,
        sub.code_posti1 code_posti,
        sub.noe_malekiat1 noe_malekiat,
        IF( sub.noe_moshtarak = 'real', 1, 0 ) noe_moshtarak,
        CONCAT(
            sub.tel1_street,
            ' ',
            sub.tel1_street2,
            ' پلاک ',
            sub.tel1_housenumber,
            ' طبقه ',
            sub.tel1_tabaghe,
            ' واحد ',
            sub.tel1_vahed ) 'address',
        sub.name,
        sub.f_name,
        sub.name_pedar,
        sub.code_meli,
        sub.branch_id,
        sub.email,
        sub.telephone_hamrah,
        sub.telephone_hamrahe_sherkat,
        sub.jensiat,
        sub.tarikhe_tavalod,
        sub.shomare_shenasname,
        sub.shenase_meli,
        sub.name_sherkat,
        sub.shomare_sabt,
        sub.tarikhe_sabt,
        sub.tel1_street,
        sub.tel2_street,
        sub.tel3_street,
        sub.tel1_street2,
        sub.tel2_street2,
        sub.tel3_street2,
        sub.tel1_housenumber,
        sub.tel2_housenumber,
        sub.tel3_housenumber,
        sub.tel1_tabaghe,
        sub.tel2_tabaghe,
        sub.tel3_tabaghe,
        sub.tel1_vahed,
        sub.tel2_vahed,
        sub.tel3_vahed,
        sub.name_malek1,
        sub.f_name_malek1,
    IF( sub.noe_moshtarak = 'real', 1, 0 ) noe_moshtarak,
        sub.noe_shenase_hoviati,
        ser.hadeaxar_sorat_daryaft bandwidth,
        ser.type servicetype,
        ser.id serviceid,
        ser.hadeaxar_sorat_daryaft,
        fa.id fid,
        fa.emkanat_id emkanatid,
        fa.tarikhe_shoroe_service start_service,
        fa.tarikhe_payane_service end_service,
        ostan.code_ostan_shahkar ostane_tavalod_code,
        os.NAME ostane_sokonat_name,
        os.name_en ostane_sokonat_name_en,
        os.code_ostan_shahkar ostane_sokonat_code,
        o1.NAME tel1_ostan_name,
        o1.code_ostan_shahkar tel1_ostan_code,
        o1.name_en tel1_ostan_name_en,
        shahr.NAME shahre_tavalod_name,
        country.CODE meliatcode,
        ncountry.CODE namayande_meliatcode,
    IF( country.CODE = 'IRN', 1, 0 ) isirani,
    IF( ncountry.CODE = 'IRN', 1, 0 ) namayande_isirani,
        company.code_noe_sherkat companytype,
        company.noe_sherkat companytypefarsi 
    FROM
        bnm_factor fa
        INNER JOIN bnm_subscribers sub ON sub.id = fa.subscriber_id
        INNER JOIN bnm_services ser ON ser.id = fa.service_id
        INNER JOIN bnm_ostan ostan ON ostan.id = sub.ostane_tavalod
        INNER JOIN bnm_ostan os ON os.id = sub.ostane_sokonat
        INNER JOIN bnm_ostan o1 ON o1.id = sub.tel1_ostan
        INNER JOIN bnm_shahr s1 ON s1.id = sub.tel1_shahr
        INNER JOIN bnm_shahr ss ON ss.id = sub.shahre_sokonat
        INNER JOIN bnm_shahr shahr ON shahr.id = sub.shahre_tavalod
        INNER JOIN bnm_countries country ON country.id = sub.meliat
        INNER JOIN bnm_sub_station sst ON sst.id = fa.emkanat_id 
        AND sst.sub_id = sub.id
        INNER JOIN bnm_wireless_station st ON st.id = sst.station_id
        LEFT JOIN bnm_countries ncountry ON ncountry.id = sub.meliat_namayande
        LEFT JOIN bnm_company_types company ON company.id = sub.noe_sherkat 
    WHERE
        fa.id = ?
        ";
        $res = Db::secure_fetchall($sql, [$factorid]);
        if($res){
            $res[0]['wirelessusername']= Helper::getIbsUsername($res[0]['subscriber_id'], $res[0]['servicetype'], $res[0]['emkanatid']);
            return $res;
        }else{
            return false;
        }
    }


    public static function putWireless($userinfo)
    {
        //todo ... check ip static and fill parameters
        //service type code
        $servicecode=self::serviceCode($userinfo[0]['servicetype']);
        if(! $servicecode){
            return false;
        }
        //start service
        $start_service = Helper::dateConvertInitialize($userinfo[0]["start_service"], '-');
        $start_service = Helper::gregorian_to_jalali($start_service[0], $start_service[1], $start_service[2]);
        $start_service[0] = (string) $start_service[0];
        if ($start_service[1] < 10) {
            $start_service[1] = "0" . (string) $start_service[1];
        }
        if ($start_service[2] < 10) {
            $start_service[2] = "0" . (string) $start_service[2];
        }
        $start_service = $start_service[0] . $start_service[1] . $start_service[2];
        //end service
        $end_service = Helper::dateConvertInitialize($userinfo[0]["end_service"], '-');
        $end_service = Helper::gregorian_to_jalali($end_service[0], $end_service[1], $end_service[2]);
        $end_service[0] = (string) $end_service[0];
        if ($end_service[1] < 10) {
            $end_service[1] = "0" . (string) $end_service[1];
        }
        if ($end_service[2] < 10) {
            $end_service[2] = "0" . (string) $end_service[2];
        }
        $end_service = $end_service[0] . $end_service[1] . $end_service[2];
        /////////////////////////////////////////////////////////////////////////////////////
        if ($userinfo[0]['isirani'] === 1) {
            if ($userinfo[0]['noe_moshtarak'] === 1) {
                //haghighi irani
                if ($userinfo[0]['noe_shenase_hoviati'] !== 0) {
                    return false;
                }
                $date = Helper::dateConvertInitialize($userinfo[0]['tarikhe_tavalod'], '-');
                $date = Helper::gregorian_to_jalali($date[0], $date[1], $date[2]);
                $date[0] = (string) $date[0];
                if(strlen($date[1])<2){
                    $date[1] = "0" . (string) $date[1];
                }
                if(strlen($date[2])<2){
                    $date[2] = "0" . (string) $date[2];
                }
                $date = $date[0] . $date[1] . $date[2];
                $data = [
                    "name" => $userinfo[0]["name"],
                    "family" => $userinfo[0]["f_name"],
                    "fatherName" => $userinfo[0]["name_pedar"],
                    "certificateNo" => $userinfo[0]["shomare_shenasname"],
                    "iranian" => $userinfo[0]["isirani"],
                    "identificationType" => $userinfo[0]["noe_shenase_hoviati"],
                    "birthDate" => $date,
                    "identificationNo" => $userinfo[0]["code_meli"],
                    "birthPlace" => $userinfo[0]["shahre_tavalod_name"],
                    "mobile" => $userinfo[0]["telephone_hamrah"],
                    "email" => $userinfo[0]["email"],
                    "gender" => $userinfo[0]["jensiat"],
                    "person" => $userinfo[0]['noe_moshtarak'],
                    "resellerCode" => "0",
                    "address" => [
                        "street2" => $userinfo[0]["tel1_street2"],
                        "address" => $userinfo[0]["address"],
                        "houseNumber" => (string)$userinfo[0]["tel1_vahed"],
                        "tel" => $userinfo[0]["telephone"],
                        "provinceName" => $userinfo[0]["tel1_ostan_name"],
                        "postalCode" => $userinfo[0]["code_posti"],
                    ],
                    "service" => [
                        "type" => $servicecode,
                        "ipStatic" => 0, //ToDo
                        "ip" => "", //ToDo
                        "subnet" => "", //ToDo
                        "bandwidth" => $userinfo[0]["hadeaxar_sorat_daryaft"],
                        "startDate" => $start_service,
                        "endDate" => $end_service,
                        "ownershipType" => $userinfo[0]["noe_malekiat"],
                        "province" =>(string) $userinfo[0]["tel1_ostan_code"],
                        "wirelessId" => $userinfo[0]["wirelessusername"],
                        "phoneNumber" => $userinfo[0]["telephone"],

                    ],
                ];
            } else {
                //hoghoghi irani
                ///tarikhe sabt
                $tarikhe_sabt_sherkat = Helper::dateConvertInitialize($userinfo[0]['tarikhe_sabt'], '-');
                $tarikhe_sabt_sherkat = Helper::gregorian_to_jalali($tarikhe_sabt_sherkat[0], $tarikhe_sabt_sherkat[1], $tarikhe_sabt_sherkat[2]);
                $tarikhe_sabt_sherkat[0] = (string) $tarikhe_sabt_sherkat[0];
                if ($tarikhe_sabt_sherkat[1] < 10) {
                    $tarikhe_sabt_sherkat[1] = "0" . (string) $tarikhe_sabt_sherkat[1];
                }
                if ($tarikhe_sabt_sherkat[2] < 10) {
                    $tarikhe_sabt_sherkat[2] = "0" . (string) $tarikhe_sabt_sherkat[2];
                }
                $tarikhe_sabt_sherkat = $tarikhe_sabt_sherkat[0] . $tarikhe_sabt_sherkat[1] . $tarikhe_sabt_sherkat[2];
                //check namayande meliat va noeshenasehoviati
                if($userinfo[0]['namayande_isirani']===1){
                    //bayad code meli bashad
                    if($userinfo[0]['noe_shenase_hoviati']===0){
                        //passport miladi sayer shamsi
                        $date = Helper::dateConvertInitialize($userinfo[0]['tarikhe_tavalod'], '-');
                        $date = Helper::gregorian_to_jalali($date[0], $date[1], $date[2]);
                        $date[0] = (string) $date[0];
                        if(strlen($date[1])<2){
                            $date[1] = "0" . (string) $date[1];
                        }
                        if(strlen($date[2])<2){
                            $date[2] = "0" . (string) $date[2];
                        }
                        $date = $date[0] . $date[1] . $date[2];
                    }else{
                        return false;
                    }
                    $data = [
                        "companyName" => $userinfo[0]["name_sherkat"],
                        "iranian" => $userinfo[0]["isirani"],
                        "identificationType" => 0,
                        "registrationDate" => $tarikhe_sabt_sherkat,
                        "identificationNo" => $userinfo[0]["shenase_meli"],
                        "companyType" => $userinfo[0]['companytype'],
                        "registrationNo" => $userinfo[0]['shomare_sabt'],
                        "agentFirstName" => $userinfo[0]["name"],
                        "agentLastName" => $userinfo[0]["f_name"],
                        "agentFatherName" => $userinfo[0]["name_pedar"],
                        "agentIdentificationType" => $userinfo[0]["noe_shenase_hoviati"],
                        "agentIdentificationNo" => $userinfo[0]["code_meli"],
                        "agentNationality" => $userinfo[0]["meliatcode"],
                        "agentBirthCertificateNo" => $userinfo[0]["shomare_shenasname"],
                        "agentBirthDate" => $date,
                        "agentbirthPlace" => $userinfo[0]["shahre_tavalod_name"],
                        "mobile" => $userinfo[0]["telephone_hamrah"],
                        "email" => $userinfo[0]["email"],
                        "gender" => $userinfo[0]["jensiat"],
                        "person" => $userinfo[0]['noe_moshtarak'],
                        "resellerCode" => "0",
                        "address" => [
                            "street2" => $userinfo[0]["tel1_street2"],
                            "address" => $userinfo[0]["address"],
                            "houseNumber" => (string)$userinfo[0]["tel1_vahed"],
                            "tel" => $userinfo[0]["telephone"],
                            "provinceName" => $userinfo[0]["tel1_ostan_name"],
                            "postalCode" => $userinfo[0]["code_posti"],
                        ],
                        "service" => [
                            "type" => $servicecode,
                            "ipStatic" => 0, //ToDo
                            "ip" => "", //ToDo
                            "subnet" => "", //ToDo
                            "bandwidth" => $userinfo[0]["hadeaxar_sorat_daryaft"],
                            "startDate" => $start_service,
                            "endDate" => $end_service,
                            "ownershipType" => $userinfo[0]["noe_malekiat"],
                            "province" =>(string) $userinfo[0]["tel1_ostan_code"],
                            "wirelessId" => $userinfo[0]["wirelessusername"],
                            "phoneNumber" => $userinfo[0]["telephone"],
    
                        ],
                    ];
                }else{
                    //namayande khareji
                    if($userinfo[0]['noe_shenase_hoviati']===1){
                        //passport miladi sayer shamsi
                        $date=explode('-',$userinfo[0]['tarikhe_tavalod']);
                        if(strlen($date[1])<2){
                            $date[1] = "0" . (string) $date[1];
                        }
                        if(strlen($date[2])<2){
                            $date[2] = "0" . (string) $date[2];
                        }
                        $date = $date[0] . $date[1] . $date[2];
                    }else{
                        $date = Helper::dateConvertInitialize($userinfo[0]['tarikhe_tavalod'], '-');
                        $date = Helper::gregorian_to_jalali($date[0], $date[1], $date[2]);
                        $date[0] = (string) $date[0];
                        if(strlen($date[1])<2){
                            $date[1] = "0" . (string) $date[1];
                        }
                        if(strlen($date[2])<2){
                            $date[2] = "0" . (string) $date[2];
                        }
                        $date = $date[0] . $date[1] . $date[2];
                    }
                }
                $data = [
                    "companyName" => $userinfo[0]["name_sherkat"],
                    "iranian" => $userinfo[0]["isirani"],
                    "identificationType" => 5,
                    "registrationDate" => $tarikhe_sabt_sherkat,
                    "identificationNo" => $userinfo[0]["shenase_meli"],
                    "companyType" => $userinfo[0]['companytype'],
                    "registrationNo" => $userinfo[0]['shomare_sabt'],
                    "agentFirstName" => $userinfo[0]["name"],
                    "agentLastName" => $userinfo[0]["f_name"],
                    "agentFatherName" => $userinfo[0]["name_pedar"],
                    "agentIdentificationType" => $userinfo[0]["noe_shenase_hoviati"],
                    "agentIdentificationNo" => $userinfo[0]["code_meli"],
                    "agentNationality" => $userinfo[0]["meliatcode"],
                    "agentBirthCertificateNo" => $userinfo[0]["shomare_shenasname"],
                    "agentBirthDate" => $date,
                    "agentbirthPlace" => $userinfo[0]["shahre_tavalod_name"],
                    "mobile" => $userinfo[0]["telephone_hamrah"],
                    "email" => $userinfo[0]["email"],
                    "gender" => $userinfo[0]["jensiat"],
                    "person" => $userinfo[0]['noe_moshtarak'],
                    "resellerCode" => "0",
                    "address" => [
                        "street2" => $userinfo[0]["tel1_street2"],
                        "address" => $userinfo[0]["address"],
                        "houseNumber" => (string)$userinfo[0]["tel1_vahed"],
                        "tel" => $userinfo[0]["telephone"],
                        "provinceName" => $userinfo[0]["tel1_ostan_name"],
                        "postalCode" => $userinfo[0]["code_posti"],
                    ],
                    "service" => [
                        "type" => $servicecode,
                        "ipStatic" => 0, //ToDo
                        "ip" => "", //ToDo
                        "subnet" => "", //ToDo
                        "bandwidth" => $userinfo[0]["hadeaxar_sorat_daryaft"],
                        "startDate" => $start_service,
                        "endDate" => $end_service,
                        "ownershipType" => $userinfo[0]["noe_malekiat"],
                        "province" =>(string) $userinfo[0]["tel1_ostan_code"],
                        "wirelessId" => $userinfo[0]["wirelessusername"],
                        "phoneNumber" => $userinfo[0]["telephone"],

                    ],
                ];
            }
        } else {
            if ($userinfo[0]['noe_moshtarak'] === 1) {
                //haghighi khareji
                if($userinfo[0]['noe_shenase_hoviati']===1){
                    //passport miladi sayer shamsi
                    $date=explode('-',$userinfo[0]['tarikhe_tavalod']);
                    if(strlen($date[1])<2){
                        $date[1] = "0" . (string) $date[1];
                    }
                    if(strlen($date[2])<2){
                        $date[2] = "0" . (string) $date[2];
                    }
                    $date = $date[0] . $date[1] . $date[2];
                }else{
                    $date = Helper::dateConvertInitialize($userinfo[0]['tarikhe_tavalod'], '-');
                    $date = Helper::gregorian_to_jalali($date[0], $date[1], $date[2]);
                    $date[0] = (string) $date[0];
                    if(strlen($date[1])<2){
                        $date[1] = "0" . (string) $date[1];
                    }
                    if(strlen($date[2])<2){
                        $date[2] = "0" . (string) $date[2];
                    }
                    $date = $date[0] . $date[1] . $date[2];
                }
                $data = [
                    "name" => $userinfo[0]["name"],
                    "family" => $userinfo[0]["f_name"],
                    "fatherName" => $userinfo[0]["name_pedar"],
                    "certificateNo" => $userinfo[0]["shomare_shenasname"],
                    "iranian" => $userinfo[0]["isirani"],
                    "identificationType" => $userinfo[0]["noe_shenase_hoviati"],
                    "birthDate" => $date,
                    "identificationNo" => $userinfo[0]["code_meli"],
                    "birthPlace" => $userinfo[0]["shahre_tavalod"],
                    "mobile" => $userinfo[0]["telephone_hamrah"],
                    "email" => $userinfo[0]["email"],
                    "gender" => $userinfo[0]["jensiat"],
                    "person" => $userinfo[0]['noe_moshtarak'],
                    "resellerCode" => "0",
                    "address" => [
                        "street2" => $userinfo[0]["tel1_street2"],
                        "address" => $userinfo[0]["address"],
                        "houseNumber" => $userinfo[0]["tel1_vahed"],
                        "tel" => $userinfo[0]["telephone"],
                        "provinceName" => $userinfo[0]["tel1_ostan_name"],
                        "postalCode" => $userinfo[0]["code_posti"],
                    ],
                    "service" => [
                        "type" => $servicecode,
                        "ipStatic" => 0, //ToDo
                        "ip" => "", //ToDo
                        "subnet" => "", //ToDo
                        "bandwidth" => $userinfo[0]["hadeaxar_sorat_daryaft"],
                        "ownershipType" => $userinfo[0]["noe_malekiat"],
                        "startDate" => $start_service,
                        "endDate" => $end_service,
                        "province" =>(string) $userinfo[0]["tel1_ostan_code"],
                        "wirelessId" => $userinfo[0]["wirelessusername"],
                        "phoneNumber" => $userinfo[0]["telephone"],

                    ],
                ];
            }else{
                //hoghoghi khareji
                if($userinfo[0]['noe_shenase_hoviati']===1){
                    //passport miladi sayer shamsi
                    $date=explode('-',$userinfo[0]['tarikhe_tavalod']);
                    if(strlen($date[1])<2){
                        $date[1] = "0" . (string) $date[1];
                    }
                    if(strlen($date[2])<2){
                        $date[2] = "0" . (string) $date[2];
                    }
                    $date = $date[0] . $date[1] . $date[2];
                }else{
                    $date = Helper::dateConvertInitialize($userinfo[0]['tarikhe_tavalod'], '-');
                    $date = Helper::gregorian_to_jalali($date[0], $date[1], $date[2]);
                    $date[0] = (string) $date[0];
                    if(strlen($date[1])<2){
                        $date[1] = "0" . (string) $date[1];
                    }
                    if(strlen($date[2])<2){
                        $date[2] = "0" . (string) $date[2];
                    }
                    $date = $date[0] . $date[1] . $date[2];
                }


                if($userinfo[0]['namayande_isirani']===1){
                    //bayad code meli bashad
                    if($userinfo[0]['noe_shenase_hoviati']===0){
                        $date = Helper::dateConvertInitialize($userinfo[0]['tarikhe_tavalod'], '-');
                        $date = Helper::gregorian_to_jalali($date[0], $date[1], $date[2]);
                        $date[0] = (string) $date[0];
                        if(strlen($date[1])<2){
                            $date[1] = "0" . (string) $date[1];
                        }
                        if(strlen($date[2])<2){
                            $date[2] = "0" . (string) $date[2];
                        }
                        $date = $date[0] . $date[1] . $date[2];
                    }else{
                        return false;
                    }
                }else{
                    //namayande khareji
                    if($userinfo[0]['noe_shenase_hoviati']===1){
                        //passport miladi sayer shamsi
                        $date=explode('-',$userinfo[0]['tarikhe_tavalod']);
                        if(strlen($date[1])<2){
                            $date[1] = "0" . (string) $date[1];
                        }
                        if(strlen($date[2])<2){
                            $date[2] = "0" . (string) $date[2];
                        }
                        $date = $date[0] . $date[1] . $date[2];
                    }else{
                        $date = Helper::dateConvertInitialize($userinfo[0]['tarikhe_tavalod'], '-');
                        $date = Helper::gregorian_to_jalali($date[0], $date[1], $date[2]);
                        $date[0] = (string) $date[0];
                        if(strlen($date[1])<2){
                            $date[1] = "0" . (string) $date[1];
                        }
                        if(strlen($date[2])<2){
                            $date[2] = "0" . (string) $date[2];
                        }
                        $date = $date[0] . $date[1] . $date[2];
                    }
                }
                $data = [
                    "name" => $userinfo[0]["name"],
                    "family" => $userinfo[0]["f_name"],
                    "fatherName" => $userinfo[0]["name_pedar"],
                    "certificateNo" => $userinfo[0]["shomare_shenasname"],
                    "iranian" => $userinfo[0]["isirani"],
                    "identificationType" => $userinfo[0]["noe_shenase_hoviati"],
                    "birthDate" => $date,
                    "identificationNo" => $userinfo[0]["code_meli"],
                    "birthPlace" => $userinfo[0]["shahre_tavalod"],
                    "mobile" => $userinfo[0]["telephone_hamrah"],
                    "email" => $userinfo[0]["email"],
                    "gender" => $userinfo[0]["jensiat"],
                    "person" => $userinfo[0]['noe_moshtarak'],
                    "resellerCode" => "0",
                    "address" => [
                        "street2" => $userinfo[0]["tel1_street2"],
                        "address" => $userinfo[0]["address"],
                        "houseNumber" => $userinfo[0]["tel1_vahed"],
                        "tel" => $userinfo[0]["telephone"],
                        "provinceName" => $userinfo[0]["tel1_ostan_name"],
                        "postalCode" => $userinfo[0]["code_posti"],
                    ],
                    "service" => [
                        "type" => $servicecode,
                        "ipStatic" => 0, //ToDo
                        "ip" => "", //ToDo
                        "subnet" => "", //ToDo
                        "bandwidth" => $userinfo[0]["hadeaxar_sorat_daryaft"],
                        "ownershipType" => $userinfo[0]["noe_malekiat"],
                        "startDate" => $start_service,
                        "endDate" => $end_service,
                        "province" =>(string) $userinfo[0]["tel1_ostan_code"],
                        "wirelessId" => $userinfo[0]["wirelessusername"],
                        "phoneNumber" => $userinfo[0]["telephone"],

                    ],
                ];
            }
        }
        return $data;
    }

    public static function tdlteUserInfo(int $factorid)
    {
        //daryafte kamele etelaate moshtarak va service kharidari shode
        $sql = "SELECT
            sim.tdlte_number,
            sim.serial,
            sim.puk1,
            sim.puk2,
            sub.id subscriber_id, 
            sub.name,
            sub.f_name,
            sub.name_pedar,
            sub.code_meli,
            sub.branch_id,
            sub.email,
            sub.telephone_hamrah,
            sub.telephone_hamrahe_sherkat,
            sub.jensiat,
            sub.tarikhe_tavalod,
            sub.shomare_shenasname,
            sub.shenase_meli,
            sub.name_sherkat,
            sub.shomare_sabt,
            sub.tarikhe_sabt,
            sub.telephone1,
            sub.tel1_street,
            sub.tel2_street,
            sub.tel3_street,
            sub.tel1_street2,
            sub.tel2_street2,
            sub.tel3_street2,
            sub.tel1_housenumber,
            sub.tel2_housenumber,
            sub.tel3_housenumber,
            sub.tel1_tabaghe,
            sub.tel2_tabaghe,
            sub.tel3_tabaghe,
            sub.tel1_vahed,
            sub.tel2_vahed,
            sub.tel3_vahed,
            sub.noe_malekiat1,
            sub.name_malek1,
            sub.f_name_malek1,
            sub.code_posti1,
            CONCAT(sub.tel1_street, ' ', sub.tel1_street2, ' پلاک ', sub.tel1_housenumber, ' طبقه ', sub.tel1_tabaghe, ' واحد ',sub.tel1_vahed ) 'address',
            if(sub.noe_moshtarak='real',1,0) noe_moshtarak,
            sub.noe_shenase_hoviati,
            ser.hadeaxar_sorat_daryaft bandwidth,
            ser.type servicetype,
            ser.id serviceid,
            ser.hadeaxar_sorat_daryaft,
            fa.id fid,
            fa.emkanat_id emkanatid,
            fa.tarikhe_shoroe_service start_service,
            fa.tarikhe_payane_service end_service,
            
            ostan.code_ostan_shahkar ostane_tavalod_code,
            os.name ostane_sokonat_name,
            os.name_en ostane_sokonat_name_en,
            os.code_ostan_shahkar ostane_sokonat_code,
            t1ostan.name tel1_ostan_name,
            t1ostan.code_ostan_shahkar tel1_ostan_code,
            t1ostan.name_en tel1_ostan_name_en,
            shahr.name shahre_tavalod_name,

            country.code meliatcode,
            ncountry.code namayande_meliatcode,
            IF( country.code = 'IRN', 1, 0 ) isirani,
            IF( ncountry.code = 'IRN', 1, 0 ) namayande_isirani,
            company.code_noe_sherkat companytype,
            company.noe_sherkat companytypefarsi
            FROM
                bnm_factor fa
                INNER JOIN bnm_subscribers sub ON sub.id = fa.subscriber_id
                INNER JOIN bnm_services ser ON ser.id = fa.service_id
                INNER JOIN bnm_ostan ostan ON ostan.id = sub.ostane_tavalod
                INNER JOIN bnm_shahr shahr ON shahr.id = sub.shahre_tavalod
                INNER JOIN bnm_ostan os ON os.id = sub.ostane_sokonat
                INNER JOIN bnm_ostan t1ostan ON t1ostan.id = sub.tel1_ostan
                INNER JOIN bnm_shahr ss ON ss.id = sub.shahre_sokonat
                INNER JOIN bnm_shahr t1shahr ON t1shahr.id = sub.tel1_shahr
                INNER JOIN bnm_countries country ON country.id = sub.meliat
                INNER JOIN bnm_tdlte_sim sim ON sim.id = fa.emkanat_id
                LEFT JOIN bnm_countries ncountry ON ncountry.id = sub.meliat_namayande
                LEFT JOIN bnm_company_types company ON company.id = sub.noe_sherkat
            WHERE
            fa.id = ?
        ";
        $res = Db::secure_fetchall($sql, [$factorid]);
        if($res){
            return $res;
        } else{
            return false;
        }
    }


    public static function getSubInfo($subid)
    {
        $sql = "
		SELECT
			sub.*,
			country.code codecountry,
		IF( country.code = 'IRN', 1, 0 ) isirani,
			company.code_noe_sherkat companytype,
			company.noe_sherkat companytypefarsi
		FROM
			bnm_subscribers sub
			INNER JOIN bnm_countries country ON country.id = sub.meliat
			LEFT JOIN bnm_company_types company ON company.id = sub.noe_sherkat
		WHERE
			sub.id = ?
		";
        $res = Db::secure_fetchall($sql, [$subid]);
        return $res;
    }

    public static function getSubInfoBytelephoneid($subid, $telephoneid)
    {
        $telephoneid = (int) $telephoneid;
        if ($telephoneid === 1) {
            $sql = "
            SELECT
                sub.telephone1 telephone,
                sub.address1 address,
                sub.code_posti1 code_posti,
                sub.noe_malekiat1 noe_malekiat,
                sub.name_malek1 name_malek,
                sub.code_meli_malek1 code_meli,
                country.code codecountry,
                IF( country.code = 'IRN', 1, 0 ) isirani
                FROM bnm_subscribers sub
                INNER JOIN bnm_countries country ON country.id = sub.meliat
            WHERE
                sub.id=?
            ";
        } elseif ($telephoneid === 2) {
            $sql = "
            SELECT
                sub.telephone2 telephone,
                sub.address2 address,
                sub.code_posti2 code_posti,
                sub.noe_malekiat2 noe_malekiat,
                sub.name_malek2 name_malek,
                sub.code_meli_malek2 code_meli,
                country.code codecountry,
                IF( country.code = 'IRN', 1, 0 ) isirani
                FROM bnm_subscribers sub
                INNER JOIN bnm_countries country ON country.id = sub.meliat
            WHERE
                sub.id=?
            ";
        } elseif ($telephoneid === 3) {
            $sql = "
            SELECT
                sub.telephone3 telephone,
                sub.address3 address,
                sub.code_posti3 code_posti,
                sub.noe_malekiat3 noe_malekiat,
                sub.name_malek3 name_malek,
                sub.code_meli_malek3 code_meli,
                country.code codecountry,
                IF( country.code = 'IRN', 1, 0 ) isirani
                FROM bnm_subscribers sub
                INNER JOIN bnm_countries country ON country.id = sub.meliat
            WHERE
                sub.id=?
            ";
        } else {
            return false;
        }
        $res = Db::secure_fetchall($sql, [$subid]);
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }

    //depricated ?
    public static function stelamUserInfo(int $factor_id, int $branch_id)
    {
        if ($branch_id === 0) {
            $sql = "SELECT
            sub.*,
            ser.type serviceType,
            ser.id serviceId,
            fa.id fid,
            fa.emkanat_id emkanatId,
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
            INNER JOIN bnm_countries country ON country.id = sub.meliat
            INNER JOIN bnm_company_types company ON company.id = sub.shahre_tavalod
            INNER JOIN bnm_port p ON p.id = fa.emkanat_id
            WHERE fa.id = ?";
            $res = Db::secure_fetchall($sql, [$factor_id]);
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
            INNER JOIN bnm_countries country ON country.id = sub.meliat
            INNER JOIN bnm_company_types company ON company.id = sub.noe_sherkat
            INNER JOIN bnm_port p ON p.id = fa.emkanat_id
            WHERE fa.id = ?";
            $res = Db::secure_fetchall($sql, [$factor_id]);
            return $res;

        }
    }

    public static function serviceCode($type)
    {
        switch ($type) {
            case 'bitstream':
            case 'adsl':
            case 'vdsl':
                return 3;
                break;
            case 'wireless':
                return 5;
                break;
            case 'tdlte':
                return 18;
                break;
            case 'voip':
                return 36;
                break;
            case 'domain':
                return 29;
                break;
            case 'reseller':
                return 30;
                break;
            default:
                return false;
                break;
        }
    }

    //data haye estelam ha
    public static function DataEstRequestHistory($request_id, $enquiry_id)
    {
        $data = [
            "enquiryId" => $enquiry_id, //shomare mored darkhast
            "response" => 200,

        ];
        if (!$data) {
            return false;
        } else {
            return $data;
        }
    }

    public static function DataEstestDailyReport($request_id)
    {
        $data = [

        ];
        if ($data) {
            return $data;
        }
    }

    public static function EstServiceStatus($sertype, $servicenumber)
    {
        $servicetypecode = self::service_type($sertype);
        $data = [
            "serviceType" => $servicetypecode,
            "serviceNumber" => $servicenumber
        ];
        if ($data) {
            return $data;
        }else{
            return false;
        }
    }

    public static function DataEstReceiveClassifier($request_id, $userinfo)
    {
        if (empty($userinfo[0]['telephone'])) {
            $userinfo[0]["telephone"] = "317";
        }
        $service_type = self::service_type($userinfo[0]['serviceType']);
        $data = [
            "requestId" => $request_id,
            "serviceType" => $service_type,
            "serviceNumber" => $userinfo[0]['telephone'],

        ];
        if ($data) {
            return $data;
        }
    }

    public static function DataEstServiceMatching($request_id, $userinfo)
    {
        $service_type = self::service_type($userinfo[0]['serviceType']);
        $data = [
            "requestId" => $request_id,
            "serviceNumber" => $userinfo[0]['telephone'],
            "identificationNo" => $userinfo[0]['shenase_meli'],
            "identificationType" => $userinfo[0]['noe_shenase_hoviati'],
            "serviceType" => $service_type,
        ];
        if ($data) {
            return $data;
        }
    }

    public static function DataEstServiceMatching2($request_id, $userinfo)
    {
        $service_type = self::service_type($userinfo[0]['serviceType']);
        $data = [
            "requestId" => $request_id,
            "serviceNumber" => $userinfo[0]['telephone'],
            "identificationNo" => $userinfo[0]['shenase_meli'],
            "identificationType" => $userinfo[0]['noe_shenase_hoviati'],
            "serviceType" => $service_type,

        ];
        if ($data) {
            return $data;
        }
    }

    public static function DataEstServiceMatching3($userinfo)
    {
        $service_type = self::service_type($userinfo[0]['serviceType']);
        $data = [
            "serviceNumber" => $userinfo[0]['telephone'],
            "identificationNo" => $userinfo[0]['shenase_meli'],
            "identificationType" => $userinfo[0]['noe_shenase_hoviati'],
            "serviceType" => $service_type,

        ];
        return $data;
    }

    public static function DataEstReportOfOperatorsServices($request_id)
    {
        $data = [
            "requestId" => $request_id,

        ];
        if ($data) {
            return $data;
        }
    }

    public static function DataEstAuthenticationIranianReal($userinfo)
    {
        $date = Helper::dateConvertInitialize($userinfo[0]['tarikhe_tavalod'], '-');
        $date = Helper::gregorian_to_jalali($date[0], $date[1], $date[2]);
        $date[0] = (string) $date[0];
        if ($date[1] < 10) {
            $date[1] = "0" . (string) $date[1];
        }
        if ($date[2] < 10) {
            $date[2] = "0" . (string) $date[2];
        }
        $date = $date[0] . $date[1] . $date[2];
        $arr = [
            'estelaamType' => 0,
            'name' => $userinfo[0]['name'],
            'family' => $userinfo[0]['f_name'],
            'fatherName' => $userinfo[0]['name_pedar'],
            'identificationType' => (int) $userinfo[0]['noe_shenase_hoviati'],
            'identificationNo' => $userinfo[0]['code_meli'],
            'nationality'=>$userinfo[0]['codecountry'],
            'birthDate' => $date,
            'certificateNo' => $userinfo[0]['shomare_shenasname'],
            "iranian" => $userinfo[0]["isirani"],
        ];
        if ($arr) {
            return $arr;
        } else {
            return false;
        }
    }

    public static function DataEstAuthenticationForeignReal($userinfo)
    {
        //tarikhe_tavalod
        // $tarikhe_tavalod = Helper::dateConvertInitialize($userinfo[0]['tarikhe_tavalod'], '-');
        // $tarikhe_tavalod = Helper::gregorian_to_jalali($tarikhe_tavalod[0], $tarikhe_tavalod[1], $tarikhe_tavalod[2]);
        // $tarikhe_tavalod[0] = (string) $tarikhe_tavalod[0];
        // if ($tarikhe_tavalod[1] < 10) {
        //     $tarikhe_tavalod[1] = "0" . (string) $tarikhe_tavalod[1];
        // }
        // if ($tarikhe_tavalod[2] < 10) {
        //     $tarikhe_tavalod[2] = "0" . (string) $tarikhe_tavalod[2];
        // }



        $date = Helper::dateConvertInitialize($userinfo[0]['tarikhe_tavalod'], '-');
                $date = Helper::gregorian_to_jalali($date[0], $date[1], $date[2]);
                $date[0] = (string) $date[0];
                if(strlen($date[1])<2){
                    $date[1] = "0" . (string) $date[1];
                }
                if(strlen($date[2])<2){
                    $date[2] = "0" . (string) $date[2];
                }
                $date = $date[0] . $date[1] . $date[2];
        $data = [
            "estelaamType" => 0,
            "name" => $userinfo[0]['name'],
            "family" => $userinfo[0]['f_name'],
            "fatherName" => $userinfo[0]['name_pedar'],
            "identificationType" => (int) $userinfo[0]['noe_shenase_hoviati'],
            "birthDate" => $date,
            "identificationNo" => $userinfo[0]['shenase_meli'],
            "nationality" => $userinfo[0]['codeCountry'],
            "iranian" => $userinfo[0]["isirani"],
        ];
        if ($data) {
            return $data;
        }
    }

    public static function DataEstAuthenticationIranianLegal($userinfo)
    {
        //tarikhe_tavalod
        // $tarikhe_tavalod = Helper::dateConvertInitialize($userinfo[0]['tarikhe_tavalod'], '-');
        // $tarikhe_tavalod = Helper::gregorian_to_jalali($tarikhe_tavalod[0], $tarikhe_tavalod[1], $tarikhe_tavalod[2]);
        // $tarikhe_tavalod[0] = (string) $tarikhe_tavalod[0];
        // if ($tarikhe_tavalod[1] < 10) {
        //     $tarikhe_tavalod[1] = "0" . (string) $tarikhe_tavalod[1];
        // }
        // if ($tarikhe_tavalod[2] < 10) {
        //     $tarikhe_tavalod[2] = "0" . (string) $tarikhe_tavalod[2];
        // }

        $date = Helper::dateConvertInitialize($userinfo[0]['tarikhe_tavalod'], '-');
        $date = Helper::gregorian_to_jalali($date[0], $date[1], $date[2]);
        $date[0] = (string) $date[0];
        if(strlen($date[1])<2){
            $date[1] = "0" . (string) $date[1];
        }
        if(strlen($date[2])<2){
            $date[2] = "0" . (string) $date[2];
        }
        $date = $date[0] . $date[1] . $date[2];


        
        //tarikhe_sabte_sherkat
        $ts = Helper::dateConvertInitialize($userinfo[0]['tarikhe_sabt'], '-');
        $ts = Helper::gregorian_to_jalali($ts[0], $ts[1], $ts[2]);
        $ts[0] = (string) $ts[0];


        if(strlen($ts[1])<2){
            $ts[1] = "0" . (string) $ts[1];
        }
        if(strlen($ts[2])<2){
            $ts[2] = "0" . (string) $ts[2];
        }
        $ts = $ts[0] . $ts[1] . $ts[2];

        
        $arr = [
            'estelaamType' => 0,
            'companyName' => $userinfo[0]["name_sherkat"],
            'companyType' => $userinfo[0]["noe_sherkat"],
            'identificationType' => 5,
            'identificationNo' => $userinfo[0]['shenase_meli'],
            'registrationDate' => $ts,
            'registrationNo' => $userinfo[0]["shomare_sabt"],
            "agentFirstName" => $userinfo[0]["name"],
            "agentLastName" => $userinfo[0]["f_name"],
            "agentFatherName" => $userinfo[0]["name_pedar"],
            "agentIdentificationNo" => $userinfo[0]["code_meli"],
            "agentIdentificationType" => $userinfo[0]["noe_shenase_hoviati"],
            "agentBirthDate" => $date,
            "agentBirthCertificateNo" => $userinfo[0]["shomare_shenasname"],
            "iranian" => $userinfo[0]["isirani"],
        ];
        return $arr;
    }

    public static function DataEstAuthenticationForeignLegal($userinfo)
    {

        //tarikhe_tavalod
        $tarikhe_tavalod = Helper::dateConvertInitialize($userinfo[0]['tarikhe_tavalod'], '-');
        $tarikhe_tavalod = Helper::gregorian_to_jalali($tarikhe_tavalod[0], $tarikhe_tavalod[1], $tarikhe_tavalod[2]);
        $tarikhe_tavalod[0] = (string) $tarikhe_tavalod[0];
        if ($tarikhe_tavalod[1] < 10) {
            $tarikhe_tavalod[1] = "0" . (string) $tarikhe_tavalod[1];
        }
        if ($tarikhe_tavalod[2] < 10) {
            $tarikhe_tavalod[2] = "0" . (string) $tarikhe_tavalod[2];
        }
        //tarikhe_sabte_sherkat
        $tarikhe_sabte_sherkat = Helper::dateConvertInitialize($userinfo[0]['tarikhe_sabte_sherkat'], '-');
        $tarikhe_sabte_sherkat = Helper::gregorian_to_jalali($tarikhe_sabte_sherkat[0], $tarikhe_sabte_sherkat[1], $tarikhe_sabte_sherkat[2]);
        $tarikhe_sabte_sherkat[0] = (string) $tarikhe_sabte_sherkat[0];
        if ($tarikhe_sabte_sherkat[1] < 10) {
            $tarikhe_sabte_sherkat[1] = "0" . (string) $tarikhe_sabte_sherkat[1];
        }
        if ($tarikhe_sabte_sherkat[2] < 10) {
            $tarikhe_sabte_sherkat[2] = "0" . (string) $tarikhe_sabte_sherkat[2];
        }
        if ($tarikhe_sabte_sherkat[2] < 10) {
            $tarikhe_sabte_sherkat[2] = "0" . (string) $tarikhe_sabte_sherkat[2];
        }
        $arr = [
            'estelaamType' => 0,
            'companyName' => $userinfo[0]["name_sherkat"],
            'companyType' => $userinfo[0]["noe_sherkat"],
            'identificationType' => (int) $userinfo[0]['noe_shenase_hoviati'],
            'identificationNo' => $userinfo[0]['shenase_hoviati_sherkat'],
            'registrationDate' => $tarikhe_sabte_sherkat[0] . $tarikhe_sabte_sherkat[1] . $tarikhe_sabte_sherkat[2],
            'registrationNo' => $userinfo[0]["shomare_sabt"],
            "agentFirstName" => $userinfo[0]["name"],
            "agentLastName" => $userinfo[0]["f_name"],
            "agentFatherName" => $userinfo[0]["name_pedar"],
            "agentIdentificationNo" => $userinfo[0]["code_meli"],
            "agentIdentificationType" => $userinfo[0]["noe_shenase_hoviati"],
            "agentBirthDate" => $tarikhe_tavalod[0] . $tarikhe_tavalod[1] . $tarikhe_tavalod[2],
            "agentBirthCertificateNo" => $userinfo[0]["shomare_shenasname"],
            "iranian" => $userinfo[0]["isirani"],
        ];
        return $arr;
    }

    public static function DataEstPostalCode($userinfo)
    {
        $data = [
            "estelaamType" => 1, //codeposti 1
            "address" => [
                "address" => $userinfo[0]["address"],
                "postalCode" => $userinfo[0]["code_posti"],
                "tel" => $userinfo[0]["telephone"],
            ],
            "response" => 200,
        ];
        if ($data) {
            return $data;
        }
    }

    public static function DataEstServices($userinfo)
    {
        $data = [
            "serviceReportType" => 0, //estelam service 0
            "identificationType" => $userinfo[0]['noe_shenase_hoviati'],
            "identificationNo" => $userinfo[0]['shenase_meli'],
            "mobileNumber" => $userinfo[0]['telephone_hamrah'],
            "response" => 200,
        ];
        if ($data) {
            return $data;
        }
    }

    public static function DataEstReceiveTrackingCode($userinfo)
    {
        $data = [
            "serviceReportType" => 1, //estelam code rahgiri 1
            "identificationType" => $userinfo[0]['noe_shenase_hoviati'],
            "identificationNo" => $userinfo[0]['shenase_meli'],
            "mobileNumber" => $userinfo[0]['telephone_hamrah'],
            "response" => 200,
        ];
        if ($data) {
            return $data;
        }
    }

    public static function DataEstServiceByTrackingCode($userinfo)
    {
        $data = [
            "serviceReportType" => 1, //estelam code rahgiri 1
            "pursuitCode" => "12345", //ToDo
            "mobileNumber" => $userinfo[0]['telephone_hamrah'],
            "identificationType" => $userinfo[0]['noe_shenase_hoviati'],
            "identificationNo" => $userinfo[0]['shenase_meli'],
            "response" => 200,
        ];
        if ($data) {
            return $data;
        }
    }

    public static function DataEstTedadSimkart($request_id, $userinfo)
    {
        $data = [
            "identificationType" => $userinfo[0]['noe_shenase_hoviati'],
            "identificationNo" => $userinfo[0]['shenase_meli'],
            "response" => 200,
        ];
        if ($data) {
            return $data;
        }
    }

    public static function service_type($service_type)
    {
        //adsl,vdsl,bitstream//wireless//tdlte//voip
        switch ($service_type) {
            case "Adsl":
            case "adsl":
            case "vdsl":
            case "Vdsl":
            case "bitstream":
            case "Bitstream":
                $service_type = 3;
                break;
            case "wireless":
            case "Wireless":
                $service_type = 5;
                break;
            case "Voip":
            case "voip":
                $service_type = 17;
                break;
            case "TDLTE":
            case "tdlte":
                $service_type = 18;
                break;
            case "reseller":
            case "Reseller":
                $service_type = 30;
                break;
            default:
                return $service_type;
        }
        if ($service_type) {
            return $service_type;
        }
    }

    public static function shamsidate($datainfo)
    {
        $Gregorian_date = $datainfo;
        $Gregorian_date = strtotime($Gregorian_date);
        $solar_date = Helper::jdate("Y/m/d", $Gregorian_date, "", "Asia/Tehran", "en");
        $shamsidate = str_replace('/', '', $solar_date);
        if ($shamsidate) {
            return $shamsidate;
        } else {
            return false;
        }
    }

}
