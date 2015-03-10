<?php
/**
 * Description of Projektor2_View_HTML_ExportExcel
 *
 * @author pes2704
 */
class Projektor2_View_HTML_ExportExcel extends Framework_View_Abstract {
    public function render() {
        $this->parts[] = "<p>Do souboru ".$modelExcel->documentPath." pro export dat nelze zapsat. </p>"
                        . "<p>Pravděpodobně složka neexistuje nebo je soubor otevřen v nějakém programu - používán.</p>";
        return $this;
    }
}
