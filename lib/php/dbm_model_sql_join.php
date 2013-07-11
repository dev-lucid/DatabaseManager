<?php
# Copyright 2013 Mike Thorn (github: WasabiVengeance). All rights reserved.
# Use of this source code is governed by a BSD-style
# license that can be found in the LICENSE file.

class dbm_model_sql_join
{
	function __construct($table,$type,$conditions,$fields=null)
	{
		$this->table = $table;
		$this->type = $type;
		$this->conditions = $conditions;
		$this->fields = $fields;
	}
	
	function build_fields()
	{
		$fields = $this->fields;

		if(is_null($this->fields))
		{
			foreach($this->table->__field_index as $field=>$idx)
			{
				$fields[] = $this->table->__table.'.'.$field;
			}
		}
		
		return $fields;
	}
	
	function build_join()
	{
		return "\n ".$this->type.' join '.$this->table->__table.' on '.$this->conditions;
	}
}

?>