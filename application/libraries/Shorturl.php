<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Shorturl {
	
	protected static $chars = "123456789bcdfghjkmnpqrstvwxyzBCDFGHJKLMNPQRSTVWXYZ";
	protected static $checkUrlExists = true;
	protected $_ci;
	
	public function __construct()
	{
		$this->_ci =& get_instance();
		$this->_ci->load->model('shorturl_model');
	}
	
	public function urlToShortCode($url = array())
	{
		if (empty($url)) 
		{
			throw new \Exception("No URL was supplied");
		}
		
		if ($this->validateUrlFormat($url['long_url']) == false)
		{
			throw new \Exception("URL does not have a valid format");
		}
		
		if (self::$checkUrlExists)
		{
			if (!$this->verifyUrlExists($url['long_url'])) 
			{
				throw new \Exception("URL does not appear to exist");
			}
		}
		
		$shortCode = $this->urlExistsInDb($url);
		
		if($shortCode == false)
		{
			$shortCode = $this->createShortCode($url);
		}
		
		return $shortCode;
	}
	
	public function shortCodeToUrl($code, $increment = true)
	{
		if (empty($code))
		{
			throw new \Exception("No short code was supplied");
		}
		
		if ($this->validateShortCode($code) == false)
		{
			throw new \Exception("Short code does not have a valid format");
		}
		
		$urlRow = $this->getUrlFromDb($code);
		
		if (empty($urlRow))
		{
			throw new \Exception("Short code does not appear to exist");
		}
		
		if ($increment == true)
		{
			$this->incrementCounter($urlRow["id"]);
		}
		
		return $urlRow["long_url"];
	}
	
	protected function validateUrlFormat($url)
	{
		return filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED);
	}
	
	protected function verifyUrlExists($url)
	{
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_NOBODY, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_exec($ch);
		
		$response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		
		return(!empty($response) && $response !=404);
	}
	
	protected function urlExistsInDb($url)
	{
		$params = $url;
		
		$result = $this->_ci->shorturl_model->find($params);
		
		if(!empty($result))
			$arr = array("url_id" => $result->id, "shortcode" => $result->short_code);
		
		return (empty($result)) ? false : $arr;
	}
	
	protected function createShortCode($url)
	{
		$params = $url;
		$id = $this->_ci->shorturl_model->insert($params);
		
		$shortCode = $this->convertIntToShortCode($id);
		//die($shortCode);
		$this->insertShortCodeInDb($id, $shortCode);
		
		$arr = array("url_id" => $id, "shortcode" => $shortCode);
		
		return $arr;
	}
	
	protected function convertIntToShortCode($id)
	{
		$id = intval($id);
		
		if ($id < 1)
		{
			throw new \Exception("The ID is not a valid integer");
		}
		
		$length = strlen(self::$chars);
		
		if ($length < 10)
		{
			throw new \Exception("Length of chars is too small");
		}
		
		$code = "";
		
/*
		while ($id > $length - 1)
		{
			$code = self::$chars[fmod($id, $length)].$code;
			die("while ".$code);
			$id = floor($id / $length);
		}
		
		$code = self::$chars[$id].$code;
*/
		$code = substr( md5( time().uniqid().rand() ), 0, 6 );
		
		return $code;
	}
	
	protected function insertShortCodeInDb($id, $code)
	{
		if ($id == null || $code == null)
		{
			throw new \Exception("Input parameter(s) invalid");
		}
		
		$row = $this->_ci->shorturl_model->update($id, array("short_code" => $code));
		
		if ($row == FALSE)
		{
			throw new \Exception("Row was not updated with short code");
		}
		
		return true;
	}
	
	protected function validateShortCode($code)
	{
		return preg_match("|[". self::$chars ."]+|", $code);
	}
	
	protected function getUrlFromDb($code)
	{
		$params = array("short_code" => $code);
		
		$result = $this->_ci->shorturl_model->find($params);
		
		return $result;
	}
	
}