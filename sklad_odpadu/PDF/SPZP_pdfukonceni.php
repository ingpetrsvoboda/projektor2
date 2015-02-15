<?php
  	define('FPDF_FONTPATH','Projektor2/PDF/Fonts/');
  $pdfpole = $_POST;


  foreach($pdfpole  as $klic => $hodnota) {
      $pdfpole['$klic'] = trim($pdfpole['$klic']);
  }


//*
    $pdfhlavicka = Projektor2_PDFContext::getHlavicka();
		$pdfhlavicka->Odstavec("Individuální plán účastníka 3.část");
		$pdfhlavicka->zarovnani("C");
		$pdfhlavicka->vyskaPisma(14);
		$pdfhlavicka->obrazek("./PDF/loga_SPZP_vedlesebe_bw.jpg", null, null,167,14);
    $pdfpaticka = Projektor2_PDFContext::getPaticka();
		$pdfpaticka->Odstavec("S pomocí za prací - Individuální plán účastníka - 3.část  Účastník: ".$Ucastnik->identifikator);
		$pdfpaticka->zarovnani("C");
		$pdfpaticka->vyskaPisma(6);
		$pdfpaticka->cislovani = true;

    $titulek = new Projektor2_PDF_Blok;
		$titulek->Nadpis("DOKLAD O UKONČENÍ ÚČASTI V PROJEKTU");
		$titulek->ZarovnaniNadpisu("C");
                $titulek->VyskaPismaNadpisu(12);
    $titulek1 = new Projektor2_PDF_Blok;
                $titulek1->Nadpis('„S pomocí za prací v Plzeňském kraji“');
                $titulek1->ZarovnaniNadpisu("C");
                $titulek1->VyskaPismaNadpisu(12);

//		$titulek->text('„S pomocí za prací v Plzeňském kraji“');
//		$titulek->Text('Lákamí vůněhulás úmyval rohlivý jednovod lek lák hane bývá přehliv smeti. Smělý Umyslemi dopicí sudba rojskočár ří bý autný tlínům z zavěď. Umí jít A hafan bý obal stako tak úmyvatkov Buben muto. ');
		//$titulek->VyskaPismaTextu(12);
		//$titulek->ZarovnaniTextu("C");

  	$osobniUdaje = new Projektor2_PDF_SadaBunek();
		$osobniUdaje->Nadpis("Údaje o účastníkovi");
		//$osobniUdaje->vyskaPismaNadpisu(16); neumi

		$celeJmeno =  @$pole_pro_zobrazeni["titul"]." ".@$pole_pro_zobrazeni["jmeno"]." ".@$pole_pro_zobrazeni["prijmeni"];
		if (@$pole_pro_zobrazeni["titul_za"])
		{
			$celeJmeno = $celeJmeno.", ".@$pole_pro_zobrazeni["titul_za"];
		}
		$osobniUdaje->PridejBunku("Účastník: ", $celeJmeno,0,80);
		$osobniUdaje->PridejBunku("Identifikátor účastníka: ", $Ucastnik->identifikator,1);

		$adresapole="";
                if (@$pole_pro_zobrazeni["ulice"]) {
                    $adresapole .=   @$pole_pro_zobrazeni["ulice"];
                    if  (@$pole_pro_zobrazeni["mesto"])  {  $adresapole .=  ", ".   @$pole_pro_zobrazeni["mesto"];}
                    if  (@$pole_pro_zobrazeni["psc"])    {  $adresapole .= ", " . @$pole_pro_zobrazeni["psc"]; }
                }
                else {
                    if  (@$pole_pro_zobrazeni["mesto"])  {
                        $adresapole .= @$pole_pro_zobrazeni["mesto"];
                        if  (@$pole_pro_zobrazeni["psc"])    {  $adresapole .= ", " . @$pole_pro_zobrazeni["psc"]; }
                    }
                    else {
                         if  (@$pole_pro_zobrazeni["psc"])  {$adresapole .=  @$pole_pro_zobrazeni["psc"];}
                    }
                }
		$osobniUdaje->PridejBunku("Bydliště: ",$adresapole, 1);
		//$osobniUdaje->PridejBunku("Bydliště: ", @$pole_pro_zobrazeni["ulice"].", ". @$pole_pro_zobrazeni["psc"]." ". @$pole_pro_zobrazeni["mesto"], 1);

		$osobniUdaje->PridejBunku("Vysílající úřad práce: ", @$pole_pro_zobrazeni["z_up"],0,80);
		$osobniUdaje->PridejBunku("Pracoviště vysílajícího úřadu práce: ", @$pole_pro_zobrazeni["prac_up"]);
		$osobniUdaje->NovyRadek();

    $ukonceniUcasti = new Projektor2_PDF_SadaBunek();
		$ukonceniUcasti->Nadpis("Údaje o účasti v projektu");
    	$ukonceniUcasti->PridejBunku("Datum zahájení účasti v projektu: ", @$pole_pro_zobrazeni["datum_reg"]);
    	$ukonceniUcasti->PridejBunku("Datum ukončení účasti v projektu: ", @$pdfpole['datum_ukonceni'], 1);

              $duvod_ukonceni_pole =  explode ("|", $pdfpole['duvod_ukonceni']);
	$ukonceniUcasti->PridejBunku("Důvod ukončení účasti v projektu: ", $duvod_ukonceni_pole[0],1);
        if ( ($duvod_ukonceni_pole[0] == "2b ") or ($duvod_ukonceni_pole[0]== "3a ")  or ($duvod_ukonceni_pole[0] == "3b ")
	      and $pdfpole['popis_ukonceni']
	    ) {
	    $ukonceniUcasti->PridejBunku("Podrobnější popis důvodu ukončení účasti v projektu: ", " " ,1);
	    $ukonceniUcasti1 = new Projektor2_PDF_Blok;
	    $ukonceniUcasti1->Odstavec( @$pdfpole['popis_ukonceni']);
	}

    $poznKUkonceni = new Projektor2_PDF_Blok;
		$poznKUkonceni->Odstavec("Možné důvody:");
		$poznKUkonceni->VyskaPismaTextu(8);
	$poznKUkonceni1 = new Projektor2_PDF_Blok;
		$poznKUkonceni1->Odstavec("1. uplynutím doby stanovené pro účast klienta v projektu – řádné absolvování projektu");
		$poznKUkonceni1->VyskaPismaTextu(8);
	$poznKUkonceni1a = new Projektor2_PDF_Blok;
		$poznKUkonceni1a->Odstavec("a. běžně v době 3 měsíce");
		$poznKUkonceni1a->VyskaPismaTextu(8);
		$poznKUkonceni1a->OdsazeniZleva(3);
        $poznKUkonceni1a->Predsazeni(3);
	$poznKUkonceni1b = new Projektor2_PDF_Blok;
		$poznKUkonceni1b->Odstavec("b. v případě účasti klienta v profesním rekvalifikačním kurzu (tedy nikoli v kurzech Obsluha osobního počítače nebo Obsluha osobního počítače dle osnov ECDL START) nebo na praxi končí jeho účast po uplynutí 14 dní od absolvování kurzu, pokud je tato doba delší než 3 měsíce");
		$poznKUkonceni1b->VyskaPismaTextu(8);
        $poznKUkonceni1b->OdsazeniZleva(3);
        $poznKUkonceni1b->Predsazeni(3);
    $poznKUkonceni2 = new Projektor2_PDF_Blok;
		$poznKUkonceni2->Odstavec("2. předčasným ukončením účasti ze strany klienta");
		$poznKUkonceni2->VyskaPismaTextu(8);
	$poznKUkonceni2a = new Projektor2_PDF_Blok;
		$poznKUkonceni2a->Odstavec("a. dnem předcházejícím nástupu klienta do pracovního poměru (ve výjimečných případech může být dohodnuto jinak)");
		$poznKUkonceni2a->VyskaPismaTextu(8);
        $poznKUkonceni2a->OdsazeniZleva(3);
        $poznKUkonceni2a->Predsazeni(3);
    $poznKUkonceni2b = new Projektor2_PDF_Blok;
		$poznKUkonceni2b->Odstavec("b. výpovědí dohody o účasti v projektu klientem z jiného důvodu než nástupu do zaměstnání (ukončení dnem, kdy byla výpověď doručena zástupci dodavatele) ");
		$poznKUkonceni2b->VyskaPismaTextu(8);
        $poznKUkonceni2b->OdsazeniZleva(3);
        $poznKUkonceni2b->Predsazeni(3);
    $poznKUkonceni3 = new Projektor2_PDF_Blok;
		$poznKUkonceni3->Odstavec("3. předčasným ukončením účasti ze strany dodavatele");
		$poznKUkonceni3->VyskaPismaTextu(8);
	$poznKUkonceni3a = new Projektor2_PDF_Blok;
		$poznKUkonceni3a->Odstavec("a. pokud klient porušuje podmínky účasti v projektu, neplní své povinnosti při účasti na aktivitách projektu (zejména na rekvalifikaci) nebo jiným závažným způsobem maří účel účasti v projektu");
		$poznKUkonceni3a->VyskaPismaTextu(8);
        $poznKUkonceni3a->OdsazeniZleva(3);
        $poznKUkonceni3a->Predsazeni(3);
    $poznKUkonceni3b = new Projektor2_PDF_Blok;
		$poznKUkonceni3b->Odstavec("b. ve výjimečných případech na základě podnětu vysílajícího ÚP (např. při sankčním vyřazení z evidence ÚP)");
		$poznKUkonceni3b->VyskaPismaTextu(8);
        $poznKUkonceni3b->OdsazeniZleva(3);
        $poznKUkonceni3b->Predsazeni(3);

    $osvedceni = new Projektor2_PDF_SadaBunek();
		$osvedceni->Nadpis("Osvědčení o absolvování projektu S pomocí za prací");
		$osvedceni->PridejBunku("Účastníkovi bylo vydáno osvědčení dne: ", @$pdfpole['datum_certif'],1);
        $osvedceni->NovyRadek();
	$poznamkaOsvedceni = new Projektor2_PDF_Blok;
		$poznamkaOsvedceni->Odstavec("Po ukončení účasti klienta v projektu řádným způsobem nebo z důvodu nástupu do zaměstnání po absolvování alespoň 3 aktivit projektu získá účastník Osvědčení o absolvování projektu S pomocí za prací.");
	    $poznamkaOsvedceni->VyskaPismaTextu(8);
/*
 * vyhodnocení účasti klienta v projektu, shrnutí absolvovaných aktivit a provedených kontaktů se zaměstnavateli a v případě, že klient nezíská při účasti v projektu zaměstnání, také doporučení pro ÚP ohledně další práce s klientem.
*/
    $vyhodnoceni=new Projektor2_PDF_SadaBunek();
    $vyhodnoceni->Nadpis("Vyhodnocení");
    $vyhodnoceniMot = new Projektor2_PDF_Blok;
    $vyhodnoceniMot->Odstavec(@$pdfpole['mot_hodnoceni']);
    $vyhodnoceniPC1 = new Projektor2_PDF_Blok;
    $vyhodnoceniPC1->Odstavec(@$pdfpole['pc1_hodnoceni']);
    $vyhodnoceniPC2 = new Projektor2_PDF_Blok;
    $vyhodnoceniPC2->Odstavec(@$pdfpole['pc2_hodnoceni']);
    $vyhodnoceniBidi = new Projektor2_PDF_Blok;
    $vyhodnoceniBidi->Odstavec(@$pdfpole['bidi_hodnoceni']);
    $vyhodnoceniPrdi = new Projektor2_PDF_Blok;
    $vyhodnoceniPrdi->Odstavec(@$pdfpole['prdi_hodnoceni']);
    /*$vyhodnoceniPraxe = new PDF_Odstavec;
    $vyhodnoceniPraxe->Text(@$pdfpole['praxe_hodnoceni']);*/
    $vyhodnoceniProf1 = new Projektor2_PDF_Blok;
    $vyhodnoceniProf1->Odstavec(@$pdfpole['prof1_hodnoceni']);
    $vyhodnoceniProf2 = new Projektor2_PDF_Blok;
    $vyhodnoceniProf2->Odstavec(@$pdfpole['prof2_hodnoceni']);
    $vyhodnoceniProf3 = new Projektor2_PDF_Blok;
    $vyhodnoceniProf3->Odstavec(@$pdfpole['prof3_hodnoceni']);
    $vyhodnoceniPoradenstvi = new Projektor2_PDF_Blok;
    $vyhodnoceniPoradenstvi->Odstavec(@$pdfpole['porad_hodnoceni']);
    $vyhodnoceniDoporuceni = new Projektor2_PDF_Blok;
    $vyhodnoceniDoporuceni->Odstavec(@$pdfpole['doporuceni']);
    $vyhodnoceniDalsi = new Projektor2_PDF_Blok;
    $vyhodnoceniDalsi->Odstavec(@$pdfpole['vyhodnoceni']);


    $podpisy = new Projektor2_PDF_SadaBunek();
        /*$kk = @$pole_pro_zobrazeni["z_up"];
        if ( @$pole_pro_zobrazeni["z_up"] == "Klatovy")
        {
        	if (@$pole_pro_zobrazeni["prac_up"] <> "Klatovy - pracoviště Klatovy")
        	{
        		$kk = "Sušice";
        	}
        }*/
	$kk = $Kancelar->plny_text;

        $podpisy->PridejBunku("Kontaktní kancelář: ", $kk, 1);
    	$podpisy->PridejBunku("Dne ", @$pdfpole["datum_vytvor_dok"],1);
        $podpisy->NovyRadek(0,5);
    	$podpisy->PridejBunku("                       ......................................................                                            ......................................................","",1);
     	$podpisy->PridejBunku("                                        účastník                                                                                     koordinátor","");
        $podpisy->NovyRadek();




    $neniPodpis = new Projektor2_PDF_SadaBunek;
                $neniPodpis->PridejBunku("V případě, že nebylo možné získat podpis účastníka, uveďte zde důvod: ", " ",1);
    $neniPodpis1 = new Projektor2_PDF_Blok;
		$neniPodpis1->Odstavec(@$pdfpole['neni_podpis']);


    $poznamka = new Projektor2_PDF_Blok;
	$poznamka->Odstavec("V případě důvodu ukončení 2a) je přílohou tohoto dokladu kopie pracovní smlouvy, v případě 2b) kopie výpovědi podané účastníkem.");
	$poznamka->VyskaPismaTextu(7);

    $priloha = new  Projektor2_PDF_SadaBunek;                //PDF_Odstavec;
            $priloha->PridejBunku("Příloha: ", " ",1);
    $priloha1 =  new Projektor2_PDF_Blok;
	    $priloha1->Odstavec(@$pdfpole['priloha']);


  //******************************************
    $pdfdebug = Projektor2_PDFContext::getDebug();
    $pdfdebug->debug(0);

    ob_clean;
	$pdf = new Projektor2_PDF_PdfCreator ();

	$pdf->AddFont('Times','','times.php');
	$pdf->AddFont('Times','B','timesbd.php');
	$pdf->AddFont("Times","BI","timesbi.php");
	$pdf->AddFont("Times","I","timesi.php");

  	$pdf->AddPage();


        $pdf->Ln(5);
	$pdf->TiskniBlok($titulek);
        $pdf->TiskniBlok($titulek1);

    $pdf->Ln(10);
    $pdf->TiskniSaduBunek($osobniUdaje, 8, 1);

    $pdf->Ln(5);
    $pdf->TiskniSaduBunek($ukonceniUcasti,8, 1);
    $pdf->TiskniBlok($ukonceniUcasti1);
    $pdf->Ln(5);
    $pdf->TiskniBlok($poznKUkonceni);
    $pdf->TiskniBlok($poznKUkonceni1);
    $pdf->TiskniBlok($poznKUkonceni1a);
    $pdf->TiskniBlok($poznKUkonceni1b);
    $pdf->TiskniBlok($poznKUkonceni2);
    $pdf->TiskniBlok($poznKUkonceni2a);
    $pdf->TiskniBlok($poznKUkonceni2b);
    $pdf->TiskniBlok($poznKUkonceni3);
    $pdf->TiskniBlok($poznKUkonceni3a);
    $pdf->TiskniBlok($poznKUkonceni3b);
    $pdf->Ln(10);
    $pdf->TiskniSaduBunek($osvedceni, 0, 1);
    $pdf->TiskniBlok($poznamkaOsvedceni);

    $pdf->AddPage();
    $pdf->TiskniSaduBunek($vyhodnoceni, 0, 1);
    $pdf->TiskniBlok($vyhodnoceniMot);
    $pdf->TiskniBlok($vyhodnoceniPC1);
    $pdf->TiskniBlok($vyhodnoceniPC2);
    $pdf->TiskniBlok($vyhodnoceniBidi);
    $pdf->TiskniBlok($vyhodnoceniPrdi);
    /*$pdf->TiskniOdstavec($vyhodnoceniPraxe);*/
    $pdf->TiskniBlok($vyhodnoceniProf1);
    $pdf->TiskniBlok($vyhodnoceniProf2);
    $pdf->TiskniBlok($vyhodnoceniProf3);
    $pdf->TiskniBlok($vyhodnoceniPoradenstvi);
    $pdf->TiskniBlok($vyhodnoceniDoporuceni);
    $pdf->TiskniBlok($vyhodnoceniDalsi);
    $pdf->Ln(5);

    $pdf->TiskniSaduBunek($podpisy, 0, 1);

    $pdf->Ln(10);

    $pdf->TiskniSaduBunek($neniPodpis,0,1);
    $pdf->TiskniBlok($neniPodpis1,0,1);
    $pdf->Ln(10);


    if ( ($duvod_ukonceni_pole[0] == "2a ") or ($duvod_ukonceni_pole[0]== "2b ")) {
	$pdf->TiskniBlok($poznamka);
	$pdf->Ln(3);
	$pdf->TiskniSaduBunek($priloha,0,1);
        $pdf->TiskniBlok($priloha1,0,1);
    }

	//$pdf->TiskniOdstavec($neniPodpis);
	//$pdf->TiskniOdstavec($mocTecek);
	//$pdf->TiskniOdstavec($priloha);    //*/

//	$pdf->SetDisplayMode("real", "continuous");

	$filepathprefix= iconv('UTF-8', 'windows-1250', "./doku/SPZP ukonceni ");
  	if (file_exists($filepathprefix. $Ucastnik->identifikator . ".pdf"))
  	{
	    unlink($filepathprefix. $Ucastnik->identifikator . ".pdf");
  	}

  	$pdf->Output($filepathprefix. $Ucastnik->identifikator . ".pdf", F);



?>