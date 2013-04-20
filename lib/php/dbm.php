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
);

class dbm
{
	function log($to_write)
	{
		global $__dbm;
		if(isset($__dbm['hooks']['log']))
		{
			$to_write=(is_object($to_write) || is_array($to_write))?print_r($to_write,true):$to_write;
			$__dbm['hooks']['log']('DBM: '.$to_write);
		}
	}
	
	function call_hook($hook,$p0=null,$p1=null,$p2=null,$p3=null,$p4=null,$p5=null,$p6=null)
	{
		global $__dbm;
		if(isset($__dbm['hooks'][$hook]))
			$__dbm['hooks'][$hook]($p0,$p1,$p2,$p3,$p4,$p5,$p6);
	}
		
	public static function init($config = array())
	{
		global $__dbm;
		
		foreach($config as $key=>$value)
		{
			if(is_array($value))
			{
				foreach($value as $subkey=>$subvalue)
				{
					if(is_numeric($subkey))
						$__dbm[$key][] = $subvalue;
					else
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
		include(__DIR__.'/dbm_adaptor.php');
		
		if($__dbm['type'] != '')
		{
			$adaptor = __DIR__.'/adaptors/'.$__dbm['type'].'.php';
			$adaptor_class = 'dbm_adaptor_'.$__dbm['type'];
			if(file_exists($adaptor))
			{
				include($adaptor);
				if(class_exists($adaptor_class))
				{
					$adaptor_class::init();
				}
				else
				{
					throw new Exception('DBM: Adaptor loaded, but properly named class was not found. Looked for '.$adaptor_class);
				}
			}
			else
			{
				throw new Exception('DBM: Could not find db adaptor for type '.$__dbm['type']);
			}			
		}
	
	}
	
	public static function deinit()
	{
	}
	
	public static function query($sql)
	{
		global $__dbm;
		return $__dbm['connection']->query($sql);
	}
	
	public static function model($name)
	{
		$return = new dbm_model($name);
		return $return;
	}
}

?>