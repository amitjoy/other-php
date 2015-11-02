<?php
class PayPalIpnListener
{
    // --------------------------------------------------------
    // if set to true, the curl php library is used to post
    // back to the paypal server. if set to false, fsockopen()
    // is used intead.
    // --------------------------------------------------------
    public $use_curl = true;     

    // --------------------------------------------------------
    // if set to true, it uses the php curl library to use 
    // SSL version 3. handy if curl is compiled with gnutls ssl.
    // --------------------------------------------------------
    public $use_ssl_v3 = false;

    // --------------------------------------------------------
    // if set to true, ssl port 443 secure connection is used. 
    // if set to false, the standard http port 80 is used.
    // --------------------------------------------------------
    public $use_ssl = true;

    // --------------------------------------------------------
    // true = use paypal sandbox = www.sandbox.paypal.com
    // false = use live paypal = www.paypal.com
    // --------------------------------------------------------
    public $use_sandbox = false; 

    // --------------------------------------------------------
    // The amount of time in seconds, to wait for the PayPal 
    // server to respond before timing out.
    // --------------------------------------------------------
    public $timeout = 30;       
    
    private $post_data = array();
    private $post_uri = '';
    private $response_status = '';
    private $response = '';

    const PAYPAL_HOST = 'www.paypal.com';
    const SANDBOX_HOST = 'www.sandbox.paypal.com';

    // --------------------------------------------------------
    // POST BACK USING CURL
    // if the use_curl property above is set to true, this
    // method uses the php curl library to post back to paypal, 
    // or throws an exception if the post fails.
    // --------------------------------------------------------
    protected function curlPost($encoded_data)
    {
        if ($this->use_ssl)
        {
            $uri = 'https://'.$this->getPaypalHost().'/cgi-bin/webscr';
            $this->post_uri = $uri;
        }
        else
        {
            $uri = 'http://'.$this->getPaypalHost().'/cgi-bin/webscr';
            $this->post_uri = $uri;
        }
        
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $uri);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded_data);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        
        if($this->use_ssl_v3)
        {
            curl_setopt($ch, CURLOPT_SSLVERSION, 3);
        }
        
        $this->response = curl_exec($ch);
        $this->response_status = strval(curl_getinfo($ch, CURLINFO_HTTP_CODE));
        
        if ($this->response === false || $this->response_status == '0')
        {
            $errno = curl_errno($ch);
            $errstr = curl_error($ch);
            throw new Exception("cURL error: [$errno] $errstr");
        }
    }

    // --------------------------------------------------------
    // POST BACK USING fsockopen()
    // if the use_curl property above is set to false, this
    // method uses the fsockopen() function to post back to 
    // paypal, or throws an exception if the post fails.
    // --------------------------------------------------------
    protected function fsockPost($encoded_data)
    {
        if ($this->use_ssl)
        {
            $uri = 'ssl://'.$this->getPaypalHost();
            $port = '443';
            $this->post_uri = $uri.'/cgi-bin/webscr';
        }
        else
        {
            $uri = $this->getPaypalHost();
            $port = '80';
            $this->post_uri = 'http://'.$uri.'/cgi-bin/webscr';
        }

        $fp = fsockopen($uri, $port, $errno, $errstr, $this->timeout);
        
        if (!$fp)
        {
            throw new Exception("fsockopen error: [$errno] $errstr");
        } 

        $header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Content-Length: ".strlen($encoded_data)."\r\n";
        $header .= "Connection: Close\r\n\r\n";
        
        fputs($fp, $header.$encoded_data."\r\n\r\n");
        
        while(!feof($fp))
        { 
            if (empty($this->response))
            {
                // extract HTTP status from first line
                $this->response .= $status = fgets($fp, 1024); 
                $this->response_status = trim(substr($status, 9, 4));
            }
            else
            {
                $this->response .= fgets($fp, 1024); 
            }
        } 
        
        fclose($fp);
    }
    
    // --------------------------------------------------------
    // return the currently selected paypal host address
    // --------------------------------------------------------
    private function getPaypalHost()
    {
        if($this->use_sandbox)
        {
            return PayPalIpnListener::SANDBOX_HOST;
        }
        else
        {
            return PayPalIpnListener::PAYPAL_HOST;
        }
    }

    // --------------------------------------------------------
    // GET POST URI
    // return the uri used to send the post back to PayPal.
    // --------------------------------------------------------
    public function getPostUri()
    {
        return $this->post_uri;
    }

    // --------------------------------------------------------
    // GET RESPONSE
    // return the entire response from PayPal as a string 
    // including all the http headers.
    // --------------------------------------------------------
    public function getResponse()
    {
        return $this->response;
    }

    // --------------------------------------------------------
    // GET RESPONSE STATUS
    // return the http response status code from paypal.
    // if the value is 200, the post was a success.
    // --------------------------------------------------------
    public function getResponseStatus()
    {
        return $this->response_status;
    }

    // --------------------------------------------------------
    // GET TEXT REPORT
    // create a report of the entire ipn trasaction.
    // --------------------------------------------------------
    public function getTextReport()
    {
        $r = '';
        
        // date and POST url
        for ($i=0; $i<80; $i++) { $r .= '-'; }
        $r .= "\n[".date('m/d/Y g:i A').'] - '.$this->getPostUri();
        if ($this->use_curl) $r .= " (curl)\n";
        else $r .= " (fsockopen)\n";
        
        // HTTP Response
        for ($i=0; $i<80; $i++) { $r .= '-'; }
        $r .= "\n{$this->getResponse()}\n";
        
        // POST vars
        for ($i=0; $i<80; $i++) { $r .= '-'; }
        $r .= "\n";
        
        foreach ($this->post_data as $key => $value) {
            $r .= str_pad($key, 25)."$value\n";
        }
        $r .= "\n\n";
        
        return $r;
    }
    
    // --------------------------------------------------------
    // PROCESS THE IPN
    // handles the ipn post back to paypal and parses the 
    // response. returns true if the response is verified, and
    // false if the response is invalid.
    // --------------------------------------------------------
    public function processIpn($post_data=null)
    {
        $encoded_data = 'cmd=_notify-validate';
        
        if ($post_data === null)
        { 
            // use raw POST data 
            if (!empty($_POST))
            {
                $this->post_data = $_POST;
                $encoded_data .= '&'.file_get_contents('php://input');
            }
            else
            {
                throw new Exception("No POST data found.");
            }
        }
        else
        { 
            // use provided data array
            $this->post_data = $post_data;
            
            foreach($this->post_data as $key => $value)
            {
                $encoded_data .= "&$key=".urlencode($value);
            }
        }

        // --------------------------------------------------------
        // use the selected postback method - curl or fsockopen
        // --------------------------------------------------------
        if ($this->use_curl) $this->curlPost($encoded_data); 
        else $this->fsockPost($encoded_data);
        
        if(strpos($this->response_status, '200') === false)
        {
            throw new Exception("Invalid response status: ".$this->response_status);
        }
        
        if(strpos($this->response, "VERIFIED") !== false)
        {
            return true;
        }
        elseif(strpos($this->response, "INVALID") !== false)
        {
            return false;
        }
        else
        {
            throw new Exception("Unexpected response from PayPal.");
        }
    }
 
    // --------------------------------------------------------
    // REQUIRE POST METHOD
    // if the request method is not a post, throw an exception
    // --------------------------------------------------------  
    public function requirePostMethod()
    {
        // require POST requests
        if($_SERVER['REQUEST_METHOD'] && $_SERVER['REQUEST_METHOD'] != 'POST')
        {
            header('Allow: POST', true, 405);
            throw new Exception("Invalid HTTP request method.");
        }
    }
}