<?php

class dbm_adaptor_mysql extends dbm_adaptor
{
	public static function before_connect()
	{
		global $__dbm;
		$__dbm['adaptor_options'][PDO::MYSQL_ATTR_INIT_COMMAND] = "SET NAMES utf8";
	}
}

?>