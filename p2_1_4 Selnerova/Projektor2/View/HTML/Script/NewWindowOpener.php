<?php
/**
 * Description of Projektor2_View_HTML_Script_NewWindowOpener
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Script_NewWindowOpener extends Framework_View_Abstract {
    public function render() {
        $this->parts[] = '<script type ="text/javascript">';
        $this->parts[] = 'FullFileName="' . $this->context['fullFileName']. '"';
        $this->parts[] = '</script>';
        return $this;
    }
}
