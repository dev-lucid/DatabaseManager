<?php
global $__dbm;
$cmd = 'php -f '.__DIR__.'/../../bin/build_models.php ';
$cmd .= ' type='.$__dbm['type'];
$cmd .= ' database='.$__dbm['database'];
$cmd .= ' username='.$__dbm['username'];
$cmd .= ' password='.$__dbm['password'];
$cmd .= ' host='.$__dbm['host'];
$cmd .= ' model_path='.$__dbm['model_path'];
shell_exec($cmd);

$out = '';

$files = glob($__dbm['model_path'].'/*'); // get all file names
foreach($files as $file)
{
	
	if(is_file($file) && !is_dir($file))
	{
		#echo('hashing: '.$file."\n");
		$out .= md5(file_get_contents($file))."\n";
	}
}

$files = glob($__dbm['model_path'].$__dbm['base_subdir'].'/*'); // get all file names
foreach($files as $file)
{ 
	if(is_file($file) && !is_dir($file))
	{
		#echo('hashing: '.$file."\n");		
		$out .= md5(file_get_contents($file))."\n";
	}
}


file_put_contents($output_path,$out);
?>