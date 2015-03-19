<?php
/**
 * Description of Projektor2_Model_DocumentBase
 *
 * @author pes2704
 */
abstract class Projektor2_Model_File_ItemAbstract extends Framework_Model_FileItemAbstract {

    public $content;
    public $documentPath;
    
    /**
     * 
     * @param type $relativeDocumentPath Umístění dokumentu ve složce documentPath zadané v konfiguraci. AppConfig. 
     * @param type $content
     * Relativní casta k dokumentu - relativní vůči složce documentRoot.
     */
    public function __construct($relativeDocumentPath, $content=NULL) {
        parent::__construct(Projektor2_AppContext::getDocumentRoot().$relativeDocumentPath, $content);
    }  
}
