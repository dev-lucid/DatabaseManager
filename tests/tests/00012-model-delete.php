<?php

$table = dbm::model('table1')->filter('table1_vc1','test2')->delete();
$table->new_query()->delete(10);

$table->new_query();
$out = $table->dump(false);

file_put_contents($output_path,$out);
?>