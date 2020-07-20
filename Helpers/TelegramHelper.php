<?php
/**
 * Created by PhpStorm.
 * User: lutov
 * Date: 02.01.2018
 * Time: 12:35
 */

namespace Longman\TelegramBot;


class TelegramHelper {

	/**
	 * @param array $data
	 * @param int $cols
	 * @param int $i
	 * @param int $row
	 * @return array
	 */
	public static function getKeyboard($data = array(), $cols = 1, $i = 0, $row = 0) {

		$result = array();

		foreach($data as $key => $value) {
			$result[$row][] = array('text' => $value);
			if($cols != $i) {$i++;} else {$row++; $i = 0;}
		}

		return $result;

	}

}