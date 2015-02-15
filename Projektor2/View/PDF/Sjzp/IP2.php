<?php


/**
* 
*
* @author pes2704
*/
class Projektor2_View_PDF_Sjzp_IP2 extends Projektor2_View_PDF_Sjzp_Common {
    const MODEL_UKONCENI = "ukonceni->";
    const MODEL_DOTAZNIK = "dotaznik->";
    const MODEL_PLAN = 'plan->';

    public function createPDFObject() {

        $textPaticky = "Individuální plán účastníka v projektu „S jazyky za prací v Karlovarském kraji“ - část 2 - vyhodnocení aktivit  ".$this->context["file"];             
        $this->setHeaderFooter($textPaticky);
        $this->initialize();
        //*****************************************************
        $textyNadpisu[] = "INDIVIDUÁLNÍ PLÁN ÚČASTNÍKA - část 2 - vyhodnocení aktivit";
        $textyNadpisu[] = 'Projekt „S jazyky za prací v Karlovarském kraji“';
        $this->tiskniTitul($textyNadpisu);
        //*****************************************************
        $this->tiskniOsobniUdaje(self::MODEL_DOTAZNIK);
        //********************************************************
        $blok = new Projektor2_PDF_Blok;
            $blok->Nadpis("Preambule");            
            $blok->PridejOdstavec("Druhá část IP obsahuje vyhodnocení účasti klienta v projektu členěné podle absolvovaných aktivit a v případě, že klient nezíská při účasti v projektu zaměstnání, také doporučení vysílajícímu KoP pro další práci s klientem.");
            $blok->predsazeni(0);
            $blok->odsazeniZleva(0);
        $this->pdf->TiskniBlok($blok);        
        //##################################################################################################
        $aktivity = Projektor2_AppContext::getAktivityProjektu('SJZP'); 
            $blok = new Projektor2_PDF_Blok;
                $blok->Nadpis("Individuální plán projektu členěný podle absolvovaných aktivit");            
                $blok->predsazeni(0);
                $blok->odsazeniZleva(0);
            $this->pdf->TiskniBlok($blok);
            $dolniokrajAPaticka = 25;
            $mistoDatumPodpisy = 60;
            Projektor2_View_PDF_Helper_UkonceniAktivitKurz::createContent($this->pdf, $this->context, $this, $dolniokrajAPaticka, $mistoDatumPodpisy);
        //##################################################################################################
        $this->tiskniMistoDatum(self::MODEL_DOTAZNIK, $this->context[self::MODEL_UKONCENI . "datum_vytvor_dok_ukonc"]);
        $this->tiskniPodpisy(self::MODEL_DOTAZNIK);   
        return $this->pdf;
    }
}

?>
