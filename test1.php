<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$servername = "localhost";
$username = "root";
$password = "123";
$db = "eosdb"
// 创建连接
$conn = new mysqli($servername, $username, $password);
 
echo "连接"
?>
