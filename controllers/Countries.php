<?php defined('__ROOT__') or exit('No direct script access allowed');

class Countries extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

        if (isset($_POST['send_countries'])) {
            // header("Location:".__ROOT__.'countries');
            switch ($_SESSION['user_type']) {
                case __ADMINUSERTYPE__:
                case __ADMINOPERATORUSERTYPE__:
                    unset($_POST['send_countries']);
                    $_POST = Helper::xss_check_array($_POST);
                    if ($_POST['id'] == "empty") {
                        if(Helper::check_add_access('countries')){
                            unset($_POST['id']);
                            $sql = Helper::Insert_Generator($_POST, 'bnm_countries');
                            $res = Db::secure_insert_array($sql, $_POST);
                            if (!$res) {
                                echo Helper::Alert_Message('f');

                            }
                        } else echo Helper::Alert_Message('na');
                    } else {
                        if(Helper::check_update_access('countries')){
                            $sql = Helper::Update_Generator($_POST, 'bnm_countries', "WHERE id = :id");
                            $res=Db::secure_update_array($sql, $_POST);
                        } else echo Helper::Alert_Message('na');
                    }
                    break;

                default:
                    echo Helper::Alert_Message('na');
                    break;
            }

        }
        $this->view->home     = 'داشبورد';
        $this->view->page     = 'کشورها';
        $this->view->page_url = 'countries';
        $this->view->pagename = 'countries';
        $this->view->render('countries', 'dashboard_template', '/public/js/countries.js', false);

    }
}
