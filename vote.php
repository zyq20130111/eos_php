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
$producer = $GET["producer"];

$result = $conn->query('SELECT voter,proudcer,date,vote FROM voter_tbl where proudcer = $producer');
$history = "";

echo($voter);
echo(#producers);
echo($voteNum);
echo($producer);
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    if ($history != "") {$history .= ",";}
    $history .= '{"voter":"'  . $rs["voter"] . '",';
    $history .= '"proudcer":"'   . $rs["proudcer"] . '",';
    $history .= '"date":"'   . $rs["date"] . '",';
    $history .= '"vote":"'. $rs["vote"] . '"}'; 
}

$ranking = '"ranking":' . $ranking;
$total = '"total":' . $total;
$voter = '"voter":' . '"' . $voter . '"';
$voteNum = '"voteNum":' . $voteNum;
$history = '"history":[' . $history . ']';

$outp = "{" . $ranking . "," .  $total . "," .  $voter . "," .  $voteNum . "," .  $history . "}";
$conn->close();

echo($outp);
*/
?>

