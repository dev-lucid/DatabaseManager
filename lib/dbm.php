<?php
# Copyright 2013 Mike Thorn (github: WasabiVengeance). All rights reserved.
# Use of this source code is governed by a BSD-style
# license that can be found in the LICENSE file.

global $__dbm;

class dbm
{
	public static function init($type=null,$host=null,$username=null,$password=null,$port=null)
	{
		global $__dbm;
		$__dbm = array(
			'type'=>$type,
			'host'=>$host,
			'username'=>$username,
			'password'=>$password,
			'port'=>$port,
			'connection'=>null,
			'hooks'=>array()
		);
		
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
}

?>