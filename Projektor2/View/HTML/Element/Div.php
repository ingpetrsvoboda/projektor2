<?php
/**
 * Description of Chyby
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Element_Div extends Framework_View_Abstract {
    public function render() {
        if (isset($this->context['class'])) {
            $this->appendPart('<div class='.$this->context['class'].'>');                        
        } else {
            $this->appendPart('<div>');            
        }
        if (isset($this->context['htmlParts']) AND $this->context['htmlParts']) {
            foreach ($this->context['htmlParts'] as $part) {
                $this->appendPart($part);                
            }
        }
        $this->appendPart('</div>');
        return $this;
    }   
}

?>
