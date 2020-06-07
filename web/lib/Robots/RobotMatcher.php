<?php

namespace Robots;

class RobotMatcher
{
    static $expresions = array();

    static function register($match, $robotName, $func)
    {
        if( isset(RobotMatcher::$expresions[$match]) )
        {
            throw new \Exception("Incompatible robot. Allready registered:".RobotMatcher::$expresions[$match]);
        }

        RobotMatcher::$expresions[$match]=array('robot'=>$robotName,'callback'=>$func);
    }

    static function run($msg)
    {
        try
        {
            $expresion=$msg->text;
            $matchArray = array();
            foreach( RobotMatcher::$expresions as $match => $candidate )
            {
                //error_log("Comprobando ".$match.'=='.$expresion);
                if(preg_match($match,substr($expresion,1),$matchArray))
                {
                    $robotObj = new $candidate['robot'];
                    $function = $candidate['callback'];
                    $robotObj->$function($matchArray,$msg);
                    return;
                }            
            }

            $msg->response('I dont understood you, '.$msg->sender->firstName);
        }
        catch(\Exception $ex)
        {
            $msg->response("Error. $ex");
        }
    }
}

