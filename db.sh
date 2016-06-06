#!/bin/sh
cd /opt/lampp/bin
./mysql -uroot -e "drop database BoardDB;"
./mysql -uroot -e  "create database BoardDB char set utf8;"
./mysql -uroot BoardDB -e "create table User(name varchar(255) not null primary key ,password varchar(255));"
./mysql -uroot BoardDB -e "create table Board(name varchar(255) not null primary key,time datetime,text varchar(255));"
# ./mysql -uroot todoDB -e "insert into ToDoList(text) value('testdata');"
# ./mysql -uroot todoDB -e "select * from ToDoList;"
