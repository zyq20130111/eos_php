#!/bin/bash
# author:zhang gang
# $0钱包密码 $1创建账号 $2账号 $3公钥1 $4公钥2 $5内存  $6 CPU $7 NET 

ram="\"$5 EOS\""
cpu="\"$6 EOS\""
net="\"$7 EOS\""
cleos wallet unlock --password PW5Ji9mDxcY83RgQGnooJPQwqMVoSeSABXvff48kevkHYqGV1Ca6T

cmd="cleos system newaccount $1 $2 $3 $4 --buy-ram $ram --stake-cpu $cpu --stake-net $net --transfer"
echo ${cmd}|awk '{run=$0;system(run)}'

cleos wallet lock 
