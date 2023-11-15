<?php defined('__ROOT__') or exit('No direct script access allowed');
class siam extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        if(isset($_POST['siamrequest'])){

            switch ($_POST['siamrequest']) {
                case 'CombinSearch':
                    $res= SiamHelper::CombinSearch(
                        $_POST['Uname'], 
                        $_POST['AutStr'],
                        $_POST['TelNum'],
                        $_POST['IPAddr'],
                        $_POST['Fname'],
                        $_POST["Lname"],
                        $_POST["PNum"],
                        $_POST["PCode"],
                        $_POST["NCode"],
                        $_POST['IPNum']);
                    echo $res;
                    die();
                break;
                case 'TechnicalSearch':
                    $res=SiamHelper::TechnicalSearch($_POST['Uname'], $_POST['AutStr'], $_POST['IPAddr'], $_POST['FDate'], $_POST['TDate']);
                    echo $res;
                    die();
                break;
                case 'MacSearch':
                    $res=SiamHelper::MacSearch($_POST['Uname'], 
                    $_POST['AutStr'],
                    $_POST['MacAddr'],
                    $_POST['FDate'],
                    $_POST['TDate']
                        );
                    echo $res;
                    die();
                break;
                case 'ListOfBPlan':
                    $res=SiamHelper::ListOfBPlan($_POST['Uname'], 
                        $_POST['AutStr'],
                        $_POST['FDate'],
                        $_POST['TDate'],
                        );
                    echo $res;
                    die();
                break;
                case 'GetIPDR':
                    // echo json_encode('asdasdsad', JSON_UNESCAPED_UNICODE);
                    // die();

                    $res=SiamHelper::GetIPDR(
                        $_POST['Uname'], 
                        $_POST['AutStr'],
                        $_POST['FDate'],
                        $_POST['TDate'],
                        $_POST['TelNum'],
                        $_POST['IPAddr'],
                        $_POST['CId'],
                        );
                    echo $res;
                    die();
                break;
                case 'ApplySuspIp':
                    // echo json_encode('asdasdasd');
                    // die();
                    $res=SiamHelper::ApplySuspIp(
                        $_POST['Uname'], 
                        $_POST['AutStr'],
                        $_POST['RefNum'],
                        $_POST['SuspId'],
                        $_POST['SuspType'],
                        $_POST['SuspOrder'],
                        $_POST['TelNum'],
                        $_POST['IPAddr'],
                        $_POST['CId'],
                        );
                    echo $res;
                    die();
                break;
                case 'GetIpPool':
                    $res=SiamHelper::GetIpPool(
                        $_POST['Uname'], 
                        $_POST['AutStr'],
                        );
                    echo $res;
                    die();
                break;
                case 'PassChange':
                    $res=SiamHelper::PassChange(
                        $_POST['Uname'], 
                        $_POST['AutStr'],
                        $_POST['NAutStr'],
                        );
                    echo $res;
                    die();
                break;
                default:
                    echo json_encode('QryResult=1^&نوع درخواست نامشخص', JSON_UNESCAPED_UNICODE);
                    die();
                break;
            }
        }

        $this->view->pagename = 'siam';
        $this->view->render('siam', 'dashboard_template', '/public/js/siam.js', false);
    }
}
