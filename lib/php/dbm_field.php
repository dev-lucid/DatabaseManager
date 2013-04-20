<?php
# Copyright 2013 Mike Thorn (github: WasabiVengeance). All rights reserved.
# Use of this source code is governed by a BSD-style
# license that can be found in the LICENSE file.

class dbm_field
{
	function __construct($name,$type,$size1,$size2,$default=null)
	{
		$this->name = $name;
		$this->type = $type;
		$this->size1 = $size1;
		$this->size2 = $size2;
		$this->default = $default;
	}
}

?>