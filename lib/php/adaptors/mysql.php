<?php

class dbm_adaptor_mysql extends dbm_adaptor
{

	
	function handle_error()
	{
		global $__dbm;
		throw new Exception('DBM: mysql error '.$__dbm['connection']->errno . ': ' . $__dbm['connection']->error);
	}
	
	function handle_format($input)
	{
		global $__dbm;
		if(is_numeric($input))
			return $input;
		else
			return "'".addslashes($input)."'";
	}
}

?>