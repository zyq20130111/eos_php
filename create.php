<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");


function request_get($url = ''){
   echo "aaaaaa";
   $ch = curl_init();
   $timeout = 5;
   curl_setopt ($ch, CURLOPT_URL, $url);
   curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
   $file_contents = curl_exec($ch);
   echo $file_contents;
   curl_close($ch);

   return $file_contents;
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
   echo $cmd;
   
   $ret = shell_exec($cmd);   
   if(is_null($ret)){
      echo "yyyy";
      echo '{"code": -1}';
      return;    
   }

   
   $url = sprintf("http://127.0.0.1:8002/eos_php/account.php?account=%s",$name);
   echo $url;
   $result = request_get(url);
   
   if(is_null($result) == false){

      $json =json_decode($result,true);
      echo $json;
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
