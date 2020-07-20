<?php
/**
 * This file is part of the TelegramBot package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Longman\TelegramBot\Commands\SystemCommands;

use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Conversation;
use Longman\TelegramBot\Request;

/**
 * Generic message command
 *
 * Gets executed when any type of message is sent.
 */
class GenericmessageCommand extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = 'genericmessage';

    /**
     * @var string
     */
    protected $description = 'Handle generic message';

    /**
     * @var string
     */
    protected $version = '1.1.0';

    /**
     * @var bool
     */
    protected $need_mysql = true;

    /**
     * Command execute method if MySQL is required but not available
     *
     * @return \Longman\TelegramBot\Entities\ServerResponse
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    public function executeNoDb()
    {
        // Do nothing
        return Request::emptyResponse();
    }

    /**
     * Command execute method
     *
     * @return \Longman\TelegramBot\Entities\ServerResponse
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    public function execute() {

		//If a conversation is busy, execute the conversation command after handling the message
		$conversation = new Conversation(
			$this->getMessage()->getFrom()->getId(),
			$this->getMessage()->getChat()->getId()
		);

		//Fetch conversation command if it exists and execute it
		/*
		if ($conversation->exists() && ($command = $conversation->getCommand())) {
			return $this->telegram->executeCommand($command);
		}
		*/

		$message = $this->getMessage();
		$chat_id = $message->getChat()->getId();
		$from = $message->getFrom();

		$user_id = $from->getId();
		$user_first_name = $from->getFirstName();
		$user_last_name = $from->getLastName();

		$input_text	= trim($message->getText(true));

		$random_options = array(
			'Книга' => 'books',
			'Фильм' => 'films',
			'Игра' => 'games',
		);

		$section = (isset($random_options[$input_text])) ? $random_options[$input_text] : false;

		if($section) {

			/*
			$output_text = 'is section';
			$data = [
				'chat_id' => $chat_id,
				'text' => $output_text,
			];
			Request::sendMessage($data);
			*/

			return $this->telegram->executeCommand("random");

		} else {

			/*
			$output_text = 'is not a section: '.$input_text;
			$data = [
				'chat_id' => $chat_id,
				'text' => $output_text,
			];
			Request::sendMessage($data);
			*/

			return $this->telegram->executeCommand("search");

			//return Request::emptyResponse();

		}

    }
}
