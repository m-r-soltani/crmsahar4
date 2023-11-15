<?php defined('__ROOT__') or exit('No direct script access allowed');

class Province extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

        if (isset($_POST['send_province'])) {
            // header("Location:".__ROOT__.'province');
            switch ($_SESSION['user_type']) {
                case __ADMINUSERTYPE__:
                case __ADMINOPERATORUSERTYPE__:
                    unset($_POST['send_province']);
                    $_POST = Helper::xss_check_array($_POST);

                    if ($_POST['id'] == "empty") {
                        if(Helper::check_add_access('province')){
                        unset($_POST['id']);
                        $sql = Helper::Insert_Generator($_POST, 'bnm_ostan');
                        $res = Db::secure_insert_array($sql, $_POST);
                        if (!$res) {
                            echo Helper::Alert_Message('f');

                        }
                    } else echo Helper::Alert_Message('na');
                    } else {
                        if(Helper::check_update_access('province')){
                        $sql = Helper::Update_Generator($_POST, 'bnm_ostan', "WHERE id = :id");
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
        $this->view->pagename = 'province';
        $this->view->render('province', 'dashboard_template', '/public/js/province.js', false);

    }
}
