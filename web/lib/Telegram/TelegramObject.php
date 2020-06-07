<?php

namespace Telegram;

class TelegramObject
{
    protected $bot;
    
    public function __construct($bot)
    {
        $this->bot = $bot;    
    }
}