<?php

/*
asiatech:
url:https://80.253.151.3/webservice
vspid:67
vpi:1
vci:58
auth key:c0c85f22aca5c7e9975155af93e73a17
 */
class AsiatechJsonrpc
{
    public function __construct(String $server_ip = __ASIATECHOSSURL__)
    {
        $this->client = new JsonRPC2Client($server_ip);
        //$this->auth   = $auth;
    }

    public function sendRequest(String $method = null,Array $params = array())
    {
        //params = array(array(params))
        if ($method!==null) {
            // return $params;
            $res = $this->client->__call($method, $params);
            return $res;
        } else {
            return false;
        }
    }

    //darje comment dar ticket
    public function insertTicketComment($tiid, $comment ,$vspid= __ASIATECHVSPID__)
    {
        //int tiwflowid, string title,enum maintype, int maintypeid, string description, int Priority, int ttypeid, 
        //string ownertype, ownerid, int source, string coordinatorName, string coordinatorMobile
        $res= $this->addAuth();
        $res['tiid']    = $tiid;
        $res['comment'] = $comment;
        $res['vspid']   = $vspid;
        return $this->sendRequest("insertTicketComment", array($res));
    }
    //daryafte commenthaye ticket
    public function getTicketComment($tiid, $vspid= __ASIATECHVSPID__)
    {
        //int tiwflowid, string title,enum maintype, int maintypeid, string description, int Priority, int ttypeid, 
        //string ownertype, ownerid, int source, string coordinatorName, string coordinatorMobile
        $res= $this->addAuth();
        $res['tiid']    = $tiid;
        $res['vspid']   = $vspid;
        return array($res);
        return $this->sendRequest("getTicketComment", array($res));
    }
    //daryafte tarikhche ticket
    public function getTicketHistory($tiid, $vspid= __ASIATECHVSPID__)
    {
        //int tiwflowid, string title,enum maintype, int maintypeid, string description, int Priority, int ttypeid, 
        //string ownertype, ownerid, int source, string coordinatorName, string coordinatorMobile
        $res= $this->addAuth();
        $res['tiid']    = $tiid;
        $res['vspid']   = $vspid;
        return $this->sendRequest("getTicketHistory", array($res));
    }
    public function getTicketDetails($tiid, $vspid= __ASIATECHVSPID__)
    {
        //int tiwflowid, string title,enum maintype, int maintypeid, string description, int Priority, int ttypeid, 
        //string ownertype, ownerid, int source, string coordinatorName, string coordinatorMobile
        $res= $this->addAuth();
        $res['tiid']    = $tiid;
        $res['vspid']   = $vspid;
        return $this->sendRequest("getTicketDetails", array($res));
    }
    //sakhte ticket
    public function createTicket(int $tiwflowid, string $onvan, string $maintype, int $maintypeid, string $tozihat,
        int $olaviat, int $tabaghe, string $ownertype='operator', $ownerid='', int $source= 1, string $sourcevalue='',
        string $coordinatorName='' , string $coordinatorMobile='',string $serviceUsername='', string $servicePassword='',
        string $serviceMACAddress='', string $serviceNASPortID='', $vspid= __ASIATECHVSPID__)
    {
        $res                        = $this->addAuth(array());
        $res['tiwflowid']           = $tiwflowid;
        $res['title']               = $onvan;
        $res['maintype']            = $maintype;
        $res['maintypeid']          = $maintypeid;
        $res['description']         = $tozihat;
        $res['Priority']            = $olaviat;
        $res['ttypeid']             = $tabaghe;
        $res['ownertype']           = $ownertype;
        $res['ownerid']             = $ownerid;
        $res['source']              = $source;
        $res['sourcevalue']         = $sourcevalue;
        $res['coordinatorName']     = $coordinatorName;
        $res['coordinatorMobile']   = $coordinatorMobile;
        $res['serviceUsername']     = $serviceUsername;
        $res['servicePassword']     = $servicePassword;
        $res['serviceMACAddress']   = $serviceMACAddress;
        $res['serviceNASPortID']    = $serviceNASPortID;
        $res['vspid']               = $vspid;
        return $this->sendRequest("createTicket", array($res));
    }
    //daryafte vpi vci vlan port
    public function getInterfaceServicePort(int $port,$vspid= __ASIATECHVSPID__)
    {
        $res= $this->addAuth(array());
        $res['resourceid']  = $port;
        $res['vspid']       = $vspid;
        return $this->sendRequest("getInterfaceServicePort", array($res));
    }
    //daryafte shenase port
    public function getPortID(string $telephone,$vspid= __ASIATECHVSPID__)
    {
        $res= $this->addAuth(array());
        $res['fixedtel']    = $telephone;
        $res['vspid']       = $vspid;
        return $this->sendRequest("getPortID", array($res));
    }

    //daryafte etelaat va joziate port
    public function getResourceDetails(int $telephone, $vspid= __ASIATECHVSPID__)
    {
        $res= $this->addAuth(array());
        $res['subid']       = $telephone;
        $res['vspid']       = $vspid;
        return $this->sendRequest("getResourceDetails", array($res));
    }
    //daryafte etelaat va joziate port
    public function activateResource(int $resid, $vspid= __ASIATECHVSPID__)
    {
        $res= $this->addAuth(array());
        $res['resid']       = $resid;
        $res['vspid']       = $vspid;
        return $this->sendRequest("activateResource", array($res));
    }
    //elame niaz be tavize port
    public function needChangePort(int $resourceid, $vspid= __ASIATECHVSPID__)
    {
        $res= $this->addAuth(array());
        $res['resourceid']  = $resourceid;
        $res['vspid']       = $vspid;
        return $this->sendRequest("needChangePort", array($res));
    }
    //ersal mojadade darkhaste ranzhe be mokhaberat
    public function reinstallADSLPort(/*to document gofte bayad telephone int bashad!!!*/$telephone,$vspid= __ASIATECHVSPID__)
    {
        $res= $this->addAuth(array());
        $res['resourceid']  = $telephone;
        $res['vspid']       = $vspid;
        return $this->sendRequest("reinstallADSLPort", array($res));
    }
    //eslahe etelaate darkhaste reserve
    public function modifyResourceInfo($resourceid,$ownertype,$phone,$vspid= __ASIATECHVSPID__)
    {
        $res= $this->addAuth(array());
        $res['resourceid']  = $resourceid;
        $res['ownertype']   = $ownertype;
        $res['phone']       = $phone;
        $res['vspid']       = $vspid;
        return $this->sendRequest("modifyResourceInfo", array($res));
    }
    //laghve darkhaste reserve
    public function cancelReserveResource(/*reserve_id*/$resid,$vspid)
    {
        $res= $this->addAuth(array());
        $res['resid']  = $resid;
        $res['vspid']  = $vspid;
        return $this->sendRequest("cancelReserveResource", array($res));
    }
    //jamavari manabe
    public function roundupResource(/*oss_id=code_meli-telephone*/$resourceid,$vspid)
    {
        $res= $this->addAuth(array());
        $res['resourceid']  = $resourceid;
        $res['vspid']       = $vspid;
        return $this->sendRequest("roundupResource", array($res));
    }
    
    //daryafte shenase moshtarak dar oss
    public function getSubscriberByID(/*codemeli-telephone*/$subscriberid, /*40*/$vspid=__ASIATECHVSPID__)
    {
        $res= $this->addAuth();
        $res['customerid']=$subscriberid;
        $res['vspid']=$vspid;
        // return $res;
        return $this->sendRequest("getSubscriberByID", array($res));
    }

    //daryafte vaziat darkhaste reserve
    public function getReserveResourceStatus(/*reserve_id*/$resourceid, /*40*/$vspid= __ASIATECHVSPID__)
    {
        $res=$this->addAuth(array('resourceid'=>$resourceid, 'vspid'=>$vspid));
        return $this->sendRequest("getReserveResourceStatus",array($res));
    }
    //daryafte moshakhasate moshtarak dar oss
    public function getSubscriberDetails($params)
    {
        $res=$this->addAuth($params);
        return $this->sendRequest("getSubscriberDetails", array($res));
    }
    //sehat salamat
    public function checkOSSWebService()
    {
        $res=$this->addAuth();
        return $this->sendRequest("checkOSSWebService", array($res));
    }
    //liste shahr ha
    public function getCity()
    {
        
        $res=$this->addAuth();
        return $this->sendRequest("getCity", array($res));
    }
    //liste markaze mokhaberati
    public function getLocation()
    {
        $res=$this->addAuth();
        // return $res;
        return $this->sendRequest("getLocation", array($res));
    }
    //gereftane markaze mokhaberati ba telephone
    public function getLocationFromPhonePrefix($telephone)
    {
        $params=[];
        $params['phone']=$telephone;
        $res=$this->addAuth($params);
        return $this->sendRequest("getLocationFromPhonePrefix", array($res));
    }
    //emkan sanji erae service
    public function resourceFeasibilityCheck($params)
    {
        $res=$this->addAuth($params);
        // return $res;
        return $this->sendRequest("resourceFeasibilityCheck", array($res));
    }
    //sakhte mosh dar oss
    public function createSubscriber($params)
    {
        $res=$this->addAuth($params);
        return $this->sendRequest("createSubscriber", array($res));
    }
    //liste ostan ha
    public function getProvince()
    {
        $res=$this->addAuth();
        return $this->sendRequest("getProvince", array($res));
    }
    //reserve manabe
    public function reserveResource($params)
    {
        //subid
        //ownertype 1=sahebe telephon , 2=mostajer
        //ownername
        //ownerfamily
        //owneruid
        //loid
        //interfacetype (enum)
        //restime (Integer)
        //phone (String)
        //vspid(Integer)
        $res=$this->addAuth($params);
        return $this->sendRequest("reserveResource", array($res));
    }

    public function addAuth(Array $params=array())
    {
        $params['auth']=__ASIATECHAUTH__;
        return $params;
    }

    public function errorCheck($res)
    {
        if(isset($res)){
            if(is_array($res)){
                if(isset($res['result'])){
                    if($res['result']['errcode']===0){
                        return true;
                    }else return false;
                }else return false;
            }else return false;
            // }else return Helper::Json_Message('asiatech_connection_error'); //old message for check if(is_array($res))
        }else return false;
    }
    public function getMessage($res)
    {
        // if(isset($res)){
        //     if(is_array($res)){
        //         if(isset($res['result'])){
        //             if($res['result']['errcode']===0){
        //                 return Helper::Custom_Msg(Helper::getor_string($res['result']['errmsg'],'پیامی از oss دریافت نشد'),1);
        //             }else return Helper::Custom_Msg(Helper::getor_string($res['result']['errmsg'],Helper::Messages('asiatech_failure')),2);
        //         }else return Helper::Json_Message('f');
        //     }else return Helper::Json_Message('asiatech_connection_error');
        // }else return Helper::Json_Message('asiatech_connection_error');
        if(isset($res)){
            if(is_array($res)){
                if(isset($res['result'])){
                    if($res['result']['errcode']===0){
                        //return ['Success'=>$res['result']['errmsg']]
                        return $res['result']['errmsg'];
                    }else{
                        return $res['result']['errmsg'];
                    }
                }else{
                    return 'پیامی از oss دریافت نشد';
                }
            }else{
                return 'پیامی از oss دریافت نشد';
            }
        }else{
            return 'پیامی از oss دریافت نشد';
        }
    }
    public function getMessageNormal($res)
    {
        return $res['result']['errmsg'];
    }
}
