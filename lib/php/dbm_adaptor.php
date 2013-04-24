<?php

abstract class dbm_adaptor 
{
	function init()
	{
		global $__dbm;

		$__dbm['adaptor'] = 'dbm_adaptor_'.$__dbm['type'];
		
		$__dbm['adaptor']::before_connect();
		$__dbm['connection'] = new PDO(
			$__dbm['type'].':host='.$__dbm['host'].';dbname='.$__dbm['database'], 
			$__dbm['username'],
			$__dbm['password'],
			$__dbm['adaptor_options']
		);
		$__dbm['adaptor']::after_connect();
		
	}
	
	public static function before_connect()
	{
	}
	
	public static function after_connect()
	{
	}
	
	public static function get_tables()
	{
		global $__dbm;
		$sql = 'SELECT table_name as name FROM INFORMATION_SCHEMA.TABLES';
		$sql .= ' where table_schema = '.$__dbm['adaptor']::handle_format($__dbm['database']).'';
		
		return dbm::query($sql);
	}
	
	public static function get_columns($table)
	{
		global $__dbm;
		$sql = '
			SELECT COLUMN_NAME as name, 
				DATA_TYPE as data_type, 
				IS_NULLABLE as is_nullable, 
				COLUMN_DEFAULT as column_default,
				CHARACTER_MAXIMUM_LENGTH as max_length,
				NUMERIC_SCALE as numeric_scale
				FROM INFORMATION_SCHEMA.COLUMNS
				where table_schema='.$__dbm['adaptor']::handle_format($__dbm['database']).'
				and table_name = '.$__dbm['adaptor']::handle_format($table).'
				order by ORDINAL_POSITION
				;
			';
		#echo($sql);
		return dbm::query($sql);
	}
	
	function handle_format($input)
	{
		global $__dbm;
		if(is_numeric($input))
			return $input;
		else if(is_null($input) || $input === _DBM_SQL_FAKENULL_)
			return 'NULL';
		else
			return $__dbm['connection']->quote($input);
	}
	
	function handle_error()
	{
		global $__dbm;
		throw new Exception('DBM: error '.$__dbm['connection']->errorCode() . ': ' . $__dbm['connection']->errorInfo());
	}
}

?>