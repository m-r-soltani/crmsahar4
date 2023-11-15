<?php defined('__ROOT__') or exit('No direct script access allowed');

class Charge_Credit extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        //////////validating charge amount
        if (isset($_POST['send_charge_credit'])) {
            // if($_SESSION['user_type']==){
            //     echo Helper::Alert_Custom_Message('درگاه بانکی به دلیل قطعی سیستم غیر فعال میباشد لطفا بعدا مراجعه کنید');
            //     die();
            // }
            if (Helper::Login_Just_Check()) {
                if(isset($_POST['dargah'])){
                    if($_POST['dargah']==="1"){
                        $_POST                  = Helper::xss_check_array($_POST);
                        $_POST['charge_amount'] = Helper::regulateNumber($_POST['charge_amount']);
                        $_POST['charge_amount'] = str_replace(',', '', $_POST['charge_amount']);
                        $_POST['charge_amount'] = Helper::str_trim($_POST['charge_amount']);
                        $_POST['charge_amount'] = (int)$_POST['charge_amount'];
                                               
                        if ((int)$_POST['charge_amount']) {
                            if($_POST['charge_amount'] >= __MINIMUMPAYMENT__){
                                $arr['userid']          = $_SESSION['user_id'];
                                $arr['usertype']        = $_SESSION['user_type'];
                                $arr['branchid']        = $_SESSION['branch_id'];
                                $arr['amount']          = $_POST['charge_amount'];
                                $arr['merchantcode']    = __ZARINPALMERCHANTCODE__;
                                $arr['remote_addr_ip']  = $_SESSION['REMOTE_ADDR'];
                                $data = array(
                                    "merchant_id" => __ZARINPALMERCHANTCODE__,
                                    "amount"        => (int) $_POST['charge_amount'],
                                    "callback_url"  => __ZARINPALCALLBACKURL__,
                                    "description"   => "خرید شارژ",
                                );
                                $jsonData = json_encode($data);
                                $ch = curl_init(__ZARINPALAUTHORITYURL__);
                                curl_setopt($ch, CURLOPT_USERAGENT, __ZARINPALUSERAGENT__);
                                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                    'Content-Type: application/json',
                                    'Content-Length: ' . strlen($jsonData)
                                ));
                                $result = curl_exec($ch);
                                $err    = curl_error($ch);
                                $result = json_decode($result, true, JSON_PRETTY_PRINT);
                                curl_close($ch);
                                if ($err) {
                                    var_dump($err);
                                    die();
                                    echo Helper::Alert_Custom_Message('مشکل در ارتباط با درگاه بانکی لطفا مجددا تلاش کنید.');
                                } else {
                                    if (empty($result['errors'])) {
                                        if ($result['data']['code'] === 100) {
                                            $arr['authority']   = $result['data']["authority"];
                                            $arr['code']        = $result['data']['code'];
                                            $arr['tarikh']      = Helper::Today_Miladi_Date('-').' '.Helper::nowTimeTehran();
                                            $sql                = Helper::Insert_Generator($arr, 'bnm_zarinpal');
                                            $res                = Db::secure_insert_array($sql, $arr);
                                            if($res){
                                                header('Location: '. __ZARINPALSTARTPAY__ . $result['data']["authority"]);
                                            }else{
                                                echo Helper::Alert_Custom_Message('f');
                                            }
                                        }else{
                                            // echo'Error Code: ' . $result['errors']['code'];
                                            // echo'message: ' .  $result['errors']['message'];
                                            // die();
                                            echo Helper::Alert_Custom_Message('مشکل در ارتباط با درگاه بانکی لطفا مجددا تلاش کنید.');
                                            
                                        }
                                    } else {
                                        // echo'Error Code: ' . $result['errors']['code'];
                                        // echo'message: ' .  $result['errors']['message'];
                                        // die();
                                        echo Helper::Alert_Custom_Message('مشکل در ارتباط با درگاه بانکی لطفا مجددا تلاش کنید.');
                                    }
                                }
                            }else{
                                $msg = 'حداقل مبلغ قابل پرداخت '.__MINIMUMPAYMENT__.' هزار تومان میباشد';
                                echo Helper::Alert_Custom_Message($msg);
                            }
                        }else{
                            $msg = 'حداقل مبلغ قابل پرداخت '.__MINIMUMPAYMENT__.' هزار تومان میباشد';
                            echo Helper::Alert_Custom_Message($msg);
                        }
                    }elseif ($_POST['dargah']==="2") {
                        $_POST                  = Helper::xss_check_array($_POST);
                        $_POST['charge_amount'] = Helper::str_trim($_POST['charge_amount']);
                        $_POST['charge_amount'] = (int)$_POST['charge_amount'];
                        if ($_POST['charge_amount'] >= __MINIMUMPAYMENT__) {
                            $arr                  = array();
                            $arr['user_id']       = $_SESSION['user_id'];
                            $arr['user_type']     = $_SESSION['user_type'];
                            $arr['branch_id']     = $_SESSION['branch_id'];
                            $arr['amount']        = $_POST['charge_amount'];
                            $arr['merchantcode']  = __SAMANMERCHANTCODE__;
                            if (isset($_SESSION['HTTP_CLIENT_IP'])) {
                                $arr['http_c_ip'] = $_SESSION['HTTP_CLIENT_IP'];
                            }
                            if (isset($_SESSION['HTTP_X_FORWARDED_FOR'])) {
                                $arr['http_x_f_f_ip'] = $_SESSION['HTTP_X_FORWARDED_FOR'];
                            }
                            if (isset($_SESSION['REMOTE_ADDR'])) {
                                $arr['remote_addr_ip'] = $_SESSION['REMOTE_ADDR'];
                            }
    
                            do {
                                $flag   = true;
                                $resnum = Helper::randomNum();
                                $sql    = "SELECT COUNT(*) rows_num FROM bnm_sep_payment WHERE resnum = ?";
                                $res    = Db::secure_fetchall($sql, [$resnum]);
                                if ($res[0]['rows_num'] === 0) {
                                    $arr['resnum'] = $resnum;
                                    $flag = false;
                                } else {
                                    $flag = true;
                                }
                            } while ($flag);
                            $token_request = [
                                "action"        => "token",
                                "TerminalId"    => __SAMANMERCHANTCODE__,
                                "RedirectUrl"   => __SAMANREDIRECTURL__,
                                "ResNum"        => $arr['resnum'],
                                "Amount"        => $arr['amount']
                            ];
                            $token = Helper::simplePost(__SAMANTOKENURL__, $token_request);
                            $token = json_decode($token, true);
                            if (isset($token)) {
                                if ($token['status'] === 1) {
                                    $arr['token'] = $token['token'];
                                    $sql = Helper::Insert_Generator($arr, 'bnm_sep_payment');
                                    $res = Db::secure_insert_array($sql, $arr);
                                    if ($res) {
                                        switch ($_SESSION['user_type']) {
                                            case __ADMINUSERTYPE__:
                                            case __ADMINOPERATORUSERTYPE__:
                                                $cellnum = false;
                                                break;
                                            case __MODIRUSERTYPE__:
                                            case __MODIR2USERTYPE__:
                                                $sql     = "SELECT id,telephone_hamrah FROM bnm_operator WHERE id = ?";
                                                $res     = Db::secure_insert_array($sql, [$_SESSION['user_id']]);
                                                $cellnum = $res[0]['telephone_hamrah'];
                                            case __MOSHTARAKUSERTYPE__:
                                                $sql     = "SELECT id,telephone_hamrah FROM bnm_subscribers WHERE id = ?";
                                                $res     = Db::secure_insert_array($sql, [$_SESSION['user_id']]);
                                                $cellnum = $res[0]['telephone_hamrah'];
                                            default:
                                                die(Helper::Json_Message('af'));
                                                break;
                                        }
                                        if ($cellnum) {
                                            echo "<form name='samanpayment' action='" . __SAMANPARDAKHTURL__ . "' method='post'>
                                                    <input name= 'Token'     type= 'hidden' value= '{$arr['token']}'/>
                                                    <input name= 'GetMethod' type= 'hidden' value= 'false'/>
                                                    </form>
                                                    <script>document.forms['samanpayment'].submit()</script>";
                                        } else {
                                            echo "<form name='samanpayment' action='" . __SAMANPARDAKHTURL__ . "' method='post'>
                                                    <input name= 'Token'      type= 'hidden' value= '{$arr['token']}'/>
                                                    <input name= 'CellNumber' type= 'hidden' value= '{$cellnum}'/>
                                                    <input name= 'GetMethod'  type= 'hidden' value= 'false'/>
                                                    </form>
                                                    <script>document.forms['samanpayment'].submit()</script>";
                                        }
                                    } else {
                                        echo Helper::Alert_Message('f');
                                    }
                                } else {
                                    // die(Helper::Custom_Msg(Helper::Messages('f'), 3));
                                    echo Helper::Alert_Message('f');
                                }
                            } else {
                                // die(Helper::Custom_Msg(Helper::Messages('confail'), 3));
                                echo Helper::Alert_Message('confail');
                            }
                        } else {
                            $msg = 'حداقل مبلغ قابل پرداخت '.__MINIMUMPAYMENT__.' هزار تومان میباشد';
                            echo Helper::Alert_Custom_Message($msg);
                            // die(Helper::Custom_Msg($msg, 3));
    
                        }
                    }else{
                        $msg="لطفا درگاه پرداخت را انتخاب کنید";
                        echo Helper::Alert_Custom_Message($msg);
                    }
                }else{
                    $msg="لطفا درگاه پرداخت را انتخاب کنید";
                        echo Helper::Alert_Custom_Message($msg);
                }

            } else {
                // die(Helper::Json_Message('af'));
                echo Helper::Alert_Message('af');
            }
        }
        $this->view->pagename = 'charge_credit';
        $this->view->render('charge_credit', 'dashboard_template', '/public/js/charge_credit.js', '/public/js/num2persian.min.js');
    }
}
