<?php defined('__ROOT__') or exit('No direct script access allowed');
class CrmLastDayReport extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        // echo Helper::Today_Miladi_Date('-'). ' '. Helper::nowShamsihisv();
        // die();
        date_default_timezone_set('Asia/Tehran');
        // echo ' '.date('H:i:s').' '; 
        // $yesterday=date('Y-m-d', strtotime(' -1 day'));
        // $yesterdaynosep= date('Ymd', strtotime(' -1 day'));
        // $yesterdaynosep=date('Ymd', strtotime('-1 day', strtotime($date)));
        // $yesterday=date('Y-m-d', strtotime('-1 day', strtotime($date)));
        // echo $yesterdaynosep;
        // echo ' '.$yesterday;
        // die();
        // $curtime    = date('His');
        // $intcurtime = (int) $curtime;
        $date       = Helper::Today_Miladi_Date('');
        $fd         = Helper::Today_Miladi_Date('-');
        $td         = Helper::Today_Miladi_Date('-');
        $res=Helper::crmDailyReportCombined($date, $fd, $td);
        echo $res;
        ///send sms to 3 days and 1 day expiring internet users
        $ibs=$GLOBALS['ibs_internet']->getUsersAboutToExpire(3,3);
        $arrids=[];
        foreach ($ibs[1][2] as $k => $v) {
            $arrids[]=$v;
        }
        if($arrids){
            $usersibsinfo=Helper::ibsGetUserInfoByArrayId($arrids);
            $allusers=Helper::getAllInternetUsersServicesInfoNoAuth();
            $arr=[];
            foreach ($allusers as $k => $v) {
                foreach ($usersibsinfo as $kk => $vv) {
                    if($v['ibsusername']===$vv['attrs']['normal_username']){
                        $v['ibsinfo']=$vv;
                        $arr[]=$v;
                    }
                }
            }
        }
        if($arr){
            foreach ($arr as $k => $v) {
                if($v['branch_id']===0){
                    $res_internal = Helper::Internal_Message_By_Karbord('mdhexs', '1');
                }else{
                    $res_internal = Helper::Internal_Message_By_Karbord('mdhexn', '1');
                }
                if ($res_internal) {
                    $res_sms_request = Helper::Write_In_Sms_Request($v['telephone_hamrah'], Helper::Today_Miladi_Date(),
                        Helper::Today_Miladi_Date(), 1, $res_internal[0]['id'], '2');
                    if ($res_sms_request) {
                        $arr = array();
                        $arr['receiver'] = $v['telephone_hamrah'];
                        $arr['sender'] = __SMSNUMBER__;
                        $arr['request_id'] = $res_sms_request;
                        $res = Helper::Write_In_Sms_Queue($arr);
                    }
                }
            }                    
        }
        ////////////////////////////internet/////////////////////////////////
        //////////voip
        $ibs=$GLOBALS['ibs_voip']->getUsersAboutToExpire(3,3);
                $arrids=[];
                foreach ($ibs[1][2] as $k => $v) {
                    $arrids[]=$v;
                }
                if($arrids){
                    $usersibsinfo=Helper::ibsGetUserInfoByArrayId($arrids, true, 'voip');
                    $allusers=Helper::getServiceInfoByServiceTypeNoAuth('voip');
                    $arr=[];
                    foreach ($allusers as $k => $v) {
                        foreach ($usersibsinfo as $kk => $vv) {
                            if($v['ibsusername']===$vv['attrs']['voip_username']){
                                $v['ibsinfo']=$vv;
                                $arr[]=$v;
                            }
                        }
                    }
                }
                if($arr){
                    foreach ($arr as $k => $v) {
                        if($v['branch_id']===0){
                            $res_internal = Helper::Internal_Message_By_Karbord('mdhexs', '1');
                        }else{
                            $res_internal = Helper::Internal_Message_By_Karbord('mdhexn', '1');
                        }
                        if ($res_internal) {
                            $res_sms_request = Helper::Write_In_Sms_Request($v['telephone_hamrah'], Helper::Today_Miladi_Date(),
                                Helper::Today_Miladi_Date(), 1, $res_internal[0]['id'], '2');
                            if ($res_sms_request) {
                                $arr = array();
                                $arr['receiver'] = $v['telephone_hamrah'];
                                $arr['sender'] = __SMSNUMBER__;
                                $arr['request_id'] = $res_sms_request;
                                $res = Helper::Write_In_Sms_Queue($arr);
                            }
                        }
                    }                    
                }
        die();
        // if($intcurtime >= __CRMREPORTFTIME__ && $intcurtime <= __CRMREPORTLTIME__){
        //    $fd     = Helper::Today_Miladi_Date('-');
        //             $td     = Helper::Today_Miladi_Date('-');
        //             $date   = Helper::Today_Miladi_Date('');
        //         }
        // $sql="SELECT COUNT(*) rowsnum FROM bnm_crmdailyreport WHERE DATE(mtarikh) = ? AND status = ? ORDER BY mtarikh DESC LIMIT 1";
        // $res=Db::secure_fetchall($sql, [$yesterday, 1]);
        // if(! $res){
        //     // $combined   = Helper::crmDailyReportCombined($yesterdaynosep, $yesterday, $yesterday, true, $yesterday);
        //     echo 'hi';
        // }else{
        //     die();
        //     echo 'bye';
        // }
        // die();
        // Helper::cLog((int)$current_time);
        // Helper::cLog(gettype($current_time));
        // die();
        //check today
        // $sql="SELECT *,DATE(mtarikh),CURDATE() today FROM bnm_crm_report_webservice WHERE DATE(mtarikh) = CURDATE() ";
        // $today=Db::fetchall_Query($sql);
        // if(! $today){
        //     //do it
        //     if($intcurtime >= __CRMREPORTFTIME__ && $intcurtime <= __CRMREPORTLTIME__){

        //     }


        //     die();
        // }
        // if($today){
        //     if($today[0]['status']===0){
        //         //do it
        //         if($intcurtime >= __CRMREPORTFTIME__ && $intcurtime <= __CRMREPORTLTIME__){
        //             $fd     = Helper::Today_Miladi_Date('-');
        //             $td     = Helper::Today_Miladi_Date('-');
        //             $date   = Helper::Today_Miladi_Date('');
        //         }

        //         die();
        //     }
        // }

        
        // $sql="SELECT * FROM (SELECT *,DATE(mtarikh),CURDATE() today FROM bnm_crm_report_webservice ORDER BY DATE(mtarikh) DESC LIMIT 30) tmp ORDER BY id ASC";
        // $res=Db::fetchall_Query($sql);
        // if($res){

        // }else{

        // }
        // echo $current_time;
        // die();   

        // $name   = '';
        // $date   = '20230209';
        // // $fd     = Helper::Today_Miladi_Date('-');
        // $fd     = '2023-02-09';
        // $td     = '2023-02-09';
        // // $td     = Helper::Today_Miladi_Date('-');
        // $name   = "CRM_".$date."_"."SaharErtebat.csv";
        // $res    = CrmReport::reportByCustomDates($fd, $td);
        // $csv    = Helper::createCrmReportCsv($res, 'dump');
        // if ($csv) {
        //     $ftp = Helper::sendCrmReportFileWithFtp(__CRMFTPHOST__, __CRMFTPUSER__, __CRMFTPPASS__, __ROOT__, 'dump.csv', __CRMFTPDESTPATH__, $name);
        // }
        // echo $ftp;
        // Helper::cLog($ftp);
        // die();

        $this->view->pagename = 'crmlastdayreport';
        $this->view->render('crmlastdayreport', 'dashboard_template', '/public/js/crmlastdayreport.js', false);
    }
}
