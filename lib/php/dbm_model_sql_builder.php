<?php
# Copyright 2013 Mike Thorn (github: WasabiVengeance). All rights reserved.
# Use of this source code is governed by a BSD-style
# license that can be found in the LICENSE file.

class dbm_model_sql_builder extends dbm_collection
{

	protected function __build_select_query()
	{
		$paged_sql     = 'select ';
		$max_page_sql  = 'select ';
		
		$paged_sql    .= $this->__build_field_list();
		$max_page_sql .= 'count('.$this->__table.'.'.$this->__fields[0]->name.') as max_page';
		
		$paged_sql    .= "\n".' from '.$this->__table;
		$max_page_sql .= "\n".' from '.$this->__table;
		
		foreach($this->__sql_joins as $join)
		{
			$paged_sql.= $join->build_join();
			$max_page_sql .= $join->build_join();
		}
		
		$filter_sql    = $this->__build_filters();
		$paged_sql    .= $filter_sql;
		$max_page_sql .= $filter_sql;
		
		$paged_sql    .= $this->__build_sorts();
		$paged_sql    .= $this->__build_paging();
		
		return array($paged_sql,$max_page_sql);
	}
	
	protected function __build_update_query()
	{
		global $__dbm;
		
		list($fields,$vals) = $this->__get_saveable_fields();
		if(count($vals) == 0)
			return false;
			
		$final = array();
		foreach($vals as $idx=>$val)
			$final[$idx] = $__dbm['adaptor']::handle_format($val);
	
		$sql = 'update '.$this->__table.' set ';
		$clauses = array();
		for($i=0;$i<count($fields);$i++)
		{
			$clauses[] = $fields[$i].'='.$final[$i];
		}
		$sql .= implode(',',$clauses);
		$sql .= $this->__build_filters();
		return $sql;
	}
	
	protected function __build_insert_query()
	{
		global $__dbm;
		list($fields,$vals) = $this->__get_saveable_fields();
		if(count($vals) == 0)
			return false;
			
		$final = array();
		foreach($vals as $idx=>$val)
			$final[$idx] = $__dbm['adaptor']::handle_format($val);
		
		$sql = 'insert into '.$this->__table."\n";
		$sql .= '('.implode(',',$fields).')'."\n";
		$sql .= ' values '."\n";
		$sql .= '('.implode(',',$final).');';
		
		$sql .= "\nselect max(".$this->__fields[0]->name.") as new_id from ".$this->__table."; ";
		return $sql;
	}
	
	protected function __build_delete_query()
	{
		return 'delete from '.$this->__table . $this->__build_filters();
	}
		
	protected function __build_filters()
	{
		$filter_clauses = array();
		foreach($this->__sql_filters as $filter)
			$filter_clauses[] = $filter->build_sql();
		
		return (count($filter_clauses) == 0)?'':"\n".' where '.implode("\n".' and ',$filter_clauses);
	}

	protected function __build_field_list()
	{
		$fields = array();
		foreach($this->__fields as $field)
			$fields[] = $this->__table.'.'.$field->name;
		
		foreach($this->__sql_joins as $join)
		{
			$join_fields = $join->build_fields();
			$fields = array_merge($fields, $join_fields);
		}
		return implode(',',$fields);
	}
	
	protected function __build_sorts()
	{
		if(count($this->__sql_sorts) == 0)
			return '';
		return "\n".'order by '.implode(',',$this->__sql_sorts);
	}
	
	protected function __build_paging()
	{
		if(!is_null($this->__sql_limit) && is_null($this->__sql_offset))
		{
			return "\n".'limit '.$this->__sql_limit;
		}
		else if(!is_null($this->__sql_limit) && !is_null($this->__sql_offset))
		{
			return "\n".'limit '.$this->__sql_offset.','.$this->__sql_limit;
		}
		return '';
	}
		
	protected function __get_saveable_fields()
	{
		$fields = array();
		$vals   = array();
		for($i=1;$i<count($this->__fields);$i++)
		{
			if(!isset($this->__data[$this->__fields[$i]->name]))
			{
				$this->__data[$this->__fields[$i]->name] = null;
			}
			if(!isset($this->__original_data[$this->__fields[$i]->name]))
			{
				$this->__original_data[$this->__fields[$i]->name] = null;
			}
			
			if($this->__original_data[$this->__fields[$i]->name] !== $this->__data[$this->__fields[$i]->name])
			{
				$fields[] = $this->__fields[$i]->name;
				$vals[]   = $this->__data[$this->__fields[$i]->name];
			}
			
		}
		return array($fields,$vals);
	}
	
	/*
	
	public function limit($new_limit)
	{
		$this->__sql_limit = $new_limit;
		return $this;
	}
	
	public function page($new_page,$limit=null)
	{
		if(!is_null($limit))
		{
			$this->__sql_limit = $limit;
		}
		$this->__sql_offset = $this->__sql_limit * $new_page;
		return $this;
	}
	
	public function sort($field,$dir = 'asc')
	{
		$field .= ($dir == 'asc')?'':' desc';
		$this->__sql_sorts[] = $field;
		return $this;
	}
	
	public function filter($field,$operator,$value=_DBM_SQL_FAKENULL_)
	{
		if($value === _DBM_SQL_FAKENULL_)
		{
			$value = $operator;
			$operator = '=';
			if(is_array($value))
				$operator = 'in';
		}
		$this->__sql_filters[] = new dbm_filter($field,$operator,$value);
		return $this;
	}
	*/
}


?>