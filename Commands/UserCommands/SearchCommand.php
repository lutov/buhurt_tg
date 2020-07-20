<?php
/**
 * Created by PhpStorm.
 * User: lutov
 * Date: 02.01.2018
 * Time: 13:03
 */

namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\DebugHelper;
use Longman\TelegramBot\Entities\Keyboard;
use Longman\TelegramBot\Request;

use Longman\TelegramBot\TelegramHelper;

use Longman\TelegramBot\BuhurtAPI;

class SearchCommand extends UserCommand {

	protected $name = 'search';
	protected $description = 'Search for item by substring';
	protected $usage = '/search';
	protected $version = '1.0.0';

	public function execute() {

		$message = $this->getMessage();
		$chat_id = $message->getChat()->getId();
		$from = $message->getFrom();

		$user_id = $from->getId();
		$user_first_name = $from->getFirstName();
		$user_last_name = $from->getLastName();

		$input_text	= trim($message->getText(true));
		$output_text = '';

		$buhurt = new BuhurtAPI();

		/*
		$data = [
			'chat_id' => $chat_id,
			'text' => DebugHelper::dump($buhurt->search($input_text, true)),
		];
		return Request::sendMessage($data);
		*/

		$list = $buhurt->search($input_text);

		if(count($list)) {
			foreach($list as $key => $value) {

				$output_text .= '<b>'.$key.'</b>';
				$output_text .= "\n";

				foreach($value as $el_key => $element) {
					$output_text .= '<a href="' . $element->link . '">' . $element->name . '</a>';
					$output_text .= "\n";
				}

				$output_text .= "\n";

			}
		} else {
			$output_text .= "Nothing found. Try be less specific";
		}

		$data = [
			'chat_id' => $chat_id,
			'text' => $output_text,
			'parse_mode' => 'HTML',
		];
		return Request::sendMessage($data);

	}

}