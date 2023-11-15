<?php
class Shahkar_Requests{

    public static function sendRequest($req, $method, $url, $data){
        $config=Helper::getShahkarConfig();
        $arr=[];
        $arr[$req]              = 1;
        $arr['requesttype']     = $method;
        $arr['url']             = $config[0]['url'].'/'.$url;
        $arr['username']        = $config[0]['username'];
        $arr['password']        = $config[0]['password'];
        $arr['providercode']    = $config[0]['providercode'];
        $arr['data']            = $data;
        $res = Helper::httpPost($config[0]['serverurl'],$arr);
        return $res;
    }

    public static function sehatSalamat(){
        $res= self::sendRequest('estsehatsalamat', 'post', 'rest/shahkar/hc', []);
        return $res; 
    }

    public static function putService(array $data, string $method='post'){
        $res= self::sendRequest('putservice', $method, 'rest/shahkar/put', $data);
        return $res;
    }
    public static function estAuthSub(array $data, string $method='post'){
        $res= self::sendRequest('estauthsub', $method, 'rest/shahkar/estelaam', $data);
        return $res;
    }

    public static function estServiceStatus(array $data, string $method='post'){
        $res= self::sendRequest('providerenquiry', $method, 'rest/shahkar/provider-enquiry', $data);
        return $res;
    }

    public static function deleteService(array $data, string $method='post'){
        $res= self::sendRequest('deleteservice', $method, 'rest/shahkar/delete', $data);
        return $res;
    }
    public static function closeService(array $data, string $method='post'){
        $res= self::sendRequest('closeservice', $method, 'rest/shahkar/update', $data);
        return $res;
    }
    public static function orginationDoc(){
        $res= self::sendRequest('docs', 'post', 'rest/shahkar/doc/service/3/current', []);
        return $res;
    }
    // public static function estAuthIraniLegal(int $subid, string $method='post'){
    //     $res= self::sendRequest('authentication_iranian_legal', $method, 'rest/shahkar/estelaam', ['subid'=>$subid, 'requestname'=>'estauthsub']);
    //     return $res; 
    // }

    // public static function estAuthKharejiReal(int $subid, string $method='post'){
    //     $res= self::sendRequest('authentication_foreign_real', $method, 'rest/shahkar/estelaam', ['subid'=>$subid, 'requestname'=>'estauthsub']);
    //     return $res; 
    // }

    // public static function estAuthKharejiLegal(int $subid, string $method='post'){
    //     $res= self::sendRequest('authentication_foreign_legal', $method, 'rest/shahkar/estelaam', ['subid'=>$subid, 'requestname'=>'estauthsub']);
    //     return $res; 
    // }


    public static function adslShahkar(int $factorid, string $method='post' , string $url, string $request){
        //request= put/ update/ delete/ transfer/ close
        $res= self::sendRequest('adsl_shahkar', $method, $url, ['factorid'=>$factorid, 'requestname'=>'adslshahkar', 'request'=>$request]);
        return $res; 
    }

    public static function wirelessShahkar(int $factorid, string $method='post' ,string $url, string $request){
        $res= self::sendRequest('adsl_shahkar', $method, $url, ['factorid'=>$factorid, 'requestname'=>'wirelessshahkar', 'request'=>$request]);
        return $res; 
    }
    
    public static function tdlteShahkar(int $factorid, string $method='post' ,string $url, string $request){
        $res= self::sendRequest('adsl_shahkar', $method, $url, ['factorid'=>$factorid, 'requestname'=>'tdlteshahkar', 'request'=>$request]);
        return $res; 
    }
    



    // public static function estAuthForeignReal($subid){
    //     $res= self::sendRequest('estsehatsalamat','post', 'rest/shahkar/hc', []);
    //     return $res; 
    // }


}
?>