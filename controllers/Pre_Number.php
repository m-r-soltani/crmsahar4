<?php defined('__ROOT__') or exit('No direct script access allowed');

class Pre_Number extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if (isset($_POST['send_pre_number'])) {
            // $_POST = Helper::Create_Post_Array_Without_Key($_POST);
            parse_str($_POST[key($_POST)], $_POST);
            $_POST = Helper::xss_check_array($_POST);
            if(! Helper::allArrayElementsHasValue($_POST)) {
                die(Helper::Json_Message('f'));
            }
            // die(json_encode($_POST));
            // unset($_POST['send_pre_number']);
            if ($_POST['id'] == "empty") {
                if(Helper::check_add_access('pre_number')){
                    unset($_POST['id']);
                    $sql = Helper::Insert_Generator($_POST, 'bnm_pre_number');
                    $res = Db::secure_insert_array($sql, $_POST);
                }else die(Helper::Json_Message('na'));
            }else{
                if(Helper::check_update_access('pre_number')){
                $sql = Helper::Update_Generator($_POST, 'bnm_pre_number', "WHERE id = :id");
                $res = Db::secure_update_array($sql, $_POST);
                }else die(Helper::Json_Message('na'));
            }
            if($res){
                die(Helper::Custom_Msg(Helper::Messages('s'),1));
            }else{
                die(Helper::Custom_Msg(Helper::Messages('f'),3));
            }
        }
//        $this->view->allUsers = R::findAll( 'bnm_users' );
        //        $this->view->title = 'کاربران';
        $this->view->home     = 'داشبورد';
        $this->view->page     = 'نمایندگی';
        $this->view->page_url = 'pre_number';
        $this->view->pagename = 'pre_number';
        $this->view->render('pre_number', 'dashboard_template', '/public/js/pre_number.js', false);

    }
}
