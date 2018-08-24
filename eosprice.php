<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

function request_get($url = ''){
   
   $ch = curl_init();
   $timeout = 5;
   curl_setopt ($ch, CURLOPT_URL, 'http://www.51growup.com/');
   curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
   $file_contents = curl_exec($ch);
   curl_close($ch);

   return $file_contents;
}
 
$result = request_get("https://ticker.mars.bituniverse.org/coincap/query_coin_market_cap_with_performance?symbol=EOS&full_name=EOS");
echo $result;

?>
