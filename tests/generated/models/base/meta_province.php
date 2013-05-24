<?php

class dbm_model__base__meta_province extends dbm_model
{
	public function __init_fields()
	{
		$this->__fields[] = new dbm_field('sys_code','varchar',10,null,'');
		$this->__fields[] = new dbm_field('iso_code','varchar',7,null,'');
		$this->__fields[] = new dbm_field('country_code','char',2,null,'');
		$this->__fields[] = new dbm_field('code','varchar',4,null,'');
		$this->__fields[] = new dbm_field('province_name','varchar',255,null,'');
		$this->__fields[] = new dbm_field('type','varchar',30,null,'');
		$this->__fields[] = new dbm_field('parent','varchar',7,null,'');
		$this->__fields[] = new dbm_field('is_parent','tinyint',null,0,'0');
		$this->__build_index();
	}
}

?>