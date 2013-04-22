<?php

global $__dbm;
include(__DIR__.'/../lib/php/dbm.php');
$config = array();
for($i=1;$i<count($argv);$i++)
{
	$param = explode('=',$argv[$i]);
	$config[$param[0]] = $param[1];
}

#print_r($config);
#exit();

dbm::init($config);

echo("inited\n");
$tables = $__dbm['adaptor']::get_tables();
while($table = $tables->fetch_assoc())
{
	$base_out = '';
	$main_out = '';
	
	$base_file = __DIR__.'/'.$__dbm['model_path'].$__dbm['base_subdir'].$table['name'].'.php';
	$main_file = __DIR__.'/'.$__dbm['model_path'].$table['name'].'.php';
	echo("\tbuilding base model for ".$table['name']."\n");
	
	
	$base_out .= '<'."?php\n\nclass dbm_model__base__".$table['name']." extends dbm_model\n{\n";
	$main_out .= '<'."?php\n\nclass dbm_model__".$table['name']." extends dbm_model__base__".$table['name']."\n{\n";
	
	$base_out .= "\tpublic function __init_fields()\n\t{\n";
	$cols = $__dbm['adaptor']::get_columns($table['name']);
	while($col = $cols->fetch_assoc())
	{
		echo("\t\t".$col['name']."\n");
		
		$base_out .= "\t\t$".'this->__fields[] = new dbm_field(';
		
		$base_out .= "'".$col['name']."',";
		$base_out .= "'".$col['data_type']."',";
		$base_out .= (is_numeric($col['max_length']))?$col['max_length'].',':'null,';
		$base_out .= (is_numeric($col['numeric_scale']))?$col['numeric_scale'].',':'null,';
		$base_out .= "'".$col['column_default']."'";
		
		
		$base_out .= ');'."\n";
		#print_r($col);
	}
	$base_out .= "\t\t$"."this->__build_index();\n";
	$base_out .= "\t}";
	
	$base_out .= "\n}\n\n?".'>';
	$main_out .= "\n}\n\n?".'>';
	
	echo("\twriting cols to ".$base_file."\n");
	
	# remove the old one, error if we can't.
	if(file_exists($base_file))
	{
		unlink($base_file);
		if(file_exists($base_file))
			throw new Exception('DBM: Could not remove base file: '.$base_file);
	}
	

	file_put_contents($base_file,$base_out);
	if(!file_exists($base_file))
		throw new Exception('DBM: Could not write new base file: '.$base_file);
	
	if(!file_exists($main_file))
	{
		file_put_contents($main_file,$main_out);
		if(!file_exists($main_file))
			throw new Exception('DBM: Could not write new main file: '.$main_file);
	}
}

?>