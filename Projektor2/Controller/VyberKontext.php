<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VyberBehu
 *
 * @author pes2704
 */
class Projektor2_Controller_VyberKontext extends Projektor2_Controller_Abstract {

    public function performPostActions() {
        if ($this->request->isPost()) {
            if ($this->request->post('id_kancelar')) {
                switch ($this->request->post('id_kancelar')) {
                    case 'ß':
                            $this->sessionStatus->setKancelar();
                            $k = FALSE;
                        break;
                    case '*':
                            $this->sessionStatus->setKancelar();
                            $k = TRUE;
                        break;
                    default:
                            $kancelar = Projektor2_Model_Db_KancelarMapper::findById($this->request->post('id_kancelar'));
                            $this->sessionStatus->setKancelar($kancelar);
                            $k = TRUE;
                        break;
                }

            }
            if ($this->request->post('id_beh')) {
                switch ($this->request->post('id_kancelar')) {
                    case ' ':
                            $this->sessionStatus->setBeh();
                            $b = FALSE;
                        break;
                    case '*':
                            $this->sessionStatus->setBeh();
                            $b = TRUE;
                        break;
                    default:
                            $beh = Projektor2_Model_Db_BehMapper::findById($this->request->post('id_beh'));
                            $this->sessionStatus->setBeh($beh);
                            $b = TRUE;
                        break;
                }                
            }
            return $k AND $b;
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
