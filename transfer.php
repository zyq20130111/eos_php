<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$conn = new mysqli("localhost","root","123","eosdb");
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
} 


$balance = $_GET["balance"];
$transferor = $_GET["transferor"];
$recipient = $_GET["recipient"];
$quantity = $_GET["quantity"];
$account = $_GET["account"];

$sql = "SELECT transferor,recipient,date,quantity FROM transfer_tbl where transferor = '" . $account . "' or recipient = '" . $account . "'";
$result = $conn->query($sql);
$history = "";

while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    if ($history != "") {$history .= ",";}
    $history .= '{"transferor":"'  . $rs["transferor"] . '",';
    $history .= '"recipient":"' . $rs["recipient"] . '",';
    $history .= '"date":"' . $rs["date"] . '",';
    $history .= '"quantity":"' .  $rs["quantity"]  . '"}'; 
}


$balance = '"balance":' . '"' . $balance . '"';
$transferor = '"transferor":' . '"' . $transferor . '"';
$recipient = '"recipient":' . '"' . $recipient . '"';
$quantity = '"quantity":' . '"' . $quantity . '"';
$history = '"history":[' . $history . ']';

$outp = "{" . $balance . "," .  $transferor . "," .  $recipient . "," . $quantity . "," . $history . "}" ;
echo($outp);

$conn->close();

?>

