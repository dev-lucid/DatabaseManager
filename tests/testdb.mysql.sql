
drop table if exists table1;
create table table1(
	table1_id int8 primary key auto_increment,
	table1_vc1 varchar(5),
	table1_vc2 varchar(255),
	table1_i1 int2
);

insert into table1 (table1_vc1,table1_vc2,table1_i1) values ('a','A',0);
insert into table1 (table1_vc1,table1_vc2,table1_i1) values ('b','B',1);
insert into table1 (table1_vc1,table1_vc2,table1_i1) values ('c','C',0);
insert into table1 (table1_vc1,table1_vc2,table1_i1) values ('d','D',1);
insert into table1 (table1_vc1,table1_vc2,table1_i1) values ('e','E',0);
insert into table1 (table1_vc1,table1_vc2,table1_i1) values ('f','F',1);
insert into table1 (table1_vc1,table1_vc2,table1_i1) values ('g','G',0);
insert into table1 (table1_vc1,table1_vc2,table1_i1) values ('h','H',1);
insert into table1 (table1_vc1,table1_vc2,table1_i1) values ('i','I',0);
insert into table1 (table1_vc1,table1_vc2,table1_i1) values ('j','J',1);
insert into table1 (table1_vc1,table1_vc2,table1_i1) values ('k','K',0);