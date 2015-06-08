<?php
/**
 * Description of Chyby
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Sjzp_IdentifikaceZajemce extends Framework_View_Html_Base {
    
    public function render() {
        $htmlResult = "";
        $htmlResult .= "
            <div id='identifikace'>
                <h2>".$this->context['titul']." ".$this->context['jmeno']." ".$this->context['prijmeni']."</h2>
                <h3>Identifikátor: ".$this->context['identifikator']."</h3>
            </div>";
        return $htmlResult;
    }
    
    public function display() {
        echo $this->render();
    }    
}

?>
