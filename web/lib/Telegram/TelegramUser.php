<?php

namespace Telegram;

class TelegramUser extends TelegramObject
{     
    public $id;
    public $firstName;
    public $lastName;
    public $userName;   

    function __construct($bot, $src)
    {
        parent::__construct($bot);

        $this->id = $src->id;
        $this->firstName = $src->first_name;
        $this->lastName = $src->last_name;
        $this->userName = $src->username;
    }
}
