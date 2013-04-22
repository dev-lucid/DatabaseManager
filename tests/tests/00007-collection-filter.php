<?php

$table = dbm::model('table1');
$table->__fields[] = new dbm_field('table1_id','int',8,null);
$table->__fields[] = new dbm_field('table1_vc1','string',5,null);
$table->__fields[] = new dbm_field('table1_vc2','string',255,null);
$table->__fields[] = new dbm_field('table1_i1','int',2,null);
$table->__build_index();
$out = '';


$table->filter('table1_id',3);
$out .= $table->dump(false);

$table->new_query()->load(5);
$out .= $table->dump(false);

$table->new_query()->filter('table1_id','in',array(4,6));
$out .= $table->dump(false);

$table->new_query()->filter('table1_id','<',10)->filter('table1_id','>',8);
$out .= $table->dump(false);

file_put_contents($output_path,$out);
?>