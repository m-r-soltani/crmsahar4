<?php defined('__ROOT__') or exit('No direct script access allowed');
// header('Content-Type: application/json; charset=utf-8');
//w-9-0820195782
class Ipdr extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        /*========sabte shahr========*/
        if(isset($_POST['ipdrrequest'])){
            if(isset($_POST['ipdrusername']) && isset($_POST['ipdrpassword'])){
                if($_POST['ipdrusername']=== __IPDRUSERNAME__ && $_POST['ipdrpassword']=== __IPDRPASSWORD__ && isset($_POST['username'])){
                    $res=false;
                    $sub=false;
                    
                        //fetching user info
                        $res=Helper::getAllIbsusername($_POST['username']);
                        // echo json_encode($res);
                        // die();
                        if(! isset($res)){
                            echo json_encode(['result'=> 0],JSON_UNESCAPED_UNICODE);
                            die();
                        }
                        if(! $res){
                            echo json_encode(['result'=> 0],JSON_UNESCAPED_UNICODE);
                            die();
                        }
                        $sql="SELECT * FROM bnm_subscribers WHERE id =?";
                        $sub=Db::secure_fetchall($sql, [$res['subid']]);
                        if(! $sub){
                            echo json_encode(['result'=> 0],JSON_UNESCAPED_UNICODE);
                            die();
                        }
                        $nationality= Helper::subIsIrani($res['subid']);
                        if($res['noe_khadamat']==="BITSTREAM_ADSL"){
                            $res['type']='adsl';
                        }elseif($res['noe_khadamat']==="BITSTREAM_VDSL"){
                            $res['type']='vdsl';
                        }

                        ////making result
                        $result=[];
                        $result['result']=0;
                        if(isset($res['type'])){
                            if($res['type']){
                                $result['service']=$res['type'];
                                $result['result']+=1;
                            }
                        }
                        if(isset($sub[0]['telephone1'])){
                            if($sub[0]['telephone1']){
                                $result['phone1']=$sub[0]['telephone1'];
                                $result['result']+=1;
                            }
                        }
                        if(isset($sub[0]['telephone_hamrah'])){
                            if($sub[0]['telephone_hamrah']){
                                $result['phone2']=$sub[0]['telephone_hamrah'];
                                $result['result']+=1;
                            }
                        }
                        if($sub[0]['noe_moshtarak']===__MOSHTARAKEHAGHIGHI__){
                            if(isset($sub[0]['code_meli'])){
                                if($sub[0]['code_meli']){
                                    $result['ID']=Helper::regulateNumber($sub[0]['code_meli']);
                                    $result['result']+=1;
                                }
                            }
                        }elseif($sub[0]['noe_moshtarak']===__MOSHTARAKEHOGHOGHI__){
                            if(isset($sub[0]['shenase_meli'])){
                                if($sub[0]['shenase_meli']){
                                    $result['ID']=Helper::regulateNumber($sub[0]['shenase_meli']);
                                    $result['result']+=1;
                                }
                            }
                        }
                        ////////Adding lat & lon for Wireless & TDLTE Services ONLY
                        if($res['type']==="wireless"){
                            $sql="SELECT * FROM bnm_sub_station ss
                            INNER JOIN bnm_wireless_station st ON st.id = ss.station_id
                            WHERE ss.id = ?";
                            $resstation=Db::secure_fetchall($sql, [$res['emkanat_id']]);
                            if(isset($resstation)){
                                if($resstation){
                                    if($resstation[0]['tol_joghrafiai'] && $resstation[0]['arz_joghrafiai']){
                                        if(is_numeric($resstation[0]['tol_joghrafiai']) && is_numeric($resstation[0]['arz_joghrafiai'])){
                                            $result['GPS']='';
                                            if (strpos($resstation[0]['tol_joghrafiai'], 'N')) {
                                                $result['GPS'].=$resstation[0]['tol_joghrafiai'].',';
                                            }else{
                                                $result['GPS'].="N:".$resstation[0]['tol_joghrafiai'].',';
                                            }
                                            if (strpos($resstation[0]['arz_joghrafiai'], 'E')) {
                                                $result['GPS'].=$resstation[0]['arz_joghrafiai'];
                                            }else{
                                                $result['GPS'].="E:".$resstation[0]['arz_joghrafiai'];    
                                            }
                                            if($result['GPS']){
                                                $result['result']+=1;
                                            }else{
                                                unset($result['GPS']);
                                            }
                                        }
                                    }
                                }
                            }
                        }elseif ($res['type']==="tdlte") {
                            $sql="SELECT * FROM bnm_tdlte_sim
                                WHERE id = ?";
                            $restdlte=Db::secure_fetchall($sql, [$res['emkanat_id']]);
                            if(isset($restdlte)){
                                if($restdlte){
                                    if($restdlte[0]['tol_joghrafiai'] && $restdlte[0]['arz_joghrafiai']){
                                        if(is_numeric($restdlte[0]['tol_joghrafiai']) && is_numeric($restdlte[0]['arz_joghrafiai'])){
                                            $result['GPS']='';
                                            if (strpos($restdlte[0]['tol_joghrafiai'], 'N')) {
                                                $result['GPS'].=$restdlte[0]['tol_joghrafiai'].',';
                                            }else{
                                                $result['GPS'].="N:".$restdlte[0]['tol_joghrafiai'].',';
                                            }
                                            if (strpos($restdlte[0]['arz_joghrafiai'], 'E')) {
                                                $result['GPS'].=$restdlte[0]['arz_joghrafiai'];
                                            }else{
                                                $result['GPS'].="E:".$restdlte[0]['arz_joghrafiai'];    
                                            }
                                            if($result['GPS']){
                                                $result['result']+=1;
                                            }else{
                                                unset($result['GPS']);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        //Last Result
                        echo json_encode($result, JSON_UNESCAPED_UNICODE);
                        die();
                        
                }else{
                    echo json_encode(['result'=>0], JSON_UNESCAPED_UNICODE);
                    die();
                }
            }else{
                echo json_encode(['result'=>0], JSON_UNESCAPED_UNICODE);
                    die();
            }
        }
        $this->view->pagename = 'ipdr';
        $this->view->render('ipdr', 'dashboard_template', '/public/js/ipdr.js', false);
    }
}

        
    

