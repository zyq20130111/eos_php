<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$conn = new mysqli("localhost","root","galaxy123456@","eosdb"); 

echo "连接";

$inj_str = "'|and|exec|insert|select|delete|update|count|*|%|chr|mid|master|truncate|char|declare|;|or|-|+|,|drop";
echo($inj_str);
$inj_stra = explode("|",$inj_str);
$c = count($inj_str);
/*
for($i=0 ; $i < count($inj_str) ; $i++)
{
    if($inj_stra[$i] == strtolower($producer)){
        echo '{"code":500}'
        return;
    }
}*/

echo "sssss"

?>
