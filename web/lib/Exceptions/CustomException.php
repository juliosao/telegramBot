<?php

namespace Exceptions;

class CustomException extends \Exception
{	
	public function __construct($msg,$errNumber=500)
	{
		$this->errNumber=$errNumber;
		parent::__construct($msg);
	}
}