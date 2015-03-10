<?php
class Projektor2_View_HTML_Footer extends Framework_View_Abstract {

    public function render() {
        $this->parts[] = '<div class="footer">';
        $this->parts[] = '</div>'; 
        return $this;
    }
}

?>
