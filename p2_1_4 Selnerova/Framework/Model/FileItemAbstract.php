<?php
/**
 * Description of Projektor2_Model_DocumentBase
 *
 * @author pes2704
 */
abstract class Framework_Model_FileItemAbstract {

    public $content;
    public $documentPath;
    
    /**
     * 
     * @param type $relativeDocumentPath Umístění dokumentu ve složce documentPath zadané v konfiguraci. AppConfig. 
     * @param type $content
     * Relativní casta k dokumentu - relativní vůči složce documentPath.
     */
    public function __construct($relativeDocumentPath, $content=NULL) {
        $this->documentPath = $relativeDocumentPath;
        $this->content = $content;
    }  
}
