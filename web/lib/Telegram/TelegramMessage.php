<?php

namespace Telegram;

class TelegramMessage extends TelegramObject
{
    function __construct(TelegramBot $bot, $src)
    {
        parent::__construct($bot);

        $this->text = $src->text;
        $this->sender = new TelegramUser($bot, $src->from);
        $this->chat = new TelegramChat($bot, $src->chat);
  
        $this->flags = array();
        foreach($src->entities as $entity)
        {
            $this->flags[] = $entity->type;
        }
    }

    function __toString()
    {
        return $this->text;
    }
}