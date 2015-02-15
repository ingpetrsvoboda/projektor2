<?php
/**
* Description of 
*
* @author pes2704
*/
class Projektor2_View_PDF_Ap_KurzOsvedceniOriginal extends Projektor2_View_PDF_Ap_Common {
    
    const MODEL_PLAN     = "plan"; 
    const MODEL_DOTAZNIK = "dotaznik";

    public function createPDFObject() {
        $textPaticky = "Osvědčení o absolutoriu kurzu v projektu „Alternativní práce v Plzeňském kraji“ "
                .$this->context["file"];      
        $this->setHeaderFooter($textPaticky, FALSE);
        $this->initialize();
        //*****************************************************
        $this->pdf->Image("img/pozadi/pozadi.jpg", 0, 25, 210, 272);  

        Projektor2_View_PDF_Helper_KurzOsvedceni::createContent($this->pdf, $this->context, $this);

        //##################################################################################################
        $datumCertif = Projektor2_Date::zSQL($this->context['certifikat']->date)->dejDatumRetezec();
        $this->tiskniMistoDatum(self::MODEL_DOTAZNIK, $datumCertif);
        $this->pdf->Ln(20);
        $this->tiskniPodpisCertifikat();      
    }
}
?>
