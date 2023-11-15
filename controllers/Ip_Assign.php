<?php defined('__ROOT__') or exit('No direct script access allowed');
class Ip_Assign extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

        if(isset($_POST['send_bandwidth_ipassign'])){
            parse_str($_POST[key($_POST)], $_POST);
            $_POST = Helper::xss_check_array($_POST);
            $_POST['servicetype']="bandwidth";
            $_POST['tarikhe_shoroe_ip']=Helper::TabdileTarikh($_POST['tarikhe_shoroe_ip'], 2, '/', '-');
            if($_POST['tarikhe_shoroe_ip']) {
                $_POST['tarikhe_shoroe_ip']= Helper::fixDateDigit($_POST['tarikhe_shoroe_ip'],'-');
                $_POST['tarikhe_shoroe_ip']=$_POST['tarikhe_shoroe_ip'].' '.Helper::nowShamsihisv();
            }
            $_POST['tarikhe_payane_ip']=Helper::TabdileTarikh($_POST['tarikhe_payane_ip'], 2, '/', '-');
            if($_POST['tarikhe_payane_ip']) {
                $_POST['tarikhe_payane_ip']= Helper::fixDateDigit($_POST['tarikhe_payane_ip'],'-');
                $_POST['tarikhe_payane_ip']=$_POST['tarikhe_payane_ip'].' '.Helper::nowShamsihisv();
            }
            $_POST['tarikhe_shoroe_service']=Helper::TabdileTarikh($_POST['tarikhe_shoroe_service'], 2, '/', '-');
            if($_POST['tarikhe_shoroe_service']) {
                $_POST['tarikhe_shoroe_service']= Helper::fixDateDigit($_POST['tarikhe_shoroe_service'],'-');
                $_POST['tarikhe_shoroe_service']=$_POST['tarikhe_shoroe_service'].' '.Helper::nowShamsihisv();
            }
            $_POST['tarikhe_payane_service']=Helper::TabdileTarikh($_POST['tarikhe_payane_service'], 2, '/', '-');
            if($_POST['tarikhe_payane_service']) {
                $_POST['tarikhe_payane_service']= Helper::fixDateDigit($_POST['tarikhe_payane_service'],'-');
                $_POST['tarikhe_payane_service']=$_POST['tarikhe_payane_service'].' '.Helper::nowShamsihisv();
            }
            $_POST['tarikhe_talighe_ip']=Helper::TabdileTarikh($_POST['tarikhe_talighe_ip'], 2, '/', '-');
            if($_POST['tarikhe_talighe_ip']) {
                $_POST['tarikhe_talighe_ip']= Helper::fixDateDigit($_POST['tarikhe_talighe_ip'],'-');
                $_POST['tarikhe_talighe_ip']=$_POST['tarikhe_talighe_ip'].' '.Helper::nowShamsihisv();
            }
            if($_POST['id']==="empty"){
                unset($_POST['id']);
                $sql=Helper::Insert_Generator($_POST,'bnm_ip_assign');
                $res=Db::secure_insert_array($sql,$_POST);
                if(! $res) die(Helper::Json_Message('f'));
                die(Helper::Custom_Msg(Helper::Messages('s'),1));
            }else{
                die(Helper::Custom_Msg('برای ویرایش با مهندس سلطانی تماس بگیرید'));
            }
            die(Helper::Json_Message('e'));
        }

        if(isset($_POST['send_adslvdsl_ipassign'])){
            parse_str($_POST[key($_POST)], $_POST);
            $_POST = Helper::xss_check_array($_POST);
            // $_POST['servicetype']="bandwidth";
            $factor = Helper::getServiceInfoByFactorid($_POST['service']);
            if(! isset($factor)) die(Helper::Custom_Msg(Helper::Messages('serviceinf'),2));
            if (!$factor) die(Helper::Custom_Msg(Helper::Messages('serviceinf'),2));
            unset($_POST['service']);
            unset($_POST['tarikhe_shoroe_service']);
            unset($_POST['tarikhe_payane_service']);
            $_POST['fid'] = $factor[0]['fid'];
            $_POST['emkanat_id'] = $factor[0]['emkanat_id'];
            $_POST['servicetype'] = $factor[0]['sertype'];
            $_POST['sub'] = $factor[0]['subid'];
            $_POST['tarikhe_shoroe_ip']=Helper::TabdileTarikh($_POST['tarikhe_shoroe_ip'], 2, '/', '-');
            if($_POST['tarikhe_shoroe_ip']) {
                $_POST['tarikhe_shoroe_ip']= Helper::fixDateDigit($_POST['tarikhe_shoroe_ip'],'-');
                $_POST['tarikhe_shoroe_ip']=$_POST['tarikhe_shoroe_ip'].' '.Helper::nowShamsihisv();
            }
            $_POST['tarikhe_payane_ip']=Helper::TabdileTarikh($_POST['tarikhe_payane_ip'], 2, '/', '-');
            if($_POST['tarikhe_payane_ip']) {
                $_POST['tarikhe_payane_ip']= Helper::fixDateDigit($_POST['tarikhe_payane_ip'],'-');
                $_POST['tarikhe_payane_ip']=$_POST['tarikhe_payane_ip'].' '.Helper::nowShamsihisv();
            }

            // $_POST['tarikhe_shoroe_service']=Helper::TabdileTarikh($_POST['tarikhe_shoroe_service'], 2, '/', '-');
            // if($_POST['tarikhe_shoroe_service']) {
            //     $_POST['tarikhe_shoroe_service']= Helper::fixDateDigit($_POST['tarikhe_shoroe_service'],'-');
            //     $_POST['tarikhe_shoroe_service']=$_POST['tarikhe_shoroe_service'].' '.Helper::nowShamsihisv();
            // }
            // $_POST['tarikhe_payane_service']=Helper::TabdileTarikh($_POST['tarikhe_payane_service'], 2, '/', '-');
            // if($_POST['tarikhe_payane_service']) {
            //     $_POST['tarikhe_payane_service']= Helper::fixDateDigit($_POST['tarikhe_payane_service'],'-');
            //     $_POST['tarikhe_payane_service']=$_POST['tarikhe_payane_service'].' '.Helper::nowShamsihisv();
            // }
            $_POST['tarikhe_talighe_ip']=Helper::TabdileTarikh($_POST['tarikhe_talighe_ip'], 2, '/', '-');
            if($_POST['tarikhe_talighe_ip']) {
                $_POST['tarikhe_talighe_ip']= Helper::fixDateDigit($_POST['tarikhe_talighe_ip'],'-');
                $_POST['tarikhe_talighe_ip']=$_POST['tarikhe_talighe_ip'].' '.Helper::nowShamsihisv();
            }
            if($_POST['id']==="empty"){
                unset($_POST['id']);
                $sql=Helper::Insert_Generator($_POST,'bnm_ip_assign');
                $res=Db::secure_insert_array($sql,$_POST);
                if(! $res) die(Helper::Json_Message('f'));
                die(Helper::Custom_Msg(Helper::Messages('s'),1));
            }else{
                die(Helper::Custom_Msg('برای ویرایش با مهندس سلطانی تماس بگیرید'));
            }
            die(Helper::Json_Message('e'));
        }
        if(isset($_POST['send_wireless_ipassign'])){
            parse_str($_POST[key($_POST)], $_POST);
            $_POST = Helper::xss_check_array($_POST);
            // $_POST['servicetype']="bandwidth";
            $factor = Helper::getServiceInfoByFactorid($_POST['service']);
            if(! isset($factor)) die(Helper::Custom_Msg(Helper::Messages('serviceinf'),2));
            if (!$factor) die(Helper::Custom_Msg(Helper::Messages('serviceinf'),2));
            unset($_POST['service']);
            unset($_POST['tarikhe_shoroe_service']);
            unset($_POST['tarikhe_payane_service']);
            $_POST['fid'] = $factor[0]['fid'];
            $_POST['emkanat_id'] = $factor[0]['emkanat_id'];
            $_POST['servicetype'] = $factor[0]['sertype'];
            $_POST['sub'] = $factor[0]['subid'];
            $_POST['tarikhe_shoroe_ip']=Helper::TabdileTarikh($_POST['tarikhe_shoroe_ip'], 2, '/', '-');
            if($_POST['tarikhe_shoroe_ip']) {
                $_POST['tarikhe_shoroe_ip']= Helper::fixDateDigit($_POST['tarikhe_shoroe_ip'],'-');
                $_POST['tarikhe_shoroe_ip']=$_POST['tarikhe_shoroe_ip'].' '.Helper::nowShamsihisv();
            }
            $_POST['tarikhe_payane_ip']=Helper::TabdileTarikh($_POST['tarikhe_payane_ip'], 2, '/', '-');
            if($_POST['tarikhe_payane_ip']) {
                $_POST['tarikhe_payane_ip']= Helper::fixDateDigit($_POST['tarikhe_payane_ip'],'-');
                $_POST['tarikhe_payane_ip']=$_POST['tarikhe_payane_ip'].' '.Helper::nowShamsihisv();
            }

            // $_POST['tarikhe_shoroe_service']=Helper::TabdileTarikh($_POST['tarikhe_shoroe_service'], 2, '/', '-');
            // if($_POST['tarikhe_shoroe_service']) {
            //     $_POST['tarikhe_shoroe_service']= Helper::fixDateDigit($_POST['tarikhe_shoroe_service'],'-');
            //     $_POST['tarikhe_shoroe_service']=$_POST['tarikhe_shoroe_service'].' '.Helper::nowShamsihisv();
            // }
            // $_POST['tarikhe_payane_service']=Helper::TabdileTarikh($_POST['tarikhe_payane_service'], 2, '/', '-');
            // if($_POST['tarikhe_payane_service']) {
            //     $_POST['tarikhe_payane_service']= Helper::fixDateDigit($_POST['tarikhe_payane_service'],'-');
            //     $_POST['tarikhe_payane_service']=$_POST['tarikhe_payane_service'].' '.Helper::nowShamsihisv();
            // }
            $_POST['tarikhe_talighe_ip']=Helper::TabdileTarikh($_POST['tarikhe_talighe_ip'], 2, '/', '-');
            if($_POST['tarikhe_talighe_ip']) {
                $_POST['tarikhe_talighe_ip']= Helper::fixDateDigit($_POST['tarikhe_talighe_ip'],'-');
                $_POST['tarikhe_talighe_ip']=$_POST['tarikhe_talighe_ip'].' '.Helper::nowShamsihisv();
            }
            if($_POST['id']==="empty"){
                unset($_POST['id']);
                $sql=Helper::Insert_Generator($_POST,'bnm_ip_assign');
                $res=Db::secure_insert_array($sql,$_POST);
                if(! $res) die(Helper::Json_Message('f'));
                die(Helper::Custom_Msg(Helper::Messages('s'),1));
            }else{
                die(Helper::Custom_Msg('برای ویرایش با مهندس سلطانی تماس بگیرید'));
            }
            die(Helper::Json_Message('e'));
        }

        if(isset($_POST['send_tdlte_ipassign'])){
            parse_str($_POST[key($_POST)], $_POST);
            $_POST = Helper::xss_check_array($_POST);
            // $_POST['servicetype']="bandwidth";
            $factor = Helper::getServiceInfoByFactorid($_POST['service']);
            if(! isset($factor)) die(Helper::Custom_Msg(Helper::Messages('serviceinf'),2));
            if (!$factor) die(Helper::Custom_Msg(Helper::Messages('serviceinf'),2));
            unset($_POST['service']);
            unset($_POST['tarikhe_shoroe_service']);
            unset($_POST['tarikhe_payane_service']);
            $_POST['fid'] = $factor[0]['fid'];
            $_POST['emkanat_id'] = $factor[0]['emkanat_id'];
            $_POST['servicetype'] = $factor[0]['sertype'];
            $_POST['sub'] = $factor[0]['subid'];
            $_POST['tarikhe_shoroe_ip']=Helper::TabdileTarikh($_POST['tarikhe_shoroe_ip'], 2, '/', '-');
            if($_POST['tarikhe_shoroe_ip']) {
                $_POST['tarikhe_shoroe_ip']= Helper::fixDateDigit($_POST['tarikhe_shoroe_ip'],'-');
                $_POST['tarikhe_shoroe_ip']=$_POST['tarikhe_shoroe_ip'].' '.Helper::nowShamsihisv();
            }
            $_POST['tarikhe_payane_ip']=Helper::TabdileTarikh($_POST['tarikhe_payane_ip'], 2, '/', '-');
            if($_POST['tarikhe_payane_ip']) {
                $_POST['tarikhe_payane_ip']= Helper::fixDateDigit($_POST['tarikhe_payane_ip'],'-');
                $_POST['tarikhe_payane_ip']=$_POST['tarikhe_payane_ip'].' '.Helper::nowShamsihisv();
            }

            // $_POST['tarikhe_shoroe_service']=Helper::TabdileTarikh($_POST['tarikhe_shoroe_service'], 2, '/', '-');
            // if($_POST['tarikhe_shoroe_service']) {
            //     $_POST['tarikhe_shoroe_service']= Helper::fixDateDigit($_POST['tarikhe_shoroe_service'],'-');
            //     $_POST['tarikhe_shoroe_service']=$_POST['tarikhe_shoroe_service'].' '.Helper::nowShamsihisv();
            // }
            // $_POST['tarikhe_payane_service']=Helper::TabdileTarikh($_POST['tarikhe_payane_service'], 2, '/', '-');
            // if($_POST['tarikhe_payane_service']) {
            //     $_POST['tarikhe_payane_service']= Helper::fixDateDigit($_POST['tarikhe_payane_service'],'-');
            //     $_POST['tarikhe_payane_service']=$_POST['tarikhe_payane_service'].' '.Helper::nowShamsihisv();
            // }
            $_POST['tarikhe_talighe_ip']=Helper::TabdileTarikh($_POST['tarikhe_talighe_ip'], 2, '/', '-');
            if($_POST['tarikhe_talighe_ip']) {
                $_POST['tarikhe_talighe_ip']= Helper::fixDateDigit($_POST['tarikhe_talighe_ip'],'-');
                $_POST['tarikhe_talighe_ip']=$_POST['tarikhe_talighe_ip'].' '.Helper::nowShamsihisv();
            }
            if($_POST['id']==="empty"){
                unset($_POST['id']);
                $sql=Helper::Insert_Generator($_POST,'bnm_ip_assign');
                $res=Db::secure_insert_array($sql,$_POST);
                if(! $res) die(Helper::Json_Message('f'));
                die(Helper::Custom_Msg(Helper::Messages('s'),1));
            }else{
                die(Helper::Custom_Msg('برای ویرایش با مهندس سلطانی تماس بگیرید'));
            }
            die(Helper::Json_Message('e'));
        }
        
        $this->view->pagename = 'ip_assign';
        $this->view->render('ip_assign', 'dashboard_template', '/public/js/ip_assign.js', false);
    }
}
