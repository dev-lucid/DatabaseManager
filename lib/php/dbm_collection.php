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
		
		
		if($this->valid())
			$this->import($this->__records->fetch_assoc(),true);
	}
	
	public function rewind ( )
	{
		$this->__index = -1;

		# if the records haven't been queried for, 
		# do so now
		if(is_null($this->__records))
		{
			$queries = $this->__build_select_query();
			print_r($queries);
			$this->__records = dbm::query($queries[0]);
		}

		#$this->__records->data_seek(0);
		$this->next();
	}
	
	public function valid ( )
	{
		return ($this->__index  < $this->__records->num_rows);
	}
}

?>