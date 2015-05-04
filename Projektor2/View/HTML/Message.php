<?php
/**
 * Description of Chyby
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Message extends Framework_View_Abstract {
    public function render() {
//        if (isset($this->context['message']) AND $this->context['message']) {
//            $this->parts[] = '<div class="message">';
            $this->parts[] = '<h1>'.$this->context['message'].'</h1>';
//            $this->parts[] = '</div>';
//        }
        return $this;
    }   
}

?>
