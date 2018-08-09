<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$account = $_GET["account"];


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

$post_data = '{"account_name":"' . $account . '"}';
$output = request_post("http://127.0.0.1:8888/v1/chain/get_account",$post_data);
$res=json_decode($output,true);
echo($res);
?>

