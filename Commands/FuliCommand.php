<?php
/**
 * This file is part of the TelegramBot package.
 *
 * (c) Jimes Yang aka sndnvaps <sndnvaps@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Longman\TelegramBot\Commands;
use Longman\TelegramBot\Command;
use Longman\TelegramBot\Request;
/**
 * User "/fuli" command
 */
class FuliCommand extends Command
{
    /**#@+
     * {@inheritdoc}
     */
    protected $name = 'fuli';
    protected $description = 'search for fuli magnet';
    protected $usage = '/fuli <CarNo.> ';
    protected $version = '1.0.1';
    protected $public = true;

     //set time zone

private function SearchCode($code) {
	$bthave = 'http://www.btmeet.org/search/';
	$new_code = '';
	$html_url = '';
	$reg_str = "/magnet[^ <'\"]*/i";

	$magnet_result = array();
	$html_url = $bthave . $code;
	//get the contents from website 
	$html = file_get_contents($html_url);

	if(preg_match_all($reg_str,$html,$matches_t)) {
		echo "";
	} else {
		echo "Not found! Try another code";
	}

	//split the result from array( $v => $k { array($vv)} => array{$v};
	foreach ($matches_t as $k => $v ) {
		if(is_array($v)) {
			foreach($v as $magnet_v) {
				array_push($magnet_result,$magnet_v);
			}
  		}
	}

	if(is_array($magnet_result)) {
		return $magnet_result[mt_rand(2, count($magnet_result)-1)];
	}

	return "Not found! Try another code";
}


// 
    /**#@-*/
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
	$message = $this->getMessage();
        $message_id = $message->getMessageId();
	$chat_id = $message->getChat()->getId();
	$text = $message->getText(true);
	if(empty($text)) {
		$text = 'Gave me you code! Old driver:
				command: /fuli <code>
			';
	} else {
	$magnet = $this->SearchCode($text);
	$text = $magnet;	
        }

	$data = [
            'chat_id' => $chat_id,
	    'disable_notification' => false,
            'reply_to_message_id' => $message_id,   
	    'text'    => $text,
        ];
        return Request::sendMessage($data);
    }
}
