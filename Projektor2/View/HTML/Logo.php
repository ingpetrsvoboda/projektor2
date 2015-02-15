<?php
/**
 * @author pes2704
 */
class Projektor2_View_HTML_Logo extends Framework_View_Abstract {
    public function render() {

        $path = "./img/loga/";
        $this->parts[] = '<div id="logo_projektu">';
        $this->parts[] = '<h1>'.$this->context['nadpis'].'</h1>';
        $this->parts[] = '<img src="'.$path.$this->context['src'].'" width="400" alt="'.$this->context['alt'].'">';            
        $this->parts[] = '</div>';
        
        return $this;
    }
}

?>
