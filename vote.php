<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$conn = new mysqli("localhost","root","123","eosdb");
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
   // return;
} 

$ranking = 1;
$total = 300;

$voter = $_GET["voter"];
$producers = $_GET["producers"];
$voteNum = $_GET["votenum"];
$producer = $_GET["producer"];

 
//$inj_str = "'|and|exec|insert|select|delete|update|count|*|%|chr|mid|master|truncate|char|declare|;|or|-|+|,|drop";
$inj_str = "sdfsdfsdfsdfsfd";
echo($inj_str);
$inj_stra = ["sss","dddd"];//split("|",$inj_str);

for($i=0 ; $i < count($inj_stra) ; $i++)
{
    if($inj_stra[$i] == strtolower($producer)){
        echo '{"code":500}'
        return;
    }
}

$sql = "SELECT voter,proudcer,date,vote FROM voter_tbl where proudcer = '" . $producer . "'";
$result = $conn->query($sql);
$history = "";

while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    if ($history != "") {$history .= ",";}
    $history .= '{"voter":"'  . $rs["voter"] . '",';
    $history .= '"proudcer":"' . $rs["proudcer"] . '",';
    $history .= '"date":"' . $rs["date"] . '",';
    $history .= '"vote":"' .  $rs["vote"]  . '"}'; 
}

$ranking = '"ranking":' . $ranking;
$total = '"total":' . $total;
$voter = '"voter":' . '"' . $voter . '"';
$producers = '"producers":' . '"' . $producers . '"';
$voteNum = '"voteNum":' . $voteNum;
$history = '"history":[' . $history . ']';

$outp = "{" . $ranking . "," .  $total . "," .  $voter . "," . $producers . "," .  $voteNum . "," .  $history . "}" ;
echo($outp);

$conn->close();

?>

