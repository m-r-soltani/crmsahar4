<?php defined('__ROOT__') or exit('No direct script access allowed');

class Terminal extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        /*========sabte terminal========*/
        if (isset($_POST['send_terminal'])) {
            parse_str($_POST[key($_POST)], $_POST);
            $_POST = Helper::xss_check_array($_POST);
            unset($_POST['send_terminal']);
            switch ($_SESSION['user_type']) {
                case __ADMINUSERTYPE__:
                case __ADMINOPERATORUSERTYPE__:
                    unset($_POST['send_terminal']);
                    $_POST = Helper::xss_check_array($_POST);
                    if ($_POST['id'] == "empty") {
                        if(Helper::check_add_access('terminal')){
                        unset($_POST['id']);
                        $sql = Helper::Insert_Generator($_POST, 'bnm_terminal');
                        $res = Db::secure_insert_array($sql, $_POST);
                        // $sql = Insert_Generator($_POST, 'bnm_terminal');
                        // $res = Db::justexecute($sql);
                        if ($res) {
                            // $sql2     = "SELECT LAST_INSERT_ID() FROM bnm_terminal";
                            // $res2     = Db::fetchall_Query($sql2);
                            $id       = (int)$res;
                            $sql3     = "SELECT * FROM bnm_terminal WHERE id ='$id'";
                            $terminal = Db::fetchall_Query($sql3);
                            if ($terminal) {
                                $terminal_type_id = $terminal[0]['noe_terminal'];
                                $sql4             = "SELECT * FROM bnm_noe_terminal WHERE id='$terminal_type_id'";
                                $noe_terminal     = Db::fetchall_Query($sql4);
                                $port             = array();
                                if ($noe_terminal) {
                                    if ($noe_terminal[0]['tartibe_ranzhe'] == 'zoj') {
                                        $tedade_port    = (int) $noe_terminal[0]['tedade_port'];
                                        $shoroe_etesali = (int) $terminal[0]['shoroe_etesali'];
                                        for ($i = $shoroe_etesali; $i < $tedade_port + $shoroe_etesali; $i++) {
                                            if ($i % 2 == 0) {
                                                $port[$i]['terminal']            = $terminal[0]['id'];
                                                $port[$i]['etesal']              = $i;
                                                $port[$i]['tighe']               = $terminal[0]['tighe'];
                                                $port[$i]['port']                = '';
                                                $port[$i]['ostan']               = $terminal[0]['ostan'];
                                                $port[$i]['shahr']               = $terminal[0]['shahr'];
                                                $port[$i]['markaze_mokhaberati'] = $terminal[0]['markaze_mokhaberati'];
                                                $port[$i]['kart']                = '';
                                                $port[$i]['dslam']               = '';
                                                $port[$i]['telephone']           = '';
                                                $port[$i]['adsl_vdsl']           = 'adsl';
                                                $port[$i]['status']              = 'salem';
                                                $port[$i]['radif']               = $terminal[0]['radif'];
                                            }
                                        }

                                        $port = array_values($port);

                                        //////////////////////insert to bnm_port////////////////
                                        for ($i = 0; $i < count($port); $i++) {
                                            $port_terminal            = $port[$i]['terminal'];
                                            $port_etesal              = $port[$i]['etesal'];
                                            $port_tighe               = $port[$i]['tighe'];
                                            $port_port                = $port[$i]['port'];
                                            $port_kart                = $port[$i]['kart'];
                                            $port_dslam               = $port[$i]['dslam'];
                                            $port_telephone           = $port[$i]['telephone'];
                                            $port_adsl_vdsl           = $port[$i]['adsl_vdsl'];
                                            $port_status              = $port[$i]['status'];
                                            $port_radif               = $port[$i]['radif'];
                                            $port_ostan               = $port[$i]['ostan'];
                                            $port_shahr               = $port[$i]['shahr'];
                                            $port_markaze_mokhaberati = $port[$i]['markaze_mokhaberati'];
                                            $port_sql                 = "INSERT INTO bnm_port
                                            (terminal,etesal,tighe,port,kart,dslam,telephone,adsl_vdsl,status,radif,ostan,shahr,markaze_mokhaberati)
                                            VALUES
                                            ('$port_terminal','$port_etesal','$port_tighe','$port_port','$port_kart','$port_dslam',
                                            '$port_telephone','$port_adsl_vdsl','$port_status','$port_radif','$port_ostan','$port_shahr','$port_markaze_mokhaberati')";
                                            Db::justexecute($port_sql);
                                        }
                                    } elseif ($noe_terminal[0]['tartibe_ranzhe'] == 'fard') {
                                        $tedade_port    = (int) $noe_terminal[0]['tedade_port'];
                                        $shoroe_etesali = (int) $terminal[0]['shoroe_etesali'];
                                        for ($i = $shoroe_etesali; $i < $tedade_port + $shoroe_etesali; $i++) {
                                            if ($i % 2 != 0) {
                                                $port[$i]['terminal']            = $terminal[0]['id'];
                                                $port[$i]['etesal']              = $i;
                                                $port[$i]['tighe']               = $terminal[0]['tighe'];
                                                $port[$i]['port']                = '';
                                                $port[$i]['ostan']               = $terminal[0]['ostan'];
                                                $port[$i]['shahr']               = $terminal[0]['shahr'];
                                                $port[$i]['markaze_mokhaberati'] = $terminal[0]['markaze_mokhaberati'];
                                                $port[$i]['kart']                = '';
                                                $port[$i]['dslam']               = '';
                                                $port[$i]['telephone']           = '';
                                                $port[$i]['adsl_vdsl']           = 'adsl';
                                                $port[$i]['status']              = 'salem';
                                                $port[$i]['radif']               = $terminal[0]['radif'];
                                            }
                                        }
                                        $port = array_values($port);
                                        //////////////////////insert to bnm_port////////////////
                                        for ($i = 0; $i < count($port); $i++) {
                                            $port_terminal            = $port[$i]['terminal'];
                                            $port_etesal              = $port[$i]['etesal'];
                                            $port_tighe               = $port[$i]['tighe'];
                                            $port_port                = $port[$i]['port'];
                                            $port_kart                = $port[$i]['kart'];
                                            $port_dslam               = $port[$i]['dslam'];
                                            $port_telephone           = $port[$i]['telephone'];
                                            $port_adsl_vdsl           = $port[$i]['adsl_vdsl'];
                                            $port_status              = $port[$i]['status'];
                                            $port_radif               = $port[$i]['radif'];
                                            $port_ostan               = $port[$i]['ostan'];
                                            $port_shahr               = $port[$i]['shahr'];
                                            $port_markaze_mokhaberati = $port[$i]['markaze_mokhaberati'];
                                            $port_sql                 = "INSERT INTO bnm_port (terminal,etesal,tighe,port,kart,dslam,
                                        telephone,adsl_vdsl,status,radif,ostan,shahr,markaze_mokhaberati) VALUES ('$port_terminal','$port_etesal','$port_tighe','$port_port',
                                        '$port_kart','$port_dslam','$port_telephone','$port_adsl_vdsl','$port_status','$port_radif','$port_ostan','$port_shahr','$port_markaze_mokhaberati')";
                                            Db::justexecute($port_sql);
                                        }
                                    } else {
                                        $tedade_port    = (int) $noe_terminal[0]['tedade_port'];
                                        $shoroe_etesali = (int) $terminal[0]['shoroe_etesali'];
                                        for ($i = $shoroe_etesali; $i < $tedade_port + $shoroe_etesali; $i++) {

                                            $port[$i]['terminal']            = $terminal[0]['id'];
                                            $port[$i]['etesal']              = $i;
                                            $port[$i]['tighe']               = $terminal[0]['tighe'];
                                            $port[$i]['port']                = '';
                                            $port[$i]['kart']                = '';
                                            $port[$i]['dslam']               = '';
                                            $port[$i]['telephone']           = '';
                                            $port[$i]['adsl_vdsl']           = 'adsl';
                                            $port[$i]['status']              = 'salem';
                                            $port[$i]['radif']               = $terminal[0]['radif'];
                                            $port[$i]['ostan']               = $terminal[0]['ostan'];
                                            $port[$i]['shahr']               = $terminal[0]['shahr'];
                                            $port[$i]['markaze_mokhaberati'] = $terminal[0]['markaze_mokhaberati'];
                                        }

                                        $port = array_values($port);
                                        //////////////////////insert to bnm_port////////////////
                                        for ($i = 0; $i < count($port); $i++) {
                                            $port_terminal            = $port[$i]['terminal'];
                                            $port_etesal              = $port[$i]['etesal'];
                                            $port_tighe               = $port[$i]['tighe'];
                                            $port_port                = $port[$i]['port'];
                                            $port_kart                = $port[$i]['kart'];
                                            $port_dslam               = $port[$i]['dslam'];
                                            $port_telephone           = $port[$i]['telephone'];
                                            $port_adsl_vdsl           = $port[$i]['adsl_vdsl'];
                                            $port_status              = $port[$i]['status'];
                                            $port_radif               = $port[$i]['radif'];
                                            $port_ostan               = $port[$i]['ostan'];
                                            $port_shahr               = $port[$i]['shahr'];
                                            $port_markaze_mokhaberati = $port[$i]['markaze_mokhaberati'];
                                            $port_sql                 = "INSERT INTO bnm_port (terminal,etesal,tighe,port,kart,dslam,
                                        telephone,adsl_vdsl,status,radif,ostan,shahr,markaze_mokhaberati) VALUES ('$port_terminal','$port_etesal','$port_tighe','$port_port','$port_kart',
                                        '$port_dslam','$port_telephone','$port_adsl_vdsl','$port_status','$port_radif','$port_ostan','$port_shahr','$port_markaze_mokhaberati')";
                                            Db::justexecute($port_sql);
                                        }
                                    }
                                }
                            }
                        }
                        }else echo Helper:: Alert_Message('na');
                    } else {
                        if(Helper::check_update_access('terminal')){
                        $sql = Helper::Update_Generator($_POST, 'bnm_terminal', "WHERE id = :id");
                        Db::secure_update_array($sql, $_POST);
                        }else echo Helper:: Alert_Message('na');
                    }
                            break;
                        default:
                            echo Helper::Alert_Message('af');
                            break;
                    }
            
        }

//        $this->view->allUsers = R::findAll( 'bnm_users' );
        //        $this->view->title = 'کاربران';
        $this->view->pagename = 'terminal';
        $this->view->render('terminal', 'dashboard_template', '/public/js/terminal.js', false);

    }
}
