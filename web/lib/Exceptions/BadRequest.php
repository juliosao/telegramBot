<?php

namespace Exceptions;

class BadRequest extends CustomException
{
	public function __construct($msg)
	{
		parent::__construct("BadRequest: $msg",400);
	}
}