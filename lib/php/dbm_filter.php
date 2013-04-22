<?php
# Copyright 2013 Mike Thorn (github: WasabiVengeance). All rights reserved.
# Use of this source code is governed by a BSD-style
# license that can be found in the LICENSE file.

class dbm_filter
{
	function __construct($field,$operator,$value)
	{
		$this->field = $field;
		$this->operator = $operator;
		$this->value = $value;
	}
	
	function build_sql()
	{
		global $__dbm;
		
		$out = '';
		
		if($this->operator == '!=')
			$this->operator = '<>';
			
		switch ($this->operator)
		{
			case '=':
			case '<>':
				if(is_null($this->value))
				{
					$out = $this->field.' is '.(($this->operator=='=')?'':'not ').'null';
				}
				else
				{
					$out .= $this->field.$this->operator;
					$out .= $__dbm['adaptor']::handle_format($this->value);
				}
				break;
			case '>':
			case '<':
			case '<=':
			case '>=':
			case '=<':
			case '=>':
				if(is_null($this->value))
				{
					throw new Exception('DBM: filter cannot compare to null: '.$this->field);
				}
				
				$out .= $this->field.$this->operator;
				$out .= $__dbm['adaptor']::handle_format($this->value);
				
				break;
			case 'in':
				if(is_string($this->value))
				{
					$out .= $this->field.' '.$this->operator.' ';
					$out .= '('.$this->value.')';
				}
				else
				{
					$vals = array();
					foreach($this->value as $value)
					{
						$vals[] = $__dbm['adaptor']::handle_format($value);
					}
					
					$out .= $this->field.' '.$this->operator.' ';
					$out .= '('.implode(',',$vals).')';
				}
				break;
		}
		return $out;
	}
}

?>