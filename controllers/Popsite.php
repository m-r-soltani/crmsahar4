<?php defined('__ROOT__') OR exit('No direct script access allowed');

class Popsite extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        /*========popsite========*/
        if (isset($_POST['send_popsite'])) {
            parse_str($_POST[key($_POST)], $_POST);
            $_POST = Helper::xss_check_array($_POST);
            switch ($_SESSION['user_type']) {
                case __ADMINUSERTYPE__:
                case __ADMINOPERATORUSERTYPE__:
                case __MODIRUSERTYPE__:
                case __OPERATORUSERTYPE__:
                case __MODIR2USERTYPE__:
                case __OPERATOR2USERTYPE__:
                        if ($_POST['id'] === "empty") {
                            if(Helper::check_add_access('popsite')){
                                unset($_POST['id']);
                                if(Helper::check_add_access('popsite')){
                                    $sql    = Helper::Insert_Generator($_POST, 'bnm_popsite');
                                    $res    = Db::secure_insert_array($sql,$_POST);
                                    if($res){
                                        die(Helper::Custom_Msg(Helper::Messages('s'),1));
                                    }else{
                                        die(Helper::Custom_Msg(Helper::Messages('f'),2));
                                    }
                                }else die(Helper::Custom_Msg(Helper::Messages('na'),3));
                            } else die(Helper::Custom_Msg(Helper::Messages('na'),3));
                        } else {
                            if(Helper::check_update_access('operator')){
                                $sql = Helper::Update_Generator($_POST, 'bnm_popsite', "WHERE id = :id");
                                $res = Db::secure_update_array($sql,$_POST);
                                if($res){
                                    die(Helper::Custom_Msg(Helper::Messages('s'),1));
                                }else{
                                    die(Helper::Custom_Msg(Helper::Messages('f'),2));
                                }
                            } else die(Helper::Custom_Msg(Helper::Messages('s'),1));
                        }
                    break;
                
                default:
                    die(Helper::Custom_Msg(Helper::Messages('na'),3));
                break;
            }
            
        }
//		$this->view->allUsers = R::findAll( 'bnm_users' );
//		$this->view->title = 'کاربران';
        $this->view->pagename='popsite';
        $this->view->render('popsite','dashboard_template','/public/js/popsite.js',false);

    }
}
