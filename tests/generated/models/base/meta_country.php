<?php

class dbm_model__base__meta_country extends dbm_model
{
	public function __init_fields()
	{
		$this->__fields[] = new dbm_field('country_code','char',2,null,'');
		$this->__fields[] = new dbm_field('alpha_3','char',3,null,'');
		$this->__fields[] = new dbm_field('numeric','char',3,null,'');
		$this->__fields[] = new dbm_field('country_name','varchar',255,null,'');
		$this->__fields[] = new dbm_field('common_name','varchar',255,null,'');
		$this->__fields[] = new dbm_field('official_name','varchar',255,null,'');
		$this->__build_index();
	}
}

?>