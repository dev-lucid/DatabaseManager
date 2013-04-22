<?php

class dbm_adaptor_mysql extends dbm_adaptor
{
	function init()
	{
		global $__dbm;
		
		$__dbm['adaptor'] = __CLASS__;
		$__dbm['connection'] = mysqli_connect(
			$__dbm['hostname'],
			$__dbm['username'],
			$__dbm['password'],
			$__dbm['database']
		);
		
		if (mysqli_connect_errno($con))
		{
			throw new Exception('DBM: Could not connect to database: '.mysqli_connect_error());
		}
	}
	
	function handle_format($input)
	{
		global $__dbm;
		if(is_numeric($input))
			return $input;
		else
			return "'".mysqli_real_escape_string($__dbm['connection'],$input)."'";
	}
}

?>