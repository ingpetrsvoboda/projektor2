<?php
/**
 * Description of Chyby
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Multipart extends Framework_View_Abstract {
    public function render() {
        $this->parts[] = '<div>';
        if (isset($this->context['htmlParts']) AND $this->context['htmlParts']) {
            foreach ($this->context['htmlParts'] as $part) {
                $this->parts[] = $part;                
            }
        }
        $this->parts[] = '</div>';
        return $this;
    }   
}

?>
