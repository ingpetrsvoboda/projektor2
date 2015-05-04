<?php
/**
 * Description of Projektor2_Model_DocumentBase
 *
 * @author pes2704
 */
abstract class Framework_Model_FileItemAbstract {

    public $content;
    public $filePath;
    
    /**
     * 
     * @param string $filePath Absolutní cesta k souboru 
     * @param string $content
     */
    public function __construct($filePath, $content=NULL) {
        $this->filePath = $filePath;
        $this->content = $content;
    }  
}
