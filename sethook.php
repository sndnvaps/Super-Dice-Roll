<?php
//Composer Loader
$loader = require __DIR__.'/vendor/autoload.php';

$API_KEY = 'you_api_token';
// botname cann't contain with '@'
$BOT_NAME = 'bot_name';
$hook_url = 'https://www.youdomain.com/path/to/webhook.php';
// you should put certificate under ./cert folder 
// the server.crt should sign the nginx as same
//
#$certificate_file = __DIR__.'/cert/server.crt';
try {
    // create Telegram API object
    $telegram = new Longman\TelegramBot\Telegram($API_KEY, $BOT_NAME);
    // set webhook

    $result = $telegram->setWebHook($hook_url);
    //$result = $telegram->setWebHook($hook_url, $certificate_path);
    if ($result->isOk()) {
        echo $result->getDescription();
    }
} catch (Longman\TelegramBot\Exception\TelegramException $e) {
    echo $e;
}
