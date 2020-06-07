<?php

namespace App;

use Exceptions\CustomException;
use Exceptions\BadRequest;
use Exception;

//Represents a http callable mini-application
abstract class JSONApp extends App{
   
    //Runs JSONApp
    public function run()
    {
        try
        {            
            $this->exitApp(json_encode($this->main()));
        }
        catch(CustomException $ce)
        {
            $this->exitApp(json_encode(["error"=>$ce->getMessage()]),$ce->errNumber,$ce->getMessage());
        }
        catch(Exception $ex)
        {
            $this->exitApp(json_encode(["error"=>$ex->getMessage()]),500,$ex->getMessage());
        }
    }

    /** 
     * Parses app arguments in json format
     */
    protected function parseArgs()
    {
        $json = file_get_contents('php://input');
        $this->args = json_decode($json,true);
    }
    
}
