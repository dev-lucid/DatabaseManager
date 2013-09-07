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
	
	public function next ( )
	{
		$this->__index++;
		$this->__reset();
		
		# if the records haven't been queried for, 
		# do so now
		if(is_null($this->__records))
		{
			$this->load();
		}
		
		if($this->valid())
		{
			$this->__import($this->__records[$this->__index],true);
			return true;
		}
		return false;
	}
	
	public function rewind ( )
	{
		$this->__index = -1;

		# if the records haven't been queried for, 
		# do so now
		if(is_null($this->__records))
		{
			$this->load();
		}
		
		$this->next();
	}
	
	public function valid ( )
	{
		return ($this->__index  < $this->__sql_row_count);
	}
	
	public function at_start()
	{
		return ($this->__index == 0);
	}
	
	public function at_end()
	{
		return (($this->__index + 1)  == $this->__sql_row_count);
	}
}

?>