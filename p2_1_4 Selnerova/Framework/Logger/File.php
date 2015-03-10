<?php
/**
 * Description of Projektor_Model_Auto_Autocode_Logger
 * Třída loguje tak, že zapisuje do souboru. Pro každý soubor vytváří jednu istanci objektu Projektor_Model_Auto_Autocode_Logger, je to singleton
 * pro jeden logovací soubor.
 *
 * @author pes2704
 */
class Framework_Logger_File {

    private static $instances = array();

//    private $fullLogFileName;
    private $logFileHandle;


    /**
     * Default soubor pro zápis logu
     */
    const LOG_SOUBOR = "Default.log";
    const ODSAZENI = "    ";

    /**
     * Privátní konstruktor. Objekt je vytvářen voláním factory metody getInstance().
     * @param Resource $logFileHandle
     */
    private function __construct($logFileHandle){
        if (!is_resource($logFileHandle)) {
            throw new \InvalidArgumentException('Cannot create '.__CLASS__.'. Invalid resource handle: '.print_r($logFileHandle, TRUE));
        }
        $this->logFileHandle = $logFileHandle;
    }

    final public function __clone(){}

    final public function __wakeup(){}

    /**
     * Factory metoda, metoda vrací instanci objektu třídy Projektor_Model_Auto_Autocode_Logger. 
     * Objekt Projektor_Model_Auto_Autocode_Logger je vytvářen jako singleton vždy pro jeden logovací soubor. Metoda vrací jeden unikátní 
     * objekt pro jednu kombinaci parametrů $pathPrefix a $logFileName.
     * @param string $logDirectoryPath Pokud parametr není zadán, třída loguje do složky, ve které je soubor s definicí třídy.
     * @param string $logFileName Název logovacího souboru (řetězec ve formátu jméno.přípona např. Mujlogsoubor.log). Pokud parametr není zadán,
     *  třída loguje do souboru se jménem v konstantě třídy LOG_SOUBOR.
     * @return Framework_Logger_File
     */
    public static function getInstance($logDirectoryPath=NULL, $logFileName=NULL) {
        if (!$logDirectoryPath) {
            $logDirectoryPath = __DIR__."\\Log\\"; //složka Log jako podsložka aktuálního adresáře
        }
        $logDirectoryPath = str_replace('/', '\\', $logDirectoryPath);  //obrácená lomítka
        if (substr($logDirectoryPath, -1)!=='\\') {  //pokud path nekončí znakem obrácené lomítko, přidá ho
            $logDirectoryPath .='\\';
        }
        if (!is_dir($logDirectoryPath)) {  //pokud není složka, vytvoří ji
            mkdir($logDirectoryPath);
        }
        if (!$logFileName) {
            $logFileName = self::LOG_SOUBOR;
        }
        $fullLogFileName = $logDirectoryPath.$logFileName;
        $handle = fopen($fullLogFileName, 'w+'); //vymaže obsah starého logu
        if(!isset(self::$instances[$fullLogFileName])){
            self::$instances[$fullLogFileName] = new self($handle);
        }
        return self::$instances[$fullLogFileName];
    }

    /**
     * Metoda zapíše do logovacího souboru obsah zadaného parametru (string), pokud parametr $bezOdradkovani není zadán nebo je FALSE, 
     * metoda za zapsaný string přidá znak konce řádku (PHP_EOL).
     * Pokud logovací soubor dosud nebyl otevřen (první volání metody v běhu skriptu), otevře soubor v režimu 'w', 
     * pokud soubor již existoval smaže jeho starý obsah a otevře soubor pro zápis. 
     * První volání metody v jednom běhu skriptu tedy zahájí nové logování do prázdného souboru.
     * @param string $string
     * @param int $pocetOdsazeni
     * @param boolean $bezOdradkovani Hodnota TRUE zakazuje odřádkování mezi za zapsaným záznamem do logu (další zápis bude navazovat na stejném řádku). 
     *                                Pokud parametr není zadán nebo je FALSE, metoda za zapsaný obsah přidává znak konce řádku (PHP_EOL).
     */
    public function log($string, $pocetOdsazeni=0, $bezOdradkovani=FALSE) {
        $rows = preg_split("/\r\n|\n|\r/", $string);
        foreach ($rows as $row) {
            $row .= str_repeat(self::ODSAZENI, ceil($pocetOdsazeni)).$row;
        }
        $newString = implode(PHP_EOL, $rows);
        if (!$bezOdradkovani) $newString .=PHP_EOL;
        fwrite($this->logFileHandle, $newString);
    }

    /**
     * Metoda vrací aktuální obsah logovacího souboru..
     * @return string
     */
    public function getLog() {
        $position = ftell($this->logFileHandle);
        $r = rewind($this->logFileHandle);
        $content = fread($this->logFileHandle, $position);
        return $content;
    }

    /**
     * Destruktor. Zavře logovací soubor.
     */
    public function __destruct() {
        if ($this->logFileHandle) fclose($this->logFileHandle);
    }    
}
?>
