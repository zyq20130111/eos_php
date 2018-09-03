<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require 'config.php';

$conn = new mysqli("127.0.0.1",Config::USERNAME,Config::PWD,Config::DB);

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
