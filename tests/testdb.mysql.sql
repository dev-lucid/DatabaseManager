
drop table if exists table1;
create table table1(
	table1_id int8 primary key auto_increment,
	table1_vc1 varchar(5),
	table1_vc2 varchar(255),
	table1_i1 int2
);

insert into table1 (table1_vc1,table1_vc2,table1_i1) values ('a','A',1);
insert into table1 (table1_vc1,table1_vc2,table1_i1) values ('b','B',2);
insert into table1 (table1_vc1,table1_vc2,table1_i1) values ('c','C',1);
insert into table1 (table1_vc1,table1_vc2,table1_i1) values ('d','D',2);
insert into table1 (table1_vc1,table1_vc2,table1_i1) values ('e','E',1);
insert into table1 (table1_vc1,table1_vc2,table1_i1) values ('f','F',2);
insert into table1 (table1_vc1,table1_vc2,table1_i1) values ('g','G',1);
insert into table1 (table1_vc1,table1_vc2,table1_i1) values ('h','H',2);
insert into table1 (table1_vc1,table1_vc2,table1_i1) values ('i','I',1);
insert into table1 (table1_vc1,table1_vc2,table1_i1) values ('j','J',2);
insert into table1 (table1_vc1,table1_vc2,table1_i1) values ('k','K',1);

drop table if exists table2;
create table table2(
	table2_id int8 primary key auto_increment,
	table1_i1 int8,
	table2_vc1 varchar(10),
);
insert into table2 (table1_i1,table2_vc1) values (1,'state:1');
insert into table2 (table1_i1,table2_vc1) values (2,'state:2');