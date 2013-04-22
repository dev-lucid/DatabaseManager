<?php

class dbm_model__base__table1 extends dbm_model
{
	public function __init_fields()
	{
		$this->__fields[] = new dbm_field('table1_id','bigint',null,0,'');
		$this->__fields[] = new dbm_field('table1_vc1','varchar',5,null,'');
		$this->__fields[] = new dbm_field('table1_vc2','varchar',255,null,'');
		$this->__fields[] = new dbm_field('table1_i1','smallint',null,0,'');
		$this->__build_index();
	}
}

?>