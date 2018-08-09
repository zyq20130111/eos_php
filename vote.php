<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$conn = new mysqli("localhost","root","123","eosdb");
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
} 

$ranking = 1;
$total = 300;

$voter = $_GET["voter"];
$producers = $_GET["producers"];
$voteNum = $_GET["votenum"];
$producer = $_GET["producer"];

echo($producer);

$sql = "SELECT voter,proudcer,date,vote FROM voter_tbl where proudcer = \'" . $producer . "\'";
$echo($sql);
/*
echo($sql);
$result = $conn->query($sql);
$history = "";

echo($producer);


while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    if ($history != "") {$history .= ",";}
    $history .= '{"voter":"'  . $rs["voter"] . '",';
    $history .= '"proudcer":"' . $rs["proudcer"] . '",';
    $history .= '"date":"' . $rs["date"] . '",';
    $history .= '"vote":"' .  $rs["vote"]  . '"}'; 
}
echo($history);

$ranking = '"ranking":' . $ranking;
$total = '"total":' . $total;
$voter = '"voter":' . '"' . $voter . '"';
$voteNum = '"voteNum":' . $voteNum;
$history = '"history":[' . $history . ']';

echo($history);

echo('{' . $ranking);
$outp = "{" . $ranking . "," .  $total . "," .  $voter . "," .  $voteNum . "," .  $history . "}" ;
echo($outp);
*/
$conn->close();

?>

