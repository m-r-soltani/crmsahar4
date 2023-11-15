<?php defined('__ROOT__') or exit('No direct script access allowed');

class Support_Requests_Compose extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        /*========sabte shahr========*/
        if (isset($_POST['send_support_requests_compose'])) {
            if(Helper::Login_Just_Check()){
                try {
                    $table_name = "bnm_support_requests";
                    $_POST      = Helper::Auto_Unset_By_Tbl_Name($_POST, $table_name);
                    $_POST      = Helper::Manual_Unset_Array($_POST, array('noe_payam', 'onvane_payam', 'matne_payam'));
                    $_POST      = Helper::xss_check_array($_POST);
                    if (Helper::Is_Empty_OR_Null($_POST['noe_payam']) && Helper::Is_Empty_OR_Null($_POST['onvane_payam']) && Helper::Is_Empty_OR_Null($_POST['matne_payam'])) {
                        //ok
                        $_POST['sender_id']          = $_SESSION['id'];
                        $_POST['sender_user_id']     = $_SESSION['user_id'];
                        $_POST['sender_user_type']   = $_SESSION['user_type'];
                        $_POST['sender_branch_id']   = $_SESSION['branch_id'];
                        $_POST['read_status_user']   = 0;
                        $_POST['read_status_branch'] = 1;
                        $_POST['read_status_admin']  = 1;
                        
                        $sql                         = Helper::Insert_Generator($_POST, 'bnm_support_requests');
                        if (Db::secure_insert_array($sql, $_POST)) {
                            Helper::Alert_Message('s');
                        } else {
                            Helper::Alert_Message('f');
                        }

                    } else {
                        echo Helper::Alert_Message('f');
                        die();
                    }
                } catch (Throwable $e) {
                    $res = Helper::Exc_Error_Debug($e, true, '', true);
                    die();
                }
            }else{
                die(Helper::Json_Message('af'));
            }
        }

        $this->view->pagename = 'support_requests_compose';
        $this->view->render('support_requests_compose', 'dashboard_template', '/public/js/support_requests_compose.js', false);
    }
}
