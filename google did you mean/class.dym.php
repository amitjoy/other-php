<?php

/** @Usage
include "class.dym.php"; // Include PHP Class
$dym = new DYM; // Make a new instance
$dym->tld = "com"; // You can set prefered TLD based on your language, if your website is in English then use com (default)

$q = $_GET["q"]; // Get search query eg "caniooon eios 50 d"

if(!empty($q)){
    $spell = $dym->search($q);
    if(!empty($spell)) $q = $spell;
}

echo $q; // canon eos 50d
*/

class DYM{
    
    public $tld = "com"; // Default is COM, if you want to look for example Spanish suggestion, use "es"  
    
    public function search($q){
     
        $url = "http://www.google.{$this->tld}/m?q=".str_replace(" ", "+", $q);  // URI of Google Did You Mean
        $html = $this->curl($url); // Fetch HTML data

        // Extract suggestion and return it if any
        preg_match('#spell=1(.*?)>(.*?)</a>#is', $html, $matches);
        if($matches){
            $spell = strip_tags($matches[2]); 
            return $spell;
        }
    
    }
    
    // cURL helper function, for fast data fetching
    private function curl($url){

        $headers[]  = "User-Agent:Mozilla/5.0 (Linux; U; Android 2.2.1; en-us; device Build/FRG83) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Safari/533.1";
        $headers[]  = "Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8";
        $headers[]  = "Accept-Language:en-us,en;q=0.5";
        $headers[]  = "Accept-Encoding:gzip,deflate";
        $headers[]  = "Accept-Charset:ISO-8859-1,utf-8;q=0.7,*;q=0.7";
        $headers[]  = "Keep-Alive:115";
        $headers[]  = "Connection:keep-alive";
        $headers[]  = "Cache-Control:max-age=0";
    
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_ENCODING, "gzip");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        curl_close($curl);
        return $data;
    
    }
    
}

?>