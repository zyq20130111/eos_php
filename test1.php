<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require 'config.php';
require 'create.php'
$conn = new mysqli(Config::IP,Config::USERNAME,Config::PWD,Config::DB);
bindEosAccount("of9I709bKnn_2w7eNKmGOcGF9Y2k","123123111qqq");
echo "连接";


