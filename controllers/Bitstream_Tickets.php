<?php defined('__ROOT__') or exit('No direct script access allowed');

class bitstream_Tickets extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        //testticket 1133264065
        // if(isset($_POST['send_new_ticket'])){
        //     parse_str($_POST[key($_POST)], $_POST);
        //     $_POST = Helper::xss_check_array($_POST);
        //     if(Helper::Login_Just_Check()){
        //         switch ($_SESSION['user_type']) {
        //         case __ADMINUSERTYPE__:
        //         case __ADMINOPERATORUSERTYPE__:
        //             if($_POST['maintype']==='port'){
        //                 $sql            = "SELECT * FROM bnm_oss_reserves WHERE id = ?";
        //                 $res            = Db::secure_fetchall($sql, array($_POST['maintypeid']));
        //             }elseif($_POST['maintype']==='subscriber'){
        //                 $sql            = "SELECT * FROM bnm_oss_subscribers WHERE id = ?";
        //                 $res            = Db::secure_fetchall($sql, array($_POST['maintypeid']));
        //             }else{
        //                 unset($_POST['maintypeid']);
        //                 unset($_POST['maintype']);
        //                 die(Helper::Json_Message('f'));
        //             }
        //         break;
        //         }
        //         $arr = array();
        //         if(isset($res)){
        //             if(isset($_POST['maintype'])){
        //                 $arr['maintype']= $_POST['maintype'];
        //                 if($_POST['maintype']==='port'){
        //                     $arr['maintypeid']= $res[0]['resid'];
        //                 }elseif($_POST['maintype']==='subscriber'){
        //                     $arr['maintypeid']= $res[0]['oss_id'];
        //                 }
        //             }
        //         }else{
        //             die(Helper::Json_Message('f'));
        //         }
        //         $arr['tiwflowid']           = 25;
        //         $arr['title']               = $_POST['title'];
        //         $arr['description']         = $_POST['description'];
        //         $arr['priority']            = (int)$_POST['priority'];
        //         $arr['ttypeid']             = (int)$_POST['ttypeid'];
        //         $arr['ownertype']           = 'operator';
        //         $arr['ownerid']             = 40;
        //         $arr['source']              = 1;
        //         $arr['sourcevalue']         = __ROOT__;
        //         $arr['coordinatorName']     = Helper::getor_string($_SESSION['name'].' '.$_SESSION['name_khanevadegi'],__OWNER__);
        //         $arr['coordinatorMobile']   = __OWNERMOBILE__;
        //         $arr['vspid']               = __ASIATECHVSPID__;
        //         $result=false;
        //         $result                     = $GLOBALS['bs']->createTicket($arr);
        //         if(! $result) die(Helper::Json_Message('f'));
        //             $arr['user_id']  = $_SESSION['id'];
        //             $arr['errcode']  = $result['errcode'];
        //             $arr['errmsg']   = $result['errmsg'];
        //             $arr['ticketID'] = $result['data']['ticketID'];
        //             $arr['tiid']     = $result['data']['tiid'];
        //             $sql2            = Helper::Insert_Generator($arr,'bnm_oss_tickets');
        //             $res2            = Db::secure_insert_array($sql2, $arr);
        //             if($res2){
        //                 die($GLOBALS['bs']->getMessage($result));
        //             }else{
        //                 $msg="متاسفانه درج اطلاعات تیکت با مشکل مواجه شد!";
        //                 die(Helper::Custom_Msg($GLOBALS['bs']->getMessageNormal($result).' '.$msg,1));
        //             }
                   
        //         //die(json_encode($result));
        //     }else{
        //         die(Helper::Json_Message('na'));
        //     }
        // }
        $this->view->home     = 'داشبورد';
        $this->view->page     = 'آسیاتک تیکت ها';
        $this->view->page_url = 'bitstream_tickets';
        $this->view->pagename = 'bitstream_tickets';
        $this->view->render('bitstream_tickets', 'dashboard_template', '/public/js/bitstream_tickets.js', false);
    }
}
