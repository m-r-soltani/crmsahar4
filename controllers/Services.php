<?php defined('__ROOT__') or exit('No direct script access allowed');

class Services extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        /*========adsl========*/
        if (isset($_POST['send_services_adsl']) || isset($_POST['send_services_wireless']) || isset($_POST['send_services_tdlte']) || isset($_POST['send_services_bs']) || isset($_POST['send_services_ip'])) {
            if (Helper::Login_Just_Check()) {
                switch ($_SESSION['user_type']) {
                    case __ADMINUSERTYPE__:
                    case __ADMINOPERATORUSERTYPE__:
                        if (isset($_POST['send_services_adsl'])) {
                            unset($_POST['send_services_adsl']);
                        }

                        if (isset($_POST['send_services_wireless'])) {
                            unset($_POST['send_services_wireless']);
                        }

                        if (isset($_POST['send_services_tdlte'])) {
                            unset($_POST['send_services_tdlte']);
                        }
                        if (isset($_POST['send_services_bs'])) {
                            unset($_POST['send_services_bs']);
                        }
                        if (isset($_POST['send_services_ip'])) {
                            unset($_POST['send_services_ip']);
                        }
                        //estefade az Fix_Date_Seperator bayad ghabl az xss_check_array bashad
                        $_POST['tarikhe_shoroe_namayesh'] = Helper::Fix_Date_Seperator($_POST['tarikhe_shoroe_namayesh']);
                        $_POST['tarikhe_payane_namayesh'] = Helper::Fix_Date_Seperator($_POST['tarikhe_payane_namayesh']);
                        $_POST                            = Helper::xss_check_array($_POST);
                        $flag_date1                       = false;
                        $flag_date2                       = false;
                        if (isset($_POST['tarikhe_shoroe_namayesh'])) {
                            $date_arr = array();
                            $date_arr = explode("/", $_POST['tarikhe_shoroe_namayesh']);
                            if (count($date_arr) > 2) {
                                $year                             = (int) Helper::convert_numbers( /*string*/$date_arr[0], /*topersian*/false);
                                $month                            = (int) Helper::convert_numbers( /*string*/$date_arr[1], /*topersian*/false);
                                $day                              = (int) Helper::convert_numbers( /*string*/$date_arr[2], /*topersian*/false);
                                $_POST['tarikhe_shoroe_namayesh'] = Helper::jalali_to_gregorian($year, $month, $day, '/');
                                $flag_date1                       = true;
                            } else {
                                $flag_date1 = false;
                            }
                        }
                        if (isset($_POST['tarikhe_payane_namayesh'])) {
                            $date_arr = array();
                            $date_arr = explode("/", $_POST['tarikhe_payane_namayesh']);
                            if (count($date_arr) > 2) {
                                $year                             = (int) Helper::convert_numbers( /*string*/$date_arr[0], /*topersian*/false);
                                $month                            = (int) Helper::convert_numbers( /*string*/$date_arr[1], /*topersian*/false);
                                $day                              = (int) Helper::convert_numbers( /*string*/$date_arr[2], /*topersian*/false);
                                $_POST['tarikhe_payane_namayesh'] = Helper::jalali_to_gregorian($year, $month, $day, '/');
                                $flag_date2                       = true;
                            } else {
                                $flag_date2 = false;
                            }
                        }
                        ////////zamane estefade be roze ke zabdar 30 mishe
                        // $int_zamane_estefade = abs((int) $_POST['zaname_estefade']);
                        // $str_zamane_estefade = (string) $int_zamane_estefade;
                        // $datetime            = new DateTime($_POST['tarikhe_shoroe_namayesh']);
                        // $datetime->modify('+' . $str_zamane_estefade . 'day');
                        // $_POST['zaname_estefade_be_tarikh'] = $datetime->format('Y/m/d');
                        // $_POST['zaname_estefade_be_tarikh'] = Helper::Add_to_Date($_POST['zaname_estefade']);
                        $_POST['zaname_estefade_be_tarikh'] = Helper::Add_Or_Minus_Day_To_Date($_POST['zaname_estefade'], '+', false);
                        //die($_POST['zaname_estefade_be_tarikh']);
                        $date1 = strtotime($_POST['tarikhe_shoroe_namayesh']);
                        $date2 = strtotime($_POST['tarikhe_payane_namayesh']);
                        ///moghayese tarikhe shoro va payan
                        if ($date1 <= $date2 && $flag_date1 && $flag_date2) {
                            if ($_POST['id'] == "empty") {
                                if(Helper::check_add_access('services')){
                                    unset($_POST['id']);
                                    $sql = Helper::Insert_Generator($_POST, 'bnm_services');
                                    Db::secure_insert_array($sql, $_POST);
                                }else echo Helper::Alert_Message('na');
                            } else {
                                if(Helper::check_update_access('services')){
                                $sql = Helper::Update_Generator($_POST, 'bnm_services', "WHERE id = :id");
                                Db::secure_update_array($sql, $_POST);
                                } else echo Helper:: Alert_Message('na');
                            }
                        } else {
                            echo "<script>alert('لطفا پس از بررسی تاریخ شروع و پایان نمایش مجددا تلاش کنید.');</script>";

                        }
                        break;

                    default:
                        die(Helper::Json_Message('auth_fail'));
                        break;
                }

            } else {
                die(Helper::Json_Message('auth_fail'));
            }

        }
        if (isset($_POST['send_services_voip'])) {
            try {
                if (Helper::Login_Just_Check()) {
                    switch ($_SESSION['user_type']) {
                        case __ADMINUSERTYPE__:
                        case __ADMINOPERATORUSERTYPE__:

                            unset($_POST['send_services_voip']);
                            $_POST['tarikhe_shoroe_namayesh'] = Helper::Fix_Date_Seperator($_POST['tarikhe_shoroe_namayesh']);
                            $_POST['tarikhe_payane_namayesh'] = Helper::Fix_Date_Seperator($_POST['tarikhe_payane_namayesh']);
                            $_POST                            = Helper::xss_check_array($_POST);
                            $flag_date1                       = false;
                            $flag_date2                       = false;
                            if (isset($_POST['tarikhe_shoroe_namayesh'])) {
                                $date_arr = array();
                                $date_arr = explode("/", $_POST['tarikhe_shoroe_namayesh']);
                                if (count($date_arr) > 2) {
                                    $year                             = (int) Helper::convert_numbers( /*string*/$date_arr[0], /*topersian*/false);
                                    $month                            = (int) Helper::convert_numbers( /*string*/$date_arr[1], /*topersian*/false);
                                    $day                              = (int) Helper::convert_numbers( /*string*/$date_arr[2], /*topersian*/false);
                                    $_POST['tarikhe_shoroe_namayesh'] = Helper::jalali_to_gregorian($year, $month, $day, '/');
                                    $flag_date1                       = true;
                                } else {
                                    $flag_date1 = false;
                                }
                            }
                            if (isset($_POST['tarikhe_payane_namayesh'])) {
                                $date_arr = array();
                                $date_arr = explode("/", $_POST['tarikhe_payane_namayesh']);
                                if (count($date_arr) > 2) {
                                    $year                             = (int) Helper::convert_numbers( /*string*/$date_arr[0], /*topersian*/false);
                                    $month                            = (int) Helper::convert_numbers( /*string*/$date_arr[1], /*topersian*/false);
                                    $day                              = (int) Helper::convert_numbers( /*string*/$date_arr[2], /*topersian*/false);
                                    $_POST['tarikhe_payane_namayesh'] = Helper::jalali_to_gregorian($year, $month, $day, '/');
                                    $flag_date2                       = true;
                                } else {
                                    $flag_date2 = false;
                                }
                            }
                            ////////zamane estefade be mahe ke zabdar 30 mishe
                            $_POST['zaname_estefade_be_tarikh'] = Helper::Add_Or_Minus_Day_To_Date($_POST['zaname_estefade'], '+', false);
                            //die($_POST['zaname_estefade_be_tarikh']);
                            $date1 = strtotime($_POST['tarikhe_shoroe_namayesh']);
                            $date2 = strtotime($_POST['tarikhe_payane_namayesh']);
                            ///moghayese tarikhe shoro va payan
                            if ($date1 <= $date2 && $flag_date1 && $flag_date2) {
                                if ($_POST['id'] == "empty") {
                                    unset($_POST['id']);
                                    $sql = Helper::Insert_Generator($_POST, 'bnm_services');
                                    $res = Db::secure_insert_array($sql, $_POST, true);
                                } else {
                                    $sql = Helper::Update_Generator($_POST, 'bnm_services', "WHERE id = :id");
                                    $res = Db::secure_update_array($sql, $_POST, true);
                                }
                            } else {
                                echo "<script>alert('لطفا پس از بررسی تاریخ شروع و پایان نمایش مجددا تلاش کنید.');</script>";
                            }
                            break;

                        default:
                            die(Helper::Json_Message('1'));
                            break;
                    }

                } else {
                    die(Helper::Json_Message('1'));
                }
            } catch (Throwable $e) {
                Helper::Exc_Error_Debug($e, true, '', false);
                die();
            }
        }
        /*========wireless========*/
        /*
        if (isset($_POST['send_services_wireless'])) {
        if (Helper::Login_Just_Check()) {
        switch ($_SESSION['user_type']) {
        case '1':
        unset($_POST['send_services_wireless']);
        $_POST['tarikhe_shoroe_namayesh'] = Helper::Fix_Date_Seperator($_POST['tarikhe_shoroe_namayesh']);
        $_POST['tarikhe_payane_namayesh'] = Helper::Fix_Date_Seperator($_POST['tarikhe_payane_namayesh']);
        $_POST                            = Helper::xss_check_array($_POST);
        $flag_date1                       = false;
        $flag_date2                       = false;
        if (isset($_POST['tarikhe_shoroe_namayesh'])) {
        $date_arr = array();
        $date_arr = explode("/", $_POST['tarikhe_shoroe_namayesh']);
        if (count($date_arr) > 2) {
        $year                             = (int) Helper::convert_numbers( $date_arr[0], false);
        $month                            = (int) Helper::convert_numbers( $date_arr[1], false);
        $day                              = (int) Helper::convert_numbers( $date_arr[2], false);
        $_POST['tarikhe_shoroe_namayesh'] = Helper::jalali_to_gregorian($year, $month, $day, '/');
        $flag_date1                       = true;
        } else {
        $flag_date1 = false;
        }
        }
        if (isset($_POST['tarikhe_payane_namayesh'])) {
        $date_arr = array();
        $date_arr = explode("/", $_POST['tarikhe_payane_namayesh']);
        if (count($date_arr) > 2) {
        $year                             = (int) Helper::convert_numbers( $date_arr[0], false);
        $month                            = (int) Helper::convert_numbers( $date_arr[1], false);
        $day                              = (int) Helper::convert_numbers( $date_arr[2], false);
        $_POST['tarikhe_payane_namayesh'] = Helper::jalali_to_gregorian($year, $month, $day, '/');
        $flag_date2                       = true;
        } else {
        $flag_date2 = false;
        }
        }
        ////////zamane estefade be mahe ke zabdar 30 mishe
        $int_zamane_estefade = abs((int) $_POST['zaname_estefade']);
        $str_zamane_estefade = (string) $int_zamane_estefade;
        $datetime            = new DateTime($_POST['tarikhe_shoroe_namayesh']);
        $datetime->modify('+' . $str_zamane_estefade . 'day');
        $_POST['zaname_estefade_be_tarikh'] = $datetime->format('Y/m/d');

        $date1 = strtotime($_POST['tarikhe_shoroe_namayesh']);
        $date2 = strtotime($_POST['tarikhe_payane_namayesh']);
        ///moghayese tarikhe shoro va payan
        if ($date1 <= $date2) {
        if ($_POST['id'] == "empty") {
        unset($_POST['id']);
        $sql = Helper::Insert_Generator($_POST, 'bnm_services');
        Db::secure_insert_array($sql, $_POST);
        } else {
        $sql = Helper::Update_Generator($_POST, 'bnm_services', "WHERE id = :id");
        Db::secure_update_array($sql, $_POST);
        }
        } else {
        echo "<script>alert('لطفا پس از بررسی تاریخ شروع و پایان نمایش مجددا تلاش کنید.');</script>";
        }
        break;
        default:
        die(Helper::Json_Message('auth_fail'));
        break;
        }
        }
        }
         */
        /*========tdlte========*/
        /*
        if (isset($_POST['send_services_tdlte'])) {
        unset($_POST['send_services_tdlte']);
        $_POST = Helper::xss_check_array($_POST);
        if (isset($_POST['tarikhe_shoroe_namayesh'])) {
        $date_arr = array();
        $date_arr = explode("/", $_POST['tarikhe_shoroe_namayesh']);
        if (count($date_arr) > 2) {
        $year                             = (int) Helper::convert_numbers($date_arr[0], false);
        $month                            = (int) Helper::convert_numbers($date_arr[1], false);
        $day                              = (int) Helper::convert_numbers($date_arr[2], false);
        $_POST['tarikhe_shoroe_namayesh'] = Helper::jalali_to_gregorian($year, $month, $day, '/');
        }
        }
        if (isset($_POST['tarikhe_payane_namayesh'])) {
        $date_arr = array();
        $date_arr = explode("/", $_POST['tarikhe_payane_namayesh']);
        if (count($date_arr) > 2) {
        $year                             = (int) Helper::convert_numbers($date_arr[0], false);
        $month                            = (int) Helper::convert_numbers($date_arr[1], false);
        $day                              = (int) Helper::convert_numbers($date_arr[2], false);
        $_POST['tarikhe_payane_namayesh'] = Helper::jalali_to_gregorian($year, $month, $day, '/');
        }
        }
        ////////zamane estefade be mahe ke zabdar 30 mishe
        $int_zamane_estefade = abs((int) $_POST['zaname_estefade']);
        $str_zamane_estefade = (string) $int_zamane_estefade;
        $datetime            = new DateTime($_POST['tarikhe_shoroe_namayesh']);
        $datetime->modify('+' . $str_zamane_estefade . 'day');
        $_POST['zaname_estefade_be_tarikh'] = $datetime->format('Y/m/d');

        $date1 = strtotime($_POST['tarikhe_shoroe_namayesh']);
        $date2 = strtotime($_POST['tarikhe_payane_namayesh']);
        ///moghayese tarikhe shoro va payan
        if ($date1 <= $date2) {
        if ($_POST['id'] == "empty") {
        unset($_POST['id']);
        $sql = Helper::Insert_Generator($_POST, 'bnm_services');
        Db::secure_insert_array($sql, $_POST);
        } else {
        $sql = Helper::Update_Generator($_POST, 'bnm_services', "WHERE id = :id");
        Db::secure_update_array($sql, $_POST);
        }
        } else {
        echo "<script>alert('لطفا پس از بررسی تاریخ شروع و پایان نمایش مجددا تلاش کنید.');</script>";
        }

        }
         */

        /*========voip========*/

        $this->view->pagename = 'services';
        $this->view->render('services', 'dashboard_template', '/public/js/services.js', false);

    }
}
