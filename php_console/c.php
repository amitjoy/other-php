<?php
 
	require 'config.php';
	require 'auth.php';
	
	class Shell {
		public $Home, $Directory;
		
		public function __construct($home) {
			$this->Home = $home;
		}
		
		/**
		* Change to a new directory.
		*
		* @param string $dir: new directory
		* @return null
		*/
		public function ChangeWorkingDirectory($dir) {
			if($dir == '~')
				$dir = &$this->Home;
			
			return @chdir($dir);
		}
		
		/**
		* Execute a command on the system.
		*
		* @param string $command: command to execute
		* @return string: HTML response
		*/
		public function Command($command) {
			global $config;
			
			// initalize path
			self::Path();
			
			foreach($config['aliases'] as $alias => $cmd) {
				$command = preg_replace('/\b' . preg_quote($alias, '/') . '\b/', $cmd, $command);
			}
			
			// execute command
			system($command . ' > ' . escapeshellarg($temp = self::Temp()) . ' 2>&1 && echo "PHP Console Dir: $(pwd)" >> ' . escapeshellarg($temp));
			
			// get contents
			$response = file_get_contents($temp);
			
			// delete temporary file
			unlink($temp);
			
			// strip whitespace
			$response = trim($response);
			
			$lines = explode("\n", $response);
			
			if(preg_match('/^PHP Console Dir: (.+)$/', $lines[count($lines) - 1], $matches)) {
				$this->Directory = $matches[1];
				if($this->Directory == $this->Home)
					$this->Directory = '~';
				
				unset($lines[count($lines) - 1]);
			} else {
				// something went wrong. probably a broken command.
				$this->Directory = false;
			}
			
			$response = implode("\n", $lines);
			
			// convert response to HTML
			$response = self::HTML($response);
			
			return $response;
		}
		
		/**
		* Convert terminal colours to HTML
		*
		* @return string $response: command response
		* @return string
		*/
		static function HTML($response) {
			global $config;
			
			// convert charcters to HTML entities
			$response = htmlentities($response);
			// fix whitespace
			$response = str_replace(" ", '&nbsp;', $response);
			
			$response = preg_replace('/\x1B\[[K]/', '', $response);
			
			preg_match_all('/\x1B\[((\d+);)?(\d+)?m/', $response, $matches);
			
			$_response = $response;
			$newresponse = '';
			
			$open_tags = Array();
			$offset = 0;
			
			for($i=0; $i < count($matches[0]); $i++) {
				$first = (int)$matches[2][$i];
				$second = (int)$matches[3][$i];
				
				if(!$first) {
					$first = $second;
				}
				
				$open = Array();
				$close = Array();
				$color = false;
				$background = false;
				$html = '';
				
				// here it gets a little messy...
				
				if($first) {
					switch($first) {
						case 0:
							if(in_array('strong', $open_tags))
								$close[] = 'strong';
							if(in_array('u', $open_tags))
								$close[] = 'u';
							break;
						case 1:
							$open[] = 'strong';
							break;
						case 4:
							$open[] = 'u';
							break;
					}
				}
				
				if($second) {
					switch($second) {
						case 0:
							$close = $open_tags;
							break;
						case 30:
							// black
							$color = '#2E3436';
							break;
						case 31:
							// red
							$color = '#EF2929';
							break;
						case 32:
							// green
							$color = '#8AE234';
							break;
						case 33:
							// yellow
							$color = '#FCE94F';
							break;
						case 34:
							// blue
							$color = '#729FCF';
							break;
						case 35:
							// purple
							$color = '#AD7FA8';
							break;
						case 36:
							// cyan
							$color = '#34E2E2';
							break;
						case 37:
							// white
							$color = '#EEEEEC';
							break;
						case 40:
							// black
							$background = '#2E3436';
							break;
						case 41:
							// red
							$background = '#EF2929';
							break;
						case 42:
							// green
							$background = '#4E9A06';
							break;
						case 43:
							// yellow
							$background = '#FCE94F';
							break;
						case 44:
							// blue
							$background = '#729FCF';
							break;
						case 45:
							// purple
							$background = '#AD7FA8';
							break;
						case 46:
							// cyan
							$background = '#34E2E2';
							break;
						case 47:
							// white
							$background = '#EEEEEC';
							break;
					}
				} else {
					$close = $open_tags;
				}
				
				// set background
				if($background) {
					// terminate existing background
					if(in_array('a', $open_tags))
						$close[] = 'a';
					$open[] = Array('a', 'style="background:' . $background . '"');
				}
				
				// set colour
				if($color) {
					// terminate existing colour
					if(in_array('span', $open_tags))
						$close[] = 'span';
					$open[] = Array('span', 'style="color:' . $color . '"');
				}
				
				// avoids complications
				$close = array_reverse($close);
				
				// close tags
				foreach($close as $tag) {
					$html .= '</' . $tag . '>';
					unset($open_tags[array_search($tag, $open_tags)]);
				}
				
				// open tags
				foreach($open as $tag) {
					if(is_array($tag)) {
						$attr = $tag[1];
						$tag = $tag[0];
					} else $attr = false;
					
					if(in_array($tag, $open_tags))
						continue; // already open
					
					$html .= '<' . $tag . ($attr ? ' ' . $attr : '') . '>';
					$open_tags[] = $tag;
				}
				
				// append data appropriately to $newresponse, replacing the matched text with the replacement HTML tags.
				$pos = strpos($response, $matches[0][$i], $offset);
				$newresponse .= substr($response, $offset > 0 ? $offset : 0, $pos - $offset) . $html;
				$offset = $pos + strlen($matches[0][$i]);
			}
			
			$newresponse .= substr($response, $offset);
			
			// update response
			$response = &$newresponse;
			
			// fix new lines
			$response = str_replace("\n", '<br/>', $response);
			
			return $newresponse;
		}
		
		/**
		* Obtain a temporary filename to use.
		*
		* @return string: filename
		*/
		static function Temp() {
			global $config;
			
			return tempnam($config['temp'], 'phpsh');
		}
		
		/**
		* Append to PATH environment variable.
		*
		* @return null
		*/
		static function Path() {
			global $config;
			
			// current path
			$path = getenv('PATH');
			// split by :
			$path = explode(':', $path);
			
			foreach($config['paths'] as &$p) {
				if(!in_array($p, $path)) {
					// not already in PATH; append it
					$path[] = &$p;
				}
			}
			
			// compile again
			$path = implode(':', $path);
			
			// update environment
			putenv('PATH=' . $path);
		}
	};
	
	if(!$config['skip_log_in'] && LogInMessage() !== true)
		die('Not authenticated.');
	if(!isset($_POST['cmd']))
		die('Nothing to do! Needs `cmd\' parameter.');
	if(!isset($_POST['cd']))
		die('`cd\' parameter is required.');
	
	$cmd = $_POST['cmd'];
	$cd = $_POST['cd'];
	
	// response
	$json = Array();
	
	// `cd' does nothing but move back home
	if(trim($cmd) == 'cd') {
		// change to home
		$json['response'] = '';
		$json['cd'] = '~';
	} else {
		// execute command
		$shell = new Shell($config['home']);
		$shell->ChangeWorkingDirectory($cd);
		$response = $shell->Command($cmd);
		
		$json['response'] = $response;
		$json['cd'] = $shell->Directory;
	}
	
	echo json_encode($json);
	
	
	
