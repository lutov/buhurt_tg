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

class RandomCommand extends UserCommand {

	protected $name = 'random';
	protected $description = 'Get random item from selected section';
	protected $usage = '/random';
	protected $version = '1.0.0';

	public function execute() {

		$message = $this->getMessage();
		$chat_id = $message->getChat()->getId();
		$from = $message->getFrom();

		$user_id = $from->getId();
		$user_first_name = $from->getFirstName();
		$user_last_name = $from->getLastName();

		$input_text	= trim($message->getText(true));
		$output_text = 'Omigosh, it\'s so random!';

		$buhurt = new BuhurtAPI();

		$options = array(
			'Книга' => 'books',
			'Фильм' => 'films',
			'Игра' => 'games',
		);

		$section = (isset($options[$input_text])) ? $options[$input_text] : false;

		if($section) {

			$element = $buhurt->random($section);

			/*
			$output_text = 'response '.DebugHelper::dump($element);
			$data = [
				'chat_id' => $chat_id,
				'text' => $output_text,
			];
			Request::sendMessage($data);
			die();
			*/

			if(isset($element->name)) {

				$output_text = $buhurt->render($element, $section);

				/*
				$caption = '';

				Request::sendPhoto([
					'chat_id' => $chat_id,
					'photo'  => $element->cover,
					'caption' => $caption,
				]);
				return Request::emptyResponse();
				*/

				$data = [
					'chat_id' => $chat_id,
					'text' => $output_text,
					'parse_mode' => 'HTML',
				];
				return Request::sendMessage($data);

			} else {

				return $this->telegram->executeCommand("random");

			}

		} else {

			$buttons = TelegramHelper::getKeyboard(array_keys($options), 0);
			$keyboard = new Keyboard(...$buttons);
			$keyboard = $keyboard
				->setResizeKeyboard(true)
				//->setOneTimeKeyboard(true)
				->setSelective(false);

			$data = [
				'chat_id' => $chat_id,
				'text' => $output_text,
				'reply_markup' => $keyboard,
			];

			return Request::sendMessage($data);

		}

	}

}