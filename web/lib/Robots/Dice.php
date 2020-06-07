<?php

namespace Robots;

class Dice
{
    function roll($test,$msg)
    {
        try
        {
            $max = intval($test[2]);
            if( $max < 1)
            {
                $msg->chat->sendMessage("Can't create dice with theese properties... (1,$max)");
                return;
            }

            $msg->chat->sendMessage("".random_int(1,$max));            
        }
        catch(\Exception $e)
        {
            $msg->chat->sendMessage("Can't create dice with theese properties. Use /d<number>");
        }
    }

    function tr($test,$msg)
    {
        $suma=0;
        do
        {

            $tmp=random_int(1,100);
            $msg->response("Tirada: $tmp");
            $suma+=$tmp;
        }
        while($tmp>95);
        
        $msg->response("Tirada total: $suma");        
    }
}