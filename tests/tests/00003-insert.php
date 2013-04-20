<?php

dbm::query('insert into table1 (table1_vc1,table1_vc2,table1_i1) values (\'l\',\'L\',1);');

$result = dbm::query('select * from table1;');
$out = '';
foreach($result as $row)
{
	$out .= print_r($row,true)."\n";
}

file_put_contents($output_path,$out);
?>