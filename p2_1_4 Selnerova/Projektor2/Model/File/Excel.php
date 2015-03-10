<?php
/**
 * Description of Excel
 *
 * @author pes2704
 */
class Projektor2_Model_File_Excel extends Framework_Model_ItemAbstract {

    public $objPHPExcel;
    public $tabulka;
    public $documentFileName;    
    
    public function __construct(PHPExcel $objPHPExcel, $tabulka, $documentFileName=NULL) {
        $this->objPHPExcel = $objPHPExcel;
        $this->tabulka = $tabulka;
        $this->documentFileName = $documentFileName;        
    }
}
