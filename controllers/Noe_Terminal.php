<?php defined('__ROOT__') or exit('No direct script access allowed');

class Noe_Terminal extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if (isset($_POST['send_noe_terminal'])) {
            if (Helper::Login_Just_Check()) {
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                        try {
                            unset($_POST['send_noe_terminal']);
                            $_POST = Helper::xss_check_array($_POST);
                            if ($_POST['id'] == "empty") {
                                if(Helper::check_add_access('noe_terminal')){
                                unset($_POST['id']);
                                $sql = Helper::Insert_Generator($_POST, 'bnm_noe_terminal');
                                $res = Db::secure_insert_array($sql, $_POST);
                                if(!$res){
                                    die('fuck');
                                }
                            }else echo Helper::Alert_Message('na');
                            } else {
                                if(Helper::check_update_access('noe_terminal')){
                                $sql = Helper::Update_Generator($_POST, 'bnm_noe_terminal', "WHERE id = :id");
                                Db::secure_update_array($sql, $_POST);
                                }else echo Helper::Alert_Message('na');
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

        $this->view->home     = 'داشبورد';
        $this->view->page     = 'نمایندگی';
        $this->view->page_url = 'noe_terminal';
        $this->view->pagename = 'noe_terminal';
        $this->view->render('noe_terminal', 'dashboard_template', '/public/js/noe_terminal.js', false);
    }
}
