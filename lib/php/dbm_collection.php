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
			$this->__import($this->__records->fetch(PDO::FETCH_ASSOC),true);
		}
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

		#$this->__records->data_seek(0);
		$this->next();
	}
	
	public function valid ( )
	{
		#echo('rowCount: '.$this->__index.'/'.$this->__sql_row_count.'<br/>');
		return ($this->__index  < $this->__sql_row_count);
	}
}

?>