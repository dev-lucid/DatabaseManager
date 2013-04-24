<?php

$result = dbm::query('select * from table1;');

$out = '';
while($row = $result->fetch(PDO::FETCH_ASSOC))
{
	#print_r($row);
	$out .= print_r($row,true)."\n";
}

file_put_contents($output_path,$out);
?>