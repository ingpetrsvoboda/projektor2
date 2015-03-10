<?php
/**
* Description of 
*
* @author pes2704
*/
class Projektor2_View_PDF_Sjzp_ProjektOsvedceniPseudokopie extends Projektor2_View_PDF_Common {
    const MODEL_DOTAZNIK = "dotaznik";
    const MODEL_UKONCENI = "ukonceni";

    public function createPDFObject() {
        $textPaticky = "Osvědčení o absolutoriu projektu „Alternativní práce v Plzeňském kraji“ ".$this->context["file"];      
        $this->setHeaderFooter($projekt, $textPaticky, FALSE);
        $this->initialize();
        //*****************************************************
        $number = intval(rand(1, 4.99));
        $this->pdf->Image("img/pozadi/komplet_pozadi".$number.".jpg", 0, 0, 210, 297);  
//        $this->pdf->Image("img/pozadi/pozadi.jpg", 0, 25, 210, 272);  
        Projektor2_View_PDF_Helper_ProjektOsvedceni::createContent($this->pdf, $this->context, $this);
        //##################################################################################################
        $datumCertif = Projektor2_Date::zSQL($this->context['certifikat']->date)->dejDatumRetezec();
        $this->tiskniMistoDatum(self::MODEL_DOTAZNIK, $datumCertif);
        $this->pdf->Ln(20);
        $this->tiskniPodpisCertifikat();      
    }
}
?>
