<?php

namespace Robots;

class Greeting
{
    function greeting($test,$msg)
    {
        $msg->chat->sendMessage("Hello!");
    }
}