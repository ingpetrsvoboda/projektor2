<?php


/**
* 
*
* @author pes2704
*/
class Projektor2_View_PDF_Ap_IP2Hodnoceni extends Projektor2_View_PDF_Common {
    const MODEL_UKONCENI = "ukonceni->";
    const MODEL_DOTAZNIK = "dotaznik->";
    const MODEL_PLAN = 'plan->';

    public function createPDFObject() {

        $textPaticky = "Individuální plán účastníka v projektu „Alternativní práce v Plzeňském kraji“ - část 2 - hodnocení a doporučení  ".$this->context["file"];      
        
        $this->setHeaderFooter($textPaticky);
        $this->initialize();
        //*****************************************************
        $textyNadpisu[] = "INDIVIDUÁLNÍ PLÁN ÚČASTNÍKA - část 2 - hodnocení a doporučení";
        $textyNadpisu[] = 'Projekt „Alternativní práce v Plzeňském kraji“';
        $this->tiskniTitul($textyNadpisu);
        //*****************************************************
        $this->tiskniOsobniUdaje(self::MODEL_DOTAZNIK);
        //********************************************************
        $blok = new Projektor2_PDF_Blok;
            $blok->Nadpis("Preambule");            
            $blok->PridejOdstavec("Druhá část IP obsahuje vyhodnocení účasti klienta v projektu (shrnutí absolvovaných aktivit a provedených kontaktů se zaměstnavateli) a v případě, že klient nezíská při účasti v projektu zaměstnání, také doporučení vysílajícímu KoP pro další práci s klientem.");
            $blok->predsazeni(0);
            $blok->odsazeniZleva(0);
        $this->pdf->TiskniBlok($blok);        
        //##################################################################################################
        $aktivity = Projektor2_AppContext::getAktivityProjektu('AP'); 
            $blok = new Projektor2_PDF_Blok;
                $blok->Nadpis("Vyhodnocení a doporučení");            
                $blok->predsazeni(0);
                $blok->odsazeniZleva(0);
            $this->pdf->TiskniBlok($blok);
// kurzy
//            VYNECHÁNO

// poradenství
            $count = count($this->context['aktivityProjektuTypuPoradenstvi']);
            $dolniokrajAPaticka = 25;
            $mistoDatumPodpisy = 60;
            if ($count) {
                $counter = 0;
                foreach($this->context['aktivityProjektuTypuPoradenstvi'] as $indexAktivity=>$aktivita) {
//                    $kurzPlan = new Projektor2_Model_KurzPlan();
                    if ($this->context[self::MODEL_UKONCENI.$indexAktivity.'_hodnoceni']) {
                        $counter++;
                        $yPositionBefore = $this->pdf->getY();  

                        $vyhodnoceni=new Projektor2_PDF_Blok();
                        $vyhodnoceni->Nadpis($aktivita['nadpis']);
                        $vyhodnoceni->vyskaPismaNadpisu(11);
                        $vyhodnoceni->Odstavec($this->context[self::MODEL_UKONCENI.'vyhodnoceni']);                                                
                        $vyhodnoceni->PridejOdstavec($this->context[self::MODEL_UKONCENI.$indexAktivity.'_hodnoceni']);
                        $this->pdf->TiskniBlok($vyhodnoceni);
                            
                        if ($counter == $count-1) {
                            $potrebneMisto = $dolniokrajAPaticka+$mistoDatumPodpisy;                        
                        } else {
                            $potrebneMisto = $dolniokrajAPaticka;
                        }
                        if (($this->pdf->h - $potrebneMisto - $this->pdf->getY()) < ($this->pdf->getY() - $yPositionBefore)) {
                            $this->pdf->AddPage();
                        }                        
                    }               
                }
            } else {
                $bezAktivit = new Projektor2_PDF_Blok();
                $bezAktivit->Odstavec("Účastník se v neúčastnil žádných aktivit projektu.");
                $this->pdf->TiskniBlok($bezAktivit);                    
            }            
        //##################################################################################################
        $this->tiskniMistoDatum(self::MODEL_DOTAZNIK, $this->context[self::MODEL_UKONCENI . "datum_vytvor_dok_ukonc"]);
        $this->tiskniPodpisPoradce(self::MODEL_DOTAZNIK);   
        return $this->pdf;
    }

}

?>
