<?php defined('__ROOT__') or exit('No direct script access allowed');

class Tdlte_Sim extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if (isset($_POST['send_tdlte_sim'])) {
            if (Helper::Login_Just_Check()) {
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                        unset($_POST['send_tdlte_sim']);
                        $_POST = Helper::xss_check_array($_POST);
                        $sql="SELECT count(*) row_nums FROM bnm_tdlte_sim WHERE tdlte_number=?";
                        $res=Db::secure_fetchall($sql,array($_POST['tdlte_number']));
                        
                        if ($_POST['id'] === "empty") {
                            if(Helper::check_add_access('tdlte_sim')){
                            if($res){
                                if($res[0]['row_nums']===0){
                                    unset($_POST['id']);
                                    unset($_POST['subscriber_id']);
                                    
                                    $_POST['tarikhe_sabt']=Helper::Today_Miladi_Date();
                                    $sql                  = Helper::Insert_Generator($_POST, 'bnm_tdlte_sim');
                                    $res                  = Db::secure_insert_array($sql, $_POST);
                                    $msg='این شماره قبلا ثبت شده!';
                                }else echo Helper::Custom_Msg($msg,2,false);
                            }else echo Helper::Alert_Message('f');
                        }else echo Helper:: Alert_Message('na');
                        } else {
                            if(Helper::check_update_access('tdlte_sim')){
                                if(Helper::Is_Empty_OR_Null($_POST['subscriber_id'])){
                                    $_POST['subscriber_id']=null;
                                }
                                unset($_POST['tarikhe_sabt']);
                                $sql = Helper::Update_Generator($_POST, 'bnm_tdlte_sim', "WHERE id = :id");
                                $res = Db::secure_update_array($sql, $_POST);
                            }else echo Helper:: Alert_Message('na');
                        }
                    
                        break;

                    default:
                        echo Helper::Alert_Message('na');
                        die();
                        break;
                }
            } else {
                echo Helper::Alert_Message('af');
                die();
            }
        }
//        $this->view->allUsers = R::findAll( 'bnm_users' );
        //        $this->view->title = 'کاربران';
        $this->view->home     = 'داشبورد';
        $this->view->page     = 'نمایندگی';
        $this->view->page_url = 'tdlte_sim';
        $this->view->pagename = 'tdlte_sim';
        $this->view->render('tdlte_sim', 'dashboard_template', '/public/js/tdlte_sim.js', false);

    }
}
