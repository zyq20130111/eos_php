<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require 'config.php';

$conn = new mysqli(Config::IP,Config::USERNAME,Config::PWD,Config::DB);
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

 
$inj_str = "'|and|exec|insert|select|delete|update|count|*|%|chr|mid|master|truncate|char|declare|;|or|-|+|,|drop";
$inj_stra = explode("|" , $inj_str);

for($i=0 ; $i < count($inj_stra) ; $i++)
{
    if($inj_stra[$i] == strtolower($producer)){
        echo '{"code":500}';
        return;
    }
}

$sql = "SELECT voter,proudcer,date,vote FROM voter_tbl where proudcer = '" . $producer . "'  ORDER BY Id DESC limit 0,20";
$result = $conn->query($sql);
$history = "";

while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    if ($history != "") {$history .= ",";}
    $history .= '{"voter":"'  . $rs["voter"] . '",';
    $history .= '"proudcer":"' . $rs["proudcer"] . '",';
    $history .= '"date":"' . $rs["date"] . '",';
    $history .= '"vote":"' .  $rs["vote"]  . '"}'; 
}

$sql  = "SELECT * from producers_tbl where owner = '" . $producer . "'";
$result = $conn->query($sql);
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
     $total = $rs["total_votes"];
}

$sql  = "SELECT count(*) AS MC from producers_tbl where total_votes  >  " .  $total;
$result = $conn->query($sql);
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
     $ranking = $rs["MC"] + 1;
}

$total = $total / 10000;

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

