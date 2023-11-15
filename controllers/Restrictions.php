<?php defined('__ROOT__') or exit('No direct script access allowed');

class Restrictions extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if (isset($_POST['send_restrictions'])) {
            //$_POST=$_POST['send_restrictions'];
            // $_POST  = Helper::Create_Post_Array_Without_Key($_POST);
            // $_POST  = Helper::xss_check_array($_POST);
            unset($_POST['send_restrictions']);
            // die(json_encode($_POST));
            if (Helper::Login_Just_Check()) {
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                        $sql="SELECT o.id,o.branch_id,o.user_type 
                            FROM bnm_operator o
                            WHERE o.id=? AND o.branch_id = ?";
                        $res=Db::secure_fetchall($sql, array($_POST['karbar'],$_POST['branch']));
                        if($res){
                            if (isset($_POST['menu_access'])) {
                                $sql    = "delete FROM bnm_dashboard_menu_access WHERE operator_id=? AND user_type = ?";
                                $result = Db::secure_fetchall($sql, array($res[0]['id'],$res[0]['user_type']));
                                // foreach ($_POST['menu_access'] as $key => $value) {
                                for ($i=0; $i <count($_POST['menu_access']) ; $i++) { 
                                    $sql    = Helper::Insert_Generator(     array('menu_id' => $_POST['menu_access'][$i], 'operator_id' => $res[0]['id'],'user_type'=>$res[0]['user_type']), 'bnm_dashboard_menu_access');
                                    $result = Db::secure_insert_array($sql, array('menu_id' => $_POST['menu_access'][$i], 'operator_id' => $res[0]['id'],'user_type'=>$res[0]['user_type']));
                                }
                            }
                            if (isset($_POST['add_access'])) {
                                $sql    = "delete FROM bnm_dashboard_menu_add WHERE operator_id=? AND user_type = ?";
                                $result = Db::secure_fetchall($sql, array($res[0]['id'],$res[0]['user_type']));
                                for ($i=0; $i <count($_POST['add_access']) ; $i++) { 
                                    $sql    = Helper::Insert_Generator(     array('menu_id' => $_POST['add_access'][$i], 'operator_id' => $res[0]['id'],'user_type'=>$res[0]['user_type']), 'bnm_dashboard_menu_add');
                                    $result = Db::secure_insert_array($sql, array('menu_id' => $_POST['add_access'][$i], 'operator_id' => $res[0]['id'],'user_type'=>$res[0]['user_type']));
                                }
                            }
                            if (isset($_POST['edit_access'])) {
                                $sql    = "delete FROM bnm_dashboard_menu_edit WHERE operator_id=? AND user_type = ?";
                                $result = Db::secure_fetchall($sql, array($res[0]['id'],$res[0]['user_type']));
                                for ($i=0; $i <count($_POST['edit_access']) ; $i++) { 
                                    $sql    = Helper::Insert_Generator(     array('menu_id' => $_POST['edit_access'][$i], 'operator_id' => $res[0]['id'],'user_type'=>$res[0]['user_type']), 'bnm_dashboard_menu_edit');
                                    $result = Db::secure_insert_array($sql, array('menu_id' => $_POST['edit_access'][$i], 'operator_id' => $res[0]['id'],'user_type'=>$res[0]['user_type']));
                                }
                            }
                            if (isset($_POST['delete_access'])) {
                                $sql    = "delete FROM bnm_dashboard_menu_delete WHERE operator_id = ? AND user_type = ?";
                                $result = Db::secure_fetchall($sql, array($res[0]['id'],$res[0]['user_type']));
                                for ($i=0; $i <count($_POST['delete_access']) ; $i++) { 
                                    $sql    = Helper::Insert_Generator(     array('menu_id' => $_POST['delete_access'][$i], 'operator_id' => $res[0]['id'],'user_type'=>$res[0]['user_type']), 'bnm_dashboard_menu_delete');
                                    $result = Db::secure_insert_array($sql, array('menu_id' => $_POST['delete_access'][$i], 'operator_id' => $res[0]['id'],'user_type'=>$res[0]['user_type']));
                                }
                            }
                            if($result){
                                echo Helper::Alert_Message('s');
                            }else{
                                echo Helper::Alert_Message('f');
                            }
                        }else{
                            die(Helper::Json_Message('f'));
                        }
                        //header("Location:" . __ROOT__ . 'restrictions');
                        break;
                    case __MODIRUSERTYPE__:
                    case __MODIR2USERTYPE__:
                        // $sql="SELECT id,branch_id FROM bnm_operator WHERE id = ? AND branch_id = ?";
                        // $res=Db::secure_fetchall($sql,array($res[0]['id'],$_SESSION['branch_id']));
                        // if($res){
                        //     if (isset($_POST['menu_access'])) {
                        //         $sql    = "delete FROM bnm_dashboard_menu_access WHERE operator_id=?";
                        //         $result = Db::secure_fetchall($sql, array($res[0]['id']));
                        //         foreach ($_POST['menu_access'] as $key => $value) {
                        //             $sql    = Helper::Insert_Generator(array('menu_id' => $value, 'operator_id' => $res[0]['id']), 'bnm_dashboard_menu_access');
                        //             $result = Db::secure_insert_array($sql, array('menu_id' => $value, 'operator_id' => $res[0]['id']));
                        //         }
                        //     }
                        //     if (isset($_POST['edit_access'])) {
                        //         $sql    = "delete FROM bnm_dashboard_menu_edit WHERE operator_id=?";
                        //         $result = Db::secure_fetchall($sql, array($res[0]['id']));
                        //         foreach ($_POST['edit_access'] as $key => $value) {
                        //             $sql    = Helper::Insert_Generator(array('menu_id' => $value, 'operator_id' => $res[0]['id']), 'bnm_dashboard_menu_edit');
                        //             $result = Db::secure_insert_array($sql, array('menu_id' => $value, 'operator_id' => $res[0]['id']));
                        //         }
                        //     }
                        //     if (isset($_POST['add_access'])) {
                        //         $sql    = "delete FROM bnm_dashboard_menu_add WHERE operator_id=?";
                        //         $result = Db::secure_fetchall($sql, array($res[0]['id']));
                        //         foreach ($_POST['add_access'] as $key => $value) {
                        //             $sql    = Helper::Insert_Generator(array('menu_id' => $value, 'operator_id' => $res[0]['id']), 'bnm_dashboard_menu_add');
                        //             $result = Db::secure_insert_array($sql, array('menu_id' => $value, 'operator_id' => $res[0]['id']));
                        //         }
                        //     }
                        //     if (isset($_POST['delete_access'])) {
                        //         $sql    = "delete FROM bnm_dashboard_menu_delete WHERE operator_id = ?";
                        //         $result = Db::secure_fetchall($sql, array($res[0]['id']));
                        //         foreach ($_POST['add_access'] as $key => $value) {
                        //             $sql    = Helper::Insert_Generator(array('menu_id' => $value, 'operator_id' => $res[0]['id']), 'bnm_dashboard_menu_delete');
                        //             $result = Db::secure_insert_array($sql, array('menu_id' => $value, 'operator_id' => $res[0]['id']));
                        //         }
                        //     }
                        
                        // header("Location:" . __ROOT__ . 'restrictions');
                        // }else echo Helper::Alert_Message('na');
                        echo Helper::Alert_Message('na');
                        break;

                    default:
                        echo Helper::Alert_Message('af');
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
        $this->view->pagename = 'restrictions';
        $this->view->render('restrictions', 'dashboard_template', '/public/js/restrictions.js', '/public/js/demo_pages/form_multiselect.js');
    }
}
