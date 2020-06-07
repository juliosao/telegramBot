<?php

namespace App;

use Exceptions\BadRequest;

//Represents a http callable mini-application
abstract class App {
	private static $appDir = null;
	private static $appURL = null;
    protected $result;

    public function __construct()
    {
		$this->parseArgs();		
        $this->result=array();
    }

	public abstract function main();

	// Parses application arguments
	protected function parseArgs()
	{
		$this->args=$_REQUEST;
	}

    //Runs JSONApp
	public function run()
	{		
		$this->main();
	}


	public function exitApp($msg="",$errCode=200,$errMsg="OK")
	{
		$protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
        header($protocol.' '.$errCode.' ' .$errMsg);
        $GLOBALS['http_response_code'] = $errCode;
		die($msg);
	}
	
	public static function getAppDir()
	{
		if(self::$appDir===null)
			self::$appDir = dirname(__DIR__).DIRECTORY_SEPARATOR;
		return self::$appDir;
	}
	
	public static function getAppURL()
	{
		if(self::$appURL === null);
		{
			$tmpRoot=explode(DIRECTORY_SEPARATOR,$_SERVER['CONTEXT_DOCUMENT_ROOT']);
			$tmpApp=explode(DIRECTORY_SEPARATOR,self::getAppDir());

			while(count($tmpRoot) && $tmpRoot[0] == $tmpApp[0])
			{
				array_shift($tmpRoot);
				array_shift($tmpApp);
			}

			self::$appURL= $_SERVER['CONTEXT_PREFIX'].DIRECTORY_SEPARATOR.implode('/',$tmpApp);
		}
		return self::$appURL;
	}
	
	/**
	 * \fn reqParam
	 * \brief Returns param or throws exception
	 */
	public function reqParam($param)
	{		
		if(!isset($this->args[$param]))
		{
			throw new BadRequest($param);
		}
		return $this->args[$param];				
	}
}
