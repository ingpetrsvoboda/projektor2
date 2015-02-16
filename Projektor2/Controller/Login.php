<?php
/**
 * Description of Projektor2_Controller_Login
 *
 * @author pes2704
 */
class Projektor2_Controller_Login extends Projektor2_Controller_Abstract {
    
    private $warning;

    public function performPostActions() {
        if ($this->request->isPost()) {
            $name = $this->request->post('name');
            $password = $this->request->post('password');
            $userid = Projektor2_Auth_Authentication::check_credentials($name,$password);    
            if($userid){
                $authCookie = new Projektor2_Auth_Cookie($this->request, $this->response, $userid);
                $authCookie->set();
                if(!is_numeric($this->request->post('id_projekt'))) {
                    switch ($this->request->post('id_projekt')) {
                        case 'ß':
                                $this->sessionStatus->setProjekt();
                                $success = FALSE;
                            break;
    //                    case '*':
    //                            $this->sessionStatus->setProjekt();
    //                            $p = TRUE;
    //                        break;
                        default:
                            if(!is_numeric($this->request->post('id_projekt'))) {
                                $projekt = Projektor2_Model_Db_ProjektMapper::findById($this->request->post('id_projekt'));
                                $this->sessionStatus->setProjekt($projekt);
                                $success = TRUE;
                            } else {
                                $this->warning = "Prosím vyberte projekt ke kterému se chcete přihlásit a přihlašte se znovu !";
                                $this->sessionStatus->setProjekt();
                                $success = FALSE;
                            }
                            break;
                    }
                }
            } else {
                $this->warning = "Přihlášení se nezdařilo.";       
                $success = FALSE;
            }            

            return $success;
        }        
    }
    
    public function getResult() {
        $performContinue = $this->performPostActions();

        $projekty = Projektor2_Model_Db_ProjektMapper::findAll();
        $parts[] = new Projektor2_View_HTML_VyberKontext(
                array('projekty'=>$projekty, 
                    'id_projekt'=>isset($this->sessionStatus->projekt->id) ? $this->sessionStatus->projekt->id : NULL,
                    'warning'=>$this->warning)
                );
        // podmínka pro pokračování
        if ($performContinue===TRUE) {
            $controller = new Projektor2_Controller_VyberKontext($this->sessionStatus, $this->request, $this->response);
            $parts[] = $controller->getResult();        
        }
        $viewVybery = new Projektor2_View_HTML_Multipart(array('htmlParts'=>$parts));
        return $viewVybery;
    }
}

?>
