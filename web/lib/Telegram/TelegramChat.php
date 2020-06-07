<?php

namespace Telegram;

class TelegramChat extends TelegramObject
{  
    public $id;
    public $lastMsg;
    public $admin;

    function __construct(TelegramBot $bot, $src)
    {        
        parent::__construct($bot);
        $this->id=$src->id;
    }

    function sendMessage($msg)
    {
        if($msg instanceof TelegramMessage)
            return $this->bot->sendTextMessage($this->id, $msg->text);
        else
            return $this->bot->sendTextMessage($this->id, $msg);
    }
}
