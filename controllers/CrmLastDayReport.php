<?php defined('__ROOT__') or exit('No direct script access allowed');
class CrmLastDayReport extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        // date_default_timezone_set('Asia/Tehran');
        // $date   = Helper::Today_Miladi_Date('');
        // $fd     = Helper::Today_Miladi_Date('-');
        // $td     = Helper::Today_Miladi_Date('-');
        // echo Helper::Today_Miladi_Date('-'). ' '. Helper::nowShamsihisv();
        // die();
        
        // // echo ' '.date('H:i:s').' ';

        $fd=date('Y-m-d', strtotime(' -1 day'));
        $td=date('Y-m-d', strtotime(' -1 day'));
        $date= date('Ymd', strtotime(' -1 day'));
        $res=false;
        $sql="SELECT COUNT(*) rowsnum FROM bnm_crmdailyreportlog WHERE DATE(mtarikh)= ? AND status = ?";
        $check=Db::secure_fetchall($sql, [$fd, 1]);
        // die(print_r($check));
        if($check[0]['rowsnum']<1){
            $res=Helper::quickCrmReport($date, $fd, $td);
            if($res){
                Helper::crmDailyReportLog($fd, 1);
            }else{
                Helper::crmDailyReportLog($fd, 1);
            }
        }
        
        die();
        
        
        // echo $res;
        

        $this->view->pagename = 'crmlastdayreport';
        $this->view->render('crmlastdayreport', 'dashboard_template', '/public/js/crmlastdayreport.js', false);
    }
}
