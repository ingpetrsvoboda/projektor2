<?php
/**
 * Description of Chyby
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Message extends Framework_View_Abstract {
    public function render() {
            $this->appendPart('<h1>'.$this->context['message'].'</h1>');
        return $this;
    }   
}

?>
