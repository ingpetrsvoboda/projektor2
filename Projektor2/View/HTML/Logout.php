<?php
/**
 *
 * @author pes2704
 */
class Projektor2_View_HTML_Logout extends Framework_View_Abstract {
    public function render() {
        $this->parts[] = '<form name="Logout" ID="Logout" action="index.php?akce=logout" method="post">';
        $this->parts[] = '<input type="Submit" value="Odhlásit">';
        $this->parts[] = '</form>';
        return $this;
    }
}

?>
