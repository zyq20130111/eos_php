<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$account = $_GET["account"];
echo($account);


function request_post($url = '', $param = '') {
     if (empty($url) || empty($param)) {
        return false;
     }
        
     $postUrl = $url;
     $curlPost = $param;
     $ch = curl_init();//初始化curl
     curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页

     curl_setopt($ch, CURLOPT_HEADER,array("Content-Type: application/json");//设置header

     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
     curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
     curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
     $data = curl_exec($ch);//运行curl
     curl_close($ch);
     echo("ssssssss");
     echo($data);        
     return $data;
}

$post_data["account_name"] = $account;
$res = request_post("http:127.0.0.1:8888/v1/chain/get_account",$post_data);
echo($res);   

echo("ssssss");
getAccount($account);

?>

