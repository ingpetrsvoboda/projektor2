<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Request
 *
 * @author pes2704
 */
class Projektor2_Request {
    
    protected $requestMethod;
    protected $get = array();
    protected $post = array();
    public $params = array();
    protected $cookies = array();
    
    public function __construct() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->requestMethod = 'post';
            $this->get = $_GET;            
            $this->params = $this->get;
            $this->post = $_POST;
            $this->params = array_merge($this->post, $this->params);
        }
    
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $this->requestMethod = 'get';
            $this->get = $_GET;
            $this->params = $this->get;
        }
        
        $this->cookies = $_COOKIE;
        
    }
    
    public function isPost() {
        if (isset($this->requestMethod) AND $this->requestMethod=='post') return TRUE;
        return FALSE;
    }
    
    public function isGet() {
        if (isset($this->requestMethod) AND $this->requestMethod=='get') return TRUE;
        return FALSE;
    }
    
    public function __get($name) {
        if (isset($this->params[$name])) {
            return $this->params[$name];
        }
    }
    
    public function post($name) {
        if (isset($this->post[$name])) {
            return $this->post[$name];
        }
    }
    
    public function postArray() {
        if (isset($this->post)) {
            return $this->post;        
        } else {
            return array();
        }
    }
        
    public function postObject() {
        if (isset($this->post)) {
            $postObject = new stdClass();
            foreach ($this->post as $key=>$value) {
                $postObject->$key = $value;
            }
            return $postObject;        
        } else {
            return NULL;
        }
    }
    
    public function get($name) {
        if (isset($this->get[$name])) {
            return $this->get[$name];        
        }
    }
    
    
    public function getArray() {
        if (isset($this->get)) {
            return $this->get;        
        } else {
            return array();
        }
    }
        
    public function getObject() {
        if (isset($this->get)) {
            $getObject = new stdClass();
            foreach ($this->get as $key=>$value) {
                $getObject->$key = $value;
            }
            return $getObject;        
        } else {
            return NULL;
        }
    }
    
    public function param($name) {
        if (isset($this->params[$name])) {
            return $this->params[$name]; 
        }
    }
        
    public function paramArray() {
        if (isset($this->params)) {
            return $this->params;        
        } else {
            return array();
        }
    }
        
    public function paranObject() {
        if (isset($this->params)) {
            $paramsObject = new stdClass();
            foreach ($this->params as $key=>$value) {
                $paramsObject->$key = $value;
            }
            return $paramsObject;        
        } else {
            return NULL;
        }
    }
    
    public function cookie($name) {
        if (isset($this->cookies[$name])) {
            return $this->cookies[$name];
        } else {
            return null;
        }      
    }
    
    
    public function cookiesArray() {
        if (isset($this->cookies)) {
            return $this->cookies;        
        } else {
            return array();
        }
    }
        
    public function cookiesObject() {
        if (isset($this->cookies)) {
            $cookiesObject = new stdClass();
            foreach ($this->cookies as $key=>$value) {
                $cookiesObject->$key = $value;
            }
            return $cookiesObject;        
        } else {
            return NULL;
        }
    }
}

?>
