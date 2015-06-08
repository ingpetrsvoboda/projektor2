<?php
/**
 * View_PDF třídy musí mít metody save() a getFullFileName(), neboť metoda display() v Projektor2_View_PDF_Base předpokládá užití těchto metod.
 * @author pes2704
 */
interface Projektor2_View_PDF_ViewPdfInterface extends Framework_View_Interface {
    public function save($relativeFilePath);
    public function isSaved();
    public function getFullFileName();
    public function getNewWindowOpenerCode();
}

?>
