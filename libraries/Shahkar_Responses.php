<?php
class Shahkar_Responses{
    public static function estAuthSub($res, $subid, ){
        $arr=[];
        $arr['noe_darkhast']= 2;
        $arr['creator']     = $_SESSION['id'];
        $arr['comment']     = $res['comment'];
        $arr['shenase']     = $res['id'];
        $arr['requestid']   = $res['requestId'];
        $arr['response']    = $res['response'];
        $arr['jresponse']   = $res;
        $arr['result']      = $res['result'];
        $arr['tarikh']      = Helper::Today_Miladi_Date('-')." ".Helper::nowTimeTehran();
        $sql=Helper::Insert_Generator($arr, 'shahkar_log');
        $insert=Db::secure_insert_array($sql, $arr);
    }
}
?>