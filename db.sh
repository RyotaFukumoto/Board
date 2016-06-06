#!/bin/sh
cd /opt/lampp/bin
./mysql -uroot -e "drop database BoardDB;"
./mysql -uroot -e  "create database BoardDB char set utf8;"
./mysql -uroot BoardDB -e "create table User(name varchar(255) not null primary key ,password varchar(255) );"
./mysql -uroot BoardDB -e "create table Board(id int not null auto_increment primary key,name varchar(255)  ,time datetime,text varchar(255));"
./mysql -uroot BoardDB -e "insert into User(name,password) value('yamada','taro');"
./mysql -uroot BoardDB -e "select * from User;"
./mysql -uroot BoardDB -e "insert into Board(name,time,text) value('yamada','YYYYMMDD[ hh:mm:ss[.mmm]]','taro');"
./mysql -uroot BoardDB -e "select * from Board;"
