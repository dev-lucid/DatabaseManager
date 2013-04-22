<?php
# Copyright 2013 Mike Thorn (github: WasabiVengeance). All rights reserved.
# Use of this source code is governed by a BSD-style
# license that can be found in the LICENSE file.

class dbm_model_sql_clauses extends dbm_model_sql_builder
{
	public function filter($field,$operator='',$value=_DBM_SQL_FAKENULL_)
	{
		if($value == _DBM_SQL_FAKENULL_)
		{
			$value = $operator;
			$operator = '=';
		}
		$this->__sql_filters[] = new dbm_filter($field,$operator,$value);
		return $this;
	}
	
	public function group()
	{
		return $this;
	}
	
	public function sort($col,$direction='asc')
	{
		$new_sort = $col;
		$new_sort .= ($direction=='asc')?'':' desc';
		$this->__sql_sorts[] = $new_sort;
		return $this;
	}
	
	public function limit($page_size)
	{
		$this->__sql_limit = $page_size;
		return $this;
	}
	
	public function page($start_page,$page_size)
	{
		$this->__sql_determine_max_page = true;
		$this->__sql_limit  = $page_size;
		$this->__sql_offset = $start_page * $page_size;
		return $this;
	}
	
	public function join($table,$fields,$conditions,$type='inner')
	{
		$this->__joins[] = new dbm_model_sql_join($table,$conditions,$fields,$type);
		return $this;
	}
	
	public function load($id=null)
	{
		if(is_numeric($id))
			$this->filter($this->__fields[0]->name,'=',$id);
		list($paged_sql,$max_page_sql) = $this->__build_select_query();
		
		# if we need to determine the max page, then do so
		if($this->__sql_determine_max_page === true)
		{
			$records = dbm_db::query($max_page_sql);
			$record = $records->fetch_assoc();
			$this->__sql_max_page = ceil($record['max_page'] / $this->__sql_limit);
		}
		$this->__records = dbm::query($paged_sql);
		
		if ($this->__records->num_rows == 1)
		{
			$this->rewind();
		}
		return $this;
	}
	
	public function save($form_id='')
	{
		if(
			isset($this->__data[$this->__fields[0]->name])
			&&
			!is_null($this->__data[$this->__fields[0]->name])
		)
			$sql = $this->__build_update_query();
		else
			$sql = $this->__build_insert_query();
			
		if($sql !== false)
			dbm::query($sql);
					
		return $this;
	}

	public function delete($id=null)
	{
		if(!is_null($id))
			$this->filter($this->__fields[0]->name,'=',$id);
		
		dbm::query($this->__build_delete_query());
		return $this;
	}
}

?>