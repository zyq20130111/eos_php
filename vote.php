<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

echo("aaaaa")
$conn = new mysqli("localhost", "root", "123", "eosdb");
echo("aaaaa")
$result = $conn->query("SELECT voter,proudcer, date,vote  FROM voter_tbl");
echo("bbbbb")
$conn->close();

echo($outp);
*/

?>

