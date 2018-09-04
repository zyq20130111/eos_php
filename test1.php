<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require 'config.php';

$conn = new mysqli(Config::IP,Config::USERNAME,Config::PWD,Config::DB);

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
try{
  $cc = [];
  echo $[cc]["aaaaa"];
}
catch(Exception $e){
  echo "aaa";
}
?>
