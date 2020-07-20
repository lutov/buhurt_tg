<?php
/**
 * Created by PhpStorm.
 * User: lutov
 * Date: 02.01.2018
 * Time: 12:35
 */

namespace Longman\TelegramBot;


class RequestHelper {

	/**
	 * @param string $url
	 * @param bool $debug
	 * @return array
	 */
	public static function getResult($url = '', $debug = false) {

		$result = array();

		if(!empty($url)) {

			$json_result = file_get_contents($url);
			if($debug) {
				$result['debug']['url'] = $url;
				$result['debug']['result'] = $json_result;
			} else {
				$result = json_decode($json_result);
			}

		}

		return $result;

	}

	/**
	 * @param string $url
	 * @param array $params
	 * @param bool $debug
	 * @return array|mixed
	 */
	public static function makeRequest($url = '', $params = array(), $debug = false) {

		$result = array();

		if(!empty($url)) {

			$query = http_build_query($params);
			if($debug) {$result['debug']['query'] = $query;}

			$path = $url.'?'.$query;
			if($debug) {$result['debug']['path'] = $path;}

			$query_result = RequestHelper::getResult($path, $debug);
			if(!$debug) {$result = $query_result;}

		}

		return $result;

	}

}