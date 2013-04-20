<?php

$result = dbm::query('select * from table1;');
$out = '';
foreach($result as $row)
{
	$out .= print_r($row,true)."\n";
}

file_put_contents($output_path,$out);
?>