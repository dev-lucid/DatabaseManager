<?php
# Copyright 2013 Mike Thorn (github: WasabiVengeance). All rights reserved.
# Use of this source code is governed by a BSD-style
# license that can be found in the LICENSE file.

global $__dbm;
$__dbm = array(
	'type'=>'',
	'host'=>'',
	'username'=>'',
	'password'=>'',
	'port'=>'',
	'connection'=>null,
	'hooks'=>array(),
	'log_hook'=>null,
);

class dbm
{
	
	public static function init($config = array())
	{
		global $__dbm;
		
		foreach($config as $key=>$value)
		{
			if(is_array($value))
			{
				foreach($value as $subkey=>$subvalue)
				{
					$__dbm[$key][$subkey] = $subvalue;
				}
			}
			else
				$__dbm[$key] = $value;
		}	
		
		include(__DIR__.'/dbm_collection.php');
		include(__DIR__.'/dbm_model_sql_builder.php');
		include(__DIR__.'/dbm_model_sql_clauses.php');
		include(__DIR__.'/dbm_field.php');
		include(__DIR__.'/dbm_model.php');
		
		if($__dbm['type'] != '')
		{
			$adaptor = __DIR__.'/adaptors/'.$type.'.php';
			$adaptor_class = 'dbm_adaptor_'.$type;
			if(file_exists($adaptor))
			{
				include($adaptor);
				if(class_exists($adaptor_class))
				{
					$__dbm['connection'] = new $adaptor_class();
				}
				else
				{
					throw new Exception('DBM: Adaptor loaded, but properly named class was not found. Looked for '.$adaptor_class);
				}
			}
			else
			{
				throw new Exception('DBM: Could not find db adaptor for type '.$type);
			}
		}
	
	}
	
	public static function query($sql)
	{
		return $__dbm['connection']->query($sql);
	}
	
	public static function model($name)
	{
	}
	
	function log($string_to_log)
	{
		global $__dbm;
		if(!is_null($__dbm['log_hook']))
		{
			$__dbm['log_hook']('DBM: '.$string_to_log);
		}
	}
	
	function deinit()
	{
	}
}

?>