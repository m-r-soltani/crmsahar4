<?php defined('__ROOT__') or exit('No direct script access allowed');

class Pre_Internal_Real_Subscribers extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        /*========pre_internal_real_subscribers========*/
        if (isset($_POST['send_pre_internal_real_subscribers'])) {
            parse_str($_POST[key($_POST)], $_POST);
            unset($_POST['shoghl_validate_langFa']);
            if (isset($_POST['national_code'])) {
                $_POST['code_meli'] = $_POST['national_code'];
                unset($_POST['national_code']);
            }
            if (isset($_POST['s_s'])) {
                $_POST['shomare_shenasname'] = $_POST['s_s'];
                unset($_POST['s_s']);
            }
            //todo... code meli replace charachter ('-','/') with ('')
            if (Helper::Login_Just_Check()) {
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                    case __MODIRUSERTYPE__:
                    case __OPERATORUSERTYPE__:
                    case __MODIR2USERTYPE__:
                    case __OPERATOR2USERTYPE__:
                        unset($_POST['send_real_subscribers']);
                        if (isset($_POST['tarikhe_tavalod'])) {
                            $date_arr = array();
                            $date_arr = explode("/", $_POST['tarikhe_tavalod']);
                            if (count($date_arr) > 2) {
                                $year = (int) Helper::convert_numbers($date_arr[0], false);
                                $month = (int) Helper::convert_numbers($date_arr[1], false);
                                $day = (int) Helper::convert_numbers($date_arr[2], false);
                                $_POST['tarikhe_tavalod'] = Helper::jalali_to_gregorian($year, $month, $day, '/');
                            }
                        }
                        if (isset($_FILES["r_t_karte_meli"]) && $_FILES["r_t_karte_meli"]['name'] != '' && isset($_POST['code_meli']) && $_POST['code_meli'] != '') {
                            $res = Helper::upload_file("r_t_karte_meli", $_FILES, "moshtarakine_haghighi\\", $_POST['code_meli'], "tasvire_codemeli");
                            if ($res) {
                                $_POST['r_t_karte_meli'] = $res;
                            } else {
                                unset($_POST['r_t_karte_meli']);
                            }
                        } else {
                            unset($_POST['r_t_karte_meli']);
                        }
                        if (isset($_FILES["r_t_ghabze_telephone"]) && $_FILES["r_t_ghabze_telephone"]['name'] != '' && isset($_POST['code_meli']) && $_POST['code_meli'] != '') {
                            $res = Helper::upload_file("r_t_ghabze_telephone", $_FILES, "moshtarakine_haghighi\\", $_POST['code_meli'], "tasvire_ghabzetelephone");
                            if ($res) {
                                $_POST['r_t_ghabze_telephone'] = $res;
                            } else {
                                unset($_POST['r_t_ghabze_telephone']);
                            }
                        } else {
                            unset($_POST['r_t_ghabze_telephone']);

                        }
                        if (isset($_FILES["r_t_ejare_malekiat"]) && $_FILES["r_t_ejare_malekiat"]['name'] != '' && isset($_POST['code_meli']) && $_POST['code_meli'] != '') {
                            $res = Helper::upload_file("r_t_ejare_malekiat", $_FILES, "moshtarakine_haghighi\\", $_POST['code_meli'], "tasvire_ejaremalekiat");
                            if ($res) {
                                $_POST['r_t_ejare_malekiat'] = $res;
                            } else {
                                unset($_POST['r_t_ejare_malekiat']);
                            }
                        } else {
                            unset($_POST['r_t_ejare_malekiat']);
                        }
                        if (isset($_FILES["r_t_gharardad"]) && $_FILES["r_t_gharardad"]['name'] != '' && isset($_POST['code_meli']) && $_POST['code_meli'] != '') {
                            $res = Helper::upload_file("r_t_gharardad", $_FILES, "moshtarakine_haghighi\\", $_POST['code_meli'], "tasvire_gharardad");
                            if ($res) {
                                $_POST['r_t_gharardad'] = $res;

                            } else {
                                unset($_POST['r_t_gharardad']);

                            }
                        } else {
                            unset($_POST['r_t_gharardad']);

                        }
                        if (isset($_FILES["r_t_sayer"]) && $_FILES["r_t_sayer"]['name'] != '' && isset($_POST['code_meli']) && $_POST['code_meli'] != '') {
                            $res = Helper::upload_file("r_t_sayer", $_FILES, "moshtarakine_haghighi\\", $_POST['code_meli'], "tasvire_sayer");
                            if ($res) {
                                $_POST['r_t_sayer'] = $res;
                            } else {
                                unset($_POST['r_t_sayer']);
                            }
                        } else {
                            unset($_POST['r_t_sayer']);
                        }
                        $_POST = Helper::xss_check_array($_POST);
                        if ($_POST['id'] == "empty") {
                            unset($_POST['id']);
                            $sql = Helper::Insert_Generator($_POST, 'bnm_presubscribers');
                            $res = Db::secure_insert_array($sql, $_POST);
                            if ($res) {
                                $id = (int) $res;
                                $sql_update = "UPDATE bnm_presubscribers SET code_eshterak=$id+1000 WHERE id='$id'";
                                $res_update = Db::justexecute($sql_update);
                                die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                            }else{
                                die(Helper::Json_Message('f'));
                            }
                        } else {
                            $res_sub = Helper::Select_By_Id('bnm_presubscribers', $_POST['id']);
                            if ($res_sub) {
                                $sql = Helper::Update_Generator($_POST, 'bnm_presubscribers', "WHERE id = :id");
                                $res = Db::secure_update_array($sql, $_POST);
                                die(Helper::Custom_Msg(Helper::Messages('s'), 1));

                            } else {
                                die(Helper::Json_Message('f'));
                            }

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
        
        // if(isset($_POST['confirmprerealsub'])){
        //     $subid=(int)$_POST['confirmprerealsub']['subid'];
        //     if(! $subid) die(Helper::Custom_Msg(Helper::Messages('pcae'),2));
        //     $sql="SELECT * FROM bnm_subscribers WHERE noe_moshtarak=? LIMIT 1";
        //     $ex=Db::secure_fetchall($sql, ['real']);
        //     if(! $ex) die(Helper::Custom_Msg(Helper::Messages('e'), 3));
        //     $structure=[];
        //     unset($ex[0]['id']);
        //     die(json_encode($ex));
        //     foreach ($ex as $k => $v) {
        //         $structure[]=$k;
                
        //     }
        //     die(json_encode($structure));
        //     // foreach ($ex as $k => $v) {
                
        //     // }
        // }
        if(isset($_POST['confirmprerealsub'])){
            $subid=(int)$_POST['confirmprerealsub']['subid'];
            // if(! $subid) die(Helper::Custom_Msg(Helper::Messages('pcae'),2));
            if(! $subid) die(Helper::Custom_Msg(Helper::Messages('pcae'),2));
            
            $sql="SELECT
            id,
            noe_moshtarak,
            NAME,
            f_name,
            name_pedar,
            jensiat,
            meliat,
            tabeiat,
            noe_shenase_hoviati,
            shomare_shenasname,
            tarikhe_tavalod,
            ostane_tavalod,
            shahre_tavalod,
            telephone1,
            telephone_hamrah,
            email,
            fax,
            website,
            code_posti1,
            code_posti2,
            code_posti3,
            address1,
            address2,
            address3,
            shoghl,
            nahve_ashnai,
            gorohe_moshtarak,
            moaref,
            tozihat,
            r_t_karte_meli,
            r_t_ghabze_telephone,
            r_t_ejare_malekiat,
            r_t_gharardad,
            r_t_sayer,
            name_sherkat,
            shomare_sabt,
            tarikhe_sabt,
            shomare_dakheli,
            code_eghtesadi,
            shenase_meli,
            name_pedare,
            reshteye_faaliat,
            l_t_agahie_tasis,
            l_t_akharin_taghirat,
            l_t_saheb_kartemeli_emzaye_aval,
            l_t_saheb_kartemeli_emzaye_dovom,
            l_t_kartemeli_namayande,
            l_t_moarefiname_namayande,
            l_t_ghabze_telephone,
            l_t_gharardad,
            l_t_ejarename_malekiat,
            l_t_sayer,
            telephone2,
            telephone3,
            code_meli,
            code_eshterak,
            branch_id,
            noe_malekiat1,
            noe_malekiat2,
            noe_malekiat3,
            name_malek1,
            name_malek2,
            name_malek3,
            f_name_malek1,
            f_name_malek2,
            f_name_malek3,
            code_meli_malek1,
            code_meli_malek2,
            code_meli_malek3,
            noe_sherkat,
            code_faragire_haghighi_pezhvak,
            tarikhe_sabte_sherkat,
            shenase_hoviati_sherkat,
            code_namayande_forosh,
            telephone_hamrahe_sherkat,
            noe_shenase_hoviati_sherkat,
            shahre_sokonat,
            ostane_sokonat,
            tarikhe_tavalod_namayande,
            code_pezhvak,
            meliat_namayande,
            tel1_ostan,
            tel2_ostan,
            tel3_ostan,
            tel1_shahr,
            tel2_shahr,
            tel3_shahr,
            tel1_street,
            tel2_street,
            tel3_street,
            tel1_street2,
            tel2_street2,
            tel3_street2,
            tel1_housenumber,
            tel2_housenumber,
            tel3_housenumber,
            tel1_tabaghe,
            tel2_tabaghe,
            tel3_tabaghe,
            tel1_vahed,
            tel2_vahed,
            tel3_vahed,
            tarikhe_sabtenam 
        FROM
            bnm_presubscribers s 
        WHERE
            s.id = ?
            AND s.noe_moshtarak =?
            AND ( s.NAME IS NOT NULL AND s.NAME <> '' ) 
            AND ( s.f_name IS NOT NULL AND s.NAME <> '' ) 
            AND ( s.code_meli IS NOT NULL AND s.code_meli <> '' ) 
            AND ( s.telephone_hamrah IS NOT NULL AND s.telephone_hamrah <> '' ) 
            AND ( s.branch_id IS NOT NULL) 
            AND ( s.code_meli_malek1 IS NOT NULL AND s.code_meli_malek1 <> '' ) 
            AND ( s.code_posti1 IS NOT NULL AND s.code_posti1 <> '' ) 
            AND ( s.jensiat IS NOT NULL AND s.jensiat <> '' ) 
            AND ( s.meliat IS NOT NULL AND s.meliat <> '' ) 
            AND ( s.tabeiat IS NOT NULL AND s.tabeiat <> '' ) 
            AND ( s.f_name_malek1 IS NOT NULL AND s.f_name_malek1 <> '' ) 
            AND ( s.name_pedar IS NOT NULL AND s.name_pedar <> '' ) 
            AND ( s.noe_shenase_hoviati IS NOT NULL) 
            AND ( s.noe_malekiat1 IS NOT NULL) 
            AND ( s.tarikhe_tavalod IS NOT NULL AND s.tarikhe_tavalod <> '' ) 
            AND ( s.telephone1 IS NOT NULL AND s.telephone1 <> '' ) 
            AND ( s.tel1_street IS NOT NULL AND s.tel1_street <> '' ) 
            AND (s.tel1_ostan IS NOT NULL AND s.tel1_ostan <> '')
            ";
            $pre=Db::secure_fetchall($sql, [$subid, 'real']);
            if(! $pre) die(Helper::Custom_Msg(Helper::Messages("اطلاعات مشترک ناقص است پس از بررسی مجددا تلاش کنید"), 2));
            unset($pre[0]['id']);
            $arr=$pre[0];
            $sql=Helper::Insert_Generator($arr, 'bnm_subscribers');
            $res = Db::secure_insert_array($sql, $arr);
            die(Helper::Custom_Msg(Helper::Messages('s'), 1));

        }
        $this->view->pagename = 'pre_internal_real_subscribers';
        $this->view->render('pre_internal_real_subscribers', 'dashboard_template', '/public/js/pre_internal_real_subscribers.js', false);

    }
}
