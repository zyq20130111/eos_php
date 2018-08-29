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
   
   $ret = shell_exec($cmd);   
   if(is_null($ret)){

      echo '{"code": -1}';
      return;    

   }

   $post_data = '{"account_name":"' . $name . '"}';
   $result = request_post("http://127.0.0.1:8888/v1/chain/get_account",$post_data);
   
   if(is_null($result) == false){

      $json =json_decode($result,true);
      echo $json["account_name"];
      if(is_null($json["account_name"]) == false){

          if(trim($json["account_name"]) == trim($name)){
               $code = 0;
          }
      }
   }

   echo sprintf('{"code":%d}',$code);
}
catch(Exception $e){
   echo sprintf('{"code":%d}',$code);
}

?>
