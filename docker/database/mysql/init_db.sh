#!/bin/bash
/usr/bin/mysqld_safe --skip-grant-tables &

mysql -u root -e "CREATE DATABASE nfm_parser"
mysql -u root -e "CREATE DATABASE nfm_agconet"
#mysql -u root mydb < /tmp/dump.sql