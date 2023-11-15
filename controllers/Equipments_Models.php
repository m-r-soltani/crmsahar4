<?php defined('__ROOT__') or exit('No direct script access allowed');
class Equipments_Models extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        /*========sabte equipments_models========*/
        if (isset($_POST['send_equipments_models'])) {
            if (Helper::Login_Just_Check()) {
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                        try {
                            unset($_POST['send_equipments_models']);
                            $_POST = Helper::xss_check_array($_POST);
                            if (isset($_POST['exdate'])) {
                                $date_arr = array();
                                $date_arr = explode("/", $_POST['exdate']);
                                if (count($date_arr) > 2) {
                                    $year                  = (int) Helper::convert_numbers($date_arr[0], false);
                                    $month                 = (int) Helper::convert_numbers($date_arr[1], false);
                                    $day                   = (int) Helper::convert_numbers($date_arr[2], false);
                                    $_POST['exdate'] = Helper::jalali_to_gregorian($year, $month, $day, '/');
                                }
                            }
                            //check exdate before query
                            if ($_POST['id'] === "empty") {
                                unset($_POST['id']);
                                if(Helper::check_add_access('equipments_models')){
                                    $sql = Helper::Insert_Generator($_POST, 'bnm_equipments_models');
                                    Db::secure_insert_array($sql, $_POST);
                                } else echo Helper::Alert_Message('na');
                            } else {
                                if(Helper::check_update_access('equipments_models')){
                                $sql = Helper::Update_Generator($_POST, 'bnm_equipments_models', "WHERE id = :id");
                                Db::secure_update_array($sql, $_POST);
                                } else echo Helper::Alert_Message('na');
                            }
                            
                        } catch (Throwable $e) {
                            $res = Helper::Exc_Error_Debug($e, true, '', true);
                            die();
                        }
                        break;

                    default:
                        echo Helper::Alert_Message('na');
                        break;
                }

            }
        }

        $this->view->pagename = 'equipments_models';
        $this->view->render('equipments_models', 'dashboard_template', '/public/js/equipments_models.js', false);
    }
}
