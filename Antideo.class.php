<?php

class Antideo {
    
    /**
 	 * Constructor
 	 *
 	 * @param string $apiKey <b>Optional</b> needs to be set if have API Key
 	 */
    function __construct($apiKey = null) {
       $this->apiKey = $apiKey;
   }
    
    
    /** 
 	 * Queries an IP address health
 	 *
 	 * @param string $email a valid email address to be queried
 	 *
 	 * @return stdClass email address result object
 	 *
 	 * @throws <b>Exception</b> if an error occurs while executing this request 
  	 */
    public function email($email) {
        if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
            try {
                $result = $this->call('/email/'.$email);
                return $result;
            } catch (Exception $e) {
                throw $e;
            }
        } else {
            throw new Exception($email.' is not a valid email address', 0);
        }
    }
    
    
    
    /** 
 	 * Queries an IP address health
 	 *
 	 * @param string $ip a valid IP address to be queried
 	 *
 	 * @return stdClass ip address health object
 	 *
 	 * @throws <b>Exception</b> if an error occurs while executing this request 
  	 */
    public function ipHealth($ip) {
        try {
            $result = $this->ipCall('/ip/health/',$ip);
            return $result;
        } catch (Exception $e) {
            throw $e;
        } 
    }
    
    
    
    /** 
 	 * Queries an IP address location
 	 *
 	 * @param string $ip a valid IP address to be queried
 	 *
 	 * @return stdClass ip address location object
 	 *
 	 * @throws <b>Exception</b> if an error occurs while executing this request 
  	 */
    public function ipLocation($ip) {
        try {
            $result = $this->ipCall('/ip/location/',$ip);
            return $result;
        } catch (Exception $e) {
            throw $e;
        } 
    }
    
    
    
    /** 
 	 * Queries an IP address info
 	 *
 	 * @param string $ip a valid IP address to be queried
 	 *
 	 * @return stdClass ip address info object
 	 *
 	 * @throws <b>Exception</b> if an error occurs while executing this request 
  	 */
    public function ipInfo($ip) {
        try {
            $result = $this->ipCall('/ip/info/',$ip);
            return $result;
        } catch (Exception $e) {
            throw $e;
        } 
    }
    
     
    /**
 	 * This will hold apiKey if passed in the constructor
 	 * @var string
 	 */
    private $apiKey;
    
    
    /**
 	 * Base URL to Antideo's REST API
 	 * @var string
 	 */
    private $baseURL = 'http://api.antideo.com';
    
    
    /** 
 	 * Private helper method executing the HTTP request
 	 *
 	 * @param string $path a URL path to be appended to baseURL
 	 *
 	 * @return stdClass response object returned from Antideo
 	 *
 	 * @throws <b>Exception</b> if an error occurs while executing this request 
  	 */
    private function call($path) {
        $ch = curl_init($this->baseURL . $path);
        if(isset($this->apiKey)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'apiKey:'.$this->apiKey
            ));
        }
        curl_setopt($ch,CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $info = curl_getinfo($ch);
        $httpcode = $info['http_code'];
        curl_close($ch);
        
        if($httpcode == 200) {
            $r = json_decode($result);
            return $r;
        } else {
            throw $this->makeException($httpcode);
        }
    }
    
    
    
    /** 
 	 * Helper method to execute API call if IP address is valid,
 	 * or thrown an exception otherwise
 	 *
 	 * @param string $path a URL path to be appended to baseURL
 	 * @param string $ip IP address candidate to be queried
 	 *
 	 * @return stdClass ip address health object
 	 *
 	 * @throws <b>Exception</b> if an error occurs 
  	 */
    private function ipCall($path, $ip) {
        if(filter_var($ip, FILTER_VALIDATE_IP)) {
            try {
                $result = $this->call($path . $ip);
                return $result;
            } catch (Exception $e) {
                throw $e;
            }
        } else {
            throw new Exception($ip.' is not a valid IP address', 0);
        }
    }
    
    
    
    /** 
 	 * Helper method to create HTTP response exception
 	 *
 	 * @param integer $code a HTTP response code returned
 	 *
 	 * @return exception Exception containing http response code and http response description
  	 */
    private function makeException($code) {
        $description = [400=>'Bad Request',401=>'Unauthorized',404=>'Method Not Allowed',429=>'Too Many Requests',500=>'Internal Server Error',503=>'Service Unavailable'];
        return new Exception($description[$code], $code);
    }
    
}

?>
