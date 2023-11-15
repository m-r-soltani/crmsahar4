<?php defined('__ROOT__') or exit('No direct script access allowed');

class Tax extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

        if (isset($_POST['send_tax'])) {
            if(Helper::Login_Just_Check()){
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                            unset($_POST['send_tax']);
                            $_POST = Helper::xss_check_array($_POST);
                            if ($_POST['id'] == "empty") {
                                unset($_POST['id']);
                                $sql = Helper::Insert_Generator($_POST, 'bnm_tax');
                                $res = Db::secure_insert_array($sql, $_POST);
                                if (!$res) {
                                    echo "<script>alert('عملیات ناموفق لطفا دوباره تلاش کنید.');</script>";
                                }
                            } else {
                                $sql = Helper::Update_Generator($_POST, 'bnm_tax', "WHERE id = :id");
                                Db::secure_update_array($sql, $_POST);
                            }
                        break;
                    
                    default:
                    echo Helper::Alert_Message('na');
                        break;
                }
                
            }else{
                echo Helper::Alert_Message('af');
                die();
            }
        }

//        $this->view->allUsers = R::findAll( 'bnm_users' );
        //        $this->view->title = 'کاربران';
        $this->view->pagename = 'tax';
        $this->view->render('tax', 'dashboard_template', '/public/js/tax.js', false);

    }
}
