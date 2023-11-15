<?php session_start();
ini_set('display_errors', 1);
ini_set("soap.wsdl_cache_enabled", "0");
ini_set('display_startup_errors', 1);
date_default_timezone_set('Asia/Tehran');
ini_set('file_uploads', 'on');
//soltani
//S0lt@n1!123
error_reporting(E_ALL);
// a.barari@asiatech.ir
/*header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Content-Type: application/html; charset=utf-8");*/
$directory   = __DIR__;
$imagespath  = $directory . '\public\images\\';
$public_dir  = $directory . '\public\\';
$private_dir = $directory . '\private\\';
$root        = (isset($_SERVER['HTTPS']) ? "http://" : "http://") . $_SERVER['HTTP_HOST'];
$script_name = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
// 11604173
// 5790518
//81681016371871
//84345000
//epay@sep.ir
define('__RECAPTCHASITEKEY__'       , '6LfBEcIZAAAAAIlZqRE9xZZYb2v3n2bqL2--XBC0');
define('__RECAPTCHASECRETKEY__'     , '6LfBEcIZAAAAAEV3QpcrAp3-8il9mOhVWjJgpMHS');
define('__IPDRUSERNAME__'           , 'saharipdr');
define('__IPDRPASSWORD__'           , '4ec1877bcd80a11f47553520bb7b87b3');
define('__MOSHTARAKEHAGHIGHI__'     , 'real');
define('__MOSHTARAKEHOGHOGHI__'     , 'legal');
define('__DASHBOARDID__'            , 24);
define('__GROUPACCESSID__'          , 51);
define('__DIDBANLIMITINSECOND__'    , 62208000);//180 rooz
define('__DIDBANLIMITINDAY__'       , 720);//180 rooz
define('__ROOT__'                   , $root . $script_name);
define('__DIRECTORY__'              , $directory);
define('__IMAGESPATH__'             , $imagespath);
define('__PUBLICFOLDER__'           , $public_dir);
define('__PRIVATEFOLDER__'          , $private_dir);
define('__ENCRYPTION_KEY__'         , 'Fho8G**g&0ds79syK0PKPph&^D12fi7g1k-23`j*G&7IVGD');
define('__SITE_NAME__'              , 'CRM سحر ارتباط');
define('__ROOT_PATH__'              , realpath($_SERVER['DOCUMENT_ROOT'] . '/' . $script_name));
define('__HOSTNAME__'               , 'localhost');
define('__USERNAME__'               , 'amin');
define('__PASSWORD__'               , 'Parisblue@23#33');
define('__DATABASE__'               , 'saharertebat');
define('__ADMINUSERTYPE__'          , 1);
define('__MODIRUSERTYPE__'          , 2);
define('__OPERATORUSERTYPE__'       , 3);
define('__ADMINOPERATORUSERTYPE__'  , 4);
define('__MOSHTARAKUSERTYPE__'      , 5);
define('__MODIR2USERTYPE__'         , 6);
define('__OPERATOR2USERTYPE__'      , 7);
define('__PANELACTIVESTATUS__'      , 1);
define('__PANELDEACTIVESTATUS__'    , 2);
define('__OWNER__'                  , 'شبکه سحر ارتباط');
define('__OWNERCOMPANYEN__'         , 'SaharErtebat');
define('__OWNERCOMPANYFA__'         , 'شبکه سحر ارتباط');
define('__OWNERTELEPHONE__'         , "0212376081-5");
define('__OWNERCODEPOSTI__'         , "1468995469");
define('__OWNERCODEEGHTESADI__'     , "411151564944");
define('__OWNEROSTAN__'             , "تهران");
define('__OWNERSHOMARESABT__'       , "203812");
define('__OWNERSHAHR__'             , "تهران");
define('__OWNERADDRESS__'           , "شهرک قدس(غرب) بلوار شهید فرحزادی خیابان شهید حافظی(ارغوان غربی) پلاک10 واحد8");
define('__OWNERNAME__'              , 'سیامک امیر منوچهری');
define('__OWNERMOBILE__'            , '09122379439');
define('__NAMAYANDE1__'             , 'نماینده سطح یک');
define('__NAMAYANDE2__'             , 'نماینده سطح دو');
define('__SEMATOPERATOR__'          , 'اپراتور شبکه');
define('__SEMATMOSHTARAK__'         , 'مشترک');
define('__SMSUSERNAME__'            , 'websaharertebat');
define('__SMSPASSWORD__'            , 'SwekBNd54!f');
define('__SMSNUMBER__'              , '30007650007104');
define('__SMSRECEIVEURL__'          , __ROOT__.'sms_inbox');
define('__MINIMUMPAYMENT__'         , 10000);
define('__SMSWEBSERVICEURL__'       , 'http://mihansmscenter.com/webservice/?wsdl');
define('__ZARINPALMERCHANTCODE__'   , '8cc54d8c-3b22-4b27-9e20-b5dabb6748f3');
define('__ZARINPALCALLBACKURL__'    , "http://185.160.205.11/Zarinpal");
define('__ZARINPALAUTHORITYURL__'   , 'https://api.zarinpal.com/pg/v4/payment/request.json');
define('__ZARINPALUSERAGENT__'      , 'ZarinPal Rest Api v1');
define('__ZARINPALSTARTPAY__'       , "https://www.zarinpal.com/pg/StartPay/");
define('__ZARINPALVERIFYURL__'      , "https://api.zarinpal.com/pg/v4/payment/verify.json");
define('__SAMANMERCHANTCODE__'      , '11604173');
define('__SAMANTOKENURL__'          , 'https://sep.shaparak.ir/MobilePG/MobilePayment');
define('__SAMANPARDAKHTURL__'       , 'https://sep.shaparak.ir/OnlinePG/OnlinePG');
define('__SAMANVERIFYURL__'         , 'https://verify.sep.ir/Payments/ReferencePayment.asmx?WSDL');
define('__SAMANVERIFY__'            , 'https://verify.sep.ir/payments/referencepayment.asmx?wsdl');
define('__SAMANREDIRECTURL__'       , 'http://185.160.205.11/charge_credit');
define('__ASIATECHAUTH__'           , "c0c85f22aca5c7e9975155af93e73a17");
define('__ASIATECHOSSURL__'         , "https://oss.asiatech.ir/webservice/");
define('__ASIATECHPORT__'           , 80);
define('__ASIATECHVSPID__'          , 40);
define('__ASIATECHALTVSPID__'       , 1);
define('__ASIATECHVPI__'            , 1);
define('__ASIATECHVCI__'            , 58);
define('__BRANCHESACCEPTABLEBALANCEFORPAY__',20/100);
define('__IPDRDBTYPE__','mysql');
define('__IPDRDBUSERNAME__','ipdr');
define('__IPDRDBPASS__','ipdrdb123');
define('__IPDRDBHOST__','80.253.151.18');
define('__IPDRDBDBNAME__','jetsib_ts');
define('__IPDRDBPORT__','3306');
define('__IPDRDBPERFIX__','');//dont delete
define('__IPDRDBCHARSET__','utf8');//dont delete
define('__CRMFTPHOST__','185.160.205.15');
// define('__CRMFTPUSER__','root');
define('__CRMFTPUSER__','Sahar_Ertebat');
define('__CRMFTPPASS__','XxeNhfmq');
// define('__CRMFTPPASS__','hp76hp1798');
define('__CRMFTPDESTPATH__','CRM/');
define('__CRMREPORTFTIME__',235700);
define('__CRMREPORTLTIME__',235959);
define('__SIAMLIMITATION__',200);



spl_autoload_register(function ($className) {
    if (file_exists('system/' . $className . '.php')) {
        require_once 'system/' . $className . '.php';
    } else if (file_exists('controllers/' . $className . '.php')) {
        require_once 'controllers/' . $className . '.php';
    } else if (file_exists('models/' . $className . '.php')) {
        require_once 'models/' . $className . '.php';
    } else if (file_exists('libraries/' . $className . '.php')) {
        require_once 'libraries/' . $className . '.php';
    }else if (file_exists('libraries/Excel/' . $className . '.php')) {
        require_once 'libraries/Excel/' . $className . '.php';
    }else if (file_exists($className . '.php')) {
        require_once $className . '.php';
    } 
});

if (file_exists('libraries' . '/nusoap' . '.php')) {
    require_once 'libraries' . '/nusoap' . '.php';
} else {
    die('file_not_found');
}
// $GLOBALS['ibs_internet'] = new IBSjsonrpcClient("80.253.151.5", "system", "si@h@sti1355", "ADMIN", 1237, 5000);
// $GLOBALS['ibs_internet'] = new IBSjsonrpcClient("185.129.212.3", "system", "si@h@sti1355", "ADMIN", 1237, 5000);
$GLOBALS['ibs_internet'] = new IBSjsonrpcClient("185.129.212.4", "system", "si@h@sti1355", "ADMIN", 1237, 5000);
$GLOBALS['ibs_voip']     = new IBSjsonrpcClient("185.160.205.13", "system", "si@h@sti1355", "ADMIN", 1237, 5000);
$GLOBALS['bs']           = new AsiatechJsonrpc();
new Bootstrap();