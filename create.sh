#!/bin/bash
# author:zhang gang
# $0钱包密码 $1创建账号 $2账号 $3公钥1 $4公钥2 $5内存  $6 CPU $7 NET 
ram="\"$6\""
cpu="\"$7\""
net="\"$8\""
echo $2
echo $3
echo $4
echo $5
echo $ram
echo $cpu
echo $net
cleos wallet lock
cleos wallet unlock --password $1
createcmd="cleos system newaccount $2 $3 $4 $5 --buy-ram $ram --stake-cpu $cpu --stake-net $net --transfer"
echo createcmd
{createcmd}
cleos wallet lock 
