<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

echo("aaaaa")
$conn = new mysqli("eosdb", "root", "123", "Northwind");
echo("aaaaa")
$result = $conn->query("SELECT voter,proudcer, date,vote  FROM voter_tbl");

$outp = "";
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    if ($outp != "") {$outp .= ",";}
    $outp .= '{"voter":"'  . $rs["voter"] . '",';
    $outp .= '"proudcer":"'   . $rs["proudcer"]        . '",';
    $outp .= '"date":"'. $rs["date"]     . '"}'; 
}
$outp ='{"records":['.$outp.']}';
$conn->close();

echo($outp);
?>
