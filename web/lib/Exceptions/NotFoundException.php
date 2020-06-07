<?php

namespace Exceptions;

class NotFoundException extends CustomException
{	
	public function __construct($path)
	{
		parent::__construct("Not found: $path",404);
	}
}