<?php defined('__ROOT__') or exit('No direct script access allowed');

class Banks extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        /*========banks========*/
        if (isset($_POST['send_bank'])) {
            unset($_POST['send_bank']);
            if (Helper::Login_Just_Check()) {
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                    case __MODIRUSERTYPE__:
                    case __OPERATORUSERTYPE__:
                    case __MODIR2USERTYPE__:
                    case __OPERATOR2USERTYPE__:
                        
                        $_POST = Helper::xss_check_array($_POST);
                        if (Helper::Is_Empty_OR_Null($_POST['name'])) {
                            if ($_POST['id'] === "empty") {
                                unset($_POST['id']);
                                if(Helper::check_add_access('Banks')){
                                $sql = Helper::Insert_Generator($_POST, 'bnm_banks');
                                $res = Db::secure_insert_array($sql, $_POST);
                                } else echo Helper::Alert_Message('na');

                            } else {
                                if(Helper::check_update_access('Banks')){
                                $sql = Helper::Update_Generator($_POST, 'bnm_banks', 'id= :id');
                                $res = Db::secure_update_array($sql, $_POST);
                                } else echo Helper::Alert_Message('na');
                            }
                        } else {
                            echo Helper::Alert_Message('f');
                        }

                        break;

                    default:
                        echo Helper::Alert_Message('na');
                        break;
                }

            } else {
                echo Helper::Alert_Message('af');
            }

        }
        $this->view->pagename = 'banks';
        $this->view->render('banks', 'dashboard_template', '/public/js/banks.js', false);

    }
}
