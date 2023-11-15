<?php defined('__ROOT__') OR exit('No direct script access allowed');

class Host extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
                /*========sabte host========*/
                // if (isset($_POST['send_host'])) {
                //     if (isset($_FILES["t_logo"]) && $_FILES["t_logo"]['name']!='' && isset($_POST['shomare_mojavez']) && $_POST['shomare_mojavez']!='') {
                //         $res = Helper::upload_file($_FILES, "mizbanha\\", $_POST['shomare_mojavez'], "tasvire_logo");
                //         if ($res) {
                //             $_POST['t_logo'] = $res;
                //         }
                //     } else {
                //         $_POST['t_logo'] = null;                        
                //     }
                //     if ($_POST['id'] == "empty") {
                //         unset($_POST['send_host']);
                //         $_POST['send_host'] = '';
                //         $sql = Insert_Generator($_POST, 'bnm_host');
                //         Db::justexecute($sql);
                //     } else {
                //         $id  = $_POST['id'];
                //         unset($_POST['send_host']);
                //         $_POST['send_host'] = '';
                //         $sql = Update_Generator($_POST, 'bnm_host', "WHERE id = $id", array("t_logo"));
                //         Db::justexecute($sql);
                //     }
                // }
                
                if (isset($_POST['send_host'])) {
                    if(Helper::Login_Just_Check()){
                        unset($_POST['send_host']);
                        if (isset($_FILES["t_logo"]) && $_FILES["t_logo"]['name']!='' && isset($_POST['shomare_mojavez']) && $_POST['shomare_mojavez']!='') {
                            $res = Helper::upload_file("t_logo",$_FILES, "mizbanha\\", $_POST['shomare_mojavez'], "tasvire_logo");
                            if ($res) {
                                $_POST['t_logo'] = $res;
                            }
                        } else {
                            unset($_POST['t_logo']);
                        }
                        
                        $_POST=Helper::xss_check_array($_POST);
                        if ($_POST['id'] == "empty") {
                            unset($_POST['id']);
                            $sql = Helper::Insert_Generator($_POST, 'bnm_host');
                            Db::secure_insert_array($sql,$_POST);
                        } else {
                            $sql = Helper::Update_Generator($_POST, 'bnm_host', "WHERE id = :id");
                            Db::secure_update_array($sql,$_POST);
                        }
                    }else echo Helper::Alert_Message('af');
                }
//		$this->view->allUsers = R::findAll( 'bnm_users' );
//		$this->view->title = 'کاربران';
        $this->view->pagename='host';
        $this->view->render('host','dashboard_template','/public/js/host.js',false);

    }
}
