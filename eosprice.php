<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

function request_get($url = ''){
   
   $ch = curl_init();
   $timeout = 5;
   curl_setopt ($ch, CURLOPT_URL, $url);
   curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
   $file_contents = curl_exec($ch);
   curl_close($ch);

   return $file_contents;
}

try{
 
   $result = request_get("https://ticker.mars.bituniverse.org/coincap/query_coin_market_cap_with_performance?symbol=EOS&full_name=EOS");
   $res=json_decode($result,true);

   $price = "0";

  if(res["code"] == 0){
     echo("zzzz");
     $price = res["data"]["price"];
  }
  echo($price);
}
catch(Exception $e)
{
  echo("error");  
}


?>
