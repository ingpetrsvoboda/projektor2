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
class Projektor2_View_PDF_Help_Smlouva extends Projektor2_View_PDF_Common{
    const MODEL_SMLOUVA = "smlouva->";   //--vs
    
    public function createPDFObject() {
        $textPaticky = "Dohoda o účasti v projektu „Help 50+“ ".$this->context["file"];  
        $this->setHeaderFooter($projekt, $textPaticky);
        $this->initialize();
        //*****************************************************
        $textyNadpisu[] = "DOHODA O ÚČASTI V PROJEKTU ";
        $textyNadpisu[] = 'Projekt „Help 50+“';
        $this->tiskniTitul($textyNadpisu, TRUE);
        //*****************************************************
        $strany = new Projektor2_PDF_Blok;
        $strany->Nadpis("S t r a n y   d o h o d y ");
        $strany->MezeraPredNadpisem(0);
        $strany->ZarovnaniNadpisu("L");
        $strany->VyskaPismaNadpisu(11);
        $this->pdf->TiskniBlok($strany);
        $this->pdf->Ln(2);
        
        $this->TiskniGrafiaUdaje();
        $this->pdf->Ln(2);

        $a = new Projektor2_PDF_Blok;
        $a->Odstavec("a        ");
        $this->pdf->TiskniBlok($a);
        $this->pdf->Ln(2);

        $this->tiskniOsobniUdaje(self::MODEL_SMLOUVA);  //--vs
        $this->pdf->Ln(2);

        $spolecneUzaviraji = new Projektor2_PDF_Blok;
        $spolecneUzaviraji->Odstavec("Příjemce a Účastník společně (dále jen „Strany dohody“) a každý z nich (dále jen „Strana dohody“) uzavírají níže uvedeného dne, měsíce a roku tuto dohodu:" );
        $this->pdf->TiskniBlok($spolecneUzaviraji);
        $this->tiskniTitul($textyNadpisu, FALSE);
        $this->pdf->Ln(2);

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
//        
//        //**********************************************
//            $pdfdebug = Projektor2_PDFContext::getDebug();
//            $pdfdebug->debug(0);
//            ob_clean;
//            $this->pdf = new Projektor2_PDF_VytvorPDF ();
//            $this->pdf->AddFont('Times','','times.php');
//            $this->pdf->AddFont('Times','B','timesbd.php');
//            $this->pdf->AddFont("Times","BI","timesbi.php");
//            $this->pdf->AddFont("Times","I","timesi.php");
//        //**********************************************
//            $textPaticky = "Dohoda o účasti v projektu „Help 50+“ ".self::FILE_NAME_PREFIX. @$this->context["identifikator"].
//                                "\n Projekt Help 50+ CZ.1.04/3.3.05/96.00249 je financován z Evropského sociálního fondu prostřednictvím OP LZZ a ze státního rozpočtu ČR.";
//            $this->setHeaderFooter($projekt, $textPaticky);
//        //********************************************** 
//        $textyNadpisu[] = "DOHODA O ÚČASTI V PROJEKTU ";
//        $textyNadpisu[] = 'Projekt „Help 50+“';
//        $this->tiskniTitul($textyNadpisu);
//        //*****************************************************           
//            $this->pdf->AddPage();   //dalsi stranky
//            $strany = new Projektor2_PDF_Blok;
//                    $strany->Nadpis("S t r a n y   d o h o d y ");
//                    $strany->MezeraPredNadpisem(5);
//                    $strany->ZarovnaniNadpisu("L");
//                    $strany->VyskaPismaNadpisu(11);
//            $this->pdf->TiskniBlok($strany);
//
//            $stranaPrijemce = new Projektor2_PDF_Blok;
//                $stranaPrijemce->Odstavec("Grafia, společnost s ručením omezeným" . chr(13) . chr(10).
//                                "zapsaná v obchodním rejstříku vedeném Krajským soudem v Plzni, odd. C, vl. 3067" . chr(13) . chr(10).
//                                "sídlo: Plzeň, Budilova 4, PSČ 301 21" . chr(13) . chr(10).
//                                "zastupující: Mgr. Jana Brabcová, jednatelka společnosti" . chr(13) . chr(10).
//                                "IČ: 47714620" . chr(13) . chr(10).
//                                "DIČ: CZ 47714620" . chr(13) . chr(10).
//                                "bankovní spojení: ČSOB" . chr(13) . chr(10).
//                                "č. účtu:  275795033/0300" . chr(13) . chr(10).
//                                "zapsán v obchodním rejstříku vedeném Krajským soudem v Plzni, v oddílu C vložka 3067" . chr(13) . chr(10).
//                                "(dále jen „Příjemce dotace“)" . chr(13) . chr(10));
//                $stranaPrijemce->MezeraPredNadpisem(10);
//                $stranaPrijemce->Radkovani(1);
//            $this->pdf->TiskniBlok($stranaPrijemce);
//
//            $a = new Projektor2_PDF_Blok;
//                $a->Odstavec("a        ");
//                $a->MezeraPredNadpisem(10);
//            $this->pdf->TiskniBlok($a);
//            //*****************************************************
//            $this->tiskniOsobniUdaje();
//            //*****************************************************
//            $this->pdf->Ln(5);
//
//            $spolecneUzaviraji = new Projektor2_PDF_Blok;
//                $spolecneUzaviraji->Odstavec("Příjemce a Účastník společně (dále jen „Strany dohody“) a každý z nich (dále jen „Strana dohody“) uzavírají níže uvedeného dne, měsíce a roku tuto" );
//            $this->pdf->TiskniBlok($spolecneUzaviraji);
//
//            $dohoda1 = new Projektor2_PDF_Blok;
//                $dohoda1->Nadpis("DOHODU O ÚČASTI V PROJEKTU");
//                $dohoda1->MezeraPredNadpisem(5);
//                $dohoda1->ZarovnaniNadpisu("C");
//                $dohoda1->VyskaPismaNadpisu(12);
//            $this->pdf->TiskniBlok($dohoda1);
//
//            $dohoda2 = new Projektor2_PDF_Blok;
//                $dohoda2->Nadpis("„Help 50+“");
//                $dohoda2->MezeraPredNadpisem(0);
//                $dohoda2->ZarovnaniNadpisu("C");
//                $dohoda2->VyskaPismaNadpisu(12);
//            $this->pdf->TiskniBlok($dohoda2);
//        //********************************************************
        //##################################################################################################
        $blok = clone $defaultBlokCislovani2;
            $blok->Nadpis("1. PREAMBULE");
            $blok->Odstavec("1.1 Účelem dohody uzavírané ve smyslu ustanovení § 51 zákona č. 40/1964 Sb., občanského zákoníku, ve znění pozdějších předpisů, a také na základě zákona č. 435/2004 Sb., o zaměstnanosti, a podle souvisejících předpisů, je úprava vzájemného vztahu mezi účastníkem a Příjemcem při provádění aktivit projektu pro fyzické osoby účastnící se grantového projektu implementovaném v Operačním programu Lidské zdroje a zaměstnanost: HELP 50+.");
            $blok->PridejOdstavec("1.2 Projekt představuje soubor aktivit a nástrojů určených pro dosažení cílů projektu. Hlavním cílem „Help 50+“ je snižování nezaměstnanosti a předcházení dlouhodobé nezaměstnanosti v Plzeňském kraji. Projekt je zaměřen na udržení a obnovení profesní orientace nebo získání nových dovedností a posílení profesního sebevědomí klientů, kteří díky svému věku a dalším handicapům potřebují pomoc při udržení na trhu práce.");
        $this->pdf->TiskniBlok($blok);

        $blok = clone $defaultBlokCislovani2;
            $blok->Nadpis("2. Předmět dohody");
            $blok->Odstavec("2.1 Předmětem dohody je stanovení podmínek účasti Účastníka na aktivitách projektu Help 50+ a úprava práv a povinností Stran dohody při realizaci těchto aktivit.");
        $this->pdf->TiskniBlok($blok);

        $blok = clone $defaultBlokCislovani2;
            $blok->Nadpis("3. Povinnosti a práva účastníka projektu „Help 50+“");
            $blok->Odstavec("3.1 Účastník potvrzuje, že se účastnil výběrové schůzky, kde byl seznámen s prezentací projektu Help 50+.");
            $blok->PridejOdstavec("3.2 Účastník se dále zavazuje k tomu, že v dohodnutém termínu schůzky se osobně dostaví do Konzultačního centra, kde poskytne své osobní údaje, údaje o svém vzdělání a předchozích zaměstnáních a další údaje na jejichž základě mu bude vypracován Individuální plán. Účastník se zavazuje, že poskytne Příjemci v maximální míře kopie dokladů osvědčujících uváděné skutečnosti, zejména doklady o ukončeném vzdělání, kurzech a předchozích zaměstnáních.");
            $blok->PridejOdstavec("3.3 Individuální plán se skládá ze dvou částí:");
        $this->pdf->TiskniBlok($blok);

        $blok = clone $odsazenyBlokCislovani2;
            $blok->Odstavec("a) První část individuálního plánu obsahuje charakteristiku účastníka, která zahrnuje jeho nacionále, údaje o dosaženém vzdělání a získaných dovednostech, o předchozích pracovních zkušenostech, o zdravotním stavu a charakterových předpokladech, motivaci k práci, potřebách na doplnění vzdělání, představách o jeho dalším pracovním zařazení atd.");
            $blok->PridejOdstavec("b) Další část individuálního plánu bude dle vyhodnocení první části sestavený plán účasti v projektu, tedy doporučení aktivit, jichž by se klient měl účastnit, zaměstnavatelů, na které by se měl zaměřit při hledání práce atd.");
            $blok->PridejOdstavec("c) Individuální plán se bude na schůzkách účastníka s poradcem v Konzultačním centru průběžně aktualizovat, doplňovat anebo měnit.");
        $this->pdf->TiskniBlok($blok);

        $blok = clone $defaultBlokCislovani2;
            $blok->Odstavec("3.4 Účastník se zavazuje informovat Příjemce o všech skutečnostech, souvisejících s jeho účastí na projektu, zejména o důvodech absence a o překážkách bránících mu v účasti na aktivitách projektu.");
            $blok->PridejOdstavec("3.5 Účastník se zavazuje k tomu, že veškeré absence na aktivitách, jichž se dle Individuálního plánu má účastnit, do 3 dnů řádně omluví, a to dokladem prokazujícím nemoc, návštěvu lékaře, ošetřování člena rodiny, případně jiným dokladem prokazujícím důvod absence.");
            $blok->PridejOdstavec("3.6 Účastník se zavazuje potvrzovat Příjemci podpisy v Prezenčních listinách nebo v Návštěvní knize svou účast (případně informace o nenastoupení) ve všech aktivitách projektu.");
            $blok->PridejOdstavec("3.7 Účastník se rovněž zavazuje:");
        $this->pdf->TiskniBlok($blok);

        $blok = clone $odsazenyBlokCislovani2;
            $blok->Odstavec("a) docházet do příslušného Konzultačního centra na dohodnuté schůzky a spolupracovat s konzultanty projektu v této kanceláři a dalšími pracovníky projektu");
            $blok->PridejOdstavec("b) účastnit se doporučených aktivit uvedených v jednotlivých částech a dodatcích Individuálního plánu");
            $blok->PridejOdstavec("c) účastnit se kurzů projektu Help 50+.");
        $this->pdf->TiskniBlok($blok);

        $blok = clone $defaultBlokCislovani2;
            $blok->Odstavec("3.8 Účastník souhlasí se svým uvedením v seznamu účastníků zařazených do rekvalifikace.");
            $blok->PridejOdstavec("3.9 Účastník, který získal zaměstnání anebo se sebezaměstnal v průběhu své účasti v projektu anebo do 2 měsíců od ukončení účasti:");            
        $this->pdf->TiskniBlok($blok);

        $blok = clone $odsazenyBlokCislovani2;
            $blok->Odstavec("a) zavazuje se informovat do 3 pracovních dnů Příjemce o této skutečnosti");
            $blok->PridejOdstavec("b) souhlasí se svým uvedením v seznamu osob, které získaly ve stanovené době zaměstnání anebo se sebezaměstnaly");
            $blok->PridejOdstavec("c) účastník, který získal zaměstnání, se zavazuje dodat Příjemci kopii své uzavřené pracovní smlouvy");
            $blok->PridejOdstavec("d) účastník, který se sebezaměstnal, doloží Příjemci písemné potvrzení Úřadu práce o ukončení evidence účastníka na vlastní žádost a prohlášení účastníka o podnikání kroků k zahájení podnikání, výpis nebo kopii výpisu z Živnostenského rejstříku potvrzující jeho oprávnění k podnikání.");
            $blok->predsazeni(3);
            $blok->odsazeniZleva(12);
        $this->pdf->TiskniBlok($blok);

        $blok = clone $defaultBlokCislovani2;
            $blok->Odstavec("3.10 Účastník se zavazuje podrobit se závěrečnému ověření získaných znalostí a dovedností v každé aktivitě, která to předpokládá.");
        $this->pdf->TiskniBlok($blok);

        $blok = clone $defaultBlokCislovani2;
            $blok->Nadpis("4.  Ukončení účasti účastníka v projektu");
            $blok->Odstavec("4.1  K ukončení účasti účastníka v projektu Help 50+ dojde v následujících případech:");
        $this->pdf->TiskniBlok($blok);

        $blok = clone $defaultBlokCislovani3;
            $blok->Odstavec("4.1.1  uplynutím doby určené pro účast účastníka v projektu v případě řádného absolvování projektu účastníkem.");
            $blok->PridejOdstavec("4.1.2 předčasným ukončení účasti ze strany účastníka:");
        $this->pdf->TiskniBlok($blok);

        $blok = clone $odsazenyBlokCislovani3;
            $blok->Odstavec("a) nástupem účastníka do pracovního poměru anebo zahájením podnikání účastníka (sebezaměstnáním), k ukončení dojde dnem nástupu účastníka do pracovního poměru anebo dnem sebezaměstnání účastníka (dnem zahájení podnikání)");
            $blok->PridejOdstavec("b)  výpovědí této Dohody o účasti v projektu účastníkem z jiného důvodu než nástupu do zaměstnání, k ukončení dojde v den, kdy byla výpověď doručena Příjemci");
        $this->pdf->TiskniBlok($blok);

        $blok = clone $defaultBlokCislovani3;
            $blok->Odstavec("4.1.3 předčasným ukončením účasti ze strany Příjemce, jestliže účastník porušuje podmínky účasti v projektu, neplní své povinnosti při účasti na aktivitách projektu (zejména na rekvalifikaci) anebo jiným závažným způsobem maří účel účasti v projektu.");
        $this->pdf->TiskniBlok($blok);

        $blok = clone $defaultBlokCislovani2;
            $blok->Odstavec("4.2 V případě, že tato Dohoda bude ze strany Příjemce vypovězena, platí, že vypovězením této Dohody zanikají veškeré závazky Příjemce vůči účastníkovi plynoucí z této Dohody s výjimkou závazku uhradit platby přímé podpory za dobu účastni účastníka v projektu. K ukončení účasti dojde dnem, kdy byla výpověď účastníkovi doručena nebo třicátý den od odeslání.");
            $blok->PridejOdstavec("4.3 Účastník se zavazuje, že se dostaví do Konzultačního centra a podepíše doklad o ukončení účasti účastníka v projektu Help 50+, pokud nebude dohodnuto jinak. Přílohou tohoto dokladu bude například kopie pracovní smlouvy, kopie výpovědi, atd.");
            $blok->PridejOdstavec("4.4 Po ukončení účasti účastníka v projektu Help 50+ řádným způsobem anebo z důvodu nástupu do zaměstnání získá účastník Osvědčení o absolvování projektu Help 50+.");
            $blok->PridejOdstavec("4.5 Po absolvování kurzů Motivační kurz a kurz orientace na trhu práce Příjemce zajistí, že účastník obdrží Osvědčení o absolvování tohoto kurzu.");
            $blok->PridejOdstavec("4.6 Po ukončení rekvalifikačního kurzu (zahrnujícího rekvalifikační kurzy a kurzy obsluhy PC) Příjemce zajistí, že rekvalifikační zařízení zhotoví a předá účastníkovi, který kurz úspěšně absolvoval, Osvědčení o rekvalifikaci (případně jiné doklady, například průkazy atd.).");
            $blok->PridejOdstavec("4.7 Příjemce založí každému účastníkovi jeho Osobní složku, do které bude zakládat, počínaje touto Dohodou o účasti v projektu a Souhlasem s poskytnutím a zpracováním osobních údajů, všechny dokumenty vztahující se k jeho účasti v projektu. Osobní složky budou uloženy po dobu trvání plnění projektu v příslušném Konzultačním centru projektu. Osobní složka každého účastníka projektu bude pro konkrétního účastníka přístupná v době dohodnuté konzultační schůzky v Konzultačním centru.");
        $this->pdf->TiskniBlok($blok);

        $blok = clone $defaultBlokCislovani2;
            $blok->Nadpis("5. Doprovodná opatření – druhy přímé podpory pro účastníky:");
            $blok->Odstavec("5.1. Účastníkovi mohou být při účasti na aktivitách projektu poskytovány příspěvky na náhradu některých nákladů souvisejících s účastí v projektu (tzv. přímá podpora), a to za podmínek stanovených projektem Help 50+. Jedná se o tyto příspěvky:");
        $this->pdf->TiskniBlok($blok);

        $blok = clone $odsazenyBlokCislovani2;
            $blok->Odstavec("a) příspěvek na jízdné");
            $blok->PridejOdstavec("b) příspěvek na stravné");
            $blok->PridejOdstavec("c) příspěvek na vyjádření o zdravotním stavu před nástupem do rekvalifikačního kurzu");
            $blok->PridejOdstavec("d) příspěvek na zabezpečení jiných výdajů souvisejících s projektem");
        $this->pdf->TiskniBlok($blok);

        $blok = clone $defaultBlokCislovani2;
            $blok->Odstavec("5.2. Bližší specifikace uvedených druhů přímé podpory je uvedena v dokumentu Základní informace účastníka projektu Help 50+.");
        $this->pdf->TiskniBlok($blok);

        $blok = clone $defaultBlokCislovani2;
            $blok->Nadpis("6.  Povinnosti Příjemce");
            $blok->Odstavec("6.1 Příjemce se zavazuje poskytnout Účastníkovi zdarma aktivity projektu. Příjemce je povinen vyvinout úsilí k tomu, aby zabezpečil účastníkovi absolvování aktivit doporučených v Individuálním plánu.");
            $blok->PridejOdstavec("6.2 Příjemce musí informovat účastníka o všech podmínkách účasti v kurzu (například potvrzení od lékaře, nutné očkování) a umožnit mu jejich obstarání.");
        $this->pdf->TiskniBlok($blok);

        $blok = clone $defaultBlokCislovani2;
            $blok->Nadpis("7.  Ochrana osobních údajů účastníků");
            $blok->Odstavec("7.1 Účastník souhlasí s poskytnutím a zpracováváním svých osobních údajů pro účely projektu, v souladu se zákonem č. 101/2000 Sb., zákon o ochraně osobních údajů. Tyto údaje může Příjemce poskytnout třetí straně - potenciálnímu zaměstnavateli za účelem zprostředkování zaměstnání účastníkovi projektu. Tuto skutečnost účastník potvrzuje podpisem této Dohody.");
        $this->pdf->TiskniBlok($blok);

        $blok = clone $defaultBlokCislovani2;
            $blok->Nadpis("8 Závěrečná ustanovení");
            $blok->Odstavec("8.1 Tuto Dohodu lze měnit či doplňovat pouze po dohodě smluvních stran formou písemných a číslovaných dodatků");
            $blok->PridejOdstavec("8.2 Tato Dohoda je sepsána ve třech vyhotoveních s platností originálu, přičemž Účastník obdrží jedno a Příjemce dvě vyhotovení.");
            $blok->PridejOdstavec("8.3 Tato Dohoda nabývá platnosti a účinnosti dnem jejího podpisu oběma smluvními stranami; tímto dnem jsou její účastníci svými projevy vázáni.");
            $blok->PridejOdstavec("8.4 Příjemce i Účastník shodně prohlašují, že si tuto Dohodu před jejím podpisem přečetli, že byla uzavřena podle jejich pravé a svobodné vůle, určitě, vážně a srozumitelně, nikoliv v tísni za nápadně nevýhodných podmínek. Smluvní strany potvrzují autentičnost této Dohody svým podpisem.");
        $this->pdf->TiskniBlok($blok);

        //##################################################################################################
        $this->pdf->Ln(5);
        $this->tiskniMistoDatum(self::MODEL_SMLOUVA, $this->context[self::MODEL_SMLOUVA ."datum_vytvor_smlouvy"]);
        $this->tiskniPodpisy(self::MODEL_SMLOUVA);
    }
}

?>
