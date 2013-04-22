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
		
		$paged_sql    .= ' from '.$this->__table;
		$max_page_sql .= ' from '.$this->__table;
		
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
		
		dbm::log('sql built: '.$paged_sql);
		return array($paged_sql,$max_page_sql);
	}
	
	protected function __build_update_query()
	{
		list($fields,$vals) = $this->__get_saveable_fields();
		if(count($vals) == 0)
			return false;
		$vals = dbm_db::escape($vals);
	
		$sql = 'update '.$this->__table.' set ';
		$clauses = array();
		for($i=0;$i<count($fields);$i++)
		{
			$clauses[] = $fields[$i].'='.$vals[$i];
		}
		$sql .= implode(',',$clauses);
		$sql .= $this->__build_filters();
		return $sql;
	}
	
	protected function __build_insert_query()
	{
		list($fields,$vals) = $this->__get_saveable_fields();
		if(count($vals) == 0)
			return false;
		$vals = dbm_db::escape($vals);
		
		$sql = 'insert into '.$this->__table.' ';
		$sql .= '('.implode(',',$fields).') values ';
		$sql .= '('.implode(',',$vals).');';
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
		
		return (count($filter_clauses) == 0)?'':' where '.implode(' and ',$filter_clauses);
	}

	protected function __build_field_list()
	{
		$fields = array();
		foreach($this->__fields as $field)
			$fields[] = $this->__table.'.'.$field->name;
		
		foreach($this->__sql_joins as $join)
		{
			$fields = array_merge($fields, $join->build_fields());
		}
		return implode(',',$fields);
	}
	
	protected function __build_sorts()
	{
		if(count($this->__sql_sorts) == 0)
			return '';
		return ' order by '.implode(',',$this->__sql_sorts);
	}
	
	protected function __build_paging()
	{
		if(!is_null($this->__sql_limit) && is_null($this->__sql_offset))
		{
			return ' limit '.$this->__sql_limit;
		}
		else if(!is_null($this->__sql_limit) && !is_null($this->__sql_offset))
		{
			return ' limit '.$this->__sql_offset.','.$this->__sql_limit;
		}
		return '';
	}
		
	protected function __get_saveable_fields()
	{
		$fields = array();
		$vals   = array();
		foreach($this->__fields as $field)
		{
			if(!isset($this->__data[$field->name]))
			{
				$this->__data[$field->name] = null;
			}
			if(!isset($this->__original_data[$field->name]))
			{
				$this->__original_data[$field->name] = null;
			}
			
			if($this->__original_data[$field->name] !== $this->__data[$field->name])
			{
				$fields[] = $field->name;
				$vals[]   = $this->__data[$field->name];
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