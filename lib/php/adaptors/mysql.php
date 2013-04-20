<?php

class dbm_adaptor_mysql extends dbm_adaptor
{
	function init()
	{
		global $__dbm;
		
		$__dbm['connection'] = mysqli_connect(
			$__dbm['hostname'],
			$__dbm['username'],
			$__dbm['password'],
			$__dbm['database']
		);
	}
}

?>