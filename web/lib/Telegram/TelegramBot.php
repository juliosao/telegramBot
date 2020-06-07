<?php

namespace Telegram;

class TelegramBot
{
    function __construct($tag)
    {
        $this->tag=$tag;
        $this->url='https://api.telegram.org/bot'.$tag;
    }

    function __toString()
    {
        return $this->tag;
    }

    function execMethod($method,$data)
    {
        $content = http_build_query( $data );
        $curl = curl_init($this->url.'/'.$method);

        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/x-www-form-urlencodedjson"));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
        $response = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        return True;
    }

    function read()
    {
        $strRequest = file_get_contents('php://input');
        $request = json_decode($strRequest);
        
        if(isset($request->message))
		{
            return new TelegramMessage($this, $request->message);            
		}

        return null;        
    }

    function sendTextMessage($chat, $txt)
    {
        $data = $msg=array('chat_id'=>$chat, 'text'=>$txt);
        return $this->execMethod('sendMessage',$data);
    }
}