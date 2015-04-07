<?php
/**
 * Description of Projektor2_Controller_Ap_ExportCertifikat
 *
 * @author pes2704
 */
class Projektor2_Controller_Certifikat_Kurz extends Projektor2_Controller_Certifikat_Abstract {

    /**
     * Metoda ověří existenci certifikátu, pokud neexistuje vytvoří ho a jako html obsah vrací js kód pro otevření pdf v novém okně prohlížeče.
     * @return string 
     * @throws LogicException
     */
    public function getResult() {
        $sKurz = Projektor2_Model_Db_SKurzMapper::findById($this->params['idSKurzFK']);
        if (!$sKurz) {
            throw new LogicException('Nekonzistence dat. Nelze vytvářet dokument certifikátu. Nenalezen kurz s id '.$this->params['idSKurzFK']
                    .', které bylo přečteno z tabulky plan.');
        }         
        $serviceCertifikat = new Projektor2_Service_CertifikatKurz();
        $datumCertifikatu = $this->params['datumCertif'];   
        $certifikat = $serviceCertifikat->create($this->sessionStatus, $this->sessionStatus->kancelar, 
                                       $this->sessionStatus->zajemce, $sKurz, $datumCertifikatu, $this->sessionStatus->user->username, __CLASS__);
        if (!$certifikat) {
            throw new LogicException('Nepodařilo se vytvořit certifikát pro zajemce id: '.$this->sessionStatus->zajemce->id. ', kurz id: '.$sKurz->id);
        } else {        
            $viewPdf = new Projektor2_View_HTML_Script_NewWindowOpener($this->sessionStatus);
            $viewPdf->assign('fullFileName', 'http://'.$_SERVER['HTTP_HOST'].'/'.Projektor2_AppContext::getFileBaseFolder().$certifikat->dbCertifikatKurz->filename);
            return $viewPdf->render(); 
        }
    } 
}
