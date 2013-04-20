create user dbm_testuser@'localhost' identified by 'dbm_testuser';
create database dbm_testdb;
grant all on *.* to 'dbm_testuser'@'localhost';
 