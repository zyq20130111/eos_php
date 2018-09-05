<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

function request_post($url = '', $param = '') {
     if (empty($url) || empty($param)) {
        return false;
     }

     $header = array();
     //$header[] = 'Authorization:'.$tmp;
     $header[] = 'Accept:application/json';
     $header[] = 'Content-Type:application/json;charset=utf-8';

     $postUrl = $url;
     $curlPost = $param;
     $ch = curl_init();//初始化curl
     curl_setopt($ch, CURLOPT_HEADER, false);
     curl_setopt($ch, CURLOPT_POST, true);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
     curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
     curl_setopt($ch, CURLOPT_URL, $postUrl);

     $data = curl_exec($ch);//运行curl
     curl_close($ch);
     return $data;
}

//得到账号信息 -1表示账号不存在，0表示账号存在
function getAccount($account){

   $flag = -1;
   $post_data = '{"account_name":"' . $account . '"}';
   $data = request_post("http://127.0.0.1:8888/v1/chain/get_account",$post_data);

   $json = json_decode($data,true);
   if(isset($json["account_name"]) &&  (trim($json["account_name"]) == trim($account)) ){
        $flag = 0;
   }


   return $flag;

}


function checkPermission($account,$ownerkey,$activekey){

   $flag = -1;
   $post_data = '{"account_name":"' . $account . '"}';
   $data = request_post("http://127.0.0.1:8888/v1/chain/get_account",$post_data);
   
   if(count($json["permissions"]) < 2){
      return $flag;
   }   

   $json = json_decode($data,true);
   if(trim($json["account_name"]) == trim($account)){
        if( ($json["permissions"][0]["required_auth"]["keys"][0]["key"] == $ownerkey) && ($json["permissions"][1]["required_auth"]["keys"][0]["key"] == $activekey)){
           $flag = 0;
        }
   }


   return $flag;   
}

//创建账号 $create
/* $creator     主账号
* $name         账号名称
* $ownerkey     ownerkey
* $activekey    activekey 
* $ram          ram 字符串 保留4位小数0.0004 
* $cpu          cpu 字符串 保留4位小数0.0001
* $net          net 字符串 保留4位小数0.0001
*/
function createAccount($creator,$name,$ownerkey,$activekey,$ram,$cpu,$net)
{

  $code = -1;

  try{

     $cmd = sprintf('/var/account/create.sh %s %s %s %s %s %s %s',$creator,$name,$ownerkey,$activekey,$ram,$cpu,$net);
     //判断是否存在相应的账号
     $code = getAccount($name);

     if($code == 0){
        return -1;
     }
     //创建账号
     $ret = shell_exec($cmd);
     if(is_null($ret)){

         return -2;    
     }
     //判断账号是否创建成功
     $code = checkPermission($name,$ownerkey,$activekey);
     return $code;
   }
   catch(Exception $e){
      return -3;
   }
}

?>
