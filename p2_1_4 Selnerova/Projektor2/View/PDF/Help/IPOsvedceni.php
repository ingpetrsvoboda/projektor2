<?php

/*
* První část IP (v rozsahu 1-2 strany A4) – která bude obsahovat:
charakteristiku účastníka (klientovy nacionále, údaje o dosaženém vzdělání a získaných dovednostech, o předchozích pracovních zkušenostech, o zdravotním stavu a charakterových předpokladech, motivaci k práci, potřebách na doplnění vzdělání, představách o dalším pracovním zařazení atd.),
plán účasti v projektu (doporučení aktivit, jichž by se klient měl účastnit, zaměstnavatelů, na které by se měl zaměřit při hledání práce, zjištění zájmu a doporučení pro eventuální zařazení do některého rekvalifikačního kurzu organizovaného a hrazeného mimo tento projekt, apod.).
První část IP je předběžný plán průběhu účasti v projektu, který se může během projektu vyvíjet, tento vývoj bude zachycen ve druhé části IP.
Druhou část IP zpracuje poradce s klientem při ukončení účasti v projektu. Tato část bude obsahovat:
vyhodnocení účasti klienta v projektu (případné změny oproti první části IP, shrnutí absolvovaných aktivit a provedených kontaktů se zaměstnavateli a v případě, že klient nezíská při účasti v projektu zaměstnání, také doporučení vysílajícímu KoP pro další práci s klientem).
Obě části IP budou podepsány poradcem i klientem. Kopie IP budou předány spolu s měsíční zprávou o realizaci Zadavateli a také vysílajícímu KoP.

*/
/**
* Description of 
*
* @author pes2704
*/
class Projektor2_View_PDF_Help_IPOsvedceni extends Projektor2_View_PDF_Common {
    const MODEL_PLAN     = "plan->"; 
    const MODEL_DOTAZNIK = "dotaznik->";

    public function createPDFObject() {
        $textPaticky = "Osvědčení o absolutoriu kurzu v projektu „Help 50+“ ".$this->context["file"];  
        $this->setHeaderFooter($projekt, $textPaticky, FALSE);
        $this->initialize();
        //*****************************************************
        $aktivity = Projektor2_AppContext::getAktivityProjektu('HELP');
        $druh = $this->context['druh'];
        $aktivita = $aktivity[$druh];

        $this->pdf->Image("img/pozadi/pozadi.jpg", 0, 25, 210, 272);  
        $this->pdf->SetXY(0,60);

        $blokCentered = new Projektor2_PDF_Blok;
            $blokCentered->ZarovnaniNadpisu('C');
            $blokCentered->ZarovnaniTextu('C');
        $blokCentered30_14 = clone $blokCentered;
            $blokCentered30_14->VyskaPismaNadpisu(30);
            $blokCentered30_14->VyskaPismaTextu(14);
            $blokCentered30_14->ZarovnaniTextu('C');
        $blokCentered20_11 = clone $blokCentered;
            $blokCentered20_11->VyskaPismaNadpisu(20);
            $blokCentered20_11->VyskaPismaTextu(11);
            $blokCentered20_11->ZarovnaniTextu('C');           
        
        $blok = clone $blokCentered30_14;
            $blok->PridejOdstavec('Grafia, společnost s ručením omezeným');
            $blok->PridejOdstavec('se sídlem Budilova 4, 301 21 Plzeň');
            $blok->PridejOdstavec('IČ: 477 14 620');
            $blok->PridejOdstavec('');
            $blok->PridejOdstavec('uděluje');
        $this->pdf->TiskniBlok($blok);
        
        $blok = clone $blokCentered30_14;
            $blok->Nadpis("CERTIFIKÁT");
            $blok->PridejOdstavec('č. '.$this->context['cisloCertifikatu']);
        $this->pdf->TiskniBlok($blok);

        $blok = clone $blokCentered30_14;
            $blok->PridejOdstavec('o absolutoriu kurzu');
        $this->pdf->TiskniBlok($blok);
        
        $blok = clone $blokCentered30_14;
            $blok->Nadpis($aktivita['nadpis']);  
            $blok->PridejOdstavec('v projektu „Help 50+“');
        $this->pdf->TiskniBlok($blok);

        $blok = clone $blokCentered20_11;
            $blok->PridejOdstavec(self::STALY_TEXT_PATICKY);
        $this->pdf->TiskniBlok($blok);        
        
        $blok = clone $blokCentered30_14;
            $blok->Nadpis($this->celeJmeno(self::MODEL_DOTAZNIK));
        $this->pdf->TiskniBlok($blok);

        $blok = clone $blokCentered30_14;
        if ($this->context[self::MODEL_DOTAZNIK.'pohlavi'] == 'muž') {
            $abs = 'absolvoval';
        } else {
            $abs = 'absolvovala';            
        }
        
        if ($this->context[$druh.'_kurz']->date_zacatek == $this->context[$druh.'_kurz']->date_konec) {
            $blok->PridejOdstavec('úspěšně '.$abs.' kurz dne '.$this->datumBezNul($this->context[$druh.'_kurz']->date_zacatek));
        } else {
            $blok->PridejOdstavec('úspěšně '.$abs.' kurz od '.$this->datumBezNul($this->context[$druh.'_kurz']->date_zacatek)
                                    .' do '.$this->datumBezNul($this->context[$druh.'_kurz']->date_konec));
        }

        if ($this->context[$druh.'_kurz']->pocet_hodin) {
            $blok->PridejOdstavec('s plánovaným rozsahem '.$this->context[$druh.'_kurz']->pocet_hodin.' hodin');
        }
//        $blok->PridejOdstavec('v rozsahu '.$this->context[self::MODEL_PLAN .$druh.'_poc_abs_hodin'].' hodin');
        $this->pdf->TiskniBlok($blok);        
        

        
        
        //##################################################################################################
        $this->tiskniMistoDatum(self::MODEL_DOTAZNIK, $this->context[self::MODEL_PLAN .$druh."_datum_certif"]);
        $this->pdf->Ln(20);
        $this->tiskniPodpisCertifikat();      
    }
}
?>
