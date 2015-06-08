<?php
/**
 * Třída Projektor2_View_HTML_FormularPHP4 je fasáda pro jednotlivé View obsahující starý kód formulářů psaný stylem PHP4.
 * Tento starý kód pracuje tak, že přímo vytváří HTML výstup s použitím příkazů echo rozesetých všude v kódu. 
 *
 * @author pes2704
 */
abstract class Projektor2_View_HTML_FormularPHP4 extends Framework_View_Abstract implements Projektor2_View_Html_FormularPHP4Interface {
        
    /**
     * Metoda používá metodu potomkovských tříd display(), která obsahuje starý PHP4 kód s příkazy echo.
     * Metoda obsah vytvořený potomkovskou metodou display() vyjme z výstupního bufferu a vrací jako návratovou hodnotu.
     * @return string
     */
    public function render() {
        $oldOutputBufferContent = ob_get_clean();  //ob_get_clean() essentially executes both ob_get_contents() and ob_end_clean(). 
        ob_start();                                 // znovunastartování output bufferu
        $this->display();
        $htmlResult = ob_get_clean();
        ob_start();
        if ($oldOutputBufferContent) echo $oldOutputBufferContent;
        return $htmlResult;
    }
    
}

?>
