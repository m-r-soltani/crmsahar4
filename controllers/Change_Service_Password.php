<?php defined('__ROOT__') or exit('No direct script access allowed');
class Change_Service_Password extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        /*========sabte shahr========*/
        // if (isset($_POST['send_change_service_password'])) {
        //     $_POST = Helper::xss_check_array($_POST);
        //     if (Helper::Is_Empty_OR_Null($_POST['new_password']) && Helper::Is_Empty_OR_Null($_POST['factor_id'])) {
        //         switch ($_SESSION['user_type']) {
        //             case __ADMINUSERTYPE__:
        //             case __ADMINOPERATORUSERTYPE__:

        //                 break;
        //             case __MODIRUSERTYPE__:
        //             case __OPERATORUSERTYPE__:
        //             case __MODIR2USERTYPE__:
        //             case __OPERATOR2USERTYPE__:

        //                 $sql = "SELECT * FROM bnm_factor WHERE id = ? AND subscriber_id=? AND branch_id=?";
        //                 $res = Db::secure_fetchall($sql, array($_POST['factor_id'], $_SESSION['subscriber_id'], $_SESSION['branch_id']));
        //                 if ($res) {
        //                     switch ($res[0]['type']) {
        //                         case 'adsl':
        //                         case 'vdsl':
        //                         case 'wireless':
        //                         case 'tdlte':
        //                             //ibs ineternet
        //                             $GLOBALS['ibs_internet'];
        //                             break;
        //                         case 'voip':
        //                             //ibs voip
        //                             $GLOBALS['ibs_voip'];
        //                             break;

        //                         default:
        //                             echo Helper::Alert_Message('fint');
        //                             break;
        //                     }
        //                 } else {
        //                     echo Helper::Alert_Message('fint');
        //                 }

        //                 break;
        //             case __MOSHTARAKUSERTYPE__:
        //                 $sql = "SELECT * FROM bnm_factor WHERE id = ? AND subscriber_id=? AND branch_id=?";
        //                 $res = Db::secure_fetchall($sql, array($_POST['factor_id'], $_SESSION['subscriber_id'], $_SESSION['branch_id']));
        //                 if ($res) {
        //                     switch ($res[0]['type']) {
        //                         case 'adsl':
        //                         case 'vdsl':
        //                         case 'wireless':
        //                         case 'tdlte':
        //                             //ibs ineternet
        //                             $GLOBALS['ibs_internet'];
        //                             break;
        //                         case 'voip':
        //                             //ibs voip
        //                             $GLOBALS['ibs_voip'];
        //                             break;

        //                         default:
        //                             echo Helper::Alert_Message('fint');
        //                             break;
        //                     }
        //                 } else {
        //                     echo Helper::Alert_Message('fint');
        //                 }

        //                 break;

        //             default:
        //                 die(Helper::Json_Message('af'));
        //                 break;
        //         }
        //     } else {
        //         echo Helper::Alert_Message('f');
        //     }

        // }
        $this->view->pagename = 'change_service_password';
        $this->view->render('change_service_password', 'dashboard_template', '/public/js/change_service_password.js', false);
    }
}
