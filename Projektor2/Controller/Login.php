<?php
/**
 * Description of Projektor2_Controller_Login
 *
 * @author pes2704
 */
class Projektor2_Controller_Login extends Projektor2_Controller_Abstract {

    public function performPostActions() {
        if ($this->request->isPost()) {
            
            user authentication
            
            if ($this->request->post('id_projekt')) {
                switch ($this->request->post('id_projekt')) {
//                    case ' ':
//                            $this->sessionStatus->setKancelar();
//                            $k = FALSE;
//                        break;
//                    case '*':
//                            $this->sessionStatus->setKancelar();
//                            $k = TRUE;
//                        break;
                    default:
                            $projekt = Projektor2_Model_Db_ProjektMapper::findById($this->request->post('id_projekt'));
                            $this->sessionStatus->setProjekt($projekt);
                            $p = TRUE;
                        break;
                }
            }

            return $p;
        }        
    }
    
    public function getResult() {
        $performContinue = $this->performPostActions();

        $idKancelari = Projektor2_Model_Db_SysAccUsrKancelarMapper::getIndexArray('id_c_kancelar', 'id_sys_users='.$this->sessionStatus->user->id);
        $kancelare = Projektor2_Model_Db_KancelarMapper::findAll('id_c_projekt_FK='.$this->sessionStatus->projekt->id.' AND id_c_kancelar IN ('.implode(', ', $idKancelari).')');    
        $behy = Projektor2_Model_Db_BehMapper::findAll('id_c_projekt='.$this->sessionStatus->projekt->id);    
        $parts[] = new Projektor2_View_HTML_VyberKontext(
                array('kancelare'=>$kancelare, 
                    'id_kancelar'=>isset($this->sessionStatus->kancelar->id) ? $this->sessionStatus->kancelar->id : NULL, 
                    'behy'=>$behy, 
                    'id_beh'=>isset($this->sessionStatus->beh->id) ? $this->sessionStatus->beh->id : NULL)
                );
        // podmínka pro pokračování
        if ($performContinue===TRUE) {
            $router = new Projektor2_Router_Akce($this->sessionStatus, $this->request, $this->response);
            $controller = $router->getController();
            $parts[] = $controller->getResult();        
        }
        $viewVybery = new Projektor2_View_HTML_Multipart(array('htmlParts'=>$parts));
        return $viewVybery;
    }
}

?>
