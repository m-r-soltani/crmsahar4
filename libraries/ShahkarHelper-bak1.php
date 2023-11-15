<?php
// require_once "shahkar.php";
// $shahkar = new Shahkar();
class ShahkarHelper
{
//databases
    public static function checkUserInfo(int $factor_id)
    {
        //daryafte etelaate moshtarak va service kharidari shode
        $sql = "SELECT
            sub.*,
            country.code meliatcode,
            ser.type serviceType
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
            ostan.pish_shomare_ostan codeostan,
            shahr.name shahre_tavalod,
            country.code meliatcode,
        IF
            ( country.code = 'IRN', 1, 0 ) isirani,
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
                sub.address1
                WHEN p.telephone = 2 THEN
                sub.address2
                WHEN p.telephone = 3 THEN
                sub.address3
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
            INNER JOIN bnm_shahr shahr ON shahr.id = sub.shahre_tavalod
            INNER JOIN bnm_countries country ON country.id = sub.meliat
            LEFT JOIN bnm_company_types company ON company.id = sub.noe_sherkat
            INNER JOIN bnm_port p ON p.id = fa.emkanat_id
        WHERE
        fa.id = ?";
        $res = Db::secure_fetchall($sql, [$factorid]);
        return $res;
    }

    //adsl put data
    public static function putAdsl($userinfo)
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
        
        if ($userinfo[0]['isirani'] === 1) {
            if ($userinfo[0]['noe_moshtarak'] === 1) {
                //haghighi irani
                if ($userinfo[0]['noe_shenase_hoviati'] !== 0) {
                    return false;
                }
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
                    "resellerCode" => (string) $userinfo[0]["branch_id"],
                    "address" => [
                        "address" => $userinfo[0]["address"],
                        "postalCode" => $userinfo[0]["code_posti"],
                        "tel" => $userinfo[0]["telephone"],
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
                        "province" => $userinfo[0]["codeostan"],
                        "phoneNumber" => $userinfo[0]["telephone"],

                    ],
                ];
            } else {
                //hoghoghi irani
                ///tarikhe tavalod namayande
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
                    "resellerCode" => (string) $userinfo[0]["branch_id"],
                    "address" => [
                        "address" => $userinfo[0]["address"],
                        "postalCode" => $userinfo[0]["code_posti"],
                        "tel" => $userinfo[0]["telephone"],
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
                        "province" => $userinfo[0]["codeostan"],
                        "phoneNumber" => $userinfo[0]["telephone"],

                    ],
                ];
            }
        } else {
            if ($userinfo[0]['noe_moshtarak'] === 1) {
                //haghighi khareji
            }else{
                //hoghoghi khareji
            }
        }
        return $data;
    }

    public static function voipUserInfo(int $factor_id, int $branch_id)
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
            INNER JOIN bnm_company_types company ON company.id = sub.noe_sherkat
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
            INNER JOIN bnm_company_types company ON company.id = sub.noe_sherkat
            INNER JOIN bnm_port p ON p.id = fa.emkanat_id
            INNER JOIN bnm_branch branch ON branch.id = sub.branch_id
            WHERE fa.id = ?";
            $res = Db::secure_fetchall($sql, [$factor_id]);
            return $res;
        }
    }

    public static function wirelessUserInfo(int $factor_id, int $branch_id)
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
        FROM
            bnm_factor fa
            INNER JOIN bnm_subscribers sub ON sub.id = fa.subscriber_id
            INNER JOIN bnm_services ser ON ser.id = fa.service_id
            INNER JOIN bnm_ostan ostan ON ostan.id = sub.ostane_tavalod
            INNER JOIN bnm_shahr shahr ON shahr.id = sub.shahre_tavalod
            INNER JOIN bnm_countries country ON country.id = sub.meliat
            INNER JOIN bnm_company_types company ON company.id = sub.noe_sherkat
            INNER JOIN bnm_wireless_station station ON station.id = fa.emkanat_id
            INNER JOIN bnm_port p ON p.id = fa.emkanat_id
            INNER JOIN bnm_wireless_ap ap ON station.wireless_ap = ap.id
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
            INNER JOIN bnm_company_types company ON company.id = sub.noe_sherkat
            INNER JOIN bnm_branch branch ON branch.id = sub.branch_id
            INNER JOIN bnm_wireless_station station ON station.id = fa.emkanat_id
            INNER JOIN bnm_port p ON p.id = fa.emkanat_id
            INNER JOIN bnm_wireless_ap ap ON station.wireless_ap = ap.id
            WHERE fa.id = ?";
            $res = Db::secure_fetchall($sql, [$factor_id]);
            return $res;
        }
    }

    public static function getSubInfo($subid)
    {
        $sql = "
		SELECT
			sub.*,
			country.code codeCountry,
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
                return 17;
                break;
            case 'domain':
                return 29;
                break;
            default:
                return false;
                break;
        }
    }
//adsl update data
    public static function updateAdslRealIrani($userinfo, $request_id)
    {
        if (empty($userinfo[0]["shomare_shenasname"])) {
            $userinfo[0]["shomare_shenasname"] = "0";
        }
        $shamsi_birth = self::shamsidate($userinfo[0]["tarikhe_tavalod"]);
        $shamsi_start_serv = self::shamsidate($userinfo[0]["start_service"]);
        $userinfo[0]["start_service"] = $shamsi_start_serv;
        $shamsi_end_serv = self::shamsidate($userinfo[0]["end_service"]);
        $userinfo[0]["end_service"] = $shamsi_end_serv;
        $persian_subnet = Helper::convert_numbers("255.255.255.0");
        if ($userinfo[0]['isirani'] === 1) {
            $userinfo[0]["tarikhe_tavalod"] = $shamsi_birth;
        }
        $data = [
            //شماره کلاسه معتبر
            "id" => "",
            //شماره مشخصه سرویس
            "serviceNumber" => $userinfo[0]["telephone"],
            "customerUpdate" => [
                "name" => $userinfo[0]["name"],
                "gender" => $userinfo[0]["jensiat"],
                "family" => $userinfo[0]["f_name"],
                "fatherName" => $userinfo[0]["name_pedar"],
                "birthDate" => $userinfo[0]["tarikhe_tavalod"],
                "birthPlace" => $userinfo[0]["shahre_tavalod"],
                "email" => $userinfo[0]["email"],
                "mobile" => $userinfo[0]["telephone_hamrah"],
            ],
            "addressUpdate" => [
                "address" => $userinfo[0]["address"],
                "postalCode" => $userinfo[0]["code_posti"],
                "tel" => $userinfo[0]["telephone"],
            ],
            "serviceUpdate" => [
                "ipStatic" => 0,
                "ip" => "", //ToDo
                "subnet" => $persian_subnet, //ToDo
                "bandwidth" => $userinfo[0]["bandWidth"], //ToDo
                "ownershipType" => $userinfo[0]["noe_malekiat"],
                "startDate" => $userinfo[0]["start_service"],
                "endDate" => $userinfo[0]["end_service"],
                "province" => $userinfo[0]["codeOstan"],
            ],
            "resellerCode" => (string) $userinfo[0]["branch_id"],
            "requestId" => $request_id,
            "response" => 200,

        ];
        if ($data) {
            return $data;
        }
    }

    public static function updateAdslRealKhareji($userinfo, $request_id)
    {
        if (empty($userinfo[0]["shomare_shenasname"])) {
            $userinfo[0]["shomare_shenasname"] = "0";
        }
        $shamsi_start_serv = self::shamsidate($userinfo[0]["start_service"]);
        $userinfo[0]["start_service"] = $shamsi_start_serv;
        $shamsi_end_serv = self::shamsidate($userinfo[0]["end_service"]);
        $userinfo[0]["end_service"] = $shamsi_end_serv;
        $persian_subnet = Helper::convert_numbers("255.255.255.0");
        $birth_date_miladi = str_replace('-', '', $userinfo[0]["tarikhe_tavalod"]);
        $userinfo[0]["tarikhe_tavalod"] = $birth_date_miladi;
        $data = [
            //شماره کلاسه معتبر
            "id" => "",
            //شماره مشخصه سرویس
            "serviceNumber" => $userinfo[0]["telephone"],
            "customerUpdate" => [
                "name" => $userinfo[0]["name"],
                "gender" => $userinfo[0]["jensiat"],
                "family" => $userinfo[0]["f_name"],
                "fatherName" => $userinfo[0]["name_pedar"],
                "nationality" => $userinfo[0]["codeCountry"],
                "birthDate" => $userinfo[0]["tarikhe_tavalod"],
                "birthPlace" => $userinfo[0]["shahre_tavalod"],
                "email" => $userinfo[0]["email"],
                "mobile" => $userinfo[0]["telephone_hamrah"],
            ],
            "addressUpdate" => [
                "address" => $userinfo[0]["address"],
                "postalCode" => $userinfo[0]["code_posti"],
                "tel" => $userinfo[0]["telephone"],
            ],
            "serviceUpdate" => [
                "ipStatic" => 0, //ToDo//ToDo
                "ip" => "", //ToDo//ToDo
                "subnet" => $persian_subnet, //ToDo//ToDo
                "bandwidth" => $userinfo[0]["bandWidth"],
                "ownershipType" => $userinfo[0]["noe_malekiat"],
                "startDate" => $userinfo[0]["start_service"],
                "endDate" => $userinfo[0]["end_service"],
                "province" => $userinfo[0]["codeOstan"],
            ],
            "resellerCode" => (string) $userinfo[0]["branch_id"],
            "requestId" => $request_id,
            "response" => 200,
        ];
        if ($data) {
            return $data;
        }
    }

    public static function updateAdslLegalIrani($userinfo, $request_id)
    {
        if (empty($userinfo[0]["shomare_shenasname"])) {
            $userinfo[0]["shomare_shenasname"] = "0";
        }
        $shamsi_birth = self::shamsidate($userinfo[0]["tarikhe_tavalod"]);
        $shamsiRegister = self::shamsidate($userinfo[0]["tarikhe_sabte_sherkat"]);
        $shamsi_start_serv = self::shamsidate($userinfo[0]["start_service"]);
        $userinfo[0]["start_service"] = $shamsi_start_serv;
        $shamsi_end_serv = self::shamsidate($userinfo[0]["end_service"]);
        $userinfo[0]["end_service"] = $shamsi_end_serv;
        $persian_subnet = Helper::convert_numbers("255.255.255.0");
        if ($userinfo[0]['isirani'] === 1) {
            $userinfo[0]["tarikhe_tavalod"] = $shamsi_birth;
            $userinfo[0]["tarikhe_sabte_sherkat"] = $shamsiRegister;
            $userinfo[0]["codeCountry"] = "0";
        } else {
            $userinfo[0]["shomare_shenasname"] = "0";
            $birth_date_miladi = str_replace('-', '', $userinfo[0]["tarikhe_tavalod"]);
            $userinfo[0]["tarikhe_tavalod"] = $birth_date_miladi;
            $registrationDateMiladi = str_replace('-', '', $userinfo[0]["tarikhe_sabte_sherkat"]);
            $userinfo[0]["tarikhe_sabte_sherkat"] = $registrationDateMiladi;
        }

        $data = [
            "id" => "",
            //شماره مشخصه سرویس
            "serviceNumber" => $userinfo[0]["telephone"],
            "customerUpdate" => [
                "companyName" => $userinfo[0]["name_sherkat"],
                "registrationDate" => $userinfo[0]["tarikhe_sabte_sherkat"],
                "mobile" => $userinfo[0]["telephone_hamrahe_sherkat"],
                "registrationNo" => $userinfo[0]["shomare_sabt"],
                "companyType" => $userinfo[0]["companyType"],
                "email" => $userinfo[0]["email"],
                "agentFirstName" => $userinfo[0]["name"],
                "agentLastName" => $userinfo[0]["f_name"],
                "agentFatherName" => $userinfo[0]["name_pedar"],
                "agentIdentificationNo" => $userinfo[0]["code_meli"],
                "agentNationality" => $userinfo[0]["codeCountry"],
                "agentBirthDate" => $userinfo[0]["tarikhe_tavalod"],
                "agentBirthCertificateNo" => $userinfo[0]["shomare_shenasname"],
                "agentIdentificationType" => $userinfo[0]["noe_shenase_hoviati"],
                "agentMobile" => $userinfo[0]["telephone_hamrah"],
            ],
            "addressUpdate" => [
                "address" => $userinfo[0]["address"],
                "postalCode" => $userinfo[0]["code_posti"],
                "tel" => $userinfo[0]["telephone"],
            ],
            "serviceUpdate" => [
                "ipStatic" => 0, //ToDo
                "ip" => "", //ToDo
                "subnet" => $persian_subnet, //ToDo
                "bandwidth" => $userinfo[0]["bandWidth"],
                "ownershipType" => $userinfo[0]["noe_malekiat"],
                "startDate" => $userinfo[0]["start_service"],
                "endDate" => $userinfo[0]["end_service"],
                "province" => $userinfo[0]["codeOstan"],
            ],
            "resellerCode" => (string) $userinfo[0]["branch_id"],
            "requestId" => $request_id,
            "response" => 200,
        ];
        if ($data) {
            return $data;
        }
    }

    public static function updateAdslLegalKhareji($userinfo, $request_id)
    {
        if (empty($userinfo[0]["shomare_shenasname"])) {
            $userinfo[0]["shomare_shenasname"] = "0";
        }
        $shamsi_birth = self::shamsidate($userinfo[0]["tarikhe_tavalod"]);
        $shamsiRegister = self::shamsidate($userinfo[0]["tarikhe_sabte_sherkat"]);
        $shamsi_start_serv = self::shamsidate($userinfo[0]["start_service"]);
        $userinfo[0]["start_service"] = $shamsi_start_serv;
        $shamsi_end_serv = self::shamsidate($userinfo[0]["end_service"]);
        $userinfo[0]["end_service"] = $shamsi_end_serv;
        $persian_subnet = Helper::convert_numbers("255.255.255.0");
        if ($userinfo[0]['isirani'] === 1) {
            $userinfo[0]["tarikhe_tavalod"] = $shamsi_birth;
            $userinfo[0]["tarikhe_sabte_sherkat"] = $shamsiRegister;
            $userinfo[0]["codeCountry"] = "0";
        } else {
            $userinfo[0]["shomare_shenasname"] = "0";
            $birth_date_miladi = str_replace('-', '', $userinfo[0]["tarikhe_tavalod"]);
            $userinfo[0]["tarikhe_tavalod"] = $birth_date_miladi;
            $registrationDateMiladi = str_replace('-', '', $userinfo[0]["tarikhe_sabte_sherkat"]);
            $userinfo[0]["tarikhe_sabte_sherkat"] = $registrationDateMiladi;
        }
        $data = [
            "id" => "",
            //شماره مشخصه سرویس
            "serviceNumber" => $userinfo[0]["telephone"],
            "customerUpdate" => [
                "companyName" => $userinfo[0]["name_sherkat"],
                "registrationDate" => $userinfo[0]["tarikhe_sabte_sherkat"],
                "nationality" => $userinfo[0]["codeCountry"],
                "companyType" => $userinfo[0]["companyType"],
                "registrationNo" => $userinfo[0]["shomare_sabt"],
                "mobile" => $userinfo[0]["telephone_hamrahe_sherkat"],
                "email" => $userinfo[0]["email"],
                "agentFirstName" => $userinfo[0]["name"],
                "agentLastName" => $userinfo[0]["f_name"],
                "agentFatherName" => $userinfo[0]["name_pedar"],
                "agentIdentificationType" => $userinfo[0]["noe_shenase_hoviati"],
                "agentIdentificationNo" => $userinfo[0]["code_meli"],
                "agentNationality" => $userinfo[0]["codeCountry"],
                "agentBirthDate" => $userinfo[0]["tarikhe_tavalod"],
                "agentBirthCertificateNo" => $userinfo[0]["shomare_shenasname"],
                "agentMobile" => $userinfo[0]["telephone_hamrah"],
            ],
            "addressUpdate" => [
                "address" => $userinfo[0]["address"],
                "postalCode" => $userinfo[0]["code_posti"],
                "tel" => $userinfo[0]["telephone"],
            ],
            "serviceUpdate" => [
                "ipStatic" => 0, //ToDo
                "ip" => "", //ToDo
                "subnet" => $persian_subnet, //ToDo
                "bandwidth" => $userinfo[0]["bandWidth"],
                "ownershipType" => $userinfo[0]["noe_malekiat"],
                "startDate" => $userinfo[0]["start_service"],
                "endDate" => $userinfo[0]["end_service"],
                "province" => $userinfo[0]["codeOstan"],
            ],
            "resellerCode" => (string) $userinfo[0]["branch_id"],
            "requestId" => $request_id,
            "response" => 200,
        ];
        if ($data) {
            return $data;
        }
    }
//end update data

//adsl Transfer Data
    public static function transferAdslRealIrani($userinfo, $request_id)
    {
        if (empty($userinfo[0]["shomare_shenasname"])) {
            $userinfo[0]["shomare_shenasname"] = "0";
        }
        $shamsi_birth = self::shamsidate($userinfo[0]["tarikhe_tavalod"]);
        if ($userinfo[0]['isirani'] === 1) {
            $userinfo[0]["tarikhe_tavalod"] = $shamsi_birth;
        }
        $data = [
            //شماره کلاسه معتبر
            "id" => "",
            //شماره مشخصه سرویس
            "serviceNumber" => $userinfo[0]["telephone"],
            "transfer" => 1,
            "transferRequest" => [
                "name" => $userinfo[0]["name"],
                "family" => $userinfo[0]["f_name"],
                "fatherName" => $userinfo[0]["name_pedar"],
                "certificateNo" => $userinfo[0]["shomare_shenasname"],
                "iranian" => $userinfo[0]["isirani"],
                "identificationType" => $userinfo[0]["noe_shenase_hoviati"],
                "birthDate" => $userinfo[0]["tarikhe_tavalod"],
                "identificationNo" => $userinfo[0]["code_meli"],
                "birthPlace" => $userinfo[0]["shahre_tavalod"],
                "mobile" => $userinfo[0]["telephone_hamrah"],
                "email" => $userinfo[0]["email"],
                "gender" => $userinfo[0]["jensiat"],
                "person" => 1,
                "address" => [
                    "address" => $userinfo[0]["address"],
                    "postalCode" => $userinfo[0]["code_posti"],
                    "tel" => $userinfo[0]["telephone"],
                ],
            ],
            "resellerCode" => (string) $userinfo[0]["branch_id"],
            "requestId" => $request_id,
            "response" => 200,
        ];
        return $data;
    }

    public static function transferAdslRealKhareji($userinfo, $request_id)
    {
        if (empty($userinfo[0]["shomare_shenasname"])) {
            $userinfo[0]["shomare_shenasname"] = "0";
        }
        $birth_date_miladi = str_replace('-', '', $userinfo[0]["tarikhe_tavalod"]);
        $userinfo[0]["tarikhe_tavalod"] = $birth_date_miladi;
        $data = [
            //شماره کلاسه معتبر
            "id" => "", //ToDo
            //شماره مشخصه سرویس
            "serviceNumber" => $userinfo[0]["telephone"],
            "transfer" => 1,
            "transferRequest" => [
                "person" => 1,
                "name" => $userinfo[0]["name"],
                "family" => $userinfo[0]["f_name"],
                "fatherName" => $userinfo[0]["name_pedar"],
                "iranian" => $userinfo[0]["isirani"],
                "nationality" => $userinfo[0]["codeCountry"],
                "identificationType" => $userinfo[0]["noe_shenase_hoviati"],
                "birthDate" => $userinfo[0]["tarikhe_tavalod"],
                "identificationNo" => $userinfo[0]["code_meli"],
                "birthPlace" => $userinfo[0]["shahre_tavalod"],
                "mobile" => $userinfo[0]["telephone_hamrah"],
                "email" => $userinfo[0]["email"],
                "gender" => $userinfo[0]["jensiat"],
                "address" => [
                    "address" => $userinfo[0]["address"],
                    "postalCode" => $userinfo[0]["code_posti"],
                    "tel" => $userinfo[0]["telephone"],
                ],
            ],
            "resellerCode" => (string) $userinfo[0]["branch_id"],
            "requestId" => $request_id,
            "response" => 200,
        ];
        return $data;
    }

    public static function transferAdslLegalIrani($userinfo, $request_id)
    {
        if (empty($userinfo[0]["shomare_shenasname"])) {
            $userinfo[0]["shomare_shenasname"] = "0";
        }
        $shamsi_birth = self::shamsidate($userinfo[0]["tarikhe_tavalod"]);
        $shamsiRegister = self::shamsidate($userinfo[0]["tarikhe_sabte_sherkat"]);
        if ($userinfo[0]['isirani'] === 1) {
            $userinfo[0]["tarikhe_tavalod"] = $shamsi_birth;
            $userinfo[0]["tarikhe_sabte_sherkat"] = $shamsiRegister;
            $userinfo[0]["codeCountry"] = "0";
        } else {
            $userinfo[0]["shomare_shenasname"] = "0";
            $birth_date_miladi = str_replace('-', '', $userinfo[0]["tarikhe_tavalod"]);
            $userinfo[0]["tarikhe_tavalod"] = $birth_date_miladi;
            $registrationDateMiladi = str_replace('-', '', $userinfo[0]["tarikhe_sabte_sherkat"]);
            $userinfo[0]["tarikhe_sabte_sherkat"] = $registrationDateMiladi;
        }

        $data = [
            //شماره کلاسه معتبر
            "id" => "",
            //شماره مشخصه سرویس
            "serviceNumber" => $userinfo[0]["telephone"],
            "transfer" => 1,
            "transferRequest" => [
                "person" => 0,
                "companyName" => $userinfo[0]["name_sherkat"],
                "iranian" => $userinfo[0]["isirani"],
                "identificationType" => $userinfo[0]["noe_shenase_hoviati_sherkat"],
                "registrationDate" => $userinfo[0]["tarikhe_sabte_sherkat"],
                "mobile" => $userinfo[0]["telephone_hamrahe_sherkat"],
                "identificationNo" => $userinfo[0]["shenase_meli"],
                "registrationNo" => $userinfo[0]["shomare_sabt"],
                "companyType" => $userinfo[0]["companyType"],
                "email" => $userinfo[0]["email"],
                "agentFirstName" => $userinfo[0]["name"],
                "agentLastName" => $userinfo[0]["f_name"],
                "agentFatherName" => $userinfo[0]["name_pedar"],
                "agentIdentificationNo" => $userinfo[0]["code_meli"],
                "agentNationality" => $userinfo[0]["codeCountry"],
                "agentBirthDate" => $userinfo[0]["tarikhe_tavalod"],
                "agentBirthCertificateNo" => $userinfo[0]["shomare_shenasname"],
                "agentIdentificationType" => $userinfo[0]["noe_shenase_hoviati"],
                "agentMobile" => $userinfo[0]["telephone_hamrah"],
                "address" => [
                    "address" => $userinfo[0]["address"],
                    "postalCode" => $userinfo[0]["code_posti"],
                    "tel" => $userinfo[0]["telephone"],
                ],
            ],
            "resellerCode" => (string) $userinfo[0]["branch_id"],
            "requestId" => $request_id,
            "response" => 200,
        ];
        if ($data) {
            return $data;
        }
    }

    public static function transferAdslLegalKhareji($userinfo, $request_id)
    {
        if (empty($userinfo[0]["shomare_shenasname"])) {
            $userinfo[0]["shomare_shenasname"] = "0";
        }
        $shamsi_birth = self::shamsidate($userinfo[0]["tarikhe_tavalod"]);
        $shamsiRegister = self::shamsidate($userinfo[0]["tarikhe_sabte_sherkat"]);
        if ($userinfo[0]['isirani'] === 1) {
            $userinfo[0]["tarikhe_tavalod"] = $shamsi_birth;
            $userinfo[0]["tarikhe_sabte_sherkat"] = $shamsiRegister;
            $userinfo[0]["codeCountry"] = "0";
        } else {
            $userinfo[0]["shomare_shenasname"] = "0";
            $birth_date_miladi = str_replace('-', '', $userinfo[0]["tarikhe_tavalod"]);
            $userinfo[0]["tarikhe_tavalod"] = $birth_date_miladi;
            $registrationDateMiladi = str_replace('-', '', $userinfo[0]["tarikhe_sabte_sherkat"]);
            $userinfo[0]["tarikhe_sabte_sherkat"] = $registrationDateMiladi;
        }

        $data = [
            //شماره کلاسه معتبر
            "id" => "", //ToDo
            //شماره مشخصه سرویس
            "serviceNumber" => $userinfo[0]["telephone"],
            "transfer" => 1,
            "transferRequest" => [
                "person" => 0,
                "companyName" => $userinfo[0]["name_sherkat"],
                "iranian" => $userinfo[0]["isirani"],
                "identificationType" => $userinfo[0]["noe_shenase_hoviati_sherkat"],
                "registrationDate" => $userinfo[0]["tarikhe_sabte_sherkat"],
                "identificationNo" => $userinfo[0]["shenase_meli"],
                "registrationNo" => $userinfo[0]["shomare_sabt"],
                "companyType" => $userinfo[0]["companyType"],
                "mobile" => $userinfo[0]["telephone_hamrahe_sherkat"],
                "email" => $userinfo[0]["email"],
                "agentFirstName" => $userinfo[0]["name"],
                "agentLastName" => $userinfo[0]["f_name"],
                "agentFatherName" => $userinfo[0]["name_pedar"],
                "agentIdentificationNo" => $userinfo[0]["code_meli"],
                "agentNationality" => $userinfo[0]["codeCountry"],
                "agentBirthDate" => $userinfo[0]["tarikhe_tavalod"],
                "agentBirthCertificateNo" => $userinfo[0]["shomare_shenasname"],
                "agentIdentificationType" => $userinfo[0]["noe_shenase_hoviati"],
                "agentMobile" => $userinfo[0]["telephone_hamrah"],
                "nationality" => $userinfo[0]["codeCountry"],
                "address" => [
                    "address" => $userinfo[0]["address"],
                    "postalCode" => $userinfo[0]["code_posti"],
                    "tel" => $userinfo[0]["telephone"],
                ],
            ],
            "resellerCode" => (string) $userinfo[0]["branch_id"],
            "requestId" => $request_id,
            "response" => 200,
        ];

        if ($data) {
            return $data;
        }
    }

//delete adsl data
    public static function deleteAdsl($userinfo, $request_id)
    {
        $data = [
            "requestId" => $request_id,
            "id" => "", //ToDo
            "resellerCode" => (string) $userinfo[0]["branch_id"],
            "serviceNumber" => $userinfo[0]["telephone"],
            "response" => 200,
        ];
        if ($data) {
            return $data;
        }
    }
//end delete data

//close wireless services
    public static function closeAdslServices($userinfo, $request_id)
    {
        $data = [
            "requestId" => $request_id,
            "id" => "", //ToDo
            "serviceNumber" => $userinfo[0]["telephone"],
            "resellerCode" => (string) $userinfo[0]["branch_id"],
            "close" => 1,
            "response" => 200,
        ];
        if ($data) {
            return $data;
        }
    }

//voip information
//voip Put Data
    public static function putVoipRealIrani($userinfo, $request_id)
    {
        if (empty($userinfo[0]["shomare_shenasname"])) {
            $userinfo[0]["shomare_shenasname"] = "0";
        }
        $shamsi_birth = self::shamsidate($userinfo[0]["tarikhe_tavalod"]);
        $shamsi_start_serv = self::shamsidate($userinfo[0]["start_service"]);
        $userinfo[0]["start_service"] = $shamsi_start_serv;
        $shamsi_end_serv = self::shamsidate($userinfo[0]["end_service"]);
        $userinfo[0]["end_service"] = $shamsi_end_serv;
        $persian_subnet = Helper::convert_numbers("255.255.255.0");
        if ($userinfo[0]['isirani'] === 1) {
            $userinfo[0]["tarikhe_tavalod"] = $shamsi_birth;
        }
        $data = [
            "person" => 1,
            "name" => $userinfo[0]["name"],
            "gender" => $userinfo[0]["jensiat"],
            "family" => $userinfo[0]["f_name"],
            "fatherName" => $userinfo[0]["name_pedar"],
            "certificateNo" => $userinfo[0]["shomare_shenasname"],
            "iranian" => $userinfo[0]["isirani"],
            "identificationType" => $userinfo[0]["noe_shenase_hoviati"],
            "birthDate" => $userinfo[0]["tarikhe_tavalod"],
            "identificationNo" => $userinfo[0]["code_meli"],
            "birthPlace" => $userinfo[0]["shahre_tavalod"],
            "address" => [
                "address" => $userinfo[0]["address"],
                "postalCode" => $userinfo[0]["code_posti"],
                "tel" => $userinfo[0]["telephone"],
            ],
            "mobile" => $userinfo[0]["telephone_hamrah"],
            "email" => $userinfo[0]["email"],
            "resellerCode" => (string) $userinfo[0]["branch_id"],
            "requestId" => $request_id,
            "service" => [
                "type" => 17,
                "phoneNumber" => $userinfo[0]["telephone"],
                "province" => $userinfo[0]["codeOstan"],
                "county" => "testy", //ToDo
                "status" => $userinfo[0]["disable_shode"],
                "credit" => 1,
                "general" => 0,
                "ipStatic" => 0,
                "ip" => "",
                "subnet" => $persian_subnet,
                "provincial/country" => 0,
            ],
            "response" => 200,
        ];
        return $data;
    }

    public static function putVoipRealKhareji($userinfo, $request_id)
    {
        if (empty($userinfo[0]["shomare_shenasname"])) {
            $userinfo[0]["shomare_shenasname"] = "0";
        }
        $shamsi_start_serv = self::shamsidate($userinfo[0]["start_service"]);
        $userinfo[0]["start_service"] = $shamsi_start_serv;
        $shamsi_end_serv = self::shamsidate($userinfo[0]["end_service"]);
        $userinfo[0]["end_service"] = $shamsi_end_serv;
        $persian_subnet = Helper::convert_numbers("255.255.255.0");
        $birth_date_miladi = str_replace('-', '', $userinfo[0]["tarikhe_tavalod"]);
        $userinfo[0]["tarikhe_tavalod"] = $birth_date_miladi;
        $data = [
            "person" => 1,
            "name" => $userinfo[0]["name"],
            "gender" => $userinfo[0]["jensiat"],
            "family" => $userinfo[0]["f_name"],
            "fatherName" => $userinfo[0]["name_pedar"],
            "iranian" => $userinfo[0]["isirani"],
            "nationality" => $userinfo[0]["codeCountry"],
            "identificationType" => $userinfo[0]["noe_shenase_hoviati"],
            "birthDate" => $userinfo[0]["tarikhe_tavalod"],
            "identificationNo" => $userinfo[0]["code_meli"],
            "universalNo" => "", //felan nadarim
            "birthPlace" => $userinfo[0]["shahre_tavalod"],
            "mobile" => $userinfo[0]["telephone_hamrah"],
            "email" => $userinfo[0]["email"],
            "resellerCode" => (string) $userinfo[0]["branch_id"],
            "requestId" => $request_id,
            "address" => [
                "address" => $userinfo[0]["address"],
                "postalCode" => $userinfo[0]["code_posti"],
                "tel" => $userinfo[0]["telephone"],
            ],
            "service" => [
                "type" => 17,
                "phoneNumber" => $userinfo[0]["telephone"],
                "province" => $userinfo[0]["codeOstan"],
                "county" => "testy", //ToDo
                "status" => $userinfo[0]["disable_shode"],
                "credit" => 1,
                "general" => 0,
                "ipStatic" => 0, //ToDo
                "ip" => "", //ToDo
                "subnet" => $persian_subnet, //ToDo
                "provincial/country" => 0,
            ],
            "response" => 200,
        ];
        return $data;
    }

    public static function putVoipLegalIrani($userinfo, $request_id)
    {
        if (empty($userinfo[0]["shomare_shenasname"])) {
            $userinfo[0]["shomare_shenasname"] = "0";
        }
        $shamsi_birth = self::shamsidate($userinfo[0]["tarikhe_tavalod"]);
        $shamsiRegister = self::shamsidate($userinfo[0]["tarikhe_sabte_sherkat"]);
        $shamsi_start_serv = self::shamsidate($userinfo[0]["start_service"]);
        $userinfo[0]["start_service"] = $shamsi_start_serv;
        $shamsi_end_serv = self::shamsidate($userinfo[0]["end_service"]);
        $userinfo[0]["end_service"] = $shamsi_end_serv;
        $persian_subnet = Helper::convert_numbers("255.255.255.0");
        if ($userinfo[0]['isirani'] === 1) {
            $userinfo[0]["tarikhe_tavalod"] = $shamsi_birth;
            $userinfo[0]["tarikhe_sabte_sherkat"] = $shamsiRegister;
            $userinfo[0]["codeCountry"] = "0";
        } else {
            $userinfo[0]["shomare_shenasname"] = "0";
            $birth_date_miladi = str_replace('-', '', $userinfo[0]["tarikhe_tavalod"]);
            $userinfo[0]["tarikhe_tavalod"] = $birth_date_miladi;
            $registrationDateMiladi = str_replace('-', '', $userinfo[0]["tarikhe_sabte_sherkat"]);
            $userinfo[0]["tarikhe_sabte_sherkat"] = $registrationDateMiladi;
        }

        $data = [
            "person" => 0,
            "companyName" => $userinfo[0]["name_sherkat"],
            "iranian" => $userinfo[0]["isirani"],
            "identificationType" => $userinfo[0]["noe_shenase_hoviati_sherkat"],
            "registrationDate" => $userinfo[0]["tarikhe_sabte_sherkat"],
            "identificationNo" => $userinfo[0]["shenase_meli"],
            "companyType" => $userinfo[0]["companyType"],
            "registrationNo" => $userinfo[0]["shomare_sabt"],
            "mobile" => $userinfo[0]["telephone_hamrahe_sherkat"],
            "email" => $userinfo[0]["email"],
            "address" => [
                "address" => $userinfo[0]["address"],
                "postalCode" => $userinfo[0]["code_posti"],
                "tel" => $userinfo[0]["telephone"],
            ],
            "agentFirstName" => $userinfo[0]["name"],
            "agentLastName" => $userinfo[0]["f_name"],
            "agentFatherName" => $userinfo[0]["name_pedar"],
            "agentIdentificationType" => $userinfo[0]["noe_shenase_hoviati"],
            "agentIdentificationNo" => $userinfo[0]["code_meli"],
            "agentNationality" => $userinfo[0]["codeCountry"],
            "agentBirthDate" => $userinfo[0]["tarikhe_tavalod"],
            "agentBirthCertificateNo" => $userinfo[0]["shomare_shenasname"],
            "agentMobile" => $userinfo[0]["telephone_hamrah"],
            "resellerCode" => (string) $userinfo[0]["branch_id"],
            "requestId" => $request_id,
            "service" => [
                "type" => 17,
                "phoneNumber" => $userinfo[0]["telephone"],
                "province" => $userinfo[0]["codeOstan"],
                "county" => "testy", //ToDo
                "status" => $userinfo[0]["disable_shode"],
                "credit" => 1,
                "general" => 0,
                "ipStatic" => 0, //ToDo
                "ip" => "", //ToDo
                "subnet" => $persian_subnet,
                "provincial/country" => 0,
            ],
            "response" => 200,
        ];
        if ($data) {
            return $data;
        }
    }

    public static function putVoipLegalKhareji($userinfo, $request_id)
    {
        if (empty($userinfo[0]["shomare_shenasname"])) {
            $userinfo[0]["shomare_shenasname"] = "0";
        }
        $shamsi_birth = self::shamsidate($userinfo[0]["tarikhe_tavalod"]);
        $shamsiRegister = self::shamsidate($userinfo[0]["tarikhe_sabte_sherkat"]);
        $shamsi_start_serv = self::shamsidate($userinfo[0]["start_service"]);
        $userinfo[0]["start_service"] = $shamsi_start_serv;
        $shamsi_end_serv = self::shamsidate($userinfo[0]["end_service"]);
        $userinfo[0]["end_service"] = $shamsi_end_serv;
        $persian_subnet = Helper::convert_numbers("255.255.255.0");
        if ($userinfo[0]['isirani'] === 1) {
            $userinfo[0]["tarikhe_tavalod"] = $shamsi_birth;
            $userinfo[0]["tarikhe_sabte_sherkat"] = $shamsiRegister;
            $userinfo[0]["codeCountry"] = "0";
        } else {
            $userinfo[0]["shomare_shenasname"] = "0";
            $birth_date_miladi = str_replace('-', '', $userinfo[0]["tarikhe_tavalod"]);
            $userinfo[0]["tarikhe_tavalod"] = $birth_date_miladi;
            $registrationDateMiladi = str_replace('-', '', $userinfo[0]["tarikhe_sabte_sherkat"]);
            $userinfo[0]["tarikhe_sabte_sherkat"] = $registrationDateMiladi;
        }

        $data = [
            "person" => 0,
            "companyName" => $userinfo[0]["name_sherkat"],
            "iranian" => $userinfo[0]["isirani"],
            "identificationType" => $userinfo[0]["noe_shenase_hoviati_sherkat"],
            "registrationDate" => $userinfo[0]["tarikhe_sabte_sherkat"],
            "identificationNo" => $userinfo[0]["shenase_meli"],
            "companyType" => $userinfo[0]["companyType"],
            "registrationNo" => $userinfo[0]["shomare_sabt"],
            "address" => [
                "address" => $userinfo[0]["address"],
                "postalCode" => $userinfo[0]["code_posti"],
                "tel" => $userinfo[0]["telephone"],
            ],
            "mobile" => $userinfo[0]["telephone_hamrahe_sherkat"],
            "email" => $userinfo[0]["email"],
            "agentFirstName" => $userinfo[0]["name"],
            "agentLastName" => $userinfo[0]["f_name"],
            "agentFatherName" => $userinfo[0]["name_pedar"],
            "agentIdentificationType" => $userinfo[0]["noe_shenase_hoviati"],
            "agentIdentificationNo" => $userinfo[0]["code_meli"],
            "agentNationality" => $userinfo[0]["codeCountry"],
            "agentBirthDate" => $userinfo[0]["tarikhe_tavalod"],
            "agentBirthCertificateNo" => $userinfo[0]["shomare_shenasname"],
            "agentMobile" => $userinfo[0]["telephone_hamrah"],
            "resellerCode" => (string) $userinfo[0]["branch_id"],
            "requestId" => $request_id,
            "nationality" => $userinfo[0]["codeCountry"],
            "service" => [
                "type" => 17,
                "phoneNumber" => $userinfo[0]["telephone"],
                "province" => $userinfo[0]["codeOstan"],
                "county" => "testy", //ToDo
                "status" => $userinfo[0]["disable_shode"],
                "credit" => 1,
                "general" => 0,
                "ipStatic" => 0, //ToDo
                "ip" => "", //ToDo
                "subnet" => "", //ToDo
                "provincial/country" => 0,
            ],
            "response" => 200,
        ];

        if ($data) {
            return $data;
        }
    }

//voip Update Data
    public static function updateVoipRealIrani($userinfo, $request_id)
    {
        if (empty($userinfo[0]["shomare_shenasname"])) {
            $userinfo[0]["shomare_shenasname"] = "0";
        }
        $shamsi_birth = self::shamsidate($userinfo[0]["tarikhe_tavalod"]);
        $shamsi_start_serv = self::shamsidate($userinfo[0]["start_service"]);
        $userinfo[0]["start_service"] = $shamsi_start_serv;
        $shamsi_end_serv = self::shamsidate($userinfo[0]["end_service"]);
        $userinfo[0]["end_service"] = $shamsi_end_serv;
        $persian_subnet = Helper::convert_numbers("255.255.255.0");
        if ($userinfo[0]['isirani'] === 1) {
            $userinfo[0]["tarikhe_tavalod"] = $shamsi_birth;
        }
        $data = [
            //شماره کلاسه معتبر
            "id" => "",
            //شماره مشخصه سرویس
            "serviceNumber" => $userinfo[0]["telephone"],
            "customerUpdate" => [
                "name" => $userinfo[0]["name"],
                "gender" => $userinfo[0]["jensiat"],
                "family" => $userinfo[0]["f_name"],
                "fatherName" => $userinfo[0]["name_pedar"],
                "birthDate" => $userinfo[0]["tarikhe_tavalod"],
                "birthPlace" => $userinfo[0]["shahre_tavalod"],
                "mobile" => $userinfo[0]["telephone_hamrah"],
                "email" => $userinfo[0]["email"],
            ],
            "addressUpdate" => [
                "address" => $userinfo[0]["address"],
                "postalCode" => $userinfo[0]["code_posti"],
                "tel" => $userinfo[0]["telephone"],
            ],
            "resellerCode" => (string) $userinfo[0]["branch_id"],
            "requestId" => $request_id,
            "serviceUpdate" => [
                "province" => $userinfo[0]["codeOstan"],
                "county" => "testy", //ToDo
                "status" => $userinfo[0]["disable_shode"],
                "credit" => 1,
                "ipStatic" => 0, //ToDo
                "ip" => "", //ToDo
                "subnet" => $persian_subnet, //ToDo
                "provincial/country" => 0,
            ],
            "response" => 200,
        ];
        return $data;
    }

    public static function updateVoipRealKhareji($userinfo, $request_id)
    {
        if (empty($userinfo[0]["shomare_shenasname"])) {
            $userinfo[0]["shomare_shenasname"] = "0";
        }
        $shamsi_start_serv = self::shamsidate($userinfo[0]["start_service"]);
        $userinfo[0]["start_service"] = $shamsi_start_serv;
        $shamsi_end_serv = self::shamsidate($userinfo[0]["end_service"]);
        $userinfo[0]["end_service"] = $shamsi_end_serv;
        $persian_subnet = Helper::convert_numbers("255.255.255.0");
        $birth_date_miladi = str_replace('-', '', $userinfo[0]["tarikhe_tavalod"]);
        $userinfo[0]["tarikhe_tavalod"] = $birth_date_miladi;
        $data = [
            //شماره کلاسه معتبر
            "id" => "",
            //شماره مشخصه سرویس
            "serviceNumber" => $userinfo[0]["telephone"],
            "customerUpdate" => [
                "name" => $userinfo[0]["name"],
                "gender" => $userinfo[0]["jensiat"],
                "family" => $userinfo[0]["f_name"],
                "fatherName" => $userinfo[0]["name_pedar"],
                "nationality" => $userinfo[0]["codeCountry"],
                "birthDate" => $userinfo[0]["tarikhe_tavalod"],
                "birthPlace" => $userinfo[0]["shahre_tavalod"],
                "mobile" => $userinfo[0]["telephone_hamrah"],
                "email" => $userinfo[0]["email"],
            ],
            "resellerCode" => (string) $userinfo[0]["branch_id"],
            "requestId" => $request_id,
            "addressUpdate" => [
                "address" => $userinfo[0]["address"],
                "postalCode" => $userinfo[0]["code_posti"],
                "tel" => $userinfo[0]["telephone"],
            ],
            "serviceUpdate" => [
                "province" => $userinfo[0]["codeOstan"],
                "county" => "testy", //ToDo
                "status" => $userinfo[0]["disable_shode"],
                "credit" => 1,
                "ipStatic" => 0, //ToDo
                "ip" => "", //ToDo
                "subnet" => $persian_subnet, //ToDo
                "provincial/country" => 0,
            ],
            "response" => 200,
        ];
        return $data;
    }

    public static function updateVoipLegalIrani($userinfo, $request_id)
    {
        if (empty($userinfo[0]["shomare_shenasname"])) {
            $userinfo[0]["shomare_shenasname"] = "0";
        }
        $shamsi_birth = self::shamsidate($userinfo[0]["tarikhe_tavalod"]);
        $shamsiRegister = self::shamsidate($userinfo[0]["tarikhe_sabte_sherkat"]);
        $shamsi_start_serv = self::shamsidate($userinfo[0]["start_service"]);
        $userinfo[0]["start_service"] = $shamsi_start_serv;
        $shamsi_end_serv = self::shamsidate($userinfo[0]["end_service"]);
        $userinfo[0]["end_service"] = $shamsi_end_serv;
        $persian_subnet = Helper::convert_numbers("255.255.255.0");
        if ($userinfo[0]['isirani'] === 1) {
            $userinfo[0]["tarikhe_tavalod"] = $shamsi_birth;
            $userinfo[0]["tarikhe_sabte_sherkat"] = $shamsiRegister;
            $userinfo[0]["codeCountry"] = "0";
        } else {
            $userinfo[0]["shomare_shenasname"] = "0";
            $birth_date_miladi = str_replace('-', '', $userinfo[0]["tarikhe_tavalod"]);
            $userinfo[0]["tarikhe_tavalod"] = $birth_date_miladi;
            $registrationDateMiladi = str_replace('-', '', $userinfo[0]["tarikhe_sabte_sherkat"]);
            $userinfo[0]["tarikhe_sabte_sherkat"] = $registrationDateMiladi;
        }

        $data = [
            //شماره کلاسه معتبر
            "id" => "",
            //شماره مشخصه سرویس
            "serviceNumber" => $userinfo[0]["telephone"],
            "customerUpdate" => [
                "companyName" => $userinfo[0]["name_sherkat"],
                "registrationDate" => $userinfo[0]["tarikhe_sabte_sherkat"],
                "companyType" => $userinfo[0]["companyType"],
                "registrationNo" => $userinfo[0]["shomare_sabt"],
                "mobile" => $userinfo[0]["telephone_hamrahe_sherkat"],
                "email" => $userinfo[0]["email"],
                "agentFirstName" => $userinfo[0]["name"],
                "agentLastName" => $userinfo[0]["f_name"],
                "agentFatherName" => $userinfo[0]["name_pedar"],
                "agentIdentificationType" => $userinfo[0]["noe_shenase_hoviati"],
                "agentIdentificationNo" => $userinfo[0]["code_meli"],
                "agentNationality" => $userinfo[0]["codeCountry"],
                "agentBirthDate" => $userinfo[0]["tarikhe_tavalod"],
                "agentBirthCertificateNo" => $userinfo[0]["shomare_shenasname"],
                "agentMobile" => $userinfo[0]["telephone_hamrah"],
            ],
            "addressUpdate" => [
                "address" => $userinfo[0]["address"],
                "postalCode" => $userinfo[0]["code_posti"],
                "tel" => $userinfo[0]["telephone"],
            ],
            "resellerCode" => (string) $userinfo[0]["branch_id"],
            "requestId" => $request_id,
            "serviceUpdate" => [
                "province" => $userinfo[0]["codeOstan"],
                "county" => "testy", //ToDo
                "status" => $userinfo[0]["disable_shode"],
                "credit" => 1,
                "general" => 0,
                "ipStatic" => 0, //ToDo
                "ip" => "", //ToDo
                "subnet" => $persian_subnet, //ToDo
                "provincial/country" => 0,
            ],
            "response" => 200,
        ];
        if ($data) {
            return $data;
        }
    }

    public static function updateVoipLegalKhareji($userinfo, $request_id)
    {
        if (empty($userinfo[0]["shomare_shenasname"])) {
            $userinfo[0]["shomare_shenasname"] = "0";
        }
        $shamsi_birth = self::shamsidate($userinfo[0]["tarikhe_tavalod"]);
        $shamsiRegister = self::shamsidate($userinfo[0]["tarikhe_sabte_sherkat"]);
        $shamsi_start_serv = self::shamsidate($userinfo[0]["start_service"]);
        $userinfo[0]["start_service"] = $shamsi_start_serv;
        $shamsi_end_serv = self::shamsidate($userinfo[0]["end_service"]);
        $userinfo[0]["end_service"] = $shamsi_end_serv;
        $persian_subnet = Helper::convert_numbers("255.255.255.0");
        if ($userinfo[0]['isirani'] === 1) {
            $userinfo[0]["tarikhe_tavalod"] = $shamsi_birth;
            $userinfo[0]["tarikhe_sabte_sherkat"] = $shamsiRegister;
            $userinfo[0]["codeCountry"] = "0";
        } else {
            $userinfo[0]["shomare_shenasname"] = "0";
            $birth_date_miladi = str_replace('-', '', $userinfo[0]["tarikhe_tavalod"]);
            $userinfo[0]["tarikhe_tavalod"] = $birth_date_miladi;
            $registrationDateMiladi = str_replace('-', '', $userinfo[0]["tarikhe_sabte_sherkat"]);
            $userinfo[0]["tarikhe_sabte_sherkat"] = $registrationDateMiladi;
        }

        $data = [
            //شماره کلاسه معتبر
            "id" => "",
            //شماره مشخصه سرویس
            "serviceNumber" => $userinfo[0]["telephone"],
            "customerUpdate" => [
                "companyName" => $userinfo[0]["name_sherkat"],
                "registrationDate" => $userinfo[0]["tarikhe_sabte_sherkat"],
                "nationality" => $userinfo[0]["codeCountry"],
                "companyType" => $userinfo[0]["companyType"],
                "registrationNo" => $userinfo[0]["shomare_sabt"],
                "mobile" => $userinfo[0]["telephone_hamrahe_sherkat"],
                "email" => $userinfo[0]["email"],
                "agentFirstName" => $userinfo[0]["name"],
                "agentLastName" => $userinfo[0]["f_name"],
                "agentFatherName" => $userinfo[0]["name_pedar"],
                "agentIdentificationType" => $userinfo[0]["noe_shenase_hoviati"],
                "agentIdentificationNo" => $userinfo[0]["code_meli"],
                "agentNationality" => $userinfo[0]["codeCountry"],
                "agentBirthDate" => $userinfo[0]["tarikhe_tavalod"],
                "agentBirthCertificateNo" => $userinfo[0]["shomare_shenasname"],
                "agentMobile" => $userinfo[0]["telephone_hamrah"],
            ],
            "addressUpdate" => [
                "address" => $userinfo[0]["address"],
                "postalCode" => $userinfo[0]["code_posti"],
                "tel" => $userinfo[0]["telephone"],
            ],
            "resellerCode" => (string) $userinfo[0]["branch_id"],
            "requestId" => $request_id,
            "serviceUpdate" => [
                "province" => $userinfo[0]["codeOstan"],
                "county" => "testy", //ToDo
                "status" => $userinfo[0]["disable_shode"],
                "credit" => 1,
                "general" => 0,
                "ipStatic" => 0, //ToDo
                "ip" => "", //ToDo
                "subnet" => "", //ToDo
                "provincial/country" => 0,
            ],
            "response" => 200,
        ];
        if ($data) {
            return $data;
        }
    }

    //wireless Transfer Data
    public static function transferVoipRealIrani($userinfo, $request_id)
    {
        if (empty($userinfo[0]["shomare_shenasname"])) {
            $userinfo[0]["shomare_shenasname"] = "0";
        }
        $shamsi_birth = self::shamsidate($userinfo[0]["tarikhe_tavalod"]);
        $shamsi_start_serv = self::shamsidate($userinfo[0]["start_service"]);
        $userinfo[0]["start_service"] = $shamsi_start_serv;
        $shamsi_end_serv = self::shamsidate($userinfo[0]["end_service"]);
        $userinfo[0]["end_service"] = $shamsi_end_serv;
        if ($userinfo[0]['isirani'] === 1) {
            $userinfo[0]["tarikhe_tavalod"] = $shamsi_birth;
        }
        $data = [
            //شماره کلاسه معتبر
            "id" => "",
            //شماره مشخصه سرویس
            "serviceNumber" => $userinfo[0]["telephone"],
            "transfer" => 1,
            "transferRequest" => [
                "person" => 1,
                "name" => $userinfo[0]["name"],
                "gender" => $userinfo[0]["jensiat"],
                "family" => $userinfo[0]["f_name"],
                "fatherName" => $userinfo[0]["name_pedar"],
                "certificateNo" => $userinfo[0]["shomare_shenasname"],
                "iranian" => $userinfo[0]["isirani"],
                "identificationType" => $userinfo[0]["noe_shenase_hoviati"],
                "birthDate" => $userinfo[0]["tarikhe_tavalod"],
                "identificationNo" => $userinfo[0]["code_meli"],
                "birthPlace" => $userinfo[0]["shahre_tavalod"],
                "mobile" => $userinfo[0]["telephone_hamrah"],
                "email" => $userinfo[0]["email"],
                "address" => [
                    "address" => $userinfo[0]["address"],
                    "postalCode" => $userinfo[0]["code_posti"],
                    "tel" => $userinfo[0]["telephone"],
                ],
            ],
            "resellerCode" => (string) $userinfo[0]["branch_id"],
            "requestId" => $request_id,
            "response" => 200,

        ];
        return $data;
    }

    public static function transferVoipRealKhareji($userinfo, $request_id)
    {
        if (empty($userinfo[0]["shomare_shenasname"])) {
            $userinfo[0]["shomare_shenasname"] = "0";
        }
        $birth_date_miladi = str_replace('-', '', $userinfo[0]["tarikhe_tavalod"]);
        $userinfo[0]["tarikhe_tavalod"] = $birth_date_miladi;
        $data = [
            //شماره کلاسه معتبر
            "id" => "",
            //شماره مشخصه سرویس
            "serviceNumber" => $userinfo[0]["telephone"],
            "transfer" => 1,
            "transferRequest" => [
                "person" => 1,
                "name" => $userinfo[0]["name"],
                "gender" => $userinfo[0]["jensiat"],
                "family" => $userinfo[0]["f_name"],
                "fatherName" => $userinfo[0]["name_pedar"],
                "iranian" => $userinfo[0]["isirani"],
                "nationality" => $userinfo[0]["codeCountry"],
                "identificationType" => $userinfo[0]["noe_shenase_hoviati"],
                "birthDate" => $userinfo[0]["tarikhe_tavalod"],
                "identificationNo" => $userinfo[0]["code_meli"],
                "birthPlace" => $userinfo[0]["shahre_tavalod"],
                "mobile" => $userinfo[0]["telephone_hamrah"],
                "email" => $userinfo[0]["email"],
                "address" => [
                    "address" => $userinfo[0]["address"],
                    "postalCode" => $userinfo[0]["code_posti"],
                    "tel" => $userinfo[0]["telephone"],
                ],
            ],
            "resellerCode" => (string) $userinfo[0]["branch_id"],
            "requestId" => $request_id,
            "response" => 200,

        ];
        return $data;
    }

    public static function transferVoipLegalIrani($userinfo, $request_id)
    {
        if (empty($userinfo[0]["shomare_shenasname"])) {
            $userinfo[0]["shomare_shenasname"] = "0";
        }
        $shamsi_birth = self::shamsidate($userinfo[0]["tarikhe_tavalod"]);
        $shamsiRegister = self::shamsidate($userinfo[0]["tarikhe_sabte_sherkat"]);
        if ($userinfo[0]['isirani'] === 1) {
            $userinfo[0]["tarikhe_tavalod"] = $shamsi_birth;
            $userinfo[0]["tarikhe_sabte_sherkat"] = $shamsiRegister;
            $userinfo[0]["codeCountry"] = "0";
        } else {
            $userinfo[0]["shomare_shenasname"] = "0";
            $birth_date_miladi = str_replace('-', '', $userinfo[0]["tarikhe_tavalod"]);
            $userinfo[0]["tarikhe_tavalod"] = $birth_date_miladi;
            $registrationDateMiladi = str_replace('-', '', $userinfo[0]["tarikhe_sabte_sherkat"]);
            $userinfo[0]["tarikhe_sabte_sherkat"] = $registrationDateMiladi;
        }

        $data = [
            //شماره کلاسه معتبر
            "id" => "", //ToDo
            //شماره مشخصه سرویس
            "serviceNumber" => $userinfo[0]["telephone"],
            "transfer" => 1,
            "transferRequest" => [
                "person" => 0,
                "companyName" => $userinfo[0]["name_sherkat"],
                "iranian" => $userinfo[0]["isirani"],
                "identificationType" => $userinfo[0]["noe_shenase_hoviati_sherkat"],
                "registrationDate" => $userinfo[0]["tarikhe_sabte_sherkat"],
                "identificationNo" => $userinfo[0]["shenase_meli"],
                "companyType" => $userinfo[0]["companyType"],
                "registrationNo" => $userinfo[0]["shomare_sabt"],
                "mobile" => $userinfo[0]["telephone_hamrahe_sherkat"],
                "email" => $userinfo[0]["email"],
                "agentFirstName" => $userinfo[0]["name"],
                "agentLastName" => $userinfo[0]["f_name"],
                "agentFatherName" => $userinfo[0]["name_pedar"],
                "agentIdentificationType" => $userinfo[0]["noe_shenase_hoviati"],
                "agentIdentificationNo" => $userinfo[0]["code_meli"],
                "agentNationality" => $userinfo[0]["codeCountry"],
                "agentBirthDate" => $userinfo[0]["tarikhe_tavalod"],
                "agentBirthCertificateNo" => $userinfo[0]["shomare_shenasname"],
                "agentMobile" => $userinfo[0]["telephone_hamrah"],
                "address" => [
                    "address" => $userinfo[0]["address"],
                    "postalCode" => $userinfo[0]["code_posti"],
                    "tel" => $userinfo[0]["telephone"],
                ],
            ],
            "resellerCode" => (string) $userinfo[0]["branch_id"],
            "requestId" => $request_id,
            "response" => 200,

        ];
        if ($data) {
            return $data;
        }
    }

    public static function transferVoipLegalKhareji($userinfo, $request_id)
    {
        if (empty($userinfo[0]["shomare_shenasname"])) {
            $userinfo[0]["shomare_shenasname"] = "0";
        }
        $shamsi_birth = self::shamsidate($userinfo[0]["tarikhe_tavalod"]);
        $shamsiRegister = self::shamsidate($userinfo[0]["tarikhe_sabte_sherkat"]);
        if ($userinfo[0]['isirani'] === 1) {
            $userinfo[0]["tarikhe_tavalod"] = $shamsi_birth;
            $userinfo[0]["tarikhe_sabte_sherkat"] = $shamsiRegister;
            $userinfo[0]["codeCountry"] = "0";
        } else {
            $userinfo[0]["shomare_shenasname"] = "0";
            $birth_date_miladi = str_replace('-', '', $userinfo[0]["tarikhe_tavalod"]);
            $userinfo[0]["tarikhe_tavalod"] = $birth_date_miladi;
            $registrationDateMiladi = str_replace('-', '', $userinfo[0]["tarikhe_sabte_sherkat"]);
            $userinfo[0]["tarikhe_sabte_sherkat"] = $registrationDateMiladi;
        }

        $data = [
            //شماره کلاسه معتبر
            "id" => "", //ToDo
            //شماره مشخصه سرویس
            "serviceNumber" => $userinfo[0]["telephone"],
            "transfer" => 1,
            "transferRequest" => [
                "person" => 0,
                "companyName" => $userinfo[0]["name_sherkat"],
                "iranian" => $userinfo[0]["isirani"],
                "identificationType" => $userinfo[0]["noe_shenase_hoviati_sherkat"],
                "registrationDate" => $userinfo[0]["tarikhe_sabte_sherkat"],
                "identificationNo" => $userinfo[0]["shenase_meli"],
                "nationality" => $userinfo[0]["codeCountry"],
                "companyType" => $userinfo[0]["companyType"],
                "registrationNo" => $userinfo[0]["shomare_sabt"],
                "mobile" => $userinfo[0]["telephone_hamrahe_sherkat"],
                "email" => $userinfo[0]["email"],
                "agentFirstName" => $userinfo[0]["name"],
                "agentLastName" => $userinfo[0]["f_name"],
                "agentFatherName" => $userinfo[0]["name_pedar"],
                "agentIdentificationType" => $userinfo[0]["noe_shenase_hoviati"],
                "agentIdentificationNo" => $userinfo[0]["code_meli"],
                "agentNationality" => $userinfo[0]["codeCountry"],
                "agentBirthDate" => $userinfo[0]["tarikhe_tavalod"],
                "agentBirthCertificateNo" => $userinfo[0]["shomare_shenasname"],
                "agentMobile" => $userinfo[0]["telephone_hamrah"],
                "address" => [
                    "address" => $userinfo[0]["address"],
                    "postalCode" => $userinfo[0]["code_posti"],
                    "tel" => $userinfo[0]["telephone"],
                ],
            ],
            "resellerCode" => (string) $userinfo[0]["branch_id"],
            "requestId" => $request_id,
            "response" => 200,
        ];

        if ($data) {
            return $data;
        }
    }

//close wireless services
    public static function closeVoipServices($userinfo, $request_id)
    {
        $data = [
            "requestId" => $request_id,
            "id" => "", //ToDo
            "serviceNumber" => $userinfo[0]["telephone"],
            "resellerCode" => (string) $userinfo[0]["branch_id"],
            "close" => 1,
            "response" => 200,

        ];
        if ($data) {
            return $data;
        }
    }

//delete wireless services
    public static function deleteVoipServices($userinfo, $request_id)
    {
        $data = [
            "requestId" => $request_id,
            "id" => "", //ToDo
            "resellerCode" => (string) $userinfo[0]["branch_id"],
            "serviceNumber" => $userinfo[0]["telephone"],
            "response" => 200,

        ];
        if ($data) {
            return $data;
        }
    }

//wireless information
//wireless Put Data
    public static function putWirelessRealIrani($userinfo, $request_id)
    {
        if (empty($userinfo[0]["shomare_shenasname"])) {
            $userinfo[0]["shomare_shenasname"] = "0";
        }
        $shamsi_birth = self::shamsidate($userinfo[0]["tarikhe_tavalod"]);
        $shamsi_start_serv = self::shamsidate($userinfo[0]["start_service"]);
        $userinfo[0]["start_service"] = $shamsi_start_serv;
        $shamsi_end_serv = self::shamsidate($userinfo[0]["end_service"]);
        $userinfo[0]["end_service"] = $shamsi_end_serv;
        $persian_subnet = Helper::convert_numbers("255.255.255.0");
        if ($userinfo[0]['isirani'] === 1) {
            $userinfo[0]["tarikhe_tavalod"] = $shamsi_birth;
        }
        $data = [
            "person" => 1,
            "name" => $userinfo[0]["name"],
            "gender" => $userinfo[0]["jensiat"],
            "family" => $userinfo[0]["f_name"],
            "fatherName" => $userinfo[0]["name_pedar"],
            "certificateNo" => $userinfo[0]["shomare_shenasname"],
            "iranian" => $userinfo[0]["isirani"],
            "identificationType" => $userinfo[0]["noe_shenase_hoviati"],
            "birthDate" => $userinfo[0]["tarikhe_tavalod"],
            "identificationNo" => $userinfo[0]["code_meli"],
            "birthPlace" => $userinfo[0]["shahre_tavalod"],
            "address" => [
                "address" => $userinfo[0]["address"],
                "postalCode" => $userinfo[0]["code_posti"],
                "tel" => $userinfo[0]["telephone"],
            ],
            "mobile" => $userinfo[0]["telephone_hamrah"],
            "email" => $userinfo[0]["email"],
            "resellerCode" => (string) $userinfo[0]["branch_id"],
            "requestId" => $request_id,
            "service" => [
                "type" => 5,
                "wirelessId" => (string) $userinfo[0]["stationid"],
                "dishType" => $userinfo[0]["dishType"],
                "deviceType" => "string", //ToDo
                "receiverLocation" => $userinfo[0]["ap_address"],
                "ipStatic" => 0, //ToDo
                "ip" => "", //ToDo
                "subnet" => $persian_subnet, //ToDo
                "lan" => $userinfo[0]['tol'],
                "lon" => $userinfo[0]['arz'],
                "bandwidth" => $userinfo[0]['bandWidth'],
                "startDate" => $userinfo[0]["start_service"],
                "endDate" => $userinfo[0]["end_service"],
                "province" => $userinfo[0]["codeOstan"],
            ],
            "response" => 200,

        ];
        return $data;
    }

    public static function putWirelessRealKhareji($userinfo, $request_id)
    {
        if (empty($userinfo[0]["shomare_shenasname"])) {
            $userinfo[0]["shomare_shenasname"] = "0";
        }
        $shamsi_start_serv = self::shamsidate($userinfo[0]["start_service"]);
        $userinfo[0]["start_service"] = $shamsi_start_serv;
        $shamsi_end_serv = self::shamsidate($userinfo[0]["end_service"]);
        $userinfo[0]["end_service"] = $shamsi_end_serv;
        $persian_subnet = Helper::convert_numbers("255.255.255.0");
        $birth_date_miladi = str_replace('-', '', $userinfo[0]["tarikhe_tavalod"]);
        $userinfo[0]["tarikhe_tavalod"] = $birth_date_miladi;
        $data = [
            "person" => 1,
            "name" => $userinfo[0]["name"],
            "gender" => $userinfo[0]["jensiat"],
            "family" => $userinfo[0]["f_name"],
            "fatherName" => $userinfo[0]["name_pedar"],
            "iranian" => $userinfo[0]["isirani"],
            "nationality" => $userinfo[0]["codeCountry"],
            "identificationType" => $userinfo[0]["noe_shenase_hoviati"],
            "birthDate" => $userinfo[0]["tarikhe_tavalod"],
            "identificationNo" => $userinfo[0]["code_meli"],
            "universalNo" => "", //felan nadarim
            "birthPlace" => $userinfo[0]["shahre_tavalod"],
            "mobile" => $userinfo[0]["telephone_hamrah"],
            "email" => $userinfo[0]["email"],
            "resellerCode" => (string) $userinfo[0]["branch_id"],
            "requestId" => $request_id,
            "address" => [
                "address" => $userinfo[0]["address"],
                "postalCode" => $userinfo[0]["code_posti"],
                "tel" => $userinfo[0]["telephone"],
            ],
            "service" => [
                "type" => 5,
                "wirelessId" => (string) $userinfo[0]["stationid"],
                "dishType" => $userinfo[0]["dishType"],
                "deviceType" => "string", //ToDo
                "receiverLocation" => $userinfo[0]["ap_address"],
                "ipStatic" => 0, //ToDo
                "ip" => "", //ToDo
                "subnet" => $persian_subnet, //ToDo
                "lan" => $userinfo[0]['tol'],
                "lon" => $userinfo[0]['arz'],
                "bandwidth" => $userinfo[0]['bandWidth'],
                "startDate" => $userinfo[0]["start_service"],
                "endDate" => $userinfo[0]["end_service"],
                "province" => $userinfo[0]["codeOstan"],
            ],
            "response" => 200,

        ];
        return $data;
    }

    public static function putWirelessLegalIrani($userinfo, $request_id)
    {
        if (empty($userinfo[0]["shomare_shenasname"])) {
            $userinfo[0]["shomare_shenasname"] = "0";
        }
        $shamsi_birth = self::shamsidate($userinfo[0]["tarikhe_tavalod"]);
        $shamsiRegister = self::shamsidate($userinfo[0]["tarikhe_sabte_sherkat"]);
        $shamsi_start_serv = self::shamsidate($userinfo[0]["start_service"]);
        $userinfo[0]["start_service"] = $shamsi_start_serv;
        $shamsi_end_serv = self::shamsidate($userinfo[0]["end_service"]);
        $userinfo[0]["end_service"] = $shamsi_end_serv;
        $persian_subnet = Helper::convert_numbers("255.255.255.0");
        if ($userinfo[0]['isirani'] === 1) {
            $userinfo[0]["tarikhe_tavalod"] = $shamsi_birth;
            $userinfo[0]["tarikhe_sabte_sherkat"] = $shamsiRegister;
            $userinfo[0]["codeCountry"] = "0";
        } else {
            $userinfo[0]["shomare_shenasname"] = "0";
            $birth_date_miladi = str_replace('-', '', $userinfo[0]["tarikhe_tavalod"]);
            $userinfo[0]["tarikhe_tavalod"] = $birth_date_miladi;
            $registrationDateMiladi = str_replace('-', '', $userinfo[0]["tarikhe_sabte_sherkat"]);
            $userinfo[0]["tarikhe_sabte_sherkat"] = $registrationDateMiladi;
        }

        $data = [
            "person" => 0,
            "companyName" => $userinfo[0]["name_sherkat"],
            "iranian" => $userinfo[0]["isirani"],
            "identificationType" => $userinfo[0]["noe_shenase_hoviati_sherkat"],
            "registrationDate" => $userinfo[0]["tarikhe_sabte_sherkat"],
            "identificationNo" => $userinfo[0]["shenase_meli"],
            "companyType" => $userinfo[0]["companyType"],
            "registrationNo" => $userinfo[0]["shomare_sabt"],
            "mobile" => $userinfo[0]["telephone_hamrahe_sherkat"],
            "email" => $userinfo[0]["email"],
            "address" => [
                "address" => $userinfo[0]["address"],
                "postalCode" => $userinfo[0]["code_posti"],
                "tel" => $userinfo[0]["telephone"],
            ],
            "agentFirstName" => $userinfo[0]["name"],
            "agentLastName" => $userinfo[0]["f_name"],
            "agentFatherName" => $userinfo[0]["name_pedar"],
            "agentIdentificationType" => $userinfo[0]["noe_shenase_hoviati"],
            "agentIdentificationNo" => $userinfo[0]["code_meli"],
            "agentNationality" => $userinfo[0]["codeCountry"],
            "agentBirthDate" => $userinfo[0]["tarikhe_tavalod"],
            "agentBirthCertificateNo" => $userinfo[0]["shomare_shenasname"],
            "agentMobile" => $userinfo[0]["telephone_hamrah"],
            "resellerCode" => (string) $userinfo[0]["branch_id"],
            "requestId" => $request_id,
            "service" => [
                "type" => 5,
                "wirelessId" => (string) $userinfo[0]["stationid"],
                "dishType" => $userinfo[0]["dishType"],
                "deviceType" => "string", //ToDo
                "receiverLocation" => $userinfo[0]["ap_address"],
                "ipStatic" => 0, //ToDo
                "ip" => "", //ToDo
                "subnet" => $persian_subnet, //ToDo
                "lan" => $userinfo[0]['tol'],
                "lon" => $userinfo[0]['arz'],
                "bandwidth" => $userinfo[0]['bandWidth'],
                "startDate" => $userinfo[0]["start_service"],
                "endDate" => $userinfo[0]["end_service"],
                "province" => $userinfo[0]["codeOstan"],
            ],
            "response" => 200,

        ];
        if ($data) {
            return $data;
        }
    }

    public static function putWirelessLegalKhareji($userinfo, $request_id)
    {
        if (empty($userinfo[0]["shomare_shenasname"])) {
            $userinfo[0]["shomare_shenasname"] = "0";
        }
        $shamsi_birth = self::shamsidate($userinfo[0]["tarikhe_tavalod"]);
        $shamsiRegister = self::shamsidate($userinfo[0]["tarikhe_sabte_sherkat"]);
        $shamsi_start_serv = self::shamsidate($userinfo[0]["start_service"]);
        $userinfo[0]["start_service"] = $shamsi_start_serv;
        $shamsi_end_serv = self::shamsidate($userinfo[0]["end_service"]);
        $userinfo[0]["end_service"] = $shamsi_end_serv;
        $persian_subnet = Helper::convert_numbers("255.255.255.0");
        if ($userinfo[0]['isirani'] === 1) {
            $userinfo[0]["tarikhe_tavalod"] = $shamsi_birth;
            $userinfo[0]["tarikhe_sabte_sherkat"] = $shamsiRegister;
            $userinfo[0]["codeCountry"] = "0";
        } else {
            $userinfo[0]["shomare_shenasname"] = "0";
            $birth_date_miladi = str_replace('-', '', $userinfo[0]["tarikhe_tavalod"]);
            $userinfo[0]["tarikhe_tavalod"] = $birth_date_miladi;
            $registrationDateMiladi = str_replace('-', '', $userinfo[0]["tarikhe_sabte_sherkat"]);
            $userinfo[0]["tarikhe_sabte_sherkat"] = $registrationDateMiladi;
        }

        $data = [
            "person" => 0,
            "companyName" => $userinfo[0]["name_sherkat"],
            "iranian" => $userinfo[0]["isirani"],
            "identificationType" => $userinfo[0]["noe_shenase_hoviati_sherkat"],
            "registrationDate" => $userinfo[0]["tarikhe_sabte_sherkat"],
            "identificationNo" => $userinfo[0]["shenase_meli"],
            "nationality" => $userinfo[0]["codeCountry"],
            "companyType" => $userinfo[0]["companyType"],
            "registrationNo" => $userinfo[0]["shomare_sabt"],
            "address" => [
                "address" => $userinfo[0]["address"],
                "postalCode" => $userinfo[0]["code_posti"],
                "tel" => $userinfo[0]["telephone"],
            ],
            "mobile" => $userinfo[0]["telephone_hamrahe_sherkat"],
            "email" => $userinfo[0]["email"],
            "agentFirstName" => $userinfo[0]["name"],
            "agentLastName" => $userinfo[0]["f_name"],
            "agentFatherName" => $userinfo[0]["name_pedar"],
            "agentIdentificationType" => $userinfo[0]["noe_shenase_hoviati"],
            "agentIdentificationNo" => $userinfo[0]["code_meli"],
            "agentNationality" => $userinfo[0]["codeCountry"],
            "agentBirthDate" => $userinfo[0]["tarikhe_tavalod"],
            "agentBirthCertificateNo" => $userinfo[0]["shomare_shenasname"],
            "agentMobile" => $userinfo[0]["telephone_hamrah"],
            "resellerCode" => (string) $userinfo[0]["branch_id"],
            "requestId" => $request_id,
            "service" => [
                "type" => 5,
                "wirelessId" => (string) $userinfo[0]["stationid"],
                "dishType" => $userinfo[0]["dishType"],
                "deviceType" => "string", //ToDo
                "receiverLocation" => $userinfo[0]["ap_address"],
                "ipStatic" => 0, //ToDo
                "ip" => "", //ToDo
                "subnet" => $persian_subnet, //ToDo
                "lan" => $userinfo[0]['tol'],
                "lon" => $userinfo[0]['arz'],
                "bandwidth" => $userinfo[0]['bandWidth'],
                "startDate" => $userinfo[0]["start_service"],
                "endDate" => $userinfo[0]["end_service"],
                "province" => $userinfo[0]["codeOstan"],
            ],
            "response" => 200,

        ];

        if ($data) {
            return $data;
        }
    }

//wireless Update Data
    public static function updateWirelessRealIrani($userinfo, $request_id)
    {
        if (empty($userinfo[0]["shomare_shenasname"])) {
            $userinfo[0]["shomare_shenasname"] = "0";
        }
        $shamsi_birth = self::shamsidate($userinfo[0]["tarikhe_tavalod"]);
        $shamsi_start_serv = self::shamsidate($userinfo[0]["start_service"]);
        $userinfo[0]["start_service"] = $shamsi_start_serv;
        $shamsi_end_serv = self::shamsidate($userinfo[0]["end_service"]);
        $userinfo[0]["end_service"] = $shamsi_end_serv;
        $persian_subnet = Helper::convert_numbers("255.255.255.0");
        if ($userinfo[0]['isirani'] === 1) {
            $userinfo[0]["tarikhe_tavalod"] = $shamsi_birth;
        }
        $data = [
            //شماره کلاسه معتبر
            "id" => "",
            //شماره مشخصه سرویس
            "serviceNumber" => $userinfo[0]["telephone"],
            "customerUpdate" => [
                "name" => $userinfo[0]["name"],
                "gender" => $userinfo[0]["jensiat"],
                "family" => $userinfo[0]["f_name"],
                "fatherName" => $userinfo[0]["name_pedar"],
                "birthDate" => $userinfo[0]["tarikhe_tavalod"],
                "birthPlace" => $userinfo[0]["shahre_tavalod"],
                "mobile" => $userinfo[0]["telephone_hamrah"],
                "email" => $userinfo[0]["email"],
            ],
            "addressUpdate" => [
                "address" => $userinfo[0]["address"],
                "postalCode" => $userinfo[0]["code_posti"],
                "tel" => $userinfo[0]["telephone"],
            ],
            "resellerCode" => (string) $userinfo[0]["branch_id"],
            "requestId" => $request_id,
            "serviceUpdate" => [
                "dishType" => $userinfo[0]["dishType"],
                "deviceType" => "string", //ToDo
                "receiverLocation" => $userinfo[0]["ap_address"],
                "ipStatic" => 0,
                "ip" => "", //ToDo
                "subnet" => $persian_subnet, //ToDo
                "lan" => $userinfo[0]['tol'],
                "lon" => $userinfo[0]['arz'],
                "bandwidth" => $userinfo[0]['bandWidth'],
                "startDate" => $userinfo[0]["start_service"],
                "endDate" => $userinfo[0]["end_service"],
                "province" => $userinfo[0]["codeOstan"],
            ],
            "response" => 200,

        ];
        return $data;
    }

    public static function updateWirelessRealKhareji($userinfo, $request_id)
    {
        if (empty($userinfo[0]["shomare_shenasname"])) {
            $userinfo[0]["shomare_shenasname"] = "0";
        }
        $shamsi_start_serv = self::shamsidate($userinfo[0]["start_service"]);
        $userinfo[0]["start_service"] = $shamsi_start_serv;
        $shamsi_end_serv = self::shamsidate($userinfo[0]["end_service"]);
        $userinfo[0]["end_service"] = $shamsi_end_serv;
        $persian_subnet = Helper::convert_numbers("255.255.255.0");
        $birth_date_miladi = str_replace('-', '', $userinfo[0]["tarikhe_tavalod"]);
        $userinfo[0]["tarikhe_tavalod"] = $birth_date_miladi;
        $data = [
            //شماره کلاسه معتبر
            "id" => 1, //tesi
            //شماره مشخصه سرویس
            "serviceNumber" => $userinfo[0]["telephone"],
            "customerUpdate" => [
                "name" => $userinfo[0]["name"],
                "gender" => $userinfo[0]["jensiat"],
                "family" => $userinfo[0]["f_name"],
                "fatherName" => $userinfo[0]["name_pedar"],
                "nationality" => $userinfo[0]["codeCountry"],
                "birthDate" => $userinfo[0]["tarikhe_tavalod"],
                "birthPlace" => $userinfo[0]["shahre_tavalod"],
                "mobile" => $userinfo[0]["telephone_hamrah"],
                "email" => $userinfo[0]["email"],
            ],
            "resellerCode" => (string) $userinfo[0]["branch_id"],
            "requestId" => $request_id,
            "address" => [
                "address" => $userinfo[0]["address"],
                "postalCode" => $userinfo[0]["code_posti"],
                "tel" => $userinfo[0]["telephone"],
            ],
            "service" => [
                "dishType" => $userinfo[0]["dishType"],
                "deviceType" => "string", //ToDo
                "receiverLocation" => $userinfo[0]["ap_address"],
                "ipStatic" => 0, //ToDo
                "ip" => "", //ToDo
                "subnet" => $persian_subnet, //ToDo
                "lan" => $userinfo[0]['tol'],
                "lon" => $userinfo[0]['arz'],
                "bandwidth" => $userinfo[0]['bandWidth'],
                "startDate" => $userinfo[0]["start_service"],
                "endDate" => $userinfo[0]["end_service"],
                "province" => $userinfo[0]["codeOstan"],
            ],
            "response" => 200,

        ];
        return $data;
    }

    public static function updateWirelessLegalIrani($userinfo, $request_id)
    {
        if (empty($userinfo[0]["shomare_shenasname"])) {
            $userinfo[0]["shomare_shenasname"] = "0";
        }
        $shamsi_birth = self::shamsidate($userinfo[0]["tarikhe_tavalod"]);
        $shamsiRegister = self::shamsidate($userinfo[0]["tarikhe_sabte_sherkat"]);
        $shamsi_start_serv = self::shamsidate($userinfo[0]["start_service"]);
        $userinfo[0]["start_service"] = $shamsi_start_serv;
        $shamsi_end_serv = self::shamsidate($userinfo[0]["end_service"]);
        $userinfo[0]["end_service"] = $shamsi_end_serv;
        $persian_subnet = Helper::convert_numbers("255.255.255.0");
        if ($userinfo[0]['isirani'] === 1) {
            $userinfo[0]["tarikhe_tavalod"] = $shamsi_birth;
            $userinfo[0]["tarikhe_sabte_sherkat"] = $shamsiRegister;
            $userinfo[0]["codeCountry"] = "0";
        } else {
            $userinfo[0]["shomare_shenasname"] = "0";
            $birth_date_miladi = str_replace('-', '', $userinfo[0]["tarikhe_tavalod"]);
            $userinfo[0]["tarikhe_tavalod"] = $birth_date_miladi;
            $registrationDateMiladi = str_replace('-', '', $userinfo[0]["tarikhe_sabte_sherkat"]);
            $userinfo[0]["tarikhe_sabte_sherkat"] = $registrationDateMiladi;
        }

        $data = [
            //شماره کلاسه معتبر
            "id" => "",
            //شماره مشخصه سرویس
            "serviceNumber" => $userinfo[0]["telephone"],
            "customerUpdate" => [
                "companyName" => $userinfo[0]["name_sherkat"],
                "registrationDate" => $userinfo[0]["tarikhe_sabte_sherkat"],
                "companyType" => $userinfo[0]["companyType"],
                "registrationNo" => $userinfo[0]["shomare_sabt"],
                "mobile" => $userinfo[0]["telephone_hamrahe_sherkat"],
                "email" => $userinfo[0]["email"],
                "agentFirstName" => $userinfo[0]["name"],
                "agentLastName" => $userinfo[0]["f_name"],
                "agentFatherName" => $userinfo[0]["name_pedar"],
                "agentIdentificationType" => $userinfo[0]["noe_shenase_hoviati"],
                "agentIdentificationNo" => $userinfo[0]["code_meli"],
                "agentNationality" => $userinfo[0]["codeCountry"],
                "agentBirthDate" => $userinfo[0]["tarikhe_tavalod"],
                "agentBirthCertificateNo" => $userinfo[0]["shomare_shenasname"],
                "agentMobile" => $userinfo[0]["telephone_hamrah"],
            ],
            "addressUpdate" => [
                "address" => $userinfo[0]["address"],
                "postalCode" => $userinfo[0]["code_posti"],
                "tel" => $userinfo[0]["telephone"],
            ],
            "resellerCode" => (string) $userinfo[0]["branch_id"],
            "requestId" => $request_id,
            "serviceUpdate" => [
                "dishType" => $userinfo[0]["dishType"],
                "deviceType" => "string", //ToDo
                "receiverLocation" => $userinfo[0]["ap_address"],
                "ipStatic" => 0, //ToDo
                "ip" => "", //ToDo
                "subnet" => $persian_subnet, //ToDo
                "lan" => $userinfo[0]['tol'],
                "lon" => $userinfo[0]['arz'],
                "bandwidth" => $userinfo[0]['bandWidth'],
                "startDate" => $userinfo[0]["start_service"],
                "endDate" => $userinfo[0]["end_service"],
                "province" => $userinfo[0]["codeOstan"],
            ],
            "response" => 200,
        ];
        if ($data) {
            return $data;
        }
    }

    public static function updateWirelessLegalKhareji($userinfo, $request_id)
    {
        if (empty($userinfo[0]["shomare_shenasname"])) {
            $userinfo[0]["shomare_shenasname"] = "0";
        }
        $shamsi_birth = self::shamsidate($userinfo[0]["tarikhe_tavalod"]);
        $shamsiRegister = self::shamsidate($userinfo[0]["tarikhe_sabte_sherkat"]);
        $shamsi_start_serv = self::shamsidate($userinfo[0]["start_service"]);
        $userinfo[0]["start_service"] = $shamsi_start_serv;
        $shamsi_end_serv = self::shamsidate($userinfo[0]["end_service"]);
        $userinfo[0]["end_service"] = $shamsi_end_serv;
        $persian_subnet = Helper::convert_numbers("255.255.255.0");
        if ($userinfo[0]['isirani'] === 1) {
            $userinfo[0]["tarikhe_tavalod"] = $shamsi_birth;
            $userinfo[0]["tarikhe_sabte_sherkat"] = $shamsiRegister;
            $userinfo[0]["codeCountry"] = "0";
        } else {
            $userinfo[0]["shomare_shenasname"] = "0";
            $birth_date_miladi = str_replace('-', '', $userinfo[0]["tarikhe_tavalod"]);
            $userinfo[0]["tarikhe_tavalod"] = $birth_date_miladi;
            $registrationDateMiladi = str_replace('-', '', $userinfo[0]["tarikhe_sabte_sherkat"]);
            $userinfo[0]["tarikhe_sabte_sherkat"] = $registrationDateMiladi;
        }

        $data = [
            //شماره کلاسه معتبر
            "id" => "", //ToDo
            //شماره مشخصه سرویس
            "serviceNumber" => $userinfo[0]["telephone"],
            "customerUpdate" => [
                "companyName" => $userinfo[0]["name_sherkat"],
                "registrationDate" => $userinfo[0]["tarikhe_sabte_sherkat"],
                "nationality" => $userinfo[0]["codeCountry"],
                "companyType" => $userinfo[0]["companyType"],
                "registrationNo" => $userinfo[0]["shomare_sabt"],
                "mobile" => $userinfo[0]["telephone_hamrahe_sherkat"],
                "email" => $userinfo[0]["email"],
                "agentFirstName" => $userinfo[0]["name"],
                "agentLastName" => $userinfo[0]["f_name"],
                "agentFatherName" => $userinfo[0]["name_pedar"],
                "agentIdentificationType" => $userinfo[0]["noe_shenase_hoviati"],
                "agentIdentificationNo" => $userinfo[0]["code_meli"],
                "agentNationality" => $userinfo[0]["codeCountry"],
                "agentBirthDate" => $userinfo[0]["tarikhe_tavalod"],
                "agentBirthCertificateNo" => $userinfo[0]["shomare_shenasname"],
                "agentMobile" => $userinfo[0]["telephone_hamrah"],
            ],
            "address" => [
                "address" => $userinfo[0]["address"],
                "postalCode" => $userinfo[0]["code_posti"],
                "tel" => $userinfo[0]["telephone"],
            ],
            "resellerCode" => (string) $userinfo[0]["branch_id"],
            "requestId" => $request_id,
            "service" => [
                "dishType" => $userinfo[0]["dishType"],
                "deviceType" => "string", //ToDo
                "receiverLocation" => $userinfo[0]["ap_address"],
                "ipStatic" => 0, //ToDo
                "ip" => "", //ToDo
                "subnet" => $persian_subnet, //ToDo
                "lan" => $userinfo[0]['tol'],
                "lon" => $userinfo[0]['arz'],
                "bandwidth" => $userinfo[0]['bandWidth'],
                "startDate" => $userinfo[0]["start_service"],
                "endDate" => $userinfo[0]["end_service"],
                "province" => $userinfo[0]["codeOstan"],
            ],
            "response" => 200,
        ];

        if ($data) {
            return $data;
        }
    }

//wireless Transfer Data
    public static function transferWirelessRealIrani($userinfo, $request_id)
    {
        if (empty($userinfo[0]["shomare_shenasname"])) {
            $userinfo[0]["shomare_shenasname"] = "0";
        }
        $shamsi_birth = self::shamsidate($userinfo[0]["tarikhe_tavalod"]);
        $shamsi_start_serv = self::shamsidate($userinfo[0]["start_service"]);
        $userinfo[0]["start_service"] = $shamsi_start_serv;
        $shamsi_end_serv = self::shamsidate($userinfo[0]["end_service"]);
        $userinfo[0]["end_service"] = $shamsi_end_serv;
        if ($userinfo[0]['isirani'] === 1) {
            $userinfo[0]["tarikhe_tavalod"] = $shamsi_birth;
        }
        $data = [
            //شماره کلاسه معتبر
            "id" => "", //ToDo
            //شماره مشخصه سرویس
            "serviceNumber" => $userinfo[0]["telephone"],
            "transfer" => 1,
            "transferRequest" => [
                "person" => 1,
                "name" => $userinfo[0]["name"],
                "gender" => $userinfo[0]["jensiat"],
                "family" => $userinfo[0]["f_name"],
                "fatherName" => $userinfo[0]["name_pedar"],
                "certificateNo" => $userinfo[0]["shomare_shenasname"],
                "iranian" => $userinfo[0]["isirani"],
                "identificationType" => $userinfo[0]["noe_shenase_hoviati"],
                "birthDate" => $userinfo[0]["tarikhe_tavalod"],
                "identificationNo" => $userinfo[0]["code_meli"],
                "birthPlace" => $userinfo[0]["shahre_tavalod"],
                "address" => [
                    "address" => $userinfo[0]["address"],
                    "postalCode" => $userinfo[0]["code_posti"],
                    "tel" => $userinfo[0]["telephone"],
                ],
            ],

            "resellerCode" => (string) $userinfo[0]["branch_id"],
            "requestId" => $request_id,
            "response" => 200,

        ];
        return $data;
    }

    public static function transferWirelessRealKhareji($userinfo, $request_id)
    {
        if (empty($userinfo[0]["shomare_shenasname"])) {
            $userinfo[0]["shomare_shenasname"] = "0";
        }
        $shamsi_start_serv = self::shamsidate($userinfo[0]["start_service"]);
        $userinfo[0]["start_service"] = $shamsi_start_serv;
        $shamsi_end_serv = self::shamsidate($userinfo[0]["end_service"]);
        $userinfo[0]["end_service"] = $shamsi_end_serv;
        $persian_subnet = Helper::convert_numbers("255.255.255.0");
        $birth_date_miladi = str_replace('-', '', $userinfo[0]["tarikhe_tavalod"]);
        $userinfo[0]["tarikhe_tavalod"] = $birth_date_miladi;
        $data = [
            //شماره کلاسه معتبر
            "id" => "",
            //شماره مشخصه سرویس
            "serviceNumber" => $userinfo[0]["telephone"],
            "transfer" => 1,
            "transferRequest" => [
                "person" => 1,
                "name" => $userinfo[0]["name"],
                "gender" => $userinfo[0]["jensiat"],
                "family" => $userinfo[0]["f_name"],
                "fatherName" => $userinfo[0]["name_pedar"],
                "iranian" => $userinfo[0]["isirani"],
                "nationality" => $userinfo[0]["codeCountry"],
                "identificationType" => $userinfo[0]["noe_shenase_hoviati"],
                "birthDate" => $userinfo[0]["tarikhe_tavalod"],
                "identificationNo" => $userinfo[0]["code_meli"],
                "universalNo" => "", //felan nadarim
                "birthPlace" => $userinfo[0]["shahre_tavalod"],
                "mobile" => $userinfo[0]["telephone_hamrah"],
                "email" => $userinfo[0]["email"],
                "address" => [
                    "address" => $userinfo[0]["address"],
                    "postalCode" => $userinfo[0]["code_posti"],
                    "tel" => $userinfo[0]["telephone"],
                ],
            ],
            "resellerCode" => (string) $userinfo[0]["branch_id"],
            "requestId" => $request_id,
            "response" => 200,

        ];
        return $data;
    }

    public static function transferWirelessLegalIrani($userinfo, $request_id)
    {
        if (empty($userinfo[0]["shomare_shenasname"])) {
            $userinfo[0]["shomare_shenasname"] = "0";
        }
        $shamsi_birth = self::shamsidate($userinfo[0]["tarikhe_tavalod"]);
        $shamsiRegister = self::shamsidate($userinfo[0]["tarikhe_sabte_sherkat"]);
        if ($userinfo[0]['isirani'] === 1) {
            $userinfo[0]["tarikhe_tavalod"] = $shamsi_birth;
            $userinfo[0]["tarikhe_sabte_sherkat"] = $shamsiRegister;
            $userinfo[0]["codeCountry"] = "0";
        } else {
            $userinfo[0]["shomare_shenasname"] = "0";
            $birth_date_miladi = str_replace('-', '', $userinfo[0]["tarikhe_tavalod"]);
            $userinfo[0]["tarikhe_tavalod"] = $birth_date_miladi;
            $registrationDateMiladi = str_replace('-', '', $userinfo[0]["tarikhe_sabte_sherkat"]);
            $userinfo[0]["tarikhe_sabte_sherkat"] = $registrationDateMiladi;
        }

        $data = [
            //شماره کلاسه معتبر
            "id" => "",
            //شماره مشخصه سرویس
            "serviceNumber" => $userinfo[0]["telephone"],
            "transfer" => 1,
            "transferRequest" => [
                "person" => 0,
                "companyName" => $userinfo[0]["name_sherkat"],
                "iranian" => $userinfo[0]["isirani"],
                "identificationType" => $userinfo[0]["noe_shenase_hoviati_sherkat"],
                "registrationDate" => $userinfo[0]["tarikhe_sabte_sherkat"],
                "identificationNo" => $userinfo[0]["shenase_meli"],
                "companyType" => $userinfo[0]["companyType"],
                "registrationNo" => $userinfo[0]["shomare_sabt"],
                "mobile" => $userinfo[0]["telephone_hamrahe_sherkat"],
                "email" => $userinfo[0]["email"],
                "agentFirstName" => $userinfo[0]["name"],
                "agentLastName" => $userinfo[0]["f_name"],
                "agentFatherName" => $userinfo[0]["name_pedar"],
                "agentIdentificationType" => $userinfo[0]["noe_shenase_hoviati"],
                "agentIdentificationNo" => $userinfo[0]["code_meli"],
                "agentNationality" => $userinfo[0]["codeCountry"],
                "agentBirthDate" => $userinfo[0]["tarikhe_tavalod"],
                "agentBirthCertificateNo" => $userinfo[0]["shomare_shenasname"],
                "agentMobile" => $userinfo[0]["telephone_hamrah"],
                "address" => [
                    "address" => $userinfo[0]["address"],
                    "postalCode" => $userinfo[0]["code_posti"],
                    "tel" => $userinfo[0]["telephone"],
                ],
            ],
            "resellerCode" => (string) $userinfo[0]["branch_id"],
            "requestId" => $request_id,
            "response" => 200,

        ];
        if ($data) {
            return $data;
        }
    }

    public static function transferWirelessLegalKhareji($userinfo, $request_id)
    {
        if (empty($userinfo[0]["shomare_shenasname"])) {
            $userinfo[0]["shomare_shenasname"] = "0";
        }
        $shamsi_birth = self::shamsidate($userinfo[0]["tarikhe_tavalod"]);
        $shamsiRegister = self::shamsidate($userinfo[0]["tarikhe_sabte_sherkat"]);
        $shamsi_start_serv = self::shamsidate($userinfo[0]["start_service"]);
        $userinfo[0]["start_service"] = $shamsi_start_serv;
        $shamsi_end_serv = self::shamsidate($userinfo[0]["end_service"]);
        $userinfo[0]["end_service"] = $shamsi_end_serv;
        $persian_subnet = Helper::convert_numbers("255.255.255.0");
        if ($userinfo[0]['isirani'] === 1) {
            $userinfo[0]["tarikhe_tavalod"] = $shamsi_birth;
            $userinfo[0]["tarikhe_sabte_sherkat"] = $shamsiRegister;
            $userinfo[0]["codeCountry"] = "0";
        } else {
            $userinfo[0]["shomare_shenasname"] = "0";
            $birth_date_miladi = str_replace('-', '', $userinfo[0]["tarikhe_tavalod"]);
            $userinfo[0]["tarikhe_tavalod"] = $birth_date_miladi;
            $registrationDateMiladi = str_replace('-', '', $userinfo[0]["tarikhe_sabte_sherkat"]);
            $userinfo[0]["tarikhe_sabte_sherkat"] = $registrationDateMiladi;
        }

        $data = [
            //شماره کلاسه معتبر
            "id" => "", //ToDo
            //شماره مشخصه سرویس
            "serviceNumber" => $userinfo[0]["telephone"],
            "transfer" => 1,
            "transferRequest" => [
                "person" => 0,
                "companyName" => $userinfo[0]["name_sherkat"],
                "iranian" => $userinfo[0]["isirani"],
                "identificationType" => $userinfo[0]["noe_shenase_hoviati_sherkat"],
                "registrationDate" => $userinfo[0]["tarikhe_sabte_sherkat"],
                "identificationNo" => $userinfo[0]["shenase_meli"],
                "nationality" => $userinfo[0]["codeCountry"],
                "companyType" => $userinfo[0]["companyType"],
                "registrationNo" => $userinfo[0]["shomare_sabt"],
                "mobile" => $userinfo[0]["telephone_hamrahe_sherkat"],
                "email" => $userinfo[0]["email"],
                "agentFirstName" => $userinfo[0]["name"],
                "agentLastName" => $userinfo[0]["f_name"],
                "agentFatherName" => $userinfo[0]["name_pedar"],
                "agentIdentificationType" => $userinfo[0]["noe_shenase_hoviati"],
                "agentIdentificationNo" => $userinfo[0]["code_meli"],
                "agentNationality" => $userinfo[0]["codeCountry"],
                "agentBirthDate" => $userinfo[0]["tarikhe_tavalod"],
                "agentBirthCertificateNo" => $userinfo[0]["shomare_shenasname"],
                "agentMobile" => $userinfo[0]["telephone_hamrah"],
                "address" => [
                    "address" => $userinfo[0]["address"],
                    "postalCode" => $userinfo[0]["code_posti"],
                    "tel" => $userinfo[0]["telephone"],
                ],
            ],
            "resellerCode" => (string) $userinfo[0]["branch_id"],
            "requestId" => $request_id,
            "response" => 200,

        ];

        if ($data) {
            return $data;
        }
    }

//close wireless services
    public static function closeWirelessServices($userinfo, $request_id)
    {
        $data = [
            "requestId" => $request_id,
            "id" => "", //ToDo
            "serviceNumber" => $userinfo[0]["telephone"],
            "resellerCode" => (string) $userinfo[0]["branch_id"],
            "close" => 1,
            "response" => 200,

        ];
        if ($data) {
            return $data;
        }
    }

//delete wireless services
    public static function deleteWirelessServices($userinfo, $request_id)
    {
        $data = [
            "requestId" => $request_id,
            "id" => "", //ToDo
            "resellerCode" => (string) $userinfo[0]["branch_id"],
            "serviceNumber" => $userinfo[0]["telephone"],
            "response" => 200,

        ];
        if ($data) {
            return $data;
        }
    }

//data haye estelam ha
    public static function DataEstRequestHistory($request_id, $enquiry_id)
    {
        $data = [
            "requestId" => $request_id,
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
            "requestId" => $request_id,
            "response" => 200,

        ];
        if ($data) {
            return $data;
        }
    }

    public static function DataEstServiceStatus($request_id, $userinfo)
    {
        $service_type = self::service_type($userinfo[0]['serviceType']);
        $data = [
            "requestId" => $request_id,
            "serviceType" => $service_type,
            "serviceNumber" => $userinfo[0]['telephone'],
            "response" => 200,

        ];
        if ($data) {
            return $data;
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
            "response" => 200,

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
            "response" => 200,
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
            "response" => 200,

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
            "response" => 200,

        ];
        return $data;
    }

    public static function DataEstReportOfOperatorsServices($request_id)
    {
        $data = [
            "requestId" => $request_id,
            "response" => 200,

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
        $tarikhe_tavalod = Helper::dateConvertInitialize($userinfo[0]['tarikhe_tavalod'], '-');
        $tarikhe_tavalod = Helper::gregorian_to_jalali($tarikhe_tavalod[0], $tarikhe_tavalod[1], $tarikhe_tavalod[2]);
        $tarikhe_tavalod[0] = (string) $tarikhe_tavalod[0];
        if ($tarikhe_tavalod[1] < 10) {
            $tarikhe_tavalod[1] = "0" . (string) $tarikhe_tavalod[1];
        }
        if ($tarikhe_tavalod[2] < 10) {
            $tarikhe_tavalod[2] = "0" . (string) $tarikhe_tavalod[2];
        }
        $data = [
            "estelaamType" => 0,
            "name" => $userinfo[0]['name'],
            "family" => $userinfo[0]['f_name'],
            "fatherName" => $userinfo[0]['name_pedar'],
            "identificationType" => (int) $userinfo[0]['noe_shenase_hoviati'],
            "birthDate" => $tarikhe_tavalod[0] . $tarikhe_tavalod[1] . $tarikhe_tavalod[2],
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
            'identificationType' => (int) $userinfo[0]['noe_shenase_hoviati_sherkat'],
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
            "requestId" => $request_id,
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
        switch ($service_type) {
//adsl,vdsl,bitstream//wireless//tdlte//voip
            case "Adsl":
            case "vdsl":
            case "bitstream":
                $service_type = 3;
                break;
            case "wireless":
                $service_type = 5;
                break;
            case "Voip":
            case "voip":
                $service_type = 17;
                break;
            case "TDLTE":
                $service_type = 18;
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
