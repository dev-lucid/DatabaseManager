<?php

$table = dbm::model('table1')->join('table2');
$out = $table->dump(false);


file_put_contents($output_path,$out);
?>