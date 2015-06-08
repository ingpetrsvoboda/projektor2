<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AgpSmlouva
 *
 * @author pes2704
 */
class Projektor2_View_PDF_Agp_Smlouva extends Projektor2_View_PDF_Common{
    const MODEL_SMLOUVA = "smlouva->";   //--vs   
    
    public function createPDFObject() {
        
        $textPaticky = "Dohoda o zprostředkování zaměstnání v projektu Personal Service  Zájemce: " .
                        @$this->context["identifikator"]."\n" .$this->context["file"];       
        $this->setHeaderFooter($textPaticky);
        $this->initialize();
        //*****************************************************
        $textyNadpisu[] = "DOHODA O ZPROSTŘEDKOVÁNÍ ZAMĚSTNÁNÍ ";
        $textyNadpisu[] = '„Personal Service“';
        $this->tiskniTitul($textyNadpisu, TRUE);
        //*****************************************************
  
        $strany = new Projektor2_PDF_Blok;
        $strany->Nadpis("S t r a n y   d o h o d y ");
        $strany->MezeraPredNadpisem(0);
        $strany->ZarovnaniNadpisu("L");
        $strany->VyskaPismaNadpisu(11);
        $this->pdf->TiskniBlok($strany);
        $this->pdf->Ln(2);
        
        $this->tiskniGrafiaUdaje();
        $this->pdf->Ln(2);

        $a = new Projektor2_PDF_Blok;
        $a->Odstavec("a        ");
        $this->pdf->TiskniBlok($a);
        $this->pdf->Ln(2);

        $this->tiskniOsobniUdaje(self::MODEL_SMLOUVA);  //--vs
        $this->pdf->Ln(2);

        $spolecneUzaviraji = new Projektor2_PDF_Blok;
        $spolecneUzaviraji->Odstavec("Dodavatel a Zájemce společně (dále jen „Strany dohody“) a každý z nich (dále jen „Strana dohody“) ".
                                     "uzavírají níže uvedeného dne, měsíce a roku tuto dohodu:" );        
        $this->pdf->TiskniBlok($spolecneUzaviraji);
        $this->pdf->Ln(3);
        $this->tiskniTitul($textyNadpisu, FALSE);

        //******************************************************** 
        //********************************************************
        $odsazeniTextuZleva = 0;
        $sirkaCisla = 3;
        
        $defaultBlok = new Projektor2_PDF_Blok;
        $defaultBlok->OdsazeniZleva($odsazeniTextuZleva); 
        
        $defaultBlokCislovani1 = clone $defaultBlok;
        $defaultBlokCislovani1->Predsazeni($sirkaCisla);
        
        $odsazenyBlokCislovani1 = clone $defaultBlokCislovani1;
        $odsazenyBlokCislovani1->OdsazeniZleva($defaultBlokCislovani1->odsazeniZleva + $sirkaCisla);
        
        $defaultBlokCislovani2 = clone $defaultBlokCislovani1;
        $defaultBlokCislovani2->Predsazeni($defaultBlokCislovani1->predsazeni + $sirkaCisla);
        
        $odsazenyBlokCislovani2 = clone $odsazenyBlokCislovani1;
        $odsazenyBlokCislovani2->OdsazeniZleva($odsazenyBlokCislovani1->odsazeniZleva + $sirkaCisla);

        $defaultBlokCislovani3 = clone $defaultBlokCislovani2;
        $defaultBlokCislovani3->predsazeni($defaultBlokCislovani2->predsazeni + $sirkaCisla);
        
        $odsazenyBlokCislovani3 = clone $odsazenyBlokCislovani2;
        $odsazenyBlokCislovani3->OdsazeniZleva($odsazenyBlokCislovani2->odsazeniZleva + $sirkaCisla);
        //********************************************************
        
        
        
$blok = clone $defaultBlokCislovani2;
    $blok->Nadpis("1. PREAMBULE");
    $blok->Odstavec("1.1 Projekt „Personal Service“ je projekt společnosti Grafia, s.r.o., Plzeň.");
    $blok->PridejOdstavec("1.2 Hlavním cílem aktivit projektu „Personal Service“  pro Zájemce je zprostředkování zaměstnání. Zprostředkováním zaměstnání pro účly této dohody se rozumí vyhledání zaměstnání pro fyzickou osobu, která se o práci uchází (Zájemce), a vyhledání zaměstnanců pro zaměstnavatele, který hledá nové pracovní síly.");
    $this->pdf->TiskniBlok($blok);
        
$blok = clone $defaultBlokCislovani2;    
    $blok -> Nadpis("2. Předmět dohody");
    $blok->Odstavec("2.1. Předmětem dohody je stanovení podmínek účasti Zájemce na aktivitách projektu Personal Service a úprava práv a povinností Stran dohody při realizaci těchto aktivit.");
    $this->pdf->TiskniBlok($blok);

$blok = clone $defaultBlokCislovani2;
    $blok -> Nadpis("3. Povinnosti a práva Zájemce o služby projektu „Personal Service“");
    $blok->Odstavec("3.1. Zájemce potvrzuje, že se účastnil vstupní schůzky, kde sdělil údaje pro tuto dohodu a registrační dotazník. Současně Zájemce souhlasí se zpracováním osobních údajů pro účely zprostředkování zaměstnání a poskytování dalších služeb projektu Personal Service.");
    $blok->PridejOdstavec("3.2. Zájemce se zavazuje k tomu, že se bude v dohodnutých termínech účastnit schůzek a dalších aktivit projektu Personal Service. Zájemce se zavazuje, že poskytne Dodavateli v maximální míře kopie dokladů osvědčujících uváděné skutečnosti, zejména doklady o ukončeném vzdělání, kurzech a předchozích zaměstnáních. Porušení těchto závazků může být důvodem okamžité výpovědi této dohody ze strany Dodavatele. ");
    $blok->PridejOdstavec("3.3. Zájemce se zavazuje bezodkladně informovat Dodavatele o všech skutečnostech, souvisejících s jeho účastí na projektu, zejména o důvodech absence na aktivitách projektu a o překážkách bránících mu v účasti na pohovorech a výběrových řízeních u potenciálních zaměstnavatelů.");
    $blok->PridejOdstavec("3.4. Zájemce souhlasí se zařazením do databáze zájemců o zaměstnání Personal service, kterou vlastní Dodavatel, a s poskytováním osobních, vzdělanostních, kvalifikačních a dalších údajů potenciálním zaměstnavatelům za účelem zprostředkování zaměstnání u těchto zaměstnavatelů.");
    $blok->PridejOdstavec("3.5. Zájemce, který získal zaměstnání anebo se sebezaměstnal v průběhu své účasti v projektu anebo kdykoli v případě, že získal zaměstnání na základě doporučení Dodavatele:");
    $this->pdf->TiskniBlok($blok);

$blok = clone $defaultBlokCislovani2;    
    $blok->Odstavec("a)   zavazuje se informovat do 3 pracovních dnů Dodavatele o této skutečnosti");
    $blok->PridejOdstavec("b)   souhlasí se svým uvedením v seznamu osob, které získaly pomocí služeb Personal Service zaměstnání anebo se sebezaměstnaly, a to bez uvedení osobních údajů, tedy anonymně.");
    $blok->PridejOdstavec("c)   Zájemce, který získal zaměstnání na základě doporučení Dodavatele, se zavazuje dodat Dodavateli kopii těch částí své uzavřené pracovní smlouvy, dohody či obdobné smlouvy, z nichž bude zřejmý zaměstnavatel, datum zahájení pracovního poměru, pracovní pozice, případně náplň práce. Zájemce může poskytnout i údaj o své skutečné nástupní mzdě nebo platu, pokud se nezavázal tento údaj nesdělovat a pokud to sám uzná za přijatelné.");
    $this->pdf->TiskniBlok($blok);

$blok = clone $defaultBlokCislovani2;    
    $blok->Nadpis("4. Ukončení dohody");
    $blok->Odstavec("4.1. Tuto dohodu lze ukončit dohodou stran nebo jednostranou výpovědí jedné smluvní strany. K ukončení účasti výpovědí dojde dnem, kdy byla výpověď doručena druhé smluvní straně.");
    $blok->PridejOdstavec("4.2. Ukončením Dohody zanikají veškeré závazky z této Dohody s výjimkou závazků dle bodu 3.5 . ");
    $this->pdf->TiskniBlok($blok);

$blok = clone $defaultBlokCislovani2;    
    $blok->Nadpis("5. Povinnosti dodavatele");
    $blok->Odstavec("5.1. Dodavatel se zavazuje poskytnout Zájemci zdarma aktivity projektu bezprostředně související se zprostředkováním zaměstnání. Na případné další služby a dodávky se tato dohoda nevztahuje.");
    $blok->PridejOdstavec("5.2. Dodavatel se bude snažit v součinnosti s potenciálním zaměstnavatelem co nejlépe informovat Zájemce o všech podmínkách účasti na pohovorech a výběrových řízeních (například o termínech, místech, nutných dokladech či jejich kopiích, potvrzení od lékaře, nutného očkování).");
    $this->pdf->TiskniBlok($blok);

$blok = clone $defaultBlokCislovani2;
    $blok->Nadpis("6. Závěrečná ustanovení");
    $blok->Odstavec("6.1. Tuto Dohodu lze měnit či doplňovat pouze po dohodě smluvních stran formou písemných a číslovaných dodatků.");
    $blok->PridejOdstavec("6.2. Tato Dohoda je sepsána ve dvou vyhotoveních s platností originálu, přičemž Zájemce i Dodavatel obdrží po jednom vyhotovení.");
    $blok->PridejOdstavec("6.3. Tato Dohoda nabývá platnosti a účinnosti dnem jejího podpisu oběma smluvními stranami; tímto dnem jsou její účastníci svými projevy vázáni.");
    $blok->PridejOdstavec("6.4. Dodavatel i Zájemce shodně prohlašují, že si tuto Dohodu před jejím podpisem přečetli, že byla uzavřena podle jejich pravé a svobodné vůle, určitě, vážně a srozumitelně, nikoliv v tísni za nápadně nevýhodných podmínek. Smluvní strany potvrzují autentičnost této Dohody svým podpisem.");
    $this->pdf->TiskniBlok($blok);
    
 //##################################################################################################
        $this->pdf->Ln(5);
        $this->tiskniMistoDatum(self::MODEL_SMLOUVA, $this->context[self::MODEL_SMLOUVA ."datum_vytvor_smlouvy"]);
        $this->tiskniPodpisy(self::MODEL_SMLOUVA);    
    
        
        
        
    }
}

?>
