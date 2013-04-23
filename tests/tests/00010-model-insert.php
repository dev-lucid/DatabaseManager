<?php
$out = '';
$table = dbm::model('table1');
$table['table1_vc1'] = 'test';
$table->save();

$out .= 'new id: '.$table['table1_id']."\n";

$table->new_query()->filter('table1_vc1','test');
$out .= $table->dump(false);

file_put_contents($output_path,$out);
?>