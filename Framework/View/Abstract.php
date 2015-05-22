<?php
/**
 * Description of Framework_View_Abstract
 *
 * @author pes2704
 */
abstract class Framework_View_Abstract implements Framework_View_Interface {
    
    /**
     * Unikátní název instancí objektů zděděných z této třídy
     * @var type 
     */
//    protected $viewUniqueName;
    
    /**
     * Počítadlo instancí objektů zděděných z této třídy
     */
//    static $instance = 0;   
    
//    protected $sessionStatus;


    protected $context = array();
    
    protected $parts = array();
    
    protected $isConvertedToString = FALSE;

    public function __construct(array $context=NULL) {
//    public function __construct(Projektor2_Model_SessionStatus $sessionStatus, array $context=NULL) {
//        $this->sessionStatus = $sessionStatus;
        $this->context = $context;
//        $this->viewUniqueName = get_called_class().''.++self::$instance; //název třídy s číslem instance třídy        
    }

    /**
     * Metoda přidá pole zadané jako parametr k poli context.
     * @param array $appendedContext
     */    
    public function appendContext(array $appendContext=NULL) {
        if ($this->context) {
            $this->context = array_merge($this->context, $appendContext);
        } else {
            $this->context = $appendContext;            
        }
        $this->isConvertedToString = FALSE;
        return $this;
    }
    
    /**
     * Metoda přídá jednu proměnnou do pole context
     * @param string $name
     * @param mixed $value
     * @return \Framework_View_Abstract
     */
    public function assign($name, $value=NULL){
        $this->context[$name] = $value;
        $this->isConvertedToString = FALSE;
        return $this;
    }
    
    public function appendPart($part='') {
        $this->parts[] = $part;
    }
    
    /**
     * Metoda umožňuje použít objekt view přímo jako proměnnou (prvek contextu) pro další view
     * @return string
     */
    public function __toString() {
        //varianta pro produkci - bez použití error handleru vyhazujícího výjimky
        $str =$this->toString();
        
        // varianta pro ladění - tuto variantu je třeba použít, pokud používáš error handler vyhazující výjimky (např. v bootsstrapu).
        // Problém je v tom, že php neumožňuje vyhazovat výjimky uvnitř metody __toString. Samozřejmě není možné vyloučit 
        // vyhození nějaké výjimky v metodách render(). Proto je nutné zde, uvnitř metody __toString přepnout error handler na handler 
        // nevyhazující výjimky a po renderu handler vrátit.
//        set_error_handler(array($this, 'tostring_handler'));
//        $render = $this->render();
//        $str =$this->toString();
//        restore_error_handler();      
            
        return $str;
    }

    
    public function tostring_handler($errno, $errstr, $errfile, $errline )
    {
        // Vypisuje do výstupu (echo) a tedy jsou tyto texty odeslány před odesláním <head> z response objektu. Neumí tedy česky 
        // a zkazí češtinu (všechna nastavení v head) i zbytku stránky. Řešením by bylo posílat tyto výpisy do response objektu.
        echo '<p>Chyba pri vykonavani metody __toString: '.$errstr.' in: '.$errfile.' on line: '.$errline.'.</p>'.PHP_EOL;
    }
    
    protected function toString() {
        if (!$this->parts) {
            $render = $this->render();
            if ($render instanceof Framework_View_Interface) {
                $str =  $this->convertToString($this->parts);
            } elseif (is_array($render)) {
                $str =  $this->convertToString($render);
            } elseif (is_scalar($render)) {
                $tr = $render;
            }
        } else {
            $str = $this->convertToString($this->parts);
        }
        $this->isConvertedToString = TRUE;
        return $str;
    }
    
    /**
     * Převede pole na html. Všechny prvky pole se přetypují na string. Prvky pole mohou být proměnné libovolného typu,
     * umožňující převod na string. Pro skalární proměnné se použije výchozí typecasting php, pro prvky ostatních typů musí přetypovábí zajistit uživatel.
     * Například pro typ objekt je možno použít magickou metodu __toString().
     * Takto přetypované pole se následně převede na řetězec tak, že jednotlivé prvky jsou odděleny znakem (znaky) PHP_EOL.
     * @param array $htmlArray
     * @return string
     */
    private function convertToString(array $htmlArray) {
        $string = '';
        if ($htmlArray) {
        foreach ($htmlArray as $value) {
            if ($value) {
                $html[] = (string) $value;
            }
        }
        $string =  implode(PHP_EOL, $html);
        }
        return $string;
    }    
}

