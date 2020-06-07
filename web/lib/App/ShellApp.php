<?php

namespace App;

use Exceptions\CustomException;
use Exceptions\BadRequest;
use Exception;

//Represents a command line callable mini-app
abstract class ShellApp extends App{

    //Runs JSONApp
    public function run()
    {
        try
        {
            exit($this->main());
        }
        catch(CustomException $ce)
        {
            error_log("Error:".$ce->getMessage());
            error_log($ce->getTraceAsString());
            exit($ce->errNumber);
        }
        catch(Exception $ex)
        {
            error_log("Error:".$ce->getMessage());
            error_log($ex->getTraceAsString());
            exit(500);
        }
    }

    // Parses commandline arguments
    protected function parseArgs()
    {
        foreach($_SERVER['argv'] as $arg)
        {
            $pos=strpos($arg,"=");
            if($pos===false)
                $pos=strpos($arg,":");

            if($pos === false)
                $this->args[$arg]=True;
            else
                $this->args[substr($arg,0,$pos)]=substr($arg,$pos+1);
        }
    }
}
