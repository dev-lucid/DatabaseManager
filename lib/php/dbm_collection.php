<?php

class dbm_collection implements Iterator
{
	public function current ( )
	{
		return $this;
	}
	
	public function key ( )
	{
		return $this->__index;
	}
	
	public function load()
	{
		return $this->next();
	}
	
	public function next ( )
	{
		$this->__index++;
		$this->__reset();
		
		# if the records haven't been queried for, 
		# do so now
		if(is_null($this->__records))
		{
			$this->__load();
		}
		
		if($this->valid())
			$this->__import($this->__records->fetch_assoc(),true);
	}
	
	public function rewind ( )
	{
		$this->__index = -1;

		# if the records haven't been queried for, 
		# do so now
		if(is_null($this->__records))
		{
			$this->__load();
		}

		#$this->__records->data_seek(0);
		$this->next();
	}
	
	public function valid ( )
	{
		return ($this->__index  < $this->__records->num_rows);
	}
	
	protected function __load()
	{
		$queries = $this->__build_select_query();
		$this->__records = dbm::query($queries[0]);
		
		
		if(!is_null($this->__sql_limit) && !is_null($this->__sql_offset))
		{
			$max_page = dbm::query($queries[1]);
			$result = $max_page->fetch_assoc();
			$this['__max_page'] = ceil($result['max_page'] / $this->__sql_limit);			
		}
	}
}

?>