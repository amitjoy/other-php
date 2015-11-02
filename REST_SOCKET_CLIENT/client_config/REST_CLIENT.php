<?php 

class REST_CLIENT {
	
	/**
	 * Define headers
	 */
	const HEADER_ACCEPT = "Accept"; // Accept: text/plain
	const HEADER_ACCEPT_CHARSET = "Accept-Charset"; // Accept-Charset: utf-8
	const HEADER_ACCEPT_ENCODING = "Accept-Encoding"; // Accept-Encoding: <compress | gzip | identity>
	const HEADER_ACCEPT_LANGUAGE = "Accept-Language"; // Accept-Language: en-US
	const HEADER_AUTHORIZATION = "Authorization"; // Basic Authorization: Basic base64(username:password)
	const HEADER_CACHE_CONTROL = "Cache-Control"; // Cache-Control: no-cache
	const HEADER_COOKIE = "Cookie"; // Cookie: $Version=1; Skin=new;
	const HEADER_COOKIEFILE = "Cookie-File"; // Cookie file: only works with curl
	const HEADER_CONTENT_LENGTH = "Content-Length"; // Content-Length: 348
	const HEADER_CONTENT_TYPE = "Content-Type"; // Content-Type: application/x-www-form-urlencoded
	const HEADER_DATE = "Date"; // Accept: Date: Tue, 15 Nov 1994 08:12:31 GMT
	const HEADER_EXPECT = "Expect"; // Expect: 100-continue
	const HEADER_FROM = "Form"; // From: user@email.com
	const HEADER_HOST = "Host"; // Host: en.wikipedia.org
	const HEADER_MAX_FORWARDS = "Max-Forwards"; // Max-Forwards: 10
	const HEADER_PRAGMA = "Pragma"; // Pragma: no-cache
	const HEADER_PROXY_AUTHORIZATION = "Proxy-Authorization"; // Proxy-Authorization: Basic base64(username:password)
	const HEADER_RANGE = "Range"; // Range: bytes=500-999
	const HEADER_REFERER = "Referer"; // Referer: http://en.wikipedia.org/wiki/Main_Page
	const HEADER_USER_AGENT = "User-Agent"; // User-Agent: Mozilla/5.0 (Linux; X11)
	const HEADER_CUSTOMREQUEST = "Request"; // Use to do a custom request. For example to communicate with DirectAdmin API "GET /CMD_API_SHOW_USERS? HTTP/1.0"

	/**
	 * Define method types
	 */
	const METHOD_GET = "GET";
	const METHOD_POST = "POST";
	const METHOD_PUT = "PUT";
	const METHOD_DELETE = "DELETE";
	
	/**
	 * Define content type
	 */
	const CONTENT_PLAIN = "plain";
	const CONTENT_JSON = "json";
	const CONTENT_XML = "xml";
	const CONTENT_PHP = "php";
	const CONTENT_XMLRPC = "xmlrpc";
	const CONTENT_QUERYSTRING = "querystring";
	
	/**
	 * HTTP header curlopt array
	 * @var array
	 */
	private $_header_to_curlopt = array (
		self::HEADER_USER_AGENT => 10018,
		self::HEADER_REFERER => 10016,
		self::HEADER_AUTHORIZATION => 10005,
		self::HEADER_COOKIE => 10022,
		self::HEADER_COOKIEFILE => 10031,
		self::HEADER_CUSTOMREQUEST => 10036
	);
	
	/**
	 * Timeout the request after x seconds
	 * @var int
	 */
	private $_timeout = 5;
	
	/**
	 * The method to use for the request
	 * @var string
	 */
	private $_method = self::METHOD_GET;
	
	/**
	 * The property to hold the data for the request
	 * @var array
	 */
	private $_data = array();
	
	/**
	 * List of errors that happen
	 * @var array
	 */
	protected $errors = array();

	/**
	 * List of response headers
	 * @var array
	 */
	protected $response_headers = array();

	/**
	 * Request headers
	 * @var array
	 */
	protected $request_headers = array();
	
	/**
	 * Use Fopen
	 * @var bool
	 */
	protected $use_fopen = false;
	
	/**
	 * Use certificate
	 * @var string
	 */
	protected $use_certificate = null;
	
	/**
	 * Request method that uses fopen
	 *
	 * @param string $url
	 * @param array $data
	 * @param string $method
	 * @param array $headers
	 * @param int $timeout
	 * @return string
	 */
	private function _requestFopen($url, $data, $method='GET', $headers = null, $timeout=5) {

		$params = array('http' => array(
				'method' => $method,
				'timeout' => $timeout
		));
	  	if ($headers !== null) {
	  		$header_string = '';
	  		foreach($headers as $key => $value){
	  			switch($key) {
	  				case self::HEADER_COOKIE:
	  					if(is_array($value)) {
	  						$value = $this->cookieStringToArray($value);
	  					}
	  					break;
	  			}
	  			if($key == self::HEADER_CUSTOMREQUEST) {
	  				$header_string = $value . "\r\n" . $header_string;
	  			} else {
	  				$header_string .= $key . ': ' . $value . "\r\n";
	  			}
	  		}
			$params['http']['header'] = $header_string;
	  	}
	  	
	  	if($method == self::METHOD_POST && count($data)) {
	  		if(is_array($data)) {
	  			$params['http']['content'] = http_build_query($data, '', '&');
	  		} else {
	  			$params['http']['content'] = $data;
	  		}
	  	}
	  	if($method == self::METHOD_GET && count($data)) {
	  		$separator = strstr($url, '?') ? '&' : '?';
	  		$url .= $separator . http_build_query($data, '', '&');
	  	}

	  	// Do request
	  	$ctx = stream_context_create($params);
	  	$fp = @fopen($url, 'rb', false, $ctx);
	  	
	  	// Make header key value array form header array
	  	$this->response_headers = isset($http_response_header) ? $this->headersToKeyValue($http_response_header) : array();
	  	
	  	if (!$fp) {
	  		$this->errors[] = 'Could not resolve host; No data record of requested type';
			throw new Exception("Problem with $url");
	  	}
	  	
	  	$response = @stream_get_contents($fp);
	  	if (!isset($http_response_header) || $response === false) {
	  		$this->errors[] = 'Bad url or timeout';
			throw new Exception("Problem reading data from $url");
	  	}
	  	return $response;
	}
	
	/**
	 * Request method that uses curl
	 *
	 * @param string $url
	 * @param array $data
	 * @param string $method
	 * @param array $headers
	 * @param int $timeout
	 * @return string
	 */
	private function _requestCurl($url, $data, $method='GET', $headers=array(), $timeout=5) {

		$ch = curl_init();

		// Convert headers to curlopts
		$headers_new = array();
		foreach($headers as $key => $value){
			if(isset($this->_header_to_curlopt[$key])){
				switch($key) {
					case self::HEADER_AUTHORIZATION:
						if(strstr($value, 'Basic')) {
							$value = base64_decode(trim(str_replace('Basic ', '', $value)));
						}
						break;
	  				case self::HEADER_COOKIE:
	  					if(is_array($value)) {
	  						$value = $this->cookieStringToArray($value);
	  					}
	  					break;
	  			}
				curl_setopt($ch, $this->_header_to_curlopt[$key], $value);
				unset($this->request_headers[$key]);
			}else{
				$headers_new[] = $key . ': ' . $value;
			}
		}
		$headers = $headers_new;

		// Add length header if it is not set
		if(!isset($headers[self::HEADER_CONTENT_LENGTH])){
			if(is_array($data)) {
				$headers[self::HEADER_CONTENT_LENGTH] = strlen(http_build_query($data, '', '&'));
			} else {
				$headers[self::HEADER_CONTENT_LENGTH] = strlen($data);
			}
		}

		// Set headers
		if(count($headers)){
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		}
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);		// Don't output content
		curl_setopt($ch ,CURLOPT_TIMEOUT, $timeout); 		// Timeout
		###########PROXY################
		curl_setopt($ch, CURLOPT_PROXY, "172.16.1.11:3128");
		###########END###########################
		switch($method){
			case self::METHOD_POST:
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
				break;
			case self::METHOD_GET:
				if(count($this->_data)) {
					$separator = strstr($url, '?') ? '&' : '?';
	  				$url .= $separator . http_build_query($this->_data, '', '&');
				}
				break;
			default:
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method); 
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
				break;
		}

		curl_setopt($ch, CURLOPT_FAILONERROR, true);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, true);
		
		// Use SSL
		if(strtolower(substr($url, 0, 5)) == 'https') {
			if(!isset($this->use_certificate)) {
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			} else {
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
				curl_setopt($ch, CURLOPT_CAINFO, $this->use_certificate);
			}
		}
		
		$result = curl_exec($ch);
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE); 

		// Separate content and headers
		$result = str_replace("\r\n\r\nHTTP/", "\r\nHTTP/", $result);
		$parts = explode("\r\n\r\n",$result);
		$headers = array_shift($parts);
		$result = implode("\r\n\r\n", $parts);

		// Make header array from headers string
		$this->response_headers = isset($headers) && !empty($headers) ? $this->headersToKeyValue(explode("\r\n", $headers)) : array();

		// Throw exception if status is not 200 or 304
		// or result is false
		if(!in_array($status, array(200, 304)) || $result === false) {
			$this->errors[] = curl_error($ch);
			throw new Exception("Problem reading data from $url");
		}
		
		return $result;
	}
	
	/**
	 * Convert header array to key value headers array
	 * 
	 * @param array $headers
	 * @return array
	 */
	protected function headersToKeyValue($headers) {
		$kvarray = array();
		foreach($headers as $header) {
			if(count($kvarray) == 0) {
				$kvarray['Http'] = $header; 
			} else {
				$splitpoint = strpos($header, ':');
				$key = substr($header, 0, $splitpoint);
				$value = trim(substr($header, $splitpoint+1));
				$kvarray[$key] = $value;
			}
		}
		return $kvarray;
	}
	
	/**
	 * Convert key value headers to headers array
	 * 
	 * @param array $headers
	 * @reutrn array
	 */
	protected function keyValueToHeaders($headers) {
		$headers_array = array();
		foreach($headers as $key => $value) {
			$headers_array[] = $key . ': ' . $value;
		}
		return $headers_array;
	}

	/**
	 * Convert array to cookie string
	 * 
	 * @param array $cookies
	 * @return string
	 */
	protected function cookieStringToArray($cookies) {
		$string = '';
		foreach($cookies as $key => $value) {
			$string .= $key . '=' . $value . '; ';
		}
		return $string;
	}
	
	
	/**
	 * Set the request timeout in seconds
	 *
	 * @param int $value
	 * @return void
	 */
	public function setTimeout($value) {
		if(!is_numeric($value)) trigger_error("Timeout must be a number!", E_NOTICE);
		$this->_timeout = $value;
	}
	
	/**
	 * Set the request timeout in seconds
	 *
	 * @param int $value
	 * @return void
	 */
	public function getTimeout() {
		return $this->_timeout;
	}
	
	/**
	 * Set request method
	 *
	 * @param string $type
	 * @return void
	 */
	public function setMethod($type) {
		$this->_method = $type;	
	}
	
	/**
	 * Add request headers
	 * 
	 * @param string $key
	 * @param string $value
	 * @return void
	 */
	public function addHeader($key, $value) {
		$this->request_headers[$key] = $value;
	}
	
	/**
	 * Set params to add to the request
	 *
	 * @param array $params
	 * @return void
	 */
	public function setParams($params) {
		$this->_data = $params;
	}
	
	/**
	 * Set data if you don't want to use params
	 * 
	 * @param string $data
	 * @return void
	 */
	public function setData($data) {
		$this->_data = $data;
	}
	
	/**
	 * Add a param to the request
	 * 
	 * @param string $key
	 * @param string $value
	 * @return void
	 */
	public function addParam($key, $value) {
		$this->_data[$key] = $value;
	}
	
	/**
	 * Use fopen instead of curl
	 * 
	 * @param bool $state
	 * @return void
	 */
	public function useFopen($state=true) {
		$this->use_fopen = $state;
	}
	
	/**
	 * Use a specific certificate for my SSL requests
	 * 
	 * @param string $certificate
	 * @return void
	 */
	public function useCertificate($certificate) {
		$this->use_certificate = $certificate;
	}
	
	/**
	 * Get array of response headers
	 * 
	 * @return array
	 */
	public function getResponseHeaders() {
		return $this->response_headers;
	}
	
	/**
	 * Execute request
	 *
	 * @param string $return_type
	 * @return *
	 */
	 public function request($url, $return_type=self::CONTENT_PLAIN) {

		 // Use fopen if curl is not installed or force fopen is set
		 if($this->use_fopen || !function_exists('curl_init')) {
			 $result = $this->_requestFopen($url, $this->_data, $this->_method, $this->request_headers, $this->_timeout);
		 } else {
			 $result = $this->_requestCurl($url, $this->_data, $this->_method, $this->request_headers, $this->_timeout);
		 }
		 
		 // Content decoder
		 switch($return_type) {
			 case self::CONTENT_JSON:
			 	return json_decode($result);
			case self::CONTENT_PHP:
				return unserialize($result);
			case self::CONTENT_XML:
				return simplexml_load_string($result);
			case self::CONTENT_XMLRPC:
				return xmlrpc_decode($result);
			case self::CONTENT_QUERYSTRING:
				parse_str($result, $return);
				return $return;
			default:
				return $result;
		 }
		 
	 }
	 
	 /**
	  * Possible to get result after a exception
	  * 
	  * @return array
	  */
	 public function getErrors() {
	 	return $this->errors;
	 }
	 
	 /**
	  * Reset the API Client
	  * - Set the request method to GET
	  * - Remove all headers
	  * - Remove all options
	  * 
	  * @param bool $reset_method	If set to true the request method is not reset
	  * @param bool $reset_request_headers	This can be skipped. Can be handy when you have a headers that needs to be sent with every request. For example an API token.
	  * @return void
	  */
	 public function reset($reset_method=true, $reset_request_headers=true) {
	 	if($reset_method) $this->_method = self::METHOD_GET;
	 	if($reset_request_headers) $this->request_headers = array();
	 	$this->response_headers = array();
	 	$this->_data = array();
	 	$this->errors = array();
	 }
	
}