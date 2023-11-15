<?php defined('__ROOT__') or exit('No direct script access allowed');

class Equipments_Brands extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

        if (isset($_POST['send_equipments_brands'])) {
            // header("Location:".__ROOT__.'equipments_brands');
            switch ($_SESSION['user_type']) {
                case __ADMINUSERTYPE__:
                case __ADMINOPERATORUSERTYPE__:
                    unset($_POST['send_equipments_brands']);
                    $_POST = Helper::xss_check_array($_POST);
                    if ($_POST['id'] == "empty") {
                        if(Helper::check_add_access('equipments_brands')){
                            unset($_POST['id']);
                            $sql = Helper::Insert_Generator($_POST, 'bnm_equipments_brands');
                            $res = Db::secure_insert_array($sql, $_POST);
                            if (!$res) {
                                echo Helper::Alert_Message('f');
                            }
                        } else echo Helper::Alert_Message('na');
                    } else {
                        if(Helper::check_update_access('equipments_brands')){
                            $sql = Helper::Update_Generator($_POST, 'bnm_equipments_brands', "WHERE id = :id");
                            $res=Db::secure_update_array($sql, $_POST);
                        } else echo Helper::Alert_Message('na');
                    }
                    break;
                default:
                    echo Helper::Alert_Message('na');
                    break;
            }

        }
//        $this->view->allUsers = R::findAll( 'bnm_users' );
        //        $this->view->title = 'کاربران';
        $this->view->pagename = 'equipments_brands';
        $this->view->render('equipments_brands', 'dashboard_template', '/public/js/equipments_brands.js', false);

    }
}
