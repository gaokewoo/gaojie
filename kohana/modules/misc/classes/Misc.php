<?php
class Misc {
	static public function encrypt($text, $key = '') {
		$ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $text, MCRYPT_MODE_ECB);
		$ciphertext = trim(base64_encode($ciphertext));
		return $ciphertext;
	}

	static public function decrypt($text, $key = '') {
		$ciphertext = base64_decode($text);
		$cleartext = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $ciphertext, MCRYPT_MODE_ECB));
		return $cleartext;
	}

	static public function jsonError($errors = NULL, $redirect = NULL, array $data = array()) {
		if(!is_array($errors)) {
			$errors = array($errors);
		}
		$response = array (
			'code' => 0,
			'messages' => $errors,
			'redirect' => $redirect,
			'data' => $data
		);
		echo json_encode($response, TRUE);
		exit();
	}

	static public function jsonSuccess($messages = NULL, $redirect = NULL, array $data = array()) {
		if(!is_array($messages)) {
			$messages = array($messages);
		}
		$response = array (
			'code' => 1,
			'messages' => $messages,
			'redirect' => $redirect,
			'data' => $data
		);
		echo json_encode($response, TRUE);
		exit();
	}

	static public function message($message, $redirect = NULL, $delay = 3) {
		echo View::factory('misc/message')
			->set('message', $message)
			->set('redirect', $redirect)
			->set('delay', $delay);
		exit();
	}

	static public function warning($message) {
		echo View::factory('misc/warning')
			->set('message', $message);
		exit();
	}

	/**
	 * 返回上一步操作
	 * @param $message
	 */
	static public function errorReturn($message) {
		echo View::factory('misc/error')
				->set('message', $message);
		exit();
	}


	static public function toUTF8($string = array(), $fromEncoding = 'GBK') {
		if(is_array($string)) {
			foreach($string as &$value) {
				self::toUTF8($value);
			}
		} else {
			$string = mb_convert_encoding($string, 'UTF8', $fromEncoding);
		}

		return $string;
	}

	/**
	 * 汉字转拼音
	 * @param string $word
	 * @return string
	 */
	static public function pinyin($word = '') {

		$length = strlen($word);
		if($length < 3) {
			return $word;
		}

		static $dictionary = array();
		if(!$dictionary) {
			$dictionary = Kohana::$config->load('pinyin')->as_array();
		}

		$pinyins = array();
		$nonchinese = '';
		for($i = 0; $i < $length; $i++) {
			$ascii = ord($word[$i]);
			if($ascii < 128) {
				if($ascii >= 65 && $ascii <= 90) {
					$nonchinese .= strtolower($word[$i]);
				} else {
					$nonchinese .= $word[$i];
				}
			} else {
				if($nonchinese) {
					$pinyins[] = $nonchinese;
					$nonchinese = '';
				}
				$character = $word[$i];
				$character .= isset($word[++$i]) ? $word[$i] : '';
				$character .= isset($word[++$i]) ? $word[$i] : '';
				$pinyins[] = isset($dictionary[$character]) ? $dictionary[$character] : '';
			}
		}
		if($nonchinese) {
			$pinyins[] = $nonchinese;
			$nonchinese = '';
		}
		return implode(' ', $pinyins);
	}

	//获取客户端IP
	static public function getClientIp() {
		$ip = 0;
		if( isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR']){
			 $forwarded = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
			 $ip = array_shift($forwarded);
		}
		else if ( isset($_SERVER['HTTP_CLIENT_IP']) &&  $_SERVER['HTTP_CLIENT_IP'] ){
			 $ip = $_SERVER['HTTP_CLIENT_IP'];
		}
		else{
			 if (!empty($_SERVER['REMOTE_ADDR'])) {
				  $ip = $_SERVER['REMOTE_ADDR'];
			 }
		}
		return $ip;
	}

	//判断是否移动端访问
	static public function isMobile() {
		if(!isset($_SERVER['HTTP_USER_AGENT'])) return false;
		$userAgent = $_SERVER['HTTP_USER_AGENT'];
		$isMobile = false;
		$isMobile = (preg_match("/AppleWebKit.*Mobile.*/", $userAgent)) ? true : $isMobile;
		$isMobile = (preg_match("/\(i[^;]+;( U;)? CPU.+Mac OS X/", $userAgent)) ? true : $isMobile;
		$isMobile = (strpos($userAgent, 'Android') || strpos($userAgent, 'Linux')) ? true : $isMobile;
		$isMobile = (strpos($userAgent, 'iPhone')) ? true : $isMobile;
		$isMobile = (strpos($userAgent, 'iPad')) ? true : $isMobile;

		return $isMobile;
	}

	/*
	 * curl get方法
	 * @url string 请求地址
	 * @getValues array 请求参数
	 * @timeout int 超时时间 默认1秒
	 */
	static public function curlGet($url, $getValues = array(), $timeout = 1) {
		if(!$url) {
			return false;
		}
		if($getValues) {
			$url = $url . "?" . http_build_query($getValues);
		}
		$handler = curl_init();
		curl_setopt($handler, CURLOPT_URL, $url);
		curl_setopt($handler, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		curl_setopt($handler, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($handler, CURLOPT_TIMEOUT, $timeout); // 设置超时时间为1秒
		$response = curl_exec($handler);
		curl_close($handler);
		return $response;
	}

	/*
	 * curl POST方法
	 * @url string 请求地址
	 * @getValues array 请求参数
	 * @timeout int 超时时间 默认1秒
	 */
	static public function curlPost($url, $postValues = array(), $timeout = 1, $referer = false) {
		if(!$url) {
			return false;
		}
		$handler = curl_init();
		curl_setopt($handler, CURLOPT_URL, $url);
		curl_setopt($handler, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		curl_setopt($handler, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($handler, CURLOPT_POST, TRUE);
		if($referer) {
			curl_setopt($handler, CURLOPT_REFERER, $referer);
		}
		curl_setopt($handler, CURLOPT_POSTFIELDS, http_build_query($postValues));
		curl_setopt($handler, CURLOPT_TIMEOUT, $timeout);
		$response = curl_exec($handler);
		curl_close($handler);
		return $response;
	}
}
