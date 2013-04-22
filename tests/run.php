<?php
# Copyright 2013 Mike Thorn (github: WasabiVengeance). All rights reserved.
# Use of this source code is governed by a BSD-style
# license that can be found in the LICENSE file.

include_once(__DIR__.'/../lib/php/dbm.php');

global $output_path,$nl,$__dbm,$config;
$output_path = '';
$nl = (isset($_SERVER['HTTP_HOST']))?'<br />':"\n";
$output  = __DIR__.'/generated/';
$compare = __DIR__.'/expected/';
$tests  = __DIR__.'/tests/';

$config = array(
	'type'=>'mysql',
	'username'=>'dbm_testuser',
	'password'=>'dbm_testuser',
	'database'=>'dbm_testdb',
	'host'=>'localhost',
	'model_path'=>__DIR__.'/generated/models/',
);


$files = glob($output.'*');
foreach($files as $file)
{
	if(is_file($file))
		unlink($file); 
}

function mylogger($string)
{
	global $nl;
	echo($string.$nl);
}
#$__dbm['hooks']['log'] = 'mylogger';


$fail_count = 0;
echo('rebuilding database'.$nl);
echo('mysql --user='.$config['username'].' --password='.$config['password'].' '.$config['database'].' < '.__DIR__.'/testdb.mysql.sql;'.$nl);
shell_exec('mysql --user='.$config['username'].' --password='.$config['password'].' '.$config['database'].' < '.__DIR__.'/testdb.mysql.sql;');

echo('removing all existing models'.$nl);
$files = glob($config['model_path'].'/*'); // get all file names
foreach($files as $file)
{
	if(is_file($file))
		unlink($file);
}

$files = glob($config['model_path'].$config['base_subdir'].'/*'); // get all file names
foreach($files as $file)
{ 
	if(is_file($file))
		unlink($file); 
}

echo('Beginning test run'.$nl.' '.$nl);



$files = glob($tests.'*');
foreach($files as $file)
{
	if(is_file($file))
	{
		$name = str_replace(__DIR__.'/tests/','',str_replace('.php','',$file));
		$output_path = $output . $name.'.txt';
		#echo($name.$nl);
		include($file);
		
		if(file_exists($output . $name.'.txt'))
		{
			$to_test  = file_get_contents($output . $name.'.txt');
		}
		else
		{
			$to_test = -1;
		}
		
		if(file_exists($output . $name.'.txt'))
		{
			$good_val  = file_get_contents($compare . $name.'.txt');
		}
		else
		{
			$good_val = -2;
		}
		
		echo($name.': ');
		
		if($to_test != $good_val)
			$fail_count++;
			
		$result = ($to_test == $good_val)?'SUCCESS':'FAIL';
		echo($result);
		echo($nl);
	}
}

echo('-----------------'.$nl);
if($fail_count == 0)
{
	echo('ALL TESTS PASS!'.$nl);
}
else
{
	echo($fail_count. ' TEST(S) FAILED'.$nl);
}



?>