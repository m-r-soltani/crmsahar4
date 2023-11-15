<?php
include_once "/jetsib-ts/cfg/php.conf";
function httpPost($url, $data = [])
{
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}
function saharertebat_get_user_info($user){
    global $crm_api_url,$crm_user,$crm_pass;
    $customer_info=httpPost($crm_api_url,['ipdrrequest'=> 1, 'ipdrusername'=> $crm_user, 'ipdrpassword'=> $crm_pass, 'username'=> $user]);
    if($customer_info){
        return $customer_info;
    }else{
        return ['result'=>0];
    }
}
saharertebat_get_user_info('02144755050');

?>