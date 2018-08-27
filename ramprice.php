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

try{
      $post_data = '{"scope":"eosio","code":"eosio","table":"rammarket","json": true}';
      $res = request_post("http://127.0.0.1:8888/v1/chain/get_table_rows",$post_data);
      $res = json_decode($res,true);
      if(($res != NULL)  && (count($res) > 0)){

         echo "aaa"
         $basebalance =  $res[0]["base"]["balance"];
         echo $basebalance;
         $basebalance =  split(" ", $basebalance);
         $basebalance = floatval($basebalance[0]);
         
         $quotebalance = $res[0]["quote"]["balance"];
         echo $quotebalance;
         $quotebalance = split(" ",$quotebalance);
         $quotebalance = floatval($quotebalance[0]);
    
         $json_str = '{"code":0,"price":%f}';
         echo sprintf($json_str,$basebalance / $quotebalance);
      }
}
catch(Exception $e){
    echo '{"code":-1}';    
}

?>
