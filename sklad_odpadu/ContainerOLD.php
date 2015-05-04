<?php
/**
 * Description of Chyby
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Container extends Framework_View_Abstract {
    public function render() {
        $this->parts[] = '<div class="container">';
            $this->parts[] = $this->context['innerHtml'];
        $this->parts[] = '</div>';
        return $this;
    }   
}

?>
