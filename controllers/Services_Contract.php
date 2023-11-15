<?php defined('__ROOT__') or exit('No direct script access allowed');
class Services_Contract extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        /*========sabte shahr========*/
        if (isset($_POST['send_services_contract'])) {
            switch ($_SESSION['user_type']) {
                case __ADMINUSERTYPE__:
                case __ADMINOPERATORUSERTYPE__:
                    try {
                        parse_str($_POST[key($_POST)], $_POST);
                        unset($_POST['send_services_contract']);
                        // $_POST = Helper::xss_check_array($_POST);

                        if ($_POST['id'] == "empty") {
                            if (Helper::check_add_access('services_contract')) {
                                unset($_POST['id']);
                                $sql = Helper::Insert_Generator($_POST, 'bnm_services_contract');
                                $res = Db::secure_insert_array($sql, $_POST);
                                if ($res) {
                                    die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                                } else {
                                    die(Helper::Custom_Msg(Helper::Messages('f'), 3));
                                }
                            } else {
                                die(Helper::Custom_Msg(Helper::Messages('na'), 3));
                            }
                            // header(\)
                        } else {
                            if (Helper::check_update_access('services_contract')) {
                                $sql = Helper::Update_Generator($_POST, 'bnm_services_contract', "WHERE id = :id");
                                $res = Db::secure_update_array($sql, $_POST);
                                if ($res) {
                                    die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                                } else {
                                    die(Helper::Custom_Msg(Helper::Messages('f'), 3));
                                }
                            } else {
                                die(Helper::Custom_Msg(Helper::Messages('na'), 3));
                            }
                        }
                    } catch (Throwable $e) {
                        $res = Helper::Exc_Error_Debug($e, true, '', true);
                        die(json_encode($res));
                    }
                    break;
                default:
                    die(Helper::Custom_Msg(Helper::Messages('af'), 3));
                    break;
            }

        }

        $this->view->pagename = 'services_contract';
        $this->view->render('services_contract', 'dashboard_template', '/public/js/services_contract.js', '/public/js/plugins/editors/tinymcefree/tinymce.min.js');
    }
}
