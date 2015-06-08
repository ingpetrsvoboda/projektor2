<?php
/**
* Description of 
*
* @author pes2704
*/
class Projektor2_View_PDF_KurzOsvedceniOriginal extends Projektor2_View_PDF_Common {
    
    const MODEL_PLAN     = "plan"; 
    const MODEL_DOTAZNIK = "dotaznik";

    public function createPDFObject() {  //Projektor2_Model_Db_Projekt $projekt
        $this->setHeaderFooter($this->context['text_paticky'], FALSE); 
        $this->initialize();
        //*****************************************************
        $this->pdf->Image(Projektor2_AppContext::getCertificateoriginalBackgroundImageFilepath(), 0, 0, 210, 297);  

        Projektor2_View_PDF_Helper_KurzOsvedceni::createContent($this->pdf, $this->context, $this);
        //##################################################################################################
        $datumCertif = Projektor2_Date::createFromSqlDate($this->context['certifikat']->date)->getCzechStringDate();
        $this->tiskniMistoDatum(self::MODEL_DOTAZNIK, $datumCertif);
        $this->pdf->Ln(20);
        $this->tiskniPodpisCertifikat();    
   
    }
}
?>
