<?php

class dbm_model__base__table2 extends dbm_model
{
	public function __init_fields()
	{
		$this->__fields[] = new dbm_field('table2_id','bigint',null,0,'');
		$this->__fields[] = new dbm_field('table1_i1','bigint',null,0,'');
		$this->__fields[] = new dbm_field('table2_vc1','varchar',10,null,'');
		$this->__build_index();
	}
}

?>