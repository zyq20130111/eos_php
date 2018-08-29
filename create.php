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

function getAccount($account){

   $flag = -1;
   $post_data = '{"account_name":"' . $account . '"}';
   $result = request_post("http://127.0.0.1:8888/v1/chain/get_account",$post_data);
   print "1111";
   print $result;  
   if(!is_null($result)){
      
      print "22222";
      $json =json_decode($result,true);
      print $json;
      if((!is_null($json)) &&  (!is_null($json["account_name"]))){

          if(trim($json["account_name"]) == trim($name)){
               $flag = 0;
          }
      }
   }
   return $flag;

}


$creator = $_GET["creator"];

$name = $_GET["name"];
$ownerkey = $_GET["ownerkey"];
$activekey = $_GET["activekey"];


$ram = $_GET["ram"];
$cpu = $_GET["cpu"];
$net = $_GET["net"];

$code = -1;

try{

   $cmd = sprintf('/var/account/create.sh %s %s %s %s %s %s %s',$creator,$name,$ownerkey,$activekey,$ram,$cpu,$net);
   //判断是否存在相应的账号
   $code = getAccount($name);

   if($code == 0){
     echo '{"code": -1}';
   }
   //创建账号
   $ret = shell_exec($cmd);
   echo $ret;
   if(is_null($ret)){

      echo '{"code": -1}';
      return;    

   }
   //判断账号是否创建成功
   $code = getAccount($name);
   echo sprintf('{"code":%d}',$code);
}
catch(Exception $e){
   echo sprintf('{"code":%d}',$code);
}

?>
