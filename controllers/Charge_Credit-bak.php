<?php defined('__ROOT__') or exit('No direct script access allowed');

class Charge_Credit extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if (isset($_POST['State'])) {
            
            if (Helper::Login_Just_Check()) {
                $_POST['State'] = strtolower($_POST['State']);
                switch ($_POST['State']) {
                    case 'ok':
                        //check RefNum in database
                        $sql    = "SELECT count(*) as rows_num FROM bnm_sep_payment WHERE refnum=?";
                        $result = Db::secure_fetchall($sql, array($_POST['RefNum']));
                        if (Helper::Is_Empty_OR_Null($_POST['RefNum'])) {
                            if ($result[0]['rows_num'] === 0) {
                                //update bnm_sep_payment
                                //refnum is ok proceed...
                                try {
                                    $arr                 = array();
                                    $arr['state']        = $_POST['State'];
                                    $arr['statecode']    = $_POST['StateCode'];
                                    $arr['id']           = $_SESSION['sep_id'];
                                    $arr['refnum']       = $_POST['RefNum'];
                                    $arr['cid']          = $_POST['CID'];
                                    $arr['traceno']      = $_POST['TRACENO'];
                                    $arr['rrn']          = $_POST['RRN'];
                                    $arr['amount']       = $_POST['Amount'];
                                    $arr['securepan']    = $_POST['SecurePan'];
                                    $arr['mid']          = $_POST['MID'];
                                    $arr['final_status'] = 'before_verify';
                                    $sql                 = Helper::Update_Generator($arr, 'bnm_sep_payment', "WHERE id = :id");
                                    $res                 = Db::secure_update_array($sql, $arr);
                                    if ($res) {
                                        $soapclient = new soapclient(__SAMANVERIFYURL__);
                                        $res_verify = $soapclient->VerifyTransaction($_POST['RefNum'], __SAMANMERCHANTCODE__);
                                        if ($res_verify <= 0) {
                                            ///set final_status = false
                                            $arr                 = array();
                                            $arr['final_status'] = 'verify_not_ok';
                                            $arr['id']           = $_SESSION['sep_id'];
                                            $sql                 = Helper::Update_Generator($arr, 'bnm_sep_payment', "WHERE id = :id");
                                            $res                 = Db::secure_update_array($sql, $arr);
                                            echo Helper::Alert_Message('f');
                                        } else {
                                            if ($_SESSION['sep_amount'] === $res_verify) {
                                                ///trakonesh be dorosti anjam shode
                                                ///set final_status = true
                                                $arr                 = array();
                                                $arr['final_status'] = '';
                                                $arr['id']           = $_SESSION['sep_id'];
                                                $arr['amount']       = $res_verify;
                                                $arr['state']        = $_POST['State'];
                                                $arr['statecode']    = $_POST['StateCode'];
                                                $arr['refnum']       = $_POST['RefNum'];
                                                $arr['cid']          = $_POST['CID'];
                                                $arr['traceno']      = $_POST['TRACENO'];
                                                $arr['rrn']          = $_POST['RRN'];
                                                $arr['securepan']    = $_POST['SecurePan'];
                                                $arr['mid']          = $_POST['MID'];
                                                $sql                 = Helper::Update_Generator($arr, 'bnm_sep_payment', "WHERE id = :id");
                                                $res                 = Db::secure_update_array($sql, $arr);
                                                $noe_user            = '';
                                                switch ($_SESSION['user_type']) {
                                                    case __ADMINUSERTYPE__:
                                                    case __ADMINOPERATORUSERTYPE__:
                                                        $noe_user = '0';
                                                        break;
                                                    case __MODIRUSERTYPE__:
                                                    case __MODIR2USERTYPE__:
                                                        /////////////////////////send sms///////////////////////////
                                                        try {
                                                            $res_modir = Helper::Select_By_Multiple_Params('bnm_operator', array('id' => $_SESSION['user_id'], 'user_type' => __MODIRUSERTYPE__));
                                                            if ($res_modir) {
                                                                if ($res_modir[0]['branch_id'] !== 0 && Helper::Is_Empty_OR_Null($res_modir[0]['branch_id'])) {
                                                                    ////user sahar
                                                                    $res_internal = Helper::Internal_Message_By_Karbord('sharje_bn', '1');
                                                                    if ($res_internal) {
                                                                        $res_sms_request = Helper::Write_In_Sms_Request($res_modir[0]['telephone_hamrah'], Helper::Today_Miladi_Date(),
                                                                            Helper::Today_Miladi_Date(), 1, $res_internal[0]['id'], '2');
                                                                        if ($res_sms_request) {
                                                                            $arr               = array();
                                                                            $arr['receiver']   = $res_modir[0]['telephone_hamrah'];
                                                                            $arr['sender']     = __SMSNUMBER__;
                                                                            $arr['request_id'] = $res_sms_request;
                                                                            $res               = Helper::Write_In_Sms_Queue($arr);
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        } catch (Throwable $e) {

                                                        }
                                                        /////////////////////////send sms///////////////////////////
                                                        $noe_user = '2';
                                                        break;
                                                    case __OPERATORUSERTYPE__:
                                                    case __OPERATOR2USERTYPE__:

                                                        try {
                                                            $res_modir = Helper::Select_By_Multiple_Params('bnm_operator', array('branch_id' => $_SESSION['branch_id'], 'user_type' => __MODIRUSERTYPE__));
                                                            if ($res_modir) {
                                                                if ($res_modir[0]['branch_id'] !== 0 && Helper::Is_Empty_OR_Null($res_modir[0]['branch_id'])) {
                                                                    $res_internal = Helper::Internal_Message_By_Karbord('sharje_bn', '1');
                                                                    if ($res_internal) {
                                                                        $res_sms_request = Helper::Write_In_Sms_Request($res_modir[0]['telephone_hamrah'], Helper::Today_Miladi_Date(),
                                                                            Helper::Today_Miladi_Date(), 1, $res_internal[0]['id'], '2');
                                                                        if ($res_sms_request) {
                                                                            $arr               = array();
                                                                            $arr['receiver']   = $res_modir[0]['telephone_hamrah'];
                                                                            $arr['sender']     = __SMSNUMBER__;
                                                                            $arr['request_id'] = $res_sms_request;
                                                                            $res               = Helper::Write_In_Sms_Queue($arr);
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        } catch (Throwable $e) {

                                                        }
                                                        $noe_user = '2';
                                                        break;
                                                            case __MOSHTARAKUSERTYPE__:
                                                        try {
                                                            //$res_operator    = Helper::Select_By_Id('bnm_operator', $_SESSION['user_id']);
                                                            if ($_SESSION['branch_id'] === 0) {
                                                                //user sahar
                                                                $res_sub = Helper::Select_By_Id('bnm_subscribers', $_SESSION['user_id']);
                                                                if ($res_sub) {
                                                                    $res_internal = Helper::Internal_Message_By_Karbord('sharje_bms', '1');
                                                                    if ($res_internal) {
                                                                        $res_sms_request = Helper::Write_In_Sms_Request($res_sub[0]['telephone_hamrah'], Helper::Today_Miladi_Date(),
                                                                            Helper::Today_Miladi_Date(), 1, $res_internal[0]['id'], '2');
                                                                        if ($res_sms_request) {
                                                                            $arr               = array();
                                                                            $arr['receiver']   = $res_sub[0]['telephone_hamrah'];
                                                                            $arr['sender']     = __SMSNUMBER__;
                                                                            $arr['request_id'] = $res_sms_request;
                                                                            $res               = Helper::Write_In_Sms_Queue($arr);
                                                                        }
                                                                    }
                                                                }
                                                            } else {
                                                                //user namayande
                                                                $res_sub = Helper::Select_By_Id('bnm_subscribers', $_SESSION['user_id']);
                                                                if ($res_sub) {

                                                                    $res_internal = Helper::Internal_Message_By_Karbord('sharje_bmn', '1');
                                                                    if ($res_internal) {
                                                                        $res_sms_request = Helper::Write_In_Sms_Request($res_sub[0]['telephone_hamrah'], Helper::Today_Miladi_Date(),
                                                                            Helper::Today_Miladi_Date(), 1, $res_internal[0]['id'], '2');
                                                                        if ($res_sms_request) {
                                                                            $arr               = array();
                                                                            $arr['receiver']   = $res_sub[0]['telephone_hamrah'];
                                                                            $arr['sender']     = __SMSNUMBER__;
                                                                            $arr['request_id'] = $res_sms_request;
                                                                            $res               = Helper::Write_In_Sms_Queue($arr);
                                                                        }
                                                                    }

                                                                }
                                                            }

                                                        } catch (Throwable $e) {

                                                        }
                                                        $noe_user = '1';
                                                        break;
                                                    default:
                                                        $noe_user = $_SESSION['user_type'];
                                                        break;
                                                }

                                                $sql        = "SELECT * FROM bnm_credits WHERE user_or_branch_id = ? AND noe_user=? ORDER BY id DESC LIMIT 1";
                                                $res_credit = Db::secure_fetchall($sql, array($_SESSION['user_id'], $noe_user));
                                                if ($res_credit) {
                                                    //ghablan hesab darad
                                                    $credit_array                      = array();
                                                    $credit_array['noe_user']          = $noe_user;
                                                    $credit_array['user_or_branch_id'] = $_SESSION['user_id'];
                                                    $credit_array['credit']            = floatval($res_credit[0]['credit']) + $res_verify;
                                                    $credit_array['bestankar']         = $res_verify;
                                                    $credit_array['bestankar']         = 0;
                                                    $credit_array['tozihat']           = 'پرداخت از درگاه بانکی در تاریخ ' . Helper::Today_Shamsi_Date() . 'شماره پیگیری' . $_POST['TRACENO'];
                                                    $sql                               = Helper::Insert_Generator($credit_array, 'bnm_credits');
                                                    $res_new_credit                    = Db::secure_insert_array($sql, $credit_array);
                                                    if ($res_new_credit) {
                                                        echo "<script>alert('تراکنش با موفقیت انجام شد و حساب شما شارژ شد اکنون میتوانید فاکتور مورد نظر را پرداخت کنید.');</script>";
                                                        echo "<script>alert('شماره پیگیری : {$_POST['TRACENO']}');</script>";
                                                    } else {
                                                        echo "<script>alert('کاربر محترم تراکنش شما با موفقیت انجام شد اما متاسفانه حساب شما شارژ نشد لطفا جهت پیگیری با شرکت تماس حاصل فرمایید.');</script>";
                                                        echo "<script>alert('شماره پیگیری : {$_POST['TRACENO']}');</script>";
                                                    }
                                                } else {
                                                    //sakhte hesabe credit baraye user
                                                    $credit_array                      = array();
                                                    $credit_array['noe_user']          = $noe_user;
                                                    $credit_array['user_or_branch_id'] = $_SESSION['user_id'];
                                                    $credit_array['credit']            = $res_verify;
                                                    $credit_array['bestankar']         = $res_verify;
                                                    $credit_array['bestankar']         = 0;
                                                    $credit_array['tozihat']           = 'پرداخت از درگاه بانکی در تاریخ ' . Helper::Today_Shamsi_Date();
                                                    $sql                               = Helper::Insert_Generator($credit_array, 'bnm_credits');
                                                    $res_new_credit                    = Db::secure_insert_array($sql, $credit_array);
                                                    if ($res_new_credit) {
                                                        echo "<script>alert('تراکنش با موفقیت انجام شد و حساب شما شارژ شد اکنون میتوانید فاکتور مورد نظر را پرداخت کنید.');</script>";
                                                        echo "<script>alert('شماره پیگیری : {$_POST['TRACENO']}');</script>";
                                                    } else {
                                                        echo "<script>alert('کاربر محترم تراکنش شما با موفقیت انجام شد اما متاسفانه حساب شما شارژ نشد لطفا جهت پیگیری با شرکت تماس حاصل فرمایید.');</script>";
                                                        echo "<script>alert('شماره پیگیری : {$_POST['TRACENO']}');</script>";
                                                    }
                                                }
                                            } else {
                                                echo "<script>alert('تراکنش شما از طرف شرکت نامعتبر است جهت پیگیری دکمه تایید را بزنید.');</script>";
                                                echo "<script>alert('شماره پیگیری : {$_POST['TRACENO']}');</script>";
                                            }
                                        }
                                    } else {
                                        echo "<script>alert('تراکنش ناموفق در صورت کسر مبلغ از حساب شما مبلغ پرداختی طی 72 ساعت آینده از طرف بانک به حساب شما برگشت داده خواهد شد.');</script>";
                                    }
                                } catch (Throwable $e) {
                                    $res = Helper::Exc_Pretty_Error($e, true, '', true);
                                    die();
                                }
                            } else {
                                echo "<script>alert('تراکنش شما نامعتبر است.');</script>";
                            }
                        } else {
                            //refnum is null
                            $arr                 = array();
                            $arr['state']        = $_POST['State'];
                            $arr['statecode']    = $_POST['StateCode'];
                            $arr['id']           = $_POST['ResNum'];
                            $arr['refnum']       = $_POST['RefNum'];
                            $arr['cid']          = $_POST['CID'];
                            $arr['traceno']      = $_POST['TRACENO'];
                            $arr['rrn']          = $_POST['RRN'];
                            $arr['amount']       = $_POST['Amount'];
                            $arr['securepan']    = $_POST['SecurePan'];
                            $arr['mid']          = $_POST['MID'];
                            $arr['final_status'] = '';
                            $sql                 = Helper::Update_Generator($arr, 'bnm_sep_payment', "WHERE id = :id");
                            $res                 = Db::secure_update_array($sql, $arr);
                            echo "<script>alert('عملیات ناموفق.');</script>";
                        }

                        break;
						case 'canceledbyuser':
						case 'failed':
						case 'sessionisnull':
						case 'invalidparameters':
						case 'merchantipaddressisinvalid':
						case 'tokennotfound':
						case 'tokenrequired':
						case 'terminalnotfound':
						case 'tme error':
							$arr                 = array();
                            $arr['state']        = $_POST['State'];
                            $arr['statecode']    = $_POST['StateCode'];
                            $arr['id']           = $_SESSION['sep_id'];
                            $arr['refnum']       = $_POST['RefNum'];
                            $arr['cid']          = $_POST['CID'];
                            $arr['traceno']      = $_POST['TRACENO'];
                            $arr['rrn']          = $_POST['RRN'];
                            $arr['amount']       = $_POST['Amount'];
                            $arr['securepan']    = $_POST['SecurePan'];
                            $arr['mid']          = $_POST['MID'];
                            $arr['final_status'] = 'before_verify';
                            $sql                 = Helper::Update_Generator($arr, 'bnm_sep_payment', "WHERE id = :id");
                            $res                 = Db::secure_update_array($sql, $arr);
							echo "<script>alert('عملیات ناموفق.');</script>";
							//echo "<script>{$arr['state']}</script>";
						break;

                    default:
                        echo "<script>alert('عملیات ناموفق.');</script>";
                        break;
                }
            } else {
                echo "<script>alert('مشخصات کاربری شما یافت نشد بنابر این قادر به ادامه عملیات پرداخت نیستید.');</script>";
            }
        }
        //////////validating charge amount
        if (isset($_POST['send_charge_credit'])) {
            if (Helper::Login_Just_Check()) {
                // parse_str($_POST[key($_POST)], $_POST);
                $_POST                  = Helper::xss_check_array($_POST);
                $_POST['charge_amount'] = Helper::str_trim($_POST['charge_amount']);
                $_POST['charge_amount'] = floatval($_POST['charge_amount']);
                if ($_POST['charge_amount'] >= 50000) {
                    $arr              = array();
                    $arr['user_id']   = $_SESSION['user_id'];
                    $arr['user_type'] = $_SESSION['user_type'];
                    //$arr['ip_address']      = $_SESSION['ip_address'];
                    $arr['branch_id']     = $_SESSION['branch_id'];
                    $arr['charge_amount'] = $_POST['charge_amount'];
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
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:
                            try {
                                $sql = Helper::Insert_Generator($arr, 'bnm_sep_payment');
                                $res = Db::secure_insert_array($sql, $arr);
                                // $sql = "SELECT LAST_INSERT_ID() FROM bnm_sep_payment";
                                // $res_id = Db::fetchall_Query($sql);
                                $id                                  = $res;
                                $res_sep_payment                     = Db::secure_fetchall("SELECT * FROM bnm_sep_payment WHERE id = ?", array($id));
                                $res_sep_payment[0]['charge_amount'] = floatval($res_sep_payment[0]['charge_amount']);
                                if ($res_sep_payment && is_array($res_sep_payment) && count($res_sep_payment) > 0 &&
                                    $res_sep_payment[0]['user_id'] == $_SESSION['user_id'] && $res_sep_payment[0]['user_type'] == $_SESSION['user_type']) {
                                    $_SESSION['sep_id']     = $res_sep_payment[0]['id'];
                                    $_SESSION['sep_amount'] = floatval($res_sep_payment[0]['charge_amount']);
                                    //GET SAMAN TOKEN
									$token_init=[
									"action"=>"token",
									"TerminalId"=>__SAMANMERCHANTCODE__,
									"RedirectUrl"=>__SAMANREDIRECTURL__,
									"ResNum"=>$_SESSION['sep_id'],
									"Amount"=>$_SESSION['sep_amount']
									];
									
									$token	=Helper::Simple_Rest("POST",__SAMANTOKENURL__,json_encode($token_init));
									$token	= json_decode($token,true);
                                    die(print_r($token));
									if($token){
										///connection ok but lets see the response
										if($token['status']===1){
											//redirect user to pardakht page
											$_SESSION['saman_token']=$token['token'];											
											echo "<form id='samanpeyment' action='".__SAMANPARDAKHTURL__."' method='post'>
														<input type='hidden' name='Token' value='{$_SESSION['saman_token']}'/>
														<input name='GetMethod' type='hidden' value='false'/>
												</form>
												<script>document.forms['samanpeyment'].submit()</script>";
												/*
												echo "<form id='samanpeyment' action='https://sep.shaparak.ir/payment.aspx' method='post'>
															<input type='hidden' name='Amount' value='{$res_sep_payment[0]['charge_amount']}' />
															<input type='hidden' name='ResNum' value='{$res_sep_payment[0]['id']}'>
															<input type='hidden' name='RedirectURL' value='{__SAMANREDIRECTURL__}'/>
															<input type='hidden' name='MID' value='{__SAMANMERCHANTCODE__}'/>
													</form>
													<script>document.forms['samanpeyment'].submit()</script>";
												*/
										}elseif($token['status']=== -1){
											//something went wrong
											echo Helper::Alert_Message('t2');
										}else{
											//maloom nis to on banke kharabshode chekhabare
											echo Helper::Alert_Message('t3');
										}
										
									}else{
										///connection failed
										echo Helper::Alert_Message('confail');
									}
                                } else {
                                    //die('asdasdas');
                                    //die(Helper::Json_Message('f'));
                                    echo Helper::Alert_Message('f');
                                }

                            } catch (Throwable $e) {
                                $res = Helper::Exc_Pretty_Error($e, true, '', false);
                                die();
                            }
                            break;
                                case __MODIRUSERTYPE__:
                                case __OPERATORUSERTYPE__:
                                case __MODIR2USERTYPE__:
                                case __OPERATOR2USERTYPE__:
                            try {
                                $sql = Helper::Insert_Generator($arr, 'bnm_sep_payment');
                                $res = Db::secure_insert_array($sql, $arr);
                                $id                                  = $res;
                                if($res){
                                    $res_sep_payment                     = Db::secure_fetchall("SELECT * FROM bnm_sep_payment WHERE id = ?", array($id));
                                    $res_sep_payment[0]['charge_amount'] = floatval($res_sep_payment[0]['charge_amount']);
                                    if ($res_sep_payment && $res_sep_payment[0]['user_id'] == $_SESSION['user_id'] && $res_sep_payment[0]['user_type'] === $_SESSION['user_type']) {
                                        $_SESSION['sep_id']     = $res_sep_payment[0]['id'];
                                        $_SESSION['sep_amount'] = floatval($res_sep_payment[0]['charge_amount']);
                                        //GET SAMAN TOKEN
                                        $token_init=[
                                        "action"=>"token",
                                        "TerminalId"=>__SAMANMERCHANTCODE__,
                                        "RedirectUrl"=>__SAMANREDIRECTURL__,
                                        "ResNum"=>$_SESSION['sep_id'],
                                        "Amount"=>$_SESSION['sep_amount']
                                        ];
                                        $token	= Helper::Simple_Rest("POST",__SAMANTOKENURL__,json_encode($token_init));
                                        $token	= json_decode($token,true);
                                        if($token){
                                            ///connection ok but lets see the response
                                            if($token['status']===1){
                                                //redirect user to pardakht page
                                                $_SESSION['saman_token']=$token['token'];											
                                                echo "<form id='samanpeyment' action='".__SAMANPARDAKHTURL__."' method='post'>
                                                            <input type='hidden' name='Token' value='{$_SESSION['saman_token']}'/>
                                                            <input name='GetMethod' type='hidden' value='false'/>
                                                    </form>
                                                    <script>document.forms['samanpeyment'].submit()</script>";
                                                    /*
                                                    echo "<form id='samanpeyment' action='https://sep.shaparak.ir/payment.aspx' method='post'>
                                                                <input type='hidden' name='Amount' value='{$res_sep_payment[0]['charge_amount']}' />
                                                                <input type='hidden' name='ResNum' value='{$res_sep_payment[0]['id']}'>
                                                                <input type='hidden' name='RedirectURL' value='{__SAMANREDIRECTURL__}'/>
                                                                <input type='hidden' name='MID' value='{__SAMANMERCHANTCODE__}'/>
                                                        </form>
                                                        <script>document.forms['samanpeyment'].submit()</script>";
                                                    */
                                            }elseif($token['status']=== -1){
                                                //something went wrong
                                                echo Helper::Alert_Message('t2');
                                            }else{
                                                //maloom nis to on banke kharabshode chekhabare
                                                echo Helper::Alert_Message('t3');
                                            }
                                            
                                        }else{
                                            ///connection failed
                                            echo Helper::Alert_Message('confail');
                                        }
                                    } else {
                                        echo Helper::Alert_Message('f');
                                    }
                                }else{
                                    die(Helper::Json_Message('f'));
                                }

                            } catch (Throwable $e) {
                                $res = Helper::Exc_Pretty_Error($e, true, '', false);
                                die();
                            }
                            break;
                                case __MOSHTARAKUSERTYPE__:
								/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                            try {
                                $sql = Helper::Insert_Generator($arr, 'bnm_sep_payment');
                                $res = Db::secure_insert_array($sql, $arr);
                                $id                                  = $res;
                                $res_sep_payment                     = Db::secure_fetchall("SELECT * FROM bnm_sep_payment WHERE id = ?", array($id));
                                $res_sep_payment[0]['charge_amount'] = floatval($res_sep_payment[0]['charge_amount']);
                                if ($res_sep_payment && is_array($res_sep_payment) && count($res_sep_payment) > 0 &&
                                    $res_sep_payment[0]['user_id'] == $_SESSION['user_id'] && $res_sep_payment[0]['user_type'] == $_SESSION['user_type']) {
                                    $_SESSION['sep_id']     = $res_sep_payment[0]['id'];
                                    $_SESSION['sep_amount'] = floatval($res_sep_payment[0]['charge_amount']);
									//GET SAMAN TOKEN
									$token_init=[
									"action"=>"token",
									"TerminalId"=>__SAMANMERCHANTCODE__,
									"RedirectUrl"=>__SAMANREDIRECTURL__,
									"ResNum"=>$_SESSION['sep_id'],
									"Amount"=>$_SESSION['sep_amount']
									];
									
									$token	=Helper::Simple_Rest("POST",__SAMANTOKENURL__,json_encode($token_init));
									$token	= json_decode($token,true);
									if($token){
										///connection ok but lets see the response
										if($token['status']===1){
											//redirect user to pardakht page
											$_SESSION['saman_token']=$token['token'];											
											echo "<form id='samanpeyment' action='".__SAMANPARDAKHTURL__."' method='post'>
														<input type='hidden' name='Token' value='{$_SESSION['saman_token']}'/>
														<input name='GetMethod' type='hidden' value='false'/>
												</form>
												<script>document.forms['samanpeyment'].submit()</script>";
												/*
												echo "<form id='samanpeyment' action='https://sep.shaparak.ir/payment.aspx' method='post'>
															<input type='hidden' name='Amount' value='{$res_sep_payment[0]['charge_amount']}' />
															<input type='hidden' name='ResNum' value='{$res_sep_payment[0]['id']}'>
															<input type='hidden' name='RedirectURL' value='{__SAMANREDIRECTURL__}'/>
															<input type='hidden' name='MID' value='{__SAMANMERCHANTCODE__}'/>
													</form>
													<script>document.forms['samanpeyment'].submit()</script>";
												*/
										}elseif($token['status']=== -1){
											//something went wrong
											echo Helper::Alert_Message('t2');
										}else{
											//maloom nis to on banke kharabshode chekhabare
											echo Helper::Alert_Message('t3');
										}
										
									}else{
										///connection failed
										echo Helper::Alert_Message('confail');
									}
                                } else {
                                    echo Helper::Alert_Message('f');
                                }

                            } catch (Throwable $e) {
                                $res = Helper::Exc_Pretty_Error($e, true, '', false);
                                die();
                            }
							/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                            break;

                        default:
                            die(Helper::Json_Message('af'));
                            break;
                    }
                } else {
                    echo "<script>alert('حداقل مبلغ قابل پرداخت 5000 تومان میباشد');</script>";
                }
            } else {
                die(Helper::Json_Message('af'));
            }

        }
        $this->view->pagename = 'charge_credit';
        $this->view->render('charge_credit', 'dashboard_template', '/public/js/charge_credit.js', false);
    }
}
