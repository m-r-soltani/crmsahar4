<?php defined('__ROOT__') OR exit('No direct script access allowed');

class Organization_Level extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        /*========levels========*/
        if (isset($_POST['send_organization_level'])) {
            if (Helper::Login_Just_Check()) {
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                        try {
                            unset($_POST['send_organization_level']);
                            $_POST = Helper::xss_check_array($_POST);
                            if ($_POST['id'] == "empty") {
                                if(Helper::check_add_access('organization_level')){
                                    unset($_POST['id']);
                                    $sql = Helper::Insert_Generator($_POST, 'bnm_organization_level');
                                    Db::secure_insert_array($sql, $_POST);
                                }else echo Helper::Alert_Message('na');
                            } else {
                                if(Helper::check_update_access('organization_level')){
                                $sql = Helper::Update_Generator($_POST, 'bnm_organization_level', "WHERE id = :id");
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
//		$this->view->allUsers = R::findAll( 'bnm_users' );
//		$this->view->title = 'کاربران';
        $this->view->pagename='organization_level';
        $this->view->render('organization_level','dashboard_template','/public/js/organization_level.js',false);

    }
}
