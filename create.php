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

//得到账号信息 -1表示账号不存在,0表示账号存在
function getAccount($account){

   $flag = -1;
   $post_data = '{"account_name":"' . $account . '"}';
   $data = request_post("http://127.0.0.1:8888/v1/chain/get_account",$post_data);

   $json = json_decode($data,true);

  if(!array_key_exists("account_name",$json)){
        return $flag;
   }

   if(trim($json["account_name"]) == trim($account)){
        $flag = 0;
   }


   return $flag;

}


function checkPermission($account,$ownerkey,$activekey){

   $flag = -1;
   $post_data = '{"account_name":"' . $account . '"}';
   $data = request_post("http://127.0.0.1:8888/v1/chain/get_account",$post_data);
   $json = json_decode($data,true);

   if( !array_key_exists("account_name",$json) ){
       return $flag;
   }

   if(!array_key_exists("permissions",$json){
	return $flag;
   }
   
   if(count($json["permissions"]) < 2){
      return $flag;
   }

   $permissions = $json["permissions"];

   if( (!array_key_exists("required_auth",$permissions[0])) || (!array_key_exists("required_auth",$permissions[1])) ){
       return $flag;
   }

   if( (!isset($permissions[0]["required_auth"])) || (!isset($permissions[1]["required_auth"])) ){
       return $flag;  
   }   


   $require_auth1 = $permissions[0]["required_auth"];
   $require_auth2 = $permissions[1]["required_auth"];

   if( (!array_key_exists("keys",$require_auth1)) || (!array_key_exists("keys",$require_auth2)) ){
       return $flag;
   }

   if((!isset($require_auth1["keys"])) || (!isset($require_auth2["keys"])) ){
       return $flag;
   }


   if( (!array_key_exists("perm_name",$permissions[0])) || (!array_key_exists("perm_name",$permissions[1])) ){
       return $flag;
   }

   if( (!isset($permissions[0]["perm_name"])) || (!isset($permissions[1]["perm_name"])) ){
       return $flag;
   }

   $perm_name1 = $permissions[0]["perm_name"];
   $perm_name2 = $permissions[1]["perm_name"];

   $keys1 = $require_auth1["keys"];
   $keys2 = $require_auth2["keys"];
   if((count($keys1) <=0) || (count($keys2) <= 0)){
       return $flag;
   }

   $key1 = $keys1[0];
   $key2 = $keys2[0];
   if((!isset($key1)) || (!isset($key2)) ){
       return $flag;
   }

   if(isset($json["account_name"]) && (trim($json["account_name"]) == trim($account)) ){
       
       if(trim($perm_name1) == "owner"){ 
           if( ($json["permissions"][0]["required_auth"]["keys"][0]["key"] == $ownerkey) && ($json["permissions"][1]["required_auth"]["keys"][0]["key"] == $activekey)){
                $flag = 0;
           }
       }else{
           if( ($json["permissions"][1]["required_auth"]["keys"][0]["key"] == $ownerkey) && ($json["permissions"][0]["required_auth"]["keys"][0]["key"] == $activekey)){
                $flag = 0;
           }
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
     //$code = checkPermission($name,$ownerkey,$activekey);
     $code = 0;
     return $code;
   }
   catch(Exception $e){
      return -3;
   }
}

?>
