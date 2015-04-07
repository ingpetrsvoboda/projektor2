<?php
/**
 * Description of Projektor2_Model_DocumentBase
 *
 * @author pes2704
 */
abstract class Projektor2_Model_File_ItemAbstract extends Framework_Model_FileItemAbstract {

    public $relativeDocumentPath;
    
    /**
     * Metoda vytvoří skutečnou absolutní cetu k souboru s použitím konfigurace Orojektoru (používá metody Projektor2_AppContext)
     * a s touto absoolutní cestou pak volá obecný Framework_Model_FileItemAbstract.
     * @param type $relativeDocumentPath Umístění dokumentu ve (složka) relativně ke složce vracené metodou Projektor2_AppContext::getFileBaseFolder(). 
     * @param type $content
     * Relativní casta k dokumentu - relativní vůči složce documentRoot.
     */
    public function __construct($relativeDocumentPath, $content=NULL) {
        parent::__construct($_SERVER['DOCUMENT_ROOT'].'/'.Projektor2_AppContext::getFileBaseFolder().$relativeDocumentPath, $content);
        $this->relativeDocumentPath = $relativeDocumentPath;
    }  
}
