#!/bin/bash
# author:zhang gang
# $0钱包密码 $1创建账号 $2账号 $3公钥1 $4公钥2 $5内存  $6 CPU $7 NET 
cleos wallet lock
cleos wallet unlock --password $0
cleos system newaccount $1 $2 $3 $4 --buy-ram $5 --stake-cpu $6 --stake-net $7 --transfer
cleos wallet lock 
