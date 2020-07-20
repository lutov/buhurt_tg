<?php
/**
 * Created by PhpStorm.
 * User: lutov
 * Date: 02.01.2018
 * Time: 12:21
 */

namespace Longman\TelegramBot;

use Longman\TelegramBot\RequestHelper;

class BuhurtAPI {

	private $site = 'https://buhurt.ru/';

	protected $search_url = '';
	protected $random_url = '';

	public function __construct() {

		$this->search_url = $this->site.'api/search/';
		$this->random_url = $this->site.'api/random/';

	}

	/**
	 * @param string $query
	 * @param bool $debug
	 * @return array
	 */
	public function search(string $query = '', bool $debug = false) {

		$result = array();

		if(!empty($query)) {

			$params = array(
				'query' => $query,
			);
			$result = RequestHelper::makeRequest($this->search_url, $params, $debug);

		}

		return $result;

	}

	/**
	 * @param string $section
	 * @param bool $debug
	 * @return array|\stdClass
	 */
	public function random(string $section = '', bool $debug = false) {

		$result = new \stdClass;

		if(!empty($section)) {
			$result = RequestHelper::getResult($this->random_url.$section, $debug);
		}

		return $result;

	}

	/**
	 * @param \stdClass $data
	 * @param string $section
	 * @return string
	 */
	public function render(\stdClass $data, string $section = '') {

		$result = '';

		if(!empty($section)) {

			if('books' == $section) {

				$result .= '<a href="'.$data->cover.'">'."\t".'</a>';
				$result .= '<a href="'.$data->link.'">'.$data->name.'</a>';
				if(!empty($data->alt_name)) {
					$result .= ' (';
					$result .= $data->alt_name;
					$result .= ')';
				}
				if(!empty($data->genres)) {
					$result .= "\n";
					$result .= $data->genres;
				}
				if(!empty($data->year)) {
					$result .= "\n";
					$result .= $data->year;
				}
				if(!empty($data->author)) {
					$result .= ", ";
					$result .= $data->author;
				}
				if(!empty($data->publishers)) {
					$result .= " | ";
					$result .= $data->publishers;
				}
				if(!empty($data->description)) {
					$result .= "\n\n";
					$result .= $data->description;
				}
				if(!empty($data->rating)) {
					$result .= "\n\n";
					$result .= 'Рейтинг: '.$data->rating."\n".$data->votes;
				}
				if(!empty($data->collections)) {
					$result .= "\n\n";
					$result .= 'Коллекции: '.$data->collections;
				}

			} elseif('films' == $section) {

				$result .= '<a href="'.$data->cover.'">'."\t".'</a>';
				$result .= '<a href="'.$data->link.'">'.$data->name.'</a>';
				if(!empty($data->alt_name)) {
					$result .= ' (';
					$result .= $data->alt_name;
					$result .= ')';
				}
				if(!empty($data->genres)) {
					$result .= "\n";
					$result .= $data->genres;
				}
				if(!empty($data->year)) {
					$result .= "\n";
					$result .= $data->year;
				}
				if(!empty($data->country)) {
					$result .= ", ";
					$result .= $data->country;
				}
				if(!empty($data->director)) {
					$result .= "\n\n";
					$result .= 'Режиссёр: '.$data->director;
				}
				if(!empty($data->screenwriter)) {
					$result .= "\n";
					$result .= 'Сценарист: '.$data->screenwriter;
				}
				if(!empty($data->producer)) {
					$result .= "\n";
					$result .= 'Продюсер: '.$data->producer;
				}
				if(!empty($data->description)) {
					$result .= "\n\n";
					$result .= $data->description;
				}
				if(!empty($data->actors)) {
					$result .= "\n\n";
					$result .= 'В ролях: '.$data->actors;
				}
				if(!empty($data->rating)) {
					$result .= "\n\n";
					$result .= 'Рейтинг: '.$data->rating."\n".$data->votes;
				}
				if(!empty($data->collections)) {
					$result .= "\n\n";
					$result .= 'Коллекции: '.$data->collections;
				}

			} elseif('games' == $section) {

				$result .= '<a href="'.$data->cover.'">'."\t".'</a>';
				$result .= '<a href="'.$data->link.'">'.$data->name.'</a>';
				if(!empty($data->alt_name)) {
					$result .= ' (';
					$result .= $data->alt_name;
					$result .= ')';
				}
				if(!empty($data->genres)) {
					$result .= "\n";
					$result .= $data->genres;
				}
				if(!empty($data->year)) {
					$result .= "\n";
					$result .= $data->year;
				}
				if(!empty($data->platforms)) {
					$result .= ", ";
					$result .= $data->platforms;
				}
				if(!empty($data->developer)) {
					$result .= "\n";
					$result .= 'Разработчик: '.$data->developer;
				}
				if(!empty($data->publisher)) {
					$result .= "\n";
					$result .= 'Издатель: '.$data->publisher;
				}
				if(!empty($data->description)) {
					$result .= "\n\n";
					$result .= $data->description;
				}
				if(!empty($data->rating)) {
					$result .= "\n\n";
					$result .= 'Рейтинг: '.$data->rating."\n".$data->votes;
				}
				if(!empty($data->collections)) {
					$result .= "\n\n";
					$result .= 'Коллекции: '.$data->collections;
				}

			} else {

				$result = 'Раздел не выбран';

			}

		}

		$result = str_replace('<br />', '', $result);
		$result = str_replace('&', '&amp;', $result);

		return $result;
	}

}