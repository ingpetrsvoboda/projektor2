<?php
/**
 * Kontajner na globalni promenne
 * @author Petr Svoboda
 */

abstract class Projektor2_AppContext
{
    
############# DATABÁZE #############    
    const DEFAULT_DB_NICK = 'projektor';
    
    /**
     * @var Framework_Database_HandlerSqlInterface 
     */
    private static $db = array();

    /**
     * Metoda vrací objekt pro přístup k databázi. Metoda se podle označení databáze (nick) zadaném jako prametr rozhoduje, 
     * který objekt pro přístup k databázi vytvoří. Ke každé databázi vytváří jednu instanci objektu.
     * @param string $nick Označení databáze používané v tomto projektu
     * @return Framework_Database_HandlerSqlInterface
     * @throws UnexpectedValueException
     */
    public static function getDb($nick = self::DEFAULT_DB_NICK)
    {
        switch ($nick) {
            case 'projektor':
                if(!isset(self::$db['projektor']) OR !isset(self::$db['projektor'])) {
//                    $dbh = new Framework_Database_HandlerSqlMysql_Radon();
                    $dbh = new Framework_Database_HandlerSqlMysql_Localhost();
                    self::$db['projektor'] = $dbh;
                }
                return self::$db['projektor'];

                break;

            default:
                throw new UnexpectedValueException('Neznámy název databáze '.$nick.'.');
        }
    }
    
    /**
     * Vrací defaulní označení (nick) databáze. Jedná se o označení používané v rámci aplikace, nikoli o skutečný název 
     * databáze v databázovém stroji.
     * @return string
     */
    public static function getDefaultDatabaseName() {
        return 'projektor';
    }
    
############# CERTIFIKÁTY #############    
    
    /**
     * Vrací pole s texty pro certifikáty
     * @param string $kod
     * @return array
     * @throws UnexpectedValueException
     */
    public static function getCertificateTexts(Projektor2_Model_SessionStatus $sessionStatus) {
        $texts = array();
        switch ($sessionStatus->projekt->kod) {
        ######## AP #################            
            case 'AP':
                $texts['signerName'] = 'Ing. Barbora Kuralová';
                $texts['signerPosition'] = 'manažer projektu';
                $texts['v_projektu'] = 'v projektu „Alternativní práce v Plzeňském kraji“';
                $texts['text_paticky'] = "Osvědčení o absolutoriu kurzu v projektu „Alternativní práce v Plzeňském kraji“ ";
                $texts['financovan'] = "\nProjekt Alternativní práce v Plzeňském kraji CZ.1.04/2.1.00/70.00055 je financován z Evropského "
                                    . "sociálního fondu prostřednictvím OP LZZ a ze státního rozpočtu ČR.";  
                break;
        ######## SJZP #################            
            case 'SJZP':
                $texts['signerName'] = $sessionStatus->user->name;
                $texts['signerPosition'] = 'poradce projektu';
                $texts['v_projektu'] = 'v projektu „S jazyky za prací v Karlovarském kraji“';
                $texts['text_paticky'] = "Osvědčení o absolutoriu kurzu v projektu „S jazyky za prací v Karlovarském kraji“ ";
                $texts['financovan'] = "\nProjekt S jazyky za prací v Karlovarském kraji CZ.1.04/2.1.01/D8.00020 je financován z Evropského "
                                    . "sociálního fondu prostřednictvím OP LZZ a ze státního rozpočtu ČR.";  
                break;                
            default:
                throw new UnexpectedValueException('Nejsou definovány texty pro certifikát v projektu '.$kod.'.');                
        }        
        return $texts;
    }
    
    /**
     * Vrací řetězec identifikátoru certifikátu. Ve formátu PR/čtyřmístné číslo roku/ctyřmístné pořadové číslo certifikátu, např: PR/2015/0012
     * @param type $rok
     * @param type $cislo
     * @return type
     */
    public static function getCertificateKurzIdentificator($rok, $cislo) {
        if (trim($rok)<="2014") {
            return $rok.'/'.$cislo;            // v roce 2014 byla první várka očíslována takto, dodržuji tedy číslování 2014
        } else {
            return sprintf("PR/%04d/%04d", $rok, $cislo);
        }
    }

    /**
     * Vrací řetězec identifikátoru certifikátu. Ve formátu PR/čtyřmístné číslo roku/ctyřmístné pořadové číslo certifikátu, např: PR/2015/0012
     * @param type $rok
     * @param type $cislo
     * @return type
     */
    public static function getCertificateProjektIdentificator($rok, $cislo) {
        return sprintf("ABS/%04d/%04d", $rok, $cislo);
    }
    
    /**
     * Maximální doba běhu skriptu použitá pro generování a export certifikátů
     * @return int
     */
    public static function getExportCertifMaxExucutionTime() {
        return 360;
    }
    
############# EXPORTY #############        
    /**
     * Vrací cestu ke kořenovému adresáři pro ukládání souborů (zejména pro file mappery). Jde vždy o cestu relativní vůči 
     * kočenové složce dokument§ serveru - DOCUMENT_ROOT
     * @param type $kod
     * @return type
     * @throws UnexpectedValueException
     */
    public static function getFileBaseFolder() {
        $fileBaseFolder = '_ExportProjektor/';        
        return $fileBaseFolder;
    }
    /**
     * Vrací cestu ke kořenovému adresáři pro ukládání souborů (zejména pro file mappery)
     * @param type $kod
     * @return type
     * @throws UnexpectedValueException
     */
    public static function getRelativeFilePath($kod=NULL) {
                switch ($kod) {
        ######## AP ###################            
            case 'AP':
                return 'AP/';
                break;
        ######## HELP #################            
            case 'HELP':
                return 'HELP/';
                break;
        ######## SJZP #################            
            case 'SJZP':
                return 'SJZP/';                
                break;
            default:
                throw new UnexpectedValueException('Není definována cesta pro dokumenty projektu '.$kod);
        }
    }

############# ZNAČKA NOVÉHO ZÁJEMCE #############    
    public function getZnacka($nove_cislo_ucastnika, $beh, $kancelar) {
        $retezec = strval($nove_cislo_ucastnika);
        $retezec = str_pad($retezec, 3, "0", STR_PAD_LEFT); // doplní zleva nulami na 3 místa
        $znacka = $beh->oznaceni_turnusu.'-'.$kancelar->kod.'-'.$retezec;        
    }
    
############# UKONČENÍ PROJEKTU #############        
    /**
     * Vrací pole pro formulář ukončení projektu
     * @param string $kod
     * @return array
     * @throws UnexpectedValueException
     */
    public static function getUkonceniProjektu($kod) {
        switch ($kod) {
        ######## AP #################            
            case 'AP':
                return array(
                    'duvod'=>array(
                        '',     //první položka prázdná - select je required
                        '1 | Řádné absolvování projektu',
                        '2a | Nástupem do pracovního poměru',
                        '2b | Výpovědí nebo jiným ukončení smlouvy ze strany účastníka',
                        '3a | Pro porušování podmínek účasti v projektu',
                        '3b | Na základě podnětu ÚP'
                        ),
                    'duvodHelp' => array(
                        '1. řádné absolvování projektu',
                        '2. předčasným ukončením účasti ze strany účastníka',
                                '&nbsp;&nbsp;a.      dnem předcházejícím nástupu účastníka do pracovního poměru (ve výjimečných případech může být dohodnuto jinak)',
                                '&nbsp;&nbsp;b.      výpovědí dohody o účasti v projektu účastníkem nebo ukončením dohody z jiného důvodu než nástupu do zaměstnání (ukončení bude dnem, kdy byla výpověď doručena zástupci dodavatele)',
                                '3. předčasným ukončením účasti ze strany dodavatele',
                                '&nbsp;&nbsp;a.       pokud účastník porušuje podmínky účasti v projektu, neplní své povinnosti při účasti na aktivitách projektu (zejména na rekvalifikaci) nebo jiným závažným způsobem maří účel účasti v projektu',
                                '&nbsp;&nbsp;b.       ve výjimečných případech na základě podnětu vysílajícího ÚP, např. při sankčním vyřazení z evidence ÚP (ukončení bude v pracovní den předcházející dni vzniku důvodu ukončení)'
                        ),
                    's_certifikatem'=>TRUE
                    );
                break;
        ######## HELP #################            
            case 'HELP':
                return array(
                    'duvod'=>array(
                        '',     //první položka prázdná - select je required
                        '1 | Řádné absolvování projektu',
                        '2a | Nástupem do pracovního poměru',
                        '2b | Výpovědí nebo jiným ukončení smlouvy ze strany účastníka',
                        '3a | Pro porušování podmínek účasti v projektu',
                        '3b | Na základě podnětu ÚP'
                        ),
                    'duvodHelp' => array(
                        '1. řádné absolvování projektu',
                        '2. předčasným ukončením účasti ze strany účastníka',
                                '&nbsp;&nbsp;a.      dnem předcházejícím nástupu účastníka do pracovního poměru (ve výjimečných případech může být dohodnuto jinak)',
                                '&nbsp;&nbsp;b.      výpovědí dohody o účasti v projektu účastníkem nebo ukončením dohody z jiného důvodu než nástupu do zaměstnání (ukončení bude dnem, kdy byla výpověď doručena zástupci dodavatele)',
                                '3. předčasným ukončením účasti ze strany dodavatele',
                                '&nbsp;&nbsp;a.       pokud účastník porušuje podmínky účasti v projektu, neplní své povinnosti při účasti na aktivitách projektu (zejména na rekvalifikaci) nebo jiným závažným způsobem maří účel účasti v projektu',
                                '&nbsp;&nbsp;b.       ve výjimečných případech na základě podnětu vysílajícího ÚP, např. při sankčním vyřazení z evidence ÚP (ukončení bude v pracovní den předcházející dni vzniku důvodu ukončení)'
                        ),
                    's_certifikatem'=>FALSE
                    );
                break;
        ######## SJZP #################            
            case 'SJZP':
                return array(
                    'duvod'=>array(
                        '',     //první položka prázdná - select je required
                        '1 | Řádné absolvování projektu',
                        '2a | Nástupem do pracovního poměru',
                        '2b | Výpovědí nebo jiným ukončení smlouvy ze strany účastníka',
                        '3a | Pro porušování podmínek účasti v projektu',
                        '3b | Na základě podnětu ÚP'
                        ),
                    'duvodHelp' => array(
                        '1. řádné absolvování projektu',
                        '2. předčasným ukončením účasti ze strany účastníka',
                                '&nbsp;&nbsp;a.      dnem předcházejícím nástupu účastníka do pracovního poměru (ve výjimečných případech může být dohodnuto jinak)',
                                '&nbsp;&nbsp;b.      výpovědí dohody o účasti v projektu účastníkem nebo ukončením dohody z jiného důvodu než nástupu do zaměstnání (ukončení bude dnem, kdy byla výpověď doručena zástupci dodavatele)',
                                '3. předčasným ukončením účasti ze strany dodavatele',
                                '&nbsp;&nbsp;a.       pokud účastník porušuje podmínky účasti v projektu, neplní své povinnosti při účasti na aktivitách projektu (zejména na rekvalifikaci) nebo jiným závažným způsobem maří účel účasti v projektu',
                                '&nbsp;&nbsp;b.       ve výjimečných případech na základě podnětu vysílajícího ÚP, např. při sankčním vyřazení z evidence ÚP (ukončení bude v pracovní den předcházející dni vzniku důvodu ukončení)'
                        ),
                    's_certifikatem'=>TRUE
                    );
                break;
            default:
                throw new UnexpectedValueException('Není definováno pole s hodnotami pro ukončení projektu '.$kod);
        }
    }
    
    public static function getAktivityProjektuTypu($kod=NULL, $typ=NULL) {
        $kurzyProjektu = array();
        foreach (self::getAktivityProjektu($kod) as $druhAktivity => $aktivita) {
            if ($aktivita['typ']==$typ) {
                $kurzyProjektu[$druhAktivity] = $aktivita;
            }
        }
        return $kurzyProjektu;
    }
    
############# AKTIVITY PROJEKTU #############        
    /**
     * Vrací pole pro formuláře IP projektu
     * @param type $kod
     * @return array
     * @throws UnexpectedValueException
     */
    public static function getAktivityProjektu($kod=NULL) {
        switch ($kod) {
        ######## AP #################            
            case 'AP':
    $aktivity = array(
            'zztp'=>array(
                'typ'=>'kurz', 
                'kurz_druh'=>'ZZTP',
                'vyberovy'=> 0,
                'nadpis'=>'Kurz základních znalostí trhu práce', 
                's_hodnocenim' => FALSE,
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                'help'=>'Příklady známek a slovního zhodnocení Kurz základních znalostí trhu práce<br> 
    1 = Účastník absolvoval kurz v plném rozsahu a se stoprocentní docházkou.<br>
    2 = Účastník úspěšně absolvoval kurz, jeho docházka byla postačující.<br>
    3 = Kurz účastník neabsolvoval v plném rozsahu, jeho účast na kurzu byla minimální.<br>'
                ), 
            'fg'=>array(
                'typ'=>'kurz', 
                'kurz_druh'=>'FG',
                'vyberovy'=> 0,
                'nadpis'=>'Kurz finanční gramotnosti', 
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                'help'=>'Příklady známek a slovního zhodnocení Kurz finanční gramotnosti<br> 
    1 = Účastník absolvoval kurz v plném rozsahu a se stoprocentní docházkou.<br>
    2 = Účastník úspěšně absolvoval kurz, jeho docházka byla postačující.<br>
    3 = Kurz účastník neabsolvoval v plném rozsahu, jeho účast na kurzu byla minimální.<br>'
                ), 
            'pc1'=>array(
                'typ'=>'kurz', 
                'kurz_druh'=>'PC',                
                'vyberovy'=> 0,
                'nadpis'=>'Kurz komunikace včetně obsluhy PC', 
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                'help'=>'Příklady známek a slovního zhodnocení Kurz komunikace včetně obsluhy PC<br>
    1 = Účastník Kurz komunikace včetně obsluhy PC absolvoval s maximální úspěšností a stoprocentní docházkou.<br> 
    3 = Účastník úspěšně absolvoval a Kurz komunikace včetně obsluhy PC.<br>
    5 = Kurz komunikace včetně obsluhy PC neabsolvoval účastník v plném rozsahu. Jeho docházka nebyla dostačující.<br>'
                ), 
            'im'=>array(
                'typ'=>'kurz', 
                'kurz_druh'=>'IM',                
                'vyberovy'=> 1,
                'nadpis'=>'Image poradna', 
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'Image poradna'
                ), 
            'spp'=>array(
                'typ'=>'kurz', 
                'kurz_druh'=>'SPP',                
                'vyberovy'=> 1,
                'nadpis'=>'Motivační setkání pro podnikavé', 
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'Motivační setkání pro podnikavé'
                ), 
            'sebas'=>array(
                'typ'=>'kurz', 
                'kurz_druh'=>'SEBAS',                
                'vyberovy'=> 1,
                'nadpis'=>'Podpora sebevědomí a asertivita', 
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'Podpora sebevědomí a asertivita'
                ), 
            'forpr'=>array(
                'typ'=>'kurz', 
                'kurz_druh'=>'FORPR',                
                'vyberovy'=> 1,
                'nadpis'=>'Moderní formy práce', 
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'Moderní formy práce'
                ),         
            'prdi'=>array(
                'typ'=>'kurz', 
                'kurz_druh'=>'PD',                
                'vyberovy'=> 1,
                'nadpis'=>'Pracovní diagnostika', 
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'Help Pracovní diagnostika'
                ), 
            'porad'=>array(
                'typ'=>'poradenstvi', 
                'vyberovy'=> 0,
                'nadpis'=>'Individuální poradenství a zprostředkování zaměstnání', 
                's_hodnocenim' => FALSE,
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení spolupráce s poradcem<br>
    1 = Klient se projektu zúčastnil úspěšně a aktivně spolupracoval s okresním koordinátorem projektu. Společně s ním se snažil najít uplatnění na trhu práce, docházel na všechny smluvené konzultace, zúčastňoval se klubových setkání. Sám aktivně vyhledával volné pracovní pozice ve svém regionu.<br>
    3 = Projektu se klient zúčastnil s ohledem na jeho možnosti (rodinné poměry, zdravotní problémy atd.) úspěšně. Vyvíjel snahu ve spolupráci s okresním koordinátorem, docházel na klubová setkání. Aktivně vyhledával za pomoci koordinátora projektu volné pracovní pozice ve svém regionu.<br>
    5 = Aktivity projektu klient absolvoval s nedostatečnou účastí. S okresním poradcem projektu spolupracoval na základě opakovaných výzev, klubových setkání se neúčastnil.<br>'
                ), 
            'klub'=>array(
                'typ'=>'poradenstvi', 
                'vyberovy'=> 1,
                'nadpis'=>'Klubová setkání', 
                's_hodnocenim' => FALSE,
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'Klubová setkání'
                ), 
            'vyhodnoceni'=>array(
                'typ'=>'poradenstvi', 
                'vyberovy'=> 0,
                'nadpis'=>'Vyhodnovení účasti při ukončení účasti', 
                's_hodnocenim' => TRUE,
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'
Vyhodnocení účasti klienta v projektu (shrnutí absolvovaných aktivit a provedených kontaktů se zaměstnavateli).<br>'
                ),
            'doporuceni'=>array(
                'typ'=>'poradenstvi', 
                'vyberovy'=> 0,
                'nadpis'=>'Doporučení vysílajícímu KoP ÚP při ukončení účasti', 
                's_hodnocenim' => TRUE,
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'
 V případě, že klient nezíská při účasti v projektu zaměstnání, doporučení vysílajícímu KoP pro další práci s klientem)<br>
 Příklady známek a slovního zhodnocení<br>
    1 = Účastník vyvíjí maximální snahu ve zdokonalování svých znalostí a dovedností a také v hledání zaměstnání. S pomocí konzultanta z Úřadu práce by měl najít vhodné zaměstnání.<br>
    2 = Účastník se zúčastnil projektu aktivně, jeho uplatnění na trhu práce je velmi pravděpodobné. S pomocí konzultanta z Úřadu práce by mohl najít vhodné zaměstnání.<br>
    3 = Účast Účastníka na aktivitách projektu byla uspokojivá, jmenovaný vyvíjel průměrné úsilí v hledání zaměstnání. Konzultantům na Úřadu práce doporučujeme, aby pokračovali ve snaze motivovat jmenovaného při uplatnění se na trhu práce.<br>
    4 = S přihlédnutím na pasivní účast účastníka v aktivitách projektu je možné konstatovat, že jmenovaný nevyvíjí optimální snahu ve zdokonalování svých znalostí a dovedností a rovněž v hledání zaměstnání. Tedy jeho uplatnění na trhu práce  podle nás závisí na podpoře a pomoci konzultantů Úřadu práce.<br>
    5 = Vzhledem ke zkušenostem z jednání a konzultací s účastníkem lze konstatovat, že jmenovaný nevyvíjí optimální snahu ve zdokonalování svých znalostí a dovedností a rovněž v hledání zaměstnání. Možnost uplatnění účastníka je tedy na trhu práce poněkud omezená, zřejmě by potřeboval intenzivní pomoc konzultantů Úřadu práce.<br>'), 
                );  

                break;
        ######## HELP #################            
            case 'HELP':

    $aktivity = array(
            'mot'=>array(
                'typ'=>'kurz', 
                'nadpis'=>'Motivační kurz', 
                'kurz_druh'=>'MOT',                
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení Motivačního programu<br> 
    1 = Účastník absolvoval kurzy Motivačního programu v plném rozsahu a se stoprocentní docházkou.<br>
    2 = Účastník úspěšně absolvoval kurzy Motivačního programu, jeho docházka byla postačující.<br>
    3 = Kurzy Motivačního programu účastník neabsolvoval v plném rozsahu, jeho účast na kurzu byla minimální.<br>'
                ), 
            'pc1'=>array(
                'typ'=>'kurz', 
                'nadpis'=>'PC kurz', 
                'kurz_druh'=>'PC',                
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení Kurzu obsluhy PC<br>
    1 = Účastník Kurz obsluhy PC absolvoval s maximální úspěšností a stoprocentní docházkou.<br> 
    3 = Účastník úspěšně absolvoval a Kurz obsluhy PC.<br>
    5 = Kurz obsluhy PC neabsolvoval účastník v plném rozsahu. Jeho docházka nebyla dostačující.<br>'
                ), 
            'prof1'=>array(
                'typ'=>'kurz', 
                'nadpis'=>'Rekvalifikační kurz 1', 
                'kurz_druh'=>'RK',                
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení Rekvalifikačního kurzu<br>
    Rekvalifikační kurzy (známku 3 a 5  je možné použít i jako doporučení pro ÚP)<br>
    1 = Účastník měl jasnou představu o dalším doplňujícím vzdělání. Rekvalifikační kurz, který si zvolil, úspěšně absolvoval, a pomohl mu najít odpovídající zaměstnání.<br>
    2 = Účastník projevoval během účasti v projektu aktivní zájem o možnosti svého dalšího vzdělávání. Vybral si proto odpovídající kurz podle svých dosavadních znalostí a vědomostí. Bohužel díky osobním problémům (nebo zdravotním komplikací nebo rodinným problémům) nemohl vybraný kurz dokončit. Bylo by zřejmě rozumné umožnit Účastníkovi absolvovat tento kurz znovu, pokud bude naplánován.<br>
    3 = Účastník si vzhledem ke svému dosavadnímu vzdělání a dosavadní činnosti vybral odpovídající kurz s cílem zaměstnání v požadovaném oboru. Bohužel nebyl tento kurz do harmonogramu kurzů zařazen. Proto doporučujeme konzultantům Úřadu práce, aby jmenovanému umožnili tento kurz, pokud bude plánován, absolvovat. Jmenovanému se zatím, přes zřejmou snahu, nepodařilo najít zaměstnání.<br>
    5 = Účastník pasivně přistupoval k výběru vhodného rekvalifikačního kurzu. Doporučení okresního koordinátora projektu ignoroval  a nejevil zájem o další vzdělávání.<br>'
                ), 
            'prof2'=>array(
                'typ'=>'kurz', 
                'nadpis'=>'Rekvalifikační kurz 2', 
                'kurz_druh'=>'RK',                
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení Rekvalifikačního kurzu<br>
    Rekvalifikační kurzy (známku 3 a 5  je možné použít i jako doporučení pro ÚP)<br>
    1 = Účastník měl jasnou představu o dalším doplňujícím vzdělání. Rekvalifikační kurz, který si zvolil, úspěšně absolvoval, a pomohl mu najít odpovídající zaměstnání.<br>
    2 = Účastník projevoval během účasti v projektu aktivní zájem o možnosti svého dalšího vzdělávání. Vybral si proto odpovídající kurz podle svých dosavadních znalostí a vědomostí. Bohužel díky osobním problémům (nebo zdravotním komplikací nebo rodinným problémům) nemohl vybraný kurz dokončit. Bylo by zřejmě rozumné umožnit Účastníkovi absolvovat tento kurz znovu, pokud bude naplánován.<br>
    3 = Účastník si vzhledem ke svému dosavadnímu vzdělání a dosavadní činnosti vybral odpovídající kurz s cílem zaměstnání v požadovaném oboru. Bohužel nebyl tento kurz do harmonogramu kurzů zařazen. Proto doporučujeme konzultantům Úřadu práce, aby jmenovanému umožnili tento kurz, pokud bude plánován, absolvovat. Jmenovanému se zatím, přes zřejmou snahu, nepodařilo najít zaměstnání.<br>
    5 = Účastník pasivně přistupoval k výběru vhodného rekvalifikačního kurzu. Doporučení okresního koordinátora projektu ignoroval  a nejevil zájem o další vzdělávání.<br>'
                ), 
            'prof3'=>array(
                'typ'=>'kurz', 
                'nadpis'=>'Rekvalifikační kurz 3', 
                'kurz_druh'=>'RK',                
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení Rekvalifikačního kurzu<br>
    Rekvalifikační kurzy (známku 3 a 5  je možné použít i jako doporučení pro ÚP)<br>
    1 = Účastník měl jasnou představu o dalším doplňujícím vzdělání. Rekvalifikační kurz, který si zvolil, úspěšně absolvoval, a pomohl mu najít odpovídající zaměstnání.<br>
    2 = Účastník projevoval během účasti v projektu aktivní zájem o možnosti svého dalšího vzdělávání. Vybral si proto odpovídající kurz podle svých dosavadních znalostí a vědomostí. Bohužel díky osobním problémům (nebo zdravotním komplikací nebo rodinným problémům) nemohl vybraný kurz dokončit. Bylo by zřejmě rozumné umožnit Účastníkovi absolvovat tento kurz znovu, pokud bude naplánován.<br>
    3 = Účastník si vzhledem ke svému dosavadnímu vzdělání a dosavadní činnosti vybral odpovídající kurz s cílem zaměstnání v požadovaném oboru. Bohužel nebyl tento kurz do harmonogramu kurzů zařazen. Proto doporučujeme konzultantům Úřadu práce, aby jmenovanému umožnili tento kurz, pokud bude plánován, absolvovat. Jmenovanému se zatím, přes zřejmou snahu, nepodařilo najít zaměstnání.<br>
    5 = Účastník pasivně přistupoval k výběru vhodného rekvalifikačního kurzu. Doporučení okresního koordinátora projektu ignoroval  a nejevil zájem o další vzdělávání.<br>'
                ), 
            'im'=>array(
                'typ'=>'kurz', 
                'nadpis'=>'Image poradna', 
                'kurz_druh'=>'IM',                
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'Help Image poradna'
                ), 
            'spp'=>array(
                'typ'=>'kurz', 
                'nadpis'=>'Setkání pro podnikavé', 
                'kurz_druh'=>'SPP',                
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'Help Setkání pro podnikavé'), 
            'prdi'=>array(
                'typ'=>'kurz', 
                'nadpis'=>'Pracovní diagnostika', 
                'kurz_druh'=>'PD',                
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'Help Pracovní diagnostika'), 
            'porad'=>array(
                'typ'=>'poradenství', 
                'nadpis'=>'Individuální poradenství a zprostředkování zaměstnání', 
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení spolupráce s poradcem<br>
    1 = Klient se projektu zúčastnil úspěšně a aktivně spolupracoval s okresním koordinátorem projektu. Společně s ním se snažil najít uplatnění na trhu práce, docházel na všechny smluvené konzultace, zúčastňoval se klubových setkání. Sám aktivně vyhledával volné pracovní pozice ve svém regionu.<br>
    3 = Projektu se klient zúčastnil s ohledem na jeho možnosti (rodinné poměry, zdravotní problémy atd.) úspěšně. Vyvíjel snahu ve spolupráci s okresním koordinátorem, docházel na klubová setkání. Aktivně vyhledával za pomoci koordinátora projektu volné pracovní pozice ve svém regionu.<br>
    5 = Aktivity projektu klient absolvoval s nedostatečnou účastí. S okresním poradcem projektu spolupracoval na základě opakovaných výzev, klubových setkání se neúčastnil.<br>'), 
            'doporuceni'=>array(
                'typ'=>'poradenství', 
                'nadpis'=>'Doporučení', 
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení<br>
    1 = Účastník vyvíjí maximální snahu ve zdokonalování svých znalostí a dovedností a také v hledání zaměstnání. S pomocí konzultanta z Úřadu práce by měl najít vhodné zaměstnání.<br>
    2 = Účastník se zúčastnil projektu aktivně, jeho uplatnění na trhu práce je velmi pravděpodobné. S pomocí konzultanta z Úřadu práce by mohl najít vhodné zaměstnání.<br>
    3 = Účast Účastníka na aktivitách projektu byla uspokojivá, jmenovaný vyvíjel průměrné úsilí v hledání zaměstnání. Konzultantům na Úřadu práce doporučujeme, aby pokračovali ve snaze motivovat jmenovaného při uplatnění se na trhu práce.<br>
    4 = S přihlédnutím na pasivní účast účastníka v aktivitách projektu je možné konstatovat, že jmenovaný nevyvíjí optimální snahu ve zdokonalování svých znalostí a dovedností a rovněž v hledání zaměstnání. Tedy jeho uplatnění na trhu práce  podle nás závisí na podpoře a pomoci konzultantů Úřadu práce.<br>
    5 = Vzhledem ke zkušenostem z jednání a konzultací s účastníkem lze konstatovat, že jmenovaný nevyvíjí optimální snahu ve zdokonalování svých znalostí a dovedností a rovněž v hledání zaměstnání. Možnost uplatnění účastníka je tedy na trhu práce poněkud omezená, zřejmě by potřeboval intenzivní pomoc konzultantů Úřadu práce.<br>'), 
            );  
                break;
            
        ######## SJZP #################            
            case 'SJZP':

    $aktivity = array(
            'mot'=>array(
                'typ'=>'kurz', 
                'nadpis'=>'Motivační kurz', 
                'kurz_druh'=>'MOT',                
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                'help'=>'Příklady známek a slovního zhodnocení Motivačního programu<br> 
    1 = Účastník absolvoval kurzy Motivačního programu v plném rozsahu a se stoprocentní docházkou.<br>
    2 = Účastník úspěšně absolvoval kurzy Motivačního programu, jeho docházka byla postačující.<br>
    3 = Kurzy Motivačního programu účastník neabsolvoval v plném rozsahu, jeho účast na kurzu byla minimální.<br>'
                ), 
            'pc1'=>array(
                'typ'=>'kurz', 
                'nadpis'=>'PC kurz', 
                'kurz_druh'=>'PC',                
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení Kurzu obsluhy PC<br>
    1 = Účastník Kurz obsluhy PC absolvoval s maximální úspěšností a stoprocentní docházkou.<br> 
    3 = Účastník úspěšně absolvoval a Kurz obsluhy PC.<br>
    5 = Kurz obsluhy PC neabsolvoval účastník v plném rozsahu. Jeho docházka nebyla dostačující.<br>'
                ),
            'prof1'=>array(
                'typ'=>'kurz', 
                'nadpis'=>'Rekvalifikační kurz 1', 
                'kurz_druh'=>'RK',                
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                'help'=>'Příklady známek a slovního zhodnocení Rekvalifikačního kurzu<br>
    Rekvalifikační kurzy (známku 3 a 5  je možné použít i jako doporučení pro ÚP)<br>
    1 = Účastník měl jasnou představu o dalším doplňujícím vzdělání. Rekvalifikační kurz, který si zvolil, úspěšně absolvoval, a pomohl mu najít odpovídající zaměstnání.<br>
    2 = Účastník projevoval během účasti v projektu aktivní zájem o možnosti svého dalšího vzdělávání. Vybral si proto odpovídající kurz podle svých dosavadních znalostí a vědomostí. Bohužel díky osobním problémům (nebo zdravotním komplikací nebo rodinným problémům) nemohl vybraný kurz dokončit. Bylo by zřejmě rozumné umožnit Účastníkovi absolvovat tento kurz znovu, pokud bude naplánován.<br>
    3 = Účastník si vzhledem ke svému dosavadnímu vzdělání a dosavadní činnosti vybral odpovídající kurz s cílem zaměstnání v požadovaném oboru. Bohužel nebyl tento kurz do harmonogramu kurzů zařazen. Proto doporučujeme konzultantům Úřadu práce, aby jmenovanému umožnili tento kurz, pokud bude plánován, absolvovat. Jmenovanému se zatím, přes zřejmou snahu, nepodařilo najít zaměstnání.<br>
    5 = Účastník pasivně přistupoval k výběru vhodného rekvalifikačního kurzu. Doporučení okresního koordinátora projektu ignoroval  a nejevil zájem o další vzdělávání.<br>'
                ),  
        // prof3 je v SJZP použit pro jazykové kurzy - v tabulce za_plan_flat_table se použijí sloupce s prefixem prof3
        // v tabulce s_kurz je použijí kurzy s typem 'JAZ'
            'prof3'=>array(
                'typ'=>'kurz', 
                'nadpis'=>'Kurz odborného jazyka', 
                'kurz_druh'=>'JAZ',                
                's_certifikatem' => TRUE,
                'tiskni_certifikat' => TRUE,
                'help'=>'Příklady známek a slovního zhodnocení jazykového kurzu<br>
    Jazykové kurzy <br>
    1 = Účastník měl jasnou představu o svém dalším odborném jazykovém vzdělání. Jazykový kurz, který si zvolil, úspěšně absolvoval, a pomohl mu najít odpovídající zaměstnání.<br>
    2 = Účastník projevoval během účasti v projektu aktivní zájem o své další odborné jazykové vzdělávání. 
    Vybral si proto odpovídající kurz podle svých dosavadních znalostí a vědomostí. Jmenovanému se zatím, přes zřejmou snahu, nepodařilo najít zaměstnání.<br>
    3 = Účastník si vzhledem ke svému dosavadnímu vzdělání a dosavadní činnosti vybral odpovídající kurz s cílem zaměstnání v požadovaném oboru. 
    Bohužel díky osobním problémům (nebo zdravotním komplikací nebo rodinným problémům) nemohl vybraný kurz dokončit.
    Jmenovanému se zatím, přes zřejmou snahu, nepodařilo najít zaměstnání.<br>
    5 = Účastník pasivně přistupoval k výběru vhodného rekvalifikačního kurzu. Doporučení okresního koordinátora projektu ignoroval  a nejevil zájem o další vzdělávání.<br>'
                ), 
//            'im'=>array(
//                'typ'=>'kurz', 
//                'nadpis'=>'Image poradna', 
//                'kurz_druh'=>'IM',                
//                's_certifikatem' => FALSE,
//                'tiskni_certifikat' => FALSE,
//                'help'=>'SJZP Image poradna'
//                ), 
//            'spp'=>array(
//                'typ'=>'kurz', 
//                'nadpis'=>'Setkání pro podnikavé', 
//                'kurz_druh'=>'SPP',                
//                's_certifikatem' => FALSE,
//                'tiskni_certifikat' => FALSE,
//                'help'=>'SJZP Setkání pro podnikavé'), 
            'prdi'=>array(
                'typ'=>'kurz', 
                'nadpis'=>'Pracovní diagnostika', 
                'kurz_druh'=>'PD',                
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'SJZP Pracovní diagnostika'), 
            'bidi'=>array(
                'typ'=>'kurz', 
                'nadpis'=>'Bilanční diagnostika', 
                'kurz_druh'=>'BD',                
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'SJZP Bilanční diagnostika'),
            'porad'=>array(
                'typ'=>'poradenství', 
                'nadpis'=>'Individuální poradenství a zprostředkování zaměstnání', 
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení spolupráce s poradcem<br>
    1 = Klient se projektu zúčastnil úspěšně a aktivně spolupracoval s okresním koordinátorem projektu. Společně s ním se snažil najít uplatnění na trhu práce, docházel na všechny smluvené konzultace, zúčastňoval se klubových setkání. Sám aktivně vyhledával volné pracovní pozice ve svém regionu.<br>
    3 = Projektu se klient zúčastnil s ohledem na jeho možnosti (rodinné poměry, zdravotní problémy atd.) úspěšně. Vyvíjel snahu ve spolupráci s okresním koordinátorem, docházel na klubová setkání. Aktivně vyhledával za pomoci koordinátora projektu volné pracovní pozice ve svém regionu.<br>
    5 = Aktivity projektu klient absolvoval s nedostatečnou účastí. S okresním poradcem projektu spolupracoval na základě opakovaných výzev, klubových setkání se neúčastnil.<br>'), 
            'doporuceni'=>array(
                'typ'=>'poradenství', 
                'nadpis'=>'Doporučení', 
                's_certifikatem' => FALSE,
                'tiskni_certifikat' => FALSE,
                'help'=>'Příklady známek a slovního zhodnocení<br>
    1 = Účastník vyvíjí maximální snahu ve zdokonalování svých znalostí a dovedností a také v hledání zaměstnání. S pomocí konzultanta z Úřadu práce by měl najít vhodné zaměstnání.<br>
    2 = Účastník se zúčastnil projektu aktivně, jeho uplatnění na trhu práce je velmi pravděpodobné. S pomocí konzultanta z Úřadu práce by mohl najít vhodné zaměstnání.<br>
    3 = Účast Účastníka na aktivitách projektu byla uspokojivá, jmenovaný vyvíjel průměrné úsilí v hledání zaměstnání. Konzultantům na Úřadu práce doporučujeme, aby pokračovali ve snaze motivovat jmenovaného při uplatnění se na trhu práce.<br>
    4 = S přihlédnutím na pasivní účast účastníka v aktivitách projektu je možné konstatovat, že jmenovaný nevyvíjí optimální snahu ve zdokonalování svých znalostí a dovedností a rovněž v hledání zaměstnání. Tedy jeho uplatnění na trhu práce  podle nás závisí na podpoře a pomoci konzultantů Úřadu práce.<br>
    5 = Vzhledem ke zkušenostem z jednání a konzultací s účastníkem lze konstatovat, že jmenovaný nevyvíjí optimální snahu ve zdokonalování svých znalostí a dovedností a rovněž v hledání zaměstnání. Možnost uplatnění účastníka je tedy na trhu práce poněkud omezená, zřejmě by potřeboval intenzivní pomoc konzultantů Úřadu práce.<br>'), 
            );  
                break;
            default:
        throw new UnexpectedValueException('Neexistuje konfigurace pro daný kód projektu: ', $kod);
        };
    return $aktivity;
    }
}