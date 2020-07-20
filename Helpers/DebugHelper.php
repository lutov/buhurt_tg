<?php
/**
 * Created by PhpStorm.
 * User: lutov
 * Date: 02.01.2018
 * Time: 12:35
 */

namespace Longman\TelegramBot;


class DebugHelper {

	/**
	 * @param array $variable
	 * @param bool $pre
	 * @return string
	 */
	public static function dump($variable = array(), $pre = false) {

		$result = "\n";

		if($pre) {$result .= '<pre>';}

		$result .= print_r($variable, true);

		if($pre) {$result .= '</pre>';}

		return $result;

	}

}