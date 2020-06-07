<?php
require('../../lib/Util.php');

use Telegram\TelegramBot;
use Robots\RobotMatcher;
use App\JSONApp;

class TelegramUpdate extends JSONApp
{
	function main()
	{
		$bot = new TelegramBot(TAG);
		$msg = $bot->read();

		try
		{
			RobotMatcher::register('/^hello *$/i','Robots\Greeting','greeting');
			RobotMatcher::register('/^(d)([0-9]+)$/i','Robots\Dice','roll');
						
			if($msg!=null)
			{				
				return RobotMatcher::run($msg);
			}
		
		}
		catch(Exception $e)
		{
			error_log("Se ha producido un error: ".$e);
		}
	}
}

$app = new TelegramUpdate();
$app->run();
