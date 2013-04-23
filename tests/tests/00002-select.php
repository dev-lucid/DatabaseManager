<?php

$result = dbm::query('select * from table1;');
print_r($result);
$out = '';
while($row = $result->fetch_assoc())
{
	#print_r($row);
	$out .= print_r($row,true)."\n";
}

file_put_contents($output_path,$out);
?>