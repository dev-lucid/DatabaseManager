<?php

$table = dbm::model('table1');
$table->__fields[] = new dbm_field('table1_id','int',8,null);
$table->__fields[] = new dbm_field('table1_vc1','string',5,null);
$table->__fields[] = new dbm_field('table1_vc2','string',255,null);
$table->__fields[] = new dbm_field('table1_i1','int',2,null);
$table->__build_index();
#print_r($table);

$out = '';
foreach($table as $row)
{
	#print_r($row);
	$out .= print_r($row,true)."\n";
}

file_put_contents($output_path,$out);
?>