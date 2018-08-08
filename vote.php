<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$conn = new mysqli("localhost","root","123","eosdb");
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
} 

$result = $conn->query("SELECT voter,proudcer,date,vote FROM voter_tbl");
$outp = "";
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    if ($outp != "") {$outp .= ",";}
    $outp .= '{"voter":"'  . $rs["voter"] . '",';
    $outp .= '"proudcer":"'   . $rs["proudcer"] . '",';
    $outp .= '"date":"'   . $rs["date"] . '",';
    $outp .= '"vote":"'. $rs["vote"] . '"}'; 
}
$outp ='{"records":['.$outp.']}';
$conn->close();

echo($outp);



?>

