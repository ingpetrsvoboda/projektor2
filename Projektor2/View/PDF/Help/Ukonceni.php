<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HeSmlouva
 *
 * @author pes2704
 */
class Projektor2_View_PDF_Help_Ukonceni extends Projektor2_View_PDF_Help_Common {
    const MODEL_UKONCENI = "ukonceni->";
    const MODEL_DOTAZNIK = "dotaznik->";
    
    public function createPDFObject() {
        $textPaticky = "Ukončení účasti účastníka v projektu ".$this->context["file"]; 
        $this->setHeaderFooter($textPaticky);
        $this->initialize();
        //*****************************************************
        $textyNadpisu[] = "UKONČENÍ ÚČASTI V PROJEKTU";
        $textyNadpisu[] = 'Projekt „Help 50+“';
        $this->tiskniTitul($textyNadpisu, FALSE);
        //*****************************************************        
        $this->tiskniOsobniUdaje(self::MODEL_DOTAZNIK);
        //**********************************************     
        
        $ukonceniUcasti = new Projektor2_PDF_SadaBunek();
            $ukonceniUcasti->Nadpis("Údaje o účasti v projektu");
            $ukonceniUcasti->PridejBunku("Datumu zahájení účasti v projektu: ", $this->context[self::MODEL_DOTAZNIK."datum_vytvor_smlouvy"]);
            $ukonceniUcasti->PridejBunku("Datum ukončení účasti v projektu: ", $this->context[self::MODEL_UKONCENI.'datum_ukonceni'], 1);

            $duvod_ukonceni_pole =  explode ("|", @$this->context[self::MODEL_UKONCENI.'duvod_ukonceni']);
            $ukonceniUcasti->PridejBunku("Důvod ukončení účasti v projektu: ", $duvod_ukonceni_pole[0],1);
            if ( ($duvod_ukonceni_pole[0] == "2b ") or ($duvod_ukonceni_pole[0]== "3a ")  or ($duvod_ukonceni_pole[0] == "3b ")
                  and $this->context[self::MODEL_UKONCENI.'popis_ukonceni']
                ) {
                $ukonceniUcasti->PridejBunku("Podrobnější popis důvodu ukončení účasti v projektu: ", " " ,1);
                $ukonceniUcasti1 = new Projektor2_PDF_Blok;
                $ukonceniUcasti1->Odstavec($this->context[self::MODEL_UKONCENI.'popis_ukonceni']);
            }
        $this->pdf->TiskniSaduBunek($ukonceniUcasti);
        if ($ukonceniUcasti1) $this->pdf->TiskniBlok($ukonceniUcasti1);
        $pozn = new Projektor2_PDF_Blok;
            $pozn->Nadpis("Možné důvody:");
            $pozn->Odstavec("1. řádné absolvování projektu");
            $pozn->PridejOdstavec("2. předčasným ukončením účasti ze strany klienta");
            $pozn->VyskaPismaNadpisu(8);
            $pozn->VyskaPismaTextu(8);
        $this->pdf->TiskniBlok($pozn);
        $pozn = new Projektor2_PDF_Blok;
            $pozn->Odstavec("a. dnem předcházejícím nástupu klienta do pracovního poměru (ve výjimečných případech může být dohodnuto jinak)");
            $pozn->PridejOdstavec("b. výpovědí dohody o účasti v projektu účastníkem nebo ukončením dohody z jiného důvodu než nástupu do zaměstnání (ukončení bude v den předcházející dni vzniku důvodu ukončení)");
            $pozn->VyskaPismaTextu(8);
            $pozn->OdsazeniZleva(3);
            $pozn->Predsazeni(3);
        $this->pdf->TiskniBlok($pozn);
        $pozn = new Projektor2_PDF_Blok;
            $pozn->Odstavec("3. předčasným ukončením účasti ze strany dodavatele");
            $pozn->VyskaPismaTextu(8);
        $this->pdf->TiskniBlok($pozn);
        $pozn = new Projektor2_PDF_Blok;
            $pozn->Odstavec("a. pokud účastník porušuje podmínky účasti v projektu, neplní své povinnosti při účasti na aktivitách projektu (zejména na rekvalifikaci) nebo jiným závažným způsobem maří účel účasti v projektu");
            $pozn->PridejOdstavec("b. ve výjimečných případech na základě podnětu vysílajícího ÚP, např. při sankčním vyřazení z evidence ÚP (ukončení bude v pracovní den předcházející dni vzniku důvodu ukončení)");
            $pozn->VyskaPismaTextu(8);
            $pozn->OdsazeniZleva(3);
            $pozn->Predsazeni(3);
        $this->pdf->TiskniBlok($pozn); 
        
        //##################################################################################################
        $this->tiskniMistoDatum(self::MODEL_UKONCENI, $this->context[self::MODEL_UKONCENI."datum_vytvor_dok_ukonc"]);
        $this->tiskniPodpisy(self::MODEL_DOTAZNIK);    
    }
}

?>
