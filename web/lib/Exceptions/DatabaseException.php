<?php

namespace Exceptions;


class DatabaseException extends CustomException
{
	public function __construct($msg)
	{
		parent::__construct("DatabaseException: $msg");
	}
}