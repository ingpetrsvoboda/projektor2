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
     * @param type $documentPath Absolutní cesta k dokumentu 
     * @param type $content
     */
    public function __construct($documentPath, $content=NULL) {
        $this->documentPath = $documentPath;
        $this->content = $content;
    }  
}
