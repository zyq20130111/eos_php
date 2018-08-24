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

   $price = 0; 

   $result = request_get("https://ticker.mars.bituniverse.org/coincap/query_coin_market_cap_with_performance?symbol=EOS&full_name=EOS");
   $res=json_decode($result,true);

  if($res["code"] == 0){
     $price = $res["data"]["price"];
  }

  $ratio = 0;

  $result1 = request_get("https://ticker.mars.bituniverse.org/ticker/fiatmap");
  $res1 = json_decode($result1,true);
  if($res1["status"] == 0){

      $data = $res1["data"];

      foreach($data as $item){

           if(($item["base"] == "USD") && ($item["quote"] == "CNY")){
              $ratio = floatval($item["price"]);

              break;
           } 
      }  
  }
  $json_str = '{"code":0,"price":%f}';
  echo sprintf($json_str,$price * $ratio); 

}
catch(Exception $e)
{
  echo '{"code":-1}';  
}


?>
