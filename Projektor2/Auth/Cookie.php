<?php
//require_once 'Exception.inc';
//class AuthException extends Exception {}	//klon

//class Cookie {	//klon
class Projektor2_Auth_Cookie {
    private $response;
    private $userid;
    
    private $created;
    private $version;
    
    //Parametry šifrování
    private $td;
    
    static $cypher = 'blowfish';
    static $mode = 'cfb';
    static $key = '8Fsfr9Ksxxc0008jj81';
    
    //Nastavení formátu Cookie
    static $cookiename = 'USERAUTH';
    static $myversion = '0.1';
    static $expiration = '6000'; //doba vypršení cookie
    static $warning = '300'; //doba po které se obnoví-znovu vydá cookie
    static $glue = '|';
    
    public function __construct(Projektor2_Request $request, Projektor2_Response $response, $userid = false) {
        $this->response = $response;
        $this->td = mcrypt_module_open (self::$cypher, '', self::$mode, '');
        if($userid) {
            $this->userid = $userid;
        } else {
            if($request->cookie(self::$cookiename)) {
                $this->_unpack($request->cookie(self::$cookiename));
            }
            else {
                throw new Projektor2_Auth_Exception ("No cookie");
            }
        }
    }
    public function get_userid() {
        return $this->userid;
    }
    public function set() {
        $cookie = $this->_pack();
        $this->response->setCookie(self::$cookiename,$cookie);
    }
    
    public function validate() {
        if(!$this->version || !$this->created || !$this->userid) {
            throw new Projektor2_Auth_Exception("Malformed cookie");
        }
        if($this->version != self::$myversion) {
            throw new Projektor2_Auth_Exception("Version mismatch");
        }
        if (time() - $this->created > self::$expiration) {
            throw new Projektor2_Auth_Exception("Cookie expired");
        } elseif (time() - $this->created > self::$warning) {
            $this->set();
        }
    }
    
    public function logout() {
//        $this->response->setCookie(self::$cookiename,"",0);
        $this->response->setCookie(self::$cookiename,"", time() - 3600);
    }
    
    private function _pack() {
        $parts = array(self::$myversion, time(), $this->userid);
        $cookie = implode(self::$glue, $parts);
        return $this->_encrypt($cookie);
    }
    
    private function _unpack($cookie) {
        $buffer = $this->_decrypt($cookie);
        list($this->version,$this->created,$this->userid) = explode(self::$glue, $buffer);
        if($this->version != self::$myversion || !$this->created || !$this->userid) {
            throw new Projektor2_Auth_Exception("Malformed cookie");
        }
    }
    
    private function _encrypt($plaintext) {
        $iv = mcrypt_create_iv (mcrypt_enc_get_iv_size($this->td), MCRYPT_RAND);
        mcrypt_generic_init ($this->td, self::$key, $iv);
        $crypttext = mcrypt_generic ($this->td, $plaintext);
        mcrypt_generic_deinit ($this->td);
        return $iv.$crypttext;
    }
    
    private function _decrypt($crypttext) {
        $ivsize = mcrypt_enc_get_iv_size($this->td);
        $iv = substr($crypttext, 0, $ivsize);
        $crypttext = substr($crypttext, $ivsize);
        mcrypt_generic_init ($this->td, self::$key, $iv);
        $plaintext = mdecrypt_generic ($this->td, $crypttext);
        mcrypt_generic_deinit ($this->td);
        return $plaintext;
    }
    
    private function _reissue() {
        $this->created = time();
    }
}