<?php

class dbm_adaptor_postgresql extends dbm_adaptor
{
	public static function after_connect()
	{
		dbm::query('SET CLIENT_ENCODING TO \'UTF8\';');
	}
}

?>