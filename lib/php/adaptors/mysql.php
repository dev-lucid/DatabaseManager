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
	}
	
	function handle_format($input)
	{
		if(is_numeric($input))
			return $input;
		else
			return "'".mysqli_escape_string($input)."'";
	}
}

?>