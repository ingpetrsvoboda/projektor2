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
class Projektor2_View_PDF_Ap_Smlouva extends Projektor2_View_PDF_Base{
    const FILE_NAME_PREFIX = "AP_smlouva ";
    
    public function createPDFObject() {
        //**********************************************
            $pdfdebug = Projektor2_PDFContext::getDebug();
            $pdfdebug->debug(0);
            ob_clean;
            $pdf = new Projektor2_PDF_PdfCreator ();
            $pdf->AddFont('Times','','times.php');
            $pdf->AddFont('Times','B','timesbd.php');
            $pdf->AddFont("Times","BI","timesbi.php");
            $pdf->AddFont("Times","I","timesi.php");
        //**********************************************
            $pdfhlavicka = Projektor2_PDFContext::getHlavicka();
                        $pdfhlavicka->zarovnani("C");
                        $pdfhlavicka->vyskaPisma(14);
                        $pdfhlavicka->obrazek("./img/loga/loga_AP_BW.png", null, null,165,12);
            $pdfpaticka = Projektor2_PDFContext::getPaticka();
                        $pdfpaticka->Odstavec("Dohoda o účasti v projektu „Alternativní práce v Plzeňském kraji“ ".self::FILE_NAME_PREFIX. @$this->context["identifikator"].
                                "\n Projekt Alternativní práce v Plzeňském kraji CZ.1.04/2.1.00/70.00055 je financován z Evropského sociálního fondu prostřednictvím OP LZZ a ze státního rozpočtu ČR.");
                        $pdfpaticka->zarovnani("C");
                        $pdfpaticka->vyskaPisma(6);
                        $pdfpaticka->cislovani = true;
        //************************************************
            $titulka1 = new Projektor2_PDF_Blok;
                    $titulka1->Nadpis("DOHODA O ÚČASTI V PROJEKTU ");
                    $titulka1->MezeraPredNadpisem(100);
                    $titulka1->ZarovnaniNadpisu("C");
                    $titulka1->VyskaPismaNadpisu(14);
            $titulka2 = new Projektor2_PDF_Blok;
                    $titulka2->Nadpis('„Alternativní práce v Plzeňském kraji“');
                    $titulka2->MezeraPredNadpisem(10);
                    $titulka2->ZarovnaniNadpisu("C");
                    $titulka2->VyskaPismaNadpisu(14);
            $pdf->AddPage();   //uvodni stranka
            $pdf->TiskniBlok($titulka1);
            $pdf->TiskniBlok($titulka2);
        //*****************************************************
            $pdf->AddPage();   //dalsi stranky
            $strany = new Projektor2_PDF_Blok;
                    $strany->Nadpis("S t r a n y   d o h o d y ");
                    $strany->MezeraPredNadpisem(0);
                    $strany->ZarovnaniNadpisu("L");
                    $strany->VyskaPismaNadpisu(11);
            $pdf->TiskniBlok($strany);

            $stranaPrijemce = new Projektor2_PDF_Blok;
                $stranaPrijemce->Odstavec("Grafia, společnost s ručením omezeným" . chr(13) . chr(10).
                                "zapsaná v obchodním rejstříku vedeném Krajským soudem v Plzni, odd. C, vl. 3067" . chr(13) . chr(10).
                                "sídlo: Plzeň, Budilova 4, PSČ 301 21" . chr(13) . chr(10).
                                "zastupující: Mgr. Jana Brabcová, jednatelka společnosti" . chr(13) . chr(10).
                                "IČ: 47714620" . chr(13) . chr(10).
                                "DIČ: CZ 47714620" . chr(13) . chr(10).
                                "bankovní spojení: ČSOB" . chr(13) . chr(10).
                                "č. účtu:  275795033/0300" . chr(13) . chr(10).
                                "zapsán v obchodním rejstříku vedeném Krajským soudem v Plzni, v oddílu C vložka 3067" . chr(13) . chr(10).
                                "(dále jen „Příjemce dotace“)" . chr(13) . chr(10));
                $stranaPrijemce->MezeraPredNadpisem(3);
                $stranaPrijemce->Radkovani(1);
            $pdf->TiskniBlok($stranaPrijemce);

            $a = new Projektor2_PDF_Blok;
                $a->Odstavec("a        ");
                $a->MezeraPredNadpisem(7);
            $pdf->TiskniBlok($a);

            $stranaUcastnik = new Projektor2_PDF_SadaBunek();
                          $celeJmeno =  @$this->context["titul"]." ".@$this->context["jmeno"]." ".@$this->context["prijmeni"];
                          if (@$this->context["titul_za"]) {
                                $celeJmeno = $celeJmeno.", ".@$this->context["titul_za"];
                          }
                    $stranaUcastnik->PridejBunku("jméno, příjmení, titul: ", $celeJmeno,1);
                        $adresapole="";
                        if (@$this->context["ulice"]) {
                            $adresapole .=   @$this->context["ulice"];
                            if  (@$this->context["mesto"])  {  $adresapole .=  ", ".   @$this->context["mesto"];}
                            if  (@$this->context["psc"])    {  $adresapole .= ", " . @$this->context["psc"]; }
                        } else {
                            if  (@$this->context["mesto"])  {
                                $adresapole .= @$this->context["mesto"];
                                if  (@$this->context["psc"])    {  $adresapole .= ", " . @$this->context["psc"]; }
                            } else {
                                 if  (@$this->context["psc"])  {$adresapole .=  @$this->context["psc"];}
                            }
                        }
                    $stranaUcastnik->PridejBunku("bydliště: ", $adresapole,1);

                    $stranaUcastnik->PridejBunku("nar.: ", @$this->context["datum_narozeni"],1);

                        $adresapole="";
                        if (@$this->context["ulice2"]) {
                            $adresapole .=   @$this->context["ulice2"];
                            if  (@$this->context["mesto2"])  {  $adresapole .= ", " . @$this->context["mesto2"];}
                            if  (@$this->context["psc2"])    {  $adresapole .= ", " . @$this->context["psc2"]; }
                        } else {
                            if  (@$this->context["mesto2"])  {
                                $adresapole .= @$this->context["mesto2"];
                                if  (@$this->context["psc2"])   {  $adresapole .= ", " . @$this->context["psc2"]; }
                            } else {
                                 if  (@$this->context["psc2"])  {  $adresapole .= @$this->context["psc2"];}
                            }
                        }
                    if  ($adresapole)   {
                        $stranaUcastnik->PridejBunku( "adresa dojíždění odlišná od místa bydliště: ", $adresapole,1);
                    }
                    $stranaUcastnik->PridejBunku("identifikační číslo účastníka: ", @$this->context["identifikator"],1);
                    $stranaUcastnik->PridejBunku("identifikační značka účastníka: ", @$this->context["znacka"],1);
                    $stranaUcastnik->PridejBunku("(dále jen „Účastník“)", "",1);
            $pdf->Ln(3);
            $pdf->TiskniSaduBunek($stranaUcastnik);

            $spolecneUzaviraji = new Projektor2_PDF_Blok;
                $spolecneUzaviraji->Odstavec("Příjemce a Účastník společně (dále jen „Strany dohody“) a každý z nich (dále jen „Strana dohody“) uzavírají níže uvedeného dne, měsíce a roku tuto" );
            $pdf->TiskniBlok($spolecneUzaviraji);

            $dohoda1 = new Projektor2_PDF_Blok;
                $dohoda1->Nadpis("DOHODU O ÚČASTI V PROJEKTU");
                $dohoda1->MezeraPredNadpisem(0);
                $dohoda1->ZarovnaniNadpisu("C");
                $dohoda1->VyskaPismaNadpisu(12);
            $pdf->TiskniBlok($dohoda1);

            $dohoda2 = new Projektor2_PDF_Blok;
                $dohoda2->Nadpis("„Alternativní práce v Plzeňském kraji“");
                $dohoda2->MezeraPredNadpisem(0);
                $dohoda2->ZarovnaniNadpisu("C");
                $dohoda2->VyskaPismaNadpisu(12);
            $pdf->TiskniBlok($dohoda2);
        //********************************************************
        //##################################################################################################
        $blok = new Projektor2_PDF_Blok;
            $blok->Nadpis("1. Preambule");
            $blok->Odstavec("1.1 Účelem dohody uzavírané dle zákona č. 89/2012 Sb., občanský zákoník, zákona č. 435/2004 Sb., o zaměstnanosti a souvisejících předpisů, je úprava vzájemného vztahu mezi Účastníkem a Dodavatelem při provádění aktivit projektu pro fyzické osoby účastnící se regionálního individuálního projektu implementovaného v rámci Operačního programu Lidské zdroje a zaměstnanost: Alternativní práce v Plzeňském kraji.");
            $blok->PridejOdstavec("1.2 Projekt představuje soubor aktivit a nástrojů určených pro dosažení cílů projektu. Hlavním cílem projektu „Alternativní práce v Plzeňském kraji“ je snižování nezaměstnanosti a předcházení dlouhodobé nezaměstnanosti v Plzeňském kraji. Projekt je zaměřen na udržení a obnovení profesní  motivace a získání nových dovedností a posílení profesního sebevědomí klientů, kteří potřebují pomoc na trhu práce.");
            $blok->predsazeni(6);
            $blok->odsazeniZleva(6);
        $pdf->TiskniBlok($blok);

        $blok = new Projektor2_PDF_Blok;
            $blok->Nadpis("2. Předmět dohody");
            $blok->Odstavec("2.1 Předmětem dohody je stanovení podmínek účasti Účastníka na aktivitách projektu Alternativní práce v Plzeňském kraji a úprava práv a povinností Stran dohody při realizaci těchto aktivit.");
            $blok->predsazeni(6);
            $blok->odsazeniZleva(6);
        $pdf->TiskniBlok($blok);

        $blok = new Projektor2_PDF_Blok;
            $blok->Nadpis("3. Povinnosti a práva účastníka projektu „Alternativní práce v Plzeňském kraji“");
            $blok->Odstavec("3.1 Účastník potvrzuje, že se účastnil výběrové schůzky, kde byl seznámen s prezentací projektu Alternativní práce v Plzeňském kraji. ");
            $blok->PridejOdstavec("3.2 Účastník se dále zavazuje k tomu, že v dohodnutém termínu schůzky, nejvýše do 5 dnů od podpisu této Dohody se osobně dostaví do Kontaktní kanceláře, kde poskytne své osobní údaje a údaje o svém vzdělání a předchozích zaměstnáních, kde mu bude vypracován Individuální plán. Účastník se zavazuje, že poskytne Dodavateli v maximální míře kopie dokladů osvědčujících uváděné skutečnosti, zejména doklady o ukončeném vzdělání, kurzech a předchozích zaměstnáních.");
            $blok->PridejOdstavec("3.3 Individuální plán se skládá ze dvou částí:");
            $blok->predsazeni(6);
            $blok->odsazeniZleva(6);
        $pdf->TiskniBlok($blok);

        $blok = new Projektor2_PDF_Blok;
            $blok->Odstavec("a) První část individuálního plánu obsahuje charakteristiku účastníka, která zahrnuje jeho nacionále, údaje o dosaženém vzdělání a získaných dovednostech, o předchozích pracovních zkušenostech, o zdravotním stavu a charakterových předpokladech, motivaci k práci, potřebách na doplnění vzdělání, představách o jeho dalším pracovním zařazení atd.");
            $blok->PridejOdstavec("b) Další část individuálního plánu bude dle vyhodnocení první části sestavený plán účasti v projektu, tedy doporučení aktivit, jichž by se klient měl účastnit, zaměstnavatelů, na které by se měl zaměřit při hledání práce atd.");
            $blok->PridejOdstavec("c) Individuální plán se bude na schůzkách účastníka s poradcem v Konzultačním centru průběžně aktualizovat, doplňovat anebo měnit.");
            $blok->predsazeni(3);
            $blok->odsazeniZleva(12);
        $pdf->TiskniBlok($blok);

        $blok = new Projektor2_PDF_Blok;
            $blok->Odstavec("3.4 Účastník se zavazuje informovat Příjemce o všech skutečnostech, souvisejících s jeho účastí na projektu, zejména o důvodech absence a o překážkách bránících mu v účasti na aktivitách projektu.");
            $blok->PridejOdstavec("3.5 Účastník se zavazuje k tomu, že veškeré absence na aktivitách, jichž se dle Individuálního plánu má účastnit, do 2 pracovních dnů řádně omluví, a to dokladem prokazujícím nemoc, návštěvu lékaře, ošetřování člena rodiny, případně jiným dokladem prokazujícím důvod absence.");
            $blok->PridejOdstavec("3.6 Účastník se zavazuje potvrzovat Příjemci podpisy v Prezenčních listinách nebo v Návštěvní knize svou účast (případně informace o nenastoupení) ve všech aktivitách projektu.");
            $blok->PridejOdstavec("3.7 Účastník se rovněž zavazuje:");
            $blok->predsazeni(6);
            $blok->odsazeniZleva(6);
        $pdf->TiskniBlok($blok);

        $blok = new Projektor2_PDF_Blok;
            $blok->Odstavec("a) docházet do příslušné Kontaktní kanceláře na dohodnuté schůzky a spolupracovat s koordinátory projektu v této kanceláři a s dalšími pracovníky projektu");
            $blok->PridejOdstavec("b) účastnit se doporučených aktivit uvedených v jednotlivých částech a dodatcích Individuálního plánu");
            $blok->PridejOdstavec("c) účastnit se kurzů projektu Alternativní práce v Plzeňském kraji.");
            $blok->predsazeni(3);
            $blok->odsazeniZleva(12);
        $pdf->TiskniBlok($blok);

        $blok = new Projektor2_PDF_Blok;
            $blok->Odstavec("3.8 Účastník souhlasí se svým uvedením v seznamu účastníků zařazených do rekvalifikace.");
            $blok->PridejOdstavec("3.9 Účastník, který získal zaměstnání anebo se sebezaměstnal v průběhu své účasti v projektu anebo do 2 měsíců od ukončení účasti:");
            $blok->predsazeni(6);
            $blok->odsazeniZleva(6);
        $pdf->TiskniBlok($blok);

        $blok = new Projektor2_PDF_Blok;
            $blok->Odstavec("a) zavazuje se informovat do 3 pracovních dnů Příjemce o této skutečnosti");
            $blok->PridejOdstavec("b) souhlasí se svým uvedením v seznamu osob, které získaly ve stanovené době zaměstnání anebo se sebezaměstnaly");
            $blok->PridejOdstavec("c) účastník, který získal zaměstnání, se zavazuje dodat Příjemci kopii své uzavřené pracovní smlouvy");
            $blok->PridejOdstavec("d) účastník, který se sebezaměstnal, doloží Příjemci písemné potvrzení Úřadu práce o ukončení evidence účastníka na vlastní žádost a prohlášení účastníka o podnikání kroků k zahájení podnikání, výpis nebo kopii výpisu z Živnostenského rejstříku potvrzující jeho oprávnění k podnikání.");
            $blok->predsazeni(3);
            $blok->odsazeniZleva(12);
        $pdf->TiskniBlok($blok);

        $blok = new Projektor2_PDF_Blok;
            $blok->Odstavec("3.9 Účastník se zavazuje podrobit se závěrečnému ověření získaných znalostí a dovedností v každé aktivitě, která to předpokládá.");
            $blok->predsazeni(6);
            $blok->odsazeniZleva(6);
        $pdf->TiskniBlok($blok);

        $blok = new Projektor2_PDF_Blok;
            $blok->Nadpis("4.  Ukončení účasti účastníka v projektu");
            $blok->Odstavec("4.1  K ukončení účasti účastníka v projektu Alternativní práce dojde v následujících případech:");
            $blok->predsazeni(6);
            $blok->odsazeniZleva(6);
        $pdf->TiskniBlok($blok);

        $blok = new Projektor2_PDF_Blok;
            $blok->Odstavec("4.1.1  uplynutím doby určené pro účast účastníka v projektu v případě řádného absolvování projektu účastníkem:");
            $blok->predsazeni(9);
            $blok->odsazeniZleva(6);
        $pdf->TiskniBlok($blok);
        $blok = new Projektor2_PDF_Blok;
            $blok->Odstavec("a) tato doba je obvykle 3 měsíce. ");
            $blok->PridejOdstavec("b) v případě účasti klienta v návazném rekvalifikačním kurzu (organizovaném mimo tento projekt) je tato doba 14 dní od absolvování tohoto kurzu, pokud je doba jeho účasti v projektu delší než 3 měsíce.");
            $blok->PridejOdstavec("V případě trvání aktivity Zprostředkování zaměstnání mohou tyto doby trvat až do ukončení aktivity Zprostředkování zaměstnání. Aktivita Zprostředkování zaměstnání bude ukončena Dodavatelem. Dodavatel může v tomto  případě ukončit trvání aktivity Zprostředkování zaměstnání také na výzvu vysílajícího KoP.");
            $blok->predsazeni(3);
            $blok->odsazeniZleva(15);
        $pdf->TiskniBlok($blok);
        $blok = new Projektor2_PDF_Blok;
            $blok->PridejOdstavec("4.1.2 předčasným ukončení účasti ze strany účastníka:");
            $blok->predsazeni(9);
            $blok->odsazeniZleva(6);
        $pdf->TiskniBlok($blok);
        $blok = new Projektor2_PDF_Blok;
            $blok->Odstavec("a) dnem předcházejícím nástupu účastníka do pracovního poměru či jiného pracovněprávního vztahu anebo dnem předcházejícím sebezaměstnání účastníka (zahájení podnikání)");
//            $blok->PridejOdstavec("b) výpovědí této Dohody o účasti v projektu účastníkem z jiného doloženého závažného důvodu (například: závažné zdravotní důvody doložené lékařským posudkem, přiznání invalidního důchodu 3. stupně, nástup na denní studium, nástup k výkonu trestu odnětí svobody či do vazby, změna trvalého pobytu mimo Plzeňský kraj, doložený dlouhodobý pobyt v zahraničí, doložené vážné rodinné důvody) než nástupu do zaměstnání bránícího účasti v projektu (ukončení dnem předcházejícím dni vzniku překážky účasti)");
            $blok->PridejOdstavec("b) výpovědí této Dohody o účasti v projektu účastníkem z jiného doloženého závažného důvodu (například: závažné zdravotní důvody doložené lékařským posudkem, přiznání invalidního důchodu 3. stupně, změna trvalého pobytu mimo Plzeňský kraj, doložený dlouhodobý pobyt v zahraničí, doložené vážné rodinné důvody) než nástupu do zaměstnání bránícího účasti v projektu (ukončení dnem předcházejícím dni vzniku překážky účasti)");
            $blok->predsazeni(3);
            $blok->odsazeniZleva(15);
        $pdf->TiskniBlok($blok);

        $blok = new Projektor2_PDF_Blok;
            $blok->Odstavec("4.1.3 předčasným ukončením účasti ze strany Dodavatele:");
            $blok->predsazeni(9);
            $blok->odsazeniZleva(6);
        $pdf->TiskniBlok($blok);
        $blok = new Projektor2_PDF_Blok;
            $blok->Odstavec("a) jestliže účastník porušuje podmínky účasti v projektu (viz výše), neplní své povinnosti při účasti na aktivitách projektu (zejména na vzdělávacích aktivitách) anebo jiným závažným způsobem maří účel účasti v projektu.");
            $blok->PridejOdstavec("b) ve výjimečných případech na základě podnětu vysílajícího KoP (např. při sankčním vyřazení z evidence ÚP)");
            $blok->PridejOdstavec("c) k ukončení dojde dnem předcházejícím dni vzniku důvodu ukončení");
            $blok->predsazeni(3);
            $blok->odsazeniZleva(15);
        $pdf->TiskniBlok($blok);
        
        $blok = new Projektor2_PDF_Blok;
            $blok->Odstavec("4.2 V případě, že tato Dohoda bude ze strany Dodavatele vypovězena, platí, že vypovězením této Dohody zanikají veškeré závazky Dodavatele vůči účastníkovi plynoucí z této Dohody s výjimkou závazku uhradit platby přímé podpory za dobu řádné účasti účastníka v projektu.");
            $blok->PridejOdstavec("4.3 Účastník se zavazuje, že se dostaví do Kontaktní kanceláře a podepíše doklad o ukončení účasti účastníka v projektu Alternativní práce v Plzeňském kraji, pokud nebude dohodnuto jinak. Přílohou tohoto dokladu bude například kopie pracovní smlouvy, kopie výpovědi, atd.");
//            $blok->PridejOdstavec("4.4 Po ukončení účasti účastníka v projektu Alternativní práce v Plzeňském kraji řádným způsobem anebo z důvodu nástupu do zaměstnání po absolvování alespoň 2 aktivit projektu získá účastník Osvědčení o absolvování projektu „Alternativní práce v Plzeňském kraji“.");
            // zkrácený odstavec:
            $blok->PridejOdstavec("4.4 Po ukončení účasti účastníka v projektu Alternativní práce v Plzeňském kraji řádným způsobem anebo z důvodu nástupu do zaměstnání po absolvování alespoň 2 aktivit projektu získá účastník Osvědčení o absolvování projektu.");
//            $blok->PridejOdstavec("4.5 Dodavatel založí každému účastníkovi jeho Osobní složku, do které bude zakládat, počínaje touto Dohodou o účasti v projektu a Souhlasem s poskytnutím a zpracováním osobních údajů, všechny dokumenty vztahující se k jeho účasti v projektu. Osobní složky budou uloženy po dobu trvání plnění projektu v příslušné Kontaktní kanceláři v zabezpečené kartotéce. Osobní složka každého účastníka projektu bude pro konkrétního účastníka přístupná v době dohodnuté individuální schůzky v Kontaktní kanceláři.");
            // zkrácený odstavec:
            $blok->PridejOdstavec("4.5 Dodavatel založí každému účastníkovi jeho Osobní složku, do které bude zakládat, počínaje touto Dohodou o účasti v projektu, všechny dokumenty vztahující se k jeho účasti v projektu. Osobní složka každého účastníka projektu bude pro konkrétního účastníka přístupná v době dohodnuté individuální schůzky v Kontaktní kanceláři.");
            $blok->predsazeni(6);
            $blok->odsazeniZleva(6);
        $pdf->TiskniBlok($blok);

        $blok = new Projektor2_PDF_Blok;
            $blok->Nadpis("5. Doprovodná opatření – druhy přímé podpory pro účastníky:");
//            $blok->predsazeni(6);
//            $blok->odsazeniZleva(6);
//        $pdf->TiskniBlok($blok);
//        $blok = new Projektor2_PDF_Blok;
            $blok->Odstavec("5.1. Účastníkovi mohou být při účasti na aktivitách projektu poskytovány příspěvky na náhradu některých nákladů souvisejících s účastí v projektu (tzv. přímá podpora), a to za podmínek stanovených projektem Alternativní práce v Plzeňském kraji. Jedná se o tyto příspěvky:");
            $blok->predsazeni(6);
            $blok->odsazeniZleva(6);
        $pdf->TiskniBlok($blok);
            $pdf->AddPage();   //dalsi stranky        
        $blok = new Projektor2_PDF_Blok;
            $blok->Odstavec("a) příspěvek na jízdné (hromadnou dopravou, z místa bydliště do místa konání aktivity projektu a zpět)");
            $blok->PridejOdstavec("b) příspěvek na stravné (70,- Kč na den – pouze v době účasti na aktivitě Neprofesní školení při účasti min. 5 vyučovacích hodin/den)");
            $blok->PridejOdstavec("c) příspěvek na zajištění péče o děti nebo jiné závislé osoby");
            $blok->PridejOdstavec("d) příspěvek na zabezpečení jiných výdajů souvisejících s projektem");
            $blok->PridejOdstavec("e) mzdové příspěvky na společensky účelná pracovní místa (SÚPM) a nově vytvořená pracovní místa (NVPM) vyhrazená pro klienty projektu.");
            $blok->predsazeni(3);
            $blok->odsazeniZleva(12);
        $pdf->TiskniBlok($blok);

        $blok = new Projektor2_PDF_Blok;
            $blok->Odstavec("5.2. Bližší specifikace uvedených druhů přímé podpory je stanovena Zadávací dokumentací projektu a prováděcími předpisy k realizaci projektů OP LZZ a bude průběžně upřesňována na základě pokynů realizátora projektu – Krajské pobočky ÚP ČR v Plzni.");
            $blok->predsazeni(6);
            $blok->odsazeniZleva(6);
        $pdf->TiskniBlok($blok);

        $blok = new Projektor2_PDF_Blok;
            $blok->Nadpis("6.  Povinnosti Dodavatele");
            $blok->Odstavec("6.1 Dodavatel se zavazuje poskytnout Účastníkovi zdarma aktivity projektu. Dodavatel je povinen vyvinout úsilí k tomu, aby zabezpečil účastníkovi úspěšné absolvování aktivit doporučených v Individuálním plánu.");
            $blok->PridejOdstavec("6.2 Dodavatel musí informovat účastníka o všech podmínkách účasti v aktivitách.");
            $blok->predsazeni(6);
            $blok->odsazeniZleva(6);
        $pdf->TiskniBlok($blok);

        $blok = new Projektor2_PDF_Blok;
            $blok->Nadpis("7.  Ochrana osobních údajů účastníků");
            $blok->Odstavec("7.1 Účastník souhlasí s poskytnutím a zpracováváním svých osobních údajů pro účely projektu, v souladu se zákonem č. 101/2000 Sb., zákon o ochraně osobních údajů. Tyto údaje může Dodavatel poskytnout třetí straně - potenciálnímu zaměstnavateli za účelem zprostředkování zaměstnání účastníkovi projektu. Tuto skutečnost účastník potvrzuje podpisem této Dohody.");
            $blok->predsazeni(6);
            $blok->odsazeniZleva(6);
        $pdf->TiskniBlok($blok);
            $pdf->AddPage();   //uvodni stranka

        $blok = new Projektor2_PDF_Blok;
            $blok->Nadpis("8 Závěrečná ustanovení");
            $blok->Odstavec("8.1 Tuto Dohodu lze měnit či doplňovat pouze po dohodě smluvních stran formou písemných a číslovaných dodatků.");
            $blok->PridejOdstavec("8.2 Tato Dohoda je sepsána ve čtyřech vyhotoveních s platností originálu, přičemž Účastník obdrží jedno a Dodavatel  tři vyhotovení.");
            $blok->PridejOdstavec("8.3 Tato Dohoda nabývá platnosti a účinnosti dnem jejího podpisu oběma smluvními stranami.");
            $blok->PridejOdstavec("8.4 Dodavatel i Účastník shodně prohlašují, že si tuto Dohodu před jejím podpisem přečetli, že byla uzavřena podle jejich pravé a svobodné vůle, určitě, vážně a srozumitelně, nikoliv v tísni za nápadně nevýhodných podmínek. Smluvní strany potvrzují autentičnost této Dohody svým podpisem.");
            $blok->predsazeni(6);
            $blok->odsazeniZleva(6);
        $pdf->TiskniBlok($blok);
        $pdf->Ln(5);

        //##################################################################################################
        $podpisy = new Projektor2_PDF_SadaBunek();

        $podpisy->PridejBunku("Kancelář: ", @$this->context['kancelar_plny_text'], 1);
        $podpisy->PridejBunku("Dne ", @$this->context["datum_vytvor_smlouvy"],1);
        $podpisy->NovyRadek(0,1);
        $podpisy->PridejBunku("                       Účastník:                                                                                   Dodavatel:","",1);
        $podpisy->NovyRadek(0,5);
        //  $podpisy->NovyRadek(0,3);
        $podpisy->PridejBunku("                       ......................................................                                            ......................................................","",1);
        $podpisy->PridejBunku("                        " . str_pad(str_pad($celeJmeno, 30, " ", STR_PAD_BOTH) , 92) . @$this->context['user_name'],"",1);
        //	$podpisy->PridejBunku("                           " . $celeJmeno . "                                                                         " . $User->name,"",1);

        //$podpisy->PridejBunku("                                     podpis účastníka                                                                podpis, jméno a příjmení","",1);
        $podpisy->PridejBunku("                                                                                                                                 okresní poradce projektu","");
        $pdf->TiskniSaduBunek($podpisy, 0, 1);
        
        return $pdf;
    }
}

?>
