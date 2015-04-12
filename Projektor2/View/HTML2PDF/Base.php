<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Base
 *
 * @author pes2704
 */
abstract class Projektor2_View_HTML2PDF_Base extends Framework_View_Abstract implements Projektor2_View_PDF_ViewPdfInterface {
    const FPDF_FONTPATH = 'Projektor2/PDF/Fonts/';
//    const FILE_PATH_PREFIX = "C:/_Export Projektor/PDF/";
    const FILE_PATH_PREFIX = "./doku/";

    protected $fullFileName;
    protected $relativeDocumentFilePath;
    
    protected $pdfObject;
    protected $pdfString;
    
    /**
     * Tuto metodu musí potomci implementovat. Je volána v metodě $this->save().
     */
    abstract function createPDFObject();
        
    /**
     * Metoda ukládá vytvořené PDF do souboru.
     * @return bool TRUE pokud byl soubor s PDF vytvořen, jinak FALSE
     */
    public function save($relativeFilePath) {
        $this->relativeDocumentFilePath = $relativeFilePath;
        $this->fullFileName = $_SERVER['DOCUMENT_ROOT'].'/'.Projektor2_AppContext::getFileBaseFolder().$relativeFilePath;

        define('FPDF_FONTPATH', self::FPDF_FONTPATH);  //běhová konstanta potřebná pro fpdf
        $this->pdfObject = $this->createPDFObject();        
        if (file_exists($this->fullFileName))  	{
            unlink($this->fullFileName);
        }
        $this->pdfObject->Output($this->fullFileName, F);
            return $this->isSaved();
        }

    public function isSaved() {
        if (file_exists($this->fullFileName))  	{
            return TRUE;
        }
        return FALSE;
    }

    public function getFullFileName() {
        return $this->fullFileName;
    }
    
    public function render() {
        $this->pdfString = $this->pdfObject->Output($this->fullFileName, S);
        return $this->pdfString;
    }

    public function getNewWindowOpenerCode() {
        $code =  '<script type ="text/javascript">
                    FullFileName="' . 'http://'.$_SERVER['HTTP_HOST'].'/'.Projektor2_AppContext::getFileBaseFolder().$this->relativeDocumentFilePath. '";
                  </script>';
        return $code;
    }
}

?>
