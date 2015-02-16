<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AppStatus
 *
 * @author pes2704
 */
class Projektor2_Model_SessionStatus {
    protected static $userId;
    protected static $behId;
    protected static $ucastnikId;
    protected static $zajemceId;
    
    /**
     * Poslední načtený stav
     * @var Projektor2_Model_SessionStatus 
     */
    protected static $sessionStatus;
    
    /**
     *
     * @var Projektor2_Model_Db_Kancelar 
     */
    public $kancelar;
    /**
     *
     * @var Projektor2_Model_Db_Projekt 
     */
    public $projekt;
    /**
     *
     * @var Projektor2_Model_Db_Beh 
     */
    public $beh;
    /**
     *
     * @var Projektor2_Model_Db_SysUser 
     */
    public $user;
    /**
     *
     * @var Projektor2_Model_Db_Ucastnik 
     */
    public $ucastnik;
    /**
     *
     * @var Projektor2_Model_Db_Zajemce 
     */
    public $zajemce;
    
    /**
     * Privátní konstruktor 
     * @param type $kancelar
     * @param type $projekt
     * @param type $beh
     * @param type $user
     * @param type $zajemce
     */
    private function __construct(Projektor2_Model_Db_SysUser $user=NULL, Projektor2_Model_Db_Kancelar $kancelar=NULL, 
                        Projektor2_Model_Db_Projekt $projekt=NULL, Projektor2_Model_Db_Beh $beh=NULL, 
                        Projektor2_Model_Db_Zajemce $zajemce=NULL) {
        $this->kancelar = $kancelar;
        $this->projekt = $projekt;
        $this->beh = $beh;
        $this->user = $user;
        $this->zajemce = $zajemce;
    }

    public function __get($name) {
        return $this->$name;   //TODO: nekontroluje existenci vlastnosti
    }
    
    public function __set($name, $value) { 
        return FALSE; //TODO: nehlasi zadnym způsobem chybné volání
    }
    
    public function setUser(Projektor2_Model_Db_SysUser $user=NULL) {      
        $this->user = $user;
        return $this;
    }    
    
    public function setKancelar(Projektor2_Model_Db_Kancelar $kancelar=NULL) {      
        $this->kancelar = $kancelar;
        return $this;
    }
    
    public function setProjekt(Projektor2_Model_Db_Projekt $projekt=NULL) {      
        $this->projekt = $projekt;
        return $this;
    }    
    
    public function setBeh(Projektor2_Model_Db_Beh $beh=NULL) {      
        $this->beh = $beh;
        return $this;
    }
    
    public function setZajemce(Projektor2_Model_Db_Zajemce $zajemce=NULL) {      
        $this->zajemce = $zajemce;
        return $this;
    }
    
    /**
     * Metoda vytvoří session status z cookies nastavených login procesem
     * @return Projektor2_Model_SessionStatus
     * @throws Exception
     */
    public static function createSessionStatus(Projektor2_Request $request, Projektor2_Response $response) {
        if (!self::$sessionStatus) {   //sigleton
            self::$sessionStatus = new Projektor2_Model_SessionStatus();
            try {
                $authCookie = new Projektor2_Auth_Cookie($request, $response);  // injekt response, Projektor2_Auth_Cookie sama nastaví cookie v responsu
                $authCookie->validate();  // při neúspěšné validaci vyhazuje výjimku
                // projekt z cookie
                self::$sessionStatus->setProjekt(Projektor2_Model_Db_ProjektMapper::findById($request->cookie('projektId')));
                // kancelat z cookie
                self::$sessionStatus->setBeh(Projektor2_Model_Db_KancelarMapper::findById($request->cookie('kancelarId')));            
                // beh z cookie
                self::$sessionStatus->setBeh(Projektor2_Model_Db_BehMapper::findById($request->cookie('behId')));
                // user z auth cookie
                $user = Projektor2_Model_Db_SysUserMapper::findById($authCookie->get_userid());
                if(!$user) {
                    throw new Exception("Neexistuje uživatel s nastavenou identitou.");
                }
                self::$sessionStatus->setUser($user);
                // zajemce z cookie
                $zajemce = Projektor2_Model_Db_ZajemceMapper::findById($request->cookie('zajemceId'));
                self::$sessionStatus->setZajemce($zajemce);
            } catch (Projektor2_Auth_Exception $exception) {
                self::$sessionStatus->setProjekt();
                self::$sessionStatus->setBeh();            
                self::$sessionStatus->setBeh();
                self::$sessionStatus->setUser();
                self::$sessionStatus->setZajemce();                
            } 


        }
        return self::$sessionStatus;
    }
    
    public function persistSessionStatus(Projektor2_Request $request, Projektor2_Response $response) {
        //buď nastaví nebo vymaže cookie, pokud proměnná je FALSE, všechny cookie jsou expirovány na konci sesion (doba expirace není zadána)
        if (isset($this->user->id)) {
            $response->setCookie('userId', $this->user->id);  
        } else {
            $response->setCookie('userId', NULL);              
        }
        if (isset($this->beh->id)) {
            $response->setCookie('behId', $this->beh->id);
        } else {
            $response->setCookie('behId', NULL);
        }
        if (isset($this->zajemce->id)) {
            $response->setCookie('zajemceId', $this->zajemce->id);
        } else {
            $response->setCookie('zajemceId', NULL);
        }
    }
    
    /**
     * 
     * @return Projektor2_Model_SessionStatus
     */
    public static function getSessionStatus() {
        return self::$sessionStatus;
    }
}

?>
