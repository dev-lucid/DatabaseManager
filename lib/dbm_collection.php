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
		$this->__records->data_seek(0);
		$this->next();
	}
	
	public function valid ( )
	{
		return ($this->__index  < $this->__records->num_rows);
	}
}

?>