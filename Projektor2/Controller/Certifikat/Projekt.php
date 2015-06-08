<?php
/**
 * Description of Projektor2_Controller_Ap_ExportCertifikat
 *
 * @author pes2704
 */
class Projektor2_Controller_Certifikat_Projekt extends Projektor2_Controller_Certifikat_Abstract {

    /**
     * Metoda ověří existenci certifikátu, pokud neexistuje vytvoří ho a jako html obsah vrací js kód pro otevření pdf v novém okně prohlížeče.
     * @return string 
     * @throws LogicException
     */
    public function getResult() {
        $serviceCertifikat = new Projektor2_Service_CertifikatProjekt();
        $datumCertifikatu = $this->params['datumCertif'];
        $certifikat = $serviceCertifikat->create(
                $this->sessionStatus, $this->sessionStatus->kancelar, 
                $this->sessionStatus->zajemce, $datumCertifikatu, $this->sessionStatus->user->username, __CLASS__);
        if (!$certifikat) {
            throw new LogicException('Nepodařilo se vytvořit certifikát pro zajemce id: '.$this->sessionStatus->zajemce->id. '.');
        }
        $viewPdf = new Projektor2_View_HTML_Script_NewWindowOpener();
        $viewPdf->assign('fullFileName', 'http://'.$_SERVER['HTTP_HOST'].'/'.Projektor2_AppContext::getFileBaseFolder().$certifikat->dbCertifikatProjekt->filename);
        
        return $viewPdf->render();          
    }
}
