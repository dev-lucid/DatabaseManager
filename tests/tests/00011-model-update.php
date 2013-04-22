<?php

$table = dbm::model('table1')->filter('table1_vc1','test')->load();
$table['table1_vc1'] = 'test2';
$table->save();

$table->new_query();
$out = $table->dump(false);

file_put_contents($output_path,$out);
?>