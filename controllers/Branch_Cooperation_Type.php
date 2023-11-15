<?php defined('__ROOT__') OR exit('No direct script access allowed');

class Branch_Cooperation_Type extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if (isset($_POST['send_branch_cooperation_type'])) {
            if(Helper::Login_Just_Check()){
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                        unset($_POST['send_branch_cooperation_type']);
                        $sql1="SELECT id,noe_khadamat,type FROM bnm_services WHERE id = ?";
                        $res1=Db::secure_fetchall($sql1,array($_POST['service_type']),true);
                        if($res1){
                            $_POST['service_id']            =$res1[0]['id'];
                            $_POST['service_type']          =$res1[0]['noe_khadamat'];
                            $_POST=Helper::xss_check_array($_POST);
                            if ($_POST['id'] === "empty") {
                                unset($_POST['id']);
                                $sql = Helper::Insert_Generator($_POST, 'bnm_branch_cooperation_type');
                                $res=Db::secure_insert_array($sql,$_POST);
                                if(!$res){
                                    echo Helper::Alert_Message('f');
                                    die();
                                }              
                            } else {
                                $sql = Helper::Update_Generator($_POST, 'bnm_branch_cooperation_type', "WHERE id = :id");    
                                Db::secure_update_array($sql,$_POST);
                            }
                        }else{
                            echo Helper::Alert_Message('f');
                            die();
                        }
                        break;
                    default:
                        echo Helper::Alert_Message('na');
                        die();
                        break;
                }
                
            }
        }
//		$this->view->allUsers = R::findAll( 'bnm_users' );
//		$this->view->title = 'کاربران';
        $this->view->home='داشبورد';
        $this->view->pagename_fa='نمایندگی-نوع همکاری';
        $this->view->page_url='branch_cooperation_type';
        $this->view->pagename_en='branch_cooperation_type';
        $this->view->render('branch_cooperation_type','dashboard_template','/public/js/branch_cooperation_type.js',false);
    }
}
