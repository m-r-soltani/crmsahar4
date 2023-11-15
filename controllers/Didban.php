<?php defined('__ROOT__') or exit('No direct script access allowed');
class Didban extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        if(isset($_POST['didbanrequest'])){
            switch ($_POST['didbanrequest']) {
                case 'CheckHealth':
                    $res= DidebanHelper::checkHealth();
                    echo $res;
                    die();
                break;
                case 'GetPackageUsage':
                    $arr=[];
                    $arr=$_POST['reqbody'];
                    $res=DidebanHelper::getPackageUsage($arr['TrackingCode'], $arr['ServiceNumber'], $arr['FromDate'], $arr['ToDate'], $arr['PageNumber']);
                    echo $res;
                    die();
                break;
                case 'GetRequestLog':
                    $arr=[];
                    $arr=$_POST['reqbody'];
                    // die(json_encode($arr));
                    $res=DidebanHelper::getRequestLog($arr['TrackingCode']);
                    echo $res;
                    die();
                break;
                case 'GetCallUsage':
                    $arr=[];
                    $arr=$_POST['reqbody'];
                    $res=DidebanHelper::getCallUsage($arr['TrackingCode'], $arr['ServiceNumber'], $arr['FromDate'], $arr['ToDate'], $arr['Type'], $arr['PageNumber']);
                    echo $res;
                    die();
                break;
                case 'GetPrePaidBillInfo':
                    $arr=[];
                    $arr=$_POST['reqbody'];
                    $res=DidebanHelper::getPrePaidBillInfo($arr['TrackingCode'], $arr['ServiceNumber'], $arr['FromDate'], $arr['ToDate'], $arr['PageNumber']);
                    echo $res;
                    die();
                break;
                case 'GetPostPaidBillInfo':
                    $res=DidebanHelper::createErrorArray(DidebanHelper::Messages('no_service'));
                    echo json_encode($res, JSON_UNESCAPED_UNICODE);
                    die();

                break;
                case 'GetSuspentionHistory':
                    $arr=[];
                    $arr=$_POST['reqbody'];
                    $res=DidebanHelper::getSuspentionHistory($arr['TrackingCode'], $arr['ServiceNumber'], $arr['FromDate'], $arr['ToDate']);
                    echo $res;
                    die();
                break;
                
                case 'GetPackageUsageDetails':
                    $arr=[];
                    $arr=$_POST['reqbody'];
                    $res=DidebanHelper::getPackageUsageDetails($arr['TrackingCode'], $arr['ServiceNumber'], $arr['FromDate'], $arr['ToDate'], $arr['PackageId'], $arr['PageNumber']);
                    echo $res;
                    die();
                break;
                case 'SearchOwner':
                    $arr=[];
                    $arr=$_POST['reqbody'];
                    $res=DidebanHelper::searchOwner($arr['TrackingCode'], $arr['ServiceNumber']);
                    echo $res;
                    die();
                break;
                default:
                    
                break;
            }
        }

        $this->view->pagename = 'didban';
        $this->view->render('didban', 'dashboard_template', '/public/js/didban.js', false);
    }
}
