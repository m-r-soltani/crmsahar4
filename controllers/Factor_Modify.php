<?php defined('__ROOT__') or exit('No direct script access allowed');
class Factor_Modify extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if (isset($_POST['send_factor_modify'])) {
            if (Helper::Login_Just_Check()) {
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                        if (Helper::Is_Empty_OR_Null($_POST['factor_id']) && Helper::Is_Empty_OR_Null($_POST['noe_taghir'])) {
                            unset($_POST['send_factor_modify']);
                            $_POST = Helper::xss_check_array($_POST);
                            $sql1  = "SELECT * FROM bnm_factor WHERE id = ?";
                            $res1  = Db::secure_fetchall($sql1, array($_POST['factor_id']));
                            if ($res1) {
                                switch ($_POST['noe_taghir']) {
                                    case 'fishe_varizi':
                                        unset($_POST['noe_taghir']);
                                        unset($_POST['factor_id']);
                                        $_POST['id']                       = $res1[0]['id'];
                                        $_POST['modifier_id']              = $_SESSION['user_id'];
                                        $_POST['modifier_branch_id']       = $_SESSION['branch_id'];
                                        $_POST['modifier_username']        = $_SESSION['username'];
                                        $_POST['tarikhe_akharin_virayesh'] = date('Y-m-d');
                                        $_POST['tozihate_tasvie_shode']    = Helper::str_trim($_POST['tozihat']);
                                        $_POST['tarikhe_tasvie_shode']     = date('Y-m-d');
                                        $_POST['tasvie_konande']           = $_SESSION['name'];
                                        unset($_POST['tozihat']);
                                        $sql                               = Helper::Update_Generator($_POST, 'bnm_factor', "WHERE id = :id");
                                        $res                               = Db::secure_update_array($sql, $_POST);
                                        break;
                                    case 'marjo':
                                        unset($_POST['noe_taghir']);
                                        unset($_POST['factor_id']);
                                        $_POST['id']                       = $res1[0]['id'];
                                        $_POST['modifier_id']              = $_SESSION['user_id'];
                                        $_POST['modifier_branch_id']       = $_SESSION['branch_id'];
                                        $_POST['modifier_username']        = $_SESSION['username'];
                                        $_POST['tarikhe_akharin_virayesh'] = date('Y-m-d');
                                        $_POST['tozihate_marjo_shode']     = Helper::str_trim($_POST['tozihat']);
                                        $_POST['marjo_shode']              = '1';
                                        $_POST['tarikhe_marjo_shode']      = date('Y-m-d');
                                        $_POST['marjo_konande']            = $_SESSION['name'];
                                        unset($_POST['tozihat']);
                                        $sql                               = Helper::Update_Generator($_POST, 'bnm_factor', "WHERE id = :id");
                                        $res                               = Db::secure_update_array($sql, $_POST);
                                        break;
                                    case 'disable':
                                        unset($_POST['noe_taghir']);
                                        unset($_POST['factor_id']);
                                        // tozihate_disable_shode
                                        // disable_shode
                                        $_POST['id']                       = $res1[0]['id'];
                                        $_POST['modifier_id']              = $_SESSION['user_id'];
                                        $_POST['modifier_branch_id']       = $_SESSION['branch_id'];
                                        $_POST['modifier_username']        = $_SESSION['username'];
                                        $_POST['tarikhe_akharin_virayesh'] = date('Y-m-d');
                                        $_POST['tozihate_disable_shode']   = Helper::str_trim($_POST['tozihat']);
                                        $_POST['disable_shode']            = '1';
                                        $_POST['tarikhe_disable_shode']    = date('Y-m-d');
                                        $_POST['disable_konande']    = $_SESSION['name'];
                                        unset($_POST['tozihat']);
                                        $sql                               = Helper::Update_Generator($_POST, 'bnm_factor', "WHERE id = :id");
                                        $res                               = Db::secure_update_array($sql, $_POST);
                                        break;
                                    case 'ersal':
                                        unset($_POST['noe_taghir']);
                                        unset($_POST['factor_id']);
                                        unset($_POST['tozihat']);
                                        //ersal_shode
                                        $_POST['id']                       = $res1[0]['id'];
                                        $_POST['modifier_id']              = $_SESSION['user_id'];
                                        $_POST['modifier_branch_id']       = $_SESSION['branch_id'];
                                        $_POST['modifier_username']        = $_SESSION['username'];
                                        $_POST['tarikhe_akharin_virayesh'] = date('Y-m-d');
                                        $_POST['ersal_shode']              = '1';
                                        $sql                               = Helper::Update_Generator($_POST, 'bnm_factor', "WHERE id = :id");
                                        $res                               = Db::secure_update_array($sql, $_POST);
                                        break;

                                    default:
                                        die(Helper::Json_Message('fint'));
                                        break;
                                }

                            } else {
                                die('fint');
                            }

                        } else {
                            die(Helper::Json_Message('rinf'));
                        }

                        break;
                            case __MODIRUSERTYPE__:
                            case __OPERATORUSERTYPE__:
                            case __MODIR2USERTYPE__:
                            case __OPERATOR2USERTYPE__:
                        if (Helper::Is_Empty_OR_Null($_POST['factor_id']) && Helper::Is_Empty_OR_Null($_POST['noe_taghir'])) {
                            unset($_POST['send_factor_modify']);
                            $_POST = Helper::xss_check_array($_POST);
                            $sql1  = "SELECT * FROM bnm_factor WHERE id = ? AND branch_id=?";
                            $res1  = Db::secure_fetchall($sql1, array($_POST['factor_id'], $_SESSION['branch_id']));
                            if ($res1) {
                                switch ($_POST['noe_taghir']) {
                                    case 'fishe_varizi':
                                        unset($_POST['noe_taghir']);
                                        unset($_POST['factor_id']);
                                        $_POST['id']                       = $res1[0]['id'];
                                        $_POST['modifier_id']              = $_SESSION['user_id'];
                                        $_POST['modifier_branch_id']       = $_SESSION['branch_id'];
                                        $_POST['modifier_username']        = $_SESSION['username'];
                                        $_POST['tarikhe_akharin_virayesh'] = date('Y-m-d');
                                        $_POST['tozihate_tasvie_shode']    = Helper::str_trim($_POST['tozihat']);
                                        unset($_POST['tozihat']);
                                        $sql                               = Helper::Update_Generator($_POST, 'bnm_factor', "WHERE id = :id");
                                        $res                               = Db::secure_update_array($sql, $_POST);
                                        break;
                                    case 'marjo':
                                        unset($_POST['noe_taghir']);
                                        unset($_POST['factor_id']);
                                        // tozihate_marjo_shode
                                        //marjo_shode
                                        $_POST['id']                       = $res1[0]['id'];
                                        $_POST['modifier_id']              = $_SESSION['user_id'];
                                        $_POST['modifier_branch_id']       = $_SESSION['branch_id'];
                                        $_POST['modifier_username']        = $_SESSION['username'];
                                        $_POST['tarikhe_akharin_virayesh'] = date('Y-m-d');
                                        $_POST['tozihate_marjo_shode']     = Helper::str_trim($_POST['tozihat']);
                                        $_POST['marjo_shode']              = '1';
                                        unset($_POST['tozihat']);
                                        $sql                               = Helper::Update_Generator($_POST, 'bnm_factor', "WHERE id = :id");
                                        $res                               = Db::secure_update_array($sql, $_POST);
                                        break;
                                    case 'disable':
                                        unset($_POST['noe_taghir']);
                                        unset($_POST['factor_id']);
                                        // tozihate_disable_shode
                                        // disable_shode
                                        $_POST['id']                       = $res1[0]['id'];
                                        $_POST['modifier_id']              = $_SESSION['user_id'];
                                        $_POST['modifier_branch_id']       = $_SESSION['branch_id'];
                                        $_POST['modifier_username']        = $_SESSION['username'];
                                        $_POST['tarikhe_akharin_virayesh'] = date('Y-m-d');
                                        $_POST['tozihate_disable_shode']   = Helper::str_trim($_POST['tozihat']);
                                        $_POST['disable_shode']            = '1';
                                        unset($_POST['tozihat']);
                                        $sql                               = Helper::Update_Generator($_POST, 'bnm_factor', "WHERE id = :id");
                                        $res                               = Db::secure_update_array($sql, $_POST);
                                        break;
                                    case 'ersal':
                                        unset($_POST['noe_taghir']);
                                        unset($_POST['factor_id']);
                                        unset($_POST['tozihat']);
                                        //ersal_shode
                                        $_POST['id']                       = $res1[0]['id'];
                                        $_POST['modifier_id']              = $_SESSION['user_id'];
                                        $_POST['modifier_branch_id']       = $_SESSION['branch_id'];
                                        $_POST['modifier_username']        = $_SESSION['username'];
                                        $_POST['tarikhe_akharin_virayesh'] = date('Y-m-d');
                                        $_POST['ersal_shode']              = '1';
                                        $sql                               = Helper::Update_Generator($_POST, 'bnm_factor', "WHERE id = :id");
                                        $res                               = Db::secure_update_array($sql, $_POST);
                                        break;

                                    default:
                                        die(Helper::Json_Message('fint'));
                                        break;
                                }

                            } else {
                                die('fint');
                            }

                        } else {
                            die(Helper::Json_Message('rinf'));
                        }

                        break;

                    default:
                        die(Helper::Json_Message('af'));
                        break;
                }
            } else {
                die(Helper::Json_Message('af'));
            }

        }
        $this->view->pagename = 'factor_modify';
        $this->view->render('factor_modify', 'dashboard_template', '/public/js/factor_modify.js', false);
    }
}
