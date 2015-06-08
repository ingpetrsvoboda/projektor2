<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Response
 *
 * @author pes2704
 */
class Projektor2_Response {

    protected $cookies = array();
    protected $body;
    
    public function setCookie($name, $value=NULL, $expire=0, $path=NULL, $domain=NULL, $secure=FALSE, $httponly=FALSE) {
        $this->cookies[$name] = new Projektor2_Cookie($name, $value, $expire, $path, $domain, $secure, $httponly);
    }
    
    public function setBody($text) {
        $this->body = $text;
    }
    
    public function appendToBody($text) {
        $this->body .= $text;
    }
    
    public function send() {
        foreach ($this->cookies as $cookie) {
            setcookie($cookie->name, $cookie->value, $cookie->expire, $cookie->path, $cookie->domain, $cookie->secure, $cookie->httponly);
        }
        echo $this->body;
    }
}

?>
