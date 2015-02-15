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
* Description of Projektor2_View_PDF_HelpPlanIP1
*
* @author pes2704
*/
class Projektor2_View_PDF_Help_IP2 extends Projektor2_View_PDF_Help_HeaderFooter{
    const MODEL_DOTAZNIK = "dotaznik->";
    const MODEL_PLAN = "plan->";
    const MODEL_UKONCENI = "ukonceni->";
    
    public function createPDFObject() {
        $textPaticky = "Individuální plán účastníka v projektu „Help 50+“ - část 2 ".$this->context["file"].
            "\n Projekt Help 50+ CZ.1.04/3.3.05/96.00249 je financován z Evropského sociálního fondu prostřednictvím OP LZZ a ze státního rozpočtu ČR.";
        $this->setHeaderFooter($textPaticky);
        $this->initialize();
        //*****************************************************
        $textyNadpisu[] = "INDIVIDUÁLNÍ PLÁN ÚČASTNÍKA - část 2";
        $textyNadpisu[] = 'Projekt „Help 50+“';
        $this->tiskniTitul($textyNadpisu);
        //*****************************************************        
        $this->tiskniOsobniUdaje(self::MODEL_DOTAZNIK);
        //**********************************************          
        $blok = new Projektor2_PDF_Blok;
            $blok->Nadpis("Preambule");            
            $blok->PridejOdstavec("Druhá část IP obsahuje vyhodnocení účasti klienta v projektu členěné podle absolvovaných aktivit a v případě, že klient nezíská při účasti v projektu zaměstnání, také doporučení vysílajícímu KoP pro další práci s klientem.");
            $blok->predsazeni(0);
            $blok->odsazeniZleva(0);
        $this->pdf->TiskniBlok($blok);        
        //##################################################################################################
        $blok = new Projektor2_PDF_Blok;
            $blok->Nadpis("Individuální plán projektu členěný podle absolvovaných aktivit");            
            $blok->predsazeni(0);
            $blok->odsazeniZleva(0);
        $this->pdf->TiskniBlok($blok);
        $aktivity = Projektor2_AppContext::getAktivityProjektu(); 
        $count = 1;
        foreach ($aktivity as $druh=>$aktivita) {
            if ($aktivita['typ']=='kurz') {
                if ($this->context[$druh.'_kurz'] AND $this->context[$druh.'_kurz']->kurz_zkratka != '*') {
                    $count++;
                    if (($count % 4)==0) {
                        $this->pdf->AddPage();   //uvodni stranka                    
                    }
                    $kurzSadaBunek = new Projektor2_PDF_SadaBunek();
                    $kurzSadaBunek->SpustSadu(true);
                    $kurzSadaBunek->Nadpis($aktivita['nadpis']);
                    $kurzSadaBunek->MezeraPredNadpisem(4);
                    $kurzSadaBunek->ZarovnaniNadpisu("L");
                    $kurzSadaBunek->VyskaPismaNadpisu(11);
                    $kurzSadaBunek->MezeraPredSadouBunek(1);
                    $kurzSadaBunek->PridejBunku("Název kurzu: ",$this->context[$druh.'_kurz']->kurz_nazev, 1);
                    $kurzSadaBunek->PridejBunku("Termín konání: ",$this->context[$druh.'_kurz']->date_zacatek.' - '.$this->context[$druh.'_kurz']->date_konec, 1);
                    $kurzSadaBunek->PridejBunku("Počet absolvovaných hodin: ", $this->context[self::MODEL_PLAN.$druh.'_poc_abs_hodin'],1);
                    if ($this->context[self::MODEL_PLAN.$druh . '_duvod_absence']) {
                        $kurzSadaBunek->PridejBunku("Důvod absence: ", $this->context[self::MODEL_PLAN.$druh.'_duvod_absence'], 1);
                    }
                    $kurzSadaBunek->PridejBunku("Dokončeno úspěšně: ", $this->context[self::MODEL_PLAN.$druh.'_dokonceno'],1);
                    if ($this->context[self::MODEL_PLAN.$druh.'_dokonceno'] == "Ne") {
                        $kurzSadaBunek->PridejBunku("Důvod neúspěšného ukončení: ", $this->context[self::MODEL_PLAN.$druh.'_duvod_neukonceni'],1);
                    }
                    $this->pdf->TiskniSaduBunek($kurzSadaBunek); 
                    if ($this->context[self::MODEL_PLAN.$druh.'_dokonceno'] == "Ano" AND $aktivita['s_certifikatem']) {
                        $vyhodnoceni=new Projektor2_PDF_Blok();
                        $vyhodnoceni->Nadpis('Osvědčení o absolvování kurzu v projektu Help50+');
                        $vyhodnoceni->vyskaPismaNadpisu(9);
                        $vyhodnoceni->Odstavec("Účastníkovi bylo vydáno osvědčení dne: ".$this->context[self::MODEL_PLAN.$druh.'_datum_certif']);
                        $this->pdf->TiskniBlok($vyhodnoceni);
                    }
                }
            } else {
                    if ($this->context[self::MODEL_PLAN.$druh.'_hodnoceni']) {
                        $vyhodnoceni=new Projektor2_PDF_Blok();
                        $vyhodnoceni->Nadpis($aktivita['nadpis']);
                        $vyhodnoceni->vyskaPismaNadpisu(9);
                        $vyhodnoceni->Odstavec($this->context[self::MODEL_PLAN.$druh.'_hodnoceni']);
                        $this->pdf->TiskniBlok($vyhodnoceni);
                    }                
            }
        }
        
        //##################################################################################################
        $this->tiskniMistoDatum(self::MODEL_DOTAZNIK, $this->context[self::MODEL_PLAN . "datum_upravy_dok_plan"]);
        $this->tiskniPodpisy($this->context[self::MODEL_UKONCENI."datum_vytvor_dok_ukonc"]);
    }

}

?>
