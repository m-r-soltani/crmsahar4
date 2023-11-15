<?php defined('__ROOT__') or exit('No direct script access allowed');
class Crm_Report extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        
        if (isset($_POST['send_crm_report'])) {
            // $_POST = Helper::Create_Post_Array_Without_Key($_POST);
            parse_str($_POST[key($_POST)], $_POST);
            $_POST = Helper::xss_check_array($_POST);
            if(isset($_POST['fd']) && isset($_POST['td']) && isset($_POST['type'])){
                if(Helper::Login_Just_Check()){
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            $fd=Helper::TabdileTarikh($_POST['fd'], 2, '/', '-', true);
                            $td=Helper::TabdileTarikh($_POST['td'], 2, '/', '-', true);
                            //todo ... check fd < td
                            if(! $fd && ! $td){
                                die(Helper::Json_Message('e'));
                            }
                            $dates=Helper::createDateRange($fd, $td);
                            if(! $dates){
                                die(Helper::Json_Message('f'));
                            }
                            if($_POST['type']==="2"){
                                //rozane
                                for ($i=0; $i < count($dates); $i++) {
                                    $d=date("Ymd", strtotime($dates[$i]));
                                    $name   = "CRM_".$d."_"."SaharErtebat.csv";
                                    $fd=date("Y-m-d", strtotime($dates[$i]));
                                    $td=date("Y-m-d", strtotime($dates[$i]));
                                    if($fd != date("Y-m-d") && $td != date("Y-m-d")){
                                        $res    = CrmReport::reportByCustomDates($fd, $td);
                                        $csv    = Helper::createCrmReportCsv($res, 'dump');
                                        if(! $csv){
                                            $msg="مشکل در ایجاد فایل csv لطفا با پشتیبانی تماس بگیرید";
                                            $msg.=" آخرین گزارش ارسال شده: ";
                                            $msg.=Helper::TabdileTarikh($dates[$i-1],1, '-', '/');
                                            die(Helper::Custom_Msg($msg));
                                        } 
                                        
                                        $ftp = Helper::sendCrmReportFileWithFtp(__CRMFTPHOST__, __CRMFTPUSER__, __CRMFTPPASS__, __ROOT__, 'dump.csv', __CRMFTPDESTPATH__, $name);
                                    }else{
                                        $msg=" گزارش تاریخ ";
                                        $msg.=Helper::TabdileTarikh($fd, 1, '-', '-', false);
                                        $msg.="مربوط به امروز است و فرستاده نشد";
                                        die(Helper::Custom_Msg($msg));
                                    }
                                }
                                // die(json_encode($res, JSON_UNESCAPED_UNICODE));
                                die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                            }else{
                                //yekja
                                $d=date("Ymd", strtotime($dates[array_key_last($dates)]));
                                $name   = "CRM_".$d."_"."SaharErtebat.csv";
                                $fd=date("Y-m-d", strtotime($dates[array_key_first($dates)]));
                                $td=date("Y-m-d", strtotime($dates[array_key_last($dates)]));
                                if($fd != date("Y-m-d") && $td != date("Y-m-d")){
                                    $res    = CrmReport::reportByCustomDates($fd, $td);
                                    $csv    = Helper::createCrmReportCsv($res, 'dump');
                                    if(! $csv){
                                        $msg="مشکل در ایجاد فایل csv لطفا با پشتیبانی تماس بگیرید";
                                        // $msg.=" آخرین گزارش ارسال شده: ";
                                        // $msg.=Helper::TabdileTarikh($dates[$i-1],1, '-', '/');
                                        die(Helper::Custom_Msg($msg));
                                    }
                                    // $res    = CrmReport::reportByCustomDates($fd, $td);
                                    $ftp = Helper::sendCrmReportFileWithFtp(__CRMFTPHOST__, __CRMFTPUSER__, __CRMFTPPASS__, __ROOT__, 'dump.csv', __CRMFTPDESTPATH__, $name);
                                }else{
                                    $msg=" گزارش ";
                                    // $msg.=Helper::TabdileTarikh($fd, 1, '-', '-', false);
                                    $msg.="مربوط به امروز است و فرستاده نشد";
                                    die(Helper::Custom_Msg($msg));
                                }
                                // die(json_encode($res, JSON_UNESCAPED_UNICODE));
                                die(Helper::Custom_Msg(Helper::Messages('s'), 1));
                            }
                            // die(json_encode($dates));
                            // die(json_encode([$fd,$td], JSON_UNESCAPED_UNICODE));
                            
                        break;
                        default:
                            die(Helper::Json_Message('af'));
                        break;
                    }
                }else{
                    die(Helper::Json_Message('na'));
                }
            }else{
                die(Helper::Custom_Msg('تمام فیلد ها باید مقدار داشته باشند.'));
            }
        }
        $this->view->pagename = 'crm_report';
        $this->view->render('crm_report', 'dashboard_template', '/public/js/crm_report.js', false);
    }
}
