<?php
require(__DIR__.'/../lib/Util.php');

use App\ShellApp;
use Exceptions\BadRequest;
use Exceptions\CustomException;

class setupDB extends ShellApp
{  
    function registerWebHook($bot,$url)
    {
        $content = http_build_query( ["url"=>$url] );
        $curl = curl_init("https://api.telegram.org/bot$bot/setWebhook");
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/x-www-form-urlencodedjson"));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
        $response = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        error_log($response);

        if($status==200)
        {
            $cfg = fopen(__DIR__."/cfg.php","w");
            if($cfg)
            {
                throw new CustomException("Cannot open file ".__DIR__."/cfg.php");
            }

            fwrite($cfg,"<?php\n");
            fwrite($cfg,"define('PROJECT','MyBOT')\n");
            fwrite($cfg,"define('TAG','$bot');\n"); 
            fwrite($cfg,"define('BOTURL','$url');\n"); 
            fclose($cfg);
        }
    }

    function askAll()
    {
        $stdin = fopen( 'php://stdin', 'r' );
        if(!$stdin)
        {
            throw new CustomException("Cannot open STDIN");            
        }
        
        do
        {
            $bot=readline("\nInput BOT Id: ");
            $url=readline("\nInput URL: ");

            echo "\n";
            echo "BOT: $bot\n";
            echo "URL: $url\n";
            $res = strtolower(readline("Its ok? [y/N/c] "));
        }
        while($res!='c' && $res!='y');

        if($res=='c')
            return 1;

        return $this->registerWebHook($bot,$url);        
    }

    function main()
    {     
        if(isset($this->args["initial"]))
        {
            return $this->askAll();
        }
        



        /*
        $db=new Database("mysql:host=localhost;",$usr,$pwd);
        $db->execute("DROP DATABASE IF EXISTS ".PROJECT);
        $db->execute("CREATE DATABASE ".PROJECT." CHARSET=utf-8");
        $db->execute("GRANT DELETE,UPDATE,INSERT,SELECT ON ".PROJECT.".* TO $usr@localhost IDENTIFIED BY '$pwd2' WITH GRANT OPTION");
        */

    }
}

$tmp = new setupDB();
$tmp->run();